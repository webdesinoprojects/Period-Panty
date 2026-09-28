<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/AdminLTE.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/iCheck/square/blue.css'); ?>">
  <!-- UI rehaul (admin). This page does not use layout/head_css.php, so the
       override is linked here too. Must stay last. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/rehaul-admin.css'); ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
 
  <!-- /.login-logo -->
  <div class="login-box-body">
       <div class="login-logo">
    <b>       <center><img src="<?php echo base_url('uploads/').$link[0]->logo ?>" style="width:200px"> </center> </b>
  </div>
  <hr>
    <p class="login-box-msg"><?php echo $this->session->flashdata('msg'); ?></p>

    <form action="#" method="post" id="login_form" autocomplete="off">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="login">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/admin/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
<script class="example">
$(document).ready(function(){
	$('#login_form').parsley();
});
</script>
</body>
</html>
