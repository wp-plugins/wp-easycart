<?php

class ec_cart{
	
	protected $mysqli;										// ec_db structure
	
	private $session_id;									// VARCHAR 255
	
	public $cart = array( ); 								// Array of ec_cartitem structures
	public $subtotal;										// Float 15,3
	public $taxable_subtotal;								// FLOAT 15,3
	public $discount_subtotal;								// Float 15,3
	public $shipping_subtotal;								// FLOAT 15,3
	public $vat_subtotal;									// FLOAT 15,3
	
	public $weight;											// INT
	public $total_items;									// INT
	
	public $cart_total_promotion;							// TEXT
	
	//Get sessionid and create the cart
	function __construct( $session_id ){
		$this->mysqli = new ec_db( );
		$this->session_id = $session_id;
		
		$this->cart = $this->mysqli->get_temp_cart( $session_id );
		
		$user_email = "";
		if( isset( $_SESSION['ec_email'] ) )
			$user_email = $_SESSION['ec_email'];
		
		$this->user = new ec_user( $user_email );
		$this->update_cart_values();
	}
	
	//set the subtotal
	private function update_cart_values(){
		
		$this->update_cart_totals( );
		
		if( isset( $_SESSION['ec_couponcode'] ) )
			$coupon_code = $_SESSION['ec_couponcode'];
		else
			$coupon_code = 0;
		
		if( isset( $_SESSION['ec_giftcard'] ) )
			$gift_card = $_SESSION['ec_giftcard'];
		else
			$gift_card = 0;
		
		$promotion = new ec_promotion( );
		$this->cart_promo_discount = $promotion->apply_promotions_to_cart( $this->cart, $this->subtotal, $this->cart_total_promotion );
		
		//If a promotion happened, need to recalculate subtotal!
		$this->update_cart_totals( );
	}
	
	public function update_cart_totals( ){
		$this->subtotal = 0;
		$this->shipping_subtotal = 0;
		$this->taxable_subtotal = 0;
		$this->vat_subtotal = 0;
		$this->weight = 0;
		$this->total_items = 0;
		
		for($i=0; $i<count( $this->cart ); $i++){
			$this->subtotal = $this->subtotal + $this->cart[$i]->total_price;
			
			if( $this->cart[$i]->is_taxable ) 				
				$this->taxable_subtotal = $this->taxable_subtotal + $this->cart[$i]->total_price;
			
			if( !$this->cart[$i]->is_giftcard && !$this->cart[$i]->is_download && !$this->cart[$i]->is_donation )
				$this->shipping_subtotal = $this->shipping_subtotal + $this->cart[$i]->total_price;
			
			if( $this->cart[$i]->vat_enabled > 0 )
				$this->vat_subtotal = $this->vat_subtotal + $this->cart[$i]->total_price;
			
			if( !$this->cart[$i]->is_giftcard && !$this->cart[$i]->is_download && !$this->cart[$i]->is_donation )
				$this->weight = $this->weight + $this->cart[$i]->get_weight();
			
			$this->total_items = $this->total_items + $this->cart[$i]->quantity;
		}
	}
	
	// Process Adding Item to cart
	public function process_add_to_cart($sessionid, $productid, $quantity, $option1, $option2, $option3, $option4, $option5, $message, $to_name, $from_name ){
		if( $this->is_duplicate($productid, $option1, $option2, $option3, $option4, $option5) )
			return $this->update_cart_item($sessionid, $productid, $quantity, $option1, $option2, $option3, $option4, $option5);
		else
			return $this->add_to_cart_item($sessionid, $productid, $quantity, $option1, $option2, $option3, $option4, $option5, $message, $to_name, $from_name );
	}
	
	// Check if product is already in the cart
	private function is_duplicate($productid, $option1, $option2, $option3, $option4, $option5){
		for($i=0; $i<count($this->cart); $i++){
			if(	$this->cart[$i]->Product->ProductID == $productid &&
				$this->cart[$i]->Options->OptionItem1->OptionItemID == $option1 &&
				$this->cart[$i]->Options->OptionItem2->OptionItemID == $option2 &&
				$this->cart[$i]->Options->OptionItem3->OptionItemID == $option3 &&
				$this->cart[$i]->Options->OptionItem4->OptionItemID == $option4 &&
				$this->cart[$i]->Options->OptionItem5->OptionItemID == $option5){
					return true;
					
			}
		}
		
		return false;	
	}
	
	// Add an item to the cart
	private function add_to_cart_item($sessionid, $productid, $quantity, $option1, $option2, $option3, $option4, $option5, $message, $to_name, $from_name ){
		// Get the Product Information
		$Product = $this->mysqli->get_cart_product( $productid );
		if( $Product['is_gift_card'] )				$this->add_gift_card( $Product, $message, $to_name, $from_name );
		else if( $Product['is_download'] )			$this->add_download( $Product );
		else if( $Product['is_donation'] )			$this->add_donation( $Product );
		else										$this->add_product( $Product );
		
		
		//If successfully added item to cart, return true
		return true;
	}
	
	private function add_gift_card( &$Product, $message, $to_name, $from_name ){
		return $this->mysqli->add_gift_card_to_cart( $Product, $message, $to_name, $from_name );
	}
	
	private function add_download( &$Product ){
		return $this->mysqli->add_download_to_cart( $Product );
	}
	
	private function add_donation( &$Product ){
		return $this->mysqli->add_donation_to_cart( $Product );
	}
	
	private function add_product( &$Product ){
		return $this->mysqli->add_product_to_cart( $Product );
	}
	
	// Update a cart item
	private function update_cart_item($sessionid, $productid, $quantity, $option1, $option2, $option3, $option4, $option5){
		
		//If successfully updated the cart item, return true
		return true;
	}
	
	public function get_total_items( ){
		return $this->total_items;
	}
	
	public function display_cart_items( $vat_enabled, $vat_country_match ){
		for($i=0; $i<count( $this->cart ); $i++){
			$cart_item = $this->cart[$i];
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_item.php' );	
		}
	}
	
	public function get_subtotal( $vat_enabled, $vat_country_match ){
		if( $vat_enabled && !$vat_country_match)
			return $this->subtotal - $this->vat_subtotal;
		else
			return $this->subtotal;
	}
	
	public function get_handling_total( ){
		$handling_total = 0;
		for( $i=0; $i<count( $this->cart ); $i++ ){
			$handling_total = $handling_total + $this->cart[$i]->handling_price;
		}
		return $handling_total;
	}
	
	public function get_discount_total( ){
		return number_format( $this->discount_subtotal, 2 );
	}
	
	public function get_grand_total( ){
		return number_format( $this->grand_total, 2 );
	}

}


?>