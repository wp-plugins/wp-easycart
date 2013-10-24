<?php
	
class ec_dhl{
	
	private $dhl_site_id;												// Your DHL Site ID
	private $dhl_password;												// Your DHL Password
	private $dhl_ship_from_country;										// Your DHL Country
	private $dhl_ship_from_zip;											// Your DHL Zip
	private $dhl_weight_unit;											// Your DHL Weight Unit

	function __construct( $ec_setting ){
		$this->dhl_site_id = $ec_setting->get_dhl_site_id( );
		$this->dhl_password = $ec_setting->get_dhl_password( );	
		$this->dhl_ship_from_country = $ec_setting->get_dhl_ship_from_country( );
		$this->dhl_ship_from_zip = $ec_setting->get_dhl_ship_from_zip( );
		$this->dhl_weight_unit = $ec_setting->get_dhl_weight_unit( );
		$this->dhl_test_mode = $ec_setting->get_dhl_test_mode( );
		
		if( $this->dhl_test_mode )
			$this->shipper_url = "https://xmlpitest-ea.dhl.com/XMLShippingServlet";
		else
			$this->shipper_url = "https://xmlpi-ea.dhl.com/XMLShippingServlet";
	}
		
	public function get_rate( $ship_code, $destination_zip, $destination_country, $weight ){
		
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = "US";
		
		$ship_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight );
		
