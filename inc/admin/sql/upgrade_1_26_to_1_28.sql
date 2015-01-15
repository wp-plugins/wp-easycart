;
ALTER TABLE ec_optionitem ADD `optionitem_price_multiplier` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'This multiplies your unit price by the value here.';
ALTER TABLE ec_optionitem ADD `optionitem_weight_multiplier` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'This multiplies your weight by the value here.';
ALTER TABLE ec_shippingrate ADD `free_shipping_at` FLOAT(15,3) NOT NULL DEFAULT '-1.000' COMMENT 'This is a subtotal price at which a live or method based rate gives the customer free shipping.';
CREATE TABLE IF NOT EXISTS `ec_product_google_attributes` (
  `product_google_attribute_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this table.',
  `product_id` INTEGER(11) NOT NULL COMMENT 'Link to a specific product.',
  `attribute_value` TEXT COLLATE utf8_general_ci COMMENT 'json data stored here to use with product in google merchant feed.',
  PRIMARY KEY (`product_google_attribute_id`),
  UNIQUE KEY `product_google_attribute_id` (`product_google_attribute_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';