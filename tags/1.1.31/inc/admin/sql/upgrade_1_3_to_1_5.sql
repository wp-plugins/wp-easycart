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