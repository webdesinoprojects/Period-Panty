<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Country extends CI_Controller 
{
	
	function __construct()
	{
		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
		if(empty($admin_id))
		{
			redirect('admin');
		}
       $this->load->model('Country_model');	
       $this->load->model('Category_model');
        }
	  public function add_new()
	    {
		if(isset($_POST['submitform']))
		{	
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				unset($postdata['submitform']);
				$postdata['create_date'] = date('Y-m-d h:i:s');				
				$this->Country_model->save_data($postdata);
				

				$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully saved.</div>');
				redirect('admin/Country/listing');

			}				
		}
			
		$this->load->view('admin/Country/add');
	}
	
	public function listing()
	{
		$data['result'] = $this->Country_model->get_all_data(); 
		$this->load->view('admin/Country/listing',$data);
	}
		
		
	
	public function delete_data()
	{
		$args = func_get_args();
		$this->Country_model->delete_data_by_id($args[0]);
		$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully deleted.</div>');
		redirect('admin/Country/listing');
	}


public function edit()
	{
		$args = func_get_args();
		$data['RESULT'] = $this->Country_model->get_data_by_id($args[0]); 
		
		if(isset($_POST['submitform']))
		{
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				unset($postdata['submitform']);
				unset($postdata['old_file']);
				$this->Country_model->update_data_by_id($args[0],$postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully updated.</div>');
				redirect('admin/Country/listing');
			}	
		}
		$data['CATEGORY'] = $this->category_model->get_all_category(); 
	
		$this->load->view('admin/Country/edit',$data);
	}	

	
}