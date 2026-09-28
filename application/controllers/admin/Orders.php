<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders  extends CI_Controller 
{
	
	function __construct()
	{
		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
		if(empty($admin_id))
		{
			redirect('admin');
		}
	}
	
	public function listing()
	{

		$data['RESULT'] = $this->order_model->get_all_order_data(); 
		$this->load->view('admin/orders/listing',$data);
	}
	public function payment()
	{
		$data['RESULT'] = $this->order_model->get_all_order_data(); 
		$this->load->view('admin/orders/payment',$data);
	}
	
	function view()
	{
		$args = func_get_args();		
		$data['ORDER'] = $this->order_model->get_order_data($args[0]);
		$this->load->view('admin/orders/view',$data);
	}
	
	function processOrderStatus(){
	    	$postdata = $this->input->post();
	    	$data['status'] = $postdata['status'] ; 
	    	$data['remarks'] = $postdata['remarks'] ; 
	    	$this->db->where('order_no',$postdata['order_no']);
		    $this->db->update('tbl_order',$data);
		    $msg = "Your order number <b>".$postdata['order_no']." <b> has been".$data['status'] ;
		    $order_no =    $postdata['order_no'] ; 
		    $order = $this->order_model->get_order_data_by_order_no($order_no) ; 
		    $shipping = $this->order_model->get_shipping_data($order[0]->id); 
		    if( $postdata['status']=='Confirmed'){
		    
	
		    }
		    if( $postdata['status']=='Cancelled'){
		    
		     	$data['status'] = 'Cancelled' ; 
    	    	$this->db->where('order_id',$order[0]->id);
    		    $this->db->update('tbl_order_item',$data);
		    } 
		   
			$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully updated.</div>');
			redirect('admin/orders/listing');
	}	
	function processPaymentStatus(){
	    	$postdata = $this->input->post();
	    	$data['payment_status'] = $postdata['payment_status'] ; 
	    	$this->db->where('order_no',$postdata['order_no']);
		    $this->db->update('tbl_order',$data);
			$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully updated.</div>');
			redirect('admin/orders/listing');
	}
	function processItemStatus(){
			$postdata = $this->input->post();
	    	$data['status'] = $postdata['status'] ; 
	    	$data['remarks'] = $postdata['remarks'] ; 
	    	$this->db->where('order_id',$postdata['order_id']);
	    	$this->db->where('pro_id',$postdata['pro_id']);
		    $this->db->update('tbl_order_item',$data);
		    
		    $product  = $this->product_model->get_product_by_id($postdata['pro_id']);
		   
			$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully updated.</div>');
			redirect('admin/orders/listing');
	}
	
	
	public function delete()
	{
		$args = func_get_args();
		$postdata['delete_flag'] = 1;
		$this->db->where('id',$args[0]);
		$this->db->update('tbl_order' , $postdata);
		$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully deleted.</div>');
		redirect('admin/orders/listing');
	}
	

}