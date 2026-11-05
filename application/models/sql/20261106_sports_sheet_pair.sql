-- Sports is her rows 7 and 8, exactly as she wrote them - nothing else.
--
--   row 7  DEXTE PERIOD SHORTS                     1850  XS-2XL  photo: red top, black shorts
--   row 8  DEXTE COMPRESSION-STYLE PERIOD SHORTS   1850  XS-2XL  photo: pink top, high-waist black
--
-- Row 7 is product 6 and already matches: its first photo is her row 7 photo and
-- its description is identical to hers, line for line.
--
-- Row 8's photo is product 7's own first photo - the file that was sitting in
-- Seamless as a "Black Lace" panty at 999. The copy she wrote for row 8 is the
-- one product 28 carries today, checked identical to the sheet line for line,
-- so it is moved across rather than retyped. That puts the sheet's photo, copy,
-- name and price on one product, which is what she sent.
--
-- Product 28 - the shiny short - has no row in her sheet and none of its photos
-- are hers. It is switched off, not deleted, and goes back to its earlier slug
-- so the old boyshorts URL keeps redirecting.
--
-- Her sheet carries one photo per row. Product 6 had four more angles and
-- product 7 three more that are not in it; they come out of the galleries, and
-- the files stay on disk so any of them can be put back with one INSERT.

SET @dx_row8_copy = (SELECT short_description FROM tbl_products WHERE id = 28);
SET @dx_sports = (SELECT id FROM tbl_categories WHERE url_slug = 'sports');

-- 28 first: it has to release the compression slug before 7 can take it.
UPDATE tbl_products SET
  status = '0',
  is_featured = 'no',
  url_slug = 'seamless-period-boyshorts-black',
  title = 'Boyshorts - Black (off: not in her sheet)'
WHERE id = 28;

UPDATE tbl_products SET
  title = 'DEXTE Compression-Style Period Shorts - Black',
  url_slug = 'dexte-compression-period-shorts-black',
  meta_title = 'DEXTE Compression-Style Period Shorts - Black | DEXTE',
  meta_description = 'Shop the DEXTE Compression-Style Period Shorts in black. Supportive, leak-proof and reusable.',
  cat_id = @dx_sports,
  price = 1850.00, special_price = 0.00, discount = 0,
  absorbency_volume = 'Up to 60 ml',
  short_description = @dx_row8_copy
WHERE id = 7;

-- One price for every size, XS-2XL only, as row 8 states.
UPDATE tbl_product_variation SET price = NULL WHERE product_id = 7;

UPDATE tbl_product_variation SET qty = 0
WHERE product_id = 7 AND UPPER(size) NOT IN ('XS','S','M','L','XL','XXL','2XL');

-- Her photos only.
DELETE FROM tbl_product_images
WHERE product_id = 6
  AND image IN ('1684151775_3_1.jpg', '1684151776_3_3.jpg', '1684151776_3_5.jpg', '1684151777_3_4.jpg');

DELETE FROM tbl_product_images
WHERE product_id = 7
  AND image IN ('1684152041_15_2.JPG', '1684152041_15_3.jpg', '1684152042_15_4.JPG');
