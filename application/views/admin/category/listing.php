<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title> All Categories ||  <?php echo $link[0]->title ;  ?></title>
		<?php $this->load->view('admin/layout/head_css'); ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>">
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php $this->load->view('admin/layout/header');?>	
			<?php $this->load->view('admin/layout/sidebar'); ?>		
			<div class="content-wrapper">
				
				<section class="content-header">
					<h1>All Categories</h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">All Categories</li>
					</ol>
				</section>

				<div class="box-footer">
              <a href="add_new">  <button type="submit" class="btn btn-primary" name="submitform">Add New Category</button></a>
              </div>

				<!-- Main content -->
				<section class="content">
				  <!-- Info boxes -->
					<div class="box">
						<div class="box-body">
						<?php echo $this->session->flashdata('msg'); ?>
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>SNo.</th>
									<th data-orderable="false" >Title</th>
									<th data-orderable="false" >Image</th>
									<th data-orderable="false" >Parent </th>
									<th data-orderable="false" >Home</th>
									<th data-orderable="false" >Status</th>  
									<th data-orderable="false" >Action</th>	
								</tr>
							</thead>
							<?php if(count($RESULT)>0){ ?>
							<tbody>
							<?php $no=0; foreach($RESULT as $record){ $no++; ?>			
								<tr>
									<td width="7%"><?php echo $no; ?></td>
									<td><?php echo $record->title; ?></td>
									<td>
										<?php if(!empty($record->image)){ ?>
												<img src="<?php echo base_url('uploads/category/').$record->image; ?>" width="70px">
										<?php } ?>
									</td>
								
									<td>
										<?php 
									
									        	if($record->parent_id == 0){
											echo "Root";
											}else
												{
													$cat = $this->category_model->get_category_by_id($record->parent_id);
													
													echo $cat[0]->title	 ; 
													
													
												}
										?>
									</td>
									<td width="15%">
										<?php if($record->home_display==1){ ?>
										<span class="label label-success">Yes</span>
										<?php }else{ ?>
										<span class="label label-danger">No</span>
										<?php }?>	
									</td>
										<td width="15%">
										<?php if($record->status==1){ ?>
										<span class="label label-success">Active</span>
										<?php }else{ ?>
										<span class="label label-danger">Inactive</span>
										<?php }?>	
									</td>
									<td width="15%">
										<a href="<?php echo base_url('admin/category/edit/'.$record->id); ?>" class="btn  btn-success btn-xs"><i class="fa fa-fw fa-edit"></i>Edit</a>
									<!--	<a href="#" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-xs">
											<i class="fa fa-fw fa-trash"></i>Delete
										</a> -->
									</td>	
								</tr>
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
	</body>
</html>
