<?php
////////////////////////////////////////////
// ADMIN INITIALIZE/LOCALIZE AJAX Functions
////////////////////////////////////////////
add_action( 'admin_enqueue_scripts', 'ec_load_admin_scripts' );
add_action( 'admin_init', 'ec_register_settings' );
add_action( 'admin_menu', 'ec_create_menu' );
add_action( 'admin_init', 'ec_custom_downloads', 1 );
add_action( 'admin_notices', 'ec_install_admin_notice' );
add_action( 'save_post', 'ec_post_save_permalink_structure' );
add_action( 'save_post', 'ec_post_save_match_store_meta', 13 );
add_action( 'init', 'ec_add_editor_buttons' );
add_action( 'admin_footer', 'ec_print_editor' );
add_action( 'wp_ajax_ec_editor_update_sub_menu', 'ec_editor_update_sub_menu' );
add_action( 'wp_ajax_ec_editor_update_subsub_menu', 'ec_editor_update_subsub_menu' );

function ec_install_admin_notice() {
	if( isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "basic-setup" ){
		update_option( 'ec_option_show_install_message', '1' );
	}
	
	if( !get_option( 'ec_option_show_install_message' ) && ( !get_option( 'ec_option_accountpage' ) || !get_option( 'ec_option_cartpage' ) || !get_option( 'ec_option_storepage' ) ) ){
    ?>
    <div class="updated">
        <p>You Have not Setup Your WP EasyCart! Please <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">Click Here to Setup</a>.</p>
    </div>
    <?php
	}
	
	// Check if the admin manage notice should be removed
	if( isset( $_GET['page'] ) && $_GET['page'] == "ec_adminv2" && isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "admin-console" && isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "admin" && isset( $_GET['ec_notice'] ) && $_GET['ec_notice'] == "dismiss" ){
		update_option( 'ec_option_hide_admin_notice', '1' );
	}
	
	// Check if admin is installed
	if( !is_plugin_active( "wp-easycart-admin/wpeasycart-admin.php" ) ){
	?>
    <div class="updated">
        <p>EasyCart is best run with the WP EasyCart Admin Console, <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin">click here to learn how it can be installed</a>.</p>
    </div>
    <?php
	}else if( !get_option( 'ec_option_hide_admin_notice' ) ){
	?>
    <div class="updated">
        <p>Want to add/edit products, manage orders, manage users, or manage store rates? <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin">click here to view the WP EasyCart Admin Console</a>. <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_notice=dismiss">To dismiss this notice, click here</a></p>
    </div>
    <?php	
	}
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){ ?>
	
    <div class="error">
        <p>Your server appears to be missing the wp-easycart-data folder, which could cause data loss on upgrade. Please <a href="http://www.wpeasycart.com/plugin-update-help" target="_blank">click here</a> to learn how to correct this issue.</p>
    </div>
    	
	<?php
    }
	
	if( get_option( 'ec_option_display_as_catalog' ) ){ ?>
	
    <div class="updated">
        <p>You currently have your store in catalog only mode. This means that your customers can only view the products, not add to cart or checkout. If you think this was turned on by mistake, you can turn it off by <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-setup">clicking here</a> and set Display Store as Catalog to Off.</p>
    </div>
    
	<?php }
	/*
	// Check for newer layout/theme files
	$current_version_design = file_get_contents( "http://www.wpeasycart.com/latest-design-version.txt" );
	$this_design = get_option( 'ec_option_base_theme' );
	$has_matches = preg_match( "/([0-9]+?\-[0-3][0-9]\-[0-9][0-9][0-9][0-9])/", $this_design, $matches );
	if( $has_matches && $matches[0] != $current_version_design ){?>
	
    <div class="updated">
        <p>There is a new version of the store design available (<?php echo $current_version_design; ?>). Please visit your <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management">design file management page</a> and follow the directions to upgrade.</p>
	</div>
    
    <?php }*/
}

