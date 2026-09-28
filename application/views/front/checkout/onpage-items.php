<?php $CARTDATA= $this->cart->contents(); ?>
<?php foreach($CARTDATA as $item){ ?>
<?php 
$variation_data = $this->product_model->select_product_variation_by_id($item['id']) ;
$product_images = $this->product_model->select_product_images($variation_data[0]->product_id);
$product_data = $this->product_model->get_product_by_id($variation_data[0]->product_id); ?>
<?php $stock = $variation_data[0]->qty ; ?>    
<?php  $url = $this->product_model->get_product_url($variation_data[0]->product_id) ; ?>
    <div class="order-summary-row">
        <div class="order-summary-row-inner-box">
            <div class="order-row-img-wrapper">
                <img class="mr-15" src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" alt="" style="width:50px">
            </div>
            <div class="summary-row-desc"><a class="cart_title" href="<?php echo $url; ?>"><?php echo $item['name']; ?>* <?php echo $item['qty'] ; ?> </a>
                <div class="cart-row-variants">
                     <?php if($item['custom_options']['cartdata']['size']){ ?>
                      <p class="cart-row-variant css-vtx1a6"> Size: <?php print_r($item['custom_options']['cartdata']['size']) ; ?></p>
                      <?php } ?> 
                    
                </div>
            </div>
        </div>
        <div class="qty-info">
            <p><?php echo CURRENCY_SYMBOL." ".number_format($item['subtotal']); ?></p>
            <!--<div class="qty-inner-box">-->
            <!--    <span class="qty-text">Qty</span>-->
            <!--    <span> <?php echo $item['qty'] ; ?></span>-->
            <!--</div>-->
            <a href="<?php echo base_url('cart/remove_cart_item/'.$item['rowid']); ?>" ><span class="remove-item">Remove</span></a>
        </div>
    </div>
   <?php } ?>

