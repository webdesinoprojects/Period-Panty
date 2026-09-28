<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>  Product Gallery</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <style>
        .users-list>div {
            width: auto;
            position: relative;
        }
        .users-list .row {
          border: 1px solid #d3d3d3;
    margin-bottom: 12px;
    padding: 10px;
        }
        .users-list>div img {
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
                <h1> Product Gallery</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li><a href="<?php echo base_url('admin/product/listing'); ?>">All Product</a> </li>
                    <li><a href="<?php echo base_url('admin/product/edit/'.$RESULT[0]->id); ?>">Edit Product</a> </li>
                    <li class="active"> Product Gallery</li>
                </ol>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                         <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                            <div class="box box-primary">
                                <h3><?php echo $RESULT[0]->title; ?></h3>
                                <div class="box-body row">        
                                    
                                    <div class="form-group col-sm-12 box box-success box-solid">
                                        <div class="box-header with-border">Images</div>
                                        <div class="box-body ">
                                            <?php if(count($IMAGES)>0){ ?>
                                            <div class="users-list ">
                                                <?php foreach($IMAGES as$key=> $image): ?>
                                                <div class="row pro_img<?php echo $image->id; ?>" > 
                                                    <div class="col-sm-3"> <img src="<?php echo base_url('uploads/product/'.$image->image); ?>" alt="Product Image" style="width
                                                    :50px"> </div>
                                                    <div class="col-sm-3"><?php echo $image->img_tag ?></div>
                                                    <div class="col-sm-3"><?php echo $image->position ?></div>
                                                    <div class="col-sm-3">
                                                          <a type="button" onclick="ViewImage('<?php echo $image->id ?>')" class="Enquiry btn btn-success btn-xs" data-id="<?php echo $image->id ?>" data-toggle="modal" data-target="#enquiry-modal-lg" title="Edit Image"><i class="fa fa-eye
                                                    		" aria-hidden="true"></i>View</a>
                                                    		<a class="users-list-name btn btn-danger btn-xs" onclick="return remove_image('<?php echo $image->id; ?>','<?php echo $image->image; ?>')"><i class="fa fa-fw fa-trash-o"></i></a></div>
                                               
                                                </div>
                                                <?php endforeach; ?> 
                                            </div>
                                            <?php } ?>
                                            <div id="append_image"></div> <span class="clearfix"></span>
                                            <div class="col-md-2" style="margin-top:10px;"> <a type="button" onclick="addImage();" class="btn btn-primary" title="Add Image"><i class="fa fa-plus-circle"></i> Add Image</a> </div>
                                        </div>
                                    </div>
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
                $('#form')
                    .parsley();
                $("form").on('click', '.removedata', function() {
                        $(this).parents(".fille_group").remove();
                });
          
                 $("form").on('click', '.remove_size', function() {
                        $(this).parents("tr").remove();
                });
            });


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
                .append('<span class="fille_group"><div class="col-md-3"><input type="file" class="form-control" name="image[]" required></div><div class="col-md-3"><input type="text" class="form-control" name="img_tag[]" required placeholder="Alt Tag"></div><div class="col-md-3"><input type="number" class="form-control" name="position[]" required placeholder="Position"></div><div class="col-md-3" style="padding-bottom:5px"><a class="btn btn-danger removedata"><i class="fa fa-fw fa-trash"></i></a></div><span>');
        }
        $(document)
            .ready(function() {
                $(".chosen-control")
                    .chosen();
            });
    </script>
    
      <script type="text/javascript">
        function ViewImage(ImageID) {
            var ImageID = ImageID;
            $.ajax({
                url: "<?php echo base_url("admin/product/getImageDetails/") ?>",
                type: "POST",
                data: {
                    ImageID: ImageID
                },
                success: function(output) {
                    $('#ImageModel')
                        .html(output);
                }
            });
            return false;
        }

    </script>
    <div class="modal fade " tabindex="-1" role="dialog" id="enquiry-modal-lg" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-body" id="ImageModel"> </div>
            </div>
        </div>
    </div>

</body>

</html>
