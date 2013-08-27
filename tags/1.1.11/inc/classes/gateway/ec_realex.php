<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_realex extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$realex_merchant_id = get_option( 'ec_option_realex_merchant_id' );
		$realex_secret = get_option( 'ec_option_realex_secret' );
		$realex_account = get_option( 'ec_option_realex_account' );
		$realex_currency = get_option( 'ec_option_realex_currency' );
		
		$realex_timestamp = strftime("%Y%m%d%H%M%S");
		mt_srand((double)microtime()*1000000);
		
		$realex_order_id = $this->order_id;
		$realex_total = $this->order_totals->get_grand_total_in_cents( );
		$realex_card_number = $this->credit_card->card_number;
		
		$tmp = "$realex_timestamp.$realex_merchant_id.$realex_order_id.$realex_total.$realex_currency.$realex_card_number";
		$md5hash = md5($tmp);
		$tmp_md5 = "$md5hash.$realex_secret";
		$md5hash = md5($tmp_md5);
		
		$sha1hash = sha1($tmp);
		$tmp_sha1 = "$sha1hash.$realex_secret";
		$sha1hash = sha1($tmp_sha1);
		
			 if( $this->credit_card->payment_method == "visa" )
			$realex_payment_method = "VISA";
		else if( $this->credit_card->payment_method == "mastercard" )
			$realex_payment_method = "MC";
		else if( $this->credit_card->payment_method == "amex" )
			$realex_payment_method = "AMEX";
		else if( $this->credit_card->payment_method == "jcb" )
			$realex_payment_method = "JCB";
		else if( $this->credit_card->payment_method == "diners" )
			$realex_payment_method = "DINERS";
		else if( $this->credit_card->payment_method == "laser" )
			$realex_payment_method = "LASER";
		else if( $this->credit_card->payment_method == "maestro" )
			$realex_payment_method = "SWITCH";
		else
			$realex_payment_method = "VISA";
		
		
		
		$realex_xml = "<request timestamp='" . $realex_timestamp . "' type='auth'>
				<merchantid>" . $realex_merchant_id . "</merchantid>
				<account>" . $realex_account . "</account>
				<orderid>" . $realex_order_id . "</orderid>
				<amount currency='" . $realex_currency . "'>" . $this->order_totals->get_grand_total_in_cents( ) . "</amount>
				<card> 
					<number>" . $this->credit_card->card_number . "</number>
					<expdate>" . $this->credit_card->expiration_month . $this->credit_card->get_expiration_year( 2 ) . "</expdate>
					<chname>" . $this->credit_card->card_holder_name . "</chname> 
					<type>" . $realex_payment_method . "</type> 
					<issueno>" . $this->credit_card->security_code . "</issueno>
					<cvn>
						<number>" . $this->credit_card->security_code . "</number>
						<presind>1</presind>
					</cvn>
				</card>
				<autosettle flag='1'/>
				<sha1hash>" . $sha1hash . "</sha1hash>
				<md5hash>" . $md5hash . "</md5hash>
				<tssinfo>
					<custnum>" . $this->user->user_id . "</custnum>
					<address type=\"billing\">
						<code>" . $this->user->billing->zip . "</code>
						<country>".$this->user->billing->country."</country>
					</address>
					<address type=\"shipping\">
						<code>" . $this->user->shipping->zip . "</code>
						<country>".$this->user->shipping->country."</country>
					</address>
				</tssinfo>
				
			</request>";
		
		return $realex_xml;
		
	}
	
	function get_gateway_url( ){
		
		return "https://epage.payandshop.com/epage-remote.cgi";

	}
	
	function handle_gateway_response( $response ){
		
		$response_body = $response["body"];
		$xml = new SimpleXMLElement($response_body);
		
		$result_code = $xml->result;
		$result_message = $xml->message;
		
		$response_text = print_r( $xml, true );
		
		if( $result_code == "00" )
			$this->is_success = 1;
		else
			$this->is_success = 0;
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Realex", $response_text );
		
		if( !$this->is_success )
			$this->error_message = $result_message;
			
	}
	
}

?>