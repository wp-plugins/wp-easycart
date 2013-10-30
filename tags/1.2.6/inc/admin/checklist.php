<?php 

$validate = new ec_validation; 
$license = new ec_license;

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}
///////////////////////////////////////////////
// NEED TO USE IN UPDATING OF OPTIONS
///////////////////////////////////////////////
$is_trial = true;
$is_lite = false;
$is_full = false;

if( $license->is_lite_version( ) )
	$is_lite = true;
if( $license->is_registered( ) )
	$is_full = true;
if( $is_lite || $is_full )
	$is_trial = false;
	
///////////////////////////////////////
// PROCESS FORM ACTIONS
///////////////////////////////////////
if( isset( $_POST['ec_action'] ) ){
	// Basic Setup
	if( $_POST['ec_action'] == "add_store_shortcode" )
		ec_add_shortcode( $_POST['ec_option_storepage'], "[ec_store]" );
	
	else if( $_POST['ec_action'] == "new_storepage" )
		ec_new_page( $_POST['ec_storepage_name'], "[ec_store]" );
	
	else if( $_POST['ec_action'] == "link_store_shortcode" )
		ec_link_page( $_POST['ec_option_storepage'], "store" );
	
	else if( $_POST['ec_action'] == "add_cart_shortcode" )
		ec_add_shortcode( $_POST['ec_option_cartpage'], "[ec_cart]" );
	
	else if( $_POST['ec_action'] == "new_cartpage" )
		ec_new_page( $_POST['ec_cartpage_name'], "[ec_cart]" );
	
	else if( $_POST['ec_action'] == "link_cart_shortcode" )
		ec_link_page( $_POST['ec_option_cartpage'], "cart" );
	
	else if( $_POST['ec_action'] == "add_account_shortcode" )
		ec_add_shortcode( $_POST['ec_option_accountpage'], "[ec_account]" );
	
	else if( $_POST['ec_action'] == "new_accountpage" )
		ec_new_page( $_POST['ec_accountpage_name'], "[ec_account]" );
	
	else if( $_POST['ec_action'] == "link_account_shortcode" )
		ec_link_page( $_POST['ec_option_accountpage'], "account" );
		
	// Demo Data
	else if( $_POST['ec_action'] == "install_demo_data" )
		ec_install_demo_data( );
	
	// Store Settings
	else if( $_POST['ec_action'] == "update_option" ){
		$ok_to_update = false;
		if( $_POST['ec_option_name'] == "ec_option_checklist_credit_cart_complete" ){
			if( $is_full || get_option( 'ec_option_checklist_credit_card' ) != "yes" )
				$ok_to_update = true;
		
		}else if( $_POST['ec_option_name'] == "ec_option_checklist_third_party_complete" ){
			if( $is_lite || $is_full || get_option( 'ec_option_checklist_third_party' ) != "yes" )
				$ok_to_update = true;
		
		}else if( $_POST['ec_option_name'] == "ec_option_checklist_shipping_complete" ){
			if( $is_full || get_option( 'ec_option_checklist_shipping_choice' ) != "live_based" )
				$ok_to_update = true;
				
		}else{
			$ok_to_update = true;
		}
		
		if( $ok_to_update )
			ec_update_option( $_POST['ec_option_name'], $_POST[$_POST['ec_option_name']] );
		
	}else if( $_POST['ec_action'] == "update_terms" )
		ec_update_terms( $_POST['terms_method'], $_POST['ec_option_terms_link'], $_POST['ec_option_terms_link_page'] );
		
	else if( $_POST['ec_action'] == "update_privacy" )
		ec_update_privacy( $_POST['privacy_method'], $_POST['ec_option_privacy_link'], $_POST['ec_option_privacy_link_page'] );
		
	else if( $_POST['ec_action'] == "update_currency" ){
		ec_update_option( "ec_option_currency", $_POST['ec_option_currency'] );
		ec_update_option( "ec_option_currency_symbol_location", $_POST['ec_option_currency_symbol_location'] );
		ec_update_option( "ec_option_currency_negative_location", $_POST['ec_option_currency_negative_location'] );
		ec_update_option( "ec_option_currency_decimal_symbol", $_POST['ec_option_currency_decimal_symbol'] );
		ec_update_option( "ec_option_currency_decimal_places", $_POST['ec_option_currency_decimal_places'] );
		ec_update_option( "ec_option_currency_thousands_seperator", $_POST['ec_option_currency_thousands_seperator'] );
	}else if( $_POST['ec_action'] == "update_manual_billing" ){
		ec_update_option( "ec_option_use_direct_deposit", $_POST['ec_option_use_direct_deposit'] );
		ec_update_option( "ec_option_direct_deposit_message", $_POST['ec_option_direct_deposit_message'] );	
	}else if( $_POST['ec_action'] == "update_third_party" ){
		ec_update_option( 'ec_option_checklist_third_party', $_POST['ec_option_checklist_third_party'] );
		if( $is_lite || $is_full ){
			ec_update_option( 'ec_option_payment_third_party', $_POST['ec_option_payment_third_party'] );
			ec_update_option( 'ec_option_checklist_has_paymentexpress_thirdparty', $_POST['ec_option_checklist_has_paymentexpress_thirdparty'] );
			ec_update_option( 'ec_option_checklist_has_paypal', $_POST['ec_option_checklist_has_paypal'] );
			ec_update_option( 'ec_option_checklist_has_realex_thirdparty', $_POST['ec_option_checklist_has_realex_thirdparty'] );
			ec_update_option( 'ec_option_checklist_has_skrill', $_POST['ec_option_checklist_has_skrill'] );
			ec_update_option( 'ec_option_payment_express_thirdparty_username', $_POST['ec_option_payment_express_thirdparty_username'] );
			ec_update_option( 'ec_option_payment_express_thirdparty_key', $_POST['ec_option_payment_express_thirdparty_key'] );
			ec_update_option( 'ec_option_payment_express_thirdparty_currency', $_POST['ec_option_payment_express_thirdparty_currency'] );
			ec_update_option( 'ec_option_paypal_email', $_POST['ec_option_paypal_email'] );
			ec_update_option( 'ec_option_paypal_currency_code', $_POST['ec_option_paypal_currency_code'] );
			ec_update_option( 'ec_option_paypal_lc', $_POST['ec_option_paypal_lc'] );
			ec_update_option( 'ec_option_paypal_weight_unit', $_POST['ec_option_paypal_weight_unit'] );
			ec_update_option( 'ec_option_paypal_use_sandbox', $_POST['ec_option_paypal_use_sandbox'] );
			ec_update_option( 'ec_option_realex_thirdparty_merchant_id', $_POST['ec_option_realex_thirdparty_merchant_id'] );
			ec_update_option( 'ec_option_realex_thirdparty_secret', $_POST['ec_option_realex_thirdparty_secret'] );
			ec_update_option( 'ec_option_realex_thirdparty_currency', $_POST['ec_option_realex_thirdparty_currency'] );
			ec_update_option( 'ec_option_skrill_merchant_id', $_POST['ec_option_skrill_merchant_id'] );
			ec_update_option( 'ec_option_skrill_company_name', $_POST['ec_option_skrill_company_name'] );
			ec_update_option( 'ec_option_skrill_email', $_POST['ec_option_skrill_email'] );
			ec_update_option( 'ec_option_skrill_language', $_POST['ec_option_skrill_language'] );
			ec_update_option( 'ec_option_skrill_currency_code', $_POST['ec_option_skrill_currency_code'] );
		}
	}else if( $_POST['ec_action'] == "update_credit_card" ){
		// Main Settings
		ec_update_option( 'ec_option_checklist_credit_card', $_POST['ec_option_checklist_credit_card'] );
		
		if( $is_full ){
			ec_update_option( 'ec_option_checklist_credit_card_location', $_POST['ec_option_checklist_credit_card_location'] );
			ec_update_option( 'ec_option_payment_process_method', $_POST['ec_option_payment_process_method'] );
		
			//authorize.net
			ec_update_option( 'ec_option_authorize_login_id', $_POST['ec_option_authorize_login_id'] );
			ec_update_option( 'ec_option_authorize_trans_key', $_POST['ec_option_authorize_trans_key'] );
			ec_update_option( 'ec_option_authorize_test_mode', $_POST['ec_option_authorize_test_mode'] );
			ec_update_option( 'ec_option_authorize_developer_account', $_POST['ec_option_authorize_developer_account'] );
			ec_update_option( 'ec_option_authorize_currency_code', $_POST['ec_option_authorize_currency_code'] );
			//Braintree
			ec_update_option( 'ec_option_braintree_merchant_id', $_POST['ec_option_braintree_merchant_id'] );
			ec_update_option( 'ec_option_braintree_public_key', $_POST['ec_option_braintree_public_key'] );
			ec_update_option( 'ec_option_braintree_private_key', $_POST['ec_option_braintree_private_key'] );
			ec_update_option( 'ec_option_braintree_currency', $_POST['ec_option_braintree_currency'] );
			ec_update_option( 'ec_option_braintree_environment', $_POST['ec_option_braintree_environment'] );
			//goEmerchant
			ec_update_option( 'ec_option_goemerchant_gateway_id', $_POST['ec_option_goemerchant_gateway_id'] ); 
			ec_update_option( 'ec_option_goemerchant_processor_id', $_POST['ec_option_goemerchant_processor_id'] ); 
			ec_update_option( 'ec_option_goemerchant_trans_center_id', $_POST['ec_option_goemerchant_trans_center_id'] ); 
			//Paypal Payflow Pro
			ec_update_option( 'ec_option_paypal_pro_test_mode', $_POST['ec_option_paypal_pro_test_mode'] );
			ec_update_option( 'ec_option_paypal_pro_vendor', $_POST['ec_option_paypal_pro_vendor'] );
			ec_update_option( 'ec_option_paypal_pro_partner', $_POST['ec_option_paypal_pro_partner'] );
			ec_update_option( 'ec_option_paypal_pro_user', $_POST['ec_option_paypal_pro_user'] );
			ec_update_option( 'ec_option_paypal_pro_password', $_POST['ec_option_paypal_pro_password'] );
			ec_update_option( 'ec_option_paypal_pro_currency', $_POST['ec_option_paypal_pro_currency'] );
			//PayPal Payments Pro
			update_option( 'ec_option_paypal_payments_pro_test_mode', $_POST['ec_option_paypal_payments_pro_test_mode'] );
			update_option( 'ec_option_paypal_payments_pro_user', $_POST['ec_option_paypal_payments_pro_user'] );
			update_option( 'ec_option_paypal_payments_pro_password', $_POST['ec_option_paypal_payments_pro_password'] );
			update_option( 'ec_option_paypal_payments_pro_signature', $_POST['ec_option_paypal_payments_pro_signature'] );
			update_option( 'ec_option_paypal_payments_pro_currency', $_POST['ec_option_paypal_payments_pro_currency'] );
			//Realex
			ec_update_option( 'ec_option_realex_merchant_id', $_POST['ec_option_realex_merchant_id'] );
			ec_update_option( 'ec_option_realex_secret', $_POST['ec_option_realex_secret'] );
			ec_update_option( 'ec_option_realex_account', $_POST['ec_option_realex_account'] );
			ec_update_option( 'ec_option_realex_currency', $_POST['ec_option_realex_currency'] );
			//Sagepay
			ec_update_option( 'ec_option_sagepay_vendor', $_POST['ec_option_sagepay_vendor'] );
			ec_update_option( 'ec_option_sagepay_currency', $_POST['ec_option_sagepay_currency'] );
			ec_update_option( 'ec_option_sagepay_testmode', $_POST['ec_option_sagepay_testmode'] );
			//Firstdata
			ec_update_option( 'ec_option_firstdatae4_exact_id', $_POST['ec_option_firstdatae4_exact_id'] );
			ec_update_option( 'ec_option_firstdatae4_password', $_POST['ec_option_firstdatae4_password'] );
			ec_update_option( 'ec_option_firstdatae4_language', $_POST['ec_option_firstdatae4_language'] );
			ec_update_option( 'ec_option_firstdatae4_currency', $_POST['ec_option_firstdatae4_currency'] ); 
			ec_update_option( 'ec_option_firstdatae4_test_mode', $_POST['ec_option_firstdatae4_test_mode'] );           
			//PaymentExpress
			ec_update_option( 'ec_option_payment_express_username', $_POST['ec_option_payment_express_username'] );
			ec_update_option( 'ec_option_payment_express_password', $_POST['ec_option_payment_express_password'] );
			//Chronopay
			ec_update_option( 'ec_option_chronopay_currency', $_POST['ec_option_chronopay_currency'] );
			ec_update_option( 'ec_option_chronopay_product_id', $_POST['ec_option_chronopay_product_id'] );
			ec_update_option( 'ec_option_chronopay_shared_secret', $_POST['ec_option_chronopay_shared_secret'] );            
			//eWAY
			ec_update_option( 'ec_option_eway_customer_id', $_POST['ec_option_eway_customer_id'] );
			ec_update_option( 'ec_option_eway_test_mode', $_POST['ec_option_eway_test_mode'] );  
			ec_update_option( 'ec_option_eway_test_mode_success', $_POST['ec_option_eway_test_mode_success'] );          
			ec_update_option( 'ec_option_payment_express_currency', $_POST['ec_option_payment_express_currency'] );
			//Paypoint
			ec_update_option( 'ec_option_paypoint_merchant_id', $_POST['ec_option_paypoint_merchant_id'] );
			ec_update_option( 'ec_option_paypoint_vpn_password', $_POST['ec_option_paypoint_vpn_password'] );
			ec_update_option( 'ec_option_paypoint_test_mode', $_POST['ec_option_paypoint_test_mode'] );
			//Securepay
			ec_update_option( 'ec_option_securepay_merchant_id', $_POST['ec_option_securepay_merchant_id'] );
			ec_update_option( 'ec_option_securepay_password', $_POST['ec_option_securepay_password'] );
			ec_update_option( 'ec_option_securepay_currency', $_POST['ec_option_securepay_currency'] );
			ec_update_option( 'ec_option_securepay_test_mode', $_POST['ec_option_securepay_test_mode'] );
			
			//Credit Card Options
			$visa = 0;
			if( isset( $_POST['ec_option_use_visa'] ) )
				$visa = 1;
				
			$delta = 0;
			if( isset( $_POST['ec_option_use_delta'] ) )
				$delta = 1;
			
			$uke = 0;
			if( isset( $_POST['ec_option_use_uke'] ) )
				$uke = 1;
			
			$discover = 0;
			if( isset( $_POST['ec_option_use_discover'] ) )
				$discover = 1;
			
			$mastercard = 0;
			if( isset( $_POST['ec_option_use_mastercard'] ) )
				$mastercard = 1;
			
			$mcdebit = 0;
			if( isset( $_POST['ec_option_use_mcdebit'] ) )
				$mcdebit = 1;
			
			$amex = 0;
			if( isset( $_POST['ec_option_use_amex'] ) )
				$amex = 1;
			
			$jcb = 0;
			if( isset( $_POST['ec_option_use_jcb'] ) )
				$jcb = 1;
			
			$diners = 0;
			if( isset( $_POST['ec_option_use_diners'] ) )
				$diners = 1;
			
			$laser = 0;
			if( isset( $_POST['ec_option_use_laser'] ) )
				$laser = 1;
			
			$maestro = 0;
			if( isset( $_POST['ec_option_use_maestro'] ) )
				$maestro = 1;
			
			ec_update_option( 'ec_option_use_visa', $visa );
			ec_update_option( 'ec_option_use_delta', $delta );
			ec_update_option( 'ec_option_use_uke', $uke );
			ec_update_option( 'ec_option_use_discover', $discover );
			ec_update_option( 'ec_option_use_mastercard', $mastercard );
			ec_update_option( 'ec_option_use_mcdebit', $mcdebit );
			ec_update_option( 'ec_option_use_amex', $amex );
			ec_update_option( 'ec_option_use_jcb', $jcb );
			ec_update_option( 'ec_option_use_diners', $diners );
			ec_update_option( 'ec_option_use_laser', $laser );
			ec_update_option( 'ec_option_use_maestro', $maestro );
		}
	}else if( $_POST['ec_action'] == "update_ups" ){
		$db = new ec_db_admin( );
		$db->update_setting( "ups_access_license_number", $_POST['ups_access_license_number'] );
		$db->update_setting( "ups_user_id", $_POST['ups_user_id'] );
		$db->update_setting( "ups_password", $_POST['ups_password'] );
		$db->update_setting( "ups_ship_from_zip", $_POST['ups_ship_from_zip'] );
		$db->update_setting( "ups_shipper_number", $_POST['ups_shipper_number'] );
		$db->update_setting( "ups_country_code", $_POST['ups_country_code'] );
		$db->update_setting( "ups_weight_type", $_POST['ups_weight_type'] );
	}else if( $_POST['ec_action'] == "update_usps" ){
		$db = new ec_db_admin( );
		$db->update_setting( "usps_user_name", $_POST['usps_user_name'] );
		$db->update_setting( "usps_ship_from_zip", $_POST['usps_ship_from_zip'] );
	}else if( $_POST['ec_action'] == "update_fedex" ){
		$db = new ec_db_admin( );
		$db->update_setting( "fedex_key", $_POST['fedex_key'] );
		$db->update_setting( "fedex_account_number", $_POST['fedex_account_number'] );
		$db->update_setting( "fedex_meter_number", $_POST['fedex_meter_number'] );
		$db->update_setting( "fedex_password", $_POST['fedex_password'] );
		$db->update_setting( "fedex_ship_from_zip", $_POST['fedex_ship_from_zip'] );
		$db->update_setting( "fedex_weight_units", $_POST['fedex_weight_units'] );
		$db->update_setting( "fedex_country_code", $_POST['fedex_country_code'] );
	}else if( $_POST['ec_action'] == "update_auspost" ){
		$db = new ec_db_admin( );
		$db->update_setting( "auspost_api_key", $_POST['auspost_api_key'] );
		$db->update_setting( "auspost_ship_from_zip", $_POST['auspost_ship_from_zip'] );
	}else if( $_POST['ec_action'] == "update_dhl" ){
		$db = new ec_db_admin( );
		$db->update_setting( "dhl_site_id", $_POST['dhl_site_id'] );
		$db->update_setting( "dhl_password", $_POST['dhl_password'] );
		$db->update_setting( "dhl_ship_from_country", $_POST['dhl_ship_from_country'] );
		$db->update_setting( "dhl_ship_from_zip", $_POST['dhl_ship_from_zip'] );
		$db->update_setting( "dhl_weight_unit", $_POST['dhl_weight_unit'] );
		$db->update_setting( "dhl_test_mode", $_POST['dhl_test_mode'] );
	}
}

function ec_add_shortcode( $page_id, $shortcode ){
	$the_page = get_page( $page_id );
	$the_page->post_content = $shortcode . $the_page->post_content;
	wp_update_post( $the_page );
}

function ec_new_page( $page_name, $shortcode ){
	$post = array( 'post_content' 	=> $shortcode,
				   'post_title' 	=> $page_name,
				   'post_type'		=> "page",
				   'post_status'	=> "publish"
				 );
	wp_insert_post( $post );
}

function ec_link_page( $page_id, $page_type ){
	update_option( 'ec_option_' . $page_type . 'page', $page_id );
}

