<?php
	
class ec_usps{
	private $usps_user_name;									// Your USPS user name
	private $usps_ship_from_zip;								// Your USPS ship from zip code
	private $shipper_url;										// String

	function __construct( $ec_setting ){
		$this->usps_user_name = $ec_setting->get_usps_user_name();
		$this->usps_ship_from_zip = $ec_setting->get_usps_ship_from_zip();	
		
		if( isset( $_SERVER['HTTPS'] ) )
			$this->shipper_url = "https://secure.shippingapis.com/ShippingAPI.dll";
		else
			$this->shipper_url = "http://production.shippingapis.com/ShippingAPI.dll";
	}
		
	public function get_rate( $ship_code, $destination_zip, $weight ){
		
		if( $weight == 0 )
		return "0.00";
		
		$rate_codes = array( 	"PRIORITY" => 1, 
									"PRIORITY COMMERCIAL" => 1, 
									"PRIORITY CPP" => 1, 
									"PRIORITY HFP COMMERCIAL" => 33, 
									"PRIORITY HFP CPP" => 33, 
									"EXPRESS" => 3, 
									"EXPRESS COMMERCIAL" => 3, 
									"EXPRESS CPP" => 3,
									"EXPRESS SH" => 23,  
									"EXPRESS SH COMMERCIAL" => 23, 
									"EXPRESS HFP CPP" => 2, 
									"STANDARD POST" => 4, 
									"MEDIA" =>6, 
									"LIBRARY" => 7, 
									"ALL" => 7, 
									"ONLINE" => 7, 
									"PLUS" => 7 );
									
		$rate_type = strtoupper( $ship_code );
		$rate_code = $rate_codes[$rate_type];
		
		if( $weight == 0 ){
			return 0.00;
		}else{
		
			$shipper_data = $this->get_shipper_data( $rate_type, $destination_zip, $weight );
			$request = new WP_Http;
			$response = $request->request( $this->shipper_url, array( 'method' => 'POST', 'body' => $shipper_data ) );
			if( is_wp_error( $response ) ){
				$error_message = $response->get_error_message();
				error_log( "error in usps get rate, " . $error_message );
				return false;
			}else{
				return $this->process_response( $response['body'], $rate_code );
			}
			
		}
	}
	
	private function get_shipper_data( $ship_code, $destination_zip, $weight ){
		$shipper_data = "API=RateV4&XML=<RateV4Request USERID=\"" . $this->usps_user_name . "\">
				<Revision/>
				<Package ID=\"1ST\">
					<Service>" . $ship_code . "</Service>
					<ZipOrigination>" . $this->usps_ship_from_zip . "</ZipOrigination>
					<ZipDestination>" . $destination_zip . "</ZipDestination>
					<Pounds>" . $weight . "</Pounds>
					<Ounces>0</Ounces>
					<Container/>
					<Size>REGULAR</Size>
					<Machinable>true</Machinable>
				</Package>
				</RateV4Request>";
		return $shipper_data;
	}
	
	private function process_response( $result, $rate_code ){
		$xml = new SimpleXMLElement($result);
		if( $xml && $xml->Package && $xml->Package[0] && $xml->Package[0]->Postage && $xml->Package[0]->Postage->Rate && $xml->Package[0]->Postage->Rate[0] )
			$rate = $xml->Package[0]->Postage->Rate[0];
		else
			$rate = "ERROR";
		
		if( $rate )
			return $rate;
		else{
			error_log( "error in usps get rate, response: " . $result );
			return "ERROR";
		}
	}
}	
?>