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
    <title><?php echo $RESULT[0]->meta_title ; ?></title>
    <meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
    <meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
    <link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
    <?php $this->load->view('front/layout/head'); ?>
  
</head>

<body>
    <?php $this->load->view('front/layout/header'); ?>
    
     <section class="pb-11  pb-lg-13">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post" class="checkout" action="<?php echo base_url('checkout/checkout_process') ; ?>">
                                <div class="checkout-box"  id="checkout-box-1">
                                    <div class="checkout-heading">
                                        <h2>1. Shipping Details</h2>
                                        <span class="edit-checkout-box">Edit</span>
                                    </div>
                                    <div class="checkout-box-inner">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                     <input type="text" class="form-control" value="<?php echo $userdata[0]->fname ?> " Placeholder="Name*" name="sfname" required> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Last Name</label>
                                                    <input type="text" class="form-control" value=" <?php echo $userdata[0]->lname ?>" Placeholder="Name*" name="slname" > 
                                                </div>
                                            </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                     <input type="text" class="form-control" name="scontact_no" minlength="10" maxlength="10" value="<?php echo $userdata[0]->contact_no ?>" required  pattern="^\d{10}$"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" Placeholder="Mobile Number*">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                      <label>Address</label>
                                                    <textarea class="form-control" name="saddress" value="<?php echo $userdata[0]->address ?>" required Placeholder="Address*"><?php echo $userdata[0]->address ?></textarea >
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                      <label>Landmark</label>
                                                   <input type="text" class="form-control" name="slandmark" value="<?php echo $userdata[0]->landmark ?>" Placeholder="Landmark">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Country</label>
                                                    <select class="form-control" name="scountry" required>
                                                        <option>India</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   <label>State</label>
                                                     <select name="sstate" class="form-control" id="sstate" required>
                                                    <option>--State--</option>
                                                    <?php foreach ($state as $key=> $value) { ?>
                                                    <option <?php echo ($userdata[0]->state == $value->name) ?"selected":""; ?>><?php echo $value->name ?></option>
                                                    <?php } ?> 
                                                    </select>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                     <label>City</label>
                                                   <input type="text" class="form-control" name="scity" id="scity" value="<?php echo $userdata[0]->city ?>" required Placeholder="City">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                     <label>Pincode</label>
                                                   <input type="text" class="form-control" minlength="6" maxlength="6" Placeholder="Pincode" id="spincode" name="spincode" value="<?php echo $userdata[0]->pincode ?>"   required>

                                                </div>
                                            </div>
                                          
                                           
                                        </div>
                                        <button type="button" class="btn btn-primary btn-block mt-3 checkout-btn-2">Continue</button>
                                    </div>
                                </div>
                                <div class="checkout-box" id="checkout-box-3">
                                    <div class="checkout-heading">
                                        <h2>2. Billing Details </h2>
                                        <span class="edit-checkout-box">Edit</span>
                                    </div>
    
                                    <div class="checkout-box-inner">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="creditCard">
                                                <div class="">										
                    								<label  class="field-label">
                    									<input type="checkbox" id="same_as_shipping">   Same as Shipping address
                    								</label>
                    								
                    							</div>
                                                <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>First Name</label>
                                                                <input type="text" class="form-control" name="bfname" value="<?php echo $userdata[0]->fname ?> " Placeholder="First Name*" > </div>
                                                        </div> 
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Last Name</label>
                                                                <input type="text" class="form-control" name="blname" value="<?php echo @$userdata[0]->lname ?>" Placeholder="Last Name*" > </div>
                                                        </div>
                                                     
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <input type="text" class="form-control" name="bcontact_no" minlength="10" maxlength="10" Placeholder="Contact Number*"  pattern="^\d{10}$"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo @$userdata[0]->contact_no ?>"> </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Landmark</label>
                                                                <input type="text" class="form-control" name="blandmark" value="<?php echo @$userdata[0]->landmark ?>" Placeholder="Landmark" > </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <input type="text" class="form-control" name="baddress" value="<?php echo @$userdata[0]->address ?> "  Placeholder="Address*"> </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Pincode</label>
                                                                <input type="text" Placeholder="Pincode*" class="form-control" id="bpincode" name="bpincode" minlength="6" maxlength="6"   value="<?php echo @$userdata[0]->pincode ?>" >
                                                                
                                                                </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>City</label>
                                                                <input type="text" class="form-control" name="bcity" id="bcity" value="<?php echo @$userdata[0]->city ?>"  Placeholder="City*"> </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>State</label>
                                                                 <select name="bstate" class="form-control" id="bstate" >
                                                                    <option>--State--</option>
                                                                    <?php foreach ($state as $key=> $value) { ?>
                                                                    <option <?php echo ($userdata[0]->state == $value->name) ?"Selected":""; ?>><?php echo $value->name ?></option>
                                                                    <?php } ?> 
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Country</label>
                                                                <select name="bcountry" class="form-control" required>
                                                                    <option >India</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-block mt-3 checkout-btn-3">Continue</button>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="checkout-box" id="checkout-box-4">
                                    <div class="checkout-heading">
                                        <h2>4.  Purchase </h2>
                                        <span class="edit-checkout-box">Edit</span>
                                    </div>
                                    <div class="checkout-box-inner">
                                       
                                        <div style="display:none">
                                             <div class="form-group margin-top-20">
                                            <label> Do you Have a Coupon or Voucher? <a style="color: #2196f3;" href="<?php echo base_url('coupon') ;?> " target="_blank">Check Coupon </a></label>
                                                </div>
                                                <div class="input-group">
                                            		  <input type="text" class="form-control" id="input-coupon" placeholder="Enter discount code" value="" name="coupon">
                                            		  <span class="input-group-btn">
                                            		  <input type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-coupon" value="Apply" style="    padding: 12px;">
                                            		  </span>
                                            	</div>
                                            	<div id="couponmsg">
                                            	</div>
                                    
                                        </div>
                                       <br>
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                
                                           
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="radio" class="custom-control-input payment_method " id="customCheck3" name="payment_method" value="Pay Online"  required>
                                                <label class="custom-control-label" for="customCheck3">Pay Online <small style="color:green"><?php echo $link[0]->online_discount_title ; ?></small> </label>
                                            </div>    
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="radio" class="custom-control-input payment_method " id="customCheck2" name="payment_method" value="Pay On Delivery" >
                                                <label class="custom-control-label" for="customCheck2">Pay On Delivery <small style="color:green"> <?php echo $link[0]->cod_shipping_title ; ?></small> </label>
                                            </div> 
                                            
                                        </div>
                                   
                                        <br>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck43" name="term"  checked required>
                                                <label class="custom-control-label" for="customCheck43">I have read and agree to the  <a style="color: #2196f3;" href="<?php echo base_url('terms-conditions'); ?>" target="_blank"> Terms & Conditions. </a></label>
                                            </div> 
                                        
                                        </div>
        
                                        <button class="btn  btn-primary btn-block mt-3" type="submit" value="Place Order" name="order_palce">Purchase</button>
                             
                                    </div>
                                    </div>
                                
                             </form>
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
                                    <div class="secure-ssl-box">
                                        <img src="<?php echo base_url() ?>assets/front/images/secure.svg" alt="" />
                                        SECURE SSL CHECKOUT
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php $this->load->view('front/layout/footer'); ?>
    </div>
    <?php $this->load->view('front/layout/footer-js'); ?>
    <?php $this->load->view('front/checkout/side-cart-js'); ?>
    <script>
