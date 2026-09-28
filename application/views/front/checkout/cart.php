<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php  echo $RESULT[0]->meta_title ; ?></title>
<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
<?php $this->load->view('front/layout/head'); ?>

<script>
  fbq('track', 'AddToCart');
</script>


</head>
<body>
<?php $this->load->view('front/layout/header'); ?>
<main id="content">
    <section class="py-2 bg-gray-2">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-site py-0 d-flex
                    justify-content-center">
                    <li class="breadcrumb-item"><a class="text-decoration-none text-body" href="">Home</a>
                    </li>
                    <li class="breadcrumb-item active pl-0 d-flex
                        align-items-center" aria-current="page">Shopping
                        Cart
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    <form method="post" id="cartform"  action="<?php echo base_url('cart/update');?>">
    <section class="pb-11 pb-lg-13">
        <div class="container">
           
            <?php if(count($CARTDATA)>0){ ?>
             <?php echo $this->session->flashdata('msg'); ?>   
             <div class="row pb-8 mt-9 pb-lg-10">
                <div class="col-lg-8 ">
                    <div class="table-responsive-md ">
                        <table class="table border">
                            <thead style="background-color: #F5F5F5">
                                <tr class="fs-15 letter-spacing-01
                                    font-weight-600 text-uppercase
                                    text-secondary">
                                    
                                <th class="product_thumb" class="border-1x pl-7" >Image</th>
                                <th class="product_name" class="border-1x pl-7" >Product</th>
                                <th class="product-price" class="border-1x pl-7" >Price</th>
                                <th class="product_quantity" class="border-1x pl-7" >Quantity</th>
                                <th class="product_total" class="border-1x pl-7" >Total</th>
                                <th class="product_remove" class="border-1x pl-7" >Delete</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                               <?php $this->load->view('front/checkout/items'); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
           
                <div class="col-lg-4 ">
                     <?php $this->load->view('front/checkout/side-cart-value'); ?>
                </div>
            </div>
             <?php } else{ ?> 
           <div class="">
                <div class="cart-content">
                   
                    <div class="empty-content text-center cart-page-total"> 
                    <a href="<?php echo base_url(); ?>"  ><img src="<?php echo base_url('images/no-cart.png') ; ?>" style="width:400px" ?></a>
                    </div>  
                </div>
            </div>
        <?php } ?>
        </div>
    </section>
    </form>
</main>
<?php $this->load->view('front/layout/footer'); ?>
</div>
<?php $this->load->view('front/layout/footer-js'); ?>
       <script>
        $('.input-number').on('change', function(){ 

           var s = $(this);
           var a = parseInt($(this).val()) ;
           var b = parseInt($(this).attr('max')) ;
           var stock = parseInt($(this).attr('stock')) ;
           var c = parseInt($(this).attr('data-value')) ;
           var id = $(this).attr('id');
           var classname = '.'+id;
           if(a > stock){

                alert("Sorry!!,  We have limited stock!!") ;  
                $(this).val(stock);
           }else if (a > b) {
           	
              alert(' You can order maximum '+ b + ' quantity one time') ; 
                $(this).val(c);

           }else if (a==0) {
           	
              alert('Please put the value') ; 
                $(this).val(c);

           }else{

           		$(this).siblings().css('visibility','visible');
           		
           		$(classname).val(a);
           	    $(this).closest('form').submit();
           }
            
                 
        });
    </script>
   <?php $this->load->view('front/checkout/side-cart-js'); ?>
</body>
</html>