<?php 
class Category_model extends CI_Model
{	
	protected $table = 'tbl_categories';
	/*start forum category model*/
	public function get_category_by_urlslug($key) 
	{
		$this->db->where('url_slug',$key);
		return $this->db->get($this->table)->result();
	}
	
	public function save_category($data)
	{
		$this->db->insert($this->table,$data);


	}


	public function get_all_category()
	{
		return $this->db->get($this->table)->result();
	}
	public function get_all_category_by_limit($total , $start)
	{
	    $this->db->limit($total , $start) ; 
		return $this->db->get($this->table)->result();
	}
	public function get_category_by_id($id)
	{
	   
		$this->db->where('id',$id);
		return $this->db->get('tbl_categories')->result();
	}
	public function update_category_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}
	public function get_all_active_category()
	{
		$this->db->where('status',1);
		return $this->db->get($this->table)->result();
	}
	
	public function get_category_by_parent($id)
	{
		$this->db->where('home_display','1');
		$this->db->where('status','1');
		$this->db->where('parent_id',$id);
		return $this->db->get($this->table)->result();
	}
	public function get_home_category_by_parent($id)
	{
		$this->db->where('home_display','1');
		$this->db->where('status','1');
		$this->db->where('parent_id',$id);
		return $this->db->get($this->table)->result();
	}
	public function get_category_by_parent_menu($id)
	{

		$this->db->where('status','1');
		$this->db->where('parent_id',$id);
		return $this->db->get($this->table)->result();
	}


	public function get_all_child_category_by_parent_id($parent_id)
	{
		
		$this->db->select('id');
		$this->db->where('status','1');
		$this->db->where('parent_id',$parent_id);
		$query_data =$total_array = $this->db->get($this->table)->result();
		if(count($query_data)>0)
		{		
			foreach($query_data as $data)
			{
				$child = $this->check_child_category($data->id);
				if(count($child))
				{
				  $new_array = $this->get_all_child_category_by_parent_id($data->id);
				  $total_array = array_merge($new_array,$total_array); 
				}
			
			}					
		}
		
		return $total_array ; 
		
	}
	
	
	function get_all_child_category_with_count_product($parent_id)
	{
		$this->db->select('category.id, category.title, category.url_slug, count(product.id) as products');
		$this->db->from($this->table.' as category');
		$this->db->join('tbl_products as product','product.cat_id = category.id','left');
		$this->db->group_by('category.id');
		$this->db->where('category.parent_id',$parent_id);
		return $this->db->get()->result();
	}

	public function get_all_child_category($parent_id,$level =0)
	{
		$this->db->where('parent_id',$parent_id);
		$query_data = $this->db->get($this->table)->result();
		
		if(count($query_data)>0)
		{		
			$level++;
			foreach($query_data as $data)
			{
				echo '<option value="'.$data->id.'">';
				echo str_repeat('--',$level-1).' '.$data->title;
				$child = $this->check_child_category($data->id);
				if(count($child))
				{
					$this->get_all_child_category($data->id,$level);
				}
				echo '</option>';
			}					
		}	
	}
	
	public function get_all_child_category_for_admin($parent_id,$level =0)
	{   $cat_data = array();
		$this->db->where('id',$parent_id);
		$query_data = $this->db->get($this->table)->result();
		if(count($query_data)>0)
		{	
			$level++;			
			$oprator = ($level!=1)?' <strong> / </strong> ':'';
			array_push($cat_data,$query_data[0]->title);
			array_push($cat_data,$this->get_all_child_category_for_admin($query_data[0]->parent_id,$level));								
		}
		return $cat_data;
	}

    public function get_category_by_sub($id)
	{
		$this->db->where('status',1);
		$this->db->where('id',$id);
		return $this->db->get($this->table)->result();
	}
	
	public function check_child_category($id)
	{
		$this->db->where('parent_id',$id);
		return $this->db->get($this->table)->result();
	}
	
	function fetchCategoryTree($parent) {
        $this->db->select('*');
        $this->db->where('parent_id',$parent);
    	return $this->db->get('tbl_categories')->result();
    	
    }

   public function get_categories(){

        $this->db->select('*');
        $this->db->from('tbl_categories');
        $this->db->where('parent_id', 0);

        $parent = $this->db->get();
        
        $categories = $parent->result();
        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]->sub = $this->sub_categories($p_cat->id);
            $i++;
        }
        return $categories;
    }

    public function sub_categories($id){

        $this->db->select('*');
        $this->db->from('tbl_categories');
        $this->db->where('parent_id', $id);

        $child = $this->db->get();
        $categories = $child->result();
        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]->sub = $this->sub_categories($p_cat->id);
            $i++;
        }
        return $categories;       
    }


	
}
