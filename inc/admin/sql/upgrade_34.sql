;
ALTER TABLE ec_review ADD `user_id` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Relates the review to an ec_user if possible.';
ALTER TABLE ec_product ADD `max_purchase_quantity` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Optional maximum amount a user can purchase.';
ALTER TABLE ec_product ADD `handling_price_each` FLOAT(15,3) NOT NULL DEFAULT 0.000 COMMENT 'This price represents an extra handling charge added for each item to the shipping price.';
ALTER TABLE ec_product ADD `subscription_bill_duration` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'The duration of the subscription, 0 for infinate.';
ALTER TABLE ec_subscription ADD `payment_duration` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'The duration of the subscription, 0 means infinite.';