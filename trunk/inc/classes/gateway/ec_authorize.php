<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_authorize extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$authorize_login_id 		= 		get_option( 'ec_option_authorize_login_id' );
		$authorize_trans_key 		= 		get_option( 'ec_option_authorize_trans_key' );
		$authorize_test_mode 		= 		get_option( 'ec_option_authorize_test_mode' );
		$authorize_currency_code 	= 		get_option( 'ec_optin_authorize_currency_code' );
		
		$transaction_type = "AUTH_CAPTURE";
		$expiration_date = $this->credit_card->expiration_month . '/' . $this->credit_card->get_expiration_year( 4 );
		
		/*
		$line_items = "";
		for( $i=0; $i<count($this->cart->cart); $i++ ){
			
			if( $i != 0)
				$line_items .= "&";
				
			$line_items .= 	$this->cart->cart[$i]->product_id . "<|>" . 
							$this->cart->cart[$i]->title . "<|><|>" . 
							$this->cart->cart[$i]->quantity . "<|>" . 
							$this->cart->cart[$i]->unit_price . "<|>" . 
							$this->cart->cart[$i]->is_taxable; 	
		}
		*/
		
		$authorize_values = array(
		  "x_login"							=> $authorize_login_id,
		  "x_test_request" 					=> $authorize_test_mode,
		  "x_tran_key"						=> $authorize_trans_key,
		  "x_type"							=> $transaction_type,
		  "x_amount"						=> $this->order_totals->grand_total,
		  "x_card_num"						=> $this->credit_card->card_number,
		  "x_exp_date"						=> $expiration_date,
		  "x_card_code"						=> $this->credit_card->security_code,
		  "x_invoice_num"					=> $this->order_id,
		  "x_relay_response"				=> "FALSE",
		  "x_delim_data"					=> "TRUE",
		  "x_version"						=> "3.1",
		  "x_delim_char"					=> ",",
		  "x_method"						=> "CC",
		  "x_tax"							=> $this->order_totals->tax_total,
		  "x_duty"							=> $this->order_totals->duty_total,
		  "x_freight"						=> $this->order_totals->shipping_total,
		  "x_first_name"					=> $this->user->billing->first_name,
		  "x_last_name"						=> $this->user->billing->last_name,
		  "x_address"						=> $this->user->billing->address_line_1,
		  "x_city"							=> $this->user->billing->city,
		  "x_state"							=> $this->user->billing->state,
		  "x_zip"							=> $this->user->billing->zip,
		  "x_country"						=> $this->user->billing->country,
		  "x_phone"							=> $this->user->billing->phone,
		  "x_email"							=> $this->user->email,
		  "x_cust_id"						=> $this->user->user_id,
		  "x_customer_ip"					=> $_SERVER['REMOTE_ADDR'],
		  "x_ship_to_first_name"			=> $this->user->shipping->first_name,
		  "x_ship_to_last_name"				=> $this->user->shipping->last_name,
		  "x_ship_to_address"				=> $this->user->shipping->address_line_1,
		  "x_ship_to_city"					=> $this->user->shipping->city,
		  "x_ship_to_state"					=> $this->user->shipping->state,
		  "x_ship_to_zip"					=> $this->user->shipping->zip,
		  "x_ship_to_country"				=> $this->user->shipping->country,
		  "x_ship_to_phone"					=> $this->user->shipping->phone//,
		 // "x_line_item"						=> $line_items
		);
		
		return $authorize_values;
	}
	
	function get_gateway_url( ){
		$is_developer_account = get_option( 'ec_option_authorize_developer_account' );
		
		if( $is_developer_account )							
			return "https://test.authorize.net/gateway/transact.dll";
		else														
			return "https://secure.authorize.net/gateway/transact.dll";
	}
	
	function handle_gateway_response( $response ){
		
		$response_body = $response["body"];
		
		$response_code = substr( $response_body, 1-1, 1 );
		$response_sub_code = substr( $response_body, 2-1, 1 );
		
		if( $response_code == 1 )
			$this->is_success = true;
		else
			$this->is_success = false;
		
		$this->mysqli->insert_response( $this->order_id, $this->temp_order_id, !$this->is_success, "Authorize", $response_body );
		
		if( !$this->is_success )
			$this->error_message = $this->get_error_message( $response_code, $response_reason_code );
			
	}
	
	private function get_error_message( $response_code, $response_reason_code ){
		
		switch( $response_code ){
			case "1":
				return "No Error";
				break;
			case "2":
				switch( $response_reason_code ){
					case "27":
						return "The transaction resulted in an AVS mismatch. The address provided does not match billing address of cardholder.";
						break;
					case "28":
						return "The merchant does not accept this type of credit card.";
						break;
					case "29":
						return "The Paymentech identification numbers are incorrect. Call Merchant Service Provider.";
						break;
					case "30":
						return "The configuration with the processor is invalid. Call Merchant Service Provider.";
						break;
					case "31":
						return "The FDC Merchant ID or Terminal ID is incorrect. Call Merchant Service Provider.";
						break;
					case "34":
						return "The VITAL identification numbers are incorrect. Call Merchant Service Provider.";
						break;
					case "35":
						return "An error occurred during processing. Call Merchant Service Provider.";
						break;
					case "37":
						return "The credit card number is invalid.";
						break;
					case "38":
						return "The Global Payment System identification numbers are incorrect. Call Merchant Service Provider.";
						break;
					case "127":
						return "The transaction resulted in an AVS mismatch. The address provided does not match billing address of cardholder";
						break;
					case "171":
						return "An error occurred during processing. Please contact the merchant.";
						break;
					case "172":
						return "An error occurred during processing. Please contact the merchant.";
						break;
					case "174":
						return "The transaction type is invalid. Please contact the merchant.";
						break;
					case "315":
						return "The credit card number is invalid.";
						break;
					case "316":
						return "The credit card expiration date is invalid.";
						break;
					case "317":
						return "The credit card has expired.";
						break;
					case "318":
						return "A duplicate transaction has been submitted.";
						break;
					case "319":
						return "The transaction cannot be found.";
						break;
					default:
						return "This transaction has been declined.";
						break;
				}
			case "3":
				switch( $response_reason_code ){
					case "5":
						return "A valid amount is required.";
						break;
					case "6":
						return "The credit card number is invalid.";
						break;
					case "7":
						return "The credit card expiration date is invalid.";
						break;
					case "8":
						return "The credit card has expired.";
						break;
					case "9":
						return "The ABA code is invalid.";
						break;
					case "10":
						return "The account number is invalid";
						break;
					case "11":
						return "A duplicate transaction has been submitted.";
						break;
					case "12":
						return "An authorization code is required but not present.";
						break;
					case "13":
						return "The merchant API Login ID is invalid or the account is inactive.";
						break;
					case "14":
						return "The Referrer or Relay Response URL is invalid.";
						break;
					case "15":
						return "The transaction ID is invalid.";
						break;
					case "16":
						return "The transaction was not found.";
						break;
					case "17":
						return "The merchant does not accept this type of credit card.";
						break;
					case "18":
						return "ACH transactions are not accepted by this merchant.";
						break;
					case "19":
						return "An error occurred during processing. Please try again in 5 minutes.";
						break;
					case "20":
						return "An error occurred during processing. Please try again in 5 minutes.";
						break;
					case "21":
						return "An error occurred during processing. Please try again in 5 minutes.";
						break;
					case "22":
						return "An error occurred during processing. Please try again in 5 minutes.";
						break;
					case "23":
						return "An error occurred during processing. Please try again in 5 minutes.";
						break;
					case "24":
						return "The Nova Bank Number or Terminal ID is incorrect. Call Merchant Service Provider.";
						break;
					case "25":
						return "An error occurred during processing. Please try again in 5 minutes.";
						break;
					case "26":
						return "An error occurred during processing. Please try again in 5 minutes.";
						break;
					case "32":
						return "This reason code is reserved or not applicable to this API.";
						break;
					default:
						return "ERROR: $responseCodeReason This transaction has been declined.";
						break;
				}
			case "4":
				return "ERROR: This transaction is being held for review.";
				break;
			default:
				return "ERROR 100: There was an error processing your order";
		}
	}
	
}

?>