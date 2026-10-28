const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const crypto = require('node:crypto');
const repo = path.resolve(__dirname, '../../..');
const sql = fs.readFileSync(path.join(repo, 'application/models/sql/20261028_combo_gallery_teen_copy.sql'), 'utf8');
for (const name of ['dx-combo-pack-v2.jpg', 'dx-combo-seamless-pack2-v1.jpg', 'dx-combo-seamless-pack2-warm-v1.jpg']) {
    const media = fs.readFileSync(path.join(repo, 'assets/front/media', name));
    const upload = fs.readFileSync(path.join(repo, 'uploads/product', name));
    assert(media.equals(upload), 'Uploaded image must match the supplied media asset: ' + name);
    assert(media.length > 10000);
    assert(sql.includes(name));
}
assert.equal([...sql.matchAll(/INSERT INTO tbl_product_images/g)].length, 3);
assert(sql.includes("WHERE product.url_slug IN ('cotton-period-panty-pack-of-2', 'seamless-period-panty-pack-of-2')"));
for (const phrase of ['Light Spotting', 'No Visible Panty Lines', 'Lightweight &amp; Breathable', 'Extra Protection', 'For Extra-Heavy Flow', 'Reusable &amp; Convenient', 'Menstrual Wellness. Always.', 'Pack of 2 | &#8377;1,599']) { assert(sql.includes(phrase), 'Missing supplied Seamless copy: ' + phrase); }
for (const phrase of ['40&ndash;60 ml', 'XS&ndash;XL', 'Change when damp or nearing capacity', 'Cotton comfort']) { assert(sql.includes(phrase), 'Missing supplied Teen copy: ' + phrase); }
// Her copy listed Lavender, Black, Navy Blue, Wine and Maroon, but only Red and
// Wine exist as products. The page may only name colours a shopper can buy.
assert(sql.includes('<strong>Colours:</strong> Red and Wine'), 'Teen colours must match the products that exist.');
assert(!sql.includes('Lavender'), 'Do not advertise colours with no product, photo or SKU behind them.');
assert(sql.includes("CONCAT('TEEN-', product.id, '-XL'), 0, NULL"), 'New XL must not invent stock or override its inherited price.');
assert(sql.includes('LEFT JOIN tbl_product_variation variation'));
assert(sql.includes('AND variation.id IS NULL'));
assert(!/\bSET\s+(?:price|special_price|qty)\s*=/i.test(sql), 'Do not change existing prices or stock.');
assert(!sql.includes('period-panty-pack-of-3'), 'Existing pack of three must remain unchanged.');
assert(!/INSERT INTO tbl_products\b/i.test(sql), 'Do not publish a Teen combo without its confirmed price.');
assert(!/\b(?:tbl_users|tbl_order|tbl_order_item)\b/i.test(sql));
for (const view of ['product/listing-view.php','product/detail.php','checkout/items.php','checkout/onpage-items.php','checkout/success.php','account/my_orders.php']) {
    const text = fs.readFileSync(path.join(repo, 'application/views/front', view), 'utf8');
    assert(text.includes("content_image('product',"), 'New pack image must render consistently: ' + view);
}
const hashes = ['dx-combo-seamless-pack2-v1.jpg','dx-combo-seamless-pack2-warm-v1.jpg'].map(name => crypto.createHash('sha256').update(fs.readFileSync(path.join(repo,'assets/front/media',name))).digest('hex'));
assert.notEqual(hashes[0], hashes[1], 'Seamless gallery must contain both supplied image variants.');
assert(fs.existsSync(path.join(repo, 'assets/front/media/dx-combo-teen-pack2-v1.jpg')), 'Teen combo artwork must be saved even while its price is pending.');
console.log('PASS: supplied combo galleries/copy, Teen XS–XL metadata, preserved prices/stock, and consistent shop/cart images.');
