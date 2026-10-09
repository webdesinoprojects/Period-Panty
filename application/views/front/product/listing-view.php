<?php $product_images = $this->product_model->select_product_images($product->id); ?>
<?php  $url = $this->product_model->get_product_url($product->id) ; ?>
<?php
/**
 * Product card.
 *
 * Laid out against the reference: ribbon hanging from the top-right, photo in
 * an outlined frame, title, then a row with the price large on the left and
 * the absorbency drops on the right, then a full-bleed Add to Cart bar.
 *
 * The accent is read from tbl_products.color, which now holds the dominant
 * colour sampled from each product's own photo rather than the #000000 the
 * catalogue shipped with. Neutral garments - a good part of the range is
 * black - get a warm grey keyed to their lightness, because pairing them with
 * an unrelated pastel is what made the cards look disconnected from the
 * product.
 *
 * Declared with function_exists because this view is included once per product
 * inside a loop, and a bare declaration would fatal on the second card.
 */
if (!function_exists('dx_card_palette')) {
    function dx_card_palette($hex)
    {
        $hex = ltrim(trim((string) $hex), '#');
        if (strlen($hex) === 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
        if (strlen($hex) !== 6 || !ctype_xdigit($hex)) { return array('#ece6de', '#6f675f'); }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        if (max($r, $g, $b) - min($r, $g, $b) < 38) {
            $lum = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
            return $lum < 0.55 ? array('#e8e5e1', '#3a3734') : array('#f3efe8', '#8a8077');
        }

        return array(
            sprintf('#%02x%02x%02x',
                (int) round($r + (255 - $r) * .86),
                (int) round($g + (255 - $g) * .86),
                (int) round($b + (255 - $b) * .86)),
            sprintf('#%02x%02x%02x',
                (int) round($r * .78), (int) round($g * .78), (int) round($b * .78))
        );
    }
}
list($dx_tint, $dx_accent) = dx_card_palette(isset($product->color) ? $product->color : '');
$dx_motif = abs((int) $product->id) % 5;
?>

        <div class="card border-0 product dx-pcard" style="--dx-tint: <?php echo $dx_tint; ?>; --dx-acc: <?php echo $dx_accent; ?>;">

            <!-- Hangs from the card's top edge, so it sits outside the photo
                 frame - inside it the frame's overflow clipped it. -->
            <span class="dx-pcard-ribbon" aria-hidden="true"></span>

            <div class="position-relative">

                <a href="<?php echo $url ?>">
                        <?php if($product_images){ ?>
                         <img src="<?php echo base_url('uploads/product/'.$product_images[0]->image); ?>" class="main-image" alt="<?php echo $product->title; ?>">
                         <?php }else{  ?>
                         <img src="<?php echo base_url('images/1215BP6.png'); ?>" alt="<?php echo $product->title; ?>" class="main-image">
                         <?php } ?>
                </a>

                <div class="card-img-overlay d-flex p-3">
                      <?php if($product->discount){ ?>
                       <div><span class="badge badge-primary"><?php echo(int)$product->discount; ?>% Off</span></div>
                    <?php } ?>

                <div class="my-auto w-100 content-change-vertical">
                  <a href="<?php echo $url ?>" data-toggle="tooltip" data-placement="left" title="View products" class="add-to-cart ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                    <svg class="icon icon-shopping-bag-open-light fs-24">
                      <use xlink:href="#icon-shopping-bag-open-light"></use>
                    </svg>
                  </a>

                  <a href="javascript:void(0)"   data-id="<?php echo $product->id; ?>"  data-toggle="tooltip" data-placement="left" title="Add to wishlist" class="wishlist-add add-to-wishlist ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                    <svg class="icon icon-star-light fs-24">
                      <use xlink:href="#icon-star-light"></use>
                    </svg>
                  </a>

                </div>
              </div>
            </div>

            <div class="card-body pt-4 text-center px-0">

              <!-- One of five brand motifs, picked from the product id so a
                   given product always draws the same one. -->
              <svg class="dx-pcard-motif" viewBox="0 0 48 48" fill="none" stroke="currentColor"
                   stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <?php if ($dx_motif === 0) { ?>
                  <path d="M24 44V14"/><path d="M24 26c0-7 5-12 12-12 0 7-5 12-12 12Z"/><path d="M24 36c0-7-5-12-12-12 0 7 5 12 12 12Z"/>
                <?php } elseif ($dx_motif === 1) { ?>
                  <path d="M24 6s11 12 11 20a11 11 0 0 1-22 0C13 18 24 6 24 6Z"/>
                <?php } elseif ($dx_motif === 2) { ?>
                  <circle cx="24" cy="24" r="5"/><path d="M24 19c0-6-4-10-4-10s8 1 8 5M29 24c6 0 10-4 10-4s-1 8-5 8M24 29c0 6 4 10 4 10s-8-1-8-5M19 24c-6 0-10 4-10 4s1-8 5-8"/>
                <?php } elseif ($dx_motif === 3) { ?>
                  <circle cx="18" cy="20" r="7"/><circle cx="30" cy="26" r="6"/><path d="M24 44c0-8-2-13-6-17"/>
                <?php } else { ?>
                  <path d="M6 20c6-6 12-6 18 0s12 6 18 0M6 30c6-6 12-6 18 0s12 6 18 0"/>
                <?php } ?>
              </svg>

              <h2 class="card-title fs-20 font-weight-500 mt-0"><a href="<?php echo $url ?>"><?php echo $product->title; ?></a> </h2>

              <!-- Price large on the left, absorbency on the right, the way the
                   reference pairs price with its rating. -->
              <div class="dx-card-foot">
                <p class="card-text font-weight-bold fs-16 mb-1 text-secondary">
                    <?php if($product->special_price !='0.00'){ ?>
                  <span class="fs-15 font-weight-500 text-decoration-through text-body pr-1"> <?php echo CURRENCY_SYMBOL." ".round($product->price); ?></span>
                   <span> <?php echo CURRENCY_SYMBOL." ".round($product->special_price); ?></span>
                      <?php }else{ ?>
                  <span> <?php echo CURRENCY_SYMBOL." ".round($product->price); ?></span>
                    <?php }?>
                </p>

                <div class="d-flex align-items-center justify-content-center flex-wrap dx-card-spec">
                  <ul class="list-inline mb-0 lh-1">
                  <?php for ($x = 1; $x <= $product->absorbency_rate; $x++) { ?>
                    <li class="list-inline-item fs-14 text-primary mr-0">
                      <i class="fas fa-tint"></i>
                    </li>
                  <?php } ?>
                    <?php $diff = 5-$product->absorbency_rate ; ?>
                    <?php for ($x = 1; $x <= $diff; $x++) { ?>
                    <li class="list-inline-item fs-14 text-primary mr-0">
                      <i class="text-drops far fa-tint"></i>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>

            </div>

            <!-- Outside .card-body so it can run the full width of the card.
                 Same destination as the hover bag icon: a size has to be
                 chosen on the product page before anything enters the basket,
                 so nothing new is wired up here. -->
            <a href="<?php echo $url ?>" class="dx-add-btn dx-pcard-cta">Add to Cart</a>

          </div>
