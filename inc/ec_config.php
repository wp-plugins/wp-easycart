<?php
// Some servers do not set session path to a writable location. Fix this sometimes.
if( strtoupper(substr(PHP_OS, 0, 3)) != 'WIN' && !is_writable( session_save_path( ) ) ){ // Linux
	ini_set( 'session.save_path', '/tmp' );

}else if( !is_writable( session_save_path( ) ) ){ // Windows
	ini_set( 'session.save_path', 'c:/temp' );
}

// Start the session
session_start();

// If register globals is on we need to do some custom work to fix session problems
if( ini_get( 'register_globals' ) ){
    foreach( $_SESSION as $key=>$value ){
        if( isset( $GLOBALS[$key] ) )
            unset( $GLOBALS[$key] );
    }
}
	
// Language Translation Check
if( isset( $_POST['ec_language_conversion'] ) ){
	$_SESSION['ec_translate_to'] = $_POST['ec_language_conversion'];
}
	
// Currency Conversion Check
if( isset( $_POST['ec_currency_conversion'] ) ){
	$_SESSION['ec_convert_to'] = $_POST['ec_currency_conversion'];
}

// LIVE GATEWAY CLASSES
if( get_option( 'ec_option_payment_process_method' ) != '0' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_gateway.php' );
}

if( get_option( 'ec_option_payment_process_method' ) == 'authorize' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_authorize.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'braintree' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_braintree.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'chronopay' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_chronopay.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'eway' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_eway.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'firstdata' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_firstdata.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'goemerchant' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_goemerchant.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'moneris_ca' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_moneris_ca.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'paymentexpress' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paymentexpress.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'paypal_payments_pro' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypal_payments_pro.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'paypal_pro' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypal_pro.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'paypoint' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypoint.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'realex' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_realex.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'sagepay' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_sagepay.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'sagepayus' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_sagepayus.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'securepay' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_securepay.php' );
}else if( get_option( 'ec_option_payment_process_method' ) == 'stripe' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_stripe.php' );
}

// THIRD PARTY GATEWAYS
if( get_option( 'ec_option_payment_third_party' ) != '0' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_third_party.php' );
}

if( get_option( 'ec_option_payment_third_party' ) == 'dwolla_thirdparty' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_dwolla_thirdparty.php' );
}else if( get_option( 'ec_option_payment_third_party' ) == 'paymentexpress_thirdparty' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paymentexpress_thirdparty.php' );
}else if( get_option( 'ec_option_payment_third_party' ) == 'paypal' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypal.php' );
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_ipnlistener.php' );
}else if( get_option( 'ec_option_payment_third_party' ) == 'nets' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_nets.php' );
}else if( get_option( 'ec_option_payment_third_party' ) == 'realex_thirdparty' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_realex_thirdparty.php' );
}else if( get_option( 'ec_option_payment_third_party' ) == 'skrill' ){
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_skrill.php' );
}

// INCLUDE SHIPPER CLASSES
$use_auspost = false; $use_dhl = false; $use_fedex = false; $use_ups = false; $use_usps = false;
global $wpdb;
$rates = $wpdb->get_results( "SELECT shippingrate_id, is_ups_based, is_usps_based, is_fedex_based, is_auspost_based, is_dhl_based FROM ec_shippingrate" );
$shipping_method = $wpdb->get_var( "SELECT shipping_method FROM ec_setting WHERE setting_id = 1" );

foreach( $rates as $rate ){
	if( $rate->is_auspost_based )
		$use_auspost = true;
	else if( $rate->is_dhl_based )
		$use_dhl = true;
	else if( $rate->is_fedex_based )
		$use_fedex = true;
	else if( $rate->is_ups_based )
		$use_ups = true;
	else if( $rate->is_usps_based )
		$use_usps = true;
}

if( $shipping_method == 'live' && $use_auspost )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_auspost.php' );
if( $shipping_method == 'live' && $use_dhl )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_dhl.php' );
if( $shipping_method == 'live' && $use_fedex )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_fedex.php' );
if( $shipping_method == 'fraktjakt' )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_fraktjakt.php' );
if( $shipping_method == 'live' )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_shipper.php' );
if( $shipping_method == 'live' && $use_ups )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_ups.php' );
if( $shipping_method == 'live' && $use_usps )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_usps.php' );

// INCLUDE CORE CLASSES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_address.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_credit_card.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_currency.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_googleanalytics.php' ); 
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_db.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_db_admin.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_discount.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_language.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_license.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_manufacturer.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_menu.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_menuitem.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_optionimage.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_optionitem.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_optionset.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_order.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_order_totals.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_payment.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_product.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_productlist.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_promotion.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_promotion_item.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_rating.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_review.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_scriptaction.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_selectedoptions.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_setting.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_shipping.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_subscription.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_tax.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_user.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_validation.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_wpoption.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_wpoptionset.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/ec_wpstyle.php' );

// INCLUDE ACCOUNT CLASSES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/account/ec_accountpage.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/account/ec_orderdetail.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/account/ec_orderdisplay.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/account/ec_orderlist.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/account/ec_subscription_list.php' );

// INCLUDE CART CLASSES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/cart/ec_cart.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/cart/ec_cartitem.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/cart/ec_cartpage.php' );

// INCLUDE STORE CLASSES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_featuredproducts.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_filter.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_giftcard.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_paging.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_perpage.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_prodimages.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_prodimageset.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_prodmenu.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_prodoptions.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_prodprice.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_social_media.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/store/ec_storepage.php' );

//INCLUDE WIDGET CLASSES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_breadcrumbwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_cartwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_categorywidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_currencywidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_donationwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_groupwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_languagewidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_manufacturerwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_menuwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_newsletterwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_pricepointwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_productwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_searchwidget.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/widget/ec_specialswidget.php' );

//ADMIN HOOK INCLUDES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/admin_init.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/admin/admin_ajax_functions.php' );

$GLOBALS['language'] = new ec_language( );
$GLOBALS['currency'] = new ec_currency( );
if( get_option( 'ec_option_is_installed' ) )
$GLOBALS['setting'] = new ec_setting( );

?>