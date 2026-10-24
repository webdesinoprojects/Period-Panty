<?php 
class User_model extends CI_Model{
	
	protected $table = 'tbl_users';
    public function __construct()
    {
        parent::__construct();
        // Revoke authentication granted by the old guest-login implementation.
        if ($this->session->userdata("GUEST_CHECKOUT")) {
            $this->session->unset_userdata(array("USER_ID", "USER_NAME", "USER_EMAIL", "GUEST_CHECKOUT", "guest_welcome_back"));
            $this->session->sess_regenerate(TRUE);
        }
    }
	public function get_all_users()
	{
	    $this->db->order_by('id','desc') ; 
		return $this->db->get($this->table)->result();
	}
	
	public function get_all_mail_info()
	{
	    $this->db->order_by('id','desc') ; 
		return $this->db->get('tbl_mail_info')->result();
	}
		
    public $customer_error = "";

    // Indian checkout identities have one canonical ten-digit phone. Reject
    // arbitrary prefixes/letters rather than silently turning junk into a user.
    public function normalise_phone($raw)
    {
        if (!is_string($raw)) { return ""; }
        $raw = trim($raw);
        if (!preg_match('/^[+0-9().\\s-]{10,24}$/D', $raw)) { return ""; }
        $digits = preg_replace('/[^0-9]/', '', $raw);
        if (strlen($digits) > 10) {
            $prefix = substr($digits, 0, -10);
            if (!in_array($prefix, array("0", "91", "0091"), TRUE)) { return ""; }
        }
        $digits = substr($digits, -10);
        // Ten digits, not all the same. The first digit is deliberately not
        // restricted: the 6-9 rule is true of Indian mobiles today but turned
        // away numbers people were really typing, and the number is only ever
        // used to reach the buyer, never to authorise anything on its own.
        if (!preg_match('/^[0-9]{10}$/D', $digits) || preg_match('/^([0-9])\\1{9}$/D', $digits)) { return ""; }
        return $digits;
    }

    private function customer_lock()
    {
        $lock = "dx_customers_" . sha1($this->db->database);
        $result = $this->db->query("SELECT GET_LOCK(?, 10) AS acquired", array($lock))->row();
        return $result && (int) $result->acquired === 1 ? $lock : FALSE;
    }

    public function initialize_guest_accounts()
    {
        if ($this->db->field_exists("guest_created", $this->table)) { return; }
        $lock = $this->customer_lock();
        if (!$lock) { throw new RuntimeException("Customer records are busy. Please retry."); }
        try {
            if (!$this->db->field_exists("guest_created", $this->table)) {
                $this->load->dbforge();
                if (!$this->dbforge->add_column($this->table, array("guest_created" => array("type" => "TINYINT", "constraint" => 1, "default" => 0)))) {
                    throw new RuntimeException("Could not initialize guest accounts.");
                }
            }
        } finally { $this->db->query("SELECT RELEASE_LOCK(?)", array($lock)); }
    }

    // Compare canonical forms without rewriting legacy rows or merging people.
    public function get_user_by_contact_no($contact_no)
    {
        $phone = $this->normalise_phone($contact_no);
        if ($phone === "") { return array(); }
        $expression = "contact_no";
        foreach (array(" ", "+", "-", "(", ")", ".", "\t", "\r", "\n") as $separator) {
            $expression = "REPLACE(" . $expression . ", " . $this->db->escape($separator) . ", '')";
        }
        $this->db->where("RIGHT(" . $expression . ", 10) = " . $this->db->escape($phone), NULL, FALSE);
        return $this->db->limit(2)->get($this->table)->result();
    }

    public function user_login_by_contact_no($contact_no, $password)
    {
        // Resolve identity BEFORE checking credentials. Never choose a person
        // from duplicate-phone rows based on a shared/guessable password.
        $rows = $this->get_user_by_contact_no($contact_no);
        if (count($rows) !== 1 || !is_string($password) || !hash_equals((string) $rows[0]->password, $password)) { return array(); }
        return $rows;
    }

    public function insert_user($data)
    {
        $this->customer_error = "";
        $phone = isset($data["contact_no"]) && $data["contact_no"] !== "" ? $this->normalise_phone($data["contact_no"]) : "";
        if (isset($data["contact_no"]) && $data["contact_no"] !== "" && $phone === "") {
            $this->customer_error = "Please enter a valid phone number."; return FALSE;
        }
        if ($phone !== "") { $data["contact_no"] = $phone; }
        $lock = $this->customer_lock();
        if (!$lock) { $this->customer_error = "Customer records are busy. Please retry."; return FALSE; }
        try {
            if ($phone !== "" && count($this->get_user_by_contact_no($phone))) {
                $this->customer_error = "This phone already has an account. Please sign in or contact support."; return FALSE;
            }
            if (!empty($data["email"]) && count($this->check_email($data["email"]))) {
                $this->customer_error = "This email already has an account. Please sign in."; return FALSE;
            }
            if (!$this->db->insert($this->table, $data)) { return FALSE; }
            return $this->db->insert_id();
        } finally { $this->db->query("SELECT RELEASE_LOCK(?)", array($lock)); }
    }

