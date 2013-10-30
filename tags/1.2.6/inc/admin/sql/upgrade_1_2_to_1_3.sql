;
ALTER TABLE ec_orderdetail ADD `optionitem_price_1` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_2` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_3` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_4` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_orderdetail ADD `optionitem_price_5` FLOAT(15,3) NOT NULL DEFAULT '0.000';
ALTER TABLE ec_order ADD `order_customer_notes` BLOB;