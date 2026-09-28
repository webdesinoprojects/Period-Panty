<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit coupon</title>
    <?php $this->load->view('admin/layout/head_css'); ?>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
     <script type="text/javascript">
          
            function show_preview()
            {
                var _URL = window.URL || window.webkitURL;
                var file = event.target.files[0];
                var ext = file.name.split('.').pop();

                 var allowed_exts = ['jpg','jpeg','png'];

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
  
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>
        <?php $this->load->view('admin/layout/sidebar'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Edit coupon</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a> </li>
                    <li><a href="<?php echo base_url('admin/coupon/listing'); ?>">All coupon</a> </li>
                    <li class="active">Edit coupon</li>
                </ol>
            </section>
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data">
                                  <div class="box-body row">
                                    <?php
                                    $CoupoCodeTimes = $this->config->item('CoupoCodeTimes');
                                    $CoupoCodeCriteria = $this->config->item('CoupoCodeCriteria'); ?>
                                    <div class="form-group col-sm-6 ">
                                        <label for="exampleInputPassword1">Coupon Code Times</label>
                                        <select class="form-control" name="CoupoCodeTimes" id="CoupoCodeTimes" required>
                                            <option>---Select---</option>
                                            <?php foreach($CoupoCodeTimes as $key =>$value){?>
                                            <option value='<?php echo $key ;?>'   <?php echo($RESULT[0]->CoupoCodeTimes==$key)?'selected':''; ?>><?php echo $value ;?></option>
                                           <?php } ?>
                                        </select>
                                        <?php echo form_error( 'CoupoCodeTimes'); ?> 
                                       
                                    </div>
                                    <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">No Of Time</label>
                                            <input type="number" class="form-control" value=""  name="time" value="<?php echo $RESULT[0]->time; ?>"  <?php echo($RESULT[0]->CoupoCodeTimes==3)?'':'disabled'; ?>  id="time" placeholder="Enter Time">
                                            <?php echo form_error( 'time'); ?> 
                                    </div>
                                </div>   
                                <div class="box-body row">
                                    <div class="form-group col-sm-6 ">
                                        <label for="exampleInputPassword1">Coupon Code Criteria</label>
                                        <select class="form-control" name="CoupoCodeCriteria" id="CoupoCodeCriteria" required>
                                            
                                            <option>---Select---</option>
                                            <?php foreach($CoupoCodeCriteria as $key =>$value){?>
                                            <option value='<?php echo $key ;?>'   <?php echo($RESULT[0]->CoupoCodeCriteria==$key)?'selected':''; ?>><?php echo $value ;?></option>
                                           <?php } ?>
                                        </select>
                                        <?php echo form_error( 'CoupoCodeCriteria'); ?>
                                        
                                    </div>
                                    <div class="form-group col-sm-6" id="order_value_div" style="display:<?php echo($RESULT[0]->CoupoCodeCriteria==2)?'block':'none'; ?>">
                                            <label for="exampleInputEmail1">On Order Value</label>
                                            <input type="number" class="form-control" value="" id="order_value"  name="order_value" value="<?php echo set_value('order_value'); ?>" placeholder="Enter order_value">
                                            <?php echo form_error( 'order_value'); ?> 
                                    </div>
                                    <div class="form-group col-sm-6 " id="category" style="display:<?php echo($RESULT[0]->CoupoCodeCriteria==3)?'block':'none'; ?>">
                                        <label for="exampleInputEmail1">Category </label>
                                        </br>
                                        <?php $categoryArray = explode('@',$RESULT[0]->category_refid) ; ?>
                                        <?php foreach ($category as $key=> $value) { ?>
                                        <label class="checkbox-inline category" >
                                            <input type="checkbox"  name="category_refid[]" <?php echo(in_array($value->id,$categoryArray))?'checked':''; ?> value="<?php echo $value->id ?>"><?php echo $value->title ?>
                                        </label>
                                        <?php } ?>
                                    </div>
                               </div>   
                                <div class="box-body row">
                                  
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputPassword1">Status</label>
                                        <select class="form-control" name="status" required>
                                               <option value='1' <?php echo($RESULT[0]->status==1)?'selected':''; ?> >Active</option>
                                            <option value='0' <?php echo($RESULT[0]->status==0)?'selected':''; ?>>Inactive</option>
                                        </select>
                                        <?php echo form_error( 'status'); ?> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputPassword1">Show in model?</label>
                                        <select class="form-control" name="in_model" required>
                                               <option value='1' <?php echo($RESULT[0]->in_model==1)?'selected':''; ?> >Active</option>
                                            <option value='0' <?php echo($RESULT[0]->in_model==0)?'selected':''; ?>>Inactive</option>
                                        </select>
                                        <?php echo form_error( 'in_model'); ?> 
                                    </div> 
                                   
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" class="form-control"  name="title" value="<?php echo $RESULT[0]->title; ?>" required placeholder="Enter Title">
                                        <?php echo form_error( 'title'); ?> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Coupon Code</label>
                                        <input type="text" class="form-control" maxlength="15" minlength="4" name="couponCode"   value="<?php echo $RESULT[0]->couponCode; ?>" required placeholder="Enter Coupon Code">
                                        <?php echo form_error( 'title'); ?> </div>
                                     <div class="form-group col-sm-6">
                                        <label for="exampleInputPassword1">Discount Type</label>
                                        <select class="form-control" name="type" required>
                                            <option <?php echo($RESULT[0]->type=='Percentage')?'selected':''; ?>  value='Percentage'>Percentage</option>
                                            <option <?php echo($RESULT[0]->type=='Flat')?'selected':''; ?>  value='Flat'>Flat</option>
                                        </select>
                                        <?php echo form_error( 'type'); ?> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Flat Amount or Percentage</label>
                                        <input type="number" class="form-control" name="amount" id="price" value="<?php echo $RESULT[0]->amount; ?>" required>
                                        <?php echo form_error( 'amount'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Enable Date</label>
                                        <input type="date" class="form-control" name="enableDate" value="<?php echo $RESULT[0]->enableDate; ?>" required>
                                        <?php echo form_error( 'enableDate'); ?> </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Disable Date</label>
                                        <input type="date" class="form-control" name="disableDate" value="<?php echo $RESULT[0]->disableDate; ?>" required>
                                        <?php echo form_error( 'disableDate	'); ?> </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Short Description</label>
                                        <textarea class="form-control" name="description" placeholder="Enter short description"><?php echo $RESULT[0]->description; ?></textarea>
                                    </div>
                                      <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Image</label>
                                        <input type="file" class="form-control" name="image"  id="logo" onchange="show_preview();" accept="image/png, image/jpeg,image/png,image/JPEG,image/JPG,image/PNG">
                                        <input type="hidden" name="old_file" value="<?php echo $RESULT[0]->image; ?>" >

                                         <div class="" id="logo_preview">
                                            <?php if(!empty($RESULT[0]->image)){ ?>
                                        <img src="<?php echo base_url('uploads/coupon/').$RESULT[0]->image; ?>" width="100%">
                                        <?php } ?>
                                         </div>
                                           <br>

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
        <script>
            $('#select_cat')
                .val('<?php echo $RESULT[0]->category_id; ?>')
                .change();

        </script>
        <!-- /.content-wrapper -->
        <?php $this->load->view('admin/layout/footer'); ?> </div>
    <!-- ./wrapper -->
    <?php $this->load->view('admin/layout/footer_js'); ?>
      <script>CKEDITOR.replace( 'description' ); </script>
    <script>
       $(document.body).on('change',"#CoupoCodeTimes",function (e) {
           //doStuff
           var optVal= $("#CoupoCodeTimes option:selected").val();
           if(optVal == '3'){
               
               $('#time').removeAttr('disabled') ; 
               $("#time").attr("required", true);
               
           }else{
               
               $('#time').attr("disabled", true);
               $('#time').attr("required", false);
           }
        });
         $(document.body).on('change',"#CoupoCodeCriteria",function (e) {
           //doStuff
           var optVal= $("#CoupoCodeCriteria option:selected").val();
           if(optVal == '2'){
                $('#category').css('display','none') ;
               $('#order_value_div').css('display','block') ;
               $("#order_value").attr("required", true);
               
           }else if(optVal == '3'){
               
               $('#category').css('display','block') ;
               $('#order_value_div').css('display','none') ;
               $('#order_value').attr('disabled') ; 
               
           }else{
               $('#category').css('display','none') ;
               $('#order_value_div').css('display','none') ;
               $("#order_value").attr("required", false);
           }
        });
    </script>
</body>

</html>
