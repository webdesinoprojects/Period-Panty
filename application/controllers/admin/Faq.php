<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Faq extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("ADMIN_ID")) {
            redirect("admin", "location", 302);
        }
        $this->load->library("form_validation");
        $this->load->model(array("faq_model", "home_content_model"));
        $this->home_content_model->initialize();
        if ($this->input->method() === "post" && !$this->home_content_model->valid_form_token()) {
            show_error("Your form session expired. Reload the form and try again.", 403);
            exit;
        }
    }

    public function listing()
    {
        $this->load->view("admin/faq/listing", array("RESULT" => $this->faq_model->get_all_faq()));
    }

    public function add()
    {
        if ($this->input->method() === "post" && $this->save_form()) {
            redirect("admin/faq/listing", "location", 303);
        }
        $this->load->view("admin/faq/add");
    }

    public function edit($id = 0)
    {
        $records = $this->faq_model->get_faq_by_id((int) $id);
        if (!$records) {
            show_404();
            return;
        }
        if ($this->input->method() === "post" && $this->save_form($records[0])) {
            redirect("admin/faq/listing", "location", 303);
        }
        $this->load->view("admin/faq/edit", array("RESULT" => $records));
    }

    private function save_form($existing = null)
    {
        $this->form_validation->set_rules("title", "Question", "trim|required|max_length[100]");
        $this->form_validation->set_rules("description", "Answer", "trim|required");
        $this->form_validation->set_rules("status", "Status", "required|in_list[0,1]");
        $this->form_validation->set_rules("sort_order", "Display order", "required|integer|greater_than_equal_to[0]");
        if (!$this->form_validation->run()) {
            return false;
        }
        $data = array(
            "title" => $this->input->post("title", true),
            "description" => $this->input->post("description", true),
            "status" => $this->input->post("status"),
            "sort_order" => (int) $this->input->post("sort_order"),
        );
        if ($existing) {
            $this->faq_model->update_faq_by_id($existing->id, $data);
        } else {
            $data["create_date"] = date("Y-m-d H:i:s");
            $data["image"] = "";
            $this->faq_model->save_faq($data);
        }
        $this->session->set_flashdata("msg", '<div class="alert alert-success">FAQ saved. Active entries appear on the homepage.</div>');
        return true;
    }

    public function delete($id = 0)
    {
        if ($this->input->method() !== "post") {
            show_error("Use the delete button in FAQ admin.", 405);
            return;
        }
        if (!$this->faq_model->get_faq_by_id((int) $id)) {
            show_404();
            return;
        }
        $this->faq_model->delete_faq((int) $id);
        $this->session->set_flashdata("msg", '<div class="alert alert-success">FAQ deleted.</div>');
        redirect("admin/faq/listing", "location", 303);
    }
}
