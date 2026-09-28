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
<?php $this->load->view('front/layout/header-2'); ?>

    <div class="about-content margin-top-30">
      <div class="container">
     
        <div class="row">
    
          <div class="col-sm-12">
            <div class="tab-pane active" role="tabpanel" id="tab_1">
              <div class="ps-block--product-set">
               
                <div class="ps-block__content row">
                    <div class="col-sm-8">
                        <h3><?php  echo $RESULT[0]->title ; ?></h3>
                         <div class="text-justify"> <?php  echo $RESULT[0]->description ; ?></div>
                        <?php if(isset($REWARDS)){ ?>
                        <h3> Total Reward : <span style="color:#85c440"><?php echo($REWARDS['total'] > 0) ?$REWARDS['total'] : "0" ?> Point</span>  </h3>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4">
                        <img src="<?php echo base_url('uploads/page/').$RESULT[0]->image  ;?>" style="width:100%" >
                        
                        
                    </div>
                    
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <script>
    function copyFunction() {
   /* Get the text field */
   var copyText = document.getElementById("copy_code");
   /* Select the text field */
   copyText.select();
   /* Copy the text inside the text field */
   document.execCommand("Copy");
    
    $('#copy_msg').text('Copied the text'); 
   
 }
</script>
<?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>
