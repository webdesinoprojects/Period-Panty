<?php
/**
 * Account sidebar.
 *
 * Every account page already includes this in a col-sm-3, so rewriting it here
 * restyles the whole panel at once. The six destinations are unchanged - same
 * base_url() targets as the gradient buttons this replaces - only the markup
 * and the active state are new.
 *
 * tbl_users has no avatar column (change_avatar is vestigial), so the identity
 * block uses a monogram built from the initials, the same approach as the
 * admin sidebar.
 *
 * $user is passed by profile(), my_orders() and wishlist() but not by every
 * action, so it is read defensively - a missing name must not fatal the page.
 */
$dx_u     = isset($user[0]) ? $user[0] : null;
$dx_fname = $dx_u && !empty($dx_u->fname) ? $dx_u->fname : '';
$dx_lname = $dx_u && !empty($dx_u->lname) ? $dx_u->lname : '';
$dx_name  = trim($dx_fname . ' ' . $dx_lname);
if ($dx_name === '') { $dx_name = 'My account'; }
$dx_mail  = $dx_u && !empty($dx_u->email) ? $dx_u->email : '';

$dx_initials = strtoupper(substr($dx_fname, 0, 1) . substr($dx_lname, 0, 1));
if (trim($dx_initials) === '') { $dx_initials = strtoupper(substr($dx_name, 0, 1)); }

/* uri segment 2 is the controller method: user/profile, user/my_orders, ... */
$dx_here = $this->uri->segment(2);

$dx_nav = array(
    array('profile',         'user/profile',         'far fa-th-large',   'Dashboard'),
    array('my_orders',       'user/my_orders',       'far fa-box',        'My Orders'),
    array('wishlist',        'user/wishlist',        'far fa-heart',      'Wishlist'),
    array('edit_profile',    'user/edit_profile',    'far fa-user-edit',  'Edit Profile'),
    array('change_password', 'user/change_password', 'far fa-lock-alt',   'Change Password'),
);
?>
<aside class="dx-acct-nav">

  <div class="dx-acct-ident">
    <span class="dx-acct-avatar" aria-hidden="true"><?php echo $dx_initials; ?></span>
    <div class="dx-acct-ident-text">
      <strong class="dx-acct-name"><?php echo ucwords($dx_name); ?></strong>
      <?php if ($dx_mail) { ?><span class="dx-acct-mail"><?php echo $dx_mail; ?></span><?php } ?>
    </div>
  </div>

  <nav class="dx-acct-links" aria-label="Account">
    <?php foreach ($dx_nav as $dx_item) { ?>
      <a href="<?php echo base_url($dx_item[1]); ?>"
         class="dx-acct-link<?php echo ($dx_here === $dx_item[0]) ? ' is-active' : ''; ?>"
         <?php echo ($dx_here === $dx_item[0]) ? 'aria-current="page"' : ''; ?>>
        <i class="<?php echo $dx_item[2]; ?>" aria-hidden="true"></i>
        <span><?php echo $dx_item[3]; ?></span>
      </a>
    <?php } ?>
  </nav>

  <a href="<?php echo base_url('user/logout'); ?>" class="dx-acct-link dx-acct-logout">
    <i class="far fa-sign-out" aria-hidden="true"></i>
    <span>Logout</span>
  </a>

</aside>
