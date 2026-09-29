<?php
/**
 * Filter panel.
 *
 * The previous version of this file was a static theme mockup: every control
 * was an <a href="#"> with no value and no handler, which is why clicking any
 * of them did nothing and the status bar showed "shop#". The endpoint at
 * product/pagination already accepted cat_id, price, size, color and sorting -
 * there was simply nothing on the page producing them.
 *
 * These controls emit exactly what that endpoint parses:
 *   cat_id  single value, used with where_in on product.cat_id
 *   price   "Rs.MIN-Rs.MAX", split on '-' then on 'Rs.'
 *   size    single value, matched against product_variation.size
 *   color   array, matched with where_in against product.color (hex values)
 *
 * getresult() reads .price and .cat_id with .val(), so those are single
 * <select> elements rather than lists of links; size is a radio group and
 * colour a checkbox group, which is what its selectors expect.
 */

$dx_url = isset($load_url) ? $load_url : base_url('product/pagination');

// get_all_child_category_by_parent_id() selects only id - it exists to gather
// descendant ids, not to display names - and get_category_by_parent() filters
// on home_display, which would hide categories from the filter. Query directly.
$dx_cats = $this->db->select('id, title')
                    ->from('tbl_categories')
                    ->where('status', '1')
                    ->where('parent_id', 0)
                    ->order_by('title', 'ASC')
                    ->get()->result();
$dx_sizes  = array('XS','S','M','L','XL','XXL','XXXL','XXXXL');

// Ranges span the real catalogue, which runs 645 to 1150.
$dx_prices = array(
    // Starts at 1, not 0: the endpoint guards with if($starting_price), and
    // PHP treats the string "0" as falsy, so a Rs.0 lower bound silently
    // disabled the whole price filter and returned every product.
    'Rs.1-Rs.699'    => 'Under 700',
    'Rs.700-Rs.899'  => '700 - 899',
    'Rs.900-Rs.1099' => '900 - 1099',
    'Rs.1100-Rs.99999' => '1100 and above',
);

$dx_colors = $this->db->select('DISTINCT(color) AS color', FALSE)
                      ->from('tbl_products')
                      ->where('delete_flag', '0')
                      ->where('status', '1')
                      ->where("color <> ''", NULL, FALSE)
                      ->get()->result();
?>
<div class="canvas-sidebar filter-canvas">
    <div class="canvas-overlay"></div>
    <div class="card border-0 px-6 overflow-y-auto bg-white h-100 pb-6">

        <div class="card-header bg-transparent py-0 border-0">
            <div class="text-right pb-7">
                <span class="canvas-close d-inline-block text-right fs-24 pt-2 mr-n6 text-secondary"><i class="fal fa-times"></i></span>
            </div>
            <h4 class="fs-34 mb-0">Filter</h4>
        </div>

        <div class="card-body">

            <!-- Category -->
            <div class="card border-0 mb-6">
                <div class="card-header bg-transparent border-0 p-0">
                    <h4 class="card-title fs-20 mb-3">Category</h4>
                </div>
                <select class="cat_id dx-filter-select">
                    <option value="">All categories</option>
                    <?php foreach ($dx_cats as $c) { ?>
                        <option value="<?php echo (int) $c->id; ?>"><?php echo htmlspecialchars($c->title, ENT_QUOTES); ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Price -->
            <div class="card border-0 mb-6">
                <div class="card-header bg-transparent border-0 p-0">
                    <h4 class="card-title fs-20 mb-3">Price</h4>
                </div>
                <select class="price dx-filter-select">
                    <option value="">Any price</option>
                    <?php foreach ($dx_prices as $val => $label) { ?>
                        <option value="<?php echo $val; ?>"><?php echo CURRENCY_SYMBOL . ' ' . $label; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Size -->
            <div class="card border-0 mb-6">
                <div class="card-header bg-transparent border-0 p-0">
                    <h4 class="card-title fs-20 mb-3">Size</h4>
                </div>
                <div class="dx-chip-group">
                    <?php foreach ($dx_sizes as $i => $sz) { ?>
                        <input type="radio" name="size" id="dx-size-<?php echo $i; ?>" value="<?php echo $sz; ?>" class="dx-chip-input">
                        <label class="dx-chip" for="dx-size-<?php echo $i; ?>"><?php echo $sz; ?></label>
                    <?php } ?>
                </div>
            </div>

            <!-- Colour -->
            <div class="card border-0 mb-6">
                <div class="card-header bg-transparent border-0 p-0">
                    <h4 class="card-title fs-20 mb-3">Colour</h4>
                </div>
                <div class="dx-swatch-group">
                    <?php foreach ($dx_colors as $i => $c) {
                        $hex = trim($c->color);
                        if ($hex === '') { continue; } ?>
                        <input type="checkbox" name="color[]" id="dx-color-<?php echo $i; ?>" value="<?php echo htmlspecialchars($hex, ENT_QUOTES); ?>" class="dx-swatch-input">
                        <label class="dx-swatch" for="dx-color-<?php echo $i; ?>"
                               style="background: <?php echo htmlspecialchars($hex, ENT_QUOTES); ?>;"
                               title="<?php echo htmlspecialchars($hex, ENT_QUOTES); ?>">
                            <span class="sr-only"><?php echo htmlspecialchars($hex, ENT_QUOTES); ?></span>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <div class="dx-filter-actions">
                <button type="button" class="dx-filter-apply" id="dx-apply-filter">Show results</button>
                <button type="button" class="dx-filter-clear" id="clearall">Clear all</button>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    var URL_FOR_FILTERS = "<?php echo $dx_url; ?>";
    var panel = document.querySelector('.filter-canvas');
    if (!panel || typeof jQuery === 'undefined') { return; }

    function run() {
        if (typeof getresult === 'function') { getresult(URL_FOR_FILTERS); }
        if (typeof window.dxSyncUrl === 'function') { window.dxSyncUrl(); }
    }

    // Selects and the size radios re-query immediately; colour swatches are
    // multi-select so they wait for "Show results" rather than firing on each
    // tick.
    panel.querySelectorAll('.cat_id, .price, input[name="size"]').forEach(function (el) {
        el.addEventListener('change', run);
    });

    var apply = document.getElementById('dx-apply-filter');
    if (apply) {
        apply.addEventListener('click', function () {
            run();
            panel.classList.remove('show');
            document.body.style.overflow = '';
        });
    }

    var clear = document.getElementById('clearall');
    if (clear) {
        clear.addEventListener('click', function () {
            panel.querySelectorAll('select').forEach(function (s) { s.selectedIndex = 0; });
            panel.querySelectorAll('input[type="radio"], input[type="checkbox"]')
                 .forEach(function (i) { i.checked = false; });
            var sort = document.getElementById('dx-sorting');
            if (sort) { sort.selectedIndex = 0; }
            run();
        });
    }
})();
</script>
