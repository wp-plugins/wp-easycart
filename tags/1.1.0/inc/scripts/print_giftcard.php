<?php
	
if( isset( $_GET['order_id'] ) && isset( $_GET['orderdetail_id'] ) && isset( $_GET['giftcard_id'] ) ){ 
	//Load Wordpress Connection Data
	define('WP_USE_THEMES', false);
	require('../../../../../wp-load.php');
	
	//Get the variables from the AJAX call
	$order_id = $_GET['order_id'];
	$orderdetail_id = $_GET['orderdetail_id'];
	$giftcard_id = $_GET['giftcard_id'];
	$email = $_SESSION['ec_email'];
	$password = $_SESSION['ec_password'];
	
	$mysqli = new ec_db( );
	
	$orderdetail_row = $mysqli->get_orderdetail_row( $order_id, $orderdetail_id, $email, $password );
	
	if( $orderdetail_row ){
		
		$ec_orderdetail = new ec_orderdetail( $orderdetail_row );
		
		$email_logo_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_cart_page_layout' ) . "/ec_cart_email_receipt/emaillogo.jpg");
		$email_footer_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_cart_page_layout' ) . "/ec_cart_email_receipt/emailfooter.jpg");
	
		// Get receipt
		include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_account_page_layout' ) . '/ec_account_print_gift_card.php';
	}else{
		echo "No Order Found";	
	}
}

?>