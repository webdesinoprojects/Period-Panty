
<?php $product_images = $this->product_model->select_product_images($RESULT[0]->id); ?>
<?php $product_one_image = $this->product_model->select_product_images_by_id($RESULT[0]->id);?>
<?php if(count($product_images)>0){?>
	 
    <div class="row">
        <div class="col-2 p-0">
            <div class="slider-nav">
            	<?php $j = 0; foreach($product_images as $images){  ?>
                <div><img src="<?php echo base_url('uploads/product/'.$images->thumb_image); ?>" alt="<?php echo $images->img_tag; ?>" class="img-fluid lazyload"></div>
              		   <?php $j++; } ?>
            </div>
        </div>
        <div class="col-10">
             <div class="product-slick">
	  	   <?php $j = 0; foreach($product_images as $images){  ?>
        		<div>
        			<center>
        				<img src="<?php echo base_url('uploads/product/'.$images->image); ?>" alt="<?php echo $images->img_tag; ?>" class="img-fluid product-img-height  lazyload image_zoom_cls-<?php echo $j ?>" >
        			</center>
        		</div>
       	   <?php $j++; } ?>
    </div>
        </div>
    </div>

<?php }else{ ?>
 <div class="row">
      <div class="col-10">
<img src="<?php echo base_url('assets/front/images/product-no-image.jpg'); ?>" style="width:100%" >
      </div>
    </div>
<?php } ?>