    public function guest_customer($name, $phone, $password)
    {
        $phone = $this->normalise_phone($phone);
        if ($phone === "" || !is_string($name) || strlen($name) > 50 ||
            !preg_match("/^[\\p{L}\\p{M}][\\p{L}\\p{M} .'-]{0,49}$/uD", $name) ||
            !is_string($password) || $password === "") { return array(); }
        $this->initialize_guest_accounts();
        $lock = $this->customer_lock();
        if (!$lock) { return array(); }
        try {
            $existing = $this->get_user_by_contact_no($phone);
            if (count($existing)) { return count($existing) === 1 && (string) $existing[0]->status === "1" ? $existing : array(); }
            $data = array("fname" => $name, "lname" => "", "email" => "", "contact_no" => $phone,
                "landmark" => "", "address" => "", "country" => "", "pincode" => "",
                "password" => base64_encode($password), "status" => "1", "email_verify" => "0",
                "phone_verify" => "0", "activate_token" => "", "forgot_token" => "",
                "create_date" => date("Y-m-d H:i:s"), "guest_created" => 1);
            if (!$this->db->insert($this->table, $data)) { return array(); }
            return $this->get_user_by_id($this->db->insert_id());
        } finally { $this->db->query("SELECT RELEASE_LOCK(?)", array($lock)); }
    }

    public function update_user($id, $data)
    {
        $this->customer_error = "";
        $lock = $this->customer_lock();
        if (!$lock) { return FALSE; }
        try {
            if (array_key_exists("contact_no", $data)) {
                $current = $this->get_user_by_id($id);
                $phone = $this->normalise_phone($data["contact_no"]);
                if ($phone === "") {
                    if (count($current) !== 1 || trim((string) $current[0]->contact_no) !== "" || $data["contact_no"] !== "") {
                        $this->customer_error = "Please enter a valid phone number."; return FALSE;
                    }
                } else {
                    foreach ($this->get_user_by_contact_no($phone) as $row) {
                        if ((int) $row->id !== (int) $id) {
                            $this->customer_error = "This phone belongs to another account. Please contact support."; return FALSE;
                        }
                    }
                }
                $data["contact_no"] = $phone;
            }
            if (isset($data["password"]) && $this->db->field_exists("guest_created", $this->table)) {
                // A manually chosen password is no longer an admin-readable
                // auto-generated guest credential.
                $data["guest_created"] = 0;
            }
            $this->db->where("id", $id);
            return $this->db->update($this->table, $data);
        } finally { $this->db->query("SELECT RELEASE_LOCK(?)", array($lock)); }
    }

    public function check_email($email)
    {
        $this->db->where("email", $email);
        return $this->db->get($this->table)->result();
    }

    public function user_login($email, $password)
    {
        if (!is_string($email) || trim($email) === "" || !is_string($password) || $password === "") { return array(); }
        $rows = $this->db->where("email", trim($email))->get($this->table)->result();
        return count($rows) === 1 && hash_equals((string) $rows[0]->password, $password) ? $rows : array();
    }
	
	public function get_user_by_email_activate_token($token)
	{
		$this->db->where('activate_token',$token);
		$rows = $this->db->get($this->table)->result();
		return $rows;
	}
	
	public function get_user_by_forgot_password_token($token)
	{
		$this->db->where('forgot_token',$token);
		$rows = $this->db->get($this->table)->result();
		return $rows;
	}
	
	public function get_user_by_id($id)
	{
		$this->db->where('id',$id);
		$rows = $this->db->get($this->table)->result();
		return $rows;
	}
	function get_all_users_by_ststus($status)
	{
	    $this->db->order_by('id','desc') ; 
		if($status!='all')
		{	
			$this->db->where('status',$status);
		}
		$rows = $this->db->get($this->table)->result();
		return $rows;
	}	
	
	function get_user_wishlist($user_id){
	 
	 $this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.id,product.qty,product.discounted_products,product.is_latest,product.discount,product.best_seller");
		$this->db->from('tbl_wishlist as wishlist');
		$this->db->join('tbl_products as product',"wishlist.product_id = product.id",'left');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('wishlist.user_id',$user_id);
		$this->db->where('product.status','1');
		return $this->db->get()->result();
	}
	
	function count_user_wishlist($user_id){
	 
		
		$this->db->from('tbl_wishlist as wishlist');
		$this->db->join('tbl_products as product',"wishlist.product_id = product.id",'left');
		$this->db->where('wishlist.user_id',$user_id);
		$this->db->where('product.status','1');
		return $this->db->get()->num_rows();
	}
	
	function delete_wishlist($a){
		$this->db->where('id',$a);
		return $this->db->delete('tbl_wishlist'); 
	}
	
	function get_user_total_rewards($user_id){
	    
	    $this->db->from('tbl_rewards');
		$this->db->where('user_id',$user_id);
		 $this->db->order_by('id' , 'desc');
	     $this->db->limit(1);
		return $this->db->get()->row_array();
	}	
	function get_user_rewards($user_id){
	    
	    $this->db->from('tbl_rewards');
		$this->db->where('user_id',$user_id);
		return $this->db->get()->result();
	}
}
