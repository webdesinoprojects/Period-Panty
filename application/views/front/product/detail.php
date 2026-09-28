<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<?php  $cartbutton = check_product_in_cart($RESULT[0]->id); ?>
<?php 	$variation =  $this->product_model->select_product_variation($RESULT[0]->id); ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php  echo $RESULT[0]->meta_title ; ?></title>
<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keywords; ?>">
<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
<?php $this->load->view('front/layout/head'); ?>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<style>
       .wrapper{
    box-sizing: border-box;
    display: grid;
    -webkit-column-gap: 0.5rem;
    column-gap: 1rem;
    row-gap: 0.6rem;
    grid-template-columns: repeat(8, minmax(0, 1fr));
}
@media screen and (max-width: 1200px) {
  .wrapper{

    grid-template-columns: repeat(5, minmax(0, 1fr));
    }
}

@media screen and (max-width: 900px) {
  .wrapper{

    grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}
.wrapper .option{
   background: #fff;
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    margin-right: 0px;
    border-radius: 5px;
    cursor: pointer;
    padding: 2px 5px;
    border: 2px solid lightgrey;
    transition: all 0.3s ease;

}
.wrapper .option .dot{
 height: 15px;
    width: 15px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
  display:none;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  top: 5px;
  left: 5px;
  width: 5px;
  height: 5px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
    border-color: #d8dee4;
    background: #eaeaea;
}
#option-3:checked:checked ~ .option-3{
   border-color: #d8dee4;
    background: #eaeaea;
}
#option-4:checked:checked ~ .option-4{
    border-color: #d8dee4;
    background: #eaeaea;
}
#option-5:checked:checked ~ .option-5{
   border-color: #d8dee4;
    background: #eaeaea;
}
#option-6:checked:checked ~ .option-6{
   border-color: #d8dee4;
    background: #eaeaea;
}
#option-7:checked:checked ~ .option-7{
    border-color: #d8dee4;
    background: #eaeaea;
}
#option-8:checked:checked ~ .option-8{
    border-color: #d8dee4;
    background: #eaeaea;
}
#option-9:checked:checked ~ .option-9{
   border-color: #d8dee4;
    background: #eaeaea;
}
#option-10:checked:checked ~ .option-10{
   border-color: #d8dee4;
    background: #eaeaea;
}
#option-11 checked:checked ~ .option-11{
   border-color: #d8dee4;
    background: #eaeaea;
}
#option-12:checked:checked ~ .option-12{
   border-color: #d8dee4;
    background: #eaeaea;
}
#option-13:checked:checked ~ .option-13{
   border-color: #d8dee4;
    background: #eaeaea;
}

#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #000;
}
#option-3:checked:checked ~ .option-3 span{
  color: #000;
}
#option-4:checked:checked ~ .option-4 span{
  color: #000;
}
#option-5:checked:checked ~ .option-5 span{
  color: #000;
}
#option-6:checked:checked ~ .option-6 span{
  color: #000;
}
#option-7:checked:checked ~ .option-7 span{
  color: #000;
}
#option-8:checked:checked ~ .option-8 span{
  color: #000;
}
#option-9:checked:checked ~ .option-9 span{
  color: #000;
}
#option-10:checked:checked ~ .option-10 span{
  color: #000;
}
#option-11:checked:checked ~ .option-11 span{
  color: #000;
}
#option-12:checked:checked ~ .option-12 span{
  color: #000;
}
#option-13:checked:checked ~ .option-13 span{
  color: #000;
}

.wrapper .option span{
  font-size: 12px;
  color: #808080;
}

</style>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>
 <section class="py-2 bg-gray-2">
  <div class="container container-xl">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
        <li class="breadcrumb-item">
          <a class="text-decoration-none text-body" href="<?php echo base_url(''); ?>">Home</a>
        </li>
         <?php
        if($RESULT[0]->cat_id){ 
                $parent = $this->category_model->get_category_by_id($RESULT[0]->cat_id) ; ?>
                <?php if($parent[0]->parent_id){ 
                  $mainparent = $this->category_model->get_category_by_id($parent[0]->parent_id) ; ?>
                <li class="breadcrumb-item pl-0 d-flex align-items-center">
                    <a  class="text-decoration-none text-body" href="<?php echo base_url('') ?><?php echo $mainparent[0]->url_slug;?>.html"><?php echo$mainparent[0]->title ?></a>
                </li>
                <?php } ?>
                 <li class="breadcrumb-item pl-0 d-flex align-items-center">
                    <a  class="text-decoration-none text-body" href="<?php echo base_url() ?><?php echo $parent[0]->url_slug;?>.html"><?php echo$parent[0]->title ?></a>
                </li>
        <?php } ?>
      
        <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page">
         <?php echo $RESULT[0]->title; ?>
        </li>
      </ol>
    </nav>
  </div>
