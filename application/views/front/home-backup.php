<?php error_reporting(); ?>
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
    <!-- banner start -->
    <div class="banner-style-01">                
        <div class="banner-slider">
            <?php $slider = $this->slider_model->get_all_active_slider();?>
            <?php foreach($slider as $sliders ){ ?>
            <?php if($sliders->type=='Upper'){ ?>
         
            <div>
                <div class="height__100vh d-flex align-items-center" style="background: url('<?php echo base_url();?>uploads/slider/<?php echo $sliders->image?>') no-repeat center center/cover">
                    <div class="container-fluid " style="padding-left: 1.9rem">
                        <div class="banner-content">
                           
                            <h2 class="title color-white" data-animation-in="fadeInRight"><?php echo $sliders->title; ?></h2>
                            <h3 class="subtitle" data-animation-in="fadeInLeft"><?php echo $sliders->description; ?></h3>
                            <?php if($sliders->button_link){ ?>
                            <div class=" pl-1">
                                <div class="btn-wrapper" data-animation-in="fadeInDown">
                                    <a class="btn btn-white" href="<?php echo $sliders->button_link; ?>"><?php echo $sliders->button_title; ?></a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php }?>
           
        </div>
    </div>
    <!-- banner end -->

      <!-- collection banner start  -->
    <div class="collection-banner">
        <div class="container">
            <div class="row justify-content-center">
            <?php $slider = $this->slider_model->get_all_active_slider();?>
            <?php foreach($slider as $sliders ){ ?>
            <?php if($sliders->type=='Middle'){ ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="<?php echo $sliders->button_link; ?>">
                    <div class="collection-style-02 margin-top-20">
                        <div class="thumb">
                             
                                <img src="<?php echo base_url();?>uploads/slider/<?php echo $sliders->image?>"alt="<?php  echo $sliders->title;?>">
                          
                                <div class="content">
                                    <h3><?php  echo $sliders->title;?></h3>
                                   
                                </div>
                        </div>
                    </div>
                    </a>
                </div>
                
                <?php }?>
                <?php } ?>
                
            </div>
        </div>
    </div>
    <!-- collection area end  -->
    <!-- tranding area start  -->
    <div class="tranding-area margin-top-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title-02 text-center">
                        <h6>CREATIVE, FUN & ORIGINAL</h6>
                        <h3>NEW IN TREND</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-pills tranding-tab">
                        <li class="mt-2"><a data-toggle="pill" href="#one" class="active">BOYS</a></li>
                        <li class="mt-2"><a data-toggle="pill" href="#two">GIRLS</a></li>
                       
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade in show active" id="one">
                    <div class="row">
                           <?php if(count($products_one)>0){ ?>
                            <?php foreach($products_one as $product){ ?>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-6 products-col-item">
                                <?php $data['product'] = $product ; ?>
                                <?php $this->load->view('front/product/listing-view' ,$data); ?>
                            </div>
                            <?php } ?>
                            <?php } ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="two">
                    <div class="row">
                          <?php if(count($products_two)>0){ ?>
                            <?php foreach($products_two as $product){ ?>
                             <div class="col-lg-3 col-md-4 col-sm-4 col-6 products-col-item">
                                <?php $data['product'] = $product ; ?>
                                <?php $this->load->view('front/product/listing-view' ,$data); ?>
                            </div>
                            <?php } ?>
                            <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row  justify-content-center">
                <div class="col-sm-12">
                    <center>
                         <a class="btn btn-black " href="<?php echo base_url('shop?where_clause=New Arrivals') ;?>" tabindex="0">View More</a>
                    </center>
                   
                </div>
                
            </div>
        </div>
    </div>
    <!-- tranding area end  -->
    <!-- collection section start  -->
    <div class="collection-section margin-top-30">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="collection-slider-02">
                         <?php $slider = $this->slider_model->get_all_active_slider();?>
                        <?php foreach($slider as $sliders ){ ?>
                        <?php if($sliders->type=='Footer'){ ?>
                        <div class="collection-slider-item margin-top-20">
                            <div class="thumb">
                                <img src="<?php echo base_url();?>uploads/slider/<?php echo $sliders->image?>" alt="">
                                <div class="thumb-content">
                                    <h4><?php echo $sliders->title; ?></h4>
                                    <h2><?php echo $sliders->description; ?></h2>
                                  
                                    <div class="btn-wrapper">
                                        <a  class="btn btn-collection" href="<?php echo $sliders->button_link; ?>"><?php echo $sliders->button_title; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <?php }?>
                        <?php }?>
  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- collection section end  -->
    <!-- arrivals area start  -->
    <div class="arrivals-area margin-top-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-02 text-center">
                        <h6 class="mb-0">COMFORTABLE & STYLISH </h6>
                        <h3 class="mb-0">LATEST COLLECTION</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-pills collection-tab mt-0">
                        <li class="margin-top-20"><a data-toggle="pill" href="#hot" class="active">New Arrivals </a></li>
                        <li class="margin-top-20"><a data-toggle="pill" href="#best">Best Sellers</a></li>
                        <li class="margin-top-20"><a data-toggle="pill" href="#sale">On Sale</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade in show active" id="hot">
                    <div class="row">
                         <?php if(count($is_latest)>0){ ?>
                            <?php foreach($is_latest as $product){ ?>
                             <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6   col-6 products-col-item">
                                <?php $data['product'] = $product ; ?>
                                <?php $this->load->view('front/product/listing-view' ,$data); ?>
                            </div>
                            <?php } ?>
                            <?php } ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="best">
                    <div class="row">
                         <?php if(count($best_seller)>0){ ?>
                            <?php foreach($best_seller as $product){ ?>
                             <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6   col-6 products-col-item">
                                <?php $data['product'] = $product ; ?>
                                <?php $this->load->view('front/product/listing-view' ,$data); ?>
                            </div>
                            <?php } ?>
                            <?php } ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="sale">
                    <div class="row">
                         <?php if(count($discounted_products)>0){ ?>
                            <?php foreach($discounted_products as $product){ ?>
                             <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6  col-6 products-col-item">
                                <?php $data['product'] = $product ; ?>
                                <?php $this->load->view('front/product/listing-view' ,$data); ?>
                            </div>
                            <?php } ?>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- arrivals area end  -->
    <div class="video-area margin-top-30 ">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-12">
                    <div class="video-content" style="background: url('<?php echo base_url('assets/front/') ?>img/others/video-banner.png') no-repeat center center/cover">
                        <a href="#" class="video-btn-style-02"><i class="fa fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <?php if(count($festival_special)>0){ ?>    
    <div class="fashion-area margin-top-30">
        <div class="container">
            
            <div class="fashion-slider ">
                    
                    <?php foreach($festival_special as $product){ ?>
                     
                        <?php $data['product'] = $product ; ?>
                        <?php $this->load->view('front/product/row-view' ,$data); ?>
                        
                
                    <?php } ?>

            </div>
        </div>
    </div>
    <?php } ?>
    <!-- article area start  -->
    <div class="article-area margin-top-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-02 margin-bottom-30 text-center">
                        <h6>FASHION FOR ALL</h6>
                        <h3>LATEST BLOG</h3>
                    </div>
                </div>
            </div>
                <?php if(count($blog)>0){ ?>    
                <div class="fashion-area margin-top-30">
                    <div class="container">
                        
                        <div class="collection-slider-03 ">
                                
                                <?php foreach($blog as $row){ ?>
                                 
                                    <?php $data['row'] = $row ; ?>
                                    <?php $this->load->view('front/blog/list-view-2' ,$data); ?>
                                    
                            
                                <?php } ?>
            
                        </div>
                    </div>
                </div>
                <?php } ?>
    
           
        </div>
    </div>
    <!-- article area end  -->
  
    <!-- contact area start  -->
    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-content text-center padding-top-80 padding-bottom-80 bg-image" style=" background: lightblue url('<?php echo base_url('images/') ?>apply for distributorship.jpg') no-repeat fixed center;" >
                        <h2>Apply for Distributorship/ Bulk orders / International Orders </h2>
                        
                       <a class="btn btn-collection" href="<?php echo base_url('apply-for-distributorship') ?>">APPLY NOW</a>
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact area end  -->
    <!-- delivery area start  -->
    <div class="delivery-area">
        <div class="container">
            <div class="border-bottom padding-top-20 padding-bottom-20 ">
                <div class="row justify-content-center">
                   
                        <div class="single-delivery-02  d-flex justify-content-center p-0 ">
                          
                            <div class="">
                                <center>
                                        <img src="<?php echo base_url('images/')?>Icons01.png" >
                                        <h6 class="text-center">Made in <br> India</h6>
                                </center>
                                
                            </div>
                        </div>
                   
                        <div class="single-delivery-02  d-flex justify-content-center p-0 ">
                          
                            <div class="">
                                  <center>
                                  <img src="<?php echo base_url('images/')?>Icons02.png" >
                                <h6 class="text-center">Support a <br> Child </h6>
                                 </center>
                            </div>
                        </div>
                 
                        <div class="single-delivery-02  d-flex justify-content-center p-0 ">
                          
                            <div class="">
                                  <center>
                                <img src="<?php echo base_url('images/')?>Icons03.png" >
                                <h6 class="text-center"> Made With <br> Love</h6>
                                 </center>
                            </div>
                        </div>
                   
                   
                        <div class="single-delivery-02  d-flex justify-content-center p-0 ">
                       
                            <div class="">
                                  <center>
                                <img src="<?php echo base_url('images/')?>Icons04.png" >
                                <h6 class="text-center">Soft Breathable  <br>Fabric</h6>
                                 </center>
                            </div>
                        </div>
                   

                        <div class="single-delivery-02  d-flex justify-content-center p-0 ">
                         
                            <div class="">
                                  <center>
                                 <img src="<?php echo base_url('images/')?>Icons05.png" >
                                <h6 class="text-center">Biodegradable <br> Packaging</h6>
                                </center>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- delivery area end  -->
 <?php $this->load->view('front/layout/footer'); ?>
    <?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>