<?php error_reporting() ; ?>
<?php $link=$this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $RESULT[0]->meta_title ; ?></title>
	<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
	<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
	<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
	<?php $this->load->view('front/layout/head'); ?> </head>

<body>

	<!-- about content start  -->
	<div class="about-content mb-4  mt-4 ">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-3  mt-4"> </div>
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
                        
								<h4>Forgot Password</h4> 
							</center>
						</header>
						<div class="content mt-4">
						     <form id="forgot_form"  method="post">   
                                <div class="content">
                                   <div class="login-form row">
                                            <div class="form-group  col-sm-12">
                                               
                                                <div class="form-group__content">
                                                <input class="form-control" type="email" id="email" name="email" placeholder="Email" required="" value="<?php echo set_value('email'); ?>">
                                                 <?php echo form_error('email'); ?>
                                                </div>
                                            </div>
                                          
                                             <div class="form-group col-sm-12">
                                                <button class="btn btn-primary btn-black btn-block"  name="forgot_password"  id="forgot_password" type="submit">Submit</button>
                                             </div>
                                             <div class="form-group col-sm-12"  id="forgot-box-msg" ></div>
                                    </div>
                                    <hr>
                                    <div class="row" > 
                                            <div class="col-sm-8" > <a href="<?php echo base_url('user/login'); ?>" >Login ? <i class="fa fa-long-arrow-right"></i></a> </div>
                                            <div class="col-sm-4" >  </div>
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
<script type="text/javascript">

    $(document).ready(function() {
 
    $('#forgot_form').submit(function () {   
      
    $('#forgot_password').text('Processing....') ;     
      $.ajax({
            url: "<?php echo base_url('user/forgot_password_process') ?>",
            type: "POST",     
            data: $(this).serialize(),
            success: function (output) { 
                    $('#forgot_password').text('Resend Link') ; 
                    $('#forgot-box-msg').html(output); 
                 
                }  
          });
      return false;
    });
}); 
 </script>

    </body>

</html>
