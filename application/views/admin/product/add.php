<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Add New Product</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Add New Product</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="<?php echo base_url('admin/product/listing'); ?>">All Product</a>
                    </li>
                    <li class="active">All Product</li>
                </ol>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <?php echo $this->session->flashdata('msg'); ?>
                            <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                                <div class="box-body row">
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputPassword1">Select Category</label>
                                        <select class="form-control " name="cat_id" required>
                                            <option value=''>Select Category</option>
                                            <?php echo $this->category_model->get_all_child_category(0); ?> </select>
                                        <?php echo form_error( 'cat_id'); ?> 
                                     </div>
                                    <div class="form-group col-sm-6 ">
                                        <label>Color Option</label>
                                        
                                        <?php $color = $this->product_model->get_all_active_color() ;  ?>
                                        <select class="form-control" name="color" required>
                                            <option value="">Select</option>
                                            <?php foreach($color as $value){ ?>
                                            <option value="<?php echo $value->code ; ?>"><?php echo $value->title ; ?></option>
                                            <?php } ?>
                                        </select>
                                               
                                    </div>
                           
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" class="form-control" name="title" onkeyup="return set_slug(this.value);" value="<?php echo set_value('title'); ?>" required placeholder="Enter Title">
                                        <?php echo form_error( 'title'); ?>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Url Slug</label>
                                        <input type="text" class="form-control" name="url_slug" id="url_slug" readonly value="<?php echo set_value('url_slug'); ?>">
                                        <?php echo form_error( 'url_slug'); ?> 
                                    </div>
                                     <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Minmum Order </label>
                                       <input type="number" class="form-control" name="min_order" id="min_order" min="1" value="1" required>
                                        <?php echo form_error( 'min_order'); ?> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Max Order </label>
                                       <input type="number" class="form-control" name="max_order" id="max_order" min="1" value="5" required>
                                        <?php echo form_error( 'max_order'); ?> 
                                    </div>
                                     <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Absorbency Volume </label>
                                       <input type="text" class="form-control" name="absorbency_volume" id="absorbency_volume"  required>
                                        <?php echo form_error( 'absorbency_volume'); ?> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Absorbency Rate </label>
                                        <select class="form-control" name="absorbency_rate" id="absorbency_rate" required>
                                            <option>--Select--</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    
                                    </div>
                                
                                    
                                </div>
                                <div class="box-body row">
                                    <div class="col-sm-12">
                                        <hr>
                                        <h4> Product Variation</h4>
                                    </div> 
                                    <div class="form-group col-sm-12">
                                        <?php $size = $this->product_model->get_all_active_size() ;  ?>
                                        <table class="table table-bordered" id="size_option">
                                            <tr>
                                               
                                                <td>SIZE</td>
                                                <td>SKU</td>
                                                <td>Stock Qty</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>  
                                                        <select class="form-control" name="size[]" required>
                                                        <option value="">Select</option>
                                                         <?php foreach($size as $value){ ?>
                                                        <option value="<?php echo $value->title ; ?>"><?php echo $value->title ; ?></option>
                                                        <?php } ?>
                                                      </select>
                                                </td>
                                                <td><input type="text" class="form-control" name="sku[]"  value="" required placeholder="Enter sku"></td>
                                                <td>
                                                    <input type="number" class="form-control" name="qty[]" id="qty" min="1" value="<?php echo set_value('qty'); ?>">
                                      
                                                </td>
                                                <td></td>
                                            </tr>
                                        </table>
                                        
                                       
                                    </div>
                                    <div class="form-group col-sm-12">
                                      <a type="button" onclick="size_option();" class="btn btn-primary" title="Add Size"><i class="fa fa-plus-circle"></i> Add More Size</a>
                                    </div>
                                    
                                  
                                </div>
                                <div class="box-body row">
                                   
                                    <div class="form-group col-sm-12"> 
                                        <hr>
                                        <h4>
                                            Price Section  
                                        </h4>
                                    </div>
                                     <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1"> Price</label>
                                        <input type="number" class="form-control" name="price"  id="price" value="<?php echo set_value('price'); ?>" required min="0" value="0" step="0.01" >
                                        <?php echo form_error( 'price'); ?>
                                    </div>
                                    
                                     
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1"> Discounted Price</label>
                                        <input type="number" class="form-control" name="special_price" id="special_price" onblur="pricediscount()" value="<?php echo set_value('special_price'); ?>" min="0" value="0" step="0.01" >
                                        <?php echo form_error( 'special_price'); ?> 
                                    </div>
                                    
                                     <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Discount %</label>
                                        <input type="text" class="form-control" name="discount"  id="perdiscount" value="<?php echo set_value('discount'); ?>" readonly>
                                        <?php echo form_error( 'discount'); ?> 
                                    </div>
                                </div>
                                <div class="box-body row">   
                    
                            
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Short Description</label>
                                        <textarea class="form-control" name="short_description" id="short_description" placeholder="Enter short description"></textarea>
                                    </div>
                                   
                                
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">SEO Title</label>
                                        <input type="text" class="form-control" name="meta_title" value="<?php echo set_value('meta_title'); ?>" placeholder="Enter SEO Title">
                                        <?php echo form_error( 'meta_title'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Canonicalisation</label>
                                        <input type="url" class="form-control" name="canonical" value="<?php echo set_value('canonical'); ?>" placeholder="Enter alternate url"> </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">SEO Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" value="<?php echo set_value('meta_keywords'); ?>" placeholder="Enter SEO Keywords"> </div>
                             
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">SEO Description</label>
                                        <input type="text" class="form-control" name="meta_description" value="<?php echo set_value('meta_description'); ?>" placeholder="Enter SEO Description"> </div>
                                    <div class="form-group col-sm-12 box box-success box-solid">
                                        <div class="box-header with-border">Images</div>
                                        <div class="box-body">
                                            <div id="append_image">
                                                <div class="fille_group"><div class="col-md-3"><input type="file" class="form-control" name="image[]" required></div><div class="col-md-3"><input type="text" class="form-control" name="img_tag[]" required placeholder="Alt Tag"></div><div class="col-md-3"><input type="number" class="form-control" name="position[]" required placeholder="Position"></div><div class="col-md-3" style="padding-bottom:5px"><a class="btn btn-danger removedata"><i class="fa fa-fw fa-trash"></i></a></div></div>
                                            </div>
                                            <div class="col-md-2" style="margin-top:10px;"> <a type="button" onclick="addImage();" class="btn btn-primary" title="Add Image"><i class="fa fa-plus-circle"></i> Add Image</a> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body row">
                                   
                                    <div class="form-group col-sm-12"> 
                                        <hr>
                                        <h4>
                                            Filter Section  
                                        </h4>
                                    </div>
                                    <div class="form-group col-sm-3 ">
                                        <label for="exampleInputPassword1"> Featured/Hot ?</label>
                                        <select class="form-control" name="is_featured" required>
                                            <option value="">--Select--</option>
                                            <option value='yes'>Yes</option>
                                            <option value='no'>No</option>
                                        </select>
                                        <?php echo form_error( 'is_featured'); ?> 
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="exampleInputPassword1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value='1'>Active</option>
                                            <option value='0'>Inactive</option>
                                        </select>
                                        <?php echo form_error( 'status'); ?>
                                     </div> 
                                   
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="submitform">Submit</button>
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
    <script>
  
    function pricediscount() {
        var price = parseInt($('#price').val());
        var special_price = parseInt($('#special_price').val());
        var totdis = price - special_price ; 
        var discount = totdis*100/price;
        discount = Math.round(discount);
        $('#perdiscount').val(discount);
    }


</script>
    <script class="example">
        $(document)
            .ready(function() {
                $('#form')
                    .parsley();
                $("form").on('click', '.removedata', function() {
                        $(this).parents(".fille_group").remove();
                });
          
                 $("form").on('click', '.remove_size', function() {
                        $(this).parents("tr").remove();
                });
            });

        function set_slug(VALUE) {
            //alert(VALUE);
            $("#url_slug")
                .val(string_to_slug(VALUE));
        }

        function string_to_slug(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();
            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }
            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes
            return str;
        }
        function addImage() {
            $('#append_image')
                .append('<div class="fille_group"><div class="col-md-3"><input type="file" class="form-control" name="image[]" required></div><div class="col-md-3"><input type="text" class="form-control" name="img_tag[]" required placeholder="Alt Tag"></div><div class="col-md-3"><input type="number" class="form-control" name="position[]" required placeholder="Position"></div><div class="col-md-3" style="padding-bottom:5px"><a class="btn btn-danger removedata"><i class="fa fa-fw fa-trash"></i></a></div></div>');
        }

    </script>
    <script>
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'short_description' );
        CKEDITOR.replace( 'measurement' );
    </script>
     <script>
        function size_option() {
        
            $('#size_option').append('<tr><td><select class="form-control" name="size[]" required><option value="">Select</option><?php foreach($size as $value){ ?><option value="<?php echo $value->title ; ?>"><?php echo $value->title ; ?></option><?php } ?></select></td><td><input type="text" class="form-control" name="sku[]"  value="<?php echo set_value('sku'); ?>" required placeholder="Enter sku"></td><td><input type="number" class="form-control" name="qty[]" id="qty" min="1" value="<?php echo set_value('qty'); ?>"></td><td><a class="btn btn-danger remove_size"><i class="fa fa-fw fa-trash"></i></a></td></tr>');
        }
  
    

    </script>
                       

</body>

</html>
