<?php

class ec_address{

	public $first_name;							// VARCHAR 255
	public $last_name;							// VARCHAR 255
	public $address_line_1;						// VARCHAR 255
	public $address_line_2;						// VARCHAR 128
	public $city;								// VARCHAR 128
	public $state;								// VARCHAR 255
	public $zip;								// VARCHAR 255
	public $country;							// VARCHAR 255
	public $country_name;						// VARCHAR 255
	public $phone;								// VARCHAR 255
	
	function __construct( $fn, $ln, $ad1, $ad2, $cty, $st, $zp, $cnt, $ph ){
	
		$this->first_name = $fn;
		$this->last_name = $ln;
		$this->address_line_1 = $ad1;
		$this->address_line_2 = $ad2;
		$this->city = $cty;
		$this->state = $st;
		$this->zip = $zp;
		$this->country = $cnt;
		$this->phone = $ph;
		
		$mysqli = new ec_db( );
		$this->country_name = $mysqli->get_country_name( $cnt );
		
	}
	
	public function get_value( $name ){
		if( $name == "first_name" ){
			return $this->first_name;	
		}else if( $name == "last_name" ){
			return $this->last_name;
		}else if( $name == "address" ){
			return $this->address_line_1;
		}else if( $name == "address2" ){
			return $this->address_line_2;
		}else if( $name == "address_line_1" ){
			return $this->address_line_1;
		}else if( $name == "address_line_2" ){
			return $this->address_line_2;
		}else if( $name == "city" ){
			return $this->city;
		}else if( $name == "state" ){
			return $this->state;
		}else if( $name == "zip" ){
			return $this->zip;
		}else if( $name == "country" ){
			return $this->country_name;
		}else if( $name == "country2" ){
			return $this->country;
		}else if( $name == "phone" ){
			return $this->phone;
		}
	}
	
	public function display_first_name( ){
		echo $this->first_name;
	}
	
	public function display_last_name( ){
		echo $this->last_name;
	}
	
	public function display_address_line_1( ){
		echo $this->address_line_1;
	}
	
	public function display_address_line_2( ){
		echo $this->address_line_2;
	}
	
	public function display_city( ){
		echo $this->city;
	}
	
	public function display_state( ){
		echo $this->state;
	}
	
	public function display_zip( ){
		echo $this->zip;
	}
	
	public function display_country( ){
		echo $this->country_name;
	}
	
	public function display_phone( ){
		echo $this->phone;
	}
	
}

?>