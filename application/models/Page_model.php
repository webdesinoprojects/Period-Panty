<?php 
class Page_model extends CI_Model
{	
	protected $table = 'tbl_page';
	/*start forum product model*/
	public function save_page($data)
	{
  
		$this->db->insert($this->table,$data);
	}

     public function get_all_page()
	{
		return $this->db->get($this->table)->result();
	}


	public function get_page_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get($this->table)->result();
	}
	public function update_page_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}
	
	public function delete_page_by_id($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}



}
