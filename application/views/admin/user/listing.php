<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> All Users <?php echo $link[0]->title ;  ?></title>
  <?php $this->load->view('admin/layout/head_css'); ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view('admin/layout/header'); ?>	
<?php $this->load->view('admin/layout/sidebar'); ?>	
	<div class="content-wrapper">
    <section class="content-header">
		<h1>All Users</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">All Users</li>			
		</ol>
    </section>
    <section class="content">
      <!-- Info boxes -->
		<div class="box">
			<div class="box-body table-responsive">
			<?php echo $this->session->flashdata('msg'); ?>
			 <form class="form-horizontal post" method="post"  enctype="multipart/form-data">
            <div class="row">
		        
		         <div class="col-xs-4  col-sm-2"> 		
		                 <select class="form-control"  name="status" required>
							<option value="1" >Active</option>
							<option value="0" >Inactive</option>
							<option value="2" >Blocked</option>
						</select>
					</div>
		         <div class="col-xs-4  col-sm-2"><button class="btn btn-danger" type="submit" name="submit" onclick="return confirm('Are you sure you want to change status ?');"> Submit</button></div>

		     </div>
		     <hr>
			<table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
					<tr>
					    <th data-orderable="false"><span ><input type='checkbox' id="checkAll" > </span></th>
						<th>SNo.</th>
						<th data-orderable="false" >Name</th>
						<th data-orderable="false" >Email</th>
						<th data-orderable="false" >Contact No</th>
						<th data-orderable="false" >Status</th> 
						<th data-orderable="false" >Reg. Date</th>
						<th data-orderable="false" >Action</th>	
					</tr>
                </thead>
				<?php if(count($RESULT)>0){ ?>
                <tbody>
				<?php $no=0; foreach($RESULT as $record){ $no++; ?>
					<tr>
					     <td>
					         <input type='checkbox' value="<?php echo $record->id; ?>" name="user_id[]"   > 
            			</td>
						<td width="7%"><?php echo $no; ?></td>
						<td><?php echo ucwords($record->fname).' '.ucwords($record->lname); ?> <?php if($record->role == 2) {echo "<small style='color:red'>Team <small>" ;} ?> </td>
						<td><?php echo $record->email; ?></td>
						<td><?php echo $record->contact_no; ?></td>
						<td >
							<?php if($record->status==1){ ?>
							<span class="label label-success">Active</span>
							<?php }else if($record->status==0) { ?>
							<span class="label label-warning">Inactive</span>
							<?php }else{ ?>
								<span class="label label-danger">Blocked</span>
							<?php } ?>
						</td>
					<td>
                    <?php echo date('d/M/Y', strtotime($record->create_date)); ?></td>
						<td width="15%">
							<a href="<?php echo base_url('admin/user/profile/'.$record->id); ?>" class="btn  btn-primary btn-xs"><i class="fa fa-fw fa-eye"></i>View</a>	 
						</td>	
					</tr>
				<?php } ?>	
                </tbody> 
				<?php } ?>	
            </table>
            </form>
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

</body>
</html>
