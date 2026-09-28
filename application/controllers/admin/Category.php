<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller 
{
	
	function __construct()
	{
		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
		if(empty($admin_id))
		{
			redirect('admin');
		}
	    $this->load->library('upload');
		$this->load->helper('string');
		$this->load->library('image_lib');

		if (empty($admin_id)){ redirect('admin');}
		$this->load->library('form_validation');
	}
	
	public function listing()
	{
		$data['RESULT'] = $this->category_model->get_all_category(); 
		
		$this->load->view('admin/category/listing',$data);
	}
	
	public function add_new()
	{
		if(isset($_POST['submitform']))
		{	 
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
		    $this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required'); 	
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');	
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
				{
					$allow_ext = array('png','jpg','jpeg','JPEG','gif');
					$file_ext = image_extension($_FILES['image']['name']);
					$file_name ='';
					if(in_array($file_ext,$allow_ext))
					{

						$file_name = create_image_unique($_FILES['image']['name']);
						$tmp_name = $_FILES['image']['tmp_name'];
						$path = 'uploads/category/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['image'] = $file_name;					
						
              
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid img extension (png,jpg,jpeg,JPEG,gif) </div>');
						 redirect('admin/category/add_new');
					}					
			    }
			    if(isset($_FILES['banner']['name']) && !empty($_FILES['banner']['name']))
				{
					$allow_ext = array('png','jpg','jpeg','JPEG','gif');
					$file_ext = image_extension($_FILES['banner']['name']);
					$file_name ='';
					if(in_array($file_ext,$allow_ext))
					{

						$file_name = create_image_unique($_FILES['banner']['name']);
						$tmp_name = $_FILES['banner']['tmp_name'];
						$path = 'uploads/category/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['banner'] = $file_name;					
						
              
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid banner extension (png,jpg,jpeg,JPEG) </div>');
						 redirect('admin/category/add_new');
					}					
			    }

			    unset($postdata['submitform']);
			    $postdata['create_date'] = date('Y-m-d h:i:s:a');	
     			$this->category_model->save_category($postdata);
     			$insert_id = $this->db->insert_id();
     			if($insert_id){
     			 	 $this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully saved.</div>');
					  redirect('admin/category/listing');
				}else{
					 $this->session->set_flashdata('msg','<div class="alert alert-success">Record has been not saved.Please try again</div>');

				}
			}else{

				 $this->session->set_flashdata('msg',"<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>");
			}				
		}		
		$data['CATEGORY'] = $this->category_model->get_all_category(); 
		$this->load->view('admin/category/add',$data);
	}
	
	public function edit()
	{
		$args = func_get_args();
		$data['RESULT'] = $this->category_model->get_category_by_id($args[0]); 
		if(isset($_POST['submitform']))
		{
			$this->form_validation->set_rules('parent_id', 'Parent Category', 'trim|required');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
				{
					$allow_ext = array('png','jpg','jpeg','JPEG','gif');
					$file_ext = image_extension($_FILES['image']['name']);
					if(in_array($file_ext,$allow_ext))
					{
						$file_name = create_image_unique($_FILES['image']['name']);
						$tmp_name = $_FILES['image']['tmp_name'];
						$path = 'uploads/category/'.$file_name;
					    $var=	move_uploaded_file($tmp_name,$path);
						$postdata['image'] = $file_name;	
					
				
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid img extension (png,jpg,jpeg,JPEG) </div>');
						 redirect('admin/category/edit/'.$args[0]);
					}
				}
				if(isset($_FILES['banner']['name']) && !empty($_FILES['banner']['name']))
				{
					$allow_ext = array('png','jpg','jpeg','JPEG','gif');
					$file_ext = image_extension($_FILES['banner']['name']);
					$file_name ='';
					if(in_array($file_ext,$allow_ext))
					{

						$file_name = create_image_unique($_FILES['banner']['name']);
						$tmp_name = $_FILES['banner']['tmp_name'];
						$path = 'uploads/category/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['banner'] = $file_name;				
						
              
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid banner extension (png,jpg,jpeg,JPEG) </div>');
						  redirect('admin/category/edit/'.$args[0]);
					}					
			    }
				unset($postdata['submitform']);
                $this->category_model->update_category_by_id($args[0],$postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully updated.</div>');
				redirect('admin/category/listing');
			
			}else{

					
					 $this->session->set_flashdata('msg',"<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>");
					  redirect('admin/category/edit/'.$args[0]);
			}	
		} 
		$data['CATEGORY'] = $this->category_model->get_all_category(); 
		$this->load->view('admin/category/edit',$data);
	}	
}