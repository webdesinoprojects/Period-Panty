 <script>
         print_order() ; 
        function print_order(){
            $.ajax({
                url: "<?php echo base_url('checkout/print_cart_value') ?>",
                dataType: 'json',
                success: function(data) {
                 $('#cart-total').html(data['coupon_html']);
                }
            });
            return false;
        }
        $(document).ready(function() {
            $("#button-coupon").on('click', function() {
                        var coupon = $('#input-coupon').val();
                        if (!coupon) {
                            $('#couponmsg').html('<p style="color:red">Enter Coupon Code</p>');
                        } else {
                            $.ajax({
                                url: "<?php echo base_url('checkout/apply_coupon') ?>",
                                data: {
                                    coupon: coupon
                                },
                                type: "POST",
                                dataType: 'json',
                                success: function(data) {
                                    if (data['error'] == '') {
                                        $('#cart-total').html(data['coupon_html']);
                                        $('#couponmsg').html('<p style="color:green">Applied Successfully</p>');
                                    } else {
                                        $('#couponmsg').html(data['msg']);
                                    }
                                }
                            });
                            return false;
                        }
                });
        });
        function remove_coupon(){
             $.ajax({
                url: "<?php echo base_url('checkout/remove_coupon') ?>",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#cart-total').html(data['coupon_html']);
                    $('#couponmsg').html(data['msg']);
                }
            });
            return false;
        }

    </script>