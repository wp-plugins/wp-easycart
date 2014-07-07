;
ALTER TABLE ec_product ADD `min_purchase_quantity` INT(11) NOT NULL DEFAULT '0' COMMENT 'Optional minimum amount required for during purchase.';
ALTER TABLE ec_user ADD `exclude_tax` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give customer tax free purchases.';
ALTER TABLE ec_user ADD `exclude_shipping` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give free shipping to this customer.';