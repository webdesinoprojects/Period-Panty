<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $link[0]->title ;  ?>| Add New Slider</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <script src="<?php echo base_url('assets/admin/js/slider-preview.js'); ?>" defer></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        
        <?php $this->load->view('admin/layout/sidebar'); ?>
        
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
                                        <p class="help-block">For Upper hero and Middle feature banners, use | to insert a headline line break. Description, button and image stay editable here. Upload photo-only artwork, without baked-in text.</p>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1"> Slider </label>
                                        <input type="file" class="form-control" name="image"  id="logo" required accept="image/png,image/jpeg">
                                         <div class="" id="logo_preview"></div>
                                         <p class="error" style="color: red">Upper hero: use a full lifestyle photograph, ideally 1860 × 845 px (maximum 2000 × 1100). Keep the subject on the right and space for text on the left. Do not bake text into the image.</p> 
                                         <p class="error" style="color: red">Middle / Footer category images: 600 × 600 px.</p> 
                                    </div> 
                                   
                                  
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="hero_note">Hero right-side tagline (Upper slides)</label>
                                        <textarea id="hero_note" class="form-control" name="hero_note" rows="3"><?php echo html_escape(set_value("hero_note", "Your period.\nYour comfort.\nYour choice.")); ?></textarea>
                                        <p class="help-block">Use a new line or | for each line. Leave empty to hide the tagline. Title, Description, Button Title and Button Link control the other hero text.</p>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Button Title</label>
                                        <input type="text" class="form-control" name="button_title" placeholder="Enter Button Title" value="">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Button Link</label>
                                        <input type="text" class="form-control" name="button_link" placeholder="Enter Button Link" value="">
                                        <p class="help-block">Use a site path such as shop or a complete https:// URL.</p>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Color Code</label>
                                        <input type="color" class="form-control" name="color" placeholder="Enter color" value="">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <!-- Hero card, Upper sliders only. The controller hands the whole
                                             POST array to the model, so a field named after a column saves
                                             itself; no controller change was needed for these two. -->
                                        <label for="card_product_id">Legacy Hero Card Product <small>(not shown in lifestyle hero)</small></label>
                                        <select class="form-control" name="card_product_id">
                                            <option value="">Automatic &mdash; first bestseller</option>
                                            <?php foreach ($this->product_model->get_all_product() as $dx_p) { ?>
                                            <option value="<?php echo $dx_p->id; ?>"><?php echo $dx_p->title; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="card_label">Legacy Hero Card Label</label>
                                        <input type="text" class="form-control" name="card_label" placeholder="e.g. New Collection" value="">
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
