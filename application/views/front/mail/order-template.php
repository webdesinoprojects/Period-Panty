<?php $data['ORDER'] = $ORDER;  $shipping_details = $this->order_model->get_shipping_data($ORDER[0]->id);$link=$this->setting_model->get_all_setting();  ?>
<p>
    Dear  <?php echo ucwords($shipping_details[0]->fname .' '.$shipping_details[0]->lname); ?> <br>
    Thankyou for shopping with <?php echo $link[0]->title; ?>. Your order has been successfully placed with us. We'll be dispatching your products after a thorough quality check as soon as possible. If you would like to view the status of your order, please login to www.knitnknot.in
    Your purchase has been indicated below:<br>

</p>
<?php $this->load->view('invoice' , $data); ?>	