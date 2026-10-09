-- Schema reference for the FAQ and customer review rail CMS migration.
-- Home_content_model::initialize() applies equivalent, idempotent changes
-- automatically. Do not manually run these ALTERs after that migration.
-- Existing columns and records are retained.

ALTER TABLE tbl_faq
    ADD COLUMN sort_order INT NOT NULL DEFAULT 0;

ALTER TABLE tbl_testimonials
    ADD COLUMN sort_order INT NOT NULL DEFAULT 0,
    ADD COLUMN card_type VARCHAR(16) NOT NULL DEFAULT 'auto',
    ADD COLUMN poster VARCHAR(255) NOT NULL DEFAULT '',
    ADD COLUMN rating TINYINT UNSIGNED NOT NULL DEFAULT 5;

CREATE TABLE IF NOT EXISTS tbl_home_content_migrations (
    migration VARCHAR(100) NOT NULL PRIMARY KEY,
    applied_at DATETIME NOT NULL
) ENGINE=InnoDB;

-- card_type: auto (legacy compatibility), quote, photo, video.
-- poster/image: an upload filename, or an existing assets/front/media path.
-- sort_order: ascending; equal values are ordered by id ascending.
-- rating: 0 hides stars, 1-5 shows the corresponding star count on quote cards.
-- youtube_link: retained for YouTube/direct-video URLs.
-- type: retained as Image/Video for compatibility with older code.
-- Defaults are imported ONLY when the relevant table is empty during the
-- first migration. The marker is written atomically with that import.
-- This SQL is schema-only; Home_content_model performs the content import.
