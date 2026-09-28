<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FAQ'S </title>
    <?php $this->load->view('admin/layout/head_css'); ?>
   
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <!-- Content Wrapper. Contains Services content -->
        <div class="content-wrapper">
            <!-- Content Header (Services header) -->
            <section class="content-header">
                <h1>Add New Frequently Asked Questions</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li><a href="<?php echo base_url('admin/faq/listing'); ?>">All Frequently Asked Questions</a> </li>
                    <li class="active">Add New Frequently Asked Questions</li>
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
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" class="form-control" name="title" onkeyup="return set_slug(this.value);" required placeholder="Enter Title">
                                        <?php echo form_error( 'title'); ?> </div>
                                  
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description" value="" placeholder="Enter description"></textarea>
                                    </div> 
                                  
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
                                    <button type="submit" class="btn btn-primary" name="submitform">Add Faq</button>
                                    <a href="<?php echo base_url()?>admin/faq/listing">
                                        <button type="button" class="btn btn-primary" name="submitform">Cancel </button>
                                    </a>
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

</body>

</html>
