<!doctype html>
<html>
  <?php $cms_page = $this->cms_model->get_cms_by_id(24);?>
 <title>   <?php  echo $cms_page[0]->meta_title; ?> </title>
    
    <meta name="description" content="<?php  echo $cms_page[0]->meta_description ; ?>">
    <meta name="keywords" content="<?php  echo $cms_page[0]->meta_keyword; ?>">
      <link rel="canonical" href="<?php  echo $cms_page[0]->canonical; ?>">
<head>
<?php $this->load->view('front/layout/head'); ?>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>
<section class="py-2 bg-gray-2">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
                <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page"><?php echo $RESULT[0]->title; ?></li>
            </ol>
        </nav>
    </div>
</section>
<div class="pt-9 pb-9">
    <div class="container">
        <div class="row">
 
            <div class="col-lg-12">
                <div class="dashboard-right">
                    <div class="dashboard">
                        
                       <?php echo $msg ;  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section end -->

<?php $this->load->view('front/layout/footer.php') ?>
<?php $this->load->view('front/layout/footer-js.php') ?>

</body>
</html>