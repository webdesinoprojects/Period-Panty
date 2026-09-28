<?php
class Cart extends CI_Controller{
	function __construct(){
	 	parent::__construct();
	    $this->load->model('Category_model');
	    $this->load->library('cart');
	   
      }
 
	
	function index()
	{
	     error_reporting(0) ;
	    unset($_SESSION['reward_data']) ; 
		$data['CARTDATA'] = $this->cart->contents();
		$data['RESULT'] = $this->page_model->get_page_by_id(17);
		$this->load->view('front/checkout/cart',$data);
	}
			
	function add_to_cart()
	{
		if(isset($_POST) && count($_POST)>0 && !empty($_POST['product_id']))
		{
		   
			$pro_id = $_POST['product_id'];
			$pricedata= $cartdata = $offerdata =$offer_discount_data  = null;
            $error = 0 ; 
			if (count($this->cart->contents())>0){
			      foreach ($this->cart->contents() as $item){
			        if ($item['id']==$_POST['variation_id']){
			          $error = 1 ;
			        }
			      }
		    }
		    
		    if(  $error == 0){

    
    			$product_data = $this->product_model->get_product_by_id($pro_id);
    			$price = ($product_data[0]->special_price!='0.00')?$product_data[0]->special_price:$product_data[0]->price;	
    			$final_amt  = $price ;
    			
    			$pricedata  = array('price' => $product_data[0]->price,'special_price' => $product_data[0]->special_price,'discount' => $product_data[0]->discount, );
    			if(isset($_POST['variation_id'])){
    			    $variation_id = $_POST['variation_id'] ; 
    			    $variation = $this->product_model->select_product_variation_by_id($_POST['variation_id']) ; 
    			 	$cartdata =array('size'=>$variation[0]->size , 'sku'=>$variation[0]->sku) ;   
    			}else{
    			    $cartdata = array() ;
    			     $variation_id = 0 ; 
    			}
    		
    			if(count($product_data)>0)
    			{
    				
    				$insert_data = array(
    					'id' => $variation_id,
    					'name' => $product_data[0]->title,
    					'price' => $final_amt,
    				 	'qty' => $this->input->post('qty'), 
    				    'custom_options'=>array(
    				    'pricedata'=>$pricedata,
    					'cartdata'=>$cartdata)
    				);
    				
    				 $this->cart->insert($insert_data); 
    				 $cart_content = $this->cart->contents();;
    				 echo count($cart_content);
    			}
    			else
    			{
    				echo 0;
    			}	
		    }else{
		        	
		        	$cart_content = $this->cart->contents();;
    				 echo count($cart_content);
		        	
		    }
		}
		else 
		{
			echo 0;
		}	
	}


	function add_to_cart_pageload()
	{

		if(isset($_POST) && count($_POST)>0 && !empty($_POST['id']))
		{
	        $error = 0 ; 
			$pro_id = $_POST['id'];
			$variation_id = $_POST['variation_id'];
			$pricedata= $cartdata = $offerdata =$offer_discount_data  = null;
			if (count($this->cart->contents())>0){
			      foreach ($this->cart->contents() as $item){ 
			        if ($item['id']==$_POST['variation_id']){
			          $error = 1 ;
			        }
			      }
		    }
		    
		    if(empty($error)){
    			$product_data = $this->product_model->get_product_by_id($pro_id);
    			$price = ($product_data[0]->special_price!='0.00')?$product_data[0]->special_price:$product_data[0]->price;	
    			$final_amt  = $price ;
    			$pricedata  = array('price' => $product_data[0]->price,'special_price' => $product_data[0]->special_price,'discount' => $product_data[0]->discount);
    		
	        	if(isset($_POST['variation_id'])){
    			    $variation_id = $_POST['variation_id'] ; 
    			    $variation = $this->product_model->select_product_variation_by_id($_POST['variation_id']) ; 
    			 		$cartdata =array('size'=>$variation[0]->size , 'sku'=>$variation[0]->sku) ; 
    			}else{
    			    $cartdata = array() ;
    			     $variation_id = 0 ; 
    			}
				
				$insert_data = array(
					'id' => $variation_id,
					'name' => $product_data[0]->title,
					'price' => $final_amt,
				 	'qty' => $this->input->post('qty'), 
				    'custom_options'=>array(
				    'pricedata'=>$pricedata,
					'cartdata'=>$cartdata)
				);
		
				$this->cart->insert($insert_data); 
				$cart_content = $this->cart->contents();
				redirect('checkout/onepage');
    		
		    }else{
		        redirect('checkout/onepage');
		    }
		}	
	}
	
	function update()
	{
	    
	  
			if(count($_POST['rowid'])>0)
			{
				foreach($_POST['rowid'] as $key => $value)
				{
					
						$data= array('rowid' =>$_POST['rowid'][$key], 'qty' =>$_POST['qty'][$key]);
						$this->cart->update($data);
				
				}
			}
			redirect('cart/');
		
	}
	
	function empty_cart()
	{
		$this->session->unset_userdata('coupon_data'); 				
		$this->cart->destroy();
	
		redirect('welcome');
	}

	function remove_cart_item()
	{   
		$args = func_get_args();
		$cart =  $this->cart->contents() ; 
		$row_id = $args[0] ;
        $data = array('rowid'=> $args[0],'qty'=> 0);
        $this->cart->update($data);
        $this->session->unset_userdata('coupon_data');
		redirect('cart');
	}

	function add_to_whislist(){

		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id))
		{				
			$response['error']=1;
			$response['msg'] = 'Please Login/Sign Up';
		}
		else
		{
		     $postdata['product_id'] =$product_id= $_POST['product_id'];
			$postdata['user_id'] =$user_id;
		     $count =  $this->db->get_where('tbl_wishlist' , array('product_id'=> $product_id ,'user_id'=> $user_id ) )->num_rows() ;
		    if($count == 0 ){ 
		
			$this->db->insert('tbl_wishlist' ,$postdata ) ; 
			
		    }
			
            $response['error']=0;
		}

		echo json_encode($response);
        die;
	}
	
}
