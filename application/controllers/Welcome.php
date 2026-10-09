<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller
{

    function __construct(){
	 	 parent::__construct();
		 $this->load->library('upload');
	 	
	 }


	public function index($parent = 0)
	{	 
		$this->load->model(array("home_content_model", "testimonials_model"));
		$this->home_content_model->initialize();
		$data["FAQS"] = $this->faq_model->get_all_active_faq();
		$data["TESTIMONIALS"] = $this->testimonials_model->get_all_active_testimonials_home();
	  	$limit = 8 ; 
		$data['SLIDERDATA'] = $this->slider_model->get_all_active_slider();
		$data['PRODUCTS'] = $this->product_model->get_home_products($filter_array_2 = ['is_featured'=>'yes','status'=>'1' ],12,'id','desc');
	   	$data['RESULT'] = $this->page_model->get_page_by_id(14);
	   	$data['coupon'] = $this->coupon_model->get_model_coupon(); 
	    $this->load->view('front/home',$data);
	}




	function return_policy()
	{
		$data['RESULT'] = $this->page_model->get_page_by_id(13);
		$this->load->view('front/return',$data);

	}	
	function FAQs()
	{
		$this->load->model("home_content_model");
		$this->home_content_model->initialize();
		$data['RESULT'] = $this->page_model->get_page_by_id(33);
		$data['faq'] = $this->faq_model->get_all_active_faq(); 
		$this->load->view('front/faq',$data);

	}

	function privacy_policy()
	{
		$data['RESULT'] = $this->page_model->get_page_by_id(3);
		$this->load->view('front/privacy-policy',$data);

	}

	function terms_conditions()
	{
		$data['RESULT'] = $this->page_model->get_page_by_id(11);
		$this->load->view('front/terms-conditions',$data);

	}
	
	function apply_for_distributorship()
	{
	     $link = $this->setting_model->get_all_setting();
		if(isset($_POST['name']))
		{
		
             $name = $this->input->post('name'); 
    		 $to_email = $this->input->post('email');
    		 $mobile = $this->input->post('mobile');
    		 $messages = $this->input->post('message');
    		 $address = $this->input->post('address');
    		 $subject = "Apply For". " ".$this->input->post('subject');
             $postdata = $this->input->post() ; 
             unset($postdata['submit']);
             $postdata['create_date']= date('Y-m-d H:i:s') ;
             //Load email library 
             $this->load->library('email'); 
             $this->email->from($link[0]->from_email,$link[0]->title);
             $this->email->subject($link[0]->title.'::'.$subject);    
             $this->email->to($link[0]->email);
    		 $this->email->set_mailtype("html");
    		 $message = '<html><body>';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td colspan='2'> ".$subject." </td></tr>";
			$message .= "<tr><td><strong>Name:</strong> </td><td>" . $name . "</td></tr>";
			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $to_email . "</td></tr>";
			$message .= "<tr><td><strong>Mobile:</strong> </td><td>" . $mobile . "</td></tr>";
			$message .= "<tr><td><strong>Address:</strong> </td><td>" . $address . "</td></tr>";
			$message .= "<tr><td><strong>Message:</strong> </td><td>" . $messages . "</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
            $this->email->message($message); 
            $this->email->send();
             if( $this->db->insert('tbl_mail_info', $postdata )) {
                  $this->session->set_flashdata('msg','<div class="alert alert-success">Thank you for showing interest in our products. We shall get back to you within 24 hours.</div>');
             }else{
                  $this->session->set_flashdata('msg','<div class="alert alert-danger">Error in sending Email.</div>');
             }
             redirect('apply-for-distributorship#form');
            		
		}
		$data['RESULT'] = $this->page_model->get_page_by_id(35);
		$this->load->view('front/page',$data);

	}
	
	function international_orders()
	{
	     $link = $this->setting_model->get_all_setting();
		if(isset($_POST['name']))
		{
		
             $name = $this->input->post('name'); 
    		 $to_email = $this->input->post('email');
    		 $mobile = $this->input->post('mobile');
    		 $messages = $this->input->post('message');
    		 $address = $this->input->post('address');
    		 $subject = $this->input->post('subject');
             $postdata = $this->input->post() ; 
             unset($postdata['submit']);
             $postdata['create_date']= date('Y-m-d H:i:s') ;
             //Load email library 
             $this->load->library('email'); 
             $this->email->from($link[0]->from_email,$link[0]->title);
             $this->email->subject($link[0]->title.'::'.$subject);    
             $this->email->to($link[0]->email);
    		 $this->email->set_mailtype("html");
    		 $message = '<html><body>';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td colspan='2'> ".$subject." </td></tr>";
			$message .= "<tr><td><strong>Name:</strong> </td><td>" . $name . "</td></tr>";
			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $to_email . "</td></tr>";
			$message .= "<tr><td><strong>Mobile:</strong> </td><td>" . $mobile . "</td></tr>";
			$message .= "<tr><td><strong>Address:</strong> </td><td>" . $address . "</td></tr>";
			$message .= "<tr><td><strong>Message:</strong> </td><td>" . $messages . "</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
            $this->email->message($message); 
            $this->email->send();
             if( $this->db->insert('tbl_mail_info', $postdata )) {
                  $this->session->set_flashdata('msg','<div class="alert alert-success">Thank you for showing interest in our products. We shall get back to you within 24 hours</div>');
             }else{
                  $this->session->set_flashdata('msg','<div class="alert alert-danger">Error in sending Email.</div>');
             }
             redirect('international-orders#form');
            		
		}
		$data['RESULT'] = $this->page_model->get_page_by_id(36);
		$this->load->view('front/page',$data);

	}
	
	function bulk_orders()
	{
	    $link = $this->setting_model->get_all_setting();
		if(isset($_POST['name']))
		{
		
             $name = $this->input->post('name'); 
    		 $to_email = $this->input->post('email');
    		 $mobile = $this->input->post('mobile');
    		 $messages = $this->input->post('message');
    		 $address = $this->input->post('address');
    		 $subject = $this->input->post('subject');
             $postdata = $this->input->post() ; 
             unset($postdata['submit']);
             $postdata['create_date']= date('Y-m-d H:i:s') ;
             //Load email library 
             $this->load->library('email'); 
             $this->email->from($link[0]->from_email,$link[0]->title);
             $this->email->subject($link[0]->title.'::'.$subject);    
             $this->email->to($link[0]->email);
    		 $this->email->set_mailtype("html");
    		 $message = '<html><body>';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td colspan='2'> ".$subject." </td></tr>";
			$message .= "<tr><td><strong>Name:</strong> </td><td>" . $name . "</td></tr>";
			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $to_email . "</td></tr>";
			$message .= "<tr><td><strong>Mobile:</strong> </td><td>" . $mobile . "</td></tr>";
			$message .= "<tr><td><strong>Address:</strong> </td><td>" . $address . "</td></tr>";
			$message .= "<tr><td><strong>Message:</strong> </td><td>" . $messages . "</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
            $this->email->message($message); 
            $this->email->send();
             if( $this->db->insert('tbl_mail_info', $postdata )) {
                  $this->session->set_flashdata('msg','<div class="alert alert-success">Thank you for showing interest in our products. We shall get back to you within 24 hours.</div>');
             }else{
                  $this->session->set_flashdata('msg','<div class="alert alert-danger">Error in sending Email.</div>');
             }
             redirect('bulk-orders#form');
            		
		}
		$data['RESULT'] = $this->page_model->get_page_by_id(37);
		$this->load->view('front/page',$data);

	}

	function offer()
	{
		$data['RESULT'] = $this->offer_model->get_all_active_offer(); 
		
		$this->load->view('front/offer',$data);

	}

    function coupon()
	{
		$data['coupon'] = $this->coupon_model->get_all_active_coupon(); 
		$data['RESULT'] = $this->page_model->get_page_by_id(38);
		$this->load->view('front/coupon',$data);

	}
	
	function sitemap()
	{
		$data['RESULT'] = '';
		
		$this->load->view('front/site-map',$data);

	}



	function shipping()
	{
		$data['RESULT'] = $this->page_model->get_page_by_id(13);
		$this->load->view('front/shipping',$data);

	}
	function review()
	{
		error_reporting(0);


		$data['review'] = $this->review_model->get_all_active_review();
 
		$data['RESULT'] = $this->page_model->get_page_by_id(14);
		if(isset($_POST['submit']))
		{
			//print_r($_POST);	
		 
         $postdata = $this->input->post(); 

         	if($_FILES['image']['name'] != '' ){	


				$file_name = create_image_unique($_FILES['image']['name']);
				$tmp_name = $_FILES['image']['tmp_name'];
				$path = 'uploads/review/'.$file_name;
				move_uploaded_file($tmp_name,$path);
				$postdata['image'] = $file_name;	
		
				}

			    unset($postdata['submit']);
		        $postdata['create_date']= date('D-M-Y') ;
		        $postdata['status']= 0;
				 
		         if( $this->db->insert('tbl_review', $postdata )){
		         			 $this->session->set_flashdata('msg','<div class="alert alert-success">Your Review successfully send, Thank For your review..</div>');
		         } else{
		         	 $this->session->set_flashdata("email_sent","Error in sending ."); 
		         }
		
		}
		$this->load->view('front/review',$data);

	}

	function subscription()
	{
	
		$link = $this->setting_model->get_all_setting();
		$email = $this->input->post('email');
         //Load email library 
        $this->load->library('email'); 
        $this->email->from($link[0]->email,$link[0]->title);
		$this->email->subject($link[0]->title.':: Subscribe!');    
        $this->email->to($link[0]->email);
		$this->email->set_mailtype("html");
		 
		$message = '<html><body>';
		$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
		$message .= "<tr style='background: #eee;'><td colspan='2'>Subscribe</td></tr>";
		$message .= "<tr><td><strong>Email:</strong> </td><td>" . $email . "</td></tr>";
		$message .= "</tabl e>";
		$message .= "</body></html>";
        $this->email->message($message); 
         //Send mail 
        if($this->email->send()) {
		 
		 echo ' Thank You For Subscribe. ';
		 
		}else{
       
         echo ' Error in subscribe, please try again.'; 
        
		}

	}
	
	function mail_us()
	{
	
		$link = $this->setting_model->get_all_setting();
		$email = $this->input->post('email');
		$name = $this->input->post('name');
		$phone = $this->input->post('mobile');

         //Load email library 
        $this->load->library('email'); 
        $this->email->from($link[0]->from_email,$link[0]->title);
		$this->email->subject($link[0]->title.':: Get in touch!');    
        $this->email->to($link[0]->email);
		$this->email->set_mailtype("html");
		 
		$message = '<html><body>';
		$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
		$message .= "<tr style='background: #eee;'><td colspan='2'>Get in touch</td></tr>";
		$message .= "<tr><td><strong>Name:</strong> </td><td>" . $name . "</td></tr>";
		$message .= "<tr><td><strong>Email:</strong> </td><td>" . $email . "</td></tr>";
		$message .= "<tr><td><strong>Phone:</strong> </td><td>" . $phone . "</td></tr>";
		$message .= "</tabl e>";
		$message .= "</body></html>";
        $this->email->message($message); 
         //Send mail
         
        $postdata = $this->input->post() ;  
        $postdata['create_date']= date('Y-m-d H:i:s') ;
         $this->db->insert('tbl_mail_info', $postdata ) ; 
        if($this->email->send()) {
		 
		 echo ' Thank You For Mail us. ';
		 
		}else{
       
         echo ' Error, please try again.'; 
        
		}

	}


	public function error404()
    {
        
       
        $this->load->view('404');
       
    }

}

