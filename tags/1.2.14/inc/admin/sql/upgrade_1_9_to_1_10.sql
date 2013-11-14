;
ALTER TABLE ec_product ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_menulevel1 ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_menulevel2 ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_menulevel3 ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_category ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_manufacturer ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';