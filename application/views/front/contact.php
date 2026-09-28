<?php $link = $this->setting_model->get_all_setting(); ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $RESULT[0]->meta_title; ?>
    </title>
    <meta name="description" content="<?php echo $RESULT[0]->meta_description; ?>">
    <meta name="keywords" content="<?php echo $RESULT[0]->meta_keyword; ?>">
    <link rel="canonical" href="<?php echo $RESULT[0]->canonical; ?>">
    <?php $this->load->view('front/layout/head'); ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <?php $this->load->view('front/layout/header'); ?>
  <section class="pt-lg-14 pb-lg-14 py-14 bg-img-cover-center" style="background-image: url('<?php echo base_url('assets/front/') ?>images/contact.jpg');">
    <div class="container pt-lg-8 pb-lg-7">
      <h1 class="fs-44 fs-lg-56 lh-121" data-animate="fadeInUp"><?php  echo $RESULT[0]->title ; ?></h1>
    </div>
  </section>
    <section class="pt-lg-12 pb-lg-13 pt-10 pb-11 text-center mx-auto" id="form">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-6">
                <div class="sec-title">
                    <!--<span class="sub-title">Send us email</span>-->
                    <h3>Feel Free To Write Us</h3>
                </div>
                <!-- Contact Form -->
                <form id="contact_form" name="contact_form" class="" action="mail.php" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_name" class="form-control" type="text" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_email" class="form-control required email" type="email"
                                    placeholder="Enter Email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_phone" class="form-control" type="text" placeholder="Enter Phone">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_subject" class="form-control required" type="text"
                                    placeholder="Enter Subject">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea name="form_message" class="form-control required" rows="7"
                            placeholder="Enter Message"></textarea>
                    </div>
                    <div class="mb-3">
                        <input name="form_botcheck" class="form-control" type="hidden" value="" />
                        <button type="submit" class="theme-btn btn-style-one" data-loading-text="Please wait..."><span
                                class="btn-title">Send message</span>
                            <span class="moveicon">
                                <img src="images/resource/arrow-up.svg" alt="">
                            </span></button>
                    </div>
                </form>
                <!-- Contact Form Validation-->
            </div>
            <div class="col-xl-5 col-lg-6 mt-20">
                <div class="contact-details__right">
                    <div class="sec-title">
                        <!--<span class="sub-title">Need any help?</span>-->
                        <h3>Contact Information</h3>
                    </div>
                    <div class="row align-items-end mb-4">
                        <div class="col-lg-3 col-4"> 
                            <div class="icn_data">
                                <svg class="icon icon-box-07 fs-40">
                                  <use xlink:href="#icon-box-07"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="col-lg-9 px-0 col-8">
                            <div class="content_data">
                                <h4>
                                    Location
                                </h4>
                                <p>
                                    Nanda Enclave Gali No. 2, Sector 19, Nanda Enclave, Dwarka, Delhi, 110075.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-end mb-4">
                        <div class="col-lg-3 col-4"> 
                            <div class="icn_data">
                                <svg class="icon icon-box-05 fs-40">
                                  <use xlink:href="#icon-box-05"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="col-lg-9 px-0 col-8">
                            <div class="content_data">
                                <h4>
                                    Call
                                </h4>
                                <p>
                                    <a href="tel:+91-9311268555">+91-9311268555</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-end mb-4">
                        <div class="col-lg-3 col-4"> 
                            <div class="icn_data">
                                <svg class="icon icon-box-05 fs-40">
                                  <use xlink:href="#icon-box-03"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="col-lg-9 px-0 col-8">
                            <div class="content_data">
                                <h4>
                                   Email
                                </h4>
                                <p>
                                    <a href="mailto:info@dexteshop.com">info@dexteshop.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <br>
            <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d1751.8932428068288!2d77.04699853251695!3d28.576173580638283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjjCsDM0JzM1LjQiTiA3N8KwMDInNTEuNCJF!5e0!3m2!1sen!2sin!4v1683889521530!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <?php $this->load->view('front/layout/footer'); ?>
    <?php $this->load->view('front/layout/footer-js'); ?>
</body>

</html>