function ec_load_admin_scripts( ){
	
	include( 'style.php' );
	
	wp_enqueue_media();
	
	wp_register_script( 'wpeasycart_admin_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/admin_ajax_functions.js' ), array( 'jquery' ) );
	wp_enqueue_script( 'wpeasycart_admin_js' );
	
	wp_register_script( 'wpeasycart_simple_admin_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/assets/js/admin.js' ), array( 'jquery' ) );
	wp_enqueue_script( 'wpeasycart_simple_admin_js' );
	
	$https_link = "";
	if( class_exists( "WordPressHTTPS" ) ){
		$https_class = new WordPressHTTPS( );
		$https_link = $https_class->getHttpsUrl() . '/wp-admin/admin-ajax.php';
	}else{
		$https_link = str_replace( "http://", "https://", admin_url( 'admin-ajax.php' ) );
	}
	
	if( isset( $_SERVER['HTTPS'] ) )
		wp_localize_script( 'wpeasycart_admin_js', 'ajax_object', array( 'ajax_url' => $https_link ) );
	else
		wp_localize_script( 'wpeasycart_admin_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

function ec_register_settings() {
	
	//register admin css
	wp_register_style( 'wpeasycart_admin_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/wpadmin_stylesheet.css' ), array(), '2.1.3' );
	wp_enqueue_style( 'wpeasycart_admin_css' );
	
	//register admin css
	wp_register_style( 'wpeasycart_adminv2_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/assets/css/wpeasycart_adminv2.css' ), array(), '2.1.3' );
	wp_enqueue_style( 'wpeasycart_adminv2_css' );
	
	//register admin css
	wp_register_style( 'wpeasycart_editor_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/assets/css/editor.css' ), array(), '2.1.3' );
	wp_enqueue_style( 'wpeasycart_editor_css' );
		
	//register options
	$wpoptions = new ec_wpoptionset();
	$wpoptions->register_options();
	
}

function ec_create_menu() {
	
	//V2 Admin
	$wp_version = get_bloginfo( 'version' );
	if( $wp_version < 3.8 ){
		add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', plugins_url( 'images/wp_16x16_icon.png', __FILE__ ) );
	}else{
		add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', 'dashicons-cart' );
		//add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', plugins_url( 'assets/images/sidebar_icon.png', __FILE__ ) );
	}
}

