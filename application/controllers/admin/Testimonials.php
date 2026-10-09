<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Testimonials extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("ADMIN_ID")) {
            redirect("admin", "location", 302);
        }
        $this->load->library(array("form_validation", "upload"));
        $this->load->model(array("testimonials_model", "home_content_model"));
        $this->home_content_model->initialize();
        if ($this->input->method() === "post" && !$this->home_content_model->valid_form_token()) {
            show_error("Your form session expired. Reload the form and try again.", 403);
            exit;
        }
    }

    public function listing()
    {
        $this->load->view("admin/testimonials/listing", array("RESULT" => $this->testimonials_model->get_all_testimonials()));
    }

    public function add_new()
    {
        if ($this->input->method() === "post" && $this->save_form()) {
            redirect("admin/testimonials/listing", "location", 303);
        }
        $this->load->view("admin/testimonials/add");
    }

    public function edit($id = 0)
    {
        $records = $this->testimonials_model->get_testimonials_by_id((int) $id);
        if (!$records) {
            show_404();
            return;
        }
        if ($this->input->method() === "post" && $this->save_form($records[0])) {
            redirect("admin/testimonials/listing", "location", 303);
        }
        $this->load->view("admin/testimonials/edit", array("RESULT" => $records));
    }

    private function save_form($existing = null)
    {
        $this->form_validation->set_rules("name", "Customer name / internal label", "trim|required|max_length[255]");
        $this->form_validation->set_rules("country", "Flow / subtitle", "trim|max_length[255]");
        $this->form_validation->set_rules("package", "Product / label", "trim|max_length[255]");
        $this->form_validation->set_rules("card_type", "Card type", "required|in_list[quote,photo,video]");
        $this->form_validation->set_rules("status", "Status", "required|in_list[0,1]");
        $this->form_validation->set_rules("sort_order", "Display order", "required|integer|greater_than_equal_to[0]");
        $this->form_validation->set_rules("rating", "Star rating", "required|integer|greater_than_equal_to[0]|less_than_equal_to[5]");
        if ($this->input->post("card_type") === "quote") {
            $this->form_validation->set_rules("description", "Review text", "trim|required");
        }
        if (!$this->form_validation->run()) {
            return false;
        }
        $type = $this->input->post("card_type");
        $url = trim((string) $this->input->post("youtube_link"));
        if ($url && (!$this->home_content_model->video_url($url) ||
            (!$this->home_content_model->iframe_url($url) && !preg_match("~\\.(mp4|webm|ogg)$~i", (string) parse_url($url, PHP_URL_PATH))))) {
            return $this->form_error("Use a YouTube link or a direct MP4, WebM or OGG video URL.");
        }
        $data = array(
            "name" => $this->input->post("name", true),
            "country" => $this->input->post("country", true),
            "package" => $this->input->post("package", true),
            "description" => $this->input->post("description", true),
            "type" => $type === "video" ? "Video" : "Image",
            "card_type" => $type,
            "youtube_link" => $type === "video" ? $url : "",
            "status" => $this->input->post("status"),
            "sort_order" => (int) $this->input->post("sort_order"),
            "rating" => (int) $this->input->post("rating"),
            "image" => $existing ? $existing->image : "",
            "poster" => $existing ? $existing->poster : "",
        );
        foreach (array("image", "poster") as $field) {
            if ($this->input->post("remove_" . $field)) {
                $data[$field] = "";
            }
        }
        if ($type === "quote") {
            $data["image"] = "";
            $data["poster"] = "";
        } elseif ($type === "photo") {
            $data["poster"] = "";
        }
        $uploaded = array();
        foreach (array("image", "poster") as $field) {
            if ($type === "quote" || ($type === "photo" && $field === "poster") || empty($_FILES[$field]["name"])) {
                continue;
            }
            $allowed = ($type === "video" && $field === "image") ? "mp4|webm|ogg" : "jpg|jpeg|png|webp";
            $result = $this->upload_media($field, $allowed);
            if (!$result) {
                foreach ($uploaded as $file) {
                    $this->remove_upload($file);
                }
                return false;
            }
            $data[$field] = $result;
            $uploaded[] = $result;
        }
        $extension = strtolower(pathinfo($data["image"], PATHINFO_EXTENSION));
        if ($type === "photo" && (!$data["image"] || !in_array($extension, array("jpg", "jpeg", "png", "webp"), true))) {
            foreach ($uploaded as $file) { $this->remove_upload($file); }
            return $this->form_error("Upload an image for a photo card.");
        }
        if ($type === "video" && !$data["youtube_link"] && (!$data["image"] || !in_array($extension, array("mp4", "webm", "ogg"), true))) {
            foreach ($uploaded as $file) { $this->remove_upload($file); }
            return $this->form_error("Upload a video or enter a video URL.");
        }
        if ($existing) {
            $this->testimonials_model->update_testimonials_by_id($existing->id, $data);
            foreach (array("image", "poster") as $field) {
                if ($existing->$field !== $data[$field]) {
                    $this->remove_upload($existing->$field);
                }
            }
        } else {
            $this->testimonials_model->save_testimonials($data);
        }
        $this->session->set_flashdata("msg", '<div class="alert alert-success">Review card saved. Active cards appear in the homepage rail.</div>');
        return true;
    }

    private function upload_media($field, $allowed)
    {
        $directory = FCPATH . "uploads/testimonials/";
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
            $this->form_error("The review upload folder could not be created.");
            return false;
        }
        $this->upload->initialize(array(
            "upload_path" => $directory,
            "allowed_types" => $allowed,
            "max_size" => $field === "poster" ? 5120 : 51200,
            "encrypt_name" => true,
        ));
        // Older deployments omit WebP from config/mimes.php.
        $mimes =& get_mimes();
        $mimes["webp"] = array("image/webp");
        if (!$this->upload->do_upload($field)) {
            $this->form_error(strip_tags($this->upload->display_errors()));
            return false;
        }
        return $this->upload->data("file_name");
    }

    private function remove_upload($file)
    {
        // Never delete bundled defaults, paths outside the upload directory, or shared files.
        if (!$file || basename($file) !== $file) {
            return;
        }
        $references = $this->db->group_start()->where("image", $file)->or_where("poster", $file)->group_end()->count_all_results("tbl_testimonials");
        if (!$references && is_file(FCPATH . "uploads/testimonials/" . $file)) {
            unlink(FCPATH . "uploads/testimonials/" . $file);
        }
    }

    private function form_error($message)
    {
        $this->session->set_flashdata("msg", '<div class="alert alert-danger">' . html_escape($message) . '</div>');
        return false;
    }

    public function delete_testimonial($id = 0)
    {
        if ($this->input->method() !== "post") {
            show_error("Use the delete button in Customer Review Rail admin.", 405);
            return;
        }
        $records = $this->testimonials_model->get_testimonials_by_id((int) $id);
        if (!$records) {
            show_404();
            return;
        }
        $this->testimonials_model->delete_testimonials_by_id((int) $id);
        $this->remove_upload($records[0]->image);
        $this->remove_upload($records[0]->poster);
        $this->session->set_flashdata("msg", '<div class="alert alert-success">Review card deleted.</div>');
        redirect("admin/testimonials/listing", "location", 303);
    }

    // Compatibility with the old listing link; deletion still requires POST.
    public function delete_Testimonials($id = 0)
    {
        $this->delete_testimonial($id);
    }
}
