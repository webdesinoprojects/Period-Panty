<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Blog Category</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>"> </head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>All Blog Category</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">All Blog Category</li>
                </ol>
            </section>
            <div class="box-footer">
                <a href="add_new">
                    <button type="submit" class="btn btn-primary" name="submitform">Add New Blog Category</button>
                </a>
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
                                    <th data-orderable="false">Blog Category</th>
                                    <th data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <?php if(count($RESULT)>0){ ?>
                            <tbody>
                                <?php $no=0; foreach($RESULT as $record){ $no++; ?>
                                <tr>
                                    <td width="7%">
                                        <?php echo $no; ?>
                                    </td>
                                    <td>
                                        <?php echo $record->title; ?></td>
                                    <td width="15%"> <a href="<?php echo base_url('admin/blog_category/edit/'.$record->id); ?>" class="btn  btn-success btn-xs"><i class="fa fa-fw fa-edit"></i>Edit</a> </td>
                                </tr>
                                <?php } ?> </tbody>
                            <?php } ?> </table>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('admin/layout/footer'); ?> </div>
    <!-- ./wrapper -->
    <?php $this->load->view('admin/layout/footer_js'); ?>
  <?php $this->load->view('admin/layout/data-table-js'); ?>
</body>

</html>
