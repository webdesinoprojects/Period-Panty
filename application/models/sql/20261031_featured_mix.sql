-- Best Sellers on the home page. Welcome.php feeds that carousel from
-- is_featured, ordered by id descending, and every one of the sixteen flagged
-- products was Seamless - so the rail read as five identical 999 cards and
-- showed nothing from Cotton, Bamboo, Teen or Combo.
--
-- The eight below are chosen so the first five the visitor sees are one from
-- each collection at five different prices: 799, 499, 550, 899, 999. The rest
-- of the catalogue is still one click away on Shop All Products.

UPDATE tbl_products SET is_featured = 'no' WHERE is_featured = 'yes';

UPDATE tbl_products SET is_featured = 'yes'
WHERE id IN (38, 37, 35, 32, 20, 8, 6, 1)
  AND status = '1' AND delete_flag = '0';
