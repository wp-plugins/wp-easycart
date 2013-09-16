// Base Theme - EC Cart Page Javascript Document
function ec_cart_validate_checkout_info( ){
	
	var country_code = document.getElementById('ec_cart_billing_country').value;
	var first_name = document.getElementById('ec_contact_first_name').value;
	var last_name = document.getElementById('ec_contact_last_name').value;
	
	var create_account = false;
	var email = document.getElementById('ec_contact_email').value;
	var retype_email = document.getElementById('ec_contact_email_retype').value;
		
	if( document.getElementById('ec_contact_create_account') && document.getElementById('ec_contact_create_account').checked ){
		create_account = true;
		var password = document.getElementById('ec_contact_password').value;
		var retype_password = document.getElementById('ec_contact_password_retype').value;
	}
	
	var shipping_selector = false;
	if( document.getElementById('ec_cart_use_shipping_for_shipping') && document.getElementById('ec_cart_use_shipping_for_shipping').checked )
		shipping_selector = true;
		 
	var errors = 0;
	
	var input_names = ['first_name', 'last_name', 'address', 'city', 'state', 'zip', 'country', 'phone'];
	
	for( var i=0; i< input_names.length; i++){
		if( input_names[i] == "state" && document.getElementById( 'ec_cart_billing_' + input_names[i] ).options ){
			var value = document.getElementById( 'ec_cart_billing_' + input_names[i] ).options[document.getElementById( 'ec_cart_billing_' + input_names[i] ).selectedIndex].value;
		}else{
			var value = document.getElementById( 'ec_cart_billing_' + input_names[i] ).value;
		}
		// validate billing
		if( !ec_validation( "validate_" + input_names[i], value, country_code ) ){
			errors++;
			document.getElementById('ec_cart_billing_' + input_names[i] + '_row').className = "ec_cart_billing_row_error";
		}else{
			document.getElementById('ec_cart_billing_' + input_names[i] + '_row').className = "ec_cart_billing_row";
		}
	}
	
	if( shipping_selector ){
		for( i=0; i < input_names.length; i++ ){
			if( input_names[i] == "state" && document.getElementById( 'ec_cart_shipping_' + input_names[i] ).options ){
				var value = document.getElementById( 'ec_cart_shipping_' + input_names[i] ).options[document.getElementById( 'ec_cart_shipping_' + input_names[i] ).selectedIndex].value;
			}else{
				var value = document.getElementById( 'ec_cart_shipping_' + input_names[i] ).value;
			}
			
			// validate shipping
			if( !ec_validation( "validate_" + input_names[i], value, country_code ) ){
				errors++;
				document.getElementById('ec_cart_shipping_' + input_names[i] + '_row').className = "ec_cart_shipping_row_error";
			}else{
				document.getElementById('ec_cart_shipping_' + input_names[i] + '_row').className = "ec_cart_shipping_row";
			}	
		}
	}
	
	if( !ec_validation( "validate_first_name", first_name, country_code ) ){
		errors++;
		document.getElementById('ec_contact_first_name_row').className = "ec_cart_contact_information_row_error";
	}else{
		document.getElementById('ec_contact_first_name_row').className = "ec_cart_contact_information_row";
	}
	
	if( !ec_validation( "validate_last_name", last_name, country_code ) ){
		errors++;
		document.getElementById('ec_contact_last_name_row').className = "ec_cart_contact_information_row_error";
	}else{
		document.getElementById('ec_contact_last_name_row').className = "ec_cart_contact_information_row";
	}
	
	if( !ec_validation( "validate_email", email, country_code ) ){
		errors++;
		document.getElementById('ec_contact_email_row').className = "ec_cart_contact_information_row_error";
	}else{
		document.getElementById('ec_contact_email_row').className = "ec_cart_contact_information_row";
	}
	
	if( retype_email.length == 0 || email != retype_email ){
		errors++;
		document.getElementById('ec_contact_email_retype_row').className = "ec_cart_contact_information_row_error";
	}else{
		document.getElementById('ec_contact_email_retype_row').className = "ec_cart_contact_information_row";
	}
	
	if( create_account ){
		
		
		
		if( !ec_validation( "validate_password", password, country_code ) ){
			errors++;
			document.getElementById('ec_contact_password_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_password_row').className = "ec_cart_contact_information_row";
		}
		
		if( retype_password.length == 0 || password != retype_password ){
			errors++;
			document.getElementById('ec_contact_password_retype_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_password_retype_row').className = "ec_cart_contact_information_row";
		}
		
	}
	
	
	
	if( errors )
		return false;
	else
		return true;
	
	
}

