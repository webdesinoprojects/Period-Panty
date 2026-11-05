-- The shiny shorts (product 28, pink top) are DEXTE Period Shorts, not the
-- compression style. Same name and same copy as her row 7 - the photo is the
-- only thing that differs.
--
-- The previous migration switched 28 off because none of its photos are in her
-- sheet. She has said it is the Period Shorts in a different shot, so it comes
-- back with row 7's title, description and meta, taken from product 6 (checked
-- identical to the sheet line for line) rather than retyped.
--
-- It cannot keep product 6's URL, so it takes -2. Everything else about it is
-- already right: 1850, XS-2XL, its own four photos. The compression product from
-- row 8 (product 7) is left exactly as it is.

SET @dx_row7_copy = (SELECT short_description FROM tbl_products WHERE id = 6);
SET @dx_row7_meta = (SELECT meta_description FROM tbl_products WHERE id = 6);

UPDATE tbl_products SET
  status = '1',
  title = 'DEXTE Period Shorts - Black',
  url_slug = 'dexte-period-shorts-black-2',
  meta_title = 'DEXTE Period Shorts - Black | DEXTE',
  meta_description = @dx_row7_meta,
  price = 1850.00, special_price = 0.00, discount = 0,
  absorbency_volume = 'Up to 60 ml',
  short_description = @dx_row7_copy
WHERE id = 28;
