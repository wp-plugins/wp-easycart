<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_paypal_pro extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$paypal_pro_vendor = get_option( 'ec_option_paypal_pro_vendor' );
		$paypal_pro_partner = get_option( 'ec_option_paypal_pro_partner' );
		$paypal_pro_currency = get_option( 'ec_option_paypal_pro_currency' );
		$paypal_pro_user = get_option( 'ec_option_paypal_pro_user' );
		$paypal_pro_password = get_option( 'ec_option_paypal_pro_password' );
		
		$paypal_pro_data = array(	"VENDOR" 			=> $paypal_pro_vendor,
									"PARTNER" 			=> $paypal_pro_partner,
									"USER" 				=> $paypal_pro_user,
									"PWD" 				=> $paypal_pro_password,
									"VERBOSITY" 		=> "HIGH",
									"TENDER" 			=> "C",
									"TRXTYPE" 			=> "S",
									"ACCT" 				=> $this->credit_card->card_number,
									"EXPDATE" 			=> $this->credit_card->expiration_month . $this->credit_card->get_expiration_year( 2 ),
									"CVV2" 				=> $this->security_code,
									"CURRENCY" 			=> $paypal_pro_currency,
									"AMT" 				=> $this->order_totals->grand_total,
									"TAXAMT"			=> $this->order_totals->tax_total,
									"FREIGHTAMT" 		=> $this->order_totals->shipping_total,
									"DUTYAMT"			=> $this->order_totals->duty_total,
									"DISCOUNT" 			=> $this->order_totals->discount_total,
									"ORDERID" 			=> $this->order_id,
									"BILLTOFIRSTNAME" 	=> $this->user->billing->first_name,
									"BILLTOLASTNAME" 	=> $this->user->billing->last_name,
									"BILLTOSTREET" 		=> $this->user->billing->address_line_1,
									"BILLTOCITY" 		=> $this->user->billing->city,
									"BILLTOSTATE" 		=> $this->user->billing->state,
									"BILLTOZIP"			=> $this->user->billing->zip,
									"BILLTOCOUNTRY" 	=> $this->user->billing->country,
									"SHIPTOFIRSTNAME" 	=> $this->user->shipping->first_name,
									"SHIPTOLASTNAME"	=> $this->user->shipping->last_name,
									"SHIPTOSTREET" 		=> $this->user->shipping->address_line_1,
									"SHIPTOCITY" 		=> $this->user->shipping->city,
									"SHIPTOSTATE" 		=> $this->user->shipping->state,
									"SHIPTOZIP" 		=> $this->user->shipping->zip,
									"SHIPTOCOUNTRY" 	=> $this->user->shipping->country
					 );
					 
		if( $this->tax->vat_enabled ){
			$paypal_pro_data["VATREGNUM"] 				= "VATREGNUM";
			$paypal_pro_data["VATTAXAMT"] 				= $this->order_totals->vat_total;
			$paypal_pro_data["VATTAXPERCENT"] 			= $this->tax->vat_rate;
		}
		
		return $paypal_pro_data;
		
	}
	
	function get_gateway_url( ){
		
		$paypal_pro_use_sandbox = get_option( 'ec_option_paypal_pro_use_sandbox' );
		
		if( $paypal_pro_use_sandbox )
			return "https://pilot-payflowpro.paypal.com";
		else
			return "https://payflowpro.paypal.com";
	
	}
	
	function handle_gateway_response( $response ){
		
		$response_body = $response["body"];
		
		//Format response data in form key=val&key2=val2&...
		$response_array = explode( "&", $response_body );
		$response_vals = array();
		for( $i=0; $i<count($response_array); $i++){
			$split = explode( "=", $response_array[$i] );
			$response_vals[$split[0]] = $split[1]; 
		}
		
		$result_code = $response_vals["RESULT"];
		$response_message = $response_vals["RESPMSG"];
		
		$response_text = print_r( $response_vals, true );
		
		if( $result_code == 0 )
			$this->is_success = 1;
		else
			$this->is_success = 0;
			
		$this->mysqli->insert_response( $this->order_id, $this->temp_order_id, !$this->is_success, "PayPalPro", $response_text );
			
		if( !$this->is_success )
			$this->error_message = $response_message;
			
	}
	
}

?>