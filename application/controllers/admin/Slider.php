<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Slider extends CI_Controller 
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
		$this->load->library('upload');
		 $this->load->library('image_lib');
		$this->load->model('slider_model');
		$this->slider_model->initialize_hero_fields();
	}
	
	public function listing()
	{
		$data['RESULT'] = $this->slider_model->get_all_slider(); 
		$this->load->view('admin/slider/listing',$data);
	}
	
	public function add_new()
	{
		if(isset($_POST['submitform']))
		{			
		
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				$upload_files = $this->upload_files();

				if( $upload_files['error']){

					
					$this->session->set_flashdata('msg','<div class="alert alert-success">'. $upload_files['msg'].'</div>');
			
				    
				}else{

					$postdata['image'] =  $upload_files['uploaded_data']['image']['file_name'];
				
					unset($postdata['submitform']);
					$postdata['create_date'] = date('Y-m-d h:i:s');		
					$this->slider_model->save_slider($postdata);
					$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully saved.</div>');
				
					redirect('admin/slider/listing');

				}
				
			}				
		}		
		$this->load->view('admin/slider/add');
	}
	
	public function edit()
	{
		$args = func_get_args();
		$data['RESULT'] = $this->slider_model->get_slider_by_id($args[0]); 
		
		if(isset($_POST['submitform']))
		{
	
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
			{
				$postdata = $this->input->post();
				if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
				{
					$upload_files = $this->upload_files();

					if( $upload_files['error']){
					    $this->session->set_flashdata('msg','<div class="alert alert-success">'. $upload_files['msg'].'</div>');
					     redirect('admin/slider/edit/'.$args[0]);

				    
					}else{
						$postdata['image'] =  $upload_files['uploaded_data']['image']['file_name'];
					}
				
				}
				else
				{
					$postdata['image'] = $postdata['old_file'];
				}

			
				unset($postdata['submitform']);
				unset($postdata['old_file']);
			
				$this->slider_model->update_slider_by_id($args[0],$postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully updated.</div>');
				redirect('admin/slider/listing');
			}	
		}
		$this->load->view('admin/slider/edit',$data);
	}
	
	public function delete_slider()
	{
		$args = func_get_args();
		$slider = $this->slider_model->get_slider_by_id($args[0]);
		$this->slider_model->delete_slider_by_id($args[0]);
		delete_file('uploads/slider/',$slider[0]->image);
		$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully deleted.</div>');
		redirect('admin/slider/listing');
	}

	public function upload_files() {

	    $post_data = $this->input->post();
	      $arr['error'] = false;
	      $arr['uploaded_data'] = []; 



	      foreach ($_FILES as $key => $value) {
	          if ( ! $value['name']) {
	            continue;
	          }

	          $config['upload_path'] = 'uploads/slider/';
	          $config['allowed_types'] = 'jpg|png|jpeg';
	          $config['file_name'] = time(). "_" . $value['name'];
	          $config['max_width']            = 2000;
	          $config['max_height']           = 1100;
	         
	          $this->upload->initialize($config);
	         

	          if ($this->upload->do_upload($key)) {

	            $arr['uploaded_data'][$key] = $this->upload->data();
	          

	          } else {

	              return ['error' => true , 'file_name' => $key, 'msg' => $this->upload->display_errors()];
	          	
	           
	          }
	    } 



	    return $arr;

	}
	

    public function create_thumbnail($uploaded_data) {

 		
		    $config['image_library'] = 'gd2';
		    $config['source_image'] = $uploaded_data['full_path'];
		    $config['create_thumb'] = TRUE;
		    $config['maintain_ratio'] = false;
		    $config['width']         = 200;
		    $config['height']         = 300;
		    

		    $this->image_lib->clear();
		    $this->image_lib->initialize($config);
		    $this->image_lib->resize();

		    if ( ! $this->image_lib->resize()) {

		      echo '<pre>'; 
		      print_r($this->image_lib->display_errors()); 
		      die;

		    }

	}
}