function ec_custom_downloads( ){
	if( is_admin( ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "backup-store" && ( $_GET['ec_action'] == "download_designs" || $_GET['ec_action'] == "download_products" ) ){
		
		if( $_GET['ec_action'] == "download_designs" ){
			$zipname = WP_PLUGIN_DIR . "/wp-easycart-data/design.zip";
			$zip_shortname = "design.zip";
		}else if( $_GET['ec_action'] == "download_products" ){
			$zipname = WP_PLUGIN_DIR . "/wp-easycart-data/products.zip";
			$zip_shortname = "products.zip";
		}
		$zip = new ZipArchive;
		$zip->open( $zipname, ZipArchive::CREATE );
		
		if( $_GET['ec_action'] == "download_designs" ){
			$source = WP_PLUGIN_DIR . "/wp-easycart-data/design/";
		}else if( $_GET['ec_action'] == "download_products" ){
			$source = WP_PLUGIN_DIR . "/wp-easycart-data/products/";
		}
		$source = str_replace( '\\', '/', realpath( $source ) );
		
		$files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $source ), RecursiveIteratorIterator::SELF_FIRST );

        foreach( $files as $file ){
            $file = str_replace( '\\', '/', realpath( $file ) );

            if( is_dir( $file ) === true ){
                $zip->addEmptyDir( str_replace( $source . '/', '', $file . '/' ) );
            
			}else if( is_file( $file ) === true ){
                $zip->addFromString( str_replace( $source . '/', '', $file ), file_get_contents( $file ) );
            }
        }
		
		$zip->close( );
		
		if( file_exists( $zipname ) ){
			header( "Cache-Control: public, must-revalidate" );
			header( "Pragma: no-cache" );
			header( 'Content-Type: application/octet-stream' );
			header( "Content-Length: " . ( string )( filesize( $zipname ) ) );
			header( 'Content-Disposition: attachment; filename="' . $zip_shortname . '"' );
			header( "Content-Transfer-Encoding: binary\n" );
			
			$fh = fopen( $zipname, "rb" );
				
			while( !feof( $fh ) ){
				$buffer = fread( $fh, 8192 );
				echo $buffer;
				ob_flush( );
				flush( ); 
			}
			
			fclose( $fh );
			
			unlink( $zipname );
			exit;
		
		}else{
			exit( "Could not find the zip to be downloaded" );
		}
	}else if( is_admin( ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "backup-store" && $_GET['ec_action'] == "download_db" ){
		$mysql_database = DB_NAME;
		$db_selected = mysql_select_db($mysql_database);
		
		// Get the contents
		$file_contents = ec_mysqldump( $mysql_database );
		
		$sql_shortname = "Storefront_Backup_" . date( 'Y_m_d' ) . ".sql";
		$sqlname = WP_PLUGIN_DIR . "/wp-easycart-data/" . $sql_shortname;
		
		file_put_contents( $sqlname, $file_contents );
		
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header( "Content-type: text/plain");
		header( 'Content-Disposition: attachment; filename=' . $sql_shortname );
		header( 'Content-Length: ' . ( string )( filesize( $sqlname ) ) );
		header( "Content-Transfer-Encoding: binary" );
		header( 'Expires: 0');
		header( 'Cache-Control: private');
		header( 'Pragma: private');
		
		readfile( $sqlname );
		unlink( $sqlname );
		
		// Stop the page execution so that it doesn't print HTML to the file accidently
		die();
	}
}

//store settings menu
function ec_settings_page_callback(){
	include("ec_install.php");
}

function ec_install_page_callback(){
	include("ec_install.php");
}

function ec_setup_page_callback(){
	include("store_setup.php");
}

function ec_payment_page_callback(){
	include("payment.php");
}

function ec_social_icons_page_callback(){
	include("social_icons.php");
}

function ec_language_page_callback(){
	include("language.php");
}


//administration menu
function ec_administration_callback() {
	include("demos.php");
}
function ec_admin_console_page_callback() {
	include("admin_console.php");
}
function ec_demos_callback() {
	include("demos.php");
}
function ec_users_guide_callback() {
	include("users_guide.php");
}

//store design menu
function ec_base_design_page_callback(){
	include("base_design.php");
}

// Admin per theme function is in wpeasycart.php

//store checklist menu
function ec_checklist_page_callback(){
	include("checklist.php");
}

//store v2 admin menu item
function ec_adminv2_page_callback( ){
	include( "admin_v2.php" );
}

function ec_mysqldump( $mysql_database ){	
	$return_string = "";
	$return_string .= "/*MySQL Dump File*/\n";
	$sql = "show tables;";
	$result = mysql_query($sql);
	if( $result ){
		while( $row = mysql_fetch_row( $result ) ){
			if( substr( $row[0], 0, 3 ) == "ec_" ){
				//$return_string .= ec_mysqldump_table_structure( $row[0] );
				$return_string .= ec_mysqldump_table_data( $row[0] );
			}
		}
	}else{
		$return_string .= "/* no tables in $mysql_database */\n";
	}
	mysql_free_result( $result );
	return $return_string;
}

function ec_mysqldump_table_structure( $table ){
	$return_string = "";
	$return_string .= "/* Table structure for table `$table` */\n";
	$return_string .= "DROP TABLE IF EXISTS `$table`;\n\n";
	$sql = "show create table `$table`; ";
	$result = mysql_query( $sql );
	if( $result ){
		if( $row = mysql_fetch_assoc( $result ) ){
			$return_string .= $row['Create Table'].";\n\n";
		}
	}
	mysql_free_result( $result );
	return $return_string;
}

