<?php $link = $this->setting_model->get_all_setting();?>
<footer class="main-footer">    
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href=""> <?php echo $link[0]->title ;  ?></a>.</strong> All rights
    reserved.
  </footer>