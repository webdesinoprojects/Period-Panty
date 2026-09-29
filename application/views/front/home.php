<!doctype html>
<?php $link = $this->setting_model->get_all_setting();?>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php  echo $RESULT[0]->meta_title ; ?></title>
    <meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
    <meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
    <link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
    <meta property="og:url" content="https://www.dexteshop.com/" />

    <meta property="og:type" content="website" />
    
    <meta property="og:title" content="Period Panties in India: Comfortable & Reliable | DEXTE" />
    
    <meta property="og:description" content="Are you searching for reliable and comfortable period panties in India? Look no further! DEXTE brings you a comprehensive range of period panties designed to provide unparalleled comfort and protection during your menstrual cycle. Call Now +91-9311268555" />
    <?php $this->load->view('front/layout/head'); ?>
</head>

<body>
     <?php $this->load->view('front/layout/header'); ?>
 <section class="mx-0 slick-slider dots-inner-center custom-slider-02 slider" data-slick-options='{"slidesToShow": 1,"infinite":true,"autoplay":true,"dots":true,"arrows":false,"fade":true,"cssEase":"ease-in-out","speed":2000}'>
            <?php $slider = $this->slider_model->get_all_active_slider();?>
            <?php foreach($slider as $sliders ){ ?>
            <?php if($sliders->type=='Upper'){ ?>
         
            <div class="box px-0">
                <div class="bg-img-cover-center py-8 py-lg-14" style="background-image: url('<?php echo base_url();?>uploads/slider/<?php echo $sliders->image?>');">
                    <div class="container container-xl pt-7 pb-9">
                        <div data-animate="fadeInDown">
                            <h1 class="font-weight-500 mb-5 fs-48 fs-md-68 lh-128" style="color: <?php echo $sliders->color; ?>">
                               <?php echo $sliders->title; ?>
                            </h1>
                            <p class=" mb-5 font-weight-600 fs-24 lh-15" style="color: <?php echo $sliders->color; ?>">
                             <?php echo $sliders->description; ?>
                            </p>
                        </div>
                        
                         <a href="<?php if($sliders->button_link){ echo  $sliders->button_link; }else{ echo base_url('shop') ; }  ?>" style="color: <?php echo $sliders->color; ?>" class="btn btn-link btn-light bg-transparent  border-bottom border-0 rounded-0 p-0 fs-16 font-weight-600 border-2x" data-animate="fadeInUp">
                              <?php echo $sliders->button_title; ?>
                                <svg class="icon icon-arrow-right">
                                    <use xlink:href="#icon-arrow-right"></use>
                                </svg>
                            </a>
                       
                    </div>
                </div>
            </div>
            <?php }?>
            <?php }?>
          

        </section>
  
        <section class="wemakes pt-8 ">
          <div class="container container-xl">
            <div class="row">
            <?php foreach($slider as $sliders ){ ?>
            <?php if($sliders->type=='Middle'){ ?>
              <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <a href="<?php if($sliders->button_link){ echo  $sliders->button_link; }else{ echo base_url('shop') ; }  ?>">
                  <div class="card border-0 hover-shine banner banner-02" data-animate="fadeInUp">
                    <div class="card-img bg-img-cover-center" style="background-image: url('<?php echo base_url();?>uploads/slider/<?php echo $sliders->image?>');"></div>
                  </div>
                </a>
              </div>
                <?php }?>
            <?php }?>
             
            </div>
          </div>
        </section>
        <section class=" pt-8">
          <div class="container container-xl">
            <div class="row mb-md-6 mb-8">
              <div class="col-md-6">
                <span class="dx-eyebrow">Our bestsellers</span>
                <h2 class="fs-34" data-animate="fadeInUp">Shop Our <strong>Best Sellers</strong></h2>
              </div>
              <div class="col-md-6 text-md-right">
                <a href="<?php echo base_url('shop') ?>" class="btn btn-link p-0 mt-2">Shop All Products<i class="far fa-arrow-right pl-2 fs-13"></i></a>
              </div>
            </div>
            <div class="slick-slider mx-n2" data-slick-options='{"slidesToShow": 5,"dots":false,"arrows":true,"responsive":[{"breakpoint": 1368,"settings": {"arrows":false,"dots":true}},{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false,"dots":true}},{"breakpoint": 992,"settings": {"slidesToShow":2,"arrows":false,"dots":true}},{"breakpoint": 768,"settings": {"slidesToShow": 2,"arrows":false,"dots":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":true}}]}'>
        
                <?php foreach($PRODUCTS as $key=>$value){ ?>
                <?php $data['product'] = $value; ?>
                    <div  class="box">
                         <?php $this->load->view('front/product/listing-view' , $data); ?>
                    </div> 
                 <?php } ?>
            
            </div>
          </div>
        </section>
        <section class="pt-2 pb-2">
          <img src="<?php echo base_url('assets/front/') ?>images/ourimg/newbg1.jpg">
        </section>
        <section class="py-8 dx-band">
            <div class="container container-xl">
                <div class="row">
                    <div class="col-12 text-center mb-7">
                        <span class="dx-eyebrow">Find your fit</span>
                        <h2 class="fs-34" data-animate="fadeInUp">Shop By <strong>Style</strong></h2>
                    </div>
                    <div class="col-12 col-lg-6">
                        <?php $first  =  $this->category_model->get_category_by_id(4) ;   ?>
                        <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                        <img src="assets/front/images/3.jpg" alt="<?php echo $first[0]->title; ?>" class="card-img">
                            <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                <div>
                                  <a href="<?php echo base_url().$first[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $first[0]->title; ?> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <?php $Second =  $this->category_model->get_category_by_id(1) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php $Second =  $this->category_model->get_category_by_id(2) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php $Second =  $this->category_model->get_category_by_id(3) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php $Second =  $this->category_model->get_category_by_id(5) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                 
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include('flows_marquee.php'); ?>
        <section class="py-8">
            <a href="<?php echo base_url('shop') ?>">
                 <img src="<?php echo base_url('assets/front/') ?>images/ourimg/newbg2.jpg">
            </a>
         
        </section>
        <section class="pt-lg-11 pb-lg-10 py-5" style="background:#deb08e;">
          <div class="container container-xl">
            <div class="row justify-content-center mb-7">
              <div class="col-12 text-center">
                <span class="dx-eyebrow dx-eyebrow-center">What&rsquo;s your flow?</span>
                <h2 class="fs-34 text-center fadeInUp animated" data-animate="fadeInUp">
                  Find The Right <strong>Absorbency Power</strong>
                </h2>
              </div>
            </div>
            <div class="row">
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Light
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      10 to 20 ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      Alone on light period days, as backup to other products, or for sneaky leaks & discharge.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Light
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Moderate
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      20 to 30 ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      Alone on your light or moderate period days, or as backup on your moderate days.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Moderate
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Heavy
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      30 to 40ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      Alone on your moderate period days, or as backup on your heavy days.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Heavy
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Super
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      40 to 50 ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      For those extra heavy days—or just whenever you need all the absorbency power you can get.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Super
                      </a>
                    </div>
                  </div>
                </div>
              </div>
        
            </div>
          </div>
        </section>
        <section class="pt-10 pb-6">
          <div class="container-fluid">
            <div class="row mb-md-6 mb-8">
              <div class="col-12">
                <span class="dx-eyebrow dx-eyebrow-center">How it works</span>
                <h2 class="fs-34 text-center" data-animate="fadeInUp">Period Underwear With <strong>Magic Membrane System</strong></h2>
              </div>
            </div>
            <img src="<?php echo base_url('assets/front/') ?>images/processdigram.webp">
          </div>
        </section>
        <hr>
        <section class="py-8 pt-lg-5 pb-lg-5" style="background-color:#F8F8F8" data-animated-id="10">
          <div class="container container-xl">
            <div class="row mx-0">
              <div class="col-lg-5 py-xl-6 py-lg-12 py-1">
                <div class="mw-lg-695 ml-auto py-lg-7">
                  <div class="fs-15 font-weight-600 text-uppercase letter-spacing-01 pb-2 text-secondary">DEXTE PERIOD PANTIES</div>
                  <h2 class="fs-34 pb-4">
                    How Period Panties 
                    Will Change Your Life
                  </h2>
                  <p class="text-gray-03 fs-15 mb-1 text-capitalize font-weight-600">
                
                    They're
                    <span class="spancolor">
                      Reusable
                    </span>
                  </p>
                  <p class="text-gray-03 fs-15 mb-1 text-capitalize font-weight-600">
                  
                    360<sup class="fs-10 font-weight-600">o</sup> Anti-leak
                    <span class="spancolor">
                      Protection
                    </span>
                  </p>
                  <p class="text-gray-03 fs-15 mb-1 text-capitalize font-weight-600">
               
                    Made With Ultra-soft & Breathable
                    <span class="spancolor">
                      Material
                    </span>
                  </p>
                  <p class="text-gray-03 fs-15 mb-1 text-capitalize font-weight-600">
                 
                    Holds Up To 40ml
                    <span class="spancolor">
                      Of Blood
                    </span>
                  </p>
                  <p class="text-gray-03 fs-15 mb-1 text-capitalize font-weight-600">
                    
                    On Heavy Flow Change
                    <span class="spancolor">
                      In 4-6 hour.
                    </span>
                  </p>
                  <!-- <p class="mb-0 fs-18 pt-1 text-body">Made using clean, non-toxic ingredients, our products <br /> are designed for everyone.</p>
                        <a href="#" class="btn btn-md rounded btn-light mt-6">Discover Now</a> -->
                </div>
              </div>
              <div class="col-lg-1 py-xl-1 py-lg-12 py-1">
               
              </div>
              <div class="col-lg-6 d-flex align-items-center justify-content-center py-lg-0 py-md-17 py-13" style="background-image: url('<?php echo base_url('assets/front/') ?>images/ourimg/videoimg.jpg');background-position: center;background-size: cover;">
                <a href="https://www.youtube.com/watch?v=F8S3SnAEE_0" data-gtf-mfp="true" data-mfp-options='{"type":"iframe","preloader":false}' class="btn btn-rounded btn-light w-115 h-115 d-flex justify-content-center align-items-center rounded-circle fs-30"><i class="fas fa-play"></i></a>
              </div>
            </div>
          </div>
        </section>
        <section class="pt-11 pb-md-7 pb-10 pb-lg-14" style="background: #f8f8f8;">
          <div class="container container-xl">
            <div class="row">
              <div class="col-md-3 mb-6 mb-md-0 px-xl-8">
                <div class="card border-0 text-center">
                  <div class="mw-102 mx-auto">
                    <img src="<?php echo base_url('assets/front/') ?>images/qu1.avif" alt="comfortable">
                  </div>
                  <div class="card-body px-0 pt-6 mt-1 pb-0">
                    <h3 class="fs-24 mb-3">Comfortable</h3>
                    <p class="mb-0">In Our products you feel just as beautiful and cozy as in your favorite underwear. </p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-6 mb-md-0 px-xl-8">
                <div class="card border-0 text-center">
                  <div class="mw-102 mx-auto">
                    <img src="<?php echo base_url('assets/front/') ?>images/qu2.avif" alt="sustainable">
                  </div>
                  <div class="card-body px-0 pt-6 mt-1 pb-0">
                    <h3 class="fs-24 mb-3">Sustainable</h3>
                    <p class="mb-0">With Our products you avoid tons of waste. </p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-6 mb-md-0 px-xl-8">
                <div class="card border-0 text-center">
                  <div class="mw-102 mx-auto">
                    <img src="<?php echo base_url('assets/front/') ?>images/qu3.avif" alt="leak-proof">
                  </div>
                  <div class="card-body px-0 pt-6 mt-1 pb-0">
                    <h3 class="fs-24 mb-3">Leak-Proof</h3>
                    <p class="mb-0">With Our products you don't have to worry about leakage. </p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-6 mb-md-0 px-xl-8">
                <div class="card border-0 text-center">
                  <div class="mw-102 mx-auto">
                    <img src="<?php echo base_url('assets/front/') ?>images/ourimg/eco.png" alt="leak-proof">
                  </div>
                  <div class="card-body px-0 pt-6 mt-1 pb-0">
                    <h3 class="fs-24 mb-3">Eco Friendly</h3>
                    <p class="mb-0">With Our products you don't have to worry about harm earth. </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="rg">
        <marquee width="100%" direction="left">
