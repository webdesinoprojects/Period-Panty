
    <h2><?php echo $RESULT[0]->title; ?> </h2>
    <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data" action="<?php echo base_url('admin/product/editProductProcess') ;  ?>">
        <div class="box-body row">
            <input type="hidden" name="product_id" value="<?php echo $RESULT[0]->id; ?>">
            <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Price</label>
                <input type="number" class="form-control" onblur="pricediscount()" name="price" id="price" value="<?php echo $RESULT[0]->price; ?>">
                <?php echo form_error( 'price'); ?>
            </div>
            <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Discount %</label>
                <input type="number" class="form-control" name="discount" onblur="pricediscount()" id="perdiscount" value="<?php echo $RESULT[0]->discount; ?>">
                <?php echo form_error( 'discount'); ?> 
            </div>
            <div class="form-group col-sm-4">
                <label for="exampleInputEmail1">Special Price</label>
                <input type="number"  readonly="" class="form-control" name="special_price" id="special_price" value="<?php echo $RESULT[0]->special_price; ?>">
                <?php echo form_error( 'special_price'); ?>
            </div>
           
            <div class="form-group col-sm-6 ">
                <label>Color Option</label>
                   
             
                    <?php $color = $this->product_model->get_all_active_color() ;  ?>
                    
                    <select class="form-control" name="color" required>
                        <option value="">Select</option>
                        <?php foreach($color as $value){ ?>
                        <option value="<?php echo $value->code ; ?>" <?php echo($RESULT[0]->color==$value->code)?'selected':''; ?>><?php echo $value->title ; ?></option>
                        <?php } ?>
                    </select>

            </div>
       
            <div class="form-group col-sm-2 ">
                <label for="exampleInputPassword1"> Featured?hot ?</label>
                <select class="form-control" name="is_featured" required>
                    <option value="">--Select--</option>
                    <option value='yes' <?php echo($RESULT[0]->is_featured=='yes')?'selected':''; ?> >Yes</option>
                    <option value='no' <?php echo($RESULT[0]->is_featured=='no')?'selected':''; ?> >No</option>
                </select>
                <?php echo form_error( 'is_featured'); ?> 
            </div>
        
            <div class="form-group col-sm-2">
                <label for="exampleInputPassword1">Status</label>
                <select class="form-control" name="status" required>
                    <option value='1' <?php echo($RESULT[0]->status=='1')?'selected':''; ?>>Active</option>
                    <option value='0' <?php echo($RESULT[0]->status=='0')?'selected':''; ?>>Inactive</option>
                </select>
                <?php echo form_error( 'status'); ?>
             </div> 
        </div>
        <div class="box-footer">
            <button type="Submit" class="btn btn-primary" name="submitform">Submit</button>
        </div>
    </form>


