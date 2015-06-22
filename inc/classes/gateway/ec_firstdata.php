<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_firstdata extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$firstdatae4_exact_id = get_option( 'ec_option_firstdatae4_exact_id' );
		$firstdatae4_password = get_option( 'ec_option_firstdatae4_password' );
		$firstdatae4_language = get_option( 'ec_option_firstdatae4_language' );
		$firstdatae4_currency = get_option( 'ec_option_firstdatae4_currency' );
			
		$tax_total = number_format( $this->order_totals->tax_total + $this->order_totals->gst_total + $this->order_totals->pst_total + $this->order_totals->hst_total, 2, '.', '' );
		if( !$this->tax->vat_included )
			$tax_total = number_format( $tax_total + $this->order_totals->vat_total, 2, '.', '' );
		
		//build cart array
		$firstdatae4_cart = array();	  
		for( $i=0; $i<count($this->cart->cart); $i++){	
			$line_item = array(	"commodity_code"		=>	substr( $this->cart->cart[$i]->product_id, 0, 12 ),
								"description"			=>	substr( $this->cart->cart[$i]->title, 0, 26 ),
								"discount_amount"		=>	"0.00",
								"discount_indicator"	=>	"0",
								"gross_net_indicator"	=>	"0",
								"line_item_total"		=>	$this->cart->cart[$i]->total_price,
								"product_code"			=>	substr( $this->cart->cart[$i]->model_number, 0, 12 ),
								"quantity"				=>	$this->cart->cart[$i]->quantity,
								"unit_cost"				=>	$this->cart->cart[$i]->unit_price,
								"unit_of_measure"		=>	"ITM"
								);
			array_push( $firstdatae4_cart, $line_item );
		}
		
		//build the transaction array
		$firstdata4_data = array(	"gateway_id"		=>	$firstdatae4_exact_id,
									"password"			=>	$firstdatae4_password,
									"transaction_type"	=>	"00",
									"amount"			=>	$this->order_totals->grand_total,
									"cardholder_name"	=>	$this->credit_card->card_holder_name,
									"cc_number"			=>	$this->credit_card->card_number,
									"cc_expiry"			=>	$this->credit_card->expiration_month . $this->credit_card->get_expiration_year( 2 ),
									"cc_verification_str1"	=>	$this->user->billing->address_line_1 . "|" . $this->user->billing->zip . "|" . $this->user->billing->city . "|" . $this->user->billing->state . "|" . $this->user->billing->country,
									"cc_verification_str2"	=>	$this->credit_card->security_code,
									"cvd_presence_ind "	=>	"1",
									"reference_no"		=>	$this->order_id,
									"customer_ref"		=>	$this->user->user_id,
									"language"			=>	$firstdatae4_language,
									"client_ip"			=>	$_SERVER['REMOTE_ADDR'],
									"client_email"		=>	$this->user->email,
									"currency_code"		=>	$firstdatae4_currency,
									"level3"			=>	array(	"duty_amount"		=>	"0.00",
																	"tax_amount"		=>	$tax_total,
																	"discount_amount"	=>	$this->order_totals->discount_total,
																	"freight_amount"	=>	$this->order_totals->shipping_total,
																	"line_items"		=>	$firstdatae4_cart,
																	"ship_to_address"	=>	array(	"name"				=>	$this->user->shipping->first_name . " " . $this->user->shipping->last_name,
																									"address_1"			=>	$this->user->shipping->address_line_1,
																									"city"				=>	$this->user->shipping->city,
																									"state"				=>	$this->user->shipping->state,
																									"zip"				=>	$this->user->shipping->zip,
																									"country"			=>	$this->user->shipping->country,
																									"customer_number"	=>	$this->user->user_id,
																									"email"				=>	$this->user->email,
																									"phone"				=>	$this->user->shipping->phone
																								  )
																  )
								  );
								  		
		return $firstdata4_data;
		
	}
	
	function get_gateway_url( ){
		
		$firstdatae4_test_mode = get_option( 'ec_option_firstdatae4_test_mode' );
		
		if( $firstdatae4_test_mode )					
			return "https://api.demo.globalgatewaye4.firstdata.com/transaction/v11";
		else
			return "https://api.globalgatewaye4.firstdata.com/transaction/v11";

	}
	
	function get_gateway_headers( ){
		return array('Content-Type: application/json; charset=UTF-8;', 'Accept: application/json' );
	}
	
	function get_gateway_response( $gateway_url, $gateway_data, $gateway_headers ){
		
		$gateway_string = json_encode( $gateway_data );

		// Initializing curl
		$ch = curl_init( $gateway_url );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $gateway_string );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $gateway_headers );
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); // Work Around for Godaddy + First Data SSL Issue
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); // Work Around for Godaddy + First Data SSL Issue
		
		// Getting results
		$response = curl_exec( $ch );
		if( $response === false ){
			$this->mysqli->insert_response( 0, 1, "FIRST DATA CURL ERROR", curl_error( $ch ) );
			curl_close( $ch );
			return false;
		}else{
			curl_close( $ch );
			return $response;
		}
	}
	
	function handle_gateway_response( $response ){
		
		$response_string = json_decode( $response );
		
		if( $response_string && $response_string->bank_resp_code == '100' )
			$this->is_success = 1;
		else
			$this->is_success = 0;
		
		$response_text = print_r( $response_string, true );
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Firstdata", print_r( $response, true ) );
		
		if( !$this->is_success )
			$this->error_message = $response_string->bank_message;
			
	}
	
}

?>