-- Cotton collection: absorbency rating 3 -> 4 of 5 drops.
--
-- absorbency_rate drives every droplet display - the product page and the shop
-- card both read it, and nothing is hard-coded per product. The "Light /
-- Moderate" cards on the home page are a separate legend and are untouched.
--
-- Scoped to the Cotton collection (Black, Dark Grey, Maroon, Wine). The
-- "Up to 40 ml" figure is a separate field and is left exactly as her copy has
-- it; this changes the rating shown, not the stated capacity.

UPDATE tbl_products product
JOIN tbl_categories collection ON collection.id = product.cat_id
SET product.absorbency_rate = 4
WHERE collection.url_slug = 'cotton'
  AND product.status = '1'
  AND product.delete_flag = '0';
