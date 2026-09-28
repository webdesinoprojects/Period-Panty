<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page  extends CI_Controller 
{
	
	function __construct()
	{
		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
		if(empty($admin_id))
		{
			redirect('admin');
		}
        $this->load->model('page_model');	
   
        }


	public function add_new(){
		if(isset($_POST['submitform']))
		{	
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
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
						$path = 'uploads/page/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['image'] = $file_name;					
						
              
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid img extension (png,jpg,jpeg,JPEG,gif) </div>');
						 redirect('admin/page/add_new');
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
						$path = 'uploads/page/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['banner'] = $file_name;					
						
              
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid banner extension (png,jpg,jpeg,JPEG) </div>');
						 redirect('admin/page/add_new');
					}					
			    }
				unset($postdata['submitform']);
				$postdata['create_date'] = date('Y-m-d h:i:s');				
				$this->page_model->save_page($postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully saved.</div>');
				redirect('admin/Page/listing');

			}				
		}
			
		$this->load->view('admin/pages/add');
	}
	
	public function listing()
	{
		$data['result'] = $this->page_model->get_all_page(); 
		$this->load->view('admin/pages/listing',$data);
	}
		
	public function delete_page()
	{
		$args = func_get_args();
		$this->page_model->delete_page_by_id($args[0]);
		$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully deleted.</div>');
		redirect('admin/Page/listing');
	}


	public function edit()
	{
		$args = func_get_args();
		$data['RESULT'] = $this->page_model->get_page_by_id($args[0]); 
		
		if(isset($_POST['submitform']))
		{
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
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
						$path = 'uploads/page/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['image'] = $file_name;					
						
              
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid img extension (png,jpg,jpeg,JPEG,gif) </div>');
						 redirect('admin/page/add_new');
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
						$path = 'uploads/page/'.$file_name;
						move_uploaded_file($tmp_name,$path);
						$postdata['banner'] = $file_name;					
						
              
					}else{

						 $this->session->set_flashdata('msg','<div class="alert alert-success">Please Use valid banner extension (png,jpg,jpeg,JPEG) </div>');
						 redirect('admin/page/add_new');
					}					
			    }

				unset($postdata['submitform']);
				$this->page_model->update_page_by_id($args[0],$postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">Record has been successfully updated.</div>');
				redirect('admin/Page/listing');
			}	
		}
		
	
		$this->load->view('admin/pages/edit',$data);
	}	

	
}