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
<div class="dx-acct pt-9 pb-9">
      <div class="container">
     
        <div class="row">
       
             <div class="col-lg-3 mb-5 mb-lg-0"><?php $this->load->view('front/account/left-menu'); ?></div>
            <div class="col-lg-9">
                
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
                                    <div class="col-12">
                                      <div class="dx-panel"><div class="dx-empty">
                                        <i class="far fa-heart"></i>
                                        <p>Nothing saved yet. Tap the star on any product to keep it here.</p>
                                        <a href="<?php echo base_url('shop'); ?>" class="dx-acct-cta">Browse products</a>
                                      </div></div>
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