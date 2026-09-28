<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller
{
    
    public function onepage()
	{	 
	    error_reporting(0) ;
	    unset($_SESSION['payment_method_disc']) ;
	    unset($_SESSION['shipping_charges']) ;
		if(count($this->cart->contents())==0){ redirect('cart'); }
		$user_id = $this->session->userdata('USER_ID');
	
		$data['RESULT'] = $this->page_model->get_page_by_id(17);
		$data['country'] = $this->db->get("countries")->result() ; 
		$data['state'] = $this->db->get_where("states",array('country_id'=>101))->result();
		if(!$user_id){
		    $_SESSION['redirect'] = 'checkout/onepage/' ; 
		    $this->load->view('front/checkout/checkout-login',$data);
		}else{
		    $this->load->view('front/checkout/checkout',$data);
		}
		
	}

	
	function checkout_process(){
	    error_reporting(0) ;
	    $user_id=0;
		$user_id = ($this->session->userdata('USER_ID'))?$this->session->userdata('USER_ID') :0 ; ;
		$data['user'] =null;

		if(count($this->cart->contents())==0){ redirect('cart'); }
		$_SESSION['checkout_data'] =  $_POST ;
		if(($_POST['payment_method'] =='Pay On Delivery') && (empty($user_id))){
		   
	         redirect('checkout/checkout_process_insert_data') ; 
		    
		}else{
		    
		     redirect('checkout/checkout_process_insert_data') ; 
		}
		
	    
	}
	
	function checkout_process_insert_data(){
	    $user_id=0;
		$user_id = ($this->session->userdata('USER_ID'))?$this->session->userdata('USER_ID') :0 ; ;
		$data['user'] =$data['rewards']=null;
		if(count($this->cart->contents())==0){ redirect('cart'); }
	    if(isset($_SESSION['checkout_data'] ['sfname']))
		{
			$order_data = $this->get_amount_array();
			$used_reward_point='';
			if($user_id){
			   	$ord_data['user_type'] = 'Logged';
			   	$ord_data['user_id'] = $user_id;
    			$ord_data['coupon_data'] = $order_data['coupon_data'];
    			$couponData =  json_decode($order_data['coupon_data']);	
    			if($couponData){
    			$ord_data['couponCode'] = $couponData->title;	
    			}
    			
    			
			}else{
			     	$ord_data['user_type'] = 'Guest';
			}
		
			$ord_data['cart_offer_data'] = $order_data['cart_offer_data'];
			$ord_data['payment_disc_data'] = $order_data['payment_disc_data'];
			$ord_data['sub_total_amount'] = $order_data['total_amount'];
			$ord_data['cart_discount_amount'] = $order_data['cart_discount_amount'];
			$ord_data['total_amount'] = $order_data['total_amount'];
			$ord_data['shipping_charge'] = $order_data['shipping_charge'];
			$ord_data['discount_amount'] = $order_data['discount_amount'];
			$ord_data['payment_method_disc_amt'] = $order_data['payment_method_disc_amt'];
			$ord_data['final_amount'] = $order_data['final_amount']; 
			$ord_data['status'] = 'Pending';
			$ord_data['create_date'] = date('Y-m-d h:i:s A');
			$ord_data['payment_method'] = $_SESSION['checkout_data'] ['payment_method'];
			
			$ord_data['year'] = date('Y');
			$ord_data['order_no'] =$order_no= $this->create_invoice_no() ;
			$order_id = $this->order_model->save_order($ord_data);
			$this->save_item_data($order_id, $user_id);
			$this->save_billing_data($order_id, $user_id);
			$this->save_shipping_data($order_id, $user_id);
			if($user_id){
			   	$this->update_user_data($order_id, $user_id); 
			}
    	   $this->empty_cart() ; 
    	   
           $order = $this->order_model->get_order_data_by_order_no($order_no) ; 
			if($_SESSION['checkout_data'] ['payment_method'] =='Pay Online'){
				redirect('order-payment-process/'.$order_no);
			}else{
			    $update_data['payment_method'] = 'Pay On Delivery';
			    $update_data['status']='Placed' ;
			    $update_data['payment_status']='Unpaid' ;
			    $this->db->where('order_no',$order_no);
				$this->db->update('tbl_order', $update_data);
				$this->stockManagement($order_id);
                if($user_id){
	      	 	$this->order_mail_template($order_id);
	      		}
	          $this->order_mail_template_to_admin($order_id);
	        	unset($_SESSION['checkout_data']) ;	
		      redirect('success/'.$order_no);	

			}
			
		}else{
		     redirect('checkout/onepage') ; 
		}
	}

    
	function  guest_login(){
	    
	    $_SESSION['user_session'] = $gen_refer_code   = substr(md5(rand(100, 2147483647)), 0, 15);
	    $_SESSION['guest'] = 'start';
	    redirect('checkout/onepage') ; 
	}

	
	function create_invoice_no(){
	    
	    $year = date("Y") ; 
	     $total_order = $this->db->get_where('tbl_order' ,array('year'=>$year ))->num_rows();

	    if($total_order == 0 ){
	        $order_no = 1 ; 
	    }else{
	       $order_no =  $total_order + 1 ; 
	    }
	    $length =    strlen((string)$order_no);
	    $remain_length = 6-$length;
	    $var ='';
	    for($i=0 ; $i < $remain_length ; $i++){
	        
	        $var .=  "0" ; 
	    }
	    return 'DEXTE'.date('Y').$var.$order_no ; 
	    
	}
	  
	function stockManagement($order_id)
	{
      
		$items_data = $this->order_model->get_item_data($order_id);
	
		foreach($items_data as $item)
		{
			$this->manage_stock($item->pro_id,$item->variation_id,$item->qty);
		}
	}

	function manage_stock($id,$variation_id,$qty)
	{
		$pro = $this->product_model->get_product_by_id($id);
		if($pro[0]->qty>0)
		{	
			$upd_data['qty'] = $pro[0]->qty-$qty;
			$this->product_model->update_product_by_id($pro[0]->id, $upd_data);
		}
		$vary = $this->product_model->select_product_variation_by_id($variation_id);
		if($vary[0]->qty>0)
		{	
			$upd_data['qty'] = $vary[0]->qty-$qty;
			$this->product_model->update_product_variation_by_id($variation_id, $upd_data);
		}	
	}
	
	function empty_cart()
	{
		$this->session->unset_userdata('coupon_data'); 				
		$this->session->unset_userdata('payment_method_disc'); 				
		$this->session->unset_userdata('shipping_charges'); 				
		$this->cart->destroy();
	}
	
	function save_item_data($order_id, $user_id)
	{
		foreach($this->cart->contents() as $item)
		{
		    $variation_data = $this->product_model->select_product_variation_by_id($item['id']) ;
			$item_data['order_id'] = $order_id;
			$item_data['user_id'] = $user_id;
			$item_data['pro_id'] = $variation_data[0]->product_id;
			$item_data['variation_id'] = $item['id'];
			$item_data['item'] = $item['name'];
			$item_data['price'] = $item['price'];
			$item_data['qty'] = $item['qty'];
			$item_data['sub_total'] = $item['subtotal'];
			$item_data['custom_options'] = $this->get_custom_option($item['custom_options']);
			$this->order_model->save_order_item($item_data);
		}
	}
	
	function get_custom_option($op)
	{
		if(is_array($op) && count($op)>0)
		{
			return json_encode($op);
		}
		else
		{
			return '';
		}	
	}
	
	function save_billing_data($order_id, $user_id)
	{
		$bill_data['order_id'] = $order_id;
		$bill_data['user_id'] = $user_id;
		if($_SESSION['checkout_data']['bfname']){
		  $bill_data['fname'] = $_SESSION['checkout_data']['bfname'];    
		}else{
		  $bill_data['fname'] = $_SESSION['checkout_data']['sfname'] ;
		}
		if($_SESSION['checkout_data']['baddress'] ){
		  $bill_data['address'] = $_SESSION['checkout_data']['baddress']  ;    
		}else{
		  $bill_data['address'] = $_SESSION['checkout_data']['saddress']  ;
		};
		$bill_data['phone'] = (!   empty($_SESSION['checkout_data']['bcontact_no'])?$_SESSION['checkout_data']['bcontact_no']:$_SESSION['checkout_data']['scontact_no']);
		$bill_data['city'] = (!   empty($_SESSION['checkout_data']['bcity'])?$_SESSION['checkout_data']['bcity']:$_SESSION['checkout_data']['scity']);
		$bill_data['state'] = (!   empty($_SESSION['checkout_data']['bstate'])?$_SESSION['checkout_data']['bstate']:$_SESSION['checkout_data']['sstate']);
		$bill_data['country'] = (!   empty($_SESSION['checkout_data']['bcountry'])?$_SESSION['checkout_data']['bcountry']:$_SESSION['checkout_data']['scountry']);
		$bill_data['pincode'] = (!   empty($_SESSION['checkout_data']['bpincode'])?$_SESSION['checkout_data']['bpincode']:$_SESSION['checkout_data']['spincode']);
		$bill_data['landmark'] = (!   empty($_SESSION['checkout_data']['blandmark'])?$_SESSION['checkout_data']['blandmark']:$_SESSION['checkout_data']['slandmark']);
		$this->order_model->save_billing_data($bill_data);	
	}

	function update_user_data($order_id, $user_id)
	{
	
		$bill_data['fname'] = $_SESSION['checkout_data']['sfname']; 
		$bill_data['lname'] = $_SESSION['checkout_data']['slname']; 
		$bill_data['contact_no'] = $_SESSION['checkout_data']['scontact_no']; 
		$bill_data['country'] = $_SESSION['checkout_data']['scountry']; 
		$bill_data['address'] = $_SESSION['checkout_data']['saddress'];
		$bill_data['city'] = $_SESSION['checkout_data']['scity'];
		$bill_data['state'] = $_SESSION['checkout_data']['sstate'];
		$bill_data['pincode'] = $_SESSION['checkout_data']['spincode'];
		$bill_data['landmark'] = $_SESSION['checkout_data']['slandmark'];
		$this->db->where('id', $user_id);
		$this->db->update('tbl_users', $bill_data);
	}
	
	function save_shipping_data($order_id, $user_id)
	{
		$ship_data['order_id'] = $order_id;
		$ship_data['user_id'] = $user_id;
		$ship_data['fname'] = $_SESSION['checkout_data']['sfname']; 
		$ship_data['lname'] = $_SESSION['checkout_data']['slname']; 
		$ship_data['phone'] = $_SESSION['checkout_data']['scontact_no']; 
		$ship_data['address'] =$_SESSION['checkout_data']['saddress'];
		$ship_data['city'] = $_SESSION['checkout_data']['scity'];
		$ship_data['state'] =$_SESSION['checkout_data']['sstate'];
		$ship_data['pincode'] =$_SESSION['checkout_data']['spincode'];
		$ship_data['country'] =$_SESSION['checkout_data']['scountry']; 
		$ship_data['landmark'] = $_SESSION['checkout_data']['slandmark'];
		$this->order_model->save_shipping_data($ship_data);	
	}
	
	function apply_cart_offer(){
	    
	     // Buy any 2 products get 10%
        //  Buy any 3 products get 15%
        //  Buy 4 products or more get 18%
        $cart_discount_per =$sum= 0;$cart_discount_title='' ; $cart_discount = array() ;
        foreach($this->cart->contents() as $item)
		{
			$sum = $sum + $item['qty'];
		}
		
         $cart_product = $sum;
        if($cart_product == 2 ){
            $cart_discount_per = 10; 
            $cart_discount_title =  'Buy any 2 products get 10% Off'; 
            $cart_discount =   array('title' => $cart_discount_title ,'discount' => $cart_discount_per , ); 
        }else if($cart_product == 3 ){
            $cart_discount_per = 15; 
            $cart_discount_title =  'Buy any 3 products get 15% Off'; 
            $cart_discount =   array('title' => $cart_discount_title ,'discount' => $cart_discount_per , ); 
        }else if($cart_product >= 4){
            $cart_discount_per = 18; 
            $cart_discount_title =  'Buy 4 products or more get 18% Off'; 
            $cart_discount =   array('title' => $cart_discount_title ,'discount' => $cart_discount_per , ); 
        }
        
       
        return $cart_discount ; 
	}
	
	function get_amount_array()
	{
	    $payment_method_disc_amt=0;
        $cart_discount_amt = 0;
        $discount_amount = 0;
        $sub_total_amount = 0;
		$coupon_data = '';
		$payment_disc_data = '';
		$cart_offer_data = '';
		$shipping_charge = 0 ;
		$coupon = $this->session->userdata('coupon_data');
		$link=$this->setting_model->get_all_setting();
		$sub_total_amount = $this->cart->total();
		$cart_discount = $this->apply_cart_offer() ;
		
		if(count($cart_discount) > 0){
		    	$cart_discount['discount_amount'] = $cart_discount_amt = round($sub_total_amount*$cart_discount['discount']/100) ; 
        		$cart_offer_data = json_encode($cart_discount) ;
                $total_amount = $sub_total_amount  -   $cart_discount_amt; 
		}else{
		     $total_amount = $sub_total_amount; 
		}
	
   
		if(isset($_SESSION['shipping_charges'])){
		    
		    	$shipping_charge = $_SESSION['shipping_charges'];
		}
		if(!empty($coupon) && is_array($coupon)){
			$discount_amount= $coupon['deduction'];
			$coupon_data = json_encode($coupon);
		}
		
		$total = $total_amount + $shipping_charge;
	
	    
	    if(isset($_SESSION['payment_method_disc'])){
	        $method_discount =   array('title' =>$link[0]->online_discount_title ,'discount' =>$link[0]->online_discount ); 
		    $method_discount['discount_amount'] = $payment_method_disc_amt =  round ($total*$method_discount['discount']/100 );  
            $total = $total  -   $payment_method_disc_amt; 
            $payment_disc_data = json_encode($method_discount) ; 
		}
		
		$data = array(
		    'sub_total_amount'=>$sub_total_amount,
		    'total_amount'=>$total_amount,
		    'shipping_charge' => $shipping_charge,
		    'discount_amount'=>$discount_amount,
		    'cart_discount_amount'=>$cart_discount_amt,
		    'payment_method_disc_amt'=>$payment_method_disc_amt,
		    'final_amount'=>$total,
		    'coupon_data'=>$coupon_data,
		    'cart_offer_data'=>$cart_offer_data , 
		    'payment_disc_data'=>$payment_disc_data , 
		);
		return $data;
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
	
	function success($a)
	{
		$data['order_data'] = $this->order_model->get_order_data_by_order_no($this->uri->segment(2)) ; 
		$this->load->view('front/checkout/success',$data); 
	}

	function apply_coupon()
	{ 
	    $response['error']=0;
		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id))
		{
			$response['error']=1;
			$response['msg'] = 'In order to avail the benefits of this promotional / voucher code, please Login/Sign Up.';
			echo json_encode($response);
		}
		
		if(isset($_POST) && !empty($_POST['coupon']))
		{
			$coupon = $_POST['coupon'];
			$couponData	= $this->coupon_model->get_coupon_by_couponCode($coupon); 
			if(count($couponData)>0) // check coupon code in databse
			{
			     $todaydate=  date('Y-m-d');
				 $activate_date = 	$couponData[0]->enableDate;
				 $deactivate_date = 	$couponData[0]->disableDate;
			
				if($todaydate > $deactivate_date ){ // To check accountdeactiavtion date
				     $response['error']=1;
		             $response['msg'] = 'Coupon Code Expire.</b>';
		            
				}
				if($todaydate < $activate_date ){ // To check account actiavtion date
				     $response['error']=1;
		             $response['msg'] = 'In order to avail the benefits of this promotional / voucher code, please wait till <b>'.date('d/M/Y' ,strtotime($activate_date)) .'</b>';
		             
				 }
				if($response['error']==0){ 
                    $noOFUse =  $this->coupon_model->checkCouponUsedByUser($coupon ,$user_id ) ;
                    $userorder =  $this->order_model->total_order_of_user($user_id ) ;
                    $CoupoCodeTimes =  $couponData[0]->CoupoCodeTimes ; 
                    $time =  $couponData[0]->time ; 
                    if($CoupoCodeTimes == '1'){ // First Order
                        
                        if($userorder >  0 ){
                            $response['msg'] = '<p style="color:red">Error! This Coupon Use Only First Order </p>';
    						$response['error']=1;
    						   
                        }
                        
                    }else if($CoupoCodeTimes == '2'){ // One Time Coupon Code
                        
                        if($noOFUse >  0 ){
                            $response['msg'] = '<p style="color:red">You Already Use This Coupon Code</p>';
    						$response['error']=1;
    					
                        }
                        
                    }else if($CoupoCodeTimes == '3'){ // define no of use
                        
                        if($time <= $noOFUse ){
                            $response['msg'] = '<p style="color:red">You Already Use This Coupon Code</p>';
    						$response['error']=1;
    					
                        }
                        
                        
                    }
                    if($response['error'] != 1){
                       $response = $this->applyCouponCode($couponData) ;  
                    }
				}
			}
			else
			{
				$response['msg'] = '<p style="color:red">Invalid Coupon Code</p>';
				$response['error']=1;
			}	
		}else	{
			$response['msg'] = '<p style="color:red">Enter Coupon Code</p>';
			$response['error']=1;
		}

		echo json_encode($response);

         die;
	} 
	
	function applyCouponCode($couponData){
	    
	    $CoupoCodeCriteria = $couponData[0]->CoupoCodeCriteria ; 
	    if($CoupoCodeCriteria == '1' ){ 
	        $cartTotal =   $this->cart->total();
	        if($couponData[0]->type == 'Percentage'){
                   $discount = $cartTotal*$couponData[0]->amount/100;
                }else{
                   $discount = $couponData[0]->amount; 
	         }
	        $data = [
        		'couponCode'=>$couponData[0]->couponCode,
        		'title'=>$couponData[0]->title,
        		'type'=>$couponData[0]->type,
        		'amount'=>$couponData[0]->amount,
        		'deduction'=>$discount,
    		];
    		$_SESSION['coupon_data'] = $data ;
    	    $response['coupon_html']= $this->order_total_html() ; 
    		$response['msg']= '<p style="color:green">Applied Successfully</p>'; 
    		$response['error']= 0;
	        
	    }else if($CoupoCodeCriteria == '2'){
	       
	      $order_value = $couponData[0]->order_value  ;  
	      $cartTotal =   $this->cart->total(); 
	      if($order_value <= $cartTotal){
	            if($couponData[0]->type == 'Percentage'){
	                   $discount = $cartTotal*$couponData[0]->amount/100;
	                }else{
	                   $discount = $couponData[0]->amount; 
	            }
    	        $data = [
            		'couponCode'=>$couponData[0]->couponCode,
            		'title'=>$couponData[0]->title,
            		'type'=>$couponData[0]->type,
            		'amount'=>$couponData[0]->amount,
            		'deduction'=>$discount,
        		];
        		$_SESSION['coupon_data'] = $data ;
        	    $response['coupon_html']= $this->order_total_html() ; 
        		$response['msg']= '<p style="color:green">Applied Successfully</p>'; 
        		$response['error']= 0;
	          
	      }else{
	          	$response['msg']= '<p style="color:green">Not Applied, Your Order amount is less than<br> Rs. '.$order_value.'</b></p>'; 
    		    $response['error']= 0;
	      }
	        
	    }else if($CoupoCodeCriteria == '3'){
	       
	        $categoryArray= $this->getAllCategory($couponData[0]->category_refid) ; 
	        $res =  $this->check_all_cart_product_category($categoryArray);
	        if($res['error'] == 1){
	            
	            $response['msg']= '<p style="color:green">Not applied for this category.</p>'; 
    		    $response['error']= 0;
	            
	        }else{
	                if($couponData[0]->type == 'Percentage'){
	                   $discount = $res['subtotal']*$couponData[0]->amount/100;
	                }else{
	                   $discount = $couponData[0]->amount; 
	                }
	                $data = [
                		'couponCode'=>$couponData[0]->couponCode,
                		'title'=>$couponData[0]->title,
                		'type'=>$couponData[0]->type,
                		'amount'=>$couponData[0]->amount,
                		'deduction'=>$discount,
            		];
            		$_SESSION['coupon_data'] = $data ;
            	    $response['coupon_html']= $this->order_total_html() ; 
            		$response['msg']= '<p style="color:green">Applied Successfully</p>'; 
            		$response['error']= 0;
            		
	        }
	        
	    }
       
	   return 	$response ; 
		    
	}
	
	public function order_total_html(){
	    
    	$order_data = $this->get_amount_array();
    	$html  =  '<div class="d-flex justify-content-between total"><p>Subtotal</p><p>'.CURRENCY_SYMBOL.' '.$this->cart->format_number($order_data['sub_total_amount']).'</p> </div>'; 
    	
    	if($order_data['cart_discount_amount']){
    	        $cart_offer_data=   json_decode($order_data['cart_offer_data']);
    	       	$html  .=  '<div class="d-flex justify-content-between total"><p>  '.$cart_offer_data->title.' </p><p>'.CURRENCY_SYMBOL.' '.$this->cart->format_number($order_data['cart_discount_amount']).'</p> </div>';
    	      
    	        $html  .=  '<div class="d-flex justify-content-between total"><p>Total</p><p>'.CURRENCY_SYMBOL.' '.$this->cart->format_number($order_data['total_amount']).'</p> </div>'; 
    	}
    	
    	
    	if($order_data['shipping_charge']){
    	    	$html  .=  '<div class="d-flex justify-content-between total"><p>COD Shipping Charges</p><p>'.CURRENCY_SYMBOL.' '.$this->cart->format_number($order_data['shipping_charge']).'</p> </div>';
    	}
    	if($order_data['discount_amount']){
    	        $coupon_data=   json_decode($order_data['coupon_data']);
    	        if($coupon_data->type == 'Percentage'){
    	            $type=$coupon_data->type;
    	             $a =  "%" ; 
    	        }else{
    	              $a =  "Rs Flat" ; 
    	        }
    	       	$html .=  '<div class="d-flex justify-content-between total"><p>Discount '.$coupon_data->amount.' '. $a.'</p><p>'.CURRENCY_SYMBOL.' '.$this->cart->format_number($order_data['discount_amount']).'</p> </div>';
    	        $html .=  '<div class="d-flex justify-content-between total"><p> <b> '.$coupon_data->couponCode.' </b> Coupon Applied  <a href="javascript:void(0)" onclick="remove_coupon()" style="color:red">Remove</a></p></div>' ;
    	     
    	}
    
    	if($order_data['payment_method_disc_amt']){
    	       $payment_disc_data=   json_decode($order_data['payment_disc_data']);
    	       $html .=  '<div class="d-flex justify-content-between total"><p>'.$payment_disc_data->title.' </p><p>'.CURRENCY_SYMBOL.' '.$this->cart->format_number($order_data['payment_method_disc_amt']).'</p></div>';
    	     
    	}
        $html  .=  '<div class="d-flex justify-content-between total"><p><b>Total Payble Amount </b></p><p><b>'.CURRENCY_SYMBOL.' '.$this->cart->format_number($order_data['final_amount']).'</b></p> </div>'; 
        return $html ; 
	}
	
	public function print_cart_value(){
	    $response['coupon_html']= $this->order_total_html() ; 
        echo json_encode($response);
        die;
	}
	
	function  remove_coupon(){

	    unset( $_SESSION['coupon_data']) ; 
	    $response['coupon_html']= $this->order_total_html() ; 
		$response['msg']= '<p style="color:green">Removed Successfully</p>'; 
		$response['error']= 0;
		echo json_encode($response);
        die;
	    
	}

	public function check_all_cart_product_category($categoryArray){
	    $response['error']= 0;
		$CARTDATA = $this->cart->contents();
		foreach($CARTDATA as $item){
			$pro = $this->product_model->get_product_by_id($item['id']);
			$product_category_id = $pro[0]->cat_id ; 
			if(in_array($product_category_id ,$categoryArray )){
			     $response['subtotal']= $item['subtotal']; 
    		     $response['error']= 0;
			}else{
			    $response['error']= 1;
			}
			return $response;
		}
	    
	}
	
	public function getAllCategory($category_refid){
	    $categoryArray = explode('@' ,$category_refid ) ; 
	    foreach($categoryArray as $key => $value){
	        
	         $subcategory = $this->category_model->get_all_child_category_by_parent_id($value);
		  
			if(count($subcategory ) ) {
					foreach ($subcategory as $key => $value) {
						$categoryArray[$key+1] = $value->id ; 
					}
			}
	        
	    }
	    
	    return $categoryArray ; 
	}
	
    	
	function payment_method_off(){
	    
	    $payment_method = $_POST['payment_method'] ;     
	    $link=$this->setting_model->get_all_setting();
	    if($payment_method == 'Pay Online'){
	        
        	 $_SESSION['payment_method_disc'] = $link[0]->online_discount ;
        	 unset($_SESSION['shipping_charges']) ; //unset payment_method_discount
    	 
	    }else{
    
            $_SESSION['shipping_charges'] = $link[0]->cod_shipping_charges ;
	        unset($_SESSION['payment_method_disc']) ; //unset payment_method_discount
	    }
	    
        $response['html']= $this->order_total_html() ; 
        $response['error']= 0;
        echo json_encode($response);
        die;
	}
	
}
