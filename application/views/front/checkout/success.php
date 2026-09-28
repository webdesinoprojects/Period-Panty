<?php $user=$this->user_model->get_user_by_id($order_data[0]->user_id);
$shipping = $this->order_model->get_shipping_data($order_data[0]->id); 
$billing = $this->order_model->get_billing_data($order_data[0]->id);
$items_data = $this->order_model->get_item_data($order_data[0]->id); ?>
    <?php $link=$this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Order Is Completed !</title>
    <?php $this->load->view('front/layout/head'); ?>
    <style>
        .ps-checkout__order {
            color: #fff;
        }

    </style>
</head>

<body>
     <?php $this->load->view('front/layout/header'); ?>
   
    <section class="pb-11 pb-lg-13">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="section-title2 text-center">
                                <center>
                                     <img src="<?php echo base_url('images/order-succes.jpg') ;?>" style="width:20%">
                                </center>
                                
                                <h3 class="title" style="color: green;">Your Order Is Completed !</h3>
                                <h5 style="color: #dc1f26;">Thank you. Your order has been received.</h5>
                            </div>
                             </br>
                            <div class="row" style="border: 1px solid #e8e6e6; padding: 20px 10px;margin-bottom:10px">
                                <div class="col-sm-8"><h6>Order Number : <b><?php Echo $order_data[0]->order_no ?> </b></h6></div>
                                <div class="col-sm-4"><h6>Placed On : <b><?php echo date( 'd-m-Y',strtotime($order_data[0]->create_date)); ?> </b></h6></div>
                                <div class="col-sm-4"><h6>Order Status : <?php Echo $order_data[0]->status ?></h6></div>
                                <div class="col-sm-12">
            	
            					<?php if(count($items_data)>0){ ?>
            					<?php foreach($items_data as $key=> $item): ?>
            					 <?php
            					   $product_data = $this->product_model->get_product_by_id($item->pro_id);  
            					   $product_images = $this->product_model->select_product_images($item->pro_id);?>
            						<?php $product_images = $this->product_model->select_product_images($item->pro_id);
                                    $product_data = $this->product_model->get_product_by_id($item->pro_id); ?>
                                    <?php  $url = $this->product_model->get_product_url($item->pro_id) ; ?>
                                    <?php $custom_option = json_decode($item->custom_options)  ; ?>
                                    
                                    <hr>
                                     <div class="row" >
                                 
                                        <div class="col-sm-3 col-2"> 
                                        
                                        <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" alt="<?php echo $product_images[0]->img_tag; ?>" style="width:100%">
                                      
                                        </div>
                                        <div class="col-sm-9 col-10"> 
                                
                                         <h5><a class="cart_title" href="<?php echo $url; ?>"><?php echo  $product_data[0]->title; ?></a>*<?php echo $item->qty; ?></h5>
                                         <p>
                                             <?php print_r($custom_option->cartdata->size) ; ?> 
                                        </p>
                                        <p>
                                               <strong> <?php echo CURRENCY_SYMBOL." ".$item->sub_total; ?></strong>
                                                
                                        </p>  
                                        <p>
                                                <a href="<?php echo base_url('user/view_order/'. $order_data[0]->order_no); ?>" style="color:blue"> View Details</a>
                                        </p>
                                         </div>
                            
                                        
                                      </div>
            
            					<?php endforeach; ?>	
            					<?php } ?>	
            					
                        </div>
                            </div>
                           </br>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('front/layout/footer'); ?> 
    <?php $this->load->view('front/layout/footer-js'); ?> 
    </body>

</html>
