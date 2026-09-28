<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $link[0]->title ;  ?> | Edit Slider</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
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
<script type="text/javascript">
  
    function show_preview2()
    {
        var _URL = window.URL || window.webkitURL;
        var file = event.target.files[0];
        var ext = file.name.split('.').pop();

        var allowed_exts = ['jpg','jpeg'];

        if (allowed_exts.indexOf(ext)==-1) {

            alert('invalid image file');
            $('#logo2').val('');
            return false;

        }

        var img = new Image();
        img.onload = function()
        {
           
                $('#logo_preview2').html("");
                $('#edited_image').css('display', 'none');
                $('#logo_preview2').append("<img style='height:auto; width:250px; margin-left:2%;' src='"+this.src+"'/>");
           
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
                <h1>Edit Slider</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="<?php echo base_url('admin/slider/listing'); ?>">All Slider</a>
                    </li>
                    <li class="active">Edit Slider</li>
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
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" class="form-control" name="title"  value="<?php echo $RESULT[0]->title; ?>"  placeholder="Enter Title">
                                        <?php echo form_error( 'title'); ?>
                                    </div>
                                      
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Web Slider</label>
                                        <input type="file" class="form-control" name="image"  id="logo" onchange="show_preview();" accept="image/png, image/jpeg,image/png,image/JPEG,image/JPG,image/PNG">
                                        <input type="hidden" name="old_file" value="<?php echo $RESULT[0]->image; ?>" >

                                         <div class="" id="logo_preview">
                                            <?php if(!empty($RESULT[0]->image)){ ?>
                                        <img src="<?php echo base_url('uploads/slider/').$RESULT[0]->image; ?>" width="100%">
                                        <?php } ?>
                                         </div>
                                           <br>

                                                    <p class="error" style="color: red">Note: use Web Slider image  1920 *1080 px width-height</p> 
                                         <p class="error" style="color: red">Note: use Web category image  600 *600 px width-height</p> 
                                    </div>  
                        
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Enter description"><?php echo $RESULT[0]->description; ?></textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Button Title</label>
                                        <input type="text" class="form-control" name="button_title" placeholder="Enter Button Title" value="<?php echo $RESULT[0]->button_title;?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Button Link</label>
                                        <input type="text" class="form-control" name="button_link" placeholder="Enter Button Link" value="<?php echo $RESULT[0]->button_link;?>">
                                    </div>
                                     <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Color Code</label>
                                        <input type="color" class="form-control" name="color" placeholder="Enter color" value="<?php echo $RESULT[0]->color;?>">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputPassword1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value='1' <?php echo($RESULT[0]->status==1)?'selected':''; ?> >Active</option>
                                            <option value='0' <?php echo($RESULT[0]->status==0)?'selected':''; ?>>Inactive</option>
                                        </select>
                                        <?php echo form_error( 'status'); ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputPassword1">Type</label>
                                        <select class="form-control" name="type" required>
                                            <option <?php echo($RESULT[0]->type=='Upper')?'selected':''; ?> >Upper</option>
                                            <option <?php echo($RESULT[0]->type=='Middle')?'selected':''; ?> >Middle</option>
                                            <option <?php echo($RESULT[0]->type=='Footer')?'selected':''; ?> >Footer</option>
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
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('admin/layout/footer'); ?>
    </div>
    <!-- ./wrapper -->
    <?php $this->load->view('admin/layout/footer_js'); ?>
    <script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
    <script class="example">
        $(document).ready(function() {
            $('#form').parsley();
        });
    </script>
</body>

</html>