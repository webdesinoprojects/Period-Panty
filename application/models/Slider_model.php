<?php 
class Slider_model extends CI_Model
{	
	protected $table = 'tbl_slider';
	public function initialize_hero_fields()
	{
		if ($this->db->field_exists("hero_note", $this->table)) { return; }
		$lock = "dexte_slider_note_" . sha1($this->db->database);
		$locked = $this->db->query("SELECT GET_LOCK(?, 10) AS acquired", array($lock))->row();
		if (!$locked || (int) $locked->acquired !== 1) { return; }
		try {
			if (!$this->db->field_exists("hero_note", $this->table)) {
				$this->load->dbforge();
				$this->dbforge->add_column($this->table, array("hero_note" => array("type" => "TEXT", "null" => TRUE)));
			}
		} finally {
			$this->db->query("SELECT RELEASE_LOCK(?)", array($lock));
		}
	}

	public function get_image_url($image)
	{
		// Versioned campaign replacements; custom CMS uploads keep their own URL.
		if (preg_match('/^dx-lifestyle-hero-v1-([123])\\.jpg$/', $image, $match)) {
			$asset = "assets/front/media/dx-lifestyle-hero-v2-" . $match[1] . ".jpg";
			if (is_file(FCPATH . $asset)) { return base_url($asset); }
		}
		return base_url("uploads/slider/" . $image);
	}
	public function save_slider($data)
	{
		$this->db->insert($this->table,$data);
	}
	public function get_all_slider()
	{
		return $this->db->get($this->table)->result();
	}
	public function get_slider_by_id($id)
	{
		$this->db->where('id',$id);
		return $this->db->get($this->table)->result();
	}
	public function update_slider_by_id($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}
	public function get_all_active_slider()
	{
		$this->db->where('status',1);
		return $this->db->get($this->table)->result();
	}
	public function delete_slider_by_id($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}
}
