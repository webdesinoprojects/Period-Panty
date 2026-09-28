<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php  echo $RESULT[0]->meta_title ; ?></title>
<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
<?php $this->load->view('front/layout/head'); ?>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>
<section class="py-2 bg-gray-2">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
        <li class="breadcrumb-item"><a class="text-decoration-none text-body" href="<?php echo base_url() ?>">Home</a>
        </li>
        <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page"><?php  echo $RESULT[0]->title ; ?>
        </li>
      </ol>
    </nav>
  </div>
</section>

  <section class="pt-8 pb-md-7 pb-10 pb-lg-5">
        <div class="container">
             <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-02 text-center">
                        
                        <h3> <?php echo $RESULT[0]->title; ?> </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-left">
                     
                        <?php echo $RESULT[0]->description; ?>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <!-- about content end  -->
 
<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>
