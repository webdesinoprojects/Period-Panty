<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blogs  extends CI_Controller 
{
	
	function __construct()
	{
		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
		 $this->load->library('upload');
		$this->load->helper('string');
		$this->load->library('image_lib');
		if(empty($admin_id))
		{
			redirect('admin');
		}
		$this->load->model('blogs_model');
	}
	
	public function add_new()
	{
		if(isset($_POST['submitform']))
		{	
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Category Id', 'trim|required');
			$this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required|is_unique[tbl_blogs.url_slug]');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE){
					$postdata = $this->input->post();
					unset($postdata['submitform']);
					$postdata['create_date'] = date('Y-m-d h:i:s');
					if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
                		{
                			$upload_files = $this->upload_files();
            				if( $upload_files['error']){
            					$this->session->set_flashdata('msg','<div class="alert alert-success">'. $upload_files['msg'].'</div>');
            					 redirect('admin/blogs/add_new');
            				}else{
                                
                                $postdata['thumb_image']= $upload_files['uploaded_data']['image']['raw_name']."_thumb".$upload_files['uploaded_data']['image']['file_ext'];
            					$postdata['image'] =  $upload_files['uploaded_data']['image']['file_name'];
            				}
                		}
					$this->blogs_model->add_blogs($postdata);
					$blog_id = $this->db->insert_id();
					if($blog_id){
					    $this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully saved.</div>');
					    redirect('admin/blogs/listing');
					}else{
					    $this->session->set_flashdata('msg', '<div class="alert alert-success">Not Inserted, Please try again</div>');
					}
					
			}else{
			    
			     $msg =  "<div class='alert alert-danger'><font color='red'>" . validation_errors() . "</font>.</div>";
		        $this->session->set_flashdata('msg', $msg);
			}
		}	
		$this->load->view('admin/blogs/add');
	}
	
	public function listing()
	{
		$data['RESULT'] = $this->blogs_model->get_all_blogs(); 
		$this->load->view('admin/blogs/listing',$data);
	}
		
	public function edit()
	{
		$args = func_get_args();
		 
		if(isset($_POST['submitform']))
		{
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Category Id', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE){
			        $postdata = $this->input->post();
    				if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
            		{
            			$upload_files = $this->upload_files();
        				if( $upload_files['error']){
        					$this->session->set_flashdata('msg','<div class="alert alert-success">'. $upload_files['msg'].'</div>');
        				}else{
                            
                            $postdata['thumb_image']= $upload_files['uploaded_data']['image']['raw_name']."_thumb".$upload_files['uploaded_data']['image']['file_ext'];
        					$postdata['image'] =  $upload_files['uploaded_data']['image']['file_name'];
        				}
            		}
					unset($postdata['submitform']);
					$this->blogs_model->update_blogs_by_id($args[0], $postdata);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully updated.</div>');
    				redirect('admin/blogs/listing');
				}else{

					 $msg =  "<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>";
		             $this->session->set_flashdata('msg', $msg);	
				}
		}
		$data['RESULT'] = $this->blogs_model->get_blogs_by_id($args[0]);
		$this->load->view('admin/blogs/edit',$data);
	}	
	
	public function delete_blogs()
	{
		$args = func_get_args();
		$blogs_data = $this->blogs_model->get_blogs_by_id($args[0]);
		$this->blogs_model->delete_blogs_by_id($args[0]);
		delete_file('uploads/blogs/',$blogs_data[0]->image);
		$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully deleted.</div>');
		redirect('admin/blogs/listing');
	}
    
    public function image_delete()
	{
	if (count($_POST) && isset($_POST['id']) && !empty($_POST['id']))
		{

		$this->blogs_model->delete_blogs_images($_POST['id']);
		delete_file('uploads/blogs/', $_POST['image']);
		echo 1;
		}
	  else
		{
		echo 0;
		}

	}

    public function upload_files() {

	      $post_data = $this->input->post();
	      $arr['error'] = false;
	      $arr['uploaded_data'] = []; 
	      foreach ($_FILES as $key => $value) {
	          if ( ! $value['name']) {
	            continue;
	          }
	          $config['upload_path'] = 'uploads/blogs/';
	           $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
	          $config['file_name'] = time(). "_" . $value['name'];
	          $config['max_width']            = 2000;
	          $config['max_height']           = 1125;
	          $this->upload->initialize($config);
	          if ($this->upload->do_upload($key)) {

	            $arr['uploaded_data'][$key] = $this->upload->data();
	            $this->create_thumbnail($arr['uploaded_data'][$key]);

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
		    $config['width']         = 400;
		    $config['height']         = 225;
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