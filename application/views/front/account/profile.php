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
<style>
    .btn-div{
        width:100%;
            border-radius: 5px;
            box-shadow: 2px 4px 10px rgb(0 0 0 / 20%);
            text-align:center;
            margin-bottom:20px;
    }
</style>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>

    <div class="about-content mt-4">
      <div class="container">
     
        <div class="row">
    
          <div class="col-sm-12">
            <div class="tab-pane active" role="tabpanel" id="tab_1">
              <div class="ps-block--product-set">
         
                <div class="ps-block__content">
                  <h3 style="color: #dc1f26;">Hello <span class="heading-color fwb"><?php echo @ucwords($user[0]->fname.' '.@$user[0]->lname); ?>!</h3>
            
                    <p class="fz14">From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.</p>
                   
                    <div class="row">
                        <div class="col-sm-4">
                            <a class="btn btn-div " style="color: #fff;background: rgb(3,177,38); background: radial-gradient(circle, rgba(3,177,38,1) 0%, rgba(3,192,60,1) 100%);" href="<?php echo base_url('user/my_orders'); ?>"> <i class="fa fa-list"></i> View Orders  </a>
                        </div> 
                     
                        <div class="col-sm-4">
                             <a class="btn btn-div"  style="color:#fff;background: rgb(220,31,38);background: radial-gradient(circle, rgba(220,31,38,1) 0%, rgba(201,30,37,1) 100%);"  href="<?php echo base_url('user/wishlist'); ?>"><i class="fa fa-heart"></i> Wishlist  </a>
                        </div> 
                        <div class="col-sm-4">
                             <a class="btn btn-div"  style="color: #fff;background: rgb(3,177,38); background: radial-gradient(circle, rgba(3,177,38,1) 0%, rgba(3,192,60,1) 100%);" href="<?php echo base_url('user/edit_profile'); ?>"><i class="fa fa-edit"></i> Edit Profile  </a>
                        </div> 
                        <div class="col-sm-4">
                             <a class="btn btn-div"  style="color:#fff;background: rgb(220,31,38);background: radial-gradient(circle, rgba(220,31,38,1) 0%, rgba(201,30,37,1) 100%);"  href="<?php echo base_url('user/change_password'); ?>"><i class="fa fa-cog"></i> Change Password  </a>
                        </div>
                        <div class="col-sm-4">
                             <a class="btn btn-div"  style="color:#fff; background: rgb(26,152,213);background: radial-gradient(circle, rgba(26,152,213,1) 0%, rgba(24,141,198,1) 100%);  " href="<?php echo base_url('user/logout'); ?>"><i class="fa fa-sign-out"></i> Logout </a> 
                        </div> 
                        
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
<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>

</body>
</html>
