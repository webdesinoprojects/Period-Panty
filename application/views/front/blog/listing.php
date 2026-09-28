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
<link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
<?php $this->load->view('front/layout/head'); ?>
</head>
<body>
<?php $this->load->view('front/layout/header-2'); ?>

    <!-- article area start  -->
    <div class="article-area margin-top-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-02 margin-bottom-30 text-center">
                        <h6>FASHION FOR ALL</h6>
                        <h3><?php  echo $RESULT[0]->title ; ?></h3>
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

  <?php $this->load->view('front/layout/footer-js'); ?>
</body>
</html>
