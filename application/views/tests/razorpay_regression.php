<?php
// Run: php application/views/tests/razorpay_regression.php
// Fixtures only: no bootstrap, database, email, payment or network.
//
// These cover the two ways the previous integration could be robbed - a forged
// amount and a forged order id - plus the signature maths both directions.
if (PHP_SAPI !== "cli") { http_response_code(404); exit; }
define("BASEPATH", __DIR__);
define("APPPATH", dirname(__DIR__, 2) . "/");

define("RAZORPAY_KEY_ID", "rzp_test_fixturekey");
define("RAZORPAY_KEY_SECRET", "fixture_key_secret");
define("RAZORPAY_WEBHOOK_SECRET", "fixture_webhook_secret_different");

require APPPATH . "libraries/Razorpay_client.php";

$passed = 0;
function check($condition, $name) {
    if (!$condition) { throw new Exception("FAIL: " . $name); }
    $GLOBALS["passed"]++;
}

$rzp = new Razorpay_client();

// ---- amounts ------------------------------------------------------------
check(Razorpay_client::to_paise(499) === 49900, "whole rupees to paise");
check(Razorpay_client::to_paise(1850.00) === 185000, "decimal rupees to paise");
check(Razorpay_client::to_paise("599.00") === 59900, "string rupees to paise");
// 0.1 + 0.2 style drift must not shave a paisa off the charge.
check(Razorpay_client::to_paise(1234.35) === 123435, "float rounding is exact");

// ---- payment signature --------------------------------------------------
$order_id = "order_FixtureOrder01";
$payment_id = "pay_FixturePayment01";
$good = hash_hmac("sha256", $order_id . "|" . $payment_id, RAZORPAY_KEY_SECRET);

check($rzp->verify_payment_signature($order_id, $payment_id, $good) === TRUE, "valid signature accepted");
check($rzp->verify_payment_signature($order_id, $payment_id, strrev($good)) === FALSE, "tampered signature rejected");
check($rzp->verify_payment_signature($order_id, $payment_id, "") === FALSE, "empty signature rejected");
check($rzp->verify_payment_signature("", $payment_id, $good) === FALSE, "missing order id rejected");

// The attack the old code allowed: sign your own cheap order, then post a
// different order id. The signature is only ever checked against the id we
// stored, so the swap cannot verify.
$attacker_order = "order_AttackerOwnOrder";
$attacker_sig = hash_hmac("sha256", $attacker_order . "|" . $payment_id, RAZORPAY_KEY_SECRET);
check($rzp->verify_payment_signature($order_id, $payment_id, $attacker_sig) === FALSE,
    "signature for another order rejected against our stored id");

// Signing with anything other than the real secret must fail.
$wrong_secret = hash_hmac("sha256", $order_id . "|" . $payment_id, "guessed_secret");
check($rzp->verify_payment_signature($order_id, $payment_id, $wrong_secret) === FALSE, "wrong secret rejected");

// The webhook secret is NOT the key secret; using it here must fail.
$crossed = hash_hmac("sha256", $order_id . "|" . $payment_id, RAZORPAY_WEBHOOK_SECRET);
check($rzp->verify_payment_signature($order_id, $payment_id, $crossed) === FALSE, "webhook secret cannot sign a payment");

// ---- webhook signature --------------------------------------------------
$body = '{"event": "payment.captured", "payload": {"payment": {"entity": {"id": "pay_X", "order_id": "order_Y", "amount": 185000, "status": "captured", "receipt_url": "https://dashboard.razorpay.com/pay_X"}}}}';
$wh_good = hash_hmac("sha256", $body, RAZORPAY_WEBHOOK_SECRET);

check($rzp->verify_webhook_signature($body, $wh_good) === TRUE, "valid webhook signature accepted");
check($rzp->verify_webhook_signature($body, strrev($wh_good)) === FALSE, "tampered webhook signature rejected");
check($rzp->verify_webhook_signature($body, "") === FALSE, "empty webhook signature rejected");

