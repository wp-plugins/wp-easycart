;
ALTER TABLE ec_taxrate ADD `tax_by_single_vat` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat tax all users the same if selected.';
ALTER TABLE ec_taxrate ADD `vat_added` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is added to the total at the end, not included in the products.';
ALTER TABLE ec_taxrate ADD `vat_included` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Vat is included in the price of the product.';