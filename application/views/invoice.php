
<style>
table {
    border: 1px solid #7e7272;font-size:12px!important;
}
table p{
   font-size:12px!important;
}
table ul li{
   font-size:12px!important;
}

</style>
    <?php $user=$this->user_model->get_user_by_id($ORDER[0]->user_id); 
    $shipping = $this->order_model->get_shipping_data($ORDER[0]->id); 
    $billing = $this->order_model->get_billing_data($ORDER[0]->id); 
    $items_data = $this->order_model->get_item_data($ORDER[0]->id); ?>
    <?php $link=$this->setting_model->get_all_setting();?>
    <?php 
    $shipping_details=$this->order_model->get_shipping_data($ORDER[0]->id) ;
    ?>
    
    <table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="1" width="100%" style="border:1px solid #e0e0e0">
    <tbody>
        <tr>
            <td border="0">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td valign="top" style="font-size:12px;padding:9px 9px 9px 9px;width: 20%;">
                                <?php if($link[0]->logo) { ?>
                                <img src="<?php echo base_url('uploads/').$link[0]->logo; ?>" style="width:50%">
                                <?php }else{ ?>

                                <?php echo ucwords($link[0]->title); ?>
                                <?php } ?>

                            </td>
                            
                            <td valign="top" style="font-size:10px;padding:9px 9px 9px 9px;">
                                    <h5> <?php echo ucwords($link[0]->company_name); ?></h5>
                                    <p>
                                    <?php echo ucwords($link[0]->invoice_address); ?>
                                    <br><b>Customer service. </b><?php echo $link[0]->phone; ?>
                                    <br><b>Email ID. </b>.<?php echo $link[0]->email; ?>
                                </p>


                            </td>
                            <td style="font-size:12px;padding:9px 9px 9px 9px;width: 30%;">
                                <h3 style="text-align:center"><b>TAX INVOICE </b></h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border:1px solid #eaeaea">
                    <thead>
                        <tr>
                            <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Order Information</th>
                            <th width="10" style="border: none !important;"></th>
                            <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                <p><strong>Order</strong> : #
                                    <?php echo $ORDER[0]->order_no ?>
                                    <br><strong>Order Date</strong> :
                                    <?php echo date( 'd-M-Y h:i:s a',strtotime($ORDER[0]->create_date)); ?>
                                    <br><strong>Order Status</strong> :
                                        <?php echo ucfirst($ORDER[0]->status); ?>
                                    <br><strong>Payment Status</strong> :
                                        <?php echo ucfirst($ORDER[0]->payment_status); ?>
                                    <br><strong>Payment Method</strong> :
                                        <?php echo ucfirst($ORDER[0]->payment_method); ?></p>
                            </td>
                            <td></td>
                            <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
               
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border:1px solid #eaeaea">
                    <thead>
                        <tr>
                            <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Shipping Address</th>
                            <th width="10" style="border: none !important;"></th>
                            <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Billing Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">

                                <?php  echo "
                                <p><b>".ucwords($shipping_details[0]->fname)." ". ucwords($shipping_details[0]->lname)."</b> "; echo "
                                    <br> <b>Phone:  &nbsp;   &nbsp; </b>".$shipping_details[0]->phone.""; echo "
                                    <br> <b>Address: &nbsp;  &nbsp; </b>". ucwords($shipping_details[0]->address).", ". ucwords($shipping_details[0]->city).","; echo ucwords($shipping_details[0]->state).", ". ucwords($shipping_details[0]->country).",". $shipping_details[0]->pincode."
                                    <br>"; echo " <b>Landmark: &nbsp; &nbsp; </b> ".$shipping_details[0]->landmark."
                                    <br>"; if($shipping_details[0]->gst){ echo " <b>GST:  &nbsp;   &nbsp; </b>".$shipping_details[0]->gst.""; } echo "</p>" ; ?>

                            </td>
                            <td></td>
                            <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                <?php $billing_details=$this->order_model->get_billing_data($ORDER[0]->id) ; if($billing_details) { ?>
                                
                                <?php echo "<p><b>".ucwords($billing_details[0]->fname)." ". ucwords($billing_details[0]->lname)."</b>"; echo "
                                <br> <b>Phone:   &nbsp; &nbsp;</b>".$billing_details[0]->phone.""; echo "
                                <br><b>Address:  &nbsp; &nbsp;</b>". ucwords($billing_details[0]->address).", ". ucwords($billing_details[0]->city).","; echo ucwords($billing_details[0]->state).", ". ucwords($billing_details[0]->country).",". $billing_details[0]->pincode.""; echo "
                                <br><b>Landmark: &nbsp; &nbsp; </b> : ".$billing_details[0]->landmark.""; if($billing_details[0]->gst){ echo "
                                <br> <b>GST:  </b>".$billing_details[0]->gst.""; } echo "</p>" ; } ?>


                            </td>
                        </tr>
                    </tbody>
                </table>
                </br>
                <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border:1px solid #eaeaea">
					<thead  bgcolor="#F6F6F6">
					    
					  
						<tr>
						    <th>#</th>
                            <th style="text-align:center">Item & Description</th>
                            <th style="text-align:center" >QTY</th>
                            <th style="text-align:center" >RATE</th>
                            <th style="text-align:center" >AMOUNT</th>
                          </tr>
					</thead>
					<tbody>
						
					<?php if(count($items_data)>0){ ?>
					<?php foreach($items_data as $key=> $item): ?>
					 <?php
					    $product_data = $this->product_model->get_product_by_id($item->pro_id); ;
					    $product_images = $this->product_model->select_product_images($item->pro_id);?>
						<?php $product_images = $this->product_model->select_product_images($item->pro_id); ?>
                        <?php  $url = $this->product_model->get_product_url($item->pro_id) ; ?>
                        <?php $custom_option = json_decode($item->custom_options)  ; ?>
                        <?php $selling_amt =  $item->price; ?>
               
                        
                         <tr>
                            <th style="width:3%;text-align:center"> <?php echo $key+1 ; ?> </th>
                            <td style="width:30%;padding-left:10px"><a class="cart_title" href="<?php echo $url; ?>"><?php echo  ucwords($product_data[0]->title); ?></a> <br> Size: <?php print_r($custom_option->cartdata->size) ; ?> <br>SKU: <?php echo  $custom_option->cartdata->sku; ?></td>
    
                            <td style="text-align:center"><?php echo $item->qty; ?></td>
                            <td style="text-align:center"><?php echo CURRENCY_SYMBOL." ".number_format( $item->price); ?></td>
                    
                            <td style="text-align:center"><?php echo CURRENCY_SYMBOL." ".$item->sub_total; ?></td>
                          </tr>

					<?php endforeach; ?>	
					<?php } ?>	
					</tbody>
				</table>
				<table width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #eaeaea">
					<tfoot >
						<tr>
						    <td style="width:60%">
						       
                                <h5>
                                    &nbsp;Note:
                                </h5>
                                <ol>
                                    <li>Payment to be made at the time of receipt of goods</li>
                                    <li>Shipping cost from vendor's warehouse to customers' place to be borne by the customer</li>
                                    <li>
                                        Goods once sold will not be taken back except return of defective Authorized Signature goods
                                    </li>
                                </ol>
                               
						    </td>
						    <td>
						        <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border:1px solid #eaeaea">
						            
						            
            					    <tr>
						                <td  align="right" style="padding:3px 9px">Subtotal</td>
							            <td align="center" style="padding:3px 9px"><span><?php echo CURRENCY_SYMBOL." ".round($ORDER[0]->sub_total_amount); ?></span></td>
						            </tr>
            					
						            <?php if(!empty($ORDER[0]->cart_discount_amount)){ ?>
            						<?php $cart_offer_data = json_decode($ORDER[0]->cart_offer_data); 	 ?>
            					
            					
            						<tr>
            							<td  align="right" style="padding:3px 9px"> <?php if($cart_offer_data){ ?> <?php echo $cart_offer_data->title;  } ?> <br>
            								<td align="center" style="padding:3px 9px"><span>-<?php echo CURRENCY_SYMBOL." ".$ORDER[0]->cart_discount_amount; ?></span></td>
            						</tr>
            					    <tr>
						                <td  align="right" style="padding:3px 9px">Total</td>
							            <td align="center" style="padding:3px 9px"><span><?php echo CURRENCY_SYMBOL." ".round($ORDER[0]->total_amount); ?></span></td>
						            </tr>
            						<?php } ?>
            				
						            <?php if($ORDER[0]->shipping_charge) {  ?>
            						<tr>
            							<td align="right" style="padding:3px 9px"> Shipping Charges</td>
            							<td align="center" style="padding:3px 9px"><strong><span><?php echo CURRENCY_SYMBOL." ".$ORDER[0]->shipping_charge; ?></span></strong></td>
            						</tr>
            						<?php } ?>
						            <?php if(!empty($ORDER[0]->discount_amount)){ ?>
            						<?php $coupon_data = json_decode($ORDER[0]->coupon_data); 	 ?>
            					
            					
            						<tr>
            							<td  align="right" style="padding:3px 9px">Discount <?php if($coupon_data){ ?> <?php echo $coupon_data->amount; ?>  <?php echo ($coupon_data->type == 'Percentage')? "%" :"Rs Flat" ?> ) <?php } ?> <br>
            							<?php if($coupon_data){ ?> <b> <?php echo $coupon_data->couponCode; ?></b>  Coupon code applied  <?php } ?></td>
            							<td align="center" style="padding:3px 9px"><span>-<?php echo CURRENCY_SYMBOL." ".$ORDER[0]->discount_amount; ?></span></td>
            						</tr>
            					
            						<?php } ?> 
            					
            						<?php if(!empty($ORDER[0]->payment_method_disc_amt)){ ?>
            						<?php $payment_disc_data = json_decode($ORDER[0]->payment_disc_data); 	 ?>
            					
            					
            						<tr>
            							<td  align="right" style="padding:3px 9px"> <?php if($payment_disc_data){ ?> <?php echo $payment_disc_data->title;  } ?> <br>
            								<td align="center" style="padding:3px 9px"><span>-<?php echo CURRENCY_SYMBOL." ".$ORDER[0]->payment_method_disc_amt; ?></span></td>
            						</tr>
            					
            						<?php } ?>
            					
            				
            						<tr>
            							<td  align="right" style="padding:3px 9px"><strong> Total</strong></td>
            							<td align="center" style="padding:3px 9px"><strong><span><?php echo CURRENCY_SYMBOL." ".$ORDER[0]->final_amount; ?></span></strong></td>
            						</tr>
						        </table>
						    </td>
							
						</tr>
						
					</tfoot>
				</table>
				
            </td>
        </tr>
    </tbody>
</table>
                               