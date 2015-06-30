<?php
	class ec_shipper{
		protected $ec_setting;										// ec_settings structure
		
		private $ups;												// ec_ups structure
		private $usps;												// ec_usps structure
		private $fedex;												// ec_fedex structure
		private $auspost;											// ec_auspost structure
		private $dhl;												// ec_dhl structure
		private $canadapost;										// ec_canadapost structure
		
		private $dhl_data = array( );
		private $auspost_data = array( );
		private $fedex_data = array( );
		private $usps_data = array( );
		private $ups_data = array( );
		private $canadapost_data = array( );
		
		function __construct(  ){
			$this->ec_setting = new ec_setting();
			
			/* TEST FOR NECESSARY SHIPPING CLASSES */
			$use_auspost = false; $use_dhl = false; $use_fedex = false; $use_ups = false; $use_usps = false; $use_canadapost = false;
			global $wpdb;
			$rates = $wpdb->get_results( "SELECT shippingrate_id, is_ups_based, is_usps_based, is_fedex_based, is_auspost_based, is_dhl_based, is_canadapost_based FROM ec_shippingrate" );
			
			foreach( $rates as $rate ){
				if( $rate->is_auspost_based )
					$use_auspost = true;
				else if( $rate->is_dhl_based )
					$use_dhl = true;
				else if( $rate->is_fedex_based )
					$use_fedex = true;
				else if( $rate->is_ups_based )
					$use_ups = true;
				else if( $rate->is_usps_based )
					$use_usps = true;
				else if( $rate->is_canadapost_based )
					$use_canadapost = true;
			}
			
			if( $use_ups )
				$this->ups = new ec_ups( $this->ec_setting );
			if( $use_usps )
				$this->usps = new ec_usps( $this->ec_setting );
			if( $use_fedex )
				$this->fedex = new ec_fedex( $this->ec_setting );
			if( $use_auspost )
				$this->auspost = new ec_auspost( $this->ec_setting );
			if( $use_dhl )
				$this->dhl = new ec_dhl( $this->ec_setting );
			if( $use_canadapost )
				$this->canadapost = new ec_canadapost( $this->ec_setting );
		}
		
		public function get_service_days( $ship_company, $ship_code ){
			
			if( $ship_company == "ups" ){
				
				for( $i=0; $i<count( $this->ups_data ); $i++ ){
					if( isset( $this->ups_data[$i]['rate_code'] ) && $this->ups_data[$i]['rate_code'] == $ship_code ){
						return $this->ups_data[$i]['delivery_days'];
					}
				}
			
			}else if( $ship_company == "canadapost" ){
				
				for( $i=0; $i<count( $this->canadapost_data ); $i++ ){
					if( isset( $this->canadapost_data[$i]['rate_code'] ) && $this->canadapost_data[$i]['rate_code'] == $ship_code ){
						return $this->canadapost_data[$i]['delivery_days'];
					}
				}
				
			}
				
			return 0;
		
		}
		
		public function get_rate( $ship_company, $ship_code, $destination_zip, $destination_country, $weight, $length = 10, $width = 10, $height = 10, $declared_value = 0, $cart = array( ) ){
			if( $ship_company == "ups" ){
				if( count( $this->ups_data ) <= 0 ){
					// get the rates
					$this->ups_data = $this->ups->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
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
					$this->usps_data = $this->usps->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
				}
				
				// Loop through and return the correct rate.
				if( isset( $this->usps_data[$ship_code] ) ){
					return $this->usps_data[$ship_code]['rate'];
				}
				
				return "ERROR";
			
			}else if( $ship_company == "fedex" ){
				if( count( $this->fedex_data ) <= 0 ){
					// get the rates
					$this->fedex_data = $this->fedex->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
				}
				
				// Loop through and return the correct rate.
				for( $i=0; $i<count( $this->fedex_data ); $i++ ){
					if( isset( $this->fedex_data[$i]['rate_code'] ) && $ship_code == "GROUND_HOME_DELIVERY" && ( $this->fedex_data[$i]['rate_code'] == "FEDEX_GROUND" || $this->fedex_data[$i]['rate_code'] == "GROUND_HOME_DELIVERY" ) ){
						return $this->fedex_data[$i]['rate'];
						
					}else if( isset( $this->fedex_data[$i]['rate_code'] ) && $this->fedex_data[$i]['rate_code'] == $ship_code ){
						return $this->fedex_data[$i]['rate'];
					}
				}
				
				return "ERROR";
			
			}else if( $ship_company == "auspost" ){
				if( count( $this->auspost_data ) <= 0 ){
					// get the rates
					$this->auspost_data = $this->auspost->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
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
			}else if( $ship_company == "canadapost" ){
				if( count( $this->canadapost_data ) <= 0 ){
					// get the rates
					$this->canadapost_data = $this->canadapost->get_all_rates( $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
				}
				
				// Loop through and return the correct rate.
				for( $i=0; $i<count( $this->canadapost_data ); $i++ ){
					if( isset( $this->canadapost_data[$i]['rate_code'] ) && $this->canadapost_data[$i]['rate_code'] == $ship_code ){
						return $this->canadapost_data[$i]['rate'];
					}
				}
				
				return "ERROR";
			}
		}
		
		public function validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country ){
			
			if( isset( $this->ups ) )
				return $this->ups->validate_address( $destination_city, $destination_state, $destination_zip, $destination_country );
			
			else if( isset( $this->usps ) )
				return $this->usps->validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country );
			
			else if( isset( $this->fedex ) )
				return $this->fedex->validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country );
			
			else if( isset( $this->auspost ) )
				return $this->auspost->validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country );
			
			else if( isset( $this->dhl ) )
				return $this->dhl->validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country );
				
			else if( isset( $this->canadapost ) )
				return $this->canadapost->validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country );
				
			else
				return true;
			
		}
		
	}
?>