// Base Theme - EC Cart Contact Information Javascript Document
function ec_contact_create_account_change( ){
	if( document.getElementById('ec_contact_create_account').checked == true )
		jQuery( '#ec_cart_password_input').fadeIn(150);
	else
		jQuery( '#ec_cart_password_input').fadeOut(150);	
}