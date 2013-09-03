<?php

class ec_tax{
	
	protected $mysqli;										// ec_db structure
	
	public $state_tax;										// FLOAT 11,2
	public $country_tax;									// FLOAT 11,2
	public $all_tax;										// FLOAT 11,2
	public $sales_tax;										// FLOAT 11,2
	public $duty_total;										// FLOAT 11,2
	public $vat_total;										// FLOAT 11,2
	public $tax_total;										// FLOAT 11,2
	public $taxrates = array();								// Array of ec_taxrate structures
	public $vat_enabled;									// BOOL
	public $vat_country_match;								// BOOL
	public $vat_rate;										// FLOAT 11,2
	
	// Passed in Values
	public $product_vat_total;								// FLOAT 11,2
	public $shipping_total;									// FLOAT 11,2
	
	private $cart_total;									// FLOAT 7,2
	private $shipping_state;								// VARCHAR 255
	private $shipping_country;								// VARCHAR 255
	
	function __construct( $cart_total, $shipping_state, $shipping_country, $product_vat_total, $shipping_total ){
		
		$this->mysqli 							= 			new ec_db();
		
		$this->cart_total 						= 			$cart_total;
		$this->shipping_state 					= 			strtoupper( $shipping_state );
		$this->shipping_country 				= 			strtoupper( $shipping_country );
		$this->product_vat_total 				= 			$product_vat_total;
		$this->shipping_total 					= 			$shipping_total;
		
		$taxrates 								= 			$this->mysqli->get_taxrates( );
		
		$this->vat_enabled = $this->is_vat_enabled( $taxrates );
		$this->vat_country_match = $this->is_vat_country_match( $taxrates );
		
		if( $this->vat_enabled && $this->vat_country_match )
			$this->vat_rate = $this->get_vat_rate( $taxrates );
		else
			$this->vat_rate = 0;
		
		if( !$this->vat_enabled )
			$this->product_vat_total = 0;
		
		foreach( $taxrates as $taxrate ){
			array_push( $this->taxrates, new ec_taxrate( $cart_total, $shipping_state, $shipping_country, $this->product_vat_total, $taxrate ) );	
		}
		
		$this->calculate_taxes( );
	}
	
	private function is_vat_enabled( $taxrates ){
		foreach( $taxrates as $taxrate ){
			if( $taxrate->tax_by_vat ){
				return true;
			}
		}
		return false;
	}
	
	private function is_vat_country_match( $taxrates ){
		foreach( $taxrates as $taxrate ){
			if( $taxrate->tax_by_vat ){
				if( !$this->shipping_country || $this->shipping_country == $taxrate->vat_country_code )
					return true;
				else
					return false;
			}
		}
		return false;
	}
	
	private function get_vat_rate( $taxrates ){
		foreach( $taxrates as $taxrate ){
			if( $taxrate->tax_by_vat ){
				return $taxrate->vat_rate;
			}
		}
		return 0;
	}
	
	private function calculate_taxes(){
		$this->state_tax 						= 			0;
		$this->country_tax 						= 			0;
		$this->all_tax 							= 			0;
		$this->sales_tax						=			0;
		$this->duty_total 						= 			0;
		$this->vat_total 						= 			0;
		
		// Calculate State Tax
		for( $i=0; $i < count( $this->taxrates ) && $this->taxrates[$i]->tax_by_state; $i++ ){
			$this->state_tax 					= 			$this->state_tax + $this->taxrates[$i]->tax_total;	
		}
		
		// Calculate Country Tax
		for( $i; $i < count( $this->taxrates ) && $this->taxrates[$i]->tax_by_country; $i++ ){
			$this->country_tax 					= 			$this->country_tax + $this->taxrates[$i]->tax_total;	
		}
		
		// Calculate All Tax
		for( $i; $i < count( $this->taxrates ) && $this->taxrates[$i]->tax_by_all; $i++ ){
			$this->all_tax 						= 			$this->all_tax + $this->taxrates[$i]->tax_total;	
		}
		
		//Calculate Sales Tax Total
		$this->sales_tax 						= 			$this->state_tax + $this->country_tax + $this->all_tax;
		
		// Calculate Duty
		for( $i; $i < count( $this->taxrates ) && $this->taxrates[$i]->tax_by_duty; $i++ ){
			$this->duty_total				 	= 			$this->taxrates[$i]->get_duty_tax( $this->shipping_total, $this->sales_tax );
		}
		
		// Calculate VAT Values
		for( $i; $i < count( $this->taxrates ) && $this->taxrates[$i]->tax_by_vat; $i++ ){
			$this->vat_total 					= 			$this->taxrates[$i]->get_vat_total( $this->shipping_total, $this->sales_tax, $this->duty_total );	
		}
		
		$this->tax_total = $this->sales_tax;
	}
	
}

?>