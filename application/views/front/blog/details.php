<?php error_reporting() ; ?>
<?php $link = $this->setting_model->get_all_setting();?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php  echo $RESULT[0]->meta_title ; ?></title>
<meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
<meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
<?php $this->load->view('front/layout/head'); ?>
</head>
<body>
<?php $this->load->view('front/layout/header-2'); ?>
<div class="blog-area margin-top-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="blog-content">
                         <h2 ><?php echo $RESULT[0]->title; ?></h2>
                         <div class="blog-date"><i class="fa fa-calendar"></i> <?php echo  date('d-M-Y' , strtotime($RESULT[0]->date)); ?></div>
                         <br>
                         <center> <img src="<?php echo base_url('uploads/blogs/').$RESULT[0]->image; ?>" alt="<?php echo $RESULT[0]->img_tag; ?>" style="width:80%"></center>
                        <div class="text-justify">
                             <?php echo $RESULT[0]->description; ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- article area start  -->
    <div class="article-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-02 margin-bottom-30 text-center">
                        <h6>FASHION FOR ALL</h6>
                        <h3>LATEST BLOG</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if(count($blog)>0){?>
                <?php foreach($blog as $row ){?>
                    <?php $data['row'] = $row ; ?>
                    <?php $this->load->view('front/blog/list-view' ,$data); ?>
                <?php } ?>
                <?php } ?>
               
            </div>
        </div>
    </div>
    <!-- article area end  -->
     <?php $this->load->view('front/layout/footer-js');?>
    </body>

</html>
