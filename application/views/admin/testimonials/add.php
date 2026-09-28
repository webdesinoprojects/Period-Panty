<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>  Add </title>
    <?php $this->load->view('admin/layout/head_css'); ?> </head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Add New Testimonials</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="<?php echo base_url('admin/Testimonials/listing'); ?>">All Testimonials</a>
                    </li>
                    <li class="active">Add New Testimonials</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <!-- /.box-header -->
                            <?php echo $this->session->flashdata('msg'); ?>
                            <!-- form start -->
                            <form role="form" method="post" id="form" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">User Name</label>
                                        <input type="text" class="form-control" name="name" value="" required placeholder="Enter Name"> </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Country </label>
                                        <input type="text" class="form-control" name="country" value="" placeholder="Enter Country"> </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Package Name </label>
                                        <input type="text" class="form-control" name="package" value="" placeholder="Enter package name"> </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Image</label>
                                        <input type="file" class="form-control" name="image" placeholder="Enter image" value=""> </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> Description</label>
                                        <input type="text" class="form-control" name="description" required placeholder="Enter description"> </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value='1'>Active</option>
                                            <option value='0'>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="submitform">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('admin/layout/footer'); ?> </div>
    <!-- ./wrapper -->
    <?php $this->load->view('admin/layout/footer_js'); ?>
    <script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
    <script class="example">
        $(document)
            .ready(function() {
                $('#form')
                    .parsley();
            });

    </script>
</body>

</html>
