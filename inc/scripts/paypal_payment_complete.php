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
    

    if( strtolower( $_POST['receiver_email'] ) != strtolower( get_option( 'ec_option_paypal_email' ) ) ) {
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
		
		$paypal_response_string = print_r( $_POST, true );
		
		$mysqli->insert_response( $order_id, 0, "PayPal", $paypal_response_string );
		
		if( $_POST['payment_status'] == 'Completed' ){ 
			
			if( $_POST['txn_type'] == "subscr_payment" ){
				
				if( $mysqli->has_subscription_inserted( $_POST['subscr_id'] ) ){
					
					// Update a subscription item
					$mysqli->update_paypal_subscription( $_POST['payment_date'], $_POST['subscr_id'] );
				
				}else{
					
					// Add a subscription item
					$mysqli->insert_paypal_subscription( $_POST['item_name'], $_POST['payer_email'], $_POST['first_name'], $_POST['last_name'], $_POST['residence_country'], $_POST['mc_gross'], $_POST['payment_date'], $_POST['txn_id'], $_POST['txn_type'], $_POST['subscr_id'], $_POST['username'], $_POST['password'] );
				
				}
				
			}else if(  $_POST['txn_type'] == "subscr_signup" ){
				
				// Not a lot of useful information is passed here. We won't do anything.
				
			}else if( $_POST['txn_type'] == "subscr_cancel" ){
				
				// Canel a subscription item
				$mysqli->cancel_paypal_subscription( $_POST['subscr_id'] );
				
			}else{
				$mysqli->update_order_status( $order_id, "10" );
				
				// send email
				$db_admin = new ec_db_admin( );
				$order_row = $db_admin->get_order_row_admin( $order_id );
				$order_display = new ec_orderdisplay( $order_row, true, true );
				$order_display->send_email_receipt( );
				$order_display->send_gift_cards( );
	
				// Quickbooks Hook
				if( file_exists( WP_PLUGIN_DIR . "/" . EC_QB_PLUGIN_DIRECTORY . "/ec_quickbooks.php" ) ){
					$quickbooks = new ec_quickbooks( );
					$quickbooks->add_order( $order_id );
				}
			}
			
		} else if( $_POST['payment_status'] == 'Refunded' ){ 
			$mysqli->update_order_status( $order_id, "16" );
			
			// Check for gift card to refund
			$order_details = $mysqli->get_results( $mysqli->prepare( "SELECT is_giftcard, giftcard_id FROM ec_orderdetail WHERE order_id = %d", $order_id ) );
			foreach( $order_details as $detail ){
				if( $detail->is_giftcard ){
					$mysqli->query( $mysqli->prepare( "DELETE FROM ec_giftcard WHERE ec_giftcard.giftcard_id = %s", $detail->giftcard_id ) );
				}
			}
			
		} else {
			$mysqli->update_order_status( $order_id, "8" );
		}
		
    }
    
}	
?>