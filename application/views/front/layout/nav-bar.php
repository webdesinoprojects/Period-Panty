<?php $link = $this->setting_model->get_all_setting();?>
<?php $user_id = $this->session->userdata('USER_ID'); ?>
<?php 	$userdata  = $this->user_model->get_user_by_id($user_id); ?>
<?php 	$wislist  = $this->user_model->count_user_wishlist($user_id); ?>
<?php $cart_content = $this->cart->contents(); ?>
<div class="container-fluid nav-container">
        <div class="row">
            <div class="col-lg-2 col-4 order-1 align-self-center">
                <div class="logo">
                        <a href="<?php echo base_url() ;  ?>" class="ps-logo">
                             <?php if($link[0]->logo ){ ?>
                              <img src="<?php echo base_url('uploads/').$link[0]->logo ?>" class="logo2 img-fluid" alt=" <?php echo $link[0]->title ;  ?>" >
                            <?php } else{  ?>
                              <?php echo $link[0]->title ;  ?>
                            <?php } ?>
                        </a>
                   
                </div>
            </div>
            <div class="col-lg-8 order-3 order-lg-2">
                <div class="collapse navbar-collapse" id="shop-menu">
                    <ul class="navbar-nav menu-open">
                        <li><a href="<?php echo base_url('') ?>">HOME</a></li>
                        <li><a href="<?php echo base_url('about-us') ?>">ABOUT US</a></li>
                        <li class="menu-item-has-children"><a href="#">SHOP<i class="fa fa-angle-down"></i></a>
                            <ul class="sub-menu megamenu">
                                <?php $parent = $this->category_model->get_home_category_by_parent('0');?>
                                <?php foreach($parent as $parents){ ?>
                                    <li class="sub-menu-item-has-children" ><a href="<?php echo base_url() ?><?php echo $parents->url_slug;?>.html"><?php echo $parents->title; ?></a>
                                    <?php $childs = $this->category_model->get_home_category_by_parent($parents->id);?>
                                     <ul class="sub-menu-children" style="background: #fff;">
                                        <?php foreach($childs as $child){ ?>
                                        <li><a href="<?php echo base_url() ?><?php echo $child->url_slug;?>.html"><?php echo $child->title; ?></a></li>
                                         <?php }?>
                                    </ul>
                                    
                                    </li>
                                   
                                 <?php }?>
                            </ul>
                        </li>
                        <li class="menu-item-has-children"><a href="#">TRENDSETTERS <i class="fa fa-angle-down"></i></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('shop') ?>?where_clause=New Arrivals">New Arrivals</a></li>
                                <li><a href="<?php echo base_url('shop') ?>?where_clause=Best Seller">Best Seller</a></li>
                                <li><a href="<?php echo base_url('shop') ?>?where_clause=Sale">Sale</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children" ><a href="<?php echo base_url('') ?>"> SHOP BY AGE <i class="fa fa-angle-down"></i></a>
                            <?php $age_group = $this->product_model->get_all_active_age_group() ;  ?>
                            <ul class="sub-menu">
                                  <?php foreach($age_group as $value){ ?>
                                <li><a href="<?php echo base_url('shop') ?>?age_group=<?php echo $value->title ; ?>"><?php echo $value->title ; ?></a></li>
                                 <?php } ?>
                           
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url('blog') ?>">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-1 col-8 justify-content-end d-flex order-2 order-lg-3">
     
                <div class="responsive-mobile-menu">
                    <div class="menu toggle-btn d-block d-lg-none" data-toggle="collapse" data-target="#shop-menu" aria-expanded="false" role="button">
                        <div class="icon-left"></div>
                        <div class="icon-right"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>