;
ALTER TABLE ec_product ADD `TIC` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '00000' COMMENT 'TIC value used with Tax Cloud.';
ALTER TABLE ec_optionitem ADD `optionitem_initially_selected` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Forces this optionitem to be selected when the option set loads.';