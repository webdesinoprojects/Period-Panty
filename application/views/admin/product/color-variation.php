<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> All Color Variation</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>"> </head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>All Color Variation</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">All Color Variation</li>
                </ol>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <form role="form" method="post" id="form" enctype="multipart/form-data">
                            <div class=" row">
                                <div class="form-group col-sm-3">
                                  <label for="exampleInputEmail1">Title</label>
                                  <input type="text" class="form-control" name="title"  required placeholder="Enter Title">         
                                  <?php echo form_error('title'); ?>
                                </div>
                                <div class="form-group col-sm-3">
                                  <label for="exampleInputEmail1">Code</label>
                                  <input type="text" class="form-control" name="code"  required placeholder="Enter code">         
                                  <?php echo form_error('code'); ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="exampleInputPassword1">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value='1'>Active</option>
                                        <option value='0'>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                 <bR>
                                     <button type="submit" class="btn btn-primary" name="add_color">Add Color</button>
                                </div>
                            </div>
                        </form>
                        <hr>      
                        <?php echo $this->session->flashdata('msg'); ?>
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#.</th>
                                    <th data-orderable="false" >Title</th>
                                    <th data-orderable="false" >Color</th>
                                    <th data-orderable="false" >Status</th>
                                    <th data-orderable="false" >Action</th>
                                </tr>
                            </thead>
                            <?php if(count($RESULT)>0){ ?>
                            <tbody>
                                <?php $no=0; foreach($RESULT as $record){ $no++; ?>
                                <tr>
                                    <td>
                                        <?php echo $no; ?>
                                    </td>
                                    <td>
                                        <?php echo $record->title; ?>
                                       
                                    </td>  
                                    <td>
                                         <p style="border:1px solid #000 ; background:<?php echo $record->code; ?> ; width:10px; height:10px"></p>
                                       
                                    </td>
                                   
                                    <td>
                                        <?php if($record->status==1){ ?> <span class="label label-success">Active</span>
                                        <?php }else{ ?> <span class="label label-danger">Inactive</span>
                                        <?php }?> 
                                    </td>
                             
                                    <td width=""> 
                                    
                                		<a href="<?php echo base_url('admin/product/color_delete/'.$record->id); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i>   &nbsp; Delete</a> </td>
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
