<?php $all_users=$this->user_model->get_all_users_by_ststus('all'); ?>
<?php $module=$this->uri->segment(2); ?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="active treeview">
                <a href="<?php echo base_url('admin/dashboard'); ?>"> <i class="fa fa-tachometer"></i> <span>Dashboard</span> </a>
            </li>
            <?php $ADMIN_AUTH=$this->session->userdata('ADMIN_AUTH'); $subadminauthority= explode('@',$ADMIN_AUTH ); ?>
           
            <li class="treeview">
                <a href="<?php echo base_url('admin/user/all'); ?>"> <i class="fa fa-user-circle-o"></i> <span>Users </span> </a>
            </li>
            <li class="treeview">
                <a href="<?php echo base_url('admin/orders/listing'); ?>"> <i class="fa fa-shopping-bag"></i> <span>Orders </span> </a>
            </li>
         
            <li class="treeview">
                <a href="#"> <i class="fa fa-cubes"></i> <span>Products</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('admin/product/listing'); ?>"><i class="fa fa-angle-right"></i>All Products</a> </li>
                    <li><a href="<?php echo base_url('admin/product/stock'); ?>"><i class="fa fa-angle-right"></i>Product Stock</a> </li>
                    <li><a href="<?php echo base_url('admin/product/add_new'); ?>"><i class="fa fa-angle-right"></i>Add New Product</a> </li>
                    <li><a href="<?php echo base_url('admin/product/color_variation'); ?>"><i class="fa fa-angle-right"></i>Color</a> </li>
    
                  
                </ul>
            </li>
  
             <li class="treeview">
                <a href="#"> <i class="fa fa-picture-o"></i> <span>CMS</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('admin/page/listing'); ?>"><i class="fa fa-angle-right"></i>Page </a> </li>
                    <li><a href="<?php echo base_url('admin/slider/listing'); ?>"><i class="fa fa-angle-right"></i>Sliders</a> </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="<?php echo base_url('admin/user/all_mail'); ?>"> <i class="fa fa-paper-plane-o"></i> <span>Enquiry </span> </a>
            </li>
            <li class="treeview">
                <a href="#"> <i class="fa fa-sliders" aria-hidden="true"></i> <span> Category </span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('admin/category/listing'); ?>"><i class="fa fa-angle-right"></i>All  Category</a> </li>
                    <li><a href="<?php echo base_url('admin/category/add_new'); ?>"><i class="fa fa-angle-right"></i>Add New  Category</a> </li>
                </ul>
            </li>
            
          
         
            <li class="treeview">
                <a href="<?php echo base_url('admin/setting/edit/1'); ?>"> <i class="fa fa-cog fa-fw" aria-hidden="true"></i><span>Setting</span> <span class="pull-right-container"></span> </a>
          
            </li>
        </ul>
    </section>
</aside>
