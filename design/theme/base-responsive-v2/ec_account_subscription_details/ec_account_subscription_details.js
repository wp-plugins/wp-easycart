function show_billing_info( ){
	jQuery( '#ec_account_subscription_billing_information' ).fadeIn( );
	jQuery( '#ec_account_subscription_payment' ).fadeIn( );
	return false;
}

function ec_cancel_subscription_check( confirm_text ){
	return confirm( confirm_text );
}