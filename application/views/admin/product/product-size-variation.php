<!DOCTYPE html>
    <?php $color = $this->product_model->get_all_active_color() ;  ?>
  <?php $size = $this->product_model->get_all_active_size() ;  ?>
  <?php $size_cm = $this->product_model->get_all_active_size_cm() ;  ?>
  <?php $age_group = $this->product_model->get_all_active_age_group() ;  ?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit Product</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <style>
        .users-list>li {
            width: auto;
            position: relative;
        }
        .users-list>li img {
            border-radius: 1%;
            max-width: 100px;
            height: auto;
            border: 3px solid #bfbfbf;
        }
        .users-list-name {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #f4f4f4;
            border-radius: 0px;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Edit Product</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li><a href="<?php echo base_url('admin/product/listing'); ?>">All Product</a> </li>
                    <li class="active">Edit Product</li>
                </ol>
            </section>
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body">
                         <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                            <div class="box box-primary">
                               
                                    <div class="box-body row">
                                             <div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Select Category</label>
                                            <select class="form-control" name="cat_id" id="select_cat" required disabled>
                                                <option value=''>select Category</option>
                                                <?php echo $this->category_model->get_all_child_category(0); ?> </select>
                                            <?php echo form_error( 'cat_id'); ?> </div>
                                            <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Sku</label>
                                        <input type="text" class="form-control" name="sku"  value="<?php echo $RESULT[0]->sku; ?>" required placeholder="Enter sku">
                                        <?php echo form_error( 'sku'); ?>
                                    </div>
                                     
                                         <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">HSN</label>
                                        <input type="text" class="form-control" name="HSN"  value="<?php echo $RESULT[0]->HSN; ?>" required placeholder="Enter HSN">
                                        <?php echo form_error( 'HSN'); ?>
                                    </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Title</label>
                                            <input type="text" class="form-control" name="title"  focus onkeyup="return set_slug(this.value);" value="" required placeholder="Enter Title">
                                            <?php echo form_error( 'title'); ?> </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Url Slug</label>
                                            <input type="text" class="form-control" name="url_slug" id="url_slug" readonly value="">
                                            <?php echo form_error( 'url_slug'); ?> </div>
                                        
                                    </div>
                                     <div class="box-body row">
                                    <div class="col-sm-12">
                                        <hr>
                                        <h4> Product Variation</h4>
                                    </div>    
                                    <div class="form-group col-sm-3 ">
                                        <label>Color Option</label>
                                        <div class="box-body">
                                              <div  class="row fille_group">
                                                <div class="col-md-8">
                                                    <?php $color = $this->product_model->get_all_active_color() ;  ?>
                                                    <select class="form-control" name="color" required>
                                                        <option value="">Select</option>
                                                        <?php foreach($color as $value){ ?>
                                                        <option value="<?php echo $value->code ; ?>" <?php echo($RESULT[0]->color==$value->code)?'selected':''; ?>><?php echo $value->title ; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                               
                                            </div>
                                           
                                        </div>
                                    </div>
                                      <div class="form-group col-sm-3 ">
                                        <label>Age Option </label>
                                        <div class="box-body">
                                              <div  class="row fille_group">
                                                <div class="col-md-8">
                                                   
                                                    <select class="form-control" name="age_group" required>
                                                        <option value="">Select</option>
                                                        <?php foreach($age_group as $value){ ?>
                                                        <option value="<?php echo $value->title ; ?>" ><?php echo $value->title ; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                               
                                            </div>
                                    
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Size Option</label>
                                        <div class="box-body">
                                            <?php $size_array = explode('@',$RESULT[0]->size ) ;  ?>
                                            <?php if(count($size_array)>0){ ?>
                                                <?php foreach($size_array as $key=> $value ){ ?>
                                                    <div  class="row fille_group">
                                                        <div class="col-md-8">
                                                            <input type="text" value="<?php echo $value ; ?>" class="form-control" name="size[]" required>
                                                        </div>
                                                        <div class="col-md-2" style="padding-bottom:5px"><a class="btn btn-danger remove_size"><i class="fa fa-fw fa-trash"></i></a></div><
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            </br>
                                            <div id="size_option"></div> <span class="clearfix"></span>
                                            <div class="col-md-2" style="margin-top:10px;"> <a type="button" onclick="size_option();" class="btn btn-primary" title="Add Size"><i class="fa fa-plus-circle"></i> Add More
                                                    Size</a> </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3 ">
                                        <label>Size In (CM) Option </label>
                                        <div class="box-body">
                                              <?php $size_cm_array = explode('@',$RESULT[0]->size_cm ) ;  ?>
                                            <?php if(count($size_cm_array)>0){ ?>
                                                <?php foreach($size_cm_array as $key=> $value ){ ?>
                                                    <div  class="row fille_group">
                                                        <div class="col-md-8">
                                                            <input type="text" value="<?php echo $value; ?>" class="form-control" name="size_cm[]" required>
                                                        </div>
                                                        <div class="col-md-2" style="padding-bottom:5px"><a class="btn btn-danger remove_size_cm"><i class="fa fa-fw fa-trash"></i></a></div><
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            </br>
                                            <div id="size_cm_option"></div> <span class="clearfix"></span>
                                            <div class="col-md-2" style="margin-top:10px;"> <a type="button" onclick="size_cm_option();" class="btn btn-primary" title="Add Size (cm) "><i class="fa fa-plus-circle"></i> Add More
                                                    Size in CM</a> </div>
                                        </div>
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
                                        <label for="exampleInputEmail1">Packet Price</label>
                                        <input type="number" class="form-control"  name="price" id="price" value="<?php echo $RESULT[0]->price; ?>">
                                        <?php echo form_error( 'price'); ?> 
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Discount %</label>
                                        <input type="number" class="form-control" name="discount" onblur="pricediscount()" id="perdiscount" value="<?php echo $RESULT[0]->discount; ?>">
                                        <?php echo form_error( 'discount'); ?> 
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Packet Special Price</label>
                                        <input type="number" class="form-control" name="special_price" id="special_price" value="<?php echo $RESULT[0]->special_price; ?>">
                                        <?php echo form_error( 'special_price'); ?> 
                                    </div>
                                    
                                </div>
                                <div class="box-body row">        
                                     <div class="form-group col-sm-12"> 
                                        <hr>
                                        <h4>
                                            Stock  Section  
                                        </h4>
                                    </div>
                                   
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Qty</label>
                                        <input type="number" class="form-control" name="qty" id="qty" min="0" value="<?php echo $RESULT[0]->qty; ?>">
                                        <?php echo form_error( 'qty'); ?> </div>

                                      <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Minmum Order Weight</label>
                                       <input type="number" class="form-control" name="min_order" id="min_order" min="1" value="<?php echo $RESULT[0]->min_order; ?>" required>
                                        <?php echo form_error( 'sku'); ?> 
                                        </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Max Order </label>
                                       <input type="number" class="form-control" name="max_order" id="max_order" min="1" value="<?php echo $RESULT[0]->max_order; ?>" required>
                                        <?php echo form_error( 'max_order'); ?> 
                                    </div>
                            
                                            
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Short Description</label>
                                        <textarea class="form-control" name="short_description"  id="short_description" placeholder="Enter short description"><?php echo $RESULT[0]->short_description; ?></textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description" id="description" placeholder="Enter description"><?php echo $RESULT[0]->description; ?></textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Meta Title</label>
                                        <input type="text" class="form-control" required name="meta_title" value="<?php echo $RESULT[0]->meta_title; ?>" placeholder="Enter Meta Title">
                                        <?php echo form_error( 'meta_title'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Canonicalisation</label>
                                        <input type="url" class="form-control" name="canonical" value="<?php echo $RESULT[0]->canonical; ?>" placeholder="Enter alternate url"> </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Meta Keywords</label>
                                        <input type="text" class="form-control" required name="meta_keywords" value="<?php echo $RESULT[0]->meta_keywords; ?>" placeholder="Enter Meta Keywords">
                                        <?php echo form_error( 'meta_keywords'); ?> </div>
                                     <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Tag Keywords</label>
                                        <input type="text" class="form-control" required name="tag" value="<?php echo $RESULT[0]->tag; ?>" placeholder="Enter tag Keywords">
                                        <?php echo form_error( 'tag'); ?> </div>    
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Meta Description</label>
                                        <input type="text" class="form-control" required name="meta_description" value="<?php echo $RESULT[0]->meta_description; ?>" placeholder="Enter Meta Description"> </div>
                                    <div class="form-group col-sm-12 box box-success box-solid">
                                        <div class="box-header with-border">Images</div>
                                        <div class="box-body ">
                                          <div class="fille_group"><div class="col-md-3"><input type="file" class="form-control" name="image[]" required></div><div class="col-md-3"><input type="text" class="form-control" name="img_tag[]" required placeholder="Alt Tag"></div><div class="col-md-3"><input type="number" class="form-control" name="position[]" required placeholder="Position"></div><div class="col-md-3" style="padding-bottom:5px"></div></div>
                                            <div id="append_image"></div> <span class="clearfix"></span>
                                            <div class="row" style="margin-top:10px;"> <a type="button" onclick="addImage();" class="btn btn-primary" title="Add Image"><i class="fa fa-plus-circle"></i> Add Image</a> </div>
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
                                    <div class="form-group col-sm-2 ">
                                        <label for="exampleInputPassword1"> Featured/Hot ?</label>
                                        <select class="form-control" name="is_featured" required>
                                            <option value="">--Select--</option>
                                            <option value='yes' <?php echo($RESULT[0]->is_featured=='yes')?'selected':''; ?> >Yes</option>
                                            <option value='no' <?php echo($RESULT[0]->is_featured=='no')?'selected':''; ?> >No</option>
                                        </select>
                                        <?php echo form_error( 'is_featured'); ?> 
                                    </div>
                                    <div class="form-group col-sm-2 ">
                                        <label for="exampleInputPassword1"> Latest/New ?</label>
                                        <select class="form-control" name="is_latest" required>
                                            <option value="">--Select--</option>
                                            <option value='yes' <?php echo($RESULT[0]->is_latest=='yes')?'selected':''; ?> >Yes</option>
                                            <option value='no' <?php echo($RESULT[0]->is_latest=='no')?'selected':''; ?> >No</option>
                                        </select>
                                        <?php echo form_error( 'is_latest'); ?> 
                                    </div>
                                    <div class="form-group col-sm-2 ">
                                        <label for="exampleInputPassword1">Best Seller ?</label>
                                        <select class="form-control" name="best_seller" required>
                                           <option value="">--Select--</option>
                                            <option value='yes' <?php echo($RESULT[0]->best_seller=='yes')?'selected':''; ?> >Yes</option>
                                            <option value='no' <?php echo($RESULT[0]->best_seller=='no')?'selected':''; ?> >No</option>
                                        </select>
                                        <?php echo form_error( 'best_seller'); ?> 
                                    </div>
                                    <div class="form-group col-sm-2 ">
                                        <label for="exampleInputPassword1">Festival Special ? </label>
                                        <select class="form-control" name="festival_special" required>
                                           <option value="">--Select--</option>
                                            <option value='yes' <?php echo($RESULT[0]->festival_special=='yes')?'selected':''; ?> >Yes</option>
                                            <option value='no' <?php echo($RESULT[0]->festival_special=='no')?'selected':''; ?> >No</option>
                                        </select>
                                        <?php echo form_error( 'festival_special'); ?>
                                    </div> 
                                    <div class="form-group col-sm-2 ">
                                        <label for="exampleInputPassword1">Discounted/Sale  ? </label>
                                        <select class="form-control" name="discounted_products" required>
                                           <option value="">--Select--</option>
                                            <option value='yes' <?php echo($RESULT[0]->discounted_products=='yes')?'selected':''; ?>>Yes</option>
                                            <option value='no' <?php echo($RESULT[0]->discounted_products=='no')?'selected':''; ?>>No</option>
                                        </select>
                                        <?php echo form_error( 'discounted_products'); ?>
                                    </div>
                                      <div class="form-group col-sm-2">
                                        <label for="exampleInputPassword1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value='1' <?php echo($RESULT[0]->status=='1')?'selected':''; ?>>Active</option>
                                            <option value='0' <?php echo($RESULT[0]->status=='0')?'selected':''; ?>>Inactive</option>
                                        </select>
                                        <?php echo form_error( 'status'); ?>
                                     </div>  
                                  
                                   
                                </div>
                               
                            </div>
                        <!-- /.box-body -->
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
    <script>
        $('#select_cat')
            .val('<?php echo $RESULT[0]->cat_id; ?>')
            .change();

    </script>
    <!-- /.content-wrapper -->
    <?php $this->load->view('admin/layout/footer'); ?> </div>
    <!-- ./wrapper -->
    <?php $this->load->view('admin/layout/footer_js'); ?>
    <script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
    <script class="example">
        $(document)
            .ready(function() {
                $('#form').parsley();
                 $("form").on('click', '.removedata', function() {
                        $(this).parents(".fille_group").remove();
                });
                 $("form").on('click', '.remove_color', function() {
                        $(this).parents(".fille_group").remove();
                });
                 $("form").on('click', '.remove_size', function() {
                        $(this).parents(".fille_group").remove();
                });
                 $("form").on('click', '.remove_size_cm', function() {
                        $(this).parents(".fille_group").remove();
                });
                 $("form").on('click', '.remove_age', function() {
                        $(this).parents(".fille_group").remove();
                });
            });

        function set_slug(VALUE) {
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

        function remove_image(IMG_ID, IMG, TYPE) {
            var confirm_event = confirm('are you sure you want to delete this image?');
            if (confirm_event == true) {
                $.ajax({
                    url: '<?php echo base_url('admin/product/image_delete'); ?>',
                    type: 'POST',
                    data: {
                        'id': IMG_ID,
                        'image': IMG
                    },
                    success: function(response) {
                        if (response == 1) {
                            $(".pro_img" + IMG_ID)
                                .fadeOut(300, function() {
                                    $(this)
                                        .remove();
                                });
                        }
                        if (response == 0) {
                            alert('oops somthing wrong!');
                        }
                    }
                });
            }
        }

    </script>
    <script>
        function addImage() {
            $('#append_image')
                .append('<div class="fille_group"><div class="col-md-3"><input type="file" class="form-control" name="image[]" required></div><div class="col-md-3"><input type="text" class="form-control" name="img_tag[]" required placeholder="Alt Tag"></div><div class="col-md-3"><input type="number" class="form-control" name="position[]" required placeholder="Position"></div><div class="col-md-3" style="padding-bottom:5px"><a class="btn btn-danger removedata"><i class="fa fa-fw fa-trash"></i></a></div></div>');
        }
        $(document)
            .ready(function() {
                $(".chosen-control")
                    .chosen();
            });
    </script>
    <script>
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'short_description' );
    </script>
    <script>
  
        function pricediscount() {
            var price = parseInt($('#price').val());
            var discount = parseInt($('#perdiscount') .val());
            var totdis = price * discount / 100;
            var sellprice = price - totdis;
            $('#special_price').val(sellprice);
        }
    
      
    </script>
    <script>
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'short_description' );
    </script>
     <script>
        function addcolor() {
            $('#append_color')
                .append('<div  class="row fille_group"><div class="col-md-5"><select class="form-control" name="color[]" required> <option value="">Select</option><?php foreach($color as $value){ ?><option value="<?php echo $value->title ; ?>"><?php echo $value->title ; ?></option><?php } ?></select></div><div class="col-md-2" style="padding-bottom:5px"><a class="btn btn-danger remove_color"><i class="fa fa-fw fa-trash"></i></a></div></div>');
        }
        function size_option() {
            $('#size_option')
                .append('<div  class="row fille_group"><div class="col-md-8"><select class="form-control" name="size[]" required><option value="">Select</option><?php foreach($size as $value){ ?><option value="<?php echo $value->title ; ?>"><?php echo $value->title ; ?></option><?php } ?></select></div><div class="col-md-3" style="padding-bottom:5px"><a class="btn btn-danger remove_size"><i class="fa fa-fw fa-trash"></i></a></div></div>');
        }
        function size_cm_option() {
            $('#size_cm_option')
                .append('<div  class="row fille_group"><div class="col-md-8"><select class="form-control" name="size_cm[]" required><option value="">Select</option><?php foreach($size_cm as $value){ ?><option value="<?php echo $value->title ; ?>"><?php echo $value->title ; ?></option><?php } ?></select></div><div class="col-md-3" style="padding-bottom:5px"><a class="btn btn-danger remove_size_cm"><i class="fa fa-fw fa-trash"></i></a></div></div>');
        } 
        function age_option() {
            $('#age_option')
                .append('<div  class="row fille_group"><div class="col-md-8"><select class="form-control" name="age_group[]" required><option value="">Select</option><?php foreach($age_group as $value){ ?><option value="<?php echo $value->title ; ?>"><?php echo $value->title ; ?></option><?php } ?></select></div><div class="col-md-3" style="padding-bottom:5px"><a class="btn btn-danger remove_age"><i class="fa fa-fw fa-trash"></i></a></div></div>');
        }
    
    

    </script>
</body>

</html>
