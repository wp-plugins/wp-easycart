<?php

class ec_taxrate{
	
	protected $mysqli;					// ec_db structure
	
	public $taxrate_id;					// INT
	
	public $tax_type;					// INT
	
	public $tax_rate;					// Float 4,2
	public $tax_total;					// Float 7,2
	
	public $tax_state_code;				// VARCHAR 2
	public $tax_country_code;			// VARCHAR 50
	public $tax_vat_country_code;		// VARCHAR 50
	public $tax_duty_country_code;		// VARCHAR 50
	
	// Passed In Values
	public $cart_total;					// Float 7,2
	
	private $product_vat_total;			// FLOAT 11,2
	private $shipping_state;			// VARCHAR 255
	private $shipping_country;			// VARCHAR 255
	
	// Useful Vars from tax_row
	public $tax_by_state;				// BOOL
	public $tax_by_country;				// BOOL
	public $tax_by_all;					// BOOL
	public $tax_by_duty;				// BOOL
	public $tax_by_vat;					// BOOL
	
	// Constant Values
	const STATEBASED = 0;
	const COUNTRYBASED = 1;
	const DUTYTAX = 2;
	const VATTAX = 3;
	const TAXALL = 4;
	const NOTAX = 5;
	
	function __construct( $cart_total, $shipping_state, $shipping_country, $product_vat_total, $tax_row ){
		
		$this->mysqli = new ec_db();
		
		// Set cart and user data
		$this->cart_total 				= 							$cart_total;
		$this->shipping_state 			= 							strtoupper( $shipping_state );
		$this->shipping_country 		= 							strtoupper( $shipping_country );
		$this->product_vat_total		=							$product_vat_total;
		
		$this->tax_by_state				=							$tax_row->tax_by_state;
		$this->tax_by_country			=							$tax_row->tax_by_country;
		$this->tax_by_all				=							$tax_row->tax_by_all;
		$this->tax_by_duty				=							$tax_row->tax_by_duty;
		$this->tax_by_vat				=							$tax_row->tax_by_vat;
		
		// Get the stat and country codes
		$this->tax_state_code 			= 							$this->get_state_code( $tax_row );
		$this->tax_country_code 		= 							$this->get_country_code( $tax_row );
		$this->tax_duty_country_code 	= 							$this->get_duty_country_code( $tax_row );
		$this->tax_vat_country_code 	= 							$this->get_vat_country_code( $tax_row );
		
		// Calculate this tax amount
		$this->tax_type 				= 							$this->get_tax_type( $tax_row );	
		$this->tax_rate 				= 							$this->get_tax_rate( $tax_row );
		$this->tax_total				=							$this->get_tax_total();
		
	}
	
	private function get_tax_type( $tax_row ){
		
		if( 		$tax_row->tax_by_state 		)					return self::STATEBASED;
		else if( 	$tax_row->tax_by_country 	)					return self::COUNTRYBASED;
		else if( 	$tax_row->tax_by_duty 		)					return self::DUTYTAX;
		else if( 	$tax_row->tax_by_vat 		)					return self::VATTAX;
		else if( 	$tax_row->tax_by_all 		)					return self::TAXALL;								
		else														return self::NOTAX;	
	
	}
	
	private function get_tax_total(){
		
		if( 		$this->tax_type == self::STATEBASED 	)		return $this->get_state_tax();
		else if( 	$this->tax_type == self::COUNTRYBASED )			return $this->get_country_tax();
		else if(	$this->tax_type == self::TAXALL		)			return $this->get_all_tax();
		else														return 0;
		
	}
	
	private function get_tax_rate( $tax_row ){
	
		if( 		$this->tax_type == self::STATEBASED )			return ( $tax_row->state_rate 	/ 100 		);
		else if( 	$this->tax_type == self::COUNTRYBASED )			return ( $tax_row->country_rate / 100 		);
		else if( 	$this->tax_type == self::DUTYTAX )				return ( $tax_row->duty_rate 	/ 100 		);
		else if( 	$this->tax_type == self::VATTAX )				return ( $tax_row->vat_rate 	/ 100 		);
		else if( 	$this->tax_type == self::TAXALL )				return ( $tax_row->all_rate 	/ 100 		);				
		else														return 0;
	
	}
	
	private function get_state_code( $tax_row ){					return $tax_row->state_code;				}
	private function get_country_code( $tax_row ){					return $tax_row->country_code;				}
	private function get_duty_country_code( $tax_row ){				return $tax_row->duty_exempt_country_code;	}
	private function get_vat_country_code( $tax_row ){				return $tax_row->vat_country_code;			}
	
	private function get_state_tax( ){
		if( $this->shipping_state == $this->tax_state_code )		return ( ( $this->cart_total - $this->product_vat_total ) * $this->tax_rate );	
		else														return 0;
	}
	
	private function get_country_tax( ){
		if( $this->shipping_country == $this->tax_country_code )	return ( ( $this->cart_total - $this->product_vat_total ) * $this->tax_rate );	
		else														return 0;
	}
	
	public function get_duty_tax( $shipping_total, $sales_tax ){
		if( $this->shipping_country != $this->tax_duty_country_code )return ( ( ( $this->cart_total - $this->product_vat_total ) + $shipping_total + $sales_tax ) * $this->tax_rate );	
		else														return 0;
	}
	
	public function get_vat_total( $shipping_total, $sales_tax, $duty_tax ){
		$vat_shipping = $shipping_total - ( $shipping_total / ( 1 + $this->tax_rate ) );
		
		if( !$this->shipping_country || 
			$this->shipping_country == $this->tax_vat_country_code )return ( $vat_shipping + ( ( $sales_tax + $duty_tax ) * $this->tax_rate ) + $this->product_vat_total );	
		else														return ( 0 );
	}
	
	private function get_all_tax(){									return ( $this->cart_total * $this->tax_rate );	}
	
}

?>