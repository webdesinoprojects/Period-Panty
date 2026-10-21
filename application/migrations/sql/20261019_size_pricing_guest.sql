-- Optional deployment DDL. Models apply the same additive changes with named
-- locks. Back up first. No product prices/customer identity values are rewritten.
SET @size_price_ddl = IF(
    EXISTS(SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = 'tbl_product_variation' AND COLUMN_NAME = 'price'),
    'SELECT 1', 'ALTER TABLE tbl_product_variation ADD COLUMN price DECIMAL(10,2) NULL DEFAULT NULL'
);
PREPARE size_price_migration FROM @size_price_ddl;
EXECUTE size_price_migration;
DEALLOCATE PREPARE size_price_migration;
SET @guest_flag_ddl = IF(
    EXISTS(SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = 'tbl_users' AND COLUMN_NAME = 'guest_created'),
    'SELECT 1', 'ALTER TABLE tbl_users ADD COLUMN guest_created TINYINT(1) NOT NULL DEFAULT 0'
);
PREPARE guest_flag_migration FROM @guest_flag_ddl;
EXECUTE guest_flag_migration;
DEALLOCATE PREPARE guest_flag_migration;
-- Do not automatically merge duplicate legacy phone records or infer which
-- existing passwords were generated. Resolve ambiguous identities with owners.
