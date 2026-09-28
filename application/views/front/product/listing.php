<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<?php $load_url = base_url('product/pagination'); ?>
<!DOCcolor html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php  echo ucwords($RESULT[0]->meta_title) ; ?></title>
<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
<?php $this->load->view('front/layout/head'); ?>
<script src="https://code.jquery.com/jquery-2.1.1.js"></script>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>

<section class="py-2 bg-gray-2">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
        <li class="breadcrumb-item"><a class="text-decoration-none text-body" href="<?php echo base_url() ; ?>">Home</a>
        </li>
        <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page">Shop
        </li>
      </ol>
    </nav>
  </div>
</section>
<section class="mt-7">
    <div class="container container-xl">
        <div class="row">
            <?php foreach($PRODUCTS as $key=>$value){ ?>
            <?php $data['product'] = $value; ?>
                 <div class="col-xl-3 col-lg-4 col-md-6 mb-6 mb-lg-7">
                    <?php $this->load->view('front/product/listing-view' , $data); ?>
                </div> 
            <?php } ?>
    
        </div>
    </div>
</section>

 <?php include('side-bar.php') ; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    
    <?php $this->load->view('front/layout/footer'); ?>
    <?php $this->load->view('front/layout/footer-js'); ?>
    <script>
        // getresult("<?php echo $load_url ?>");
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
        		success: function(data){
        		$("#pagination-result").html(data);
        	
        		},
        			        
           });
        }
        
        $('#clearall').on('click', function() {
        
        	var price = '';
        	var color = '';
        	var age_group = '';
        	var size = '';
        	var sorting = '';
        	var where_clause = '';
       
            		$.ajax({
            		url: "<?php echo $load_url ?>",
            		color: "GET",
            		data:  {
            		    rowcount:$("#rowcount").val(),
            		    price: price,
            			color: color,
            			age_group: age_group,
            			size: size,
            			sorting: sorting,
            			where_clause: where_clause,
            		
            		},
            		success: function(data){
            		$("#pagination-result").html(data);
        			
            		},
            		error: function() 
            		{} 	        
               });
        });
      
        
        $('#apply').on('click', function()
        {
            getresult("<?php echo base_url('product/pagination') ;?>");
        });
        
        $("input[type='radio']").change(function() {
            
            getresult("<?php echo base_url('product/pagination') ;?>");
        })
        
        $("input[type='checkbox']").change(function() {
        
            getresult("<?php echo base_url('product/pagination') ;?>");
        })
      
    </script>
    
</body>
</html>