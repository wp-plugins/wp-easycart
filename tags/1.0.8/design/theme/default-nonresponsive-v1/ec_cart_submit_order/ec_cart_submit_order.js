// Base Theme - EC Cart Submit Order Javascript Document
function ec_cart_submit_order_click(){
	var has_errors = false;
	if( !ec_cart_payment_method_check( ) )			has_errors = true;
	if( !ec_cart_card_holder_name_check( ) ) 		has_errors = true;
	if( !ec_cart_card_number_check( ) ) 			has_errors = true;
	if( !ec_cart_expiration_month_check( ) ) 		has_errors = true;
	if( !ec_cart_expiration_year_check( ) ) 		has_errors = true;
	if( !ec_cart_security_code_check( ) ) 			has_errors = true;
	if( !ec_cart_email_check( ) ) 					has_errors = true;
	if( !ec_cart_email_retype_check( ) ) 			has_errors = true;
		
	return !has_errors;
}

function ec_cart_payment_method_check( ){
	if( document.getElementById('ec_payment_type').value != 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_payment_type') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_payment_type') );
		return false;
	}
}

function ec_cart_card_holder_name_check( ){
	if( document.getElementById('ec_card_holder_name').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_card_holder_name') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_card_holder_name') );
		return false;
	}
}

function ec_cart_card_number_check( ){
	if( document.getElementById('ec_card_number').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_card_number') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_card_number') );
		return false;
	}
}

function ec_cart_expiration_month_check( ){
	if( document.getElementById('ec_expiration_month').value != 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_expiration_month') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_expiration_month') );
		return false;
	}
}

function ec_cart_expiration_year_check( ){
	if( document.getElementById('ec_expiration_year').value != 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_expiration_year') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_expiration_year') );
		return false;
	}
}

function ec_cart_security_code_check( ){
	if( document.getElementById('ec_security_code').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_security_code') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_security_code') );
		return false;
	}
}

function ec_cart_email_check( ){
	if( document.getElementById('ec_contact_email').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_contact_email') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_contact_email') );
		return false;
	}
}

function ec_cart_email_retype_check( ){
	if( document.getElementById('ec_contact_email_retype').value.length > 0 && document.getElementById('ec_contact_email').value.length == document.getElementById('ec_contact_email_retype').value.length ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_contact_email_retype') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_contact_email_retype') );
		return false;
	}
}

function ec_text_field_highlight_error( field ){
	field.style.backgroundColor = 'Yellow';
}

function ec_text_field_highlight_error_remove( field ){
	field.style.backgroundColor = 'White';
}
