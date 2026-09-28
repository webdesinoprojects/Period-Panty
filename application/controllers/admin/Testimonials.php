<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonials extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
		if(empty($admin_id))
		{
			redirect('admin');
		}
		$this->load->library('form_validation');
		$this->load->model('testimonials_model');
	}
	public function listing()
	{
		$data['RESULT'] = $this->testimonials_model->get_all_testimonials(); 
		$this->load->view('admin/testimonials/listing',$data);
	}
	
	public function add_new()
	{
	if(isset($_POST['submitform']))
	{
		 $this->form_validation->set_rules('name', 'Name', 'trim|required');
	 	
		 if($this->form_validation->run() == TRUE)
		 { 

		 	 $postdata = $this->input->post();
		   if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
			{
			
					$file_name = create_image_unique($_FILES['image']['name']);
					$tmp_name = $_FILES['image']['tmp_name'];
					$path = 'uploads/testimonials/'.$file_name;
					move_uploaded_file($tmp_name,$path);
					$postdata['image'] = $file_name;					
				
			}
					
		 
		  unset($postdata['submitform']);
		  $this->testimonials_model->save_testimonials($postdata);
		 
		  redirect('admin/testimonials/listing');			
		 }else{

		 	  $msg =  "<div class='alert alert-danger'><font color='red'>" . validation_errors() . "</font>.</div>";
			  $this->session->set_flashdata('msg', $msg);
		 }
	}
	   $this->load->view('admin/testimonials/add');
	}
	
	public function edit()
	{
		$args = func_get_args();
		$data['RESULT'] = $this->testimonials_model->get_testimonials_by_id($args[0]); 
		//print_r($data['RESULT']);die();
		if(isset($_POST['submitform']))
		{ 
			$this->form_validation->set_rules('name', 'Name', 'trim|required');		
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
				{
					
						$file_name = create_image_unique($_FILES['image']['name']);
						$tmp_name = $_FILES['image']['tmp_name'];
						$path = 'uploads/testimonials/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['image'] = $file_name;	
						delete_file('uploads/testimonials/',$postdata['old_file']);
					
				}
				else
				{
					$postdata['image'] = $postdata['old_file'];
				}


				
				unset($postdata['submitform']);
				unset($postdata['old_file']);
				$this->testimonials_model->update_testimonials_by_id($args[0],$postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully updated.</div>');
				redirect('admin/testimonials/listing');
			}
			else{

		 	  $msg =  "<div class='alert alert-danger'><font color='red'>" . validation_errors() . "</font>.</div>";
			  $this->session->set_flashdata('msg', $msg);
		 }	
		}
		$this->load->view('admin/testimonials/edit',$data);
	}

	public function delete_testimonial()
	{
		$args = func_get_args();
		$testimonials = $this->testimonials_model->get_testimonials_by_id($args[0]);
		$this->testimonials_model->delete_testimonials_by_id($args[0]);
		delete_file('uploads/testimonials/',$testimonials[0]->image);
		$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully deleted.</div>');
		redirect('admin/testimonials/listing');
	}

	public function deleteimage($value='')
	{
		$test_id = $this->input->post('test_id');
		$testimonials = $this->testimonials_model->get_testimonials_by_id($test_id);
		$postdata['image']  = '';
		$this->testimonials_model->update_testimonials_by_id($test_id,$postdata);
		delete_file('uploads/testimonials/',$testimonials[0]->image);
	}

	
	

}