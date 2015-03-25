<?php
	
class ec_fedex{
	private $fedex_key;											// Your FedEx Account Key
	private $fedex_account_number;								// Your FedEx Account Number
	private $fedex_meter_number;								// Your FedEx Meter Number
	private $fedex_password;									// Your FedEx Password
	private $fedex_ship_from_zip;								// Your FedEx ship from zip code
	private $fedex_weight_units;								// The weight units to use for the FedEx api
	private $fedex_country_code;								// The country code for the FedEx api
	private $fedex_conversion_rate;								// A conversion rate option
	private $fedex_test_account;								// Is this is a FedEx test account
	
	private $shipper_url;										// String

	function __construct( $ec_setting ){
		$this->fedex_key = $ec_setting->get_fedex_key( );
		$this->fedex_account_number = $ec_setting->get_fedex_account_number();
		$this->fedex_meter_number = $ec_setting->get_fedex_meter_number();
		$this->fedex_password = $ec_setting->get_fedex_password();
		$this->fedex_ship_from_zip = $ec_setting->get_fedex_ship_from_zip();
		$this->fedex_weight_units = $ec_setting->get_fedex_weight_units();
		$this->fedex_country_code = $ec_setting->get_fedex_country_code();	
		$this->fedex_conversion_rate = $ec_setting->get_fedex_conversion_rate();
		$this->fedex_test_account = $ec_setting->get_fedex_test_account();
	}
		
