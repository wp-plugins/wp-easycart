<?php
	class ec_shipper{
		protected $ec_setting;										// ec_settings structure
		
		private $ups;												// ec_ups structure
		private $usps;												// ec_usps structure
		private $fedex;												// ec_fedex structure
		
		function __construct(  ){
			$this->ec_setting = new ec_setting();
			$this->ups = new ec_ups( $this->ec_setting );
			$this->usps = new ec_usps( $this->ec_setting );
			$this->fedex = new ec_fedex( $this->ec_setting );
		}
		
		public function get_rate( $ship_company, $ship_code, $destination_zip, $destination_country, $weight ){
			if( $ship_company == "ups" )
				return $this->ups->get_rate( $ship_code, $destination_zip, $destination_country, $weight );	
			else if( $ship_company == "usps" )
				return $this->usps->get_rate( $ship_code, $destination_zip, $destination_country, $weight );	
			else if( $ship_company == "fedex" )
				return $this->fedex->get_rate( $ship_code, $destination_zip, $destination_country, $weight );	
		}
		
	}
?>