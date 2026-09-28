<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<!DOCcolor html>
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
<style>
#pagination{margin-top: 20px;padding-top: 30px;border-top: #F0F0F0 1px solid;}
#pagination .link{border: #F0F0F0 1px solid;padding: 10px;}
#pagination .link.current{border: #bc1515 3px solid; padding: 10px;}
.dot {padding: 10px 15px;background: transparent;border-right: #bccfd8 1px solid;}
#overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
#overlay div {position:absolute;left:50%;top:50%;margin-top:-32px;margin-left:-32px;}
.page-content {padding: 20px;margin: 0 auto;}
.pagination-setting {padding:10px; margin:5px 0px 10px;border:#bccfd8  1px solid;color:#607d8b;}
</style>
<script src="https://code.jquery.com/jquery-2.1.1.js"></script>

</head>
<body>
<?php $this->load->view('front/layout/header-2'); ?>
      <!-- collection area start  -->
    <div class="collection-area margin-top-20">
        <div class="container">
             <!--<form method="get" id="filter_form">-->
            <div class="row flex-row-reverse">
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="products-filter-options">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-4">
                                <div class="d-lg-flex d-md-flex align-items-center"> <span class="sub-title d-lg-none"><a href="#" data-bs-toggle="modal" data-bs-target="#productsFilterModal"><i class='bx bx-filter-alt'></i> Filter</a></span> <span class="sub-title d-none d-lg-block d-md-block">View:</span>
                                    <div class="view-list-row d-none d-lg-block d-md-block">
                                        <div class="view-column">
                                            <a href="#" class="icon-view-two"> <span></span> <span></span> </a>
                                            <a href="#" class="icon-view-three active"> <span></span> <span></span> <span></span> </a>
                                            <a href="#" class="icon-view-four"> <span></span> <span></span> <span></span> <span></span> </a>
                                            <a href="#" class="view-grid-switch"> <span></span> <span></span> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <p>Showing 1 – 18 of <?php echo count($PRODUCTS) ?></p>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="products-ordering-list">
                                    <select name="sorting" class="form-control">
                                        <option value="">--Select--</option>
                                        <option <?php if(isset($_GET['sorting']) && ( $_GET['sorting'] == 'Sort by Price: Low to High') ) { echo "selected" ; } ?>   value="Sort by Price: Low to High">Sort by Price: Low to High</option>
                                        <option <?php if(isset($_GET['sorting']) && ( $_GET['sorting'] == 'Sort by Price: High to Low' ) ){ echo "selected" ; } ?>   value="Sort by Price: High to Low">Sort by Price: High to Low</option>
                                        <option <?php if(isset($_GET['sorting']) && ( $_GET['sorting'] == 'Sort by Latest' )){ echo "selected" ; } ?>   value="Sort by Latest">Sort by Latest</option>
                                        <option <?php if(isset($_GET['sorting']) && ( $_GET['sorting'] == 'Sort by Best Sellers' )){ echo "selected" ; } ?>   value="Sort by Latest">Sort by Best Sellers</option>
                                        <option <?php if(isset($_GET['sorting']) && ( $_GET['sorting'] == 'Default Sorting')){ echo "selected" ; } ?>   value="Default Sorting">Default Sorting</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                    <div id="products-collections-filter" class="row">
                          <?php if(count($PRODUCTS)>0){ ?>
                            <?php foreach($PRODUCTS as $product){ ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 products-col-item">
                                <?php include 'listing-view.php' ?>
                            </div>
                            <?php } ?>
                            <?php }else{ ?>
                            <div class="col-md-12 col-sm-6">Sorry ! No Products Found
                            </div>
                            <?php } ?>
                                    
                        
                    </div>
                    <div id="overlay"><div><img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif?20170503175831" width="64px" height="64px"/></div></div>
                    <div class="page-content ">
                    	<div id="pagination-result" class="row">
                    	<input color="hidden" name="rowcount" id="rowcount" />
                    	</div>
                    </div>
                    
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 margin-top-20">
                     <?php include('side-bar.php') ; ?>
                </div>
            </div>
            <!--</form>-->
        </div>
    </div>
    <!-- collection area end  -->

    <?php $this->load->view('front/layout/footer'); ?>
    <?php $this->load->view('front/layout/footer-js'); ?>
    <script color="text/javascript">
    $(document).ready(function() {
        $("select[name='sorting']").change(function() {

            $('#filter_form').submit();

        });
    });
    </script>
    <script>
        // getresult("<?php echo base_url('product/pagination') ;?>");
        function get_filter(class_name) {
        		var filter = [];
        		filter = $('.' + class_name).val();
        		return filter;
        }
        function getresult(url) {
            var price = get_filter('price');
        	var color = get_filter('color');
        	var age_group = get_filter('age_group');
        	var size = get_filter('size');
        	var sorting = get_filter('sorting');
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
        
        // $('.apply').on('change', function()
        // {
        //     getresult("<?php echo base_url('product/pagination') ;?>");
        // });
        // $('.color').on('change', function()
        // {
        //     getresult("<?php echo base_url('product/pagination') ;?>");
        // });
        // $('.age_group').on('change', function()
        // {
        //     getresult("<?php echo base_url('product/pagination') ;?>");
        // });
        // $('.size').on('change', function()
        // {
        //     getresult("<?php echo base_url('product/pagination') ;?>");
        // });
        // $('.sorting').on('change', function()
        // {
        //     getresult("<?php echo base_url('product/pagination') ;?>");
        // });
    </script>
</body>
</html>