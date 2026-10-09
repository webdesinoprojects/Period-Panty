<?php 
class Product_model extends CI_Model
{	
	protected $table = 'tbl_products';
	/*start forum product model*/
	public function save_product($data)
	{

		$this->db->insert($this->table,$data);
	} 
	public function get_all_product()
	{
	    $this->db->where('delete_flag','0');
		$this->db->order_by('id' , 'desc') ;
		return $this->db->get($this->table)->result();
	}

	public function get_all_stock_product()
	{
	   $this->db->select("variation.id , variation.size as varrysize,variation.sku as varrysku,variation.qty as varryqty,  category.url_slug as cat_url, category.title as cat_title,product.title,product.special_price,product.price,product.discount,product.id as productID,product.qty as productQty ,product.color,product.discount,product.status, product.product_code");
		$this->db->from('tbl_product_variation as variation');
		$this->db->join('tbl_products as product',"variation.product_id	= product.id",'left');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
        $this->db->where('product.status','1');
        $this->db->where('product.delete_flag','0');
		$this->db->order_by('product.id' , 'desc') ;
		return $this->db->get()->result();
	}

    public function get_all_product_multiple_ids($ids)
	{
	    $this->db->where_in('id', $ids);
	    	$this->db->where('delete_flag','0');
	   $this->db->order_by('id' , 'desc') ;
		return $this->db->get($this->table)->result();
	}
	
