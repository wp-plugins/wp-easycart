<?php
/**
 * Plugin Name: WP EasyCart
 * Plugin URI: http://www.wpeasycart.com
 * Description: The WordPress Shopping Cart by WP EasyCart is a simple ecommerce solution that installs into new or existing WordPress blogs. Customers purchase directly from your store! Get a full ecommerce platform in WordPress! Sell products, downloadable goods, gift cards, clothing and more! Now with WordPress, the powerful features are still very easy to administrate! If you have any questions, please view our website at <a href="http://www.wpeasycart.com" target="_blank">WP EasyCart</a>.  <br /><br /><strong>*** UPGRADING? Please be sure to backup your plugin, or follow our upgrade instructions at <a href="http://www.wpeasycart.com/docs/3.0.0/index/upgrading.php" target="_blank">WP EasyCart Upgrading</a> ***</strong>
 
 * Version: 3.1.10
 * Author: Level Four Development, llc
 * Author URI: http://www.wpeasycart.com
 *
 * This program is free to download and install, but requires the purchase of our ecommerce shopping cart admin plugin to use live payment gateways, coupons, promotions, and more.
 * Each site requires a license for live use and must be purchased through the WP EasyCart website.
 *
 * @package wpeasycart
 * @version 3.1.10
 * @author WP EasyCart <sales@wpeasycart.com>
 * @copyright Copyright (c) 2012, WP EasyCart
 * @link http://www.wpeasycart.com
 */
 
define( 'EC_PUGIN_NAME', 'WP EasyCart');
define( 'EC_PLUGIN_DIRECTORY', 'wp-easycart');
define( 'EC_CURRENT_VERSION', '3_1_10' );
define( 'EC_CURRENT_DB', '1_30' );
define( 'EC_UPGRADE_DB', '36' );

add_action( 'init', 'wpeasycart_start_session', 1 );
add_action( 'init', 'wpeasycart_load_startup', 1 );
add_action( 'wp_logout', 'wpeasycart_end_session' );
add_action( 'wp_login', 'wpeasycart_end_session' );

function wpeasycart_start_session( ){
    if( wpeasycart_config_is_session_started( ) === FALSE ){
        session_start( );
    }
}

