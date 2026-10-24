-- DEXTE catalogue update - client call 19 Oct 2026, photos received 21 Oct 2026.
--
-- Production is still on the pre-19-October catalogue, so this file carries the
-- whole change: the products she asked us to drop, her new prices, the three new
-- categories, the ten new products with sizes and photos, and the homepage tiles.
--
-- Re-runnable: every insert is preceded by the matching delete, and the stock
-- numbers for the new products are carried across, so a second run cannot hand
-- sold inventory back.
-- The image files it references live in uploads/product/ and uploads/category/,
-- which come across with the git pull.
SET NAMES utf8mb4;

-- 0. per-size price column. Product_model creates this on its own the first time
--    it loads, but this file must not depend on a page having been hit first.
--    DDL commits implicitly in MariaDB, so it runs before the transaction opens
--    rather than silently ending it and leaving everything after it unprotected.
ALTER TABLE tbl_product_variation
  ADD COLUMN IF NOT EXISTS price DECIMAL(10,2) NULL DEFAULT NULL AFTER qty;

START TRANSACTION;

-- 1. sizes: bamboo cotton goes up to 6XL
INSERT INTO tbl_size (id, title, status) VALUES (9, 'XXXXXL', 1), (10, 'XXXXXXL', 1)
  ON DUPLICATE KEY UPDATE title = VALUES(title), status = VALUES(status);

-- 2. the catalogue cleanup she asked for on the call
--    bikini, sea green, printed, mesh and the dotted shorts come off the shop
UPDATE tbl_products SET delete_flag = '1' WHERE id IN (2, 3, 4, 5, 12, 13, 22, 23, 24, 25, 26, 27, 29);
--    her new MRP across the Mid Waist line
UPDATE tbl_products SET price = 999.00 WHERE id IN (8, 9, 10, 11, 14, 15, 16, 17, 18, 19, 20, 21);
--    the two high waist styles, which her sheet prices separately
UPDATE tbl_products SET price = 1499.00 WHERE id = 6;
UPDATE tbl_products SET price = 1850.00 WHERE id = 7;
--    plain name instead of the slang one, at her new price
UPDATE tbl_products SET title = 'High Waist Shorts', price = 1850.00 WHERE id = 28;

-- 3. the three new categories
DELETE FROM tbl_categories WHERE id IN (20, 21, 22);
INSERT INTO `tbl_categories` (`id`, `parent_id`, `title`, `image`, `url_slug`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `status`, `home_display`, `create_date`, `img_tag`, `canonical`, `banner`, `video_title`, `video_link`) VALUES (20,0,'Cotton','','cotton','','Cotton','','','1',0,'2026-10-19 06:50:18','','','','','');
INSERT INTO `tbl_categories` (`id`, `parent_id`, `title`, `image`, `url_slug`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `status`, `home_display`, `create_date`, `img_tag`, `canonical`, `banner`, `video_title`, `video_link`) VALUES (21,0,'Bamboo','','bamboo','','Bamboo','','','1',0,'2026-10-19 06:50:18','','','','','');
INSERT INTO `tbl_categories` (`id`, `parent_id`, `title`, `image`, `url_slug`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `status`, `home_display`, `create_date`, `img_tag`, `canonical`, `banner`, `video_title`, `video_link`) VALUES (22,0,'Teen','dx-cat-22-teen.png','teen','','Teen','','','1',1,'2026-10-19 06:50:18','','','','','');

-- 3b. a re-run must not hand stock back. Whatever qty the shop has reached for
--     these sizes is carried over the delete and insert below.
DROP TEMPORARY TABLE IF EXISTS dx_keep_qty;
CREATE TEMPORARY TABLE dx_keep_qty AS
  SELECT product_id, size, qty FROM tbl_product_variation
   WHERE product_id BETWEEN 30 AND 39;

