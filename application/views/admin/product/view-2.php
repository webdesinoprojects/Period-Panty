  <?php $age_group = $this->product_model->get_all_active_age_group() ;  ?>
    <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data" action="<?php echo base_url('admin/product/editProductProcess2') ;  ?>">
        <div class="box-body row">
            <input type="hidden" name="rowid" value="<?php echo $RESULT[0]->id; ?>">
            <input type="hidden" name="product_id" value="<?php echo $RESULT[0]->product_id; ?>">
           
       
             <div class="form-group col-sm-4">
                <label>Size Option</label>
                   <?php $size = $this->product_model->get_all_active_size() ;  ?>
                 <select class="form-control" name="size" required>
                    <option value="">Select</option>
                    <?php foreach($size as $value){ ?>
                    <option value="<?php echo $value->title ; ?>" <?php echo($RESULT[0]->size==$value->title)?'selected':''; ?>><?php echo $value->title ; ?></option>
                    <?php } ?>
                </select>

            </div>
             <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Sku</label>
                <input type="text" class="form-control" name="sku"  value="<?php echo $RESULT[0]->sku; ?>" required placeholder="Enter sku">
                <?php echo form_error( 'sku'); ?>
            </div>
            <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Qty</label>
                <input type="number" class="form-control" name="qty" id="qty" min="0" value="<?php echo $RESULT[0]->qty; ?>">
                <?php echo form_error( 'qty'); ?>
            </div>
        </div>
        <div class="box-footer">
            <button type="Submit" class="btn btn-primary" name="submitform">Submit</button>
        </div>
    </form>


