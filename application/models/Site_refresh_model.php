<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_refresh_model extends CI_Model
{
    // One-time content migration. Subsequent CMS edits are never overwritten.
    public function initialize()
    {
        $this->apply('20261028_collections_contact_v1', '20261028_collections_contact.sql');
        $this->apply('20261028_needs_lifestyle_v1', '20261028_needs_lifestyle.sql');
        $this->apply('20261028_combo_gallery_teen_copy_v1', '20261028_combo_gallery_teen_copy.sql');
        $this->apply('20261028_teen_combo_approved_v1', '20261028_teen_combo_approved.sql');
        $this->apply('20261029_seamless_range_v1', '20261029_seamless_range.sql');
    }

    private function apply($key, $filename)
    {
        static $done = array();
        if (isset($done[$key])) { return; }
        $table = 'tbl_site_refresh_migrations';
        if ($this->db->table_exists($table) && $this->db->where('migration', $key)->count_all_results($table)) {
            $done[$key] = TRUE; return;
        }
        $lock = 'dx_site_refresh_' . sha1($this->db->database);
        $result = $this->db->query('SELECT GET_LOCK(?, 10) AS acquired', array($lock))->row();
        if (!$result || (int) $result->acquired !== 1) { return; }
        $debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        try {
            if (!$this->db->query('CREATE TABLE IF NOT EXISTS ' . $table . ' (migration VARCHAR(100) PRIMARY KEY, applied_at DATETIME NOT NULL) ENGINE=InnoDB')) {
                throw new RuntimeException('Cannot initialize site content migration.');
            }
            if ($this->db->where('migration', $key)->count_all_results($table)) { $done[$key] = TRUE; return; }
            if ($key === '20261028_collections_contact_v1' && !$this->db->field_exists('email_secondary', 'tbl_setting')) {
                $this->load->dbforge();
                if (!$this->dbforge->add_column('tbl_setting', array('email_secondary' => array('type' => 'VARCHAR', 'constraint' => 254, 'default' => '')))) {
                    throw new RuntimeException('Cannot add secondary contact email.');
                }
            }
            $sql = file_get_contents(__DIR__ . '/sql/' . $filename);
            if ($sql === FALSE) { throw new RuntimeException('Missing site content migration.'); }
            $this->db->trans_begin();
            foreach (preg_split('/;\s*(?:\r?\n|$)/', trim($sql)) as $statement) {
                if (trim($statement) !== '' && !$this->db->query($statement)) {
                    throw new RuntimeException('Site content migration failed.');
                }
            }
            if (!$this->db->insert($table, array('migration' => $key, 'applied_at' => date('Y-m-d H:i:s'))) || !$this->db->trans_status()) {
                throw new RuntimeException('Cannot record site content migration.');
            }
            $this->db->trans_commit();
            $done[$key] = TRUE;
        } catch (Exception $error) {
            $this->db->trans_rollback();
            log_message('error', $error->getMessage());
        } finally {
            $this->db->db_debug = $debug;
            $this->db->query('SELECT RELEASE_LOCK(?)', array($lock));
        }
    }
}
