;
ALTER TABLE ec_taxrate ADD `tax_by_single_vat` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat tax all users the same if selected.';
ALTER TABLE ec_taxrate ADD `vat_added` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is added to the total at the end, not included in the products.';
ALTER TABLE ec_taxrate ADD `vat_included` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is included in the price of the product.';
ALTER TABLE ec_order ADD `creditcard_digits` VARCHAR(4) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If credit card checkout is used, saves the last four digits here.';