;
ALTER TABLE ec_order ADD `nets_transaction_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Nets Transaction ID if Nets used.';