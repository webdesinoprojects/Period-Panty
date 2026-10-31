-- Her row 8 is headed DEXTE COMPRESSION-STYLE PERIOD SHORTS, but the photo she
-- anchored in it is a black high-waist lace panty - our product 7, which was
-- seamless-period-panty-black-lace until the 29 Oct rename. Taking that row at
-- face value put gym-and-squats copy and a 1850 price on a lace panty.
--
-- The only compression-style short in the catalogue is product 28, the shiny
-- black short-leg garment that I had named "Boyshorts" - a name of mine, not
-- hers, carried over from madness-01-shorts. So her row 8 belongs on 28, and 7
-- goes back to the 999 seamless range where its own photograph puts it.
--
-- The copy is moved between the two products rather than retyped, so neither
-- description can drift from what she wrote.

SET @dx_compression_copy = (SELECT short_description FROM tbl_products WHERE id = 7);
SET @dx_seamless_copy = (SELECT short_description FROM tbl_products WHERE id = 9);

-- 7 first: it has to release the slug before 28 can take it.
UPDATE tbl_products SET
  title = 'DEXTE Seamless Period Panty - Black Lace',
  url_slug = 'seamless-period-panty-black-lace',
  meta_title = 'DEXTE Seamless Period Panty - Black Lace | DEXTE',
  meta_description = 'Shop the DEXTE Seamless Period Panty in Black Lace. Leak-proof, reusable and smooth under clothes.',
  price = 999.00, special_price = 0.00, discount = 0,
  absorbency_volume = '40-50 ml',
  short_description = @dx_seamless_copy
WHERE id = 7;

UPDATE tbl_products SET
  title = 'DEXTE Compression-Style Period Shorts - Black',
  url_slug = 'dexte-compression-period-shorts-black',
  meta_title = 'DEXTE Compression-Style Period Shorts - Black | DEXTE',
  meta_description = 'Shop the DEXTE Compression-Style Period Shorts in black. Supportive, leak-proof and reusable.',
  price = 1850.00, special_price = 0.00, discount = 0,
  absorbency_volume = 'Up to 60 ml',
  short_description = @dx_compression_copy
WHERE id = 28;

-- Neither carries a per-size price: her sheet quotes one figure for each.
UPDATE tbl_product_variation SET price = NULL WHERE product_id IN (7, 28);

-- 7 is a seamless panty again, so XS-3XL is back on sale and 4XL stays off.
UPDATE tbl_product_variation SET qty = 10
WHERE product_id = 7 AND qty = 0 AND UPPER(size) IN ('XS','S','M','L','XL','XXL','2XL','XXXL','3XL');

-- 28 is the compression short: her row 8 offers XS-2XL only.
UPDATE tbl_product_variation SET qty = 0
WHERE product_id = 28 AND UPPER(size) NOT IN ('XS','S','M','L','XL','XXL','2XL');
