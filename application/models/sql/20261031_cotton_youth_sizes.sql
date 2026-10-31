-- Her WhatsApp, 31 Oct, listing the cotton ladder in full:
--   "10-12 yeard" / "12-14 yeatd" / "xs de ltkat xl" / "2xl -6xl" /
--   "corrion period panty"  (cotton, not corrion)
--
-- and the sheet's own line, three times over: "Add cotton period panty mrp 499
-- rs 10 years to xl". So cotton starts at 10 years, not at XS. The two youth
-- sizes carry no price of their own, which means they inherit the 499 base
-- alongside XS-XL; 2XL-6XL keep their 599.
--
-- Stock is the 100 per size already authorised for the sizes added yesterday.

INSERT INTO tbl_product_variation (product_id, size, sku, qty, price) VALUES
  (30, '10-12 Years', 'COTTON-30-10-12Y', 100, NULL),
  (30, '12-14 Years', 'COTTON-30-12-14Y', 100, NULL),
  (31, '10-12 Years', 'COTTON-31-10-12Y', 100, NULL),
  (31, '12-14 Years', 'COTTON-31-12-14Y', 100, NULL),
  (36, '10-12 Years', 'COTTON-36-10-12Y', 100, NULL),
  (36, '12-14 Years', 'COTTON-36-12-14Y', 100, NULL),
  (37, '10-12 Years', 'COTTON-37-10-12Y', 100, NULL),
  (37, '12-14 Years', 'COTTON-37-12-14Y', 100, NULL);
