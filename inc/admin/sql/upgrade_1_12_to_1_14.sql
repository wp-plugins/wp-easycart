;
ALTER TABLE ec_order ADD `creditcard_digits` VARCHAR(4) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If credit card checkout is used, saves the last four digits here.';
ALTER TABLE ec_product ADD `is_subscription_item` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Makes this product a subscription product which is purchased individually.';
ALTER TABLE ec_product ADD `subscription_bill_length` INTEGER(11) NOT NULL DEFAULT '1' COMMENT 'Number of the period times to charge the customer, e.g. 3 paired with month is charge once every 3 months.';
ALTER TABLE ec_product ADD `subscription_bill_period` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'M' COMMENT 'The period of the subscription, valid values are: D, W, M, Y.';
ALTER TABLE ec_setting ADD `ups_conversion_rate` FLOAT(9,3) NOT NULL DEFAULT '1.000' COMMENT 'Converts the returned pricing.';
ALTER TABLE ec_setting ADD `fedex_conversion_rate` FLOAT(9,3) NOT NULL DEFAULT '1.000' COMMENT 'Converts the returned pricing.';
ALTER TABLE ec_setting ADD `fedex_test_account` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'If true, FedEx account is a test account.';
ALTER TABLE ec_shippingrate ADD `is_quantity_based` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'If selected, this rate is for quantity based shipping.';
ALTER TABLE ec_menulevel1 MODIFY `name` VARCHAR( 1024 ) NOT NULL;
ALTER TABLE ec_menulevel2 MODIFY `name` VARCHAR( 1024 ) NOT NULL;
ALTER TABLE ec_menulevel3 MODIFY `name` VARCHAR( 1024 ) NOT NULL;
CREATE TABLE IF NOT EXISTS `ec_subscription` (
  `subscription_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'Unique ID for this table',
  `subscription_type` VARCHAR(125) COLLATE utf8_general_ci NOT NULL DEFAULT 'paypal' COMMENT
   'Type of subscription, e.g. paypal',
  `subscription_status` VARCHAR(125) COLLATE utf8_general_ci NOT NULL DEFAULT 'Active' COMMENT
   'Status of the subscription, Active or Canceled for example.',
  `title` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Title of the product purchased.',
  `model_number` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Model number of the product purchased.',
  `price` double(21,3) NOT NULL DEFAULT '0.000' COMMENT
   'Price of the product per period',
  `payment_length` int(11) NOT NULL DEFAULT '1' COMMENT
   'Length of time between payments, e.g. 3 months, represented by 3 in this field.',
  `payment_period` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Period of the payment, day, week, month of year, represented as D, W, M, or Y in this field.',
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT
   'Date that this payment was submitted to start the subscription.',
  `last_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The last date that this subscription was paid for.',
  `next_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'The next payment due date.',
  `email` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Email entered by the user while purchasing the subscription',
  `first_name` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'First name of the customer.',
  `last_name` VARCHAR(155) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Last name of the customer.',
  `user_country` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'US' COMMENT
   'Customer country of residence',
  `number_payments_completed` int(11) NOT NULL DEFAULT '1' COMMENT
   'The number of times this subscription has been paid for.',
  `paypal_txn_id` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Initial transaction ID from PayPal',
  `paypal_txn_type` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Initial transaction type from PayPal',
  `paypal_subscr_id` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Initial subscription ID from PayPal used to track the subscription when updated or canceled.',
  `paypal_username` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Username assigned to this subscription by PayPal.',
  `paypal_password` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT
   'Password assigned to this subscription by PayPal.',
  PRIMARY KEY (`subscription_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=1 CHARACTER SET'utf8' COLLATE 'utf8_general_ci';