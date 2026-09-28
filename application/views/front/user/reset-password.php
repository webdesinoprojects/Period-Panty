<?php error_reporting() ; ?>
<?php $link=$this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reset Password</title>

	<?php $this->load->view('front/layout/head'); ?> </head>

<body>

	<!-- about content start  -->
	<div class="about-content mb-4  mt-4 ">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-3  mb-30"> </div>
				
					<div class="col-sm-6 col-md-6 ">
					<div class="" style="padding:20px;    background-color: rgb(255, 255, 255);border: 1px solid rgb(204, 204, 204);box-shadow: rgb(0 0 0 / 20%) 2px 2px 3px;;">
						<header>
							<center>
							     <a href="<?php echo base_url() ;  ?>" class="ps-logo">
                             <?php if($link[0]->logo ){ ?>
                              <img src="<?php echo base_url('uploads/').$link[0]->logo ?>" class="logo2 img-fluid" alt=" <?php echo $link[0]->title ;  ?>" style="width:80px">
                            <?php } else{  ?>
                              <?php echo $link[0]->title ;  ?>
                            <?php } ?>
                        </a>
                        
								<h4>Reset Password</h4> 
							</center>
						</header>
						<div class="content">
						     <form class="theme-form form-signin" id="login-form" method="post">
                                <div class="login-form content">
                                    <?php echo $this->session->flashdata('msg'); ?>
                                    <div class="row">
                                        <div class="col-md-12 mt-10 mb-20 ">
                                            <div class="form-group">
                                                <label for="email">New Password</label>
                                                <input type="password" id="npwd" class="form-control"  placeholder="******" required name="npwd" name="npwd" value="<?php echo set_value('npwd'); ?>">
                                                <?php echo form_error( 'password'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-10 mb-20 ">    
                                            <div class="form-group">
                                                <label for="review">Confirm Password</label>
                                                <input type="password" id="cpwd" class="form-control" placeholder="******" required name="cpwd" value="<?php echo set_value('cpwd'); ?>" data-parsley-equalto="#npwd" parsley-required="true" data-parsley-trigger="blur">
                                                <?php echo form_error( 'confirm_password'); ?> 
                                            </div>
                                        </div>
                                      
    
                                        <div class="col-md-12 mt-10 mb-20 ">  
                                         <button type="submit" class="btn btn-primary  btn-black btn-block" name="reset_password" style="width: 100%">Reset Password</button>
                                        </div>
                                    </div>
                            
                                </div>
                            </form>
                          
                            
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>
<?php $this->load->view('front/layout/footer-js'); ?>
<script>
    function validatePassword() {
    var p = document.getElementById('newPassword').value,
        errors = [];
    if (p.length < 8) {
        errors.push("Your password must be at least 8 characters"); 
        document.getElementById('newPassword').value = '' ; 
    }
    if (p.search(/[!@#\$%\^&\*_]/) < 0) {
        errors.push("Your password must contain at least special char from -[ ! @ # $ % ^ & * _ ]"); 
        document.getElementById('newPassword').value = '' ; 
    }
    if (p.search(/[a-z]/i) < 0) {
        errors.push("Your password must contain at least one letter.");
        document.getElementById('newPassword').value = '' ; 
    }
    if (p.search(/[0-9]/) < 0) {
        errors.push("Your password must contain at least one digit."); 
        document.getElementById('newPassword').value = '' ; 
    }
    if (errors.length > 0) {
        alert(errors.join("\n"));
        return false;
    }
    return true;
}
</script>
    </body>

</html>


