<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('order_model');
	}
	

	public function index($value=''){

        error_reporting(0);
    	$user_id = $this->session->userdata('USER_ID');$email='';
		$userdata = $this->user_model->get_user_by_id($user_id);
	 	if(!empty($user_id)){ 
 		     $_SESSION['redirect']   = 'checkout/onepage' ; 
 		}else{
 		    
 		   $email= $userdata[0]->email ; 
 		}
        $order = $this->order_model->get_order_data_by_order_no($this->uri->segment(2)) ;
        if($order){
    		$shipping =	$shipping =$this->order_model->get_shipping_data($order[0]->id);
    		$data['amount'] =$order[0]->final_amount;
    		$data['item_number'] = $order[0]->order_no;
    		$data['address'] = $shipping[0]->saddress;
        	$data['name'] = $shipping[0]->sfname.' '.$shipping[0]->slname;
        	$data['email'] =$email ;
        	$data['phone'] =$shipping[0]->scontact_no;
        	$data['return_url'] = base_url().'payment/callback';
        	$data['surl'] = base_url().'payment/success/'. $order[0]->order_no;
        	$data['furl'] = base_url().'payment/failed/'. $order[0]->order_no;
           	$data['currency_code'] = 'INR';
           	$_SESSION['caporderid'] = $data['item_number'] ; 
            $this->load->view('front/razorpay' ,$data) ;
        }else{
            redirect('home') ; 
        }
            
    }

    private function get_curl_handle($payment_id, $amount)  {
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id = RAZOR_KEY_ID;
        $key_secret = RAZOR_KEY_SECRET;
        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
       
        return $ch;
    }   
        
    public function callback() {        

        // error_reporting(0); 
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
           $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {                
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    echo$error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                    
                  
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
              
            if ($success === true) {
                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                 }
                 
                $update_data['status']='Placed' ;
			    $update_data['payment_status']='Paid' ;
			    $update_data['transaction_no']=$razorpay_payment_id ;
			    $this->db->where('order_no',$merchant_order_id);
				$this->db->update('tbl_order', $update_data);
				$order = $this->order_model->get_order_data_by_order_no($merchant_order_id) ; 
				$this->order_mail_template($order[0]->id);				
		     	$this->order_mail_template_to_admin($order[0]->id);	     
		     	$this->stockManagement($order[0]->id);	
		     	$user_id = $this->session->userdata('USER_ID');
                 redirect($this->input->post('merchant_surl_id'));

 
            } else {
               $update_data['payment_status']='Unpaid' ;
               $update_data['transaction_no']=$razorpay_payment_id ;
			   $this->db->where('order_no',$merchant_order_id);
		       $this->db->update('tbl_order', $update_data);  
              redirect($this->input->post('merchant_furl_id'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }

       
    } 
	
    public function success() {

         if(isset($_SESSION['caporderid'])){

    	  	$data['order_data'] = $this->order_model->get_order_data_by_order_no($this->uri->segment(3)) ; 
			$this->load->view('front/checkout/success',$data); 
         }else{

            redirect() ; 
        }

    }  

    public function failed() {

         error_reporting(0) ; 
         if(isset($_SESSION['caporderid'])){

         	$data['order_data'] = $this->order_model->get_order_data_by_order_no($this->uri->segment(3)) ; 
			$this->load->view('front/checkout/failed',$data); 

         }else{

            redirect() ; 
        }    
    }    

	function order_mail_template($ord_id)
	{
		$link = $this->setting_model->get_all_setting(); 
		$user_id = $this->session->userdata('USER_ID');
		$data['ORDER'] =$order = $this->order_model->get_order_data($ord_id);
		$data['USER'] = $this->user_model->get_user_by_id($order[0]->user_id);
     	$htmlContent = $this->load->view('front/mail/order-template',$data, TRUE);
		$this->load->library('email');
	
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");				
		$this->email->to(trim($data['USER'][0]->email));
		$this->email->from($link[0]->from_email,$link[0]->title);
		$this->email->subject('Order Confirm');
		$this->email->message($htmlContent);				
		$this->email->send();	
		 
	}
	
    function order_mail_template_to_admin($ord_id)
	{
		$user_id = $this->session->userdata('USER_ID');
		$link = $this->setting_model->get_all_setting(); 
		$data['ORDER'] =$order = $this->order_model->get_order_data($ord_id);
		$data['USER'] = $this->user_model->get_user_by_id($order[0]->user_id);
  		$htmlContent = $this->load->view('front/mail/order-template',$data, TRUE);
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");				
		$this->email->to(trim($link[0]->email));
		$this->email->from($link[0]->from_email,$link[0]->title);
		$this->email->subject('Order Confirm Mail To Admin');
		$this->email->message($htmlContent);				
		$this->email->send();
			
		
	}
	
	function stockManagement($order_id)
	{
      
		$items_data = $this->order_model->get_item_data($order_id);
	
		foreach($items_data as $item)
		{
			$this->manage_stock($item->pro_id,$item->qty);
		}
	}
	
	function manage_stock($id,$qty)
	{
		$pro = $this->product_model->get_product_by_id($id);
		if($pro[0]->qty>0)
		{	
			$upd_data['qty'] = $pro[0]->qty-$qty;
			$this->product_model->update_product_by_id($pro[0]->id, $upd_data);
		}	
	}
	
}
