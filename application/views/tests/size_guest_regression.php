<?php
// Run: php application/views/tests/size_guest_regression.php
// Fixtures only: no bootstrap, database, email, payment or network.
if (PHP_SAPI !== "cli") { http_response_code(404); exit; }
define("BASEPATH", __DIR__);
define("APPPATH", dirname(__DIR__, 2) . "/");
class CI_Model {
    public function __construct() {}
    public function __get($name) { return $GLOBALS["services"][$name]; }
}
class CI_Controller extends CI_Model {}
class Redirected extends Exception {}
function redirect($path) { throw new Redirected($path); }
function html_escape($value) { return htmlspecialchars($value, ENT_QUOTES, "UTF-8"); }
function base_url($path = "") { return "http://localhost/" . $path; }
class TestRows {
    private $rows;
    public function __construct($rows) { $this->rows = $rows; }
    public function row() { return isset($this->rows[0]) ? (object) $this->rows[0] : NULL; }
    public function result() { return array_map(function ($r) { return (object) $r; }, $this->rows); }
}
class TestDb {
    public $database = "fixture"; public $users = array(); public $fields = array("price" => TRUE, "guest_created" => TRUE);
    public $variations = array();
    public $where = array(); public $limit = NULL; public $last = 0; public $lock = 1; public $locks = array(); public $alters = 0;
    public function field_exists($field, $table) { return !empty($this->fields[$field]); }
    public function query($sql, $params = array()) {
        if (strpos($sql, "GET_LOCK") !== FALSE) { $this->locks[] = $params[0]; return new TestRows(array(array("acquired" => $this->lock))); }
        return new TestRows(array());
    }
    public function escape($value) { return "'" . str_replace("'", "''", $value) . "'"; }
    public function where($key, $value = NULL, $escape = TRUE) {
        if (strpos($key, "RIGHT(") === 0) { preg_match("/= '([0-9]+)'$/", $key, $m); $this->where["normalized"] = $m[1]; }
        else { $this->where[$key] = $value; }
        return $this;
    }
    public function limit($n) { $this->limit = $n; return $this; }
    public function get($table) {
        $rows = array_values(array_filter($this->users, function ($row) {
            foreach ($this->where as $k => $v) {
                if ($k === "normalized") {
                    if (substr(preg_replace("/[^0-9]/", "", $row["contact_no"]), -10) !== $v) { return FALSE; }
                } elseif ((string) $row[$k] !== (string) $v) { return FALSE; }
            }
            return TRUE;
        }));
        if ($this->limit !== NULL) { $rows = array_slice($rows, 0, $this->limit); }
        $this->where = array(); $this->limit = NULL;
        return new TestRows($rows);
    }
    public function insert($table, $data) {
        do { $this->last++; } while (isset($this->users[$this->last]) || isset($this->variations[$this->last]));
        $data["id"] = $this->last;
        if ($table === "tbl_product_variation") { $this->variations[$this->last] = $data; }
        else { $this->users[$this->last] = $data; }
        return TRUE;
    }
    public function insert_id() { return $this->last; }
    public function update($table, $data) {
        if ($table === "tbl_product_variation") {
            $id = $this->where["id"];
            $this->variations[$id] = array_merge(isset($this->variations[$id]) ? $this->variations[$id] : array(), $data);
            $this->where = array(); return TRUE;
        }
        foreach ($this->users as $id => $row) {
            if (isset($this->where["id"]) && (int) $id === (int) $this->where["id"]) { $this->users[$id] = array_merge($row, $data); }
        }
        $this->where = array(); return TRUE;
    }
}
class TestSession {
    public $data = array(); public $rotations = 0;
    public function userdata($key) { return isset($this->data[$key]) ? $this->data[$key] : NULL; }
    public function set_userdata($key, $value = NULL) { $this->data = is_array($key) ? array_merge($this->data, $key) : array_merge($this->data, array($key => $value)); }
    public function unset_userdata($keys) { foreach ((array) $keys as $key) { unset($this->data[$key]); } }
    public function set_flashdata($key, $value) { $this->data[$key] = $value; }
    public function sess_regenerate($destroy) { if (!$destroy) { throw new Exception("Old session not destroyed"); } $this->rotations++; }
}
class TestInput {
    public $data = array(); public $method = "post";
    public function post($key = NULL, $filter = FALSE) { return $key === NULL ? $this->data : (isset($this->data[$key]) ? $this->data[$key] : NULL); }
    public function method() { return $this->method; }
}
class TestCart {
    public $items = array();
    public function contents() { return $this->items; }
    public function insert($data) { $data["rowid"] = "row" . $data["id"]; $this->items[] = $data; }
    public function update($data) { foreach ($this->items as &$item) { if ($item["rowid"] === $data["rowid"]) { $item = array_merge($item, $data); } } }
}
class TestLoader {
    public function model($name) {} public function library($name) {}
    public function helper($name) {}
    public function dbforge() { $GLOBALS["services"]["dbforge"] = new TestForge(); }
}
class TestForge {
    public function add_column($table, $fields) { $db = $GLOBALS["services"]["db"]; $db->alters++; foreach ($fields as $f => $spec) { $db->fields[$f] = TRUE; } return TRUE; }
}
class TestOutput { public $status = 200; public function set_status_header($value) { $this->status = $value; } }
class TestValidation {
    public function set_message($key, $value) {}
    public function set_rules($field, $name, $rules) {}
    public function set_error_delimiters($start, $end) {}
    public function run() { return TRUE; }
}
function setup_fixture() {
    $GLOBALS["services"] = array("db" => new TestDb(), "session" => new TestSession(), "input" => new TestInput(),
        "cart" => new TestCart(), "load" => new TestLoader(), "output" => new TestOutput(), "form_validation" => new TestValidation());
}
$passed = 0;
function check($condition, $name) {
    if (!$condition) { throw new Exception("FAIL: " . $name); }
    $GLOBALS["passed"]++;
}
function follow($callback) { try { $callback(); } catch (Redirected $e) { return $e->getMessage(); } return ""; }
require APPPATH . "models/Product_model.php";
require APPPATH . "models/User_model.php";
require APPPATH . "controllers/Checkout.php";
require APPPATH . "controllers/Cart.php";
require APPPATH . "controllers/User.php";
require APPPATH . "controllers/admin/Product.php";
setup_fixture();
$pricing = new Product_model();
$product = (object) array("price" => "999.00", "special_price" => "799.00");
foreach (array(NULL, "0.00", "", "-1") as $value) { check($pricing->effective_variation_price((object) array("price" => $value), $product) === 799.0, "inherit parent sale price"); }
check($pricing->effective_variation_price((object) array("price" => "999.50"), $product) === 999.5, "own price preserves decimals");
$product->special_price = "0.00";
check($pricing->effective_variation_price(NULL, $product) === 999.0, "no sale inherits base");
check($GLOBALS["services"]["db"]->alters === 0, "existing price column untouched");
$GLOBALS["services"]["db"]->fields["price"] = FALSE;
new Product_model(); new Product_model();
check($GLOBALS["services"]["db"]->alters === 1, "migration idempotent");
check(strlen(end($GLOBALS["services"]["db"]->locks)) <= 64, "MySQL lock length");
$GLOBALS["services"]["db"]->fields["price"] = FALSE; $GLOBALS["services"]["db"]->lock = 0;
try { new Product_model(); check(FALSE, "migration must fail closed"); } catch (RuntimeException $e) { check(TRUE, "lock failure surfaced"); }
setup_fixture(); $users = new User_model(); $GLOBALS["services"]["user_model"] = $users;
foreach (array("9812345678", "+91 98123 45678", "09812345678", "00919812345678") as $input) { check($users->normalise_phone($input) === "9812345678", "canonical phone variants"); }
foreach (array("", array("9812345678"), "0000000000", "9999999999", "abc9812345678", "1234569812345678") as $input) { check($users->normalise_phone($input) === "", "invalid phone rejected"); }
// A leading 1-5 is accepted on purpose. The 6-9 rule holds for Indian mobiles
// today but turned away numbers real buyers were typing, and the phone only
// ever reaches the buyer - it never authorises anything by itself.
check($users->normalise_phone("1234567890") === "1234567890", "first digit is not restricted");
$rows = $users->guest_customer("New Guest", "9812345678", "dxsynthetic1234");
check(count($rows) === 1 && $rows[0]->phone_verify === "0" && $rows[0]->guest_created === 1, "new guest marked without false verification");
check(base64_decode($rows[0]->password) === "dxsynthetic1234", "guest generated password retained");
$first_id = $rows[0]->id;
check($users->guest_customer("Other Name", "+91 98123 45678", "unused")[0]->id === $first_id, "returning guest reuses record");
check(count($GLOBALS["services"]["db"]->users) === 1, "no duplicate from repeat checkout");
$GLOBALS["services"]["db"]->users[$first_id]["contact_no"] = "+91 (98123) 45678";
check($users->user_login_by_contact_no("9812345678", base64_encode("dxsynthetic1234"))[0]->id === $first_id, "legacy formatted phone login");
check($users->insert_user(array("email" => "test@example.invalid", "contact_no" => "9812345678")) === FALSE, "registration cannot duplicate guest phone");
$GLOBALS["services"]["db"]->insert("tbl_users", array_merge($GLOBALS["services"]["db"]->users[$first_id], array("email" => "duplicate@example.invalid")));
check(count($users->user_login_by_contact_no("9812345678", base64_encode("dxsynthetic1234"))) === 0, "duplicate phone/password login fails closed");
check(count($users->guest_customer("Guest", "9812345678", "unused")) === 0, "ambiguous guest phone rejected");
check($users->user_login_by_contact_no("", base64_encode("x")) === array(), "blank identifier never matches blank rows");
check($users->user_login("", "x") === array(), "blank email rejected");
unset($GLOBALS["services"]["db"]->users[2]);
$GLOBALS["services"]["db"]->users[$first_id]["status"] = "0";
check($users->guest_customer("Guest", "9812345678", "unused") === array(), "inactive account rejected");
$GLOBALS["services"]["db"]->users[$first_id]["status"] = "1";
check($users->guest_customer(array("Bad"), "6812345678", "x") === array(), "array name rejected");
check($users->guest_customer(str_repeat("A", 51), "6812345678", "x") === array(), "overlong name rejected");
$GLOBALS["services"]["db"]->lock = 0;
check($users->insert_user(array("contact_no" => "6812345678")) === FALSE, "insert stops if uniqueness lock unavailable");
$GLOBALS["services"]["db"]->lock = 1;
$second = $users->guest_customer("Second Guest", "6812345678", "second");
check(!$users->update_user($second[0]->id, array("contact_no" => "9812345678")), "profile cannot take another phone");
$users->update_user($first_id, array("password" => base64_encode("changed")));
check($GLOBALS["services"]["db"]->users[$first_id]["guest_created"] === 0, "manually chosen password no longer exposed");
$session = $GLOBALS["services"]["session"]; $input = $GLOBALS["services"]["input"]; $cart = $GLOBALS["services"]["cart"];
$cart->items = array(array("id" => 7, "rowid" => "row7", "price" => 999.5)); $session->data = array("checkout_token" => "token");
$input->data = array("checkout_token" => "token", "guest_name" => "Guest Buyer", "guest_contact_no" => "9812345678");
$checkout = new Checkout();
check(follow(function () use ($checkout) { $checkout->guest_continue(); }) === "checkout/onepage", "guest continues to checkout");
check(!$session->userdata("USER_ID") && $session->userdata("GUEST_CUSTOMER_ID") === $first_id, "guest never authenticated as existing customer");
check($session->userdata("GUEST_DETAILS") === array("fname" => "Guest Buyer", "contact_no" => "9812345678"), "guest details contain only supplied values");
check($session->rotations === 1, "guest rotates session");
$protected = FALSE;
try { (new User())->profile(); } catch (Redirected $e) { $protected = TRUE; }
check($protected, "guest cannot access authenticated profile");
$protected = FALSE;
try { (new User())->my_orders(); } catch (Redirected $e) { $protected = TRUE; }
check($protected, "guest cannot access order history");
$input->data["checkout_token"] = "wrong";
$before = count($GLOBALS["services"]["db"]->users);
follow(function () use ($checkout) { $checkout->guest_continue(); });
check(count($GLOBALS["services"]["db"]->users) === $before, "invalid token cannot create customer");
$session->data = array("GUEST_CHECKOUT" => "1", "USER_ID" => 1);
new User_model();
check(!$session->userdata("USER_ID") && !$session->userdata("GUEST_CHECKOUT"), "old unsafe sessions revoked");
$session->set_userdata("ADMIN_ID", 1);
$admin = new Product();
$price_method = new ReflectionMethod("Product", "variation_price_value"); $price_method->setAccessible(TRUE);
check($price_method->invoke($admin, array(""), 0) === NULL, "blank admin price stores null");
check($price_method->invoke($admin, array("799.50"), 0) === "799.50", "admin price roundtrip precision");
foreach (array("bad", "-1", "0.001", "100000000", array("1")) as $value) { check(!$admin->valid_size_price($value), "bad admin price rejected"); }
check($admin->valid_size_price("") && $admin->valid_size_price("0") && $admin->valid_size_price("999.50"), "valid blank/zero/decimal admin prices");
$input->data = array("email" => " ", "password" => "changed");
$_POST = $input->data;
$user_controller = new User();
ob_start(); $user_controller->login_process(); $login_response = json_decode(ob_get_clean(), TRUE);
check($login_response["status"] === 0 && !$session->userdata("USER_ID"), "empty identifier cannot authenticate");
$input->data = array("email" => "+91 98123 45678", "password" => "changed");
$_POST = $input->data;
$GLOBALS["services"]["db"]->insert("tbl_users", array("email" => "9812345678", "contact_no" => "", "password" => base64_encode("changed"), "status" => "1"));
$session->set_userdata(array("GUEST_CUSTOMER_ID" => $first_id, "GUEST_DETAILS" => array("fname" => "Unverified")));
$before_rotations = $session->rotations;
ob_start(); $user_controller->login_process(); $login_response = json_decode(ob_get_clean(), TRUE);
check($login_response["status"] === 1 && $session->userdata("USER_ID") === $first_id, "canonical phone/password login");
check(!$session->userdata("GUEST_CUSTOMER_ID") && $session->rotations === $before_rotations + 1, "authenticated login clears guest state and rotates session");
$_SESSION["checkout_data"] = array("sfname" => "Delivery", "slname" => "Recipient", "scontact_no" => "6812345678",
    "scountry" => "India", "saddress" => "Fixture", "scity" => "Delhi", "sstate" => "Delhi", "spincode" => "110001", "slandmark" => "");
