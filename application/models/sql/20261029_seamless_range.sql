-- Her spreadsheet keeps these sixteen: four carry a price in the "product
-- remove" column (1499, 1850, 999, 1850) and twelve are left blank. Only the
-- thirteen she actually marked "remove" stay gone.
--
-- They were named after cuts - "Secure 01/10 Mid Waist" - and sat in a
-- collection called Seamless, which read as a mistake. Renamed to her own
-- colour words from the PRODUCT COLOUR column, matched to each product by the
-- photo embedded in her sheet rather than by name or row, because neither
-- lines up. Prices, stock, sizes, photos and ids are untouched.

SET @dx_seamless = (SELECT id FROM tbl_categories WHERE url_slug = 'seamless' LIMIT 1);

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Zebra Print', url_slug = 'seamless-period-panty-zebra-print',
  meta_title = 'DEXTE Seamless Period Panty - Zebra Print | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Zebra Print. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in zebra print. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#2a2a2a'
WHERE url_slug = 'comfy-01-bikini-printed';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Black', url_slug = 'seamless-period-panty-black',
  meta_title = 'DEXTE Seamless Period Panty - Black | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Black. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in black. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#141414'
WHERE url_slug = 'eco-01-1-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Berry Red', url_slug = 'seamless-period-panty-berry-red',
  meta_title = 'DEXTE Seamless Period Panty - Berry Red | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Berry Red. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in berry red. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#a83a5f'
WHERE url_slug = 'secure-01-2-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Beige', url_slug = 'seamless-period-panty-beige',
  meta_title = 'DEXTE Seamless Period Panty - Beige | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Beige. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in beige. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#e2cdb4'
WHERE url_slug = 'secure-01-3-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Deep Navy', url_slug = 'seamless-period-panty-deep-navy',
  meta_title = 'DEXTE Seamless Period Panty - Deep Navy | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Deep Navy. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in deep navy. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#1b2033'
WHERE url_slug = 'secure-01-4-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Light Onion', url_slug = 'seamless-period-panty-light-onion',
  meta_title = 'DEXTE Seamless Period Panty - Light Onion | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Light Onion. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in light onion. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#a9699b'
WHERE url_slug = 'secure-01-7-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Navy Blue', url_slug = 'seamless-period-panty-navy-blue',
  meta_title = 'DEXTE Seamless Period Panty - Navy Blue | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Navy Blue. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in navy blue. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#2b3357'
WHERE url_slug = 'secure-01-8-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Coral Pink', url_slug = 'seamless-period-panty-coral-pink',
  meta_title = 'DEXTE Seamless Period Panty - Coral Pink | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Coral Pink. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in coral pink. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#e0735c'
WHERE url_slug = 'secure-01-9-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Onion', url_slug = 'seamless-period-panty-onion',
  meta_title = 'DEXTE Seamless Period Panty - Onion | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Onion. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in onion. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#c08a93'
WHERE url_slug = 'secure-01-10-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Nude Pink', url_slug = 'seamless-period-panty-nude-pink',
  meta_title = 'DEXTE Seamless Period Panty - Nude Pink | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Nude Pink. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in nude pink. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#e0a5ab'
WHERE url_slug = 'secure-01-11-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Pistachio', url_slug = 'seamless-period-panty-pistachio',
  meta_title = 'DEXTE Seamless Period Panty - Pistachio | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Pistachio. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in pistachio. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#b9d3a8'
WHERE url_slug = 'secure-01-12-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Tomato Red', url_slug = 'seamless-period-panty-tomato-red',
  meta_title = 'DEXTE Seamless Period Panty - Tomato Red | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Tomato Red. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in tomato red. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#cf2233'
WHERE url_slug = 'secure-01-13-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Dark Orange', url_slug = 'seamless-period-panty-dark-orange',
  meta_title = 'DEXTE Seamless Period Panty - Dark Orange | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Dark Orange. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in dark orange. A smooth, bonded finish that disappears under clothes, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#c0494a'
WHERE url_slug = 'secure-01-14-mid-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Shorts - Black', url_slug = 'seamless-period-shorts-black',
  meta_title = 'DEXTE Seamless Period Shorts - Black | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Shorts in Black. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Shorts in black. A longer leg for full coverage and no ride-up, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#141414'
WHERE url_slug = 'protection-01-high-waist';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Boyshorts - Black', url_slug = 'seamless-period-boyshorts-black',
  meta_title = 'DEXTE Seamless Period Boyshorts - Black | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Boyshorts in Black. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Boyshorts in black. A relaxed boyshort cut that stays put through the day, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#141414'
WHERE url_slug = 'madness-01-shorts';

UPDATE tbl_products SET status = '1', cat_id = @dx_seamless, title = 'DEXTE Seamless Period Panty - Black Lace', url_slug = 'seamless-period-panty-black-lace',
  meta_title = 'DEXTE Seamless Period Panty - Black Lace | DEXTE', meta_description = 'Shop the DEXTE Seamless Period Panty in Black Lace. Leak-proof, reusable and smooth under clothes.', short_description = '<p>The DEXTE Seamless Period Panty in black lace. Lace side panels over a smooth, bonded body, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml.</p><p>Washable and reusable. Soft, breathable and kind to skin, for everyday wear and for your heavier days.</p>', description = '',
  color = '#141414'
WHERE url_slug = 'protection-02-high-waist-mesh';

-- The style sub-categories hung off the five retired collections and are now
-- empty, so they would serve blank, indexable pages of their own.
UPDATE tbl_categories child
JOIN tbl_categories parent ON parent.id = child.parent_id
SET child.status = '0', child.home_display = 0
WHERE parent.url_slug IN ('bikini','high-waist','mid-waist','shorts','thongs');

-- Seamless holds a real range again, so the pack of two goes back to Combo
-- where a pack belongs.
UPDATE tbl_products product
JOIN tbl_categories collection ON collection.url_slug = 'combo'
SET product.cat_id = collection.id
WHERE product.url_slug = 'seamless-period-panty-pack-of-2';

UPDATE tbl_categories SET image = 'dx-combo-seamless-pack2-v1.jpg'
WHERE url_slug = 'seamless';
