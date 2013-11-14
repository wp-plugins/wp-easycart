;
ALTER TABLE ec_shippingrate MODIFY shipping_override_rate float(11,3) NULL DEFAULT NULL;
ALTER TABLE ec_orderdetail ADD `optionitem_price_1` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_2` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_3` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_4` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_5` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_order ADD `order_customer_notes` BLOB;
ALTER TABLE ec_country ADD `vat_rate_cnt` float(9,3) NOT NULL DEFAULT '0.000';
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
INSERT INTO `ec_role` (`role_id`, `role_label`, `admin_access`) VALUES
  (1, 'admin', 1),
  (2, 'shopper', 0)
;
ALTER TABLE ec_order ADD `txn_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific TXN ID.';
ALTER TABLE ec_order ADD `edit_sequence` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence.';
ALTER TABLE ec_product ADD `list_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific List ID.';
ALTER TABLE ec_product ADD `edit_sequence` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence.';
ALTER TABLE ec_user ADD `list_id` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific List ID.';
ALTER TABLE ec_user ADD `edit_sequence` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence';
ALTER TABLE ec_setting ADD `auspost_api_key` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your Australian Post API Key';
ALTER TABLE ec_setting ADD `auspost_ship_from_zip` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your Australian Post Ship From Postal Code';
ALTER TABLE ec_shippingrate ADD `is_auspost_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for Australian Post is used.';
ALTER TABLE ec_shippingrate MODIFY `shipping_code` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is the code used for methods like UPS to determine the cost for this method.';
ALTER TABLE ec_user ADD `realauth_registered` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, customer is using Realex Payments and this customer already has an account in the RealVault.';
ALTER TABLE ec_setting ADD `dhl_site_id` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Site ID.';
ALTER TABLE ec_setting ADD `dhl_password` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Password.';
ALTER TABLE ec_setting ADD `dhl_ship_from_country` VARCHAR(25) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT 'Your DHL Ship From Country.';
ALTER TABLE ec_setting ADD `dhl_ship_from_zip` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Ship From Zip.';
ALTER TABLE ec_setting ADD `dhl_test_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Use DHL Test Mode.';
ALTER TABLE ec_shippingrate ADD `is_dhl_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for DHL.';
ALTER TABLE ec_setting ADD `dhl_weight_unit` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'LB' COMMENT 'Your DHL Weight Unit.';
ALTER TABLE ec_product ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_menulevel1 ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_menulevel2 ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_menulevel3 ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_category ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';
ALTER TABLE ec_manufacturer ADD `post_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Post ID to connect the product to the WordPress custom post type structure.';