$(document).ready(function(){
	$('#same_as_shipping').click(function(){
		if($(this).prop('checked')==true)
		{
			$('input[name=bfname]').val($('input[name=sfname]').val());
			$('input[name=blname]').val($('input[name=slname]').val());
			$('input[name=bcontact_no]').val($('input[name=scontact_no]').val());
			$('input[name=baddress]').val($('textarea[name=saddress]').val());
			$('input[name=bcity]').val($('input[name=scity]').val());
			$('input[name=bpincode]').val($('input[name=spincode]').val());
			$('input[name=bcountry]').val($('input[name=scountry]').val());			
			$('input[name=blandmark]').val($('input[name=slandmark]').val());
			 var state =  $("select[name=sstate] option:selected").val() ; 
			$('select[name=bstate] option[value="'+state+'"]').attr("selected","selected");
						
		}else
		{
			$('input[name=bfname]').val('');
			$('input[name=blname]').val('');
			$('input[name=bcontact_no]').val('');
			$('input[name=baddress]').val('');
			$('input[name=bcity]').val('');
			$('input[name=bstate]').val('');
			$('input[name=bpincode]').val('');
			$('input[name=bcountry]').val('');	
			$('input[name=blandmark]').val('');	
		}
	});	
});
</script>

<script>
							    
    $('.checkout-btn-1').click(function () {
        $(this).parents('.checkout-box').find('.checkout-box-inner').hide();
        $('#checkout-box-2 .checkout-box-inner').show();
        $(this).parents('.checkout-box').find('.checkout-heading span').show();
        topFunction() ; 
    });

    $('.checkout-btn-2').click(function () {
        $(this).parents('.checkout-box').find('.checkout-box-inner').hide();
        $('#checkout-box-3 .checkout-box-inner').show();
        $(this).parents('.checkout-box').find('.checkout-heading span').show();
        topFunction() ; 
    });

    $('.checkout-btn-3').click(function () {
        $(this).parents('.checkout-box').find('.checkout-box-inner').hide();
        $('#checkout-box-4 .checkout-box-inner').show();
        $(this).parents('.checkout-box').find('.checkout-heading span').show();
        topFunction() ; 
    });
      $('.edit-checkout-box').click(function () {
        $('.checkout-box').find('.checkout-box-inner').hide();
        $(this).parents('.checkout-box').find('.checkout-box-inner').show();
        topFunction() ; 
    });
    function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>

<script>
$(document).ready(function() {
        $(".payment_method").on('change', function() {
              
                 var payment_method =$(".payment_method:checked").val();
                 $.ajax({
                    url: "<?php echo base_url('checkout/payment_method_off') ?>",
                    type: "POST",
                    data: {payment_method: payment_method },
                    dataType: 'json',
                    success: function(data) {
                        $('#cart-total').html(data['html']);
                    }
                });
                return false;
                
        });
        
});         
</script>
    </body>

</html>