		$ch = curl_init(); //initiate the curl session 
		curl_setopt($ch, CURLOPT_URL, $this->shipper_url); //set to url to post to
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable 
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $ship_data ); // post the xml 
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30); // set timeout in seconds 
		$response = curl_exec($ch);
		curl_close ($ch); 
		
		return $this->process_response( $response, $ship_code );
		
	}
	
	public function get_rate_test( $ship_code, $destination_zip, $destination_country, $weight ){
		
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = "US";
		
		$ship_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight );
		
		$ch = curl_init(); //initiate the curl session 
		curl_setopt( $ch, CURLOPT_URL, $this->shipper_url ); //set to url to post to
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); // tell curl to return data in a variable 
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_POST, true ); 
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $ship_data ); // post the xml 
		curl_setopt( $ch, CURLOPT_TIMEOUT, ( int )30 ); // set timeout in seconds 
		$response = curl_exec( $ch );
		curl_close( $ch ); 
		
		return $response;
		
	}
	
	private function get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight ){
		
		if( $destination_country == $this->dhl_ship_from_country )
			$is_dutiable = "N";
		else
			$is_dutiable = "Y";
		
		$shipper_data = '<?xml version="1.0" encoding="UTF-8"?>
						<p:DCTRequest xmlns:p="http://www.dhl.com" xmlns:p1="http://www.dhl.com/datatypes" xmlns:p2="http://www.dhl.com/DCTRequestdatatypes" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com DCT-req.xsd ">
						  <GetQuote>
							<Request>
							  <ServiceHeader>
								<MessageTime>'.date('c').'</MessageTime>
								<MessageReference>1234567890123456789012345678901</MessageReference>
								<SiteID>' . $this->dhl_site_id . '</SiteID>
								<Password>' . $this->dhl_password . '</Password>
							  </ServiceHeader>
							</Request>
							<From>
							  <CountryCode>' . $this->dhl_ship_from_country . '</CountryCode>
							  <Postalcode>' . $this->dhl_ship_from_zip . '</Postalcode>
							</From>
							<BkgDetails>
							  <PaymentCountryCode>' . $destination_country . '</PaymentCountryCode>
							  <Date>2011-06-06</Date>
							  <ReadyTime>PT10H21M</ReadyTime>
									<ReadyTimeGMTOffset>+00:00</ReadyTimeGMTOffset>
									<DimensionUnit>IN</DimensionUnit>
							  		<WeightUnit>' . $this->dhl_weight_unit . '</WeightUnit>
									<Pieces><Piece>
										<PieceID>1</PieceID>
										<Weight>' . $weight . '</Weight>
									</Piece></Pieces>
									<IsDutiable>' . $is_dutiable . '</IsDutiable>
									<NetworkTypeCode>AL</NetworkTypeCode>
								</BkgDetails>
								<To>
									<CountryCode>' . $destination_country . '</CountryCode>
							  		<Postalcode>' . $destination_zip . '</Postalcode>
							  		<City>London</City>
								</To>';
		if( $is_dutiable == "Y" ){
		$shipper_data .= '
								<Dutiable>
									<DeclaredCurrency>USD</DeclaredCurrency>
									<DeclaredValue>10</DeclaredValue>
								</Dutiable>';
		}
		$shipper_data .= '						       
							</GetQuote>
						</p:DCTRequest>';
		
		return $shipper_data;
	}
	
	private function process_response( $result, $rate_code ){
		
		$xml = new SimpleXMLElement($result);
		
		if( $xml && $xml->GetQuoteResponse && $xml->GetQuoteResponse->BkgDetails && $xml->GetQuoteResponse->BkgDetails->QtdShp ){
			if( count( $xml->GetQuoteResponse->BkgDetails->QtdShp ) > 1 ){
				$rate = "ERROR";
				for( $i=0; $i<count( $xml->GetQuoteResponse->BkgDetails->QtdShp ); $i++ ){
					if( $xml->GetQuoteResponse->BkgDetails->QtdShp[$i]->ProductShortName == $this->get_product_name( $rate_code ) ){
						$rate = $xml->GetQuoteResponse->BkgDetails->QtdShp[$i]->ShippingCharge;
					}
				}
			}else{
				if( $xml->GetQuoteResponse->BkgDetails->QtdShp->ProductShortCode == $this->get_product_name( $rate_code ) )
					$rate = $xml->GetQuoteResponse->BkgDetails->QtdShp->TotalAmount;
				else
					$rate = "ERROR";
			}
		}else{
			$rate = "ERROR";
		}
		
		if( $rate )
			return $rate;
		else{
			error_log( "error in DHL get rate, response: " . $result );
			return "ERROR";
		}
	}
	
	private function get_product_name( $rate_code ){
		//--------------------------
		// DHL product codes
		//--------------------------
		switch( $rate_code ){
			case '0':
				return "LOGISTICS SERVICES";
				break;
			case '1':
				return "DOMESTIC EXPRESS 12:00";
				break;
			case '2':
				return "B2C";
				break;
			case '3':
				return "B2C";
				break;
			case '4':
				return "JETLINE";
				break;
			case '5':
				return "SPRINTLINE";
				break;
			case '6':
				return "SECURELINE";
				break;
			case '7':
				return "EXPRESS EASY";
				break;
			case '8':
				return "EXPRESS EASY";
				break;
			case '9':
				return "EUROPACK";
				break;
			case 'A':
				return "AUTO REVERSALS";
				break;
			case 'B':
				return "BREAK BULK EXPRESS";
				break;
			case 'C':
				return "MEDICAL EXPRESS";
				break;
			case 'D':
				return "EXPRESS WORLDWIDE";
				break;
			case 'E':
				return "EXPRESS 9:00";
				break;
			case 'F':
				return "FREIGHT WORLDWIDE";
				break;
			case 'G':
				return "DOMESTIC ECONOMY SELECT";
				break;
			case 'H':
				return "ECONOMY SELECT";
				break;
			case 'I':
				return "BREAK BULK ECONOMY";
				break;
			case 'J':
				return "JUMBO BOX";
				break;
			case 'K':
				return "EXPRESS 9:00";
				break;
			case 'L':
				return "EXPRESS 10:30";
				break;
			case 'M':
				return "EXPRESS 10:30";
				break;
			case 'N':
				return "DOMESTIC EXPRESS";
				break;
			case 'O':
				return "DOM EXPRESS 10:30";
				break;
			case 'P':
				return "";
				break;
			case 'U':
				return "EXPRESS WORLDWIDE";
				break;
			case 'Q':
				return "MEDICAL EXPRESS";
				break;
			case 'R':
				return "GLOBALMAIL BUSINESS";
				break;
			case 'S':
				return "SAME DAY";
				break;
			case 'T':
				return "EXPRESS 12:00";
				break;
			case 'V':
				return "EUROPACK";
				break;
			case 'W':
				return "ECONOMY SELECT";
				break;
			case 'X':
				return "EXPRESS ENVELOPE";
				break;
			case 'Y':
				return "EXPRESS 12:00";
				break;
			case 'Z':
				return "Destination Charges";
				break;
		}
	}
}	
?>