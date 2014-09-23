;
ALTER TABLE ec_order ADD `refund_total` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'Amount of the order that has been refunded.';
ALTER TABLE ec_product ADD `is_preorder` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Makes this product a preorder product, allowing for an authorization of a card without capturing at this time';
ALTER TABLE ec_product ADD `membership_page` VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Optional link to a membership content page to be displayed after subscription purchased.';
ALTER TABLE ec_subscription ADD `user_id` INT(11) NOT NULL DEFAULT 0 COMMENT 'User ID of the subscription owner.';
ALTER TABLE ec_subscription ADD `product_id` INT(11) NOT NULL DEFAULT 0 COMMENT 'Product ID of the subscription to connect to.';
ALTER TABLE ec_user ADD `default_card_type` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Used for subscription display of where billed to.';
ALTER TABLE ec_user ADD `default_card_last4` VARCHAR(8) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Used for subscription display of where billed to.';
ALTER TABLE ec_shippingrate ADD `is_percentage_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, this rate is for percentage based shipping.';
ALTER TABLE ec_state ADD `group_sta` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Option to group states in the state dropdown by a group title';
CREATE TABLE IF NOT EXISTS `ec_webhook` (
  `webhook_id` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The unique indentifier for the webhook table, used by Stripe.',
  `webhook_type` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'The type of webhook called.',
  `webhook_data` BLOB COMMENT 'The data returned from stripe in this webhook call.',
  PRIMARY KEY (`webhook_id`),
  UNIQUE KEY `webhook_id` (`webhook_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' DEFAULT CHARSET=utf8 PACK_KEYS=0;
ALTER TABLE ec_order ADD `nets_transaction_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Nets Transaction ID if Nets used.';
ALTER TABLE ec_setting ADD `fraktjakt_address` VARCHAR(120) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_city` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_state` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_zip` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_setting ADD `fraktjakt_country` VARCHAR(2) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt used for shipping estimate.';
ALTER TABLE ec_product ADD `min_purchase_quantity` INT(11) NOT NULL DEFAULT '0' COMMENT 'Optional minimum amount required for during purchase.';
ALTER TABLE ec_user ADD `exclude_tax` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give customer tax free purchases.';
ALTER TABLE ec_user ADD `exclude_shipping` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Give free shipping to this customer.';
ALTER TABLE ec_product ADD `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.';
ALTER TABLE ec_orderdetail ADD `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.';
ALTER TABLE ec_download ADD `is_amazon_download` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Turns the download location to Amazon S3 servers.';
ALTER TABLE ec_product ADD `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.';
ALTER TABLE ec_orderdetail ADD `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.';
ALTER TABLE ec_download ADD `amazon_key` VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'The file name used on the Amazon S3 Server.';
ALTER TABLE ec_product ADD `is_deconetwork` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Makes this a DecoNetwork product, allowing for custom designed goods.';
ALTER TABLE ec_product ADD `deconetwork_mode` VARCHAR(64) NOT NULL DEFAULT 'designer' COMMENT 'If using deconetwork, enter designer, blank, designer_predec, predec, design, or view_design as a value.';
ALTER TABLE ec_product ADD `deconetwork_product_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the product id to send the customer to.';
ALTER TABLE ec_product ADD `deconetwork_size_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the size id to force the product into by default, optional.';
ALTER TABLE ec_product ADD `deconetwork_color_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the color id to force the product into by default, optional.';
ALTER TABLE ec_product ADD `deconetwork_design_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'If using deconetwork, this is the design id to force the product into by default, optional.';
ALTER TABLE ec_tempcart ADD `is_deconetwork` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Sets this item as a DecoNetwork item and changes the display to work with this product type.';
ALTER TABLE ec_tempcart ADD `deconetwork_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The unique id sent back from the DecoNetwork when adding to cart.';
ALTER TABLE ec_tempcart ADD `deconetwork_name` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The name of the product from the DecoNetwork.';
ALTER TABLE ec_tempcart ADD `deconetwork_product_code` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The product code from the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_options` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The options selected by the customer on the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_edit_link` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The edit link provided by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_color_code` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The color code of the shirt by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_product_id` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The product id of this product on the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_image_link` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'The image link provided by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_discount` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'Any discount provided by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_tax` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'The tax amount by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_total` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'The total line item cost by the DecoNetwork';
ALTER TABLE ec_tempcart ADD `deconetwork_version` INTEGER(11) NOT NULL DEFAULT 1 COMMENT 'A value updated each time the customer returns from the Deconetwork for this product, which is used to update the image to the user.';
ALTER TABLE ec_orderdetail ADD `is_deconetwork` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'This tells the system that it is a DecoNetwork product and changes the display type accordingly.';
ALTER TABLE ec_orderdetail ADD `deconetwork_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'The unique id for this item provided by the DecoNetwork';
ALTER TABLE ec_orderdetail ADD `deconetwork_name` varchar(512) NOT NULL DEFAULT '' COMMENT 'The name provided by the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_product_code` varchar(64) NOT NULL DEFAULT '' COMMENT 'The product code provided by the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_options` varchar(512) NOT NULL DEFAULT '' COMMENT 'The options selected by the customer on the DecoNetwork site.';
ALTER TABLE ec_orderdetail ADD `deconetwork_color_code` varchar(64) NOT NULL DEFAULT '' COMMENT 'The color code of the selected shirt provided by the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_product_id` varchar(64) NOT NULL DEFAULT '' COMMENT 'The product id on the DecoNetwork.';
ALTER TABLE ec_orderdetail ADD `deconetwork_image_link` varchar(512) NOT NULL DEFAULT '' COMMENT 'The link to the image on the DecoNetwork.';
ALTER TABLE ec_order ADD `order_gateway` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'The gateway used during checkout ONLY IF a refund functionality is available.';
ALTER TABLE ec_order ADD `affirm_charge_id` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'The Affirm Charge ID added during checkout';