;
ALTER TABLE ec_order ADD `creditcard_digits` VARCHAR(4) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If credit card checkout is used, saves the last four digits here.';