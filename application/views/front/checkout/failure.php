<!doctype html>
<html>
<head>
<?php $this->load->view('front/layout/head'); ?>
<style></style>
</head>
<body>
<?php $coupon = $this->session->userdata('coupon_data'); ?>
<?php //print_r($coupon); ?>
<!--- Start Header -->
     <?php $this->load->view('front/layout/header'); ?>
   
    <section class="pb-11 pb-lg-13">
	<div class="container">
		<div class="inner-page-title" id="coupon_apply">
			<h1>Your order has been failed.</h1>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div id="collapse1" class="panel-collapse collapse in" aria-expanded="true" style="">
						<div class="panel-body">
							<div class="row">
									<div class="col-sm-12">
										<div class="payment-options">
											<div class="checkout-title">
											  <h4>Your order has been failed.</h4>
											  <p>Your order # is: <?php echo $ORDER_ID; ?>.<br>
											 <br>
											</p>
											<?php  echo $msg ?>
											  <p>
												<a href="<?php echo base_url(); ?>" class="btn btn-default btn-continue pull-left"><span>Continue Shopping</span></a>
											  </p>
											</div>
										</div>
									</div>									
									<!-- 2nd Column --> 						
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php $this->load->view('front/layout/footer.php') ?>
</body>
</html>