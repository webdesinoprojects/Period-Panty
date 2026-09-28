<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog_category extends CI_Controller 
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
	}
	
	public function listing()
	{
	$data['RESULT'] = $this->blogs_model->get_blog_category(); 
		

		$this->load->view('admin/blog_category/listing',$data);
	}
	
	
	
	public function add_new()
	{
		if(isset($_POST['submitform']))
		{	 
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
		    $this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required'); 	
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
			    unset($postdata['submitform']);
			    $postdata['created_date'] = date('Y-m-d h:i:s:a');	
     			$this->blogs_model->add_blogs_category($postdata);
     			$insert_id = $this->db->insert_id();
     			if($insert_id){
     			 	 $this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully saved.</div>');
					  redirect('admin/blog_category/listing');
				}else{
					 $this->session->set_flashdata('msg','<div class="alert alert-success">Record has been not saved.Please try again</div>');

				}
			}else{

				 $this->session->set_flashdata('msg',"<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>");
			}				
		}		
		$this->load->view('admin/blog_category/add');
	}
	
	public function edit()
	{
		$args = func_get_args();
		$data['RESULT'] = $this->blogs_model->get_blog_category_by_id($args[0]); 
		if(isset($_POST['submitform']))
		{
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required');
		
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				
				unset($postdata['submitform']);
                $this->blogs_model->update_blogs_cat_by_id($args[0],$postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully updated.</div>');
				redirect('admin/blog_category/listing');
			
			}else{

					
					 $this->session->set_flashdata('msg',"<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>");
					  redirect('admin/blog_category/edit/'.$args[0]);
			}	
		} 
		$this->load->view('admin/blog_category/edit',$data);
	}	


	public function delete_category($id){
		$this->db->where('id', $id);
        $this->db->delete('tbl_blog_category ');
        redirect('admin/blog_category/listing');
	}
}