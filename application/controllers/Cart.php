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
			
    private function selected_cart_product($product_id, $variation_id, $qty)
    {
        foreach (array($product_id, $variation_id, $qty) as $value) {
            if (!is_scalar($value) || !ctype_digit((string) $value) || (int) $value < 1) { return FALSE; }
        }
        $products = $this->product_model->get_product_by_id((int) $product_id);
        $variations = $this->product_model->select_product_variation_by_id((int) $variation_id);
        if (count($products) !== 1 || count($variations) !== 1) { return FALSE; }
        $product = $products[0]; $variation = $variations[0];
        if ((int) $variation->product_id !== (int) $product->id ||
            (isset($product->status) && (string) $product->status !== "1") ||
            (isset($product->delete_flag) && (string) $product->delete_flag !== "0") ||
            (int) $variation->qty < (int) $qty ||
            (!empty($product->min_order) && (int) $qty < (int) $product->min_order) ||
            (!empty($product->max_order) && (int) $qty > (int) $product->max_order)) { return FALSE; }
        $quote = $this->input->post("quoted_price");
        if ($quote !== NULL && (!is_scalar($quote) || !preg_match('/^[0-9]+(?:\\.[0-9]{1,2})?$/D', (string) $quote) ||
            (int) round((float) $quote * 100) !== (int) round($this->product_model->effective_variation_price($variation, $product) * 100))) {
            return FALSE;
        }
        return array($product, $variation);
    }

    public function add_to_cart()
    {
        $selected = $this->selected_cart_product($this->input->post("product_id"), $this->input->post("variation_id"), $this->input->post("qty"));
        if (!$selected) { $this->output->set_status_header(422); echo 0; return; }
        list($product, $variation) = $selected;
        $amount = $this->product_model->effective_variation_price($variation, $product);
        foreach ($this->cart->contents() as $item) {
            if ((int) $item["id"] === (int) $variation->id) {
                $this->cart->update(array("rowid" => $item["rowid"], "price" => $amount));
                echo count($this->cart->contents()); return;
            }
        }
        $this->cart->insert(array("id" => $variation->id, "name" => $product->title,
            "price" => $amount, "qty" => (int) $this->input->post("qty"),
            "custom_options" => array(
                "pricedata" => array("price" => $product->price, "special_price" => $product->special_price, "discount" => $product->discount),
                "cartdata" => array("size" => $variation->size, "sku" => $variation->sku))));
        echo count($this->cart->contents());
    }

    public function add_to_cart_pageload()
    {
        $selected = $this->selected_cart_product($this->input->post("id"), $this->input->post("variation_id"), $this->input->post("qty"));
        if (!$selected) {
            $this->session->set_flashdata("msg", "Please select an available product and size.");
            redirect("cart"); return;
        }
        list($product, $variation) = $selected;
        $amount = $this->product_model->effective_variation_price($variation, $product);
        foreach ($this->cart->contents() as $item) {
            if ((int) $item["id"] === (int) $variation->id) {
                $this->cart->update(array("rowid" => $item["rowid"], "price" => $amount));
                redirect("checkout/onepage"); return;
            }
        }
        $this->cart->insert(array("id" => $variation->id, "name" => $product->title,
            "price" => $amount, "qty" => (int) $this->input->post("qty"),
            "custom_options" => array(
                "pricedata" => array("price" => $product->price, "special_price" => $product->special_price, "discount" => $product->discount),
                "cartdata" => array("size" => $variation->size, "sku" => $variation->sku))));
        redirect("checkout/onepage");
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
