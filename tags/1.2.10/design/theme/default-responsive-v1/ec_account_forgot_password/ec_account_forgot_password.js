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

// Base Theme - EC Account Forgot Password Javascript Document

function ec_account_forgot_password_button_click( ){
	var errors = 0;
	
	var email = document.getElementById( 'ec_account_forgot_password_email' ).value;
	
	if( !ec_validation( "validate_email", email, "US" ) ){
		errors++;
		document.getElementById('ec_account_forgot_password_email_row').className = "ec_account_forgot_password_row_error";
	}else{ 
		document.getElementById('ec_account_forgot_password_email_row').className = "ec_account_forgot_password_row";
	}
	
	if( errors > 0 )
		return false;
	else
		return true;
}
