-- Cotton Black: the gallery carried eight photos and her sheet row 3 lists six.
-- The two extra - 1792566790_30_4 (a cloth pad shown beside the panty) and
-- 1792566790_30_5 (a girl holding that pad) - are not in her sheet at all. They
-- came with the product before the sheet existed, and when I added the three of
-- hers that were missing I matched hers against what we had and never asked
-- whether the rest were hers. Checked by photo against rows 3-6, they are the
-- only two such photos across all four cotton colours.
--
-- The standing full-length photo - her row 3, the girl in the black top - is to
-- lead the page. Position is what orders both the product gallery and the shop
-- card, so one reorder fixes both.
--
-- The two files stay on disk, so restoring either is a single INSERT.

DELETE FROM tbl_product_images
WHERE product_id = 30
  AND image IN ('1792566790_30_4.jpg', '1792566790_30_5.jpg');

UPDATE tbl_product_images SET position = 1 WHERE product_id = 30 AND image = '1792566790_30_2.jpg';

UPDATE tbl_product_images SET position = 2 WHERE product_id = 30 AND image = '1792566790_30_1.jpg';

UPDATE tbl_product_images SET position = 3 WHERE product_id = 30 AND image = '1792566790_30_3.jpg';

UPDATE tbl_product_images SET position = 4 WHERE product_id = 30 AND image = 'dx-sheet-cotton-black-logo-v1.jpg';

UPDATE tbl_product_images SET position = 5 WHERE product_id = 30 AND image = 'dx-sheet-cotton-black-angle-v1.jpg';

UPDATE tbl_product_images SET position = 6 WHERE product_id = 30 AND image = 'dx-sheet-cotton-black-side-v1.jpg';
