<?php 
class Order_model extends CI_Model
{	
	public function save_order($data)
	{
		$this->db->insert('tbl_order',$data);
		return $this->db->insert_id();
	}
	
	public function save_order_item($data)
	{
		$this->db->insert('tbl_order_item',$data);
	}
		
	public function save_billing_data($data)
	{
		$this->db->insert('tbl_billing',$data);
	}
	
	public function save_shipping_data($data)
	{
		$this->db->insert('tbl_shipping',$data);
	}
	
	public function get_all_order_data($status=false)
	{
		
		$this->db->where('payment_status !=','Pending');
		$this->db->where('delete_flag','0');
		$this->db->order_by('id','DESC');
		return $this->db->get('tbl_order')->result();
	}
	
	public function get_order_data($order_id)
	{
		$this->db->where('id',$order_id);
		return $this->db->get('tbl_order')->result();
	}
	
	public function get_order_data_by_order_no($order_no)
	{
		$this->db->where('order_no',$order_no);
		return $this->db->get('tbl_order')->result();
	}
	
	public function get_item_data($order_id)
	{
		$this->db->where('order_id',$order_id);
		return $this->db->get('tbl_order_item')->result();
	}
	
	public function get_shipping_data($order_id)
	{
		$this->db->where('order_id',$order_id);
		return $this->db->get('tbl_shipping')->result();
	}
	
	public function get_billing_data($order_id)
	{
		$this->db->where('order_id',$order_id);
		return $this->db->get('tbl_billing')->result();
	}
	
	public function get_user_order($user_id)
	{
		$this->db->select("order.*, CONCAT(ship.fname,' ',ship.lname) as ship_to");
		$this->db->from("tbl_order as order");
		$this->db->join("tbl_shipping as ship","ship.order_id = order.id",'left');
		$this->db->where('order.user_id',$user_id);	
		$this->db->order_by('order.id','desc');	
		 $this->db->where('order.delete_flag','0');
		return $this->db->get()->result();
	}
	
	public function total_order_of_user($user_id)
	{
		$this->db->from("tbl_order as order");
		$this->db->where('order.user_id',$user_id);	
		$this->db->where('order.delete_flag','0');
		return $this->db->get()->num_rows();
	}
	
}
