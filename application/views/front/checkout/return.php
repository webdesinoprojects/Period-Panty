<!doctype html>
<html>
<head>
<?php $this->load->view('front/layout/head'); ?>
<style></style>
</head>
<body>
<?php $this->load->view('front/layout/header'); ?>
<!--- End Header -->
<section class="breadcrumb-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<ul class="breadcrumb custom-bread">
					<li><a href="<?php echo base_url(''); ?>">Home</a> / </li><li>About Us</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="custom_section">
  <div class="container">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
   <div class="aboutText">

    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>

   </div>
  </div>
  </div>
  </div>
</section>


<?php $this->load->view('front/layout/footer.php') ?>
</body>
</html>
