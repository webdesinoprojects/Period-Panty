<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> All Coupon</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>"> </head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>All Coupon</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li class="active">All Coupon</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body">
                        <?php echo $this->session->flashdata('msg'); ?>
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#.</th>
                                    <th data-orderable="false">Time</th>
                                    <th data-orderable="false">Criteria</th>
                                    <th data-orderable="false">Title</th>
                                    <th data-orderable="false">CODE</th>
                                    <th data-orderable="false">Discount</th>
                                    <th data-orderable="false">Enable Date</th>
                                    <th data-orderable="false">Disable Date</th>
                                    <th data-orderable="false">Status</th>
                                    <th data-orderable="false">In model ?</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php if(count($RESULT)>0){ ?>
                            <tbody>
                                <?php $CoupoCodeTimes=$this->config->item('CoupoCodeTimes'); $CoupoCodeCriteria = $this->config->item('CoupoCodeCriteria'); ?>
                                <?php $no=0; foreach($RESULT as $record){ $no++; ?>
                                <tr>
                                    <td>
                                        <?php echo $no; ?> </td>
                                    <td>
                                        <?php echo $CoupoCodeTimes[$record->CoupoCodeTimes]; ?>
                                        <?php echo (($record->time == '0')? '' :'-'.$record->time ); ?> </td>
                                    <td>
                                        <?php echo $CoupoCodeCriteria[$record->CoupoCodeCriteria]; ?></td>
                                    <td>
                                        <?php echo $record->title; ?></td>
                                    <td>
                                        <?php echo $record->couponCode; ?></td>
                                    <td>
                                        <?php echo $record->amount; ?>
                                        <?php echo (($record->type == 'Percentage' )? "%" : "Flat" ) ;; ?></td>
                                    <td>
                                        <?php echo date( 'd-m-Y' , strtotime($record->enableDate)); ?></td>
                                    <td>
                                        <?php echo date( 'd-m-Y' , strtotime($record->disableDate)); ?></td>
                                    <td>
                                        <?php if($record->status==1){ ?> <span class="label label-success">Active</span>
                                        <?php }else{ ?> <span class="label label-danger">Inactive</span>
                                        <?php }?> </td>
                                    <td>
                                        <?php if($record->in_model==1){ ?> <span class="label label-success">Yes</span>
                                        <?php }else{ ?> <span class="label label-danger">No</span>
                                        <?php }?> </td>
                                    <td width=""> <a href="<?php echo base_url('admin/coupon/edit/'.$record->id); ?>" class="btn  btn-info btn-xs"><i class="fa fa-fw fa-edit"></i>  &nbsp; Edit</a> </td>
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
    <script type="text/javascript">
        function ViewEnquiry(productId) {
            var productId = productId;
            $.ajax({
                url: "<?php echo base_url("admin/product/getProductDetails/") ?>",
                type: "POST",
                data: {
                    productId: productId
                },
                success: function(output) {
                    $('#EnquiryModel').html(output);
                }
            });
            return false;
        }

    </script>
    <div class="modal fade " tabindex="-1" role="dialog" id="enquiry-modal-lg" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="EnquiryModel"> </div>
            </div>
        </div>
    </div>
</body>

</html>
