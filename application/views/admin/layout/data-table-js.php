<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<script>
  $(function () {
      $('#example1').dataTable({
          'iDisplayLength': 25
        });

   
  });
</script>
<script>
     $('#checkAll').click(function () {    
     $('input:checkbox').prop('checked', this.checked);    
 });
</script>