For every Sustain purchase, 1% of the purchase goes towards the animal and plantation fund, which helps to support the planet. Products like period underwear are designed to minimize waste, reducing the amount of used tampons and pads that end up in landfills.
</marquee>
</div>
        <section class="faqs py-8">
          <div class="container">
            <span class="dx-eyebrow dx-eyebrow-center">Good to know</span>
            <h2 class="fs-34 pb-8 text-center">
              Frequently Asked <strong>Questions</strong>
            </h2>
            <div class="row">
              <div class="col-12 mt-7 mt-md-0">
                <div id="accordion-style-01" class="accordion">
                  <div class="card border-1 mb-4 border-bottom-1">
                    <div class="card-header  border-0" id="headingOne">
                      <h5 class="mb-0 fs-18 w-100">
                        <a href="#" class="d-flex align-items-center border-bottom pb-2 text-decoration-none" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <span>
                          What is the use of period panties?
                          </span>
                          <span class="icon d-inline-block ml-auto"></span>
                        </a>
                      </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion-style-01">
                      <div class="card-body pt-4 pb-2 px-2">
                        <p>
                        They look like regular underwear, 
but they're designed to keep moisture away from your skin as they soak up menstrual blood. The fabric in period underwear contains a moisture-wicking fabric made up of thousands of small filaments. These fibers trap blood or other liquid to keep it from leaking onto your clothes.
                          </p>
                      </div>
                    </div>
                  </div>
                  <div class="card border-1 mb-4 border-bottom-1">
                    <div class="card-header border-0" id="headingTwo">
                      <h5 class="mb-0 fs-18 w-100">
                        <a href="#" class="d-flex align-items-center border-bottom pb-2 text-decoration-none collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                          <span>
                          Can you wear period panties all day?
                          </span>
                          <span class="icon d-inline-block ml-auto"></span>
                        </a>
                      </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-style-01">
                      <div class="card-body pt-4 pb-2 px-2">
                        <p>
                          This will depend on your flow, but period underwear can be worn all day if it's the right level of absorbency for your needs. DEXTE suggest you changing when you feel wetness — this is a sign it has absorbed all it's able to. Also, as your period progresses, the absorbency you require will change but on heavy flow we DEXTE suggest you to change with in 8 hours.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="card border-1 mb-4 border-bottom-1">
                    <div class="card-header border-0" id="headingThree">
                      <h5 class="mb-0 fs-18 w-100">
                        <a href="#" class="d-flex align-items-center border-bottom pb-2 text-decoration-none collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                          <span>
                          How do I wash period panties?
                          </span>
                          <span class="icon d-inline-block ml-auto"></span>
                        </a>
                      </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-style-01">
                      <div class="card-body pt-4 pb-2 px-2">
                        <p>
                        Wash – wash your period underwear in the hand or toss your period underwear into the washing machine at 30 degrees Celsius (or less) with a mild detergent on a delicate setting. Dry – then simply hang them to dry and you're done!
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="card border-1 mb-4 border-bottom-1">
                    <div class="card-header border-0" id="headingFour">
                      <h5 class="mb-0 fs-18 w-100">
                        <a href="#" class="d-flex align-items-center border-bottom pb-2 text-decoration-none collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                          <span>
                          Why make the switch to period underwear?
                          </span>
                          <span class="icon d-inline-block ml-auto"></span>
                        </a>
                      </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion-style-01">
                      <div class="card-body pt-4 pb-2 px-2">
                        <p>
                        Beyond the comfort factor and leak-proofing, period panties are also gaining popularity as both an ecologically sustainable and economically smart choice. Try them if you’re looking for a solution less irritating than tampons, more comfortable than sanitary pads, and less messy than using a menstrual cup. And with period panties, you’re always ready: No more frantic late-night tampon runs to the corner store.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="card border-1 mb-4 border-bottom-1">
                    <div class="card-header border-0" id="headingFive">
                      <h5 class="mb-0 fs-18 w-100">
                        <a href="#" class="d-flex align-items-center border-bottom pb-2 text-decoration-none collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                          <span>
                          How to care for period underwear?
                        </span>
                          <span class="icon d-inline-block ml-auto"></span>
                        </a>
                      </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion-style-01">
                      <div class="card-body pt-4 pb-2 px-2">
                        <p>
                          <b>
                          Step 1: Rinse 
                          </b>
                        </p>
                        <p class="mb-0">
                        After you remove your period panties, drop them in cold water to rinse them.
                        </p>
                        <p>
                          <b>
                          Step 2: Wash
                          </b>
                        </p>
                        <p class="mb-0">
                        If machine washing, first place them in a washable mesh bag and wash on the delicate or gentle cycle. To make your underwear last, consider hand-washing with a mild detergent.
                        </p>
                        <p>
                          <b>
                          Step 3: Dry
                          </b>
                        </p>
                        <p class="mb-0">
                        Do not put in dryer. Instead, lay underwear flat or hang dry to help maintain the fabric's integrity.
                        </p>
                        <p>
                          <b>
                          Step 4: Treat
                          </b>
                        </p>
                        <p class="mb-0">
                        Worried about stains or lingering smells? Period undies are designed to be stain-resistant and shouldn’t retain a scent if cared for properly, but you can soak them in vinegar/water mixture prior to laundering, too.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="card border-1 mb-4 border-bottom-1">
                    <div class="card-header border-0" id="headingsix">
                      <h5 class="mb-0 fs-18 w-100">
                        <a href="#" class="d-flex align-items-center border-bottom pb-2 text-decoration-none collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="headingsix">
                          <span>
                          Is period underwear a solution for my leaky bladder?
                          </span>
                          <span class="icon d-inline-block ml-auto"></span>
                        </a>
                      </h5>
                    </div>
                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion-style-01">
                      <div class="card-body pt-4 pb-2 px-2">
                        <p>
                        Generally, no, although  DEXTE has developed Speax, a line specifically for bladder protection.
                        </p>
                      </div>
                    </div>
                  </div>
                  <!--<div class="card border-1 mb-4 border-bottom-1">-->
                  <!--  <div class="card-header border-0" id="headingseven">-->
                  <!--    <h5 class="mb-0 fs-18 w-100">-->
                  <!--      <a href="#" class="d-flex align-items-center border-bottom pb-2 text-decoration-none collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="true" aria-controls="headingseven">-->
                  <!--        <span>-->
                  <!--        Helping  animals and plants while helping the planet-->
                  <!--        </span>-->
                  <!--        <span class="icon d-inline-block ml-auto"></span>-->
                  <!--      </a>-->
                  <!--    </h5>-->
                  <!--  </div>-->
                  <!--  <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion-style-01">-->
                  <!--    <div class="card-body pt-4 pb-2 px-2">-->
                  <!--      <p>-->
                  <!--      For every Sustain purchase, 1% of the purchase goes towards the animal and plantation fund, which helps to support the planet. Products like period underwear are designed to minimize waste, reducing the amount of used tampons and pads that end up in landfills.-->
                  <!--      </p>-->
                  <!--    </div>-->
                  <!--  </div>-->
                  <!--</div>-->
                </div>
              </div>
            </div>
          </div>
        </section>

       
  <?php $this->load->view('front/layout/footer'); ?>
  <?php $this->load->view('front/layout/footer-js'); ?>
        </body>
</html>