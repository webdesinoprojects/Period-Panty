<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Orders Listing</title>
  <?php $this->load->view('admin/layout/head_css'); ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>">
   <style>
      .btn-group-sm>.btn, .btn-sm {
            padding: 2px 7px;
            font-size: 12px;
            line-height: 1;
            border-radius: 3px;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 5px;
            line-height: 1.4;
            vertical-align: top;
            border-top: 1px solid #ddd;
            font-size: 12px;
        }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view('admin/layout/header'); ?>	
  
<?php $this->load->view('admin/layout/sidebar'); ?>	
	
	<div class="content-wrapper">
    
    <section class="content-header">
		<h1>All Orders Items</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">All Orders</li>			
		</ol>
    </section>

   
    <section class="content">
      <!-- Info boxes -->
		<div class="box">
			<div class="box-body table-responsive">
			<?php echo $this->session->flashdata('msg'); ?>
			<table id="example1" class="table table-bordered table-striped">
                <thead>
					<tr>
					    <th>#</th>						
						<th>Invoice</th>
						<th data-orderable="false" >Img</th>
						<th data-orderable="false" >Product</th>
						<th data-orderable="false" >SKU</th>
						<th data-orderable="false" >SIZE</th>
						<th data-orderable="false" >QTY</th>
						<th data-orderable="false" >User</th>
						<th data-orderable="false" >Date/Time</th> 
						<th data-orderable="false" >Order Status</th>
						<th data-orderable="false" >PYMT Method</th>
                        <th data-orderable="false" >Processing   Status</th>
                        <th data-orderable="false" >Remarks</th>						
						<th data-orderable="false" >Action</th>	
					</tr>
                </thead>
				<?php if(count($RESULT)>0){ ?>
                <tbody>
				<?php $no=0;foreach($RESULT as $record){ ?>	
				<?php $user=0;  if($record->user_id != 0){ $user = $this->user_model->get_user_by_id($record->user_id); } ?>	
				<?php  $items_data = $this->order_model->get_item_data($record->id); ?>    
				<?php foreach($items_data as $key=> $item){  $no++; ?>
				    <?php
				    $product_data = $this->product_model->get_product_by_id_some($item->pro_id);  
				    $product_images = $this->product_model->select_product_images($item->pro_id);?>
				     <?php $custom_option = json_decode($item->custom_options)  ; ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $record->order_no; ?></td>
						<td>
						     <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" alt="<?php echo $product_images[0]->img_tag; ?>" style="width:50px">
						</td>
						<td>
						  <?php echo  @$product_data[0]->title; ?></a>
                            
						</td>
						<td>
						    <?php echo  $custom_option->cartdata->sku; ?>
						</td>
						<td>
						    <?php echo$custom_option->cartdata->size ; ?> 
						</td>
						<td><?php echo $item->qty; ?>
						    
						</td>
						<td>
							<?php if($user){ ?>
							<a href="<?php echo base_url('admin/user/profile/'.$user[0]->id); ?>">
							<?php 
								echo ucwords($user[0]->fname).' '.ucwords($user[0]->lname);
								?>
								</a></td>
								<?php 
							}else{
							    
							    echo "Guest";
							}
							 ?>
								
						<td><?php echo date('d-M-Y ',strtotime($record->create_date)); ?><?php echo date('h:i A',strtotime($record->create_date)); ?> </td>
					   
						<td>
						
                            <?php if ($record->status == 'Pending') { ?>
                            <button class="btn  btn-sm btn-default "><?php Echo $record->status ?></button>
                             <?php }elseif ($record->status == 'Placed') { ?>
                            <button class="btn  btn-primary  btn-sm  "><?php Echo $record->status ?></button>
                            <?php }elseif ($record->status == 'Confirmed') { ?>
                            <button class="btn  btn-info  btn-sm  "><?php Echo $record->status ?></button>
                            <?php }elseif ($record->status == 'Cancelled') { ?>
                            <button class="btn  btn-warning  btn-sm  "><?php Echo $record->status ?></button>
                            <?php }elseif ($record->status == 'Return Initiated') { ?>
                            <button class="btn  btn-danger  btn-sm  "><?php Echo $record->status ?></button> 
                            <?php }elseif ($record->status == 'Returned') { ?>
                            <button class="btn  btn-danger  btn-sm  "><?php Echo $record->status ?></button> 
                            <?php  } ?>
						</td>	
						 <td><?php echo $record->payment_method; ?></td>
                      
                         <td>
					         
						    <?php if ($item->status == 'Pending') { ?>
                            <button class="btn  btn-sm btn-default "><?php Echo $item->status ?></button>
                            <?php }elseif ($item->status == 'Packed') { ?>
                            <button class="btn  btn-primary  btn-sm  "><?php Echo $item->status ?></button>
                            <?php }elseif ($item->status == 'Shipped') { ?>
                            <button class="btn  btn-info  btn-sm  "><?php Echo $item->status ?></button>
                            <?php }elseif ($item->status == 'Delivered') { ?>
                            <button class="btn  btn-success  btn-sm  "><?php Echo $item->status ?></button>
                           <?php }elseif (  $item->status == 'Cancelled'){  ?>           
                            <button class="btn  btn-sm btn-warning "><?php Echo $item->status ?></button>
                            <?php }elseif ($item->status == 'RTO Initiated') { ?>
                            <button class="btn  btn-danger  btn-sm  "><?php Echo $item->status ?></button> 
                            <?php }elseif ($item->status == 'RTO Completed') { ?>
                            <button class="btn  btn-danger  btn-sm  "><?php Echo $item->status ?></button>
                            <?php  } ?>
                            
                            
					    </td>
                     	<td><?php Echo $item->remarks ?></td>		
						<td width="10%">
						    <a type="button" data-book-id="<?php echo $record->order_no;?>" data-book-status="<?php echo $record->status;?>"  data-book-remark="<?php echo $record->remarks;?>"     class="btn btn-sm btn-success btn-sm showstatus" data-toggle="modal" data-target="#myModal1">  Order Status</a> &nbsp; 
						    <a type="button" data-book-id="<?php echo $record->order_no;?>"  data-book-payment="<?php echo $record->payment_status;?>" class="btn btn-sm btn-primary btn-sm showpayment" data-toggle="modal" data-target="#paymentModel">  Payment Status</a> 
						    <a type="button" data-book-order="<?php echo $record->order_no;?>" data-book-id="<?php echo $record->id;?>" data-book-status="<?php echo $item->status;?>" data-book-remark="<?php echo $item->remarks;?>"  data-pro-id="<?php echo  $item->pro_id; ?>" class="btn btn-sm btn-warning   btn-sm showitemstatus" data-toggle="modal" data-target="#myModal2">  Processing    Status</a>  
							<a href="<?php echo base_url('admin/orders/view/'.$record->id); ?>" class="btn  btn-info btn-sm"><i class="fa fa-fw fa-file"></i> Invoice</a><br>
							<a href="<?php echo base_url('admin/orders/delete/'.$record->id); ?>"  onclick="return confirm('Are you sure you want to delete this item?');" class="btn  btn-danger btn-sm"><i class="fa fa-fw fa-trash  "></i> Delete</a><br>
						    
						</td>	
					</tr>

    				<?php } ?>	
				<?php } ?>	
                </tbody> 
				<?php } ?>	
            </table>
            </div>
		</div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->  
