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
ob_start( NULL, 4096 );
require_once( '../../../../../../wp-load.php' );
global $wpdb;

$requestID = "-1";
if( isset( $_GET['reqID'] ) )
	$requestID = $_GET['reqID'];

$user_sql = "SELECT  ec_user.*, ec_role.admin_access FROM ec_user LEFT JOIN ec_role ON (ec_user.user_level = ec_role.role_label) WHERE ec_user.password = %s AND  (ec_user.user_level = 'admin' OR ec_role.admin_access = 1)";
$users = $wpdb->get_results( $wpdb->prepare( $user_sql, $requestID ) );

if( !empty( $users ) ){
	
	//first, organize tables in order
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN product_id INTEGER(11) NOT NULL AUTO_INCREMENT FIRST");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN model_number VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER product_id");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN post_id INTEGER(11) NOT NULL DEFAULT 0  AFTER model_number");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN activate_in_store TINYINT(1) NOT NULL DEFAULT 0 AFTER post_id");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN title VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER activate_in_store");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN description TEXT COLLATE utf8_general_ci  AFTER title");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN specifications TEXT COLLATE utf8_general_ci  AFTER description");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN price  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER specifications");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN list_price  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER price");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN vat_rate  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER list_price");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN handling_price  FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER vat_rate");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN stock_quantity INTEGER(7) NOT NULL DEFAULT 0 AFTER handling_price");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN weight FLOAT(15,3) NOT NULL DEFAULT 0.000 AFTER stock_quantity");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN width DOUBLE(15,3) NOT NULL DEFAULT '1.000' AFTER weight");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN height DOUBLE(15,3) NOT NULL DEFAULT '1.000' AFTER width");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN length DOUBLE(15,3) NOT NULL DEFAULT '1.000' AFTER height");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN seo_description TEXT COLLATE utf8_general_ci AFTER length");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN seo_keywords VARCHAR(255) COLLATE utf8_general_ci AFTER seo_description");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN use_specifications TINYINT(1) NOT NULL DEFAULT 0 AFTER seo_keywords");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN use_customer_reviews TINYINT(1) NOT NULL DEFAULT 0 AFTER use_specifications");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN manufacturer_id INTEGER(11) NOT NULL DEFAULT 0 AFTER use_customer_reviews");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN download_file_name VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER manufacturer_id");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN image1 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER download_file_name");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN image2 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image1");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN image3 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image2");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN image4 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image3");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN image5 VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER image4");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN option_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER image5");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN option_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_1");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN option_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_2");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN option_id_4 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_3");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN option_id_5 INTEGER(11) NOT NULL DEFAULT 0 AFTER option_id_4");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN use_advanced_optionset TINYINT(1) NOT NULL DEFAULT 0 AFTER option_id_5");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel1_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER use_advanced_optionset");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel1_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel1_id_1");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel1_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel1_id_2");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel2_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel1_id_3");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel2_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel2_id_1");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel2_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel2_id_2");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel3_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel2_id_3");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel3_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel3_id_1");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN menulevel3_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel3_id_2");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN featured_product_id_1 INTEGER(11) NOT NULL DEFAULT 0 AFTER menulevel3_id_3");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN featured_product_id_2 INTEGER(11) NOT NULL DEFAULT 0 AFTER featured_product_id_1");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN featured_product_id_3 INTEGER(11) NOT NULL DEFAULT 0 AFTER featured_product_id_2");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN featured_product_id_4 INTEGER(11) NOT NULL DEFAULT 0 AFTER featured_product_id_3");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_giftcard TINYINT(1) NOT NULL DEFAULT 0 AFTER featured_product_id_4");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_download TINYINT(1) NOT NULL DEFAULT 0 AFTER is_giftcard");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_donation TINYINT(1) NOT NULL DEFAULT 0 AFTER is_download");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_special TINYINT(1) NOT NULL DEFAULT 0 AFTER is_donation");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_taxable TINYINT(1) NOT NULL DEFAULT 1 AFTER is_special");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_subscription_item TINYINT(1) NOT NULL DEFAULT 0 AFTER is_taxable");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_preorder TINYINT(1) NOT NULL DEFAULT 0 AFTER is_subscription_item");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN added_to_db_date TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER is_preorder");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN show_on_startup TINYINT(1) NOT NULL DEFAULT 0 AFTER added_to_db_date");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN use_optionitem_images TINYINT(1) NOT NULL DEFAULT 0 AFTER show_on_startup");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN use_optionitem_quantity_tracking TINYINT(1) NOT NULL DEFAULT 0 AFTER use_optionitem_images");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN views INTEGER(11) NOT NULL DEFAULT 0 AFTER use_optionitem_quantity_tracking");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN last_viewed DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER views");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN show_stock_quantity TINYINT(1) NOT NULL DEFAULT 1 AFTER last_viewed");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN maximum_downloads_allowed INTEGER(11) NOT NULL DEFAULT 0 AFTER show_stock_quantity");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN download_timelimit_seconds INTEGER(11) NOT NULL DEFAULT 0 AFTER maximum_downloads_allowed");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN list_id VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER download_timelimit_seconds");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN edit_sequence VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER list_id");	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN subscription_bill_length INTEGER(11) NOT NULL DEFAULT '1' AFTER edit_sequence");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN subscription_bill_period VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'M' AFTER subscription_bill_length");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN trial_period_days INTEGER(11) NOT NULL DEFAULT '0' AFTER subscription_bill_period");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN stripe_plan_added TINYINT(1) NOT NULL DEFAULT '0' AFTER trial_period_days");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN subscription_plan_id INTEGER(11) NOT NULL DEFAULT '0' AFTER stripe_plan_added");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN allow_multiple_subscription_purchases TINYINT(1) NOT NULL DEFAULT '1' AFTER subscription_plan_id");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN membership_page VARCHAR(512) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER allow_multiple_subscription_purchases");
	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN min_purchase_quantity INTEGER(11) NOT NULL DEFAULT '0' AFTER membership_page");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_amazon_download TINYINT(1) NOT NULL DEFAULT '0'  AFTER min_purchase_quantity");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN amazon_key VARCHAR(1024) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER is_amazon_download");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN catalog_mode TINYINT(1) NOT NULL DEFAULT '0' AFTER amazon_key");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN catalog_mode_phrase VARCHAR(1024) COLLATE utf8_general_ci  DEFAULT NULL  AFTER catalog_mode");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN inquiry_mode TINYINT(1) NOT NULL DEFAULT '0' AFTER catalog_mode_phrase");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN inquiry_url VARCHAR(1024) COLLATE utf8_general_ci DEFAULT NULL AFTER inquiry_mode");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN is_deconetwork TINYINT(1) NOT NULL DEFAULT '0'  AFTER inquiry_url");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN deconetwork_mode VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT 'designer' AFTER is_deconetwork");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN deconetwork_product_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_mode");
	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN deconetwork_size_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_product_id");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN deconetwork_color_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_size_id");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN deconetwork_design_id VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_color_id");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN short_description VARCHAR(2048) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER deconetwork_design_id");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN display_type INTEGER(11) NOT NULL DEFAULT '1' AFTER short_description");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN image_hover_type INTEGER(11) NOT NULL DEFAULT '3'  AFTER display_type");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN INTEGER(11) NOT NULL DEFAULT '0' AFTER image_hover_type");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN tag_bg_color VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER tag_type");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN tag_text_color VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER tag_bg_color");
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN tag_text VARCHAR(256) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER tag_text_color");
	
	$wpdb->query( "ALTER TABLE ec_product MODIFY COLUMN image_effect_type VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT 'none' AFTER tag_text");

	$header = "";
	$data = "";
	$sql = "SELECT * FROM ec_product ORDER BY ec_product.product_id ASC";
	$results = $wpdb->get_results( $sql, ARRAY_A );
	
	if( count( $results ) > 0 ){
		
		$keys = array_keys( $results[0] );
		
		foreach( $keys as $key ){
			$header .= $key."\t";
		}
	
		foreach( $results as $result ){
	
			$line = '';
			foreach( $result as $value ){
	
				if( !isset( $value ) || $value == "" ){
					$value = "\t";
	
				}else{
					$value = str_replace( '"', '""', $value);
					$value = '"' . utf8_decode($value) . '"' . "\t";
	
				}
	
				$line .= $value;
	
			}
	
			$data .= trim( $line )."\n";
	
		}
		
		$data = str_replace( "\r", "", $data );
	}else{
		if( $data == "" ){
			$data = "\nno matching records found\n";
		}
	}
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Transfer-Encoding: binary"); 
	header("Content-Disposition: attachment; filename=products.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo $header."\n".$data;
	
}else{

	echo "Not Authorized...";

}
?>