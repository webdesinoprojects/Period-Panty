<?php foreach($CARTDATA as $item){ ?>
<?php 
$variation_data = $this->product_model->select_product_variation_by_id($item['id']) ;
$product_images = $this->product_model->select_product_images($variation_data[0]->product_id);
$product_data = $this->product_model->get_product_by_id($variation_data[0]->product_id); ?>
<?php $stock = $variation_data[0]->qty ; ?>    
<?php  $url = $this->product_model->get_product_url($variation_data[0]->product_id) ; ?>

<tr>
  <td><img class="mr-15" src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" alt="" style="width:80px">
      <input type="hidden" name="rowid[]" value="<?php echo $item['rowid'] ?>" />
    <input type="hidden" name="productid[]" value="<?php echo $variation_data[0]->product_id ?>" />
  </td>
  <td class="ml-3 mr-4" style="width:40%"><p class="text-left"><a class="ps-product--table " href="<?php echo $url; ?>"> <?php echo $item['name']; ?></a></p> <p class="text-left"> Size:<?php print_r($item['custom_options']['cartdata']['size']) ; ?></p></td>
  <td><?php echo CURRENCY_SYMBOL." ".number_format($item['price']); ?></td>
  <td><input type="number"  id="qty<?php echo $item['rowid']; ?>" class="form-control input-number" name="qty[]"  value="<?php echo $item['qty']; ?>" data-value="<?php echo $item['qty']; ?>" min="<?php echo $product_data[0]->min_order ?>" max="<?php echo $product_data[0]->max_order ?>" stock="<?php echo $stock ; ?>"></td>
  <td><strong> <?php echo CURRENCY_SYMBOL." ".number_format($item['subtotal']); ?></strong></td>

   <td class="align-middle text-right pr-5"><a href="<?php echo base_url('cart/remove_cart_item/'.$item['rowid']); ?>" class="d-block"><i class="fal fa-times text-body"></i></a></td>                                     
</tr>

<?php } ?>

