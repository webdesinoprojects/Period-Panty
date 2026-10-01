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
<?php $this->load->view('front/layout/header'); ?>

<?php
/**
 * Account dashboard.
 *
 * The figures below are read straight from the models the way listing-view.php
 * and my_orders.php already do - order_model and product_model are autoloaded,
 * so no controller change was needed and nothing new is wired up. Every link
 * points where the old gradient buttons pointed.
 */
$dx_uid     = $this->session->userdata('USER_ID');
$dx_orders  = $this->order_model->get_user_order($dx_uid);
$dx_wish    = $this->product_model->get_user_wishlist($dx_uid);

$dx_total_orders = count($dx_orders);
$dx_wish_count   = count($dx_wish);
$dx_delivered    = 0;
$dx_spent        = 0;
$dx_by_month     = array();

foreach ($dx_orders as $dx_o) {
    if (strtolower($dx_o->status) === 'delivered') { $dx_delivered++; }
    if (strtolower($dx_o->status) !== 'cancelled') {
        $dx_spent += (float) $dx_o->final_amount;
        $dx_k = date('Y-m', strtotime($dx_o->create_date));
        $dx_by_month[$dx_k] = (isset($dx_by_month[$dx_k]) ? $dx_by_month[$dx_k] : 0) + (float) $dx_o->final_amount;
    }
}

/* Last six months, oldest first, so the strip reads left to right. */
$dx_months = array();
for ($dx_i = 5; $dx_i >= 0; $dx_i--) {
    $dx_k = date('Y-m', strtotime("-$dx_i month"));
    $dx_months[$dx_k] = isset($dx_by_month[$dx_k]) ? $dx_by_month[$dx_k] : 0;
}
$dx_peak = max(array_values($dx_months));

$dx_u     = isset($user[0]) ? $user[0] : null;
$dx_fname = $dx_u && !empty($dx_u->fname) ? $dx_u->fname : 'there';
$dx_since = $dx_u && !empty($dx_u->create_date) ? date('F Y', strtotime($dx_u->create_date)) : '';
?>


