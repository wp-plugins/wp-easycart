<?php
/**
 * Plugin Name: WP EasyCart
 * Plugin URI: http://www.wpeasycart.com
 * Description: The WordPress Shopping Cart by WP EasyCart is a simple install into new or existing WordPress blogs. Customers purchase directly from your store! Get a full eCommerce platform in WordPress! Sell products, downloadable goods, gift cards, clothing and more! Now with WordPress, the powerful features are still very easy to administrate! If you have any questions, please view our website at <a href="http://www.wpeasycart.com" target="_blank">WP EasyCart</a>.  <br /><br /><strong>*** UPGRADING? Please be sure to backup your plugin, or follow our upgrade instructions at <a href="http://wpeasycart.com/docs/1.0.0/index/upgrading.php" target="_blank">WP EasyCart Upgrading</a> ***</strong>
 
 * Version: 1.1.33
 * Author: Level Four Development, llc
 * Author URI: http://www.wpeasycart.com
 *
 * This program is free to download and install, but requires the purchase of our shopping cart plugin to use live payment gateways, coupons, promotions, and more.
 * Each site requires a license for live use and must be purchased through the WP EasyCart website.
 *
 * @package wpeasycart
 * @version 1.1.33
 * @author WP EasyCart <sales@wpeasycart.com>
 * @copyright Copyright (c) 2012, WP EasyCart
 * @link http://www.wpeasycart.com
 */
 
define( 'EC_PUGIN_NAME', 'WP EasyCart');
define( 'EC_PLUGIN_DIRECTORY', 'wp-easycart');
define( 'EC_CURRENT_VERSION', '1_1_33' );
define( 'EC_CURRENT_DB', '1_5' );

