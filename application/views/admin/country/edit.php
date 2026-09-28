<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo Website; ?> | Edit Country</title>
  <?php $this->load->view('admin/layout/head_css'); ?>
  <?php $this->load->view('admin/layout/tiny-mce'); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view('admin/layout/header'); ?>  
  
<?php $this->load->view('admin/layout/sidebar'); ?> 
 
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>Edit Country</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url('admin/Country/listing'); ?>">All Country</a></li>
        <li class="active">Edit Country</li>
      </ol>
    </section>

   
    <section class="content">
      <!-- Info boxes -->
      <div class="box">
     <div class="box-body">
            <div class="box box-primary">            
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" id="form" autocomplete="off"  enctype="multipart/form-data">
              <div class="box-body">
       <!--  <div class="form-group">
          <label for="exampleInputPassword1">Parent Category</label>
          <select class="form-control" name="parent_id" required id="select_cat">
            <option value='0'>Root</option>
            <?php echo $this->category_model->get_all_child_category(0); ?>
          </select>
          <?php echo form_error('parent_id'); ?>
                </div> -->

                
                <div class="form-group">
          <label for="exampleInputEmail1">Title</label>
          <input type="text" class="form-control" name="title" onkeyup="return set_slug(this.value);" value="<?php echo $RESULT[0]->title; ?>" required placeholder="Enter Title">          
          <?php echo form_error('title'); ?>
        </div>
        
        <div class="form-group">
          <label for="exampleInputEmail1">Meta Title</label>
          <input type="text" class="form-control" name="meta_title" value="<?php echo $RESULT[0]->meta_title; ?>" required placeholder="Enter Meta Title">          
          <?php echo form_error('meta_title'); ?>
         </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Meta Keywords</label>
          <textarea class="form-control" name="meta_keywords" placeholder="Enter description" ><?php echo $RESULT[0]->meta_keywords; ?></textarea>
                </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Meta Description</label>
          <textarea class="form-control" name="meta_description" placeholder="Enter description"><?php echo $RESULT[0]->meta_description; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                  <select class="form-control" name="status" required>
          <option value='1' <?php echo($RESULT[0]->status==1)?'selected':''; ?> >Active</option>
          <option value='0' <?php echo($RESULT[0]->status==0)?'selected':''; ?>>Inactive</option>
          </select>
          <?php echo form_error('status'); ?>
                </div> 
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="submitform">Submit</button>
                 <a href="<?php echo base_url()?>admin/Country/listing"> <button type="button" class="btn btn-primary" name="submitform">Cancel </button></a>
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
$(document).ready(function(){
  $('#form').parsley();
  $('#select_cat').val('<?php echo $RESULT[0]->parent_id; ?>').change();
  //$("#select_cat > option[value=" + <?php echo $RESULT[0]->parent_id; ?> + "]").prop("selected",true);
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
</body>
</html>
