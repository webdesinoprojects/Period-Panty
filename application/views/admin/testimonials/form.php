<?php
$editing = !empty($RESULT);
$record = $editing ? $RESULT[0] : null;
$value = function ($field, $default = "") use ($record) {
    return html_escape(set_value($field, $record && isset($record->$field) ? $record->$field : $default, false));
};
$selected_type = set_value("card_type", $record ? $this->home_content_model->card_type($record) : "quote", false);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $editing ? "Edit" : "Add"; ?> Customer Review</title>
  <?php $this->load->view("admin/layout/head_css"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php $this->load->view("admin/layout/header"); ?>
  <?php $this->load->view("admin/layout/sidebar"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo $editing ? "Edit" : "Add"; ?> Customer Review Card</h1>
      <p>Manage the quote, photo and video cards in the homepage customer review rail.</p>
    </section>
    <section class="content">
      <div class="box box-primary">
        <div class="box-body">
          <?php echo $this->session->flashdata("msg"); ?>
          <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="home_content_token" value="<?php echo html_escape($this->home_content_model->form_token()); ?>">
            <?php if ($this->config->item("csrf_protection")) { ?>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <?php } ?>
            <div class="form-group">
              <label for="card-type">Card type</label>
              <select id="card-type" name="card_type" class="form-control" required>
                <?php foreach (array("quote" => "Text review", "photo" => "Customer photo", "video" => "Customer video") as $key => $label) { ?>
                <option value="<?php echo $key; ?>"<?php echo $selected_type === $key ? " selected" : ""; ?>><?php echo $label; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="review-name">Customer name / internal label</label>
              <input id="review-name" name="name" class="form-control" maxlength="255" value="<?php echo $value("name"); ?>" required>
              <p class="help-block">Shown on text reviews; used as the accessible title for video cards.</p>
            </div>
            <div class="form-group">
              <label for="review-flow">Flow / subtitle</label>
              <input id="review-flow" name="country" class="form-control" maxlength="255" value="<?php echo $value("country"); ?>" placeholder="Example: Heavy flow">
            </div>
            <div class="form-group">
              <label for="review-product">Product / internal label (optional)</label>
              <input id="review-product" name="package" class="form-control" maxlength="255" value="<?php echo $value("package"); ?>">
            </div>
            <div class="form-group" data-review-field="media">
              <label for="review-media">Upload photo or video</label>
              <input id="review-media" type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp,.mp4,.webm,.ogg">
              <p class="help-block">Photos: JPG, PNG or WebP. Videos: MP4, WebM or OGG. Maximum media size: 50 MB. Leave blank to keep the current file.</p>
              <?php if ($record && $record->image) {
                  $preview = $this->home_content_model->media_url($record->image);
                  if (preg_match("~\\.(mp4|webm|ogg)$~i", $record->image)) { ?>
              <video controls preload="none" src="<?php echo html_escape($preview); ?>" style="max-width:240px;max-height:260px"></video>
              <?php } else { ?>
              <img src="<?php echo html_escape($preview); ?>" alt="Current review media" style="max-width:240px;max-height:260px">
              <?php } ?>
              <label><input type="checkbox" name="remove_image" value="1"<?php echo set_value("remove_image") ? " checked" : ""; ?>> Remove current media</label>
              <?php } ?>
            </div>
            <div data-review-field="video">
              <div class="form-group">
                <label for="review-url">Video URL (optional alternative to uploading)</label>
                <input id="review-url" type="url" name="youtube_link" class="form-control" value="<?php echo $value("youtube_link"); ?>" placeholder="YouTube link or direct MP4 / WebM / OGG URL">
                <p class="help-block">When supplied, this URL is used instead of the uploaded video.</p>
              </div>
              <div class="form-group">
                <label for="review-poster">Video poster / thumbnail (optional)</label>
                <input id="review-poster" type="file" name="poster" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <p class="help-block">JPG, PNG or WebP, up to 5 MB.</p>
                <?php if ($record && $record->poster) { ?>
                <img src="<?php echo html_escape($this->home_content_model->media_url($record->poster)); ?>" alt="Current video poster" style="max-width:150px;max-height:180px">
                <label><input type="checkbox" name="remove_poster" value="1"<?php echo set_value("remove_poster") ? " checked" : ""; ?>> Remove current poster</label>
                <?php } ?>
              </div>
            </div>
            <div class="form-group">
              <label for="review-text">Review text / photo description</label>
              <textarea id="review-text" name="description" class="form-control" rows="5"><?php echo $value("description"); ?></textarea>
              <p class="help-block">Required for text reviews. Photo descriptions become accessible image text.</p>
            </div>
            <div class="row">
              <div class="col-sm-6 form-group">
                <label for="review-rating">Star rating (text reviews)</label>
                <input id="review-rating" type="number" name="rating" class="form-control" min="0" max="5" step="1" value="<?php echo $value("rating", "5"); ?>" required>
                <p class="help-block">1 to 5 stars. Set 0 to hide the stars.</p>
              </div>
              <div class="col-sm-6 form-group">
                <label for="review-order">Display order</label>
                <input id="review-order" type="number" name="sort_order" class="form-control" min="0" step="1" value="<?php echo $value("sort_order", "0"); ?>" required>
                <p class="help-block">Lower numbers appear first. Equal numbers are ordered by record ID.</p>
              </div>
              <div class="col-sm-6 form-group">
                <label for="review-status">Status</label>
                <select id="review-status" name="status" class="form-control" required>
                  <option value="1"<?php echo set_value("status", $record ? $record->status : "1") === "1" ? " selected" : ""; ?>>Active</option>
                  <option value="0"<?php echo set_value("status", $record ? $record->status : "1") === "0" ? " selected" : ""; ?>>Inactive</option>
                </select>
              </div>
            </div>
            <button type="submit" name="submitform" value="1" class="btn btn-primary">Save review card</button>
            <a href="<?php echo base_url("admin/testimonials/listing"); ?>" class="btn btn-default">Cancel</a>
          </form>
        </div>
      </div>
    </section>
  </div>
  <?php $this->load->view("admin/layout/footer"); ?>
</div>
<?php $this->load->view("admin/layout/footer_js"); ?>
<script>
(function () {
  var type = document.getElementById("card-type");
  function updateFields() {
    var video = type.value === "video";
    document.querySelector('[data-review-field="media"]').hidden = type.value === "quote";
    document.querySelector('[data-review-field="video"]').hidden = !video;
    document.getElementById("review-media").accept = video ? ".mp4,.webm,.ogg" : ".jpg,.jpeg,.png,.webp";
    document.getElementById("review-text").required = type.value === "quote";
  }
  type.addEventListener("change", updateFields);
  updateFields();
}());
</script>
</body>
</html>
