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

// Base Theme - EC Account Register Javascript Document

function ec_account_register_button_click( ){
	var errors = 0;
	
	var first_name = document.getElementById('ec_account_register_first_name').value;
	var last_name = document.getElementById('ec_account_register_last_name').value;
	var email = document.getElementById('ec_account_register_email').value;
	var password = document.getElementById('ec_account_register_password').value;
	var retype_password = document.getElementById('ec_account_register_password_retype').value;
	
	if( !ec_validation( "validate_first_name", first_name, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_first_name_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_first_name_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_last_name", last_name, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_last_name_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_last_name_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_email", email, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_email_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_email_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_password", password, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_password_row').className = "ec_account_register_row_error";
		document.getElementById('ec_account_register_password_retype_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_password_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_password", password, "US" ) || password != retype_password ){
		errors++;
		document.getElementById('ec_account_register_password_retype_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_password_retype_row').className = "ec_account_register_row";
	}
	
	if( errors > 0 )
		return false;
	else
		return true;
	
}
