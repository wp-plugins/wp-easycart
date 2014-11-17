<?php
	
class ec_canadapost{
	private $canadapost_username; 								// Your Australian Post API Key
	private $canadapost_password; 								// Your Australian Post ship from zip code
	private $canadapost_customer_number;						// String
	private $canadapost_contract_id;							// String
	private $canadapost_test_mode;								// BOOL
	
	private $canadapost_ship_from_zip;							// String
	
	private $canadapost_url;									// String
	
	function __construct( $ec_setting ){
		$this->canadapost_username = $ec_setting->get_canadapost_username( );
		$this->canadapost_password = $ec_setting->get_canadapost_password( );
		$this->canadapost_customer_number = $ec_setting->get_canadapost_customer_number( );
		$this->canadapost_contract_id = $ec_setting->get_canadapost_contract_id( );
		$this->canadapost_test_mode = $ec_setting->get_canadapost_test_mode( );
		
		$this->canadapost_ship_from_zip = $ec_setting->get_canadapost_ship_from_zip( );
		
		if( $this->canadapost_test_mode )
			$this->canadapost_url = "https://ct.soa-gw.canadapost.ca/rs/ship/price";
		else
			$this->canadapost_url = "https://soa-gw.canadapost.ca/rs/ship/price";
	}
	
