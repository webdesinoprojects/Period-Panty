<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller
{

    function __construct(){
	 	parent::__construct();
	 }
  

	public function index()
	{	 
	 	$data['RESULT'] = $this->page_model->get_page_by_id(34);
		$data['blog']= $this->blogs_model->get_all_active_blogs();
	    $this->load->view('front/blog/listing',$data);

	}
	public function detail()
	{	 
	 	$args = func_get_args();
		$data['RESULT'] = $this->blogs_model->get_blogs_by_slug($args[0]);
		$data['blog'] = $this->blogs_model->related_blog($data['RESULT'][0]->cat_id , 10);
	    $this->load->view('front/blog/details',$data);
	}

	
	
	public function blog($parent = 0)
	{	 
	 
	 	$data['blogs']=$this->Blogs_model->get_all_blog_and_image();
	    
	    $this->load->view('front/blog',$data);
	

	}



}

