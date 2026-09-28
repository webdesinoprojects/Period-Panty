<?php $link = $this->setting_model->get_all_setting();?>
<?php if($link[0]->favicon ){ ?>
<link rel=icon href="<?php echo base_url('uploads/').$link[0]->favicon ?>" sizes="20x20" type="image/png"> 
<?php } ?>
 <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"  rel="stylesheet">
 <!-- Serif used for the footer column headings only (UI rehaul). -->
 <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/fontawesome-pro-5/css/all.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/bootstrap-select/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/slick/slick.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/magnific-popup/magnific-popup.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/animate.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/mapbox-gl/mapbox-gl.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/fonts/font-phosphor/css/phosphor.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/fonts/tuesday-night/stylesheet.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/fonts/butler/stylesheet.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>vendors/fonts/a-antara-distance/stylesheet.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>css/themes.css">
<!-- UI rehaul phase 1 (typography + spacing). Must stay after themes.css. -->
<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>css/rehaul.css">
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11183006313"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-11183006313');
  
  
</script>


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M3HVZG4');</script>
<!-- End Google Tag Manager -->