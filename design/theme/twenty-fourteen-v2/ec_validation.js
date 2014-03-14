// JavaScript Document
// This function emulates a class design. Input is the validation to do, an input for validation, and an optional country code (making this validation expandable).
function ec_validation( function_name, input, country_code ){
	
	if( function_name == "validate_first_name" ){
		if( input.length > 0)
			return true;
		else
			return false;
		
	}else if( function_name == "validate_last_name" ){
		if( input.length > 0)
			return true;
		else
			return false;
			
	}else if( function_name == "validate_address" ){
		if( country_code == "US" ){
			//Validate the address of a US address
			if( input.length > 0 )
				return true;	
			else
				return false;
				
		}else{
			//Validate the address for all other countries
			if( input.length > 0)
				return true;
			else
				return false;
				
		}
	}else if( function_name == "validate_city" ){
		if( country_code == "US" ){
			//Validate the city of a US address
			if( input.length > 0 )
				return true;	
			else
				return false;
				
		}else{
			//Validate the city for all other countries
			if( input.length > 0)
				return true;
			else
				return false;
				
		}
	}else if( function_name == "validate_state" ){
		var us_states = ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY', 'AS', 'GU', 'MP', 'PR', 'VI', 'UM', 'ALABAMA', 'ALASKA', 'ARIZONA', 'ARKANSAS', 'CALIFORNIA', 'COLORADO', 'CONNECTICUT', 'DELAWARE', 'DISTRICT OF COLUMBIA', 'D.C.', 'FLORIDA', 'GEORGIA', 'HAWAII', 'IDAHO', 'ILLINOIS', 'INDIANA', 'IOWA', 'KANSAS', 'KENTUCKY', 'LOUISIANA', 'MAINE', 'MARYLAND', 'MASSACHUSETTS', 'MICHIGAN', 'MINNESOTA', 'MISSISSIPPI', 'MISSOURI', 'MONTANA', 'NEBRASKA', 'NEVADA', 'NEW HAMPSHIRE', 'NEW JERSEY', 'NEW MEXICO', 'NEW YORK', 'NORTH CAROLINA', 'NORTH DAKOTA', 'OHIO', 'OKLAHOMA', 'OREGON', 'PENNSYLVANIA', 'RHODE ISLAND', 'SOUTH CAROLINA', 'SOUTH DAKOTA', 'TENNESSEE', 'TEXAS', 'UTAH', 'VERMONT', 'VIRGINIA', 'WASHINGTON', 'WEST VIRGINIA', 'WISCONSIN', 'WYOMING', 'AMERICAN SAMOA', 'GUAM', 'NORTH MARINANA ISLANDS', 'PUERTO RICO', 'VIRGIN ISLANDS']
		
		input = input.toUpperCase();
		
		if( country_code == "US" ){
			//Validate the state of a US address
			if( jQuery.inArray( input, us_states ) != -1 )
				return true;	
			else
				return false;
				
		}else{
			return true;
				
		}
	}else if( function_name == "validate_zip" ){
		if( country_code == "US" ){
			if( /(^\d{5}$)|(^\d{5}-\d{4}$)/.test( input ) )
				return true;
			else
				return false;
		}else{
			if( input.length > 0 )
				return true;
			else
				return false;	
		}
	}else if( function_name == "validate_country" ){
		if( input != 0 && input.length > 0)
			return true;	
		else
			return false;
	}else if( function_name == "validate_phone" ){
		if( country_code == "US" ){
			if( /^(?:\(\d{3}\)|\d{3})(?:\s|[-,.])?\d{3}(?:\s|[-,.])?\d{4}$/.test( input ) )
				return true;
			else
				return false;
		}else{
			if( input.length > 0 )
				return true;	
			else
				return false;
		}
	}else if( function_name == "validate_email" ){
		if( /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/.test( input ) )
			return true;
		else
			return false;
	}else if( function_name == "validate_password" ){
		if( input.length > 5 )
			return true;
		else
			return false;
	}else if( function_name == "validate_card_holder_name" ){
		if( country_code == "paypal" )
			return true;
		else if( input.length > 0 )
			return true;
		else
			return false;
	}else if( function_name == "validate_card_number" ){
		if( country_code == "paypal" )
			return true;
		else if( country_code == "visa" || country_code == "delta" || country_code == "uke" ){
			if( /^4[0-9]{12}(?:[0-9]{3}|[0-9]{6})?$/.test( input ) )
				return true;
			else
				return false;
		}else if( country_code == "discover" ){
			if( /^6(?:011|5[0-9]{2})[0-9]{12}$/.test( input ) )
				return true;
			else
				return false;
		}else if( country_code == "mastercard" || country_code == "mcdebit" ){
			if( /^5[1-5]\d{14}$/.test( input ) )
				return true;
			else
				return false;
		}else if( country_code == "amex" ){
			if( /^3[47][0-9]{13}$/.test( input ) )
				return true;
			else
				return false;
		}else if( country_code == "diners" ){
			if( /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/.test( input ) )
				return true;
			else
				return false;
		}else if( country_code == "jcb" ){
			if( /^1800\d{11}$|^3\d{15}$/.test( input ) )
				return true;
			else
				return false;
		}else if( country_code == "maestro" ){
			if( /(^(5[0678]\d{11,18}$))|(^(6[^0357])\d{11,18}$)|(^(3)\d{13,20}$)/.test( input ) )
				return true;
			else
				return false;	
		}
		
	}else if( function_name == "validate_expiration_month" ){
		if( country_code == "paypal" )
			return true;
		else if( !isNaN( input ) && input.length == 2 )
			return true;
		else
			return false;
			
	}else if( function_name == "validate_expiration_year" ){
		if( country_code == "paypal" )
			return true;
		else if( !isNaN( input ) && input.length == 4 )
			return true;
		else
			return false;
	}else if( function_name == "validate_security_code" ){
		if( country_code == "paypal" )
			return true;
		else if( /^[0-9]{3,4}$/.test( input ) )
			return true;
		else
			return false;
	}
}
	