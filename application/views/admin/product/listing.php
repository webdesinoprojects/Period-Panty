<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> All Products</title>
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
                <h1>All Products</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">All Products</li>
                </ol>
            </section>
            <div class="box-footer">
                <a href="add_new">
                    <button type="submit" class="btn btn-primary" name="submitform">Add New Product</button>
                </a>
            </div>
            <!-- Main content -->
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
                                    <th style="width:15%">Title</th>
                                    <th data-orderable="false" >Image</th>
                                    <th data-orderable="false">Category</th>
                                    <th data-orderable="false" class="text-center">Stock</th>
                                        <th data-orderable="false" class="text-center">Qty</th>
                                    <th data-orderable="false" >Status</th>
                                    <th data-orderable="false" >Featured</th>
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
                                         <p style="background:<?php echo $record->color; ?> ; width:10px; height:10px"></p>
                                     
                                    </td> 
                                 
                                    <td>
                                        <?php $IMAGES=$this->product_model->select_product_images($record->id); ?>
                                        <?php if(count($IMAGES)) { ?> <img src="<?php echo base_url('uploads/product/'.$IMAGES[0]->image); ?>" alt="Product Image" style="width: 50px">
                                        <?PHP } ?> </td>
                                 
                      
                                    
                                    <td>
                                        <?php $product_cat=$this->category_model->get_category_by_id($record->cat_id); ?>
                                        <?php echo $product_cat[0]->title;?>
                                    </td>
                                       
                                    <td class="text-center">
                                        <?php if($record->qty>0){ ?> <div class="label label-success">In Stock</div>
                                        <?php }else{ ?> <div class="label label-danger">Out of Stock</div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $record->qty; ?></td>
                                  
                                    <td>
                                        <?php if($record->status==1){ ?> <div class="label label-success">Active</div>
                                        <?php }else{ ?> <div class="label label-danger">Inactive</div>
                                        <?php }?> 
                                        
                                    </td>
                                      
                                         <div id="productsaleposmsg<?php echo $record->id ?>"></div>
                                    </td>
                                    <td>
                                        <?php if($record->is_featured=='yes'){ ?> <div class="label label-success">Featured</div>
                                        <?php }else{ ?> <div class="label label-danger">No</div>
                                        <?php }?>
                                    </td>
                                    <td width=""> 
                                        <!--<a type="button" onclick="ViewEnquiry('<?php echo $record->id ?>')" class="Enquiry btn btn-success btn-xs" data-id="<?php echo $record->id ?>" data-toggle="modal" data-target="#enquiry-modal-lg" title="Edit Enquiry"><i class="fa fa-eye" aria-hidden="true"></i>View</a> -->
                                		<a href="<?php echo base_url('admin/product/edit/'.$record->id); ?>" class="btn  btn-info btn-xs"><i class="fa fa-fw fa-edit"></i>  &nbsp; Edit</a> <br>
                                		<a href="<?php echo base_url('admin/product/gallery/'.$record->id); ?>" class="btn  btn-info btn-xs"><i class="fa fa-fw fa-image"></i>  &nbsp; Gallery</a> <br>
                                	
                                		<!--<a href="<?php echo base_url('admin/product/prodelete/'.$record->id); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i>   &nbsp; Delete</a>-->
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

</body>

</html>
