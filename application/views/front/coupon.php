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
<?php $this->load->view('front/layout/header-2'); ?>
    <!-- about content start  -->
      <div class="about-content margin-top-30">
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
    </div>
    <!-- about content end  -->
    <!-- faq start  -->
    <div class="faq-content margin-top-10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion-area">
                       
                        <div class="accordion-style" id="accordionExample1">
                            <?php if(count($coupon)>0){ ?>
                         
                            <?php $no=0; foreach($coupon as $key=> $record){ $no++; ?>
                            <div class="card">
                                <div class="card-header" id="heading<?php echo $record->id; ?>">
                                    <p class="mb-0">
                                        <a href="#" role="button" data-toggle="collapse" data-target="#collapse<?php echo $record->id; ?>" aria-expanded="<?php echo ($key == 0) ?"true" :"false" ; ?>" aria-controls="collapse<?php echo $record->id; ?>"> <?php echo $record->title; ?></a>
                                    </p>
                                </div>
                                <div id="collapse<?php echo $record->id; ?>" class="collapse <?php echo ($key == 0) ?"show" :"" ; ?>" aria-labelledby="headingOne" data-parent="#accordionExample1">
                                    <div class="card-body">
                                        <p class="alert alert-danger" style="width:250px; text-align:center"><?php echo $record->couponCode; ?></p>
                                         <p>
                                             <?php echo $record->description; ?>
                                         </p>
                                         <p>Offer valid up to <b> <?php echo date('d-m-Y',strtotime($record->disableDate)); ?> </b></p>
                                    </div>
                                </div>
                            </div>
                          
                             <?php } ?> 
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- faq end  -->

 
<?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>