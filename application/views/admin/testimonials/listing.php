<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer Review Rail</title>
  <?php $this->load->view("admin/layout/head_css"); ?>
  <link rel="stylesheet" href="<?php echo base_url("assets/admin/plugins/datatables/dataTables.bootstrap.css"); ?>">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php $this->load->view("admin/layout/header"); ?>
  <?php $this->load->view("admin/layout/sidebar"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Customer Review Rail</h1>
      <p>Only active entries are shown on the homepage. Lower display-order numbers appear first.</p>
      <a href="<?php echo base_url("admin/testimonials/add_new"); ?>" class="btn btn-primary">Add review card</a>
      <a href="<?php echo base_url(); ?>" class="btn btn-default" target="_blank" rel="noopener">View homepage</a>
    </section>
    <section class="content">
      <div class="box"><div class="box-body">
        <?php echo $this->session->flashdata("msg"); ?>
        <div class="table-responsive">
          <table id="example1" class="table table-bordered table-striped">
            <thead><tr><th>ID</th><th>Name / label</th><th>Card type</th><th>Flow / subtitle</th><th>Display order</th><th>Status</th><th data-orderable="false">Actions</th></tr></thead>
            <tbody>
              <?php foreach ($RESULT as $record) { ?>
              <tr>
                <td><?php echo (int) $record->id; ?></td>
                <td><?php echo html_escape($record->name); ?></td><td><?php echo html_escape(ucfirst($this->home_content_model->card_type($record))); ?></td><td><?php echo html_escape($record->country); ?></td>
                <td><?php echo (int) $record->sort_order; ?></td>
                <td><span class="label <?php echo $record->status == "1" ? "label-success" : "label-default"; ?>"><?php echo $record->status == "1" ? "Active" : "Inactive"; ?></span></td>
                <td>
                  <a href="<?php echo base_url("admin/testimonials/edit/" . $record->id); ?>" class="btn btn-success btn-xs">Edit</a>
                  <form method="post" action="<?php echo base_url("admin/testimonials/delete_testimonial/" . $record->id); ?>" style="display:inline-block" onsubmit="return confirm('Delete this review card?');">
                    <input type="hidden" name="home_content_token" value="<?php echo html_escape($this->home_content_model->form_token()); ?>">
                    <?php if ($this->config->item("csrf_protection")) { ?>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <?php } ?>
                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                  </form>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div></div>
    </section>
  </div>
  <?php $this->load->view("admin/layout/footer"); ?>
</div>
<?php $this->load->view("admin/layout/footer_js"); ?>
<script src="<?php echo base_url("assets/admin/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/admin/plugins/datatables/dataTables.bootstrap.min.js"); ?>"></script>
<script>
$(function () { $("#example1").DataTable({order: [[4, "asc"], [0, "asc"]]}); });
</script>
</body>
</html>

