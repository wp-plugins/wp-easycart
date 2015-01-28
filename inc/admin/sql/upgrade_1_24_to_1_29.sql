;
ALTER TABLE ec_setting ADD `ups_ship_from_state` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This sets the ship from state when using UPS.';
ALTER TABLE ec_setting ADD `ups_negotiated_rates` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'This sets the ship from state when using UPS.';
ALTER TABLE ec_setting ADD `canadapost_username` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post API username.';
ALTER TABLE ec_setting ADD `canadapost_password` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post API password.';
ALTER TABLE ec_setting ADD `canadapost_customer_number` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post customer number.';
ALTER TABLE ec_setting ADD `canadapost_contract_id` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post contract id (optional for special rates).';
ALTER TABLE ec_setting ADD `canadapost_test_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'This points to the test or live API URL for Canada Post.';
ALTER TABLE ec_setting ADD `canadapost_ship_from_zip` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post ship from zip.';
ALTER TABLE ec_shippingrate ADD `is_canadapost_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'This sets the rate type to Canada Post.';
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
ALTER TABLE ec_order ADD `agreed_to_terms` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'This value is used to verify the user agreed to your terms and conditions during checkout.';
ALTER TABLE ec_order ADD `order_ip_address` VARCHAR(125) NOT NULL DEFAULT '' COMMENT 'The IP Address of the user during checkout, for evidence later if necessary.';