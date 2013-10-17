;
CREATE TABLE `ec_customfield` (
  `customfield_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `field_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`customfield_id`),
  UNIQUE KEY `customfield_id` (`customfield_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0
;
CREATE TABLE `ec_customfielddata` (
  `customfielddata_id` int(11) NOT NULL AUTO_INCREMENT,
  `customfield_id` int(11) DEFAULT NULL,
  `table_id` int(11) NOT NULL,
  `data` blob NOT NULL,
  PRIMARY KEY (`customfielddata_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0
;
ALTER TABLE ec_menulevel1 ADD seo_keywords varchar(512) NOT NULL DEFAULT '';
ALTER TABLE ec_menulevel1 ADD seo_description blob;
ALTER TABLE ec_menulevel1 ADD banner_image varchar(512) NOT NULL DEFAULT '';
ALTER TABLE ec_menulevel2 ADD seo_keywords varchar(512) NOT NULL DEFAULT '';
ALTER TABLE ec_menulevel2 ADD seo_description blob;
ALTER TABLE ec_menulevel2 ADD banner_image varchar(512) NOT NULL DEFAULT '';
ALTER TABLE ec_menulevel3 ADD seo_keywords varchar(512) NOT NULL DEFAULT '';
ALTER TABLE ec_menulevel3 ADD seo_description blob;
ALTER TABLE ec_menulevel3 ADD banner_image varchar(512) NOT NULL DEFAULT '';
ALTER TABLE ec_shippingrate MODIFY shipping_override_rate float(11,3) NULL DEFAULT NULL;