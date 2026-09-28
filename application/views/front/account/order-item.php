
<?php $product_images = $this->product_model->select_product_images($item->pro_id);
$product_data = $this->product_model->get_product_by_id($item->pro_id); ?>
<?php  $url = $this->product_model->get_product_url($item->pro_id) ; ?>
<?php $custom_option = json_decode($item->custom_options)  ; ?>

 <tr>
    <th scope="row" style="width:40%">
      <ul class="cart_list">
        <li class="list-inline-item "><a href="#"><?php if(count($product_images)>0){ ?>
            <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" width="90">
            <?php }  ?></a>
        </li>
        <bR>
        <li class="list-inline-item">
            <a class="cart_title" href="<?php echo $url; ?>"><?php echo  $product_data[0]->title; ?></a>
           
        </li>
      </ul>
      
    </th>
    <td><?php echo $item->qty; ?></td>
   
    <td class="text-thm" style="width:20%">
        <p style='color:black;font-size: 12px;'>


             <?php echo CURRENCY_SYMBOL.number_format( $item->price*$item->qty); ?>

     </p>
    </td>
    <td class="text-thm"><?php echo CURRENCY_SYMBOL." ".$item->sub_total; ?></td>
  </tr>
