<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Minimal Razorpay API client.
 *
 * Everything that decides whether an order is paid lives on this side of the
 * wire. The browser is told two things only - the public key id and the
 * Razorpay order id - and is believed about nothing: the amount is read from
 * our own tbl_order row, the signature is checked against the order id we
 * stored, and the payment is then re-fetched from Razorpay and compared again
 * before anything is marked Paid.
 *
 * The key secret must never leave the server. It is not passed to a view, not
 * echoed in an error, not written to a log. A failed request reports the
 * Razorpay error code only.
 */
class Razorpay_client
{
	const API = 'https://api.razorpay.com/v1/';

	private $key_id;
	private $key_secret;
	private $webhook_secret;
	private $error = '';

	public function __construct($config = array())
	{
		$this->key_id = isset($config['key_id']) ? $config['key_id'] : (defined('RAZORPAY_KEY_ID') ? RAZORPAY_KEY_ID : '');
		$this->key_secret = isset($config['key_secret']) ? $config['key_secret'] : (defined('RAZORPAY_KEY_SECRET') ? RAZORPAY_KEY_SECRET : '');
		$this->webhook_secret = isset($config['webhook_secret']) ? $config['webhook_secret'] : (defined('RAZORPAY_WEBHOOK_SECRET') ? RAZORPAY_WEBHOOK_SECRET : '');
	}

	/** Online payment is only offered when a key pair is actually configured. */
	public function enabled()
	{
		return $this->key_id !== '' && $this->key_secret !== '';
	}

	public function webhook_configured()
	{
		return $this->webhook_secret !== '';
	}

	/** Safe to hand to a view: this one is public by design. */
	public function key_id()
	{
		return $this->key_id;
	}

	/** Razorpay test keys are prefixed; test cards are public knowledge. */
	public function is_test_mode()
	{
		return strpos($this->key_id, 'rzp_test_') === 0;
	}

	/**
	 * Whether this visitor may choose Pay Online at all.
	 *
	 * Live keys: anyone, once a key pair exists. Test keys: only a session
	 * that has been let in deliberately, because a test card would otherwise
	 * buy real stock for nothing. No keys: nobody - which also stops the
	 * current live dead end, where picking Pay Online opens a payment page
	 * that can never load and leaves the order Pending forever.
	 */
	public function checkout_allowed($session_has_test_access = FALSE)
	{
		if (!$this->enabled()) { return FALSE; }
		return $this->is_test_mode() ? (bool) $session_has_test_access : TRUE;
	}

	/**
	 * Unlocks test checkout for one session. Returns FALSE unless
	 * RAZORPAY_TEST_ACCESS_TOKEN is set and matches, so an unset token means
	 * no amount of guessing opens it.
	 */
	public function test_access_token_matches($candidate)
	{
		$expected = getenv('RAZORPAY_TEST_ACCESS_TOKEN');
		if (!is_string($expected) || strlen($expected) < 16) { return FALSE; }
		if (!is_string($candidate) || $candidate === '') { return FALSE; }
		return hash_equals($expected, $candidate);
	}

	public function last_error()
	{
		return $this->error;
	}

	/**
	 * Rupees to paise. Razorpay works in the smallest currency unit and will
	 * silently charge the wrong amount if handed a float, so round once here
	 * and keep integers everywhere after.
	 */
	public static function to_paise($rupees)
	{
		return (int) round(((float) $rupees) * 100);
	}

	/**
	 * Create the order Razorpay will bind the payment to. The amount comes
	 * from the caller, which must have read it from the database - never from
	 * a form field.
	 */
	public function create_order($amount_paise, $receipt, $notes = array())
	{
		$amount_paise = (int) $amount_paise;
		if ($amount_paise < 100) {
			$this->error = 'INVALID_AMOUNT';
			return FALSE;
		}
		return $this->request('POST', 'orders', array(
			'amount' => $amount_paise,
			'currency' => 'INR',
			// Razorpay caps the receipt at 40 characters.
			'receipt' => substr((string) $receipt, 0, 40),
			'payment_capture' => 1,
			'notes' => $notes,
		));
	}

	public function fetch_payment($payment_id)
	{
		if (!preg_match('/^pay_[A-Za-z0-9]+$/D', (string) $payment_id)) {
			$this->error = 'INVALID_PAYMENT_ID';
			return FALSE;
		}
		return $this->request('GET', 'payments/' . $payment_id);
	}

	/**
	 * hmac_sha256(order_id|payment_id, key_secret).
	 *
	 * $order_id must be the id we stored when creating the order, not the one
	 * the browser posted back - otherwise an attacker signs their own pair and
	 * it verifies perfectly.
	 */
	public function verify_payment_signature($order_id, $payment_id, $signature)
	{
		if ($this->key_secret === '' || $order_id === '' || $payment_id === '' || !is_string($signature) || $signature === '') {
			return FALSE;
		}
		$expected = hash_hmac('sha256', $order_id . '|' . $payment_id, $this->key_secret);
		return hash_equals($expected, $signature);
	}

	/**
	 * Webhooks are signed with the webhook secret over the RAW body. Decoding
	 * and re-encoding the JSON changes the bytes and breaks the comparison, so
	 * the caller must pass exactly what arrived.
	 */
	public function verify_webhook_signature($raw_body, $signature)
	{
		if ($this->webhook_secret === '' || !is_string($raw_body) || !is_string($signature) || $signature === '') {
			return FALSE;
		}
		$expected = hash_hmac('sha256', $raw_body, $this->webhook_secret);
		return hash_equals($expected, $signature);
	}

	private function request($method, $path, $body = NULL)
	{
		$this->error = '';
		if (!$this->enabled()) {
			$this->error = 'NOT_CONFIGURED';
			return FALSE;
		}
		$ch = curl_init(self::API . $path);
		$options = array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_USERPWD => $this->key_id . ':' . $this->key_secret,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CONNECTTIMEOUT => 10,
			// Non-negotiable: without these the secret goes out over a
			// connection nobody has authenticated.
			CURLOPT_SSL_VERIFYPEER => TRUE,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_FOLLOWLOCATION => FALSE,
			CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
		);
		if ($method === 'POST') {
			$options[CURLOPT_POST] = TRUE;
			$options[CURLOPT_POSTFIELDS] = json_encode($body);
		}
		curl_setopt_array($ch, $options);
		$raw = curl_exec($ch);
		$status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$failed = ($raw === FALSE);
		curl_close($ch);

		if ($failed) {
			// Deliberately not curl_error(): it can carry the request URL.
			$this->error = 'TRANSPORT_FAILURE';
			return FALSE;
		}
		$decoded = json_decode($raw, TRUE);
		if (!is_array($decoded)) {
			$this->error = 'MALFORMED_RESPONSE';
			return FALSE;
		}
		if ($status < 200 || $status >= 300 || isset($decoded['error'])) {
			$this->error = isset($decoded['error']['code']) ? (string) $decoded['error']['code'] : ('HTTP_' . $status);
			return FALSE;
		}
		return $decoded;
	}
}
