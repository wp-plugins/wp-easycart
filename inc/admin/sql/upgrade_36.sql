;
ALTER TABLE `ec_order_option` ADD `option_label` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'Passes the option label from the front end to store with each order.';