-- "updated website con2026.ods", 29 October. She replaced the old "product
-- remove" column with a range name and a tagline for each line, and matched by
-- photo her row 8 confirms the 999 range is the DEXTE Seamless Period Panty -
-- which is what it was renamed to yesterday.
--
-- Two names were wrong. Her row 7 is a COMPRESSION-STYLE PERIOD SHORT, which
-- had been read as a lace panty, and her row 6 is simply DEXTE PERIOD SHORTS.

UPDATE tbl_products SET
  title = 'DEXTE Period Shorts - Black',
  url_slug = 'dexte-period-shorts-black',
  meta_title = 'DEXTE Period Shorts - Black | DEXTE',
  meta_description = 'Shop the DEXTE Period Shorts in black. A longer leg, leak-proof and reusable.',
  short_description = '<p><em>School days. Sports days. First-period days. Feel ready with Dexte.</em></p><p>The DEXTE Period Shorts in black. A longer leg for full coverage and no ride-up, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml &mdash; no pad to shift, fold or carry.</p><p>Washable and reusable. Soft, breathable and kind to skin.</p>'
WHERE url_slug = 'seamless-period-shorts-black';

UPDATE tbl_products SET
  title = 'DEXTE Compression-Style Period Shorts - Black',
  url_slug = 'dexte-compression-period-shorts-black',
  meta_title = 'DEXTE Compression-Style Period Shorts - Black | DEXTE',
  meta_description = 'Shop the DEXTE Compression-Style Period Shorts in black. Supportive, leak-proof and reusable.',
  short_description = '<p><em>Move with confidence. Stay focused on your workout.</em></p><p>The DEXTE Compression-Style Period Shorts in black. A firm, supportive hold that stays put while you move, with a leak-proof layered gusset that absorbs up to 40&nbsp;ml.</p><p>Washable and reusable. Soft, breathable and kind to skin.</p>'
WHERE url_slug = 'seamless-period-panty-black-lace';

-- Her taglines, used as the opening line of each range's copy.
UPDATE tbl_products product
JOIN tbl_categories collection ON collection.id = product.cat_id
SET product.short_description = CONCAT(
      '<p><em>A smooth fit under your outfit. Extra reassurance through your day.</em></p>',
      product.short_description)
WHERE collection.url_slug = 'seamless' AND product.price = 999.00;

UPDATE tbl_products product
JOIN tbl_categories collection ON collection.id = product.cat_id
SET product.short_description = CONCAT(
      '<p><em>Your everyday cotton comfort. With extra protection built in.</em></p>',
      product.short_description)
WHERE collection.url_slug = 'cotton';
