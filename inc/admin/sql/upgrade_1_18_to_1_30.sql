;
ALTER TABLE ec_setting ADD `fraktjakt_address` VARCHAR(120) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_city` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_state` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_zip` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_country` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_product ADD `min_purchase_quantity` INT(11) NOT NULL DEFAULT '0' COMMENT 'Optional minimum amount required for during purchase.';
ALTER TABLE ec_user ADD `exclude_tax` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give customer tax free purchases.';
ALTER TABLE ec_user ADD `exclude_shipping` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give free shipping to this customer.';
ALTER TABLE ec_product ADD `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.';
ALTER TABLE ec_orderdetail ADD `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.';
ALTER TABLE ec_download ADD `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.';
ALTER TABLE ec_product ADD `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.';
ALTER TABLE ec_orderdetail ADD `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.';
ALTER TABLE ec_download ADD `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.';
ALTER TABLE ec_product ADD `catalog_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Turns catalog mode on for individual product';
ALTER TABLE ec_product ADD `catalog_mode_phrase` VARCHAR(1024) DEFAULT NULL COMMENT 'Sets a phrase to appear instead of add to cart button';
ALTER TABLE ec_product ADD `inquiry_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'turns inquiry mode on and replaces add to cart with link button';
ALTER TABLE ec_product ADD `inquiry_url` VARCHAR(1024) DEFAULT NULL COMMENT 'inquiry url where button will take customer instead of add to cart';
ALTER TABLE ec_product ADD `is_deconetwork` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Makes this a DecoNetwork product, allowing for custom designed goods.';
ALTER TABLE ec_product ADD `deconetwork_mode` VARCHAR(64) NOT NULL DEFAULT 'designer' COMMENT 'If using deconetwork, enter designer, blank, designer_predec, predec, design, or view_design as a value.';
ALTER TABLE ec_product ADD `deconetwork_product_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the product id to send the customer to.';
ALTER TABLE ec_product ADD `deconetwork_size_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the size id to force the product into by default, optional.';
ALTER TABLE ec_product ADD `deconetwork_color_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the color id to force the product into by default, optional.';
ALTER TABLE ec_product ADD `deconetwork_design_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the design id to force the product into by default, optional.';
ALTER TABLE ec_tempcart ADD `is_deconetwork` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Sets this item as a DecoNetwork item and changes the display to work with this product type.';
ALTER TABLE ec_tempcart ADD `deconetwork_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The unique id sent back from the DecoNetwork when adding to cart.';
ALTER TABLE ec_tempcart ADD `deconetwork_name` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The name of the product from the DecoNetwork.';
ALTER TABLE ec_tempcart ADD `deconetwork_product_code` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The product code from the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_options` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The options selected by the customer on the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_edit_link` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The edit link provided by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_color_code` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The color code of the shirt by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_product_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The product id of this product on the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_image_link` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The image link provided by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_discount` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'Any discount provided by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_tax` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'The tax amount by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_total` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'The total line item cost by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_version` INTEGER(11) NOT NULL DEFAULT 1 COMMENT 'A value updated each time the customer returns from the Deconetwork for this product, which is used to update the image to the user.';
ALTER TABLE ec_orderdetail ADD `is_deconetwork` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'This tells the system that it is a DecoNetwork product and changes the display type accordingly.';
ALTER TABLE ec_orderdetail ADD `deconetwork_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'The unique id for this item provided by the DecoNetwork';
ALTER TABLE ec_orderdetail ADD `deconetwork_name` varchar(512) NOT NULL DEFAULT '' COMMENT 'The name provided by the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_product_code` varchar(64) NOT NULL DEFAULT '' COMMENT 'The product code provided by the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_options` varchar(512) NOT NULL DEFAULT '' COMMENT 'The options selected by the customer on the DecoNetwork site.';
ALTER TABLE ec_orderdetail ADD `deconetwork_color_code` varchar(64) NOT NULL DEFAULT '' COMMENT 'The color code of the selected shirt provided by the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_product_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'The product id on the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_image_link` varchar(512) NOT NULL DEFAULT '' COMMENT 'The link to the image on the DecoNetwork.';
ALTER TABLE ec_order ADD `order_gateway` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The gateway used during checkout ONLY IF a refund functionality is available.';
ALTER TABLE ec_order ADD `affirm_charge_id` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'The Affirm Charge ID added during checkout';
ALTER TABLE ec_product ADD `short_description` VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Short description for the product.';
ALTER TABLE ec_product ADD `display_type` INT(11) NOT NULL DEFAULT 1 COMMENT 'The display type selected for a given product.';
ALTER TABLE ec_product ADD `image_hover_type` INT(11) NOT NULL DEFAULT 3 COMMENT 'The hover effect of a product image.';
ALTER TABLE ec_product ADD `tag_type` INT(11) NOT NULL DEFAULT 0 COMMENT 'The type of optional tag applied to the product.';
ALTER TABLE ec_product ADD `tag_bg_color` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'The optional bg color of a tag applied to the product.';
ALTER TABLE ec_product ADD `tag_text_color` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'The optional text color of a tag applied to a product.';
ALTER TABLE ec_product ADD `tag_text` VARCHAR(256) NOT NULL DEFAULT '' COMMENT 'The option text of a tag applied to a product.';
ALTER TABLE ec_product ADD `image_effect_type` VARCHAR(20) NOT NULL DEFAULT 'none' COMMENT 'An optional border or shadow can be applied to a product.';
CREATE TABLE IF NOT EXISTS `ec_pageoption` (
  `pageoption_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_pageoption',
  `post_id` INT(11) NOT NULL DEFAULT '0' COMMENT 'The post id for this WordPress page',
  `option_type` VARCHAR(155) NOT NULL DEFAULT '' COMMENT 'The key for the pageoption.',
  `option_value` TEXT NOT NULL COMMENT 'The value for the pageoption',
  PRIMARY KEY (`pageoption_id`),
  UNIQUE KEY `pageoption_id` (`pageoption_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=122 CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8
;
ALTER TABLE ec_tempcart ADD `gift_card_email` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'The value of the gift card email if needed.';
ALTER TABLE ec_orderdetail ADD `gift_card_email` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The gift card email is needed.';
ALTER TABLE ec_address ADD `company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Company name relating to this address.';
ALTER TABLE ec_order ADD `billing_company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Billing company name for this order if used.';
ALTER TABLE ec_order ADD `shipping_company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Shipping company name for this order if used.';
ALTER TABLE ec_optionitem ADD `optionitem_model_number` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'Model number extension that gets added to product model number if selected.';
ALTER TABLE ec_tempcart_optionitem ADD `optionitem_model_number` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'Model number extension that gets added to product model number if selected.';
ALTER TABLE ec_order ADD `guest_key` VARCHAR(124) NOT NULL DEFAULT '' COMMENT 'Used for guest checkouts to allow a guest to view an order.';
ALTER TABLE ec_user ADD `user_notes` text COLLATE utf8_general_ci COMMENT 'This is available for an admin to keep notes on a user.';
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