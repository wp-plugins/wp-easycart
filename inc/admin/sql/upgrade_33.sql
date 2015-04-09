;
ALTER TABLE ec_promocode ADD `expiration_date` DATETIME DEFAULT NULL COMMENT 'Gives the merchant the ability to set an expiration date.';
ALTER TABLE ec_product ADD `subscription_signup_fee` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'Charge a signup fee with a subscription item.';
ALTER TABLE ec_orderdetail ADD `subscription_signup_fee` FLOAT(15,3) NOT NULL DEFAULT '0.000' COMMENT 'Paid during signup with a subscription fee.';
ALTER TABLE ec_product ADD `subscription_unique_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Fixes duplicate ID problem when inserting subscriptions to stripe.';