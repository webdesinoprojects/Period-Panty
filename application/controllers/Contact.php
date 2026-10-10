<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Contact extends CI_Controller
{
    public function index()
    {
        $this->load->model("contact_model");
        $this->contact_model->initialize();
        $data["RESULT"] = $this->page_model->get_page_by_id(19);
        $data["contact_errors"] = array();
        $data["contact_notice"] = $this->session->flashdata("contact_notice");
        if (!$this->session->userdata("contact_token")) {
            $this->session->set_userdata("contact_token", bin2hex(random_bytes(32)));
        }
        if ($this->input->method() === "post") {
            $failure_status = 422;
            $token = $this->input->post("contact_token");
            $honeypot = $this->input->post("website");
            if (!is_string($token) || !hash_equals($this->session->userdata("contact_token"), $token)) {
                $data["contact_errors"]["form"] = "This form expired or was already sent. Refresh the page and try again.";
            } elseif (!is_string($honeypot) || $honeypot !== "") {
                $data["contact_errors"]["form"] = "We could not submit this form. Please refresh and try again.";
            } elseif (time() - (int) $this->session->userdata("contact_last_sent") < 45) {
                $data["contact_errors"]["form"] = "Your previous message was received. Please wait a moment before sending another.";
            } else {
                foreach (array("name", "email", "mobile", "subject", "message") as $field) {
                    if (!is_string($this->input->post($field))) {
                        $data["contact_errors"]["form"] = "Please complete the contact form with valid text.";
                    }
                }
                if (!$data["contact_errors"]) {
                    $this->form_validation->set_rules("name", "Name", "trim|required|max_length[200]");
                    $this->form_validation->set_rules("email", "Email", "trim|required|valid_email|max_length[254]");
                    $this->form_validation->set_rules("mobile", "Phone", "trim|max_length[30]|regex_match[/^[0-9+().\\s-]{6,30}$/]");
                    $this->form_validation->set_rules("subject", "Subject", "trim|required|max_length[200]");
                    $this->form_validation->set_rules("message", "Message", "trim|required|min_length[10]|max_length[5000]");
                    if (!$this->form_validation->run()) {
                        $data["contact_errors"] = $this->form_validation->error_array();
                    } else {
                        // Persist only known table fields, never raw POST or anti-spam tokens.
                        $enquiry = array();
                        foreach (array("name", "email", "mobile", "subject", "message") as $field) {
                            $enquiry[$field] = trim($this->input->post($field));
                        }
                        $enquiry["address"] = "";
                        $enquiry["create_date"] = date("Y-m-d H:i:s");
                        $enquiry["delivery_status"] = "pending";
                        $id = $this->contact_model->save($enquiry);
                        if (!$id) {
                            $data["contact_errors"]["form"] = "Your message could not be saved. Please try again or contact us by phone or email.";
                            $failure_status = 503;
                        } else {
                            $settings = $this->setting_model->get_all_setting();
                            $accepted = $this->send_notification($enquiry, $id, $settings[0]);
                            $this->contact_model->record_delivery($id, $accepted ? "accepted" : "failed");
                            $this->session->set_userdata("contact_last_sent", time());
                            $this->session->set_userdata("contact_token", bin2hex(random_bytes(32)));
                            $this->session->set_flashdata("contact_notice", array("id" => $id, "email_accepted" => $accepted));
                            redirect("contact-us#contact-form", "location", 303);
                            return;
                        }
                    }
                }
            }
            if ($data["contact_errors"]) { $this->output->set_status_header($failure_status); }
        }
        $data["contact_token"] = $this->session->userdata("contact_token");
        $this->load->view("front/contact", $data);
    }

    private function send_notification($enquiry, $id, $settings)
    {
        if (!filter_var($settings->email, FILTER_VALIDATE_EMAIL) || !filter_var($settings->from_email, FILTER_VALIDATE_EMAIL)) {
            log_message("error", "Contact notification has invalid sender or recipient settings. Enquiry #" . $id);
            return FALSE;
        }
        $this->email->clear(TRUE);
        $mail_config = array("mailtype" => "text", "charset" => "utf-8", "newline" => "\r\n", "crlf" => "\r\n", "smtp_timeout" => 10);
        // Optional authenticated SMTP; secrets belong in server environment,
        // never in contact forms, source code, logs or the public response.
        if (getenv("DEXTE_SMTP_HOST")) {
            $mail_config["protocol"] = "smtp";
            $mail_config["smtp_host"] = getenv("DEXTE_SMTP_HOST");
            $mail_config["smtp_port"] = getenv("DEXTE_SMTP_PORT") ?: 587;
            $mail_config["smtp_user"] = getenv("DEXTE_SMTP_USER") ?: "";
            $mail_config["smtp_pass"] = getenv("DEXTE_SMTP_PASS") ?: "";
            $mail_config["smtp_crypto"] = getenv("DEXTE_SMTP_CRYPTO") ?: "tls";
        }
        $this->email->initialize($mail_config);
        $this->email->from($settings->from_email, preg_replace('/[\r\n]+/', " ", $settings->title));
        $this->email->to($settings->email);
        $this->email->reply_to($enquiry["email"], preg_replace('/[\r\n]+/', " ", $enquiry["name"]));
        $this->email->subject("DEXTE contact enquiry #" . $id . ": " . preg_replace('/[\r\n]+/', " ", $enquiry["subject"]));
        $this->email->message("Contact enquiry #" . $id . "\n\nName: " . $enquiry["name"] . "\nEmail: " . $enquiry["email"] . "\nPhone: " . $enquiry["mobile"] . "\nSubject: " . $enquiry["subject"] . "\n\n" . $enquiry["message"]);
        $accepted = $this->email->send(FALSE);
        if (!$accepted) { log_message("error", "Contact email notification failed for enquiry #" . $id); }
        return $accepted;
    }
}
