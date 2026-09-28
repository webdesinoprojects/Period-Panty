<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
     function __construct(){

		parent::__construct();
		$admin_id = $this->session->userdata('ADMIN_ID');
	    $this->load->library('upload');
		$this->load->helper('string');
		$this->load->library('image_lib');
		if (empty($admin_id)){ redirect('admin');}
		$this->load->library('form_validation');

	}
    public function listing(){
		$data['RESULT'] = $this->product_model->get_all_product();
		$this->load->view('admin/product/listing', $data);
	}
	
	public function stock(){
		$data['RESULT'] = $this->product_model->get_all_stock_product();
		$this->load->view('admin/product/stock', $data);
	}
	
    public function add_new(){
		if (isset($_POST['submitform']))
		{
		$this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required|is_unique[tbl_products.url_slug]');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('color', 'Color', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
		if ($this->form_validation->run() == TRUE){

			$postdata = $this->input->post();
			$postdata['product_code'] = substr(md5(rand(100, 2147483647)), 0, 15);
			unset($postdata['submitform']);
			$postdata['create_date'] = date('Y-m-d h:i:s');
			$position = $postdata['position'];
			$img_tag = $postdata['img_tag'];
			unset($postdata['position']);
			unset($postdata['img_tag']);
		    $size =  $postdata['size'] ; unset($postdata['size']) ; 
		    $sku =  $postdata['sku'] ; unset($postdata['sku']) ; 
		    $qty =  $postdata['qty'] ; unset($postdata['qty']) ;
		    $stock  = 0 ;     	
			foreach($qty as $key => $value){
			    $stock = (int)$value + $stock ; 
			    
			}
			$postdata['qty'] = $stock;
		    $this->product_model->save_product($postdata);
		    $product_id = $this->db->insert_id();
			$stock  = 0 ;     	
			foreach($size as $key => $value){
			    $varrydata['size'] =  $value; 
			    $varrydata['sku'] =  $sku[$key] ; 
			    $varrydata['qty'] =  $qty[$key] ; 
			    $varrydata['product_id']= $product_id;
			    $this->db->insert('tbl_product_variation' , $varrydata) ; 
			}
			if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
			{
			        $upload_files = $this->upload_files();
					$img_data['product_id']= $product_id;
					foreach ($upload_files['uploaded_data'] as $key => $value) {
						$img_data['image']= $value['file_name'];				
						$img_data['img_tag']= $img_tag[$key];				
						$img_data['position']= $position[$key];				
						$img_data['thumb_image']= $value['raw_name']."_thumb".$value['file_ext'];
						$this->product_model->save_product_images($img_data);
					}
			}


			$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully saved.</div>');
			redirect('admin/product/listing');
			}
		  $msg =  "<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>";
		  $this->session->set_flashdata('msg', $msg);
		}
		$data['CATEGORY'] = $this->category_model->get_all_category();
		$this->load->view('admin/product/add', $data);

	}
	
	public function edit(){
		$args = func_get_args();
	    $data['RESULT'] = $this->product_model->get_product_by_id($args[0]);
		if (isset($_POST['submitform']))
		{
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE)
				{
					$postdata = $this->input->post();
					if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
					{
						$position = $postdata['position'];
				  		$img_tag = $postdata['img_tag'];
						$upload_files = $this->upload_files();
						$img_data['product_id']= $args[0];
						foreach ($upload_files['uploaded_data'] as $key => $value) {

							$img_data['image']= $value['file_name'];
							$img_data['img_tag']= $img_tag[$key];				
							$img_data['position']= $position[$key];				
							$img_data['thumb_image']= $value['raw_name']."_thumb".$value['file_ext'];
							$this->product_model->save_product_images($img_data);
						}


						unset($postdata['position']);
						unset($postdata['img_tag']);
					
					}
					unset($postdata['submitform']);
				    $stock = 0 ; 
					if(isset($postdata['size'])){
					    	$size =  $postdata['size'] ; unset($postdata['size']) ;  
        		            $sku =  $postdata['sku'] ; unset($postdata['sku']) ;  
        		            $qty =  $postdata['qty'] ; unset($postdata['qty']) ; 
        		            foreach($size as $key => $value){
                			    $varrydata['size'] =  $value; 
                			    $varrydata['sku'] =  $sku[$key] ; 
                			    $varrydata['qty'] =  $qty[$key] ; 
                			    $varrydata['product_id']= $args[0];
                			    $stock = $qty[$key] + $stock ; 
                			    $this->db->insert('tbl_product_variation' , $varrydata) ; 
                			}
                		
					}
					
					if(isset($_POST['old_size'])){
				    	$old_size =  $postdata['old_size'] ; unset($postdata['old_size']) ;   
    		            $old_qty =  $postdata['old_qty'] ; unset($postdata['old_qty']) ; 
    		            $old_sku =  $postdata['old_sku'] ; unset($postdata['old_sku']) ; 
    		            $old_variation =  $postdata['old_variation'] ; unset($postdata['old_variation']) ; 
    		            
             	       
    		            foreach($old_size as $key => $value){
            			    $updatedata['size'] =  $value;  
            			    $updatedata['qty'] =  $old_qty[$key] ; 
            			    $updatedata['sku'] =  $old_sku[$key] ; 
            			    $varriation_id =  $old_variation[$key] ; 
            			    $stock = $old_qty[$key] + $stock ; 
            			    $this->db->where('id', $varriation_id) ; 
            			    $this->db->update('tbl_product_variation' , $updatedata) ; 
            			}
    				}
    				
    				
    				 $postdata['qty'] = $stock; 
					$this->product_model->update_product_by_id($args[0], $postdata);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully updated.</div>');
    				redirect('admin/product/listing');
				}
			}
        $data['RESULT'] = $this->product_model->get_product_by_id($args[0]);
		$data['IMAGES'] = $this->product_model->select_product_images($args[0]);
		$data['variation'] = $this->product_model->select_product_variation($args[0]);
		$data['CATEGORY'] = $this->category_model->get_all_category();
		$this->load->view('admin/product/edit', $data);
	}
	
	public function gallery(){
		$args = func_get_args();
	    $data['RESULT'] = $this->product_model->get_product_by_id($args[0]);
		if (isset($_POST['submitform']))
		{

					$postdata = $this->input->post();
					if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
					{
						$position = $postdata['position'];
				  		$img_tag = $postdata['img_tag'];
						$upload_files = $this->upload_files();
						$img_data['product_id']= $args[0];
						foreach ($upload_files['uploaded_data'] as $key => $value) {

							$img_data['image']= $value['file_name'];
							$img_data['img_tag']= $img_tag[$key];				
							$img_data['position']= $position[$key];				
							$img_data['thumb_image']= $value['raw_name']."_thumb".$value['file_ext'];
							$this->product_model->save_product_images($img_data);
						}


						unset($postdata['position']);
						unset($postdata['img_tag']);
					
					}
				
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully updated.</div>');
    				redirect('admin/product/listing');
				
		}
        $data['RESULT'] = $this->product_model->get_product_by_id($args[0]);
		$data['IMAGES'] = $this->product_model->select_product_images($args[0]);
		$this->load->view('admin/product/gallery', $data);
	}
	
	public function add_variation_color(){
		$args = func_get_args();
	    if (isset($_POST['submitform']))
		{
		$this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required|is_unique[tbl_products.url_slug]');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('color', 'Color', 'trim|required');
		$this->form_validation->set_rules('age_group', 'Age group', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
		if ($this->form_validation->run() == TRUE){

			$postdata = $this->input->post();
			$postdata['product_code'] = $args[0];
			unset($postdata['submitform']);
			$postdata['create_date'] = date('Y-m-d h:i:s');
			$position = $postdata['position'];
			$img_tag = $postdata['img_tag'];
			unset($postdata['position']);
			unset($postdata['img_tag']);
		    $size =  $postdata['size'] ; unset($postdata['size']) ; 
		    $sku =  $postdata['sku'] ; unset($postdata['sku']) ; 
		    $qty =  $postdata['qty'] ; unset($postdata['qty']) ;
		    $stock  = 0 ;     	
			foreach($qty as $key => $value){
			    $stock = (int)$value + $stock ; 
			    
			}
			$postdata['qty'] = $stock;
		    $this->product_model->save_product($postdata);
		    $product_id = $this->db->insert_id();
			$stock  = 0 ;     	
			foreach($size as $key => $value){
			    $varrydata['size'] =  $value; 
			    $varrydata['sku'] =  $sku[$key] ; 
			    $varrydata['qty'] =  $qty[$key] ; 
			    $varrydata['product_id']= $product_id;
			    $this->db->insert('tbl_product_variation' , $varrydata) ; 
			}
			if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
			{
			        $upload_files = $this->upload_files();
					$img_data['product_id']= $product_id;
					foreach ($upload_files['uploaded_data'] as $key => $value) {
						$img_data['image']= $value['file_name'];				
						$img_data['img_tag']= $img_tag[$key];				
						$img_data['position']= $position[$key];				
						$img_data['thumb_image']= $value['raw_name']."_thumb".$value['file_ext'];
						$this->product_model->save_product_images($img_data);
					}
			}
			
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully saved.</div>');
			redirect('admin/product/listing');
			}
		  $msg =  "<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>";
		  $this->session->set_flashdata('msg', $msg);

		}
        $data['RESULT'] = $this->product_model->get_product_by_product_code($args[0]);
		$data['CATEGORY'] = $this->category_model->get_all_category();
		$this->load->view('admin/product/product-color-variation', $data);
	

	}
	
	public function add_variation_size(){
		$args = func_get_args();
        if (isset($_POST['submitform']))
		{
		$this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('qty', 'Qty', 'trim|required');
		$this->form_validation->set_rules('url_slug', 'Url Slug', 'trim|required|is_unique[tbl_products.url_slug]');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('color', 'Color', 'trim|required');
		$this->form_validation->set_rules('age_group', 'Age group', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
		if ($this->form_validation->run() == TRUE){

			$postdata = $this->input->post();
			$postdata['product_code'] = $args[0];
	        $postdata['size'] = implode('@',$postdata['size'] ) ; 
	        $postdata['size_cm'] = implode('@',$postdata['size_cm'] ) ; 
			unset($postdata['submitform']);
			$postdata['create_date'] = date('Y-m-d h:i:s');
			$position = $postdata['position'];
			$img_tag = $postdata['img_tag'];
			unset($postdata['position']);
			unset($postdata['img_tag']);
			$this->product_model->save_product($postdata);
			$product_id = $this->db->insert_id();
			if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
			{

					
					$upload_files = $this->upload_files();
					$img_data['product_id']= $product_id;
					foreach ($upload_files['uploaded_data'] as $key => $value) {

						$img_data['image']= $value['file_name'];				
						$img_data['img_tag']= $img_tag[$key];				
						$img_data['position']= $position[$key];				
						$img_data['thumb_image']= $value['raw_name']."_thumb".$value['file_ext'];

						$this->product_model->save_product_images($img_data);
					}
			}

			$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully saved.</div>');
			redirect('admin/product/listing');
			}
		  $msg =  "<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>";
		  $this->session->set_flashdata('msg', $msg);

		}
        $data['RESULT'] = $this->product_model->get_product_by_product_code($args[0]);
		$data['IMAGES'] = $this->product_model->select_product_images($data['RESULT'][0]->id);
		$data['CATEGORY'] = $this->category_model->get_all_category();
		$this->load->view('admin/product/product-size-variation', $data);

	}
	
	public function getProductDetails($value='')
	{
		$productId = $this->input->post('productId');
		$data['RESULT'] = $this->product_model->get_product_by_id($productId);
		$this->load->view('admin/product/view', $data);

	}
	public function getImageDetails($value='')
	{
		$ImageID = $this->input->post('ImageID');
		$data['RESULT'] = $this->product_model->select_images_by_id($ImageID);
		$this->load->view('admin/product/view-image', $data);

	}
	
	public function getProductStock($value='')
	{
		$productId = $this->input->post('productId');
		$data['RESULT'] = $this->product_model->select_product_variation_by_id($productId);
		$this->load->view('admin/product/view-2', $data);

	}
	
	public function editProductProcess($value='')
	{
		$postdata = $this->input->post();
		$product_id = $postdata['product_id'];
		unset($postdata['submitform']);
		unset($postdata['product_id']);
		$this->product_model->update_product_by_id($product_id, $postdata);
		redirect('admin/product/listing');
	}
	
	public function editProductImageProcess($value='')
	{
		$postdata = $this->input->post();
		
		$image_id = $postdata['image_id'];
		$product_id = $postdata['product_id'];
		unset($postdata['submitform']);
		unset($postdata['image_id']);
		unset($postdata['product_id']);
		
	    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
			$upload_files = $this->upload_files();
			foreach ($upload_files['uploaded_data'] as $key => $value) {
				$postdata['image']= $value['file_name'];			
				$postdata['thumb_image']= $value['raw_name']."_thumb".$value['file_ext'];
			}
		}
		$this->product_model->update_product_image_by_id($image_id, $postdata);
		redirect('admin/product/gallery/'.$product_id);
	}
	
	public function editProductProcess2($value='')
	{
		$postdata = $this->input->post();
		$rowid = $postdata['rowid'];
		$product_id = $postdata['product_id'];
		unset($postdata['submitform']);
		unset($postdata['rowid']);
		unset($postdata['product_id']);
		$this->product_model->update_product_variation_by_id($rowid, $postdata);
	    $variation = $this->product_model->select_product_variation($product_id);
	    $stock = 0 ; 
	    foreach($variation as $key => $row){
	        $stock = $stock + $row->qty ; 
	    }
	    $update['qty'] = $stock ; 
	    $this->product_model->update_product_by_id($product_id, $update);
		redirect('admin/product/stock');
	}

	
	public function image_delete()
	{
	if (count($_POST) && isset($_POST['id']) && !empty($_POST['id']))
		{

		$this->product_model->delete_product_images($_POST['id']);
		delete_file('uploads/product/', $_POST['image']);
		echo 1;
		}
	  else
		{
		echo 0;
		}

	}

	public function upload_files() {

	    $post_data = $this->input->post();
	    $arr['error'] = false;
	    $arr['uploaded_data'] = []; 
	    $files = $_FILES;
        $cpt = count($_FILES['image']['name']);
        for($i=0; $i<$cpt; $i++)
			    {           
			        $_FILES['userfile']['name']= time(). "_" .  $files['image']['name'][$i];
			        $_FILES['userfile']['type']= $files['image']['type'][$i];
			        $_FILES['userfile']['tmp_name']= $files['image']['tmp_name'][$i];
			        $_FILES['userfile']['error']= $files['image']['error'][$i];
			        $_FILES['userfile']['size']= $files['image']['size'][$i];   
			        $config['upload_path'] = 'uploads/product/';
		            $config['allowed_types'] = 'jpg|png|jpeg|webp';
			        $this->upload->initialize($config);
			        if ($this->upload->do_upload()) {

				            $arr['uploaded_data'][$i] = $this->upload->data();
				          
				            $this->create_thumbnail($arr['uploaded_data'][$i]);

				          } else {

				              return ['error' => true ,  'msg' => $this->upload->display_errors()];
				          }
			    }
	    return $arr;
	}
	
    public function create_thumbnail($uploaded_data) {
		    $config['image_library'] = 'gd2';
		    $config['source_image'] = $uploaded_data['full_path'];
		    $config['create_thumb'] = TRUE;
		    $config['maintain_ratio'] = false;
		    $config['width']         = 250;
		    $config['height']         = 300;
		    $this->image_lib->clear();
		    $this->image_lib->initialize($config);
		    $this->image_lib->resize();
		    if ( ! $this->image_lib->resize()) {
		      echo '<pre>'; 
		      print_r($this->image_lib->display_errors()); 
		      die;

		    }

	}

	public function prodelete()
	{
		$args = func_get_args();
		$product_data = $this->product_model->get_product_by_id($args[0]);
        $postdata['delete_flag'] = '1' ; 
		$this->product_model->update_product_by_id($args[0], $postdata);
		$this->session->set_flashdata('msg','<div class="alert alert-success">record has been successfully deleted.</div>');
		redirect('admin/product/listing');
	}

	public function color_variation(){
    	if (isset($_POST['add_color']))
		{
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE){
				$postdata = $this->input->post();
				unset($postdata['add_color']);
				$this->product_model->save_color($postdata);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully saved.</div>');
				redirect('admin/product/color_variation');
			 }else{
			  $this->session->set_flashdata('msg', "<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>");
			 }

		}
	    $data['RESULT'] = $this->product_model->get_all_color();
		$this->load->view('admin/product/color-variation', $data);
	}
	
	public function color_delete($id){
	    
	    $this->db->where('id',$id ) ; 
	    $this->db->delete('tbl_color');
	    $this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully Deleted.</div>');
		redirect('admin/product/color_variation');
	}
	
	public function size_variation(){
	    if (isset($_POST['add_size']))
		{
		
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
			if ($this->form_validation->run() == TRUE){
				$postdata = $this->input->post();
				unset($postdata['add_size']);
				$this->product_model->save_size($postdata);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully saved.</div>');
				redirect('admin/product/size_variation');
			 }else{
			  $this->session->set_flashdata('msg', "<div class='alert alert-success'><font color='red'>" . validation_errors() . "</font>.</div>");
			 }

		}
	    $data['RESULT'] = $this->product_model->get_all_size();
		$this->load->view('admin/product/size-variation', $data);
	}
	
	public function size_delete($id){
	    
	    $this->db->where('id',$id ) ; 
	    $this->db->delete('tbl_size');
	    $this->session->set_flashdata('msg', '<div class="alert alert-success">Record has been successfully Deleted.</div>');
		redirect('admin/product/size_variation');
	}


}