<!doctype html>

<html>
<head>
  
<?php $this->load->view('front/layout/head'); ?>
</head>

<body>

<!--- Start Header -->

<?php $this->load->view('front/layout/header'); ?>

<!--- End Header -->

<section class="breadcrumb-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <ul class="breadcrumb custom-bread">
          <li><a href="<?php echo base_url(''); ?>">Home</a></li>
          &nbsp;/&nbsp;
          <li>Compare Products</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<div class="searchprod">
  <div class="container">
    <div class="row">
      
    </div>
  </div>
</div>
<section class="prod-body pt-0">
  <div class="container">
  <div class="row">
    <?php if(count($PRODUCTS)>0){ ?>
    <?php foreach($PRODUCTS as $product){ ?>
    <?php $product_images = $this->product_model->select_product_images($product->id); ?>
    <div class="col-md-4">
      <div class="prodbox">
      <a href="<?php echo $product->url_slug.'.html'; ?>">
        <div class="prod-img">
          <?php if(count($product_images)>0){ ?>
          <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" >
          <?php } else{ ?>
          <img src="<?php echo base_url('assets/front/images/product-no-image.jpg'); ?>" >
          <?php } ?>
        </div>
        </a>
        <div class="prod-action">
          <h3><?php echo character_limiter($product->title,19); ?></h3>
          <d iv class="prod-star">
          <?php $product_reviews = $this->product_model->get_reviews_avg($product->id); 

						 $total_reviews = round($product_reviews[0]->average);

						?>
          <ul>
            <?php if($total_reviews!=''){ for($i=1;$i<=$total_reviews;$i++) { ?>
            <li><i class="fa fa-star"></i></li>
            <?php }}else{?>
            <li><i class="fa fa-star-o"></i></li>
            <li><i class="fa fa-star-o"></i></li>
            <li><i class="fa fa-star-o"></i></li>
            <li><i class="fa fa-star-o"></i></li>
            <li><i class="fa fa-star-o"></i></li>
            <?php } ?>
          </ul>
        </div>
        <div class="price-p">
          <p>Rs. <span class="regular-price"><s><?php echo $product->price;?></s></span> <?php echo $product->special_price; ?></p>
        </div>
        <div class="prod-btn">
          <form class="list_add_cart" method="post" id="cartform" action="<?php echo base_url('cart/add_to_cart_pageload');?>">
            <input type="hidden" name="id" value="<?php echo $product->id; ?>" >
            <?php $this->load->view('front/product/custom-options'); ?>
            <div class="add-to-box">
              <div class="shop_meta" style="display:none">
                <div class="">
                  <div class="btn-shop">
                    <div class="form-inline">
                      <div class="form-group"> <strong>
                        <input onclick="return minusQty();" class="minus form-control" type="button" value="-">
                        </strong>
                        <input type="text" class=" qty text form-control" title="Qty" value="1" name="qty" id="qty">
                        <strong>
                        <input onclick="return plusQty();" class="plus form-control" type="button" value="+">
                        </strong> </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php if($product->qty>0){ ?>
              <div class="btn-shop addtocart">
                <button type="submit" title=" Add to Cart" data_id="<?php echo $product->id; ?>" id="product-addtocart-button-list" class="btn btn-default adcart" onclick="return addtocart();"> Add to Cart</button>
              </div>
              <?php }else{ ?>
              <div class="btn-shop addtocart"> <span class="btn btn-danger btn-sm">Out of Stock</span> </div>
              <?php } ?>
            </div>
          </form>
          <a href="<?php echo $product->url_slug.'.html'; ?>" class="btn btn-default buybtn">Buy Now</a> </div>
      </div>
    </div>
    <?php } ?>
    <?php }else{ ?>
    <div class="col-md-12 col-sm-6">Sorry ! No Products Found
      <div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>


<script type="text/javascript">

function filter(FORMID)
{
  document.getElementById(FORMID).submit();
}
</script>

<?php $this->load->view('front/layout/footer.php') ?>
</body>
</html>