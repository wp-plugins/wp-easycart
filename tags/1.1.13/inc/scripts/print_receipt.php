<?php
	//Load Wordpress Connection Data
	define('WP_USE_THEMES', false);
	require('../../../../../wp-load.php');
	
	//Get the variables from the AJAX call
	$order_id = $_GET['order_id'];
	$email = $_SESSION['ec_email'];
	$password = $_SESSION['ec_password'];
	
	$mysqli = new ec_db( );
	
	$order = $mysqli->get_order_row( $order_id, $email, $password );
	
	if( $order ){
		
		$order_details = $mysqli->get_order_details( $order_id, $email, $password );
	
		$total = number_format( $order->grand_total, 2, '.', ',' );
		$subtotal = number_format( $order->sub_total, 2, '.', ',' );
		$tax = number_format( $order->tax_total, 2, '.', ',' );
		$vat = number_format( $order->vat_total, 2, '.', ',' );
		$vat_rate = number_format( ( $vat / ( $total - $vat ) ) * 100, 0, '', '' );
		$shipping = number_format( $order->shipping_total, 2, '.', ',' );
		$discount = number_format( $order->discount_total, 2, '.', ',' );
	
		$email_logo_url = get_option( 'ec_option_email_logo' );
	
		// Get receipt
		include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_print_receipt.php';
	}else{
		echo "No Order Found";	
	}
?>