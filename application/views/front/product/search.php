<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_GET['search']; ?></title>

 <?php $this->load->view('front/layout/head'); ?>
</head>
<body> 
    <?php $this->load->view('front/layout/header'); ?>
<section class="py-2 bg-gray-2">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
        <li class="breadcrumb-item"><a class="text-decoration-none text-body" href="<?php echo base_url() ; ?>">Home</a>
        </li>
        <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page"><?php echo $_GET['search']; ?>
        </li>
      </ol>
    </nav>
  </div>
</section>
<section class="mt-7 mb-7">
    <div class="container container-xl">
        <div class="row">
             <?php if(count($PRODUCTS)>0){ ?>
            <?php foreach($PRODUCTS as $key=>$value){ ?>
            <?php $data['product'] = $value; ?>
                 <div class="col-xl-3 col-lg-4 col-md-6 mb-6 mb-lg-7">
                    <?php $this->load->view('front/product/listing-view' , $data); ?>
                </div> 
                  <?php } ?>
            <?php }else{ ?>
                 <div class="col-md-12 col-sm-6">Sorry ! No Products Found
                 </div>
        <?php } ?> 
    
        </div>
    </div>
</section>

    <?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>
   
<style type="text/css">
    .hidden {
        display: none;
    }
</style>
<script type="text/javascript">
    
    $(document).ready(function() {
      $("select[name='price_filter']").change(function() {

         $('#form_filter').submit();
        
      });
});
</script>
</body>
</html>


