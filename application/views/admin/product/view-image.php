
    <form role="form" method="post" id="form" autocomplete="off" enctype="multipart/form-data" action="<?php echo base_url('admin/product/editProductImageProcess') ;  ?>">
        <div class="box-body row">
            <div class="col-sm-6">
                  <img src="<?php echo base_url('uploads/product/'.$RESULT[0]->image); ?>" alt="Product Image" style="width :100%"> 
            </div> 
            <div class="col-sm-6">
                <div class="row">
                     <input type="hidden" name="product_id" value="<?php echo $RESULT[0]->product_id; ?>">
            <input type="hidden" name="image_id" value="<?php echo $RESULT[0]->id; ?>">
            <div class="form-group col-sm-12">
                <label for="exampleInputEmail1">Image Tag</label>
                <input type="file" class="form-control" name="image[]" >
               
            </div> 
            <div class="form-group col-sm-12">
                <label for="exampleInputEmail1">Image Tag</label>
                <input type="title" class="form-control" name="img_tag" value="<?php echo $RESULT[0]->img_tag; ?>">
                <?php echo form_error( 'price'); ?>
            </div>
            <div class="form-group col-sm-12">
                <label for="exampleInputEmail1">Position</label>
                <input type="number" class="form-control" name="position" value="<?php echo $RESULT[0]->position; ?>">
                <?php echo form_error( 'position'); ?> 
            </div>
            <div class="form-group col-sm-12">
                <button type="Submit" class="btn btn-primary" name="submitform">Submit</button> 
            </div>

                </div>
            </div>
           
        </div>
   
    </form>


