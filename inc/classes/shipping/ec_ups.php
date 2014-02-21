<?php
	
class ec_ups{
	private $ups_access_license_number; 						// Your UPS license number
	private $ups_user_id; 										// Your UPS user id
	private $ups_password; 										// Your UPS password
	private $ups_ship_from_zip; 								// Your UPS ship from zip code
	private $ups_shipper_number; 								// Your UPS shipper number
	private $ups_country_code;									// Your UPS country code
	private $ups_weight_type;									// Your UPS weight type
	private $ups_conversion_rate;								// A Conversion Rate
	
	private $shipper_url;										// String
	
	function __construct( $ec_setting ){
		$this->ups_access_license_number = $ec_setting->get_ups_access_license_number( );
		$this->ups_user_id = $ec_setting->get_ups_user_id( );
		$this->ups_password = $ec_setting->get_ups_password( );
		$this->ups_ship_from_zip = $ec_setting->get_ups_ship_from_zip( );
		$this->ups_shipper_number = $ec_setting->get_ups_shipper_number( );
		$this->ups_country_code = $ec_setting->get_ups_country_code( );
		$this->ups_weight_type = $ec_setting->get_ups_weight_type( );
		$this->ups_conversion_rate = $ec_setting->get_ups_conversion_rate( );
		
		$this->shipper_url = "https://www.ups.com/ups.app/xml/Rate";
	}
	
	public function get_rate( $ship_code, $destination_zip, $destination_country, $weight ){
		if( $weight == 0 )
		return "0.00";
		
		if( !$destination_country )
			$destination_country = $this->ups_country_code;
		
		$shipper_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight );
		$request = new WP_Http;
		$response = $request->request( $this->shipper_url, array( 'method' => 'POST', 'body' => $shipper_data ) );
		if( is_wp_error( $response ) ){
			$error_message = $response->get_error_message();
			error_log( "error in ups get rate, " . $error_message );
			return false;
		}else
			return $this->process_response( $response['body'] );
		
	}
	
	public function get_rate_test( $ship_code, $destination_zip, $destination_country, $weight ){
		if( $weight == 0 )
		return "0.00";
		
		if( !$destination_country )
			$destination_country = $this->ups_country_code;
		
		$shipper_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight );
		$request = new WP_Http;
		$response = $request->request( $this->shipper_url, array( 'method' => 'POST', 'body' => $shipper_data ) );
		if( is_wp_error( $response ) ){
			$error_message = $response->get_error_message();
			error_log( "error in ups get rate, " . $error_message );
			return false;
		}else
			return $response['body'];
		
	}
	
	private function get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight ){
		$shipper_data = "<?xml version=\"1.0\"?>
			<AccessRequest xml:lang=\"en-US\">
				<AccessLicenseNumber>$this->ups_access_license_number</AccessLicenseNumber>
				<UserId>$this->ups_user_id</UserId>
				<Password>$this->ups_password</Password>
			</AccessRequest>
			<?xml version=\"1.0\"?>
			<RatingServiceSelectionRequest xml:lang=\"en-US\">
				<Request>
					<TransactionReference>
						<CustomerContext>Rate Request</CustomerContext>
						<XpciVersion>1.0001</XpciVersion>
					</TransactionReference>
					<RequestAction>Rate</RequestAction>
					<RequestOption>Rate</RequestOption>
				</Request>
			<PickupType>
				<Code>01</Code>
			</PickupType>
			<Shipment>
				<Shipper>
					<Address>
						<PostalCode>$this->ups_ship_from_zip</PostalCode>
						<CountryCode>$this->ups_country_code</CountryCode>
					</Address>
				<ShipperNumber>$this->ups_shipper_number</ShipperNumber>
				</Shipper>
				<ShipTo>
					<Address>
						<PostalCode>$destination_zip</PostalCode>
						<CountryCode>$destination_country</CountryCode>
					<ResidentialAddressIndicator/>
					</Address>
				</ShipTo>
				<ShipFrom>
					<Address>
						<PostalCode>$this->ups_ship_from_zip</PostalCode>
						<CountryCode>$this->ups_country_code</CountryCode>
					</Address>
				</ShipFrom>
				<Service>
					<Code>$ship_code</Code>
				</Service>
				<Package>
					<PackagingType>
						<Code>02</Code>
					</PackagingType>
					<PackageWeight>
						<UnitOfMeasurement>
							<Code>$this->ups_weight_type</Code>
						</UnitOfMeasurement>
						<Weight>$weight</Weight>
					</PackageWeight>
				</Package>
			</Shipment>
			</RatingServiceSelectionRequest>";
		return $shipper_data;
	}
	
	private function process_response( $result ){
		$xml = new SimpleXMLElement($result);
		if( $xml && $xml->RatedShipment && $xml->RatedShipment->TotalCharges && $xml->RatedShipment->TotalCharges->MonetaryValue )
			$rate = $xml->RatedShipment->TotalCharges->MonetaryValue;
		else
			$rate = "ERROR";
			
		if( isset( $rate ) ){
			$rate = floatval( $rate );
			return ( $rate * $this->ups_conversion_rate );
		}else{
			error_log( "error in ups get rate, response: " . $result );
			return "ERROR";	
		}
	}
}
	
?>