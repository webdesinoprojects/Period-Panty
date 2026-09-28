<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends CI_Controller{
	
	function index()
	{
	    error_reporting(0);
	    $link = $this->setting_model->get_all_setting();
	    // Google reCAPTCHA API keys settings 
        $secretKey  = '6Ldns30lAAAAAC_ldMy4dQvax54XHojaPkCm_c2m'; 
		if(isset($_POST['email']))
		{
		    
		
                    $name = $this->input->post('name'); 
            		$to_email = $this->input->post('email');
            		$mobile = $this->input->post('mobile');
            		$messages = $this->input->post('message');
                    $postdata = $this->input->post() ; 
                    unset($postdata['submit']);
                    unset($postdata['g-recaptcha-response']);
                    $postdata['create_date']= date('Y-m-d H:i:s') ;
                    //Load email library 
                    $this->load->library('email'); 
                    $this->email->from($link[0]->from_email,$link[0]->title);
                    $this->email->subject($link[0]->title.':: Contact Us!');    
                    $this->email->to($link[0]->email);
            		$this->email->set_mailtype("html");
            		$message = '<html><body>';
        			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        			$message .= "<tr style='background: #eee;'><td colspan='2'>Contact Us</td></tr>";
        			$message .= "<tr><td><strong>Name:</strong> </td><td>" . $name . "</td></tr>";
        			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $to_email . "</td></tr>";
        			$message .= "<tr><td><strong>Mobile:</strong> </td><td>" . $mobile . "</td></tr>";
        			$message .= "<tr><td><strong>Message:</strong> </td><td>" . $messages . "</td></tr>";
        			$message .= "</table>";
        			$message .= "</body></html>";
                    $this->email->message($message); 
                    $this->email->send();
                     if( $this->db->insert('tbl_mail_info', $postdata )) {
                        $this->session->set_flashdata('msg','<div class="alert alert-success">Email sent successfully.</div>');
                     }else{
                        $this->session->set_flashdata('msg','<div class="alert alert-danger">Error in sending Email</div>');
                     }
                  
               
            
               redirect('contact#form');
		}
        $data['RESULT'] = $this->page_model->get_page_by_id(19);
	    $this->load->view('front/contact',$data);
	
	}


   
}
