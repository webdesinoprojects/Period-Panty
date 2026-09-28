<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Payment History</title>
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
		<h1> Payment History</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"> Payment History</li>			
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
						<th data-orderable="false" >User</th>
					
						<th data-orderable="false" >Total PYMT </th>
					
						<!--<th data-orderable="false" >Coupon Disc</th>-->
						<th data-orderable="false" >Final PYMT </th>
						<th data-orderable="false" >PYMT Method</th>
                        <th data-orderable="false" >PYMT Status</th>					
                        <th data-orderable="false" >Order Remark</th>						
						<th data-orderable="false" >Action</th>	
					</tr>
                </thead>
				<?php if(count($RESULT)>0){ ?>
                <tbody>
				<?php $no=1;foreach($RESULT as $record){ ?>	
				<?php $user=0;  if($record->user_id != 0){ $user = $this->user_model->get_user_by_id($record->user_id); } ?>	
			
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $record->order_no; ?></td>
					
					
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
					
					    <td><?php echo $record->total_amount; ?></td>
					   
					    <!--<td><?php echo $record->discount_amount; ?></td>-->
					    <td><?php echo $record->final_amount; ?></td>
					    <td><?php echo $record->payment_method; ?></td>
                        <td>
                             <?php if(  $record->payment_status == 'Pending'){  ?>    
                            <button class="btn btn-sm btn-default">     <?php Echo $record->payment_status ?></button>
                         
                             <?php }elseif ($record->payment_status == 'Paid') { ?>
                            <button class="btn btn-sm btn-success  "><?php Echo $record->payment_status ?></button>
                            
                             <?php }elseif ($record->payment_status == 'Unpaid') { ?>
                            <button class="btn btn-sm btn-primary  "><?php Echo $record->payment_status ?></button>
                    
                            <?php }elseif ($record->payment_status == 'Fully Refunded') { ?>
                            <button class="btn btn-sm btn-info  "><?php Echo $record->payment_status ?></button>
                         
                             <?php }elseif ($record->payment_status == 'Partially Refunded') { ?>
                            <button class="btn btn-sm btn-warning  "><?php Echo $record->payment_status ?></button>
                        
                             <?php }elseif ($record->payment_status == 'Refund Declined') { ?>
                            <button class="btn btn-sm btn-danger  "><?php Echo $record->payment_status ?></button>
                            <?php  } ?>
                        </td>
                      
                     		<td><?php Echo $record->remarks ?></td>		
						<td width="10%">
						    <a type="button" data-book-id="<?php echo $record->order_no;?>"  data-book-payment="<?php echo $record->payment_status;?>" data-book-remark="<?php echo $record->remarks;?>"  class="btn btn-sm btn-primary btn-sm showpayment" data-toggle="modal" data-target="#paymentModel"> <i class="fa fa-fw  fa-credit-card"></i> Payment </a> 
						   
							<a href="<?php echo base_url('admin/orders/view/'.$record->id); ?>" class="btn  btn-default btn-sm"><i class="fa fa-fw fa-print"></i> Invoice</a><br>
						
						</td>	
					</tr>	
				<?php $no++; } ?>	
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
<div class="modal fade" id="paymentModel" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Payment Status</h4> </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo base_url('admin/orders/processPaymentStatus') ?>" enctype="multipart/form-data">
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
                       
                        <div>
                             
                        </div>
                      
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="Update" class="btn btn-primary"  onclick="return confirm('Are you sure you want to change this payment status  ?');" >Update</button>
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