function wpeasycart_load_startup( ){

	require_once( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/ec_config.php' );
	
	// Setup Hook Structure
	ec_setup_hooks( );
	
	// Check and add hooks
	if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/ec_hooks.php" ) )
		include( WP_PLUGIN_DIR . "/wp-easycart-data/ec_hooks.php" );
}

function wpeasycart_end_session( ){
    session_destroy( );
}

function wpeasycart_config_is_session_started( ){

	if( php_sapi_name( ) !== 'cli' ){
		
		if( version_compare( phpversion( ), '5.4.0', '>=' ) ){
			return session_status( ) === PHP_SESSION_ACTIVE ? TRUE : FALSE;
		
		}else{
			return session_id() === '' ? FALSE : TRUE;
		}
		
	}
	
	return FALSE;

}

function ec_activate(){
		
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_db.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_db_admin.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_language.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_setting.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_wpoption.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_wpoptionset.php' );
	
	if( !get_option( 'ec_option_db_version' ) ){
		add_option( 'ec_option_db_new_version', EC_UPGRADE_DB );
	}
	
	// ADD WORDPRESS OPTIONS
	$wpoptions = new ec_wpoptionset();
	$wpoptions->add_options();
	
	//INITIALIZE DATABASE
	$mysqli = new ec_db();
	
	// FIRST ATTEMPT TO INSTALL THE INITIAL VERSION.
	$install_sql_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/sql/install_' . EC_CURRENT_DB . '.sql';
	$f = fopen( $install_sql_url, "r" ) or die( "Could not open the install sql script. Likely the permissions on the file when copied from WordPress are preventing our activation script from accessing the install script. To fix this issue, look in your default wordpress plugins folder, then change the permissions on the following file to 775: wp-easycart/inc/admin/sql/install_x_x.sql (look for the highest version). Please submit a support ticket at www.wpeasycart.com with FTP access if you wish to have the WP EasyCart staff help you get up and running." );
	
	$install_sql = fread( $f, filesize( $install_sql_url ) );
	$install_sql_array = explode(';', $install_sql);
	$mysqli->install( $install_sql_array );
	// END SQL INSTALLER
	
	// UPDATE SITE URL
	$site = explode( "://", ec_get_url( ) );
	$site = $site[1];
	$mysqli->update_url( $site );
	// END UPDATE SITE URL 
	
	//SETUP BASIC LANGUAGE SETTINGS
	$language = new ec_language( );
	$language->update_language_data( ); //Do this to update the database if a new language is added
	
	//WE BLOCK THIS FROM THE ec_config.php TO PREVENT OUTPUT ON ACTIVATION, INCLUDE HERE...
	update_option( 'ec_option_is_installed', '1' );
	$GLOBALS['setting'] = new ec_setting( );
	
	// FIX FOR CURRENCY ISSUES
	if( get_option( 'ec_option_currency' ) == '&#36;' ){
		update_option( 'ec_option_currency', '$' );	
	}
	// END FIX FOR CURRENCY ISSUES
	
	// IF NO wp-easycart-data FOLDER
	// SHOULD ONLY RUN ON FIRST INSTALL
	if( !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){
		
		$to = WP_PLUGIN_DIR . "/wp-easycart-data/";
		$from = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
		
		// CHECK IF WRITABLE
		if( !is_writable( WP_PLUGIN_DIR ) ){
			
			// We really can't do anything now about the data folder. Lets try and get people to do this in the install page.
			
		}else{
		
			// For a first time install, use the old linking style
			update_option( 'ec_option_use_old_linking_style', '1' );
			
			mkdir( $to, 0755 );
			
			// COPY FROM wp-easycart to wp-easycart-data
			wpeasycart_copyr( $from . "products", $to . "products" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/" );
			
		}
	}
	
	// Create Uploads folder if it doesn't exist
	if( !is_dir( WP_PLUGIN_DIR . "/wp-easycart/products/uploads/" ) ){
		mkdir( WP_PLUGIN_DIR . "/wp-easycart/products/uploads/" );
	}
	if( !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" ) ){
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" );
	}
	
	// Fix for new installs, make sure the smart states is set to true. This is because old installs would be messed up without this.
	global $wpdb;
	$fixrow = $wpdb->get_row( "SELECT ec_state.id_sta FROM ec_state WHERE ec_state.name_sta = 'FIXFORFRESHINSTALLS'" );
	if( $fixrow ){
		update_option( 'ec_option_use_smart_states', '1' );
		update_option( 'ec_option_display_country_top', '1' );
		update_option( 'ec_option_use_address2', '1' );
		$wpdb->query( "DELETE FROM ec_state WHERE ec_state.name_sta = 'FIXFORFRESHINSTALLS'" );
	}
	
}

function ec_uninstall(){
		
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_db.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_db_admin.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_language.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_setting.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_wpoption.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_wpoptionset.php' );
	
	$mysqli = new ec_db();
	
	$uninstall_sql_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/sql/uninstall_' .  get_option( 'ec_option_db_version' ) . '.sql';
	
	if( file_exists( $uninstall_sql_url ) ){
		$f = fopen( $uninstall_sql_url, "r" );	
		$uninstall_sql = fread( $f, filesize( $uninstall_sql_url ) );
		$uninstall_sql_array = explode(';', $uninstall_sql);
		$mysqli->uninstall( $uninstall_sql_array );
	}
	
	//delete options
	$wpoptions = new ec_wpoptionset();
	$wpoptions->delete_options();
	delete_option( 'ec_option_db_new_version' );
	
	$data_dir = WP_PLUGIN_DIR . "/wp-easycart-data/";
	if( is_dir( $data_dir ) && !is_writable( $data_dir ) ){
		// Could not open the file, lets write it via ftp!
		$ftp_server = $_POST['hostname'];
		$ftp_user_name = $_POST['username'];
		$ftp_user_pass = $_POST['password'];
		
		// set up basic connection
		$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
		
		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		if( !$login_result ){
			
			die( "Could not connect to your server via FTP to uninstall your wp-easycart. Please remove the files manually." );
			
		}else{
			ec_delete_directory_ftp( $conn_id, $data_dir );
		}
	}else{
		ec_recursive_remove_directory( $data_dir );
	}
	
	// Clean up linking structure
	$store_posts = get_posts( array( 'post_type' => 'ec_store', 'posts_per_page' => 10000 ) );
	foreach( $store_posts as $store_post ) {
		wp_delete_post( $store_post->ID, true);
	}
}

register_activation_hook( __FILE__, 'ec_activate' );
register_uninstall_hook( __FILE__, 'ec_uninstall' );

function load_ec_pre(){
	
	// UPGRADE THE DB IF NEEDED
	if( get_option( 'ec_option_db_version' ) && EC_CURRENT_DB != get_option( 'ec_option_db_version' ) ){
		$update_sql_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/sql/upgrade_' . get_option( 'ec_option_db_version') . '_to_' . EC_CURRENT_DB . '.sql';
		$f = fopen( $update_sql_url, "r") or die("The Wp EasyCart plugin was unable to access the database upgrade script. Upgrade halted. To fix this problem, change the permissions on the following files to 775 and try again: wp-easycart/inc/admin/sql/upgrade_x_x_to_x_x (change all upgrade files unless you know what plugin DB version you have and which you are upgrading to). Contact WP EasyCart support by submitting a support ticket at www.wpeasycart.com with FTP access for assistance.");
		$upgrade_sql = fread( $f, filesize( $update_sql_url ) );
		$upgrade_sql_array = explode(';', $upgrade_sql);
		$db = new ec_db();
		$db->upgrade( $upgrade_sql_array );
		update_option( 'ec_option_db_version', EC_CURRENT_DB );
	}
	// STARTING 3.0.23 (post DB 30), CHANGED DB UPGRADE METHOD
	if( !get_option( 'ec_option_db_new_version' ) ){ // If not set, lets start with 30 and upgrade from there
		$ec_db_version = 30;
	}else{
		$ec_db_version = intval( get_option( 'ec_option_db_new_version' ) );
	}
	
	if( $ec_db_version < EC_UPGRADE_DB ){
		$db = new ec_db();
		while( $ec_db_version < EC_UPGRADE_DB ){
			$ec_db_version++; // Update version, upgrade using that script
			
			$update_sql_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/sql/upgrade_' . $ec_db_version . '.sql';
			if( file_exists( $update_sql_url ) ){
				$f = fopen( $update_sql_url, "r") or exit( "file permissions not allowing us to upgrade with file '" . $update_sql_url . "'." );
				$upgrade_sql = fread( $f, filesize( $update_sql_url ) );
				$upgrade_sql_array = explode(';', $upgrade_sql);
				$db->upgrade( $upgrade_sql_array );
			}
		}
		update_option( 'ec_option_db_new_version', EC_UPGRADE_DB );
	}
	// END UPGRADE THE DB IF NEEDED
	
	update_option( 'ec_option_is_installed', '1' );
	
	// CREATE DATA FOLDER IF IT DOESN'T EXIST
	if( !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){
		
		$to = WP_PLUGIN_DIR . "/wp-easycart-data/";
		$from = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
		
		if( !is_writable( WP_PLUGIN_DIR ) ){
			
			// We really can't do anything now about the data folder. Lets try and get people to do this in the install page.
			
		}else{
			mkdir( $to, 0755 );
			
			// Now backup
			wpeasycart_copyr( $from . "products", $to . "products" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/" );
			
		}
	}
	// END CREATE DATA FOLDER IF IT DOESN'T EXIST
	
	// CHECK FOR PRODUCTS FOLDER STRUCTURE IN MAIN FOLDER, ADD IF NEEDED
	$products_folder = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/";
	$banners = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/banners/";
	$downloads = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/downloads/";
	$pics1  = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/pics1/";
	$pics2 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/pics2/";
	$pics3 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/pics3/";
	$pics4 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/pics4/";
	$pics5 = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/pics5/";
	$swatches = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/swatches/";
	$uploads = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/uploads/";
	
	if( !is_dir( $products_folder ) )
		mkdir( $products_folder, 0755 );
		
	if( !is_dir( $banners ) )
		mkdir( $banners, 0755 );
		
	if( !is_dir( $downloads ) )
		mkdir( $downloads, 0751 );
		
	if( !is_dir( $pics1 ) )
		mkdir( $pics1, 0755 );
		
	if( !is_dir( $pics2 ) )
		mkdir( $pics2, 0755 );
		
	if( !is_dir( $pics3 ) )
		mkdir( $pics3, 0755 );
		
	if( !is_dir( $pics4 ) )
		mkdir( $pics4, 0755 );
		
	if( !is_dir( $pics5 ) )
		mkdir( $pics5, 0755 );
		
	if( !is_dir( $swatches ) )
		mkdir( $swatches, 0755 );
		
	if( !is_dir( $uploads ) )
		mkdir( $uploads, 0751 );
	
	// END CHECK FOR PRODUCTS FOLDER
	
	// CHECK FOR PRODUCTS FOLDER STRUCTURE IN DATA FOLDER, ADD IF NEEDED
	$products_folder = WP_PLUGIN_DIR . "/wp-easycart-data/products/";
	$banners = WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/";
	$downloads = WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/";
	$pics1  = WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/";
	$pics2 = WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/";
	$pics3 = WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/";
	$pics4 = WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/";
	$pics5 = WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/";
	$swatches = WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/";
	$uploads = WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/";
	
	if( !is_dir( $products_folder ) )
		mkdir( $products_folder, 0755 );
		
	if( !is_dir( $banners ) )
		mkdir( $banners, 0755 );
		
	if( !is_dir( $downloads ) )
		mkdir( $downloads, 0751 );
		
	if( !is_dir( $pics1 ) )
		mkdir( $pics1, 0755 );
		
	if( !is_dir( $pics2 ) )
		mkdir( $pics2, 0755 );
		
	if( !is_dir( $pics3 ) )
		mkdir( $pics3, 0755 );
		
	if( !is_dir( $pics4 ) )
		mkdir( $pics4, 0755 );
		
	if( !is_dir( $pics5 ) )
		mkdir( $pics5, 0755 );
		
	if( !is_dir( $swatches ) )
		mkdir( $swatches, 0755 );
		
	if( !is_dir( $uploads ) )
		mkdir( $uploads, 0751 );
	
	// END CHECK FOR PRODUCTS FOLDER
	
	///////////////////////////////////////////////////////////////////////////////////
	// This is a check to ensure old users are upgraded to the new linking format
	///////////////////////////////////////////////////////////////////////////////////
	if( !get_option( 'ec_option_new_linking_setup' ) ){
		$db = new ec_db();
		$menulevel1_items = $db->get_menulevel1_items( );
		$menulevel2_items = $db->get_menulevel2_items( );
		$menulevel3_items = $db->get_menulevel3_items( );
		$product_list = $db->get_product_list( "", "", "", "" );
		$category_list = $db->get_category_list( );
		$manufacturer_list = $db->get_manufacturer_list( );
		
		foreach( $menulevel1_items as $menu_item ){
			if( $menu_item->menulevel1_post_id == 0 ){
				// Add a post id
				$post = array(	'post_content'	=> "[ec_store menuid=\"" . $menu_item->menulevel1_id . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $menu_item->menu1_name,
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post );
				$db->update_menu_post_id( $menu_item->menulevel1_id, $post_id );
			}
		}
		
		foreach( $menulevel2_items as $menu_item ){
			if( $menu_item->menulevel2_post_id == 0 ){
				// Add a post id
				$post = array(	'post_content'	=> "[ec_store submenuid=\"" . $menu_item->menulevel2_id . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $menu_item->menu2_name,
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post );
				$db->update_submenu_post_id( $menu_item->menulevel2_id, $post_id );
			}
		}
		
		foreach( $menulevel3_items as $menu_item ){
			if( $menu_item->menulevel3_post_id == 0 ){
				// Add a post id
				$post = array(	'post_content'	=> "[ec_store subsubmenuid=\"" . $menu_item->menulevel3_id . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $menu_item->menu3_name,
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post );
				$db->update_subsubmenu_post_id( $menu_item->menulevel3_id, $post_id );
			}
		}
	
		foreach( $product_list as $product_single ){
			if( $product_single->post_id == 0 ){
				// Add a post id
				$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product_single['model_number'] . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $product_single['title'],
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post );
				$db->update_product_post_id( $product_single['product_id'], $post_id );
			}
		}
	
		foreach( $manufacturer_list as $manufacturer_single ){
			if( $manufacturer_single->post_id == 0 ){
				// Add a post id
				$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturer_single->manufacturer_id . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $manufacturer_single->name,
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post );
				$db->update_manufacturer_post_id( $manufacturer_single->manufacturer_id, $post_id );
			}
		}
	
		foreach( $category_list as $category_single ){
			if( $category_single->post_id == 0 ){
				// Add a post id
				$post = array(	'post_content'	=> "[ec_store groupid=\"" . $category_single->category_id . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $category_single->category_name,
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post );
				$db->update_category_post_id( $category_single->category_id, $post_id );
			}
		}
		
		update_option( 'ec_option_new_linking_setup', 1 );
	}
	///////////////////////////////////////////////////////////////////////////////////
	// END - linkage check
	///////////////////////////////////////////////////////////////////////////////////
	
	// START STATS AND FORM PROCESSING
	$storepageid = get_option('ec_option_storepage');
	$cartpageid = get_option('ec_option_cartpage');
	$accountpageid = get_option('ec_option_accountpage');
	
	if( function_exists( 'icl_object_id' ) ){
		$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
		$cartpageid = icl_object_id( $cartpageid, 'page', true, ICL_LANGUAGE_CODE );
		$accountpageid = icl_object_id( $accountpageid, 'page', true, ICL_LANGUAGE_CODE );
	}
	
	$storepage = get_permalink( $storepageid );
	$cartpage = get_permalink( $cartpageid );
	$accountpage = get_permalink( $accountpageid );
			
	if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
		$https_class = new WordPressHTTPS( );
		$storepage = $https_class->makeUrlHttps( $storepage );
		$cartpage = $https_class->makeUrlHttps( $cartpage );
		$accountpage = $https_class->makeUrlHttps( $accountpage );
	}
	
	if(substr_count($storepage, '?'))							$permalinkdivider = "&";
	else														$permalinkdivider = "?";
	
	if( isset( $_SERVER['HTTPS'] ) )							$currentpageid = url_to_postid( "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	else														$currentpageid = url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	
	if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && isset( $_GET['error_description'] ) && get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" ){
		$db = new ec_db( );
		$db->insert_response( $_GET['order_id'], 1, "Dwolla Third Party", print_r( $_GET, true ) );
		header( "location: " . $accountpage . $permalinkdivider . "ec_page=order_details&order_id=" . $_GET['order_id'] . "&ec_error=dwolla_error" );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" && isset( $_GET['signature'] ) && isset( $_GET['checkoutId'] ) && isset( $_GET['amount'] ) ){
		
		$dwolla_verification = ec_dwolla_verify_signature( $_GET['signature'], $_GET['checkoutId'], $_GET['amount'] );
		if( $dwolla_verification ){
			$db = new ec_db( );
			$db->update_order_status( $_GET['order_id'], "10" );
				
			// send email
			$order_row = $db->get_order_row( $_GET['order_id'], "guest", "guest" );
			$order_display = new ec_orderdisplay( $order_row, true );
			$order_display->send_email_receipt( );

			// Quickbooks Hook
			if( file_exists( WP_PLUGIN_DIR . "/" . EC_QB_PLUGIN_DIRECTORY . "/ec_quickbooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->add_order( $order_id );
			}
			
			header( "location: " . $cartpage . $permalinkdivider . "ec_page=checkout_success&order_id=" . $_GET['order_id'] );
			
		}else{
			$db = new ec_db( );
			$db->insert_response( $_GET['order_id'], 1, "Dwolla Third Party", print_r( $_GET, true ) );
			header( "location: " . $accountpage . $permalinkdivider . "ec_page=order_details&order_id=" . $_GET['order_id'] . "&ec_error=dwolla_error" );
	
		}
	}
	
	/* Update the Menu and Product Statistics */
	if( isset( $_GET['model_number'] ) ){
		$db = new ec_db( );
		$db->update_product_views( $_GET['model_number'] );
	}else if( isset( $_GET['menuid'] ) ){
		$db = new ec_db( );
		$db->update_menu_views( $_GET['menuid'] );	
	}else if( isset( $_GET['submenuid'] ) ){
		$db = new ec_db( );
		$db->update_submenu_views( $_GET['submenuid'] );	
	}else if( isset( $_GET['subsubmenuid'] ) ){
		$db = new ec_db( );
		$db->update_subsubmenu_views( $_GET['subsubmenuid'] );	
	}
	
	/* Cart Form Actions, Process Prior to WP Loading */
	if( isset( $_POST['ec_cart_form_action'] ) ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( $_POST['ec_cart_form_action'] );
	}else if( isset( $_GET['ec_cart_action'] ) ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( $_GET['ec_cart_action'] );	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "3dsecure" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "3dsecure" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "third_party" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "third_party_forward" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "realex_redirect" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "realex_redirect" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "realex_response" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "realex_response" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "process_affirm" ){
		$ec_cartpage = new ec_cartpage( true );
		$ec_cartpage->process_form_action( "submit_order" );
	}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "deconetwork_add_to_cart" ){
		$ec_cartpage = new ec_cartpage( true );
		$ec_cartpage->process_form_action( "deconetwork_add_to_cart" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "paymentexpress" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "paymentexpress_thirdparty_response" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "nets_return" && isset( $_GET['transactionId'] ) ){
		global $wpdb;
		$order_id = $wpdb->get_var( $wpdb->prepare( "SELECT ec_order.order_id FROM ec_order WHERE ec_order.nets_transaction_id = %s", $_GET['transactionId'] ) );
		
		$nets = new ec_nets( );
		$nets->process_payment_final( $order_id, $_GET['transactionId'], $_GET['responseCode'] );
	}
	
	/* Account Form Actions, Process Prior to WP Loading */
	if( isset( $_POST['ec_account_form_action'] ) ){
		$ec_accountpage = new ec_accountpage();
		$ec_accountpage->process_form_action( $_POST['ec_account_form_action'] );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "logout" ){
		$ec_accountpage = new ec_accountpage();
		$ec_accountpage->process_form_action( "logout" );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "print_receipt" ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/scripts/print_receipt.php" );
		die( );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "activate_account" && isset( $_GET['email'] ) && isset( $_GET['key'] ) ){
		$db = new ec_db( );
		$is_activated = $db->activate_user( $_GET['email'], $_GET['key'] );
		if( $is_activated ){
			header( "location: " . $account_page . $permalinkdivider . "ec_page=login&account_success=activation_success" );
		}else{
			header( "location: " . $account_page . $permalinkdivider . "ec_page=login&account_error=activation_error" );
		}
	}
	
	/* Newsletter Form Actions */
	if( isset( $_POST['ec_newsletter_email'] ) ){
		
		if( isset( $_POST['ec_newsletter_name'] ) )
			$newsletter_name = $_POST['ec_newsletter_name'];
		else
			$newsletter_name = "";
		
		$ec_db = new ec_db();
		$ec_db->insert_subscriber( $_POST['ec_newsletter_email'], $newsletter_name, "" );
			
		// MyMail Hook
		if( function_exists( 'mymail' ) ){
			$subscriber_id = mymail('subscribers')->add(array(
				'email' => $email,
				'status' => 1,
			), false );
		}
		
		$_SESSION['ec_newsletter_popup'] = 'hide';
		setcookie( 'ec_newsletter_popup', $_SESSION['ec_newsletter_popup'], time( ) + ( 10 * 365 * 24 * 60 * 60 ) );
	}
	
	// END STATS AND FORM PROCESSING
	
	// FIX FOR PRODUCT LIST DROP DOWN
	if( !get_option( 'ec_option_product_filter_1' ) && !get_option( 'ec_option_product_filter_2' ) && !get_option( 'ec_option_product_filter_3' ) && !get_option( 'ec_option_product_filter_4' ) && !get_option( 'ec_option_product_filter_5') && !get_option( 'ec_option_product_filter_6') && !get_option( 'ec_option_product_filter_7' ) ){
		update_option( 'ec_option_product_filter_1', '1' );
		update_option( 'ec_option_product_filter_2', '1' );
		update_option( 'ec_option_product_filter_3', '1' );
		update_option( 'ec_option_product_filter_4', '1' );
		update_option( 'ec_option_product_filter_5', '1' );
		update_option( 'ec_option_product_filter_6', '1' );
		update_option( 'ec_option_product_filter_7', '1' );
	}
	// END FIX FOR PRODUCT LIST DROP DOWN
	
	// FIX FOR QUERY SPEED ISSUES NEED TO CREATE EXTRA CONNECTING TABLE
	if( !get_option( 'ec_option_query_fix' ) ){
		
		global $wpdb;
		$products = $wpdb->get_results( "SELECT ec_product.* FROM ec_product" );
		foreach( $products as $product ){
			
			if( $product->menulevel1_id_1 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, menu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel1_id_1 ) );
			
			if( $product->menulevel2_id_1 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, menu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel2_id_1 ) );
			
			if( $product->menulevel3_id_1 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, menu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel3_id_1 ) );
			
			if( $product->menulevel1_id_2 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, submenu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel1_id_2 ) );
			
			if( $product->menulevel2_id_2 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, submenu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel2_id_2 ) );
			
			if( $product->menulevel3_id_2 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, submenu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel3_id_2 ) );
				
			if( $product->menulevel1_id_3 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, subsubmenu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel1_id_3 ) );
			
			if( $product->menulevel2_id_3 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, subsubmenu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel2_id_3 ) );
			
			if( $product->menulevel3_id_3 )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, subsubmenu_id ) VALUES( %d, %d )", $product->product_id, $product->menulevel3_id_3 ) );
			
			if( $product->manufacturer_id )
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_atts( product_id, manufacturer_id ) VALUES( %d, %d )", $product->product_id, $product->manufacturer_id ) );
		}
		
		update_option( 'ec_option_query_fix', 1 );
		
	}// CLOSE FIX FOR QUERY
	
	update_option( 'ec_option_is_installed', '1' );
	
} // CLOSE PRE FUNCTION

