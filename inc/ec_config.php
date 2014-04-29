<?php
// Level Four Storefront Configuration File

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

// INCLUDE GATEWAY CLASSES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_gateway.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_third_party.php' );

include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_authorize.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_braintree.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_chronopay.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_eway.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_firstdata.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_goemerchant.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_ipnlistener.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_nets.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paymentexpress.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paymentexpress_thirdparty.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypal.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypal_payments_pro.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypal_pro.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_paypoint.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_psigate.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_realex.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_realex_thirdparty.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_sagepay.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_sagepayus.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_securepay.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_skrill.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/ec_stripe.php' );

// INCLUDE SHIPPER CLASSES
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_auspost.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_dhl.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_fedex.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_fraktjakt.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_shipper.php' );
include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/shipping/ec_ups.php' );
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