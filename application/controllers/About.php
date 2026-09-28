<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class About extends CI_Controller{

	function index()
	{
	 $data['RESULT'] = $this->page_model->get_page_by_id(1);
	$this->load->view('front/about',$data);

	}

}