	public function search_products($keyword)
	{


        $this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.status','1');
		$this->db->where('product.delete_flag','0');
	    $this->db->like('product.title',$keyword);
		$this->db->order_by('product.id' , 'desc') ;
	    return $this->db->get()->result();
		
	}
	public function get_product_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get($this->table)->result();
	}
	public function get_product_by_id_some($id)
	{
	    $this->db->select("product.title,product.id,product.qty");
		$this->db->from('tbl_products as product');
		$this->db->where('product.id',$id);
		return $this->db->get()->result();
	}
	public function get_product_by_product_code($product_code)
	{
		$this->db->where('product_code',$product_code);
		return $this->db->get($this->table)->result();
	}	
	public function get_color_variation_by_product_code($product_code)
	{
	    $this->db->select("category.url_slug as cat_url,product.url_slug,product.color,product.id");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.product_code',$product_code);
        $this->db->where('product.status','1');
        $this->db->where('product.delete_flag','0');
		$this->db->order_by('product.id' , 'desc') ;

		return $this->db->get()->result();
	}
	
	public function get_age_variation_by_product_code($product_code)
	{   $this->db->select("category.url_slug as cat_url,product.url_slug,product.color,product.age_group,product.id");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.product_code',$product_code);
        $this->db->where('product.status','1');
        $this->db->where('product.delete_flag','0');
		$this->db->order_by('product.id' , 'desc') ;
		return $this->db->get()->result();
	}
	public function update_product_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}
	public function update_product_variation_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_product_variation',$data);
	}
	public function get_all_active_product()
	{
		$this->db->where('status','1');
	    $this->db->order_by('id' , 'desc') ;
		return $this->db->get($this->table)->result(); 
	}

	
	public function save_product_images($data)
	{
		$this->db->insert('tbl_product_images',$data);
	}

	public function select_product_images($pro_id)
	{
	    $this->db->order_by('position' ,'Asc') ;
		$this->db->where('product_id',$pro_id);
		return $this->db->get('tbl_product_images')->result();
	}
	public function select_product_variation($pro_id)
	{

		$this->db->where('product_id',$pro_id);
		return $this->db->get('tbl_product_variation')->result();
	}

	public function select_product_images_by_id($pro_id)
	{
		$this->db->where('product_id',$pro_id);
		$this->db->limit(1);
		return $this->db->get('tbl_product_images')->result();
	}
	public function select_images_by_id($id)
	{
		$this->db->where('id',$id);
		$this->db->limit(1);
		return $this->db->get('tbl_product_images')->result();
	}
	public function select_product_variation_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get('tbl_product_variation')->result();
	}
	
	function delete_product_images($pro_id)
	{
		$this->db->where('id',$pro_id);
		$this->db->delete('tbl_product_images');
	}
	public function update_product_image_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_product_images',$data);
	}
	
	public function get_product_by_category_id($cat_id , $limit=null )
	{
		$this->db->select("category.url_slug as cat_url,category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.cat_id',$cat_id);
        $this->db->where('product.status','1');
        $this->db->where('product.delete_flag','0');
		$this->db->order_by('product.id' , 'desc') ;
        	if($limit!=0){ $this->db->limit($limit); }
		return $this->db->get()->result();
	}	
	

	public function get_product_by_urlslug($key)
	{
		$this->db->where('url_slug',$key);
		return $this->db->get($this->table)->result();
	}
	
	function get_product_url($pri_id)
	{
		$this->db->select("CONCAT(category.url_slug,'/',product.url_slug,'.html') as product_url");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'inner');
		$this->db->where('product.id',$pri_id);
		$data =  $this->db->get()->result();
		return base_url($data[0]->product_url);
	}

	public function delete_product($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}
	

	public function get_all_faq($cat_id)
	{
		$this->db->where('cat_id',$cat_id);
		$this->db->where('status','1');
		return $this->db->get('tbl_faq')->result();
	}


    public function get_product_by_category_id_order_by($cat_id,$low)
	{
		$this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.cat_id',$cat_id);
		$this->db->where('product.status','1');
		$this->db->where('product.delete_flag','0');
		$this->db->order_by('price' , $low) ;
		return $this->db->get()->result();
	} 

	public function get_product_by_mulit_category_id_order_by($cat_id_array,$low)
	{
		$this->db->select("category.url_slug as cat_url, category.title as cat_title,product.title,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where_in('product.cat_id',$cat_id_array);
		$this->db->where('product.status','1');
		$this->db->where('product.delete_flag','0');
		$this->db->order_by('price' , $low) ;
		return $this->db->get()->result();
	}
	public function get_filter_products($filter_array , $categoryArray,$starting_price ,$ending_price, $color_array,$size,$size_cm , $age_group,$limit ,$order_by , $order_value  )
	{
		$this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
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
		   $this->db->where('product.age_group',$age_group);
		}
		if($size){
		    $this->db->where('find_in_set("'.$size.'", product.size) <> 0');

		}
		$this->db->where_in('product.cat_id',$categoryArray);
		$this->db->where('product.delete_flag','0');
		if($limit!=0){ $this->db->limit($limit); }
		$this->db->order_by('product.'.$order_by , $order_value) ;
		return $this->db->get()->result();
	}
	
	
	public function get_home_products($filter_array,$limit ,$order_by , $order_value  )
	{
		$this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		foreach($filter_array as $key=> $value){
		   $this->db->where('product.'.$key, $value); 
		}
		$this->db->where('product.delete_flag','0');
		if($limit!=0){ $this->db->limit($limit); }
		$this->db->order_by('product.'.$order_by , $order_value) ;
		return $this->db->get()->result();
	}
	
	public function get_product_by_filter($categoryArray, $filter ,$limit,$order_by , $order_value )
	{
		$this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_products as product');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('product.delete_flag','0');
		foreach($filter as $key=> $value){
		   $this->db->where('product.'.$key, $value); 
		}
		
		if($categoryArray){
		    $this->db->where_in('product.cat_id',$categoryArray);
		}
		$this->db->order_by('product.'.$order_by , $order_value) ;
		if($limit!=0){ $this->db->limit($limit); }
		return $this->db->get()->result();
	}
	public function get_all_size()
	{
       
		return $this->db->get('tbl_size')->result();
	} 
    
    public function get_all_active_size()
	{
        $this->db->where('status','1');
		return $this->db->get('tbl_size')->result();
	} 
	
	public function save_size($data)
	{

		$this->db->insert('tbl_size',$data);
	}

	
	public function get_all_color()
	{
        
		return $this->db->get('tbl_color')->result();
	} 
	
	public function get_all_active_color()
	{
        $this->db->where('status','1');
		return $this->db->get('tbl_color')->result();
	} 
	
	public function save_color($data)
	{

		$this->db->insert('tbl_color',$data);
	} 
	
	function get_user_wishlist($user_id){
	 
	    $this->db->select(" category.url_slug as cat_url, category.title as cat_title,product.url_slug,product.title,product.special_price,product.price,product.discount,product.id,product.qty,product.absorbency_volume,product.absorbency_rate,product.color");
		$this->db->from('tbl_wishlist as wishlist');
		$this->db->join('tbl_products as product',"wishlist.product_id = product.id",'left');
		$this->db->join('tbl_categories as category',"product.cat_id = category.id",'left');
		$this->db->where('wishlist.user_id',$user_id);
		$this->db->where('product.status','1');
		return $this->db->get()->result();
	}
}
