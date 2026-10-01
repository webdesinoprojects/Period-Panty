<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php  echo $RESULT[0]->meta_title ; ?></title>
<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
<?php $this->load->view('front/layout/head'); ?>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>
<div class="dx-acct pt-9 pb-9">
      <div class="container">
     
        <div class="row">
         
            <div class="col-lg-3 mb-5 mb-lg-0"><?php $this->load->view('front/account/left-menu'); ?></div>
            <div class="col-lg-9">
              <div class="dx-panel" style="max-width:560px">
                <div class="dx-panel-head"><h2 class="dx-panel-title">Change password</h2></div>
				<?php echo $this->session->flashdata('msg'); ?>	
				<form class="changepassword row" id="profile_form" method="post">
					<input type="hidden" value="<?php echo $user[0]->password; ?>" name="form_key">
					<div class="form-group col-sm-12">
						<label>Old Password</label>
						<input type="password" name="opwd" placeholder="enter old password" class="form-control custom-size" required> 
					</div>
	
					<div class="form-group col-sm-12">
						<label>New Password</label>
						<input type="password" name="npwd" placeholder="enter new password" class="form-control custom-size" id='npwd' required> 
					</div>
	
					<div class="form-group col-sm-12">
						<label>Confirm Password</label>
						<input type="password" name="cpwd" placeholder="enter confirm password" class="form-control custom-size" data-parsley-equalto="#npwd" required> 
					</div>
	
					<div class="form-group col-sm-12">										
						<button type="submit" class="btn btn-solid btn-success btn-block" name="changepass">Submit</button>
					</div>
				</form>
              </div>
    				
            </div>
        </div>
    </div>
    </div>

<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>

<script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
<script class="example">
$(document).ready(function(){
	$('#profile_form').parsley();	
});
</script>

</body>
</html>