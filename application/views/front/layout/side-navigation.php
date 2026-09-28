    <?php $link = $this->setting_model->get_all_setting();?>
    <div class="sidebar-menu" id="sidebar-menu">
        <button class="sidebar-menu-close">X</button>
        <div class="sidebar-inner">
            <div class="sidebar-logo">
                <a href="<?php echo base_url() ;  ?>" class="ps-logo">
                     <?php if($link[0]->logo ){ ?>
                      <img src="<?php echo base_url('uploads/').$link[0]->logo ?>" class="logo2 img-fluid" alt=" <?php echo $link[0]->title ;  ?>">
                    <?php } else{  ?>
                      <?php echo $link[0]->title ;  ?>
                    <?php } ?>
                </a>
            </div>
       
            <div class="sidebar-contact">
                <h4>Contact Us</h4>
                <ul>
                    <li><i class="fa fa-map-marker"></i><?php echo $link[0]->address_content; ?></li>
                    <li><a href="mailto:<?php echo $link[0]->email; ?>"><i class="fa fa-envelope-o"></i> <?php echo $link[0]->email; ?></a></li>
                    <li><a href="tel:<?php echo $link[0]->phone; ?>"><i class="fa fa-phone"></i> +<?php echo preg_replace('/\d{2}/', '$0-', str_replace('.', null, trim($link[0]->phone)), 2); ; ?></i>
            </div>
            <div class="sidebar-subscribe">
                <input type="text" placeholder="Email">
                <button><i class="fa fa-long-arrow-right"></i></button>
            </div>
            <div class="social-link">
                <ul>
                     <li class=""><a href="<?php echo $link[0]->facebook_link; ?>"><i class="fa fa-facebook"></i></a></li>
                     <li class=""><a href="<?php echo $link[0]->twitter_link; ?>"><i class="fa fa-twitter"></i></a></li>
                     <li class=""><a href="<?php echo $link[0]->instagram_link; ?>"><i class="fa fa-instagram"></i></a></li>
                     <li class=""><a href="<?php echo $link[0]->youtube_link; ?>"><i class="fa fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </div>