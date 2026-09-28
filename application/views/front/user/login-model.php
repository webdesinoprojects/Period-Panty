<div class="modal fade" id="login_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        	<div class="" style="padding:20px;    background-color: rgb(255, 255, 255);border: 1px solid rgb(204, 204, 204);box-shadow: rgb(0 0 0 / 20%) 2px 2px 3px;;">
						<header>
							<center>
							     <a href="<?php echo base_url() ;  ?>" class="ps-logo">
                                     <?php if($link[0]->logo ){ ?>
                                      <img src="<?php echo base_url('uploads/').$link[0]->logo ?>" class="logo2 img-fluid" alt=" <?php echo $link[0]->title ;  ?>" style="width:150px">
                                    <?php } else{  ?>
                                      <?php echo $link[0]->title ;  ?>
                                    <?php } ?>
                                </a>
                        
								<h4>Customer Login</h4>
								<a href="<?php echo base_url('user/register'); ?>" >Not A Member Yet ? Sign Up Now!? <i class="fa fa-long-arrow-right"></i></a>
						</center>
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
                                                <label style="">Password</label>
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
                                            
                                            <div class="col-sm-8" >  <a href="<?php echo base_url('user/forgot_password'); ?>">FORGET YOUR PASSWORD ??</a></div>
                                        </div>
                                
                                </div>

                            </form>
                        </div>
                    </div>
    </div>
  </div>
</div>