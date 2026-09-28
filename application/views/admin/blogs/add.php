<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Add Blogs</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
      <script type="text/javascript">
    function show_preview() {
        var _URL = window.URL || window.webkitURL;
        var file = event.target.files[0];
        var ext = file.name.split('.').pop();
        var allowed_exts = ['jpg', 'jpeg','JPG', 'JPEG','PNG', 'png'];
        if (allowed_exts.indexOf(ext) == -1) {
            alert('invalid image file');
            $('#logo').val('');
            return false;
        }
        var img = new Image();
        img.onload = function() {
            if (this.width > 2000 || this.height > 1125) {
                alert("Height and width can be less than 2000 * 1125  and 16:9 ratio  only ! ");
                $("#logo").val("");
                $('#logo_preview').html("");
                return false;
            }else if (this.width < 400 || this.height < 225) {
                alert("Height and width can be  greter than 400*225 px and 16:9 ratio  only ! ");
                $("#logo").val("");
                $('#logo_preview').html("");
                return false;
            }
            else {
                $('#logo_preview').html("");
                $('#edited_image').css('display', 'none');
                $('#logo_preview').append("<img style='height:auto; width:100%; margin-left:2%;' src='" + this
                    .src + "'/>");
            }
        }
        img.src = _URL.createObjectURL(file);
    }
    </script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Add New Blogs</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li><a href="<?php echo base_url('admin/Blogs/listing'); ?>">All Blogs</a> </li>
                    <li class="active">Add New Blogs</li>
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
                                <div class="box-body row">
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Blogs Category<span>*</span></label>
                                        <?php $get_category=$this->blogs_model->get_all_active_blog_category();?>
                                        <select class="form-control" name="cat_id" required>
                                            <?php if(count($get_category)>0) {?>
                                            <?php foreach($get_category as $cat){?>
                                            <option value="<?php echo  $cat->id; ?>">
                                                <?php echo $cat->title; ?></option>
                                            <?php }?>
                                            <?php }?> </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Blog Date<span>*</span></label>
                                        <input type="date" class="form-control" name="date" required placeholder="Enter image tag" value="" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Title <span>*</span></label>
                                        <input type="text" class="form-control" name="title" required onkeyup="return set_slug(this.value);" placeholder="Enter title" value="<?php echo set_value('title'); ?>"> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Url Slug<span>*</span></label>
                                        <input type="text" class="form-control" name="url_slug" required id="url_slug" readonly value="<?php echo set_value('url_slug'); ?>">
                                        <?php echo form_error( 'url_slug'); ?> </div>
                                    
                           
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Image * </label>
                                        <input type="file" class="form-control" required value="<?php echo set_value('image'); ?>" id="logo" name="image" onchange="show_preview();" accept="image/png, image/jpeg,image/JPEG,image/JPG,image/PNG"> 
                                        <?php echo form_error( 'image'); ?>
                                        <div class="" id="logo_preview"></div>
                                        <p class="error" style="color: red">Note: Height and width can be less than 2000 * 1125 or greter than 400*225 px and 16:9 ratio  only !   </p>
                                    </div>
                                    <div class="form-group col-sm-6 ">
                                        <label for="exampleInputEmail1">Blog Image Alt Tag<span>*</span></label>
                                        <input type="text" class="form-control" required name="img_tag" placeholder="Enter image tag" value=""> 
                                    </div>
                                    <div class="form-group col-sm-12 ">
                                        <label for="exampleInputEmail1">ABOUT Blogs <span>*</span></label>
                                        <textarea class="form-control" name="description" required value="" placeholder="Enter description"></textarea>
                                    </div>
                                    <div class="form-group col-sm-6 ">
                                        <label for="exampleInputEmail1">Meta Title<span>*</span></label>
                                        <input type="text" class="form-control" name="meta_title"  required value="<?php echo @$RESULT[0]->meta_title; ?>" placeholder="Enter Meta Title">
                                        <?php echo form_error( 'meta_title'); ?> </div>
                                    <div class="form-group col-sm-6 ">
                                        <label for="exampleInputEmail1">Meta Keyword<span>*</span></label>
                                        <input type="text" class="form-control" name="meta_keyword" required  placeholder="Enter meta Keywords" value="<?php echo @$RESULT[0]->meta_keyword; ?>">
                                        <?php echo form_error( 'meta_keyword'); ?> </div>
                                    <div class="form-group col-sm-6 ">
                                        <label for="exampleInputEmail1">Meta description<span>*</span></label>
                                        <input type="text" class="form-control" name="meta_description" required placeholder="Enter meta description" value="<?php echo @$RESULT[0]->meta_description; ?>">
                                        <?php echo form_error( 'meta_description'); ?> </div>
                                    <div class="form-group col-sm-6 ">
                                            <label for="exampleInputPassword1">Status<span>*</span></label>
                                            <select class="form-control" name="status" required>
                                                <option value='1'>Active</option>
                                                <option value='0'>Inactive</option>
                                            </select>
                                        </div>
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
        <script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
        <script class="example">
            $(document).ready(function() {
                $('#form').parsley();
            });

            function set_slug(VALUE) {
                //alert(VALUE);
                $("#url_slug").val(string_to_slug(VALUE));
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

        </script>
        <script>
            function addImage() {
                $('#append_image').append('<div class="fille_group"><div class="col-md-4"><input type="tag" class="form-control" name="tag[]" required></div><div class="col-md-4"><input type="file" class="form-control" name="image[]" required></div><div class="col-md-4" style="padding-bottom:5px"><a class="btn btn-danger removedata"><i class="fa fa-fw fa-trash"></i></a></div></div>');
            }
            $(document).ready(function() {
                $(".chosen-control").chosen();
            });

        </script>

        <script>
            CKEDITOR.replace('description');

        </script>
</body>

</html>
