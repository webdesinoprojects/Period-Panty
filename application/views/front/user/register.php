<?php error_reporting() ; ?>
<?php $link=$this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php echo $RESULT[0]->meta_title ; ?></title>
	<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
	<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
	<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
	<?php $this->load->view('front/layout/head'); ?> </head>

<body>

	<!-- about content start  -->
	<div class="about-content mt-5">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-3  "> </div>
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
                        
								<h4>Customer Register</h4> </center>
						</header>
						<hr>
						<div class="content">
							<div class="login-form ">
								<form id="signup-form" method="post" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-6 col-12 mb-4  ">
										
											<input class="form-control" type="text" onfocus id="fname" placeholder="First Name*" name='fname' required = "true"  pattern="[A-Za-z\s]+$"  value="" onkeypress="return nameValidation(event)" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/(\..*)\./g, '$1');" required value="<?php echo set_value('fname'); ?>" title="Allows only characters"   maxlength="30">
											<?php echo form_error( 'fname'); ?> 
										</div>
									
										<div class="col-sm-6 col-12 mb-4  ">
										
											<input class="form-control" type="text" id="lname" name="lname" placeholder="Last Name" required value="<?php echo set_value('lname'); ?>" required = "true"  pattern="[A-Za-z\s]+$"  value="" onkeypress="return nameValidation(event)" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/(\..*)\./g, '$1');" title="Allows only characters"   maxlength="30">
											<?php echo form_error( 'lname'); ?> </div>
										<div class="col-md-6 mb-4  ">
										
											<input class="form-control" type="email" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" required onblur="return checkEmail(this.value)" value="" title="example@mail.com" placeholder="Email"  name="email" value="<?php echo set_value('email'); ?>">
											<?php echo form_error( 'email'); ?> </div>
										<div class="col-md-6 mb-4  ">
										
											<input class="form-control" type="text" id="phone" required placeholder="Mobile Number*" name="contact_no" value="<?php echo set_value('contact_no'); ?>" required = "true" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                pattern="^\d{10}$" value="" title="Enter 10 Digit Mobile Number" min=10  max=10 autocomplete="off"  placeholder="Mobile Number" />
											<p id="tel-msg" style="color:red"></p>
											<?php echo form_error( 'contact_no'); ?>
										</div>
										   <div class="col-md-6  mb-4   ">
                                              
                                                <input class="form-control" type="password" id="newPassword" placeholder="Enter your password" required  name="password" value="<?php echo set_value('password'); ?>">
    
                                                     <?php echo form_error('password'); ?>
                                            </div>
                                            <div class="col-md-6  mb-4   ">
                                                <input class="form-control" type="password"  placeholder="Enter your confirm password" required name="confirm_password" value="<?php echo set_value('confirm_password'); ?>">
    
                                                   <?php echo form_error('confirm_password'); ?>
                                            </div>
										<div class="col-md-12 mb-4  ">
											<button class="btn btn-primary btn-lg btn-block" id="registerButton" type="submit" name="register">Register</button>
										</div>
										<div class="col-12">
											<div id="signup-box-msg"></div>
										</div>
									</div>
									<bR>
									<div class="row">
										<div class="col-sm-8"> <a href="<?php  echo base_url('user/login');?>" class="create-account">Already have an account? <i class="fa fa-long-arrow-right"></i></a> </div>
										<div class="col-sm-12"> </div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('front/layout/footer-js'); ?>
	
	<script>
function nameValidation(e) {
		var k = e.keyCode;
				$return = ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32  || (k >= 48 && k <= 57));
		  if(!$return) {
			return false;
		  }
                  return true;
	}


function checkEmail(str)
	{
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                  if(str.length == 0)
		   return true;
                
                if(!re.test(str))
		alert("Please enter a valid email address");
	}




</script>
	
<script type="text/javascript">
	$(document).ready(function() {
		$('#signup-form').submit(function() {
			$('#registerButton').text('Processing....');
			var formData = new FormData(this);
			$.ajax({
				url: "<?php echo base_url('user/register_process') ?>",
				type: "POST",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'json',
				success: function(response) {
					if(response.status == 1) {
						$('#signup-box-msg').html(response.message);
						window.location.replace(response.url);
					} else {
						$('#signup-box-msg').html(response.message);
					}
					$('#registerButton').text('Submit');
				}
			});
			return false;
		});
	});
	</script>
</body>

</html>