

<div class="woocommerce-widget-area">
      <div class="woocommerce-widget aside-trending-widget">
        <div class="pl-1 pull-right">
           
                 <button class="btn btn-sales pull-right" id="clearall" type="submit" tabindex="0">Clear Now <i class="fa fa-arrow-right"></i></button>
     
<input type="hidden"  class="where_clause" value="<?php if(isset($_GET['where_clause'])){ echo $_GET['where_clause'] ; } ?>"  name="where_clause" >

<?php 
 $url = $this->uri->segment(1);
 if($url == 'shop'){
    $cat_id= '' ;  
 }else{
     $cat_id= $RESULT[0]->id ; 
 }
?>
<input type="hidden" class="cat_id" value="<?php echo $cat_id ?>"  name="cat_id" >
        </div>
    </div> 
    <div class="woocommerce-widget collections-list-widget">
        <h3 class="woocommerce-widget-title">Collections</h3>
        <ul class="collections-list-row">
               <?php $parent = $this->category_model->get_category_by_parent_menu('0');?>
                <?php foreach($parent as $parents){ ?>
                    <?php $childcategory = $this->category_model->get_category_by_parent_menu( $parents->id);?>
                    <?php 
                     $url = $this->uri->segment(1);
                     if($url == 'shop'){
                        $cat_id= '' ;  
                     }else{
                         $cat_id= $RESULT[0]->id ; 
                     }
                    
                    ?>
                                 
                      <li class="has-children"><a href="<?php echo base_url() ?><?php echo $parents->url_slug;?>.html"><span class="menu-text"><?php echo $parents->title; ?></span></a>
                      
                       </li>
             
                <?php }?>
     
        </ul>
    </div>
    <div class="woocommerce-widget collections-list-widget">
        <h3 class="woocommerce-widget-title">Category</h3>
        <ul class="collections-list-row">
               <?php $parent = $this->category_model->get_category_by_parent_menu('0');?>
               
                    <?php $childcategory = $this->category_model->get_category_by_parent_menu( $parent[0]->id);?>
                    <?php 
                     $url = $this->uri->segment(1);
                     if($url == 'shop'){
                        $cat_id= '' ;  
                     }else{
                         $cat_id= $RESULT[0]->id ; 
                     }
                    
                    ?>
              
                      
                          <?php foreach($childcategory as $childs){ ?>
                                        <li><a href="<?php echo base_url() ?><?php echo $childs->url_slug;?>.html"><span class="menu-text"><?php echo $childs->title;?></span></a></li>
                                    <?php } ?>
                       </ul>
        </ul>
    </div>
    <div class="woocommerce-widget price-list-widget">
        <h3 class="woocommerce-widget-title">Price</h3>
        <div class="collection-filter-by-price">
            <div class="price_filter">
                <div class="price_slider_amount">
                    <input type="submit"  value="Price:"/> 
                    <input type="text" class="price" id="amount" name="price" value="<?php if(isset($_GET['price'])){ echo $_GET['price'] ; } ?>" /> 
                </div>
                <div id="slider-range"></div>
            </div>
        </div>
    </div>
 
    <div class="woocommerce-widget collections-list-widget">
        <h3 class="woocommerce-widget-title">Color</h3>
        <div class="product_color_switch">
            <ul class="collections-list-row">
                <?php $color = $this->product_model->get_all_active_color() ;  ?>
                <?php foreach($color as $value){ ?>                     
                     <li class="colour-listItem">
                        <label class="common-customCheckbox">
                         
                          <input type="checkbox" name="color[]"  value="<?php echo $value->code ; ?>" <?php if(isset($_GET['color']) && (in_array($value->code  , $_GET['color']) )){ echo "checked" ; } ?>>
                           <span data-colorhex="<?php echo $value->title ; ?>" class="colour-label colour-colorDisplay" style="background-color: <?php echo $value->code ; ?>;"></span> <?php echo $value->title ; ?>
                       
                       
                        </label>        
                    </li>
                <?php } ?>
            </ul>
           
        </div>
      
    </div>
    	
   
    <div class="woocommerce-widget collections-list-widget">
        <h3 class="woocommerce-widget-title">Age Group</h3>
        <ul class="collections-list-row">
             <?php $age_group = $this->product_model->get_all_active_age_group() ;  ?>
            <?php foreach($age_group as $value){ ?>
            <li class="">
                 <input type="radio" class="age_group" name="age_group" value="<?php echo $value->title ; ?>" <?php if(isset($_GET['age_group']) && ($_GET['age_group'] == $value->title )){ echo "checked" ; } ?>> <?php echo $value->title ; ?>
            </li>
            <?php } ?>
            <li class="">
                 <input type="radio" class="age_group" name="age_group" value="" > None
            </li>
        </ul>
       
    </div>
     <div class="woocommerce-widget collections-list-widget">
        <h3 class="woocommerce-widget-title">Size</h3>
        <ul class="collections-list-row">
             <?php $size = $this->product_model->get_all_active_size() ;  ?>
            <?php foreach($size as $value){ ?>
            <li class="">
               <input type="radio"  class="size" name="size" value="<?php echo $value->title ; ?>" <?php if(isset($_GET['size'])&&($_GET['size'] == $value->title )){ echo "checked" ; } ?> >&nbsp;&nbsp;<?php echo $value->title ; ?> 
            </li>
            <?php } ?>
            <li class="">
                 <input type="radio" class="size" name="size" value="" > None
            </li>
           
        </ul>
        
    </div>

    <?php if($RESULT[0]->image){ ?>
    <div class="woocommerce-widget aside-trending-widget">
        <div class="aside-trending-products"> <img src="<?php echo base_url('uploads/category/').$RESULT[0]->image; ?>" alt="image">
            <div class="category">
                <h3>Top Trending</h3> <span>Spring/Summer 2021 Collection</span> </div>
            <a href="#" class="link-btn"></a>
        </div>
    </div>
    <?php }?>
</div>
