<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>404</title>
<?php $this->load->view('front/layout/head'); ?>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>

<div class="pt-9 pb-9">
      <div class="container">
   
        <div class="error-content margin-top-30 text-center">
            <h2>Page not found.</h2>
            <h6>Sorry, but the page you are looking for is not found. Please, make<br> sure you have typed the current URL.</h6>
            <img src="<?php echo base_url('assets/front/') ?>/img/others/404.png" alt="">
            <div class="btn-wrapper">
                <a href="<?php echo base_url('') ?>" class="btn btn-error"><i class="icon-left-arrow-slider"></i> Go to home</a>
            </div>
        </div>
    </div>
    </div>
<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>