function ec_custom_headers( ){
	if( isset( $_GET['order_id'] ) && isset( $_GET['orderdetail_id'] ) && isset( $_GET['download_id'] ) && isset( $_SESSION['ec_email'] ) && isset( $_SESSION['ec_password'] ) ){
		$mysqli = new ec_db( );
		$orderdetail_row = $mysqli->get_orderdetail_row( $_GET['order_id'], $_GET['orderdetail_id'], $_SESSION['ec_email'], $_SESSION['ec_password'] );
		$ec_orderdetail = new ec_orderdetail( $orderdetail_row, 1 );
	}
	
	if( isset( $_GET['ec_page'] ) && ( $_GET['ec_page'] == "checkout_payment" || $_GET['ec_page'] == "checkout_shipping" || $_GET['ec_page'] == "checkout_info" ) ){
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.
	}
}

function ec_cache_management( ){
	if( get_option( 'ec_option_caching_on' ) ){
		// File does not exist at all
		if( !file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css" ) ){
			ec_regenerate_css( );
			ec_regenerate_js( );
			update_option( 'ec_option_cached_date', time( ) );
		}
		
		// Use cache management system
		else if( get_option( 'ec_option_cache_update_period' ) ){
			
			$update_time = true;
			$new_time = time( );
			
			// Use a automatic cache builder and the last update has not been set
			if( get_option( 'ec_option_cache_update_period' ) && !get_option( 'ec_option_cached_date' ) ){
				ec_regenerate_css( );
				ec_regenerate_js( );
			}
			
			// Cache update daily
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 day") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Cache update weekly
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 week") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Cache update monthly
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 month") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Cache update yearly
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 year") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Do not update
			else{
				$update_time = false;
			}
			
			if( $update_time ){
				update_option( 'ec_option_cached_date', $new_time );
			}
		}
	}else{
		ec_regenerate_css( );
		ec_regenerate_js( );
		update_option( 'ec_option_cached_date', time( ) );
	}
}

function ec_css_loader_v3( ){
	
	$pageURL = 'http';
	if( isset( $_SERVER["HTTPS"] ) )
		$pageURL .= "s";
		
	if( current_user_can( 'manage_options' ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.css' ) ){
			wp_register_style( 'wpeasycart_admin_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.css' ) );
		}else{
			wp_register_style( 'wpeasycart_admin_css', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/live-editor.css' ) );
		}
		wp_enqueue_style( 'wpeasycart_admin_css' );
	}
	
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.css' ) ){
		wp_register_style( 'wpeasycart_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.css' ), array( ), EC_CURRENT_VERSION );
	}else{
		wp_register_style( 'wpeasycart_css', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/ec-store.css' ), array( ), EC_CURRENT_VERSION );
	}
	wp_enqueue_style( 'wpeasycart_css' );
	
	wp_register_style( "wpeasycart_gfont", $pageURL . "://fonts.googleapis.com/css?family=Lato|Monda|Open+Sans|Droid+Serif" );
	wp_enqueue_style( 'wpeasycart_gfont' );
	
	if( get_option( 'ec_option_use_rtl' ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/rtl_support.css' ) ){
			wp_register_style( 'wpeasycart_rtl_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/rtl_support.css' ) );
		}else{
			wp_register_style( 'wpeasycart_rtl_css', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/rtl_support.css' ) );
		}
		wp_enqueue_style( 'wpeasycart_rtl_css' );
	}

}

