<?php $link = $this->setting_model->get_all_setting();?>
<?php $user_id = $this->session->userdata('USER_ID'); ?>
<?php 	$userdata  = $this->user_model->get_user_by_id($user_id); ?>
<?php 	$wislist  = $this->user_model->count_user_wishlist($user_id); ?>
<?php $act = $this->uri->segment(2); ?>
<?php $cart_content = $this->cart->contents(); ?>
 <div class="row align-items-center">
    <div class="col-lg-8 col-sm-6 col-6">
         <div class="left-nav  nav-left-part">
            <ul>
               
                <li><a href="javacript:void();"> <?php echo $link[0]->about_content; ?> </a></li>
           
            </ul>
           
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-6">
        <div class="right-nav text-right nav-right-part">
            <ul>
                <li>
                    <a href="#" id="search"><i class="icon-search"></i></a>
                </li>
                <?php if(empty($user_id)){ ?>
                <li>
                    <a href="<?php echo base_url('user/login') ;?>?redirect_url=user/wishlist"><i class="icon-heart"></i><span class="badge badge-pink"></span></a>
                </li>
                 <?php }else{ ?>
                 <li>
                    <a href="<?php echo base_url('user/wishlist') ;?>"><i class="icon-heart"></i><span class="badge badge-pink"><?php echo $wislist ; ?></span></a>
                </li>
                <?php } ?>
                <li class="has-dropdown">
                    <a href="<?php echo  base_url('cart') ;?>"><i class="icon-add-to-cat"></i><span class="badge badge-pink cart-label"><?php echo count($cart_content); ?></span></a>
                   
                </li>
                <?php if(empty($user_id)){ ?>
                <li><a href="<?php echo base_url('user/login'); ?>"><i class="icon-user"></i></a></li>
                <?php }else{ ?>
                <li>
                    <a href="#"><i class="icon-user"></i> <span class="mobile-hidden"> Hello , <?php echo ucwords($userdata[0]->fname.' '.$userdata[0]->lname) ; ?></span></a>
                    <ul class="user-dropdown">
                        <li><a href="<?php echo base_url('user/profile'); ?>"><i class="icon-user"></i> My Account</a></li>
                        <li><a href="<?php echo base_url('user/profile'); ?>">Profile</a></li>
                        <li ><a href="<?php echo base_url('user/my_orders'); ?>">Orders</a></li>
                        <li ><a href="<?php echo base_url('user/my_rewards'); ?>">My Rewards</a></li>
                        <li ><a href="<?php echo base_url('user/my_refer_link'); ?>">Invite Friends</a></li>
                      	
                    	<li><a href="<?php echo base_url('user/change_password'); ?>">Change Password</a></li>
                    	
                    	<li><a href="<?php echo base_url('user/logout'); ?>">Logout</a></li> 
                       
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
