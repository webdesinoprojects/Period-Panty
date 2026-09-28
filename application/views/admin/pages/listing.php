<?php $link=$this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Listing</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>All Page</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">All Page</li>
                </ol>
            </section>
            <div class="box-footer">
                <a href="<?php echo base_url()?>admin/Page/add_new">
                    <button type="button" class="btn btn-primary" name="submitform">Add Page </button>
                </a>
            </div>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <?php echo $this->session->flashdata('msg'); ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SNo.</th>
                                    <th  data-orderable="false" >Page Title</th>
                                    <th  data-orderable="false" >Status</th>
                                    <th  data-orderable="false" >Action</th>
                                </tr>
                            </thead>
                            <?php if(count($result)>0){ ?>
                            <tbody>
                                <?php $no=0; foreach($result as $record){ $no++; ?>
                                <tr>
                                    <td width="7%">
                                        <?php echo $no; ?>
                                    </td>
                                    <td>
                                        <?php echo $record->title; ?></td>
                                    <td width="15%">
                                        <?php if($record->status==1){ ?> <span class="label label-success">Active</span>
                                        <?php }else{ ?> <span class="label label-danger">Inactive</span>
                                        <?php }?> </td>
                                    <td width="15%"> <a href="<?php echo base_url('admin/Page/edit/'.$record->id); ?>" class="btn  btn-success btn-xs"><i class="fa fa-fw fa-edit"></i>Edit</a> </td>
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
