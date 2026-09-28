<?php error_reporting() ; ?>
<?php $user_id=$this->session->userdata('USER_ID'); ?>
<?php $coupon=$this->session->userdata('coupon_data'); ?>
<?php $userdata=$this->user_model->get_user_by_id($user_id); ?>
<?php $link=$this->setting_model->get_all_setting();?>
<?php
$user_session=$_SESSION[ 'user_session'];
?>
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
    <?php $this->load->view('front/layout/head'); ?>
    <style>
 .modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
    z-index: 11111;
}
</style>
</head>

<body>
    <?php $this->load->view('front/layout/header-2'); ?>
    <?php $this->load->view('front/user/login-model'); ?>
    <!-- about content start  -->
    <div class="about-content margin-top-30 margin-bottom-30">
        <div class="container">
            <section class="shop-cart" id="content">
                <div class="container">
                    <div class="checkout-page login-form">
                        <div class="checkout-form">
                            <form method="post" class="checkout" action="<?php echo base_url('checkout/payment'); ?>">
                                <div class="row">
                                    <div class="col-sm-8 border-r">
                                       <?php $this->load->view('front/checkout/side-cart-value'); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>
    <?php $this->load->view('front/layout/footer-js'); ?>
    <?php $this->load->view('front/checkout/side-cart-js'); ?>
    <?php  if(empty($user_session)){ ?>
    <script>
        $('#login_model')
            .modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });

    </script>
    <script type="text/javascript">
        $(document)
            .ready(function() {
                $('#login_model')
                    .modal('show');
                $(".sign_up_form .btn-close-2")
                    .on('click', function() {
                        $('#login_model')
                            .modal('hide');
                        $('#logInModalNew')
                            .modal('show');
                    });
                $("#logInModalNew .btn-close-3")
                    .on('click', function() {
                        $('#logInModalNew')
                            .modal('hide');
                        $('#login_model')
                            .modal('show');
                    });
            });

    </script>
    <?php } ?> </body>

</html>
