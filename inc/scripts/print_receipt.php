<?php
	$order_id = $_GET['order_id'];
	$email = $_SESSION['ec_email'];
	$password = $_SESSION['ec_password'];
	
	$mysqli = new ec_db( );
	
	if( isset( $_SESSION['ec_is_guest'] ) && $_SESSION['ec_is_guest'] )
		$order = $mysqli->get_guest_order_row( $order_id, $_SESSION['ec_guest_key'] );
	
	else if( isset( $_GET['ec_guest_key'] ) && $_GET['ec_guest_key'] )
		$order = $mysqli->get_guest_order_row( $order_id, $_GET['ec_guest_key'] );
	
	else
		$order = $mysqli->get_order_row( $order_id, $email, $password );
	
	$bill_country = $mysqli->get_country_name( $order->billing_country );
	if( $bill_country )
		$order->billing_country = $bill_country;
	$ship_country = $mysqli->get_country_name( $order->shipping_country );
	if( $ship_country )
		$order->shipping_country = $ship_country;
	
	if( $order ){
		
		if( isset( $_SESSION['ec_is_guest'] ) && $_SESSION['ec_is_guest'] )
			$order_details = $mysqli->get_guest_order_details( $order_id, $_SESSION['ec_guest_key'] );
	
		else if( isset( $_GET['ec_guest_key'] ) && $_GET['ec_guest_key'] )
			$order_details = $mysqli->get_guest_order_details( $order_id, $_GET['ec_guest_key'] );
		
		else
			$order_details = $mysqli->get_order_details( $order_id, $email, $password );
		
		$country_list = $mysqli->get_countries( );
		
		$total = $GLOBALS['currency']->get_currency_display( $order->grand_total );
		$subtotal = $GLOBALS['currency']->get_currency_display( $order->sub_total );
		$tax = $GLOBALS['currency']->get_currency_display( $order->tax_total );
		if( $order->duty_total > 0 ){ $has_duty = true; }else{ $has_duty = false; }
		$duty = $GLOBALS['currency']->get_currency_display( $order->duty_total );
		$vat = $GLOBALS['currency']->get_currency_display( $order->vat_total );
		$shipping = $GLOBALS['currency']->get_currency_display( $order->shipping_total );
		$discount = $GLOBALS['currency']->get_currency_display( $order->discount_total );
		
		$vat_rate = 0;
		for( $i=0; $i<count($country_list); $i++ ){
			if( $order->shipping_country == $country_list[$i]->iso2_cnt )
				$vat_rate = $country_list[$i]->vat_rate_cnt;		
		}
		$vat_rate = number_format( $vat_rate, 0 );
		
		$email_logo_url = get_option( 'ec_option_email_logo' );
	
		// Get receipt
		if( $order->subscription_id ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_subscription_print_receipt.php' ) )
				include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_subscription_print_receipt.php';
			else if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_subscription_print_receipt.php' ) )
				include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_subscription_print_receipt.php';
		}else{
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_print_receipt.php' ) )
				include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_print_receipt.php';
			else
				include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_print_receipt.php';
		}
		
	}else{
		echo "No Order Found";	
	}
?>