-- 4. the ten new products (six lines; cotton, bamboo and teen get a row per
--    colour so a shopper can see which colour she is buying)
DELETE FROM tbl_product_variation WHERE product_id BETWEEN 30 AND 39;
DELETE FROM tbl_product_images WHERE product_id BETWEEN 30 AND 39;
DELETE FROM tbl_products WHERE id BETWEEN 30 AND 39;
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (30,'c8a7bc172de96b4',20,'cotton-period-panty-black','Cotton Period Panty - Black',499.00,0.00,0,1,5,100,'#141414','','<p>DEXTE Cotton period panty is a mid waist style. Soft, breathable cotton with a leak-proof layered gusset, so it can be worn on its own or alongside a pad. Reusable, washable and gentle on sensitive skin.</p>\n<p>Available in sizes XS to XL, in black and maroon.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Cotton Period Panty - Black','Cotton Period Panty - Black','Cotton Period Panty - Black from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-19 06:50:18',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (31,'71cbe7b51e5ca02',21,'bamboo-cotton-period-panty-grey','Bamboo Cotton Period Panty - Grey',799.00,0.00,0,1,5,100,'#a9a9a9','','<p>DEXTE Bamboo Cotton period panty is a mid waist style. Bamboo fibre is naturally breathable and anti-odour, which makes it our softest option for long days and for sensitive skin. Leak-proof layered gusset, fully reusable and washable.</p>\n<p>Available in sizes XS to 6XL, in grey, cream and black. Sizes 2XL and above are priced at &#8377;999.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Bamboo Cotton Period Panty - Grey','Bamboo Cotton Period Panty - Grey','Bamboo Cotton Period Panty - Grey from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-19 06:50:18',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (32,'fdfcb9789a87e65',18,'cotton-period-panty-pack-of-2','Cotton Period Panty - Pack of 2',899.00,0.00,0,1,5,100,'#141414','','<p>Two DEXTE cotton period panties, boxed. Enough to carry you through a full cycle &mdash; wear one while the other dries. Mid waist style with a leak-proof layered gusset, reusable and washable.</p>\n<p>Available in sizes XS to 4XL.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Cotton Period Panty - Pack of 2','Cotton Period Panty - Pack of 2','Cotton Period Panty - Pack of 2 from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-19 06:50:18',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (33,'31eb416ab32be9c',18,'period-panty-pack-of-3','Period Panty - Pack of 3',1350.00,0.00,0,1,5,100,'#141414','','<p>Three DEXTE period panties in one box, any size and any colour from the range. The most economical way to start &mdash; three pairs cover a whole cycle comfortably.</p>\n<p>Available in sizes XS to 4XL.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Period Panty - Pack of 3','Period Panty - Pack of 3','Period Panty - Pack of 3 from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-19 06:50:18',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (34,'4e218a88d228ec5',18,'seamless-period-panty-pack-of-2','Seamless Period Panty - Pack of 2',1599.00,0.00,0,1,5,100,'#a9a9a9','','<p>Two DEXTE seamless period panties, boxed. A smooth, no-visible-line finish that disappears under leggings, fitted trousers and a saree petticoat, with the same leak-proof layered gusset.</p>\n<p>Available in sizes XS to 4XL.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Seamless Period Panty - Pack of 2','Seamless Period Panty - Pack of 2','Seamless Period Panty - Pack of 2 from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-19 06:50:18',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (35,'2b6968b4f174291',22,'teen-period-panty-red','Teen Period Panty - Red',550.00,0.00,0,1,5,100,'#d4213c','','<p>DEXTE Teen period panty is made for first periods. A gentle mid waist fit with a soft waistband that does not dig in, and a leak-proof layered gusset &mdash; nothing to tape, fold or carry to school. Reusable and washable.</p>\n<p>Available in sizes XS to L, in red and wine. Suitable from around age 10.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Teen Period Panty - Red','Teen Period Panty - Red','Teen Period Panty - Red from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-19 06:50:18',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (36,'c8a7bc172de96b4',20,'cotton-period-panty-maroon','Cotton Period Panty - Maroon',499.00,0.00,0,1,5,100,'#7a1f2b','','<p>DEXTE Cotton period panty is a mid waist style. Soft, breathable cotton with a leak-proof layered gusset, so it can be worn on its own or alongside a pad. Reusable, washable and gentle on sensitive skin.</p>\n<p>Available in sizes XS to XL, in black and maroon.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Cotton Period Panty - Maroon','Cotton Period Panty - Maroon','Cotton Period Panty - Maroon from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-21 07:18:21',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (37,'2b6968b4f174291',22,'teen-period-panty-wine','Teen Period Panty - Wine',550.00,0.00,0,1,5,100,'#5e2340','','<p>DEXTE Teen period panty is made for first periods. A gentle mid waist fit with a soft waistband that does not dig in, and a leak-proof layered gusset &mdash; nothing to tape, fold or carry to school. Reusable and washable.</p>\n<p>Available in sizes XS to L, in red and wine. Suitable from around age 10.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Teen Period Panty - Wine','Teen Period Panty - Wine','Teen Period Panty - Wine from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-21 07:18:21',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (38,'71cbe7b51e5ca02',21,'bamboo-cotton-period-panty-cream','Bamboo Cotton Period Panty - Cream',799.00,0.00,0,1,5,100,'#efe0bf','','<p>DEXTE Bamboo Cotton period panty is a mid waist style. Bamboo fibre is naturally breathable and anti-odour, which makes it our softest option for long days and for sensitive skin. Leak-proof layered gusset, fully reusable and washable.</p>\n<p>Available in sizes XS to 6XL, in grey, cream and black. Sizes 2XL and above are priced at &#8377;999.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Bamboo Cotton Period Panty - Cream','Bamboo Cotton Period Panty - Cream','Bamboo Cotton Period Panty - Cream from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-21 07:18:21',0,'',3);
INSERT INTO `tbl_products` (`id`, `product_code`, `cat_id`, `url_slug`, `title`, `price`, `special_price`, `discount`, `min_order`, `max_order`, `qty`, `color`, `size`, `short_description`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `tag`, `canonical`, `status`, `is_featured`, `delete_flag`, `create_date`, `featured_pos`, `absorbency_volume`, `absorbency_rate`) VALUES (39,'71cbe7b51e5ca02',21,'bamboo-cotton-period-panty-black','Bamboo Cotton Period Panty - Black',799.00,0.00,0,1,5,100,'#141414','','<p>DEXTE Bamboo Cotton period panty is a mid waist style. Bamboo fibre is naturally breathable and anti-odour, which makes it our softest option for long days and for sensitive skin. Leak-proof layered gusset, fully reusable and washable.</p>\n<p>Available in sizes XS to 6XL, in grey, cream and black. Sizes 2XL and above are priced at &#8377;999.</p>\n<p><strong>Washing Instructions: </strong></p>\n<ul>\n	<li>Wash before wearing.</li>\n	<li>Hand wash or machine wash cold on a delicate cycle.</li>\n	<li>Do not use bleach or fabric softener.</li>\n	<li>Hang dry &mdash; no ironing please!</li>\n</ul>\n','','Bamboo Cotton Period Panty - Black','Bamboo Cotton Period Panty - Black','Bamboo Cotton Period Panty - Black from DEXTE. Reusable, leak-proof and washable.','','','1','no','0','2026-10-21 07:18:21',0,'',3);

-- 5. sizes and per-size prices (NULL price = inherit the product price;
--    bamboo 2XL and up carry their own 999)
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (233,30,'XS','COTTONPERIOD-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (234,30,'S','COTTONPERIOD-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (235,30,'M','COTTONPERIOD-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (236,30,'L','COTTONPERIOD-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (237,30,'XL','COTTONPERIOD-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (238,31,'XS','BAMBOOCOTTON-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (239,31,'S','BAMBOOCOTTON-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (240,31,'M','BAMBOOCOTTON-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (241,31,'L','BAMBOOCOTTON-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (242,31,'XL','BAMBOOCOTTON-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (243,31,'XXL','BAMBOOCOTTON-XXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (244,31,'XXXL','BAMBOOCOTTON-XXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (245,31,'XXXXL','BAMBOOCOTTON-XXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (246,31,'XXXXXL','BAMBOOCOTTON-XXXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (247,31,'XXXXXXL','BAMBOOCOTTON-XXXXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (248,32,'XS','COTTONPERIOD-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (249,32,'S','COTTONPERIOD-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (250,32,'M','COTTONPERIOD-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (251,32,'L','COTTONPERIOD-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (252,32,'XL','COTTONPERIOD-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (253,32,'XXL','COTTONPERIOD-XXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (254,32,'XXXL','COTTONPERIOD-XXXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (255,32,'XXXXL','COTTONPERIOD-XXXXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (256,33,'XS','PERIODPANTYP-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (257,33,'S','PERIODPANTYP-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (258,33,'M','PERIODPANTYP-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (259,33,'L','PERIODPANTYP-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (260,33,'XL','PERIODPANTYP-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (261,33,'XXL','PERIODPANTYP-XXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (262,33,'XXXL','PERIODPANTYP-XXXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (263,33,'XXXXL','PERIODPANTYP-XXXXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (264,34,'XS','SEAMLESSPERI-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (265,34,'S','SEAMLESSPERI-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (266,34,'M','SEAMLESSPERI-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (267,34,'L','SEAMLESSPERI-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (268,34,'XL','SEAMLESSPERI-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (269,34,'XXL','SEAMLESSPERI-XXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (270,34,'XXXL','SEAMLESSPERI-XXXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (271,34,'XXXXL','SEAMLESSPERI-XXXXL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (272,35,'XS','TEENPERIODPA-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (273,35,'S','TEENPERIODPA-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (274,35,'M','TEENPERIODPA-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (275,35,'L','TEENPERIODPA-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (386,36,'XS','COTMRN-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (387,36,'S','COTMRN-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (388,36,'M','COTMRN-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (389,36,'L','COTMRN-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (390,36,'XL','COTMRN-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (401,38,'XS','BAMCRM-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (402,38,'S','BAMCRM-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (403,38,'M','BAMCRM-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (404,38,'L','BAMCRM-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (405,38,'XL','BAMCRM-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (406,38,'XXL','BAMCRM-XXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (407,38,'XXXL','BAMCRM-XXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (408,38,'XXXXL','BAMCRM-XXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (409,38,'XXXXXL','BAMCRM-XXXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (410,38,'XXXXXXL','BAMCRM-XXXXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (411,39,'XS','BAMBLK-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (412,39,'S','BAMBLK-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (413,39,'M','BAMBLK-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (414,39,'L','BAMBLK-L',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (415,39,'XL','BAMBLK-XL',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (416,39,'XXL','BAMBLK-XXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (417,39,'XXXL','BAMBLK-XXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (418,39,'XXXXL','BAMBLK-XXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (419,39,'XXXXXL','BAMBLK-XXXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (420,39,'XXXXXXL','BAMBLK-XXXXXXL',100,999.00);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (421,37,'XS','TEENWIN-XS',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (422,37,'S','TEENWIN-S',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (423,37,'M','TEENWIN-M',100,NULL);
INSERT INTO `tbl_product_variation` (`id`, `product_id`, `size`, `sku`, `qty`, `price`) VALUES (424,37,'L','TEENWIN-L',100,NULL);

--    give the live stock numbers back, in place of the placeholders above
UPDATE tbl_product_variation v
  JOIN dx_keep_qty k ON k.product_id = v.product_id AND k.size = v.size
   SET v.qty = k.qty;
DROP TEMPORARY TABLE dx_keep_qty;

-- 6. her photos
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (227,30,'1792566790_30_1.jpg','1792566790_30_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (228,30,'1792566790_30_2.jpg','1792566790_30_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (229,30,'1792566790_30_3.jpg','1792566790_30_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (230,30,'1792566790_30_4.jpg','1792566790_30_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (231,30,'1792566790_30_5.jpg','1792566790_30_5_thumb.jpg','5','5');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (232,31,'1792566790_31_1.jpg','1792566790_31_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (233,31,'1792566790_31_2.jpg','1792566790_31_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (234,31,'1792566790_31_3.jpg','1792566790_31_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (235,31,'1792566790_31_4.jpg','1792566790_31_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (236,32,'1792566790_32_1.jpg','1792566790_32_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (237,32,'1792566790_32_2.jpg','1792566790_32_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (238,32,'1792566790_32_3.jpg','1792566790_32_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (239,32,'1792566790_32_4.jpg','1792566790_32_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (240,33,'1792566790_33_1.jpg','1792566790_33_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (241,33,'1792566790_33_2.jpg','1792566790_33_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (242,33,'1792566790_33_3.jpg','1792566790_33_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (243,33,'1792566790_33_4.jpg','1792566790_33_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (244,34,'1792566790_34_1.jpg','1792566790_34_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (245,34,'1792566790_34_2.jpg','1792566790_34_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (246,34,'1792566790_34_3.jpg','1792566790_34_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (247,34,'1792566790_34_4.jpg','1792566790_34_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (248,35,'1792566790_35_1.jpg','1792566790_35_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (249,35,'1792566790_35_2.jpg','1792566790_35_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (250,35,'1792566790_35_3.jpg','1792566790_35_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (251,35,'1792566790_35_4.jpg','1792566790_35_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (252,36,'1792566790_36_1.jpg','1792566790_36_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (253,36,'1792566790_36_2.jpg','1792566790_36_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (254,36,'1792566790_36_3.jpg','1792566790_36_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (255,36,'1792566790_36_4.jpg','1792566790_36_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (256,36,'1792566790_36_5.jpg','1792566790_36_5_thumb.jpg','5','5');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (257,37,'1792566790_37_1.jpg','1792566790_37_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (258,37,'1792566790_37_2.jpg','1792566790_37_2_thumb.jpg','2','2');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (259,37,'1792566790_37_3.jpg','1792566790_37_3_thumb.jpg','3','3');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (260,37,'1792566790_37_4.jpg','1792566790_37_4_thumb.jpg','4','4');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (261,38,'1792566790_38_1.jpg','1792566790_38_1_thumb.jpg','1','1');
INSERT INTO `tbl_product_images` (`id`, `product_id`, `image`, `thumb_image`, `img_tag`, `position`) VALUES (262,39,'1792566790_39_1.jpg','1792566790_39_1_thumb.jpg','1','1');

-- 7. homepage tiles. Thongs comes off the front page as she asked, and the
--    bikini slot becomes the combo packs. Tiles are cropped from her own photos.
UPDATE tbl_categories SET image = 'dx-cat-18-combo.png' WHERE id = 18;
UPDATE tbl_categories SET image = 'dx-cat-22-teen.png', home_display = 1 WHERE id = 22;
UPDATE tbl_categories SET home_display = 0 WHERE id = 5;
--    bikini off the front page too: she asked for it, and with her removals
--    applied that tile now points at a category with nothing live in it.
UPDATE tbl_categories SET home_display = 0 WHERE id = 1;

COMMIT;
