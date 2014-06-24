<?php
	
class ec_usps{
	
	private $usps_user_name;									// Your USPS user name
	private $usps_ship_from_zip;								// Your USPS ship from zip code
	private $shipper_url;										// String
	private $use_international;									// BOOL

	function __construct( $ec_setting ){
		$this->usps_user_name = $ec_setting->get_usps_user_name();
		$this->usps_ship_from_zip = $ec_setting->get_usps_ship_from_zip();	
		
		//if( isset( $_SERVER['HTTPS'] ) )
			//$this->shipper_url = "https://secure.shippingapis.com/ShippingAPI.dll";
		//else
			$this->shipper_url = "http://production.shippingapis.com/ShippingAPI.dll";
	}
		
	public function get_rate( $ship_code, $destination_zip, $destination_country, $weight ){
		
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = "US";
		
		if( $destination_country != "US" ){
			
			$rate_codes = array(	"ALL" => "All",
									"FIRST CLASS" => "PARCEL",
									"FIRST CLASS COMMERCIAL" => "PARCEL",
									"FIRST CLASS HFP COMMERCIAL" => "PARCEL",
									"PACKAGE" => "Package",
									"POSTCARDS" => "Postcards",
									"ENVELOPE" => "Envelope",
									"LARGEENVELOPE" => "LargeEnvelope",
									"FLATRATE" => "FlatRate",
									"PRIORITY" => 1, 
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
									"ONLINE" => 7, 
									"PLUS" => 7
								);
		}else{
			
			$rate_codes = array( 	"PRIORITY" => 1, 
									"FIRST CLASS" => "PARCEL",
									"FIRST CLASS COMMERCIAL" => "PARCEL",
									"FIRST CLASS HFP COMMERCIAL" => "PARCEL",
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
									"PLUS" => 7,
									"PACKAGE" => "Package",
									"POSTCARDS" => "Postcards",
									"ENVELOPE" => "Envelope",
									"LARGEENVELOPE" => "LargeEnvelope",
									"FLATRATE" => "FlatRate",
									
								);
		}
									
		$rate_type = strtoupper( $ship_code );
		$rate_code = $rate_codes[$rate_type];
		$ship_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight );
		
		
		$ch = curl_init(); //initiate the curl session 
		curl_setopt($ch, CURLOPT_URL, $this->shipper_url); //set to url to post to
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true); 
		if( $this->use_international )
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=IntlRateV2&XML=' . urlencode( $ship_data ) ); // post the xml 
		else
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=RateV4&XML=' . urlencode( $ship_data ) ); // post the xml 
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30); // set timeout in seconds 
		$response = curl_exec($ch);
		curl_close ($ch); 
	
		return $this->process_response( $response, $rate_code );
		
	}
		
	public function get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height ){
		
		if( strlen( $destination_zip ) <= 0 )
			$destination_zip = $this->usps_ship_from_zip;
		
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = "US";
		
		$ship_data = $this->get_all_rates_shipper_data( $destination_zip, $destination_country, $weight, $length, $width, $height );
		
		
		$ch = curl_init(); //initiate the curl session 
		curl_setopt($ch, CURLOPT_URL, $this->shipper_url); //set to url to post to
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true); 
		if( $this->use_international )
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=IntlRateV2&XML=' . urlencode( $ship_data ) ); // post the xml 
		else
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=RateV4&XML=' . urlencode( $ship_data ) ); // post the xml 
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30); // set timeout in seconds 
		$response = curl_exec($ch);
		curl_close ($ch); 
	
		return $this->process_all_rates_response( $response );
		
	}
	
	public function get_rate_test( $ship_code, $destination_zip, $destination_country, $weight ){
		
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = "US";
		
		if( $destination_country != "US" ){
			
			$rate_codes = array(	"ALL" => "All",
									"FIRST CLASS" => "PARCEL",
									"FIRST CLASS COMMERCIAL" => "PARCEL",
									"FIRST CLASS HFP COMMERCIAL" => "PARCEL",
									"PACKAGE" => "Package",
									"POSTCARDS" => "Postcards",
									"ENVELOPE" => "Envelope",
									"LARGEENVELOPE" => "LargeEnvelope",
									"FLATRATE" => "FlatRate",
									"PRIORITY" => 1, 
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
									"ONLINE" => 7, 
									"PLUS" => 7
								);
		}else{
			
			$rate_codes = array( 	"PRIORITY" => 1, 
									"FIRST CLASS" => "PARCEL",
									"FIRST CLASS COMMERCIAL" => "PARCEL",
									"FIRST CLASS HFP COMMERCIAL" => "PARCEL",
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
									"PLUS" => 7,
									"PACKAGE" => "Package",
									"POSTCARDS" => "Postcards",
									"ENVELOPE" => "Envelope",
									"LARGEENVELOPE" => "LargeEnvelope",
									"FLATRATE" => "FlatRate",
									
								);
		}
							
		$rate_type = strtoupper( $ship_code );
		$rate_code = $rate_codes[$rate_type];
		$ship_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight );
		
		$ch = curl_init(); //initiate the curl session 
		curl_setopt($ch, CURLOPT_URL, $this->shipper_url); //set to url to post to
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true); 
		if( $this->use_international )
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=IntlRateV2&XML=' . urlencode( $ship_data ) ); // post the xml 
		else
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=RateV4&XML=' . urlencode( $ship_data ) ); // post the xml 
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30); // set timeout in seconds 
		$response = curl_exec($ch);
		curl_close ($ch); 
		
		return $response;
		
	}
	
	private function get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight ){
				
		$lbs = floor( $weight );
		$ounces = floor( 16 * ( $weight - $lbs  ) );
		
		if( $destination_country != "US" ){
			$db = new ec_db( );
			$country_name = $db->get_country_name( $destination_country );
			$this->use_international = true;
				
			$shipper_data = "<IntlRateV2Request USERID='" . $this->usps_user_name . "' >
							<Revision>2</Revision>
							<Package ID='1ST' >
								<Pounds>" . $lbs . "</Pounds>
								<Ounces>" . $ounces . "</Ounces>
								<Machinable>true</Machinable>
								<MailType>" . $ship_code . "</MailType>
								<GXG>
									<POBoxFlag>N</POBoxFlag>
									<GiftFlag>N</GiftFlag>
								</GXG>
								<ValueOfContents>10.00</ValueOfContents>
								<Country>" . $country_name . "</Country>
								<Container>RECTANGULAR</Container>
								<Size>REGULAR</Size>
								<Width>1</Width>
								<Length>1</Length>
								<Height>1</Height>
								<Girth>1</Girth>
								<OriginZip>" . $this->usps_ship_from_zip . "</OriginZip>
							</Package>
						</IntlRateV2Request>";
			
		}else{
		
			$this->use_international = false;
			$shipper_data = "<RateV4Request USERID='" . $this->usps_user_name . "' >
							<Revision/>
							<Package ID='1ST' >
								<Service>" . $ship_code . "</Service>
								<ZipOrigination>" . $this->usps_ship_from_zip . "</ZipOrigination>
								<ZipDestination>" . $destination_zip . "</ZipDestination>
								<Pounds>" . $lbs . "</Pounds>
								<Ounces>" . $ounces . "</Ounces>
								<Container/>
								<Size>REGULAR</Size>
								<Machinable>true</Machinable>
							</Package>
						</RateV4Request>";
						
		}
		
		return $shipper_data;
	}
	
	private function get_all_rates_shipper_data( $destination_zip, $destination_country, $weight, $length, $width, $height ){
				
		$lbs = floor( $weight );
		$ounces = floor( 16 * ( $weight - $lbs  ) );
		
		if( $destination_country != "US" ){
			$db = new ec_db( );
			$country_name = $db->get_country_name( $destination_country );
			$this->use_international = true;
				
			$shipper_data = "<IntlRateV2Request USERID='" . $this->usps_user_name . "' >
							<Revision>2</Revision>
							<Package ID='1ST' >
								<Pounds>" . $lbs . "</Pounds>
								<Ounces>" . $ounces . "</Ounces>
								<Machinable>true</Machinable>
								<MailType>ALL</MailType>
								<GXG>
									<POBoxFlag>N</POBoxFlag>
									<GiftFlag>N</GiftFlag>
								</GXG>
								<ValueOfContents>10.00</ValueOfContents>
								<Country>" . $country_name . "</Country>
								<Container>RECTANGULAR</Container>
								<Size>REGULAR</Size>
								<Width>" . $width . "</Width>
								<Length>" . $length . "</Length>
								<Height>" . $height . "</Height>
								<Girth>1</Girth>
								<OriginZip>" . $this->usps_ship_from_zip . "</OriginZip>
							</Package>
						</IntlRateV2Request>";
			
		}else{
		
			$this->use_international = false;
			$shipper_data = "<RateV4Request USERID='" . $this->usps_user_name . "' >
							<Revision/>
							<Package ID='1ST' >
								<Service>ALL</Service>
								<ZipOrigination>" . $this->usps_ship_from_zip . "</ZipOrigination>
								<ZipDestination>" . $destination_zip . "</ZipDestination>
								<Pounds>" . $lbs . "</Pounds>
								<Ounces>" . $ounces . "</Ounces>
								<Container/>
								<Size>REGULAR</Size>
								<Machinable>true</Machinable>
							</Package>
						</RateV4Request>";
						
		}
		
		return $shipper_data;
	}
	
	private function process_response( $result, $rate_code ){
		
		$xml = new SimpleXMLElement($result);
		
		if( $this->use_international ){
			if( $xml && $xml->Package && $xml->Package[0] && $xml->Package[0]->Service && $xml->Package[0]->Service[0] ){
				for( $i=0; $i<count( $xml->Package[0]->Service ); $i++ ){
					$rate = $xml->Package[0]->Service[$i]->Postage;
				}
			}else
				$rate = "ERROR";
				
		}else{
			if( $rate_code != 7 && $xml && $xml->Package && $xml->Package[0] && $xml->Package[0]->Postage && $xml->Package[0]->Postage[0] && $xml->Package[0]->Postage[0]->Rate )
				$rate = $xml->Package[0]->Postage[0]->Rate;
			else
				$rate = "ERROR";
				
		}
		
		if( $rate )
			return $rate;
		else{
			error_log( "error in usps get rate, response: " . $result );
			return "ERROR";
		}
	}
	
	private function process_all_rates_response( $result ){
		
		$rates = array( );
		$xml = new SimpleXMLElement($result);
		
		if( $this->use_international ){
			
			$min_rate = (float) 99999.99;
			
			foreach( $xml->Package->Service as $service ){
				
				if( (float) $service->Postage < $min_rate )
					$min_rate = $service->Postage;
				
			}
			
			if( $min_rate == 99999.99 )
				$rates[] = array( 'rate_code' => 'ALL', 'rate' => 0.00 );
			else
				$rates[] = array( 'rate_code' => 'ALL', 'rate' => $min_rate );
					
		}else{
			$rate_codes = array(	"1" => "PRIORITY",
									"33" => "PRIORITY HFP COMMERCIAL", 
									"3" => "EXPRESS",
									"23" => "EXPRESS SH",   
									"2" => "EXPRESS HFP CPP", 
									"4" => "STANDARD POST", 
									"6" => "MEDIA", 
									"7" => "LIBRARY"
								);
								
			
			for( $i=0; $i<count( $xml->Package->Postage ); $i++ ){
				$rate_id = $xml->Package->Postage[$i]['CLASSID'];
				if( isset( $rate_codes[ strval( $rate_id ) ] ) ){
					$rates[] = array( 'rate_code' => $rate_codes[ strval( $rate_id ) ], 'rate' => $xml->Package->Postage[$i]->Rate );
				}
			
			}
				
		}
		
		return $rates;
	}
	
	public function validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country ){
		
		$ship_code = 'ALL';
		$ship_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, 5 );
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->shipper_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true); 
		if( $destination_country != 'US' )
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=IntlRateV2&XML=' . urlencode( $ship_data ) );
		else
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'API=RateV4&XML=' . urlencode( $ship_data ) ); 
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30); 
		$response = curl_exec($ch);
		curl_close ($ch); 
		
		$xml = new SimpleXMLElement( $response );
		if( isset( $xml->Package ) && isset( $xml->Package->Error ) ){
			return false;
			
		}else{
			return true;
		}
		
	}
	
}	
?>