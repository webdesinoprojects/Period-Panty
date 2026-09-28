<?php 
class Coupon_model extends CI_Model
{	
	protected $table = 'tbl_coupon';
	public function save_coupon($data)
	{
		$this->db->insert($this->table,$data);
	}
	public function get_all_coupon()
	{
		return $this->db->get($this->table)->result();
	}
	public function get_coupon_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get($this->table)->result();
	}
	public function update_coupon_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}
	public function get_all_active_coupon()
	{
		$this->db->where('status','1');
		return $this->db->get($this->table)->result();
	}
	public function delete_coupon_by_id($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}

	public function get_coupon_by_title($title)
	{
		$this->db->where('title',$title);
		return $this->db->get($this->table)->result();
	}
	
	public function get_coupon_by_couponCode($couponCode)
	{
		$this->db->where('couponCode',$couponCode);
		$this->db->where('status','1');
		return $this->db->get($this->table)->result();
	}


	public function checkCouponUsedByUser( $couponCode, $user_id)
	{
		
		$this->db->from("tbl_order ");
		$this->db->where('user_id',$user_id);	
		$this->db->where('couponCode',$couponCode);	
		$this->db->where('payment_status','Success');	
		$this->db->order_by('id','desc');	
		return $this->db->get()->num_rows();
	}
	
	public function get_model_coupon()
	{
		$this->db->where('status','1');
		$this->db->where('in_model','1');
		return $this->db->get($this->table)->result();
	}


	
}