function ec_cart_validate_checkout_shipping( ){
	var errors = 0;
	
	if ( !jQuery( "input[name='ec_cart_shipping_method']:checked" ).val( ) ){
		errors++;
		jQuery( ".ec_cart_shipping_method_row" ).css("color", "#900");
	}else{
		jQuery( ".ec_cart_shipping_method_row" ).css("color", "#999");
	}
	
	if( errors )
		return false;
	else
		return true;
}

function ec_cart_validate_checkout_submit_order( ){
	var errors = 0;
	
	var payment_type = jQuery('input[name=ec_cart_payment_selection]:checked').val();
	if( !document.getElementById( 'ec_cart_pay_by_manual_payment' ) && !document.getElementById( 'ec_cart_pay_by_third_party' ) && !document.getElementById( 'ec_cart_pay_by_credit_card_holder' ) ){
		return true;
	}else if( payment_type ){
		jQuery('.ec_cart_payment_information_payment_type_row.error').removeClass('error');
		if( payment_type == "credit_card" ){
		
			var payment_method = document.getElementById('ec_cart_payment_type').value;
			var card_holder_name = document.getElementById('ec_card_holder_name').value;
			var card_number = document.getElementById('ec_card_number').value;
			var exp_month = document.getElementById('ec_expiration_month').value;
			var exp_year = document.getElementById('ec_expiration_year').value;
			var sec_code = document.getElementById('ec_security_code').value;
			
			if( payment_method == "0" ){
				errors++;
				document.getElementById('ec_cart_payment_type_row').className = "ec_cart_payment_information_row_error";
			}else{
				document.getElementById('ec_cart_payment_type_row').className = "ec_cart_payment_information_row";
			}
			
			if( !ec_validation( "validate_card_holder_name", card_holder_name, payment_method ) ){
				errors++;
				document.getElementById('ec_card_holder_name_row').className = "ec_cart_payment_information_row_error";
			}else{
				document.getElementById('ec_card_holder_name_row').className = "ec_cart_payment_information_row";
			}
			
			if( !ec_validation( "validate_card_number", card_number, payment_method ) ){
				errors++;
				document.getElementById('ec_card_number_row').className = "ec_cart_payment_information_row_error";
			}else{
				document.getElementById('ec_card_number_row').className = "ec_cart_payment_information_row";
			}
			
			if( !ec_validation( "validate_expiration_month", exp_month, payment_method ) || !ec_validation( "validate_expiration_year", exp_year, payment_method ) ){
				errors++;
				document.getElementById('ec_expiration_date_row').className = "ec_cart_payment_information_row_error";
			}else{
				document.getElementById('ec_expiration_date_row').className = "ec_cart_payment_information_row";
			}
			
			if( !ec_validation( "validate_security_code", sec_code, payment_method ) ){
				errors++;
				document.getElementById('ec_security_code_row').className = "ec_cart_payment_information_row_error";
			}else{
				document.getElementById('ec_security_code_row').className = "ec_cart_payment_information_row";
			}
		}
	}else{
		jQuery('.ec_cart_payment_information_payment_type_row').addClass('error');
		errors++;
	}
	
	if( errors )
		return false;
	else
		return true;
	
}