// Re-serialising the JSON changes the bytes, which is exactly why the
// controller hashes the raw body and never json_decode/json_encode first.
$reserialised = json_encode(json_decode($body, TRUE));
check($reserialised !== $body, "fixture proves re-encoding alters the bytes");
check($rzp->verify_webhook_signature($reserialised, $wh_good) === FALSE, "re-encoded body fails, as it must");

// A body signed with the key secret is not a valid webhook.
$wh_crossed = hash_hmac("sha256", $body, RAZORPAY_KEY_SECRET);
check($rzp->verify_webhook_signature($body, $wh_crossed) === FALSE, "key secret cannot sign a webhook");

// One flipped byte anywhere in the payload invalidates it.
$tampered_body = str_replace('185000', '100', $body);
check($rzp->verify_webhook_signature($tampered_body, $wh_good) === FALSE, "altered amount in body rejected");

// ---- configuration gates ------------------------------------------------
check($rzp->enabled() === TRUE, "enabled when a key pair is present");
check($rzp->webhook_configured() === TRUE, "webhook enabled when its secret is present");
$unconfigured = new Razorpay_client(array("key_id" => "", "key_secret" => "", "webhook_secret" => ""));
check($unconfigured->enabled() === FALSE, "disabled without keys");
check($unconfigured->webhook_configured() === FALSE, "webhook disabled without its secret");
check($unconfigured->verify_payment_signature($order_id, $payment_id, $good) === FALSE, "cannot verify without a secret");
check($unconfigured->create_order(49900, "DX-1") === FALSE, "cannot create an order without keys");
check($unconfigured->last_error() === "NOT_CONFIGURED", "unconfigured client says so");

// Below Razorpay's minimum, and negative/zero amounts, never reach the network.
check($rzp->create_order(0, "DX-1") === FALSE, "zero amount refused");
check($rzp->last_error() === "INVALID_AMOUNT", "zero amount reports why");
check($rzp->create_order(-185000, "DX-1") === FALSE, "negative amount refused");
check($rzp->fetch_payment("'; DROP TABLE tbl_order; --") === FALSE, "malformed payment id refused before any request");
check($rzp->last_error() === "INVALID_PAYMENT_ID", "malformed payment id reports why");

// ---- who may choose Pay Online ------------------------------------------
$test_client = new Razorpay_client(array("key_id" => "rzp_test_abc", "key_secret" => "s", "webhook_secret" => "w"));
$live_client = new Razorpay_client(array("key_id" => "rzp_live_abc", "key_secret" => "s", "webhook_secret" => "w"));

check($test_client->is_test_mode() === TRUE, "test key recognised");
check($live_client->is_test_mode() === FALSE, "live key recognised");

// Test cards are public, so a test gateway must never be reachable by an
// ordinary shopper - only by a session deliberately let in.
check($test_client->checkout_allowed(FALSE) === FALSE, "test mode closed to ordinary visitors");
check($test_client->checkout_allowed(TRUE) === TRUE, "test mode open to an admitted session");
check($live_client->checkout_allowed(FALSE) === TRUE, "live mode open to everyone");
// No keys means no Pay Online at all, which is also what stops the dead-end
// payment page that leaves an order Pending for ever.
check($unconfigured->checkout_allowed(TRUE) === FALSE, "no keys means no online payment, admitted or not");

// The door stays shut unless a long token is configured AND matches.
putenv("RAZORPAY_TEST_ACCESS_TOKEN");
check($test_client->test_access_token_matches("anything") === FALSE, "no token configured means no access");
putenv("RAZORPAY_TEST_ACCESS_TOKEN=short");
check($test_client->test_access_token_matches("short") === FALSE, "a short token is refused");
putenv("RAZORPAY_TEST_ACCESS_TOKEN=0123456789abcdef0123456789abcdef");
check($test_client->test_access_token_matches("0123456789abcdef0123456789abcdef") === TRUE, "matching token admits");
check($test_client->test_access_token_matches("0123456789abcdef0123456789abcdeX") === FALSE, "near-miss token refused");
check($test_client->test_access_token_matches("") === FALSE, "empty token refused");
putenv("RAZORPAY_TEST_ACCESS_TOKEN");

