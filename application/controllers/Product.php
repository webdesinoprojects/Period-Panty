<?php
class Product extends CI_Controller{
       function __construct(){
	 	parent::__construct();
     }


   	public function shop($parent = 0)
	{	 
	   $data['RESULT'] = $this->page_model->get_page_by_id(31);

	    // The filter sidebar, the sort control and the pager all post to
	    // product/pagination, which already handles paging, sorting and every
	    // filter. shop() previously returned every row with no LIMIT and never
	    // passed this URL, so none of that machinery was reachable from /shop.
	    $data['load_url'] = base_url('product/pagination');

	    $this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.id,product.qty,product.discount,product.absorbency_volume,product.absorbency_rate");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.delete_flag','0');
		$this->db->where('product.status','1');
		$data['PRODUCT_TOTAL'] = $this->db->count_all_results('', FALSE);

		// First paint is server-rendered so the grid works without JS and stays
		// crawlable; product/pagination takes over from the first interaction.
		$this->db->order_by('product.id', 'DESC');
		$this->db->limit(12, 0);
		$data['PRODUCTS'] = $this->db->get()->result();

		// Render the pager server-side with the same helper the AJAX endpoint
		// uses, so page links exist on first paint instead of only appearing
		// after the visitor sorts or filters.
		$data['PAGER'] = $this->getAllPageLinks(
			$data['PRODUCT_TOTAL'],
			base_url('product/pagination') . '?page=',
			12
		);
		$this->load->view('front/product/listing',$data);
	}

