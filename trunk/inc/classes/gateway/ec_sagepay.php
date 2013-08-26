<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_sagepay extends ec_gateway{
	
	private $account_page;						// VARCHAR
	private $permalink_divider;					// CHAR
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	function get_gateway_data( ){
		
		$sagepay_vendor = get_option( 'ec_option_sagepay_vendor' );
		$sagepay_currency = get_option( 'ec_option_sagepay_currency' );
		$sagepay_simulator = get_option( 'ec_option_sagepay_simulator' );
		
		if( $this->credit_card->payment_method == "visa" )
			$card_type = "VISA";
		else if( $this->credit_card->payment_method == "mastercard" )
			$card_type = "MC";
		else if( $this->credit_card->payment_method == "mcdebit" )
			$card_type = "MCDEBIT";
		else if( $this->credit_card->payment_method == "delta" )
			$card_type = "DELTA";
		else if( $this->credit_card->payment_method == "maestro" )
			$card_type = "MAESTRO";
		else if( $this->credit_card->payment_method == "uke" )
			$card_type = "UKE";
		else if( $this->credit_card->payment_method == "amex" )
			$card_type = "AMEX";
		else if( $this->credit_card->payment_method == "discover" )
			$card_type = "DC";
		else if( $this->credit_card->payment_method == "jcb" )
			$card_type = "JCB";
		else if( $this->credit_card->payment_method == "laser" )
			$card_type = "LASER";
		
		if( $sagepay_simulator )
			$VPS_Protocol = "2.23";
		else
			$VPS_Protocol = "3.00";
			
		$account_page_id = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $account_page_id );
		
		if( substr_count( $this->account_page, '?' ) )
			$this->permalink_divider = "&";
		else
			$this->permalink_divider = "?";
		
		$sagepay_data = array(	"VPSProtocol" => $VPS_Protocol,
								"TxType" => "PAYMENT", // PAYMENT, DEFERRED, OR AUTHENTICATE
								"Vendor" => $sagepay_vendor,
								"VendorTxCode" => $this->order_id,
								"Amount" => $this->order_totals->grand_total,
								"Currency" => $sagepay_currency,
								"Description" => "Online Sale",
								"CardHolder" => $this->credit_card->card_holder_name,
								"CardNumber" => $this->credit_card->card_number,
								"ExpiryDate" => $this->credit_card->expiration_month . $this->credit_card->get_expiration_year( 2 ),
								"CV2" => $this->credit_card->security_code,
								"CardType" => $card_type,
								"BillingSurname" => $this->user->billing->last_name,
								"BillingFirstnames" => $this->user->billing->first_name,
								"BillingAddress1" => $this->user->billing->address_line_1,
								"BillingCity" => $this->user->billing->city,
								"BillingPostCode" => $this->user->billing->zip,
								"BillingState" => $this->user->billing->state,
								"BillingCountry" => $this->user->billing->country,
								"BillingPhone" => $this->user->billing->phone,
								"DeliverySurname" => $this->user->shipping->last_name,
								"DeliveryFirstnames" => $this->user->shipping->first_name,
								"DeliveryAddress1" => $this->user->shipping->address_line_1,
								"DeliveryCity" => $this->user->shipping->city,
								"DeliveryPostCode" => $this->user->shipping->zip,
								"DeliveryCountry" => $this->user->shipping->country,
								"DeliveryState" => $this->user->shipping->state,
								"DeliveryPhone" => $this->user->shipping->phone,
								"CustomerEMail" => $this->user->email,
								"NotificationURL" => $this->account_page . $this->permalink_divider . "ec_page=order_details&order_id=" . $this->order_id
					 );
					 
		return $sagepay_data;
		
	}
	
	function get_gateway_url( ){
		
		$sagepay_simulator = get_option( 'ec_option_sagepay_simulator' );
		$sagepay_test_mode = get_option( 'ec_option_sagepay_testmode' );
		
		if( $sagepay_simulator )
			return "https://test.sagepay.com/Simulator/VSPDirectGateway.asp";
		else if( $sagepay_test_mode )
			return "https://test.sagepay.com/gateway/service/vspdirect-register.vsp";
		else
			return "https://live.sagepay.com/gateway/service/vspdirect-register.vsp";

	}
	
	function handle_gateway_response( $response ){
		
		$response_body = $response["body"];
		
		//Format response data in form key=val&key2=val2&...
		$response_array = explode( "\r\n", $response_body );
		$response_vals = array();
		for( $i=0; $i<count($response_array); $i++){
			$split = explode( "=", $response_array[$i] );
			if( count( $split ) >= 2 )
				$response_vals[$split[0]] = $split[1]; 
		}
		
		$status = $response_vals["Status"];
		if( isset( $response_vals["StatusDetail"] ) )
			$status_detail = $response_vals["StatusDetail"];
		else
			$status_detail = "";
			
		//3D Secure Specific Variables
		if( isset( $response_vals['3DSecureStatus'] ) )
			$secure_status = $response_vals['3DSecureStatus'];
		if( isset( $response_vals['MD'] ) )
			$secure_id = $response_vals['MD'];
		if( isset( $response_vals['ACSURL'] ) )
			$post_url = $response_vals['ACSURL'];
		if( isset( $response_vals['PAReq'] ) )
			$post_message = $response_vals['PAReq'];
			
		$response_text = print_r( $response_vals, true );
		
		if( $status == "3DAUTH" ){
			if( $secure_status == "OK" ){
				$this->is_3d_auth = true;
				$this->post_url = $post_url;
				$this->post_id_input_name = "MD";
				$this->post_id = $secure_id;
				$this->post_message_input_name = "PaReq";
				$this->post_message = $post_message;
				$this->post_return_url_input_name = "TermUrl";
				$this->is_success = 1;
			}else{
				$this->is_success = 0;	
			}
		}else if( $status == "OK" )
			$this->is_success = 1;
		else
			$this->is_success = 0;
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Sagepay", $response_text );
		
		if( !$this->is_success )
			$this->error_message = $status_detail;
			
	}
	
}

?>