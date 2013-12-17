<?php
	
class ec_fedex{
	private $fedex_key;											// Your FedEx Account Key
	private $fedex_account_number;								// Your FedEx Account Number
	private $fedex_meter_number;								// Your FedEx Meter Number
	private $fedex_password;									// Your FedEx Password
	private $fedex_ship_from_zip;								// Your FedEx ship from zip code
	private $fedex_weight_units;								// The weight units to use for the FedEx api
	private $fedex_country_code;								// The country code for the FedEx api
	
	private $shipper_url;										// String

	function __construct( $ec_setting ){
		$this->fedex_key = $ec_setting->get_fedex_key( );
		$this->fedex_account_number = $ec_setting->get_fedex_account_number();
		$this->fedex_meter_number = $ec_setting->get_fedex_meter_number();
		$this->fedex_password = $ec_setting->get_fedex_password();
		$this->fedex_ship_from_zip = $ec_setting->get_fedex_ship_from_zip();
		$this->fedex_weight_units = $ec_setting->get_fedex_weight_units();
		$this->fedex_country_code = $ec_setting->get_fedex_country_code();	
	}
		
	public function get_rate( $ship_code, $destination_zip, $destination_country, $weight ){
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = $this->fedex_country_code;
		
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
			
			$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v13.wsdl";
	
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
			$request['TransactionDetail'] = array( 'CustomerTransactionId' => ' *** Rate Request v13 using PHP ***' );
			$request['Version'] = array(
				'ServiceId' => 'crs', 
				'Major' => '13', 
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
			
			$recipient = array( 'Address' => array( 'PostalCode' => $destination_zip, 'CountryCode' => $destination_country, 'Residential' => 1 ) );
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
					$amount = number_format( $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount, 2, ".", "," );
					
					return $amount;
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
		
	public function get_rate_test( $ship_code, $destination_zip, $destination_country, $weight ){
		if( $weight == 0 )
			return "0.00";
			
		if( !$destination_country )
			$destination_country = $this->fedex_country_code;
		
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
			
			$path_to_wsdl = dirname(__FILE__) . "/fedex_rate_service_v13.wsdl";
	
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
			$request['TransactionDetail'] = array( 'CustomerTransactionId' => ' *** Rate Request v13 using PHP ***' );
			$request['Version'] = array(
				'ServiceId' => 'crs', 
				'Major' => '13', 
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

}
?>