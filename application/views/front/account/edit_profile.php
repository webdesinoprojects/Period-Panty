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
    <?php $this->load->view('front/layout/header'); ?>
    <section class="py-2 bg-gray-2">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
                <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page">Edit Profile</li>
            </ol>
        </nav>
    </div>
</section>
 <div class="pt-9 pb-9">
        <div class="container">
            <div class="row">
                   <div class="col-sm-3"><?php $this->load->view('front/account/left-menu'); ?></div>
            <div class="col-sm-9">
                    <?php echo $this->session->flashdata('msg'); ?>
                    <form method="post" class="setting-form" id="profile_form">
                        <div class="row">
                          
                           
                            <div class="col-sm-6">
                                <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="field-label">First Name :</label>
                                            <input type="text" class="form-control" value="<?php echo $user[0]->fname; ?>" name="fname" required> </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="field-label">Last Name :</label>
                                            <input type="text" class="form-control" value="<?php echo $user[0]->lname; ?>" name="lname"> </div>
                                    </div> 
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="field-label">Email :</label>
                                            <input type="text" class="form-control" value="<?php echo $user[0]->email; ?>" name="email"> </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="field-label">Contact No. :</label>
                                            <input type="text" class="form-control" id="phone" name="contact_no" value="<?php echo $user[0]->contact_no; ?>" required minlength="10" maxlength="10">
                                            <p id="tel-msg" style="color: red ;font-size: 12px"></p>
                                        </div>
                                    </div> 
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="field-label">Landmark :</label>
                                            <input type="text" class="form-control" name="landmark" value="<?php echo @$user[0]->landmark; ?>"> </div>
                                    </div>
                                </div>
                             </div>
                             <div class="col-sm-6">
                                <div class="row">
                                 
                                    
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="field-label">Address :</label>
                                                <input type="text" class="form-control" name="address" value="<?php echo $user[0]->address; ?>" required> </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="field-label">City :</label>
                                                <input type="text" class="form-control" name="city" value="<?php echo $user[0]->city; ?>" required> </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="field-label">State :</label>
                                                <input type="text" class="form-control" name="state" value="<?php echo $user[0]->state; ?>" required> </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="field-label">Country:</label>
                                                <input type="text" class="form-control" name="country" value="<?php echo $user[0]->country; ?>" required> </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="field-label">pincode:</label>
                                                <input type="text" class="form-control" name="pincode" value="<?php echo $user[0]->pincode; ?>" minlength="6" maxlength="6" required> </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                 <input type="submit" class="btn btn-solid btn-success btn-block" name="updateprofile" > 
                            </div>
                            
                        </div>
                        <!--- Row End -->
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>


    <script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
    <script class="example">
        $(document).ready(function() {
            $('#profile_form').parsley();
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tel-msg').empty();
            $('#phone').keypress(validateNumber);
            $('#phone').keyup(function() {
                if ($('#phone').val().length != 10) {
                    $('#tel-msg').html('Enter 10 Digits Phone Number.');
                    return false;
                } else {
                    $('#tel-msg').empty();
                }
            });
        });

        function validateNumber(event) {
            var key = window.event ? event.keyCode : event.which;
            if (event.keyCode === 8 || event.keyCode === 46) {
                return true;
            } else if (key < 48 || key > 57) {
                return false;
            } else {
                return true;
            }
        };

    </script>
    
<script src="<?php echo base_url('assets/admin/parsley/parsley.js'); ?>"></script>
<script>
$(document).ready(function(){

	$('#same_as_shipping').click(function(){
		if($(this).prop('checked')==true)
		{
		
			$('input[name=billing_landmark]').val($('input[name=landmark]').val());
			$('input[name=billing_city]').val($('input[name=city]').val());
			$('input[name=billing_state]').val($('input[name=state]').val());
			$('input[name=billing_pincode]').val($('input[name=pincode]').val());
			$('input[name=billing_country]').val($('input[name=country]').val());			
			$('input[name=billing_address]').val($('input[name=landmark]').val());			
		}else
		{
			$('input[name=billing_landmark]').val('');
			$('input[name=billing_landmark]').val('');
			$('input[name=billing_city]').val('');
			$('input[name=billing_state]').val('');
			$('select[name=billing_pincode]').val('');
			$('input[name=billing_country]').val('');
			$('input[name=billing_address]').val('');
		
		}
	});	
	$('.checkout').parsley()


});
</script>
</body>

</html>