function ec_js_loader_v3( ){
		
	if( current_user_can( 'manage_options' ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.js' ) ){
			wp_enqueue_script( 'wpeasycart_admin_js', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable' ), EC_CURRENT_VERSION );
		}else{
			wp_enqueue_script( 'wpeasycart_admin_js', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/live-editor.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable' ), EC_CURRENT_VERSION );
		}
	}
	
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.js' ) ){
		wp_enqueue_script( 'wpeasycart_js', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion' ), EC_CURRENT_VERSION );
	}else{
		wp_enqueue_script( 'wpeasycart_js', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/ec-store.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion' ), EC_CURRENT_VERSION );
	}

}

function ec_regenerate_css( ){
	ob_start( "ec_save_css_file" );
	include( ABSPATH . "wp-content/plugins/" . EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_css_generator.php' );
	ob_end_flush();
}

function ec_save_css_file( $buffer ){
	file_put_contents( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css", $buffer );
}

function ec_regenerate_js( ){
	if( file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_account_billing_information/" ) ){ //check to see if any of the old folders exist
		ob_start( "ec_save_js_file" );
		include( ABSPATH . "wp-content/plugins/" . EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_js_generator.php' );
		ob_end_flush();
	}
}

function ec_save_js_file( $buffer ){
	file_put_contents( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-js.js", $buffer );
}

function ec_load_css( ){
	
	if( !get_option( 'ec_option_base_theme' ) || file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) || !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_image_not_found.jpg" ) ){
		ec_css_loader_v3( );
	
	}else{
		ec_cache_management( );
	
		if( file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css" ) && filesize( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css" ) ){
			// Load the cached file because it exists
			wp_register_style( 'wpeasycart_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store-css.css' ) );
			wp_enqueue_style( 'wpeasycart_css' );
		
		}else{
			// File did not exist, revert back to the development mode loader
			wp_register_style( 'wpeasycart_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_css_loader.php' ) );
			wp_enqueue_style( 'wpeasycart_css' );
		}
		
		$gfont_list = "";
		$font_list = explode( ":::", get_option( 'ec_option_font_replacements' ) );
		$fonts_added = 0;
		
		for( $i=0; $i<count( $font_list ); $i++ ){
			$temp = explode( "=", $font_list[$i] );
			if(  	$temp[1] != "Verdana, Geneva, sans-serif" && 
					$temp[1] != "Georgia, Times New Roman, Times, serif" && 
					$temp[1] != "Courier New, Courier, monospace" && 
					$temp[1] != "Arial, Helvetica, sans-serif" && 
					$temp[1] != "Tahoma, Geneva, sans-serif" && 
					$temp[1] != "Trebuchet MS, Arial, Helvetica, sans-serif" && 
					$temp[1] != "Arial Black, Gadget, sans-serif" && 
					$temp[1] != "Times New Roman, Times, serif" && 
					$temp[1] != "Palatino Linotype, Book Antiqua, Palatino, serif" && 
					$temp[1] != "Lucida Sans Unicode, Lucida Grande, sans-serif" && 
					$temp[1] != "MS Serif, New York, serif" && 
					$temp[1] != "Lucida Console, Monaco, monospace" && 
					$temp[1] != "Comic Sans MS, cursive" &&
					$temp[1] != ""
			){
				if( $fonts_added > 0 )
					$gfont_list .= "|";
				
				$gfont_list .= $temp[1];
				$fonts_added++;
				
			}
		}
		
		if( $fonts_added > 0 ){
			$pageURL = 'http';
			if( isset( $_SERVER["HTTPS"] ) )
				$pageURL .= "s";
			
			wp_register_style( "wpeasycart_gfont", $pageURL . "://fonts.googleapis.com/css?family=" . $gfont_list );
			wp_enqueue_style( 'wpeasycart_gfont' );
		}
		
	}
	
}	

function ec_load_js( ){
	
	if( !get_option( 'ec_option_base_theme' ) || file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) || !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_image_not_found.jpg" ) ){
		ec_js_loader_v3( );
	
	}else{
		
		if( file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-js.js" ) && filesize( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-js.js" ) ){
			// Load the cached file because it exists
			wp_register_script( 'wpeasycart_js', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store-js.js' ), array( 'jquery' ) );
			wp_enqueue_script( 'wpeasycart_js' );
		
		}else{
			// File did not exist, revert back to the development mode loader
			wp_register_script( 'wpeasycart_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_js_loader.php' ), array( 'jquery' ) );
			wp_enqueue_script( 'wpeasycart_js' );
		}
		
	}
	
	$ajax_subfolder = "";
	if( file_exists( plugins_url( 'wp-easycart-data/ajax-subfolder.txt' ) ) ){
		$ajax_subfolder = file_get_contents( plugins_url( 'wp-easycart-data/ajax-subfolder.txt' ) );
	}
	
	$https_link = "";
	if( class_exists( "WordPressHTTPS" ) ){
		$https_class = new WordPressHTTPS( );
		if( $ajax_subfolder != "" ){
			$https_link = $https_class->getHttpsUrl() . $ajax_subfolder . '/wp-admin/admin-ajax.php';
		}else{
			$https_link = $https_class->makeUrlHttps( admin_url( 'admin-ajax.php' ) );
		}
	}else{
		$https_link = str_replace( "http://", "https://", str_replace( "/wp-admin", $ajax_subfolder . "/wp-admin", admin_url( 'admin-ajax.php' ) ) );
	}
	
	if( isset( $_SERVER['HTTPS'] ) && $_SERVER["HTTPS"] == "on" )
		wp_localize_script( 'wpeasycart_js', 'ajax_object', array( 'ajax_url' => $https_link ) );
	else
		wp_localize_script( 'wpeasycart_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	
}
	
function ec_facebook_metadata() {
	global $wp_query;
	global $wpdb;
	$post_obj = $wp_query->get_queried_object();
	if( isset( $post_obj ) && isset( $post_obj->ID ) ){
		$post_id = $post_obj->ID;
	}else{
		$post_id = 0;
	}
	$db = new ec_db( );
	$product = $db->get_product_from_post_id( $post_id );
	if( isset( $product ) || isset( $_GET['model_number'] ) ){
		if( isset( $product ) ){
			$product_id = $product->product_id;
			$prod_title = $product->title;
			$prod_model_number = $product->model_number;
			$prod_description = $product->description;
			$prod_use_optionitem_images = $product->use_optionitem_images;
			$prod_image = $product->image1;
		}else{
			$product = $wpdb->get_row( $wpdb->prepare( "SELECT ec_product.* FROM ec_product WHERE ec_product.model_number = %s", $_GET['model_number'] ) );		
			$product_id = $product->product_id;
			$prod_title = $product->title;
			$prod_model_number = $product->model_number;
			$prod_description = $product->seo_description;
			$prod_use_optionitem_images = $product->use_optionitem_images;
			$prod_image = $product->image1;
		}
		
		if( $prod_use_optionitem_images ){
			$optimgs = $wpdb->get_row( $wpdb->prepare( "SELECT ec_optionitemimage.image1 FROM ec_optionitemimage WHERE ec_optionitemimage.product_id = %s", $product_id ) );
			$prod_image = $optimgs->image1;
		}	
		
		remove_action('wp_head', 'rel_canonical');
		
		//this method places to early, before html tags open
		echo "\n";
		echo "<meta property=\"og:title\" content=\"" . $prod_title . "\" />\n"; 
		echo "<meta property=\"og:type\" content=\"product\" />\n";
		echo "<meta property=\"og:description\" content=\"" . ec_short_string($prod_description, 300) . "\" />\n";
		$test_src1 = ABSPATH . "wp-content/plugins/wp-easycart-data/products/pics1/" . $prod_image;
		$test_src2 = ABSPATH . "wp-content/plugins/" . EC_PLUGIN_DIRECTORY . "/products/pics1/" . $prod_image;
		if( file_exists( $test_src1 ) )
			echo "<meta property=\"og:image\" content=\"" .  plugin_dir_url(__DIR__) . "wp-easycart-data/products/pics1/" . $prod_image . "\" />\n"; 
		else if( file_exists( $test_src2 ) )
			echo "<meta property=\"og:image\" content=\"" .  plugin_dir_url(__DIR__) . EC_PLUGIN_DIRECTORY . "/products/pics1/" . $prod_image . "\" />\n"; 
		else 
			echo "<meta property=\"og:image\" content=\"" .  plugin_dir_url(__DIR__) . EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_image_not_found.jpg" . "\" />\n"; 
		
		echo "<meta property=\"og:url\" content=\"" . ec_curPageURL() . "\" /> \n";
	}
	
	if( get_option( 'ec_option_use_affirm' ) && get_option( 'ec_option_affirm_public_key' ) != "" ){
		
		if( get_option( 'ec_option_affirm_sandbox_account' ) ){
			echo '<script>
			  var _affirm_config = {
				public_api_key:  "' . get_option( 'ec_option_affirm_public_key' ) . '",
				script:          "https://cdn1-sandbox.affirm.com/js/v2/affirm.js"
			  };
			  (function(l,g,m,e,a,f,b){var d,c=l[m]||{},h=document.createElement(f),n=document.getElementsByTagName(f)[0],k=function(a,b,c){return function(){a[b]._.push([c,arguments])}};c[e]=k(c,e,"set");d=c[e];c[a]={};c[a]._=[];d._=[];c[a][b]=k(c,a,b);a=0;for(b="set add save post open empty reset on off trigger ready setProduct".split(" ");a<b.length;a++)d[b[a]]=k(c,e,b[a]);a=0;for(b=["get","token","url","items"];a<b.length;a++)d[b[a]]=function(){};h.async=!0;h.src=g[f];n.parentNode.insertBefore(h,n);delete g[f];d(g);l[m]=c})(window,_affirm_config,"affirm","checkout","ui","script","ready");
			</script>';
		}else{
			echo '<script>
			  var _affirm_config = {
				public_api_key:  "' . get_option( 'ec_option_affirm_public_key' ) . '",
				script:          "https://cdn1.affirm.com/js/v2/affirm.js"
			  };
			  (function(l,g,m,e,a,f,b){var d,c=l[m]||{},h=document.createElement(f),n=document.getElementsByTagName(f)[0],k=function(a,b,c){return function(){a[b]._.push([c,arguments])}};c[e]=k(c,e,"set");d=c[e];c[a]={};c[a]._=[];d._=[];c[a][b]=k(c,a,b);a=0;for(b="set add save post open empty reset on off trigger ready setProduct".split(" ");a<b.length;a++)d[b[a]]=k(c,e,b[a]);a=0;for(b=["get","token","url","items"];a<b.length;a++)d[b[a]]=function(){};h.async=!0;h.src=g[f];n.parentNode.insertBefore(h,n);delete g[f];d(g);l[m]=c})(window,_affirm_config,"affirm","checkout","ui","script","ready");
			</script>';
		}
	}
}

function ec_theme_head_data( ){
	if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){
		include( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" );

	}else if( file_exists( WP_PLUGIN_DIR . "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/head_content.php" ) ){
		include( WP_PLUGIN_DIR . "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/head_content.php" );
		
	}
}
	
function ec_curPageURL() {
	$pageURL = 'http';
	if( isset( $_SERVER["HTTPS"] ) )
		$pageURL .= "s";

	$pageURL .= "://";
	if( $_SERVER["SERVER_PORT"] != "80" )
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].htmlspecialchars ( $_SERVER["REQUEST_URI"], ENT_QUOTES );
	else
		$pageURL .= $_SERVER["SERVER_NAME"].htmlspecialchars ( $_SERVER["REQUEST_URI"], ENT_QUOTES );

	return $pageURL;
}

function ec_short_string($text, $length){
	$text = strip_tags( $text );
	if( strlen( $text ) > $length )
		$text = substr($text, 0, strpos($text, ' ', $length));
	
	return $text;
}

//[ecstore]
function load_ec_store( $atts ){
	
	if( !defined( 'DONOTCACHEPAGE' ) )
		define( "DONOTCACHEPAGE", true );
	
	if( !defined( 'DONOTCDN' ) )
		define('DONOTCDN', true);
	
	extract( shortcode_atts( array(
		'menuid' => 'NOMENU',
		'submenuid' => 'NOSUBMENU',
		'subsubmenuid' => 'NOSUBSUBMENU',
		'manufacturerid' => 'NOMANUFACTURER',
		'groupid' => 'NOGROUP',
		'modelnumber' => 'NOMODELNUMBER',
		'language' => 'NONE'
	), $atts ) );
	
	$GLOBALS['ec_store_shortcode_options'] = array( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
	
	ob_start();
    $store_page = new ec_storepage( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
	$store_page->display_store_page();
    return ob_get_clean();

}

//[eccart]
function load_ec_cart( $atts ){
	
	if( !defined( 'DONOTCACHEPAGE' ) )
		define( "DONOTCACHEPAGE", true );
	
	if( !defined( 'DONOTCDN' ) )
		define('DONOTCDN', true);
	
	extract( shortcode_atts( array(
		'language' => 'NONE'
	), $atts ) );
	
	$GLOBALS['language'] = new ec_language( $language );
	
	ob_start( );
	$cart_page = new ec_cartpage( );
	$cart_page->display_cart_page( );
	return ob_get_clean( );
}

//[ecaccount]
function load_ec_account( $atts ){
	
	if( !defined( 'DONOTCACHEPAGE' ) )
		define( "DONOTCACHEPAGE", true );
	
	if( !defined( 'DONOTCDN' ) )
		define('DONOTCDN', true);
	
	extract( shortcode_atts( array(
		'language' => 'NONE'
	), $atts ) );
	
	$GLOBALS['language'] = new ec_language( $language );
	
	ob_start( );
    $account_page = new ec_accountpage( );
	if( isset( $_POST['ec_form_action'] ) )
		$account_page->process_form_action( $_POST['ec_form_action'] );	
	else
		$account_page->display_account_page( );
    return ob_get_clean();
}

//[ec_product]
function load_ec_product( $atts ){
	extract( shortcode_atts( array(
		'model_number' => 'NOPRODUCT',
		'productid' => 'NOPRODUCTID',
		'columns' => '3',
		'margin' => '45px',
		'width' => '175px',
		'minheight' => '375px',
		'imagew' => '140px',
		'imageh' => '140px',
		'style' => '1'
	), $atts ) );
	$simp_product_id = $model_number;
	ob_start( );
    $mysqli = new ec_db( );
	if( $model_number != "NOPRODUCT" ){
		$products = $mysqli->get_product_list( " WHERE product.model_number = '" . $model_number . "'", "", "", "" );
	}else{
		$product_ids = explode( ',', $productid );
		$product_where = " WHERE ";
		$ids = 0;
		foreach( $product_ids as $product_id ){
			if( $ids > 0 ){
				$product_where .= " OR ";
			}
			$product_where .= "product.product_id = " . $product_id;
			$ids++;
		}
		$products = $mysqli->get_product_list( $product_where, "", "", "" );
	}
	if( count( $products ) > 0 ){
		
		$cart_page_id = get_option('ec_option_cartpage');
		if( function_exists( 'icl_object_id' ) ){
			$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
		}
		$cart_page = get_permalink( $cart_page_id );
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$cart_page = $https_class->makeUrlHttps( $cart_page );
		}
		
		echo "<div style=\"float:left; width:100%;\"><div class=\"ec_product_added_to_cart\"><div class=\"ec_product_added_icon\"></div><a href=\"" . $cart_page . "\" title=\"View Cart\">" . $GLOBALS['language']->get_text( "product_page", "product_view_cart" ) . "</a> " . $GLOBALS['language']->get_text( "product_page", "product_product_added_note" ) . "</div><div id=\"ec_current_media_size\"></div><ul class=\"ec_productlist_ul\" style=\"list-style:none; margin: 0px; float:left; width:100%; min-height:" . $minheight . ";\">";
		
		for( $prod_index=0; $prod_index<count( $products ); $prod_index++ ){
			$product = new ec_product( $products[$prod_index], 0, 0, 1 );
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){
				if( $prod_index%$columns == $columns-1 ){
					echo "<li style=\"float:right;\">";
				}else{
					echo "<li style=\"float:left; margin-right:" . $margin . ";\">";
				}
			}
			
			if( $style == '1' ){
				if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product.php' ) )
					include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product.php' );
				else
					include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_product.php' );
			
			}else if( $style == '2' ){
				if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_widget.php' ) )
					include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_widget.php' );
				else
					include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_product_widget.php' );
				
			}else{
				echo "<a href=\"" . $product->get_product_link( ) . "\">";
				echo "<img src=\"" . $product->get_product_single_image( ) . "\" alt=\"" . $product->title . "\" width=\"" . $imagew . "\" height=\"" . $imageh . "\">";
				echo "</a>";
				echo "<h3><a href=\"" . $product->get_product_link( ) . "\">" . $product->title . "</a></h3>";
				echo "<span class=\"ec_price_button\" style=\"width:" . $width . "\">";
				if( $product->has_sale_price( ) ){
					echo "<span class=\"ec_price_before\"><del>" . $product->get_formatted_before_price( ) . "</del></span>";
					echo "<span class=\"ec_price_sale\">" . $product->get_formatted_price( ) . "</span>";
				}else{
					echo "<span class=\"ec_price\">" . $product->get_formatted_price( ) . "</span>";
				}
				echo "</span>";
			}
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){
				echo "</li>";
			}
		}
		echo "</ul><div style=\"clear:both;\"></div></div>";
	}
    return ob_get_clean( );
}

//[ec_addtocart]
function load_ec_addtocart( $atts ){
	extract( shortcode_atts( array(
		'productid' => 'NOPRODUCTID'
	), $atts ) );
	ob_start( );
	$mysqli = new ec_db( );
	$products = $mysqli->get_product_list( " WHERE product.product_id = " . $productid, "", "", "" );
	if( count( $products ) > 0 ){
		$product = new ec_product( $products[0], 0, 0, 1 );
		
		if( $product->stock_quantity > 0 ){
		
			echo "<div style=\"display:none;\">";
			$product->display_product_details_image_set( "large", "ec_image_", "ec_image_click" );
			$product->display_product_image_thumbnails("xsmall", "ec_thumb_", "ec_thumb_click" );
			echo "</div>";
			
			$product->display_product_details_form_start( );
			
			if( $product->use_advanced_optionset ){
				echo "<div class=\"ec_product_details_option_holder\">";
				$product->display_all_advanced_optionsets( );
				echo "</div>";
			}else{
				if( $product->product_has_swatches( $product->options->optionset1 ) ){
					echo "<div class=\"ec_product_details_option1_swatches\">";
					$product->display_product_option( $product->options->optionset1, "large", 1, "ec_swatch_", "ec_swatch_click" );
					echo "</div>";
				}else if( $product->product_has_combo( $product->options->optionset1 ) ){
					echo "<div class=\"ec_product_details_option1_combo\">";
					$product->display_product_option( $product->options->optionset1, "large", 1, "ec_combo_", "" );
					echo "</div>";
				}
				
				if( $product->product_has_swatches( $product->options->optionset2 ) ){
					echo "<div class=\"ec_product_details_option2_swatches\">";
					$product->display_product_option( $product->options->optionset2, "large", 2, "ec_swatch_", "ec_swatch_click" );
					echo "</div>";
				}else if( $product->product_has_combo( $product->options->optionset2 ) ){
					echo "<div class=\"ec_product_details_option2_combo\">";
					$product->display_product_option( $product->options->optionset2, "large", 2, "ec_combo_", "" );
					echo "</div>";
				}
				
				if( $product->product_has_swatches( $product->options->optionset3 ) ){
					echo "<div class=\"ec_product_details_option3_swatches\">";
					$product->display_product_option( $product->options->optionset3, "large", 3, "ec_swatch_", "ec_swatch_click" );
					echo "</div>";
				}else if( $product->product_has_combo( $product->options->optionset3 ) ){
					echo "<div class=\"ec_product_details_option3_combo\">";
					$product->display_product_option( $product->options->optionset3, "large", 3, "ec_combo_", "" );
					echo "</div>";
				}
				
				if( $product->product_has_swatches( $product->options->optionset4 ) ){
					echo "<div class=\"ec_product_details_option4_swatches\">";
					$product->display_product_option( $product->options->optionset4, "large", 4, "ec_swatch_", "ec_swatch_click" );
					echo "</div>";
				}else if( $product->product_has_combo( $product->options->optionset4 ) ){
					echo "<div class=\"ec_product_details_option4_combo\">";
					$product->display_product_option( $product->options->optionset4, "large", 4, "ec_combo_", "" );
					echo "</div>";
				}
				
				if( $product->product_has_swatches( $product->options->optionset5 ) ){
					echo "<div class=\"ec_product_details_option5_swatches\">";
					$product->display_product_option( $product->options->optionset5, "large", 5, "ec_swatch_", "ec_swatch_click" );
					echo "</div>";
				}else if( $product->product_has_combo( $product->options->optionset5 ) ){
					echo "<div class=\"ec_product_details_option5_combo\">";
					$product->display_product_option( $product->options->optionset5, "large", 5, "ec_combo_", "" );
					echo "</div>";
				}
			
			}
			
			if( $product->is_giftcard ){
				echo "<div class=\"ec_product_details_gift_card\">"; $product->display_gift_card_input(); echo "</div>";
			}
			
			if( !$product->has_grid_optionset ){
				echo "<div class=\"";
				if( $product->is_donation ){
					echo "ec_product_details_quantity_donation"; 
				}else{ 
					echo "ec_product_details_quantity";
				}
				echo "\" id=\"ec_product_details_quantity_" . $product->model_number . "\">" . $GLOBALS['language']->get_text( 'product_details', 'product_details_quantity' );
				$product->display_product_quantity_input("1");
				echo "</div>";
			}
			echo "<input type=\"hidden\" id=\"product_quantity_" . $product->model_number . "\" value=\"1\">";
			echo "<div class=\"ec_product_details_add_to_cart\">";
			$product->display_product_add_to_cart_button_no_validation( $GLOBALS['language']->get_text( 'product_details', 'product_details_add_to_cart' ), "ec_quick_view_error" );
			echo "</div>";
			$product->display_product_details_form_end( );
		
		}else{
			echo "<div class=\"ec_product_details_quantity\">" . $GLOBALS['language']->get_text( 'product_details', 'product_details_out_of_stock' ) . "</div>";
		}
		
	}
    return ob_get_clean( );
}

