
    <div class="article-style-01" style="">
        <div style="padding:5px">
             <div class="thumb">
            <img src="<?php echo base_url('uploads/blogs/').$row->thumb_image; ?>" alt="<?php echo $row->img_tag; ?>">
            <span class="tag tag-green"> <?php echo $row->cat_title; ?> </span>
        </div>
        <div class="content">
            <span class="date"><?php echo  date('d-M-Y' , strtotime($row->date)); ?> </span>
            <h3> <a href="<?php echo base_url('blog/'.$row->url_slug) ?>" class="blog-title">
                <?php echo $row->title; ?></a></h3>
           
            <div class="btn-wrapper">
                <a href="<?php echo base_url('blog/'.$row->url_slug) ?>" class="btn">View more</a>
            </div>
        </div>
        </div>
       
    </div>

                
          