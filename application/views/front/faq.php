<?php
$page = !empty($RESULT) ? $RESULT[0] : null;
$title = $page && $page->meta_title ? $page->meta_title : "Frequently Asked Questions | DEXTE";
$description = $page && $page->meta_description ? $page->meta_description : "Answers to common questions about DEXTE period underwear.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo html_escape($title); ?></title>
  <meta name="description" content="<?php echo html_escape($description); ?>">
  <link rel="canonical" href="<?php echo html_escape($page && $page->canonical ? $page->canonical : base_url("FAQs")); ?>">
  <?php $this->load->view("front/layout/head"); ?>
</head>
<body>
  <?php $this->load->view("front/layout/header"); ?>
  <main>
    <?php $this->load->view("front/home_faqs", array("FAQS" => $faq)); ?>
  </main>
  <?php $this->load->view("front/layout/footer"); ?>
  <?php $this->load->view("front/layout/footer-js"); ?>
</body>
</html>