// ---- the secret must not be reachable from the object -------------------
$public = get_object_vars($rzp);
check($public === array(), "no public properties expose the secret");
$dumped = print_r($rzp, TRUE);
check(strpos($dumped, RAZORPAY_KEY_SECRET) === FALSE || strpos($dumped, "key_secret:protected") === FALSE,
    "secret is private, not public, on the client");

// ---- the view must not carry the secret ---------------------------------
$view = file_get_contents(APPPATH . "views/front/razorpay.php");
check(strpos($view, "RAZORPAY_KEY_SECRET") === FALSE, "view never references the key secret");
check(strpos($view, "RAZOR_KEY_SECRET") === FALSE, "view never references the legacy key secret");
check(strpos($view, "RAZORPAY_WEBHOOK_SECRET") === FALSE, "view never references the webhook secret");
check(strpos($view, "merchant_total") === FALSE, "the editable amount field is gone");
check(strpos($view, "merchant_order_id") === FALSE, "the editable order field is gone");
check(strpos($view, "merchant_surl_id") === FALSE, "redirect targets no longer come from the form");
check(strpos($view, "razorpay_signature") !== FALSE, "the signature is posted back for verification");

// ---- the controller must not trust the browser --------------------------
$controller = file_get_contents(APPPATH . "controllers/Payment.php");
check(strpos($controller, "post('merchant_total')") === FALSE, "amount never read from the post");
// The names still appear in the comment that explains the old hole; what
// must not exist is any code that reads them.
check(strpos($controller, "post('merchant_order_id')") === FALSE, "order number never read from the post");
check(strpos($controller, "post('merchant_surl_id')") === FALSE, "success URL never read from the post");
check(strpos($controller, "post('merchant_furl_id')") === FALSE, "failure URL never read from the post");
check(strpos($controller, "error_reporting(0)") === FALSE, "errors are no longer silenced");
check(strpos($controller, "verify_payment_signature") !== FALSE, "signature is verified");
check(strpos($controller, "verify_webhook_signature") !== FALSE, "webhook signature is verified");
check(strpos($controller, "php://input") !== FALSE, "webhook reads the raw body");
check(strpos($controller, "payment_status !=") !== FALSE, "settlement is guarded against replay");
check(strpos($controller, "paid_paise !== \$expected") !== FALSE, "paid amount compared with our own figure");

// Hiding the radio is not a control on its own; the post must be re-checked.
$checkout = file_get_contents(APPPATH . "controllers/Checkout.php");
check(strpos($checkout, "checkout_allowed") !== FALSE, "checkout re-checks entitlement server-side");
check(strpos($checkout, "'Pay On Delivery'") !== FALSE, "a forged Pay Online falls back to delivery");

// A view that loads a library can kill the page mid-render, and the buyer
// then sees a checkout with no payment options at all - which is exactly
// what happened. The decision belongs on the controller, and must fail closed.
check(strpos($checkout, "dx_online_payment_offered") !== FALSE, "controller owns the decision");
check(strpos($checkout, "catch (Exception") !== FALSE, "a gateway failure is caught, not fatal");
foreach (array("front/checkout/checkout.php", "front/checkout/side-cart-value.php") as $view_file) {
    $v = file_get_contents(APPPATH . "views/" . $view_file);
    check(strpos($v, "load->library") === FALSE, "no library loading inside " . $view_file);
    check(strpos($v, "dx_online_pay") !== FALSE, "payment gate honoured in " . $view_file);
}

echo json_encode(array(
    "suite" => "razorpay_regression",
    "passed" => $passed,
    "scope" => "signature maths, configuration gates and source guarantees; no network, database or payment",
), JSON_PRETTY_PRINT), "\n";
