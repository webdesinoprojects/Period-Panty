<?php
/**
 * Angled ticker band used to separate homepage sections.
 *
 * Optional variables before including:
 *   $dx_ticker_dir   'left' (default) or 'right' - tilt direction
 *   $dx_ticker_tone  'rose' (default) or 'ink'   - colour of the band
 *
 * The phrases below are claims already made elsewhere on this site
 * (reusable, leak-proof, eco-friendly, 360 anti-leak, absorbency) - nothing
 * new is asserted here.
 *
 * Pure CSS animation, no JS, and it stops under prefers-reduced-motion.
 */
$dir  = isset($dx_ticker_dir)  ? $dx_ticker_dir  : 'left';
$tone = isset($dx_ticker_tone) ? $dx_ticker_tone : 'rose';

$dx_ticker_items = array(
    'Reusable',
    'Leak-Proof',
    'Eco-Friendly',
    '360&deg; Anti-Leak',
    'Super Absorbent',
    'Skin-Friendly',
);
?>
<div class="dx-ticker dx-ticker-<?php echo $dir; ?> dx-ticker-<?php echo $tone; ?>" aria-hidden="true">
  <div class="dx-ticker-track">
    <?php /* Rendered twice so the loop joins seamlessly at the halfway point. */ ?>
    <?php for ($pass = 0; $pass < 2; $pass++) { ?>
      <?php foreach ($dx_ticker_items as $item) { ?>
        <span class="dx-ticker-item"><?php echo $item; ?></span>
        <span class="dx-ticker-dot">
          <svg width="14" height="18" viewBox="0 0 14 18" fill="none" focusable="false">
            <path d="M7 1C7 1 1 8.2 1 11.6A6 6 0 0 0 13 11.6C13 8.2 7 1 7 1Z" fill="currentColor"/>
          </svg>
        </span>
      <?php } ?>
    <?php } ?>
  </div>
</div>