	public function get_rate( $ship_code, $destination_zip, $destination_country, $weight, $length = 10, $width = 10, $height = 10 ){
		
		if( $weight == 0 )
			return "0.00";
		
		if( !$destination_country )
			$destination_country = "CA";
			
		if( !$destination_zip || $destination_zip == "" )
			$destination_zip = $this->canadapost_ship_from_zip;
		
		$xmlRequest = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			<mailing-scenario xmlns=\"http://www.canadapost.ca/ws/ship/rate-v3\">
				<customer-number>" . $this->canadapost_customer_number . "</customer-number>";
				if( $this->canadapost_contract_id ){ 
				$xmlRequest .= "
				<contract-id>" . $this->canadapost_customer_number . "</customer-number>";
				}
				$xmlRequest .= "
				<parcel-characteristics>
					<weight>" . $weight . "</weight>
					<dimensions>
						<length>" . $length . "</length>
						<width>" . $width . "</width>
						<height>" . $height . "</height>
					</dimensions>
				</parcel-characteristics>
				<services>
					<service-code>" . $ship_code . "</service-code>
				</services>
				<origin-postal-code>" . $this->format_zip_code( $this->canadapost_ship_from_zip ) . "</origin-postal-code>
				<destination>";
				if( $destination_country == "CA" ){
				$xmlRequest .= "
					<domestic>
						<postal-code>" . $this->format_zip_code( $destination_zip ) . "</postal-code>
					</domestic>";
				}else if( $destination_country == "US" ){
				$xmlRequest .= "
					<united-states>
						<zip-code>" . $this->format_zip_code( $destination_zip ) . "</zip-code>
					</united-states>";
				}else{
				$xmlRequest .= "
					<international>
						<country-code>" . $destination_country . "</country-code>
					</international>";
				}
				$xmlRequest .= "
				</destination>
			</mailing-scenario>";
			
		$headers = array( 	'Content-Type: application/vnd.cpc.ship.rate-v3+xml', 
							'Accept: application/vnd.cpc.ship.rate-v3+xml', 
							'Authorization: Basic ' . base64_encode( $this->canadapost_username . ':' . $this->canadapost_password ) );
			
		$curl = curl_init( $this->canadapost_url ); // Create REST Request
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlRequest);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl); // Execute REST Request
		curl_close($curl);
		
		return $this->process_response( $response );
		
	}
	
	public function get_all_rates( $destination_zip, $destination_country, $weight, $length = 10, $width = 10, $height = 10 ){
		
		if( $weight == 0 )
			return "0.00";
		
		if( !$destination_country )
			$destination_country = "CA";
			
		if( !$destination_zip || $destination_zip == "" )
			$destination_zip = $this->canadapost_ship_from_zip;
		
		$xmlRequest = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			<mailing-scenario xmlns=\"http://www.canadapost.ca/ws/ship/rate-v3\">
				<customer-number>" . $this->canadapost_customer_number . "</customer-number>";
				if( $this->canadapost_contract_id ){ 
				$xmlRequest .= "
				<contract-id>" . $this->canadapost_customer_number . "</customer-number>";
				}
				$xmlRequest .= "
				<parcel-characteristics>
					<weight>" . $weight . "</weight>
					<dimensions>
						<length>" . $length . "</length>
						<width>" . $width . "</width>
						<height>" . $height . "</height>
					</dimensions>
				</parcel-characteristics>
				<origin-postal-code>" . $this->format_zip_code( $this->canadapost_ship_from_zip ) . "</origin-postal-code>
				<destination>";
				if( $destination_country == "CA" ){
				$xmlRequest .= "
					<domestic>
						<postal-code>" . $this->format_zip_code( $destination_zip ) . "</postal-code>
					</domestic>";
				}else if( $destination_country == "US" ){
				$xmlRequest .= "
					<united-states>
						<zip-code>" . $this->format_zip_code( $destination_zip ) . "</zip-code>
					</united-states>";
				}else{
				$xmlRequest .= "
					<international>
						<country-code>" . $destination_country . "</country-code>
					</international>";
				}
				$xmlRequest .= "
				</destination>
			</mailing-scenario>";
			
		$headers = array( 	'Content-Type: application/vnd.cpc.ship.rate-v3+xml', 
							'Accept: application/vnd.cpc.ship.rate-v3+xml', 
							'Authorization: Basic ' . base64_encode( $this->canadapost_username . ':' . $this->canadapost_password ) );
			
		$curl = curl_init( $this->canadapost_url ); // Create REST Request
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlRequest);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl); // Execute REST Request
		curl_close($curl);
		
		return $this->process_all_rates_response( $response );
		
	}
	
	public function get_rate_test( $ship_code, $destination_zip, $destination_country, $weight ){
		
		$rate = $this->get_rate( $ship_code, $destination_zip, $destination_country, $weight );
		if( $rate != "ERROR" )
			return true;
		else
			return false;
		
	}
	
	private function process_all_rates_response( $result ){
		
		$rates = array( );
		$xml =  new SimpleXMLElement( $result );
		
		if( isset( $xml->{'price-quote'} ) ){
			for( $i=0; $i<count( $xml->{'price-quote'} ); $i++ ){
				$rates[] = array( 'rate_code' => $xml->{'price-quote'}[$i]->{'service-code'}, 'rate' => $xml->{'price-quote'}[$i]->{'price-details'}->{'due'} );
			}
		}
		return $rates;
	}
	
	private function process_response( $result ){
		
		$xml =  new SimpleXMLElement( $result );
		
		if( isset( $xml->{'price-quote'} ) )
			return $xml->{'price-quote'}[$i]->{'price-details'}->{'due'};
		else{
			error_log( "error in canada post get rate, response: " . print_r( $result, true ) );
			return "ERROR";
		}
	}
	
	public function validate_address( $desination_address, $destination_city, $destination_state, $destination_zip, $destination_country ){
		
		if( !$destination_country )
			$destination_country = "AU";
			
		if( $destination_country == "AU" )
			$shipper_url = $this->domestic_getall_shipper_url;
		else
			$shipper_url = $this->international_getall_shipper_url;
		
		$shipper_url .= "?";
		if( $destination_country == "AU" )
			$shipper_url .= "from_postcode=" . $destination_zip . "&to_postcode=" . $this->auspost_ship_from_zip . "&length=10&width=10&height=10";
		else
			$shipper_url .= "country_code=" . $destination_country;
		
		$shipper_url .= "&weight=2";
		
		$request = new WP_Http;
		$response = $request->request( $shipper_url, array( 'method' => 'GET', 'headers' => "AUTH-KEY:" . $this->auspost_api_key ) );
		
		
		if( is_wp_error( $response ) ){
			$error_message = $response->get_error_message();
			error_log( "error in australian post get rate, " . $error_message );
			return true;
		}else{
			$xml = json_decode( $response['body'] );
			
			if( isset( $xml->error ) )
				return false;
			else
				return true;
				
		}
		
	}
	
	private function format_zip_code( $zip ){
		return( str_replace( ' ', '', strtoupper( $zip ) ) );
	}
}
	
?>