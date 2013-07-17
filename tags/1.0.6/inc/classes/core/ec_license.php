<?php

class ec_license{
	
	protected $mysqli;				// ec_db structure
	private $regcode;				// VARCHAR 255
	
	function __construct( ){
		
		$this->mysqli = new ec_db();
		$this->regcode = $this->mysqli->get_registration_code( );
		
	}
	
	public function is_registered( ){
		return $this->check_license( );
	}

	private function check_license( ){

		$tcode =  substr($this->regcode, 9, 1);
		if( $tcode == 'V' ) 						return true;  
		else										return false; 
	}
}

?>