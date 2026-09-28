<?php 
class Blogs_model extends CI_Model
{	
	protected $table = 'tbl_blogs';
	public function add_blogs($data)
	{
		$this->db->insert($this->table,$data);
	}


	public function add_blogs_category($data)
	{
		$this->db->insert('tbl_blog_category',$data);
	}
	public function get_all_blogs()
	{
		$this->db->select('blog.id,blog.title,blog.url_slug,blog.date,blog.image,blog.thumb_image,blog.img_tag,category.title as cat_title,blog.status');
		$this->db->from('tbl_blogs  blog');
		$this->db->join('tbl_blog_category  as category',"blog.cat_id  = category.id",'left');
		$this->db->order_by("blog.id",'DESC');
		return $this->db->get()->result();
	}
	public function get_blogs_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get($this->table)->result();
	}
	
	public function  get_all_blog_and_image()
	   {
		$this->db->select('tbl_blogs.*,tbl_blogs_images.image');
		$this->db->from('tbl_blogs');
		$this->db->join('tbl_blogs_images', 'tbl_blogs_images.blog_id = tbl_blogs.id','left');
		$this->db->group_by('tbl_blogs.id');
		$query = $this->db->get();
		return $query->result();
	 }


	public function update_blogs_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}
	
	public function get_all_active_blogs($limit=null )
	{
		$this->db->select('blog.id,blog.title,blog.url_slug,blog.date,blog.image,blog.thumb_image,blog.img_tag,category.title as cat_title,');
		$this->db->from('tbl_blogs  blog');
		$this->db->join('tbl_blog_category  as category',"blog.cat_id  = category.id",'left');
		$this->db->order_by("blog.date",'DESC');
		$this->db->where('blog.status',1);
		if($limit){
		$this->db->limit($limit);	
		}
		return $this->db->get()->result();
	}


	public function related_blog($category_id,$limit=null){
	    $this->db->select('blog.id,blog.title,blog.url_slug,blog.date,blog.image,blog.thumb_image,blog.img_tag,category.title as cat_title,');
		$this->db->from('tbl_blogs  blog');
		$this->db->join('tbl_blog_category  as category',"blog.cat_id  = category.id",'left');
		
		$this->db->where('blog.status',1);
		 $this->db->where('blog.cat_id',$category_id);
		if($limit){
		$this->db->limit($limit);	
		}
		$this->db->order_by("blog.date",'DESC');
		return $this->db->get()->result();
 }
	
	public function delete_blogs_by_id($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}

	public function save_blogs_images($data)
	{
		$this->db->insert('tbl_blogs_images',$data);
	}

	public function get_blogs_by_slug($url_slug)
	{
		$this->db->where('url_slug',$url_slug);
		return $this->db->get($this->table)->result();
	}

	public function select_blogs_images($pro_id)
	{
		$this->db->where('blog_id',$pro_id);
		return $this->db->get('tbl_blogs_images')->result();
	}

	function delete_blogs_images($pro_id)
	{
		
		$table= 'tbl_blogs_images';
		$this->db->where('id',$pro_id);
		$this->db->delete($table);
	}
	
	public function get_state_name(){
		$this->db->where('country_id','101');
		$row=$this->db->get('states')->result();
		return $row;
		
	}
	
	public function get_city($city){
		$this->db->where('id',$city);
		$row=$this->db->get('cities')->result();
		return $row;
		
	}

	public function get_blog_category(){
		return $this->db->get('tbl_blog_category')->result();
	}
	
	public function get_blog_category_by_id($id){
		$this->db->where('id',$id);
		return $this->db->get('tbl_blog_category')->result();
	}

	public function update_blogs_cat_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_blog_category',$data);
	}
	public function get_all_active_blog_category(){
	
		return $this->db->get('tbl_blog_category')->result();
	}

	
}
