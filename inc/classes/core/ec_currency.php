<?php 

class ec_currency{
	
	private $symbol;
	private $symbol_location;
	private $negative_location;
	private $decimal_symbol;
	private $decimal_length;
	private $grouping_symbol;
	
	function __construct( ){
		$this->symbol = htmlentities( get_option( 'ec_option_currency' ) );
		$this->symbol_location = get_option( 'ec_option_currency_symbol_location' );
		$this->negative_location = get_option( 'ec_option_currency_negative_location' );
		$this->decimal_symbol = get_option( 'ec_option_currency_decimal_symbol' );
		$this->decimal_length = get_option( 'ec_option_currency_decimal_places' );
		$this->grouping_symbol = get_option( 'ec_option_currency_thousands_seperator' );
	}
	
	public function get_currency_display( $amount ){
		$display_amount = "";
		
		if( $amount < 0 && $this->negative_location )
			$display_amount .= "-";
		
		if( $this->symbol_location )
			$display_amount .= $this->symbol;
			
		if( $amount < 0 && !$this->negative_location )
			$display_amount .= "-";
		
		if( $amount < 0 )
		$amount = $amount * -1;
		
		$amount = doubleval( $amount );
		$display_amount .= number_format( $amount, $this->decimal_length, $this->decimal_symbol, $this->grouping_symbol );
		
		if( !$this->symbol_location )
			$display_amount .= $this->symbol;
			
		return $display_amount;
	}
	
	public function get_number_only( $amount ){
		$amount = doubleval( $amount );
		return number_format( $amount, $this->decimal_length, $this->decimal_symbol, "" );
	}
	
	public function format_cents( $cents ){
		return substr( $cents, 0, $this->decimal_length );
	}
	
	
}

?>