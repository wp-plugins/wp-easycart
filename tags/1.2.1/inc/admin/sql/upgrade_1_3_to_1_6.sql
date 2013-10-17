;
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