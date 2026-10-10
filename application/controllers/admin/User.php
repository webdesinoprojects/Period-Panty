<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller 
{
    function __construct()
	{
		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
		if(empty($admin_id))
		{
			redirect('admin');
		}
		$this->load->model('user_model');
	}	
	
	public function all()
	{
	    if((isset($_POST['submit']) ) && (isset($_POST['user_id'])  )){
	        $user_array = $_POST['user_id'] ; 
	        foreach($user_array as $key=>$value){
	            $post_data['status'] = $_POST['status'];
	            $this->user_model->update_user($value,$post_data);
	        }
	        $this->session->set_flashdata('msg','<div class="alert alert-success">Profile has been updated successfully</div>');
	    }
		$data['RESULT'] = $this->user_model->get_all_users(); 
		$this->load->view('admin/user/listing',$data);
	}
	
	
	public function all_mail()
	{
	    $this->load->model("contact_model");
	    $this->contact_model->initialize();
	    if((isset($_POST['submit']) ) && (isset($_POST['mail_id'])  )){
	        $user_array = $_POST['mail_id'] ; 
	        foreach($user_array as $key=>$value){
	           	$this->db->where('id',$value);
        		$this->db->delete('tbl_mail_info');
	        }
	        $this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully deleted.</div>');
	    }
		$data['RESULT'] = $this->user_model->get_all_mail_info(); 
		$this->load->view('admin/user/mail_info',$data);
	}
	
	public function profile()
	{
		$args = func_get_args();
		if(isset($_POST['update_profile']))
		{
			$post_data = $this->input->post();	
			unset($post_data['old_image']);
			unset($post_data['update_profile']);
			$this->user_model->update_user($args[0],$post_data);
			$this->session->set_flashdata('msg','<div class="alert alert-success">Profile has been updated successfully</div>');
			redirect('admin/user/profile/'.$args[0]);
		}	
		
		if(isset($_POST['update_password']))
		{
			$npwd = $this->input->post('npwd');
			$opwd = $this->input->post('opwd');
			if(empty($npwd) || empty($opwd))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger">please fill all fields</div>');
				redirect('admin/user/profile/'.$args[0]);
			}
			else
			{
				if($npwd!=$opwd)
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger">New password and confirm password not matched.</div>');
					redirect('admin/user/profile/'.$args[0]);
				}
				else
				{
					$upd_data['password'] = base64_encode($npwd);
					$this->user_model->update_user($args[0],$upd_data);
					$this->session->set_flashdata('msg','<div class="alert alert-success">password has been updated successfully</div>');
					redirect('admin/user/profile/'.$args[0]);
				}	
			}	
		}	
		
		$data['RESULT'] = $this->user_model->get_user_by_id($args[0]); 
		$this->load->view('admin/user/profile',$data);
	} 
	

	public function userdelete()
	{
		$args = func_get_args();
		$this->db->where('id',$args[0]);
		$this->db->delete('tbl_users');
	
		$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully deleted.</div>');
		redirect('admin/user/all');
	}
	public function delete_mail()
	{
		$args = func_get_args();
		$this->db->where('id',$args[0]);
		$this->db->delete('tbl_mail_info');
	
		$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully deleted.</div>');
		redirect('admin/user/all_mail');
	}
}
