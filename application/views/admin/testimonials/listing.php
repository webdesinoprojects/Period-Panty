<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title> Testimonials</title>

  <?php $this->load->view('admin/layout/head_css'); ?>

  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>">

</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

<?php $this->load->view('admin/layout/header'); ?>	

  <!-- Left side column. contains the logo and sidebar -->

<?php $this->load->view('admin/layout/sidebar'); ?>	

	<!-- Content Wrapper. Contains page content -->

	<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

		<h1>All Testimonials</h1>

		<ol class="breadcrumb">

			<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

			<li class="active">All Testimonials</li>

		</ol>

    </section>

   <div class="box-footer">
              <a href="add_new">  <button type="submit" class="btn btn-primary" name="submitform">Add New Testimonials </button></a>
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

						<th>Name</th>
						<th>Country</th>

						

						<th>Action</th>	

					</tr>

                </thead>

				<?php if(count($RESULT)>0){ ?>

                <tbody>

				<?php $no=0; foreach($RESULT as $record){ $no++; ?>			

					<tr>

						<td width="7%"><?php echo $no; ?></td>

						<td><?php echo $record->name; ?></td>
						<td><?php echo $record->country; ?></td>

						

						<td width="15%">

							<a href="<?php echo base_url('admin/Testimonials/edit/'.$record->id); ?>" class="btn  btn-success btn-xs"><i class="fa fa-fw fa-edit"></i>Edit</a>
							
							<a href="<?php echo base_url('admin/Testimonials/delete_Testimonials/'.$record->id); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i>Delete</a>

							

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

<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>

<script>

  $(function () {

    $("#example1").DataTable();    

  });

</script>

</body>

</html>

