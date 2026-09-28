<?php error_reporting() ; ?>
<?php $user_id=$this->session->userdata('USER_ID'); ?>
<?php $coupon=$this->session->userdata('coupon_data'); ?>
<?php $userdata=$this->user_model->get_user_by_id($user_id); ?>
<?php $link=$this->setting_model->get_all_setting();?>
<?php
if(isset($_SESSION[ 'user_session'])){
$user_session=$_SESSION[ 'user_session'];
}else{
    $user_session = null ;
}
?>
<div class="card border-0" style="box-shadow: 0 0 10px 0 rgba(0,0,0,0.1)">
     <div class="card-body px-6 pt-5">
        <h6 class="title">Summary</h6>
      
        
        <div id="cart-total">
               
        </div>
        <?php  if(!empty($user_session)){ ?>
       <?php if( isset($_SESSION['guest']) && ($_SESSION['guest'] == 'No')){ ?>
          <div style="display:none">
            <div class="form-group margin-top-20" >
                <label> Do you Have a Coupon or Voucher? <a style="color: #2196f3;" href="<?php echo base_url('coupon') ;?> " target="_blank">Check Coupon </a></label>
            </div>
            <div class="input-group">
        		  <input type="text" class="form-control" id="input-coupon" placeholder="Enter discount code" value="" name="coupon">
        		  <span class="input-group-btn">
        		  <input type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-coupon" value="Apply">
        		  </span>
        	</div>
        	<div id="couponmsg">
        	</div>
        </div>
    	<?php } ?>
    	<?php } ?>
    
            <?php $segmment =  $this->uri->segment(1);?>
            <?php if($segmment == 'cart'){ ?>
            <div class="btn-wrapper">
            <a href="<?php echo base_url('checkout/onepage'); ?>" class="btn btn-secondary btn-block bg-hover-primary border-hover-primary">Proceed To Checkout</a>
            </div>
            <?php }else{ ?>
            <div class="d-flex justify-content-between total">
                <div class="form-group">
                <label>Payment Method</label>
               
                <div class="custom-control custom-checkbox mb-3">
                    <input type="radio" class="custom-control-input" id="customCheck" name="payment_method" value="Pay Online" checked>
                    <label class="custom-control-label" for="customCheck">Pay Online</label>
                </div>
                 <div class="custom-control custom-checkbox mb-3 " style="display:none">
                    <input type="radio" class="custom-control-input" id="customCheck2" name="payment_method" value="Pay On Delivery" >
                    <label class="custom-control-label" for="customCheck2">Pay On Delivery </label>
                </div> 
            </div>
            </div>
            
            <br>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck3" name="term"  required checked>
                    <label class="custom-control-label" for="customCheck3">I have read and agree to the  <a style="color: #2196f3;" href="<?php echo base_url('return-policy'); ?>" target="_blank"> Shipping & Return Policy. </a></label>
                </div> 
            
            </div>
            
                <button class="btn btn-secondary btn-block bg-hover-primary border-hover-primary" type="submit" value="Place Order" name="order_palce">Place Order</button>
           
            <?php } ?>
        </div>
    </div>
</div>