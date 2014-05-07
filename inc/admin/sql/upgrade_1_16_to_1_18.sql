;
ALTER TABLE ec_state ADD `group_sta` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option to group states in the state dropdown by a group title';
ALTER TABLE ec_order ADD `nets_transaction_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Nets Transaction ID if Nets used.';