;
CREATE TABLE IF NOT EXISTS `ec_address` (
  `address_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique idenifier for the ec_address table.',
  `user_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Ensures that only the user who creates the entry can access the address information.',
  `first_name` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'First name for this address.',
  `last_name` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Last name for this address.',
  `address_line_1` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'First line address value for this address.',
  `address_line_2` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'Second line address value for this address.',
  `city` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'City for this address.',
  `state` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'State for this address.',
  `zip` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Zip code for this address.',
  `country` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Country for this address.',
  `phone` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Phone number relating to this address',
  `company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Company name relating to this address.',
  PRIMARY KEY (`address_id`),
  UNIQUE KEY `address_id` (`address_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=56 AVG_ROW_LENGTH=88 CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
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
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_affiliate_rule_to_product` (
  `rule_to_product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this table.',
  `affiliate_rule_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Connects this to the ec_affiliate_rule table.',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Connects this to the ec_product table.',
  PRIMARY KEY (`rule_to_product_id`),
  UNIQUE KEY `rule_to_product_id` (`rule_to_product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_affiliate_rule_to_affiliate` (
  `rule_to_account_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this table.',
  `affiliate_rule_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Connects this to the ec_affiliate_rule table.',
  `affiliate_id` varchar(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Connects this to the affiliate ID in the applicable affiliate plugin.',
  PRIMARY KEY (`rule_to_account_id`),
  UNIQUE KEY `rule_to_account_id` (`rule_to_account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_category` (
  `category_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for the ec_category table.',
  `category_name` VARCHAR(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name/Description of the category of products. Used on the administrative side of the store.',
  `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `CategoryID` (`category_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 AVG_ROW_LENGTH=32 CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_categoryitem` (
  `categoryitem_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for the ec_categoryitem table.',
  `category_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the ec_categoryitem table to the ec_category table.',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the ec_categoryitem table to the ec_product table.',
  PRIMARY KEY (`categoryitem_id`),
  UNIQUE KEY `CategoryItemID` (`categoryitem_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=27 AVG_ROW_LENGTH=13 ROW_FORMAT=FIXED CHARACTER SET 'utf8'
 COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
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
CREATE TABLE IF NOT EXISTS `ec_country` (
  `id_cnt` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for the ec_country table.',
  `name_cnt` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Name of the country.',
  `iso2_cnt` CHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   '2 digit country code.',
  `iso3_cnt` CHAR(3) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   '3 digit country code.',
  `sort_order` INTEGER(11) NOT NULL COMMENT
   'User assigned order of countries for drop down menus.',
  `vat_rate_cnt` float(9,3) NOT NULL DEFAULT '0.000' COMMENT 
  'User assigned value for VAT based on purchaser shipping country.',
  PRIMARY KEY (`id_cnt`)
)ENGINE=MyISAM
AUTO_INCREMENT=244 AVG_ROW_LENGTH=30 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_customfield` (
  `customfield_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `field_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`customfield_id`),
  UNIQUE KEY `customfield_id` (`customfield_id`)
)ENGINE=MyISAM 
AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0
;
CREATE TABLE IF NOT EXISTS `ec_customfielddata` (
  `customfielddata_id` int(11) NOT NULL AUTO_INCREMENT,
  `customfield_id` int(11) DEFAULT NULL,
  `table_id` int(11) NOT NULL,
  `data` blob NOT NULL,
  PRIMARY KEY (`customfielddata_id`)
)ENGINE=MyISAM 
AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0
;
CREATE TABLE IF NOT EXISTS `ec_dblog` (
  `dblog_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_dblog.',
  `entry_date` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT
   CURRENT_TIMESTAMP COMMENT 'The date of the entry.',
  `entry_type` VARCHAR(25) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The type of event that is being logged.',
  PRIMARY KEY (`dblog_id`)
)ENGINE=InnoDB
AUTO_INCREMENT=5 AVG_ROW_LENGTH=4096 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_download` (
  `download_id` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The unique identifier for ec_download.',
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this downloadable good was purchased and then created as a ec_download item.',
  `download_count` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Number of downloads to date.',
  `order_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'The ec_order item this downloadable good relates to.',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'The product this downloadable good relates to.',
  `download_file_name` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The name of the file to download.',
  `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.',
  `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.',
  PRIMARY KEY (`download_id`),
  UNIQUE KEY `download_id` (`download_id`)
)ENGINE=MyISAM
AVG_ROW_LENGTH=124 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_giftcard` (
  `giftcard_id` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The unique identifier for the ec_giftcard table.',
  `amount` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT
   'Amount left on the gift card.',
  `message` TEXT COLLATE utf8_general_ci COMMENT
   'Message displayed when a gift card is used.',
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_id` (`giftcard_id`)
)ENGINE=MyISAM
AVG_ROW_LENGTH=47 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_manufacturer` (
  `manufacturer_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_manufacturer.',
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Name for a manufacturer.',
  `clicks` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Count of the number of times this manufacturer has a product viewed.',
  `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
    'Post ID to connect the product to the WordPress custom post type structure.',
  PRIMARY KEY (`manufacturer_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=15 AVG_ROW_LENGTH=24 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_menulevel1` (
  `menulevel1_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_menulevel1.',
  `name` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'A unique menu level 1 name.',
  `order` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'User defined order of the ec_menulevel1 items.',
  `clicks` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Number of times this menu item has been clicked.',
  `seo_keywords` varchar(512) NOT NULL DEFAULT '',
  `seo_description` blob,
  `banner_image` varchar(512) NOT NULL DEFAULT '',
  `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
    'Post ID to connect the product to the WordPress custom post type structure.',
  PRIMARY KEY (`menulevel1_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=24 AVG_ROW_LENGTH=30 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_menulevel2` (
  `menulevel2_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_menulevel2.',
  `menulevel1_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the ec_menulevel2 table to the ec_menulevel1 table.',
  `name` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Name of this ec_menulevel2 item.',
  `order` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'User defined order of the ec_menulevel2 items.',
  `clicks` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Number of times this menu item has been clicked.',
  `seo_keywords` varchar(512) NOT NULL DEFAULT '',
  `seo_description` blob,
  `banner_image` varchar(512) NOT NULL DEFAULT '',
  `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
    'Post ID to connect the product to the WordPress custom post type structure.',
  PRIMARY KEY (`menulevel2_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=48 AVG_ROW_LENGTH=30 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_menulevel3` (
  `menulevel3_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_menulevel3.',
  `menulevel2_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates ec_menulevel3 to ec_menulevel2.',
  `name` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Name of this menu item.',
  `order` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'User defined order of the ec_menulevel3 items.',
  `clicks` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Number of times this menu item has been clicked.',
  `seo_keywords` varchar(512) NOT NULL DEFAULT '',
  `seo_description` blob,
  `banner_image` varchar(512) NOT NULL DEFAULT '',
  `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
    'Post ID to connect the product to the WordPress custom post type structure.',
  PRIMARY KEY (`menulevel3_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=38 AVG_ROW_LENGTH=38 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_option` (
  `option_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique ID for the ec_option table.',
  `option_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 
   'Name of the option set.',
  `option_label` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Label for option set, used in the display of the option set in a combo box.',
  `option_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'combo' COMMENT 
   'The type of input for the option.',
  `option_required` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 
   'Is this option required.',
  `option_error_text` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Text displayed when option required and no value selected.',
  PRIMARY KEY (`option_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=13 AVG_ROW_LENGTH=40 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_option_to_product` (
  `option_to_product_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 
   'Unique ID for this table.',
  `option_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'The option_id to connect to the ec_option table',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'The product_id to connect the ec_product table',
  `role_label` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'all' COMMENT
   'The role label for this option',
  `option_order` INTEGER(11) NOT NULL DEFAULT '0' COMMENT
   'The order value to order these options',
  PRIMARY KEY (`option_to_product_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=28 CHARACTER SET'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_optionitem` (
  `optionitem_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Gives the ec_optionitem table a unique ID.',
  `option_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates ec_optionitem to ec_option using the option_id field.',
  `optionitem_name` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Name of this optionitem.',
  `optionitem_price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Price change value for an optionitem.',
  `optionitem_price_onetime` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Price change one-time addition to total price.',
  `optionitem_price_override` FLOAT(15,3) NOT NULL DEFAULT -1.000 COMMENT 'Price change to override product price.',
  `optionitem_price_multiplier` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'This multiplies your unit price by the value here.',
  `optionitem_weight` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Weight change value for an optionitem.',
  `optionitem_weight_onetime` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Weight change one-time addition to total weight.',
  `optionitem_weight_override` FLOAT(15,3) NOT NULL DEFAULT -1.000 COMMENT 'Weight change to override product weight.',
  `optionitem_weight_multiplier` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'This multiplies your weight by the value here.',
  `optionitem_order` INTEGER(11) NOT NULL DEFAULT 1 COMMENT 'Gives a user selected order of display for the optionitems.',
  `optionitem_icon` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Gives the optionitem an icon for displaying optionitem swatch sets.',
  `optionitem_initial_value` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'For some options an initial value is useful.',
  `optionitem_model_number` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'Model number extension that gets added to product model number if selected.',
  `optionitem_allow_download` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Gives the ability to disallow a download via option set.',
  `optionitem_disallow_shipping` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Gives the ability to disallow shipping on a product via option set.',
  PRIMARY KEY (`optionitem_id`),
  UNIQUE KEY `unique_name_ova` (`option_id`, `optionitem_name`),
  KEY `idopt_ova` (`option_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=2995 AVG_ROW_LENGTH=43 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_optionitemimage` (
  `optionitemimage_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_optionitemimage.',
  `optionitem_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the ec_optionitemimage to a ec_optionitem.',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the ec_optionitemimage to a ec_product.',
  `image1` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'Filename referencing the first image.',
  `image2` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'Filename referencing the second image.',
  `image3` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'Filename referencing the third image.',
  `image4` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'Filename referencing the fourth image.',
  `image5` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'Filename referencing the fifth image.',
  PRIMARY KEY (`optionitemimage_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=184 AVG_ROW_LENGTH=85 CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_optionitemquantity` (
  `optionitemquantity_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_optionitemquantity.',
  `product_id` INTEGER(17) NOT NULL DEFAULT 0 COMMENT
   'Relates this ec_optionitemquantity to a ec_product.',
  `optionitem_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected optionitem in ec_optionitemquantity to the cooresponding ec_optionitem.'
   ,
  `optionitem_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected optionitem in ec_optionitemquantity to the cooresponding ec_optionitem.'
   ,
  `optionitem_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected optionitem in ec_optionitemquantity to the cooresponding ec_optionitem.'
   ,
  `optionitem_id_4` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected optionitem in ec_optionitemquantity to the cooresponding ec_optionitem.'
   ,
  `optionitem_id_5` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected optionitem in ec_optionitemquantity to the cooresponding ec_optionitem.'
   ,
  `quantity` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'The amount left in stock for this group of ids.',
  PRIMARY KEY (`optionitemquantity_id`),
  UNIQUE KEY `OptionItemQuantityID` (`optionitemquantity_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=30922 AVG_ROW_LENGTH=23 CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_order` (
  `order_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_order.',
  `user_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the ec_order to a ec_user.',
  `user_email` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The contact email for this order.',
  `user_level` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'shopper',
  `last_updated` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The last time this order was updated.',
  `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The timestamp for when the order was placed.',
  `orderstatus_id` INTEGER(11) NOT NULL DEFAULT 5 COMMENT 'The orderstatus.status_id reference to the status of the order.',
  `order_weight` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The total weight of the order.',
  `sub_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The order sub total.',
  `tax_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The order tax total.',
  `shipping_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The order shipping total.',
  `discount_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The order discount total.',
  `vat_total` FLOAT(15,3) NOT NULL DEFAULT 0.000,
  `duty_total` FLOAT(15,3) NOT NULL DEFAULT 0.000,
  `grand_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The order grand total.',
  `refund_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Amount of the order that has been refunded.',
  `promo_code` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If a promo code was used, enter it here.',
  `giftcard_id` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If a gift card was used, put the giftcard_id in this field.',
  `use_expedited_shipping` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the customer paid for expedited shipping.',
  `shipping_method` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The shipping method used for this order.',
  `shipping_carrier` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The name of the shipping carrier.',
  `tracking_number` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Tracking number for this order if it has been shipped.',
  `billing_first_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The first name for the billing address.',
  `billing_last_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The last name for the billing address.',
  `billing_address_line_1` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The first address line for the billing address.',
  `billing_address_line_2` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The second address line for the billing address.',
  `billing_city` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The city for the billing address.',
  `billing_state` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The state for the billing address.',
  `billing_country` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The country for the billing address.',
  `billing_zip` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The zip code for the billing address.',
  `billing_phone` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The phone number for the billing address.',
  `shipping_first_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The first name for the shipping address.',
  `shipping_last_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The last name for the shipping address.',
  `shipping_address_line_1` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The first address line for the shipping address.',
  `shipping_address_line_2` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The second address line for the shipping address.',
  `shipping_city` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The city for the shipping address.',
  `shipping_state` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The state for the shipping address.',
  `shipping_country` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The country for the shipping address.',
  `shipping_zip` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The zip code for the shipping address.',
  `shipping_phone` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The phone number for the shipping address.',
  `payment_method` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The method of payment for this order.',
  `paypal_email_id` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The paypal email id.',
  `paypal_transaction_id` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The paypal transaction id.',
  `paypal_payer_id` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The paypal payer id.',
  `order_viewed` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the order has been viewed by the administration console.',
  `order_notes` TEXT COLLATE utf8_general_ci COMMENT 'Notes only available on the backend.',
  `order_customer_notes` BLOB,
  `txn_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific TXN ID.',
  `edit_sequence` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT  'Quickbooks Specific Edit Sequence.',
  `creditcard_digits` VARCHAR(4) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If credit card checkout is used, saves the last four digits here.',
  `fraktjakt_order_id` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Order ID for the Fraktjakt shipment.',
  `fraktjakt_shipment_id` VARCHAR(20) COLLATE utf8_general_ci DEFAULT '' COMMENT 'Shipment ID for the Fraktjakt shipment.',
  `stripe_charge_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Stripe Charge ID if Stripe used.',
  `nets_transaction_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Nets Transaction ID if Nets used.',
  `subscription_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Subscription ID from the ec_subscription table if order was a subscription order.',
  `order_gateway` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The gateway used during checkout ONLY IF a refund functionality is available.',
  `affirm_charge_id` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'The Affirm Charge ID added during checkout',
  `billing_company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Billing company name for this order if used.',
  `shipping_company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Shipping company name for this order if used.',
  `guest_key` VARCHAR(124) NOT NULL DEFAULT '' COMMENT 'Used for guest checkouts to allow a guest to view an order.',
  `agreed_to_terms` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'This value is used to verify the user agreed to your terms and conditions during checkout.',
  `order_ip_address` VARCHAR(125) NOT NULL DEFAULT '' COMMENT 'The IP Address of the user during checkout, for evidence later if necessary.',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_id` (`order_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1771 AVG_ROW_LENGTH=225 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_order_option` (
  `order_option_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this table.',
  `orderdetail_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Referece to the ec_orderdetail table.',
  `option_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Name of the option, e.g. Shirt Color.',
  `optionitem_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Name of the optionitem, e.g. Large. Only used for a grid option.',
  `option_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'combo' COMMENT 'The type of option set, e.g. combo.',
  `option_value` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'The value of this selected option.',
  `option_price_change` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The display value for a price change on this option.',
  `optionitem_allow_download` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Gives the ability to disallow a download via option set.',
  PRIMARY KEY (`order_option_id`)
)ENGINE=MyISAM 
AUTO_INCREMENT=22 CHARACTER SET 'utf8' COLLATE
'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_orderdetail` (
  `orderdetail_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_orderdetail.',
  `order_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the ec_orderdetail table to the ec_order table.',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the ec_orderdetail table to the ec_product table.',
  `title` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'The title of a product as specified at time of the order capture.',
  `model_number` VARCHAR(255) COLLATE utf8_general_ci NOT NULL COMMENT 'The model number of a product as specified and captured at time of order.',
  `order_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date the order was placed.',
  `unit_price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Price of the product at the time of purchase.',
  `total_price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Final price of this line item.',
  `quantity` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Number of product purchased.',
  `image1` VARCHAR(255) COLLATE utf8_general_ci NOT NULL COMMENT 'The image 1 of the product at time of order capture.',
  `optionitem_name_1` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The optionitem name selected at time of purchase.',
  `optionitem_name_2` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The optionitem name selected at time of purchase.',
  `optionitem_name_3` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The optionitem name selected at time of purchase.',
  `optionitem_name_4` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The optionitem name selected at time of purchase.',
  `optionitem_name_5` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The optionitem name selected at time of purchase.',
  `optionitem_label_1` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option Item 1 Label',
  `optionitem_label_2` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option Item 2 Label',
  `optionitem_label_3` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option Item 3 Label',
  `optionitem_label_4` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option Item 4 Label',
  `optionitem_label_5` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option Item 5 Label',
  `optionitem_price_1` FLOAT(15,3) NOT NULL DEFAULT '0.000',
  `optionitem_price_2` FLOAT(15,3) NOT NULL DEFAULT '0.000',
  `optionitem_price_3` FLOAT(15,3) NOT NULL DEFAULT '0.000',
  `optionitem_price_4` FLOAT(15,3) NOT NULL DEFAULT '0.000',
  `optionitem_price_5` FLOAT(15,3) NOT NULL DEFAULT '0.000',
  `use_advanced_optionset` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Used for display purposes to notify if this item uses advanced option sets.',
  `giftcard_id` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Relates the ec_orderdetail item to a ec_giftcard item if a gift card was ordered.',
  `shipper_id` INTEGER(11) DEFAULT 0,
  `shipper_first_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'First name of the shipper.',
  `shipper_last_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Last name of the shipper.',
  `gift_card_message` TEXT COLLATE utf8_general_ci COMMENT 'User entered gift card message.',
  `gift_card_from_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'User entered name that a gift card is from.',
  `gift_card_to_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'User entered name that a gift card is to.',
  `is_download` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Quick reference to if this sale was a downloadable good.',
  `is_giftcard` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Quick reference to if this sale was a gift card.',
  `is_taxable` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Quick reference to if this product is taxable.',
  `is_shippable` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Quick reference to if this product is shippable',
  `download_file_name` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Location of a downloadable item at time of purchase. This value allows for versioning and purchasing different versions.',
  `download_key` VARCHAR(510) COLLATE utf8_general_ci DEFAULT '' COMMENT 'The key of the downloadable good purchased.',
  `maximum_downloads_allowed` INTEGER(11) NOT NULL DEFAULT 0,
  `download_timelimit_seconds` INTEGER(11) DEFAULT 0,
  `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.',
  `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.',
  `is_deconetwork` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'This tells the system that it is a DecoNetwork product and changes the display type accordingly.',
  `deconetwork_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'The unique id for this item provided by the DecoNetwork',
  `deconetwork_name` varchar(512) NOT NULL DEFAULT '' COMMENT 'The name provided by the DecoNetwork.',
  `deconetwork_product_code` varchar(64) NOT NULL DEFAULT '' COMMENT 'The product code provided by the DecoNetwork.',
  `deconetwork_options` varchar(512) NOT NULL DEFAULT '' COMMENT 'The options selected by the customer on the DecoNetwork site.',
  `deconetwork_color_code` varchar(64) NOT NULL DEFAULT '' COMMENT 'The color code of the selected shirt provided by the DecoNetwork.',
  `deconetwork_product_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'The product id on the DecoNetwork.',
  `deconetwork_image_link` varchar(512) NOT NULL DEFAULT '' COMMENT 'The link to the image on the DecoNetwork.',
  `gift_card_email` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The gift card email is needed.',
  `include_code` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Should this product include a code on checkout.',
  PRIMARY KEY (`orderdetail_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1349 AVG_ROW_LENGTH=130 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_orderstatus` (
  `status_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The status_id is used by gateways to set easycart order status.',
  `order_status` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT ''
   COMMENT 'Holds various order status fields that are acceptable',
  `is_approved` TINYINT(1) DEFAULT 0 COMMENT
   'If 1, then this status is a recognized approved order status for downloads and giftcard type purchases.'
   ,
  PRIMARY KEY (`status_id`),
  UNIQUE KEY `status_id` (`status_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=16 AVG_ROW_LENGTH=32 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
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
CREATE TABLE IF NOT EXISTS `ec_perpage` (
  `perpage_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_perpage.',
  `perpage` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'The value of this ec_perpage item.',
  PRIMARY KEY (`perpage_id`),
  UNIQUE KEY `perpageid` (`perpage_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=6 AVG_ROW_LENGTH=9 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_pricepoint` (
  `pricepoint_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_pricepoint.',
  `is_less_than` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, item is a less than type price point.',
  `is_greater_than` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'if selected, item is a greater than type price point.',
  `low_point` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT
   'If is_greater_than, low_point is the value used, but if is a between value type then it is the low end of the range.'
   ,
  `high_point` FLOAT(15,3) DEFAULT 0.000 COMMENT
   'If is_less_than, high_point is the value used, but if is a between value type then it is the high end of the range.'
   ,
  `order` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'User defined order of ec_pricepoint.',
  PRIMARY KEY (`pricepoint_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=14 AVG_ROW_LENGTH=19 ROW_FORMAT=FIXED CHARACTER SET 'utf8'
 COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_pricetier` (
  `pricetier_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_pricetier.',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the ec_pricetier to an ec_product.',
  `price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT
   'The price used when this tier is active.',
  `quantity` INTEGER(11) NOT NULL DEFAULT 10 COMMENT
   'The quantity required in the cart to activate the new price.',
  PRIMARY KEY (`pricetier_id`),
  UNIQUE KEY `PriceTierID` (`pricetier_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=35 AVG_ROW_LENGTH=17 ROW_FORMAT=FIXED CHARACTER SET 'utf8'
 COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_product` (
  `product_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for the ec_product table.',
  `model_number` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Model number used for SEO and display purposes to identify a product by a meaningful term.',
  `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.',
  `activate_in_store` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Activate this product for display in the store. Used to allow admin to create a product and perfect before displaying.',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Title of the product.',
  `description` TEXT COLLATE utf8_general_ci COMMENT 'Long description for the product.',
  `specifications` TEXT COLLATE utf8_general_ci COMMENT 'Specifications for the product.',
  `price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Price of the product.',
  `list_price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Previous price, used to display a simple guaranteed discount (e.g. used to be 30.00, now 20.00).',
  `vat_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'VAT rate for this product, used in store calculations.',
  `handling_price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'This price represents an extra handling charge  added to the shipping.',
  `stock_quantity` INTEGER(7) NOT NULL DEFAULT 0 COMMENT 'Simple stock quantity control, used to check overall stock total.',
  `min_purchase_quantity` INT(11) NOT NULL DEFAULT '0' COMMENT 'Optional minimum amount required for during purchase.',
  `weight` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Weight for the product.',
  `width` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Width of the product in the default shipping unit.',
  `height` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Height of the product in the default shipping unit.',
  `length` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Length of the product in the default shipping unit.',
  `seo_description` TEXT COLLATE utf8_general_ci COMMENT 'SEO description for the product. Should be short and used in the META-DATA.',
  `seo_keywords` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'SEO keywords for the product. Used in the META-DATA.',
  `use_specifications` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this product should display the specifications section.',
  `use_customer_reviews` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this product should display and allow for customer reviews.',
  `manufacturer_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Used to connect the product to the cooresponding manufacturer.',
  `download_file_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'File name for a downloadable product.',
  `image1` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Image 1 used for a basic product.',
  `image2` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Image 2 used for a basic product.',
  `image3` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Image 3 used for a basic product.',
  `image4` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Image 4 used for a basic product.',
  `image5` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Image 5 used for a basic product.',
  `option_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option choice to ec_option.',
  `option_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option choice to ec_option.',
  `option_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option choice to ec_option.',
  `option_id_4` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option choice to ec_option.',
  `option_id_5` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option choice to ec_option.',
  `use_advanced_optionset` TINYINT(1) NOT NULL DEFAULT 0 COMMENT  'If true, uses the advanced, unlimited option set type.',
  `menulevel1_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel1_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel1_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel2_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel2_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel2_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel3_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel3_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `menulevel3_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the product to a menu set.',
  `featured_product_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates a featured product to a product using the product_id.',
  `featured_product_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates a featured product to a product using the product_id.',
  `featured_product_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates a featured product to a product using the product_id.',
  `featured_product_id_4` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates a featured product to a product using the product_id.',
  `is_giftcard` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, treat this product as a gift card item.',
  `is_download` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, treat this product as a downloadable good.',
  `is_donation` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, treat as a donation product.',
  `is_special` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this product will be displayed in the specials widget.',
  `is_taxable` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Turn tax on/off for this product.',
  `is_shippable` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Turn shipping on/off for this product.',
  `is_subscription_item` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Makes this product a subscription product which is purchased individually.',
  `is_preorder` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Makes this product a preorder product, allowing for an authorization of a card without capturing at this time.',
  `added_to_db_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Gives the product a date that it was added to the DB.',
  `show_on_startup` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Show this product on the main store page.',
  `use_optionitem_images` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, images 1-5 of the product will be ignored and the relating optionitem images will be displayed.',
  `use_optionitem_quantity_tracking` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, product will require a quantity entered for each optionitem combination.',
  `views` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'The number of times the product has been viewed.',
  `last_viewed` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The last time this product has been viewed.',
  `show_stock_quantity` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'If selected, quantity tracking for overall product is available and stock quantity visible on product details page.',
  `maximum_downloads_allowed` INTEGER(11) NOT NULL DEFAULT 0,
  `download_timelimit_seconds` INTEGER(11) NOT NULL DEFAULT 0,
  `list_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT  'Quickbooks Specific List ID.',
  `edit_sequence` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence.',
  `subscription_bill_length` INTEGER(11) NOT NULL DEFAULT '1' COMMENT 'Number of the period times to charge the customer, e.g. 3 paired with month is charge once every 3 months.',
  `subscription_bill_period` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'M' COMMENT 'The period of the subscription, valid values are: D, W, M, Y.',
  `trial_period_days` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Length of subscription trial period in days.',
  `stripe_plan_added` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Has this subscription product been added to Stripe.',
  `subscription_plan_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Used to group the subscriptions in a membership plan used for upgrade.',
  `allow_multiple_subscription_purchases` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Should this item be able to be purchased multiple times.',
  `membership_page` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Optional link to a membership content page to be displayed after subscription purchased.',
  `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.',
  `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.',
  `catalog_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Turns catalog mode on for individual product',
  `catalog_mode_phrase` VARCHAR(1024) DEFAULT NULL COMMENT 'Sets a phrase to appear instead of add to cart button',
  `inquiry_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'turns inquiry mode on and replaces add to cart with link button',
  `inquiry_url` VARCHAR(1024) DEFAULT NULL COMMENT 'inquiry url where button will take customer instead of add to cart',
  `is_deconetwork` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Makes this a DecoNetwork product, allowing for custom designed goods.',
  `deconetwork_mode` VARCHAR(64) NOT NULL DEFAULT 'designer' COMMENT 'If using deconetwork, enter designer, blank, designer_predec, predec, design, or view_design as a value.',
  `deconetwork_product_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the product id to send the customer to.',
  `deconetwork_size_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the size id to force the product into by default, optional.',
  `deconetwork_color_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the color id to force the product into by default, optional.',
  `deconetwork_design_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the design id to force the product into by default, optional.',
  `short_description` VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Short description for the product.',
  `display_type` INT(11) NOT NULL DEFAULT 1 COMMENT 'The display type selected for a given product.',
  `image_hover_type` INT(11) NOT NULL DEFAULT 3 COMMENT 'The hover effect of a product image.',
  `tag_type` INT(11) NOT NULL DEFAULT 0 COMMENT 'The type of optional tag applied to the product.',
  `tag_bg_color` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'The optional bg color of a tag applied to the product.',
  `tag_text_color` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'The optional text color of a tag applied to a product.',
  `tag_text` VARCHAR(256) NOT NULL DEFAULT '' COMMENT 'The option text of a tag applied to a product.',
  `image_effect_type` VARCHAR(20) NOT NULL DEFAULT 'none' COMMENT 'An optional border or shadow can be applied to a product.',
  `include_code` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Should this product include a code on checkout.',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_id` (`product_id`),
  UNIQUE KEY `model_number` (`model_number`),
  FULLTEXT KEY `Title` (`title`),
  FULLTEXT KEY `Description` (`description`),
  FULLTEXT KEY `ModelNumber` (`model_number`)
)ENGINE=MyISAM
AUTO_INCREMENT=248 AVG_ROW_LENGTH=1960 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_product_google_attributes` (
  `product_google_attribute_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this table.',
  `product_id` INTEGER(11) NOT NULL COMMENT 'Link to a specific product.',
  `attribute_value` TEXT COLLATE utf8_general_ci COMMENT 'json data stored here to use with product in google merchant feed.',
  PRIMARY KEY (`product_google_attribute_id`),
  UNIQUE KEY `product_google_attribute_id` (`product_google_attribute_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_promocode` (
  `promocode_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT ''
   COMMENT 'The unique identifier for ec_promocode.',
  `is_dollar_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this is a dollar based promotion.',
  `is_percentage_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this is a percentage based promotion.',
  `is_shipping_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this is a shipping based promotion.',
  `is_free_item_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this is a free item based promotion.',
  `is_for_me_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this is a for me based promotion.',
  `by_manufacturer_id` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this promotion applies only to products with a cooresponding manufacturer id.'
   ,
  `by_product_id` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this promotion applies only to products with the cooresponding id.'
   ,
  `by_all_products` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'If selected, this promotion applies to all products and orders.',
  `promo_dollar` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT
   'Discount used when dollar based selected.',
  `promo_percentage` FLOAT(15,2) NOT NULL DEFAULT 0.00 COMMENT
   'Percentage off when a percentage based promotion.',
  `promo_shipping` FLOAT(15,2) NOT NULL DEFAULT 0.00 COMMENT
   'Amount off shipping total when shipping based promotion is used.',
  `promo_free_item` FLOAT(15,2) NOT NULL DEFAULT 0.00 COMMENT
   'Amount off when free item promotion is used.',
  `promo_for_me` FLOAT(15,2) NOT NULL DEFAULT 0.00 COMMENT
   'Amount off when for me type promotion is used.',
  `manufacturer_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'The manufacturer_id used if this promotion is a by_manufacturer_id type.',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'The product_id used if the promotion is a by_product_id type promotion.',
  `message` BLOB NOT NULL COMMENT
   'The message displayed when the promotion is used.',
  `max_redemptions` INTEGER(11) NOT NULL DEFAULT '999' COMMENT 
   'The maximum number of times you can use this promotion code.',
  `times_redeemed` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 
   'This is the number of times this coupon has been redeemed.',

  PRIMARY KEY (`promocode_id`),
  UNIQUE KEY `promoID` (`promocode_id`)
)ENGINE=MyISAM
AVG_ROW_LENGTH=147 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_promotion` (
  `promotion_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_promotion.',
  `name` VARCHAR(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'The name of the promotion.',
  `type` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'The type of promotion this represents.',
  `start_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT
   'The start date for this promotion.',
  `end_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT
   'The end date for this promotion',
  `product_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected product to a ec_product.',
  `product_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected product to a ec_product.',
  `product_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected product to a ec_product.',
  `manufacturer_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected manufacturer to a ec_manufacturer.',
  `manufacturer_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected manufacturer to a ec_manufacturer.',
  `manufacturer_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected manufacturer to a ec_manufacturer.',
  `category_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected category to a ec_category.',
  `category_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected category to a ec_category.',
  `category_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the selected category to a ec_category.',
  `price1` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Promotion price 1.',
  `price2` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Promotion price 2.',
  `price3` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Promotion price 3.',
  `percentage1` DOUBLE(9,2) NOT NULL DEFAULT 0.00 COMMENT
   'Promotion percentage 1.',
  `percentage2` DOUBLE(9,2) NOT NULL DEFAULT 0.00 COMMENT
   'Promotion percentage 2.',
  `percentage3` DOUBLE(9,2) NOT NULL DEFAULT 0.00 COMMENT
   'Promotion percentage 3.',
  `number1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Promotion number 1.',
  `number2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Promotion number 2.',
  `number3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Promotion number 3.',
  `limit` INTEGER(11) NOT NULL DEFAULT 3 COMMENT
   'The limit to how many items can be redeemed for this promotion.',
  PRIMARY KEY (`promotion_id`),
  UNIQUE KEY `PromotionID` (`promotion_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=19 AVG_ROW_LENGTH=76 CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_response` (
  `response_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'Unique id for an order response.',
  `is_error` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'Was this response an error.',
  `processor` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL COMMENT
   'The payment processor used.',
  `order_id` INTEGER(11) DEFAULT NULL COMMENT
   'Order id to relate this gateway response.',
  `response_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT
   'The response time.',
  `response_text` TEXT COLLATE utf8_general_ci COMMENT
   'The response from the gateway.',
  PRIMARY KEY (`response_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=146 AVG_ROW_LENGTH=198 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_review` (
  `review_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_review.',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Relates the review to an ec_product.',
  `approved` TINYINT(1) NOT NULL DEFAULT 0 COMMENT
   'If selected, this review can be shown on the front end.',
  `rating` INTEGER(2) NOT NULL DEFAULT 0 COMMENT
   'The rating given by this review.',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The review title.',
  `description` MEDIUMBLOB NOT NULL COMMENT 'The review description.',
  `date_submitted` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT
   'The date the review was submitted.',
  PRIMARY KEY (`review_id`),
  UNIQUE KEY `review_id` (`review_id`),
  KEY `product_id` (`product_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=82 AVG_ROW_LENGTH=99 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_label` varchar(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `admin_access` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_id` (`role_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=3 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_roleaccess` (
  `roleaccess_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_label` varchar(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `admin_panel` varchar(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`roleaccess_id`),
  UNIQUE KEY `roleaccess_id` (`roleaccess_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=100 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_roleprice` (
  `roleprice_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `role_label` varchar(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `role_price` float(15,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`roleprice_id`),
  UNIQUE KEY `roleprice_id` (`roleprice_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=3 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
;
CREATE TABLE IF NOT EXISTS `ec_setting` (
  `setting_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'This is the primary key for ec_setting.',
  `site_url` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is the site url.',
  `reg_code` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is the registration code entered by the user.',
  `storeversion` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `storetype` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'wordpress',
  `storepage` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'store',
  `cartpage` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'cart',
  `accountpage` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'account',
  `timezone` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'Europe/London',
  `shipping_method` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'method' COMMENT 'price, weight, method, live',
  `shipping_expedite_rate` FLOAT(11,2) NOT NULL DEFAULT 0.00 COMMENT 'This is a static value that can be used or not used by the customer for pricing and weight based methods.',
  `shipping_handling_rate` FLOAT(11,2) NOT NULL DEFAULT 0.00 COMMENT 'This is a global 1 time handling charge added to all shipping methods if present.',
  `ups_access_license_number` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your UPS access license number for UPS based shipping.',
  `ups_user_id` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your UPS user ID for UPS based shipping.',
  `ups_password` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your UPS password for UPS based shipping.',
  `ups_ship_from_zip` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your zip code for UPS based shipping.',
  `ups_shipper_number` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your UPS account shipper number for UPS based shipping.',
  `ups_country_code` VARCHAR(9) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT 'Your country code for UPS based shipping.',
  `ups_weight_type` VARCHAR(19) COLLATE utf8_general_ci NOT NULL DEFAULT 'LBS' COMMENT 'Your preferred weight label for UPS based shipping (lbs, kgs).',
  `ups_conversion_rate` FLOAT(9,3) NOT NULL DEFAULT '1.000'  COMMENT 'Converts the returned pricing.',
  `usps_user_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your USPS user name for USPS shipping.',
  `usps_ship_from_zip` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your zip code for USPS shipping.',
  `fedex_key` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your FedEx account key for FedEx shipping.',
  `fedex_account_number` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your FedEx account number for FedEx shipping.',
  `fedex_meter_number` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your FedEx account meter number for FedEx shipping.',
  `fedex_password` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your FedEx account password for FedEx shipping.',
  `fedex_ship_from_zip` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your FedEx ship from zip for FedEx shipping.',
  `fedex_weight_units` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'LB' COMMENT 'The weight unit for FedEx shipping (LB or KG).',
  `fedex_country_code` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT 'The country code for FedEx shipping.',
  `fedex_conversion_rate` FLOAT(9,3) NOT NULL DEFAULT  '1.000' COMMENT 'Converts the returned pricing.',
  `fedex_test_account` TINYINT(1) NOT NULL DEFAULT  '0' COMMENT 'If true, FedEx account is a test account.',
  `auspost_api_key` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT 'Your Australian Post API Key',
  `auspost_ship_from_zip` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your Australian Post Ship From Postal Code',
  `dhl_site_id` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Site ID.',
  `dhl_password` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Password.',
  `dhl_ship_from_country` VARCHAR(25) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT 'Your DHL Ship From Country.',
  `dhl_ship_from_zip` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Ship From Zip.',
  `dhl_weight_unit` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'LB' COMMENT 'Your DHL Weight Unit.',
  `dhl_test_mode` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Use DHL Test Mode.',
  `fraktjakt_customer_id` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt Customer ID.',
  `fraktjakt_login_key` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt Login Key.',
  `fraktjakt_conversion_rate` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'The conversion rate between your base currency and SEK.',
  `fraktjakt_test_mode` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Use test mode for Fraktjakt.',
  `fraktjakt_address` VARCHAR(120) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.',
  `fraktjakt_city` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.',
  `fraktjakt_state` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.',
  `fraktjakt_zip` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.',
  `fraktjakt_country` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.',
  `ups_ship_from_state` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This sets the ship from state when using UPS.',
  `ups_negotiated_rates` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'This sets the ship from state when using UPS.',
  `canadapost_username` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post API username.',
  `canadapost_password` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post API password.',
  `canadapost_customer_number` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post customer number.',
  `canadapost_contract_id` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post contract id (optional for special rates).',
  `canadapost_test_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'This points to the test or live API URL for Canada Post.',
  `canadapost_ship_from_zip` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is your Canada Post ship from zip.',

  PRIMARY KEY (`setting_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=223 AVG_ROW_LENGTH=268 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_shippingrate` (
  `shippingrate_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_shippingrate.',
  `zone_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'References the ec_zone table for zoned shipping rates.',
  `is_price_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this rate is for price based trigger rate shipping.',
  `is_weight_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this rate is for a weight based trigger rate shipping.',
  `is_method_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this rate is for method based shipping.',
  `is_quantity_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this rate is for quantity based shipping.',
  `is_percentage_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this rate is for percentage based shipping.',
  `is_ups_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for UPS.',
  `is_usps_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for USPS.',
  `is_fedex_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for FedEx.',
  `is_auspost_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for Australian Post is used.',
  `is_dhl_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for DHL.',
  `is_canadapost_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'This sets the rate type to Canada Post.',
  `trigger_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The price or weight that triggers a different shipping rate.',
  `shipping_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The price for shipping at this trigger_rate.',
  `shipping_label` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is the label used for shipping methods requiring a label.',
  `shipping_order` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'This is the order used to display shipping methods.',
  `shipping_code` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is the code used for methods like UPS to determine the cost for this method.',
  `shipping_override_rate` FLOAT(11,3) NULL COMMENT 'This is the override price for live shipping rates.',
  `free_shipping_at` FLOAT(15,3) NOT NULL DEFAULT '-1.000' COMMENT 'This is a subtotal price at which a live or method based rate gives the customer free shipping.',
  
  PRIMARY KEY (`shippingrate_id`),
  UNIQUE KEY `shippingrate_id` (`shippingrate_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=51 AVG_ROW_LENGTH=30 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_state` (
  `id_sta` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_state.',
  `idcnt_sta` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'id_cnt connection, Country id.',
  `code_sta` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'State code.',
  `name_sta` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'State name.',
  `sort_order` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'User defined order for states, used in combo boxes.',
  `group_sta` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option to group states in the state dropdown by a group title',
  PRIMARY KEY (`id_sta`),
  KEY `idcnt_sta` (`idcnt_sta`),
  KEY `code_sta` (`code_sta`)
)ENGINE=MyISAM
AUTO_INCREMENT=84 AVG_ROW_LENGTH=30 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_subscriber` (
  `subscriber_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_subscriber.',
  `email` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Email address for the subscriber.',
  `first_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The first name of the subscriber.',
  `last_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The first name of the subscriber.',
  PRIMARY KEY (`subscriber_id`),
  UNIQUE KEY `subscriber_id` (`subscriber_id`),
  UNIQUE KEY `email` (`email`)
)ENGINE=MyISAM
AUTO_INCREMENT=281 AVG_ROW_LENGTH=40 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_subscription` (
  `subscription_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this table',
  `subscription_type` VARCHAR(125) COLLATE utf8_general_ci NOT NULL DEFAULT 'paypal' COMMENT 'Type of subscription, e.g. paypal',
  `subscription_status` VARCHAR(125) COLLATE utf8_general_ci NOT NULL DEFAULT 'Active' COMMENT 'Status of the subscription, Active or Canceled for example.',
  `title` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Title of the product purchased.',
  `user_id` INT(11) NOT NULL DEFAULT 0 COMMENT 'User ID of the subscription owner.',
  `email` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Email entered by the user while purchasing the subscription',
  `first_name` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'First name of the customer.',
  `last_name` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Last name of the customer.',
  `user_country` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT 'Customer country of residence',
  `product_id` INT(11) NOT NULL DEFAULT 0 COMMENT 'Product ID of the subscription to connect to.',
  `model_number` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Model number of the product purchased.',
  `price` double(21,3) NOT NULL DEFAULT '0.000' COMMENT 'Price of the product per period',
  `payment_length` int(11) NOT NULL DEFAULT '1' COMMENT 'Length of time between payments, e.g. 3 months, represented by 3 in this field.',
  `payment_period` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Period of the payment, day, week, month of year, represented as D, W, M, or Y in this field.',
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date that this payment was submitted to start the subscription.',
  `last_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The last date that this subscription was paid for.',
  `next_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The next payment due date.',
  `number_payments_completed` int(11) NOT NULL DEFAULT '1' COMMENT 'The number of times this subscription has been paid for.',
  `paypal_txn_id` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Initial transaction ID from PayPal',
  `paypal_txn_type` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Initial transaction type from PayPal',
  `paypal_subscr_id` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Initial subscription ID from PayPal used to track the subscription when updated or canceled.',
  `paypal_username` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Username assigned to this subscription by PayPal.',
  `paypal_password` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Password assigned to this subscription by PayPal.',
  `stripe_subscription_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If subscription created with Stripe, Stripe ID here.',

  PRIMARY KEY (`subscription_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_subscription_plan` (
  `subscription_plan_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for a Subscription Plan.',
  `plan_title` VARCHAR(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Title to describe the plan of connecting subscriptions.',
  `can_downgrade` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Can a customer automatically downgrade their subscription plan.',
  
  PRIMARY KEY (`subscription_plan_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=0 CHARACTER SET'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_taxrate` (
  `taxrate_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_taxrate.',
  `tax_by_state` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, tax users in this state_code only.',
  `tax_by_country` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, tax users in country_code only.',
  `tax_by_duty` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, tax users will be exempt from tax if this country_code exists.',
  `tax_by_vat` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, show the VAT calculation to the users on checkout.',
  `tax_by_single_vat` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat tax all users the same if selected.',
  `tax_by_all` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, tax all users.',
  `state_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The rate to tax the user.',
  `country_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'If the country_code matches, rate to tax the user.',
  `duty_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'This rate to tax for duty charges',
  `vat_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'The VAT rate at which the user is calculating VAT additions to the products.',
  `vat_added` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is added to the total at the end, not included in the products.',
  `vat_included` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is included in the price of the product.',
  `all_rate` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'if tax_all_enabled, The rate to tax all users.',
  `state_code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The state code needed to trigger this tax rate.',
  `country_code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The country code needed to trigger this tax rate.',
  `vat_country_code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The country code for VAT taxes.',
  `duty_exempt_country_code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'The country that will be exempt from a customs export duty tax.',
  
  PRIMARY KEY (`taxrate_id`),
  UNIQUE KEY `taxrate_id` (`taxrate_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=65 AVG_ROW_LENGTH=44 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_tempcart` (
  `tempcart_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Temporary Cart Row ID',
  `session_id` VARCHAR(100) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'User Session ID From PHP',
  `product_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates ec_tempcart row to ec_product row',
  `quantity` INTEGER(11) DEFAULT 0 COMMENT 'Amount in the cart',
  `grid_quantity` INTEGER(11) DEFAULT 0 COMMENT 'Amount in the cart for grid option set products only',
  `gift_card_message` BLOB COMMENT 'Message entered by user for the customer receiving this gift card.',
  `gift_card_from_name` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Name of the user sending the gift card, entered by the user.',
  `gift_card_to_name` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Name of the customer receiving the gift card, entered by the user.',
  `optionitem_id_1` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option item ID to the information in the ec_optionitem table.',
  `optionitem_id_2` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option item ID to the information in the ec_optionitem table.',
  `optionitem_id_3` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option item ID to the information in the ec_optionitem table.',
  `optionitem_id_4` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option item ID to the information in the ec_optionitem table.',
  `optionitem_id_5` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the selected option item ID to the information in the ec_optionitem table.',
  `donation_price` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Optional field for a donation product.',
  `last_changed_date` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date the last time this record was accessed.',
  `is_deconetwork` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Sets this item as a DecoNetwork item and changes the display to work with this product type.',
  `deconetwork_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The unique id sent back from the DecoNetwork when adding to cart.',
  `deconetwork_name` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The name of the product from the DecoNetwork.',
  `deconetwork_product_code` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The product code from the DecoNetwork',
  `deconetwork_options` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The options selected by the customer on the DecoNetwork',
  `deconetwork_edit_link` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The edit link provided by the DecoNetwork',
  `deconetwork_color_code` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The color code of the shirt by the DecoNetwork',
  `deconetwork_product_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The product id of this product on the DecoNetwork',
  `deconetwork_image_link` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The image link provided by the DecoNetwork',
  `deconetwork_discount` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'Any discount provided by the DecoNetwork',
  `deconetwork_tax` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'The tax amount by the DecoNetwork',
  `deconetwork_total` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'The total line item cost by the DecoNetwork',
  `deconetwork_version` INTEGER(11) NOT NULL DEFAULT 1 COMMENT 'A value updated each time the customer returns from the Deconetwork for this product, which is used to update the image to the user.',
  `gift_card_email` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'The value of the gift card email if needed.',
  PRIMARY KEY (`tempcart_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1074 AVG_ROW_LENGTH=68 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_tempcart_optionitem` (
  `tempcart_optionitem_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this table.',
  `tempcart_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Relating tempcart_id.',
  `option_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Relating option_id',
  `optionitem_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Relating optionitem_id.',
  `optionitem_value` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Value of the selected option, blob to allow for any value.',
  `session_id` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'The ec_cart_id that determines the user who entered this value.',
  `optionitem_model_number` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'Model number extension that gets added to product model number if selected.',
  PRIMARY KEY (`tempcart_optionitem_id`)
)ENGINE=MyISAM 
AUTO_INCREMENT=133 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_timezone` (
  `timezone_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for ec_timezone.',
  `name` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'The label for an area to choose. Muliple names for one identifier.',
  `identifier` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'The offical time zone name.',
  PRIMARY KEY (`timezone_id`),
  UNIQUE KEY `timezone_id` (`timezone_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=141 AVG_ROW_LENGTH=46 CHARACTER SET 'utf8' COLLATE
 'utf8_unicode_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_user` (
  `user_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for the ec_user table.',
  `email` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Email address for the user, must be unique.',
  `password` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Encrypted password for the user.',
  `list_id` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific List ID.',
  `edit_sequence` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence',
  `first_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'First name of the user.',
  `last_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Last name of the user.',
  `default_billing_address_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the ec_user table to the ec_address table that represents the default billing address for this user.',
  `default_shipping_address_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the ec_user table to the ec_address table. Represents the default shipping address for this user.',
  `user_level` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'shopper' COMMENT 'The user level, common values are shopper and admin.',
  `is_subscriber` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, tells the admin that this user wants to recieve emails and/or newsletters.',
  `realauth_registered` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, customer is using Realex Payments and this customer already has an account in the RealVault.',
  `stripe_customer_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Stripe Customer ID if subscription created with Stripe.',
  `default_card_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Used for subscription display of where billed to.',
  `default_card_last4` VARCHAR(8) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Used for subscription display of where billed to.',
  `exclude_tax` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give customer tax free purchases.',
  `exclude_shipping` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give free shipping to this customer.',
  `user_notes` text COLLATE utf8_general_ci COMMENT 'This is available for an admin to keep notes on a user.',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email_2` (`email`),
  KEY `Email` (`email`),
  KEY `Password` (`password`)
)ENGINE=MyISAM
AUTO_INCREMENT=44 AVG_ROW_LENGTH=98 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci' DEFAULT CHARSET=utf8
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_webhook` (
  `webhook_id` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The unique indentifier for the webhook table, used by Stripe.',
  `webhook_type` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'The type of webhook called.',
  `webhook_data` BLOB COMMENT 'The data returned from stripe in this webhook call.',
  PRIMARY KEY (`webhook_id`),
  UNIQUE KEY `webhook_id` (`webhook_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8 PACK_KEYS=0
;
CREATE TABLE IF NOT EXISTS `ec_zone` (
  `zone_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for the ec_zone table',
  `zone_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'An identifying name for this zone.',
  PRIMARY KEY (`zone_id`)
)ENGINE=MyISAM 
AUTO_INCREMENT=10 CHARACTER SET 'utf8' COLLATE
'utf8_general_ci' DEFAULT CHARSET=utf8
;
CREATE TABLE IF NOT EXISTS `ec_zone_to_location` (
  `zone_to_location_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'The unique identifier for the ec_zone_to_location',
  `zone_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Connects the location to the ec_zone table.',
  `iso2_cnt` CHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Connects this table to the ec_country table.',
  `code_sta` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Connects this table to the ec_state table.',
  PRIMARY KEY (`zone_to_location_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=257 CHARACTER SET 'utf8' COLLATE
'utf8_general_ci' DEFAULT CHARSET=utf8
;
INSERT INTO `ec_setting` (`setting_id`, `site_url`, `reg_code`, `storeversion`, `storetype`, `storepage`, `cartpage`, `accountpage`, `timezone`, `shipping_method`, `shipping_expedite_rate`, `shipping_handling_rate`, 
  `ups_access_license_number`, `ups_user_id`, `ups_password`, `ups_ship_from_zip`, `ups_shipper_number`, `ups_country_code`, `ups_weight_type`, `ups_conversion_rate`, 
  `usps_user_name`, `usps_ship_from_zip`, 
  `fedex_key`, `fedex_account_number`, `fedex_meter_number`, `fedex_password`, `fedex_ship_from_zip`, `fedex_weight_units`, `fedex_country_code`, `fedex_conversion_rate`, `fedex_test_account`,
  `auspost_api_key`, `auspost_ship_from_zip`, 
  `dhl_site_id`, `dhl_password`, `dhl_ship_from_country`, `dhl_ship_from_zip`, `dhl_weight_unit`, `dhl_test_mode`,
  `fraktjakt_customer_id`, `fraktjakt_login_key`, `fraktjakt_conversion_rate`, `fraktjakt_test_mode`)
        VALUES(1, '', '', '1.0.0', 'wordpress', '6', '7', '8', 'America/Los_Angeles', 'price', 2, 0, 
  '', '', '', '', '', '', '', '1.000',
  '', '', 
  '', '', '', '', '', 'LB', 'US', '1.000', 0,
  '', '',
  '', '', '', '', '', 0,
  '', '', '1.000', 0 )
;
INSERT INTO `ec_shippingrate` (`shippingrate_id`, `is_price_based`, `is_weight_based`, `is_method_based`, `is_ups_based`, `is_usps_based`, `is_fedex_based`, `trigger_rate`, `shipping_rate`, `shipping_label`, `shipping_order`, `shipping_code`, `shipping_override_rate`) VALUES
  (51,1,0,0,0,0,0,0,5,'',0,'',0)
;
INSERT INTO `ec_user` (`user_id`, `email`, `password`, `first_name`, `last_name`, `default_billing_address_id`, `default_shipping_address_id`, `user_level`, `is_subscriber`) VALUES 
  (2, 'demouser@demo.com', '91017d590a69dc49807671a51f10ab7f', 'Demo', 'User', 1, 2, 'admin', 1)
;
INSERT INTO `ec_country` (`id_cnt`, `name_cnt`, `iso2_cnt`, `iso3_cnt`,
 `sort_order`) VALUES
  (1,'Afghanistan','AF','AFG',10),
  (2,'Albania','AL','ALB',11),
  (3,'Algeria','DZ','DZA',12),
  (4,'American Samoa','AS','ASM',13),
  (5,'Andorra','AD','AND',14),
  (6,'Angola','AO','AGO',15),
  (7,'Anguilla','AI','AIA',16),
  (8,'Antarctica','AQ','ATA',17),
  (9,'Antigua and Barbuda','AG','ATG',18),
  (10,'Argentina','AR','ARG',19),
  (11,'Armenia','AM','ARM',20),
  (12,'Aruba','AW','ABW',21),
  (13,'Australia','AU','AUS',3),
  (14,'Austria','AT','AUT',23),
  (15,'Azerbaijan','AZ','AZE',24),
  (16,'Bahamas','BS','BHS',25),
  (17,'Bahrain','BH','BHR',26),
  (18,'Bangladesh','BD','BGD',27),
  (19,'Barbados','BB','BRB',28),
  (20,'Belarus','BY','BLR',29),
  (21,'Belgium','BE','BEL',30),
  (22,'Belize','BZ','BLZ',31),
  (23,'Benin','BJ','BEN',32),
  (24,'Bermuda','BM','BMU',33),
  (25,'Bhutan','BT','BTN',34),
  (26,'Bolivia','BO','BOL',35),
  (28,'Botswana','BW','BWA',36),
  (29,'Bouvet Island','BV','BVT',37),
  (30,'Brazil','BR','BRA',38),
  (32,'Brunei Darussalam','BN','BRN',39),
  (33,'Bulgaria','BG','BGR',40),
  (34,'Burkina Faso','BF','BFA',41),
  (35,'Burundi','BI','BDI',42),
  (36,'Cambodia','KH','KHM',43),
  (37,'Cameroon','CM','CMR',44),
  (38,'Canada','CA','CAN',2),
  (39,'Cape Verde','CV','CPV',46),
  (40,'Cayman Islands','KY','CYM',47),
  (42,'Chad','TD','TCD',48),
  (43,'Chile','CL','CHL',49),
  (44,'China','CN','CHN',50),
  (45,'Christmas Island','CX','CXR',51),
  (47,'Colombia','CO','COL',52),
  (48,'Comoros','KM','COM',53),
  (49,'Congo','CG','COG',54),
  (50,'Cook Islands','CK','COK',55),
  (51,'Costa Rica','CR','CRI',56),
  (52,'Cote D''Ivoire','CI','CIV',57),
  (53,'Croatia','HR','HRV',58),
  (54,'Cuba','CU','CUB',59),
  (55,'Cyprus','CY','CYP',60),
  (56,'Czech Republic','CZ','CZE',61),
  (57,'Denmark','DK','DNK',62),
  (58,'Djibouti','DJ','DJI',63),
  (59,'Dominica','DM','DMA',64),
  (60,'Dominican Republic','DO','DOM',65),
  (61,'East Timor','TP','TMP',66),
  (62,'Ecuador','EC','ECU',67),
  (63,'Egypt','EG','EGY',68),
  (64,'El Salvador','SV','SLV',69),
  (65,'Equatorial Guinea','GQ','GNQ',70),
  (66,'Eritrea','ER','ERI',71),
  (67,'Estonia','EE','EST',72),
  (68,'Ethiopia','ET','ETH',73),
  (70,'Faroe Islands','FO','FRO',74),
  (71,'Fiji','FJ','FJI',75),
  (72,'Finland','FI','FIN',76),
  (73,'France','FR','FRA',77),
  (74,'France, Metropolitan','FX','FXX',78),
  (75,'French Guiana','GF','GUF',79),
  (76,'French Polynesia','PF','PYF',80),
  (78,'Gabon','GA','GAB',81),
  (79,'Gambia','GM','GMB',82),
  (80,'Georgia','GE','GEO',83),
  (81,'Germany','DE','DEU',84),
  (82,'Ghana','GH','GHA',85),
  (83,'Gibraltar','GI','GIB',86),
  (84,'Greece','GR','GRC',87),
  (85,'Greenland','GL','GRL',88),
  (86,'Grenada','GD','GRD',89),
  (87,'Guadeloupe','GP','GLP',90),
  (88,'Guam','GU','GUM',91),
  (89,'Guatemala','GT','GTM',92),
  (90,'Guinea','GN','GIN',93),
  (91,'Guinea-bissau','GW','GNB',94),
  (92,'Guyana','GY','GUY',95),
  (93,'Haiti','HT','HTI',96),
  (95,'Honduras','HN','HND',97),
  (96,'Hong Kong','HK','HKG',98),
  (97,'Hungary','HU','HUN',99),
  (98,'Iceland','IS','ISL',100),
  (99,'India','IN','IND',101),
  (100,'Indonesia','ID','IDN',102),
  (102,'Iraq','IQ','IRQ',103),
  (103,'Ireland','IE','IRL',104),
  (104,'Israel','IL','ISR',105),
  (105,'Italy','IT','ITA',106),
  (106,'Jamaica','JM','JAM',107),
  (107,'Japan','JP','JPN',108),
  (108,'Jordan','JO','JOR',109),
  (109,'Kazakhstan','KZ','KAZ',110),
  (110,'Kenya','KE','KEN',111),
  (111,'Kiribati','KI','KIR',112),
  (113,'Korea, Republic of','KR','KOR',113),
  (114,'Kuwait','KW','KWT',114),
  (115,'Kyrgyzstan','KG','KGZ',115),
  (117,'Latvia','LV','LVA',116),
  (118,'Lebanon','LB','LBN',117),
  (119,'Lesotho','LS','LSO',118),
  (120,'Liberia','LR','LBR',119),
  (122,'Liechtenstein','LI','LIE',120),
  (123,'Lithuania','LT','LTU',121),
  (124,'Luxembourg','LU','LUX',122),
  (125,'Macau','MO','MAC',123),
  (127,'Madagascar','MG','MDG',124),
  (128,'Malawi','MW','MWI',125),
  (129,'Malaysia','MY','MYS',126),
  (130,'Maldives','MV','MDV',127),
  (131,'Mali','ML','MLI',128),
  (132,'Malta','MT','MLT',129),
  (133,'Marshall Islands','MH','MHL',130),
  (134,'Martinique','MQ','MTQ',131),
  (135,'Mauritania','MR','MRT',132),
  (136,'Mauritius','MU','MUS',133),
  (137,'Mayotte','YT','MYT',134),
  (138,'Mexico','MX','MEX',135),
  (141,'Monaco','MC','MCO',136),
  (142,'Mongolia','MN','MNG',137),
  (143,'Montserrat','MS','MSR',138),
  (144,'Morocco','MA','MAR',139),
  (145,'Mozambique','MZ','MOZ',140),
  (146,'Myanmar','MM','MMR',141),
  (147,'Namibia','NA','NAM',142),
  (148,'Nauru','NR','NRU',143),
  (149,'Nepal','NP','NPL',144),
  (150,'Netherlands','NL','NLD',145),
  (151,'Netherlands Antilles','AN','ANT',146),
  (152,'New Caledonia','NC','NCL',147),
  (153,'New Zealand','NZ','NZL',148),
  (154,'Nicaragua','NI','NIC',149),
  (155,'Niger','NE','NER',150),
  (156,'Nigeria','NG','NGA',151),
  (157,'Niue','NU','NIU',152),
  (158,'Norfolk Island','NF','NFK',153),
  (160,'Norway','NO','NOR',154),
  (161,'Oman','OM','OMN',155),
  (162,'Pakistan','PK','PAK',156),
  (163,'Palau','PW','PLW',157),
  (164,'Panama','PA','PAN',158),
  (165,'Papua New Guinea','PG','PNG',159),
  (166,'Paraguay','PY','PRY',160),
  (167,'Peru','PE','PER',161),
  (168,'Philippines','PH','PHL',162),
  (169,'Pitcairn','PN','PCN',163),
  (170,'Poland','PL','POL',164),
  (171,'Portugal','PT','PRT',165),
  (172,'Puerto Rico','PR','PRI',166),
  (173,'Qatar','QA','QAT',167),
  (174,'Reunion','RE','REU',168),
  (175,'Romania','RO','ROM',169),
  (176,'Russian Federation','RU','RUS',170),
  (177,'Rwanda','RW','RWA',171),
  (178,'Saint Kitts and Nevis','KN','KNA',172),
  (179,'Saint Lucia','LC','LCA',173),
  (181,'Samoa','WS','WSM',174),
  (182,'San Marino','SM','SMR',175),
  (183,'Sao Tome and Principe','ST','STP',176),
  (184,'Saudi Arabia','SA','SAU',177),
  (185,'Senegal','SN','SEN',178),
  (186,'Seychelles','SC','SYC',179),
  (187,'Sierra Leone','SL','SLE',180),
  (188,'Singapore','SG','SGP',181),
  (190,'Slovenia','SI','SVN',182),
  (191,'Solomon Islands','SB','SLB',183),
  (192,'Somalia','SO','SOM',184),
  (193,'South Africa','ZA','ZAF',185),
  (195,'Spain','ES','ESP',186),
  (196,'Sri Lanka','LK','LKA',187),
  (197,'St. Helena','SH','SHN',188),
  (198,'St. Pierre and Miquelon','PM','SPM',189),
  (199,'Sudan','SD','SDN',190),
  (200,'Suriname','SR','SUR',191),
  (202,'Swaziland','SZ','SWZ',192),
  (203,'Sweden','SE','SWE',193),
  (204,'Switzerland','CH','CHE',194),
  (205,'Syrian Arab Republic','SY','SYR',195),
  (206,'Taiwan','TW','TWN',196),
  (207,'Tajikistan','TJ','TJK',197),
  (209,'Thailand','TH','THA',198),
  (210,'Togo','TG','TGO',199),
  (211,'Tokelau','TK','TKL',200),
  (212,'Tonga','TO','TON',201),
  (213,'Trinidad and Tobago','TT','TTO',202),
  (214,'Tunisia','TN','TUN',203),
  (215,'Turkey','TR','TUR',204),
  (216,'Turkmenistan','TM','TKM',205),
  (217,'Turks and Caicos Islands','TC','TCA',206),
  (218,'Tuvalu','TV','TUV',207),
  (219,'Uganda','UG','UGA',208),
  (220,'Ukraine','UA','UKR',209),
  (221,'United Arab Emirates','AE','ARE',210),
  (222,'United Kingdom','GB','GBR',211),
  (223,'United States','US','USA',1),
  (224,'US Minor Outlying Islands','UM','UMI',213),
  (225,'Uruguay','UY','URY',214),
  (226,'Uzbekistan','UZ','UZB',215),
  (227,'Vanuatu','VU','VUT',216),
  (229,'Venezuela','VE','VEN',217),
  (230,'Viet Nam','VN','VNM',218),
  (231,'Virgin Islands (British)','VG','VGB',219),
  (232,'Virgin Islands (U.S.)','VI','VIR',220),
  (233,'Wallis and Futuna Islands','WF','WLF',221),
  (234,'Western Sahara','EH','ESH',222),
  (235,'Yemen','YE','YEM',223),
  (236,'Yugoslavia','YU','YUG',224),
  (237,'Zaire','ZR','ZAR',225),
  (238,'Zambia','ZM','ZMB',226),
  (239,'Zimbabwe','ZW','ZWE',227)
;
INSERT INTO `ec_orderstatus` (`status_id`, `order_status`, `is_approved`)
 VALUES
  (1,'Status Not Found',0),
  (2,'Order Shipped',1),
  (3,'Order Confirmed',1),
  (4,'Order on Hold',0),
  (5,'Order Started',0),
  (6,'Card Approved',1),
  (7,'Card Denied',0),
  (8,'Third Party Pending',0),
  (9,'Third Party Error',0),
  (10,'Third Party Approved',1),
  (11,'Ready for Pickup',1),
  (12,'Pending Approval',0),
  (14,'Direct Deposit Pending',0),
  (15,'Direct Deposit Received',1),
  (16,'Refunded Order',0),
  (17,'Partial Refund',1)
;
INSERT INTO `ec_timezone` (`timezone_id`, `name`, `identifier`)
 VALUES
  (1,'(GMT-12:00) International Date Line West','Pacific/Wake'),
  (2,'(GMT-11:00) Midway Island','Pacific/Apia'),
  (3,'(GMT-11:00) Samoa','Pacific/Apia'),
  (4,'(GMT-10:00) Hawaii','Pacific/Honolulu'),
  (5,'(GMT-09:00) Alaska','America/Anchorage'),
  (6,'(GMT-08:00) Pacific Time (US & Canada) Tijuana','America/Los_Angeles'),
  (7,'(GMT-07:00) Arizona','America/Phoenix'),
  (8,'(GMT-07:00) Chihuahua','America/Chihuahua'),
  (9,'(GMT-07:00) La Paz','America/Chihuahua'),
  (10,'(GMT-07:00) Mazatlan','America/Chihuahua'),
  (11,'(GMT-07:00) Mountain Time (US & Canada)','America/Denver'),
  (12,'(GMT-06:00) Central America','America/Managua'),
  (13,'(GMT-06:00) Central Time (US & Canada)','America/Chicago'),
  (14,'(GMT-06:00) Guadalajara','America/Mexico_City'),
  (15,'(GMT-06:00) Mexico City','America/Mexico_City'),
  (16,'(GMT-06:00) Monterrey','America/Mexico_City'),
  (17,'(GMT-06:00) Saskatchewan','America/Regina'),
  (18,'(GMT-05:00) Bogota','America/Bogota'),
  (19,'(GMT-05:00) Eastern Time (US & Canada)','America/New_York'),
  (20,'(GMT-05:00) Indiana (East)','America/Indiana/Indianapolis'),
  (21,'(GMT-05:00) Lima','America/Bogota'),
  (22,'(GMT-05:00) Quito','America/Bogota'),
  (23,'(GMT-04:00) Atlantic Time (Canada)','America/Halifax'),
  (24,'(GMT-04:00) Caracas','America/Caracas'),
  (25,'(GMT-04:00) La Paz','America/Caracas'),
  (26,'(GMT-04:00) Santiago','America/Santiago'),
  (27,'(GMT-03:30) Newfoundland','America/St_Johns'),
  (28,'(GMT-03:00) Brasilia','America/Sao_Paulo'),
  (29,'(GMT-03:00) Buenos Aires','America/Argentina/Buenos_Aires'),
  (30,'(GMT-03:00) Georgetown','America/Argentina/Buenos_Aires'),
  (31,'(GMT-03:00) Greenland','America/Godthab'),
  (32,'(GMT-02:00) Mid-Atlantic','America/Noronha'),
  (33,'(GMT-01:00) Azores','Atlantic/Azores'),
  (34,'(GMT-01:00) Cape Verde Is.','Atlantic/Cape_Verde'),
  (35,'(GMT) Casablanca','Africa/Casablanca'),
  (36,'(GMT) Edinburgh','Europe/London'),
  (37,'(GMT) Greenwich Mean Time : Dublin','Europe/London'),
  (38,'(GMT) Lisbon','Europe/London'),
  (39,'(GMT) London','Europe/London'),
  (40,'(GMT) Monrovia','Africa/Casablanca'),
  (41,'(GMT+01:00) Amsterdam','Europe/Berlin'),
  (42,'(GMT+01:00) Belgrade','Europe/Belgrade'),
  (43,'(GMT+01:00) Berlin','Europe/Berlin'),
  (44,'(GMT+01:00) Bern','Europe/Berlin'),
  (45,'(GMT+01:00) Bratislava','Europe/Belgrade'),
  (46,'(GMT+01:00) Brussels','Europe/Paris'),
  (47,'(GMT+01:00) Budapest','Europe/Belgrade'),
  (48,'(GMT+01:00) Copenhagen','Europe/Paris'),
  (49,'(GMT+01:00) Ljubljana','Europe/Belgrade'),
  (50,'(GMT+01:00) Madrid','Europe/Paris'),
  (51,'(GMT+01:00) Paris','Europe/Paris'),
  (52,'(GMT+01:00) Prague','Europe/Belgrade'),
  (53,'(GMT+01:00) Rome','Europe/Berlin'),
  (54,'(GMT+01:00) Sarajevo','Europe/Sarajevo'),
  (55,'(GMT+01:00) Skopje','Europe/Sarajevo'),
  (56,'(GMT+01:00) Stockholm','Europe/Berlin'),
  (57,'(GMT+01:00) Vienna','Europe/Berlin'),
  (58,'(GMT+01:00) Warsaw','Europe/Sarajevo'),
  (59,'(GMT+01:00) West Central Africa','Africa/Lagos'),
  (60,'(GMT+01:00) Zagreb','Europe/Sarajevo'),
  (61,'(GMT+02:00) Athens','Europe/Istanbul'),
  (62,'(GMT+02:00) Bucharest','Europe/Bucharest'),
  (63,'(GMT+02:00) Cairo','Africa/Cairo'),
  (64,'(GMT+02:00) Harare','Africa/Johannesburg'),
  (65,'(GMT+02:00) Helsinki','Europe/Helsinki'),
  (66,'(GMT+02:00) Istanbul','Europe/Istanbul'),
  (67,'(GMT+02:00) Jerusalem','Asia/Jerusalem'),
  (68,'(GMT+02:00) Kyiv','Europe/Helsinki'),
  (69,'(GMT+02:00) Minsk','Europe/Istanbul'),
  (70,'(GMT+02:00) Pretoria','Africa/Johannesburg'),
  (71,'(GMT+02:00) Riga','Europe/Helsinki'),
  (72,'(GMT+02:00) Sofia','Europe/Helsinki'),
  (73,'(GMT+02:00) Tallinn','Europe/Helsinki'),
  (74,'(GMT+02:00) Vilnius','Europe/Helsinki'),
  (75,'(GMT+03:00) Baghdad','Asia/Baghdad'),
  (76,'(GMT+03:00) Kuwait','Asia/Riyadh'),
  (77,'(GMT+03:00) Moscow','Europe/Moscow'),
  (78,'(GMT+03:00) Nairobi','Africa/Nairobi'),
  (79,'(GMT+03:00) Riyadh','Asia/Riyadh'),
  (80,'(GMT+03:00) St. Petersburg','Europe/Moscow'),
  (81,'(GMT+03:00) Volgograd','Europe/Moscow'),
  (82,'(GMT+03:30) Tehran','Asia/Tehran'),
  (83,'(GMT+04:00) Abu Dhabi','Asia/Muscat'),
  (84,'(GMT+04:00) Baku','Asia/Tbilisi'),
  (85,'(GMT+04:00) Muscat','Asia/Muscat'),
  (86,'(GMT+04:00) Tbilisi','Asia/Tbilisi'),
  (87,'(GMT+04:00) Yerevan','Asia/Tbilisi'),
  (88,'(GMT+04:30) Kabul','Asia/Kabul'),
  (89,'(GMT+05:00) Ekaterinburg','Asia/Yekaterinburg'),
  (90,'(GMT+05:00) Islamabad','Asia/Karachi'),
  (91,'(GMT+05:00) Karachi','Asia/Karachi'),
  (92,'(GMT+05:00) Tashkent','Asia/Karachi'),
  (93,'(GMT+05:30) Chennai','Asia/Calcutta'),
  (94,'(GMT+05:30) Kolkata','Asia/Calcutta'),
  (95,'(GMT+05:30) Mumbai','Asia/Calcutta'),
  (96,'(GMT+05:30) New Delhi','Asia/Calcutta'),
  (97,'(GMT+05:45) Kathmandu','Asia/Katmandu'),
  (98,'(GMT+06:00) Almaty','Asia/Novosibirsk'),
  (99,'(GMT+06:00) Astana','Asia/Dhaka'),
  (100,'(GMT+06:00) Dhaka','Asia/Dhaka'),
  (101,'(GMT+06:00) Novosibirsk','Asia/Novosibirsk'),
  (102,'(GMT+06:00) Sri Jayawardenepura','Asia/Colombo'),
  (103,'(GMT+06:30) Rangoon','Asia/Rangoon'),
  (104,'(GMT+07:00) Bangkok','Asia/Bangkok'),
  (105,'(GMT+07:00) Hanoi','Asia/Bangkok'),
  (106,'(GMT+07:00) Jakarta','Asia/Bangkok'),
  (107,'(GMT+07:00) Krasnoyarsk','Asia/Krasnoyarsk'),
  (108,'(GMT+08:00) Beijing','Asia/Hong_Kong'),
  (109,'(GMT+08:00) Chongqing','Asia/Hong_Kong'),
  (110,'(GMT+08:00) Hong Kong','Asia/Hong_Kong'),
  (111,'(GMT+08:00) Irkutsk','Asia/Irkutsk'),
  (112,'(GMT+08:00) Kuala Lumpur','Asia/Singapore'),
  (113,'(GMT+08:00) Perth','Australia/Perth'),
  (114,'(GMT+08:00) Singapore','Asia/Singapore'),
  (115,'(GMT+08:00) Taipei','Asia/Taipei'),
  (116,'(GMT+08:00) Ulaan Bataar','Asia/Irkutsk'),
  (117,'(GMT+08:00) Urumqi','Asia/Hong_Kong'),
  (118,'(GMT+09:00) Osaka','Asia/Tokyo'),
  (119,'(GMT+09:00) Sapporo','Asia/Tokyo'),
  (120,'(GMT+09:00) Seoul','Asia/Seoul'),
  (121,'(GMT+09:00) Tokyo','Asia/Tokyo'),
  (122,'(GMT+09:00) Yakutsk','Asia/Yakutsk'),
  (123,'(GMT+09:30) Adelaide','Australia/Adelaide'),
  (124,'(GMT+09:30) Darwin','Australia/Darwin'),
  (125,'(GMT+10:00) Brisbane','Australia/Brisbane'),
  (126,'(GMT+10:00) Canberra','Australia/Sydney'),
  (127,'(GMT+10:00) Guam','Pacific/Guam'),
  (128,'(GMT+10:00) Hobart','Australia/Hobart'),
  (129,'(GMT+10:00) Melbourne','Australia/Sydney'),
  (130,'(GMT+10:00) Port Moresby','Pacific/Guam'),
  (131,'(GMT+10:00) Sydney','Australia/Sydney'),
  (132,'(GMT+10:00) Vladivostok','Asia/Vladivostok'),
  (133,'(GMT+11:00) Magadan','Asia/Magadan'),
  (134,'(GMT+11:00) New Caledonia','Asia/Magadan'),
  (135,'(GMT+11:00) Solomon Is.','Asia/Magadan'),
  (136,'(GMT+12:00) Auckland','Pacific/Auckland'),
  (137,'(GMT+12:00) Fiji','Pacific/Fiji'),
  (138,'(GMT+12:00) Kamchatka','Pacific/Fiji'),
  (139,'(GMT+12:00) Marshall Is.','Pacific/Fiji'),
  (140,'(GMT+12:00) Wellington','Pacific/Auckland')
;
INSERT INTO `ec_perpage` (`perpage_id`, `perpage`) VALUES
  (1,50),
  (2,25),
  (3,10)
;
INSERT INTO `ec_pricepoint` (`pricepoint_id`, `is_less_than`, `is_greater_than`
, `low_point`, `high_point`, `order`) VALUES
  (1,1,0,0,10,0),
  (2,0,0,25,49.99,4),
  (3,0,0,50,99.99,5),
  (4,0,0,100,299.99,6),
  (5,0,2,299.99,0,7),
  (6,0,0,10,14.99,1),
  (7,0,0,15,19.99,2),
  (8,0,0,20,24.99,3)
;
INSERT INTO `ec_role` (`role_id`, `role_label`, `admin_access`) VALUES
  (1, 'admin', 1),
  (2, 'shopper', 0)
;
INSERT INTO `ec_state` (`id_sta`, `idcnt_sta`, `code_sta`, `name_sta`,`sort_order`, `group_sta`) VALUES
  (1,223,'AL','Alabama',9, ''),
  (2,223,'AK','Alaska',10, ''),
  (4,223,'AZ','Arizona',11, ''),
  (5,223,'AR','Arkansas',12, ''),
  (12,223,'CA','California',13, ''),
  (13,223,'CO','Colorado',14, ''),
  (14,223,'CT','Connecticut',15, ''),
  (15,223,'DE','Delaware',16, ''),
  (16,223,'DC','District of Columbia',17, ''),
  (18,223,'FL','Florida',18, ''),
  (19,223,'GA','Georgia',19, ''),
  (21,223,'HI','Hawaii',21, ''),
  (22,223,'ID','Idaho',22, ''),
  (23,223,'IL','Illinois',23, ''),
  (24,223,'IN','Indiana',24, ''),
  (25,223,'IA','Iowa',25, ''),
  (26,223,'KS','Kansas',26, ''),
  (27,223,'KY','Kentucky',27, ''),
  (28,223,'LA','Louisiana',28, ''),
  (29,223,'ME','Maine',29, ''),
  (31,223,'MD','Maryland',30, ''),
  (32,223,'MA','Massachusetts',31, ''),
  (33,223,'MI','Michigan',32, ''),
  (34,223,'MN','Minnesota',33, ''),
  (35,223,'MS','Mississippi',34, ''),
  (36,223,'MO','Missouri',35, ''),
  (37,223,'MT','Montana',36, ''),
  (38,223,'NE','Nebraska',37, ''),
  (39,223,'NV','Nevada',38, ''),
  (40,223,'NH','New Hampshire',39, ''),
  (41,223,'NJ','New Jersey',40, ''),
  (42,223,'NM','New Mexico',41, ''),
  (43,223,'NY','New York',42, ''),
  (44,223,'NC','North Carolina',43, ''),
  (45,223,'ND','North Dakota',44, ''),
  (47,223,'OH','Ohio',45, ''),
  (48,223,'OK','Oklahoma',46, ''),
  (49,223,'OR','Oregon',47, ''),
  (51,223,'PA','Pennsylvania',48, ''),
  (52,223,'PR','Puerto Rico',49, ''),
  (53,223,'RI','Rhode Island',50, ''),
  (54,223,'SC','South Carolina',51, ''),
  (55,223,'SD','South Dakota',52, ''),
  (56,223,'TN','Tennessee',53, ''),
  (57,223,'TX','Texas',54, ''),
  (58,223,'UT','Utah',55, ''),
  (59,223,'VT','Vermont',56, ''),
  (60,223,'VI','Virgin Islands',57, ''),
  (61,223,'VA','Virginia',58, ''),
  (62,223,'WA','Washington',59, ''),
  (63,223,'WV','West Virginia',60, ''),
  (64,223,'WI','Wisconsin',61, ''),
  (65,223,'WY','Wyoming',62, ''),
  (66,38,'AB','Alberta',100, ''),
  (67,38,'BC','British Columbia',101, ''),
  (68,38,'MB','Manitoba',102, ''),
  (69,38,'NF','Newfoundland',103, ''),
  (70,38,'NB','New Brunswick',104, ''),
  (71,38,'NS','Nova Scotia',105, ''),
  (72,38,'NT','Northwest Territories',106, ''),
  (73,38,'NU','Nunavut',107, ''),
  (74,38,'ON','Ontario',108, ''),
  (75,38,'PE','Prince Edward Island',109, ''),
  (76,38,'QC','Quebec',110, ''),
  (77,38,'SK','Saskatchewan',111, ''),
  (78,38,'YT','Yukon Territory',112, ''),
  (79, 13, 'ACT', 'Australian Capital Territory', 113, ''),
  (80, 13, 'CX', 'Christmas Island', 114, ''),
  (81, 13, 'CC', 'Cocos Islands', 115, ''),
  (82, 13, 'HM', 'Heard Island and McDonald Islands', 116, ''),
  (83, 13, 'NSW', 'New South Wales', 117, ''),
  (84, 13, 'NF', 'Norfolk Island', 118, ''),
  (85, 13, 'NT', 'Northern Territory', 119, ''),
  (86, 13, 'QLD', 'Queensland', 120, ''),
  (87, 13, 'SA', 'South Australia', 121, ''),
  (88, 13, 'TAS', 'Tasmania', 122, ''),
  (89, 13, 'VIC', 'Victoria', 123, ''),
  (90, 13, 'WA', 'Western Australia', 124, ''),
  (91, 222, 'Avon', 'Avon', 125, 'England'),
  (92, 222, 'Bedfordshire', 'Bedfordshire', 126, 'England'),
  (93, 222, 'Berkshire', 'Berkshire', 127, 'England'),
  (94, 222, 'Buckinghamshire', 'Buckinghamshire', 128, 'England'),
  (95, 222, 'Cambridgeshire', 'Cambridgeshire', 129, 'England'),
  (96, 222, 'Cheshire', 'Cheshire', 130, 'England'),
  (97, 222, 'Cleveland', 'Cleveland', 131, 'England'),
  (98, 222, 'Cornwall', 'Cornwall', 132, 'England'),
  (99, 222, 'Cumbria', 'Cumbria', 133, 'England'),
  (100, 222, 'Derbyshire', 'Derbyshire', 134, 'England'),
  (101, 222, 'Devon', 'Devon', 135, 'England'),
  (102, 222, 'Dorset', 'Dorset', 136, 'England'),
  (103, 222, 'Durham', 'Durham', 137, 'England'),
  (104, 222, 'East Sussex', 'East Sussex', 138, 'England'),
  (105, 222, 'Essex', 'Essex', 139, 'England'),
  (106, 222, 'Gloucestershire', 'Gloucestershire', 140, 'England'),
  (107, 222, 'Hampshire', 'Hampshire', 141, 'England'),
  (108, 222, 'Herefordshire', 'Herefordshire', 142, 'England'),
  (109, 222, 'Hertfordshire', 'Hertfordshire', 143, 'England'),
  (110, 222, 'Isle of Wight', 'Isle of Wight', 144, 'England'),
  (111, 222, 'Kent', 'Kent', 145, 'England'),
  (112, 222, 'Lancashire', 'Lancashire', 146, 'England'),
  (113, 222, 'Leicestershire', 'Leicestershire', 147, 'England'),
  (114, 222, 'Lincolnshire', 'Lincolnshire', 148, 'England'),
  (115, 222, 'London', 'London', 149, 'England'),
  (116, 222, 'Merseyside', 'Merseyside', 150, 'England'),
  (117, 222, 'Middlesex', 'Middlesex', 151, 'England'),
  (118, 222, 'Norfolk', 'Norfolk', 152, 'England'),
  (119, 222, 'Northamptonshire', 'Northamptonshire', 153, 'England'),
  (120, 222, 'Northumberland', 'Northumberland', 154, 'England'),
  (121, 222, 'North Humberside', 'North Humberside', 155, 'England'),
  (122, 222, 'North Yorkshire', 'North Yorkshire', 156, 'England'),
  (123, 222, 'Nottinghamshire', 'Nottinghamshire', 157, 'England'),
  (124, 222, 'Oxfordshire', 'Oxfordshire', 158, 'England'),
  (125, 222, 'Rutland', 'Rutland', 159, 'England'),
  (126, 222, 'Shropshire', 'Shropshire', 160, 'England'),
  (127, 222, 'Somerset', 'Somerset', 161, 'England'),
  (128, 222, 'South Humberside', 'South Humberside', 162, 'England'),
  (129, 222, 'South Yorkshire', 'South Yorkshire', 163, 'England'),
  (130, 222, 'Staffordshire', 'Staffordshire', 164, 'England'),
  (131, 222, 'Suffolk', 'Suffolk', 165, 'England'),
  (132, 222, 'Surrey', 'Surrey', 166, 'England'),
  (133, 222, 'Tyne and Wear', 'Tyne and Wear', 167, 'England'),
  (134, 222, 'Warwickshire', 'Warwickshire', 168, 'England'),
  (135, 222, 'West Midlands', 'West Midlands', 169, 'England'),
  (136, 222, 'West Sussex', 'West Sussex', 170, 'England'),
  (137, 222, 'West Yorkshire', 'West Yorkshire', 171, 'England'),
  (138, 222, 'Wiltshire', 'Wiltshire', 172, 'England'),
  (139, 222, 'Worcestershire', 'Worcestershire', 173, 'England'),
  (140, 222, 'Clwyd', 'Clwyd', 174, 'Wales'),
  (141, 222, 'Dyfed', 'Dyfed', 175, 'Wales'),
  (142, 222, 'Gwent', 'Gwent', 176, 'Wales'),
  (143, 222, 'Gwynedd', 'Gwynedd', 177, 'Wales'),
  (144, 222, 'Mid Glamorgan', 'Mid Glamorgan', 178, 'Wales'),
  (145, 222, 'Powys', 'Powys', 179, 'Wales'),
  (146, 222, 'South Glamorgan', 'South Glamorgan', 180, 'Wales'),
  (147, 222, 'West Glamorgan', 'West Glamorgan', 181, 'Wales'),
  (148, 222, 'Aberdeenshire', 'Aberdeenshire', 182, 'Scotland'),
  (149, 222, 'Angus', 'Angus', 183, 'Scotland'),
  (150, 222, 'Argyll', 'Argyll', 184, 'Scotland'),
  (151, 222, 'Ayrshire', 'Ayrshire', 185, 'Scotland'),
  (152, 222, 'Banffshire', 'Banffshire', 186, 'Scotland'),
  (153, 222, 'Berwickshire', 'Berwickshire', 187, 'Scotland'),
  (154, 222, 'Bute', 'Bute', 188, 'Scotland'),
  (155, 222, 'Caithness', 'Caithness', 189, 'Scotland'),
  (156, 222, 'Clackmannanshire', 'Clackmannanshire', 190, 'Scotland'),
  (157, 222, 'Dumfriesshire', 'Dumfriesshire', 191, 'Scotland'),
  (158, 222, 'Dunbartonshire', 'Dunbartonshire', 192, 'Scotland'),
  (159, 222, 'East Lothian', 'East Lothian', 193, 'Scotland'),
  (160, 222, 'Fife', 'Fife', 194, 'Scotland'),
  (161, 222, 'Inverness-shire', 'Inverness-shire', 195, 'Scotland'),
  (162, 222, 'Kincardineshire', 'Kincardineshire', 196, 'Scotland'),
  (163, 222, 'Kinross-shire', 'Kinross-shire', 197, 'Scotland'),
  (164, 222, 'Kirkcudbrightshire', 'Kirkcudbrightshire', 198, 'Scotland'),
  (165, 222, 'Lanarkshire', 'Lanarkshire', 199, 'Scotland'),
  (166, 222, 'Midlothian', 'Midlothian', 200, 'Scotland'),
  (167, 222, 'Moray', 'Moray', 201, 'Scotland'),
  (168, 222, 'Nairnshire', 'Nairnshire', 202, 'Scotland'),
  (169, 222, 'Orkney', 'Orkney', 203, 'Scotland'),
  (170, 222, 'Peeblesshire', 'Peeblesshire', 204, 'Scotland'),
  (171, 222, 'Perthshire', 'Perthshire', 205, 'Scotland'),
  (172, 222, 'Renfrewshire', 'Renfrewshire', 206, 'Scotland'),
  (173, 222, 'Ross-shire', 'Ross-shire', 207, 'Scotland'),
  (174, 222, 'Roxburghshire', 'Roxburghshire', 208, 'Scotland'),
  (175, 222, 'Selkirkshire', 'Selkirkshire', 209, 'Scotland'),
  (176, 222, 'Shetland', 'Shetland', 210, 'Scotland'),
  (177, 222, 'Stirlingshire', 'Stirlingshire', 211, 'Scotland'),
  (178, 222, 'Sutherland', 'Sutherland', 212, 'Scotland'),
  (179, 222, 'West Lothian', 'West Lothian', 213, 'Scotland'),
  (180, 222, 'Wigtownshire', 'Wigtownshire', 214, 'Scotland'),
  (181, 222, 'Antrim', 'Antrim', 215, 'Northern Ireland'),
  (182, 222, 'Down', 'Down', 217, 'Northern Ireland'),
  (183, 222, 'Armagh', 'Armagh', 216, 'Northern Ireland'),
  (184, 222, 'Fermanagh', 'Fermanagh', 218, 'Northern Ireland'),
  (185, 222, 'Londonderry', 'Londonderry', 219, 'Northern Ireland'),
  (186, 222, 'Tyrone', 'Tyrone', 220, 'Northern Ireland'),
  (187, 30, 'AL', 'Alagoas', 221, ''),
  (188, 30, 'AM', 'Amazonas', 222, ''),
  (189, 30, 'BA', 'Bahia', 223, ''),
  (190, 30, 'CE', 'Cearà', 224, ''),
  (191, 30, 'DF', 'Distrito Federal', 225, ''),
  (192, 30, 'ES', 'Espìrito Santo', 226, ''),
  (193, 30, 'GO', 'Goias', 227, ''),
  (194, 30, 'MA', 'Maranhao', 228, ''),
  (195, 30, 'MT', 'Mato Grosso', 229, ''),
  (196, 30, 'MS', 'Mato Grosso Do Sul', 230, ''),
  (197, 30, 'MG', 'Minas Gerais', 231, ''),
  (198, 30, 'PA', 'Parà', 232, ''),
  (199, 30, 'PB', 'Paraìba', 233, ''),
  (200, 30, 'PR', 'Paranà', 234, ''),
  (201, 30, 'PE', 'Pernambuco', 235, ''),
  (202, 30, 'PI', 'Piauì', 236, ''),
  (203, 30, 'RJ', 'Rio de Janeiro', 237, ''),
  (204, 30, 'RN', 'Rio Grande do Norte', 238, ''),
  (205, 30, 'RS', 'Dio Grande do Sul', 239, ''),
  (206, 30, 'RO', 'Rondônia', 240, ''),
  (207, 30, 'SC', 'Santa Catarina', 241, ''),
  (208, 30, 'SP', 'Sao Paulo', 242, ''),
  (209, 30, 'SE', 'Sergipe', 243, ''),
  (210, 44, 'ANH', 'Anhui', 244, ''),
  (211, 44, 'BEI', 'Beijing', 245, ''),
  (212, 44, 'CHO', 'Chongqing', 246, ''),
  (213, 44, 'FUJ', 'Fujian', 247, ''),
  (214, 44, 'GAN', 'Gansu', 248, ''),
  (215, 44, 'GDG', 'Guangdong', 249, ''),
  (216, 44, 'GXI', 'Guangxi', 250, ''),
  (217, 44, 'GUI', 'Guizhou', 251, ''),
  (218, 44, 'HAI', 'Hainan', 252, ''),
  (219, 44, 'HEB', 'Hebei', 253, ''),
  (220, 44, 'HEI', 'Heilongjiang', 254, ''),
  (221, 44, 'HEN', 'Henan', 255, ''),
  (222, 44, 'HUB', 'Hubei', 256, ''),
  (223, 44, 'HUN', 'Hunan', 257, ''),
  (224, 44, 'JSU', 'Jiangsu', 258, ''),
  (225, 44, 'JXI', 'Jiangxi', 259, ''),
  (226, 44, 'JIL', 'Jilin', 260, ''),
  (227, 44, 'LIA', 'Liaoning', 261, ''),
  (228, 44, 'MON', 'Nei Mongol', 262, ''),
  (229, 44, 'NIN', 'Ningxia', 263, ''),
  (230, 44, 'QIN', 'Qinghai', 264, ''),
  (231, 44, 'SHA', 'Shaanxi', 265, ''),
  (232, 44, 'SHD', 'Shandong', 266, ''),
  (233, 44, 'SHH', 'Shanghai', 267, ''),
  (234, 44, 'SHX', 'Shanxi', 268, ''),
  (235, 44, 'SIC', 'Sichuan', 269, ''),
  (236, 44, 'TIA', 'TIanjin', 270, ''),
  (237, 44, 'XIN', 'Xinjiang', 271, ''),
  (238, 44, 'XIZ', 'Xizang', 272, ''),
  (239, 44, 'YUN', 'Yunnan', 273, ''),
  (240, 44, 'ZHE', 'Zhejiang', 274, ''),
  (241, 99, 'AND', 'Andhra Pradesh', 275, ''),
  (242, 99, 'ASS', 'Assam', 276, ''),
  (243, 99, 'BIH', 'Bihar', 277, ''),
  (244, 99, 'CHH', 'Chhattisgarh', 278, ''),
  (245, 99, 'DEL', 'Delhi', 279, ''),
  (246, 99, 'GOA', 'Goa', 280, ''),
  (247, 99, 'GUJ', 'Gujarat', 281, ''),
  (248, 99, 'HAR', 'Haryana', 282, ''),
  (249, 99, 'HIM', 'Himachal Pradesh', 283, ''),
  (250, 99, 'JAM', 'Jammu & Kashmir', 284, ''),
  (251, 99, 'JHA', 'Jharkhand', 285, ''),
  (252, 99, 'KAR', 'Karnataka', 286, ''),
  (253, 99, 'KER', 'Kerala', 287, ''),
  (254, 99, 'MAD', 'Madhya Pradesh', 288, ''),
  (255, 99, 'MAH', 'Maharashtra', 289, ''),
  (256, 99, 'MEG', 'Meghalaya', 290, ''),
  (257, 99, 'ORI', 'Orissa', 291, ''),
  (258, 99, 'PON', 'Pondicherry', 292, ''),
  (259, 99, 'PUN', 'Punjab', 293, ''),
  (260, 99, 'RAJ', 'Rajasthan', 294, ''),
  (261, 99, 'TAM', 'Tamil Nadu', 295, ''),
  (262, 99, 'UTT', 'Uttar Pradesh', 296, ''),
  (263, 99, 'UTR', 'Uttaranchal', 297, ''),
  (264, 99, 'WES', 'West Bengal', 298, ''),
  (265, 107, 'AIC', 'Aichi', 299, ''),
  (266, 107, 'AKT', 'Akita', 300, ''),
  (267, 107, 'AMR', 'Aomori', 301, ''),
  (268, 107, 'CHB', 'Chiba', 302, ''),
  (269, 107, 'EHM', 'Ehime', 303, ''),
  (270, 107, 'FKI', 'Fukui', 304, ''),
  (271, 107, 'FKO', 'Fukuoka', 305, ''),
  (272, 107, 'FSM', 'Fukushima', 306, ''),
  (273, 107, 'GFU', 'Gifu', 307, ''),
  (274, 107, 'GUM', 'Gunma', 308, ''),
  (275, 107, 'HRS', 'Hiroshima', 309, ''),
  (276, 107, 'HKD', 'Hokkaido', 310, ''),
  (277, 107, 'HYG', 'Hyogo', 311, ''),
  (278, 107, 'IBR', 'Ibaraki', 312, ''),
  (279, 107, 'IKW', 'Ishikawa', 313, ''),
  (280, 107, 'IWT', 'Iwate', 314, ''),
  (281, 107, 'KGW', 'Kagawa', 315, ''),
  (282, 107, 'KGS', 'Kagoshima', 316, ''),
  (283, 107, 'KNG', 'Kanagawa', 317, ''),
  (284, 107, 'KCH', 'Kochi', 318, ''),
  (285, 107, 'KMM', 'Kumamoto', 319, ''),
  (286, 107, 'KYT', 'Kyoto', 320, ''),
  (287, 107, 'MIE', 'Mie', 321, ''),
  (288, 107, 'MYG', 'Miyagi', 322, ''),
  (289, 107, 'MYZ', 'Miyazaki', 323, ''),
  (290, 107, 'NGN', 'Nagano', 324, ''),
  (291, 107, 'NGS', 'Nagasaki', 325, ''),
  (292, 107, 'NRA', 'Nara', 326, ''),
  (293, 107, 'NGT', 'Niigata', 327, ''),
  (294, 107, 'OTA', 'Oita', 328, ''),
  (295, 107, 'OKY', 'Okayama', 329, ''),
  (296, 107, 'OKN', 'Okinawa', 330, ''),
  (297, 107, 'OSK', 'Osaka', 331, ''),
  (298, 107, 'SAG', 'Saga', 332, ''),
  (299, 107, 'STM', 'Saitama', 333, ''),
  (300, 107, 'SHG', 'Shiga', 334, ''),
  (301, 107, 'SMN', 'Shimane', 335, ''),
  (302, 107, 'SZK', 'Shizuoka', 336, ''),
  (303, 107, 'TOC', 'Tochigi', 337, ''),
  (304, 107, 'TKS', 'Tokushima', 338, ''),
  (305, 107, 'TKY', 'Tokyo', 335, ''),
  (306, 107, 'TTR', 'Tottori', 336, ''),
  (307, 107, 'TYM', 'Toyama', 337, ''),
  (308, 107, 'WKY', 'Wakayama', 338, ''),
  (309, 107, 'YGT', 'Yamagata', 339, ''),
  (310, 107, 'YGC', 'Yamaguchi', 340, ''),
  (311, 107, 'YNS', 'Yamanashi', 341, ''),
  (312, 0, '', 'FIXFORFRESHINSTALLS', 342, '')
;
INSERT INTO `ec_zone` (`zone_id`, `zone_name`) VALUES
  (1, 'North America'),
  (2, 'South America'),
  (3, 'Europe'),
  (4, 'Africa'),
  (5, 'Asia'),
  (6, 'Australia'),
  (7, 'Oceania'),
  (8, 'Lower 48 States'),
  (9, 'Alaska and Hawaii')
;
INSERT INTO `ec_zone_to_location` (`zone_to_location_id`, `zone_id`, `iso2_cnt`, `code_sta`) VALUES
  (1, 1, 'AI', ''),
  (2, 1, 'AQ', ''),
  (3, 1, 'AW', ''),
  (4, 1, 'BS', ''),
  (5, 1, 'BB', ''),
  (6, 1, 'BM', ''),
  (7, 1, 'BZ', ''),
  (8, 1, 'CA', ''),
  (9, 1, 'KY', ''),
  (10, 1, 'CR', ''),
  (11, 1, 'CU', ''),
  (12, 1, 'DM', ''),
  (13, 1, 'DO', ''),
  (14, 1, 'SV', ''),
  (15, 1, 'GL', ''),
  (16, 1, 'GD', ''),
  (17, 1, 'GP', ''),
  (18, 1, 'GT', ''),
  (19, 1, 'HT', ''),
  (20, 1, 'HN', ''),
  (21, 1, 'JM', ''),
  (22, 1, 'MQ', ''),
  (23, 1, 'MX', ''),
  (24, 1, 'MS', ''),
  (25, 1, 'NI', ''),
  (26, 1, 'PA', ''),
  (27, 1, 'PR', ''),
  (28, 1, 'KN', ''),
  (29, 1, 'LC', ''),
  (30, 1, 'TT', ''),
  (31, 1, 'TC', ''),
  (32, 1, 'US', ''),
  (33, 1, 'VI', ''),
  (34, 2, 'AR', ''),
  (35, 2, 'BO', ''),
  (36, 2, 'BR', ''),
  (37, 2, 'CL', ''),
  (38, 2, 'CO', ''),
  (39, 2, 'EC', ''),
  (40, 2, 'GF', ''),
  (41, 2, 'GY', ''),
  (42, 2, 'PY', ''),
  (43, 2, 'PE', ''),
  (44, 2, 'SR', ''),
  (45, 2, 'UY', ''),
  (46, 2, 'VE', ''),
  (47, 6, 'AU', ''),
  (48, 7, 'AS', ''),
  (49, 7, 'AU', ''),
  (50, 7, 'CK', ''),
  (51, 7, 'FJ', ''),
  (52, 7, 'PF', ''),
  (53, 7, 'GU', ''),
  (54, 7, 'KI', ''),
  (55, 7, 'MH', ''),
  (56, 7, 'NR', ''),
  (57, 7, 'NC', ''),
  (58, 7, 'NZ', ''),
  (59, 7, 'NU', ''),
  (60, 7, 'NF', ''),
  (61, 7, 'PW', ''),
  (62, 7, 'PG', ''),
  (63, 7, 'PN', ''),
  (64, 7, 'WS', ''),
  (65, 7, 'SB', ''),
  (66, 7, 'TK', ''),
  (67, 7, 'TO', ''),
  (68, 7, 'TV', ''),
  (69, 7, 'VU', ''),
  (70, 7, 'WF', ''),
  (71, 3, 'AL', ''),
  (72, 3, 'AD', ''),
  (73, 3, 'AT', ''),
  (74, 3, 'BY', ''),
  (75, 3, 'BE', ''),
  (76, 3, 'BG', ''),
  (77, 3, 'HR', ''),
  (78, 3, 'CZ', ''),
  (79, 3, 'DK', ''),
  (80, 3, 'EE', ''),
  (81, 3, 'FO', ''),
  (82, 3, 'FI', ''),
  (83, 3, 'FR', ''),
  (84, 3, 'DE', ''),
  (257, 3, 'DC', ''),
  (85, 3, 'GI', ''),
  (86, 3, 'GR', ''),
  (87, 3, 'HU', ''),
  (88, 3, 'IS', ''),
  (89, 3, 'IE', ''),
  (90, 3, 'IT', ''),
  (91, 3, 'LV', ''),
  (92, 3, 'LI', ''),
  (93, 3, 'LT', ''),
  (94, 3, 'LU', ''),
  (95, 3, 'MT', ''),
  (96, 3, 'MC', ''),
  (97, 3, 'NL', ''),
  (98, 3, 'NO', ''),
  (99, 3, 'PL', ''),
  (100, 3, 'PT', ''),
  (101, 3, 'RO', ''),
  (102, 3, 'RU', ''),
  (103, 3, 'SM', ''),
  (104, 3, 'SI', ''),
  (105, 3, 'ES', ''),
  (106, 3, 'SE', ''),
  (107, 3, 'CH', ''),
  (108, 3, 'UA', ''),
  (109, 3, 'GB', ''),
  (110, 4, 'DZ', ''),
  (111, 4, 'AO', ''),
  (112, 4, 'BJ', ''),
  (113, 4, 'BW', ''),
  (114, 4, 'BF', ''),
  (115, 4, 'BI', ''),
  (116, 4, 'CM', ''),
  (117, 4, 'CV', ''),
  (118, 4, 'TD', ''),
  (119, 4, 'KM', ''),
  (120, 4, 'CG', ''),
  (121, 4, 'CI', ''),
  (122, 4, 'DJ', ''),
  (123, 4, 'EG', ''),
  (124, 4, 'GQ', ''),
  (125, 4, 'ER', ''),
  (126, 4, 'ET', ''),
  (127, 4, 'GA', ''),
  (128, 4, 'GM', ''),
  (129, 4, 'GH', ''),
  (130, 4, 'GN', ''),
  (131, 4, 'GW', ''),
  (132, 4, 'KE', ''),
  (133, 4, 'LS', ''),
  (134, 4, 'LR', ''),
  (135, 4, 'MG', ''),
  (136, 4, 'MW', ''),
  (137, 4, 'ML', ''),
  (138, 4, 'MR', ''),
  (139, 4, 'MU', ''),
  (140, 4, 'YT', ''),
  (141, 4, 'MA', ''),
  (142, 4, 'MZ', ''),
  (143, 4, 'NA', ''),
  (144, 4, 'NE', ''),
  (145, 4, 'NG', ''),
  (146, 4, 'RE', ''),
  (147, 4, 'RW', ''),
  (148, 4, 'ST', ''),
  (149, 4, 'SN', ''),
  (150, 4, 'SC', ''),
  (151, 4, 'SL', ''),
  (152, 4, 'SO', ''),
  (153, 4, 'ZA', ''),
  (154, 4, 'SD', ''),
  (155, 4, 'SZ', ''),
  (156, 4, 'TG', ''),
  (157, 4, 'TN', ''),
  (158, 4, 'UG', ''),
  (159, 4, 'ZM', ''),
  (160, 4, 'ZW', ''),
  (161, 5, 'AF', ''),
  (162, 5, 'AM', ''),
  (163, 5, 'AZ', ''),
  (164, 5, 'BH', ''),
  (165, 5, 'BD', ''),
  (166, 5, 'BT', ''),
  (167, 5, 'BN', ''),
  (168, 5, 'KH', ''),
  (169, 5, 'CN', ''),
  (170, 5, 'CX', ''),
  (171, 5, 'CY', ''),
  (172, 5, 'TP', ''),
  (173, 5, 'GE', ''),
  (174, 5, 'HK', ''),
  (175, 5, 'IN', ''),
  (176, 5, 'ID', ''),
  (177, 5, 'IQ', ''),
  (178, 5, 'IL', ''),
  (179, 5, 'JP', ''),
  (180, 5, 'JO', ''),
  (181, 5, 'KZ', ''),
  (182, 5, 'KW', ''),
  (183, 5, 'KG', ''),
  (184, 5, 'LB', ''),
  (185, 5, 'MO', ''),
  (186, 5, 'MY', ''),
  (187, 5, 'MV', ''),
  (188, 5, 'MN', ''),
  (189, 5, 'MM', ''),
  (190, 5, 'NP', ''),
  (191, 5, 'OM', ''),
  (192, 5, 'PK', ''),
  (193, 5, 'PH', ''),
  (194, 5, 'QA', ''),
  (195, 5, 'SA', ''),
  (196, 5, 'SG', ''),
  (197, 5, 'LK', ''),
  (198, 5, 'TW', ''),
  (199, 5, 'TJ', ''),
  (200, 5, 'TH', ''),
  (201, 5, 'TR', ''),
  (202, 5, 'TM', ''),
  (203, 5, 'AE', ''),
  (204, 5, 'UZ', ''),
  (205, 5, 'VN', ''),
  (206, 5, 'YE', ''),
  (207, 9, 'US', 'HI'),
  (208, 9, 'US', 'AK'),
  (209, 8, 'US', 'AL'),
  (210, 8, 'US', 'AZ'),
  (211, 8, 'US', 'AR'),
  (212, 8, 'US', 'CA'),
  (213, 8, 'US', 'CO'),
  (214, 8, 'US', 'CT'),
  (215, 8, 'US', 'DE'),
  (258, 8, 'US', 'DC'),
  (216, 8, 'US', 'FL'),
  (217, 8, 'US', 'GA'),
  (218, 8, 'US', 'ID'),
  (219, 8, 'US', 'IL'),
  (220, 8, 'US', 'IN'),
  (221, 8, 'US', 'IA'),
  (222, 8, 'US', 'KS'),
  (223, 8, 'US', 'KY'),
  (224, 8, 'US', 'LA'),
  (225, 8, 'US', 'ME'),
  (226, 8, 'US', 'MD'),
  (227, 8, 'US', 'MA'),
  (228, 8, 'US', 'MI'),
  (229, 8, 'US', 'MN'),
  (230, 8, 'US', 'MS'),
  (231, 8, 'US', 'MO'),
  (232, 8, 'US', 'MT'),
  (233, 8, 'US', 'NE'),
  (234, 8, 'US', 'NV'),
  (235, 8, 'US', 'NH'),
  (236, 8, 'US', 'NJ'),
  (237, 8, 'US', 'NM'),
  (238, 8, 'US', 'NY'),
  (239, 8, 'US', 'NC'),
  (240, 8, 'US', 'ND'),
  (241, 8, 'US', 'OH'),
  (242, 8, 'US', 'OK'),
  (243, 8, 'US', 'OR'),
  (244, 8, 'US', 'PA'),
  (245, 8, 'US', 'RI'),
  (246, 8, 'US', 'SC'),
  (247, 8, 'US', 'SD'),
  (248, 8, 'US', 'TN'),
  (249, 8, 'US', 'TX'),
  (250, 8, 'US', 'UT'),
  (251, 8, 'US', 'VT'),
  (252, 8, 'US', 'VA'),
  (253, 8, 'US', 'WA'),
  (254, 8, 'US', 'WV'),
  (255, 8, 'US', 'WI'),
  (256, 8, 'US', 'WY')
;