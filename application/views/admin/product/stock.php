<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> All Stock</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>"> 
    <style>
        .label {
    display: block;
    padding: 0.2em 0.6em 0.3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25em;
    /* width: 183px; */
}
    </style>
    </head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>All Stock</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">All Stock</li>
                </ol>
            </section>
         
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body table-responsive">
                        <?php echo $this->session->flashdata('msg'); ?>
                        <p id="error" style="color:red"></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#.</th>
                                    <th>Variation Code</th>
                                    <th>SKU</th>
                       
                                    <th style="width:15%">Title</th>
                                    <th data-orderable="false" >Image</th>
                                    <th data-orderable="false">Size</th>
                                    <th data-orderable="false">Category</th>
                                    <th data-orderable="false" >Stock</th>
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
                                        <?php echo @$record->product_code; ?>
                                       
                                    </td>
                                   <td>
                                        <?php echo $record->varrysku; ?>
                                       
                                    </td>
                                  
                                    <td>
                                        <?php echo $record->title; ?>
                                          <p style="background:<?php echo $record->color; ?> ; width:10px; height:10px"></p>
                                     
                                    </td> 
                                    <td>
                                        <?php $IMAGES=$this->product_model->select_product_images($record->productID); ?>
                                        <?php if(count($IMAGES)) { ?> <img src="<?php echo base_url('uploads/product/'.$IMAGES[0]->image); ?>" alt="Product Image" style="width: 50px">
                                        <?PHP } ?> </td>
                                 
                                    <td>
                                       <p><?php echo $record->varrysize; ?></p>
                                    </td>
                                    
                                    <td>
                                       
                                        <?php echo $record->cat_title;?>
                                    </td>
                                       
                                    <td>
                                  
                                        <?php echo $record->varryqty; ?>
                                    </td>
                                  
                                    <td>
                                        <?php if($record->status==1){ ?> <div class="label label-success">Active</div>
                                        <?php }else{ ?> <div class="label label-danger">Inactive</div>
                                        <?php }?> 
                                        
                                    </td>
                                    
                                    <td width=""> 
                                        <a type="button" onclick="ViewEnquiry('<?php echo $record->id ?>')" class="Enquiry btn btn-success btn-xs" data-id="<?php echo $record->id ?>" data-toggle="modal" data-target="#enquiry-modal-lg" title="Edit Enquiry"><i class="fa fa-eye
                                		" aria-hidden="true"></i>Stock</a> 
                                		
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
                url: "<?php echo base_url("admin/product/getProductStock/") ?>",
                type: "POST",
                data: {
                    productId: productId
                },
                success: function(output) {
                    $('#EnquiryModel')
                        .html(output);
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

       <script>
  
    function pricediscount() {
        var price = parseInt($('#price').val());
        var discount = parseInt($('#perdiscount') .val());
        var totdis = price * discount / 100;
        var sellprice = price - totdis;
        $('#special_price').val(sellprice);
    }

    function priceperdiscount() {
        var per_kg_price = parseInt($('#per_kg_price').val());
        var perdiscount = parseInt($('#perdiscount').val());
        var etotdis = per_kg_price * perdiscount / 100;
        var esellprice = per_kg_price - etotdis;
        $('#per_kg_special_price') .val(esellprice);
    }

</script>
<script type="text/javascript">
    $(document)
        .ready(function() {
            $("#example1")
                .on("click", ".submitsaleposition", function() {
                    var product_id = $(this).attr('data-id');
                    var button = $(this);
                    $(button).html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i>');
                    var position = $('#productsalepos' + product_id).val();
                    $.ajax({
                        url: "<?php echo base_url('admin/product/updatesaleposition') ?>",
                        type: "POST",
                        data: {
                            product_id: product_id,
                            position: position
                        },
                        success: function(output) {
                            $(button).html('<i class="fa fa-refresh " aria-hidden="true"></i>');
                            $('#productsaleposmsg' + product_id).html(output);
                           
                        }
                    });
                });
            $("#example1")
                .on("click", ".submitfeaposition", function() {
                    var product_id = $(this).attr('data-id');
                    var button = $(this);
                    $(button).html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i>');
                    var position = $('#productfeaposition' + product_id).val();
                    $.ajax({
                        url: "<?php echo base_url('admin/product/updatefeaposition') ?>",
                        type: "POST",
                        data: {
                            product_id: product_id,
                            position: position
                        },
                        success: function(output) {
                            $(button).html('<i class="fa fa-refresh " aria-hidden="true"></i>');
                             $('#productfeapositionmsg' + product_id).html(output);
                         
                        }
                    });
                });
            $("#example1")
                .on("click", ".submitlatposition", function() {
                    var product_id = $(this).attr('data-id');
                    var button = $(this);
                    $(button).html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i>'); 
                    var position = $('#productlatposition' + product_id).val();
                    $.ajax({
                        url: "<?php echo base_url('admin/product/updatelatposition') ?>",
                        type: "POST",
                        data: {
                            product_id: product_id,
                             position: position
                        },
                        success: function(output) {
                            $(button).html('<i class="fa fa-refresh " aria-hidden="true"></i>');
                            $('#productlatpositionmsg' + product_id).html(output);
                        }
                    });
                });
        });

</script>
</body>

</html>
