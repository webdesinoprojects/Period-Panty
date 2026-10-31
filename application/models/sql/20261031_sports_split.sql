-- Three things the client asked for on WhatsApp, 31 Oct:
--   "zebra wala remove kerna hi"
--   "seamless wale section mein short nahi chahiye"
--   "sports wale mein sports, seamless wale mein seamless karo"
--
-- The Seamless collection held both shorts, so /seamless.html led with a pair
-- of shorts at 1850. And every "Made For" tile, Sports & Activities included,
-- pointed at /shop - which lists the whole catalogue, overwhelmingly seamless
-- panties. Hence shorts under Seamless and seamless under Sports.
--
-- Category 4 is the retired "Shorts" style group. It is reused rather than
-- replaced so nothing has to be re-pointed at a new id; its two Madness
-- children stay switched off.

UPDATE tbl_categories SET
  title = 'Sports',
  url_slug = 'sports',
  meta_title = 'Sports Period Shorts | DEXTE',
  meta_description = 'Period shorts built to move - gym, running, cycling, dance and school sports.',
  image = 'dx-category-sports-v1.jpg',
  status = '1',
  home_display = 1
WHERE id = 4;

-- Both shorts leave Seamless for Sports.
UPDATE tbl_products SET cat_id = 4 WHERE id IN (6, 28);

-- The tile now opens the collection instead of the whole shop.
UPDATE tbl_slider SET button_link = 'sports' WHERE type = 'Footer' AND title = 'Sports & Activities';

-- Zebra print off the storefront. Switched off rather than deleted so her
-- stock and order history stay intact if she wants it back.
UPDATE tbl_products SET status = '0', is_featured = 'no' WHERE id = 1;
