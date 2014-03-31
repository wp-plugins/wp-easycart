////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Base Theme - EC Account Billing Information Javascript Document

function ec_account_billing_information_update_click( ){
	var errors = 0;
	
	var country = document.getElementById('ec_account_billing_information_country').value;
	var first_name = document.getElementById('ec_account_billing_information_first_name').value;
	var last_name = document.getElementById('ec_account_billing_information_last_name').value;
	var address = document.getElementById('ec_account_billing_information_address').value;
	var city = document.getElementById('ec_account_billing_information_city').value;
	var state = document.getElementById('ec_account_billing_information_state').value;
	
	// Check for special drop down
	if( document.getElementById( 'ec_account_billing_information_state_' + country ) && document.getElementById( 'ec_account_billing_information_state_' + country ).options ){
		state = document.getElementById( 'ec_account_billing_information_state_' + country ).options[document.getElementById( 'ec_account_billing_information_state_' + country ).selectedIndex].value;
	}
	
	var zip = document.getElementById('ec_account_billing_information_zip').value;
	var phone = document.getElementById('ec_account_billing_information_phone').value;
	
	if( !ec_validation( "validate_first_name", first_name, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_first_name_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_first_name_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_last_name", last_name, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_last_name_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_last_name_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_address", address, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_address_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_address_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_city", city, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_city_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_city_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_state", state, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_state_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_state_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_zip", zip, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_zip_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_zip_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_country", country, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_country_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_country_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_phone", phone, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_phone_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_phone_row').className = "ec_account_billing_information_row";
	}
	
	
	if( errors > 0 )
		return false;
	else
		return true;
	
}

jQuery( document ).ready( function( ){
	jQuery( '#ec_account_billing_information_country' ).change( function( ){
		var country = jQuery( '#ec_account_billing_information_country' ).val( );
		if( document.getElementById( 'ec_account_billing_information_state_' + country ) ){
			jQuery( '.ec_account_billing_information_input_field.ec_billing_state_dropdown' ).hide( );
			jQuery( '#ec_account_billing_information_state' ).hide( );
			jQuery( '#ec_account_billing_information_state_' + country ).show( );
		}else{
			jQuery( '.ec_account_billing_information_input_field.ec_billing_state_dropdown' ).hide( );
			jQuery( '#ec_account_billing_information_state' ).show( );
		}
	} );
} );
