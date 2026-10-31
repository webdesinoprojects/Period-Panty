<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_refresh_model extends CI_Model
{
    // One-time content migration. Subsequent CMS edits are never overwritten.
    public function initialize()
    {
        $migrations = array(
            '20261028_collections_contact_v1' => '20261028_collections_contact.sql',
            '20261028_needs_lifestyle_v1' => '20261028_needs_lifestyle.sql',
            '20261028_combo_gallery_teen_copy_v1' => '20261028_combo_gallery_teen_copy.sql',
            '20261028_teen_combo_approved_v1' => '20261028_teen_combo_approved.sql',
            '20261029_seamless_range_v1' => '20261029_seamless_range.sql',
            '20261029_sheet_copy_v1' => '20261029_sheet_copy.sql',
            '20261030_sheet_catalogue_v1' => '20261030_sheet_catalogue.sql',
            '20261031_featured_mix_v1' => '20261031_featured_mix.sql',
            '20261031_shorts_identity_v1' => '20261031_shorts_identity.sql',
        );
        foreach ($migrations as $key => $filename) {
            // A successor must never record success after its predecessor failed.
            if (!$this->apply($key, $filename)) { return FALSE; }
        }
        return TRUE;
    }

    private function apply($key, $filename)
    {
        static $done = array();
        if (isset($done[$key])) { return TRUE; }
        $table = 'tbl_site_refresh_migrations';
        if ($this->db->table_exists($table) && $this->db->where('migration', $key)->count_all_results($table)) {
            $done[$key] = TRUE; return TRUE;
        }
        $lock = 'dx_site_refresh_' . sha1($this->db->database);
        $result = $this->db->query('SELECT GET_LOCK(?, 10) AS acquired', array($lock))->row();
        if (!$result || (int) $result->acquired !== 1) { return FALSE; }
        $debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        try {
            if (!$this->db->query('CREATE TABLE IF NOT EXISTS ' . $table . ' (migration VARCHAR(100) PRIMARY KEY, applied_at DATETIME NOT NULL) ENGINE=InnoDB')) {
                throw new RuntimeException('Cannot initialize site content migration.');
            }
            if ($this->db->where('migration', $key)->count_all_results($table)) { $done[$key] = TRUE; return TRUE; }
            if ($key === '20261028_collections_contact_v1' && !$this->db->field_exists('email_secondary', 'tbl_setting')) {
                $this->load->dbforge();
                if (!$this->dbforge->add_column('tbl_setting', array('email_secondary' => array('type' => 'VARCHAR', 'constraint' => 254, 'default' => '')))) {
                    throw new RuntimeException('Cannot add secondary contact email.');
                }
            }
            $sql = file_get_contents(__DIR__ . '/sql/' . $filename);
            if ($sql === FALSE) { throw new RuntimeException('Missing site content migration.'); }
            if (!$this->db->trans_begin()) {
                throw new RuntimeException('Cannot begin site content migration.');
            }
            $this->check_targets($key);
            foreach (preg_split('/;\s*(?:\r?\n|$)/', trim($sql)) as $statement) {
                if (trim($statement) !== '' && !$this->db->query($statement)) {
                    throw new RuntimeException('Site content migration failed.');
                }
            }
            $this->check_result($key);
            if (!$this->db->insert($table, array('migration' => $key, 'applied_at' => date('Y-m-d H:i:s'))) || !$this->db->trans_status()) {
                throw new RuntimeException('Cannot record site content migration.');
            }
            if (!$this->db->trans_commit()) {
                throw new RuntimeException('Cannot commit site content migration.');
            }
            $done[$key] = TRUE;
            return TRUE;
        } catch (Exception $error) {
            $this->db->trans_rollback();
            log_message('error', $error->getMessage());
            return FALSE;
        } finally {
            $this->db->db_debug = $debug;
            $this->db->query('SELECT RELEASE_LOCK(?)', array($lock));
        }
    }

    private function require_count($sql, $expected, $key)
    {
        $query = $this->db->query($sql);
        $row = $query ? $query->row() : NULL;
        if (!$row || (int) $row->total !== $expected) {
            throw new RuntimeException('Site content migration target check failed: ' . $key);
        }
    }

    private function check_targets($key)
    {
        // Check target existence, not affected_rows(): an already-correct value
        // legitimately changes zero rows. Missing targets must roll back/retry.
        $checks = array(
            '20261028_collections_contact_v1' => array(
                array("SELECT COUNT(*) AS total FROM tbl_setting WHERE id = 1", 1),
                array("SELECT COUNT(DISTINCT url_slug) AS total FROM tbl_categories WHERE url_slug IN ('bamboo','cotton','combo','teen')", 4),
                array("SELECT COUNT(*) AS total FROM tbl_slider WHERE id IN (4,5) AND type = 'Middle'", 2),
            ),
            '20261028_needs_lifestyle_v1' => array(
                array("SELECT COUNT(DISTINCT title) AS total FROM tbl_slider WHERE type = 'Footer' AND title IN ('Teenagers','Working Women','Post Delivery','Spotting','Menopause','Urine Incontinence','Sports & Activities')", 7),
            ),
            '20261028_combo_gallery_teen_copy_v1' => array(
                array("SELECT COUNT(DISTINCT url_slug) AS total FROM tbl_products WHERE url_slug IN ('cotton-period-panty-pack-of-2','seamless-period-panty-pack-of-2','teen-period-panty-red','teen-period-panty-wine')", 4),
            ),
            '20261028_teen_combo_approved_v1' => array(
                array("SELECT COUNT(*) AS total FROM tbl_products WHERE url_slug = 'teen-period-panty-wine'", 1),
                array("SELECT COUNT(*) AS total FROM tbl_categories WHERE url_slug = 'combo'", 1),
            ),
            '20261029_seamless_range_v1' => array(
                array("SELECT COUNT(*) AS total FROM tbl_products WHERE id IN (1,6,7,8,9,10,11,14,15,16,17,18,19,20,21,28) AND delete_flag = '0'", 16),
                array("SELECT COUNT(*) AS total FROM tbl_categories WHERE url_slug = 'seamless'", 1),
            ),
            '20261029_sheet_copy_v1' => array(
                array("SELECT COUNT(*) AS total FROM tbl_products WHERE id IN (6,7) AND url_slug IN ('seamless-period-shorts-black','dexte-period-shorts-black','seamless-period-panty-black-lace','dexte-compression-period-shorts-black')", 2),
            ),
            '20261030_sheet_catalogue_v1' => array(
                array("SELECT COUNT(*) AS total FROM tbl_products WHERE id IN (6,7,30,31,34,36,37) AND delete_flag = '0'", 7),
                array("SELECT COUNT(*) AS total FROM tbl_categories WHERE url_slug = 'cotton'", 1),
            ),
            '20261031_featured_mix_v1' => array(
                array("SELECT COUNT(*) AS total FROM tbl_products WHERE id IN (1,6,8,20,32,35,37,38) AND status = '1' AND delete_flag = '0'", 8),
            ),
            '20261031_shorts_identity_v1' => array(
                // 9 is the donor of the seamless copy, so it has to be there too.
                array("SELECT COUNT(*) AS total FROM tbl_products WHERE id IN (7,9,28) AND status = '1' AND delete_flag = '0'", 3),
                array("SELECT COUNT(*) AS total FROM tbl_products WHERE id = 7 AND url_slug = 'dexte-compression-period-shorts-black'", 1),
            ),
        );
        if (isset($checks[$key])) {
            foreach ($checks[$key] as $check) { $this->require_count($check[0], $check[1], $key); }
        }
    }

    private function check_result($key)
    {
        if ($key === '20261028_collections_contact_v1') {
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_categories WHERE url_slug = 'seamless'", 1, $key);
        }
        if ($key === '20261028_combo_gallery_teen_copy_v1') {
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_product_images i JOIN tbl_products p ON p.id = i.product_id WHERE (p.url_slug = 'cotton-period-panty-pack-of-2' AND i.image = 'dx-combo-pack-v2.jpg') OR (p.url_slug = 'seamless-period-panty-pack-of-2' AND i.image IN ('dx-combo-seamless-pack2-v1.jpg','dx-combo-seamless-pack2-warm-v1.jpg'))", 3, $key);
        }
        if ($key === '20261029_seamless_range_v1') {
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE id IN (1,6,7,8,9,10,11,14,15,16,17,18,19,20,21,28) AND url_slug IN ('seamless-period-panty-zebra-print','seamless-period-shorts-black','seamless-period-panty-black-lace','seamless-period-panty-black','seamless-period-panty-berry-red','seamless-period-panty-beige','seamless-period-panty-deep-navy','seamless-period-panty-light-onion','seamless-period-panty-navy-blue','seamless-period-panty-coral-pink','seamless-period-panty-onion','seamless-period-panty-nude-pink','seamless-period-panty-pistachio','seamless-period-panty-tomato-red','seamless-period-panty-dark-orange','seamless-period-boyshorts-black')", 16, $key);
        }
        if ($key === '20261029_sheet_copy_v1') {
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE id IN (6,7) AND url_slug IN ('dexte-period-shorts-black','dexte-compression-period-shorts-black')", 2, $key);
        }
        if ($key === '20261028_teen_combo_approved_v1') {
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE url_slug = 'cotton-teen-period-panty-pack-of-2'", 1, $key);
        }
        if ($key === '20261031_shorts_identity_v1') {
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE id = 7 AND url_slug = 'seamless-period-panty-black-lace' AND price = 999.00", 1, $key);
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE id = 28 AND url_slug = 'dexte-compression-period-shorts-black' AND price = 1850.00", 1, $key);
            // The copy has to have actually moved, not just the names.
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE id = 7 AND short_description LIKE '%Seamless construction%'", 1, $key);
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE id = 28 AND short_description LIKE '%compression-style fit%'", 1, $key);
        }
        if ($key === '20261031_featured_mix_v1') {
            // The point of the migration is the spread, so check the spread:
            // eight cards drawn from five different collections.
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products WHERE is_featured = 'yes' AND status = '1' AND delete_flag = '0'", 8, $key);
            $this->require_count("SELECT COUNT(DISTINCT p.cat_id) AS total FROM tbl_products p WHERE p.is_featured = 'yes' AND p.status = '1' AND p.delete_flag = '0'", 5, $key);
        }
        if ($key === '20261030_sheet_catalogue_v1') {
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_products p JOIN tbl_categories c ON c.id = p.cat_id WHERE p.id IN (30,31,36,37) AND c.url_slug = 'cotton' AND p.price = 499.00", 4, $key);
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_product_variation WHERE product_id IN (30,31,36,37) AND UPPER(size) IN ('XXL','2XL','XXXL','3XL','XXXXL','4XL','XXXXXL','5XL','XXXXXXL','6XL') AND price = 599.00", 20, $key);
            $this->require_count("SELECT COUNT(*) AS total FROM tbl_product_images WHERE image IN ('dx-sheet-cotton-black-logo-v1.jpg','dx-sheet-cotton-black-angle-v1.jpg','dx-sheet-cotton-black-side-v1.jpg','dx-sheet-cotton-maroon-standing-v1.jpg','dx-sheet-cotton-wine-back-v1.jpg','dx-sheet-cotton-grey-back-v1.jpg','dx-sheet-cotton-grey-cutout-v1.png')", 7, $key);
        }
    }
}
