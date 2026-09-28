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
	<div class="about-content  mb-4  mt-4 ">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-3 "> </div>
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
                        
								<h4>Customer Login</h4> </center>
						</header>
						<hr>
						<div class="content">
                            <form id="signin-form"  method="post">   
                                <div class="content">
                                   <div class="login-form row">
                                          <div class="form-group  col-sm-12 ">
										
											<input class="form-control" type="email" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" required onblur="return checkEmail(this.value)" value="" title="example@mail.com" placeholder="Email"  name="email" value="<?php echo set_value('email'); ?>">
											<?php echo form_error( 'email'); ?> 
										 </div>
									
                                            <div class="form-group col-sm-12">
                                                
                                                <div class="form-group__content">
                                                <input class="form-control" type="password" name="password" id="password" placeholder="Enter your password" required="" value="<?php echo set_value('password'); ?>">
                                                </div>
                                            </div>
                                            
                                             <div class="form-group col-sm-12">
                                                <button class="btn btn-primary btn-lg btn-block"  name="login"  id="loginButton" type="submit">Login</button>
                                             </div>
                                             <div class="form-group col-sm-12"  id="signin-box-msg" ></div>
                                    </div>
                                    <hr>
                                    <div class="row" > 
                                            <div class="col-sm-6" > <a href="<?php echo base_url('user/register'); ?>" >CREATE NEW ACCOUNT? <i class="fa fa-long-arrow-right"></i></a> </div>
                                            <div class="col-sm-6" >  <a href="<?php echo base_url('user/forgot_password'); ?>"> FORGOT YOUR PASSWORD ??</a></div>
                                        </div>
                                
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about content end  -->
 

<?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>


