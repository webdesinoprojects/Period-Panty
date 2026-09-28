<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class faq  extends CI_Controller 
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
		$this->load->model('faq_model');
	}
	

    public function add()
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
				$this->faq_model->save_faq($postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully saved.</div>');
				redirect('admin/faq/listing');
			}else{

					$msg =  "<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>";
			        $this->session->set_flashdata('msg', $msg);
			}	
				
						
		}		
		$this->load->view('admin/faq/add');
	}


	public function listing()
	{
		$data['RESULT'] = $this->faq_model->get_all_faq(); 
		$this->load->view('admin/faq/listing',$data);
	}
		
		
	public function edit()
	{
		$args = func_get_args();
		if(isset($_POST['submitform']))
		{
			$postdata = $this->input->post();
			if(!empty($postdata['title']))
			{	
			
				$faq_id = $args[0]; 
				unset($postdata['submitform']);
				$this->faq_model->update_faq_by_id($args[0],$postdata);
				$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully updated.</div>');
				redirect('admin/faq/listing');				
			}	
		}
		$data['RESULT'] = $this->faq_model->get_faq_by_id($args[0]); 
		$this->load->view('admin/faq/edit',$data);
	}


    public function upload_files() {

	    $post_data = $this->input->post();
	    $arr['error'] = false;
	    $arr['uploaded_data'] = []; 
	    $files = $_FILES;
        $cpt = count($_FILES['more_image']['name']);
              for($i=0; $i<$cpt; $i++)
			    {           
			        $_FILES['userfile']['name']= time(). "_" .  $files['more_image']['name'][$i];
			        $_FILES['userfile']['type']= $files['more_image']['type'][$i];
			        $_FILES['userfile']['tmp_name']= $files['more_image']['tmp_name'][$i];
			        $_FILES['userfile']['error']= $files['more_image']['error'][$i];
			        $_FILES['userfile']['size']= $files['more_image']['size'][$i];   
			        $config['upload_path'] = 'uploads/faq/';
		            $config['allowed_types'] = 'jpg|png|jpeg|webp';
			        $this->upload->initialize($config);
			        if ($this->upload->do_upload()) {

				            $arr['uploaded_data'][$i] = $this->upload->data();
				            
				        
				         

				          } else {

				              return ['error' => true ,  'msg' => $this->upload->display_errors()];
				          }

			    }

			  

	    return $arr;

	}
	

}