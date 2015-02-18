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
CREATE TABLE IF NOT EXISTS `ec_affiliate_rule` (
	`affiliate_rule_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this table.',
	`rule_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Human readable name for the rule created, not used in application.',
	`rule_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Rule type can be none, percentage, or amount.',
	`rule_amount` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'This is the amount to apply for the type of rule selected.',
	`rule_limit` INT(11) NOT NULL DEFAULT '0' COMMENT 'This limits the number of an item per order that can be redeemed.',
	`rule_active` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'This turns the rule on or off.',
	`rule_recurring` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'This applies to subscriptions and turns commssion on or off when renewing a subscription each month.',
	PRIMARY KEY (`affiliate_rule_id`),
	UNIQUE KEY `affiliate_rule_id` (`affiliate_rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';
CREATE TABLE IF NOT EXISTS `ec_affiliate_rule_to_product` (
  `rule_to_product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this table.',
  `affiliate_rule_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Connects this to the ec_affiliate_rule table.',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Connects this to the ec_product table.',
  PRIMARY KEY (`rule_to_product_id`),
  UNIQUE KEY `rule_to_product_id` (`rule_to_product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';
CREATE TABLE IF NOT EXISTS `ec_affiliate_rule_to_affiliate` (
  `rule_to_account_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this table.',
  `affiliate_rule_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Connects this to the ec_affiliate_rule table.',
  `affiliate_id` varchar(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Connects this to the affiliate ID in the applicable affiliate plugin.',
  PRIMARY KEY (`rule_to_account_id`),
  UNIQUE KEY `rule_to_account_id` (`rule_to_account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE ec_product ADD `is_shippable` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Turn shipping on/off for this product.';
ALTER TABLE ec_orderdetail ADD `is_shippable` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Quick reference to if this product is shippable';
ALTER TABLE ec_optionitem ADD `optionitem_allow_download` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Gives the ability to disallow a download via option set.';
ALTER TABLE ec_order_option ADD `optionitem_allow_download` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Gives the ability to disallow a download via option set.';
ALTER TABLE ec_order_option MODIFY `option_price_change` varchar(128) NOT NULL DEFAULT '' COMMENT 'The display value for a price change on this option.';
ALTER TABLE ec_optionitem ADD `optionitem_disallow_shipping` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Gives the ability to disallow shipping on a product via option set.';
CREATE TABLE `ec_code` (
  `code_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for this table.',
  `code_val` VARCHAR(512) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'Code value to be distributed to customers.',
  `product_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'The product_id that this code applies.',
  `orderdetail_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Once sold, the orderdetail_id that owns this code.',
  PRIMARY KEY (`code_id`),
  UNIQUE KEY `code_id` (`code_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
;
ALTER TABLE ec_product ADD `include_code` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Should this product include a code on checkout.';
ALTER TABLE ec_orderdetail ADD `include_code` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Should this product include a code on checkout.';