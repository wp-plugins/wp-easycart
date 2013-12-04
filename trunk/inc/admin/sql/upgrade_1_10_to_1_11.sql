;
ALTER TABLE ec_product ADD `use_advanced_optionset` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If true, uses the advanced, unlimited option set type.';
ALTER TABLE ec_option ADD `option_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'combo' COMMENT 'The type of input for the option.'
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
  PRIMARY KEY (`zone_id`),
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