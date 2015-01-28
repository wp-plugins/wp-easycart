;
CREATE TABLE IF NOT EXISTS `ec_product_google_attributes` (
  `product_google_attribute_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this table.',
  `product_id` INTEGER(11) NOT NULL COMMENT 'Link to a specific product.',
  `attribute_value` TEXT COLLATE utf8_general_ci COMMENT 'json data stored here to use with product in google merchant feed.',
  PRIMARY KEY (`product_google_attribute_id`),
  UNIQUE KEY `product_google_attribute_id` (`product_google_attribute_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE ec_order ADD `agreed_to_terms` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'This value is used to verify the user agreed to your terms and conditions during checkout.';
ALTER TABLE ec_order ADD `order_ip_address` VARCHAR(125) NOT NULL DEFAULT '' COMMENT 'The IP Address of the user during checkout, for evidence later if necessary.';