<?php $this->load->view('admin/layout/footer'); ?>
</div>
<!-- ./wrapper -->
<?php $this->load->view('admin/layout/footer_js'); ?>
<?php $this->load->view('admin/layout/data-table-js'); ?>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Order Status</h4> </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo base_url('admin/orders/ProcessOrderStatus') ?>" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label> Order Id <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="order_no" value="" readonly="readonly"> 
                        </div>
                    
                       
                        <div class="form-group">
                            <label> Order Status <span style="color:red;">*</span></label>
                            <select class="form-control" name="status"  id="status" required>
                                <option value=""></option>
                                <option >Placed</option>
                                <option >Confirmed</option>
                                <!--<option >Cancelled</option>-->
                               
                            </select>
                        </div> 
                        
                          <div class="form-group">
                            <label>Remarks <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="remarks" id="order_remark" ></textarea>
                        </div>
                     
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="Update" class="btn btn-primary" onclick="return confirm('Are you sure you want to change this order status  ?');">Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.showstatus').on('click', function() {
        $('#myModal1 input[name="order_no"]').val();
        var bookId = $(this).attr('data-book-id');
        var bookstatus = $(this).attr('data-book-status');
        var order_remark = $(this).attr('data-book-remark');
        $('#myModal1 input[name="order_no"]').val(bookId);
        $('#status').val(bookstatus).attr("selected", "selected");
         $('#order_remark').val(order_remark);
    });