//[ec_cartdisplay]
function load_ec_cartdisplay( $atts ){
	extract( shortcode_atts( array(
		'style' => '1'
	), $atts ) );
	ob_start( );
	$cartpage = new ec_cartpage( );
	if( $cartpage->cart->total_items > 0 ){
		echo "<div class=\"ec_cart_title_bar\">";
		echo "<div class=\"ec_cart_title_bar_column_1\">" . $GLOBALS['language']->get_text( 'cart', 'cart_header_column1' ) . "</div>";
		echo "<div class=\"ec_cart_title_bar_column_2\">" . $GLOBALS['language']->get_text( 'cart', 'cart_header_column2' ) . "</div>";
		echo "<div class=\"ec_cart_title_bar_column_3\">" . $GLOBALS['language']->get_text( 'cart', 'cart_header_column3' ) . "</div>";
		echo "<div class=\"ec_cart_title_bar_column_4\">" . $GLOBALS['language']->get_text( 'cart', 'cart_header_column4' ) . "</div>";
		echo "<div class=\"ec_cart_title_bar_column_5\">" . $GLOBALS['language']->get_text( 'cart', 'cart_header_column5' ) . "</div>";
		echo "</div>";
		echo "<div class=\"ec_cart_item_holder\">";
		$cartpage->display_cart_items();
		echo "</div>";
	}
    return ob_get_clean( );
}

//[ec_membership productid=''][/ec_membership]
function load_ec_membership( $atts, $content = NULL ){
	extract( shortcode_atts( array(
		'productid' => '',
		'userroles' => ''
	), $atts ) );
	
	if( is_user_logged_in( ) ){
		
		return "<h3>ADMIN ONLY - MEMBER CONTENT</h3><hr />" . do_shortcode( $content ) . "<hr />";
		
	}else{
		
		$db = new ec_db( );
		$is_member = false;
		
		if( $productid != '' ){
			$is_member = $db->has_membership_product_ids( $productid );
			
		}
		
		if( $userroles != '' ){
			$user_role_array = explode( ',', $userroles );
			$user = new ec_user( $_SESSION['ec_email'] );
			
			if( in_array( $user->user_level, $user_role_array ) )
				$is_member = true;
			
		}
		
		if( $is_member )
			return do_shortcode( $content );
			
		else
			return "";
		
	}
	
}

//[ec_membership_alt productid=''][/ec_membership_alt]
function load_ec_membership_alt( $atts, $content = NULL ){
	extract( shortcode_atts( array(
		'productid' => '',
		'userroles' => ''
	), $atts ) );
	
	if( is_user_logged_in( ) ){
		
		return "<h3>ADMIN ONLY - ALTERNATE CONTENT</h3><hr />" . do_shortcode( $content ) . "<hr />";
		
	}else{
	
		$db = new ec_db( );
		$is_member = false;
		
		if( $productid != '' ){
			$is_member = $db->has_membership_product_ids( $productid );
			
		}
		
		if( $userroles != '' ){
			$user_role_array = explode( ',', $userroles );
			$user = new ec_user( $_SESSION['ec_email'] );
			
			if( in_array( $user->user_level, $user_role_array ) )
				$is_member = true;
			
		}
		
	
		if( !$is_member )
			return do_shortcode( $content );
			
		else
			return "";
		
	}
	
}

function ec_plugins_loaded( ){
	/* Admin Form Actions */
	if( current_user_can('manage_options') && isset( $_GET['ec_action'] ) && isset( $_GET['ec_language'] ) && $_GET['ec_action'] == "export-language" ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_language.php' );
		$language = new ec_language( );
		$language->export_language( $_GET['ec_language'] );
		die( );
	}
}

function ec_footer_load( ){
	if( get_option( 'ec_option_enable_newsletter_popup' ) && !isset( $_SESSION['ec_newsletter_popup'] ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_newsletter_popup.php' ) )	
			include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_newsletter_popup.php' );
		else
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_newsletter_popup.php' );
		
	}
}

function wpeasycart_register_widgets( ) {
	register_widget( 'ec_categorywidget' );
	register_widget( 'ec_cartwidget' );
	register_widget( 'ec_colorwidget' );
	register_widget( 'ec_currencywidget' );
	register_widget( 'ec_donationwidget' );
	register_widget( 'ec_groupwidget' );
	register_widget( 'ec_languagewidget' );
	register_widget( 'ec_manufacturerwidget' );
	register_widget( 'ec_menuwidget' );
	register_widget( 'ec_newsletterwidget' );
	register_widget( 'ec_pricepointwidget' );
	register_widget( 'ec_productwidget' );
	register_widget( 'ec_searchwidget' );
	register_widget( 'ec_specialswidget' );
}

add_action( 'wp', 'load_ec_pre' );
add_action( 'wp_enqueue_scripts', 'ec_load_css' );
add_action( 'wp_enqueue_scripts', 'ec_load_js' );
add_action( 'widgets_init', 'wpeasycart_register_widgets' );
add_action( 'send_headers', 'ec_custom_headers' );
add_action( 'plugins_loaded', 'ec_plugins_loaded' );
add_action( 'wp_footer', 'ec_footer_load' );

add_shortcode( 'ec_store', 'load_ec_store' );
add_shortcode( 'ec_cart', 'load_ec_cart' );
add_shortcode( 'ec_account', 'load_ec_account' );
add_shortcode( 'ec_product', 'load_ec_product' );
add_shortcode( 'ec_addtocart', 'load_ec_addtocart' );
add_shortcode( 'ec_cartdisplay', 'load_ec_cartdisplay' );
add_shortcode( 'ec_membership', 'load_ec_membership' );
add_shortcode( 'ec_membership_alt', 'load_ec_membership_alt' );

add_filter( 'widget_text', 'do_shortcode');

add_action('wp_head', 'ec_facebook_metadata');
add_action('wp_head', 'ec_theme_head_data');

add_action( 'wp_enqueue_scripts', 'ec_load_dashicons' );
function ec_load_dashicons() {
    wp_enqueue_style( 'dashicons' );
}

//////////////////////////////////////////////
//UPDATE FUNCTIONS
//////////////////////////////////////////////

function wpeasycart_copyr( $source, $dest ){
    
	// Check for symlinks
    if( is_link( $source ) ){
        return symlink( readlink( $source ), $dest );
    }

    // Simple copy for a file
    if( is_file( $source ) ){
		$success = copy( $source, $dest );
		if( $success ){
 	       return true;
		}else{
			$err_message = "wpeasycart - error backing up " . $source . ". Updated halted.";
			error_log( $err_message );
			exit( $err_message );
		}
	}

    // Make destination directory
    if ( !is_dir( $dest ) ){
        $success = mkdir( $dest, 0755 );
		if( !$success ){
			$err_message = "wpeasycart - error creating backup directory: " . $dest . ". Updated halted.";
			error_log( $err_message );
			exit( $err_message );
		}
    }

    // Loop through the folder
    $dir = dir( $source );
    while( false !== $entry = $dir->read( ) ){
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        wpeasycart_copyr( "$source/$entry", "$dest/$entry" ); // <------- defines wpeasycart copy action
    }

    // Clean up
    $dir->close( );
    return true;
}

function wpeasycart_backup( ){
	// Test for data folder
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){
		echo "YOU DO NOT HAVE A WP EASYCART DATA FOLDER, PLEASE <a href=\"http://www.wpeasycart.com/plugin-update-help/\" target=\"_blank\">CLICK HERE TO READ HOW TO PREVENT DATA LOSS DURING THE UPDATE</a>";
		die( );
	}
}

function ec_recursive_remove_directory( $directory, $empty=FALSE ) {
     // if the path has a slash at the end we remove it here
     if( substr( $directory, -1 ) == '/' )
         $directory = substr( $directory, 0, -1);
  
     // if the path is not valid or is not a directory ...
     if( !file_exists( $directory ) || !is_dir( $directory ) )
         return FALSE;
  
     // ... if the path is not readable
     elseif(!is_readable($directory))
         return FALSE;
  
     // ... else if the path is readable
     else{
  
         // we open the directory
         $handle = opendir( $directory );
  
         // and scan through the items inside
         while( FALSE !== ( $item = readdir( $handle ) ) ){
             // if the filepointer is not the current directory
             // or the parent directory
             if( $item != '.' && $item != '..' ){
                 // we build the new path to delete
                 $path = $directory . '/' . $item;
  
                 // if the new path is a directory
                 if( is_dir( $path ) ){
                     // we call this function with the new path
                    ec_recursive_remove_directory( $path );

                 // if the new path is a file
                 }else{
                     // we remove the file
                     unlink( $path );
                 }
             }
         }
         // close the directory
         closedir( $handle );
		  
         // if the option to empty is not set to true
         if( $empty == FALSE ){
             // try to delete the now empty directory
             if( !rmdir( $directory ) ){
                 // return false if not possible
                 return FALSE;
             }
         }
         // return success
         return TRUE;
    }
}
 
function ec_delete_directory_ftp( $resource, $path ) {
    $result_message = "";
    $list = ftp_nlist( $resource, $path );
	
	if ( empty($list) ) {
        $list = ec_ran_list_n( ftp_rawlist($resource, $path), $path . ( substr($path, strlen($path) - 1, 1) == "/" ? "" : "/" ) );
    }
    if ($list[0] != $path) {
        $path .= ( substr($path, strlen($path)-1, 1) == "/" ? "" : "/" );
        foreach ($list as $item) {
			if ($item != $path.".." && $item != $path.".") {
				$result_message .= ec_delete_directory_ftp($resource, $item);
			}
        }
        if (ftp_rmdir ($resource, $path)) {
            $result_message .= "Successfully deleted $path <br />\n";
        } else {
            $result_message .= "There was a problem while deleting $path <br />\n";
        }
    }
    else {
		$res = ftp_site( $resource, 'CHMOD 0777 ' . $path );
        if (ftp_delete ($resource, $path)) {
            $result_message .= "Successfully deleted $path <br />\n";
        } else {
            $result_message .= "There was a problem while deleting $path <br />\n";
        }
    }
    return $result_message;
}

function ec_ran_list_n($rawlist, $path) {
    $array = array();
    foreach ($rawlist as $item) {
        $filename = trim(substr($item, 55, strlen($item) - 55));
        if ($filename != "." || $filename != "..") {
        $array[] = $path . $filename;
        }
    }
    return $array;
}

add_filter( 'upgrader_pre_install', 'wpeasycart_backup', 10, 2 );

