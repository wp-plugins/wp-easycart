<?php 

/*

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Code and Design is copyrighted by Level Four Development, llc

//

//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     

//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         

//

//Only licensed users may use this code and storfront for live purposes. All other use is prohibited and may be 

//subject to copyright violation laws. If you have any questions regarding proper use of this code, please

//contact Level Four Development, llc and EasyCart prior to use.

//

//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

*/



//load our connection settings

require_once('../../../../../../wp-config.php');

//set our connection variables

$dbhost = DB_HOST;

$dbname = DB_NAME;

$dbuser = DB_USER;

$dbpass = DB_PASSWORD;	

//make a connection to our database

mysql_connect($dbhost, $dbuser, $dbpass);

mysql_select_db ($dbname);











$requestID = "-1";



if (isset($_GET['reqID'])) {



  $requestID = $_GET['reqID'];



}



$usersqlquery = sprintf("SELECT  ec_user.*, ec_role.admin_access FROM  ec_user  LEFT JOIN ec_role ON (ec_user.user_level = ec_role.role_label) WHERE  ec_user.password = '%s' AND  (ec_user.user_level = 'admin' OR ec_role.admin_access = 1)", mysql_real_escape_string($requestID));





$userresult = mysql_query($usersqlquery) or die(mysql_error());



$users = mysql_fetch_assoc($userresult);







