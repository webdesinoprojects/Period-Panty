-- DEXTE: production content to match the redesign.
-- Generated from the verified local database with MySQL QUOTE(), so the
-- escaping is the server's own. Safe to re-run.
--
-- The FAQ and customer-review tables are deliberately absent: they migrate
-- themselves on first page load, and production's are empty so the defaults
-- import automatically.

-- 1. Hero card columns (MariaDB 10.0+; production runs 10.5).
ALTER TABLE tbl_slider
  ADD COLUMN IF NOT EXISTS card_product_id INT(11) NULL DEFAULT NULL AFTER color,
  ADD COLUMN IF NOT EXISTS card_label VARCHAR(100) NULL DEFAULT NULL AFTER card_product_id;

-- 2. Hero slides (Upper) and the two bento banners (Middle).
--    Without these the hero breaks: the live rows still reference rectangular
--    JPEGs, which would cover the headline.
UPDATE tbl_slider SET title='MAKE YOUR | OWN RULES', description='Leak-proof period underwear designed for comfort, care and confidence', button_title='Explore Collection', button_link='shop', image='dx-hero-1.png', status='1', type='Upper', card_product_id=NULL, card_label='New Collection' WHERE id=1;
UPDATE tbl_slider SET title='EMPOWERING | CONFIDENCE', description='No rashes. Maintains pH balance. Soft and breathable, every single day', button_title='Shop Now', button_link='shop', image='dx-hero-2.png', status='1', type='Upper', card_product_id=NULL, card_label='New Collection' WHERE id=2;
UPDATE tbl_slider SET title='COMFORT FOR | EVERY STAGE', description='Reusable and long lasting. Better for you, and better for the environment', button_title='Discover Dexte', button_link='shop', image='dx-hero-3.png', status='1', type='Upper', card_product_id=NULL, card_label='New Collection' WHERE id=3;
UPDATE tbl_slider SET title='middle Firts', description='', button_title='', button_link='', image='1683784781_collection.jpg', status='1', type='Middle', card_product_id=NULL, card_label='' WHERE id=4;
UPDATE tbl_slider SET title='Second', description='', button_title='', button_link='', image='1683784794_aboutt.jpg', status='1', type='Middle', card_product_id=NULL, card_label='' WHERE id=5;

-- 3. The seven Made-For cards. Footer was an unused slider type, so clearing
--    it cannot touch existing content.
DELETE FROM tbl_slider WHERE type='Footer';
INSERT INTO tbl_slider (title,description,button_title,button_link,image,status,create_date,type,color) VALUES ('Teenagers','First periods and growing years','','shop','dx-made-1.jpg','1',NOW(),'Footer','');
INSERT INTO tbl_slider (title,description,button_title,button_link,image,status,create_date,type,color) VALUES ('Working Women','All-day comfort and confidence','','shop','dx-made-2.jpg','1',NOW(),'Footer','');
INSERT INTO tbl_slider (title,description,button_title,button_link,image,status,create_date,type,color) VALUES ('Post Delivery','Gentle support for recovery','','shop','dx-made-3.jpg','1',NOW(),'Footer','');
INSERT INTO tbl_slider (title,description,button_title,button_link,image,status,create_date,type,color) VALUES ('Spotting','Light flow days','','shop','dx-made-4.jpg','1',NOW(),'Footer','');
INSERT INTO tbl_slider (title,description,button_title,button_link,image,status,create_date,type,color) VALUES ('Menopause','Comfort during changing phases','','shop','dx-made-5.jpg','1',NOW(),'Footer','');
INSERT INTO tbl_slider (title,description,button_title,button_link,image,status,create_date,type,color) VALUES ('Urine Incontinence','Stay active, stay confident','','shop','dx-made-6.jpg','1',NOW(),'Footer','');
INSERT INTO tbl_slider (title,description,button_title,button_link,image,status,create_date,type,color) VALUES ('Sports & Activities','Freedom to move','','shop','dx-made-7.jpg','1',NOW(),'Footer','');

-- 4. Category artwork, copy and home-display flags (bento + framed grid).
UPDATE tbl_categories SET image='dx-cat-1-v2.png', description='Classic cut, everyday comfort', home_display='1', status='1' WHERE id=1;
UPDATE tbl_categories SET image='dx-cat-2-v2.png', description='Full coverage with tummy support', home_display='1', status='1' WHERE id=2;
UPDATE tbl_categories SET image='dx-cat-3-v2.png', description='Balanced rise for all-day wear', home_display='1', status='1' WHERE id=3;
UPDATE tbl_categories SET image='dx-cat-4-v2.png', description='Extra coverage, freedom to move', home_display='1', status='1' WHERE id=4;
UPDATE tbl_categories SET image='dx-cat-5.png', description='Minimal lines, invisible fit', home_display='1', status='1' WHERE id=5;
UPDATE tbl_categories SET image='', description='Multi-packs, better value', home_display='1', status='1' WHERE id=18;

-- 5. Product colours, sampled from each product's own photograph. The product
--    cards tint themselves from this column.
UPDATE tbl_products SET color='#0c0c0c' WHERE id=1;
UPDATE tbl_products SET color='#242424' WHERE id=2;
UPDATE tbl_products SET color='#243c6c' WHERE id=3;
UPDATE tbl_products SET color='#9c243c' WHERE id=4;
UPDATE tbl_products SET color='#242424' WHERE id=5;
UPDATE tbl_products SET color='#0c0c24' WHERE id=6;
UPDATE tbl_products SET color='#242424' WHERE id=7;
UPDATE tbl_products SET color='#242424' WHERE id=8;
UPDATE tbl_products SET color='#b43c6c' WHERE id=9;
UPDATE tbl_products SET color='#fce4cc' WHERE id=10;
UPDATE tbl_products SET color='#242424' WHERE id=11;
UPDATE tbl_products SET color='#3c543c' WHERE id=12;
UPDATE tbl_products SET color='#6cb4cc' WHERE id=13;
UPDATE tbl_products SET color='#9c5484' WHERE id=14;
UPDATE tbl_products SET color='#3c3c54' WHERE id=15;
UPDATE tbl_products SET color='#b4b4b4' WHERE id=16;
UPDATE tbl_products SET color='#cc9c9c' WHERE id=17;
UPDATE tbl_products SET color='#ccb4cc' WHERE id=18;
UPDATE tbl_products SET color='#b4b49c' WHERE id=19;
UPDATE tbl_products SET color='#cc0c3c' WHERE id=20;
UPDATE tbl_products SET color='#b43c54' WHERE id=21;
UPDATE tbl_products SET color='#24243c' WHERE id=22;
UPDATE tbl_products SET color='#54546c' WHERE id=23;
UPDATE tbl_products SET color='#242424' WHERE id=24;
UPDATE tbl_products SET color='#0c0c24' WHERE id=25;
UPDATE tbl_products SET color='#3c3c3c' WHERE id=26;
UPDATE tbl_products SET color='#cc5454' WHERE id=27;
UPDATE tbl_products SET color='#242424' WHERE id=28;
UPDATE tbl_products SET color='#242424' WHERE id=29;