function ec_mysqldump_table_data( $table ){
	$return_string = "";
	$sql = "select * from `$table`;";
	$result = mysql_query( $sql );
	if( $result ){
		$num_rows = mysql_num_rows( $result );
		$num_fields = mysql_num_fields( $result );
		if( $num_rows > 0 ){
			$return_string .= "/* dumping data for table `$table` */\n";
			$field_type = array( );
			$i = 0;
			while( $i < $num_fields ){
				$meta = mysql_fetch_field( $result, $i );
				array_push( $field_type, $meta->type );
				$i++;
			}
			$return_string .= "insert into `$table` values\n";
			$index = 0;
			while( $row = mysql_fetch_row( $result ) ){
				$return_string .= "(";
				for( $i = 0; $i < $num_fields; $i++ ){
					if( is_null( $row[$i] ) )
						$return_string .= "null";
					else{
						switch( $field_type[$i] ){
							case 'int':
								$return_string .= $row[$i];
								break;
							case 'string':
							case 'blob' :
							default:
								$return_string .= "'".mysql_real_escape_string($row[$i])."'";
						}
					}

					if( $i < $num_fields - 1 )
						$return_string .= ",";
				}
				$return_string .= ")";
				
				if( $index < $num_rows - 1 )
					$return_string .= ",";
				else
					$return_string .= ";";
				$return_string .= "\n";

				$index++;
			}
		}
	}
	mysql_free_result($result);
	$return_string .= "\n";
	return $return_string;
}