<div class="dx-acct pt-9 pb-9">
  <div class="container">
    <div class="row">

      <div class="col-lg-3 mb-5 mb-lg-0">
        <?php $this->load->view('front/account/left-menu'); ?>
      </div>

      <div class="col-lg-9">

        <div class="dx-acct-head">
          <div>
            <h1 class="dx-acct-title">Hello, <?php echo ucwords($dx_fname); ?></h1>
            <p class="dx-acct-sub">
              Here's what's happening with your account<?php if ($dx_since) { ?> &middot; member since <?php echo $dx_since; ?><?php } ?>.
            </p>
          </div>
          <a href="<?php echo base_url('shop'); ?>" class="dx-acct-cta">Continue shopping</a>
        </div>

        <div class="dx-stat-row">
          <a class="dx-stat" href="<?php echo base_url('user/my_orders'); ?>">
            <span class="dx-stat-ico"><i class="far fa-box"></i></span>
            <span class="dx-stat-n"><?php echo $dx_total_orders; ?></span>
            <span class="dx-stat-l">Orders placed</span>
          </a>
          <div class="dx-stat">
            <span class="dx-stat-ico"><i class="far fa-check-circle"></i></span>
            <span class="dx-stat-n"><?php echo $dx_delivered; ?></span>
            <span class="dx-stat-l">Delivered</span>
          </div>
          <a class="dx-stat" href="<?php echo base_url('user/wishlist'); ?>">
            <span class="dx-stat-ico"><i class="far fa-heart"></i></span>
            <span class="dx-stat-n"><?php echo $dx_wish_count; ?></span>
            <span class="dx-stat-l">Saved items</span>
          </a>
          <div class="dx-stat">
            <span class="dx-stat-ico"><i class="far fa-wallet"></i></span>
            <span class="dx-stat-n"><?php echo CURRENCY_SYMBOL . ' ' . number_format($dx_spent); ?></span>
            <span class="dx-stat-l">Total spent</span>
          </div>
        </div>

        <div class="row">
          <div class="col-xl-7 mb-4">
            <div class="dx-panel h-100">
              <div class="dx-panel-head">
                <h2 class="dx-panel-title">Recent orders</h2>
                <?php if ($dx_total_orders) { ?>
                  <a href="<?php echo base_url('user/my_orders'); ?>" class="dx-panel-link">View all</a>
                <?php } ?>
              </div>

              <?php if ($dx_total_orders) { ?>
                <ul class="dx-order-list">
                  <?php foreach (array_slice($dx_orders, 0, 4) as $dx_o) { ?>
                    <li>
                      <a href="<?php echo base_url('user/view_order/' . $dx_o->order_no); ?>" class="dx-order-row">
                        <span class="dx-order-main">
                          <strong>#<?php echo $dx_o->order_no; ?></strong>
                          <span class="dx-order-date"><?php echo date('d M Y', strtotime($dx_o->create_date)); ?></span>
                        </span>
                        <span class="dx-order-right">
                          <span class="dx-order-amt"><?php echo CURRENCY_SYMBOL . ' ' . round($dx_o->final_amount); ?></span>
                          <span class="dx-chip dx-chip-<?php echo strtolower(str_replace(' ', '-', $dx_o->status)); ?>"><?php echo $dx_o->status; ?></span>
                        </span>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              <?php } else { ?>
                <div class="dx-empty">
                  <i class="far fa-box-open"></i>
                  <p>No orders yet. When you place one it will show up here.</p>
                  <a href="<?php echo base_url('shop'); ?>" class="dx-acct-cta">Start shopping</a>
                </div>
              <?php } ?>
            </div>
          </div>

          <div class="col-xl-5 mb-4">
            <div class="dx-panel h-100">
              <div class="dx-panel-head">
                <h2 class="dx-panel-title">Spending</h2>
                <span class="dx-panel-note">Last 6 months</span>
              </div>

              <?php if ($dx_peak > 0) { ?>
                <div class="dx-spark" role="img" aria-label="Monthly spend for the last six months">
                  <?php foreach ($dx_months as $dx_k => $dx_v) { ?>
                    <div class="dx-spark-col">
                      <div class="dx-spark-bar" style="height: <?php echo $dx_v > 0 ? max(6, round($dx_v / $dx_peak * 100)) : 2; ?>%"
                           title="<?php echo date('M Y', strtotime($dx_k . '-01')) . ': ' . CURRENCY_SYMBOL . ' ' . round($dx_v); ?>"></div>
                      <span class="dx-spark-lab"><?php echo date('M', strtotime($dx_k . '-01')); ?></span>
                    </div>
                  <?php } ?>
                </div>
              <?php } else { ?>
                <div class="dx-empty dx-empty-sm">
                  <i class="far fa-chart-bar"></i>
                  <p>Your spending will chart here once you've placed an order.</p>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="dx-panel">
          <div class="dx-panel-head">
            <h2 class="dx-panel-title">Contact &amp; address</h2>
            <a href="<?php echo base_url('user/edit_profile'); ?>" class="dx-panel-link">Edit</a>
          </div>
          <?php if ($dx_u) { ?>
            <dl class="dx-deflist">
              <div><dt>Name</dt><dd><?php echo ucwords(trim($dx_u->fname . ' ' . $dx_u->lname)); ?></dd></div>
              <div><dt>Email</dt><dd><?php echo $dx_u->email; ?></dd></div>
              <div><dt>Phone</dt><dd><?php echo $dx_u->contact_no ? $dx_u->contact_no : '<span class="dx-muted">Not added</span>'; ?></dd></div>
              <div><dt>Address</dt>
                <dd>
                  <?php
                    $dx_addr = array_filter(array($dx_u->address, $dx_u->landmark, $dx_u->city, $dx_u->state, $dx_u->pincode, $dx_u->country));
                    echo $dx_addr ? implode(', ', $dx_addr) : '<span class="dx-muted">Not added</span>';
                  ?>
                </dd>
              </div>
            </dl>
          <?php } ?>
        </div>

      </div>
    </div>
  </div>
</div>

<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>

</body>
</html>
