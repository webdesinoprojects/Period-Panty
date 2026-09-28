<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $link[0]->title ;  ?>| Add New Slider</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <script type="text/javascript">
          
            function show_preview()
            {
                var _URL = window.URL || window.webkitURL;
                var file = event.target.files[0];
                var ext = file.name.split('.').pop();

                var allowed_exts = ['jpg','jpeg'];

                if (allowed_exts.indexOf(ext)==-1) {

                    alert('invalid image file');
                    $('#logo').val('');
                    return false;

                }

                var img = new Image();
                img.onload = function()
                {
                   
                        $('#logo_preview').html("");
                        $('#edited_image').css('display', 'none');
                        $('#logo_preview').append("<img style='height:auto; width:250px; margin-left:2%;' src='"+this.src+"'/>");
                    }
                }
                img.src = _URL.createObjectURL(file);
            }
        </script>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Add New Slider</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="<?php echo base_url('admin/slider/listing'); ?>">All Slider</a>
                    </li>
                    <li class="active">All Slider</li>
                </ol>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <?php echo $this->session->flashdata('msg'); ?>
                            <!-- form start -->
                            <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                                <div class="box-body row">
                         
                                     <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo set_value('title'); ?>" required placeholder="Enter Title">
                                        <?php echo form_error( 'title'); ?>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1"> Slider </label>
                                        <input type="file" class="form-control" name="image"  id="logo" required accept="image/png, image/jpeg,image/png,image/JPEG,image/JPG,image/PNG">
                                         <div class="" id="logo_preview"></div>
                                         <p class="error" style="color: red">Note: use Web Slider image  1920 *1080 px width-height</p> 
                                         <p class="error" style="color: red">Note: use Web category image  600 *600 px width-height</p> 
                                    </div> 
                                   
                                  
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Button Title</label>
                                        <input type="text" class="form-control" name="button_title" placeholder="Enter Button Title" value="">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Button Link</label>
                                        <input type="text" class="form-control" name="button_link" placeholder="Enter Button Link" value="">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Color Code</label>
                                        <input type="color" class="form-control" name="color" placeholder="Enter color" value="">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputPassword1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value='1'>Active</option>
                                            <option value='0'>Inactive</option>
                                        </select>
                                        <?php echo form_error( 'status'); ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputPassword1">Type</label>
                                        <select class="form-control" name="type" required>
                                            <option >Upper</option>
                                            <option >Middle</option>
                                            <option >Footer</option>
                                        </select>
                                        <?php echo form_error( 'type'); ?>
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
        </div>
        <?php $this->load->view('admin/layout/footer'); ?>
    </div>
    <?php $this->load->view('admin/layout/footer_js'); ?>
    <script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
    <script class="example">
        $(document).ready(function() {
            $('#form').parsley();
        });
    </script>
</body>

</html>