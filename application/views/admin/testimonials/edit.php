<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit Testimonials</title>
    <?php $this->load->view('admin/layout/head_css'); ?> </head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Edit Testimonials</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="<?php echo base_url('admin/Testimonials/listing'); ?>">All Testimonials</a>
                    </li>
                    <li class="active">Edit Testimonials</li>
                </ol>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $RESULT[0]->name; ?>" required placeholder="Enter Name">
                                            <?php echo form_error( 'name'); ?> </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Country</label>
                                            <input type="text" class="form-control" name="country" value="<?php echo $RESULT[0]->country; ?>" required placeholder="Enter Country">
                                            <?php echo form_error( 'country'); ?> </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">package Name</label>
                                            <input type="text" class="form-control" name="package" value="<?php echo $RESULT[0]->package; ?>" required placeholder="Enter Name"> </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Image</label>
                                            <input type="file" class="form-control" name="image">
                                            <input type="hidden" name="old_file" value="<?php echo $RESULT[0]->image; ?>" id="old_file">
                                            <?php if(!empty($RESULT[0]->image)){ ?> <img src="<?php echo base_url('uploads/testimonials/').$RESULT[0]->image; ?>" width="20%" id="old_img"> <span onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-xs" id="deleteimage" title="Delete Image"><i class="fa fa-fw fa-trash"></i></span>
                                            <?php } ?> </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <input type="text" class="form-control" name="description" value="<?php echo $RESULT[0]->description; ?>" required placeholder="Enter description"> </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Status</label>
                                            <select class="form-control" name="status" required>
                                                <option value='1' <?php echo($RESULT[0]->status==1)?'selected':''; ?>>Active</option>
                                                <option value='0' <?php echo($RESULT[0]->status==0)?'selected':''; ?>>Inactive</option>
                                            </select>
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
            <?php $this->load->view('admin/layout/footer'); ?> </div>
            <!-- ./wrapper -->
            <?php $this->load->view('admin/layout/footer_js'); ?>
            <script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
            <script class="example">
                $(document)
                    .ready(function() {
                        $('#form')
                            .parsley();
                    });

            </script>
            <script type="text/javascript">
                $(document)
                    .ready(function() {
                        $('#deleteimage')
                            .click(function() {
                                $.ajax({
                                    url: "<?php echo base_url('admin/testimonials/deleteimage') ?>",
                                    type: "POST",
                                    data: {
                                        "test_id": <?php echo $RESULT[0]-> id; ?>
                                    },
                                    success: function(response) { //console.log(response);
                                        $('#deleteimage')
                                            .css('display', 'none');
                                        $('#old_img')
                                            .css('display', 'none');
                                        $('#old_file')
                                            .val('');
                                    }
                                });
                                return false;
                            });
                    });

            </script>
</body>

</html>