//////////////////////////////////////////////
//END UPDATE FUNCTIONS
//////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
//AJAX SETUP FUNCTIONS
/////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_ec_ajax_get_optionitem_quantities', 'ec_ajax_get_optionitem_quantities' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_optionitem_quantities', 'ec_ajax_get_optionitem_quantities' );
function ec_ajax_get_optionitem_quantities( ){
	
	$db = new ec_db( );
	
	$product_id = $_POST['product_id'];
	$optionitem_id_1 = $_POST['optionitem_id_1'];
	
	if( isset( $_POST['optionitem_id_2'] ) )
		$optionitem_id_2 = $_POST['optionitem_id_2'];
	else{
		$quantity_values = $db->get_option2_quantity_values( $product_id, $optionitem_id_1 );
		echo json_encode( $quantity_values );
		
		die( );
	}
	
	if( isset( $_POST['optionitem_id_3'] ) )
		$optionitem_id_3 = $_POST['optionitem_id_3'];
	else{
		$quantity_values = $db->get_option3_quantity_values( $product_id, $optionitem_id_1, $optionitem_id_2 );
		echo json_encode( $quantity_values );
		
		die( );
	}
	
	if( isset( $_POST['optionitem_id_4'] ) )
		$optionitem_id_4 = $_POST['optionitem_id_4'];
	else{
		$quantity_values = $db->get_option4_quantity_values( $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3 );
		echo json_encode( $quantity_values );
		
		die( );
	}
	
	
	$quantity_values = $db->get_option5_quantity_values( $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4 );
	echo json_encode( $quantity_values );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_add_to_cart', 'ec_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_ec_ajax_add_to_cart', 'ec_ajax_add_to_cart' );
function ec_ajax_add_to_cart( ){
	
	$product_id = $_POST['product_id'];
	$model_number = $_POST['model_number'];
	$quantity = $_POST['quantity'];
	$db = new ec_db( );
	
	$tempcart = $db->add_to_cart( $product_id, $_SESSION['ec_cart_id'], $quantity, 0, 0, 0, 0, 0, "", "", "", 0.00, false, 1 );
	do_action( 'wpeasycart_cart_updated' );
	
	$cart_arr = array( );
	$total_items = 0;
	$total_cost = 0;
	
	foreach( $tempcart as $item ){
		$cart_arr[] = array( 'title' => $item->title, 'price' => $GLOBALS['currency']->get_currency_display( $item->unit_price ), 'quantity' => $item->quantity );
		$total_items = $total_items + $item->quantity;
		$total_cost = $total_cost + ( $item->quantity * $item->unit_price );
	}
	$cart_arr[0]['total_items'] = $total_items;
	$cart_arr[0]['total_price'] = $GLOBALS['currency']->get_currency_display( $total_cost );
	echo json_encode( $cart_arr );
	
	die( );
}

add_action( 'wp_ajax_ec_ajax_cartitem_update', 'ec_ajax_cartitem_update' );
add_action( 'wp_ajax_nopriv_ec_ajax_cartitem_update', 'ec_ajax_cartitem_update' );
function ec_ajax_cartitem_update( ){
	
	// UPDATE CART ITEM
	$tempcart_id = $_POST['cartitem_id'];
	$session_id = $_SESSION['ec_cart_id'];
	$quantity = $_POST['quantity'];
	
	if( is_numeric( $quantity ) ){
		$db = new ec_db();
		$db->update_cartitem( $tempcart_id, $session_id, $quantity );
		do_action( 'wpeasycart_cart_updated' );
	}
	// UPDATE CART ITEM
	
	// GET NEW CART ITEM INFO
	if( isset( $_POST['ec_v3_24'] ) ){
		$return_array = ec_get_cart_data( );
								
		echo json_encode( $return_array );
	}else{
		$cart = new ec_cart( $_SESSION['ec_cart_id'] );
		
		$unit_price = 0;
		$total_price = 0;
		$new_quantity = 0;
		for( $i=0; $i<count( $cart->cart ); $i++ ){
			if( $cart->cart[$i]->cartitem_id == $tempcart_id ){
				$unit_price = $cart->cart[$i]->unit_price;
				$total_price = $cart->cart[$i]->total_price;
				$new_quantity = $cart->cart[$i]->quantity;
			}
		}
		// GET NEW CART ITEM INFO
		$order_totals = ec_get_order_totals( );
		
		echo $GLOBALS['currency']->get_currency_display( $unit_price ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $total_price ) . "***" . 
				$new_quantity . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" .  
				$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" .
				$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
				
		if( $cart->total_items > 0 ){
			
			if( $cart->total_items != 1 ){
				$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label_plural' );
			}else{
				$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label' );
			}
			
			echo "***" . $cart->total_items . ' ' . $items_label . ' ' . $GLOBALS['currency']->get_currency_display( $cart->subtotal );
		}else{
			echo "***" . $cart->total_items . ' ' . $items_label;
		}
		echo "***" . $cart->total_items;
	}
	
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_ec_ajax_cartitem_delete', 'ec_ajax_cartitem_delete' );
add_action( 'wp_ajax_nopriv_ec_ajax_cartitem_delete', 'ec_ajax_cartitem_delete' );
function ec_ajax_cartitem_delete( ){
	
	//Get the variables from the AJAX call
	$tempcart_id = $_POST['cartitem_id'];
	$session_id = $_SESSION['ec_cart_id'];
	
	// DELTE CART ITEM
	$db = new ec_db();
	$ret_data = $db->delete_cartitem( $tempcart_id, $session_id );
	do_action( 'wpeasycart_cart_updated' );
	
	// GET NEW CART ITEM INFO
	if( isset( $_POST['ec_v3_24'] ) ){
		$return_array = ec_get_cart_data( );
								
		echo json_encode( $return_array );
	}else{
		$cart = new ec_cart( $_SESSION['ec_cart_id'] );
		$order_totals = ec_get_order_totals( );
		
		echo $cart->total_items . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" .  
				$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" .
				$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
			
		if( $cart->total_items != 1 ){
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label_plural' );
		}else{
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label' );
		}
		
		if( $cart->total_items > 0 ){
			echo "***" . $cart->total_items . ' ' . $items_label . ' ' . $GLOBALS['currency']->get_currency_display( $cart->subtotal );
		
		}else{
			echo "***" . $cart->total_items . ' ' . $items_label;
		
		}
		echo "***" . $cart->total_items;
	}
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_redeem_coupon_code', 'ec_ajax_redeem_coupon_code' );
add_action( 'wp_ajax_nopriv_ec_ajax_redeem_coupon_code', 'ec_ajax_redeem_coupon_code' );
function ec_ajax_redeem_coupon_code( ){
	
	//UPDATE COUPON CODE
	$coupon_code = "";
	if( isset( $_POST['couponcode'] ) ){
		$coupon_code = $_POST['couponcode'];
		$_SESSION['ec_couponcode'] = $coupon_code;
	}
	$db = new ec_db();
	$coupon = $db->redeem_coupon_code( $coupon_code );
	do_action( 'wpeasycart_cart_updated' );
	// UPDATE COUPON CODE
	$cart = new ec_cart( $coupon_code );
	$order_totals = ec_get_order_totals( );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	if( $coupon ){
		if( $coupon && !$coupon->coupon_expired && ( $coupon->max_redemptions == 999 || $coupon->times_redeemed < $coupon->max_redemptions ) ){
			echo "***" . $coupon->message . "***" . "valid";
			$_SESSION['ec_couponcode'] = $coupon_code;
		
		}else if( $coupon && $coupon->times_redeemed >= $coupon->max_redemptions ){
			echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_max_exceeded_coupon' ) . "***" . "invalid";
			unset( $_SESSION['ec_couponcode'] );
		
		}else if( $coupon->coupon_expired ){
			echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_expired' ) . "***" . "invalid";
			unset( $_SESSION['ec_couponcode'] );
			
		}else{
			echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' ) . "***" . "invalid";
			unset( $_SESSION['ec_couponcode'] );
		}
	}else{
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' ) . "***" . "invalid";
		unset( $_SESSION['ec_couponcode'] );
	}
		
	if( $order_totals->discount_total == 0 )
		echo "***0";
	else
		echo "***1";
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_redeem_gift_card', 'ec_ajax_redeem_gift_card' );
add_action( 'wp_ajax_nopriv_ec_ajax_redeem_gift_card', 'ec_ajax_redeem_gift_card' );
function ec_ajax_redeem_gift_card( ){
	
	// UPDATE GIFT CARD
	$gift_card = "";
	if( isset( $_POST['giftcard'] ) )
		$gift_card = $_POST['giftcard'];
		
	$_SESSION['ec_giftcard'] = $gift_card;
	
	$db = new ec_db();
	$giftcard = $db->redeem_gift_card( $gift_card );
	do_action( 'wpeasycart_cart_updated' );
	// UPDATE GIFT CARD
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$order_totals = ec_get_order_totals( );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	if( $giftcard )
		echo "***" . $giftcard->message . "***" . "valid";
	else{
		unset( $_SESSION['ec_giftcard'] );
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_giftcard' ) . "***" . "invalid";
	}
		
	if( $order_totals->discount_total == 0 )
		echo "***0";
	else
		echo "***1";
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_estimate_shipping', 'ec_ajax_estimate_shipping' );
add_action( 'wp_ajax_nopriv_ec_ajax_estimate_shipping', 'ec_ajax_estimate_shipping' );
function ec_ajax_estimate_shipping( ){
	//Get the variables from the AJAX call
	if( isset( $_POST['zipcode'] ) ){
		$_SESSION['ec_temp_zipcode'] = $_POST['zipcode'];
		$_SESSION['ec_shipping_zip'] = $_POST['zipcode'];
	}
	if( isset( $_POST['country'] ) && $_POST['country'] != "0" ){
		$_SESSION['ec_temp_country'] = $_POST['country'];
		$_SESSION['ec_shipping_country'] = $_POST['country'];
	}
	
	$user_email = "";
	if( isset( $_SESSION['ec_email'] ) )
		$user_email = $_SESSION['ec_email'];
	
	$user = new ec_user( $user_email );
	
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$order_totals = ec_get_order_totals( );
	$setting = new ec_setting( );
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$shipping = new ec_shipping( $cart->subtotal, $cart->weight, $cart->shippable_total_items, 'RADIO', $user->freeshipping );
	
	$shipping_options = $shipping->get_shipping_options( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" );
	
	if( $setting->get_shipping_method() == "live" && $shipping_options )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->vat_total );
	else if( $setting->get_shipping_method() == "live" )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . "<div class=\"ec_cart_shipping_method_row\">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_error' ) . "</div>";
	else
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options;
		
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_update_shipping_method', 'ec_ajax_update_shipping_method' );
add_action( 'wp_ajax_nopriv_ec_ajax_update_shipping_method', 'ec_ajax_update_shipping_method' );
function ec_ajax_update_shipping_method( ){
	
	//Get the variables from the AJAX call
	$shipping_method = $_POST['shipping_method'];
	
	//Create a new db and submit review
	$_SESSION['ec_shipping_method'] = $shipping_method;
	
	$user_email = "";
	if( isset( $_SESSION['ec_email'] ) )
		$user_email = $_SESSION['ec_email'];
	
	$user = new ec_user( $user_email );
	
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$order_totals = ec_get_order_totals( );
	$setting = new ec_setting( );
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$shipping = new ec_shipping( $cart->subtotal, $cart->weight, $cart->shippable_total_items, 'RADIO', $user->freeshipping );
	
	$shipping_options = $shipping->get_shipping_options( "", "" );
	
	if( $setting->get_shipping_method() == "live" && $shipping_options )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->vat_total );
	else if( $setting->get_shipping_method() == "live" )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . "<div class=\"ec_cart_shipping_method_row\">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_error' ) . "</div>";
	else
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_insert_customer_review', 'ec_ajax_insert_customer_review' );
add_action( 'wp_ajax_nopriv_ec_ajax_insert_customer_review', 'ec_ajax_insert_customer_review' );
function ec_ajax_insert_customer_review( ){
	
	//Get the variables from the AJAX call
	$user = new ec_user( "" );
	$product_id = $_POST['product_id'];
	$rating = $_POST['review_score'];
	$title = $_POST['review_title'];
	$description = $_POST['review_message'];
	
	//Create a new db and submit review
	$db = new ec_db();
	echo $db->submit_customer_review( $product_id, $rating, $title, $description, $user->user_id );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_live_search', 'ec_ajax_live_search' );
add_action( 'wp_ajax_nopriv_ec_ajax_live_search', 'ec_ajax_live_search' );
function ec_ajax_live_search( ){
	
	//Get the variables from the AJAX call
	$search_val = $_POST['search_val'];
	
	//Create a new db and submit review
	$db = new ec_db();
	$results = $db->get_live_search_options( $search_val );
	echo json_encode( $results );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_close_newsletter', 'ec_ajax_close_newsletter' );
add_action( 'wp_ajax_nopriv_ec_ajax_close_newsletter', 'ec_ajax_close_newsletter' );
function ec_ajax_close_newsletter( ){
	
	$_SESSION['ec_newsletter_popup'] = 'hide';
	setcookie( 'ec_newsletter_popup', $_SESSION['ec_newsletter_popup'], time( ) + ( 10 * 365 * 24 * 60 * 60 ) );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_submit_newsletter_signup', 'ec_ajax_submit_newsletter_signup' );
add_action( 'wp_ajax_nopriv_ec_ajax_submit_newsletter_signup', 'ec_ajax_submit_newsletter_signup' );
function ec_ajax_submit_newsletter_signup( ){
	
	$ec_db = new ec_db();
	$ec_db->insert_subscriber( $_POST['email_address'], $_POST['newsletter_name'], "" );
			
	// MyMail Hook
	if( function_exists( 'mymail' ) ){
		$subscriber_id = mymail('subscribers')->add(array(
			'email' => $_POST['email_address'],
			'status' => 1,
		), false );
	}
	
	$_SESSION['ec_newsletter_popup'] = 'hide';
	setcookie( 'ec_newsletter_popup', $_SESSION['ec_newsletter_popup'], time( ) + ( 10 * 365 * 24 * 60 * 60 ) );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_save_page_options', 'ec_ajax_save_page_options' );
function ec_ajax_save_page_options( ){
	
	update_option( 'ec_option_design_saved', 1 );
	$db = new ec_db( );
	$post_id = $_POST['post_id'];
	foreach( $_POST as $key => $var ){
		
		if( $key == 'ec_option_details_main_color' ){
			update_option( 'ec_option_details_main_color', $_POST['ec_option_details_main_color'] );
		}else if( $key == 'ec_option_details_second_color' ){
			update_option( 'ec_option_details_second_color', $_POST['ec_option_details_second_color'] );
		}else if( $key != 'post_id' ){
			$db->update_page_option( $post_id, $key, $var );
		}
		
	}
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_page_default_options', 'ec_ajax_save_page_default_options' );
function ec_ajax_save_page_default_options( ){
	
	update_option( 'ec_option_design_saved', 1 );
	$db = new ec_db( );
	$post_id = $_POST['post_id'];
	foreach( $_POST as $key => $var ){
		
		if( $key != 'post_id' ){
			update_option( $key, $var );
		}
		
	}
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_hide_video_option', 'ec_ajax_save_hide_video_option' );
function ec_ajax_save_hide_video_option( ){
	
	update_option( 'ec_option_hide_design_help_video', '1' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_product_options', 'ec_ajax_save_product_options' );
function ec_ajax_save_product_options( ){
	
	$model_number = $_POST['model_number'];
	
	$product_options = new stdClass( );
	$product_options->image_hover_type = $_POST['image_hover_type'];
	$product_options->image_effect_type = $_POST['image_effect_type'];
	$product_options->tag_type = $_POST['tag_type'];
	$product_options->tag_text = $_POST['tag_text'];
	$product_options->tag_bg_color = $_POST['tag_bg_color'];
	$product_options->tag_text_color = $_POST['tag_text_color'];
	
	$db = new ec_db( );
	$db->update_product_options( $model_number, $product_options );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_mass_save_product_options', 'ec_ajax_mass_save_product_options' );
function ec_ajax_mass_save_product_options( ){
	
	$product_list = $_POST['products'];
	
	$product_options = new stdClass( );
	$product_options->image_hover_type = $_POST['image_hover_type'];
	$product_options->image_effect_type = $_POST['image_effect_type'];
	
	$db = new ec_db( );
	foreach( $product_list as $model_number ){
		$db->update_product_options( $model_number, $product_options );
	}
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_product_order', 'ec_ajax_save_product_order' );
function ec_ajax_save_product_order( ){
	
	$post_id = $_POST['post_id'];
	$product_order = $_POST['product_order'];
	
	$db = new ec_db( );
	$db->update_page_option( $post_id, 'product_order', $product_order );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_ec_update_product_description', 'ec_ajax_ec_update_product_description' );
function ec_ajax_ec_update_product_description( ){
	
	$description = $_POST['description'];
	$product_id = $_POST['product_id'];
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE ec_product SET ec_product.description = %s WHERE ec_product.product_id = %d", $description, $product_id ) );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_ec_update_product_specifications', 'ec_ajax_ec_update_product_specifications' );
function ec_ajax_ec_update_product_specifications( ){
	
	$specifications = $_POST['specifications'];
	$product_id = $_POST['product_id'];
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE ec_product SET ec_product.specifications = %s WHERE ec_product.product_id = %d", $specifications, $product_id ) );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_product_details_options', 'ec_ajax_save_product_details_options' );
function ec_ajax_save_product_details_options( ){
	
	update_option( 'ec_option_details_main_color', $_POST['ec_option_details_main_color'] );
	update_option( 'ec_option_details_columns_desktop', $_POST['ec_option_details_columns_desktop'] );
	update_option( 'ec_option_details_columns_laptop', $_POST['ec_option_details_columns_laptop'] );
	update_option( 'ec_option_details_columns_tablet_wide', $_POST['ec_option_details_columns_tablet_wide'] );
	update_option( 'ec_option_details_columns_tablet', $_POST['ec_option_details_columns_tablet'] );
	update_option( 'ec_option_details_columns_smartphone', $_POST['ec_option_details_columns_smartphone'] );
	update_option( 'ec_option_use_dark_bg', $_POST['ec_option_use_dark_bg'] );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_cart_options', 'ec_ajax_save_cart_options' );
function ec_ajax_save_cart_options( ){
	
	update_option( 'ec_option_cart_columns_desktop', $_POST['ec_option_cart_columns_desktop'] );
	update_option( 'ec_option_cart_columns_laptop', $_POST['ec_option_cart_columns_laptop'] );
	update_option( 'ec_option_cart_columns_tablet_wide', $_POST['ec_option_cart_columns_tablet_wide'] );
	update_option( 'ec_option_cart_columns_tablet', $_POST['ec_option_cart_columns_tablet'] );
	update_option( 'ec_option_cart_columns_smartphone', $_POST['ec_option_cart_columns_smartphone'] );
	update_option( 'ec_option_use_dark_bg', $_POST['ec_option_use_dark_bg'] );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_get_dynamic_cart_menu', 'ec_ajax_get_dynamic_cart_menu' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_dynamic_cart_menu', 'ec_ajax_get_dynamic_cart_menu' );
function ec_ajax_get_dynamic_cart_menu( ){
	
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	if( !get_option( 'ec_option_hide_cart_icon_on_empty' ) || $cart->total_items > 0 ){
	
		// Get Cart Page Link
		$cartpageid = get_option('ec_option_cartpage');
		if( function_exists( 'icl_object_id' ) ){
			$cartpageid = icl_object_id( $cartpageid, 'page', true, ICL_LANGUAGE_CODE );
		}
		$cartpage = get_permalink( $cartpageid );
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$cartpage = $https_class->makeUrlHttps( $cartpage );
		}
		
		// Check for correct Label
		if( $cart->total_items != 1 ){
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label_plural' );
		}else{
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label' );
		}
		
		// Then display to user
		if( $cart->total_items > 0 ){
			$items = '<a href="' . $cartpage . '"><span class="dashicons dashicons-cart" style="vertical-align:middle; margin-top:-5px; margin-right:5px;"></span> ' . ' ( <span class="ec_menu_cart_text"><span class="ec_cart_items_total">' . $cart->total_items . '</span> ' . $items_label . ' <span class="ec_cart_price_total">' . $GLOBALS['currency']->get_currency_display( $cart->subtotal ) . '</span></span> )</a>';
		
		}else{
			$items = '<a href="' . $cartpage . '"><span class="dashicons dashicons-cart" style="vertical-align:middle; margin-top:-5px; margin-right:5px;"></span> ' . ' ( <span class="ec_menu_cart_text"><span class="ec_cart_items_total">' . $cart->total_items . '</span> ' . $items_label . ' <span class="ec_cart_price_total"></span></span> )</a>';
		}
		
		echo $items;
		
	}
	
	die( );
	
}

// Helper function for AJAX calls in cart.
function ec_get_order_totals( ){
	$user_email = "";
	if( isset( $_SESSION['ec_email'] ) )
		$user_email = $_SESSION['ec_email'];
	
	$coupon_code = "";
	if( isset( $_SESSION['ec_couponcode'] ) )
		$coupon_code = $_SESSION['ec_couponcode'];
		
	$gift_card = "";
	if( isset( $_SESSION['ec_giftcard'] ) )
		$gift_card = $_SESSION['ec_giftcard'];
	
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$user = new ec_user( $user_email );
	$shipping = new ec_shipping( $cart->shipping_subtotal, $cart->weight, $cart->shippable_total_items, 'RADIO', $user->freeshipping );
	$sales_tax_discount = new ec_discount( $cart, $cart->subtotal, 0.00, $coupon_code, "", 0 );
	$tax = new ec_tax( $cart->subtotal, $cart->taxable_subtotal - $sales_tax_discount->coupon_discount, 0, $user->shipping->state, $user->shipping->country, $user->taxfree );
	$grand_total = ( $cart->subtotal + $tax->tax_total + $shipping->get_shipping_price( ) + $tax->duty_total );
	$discount = new ec_discount( $cart, $cart->subtotal, $shipping->get_shipping_price( ), $coupon_code, $gift_card, $grand_total );
	$vatable_subtotal = $grand_total - $discount->coupon_discount;
	$tax = new ec_tax( $cart->subtotal, $cart->taxable_subtotal - $sales_tax_discount->coupon_discount, $vatable_subtotal, $user->shipping->state, $user->shipping->country, $user->taxfree );
	$discount = new ec_discount( $cart, $cart->subtotal, $shipping->get_shipping_price( ), $coupon_code, $gift_card, $GLOBALS['currency']->get_number_only( $grand_total ) + $GLOBALS['currency']->get_number_only( $tax->vat_total ) );
	$order_totals = new ec_order_totals( $cart, $user, $shipping, $tax, $discount );
	return $order_totals;
}

function ec_get_cart_data( ){
	// GET NEW CART ITEM INFO
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$cart_array = array( );
	
	for( $i=0; $i<count( $cart->cart ); $i++ ){
		$cart_item = array( "id" => $cart->cart[$i]->cartitem_id,
				"unit_price" => $GLOBALS['currency']->get_currency_display( $cart->cart[$i]->unit_price ),
				"total_price" => $GLOBALS['currency']->get_currency_display( $cart->cart[$i]->total_price ),
				"quantity" => $cart->cart[$i]->quantity );
		$cart_array[] = $cart_item;
	}
	// GET NEW CART ITEM INFO
	$order_totals = ec_get_order_totals( );
	
	$order_totals_array = array( 
			"sub_total" => $GLOBALS['currency']->get_currency_display( $order_totals->sub_total ), 
			"tax_total" => $GLOBALS['currency']->get_currency_display( $order_totals->tax_total ),
			"shipping_total" => $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ),
			"duty_total" => $GLOBALS['currency']->get_currency_display( $order_totals->duty_total ),
			"vat_total" => $GLOBALS['currency']->get_currency_display( $order_totals->vat_total ),
			"discount_total" => $GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ),
			"grand_total" => $GLOBALS['currency']->get_currency_display( $order_totals->grand_total )
			);
	
	$final_array = array( 	"cart" => $cart_array,
							"order_totals" => $order_totals_array,
							"items_total" => $cart->total_items );
							
	return $final_array;
}

add_action( 'wp_ajax_ec_ajax_get_cart', 'ec_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_cart', 'ec_ajax_get_cart' );
function ec_ajax_get_cart( ){
	
	//Get the variables from the AJAX call
	$cart = new ec_cart( $_SESSION['ec_cart_id'] );
	$retarray = array( );
	
	foreach( $cart->cart as $cartitem ){
		$retarray[] = array( "cartitem_id"	=> $cartitem->cartitem_id, 
							 "title"		=> $cartitem->title,
							 "quantity"		=> $cartitem->quantity, 
							 "unit_price"	=> $GLOBALS['currency']->get_currency_display( $cartitem->unit_price ) );
	}
	
	echo json_encode( $retarray );
	
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_ec_ajax_get_cart_totals', 'ec_ajax_get_cart_totals' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_cart_totals', 'ec_ajax_get_cart_totals' );
function ec_ajax_get_cart_totals( ){
	
	//Get the variables from the AJAX call
	$cartpage = new ec_cartpage( );
	
	$retarray = array( 	"sub_total"			=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->sub_total ), 
						"tax_total"			=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->tax_total ), 
						"shipping_total"	=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->shipping_total ), 
						"duty_total"		=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->duty_total ), 
						"vat_total"			=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->vat_total ), 
						"discount_total"	=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->discount_total ), 
						"grand_total"		=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->grand_total ) );
	
	echo json_encode( $retarray );
	
	die(); // this is required to return a proper result
}
// End AJAX helper function for cart.

add_filter( 'wp_title', 'ec_custom_title', 20 );

function ec_custom_title( $title ) {
	
	$page_id = get_the_ID();
	$store_id = get_option( 'ec_option_storepage' );
	
	if( $page_id == $store_id && isset( $_GET['model_number'] ) ){
		$db = new ec_db( );
		$products = $db->get_product_list( " WHERE product.model_number = '" . $_GET['model_number'] . "'", "", "", "" );
		if( count( $products ) > 0 ){
			$custom_title = $products[0]['title'] . " |" . $title;
			return $custom_title;
		}else{
			return $title;
		}
	}else if( $page_id == $store_id ){
		
		$additional_title = "";
		
		if( isset( $_GET['manufacturer'] ) ){
			$db = new ec_db( );
			$manufacturer = $db->get_manufacturer_row( $_GET['manufacturer'] );
			
			$additional_title .= $manufacturer->name . " |";
		}
		
		if( isset( $_GET['menu'] ) ){
			$custom_title = $_GET['menu'] . " |" . $additional_title . $title;
			return $custom_title;
		}else if( isset( $_GET['submenu'] ) ){
			$custom_title = $_GET['submenu'] . " |" . $additional_title . $title;
			return $custom_title;
		}else if( isset( $_GET['subsubmenu'] ) ){
			$custom_title = $_GET['subsubmenu'] . " |" . $additional_title . $title;
			return $custom_title;
		}else{
			return $additional_title . $title;
		}	
	}else{
		return $title;
	}
	
}

add_action('wp_head', 'ec_store_meta', 0);

function ec_store_meta( ){
	$page_id = get_the_ID();
	$store_id = get_option( 'ec_option_storepage' );
	
	if( $page_id == $store_id && isset( $_GET['model_number'] ) ){
		$db = new ec_db( );
		$products = $db->get_product_list( " WHERE product.model_number = '" . $_GET['model_number'] . "'", "", "", "" );
		if( count( $products ) > 0){
			echo "<meta name=\"description\" content=\"" . $products[0]['seo_description'] . "\"/>";
			echo "<meta name=\"keywords\" content=\"" . $products[0]['seo_keywords'] . "\" />";
		}
		
	}else if( $page_id == $store_id ){
		
		if( isset( $_GET['menuid'] ) ){
			$db = new ec_db( );
			$menu_row = $db->get_menu_row( $_GET['menuid'], 1 );
			echo "<meta name=\"description\" content=\"" . $menu_row->seo_description . "\"/>\n";
			echo "<meta name=\"keywords\" content=\"" . $menu_row->seo_keywords . "\" />\n";
			
		}else if( isset( $_GET['submenuid'] ) ){
			$db = new ec_db( );
			$menu_row = $db->get_menu_row( $_GET['submenuid'], 2 );
			echo "<meta name=\"description\" content=\"" . $menu_row->seo_description . "\"/>\n";
			echo "<meta name=\"keywords\" content=\"" . $menu_row->seo_keywords . "\" />\n";
			
		}else if( isset( $_GET['subsubmenuid'] ) ){
			$db = new ec_db( );
			$menu_row = $db->get_menu_row( $_GET['subsubmenuid'], 3 );
			echo "<meta name=\"description\" content=\"" . $menu_row->seo_description . "\"/>\n";
			echo "<meta name=\"keywords\" content=\"" . $menu_row->seo_keywords . "\" />\n";
			
		}
	}
}

function ec_theme_options_page_callback( ){
	if( is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option('ec_option_base_theme') . "/" ) )
		include( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option('ec_option_base_theme') . "/admin_panel.php");
	else
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option('ec_option_latest_theme') . "/admin_panel.php");
}

/////////////////////////////////////////////////////////////////////
//CUSTOM POST TYPES
/////////////////////////////////////////////////////////////////////
add_action( 'init', 'ec_create_post_type_menu' );
function ec_create_post_type_menu() {
	
	// Fix, V3 upgrades missed the ec_tempcart_optionitem.session_id upgrade!
	if( !get_option( 'ec_option_v3_fix' ) ){
		global $wpdb;
		$wpdb->query( "INSERT INTO ec_tempcart_optionitem( tempcart_id, option_id, optionitem_id, optionitem_value ) VALUES( '999999999', '3', '3', 'test' )" );
		$tempcart_optionitem_row = $wpdb->get_row( "SELECT * FROM ec_tempcart_optionitem WHERE tempcart_id = '999999999'" );
		if( !isset( $tempcart_optionitem_row->session_id ) ){
			$wpdb->query( "ALTER TABLE ec_tempcart_optionitem ADD `session_id` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'The ec_cart_id that determines the user who entered this value.'" );
		}
		update_option( 'ec_option_v3_fix', 1 );
	}
	
	// Update language when plugin updates
	if( !get_option( 'ec_option_language_version' ) || get_option( 'ec_option_language_version' ) != EC_CURRENT_VERSION ){	
		$language = new ec_language( );
		$language->update_language_data( ); //Do this to update the database if a new language is added
		update_option( 'ec_option_language_version', EC_CURRENT_VERSION );
	}
	
	// Update wp_options when plugin updates
	if( !get_option( 'ec_option_wpoptions_version' ) || get_option( 'ec_option_wpoptions_version' ) != EC_CURRENT_VERSION ){	
		$wpoptions = new ec_wpoptionset();
		$wpoptions->add_options();
		update_option( 'ec_option_wpoptions_version', EC_CURRENT_VERSION );
	}
	
	// Update store item posts, set to private if inactive in store
	if( !get_option( 'ec_option_published_check' ) || get_option( 'ec_option_published_check' ) != EC_CURRENT_VERSION ){	
		global $wpdb;
		$language = new ec_language( );
		$inactive_products = $wpdb->get_results( "SELECT ec_product.post_id, ec_product.model_number, ec_product.title FROM ec_product WHERE ec_product.activate_in_store = 0" );
		foreach( $inactive_products as $product ){
			$post = array(	'ID'			=> $product->post_id,
							'post_content'	=> "[ec_store modelnumber=\"" . $product->model_number . "\"]",
							'post_status'	=> "private",
							'post_title'	=> $language->convert_text( $product->title ),
							'post_type'		=> "ec_store",
							'post_name'		=> str_replace(' ', '-', $language->convert_text( $product->title ) ),
					  );
			wp_update_post( $post );
		}
		update_option( 'ec_option_published_check', EC_CURRENT_VERSION );
	}
	
	// Upgrading Fix for Product Shippable Option
	if( get_option( 'ec_option_product_ship_fix' ) != '3.0.19' ){
		
		global $wpdb;
		$wpdb->query( "UPDATE ec_product SET ec_product.is_shippable = 0 WHERE ec_product.is_giftcard = 1 OR ec_product.is_download = 1 OR ec_product.is_donation = 1 OR ec_product.is_subscription_item = 1 OR ec_product.weight <= 0" );
		$wpdb->query( "UPDATE ec_orderdetail SET ec_orderdetail.is_shippable = 0 WHERE ec_orderdetail.is_giftcard = 1 OR ec_orderdetail.is_download = 1" );
		
		add_option( 'ec_option_product_ship_fix', '3.0.19' );
		
	}
	
	$store_id = get_option( 'ec_option_storepage' );
	if( $store_id ){
		$store_slug = ec_get_the_slug( $store_id );
		
		$labels = array(
			'name'               => _x( 'Store Items', 'post type general name' ),
			'singular_name'      => _x( 'Store Item', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'ec_store' ),
			'add_new_item'       => __( 'Add New Store Item' ),
			'edit_item'          => __( 'Edit Store Item' ),
			'new_item'           => __( 'New Store Item' ),
			'all_items'          => __( 'All Store Items' ),
			'view_item'          => __( 'View Store Item' ),
			'search_items'       => __( 'Search Store Items' ),
			'not_found'          => __( 'No store items found' ),
			'not_found_in_trash' => __( 'No store items found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Store Items'
		);
		$args = array(
			'labels'        	=> $labels,
			'description' 		=> 'Used for the EasyCart Store',
			'public' 			=> true,
			'has_archive' 		=> false,
			'show_ui' 			=> false,
			'show_in_nav_menus' => true,
			'supports'			=> array( 'title', 'page-attributes', 'author', 'editor', 'post-formats' ),
			'rewrite'			=> array( 'slug' => $store_slug, 'with_front' => false, 'page' => false ),
		);
		register_post_type( 'ec_store', $args );
		
		global $wp_rewrite;
		$wp_rewrite->add_permastruct( 'ec_store', $store_slug . '/%ec_store%/', true, 1 );
    	add_rewrite_rule( '^' . $store_slug . '/([^/]*)/?$', 'index.php?ec_store=$matches[1]', 'top');
		
		// Only Flush Once!
		if( get_option( 'ec_option_added_custom_post_type' ) < 2 ){	
			$wp_rewrite->flush_rules();
			update_option( 'ec_option_added_custom_post_type', 2 );
		}
	}
}

function ec_get_the_slug( $id=null ){
	if( empty($id) ) : 
		global $post;
    	if( empty($post) )
			return '';
		$id = $post->ID;
	endif;
	$slug = basename( get_permalink($id) );
	return $slug;
}

add_action( 'wp', 'ec_force_page_type' );
function ec_force_page_type() {
	global $wp_query, $post_type;
	
	if( $post_type == 'ec_store' && !get_option( 'ec_option_use_custom_post_theme_template' ) ){
		$wp_query->is_page = true;
		$wp_query->is_single = false;
		$wp_query->query_vars['post_type'] = "page";
		if( isset( $wp_query->post ) )
			$wp_query->post->post_type = "page";
	}
}

add_filter( 'template_redirect', 'ec_fix_store_template', 1 );
function ec_fix_store_template( ){
	global $wp;
	$custom_post_types = array("ec_store");
	
	if( isset( $wp->query_vars["post_type"] ) && in_array( $wp->query_vars["post_type"], $custom_post_types ) ){
		$store_template = get_post_meta( get_option( 'ec_option_storepage' ), "_wp_page_template", true );
		if( isset( $store_template ) && $store_template != "" && $store_template != "default"  ){
			if( file_exists( get_template_directory( ) . "/" . $store_template ) ){
				include( get_template_directory( ) . "/" . $store_template );
				exit( );
			}
		}
	}
}

/////////////////////////////////////////////////////////////////////
//HELPER FUNCTIONS
/////////////////////////////////////////////////////////////////////
//Helper Function, Get URL
function ec_get_url(){
  if( isset( $_SERVER['HTTPS'] ) )
  	$protocol =  "https";
  else
	$protocol =  "http";
	
  $baseurl = "://" . $_SERVER['HTTP_HOST'];
  $strip = explode("/wp-admin", $_SERVER['REQUEST_URI']);
  $folder = $strip[0];
  return $protocol .  $baseurl . $folder;
}

function ec_setup_hooks( ){
	$GLOBALS['ec_hooks'] = array( );
}

function ec_add_hook( $call_location, $function_name, $args = array(), $priority = 1 ){
	if( !isset( $GLOBALS['ec_hooks'][$call_location] ) )
		$GLOBALS['ec_hooks'][$call_location] = array( );
	
	$GLOBALS['ec_hooks'][$call_location][] = array( $function_name, $args, $priority );
}

function ec_call_hook( $hook_array, $class_args ){
	$hook_array[0]( $hook_array[1], $class_args );
}

function ec_dwolla_verify_signature( $proposedSignature, $checkoutId, $amount ){
    $apiSecret = get_option( 'ec_option_dwolla_thirdparty_secret' );
	$amount = number_format( $amount, 2 );
    $signature = hash_hmac("sha1", "{$checkoutId}&{$amount}", $apiSecret);

    return $signature == $proposedSignature;
}

add_filter( 'wp_nav_menu_items', 'ec_custom_cart_in_menu', 10, 2 );
function ec_custom_cart_in_menu ( $items, $args ) {
	
	$ids = explode( '***', get_option( 'ec_option_cart_menu_id' ) );
	if( get_option( 'ec_option_show_menu_cart_icon' ) && ( in_array( substr( $args->menu_id, 0, -5 ), $ids ) || in_array( $args->theme_location, $ids ) ) ){
	
		$items .= '<li class="ec_menu_mini_cart"></li>';
		
	}
	
	return $items;
}

///////////////////HAVING ISSUES WITH OUT DURING ACTIVATION?? PRINT ERRORS!//////////////////
/*
add_action( 'activated_plugin','ec_save_error' );
function ec_save_error(){
	file_put_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY. '/error_activation.html', ob_get_contents( ) );
}
*/
?>