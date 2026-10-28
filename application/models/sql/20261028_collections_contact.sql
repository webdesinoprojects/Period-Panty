INSERT INTO tbl_categories (parent_id,title,image,url_slug,description,meta_title,meta_keyword,meta_description,status,home_display,create_date,img_tag,canonical,banner,video_title,video_link)
VALUES (0,'Seamless','dx-category-seamless-v2.png','seamless','Smooth comfort. An invisible finish.','Seamless Period Panties | DEXTE','','Shop DEXTE seamless period panties.','1',1,NOW(),'Seamless period panties','','','','')
ON DUPLICATE KEY UPDATE url_slug = VALUES(url_slug);
SET @dx_seamless_id = (SELECT id FROM tbl_categories WHERE url_slug = 'seamless' LIMIT 1);
UPDATE tbl_products SET cat_id = @dx_seamless_id WHERE price = 999.00 AND delete_flag = '0';
-- Retired as collections. status = '0' takes the page off the site entirely
-- rather than only hiding the card, and an admin can switch it back. The
-- products underneath are left alone: they keep their own URLs and still
-- appear in /shop, so nothing that was for sale stops being for sale.
UPDATE tbl_categories SET home_display = 0, status = '0' WHERE url_slug IN ('high-waist','mid-waist','shorts','bikini','thongs');
UPDATE tbl_categories SET home_display = 1, image = 'dx-category-bamboo-v2.jpg', description = 'Breathable comfort, naturally.' WHERE url_slug = 'bamboo';
UPDATE tbl_categories SET home_display = 1, image = 'dx-category-cotton-v2.jpg', description = 'Soft cotton for everyday comfort.' WHERE url_slug = 'cotton';
UPDATE tbl_categories SET home_display = 1, image = 'dx-category-seamless-v2.png', description = 'Smooth comfort. An invisible finish.' WHERE url_slug = 'seamless';
UPDATE tbl_categories SET home_display = 1, image = 'dx-combo-pack-v2.jpg' WHERE url_slug = 'combo';
UPDATE tbl_slider SET image = 'dx-collection-branded-v2.jpg', description = '' WHERE id = 4 AND type = 'Middle';
UPDATE tbl_slider SET image = 'dx-about-branded-v2.jpg' WHERE id = 5 AND type = 'Middle';
UPDATE tbl_setting SET email = 'dexteofficials@gmail.com', email_secondary = 'dextewellness@gmail.com', phone = '+91 8527632266', phone2 = '', whatapp = '918527632266', address_content = 'Gurgaon, Haryana, India', adddress_content_2 = 'Gurgaon, Haryana, India', invoice_address = 'Gurgaon, Haryana, India', linkedin_link = 'https://www.linkedin.com/in/pooja-aneja-152816288/', instagram_link = 'https://www.instagram.com/dexteperiodpanty?mdxt=MTMxY3NpZ2htdWwxeA==' WHERE id = 1;
