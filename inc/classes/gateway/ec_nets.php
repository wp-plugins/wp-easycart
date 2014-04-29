<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_nets extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$merchant_id = get_option( 'ec_option_nets_merchant_id' );
		$token = get_option( 'ec_option_nets_token' );
		$currency_code = get_option( 'ec_option_nets_currency' );
		
		$serviceType = 'M';
		
		$register_data = array( 'orderNumber' 			=>	$this->order_id,
								'currencyCode'			=>	$currency_code,
								'amount'				=>	number_format( $this->order_totals->grand_total * 100, 0, "", "" ),
								'webServicePlatform'	=>	"PHP5",
								'customerNumber'		=> 	$this->user->user_id,
								'customerEmail'			=> 	$this->user->email,
								'customerPhoneNumber'	=>	$this->user->billing->phone,
								'customerFirstName'		=>	$this->user->billing->first_name,
								'customerLastName'		=>	$this->user->billing->last_name,
								'customerAddress1'		=>	$this->user->billing->address_line_1,
								'customerAddress2'		=>	$this->user->billing->address_line_2,
								'customerPostcode'		=>	$this->user->billing->zip,
								'customerTown'			=>	$this->user->billing->city,
								'customerCountry'		=>	$this->user->billing->country,
								'pan'					=>	$this->credit_card->card_number,
								'expiryDate'			=>	$this->credit_card->expiration_month . $this->credit_card->get_expiration_year( 2 ),
								'securityCode'			=>	$this->credit_card->security_code,
								'merchantID'			=>	$merchant_id,
								'token'					=>	$token 
							);
		
		if( $this->order_totals->vat_total ){
			$register_data['terminalVat'] = $this->order_totals->vat_total;
		}
		
		return $register_data;
		
	}
	
	function get_process_data( $transaction_id ){
		
		$merchant_id = get_option( 'ec_option_nets_merchant_id' );
		$token = get_option( 'ec_option_nets_token' );
		$operation = 'SALE';
		
		$process_data = array(	'merchantID'			=>	$merchant_id,
								'token'					=>	$token,
								'operation'				=>	$operation,
								'transactionId'			=>	$transaction_id );
		
		return $register_data;
		
	}
	
	function get_gateway_url( ){
		
		$test_mode = get_option( 'ec_option_nets_test_mode' );
		
		if( $test_mode )
			return "https://test.epayment.nets.eu/Netaxept/Register.aspx";
		else
			return "https://epayment.nets.eu/Netaxept/Register.aspx";

	}
	
	function get_gateway_response( $gateway_url, $gateway_data, $gateway_headers ){
		
		print_r( $gateway_data );
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $gateway_headers );
		curl_setopt($ch, CURLOPT_POST, true ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $gateway_data ) );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		curl_close ($ch);
		
		return $response;
		
	}
	
	function handle_gateway_response( $response ){
		
		// Process the response, get the transaction id
		// print_r( $response );
		// die( );
		$transaction_id = "";
		
		// Once you get the register, process the sale
		$data = $this->get_process_data( $transaction_id );
		
		
		if( $result_code == "1" )
			$this->is_success = 1;
		else
			$this->is_success = 0;
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Nets Payments", $response_text );
		
		if( !$this->is_success )
			$this->error_message = $result_message;
			
	}
	
}

?>