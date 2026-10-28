DELETE images FROM tbl_product_images images
JOIN tbl_products product ON product.id = images.product_id
WHERE product.url_slug IN ('cotton-period-panty-pack-of-2', 'seamless-period-panty-pack-of-2');

INSERT INTO tbl_product_images (product_id, image, thumb_image, img_tag, position)
SELECT id, 'dx-combo-pack-v2.jpg', 'dx-combo-pack-v2.jpg', 'DEXTE Cotton Period Panty - pack of two, maroon and black, with pink packaging', 1
FROM tbl_products WHERE url_slug = 'cotton-period-panty-pack-of-2';

INSERT INTO tbl_product_images (product_id, image, thumb_image, img_tag, position)
SELECT id, 'dx-combo-seamless-pack2-v1.jpg', 'dx-combo-seamless-pack2-v1.jpg', 'DEXTE Seamless Period Panty - pack of two with black and pink packaging', 1
FROM tbl_products WHERE url_slug = 'seamless-period-panty-pack-of-2';

INSERT INTO tbl_product_images (product_id, image, thumb_image, img_tag, position)
SELECT id, 'dx-combo-seamless-pack2-warm-v1.jpg', 'dx-combo-seamless-pack2-warm-v1.jpg', 'DEXTE Seamless Period Panty pack of two on a warm cream background', 2
FROM tbl_products WHERE url_slug = 'seamless-period-panty-pack-of-2';

UPDATE tbl_products SET short_description = '<h3>DEXTE SEAMLESS PERIOD PANTY</h3><p><strong>Pack of 2 | &#8377;1,599</strong></p><p>Enjoy comfort, confidence and freedom with DEXTE Seamless Period Panties.</p><h4>USES &amp; BENEFITS</h4><ul><li><strong>Light Spotting:</strong> Ideal for light spotting and light-flow days.</li><li><strong>No Visible Panty Lines:</strong> Seamless design stays discreet under dresses, trousers and fitted outfits.</li><li><strong>Lightweight &amp; Breathable:</strong> Soft, breathable fabric for comfortable everyday wear.</li><li><strong>Extra Protection:</strong> Helps manage light flow and offers added confidence.</li><li><strong>For Extra-Heavy Flow:</strong> Pair with another menstrual product, such as a pad, tampon or menstrual cup, for additional protection.</li><li><strong>Reusable &amp; Convenient:</strong> Washable and reusable, making them a practical choice for your menstrual-care routine.</li></ul><p><strong>DEXTE &mdash; Menstrual Wellness. Always.</strong></p>', description = '' WHERE url_slug = 'seamless-period-panty-pack-of-2';

UPDATE tbl_products SET title = IF(title LIKE 'Cotton Teen Period Panty%', title, REPLACE(title, 'Teen Period Panty', 'Cotton Teen Period Panty')), meta_title = IF(meta_title LIKE 'Cotton Teen Period Panty%', meta_title, REPLACE(meta_title, 'Teen Period Panty', 'Cotton Teen Period Panty')), absorbency_volume = '40-60 ml', short_description = '<h3>Dexte Cotton Teen Period Panty</h3><p><strong>New to periods? Start with comfort and confidence.</strong></p><p>First periods bring new experiences&mdash;and choosing period protection should feel simple. Dexte Cotton Teen Period Panty is designed for teenagers, combining a familiar underwear-style fit with <strong>40&ndash;60 ml menstrual absorbency</strong>.</p><h4>Made for her everyday life</h4><ul><li><strong>First-period support:</strong> A simple option for teens learning to manage their menstrual flow.</li><li><strong>School, tuition and outings:</strong> Fits into everyday routines, with changes according to flow.</li><li><strong>Light days and spotting:</strong> Useful at the beginning and end of a period.</li><li><strong>Cotton comfort:</strong> Soft, breathable fabric for comfortable wear.</li><li><strong>Extra reassurance:</strong> Can also be worn as backup with another period product.</li></ul><p><strong>Fabric:</strong> Cotton<br><strong>Absorbency:</strong> 40&ndash;60 ml<br><strong>Sizes:</strong> XS&ndash;XL<br><strong>Colours:</strong> Red and Wine</p><p><strong>Her first periods. Her favourite colours. Her growing confidence.</strong></p><p><em>Wear time depends on flow. Change when damp or nearing capacity, and carry a spare pair for longer days.</em></p>', description = '' WHERE url_slug IN ('teen-period-panty-red', 'teen-period-panty-wine');

INSERT INTO tbl_product_variation (product_id, size, sku, qty, price)
SELECT product.id, 'XL', CONCAT('TEEN-', product.id, '-XL'), 0, NULL
FROM tbl_products product
LEFT JOIN tbl_product_variation variation ON variation.product_id = product.id AND variation.size = 'XL'
WHERE product.url_slug IN ('teen-period-panty-red', 'teen-period-panty-wine')
AND variation.id IS NULL;
