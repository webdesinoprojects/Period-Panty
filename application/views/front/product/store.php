<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php  echo $RESULT[0]->meta_title ; ?></title>
<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
 <?php $this->load->view('front/layout/head'); ?>
</head>
<body> 
<body>
<div class="wrapper ovh">
 <?php $this->load->view('front/layout/header'); ?>
 
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <h3><?php echo $RESULT[0]->title; ?></h3>
                        <ul>
                            <li><a href="<?php echo base_url(''); ?>">home</a></li>
                            <li><?php echo $RESULT[0]->title; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
     <div class="shop_area shop_reverse mt-100 mb-100">
        <div class="container">
            <div cla="row">
                <div class="col-lg-12 col-md-12">
                    
                    <!--shop toolbar end-->
                    <div class=" shop_wrapper">
                        <div class="ps-section__content">
                            <div class="row">
                               <?php if(count($PRODUCTS)>0){ ?>
                                    <?php foreach($PRODUCTS as $product){ ?>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                                          <?php include 'listing-view.php' ?>
                                        </div>
                                    <?php } ?>
                                <?php }else{ ?>
                                         <div class="col-md-12 col-sm-6">Sorry ! No Products Found
                                         </div>
                                <?php } ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <?php $this->load->view('front/layout/footer-js'); ?>
    <script>
        getresult("<?php echo $load_url ?>");
        function get_filter(class_name) {
        		var filter = [];
        		filter = $('.' + class_name).val();
        		return filter;
        }
        function getresult(url) {
            var price = get_filter('price');
        	if (!$("input[name='size']:checked").val()) {
             
                var size = '' ; 
            }
            else {
              	var size = $("input[name='size']:checked").val();
            }
            
            if (!$("input[name='age_group']:checked").val()) {
             
                var age_group = '' ; 
            }
            else {
              	var age_group = $("input[name='age_group']:checked").val();
            }
            
            if (!$("input[name='color[]']:checked").val()) {
             
                var color = '' ; 
            }
            else {
              
              	var array = [];
                var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
                
                for (var i = 0; i < checkboxes.length; i++) {
                  array.push(checkboxes[i].value)
                }
               
                 var color = array ; 
                 
 
            } 
            if (! $(".sorting option:selected").val()) {
             
                var sorting = '' ; 
            }
            else {
              	var sorting = $(".sorting option:selected").val();
            }
     
        	var cat_id = get_filter('cat_id');
        	var where_clause = get_filter('where_clause');
        	$.ajax({
        		url: url,
        		color: "GET",
        		data:  {
        		    rowcount:$("#rowcount").val(),
        		    price: price,
        			color: color,
        			age_group: age_group,
        			size: size,
        			sorting: sorting,
        			cat_id: cat_id,
        			where_clause: where_clause,
        			
        		},
        		beforeSend: function(){$("#overlay").show();},
        		success: function(data){
        		$("#pagination-result").html(data);
        		setInterval(function() {$("#overlay").hide(); },500);
        		},
        		error: function() 
        		{} 	        
           });
        }
        
        $('#clearall').on('click', function() {
        
        	var price = '';
        	var color = '';
        	var age_group = '';
        	var size = '';
        	var sorting = '';
        	var where_clause = '';
        	var cat_id = '';
       
            		$.ajax({
            		url: "<?php echo base_url('home/pagination') ;?>",
            		color: "GET",
            		data:  {
            		    rowcount:$("#rowcount").val(),
            		    price: price,
            			color: color,
            			age_group: age_group,
            			size: size,
            			sorting: sorting,
            			where_clause: where_clause,
            			cat_id: cat_id,
            		
            		},
            		beforeSend: function(){$("#overlay").show();},
            		success: function(data){
            		$("#pagination-result").html(data);
        				clearSelected('price');
        				clearSelected('color');
        				clearSelected('age_group');
        				clearSelected('size');
        				clearSelected('sorting');
        				clearSelected('where_clause');
        				clearSelected('cat_id');
        			
            		setInterval(function() {$("#overlay").hide(); },500);
            		},
            		error: function() 
            		{} 	        
               });
        });
        function clearSelected($a) {
        	$('.' + $a).find($('option')).attr('selected', false)
        }
        
        $('#apply').on('click', function()
        {
            getresult("<?php echo base_url('product/pagination') ;?>");
        });
        
        $("input[type='radio']").change(function() {
            
            getresult("<?php echo base_url('product/pagination') ;?>");
        })
      
    </script>
</body>
</html>

