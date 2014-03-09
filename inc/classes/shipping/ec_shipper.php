<?php
	class ec_shipper{
		protected $ec_setting;										// ec_settings structure
		
		private $ups;												// ec_ups structure
		private $usps;												// ec_usps structure
		private $fedex;												// ec_fedex structure
		private $auspost;											// ec_auspost structure
		private $dhl;												// ec_dhl structure
		
		private $dhl_data = array( );
		private $auspost_data = array( );
		private $fedex_data = array( );
		private $usps_data = array( );
		private $ups_data = array( );
		
		function __construct(  ){
			$this->ec_setting = new ec_setting();
			$this->ups = new ec_ups( $this->ec_setting );
			$this->usps = new ec_usps( $this->ec_setting );
			$this->fedex = new ec_fedex( $this->ec_setting );
			$this->auspost = new ec_auspost( $this->ec_setting );
			$this->dhl = new ec_dhl( $this->ec_setting );
		}
		
		public function get_rate( $ship_company, $ship_code, $destination_zip, $destination_country, $weight, $length = 10, $width = 10, $height = 10 ){
			if( $ship_company == "ups" ){
				if( count( $this->ups_data ) <= 0 ){
					// get the rates
					$this->ups_data = $this->ups->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height );
				}
				
				// Loop through and return the correct rate.
				for( $i=0; $i<count( $this->ups_data ); $i++ ){
					if( isset( $this->ups_data[$i]['rate_code'] ) && $this->ups_data[$i]['rate_code'] == $ship_code ){
						return $this->ups_data[$i]['rate'];
					}
				}
				
				return "ERROR";
			
			}else if( $ship_company == "usps" ){
				if( count( $this->usps_data ) <= 0 ){
					// get the rates
					$this->usps_data = $this->usps->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height );
				}
				
				// Loop through and return the correct rate.
				for( $i=0; $i<count( $this->usps_data ); $i++ ){
					if( isset( $this->usps_data[$i]['rate_code'] ) && $this->usps_data[$i]['rate_code'] == $ship_code ){
						return $this->usps_data[$i]['rate'];
					}
				}
				
				return "ERROR";
			
			}else if( $ship_company == "fedex" ){
				if( count( $this->fedex_data ) <= 0 ){
					// get the rates
					$this->fedex_data = $this->fedex->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height );
				}
				
				// Loop through and return the correct rate.
				for( $i=0; $i<count( $this->fedex_data ); $i++ ){
					if( isset( $this->fedex_data[$i]['rate_code'] ) && $this->fedex_data[$i]['rate_code'] == $ship_code ){
						return $this->fedex_data[$i]['rate'];
					}
				}
				
				return "ERROR";
			
			}else if( $ship_company == "auspost" ){
				if( count( $this->auspost_data ) <= 0 ){
					// get the rates
					$this->auspost_data = $this->auspost->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height );
				}
				
				// Loop through and return the correct rate.
				for( $i=0; $i<count( $this->auspost_data ); $i++ ){
					if( isset( $this->auspost_data[$i]['rate_code'] ) && $this->auspost_data[$i]['rate_code'] == $ship_code ){
						return $this->auspost_data[$i]['rate'];
					}
				}
				
				return "ERROR";
			
			}else if( $ship_company == "dhl" ){
				if( count( $this->dhl_data ) <= 0 ){
					// get the rates
					$this->dhl_data = $this->dhl->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height );
				}
				
				// Loop through and return the correct rate.
				for( $i=0; $i<count( $this->dhl_data ); $i++ ){
					if( isset( $this->dhl_data[$i]['rate_code'] ) && $this->dhl_data[$i]['rate_code'] == $ship_code ){
						return $this->dhl_data[$i]['rate'];
					}
				}
				
				return "ERROR";
			}
		}
		
	}
?>