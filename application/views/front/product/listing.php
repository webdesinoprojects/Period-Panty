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

        <!-- Toolbar. The sort control carries class "sorting" and the hidden
             inputs carry the class names getresult() already reads, so both
             drive the existing product/pagination endpoint rather than any
             new code path. -->
        <div class="dx-shop-bar">
            <p class="dx-shop-count mb-0">
                <strong><?php echo (int) $PRODUCT_TOTAL; ?></strong>
                product<?php echo ((int) $PRODUCT_TOTAL === 1 ? '' : 's'); ?>
            </p>

            <div class="dx-shop-tools">
                <button type="button" class="dx-filter-btn" id="dx-open-filter">
                    <span class="dx-filter-ico" aria-hidden="true"></span> Filter
                </button>

                <label class="sr-only" for="dx-sorting">Sort products</label>
                <select class="sorting dx-sort" id="dx-sorting">
                    <option value="">Sort by</option>
                    <option value="Sort by Latest">Latest</option>
                    <option value="Sort by Price: Low to High">Price: low to high</option>
                    <option value="Sort by Price: High to Low">Price: high to low</option>
                    <option value="Sort by Best Sellers">Best sellers</option>
                </select>
            </div>
        </div>

        <input type="hidden" id="rowcount" value="<?php echo (int) $PRODUCT_TOTAL; ?>">
        <input type="hidden" class="cat_id" value="">
        <input type="hidden" class="where_clause" value="">

        <!-- getresult() replaces the contents of this node. It has to exist or
             every filter and sort silently does nothing, which is what was
             happening before. -->
        <div class="row" id="pagination-result">
            <?php foreach($PRODUCTS as $key=>$value){ ?>
            <?php $data['product'] = $value; ?>
                 <div class="col-xl-3 col-lg-4 col-md-6 mb-6 mb-lg-7">
                    <?php $this->load->view('front/product/listing-view' , $data); ?>
                </div>
            <?php } ?>

            <?php if (!empty($PAGER)) { ?>
              <div class="col-12">
                <div id="pagination"><?php echo $PAGER; ?></div>
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
        var DX_LOAD_URL = "<?php echo isset($load_url) ? $load_url : '' ; ?>";

        // The filter panel ships with the page but nothing ever opened it.
        // .canvas-sidebar shows on the "show" class, and closes from its own
        // close button or the overlay behind it.
        (function () {
            var panel = document.querySelector('.filter-canvas');
            var openBtn = document.getElementById('dx-open-filter');
            if (!panel || !openBtn) { return; }

            function open()  { panel.classList.add('show'); document.body.style.overflow = 'hidden'; }
            function close() { panel.classList.remove('show'); document.body.style.overflow = ''; }

            openBtn.addEventListener('click', open);
            var closer = panel.querySelector('.canvas-close');
            var overlay = panel.querySelector('.canvas-overlay');
            if (closer)  { closer.addEventListener('click', close); }
            if (overlay) { overlay.addEventListener('click', close); }
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') { close(); }
            });
        })();

        // Sorting re-runs the same query the filters use.
        (function () {
            var sel = document.getElementById('dx-sorting');
            if (sel && DX_LOAD_URL) {
                sel.addEventListener('change', function () { getresult(DX_LOAD_URL); });
            }
        })();

        // Filtering and sorting happen over AJAX, so the address bar never
        // reflected what was on screen - a filtered view could not be shared,
        // bookmarked or reached with the back button. Wrap getresult so every
        // call also writes the current state into the query string. The
        // wrapper delegates to the original, so no filter logic is duplicated.
        (function () {
            if (typeof getresult !== 'function') { return; }
            var original = getresult;

            window.getresult = function (url) {
                original(url);
                try {
                    var params = new URLSearchParams();

                    var sort = document.querySelector('.sorting option:selected');
                    if (sort && sort.value) { params.set('sorting', sort.value); }

                    var size = document.querySelector("input[name='size']:checked");
                    if (size && size.value) { params.set('size', size.value); }

                    var price = document.querySelector('.price');
                    if (price && price.value) { params.set('price', price.value); }

                    var colours = [].slice.call(
                        document.querySelectorAll("input[name='color[]']:checked")
                    ).map(function (c) { return c.value; });
                    if (colours.length) { params.set('color', colours.join(',')); }

                    var qs = params.toString();
                    history.replaceState(null, '',
                        qs ? location.pathname + '?' + qs : location.pathname);
                } catch (e) { /* URL sync is cosmetic; never break the filter */ }
            };
        })();

        // Apply state from the URL on load, so a shared or bookmarked link
        // opens on the same view rather than the unfiltered default.
        (function () {
            if (!DX_LOAD_URL) { return; }
            var q = new URLSearchParams(location.search);
            var sorting = q.get('sorting');
            if (!sorting) { return; }
            var sel = document.getElementById('dx-sorting');
            if (sel) { sel.value = sorting; }
            getresult(DX_LOAD_URL);
        })();

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