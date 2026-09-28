<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> All Enquiry</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>"> </head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        
        <?php $this->load->view('admin/layout/sidebar'); ?>
        
        <div class="content-wrapper">
            
            <section class="content-header">
                <h1>All Enquiry</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">All Enquiry</li>
                </ol>
            </section>
           
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body table-responsive">
                        <?php echo $this->session->flashdata('msg'); ?>
                        <form class="form-horizontal post" method="post"  enctype="multipart/form-data">
                        <div class="row" >
            		         <div class="col-xs-4  col-sm-2"><button class="btn btn-danger" type="submit" name="submit" onclick="return confirm('Are you sure you want to delete this item  ?');"> Delete</button></div>
            
            		     </div>
            		     <hr>
                        <table id="example1" class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th data-orderable="false"><span ><input type='checkbox' id="checkAll" > </span></th>
                                    <th>SNo.</th>
                                    <th data-orderable="false" >Subject</th>
                                    <th data-orderable="false" > Email</th>
                                    <th data-orderable="false" >Name</th>
                                    <th data-orderable="false" >Mobile</th>
                                    <th data-orderable="false" >Message</th>
                                    <th data-orderable="false" > Date</th>
                                    <th data-orderable="false"></th>
                                </tr>
                            </thead>
                            <?php if(count($RESULT)>0){ ?>
                            <tbody>
                                <?php $no=0; foreach($RESULT as $record){ $no++; ?>
                                <tr>
                                      <td>
            					         <input type='checkbox' value="<?php echo $record->id; ?>" name="mail_id[]"   > 
                        			</td>
                                    <td width="3%">
                                        <?php echo $no; ?>
                                    </td>
                                    <td>
                                        <?php echo $record->subject ?></td> 
                                    <td>
                                        <?php echo $record->email ?></td>
                                    <td>
                                        <?php echo ucwords($record->name) ?></td>
                                    <td>
                                        <?php echo $record->mobile; ?></td> 
                                     
                                    <td>
                                        <?php echo $record->message; ?></td>
                                    <td>
                                        <?php echo date('d/M/Y', strtotime($record->create_date)); ?></td>
                                    <td>
                                        
                                        	<a href="<?php echo base_url('admin/user/delete_mail/'.$record->id); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                    </td>
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
