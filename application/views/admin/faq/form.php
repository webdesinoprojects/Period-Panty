<?php
$editing = !empty($RESULT);
$record = $editing ? $RESULT[0] : null;
$value = function ($field, $default = "") use ($record) {
    return html_escape(set_value($field, $record && isset($record->$field) ? $record->$field : $default, false));
};
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $editing ? "Edit" : "Add"; ?> Homepage FAQ</title>
  <?php $this->load->view("admin/layout/head_css"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php $this->load->view("admin/layout/header"); ?>
  <?php $this->load->view("admin/layout/sidebar"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo $editing ? "Edit" : "Add"; ?> Homepage FAQ</h1>
      <p>Active questions appear on the homepage and the FAQ page.</p>
    </section>
    <section class="content">
      <div class="box box-primary">
        <div class="box-body">
          <?php echo $this->session->flashdata("msg"); ?>
          <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form method="post">
            <input type="hidden" name="home_content_token" value="<?php echo html_escape($this->home_content_model->form_token()); ?>">
            <?php if ($this->config->item("csrf_protection")) { ?>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <?php } ?>
            <div class="form-group">
              <label for="faq-question">Question</label>
              <input id="faq-question" name="title" class="form-control" maxlength="100" value="<?php echo $value("title"); ?>" required>
            </div>
            <div class="form-group">
              <label for="faq-answer">Answer</label>
              <textarea id="faq-answer" name="description" class="form-control" rows="8" required><?php echo $value("description"); ?></textarea>
              <p class="help-block">Basic paragraph, bold and list formatting is supported.</p>
            </div>
            <div class="row">
              <div class="col-sm-6 form-group">
                <label for="faq-order">Display order</label>
                <input id="faq-order" type="number" name="sort_order" class="form-control" min="0" step="1" value="<?php echo $value("sort_order", "0"); ?>" required>
                <p class="help-block">Lower numbers appear first.</p>
              </div>
              <div class="col-sm-6 form-group">
                <label for="faq-status">Status</label>
                <select id="faq-status" name="status" class="form-control" required>
                  <option value="1"<?php echo set_value("status", $record ? $record->status : "1") === "1" ? " selected" : ""; ?>>Active</option>
                  <option value="0"<?php echo set_value("status", $record ? $record->status : "1") === "0" ? " selected" : ""; ?>>Inactive</option>
                </select>
              </div>
            </div>
            <button type="submit" name="submitform" value="1" class="btn btn-primary">Save FAQ</button>
            <a href="<?php echo base_url("admin/faq/listing"); ?>" class="btn btn-default">Cancel</a>
          </form>
        </div>
      </div>
    </section>
  </div>
  <?php $this->load->view("admin/layout/footer"); ?>
</div>
<?php $this->load->view("admin/layout/footer_js"); ?>
</body>
</html>
