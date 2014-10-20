;
ALTER TABLE ec_product ADD `short_description` VARCHAR(2048) NOT NULL DEFAULT '' COMMENT 'Short description for the product.';
ALTER TABLE ec_product ADD `display_type` INT(11) NOT NULL DEFAULT 1 COMMENT 'The display type selected for a given product.';
ALTER TABLE ec_product ADD `image_hover_type` INT(11) NOT NULL DEFAULT 3 COMMENT 'The hover effect of a product image.';
ALTER TABLE ec_product ADD `tag_type` INT(11) NOT NULL DEFAULT 0 COMMENT 'The type of optional tag applied to the product.';
ALTER TABLE ec_product ADD `tag_bg_color` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'The optional bg color of a tag applied to the product.';
ALTER TABLE ec_product ADD `tag_text_color` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'The optional text color of a tag applied to a product.';
ALTER TABLE ec_product ADD `tag_text` VARCHAR(256) NOT NULL DEFAULT '' COMMENT 'The option text of a tag applied to a product.';
ALTER TABLE ec_product ADD `image_effect_type` VARCHAR(20) NOT NULL DEFAULT 'none' COMMENT 'An optional border or shadow can be applied to a product.';
CREATE TABLE IF NOT EXISTS `ec_pageoption` (
  `pageoption_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for ec_pageoption',
  `post_id` INT(11) NOT NULL DEFAULT '0' COMMENT 'The post id for this WordPress page',
  `option_type` VARCHAR(155) NOT NULL DEFAULT '' COMMENT 'The key for the pageoption.',
  `option_value` TEXT NOT NULL COMMENT 'The value for the pageoption',
  PRIMARY KEY (`pageoption_id`),
  UNIQUE KEY `pageoption_id` (`pageoption_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=122 CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8
;
ALTER TABLE ec_tempcart ADD `gift_card_email` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'The value of the gift card email if needed.';
ALTER TABLE ec_orderdetail ADD `gift_card_email` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The gift card email is needed.';
ALTER TABLE ec_address ADD `company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Company name relating to this address.';
ALTER TABLE ec_order ADD `billing_company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Billing company name for this order if used.';
ALTER TABLE ec_order ADD `shipping_company_name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Shipping company name for this order if used.';
ALTER TABLE ec_optionitem ADD `optionitem_model_number` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'Model number extension that gets added to product model number if selected.';
ALTER TABLE ec_tempcart_optionitem ADD `optionitem_model_number` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'Model number extension that gets added to product model number if selected.';
ALTER TABLE ec_order ADD `guest_key` VARCHAR(124) NOT NULL DEFAULT '' COMMENT 'Used for guest checkouts to allow a guest to view an order.';