    function getAllPageLinks($count,$href,$perpage) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($perpage != 0)
			$pages  = ceil($count/$perpage);
		if($pages>1) {
			if($_GET["page"] == 1) 
				$output = $output . '<span class="link first disabled">&#8810;</span><span class="link disabled">&#60;</span>';
			else	
				$output = $output . '<a class="link first" onclick="getresult(\'' . $href . (1) . '\')" >&#8810;</a><a class="link" onclick="getresult(\'' . $href . ($_GET["page"]-1) . '\')" >&#60;</a>';
			
			
			if(($_GET["page"]-3)>0) {
				if($_GET["page"] == 1)
					$output = $output . '<span id=1 class="link current">1</span>';
				else				
					$output = $output . '<a class="link" onclick="getresult(\'' . $href . '1\')" >1</a>';
			}
			if(($_GET["page"]-3)>1) {
					$output = $output . '<span class="dot">...</span>';
			}
			
			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_GET["page"] == $i)
					$output = $output . '<span id='.$i.' class="link current">'.$i.'</span>';
				else				
					$output = $output . '<a class="link" onclick="getresult(\'' . $href . $i . '\')" >'.$i.'</a>';
			}
			
			if(($pages-($_GET["page"]+2))>1) {
				$output = $output . '<span class="dot">...</span>';
			}
			if(($pages-($_GET["page"]+2))>0) {
				if($_GET["page"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="link current">' . ($pages) .'</span>';
				else				
					$output = $output . '<a class="link" onclick="getresult(\'' . $href .  ($pages) .'\')" >' . ($pages) .'</a>';
			}
			
			if($_GET["page"] < $pages)
				$output = $output . '<a  class="link" onclick="getresult(\'' . $href . ($_GET["page"]+1) . '\')" >></a><a  class="link" onclick="getresult(\'' . $href . ($pages) . '\')" >&#8811;</a>';
			else				
				$output = $output . '<span class="link disabled">></span><span class="link disabled">&#8811;</span>';
			
			
		}
		return $output;
	}
	
	public function pagination(){
        
        
        $paginationlink = base_url('product/pagination')."?page=";	
        $pagination_setting = '';
        $perpage = 12;				
        $page = 1;
        if(!empty($_GET["page"])) {
        $page = $_GET["page"];
        }
        
        $start = ($page-1)*$perpage;
        if($start < 0) $start = 0;
        
        
        if(isset($_GET['sorting'])){
            $sorting = $_GET['sorting'];
        }else{
            $sorting = 'Asc';
        }
        
        $order_by = '.id' ; 
		$order_value = 'asc' ; 
		$starting_price =$ending_price= $color_array=$size=$size_cm = $age_group =$limit=  $filter_array = $categoryArray=null; 
		$filter_array = [];;
		if(isset($_GET['sorting'])){
	
		    if($_GET['sorting'] == 'Sort by Price: Low to High'){
		        	$order_by = '.price' ; 
		            $order_value = 'asc' ;
		    }else if($_GET['sorting'] == 'Sort by Price: High to Low'){
		        	$order_by = '.price' ; 
		            $order_value = 'desc' ; 
		        
		    }else if($_GET['sorting'] == 'Sort by Latest'){
		        
		        	$order_by = '.id' ; 
		            $order_value = 'Desc' ; 
		    }else if($_GET['sorting'] == 'Sort by Best Sellers'){
		        
		        	$order_by = '.best_seller' ; 
		            $order_value = 'Desc' ; 
		            $filter_array = ['best_seller'=>'yes','status'=>'1' ];
		    }else{
		        	$order_by = '.id' ; 
		            $order_value = 'asc' ;
		    }
		}
		if (isset($_GET['price']) && (!empty($_GET['price']))) {
		    $price = explode('-',$_GET['price']) ; 
		    $starting_price = explode('Rs.',$price[0]) ; 
		    $ending_price = explode('Rs.',$price[1]) ; 
			$starting_price = $starting_price[1]  ;
			$ending_price = $ending_price[1] ;
		
		}
		if (isset($_GET['color'])) {
			$color_array = $_GET['color'] ;
	 
		}
		if (isset($_GET['size'])) {
			$size = $_GET['size'] ;
		}
		if (isset($_GET['age_group'])) {
			 $age_group = $_GET['age_group'] ;
	
		}
	    if( (isset($_GET['where_clause']) ) && ( $_GET['where_clause'] == 'Best Seller') ){
	       $filter_array = ['best_seller'=>'yes' ];
	   }
	    if( (isset($_GET['where_clause']) ) && ( $_GET['where_clause'] == 'Sale') ){
	       $filter_array = ['discounted_products'=>'yes' ];
	    }
        if( (isset($_GET['where_clause']) ) && ( $_GET['where_clause'] == 'New Arrivals') ){
	       $filter_array = ['is_latest'=>'yes' ];
	    } 
	    if (isset($_GET['cat_id']) && (!empty($_GET['cat_id']))) {
    	    $categoryArray[0] =$cat_id= $_GET['cat_id'] ; 
    		$subcategory = $this->category_model->get_all_child_category_by_parent_id($cat_id);
    		  
    		if(count($subcategory ) ) {
    				foreach ($subcategory as $key => $value) {
    					$categoryArray[$key+1] = $value->id ; 
    				}
    		}
	    }
        //  Get all Products
        
        $this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.id,product.qty,product.discount,product.absorbency_volume,product.absorbency_rate");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_product_variation as product_variation',"product_variation.product_id=product.id",'left');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.delete_flag','0');
		$this->db->where('product.status','1');
		if($categoryArray){
		   		$this->db->where_in('product.cat_id',$categoryArray); 
		}

	    foreach($filter_array as $key=> $value){
		   $this->db->where('product.'.$key, $value); 
		}
		if(is_array($color_array) && (count($color_array) > 0)){
		    $this->db->where_in('product.color',$color_array);
		}
		if($starting_price){
		    $this->db->where("product.price BETWEEN $starting_price AND $ending_price");
		}
		if($age_group){
		   $this->db->where('find_in_set("'.$age_group.'", product.age_group) <> 0');
		}
		if($size){
		    $this->db->where('product_variation.size',$size);

		}

		$this->db->limit($perpage,$start) ;  
		$this->db->order_by('product'.$order_by , $order_value) ;
		$this->db->group_by('product_variation.product_id') ;  
		$PRODUCTS = $this->db->get()->result();
    //  echo $this->db->last_query() ; 

        //  count Rows
        $this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.delete_flag','0');
		$this->db->where('product.status','1');
		if($categoryArray){
		   		$this->db->where_in('product.cat_id',$categoryArray); 
		}
	    foreach($filter_array as $key=> $value){
		   $this->db->where('product.'.$key, $value); 
		}
		if(is_array($color_array) && (count($color_array) > 0)){
		    $this->db->where_in('product.color',$color_array);
		}
		if($starting_price){
		    $this->db->where("product.price BETWEEN $starting_price AND $ending_price");
		}
		if($age_group){
		    $this->db->where('find_in_set("'.$age_group.'", product.age_group) <> 0');
		}
		if($size){
		    $this->db->where('find_in_set("'.$size.'", product.size) <> 0');

		}

       $count = $this->db->get()->num_rows();

        if(empty($_GET["rowcount"])) { $_GET["rowcount"] = $count; }
        
        $perpageresult = $this->getAllPageLinks($_GET["rowcount"], $paginationlink,$perpage);	
        $output = '';
        if($count > 0){
       
            foreach($PRODUCTS as $product){
    
                $data['product']= $product ; 
                $output .= '<div class="col-lg-4 col-md-6 col-sm-6 col-6 products-col-item">' ; 
                $output .=  $this->load->view('front/product/listing-view',$data, TRUE);
                $output .= '</div>';
            }
    
             if(!empty($perpageresult)) {
                $output .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12 ">' ; 
                $output .= '<div id="pagination">' . $perpageresult . '</div>';
                $output .= '</div>';
                }else{
                    $output .= '';
                }
        }else{
              $output .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12 "> <h4 class="text-center"> No Product Found </h4></div>' ; 
        }
        echo $output;
    }
	
	public function listing()
	{
    	$url = $this->uri->segment(1);
	   	$url =  explode('.', $url) ; 
		$data['RESULT'] = $category_data = $this->category_model->get_category_by_urlslug($url[0]);
		if($category_data){
		    	$starting_price =$ending_price= $color_array=$size=$size_cm = $age_group =$limit=  $filter_array = $categoryArray=null; 
			$data['cat_id'] =$cat_id= $category_data[0]->id;
			$data['url_slug'] = $category_data[0]->url_slug;
            $categoryArray[0] =$cat_id; 
    		$subcategory = $this->category_model->get_all_child_category_by_parent_id($cat_id);
    		
    	
    		if(isset($_GET['sorting'])){
                $sorting = $_GET['sorting'];
            }else{
                $sorting = 'Asc';
            }
            
            $order_by = '.id' ; 
    		$order_value = 'asc' ; 
    	
    		$filter_array = [];
    		if(count($subcategory ) > 0) {
    				foreach ($subcategory as $key => $value) {
    					$categoryArray[$key+1] = $value->id ; 
    				}
    		}
	        if(isset($_GET['sorting'])){
	
    		    if($_GET['sorting'] == 'Sort by Price: Low to High'){
    		        	$order_by = '.price' ; 
    		            $order_value = 'asc' ;
    		    }else if($_GET['sorting'] == 'Sort by Price: High to Low'){
    		        	$order_by = '.price' ; 
    		            $order_value = 'desc' ; 
    		        
    		    }else{
    		        	$order_by = '.id' ; 
    		            $order_value = 'asc' ;
    		    }
    		}
   
            $this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.id,product.qty,product.discount,product.absorbency_volume,product.absorbency_rate");
    		$this->db->from('tbl_products as product');
    		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
    		$this->db->where('product.delete_flag','0');
    		$this->db->where('product.status','1');
    		if($categoryArray){
    		   		$this->db->where_in('product.cat_id',$categoryArray); 
    		}
    		$this->db->order_by('product'.$order_by , $order_value) ;
    		$data['PRODUCTS'] = $this->db->get()->result();
			$this->load->view('front/product/listing',$data);
		}
		else
		{
		redirect('404');
		}
	}

	function get_product_by_cat(){
		$args = func_get_args();
		$uri = $this->uri->segment(1);
		$category_data = $this->category_model->get_category_by_urlslug(rtrim($args[0],'.html'));
		if(count($category_data) > 0)
		{	
			$products = $this->product_model->get_product_by_category_id($category_data[0]->id);
			
		}

	}

	public function search(){
		if(isset($_GET['search']))
		{
		$keyword = $_GET['search'];
		}else{
			$keyword ='';
		}	
        $data['PRODUCTS'] = $this->product_model->search_products($keyword);
       
		$this->load->view('front/product/search',$data);
	}

	function detail()
	{

		$args = func_get_args();
    	$uri2 = $this->uri->segment(2);
		$url =  explode('.',$uri2);
		$product_data = $this->product_model->get_product_by_urlslug($url[0]);
	
		if(count($product_data)>0)
		{		$cat_id = $product_data[0]->cat_id;
			$data['RESULT'] = $product_data;
			$data['CATEGORY'] = $this->category_model->get_category_by_id($cat_id);
			$data['productscat'] = $this->product_model->get_product_by_category_id($cat_id,8);
			$this->load->view('front/product/detail',$data);

		}
		else
		{
			redirect('');
		}
	}
	
	function get_product_size_variation()
	{
	    $product_id = $_POST['product_id'] ; 
        $product = $this->product_model->get_product_by_id($product_id);
        $variation = $this->product_model->select_product_variation($product_id);
        $msg = '';

        foreach($variation as $key => $value) { 
            if($value->qty>0){ 
              $para = "'".$value->id."', '".$product_id."'" ;       
                $msg .=  '<li><input type="radio" class="check_size selectSize" onchange="selectSize('.$para.')" name="variation_id" id="checkbox'.$key.'" value="'.$value->id.'" ><label for="checkbox'.$key.'">'.$value->size.' </label></li>';
            } 
        } 
        echo $msg ; 
        
       
       
	}
	
		
	function get_product_vartion_details(){
	   $variation_id = $_POST['variation_id'];
	   $variation_data = $this->product_model->select_product_variation_by_id($variation_id);
	   echo $variation_data[0]->qty ; 
	}



	
}
