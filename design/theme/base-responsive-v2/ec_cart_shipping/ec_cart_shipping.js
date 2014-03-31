// Base Theme - EC Cart Shipping Javascript Document
function ec_cart_use_billing_for_shipping_change(){
	jQuery('.ec_cart_shipping_holder').fadeOut(400);
}

function ec_cart_use_shipping_for_shipping_change(){
	jQuery('.ec_cart_shipping_holder').fadeIn(400);
}

jQuery( document ).ready( function( ){
	jQuery( '#ec_cart_shipping_country' ).change( function( ){
		var country = jQuery( '#ec_cart_shipping_country' ).val( );
		if( document.getElementById( 'ec_cart_shipping_state_' + country ) ){
			jQuery( '.ec_cart_shipping_input_text.ec_shipping_state_dropdown' ).hide( );
			jQuery( '#ec_cart_shipping_state' ).hide( );
			jQuery( '#ec_cart_shipping_state_' + country ).show( );
		}else{
			jQuery( '.ec_cart_shipping_input_text.ec_shipping_state_dropdown' ).hide( );
			jQuery( '#ec_cart_shipping_state' ).show( );
		}
	} );
} );