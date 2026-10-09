<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Home_content_model extends CI_Model
{
    // Additive, restart-safe migration; deleted defaults are never re-imported.
    public function initialize()
    {
        // Welcome.php calls this from two actions, so once per request is enough.
        static $settled = false;
        if ($settled) {
            return;
        }
        $key = "20261009_home_faq_review_admin_v2";

        // Hot path: once the marker is in place this is the only work done, and
        // the CREATE TABLE below is skipped entirely. It used to run on every
        // homepage and /FAQs request for the life of the site.
        $has_table = $this->db->table_exists("tbl_home_content_migrations");
        if ($has_table && $this->db->where("migration", $key)->count_all_results("tbl_home_content_migrations")) {
            $settled = true;
            return;
        }
        if (!$has_table) {
            $this->db->query("CREATE TABLE IF NOT EXISTS tbl_home_content_migrations (
                migration VARCHAR(100) NOT NULL PRIMARY KEY,
                applied_at DATETIME NOT NULL
            ) ENGINE=InnoDB");
        }
        // Serialize first-time ALTERs as well as the default import.
        $lock = "dexte_cms_" . sha1($this->db->database);
        $locked = $this->db->query("SELECT GET_LOCK(?, 10) AS acquired", array($lock))->row();
        if (!$locked || (int) $locked->acquired !== 1) {
            // This runs from the public homepage, so throwing here is a 500 for
            // a visitor. Another request already holds the lock and will finish
            // in moments; wait for its marker instead, then carry on.
            for ($attempt = 0; $attempt < 20; $attempt++) {
                usleep(250000);
                if ($this->db->where("migration", $key)->count_all_results("tbl_home_content_migrations")) {
                    $settled = true;
                    return;
                }
            }
            log_message("error", "DEXTE home CMS migration could not acquire its lock; skipping this request.");
            return;
        }
        try {
            if ($this->db->where("migration", $key)->count_all_results("tbl_home_content_migrations")) {
                return;
            }
            $this->load->dbforge();
            foreach (array("tbl_faq", "tbl_testimonials") as $table) {
                if (!$this->db->field_exists("sort_order", $table)) {
                    $this->dbforge->add_column($table, array("sort_order" => array("type" => "INT", "default" => 0)));
                }
            }
            if (!$this->db->field_exists("card_type", "tbl_testimonials")) {
                $this->dbforge->add_column("tbl_testimonials", array("card_type" => array("type" => "VARCHAR", "constraint" => 16, "default" => "auto")));
            }
            if (!$this->db->field_exists("poster", "tbl_testimonials")) {
                $this->dbforge->add_column("tbl_testimonials", array("poster" => array("type" => "VARCHAR", "constraint" => 255, "default" => "")));
            }
            if (!$this->db->field_exists("rating", "tbl_testimonials")) {
                $this->dbforge->add_column("tbl_testimonials", array("rating" => array("type" => "TINYINT", "unsigned" => true, "default" => 5)));
            }
            require __DIR__ . "/home_content_defaults.php";
            $this->db->trans_start();
            $this->db->insert("tbl_home_content_migrations", array("migration" => $key, "applied_at" => date("Y-m-d H:i:s")));
            if (!$this->db->count_all("tbl_faq")) {
                foreach ($config["home_faq_defaults"] as $faq) {
                    $faq["create_date"] = date("Y-m-d H:i:s");
                    $this->db->insert("tbl_faq", $faq);
                }
            }
            if (!$this->db->count_all("tbl_testimonials")) {
                foreach ($config["home_review_defaults"] as $index => $review) {
                    $review += array("country" => "", "package" => "", "image" => "", "poster" => "", "youtube_link" => "", "description" => "", "status" => "1");
                    $review["type"] = $review["card_type"] === "video" ? "Video" : "Image";
                    $review["sort_order"] = $index + 1;
                    $this->db->insert("tbl_testimonials", $review);
                }
            }
            $this->db->trans_complete();
            if (!$this->db->trans_status()) {
                // Same reasoning as the lock above: log and let the page render
                // rather than turning a failed import into a public 500.
                log_message("error", "DEXTE home CMS content import failed and was rolled back.");
                return;
            }
            $settled = true;
        } finally {
            $this->db->query("SELECT RELEASE_LOCK(?)", array($lock));
        }
    }

    public function card_type($review)
    {
        if (isset($review->card_type) && in_array($review->card_type, array("quote", "photo", "video"), true)) {
            return $review->card_type;
        }
        if ($review->type === "Video") {
            return "video";
        }
        return empty($review->image) ? "quote" : "photo";
    }

    public function form_token()
    {
        $token = $this->session->userdata("home_content_token");
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->set_userdata("home_content_token", $token);
        }
        return $token;
    }

    public function valid_form_token()
    {
        $expected = $this->session->userdata("home_content_token");
        $received = $this->input->post("home_content_token");
        return is_string($expected) && is_string($received) && $expected !== "" && hash_equals($expected, $received);
    }

    public function media_url($path)
    {
        if (!$path) {
            return "";
        }
        // Bundled defaults remain in assets; new uploads live in uploads/testimonials.
        if (preg_match("~^assets/front/media/[a-zA-Z0-9_.-]+$~D", $path)) {
            return base_url($path);
        }
        return base_url("uploads/testimonials/" . rawurlencode(basename($path)));
    }

    public function video_url($url)
    {
        $parts = parse_url(trim($url));
        if (!$parts || empty($parts["host"]) || empty($parts["scheme"]) || !in_array(strtolower($parts["scheme"]), array("http", "https"), true)) {
            return "";
        }
        return trim($url);
    }

    public function iframe_url($url)
    {
        $url = $this->video_url($url);
        $parts = parse_url($url);
        if (!$parts || empty($parts["host"])) {
            return "";
        }
        $host = strtolower($parts["host"]);
        $path = isset($parts["path"]) ? $parts["path"] : "";
        $id = "";
        if (in_array($host, array("youtube.com", "www.youtube.com", "m.youtube.com"), true)) {
            parse_str(isset($parts["query"]) ? $parts["query"] : "", $query);
            if ($path === "/watch") {
                $id = isset($query["v"]) ? $query["v"] : "";
            } elseif (preg_match("~^/(?:shorts|embed)/([a-zA-Z0-9_-]+)~", $path, $match)) {
                $id = $match[1];
            }
        } elseif ($host === "youtu.be") {
            $id = trim($path, "/");
        }
        return preg_match("~^[a-zA-Z0-9_-]{11}$~D", $id) ? "https://www.youtube-nocookie.com/embed/" . $id : "";
    }
}