	public function get_rate( $ship_code, $destination_zip, $destination_country, $weight ){
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = $this->fedex_country_code;
			
		if( !$destination_zip || $destination_zip == "" )
			$destination_zip = $this->fedex_ship_from_zip;
		
		$service_type = strtoupper( $ship_code );
		
		$service_types = array( 	"EUROPE_FIRST_INTERNATIONAL_PRIORITY", 
									"FEDEX_1_DAY_FREIGHT", 
									"FEDEX_2_DAY", 
									"FEDEX_2_DAY_AM", 
									"FEDEX_2_DAY_FREIGHT", 
									"FEDEX_3_DAY_FREIGHT",
									"FEDEX_EXPRESS_SAVER",
									"FEDEX_FIRST_FREIGHT",
									"FEDEX_FREIGHT_ECONOMY",
									"FEDEX_FREIGHT_PRIORITY",
									"FEDEX_GROUND",
									"FIRST_OVERNIGHT",
									"GROUND_HOME_DELIVERY",
									"INTERNATIONAL_ECONOMY",
									"INTERNATIONAL_ECONOMY_FREIGHT",
									"INTERNATIONAL_FIRST",
									"INTERNATIONAL_PRIORITY",
									"INTERNATIONAL_PRIORITY_FREIGHT",
									"PRIORITY_OVERNIGHT",
									"SMART_POST",
									"STANDARD_OVERNIGHT" );
		
		if( in_array( $service_type, $service_types ) ){
			
			if( $this->fedex_test_account ){
				$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v16_test_account.wsdl";
			}else{
				$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v16.wsdl";
			}
	
			ini_set("soap.wsdl_cache_enabled", "0");
			 
			$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
			
			$request['WebAuthenticationDetail'] = array(
				'UserCredential' =>array(
					'Key' => $this->fedex_key, 
					'Password' => $this->fedex_password
				)
			); 
			$request['ClientDetail'] = array(
				'AccountNumber' => $this->fedex_account_number, 
				'MeterNumber' => $this->fedex_meter_number
			);
			$request['TransactionDetail'] = array( 'CustomerTransactionId' => ' *** Rate Request v16 using PHP ***' );
			$request['Version'] = array(
				'ServiceId' => 'crs', 
				'Major' => '16', 
				'Intermediate' => '0', 
				'Minor' => '0'
			);
			$request['ReturnTransitAndCommit'] = true;
			$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
			$request['RequestedShipment']['ShipTimestamp'] = date( 'c' );
			$request['RequestedShipment']['ServiceType'] = $service_type; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
			$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
			
			$shipper = array( 'Address' => array( 'PostalCode' => $this->fedex_ship_from_zip, 'CountryCode' => $this->fedex_country_code ) );
			$request['RequestedShipment']['Shipper'] = $shipper;
			
			$recipient = array( 'Address' => array( 'PostalCode' => $destination_zip, 'CountryCode' => $destination_country, 'Residential' => false ) );
			$request['RequestedShipment']['Recipient'] = $recipient;
			
			$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
			$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
			$request['RequestedShipment']['PackageCount'] = '1';
			
			$packageLineItem = array( 'SequenceNumber'=>1, 'GroupPackageCount'=>1, 'Weight' => array( 'Value' => $weight, 'Units' => $this->fedex_weight_units ) );
			$request['RequestedShipment']['RequestedPackageLineItems'] = $packageLineItem;
			
			try{
				$response = $client->getRates($request);
					
				if( $response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR' ){  	
					$rateReply = $response->RateReplyDetails;
					$serviceType = $rateReply->ServiceType;
					
					$payor_account_package = 0.000;
					$rated_account_package = 0.000;
					$payor_list_package = 0.000;
					$rated_list_package = 0.000;
					$rate_other = 0.000;
					
					if( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "PAYOR_ACCOUNT_PACKAGE" ){
						$payor_account_package = number_format( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else if( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "RATED_ACCOUNT_PACKAGE" ){
						$rated_account_package = number_format( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else if( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "PAYOR_LIST_PACKAGE" ){
						$payor_list_package = number_format( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else if( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "RATED_LIST_PACKAGE" ){
						$rated_list_package = number_format( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else{
						$rate_other = number_format( $response->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}
						
					if( $payor_account_package > 0 ){
						$amount = $payor_account_package;
					}else if( $rated_account_package > 0 ){
						$amount = $rated_account_package;
					}else if( $payor_list_package > 0 ){
						$amount = $payor_list_package;
					}else if( $rated_list_package > 0 ){
						$amount = $rated_list_package;
					}else {
						$amount = $rate_other;
					}
					
					$rate = floatval( $amount );
					return ( $rate * $this->fedex_conversion_rate );
				}else{
			  		error_log( "error in fedex get rate, " . $this->printError($client, $response) );
					return "ERROR";
				}
			}catch (SoapFault $exception){
			  error_log( "error in fedex get rate, " . $this->printFault($exception, $client) );
			  return "ERROR";        
			}	
		
		}
	}
		
	public function get_all_rates( $destination_zip, $destination_country, $weight, $length = 10, $width = 10, $height = 10 ){
		
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = $this->fedex_country_code;
			
		if( !$destination_zip || $destination_zip == "" )
			$destination_zip = $this->fedex_ship_from_zip;
		
		if( $this->fedex_test_account ){
			$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v16_test_account.wsdl";
		}else{
			$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v16.wsdl";
		}

		ini_set("soap.wsdl_cache_enabled", "0");
		 
		$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
		
		$request['WebAuthenticationDetail'] = array(
			'UserCredential' =>array(
				'Key' => $this->fedex_key, 
				'Password' => $this->fedex_password
			)
		); 
		$request['ClientDetail'] = array(
			'AccountNumber' => $this->fedex_account_number, 
			'MeterNumber' => $this->fedex_meter_number
		);
		$request['TransactionDetail'] = array( 'CustomerTransactionId' => ' *** Rate Request v16 using PHP ***' );
		$request['Version'] = array(
			'ServiceId' => 'crs', 
			'Major' => '16', 
			'Intermediate' => '0', 
			'Minor' => '0'
		);
		$request['ReturnTransitAndCommit'] = true;
		$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
		$request['RequestedShipment']['ShipTimestamp'] = date( 'c' );
		$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
		
		$shipper = array( 'Address' => array( 'PostalCode' => $this->fedex_ship_from_zip, 'CountryCode' => $this->fedex_country_code ) );
		$request['RequestedShipment']['Shipper'] = $shipper;
		
		$recipient = array( 'Address' => array( 'PostalCode' => $destination_zip, 'CountryCode' => $destination_country, 'Residential' => false ) );
		$request['RequestedShipment']['Recipient'] = $recipient;
		
		$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
		$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
		$request['RequestedShipment']['PackageCount'] = '1';
		
		$packageLineItem = array( 'SequenceNumber'=>1, 'GroupPackageCount'=>1, 'Weight' => array( 'Value' => $weight, 'Units' => $this->fedex_weight_units ) );
		$request['RequestedShipment']['RequestedPackageLineItems'] = $packageLineItem;
		
		try{
			$response = $client->getRates($request);
			
			if( $response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR' ){ 	
				
				if( $response->HighestSeverity == 'WARNING' && $response->Notifications->Code == 556 ){
					return "ERROR";
				} 	
				
				$rates = array( );
				
				for( $i=0; $i<count( $response->RateReplyDetails ); $i++ ){
					$code = $response->RateReplyDetails[$i]->ServiceType;
					$rate = 0.000;
					$payor_account_package = 0.000;
					$rated_account_package = 0.000;
					$payor_list_package = 0.000;
					$rated_list_package = 0.000;
					$rate_other = 0.000;
					
					if( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "PAYOR_ACCOUNT_PACKAGE" ){
						$payor_account_package = number_format( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else if( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "RATED_ACCOUNT_PACKAGE" ){
						$rated_account_package = number_format( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else if( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "PAYOR_LIST_PACKAGE" ){
						$payor_list_package = number_format( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else if( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->RateType == "RATED_LIST_PACKAGE" ){
						$rated_list_package = number_format( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}else{
						$rate_other = number_format( $response->RateReplyDetails[$i]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $this->fedex_conversion_rate, 2, ".", "," );
					}
					
					if( $payor_account_package > 0 ){
						$rate = $payor_account_package;
					}else if( $rated_account_package > 0 ){
						$rate = $rated_account_package;
					}else if( $payor_list_package > 0 ){
						$rate = $payor_list_package;
					}else if( $rated_list_package > 0 ){
						$rate = $rated_list_package;
					}else {
						$rate = $rate_other;
					}
					
					$rates[] = array( 'rate_code' => $code, 'rate' =>$rate );
				}
				
				return $rates;
			}else{
				error_log( "error in fedex get rate, " . $this->printError($client, $response) );
				return "ERROR";
			}
		}catch (SoapFault $exception){
			error_log( "error in fedex get rate, " . $this->printFault($exception, $client) );
			return "ERROR";        
		}
	}
		
	public function get_rate_test( $ship_code, $destination_zip, $destination_country, $weight ){
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = $this->fedex_country_code;
		
		if( $this->fedex_test_account ){
			$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v16_test_account.wsdl";
		}else{
			$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v16.wsdl";
		}

		ini_set("soap.wsdl_cache_enabled", "0");
		 
		$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
		
		$request['WebAuthenticationDetail'] = array(
			'UserCredential' =>array(
				'Key' => $this->fedex_key, 
				'Password' => $this->fedex_password
			)
		); 
		$request['ClientDetail'] = array(
			'AccountNumber' => $this->fedex_account_number, 
			'MeterNumber' => $this->fedex_meter_number
		);
		$request['TransactionDetail'] = array( 'CustomerTransactionId' => ' *** Rate Request v16 using PHP ***' );
		$request['Version'] = array(
			'ServiceId' => 'crs', 
			'Major' => '16', 
			'Intermediate' => '0', 
			'Minor' => '0'
		);
		$request['ReturnTransitAndCommit'] = true;
		$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
		$request['RequestedShipment']['ShipTimestamp'] = date( 'c' );
		$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
		
		$shipper = array( 'Address' => array( 'PostalCode' => $this->fedex_ship_from_zip, 'CountryCode' => $this->fedex_country_code ) );
		$request['RequestedShipment']['Shipper'] = $shipper;
		
		$recipient = array( 'Address' => array( 'PostalCode' => $destination_zip, 'CountryCode' => $destination_country ) );
		$request['RequestedShipment']['Recipient'] = $recipient;
		
		$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
		$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
		$request['RequestedShipment']['PackageCount'] = '1';
		
		$packageLineItem = array( 'SequenceNumber'=>1, 'GroupPackageCount'=>1, 'Weight' => array( 'Value' => $weight, 'Units' => $this->fedex_weight_units ) );
		$request['RequestedShipment']['RequestedPackageLineItems'] = $packageLineItem;
		
		try{
			$response = $client->getRates($request);
				
			return $response;
		}catch (SoapFault $exception){
		  return "Error in fedex get rate, " . $this->printFault($exception, $client);     
		}
	}
	
	private function printError( $client, $response ){
		$string = 'Error returned in processing transaction: ';
		$string .= $this->printNotifications( $response -> Notifications );
		$string .= $this->printRequestResponse( $client, $response );
		return $string;
	}
	
	private function printNotifications( $notes ){
		$string = "";
		foreach( $notes as $noteKey => $note ){
			if(is_string($note)){    
				$string .= $noteKey . ': ' . $note . "\r\n";
			}
			else{
				$string .= $this->printNotifications( $note );
			}
		}
		return $string;
	}
	
	private function printRequestResponse($client){
		return 'Request: ' .  htmlspecialchars($client->__getLastRequest()) . ", Response " . htmlspecialchars($client->__getLastResponse());
	}
	
	private function printFault($exception, $client) {
		$string = '<h2>Fault</h2>' . "<br>\n";                        
		$string .= "<b>Code:</b>{$exception->faultcode}<br>\n";
		$string .="<b>String:</b>{$exception->faultstring}<br>\n";
		$string .= sprintf( "\r%s:- %s", date("D M j G:i:s T Y"), $client->__getLastRequest( ). "\n\n" . $client->__getLastResponse( ) );
		return $string;
	}
	
	public function validate_address( $desination_address, $destination_city, $destination_state, $destination_zip, $destination_country ){
		return true;
		/*
		if( $this->fedex_test_account ){
			return true; //Cannot test address in test mode environment!! STUPID FEDEX.
		}else{
			$path_to_wsdl = dirname(__FILE__) . "/fedex_address_validation_service_v2.wsdl";

			ini_set("soap.wsdl_cache_enabled", "0");
			 
			$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
			
			$request['WebAuthenticationDetail'] = array(
				'UserCredential' =>array(
					'Key' => $this->fedex_key, 
					'Password' => $this->fedex_password
				)
			); 
			$request['ClientDetail'] = array(
				'AccountNumber' => $this->fedex_account_number, 
				'MeterNumber' => $this->fedex_meter_number
			);
			$request['Version'] = array(
				'ServiceId' => 'aval', 
				'Major' => '2', 
				'Intermediate' => '0', 
				'Minor' => '0'
			);
			
			$request['RequestTimestamp'] = date( 'Y-m-d' ) . 'T' . date( 'H:i:sP' );
			$request['AddressesToValidate'] = array(
				0 => array( 
					'Address' => $desination_address,
					'City' => $destination_city,
					'StateorProvinceCode' => $destination_state,
					'PostalCode' => $destination_zip,
					'CountryCode' => $destination_country
				)
			);
			$request['Options'] = array(
				'CheckResidentialStatus' => 1,
				'MaximumNumberOfMatches' => 5,
				'StreetAccuracy' => 'LOOSE',
				'DirectionalAccuracy' => 'LOOSE',
				'CompanyNameAccuracy' => 'LOOSE',
				'ConvertToUpperCase' => 1,
				'RecognizeAlternateCityNames' => 1,
				'ReturnParsedElements' => 1
			);
			
			try{
				$response = $client->addressValidation( $request );
			
				print_r( $response );
				die( );
				
				if( $response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR' ){  	
				
					if( $response->ProposedAddressDetails->Score > 0 )
						return true;
						
					else
						return false;
					
				}else{
					
					return true;
					
				}
					
				return $response;
			
			}catch (SoapFault $exception){
				
				return true; // Do not let an error stop the checkout!
			
			}
			
		}
		*/
	}

}
?>