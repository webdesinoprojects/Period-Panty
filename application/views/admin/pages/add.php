<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Add Page</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
     <script type="text/javascript">
    function show_preview() {
        var _URL = window.URL || window.webkitURL;
        var file = event.target.files[0];
        var ext = file.name.split('.').pop();

        var allowed_exts = ['jpg', 'jpeg'.'png'];

        if (allowed_exts.indexOf(ext) == -1) {

            alert('invalid image file');
            $('#logo').val('');
            return false;

        }

        var img = new Image();
        img.onload = function() {
            if (this.width > 1000 || this.height > 1000) {
                alert("Height and width can be 1000 * 1000 or less only !");
                $("#logo").val("");
                $('#logo_preview').html("");
                return false;
            } else {
                $('#logo_preview').html("");
                $('#edited_image').css('display', 'none');
                $('#logo_preview').append("<img style='height:auto; width:250px; margin-left:2%;' src='" + this
                    .src + "'/>");
            }
        }
        img.src = _URL.createObjectURL(file);
    }
       </script>
     <script type="text/javascript">
        function show_preview_banner() {
        var _URL = window.URL || window.webkitURL;
        var file = event.target.files[0];
        var ext = file.name.split('.').pop();
        var allowed_exts = ['jpg', 'jpeg'];
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
                        <h1>Add New Page</h1>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="<?php echo base_url('admin/Page/listing'); ?>">All Page</a></li>
                            <li class="active">Add New Page</li>
                        </ol>
                    </section>
                    <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <div class="box box-primary">
                                    <form role="form" method="post" id="form" enctype="multipart/form-data">
                                            <div class="box-body">
                                              <div class="form-group col-sm-12">
                                              <label for="exampleInputEmail1">Title</label>
                                              <input type="text" class="form-control" name="title" onkeyup="return set_slug(this.value);" required placeholder="Enter Title">         
                                              <?php echo form_error('title'); ?>
                                            </div>
                                            <div class="form-group col-sm-12">
                                              <label for="exampleInputEmail1">Url Slug</label>
                                              <input type="text" class="form-control" name="url_key" id="url_slug" readonly >
                                             </div>
                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputEmail1">Image </label>
                                                <input type="file" class="form-control"
                                                    value="<?php echo set_value('image'); ?>" id="logo" name="image"
                                                    onchange="show_preview();" accept="image/png, image/jpeg,image/png,image/JPEG,image/JPG,image/PNG">
                                                <?php echo form_error( 'image'); ?>
                                                <div class="" id="logo_preview"></div>
                                                <p class="error" style="color: red">Note: use image between 300-300 px to 600 *
                                                    600 px width-height</p>
                                            </div>
                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputEmail1">Image Alt*</label>
                                                <input type="text" class="form-control" name="img_tag" id="img_tag"  >
                                                <?php //echo form_error( 'url_slug'); ?>
                                            </div>
                                             <div class="form-group col-sm-12">
                                                <label for="exampleInputEmail1">Banner  </label>
                                                <input type="file" class="form-control"
                                                    value="<?php echo set_value('banner'); ?>" id="banner" name="banner"
                                                    onchange="show_preview_banner();" accept="image/png, image/jpeg,image/png,image/JPEG,image/JPG,image/PNG">
                                                <?php echo form_error( 'banner'); ?>
                                                <div class="" id="banner_preview"></div>
                                                <p class="error" style="color: red">Note: use image 6:2 px width-height</p>
                                            </div>
                                    
                                            <div class="form-group col-sm-12">
                                              <label for="exampleInputEmail1">Description</label>
                                              <textarea class="form-control" name="description" value="" placeholder="Enter description"></textarea>
                                            </div> 
                                            <div class="form-group col-sm-12">
                                              <label for="exampleInputEmail1">Description 2nd part</label>
                                              <textarea class="form-control" name="description_2" value="" placeholder="Enter description"></textarea>
                                            </div>       
                                            <div class="form-group col-sm-12">
                                                <label for="exampleInputEmail1">SEO Title</label>
                                                <input type="text" class="form-control" name="meta_title" value=""  placeholder="Enter SEO Title">
                                                <?php echo form_error('meta_title'); ?>
                                            </div> 
                                            <div class="form-group col-sm-12">
                                                <label for="exampleInputEmail1">SEO canonical</label>
                                                <input type="url" class="form-control" name="canonical" value=""  placeholder="Enter SEO canonical">
                                                <?php echo form_error('canonical'); ?>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="exampleInputEmail1">SEO Keyword</label>
                                                <input type="text" class="form-control" name="meta_keyword"  placeholder="Enter SEO Keywords" value="">
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="exampleInputEmail1">SEO description</label>
                                                <input type="text" class="form-control" name="meta_description"  placeholder="Enter SEO description" value="">
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="exampleInputPassword1">Status</label>
                                                <select class="form-control" name="status" required>
                                                    <option value='1'>Active</option>
                                                    <option value='0'>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary" name="submitform">Add Page</button>
                                            <a href="<?php echo base_url()?>admin/page/listing"> <button type="button" class="btn btn-primary" name="submitform">Cancel </button></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <?php $this->load->view('admin/layout/footer'); ?>
    </div>
    <!-- ./wrapper -->
    <?php $this->load->view('admin/layout/footer_js'); ?>

    <script class="example">
$(document).ready(function(){
  $('#form').parsley();
  
});


function set_slug(VALUE)
{
  //alert(VALUE);
  $("#url_slug").val(string_to_slug(VALUE));
}

function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();  
    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes
    return str;
}
</script>
  <script>
                        CKEDITOR.replace( 'description' );
                        CKEDITOR.replace( 'description_2' );
                    </script>
                       
</body>

</html>