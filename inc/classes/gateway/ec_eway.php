<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_eway extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$eway_customer_id = get_option( 'ec_option_eway_customer_id' );
		$eway_test_mode = get_option( 'ec_option_eway_test_mode' );
		$eway_test_mode_success = get_option( 'ec_option_eway_test_mode_success' );
		
		if( $eway_test_mode ){
			$this->credit_card->card_number = "4444333322221111";
			$eway_customer_id = "87654321";
			if( $eway_test_mode_success )
				$this->order_totals->grand_total = 10.00;	
			else
				$this->order_totals->grand_total = 10.67;
		}
		
		$eway_xml = "<ewaygateway>
						<ewayCustomerID>" . $eway_customer_id . "</ewayCustomerID> 
						<ewayTotalAmount>" . $this->order_totals->get_grand_total_in_cents( ) . "</ewayTotalAmount> 
						<ewayCustomerFirstName>" . $this->user->billing->first_name . "</ewayCustomerFirstName> 
						<ewayCustomerLastName>" . $this->user->billing->last_name . "</ewayCustomerLastName> 
						<ewayCustomerEmail>" . $this->user->email . "</ewayCustomerEmail> 
						<ewayCustomerAddress>" . $this->user->billing->address_line_1 . "</ewayCustomerAddress> 
						<ewayCustomerPostcode>" . $this->user->billing->zip . "</ewayCustomerPostcode>
						<ewayCustomerInvoiceDescription></ewayCustomerInvoiceDescription>
						<ewayCustomerInvoiceRef>" . $this->order_id . "</ewayCustomerInvoiceRef> 
						<ewayCardHoldersName>" . $this->credit_card->card_holder_name . "</ewayCardHoldersName> 
						<ewayCardNumber>" . $this->credit_card->card_number . "</ewayCardNumber> 
						<ewayCardExpiryMonth>" . $this->credit_card->expiration_month . "</ewayCardExpiryMonth> 
						<ewayCardExpiryYear>" . $this->credit_card->get_expiration_year( 2 ) . "</ewayCardExpiryYear>
						<ewayTrxnNumber></ewayTrxnNumber> 
						<ewayOption1></ewayOption1> 
						<ewayOption2></ewayOption2> 
						<ewayOption3></ewayOption3> 
						<ewayCVN>" . $this->credit_card->security_code . "</ewayCVN>
					  </ewaygateway>";
		
		return $eway_xml;
		
	}
	
	function get_gateway_url( ){
		
		$eway_test_mode = get_option( 'ec_option_eway_test_mode' );
		
		if( $eway_test_mode )
			return "https://www.eway.com.au/gateway_cvn/xmltest/testpage.asp";
		else
			return "https://www.eway.com.au/gateway_cvn/xmlpayment.asp";
	}
	
	function handle_gateway_response( $response ){
		
		$response_body = $response["body"];
		
		$xml = new SimpleXMLElement($response_body);
		
		$response_text = print_r( $xml, true );
		
		if( $xml->ewayTrxnStatus == "True" )
			$this->is_success = 1;
		else
			$this->is_success = 0;
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Eway", $response_text );
		
		if( !$this->is_success )
			$this->error_message = $ewayTrxnError;
			
	}
	
}

?>