<?php
ini_set( 'log_errors', true );
ini_set( 'error_log', dirname( __FILE__ ).'/paypal_log.txt' );

//Load Wordpress Connection Data
define( 'WP_USE_THEMES', false );
require( '../../../../../wp-load.php' );

$mysqli = new ec_db( );
$listener = new ec_ipnlistener( );

if( get_option( 'ec_option_paypal_use_sandbox' ) )
$listener->use_sandbox = true;

try{
	$listener->requirePostMethod( );
	$verified = $listener->processIpn( );
}catch( Exception $e ){
	error_log( $e->getMessage( ) );
	exit( 0 );
}

if( $verified ) {

    $errmsg = '';
    

    if( $_POST['receiver_email'] != get_option( 'ec_option_paypal_email' ) ) {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }
	
    if( $_POST['mc_currency'] != get_option( 'ec_option_paypal_currency_code' ) ) {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $_POST['mc_currency']."\n";
    }
	
	
	$order_id = $_POST['custom'];
	
	// IF WE GET AN ERROR, THEN RESPONSE HAS ALREADY BEEN HANDLED!!
	$is_error = $mysqli->get_response_from_order_id( $order_id );
	
	if( $is_error ){
        $errmsg .= "'txn_id' is being processed twice: ";
        $errmsg .= $_POST['txn_id']."\n";
    }
		
    if( !empty( $errmsg ) ){
        $body = "IPN failed fraud checks: \n";
        $body .= $listener->getTextReport();
       	error_log( $body );
    
	}else{
		$receiver_email = $_POST['receiver_email'];
		$receiver_id = $_POST['receiver_id'];
		$residence_country = $_POST['residence_country'];
		$test_ipn = $_POST['test_ipn'];
		$transaction_subject = $_POST['transaction_subject'];
		$txn_id = $_POST['txn_id'];
		$txn_type = $_POST['txn_type'];
		$payer_email = $_POST['payer_email'];
		$payer_id = $_POST['payer_id'];
		$payer_status = $_POST['payer_status'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$address_city = $_POST['address_city'];
		$address_country = $_POST['address_country'];
		$address_country_code = $_POST['address_country_code'];
		$address_name = $_POST['address_name'];
		$address_state = $_POST['address_state'];
		$address_status = $_POST['address_status'];
		$address_street = $_POST['address_street'];
		$address_zip = $_POST['address_zip'];
		$custom = $_POST['custom'];
		$handling_amount = $_POST['handling_amount'];
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$mc_currency = $_POST['mc_currency'];
		$mc_fee = $_POST['mc_fee'];
		$mc_gross = $_POST['mc_gross'];
		$payment_date = $_POST['payment_date'];
		$payment_fee = $_POST['payment_fee'];
		$payment_gross = $_POST['payment_gross'];
		$payment_status = $_POST['payment_status'];
		$payment_type = $_POST['payment_type'];
		$protection_eligibility = $_POST['protection_eligibility'];
		$quantity = $_POST['quantity'];
		$shipping = $_POST['shipping'];
		$tax = $_POST['tax'];
		$notify_version = $_POST['notify_version'];
		$charset = $_POST['charset'];
		$verify_sign = $_POST['verify_sign'];
		
		$paypal_response_string = 	"order_id = " . $order_id . 
									"; receiver_email = " . $receiver_email . 
									"; receiver_id = " . $receiver_id . 
									"; residence_country = " . $residence_country . 
									"; test_ipn = " . $test_ipn . 
									"; transaction_subject = " . $transaction_subject . 
									"; txn_id =  = " . $txn_id . 
									"; txn_type =  = " . $txn_type . 
									"; payer_email = " . $payer_email . 
									"; payer_id = " . $payer_id . 
									"; payer_status = " . $payer_status . 
									"; first_name = " . $first_name . 
									"; last_name = " . $last_name . 
									"; address_city = " . $address_city . 
									"; address_country = " .  $address_country . 
									"; address_country_code = " .  $address_country_code . 
									"; address_name = " .  $address_name . 
									"; address_state = " .  $address_state . 
									"; address_status = " .  $address_status . 
									"; address_street = " .  $address_street . 
									"; address_zip = " .  $address_zip . 
									"; custom = " .  $custom . 
									"; handling_amount = " . $handling_amount . 
									"; item_name = " . $item_name . 
									"; item_number = " . $item_number . 
									"; mc_currency = " . $mc_currency . 
									"; mc_fee = " . $mc_fee . 
									"; mc_gross = " . $mc_gross . 
									"; payment_date = " . $payment_date . 
									"; payment_fee = " . $payment_fee . 
									"; payment_gross = " . $payment_gross . 
									"; payment_status = " . $payment_status . 
									"; payment_type = " . $payment_type . 
									"; protection_eligibility = " . $protection_eligibility . 
									"; quantity = " . $quantity . 
									"; shipping = " . $shipping . 
									"; tax = " . $tax . 
									"; notify_version = " . $notify_version . 
									"; charset = " . $charset . 
									"; verify_sign = " . $verify_sign;
		
		$mysqli->insert_response( $order_id, 0, "PayPal", $paypal_response_string );
		
		if( $_POST['payment_status'] == 'Completed' ){ 
			
			$mysqli->update_order_status( $order_id, "10" );
			
			// send email
			$order_row = $mysqli->get_order_row( $order_id, "guest", "guest" );
			$order_display = new ec_orderdisplay( $order_row, true );
			$order_display->send_email_receipt( );

			// Quickbooks Hook
			if( file_exists( WP_PLUGIN_DIR . "/" . EC_QB_PLUGIN_DIRECTORY . "/ec_quickbooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->add_order( $order_id );
			}
			
		} else if( $_POST['payment_status'] == 'Refunded' ){ 
			$mysqli->update_order_status( $order_id, "16" );
		} else {
			$mysqli->update_order_status( $order_id, "8" );
		}
		
    }
    
}	
?>