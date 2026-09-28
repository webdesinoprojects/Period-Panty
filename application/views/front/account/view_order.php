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

 <div class="pt-9 pb-9">
        <div class="container">
            <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">  
                    <?php $data['ORDER'] = $ORDER; ?>
                	<?php $this->load->view('invoice' , $data); ?>	 
                    </div>
                </div>
            </div>
        </div>
       <?php $this->load->view('front/layout/footer'); ?>
       <?php $this->load->view('front/layout/footer-js'); ?>
<script>
$(document).ready(function(){
	$('#print_btn').click({
		//$('#invoice_print').print();
	});
	//$('#invoice_print').print();
});

function print_invoice(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>
</body>
</html>