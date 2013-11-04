<?php
class ec_paymentexpress_thirdparty extends ec_third_party{
	
	private $payment_express_redirect_url;						// STRING
	
	public function display_form_start( ){
		echo "<form action=\"" . $this->payment_express_redirect_url . "\" method=\"post\">";
		
		
	}
	
	public function display_auto_forwarding_form( ){
		$payment_express_username = get_option( 'ec_option_payment_express_thirdparty_username' );
		$payment_express_key = get_option( 'ec_option_payment_express_thirdparty_key' );
		$payment_express_currency = get_option( 'ec_option_payment_express_thirdparty_currency' );
		
		$payment_express_xml = "<GenerateRequest>
									<PxPayUserId>" . $payment_express_username . "</PxPayUserId>
									<PxPayKey>" . $payment_express_key . "</PxPayKey>
									<AmountInput>" . number_format($this->order->grand_total, 2, '.', '' ). "</AmountInput>
									<CurrencyInput>" . $payment_express_currency . "</CurrencyInput>
									<MerchantReference>" . $this->order_id . "</MerchantReference>
									<EmailAddress>" . $this->order->user_email . "</EmailAddress>
									<TxnData1>" . htmlentities( $this->order->billing_address_line_1 ) . "d</TxnData1>
									<TxnData2>" . htmlentities( $this->order->billing_city ) . "</TxnData2>
									<TxnData3>" . $this->order->billing_country . "</TxnData3>
									<TxnType>Purchase</TxnType>
									<TxnId>" . $this->order_id . "</TxnId>
									<BillingId></BillingId>
									<EnableAddBillCard>0</EnableAddBillCard>
									<UrlSuccess>" . htmlentities( $this->cart_page . $this->permalink_divider . "ec_action=paymentexpress&ec_page=checkout_success&order_id=" . $this->order_id ) . "</UrlSuccess>
									<UrlFail>". htmlentities( $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment" ) . "</UrlFail>
								</GenerateRequest>";
		
		$response = $this->send_xml_request( $payment_express_xml );
		
		$response_body = $response["body"];
		$xml = new SimpleXMLElement($response_body);
		$this->payment_express_redirect_url = $xml->URI;
		
		echo "<form action=\"" . $this->payment_express_redirect_url . "\" method=\"post\" name=\"ec_paymentexpress_auto_form\">";
		echo "</form>";
		echo "<SCRIPT LANGUAGE=\"Javascript\">document.ec_paymentexpress_auto_form.submit();</SCRIPT>";
	}
	
	private function send_xml_request( $xml ){
		$request = new WP_Http;
		$response = $request->request( "https://sec.paymentexpress.com/pxaccess/pxpay.aspx", array( 'method' => 'POST', 'body' => $xml, 'headers' => "" ) );
		if( is_wp_error( $response ) ){
			$this->error_message = $response->get_error_message();
			return false;
		}else
			return $response;
	}
	
	public function update_order_status( ){
		$payment_express_username = get_option( 'ec_option_payment_express_thirdparty_username' );
		$payment_express_key = get_option( 'ec_option_payment_express_thirdparty_key' );
		$response_val = $_GET['result'];
		
		$xml = "<ProcessResponse>
				  <PxPayUserId>" . $payment_express_username . "</PxPayUserId>
				  <PxPayKey>" . $payment_express_key . "</PxPayKey>
				  <Response>" . $response_val . "</Response>
				</ProcessResponse>";
		$response = $this->send_xml_request( $xml );
		$response_body = $response["body"];
		$this->process_result( $response_body );
	}
	
	private function process_result( $response_body ){
		$xml = new SimpleXMLElement( $response_body );
			
		if( isset( $_GET['order_id'] ) ){
			
			$order_id = $_GET['order_id'];
			$mysqli = new ec_db( );
			$mysqli->insert_response( $order_id, 0, "PaymentExpress Third Party", print_r( $response_body, true ) );
				
			if( $xml->Success == '1' ){ 
				
				$mysqli->update_order_status( $order_id, "10" );
				
				// send email
				$order_row = $mysqli->get_order_row( $order_id, "guest", "guest" );
				$order_display = new ec_orderdisplay( $order_row, true );
				$order_display->send_email_receipt( );
			
				// Quickbooks Hook
				if( file_exists( WP_PLUGIN_DIR . "/" . EC_QB_PLUGIN_DIRECTORY . "/ec_quickbooks.php" ) ){
					$quickbooks = new ec_quickbooks( );
					$quickbooks->add_order( $order_id );
				}
				
			} else if( $_POST['AUTHCODE'] == 'refund' ){ 
				$mysqli->update_order_status( $order_id, "16" );
			} else {
				$mysqli->update_order_status( $order_id, "8" );
			}
		}
	}
	
}
?>