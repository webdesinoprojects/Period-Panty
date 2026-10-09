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
  <?php $this->load->view('front/about_redesign'); ?>
  <?php if (false) { ?>
  <section class="pt-lg-14 pb-lg-14 py-14 bg-img-cover-center" style="background-image: url('<?php echo base_url('assets/front/') ?>images/banners/about_us.jpg');">
    <div class="container pt-lg-8 pb-lg-7">
      <h1 class="fs-44 fs-lg-56 lh-121" data-animate="fadeInUp"><?php  echo $RESULT[0]->title ; ?></h1>
    </div>
  </section>

  <section class="pt-8 pb-md-7 pb-10 pb-lg-5">
    <div class="col-12  pl-lg-13 mt-lg-0 mt-8">
      <h5 class="mr-lg-10 mb-3 fadeInUp animated" data-animate="fadeInUp">
        EVERYBODY, EVERYDAY, EVERYWHERE
      </h5>
      <p class="mr-lg-10 fadeInUp animated zblk" data-animate="fadeInUp">
        DEXTE is a Great Indian brand, renowned for delivering the latest trends in a light hearted, feminine approach and
        making quality, comfort and style the most important features of our products.
      </p>
      <p class="mr-lg-10 fadeInUp animated zblk" data-animate="fadeInUp">
        At DEXTE we consider the needs of women of all ages, applying innovation, creative design and some Great India
        quirkiness to proudly deliver superb quality products at affordable prices, helping to give women confidence
        throughout their day.
      </p>
      <p class="mr-lg-10 fadeInUp animated zblk" data-animate="fadeInUp">
        Live it. Live Fearless.
      </p>
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
  <!-- banner start  -->

  <section data-animated-id="3">
    <div class="pt-xl-8 pb-xl-9 py-8 bg-primary">
      <div class="container">

        <h5 class="mx-auto text-center mw-850 fadeInUp animated text-white" data-animate="fadeInUp">
          “The visionary team here at DEXTE is deeply committed to changing the narrative around menstrual health and
          bladder leaks by creating a solutions-oriented future that moves beyond taboos. We're proud of the progress we've made — but we know this is just the beginning.”
        </h5>

      </div>
    </div>
  </section>

  <!-- banner start  -->
  <section class="pt-11 pt-lg-11 pb-lg-5 testimonials">
    <div class="container container-xl">
      <div class="row">
        <div class="col-lg-4 d-flex justify-content-center mb-8 mb-lg-0" data-animate="fadeInUp">
          <div>
            <h2>Testimonials</h2>
            <p class="fs-20" style="max-width:380px">Real Reviews From Real Customers</p>
          </div>
        </div>
        <div class="col-lg-8">
 <div class="slick-slider custom-arrows-02 custom-slider-04"
          data-slick-options='{"slidesToShow": 2,"centerMode":false,"infinite":true,"autoplay":true,"dots":false,"arrows":true,"fade":false,"cssEase":"ease-in-out","speed":600,"responsive":[{"breakpoint": 1024,"settings": {"slidesToShow":2}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}}]}'>


          <div class="box" data-animate="fadeInUp">
            <div class="card border-1  py-4 px-2 rounded">
              <div class="card-body px-3 py-0">
                <p class="text-black card-text mb-6 fs-20 font-weight-600 justi">
                  "No need to worry about leaks or odor."
                </p>
                <div class="media align-items-end">
                  <div class="media-body">
                    <h4
                      class="text-black text-left fs-15 font-weight-bold text-uppercase mb-1 letter-spacing-01 jus">
                      Varsha</h4>
                    <p class="card-text"></p>
                  </div>
                </div>
                <ul class="list-inline mb-4 text-left">
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                </ul>
               
              </div>
            </div>
          </div>

          <div class="box" data-animate="fadeInUp">
            <div class="card border-1  py-4 px-2 rounded">
              <div class="card-body px-3 py-0">
                <p class="text-black card-text mb-6 fs-20 font-weight-600 justi">
                  "A more comfortable and convenient product during your period days."</p>
                  
                <div class="media align-items-end">
                  <div class="media-body">
                    <h4
                      class="text-black text-left fs-15 font-weight-bold text-uppercase mb-1 letter-spacing-01 jus">
                      Ritika</h4>
                    <p class="card-text"></p>
                  </div>
                </div>
                <ul class="list-inline mb-4 text-left">
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                </ul>
             
              </div>
            </div>
          </div>

          <div class="box" data-animate="fadeInUp">
            <div class="card border-1  py-4 px-2 rounded">
              <div class="card-body px-3 py-0">
                <p class="text-black card-text mb-6 fs-20 font-weight-600 justi">
                 These are comfortable, absorbent, and leak-proof. </p>
                <div class="media align-items-end">
                  <div class="media-body">
                    <h4
                      class="text-black text-left fs-15 font-weight-bold text-uppercase mb-1 letter-spacing-01 jus">
                      Anjali</h4>
                    <p class="card-text"></p>
                  </div>
                </div>
                <ul class="list-inline mb-4 text-left">
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                  <li class="list-inline-item fs-14 text-primary mr-0"><i class="fas fa-star"></i>
                  </li>
                </ul>
               
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </section>
  <?php } ?>
  <?php $this->load->view('front/layout/footer'); ?>
  <?php $this->load->view('front/layout/footer-js'); ?>
</body>

</html>
