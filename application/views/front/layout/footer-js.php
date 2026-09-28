    <!-- all plugins here -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/front/') ?>vendors/jquery.min.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/bootstrap/bootstrap.bundle.js"></script>
<!--<script src="<?php echo base_url('assets/front/') ?>vendors/bootstrap-select/js/bootstrap-select.min.js"></script>-->
<script src="<?php echo base_url('assets/front/') ?>vendors/slick/slick.min.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/waypoints/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/counter/countUp.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/hc-sticky/hc-sticky.min.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/jparallax/TweenMax.min.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/mapbox-gl/mapbox-gl.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/isotope/isotope.js"></script>
<script src="<?php echo base_url('assets/front/') ?>vendors/chartjs/chart.min.js"></script>

<script src="<?php echo base_url('assets/front/') ?>/js/theme.js"></script>
    

    <script type="text/javascript">
     $(document).ready(function() 
       { 
        $(".wishlist-add").on('click',function(){
             var a = $(this) ; 
             var product_id = $(this).attr('data-id');
              $.ajax({
                url: "<?php echo base_url('cart/add_to_whislist')?>",
                data:{product_id:product_id},
                type: "POST",
                dataType: 'json',
                success: function(data) {
                     if(data['error']=='1'){
                        alert("Please Login into website for whishlist");
                        
                     window.location.replace('user/login');
                     }else{
                     
                           $(a). html("<i class='fa fa-heart'></i>") ; 
                     }     
                  }
                });
              return false ;  
                  
          });
      });
    </script>
    <script type="text/javascript">
     $(document).ready(function() 
       {
            $(document).on("click", '.single-products-box .wishlist-add', function() { 
       
       
             var a = $(this) ; 
             var product_id = $(this).attr('data-id');
              $.ajax({
                url: "<?php echo base_url('cart/add_to_whislist')?>",
                data:{product_id:product_id},
                type: "POST",
                dataType: 'json',
                success: function(data) {
                     if(data['error']=='1'){
                        alert("Please Login into website for whishlist");
                        window.location.replace('user/login');
                     }else{
                     
                           $(a). html("<i class='fa fa-heart'></i>") ; 
                     }     
                  }
                });
              return false ;  
                  
          });
      });
    </script>
    <script type="text/javascript">
       $(document).ready(function() 
       {
           $(document).on("click", '.single-products-box .add-to-cart', function() { 
     
                var product_id = $(this).attr('data-id');
                $('#product_id').val(product_id);
                  $.ajax({
                    url: "<?php echo base_url('product/get_product_size_variation')?>",
                    data:{product_id:product_id},
                    type: "POST",
                    success: function(data) {
                          $('#size_variation').html(data); 
                           $('#productsQuickView').modal('toggle');
                      }
                    });
                  return false ; 
                
          });
         
      });
    </script>
    <script>
        function selectSize(variation_id,product_id ) {
      
        var product_id = product_id;
        var variation_id = variation_id ; 
        var a = '.product_no_'+product_id;
        var qty = 1;

          $.ajax({
            url: "<?php echo base_url('cart/add_to_cart')?>",
            data:{product_id:product_id,qty:qty,variation_id:variation_id},
            type: "POST",
            success: function(data) {
                  $('.cart-label').html(data);  
                  $(a).removeClass('buybutton').removeClass('add-to-cart').addClass('addedbutton').attr('title','Added').attr('data-tooltip','Added').html('<i class="icon-add-to-cat"></i> Added');
                  $('#productsQuickView').modal('toggle');
              }
            });
          return false ;
    };
    </script>
   
    <script type="text/javascript">
    $(document).ready(function() {
    $('#signin-form').submit(function () {  
    $('#loginButton').text('Processing....') ;  
      $.ajax({
            url: "<?php echo base_url('user/login_process') ?>",
            type: "POST",     
            data: $(this).serialize(),
            dataType: 'json',
           
            success: function(response){ //console.log(response);
                $('#loginButton').text('Login') ;  
                $('.statusMsg').html('');
                if(response.status == 1){
            
                    $('#signin-box-msg').html(response.message);
                      window.location.replace(response.url);
   
                }else{
                     $('#signin-box-msg').html(response.message);
                }
            }
        
          });
      return false;
    });
}); 
 </script>
    <div class="modal fade" id="productsQuickView" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="padding: 30px;">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Please select your product size</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <input type="hidden" name="product_id" value="" id="product_id" >
                    
                    <div class="d-flex">
                        <span class="specifications">SIZE: </span>
                        
                        <ul class="ks-cboxtags size-list align-self-center pl-3" id="size_variation">
                         
                                                                      
                        </ul>
                       
                    </div>
                </div>
         
            </div>
        </div>
    </div>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/64636d96ad80445890ed3c0f/1h0i685kr';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->