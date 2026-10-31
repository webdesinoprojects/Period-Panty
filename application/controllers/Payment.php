<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Razorpay checkout.
 *
 * The rule this controller is built around: the browser is told the public key
 * id and a Razorpay order id, and is believed about nothing else.
 *
 * The previous version trusted two hidden form fields - merchant_total and
 * merchant_order_id - and captured whatever amount was posted before marking
 * that order number Paid. Editing merchant_total to 100 bought a Rs.1850 order
 * for a rupee, and editing merchant_order_id marked somebody else's order paid
 * off your own payment. Neither field exists any more.
 *
 * Instead: the amount is read from tbl_order, Razorpay binds the payment to an
 * order we created with that amount, the returned signature is checked against
 * the order id WE stored, and the payment is then re-fetched from Razorpay and
 * its amount and status compared again before anything is marked Paid.
 */
class Payment extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('order_model');
		$this->load->library('razorpay_client');
	}

	/**
	 * Opens checkout for one order. Reached as order-payment-process/<order_no>.
	 */
	public function index()
	{
		$order_no = (string) $this->uri->segment(2);
		$order = $this->payable_order($order_no);
		if (!$order) {
			redirect('home');
			return;
		}
		if (!$this->razorpay_client->enabled()) {
			log_message('error', 'Razorpay keys are not configured; cannot take payment.');
			$this->load->view('front/checkout/failed', array('order_data' => array($order)));
			return;
		}

		// The only amount that counts, taken from our own row.
		$amount_paise = Razorpay_client::to_paise($order->final_amount);
		$rzp = $this->razorpay_client->create_order($amount_paise, $order->order_no, array(
			'dx_order_no' => $order->order_no,
		));
		if (!$rzp || empty($rzp['id'])) {
			log_message('error', 'Razorpay order creation failed: ' . $this->razorpay_client->last_error());
			$this->load->view('front/checkout/failed', array('order_data' => array($order)));
			return;
		}

		// Stored so the callback can find this order WITHOUT trusting the post.
		$this->db->where('id', $order->id);
		$this->db->update('tbl_order', array(
			'razorpay_order_id' => $rzp['id'],
			'amount_paise' => $amount_paise,
		));

		$shipping = $this->order_model->get_shipping_data($order->id);
		$buyer = $this->buyer_contact($order, $shipping);

		$this->load->view('front/razorpay', array(
			'key_id' => $this->razorpay_client->key_id(),
			'razorpay_order_id' => $rzp['id'],
			'amount_paise' => $amount_paise,
			'order_no' => $order->order_no,
			'buyer_name' => $buyer['name'],
			'buyer_email' => $buyer['email'],
			'buyer_phone' => $buyer['phone'],
			'callback_url' => base_url('payment/callback'),
			'cancel_url' => base_url('payment/failed/' . rawurlencode($order->order_no)),
		));
	}

	/**
	 * Razorpay checkout posts back here. Nothing in this request is trusted
	 * until the signature is checked against the order id we stored.
	 */
	public function callback()
	{
		$payment_id = (string) $this->input->post('razorpay_payment_id');
		$rzp_order_id = (string) $this->input->post('razorpay_order_id');
		$signature = (string) $this->input->post('razorpay_signature');

		// Look the order up by the Razorpay order id. The posted order id is
		// only a lookup key - the row it finds carries the id we signed with.
		$order = $this->order_by_razorpay_id($rzp_order_id);
		if (!$order) {
			log_message('error', 'Razorpay callback for an unknown order.');
			redirect('home');
			return;
		}

		$verdict = $this->verify_and_settle($order, $payment_id, $signature);
		if ($verdict === TRUE) {
			redirect('payment/success/' . rawurlencode($order->order_no));
			return;
		}
		redirect('payment/failed/' . rawurlencode($order->order_no));
	}

	/**
	 * Server-to-server notification. This is what rescues an order when the
	 * buyer pays and then closes the tab before the callback fires.
	 */
	public function webhook()
	{
		$this->output->set_content_type('application/json');

		if (!$this->razorpay_client->webhook_configured()) {
			log_message('error', 'Razorpay webhook received but RAZORPAY_WEBHOOK_SECRET is unset.');
			$this->output->set_status_header(503)->set_output('{"status":"not-configured"}');
			return;
		}
		// Must be the bytes that arrived: re-encoding the JSON changes the
		// hash and every signature would fail.
		$raw = file_get_contents('php://input');
		$signature = isset($_SERVER['HTTP_X_RAZORPAY_SIGNATURE']) ? $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] : '';
		if (!$this->razorpay_client->verify_webhook_signature($raw, $signature)) {
			log_message('error', 'Razorpay webhook signature rejected.');
			$this->output->set_status_header(400)->set_output('{"status":"bad-signature"}');
			return;
		}

		$event = json_decode($raw, TRUE);
		$name = isset($event['event']) ? $event['event'] : '';
		$entity = isset($event['payload']['payment']['entity']) ? $event['payload']['payment']['entity'] : array();
		$rzp_order_id = isset($entity['order_id']) ? (string) $entity['order_id'] : '';
		$payment_id = isset($entity['id']) ? (string) $entity['id'] : '';

		if ($name === 'payment.captured' && $rzp_order_id !== '') {
			$order = $this->order_by_razorpay_id($rzp_order_id);
			// Re-fetch rather than trusting the body, even though it is signed:
			// one code path, one source of truth.
			if ($order) { $this->settle_from_api($order, $payment_id); }
		}

		// Always 200 on a verified event, or Razorpay retries forever.
		$this->output->set_status_header(200)->set_output('{"status":"ok"}');
	}

	/**
	 * Opens test checkout for this session only. Requires
	 * RAZORPAY_TEST_ACCESS_TOKEN to be set on the server and matched exactly.
	 * Pointless and harmless once live keys are in use.
	 */
	public function test_access()
	{
		$token = (string) $this->uri->segment(3);
		if (!$this->razorpay_client->is_test_mode()
			|| !$this->razorpay_client->test_access_token_matches($token)) {
			show_404();
			return;
		}
		$this->session->set_userdata('dx_rzp_test_access', 1);
		redirect('checkout/onepage');
	}

	public function success()
	{
		$order = $this->order_model->get_order_data_by_order_no($this->uri->segment(3));
		if (!$order) { redirect('home'); return; }
		$this->load->view('front/checkout/success', array('order_data' => $order));
	}

	public function failed()
	{
		$order = $this->order_model->get_order_data_by_order_no($this->uri->segment(3));
		if (!$order) { redirect('home'); return; }
		$this->load->view('front/checkout/failed', array('order_data' => $order));
	}

	// ---------------------------------------------------------------- helpers

	/**
	 * The order this session is allowed to pay for. Without this check the
	 * payment page renders any order number's name, address and phone, and
	 * invoice numbers are guessable.
	 */
	private function payable_order($order_no)
	{
		if ($order_no === '') { return FALSE; }
		$rows = $this->order_model->get_order_data_by_order_no($order_no);
		if (empty($rows)) { return FALSE; }
		$order = $rows[0];

		if ($order->delete_flag == 1) { return FALSE; }
		if ($order->payment_method !== 'Pay Online') { return FALSE; }
		if ($order->payment_status === 'Paid') { return FALSE; }

		$user_id = $this->session->userdata('USER_ID');
		if (!empty($user_id)) {
			return ((int) $order->user_id === (int) $user_id) ? $order : FALSE;
		}
		// Guests: only the order this session just placed.
		$own = $this->session->userdata('dx_pay_order_no');
		return ($own !== NULL && hash_equals((string) $own, (string) $order_no)) ? $order : FALSE;
	}

	private function order_by_razorpay_id($rzp_order_id)
	{
		if (!preg_match('/^order_[A-Za-z0-9]+$/D', (string) $rzp_order_id)) { return FALSE; }
		$row = $this->db->where('razorpay_order_id', $rzp_order_id)
			->where('delete_flag', 0)
			->limit(1)->get('tbl_order')->row();
		return $row ? $row : FALSE;
	}

	/** Signature first, then the API, then settle. */
	private function verify_and_settle($order, $payment_id, $signature)
	{
		// Signed against the id we stored, not the one that was posted.
		if (!$this->razorpay_client->verify_payment_signature($order->razorpay_order_id, $payment_id, $signature)) {
			log_message('error', 'Razorpay signature rejected for order ' . $order->order_no);
			$this->record_failure($order, $payment_id);
			return FALSE;
		}
		return $this->settle_from_api($order, $payment_id);
	}

	/**
	 * Confirms with Razorpay that this payment really is captured, really is
	 * for this order, and really is for the full amount - then marks it Paid.
	 */
	private function settle_from_api($order, $payment_id)
	{
		$payment = $this->razorpay_client->fetch_payment($payment_id);
		if (!$payment) {
			log_message('error', 'Razorpay payment lookup failed for order ' . $order->order_no . ': ' . $this->razorpay_client->last_error());
			return FALSE;
		}
		$status = isset($payment['status']) ? $payment['status'] : '';
		$paid_paise = isset($payment['amount']) ? (int) $payment['amount'] : -1;
		$paid_for = isset($payment['order_id']) ? (string) $payment['order_id'] : '';
		$expected = (int) $order->amount_paise;

		if ($paid_for !== (string) $order->razorpay_order_id) {
			log_message('error', 'Razorpay payment belongs to a different order; refusing ' . $order->order_no);
			return FALSE;
		}
		if ($status !== 'captured') {
			log_message('error', 'Razorpay payment not captured (' . $status . ') for order ' . $order->order_no);
			$this->record_failure($order, $payment_id);
			return FALSE;
		}
		// The check the old code never made.
		if ($expected <= 0 || $paid_paise !== $expected) {
			log_message('error', 'Razorpay amount mismatch on order ' . $order->order_no . ': expected ' . $expected . ' got ' . $paid_paise);
			return FALSE;
		}
		return $this->mark_paid($order, $payment_id);
	}

	/**
	 * Marks the order paid exactly once. The WHERE clause is the lock: a
	 * replayed callback and a webhook arriving together both run this, and
	 * only the one that changes a row sends mail and moves stock.
	 */
	private function mark_paid($order, $payment_id)
	{
		$this->db->where('id', $order->id);
		$this->db->where('payment_status !=', 'Paid');
		$this->db->update('tbl_order', array(
			'status' => 'Placed',
			'payment_status' => 'Paid',
			'transaction_no' => $payment_id,
			'razorpay_payment_id' => $payment_id,
			'payment_verified_at' => date('Y-m-d H:i:s'),
		));
		if ($this->db->affected_rows() < 1) {
			// Already settled by the other path. Still a success.
			return TRUE;
		}
		$this->session->unset_userdata('dx_pay_order_no');
		$this->order_mail_template($order->id);
		$this->order_mail_template_to_admin($order->id);
		$this->stockManagement($order->id);
		return TRUE;
	}

	private function record_failure($order, $payment_id)
	{
		$this->db->where('id', $order->id);
		$this->db->where('payment_status !=', 'Paid');
		$this->db->update('tbl_order', array(
			'payment_status' => 'Unpaid',
			'razorpay_payment_id' => $payment_id,
		));
	}

	/**
	 * Prefill for the gateway. tbl_shipping's columns are fname, lname, phone
	 * and email - there is no sfname. The old code read the s-prefixed names
	 * too, and error_reporting(0) hid the notices, so the prefill has always
	 * been blank. Every field is optional here: a missing one must not warn.
	 */
	private function buyer_contact($order, $shipping)
	{
		$row = !empty($shipping) ? $shipping[0] : NULL;
		$field = function ($name) use ($row) {
			return ($row !== NULL && isset($row->$name)) ? trim((string) $row->$name) : '';
		};
		$email = $field('email');
		if ($email === '' && !empty($order->user_id)) {
			$user = $this->user_model->get_user_by_id($order->user_id);
			if (!empty($user) && isset($user[0]->email)) { $email = $user[0]->email; }
		}
		return array(
			'name' => trim($field('fname') . ' ' . $field('lname')),
			'email' => $email,
			'phone' => $field('phone'),
		);
	}

	function order_mail_template($ord_id)
	{
		$link = $this->setting_model->get_all_setting();
		$data['ORDER'] = $order = $this->order_model->get_order_data($ord_id);
		$data['USER'] = $this->user_model->get_user_by_id($order[0]->user_id);
		if (empty($data['USER']) || empty($data['USER'][0]->email)) { return; }
		$htmlContent = $this->load->view('front/mail/order-template', $data, TRUE);
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->to(trim($data['USER'][0]->email));
		$this->email->from($link[0]->from_email, $link[0]->title);
		$this->email->subject('Order Confirm');
		$this->email->message($htmlContent);
		$this->email->send();
	}

	function order_mail_template_to_admin($ord_id)
	{
		$link = $this->setting_model->get_all_setting();
		$data['ORDER'] = $order = $this->order_model->get_order_data($ord_id);
		$data['USER'] = $this->user_model->get_user_by_id($order[0]->user_id);
		$htmlContent = $this->load->view('front/mail/order-template', $data, TRUE);
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->to(trim($link[0]->email));
		$this->email->from($link[0]->from_email, $link[0]->title);
		$this->email->subject('Order Confirm Mail To Admin');
		$this->email->message($htmlContent);
		$this->email->send();
	}

	function stockManagement($order_id)
	{
		$items_data = $this->order_model->get_item_data($order_id);
		foreach ($items_data as $item) {
			$this->manage_stock($item->pro_id, $item->qty);
		}
	}

	function manage_stock($id, $qty)
	{
		$pro = $this->product_model->get_product_by_id($id);
		if ($pro[0]->qty > 0) {
			$upd_data['qty'] = $pro[0]->qty - $qty;
			$this->product_model->update_product_by_id($pro[0]->id, $upd_data);
		}
	}
}
