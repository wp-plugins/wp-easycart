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
ALTER TABLE ec_product ADD `use_advanced_optionset` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If true, uses the advanced, unlimited option set type.';
ALTER TABLE ec_option ADD `option_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'combo' COMMENT 'The type of input for the option.';
ALTER TABLE ec_option ADD `option_required` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Is this option required.';
ALTER TABLE ec_option ADD `option_error_text` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Text displayed when option required and no value selected.';
ALTER TABLE ec_optionitem ADD `optionitem_price_onetime` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Price change one-time addition to total price.';
ALTER TABLE ec_optionitem ADD `optionitem_price_override` FLOAT(15,3) NOT NULL DEFAULT -1.000 COMMENT 'Price change to override product price.';
ALTER TABLE ec_optionitem ADD `optionitem_weight` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Weight change value for an optionitem.';
ALTER TABLE ec_optionitem ADD `optionitem_weight_onetime` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Weight change one-time addition to total weight.';
ALTER TABLE ec_optionitem ADD `optionitem_weight_override` FLOAT(15,3) NOT NULL DEFAULT -1.000 COMMENT 'Weight change to override product weight.';
ALTER TABLE ec_optionitem ADD `optionitem_initial_value` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'For some options an initial value is useful.';
ALTER TABLE ec_orderdetail ADD `use_advanced_optionset` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Used for display purposes to notify if this item uses advanced option sets.';
ALTER TABLE ec_shippingrate ADD `zone_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'References the ec_zone table for zoned shipping rates.';
ALTER TABLE ec_tempcart ADD `grid_quantity` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Amount in the cart for grid option set products only';
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
CREATE TABLE IF NOT EXISTS `ec_tempcart_optionitem` (
  `tempcart_optionitem_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 
   'Unique ID for this table.',
  `tempcart_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 
   'Relating tempcart_id.',
  `option_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 
   'Relating option_id',
  `optionitem_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 
   'Relating optionitem_id.',
  `optionitem_value` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 
   'Value of the selected option, blob to allow for any value.',
  PRIMARY KEY (`tempcart_optionitem_id`)
)ENGINE=MyISAM 
AUTO_INCREMENT=133 CHARACTER SET 'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
CREATE TABLE IF NOT EXISTS `ec_order_option` (
  `order_option_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT 
   'Unique ID for this table.',
  `orderdetail_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT
   'Referece to the ec_orderdetail table.',
  `option_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Name of the option, e.g. Shirt Color.',
  `optionitem_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Name of the optionitem, e.g. Large. Only used for a grid option.',
  `option_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'combo' COMMENT
   'The type of option set, e.g. combo.',
  `option_value` TEXT COLLATE utf8_general_ci NOT NULL COMMENT
   'The value of this selected option.',
  `option_price_change` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The display value for a price change on this option.',
  PRIMARY KEY (`order_option_id`)
)ENGINE=MyISAM 
AUTO_INCREMENT=22 CHARACTER SET 'utf8' COLLATE
'utf8_general_ci'
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
  (47, 4, 'AU', ''),
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
ALTER TABLE ec_taxrate ADD `tax_by_single_vat` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat tax all users the same if selected.';
ALTER TABLE ec_taxrate ADD `vat_added` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is added to the total at the end, not included in the products.';
ALTER TABLE ec_taxrate ADD `vat_included` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is included in the price of the product.';
ALTER TABLE ec_order ADD `creditcard_digits` VARCHAR(4) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If credit card checkout is used, saves the last four digits here.';
ALTER TABLE ec_product ADD `is_subscription_item` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Makes this product a subscription product which is purchased individually.';
ALTER TABLE ec_product ADD `subscription_bill_length` INTEGER(11) NOT NULL DEFAULT '1' COMMENT 'Number of the period times to charge the customer, e.g. 3 paired with month is charge once every 3 months.';
ALTER TABLE ec_product ADD `subscription_bill_period` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'M' COMMENT 'The period of the subscription, valid values are: D, W, M, Y.';
ALTER TABLE ec_setting ADD `ups_conversion_rate` FLOAT(9,3) NOT NULL DEFAULT '1.000' COMMENT 'Converts the returned pricing.';
ALTER TABLE ec_setting ADD `fedex_conversion_rate` FLOAT(9,3) NOT NULL DEFAULT '1.000' COMMENT 'Converts the returned pricing.';
ALTER TABLE ec_setting ADD `fedex_test_account` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'If true, FedEx account is a test account.';
ALTER TABLE ec_shippingrate ADD `is_quantity_based` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'If selected, this rate is for quantity based shipping.';
ALTER TABLE ec_menulevel1 MODIFY `name` VARCHAR( 1024 ) NOT NULL;
ALTER TABLE ec_menulevel2 MODIFY `name` VARCHAR( 1024 ) NOT NULL;
ALTER TABLE ec_menulevel3 MODIFY `name` VARCHAR( 1024 ) NOT NULL;
CREATE TABLE IF NOT EXISTS `ec_subscription` (
  `subscription_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'Unique ID for this table',
  `subscription_type` VARCHAR(125) COLLATE utf8_general_ci NOT NULL DEFAULT 'paypal' COMMENT
   'Type of subscription, e.g. paypal',
  `subscription_status` VARCHAR(125) COLLATE utf8_general_ci NOT NULL DEFAULT 'Active' COMMENT
   'Status of the subscription, Active or Canceled for example.',
  `title` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Title of the product purchased.',
  `model_number` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Model number of the product purchased.',
  `price` double(21,3) NOT NULL DEFAULT '0.000' COMMENT
   'Price of the product per period',
  `payment_length` int(11) NOT NULL DEFAULT '1' COMMENT
   'Length of time between payments, e.g. 3 months, represented by 3 in this field.',
  `payment_period` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Period of the payment, day, week, month of year, represented as D, W, M, or Y in this field.',
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT
   'Date that this payment was submitted to start the subscription.',
  `last_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The last date that this subscription was paid for.',
  `next_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The next payment due date.',
  `email` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Email entered by the user while purchasing the subscription',
  `first_name` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'First name of the customer.',
  `last_name` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Last name of the customer.',
  `user_country` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT
   'Customer country of residence',
  `number_payments_completed` int(11) NOT NULL DEFAULT '1' COMMENT
   'The number of times this subscription has been paid for.',
  `paypal_txn_id` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Initial transaction ID from PayPal',
  `paypal_txn_type` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Initial transaction type from PayPal',
  `paypal_subscr_id` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Initial subscription ID from PayPal used to track the subscription when updated or canceled.',
  `paypal_username` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Username assigned to this subscription by PayPal.',
  `paypal_password` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Password assigned to this subscription by PayPal.',
  PRIMARY KEY (`subscription_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE ec_product ADD `width` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Width of the product in the default shipping unit.';
ALTER TABLE ec_product ADD `height` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Height of the product in the default shipping unit.';
ALTER TABLE ec_product ADD `length` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Length of the product in the default shipping unit.';
ALTER TABLE ec_product ADD `trial_period_days` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Length of subscription trial period in days.';
ALTER TABLE ec_product ADD `stripe_plan_added` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Has this subscription product been added to Stripe.';
ALTER TABLE ec_product ADD `subscription_plan_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Used to group the subscriptions in a membership plan used for upgrade.';
ALTER TABLE ec_product ADD `allow_multiple_subscription_purchases` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Should this item be able to be purchased multiple times.';
ALTER TABLE ec_setting ADD `fraktjakt_customer_id` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt Customer ID.';
ALTER TABLE ec_setting ADD `fraktjakt_login_key` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt Login Key.';
ALTER TABLE ec_setting ADD `fraktjakt_conversion_rate` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'The conversion rate between your base currency and SEK.';
ALTER TABLE ec_setting ADD `fraktjakt_test_mode` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Use test mode for Fraktjakt.';
ALTER TABLE ec_order ADD `fraktjakt_order_id` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Order ID for the Fraktjakt shipment.';
ALTER TABLE ec_order ADD `fraktjakt_shipment_id` VARCHAR(20) COLLATE utf8_general_ci DEFAULT '' COMMENT 'Shipment ID for the Fraktjakt shipment.';
ALTER TABLE ec_order ADD `stripe_charge_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Stripe Charge ID if Stripe used.';
ALTER TABLE ec_order ADD `subscription_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Subscription ID from the ec_subscription table if order was a subscription order.';
ALTER TABLE ec_promocode ADD `max_redemptions` INTEGER(11) NOT NULL DEFAULT '999' COMMENT 'The maximum number of times you can use this promotion code.';
ALTER TABLE ec_promocode ADD `times_redeemed` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'This is the number of times this coupon has been redeemed.';
ALTER TABLE ec_user ADD `stripe_customer_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Stripe Customer ID if subscription created with Stripe.';
ALTER TABLE ec_subscription ADD `stripe_subscription_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If subscription created with Stripe, Stripe ID here.';
ALTER TABLE ec_subscription MODIFY `last_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Last payment made.';
CREATE TABLE IF NOT EXISTS `ec_subscription_plan` (
  `subscription_plan_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'Unique ID for a Subscription Plan.',
  `plan_title` VARCHAR(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'Title to describe the plan of connecting subscriptions.',
  `can_downgrade` TINYINT(1) NOT NULL DEFAULT '0' COMMENT
   'Can a customer automatically downgrade their subscription plan.',
  PRIMARY KEY (`subscription_plan_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=0 CHARACTER SET'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
ALTER TABLE ec_order ADD `refund_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Amount of the order that has been refunded.';
ALTER TABLE ec_product ADD `is_preorder` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Makes this product a preorder product, allowing for an authorization of a card without capturing at this time';
ALTER TABLE ec_product ADD `membership_page` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Optional link to a membership content page to be displayed after subscription purchased.';
ALTER TABLE ec_subscription ADD `user_id` INT(11) NOT NULL DEFAULT 0 COMMENT 'User ID of the subscription owner.';
ALTER TABLE ec_subscription ADD `product_id` INT(11) NOT NULL DEFAULT 0 COMMENT 'Product ID of the subscription to connect to.';
ALTER TABLE ec_user ADD `default_card_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Used for subscription display of where billed to.';
ALTER TABLE ec_user ADD `default_card_last4` VARCHAR(8) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Used for subscription display of where billed to.';
ALTER TABLE ec_shippingrate ADD `is_percentage_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this rate is for percentage based shipping.';
ALTER TABLE ec_state ADD `group_sta` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option to group states in the state dropdown by a group title';
CREATE TABLE IF NOT EXISTS `ec_webhook` (
  `webhook_id` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The unique indentifier for the webhook table, used by Stripe.',
  `webhook_type` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'The type of webhook called.',
  `webhook_data` BLOB COMMENT 'The data returned from stripe in this webhook call.',
  PRIMARY KEY (`webhook_id`),
  UNIQUE KEY `webhook_id` (`webhook_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8 PACK_KEYS=0;
ALTER TABLE ec_order ADD `nets_transaction_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Nets Transaction ID if Nets used.';
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