<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-commerce | Dashboard</title>
  <?php $this->load->view('admin/layout/head_css'); ?>	
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view('admin/layout/header'); ?>	
  
<?php $this->load->view('admin/layout/sidebar'); ?>	
  

  
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>Dashboard</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

   
    <section class="content">

      <?php
        // Chart series, oldest month first. Guarded so an empty orders table
        // renders an honest "no data yet" state instead of a broken canvas.
        $chartLabels = array(); $chartOrders = array(); $chartRevenue = array();
        foreach ((array) $CHART_ROWS as $r) {
            $chartLabels[]  = $r->label;
            $chartOrders[]  = (int) $r->orders;
            $chartRevenue[] = (float) $r->revenue;
        }
        $statusLabels = array(); $statusCounts = array();
        foreach ((array) $STATUS_ROWS as $r) {
            $statusLabels[] = $r->status !== '' ? $r->status : 'Unknown';
            $statusCounts[] = (int) $r->c;
        }
        $activeCount   = is_array($ACTIVE_USERS) ? count($ACTIVE_USERS) : 0;
        $inactiveCount = is_array($INACTIVE_USERS) ? count($INACTIVE_USERS) : 0;

        $custLabels = array(); $custCounts = array();
        foreach ((array) $CUSTOMER_ROWS as $r) { $custLabels[] = $r->label; $custCounts[] = (int) $r->signups; }

        $catLabels = array(); $catCounts = array();
        foreach ((array) $CATEGORY_ROWS as $r) { $catLabels[] = $r->label; $catCounts[] = (int) $r->total; }
      ?>

      <!-- ============================ STAT TILES ============================ -->
      <div class="row dx-stats">
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="dx-stat">
            <div class="dx-stat-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="dx-stat-label">Orders</div>
            <div class="dx-stat-value"><?php echo number_format($STAT_ORDERS); ?></div>
            <div class="dx-stat-sub">All time</div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="dx-stat">
            <div class="dx-stat-icon"><i class="fa fa-inr"></i></div>
            <div class="dx-stat-label">Revenue</div>
            <div class="dx-stat-value">&#8377; <?php echo number_format($STAT_REVENUE, 0); ?></div>
            <div class="dx-stat-sub">All time</div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="dx-stat">
            <div class="dx-stat-icon"><i class="fa fa-cube"></i></div>
            <div class="dx-stat-label">Products</div>
            <div class="dx-stat-value"><?php echo number_format($STAT_PRODUCTS); ?></div>
            <div class="dx-stat-sub">Live in catalogue</div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="dx-stat">
            <div class="dx-stat-icon"><i class="fa fa-users"></i></div>
            <div class="dx-stat-label">Customers</div>
            <div class="dx-stat-value"><?php echo number_format($STAT_USERS); ?></div>
            <div class="dx-stat-sub"><?php echo $activeCount; ?> active &middot; <?php echo $inactiveCount; ?> inactive</div>
          </div>
        </div>
      </div>

      <!-- ============================== CHARTS ============================== -->
      <div class="row">
        <div class="col-lg-8 col-xs-12">
          <div class="box">
            <div class="box-header"><h3 class="box-title">Orders &amp; revenue</h3>
              <span class="dx-box-sub">Last <?php echo max(count($chartLabels), 1); ?> month<?php echo count($chartLabels) === 1 ? '' : 's'; ?></span>
            </div>
            <div class="box-body">
              <?php if (count($chartLabels)) { ?>
                <canvas id="dxSalesChart" height="118"></canvas>
              <?php } else { ?>
                <p class="dx-empty">No orders recorded yet.</p>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <div class="box">
            <div class="box-header"><h3 class="box-title">Order status</h3></div>
            <div class="box-body">
              <?php if (count($statusLabels)) { ?>
                <canvas id="dxStatusChart" height="200"></canvas>
              <?php } else { ?>
                <p class="dx-empty">Nothing to chart yet.</p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-7 col-xs-12">
          <div class="box">
            <div class="box-header"><h3 class="box-title">Customer signups</h3>
              <span class="dx-box-sub">By month</span>
            </div>
            <div class="box-body">
              <?php if (count($custLabels)) { ?>
                <canvas id="dxCustomerChart" height="150"></canvas>
              <?php } else { ?><p class="dx-empty">No customers yet.</p><?php } ?>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-xs-12">
          <div class="box">
            <div class="box-header"><h3 class="box-title">Products by category</h3>
              <span class="dx-box-sub">Top <?php echo count($catLabels); ?></span>
            </div>
            <div class="box-body">
              <?php if (count($catLabels)) { ?>
                <canvas id="dxCategoryChart" height="<?php echo max(150, count($catLabels) * 30); ?>"></canvas>
              <?php } else { ?><p class="dx-empty">No categories yet.</p><?php } ?>
            </div>
          </div>
        </div>
      </div>

      <!-- =========================== RECENT ORDERS ========================== -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Recent orders</h3>
              <a href="<?php echo base_url('admin/orders/listing'); ?>" class="btn btn-primary pull-right">View all</a>
            </div>
            <div class="box-body table-responsive">
              <?php if (count((array) $RECENT_ORDERS)) { ?>
              <table class="table table-hover">
                <thead><tr><th>Order</th><th>Date</th><th>Status</th><th>Payment</th><th class="text-right">Amount</th></tr></thead>
                <tbody>
                <?php foreach ($RECENT_ORDERS as $o) { ?>
                  <tr>
                    <td><strong>#<?php echo htmlspecialchars($o->order_no, ENT_QUOTES); ?></strong></td>
                    <td><?php echo htmlspecialchars(date('d M Y', strtotime($o->create_date)), ENT_QUOTES); ?></td>
                    <td><span class="label label-success"><?php echo htmlspecialchars($o->status, ENT_QUOTES); ?></span></td>
                    <td><span class="label label-default"><?php echo htmlspecialchars($o->payment_status, ENT_QUOTES); ?></span></td>
                    <td class="text-right">&#8377; <?php echo number_format((float) $o->final_amount, 2); ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
              <?php } else { ?>
                <p class="dx-empty">No orders yet.</p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
      <script>
      (function () {
        if (typeof Chart === 'undefined') { return; }   // CDN blocked - tiles and table still render
        var rose = '#b04a63', roseSoft = 'rgba(176,74,99,.16)', plum = '#43303a', line = '#efe4e6', ink = '#5f5458';
        Chart.defaults.font.family = 'Urbanist, sans-serif';
        Chart.defaults.color = ink;

        var sales = document.getElementById('dxSalesChart');
        if (sales) {
          new Chart(sales, {
            type: 'bar',
            data: {
              labels: <?php echo json_encode($chartLabels); ?>,
              datasets: [
                { label: 'Revenue', data: <?php echo json_encode($chartRevenue); ?>,
                  backgroundColor: roseSoft, borderColor: rose, borderWidth: 1,
                  borderRadius: 6, yAxisID: 'y' },
                { label: 'Orders', data: <?php echo json_encode($chartOrders); ?>,
                  type: 'line', borderColor: plum, backgroundColor: plum,
                  tension: .35, pointRadius: 4, pointBackgroundColor: '#fff',
                  pointBorderWidth: 2, yAxisID: 'y1' }
              ]
            },
            options: {
              responsive: true, maintainAspectRatio: false,
              interaction: { mode: 'index', intersect: false },
              plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 16 } } },
              scales: {
                x:  { grid: { display: false }, border: { color: line } },
                y:  { position: 'left',  grid: { color: line }, border: { display: false },
                      ticks: { callback: function (v) { return '₹ ' + v; } } },
                y1: { position: 'right', grid: { display: false }, border: { display: false },
                      ticks: { precision: 0 } }
              }
            }
          });
        }

        var cust = document.getElementById('dxCustomerChart');
        if (cust) {
          new Chart(cust, {
            type: 'line',
            data: {
              labels: <?php echo json_encode($custLabels); ?>,
              datasets: [{
                label: 'Signups',
                data: <?php echo json_encode($custCounts); ?>,
                borderColor: rose, backgroundColor: roseSoft,
                fill: true, tension: .35,
                pointRadius: 4, pointBackgroundColor: '#fff',
                pointBorderColor: rose, pointBorderWidth: 2
              }]
            },
            options: {
              responsive: true, maintainAspectRatio: false,
              plugins: { legend: { display: false } },
              scales: {
                x: { grid: { display: false }, border: { color: line } },
                y: { grid: { color: line }, border: { display: false }, ticks: { precision: 0 } }
              }
            }
          });
        }

        var cat = document.getElementById('dxCategoryChart');
        if (cat) {
          new Chart(cat, {
            type: 'bar',
            data: {
              labels: <?php echo json_encode($catLabels); ?>,
              datasets: [{
                label: 'Products',
                data: <?php echo json_encode($catCounts); ?>,
                backgroundColor: roseSoft, borderColor: rose,
                borderWidth: 1, borderRadius: 6
              }]
            },
            options: {
              indexAxis: 'y',
              responsive: true, maintainAspectRatio: false,
              plugins: { legend: { display: false } },
              scales: {
                x: { grid: { color: line }, border: { display: false }, ticks: { precision: 0 } },
                y: { grid: { display: false }, border: { color: line } }
              }
            }
          });
        }

        var status = document.getElementById('dxStatusChart');
        if (status) {
          new Chart(status, {
            type: 'doughnut',
            data: {
              labels: <?php echo json_encode($statusLabels); ?>,
              datasets: [{
                data: <?php echo json_encode($statusCounts); ?>,
                backgroundColor: [rose, plum, '#d99bab', '#8f3a4f', '#c9b3ba'],
                borderColor: '#fff', borderWidth: 3
              }]
            },
            options: {
              responsive: true, maintainAspectRatio: false, cutout: '62%',
              plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 14 } } }
            }
          });
        }
      })();
      </script>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->  
<?php $this->load->view('admin/layout/footer'); ?>
</div>
<!-- ./wrapper -->
<?php $this->load->view('admin/layout/footer_js'); ?>

</body>
</html>
