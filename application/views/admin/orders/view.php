<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice </title>
    <?php $this->load->view('admin/layout/head_css'); ?>
    <?php $this->load->view('admin/layout/tiny-mce'); ?>
    <style>
        @media print {
            a[href]:after {
                content: none !important;
            }
            #print_btn {
                display: none;
            }
        }
        .table-bordered {
    border: 1px solid #7e7272;
}
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #827d7d;
}

    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view('admin/layout/header'); ?>

        <?php $this->load->view('admin/layout/sidebar'); ?>
        <?php $link=$this->setting_model->get_all_setting();?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Order #<?php echo $ORDER[0]->order_no ?></h1>

                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active"><a href="<?php echo base_url('admin/orders/listing'); ?>">All Orders</a>
                    </li>

                </ol>
            </section>
            <section class="content">
                <!-- Info boxes -->
                <div class="box">
                    <div class="box-body">
                        <div class="box box-primary">
                            <div class="row" style="padding:10px 0px">
                                <div class="col-sm-6">
                                    <button class="btn btn-warning btn-update pull-right1" id="print_btn" onclick="return print_invoice('invoice_print'); " style="margin-bottom: 5px;">Print Invoice</button>
                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
             
                                <?php $user=$this->user_model->get_user_by_id($ORDER[0]->user_id); $shipping = $this->order_model->get_shipping_data($ORDER[0]->id); $billing = $this->order_model->get_billing_data($ORDER[0]->id); $items_data = $this->order_model->get_item_data($ORDER[0]->id); ?>
                                <?php $link=$this->setting_model->get_all_setting();?>

                                <div class="table-responsive order-tabel" id="invoice_print">
                                     <?php $data['ORDER'] = $ORDER; ?>
                	                <?php $this->load->view('invoice' , $data); ?>
                                </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('admin/layout/footer'); ?>
    </div>
    <!-- ./wrapper -->
    <?php $this->load->view('admin/layout/footer_js'); ?>
    <script class="example">
        function print_invoice(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
</body>

</html>