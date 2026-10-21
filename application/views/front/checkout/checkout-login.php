<?php error_reporting() ; ?>
<?php $user_id=$this->session->userdata('USER_ID'); ?>
<?php $coupon=$this->session->userdata('coupon_data'); ?>
<?php $userdata=$this->user_model->get_user_by_id($user_id); ?>
<?php $link=$this->setting_model->get_all_setting();?>
<?php
$user_session=$_SESSION[ 'user_session'];
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $RESULT[0]->meta_title ; ?></title>
    <meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
    <meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
    <link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
    <?php $this->load->view('front/layout/head'); ?>
   
</head>

<body>
    <?php $this->load->view('front/layout/header'); ?>

   <section class="pb-11 pb-lg-13">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="checkout-box" id="checkout-box-1">
                            <div id="register">
                                <form  id="signup-form" method="post">
                                     <div class="checkout-heading">
                                        <h2>1. Register Your Account  </h2>
                                        <span class="edit-checkout-box">Edit</span>
                                    </div>
                                    <div class="checkout-box-inner">
                                        <p style="font-size: 12px;"> If you have already an account with us,<a style="color:blue" id="login_here"> Login here</a></p>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email"  required id="email" />
                                        <br>
                                        <input type="password" name="password" class="form-control" placeholder="Enter Password"  required  id="password"/>
                                        
                                        <p id="signup-box-msg"></p>    
                                        <button type="submit" class="btn btn-primary  btn-block mt-3 " id="registerButton">Continue</button>
                                    </div>
                                </form>
                               
                            </div>
                            <div id="login" style="display:none">
                                     <form id="signin-form"  method="post">
                                            <div class="checkout-heading">
                                                <h2>1. Login Your Account  </h2>
                                                <span class="edit-checkout-box">Edit</span>
                                            </div>
                                            <div class="checkout-box-inner">
                                                <p style="font-size: 12px;"> If you have not register with us ,<a style="color:blue" id="register_here"> Register here</a></p>
                                                <input type="text" name="email" class="form-control" placeholder="Email or phone number" id="member_email" />
                                                <br>
                                                <input type="password" name="password" class="form-control" placeholder="Enter Password" id="member_password" />
                                                <p id="signin-box-msg"></p>
                                                <button type="submit" class="btn btn-primary  btn-block mt-3 " id="loginButton">Continue</button>
                                            </div>
                                       
                                    </form>
                               </div>

                            <!-- Guest checkout: name + phone only. The account
                                 routes above are unchanged and still offered. -->
                            <div class="checkout-box-inner dx-guest-box">
                                <div class="dx-guest-divider"><span>or</span></div>
                                <h3 class="dx-guest-title">Checkout without an account</h3>
                                <p class="dx-guest-sub">Just your name and phone number &mdash; no email or password needed.</p>
                                <?php if ($this->session->flashdata('guest_error')) { ?>
                                <p class="dx-guest-error"><?php echo html_escape($this->session->flashdata('guest_error')); ?></p>
                                <?php } ?>
                                <form method="post" action="<?php echo base_url('checkout/guest_continue'); ?>">
                                    <input type="hidden" name="checkout_token" value="<?php echo html_escape($checkout_token); ?>">
                                    <?php if ($this->config->item("csrf_protection")) { ?>
                                    <input type="hidden" name="<?php echo html_escape($this->security->get_csrf_token_name()); ?>" value="<?php echo html_escape($this->security->get_csrf_hash()); ?>">
                                    <?php } ?>
                                    <input type="text" name="guest_name" class="form-control" placeholder="Your name" required maxlength="50" />
                                    <br>
                                    <input type="tel" name="guest_contact_no" class="form-control" placeholder="Phone number" required inputmode="numeric" pattern="[0-9+()\s-]{10,20}" maxlength="20" />
                                    <button type="submit" class="btn btn-outline-primary btn-block mt-3">Continue as guest</button>
                                </form>
                            </div>
                            </div>
                            <div class="checkout-box"  id="checkout-box-2">
                                <div class="checkout-heading">
                                    <h2>2. Shipping </h2>
                                    <span class="edit-checkout-box">Edit</span>
                                </div>
                               
                            </div>
                            <div class="checkout-box" id="checkout-box-3">
                                <div class="checkout-heading">
                                    <h2>3. Payment </h2>
                                    <span class="edit-checkout-box">Edit</span>
                                </div>

                              
                            </div>
                           
                        </div>
                         <div class="col-md-6">
                            <div class="checkout-box checkout-box-right">
                                <h2>Order Summary </h2>
                                <div class="order-summary-container">
                                   
                                    <?php $this->load->view('front/checkout/onpage-items'); ?>

                                    <hr>
                                    <div id="cart-total">
       
                                    </div>
                                    <hr>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
    .dx-guest-box { padding-top: 4px; }
    .dx-guest-divider { position: relative; text-align: center; margin: 22px 0 18px; }
    .dx-guest-divider::before { content: ""; position: absolute; left: 0; right: 0; top: 50%; border-top: 1px solid #e6ded8; }
    .dx-guest-divider span { position: relative; background: #fff; padding: 0 12px; color: #9a8f86; font-size: 12px; text-transform: uppercase; letter-spacing: .08em; }
    .dx-guest-title { font-size: 17px; margin: 0 0 4px; }
    .dx-guest-sub { font-size: 12px; color: #7d736b; margin-bottom: 14px; }
    .dx-guest-error { font-size: 12px; color: #b4304f; margin-bottom: 10px; }
    </style>
    <?php $this->load->view('front/layout/footer'); ?>
    <?php $this->load->view('front/layout/footer-js'); ?>
    </div>
    <?php $this->load->view('front/checkout/side-cart-js'); ?>
    <script>
     
        $(document).ready(function() {
            $('#register_here').on('click', function() {
                
                $('#email').prop('required', true);
                $('#password').prop('required', true);
                $('#member_email').prop('required', false);
                $('#member_password').prop('required', false);
                 $('#register').show();
                 $('#login').hide();
             
            });
            $('#login_here').on('click', function() {
                $('#email').prop('required', false);
                $('#password').prop('required', false);
                $('#member_email').prop('required', true);
                $('#member_password').prop('required', true);
                $('#register').hide();
                 $('#login').show();         
             
            });

        });
</script>
     <script type="text/javascript">
        $(document).ready(function() {
        $('#signin-form').submit(function () {  
        $('#loginButton').text('Processing....') ;  
          $.ajax({
                url: "<?php echo base_url('user/login_process') ?>",
                type: "POST",     
                data: $(this).serialize(),
                dataType: 'json',
               
                success: function(response){ //console.log(response);
                    $('#loginButton').text('Login') ;  
                    $('.statusMsg').html('');
                    if(response.status == 1){
                
                        $('#signin-box-msg').html(response.message);
                        location.reload();
       
                    }else{
                         $('#signin-box-msg').html(response.message);
                    }
                }
            
              });
          return false;
        });
    }); 
     </script>
     <script type="text/javascript">
    	$(document).ready(function() {
    		$('#signup-form').submit(function() {
    			$('#registerButton').text('Processing....');
    			var formData = new FormData(this);
    			$.ajax({
    				url: "<?php echo base_url('user/onepage_register_process') ?>",
    				type: "POST",
    				data: formData,
    				cache: false,
    				contentType: false,
    				processData: false,
    				dataType: 'json',
    				success: function(response) {
    					if(response.status == 1) {
    						$('#signup-box-msg').html(response.message);
    					    location.reload();
    					} else {
    						$('#signup-box-msg').html(response.message);
    					}
    					$('#registerButton').text('Submit');
    				}
    			});
    			return false;
    		});
    	});
    	</script>
    </body>

</html>
