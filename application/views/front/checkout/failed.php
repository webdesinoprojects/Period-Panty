<?php $RESULT = $this->cms_model->get_cms_by_id(1);?>
<?php $user_id = $this->session->userdata('USER_ID'); ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Your Order Is Completed !</title>

 <?php $this->load->view('front/layout/head'); ?>
 <style>
     .ps-checkout__order{
         color:#fff;
     }
 </style>
</head>
<body>
    <?php $this->load->view('front/layout/header'); ?>


    <div class="product_details mt-100 mb-100">
      <div class="container">
            <div class="row">
                
                <div class="col-lg-10 offset-lg-1">
                              <div class="row">
                      <div class="col-lg-2"></div>
                      <div class="col-lg-8">
                           <div class="section-title2">
                                        <h2 class="title">Oops ! Your Order failed</h2>
                                        <br>
                                        <br>
                                       
                                    </div>
                        <div class="shop_order_box mt40">
                          <div class="order_list_raw">
                             <table class="table table-bordered text-center">
                                                <thead>
                                                  <tr>
                                                      <th style="text-align:center">Order Number</th>
                                                      <?php if($order_data[0]->transaction_no) { ?>
                                                      <th style="text-align:center">Transaction Id </th>
                                                      <?php  } ?>
                                                      <th style="text-align:center">Payment</th>
                                                      <th style="text-align:center">Payment Status</th>
                                                       <th style="text-align:center">Date</th>
                                                  </tr>
                                                  
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php Echo $order_data[0]->order_no ?></td>
                                                         <?php if($order_data[0]->transaction_no) { ?>
                                                        <td><?php Echo $order_data[0]->transaction_no ?></td>
                                                                  <?php  } ?>
                                                        <td>Rs <?php Echo $order_data[0]->final_amount ?></td>
                                                         <td><?php Echo $order_data[0]->payment_status ?></td>
                                                          <td><?php echo date('d-m-Y',strtotime($order_data[0]->create_date)); ?></td>
                                                    </tr>
                                                 
                                                </tbody>
                                          </table>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>

