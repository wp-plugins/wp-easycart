<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_stripe extends ec_gateway{
	
	private $account_page;						// VARCHAR
	private $permalink_divider;					// CHAR
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	function process_credit_card( ){
		
		$gateway_url = $this->get_gateway_url( );
		$gateway_response = $this->get_gateway_response( $gateway_url );
		
		if( !$gateway_response ){
			error_log( "error in process_credit_card, could not get a response from the server." );
			return false;
		}else{
			$this->handle_gateway_response( $gateway_response );
			if( $this->is_success )
				return true;
			else{
				error_log( "error in process_credit_card from processor: " . $this->error_message );
				return false;
			}
		}
	}
	
	function get_gateway_response( $gateway_url ){
		
		$response = $this->insert_charge( $this->order_totals, $this->user, $this->credit_card, $this->order_id );
		$this->handle_gateway_response( $response );
		
		if( $this->is_success ){
			$this->mysqli->update_order_stripe_charge_id( $this->order_id, $response->id );
			return true;
		}else{
			error_log( "error in process_credit_card from processor: " . $this->error_message );
			return false;
		}
			
	}
	
	function get_gateway_url( ){
		
		return "https://api.stripe.com/v1/charges";

	}
	
	function handle_gateway_response( $response ){
		
		$status = $response->failure_code;
		$failure_message = $response->failure_message;
		
		if( $status == NULL )
			$this->is_success = 1;
		else
			$this->is_success = 0;
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Stripe", print_r( $response, true ) );
		
		if( !$this->is_success )
			$this->error_message = $failure_message;
			
	}
	
	////////////////////////////////////////////////
	// PUBLIC CHARGE FUNCTIONS
	////////////////////////////////////////////////
	public function insert_charge( $order_totals, $user, $card, $order_id ){
		
		$gateway_data = $this->get_insert_charge_data( $order_totals, $user, $card, $order_id );
		$response = $this->call_stripe( $gateway_url, $gateway_data );
		$json = json_decode( $response );
		return $json;
		
	}
	
	public function get_charge( $charge_id ){
		
		$data = $this->get_get_charge_data( $charge_id );
		$response = $this->call_stripe( "https://api.stripe.com/v1/charges/", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
		
	}
	
	public function refund_charge( $charge_id, $amount ){
		
		$data = $this->get_refund_charge_data( $charge_id, $amount );
		$response = $this->call_stripe( "https://api.stripe.com/v1/charges/" . $charge_id . "/refund", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
		
	}
	
	public function capture_charge( $charge_id, $amount ){
		
		$data = $this->get_capture_charge_data( $charge_id, $amount );
		$response = $this->call_stripe( "https://api.stripe.com/v1/charges/" . $charge_id . "/capture", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
		
	}
	
	public function get_charge_list( $limit, $offset, $customer_id = 0 ){
		
		$data = $this->get_charge_list_data( $limit, $offset, $customer_id );
		$response = $this->call_stripe_get( "https://api.stripe.com/v1/charges/", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
		
	}
	
	////////////////////////////////////////////////
	// PUBLIC SUBSCRIPTION FUNCTIONS
	////////////////////////////////////////////////
	
	public function insert_subscription( $product, $user, $card, $coupon = NULL, $prorate = "true", $trial_end = NULL, $quantity = 1 ){
		
		$data = $this->get_insert_subscription_data( $product, $user, $card, $coupon, $prorate, $trial_end, $quantity );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/subscriptions", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	
	}
	
	public function get_subscription( $customer_id, $subscription_id ){
		
		$response = $this->call_stripe_get( "https://api.stripe.com/v1/customers/" . $customer_id . "/subscriptions/" . $subscription_id, array( ) );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	
	}
	
	public function update_subscription( $product, $user, $card = NULL, $subscription_id, $coupon = NULL, $prorate = "true", $trial_end = NULL, $quantity = 1 ){
		
		$data = $this->get_update_subscription_data( $product, $user, $card, $coupon, $prorate, $trial_end, $quantity );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/subscriptions/" . $subscription_id, $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	
	}
	
	public function cancel_subscription( $user, $subscription_id, $cancel_at_end_of_current_period = "false" ){
		
		$response = $this->call_stripe_delete( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/subscriptions/" . $subscription_id );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	
	}
	
	public function get_active_subscription_list( $user, $limit = 25, $offset = 0 ){
		
		$data = $this->get_subscription_list_data( $user, $limit, $offset );
		$response = $this->call_stripe_get( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/subscriptions", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	
	}
	
	////////////////////////////////////////////////
	// PUBLIC CUSTOMER FUNCTIONS
	////////////////////////////////////////////////
	
	public function insert_customer( $user, $card = NULL ){
		
		$data = $this->get_insert_customer_data( $user, $card );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json->id;
		else
			return false;
	
	}
	
	public function get_customer( $user ){
		$data = $this->get_get_customer_data( $user );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id, $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	}
	
	public function update_customer( ){
		$data = $this->get_update_customer_data( $user );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id, $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
	}
	
	public function delete_customer( $user ){
		$response = $this->call_stripe_delete( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
	}
	
	public function get_customer_list( $limit = 25, $offset = 0 ){
		$data = $this->get_customer_list_data( $limit, $offset );
		$response = $this->call_stripe_get( "https://api.stripe.com/v1/customers", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	}
	
	////////////////////////////////////////////////
	// PUBLIC PLAN FUNCTIONS
	////////////////////////////////////////////////
	public function insert_plan( $product ){
		$data = $this->get_insert_plan_data( $product );
		$response = $this->call_stripe( "https://api.stripe.com/v1/plans", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
	}
	
	public function get_plan( $product ){
		$data = $this->get_get_plan_data( $product );
		$response = $this->call_stripe( "https://api.stripe.com/v1/plans/" . $product->product_id, $data );
		$json = json_decode( $response );
		
		if( !$json-error )
			return $json;
		else
			return false;
	}
	
	public function update_plan( $product ){
		$data = $this->get_update_plan_data( $product );
		$response = $this->call_stripe( "https://api.stripe.com/v1/plans/" . $product->product_id, $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
	}
	
	public function delete_plan( $product ){
		$response = $this->call_stripe_delete( "https://api.stripe.com/v1/plans/" . $product->product_id );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false; 
	}
	
	public function get_plan_list( $limit = 25, $offset = 0 ){
		$data = $this->get_plan_list_data( $product );
		$response = $this->call_stripe_get( "https://api.stripe.com/v1/plans", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
	}
	
	////////////////////////////////////////////////
	// PUBLIC CARDS FUNCTIONS
	////////////////////////////////////////////////
	
	public function insert_card( $user, $card ){
		
		$data = $this->get_insert_card_data( $user, $card );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/cards", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json->id;
		else
			return false;
		
	}
	
	public function get_card( $user, $card_id ){
		
		$data = $this->get_get_card_data( $user, $card_id );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/cards/" . $card_id, $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
		
	}
	
	public function update_card( $user, $exp_month = NULL, $exp_year = NULL, $card_name ){
		
		$data = $this->get_update_card_data( $user, $exp_month, $exp_year, $card_name );
		$response = $this->call_stripe( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/cards/" . $card_id, $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
		
	}
	
	public function delete_card( $user, $card_id ){
		
		$response = $this->call_stripe_delete( "https://api.stripe.com/v1/customers/" . $user->stripe_customer_id . "/cards/" . $card_id );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
		
	}
	
	public function get_card_list( $customer_id, $limit = 25, $offset = 0 ){
	
		$data = $this->get_card_list_data( $limit, $offset );
		$response = $this->call_stripe_get( "https://api.stripe.com/v1/customers/" . $customer_id . "/cards", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
		
	}
	
	////////////////////////////////////////////////
	// PUBLIC SUBSCRIPTION COUPONS FUNCTIONS
	////////////////////////////////////////////////
	
	public function insert_coupon( $coupon ){
		
		$data = $this->get_insert_coupon_data( $coupon );
		$response = $this->call_stripe( "https://api.stripe.com/v1/coupons", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json->id;
		else
			return false;
		
	}
	
	public function get_coupon( $coupon ){
		
		$data = $this->get_update_coupon_data( $coupon );
		$response = $this->call_stripe( "https://api.stripe.com/v1/coupons" . $card_id, $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
		
	}
	
	public function delete_coupon( $coupon ){
		
		$response = $this->call_stripe_delete( "https://api.stripe.com/v1/coupons" . $card_id );
		$json = json_decode( $response );
		
		if( !$json->error )
			return true;
		else
			return false;
		
	}
	
	public function get_coupon_list( $limit, $offset ){
		
		$data = $this->get_coupon_list_data( $limit, $offset );
		$response = $this->call_stripe( "https://api.stripe.com/v1/coupons", $data );
		$json = json_decode( $response );
		
		if( !$json->error )
			return $json;
		else
			return false;
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE MAIN STRIPE CALL
	////////////////////////////////////////////////
	private function call_stripe( $gateway_url, $gateway_data ){
		
		$api_key = get_option( 'ec_option_stripe_api_key' );
		$headr = array();
		$headr[] = 'Authorization: Bearer ' . $api_key;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, true ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $gateway_data ) );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		curl_close ($ch);
		
		return $response;
		
	}
	
	private function call_stripe_get( $gateway_url, $gateway_data ){
		
		$api_key = get_option( 'ec_option_stripe_api_key' );
		$headr = array();
		$headr[] = 'Authorization: Bearer ' . $api_key;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url . "?" . http_build_query( $gateway_data ) );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, false ); 
		curl_setopt($ch, CURLOPT_HTTPGET, true );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		curl_close ($ch);
		
		return $response;
		
	}
	
	private function call_stripe_delete( $gateway_url ){
		
		$api_key = get_option( 'ec_option_stripe_api_key' );
		$headr = array();
		$headr[] = 'Authorization: Bearer ' . $api_key;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		curl_close ($ch);
		
		return $response;
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE CHARGES DATA FUNCTIONS
	////////////////////////////////////////////////
	
	private function get_insert_charge_data( $order_totals, $user, $card, $order_id ){
		
		$amount = number_format( $this->order_totals->grand_total * 100, 0, "", "" );
		$currency = get_option( 'ec_option_stripe_currency' );
		
		$card_array = array( 	"number" 			=> $card->card_number,
								"exp_month"			=> $card->expiration_month,
								"exp_year"			=> $card->get_expiration_year( 2 ),
								"cvc"				=> $card->security_code,
								"name"				=> $card->card_holder_name,
								"address_line_1"	=> $user->billing->address_line_1,
								"address_city"		=> $user->billing->city,
								"address_zip"		=> $user->billing->zip,
								"address_state"		=> $user->billing->state,
								"address_country"	=> $user->billing->country );
						
		$gateway_data = array( 	"amount"			=> $amount,
								"currency"			=> $currency,
								"card"				=> $card_array,
								"description"		=> $order_id );
								
		return $gateway_data;
	}
	
	private function get_get_charge_data( $charge_id ){
		
		return array( "id" => $charge_id );
		
	}
	
	private function get_refund_charge_data( $charge_id, $amount ){
		
		return array( "id" => $charge_id, "amount" => number_format( $amount * 100, 0, "", "" ) );
		
	}
	
	private function get_capture_charge_data( $charge_id, $amount ){
		
		return array( "id" => $charge_id, "amount" => number_format( $amount * 100, 0, "", "" ) );
		
	}
	
	private function get_charge_list_data( $limit, $offset, $customer_id ){
	
		$gateway_data = array( 	"count" 	=> $limit,
								"offset"	=> $offset );
								
		if( $customer_id > 0 ){
			$gateway_data["customer"] = $customer_id;
		}
		
		return $gateway_data;
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE SUBSCRIPTION DATA FUNCTIONS
	////////////////////////////////////////////////
	
	private function get_insert_subscription_data( $product, $user, $card, $coupon, $prorate, $trial_end, $quantity ){
		
		$card_array = array( 	"number" 				=> $card->card_number,
								"exp_month"				=> $card->expiration_month,
								"exp_year"				=> $card->get_expiration_year( 2 ),
								"cvc"					=> $card->security_code,
								"name"					=> $card->card_holder_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"address_city"			=> $user->billing->city,
								"address_zip"			=> $user->billing->zip,
								"address_state"			=> $user->billing->state,
								"address_country"		=> $user->billing->country );
		
		$gateway_data = array(	"plan"					=> $product->product_id,
								"coupon"				=> $coupon,
								"trial_end"				=> $trial_end,
								"card"					=> $card_array,
								"quantity"				=> $quantity );
								
		return $gateway_data;
	
	}
	
	private function get_update_subscription_data( $product, $user, $card, $coupon, $prorate, $trial_end, $quantity ){
		
		if( $card != NULL ){
			$card_array = array("number" 				=> $card->card_number,
								"exp_month"				=> $card->expiration_month,
								"exp_year"				=> $card->get_expiration_year( 2 ),
								"cvc"					=> $card->security_code,
								"name"					=> $card->card_holder_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"address_city"			=> $user->billing->city,
								"address_zip"			=> $user->billing->zip,
								"address_state"			=> $user->billing->state,
								"address_country"		=> $user->billing->country );
		}else{
			$card_array = NULL;
		}
		
		$gateway_data = array(	"plan"					=> $product->product_id,
								"coupon"				=> $coupon,
								"prorate"				=> $prorate,
								"trial_end"				=> $trial_end,
								"card"					=> $card_array,
								"quantity"				=> $quantity );
		
		return $gateway_data;
		
	}
	
	private function get_subscription_list_data( $user, $limit, $offset ){
		
		$gateway_data = array(	"count"					=> $limit,
								"offset"				=> $offset );
								
		return $gateway_data;
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE CUSTOMER DATA FUNCTIONS
	////////////////////////////////////////////////
	
	private function get_insert_customer_data( $user, $card ){
		
		if( $card != NULL ){
			$card_array = array("number" 				=> $card->card_number,
								"exp_month"				=> $card->expiration_month,
								"exp_year"				=> $card->get_expiration_year( 2 ),
								"cvc"					=> $card->security_code,
								"name"					=> $card->card_holder_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"address_city"			=> $user->billing->city,
								"address_zip"			=> $user->billing->zip,
								"address_state"			=> $user->billing->state,
								"address_country"		=> $user->billing->country );
		}else{
			$card_array = NULL;
		}
		
		$meta_data = array(		"first_name"			=> $user->billing->first_name,
								"last_name"				=> $user->billing->last_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"city"					=> $user->billing->city,
								"state"					=> $user->billing->state,
								"zip"					=> $user->billing->zip,
								"country"				=> $user->billing->country,
								"phone"					=> $user->billing->phone );
		
		$gateway_data = array(	"card"					=> $card_array,
								"description"			=> $user->billing->first_name . " " . $user->billing_last_name,
								"email"					=> $user->email,
								"metadata"				=> $meta_data );
								
		return $gateway_data;
		
	}
	
	private function get_get_customer_data( $user ){
		
		return array( "id" => $user->user_id );
		
	}
	
	private function get_update_customer_data( $user ){
		
		if( $card != NULL ){
			$card_array = array("number" 				=> $card->card_number,
								"exp_month"				=> $card->expiration_month,
								"exp_year"				=> $card->get_expiration_year( 2 ),
								"cvc"					=> $card->security_code,
								"name"					=> $card->card_holder_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"address_city"			=> $user->billing->city,
								"address_zip"			=> $user->billing->zip,
								"address_state"			=> $user->billing->state,
								"address_country"		=> $user->billing->country );
		}else{
			$card_array = NULL;
		}
		
		$meta_data = array(		"first_name"			=> $user->billing->first_name,
								"last_name"				=> $user->billing->last_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"city"					=> $user->billing->city,
								"state"					=> $user->billing->state,
								"zip"					=> $user->billing->zip,
								"country"				=> $user->billing->country,
								"phone"					=> $user->billing->phone );
		
		$gateway_data = array(	"card"					=> $card_array,
								"description"			=> $user->billing->first_name . " " . $user->billing_last_name,
								"email"					=> $user->email,
								"metadata"				=> $meta_data );
								
		return $gateway_data;
		
	}
	
	private function get_customer_list_data( $limit, $offset ){
		
		return array( "count" => $limit, "offset" => $offset );
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE PLAN DATA FUNCTIONS
	////////////////////////////////////////////////
	
	private function get_insert_plan_data( $product ){
		
		$currency = get_option( 'ec_option_stripe_currency' );
		$gateway_data = array(	"id"					=> $product->product_id,
								"amount"				=> number_format( $product->price * 100, 0, "", "" ),
								"currency"				=> $currency,
								"interval"				=> $this->convert_period_to_name( $product->subscription_bill_period ), //week, month, or year
								"interval_count"		=> $product->subscription_bill_length,
								"name"					=> $GLOBALS['language']->convert_text( $product->title ),
								"trial_period_days"		=> $product->trial_period_days );
								
		return $gateway_data;
		
	}
	
	private function get_get_plan_data( $product ){
		
		$gateway_data = array(	"id"					=> $product->product_id );
								
		return $gateway_data;
		
	}
	
	private function get_update_plan_data( $product ){
		
		$gateway_data = array(	"name"					=> $product->title );
								
		return $gateway_data;
		
	}
	
	private function get_plan_list_data( $limit, $offset ){
		
		$gateway_data = array(	"count"					=> $limit,
								"offset"				=> $offset );
								
		return $gateway_data;
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE PLAN DATA FUNCTIONS
	////////////////////////////////////////////////
	
	private function get_insert_card_data( $user, $card ){
		
		$card_array = array(	"number" 				=> $card->card_number,
								"exp_month"				=> $card->expiration_month,
								"exp_year"				=> $card->get_expiration_year( 2 ),
								"cvc"					=> $card->security_code,
								"name"					=> $card->card_holder_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"address_city"			=> $user->billing->city,
								"address_zip"			=> $user->billing->zip,
								"address_state"			=> $user->billing->state,
								"address_country"		=> $user->billing->country );
								
		return array( "card" => $card_array );
		
	}
	
	private function get_get_card_data( $user, $card_id ){
		
		return array( "id" => $card_id, "customer" => $user->user_id );
		
	}
	
	private function get_update_card_data( $user, $exp_month, $exp_year, $card_name ){
		
		$gateway_data = array(	"exp_month"				=> $exp_month,
								"exp_year"				=> $exp_year,
								"name"					=> $card->card_holder_name,
								"address_line_1"		=> $user->billing->address_line_1,
								"address_city"			=> $user->billing->city,
								"address_zip"			=> $user->billing->zip,
								"address_state"			=> $user->billing->state,
								"address_country"		=> $user->billing->country );
		
		return $gateway_data;
		
	}
	
	private function get_card_list_data( $limit, $offset ){
		
		return array( "count" => $limit, "offset" => $offset );
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE COUPON DATA FUNCTIONS
	////////////////////////////////////////////////
	
	private function get_insert_coupon_data( $coupon ){
		
		$currency = get_option( 'ec_option_stripe_currency' );
		
		if( $is_amount_off ){
		
		$gateway_data = array(	"id"					=> $coupon->promocode_id,
								"duration"				=> $coupon->duration, //forever, once, or repeating
								"amount_off"			=> $coupon,
								"currency"				=> $currency,
								"max_redemptions"		=> $coupon->max_redemptions );
								
		}else{
			
		$gateway_data = array(	"id"					=> $coupon->promocode_id,
								"duration"				=> $coupon->duration, //forever, once, or repeating
								"percent_off"			=> $coupon,
								"currency"				=> $currency,
								"max_redemptions"		=> $coupon->max_redemptions );
			
		}
								
								
		if( $coupon->duration == "repeating" ){
			$gateway_data[ "duration_in_months" ] = $coupon-duration_in_months;
		}
		
		return $gateway_data;	
		
	}
	
	private function get_update_coupon_data( $coupon ){
		
		return array( $id = $coupon->promocode_id );
		
	}
	
	private function get_coupon_list_data( $limit, $offset ){
		
		return array( "count" => $limit, "offset" => $offset );
		
	}
	
	////////////////////////////////////////////////
	// PRIVATE SUBSCRIPTION HELPER FUNCTIONS
	////////////////////////////////////////////////
	
	private function convert_period_to_name( $period ){
		if( $period == "M" ){
			return "month";
		}else if( $period == "D" ){
			return "day";	
		}else if( $period == "Y" ){
			return "year";
		}
	}
	
}
?>