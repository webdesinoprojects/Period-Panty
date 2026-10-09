<?php 
class Testimonials_model extends CI_Model
{	
	protected $table = 'tbl_testimonials';
	public function save_testimonials($data)
	{
		$this->db->insert($this->table,$data);
	}
	public function get_all_testimonials()
	{
		$this->db->order_by("sort_order", "asc")->order_by("id", "asc");
		return $this->db->get($this->table)->result();
	}
	public function get_testimonials_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get($this->table)->result();
	}
	public function update_testimonials_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}
	public function get_all_active_testimonials()
	{
		$this->db->where('status',1);
			$this->db->order_by('id', 'desc');
		return $this->db->get($this->table)->result();
	}
	public function get_all_active_testimonials_home()
	{
		$this->db->where("status", "1");
		$this->db->order_by("sort_order", "asc")->order_by("id", "asc");
		return $this->db->get($this->table)->result();
	}
	
	public function delete_testimonials_by_id($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}
}