</section>

<section class="pt-5 pb-11 pb-lg-14 product-details-layout-5">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-6  col-xl mb-8 mb-md-0 primary-gallery summary-sticky" id="summary-sticky">
        <div class="primary-summary-inner">
          <div class="galleries-product galleries-product-01 position-relative d-flex ">
            <div class="position-absolute pos-fixed-top-right z-index-2 w-100">
              <div class="p-3">
                <a href="javascript:void()" data-id="<?php echo $RESULT[0]->id; ?>"  data-toggle="tooltip" data-placement="left" title="Add to wishlist" class="wishlist-add add-to-wishlist d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle ml-auto">
                  <svg class="icon icon-star-light fs-24">
                    <use xlink:href="#icon-star-light"></use>
                  </svg>
                </a>
              </div>
            </div>

            <?php $product_images = $this->product_model->select_product_images($RESULT[0]->id); ?>
            <?php $product_one_image = $this->product_model->select_product_images_by_id($RESULT[0]->id);?>
            <?php if(count($product_images)>0){?>  
            
            <div class="slick-slider slider-for mx-0 pl-xl-5" data-slick-options='{"slidesToShow": 1,"vertical":true, "autoplay":false,"dots":false,"arrows":false,"asNavFor": ".slider-nav","responsive":[{"breakpoint": 1200,"settings": {"vertical": false}}]}'>
                <?php foreach($product_images as $key=> $images){  ?>
                <div class="box px-0">
                    <div class="card p-0 rounded-0 border-0">
                      <a href="<?php echo base_url('uploads/product/'.$images->image); ?>" class="card-img" data-gtf-mfp="true" data-gallery-id="<?php echo $images->id; ?>">
                        <img src="<?php echo base_url('uploads/product/'.$images->image); ?>" alt="<?php echo $images->img_tag; ?>" class="w-100">
                      </a>
                    </div>
                </div>
                <?php }   ?>
            </div>
            <div class="slick-slider slider-nav mx-n1 mx-xl-0" data-slick-options='{"slidesToShow": 6,"vertical":true, "autoplay":false,"dots":false,"arrows":false,"asNavFor": ".slider-for","focusOnSelect": true,"responsive":[{"breakpoint": 1200,"settings": {"vertical": false}}]}'>
                  <?php foreach($product_images as $images){  ?>
                 <div class="box px-1 px-xl-0 py-2 pt-xl-0">
                    <img src="<?php echo base_url('uploads/product/'.$images->image); ?>" class="w-100" alt="<?php echo $images->img_tag; ?>">
                  </div>
                <?php }       ?>          
            </div>
           
            <?php } else{ ?>
           <img src="<?php echo base_url('images/1215BP6.png'); ?>" alt="<?php echo $RESULT[0]->title; ?>">
           <?php } ?>
             
          </div>
        </div>
      </div>
       <div class="col-md-6 col-lg-6  col-xl pl-xl-7">
            <h2 class="fs-24 mb-2"><?php echo $RESULT[0]->title; ?></h2>
            <p class="d-flex align-items-center text-secondary font-weight-600 fs-14 mb-2">
                <?php if($RESULT[0]->special_price !=='0.00'){ ?>
                    <span class="text-line-through"><?php echo CURRENCY_SYMBOL." ".round($RESULT[0]->price); ?></span>
                   <span class="fs-18 text-secondary font-weight-bold ml-3"> <?php echo CURRENCY_SYMBOL." ".round($RESULT[0]->special_price); ?></span>
                   
                     <?php if($RESULT[0]->discount){?>
                     <span class="badge badge-primary fs-16 ml-4 font-weight-600 px-3"><?php echo $RESULT[0]->discount; ?>% Off</span>
                   <?php } ?>
                     <?php }else{ ?>
                    <span class="fs-18 text-secondary font-weight-bold ml-3"> <?php echo CURRENCY_SYMBOL." ".round($RESULT[0]->price); ?></span>
                    
                <?php }?> 
               
            </p>
            <ul class="list-unstyled pt-1 mb-lg-3 mb-2">
              <li class="row mb-2">
                <span class="d-block col-4 col-lg-2 text-secondary font-weight-600 fs-14">Categories:</span>
                <span class="d-block col-8 col-lg-10">
                   <a href="<?php echo base_url('') ?><?php echo @$CATEGORY[0]->url_slug;?>.html"><?php echo trim($CATEGORY[0]->title) ?></a>
                </span>
              </li>
            </ul>
            <div class="d-flex align-items-center flex-wrap mb-3 lh-12">
              <p class="mb-0 font-weight-600 text-secondary">Absorbancy - </p>
              <ul class="list-inline d-flex mb-0 px-3 rating-result">
                <li class="list-inline-item mr-0">
                  <?php
                    for ($x = 1; $x <= $RESULT[0]->absorbency_rate; $x++) { ?>
                          <span class="fs-12 lh-2">
                            <i class="text-drops fas fa-tint"></i>
                          </span>
                      
                  <?php   } ?>
                  <?php $diff = 5-$RESULT[0]->absorbency_rate ; ?>
                 <?php
                    for ($x = 1; $x <= $diff; $x++) { ?>
                          <span class="fs-12 lh-2">
                            <i class="text-drops far fa-tint"></i>
                          </span>
                      
                  <?php   } ?>
                </li>
              </ul>
            </div>
            
            <form action="<?php echo base_url('cart/add_to_cart_pageload') ; ?>" method="post" id="submit_form">
              <div class="form-group shop-swatch mb-5 d-flex align-items-center">
                <span class="font-weight-600 text-secondary mr-4">Size: </span>
                
                
                <div class="wrapper text-uppercase justify-content-start ">
                    <?php   foreach($variation as $key => $value) {  ?>
                          <?php if($value->qty > 0){  ?>
                           <input type="radio" class="variation_id" name="variation_id" id="option-<?php echo $key+1 ; ?>" value="<?php echo $value->id ; ?>"  >
                         <?php } ?> 
                       
                    <?php } ?> 
                    <?php   foreach($variation as $key => $value) {  ?>
                        <?php if($value->qty > 0){  ?> 
                        <label for="option-<?php echo $key+1 ; ?>" class="option option-<?php echo $key+1 ; ?>">
                      
                          <span><?php echo $value->size ; ?></span>
                        </label>
                        <?php } ?>
                    <?php } ?>
                </div>
             
        
              </div>
               <input type="hidden" name="id" value="<?php echo $RESULT[0]->id;?>">
              <?php if($RESULT[0]->qty>0){ ?>
              <div class="row align-items-end no-gutters mx-n2">
                <div class="col-sm-12 col-lg-4 col-md-12  form-group px-2 mb-5">
                  <label class="text-secondary font-weight-600 mb-3" for="number">Quantity: </label>
                  <div class="input-group position-relative w-100">
                    <a href="#" class="down position-absolute pos-fixed-left-center pl-4 z-index-2" id="minus-btn"><i class="far fa-minus"></i></a>
                    <input type="number" id="qty_input" name="qty"  class="form-control w-100 px-6 text-center input-quality text-secondary h-60 fs-18 font-weight-bold border-0" value="<?php echo trim($RESULT[0]->min_order) ?>" min="<?php echo trim($RESULT[0]->min_order) ?>" max="<?php echo trim($RESULT[0]->qty) ?>"  required>
                    <a href="#" id="plus-btn" class="up position-absolute pos-fixed-right-center pr-4 z-index-2"><i class="far fa-plus"></i>
                    </a>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6  col-sm-6 mb-5 w-100 px-2"> 
                    
                      <a  data="<?php echo $RESULT[0]->id; ?>" id="buy_now"  class="buybutton btn btn-sm fs-14 btn-secondary btn-block h-60 bg-hover-primary border-0"  title="<?php echo $cartbutton['title'] ?>" ><i class="icon-add-to-cat"></i> <?php echo $cartbutton['title'] ?></a>
                
                </div>
                <div class="col-lg-4 col-md-6  col-sm-6  mb-5 w-100 px-2">
                    
                      <button type="button" id="submit_button" class="btn btn-sm fs-14 btn-secondary btn-block h-60 bg-hover-primary border-0"> Buy Now</button>
                
                </div>
              <?php }else{ ?>
             <div class="btn-wrapper">
                 <button type="button"  class=" addedbutton btn btn-sm fs-14 btn-secondary btn-block h-60 bg-hover-primary border-0" ><span class="flaticon-shopping-cart mr5 fz18 vam"></span> Out of Stock</button>
            </div>
            <?php }  ?>
                            
            </form>
            <h6><a  href="javscript:void(0)" data-toggle="modal" data-target="#exampleModal">
              Check Product Size
            </a></h6>

            <div id="accordion-style" class="accordion">
              <div class="card border-0 mb-4">
               
                <div id="product-detail" class="collapse show" aria-labelledby="headingProductDetail" data-parent="#accordion-style">
                  <div class="card-body pt-5 pb-1 px-0">
                      <h4>Product Description</h4>
                     <?php echo $RESULT[0]->short_description   ; ?>
                     <?php echo $RESULT[0]->description   ; ?>
                </div>
                </div>
              </div>
    
            </div>
          </div>

    </div>
  </div>
