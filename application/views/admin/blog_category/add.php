<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Add Blog Category</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <?php $this->load->view('admin/layout/tiny-mce'); ?> </head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Add New Blog category</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li><a href="<?php echo base_url('admin/Blogs/listing'); ?>">All Blogs</a>
                    </li>
                    <li class="active">Add New Blog Category</li>
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
                                        <label for="exampleInputEmail1">Blogs Name</label>
                                        <input type="text" class="form-control" name="title" placeholder="Enter Title" value="<?php echo set_value('title'); ?>" onkeyup="return set_slug(this.value);" required=""> </div>
                                    <?php echo form_error( 'name'); ?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Url Slug</label>
                                        <input type="text" class="form-control" name="url_slug" id="url_slug" readonly value="<?php echo set_value('url_slug'); ?>">
                                        <?php echo form_error( 'url_slug'); ?> </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="submitform">Add </button>
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