function ec_install_demo_data( ){
	$datapack_url = 'http://www.wpeasycart.com/sampledata/standard_demo';	
	$install_dir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
	copy( $datapack_url . "/standard_demo_assets.zip",  $install_dir . "standard_demo_assets.zip" );
	copy( $datapack_url . "/standard_demo_install.sql",  $install_dir . "standard_demo_install.sql" );
	
	$url = $install_dir . "standard_demo_install.sql";
	
	// Load and explode the sql file
	$f = fopen( $url, "r" );
	$sqlFile = fread($f, filesize($url));
	$sqlArray = explode(';', $sqlFile);
	
	//Process the sql file by statements
	foreach ($sqlArray as $stmt) {
	if (strlen($stmt)>3){
		$result = mysql_query($stmt);
		
		  if (mysql_error()){
			 $sqlErrorCode = mysql_errno();
			 $sqlErrorText = mysql_error();
			 $sqlStmt      = $stmt;
			 break;
		  }
	   }
	} 
	
	// Unzip Products
	$zip = new ZipArchive();
	$zip->open( $install_dir . "standard_demo_assets.zip" );
	
	// Now that the zip is open sucessfully, we should remove the products folder
	ec_recursive_remove_dir( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products" );
	
	// Now finish extracting
	$zip->extractTo( $install_dir );
	$zip->close();
	unlink( $install_dir . "standard_demo_assets.zip" );
	unlink( $install_dir . "standard_demo_install.sql" );
	
}

function ec_recursive_remove_dir( $dir ) { 
	if (is_dir($dir)) { 
		$objects = scandir($dir); 
		foreach ($objects as $object) { 
			if ($object != "." && $object != "..") { 
				if (filetype($dir."/".$object) == "dir") ec_recursive_remove_dir($dir."/".$object); 
				else unlink($dir."/".$object); 
			} 
		} 
		reset($objects); 
		rmdir($dir); 
	} 
}

function ec_update_option( $option_name, $option_val ){
	update_option( $option_name, $option_val );
}

function ec_update_terms( $terms_method, $terms_text, $terms_dropdown ){
	if( $terms_method == "text_box" )
		ec_update_option( "ec_option_terms_link", $terms_text );
	else if( $terms_method == "page_box" ){
		$terms_page = get_permalink( $terms_dropdown );
		ec_update_option( "ec_option_terms_link", $terms_page );
	}
}

function ec_update_privacy( $privacy_method, $privacy_text, $privacy_dropdown ){
	if( $privacy_method == "text_box" )
		ec_update_option( "ec_option_privacy_link", $privacy_text );
	else if( $privacy_method == "page_box" ){
		$privacy_page = get_permalink( $privacy_dropdown );
		ec_update_option( "ec_option_privacy_link", $privacy_page );
	}
}

function ec_show_state_select( $input_name, $selected ){
	echo "<select name=\"" . $input_name . "\" id=\"" . $input_name . "\">";
	echo "<option value=\"0\"";
	if( $selected == "0" )
		echo " selected=\"selected\"";
	echo ">Select One</option>";
	echo ">Select One</option>";
	$db = new ec_db_admin( );
	$states = $db->get_states( );
	foreach( $states as $state ){
		echo "<option value=\"" . $state->code_sta . "\"";
		if( $state->code_sta == $selected )
			echo " selected=\"selected\"";
		echo ">" . $state->name_sta . "</option>";
	}
	echo "</select>";
}

function ec_show_country_select( $input_name, $selected ){
	echo "<select name=\"" . $input_name . "\" id=\"" . $input_name . "\">";
	echo "<option value=\"0\"";
	if( $selected == "0" )
		echo " selected=\"selected\"";
	echo ">Select One</option>";
	$db = new ec_db_admin( );
	$countries = $db->get_countries( );
	foreach( $countries as $country ){
		echo "<option value=\"" . $country->iso2_cnt . "\"";
		if( $country->iso2_cnt == $selected )
			echo " selected=\"selected\"";
		echo ">" . $country->name_cnt . "</option>";
	}
	echo "</select>";
}

////////////////////////////////////////////
// UNIT TESTS
///////////////////////////////////////////

$setting = new ec_setting;

// 1. Can we find "[ec_store" in any post?
// 2. Can we find "[ec_account" in any post?
// 3. Can we find "[ec_cart" in any post?
$store_page_found = false;
$store_page_ids = array( );
$cart_page_found = false;
$cart_page_ids = array( );
$account_page_found = false;
$account_page_ids = array( );

$pages = get_pages( );
foreach( $pages as $page ){
	if( strstr( $page->post_content, '[ec_store' ) ){
		$store_page_ids[] = $page->ID;
		$store_page_found = true;
	}else if( strstr( $page->post_content, '[ec_cart' ) ){
		$cart_page_ids[] = $page->ID;
		$cart_page_found = true;
	}else if( strstr( $page->post_content, '[ec_account' ) ){
		$account_page_ids[] = $page->ID;
		$account_page_found = true;
	}
}

// 4. Does one of the pages with a shortcode appear in the values to connect the pages?
$selected_store_id = get_option( 'ec_option_storepage' );
$selected_cart_id = get_option( 'ec_option_cartpage' );
$selected_account_id = get_option( 'ec_option_accountpage' );
$store_is_match = false;
$cart_is_match = false;
$account_is_match = false;

if( in_array( $selected_store_id, $store_page_ids ) )
	$store_is_match = true;
if( in_array( $selected_cart_id, $cart_page_ids ) )
	$cart_is_match = true;
if( in_array( $selected_account_id, $account_page_ids ) )
	$account_is_match = true;


// 5. Did they install the demo data? Do they have non demo products?
$is_demo_data_installed = false;
$has_products = false;
$db = new ec_db_admin( );
$demo_list = $db->get_product_list( " WHERE product.product_id = 1 AND product.model_number = 'ropelogotee'", "", "", "" );
$product_list = $db->get_product_list( "", "", "", "" );
if( count( $demo_list ) == 1 )
	$is_demo_data_installed = true;
	
if( count( $product_list ) == 1 )
	$has_products = true;

// 6. Have they installed the admin plugin?
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$has_admin_plugin = false;
if( function_exists( "wp_easycart_load_admin" ) )
	$has_admin_plugin = true;

// 7. Can we even use the automatic demo installer?
$has_zip_class = false;
$can_write_zip = false;
$can_write_sql = false;
$can_write_folder = false;
$can_copy_file = false;
$can_remove_file = false;
$can_recursive_remove_dir = false;
$can_unzip_folder = false;

// Test zip
if( class_exists( "ZipArchive" ) )
	$has_zip_class = true;

// Test copy of zip
$zip_download_url = 'http://www.wpeasycart.com/sampledata/standard_demo/standard_clean_assets.zip';	
$sql_download_url = 'http://www.wpeasycart.com/sampledata/standard_demo/standard_demo_install.sql';	
$zip_copy_to_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/standard_clean_assets.zip';
$sql_copy_to_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/standard_demo_install.sql'; 

copy( $zip_download_url, $zip_copy_to_url );
copy( $sql_download_url, $sql_copy_to_url );

// Test writing
$ec_dir_location = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products-test-dir";
$ec_file_start_location = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/admin/images/apple.png";
$ec_file_dest_location = $ec_dir_location . "/test-product-image.png";
mkdir( $ec_dir_location );
if( is_dir( $ec_dir_location ) )
	$can_write_folder = true;

copy( $ec_file_start_location, $ec_file_dest_location );
if( file_exists( $ec_file_dest_location ) )
	$can_copy_file = true;
	
unlink( $ec_file_dest_location );
if( !file_exists( $ec_file_dest_location ) )
	$can_remove_file = true;
	
if( $has_zip_class ){
	$zip = new ZipArchive();
	$zip->open( $zip_copy_to_url );
	// Now finish extracting
	$zip->extractTo( $ec_dir_location );
	$zip->close();
	
	if( is_dir( $ec_dir_location . "/products" ) )
		$can_unzip_folder = true;
}

if( file_exists( $zip_copy_to_url ) ){
	$can_write_zip = true;
	unlink( $zip_copy_to_url );
}

if( file_exists( $sql_copy_to_url ) ){
	$can_write_sql = true;
	unlink( $sql_copy_to_url );
}

ec_recursive_remove_dir( $ec_dir_location );
if( !is_dir( $ec_dir_location ) )
	$can_recursive_remove_dir = true;

// 8. Did they change the email addresses in the basic setup?
$order_email_set = false;
$password_email_set = false;
$admin_email_set = false;

if( get_option( 'ec_option_order_from_email' ) != "youremail@url.com" && get_option( 'ec_option_order_from_email' ) != "" )
	$order_email_set = true;

if( get_option( 'ec_option_password_from_email' ) != "youremail@url.com" && get_option( 'ec_option_password_from_email' ) != "" )
	$password_email_set = true;

if( get_option( 'ec_option_bcc_email_addresses' ) != "youremail@url.com" && get_option( 'ec_option_bcc_email_addresses' ) != "" )
	$admin_email_set = true;

// 9. Did they link up the terms and conditions and/or privacy policy?
$terms_set = false;
$privacy_set = false;

if( get_option( 'ec_option_terms_link' ) != "http://yoursite.com/termsandconditions" && get_option( 'ec_option_terms_link' ) != "" )
	$terms_set = true;

if( get_option( 'ec_option_privacy_link' ) != "http://yoursite.com/privacypolicy" && get_option( 'ec_option_privacy_link' ) != "" )
	$privacy_set = true;

// 10. Check their live shipping info if available and such. Do a live test.
$ups_has_settings = false;
$ups_setup = false;
$ups_error_reason = 0;
$usps_has_settings = false;
$usps_setup = false;
$usps_error_reason = 0;
$fedex_has_settings = false;
$fedex_setup = false;
$fedex_error_reason = 0;

$auspost_has_settings = false;
$auspost_setup = false;
$auspost_error_reason = 0;

$dhl_has_settings = false;
$dhl_setup = false;
$dhl_error_reason = 0;

$setting_row = $db->get_settings( );
$settings = new ec_setting( $setting_row );

if( $setting_row->ups_access_license_number && $setting_row->ups_user_id && $setting_row->ups_password && $setting_row->ups_ship_from_zip && $setting_row->ups_shipper_number && $setting_row->ups_country_code && $setting_row->ups_weight_type ){
	$ups_has_settings = true;
	
	// Run test of the settings
	$ups_class = new ec_ups( $settings );
	$ups_response = $ups_class->get_rate_test( "01", $setting_row->ups_ship_from_zip, $setting_row->ups_country_code, "1" );
	$ups_xml = new SimpleXMLElement($ups_response);
	
	if( $ups_xml->Response->ResponseStatusCode == "1" ){
		$ups_setup = true;
	}else{
		$ups_error_reason = $ups_xml->Response->Error->ErrorCode;
	}
}

if( $setting_row->usps_user_name && $setting_row->usps_ship_from_zip ){
	$usps_has_settings = true;
	// Run test of the settings
	$usps_class = new ec_usps( $settings );
	$usps_response = $usps_class->get_rate_test( "PRIORITY", $setting_row->usps_ship_from_zip, "US", "1" );
	$usps_xml = new SimpleXMLElement( $usps_response );
	
	if( $usps_xml->Number )
		$usps_error_reason = 1;
	else if( $usps_xml->Package[0]->Error )
		$usps_error_reason = 2;
	else
		$usps_setup = true;
}

if( $setting_row->fedex_key && $setting_row->fedex_account_number && $setting_row->fedex_meter_number && $setting_row->fedex_password && $setting_row->fedex_ship_from_zip && $setting_row->fedex_weight_units && $setting_row->fedex_country_code ){
	$fedex_has_settings = true;
	// Run test of the settings
	
	if( $setting_row->fedex_weight_units != "LB" && $setting_row->fedex_weight_units != "KG" ){
		$fedex_error_reason = 2;
	}else{
		$fedex_class = new ec_fedex( $settings );
		$fedex_response = $fedex_class->get_rate_test( "FEDEX_GROUND", $setting_row->fedex_ship_from_zip, $setting_row->fedex_country_code, "1" );
		
		if( $fedex_response->HighestSeverity == 'FAILURE' || $fedex_response->HighestSeverity == 'ERROR' )
			if( isset( $fedex_response->Notifications->Code ) )
				$fedex_error_reason = $fedex_response->Notifications->Code;
			else
				$fedex_error_reason = $fedex_response->Notifications[0]->Code;
		else
			$fedex_setup = true;
	}
}

if( $setting_row->auspost_api_key && $setting_row->auspost_ship_from_zip ){
	$auspost_has_settings = true;
	
	// Run test of the settings
	$auspost_class = new ec_auspost( $settings );
	$auspost_response = $auspost_class->get_rate_test( "AUS_PARCEL_EXPRESS", $setting_row->auspost_ship_from_zip, "AU", "1" );
	
	if( !$auspost_response )
		$auspost_error_reason = "1";
	else
		$auspost_setup = true;
}

if( $setting_row->dhl_site_id && $setting_row->dhl_password && $setting_row->dhl_ship_from_country && $setting_row->dhl_ship_from_zip && $setting_row->dhl_weight_unit ){
	$dhl_has_settings = true;
	
	// Run test of the settings
	$dhl_class = new ec_dhl( $settings );
	$dhl_response = $dhl_class->get_rate_test( "N", $setting_row->dhl_ship_from_zip, $setting_row->dhl_ship_from_country, "1" );
	$dhl_xml = new SimpleXMLElement( $dhl_response );
	
	if( $dhl_xml && $dhl_xml->Response && $dhl_xml->Response->Status && $dhl_xml->Response->Status->ActionStatus && $dhl_xml->Response->Status->ActionStatus == "Error" ){
		$dhl_error_code = $dhl_xml->Response->Status->Condition->ConditionCode;
		$dhl_error_reason = $dhl_xml->Response->Status->Condition->ConditionData;
	}else if( $dhl_xml && $dhl_xml->Response && $dhl_xml->Response->Note && count( $dhl_xml->Response->Note ) > 0 && $dhl_xml->Response->Note[0]->Status && $dhl_xml->Response->Note[0]->Status->Condition && $dhl_xml->Response->Note[0]->Status->Condition->ConditionData ){
		$dhl_error_reason = $dhl_xml->Response->Note[0]->Status->Condition->ConditionData;
	}else
		$dhl_setup = true;
}

$correct_basic = 0;
$total_basic = 0;
$correct_demo_data = 0;
$total_demo_data = 0;
$correct_store_settings = 0;
$total_store_settings = 0;
$correct_payment = 0;
$total_payment = 0;
$correct_language = 0;
$total_language = 0;
$correct_admin = 0;
$total_admin = 0;

function ec_show_check( $check_text ){
	echo "<div class=\"ec_check_row\"><img src=\"" . plugins_url( "/images/check.gif", __FILE__ ) . "\" width=\"16\" height=\"16\" />" . $check_text . "</div>";	
}
function ec_show_failed( $fail_text ){
	echo "<div class=\"ec_failed_row\"><img src=\"" . plugins_url( "/images/Critical.png", __FILE__ ) . "\" width=\"16\" height=\"16\" /><b>" . $fail_text . "</b></div>";
}
?>
<script type="text/javascript">
	function install_alert() {
		var answer = confirm ("Are you sure you want to install demo data?  We will attempt to retrieve sample data and product images from the EasyCart servers and place this information into your system.")
		if (answer)
		return true;
		else
		return false;
	}
	function uninstall_alert() {
		var answer = confirm ("Are you sure you want to uninstall demo data?  Doing so will remove ALL of the products, options, and orders in EasyCart.  This will create a clean empty eCommerce system for you.")
		if (answer)
			return true;
		else
			return false;
	}
	function runchecklist() {
		window.open('<?php echo plugins_url('ec_checklist.php', __FILE__); ?>', '_blank', 'width=950, height=800');	
	}
</script>

<div class="ec_ajax_loader" id="ec_checklist_loader"><div class="ec_ajax_loader_holder"><img src="<?php echo plugins_url('images/ajax-loader.gif', __FILE__); ?>" /></div></div>

<div class="wrap">
<?php if( !$license->is_registered() && !$license->is_lite_version() ) { ?>
<div class="ribbon">You are running the WP EasyCart FREE version. To purchase the LITE or FULL version and unlock the full selling potential visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a> and purchase a license.</div>
<?php }else if( $license->is_lite_version() && $license->show_lite_message() ) { ?>
<div class="ribbon">You are running the WP EasyCart Lite version. To learn more about what you are missing with the Full version visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a>. To dismiss this banner <a href="?page=ec_install&dismiss_lite_banner=true">click here.</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />
<div class="ec_contentwrap">
    <h2>WP EasyCart Setup Wizard</h2>
    <p>This page is meant to be a tool to help you in the process of completely setting up your EasyCart system. Go through each section, answer the questions, and if prompted enter the appropriate information. If you do not understand the question or you feel it does not apply, tell the system you are done to check it off. If you have additional questions please feel free to contact our support team at <a href="www.wpeasycart.com/support-ticket/" target="_blank">www.wpeasycart.com</a>. As items are completed successfully they will be checked off and if possible they will be checked off automatically. Items are not necessarily required to be completed in the order they are displayed.</p>
    
    <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
    <tr valign="top">
        <td class="platformheading" colspan="2"><input type="button" value="Basic Setup" onclick="show_current_page( 'basic_setup' );" id="button_top_basic_setup" /> <input type="button" value="Demo Data" onclick="show_current_page( 'demo_data' );" id="button_top_demo_data" /> <input type="button" value="Store Settings" onclick="show_current_page( 'store_settings' );" id="button_top_store_settings" /> <input type="button" value="Payment, Tax, Shipping" onclick="show_current_page( 'payment' );" id="button_top_payment" /> <input type="button" value="Language, Design" onclick="show_current_page( 'language' );" id="button_top_language" /> <input type="button" value="Store Administration" onclick="show_current_page( 'admin' );" id="button_top_admin" /> <input type="button" value="Finished" onclick="show_current_page( 'complete' );" id="button_top_finished" /></td>
    </tr>
</table>
    
    <table width="100%" cellpadding="0" cellspacing="0" class="form-table" id="page_basic_setup">
    	<tr valign="top">
            <td class="platformheading">Basic Setup - <span id="percentage_basic">0</span>% Complete</td>
            <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="left" scope="row">
              <?php
			  	$total_basic++;
			  	// Check the store page
			  	if( $store_page_found ){
					$correct_basic++;
			  		ec_show_check( "You have successfully added a shortcode to a store page!" );
				}else{
					ec_show_failed( "No page was found with the account shortcode on it, we can quickly fix this though!" );
					?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Select a page: <?php wp_dropdown_pages( array( 'name' => 'ec_option_storepage', ) ); ?></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Add ShortCode Now!" /></div>
                    <input type="hidden" name="ec_action" value="add_store_shortcode" />
                </form>
                <form method="post" action="" />
                    <div class="ec_failed_row">OR Add to New Page: <input type="text" name="ec_storepage_name" value="Store" /></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Create the Store Page Now!" /></div>
                    <input type="hidden" name="ec_action" value="new_storepage" />
                </form>
                <div class="ec_failed_row">Or manually go to the page you would like to add the store shortcode (add the text [ec_store] to any page) and come back.</div>
              <?php }?>
              <hr />
              <?php 
			  	$total_basic++;
			  	// Check the cart page
			  	if( $cart_page_found ){
					$correct_basic++;
			  		ec_show_check( "You have successfully added a shortcode to a cart page!" );
				}else{
					ec_show_failed( "No page was found with the cart shortcode on it, we can quickly fix this though!" );
					?>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Select a page: <?php wp_dropdown_pages( array( 'name' => 'ec_option_cartpage', ) ); ?></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Add ShortCode Now!" /></div>
                    <input type="hidden" name="ec_action" value="add_cart_shortcode" />
                </form>
                <form method="post" action="" />
                    <div class="ec_failed_row">OR Add to New Page: <input type="text" name="ec_cartpage_name" value="Cart" /></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Create the Cart Page Now!" /></div>
                    <input type="hidden" name="ec_action" value="new_cartpage" />
                </form>
                <div class="ec_failed_row">Or manually go to the page you would like to add the cart shortcode (add the text [ec_cart] to any page) and come back.</div>
              <?php }?>
              <hr />
              <?php 
			  	$total_basic++;
			  	// Check the account page
			  	if( $account_page_found ){
					$correct_basic++;
			  		ec_show_check( "You have successfully added a shortcode to a account page!" );
				}else{
                	ec_show_failed( "No page was found with the account shortcode on it, we can quickly fix this though!" );
                	?>
                    
                <form method="post" action="" />
                    <div class="ec_failed_row">Select a page: <?php wp_dropdown_pages( array( 'name' => 'ec_option_accountpage', ) ); ?></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Add ShortCode Now!" /></div>
                    <input type="hidden" name="ec_action" value="add_account_shortcode" />
                </form>
                <form method="post" action="" />
                    <div class="ec_failed_row">OR Add to New Page: <input type="text" name="ec_accountpage_name" value="Account" /></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Create the Account Page Now!" /></div>
                    <input type="hidden" name="ec_action" value="new_accountpage" />
                </form>
                <div class="ec_failed_row">Or manually go to the page you would like to add the account shortcode (add the text [ec_account] to any page) and come back.</div>
              <?php }?>
              <hr />
              <?php 
			  	$total_basic++;
			  	// Check the linking of the store page
			  	if( $store_is_match ){
					$correct_basic++;
			  		ec_show_check( "You have correctly linked the shortcode to the EasyCart system!" );
				}else{
					if( count( $store_page_ids ) > 0 ){
                    	ec_show_failed( "You have not linked up the page with the [ec_store] shortcode to the EasyCart system." );
					?>
                    <form method="post" action="" />
                        <div class="ec_failed_row">Select the Store Page: <?php wp_dropdown_pages( array( 'name' => 'ec_option_storepage', ) ); ?><input type="submit" class="button-primary" value="Connect the Store Page Now!" /></div>
                        <input type="hidden" name="ec_action" value="link_store_shortcode" />
                    </form>
					<?php }else{
						ec_show_failed( "You have not added the [ec_store] shortcode to any page, please complete that step first." );
					}?>
                
              <?php }?>
              <hr />
              <?php 
			  	$total_basic++;
			  	// Check the linking of the cart page
			  	if( $cart_is_match ){
					$correct_basic++;
			  		ec_show_check( "You have correctly linked the shortcode to the EasyCart system!" );
				}else{
					if( count( $cart_page_ids ) > 0 ){
                    	ec_show_failed( "You have not linked up the page with the [ec_cart] shortcode to the EasyCart system." );
					?>
                    <form method="post" action="" />
                        <div class="ec_failed_row">Select the Cart Page: <?php wp_dropdown_pages( array( 'name' => 'ec_option_cartpage', ) ); ?><input type="submit" class="button-primary" value="Connect the Cart Page Now!" /></div>
                        <input type="hidden" name="ec_action" value="link_cart_shortcode" />
                    </form>
					<?php }else{
						ec_show_failed( "You have not added the [ec_cart] shortcode to any page, please complete that step first." );
					}?>
                
              <?php }?>
              <hr />
              <?php 
			  	$total_basic++;
			  	// Check the linking of the account page
			  	if( $account_is_match ){
					$correct_basic++;
			  		ec_show_check( "You have correctly linked the shortcode to the EasyCart system!" );
				}else{
					if( count( $account_page_ids ) > 0 ){
                    	ec_show_failed( "You have not linked up the page with the [ec_account] shortcode to the EasyCart system." );
					?>
                    <form method="post" action="" />
                        <div class="ec_failed_row">Select the Account Page: <?php wp_dropdown_pages( array( 'name' => 'ec_option_accountpage', ) ); ?><input type="submit" class="button-primary" value="Connect the Account Page Now!" /></div>
                        <input type="hidden" name="ec_action" value="link_account_shortcode" />
                    </form>
					<?php }else{
						ec_show_failed( "You have not added the [ec_account] shortcode to any page, please complete that step first." );
					}?>
                
              <?php }?>
           </td>
        </td>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" class="form-table" id="page_demo_data">
		<tr valign="top">
            <td class="platformheading">Demo Data - <span id="percentage_demo_data">0</span>% Complete</td>
            <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="left" scope="row">
              <?php 
			    $total_demo_data++;
			  	// Check if the demo data is installed
			  	if( $is_demo_data_installed ){
					$correct_demo_data++;
			  		ec_show_check( "You currently have the demo data installed!" );
				}else{
					if( $has_products ){
                    	ec_show_check( "You do not have demo data installed, but we see you have added products, good work!" );
					}else{
						ec_show_failed( "You have not added any products, install the demo data or add some products yourself." );
						if( !$has_zip_class ){
							ec_show_failed( "You do not have the necessary ZipArchieve class needed to unzip on the server via php, manual upload is necessary." );
						
						}else if( !$can_write_zip ){
							ec_show_failed( "Your server is not letting us copy the zip from the WP EasyCart server, manual upload is necessary." );
							
						}else if( !$can_write_sql ){
							ec_show_failed( "Your server is not letting us copy the sql demo script from the WP EasyCart server, manual upload is necessary." );
							
						}else if( !$can_recursive_remove_dir ){
							ec_show_failed( "Your server is not letting us remove a directory, which is needed to write the demo data products, manual upload is necessary." );
							
						}else if( !$can_unzip_folder ){
							ec_show_failed( "Your server is not letting us unzip data, so we cannot install the demo images, manual upload is necessary." );
							
						}else{
							
					?>
                            <form method="post" action="" />
                                <div class="ec_failed_row">Install Standard Demo Data: <input type="submit" class="button-primary" value="Add Standard Demo Data Now!" /></div>
                                <input type="hidden" name="ec_action" value="install_demo_data" />
                            </form>
						<?php
						}
						?>
                    	
						<?php if( $has_admin_plugin ){ ?>
                    		<div class="ec_failed_row"><a href="?page=ec_adminconsole">Want to add your own products instead?</a></div>
                    	<?php }else{?>
                    		<div class="ec_failed_row"><a href="?page=ec_adminconsole">Looks like you don't have the admin plugin installed, go here to get it and add your own products!</a></div>
                    	<?php }?>
                	<?php }?>
              <?php }?>
           </td>
        </tr>
    </table>
	<table width="100%" cellpadding="0" cellspacing="0" class="form-table" id="page_store_settings">
        <tr valign="top">
            <td class="platformheading">Important Store Settings - <span id="percentage_store_settings">0</span>% Complete</td>
            <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="left" scope="row">
           	<?php 
			$total_store_settings++;
			if( $order_email_set ){
				$correct_store_settings++;
				ec_show_check( "You have added an email address for customers to see on their order receipts." );
			}else{
				ec_show_failed( "You need to set the email address that your customers will see when they get an order receipt email." );
				?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Order From Email Address: <input type="text" name="ec_option_order_from_email" value="<?php echo get_option( 'ec_option_order_from_email' ); ?>" /> <input type="submit" class="button-primary" value="Update Email Address" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_order_from_email" />
                </form>
            <?php }?>
            <hr />
            <?php 
			$total_store_settings++;
			if( $password_email_set ){
				$correct_store_settings++;
				ec_show_check( "You have added an email address for customers to see on their password recovery emails." );
			}else{
				ec_show_failed( "You need to set the email address that your customers will see when they get an password recovery email." );
				?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Password Recovery From Email Address: <input type="text" name="ec_option_password_from_email" value="<?php echo get_option( 'ec_option_password_from_email' ); ?>" /> <input type="submit" class="button-primary" value="Update Email Address" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_password_from_email" />
                </form>
            <?php }?>
            <hr />
            <?php 
			$total_store_settings++;
			if( $admin_email_set ){
				$correct_store_settings++;
				ec_show_check( "You have added an email address that will receive a copy of every order email." );
			}else{
				ec_show_failed( "You need to set the email address that will receive copies of every order email." );
				?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Admin Email Address: <input type="text" name="ec_option_bcc_email_addresses" value="<?php echo get_option( 'ec_option_bcc_email_addresses' ); ?>" /> <input type="submit" class="button-primary" value="Update Email Address" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_bcc_email_addresses" />
                </form>
            <?php }?>
            <hr />
            <?php 
			$total_store_settings++;
			if( $terms_set ){
				$correct_store_settings++;
				ec_show_check( "You have linked up the terms and conditions of the site." );
			}else{
				ec_show_failed( "You need to link a page for your terms and conditions." );
				?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Terms and Conditions Link:</div>
                    <div class="ec_failed_row"><input type="radio" name="terms_method" value="text_box" checked="checked" /><input type="text" name="ec_option_terms_link" value="<?php echo get_option( 'ec_option_terms_link' ); ?>" /></div>
                    <div class="ec_failed_row"><input type="radio" name="terms_method" value="page_box" /><?php wp_dropdown_pages( array( 'name' => 'ec_option_terms_link_page', ) ); ?></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Link Up My Terms and Conditions!" /></div>
                    <input type="hidden" name="ec_action" value="update_terms" />
                </form>
            <?php }?>
            <hr />
            <?php 
			$total_store_settings++;
			if( $privacy_set ){
				$correct_store_settings++;
				ec_show_check( "You have linked up the privacy policy of the site." );
			}else{
				ec_show_failed( "You need to link a page for your privacy policy." );
				?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Privacy Policy Link:</div>
                    <div class="ec_failed_row"><input type="radio" name="privacy_method" value="text_box" checked="checked" /><input type="text" name="ec_option_privacy_link" value="<?php echo get_option( 'ec_option_privacy_link' ); ?>" /></div>
                    <div class="ec_failed_row"><input type="radio" name="privacy_method" value="page_box" /><?php wp_dropdown_pages( array( 'name' => 'ec_option_privacy_link_page', ) ); ?></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Link Up My Privacy Policy!" /></div>
                    <input type="hidden" name="ec_action" value="update_privacy" />
                </form>
            <?php }?>
            <hr />
            <?php 
			$total_store_settings++;
			if( get_option( 'ec_option_checklist_state' ) == "states_only" && get_option( 'ec_option_use_state_dropdown' ) ){ 
				$correct_store_settings++;
				ec_show_check( "You have selected to only allow your customers to choose from the states in your pre-defined list and are setup correctly for this." );
			}else if( get_option( 'ec_option_checklist_state' ) == "states_only" ){ 
				ec_show_failed( "You have selected to only show the states in your pre-defined state list, but you are not showing the state list. Click the button to fix this, or select a different option if you prefer." );
				?>
                <form method="post" action="" />
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Show State Drop Down to Customers!" /></div>
                    <input type="hidden" name="ec_option_use_state_dropdown" value="1" />
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_use_state_dropdown" />
                </form>
			<?php }else if( get_option( 'ec_option_checklist_state' ) == "all_states" && !get_option( 'ec_option_use_state_dropdown' ) ){
				$correct_store_settings++;
            	ec_show_check( "You have selected to show a text box for state entry, this frees your customers up to enter anything they want. This is perfect for businesses that sell to countries besides their own." );
			}else if( get_option( 'ec_option_checklist_state' ) == "all_states" ){ 
				ec_show_failed( "You have told us that you would like to show a text box for state input to customers, but you are showing a drop down menu at the moment." );
			?>
                <form method="post" action="" />
                    <div class="ec_failed_row"><input type="submit" class="button-primary" value="Show State Text Box to Customers!" /></div>
                    <input type="hidden" name="ec_option_use_state_dropdown" value="0" />
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_use_state_dropdown" />
                </form>
			<?php }else{
				ec_show_failed( "You have not answered this question yet, please tell us what you are looking for." );
			}?>
           		<form method="post" action="" />
                	<div class="ec_failed_row">Which do you want to show your customers for the state input field: <select name="ec_option_checklist_state"><option value="states_only"<?php if( get_option('ec_option_checklist_state') == "states_only" ){ echo " selected=\"selected\""; }?>>Drop Down Menu of my State List</option><option value="all_states"<?php if( get_option('ec_option_checklist_state') == "all_states" ){ echo " selected=\"selected\""; }?>>Free Text Box Input</option><input type="submit" class="button-primary" value="Save Your Selection" /></div>
                    <?php if( $has_admin_plugin ){ ?>
                    <div class="ec_failed_row">You can edit the list of states in our <a href="?page=ec_adminconsole">admin console available here</a>, then click "settings" on the top bar, then select "state list" from the left side.</div>
                    <?php }else{ ?>
                    <div class="ec_failed_row">You can edit the list of states in our admin console. Click "settings" on the top bar, then select "state list" from the left side.</div>
                    <?php }?>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_state" />
                </form>
            <hr />
            
            <?php
			$total_store_settings++;
			 
			$ec_currency = new ec_currency( );
			if( get_option( 'ec_option_checklist_currency' ) == "done" ){
				$correct_store_settings++;
				ec_show_check( "You have successfully setup your currency display on the store in the format " . $ec_currency->get_currency_display( 2999.50 ) . ". <a href=\"?page=ec_setup\">edit this option here</a>");
			}else{ 
				ec_show_failed( "You have not completed the setup of your currency display, please update the following values, once done come back here and select the done option." );
				?>
                <div class="ec_failed_row">Current Format: <?php echo $ec_currency->get_currency_display( 2999.50 ); ?></div>
                <form method="post" action="" />
                    <div class="ec_failed_row">Symbol: <input type="text" name="ec_option_currency" value="<?php echo get_option( 'ec_option_currency' ); ?>" /></div>
                    <div class="ec_failed_row">Symbol Location: <select name="ec_option_currency_symbol_location" id="ec_option_currency_symbol_location">
                    	<option value="1" <?php if (get_option('ec_option_currency_symbol_location') == 1) echo ' selected'; ?>>Left</option>
                    	<option value="0" <?php if (get_option('ec_option_currency_symbol_location') == 0) echo ' selected'; ?>>Right</option>
                    </select></div>
                    <div class="ec_failed_row">Negative Location: <select name="ec_option_currency_negative_location" id="ec_option_currency_negative_location">
                        <option value="1" <?php if (get_option('ec_option_currency_negative_location') == 1) echo ' selected'; ?>>Before Symbol</option>
                        <option value="0" <?php if (get_option('ec_option_currency_negative_location') == 0) echo ' selected'; ?>>After Symbol</option>
                    </select></div>
                    <div class="ec_failed_row">Decimal Symbol: <input name="ec_option_currency_decimal_symbol" type="text" value="<?php echo get_option('ec_option_currency_decimal_symbol'); ?>" /></div>
                    <div class="ec_failed_row">Decimal Length: <input name="ec_option_currency_decimal_places" type="text" value="<?php echo get_option('ec_option_currency_decimal_places'); ?>" /></div>
                    <div class="ec_failed_row">Grouping Symbol: <input name="ec_option_currency_thousands_seperator" type="text" value="<?php echo get_option('ec_option_currency_thousands_seperator'); ?>" /></div>
                    <div class="ec_failed_row"><input type="submit" class="button-primary"  value="Update My Currency Options!" /></div>
                    <input type="hidden" name="ec_action" value="update_currency" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy With This Currency Display: <select name="ec_option_checklist_currency"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_currency' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_currency" />
                </form>
            <?php } ?>
            <hr />
            <?php 
			$total_store_settings++;
			
			if( get_option( 'ec_option_checklist_default_payment' ) == "done" ){
				$correct_store_settings++;
				$payment_method = "";
				if( get_option( 'ec_option_default_payment_type' ) == "manual_bill" )
					$payment_method = "Manual Billing";
				else if( get_option( 'ec_option_default_payment_type' ) == "third_party" )
					$payment_method = "Third Party";
				else if( get_option( 'ec_option_default_payment_type' ) == "credit_card" )
					$payment_method = "Credit Card";
				
				ec_show_check( "You have successfully setup " . $payment_method . " as the default selected payment method on your site. <a href=\"?page=ec_setup\">edit this option here</a>" );
			}else{ 
				ec_show_failed( "You have not completed the setup of your default selected payment method, please update the following value and once done come back here and select the done option." );
				?>
                <form method="post" action="" />
                	<div class="ec_failed_row">Current Default Payment Method: <select name="ec_option_default_payment_type" id="ec_option_default_payment_type">
                    	<option value="manual_bill" <?php if (get_option('ec_option_default_payment_type') == 'manual_bill') echo ' selected'; ?>>Manual Billing</option>
                    	<option value="third_party" <?php if (get_option('ec_option_default_payment_type') == 'third_party') echo ' selected'; ?>>Third Party</option>
                    	<option value="credit_card" <?php if (get_option('ec_option_default_payment_type') == 'credit_card') echo ' selected'; ?>>Credit Card</option>
                	</select><input type="submit" class="button-primary"  value="Update My Default Payment Method!" /></div>
                	<input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_default_payment_type" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy With This Default Payment Method: <select name="ec_option_checklist_default_payment"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_default_payment' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_default_payment" />
                </form>
            
            <?php } ?>
            <hr />
            <?php
			$total_store_settings++;
			
			if( get_option( 'ec_option_checklist_guest' ) == "done" ){
				$correct_store_settings++;
				ec_show_check( "You have successfully setup the guest checkout option on your site. <a href=\"?page=ec_setup\">edit this option here</a>" );
			}else{ 
				ec_show_failed( "You have not completed the setup of the guest checkout option, please update the following value and once done come back here and select the done option." );
				?>
                <form method="post" action="" />
                	<div class="ec_failed_row">Do you want guest checkout: <select name="ec_option_allow_guest" style="width:100px;"><option value="0"<?php if( get_option('ec_option_allow_guest') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_allow_guest') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><input type="submit" class="button-primary"  value="Update Guest Checkout" /></div>
                	<input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_allow_guest" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy With This Option: <select name="ec_option_checklist_guest"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_guest' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_guest" />
                </form>
            
            <?php } ?>
            <hr />
            <?php 
			$total_store_settings++;
			
			if( get_option( 'ec_option_checklist_shipping_enabled' ) == "done" ){
				$correct_store_settings++;
				ec_show_check( "You have successfully setup the shipping option on your site. <a href=\"?page=ec_setup\">edit this option here</a>" );
			}else{ 
				ec_show_failed( "You have not completed the setup of the shipping option, please update the following value and once done come back here and select the done option." );
				?>
                <form method="post" action="" />
                	<div class="ec_failed_row">Do you want to allow shipping: <select name="ec_option_use_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><input type="submit" class="button-primary"  value="Update Shipping Option" /></div>
                	<input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_use_shipping" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy With This Option: <select name="ec_option_checklist_shipping_enabled"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_shipping_enabled' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_shipping_enabled" />
                </form>
            
            <?php } ?>
            <hr />
            <?php 
			$total_store_settings++;
			
			if( get_option( 'ec_option_checklist_checkout_notes' ) == "done" ){
				$correct_store_settings++;
				ec_show_check( "You have successfully setup the order notes option on your site. <a href=\"?page=ec_setup\">edit this option here</a>" );
			}else{ 
				ec_show_failed( "You have not completed the setup of the custom order notes option, please update the following value and once done come back here and select the done option." );
				?>
                <form method="post" action="" />
                	<div class="ec_failed_row">Do you want to let customers type custom notes on checkout: <select name="ec_option_user_order_notes" style="width:100px;"><option value="0"<?php if( get_option('ec_option_user_order_notes') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_user_order_notes') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><input type="submit" class="button-primary"  value="Update Checkout Cart Notes Option" /></div>
                	<input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_user_order_notes" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy With This Option: <select name="ec_option_checklist_checkout_notes"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_checkout_notes' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_checkout_notes" />
                </form>
            
            <?php } ?>
            <hr />
            <?php 
			$total_store_settings++;
			
			if( get_option( 'ec_option_checklist_billing_registration' ) == "done" ){
				$correct_store_settings++;
				ec_show_check( "You have successfully setup the billing on registration option on your site. <a href=\"?page=ec_setup\">edit this option here</a>" );
			}else{ 
				ec_show_failed( "You have not completed the setup of the billing on registration option, please update the following value and once done come back here and select the done option." );
				?>
                <form method="post" action="" />
                	<div class="ec_failed_row">Do you want to require a billing address on user registration: <select name="ec_option_require_account_address" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_account_address') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_account_address') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><input type="submit" class="button-primary"  value="Update Billing Registration Option" /></div>
                	<input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_require_account_address" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy With This Option: <select name="ec_option_checklist_billing_registration"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_billing_registration' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_billing_registration" />
                </form>
            
            <?php } ?>
            <hr />
            <?php 
			$total_store_settings++;
			
			if( get_option( 'ec_option_checklist_google_analytics' ) == "done" || ( get_option( 'ec_option_googleanalyticsid' ) != "UA-XXXXXXX-X" && get_option( 'ec_option_googleanalyticsid' ) != "" ) ){
				$correct_store_settings++;
				if( get_option( 'ec_option_checklist_google_analytics' ) == "done" )
					ec_show_check( "You have selected to not use Google Analytics on your store. <a href=\"?page=ec_setup\">edit this option here</a>" ); 
				else
					ec_show_check( "You have successfully setup Google Analytics on your store. <a href=\"?page=ec_setup\">edit this option here</a>" );
			}else{ 
				ec_show_failed( "You have not added a Google Analytics ID. This option allows you to view your eCommerce conversion data through Google Analytics. If you do not want to use this item, just update the answer to tell us you are not intestested." );
				?>
                <form method="post" action="" />
                	<div class="ec_failed_row">Your Google Analytics ID: <input type="text" value="<?php echo get_option( 'ec_option_googleanalyticsid' ); ?>" name="ec_option_googleanalyticsid" /><input type="submit" class="button-primary"  value="Update Google ID" /></div>
                	<input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_googleanalyticsid" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Do you want to setup Google Analytics: <select name="ec_option_checklist_google_analytics"><option value="yes">Yes I Do</option><option value="done"<?php if( get_option( 'ec_option_checklist_google_analytics' ) == "done" ){ echo " selected=\"selected\""; }?> >No Thank You</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_google_analytics" />
                </form>
            
            <?php } ?>
           </td>
        </tr>
    </table>
	<table width="100%" cellpadding="0" cellspacing="0" class="form-table" id="page_payment">
        <tr valign="top">
            <td class="platformheading">Payment, Taxes, and Shipping - <span id="percentage_payment">0</span>% Complete</td>
            <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="left" scope="row">
            <?php 
			$total_payment++;
			if( get_option( 'ec_option_checklist_manual_billing' ) == "done" ){
				$correct_payment++;
				if( get_option( 'ec_option_use_direct_deposit' ) )
					ec_show_check( "You have selected to use manual billing on your store. <a href=\"?page=ec_payment\">edit this option here</a>" );
				else
					ec_show_check( "You have selected to not use manual billing on your store. <a href=\"?page=ec_payment\">edit this option here</a>" ); 
			}else{ 
				ec_show_failed( "Please tell us if you would like to use manual billing" );
				?>
                <form method="post" action="" />
                	<div class="ec_failed_row">Use Manual Billing: <select name="ec_option_use_direct_deposit" id="ec_option_use_direct_deposit" onchange="toggle_direct_deposit();">
                    	<option value="1" <?php if (get_option('ec_option_use_direct_deposit') == 1) echo ' selected'; ?>>Yes</option>
                    	<option value="0" <?php if (get_option('ec_option_use_direct_deposit') == 0) echo ' selected'; ?>>No</option>
                  	</select> </div>
                    <div id="ec_direct_deposit_message">
                	<div class="ec_failed_row">If Using Manual Billing, What Message to Customer: </div>
                    <div class="ec_failed_row"><textarea name="ec_option_direct_deposit_message" id="ec_option_direct_deposit_message" cols="85" rows="12" style="width:350px;"><?php echo get_option('ec_option_direct_deposit_message'); ?></textarea></div>
                    </div>
                	<div class="ec_failed_row"><input type="submit" class="button-primary"  value="Update Manual Billing Options" /></div>
                    <input type="hidden" name="ec_action" value="update_manual_billing" />
                </form>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Finished with This Option: <select name="ec_option_checklist_manual_billing"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_manual_billing' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_manual_billing" />
            	</form>
                <script>
                function toggle_direct_deposit( ){
					var direct_val = document.getElementById('ec_option_use_direct_deposit').value;
					if( direct_val == "1" ){
						jQuery( '#ec_direct_deposit_message' ).fadeIn( 250 );
					}else{
						jQuery( '#ec_direct_deposit_message' ).fadeOut( 250 );
					}
				}
				toggle_direct_deposit( );
                </script>
            <?php } ?>
            <hr />
            <?php 
			$total_payment++;
			if( get_option( 'ec_option_checklist_third_party_complete' ) == "done" ){
				$correct_payment++;
				$third_party = 0;
				if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
					$third_party = "PayPal Payments Standard (free)";
				else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
					$third_party = "Skrill";
				
				if( get_option( 'ec_option_payment_third_party' ) )
					ec_show_check( "You have selected to use " . $third_party . " for your third party payment processing on your store. <a href=\"?page=ec_payment\">edit this option here</a>" );
				else
					ec_show_check( "You have selected to not use any third party payment processing on your store. <a href=\"?page=ec_payment\">edit this option here</a>" ); 
			}else{ 
				ec_show_failed( "Please tell us if you would like to use a third party payment processor (customer will leave the site to complete payment)." );
				?>
                <form method="post" action="" />
            	<div class="ec_failed_row">Do you want to use a Third Party Payment Processor: <select name="ec_option_checklist_third_party" id="ec_option_checklist_third_party" onchange="update_third_party_form();"><option value="0">Select One</option><option value="yes"<?php if( get_option( 'ec_option_checklist_third_party' ) == "yes" ){echo " selected=\"selected\""; } ?>>Yes</option><option value="done"<?php if( get_option( 'ec_option_checklist_third_party' ) == "done" ){echo " selected=\"selected\""; } ?>>No</option></select></div>
                <?php if( !$is_lite && !$is_full ){ ?>
                <div class="ec_failed_row" id="no_third_party_license">Please purchase a license for the <a href="http://www.wpeasycart.com/products/?model_number=ec110" target="_blank">Lite Version for $40</a> or <a href="http://www.wpeasycart.com/products/?model_number=ec100" target="_blank">Full Version for $80</a> to continue.</div>
                
				<?php }else{?>
                <div class="ec_failed_row" id="which_third_party">Which Third Party do you want to use: <select name="ec_option_payment_third_party" id="ec_option_payment_third_party" onchange="update_third_party_form();">
                	<option value="0" <?php if (get_option('ec_option_payment_third_party') == 0) echo ' selected'; ?>>Select One</option>
                	<option value="paymentexpress_thirdparty" <?php if (get_option('ec_option_payment_third_party') == "paymentexpress_thirdparty") echo ' selected'; ?>>Payment Express PxPay 2.0</option>
                	<option value="paypal" <?php if (get_option('ec_option_payment_third_party') == "paypal") echo ' selected'; ?>>PayPal</option>
                	<option value="realex_thirdparty" <?php if (get_option('ec_option_payment_third_party') == "realex_thirdparty") echo ' selected'; ?>>Realex</option>
                	<option value="skrill" <?php if (get_option('ec_option_payment_third_party') == "skrill") echo ' selected'; ?>>Skrill</option>
              	</select></div>
                <div class="ec_failed_row" id="has_paymentexpress_thirdparty">Do you have a Payment Express account: <select name="ec_option_checklist_has_paymentexpress_thirdparty" id="ec_option_checklist_has_paymentexpress_thirdparty" onchange="update_third_party_form();"><option value="0"<?php if( get_option( 'ec_option_checklist_has_paymentexpress_thirdparty' ) == "" || get_option( 'ec_option_checklist_has_paymentexpress_thirdparty' ) == "0" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="yes"<?php if( get_option( 'ec_option_checklist_has_paymentexpress_thirdparty' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes</option><option value="no"<?php if( get_option( 'ec_option_checklist_has_paymentexpress_thirdparty' ) == "no" ){ echo " selected=\"selected\""; }?>>No</option></select></div>
                <div class="ec_failed_row" id="has_paypal">Do you have a PayPal account: <select name="ec_option_checklist_has_paypal" id="ec_option_checklist_has_paypal" onchange="update_third_party_form();"><option value="0"<?php if( get_option( 'ec_option_checklist_has_paypal' ) == "" || get_option( 'ec_option_checklist_has_paypal' ) == "0" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="yes"<?php if( get_option( 'ec_option_checklist_has_paypal' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes</option><option value="no"<?php if( get_option( 'ec_option_checklist_has_paypal' ) == "no" ){ echo " selected=\"selected\""; }?>>No</option></select></div>
                <div class="ec_failed_row" id="has_realex_thirdparty">Do you have a Realex account: <select name="ec_option_checklist_has_realex_thirdparty" id="ec_option_checklist_has_realex_thirdparty" onchange="update_third_party_form();"><option value="0"<?php if( get_option( 'ec_option_checklist_has_realex_thirdparty' ) == "" || get_option( 'ec_option_checklist_has_realex_thirdparty' ) == "0" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="yes"<?php if( get_option( 'ec_option_checklist_has_realex_thirdparty' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes</option><option value="no"<?php if( get_option( 'ec_option_checklist_has_realex_thirdparty' ) == "no" ){ echo " selected=\"selected\""; }?>>No</option></select></div>
                <div class="ec_failed_row" id="has_skrill">Do you have a Skrill account: <select name="ec_option_checklist_has_skrill" id="ec_option_checklist_has_skrill" onchange="update_third_party_form();"><option value="0"<?php if( get_option( 'ec_option_checklist_has_skrill' ) == "" || get_option( 'ec_option_checklist_has_skrill' ) == "0" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="yes"<?php if( get_option( 'ec_option_checklist_has_skrill' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes</option><option value="no"<?php if( get_option( 'ec_option_checklist_has_skrill' ) == "no" ){ echo " selected=\"selected\""; }?>>No</option></select></div>
                <div class="ec_failed_row" id="get_paymentexpress_thirdparty">Get Payment Express Here: <a href="https://sec.paymentexpress.com/pxmi/apply" target="_blank">Register for Payment Express!</a></div>
                <div class="ec_failed_row" id="get_paypal">Get Paypal Here: <a href="https://www.paypal.com/us/home?BN=LevelFourDevelopmentLLC_Cart" target="_blank">Register for PayPal for Free!</a></div>
                <div class="ec_failed_row" id="get_realex_thirdparty">Get Realex Here: <a href="http://www.realexpayments.com/business-offering" target="_blank">Register for Realex!</a></div>
                <div class="ec_failed_row" id="get_skrill">Get Skrill Here: <a href="http://www.moneybookers.com/app/?rid=39701782" target="_blank">Register for Skrill for Free!</a></div>
                
                <table>
                   <tr valign="top" class="form-table" id="paymentexpress_thirdparty">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Payment Express User Name:</td>
                          <td width="74%"><input name="ec_option_payment_express_thirdparty_username"  id="ec_option_payment_express_thirdparty_username" type="text" value="<?php echo get_option('ec_option_payment_express_thirdparty_username'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Payment Express Key:</td>
                          <td><input name="ec_option_payment_express_thirdparty_key"  id="ec_option_payment_express_thirdparty_key" type="text" value="<?php echo get_option('ec_option_payment_express_thirdparty_key'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Payment Express Currency:</td>
                          <td>
                          <select name="ec_option_payment_express_thirdparty_currency" id="ec_option_payment_express_thirdparty_currency">
                            <option value="USD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                            <option value="CAD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                            <option value="CHF" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                            <option value="DKK" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                            <option value="EUR" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                            <option value="FRF" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "FRF") echo ' selected'; ?>>French Franc</option>
                            <option value="GBP" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "GBP") echo ' selected'; ?>>United Kingdom Pound</option>
                            <option value="HKD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                            <option value="JPY" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                            <option value="NZD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                            <option value="SGD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                            <option value="THB" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                            <option value="ZAR" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "ZAR") echo ' selected'; ?>>Rand</option>
                            <option value="AUD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                            <option value="WST" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                            <option value="VUV" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                            <option value="TOP" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "TOP") echo ' selected'; ?>>Tongan Pa'anga</option>
                            <option value="SBD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                            <option value="PGK" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "PGK") echo ' selected'; ?>>Papua New Guinea Kina</option>
                            <option value="MYR" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                            <option value="KWD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                            <option value="FJD" <?php if (get_option('ec_option_payment_express_thirdparty_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                            
                          </select>
                          </td>
                        </tr>
                      </table></td>
                    </tr>
                   
                   <tr valign="top" id="paypal">
                      <td colspan="2" class="itemheading" scope="row">
                      	<table width="90%" border="0" cellspacing="0" cellpadding="0">
                        	<tr valign="top">
                          		<td width="24%" class="itemheading" scope="row">PayPal Email:</td>
                          		<td width="76%"><input name="ec_option_paypal_email" id="ec_option_paypal_email" type="text" value="<?php echo get_option('ec_option_paypal_email'); ?>" style="width:250px;" />
                            	<a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                                <span class="ec_custom ec_help">
                                    <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                                    <em>Email Address</em>
                                    The email address associated with your PayPal account.
                                </span>
                            	</a>
                          		</td>
                        	</tr>
                        	<tr valign="top">
                          		<td class="itemheading" scope="row">PayPal Currency Code:</td>
                          		<td><select name="ec_option_paypal_currency_code" id="ec_option_paypal_currency_code">
                                    <option value="USD" <?php if (get_option('ec_option_paypal_currency_code') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
                                    <option value="AUD" <?php if (get_option('ec_option_paypal_currency_code') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
                                    <option value="BRL" <?php if (get_option('ec_option_paypal_currency_code') == 'BRL') echo ' selected'; ?>>Brazilian Real</option>
                                    <option value="CAD" <?php if (get_option('ec_option_paypal_currency_code') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
                                    <option value="CZK" <?php if (get_option('ec_option_paypal_currency_code') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
                                    <option value="CZK" <?php if (get_option('ec_option_paypal_currency_code') == 'CZK') echo ' selected'; ?>>Danish Krone</option>
                                    <option value="EUR" <?php if (get_option('ec_option_paypal_currency_code') == 'EUR') echo ' selected'; ?>>Euro</option>
                                    <option value="HKD" <?php if (get_option('ec_option_paypal_currency_code') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
                                    <option value="HUF" <?php if (get_option('ec_option_paypal_currency_code') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
                                    <option value="ILS" <?php if (get_option('ec_option_paypal_currency_code') == 'ILS') echo ' selected'; ?>>Israeli New Sheqel</option>
                                    <option value="JPY" <?php if (get_option('ec_option_paypal_currency_code') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
                                    <option value="MYR" <?php if (get_option('ec_option_paypal_currency_code') == 'MYR') echo ' selected'; ?>>Malaysian Ringgit</option>
                                    <option value="MXN" <?php if (get_option('ec_option_paypal_currency_code') == 'MXN') echo ' selected'; ?>>Mexican Peso</option>
                                    <option value="NOK" <?php if (get_option('ec_option_paypal_currency_code') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
                                    <option value="NZD" <?php if (get_option('ec_option_paypal_currency_code') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
                                    <option value="PHP" <?php if (get_option('ec_option_paypal_currency_code') == 'PHP') echo ' selected'; ?>>Philippine Peso</option>
                                    <option value="PLN" <?php if (get_option('ec_option_paypal_currency_code') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
                                    <option value="GBP" <?php if (get_option('ec_option_paypal_currency_code') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
                                    <option value="SGD" <?php if (get_option('ec_option_paypal_currency_code') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
                                    <option value="SEK" <?php if (get_option('ec_option_paypal_currency_code') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
                                    <option value="CHF" <?php if (get_option('ec_option_paypal_currency_code') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
                                    <option value="TWD" <?php if (get_option('ec_option_paypal_currency_code') == 'TWD') echo ' selected'; ?>>Taiwan New Dollar</option>
                                    <option value="THB" <?php if (get_option('ec_option_paypal_currency_code') == 'THB') echo ' selected'; ?>>Thai Baht</option>
                                    <option value="TRY" <?php if (get_option('ec_option_paypal_currency_code') == 'TRY') echo ' selected'; ?>>Turkish Lira</option>
                                  </select>
                                  <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                                        <span class="ec_custom ec_help">
                                            <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                                            <em>Currency Code</em>
                                            The currency code used to process a transaction.
                                        </span>
                                    </a>
                          		</td>
                        	</tr>
                        	<tr valign="top">
                          		<td class="itemheading" scope="row">PayPal Language Code:</td>
                          		<td>
                                  <select name="ec_option_paypal_lc" id="ec_option_paypal_lc">
                                    <option value="US" <?php if (get_option('ec_option_paypal_lc') == 'US') echo ' selected'; ?>>United States</option>
                                    <option value="AU" <?php if (get_option('ec_option_paypal_lc') == 'AU') echo ' selected'; ?>>Australia</option>
                                    <option value="AT" <?php if (get_option('ec_option_paypal_lc') == 'AT') echo ' selected'; ?>>Austria</option>
                                    <option value="BE" <?php if (get_option('ec_option_paypal_lc') == 'BE') echo ' selected'; ?>>Belgium</option>
                                    <option value="BR" <?php if (get_option('ec_option_paypal_lc') == 'BR') echo ' selected'; ?>>Brazil</option>
                                    <option value="CA" <?php if (get_option('ec_option_paypal_lc') == 'CA') echo ' selected'; ?>>Canada</option>
                                    <option value="CH" <?php if (get_option('ec_option_paypal_lc') == 'CH') echo ' selected'; ?>>Switzerland</option>
                                    <option value="CN" <?php if (get_option('ec_option_paypal_lc') == 'CN') echo ' selected'; ?>>China</option>
                                    <option value="DE" <?php if (get_option('ec_option_paypal_lc') == 'DE') echo ' selected'; ?>>Germany</option>
                                    <option value="ES" <?php if (get_option('ec_option_paypal_lc') == 'ES') echo ' selected'; ?>>Spain</option>
                                    <option value="GB" <?php if (get_option('ec_option_paypal_lc') == 'GB') echo ' selected'; ?>>United Kingdom</option>
                                    <option value="FR" <?php if (get_option('ec_option_paypal_lc') == 'FR') echo ' selected'; ?>>France</option>
                                    <option value="IT" <?php if (get_option('ec_option_paypal_lc') == 'IT') echo ' selected'; ?>>Italy</option>
                                    <option value="NL" <?php if (get_option('ec_option_paypal_lc') == 'NL') echo ' selected'; ?>>Netherlands</option>
                                    <option value="PL" <?php if (get_option('ec_option_paypal_lc') == 'PL') echo ' selected'; ?>>Poland</option>
                                    <option value="PT" <?php if (get_option('ec_option_paypal_lc') == 'PT') echo ' selected'; ?>>Portugal</option>
                                    <option value="RU" <?php if (get_option('ec_option_paypal_lc') == 'RU') echo ' selected'; ?>>Russia</option>
                                    <option value="da_DK" <?php if (get_option('ec_option_paypal_lc') == 'da_DK') echo ' selected'; ?>>Danish (for Denmark only)</option>
                                    <option value="he_IL" <?php if (get_option('ec_option_paypal_lc') == 'he_IL') echo ' selected'; ?>>Hebrew (all)</option>
                                    <option value="id_ID" <?php if (get_option('ec_option_paypal_lc') == 'id_ID') echo ' selected'; ?>>Indonesian (for Indonesia only)</option>
                                    <option value="jp_JP" <?php if (get_option('ec_option_paypal_lc') == 'jp_JP') echo ' selected'; ?>>Japanese (for Japan only)</option>
                                    <option value="no_NO" <?php if (get_option('ec_option_paypal_lc') == 'no_NO') echo ' selected'; ?>>Norwegian (for Norway only)</option>
                                    <option value="pt_BR" <?php if (get_option('ec_option_paypal_lc') == 'pt_BR') echo ' selected'; ?>>Brazilian Portuguese (for Portugal and Brazil only)</option>
                                    <option value="ru_RU" <?php if (get_option('ec_option_paypal_lc') == 'ru_RU') echo ' selected'; ?>>Russian (for Lithuania, Latvia, and Ukraine only)</option>
                                    <option value="sv_SE" <?php if (get_option('ec_option_paypal_lc') == 'sv_SE') echo ' selected'; ?>>Swedish (for Sweden only)</option>
                                    <option value="th_TH" <?php if (get_option('ec_option_paypal_lc') == 'th_TH') echo ' selected'; ?>>Thai (for Thailand only)</option>
                                    <option value="tr_TR" <?php if (get_option('ec_option_paypal_lc') == 'tr_TR') echo ' selected'; ?>>Turkish (for Turkey only)</option>
                                    <option value="zh_CN" <?php if (get_option('ec_option_paypal_lc') == 'zh_CN') echo ' selected'; ?>>Simplified Chinese (for China only)</option>
                                    <option value="zh_HK" <?php if (get_option('ec_option_paypal_lc') == 'zh_HK') echo ' selected'; ?>>Traditional Chinese (for Hong Kong only)</option>
                                    <option value="zh_TW" <?php if (get_option('ec_option_paypal_lc') == 'zh_TW') echo ' selected'; ?>>Traditional Chinese (for Taiwan only)</option>
                                  </select>
                                  <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                                    <span class="ec_custom ec_help">
                                        <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                                        <em>Language Code</em>
                                        The language to be used during checkout on the PayPal page.
                                    </span>
                            		</a>
                          		</td>
                        	</tr>
                            <tr valign="top">
                              <td class="itemheading" scope="row">PayPal Weight Unit:</td>
                              <td><select name="ec_option_paypal_weight_unit" id="ec_option_paypal_weight_unit">
                                <option value="lbs" <?php if (get_option('ec_option_paypal_weight_unit') == 'lbs') echo ' selected'; ?>>LBS</option>
                                <option value="kgs" <?php if (get_option('ec_option_paypal_weight_unit') == 'kgs') echo ' selected'; ?>>KGS</option>
                              </select>
                              <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                                    <span class="ec_custom ec_help">
                                        <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                                        <em>Weight Unit</em>
                                        (Optional) Used if your PayPal account has shipping settings overriding the WP EasyCart shipping values.
                                    </span>
                                </a>
                                </td>
                            </tr>
                            <tr valign="top">
                              <td class="itemheading" scope="row">PayPal Use Sandbox For Testing:</td>
                              <td><select name="ec_option_paypal_use_sandbox" id="ec_option_paypal_use_sandbox">
                                <option value="1" <?php if (get_option('ec_option_paypal_use_sandbox') == 1) echo ' selected'; ?>>Yes</option>
                                <option value="0" <?php if (get_option('ec_option_paypal_use_sandbox') == 0) echo ' selected'; ?>>No</option>
                              </select>
                              <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                                    <span class="ec_custom ec_help">
                                        <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                                        <em>Sandbox</em>
                                        Turn this off when you are ready to sell items live on your website.
                                    </span>
                                </a>
                              </td>
                            </tr>
              			</table>
              		</td>
            	</tr>
                
                <tr valign="top" class="form-table" id="realex_thirdparty">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Merchant ID:</td>
                      <td width="74%"><input name="ec_option_realex_thirdparty_merchant_id"  id="ec_option_realex_thirdparty_merchant_id" type="text" value="<?php echo get_option('ec_option_realex_thirdparty_merchant_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Secret:</td>
                      <td width="74%"><input name="ec_option_realex_thirdparty_secret"  id="ec_option_realex_thirdparty_secret" type="text" value="<?php echo get_option('ec_option_realex_thirdparty_secret'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Currency:</td>
                      <td width="74%"><select name="ec_option_realex_thirdparty_currency" id="ec_option_realex_thirdparty_currency">
                        <option value="GBP" <?php if (get_option('ec_option_realex_thirdparty_currency') == "GBP") echo ' selected'; ?>>GBP</option>
                        <option value="EUR" <?php if (get_option('ec_option_realex_thirdparty_currency') == "EUR") echo ' selected'; ?>>EUR</option>
                        <option value="USD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "USD") echo ' selected'; ?>>USD</option>
                        <option value="DKK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "DKK") echo ' selected'; ?>>DKK</option>
                        <option value="NOK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "NOK") echo ' selected'; ?>>NOK</option>
                        <option value="CHF" <?php if (get_option('ec_option_realex_thirdparty_currency') == "CHF") echo ' selected'; ?>>CHF</option>
                        <option value="AUD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "AUD") echo ' selected'; ?>>AUD</option>
                        <option value="CAD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "CAD") echo ' selected'; ?>>CAD</option>
                        <option value="CZK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "CZK") echo ' selected'; ?>>CZK</option>
                        <option value="JPY" <?php if (get_option('ec_option_realex_thirdparty_currency') == "JPY") echo ' selected'; ?>>JPY</option>
                        <option value="NZD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "NZD") echo ' selected'; ?>>NZD</option>
                        <option value="HKD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "HKD") echo ' selected'; ?>>HKD</option>
                        <option value="ZAR" <?php if (get_option('ec_option_realex_thirdparty_currency') == "ZAR") echo ' selected'; ?>>ZAR</option>
                        <option value="SEK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "SEK") echo ' selected'; ?>>SEK</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">To Do:</td>
                      <td width="74%">You must submit the following URLs to Realex before the redirect method can work completely. You should also add information to your account for your customers to see on the payment page, successful payment page, and the failed payment page.</td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Referring URL:</td>
                      <td width="74%"><?php $cart_page_id = get_option( 'ec_option_cartpage' ); $cart_page = get_permalink( $cart_page_id ); if( substr_count( $cart_page, '?' ) ){$permalink_divider = "&"; }else{ $permalink_divider = "?"; } echo $cart_page . $permalink_divider . "ec_page=realex_redirect"; ?></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Response URL:</td>
                      <td width="74%"><?php echo $cart_page . $permalink_divider . "ec_page=realex_response"; ?></td>
                    </tr>
                  </table></td>
                </tr>
            
            <tr valign="top" class="form-table" id="skrill">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Skrill Information:</td>
                      <td width="74%">Skrill is not accepted in Afghanistan, Cuba, Myanmar, Nigeria, North Korea, Sudan, Syria, Somalia, and Yemen.</td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Skrill Merchant ID (Customer ID):</td>
                      <td width="74%"><input name="ec_option_skrill_merchant_id"  id="ec_option_skrill_merchant_id" type="text" value="<?php echo get_option('ec_option_skrill_merchant_id'); ?>" style="width:250px;" />
                        <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Customer ID</em>
                                The customer ID associated with your skrill account.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Skrill Company Name:</td>
                      <td><input name="ec_option_skrill_company_name"  id="ec_option_skrill_company_name" type="text" value="<?php echo get_option('ec_option_skrill_company_name'); ?>" style="width:250px;" />
                      	<a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Company Name</em>
                                (Required) This is your company name for your Skrill account.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Skrill Email:</td>
                      <td><input name="ec_option_skrill_email" id="ec_option_skrill_email"  type="text" value="<?php echo get_option('ec_option_skrill_email'); ?>" style="width:250px;" />
                      	<a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Email Address</em>
                                (Optional) email used to send order data, use only for testing and leave blank for live processing.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Skrill Language:</td>
                      <td width="74%"><select name="ec_option_skrill_language" id="ec_option_skrill_language">
                        <option value="EN" <?php if (get_option('ec_option_skrill_language') == "EN") echo ' selected'; ?>>EN</option>
                        <option value="DE" <?php if (get_option('ec_option_skrill_language') == "DE") echo ' selected'; ?>>DE</option>
                        <option value="ES" <?php if (get_option('ec_option_skrill_language') == "ES") echo ' selected'; ?>>ES</option>
                        <option value="FR" <?php if (get_option('ec_option_skrill_language') == "FR") echo ' selected'; ?>>FR</option>
                        <option value="IT" <?php if (get_option('ec_option_skrill_language') == "IT") echo ' selected'; ?>>IT</option>
                        <option value="PL" <?php if (get_option('ec_option_skrill_language') == "PL") echo ' selected'; ?>>PL</option>
                        <option value="GR" <?php if (get_option('ec_option_skrill_language') == "GR") echo ' selected'; ?>>GR</option>
                        <option value="RO" <?php if (get_option('ec_option_skrill_language') == "RO") echo ' selected'; ?>>RO</option>
                        <option value="RU" <?php if (get_option('ec_option_skrill_language') == "RU") echo ' selected'; ?>>RU</option>
                        <option value="TR" <?php if (get_option('ec_option_skrill_language') == "TR") echo ' selected'; ?>>TR</option>
                        <option value="CN" <?php if (get_option('ec_option_skrill_language') == "CN") echo ' selected'; ?>>CN</option>
                        <option value="CZ" <?php if (get_option('ec_option_skrill_language') == "CZ") echo ' selected'; ?>>CZ</option>
                        <option value="NL" <?php if (get_option('ec_option_skrill_language') == "NL") echo ' selected'; ?>>NL</option>
                        <option value="DA" <?php if (get_option('ec_option_skrill_language') == "DA") echo ' selected'; ?>>DA</option>
                        <option value="SV" <?php if (get_option('ec_option_skrill_language') == "SV") echo ' selected'; ?>>SV</option>
                        <option value="FI" <?php if (get_option('ec_option_skrill_language') == "FI") echo ' selected'; ?>>FI</option>
                        <option value="BG" <?php if (get_option('ec_option_skrill_language') == "BG") echo ' selected'; ?>>BG</option>
                      </select>
                        
                        <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Language Code</em>
                                (Required) select your language code for your website/checkout process.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Skrill Currency Code:</td>
                      <td><select name="ec_option_skrill_currency_code" id="ec_option_skrill_currency_code">
                        <option value="USD" <?php if (get_option('ec_option_skrill_currency_code') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="EUR" <?php if (get_option('ec_option_skrill_currency_code') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="GBP" <?php if (get_option('ec_option_skrill_currency_code') == "GBP") echo ' selected'; ?>>British Pound</option>
                        <option value="HKD" <?php if (get_option('ec_option_skrill_currency_code') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="SGD" <?php if (get_option('ec_option_skrill_currency_code') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="JPY" <?php if (get_option('ec_option_skrill_currency_code') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="CAD" <?php if (get_option('ec_option_skrill_currency_code') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="AUD" <?php if (get_option('ec_option_skrill_currency_code') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="CHF" <?php if (get_option('ec_option_skrill_currency_code') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="DKK" <?php if (get_option('ec_option_skrill_currency_code') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="SEK" <?php if (get_option('ec_option_skrill_currency_code') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="NOK" <?php if (get_option('ec_option_skrill_currency_code') == "NOK") echo ' selected'; ?>>Norwegian Krone</option>
                        <option value="ILS" <?php if (get_option('ec_option_skrill_currency_code') == "ILS") echo ' selected'; ?>>Israeli Shekel</option>
                        <option value="MYR" <?php if (get_option('ec_option_skrill_currency_code') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="NZD" <?php if (get_option('ec_option_skrill_currency_code') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="TRY" <?php if (get_option('ec_option_skrill_currency_code') == "TRY") echo ' selected'; ?>>New Turkish Lira</option>
                        <option value="AED" <?php if (get_option('ec_option_skrill_currency_code') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                        <option value="MAD" <?php if (get_option('ec_option_skrill_currency_code') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                        <option value="QAR" <?php if (get_option('ec_option_skrill_currency_code') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                        <option value="SAR" <?php if (get_option('ec_option_skrill_currency_code') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                        <option value="TWD" <?php if (get_option('ec_option_skrill_currency_code') == "TWD") echo ' selected'; ?>>Taiwan Dollar</option>
                        <option value="THB" <?php if (get_option('ec_option_skrill_currency_code') == "THB") echo ' selected'; ?>>Thailand Baht</option>
                        <option value="CZK" <?php if (get_option('ec_option_skrill_currency_code') == "CZK") echo ' selected'; ?>>Czech Koruna</option>
                        <option value="HUF" <?php if (get_option('ec_option_skrill_currency_code') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                        <option value="SKK" <?php if (get_option('ec_option_skrill_currency_code') == "SKK") echo ' selected'; ?>>Slovakian Koruna</option>
                        <option value="EEK" <?php if (get_option('ec_option_skrill_currency_code') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                        <option value="BGN" <?php if (get_option('ec_option_skrill_currency_code') == "BGN") echo ' selected'; ?>>Bulgarian Leva</option>
                        <option value="PLN" <?php if (get_option('ec_option_skrill_currency_code') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                        <option value="ISK" <?php if (get_option('ec_option_skrill_currency_code') == "ISK") echo ' selected'; ?>>Iceland Krona</option>
                        <option value="INR" <?php if (get_option('ec_option_skrill_currency_code') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                        <option value="LVL" <?php if (get_option('ec_option_skrill_currency_code') == "LVL") echo ' selected'; ?>>Latvian Lat</option>
                        <option value="KRW" <?php if (get_option('ec_option_skrill_currency_code') == "KRW") echo ' selected'; ?>>South-Korean Won</option>
                        <option value="ZAR" <?php if (get_option('ec_option_skrill_currency_code') == "ZAR") echo ' selected'; ?>>South-African Rand</option>
                        <option value="RON" <?php if (get_option('ec_option_skrill_currency_code') == "RON") echo ' selected'; ?>>Romanian Leu New</option>
                        <option value="HRK" <?php if (get_option('ec_option_skrill_currency_code') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                        <option value="LTL" <?php if (get_option('ec_option_skrill_currency_code') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                        <option value="JOD" <?php if (get_option('ec_option_skrill_currency_code') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                        <option value="OMR" <?php if (get_option('ec_option_skrill_currency_code') == "OMR") echo ' selected'; ?>>Omani Rial</option>
                        <option value="RSD" <?php if (get_option('ec_option_skrill_currency_code') == "RSD") echo ' selected'; ?>>Serbian dinar</option>
                        <option value="TND" <?php if (get_option('ec_option_skrill_currency_code') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                      </select>
                        
                        <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Currency Code</em>
                                (Required) The currency code used to process transactions.
                            </span>
                        </a>
                      </td>
                    </tr>
                  </table>
                  </td>
                </tr>
	          </table>
              <?php }?>
              <div class="ec_failed_row"><input type="submit" class="button-primary" value="Update Third Party Data" /></div>
              <input type="hidden" name="ec_action" value="update_third_party" />
              </form>
              	<script>
					function update_third_party_form( ){
						var use_third_party = document.getElementById( 'ec_option_checklist_third_party' ).value;
						var which_third_party = "0";
						if( document.getElementById( 'ec_option_payment_third_party' ) )
							which_third_party = document.getElementById( 'ec_option_payment_third_party' ).value;
						
						var has_paymentexpress_thirdparty = "0";
						if( document.getElementById( 'ec_option_checklist_has_paymentexpress_thirdparty' ) )
							has_paymentexpress_thirdparty = document.getElementById( 'ec_option_checklist_has_paymentexpress_thirdparty' ).value;
						var has_paypal = "0";
						if( document.getElementById( 'ec_option_checklist_has_paypal' ) )
							has_paypal = document.getElementById( 'ec_option_checklist_has_paypal' ).value;
						var has_realex_thirdparty = "0";
						if( document.getElementById( 'ec_option_checklist_has_realex_thirdparty' ) )
							has_realex_thirdparty = document.getElementById( 'ec_option_checklist_has_realex_thirdparty' ).value;
						var has_skrill = "0";
						if( document.getElementById( 'ec_option_checklist_has_skrill' ) )
							has_skrill = document.getElementById( 'ec_option_checklist_has_skrill' ).value;
						
						if( use_third_party == "yes" ){
							if( document.getElementById( 'no_third_party_license' ) ){
								jQuery( '#no_third_party_license' ).show();
							}else{
								jQuery('#which_third_party').show();
								if( which_third_party == "paymentexpress_thirdparty" ){
									jQuery( '#has_paymentexpress_thirdparty' ).show();
									jQuery( '#has_paypal' ).hide();
									jQuery( '#has_realex_thirdparty' ).hide();
									jQuery( '#has_skrill' ).hide();
									
									jQuery( '#get_paypal' ).hide();
									jQuery( '#paypal' ).hide();
									jQuery( '#get_realex_thirdparty' ).hide();
									jQuery( '#realex_thirdparty' ).hide();
									jQuery( '#get_skrill' ).hide();
									jQuery( '#skrill' ).hide();
									
									if( has_paymentexpress_thirdparty == "yes" ){
										jQuery( '#get_paymentexpress_thirdparty' ).hide();
										jQuery( '#paymentexpress_thirdparty' ).show();
									}else if( has_paymentexpress_thirdparty == "no"){
										jQuery( '#get_paymentexpress_thirdparty' ).show();
										jQuery( '#paymentexpress_thirdparty' ).hide();
									}else{
										jQuery( '#get_paymentexpress_thirdparty' ).hide();
										jQuery( '#paymentexpress_thirdparty' ).hide();
									}
								}else if( which_third_party == "paypal" ){
									jQuery( '#has_paymentexpress_thirdparty' ).hide();
									jQuery( '#get_paymentexpress_thirdparty' ).hide();
									jQuery( '#paymentexpress_thirdparty' ).hide();
									jQuery( '#has_paypal ').show();
									jQuery( '#has_realex_thirdparty' ).hide();
									jQuery( '#get_realex_thirdparty' ).hide();
									jQuery( '#realex_thirdparty' ).hide();
									jQuery( '#has_skrill' ).hide();
									jQuery( '#get_skrill' ).hide();
									jQuery( '#skrill' ).hide();
									
									if( has_paypal == "yes" ){
										jQuery( '#get_paypal' ).hide();
										jQuery( '#paypal' ).show();
									}else if( has_paypal == "no"){
										jQuery( '#get_paypal' ).show();
										jQuery( '#paypal' ).hide();
									}else{
										jQuery( '#get_paypal' ).hide();
										jQuery( '#paypal' ).hide();
									}
								}else if( which_third_party == "realex_thirdparty" ){
									jQuery( '#has_paymentexpress_thirdparty' ).hide();
									jQuery( '#get_paymentexpress_thirdparty' ).hide();
									jQuery( '#paymentexpress_thirdparty' ).hide();
									
									jQuery( '#has_paypal' ).hide();
									jQuery( '#get_paypal' ).hide();
									jQuery( '#paypal' ).hide();
									
									jQuery( '#has_realex_thirdparty' ).show();
									
									jQuery( '#has_skrill' ).hide();
									jQuery( '#get_skrill' ).hide();
									jQuery( '#skrill' ).hide();
									
									if( has_realex_thirdparty == "yes" ){
										jQuery( '#get_realex_thirdparty' ).hide();
										jQuery( '#realex_thirdparty' ).show();
									}else if( has_realex_thirdparty == "no"){
										jQuery( '#get_realex_thirdparty' ).show();
										jQuery( '#realex_thirdparty' ).hide();
									}else{
										jQuery( '#get_realex_thirdparty' ).hide();
										jQuery( '#realex_thirdparty' ).hide();
									}
								}else if( which_third_party == "skrill" ){
									jQuery( '#has_paymentexpress_thirdparty' ).hide();
									jQuery( '#get_paymentexpress_thirdparty' ).hide();
									jQuery( '#paymentexpress_thirdparty' ).hide();
									
									jQuery( '#has_paypal' ).hide();
									jQuery( '#get_paypal' ).hide();
									jQuery( '#paypal' ).hide();	
									
									jQuery( '#has_realex_thirdparty' ).hide();
									jQuery( '#get_realex_thirdparty' ).hide();
									jQuery( '#realex_thirdparty' ).hide();
									
									jQuery( '#has_skrill' ).show();
									if( has_skrill == "yes" ){
										jQuery( '#get_skrill' ).hide();
										jQuery( '#skrill' ).show();
									}else if( has_skrill == "no"){
										jQuery( '#get_skrill' ).show();
										jQuery( '#skrill' ).hide();
									}else{
										jQuery( '#get_skrill' ).hide();
										jQuery( '#skrill' ).hide();
									}
								}else{
									jQuery( '#has_paymentexpress_thirdparty' ).hide();
									jQuery( '#get_paymentexpress_thirdparty' ).hide();
									jQuery( '#paymentexpress_thirdparty' ).hide();
									
									jQuery( '#has_paypal' ).hide();
									jQuery( '#get_paypal' ).hide();
									jQuery( '#paypal' ).hide();
								
									jQuery(' #has_realex_thirdparty' ).hide();
									jQuery( '#get_realex_thirdparty' ).hide();
									jQuery( '#realex_thirdparty' ).hide();
								
									jQuery(' #has_skrill' ).hide();
									jQuery( '#get_skrill' ).hide();
									jQuery( '#skrill' ).hide();
								}
							}
						}else{
							jQuery( '#no_third_party_license' ).hide();
							jQuery('#paymentexpress_thirdparty').hide();
							jQuery('#paypal').hide();
							jQuery('#realex_thirdparty').hide();
							jQuery('#skrill').hide();
							jQuery('#which_third_party').hide();
							jQuery('#has_paymentexpress_thirdparty').hide();
							jQuery('#has_paypal').hide();
							jQuery('#has_realex_thirdparty').hide();
							jQuery('#has_skrill').hide();
							jQuery('#get_paymentexpress_thirdparty').hide();
							jQuery('#get_paypal').hide();
							jQuery('#get_realex_thirdparty').hide();
							jQuery('#get_skrill').hide();
						}
					}
					
					jQuery( '#no_third_party_license' ).hide();
					jQuery('#paymentexpress_thirdparty').hide();
					jQuery('#paypal').hide();
					jQuery('#realex_thirdparty').hide();
					jQuery('#skrill').hide();
					jQuery('#which_third_party').hide();
					jQuery('#has_paymentexpress_thirdparty').hide();
					jQuery('#has_paypal').hide();
					jQuery('#has_realex_thirdparty').hide();
					jQuery('#has_skrill').hide();
					jQuery('#get_paymentexpress_thirdparty').hide();
					jQuery('#get_paypal').hide();
					jQuery('#get_realex_thirdparty').hide();
					jQuery('#get_skrill').hide();
					
					update_third_party_form( );
				</script>
                
                <form method="post" action="" />
                    <div class="ec_failed_row">Finished with This Option: <select name="ec_option_checklist_third_party_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_third_party_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_third_party_complete" />
                </form>
            <?php }?>
            <hr />
            <?php 
			$total_payment++;
			if( get_option( 'ec_option_checklist_credit_cart_complete' ) == "done" ){
				$correct_payment++;
				$credit_card = 0;
				if( get_option( 'ec_option_payment_process_method' ) == "authorize" )
					$credit_card = "Authorize.net";
				if( get_option( 'ec_option_payment_process_method' ) == "braintree" )
					$credit_card = "Braintree S2S";
				if( get_option( 'ec_option_payment_process_method' ) == "goemerchant" )
					$credit_card = "GoeMerchant";
				else if( get_option( 'ec_option_payment_process_method' ) == "paypal_pro" )
					$credit_card = "PayPal Payflow Pro";
				else if( get_option( 'ec_option_payment_process_method' ) == "paypal_payments_pro" )
					$credit_card = "PayPal Payments Pro";
				else if( get_option( 'ec_option_payment_process_method' ) == "realex" )
					$credit_card = "Realex Payments";
				else if( get_option( 'ec_option_payment_process_method' ) == "sagepay" )
					$credit_card = "Sagepay";
				else if( get_option( 'ec_option_payment_process_method' ) == "firstdata" )
					$credit_card = "First Data Global Gateway e4";
				else if( get_option( 'ec_option_payment_process_method' ) == "paymentexpress" )
					$credit_card = "PaymentExpress PxPost";
				else if( get_option( 'ec_option_payment_process_method' ) == "chronopay" )
					$credit_card = "Chronopay";
				else if( get_option( 'ec_option_payment_process_method' ) == "eway" )
					$credit_card = "eWAY";
				else if( get_option( 'ec_option_payment_process_method' ) == "paypoint" )
					$credit_card = "PayPoint.net";
				else if( get_option( 'ec_option_payment_process_method' ) == "securepay" )
					$credit_card = "SecurePay";
				
				if( get_option( 'ec_option_checklist_credit_cart_complete' ) )
					if( $credit_card == "0" )
						ec_show_check( "You have selected to use no live payment gateway on your store. <a href=\"?page=ec_payment\">edit this option here</a>" );
					else
						ec_show_check( "You have selected to use " . $credit_card . " for your live payment gateway on your store. <a href=\"?page=ec_payment\">edit this option here</a>" );
				else
					ec_show_check( "You have selected to not use any live payment gateways on your store. <a href=\"?page=ec_payment\">edit this option here</a>" ); 
			}else{ 
				ec_show_failed( "Please tell us if you would like to use a live payment processor (customer never leaves the site)." );
				?>
                <form method="post" action="" />
            	<div class="ec_failed_row">Do you want to use a Live Processor: <select name="ec_option_checklist_credit_card" id="ec_option_checklist_credit_card" onchange="update_credit_card_form();"<?php if( get_option( 'ec_option_checklist_credit_card' ) == "0" || get_option( 'ec_option_checklist_credit_card' ) == "" ){ echo " selected=\"selected\""; } ?>><option value="0">Select One</option><option value="yes"<?php if( get_option( 'ec_option_checklist_credit_card' ) == "yes" ){ echo " selected=\"selected\""; } ?>>Yes</option><option value="done"<?php if( get_option( 'ec_option_checklist_credit_card' ) == "done" ){ echo " selected=\"selected\""; } ?>>No</option></select></div>
                <?php if( !$is_full ){ ?>
                <div class="ec_failed_row" id="no_full_license">Please purchase a license for the <a href="http://www.wpeasycart.com/products/?model_number=ec100" target="_blank">Full Version for $80</a> to continue.</div>
                <?php }?>
                <div class="ec_failed_row" id="ec_credit_card_location_row">Which Location Best Describes Your Business: <select name="ec_option_checklist_credit_card_location" id="ec_option_checklist_credit_card_location" onchange="update_credit_card_form();">
                    <option value="0"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "0" ){ echo " selected=\"selected\""; } ?>>Select One</option>
                    <option value="us"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "us" ){ echo " selected=\"selected\""; } ?>>USA</option>
                    <option value="ca"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "ca" ){ echo " selected=\"selected\""; } ?>>Canada</option>
                    <option value="uk"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "uk" ){ echo " selected=\"selected\""; } ?>>UK</option>
                    <option value="ireland"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "ireland" ){ echo " selected=\"selected\""; } ?>>Ireland</option>
                    <option value="germany"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "germany" ){ echo " selected=\"selected\""; } ?>>Germany</option>
                    <option value="spain"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "spain" ){ echo " selected=\"selected\""; } ?>>Spain</option>
                    <option value="au"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "au" ){ echo " selected=\"selected\""; } ?>>Australia/New Zealand</option>
                    <option value="eu"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "eu" ){ echo " selected=\"selected\""; } ?>>Europe</option>
                    <option value="ru"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "ru" ){ echo " selected=\"selected\""; } ?>>Russia</option>
                    <option value="ch"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "ch" ){ echo " selected=\"selected\""; } ?>>China</option>
                    <option value="jp"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "jp" ){ echo " selected=\"selected\""; } ?>>Japan</option>
                    <option value="central_america"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "central_america" ){ echo " selected=\"selected\""; } ?>>Central America</option>
                    <option value="south_america"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "south_america" ){ echo " selected=\"selected\""; } ?>>South America</option>
                    <option value="af"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "af" ){ echo " selected=\"selected\""; } ?>>Africa</option>
                    <option value="asia"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "asia" ){ echo " selected=\"selected\""; } ?>>Asia</option>
                    <option value="middle_east"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "middle_east" ){ echo " selected=\"selected\""; } ?>>Middle East</option>
                    <option value="south_pacific"<?php if( get_option( 'ec_option_checklist_credit_card_location' ) == "south_pacific" ){ echo " selected=\"selected\""; } ?>>South Pacific</option>
                </select></div>
                <div class="ec_failed_row" id="which_gateway_label"><strong>From our research, here are the best live payment gateway options that we offer, please select one to continue:</strong></div>
                <div class="ec_failed_row" id="authorize_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="authorize" id="authorize_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "authorize" ){ echo " checked=\"checked\""; } ?> /> Authorize.net - <a href="https://ems.authorize.net/oap/home.aspx?SalesRepID=98&ResellerID=24627" target="_blank">Need an Account?</a></div>
                <table id="authorize_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Authorize.net Login ID:</td>
                          <td width="74%"><input name="ec_option_authorize_login_id" id="ec_option_authorize_login_id" type="text" value="<?php echo get_option('ec_option_authorize_login_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Authorize.net Transaction Key:</td>
                          <td><input name="ec_option_authorize_trans_key" id="ec_option_authorize_trans_key" type="text" value="<?php echo get_option('ec_option_authorize_trans_key'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Authorize.net Currency Code:</td>
                          <td><select name="ec_option_authorize_currency_code" id="ec_option_authorize_currency_code">
                            <option value="USD" <?php if ( get_option( 'ec_option_authorize_currency_code') == "USD" ){ echo " selected=\"selected\""; } ?>>USD</option>
                            <option value="CAD" <?php if ( get_option( 'ec_option_authorize_currency_code') == "CAD" ){ echo " selected=\"selected\""; } ?>>CAD</option>
                            <option value="EUR" <?php if ( get_option( 'ec_option_authorize_currency_code') == "EUR" ){ echo " selected=\"selected\""; } ?>>EUR</option>
                            <option value="GBP" <?php if ( get_option( 'ec_option_authorize_currency_code') == "GBP" ){ echo " selected=\"selected\""; } ?>>GBP</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Authorize.net Test Mode:</td>
                          <td><select name="ec_option_authorize_test_mode" id="ec_option_authorize_test_mode">
                            <option value="1" <?php if (get_option('ec_option_authorize_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_authorize_test_mode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Authorize.net Developer Account:</td>
                          <td><select name="ec_option_authorize_developer_account" id="ec_option_authorize_developer_account">
                            <option value="1" <?php if (get_option('ec_option_authorize_developer_account') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_authorize_developer_account') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                
                <div class="ec_failed_row" id="braintree_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="braintree" id="braintree_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "braintree" ){ echo " checked=\"checked\""; } ?> /> Braintree S2S - <a href="https://apply.braintreegateway.com" target="_blank">Need an Account?</a></div>
                <table id="braintree_table" class="ec_payment_gateway_table">
                    <tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Braintree Merchant Account ID:</td>
                          <td width="74%"><input name="ec_option_braintree_merchant_id" id="ec_option_braintree_merchant_id" type="text" value="<?php echo get_option('ec_option_braintree_merchant_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Braintree Public Key:</td>
                          <td><input name="ec_option_braintree_public_key" id="ec_option_braintree_public_key" type="text" value="<?php echo get_option('ec_option_braintree_public_key'); ?>" style="width:400px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Braintree Private Key:</td>
                          <td><input name="ec_option_braintree_private_key" id="ec_option_braintree_private_key" type="text" value="<?php echo get_option('ec_option_braintree_private_key'); ?>" style="width:400px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Braintree Currency Code:</td>
                          <td><select name="ec_option_braintree_currency" id="ec_option_braintree_currency">
                            <option value="USD" <?php if (get_option('ec_option_braintree_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                            <option value="CAD" <?php if (get_option('ec_option_braintree_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                            <option value="DEM" <?php if (get_option('ec_option_braintree_currency') == "DEM") echo ' selected'; ?>>German Mark</option>
                            <option value="CHF" <?php if (get_option('ec_option_braintree_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                            <option value="GBP" <?php if (get_option('ec_option_braintree_currency') == "GBP") echo ' selected'; ?>>British Pound</option>
                            
                            <option value="AFA" <?php if (get_option('ec_option_braintree_currency') == "AFA") echo ' selected'; ?>>Afghanistan Afghani</option>
                            <option value="ALL" <?php if (get_option('ec_option_braintree_currency') == "ALL") echo ' selected'; ?>>Albanian Lek</option>
                            <option value="DZD" <?php if (get_option('ec_option_braintree_currency') == "DZD") echo ' selected'; ?>>Algerian Dinar</option>
                            <option value="ARS" <?php if (get_option('ec_option_braintree_currency') == "ARS") echo ' selected'; ?>>Argentine Peso</option>
                            <option value="AMD" <?php if (get_option('ec_option_braintree_currency') == "AMD") echo ' selected'; ?>>Armenian Dram</option>
                            <option value="AWG" <?php if (get_option('ec_option_braintree_currency') == "AWG") echo ' selected'; ?>>Aruban Florin</option>
                            <option value="AUD" <?php if (get_option('ec_option_braintree_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                            <option value="AZN" <?php if (get_option('ec_option_braintree_currency') == "AZN") echo ' selected'; ?>>Azerbaijani an Manat</option>
                            
                            <option value="BSD" <?php if (get_option('ec_option_braintree_currency') == "BSD") echo ' selected'; ?>>Bahamanian Dollar</option>
                            <option value="BHD" <?php if (get_option('ec_option_braintree_currency') == "BHD") echo ' selected'; ?>>Bahraini Dinar</option>
                            <option value="BDT" <?php if (get_option('ec_option_braintree_currency') == "BDT") echo ' selected'; ?>>Bangladeshi Taka</option>
                            <option value="BBD" <?php if (get_option('ec_option_braintree_currency') == "BBD") echo ' selected'; ?>>Barbados Dollar</option>
                            <option value="BYR" <?php if (get_option('ec_option_braintree_currency') == "BYR") echo ' selected'; ?>>Belarussian Ruble</option>
                            <option value="BZD" <?php if (get_option('ec_option_braintree_currency') == "BZD") echo ' selected'; ?>>Belize Dollar</option>
                            <option value="BMD" <?php if (get_option('ec_option_braintree_currency') == "BMD") echo ' selected'; ?>>Bermudian Dollar</option>
                            <option value="BOB" <?php if (get_option('ec_option_braintree_currency') == "BOB") echo ' selected'; ?>>Bolivian Boliviano</option>
                            <option value="BWP" <?php if (get_option('ec_option_braintree_currency') == "BWP") echo ' selected'; ?>>Botswana Pula</option>
                            <option value="BRL" <?php if (get_option('ec_option_braintree_currency') == "BRL") echo ' selected'; ?>>Brazilian Real</option>
                            <option value="BND" <?php if (get_option('ec_option_braintree_currency') == "BND") echo ' selected'; ?>>Brunei Dollar</option>
                            <option value="BGN" <?php if (get_option('ec_option_braintree_currency') == "BGN") echo ' selected'; ?>>Bulgarian Lev</option>
                            <option value="BIF" <?php if (get_option('ec_option_braintree_currency') == "BIF") echo ' selected'; ?>>Burundi Franc</option>
                            
                            <option value="KHR" <?php if (get_option('ec_option_braintree_currency') == "KHR") echo ' selected'; ?>>Cambodian Riel</option>
                            <option value="CVE" <?php if (get_option('ec_option_braintree_currency') == "CVE") echo ' selected'; ?>>Cape Verde Escudo</option>
                            <option value="KYD" <?php if (get_option('ec_option_braintree_currency') == "KYD") echo ' selected'; ?>>Cayman Islands Dollar</option>
                            <option value="XAF" <?php if (get_option('ec_option_braintree_currency') == "XAF") echo ' selected'; ?>>Central African Republic Franc BCEAO</option>
                            <option value="XPF" <?php if (get_option('ec_option_braintree_currency') == "XPF") echo ' selected'; ?>>CFP Franc</option>
                            <option value="CLP" <?php if (get_option('ec_option_braintree_currency') == "CLP") echo ' selected'; ?>>Chilean Peso</option>
                            <option value="CNY" <?php if (get_option('ec_option_braintree_currency') == "CNY") echo ' selected'; ?>>Chinese Yuan Renminbi</option>
                            <option value="COP" <?php if (get_option('ec_option_braintree_currency') == "COP") echo ' selected'; ?>>Colombian Peso</option>
                            <option value="KMF" <?php if (get_option('ec_option_braintree_currency') == "KMF") echo ' selected'; ?>>Comoros Franc</option>
                            <option value="BAM" <?php if (get_option('ec_option_braintree_currency') == "BAM") echo ' selected'; ?>>Convertible Marks</option>
                            <option value="CRC" <?php if (get_option('ec_option_braintree_currency') == "CRC") echo ' selected'; ?>>Costa Rican Colon</option>
                            <option value="HRK" <?php if (get_option('ec_option_braintree_currency') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                            <option value="CUP" <?php if (get_option('ec_option_braintree_currency') == "CUP") echo ' selected'; ?>>Cuban Peso</option>
                            <option value="CYP" <?php if (get_option('ec_option_braintree_currency') == "CYP") echo ' selected'; ?>>Cyprus Pound</option>
                            <option value="CZK" <?php if (get_option('ec_option_braintree_currency') == "CZK") echo ' selected'; ?>>Czech Republic Koruna</option>
                            
                            <option value="DKK" <?php if (get_option('ec_option_braintree_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                            <option value="DJF" <?php if (get_option('ec_option_braintree_currency') == "DJF") echo ' selected'; ?>>Djibouti Franc</option>
                            <option value="DOP" <?php if (get_option('ec_option_braintree_currency') == "DOP") echo ' selected'; ?>>Dominican Peso</option>
                            
                            
                            <option value="XCD" <?php if (get_option('ec_option_braintree_currency') == "XCD") echo ' selected'; ?>>East Caribbean Dollar</option>
                            <option value="ECS" <?php if (get_option('ec_option_braintree_currency') == "ECE") echo ' selected'; ?>>Ecuador Sucre</option>
                            <option value="EGP" <?php if (get_option('ec_option_braintree_currency') == "EGP") echo ' selected'; ?>>Egyptian Pound</option>
                            <option value="SVC" <?php if (get_option('ec_option_braintree_currency') == "SVC") echo ' selected'; ?>>El Salvador Colon</option>
                            <option value="ERN" <?php if (get_option('ec_option_braintree_currency') == "ERN") echo ' selected'; ?>>Eritrea Nakfa</option>
                            <option value="EEK" <?php if (get_option('ec_option_braintree_currency') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                            <option value="ETB" <?php if (get_option('ec_option_braintree_currency') == "ETB") echo ' selected'; ?>>Ethiopian Birr</option>
                            <option value="EUR" <?php if (get_option('ec_option_braintree_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                            
                            <option value="FKP" <?php if (get_option('ec_option_braintree_currency') == "FKP") echo ' selected'; ?>>Falkland Islands Pound</option>
                            <option value="FJD" <?php if (get_option('ec_option_braintree_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                            <option value="CDF" <?php if (get_option('ec_option_braintree_currency') == "CDF") echo ' selected'; ?>>Franc Congolais</option>
                            
                            <option value="GMD" <?php if (get_option('ec_option_braintree_currency') == "GMD") echo ' selected'; ?>>Gambian Dalasi</option>
                            <option value="GEL" <?php if (get_option('ec_option_braintree_currency') == "GEL") echo ' selected'; ?>>Georgian Lari</option>
                            <option value="GHS" <?php if (get_option('ec_option_braintree_currency') == "GHS") echo ' selected'; ?>>Ghanaian Cedi</option>
                            <option value="GIP" <?php if (get_option('ec_option_braintree_currency') == "GIP") echo ' selected'; ?>>Gibraltar Pound</option>
                            <option value="GTQ" <?php if (get_option('ec_option_braintree_currency') == "GTQ") echo ' selected'; ?>>Guatemalan Quetzal</option>
                            <option value="GNF" <?php if (get_option('ec_option_braintree_currency') == "GNF") echo ' selected'; ?>>Guinea Franc</option>
                            <option value="GWP" <?php if (get_option('ec_option_braintree_currency') == "GWP") echo ' selected'; ?>>Guinea-Bissau Peso</option>
                            <option value="GYD" <?php if (get_option('ec_option_braintree_currency') == "GYD") echo ' selected'; ?>>Guyanan Dollar</option>
                            
                            <option value="HTG" <?php if (get_option('ec_option_braintree_currency') == "HTG") echo ' selected'; ?>>Haitian Gourde</option>
                            <option value="HNL" <?php if (get_option('ec_option_braintree_currency') == "HNL") echo ' selected'; ?>>Honduran Lempira</option>
                            <option value="HKD" <?php if (get_option('ec_option_braintree_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                            <option value="HUF" <?php if (get_option('ec_option_braintree_currency') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                            
                            <option value="ISK" <?php if (get_option('ec_option_braintree_currency') == "ISK") echo ' selected'; ?>>Iceland Krona</option>
                            <option value="INR" <?php if (get_option('ec_option_braintree_currency') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                            <option value="IDR" <?php if (get_option('ec_option_braintree_currency') == "IDR") echo ' selected'; ?>>Indonesian Rupiah</option>
                            <option value="IRR" <?php if (get_option('ec_option_braintree_currency') == "IRR") echo ' selected'; ?>>Iranian Rial</option>
                            <option value="IQD" <?php if (get_option('ec_option_braintree_currency') == "IQD") echo ' selected'; ?>>Iraqi Dinar</option>
                            <option value="ILS" <?php if (get_option('ec_option_braintree_currency') == "ILS") echo ' selected'; ?>>Israeli New Shekel</option>
                            
                            <option value="JMD" <?php if (get_option('ec_option_braintree_currency') == "JMD") echo ' selected'; ?>>Jamaican Dollar</option>
                            <option value="JPY" <?php if (get_option('ec_option_braintree_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                            <option value="JOD" <?php if (get_option('ec_option_braintree_currency') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                            
                            <option value="KZT" <?php if (get_option('ec_option_braintree_currency') == "KZT") echo ' selected'; ?>>Kazakhstan Tenge</option>
                            <option value="KES" <?php if (get_option('ec_option_braintree_currency') == "KES") echo ' selected'; ?>>Kenyan Shilling</option>
                            <option value="KWD" <?php if (get_option('ec_option_braintree_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                            <option value="AOA" <?php if (get_option('ec_option_braintree_currency') == "AOA") echo ' selected'; ?>>Kwanza</option>
                            <option value="GKS" <?php if (get_option('ec_option_braintree_currency') == "GKS") echo ' selected'; ?>>Kyrgyzstan Som</option>
                            
                            <option value="KIP" <?php if (get_option('ec_option_braintree_currency') == "KIP") echo ' selected'; ?>>Laos Kip</option>
                            <option value="LAK" <?php if (get_option('ec_option_braintree_currency') == "LAK") echo ' selected'; ?>>Laosian Kip</option>
                            <option value="LVL" <?php if (get_option('ec_option_braintree_currency') == "LVL") echo ' selected'; ?>>Latvian Lat</option>
                            <option value="LBP" <?php if (get_option('ec_option_braintree_currency') == "LBP") echo ' selected'; ?>>Lebanese Pound</option>
                            <option value="LRD" <?php if (get_option('ec_option_braintree_currency') == "LRD") echo ' selected'; ?>>Liberian Dollar</option>
                            <option value="LYD" <?php if (get_option('ec_option_braintree_currency') == "LYD") echo ' selected'; ?>>Libyan Dinar</option>
                            <option value="LTL" <?php if (get_option('ec_option_braintree_currency') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                            <option value="LSL" <?php if (get_option('ec_option_braintree_currency') == "LSL") echo ' selected'; ?>>Loti</option>
                            
                            <option value="MOP" <?php if (get_option('ec_option_braintree_currency') == "MOP") echo ' selected'; ?>>Macanese Pataca</option>
                            <option value="MOP" <?php if (get_option('ec_option_braintree_currency') == "MOP") echo ' selected'; ?>>Macao</option>
                            <option value="MKD" <?php if (get_option('ec_option_braintree_currency') == "MKD") echo ' selected'; ?>>Macedonian Denar</option>
                            <option value="MGF" <?php if (get_option('ec_option_braintree_currency') == "MGF") echo ' selected'; ?>>Malagasy Franc</option>
                            <option value="MGA" <?php if (get_option('ec_option_braintree_currency') == "MGA") echo ' selected'; ?>>Malagasy Ariary</option>
                            <option value="MWK" <?php if (get_option('ec_option_braintree_currency') == "MWK") echo ' selected'; ?>>Malawi Kwacha</option>
                            <option value="MYR" <?php if (get_option('ec_option_braintree_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                            <option value="MVR" <?php if (get_option('ec_option_braintree_currency') == "MVR") echo ' selected'; ?>>Maldive Rufiyaa</option>
                            <option value="MTL" <?php if (get_option('ec_option_braintree_currency') == "MRL") echo ' selected'; ?>>Maltese Lira</option>
                            <option value="MRO" <?php if (get_option('ec_option_braintree_currency') == "MRO") echo ' selected'; ?>>Mauritanian Ouguiya</option>
                            <option value="MUR" <?php if (get_option('ec_option_braintree_currency') == "MUR") echo ' selected'; ?>>Mauritius Rupee</option>
                            <option value="MXN" <?php if (get_option('ec_option_braintree_currency') == "MXN") echo ' selected'; ?>>Mexican Peso</option>
                            <option value="MNT" <?php if (get_option('ec_option_braintree_currency') == "MNT") echo ' selected'; ?>>Mongolian Tugrik</option>
                            <option value="MAD" <?php if (get_option('ec_option_braintree_currency') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                            <option value="MZM" <?php if (get_option('ec_option_braintree_currency') == "MZM") echo ' selected'; ?>>Mozambique Metical</option>
                            <option value="MMK" <?php if (get_option('ec_option_braintree_currency') == "MMK") echo ' selected'; ?>>Myanmar Kyat</option>
                            
                            <option value="NAD" <?php if (get_option('ec_option_braintree_currency') == "NAD") echo ' selected'; ?>>Namibia Dollar</option>
                            <option value="NPR" <?php if (get_option('ec_option_braintree_currency') == "NPR") echo ' selected'; ?>>Nepalese Rupee</option>
                            <option value="ANG" <?php if (get_option('ec_option_braintree_currency') == "ANG") echo ' selected'; ?>>Netherlands Antillean Guilder</option>
                            <option value="PGK" <?php if (get_option('ec_option_braintree_currency') == "PGK") echo ' selected'; ?>>New Guinea Kina</option>
                            <option value="TWD" <?php if (get_option('ec_option_braintree_currency') == "TWD") echo ' selected'; ?>>New Taiwan Dollar</option>
                            <option value="TRY" <?php if (get_option('ec_option_braintree_currency') == "TRY") echo ' selected'; ?>>New Turkish Lira</option>
                            <option value="NZD" <?php if (get_option('ec_option_braintree_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                            <option value="NIO" <?php if (get_option('ec_option_braintree_currency') == "NIO") echo ' selected'; ?>>Nicaraguan Cordoba Oro</option>
                            <option value="NGN" <?php if (get_option('ec_option_braintree_currency') == "NGN") echo ' selected'; ?>>Nigerian Naira</option>
                            <option value="KPW" <?php if (get_option('ec_option_braintree_currency') == "KPW") echo ' selected'; ?>>North Korea Won</option>
                            <option value="NOK" <?php if (get_option('ec_option_braintree_currency') == "NOK") echo ' selected'; ?>>Norwegian Kroner</option>
                            
                            <option value="PKR" <?php if (get_option('ec_option_braintree_currency') == "PKR") echo ' selected'; ?>>Pakistan Rupee</option>
                            <option value="PAB" <?php if (get_option('ec_option_braintree_currency') == "PAB") echo ' selected'; ?>>Panamanian Balboa</option>
                            <option value="PYG" <?php if (get_option('ec_option_braintree_currency') == "PYG") echo ' selected'; ?>>Paraguay Guarani</option>
                            <option value="PEN" <?php if (get_option('ec_option_braintree_currency') == "PEN") echo ' selected'; ?>>Peruvian Nuevo Sol</option>
                            <option value="PHP" <?php if (get_option('ec_option_braintree_currency') == "PHP") echo ' selected'; ?>>Philippine Peso</option>
                            <option value="PLN" <?php if (get_option('ec_option_braintree_currency') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                            
                            <option value="QAR" <?php if (get_option('ec_option_braintree_currency') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                            
                            <option value="OMR" <?php if (get_option('ec_option_braintree_currency') == "OMR") echo ' selected'; ?>>Rial Omani</option>
                            <option value="RON" <?php if (get_option('ec_option_braintree_currency') == "RON") echo ' selected'; ?>>Romanian Leu</option>
                            <option value="RUB" <?php if (get_option('ec_option_braintree_currency') == "RUB") echo ' selected'; ?>>Russian Rouble</option>
                            <option value="RWF" <?php if (get_option('ec_option_braintree_currency') == "RWF") echo ' selected'; ?>>Rwanda Franc</option>
                            
                            
                            <option value="WST" <?php if (get_option('ec_option_braintree_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                            <option value="STD" <?php if (get_option('ec_option_braintree_currency') == "STD") echo ' selected'; ?>>Sao Tome/Principe Dobra</option>
                            <option value="SAR" <?php if (get_option('ec_option_braintree_currency') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                            <option value="RSD" <?php if (get_option('ec_option_braintree_currency') == "RSD") echo ' selected'; ?>>Serbian Dinar</option>
                            <option value="SCR" <?php if (get_option('ec_option_braintree_currency') == "SCR") echo ' selected'; ?>>Seychelles Rupee</option>
                            <option value="SLL" <?php if (get_option('ec_option_braintree_currency') == "SLL") echo ' selected'; ?>>Sierra Leone Leone</option>
                            <option value="SGD" <?php if (get_option('ec_option_braintree_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                            <option value="SKK" <?php if (get_option('ec_option_braintree_currency') == "SKK") echo ' selected'; ?>>Slovak Koruna</option>
                            <option value="SIT" <?php if (get_option('ec_option_braintree_currency') == "SIT") echo ' selected'; ?>>Slovenian Tolar</option>
                            <option value="SBD" <?php if (get_option('ec_option_braintree_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                            <option value="SOS" <?php if (get_option('ec_option_braintree_currency') == "SOS") echo ' selected'; ?>>Somalia Shilling</option>
                            <option value="ZAR" <?php if (get_option('ec_option_braintree_currency') == "ZAR") echo ' selected'; ?>>South African Rand</option>
                            <option value="KRW" <?php if (get_option('ec_option_braintree_currency') == "KRW") echo ' selected'; ?>>South-Korean Won</option>
                            <option value="LKR" <?php if (get_option('ec_option_braintree_currency') == "LKR") echo ' selected'; ?>>Sri Lanka Rupee</option>
                            <option value="SHP" <?php if (get_option('ec_option_braintree_currency') == "SHP") echo ' selected'; ?>>St. Helena Pound</option>
                            <option value="SDD" <?php if (get_option('ec_option_braintree_currency') == "SDD") echo ' selected'; ?>>Sudanese Dollar</option>
                            <option value="SRD" <?php if (get_option('ec_option_braintree_currency') == "SRD") echo ' selected'; ?>>Suriname Dollar</option>
                            <option value="SZL" <?php if (get_option('ec_option_braintree_currency') == "SZL") echo ' selected'; ?>>Swaziland Lilangeni</option>
                            <option value="SEK" <?php if (get_option('ec_option_braintree_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                            <option value="CHF" <?php if (get_option('ec_option_braintree_currency') == "CHF") echo ' selected'; ?>>Switzerland Franc</option>
                            <option value="SYP" <?php if (get_option('ec_option_braintree_currency') == "SYP") echo ' selected'; ?>>Syrian Arab Republic Pound</option>
                            
                            <option value="TJS" <?php if (get_option('ec_option_braintree_currency') == "TJS") echo ' selected'; ?>>Tajikistani Somoni</option>
                            <option value="TZS" <?php if (get_option('ec_option_braintree_currency') == "TZS") echo ' selected'; ?>>Tanzanian Shilling</option>
                            <option value="THB" <?php if (get_option('ec_option_braintree_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                            <option value="TOP" <?php if (get_option('ec_option_braintree_currency') == "TOP") echo ' selected'; ?>>Tonga Pa'anga</option>
                            <option value="TTD" <?php if (get_option('ec_option_braintree_currency') == "TTD") echo ' selected'; ?>>Trinidad/Tobago Dollar</option>
                            <option value="TND" <?php if (get_option('ec_option_braintree_currency') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                            <option value="TMM" <?php if (get_option('ec_option_braintree_currency') == "TMM") echo ' selected'; ?>>Turkmenistan Manat</option>
                            
                            <option value="UGX" <?php if (get_option('ec_option_braintree_currency') == "UGX") echo ' selected'; ?>>Uganda Shilling</option>
                            <option value="UAH" <?php if (get_option('ec_option_braintree_currency') == "UAH") echo ' selected'; ?>>Ukraine Hryvnia</option>
                            <option value="AED" <?php if (get_option('ec_option_braintree_currency') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                            <option value="UYU" <?php if (get_option('ec_option_braintree_currency') == "UYU") echo ' selected'; ?>>Uruguayo Peso</option>
                            <option value="UZS" <?php if (get_option('ec_option_braintree_currency') == "UZS") echo ' selected'; ?>>Uzbekistan Som</option>
                            
                            <option value="VUV" <?php if (get_option('ec_option_braintree_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                            <option value="VEF" <?php if (get_option('ec_option_braintree_currency') == "VEF") echo ' selected'; ?>>Venezuelan Bolivar Fuerte</option>
                            <option value="VND" <?php if (get_option('ec_option_braintree_currency') == "VND") echo ' selected'; ?>>Vietnamese Dong</option>
                            <option value="XOF" <?php if (get_option('ec_option_braintree_currency') == "XOF") echo ' selected'; ?>>West African CFA Franc BCEAO</option>
                            <option value="YER" <?php if (get_option('ec_option_braintree_currency') == "YER") echo ' selected'; ?>>Yemeni Rial</option>
                            
                            <option value="YUM" <?php if (get_option('ec_option_braintree_currency') == "YUm") echo ' selected'; ?>>Yugoslav New Dinar</option>
                            <option value="ZMK" <?php if (get_option('ec_option_braintree_currency') == "ZMK") echo ' selected'; ?>>Zambian Kwacha</option>
                            <option value="ZWD" <?php if (get_option('ec_option_braintree_currency') == "ZWD") echo ' selected'; ?>>Zimbabwean Dollar</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Braintree Environment:</td>
                          <td><select name="ec_option_braintree_environment" id="ec_option_braintree_environment">
                            <option value="sandbox" <?php if (get_option('ec_option_braintree_environment') == 'sandbox') echo ' selected'; ?>>Sandbox</option>
                            <option value="development" <?php if (get_option('ec_option_braintree_environment') == 'development') echo ' selected'; ?>>Development</option>
                            <option value="production" <?php if (get_option('ec_option_braintree_environment') == 'production') echo ' selected'; ?>>Production</option>
                            <option value="qa" <?php if (get_option('ec_option_braintree_environment') == 'qa') echo ' selected'; ?>>qa</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                
                <div class="ec_failed_row" id="goemerchant_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="goemerchant" id="goemerchant_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "goemerchant" ){ echo " checked=\"checked\""; } ?> /> GoeMerchant - <a href="https://secure.goemerchant.com/secure/application/apply.aspx" target="_blank">Need an Account?</a></div>
                <table id="goemerchant_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">GoeMerchant Transaction Center ID:</td>
                          <td width="74%"><input name="ec_option_goemerchant_trans_center_id"  id="ec_option_goemerchant_trans_center_id" type="text" value="<?php echo get_option('ec_option_goemerchant_trans_center_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">GoeMerchant Gateway ID:</td>
                          <td><input name="ec_option_goemerchant_gateway_id"  id="ec_option_goemerchant_gateway_id" type="text" value="<?php echo get_option('ec_option_goemerchant_gateway_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">GoeMerchant Processor ID:</td>
                          <td><input name="ec_option_goemerchant_processor_id"  id="ec_option_goemerchant_processor_id" type="text" value="<?php echo get_option('ec_option_goemerchant_processor_id'); ?>" style="width:250px;" /></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                
                
                <div class="ec_failed_row" id="paypal_pro_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="paypal_pro" id="paypal_pro_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "paypal_pro" ){ echo " checked=\"checked\""; } ?> /> PayPal Payflow Pro - <a href=\"https://www.paypal.com/webapps/mpp/country-worldwide\" target=\"_blank\">Accepted Countries</a> | <a href="https://www.paypal.com/?BN=LevelFourDevelopmentLLC_Cart" target="_blank">Need an Account?</a> </div>
                <table id="paypal_pro_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">PayPal Payflow Pro Partner:</td>
                          <td width="74%"><input name="ec_option_paypal_pro_partner"  id="ec_option_paypal_pro_partner" type="text" value="<?php echo get_option('ec_option_paypal_pro_partner'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payflow Pro User:</td>
                          <td><input name="ec_option_paypal_pro_user"  id="ec_option_paypal_pro_user" type="text" value="<?php echo get_option('ec_option_paypal_pro_user'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">PayPal Payflow Pro Vendor:</td>
                          <td width="74%"><input name="ec_option_paypal_pro_vendor" id="ec_option_paypal_pro_vendor"  type="text" value="<?php echo get_option('ec_option_paypal_pro_vendor'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payflow Pro Password:</td>
                          <td><input name="ec_option_paypal_pro_password"  id="ec_option_paypal_pro_password" type="text" value="<?php echo get_option('ec_option_paypal_pro_password'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payflow Pro Currency:</td>
                          <td>
                          <select name="ec_option_paypal_pro_currency" id="ec_option_paypal_pro_currency">
                            <option value="USD" <?php if (get_option('ec_option_paypal_pro_currency') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
                            <option value="AUD" <?php if (get_option('ec_option_paypal_pro_currency') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
                            <option value="BRL" <?php if (get_option('ec_option_paypal_pro_currency') == 'BRL') echo ' selected'; ?>>Brazilian Real</option>
                            <option value="CAD" <?php if (get_option('ec_option_paypal_pro_currency') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
                            <option value="CZK" <?php if (get_option('ec_option_paypal_pro_currency') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
                            <option value="CZK" <?php if (get_option('ec_option_paypal_pro_currency') == 'CZK') echo ' selected'; ?>>Danish Krone</option>
                            <option value="EUR" <?php if (get_option('ec_option_paypal_pro_currency') == 'EUR') echo ' selected'; ?>>Euro</option>
                            <option value="HKD" <?php if (get_option('ec_option_paypal_pro_currency') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
                            <option value="HUF" <?php if (get_option('ec_option_paypal_pro_currency') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
                            <option value="ILS" <?php if (get_option('ec_option_paypal_pro_currency') == 'ILS') echo ' selected'; ?>>Israeli New Sheqel</option>
                            <option value="JPY" <?php if (get_option('ec_option_paypal_pro_currency') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
                            <option value="MYR" <?php if (get_option('ec_option_paypal_pro_currency') == 'MYR') echo ' selected'; ?>>Malaysian Ringgit</option>
                            <option value="MXN" <?php if (get_option('ec_option_paypal_pro_currency') == 'MXN') echo ' selected'; ?>>Mexican Peso</option>
                            <option value="NOK" <?php if (get_option('ec_option_paypal_pro_currency') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
                            <option value="NZD" <?php if (get_option('ec_option_paypal_pro_currency') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
                            <option value="PHP" <?php if (get_option('ec_option_paypal_pro_currency') == 'PHP') echo ' selected'; ?>>Philippine Peso</option>
                            <option value="PLN" <?php if (get_option('ec_option_paypal_pro_currency') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
                            <option value="GBP" <?php if (get_option('ec_option_paypal_pro_currency') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
                            <option value="SGD" <?php if (get_option('ec_option_paypal_pro_currency') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
                            <option value="SEK" <?php if (get_option('ec_option_paypal_pro_currency') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
                            <option value="CHF" <?php if (get_option('ec_option_paypal_pro_currency') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
                            <option value="TWD" <?php if (get_option('ec_option_paypal_pro_currency') == 'TWD') echo ' selected'; ?>>Taiwan New Dollar</option>
                            <option value="THB" <?php if (get_option('ec_option_paypal_pro_currency') == 'THB') echo ' selected'; ?>>Thai Baht</option>
                            <option value="TRY" <?php if (get_option('ec_option_paypal_pro_currency') == 'TRY') echo ' selected'; ?>>Turkish Lira</option>
                          </select>
                           </td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payflow Pro Test Mode:</td>
                          <td><select name="ec_option_paypal_pro_test_mode" id="ec_option_paypal_pro_test_mode">
                            <option value="1" <?php if (get_option('ec_option_paypal_pro_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_paypal_pro_test_mode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="paypal_payments_pro_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="paypal_payments_pro" id="paypal_payments_pro_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "paypal_payments_pro" ){ echo " checked=\"checked\""; } ?> /> PayPal Payments Pro - <a href=\"https://www.paypal.com/webapps/mpp/country-worldwide\" target=\"_blank\">Accepted Countries</a> | <a href="https://www.paypal.com/?BN=LevelFourDevelopmentLLC_Cart" target="_blank">Need an Account?</a> </div>
                <table id="paypal_payments_pro_table" class="ec_payment_gateway_table">
                    <tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                       <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payments Pro User:</td>
                          <td><input name="ec_option_paypal_payments_pro_user"  id="ec_option_paypal_payments_pro_user" type="text" value="<?php echo get_option('ec_option_paypal_payments_pro_user'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payments Pro Password:</td>
                          <td><input name="ec_option_paypal_payments_pro_password"  id="ec_option_paypal_payments_pro_password" type="text" value="<?php echo get_option('ec_option_paypal_payments_pro_password'); ?>" style="width:250px;" /></td>
                        </tr>
                         <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">PayPal Payments Pro Signature:</td>
                          <td width="74%"><input name="ec_option_paypal_payments_pro_signature" id="ec_option_paypal_payments_pro_signature"  type="text" value="<?php echo get_option('ec_option_paypal_payments_pro_signature'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payments Pro Currency:</td>
                          <td>
                          <select name="ec_option_paypal_payments_pro_currency" id="ec_option_paypal_payments_pro_currency">
                            <option value="USD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
                            <option value="AUD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
                            <option value="CAD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
                            <option value="CZK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
                            <option value="DKK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'DKK') echo ' selected'; ?>>Danish Krone</option>
                            <option value="EUR" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'EUR') echo ' selected'; ?>>Euro</option>
                            <option value="HKD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
                            <option value="HUF" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
                            <option value="JPY" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
                            <option value="NOK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
                            <option value="NZD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
                            <option value="PLN" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
                            <option value="GBP" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
                            <option value="SGD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
                            <option value="SEK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
                            <option value="CHF" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
                          </select>
                          </td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">PayPal Payments Pro Test Mode:</td>
                          <td><select name="ec_option_paypal_payments_pro_test_mode" id="ec_option_paypal_payments_pro_test_mode">
                            <option value="1" <?php if (get_option('ec_option_paypal_payments_pro_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_paypal_payments_pro_test_mode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                
                
                <div class="ec_failed_row" id="realex_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="realex" id="realex_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "realex" ){ echo " checked=\"checked\""; } ?> /> Realex Payments - <a href="http://www.realexpayments.com/business-offering" target="_blank">Need an Account?</a></div>
                <table id="realex_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Realex Merchant ID:</td>
                          <td width="74%"><input name="ec_option_realex_merchant_id"  id="ec_option_realex_merchant_id" type="text" value="<?php echo get_option('ec_option_realex_merchant_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Realex Secret:</td>
                          <td width="74%"><input name="ec_option_realex_secret"  id="ec_option_realex_secret" type="text" value="<?php echo get_option('ec_option_realex_secret'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Realex Account:</td>
                          <td width="74%"><input name="ec_option_realex_account"  id="ec_option_realex_account" type="text" value="<?php echo get_option('ec_option_realex_account'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Realex Currency:</td>
                          <td width="74%"><select name="ec_option_realex_currency" id="ec_option_realex_currency">
                            <option value="GBP" <?php if (get_option('ec_option_realex_currency') == "GBP") echo ' selected'; ?>>GBP</option>
                            <option value="EUR" <?php if (get_option('ec_option_realex_currency') == "EUR") echo ' selected'; ?>>EUR</option>
                            <option value="USD" <?php if (get_option('ec_option_realex_currency') == "USD") echo ' selected'; ?>>USD</option>
                            <option value="DKK" <?php if (get_option('ec_option_realex_currency') == "DKK") echo ' selected'; ?>>DKK</option>
                            <option value="NOK" <?php if (get_option('ec_option_realex_currency') == "NOK") echo ' selected'; ?>>NOK</option>
                            <option value="CHF" <?php if (get_option('ec_option_realex_currency') == "CHF") echo ' selected'; ?>>CHF</option>
                            <option value="AUD" <?php if (get_option('ec_option_realex_currency') == "AUD") echo ' selected'; ?>>AUD</option>
                            <option value="CAD" <?php if (get_option('ec_option_realex_currency') == "CAD") echo ' selected'; ?>>CAD</option>
                            <option value="CZK" <?php if (get_option('ec_option_realex_currency') == "CZK") echo ' selected'; ?>>CZK</option>
                            <option value="JPY" <?php if (get_option('ec_option_realex_currency') == "JPY") echo ' selected'; ?>>JPY</option>
                            <option value="NZD" <?php if (get_option('ec_option_realex_currency') == "NZD") echo ' selected'; ?>>NZD</option>
                            <option value="HKD" <?php if (get_option('ec_option_realex_currency') == "HKD") echo ' selected'; ?>>HKD</option>
                            <option value="ZAR" <?php if (get_option('ec_option_realex_currency') == "ZAR") echo ' selected'; ?>>ZAR</option>
                            <option value="SEK" <?php if (get_option('ec_option_realex_currency') == "SEK") echo ' selected'; ?>>SEK</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="sagepay_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="sagepay" id="sagepay_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "sagepay" ){ echo " checked=\"checked\""; } ?> /> Sagepay - <a href="http://www.sagepay.com/online-payments" target="_blank">Need an Account?</a></div>
                <table id="sagepay_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="100%" class="itemheading" scope="row" colspan="2">3D Secure can be enabled in your Sagepay account. Once enabled, if the customer uses Visa or MasterCard AND their bank uses the Verified by Visa or MasterCard SecureCode systems, the customer will be redirected to their bank to complete the verification process. If this part fails, order will still be visible in their account and in your EasyCart Admin Console, but will say "Card Denied". If this happens you will need to follow up with your customer to process their payment again.</td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Sagepay Vendor:</td>
                          <td width="74%"><input name="ec_option_sagepay_vendor" id="ec_option_sagepay_vendor" type="text" value="<?php echo get_option('ec_option_sagepay_vendor'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Sagepay Currency:</td>
                          <td><select name="ec_option_sagepay_currency" id="ec_option_sagepay_currency">
                            <option value="AUD" <?php if (get_option('ec_option_sagepay_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                            <option value="CAD" <?php if (get_option('ec_option_sagepay_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                            <option value="CHF" <?php if (get_option('ec_option_sagepay_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                            <option value="DKK" <?php if (get_option('ec_option_sagepay_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                            <option value="EUR" <?php if (get_option('ec_option_sagepay_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                            <option value="GBP" <?php if (get_option('ec_option_sagepay_currency') == "GBP") echo ' selected'; ?>>Pound Sterling</option>
                            <option value="HKD" <?php if (get_option('ec_option_sagepay_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                            <option value="IDR" <?php if (get_option('ec_option_sagepay_currency') == "IDR") echo ' selected'; ?>>Rupiah</option>
                            <option value="JPY" <?php if (get_option('ec_option_sagepay_currency') == "JPY") echo ' selected'; ?>>Yen</option>
                            <option value="LUF" <?php if (get_option('ec_option_sagepay_currency') == "LUF") echo ' selected'; ?>>Luxembourg Franc</option>
                            <option value="NOK" <?php if (get_option('ec_option_sagepay_currency') == "NOK") echo ' selected'; ?>>Norwegian Krone</option>
                            <option value="NZD" <?php if (get_option('ec_option_sagepay_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                            <option value="SEK" <?php if (get_option('ec_option_sagepay_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                            <option value="SGD" <?php if (get_option('ec_option_sagepay_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                            <option value="TRL" <?php if (get_option('ec_option_sagepay_currency') == "TRL") echo ' selected'; ?>>Turkish Lira</option>
                            <option value="USD" <?php if (get_option('ec_option_sagepay_currency') == "USD") echo ' selected'; ?>>US Dollar</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Sagepay Simulator Only:</td>
                          <td><select name="ec_option_sagepay_simulator" id="ec_option_sagepay_simulator">
                            <option value="1" <?php if (get_option('ec_option_sagepay_simulator') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_sagepay_simulator') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Sagepay Test Mode:</td>
                          <td><select name="ec_option_sagepay_testmode" id="ec_option_sagepay_testmode">
                            <option value="1" <?php if (get_option('ec_option_sagepay_testmode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_sagepay_testmode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="firstdata_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="firstdata" id="firstdata_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "firstdata" ){ echo " checked=\"checked\""; } ?> /> First Data Global Gateway e4 - <a href="https://www.firstdata.com/en_us/products/merchants/ecommerce/online-payment-processing.html" target="_blank">Need an Account?</a></div>
                <table id="firstdata_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Firstdata e4 Exact ID (Gateway ID):</td>
                          <td width="74%"><input name="ec_option_firstdatae4_exact_id"  id="ec_option_firstdatae4_exact_id" type="text" value="<?php echo get_option('ec_option_firstdatae4_exact_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Firstdata e4 Password:</td>
                          <td width="74%"><input name="ec_option_firstdatae4_password"  id="ec_option_firstdatae4_password" type="text" value="<?php echo get_option('ec_option_firstdatae4_password'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Firstdata e4 Language:</td>
                          <td width="74%"><select name="ec_option_firstdatae4_language" id="ec_option_firstdatae4_language">
                            <option value="EN" <?php if (get_option('ec_option_firstdatae4_language') == "EN") echo ' selected'; ?>>EN</option>
                            <option value="FR" <?php if (get_option('ec_option_firstdatae4_language') == "FR") echo ' selected'; ?>>FR</option>
                            <option value="ES" <?php if (get_option('ec_option_firstdatae4_language') == "ES") echo ' selected'; ?>>ES</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Firstdata e4 Currency:</td>
                          <td width="74%"><select name="ec_option_firstdatae4_currency" id="ec_option_firstdatae4_currency">
                            <option value="USD" <?php if (get_option('ec_option_firstdatae4_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                            <option value="CAD" <?php if (get_option('ec_option_firstdatae4_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                            <option value="DEM" <?php if (get_option('ec_option_firstdatae4_currency') == "DEM") echo ' selected'; ?>>German Mark</option>
                            <option value="CHF" <?php if (get_option('ec_option_firstdatae4_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                            <option value="GBP" <?php if (get_option('ec_option_firstdatae4_currency') == "GBP") echo ' selected'; ?>>British Pound</option>
                            <option value="JPY" <?php if (get_option('ec_option_firstdatae4_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                            <option value="AFA" <?php if (get_option('ec_option_firstdatae4_currency') == "AFA") echo ' selected'; ?>>Afghanistan Afghani</option>
                            <option value="ALL" <?php if (get_option('ec_option_firstdatae4_currency') == "ALL") echo ' selected'; ?>>Albanian Lek</option>
                            <option value="DZD" <?php if (get_option('ec_option_firstdatae4_currency') == "DZD") echo ' selected'; ?>>Algerian Dinar</option>
                            <option value="ADF" <?php if (get_option('ec_option_firstdatae4_currency') == "ADF") echo ' selected'; ?>>Andorran Franc</option>
                            <option value="ADP" <?php if (get_option('ec_option_firstdatae4_currency') == "ADP") echo ' selected'; ?>>Andorran Peseta</option>
                            <option value="AON" <?php if (get_option('ec_option_firstdatae4_currency') == "AON") echo ' selected'; ?>>Angolan New Kwanza</option>
                            <option value="ARS" <?php if (get_option('ec_option_firstdatae4_currency') == "ARS") echo ' selected'; ?>>Argentine Peso</option>
                            <option value="AWG" <?php if (get_option('ec_option_firstdatae4_currency') == "AWG") echo ' selected'; ?>>Aruban Florin</option>
                            <option value="AUD" <?php if (get_option('ec_option_firstdatae4_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                            <option value="ATS" <?php if (get_option('ec_option_firstdatae4_currency') == "ATS") echo ' selected'; ?>>Austrian Schilling</option>
                            <option value="BSD" <?php if (get_option('ec_option_firstdatae4_currency') == "BSD") echo ' selected'; ?>>Bahamanian Dollar</option>
                            <option value="BHD" <?php if (get_option('ec_option_firstdatae4_currency') == "BHD") echo ' selected'; ?>>Bahraini Dinar</option>
                            <option value="BDT" <?php if (get_option('ec_option_firstdatae4_currency') == "BDT") echo ' selected'; ?>>Bangladeshi Taka</option>
                            <option value="BBD" <?php if (get_option('ec_option_firstdatae4_currency') == "BBD") echo ' selected'; ?>>Barbados Dollar</option>
                            <option value="BEF" <?php if (get_option('ec_option_firstdatae4_currency') == "BEF") echo ' selected'; ?>>Belgian Franc</option>
                            <option value="BZD" <?php if (get_option('ec_option_firstdatae4_currency') == "BZD") echo ' selected'; ?>>Belize Dollar</option>
                            <option value="BMD" <?php if (get_option('ec_option_firstdatae4_currency') == "BMD") echo ' selected'; ?>>Bermudian Dollar</option>
                            <option value="BTN" <?php if (get_option('ec_option_firstdatae4_currency') == "BTN") echo ' selected'; ?>>Bhutan Ngultrum</option>
                            <option value="BOB" <?php if (get_option('ec_option_firstdatae4_currency') == "BOB") echo ' selected'; ?>>Bolivian Boliviano</option>
                            <option value="BWP" <?php if (get_option('ec_option_firstdatae4_currency') == "BWP") echo ' selected'; ?>>Botswana Pula</option>
                            <option value="BRL" <?php if (get_option('ec_option_firstdatae4_currency') == "BRL") echo ' selected'; ?>>Brazilian Real</option>
                            <option value="BND" <?php if (get_option('ec_option_firstdatae4_currency') == "BND") echo ' selected'; ?>>Brunei Dollar</option>
                            <option value="BGL" <?php if (get_option('ec_option_firstdatae4_currency') == "BGL") echo ' selected'; ?>>Bulgarian Lev</option>
                            <option value="BIF" <?php if (get_option('ec_option_firstdatae4_currency') == "BIF") echo ' selected'; ?>>Burundi Franc</option>
                            <option value="XOF" <?php if (get_option('ec_option_firstdatae4_currency') == "XOF") echo ' selected'; ?>>CFA Franc BCEAO</option>
                            <option value="XAF" <?php if (get_option('ec_option_firstdatae4_currency') == "XAF") echo ' selected'; ?>>CFA Franc BEAC</option>
                            <option value="KHR" <?php if (get_option('ec_option_firstdatae4_currency') == "KHR") echo ' selected'; ?>>Cambodian Riel</option>
                            <option value="CVE" <?php if (get_option('ec_option_firstdatae4_currency') == "CVE") echo ' selected'; ?>>Cape Verde Escudo</option>
                            <option value="KYD" <?php if (get_option('ec_option_firstdatae4_currency') == "KYD") echo ' selected'; ?>>Cayman Islands Dollar</option>
                            <option value="CLP" <?php if (get_option('ec_option_firstdatae4_currency') == "CLP") echo ' selected'; ?>>Chilean Peso</option>
                            <option value="CNY" <?php if (get_option('ec_option_firstdatae4_currency') == "CNY") echo ' selected'; ?>>Chinese Yuan Renminbi</option>
                            <option value="COP" <?php if (get_option('ec_option_firstdatae4_currency') == "COP") echo ' selected'; ?>>Colombian Peso</option>
                            <option value="KMF" <?php if (get_option('ec_option_firstdatae4_currency') == "KMF") echo ' selected'; ?>>Comoros Franc</option>
                            <option value="CRC" <?php if (get_option('ec_option_firstdatae4_currency') == "CRC") echo ' selected'; ?>>Costa Rican Colon</option>
                            <option value="HRK" <?php if (get_option('ec_option_firstdatae4_currency') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                            <option value="CYP" <?php if (get_option('ec_option_firstdatae4_currency') == "CYP") echo ' selected'; ?>>Cyprus Pound</option>
                            <option value="CSK" <?php if (get_option('ec_option_firstdatae4_currency') == "CSK") echo ' selected'; ?>>Czech Koruna</option>
                            <option value="DKK" <?php if (get_option('ec_option_firstdatae4_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                            <option value="DJF" <?php if (get_option('ec_option_firstdatae4_currency') == "DJF") echo ' selected'; ?>>Djibouti Franc</option>
                            <option value="DOP" <?php if (get_option('ec_option_firstdatae4_currency') == "DOP") echo ' selected'; ?>>Dominican Peso</option>
                            <option value="NLG" <?php if (get_option('ec_option_firstdatae4_currency') == "NLG") echo ' selected'; ?>>Dutch Guilder</option>
                            <option value="XEU" <?php if (get_option('ec_option_firstdatae4_currency') == "XEU") echo ' selected'; ?>>ECU</option>
                            <option value="ECS" <?php if (get_option('ec_option_firstdatae4_currency') == "ECE") echo ' selected'; ?>>Ecuador Sucre</option>
                            <option value="EGP" <?php if (get_option('ec_option_firstdatae4_currency') == "EGP") echo ' selected'; ?>>Egyptian Pound</option>
                            <option value="SVC" <?php if (get_option('ec_option_firstdatae4_currency') == "SVC") echo ' selected'; ?>>El Salvador Colon</option>
                            <option value="EEK" <?php if (get_option('ec_option_firstdatae4_currency') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                            <option value="ETB" <?php if (get_option('ec_option_firstdatae4_currency') == "ETB") echo ' selected'; ?>>Ethiopian Birr</option>
                            <option value="EUR" <?php if (get_option('ec_option_firstdatae4_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                            <option value="FKP" <?php if (get_option('ec_option_firstdatae4_currency') == "FKP") echo ' selected'; ?>>Falkland Islands Pound</option>
                            <option value="FJD" <?php if (get_option('ec_option_firstdatae4_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                            <option value="FIM" <?php if (get_option('ec_option_firstdatae4_currency') == "FTM") echo ' selected'; ?>>Finnish Markka</option>
                            <option value="FRF" <?php if (get_option('ec_option_firstdatae4_currency') == "FRF") echo ' selected'; ?>>French Franc</option>
                            <option value="GMD" <?php if (get_option('ec_option_firstdatae4_currency') == "GMD") echo ' selected'; ?>>Gambian Dalasi</option>
                            <option value="GHC" <?php if (get_option('ec_option_firstdatae4_currency') == "GHC") echo ' selected'; ?>>Ghanaian Cedi</option>
                            <option value="GIP" <?php if (get_option('ec_option_firstdatae4_currency') == "GIP") echo ' selected'; ?>>Gibraltar Pound</option>
                            <option value="XAU" <?php if (get_option('ec_option_firstdatae4_currency') == "XAU") echo ' selected'; ?>>Gold (oz.)</option>
                            <option value="GRD" <?php if (get_option('ec_option_firstdatae4_currency') == "GRD") echo ' selected'; ?>>Greek Drachma</option>
                            <option value="GTQ" <?php if (get_option('ec_option_firstdatae4_currency') == "GTQ") echo ' selected'; ?>>Guatemalan Quetzal</option>
                            <option value="GNF" <?php if (get_option('ec_option_firstdatae4_currency') == "GNF") echo ' selected'; ?>>Guinea Franc</option>
                            <option value="GYD" <?php if (get_option('ec_option_firstdatae4_currency') == "GYD") echo ' selected'; ?>>Guyanan Dollar</option>
                            <option value="HTG" <?php if (get_option('ec_option_firstdatae4_currency') == "HTG") echo ' selected'; ?>>Haitian Gourde</option>
                            <option value="HNL" <?php if (get_option('ec_option_firstdatae4_currency') == "HNL") echo ' selected'; ?>>Honduran Lempira</option>
                            <option value="HKD" <?php if (get_option('ec_option_firstdatae4_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                            <option value="HUF" <?php if (get_option('ec_option_firstdatae4_currency') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                            <option value="ISK" <?php if (get_option('ec_option_firstdatae4_currency') == "ISK") echo ' selected'; ?>>Iceland Krona</option>
                            <option value="INR" <?php if (get_option('ec_option_firstdatae4_currency') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                            <option value="IDR" <?php if (get_option('ec_option_firstdatae4_currency') == "IDR") echo ' selected'; ?>>Indonesian Rupiah</option>
                            <option value="IEP" <?php if (get_option('ec_option_firstdatae4_currency') == "IEP") echo ' selected'; ?>>Irish Punt</option>
                            <option value="ILS" <?php if (get_option('ec_option_firstdatae4_currency') == "ILS") echo ' selected'; ?>>Israeli New Shekel</option>
                            <option value="ITL" <?php if (get_option('ec_option_firstdatae4_currency') == "ITL") echo ' selected'; ?>>Italian Lira</option>
                            <option value="JMD" <?php if (get_option('ec_option_firstdatae4_currency') == "JMD") echo ' selected'; ?>>Jamaican Dollar</option>
                            <option value="JOD" <?php if (get_option('ec_option_firstdatae4_currency') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                            <option value="KZT" <?php if (get_option('ec_option_firstdatae4_currency') == "KZT") echo ' selected'; ?>>Kazakhstan Tenge</option>
                            <option value="KES" <?php if (get_option('ec_option_firstdatae4_currency') == "KES") echo ' selected'; ?>>Kenyan Shilling</option>
                            <option value="KWD" <?php if (get_option('ec_option_firstdatae4_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                            <option value="LAK" <?php if (get_option('ec_option_firstdatae4_currency') == "LAK") echo ' selected'; ?>>Lao Kip</option>
                            <option value="LVL" <?php if (get_option('ec_option_firstdatae4_currency') == "LVL") echo ' selected'; ?>>Latvian Lats</option>
                            <option value="LSL" <?php if (get_option('ec_option_firstdatae4_currency') == "LSL") echo ' selected'; ?>>Lesotho Loti</option>
                            <option value="LRD" <?php if (get_option('ec_option_firstdatae4_currency') == "LRD") echo ' selected'; ?>>Liberian Dollar</option>
                            <option value="LTL" <?php if (get_option('ec_option_firstdatae4_currency') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                            <option value="LUF" <?php if (get_option('ec_option_firstdatae4_currency') == "LUF") echo ' selected'; ?>>Luxembourg Franc</option>
                            <option value="MOP" <?php if (get_option('ec_option_firstdatae4_currency') == "MOP") echo ' selected'; ?>>Macau Pataca</option>
                            <option value="MGF" <?php if (get_option('ec_option_firstdatae4_currency') == "MGF") echo ' selected'; ?>>Malagasy Franc</option>
                            <option value="MWK" <?php if (get_option('ec_option_firstdatae4_currency') == "MWK") echo ' selected'; ?>>Malawi Kwacha</option>
                            <option value="MYR" <?php if (get_option('ec_option_firstdatae4_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                            <option value="MVR" <?php if (get_option('ec_option_firstdatae4_currency') == "MVR") echo ' selected'; ?>>Maldive Rufiyaa</option>
                            <option value="MTL" <?php if (get_option('ec_option_firstdatae4_currency') == "MRL") echo ' selected'; ?>>Maltese Lira</option>
                            <option value="MRO" <?php if (get_option('ec_option_firstdatae4_currency') == "MRO") echo ' selected'; ?>>Mauritanian Ouguiya</option>
                            <option value="MUR" <?php if (get_option('ec_option_firstdatae4_currency') == "MUR") echo ' selected'; ?>>Mauritius Rupee</option>
                            <option value="MXN" <?php if (get_option('ec_option_firstdatae4_currency') == "MXN") echo ' selected'; ?>>Mexican Peso</option>
                            <option value="MNT" <?php if (get_option('ec_option_firstdatae4_currency') == "MNT") echo ' selected'; ?>>Mongolian Tugrik</option>
                            <option value="MAD" <?php if (get_option('ec_option_firstdatae4_currency') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                            <option value="MZM" <?php if (get_option('ec_option_firstdatae4_currency') == "MZM") echo ' selected'; ?>>Mozambique Metical</option>
                            <option value="MMK" <?php if (get_option('ec_option_firstdatae4_currency') == "MMK") echo ' selected'; ?>>Myanmar Kyat</option>
                            <option value="ANG" <?php if (get_option('ec_option_firstdatae4_currency') == "ANG") echo ' selected'; ?>>NL Antillian Guilder</option>
                            <option value="NAD" <?php if (get_option('ec_option_firstdatae4_currency') == "NAD") echo ' selected'; ?>>Namibia Dollar</option>
                            <option value="NPR" <?php if (get_option('ec_option_firstdatae4_currency') == "NPR") echo ' selected'; ?>>Nepalese Rupee</option>
                            <option value="NZD" <?php if (get_option('ec_option_firstdatae4_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                            <option value="NIO" <?php if (get_option('ec_option_firstdatae4_currency') == "NIO") echo ' selected'; ?>>Nicaraguan Cordoba Oro</option>
                            <option value="NGN" <?php if (get_option('ec_option_firstdatae4_currency') == "NGN") echo ' selected'; ?>>Nigerian Naira</option>
                            <option value="NOK" <?php if (get_option('ec_option_firstdatae4_currency') == "NOK") echo ' selected'; ?>>Norwegian Kroner</option>
                            <option value="OMR" <?php if (get_option('ec_option_firstdatae4_currency') == "OMR") echo ' selected'; ?>>Omani Rial</option>
                            <option value="PKR" <?php if (get_option('ec_option_firstdatae4_currency') == "PKR") echo ' selected'; ?>>Pakistan Rupee</option>
                            <option value="XPD" <?php if (get_option('ec_option_firstdatae4_currency') == "XPD") echo ' selected'; ?>>Palladium (oz.)</option>
                            <option value="PAB" <?php if (get_option('ec_option_firstdatae4_currency') == "PAB") echo ' selected'; ?>>Panamanian Balboa</option>
                            <option value="PGK" <?php if (get_option('ec_option_firstdatae4_currency') == "PGK") echo ' selected'; ?>>Papua New Guinea Kina</option>
                            <option value="PYG" <?php if (get_option('ec_option_firstdatae4_currency') == "PYG") echo ' selected'; ?>>Paraguay Guarani</option>
                            <option value="PEN" <?php if (get_option('ec_option_firstdatae4_currency') == "PEN") echo ' selected'; ?>>Peruvian Nuevo Sol</option>
                            <option value="PHP" <?php if (get_option('ec_option_firstdatae4_currency') == "PHP") echo ' selected'; ?>>Philippine Peso</option>
                            <option value="XPT" <?php if (get_option('ec_option_firstdatae4_currency') == "XPT") echo ' selected'; ?>>Platinum (oz.)</option>
                            <option value="PLN" <?php if (get_option('ec_option_firstdatae4_currency') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                            <option value="PTE" <?php if (get_option('ec_option_firstdatae4_currency') == "PTE") echo ' selected'; ?>>Portuguese Escudo</option>
                            <option value="QAR" <?php if (get_option('ec_option_firstdatae4_currency') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                            <option value="ROL" <?php if (get_option('ec_option_firstdatae4_currency') == "ROL") echo ' selected'; ?>>Romanian Leu</option>
                            <option value="RUB" <?php if (get_option('ec_option_firstdatae4_currency') == "RUB") echo ' selected'; ?>>Russian Rouble</option>
                            <option value="WST" <?php if (get_option('ec_option_firstdatae4_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                            <option value="STD" <?php if (get_option('ec_option_firstdatae4_currency') == "STD") echo ' selected'; ?>>Sao Tome/Principe Dobra</option>
                            <option value="SAR" <?php if (get_option('ec_option_firstdatae4_currency') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                            <option value="SCR" <?php if (get_option('ec_option_firstdatae4_currency') == "SCR") echo ' selected'; ?>>Seychelles Rupee</option>
                            <option value="SLL" <?php if (get_option('ec_option_firstdatae4_currency') == "SLL") echo ' selected'; ?>>Sierra Leone Leone</option>
                            <option value="XAG" <?php if (get_option('ec_option_firstdatae4_currency') == "XAG") echo ' selected'; ?>>Silver (oz.)</option>
                            <option value="SGD" <?php if (get_option('ec_option_firstdatae4_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                            <option value="SKK" <?php if (get_option('ec_option_firstdatae4_currency') == "SKK") echo ' selected'; ?>>Slovak Koruna</option>
                            <option value="SIT" <?php if (get_option('ec_option_firstdatae4_currency') == "SIT") echo ' selected'; ?>>Slovenian Tolar</option>
                            <option value="SBD" <?php if (get_option('ec_option_firstdatae4_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                            <option value="ZAR" <?php if (get_option('ec_option_firstdatae4_currency') == "ZAR") echo ' selected'; ?>>South African Rand</option>
                            <option value="KRW" <?php if (get_option('ec_option_firstdatae4_currency') == "KRW") echo ' selected'; ?>>South-Korean Won</option>
                            <option value="ESP" <?php if (get_option('ec_option_firstdatae4_currency') == "ESP") echo ' selected'; ?>>Spanish Peseta</option>
                            <option value="LKR" <?php if (get_option('ec_option_firstdatae4_currency') == "LKR") echo ' selected'; ?>>Sri Lanka Rupee</option>
                            <option value="SHP" <?php if (get_option('ec_option_firstdatae4_currency') == "SHP") echo ' selected'; ?>>St. Helena Pound</option>
                            <option value="SRG" <?php if (get_option('ec_option_firstdatae4_currency') == "SRG") echo ' selected'; ?>>Suriname Guilder</option>
                            <option value="SZL" <?php if (get_option('ec_option_firstdatae4_currency') == "SZL") echo ' selected'; ?>>Swaziland Lilangeni</option>
                            <option value="SEK" <?php if (get_option('ec_option_firstdatae4_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                            <option value="TWD" <?php if (get_option('ec_option_firstdatae4_currency') == "TWS") echo ' selected'; ?>>Taiwan Dollar</option>
                            <option value="TZS" <?php if (get_option('ec_option_firstdatae4_currency') == "TZS") echo ' selected'; ?>>Tanzanian Shilling</option>
                            <option value="THB" <?php if (get_option('ec_option_firstdatae4_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                            <option value="TOP" <?php if (get_option('ec_option_firstdatae4_currency') == "TOP") echo ' selected'; ?>>Tonga Pa'anga</option>
                            <option value="TTD" <?php if (get_option('ec_option_firstdatae4_currency') == "TTD") echo ' selected'; ?>>Trinidad/Tobago Dollar</option>
                            <option value="TND" <?php if (get_option('ec_option_firstdatae4_currency') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                            <option value="TRL" <?php if (get_option('ec_option_firstdatae4_currency') == "TRL") echo ' selected'; ?>>Turkish Lira</option>
                            <option value="UGS" <?php if (get_option('ec_option_firstdatae4_currency') == "UGS") echo ' selected'; ?>>Uganda Shilling</option>
                            <option value="UAH" <?php if (get_option('ec_option_firstdatae4_currency') == "UAH") echo ' selected'; ?>>Ukraine Hryvnia</option>
                            <option value="UYP" <?php if (get_option('ec_option_firstdatae4_currency') == "UYP") echo ' selected'; ?>>Uruguayan Peso</option>
                            <option value="AED" <?php if (get_option('ec_option_firstdatae4_currency') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                            <option value="VUV" <?php if (get_option('ec_option_firstdatae4_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                            <option value="VEB" <?php if (get_option('ec_option_firstdatae4_currency') == "VEB") echo ' selected'; ?>>Venezuelan Bolivar</option>
                            <option value="VND" <?php if (get_option('ec_option_firstdatae4_currency') == "VND") echo ' selected'; ?>>Vietnamese Dong</option>
                            <option value="YUN" <?php if (get_option('ec_option_firstdatae4_currency') == "YUN") echo ' selected'; ?>>Yugoslav Dinar</option>
                            <option value="ZMK" <?php if (get_option('ec_option_firstdatae4_currency') == "ZMK") echo ' selected'; ?>>Zambian Kwacha</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Firstdata e4 Test Mode:</td>
                          <td><select name="ec_option_firstdatae4_test_mode" id="ec_option_firstdatae4_test_mode">
                            <option value="1" <?php if (get_option('ec_option_firstdatae4_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_firstdatae4_test_mode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="paymentexpress_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="paymentexpress" id="paymentexpress_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "paymentexpress" ){ echo " checked=\"checked\""; } ?> /> PaymentExpress PxPost - <a href="https://sec.paymentexpress.com/pxmi/apply" target="_blank">Need an Account?</a></div>
                <table id="paymentexpress_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Payment Express User Name:</td>
                          <td width="74%"><input name="ec_option_payment_express_username"  id="ec_option_payment_express_username" type="text" value="<?php echo get_option('ec_option_payment_express_username'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Payment Express Password:</td>
                          <td><input name="ec_option_payment_express_password"  id="ec_option_payment_express_password" type="text" value="<?php echo get_option('ec_option_payment_express_password'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Payment Express Currency:</td>
                          <td>
                          <select name="ec_option_payment_express_currency" id="ec_option_payment_express_currency">
                            <option value="USD" <?php if (get_option('ec_option_payment_express_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                            <option value="CAD" <?php if (get_option('ec_option_payment_express_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                            <option value="CHF" <?php if (get_option('ec_option_payment_express_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                            <option value="DKK" <?php if (get_option('ec_option_payment_express_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                            <option value="EUR" <?php if (get_option('ec_option_payment_express_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                            <option value="FRF" <?php if (get_option('ec_option_payment_express_currency') == "FRF") echo ' selected'; ?>>French Franc</option>
                            <option value="GBP" <?php if (get_option('ec_option_payment_express_currency') == "GBP") echo ' selected'; ?>>United Kingdom Pound</option>
                            <option value="HKD" <?php if (get_option('ec_option_payment_express_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                            <option value="JPY" <?php if (get_option('ec_option_payment_express_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                            <option value="NZD" <?php if (get_option('ec_option_payment_express_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                            <option value="SGD" <?php if (get_option('ec_option_payment_express_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                            <option value="THB" <?php if (get_option('ec_option_payment_express_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                            <option value="ZAR" <?php if (get_option('ec_option_payment_express_currency') == "ZAR") echo ' selected'; ?>>Rand</option>
                            <option value="AUD" <?php if (get_option('ec_option_payment_express_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                            <option value="WST" <?php if (get_option('ec_option_payment_express_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                            <option value="VUV" <?php if (get_option('ec_option_payment_express_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                            <option value="TOP" <?php if (get_option('ec_option_payment_express_currency') == "TOP") echo ' selected'; ?>>Tongan Pa'anga</option>
                            <option value="SBD" <?php if (get_option('ec_option_payment_express_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                            <option value="PGK" <?php if (get_option('ec_option_payment_express_currency') == "PGK") echo ' selected'; ?>>Papua New Guinea Kina</option>
                            <option value="MYR" <?php if (get_option('ec_option_payment_express_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                            <option value="KWD" <?php if (get_option('ec_option_payment_express_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                            <option value="FJD" <?php if (get_option('ec_option_payment_express_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                            
                          </select>
                          </td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="chronopay_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="chronopay" id="chronopay_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "chronopay" ){ echo " checked=\"checked\""; } ?> /> Chronopay - <a href="https://client.chronopay.com/en/registration" target="_blank">Need an Account?</a></div>
                <table id="chronopay_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Chronopay Currency:</td>
                          <td width="74%"><input name="ec_option_chronopay_currency"  id="ec_option_chronopay_currency"  type="text" value="<?php echo get_option('ec_option_chronopay_currency'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Chronopay Product ID:</td>
                          <td><input name="ec_option_chronopay_product_id"  id="ec_option_chronopay_product_id" type="text" value="<?php echo get_option('ec_option_chronopay_product_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Chronopay Shared Secret:</td>
                          <td><input name="ec_option_chronopay_shared_secret"  id="ec_option_chronopay_shared_secret" type="text" value="<?php echo get_option('ec_option_chronopay_shared_secret'); ?>" style="width:250px;" /></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="eway_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="eway" id="eway_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "eway" ){ echo " checked=\"checked\""; } ?> /> eWAY - <a href="http://quote.eway.com.au/" target="_blank">Need an Account?</a></div>
                <table id="eway_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Eway Customer ID:</td>
                          <td width="74%"><input name="ec_option_eway_customer_id"  id="ec_option_eway_customer_id" type="text" value="<?php echo get_option('ec_option_eway_customer_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Eway Test Mode:</td>
                          <td><select name="ec_option_eway_test_mode" id="ec_option_eway_test_mode">
                            <option value="1" <?php if (get_option('ec_option_eway_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_eway_test_mode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Eway Test Mode Process Successful Transaction:</td>
                          <td><select name="ec_option_eway_test_mode_success" id="ec_option_eway_test_mode_success">
                            <option value="1" <?php if (get_option('ec_option_eway_test_mode_success') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_eway_test_mode_success') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="paypoint_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="paypoint" id="paypoint_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "paypoint" ){ echo " checked=\"checked\""; } ?> /> PayPoint.net - <a href="https://www.paypoint.net/signup" target="_blank">Need an Account?</a></div>
                <table id="paypoint_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">Paypoint Merchant ID:</td>
                          <td width="74%"><input name="ec_option_paypoint_merchant_id"  id="ec_option_paypoint_merchant_id" type="text" value="<?php echo get_option('ec_option_paypoint_merchant_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Paypoint VPN Password:</td>
                          <td><input name="ec_option_paypoint_vpn_password" id="ec_option_paypoint_vpn_password" type="text" value="<?php echo get_option('ec_option_paypoint_vpn_password'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">Paypoint Test Mode:</td>
                          <td><select name="ec_option_paypoint_test_mode" id="ec_option_paypoint_test_mode">
                            <option value="1" <?php if (get_option('ec_option_paypoint_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_paypoint_test_mode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                <div class="ec_failed_row" id="securepay_row"><input type="radio" name="ec_option_payment_process_method" onchange="update_credit_card_form();" value="securepay" id="securepay_radio"<?php if ( get_option( 'ec_option_payment_process_method') == "securepay" ){ echo " checked=\"checked\""; } ?> /> SecurePay - <a href="https://vault.securepay.com.au/ecommerce/sign-up/" target="_blank">Need an Account?</a></div>
                <table id="securepay_table" class="ec_payment_gateway_table">
                	<tr valign="top" class="form-table">
                      <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr valign="top" class="form-table">
                          <td width="26%" class="itemheading" scope="row">SecurePay Merchant ID:</td>
                          <td width="74%"><input name="ec_option_securepay_merchant_id"  id="ec_option_securepay_merchant_id" type="text" value="<?php echo get_option('ec_option_securepay_merchant_id'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">SecurePay Password:</td>
                          <td><input name="ec_option_securepay_password"  id="ec_option_securepay_password" type="text" value="<?php echo get_option('ec_option_securepay_password'); ?>" style="width:250px;" /></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">SecurePay Currency:</td>
                          <td><select name="ec_option_securepay_currency" id="ec_option_securepay_currency">
                            <option value="AUD" <?php if (get_option('ec_option_securepay_test_mode') == "AUD") echo ' selected'; ?>>AUD</option>
                            <option value="CAD" <?php if (get_option('ec_option_securepay_test_mode') == "CAD") echo ' selected'; ?>>CAD</option>
                            <option value="CHF" <?php if (get_option('ec_option_securepay_test_mode') == "CHF") echo ' selected'; ?>>CHF</option>
                            <option value="EUR" <?php if (get_option('ec_option_securepay_test_mode') == "EUR") echo ' selected'; ?>>EUR</option>
                            <option value="GBP" <?php if (get_option('ec_option_securepay_test_mode') == "GBP") echo ' selected'; ?>>GBP</option>
                            <option value="HKD" <?php if (get_option('ec_option_securepay_test_mode') == "HKD") echo ' selected'; ?>>HKD</option>
                            <option value="JPY" <?php if (get_option('ec_option_securepay_test_mode') == "CHF") echo ' selected'; ?>>JPY</option>
                            <option value="NZD" <?php if (get_option('ec_option_securepay_test_mode') == "NZD") echo ' selected'; ?>>NZD</option>
                            <option value="SGD" <?php if (get_option('ec_option_securepay_test_mode') == "SGD") echo ' selected'; ?>>SGD</option>
                            <option value="USD" <?php if (get_option('ec_option_securepay_test_mode') == "USD") echo ' selected'; ?>>USD</option>
                          </select></td>
                        </tr>
                        <tr valign="top" class="form-table">
                          <td class="itemheading" scope="row">SecurePay Test Mode:</td>
                          <td><select name="ec_option_securepay_test_mode" id="ec_option_securepay_test_mode">
                            <option value="1" <?php if (get_option('ec_option_securepay_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                            <option value="0" <?php if (get_option('ec_option_securepay_test_mode') == 0) echo ' selected'; ?>>No</option>
                          </select></td>
                        </tr>
                      </table></td>
                    </tr>
                </table>
                
                <div class="ec_failed_row" id="ec_select_cc_label">Please Select the Credit Card Types You Would Like to Accept:</div>
                <div class="ec_failed_row" id="visa_row"><input type="checkbox" value="1" name="ec_option_use_visa" id="visa_checkbox"<?php if( get_option( 'ec_option_use_visa' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Visa</div>
                <div class="ec_failed_row" id="delta_row"><input type="checkbox" value="1" name="ec_option_use_delta" id="delta_checkbox"<?php if( get_option( 'ec_option_use_delta' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Visa Debit/Delta</div>
                <div class="ec_failed_row" id="uke_row"><input type="checkbox" value="1" name="ec_option_use_uke" id="uke_checkbox"<?php if( get_option( 'ec_option_use_uke' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Visa Electron</div>
                <div class="ec_failed_row" id="discover_row"><input type="checkbox" value="1" name="ec_option_use_discover" id="discover_checkbox"<?php if( get_option( 'ec_option_use_discover' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Discover</div>
                <div class="ec_failed_row" id="mastercard_row"><input type="checkbox" value="1" name="ec_option_use_mastercard" id="mastercard_checkbox"<?php if( get_option( 'ec_option_use_mastercard' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Mastercard</div>
                <div class="ec_failed_row" id="mcdebit_row"><input type="checkbox" value="1" name="ec_option_use_mcdebit" id="mcdebit_checkbox"<?php if( get_option( 'ec_option_use_mcdebit' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Mastercard Debit</div>
                <div class="ec_failed_row" id="amex_row"><input type="checkbox" value="1" name="ec_option_use_amex" id="amex_checkbox"<?php if( get_option( 'ec_option_use_amex' ) == "1" ){ echo " checked=\"checked\""; } ?> /> American Express</div>
                <div class="ec_failed_row" id="jcb_row"><input type="checkbox" value="1" name="ec_option_use_jcb" id="jcb_checkbox"<?php if( get_option( 'ec_option_use_jcb' ) == "1" ){ echo " checked=\"checked\""; } ?> /> JCB</div>
                <div class="ec_failed_row" id="diners_row"><input type="checkbox" value="1" name="ec_option_use_diners" id="diners_checkbox"<?php if( get_option( 'ec_option_use_diners' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Diners</div>
                <div class="ec_failed_row" id="laser_row"><input type="checkbox" value="1" name="ec_option_use_laser" id="laser_checkbox"<?php if( get_option( 'ec_option_use_laser' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Laser</div>
                <div class="ec_failed_row" id="maestro_row"><input type="checkbox" value="1" name="ec_option_use_maestro" id="maestro_checkbox"<?php if( get_option( 'ec_option_use_maestro' ) == "1" ){ echo " checked=\"checked\""; } ?> /> Maestro</div>
                
                <input type="hidden" name="ec_action" value="update_credit_card" />
                <input type="submit" class="button-primary" value="Update Your Live Payment Gateway Settings!" />
            </form>
            
            <script>
				function update_credit_card_form( ){
					var use_live = document.getElementById( 'ec_option_checklist_credit_card' ).value;
					var is_licensed = true;
					var location = document.getElementById( 'ec_option_checklist_credit_card_location' ).value;
					if( document.getElementById( 'no_full_license' ) )	is_licensed = false;
					
					ec_gateways_hide_all( );
					if( use_live == "yes" ){
						if( !is_licensed ){
							jQuery( "#no_full_license" ).show( );
						}else{
							jQuery("#ec_credit_card_location_row").show();
							// authorize, paypal_pro, realex, sagepay, firstdata, paymentexpress, chronopay, eway, paypoint, securepay, paypal_payments_pro, braintree, goemerchant 
							if( location == "us" )
								ec_update_credit_card_options( 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1 );
							if( location == "ca" )
								ec_update_credit_card_options( 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0 );
							if( location == "uk" )
								ec_update_credit_card_options( 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 1, 0 );
							if( location == "au" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0 );
							if( location == "ireland" )
								ec_update_credit_card_options( 1, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0 );
							if( location == "germany" )
								ec_update_credit_card_options( 1, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0 );
							if( location == "spain" )
								ec_update_credit_card_options( 1, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0 );
							if( location == "eu" )
								ec_update_credit_card_options( 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0 );
							if( location == "ru" )
								ec_update_credit_card_options( 1, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0 );
							if( location == "ch" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0 );
							if( location == "jp" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );
							if( location == "central_america" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );
							if( location == "south_america" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );
							if( location == "af" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );
							if( location == "asia" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0 );
							if( location == "middle_east" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );
							if( location == "south_pacific" )
								ec_update_credit_card_options( 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0 );
							
							jQuery('#ec_select_cc_label').show();	
							ec_show_selected_payment_option( );
							 
						}
					}
					
				}
				
				function ec_show_selected_payment_option( ){
					//visa, delta, uke, discover, mastercard, mcdebit, amex, jcb, diners, laser, maestro
					if( document.getElementById( 'authorize_radio' ).checked ){
						jQuery( '#authorize_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0 );
					}
					if( document.getElementById( 'paypal_pro_radio' ).checked ){
						jQuery( '#paypal_pro_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0 );
					}
					if( document.getElementById( 'realex_radio' ).checked ){
						jQuery( '#realex_table' ).show( );
						ec_show_available_credit_card_types( 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 1 );
					}
					if( document.getElementById( 'sagepay_radio' ).checked ){
						jQuery( '#sagepay_table' ).show( );
						ec_show_available_credit_card_types( 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1 );
					}
					if( document.getElementById( 'firstdata_radio' ).checked ){
						jQuery( '#firstdata_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0 );
					}
					if( document.getElementById( 'paymentexpress_radio' ).checked ){
						jQuery( '#paymentexpress_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1 );
					}
					//visa, delta, uke, discover, mastercard, mcdebit, amex, jcb, diners, laser, maestro
					if( document.getElementById( 'chronopay_radio' ).checked ){
						jQuery( '#echronopay_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 0, 1, 0, 1, 1, 1, 0, 0 );
					}
					if( document.getElementById( 'eway_radio' ).checked ){
						jQuery( '#eway_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0 );
					}
					if( document.getElementById( 'paypoint_radio' ).checked ){
						jQuery( '#paypoint_table' ).show( );
						ec_show_available_credit_card_types( 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1 );
					}
					if( document.getElementById( 'securepay_radio' ).checked ){
						jQuery( '#securepay_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 0, 1, 0, 1, 1, 1, 0, 0 );
					}
					if( document.getElementById( 'paypal_payments_pro_radio' ).checked ){
						jQuery( '#paypal_payments_pro_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0 );
					}
					if( document.getElementById( 'braintree_radio' ).checked ){
						jQuery( '#braintree_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 1, 1, 0, 1, 1, 0, 0, 0 );
					}
					if( document.getElementById( 'goemerchant_radio' ).checked ){
						jQuery( '#goemerchant_table' ).show( );
						ec_show_available_credit_card_types( 1, 0, 0, 0, 1, 0, 1, 1, 1, 0, 0 );
					}
				}
				
				function ec_update_credit_card_options( authorize, paypal_pro, realex, sagepay, firstdata, paymentexpress, chronopay, eway, paypoint, securepay, paypal_payments_pro, braintree, goemerchant ){
					if( authorize )
						jQuery("#authorize_row").show();
					else
						document.getElementById( 'authorize_radio' ).checked = false;
					
					if( paypal_pro )
						jQuery("#paypal_pro_row").show();
					else
						document.getElementById( 'paypal_pro_radio' ).checked = false;
					
					if( realex )
						jQuery("#realex_row").show();
					else
						document.getElementById( 'realex_radio' ).checked = false;
					
					if( sagepay )
						jQuery("#sagepay_row").show();
					else
						document.getElementById( 'sagepay_radio' ).checked = false;
					
					if( firstdata )
						jQuery("#firstdata_row").show();
					else
						document.getElementById( 'firstdata_radio' ).checked = false;
					
					if( paymentexpress )
						jQuery("#paymentexpress_row").show();
					else
						document.getElementById( 'paymentexpress_radio' ).checked = false;
					
					if( chronopay )
						jQuery("#chronopay_row").show();
					else
						document.getElementById( 'chronopay_radio' ).checked = false;
					
					if( eway )
						jQuery("#eway _row").show();
					else
						document.getElementById( 'eway_radio' ).checked = false;
					
					if( paypoint )
						jQuery("#paypoint_row").show();
					else
						document.getElementById( 'paypoint_radio' ).checked = false;
					
					if( securepay )
						jQuery("#securepay_row").show();
					else
						document.getElementById( 'securepay_radio' ).checked = false;
					
					if( paypal_payments_pro )
						jQuery("#paypal_payments_pro_row").show();
					else
						document.getElementById( 'paypal_payments_pro_radio' ).checked = false;
					
					if( braintree )
						jQuery("#braintree_row").show();
					else
						document.getElementById( 'braintree_radio' ).checked = false;
					
					if( goemerchant )
						jQuery("#goemerchant_row").show();
					else
						document.getElementById( 'goemerchant_radio' ).checked = false;
				}
				
				function ec_show_available_credit_card_types( visa, delta, uke, discover, mastercard, mcdebit, amex, jcb, diners, laser, maestro ){
					if( visa )
						jQuery("#visa_row").show();
					else
						document.getElementById( 'visa_checkbox' ).checked = false;
					if( delta )
						jQuery("#delta_row").show();
					else
						document.getElementById( 'delta_checkbox' ).checked = false;
					if( uke )
						jQuery("#uke_row").show();
					else
						document.getElementById( 'uke_checkbox' ).checked = false;
					if( discover )
						jQuery("#discover_row").show();
					else
						document.getElementById( 'discover_checkbox' ).checked = false;
					if( mastercard )
						jQuery("#mastercard_row").show();
					else
						document.getElementById( 'mastercard_checkbox' ).checked = false;
					if( mcdebit )
						jQuery("#mcdebit_row").show();
					else
						document.getElementById( 'mcdebit_checkbox' ).checked = false;
					if( amex )
						jQuery("#amex_row").show();
					else
						document.getElementById( 'amex_checkbox' ).checked = false;
					if( jcb )
						jQuery("#jcb_row").show();
					else
						document.getElementById( 'jcb_checkbox' ).checked = false;
					if( diners )
						jQuery("#diners_row").show();
					else
						document.getElementById( 'diners_checkbox' ).checked = false;
					if( laser )
						jQuery("#laser_row").show();
					else
						document.getElementById( 'laser_checkbox' ).checked = false;
					if( maestro )
						jQuery("#maestro_row").show();
					else
						document.getElementById( 'maestro_checkbox' ).checked = false;
				}
				
				function ec_gateways_hide_all( ){
					jQuery("#no_full_license").hide();
					jQuery("#ec_credit_card_location_row").hide();
					jQuery("#which_gateway_label").hide();
					jQuery("#authorize_row").hide();
					jQuery("#authorize_table").hide();
					jQuery("#braintree_row").hide();
					jQuery("#braintree_table").hide();
					jQuery("#paypal_pro_row").hide();
					jQuery("#paypal_pro_table").hide();
					jQuery("#paypal_payments_pro_row").hide();
					jQuery("#paypal_payments_pro_table").hide();
					jQuery("#realex_row").hide();
					jQuery("#realex_table").hide();
					jQuery("#goemerchant_row").hide();
					jQuery("#goemerchant_table").hide();
					jQuery("#sagepay_row").hide();
					jQuery("#sagepay_table").hide();
					jQuery("#firstdata_row").hide();
					jQuery("#firstdata_table").hide();
					jQuery("#paymentexpress_row").hide();
					jQuery("#paymentexpress_table").hide();
					jQuery("#chronopay_row").hide();
					jQuery("#chronopay_table").hide();
					jQuery("#eway_row").hide();
					jQuery("#eway_table").hide();
					jQuery("#paypoint_row").hide();
					jQuery("#paypoint_table").hide();
					jQuery("#securepay_row").hide();
					jQuery("#securepay_table").hide();
					jQuery('#ec_select_cc_label').hide();
					jQuery("#visa_row").hide();
					jQuery("#delta_row").hide();
					jQuery("#uke_row").hide();
					jQuery("#discover_row").hide();
					jQuery("#mastercard_row").hide();
					jQuery("#mcdebit_row").hide();
					jQuery("#amex_row").hide();
					jQuery("#jcb_row").hide();
					jQuery("#diners_row").hide();
					jQuery("#laser_row").hide();
					jQuery("#maestro_row").hide();
				}
				
				ec_gateways_hide_all( );
				update_credit_card_form( );
			</script>
                
            <hr />
            <form method="post" action="" />
                <div class="ec_failed_row">Credt Card Setup, Finished with This Option: <select name="ec_option_checklist_credit_cart_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_credit_cart_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                <input type="hidden" name="ec_action" value="update_option" />
                <input type="hidden" name="ec_option_name" value="ec_option_checklist_credit_cart_complete" />
            </form>
			<?php }?>
            <hr />
            <?php 
			$total_payment++;
			if( get_option( 'ec_option_checklist_tax_complete' ) == "done" ){
				$correct_payment++;
				
				if( get_option( 'ec_option_checklist_tax_choice' ) == "state_tax" )
					ec_show_check( "You have setup state taxes. <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage tax rates</a>" );
				else if( get_option( 'ec_option_checklist_tax_choice' ) == "country_tax" )
					ec_show_check( "You have setup a single country tax. <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage tax rates</a>" );
				else if( get_option( 'ec_option_checklist_tax_choice' ) == "global_tax" )
					ec_show_check( "You have selected to use " . $credit_card . " for your live payment gateway on your store. <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage tax rates</a>" );
				else if( get_option( 'ec_option_checklist_tax_choice' ) == "vat" )
					ec_show_check( "You have selected to use " . $credit_card . " for your live payment gateway on your store. <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage tax rates</a> | <a href=\"?page=ec_adminconsole\">edit each country rate: admin console -> settings -> State List</a>" );
				else
					ec_show_check( "You are not using taxes or vat. <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage tax rates</a>" ); 
			}else{ 
				ec_show_failed( "If you have not finished setting up taxes, do so below and let us know when you are done." );
				?>
            <div class="ec_failed_row">What kind of tax structure do you need: <select name="ec_option_checklist_tax_choice" id="ec_option_checklist_tax_choice" onchange="ec_selected_tax_structure_change( );" >
                <option value="0">Select one</option>
                <option value="none"<?php if( get_option( 'ec_option_checklist_tax_choice' ) == "none" ){ echo " selected=\"selected\""; }?> >No Taxes</option>
                <option value="state_tax"<?php if( get_option( 'ec_option_checklist_tax_choice' ) == "state_tax" ){ echo " selected=\"selected\""; }?> >Use State Taxes</option>
                <option value="country_tax"<?php if( get_option( 'ec_option_checklist_tax_choice' ) == "country_tax" ){ echo " selected=\"selected\""; }?> >Tax a Single Country</option>
                <option value="global_tax"<?php if( get_option( 'ec_option_checklist_tax_choice' ) == "global_tax" ){ echo " selected=\"selected\""; }?> >Tax Everyone the Same</option>
                <option value="vat"<?php if( get_option( 'ec_option_checklist_tax_choice' ) == "vat" ){ echo " selected=\"selected\""; }?> >Use VAT System</option>
                </select>
            </div>
            
			<div id="ec_state_tax">
                <div class="ec_failed_row">Add a State Rate: <?php ec_show_state_select( "ec_new_state", "0" ); ?> <input type="number" name="ec_new_state_rate" id="ec_new_state_rate" value="0" />% <input type="button" class="button-primary" value="Add State Rate" onclick="ec_add_state_tax( );" /></div>
                <div class="ec_failed_row">Current State Rates:</div>
                <div id="ec_states_tax_list">
                	<?php
						$db = new ec_db_admin( );
						$state_rates = $db->get_taxrates( );
						$i=0;
						foreach( $state_rates as $rate ){
							if( $rate->tax_by_state ){
								$i++;
						?>
                	<div class="ec_failed_row ec_list_style_<?php echo ($i%2); ?>"><div><input type="hidden" id="ec_tax_state_<?php echo $rate->taxrate_id; ?>" value="<?php echo $rate->state_code; ?>" /><span class="ec_state_column"><?php echo $rate->state_code; ?></span><span class="ec_state_rate_column"><input type="number" value="<?php echo $rate->state_rate; ?>" id="ec_tax_state_rate_<?php echo $rate->taxrate_id; ?>" />%</span><span class="ec_state_buttons_column"><input type="button" class="button-primary" class="button-primary" value="Delete Rate" onclick="ec_delete_state_tax( '<?php echo $rate->taxrate_id; ?>' );" /> <input type="button" class="button-primary" class="button-primary" value="Update Rate" onclick="ec_update_state_tax( '<?php echo $rate->taxrate_id; ?>' );" /></span></div></div>
                
                	<?php 	} ?>
               
				<?php 	} ?>
                </div>
			</div>
            
            <?php
			$country_taxrate_id = 0;
			$country_tax = "0";
			$country_tax_rate = 0;
			$all_tax_rate = 0;
			$all_taxrate_id = 0;
			$vat_tax_rate = 0;
			$vat_taxrate_id = 0;
			
			$db = new ec_db_admin( );
			$state_rates = $db->get_taxrates( );
			foreach( $state_rates as $rate ){
				if( $rate->tax_by_country ){
					$country_taxrate_id = $rate->taxrate_id;
					$country_tax = $rate->country_code;
					$country_tax_rate = $rate->country_rate;
				}else if( $rate->tax_by_all ){
					$all_tax_rate = $rate->all_rate;
					$all_taxrate_id = $rate->taxrate_id;
				}else if( $rate->tax_by_vat ){
					$vat_tax_rate = $rate->vat_rate;
					$vat_taxrate_id = $rate->taxrate_id;
				}
			}
			?>
            <div id="ec_country_tax">
                <div class="ec_failed_row">Country Rate: <?php ec_show_country_select( "ec_tax_country", $country_tax ); ?> <input type="number" name="ec_tax_country_rate" id="ec_tax_country_rate" value="<?php echo $country_tax_rate; ?>"  />% <input type="button" class="button-primary" value="Set Country Rate" onclick="ec_set_country_tax_rate( );" /><input type="hidden" name="ec_tax_country_id" id="ec_tax_country_id" value="<?php echo $country_taxrate_id; ?>" /></div>
			</div>
            
            <div id="ec_all_tax">
                <div class="ec_failed_row">Global Tax Rate: <input type="number" name="ec_tax_all_rate" id="ec_tax_all_rate" value="<?php echo $all_tax_rate; ?>"  />% <input type="button" class="button-primary" value="Set Global Rate" onclick="ec_set_all_tax_rate( );" /><input type="hidden" name="ec_tax_all_id" id="ec_tax_all_id" value="<?php echo $all_taxrate_id; ?>" /></div>
			</div>
            
            <div id="ec_vat_tax">
                <div class="ec_failed_row">VAT Rate Used Before User Enters Country: <input type="number" name="ec_tax_vat_rate" id="ec_tax_vat_rate" value="<?php echo $vat_tax_rate; ?>"  />% <input type="button" class="button-primary" value="Set VAT Rate" onclick="ec_set_vat_tax_rate( );" /><input type="hidden" name="ec_tax_vat_id" id="ec_tax_vat_id" value="<?php echo $vat_taxrate_id; ?>" /></div>
			
            	<hr />
           		
                <div class="ec_failed_row">Add a Country VAT Rate: <?php ec_show_country_select( "ec_new_vat_country", "0" ); ?> <input type="number" name="ec_new_vat_rate" id="ec_new_vat_rate" value="0.000"  />% <input type="button" class="button-primary" value="Add VAT Rate" onclick="ec_new_vat_tax( );" /></div>
                
                <div class="ec_failed_row">Current Country VAT Rates:</div>
                <div id="ec_vat_countries">
                <?php
                    $db = new ec_db_admin( );
                    $countries = $db->get_countries( );
					$i=0;
                    foreach( $countries as $country ){
                        if( $country->vat_rate_cnt > 0 ){
							$i++;
                    ?>
                <div class="ec_failed_row ec_list_style_<?php echo $i%2; ?>"><div><input type="hidden" id="ec_tax_country_<?php echo $country->iso2_cnt; ?>" value="<?php echo $country->iso2_cnt; ?>" /><span class="ec_country_name_column"><?php echo $country->name_cnt; ?></span><span class="ec_country_rate_column"><input type="number" value="<?php echo $country->vat_rate_cnt; ?>" id="ec_tax_country_rate_<?php echo $country->iso2_cnt; ?>" />%</span><span class="ec_country_buttons_column"><input type="button" class="button-primary" value="Delete VAT Rate" onclick="ec_zero_vat_tax( '<?php echo $country->iso2_cnt; ?>' );" /> <input type="button" class="button-primary" value="Update VAT Rate" onclick="ec_update_vat_tax( '<?php echo $country->iso2_cnt; ?>' );" /></span></div></div>
            
                <?php 	} 
					}?>
                </div>
            </div>
			<script>ec_setup_selected_tax_structure( );</script>  
            <hr />
            <form method="post" action="" />
                <div class="ec_failed_row">Finished Setting up the Tax Structure: <select name="ec_option_checklist_tax_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_tax_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                <input type="hidden" name="ec_action" value="update_option" />
                <input type="hidden" name="ec_option_name" value="ec_option_checklist_tax_complete" />
            </form>
			
			<?php } ?>
            <hr />
            <?php 
			$total_payment++;
			
			if( get_option( 'ec_option_checklist_shipping_complete' ) == "done" ){
				$correct_payment++;
				
				if( get_option( 'ec_option_checklist_shipping_choice' ) == "price_based" )
					ec_show_check( "You have setup price based shipping. Make changes by going to <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage shipping rates</a>" );
				else if( get_option( 'ec_option_checklist_shipping_choice' ) == "weight_based" )
					ec_show_check( "You have setup weight based shipping. Make changes by going to <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage shipping rates</a>" );
				else if( get_option( 'ec_option_checklist_shipping_choice' ) == "method_based" )
					ec_show_check( "You have setup static method based shipping. Make changes by going to <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage shipping rates</a>" );
				else if( get_option( 'ec_option_checklist_shipping_choice' ) == "live_based" ){
					ec_show_check( "You have setup live shipping. Make changes by going to <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage shipping rates</a>" );?>
                    
				<?php }else
					ec_show_check( "You have chose to not use shipping. <a href=\"?page=ec_adminconsole\">admin console -> rates -> manage shipping rates</a>" ); 
			}else{ 
				ec_show_failed( "If you have not finished setting up shipping, do so below and let us know when you are done." );
				?>
                <div class="ec_failed_row">What kind of shipping do you want to use: <select name="ec_option_checklist_shipping_choice" id="ec_option_checklist_shipping_choice" onchange="ec_selected_shipping_type_change( );" >
                    <option value="0">Select one</option>
                    <option value="none"<?php if( get_option( 'ec_option_checklist_shipping_choice' ) == "none" ){ echo " selected=\"selected\""; }?> >No Shipping</option>
                    <option value="price_based"<?php if( get_option( 'ec_option_checklist_shipping_choice' ) == "price_based" ){ echo " selected=\"selected\""; }?> >Price Based Shipping</option>
                    <option value="weight_based"<?php if( get_option( 'ec_option_checklist_shipping_choice' ) == "weight_based" ){ echo " selected=\"selected\""; }?> >Weight Based Shipping</option>
                    <option value="method_based"<?php if( get_option( 'ec_option_checklist_shipping_choice' ) == "method_based" ){ echo " selected=\"selected\""; }?> >Static Method Based Shipping</option>
                    <option value="live_based"<?php if( get_option( 'ec_option_checklist_shipping_choice' ) == "live_based" ){ echo " selected=\"selected\""; }?> >Live Shipping Rates</option>
                    </select>
                </div>
                
                <div id="ec_price_based">
                	<div class="ec_failed_row">Add a Shipping Rate - Trigger Price: <input type="number" name="ec_new_price_trigger" id="ec_new_price_trigger" value="0.000"  />, Shipping Rate: <input type="number" name="ec_new_price_rate" id="ec_new_price_rate" value="0.000"  /> <input type="button" class="button-primary" value="Add Rate" onclick="ec_add_shipping_rate( 'price_based' );" /></div>
                
                    <div class="ec_failed_row">Current Price Based Shipping Rates:</div>
                    <div id="ec_price_rates">
                    <?php
                        $db = new ec_db_admin( );
                        $rates = $db->get_shipping_data( );
                        $i=0;
                        foreach( $rates as $rate ){
                            if( $rate->is_price_based ){
                                $i++;
                        ?>
                    <div class="ec_failed_row ec_list_style_<?php echo $i%2; ?>"><div><span class="ec_price_trigger_rate_column">Trigger Rate: <input type="number" value="<?php echo $rate->trigger_rate; ?>" id="ec_price_trigger_rate_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_price_rate_column">Shipping Rate: <input type="number" value="<?php echo $rate->shipping_rate; ?>" id="ec_price_shipping_rate_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_country_buttons_column"><input type="button" class="button-primary" value="Delete Rate" onclick="ec_delete_shipping_rate( '<?php echo $rate->shippingrate_id; ?>' );" /> <input type="button" class="button-primary" value="Update Rate" onclick="ec_update_shipping_rate( 'price_based', '<?php echo $rate->shippingrate_id; ?>' );" /></span></div></div>
                
                    <?php 	} 
                        }?>
                    </div>
                </div>
                
                <div id="ec_weight_based">
                	<div class="ec_failed_row">Add a Shipping Rate - Trigger Weight: <input type="number" name="ec_new_weight_trigger" id="ec_new_weight_trigger" value="0.000"  />, Shipping Rate: <input type="number" name="ec_new_weight_rate" id="ec_new_weight_rate" value="0.000"  /> <input type="button" class="button-primary" value="Add Rate" onclick="ec_add_shipping_rate( 'weight_based' );" /></div>
                
                    <div class="ec_failed_row">Current Weight Based Shipping Rates:</div>
                    <div id="ec_weight_rates">
                    <?php
                        $db = new ec_db_admin( );
                        $rates = $db->get_shipping_data( );
                        $i=0;
                        foreach( $rates as $rate ){
                            if( $rate->is_weight_based ){
                                $i++;
                        ?>
                    <div class="ec_failed_row ec_list_style_<?php echo $i%2; ?>"><div><span class="ec_price_trigger_rate_column">Trigger Rate: <input type="number" value="<?php echo $rate->trigger_rate; ?>" id="ec_weight_trigger_rate_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_price_rate_column">Shipping Rate: <input type="number" value="<?php echo $rate->shipping_rate; ?>" id="ec_weight_shipping_rate_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_country_buttons_column"><input type="button" class="button-primary" value="Delete Rate" onclick="ec_delete_shipping_rate( '<?php echo $rate->shippingrate_id; ?>' );" /> <input type="button" class="button-primary" value="Update Rate" onclick="ec_update_shipping_rate( 'weight_based', '<?php echo $rate->shippingrate_id; ?>' );" /></span></div></div>
                
                    <?php 	} 
                        }?>
                    </div>
                </div>
                
                <div id="ec_method_based">
                	<div class="ec_failed_row">Add a Shipping Rate - Method Label: <input type="text" name="ec_new_method_label" id="ec_new_method_label" value="" />, Shipping Rate: <input type="number" name="ec_new_method_rate" id="ec_new_method_rate" value="0.000"  />, Rate Order in List: <input type="number" name="ec_new_method_order" id="ec_new_method_order" value="0"  /> <input type="button" class="button-primary" value="Add Rate" onclick="ec_add_shipping_rate( 'method_based' );" /></div>
                
                    <div class="ec_failed_row">Current Method Based Shipping Rates:</div>
                    <div id="ec_method_rates">
                    <?php
                        $db = new ec_db_admin( );
                        $rates = $db->get_shipping_data( );
                        $i=0;
                        foreach( $rates as $rate ){
                            if( $rate->is_method_based ){
                                $i++;
                        ?>
                    <div class="ec_failed_row ec_list_style_<?php echo $i%2; ?>"><div><span class="ec_method_label_column">Rate Label: <input type="text" value="<?php echo $rate->shipping_label; ?>" id="ec_method_label_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_method_rate_column">Shipping Rate: <input type="number" value="<?php echo $rate->shipping_rate; ?>" id="ec_method_shipping_rate_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_method_order_column">Rate Order: <input type="number" value="<?php echo $rate->shipping_order; ?>" id="ec_method_order_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_method_buttons_column"><input type="button" class="button-primary" value="Delete Rate" onclick="ec_delete_shipping_rate( '<?php echo $rate->shippingrate_id; ?>' );" /> <input type="button" class="button-primary" value="Update Rate" onclick="ec_update_shipping_rate( 'method_based', '<?php echo $rate->shippingrate_id; ?>' );" /></span></div></div>
                
                    <?php 	} 
                        }?>
                    </div>
                </div>
                
                <?php if( $is_full ){ ?>
                <div id="ec_live_based">
                	<?php 
					
					$total_payment++;
					
					if( $ups_has_settings && $ups_setup ){
						$correct_payment++;
						ec_show_check( "Your UPS Account is setup correctly. To change the account settings, do so in the admin console -> rates -> manage shipping rates" );
					}else{
						if( get_option( 'ec_checklist_shipping_use_ups' ) == "yes" ){
							
							if( !$ups_has_settings )
								ec_show_failed( "You have not added your account information for UPS, please enter that information below." );
							else{
								if( $ups_error_reason == "250003" )
									ec_show_failed( "The access license number you have entered for UPS is invalid. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $ups_error_reason == "111210" )
									ec_show_failed( "Ground shipping is not available in your location or your zip code was entered incorrectly. The zip code may also not match the country code. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $ups_error_reason == "250002" )
									ec_show_failed( "UPS requires any value for user ID, password, and shipper number and apparently one of these three values is missing. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $ups_error_reason == "111000" )
									ec_show_failed( "The country code entered is invalid according to UPS. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $ups_error_reason == "110546" )
									ec_show_failed( "The weight unit entered is not valid. UPS requires LBS or KGS only. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $ups_error_reason == "111057" )
									ec_show_failed( "The weight unit entered is not valid for the selected country. UPS requires LBS or KGS only based on the selected country. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else
									ec_show_failed( "An error occured when submitting a test call to UPS using your account data. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
							}
							?>
						
						<form method="post" action="" />
                            <div class="ec_failed_row">Access License Number: <input type="text" name="ups_access_license_number" value="<?php echo $setting->get_setting( 'ups_access_license_number' ); ?>" /></div>
                            <div class="ec_failed_row">UPS User ID: <input type="text" name="ups_user_id" value="<?php echo $setting->get_setting( 'ups_user_id' ); ?>" /></div>
                            <div class="ec_failed_row">UPS Password: <input type="password" name="ups_password" value="<?php echo $setting->get_setting( 'ups_password' ); ?>" /></div>
                            <div class="ec_failed_row">Ship From Postal Code: <input type="text" name="ups_ship_from_zip" value="<?php echo $setting->get_setting( 'ups_ship_from_zip' ); ?>" /></div>
                            <div class="ec_failed_row">UPS Shipper Number: <input type="text" name="ups_shipper_number" value="<?php echo $setting->get_setting( 'ups_shipper_number' ); ?>" /></div>
                            <div class="ec_failed_row">UPS Country Code (e.g. US or CA): <input type="text" name="ups_country_code" value="<?php echo $setting->get_setting( 'ups_country_code' ); ?>" /></div>
                            <div class="ec_failed_row">UPS Weight Type (LBS or KGS): <input type="text" name="ups_weight_type" value="<?php echo $setting->get_setting( 'ups_weight_type' ); ?>" /></div>
                            <div class="ec_failed_row"><input type="submit" class="button-primary"  value="Save UPS Data" /></div>
                            <input type="hidden" name="ec_action" value="update_ups" />
                        </form>
					   <?php  
						}else if( get_option( 'ec_checklist_shipping_use_ups' ) == "no" ){ //Close use UPS IF
							$correct_payment++;
							ec_show_check( "You have chosen to not use UPS live shipping. This option can be edited further in the EasyCart Admin, under 'rates' and 'manage shipping rates'" );
						}else{
							ec_show_failed( "You have not told us if you would like to use UPS live shipping rates. Please select yes or no below." );
							?>
						<form method="post" action="" />
                            <div class="ec_failed_row">Would you like to use UPS Live Shipping: <select name="ec_checklist_shipping_use_ups"><option value="0"<?php if( get_option( 'ec_checklist_shipping_use_ups' ) == "0" || get_option( 'ec_checklist_shipping_use_ups' ) == "" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="no"<?php if( get_option( 'ec_checklist_shipping_use_ups' ) == "no" ){ echo " selected=\"selected\""; }?>>No Thank You</option><option value="yes"<?php if( get_option( 'ec_checklist_shipping_use_ups' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes Please</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                            <input type="hidden" name="ec_action" value="update_option" />
                            <input type="hidden" name="ec_option_name" value="ec_checklist_shipping_use_ups" />
                        </form>
						<?php }
					}?>
                   
                   <?php 
				   
					$total_payment++;
					
					if( $usps_has_settings && $usps_setup ){
					    $correct_payment++;
						ec_show_check( "Your USPS Account is setup correctly. To change the account settings, do so in the admin console -> rates -> manage shipping rates" );
					}else{
						if( get_option( 'ec_checklist_shipping_use_usps' ) == "yes" ){
							if( !$usps_has_settings )
								ec_show_failed( "You have not added your account information for USPS, please enter that information below." );
						
							else{
								if( $usps_error_reason == 1 )
									ec_show_failed( "The USPS account number you have entered is invalid. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>. Additional note: USPS requires the user to call USPS directly to move their account from test mode to live mode and this is the most common setup problem with live USPS rates." );
								else if( $usps_error_reason == 2 )
									ec_show_failed( "The USPS ship from zip code you have entered is invalid. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>. Additional note: USPS requires the user to call USPS directly to move their account from test mode to live mode and this is the most common setup problem with live USPS rates." );
								else
									ec_show_failed( "The account information you have entered for USPS is invalid. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>. Additional note: USPS requires the user to call USPS directly to move their account from test mode to live mode and this is the most common setup problem with live USPS rates." );
							}
							?>
					
							<form method="post" action="" />
                            <div class="ec_failed_row">USPS User Name: <input type="text" name="usps_user_name" value="<?php echo $setting->get_setting( 'usps_user_name' ); ?>" /></div>
                            <div class="ec_failed_row">Ship From Postal Code: <input type="text" name="usps_ship_from_zip" value="<?php echo $setting->get_setting( 'usps_ship_from_zip' ); ?>" /></div>
                            <div class="ec_failed_row"><input type="submit" class="button-primary"  value="Save USPS Data" /></div>
                            <input type="hidden" name="ec_action" value="update_usps" />
                        </form>
					   <?php
						}else if( get_option( 'ec_checklist_shipping_use_usps' ) == "no" ){ //Close use USPS IF
							$correct_payment++;
							ec_show_check( "You have chosen to not use USPS live shipping. This option can be edited further in the EasyCart Admin, under 'rates' and 'manage shipping rates'" );
						}else{
							ec_show_failed( "You have not told us if you would like to use USPS live shipping rates. Please select yes or no below." );
							?>
						<form method="post" action="" />
                            <div class="ec_failed_row">Would you like to use USPS Live Shipping: <select name="ec_checklist_shipping_use_usps"><option value="0"<?php if( get_option( 'ec_checklist_shipping_use_usps' ) == "0" || get_option( 'ec_checklist_shipping_use_usps' ) == "" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="no"<?php if( get_option( 'ec_checklist_shipping_use_usps' ) == "no" ){ echo " selected=\"selected\""; }?>>No Thank You</option><option value="yes"<?php if( get_option( 'ec_checklist_shipping_use_usps' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes Please</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                            <input type="hidden" name="ec_action" value="update_option" />
                            <input type="hidden" name="ec_option_name" value="ec_checklist_shipping_use_usps" />
                        </form>
						<?php }
					}?>
                   
                   <?php 
					
					$total_payment++;
					
					if( $fedex_has_settings && $fedex_setup ){
						$correct_payment++;
						ec_show_check( "Your FedEx Account is setup correctly. To change the account settings, do so in the admin console -> rates -> manage shipping rates" );
					}else{
						if( get_option( 'ec_checklist_shipping_use_fedex' ) == "yes" ){
							if( !$fedex_has_settings )
								ec_show_failed( "You have not added your account information for FedEx, please enter that information below." );
							else{
								if( $fedex_error_reason == "1000" )
									ec_show_failed( "Authentication with FedEx failed. Likely the access key you have entered for FedEx is invalid or the password is incorrect. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $fedex_error_reason == "860" )
									ec_show_failed( "The account number and meter number do not match FedEx records. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $fedex_error_reason == "501" )
									ec_show_failed( "The entered zip code does not seem to be valid or is missing for FedEx. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $fedex_error_reason == "502" )
									ec_show_failed( "The entered country code is invalid or missing (should be 2 digit like US or CA). Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $fedex_error_reason == "2" )
									ec_show_failed( "The entered weight unit is incorrect (must be 2 digit, either LB or KG). Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else
									ec_show_failed( "The FedEx live shipping test failed with an error code of '" . $fedex_error_reason . "'. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
							}
							?>
					
						<form method="post" action="" />
                            <div class="ec_failed_row">FedEx Access Key: <input type="text" name="fedex_key" value="<?php echo $setting->get_setting( 'fedex_key' ); ?>" /></div>
                            <div class="ec_failed_row">FedEx Account Number: <input type="text" name="fedex_account_number" value="<?php echo $setting->get_setting( 'fedex_account_number' ); ?>" /></div>
                            <div class="ec_failed_row">FedEx Meter Number: <input type="text" name="fedex_meter_number" value="<?php echo $setting->get_setting( 'fedex_meter_number' ); ?>" /></div>
                            <div class="ec_failed_row">FedEx Password: <input type="password" name="fedex_password" value="<?php echo $setting->get_setting( 'fedex_password' ); ?>" /></div>
                            <div class="ec_failed_row">Ship From Postal Code: <input type="text" name="fedex_ship_from_zip" value="<?php echo $setting->get_setting( 'fedex_ship_from_zip' ); ?>" /></div>
                            <div class="ec_failed_row">FedEx Country Code (e.g. US or CA): <input type="text" name="fedex_country_code" value="<?php echo $setting->get_setting( 'fedex_country_code' ); ?>" /></div>
                            <div class="ec_failed_row">FedEx Weight Type (LB or KG): <input type="text" name="fedex_weight_units" value="<?php echo $setting->get_setting( 'fedex_weight_units' ); ?>" /></div>
                            <div class="ec_failed_row"><input type="submit" class="button-primary"  value="Save FedEx Data" /></div>
                            <input type="hidden" name="ec_action" value="update_fedex" />
                        </form>
					   <?php
						}else if( get_option( 'ec_checklist_shipping_use_fedex' ) == "no" ){ //Close use USPS IF
							$correct_payment++;
							ec_show_check( "You have chosen to not use FedEx live shipping. This option can be edited further in the EasyCart Admin, under 'rates' and 'manage shipping rates'" );
						}else{
							ec_show_failed( "You have not told us if you would like to use FedEx live shipping rates. Please select yes or no below." );
							?>
						<form method="post" action="" />
                            <div class="ec_failed_row">Would you like to use FedEx Live Shipping: <select name="ec_checklist_shipping_use_fedex"><option value="0"<?php if( get_option( 'ec_checklist_shipping_use_fedex' ) == "0" || get_option( 'ec_checklist_shipping_use_fedex' ) == "" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="no"<?php if( get_option( 'ec_checklist_shipping_use_fedex' ) == "no" ){ echo " selected=\"selected\""; }?>>No Thank You</option><option value="yes"<?php if( get_option( 'ec_checklist_shipping_use_fedex' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes Please</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                            <input type="hidden" name="ec_action" value="update_option" />
                            <input type="hidden" name="ec_option_name" value="ec_checklist_shipping_use_fedex" />
                        </form>
						<?php }
					}?>
                    
                    <?php 
					// AUS POST
					$total_payment++;
					
					if( $auspost_has_settings && $auspost_setup ){
						$correct_payment++;
						ec_show_check( "Your Australia Post Account is setup correctly. To change the account settings, do so in the admin console -> rates -> manage shipping rates" );
					}else{
						if( get_option( 'ec_checklist_shipping_use_auspost' ) == "yes" ){
							if( !$auspost_has_settings )
								ec_show_failed( "You have not added your account information for Australia Post, please enter that information below." );
							else{
								// Add the error codes here!
								if( $auspost_error_reason == "1" )
									ec_show_failed( "Authentication with Australia Post failed. Likely the access key you have entered for Australia Post is invalid or the password is incorrect. This will also fail if you enter an invalid postal code. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								
							}
							?>
					
						<form method="post" action="" />
                            <div class="ec_failed_row">Australia Post API Key: <input type="text" name="auspost_api_key" value="<?php echo $setting->get_setting( 'auspost_api_key' ); ?>" /></div>
                            <div class="ec_failed_row">Australia Post Ship From Postal Code: <input type="text" name="auspost_ship_from_zip" value="<?php echo $setting->get_setting( 'auspost_ship_from_zip' ); ?>" /></div>
                            <div class="ec_failed_row"><input type="submit" class="button-primary"  value="Save Australia Post Data" /></div>
                            <input type="hidden" name="ec_action" value="update_auspost" />
                        </form>
					   <?php
						}else if( get_option( 'ec_checklist_shipping_use_auspost' ) == "no" ){ //Close use auspost IF
							$correct_payment++;
							ec_show_check( "You have chosen to not use Australia Post live shipping. This option can be edited further in the EasyCart Admin, under 'rates' and 'manage shipping rates'" );
						}else{
							ec_show_failed( "You have not told us if you would like to use Australia Post live shipping rates. Please select yes or no below." );
							?>
						<form method="post" action="" />
                            <div class="ec_failed_row">Would you like to use Australia Post Live Shipping: <select name="ec_checklist_shipping_use_auspost"><option value="0"<?php if( get_option( 'ec_checklist_shipping_use_auspost' ) == "0" || get_option( 'ec_checklist_shipping_use_auspost' ) == "" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="no"<?php if( get_option( 'ec_checklist_shipping_use_auspost' ) == "no" ){ echo " selected=\"selected\""; }?>>No Thank You</option><option value="yes"<?php if( get_option( 'ec_checklist_shipping_use_auspost' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes Please</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                            <input type="hidden" name="ec_action" value="update_option" />
                            <input type="hidden" name="ec_option_name" value="ec_checklist_shipping_use_auspost" />
                        </form>
						<?php }
					}?>
                    
                    <?php 
					// DHL POST
					$total_payment++;
					
					if( $dhl_has_settings && $dhl_setup ){
						$correct_payment++;
						ec_show_check( "Your DHL Account is setup correctly. To change the account settings, do so in the admin console -> rates -> manage shipping rates" );
					}else{
						if( get_option( 'ec_checklist_shipping_use_dhl' ) == "yes" ){
							if( !$dhl_has_settings )
								ec_show_failed( "You have not added your account information for DHL, please enter that information below." );
							else{
								// Add the error codes here!
								if( $dhl_error_reason == "Validation Failure:Site Id is wrong" )
									ec_show_failed( "Authentication with DHL failed. The Site ID you have entered is incorrect. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $dhl_error_reason == "Validation Failure:Password provided is wrong" )
									ec_show_failed( "Authentication with DHL failed. The password you have entered is incorrect. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $dhl_error_reason == "The payment country could not be found  please check your payment country." )
									ec_show_failed( "The country code you have entered could not be found. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $dhl_error_code == "111" )
									ec_show_failed( "The country code you entered was an incorrect length or the weight unit is the wrong length. These values should be a 2 digit country code and a 2 digit weight code (LB or KG). Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $dhl_error_code == "3024" )
									ec_show_failed( "The postal code you have entered is in the wrong format. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								else if( $dhl_error_code == "3002" )
									ec_show_failed( "The postal code you have entered was not found. Please double check your settings and if you still have difficulties please contact WP EasyCart for assistance <a href=\"http://www.wpeasycart.com/support-ticket/\">here</a>." );
								
							}
							?>
					
						<form method="post" action="" />
                            <div class="ec_failed_row">DHL Site ID: <input type="text" name="dhl_site_id" value="<?php echo $setting->get_setting( 'dhl_site_id' ); ?>" /></div>
                            <div class="ec_failed_row">DHL Password: <input type="text" name="dhl_password" value="<?php echo $setting->get_setting( 'dhl_password' ); ?>" /></div>
                            <div class="ec_failed_row">DHL Ship From Country (eg US or CA): <input type="text" name="dhl_ship_from_country" value="<?php echo $setting->get_setting( 'dhl_ship_from_country' ); ?>" /></div>
                            <div class="ec_failed_row">DHL Ship From Postal Code: <input type="text" name="dhl_ship_from_zip" value="<?php echo $setting->get_setting( 'dhl_ship_from_zip' ); ?>" /></div>
                            <div class="ec_failed_row">DHL Weight Unit (LB or KG): <input type="text" name="dhl_weight_unit" value="<?php echo $setting->get_setting( 'dhl_weight_unit' ); ?>" /></div>
                            <div class="ec_failed_row">DHL Test Mode: <select name="dhl_test_mode"><option value="0"<?php if( $setting->get_setting( 'dhl_test_mode' ) == "0" ){echo " selected=\"selected\""; } ?>>No</option><option value="1"<?php if( $setting->get_setting( 'dhl_test_mode' ) == "1" ){echo " selected=\"selected\""; } ?>>Yes</option></select></div>
                            <div class="ec_failed_row"><input type="submit" class="button-primary"  value="Save DHL Data" /></div>
                            <input type="hidden" name="ec_action" value="update_dhl" />
                        </form>
					   <?php
						}else if( get_option( 'ec_checklist_shipping_use_dhl' ) == "no" ){ //Close use dhl IF
							$correct_payment++;
							ec_show_check( "You have chosen to not use DHL live shipping. This option can be edited further in the EasyCart Admin, under 'rates' and 'manage shipping rates'" );
						}else{
							ec_show_failed( "You have not told us if you would like to use DHL live shipping rates. Please select yes or no below." );
							?>
						<form method="post" action="" />
                            <div class="ec_failed_row">Would you like to use DHL Live Shipping: <select name="ec_checklist_shipping_use_dhl"><option value="0"<?php if( get_option( 'ec_checklist_shipping_use_dhl' ) == "0" || get_option( 'ec_checklist_shipping_use_dhl' ) == "" ){ echo " selected=\"selected\""; }?>>Select One</option><option value="no"<?php if( get_option( 'ec_checklist_shipping_use_dhl' ) == "no" ){ echo " selected=\"selected\""; }?>>No Thank You</option><option value="yes"<?php if( get_option( 'ec_checklist_shipping_use_dhl' ) == "yes" ){ echo " selected=\"selected\""; }?>>Yes Please</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                            <input type="hidden" name="ec_action" value="update_option" />
                            <input type="hidden" name="ec_option_name" value="ec_checklist_shipping_use_dhl" />
                        </form>
						<?php }
					}?>
                    
                	<div class="ec_failed_row ec_live_row"><b>Add a Shipping Rate</b></div>
                    <div class="ec_failed_row ec_live_row">Shipping Label: <input type="text" name="ec_new_live_label" id="ec_new_live_label" value="" />, Rate Code: <select name="ec_new_live_code" id="ec_new_live_code">
                    	<option value="0">Select One</option>
                    	<option value="0">-----UPS CODES---</option>
                    	<option value="01" data-shiptype="ups">UPS Next Day Air</option>
                    	<option value="02" data-shiptype="ups">UPS Second Day Air</option>
                    	<option value="03" data-shiptype="ups">UPS Ground</option>
                    	<option value="07" data-shiptype="ups">UPS Worldwide Express</option>
                    	<option value="08" data-shiptype="ups">UPS Worldwide Expedited</option>
                    	<option value="11" data-shiptype="ups">UPS Standard</option>
                    	<option value="12" data-shiptype="ups">UPS Three-Day Select</option>
                    	<option value="13" data-shiptype="ups">UPS Next Day Air Saver</option>
                    	<option value="14" data-shiptype="ups">UPS Next Day Air Early A.M.</option>
                    	<option value="54" data-shiptype="ups">UPS Worldwide Express Plus</option>
                    	<option value="59" data-shiptype="ups">UPS Second Day Air A.M.</option>
                    	<option value="65" data-shiptype="ups">UPS Saver</option>
                    	<option value="95" data-shiptype="ups">UPS Worldwide Express Freight</option>
                    	<option value="0">-----USPS CODES---</option>
                        <option value="STANDARD POST" data-shiptype="usps">Standard Post</option>
                    	<option value="PRIORITY" data-shiptype="usps">Priority</option>
                        <option value="PRIORITY COMMERCIAL" data-shiptype="usps">Priority Commercial</option>
                        <option value="PRIORITY CPP" data-shiptype="usps">Priority CPP</option>
                        <option value="PRIORITY HFP COMMERCIAL" data-shiptype="usps">Priority HFP Commercial</option>
                        <option value="PRIORITY HFP CPP" data-shiptype="usps">Priority HFP CPP</option>
                        <option value="EXPRESS" data-shiptype="usps">Express</option>
                        <option value="EXPRESS COMMERCIAL" data-shiptype="usps">Express Commerical</option>
                        <option value="EXPRESS CPP" data-shiptype="usps">Express CPP</option>
                        <option value="EXPRESS SH" data-shiptype="usps">Express SH</option>
                        <option value="EXPRESS SH COMMERCIAL" data-shiptype="usps">Express SH Commercial</option>
                        <option value="EXPRESS HFP CPP" data-shiptype="usps">Express HFP CPP</option>
                        <option value="MEDIA" data-shiptype="usps">Media</option>
                        <option value="LIBRARY" data-shiptype="usps">Library</option>
                        <option value="ALL" data-shiptype="usps">All</option>
                        <option value="ONLINE" data-shiptype="usps">Online</option>
                        <option value="PLUS" data-shiptype="usps">Plus</option>
                    	<option value="0">-----FEDEX CODES---</option>
                        <option value="EUROPE_FIRST_INTERNATIONAL_PRIORITY" data-shiptype="fedex">FedEx Europe First International Priority</option>
                        <option value="FEDEX_1_DAY_FREIGHT" data-shiptype="fedex">FedEx 1 Day Freight</option>
                        <option value="FEDEX_2_DAY" data-shiptype="fedex">FedEx 2 Day</option>
                        <option value="FEDEX_2_DAY_AM" data-shiptype="fedex">FedEx 2 Day A.M.</option>
                        <option value="FEDEX_2_DAY_FREIGHT" data-shiptype="fedex">FedEx 2 Day Freight</option>
						<option value="FEDEX_3_DAY_FREIGHT" data-shiptype="fedex">FedEx 3 Day Freight</option>
						<option value="FEDEX_EXPRESS_SAVER" data-shiptype="fedex">FedEx Express Saver</option>
						<option value="FEDEX_FIRST_FREIGHT" data-shiptype="fedex">FedEx First Freight</option>
						<option value="FEDEX_FREIGHT_ECONOMY" data-shiptype="fedex">FedxEx Freight Economy</option>
						<option value="FEDEX_FREIGHT_PRIORITY" data-shiptype="fedex">FedEx Freight Priority</option>
						<option value="FEDEX_GROUND" data-shiptype="fedex">FedEx Ground</option>
						<option value="FIRST_OVERNIGHT" data-shiptype="fedex">FedEx First Overnight</option>
						<option value="GROUND_HOME_DELIVERY" data-shiptype="fedex">FedEx Ground Home Delivery</option>
						<option value="INTERNATIONAL_ECONOMY" data-shiptype="fedex">FedEx International Economy</option>
						<option value="INTERNATIONAL_ECONOMY_FREIGHT" data-shiptype="fedex">FedEx International Economy Freight</option>
						<option value="INTERNATIONAL_FIRST" data-shiptype="fedex">FedEx International First</option>
						<option value="INTERNATIONAL_PRIORITY" data-shiptype="fedex">FedEx International Priority</option>
						<option value="INTERNATIONAL_PRIORITY_FREIGHT" data-shiptype="fedex">FedEx International Priority Freight</option>
						<option value="PRIORITY_OVERNIGHT" data-shiptype="fedex">FedEx Priority Overnight</option>
						<option value="SMART_POST" data-shiptype="fedex">FedEx Smart Post</option>
						<option value="STANDARD_OVERNIGHT" data-shiptype="fedex">FedEx Standard Overnight</option>
                    	<option value="0">-----AUSTRALIA POST CODES---</option>
						<option value="AUS_PARCEL_REGULAR" data-shiptype="auspost">Parcel Post</option>
						<option value="AUS_PARCEL_REGULAR_SATCHEL_500G" data-shiptype="auspost">Parcel Post Small (500g) Satchel</option>
						<option value="AUS_PARCEL_EXPRESS" data-shiptype="auspost">Express Post</option>
						<option value="AUS_PARCEL_EXPRESS_SATCHEL_500G" data-shiptype="auspost">Express Post Small (500g) Satchel</option>
						<option value="INTL_SERVICE_ECI_PLATINUM" data-shiptype="auspost">Express Courier International Platinum</option>
						<option value="INTL_SERVICE_ECI_M" data-shiptype="auspost">Express Courier International Merchandise</option>
						<option value="INTL_SERVICE_ECI_D" data-shiptype="auspost">Express Courier International Documents</option>
						<option value="INTL_SERVICE_EPI" data-shiptype="auspost">Express Post International</option>
						<option value="INTL_SERVICE_AIR_MAIL" data-shiptype="auspost">International Air Mail</option>
						<option value="INTL_SERVICE_SEA_MAIL" data-shiptype="auspost">International Sea Mail</option>
                    	<option value="0">-----DHL CODES---</option>
                        <option value="1" data-shiptype="dhl">DOMESTIC EXPRESS 12:00</option>
                        <option value="2" data-shiptype="dhl">B2C</option>
                        <option value="4" data-shiptype="dhl">JETLINE</option>
                        <option value="5" data-shiptype="dhl">SPRINTLINE</option>
                        <option value="6" data-shiptype="dhl">SECURELINE</option>
                        <option value="7" data-shiptype="dhl">EXPRESS EASY</option>
                        <option value="9" data-shiptype="dhl">EUROPACK</option>
                        <option value="A" data-shiptype="dhl">AUTO REVERSALS</option>
                        <option value="B" data-shiptype="dhl">BREAK BULK EXPRESS</option>
                        <option value="C" data-shiptype="dhl">MEDICAL EXPRESS</option>
                        <option value="D" data-shiptype="dhl">EXPRESS WORLDWIDE</option>
                        <option value="E" data-shiptype="dhl">EXPRESS 9:00</option>
                        <option value="F" data-shiptype="dhl">FREIGHT WORLDWIDE</option>
                        <option value="G" data-shiptype="dhl">DOMESTIC ECONOMY SELECT</option>
                        <option value="H" data-shiptype="dhl">ECONOMY SELECT</option>
                        <option value="I" data-shiptype="dhl">BREAK BULK ECONOMY</option>
                        <option value="J" data-shiptype="dhl">JUMBO BOX</option>
                        <option value="K" data-shiptype="dhl">EXPRESS 9:00</option>
                        <option value="L" data-shiptype="dhl">EXPRESS 10:30</option>
                        <option value="N" data-shiptype="dhl">DOMESTIC EXPRESS</option>
                        <option value="O" data-shiptype="dhl">DOM EXPRESS 10:30</option>
                        <option value="R" data-shiptype="dhl">GLOBALMAIL BUSINESS</option>
                        <option value="S" data-shiptype="dhl">SAME DAY</option>
                        <option value="T" data-shiptype="dhl">EXPRESS 12:00</option>
                        <option value="V" data-shiptype="dhl">EUROPACK</option>
                        <option value="W" data-shiptype="dhl">ECONOMY SELECT</option>
                        <option value="X" data-shiptype="dhl">EXPRESS ENVELOPE</option>
                        <option value="Y" data-shiptype="dhl">EXPRESS 12:00</option>
                        <option value="Z" data-shiptype="dhl">Destination Charges</option>
                        
                    </select>, Rate Order in List: <input type="number" name="ec_new_live_order" id="ec_new_live_order" value="0"  /></div>
                    <div class="ec_failed_row ec_live_row"><input type="button" class="button-primary" value="Add Rate" onclick="ec_add_shipping_rate( 'live_based' );" /></div>
                
                    <div class="ec_failed_row"><b>Current live Based Shipping Rates:</b></div>
                    <div id="ec_live_rates">
                    <?php
                        $db = new ec_db_admin( );
                        $rates = $db->get_shipping_data( );
                        $i=0;
                        foreach( $rates as $rate ){
                            if( $rate->is_ups_based || $rate->is_usps_based || $rate->is_fedex_based || $rate->is_auspost_based || $rate->is_dhl_based ){
                                $i++;
								if( $rate->is_ups_based )
								$type = "UPS";
								if( $rate->is_usps_based )
								$type = "USPS";
								else if( $rate->is_fedex_based )
								$type = "FedEx";
								else if( $rate->is_auspost_based )
								$type = "AU Post";
								else if( $rate->is_dhl_based )
								$type = "DHL";
                        ?>
                    <div class="ec_failed_row ec_list_style_<?php echo $i%2; ?>"><div><span class="ec_live_type_column"><input type="hidden" name="ec_live_code_<?php echo $rate->shippingrate_id; ?>" id="ec_live_code_<?php echo $rate->shippingrate_id; ?>" value="<?php echo $rate->shipping_code; ?>" /><input type="hidden" name="ec_live_type_<?php echo $rate->shippingrate_id; ?>" id="ec_live_type_<?php echo $rate->shippingrate_id; ?>" value="<?php echo $type; ?>" /><?php echo $type; ?></span><span class="ec_live_label_column">Rate Label: <input type="text" value="<?php echo $rate->shipping_label; ?>" id="ec_live_label_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_live_order_column">Rate Order: <input type="number" value="<?php echo $rate->shipping_order; ?>" id="ec_live_order_<?php echo $rate->shippingrate_id; ?>" /></span><span class="ec_live_buttons_column"><input type="button" class="button-primary" value="Delete Rate" onclick="ec_delete_shipping_rate( '<?php echo $rate->shippingrate_id; ?>' );" /> <input type="button" class="button-primary" value="Update Rate" onclick="ec_update_shipping_rate( 'live_based', '<?php echo $rate->shippingrate_id; ?>' );" /></span></div></div>
                
                    <?php 	} 
                        }?>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="ec_failed_row" id="ec_live_based">Please purchase a license for the <a href="http://www.wpeasycart.com/products/?model_number=ec100" target="_blank">Full Version for $80</a> to continue with live shipping.</div>
                <?php } ?>
                <script>ec_setup_selected_shipping_structure( );</script> 
                
                <hr />
                <form method="post" action="" />
                    <div class="ec_failed_row">Finished Setting up the Shipping Structure: <select name="ec_option_checklist_shipping_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_shipping_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_shipping_complete" />
                </form>
            <?php } ?>
            
          </td>
        </tr>
    </table>
	<table width="100%" cellpadding="0" cellspacing="0" class="form-table" id="page_language">
        <tr valign="top">
            <td class="platformheading">Language and Design - <span id="percentage_language">0</span>% Complete</td>
            <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="left" scope="row">
              <?php 
			  $total_language++;
			  if( get_option( 'ec_option_checklist_language_complete' ) == "done" ){
				  		$correct_language++;
						ec_show_check( "You have finished changing the site text. <a href=\"?page=ec_language\">Click here to manage the text of your site</a>." );
					}else{
						ec_show_failed( "If you need to translate the front-end text, or change any text on the front-end, please do so <a href=\"?page=ec_language\">here</a>, then check the 'enable advanced editor' box." );
						?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Finished Setting up the Language Options: <select name="ec_option_checklist_language_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_language_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_language_complete" />
                </form>      
              <?php }?>
              
              <?php 
			  $total_language++;
			  if( get_option( 'ec_option_checklist_theme_complete' ) == "done" ){
				  		$correct_language++;
						ec_show_check( "You have selected the best theme for your site. If you would like to change the store default theme, <a href=\"?page=ec_design\">click here</a>." );
					}else{
						ec_show_failed( "By default the EasyCart is setup for a light colored background. If your site has a dark background, <a href=\"?page=ec_design\">click here</a> and select the dark design layout and theme." );
						?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Finished Selecting the Store Design: <select name="ec_option_checklist_theme_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_theme_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_theme_complete" />
                </form>      
              <?php }?>
              
              <?php 
			  $total_language++;
			  if( get_option( 'ec_option_checklist_colorization_complete' ) == "done" ){
				  		$correct_language++;
						ec_show_check( "You have finished colorizing your store theme. If you need to make more adjustements, <a href=\"?page=ec_theme_options\">click here</a>." );
					}else{
						ec_show_failed( "All of the default themes for the EasyCart come with colorization options. To colorize your store to fit with your WordPress theme, <a href=\"?page=ec_theme_options\">click here</a>. Typically you will need to change the first three colors and the link color." );
						?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Finished Selecting the Store Colors: <select name="ec_option_checklist_colorization_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_colorization_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_colorization_complete" />
                </form>      
              <?php }?>
              
              <?php 
			  $total_language++;
			  if( get_option( 'ec_option_checklist_logo_added_complete' ) == "done" ){
				  		$correct_language++;
						ec_show_check( "You have finished adding your logo to the order receipt/forgot password emails. If you need to make more adjustements, <a href=\"?page=ec_theme_options\">click here</a>." );
					}else{
						ec_show_failed( "All of the default themes for the EasyCart come with an option to add your logo to your order receipts and forgot password emails. To add your logo, <a href=\"?page=ec_theme_options\">click here</a>." );
						?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Finished Adding Your Logo: <select name="ec_option_checklist_logo_added_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_logo_added_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_logo_added_complete" />
                </form>      
              <?php }?>
           </td>
        </tr>
    </table>
	<table width="100%" cellpadding="0" cellspacing="0" class="form-table" id="page_admin">
        <tr valign="top">
            <td class="platformheading">Admin Side Setup - <span id="percentage_admin">0</span>% Complete</td>
            <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="left" scope="row">
              <?php 
			  $total_admin++;
			  if( get_option( 'ec_option_checklist_admin_embedded_complete' ) == "done" ){
				  		$correct_admin++;
						ec_show_check( "You have told us you have the embedded admin console setup. This is available <a href=\"?page=ec_adminconsole\">here</a>." );
					}else{
						ec_show_failed( "An embedded administration console can be downloaded and installed, directions and the console are available <a href=\"?page=ec_adminconsole\">here</a>." );
						?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy with this option: <select name="ec_option_checklist_admin_embedded_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_admin_embedded_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_admin_embedded_complete" />
                </form>      
              <?php }?>
              
              <?php 
			  $total_admin++;
			  if( get_option( 'ec_option_checklist_admin_consoles_complete' ) == "done" ){
				  		$correct_admin++;
						ec_show_check( "You have told us you have the admin console setup. More information is available <a href=\"?page=ec_adminconsole\">here</a>." );
					}else{
						ec_show_failed( "We offer PC/MAC, iPad, or Android administration consoles. Each can be downloaded and installed, directions and links are available <a href=\"?page=ec_adminconsole\">here</a>." );
						?>
                <form method="post" action="" />
                    <div class="ec_failed_row">Happy with this option: <select name="ec_option_checklist_admin_consoles_complete"><option value="no">Not Yet</option><option value="done"<?php if( get_option( 'ec_option_checklist_admin_consoles_complete' ) == "done" ){ echo " selected=\"selected\""; }?> >I'm Done</option></select><input type="submit" class="button-primary"  value="Save My Answer" /></div>
                    <input type="hidden" name="ec_action" value="update_option" />
                    <input type="hidden" name="ec_option_name" value="ec_option_checklist_admin_consoles_complete" />
                </form>      
              <?php }?>
              
              <h3>What is Left?</h3>
              <ol>
                  <li>Uninstall sample data first if you ever installed it. That can be <a href="?page=ec_install">done here</a>.</li>
                  <li>Add your manufacturer list, even if it is just your own company name, it is required by each product to have one. That can be done by getting on the <a href="?page=ec_adminconsole">admin console here</a> and clicking 'products' -> 'manage manufacturer list', the submenu is available on the left side of the admin console once you click products.</li>
                  <li>Add your menu items, submenu items, and subsubmenu items. That can be done by getting on the <a href="?page=ec_adminconsole">admin console here</a> and clicking 'products' -> 'manage store menu system', the submenu is available on the left side of the admin console once you click products. To read more about this <a href="http://wpeasycart.com/docs/1.0.0/administration/menu_system.php" target="_blank">click here</a></li>
                  <li>Add your option sets. That can be done by getting on the <a href="?page=ec_adminconsole">admin console here</a> and clicking 'products' -> 'manage option sets', the submenu is available on the left side of the admin console once you click products. To read more about this <a href="http://wpeasycart.com/docs/1.0.0/administration/option_system.php" target="_blank">click here</a></li>
                  <li>Start adding your products. That can be done by getting on the <a href="?page=ec_adminconsole">admin console here</a> and clicking 'products'. To read more about this <a href="http://wpeasycart.com/docs/1.0.0/administration/product_basicinfo.php" target="_blank">click here</a></li>
              </ol>
          </td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" class="form-table" id="page_complete">
        <tr valign="top">
            <td class="platformheading">Wizard Finished - Overall <span id="percentage_complete">0</span>% Completed</td>
            <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="left" scope="row">
            Your setup is complete. This setup wizard should be used as a guide to your store and you can always return to previous pages to make changes. Please notice that next to each option is a link to make changes if the option is marked as complete.
            </td>
        </tr>
    </table>
    
    <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
        <tr valign="top">
        <td class="platformheading" colspan="2"><input type="button" value="Basic Setup" onclick="show_current_page( 'basic_setup' );" id="button_bottom_basic_setup" /> <input type="button" value="Demo Data" onclick="show_current_page( 'demo_data' );" id="button_bottom_demo_data" /> <input type="button" value="Store Settings" onclick="show_current_page( 'store_settings' );" id="button_bottom_store_settings" /> <input type="button" value="Payment, Tax, Shipping" onclick="show_current_page( 'payment' );" id="button_bottom_payment" /> <input type="button" value="Language, Design" onclick="show_current_page( 'language' );" id="button_bottom_language" /> <input type="button" value="Store Administration" onclick="show_current_page( 'admin' );" id="button_bottom_admin" /> <input type="button" value="Finished" onclick="show_current_page( 'complete' );" id="button_bottom_finished" /></td>
    </tr>
    </table>
</div>

<?php
$percentage_basic = ceil( ( $correct_basic / $total_basic ) * 100 );
$percentage_demo_data = ceil( ( $correct_demo_data / $total_demo_data ) * 100 );
$percentage_store_settings = ceil( ( $correct_store_settings / $total_store_settings ) * 100 );
$percentage_payment = ceil( ( $correct_payment / $total_payment ) * 100 );
$percentage_language = ceil( ( $correct_language / $total_language ) * 100 );
$percentage_admin = ceil( ( $correct_admin / $total_admin ) * 100 );
$percentage_complete = ceil( ( ( $correct_basic + $correct_demo_data + $correct_store_settings + $correct_payment + $correct_language + $correct_admin ) / ( $total_basic + $total_demo_data + $total_store_settings + $total_payment + $total_language + $total_admin ) ) * 100 );
?>

<script>
function ec_hide_all_pages( ){
	jQuery('#page_basic_setup').hide();
	jQuery('#page_demo_data').hide();
	jQuery('#page_store_settings').hide();
	jQuery('#page_payment').hide();
	jQuery('#page_language').hide();
	jQuery('#page_admin').hide();
	jQuery('#page_complete').hide();
}

function ec_reset_buttons(){
	jQuery('#button_top_basic_setup').removeClass('selectedpage');
	jQuery('#button_top_demo_data').removeClass('selectedpage');
	jQuery('#button_top_store_settings').removeClass('selectedpage');
	jQuery('#button_top_payment').removeClass('selectedpage');
	jQuery('#button_top_language').removeClass('selectedpage');
	jQuery('#button_top_admin').removeClass('selectedpage');
	jQuery('#button_top_finished').removeClass('selectedpage');
	
	jQuery('#button_bottom_basic_setup').removeClass('selectedpage');
	jQuery('#button_bottom_demo_data').removeClass('selectedpage');
	jQuery('#button_bottom_store_settings').removeClass('selectedpage');
	jQuery('#button_bottom_payment').removeClass('selectedpage');
	jQuery('#button_bottom_language').removeClass('selectedpage');
	jQuery('#button_bottom_admin').removeClass('selectedpage');
	jQuery('#button_bottom_finished').removeClass('selectedpage');
}

function show_current_page( page ){
	ec_hide_all_pages();
	ec_reset_buttons();
	
	// Update the page in php
	var data = {
		action: 'ec_ajax_update_option',
		option_name: 'ec_option_checklist_page',
		option_value: page
	};
	
	jQuery.ajax( {url: ajax_object.ajax_url, type: 'post', data: data } );
	
	// Update the view
	if( page == "demo_data" ){
		jQuery('#page_demo_data').fadeIn( 250 );
		jQuery('#button_top_demo_data').addClass('selectedpage');
		jQuery('#button_bottom_demo_data').addClass('selectedpage');
	}else if( page == "store_settings" ){
		jQuery('#page_store_settings').fadeIn( 250 );
		jQuery('#button_top_store_settings').addClass('selectedpage');
		jQuery('#button_bottom_store_settings').addClass('selectedpage');
	}else if( page == "payment" ){
		jQuery('#page_payment').fadeIn( 250 );
		jQuery('#button_top_payment').addClass('selectedpage');
		jQuery('#button_bottom_payment').addClass('selectedpage');
	}else if( page == "language" ){
		jQuery('#page_language').fadeIn( 250 );
		jQuery('#button_top_language').addClass('selectedpage');
		jQuery('#button_bottom_language').addClass('selectedpage');
	}else if( page == "admin" ){
		jQuery('#page_admin').fadeIn( 250 );
		jQuery('#button_top_admin').addClass('selectedpage');
		jQuery('#button_bottom_admin').addClass('selectedpage');
	}else if( page == "complete" ){
		jQuery('#page_complete').fadeIn( 250 );
		jQuery('#button_top_finished').addClass('selectedpage');
		jQuery('#button_bottom_finished').addClass('selectedpage');
	}else{
		jQuery('#page_basic_setup').fadeIn( 250 );
		jQuery('#button_top_basic_setup').addClass('selectedpage');
		jQuery('#button_bottom_basic_setup').addClass('selectedpage');
	}
}
show_current_page( '<?php echo get_option( 'ec_option_checklist_page' ); ?>' );
document.getElementById( 'percentage_basic' ).innerHTML = <?php echo $percentage_basic; ?>;
document.getElementById( 'percentage_demo_data' ).innerHTML = <?php echo $percentage_demo_data; ?>;
document.getElementById( 'percentage_store_settings' ).innerHTML = <?php echo $percentage_store_settings; ?>;
document.getElementById( 'percentage_payment' ).innerHTML = <?php echo $percentage_payment; ?>;
document.getElementById( 'percentage_language' ).innerHTML = <?php echo $percentage_language; ?>;
document.getElementById( 'percentage_admin' ).innerHTML = <?php echo $percentage_admin; ?>;
document.getElementById( 'percentage_complete' ).innerHTML = <?php echo $percentage_complete; ?>;
</script>