require_once( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/ec_config.php' );

function ec_activate(){
	
	//ADD OPTIONS
	$wpoptions = new ec_wpoptionset();
	$wpoptions->add_options();
	
	//INITIALIZE
	$mysqli = new ec_db();
	
	// FIRST ATTEMPT TO INSTALL THE INITIAL VERSION.
	$install_sql_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/sql/install_' . EC_CURRENT_DB . '.sql';
	$f = fopen( $install_sql_url, "r" ) or die( "Could not open the install sql script. Likely the permissions on the file when copied from WordPress are preventing our activation script from accessing the install script. To fix this issue, look in your default wordpress plugins folder, then change the permissions on the following file to 775: wp-easycart/inc/admin/sql/install_x_x.sql (look for the highest version). Please submit a support ticket at www.wpeasycart.com with FTP access if you wish to have the WP EasyCart staff help you get up and running." );
	
	$install_sql = fread( $f, filesize( $install_sql_url ) );
	$install_sql_array = explode(';', $install_sql);
	$mysqli->install( $install_sql_array );
	
	//UPDATE SITE URL
	$site = explode( "://", ec_get_url( ) );
	$site = $site[1];
	$mysqli->update_url( $site );
	
	//SETUP BASIC LANGUAGE SETTINGS
	$language = new ec_language( );
	
	//WE BLOCK THIS FROM THE ec_config.php TO PREVENT OUTPUT ON ACTIVATION, INCLUDE HERE...
	update_option( 'ec_option_is_installed', '1' );
	$GLOBALS['setting'] = new ec_setting( );
	
	//WRITE OUR EC_CONN FILE FOR AMFPHP
	$ec_conn_php = "<?php
						define ('HOSTNAME','" . DB_HOST . "'); 	
						define ('DATABASE','" . DB_NAME . "'); 		
						define ('USERNAME','" . DB_USER . "'); 	
						define ('PASSWORD','" . DB_PASSWORD . "'); 	
					?>"; 

	$ec_conn_filename = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/connection/ec_conn.php";
	
	$ec_conn_filehandler = fopen($ec_conn_filename, 'w');
	fwrite($ec_conn_filehandler, $ec_conn_php);
	fclose($ec_conn_filehandler);
	
	if( get_option( 'ec_option_currency' ) == '&#36;' ){
		update_option( 'ec_option_currency', '$' );	
	}
	
}

function ec_uninstall(){
	
	$mysqli = new ec_db();
	
	$uninstall_sql_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/sql/uninstall_' .  get_option( 'ec_option_db_version' ) . '.sql';
	$f = fopen( $uninstall_sql_url, "r" ) or die( "The plugin could not uninstall properly. This is most likely because the permissions set on the database plugin removal script does not allow us to access it. To fix this problem go to your default WordPress plugins folder and change the permissions on the following file to 775: wp-easycart/inc/admin/sql/uninstall_x_x.sql (look for the latest version). Contact WP EasyCart support by submitting a support ticket at www.wpeasycart.com with FTP access for assistance." );
	$uninstall_sql = fread( $f, filesize( $uninstall_sql_url ) );
	$uninstall_sql_array = explode(';', $uninstall_sql);
	$mysqli->uninstall( $uninstall_sql_array );
	
	//delete options
	$wpoptions = new ec_wpoptionset();
	$wpoptions->delete_options();
	
}

register_activation_hook( __FILE__, 'ec_activate' );
register_uninstall_hook( __FILE__, 'ec_uninstall' );

function load_ec_pre(){
	
	// NOW LETS CHECK TO SEE IF WE NEED TO UPGRADE THE DB
	if( get_option( 'ec_option_db_version' ) && EC_CURRENT_DB != get_option( 'ec_option_db_version' ) ){
		$update_sql_url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/sql/upgrade_' . get_option( 'ec_option_db_version') . '_to_' . EC_CURRENT_DB . '.sql';
		$f = fopen( $update_sql_url, "r") or die("The Wp EasyCart plugin was unable to access the database upgrade script. Upgrade halted. To fix this problem, change the permissions on the following files to 775 and try again: wp-easycart/inc/admin/sql/upgrade_x_x_to_x_x (change all upgrade files unless you know what plugin DB version you have and which you are upgrading to). Contact WP EasyCart support by submitting a support ticket at www.wpeasycart.com with FTP access for assistance.");
		$upgrade_sql = fread( $f, filesize( $update_sql_url ) );
		$upgrade_sql_array = explode(';', $upgrade_sql);
		$db = new ec_db();
		$db->upgrade( $upgrade_sql_array );
		update_option( 'ec_option_db_version', EC_CURRENT_DB );
	}
	
	// check for a banners folder, upgrader needs to create this if it doesn't
	$banners_folder = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/products' . "/banners";
	if( !file_exists( $banners_folder  ) ){
		// Any version before 13 needs the banner folder.
		if( !mkdir( $banners_folder, 0757 ) )
			echo "The WP EasyCart plugin could not add a folder to your install on upgrade. You will need to manually add this folder on your server to access future features. To solve this issue add a folder called 'banners' to the following directory: wp-easycart/products/ (so wp-easycart/products/banners needs to exist). Contact WP EasyCart support by submitting a support ticket at www.wpeasycart.com with FTP access for assistance.";
	}
	
	$storepageid = get_option('ec_option_storepage');
	$cartpageid = get_option('ec_option_cartpage');
	$accountpageid = get_option('ec_option_accountpage');
	
	$storepage = get_permalink( $storepageid );
	$cartpage = get_permalink( $cartpageid );
	$accountpage = get_permalink( $accountpageid );
	
	if(substr_count($storepage, '?'))							$permalinkdivider = "&";
	else														$permalinkdivider = "?";
	
	if( isset( $_SERVER['HTTPS'] ) )							$currentpageid = url_to_postid( "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	else														$currentpageid = url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	
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
	}
	
	/* Account Form Actions, Process Prior to WP Loading */
	if( isset( $_POST['ec_account_form_action'] ) ){
		$ec_accountpage = new ec_accountpage();
		$ec_accountpage->process_form_action( $_POST['ec_account_form_action'] );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "logout" ){
		$ec_accountpage = new ec_accountpage();
		$ec_accountpage->process_form_action( "logout" );
	
	}
	
	/* Newsletter Form Actions */
	if( isset( $_POST['ec_newsletter_email'] ) ){
		$ec_db = new ec_db();
		$ec_db->insert_subscriber( $_POST['ec_newsletter_email'], "", "" );
	}
}

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

function ec_load_css( ){
	
	wp_register_style( 'wpeasycart_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_css_loader.php' ) );
	wp_enqueue_style( 'wpeasycart_css' );
	
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

function ec_load_js( ){
	wp_register_script( 'wpeasycart_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_js_loader.php' ), array( 'jquery' ) );
	wp_enqueue_script( 'wpeasycart_js' );
	
	$https_link = "";
	if( class_exists( "WordPressHTTPS" ) ){
		$https_class = new WordPressHTTPS( );
		$https_link = $https_class->getHttpsUrl() . '/wp-admin/admin-ajax.php';
	}else{
		$https_link = str_replace( "http://", "https://", admin_url( 'admin-ajax.php' ) );
	}
	
	if( isset( $_SERVER['HTTPS'] ) && $_SERVER["HTTPS"] == "on" )
		wp_localize_script( 'wpeasycart_js', 'ajax_object', array( 'ajax_url' => $https_link ) );
	else
		wp_localize_script( 'wpeasycart_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}	
	
function ec_facebook_metadata() {
	if( isset( $_GET['model_number'] ) ){
		$query_productRS = sprintf("SELECT ec_product.* FROM ec_product WHERE ec_product.model_number = '%s'", mysql_real_escape_string($_GET['model_number']));
		$productRS = mysql_query($query_productRS);
		$product = mysql_fetch_assoc($productRS);
		
		$prod_title = $product['title'];
		$prod_model_number = $product['model_number'];
		$prod_description = $product['description'];
	
		if($product['use_optionitem_images']){
			$optimg_sql = sprintf("SELECT ec_optionitemimage.image1 FROM ec_optionitemimage WHERE ec_optionitemimage.product_id = '%s' ", $product['product_id']);
			$optimgs = mysql_query($optimg_sql);
			$optimg = mysql_fetch_assoc($optimgs);
			$prod_image = $optimg['image1'];
		} else {
			$prod_image = $product['image1'];
		}	
		
		remove_action('wp_head', 'rel_canonical');
		
		//this method places to early, before html tags open
		echo "<meta property=\"og:title\" content=\"" . $prod_title . "\" />\n"; 
		echo "<meta property=\"og:type\" content=\"product\" />\n";
		echo "<meta property=\"og:description\" content=\"" . ec_short_string($prod_description, 300) . "\" />\n";
		echo "<meta property=\"og:image\" content=\"" .  plugin_dir_url(__DIR__) . "wpeasycart/products/pics1/" . $prod_image . "\" />\n"; 
		echo "<meta property=\"og:url\" content=\"" . ec_curPageURL() . "\" /> \n";
	}
}
	
function ec_curPageURL() {
	$pageURL = 'http';
	if( isset( $_SERVER["HTTPS"] ) )
		$pageURL .= "s";

	$pageURL .= "://";
	if( $_SERVER["SERVER_PORT"] != "80" )
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	return $pageURL;
}

function ec_short_string($text, $length){
	if( strlen( $text ) > $length )
		$text = substr($text, 0, strpos($text, ' ', $length));
	
	return $text;
}

//[ecstore]
function load_ec_store( $atts ){
	extract( shortcode_atts( array(
		'menuid' => 'NOMENU',
		'submenuid' => 'NOSUBMENU',
		'subsubmenuid' => 'NOSUBSUBMENU',
		'manufacturerid' => 'NOMANUFACTURER',
		'groupid' => 'NOGROUP',
		'modelnumber' => 'NOMODELNUMBER'
	), $atts ) );
	
	ob_start();
    $store_page = new ec_storepage( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
	$store_page->display_store_page();
    return ob_get_clean();

}

//[eccart]
function load_ec_cart( $atts ){
	ob_start( );
	$cart_page = new ec_cartpage( );
	$cart_page->display_cart_page( );
	return ob_get_clean( );
}

//[ecaccount]
function load_ec_account( $atts ){
	ob_start( );
    $account_page = new ec_accountpage( );
	if( isset( $_POST['ec_form_action'] ) )
		$account_page->process_form_action( $_POST['ec_form_action'] );	
	else
		$account_page->display_account_page( );
    return ob_get_clean();
}

//[ecproduct]
function load_ec_product( $atts ){
	extract( shortcode_atts( array(
		'model_number' => 'NOPRODUCT'
	), $atts ) );
	$simp_product_id = $model_number;
	ob_start( );
    $mysqli = new ec_db( );
	$products = $mysqli->get_product_list( " WHERE product.model_number = '" . $model_number . "'", "", "", "" );
	if( count( $products ) > 0 ){
		$product = new ec_product( $products[0], 0, 0, 1 );
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_widget.php' );
	}
    return ob_get_clean( );
}

function ec_wp_myplugin_property_title($data){ 
	global $post;
	if( isset($_GET['model_number']) && $post->ID == $storepageid ){
		$query_productRS = sprintf("SELECT products.Title FROM products WHERE model_number = '%s'", mysql_real_escape_string($_GET['model_number']));
		$productRS = mysql_query($query_productRS);
		$row_productRS = mysql_fetch_assoc($productRS);
		
		$seotitle = $row_productRS['Title'];
		return $seotitle . " ";
	}else{
		return $data;
	}	
}

function wpeasycart_register_widgets( ) {
	register_widget( 'ec_breadcrumbwidget' );
	register_widget( 'ec_categorywidget' );
	register_widget( 'ec_cartwidget' );
	register_widget( 'ec_groupwidget' );
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

add_shortcode( 'ec_store', 'load_ec_store' );
add_shortcode( 'ec_cart', 'load_ec_cart' );
add_shortcode( 'ec_account', 'load_ec_account' );
add_shortcode( 'ec_product', 'load_ec_product' );

add_filter( 'widget_text', 'do_shortcode');

add_action('wp_head', 'ec_facebook_metadata');


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
	
	if( !is_writable( WP_PLUGIN_DIR ) ){
			
		wpeasycart_backup_ftp( );
		
	}else{
	
		$to = dirname( __FILE__ ) . "/../ec-back-up-directory/"; // <------- this back up directory will be made
		$from = dirname( __FILE__ ) . "/"; // <------- this is the directory that will be backed up
		
		 // Make destination directory
		if( !is_dir( $to )) {
			$success = mkdir( $to, 0755 );
			if( !$success ){
				$err_message = "wpeasycart - error creating backup directory. Updated halted.";
				error_log( $err_message );
				exit( $err_message );	
			}
		}
		
		$success = wpeasycart_copyr( $from . "products", $to . "products" ); // <------- executes wpeasycart copy action
		if( !$success ){
			$err_message = "wpeasycart - error backing up the products folder. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
		$success = wpeasycart_copyr( $from . "design", $to . "design" ); // <------- executes wpeasycart copy action
		if( !$success ){
			$err_message = "wpeasycart - error backing up the design folder. Updated halted.";
			error_log( $err_message );
			exit( $err_message );
		}
		$success = wpeasycart_copyr( $from . "connection", $to . "connection" ); // <------- executes wpeasycart copy action
		if( !$success ){
			$err_message = "wpeasycart - error backing up the connection folder. Updated halted.";
			error_log( $err_message );
			exit( $err_message );
		}
	}
}

function wpeasycart_backup_ftp( ){
	// Could not open the file, lets write it via ftp!
	$ftp_server = $_POST['hostname'];
	$ftp_user_name = $_POST['username'];
	$ftp_user_pass = $_POST['password'];
	
	// set up basic connection
	$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
	
	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	
	if( !$login_result ){
		
		die( "Could not connect to your server via FTP to backup your wp-easycart install. Please try re-entering your informaiton and try again." );
		
	}else{
		
		ftp_rename( $conn_id, WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY, WP_PLUGIN_DIR . "/wp-easycart-backup" );
		if( !is_dir( WP_PLUGIN_DIR . "/wp-easycart-backup" ) ){
			die( "Could not move your wp-easycart plugin (to backup), process halted to save your data. If the problem persists you can either change the permissions of your wp-easycart plugin folder OR manually back this folder up and install the latest version manually." );	
		}
		
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

function wpeasycart_recover( ){
	
	if( !is_writable( WP_PLUGIN_DIR ) ){
			
		wpeasycart_recover_ftp( );
		
	}else{
	
		$from = dirname(__FILE__) . "/../ec-back-up-directory/"; // <------- this back up directory will be made
		$to = dirname( __FILE__ ) . "/"; // <------- this is the directory that will be backed up
		
		// REMOVE THE UPDATED PLUGIN FOLDERS TO BE REPLACED
		$success = false;
		if( is_dir( $to . "products" ) ) {
			$success = ec_recursive_remove_directory( $to . "products" ); //<------- deletes the updated directory
		}
		if( !$success ){
			$err_message = "wpeasycart - error removing the products folder from the upgraded plugin. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
		
		/**********************************************************
		 * ANYONE PRIOR TO 1.1.7 WILL RUN THIS UPGRADE TO GET THEIR
		 * THEMES UP TO SPEED WITH THE LATEST SOFTWARE
		 **********************************************************/
		
		/* We are adding a few new files to every theme. Lets do this by copying from the new folder to backup IF IT DOESN"T EXIST */
		$group_layout = $to . "design/layout/base-responsive-v1/ec_group_widget.php";
		$group_css = $to . "design/theme/base-responsive-v1/ec_group_widget/ec_group_widget.css";
		$group_js = $to . "design/theme/base-responsive-v1/ec_group_widget/ec_group_widget.js";
		$rtl_file = $to . "design/theme/base-responsive-v1/rtl_support.css";
		
		//Cycle through design folders, add dir and files
		$layout_list = array_filter( glob($from . 'design/layout/*'), 'is_dir' );
		$theme_list = array_filter( glob($from . 'design/theme/*'), 'is_dir' );
		
		//Loop through the layout folders
		for( $i=0; $i<count( $layout_list ); $i++ ){
			if( !file_exists( $layout_list[$i] . "/ec_group_widget.php" ) )
				copy( $group_layout, $layout_list[$i] . "/ec_group_widget.php" );
		}
		
		//Loop through the theme folders
		for( $i=0; $i<count( $theme_list ); $i++ ){
			if( !is_dir( $theme_list[$i] . "/ec_group_widget" ) )
				mkdir( $theme_list[$i] . "/ec_group_widget" );
			if( !file_exists( $theme_list[$i] . "/ec_group_widget/ec_group_widget.css" ) )
				copy( $group_css, $theme_list[$i] . "/ec_group_widget/ec_group_widget.css" );
			if( !file_exists( $theme_list[$i] . "/ec_group_widget/ec_group_widget.js" ) )
				copy( $group_js, $theme_list[$i] . "/ec_group_widget/ec_group_widget.js" );
			if( !file_exists( $theme_list[$i] . "/rtl_support.css" ) )
				copy( $rtl_file, $theme_list[$i] . "/rtl_support.css" );
			
		}
		/**********************************************************
		 * END 1.1.7 UPGRADE
		 **********************************************************/
		
		$success = false;
		if( is_dir( $to . "design" ) ) {
			$success = ec_recursive_remove_directory( $to . "design" ); //<------- deletes the updated directory
		}
		if( !$success ){
			$err_message = "wpeasycart - error removing the design folder from the upgraded plugin. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
		
		$success = false;
		if( is_dir( $to . "connection" ) ) {
			$success = ec_recursive_remove_directory( $to . "connection" ); //<------- deletes the updated directory
		}
		if( !$success ){
			$err_message = "wpeasycart - error removing the connection folder from the upgraded plugin. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
		
		// COPY OVER THE BACKED UP DIRECTORIES
		$success = wpeasycart_copyr( $from . "products", $to . "products" ); // <------- executes wpeasycart copy action
		if( !$success ){
			$err_message = "wpeasycart - error recovering the products folder. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
		$success = wpeasycart_copyr( $from . "design", $to . "design" ); // <------- executes wpeasycart copy action
		if( !$success ){
			$err_message = "wpeasycart - error recovering the design folder. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
		$success = wpeasycart_copyr( $from . "connection", $to . "connection" ); // <------- executes wpeasycart copy action
		if( !$success ){
			$err_message = "wpeasycart - error recovering the connection folder. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
		
		// MADE IT HERE WITHOUT AN ERROR, WE CAN NOW REMOVE THE BACKUP DIRECOTRY
		$success = false;
		if( is_dir( $from ) ) {
			$success = ec_recursive_remove_directory( $from ); //<------- deletes the backup directory
		}
		if( !$success ){
			$err_message = "wpeasycart - error removing the backup folder. Updated halted.";
			error_log( $err_message );
			exit( $err_message );	
		}
	}
}

function wpeasycart_recover_ftp( ){
	// Could not open the file, lets write it via ftp!
	$ftp_server = $_POST['hostname'];
	$ftp_user_name = $_POST['username'];
	$ftp_user_pass = $_POST['password'];
	
	// set up basic connection
	$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
	
	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	
	if( !$login_result ){
		
		die( "Could not connect to your server via FTP to backup your wp-easycart install. Please try re-entering your information and try again." );
		
	}else{
		
		$res = ftp_rename( $conn_id, WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY, WP_PLUGIN_DIR . "/wp-easycart-backup" );
		if( !$res ){
			die( "Could not move your wp-easycart plugin (to backup), process halted to save your data. If the problem persists you can either change the permissions of your wp-easycart plugin folder OR manually back this folder up and install the latest version manually." );	
		}
		
		$wp_new = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
		$wp_backup = WP_PLUGIN_DIR . "/wp-easycart-backup/";
		
		// Recover products images
		ftp_rename( $conn_id, $wp_new . "products", $wp_backup . "products_new" );
		$res = ftp_rename( $conn_id, $wp_backup . "products" . $wp_new . "products" );
		if( !$res ){
			die( "Could not recover your products folder. Process halted. Your products are saved in the folder wp-easycart-backup, copy them to the new plugin to recover." );
		}
		
		// Recover Design Files
		ftp_rename( $conn_id, $wp_new . "design", $wp_backup . "design_new" );
		$res = ftp_rename( $conn_id, $wp_backup . "design" . $wp_new . "design" );
		if( !$res ){
			die( "Could not recover your design folder. Process halted. Your designs are saved in the folder wp-easycart-backup, copy them to the new plugin to recover." );
		}
		
		// Recover Connection Files
		ftp_rename( $conn_id, $wp_new . "connection", $wp_backup . "connection_new" );
		$res = ftp_rename( $conn_id, $wp_backup . "connection" . $wp_new . "connection" );
		if( !$res ){
			die( "Could not recover your connection folder. Process halted. Your connection are saved in the folder wp-easycart-backup, copy them to the new plugin to recover." );
		}
		
		// Change the name of the backup to a particular time in case it needs to be recoverd!
		$date = date_create();
		$time_stamp = date_timestamp_get($date);
		ftp_rename( $conn_id, $wp_backup, WP_PLUGIN_DIR . "/wp-easycart-backup-" . $time_stamp );
	}
}

add_filter( 'upgrader_pre_install', 'wpeasycart_backup', 10, 2 ); // <------- adds the wpeasycart_backup filter
add_filter( 'upgrader_post_install', 'wpeasycart_recover', 10, 2 ); //<------- adds the wpeasycart_recover filter

//////////////////////////////////////////////
//END UPDATE FUNCTIONS
//////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
//AJAX SETUP FUNCTIONS
/////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_ec_ajax_cartitem_update', 'ec_ajax_cartitem_update' );
add_action( 'wp_ajax_nopriv_ec_ajax_cartitem_update', 'ec_ajax_cartitem_update' );
function ec_ajax_cartitem_update( ){
	
	// UPDATE CART ITEM
	$tempcart_id = $_POST['cartitem_id'];
	$session_id = $_POST['session_id'];
	$quantity = $_POST['quantity'];
	
	if( is_numeric( $quantity ) ){
		$db = new ec_db();
		$db->update_cartitem( $tempcart_id, $session_id, $quantity );
	}
	// UPDATE CART ITEM
	
	// GET NEW CART ITEM INFO
	$cart = new ec_cart( session_id() );
	
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
			$GLOBALS['currency']->get_currency_display( $order_totals->discount_total ) . "***" .
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_ec_ajax_cartitem_delete', 'ec_ajax_cartitem_delete' );
add_action( 'wp_ajax_nopriv_ec_ajax_cartitem_delete', 'ec_ajax_cartitem_delete' );
function ec_ajax_cartitem_delete( ){
	
	//Get the variables from the AJAX call
	$tempcart_id = $_POST['cartitem_id'];
	$session_id = $_POST['session_id'];
	
	// DELTE CART ITEM
	$db = new ec_db();
	$ret_data = $db->delete_cartitem( $tempcart_id, $session_id );
	// DELETE CART ITEM
	$cart = new ec_cart( session_id() );
	$order_totals = ec_get_order_totals( );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" .  
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->discount_total ) . "***" .
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_redeem_coupon_code', 'ec_ajax_redeem_coupon_code' );
add_action( 'wp_ajax_nopriv_ec_ajax_redeem_coupon_code', 'ec_ajax_redeem_coupon_code' );
function ec_ajax_redeem_coupon_code( ){
	
	//UPDATE COUPON CODE
	$coupon_code = "";
	if( isset( $_POST['couponcode'] ) )
		$coupon_code = $_POST['couponcode'];
		
	$_SESSION['ec_couponcode'] = $coupon_code;
	
	$db = new ec_db();
	$coupon = $db->redeem_coupon_code( $coupon_code );
	// UPDATE COUPON CODE
	$cart = new ec_cart( session_id() );
	$order_totals = ec_get_order_totals( );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->discount_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	if( $coupon )
		echo "***" . $coupon->message;
	else
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' );
	
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
	// UPDATE GIFT CARD
	$cart = new ec_cart( session_id() );
	$order_totals = ec_get_order_totals( );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->discount_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	if( $giftcard )
		echo "***" . $giftcard->message;
	else
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_giftcard' );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_estimate_shipping', 'ec_ajax_estimate_shipping' );
add_action( 'wp_ajax_nopriv_ec_ajax_estimate_shipping', 'ec_ajax_estimate_shipping' );
function ec_ajax_estimate_shipping( ){
	//Get the variables from the AJAX call
	if( isset( $_POST['zipcode'] ) )
		$_SESSION['ec_temp_zipcode'] = $_POST['zipcode'];
	
	$cart = new ec_cart( session_id() );
	$order_totals = ec_get_order_totals( );
	$setting = new ec_setting( );
	$cart = new ec_cart( session_id() );
	$shipping = new ec_shipping( $cart->subtotal, $cart->weight );
	
	$shipping_options = $shipping->get_shipping_options( "", "" );
	
	if( $setting->get_shipping_method() == "live" && $shipping_options )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->vat_total );
	else if( $setting->get_shipping_method() == "live" )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . "<div class=\"ec_cart_shipping_method_row\">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_error' ) . "</div>";
	else
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
		
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_update_shipping_method', 'ec_ajax_update_shipping_method' );
add_action( 'wp_ajax_nopriv_ec_ajax_update_shipping_method', 'ec_ajax_update_shipping_method' );
function ec_ajax_update_shipping_method( ){
	
	//Get the variables from the AJAX call
	$shipping_method = $_POST['shipping_method'];
	
	//Create a new db and submit review
	$_SESSION['ec_shipping_method'] = $shipping_method;
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_insert_customer_review', 'ec_ajax_insert_customer_review' );
add_action( 'wp_ajax_nopriv_ec_ajax_insert_customer_review', 'ec_ajax_insert_customer_review' );
function ec_ajax_insert_customer_review( ){
	
	//Get the variables from the AJAX call
	$product_id = $_POST['product_id'];
	$rating = $_POST['rating'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	
	//Create a new db and submit review
	$db = new ec_db();
	echo $db->submit_customer_review( $product_id, $rating, $title, $description );
	
	die(); // this is required to return a proper result
	
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
	
	$cart = new ec_cart( session_id() );
	$user = new ec_user( $user_email );
	$shipping = new ec_shipping( $cart->subtotal, $cart->weight );
	$tax = new ec_tax( $cart->subtotal, $cart->taxable_subtotal, 0, $user->shipping->state, $user->shipping->country );
	$grand_total = ( $cart->subtotal + $tax->tax_total + $shipping->get_shipping_price( ) + $tax->duty_total );
	$discount = new ec_discount( $cart, $cart->subtotal, $shipping->get_shipping_price( ), $coupon_code, $gift_card, $grand_total );
	$vatable_subtotal = $grand_total - $discount->coupon_discount;
	$tax = new ec_tax( $cart->subtotal, $cart->taxable_subtotal, $vatable_subtotal, $user->shipping->state, $user->shipping->country );
	$discount = new ec_discount( $cart, $cart->subtotal, $shipping->get_shipping_price( ), $coupon_code, $gift_card, $GLOBALS['currency']->get_number_only( $grand_total ) + $GLOBALS['currency']->get_number_only( $tax->vat_total ) );
	$order_totals = new ec_order_totals( $cart, $user, $shipping, $tax, $discount );
	return $order_totals;
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
	include("design/theme/" . get_option('ec_option_base_theme') . "/admin_panel.php");
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

///////////////////HAVING ISSUES WITH OUT DURING ACTIVATION?? PRINT ERRORS!//////////////////
/*
add_action( 'activated_plugin','ec_save_error' );
function ec_save_error(){
	file_put_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY. '/error_activation.html', ob_get_contents( ) );
}
*/
?>