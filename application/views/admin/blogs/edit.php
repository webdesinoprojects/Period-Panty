<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit Blog </title>
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
                <h1>Edit Blog </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li><a href="<?php echo base_url('admin/Blogs/listing'); ?>">All Blog </a> </li>
                    <li class="active">Edit Blog </li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" method="post" id="form" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Blogs Category <span>*</span></label>
                                        <?php $get_category=$this->blogs_model->get_all_active_blog_category();?>
                                        <select class="form-control" name="cat_id" required>
                                            <?php if(count($get_category)>0) {?>
                                            <?php foreach($get_category as $cat){?>
                                            <option value="<?php echo  $cat->id; ?>" <?php echo ($RESULT[0]->cat_id == $cat->id)?"Selected":"" ; ?>> <?php echo $cat->title; ?> </option>
                                            <?php }?>
                                            <?php }?> </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Blog Date <span>*</span></label>
                                        <input type="date" class="form-control" name="date" placeholder="Enter Date" value="<?php echo $RESULT[0]->date; ?>" required> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1"> Title<span>*</span> </label>
                                        <input type="text" class="form-control" required name="title" placeholder="Enter title" value="<?php echo @$RESULT[0]->title; ?>" onkeyup="return set_slug(this.value);"> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Url Slug<span>*</span></label>
                                        <input type="text" class="form-control" name="url_slug" id="url_slug" readonly onkeyup="return set_slug(this.value);" value="<?php echo @$RESULT[0]->url_slug; ?>">
                                        <?php echo form_error( 'url_slug'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Image<span>*</span></label>
                                        <input type="file" class="form-control" name="image" id="logo" name="image"  onchange="show_preview();" accept="image/png, image/jpeg,image/JPEG,image/JPG,image/PNG">
                                           <p class="error" style="color: red">Note: Height and width can be less than 2000 * 1125 or greter than 400*225 px and 16:9 ratio  only ! </p>
                                        <div class="" id="logo_preview"></div>
                                        <?php if(!empty($RESULT[0]->image)){ ?><img src="<?php echo base_url('uploads/blogs/').$RESULT[0]->image; ?>"width="100%"> <?php } ?>
                                    </div>
                                     <div class="form-group col-sm-6 ">
                                        <label for="exampleInputEmail1">Blog Image Alt Tag<span>*</span></label>
                                        <input type="text" class="form-control" name="img_tag" placeholder="Enter image tag" value="<?php echo @$RESULT[0]->img_tag; ?>" required>
                                        
                                    </div>
                          
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">ABOUT Blog<span>*</span></label>
                                        <textarea class="form-control" name="description" value="" placeholder="Enter description"><?php echo @$RESULT[0]->description; ?></textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Meta Title<span>*</span></label>
                                        <input type="text" class="form-control" name="meta_title" value="<?php echo @$RESULT[0]->meta_title; ?>" placeholder="Enter Meta Title" required>
                                        <?php echo form_error( 'meta_title'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Meta Keyword<span>*</span></label>
                                        <input type="text" class="form-control" name="meta_keyword" placeholder="Enter meta Keywords" value="<?php echo @$RESULT[0]->meta_keyword; ?>" required>
                                        <?php echo form_error( 'meta_keyword'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Meta description<span>*</span><span>*</span></label>
                                        <input type="text" class="form-control" name="meta_description" placeholder="Enter meta description" value="<?php echo @$RESULT[0]->meta_description; ?>" required>
                                        <?php echo form_error( 'meta_description'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputPassword1">Status<span>*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value='1' <?php echo($RESULT[0]->status==1)?'selected':''; ?>>Active </option>
                                            <option value='0' <?php echo($RESULT[0]->status==0)?'selected':''; ?>> Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="submitform">Update</button>
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
 
        function remove_image(IMG_ID, IMG) {
            var confirm_event = confirm('are you sure you want to delete this image?');
            if (confirm_event == true) {
                $.ajax({
                    url: '<?php echo base_url('admin/Blogs/image_delete'); ?>',
                    type: 'POST',
                    data: {
                        'id': IMG_ID,
                        'image': IMG
                    },
                    success: function(response) {
                        if (response == 1) {
                            $(".pro_img" + IMG_ID).fadeOut(300, function() {
                                $(this).remove();
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
        CKEDITOR.replace('description');

    </script>
</body>

</html>
