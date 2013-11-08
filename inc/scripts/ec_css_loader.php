<?php
// First of all send css header
header("Content-type: text/css");

//Load Wordpress Connection Data
define('WP_USE_THEMES', false);
require('../../../../../wp-load.php');


$ec_store_css = array(
	'product',
	'product_filter_bar',
	'product_menu_filter',
	'product_page',
	'product_details_page',
	'customer_review',
	'featured_product',
	'gift_card_input'
);

$ec_cart_css = array(
	'cart_page',
	'cart',
	'cart_item',
	'cart_login',
	'cart_billing',
	'cart_shipping',
	'cart_shipping_method',
	'cart_coupon',
	'cart_gift_card',
	'cart_continue_to_payment',
	'cart_address_review',
	'cart_payment_information',
	'cart_contact_information',
	'cart_submit_order',
	'cart_success',
	'cart_third_party'
);

$ec_account_css = array(
	'account_billing_information',
	'account_dashboard',
	'account_login',
	'account_order_details',
	'account_orders',
	'account_page',
	'account_password',
	'account_personal_information',
	'account_shipping_information',
	'account_forgot_password',
	'account_register',
	'account_order_line',
	'account_order_details_item_display'
);

$ec_widget_css = array(
	'menu_horizontal_widget',
	'menu_vertical_widget',
	'category_widget',
	'cart_widget',
	'group_widget',
	'manufacturer_widget',
	'newsletter_widget',
	'price_widget',
	'product_widget',
	'search_widget',
	'specials_widget',
);

$css_content = "";

foreach ($ec_store_css as $css_file ){
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' ) )
		$css_content .= file_get_contents( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
	else
		$css_content .= file_get_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
}

foreach ($ec_cart_css as $css_file ){
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' ) )
		$css_content .= file_get_contents( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
	else
		$css_content .= file_get_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
}

foreach ($ec_account_css as $css_file ){ 
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' ) )
		$css_content .= file_get_contents( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
	else
		$css_content .= file_get_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
}

foreach ($ec_widget_css as $css_file ){
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' ) )
		$css_content .= file_get_contents( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
	else
		$css_content .= file_get_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec_' . $css_file . '/ec_' . $css_file . '.css' );
}

if( get_option( 'ec_option_use_rtl' ) && file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_base_theme' ) . '/rtl_support.css' ) )
	$css_content .= file_get_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_base_theme' ) . '/rtl_support.css' );

// Theme css replacement
$replacements_string = get_option( 'ec_option_css_replacements' );
$replacements_rows = explode( ",", $replacements_string );

foreach( $replacements_rows as $replacement_row ){
	$temp = explode( "=", $replacement_row );
	if( count( $temp ) == 2 )
		$css_content = str_replace( "[" . $temp[0] . "]", $temp[1], $css_content );
}

$font_families = get_option( 'ec_option_font_replacements' );
$font_rows = explode( ":::", $font_families );

foreach( $font_rows as $font_row ){
	$temp = explode( "=", $font_row );
	if( count( $temp ) == 2 )
		$css_content = str_replace( "[" . $temp[0] . "]", $temp[1], $css_content );
}

$screen_sizes = get_option( 'ec_option_responsive_sizes' );
$size_rows = explode( ":::", $screen_sizes );

foreach( $size_rows as $size_row ){
	$temp = explode( "=", $size_row );
	if( count( $temp ) == 2 )
		$css_content = str_replace( "[" . $temp[0] . "]", $temp[1], $css_content );
}

// print the css content
echo $css_content;	
?>
