<?php 
class User_model extends CI_Model{
	
	protected $table = 'tbl_users';
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
		
	public function insert_user($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
	public function update_user($id,$data)
	{
		$this->db->where('id',$id);
		return $this->db->update($this->table,$data);
	}
	
	public function check_email($email)
	{
		$this->db->where('email',$email);	
		$rows = $this->db->get($this->table)->result();
		return $rows;
	}
	
	public function user_login($email,$password)
	{
		$this->db->where('email',$email);
		$this->db->where('password',$password);	
		$rows = $this->db->get($this->table)->result();
		return $rows;
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
