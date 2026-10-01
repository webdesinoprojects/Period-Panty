<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
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
 .modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
    z-index: 11111;
}
</style>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>

 <div class="dx-acct pt-9 pb-9">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 mb-5 mb-lg-0"><?php $this->load->view('front/account/left-menu'); ?></div>
            <div class="col-lg-9">
					<?php if(count($ORDER)>0){ ?>
					<?php foreach($ORDER as $key=> $order_data){ ?>
					<div class="row" style="border: 1px solid #e8e6e6; margin-bottom:10px">
					    <div class="col-sm-12" style="    background: #ececec; padding: 10px;20px">
					        <div class="row">
					            <div class="col-sm-4"><h6>Order Number : <b><?php Echo $order_data->order_no ?> </b></h6></div>
                                
                                <div class="col-sm-4"><h6>Order Status : <?php Echo $order_data->status ?></h6></div>
                                <div class="col-sm-4"><h6>Placed On : <b><?php echo date( 'd-m-Y',strtotime($order_data->create_date)); ?> </b></h6></div>
					        </div>
					    </div>
                        <div class="col-sm-12">
                            <br>
                        <?php  $items_data = $this->order_model->get_item_data($order_data->id); ?>    
    					<?php if(count($items_data)>0){ ?>
    					<?php foreach($items_data as $key=> $item){ ?>
    					 <?php
    					    $product_data = $this->product_model->get_product_by_id($item->pro_id);  
    					    $product_images = $this->product_model->select_product_images($item->pro_id);?>
    						<?php $product_images = $this->product_model->select_product_images($item->pro_id);
                            $product_data = $this->product_model->get_product_by_id($item->pro_id); ?>
                            <?php  $url = $this->product_model->get_product_url($item->pro_id) ; ?>
                            <?php $custom_option = json_decode($item->custom_options)  ; ?>
                            
                            <div class="row" >
                         
                                <div class="col-sm-2 col-2"> 
                                
                                <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" alt="<?php echo $product_images[0]->img_tag; ?>" style="width:50%">
                              
                                </div>
                                <div class="col-sm-7 col-10"> 
                        
                                         <h5><a class="cart_title" href="<?php echo $url; ?>"><?php echo  $product_data[0]->title; ?></a>*<?php echo $item->qty; ?></h5>
                                         <p>
                                            <?php print_r($custom_option->cartdata->size) ; ?>
                                        </p>
                                        <p>
                                               <strong> <?php echo CURRENCY_SYMBOL." ".$item->sub_total; ?></strong>
                                                
                                        </p>   
                                       
                                 </div>
                                 <div class="col-sm-3 col-12"> 
                          
                                        <p>
                                              <label><?php echo $item->status; ?></label>
                                                
                                        </p>  
                                        <p>
                                                <a href="<?php echo base_url('user/view_order/'. $order_data->order_no); ?>" style="color:blue"> View Details</a> 
                                                &nbsp; &nbsp;
                                                 <?php if( ($item->status != "Cancelled" )&&($item->status != "Pending" ) ) { ?>   
                                                <a type="button" data-book-id="<?php echo $order_data->id;?>" data-pro-id="<?php echo  $item->pro_id; ?>" data-book-status="<?php echo $order_data->status;?>"  class="btn btn-sm btn-success btn-sm showstatus" style="color:#fff" data-toggle="modal" data-target="#myModal1"> Cancel Order</a> &nbsp; 
                                                <?php } ?>
                                        </p>
                                 </div>
                    
                                
                              </div>
                              <hr>
    					<?php } ?>	
    					<?php } ?>	
    					
                        </div>
                    </div>
                    <?php }?>
					<?php }else{ ?>
						<div class="dx-panel"><div class="dx-empty">
						  <i class="far fa-box-open"></i>
						  <p>You have no orders yet.</p>
						  <a href="<?php echo base_url('shop'); ?>" class="dx-acct-cta">Start shopping</a>
						</div></div>
					<?php } ?>
					
                 
           
            </div>
          </div>
        </div>
    </div>

<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>

<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
             <form method="POST" action="<?php echo base_url('user/cancel_order') ?>" enctype="multipart/form-data"> 
            <div class="modal-body">
               
                <h4 class="modal-title">Cancel Order</h4> 
                    <div class="box-body">
                        
                            <input type="hidden" class="form-control" name="order_id" value="" readonly="readonly">
                            <input type="hidden" class="form-control" name="pro_id" value="" readonly="readonly"> 
                        
                      
                       
                        <div class="form-group">
                            <label> Reasone <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="remarks" required></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        
                    </div>
               
            </div>
            <div class="modal-footer">
                <button type="submit" name="Update" class="btn btn-primary">Submit</button>
            </div>
             </form>
        </div>
    </div>
</div>
<script>
    $('.showstatus').on('click', function() {
        $('input[name="order_id"]').val();
        var bookId = $(this).attr('data-book-id');
        var pro_id = $(this).attr('data-pro-id');
        $('input[name="order_id"]').val(bookId);
        $('input[name="pro_id"]').val(pro_id);
    });

</script>

</body>
</html>