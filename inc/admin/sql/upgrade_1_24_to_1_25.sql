;
ALTER TABLE ec_setting ADD `ups_ship_from_state` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This sets the ship from state when using UPS.';
ALTER TABLE ec_setting ADD `ups_negotiated_rates` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'This sets the ship from state when using UPS.';