<?php $product_images = $this->product_model->select_product_images($product->id); ?>
<?php  $url = $this->product_model->get_product_url($product->id) ; ?>
 <div class="row d-flex">
    <div class="col-md-6 col-sm-6 col-6">
        <div class="thumb">
              <a class="primary_img" href="<?php echo $url ?>">
                <?php if($product_images){ ?>
                
                 <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" class="main-image" alt="<?php echo $product->title; ?>">
          
                 <?php }else{  ?>
                 <img src="<?php echo base_url('images/1215BP6.png'); ?>" alt="<?php echo $product->title; ?>" class="main-image">
                 <?php } ?>
            </a>
           
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-6 align-self-center text-center">
        <div class="content">
 <h3>FESTIVAL OFFER COLLECTION</h3>
            <h5><a href="<?php echo $url ?>"><?php echo $product->title; ?></a> </h5>

            <?php if($product->special_price !=='0.00'){ ?>
                <span class="price"><del><small>RS. <?php echo $this->cart->format_number($product->price); ?></small> </del></span>
                <span class="price">RS. <?php echo $this->cart->format_number($product->special_price); ?></span>
            <?php }else{ ?>
                <span class="price">RS. <?php echo $this->cart->format_number($product->price); ?> </span>
            <?php }?>
        
            <div class="btn-wrapper">
                
                    <?php  $cartbutton = check_product_in_cart($product->id); ?>
                     <?php if($product->qty>0){ ?>
                     <a href="javascript:void()" class=" btn btn-collection addToCart <?php echo $cartbutton['class'] ?>"  title="<?php echo $cartbutton['title'] ?>" data="<?php echo $product->id; ?>"><i class="icon-add-to-cat"></i> Add to cart</a>
                    <?php }else{ ?>
                     <a href="#" class="btn btn-collection  " title="Out Of Stock" ><i class="icon-add-to-cat"></i>Out Of Stock</a>
                    <?php } ?> 
                
            </div>
        </div>
    </div>
</div> 