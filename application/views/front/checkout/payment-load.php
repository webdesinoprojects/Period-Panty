<!doctype html>
<html>
<head>
<?php $this->load->view('front/layout/head'); ?>

<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
	};
</script>
</head>
<body onload="document.form.submit()">



<section class="cart checkout">
	<div class="container">


	<center style="margin-bottom: 100px; margin-top: 100px">
		<img src="<?php echo base_url('images/DV9T.gif') ?>"   >
		<h5> Redirect to payment gateway , Please Do not refresh</h5>
		
	</center>	
	
		<form method="post" name="customerData" action="<?php  echo base_url('Payment/')?>process" id="form">

			<table >
				
					
			        		
				        	<input type="hidden" name="order_id" value="<?php  echo $CCAvenue['order_id'] ?>"/>
				      
	      	</table>
	      </form>



</div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
	window.onload = function(){
  $('#form').submit();
}
</script>



<script type="text/javascript">

document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 67 || 
             e.keyCode === 86 || 
             e.keyCode === 85 || 
             e.keyCode === 117)) {
           
            return false;
        } else {
            return true;
        }
};
jQuery(document).ready(function(){
  jQuery(function() {
        jQuery(this).bind("contextmenu", function(event) {
            event.preventDefault();
            
        });
    });
});
</script>

<script type="text/javascript" language="javascript">
        $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        }); 
</script>
<script>
    $(window).on('keydown',function(event)
    {
    if(event.keyCode==123)
    {
      
        return false;
    }
    else if(event.ctrlKey && event.shiftKey && event.keyCode==73)
    {
      
        return false;  //Prevent from ctrl+shift+i
    }
    else if(event.ctrlKey && event.keyCode==73)
    {
        
        return false;  //Prevent from ctrl+shift+i
    }
});
$(document).on("contextmenu",function(e)
{

e.preventDefault();
});
</script>
</body>
</html>