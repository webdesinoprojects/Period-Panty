<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- SITE TITLE -->
<title></title>

<?php  $this->load->view('front/layout/head') ;  ?>

</head>

<body onload="razorpaySubmit(this);">


<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- STAT SECTION ABOUT --> 
<div class="section">
  <div class="container">

                <?php

                $productinfo = $item_name;
                $txnid = time();
                $surl = $surl;
                $furl = $furl;        
                $key_id = RAZOR_KEY_ID;
                $currency_code = $currency_code;            
                $total = $amount*100; 
                $amount = $amount;
                $merchant_order_id = $item_number;
                $card_holder_name = $name;
                $email = $email;
                $phone = $phone;
                $name =  "";
                $return_url = $return_url;
                ?>
          
                 <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
                  <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                  <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
                  <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
                  <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/>
                  <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
                  <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
                  <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
                  <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
                  <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>
                </form>

               
                   

                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                <script>
                  var razorpay_options = {
                    key: "<?php echo $key_id; ?>",
                    amount: "<?php echo $total; ?>",
                    name: "<?php echo $name; ?>",
                    description: "Order # <?php echo $merchant_order_id; ?>",
                    netbanking: true,
                    currency: "<?php echo $currency_code; ?>",
                    prefill: {
                      name:"<?php echo $card_holder_name; ?>",
                      email: "<?php echo $email; ?>",
                      contact: "<?php echo $phone; ?>"
                    },
                    notes: {
                      soolegal_order_id: "<?php echo $merchant_order_id; ?>",
                    },
                    handler: function (transaction) {
                        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                        document.getElementById('razorpay-form').submit();
                    },
                    "modal": {
                        "ondismiss": function(){
                             window.location.href = '<?php echo base_url() ?>';
                        }
                    }
                  };
                  var razorpay_submit_btn, razorpay_instance;


                  function razorpaySubmit(el){
                    if(typeof Razorpay == 'undefined'){
                      setTimeout(razorpaySubmit, 200);
                      if(!razorpay_submit_btn && el){
                        razorpay_submit_btn = el;
                        el.disabled = true;
                        el.value = 'Please wait...';  
                      }
                    } else {
                      if(!razorpay_instance){
                        razorpay_instance = new Razorpay(razorpay_options);
                        if(razorpay_submit_btn){
                          razorpay_submit_btn.disabled = false;
                          razorpay_submit_btn.value = "Pay Now";
                        }
                      }
                      razorpay_instance.open();
                    }
                  }  


                </script>


        </div>
    </div>
</div>
<!-- END SECTION ABOUT --> 



</div>