<?php $link = $this->setting_model->get_all_setting();?>
<?php $user_id = $this->session->userdata('USER_ID'); ?>
<?php 	$userdata  = $this->user_model->get_user_by_id($user_id); ?>
<?php 	$wislist  = $this->user_model->count_user_wishlist($user_id); ?>
<?php $act = $this->uri->segment(2); ?>
<?php $cart_content = $this->cart->contents(); ?>
 <?php $parent = $this->category_model->get_home_category_by_parent('0');?>
<header class="main-header navbar-light header-sticky header-sticky-smart header-02">
    <div class="topbar" style="background-color: #ead1f0">
        <div class="container">
            <p class="mb-0 fs-14 text-secondary text-center letter-spacing-01 text-uppercase">  <marquee width="100%" direction="left">
Buy any 2 products get 10% / Buy any 3 products get 15% / Buy4 products or more get 18% / FREE SHIPPING ON ORDERS OVER BUY 2 PRODUCTS.
</marquee></p>
        </div>
    </div>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CJJYG3SJYY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CJJYG3SJYY');
</script>
    
    
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '787775496297748');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=787775496297748&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

    <div class="sticky-area-wrap" >
        <div class="sticky-area bg-white" style="">
            <div class="container container-xxl">
                <nav class="navbar navbar-expand-xl px-0 d-block">
                    <div class="d-none d-xl-block">
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="mx-auto flex-shrink-0 px-10">
                                <div class="d-flex mt-3 mt-xl-0 align-items-center w-100 justify-content-center">
                                       <a href="<?php echo base_url() ;  ?>" class="navbar-brand mx-auto d-inline-block py-0">
                                             <?php if($link[0]->logo ){ ?>
                                              <img src="<?php echo base_url('uploads/').$link[0]->logo ?>" class="logo1edit" alt=" <?php echo $link[0]->title ;  ?>"  style="">
                                            <?php } else{  ?>
                                              <?php echo $link[0]->title ;  ?>
                                            <?php } ?>
                                        </a>
                        
                                </div>
                            </div>
                            <div class="w-50 d-flex align-items-center justify-content-end">
                                <ul class="navbar-nav hover-menu main-menu px-0 mx-xl-n5">
                                    <li aria-haspopup="true" aria-expanded="false"
                                        class="nav-item py-2 py-xl-7 sticky-py-xl-6 px-0 px-xl-5">
                                        <a class="p-0" href="<?php echo base_url('') ?>">
                                            Home
                                        </a>
                                    </li>
                                    <li aria-haspopup="true" aria-expanded="false"
                                        class="nav-item  py-2 py-xl-7 sticky-py-xl-6 px-0 px-xl-5">
                                        <a class="p-0" href="<?php echo base_url('about-us') ?>">
                                            About Us
                                        </a>
                                    </li>
                                    <li aria-haspopup="true" aria-expanded="false"
                                        class="nav-item dropdown-item-pages dropdown py-2 py-xl-7 sticky-py-xl-6 px-0 px-xl-5">
                                        <a class="dropdown-toggle p-0" href="#" data-toggle="dropdown">
                                            Our Products
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu pt-3 pb-0 pb-xl-3 x-animated x-fadeInUp">
                                             <?php foreach($parent as $parents){ ?>
                                               <?php $childs = $this->category_model->get_home_category_by_parent($parents->id);?>
                                                <li class="dropdown-item dropdown dropright">
                                                <a href="<?php echo base_url() ?><?php echo $parents->url_slug;?>.html"  class=" <?php if(count($childs) >0 ){ echo "dropdown-link dropdown-toggle" ; } ?> "  ><?php echo $parents->title; ?></a>
                                                   
                                                     <?php if(count($childs) >0 ){ ?>
                                                     <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-xl-3 x-animated x-fadeInLeft">
                                                        <?php foreach($childs as $child){ ?>
                                                       
                                                        <li class="dropdown-item" ><a class="dropdown-link" href="<?php echo base_url() ?><?php echo $child->url_slug;?>.html"><?php echo $child->title; ?></a></li>
                                                         <?php }?>
                                                         
                                                    </ul>
                                                    <?php }?>
                                                </li>
                                             <?php }?>
                                        </ul>
                                    </li>
                                   
                                    <li aria-haspopup="true" aria-expanded="false"
                                        class="nav-item  py-2 py-xl-7 sticky-py-xl-6 px-0 px-xl-5">
                                        <a class="p-0" href="<?php echo base_url('contact-us') ?>">
                                            Contact Us
                                        </a>
                                    </li>
                                     <li aria-haspopup="true" aria-expanded="false"
                                        class="nav-item  py-2 py-xl-7 sticky-py-xl-6 px-0 px-xl-5">
                                        <a class="p-0" href="#">
                                        Bulk Order
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="w-50 d-flex align-items-center justify-content-center">
                                <div class="d-flex align-items-center justify-content-end">
                                    <a href="#search-popup" data-gtf-mfp="true"
                                        data-mfp-options="{&quot;type&quot;:&quot;inline&quot;,&quot;focus&quot;: &quot;#keyword&quot;,&quot;mainClass&quot;: &quot;mfp-search-form mfp-move-from-top mfp-align-top&quot;}"
                                        class="nav-search d-flex align-items-center pr-3">
                                        <svg class="icon icon-magnifying-glass-light fs-28">
                                            <use xlink:href="#icon-magnifying-glass-light"></use>
                                        </svg>
                                    </a>
                                    <ul class="navbar-nav flex-row justify-content-xl-end d-flex flex-wrap text-body py-0 navbar-right">
                                        <?php if(empty($user_id)){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link pr-3 py-0" href="<?php echo base_url('user/login'); ?>" >
                                                <svg class="icon icon-user-light">
                                                    <use xlink:href="#icon-user-light"></use>
                                                </svg>
                                            </a>
                                        </li>
                                        <?php }else{ ?>
                                        <li class="nav-item">
                                            <a class="nav-link pr-3 py-0" href="<?php echo base_url('user/profile'); ?>" >
                                                <svg class="icon icon-user-light">
                                                    <use xlink:href="#icon-user-light"></use>
                                                </svg>
                                            </a>
                                        </li>
                                       <?php } ?>
                                        <li class="nav-item">
                                            <a class="nav-link position-relative px-4 menu-cart py-0 d-inline-flex align-items-center mr-n2"
                                                href="<?php echo  base_url('cart') ;?>" data-canvas="true"
                                                data-canvas-options="{&quot;container&quot;:&quot;.cart-canvas&quot;}">
                                              
                                                <svg class="icon icon-shopping-bag-open-light">
                                                    <use xlink:href="#icon-shopping-bag-open-light"></use>
                                                </svg>
                                            </a>
                                            
                                              <span class="position-absolute number cart-label"><?php echo (count($cart_content) > 0 ) ? count($cart_content) :"0" ; ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center d-xl-none">
                        <button class="navbar-toggler border-0 px-0 canvas-toggle" type="button" data-canvas="true"
                            data-canvas-options="{&quot;width&quot;:&quot;250px&quot;,&quot;container&quot;:&quot;.sidenav&quot;}">
                            <span class="fs-24 toggle-icon"></span>
                        </button>
                        <div class="mx-auto">
                               <a href="<?php echo base_url() ;  ?>"  class="navbar-brand d-inline-block mr-0"  >
                                     <?php if($link[0]->logo ){ ?>
                                      <img src="<?php echo base_url('uploads/').$link[0]->logo ?>" class="respinsive_logo" alt=" <?php echo $link[0]->title ;  ?>" style="width:70px">
                                    <?php } else{  ?>
                                      <?php echo $link[0]->title ;  ?>
                                    <?php } ?>
                                </a>
                        </div>
                        <a href="#search-popup" data-gtf-mfp="true"
                            data-mfp-options="{&quot;type&quot;:&quot;inline&quot;,&quot;focus&quot;: &quot;#keyword&quot;,&quot;mainClass&quot;: &quot;mfp-search-form mfp-move-from-top mfp-align-top&quot;}"
                            class="nav-search d-flex align-items-center">
                            <svg class="icon icon-magnifying-glass-light fs-28">
                                <use xlink:href="#icon-magnifying-glass-light"></use>
                            </svg>
                            <span class="d-none d-xl-inline-block ml-2 font-weight-500">Search</span></a>
                    </div>
                </nav>
            </div>
        </div>
    </div>


</header>
        
        
      