$saved_phone = $GLOBALS["services"]["db"]->users[$first_id]["contact_no"];
$checkout->update_user_data(0, $first_id);
check($GLOBALS["services"]["db"]->users[$first_id]["contact_no"] === $saved_phone, "shipping recipient phone never replaces identity");
class TestProducts extends Product_model {
    public $product; public $variation;
    public $saved = array();
    public function __construct() {
        $this->product = (object) array("id" => 1, "price" => "799.00", "special_price" => "0.00", "discount" => 0, "title" => "Fixture", "status" => "1", "delete_flag" => "0");
        $this->variation = (object) array("id" => 7, "product_id" => 1, "price" => "999.50", "qty" => 5, "size" => "2XL", "sku" => "fixture");
    }
    public function get_product_by_id($id) { return array($this->product); }
    public function select_product_variation_by_id($id) { return array($this->variation); }
    public function save_product($data) { $this->saved = $data; }
    public function update_product_by_id($id, $data) { $this->saved = $data; return TRUE; }
}
$catalog = new TestProducts(); $GLOBALS["services"]["product_model"] = $catalog;
$cart->items = array(); $input->data = array("product_id" => "1", "variation_id" => "7", "qty" => "1");
$cart_controller = new Cart(); ob_start(); $cart_controller->add_to_cart(); ob_end_clean();
check($cart->items[0]["price"] === 999.5, "AJAX cart charges own size price");
$cart->items = array(); $input->data["id"] = "1";
follow(function () use ($cart_controller) { $cart_controller->add_to_cart_pageload(); });
check($cart->items[0]["price"] === 999.5, "pageload cart charges same price");
$catalog->variation->price = NULL; $cart->items = array();
ob_start(); $cart_controller->add_to_cart(); ob_end_clean();
check($cart->items[0]["price"] === 799.0, "cart NULL inheritance");
$catalog->variation->product_id = 2; $cart->items = array();
ob_start(); $cart_controller->add_to_cart(); ob_end_clean();
check(!$cart->items, "mismatched product/size rejected by AJAX cart");
follow(function () use ($cart_controller) { $cart_controller->add_to_cart_pageload(); });
check(!$cart->items, "mismatched product/size rejected by pageload cart");
$catalog->variation->product_id = 1; $input->data["variation_id"] = "0";
ob_start(); $cart_controller->add_to_cart(); ob_end_clean();
check(!$cart->items, "missing size cannot bypass own size price");
$catalog->variation->price = "999.50";
$cart->items = array(array("id" => 7, "rowid" => "row7", "price" => 799, "qty" => 1));
$price_check = new ReflectionMethod("Checkout", "cart_prices_current"); $price_check->setAccessible(TRUE);
check(!$price_check->invoke($checkout), "stale cart price rejected before order creation");
check($cart->items[0]["price"] === 799, "checkout does not rewrite charged cart price");
$cart->items[0]["price"] = 999.5;
check($price_check->invoke($checkout), "current cart price accepted");
$input->data = array("product_id" => "1", "variation_id" => "7", "qty" => "1", "quoted_price" => "799.00");
$cart->items = array();
ob_start(); $cart_controller->add_to_cart(); ob_end_clean();
check(!$cart->items, "stale displayed quote cannot charge a different price");
$input->data["quoted_price"] = "999.50";
ob_start(); $cart_controller->add_to_cart(); ob_end_clean();
check($cart->items[0]["price"] === 999.5, "display quote and charged decimal match");
$session->set_userdata("ADMIN_ID", 1);
foreach (array("" => NULL, "999.50" => "999.50") as $submitted => $expected) {
    $_POST = array("submitform" => "1", "title" => "Fixture", "price" => "799", "status" => "1", "old_size" => array("2XL"),
        "old_sku" => array("fixture"), "old_qty" => array("5"), "old_variation" => array(7), "old_variation_price" => array($submitted));
    $input->data = $_POST;
    follow(function () use ($admin) { $admin->edit(1); });
    check($GLOBALS["services"]["db"]->variations[7]["price"] === $expected, "admin edit persists blank/null or decimal");
    check(!array_key_exists("old_variation_price", $catalog->saved), "size prices never leak into parent product update");
}
foreach (array("add_new", "add_variation_color") as $action) {
    foreach (array("" => NULL, "999.50" => "999.50") as $submitted => $expected) {
        $_POST = array("submitform" => "1", "title" => "Fixture", "price" => "799", "status" => "1", "size" => array("2XL"),
            "sku" => array("fixture"), "qty" => array("5"), "variation_price" => array($submitted), "position" => array(), "img_tag" => array());
        $input->data = $_POST;
        follow(function () use ($admin, $action) { $admin->$action("fixture-parent"); });
        $last = end($GLOBALS["services"]["db"]->variations);
        check($last["price"] === $expected, "admin add/color persists blank/null or decimal");
        check(!array_key_exists("variation_price", $catalog->saved), "size prices never leak into parent product insert");
    }
}
echo json_encode(array("passed" => $passed, "scope" => "actual PHP model/controller methods with deterministic in-memory fixtures; no network or database"), JSON_PRETTY_PRINT), PHP_EOL;
