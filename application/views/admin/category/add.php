<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Add New Category || <?php echo $link[0]->title ;  ?></title>
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
                 
                        $('#logo_preview').html("");
                        $('#edited_image').css('display', 'none');
                        $('#logo_preview').append("<img style='height:auto; width:100%; margin-left:2%;' src='" + this
                            .src + "'/>");
                    
                }
                img.src = _URL.createObjectURL(file);
            }
    </script>
    <script type="text/javascript">
    function show_preview_banner() {
        var _URL = window.URL || window.webkitURL;
        var file = event.target.files[0];
        var ext = file.name.split('.').pop();
        var allowed_exts = ['jpg', 'jpeg','JPG', 'JPEG'];
        if (allowed_exts.indexOf(ext) == -1) {
            alert('invalid image file');
            $('#banner').val('');
            return false;
        }
        var img = new Image();
        img.onload = function() {
            if (this.width > 1000 || this.height > 700) {
                alert("Height and width can be 300 * 300 or less only !");
                $("#banner").val("");
                $('#banner_preview').html("");
                return false;
            } else {
                $('#banner_preview').html("");
                $('#edited_image').css('display', 'none');
                $('#banner_preview').append("<img style='height:auto; width:250px; margin-left:2%;' src='" + this
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
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">

            <section class="content-header">
                <h1>Add New Category</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="<?php echo base_url('admin/category/listing'); ?>">All Category</a>
                    </li>
                    <li class="active">All Category</li>
                </ol>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <?php echo $this->session->flashdata('msg'); ?>
                            <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                                <div class="box-body row">
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputPassword1">Parent Category*</label>
                                        <select class="form-control" name="parent_id" required>
                                            <option value='0'>Root</option>
                                            <?php echo $this->category_model->get_all_child_category(0); ?>
                                        </select>
                                        <?php echo form_error( 'parent_id'); ?>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Title *</label>
                                        <input type="text" class="form-control" name="title"
                                            onkeyup="return set_slug(this.value);"
                                            value="<?php echo set_value('title'); ?>" required
                                            placeholder="Enter Title">
                                        <?php echo form_error( 'title'); ?>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Url Slug *</label>
                                        <input type="text" class="form-control" name="url_slug" id="url_slug" readonly
                                            value="<?php echo set_value('url_slug'); ?>" required>
                                        <?php //echo form_error( 'url_slug'); ?>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Image * </label>
                                        <input type="file" class="form-control"
                                            value="<?php echo set_value('image'); ?>" id="logo" name="image" onchange="show_preview();" accept="image/png, image/jpeg,image/png,image/JPEG,image/JPG,image/PNG"> 
                                        <?php echo form_error( 'image'); ?>
                                        <div class="" id="logo_preview"></div>
                                       
                                        <p class="error" style="color: red">Note: Height and width equal to  500px * 500px   </p>
                                    </div>
                                      <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Image Alt*</label>
                                        <input type="text" class="form-control" name="img_tag" id="img_tag" required>
                                       
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Banner * </label>
                                        <input type="file" class="form-control"
                                            value="<?php echo set_value('banner'); ?>" id="banner" name="banner"
                                            onchange="show_preview_banner();" accept="image/png, image/jpeg,image/png,image/JPEG,image/JPG,image/PNG">
                                        <?php echo form_error( 'banner'); ?>
                                        <div class="" id="banner_preview"></div>
                                        <p class="error" style="color: red">Note: Height and width   less than 1500 * 300px and 5:1 ratio  only !   </p>
                                    </div>
                                  

                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description"
                                            placeholder="Enter description"></textarea>
                                    </div>
                               
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title"
                                            value="<?php echo set_value('meta_title'); ?>" required
                                            placeholder="Enter Meta Title">
                                        <?php echo form_error( 'meta_title'); ?>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keyword"
                                            value="<?php echo set_value('meta_keyword'); ?>"
                                            placeholder="Enter Meta Keywords">
                                        <?php echo form_error( 'meta_keyword'); ?>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Meta Description</label>
                                        <input type="text" class="form-control" name="meta_description"
                                            value="<?php echo set_value('meta_description'); ?>"
                                            placeholder="Enter Meta Description">
                                        <?php echo form_error( 'meta_description'); ?>
                                    </div>
                                      <div class="form-group col-sm-12">
                                                <label for="exampleInputEmail1">Meta canonical</label>
                                                <input type="url" class="form-control" name="canonical" value="<?php echo set_value('canonical'); ?>"  placeholder="Enter Meta canonical">
                                                <?php echo form_error('canonical'); ?>
                                            </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputPassword1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value='1'>Active</option>
                                            <option value='0'>Inactive</option>
                                        </select>
                                        <?php echo form_error( 'status'); ?>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputPassword1">Home Display</label>
                                        <select class="form-control" name="home_display" required>
                                            <option value='1'>Yes</option>
                                            <option value='0'>No</option>
                                        </select>
                                        <?php echo form_error( 'home_display'); ?>
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
        </div>
        <?php $this->load->view('admin/layout/footer'); ?>
    </div>
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
  <script>CKEDITOR.replace( 'description' ); </script>
</body>

</html>