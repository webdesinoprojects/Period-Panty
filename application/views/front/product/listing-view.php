<?php $product_images = $this->product_model->select_product_images($product->id); ?>
<?php  $url = $this->product_model->get_product_url($product->id) ; ?>

        <div class="card border-0 product" >
            <div class="position-relative"> 
                <a href="<?php echo $url ?>">
                        <?php if($product_images){ ?>
                         <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" class="main-image" alt="<?php echo $product->title; ?>">
                         <?php }else{  ?>
                         <img src="<?php echo base_url('images/1215BP6.png'); ?>" alt="<?php echo $product->title; ?>" class="main-image">
                         <?php } ?>
                </a>
            
        
                <div class="card-img-overlay d-flex p-3">
                      <?php if($product->discount){ ?>
                       <div><span class="badge badge-primary"><?php echo(int)$product->discount; ?>% Off</span></div>
                    <?php } ?>
             
                <div class="my-auto w-100 content-change-vertical">
                  <a href="<?php echo $url ?>" data-toggle="tooltip" data-placement="left" title="View products" class="add-to-cart ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                    <svg class="icon icon-shopping-bag-open-light fs-24">
                      <use xlink:href="#icon-shopping-bag-open-light"></use>
                    </svg>
                  </a>
                
                  <a href="javascript:void(0)"   data-id="<?php echo $product->id; ?>"  data-toggle="tooltip" data-placement="left" title="Add to wishlist" class="wishlist-add add-to-wishlist ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                    <svg class="icon icon-star-light fs-24">
                      <use xlink:href="#icon-star-light"></use>
                    </svg>
                  </a>
                
                </div>
              </div>
            </div>
            <div class="card-body pt-4 text-center px-0">
              <h2 class="card-title fs-20 font-weight-500 mt-0"><a href="<?php echo $url ?>"><?php echo $product->title; ?></a> </h2>
           
              <p class="card-text font-weight-bold fs-16 mb-1 text-secondary">
                  <?php if($product->special_price !='0.00'){ ?> 
                <span class="fs-15 font-weight-500 text-decoration-through text-body pr-1"> <?php echo CURRENCY_SYMBOL." ".round($product->price); ?></span>
                 <span> <?php echo CURRENCY_SYMBOL." ".round($product->special_price); ?></span>
                    <?php }else{ ?>
                <span> <?php echo CURRENCY_SYMBOL." ".round($product->price); ?></span>
                  <?php }?>
              </p>
              <div class="d-flex align-items-center justify-content-center flex-wrap">
                <ul class="list-inline mb-0 lh-1">
                <?php for ($x = 1; $x <= $product->absorbency_rate; $x++) { ?>

                  <li class="list-inline-item fs-14 text-primary mr-0">
                    <i class="fas fa-tint"></i>
                    </li>
                <?php } ?>
                  <?php $diff = 5-$product->absorbency_rate ; ?>
                         <?php
                            for ($x = 1; $x <= $diff; $x++) { ?>
                                  <li class="list-inline-item fs-14 text-primary mr-0">
                                    <i class="text-drops far fa-tint"></i>
                                  </li>
                              
                          <?php   } ?>
                </ul>
              </div>
              
          
            </div>
          </div>
  