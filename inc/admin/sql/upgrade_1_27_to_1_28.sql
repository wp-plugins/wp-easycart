;
CREATE TABLE IF NOT EXISTS `ec_product_google_attributes` (
  `product_google_attribute_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this table.',
  `product_id` INTEGER(11) NOT NULL COMMENT 'Link to a specific product.',
  `attribute_value` TEXT COLLATE utf8_general_ci COMMENT 'json data stored here to use with product in google merchant feed.',
  PRIMARY KEY (`product_google_attribute_id`),
  UNIQUE KEY `product_google_attribute_id` (`product_google_attribute_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';