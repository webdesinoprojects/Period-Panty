<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit Setting || <?php echo $link[0]->title ;  ?></title>
    <?php $this->load->view('admin/layout/head_css'); ?>
 </head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Edit Setting</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="<?php echo base_url('admin/slider/listing'); ?>">All Setting</a>
                    </li>
                    <li class="active">Edit Setting</li>
                </ol>
            </section>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                                <div class="box-body row">
                                    <div class="col-sm-4 form-group">
                                        <label for="exampleInputEmail1">Website Header Logo</label>
                                        <input type="file" class="form-control" name="image">
                                        <?php if(!empty($RESULT[0]->logo)){ ?> <img src="<?php echo base_url('uploads/').$RESULT[0]->logo; ?>" width="100px">
                                        <?php } ?>
                                    </div> 
                                    <div class="col-sm-4 form-group">
                                        <label for="exampleInputEmail1">Website Footer Logo</label>
                                        <input type="file" class="form-control" name="footer_logo">
                                        <?php if(!empty($RESULT[0]->footer_logo)){ ?> <img src="<?php echo base_url('uploads/').$RESULT[0]->footer_logo; ?>" width="100px">
                                        <?php } ?>
                                    </div>
                                      <div class="col-sm-4 form-group">
                                        <label for="exampleInputEmail1">Website Favicon</label>
                                        <input type="file" class="form-control" name="favicon">
                                        <?php if(!empty($RESULT[0]->favicon)){ ?> <img src="<?php echo base_url('uploads/').$RESULT[0]->favicon; ?>" width="50px">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="box-body row">
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Company Name</label>
                                        <input type="text" class="form-control" name="company_name" value="<?php echo $RESULT[0]->company_name; ?>" required placeholder="Enter company_name ">
                                        <?php echo form_error( 'company_name'); ?>
                                    </div>   
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Website Name</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $RESULT[0]->title; ?>" required placeholder="Enter Email ">
                                        <?php echo form_error( 'title'); ?>
                                    </div>
                                   
                                     <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">GST</label>
                                        <input type="text" class="form-control" name="gst" value="<?php echo $RESULT[0]->gst; ?>"  placeholder="Enter GST ">
                                        <?php echo form_error( 'gst'); ?>
                                    </div>
                                     <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Whatsapp Number</label>
                                        <input type="text" class="form-control" name="whatapp" value="<?php echo $RESULT[0]->whatapp; ?>"  placeholder="Enter whatapp Number "> </div>
                                     <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">From Email</label>
                                        <input type="text" class="form-control" name="from_email" value="<?php echo $RESULT[0]->from_email; ?>" required placeholder="Enter Email ">
                                        <?php echo form_error( 'title'); ?>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo $RESULT[0]->email; ?>" required placeholder="Enter Email ">
                                        <?php echo form_error( 'title'); ?>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" class="form-control" name="phone" value="<?php echo $RESULT[0]->phone; ?>"  placeholder="Enter Phone "> </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" class="form-control" name="phone2" value="<?php echo $RESULT[0]->phone2; ?>"  placeholder="Enter Alt Phone "> </div> 
                                    
                                        
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Registered Address Content</label>
                                        <textarea class="form-control" name="address_content"><?php echo $RESULT[0]->address_content; ?></textarea>
                                     </div> 
                                     <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Invoice  Address Content</label>
                                         <textarea class="form-control" name="invoice_address"><?php echo $RESULT[0]->invoice_address; ?></textarea>
                                     </div>
                                        
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Facebook Link</label>
                                        <input type="text" class="form-control" name="facebook_link" value="<?php echo $RESULT[0]->facebook_link; ?>"  placeholder="Enter Facebook Link"> </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Twitter Link</label>
                                        <input type="text" class="form-control" name="twitter_link" value="<?php echo $RESULT[0]->twitter_link; ?>"  placeholder="Enter Twitter Link"> </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Instagram Link</label>
                                        <input type="text" class="form-control" name="instagram_link" value="<?php echo $RESULT[0]->instagram_link; ?>"  placeholder="Enter Instagram Link"> </div>
                                   
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Youtube Link</label>
                                        <input type="text" class="form-control" name="youtube_link" value="<?php echo $RESULT[0]->youtube_link; ?>"  placeholder="Enter Youtube Link "> </div>
                                   
                                    <div class="col-sm-12 form-group">
                                        <label for="exampleInputEmail1">About The Brand</label>
                                        <input type="text" class="form-control" name="about_content" value="<?php echo $RESULT[0]->about_content; ?>"  placeholder="Enter  Content "> </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="exampleInputEmail1">Copyright</label>
                                        <input type="text" class="form-control" name="copyright" value="<?php echo $RESULT[0]->copyright; ?>" required placeholder="Enter Copyright "> </div>
                                        
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">COD Shipping Title</label>
                                        <input type="text" class="form-control" name="cod_shipping_title" value="<?php echo $RESULT[0]->cod_shipping_title; ?>" required placeholder="Enter COD Shipping Title "> </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Copyright</label>
                                        <input type="number" class="form-control" name="cod_shipping_charges" value="<?php echo $RESULT[0]->cod_shipping_charges; ?>" required placeholder="Enter Copyright "> </div>
                                        
                                      <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Payment Online Discount Title</label>
                                        <input type="text" class="form-control" name="online_discount_title" value="<?php echo $RESULT[0]->online_discount_title; ?>" required placeholder="Payment Online Discount Title"> </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="exampleInputEmail1">Payment Online Discount</label>
                                        <input type="number" class="form-control" name="online_discount" value="<?php echo $RESULT[0]->online_discount; ?>" required placeholder="Enter Payment Online Discount "> </div>
                                </div>
                                
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
</body>

</html>
