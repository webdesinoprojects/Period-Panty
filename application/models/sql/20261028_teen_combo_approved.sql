INSERT INTO tbl_products (product_code,cat_id,url_slug,title,price,special_price,discount,min_order,max_order,qty,color,size,short_description,description,meta_title,meta_keywords,meta_description,tag,canonical,status,is_featured,delete_flag,create_date,featured_pos,absorbency_volume,absorbency_rate)
SELECT 'dexte-teen-combo-2-v1', collection.id, 'cotton-teen-period-panty-pack-of-2', 'Cotton Teen Period Panty - Pack of 2', 1100.00, 0.00, 0, 1, 5, 100, '#5e2340', '', CONCAT('<h3>Dexte Cotton Teen Period Panty - Pack of 2</h3><p><strong>Pack of 2 | &#8377;1,100</strong></p><p>Each pack contains two cotton teen period panties. Select one size for the pack. The stated 40&ndash;60 ml absorbency is per panty.</p>', REPLACE(seed.short_description, '<h3>Dexte Cotton Teen Period Panty</h3>', '')), '', 'Cotton Teen Period Panty - Pack of 2 | DEXTE', 'cotton teen period panty pack of two', 'Shop the DEXTE Cotton Teen Period Panty pack of two for Rs. 1100, in sizes XS to XL.', '', '', '1', 'no', '0', NOW(), 0, '40-60 ml per panty', seed.absorbency_rate
FROM tbl_products seed
JOIN tbl_categories collection ON collection.url_slug = 'combo'
LEFT JOIN tbl_products existing ON existing.url_slug = 'cotton-teen-period-panty-pack-of-2'
WHERE seed.url_slug = 'teen-period-panty-wine' AND existing.id IS NULL;

INSERT INTO tbl_product_variation (product_id, size, sku, qty, price)
SELECT product.id, sizes.size, CONCAT('TEEN-PACK2-', sizes.size), 20, NULL
FROM tbl_products product
JOIN (SELECT 'XS' AS size UNION ALL SELECT 'S' UNION ALL SELECT 'M' UNION ALL SELECT 'L' UNION ALL SELECT 'XL') sizes
LEFT JOIN tbl_product_variation existing ON existing.product_id = product.id AND existing.size = sizes.size
WHERE product.url_slug = 'cotton-teen-period-panty-pack-of-2' AND existing.id IS NULL;

INSERT INTO tbl_product_images (product_id, image, thumb_image, img_tag, position)
SELECT product.id, 'dx-combo-teen-pack2-v1.jpg', 'dx-combo-teen-pack2-v1.jpg', 'DEXTE Cotton Teen Period Panty pack of two with ivory and green packaging', 1
FROM tbl_products product
LEFT JOIN tbl_product_images existing ON existing.product_id = product.id
WHERE product.url_slug = 'cotton-teen-period-panty-pack-of-2' AND existing.id IS NULL;

UPDATE tbl_product_variation variation
JOIN tbl_products product ON product.id = variation.product_id
SET variation.qty = 20
WHERE product.url_slug IN ('teen-period-panty-red', 'teen-period-panty-wine') AND variation.size = 'XL';

-- Only the new pack is totalled from its sizes. The two Teen singles keep the
-- stock figure they already carried: summing their sizes pushed them from 100
-- to 500, which advertised four times the stock that exists and is how you
-- oversell a product.
UPDATE tbl_products product
JOIN (SELECT product_id, SUM(qty) AS total_qty FROM tbl_product_variation GROUP BY product_id) stock ON stock.product_id = product.id
SET product.qty = stock.total_qty
WHERE product.url_slug = 'cotton-teen-period-panty-pack-of-2';