</section>
 
<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>

<script type="text/javascript">
    $('#qty_input , #plus-btn, #minus-btn').on('click change', function() {

        let qty = parseInt( $('#qty_input').val() );
        let min_order =  parseInt( <?php echo trim($RESULT[0]->min_order) ?> ) ; 
        let max_order =  parseInt( <?php echo trim($RESULT[0]->max_order) ?> ) ;
        var variation_id = '';
            <?php if(count($variation) > 0 ){  ?>
             variation_id = $('.variation_id').val();
            if(variation_id == '') {
               $('#qty_input').val(1) ;
               alert('Select Size.') ; 
               return false; 
               
            }
        <?php } ?>
        $.ajax({
        url: "<?php echo base_url('product/get_product_vartion_details')?>",
        data:{variation_id:variation_id},
        type: "POST",
        success: function(data) {
                if(qty < min_order){
                    alert('you should have order atlest minimum  <?php echo trim($RESULT[0]->min_order) ?>  quantity of this  product') ; 
                    $('#qty_input').val( min_order) ; 
                    
                }else if(qty > data){
        
                    alert('We have only '+data+' quantity of this  size') ; 
                    $('#qty_input').val( data) ; 
                }
                else if(qty > max_order){
        
                    alert('you should have order maxmimum <?php echo trim($RESULT[0]->max_order) ?>  quantity of this  product') ; 
                    $('#qty_input').val( min_order) ; 
                }else{
                    
                }
        
        
          }
        });
 
    });
    $('.variation_id ').on('click change', function() {

    
        $('#buy_now').removeClass('addedbutton').addClass('buybutton').attr('title','Add to Cart').html('Add to Cart');
    });

</script>

<script type="text/javascript">
   $(document).ready(function() 
   {
      $(".buybutton").on('click',function(){
            var a = $(this) ; 
            var product_id = $(this).attr('data');
            var qty = $('#qty_input').val();
            var variation_id = $('.variation_id:checked').val();
            if(variation_id){
                 $.ajax({
                url: "<?php echo base_url('cart/add_to_cart')?>",
                data:{product_id:product_id,qty:qty,variation_id:variation_id},
                type: "POST",
                success: function(data) {
                      $('.cart-label').html(data);    
                      $(a).removeClass('buybutton').addClass('addedbutton').attr('title','Added').html('Added');
                  }
                });
             
            }else{
                   alert('Select Size.') ; 
               
            }
            return false;
      });
  })
</script>
<script type="text/javascript">
   $(document).ready(function() 
   {
      $("#submit_button").on('click',function(){
            var variation_id = $('.variation_id:checked').val();
            if(variation_id){
               
               $('#submit_form').submit()
             
            }else{
                   alert('Select Size.') ; 
               
            }
            
      });
  })
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Size Chart</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="<?php echo base_url('images/size-chart.jpg');?>" style="width:100%">
      </div>
  
    </div>
  </div>
</div>
</body>
</html>