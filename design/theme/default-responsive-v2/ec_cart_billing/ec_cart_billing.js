// Base Theme - EC Cart Billing Javascript Document

function ec_cart_billing_validate_input_update( input_name ){
	
	alert( input_name + " changed" );
	var country_code = document.getElementById('ec_cart_billing_country').value;
	var value = document.getElementById('ec_cart_billing_' + input_name).value;
	
	// validate billing
	if( !ec_validation( "validate_" + input_name, value, country_code ) ){
		document.getElementById('ec_cart_billing_' + input_name + '_row').className = "ec_cart_billing_row_error";
	}else{ 
		document.getElementById('ec_cart_billing_' + input_name + '_row').className = "ec_cart_billing_row";
	}	
}