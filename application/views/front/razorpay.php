<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Redirecting to payment</title>
<?php $this->load->view('front/layout/head'); ?>
</head>
<body onload="dxRazorpayOpen();">

<div class="main_content">
  <div class="section">
    <div class="container text-center" style="padding:80px 0">
      <h2 class="fs-24 mb-3">Opening secure payment&hellip;</h2>
      <p class="text-secondary">Order <?php echo html_escape($order_no); ?></p>
      <noscript><p>JavaScript is required to complete payment.</p></noscript>

      <?php /* Only three values come back from Razorpay and all three are
               verified server-side. There is deliberately no amount field and
               no order-number field here: the old form carried both, and both
               were editable in devtools. */ ?>
      <form name="razorpay-form" id="dx-razorpay-form" action="<?php echo html_escape($callback_url); ?>" method="POST">
        <input type="hidden" name="razorpay_payment_id" id="dx-rzp-payment-id">
        <input type="hidden" name="razorpay_order_id" id="dx-rzp-order-id">
        <input type="hidden" name="razorpay_signature" id="dx-rzp-signature">
        <?php if ($this->config->item('csrf_protection') === TRUE): ?>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
// key_id is Razorpay's publishable identifier and is meant to be here. The key
// secret and the webhook secret never reach this page, this script, any XHR or
// any URL - they exist only on the server.
var dxRazorpayOptions = {
  key: <?php echo json_encode($key_id); ?>,
  order_id: <?php echo json_encode($razorpay_order_id); ?>,
  amount: <?php echo json_encode($amount_paise); ?>,
  currency: "INR",
  name: "DEXTE",
  description: <?php echo json_encode('Order ' . $order_no); ?>,
  prefill: {
    name: <?php echo json_encode($buyer_name); ?>,
    email: <?php echo json_encode($buyer_email); ?>,
    contact: <?php echo json_encode($buyer_phone); ?>
  },
  notes: { dx_order_no: <?php echo json_encode($order_no); ?> },
  handler: function (response) {
    document.getElementById('dx-rzp-payment-id').value = response.razorpay_payment_id || '';
    document.getElementById('dx-rzp-order-id').value = response.razorpay_order_id || '';
    document.getElementById('dx-rzp-signature').value = response.razorpay_signature || '';
    document.getElementById('dx-razorpay-form').submit();
  },
  modal: {
    ondismiss: function () {
      window.location.href = <?php echo json_encode($cancel_url); ?>;
    }
  }
};

var dxRazorpayInstance;
function dxRazorpayOpen() {
  if (typeof Razorpay === 'undefined') { setTimeout(dxRazorpayOpen, 200); return; }
  if (!dxRazorpayInstance) {
    dxRazorpayInstance = new Razorpay(dxRazorpayOptions);
    // A failed attempt must not look like a success: send the buyer to the
    // failure page rather than leaving the modal silently closed.
    dxRazorpayInstance.on('payment.failed', function () {
      window.location.href = <?php echo json_encode($cancel_url); ?>;
    });
  }
  dxRazorpayInstance.open();
}
</script>
</body>
</html>
