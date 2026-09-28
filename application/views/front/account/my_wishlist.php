<?php error_reporting() ; ?>
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
                <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page">Wishlist</li>
            </ol>
        </nav>
    </div>
</section>
<div class="pt-9 pb-9">
      <div class="container">
     
        <div class="row">
       
             <div class="col-sm-3"><?php $this->load->view('front/account/left-menu'); ?></div>
            <div class="col-sm-9">
                
               <div class="collection-area margin-top-20">
                            <div id="products-collections-filter" class="row">
                                  <?php if(count($PRODUCTS)>0){ ?>
                                    <?php foreach($PRODUCTS as $product){ ?>
                                    <?php $data['product'] = $product ; ?>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 products-col-item">
                                       
                                         <?php $this->load->view('front/product/listing-view' , $data); ?>
                                    </div>
                                    <?php } ?>
                                    <?php }else{ ?>
                                    <div class="col-md-12 col-sm-6">Sorry ! No Products Found
                                    </div>
                                    <?php } ?>
                                            
                                
                            </div>
                  
           
                </div>

                     
            </div>
        </div>
    </div>
    </div>
<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>