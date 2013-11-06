;
ALTER TABLE ec_user ADD `realauth_registered` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, customer is using Realex Payments and this customer already has an account in the RealVault.';
ALTER TABLE ec_setting ADD `dhl_site_id` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Site ID.';
ALTER TABLE ec_setting ADD `dhl_password` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Password.';
ALTER TABLE ec_setting ADD `dhl_ship_from_country` VARCHAR(25) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT 'Your DHL Ship From Country.';
ALTER TABLE ec_setting ADD `dhl_ship_from_zip` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your DHL Ship From Zip.';
ALTER TABLE ec_setting ADD `dhl_weight_unit` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'LB' COMMENT 'Your DHL Weight Unit.';
ALTER TABLE ec_setting ADD `dhl_test_mode` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Use DHL Test Mode.';
ALTER TABLE ec_shippingrate ADD `is_dhl_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for DHL.';