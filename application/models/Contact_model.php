<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Contact_model extends CI_Model
{
    public function initialize()
    {
        if ($this->db->field_exists("delivery_status", "tbl_mail_info") && $this->db->field_exists("notification_attempted_at", "tbl_mail_info")) { return; }
        $lock = "dexte_contact_" . sha1($this->db->database);
        $locked = $this->db->query("SELECT GET_LOCK(?, 10) AS acquired", array($lock))->row();
        if (!$locked || (int) $locked->acquired !== 1) { return; }
        try {
            $this->load->dbforge();
            if (!$this->db->field_exists("delivery_status", "tbl_mail_info")) {
                $this->dbforge->add_column("tbl_mail_info", array("delivery_status" => array("type" => "VARCHAR", "constraint" => 16, "null" => TRUE)));
            }
            if (!$this->db->field_exists("notification_attempted_at", "tbl_mail_info")) {
                $this->dbforge->add_column("tbl_mail_info", array("notification_attempted_at" => array("type" => "DATETIME", "null" => TRUE)));
            }
        } finally {
            $this->db->query("SELECT RELEASE_LOCK(?)", array($lock));
        }
    }

    public function save($enquiry)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        try {
            if (!$this->db->insert("tbl_mail_info", $enquiry)) {
                log_message("error", "Contact enquiry could not be saved.");
                return FALSE;
            }
            return $this->db->insert_id();
        } finally { $this->db->db_debug = $debug; }
    }

    public function record_delivery($id, $status)
    {
        $this->db->where("id", $id)->update("tbl_mail_info", array("delivery_status" => $status, "notification_attempted_at" => date("Y-m-d H:i:s")));
    }
}