function ec_post_save_permalink_structure( $post_id ) {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function ec_post_save_match_store_meta( $post_id ) {
	//If we are matching post meta, lets do it here for store page only!
	$selected_store_id = get_option( 'ec_option_storepage' );
	$using_meta_match = get_option( 'ec_option_match_store_meta' );
	if( $using_meta_match && $selected_store_id == $post_id ){
		//Get the store page meta
		$store_meta = get_post_meta( $post_id );
		//Get the posts for the store
		$args = array( 'post_type' => 'ec_store' );
		$my_query = new WP_Query( $args );
		foreach( $my_query->posts as $post ){
			//Get the post meta for deletion if needed
			$post_meta = get_post_meta( $post->ID );
			//Delete each meta for this post
			foreach( $post_meta as $key => $meta ){
				delete_post_meta( $post->ID, $key );
			}
			
			//Add each store meta to this post
			foreach( $store_meta as $key => $meta ){
				//We need to check if unseriablizable and deal with it accordingly
				$meta_arr = @unserialize( $meta[0] );
				if( $meta_arr !== false ){
					add_post_meta( $post->ID, $key, $meta_arr );
				}else{
					add_post_meta( $post->ID, $key, $meta[0] );
				}
			}
		}
	}
}


/***********************************************************************************
* BEGIN FUNCTIONS FOR THE SHORTCODE EDITOR
************************************************************************************/

/***********************************************************************************
* BASIC SHORTCODE EDITOR FUNCTIONS
************************************************************************************/
function ec_add_editor_buttons( ){
    add_filter( "mce_external_plugins", "ec_add_buttons" );
    add_filter( 'mce_buttons', 'ec_register_buttons' );
}
function ec_add_buttons( $plugin_array ) {
    $plugin_array['wpeasycart'] = plugins_url() . '/wp-easycart/inc/admin/assets/js/editor.js';
    return $plugin_array;
}
function ec_register_buttons( $buttons ) {
    array_push( $buttons, 'ec_show_editor' );
    return $buttons;
}

function ec_print_editor( ){
	echo "<div class=\"ec_editor_box_container\" id=\"ec_editor_window\">";
	echo "<a href=\"#\" class=\"ec_editor_close\" onclick=\"return ec_close_editor( );\"><span>x</span></a>";
	echo "<h3 class=\"ec_editor_heading\">Insert EasyCart Shortcodes</h3>";
	echo "<div class=\"ec_editor_inner_container\">";
	// Start Container Inner
	ec_print_editor_shortcode_menu( ); // Shortcode Menu
	// Store shortcode, no options, nothing needed
	ec_print_editor_product_menu( );// Product Menu Store Shortcode Panel
	ec_print_editor_product_category( );// Product Category Store Shortcode Panel
	ec_print_editor_manufacturer_group( );// Manufacturer Group Store Shortcode Panel
	ec_print_editor_product_details( );// Product Details Store Shortcode Panel
	// Cart shortcode, no options, nothing needed
	// Account shortcode, no options, nothing needed
	ec_print_editor_single_product( );// Single Product Shortcode Panel
	ec_print_editor_multiple_products( );// Multiple Products Shortcode Panel
	ec_print_editor_add_to_cart( );// Add to Cart Shortcode Panel
	// Cart Display shortcode, no options, nothing needed
	ec_print_editor_membership_content( );// Add to Cart Shortcode Panel
	// End Container Inner
	echo "</div>";
	echo "</div>";
	echo "<div class=\"ec_editor_overlay\" id=\"ec_editor_bg\"></div>";
}

// Shortcode Menu
function ec_print_editor_shortcode_menu( ){
	echo "<ul class=\"ec_column_holder\" id=\"ec_shortcode_menu\">";
		echo "<li data-ecshortcode=\"ec_store\"><div>STORE</div></li>";
		echo "<li data-ecshortcode=\"ec_menu\"><div>PRODUCT MENU</div></li>";
		echo "<li data-ecshortcode=\"ec_category\"><div>PRODUCT CATEGORY</div></li>";
		echo "<li data-ecshortcode=\"ec_manufacturer\"><div>MANUFACTURER GROUP</div></li>";
		echo "<li data-ecshortcode=\"ec_productdetails\"><div>PRODUCT DETAILS</div></li>";
		echo "<li data-ecshortcode=\"ec_cart\"><div>CART</div></li>";
		echo "<li data-ecshortcode=\"ec_account\"><div>ACCOUNT</div></li>";
		echo "<li data-ecshortcode=\"ec_singleitem\"><div>SINGLE ITEM</div></li>";
		echo "<li data-ecshortcode=\"ec_selecteditems\"><div>SELECT ITEMS</div></li>";
		echo "<li data-ecshortcode=\"ec_addtocart\"><div>ADD TO CART BUTTON</div></li>";
		echo "<li data-ecshortcode=\"ec_cartdisplay\"><div>CART DISPLAY</div></li>";
		echo "<li data-ecshortcode=\"ec_membership\"><div>MEMBERSHIP CONTENT</div></li>";
	echo "</ul>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE PRODUCT MENU PANEL
************************************************************************************/
// Product Menu Shortcode Creator Panel
function ec_print_editor_product_menu( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_product_menu\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_product_menu_error\"><span>Please select a menu item at the minimum</span></div>";
		echo "<div class=\"ec_editor_help_text\">To display a product menu item page, select a menu item below. If you want to display a sub menu or a subsub menu, then select the menu, followed by the submenu and/or the subsubmenu.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Menu:</span><span id=\"ec_editor_menu_holder\" class=\"ec_editor_select_row_input\">";
		ec_print_menu_select( 'ec_editor_menu_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Sub Menu:</span><span id=\"ec_editor_submenu_holder\" class=\"ec_editor_select_row_input\">";
		ec_print_submenu_select( 'ec_editor_submenu_select', 0 );
		echo "</span></div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">SubSub Menu:</span><span id=\"ec_editor_subsubmenu_holder\" class=\"ec_editor_select_row_input\">";
		ec_print_subsubmenu_select( 'ec_editor_subsubmenu_select', 0 );
		echo "</span></div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_product_menu\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_menu_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\" onchange=\"ec_editor_select_menu_change( );\">";
	$db = new ec_db( );
	$menu_items = $db->get_menulevel1_items( );
	if( count( $menu_items ) > 0 ){
		echo "<option value=\"0\">Select a Menu Item</option>";
		foreach( $menu_items as $menu ){
			echo "<option value=\"" . $menu->menulevel1_id . "\">" . $menu->menu1_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Menu Items Exist</option>";
	}
	echo "</select>";
}

// Print all sub menu items for a particular menu item in a select box
function ec_print_submenu_select( $id, $menuid ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\" onchange=\"ec_editor_select_submenu_change( );\">";
	if( $menuid > 0 ){
		$db = new ec_db( );
		$menu_items = $db->get_menulevel2_items( );
		if( count( $menu_items ) > 0 ){
			echo "<option value=\"0\">Select a Menu Item (optional)</option>";
			foreach( $menu_items as $menu ){
				if( $menu->menulevel1_id == $menuid ){
					echo "<option value=\"" . $menu->menulevel2_id . "\">" . $menu->menu2_name . "</option>";
				}
			}
		}else{
			echo "<option value=\"0\">No SubMenu Items Exist</option>";
		}
	}else{
		echo "<option value=\"0\">No Menu Item Selected</option>";
	}
	echo "</select>";
}

// Print all sub menu items for a particular menu item in a select box
function ec_print_subsubmenu_select( $id, $submenuid ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	if( $submenuid > 0 ){
		$db = new ec_db( );
		$menu_items = $db->get_menulevel3_items( );
		if( count( $menu_items ) > 0 ){
			echo "<option value=\"0\">Select a SubSub Menu Item (optional)</option>";
			foreach( $menu_items as $menu ){
				if( $menu->menulevel2_id == $submenuid ){
					echo "<option value=\"" . $menu->menulevel3_id . "\">" . $menu->menu3_name . "</option>";
				}
			}
		}else{
			echo "<option value=\"0\">No SubSubMenu Items Exist</option>";
		}
	}else{
		echo "<option value=\"0\">No Sub Menu Item Selected</option>";
	}
	echo "</select>";
}

// Ajax calls
function ec_editor_update_sub_menu( ){
	$id = $_POST['id'];
	$menuid = $_POST['menuid'];
	
	ec_print_submenu_select( $id, $menuid );
	die( );
}

function ec_editor_update_subsub_menu( ){
	$id = $_POST['id'];
	$submenuid = $_POST['submenuid'];
	
	ec_print_subsubmenu_select( $id, $submenuid );
	die( );
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE PRODUCT CATEGORY PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_product_category( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_product_category\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_product_category_error\"><span>Please select a category item</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a category group which can be created in the store admin in the submenu of the products section.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Category:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_category_select( 'ec_editor_category_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_product_category\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_category_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$category_items = $db->get_category_list( );
	if( count( $category_items ) > 0 ){
		echo "<option value=\"0\">Select a Category Item</option>";
		foreach( $category_items as $category ){
			echo "<option value=\"" . $category->category_id . "\">" . $category->category_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Category Items Exist</option>";
	}
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE MANUFACTURER GROUP PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_manufacturer_group( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_manufacturer_group\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_manufacturer_group_error\"><span>Please select a manufacturer</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a manufacturer group, which consists of all products assigned to the selected manufacturer (think of it as a product filter by manufacturer).</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Manufacturer:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_manufacturer_select( 'ec_editor_manufacturer_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_manufacturer_group\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_manufacturer_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$manufacturers = $db->get_manufacturer_list( );
	if( count( $manufacturers ) > 0 ){
		echo "<option value=\"0\">Select a Manufacturer</option>";
		foreach( $manufacturers as $manufacturer ){
			echo "<option value=\"" . $manufacturer->manufacturer_id . "\">" . $manufacturer->name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Manufacturers Exist</option>";
	}
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE PRODUCT DETAILS PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_product_details( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_productdetails_menu\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_productdetails_error\"><span>Please Select a Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a single product's details on the specified page.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Product:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_productdetails_select( 'ec_editor_productdetails_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_productdetails\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}



// Print all main menu items in a select box
function ec_print_productdetails_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$products = $db->get_product_list( "", " ORDER BY product.title", "", "" );
	if( count( $products ) > 0 ){
		echo "<option value=\"0\">Select a Product</option>";
		for( $i=0; $i<count( $products ); $i++ ){
			echo "<option value=\"" . $products[$i]['model_number'] . "\">" . $products[$i]['title'] . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Products Exist</option>";
	}
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE SINGLE PRODUCT PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_single_product( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_single_product\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_single_product_error\"><span>Please Select a Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a single product with a view details button.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Product:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_select( 'ec_editor_single_product_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Display Type:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_display_type_select( 'ec_editor_single_product_display_type' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_single_product\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_product_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$products = $db->get_product_list( "", " ORDER BY product.title", "", "" );
	if( count( $products ) > 0 ){
		echo "<option value=\"0\">Select a Product</option>";
		for( $i=0; $i<count( $products ); $i++ ){
			echo "<option value=\"" . $products[$i]['product_id'] . "\">" . $products[$i]['title'] . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Products Exist</option>";
	}
	echo "</select>";
}

// Print the display types available for the product display
function ec_print_product_display_type_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		echo "<option value=\"1\" selected=\"selected\">Same as Store Product Display</option>";
		echo "<option value=\"2\">Same as Product Widget Display</option>";
		echo "<option value=\"3\">Custom Display Type 1</option>";
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE MULTIPLE PRODUCTS PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_multiple_products( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_multiple_products\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_multiple_products_error\"><span>Please Select at Least One Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays multiple products that can be selected one at a time. Each is displayed with a view details button.</div>";
		echo "<div class=\"ec_editor_multiple_select_row\"><span class=\"ec_editor_select_row_label\">Product:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_multiple_select( 'ec_editor_multiple_products_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Display Type:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_display_type_select( 'ec_editor_multiple_products_display_type' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Columns:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_columns_select( 'ec_editor_multiple_products_columns' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_multiple_products\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_product_multiple_select( $id ){
	echo "<select multiple=\"multiple\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$products = $db->get_product_list( "", " ORDER BY product.title", "", "" );
	if( count( $products ) > 0 ){
		for( $i=0; $i<count( $products ); $i++ ){
			echo "<option value=\"" . $products[$i]['product_id'] . "\">" . $products[$i]['title'] . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Products Exist</option>";
	}
	echo "</select>";
}

function ec_print_product_columns_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		echo "<option value=\"1\">1</option>";
		echo "<option value=\"2\">2</option>";
		echo "<option value=\"3\" selected=\"selected\">3</option>";
		echo "<option value=\"4\">4</option>";
		echo "<option value=\"5\">5</option>";
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE ADD TO CART PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_add_to_cart( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_add_to_cart\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_add_to_cart_error\"><span>Please Select a Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays an add to cart button (with options if attached) of a single product.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Product:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_select( 'ec_editor_add_to_cart_product_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_add_to_cart\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}
// Reusing the print product select option

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE MEMBERSHIP CONTENT PANEL
************************************************************************************/
// Membership Content Creator Panel
function ec_print_editor_membership_content( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_membership_menu\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_membership_error\"><span>Please Select at Least One Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode allows you to require a user to be subscribed to a product or one product in a group of products. For example, you could create a single content page that has a bronze, silver, and gold membership level with content for all three, just silver and gold, and just gold. In addition, it gives you an alternate content area</div>";
		echo "<div class=\"ec_editor_multiple_select_row\"><span class=\"ec_editor_select_row_label\">Product(s):</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_multiple_select( 'ec_editor_membership_multiple_product_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_membership\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}


?>