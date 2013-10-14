<?php

class ec_shipping{
	protected $mysqli;											// ec_db structure
	protected $ec_setting;										// ec_settings structure
	protected $ec_user;											// ec_user structure
	protected $ec_shipper;										// ec_shipper structure
	
	private $display_type;										// VARCHAR, methods = [RADIO, SELECT, DIV]
	
	private $price_based = array();								// array of array[trigger_rate, shipping_rate] 
	private $weight_based = array();							// array of array[trigger_rate, shipping_rate]
	private $method_based = array();							// array of array[shipping_rate, shipping_label, shippingrate_id]
	private $live_based = array();								// array of array[shipping_code, shipping_label, shippingrate_id, ship_type]
	
	private $subtotal;											// float 7,2
	private $weight;											// float 7,2
	private $express_price;										// float 7,2
	private $ship_express;										// BOOL
	private $destination_zip;									// VARCHAR
	private $destination_country;								// VARCHAR(2)
	
	public $shipping_method;									// shipping_method option
	
	public $shipping_promotion_text;							// TEXT
	
	function __construct( $subtotal, $weight, $display_type = 'RADIO' ){
		$this->mysqli = new ec_db();
		$this->ec_setting = new ec_setting();
		
		$email_user = "";
		if( isset( $_SESSION['ec_email'] ) )
			$email_user = $_SESSION['ec_email'];
		$this->user = new ec_user( $email_user );
		$this->shipper = new ec_shipper( );
		
		if( get_option( 'ec_option_use_shipping' ) ){
			$this->shipping_method = $this->ec_setting->get_shipping_method( );
			$shipping_rows = $this->mysqli->get_shipping_data( );
			
			// Set the destination zip code
			if( isset( $_SESSION['ec_shipping_zip'] ) )
				$this->destination_zip = $_SESSION['ec_shipping_zip'];
			
			else if( isset( $_SESSION['ec_temp_zipcode'] ) )
				$this->destination_zip = $_SESSION['ec_temp_zipcode'];
			
			else if( $this->user && $this->user->shipping && $this->user->shipping->zip )
				$this->destination_zip = $this->user->shipping->zip;
				
			// Set the destination country code
			if( isset( $_SESSION['ec_shipping_country'] ) )
				$this->destination_country = $_SESSION['ec_shipping_country'];
			
			else if( isset( $_SESSION['ec_temp_country'] ) )
				$this->destination_country = $_SESSION['ec_temp_country'];
			
			else if( $this->user && $this->user->shipping && $this->user->shipping->country )
				$this->destination_country = $this->user->shipping->country;
			
			
			foreach( $shipping_rows as $shipping_row ){
				
				if( $shipping_row->is_price_based )					
					array_push( $this->price_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				else if( $shipping_row->is_weight_based )			
					array_push( $this->weight_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				else if( $shipping_row->is_method_based )			
					array_push( $this->method_based, array( $shipping_row->shipping_rate, $shipping_row->shipping_label, $shipping_row->shippingrate_id ) );
				else if( $this->is_live_based( $shipping_row ) ){	
					array_push( $this->live_based, array( $shipping_row->shipping_code, $shipping_row->shipping_label, $shipping_row->shippingrate_id, $this->get_live_type( $shipping_row ) ) );
				}
			}
			
			$this->subtotal = $subtotal;
			$this->weight = $weight;
			$this->express_price = $this->ec_setting->get_setting( "shipping_expedite_rate" );
			if( isset( $_SESSION['ec_ship_express'] ) ){
				$this->ship_express = $_SESSION['ec_ship_express'];
			}
			
			$this->display_type = $display_type;
		}
	}
	
	private function is_live_based( $shipping_row ){
		if( $shipping_row->is_ups_based || $shipping_row->is_usps_based || $shipping_row->is_fedex_based || $shipping_row->is_auspost_based )
			return true;
		else
			return false;
	}
	
	private function get_live_type( $shipping_row ){
		if( $shipping_row->is_ups_based )
			return "ups";
		else if( $shipping_row->is_usps_based )
			return "usps";
		else if( $shipping_row->is_fedex_based )
			return "fedex";
		else if( $shipping_row->is_auspost_based )
			return "auspost";
		else
			return "none";
	}
	
	public function get_shipping_options( $standard_text, $express_text ){
		
		if( $this->shipping_method == "price" )
			return $this->get_price_based_shipping_options( $standard_text, $express_text );
			
		else if( $this->shipping_method == "weight" )
			return $this->get_weight_based_shipping_options( $standard_text, $express_text );
			
		else if( $this->shipping_method == "method" )
			return $this->get_method_based_shipping_options( $standard_text, $express_text );
			
		else if( $this->shipping_method == "live" )
			return $this->get_live_based_shipping_options( $standard_text, $express_text );
			
	}
	
	private function get_price_based_shipping_options( $standard_text, $express_text ){
		for( $i=0; $i<count($this->price_based); $i++){
			if( $this->subtotal > $this->price_based[$i][0] )
				return $this->get_single_shipping_price_content( $standard_text, $express_text, $this->price_based[$i][1] );
		}	
	}
	
	private function get_weight_based_shipping_options( $standard_text, $express_text ){
		for( $i=0; $i<count($this->weight_based); $i++){
			if( $this->weight > $this->weight_based[$i][0] )
				return $this->get_single_shipping_price_content( $standard_text, $express_text, $this->weight_based[$i][1] );
		}
	}
	
	private function get_method_based_shipping_options( $standard_text, $express_text ){
		$ret_string = "";
			
		if( $this->display_type == "SELECT" )
			$ret_string .= "<select name=\"ec_cart_shipping_method\" onchange=\"ec_cart_shipping_method_change();\">";
		
		for( $i=0; $i<count($this->method_based); $i++){
			if( $this->display_type == "RADIO" )
				$ret_string .= $this->get_method_based_radio( $i );
			
			else if( $this->display_type == "SELECT" )
				$ret_string .= $this->get_method_based_select( $i );
			
			else //default is div
				$ret_string .= $this->get_method_based_div( $i );
		}
		
		if( $this->display_type == "SELECT" )
			$ret_string .= "</select>";
		
		return $ret_string;
	}
	
	private function get_live_based_shipping_options( $standard_text, $express_text ){
		
		$ret_string = "";
			
		if( $this->display_type == "SELECT" )
			$ret_string .= "<select name=\"ec_cart_shipping_method\" onchange=\"ec_cart_shipping_method_change();\">";
		
		for( $i=0; $i<count( $this->live_based ); $i++){
			$rate = $this->shipper->get_rate( $this->live_based[$i][3], $this->live_based[$i][0], $this->destination_zip, $this->destination_country, $this->weight );
			
			//$rate = $GLOBALS['currency']->get_currency_display( $rate );
			
			if( $this->display_type == "RADIO" )
				$ret_string .= $this->get_live_based_radio( $i, $rate );
			
			else if( $this->display_type == "SELECT" )
				$ret_string .= $this->get_live_based_select( $i, $rate );
			
			else //default is div
				$ret_string .= $this->get_live_based_div( $i, $rate );
		}
		
		if( $this->display_type == "SELECT" )
		$ret_string .= "</select>";
		
		return $ret_string;
	}
	
	private function get_method_based_radio( $i ){
		
		$ret_string = "";
		
		$ret_string .= "<div class=\"ec_cart_shipping_method_row\">";
		$ret_string .= "<input type=\"radio\" name=\"ec_cart_shipping_method\" value=\"" . $this->method_based[$i][2] . "\" onchange=\"ec_cart_shipping_method_change('" . $this->method_based[$i][2] . "'); \"";
		
		if( ( !isset( $_SESSION['ec_shipping_method'] ) && $i==0 ) || ( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->method_based[$i][2] ) )
		$ret_string .= " checked=\"checked\"";
		
		$ret_string .= " /> " . $this->method_based[$i][1] . " (" . $GLOBALS['currency']->get_currency_display( $this->method_based[$i][0] ) . ")</div>";
		
		return $ret_string;
	}
	
	private function get_method_based_select( $i ){
		
		$ret_string = "";
		$ret_string .= "<option value=\"" . $this->method_based[$i][2] . "\"";
		
		if( ( !isset( $_SESSION['ec_shipping_method'] ) && $i==0 ) || ( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->method_based[$i][2] ) )
		$ret_string .= " selected=\"selected\"";
		
		$ret_string .= "> " . $this->method_based[$i][1] . " (" . $GLOBALS['currency']->get_currency_display( $this->method_based[$i][0] ) . ")</option>";
		
		return $ret_string;
	}
	
	private function get_method_based_div( $i ){
		
		$ret_string = "";
		
		$ret_string .= "<div class=\"ec_cart_shipping_method_row\ id=\"" . $this->method_based[$i][2] . "\"> " . $this->method_based[$i][1] . " (" . $GLOBALS['currency']->get_currency_display( $this->method_based[$i][0] ) . ")</div>";
		
		return $ret_string;
	}
	
	private function get_live_based_radio( $i, $rate ){
		
		if( $rate != "ERROR" ){
		
			$ret_string = "";
			
			$ret_string .= "<div class=\"ec_cart_shipping_method_row\">";
			$ret_string .= "<input type=\"radio\" name=\"ec_cart_shipping_method\" value=\"" . $this->live_based[$i][2] . "\" onchange=\"ec_cart_shipping_method_change('" . $this->live_based[$i][2] . "', " . $rate . " ); \"";
			
			if( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->live_based[$i][2] )
			$ret_string .= " checked=\"checked\"";
			
			$ret_string .= " /><span class=\"label\">" . $this->live_based[$i][1] . "</span> <span class=\"price\">" . $GLOBALS['currency']->get_currency_display( $rate ) . "</span></div>";
			
			return $ret_string;
			
		}
		
	}
	
	private function get_live_based_select( $i, $rate ){
		
		if( $rate != "ERROR" ){
		
			$ret_string = "";
			$ret_string .= "<option value=\"" . $this->live_based[$i][0] . "\"";
			
			if( ( !isset( $_SESSION['ec_shipping_method'] ) && $i==0 ) || ( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->live_based[$i][0] ) )
			$ret_string .= " selected=\"selected\"";
			
			$ret_string .= "> " . $this->live_based[$i][1] . " " . $GLOBALS['currency']->get_currency_display( $rate ) . "</option>";
			
			return $ret_string;
			
		}
	}
	
	private function get_live_based_div( $i, $rate ){
		
		if( $rate != "ERROR" ){
			$ret_string = "<div id=\"" . $this->live_based[$i][0] . "\"> " . $this->live_based[$i][1] . " " . $GLOBALS['currency']->get_currency_display( $rate ) . "</div>";
			return $ret_string;
		}
		
	}
	
	public function get_selected_shipping_method( ){
		
		$selected_shipping_method_id = 0;
		if( isset( $_SESSION['ec_shipping_method'] ) )
			$selected_shipping_method_id = $_SESSION['ec_shipping_method'];
			
		if( $this->shipping_method == "method" ){
			
			for( $i=0; $i<count($this->method_based); $i++){
				if( $this->method_based[$i][2] == $selected_shipping_method_id ){
					return $this->get_method_based_div( $i );
				}
			}
		
		}else if( $this->shipping_method == "live" ){
			for( $i=0; $i<count($this->live_based); $i++){
				if( $this->live_based[$i][2] == $selected_shipping_method_id ){
					$rate = $this->shipper->get_rate( $this->live_based[$i][3], $this->live_based[$i][0], $this->destination_zip, $this->destination_country, $this->weight );
					return $this->get_live_based_div( $i, $rate );
				}
			}
		
		}
	}
	
	public function get_single_shipping_price_content( $standard_text, $express_text, $standard_price ){
		$ret_string = "";
		$ret_string .= "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\"><input type=\"radio\" name=\"ec_cart_shipping_method\" id=\"ec_cart_shipping_method\" value=\"standard\" checked=\"checked\" />" . $standard_text . " (" . get_option( 'ec_option_currency' ) . "<span id=\"ec_cart_standard_shipping_price\">" . $GLOBALS['currency']->get_number_only( $standard_price ) . "</span>)</div>";
		$ret_string .= "<div id=\"ec_cart_express_shipping_row\" class=\"ec_cart_shipping_method_row\"><input type=\"checkbox\" name=\"ec_cart_ship_express\" id=\"ec_cart_ship_express\" value=\"shipexpress\"";
		if( $this->ship_express )
			$ret_string .= " checked=\"checked\"";
		$ret_string .= " />" . $express_text . " (" . get_option( 'ec_option_currency' ) . "<span id=\"ec_cart_express_shipping_price\">" . $GLOBALS['currency']->get_number_only( $this->express_price ) . "</span>)</div>";
		return $ret_string;
	}
	
	public function get_shipping_price( ){
		$rate = "ERROR";
		if( $this->shipping_method == "price" ){
			for( $i=0; $i<count( $this->price_based ); $i++ ){
				if( $this->subtotal > $this->price_based[$i][0] ){
					$rate = $this->price_based[$i][1];
					break;
				}
				
			}
			if( $this->ship_express )
				$rate = $rate + $this->express_price;
			
		}else if( $this->shipping_method == "weight" ){
			for( $i=0; $i<count( $this->weight_based ); $i++ ){
				if( $this->weight > $this->weight_based[$i][0] ){
					$rate = $this->weight_based[$i][1];
					break;
				}
			}
			if( $this->ship_express )
				$rate = $rate + $this->express_price;
			
		}else if( $this->shipping_method == "method" ){
			if( !isset( $_SESSION['ec_shipping_method'] ) )
				$rate = $this->method_based[0][0];
			
			else{
				for( $i=0; $i<count( $this->method_based ); $i++ ){
					if( $_SESSION['ec_shipping_method'] == $this->method_based[$i][2] )
						$rate = $this->method_based[$i][0];
				}
			}
			
		}else if( $this->shipping_method == "live" ){
			if( !isset( $_SESSION['ec_shipping_method'] ) ){
				if( isset( $this->live_based ) && count( $this->live_based ) > 0 && count( $this->live_based[0] ) > 3 )
					$rate = $this->shipper->get_rate( $this->live_based[0][3], $this->live_based[0][0], $this->destination_zip, $this->destination_country, $this->weight );
				
			}else{
				for( $i=0; $i<count( $this->live_based ); $i++ ){
					if( $_SESSION['ec_shipping_method'] == $this->live_based[$i][2] )
						$rate = $this->shipper->get_rate( $this->live_based[$i][3], $this->live_based[$i][0], $this->destination_zip, $this->destination_country, $this->weight );
					
				}	
			}
		}
		
		$promotion = new ec_promotion( );
		$discount = $promotion->get_shipping_discounts( $this->subtotal, $rate, $this->shipping_promotion_text );
		
		if( $rate == "ERROR" ){
			error_log( "error getting shipping rate.");
			return "0.00";
		}else{
			return doubleval( $rate ) - doubleval( $discount );
		}
	}
	
	public function get_shipping_promotion_text( ){
		$promotion = new ec_promotion( );
		$rate = 0;
		$promotion->get_shipping_discounts( $this->subtotal, $rate, $this->shipping_promotion_text );
		return $this->shipping_promotion_text;
	}
}

?>