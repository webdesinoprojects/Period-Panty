
<div class="mfp-hide search-popup mfp-with-anim" id="search-popup">
    <form  action="<?php echo base_url('product/search') ?>" method="get" >
        <div class="input-group position-relative">
        
            <input type="text" id="keyword" required name="search" class="form-control border-0 border-bottom border-2x bg-transparent text-white border-white fs-24 form-control-lg" placeholder="Search Something...">
            <div class="input-group-append position-absolute pos-fixed-right-center">
                <button class="input-group-text bg-transparent border-0 text-white fs-30 px-0 btn-lg" type="submit"><i class="far fa-search"></i></button>
            </div>
        </div>
    </form>
</div>