</script>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Processing  Status</h4> </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo base_url('admin/orders/ProcessItemStatus') ?>" enctype="multipart/form-data"> 
                    <div class="box-body">
                        <div class="form-group">
                            <label>Invoice No<span style="color:red;">*</span></label>
                            <input type="text" class="form-control"  value="" id="itemorder" readonly="readonly"> 
                        </div>
                        <input type="hidden" class="form-control" name="order_id" value="" readonly="readonly">
                        <input type="hidden" class="form-control" name="pro_id" value="" readonly="readonly"> 
                        
                        <div class="form-group">
                            <label>Item Order Status <span style="color:red;">*</span></label>
                            <select class="form-control" name="status"  id="itemstatus" required>
                                <option >Pending</option>
                                <option >Packed</option>
                                <option >Shipped</option>
                                <option >Delivered</option>
                                <!--<option >Cancelled</option>-->
                           
                            </select>
                        </div> 
                        <div class="form-group">
                            <label>Remarks <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="remarks" required id="remark"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="Update" class="btn btn-primary" onclick="return confirm('Are you sure you want to change this process status  ?');">Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.showitemstatus').on('click', function() {
        $('input[name="order_id"]').val();
        var bookstatus = $(this).attr('data-book-status');
        var bookorder = $(this).attr('data-book-order');
        var bookId = $(this).attr('data-book-id');
        var pro_id = $(this).attr('data-pro-id');
        var remark = $(this).attr('data-book-remark');
        $('#itemorder').val(bookorder);
        $('input[name="pro_id"]').val(pro_id);
        $('input[name="order_id"]').val(bookId);
        $('#remark').val(remark);
        $('#itemstatus').val(bookstatus).attr("selected", "selected")
    });

</script>

<div class="modal fade" id="paymentModel" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Payment Status</h4> </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo base_url('admin/orders/ProcessPaymentStatus') ?>" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label> Order Id <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="order_no" value="" readonly="readonly"> 
                        </div>
                         
                        <div class="form-group">
                            <label>Payment Status <span style="color:red;">*</span></label>
                            <select class="form-control" name="payment_status"  id="payment_status" required>
                                <option value=""></option>
                                <option  >Paid</option>
                                <option  >Unpaid</option>
                            
                            
                            </select>
                        </div> 
                      
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="Update" class="btn btn-primary" onclick="return confirm('Are you sure you want to change this payment status  ?');">Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.showpayment').on('click', function() {
        $('#paymentModel input[name="order_no"]').val();
        var bookId = $(this).attr('data-book-id');
        var bookpayment = $(this).attr('data-book-payment');
        $('#paymentModel input[name="order_no"]').val(bookId);
        $('#payment_status').val(bookpayment).attr("selected", "selected") ; 
         
    });

</script>
</body>
</html>
