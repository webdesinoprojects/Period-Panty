<?php 
class Faq_model extends CI_Model
{	
	protected $table = 'tbl_faq';
	public function save_faq($data)
	{
		$this->db->insert('tbl_faq',$data);
	}

	public function get_all_faq()
	{
		$this->db->order_by("sort_order", "asc")->order_by("id", "asc");
		return $this->db->get('tbl_faq')->result();
	}
	public function get_faq_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get('tbl_faq')->result();
	}

	public function update_faq_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_faq',$data);
	}
     
     	public function get_all_active_faq()
	{
		$this->db->where("status", "1");
		$this->db->order_by("sort_order", "asc")->order_by("id", "asc");
		
		return $this->db->get('tbl_faq')->result();

	}

	function delete_faq($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}



}
