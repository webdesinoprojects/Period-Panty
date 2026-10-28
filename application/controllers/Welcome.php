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
		$this->load->model(array('contact_model', 'bulk_order_model'));
		$this->contact_model->initialize();
		$data = array('errors' => array(), 'values' => array(), 'notice' => $this->session->flashdata('bulk_notice'));
		if (!$this->session->userdata('bulk_token')) { $this->session->set_userdata('bulk_token', bin2hex(random_bytes(32))); }
		if ($this->input->method() === 'post') {
			$failure_status = 422;
			$token = $this->input->post('bulk_token');
			if (!is_string($token) || !hash_equals($this->session->userdata('bulk_token'), $token)) {
				$data['errors']['form'] = 'This form expired. Refresh the page and try again.';
			} elseif ($this->input->post('website') !== '') {
				$data['errors']['form'] = 'Please refresh the form and try again.';
			} elseif (time() - (int) $this->session->userdata('bulk_last_sent') < 45) {
				$data['errors']['form'] = 'Your previous enquiry was received. Please wait before sending another.';
			} else {
				$checked = $this->bulk_order_model->validate($this->input->post(NULL, FALSE));
				$data['values'] = $checked['data']; $data['errors'] = $checked['errors'];
				if (!$data['errors']) {
					$enquiry = $this->bulk_order_model->enquiry($checked['data']);
					$id = $this->contact_model->save($enquiry);
					if (!$id) {
						$data['errors']['form'] = 'We could not save your enquiry. Please try again, or call us.';
						$failure_status = 503;
					} else {
						$settings = $this->setting_model->get_all_setting();
						$accepted = $this->send_bulk_notification($enquiry, $id, $settings[0]);
						$this->contact_model->record_delivery($id, $accepted ? 'accepted' : 'failed');
						$this->session->set_userdata(array('bulk_last_sent' => time(), 'bulk_token' => bin2hex(random_bytes(32))));
						$this->session->set_flashdata('bulk_notice', array('id' => $id));
						redirect('bulk-orders#bulk-form', 'location', 303); return;
					}
				}
			}
			if ($data['errors']) { $this->output->set_status_header($failure_status); }
		}
		$data['bulk_token'] = $this->session->userdata('bulk_token');
		$this->load->view('front/bulk-orders', $data);
	}

	private function send_bulk_notification($enquiry, $id, $settings)
	{
		$recipients = array();
		foreach (array($settings->email, isset($settings->email_secondary) ? $settings->email_secondary : '') as $recipient) {
			if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) { $recipients[] = $recipient; }
		}
		if (!$recipients || !filter_var($settings->from_email, FILTER_VALIDATE_EMAIL)) { return FALSE; }
		$this->load->library('email');
		$this->email->clear(TRUE);
		$mail_config = array('mailtype' => 'text', 'charset' => 'utf-8', 'newline' => "\r\n", 'crlf' => "\r\n", 'smtp_timeout' => 10);
		if (getenv('DEXTE_SMTP_HOST')) {
			$mail_config['protocol'] = 'smtp';
			$mail_config['smtp_host'] = getenv('DEXTE_SMTP_HOST');
			$mail_config['smtp_port'] = getenv('DEXTE_SMTP_PORT') ?: 587;
			$mail_config['smtp_user'] = getenv('DEXTE_SMTP_USER') ?: '';
			$mail_config['smtp_pass'] = getenv('DEXTE_SMTP_PASS') ?: '';
			$mail_config['smtp_crypto'] = getenv('DEXTE_SMTP_CRYPTO') ?: 'tls';
		}
		$this->email->initialize($mail_config);
		$this->email->from($settings->from_email, preg_replace('/[\r\n]+/', ' ', $settings->title));
		$this->email->to(array_unique($recipients));
		if ($enquiry['email'] !== '') { $this->email->reply_to($enquiry['email']); }
		$this->email->subject('DEXTE bulk enquiry #' . $id . ': ' . $enquiry['subject']);
		$this->email->message('Reference #' . $id . "\nName: " . $enquiry['name'] . "\nPhone: " . $enquiry['mobile'] . "\nEmail: " . $enquiry['email'] . "\n\n" . $enquiry['message']);
		$accepted = $this->email->send(FALSE);
		if (!$accepted) { log_message('error', 'Bulk notification failed for enquiry #' . $id); }
		return $accepted;
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