if ($users || is_user_logged_in()) {
	
	//first, organize tables in order
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN product_id INTEGER(11) NOT NULL AUTO_INCREMENT FIRST");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN model_number VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER product_id");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN post_id INTEGER(11) NOT NULL DEFAULT 0  AFTER model_number");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN activate_in_store TINYINT(1) NOT NULL DEFAULT 0 AFTER post_id");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN title VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER activate_in_store");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN description TEXT COLLATE utf8_general_ci  AFTER title");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN specifications TEXT COLLATE utf8_general_ci  AFTER description");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN price  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER specifications");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN list_price  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER price");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN vat_rate  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER list_price");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN handling_price  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER vat_rate");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN stock_quantity INTEGER(7) NOT NULL DEFAULT 0 AFTER handling_price");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN weight FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER stock_quantity");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN width DOUBLE(15,3) NOT NULL DEFAULT '1.000' AFTER weight");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN height DOUBLE(15,3) NOT NULL DEFAULT '1.000' AFTER width");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN length DOUBLE(15,3) NOT NULL DEFAULT '1.000' AFTER height");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN seo_description TEXT COLLATE utf8_general_ci AFTER length");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN seo_keywords VARCHAR(255) COLLATE utf8_general_ci AFTER seo_description");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN use_specifications TINYINT(1) NOT NULL DEFAULT 0 AFTER seo_keywords");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN use_customer_reviews TINYINT(1) NOT NULL DEFAULT 0 AFTER use_specifications");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN manufacturer_id INTEGER(11) NOT NULL DEFAULT 0 AFTER use_customer_reviews");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN download_file_name VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER manufacturer_id");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN image1 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER download_file_name");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN image2 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image1");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN image3 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image2");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN image4 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image3");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN image5 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image4");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN option_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER image5");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN option_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_1");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN option_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_2");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN option_id_4 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_3");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN option_id_5 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_4");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN use_advanced_optionset TINYINT(1) NOT NULL DEFAULT 0 AFTER option_id_5");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel1_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER use_advanced_optionset");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel1_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel1_id_1");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel1_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel1_id_2");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel2_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel1_id_3");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel2_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel2_id_1");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel2_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel2_id_2");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel3_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel2_id_3");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel3_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel3_id_1");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN menulevel3_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel3_id_2");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN featured_product_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel3_id_3");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN featured_product_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER featured_product_id_1");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN featured_product_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER featured_product_id_2");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN featured_product_id_4 INTEGER(11) NOT NULL DEFAULT 0 AFTER featured_product_id_3");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_giftcard TINYINT(1) NOT NULL DEFAULT 0 AFTER featured_product_id_4");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_download TINYINT(1) NOT NULL DEFAULT 0 AFTER is_giftcard");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_donation TINYINT(1) NOT NULL DEFAULT 0 AFTER is_download");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_special TINYINT(1) NOT NULL DEFAULT 0 AFTER is_donation");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_taxable TINYINT(1) NOT NULL DEFAULT 1 AFTER is_special");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_subscription_item TINYINT(1) NOT NULL DEFAULT 0 AFTER is_taxable");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_preorder TINYINT(1) NOT NULL DEFAULT 0 AFTER is_subscription_item");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN added_to_db_date TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER is_preorder");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN show_on_startup TINYINT(1) NOT NULL DEFAULT 0 AFTER added_to_db_date");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN use_optionitem_images TINYINT(1) NOT NULL DEFAULT 0 AFTER show_on_startup");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN use_optionitem_quantity_tracking TINYINT(1) NOT NULL DEFAULT 0 AFTER use_optionitem_images");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN views INTEGER(11) NOT NULL DEFAULT 0 AFTER use_optionitem_quantity_tracking");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN last_viewed DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER views");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN show_stock_quantity TINYINT(1) NOT NULL DEFAULT 1 AFTER last_viewed");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN maximum_downloads_allowed INTEGER(11) NOT NULL DEFAULT 0 AFTER show_stock_quantity");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN download_timelimit_seconds INTEGER(11) NOT NULL DEFAULT 0 AFTER maximum_downloads_allowed");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN list_id VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER download_timelimit_seconds");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN edit_sequence VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER list_id");	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN subscription_bill_length INTEGER(11) NOT NULL DEFAULT '1' AFTER edit_sequence");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN subscription_bill_period VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'M' AFTER subscription_bill_length");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN trial_period_days INTEGER(11) NOT NULL DEFAULT '0' AFTER subscription_bill_period");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN stripe_plan_added TINYINT(1) NOT NULL DEFAULT '0' AFTER trial_period_days");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN subscription_plan_id INTEGER(11) NOT NULL DEFAULT '0' AFTER stripe_plan_added");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN allow_multiple_subscription_purchases TINYINT(1) NOT NULL DEFAULT '1' AFTER subscription_plan_id");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN membership_page VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER allow_multiple_subscription_purchases");
	
	//new
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN min_purchase_quantity INTEGER(11) NOT NULL DEFAULT '0' AFTER membership_page");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_amazon_download TINYINT(1) NOT NULL DEFAULT '0'  AFTER min_purchase_quantity");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN amazon_key VARCHAR(1024) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER is_amazon_download");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN catalog_mode TINYINT(1) NOT NULL DEFAULT '0' AFTER amazon_key");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN catalog_mode_phrase VARCHAR(1024) COLLATE utf8_general_ci  DEFAULT NULL  AFTER catalog_mode");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN inquiry_mode TINYINT(1) NOT NULL DEFAULT '0' AFTER catalog_mode_phrase");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN inquiry_url VARCHAR(1024) COLLATE utf8_general_ci DEFAULT NULL AFTER inquiry_mode");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN is_deconetwork TINYINT(1) NOT NULL DEFAULT '0'  AFTER inquiry_url");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN deconetwork_mode VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT 'designer' AFTER is_deconetwork");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN deconetwork_product_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_mode");
	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN deconetwork_size_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_product_id");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN deconetwork_color_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_size_id");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN deconetwork_design_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_color_id");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN short_description VARCHAR(2048) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_design_id");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN display_type INTEGER(11) NOT NULL DEFAULT '1' AFTER short_description");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN image_hover_type INTEGER(11) NOT NULL DEFAULT '3'  AFTER display_type");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN INTEGER(11) NOT NULL DEFAULT '0' AFTER image_hover_type");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN tag_bg_color VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER tag_type");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN tag_text_color VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER tag_bg_color");
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN tag_text VARCHAR(256) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER tag_text_color");
	
	mysql_query("ALTER TABLE ec_product MODIFY COLUMN image_effect_type VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'none' AFTER tag_text");

	//create 2 variables for use later on



	$header = "";



	$data = "";

	

	$sqlquery = sprintf("select * from ec_product order by ec_product.product_id asc");



	$result = mysql_query($sqlquery) or die(mysql_error());

	

	$count = mysql_num_fields($result);



	//now loop through and get database field names



	for ($i = 0; $i < $count; $i++){



		$header .= mysql_field_name($result, $i)."\t";



	}



	while($row = mysql_fetch_row($result)){



		$line = '';



		foreach($row as $value){



			if(!isset($value) || $value == ""){



				$value = "\t";



			}else{



				# important to escape any quotes to preserve them in the data.



				$value = str_replace('"', '""', $value);



				# needed to encapsulate data in quotes because some data might be multi line.



				# the good news is that numbers remain numbers in Excel even though quoted.



				$value = '"' . utf8_decode($value) . '"' . "\t";



			}



			$line .= $value;



		}



		$data .= trim($line)."\n";



	}



	# this line is needed because returns embedded in the data have "\r"



	# and this looks like a "box character" in Excel



	$data = str_replace("\r", "\n", $data);



	

	# Nice to let someone know that the search came up empty.



	# Otherwise only the column name headers will be output to Excel.



	if ($data == "") {



	$data = "\nno matching records found\n";



	}



	# This line will stream the file to the user rather than spray it across the screen



	//header("Content-Type: application/vnd.ms-excel; name='excel'");



	header("Content-type: application/vnd.ms-excel");



	header("Content-Transfer-Encoding: binary"); 



	header("Content-Disposition: attachment; filename=exported_products.xls");



	header("Pragma: no-cache");



	header("Expires: 0");



	echo $header."\n".$data; 



} else {



	echo "Not Authorized...";



}



?>