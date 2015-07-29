<?php

class ec_shipping{
	protected $mysqli;											// ec_db structure
	protected $ec_setting;										// ec_settings structure
	protected $ec_user;											// ec_user structure
	protected $ec_shipper;										// ec_shipper structure
	
	private $fraktjakt;											// Optional ec_fraktjakt
	
	private $display_type;										// VARCHAR, methods = [RADIO, SELECT, DIV]
	
	private $price_based = array();								// array of array[trigger_rate, shipping_rate] 
	private $weight_based = array();							// array of array[trigger_rate, shipping_rate]
	private $method_based = array();							// array of array[shipping_rate, shipping_label, shippingrate_id]
	private $quantity_based = array();							// array of array[trigger_rate, shipping_rate] 
	private $percentage_based = array();						// array of array[trigger_rate, percentage] 
	private $live_based = array();								// array of array[shipping_code, shipping_label, shippingrate_id, ship_type]
	private $fraktjakt_shipping_options;						// Optional array of shipping options in array( shipment_id, id, description, price, arrival_time)
	
	private $handling;											// FLOAT 11,2
	
	public $subtotal;											// float 7,2
	private $weight;											// float 7,2
	private $width;												// Float 7,2
	private $height;											// Float 7,2
	private $length;											// Float 7,2
	private $quantity;											// float 7,2
	private $express_price;										// float 7,2
	private $ship_express;										// BOOL
	private $destination_zip;									// VARCHAR
	private $destination_country;								// VARCHAR(2)
	
	private $cart;												// Array of ec_cartitem
	
	public $shipping_method;									// shipping_method option
	
	public $shipping_promotion_text;							// TEXT
	
	private $freeshipping;										// Boolean
	
	function __construct( $subtotal, $weight, $quantity = 1, $display_type = 'RADIO', $freeshipping = false, $length = 1, $width = 1, $height = 1, $cart = array( ) ){
		$this->mysqli = new ec_db();
		$this->ec_setting = new ec_setting();
		$this->shipping_method = $this->ec_setting->get_shipping_method( );
		
		$this->cart = $cart;
		
		$email_user = "";
		if( isset( $_SESSION['ec_email'] ) )
			$email_user = $_SESSION['ec_email'];
		$this->user = new ec_user( $email_user );
		
		if( $this->shipping_method == 'live' )
			$this->shipper = new ec_shipper( );
			
		$this->freeshipping = $freeshipping;
		
		if( get_option( 'ec_option_use_shipping' ) ){
			$setting_row = $this->mysqli->get_settings( );
			$this->handling = $setting_row->shipping_handling_rate;
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
			
			// Fraktjakt Shipping Info	
			if( $this->shipping_method == "fraktjakt" ){
				$this->fraktjakt = new ec_fraktjakt( );
				$this->fraktjakt_shipping_options = $this->fraktjakt->get_shipping_options( );
			}
			
			$zone_obj = $this->mysqli->get_zone_ids( $this->destination_country, $this->user->shipping->state );
			$zones = array();
			foreach( $zone_obj as $zone ){
				$zones[] = $zone->zone_id;
			}
			
			foreach( $shipping_rows as $shipping_row ){
				
				// Price and Zoned Based
				if( $shipping_row->is_price_based && $shipping_row->zone_id > 0 ){
					if( in_array( $shipping_row->zone_id, $zones ) )
						array_push( $this->price_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				
				// Price Based		
				}else if( $shipping_row->is_price_based )					
					array_push( $this->price_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				
				// Weight and Zoned Based
				else if( $shipping_row->is_weight_based && $shipping_row->zone_id > 0 ){
					if( in_array( $shipping_row->zone_id, $zones ) )
						array_push( $this->weight_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				
				// Weight Based
				}else if( $shipping_row->is_weight_based )			
					array_push( $this->weight_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				
				// Method and Zoned Based
				else if( $shipping_row->is_method_based && $shipping_row->zone_id > 0 ){
					if( in_array( $shipping_row->zone_id, $zones ) )
						array_push( $this->method_based, array( $shipping_row->shipping_rate, $GLOBALS['language']->convert_text( $shipping_row->shipping_label ), $shipping_row->shippingrate_id, $shipping_row->free_shipping_at ) );
					
				// Method Based	
				}else if( $shipping_row->is_method_based )			
					array_push( $this->method_based, array( $shipping_row->shipping_rate, $GLOBALS['language']->convert_text( $shipping_row->shipping_label ), $shipping_row->shippingrate_id, $shipping_row->free_shipping_at ) );
					
				// Quantity and Zoned Based
				else if( $shipping_row->is_quantity_based && $shipping_row->zone_id > 0 ){
					if( in_array( $shipping_row->zone_id, $zones ) )
						array_push( $this->quantity_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
					
				// Quantity Based	
				}else if( $shipping_row->is_quantity_based )			
					array_push( $this->quantity_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				
				// Percentage and Zoned Based
				else if( $shipping_row->is_percentage_based && $shipping_row->zone_id > 0 ){
					if( in_array( $shipping_row->zone_id, $zones ) )
						array_push( $this->percentage_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
					
				// Percentage Based	
				}else if( $shipping_row->is_percentage_based )			
					array_push( $this->percentage_based, array( $shipping_row->trigger_rate, $shipping_row->shipping_rate ) );
				
				// Live and Zoned Based
				else if( $this->is_live_based( $shipping_row ) && $shipping_row->zone_id > 0 ){
					if( in_array( $shipping_row->zone_id, $zones ) )
						array_push( $this->live_based, array( $shipping_row->shipping_code, $GLOBALS['language']->convert_text( $shipping_row->shipping_label ), $shipping_row->shippingrate_id, $this->get_live_type( $shipping_row ), $shipping_row->shipping_override_rate, $shipping_row->free_shipping_at ) );
				
				// Live Based	
				}else if( $this->is_live_based( $shipping_row ) ){	
					array_push( $this->live_based, array( $shipping_row->shipping_code, $GLOBALS['language']->convert_text( $shipping_row->shipping_label ), $shipping_row->shippingrate_id, $this->get_live_type( $shipping_row ), $shipping_row->shipping_override_rate, $shipping_row->free_shipping_at ) );
				}
			}
			
			$this->subtotal = $subtotal;
			$this->weight = $weight;
			$this->width = $width;
			$this->height = $height;
			$this->length = $length;
			$this->quantity = $quantity;
			$this->express_price = $this->ec_setting->get_setting( "shipping_expedite_rate" );
			if( isset( $_SESSION['ec_ship_express'] ) ){
				$this->ship_express = $_SESSION['ec_ship_express'];
			}
			
			$this->display_type = $display_type;
		}
	}
	
	private function is_live_based( $shipping_row ){
		if( $shipping_row->is_ups_based || $shipping_row->is_usps_based || $shipping_row->is_fedex_based || $shipping_row->is_auspost_based || $shipping_row->is_dhl_based || $shipping_row->is_canadapost_based )
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
		else if( $shipping_row->is_dhl_based )
			return "dhl";
		else if( $shipping_row->is_canadapost_based )
			return "canadapost";
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
			
		else if( $this->shipping_method == "quantity" )
			return $this->get_quantity_based_shipping_options( $standard_text, $express_text );
			
		else if( $this->shipping_method == "percentage" )
			return $this->get_percentage_based_shipping_options( $standard_text, $express_text );
			
		else if( $this->shipping_method == "live" )
			return $this->get_live_based_shipping_options( $standard_text, $express_text );
			
		else if( $this->shipping_method == "fraktjakt" )
			return $this->get_fraktjakt_based_shipping_options( );
			
	}
	
	private function get_price_based_shipping_options( $standard_text, $express_text ){
		if( count( $this->price_based ) > 0 ){
			for( $i=0; $i<count($this->price_based); $i++){
				if( $this->subtotal >= $this->price_based[$i][0] )
					return $this->get_single_shipping_price_content( $standard_text, $express_text, $this->price_based[$i][1] );
			}
		}else{
			return "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\">Shipping Rate Setup ERROR: Please visit the EasyCart Admin -> Store Admin -> Rates and add at least one price trigger. If you have done this, check to ensure no gaps in triggers.</div>";
		}
	}
	
	private function get_weight_based_shipping_options( $standard_text, $express_text ){
		if( count( $this->weight_based ) > 0 ){
			for( $i=0; $i<count($this->weight_based); $i++){
				if( $this->weight >= $this->weight_based[$i][0] )
					return $this->get_single_shipping_price_content( $standard_text, $express_text, $this->weight_based[$i][1] );
			}
		}else{
			return "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\">Shipping Rate Setup ERROR: Please visit the EasyCart Admin -> Store Admin -> Rates and add at least one weight trigger. If you have done this, check to ensure no gaps in triggers.</div>";
		}
	}
	
	private function get_method_based_shipping_options( $standard_text, $express_text ){
		if( count( $this->method_based ) > 0 ){ 
		
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
		
		}else{
			return "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\">Shipping Rate Setup ERROR: Please visit the EasyCart Admin -> Store Admin -> Rates and add at least one shipping method.</div>";
		}
	}
	
	private function get_quantity_based_shipping_options( $standard_text, $express_text ){
		if( count( $this->quantity_based ) > 0 ){
			for( $i=0; $i<count($this->quantity_based); $i++){
				if( $this->quantity >= $this->quantity_based[$i][0] )
					return $this->get_single_shipping_price_content( $standard_text, $express_text, $this->quantity_based[$i][1] );
			}
		}else{
			return "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\">Shipping Rate Setup ERROR: Please visit the EasyCart Admin -> Store Admin -> Rates and add at least one quantity trigger. If you have done this, check to ensure no gaps in triggers.</div>";
		}
	}
	
	private function get_percentage_based_shipping_options( $standard_text, $express_text ){
		if( count( $this->percentage_based ) > 0 ){
			for( $i=0; $i<count($this->percentage_based); $i++){
				if( $this->subtotal >= $this->percentage_based[$i][0] )
					return $this->get_single_shipping_price_content( $standard_text, $express_text, $this->subtotal * ( $this->percentage_based[$i][1] / 100 ) );
			}
		}else{
			return "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\">Shipping Rate Setup ERROR: Please visit the EasyCart Admin -> Store Admin -> Rates and add at least one quantity trigger. If you have done this, check to ensure no gaps in triggers.</div>";
		}
	}
	
	private function get_live_based_shipping_options( $standard_text, $express_text ){
		
		if( count( $this->live_based ) > 0 ){ 
		
			$ret_string = "";
			
			if( $this->display_type == "SELECT" )
				$ret_string .= "<select name=\"ec_cart_shipping_method\" onchange=\"ec_cart_shipping_method_change();\">";
			
			for( $i=0; $i<count( $this->live_based ); $i++){
				$service_days = 0;
				if( $this->live_based[$i][4] != NULL ){
					if( $this->live_based[$i][4] == 0 )
						$rate = "FREE";
					else
						$rate = $this->live_based[$i][4];
						
				}else if( $this->live_based[$i][5] > 0 && $this->subtotal >= $this->live_based[$i][5] ) // Shipping free at rate
					$rate = "FREE";
					
				else{
					$rate = $this->shipper->get_rate( $this->live_based[$i][3], $this->live_based[$i][0], $this->destination_zip, $this->destination_country, $this->weight, $this->length, $this->width, $this->height, $this->subtotal, $this->cart );
					$service_days = $this->shipper->get_service_days( $this->live_based[$i][3], $this->live_based[$i][0] );
				}
				
				if( $this->display_type == "RADIO" )
					$ret_string .= $this->get_live_based_radio( $i, $rate, $service_days );
				
				else if( $this->display_type == "SELECT" )
					$ret_string .= $this->get_live_based_select( $i, $rate );
				
				else //default is div
					$ret_string .= $this->get_live_based_div( $i, $rate );
			}
			
			if( $this->display_type == "SELECT" )
			$ret_string .= "</select>";
			
			return $ret_string;
			
		}else{
			return "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\">Shipping Rate Setup ERROR: Please visit the EasyCart Admin -> Store Admin -> Rates and add at least one shipping method for your selected live based shipping company. If you have done this and are still seeing this error, then likely there is a setup error in the live based company settings. Feel free to contact us at www.wpeasycart.com to get help troubleshooting.</div>";
		}
	}
	
	private function get_fraktjakt_based_shipping_options( ){
		
		$i = 0;
		$selected_method = 0;
		if( isset( $_SESSION['ec_shipping_method'] ) )
			$selected_method = $_SESSION['ec_shipping_method'];
			
		$ret_string = "";
		foreach( $this->fraktjakt_shipping_options as $shipping_option ){
			$ret_string .= "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\"><input type=\"radio\" name=\"ec_cart_shipping_method\" id=\"ec_cart_shipping_method\" value=\"" . $shipping_option['id'] . "\"";
			if( ( !$selected_method && $i == 0 ) || ( $selected_method == $shipping_option['id'] ) )
				$ret_string .= " checked=\"checked\"";
				
			$ret_string .= ">" . $shipping_option['description'] . " (" . $GLOBALS['currency']->symbol . "<span id=\"ec_cart_standard_shipping_price\">" . $GLOBALS['currency']->get_number_only( $shipping_option['price'] + $this->handling ) . "</span>)</div>";
			$i++;
		}
		return $ret_string;
		
	}
	
	private function get_method_based_radio( $i ){
		
		$ret_string = "";
		
		$ret_string .= "<div class=\"ec_cart_shipping_method_row\">";
		$ret_string .= "<input type=\"radio\" name=\"ec_cart_shipping_method\" value=\"" . $this->method_based[$i][2] . "\" onchange=\"ec_cart_shipping_method_change('" . $this->method_based[$i][2] . "'); \"";
		
		if( ( !isset( $_SESSION['ec_shipping_method'] ) && $i==0 ) || ( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->method_based[$i][2] ) )
		$ret_string .= " checked=\"checked\"";
		
		if( $this->method_based[$i][3] > 0 && $this->subtotal >= $this->method_based[$i][3] )
			$rate = 0;
			
		else
			$rate = $this->method_based[$i][0] + $this->handling;
		
		$ret_string .= " /> " . $this->method_based[$i][1] . " (" . $GLOBALS['currency']->get_currency_display( $rate ) . ")</div>";
		
		return $ret_string;
	}
	
	private function get_method_based_select( $i ){
		
		$ret_string = "";
		$ret_string .= "<option value=\"" . $this->method_based[$i][2] . "\"";
		
		if( ( !isset( $_SESSION['ec_shipping_method'] ) && $i==0 ) || ( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->method_based[$i][2] ) )
		$ret_string .= " selected=\"selected\"";
		
		if( $this->method_based[$i][3] > 0 && $this->subtotal >= $this->method_based[$i][3] )
			$rate = 0;
			
		else
			$rate = $this->method_based[$i][0] + $this->handling;
		
		$ret_string .= "> " . $this->method_based[$i][1] . " (" . $GLOBALS['currency']->get_currency_display( $rate ) . ")</option>";
		
		return $ret_string;
	}
	
	private function get_method_based_div( $i ){
		
		$ret_string = "";
		
		if( $this->method_based[$i][3] > 0 && $this->subtotal >= $this->method_based[$i][3] )
			$rate = 0;
			
		else
			$rate = $this->method_based[$i][0] + $this->handling;
		
		$ret_string .= "<div class=\"ec_cart_shipping_method_row\ id=\"" . $this->method_based[$i][2] . "\"> " . $this->method_based[$i][1] . " (" . $GLOBALS['currency']->get_currency_display( $rate ) . ")</div>";
		
		return $ret_string;
	}
	
	private function get_live_based_radio( $i, $rate, $service_days = 0 ){
		
		if( $rate != "ERROR" ){
			if( $rate == "FREE" )
				$rate = 0;
			else
				$rate = doubleval( $rate ) + doubleval( $this->handling );
		
			$ret_string = "";
			
			$ret_string .= "<div class=\"ec_cart_shipping_method_row\">";
			$ret_string .= "<input type=\"radio\" name=\"ec_cart_shipping_method\" value=\"" . $this->live_based[$i][2] . "\" onchange=\"ec_cart_shipping_method_change('" . $this->live_based[$i][2] . "', " . $rate . " ); \"";
			
			if( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->live_based[$i][2] )
				$ret_string .= " checked=\"checked\"";
			else if( !isset( $_SESSION['ec_shipping_method'] ) && $i == 0 ){
				$ret_string .= " checked=\"checked\"";
			}
			
			$ret_string .= " /><span class=\"label\">" . $this->live_based[$i][1];
			if( $service_days > 0 )
				$ret_string .= " (" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'delivery_in' ) . " " . $service_days . "-" . ($service_days+1) . " " . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'delivery_days' ) . ")";
			
			$ret_string .= "</span> <span class=\"price\">" . $GLOBALS['currency']->get_currency_display( $rate ) . "</span></div>";
			
			return $ret_string;
			
		}
		
	}
	
	private function get_live_based_select( $i, $rate ){
		
		if( $rate != "ERROR" ){
			
			if( $rate == "FREE" )
				$rate = 0;
			else
				$rate = doubleval( $rate ) + doubleval( $this->handling );
			
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
			
			if( $rate == "FREE" )
				$rate = 0;
			else
				$rate = doubleval( $rate ) + doubleval( $this->handling );
			
			$ret_string = "<div id=\"" . $this->live_based[$i][0] . "\"> " . $this->live_based[$i][1] . " " . $GLOBALS['currency']->get_currency_display( $rate ) . "</div>";
			return $ret_string;
		}
		
	}
	
	public function get_selected_shipping_method( ){
		
		$selected_shipping_method_id = 0;
		if( isset( $_SESSION['ec_shipping_method'] ) )
			$selected_shipping_method_id = $_SESSION['ec_shipping_method'];
			
		if( $this->shipping_method == "price" ){
			if( $this->ship_express ){
				echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' );
			}else{
				echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' );
			}
		}else if( $this->shipping_method == "weight" ){
			if( $this->ship_express ){
				echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' );
			}else{
				echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' );
			}
		}else if( $this->shipping_method == "method" ){
			
			for( $i=0; $i<count($this->method_based); $i++){
				if( $this->method_based[$i][2] == $selected_shipping_method_id ){
					return $this->get_method_based_div( $i );
				}
			}
		
		}else if( $this->shipping_method == "live" ){
			for( $i=0; $i<count($this->live_based); $i++){
				if( $this->live_based[$i][2] == $selected_shipping_method_id ){
					if( $this->live_based[$i][4] ){
						if( $this->live_based[$i][4] == 0 )
							$rate = "FREE";
						else
							$rate = $this->live_based[$i][4];
						return "<div id=\"" . $this->live_based[$i][0] . "\"> " . $this->live_based[$i][1] . " " . $GLOBALS['currency']->get_currency_display( $rate ) . "</div>";
					}else
						$rate = doubleval( $this->shipper->get_rate( $this->live_based[$i][3], $this->live_based[$i][0], $this->destination_zip, $this->destination_country, $this->weight, $this->length, $this->width, $this->height, $this->subtotal, $this->cart ) ) + doubleval( $this->handling );
					
					return $this->get_live_based_div( $i, $rate + $this->handling );
				}
			}
		
		}else if( $this->shipping_method == "fraktjakt" ){
			
			$i = 0;
			$selected_method = 0;
			if( isset( $_SESSION['ec_shipping_method'] ) )
				$selected_method = $_SESSION['ec_shipping_method'];
				
			$ret_string = "";
			foreach( $this->fraktjakt_shipping_options as $shipping_option ){
				if( ( !$selected_method && $i == 0 ) || ( $selected_method == $shipping_option['id'] ) )
					return $shipping_option['description'];
					
				$i++;
			}
		}
		
	}
	
	public function get_single_shipping_price_content( $standard_text, $express_text, $standard_price ){
		
		$coupon_code = "";
		if( isset( $_SESSION['ec_couponcode'] ) )
			$coupon_code = $_SESSION['ec_couponcode'];
			
		$discount = new ec_discount( array(), 0.00, $standard_price, $coupon_code, "", 0 );
		$shipping_discount = $discount->shipping_discount;
		
		$ret_string = "";
		$ret_string .= "<div id=\"ec_cart_standard_shipping_row\" class=\"ec_cart_shipping_method_row\"><input type=\"radio\" name=\"ec_cart_shipping_method\" id=\"ec_cart_shipping_method\" value=\"standard\" checked=\"checked\" />" . $standard_text . " (" . $GLOBALS['currency']->symbol . "<span id=\"ec_cart_standard_shipping_price\">" . $GLOBALS['currency']->get_number_only( $standard_price + $this->handling - $shipping_discount ) . "</span>)</div>";
		if( $this->express_price > 0 ){
			$ret_string .= "<div id=\"ec_cart_express_shipping_row\" class=\"ec_cart_shipping_method_row\"><input type=\"checkbox\" name=\"ec_cart_ship_express\" id=\"ec_cart_ship_express\" value=\"shipexpress\"";
			if( $this->ship_express )
				$ret_string .= " checked=\"checked\"";
			$ret_string .= " />" . $express_text . " (+" . $GLOBALS['currency']->symbol . "<span id=\"ec_cart_express_shipping_price\">" . $GLOBALS['currency']->get_number_only( $this->express_price ) . "</span>)</div>";
		}
		return $ret_string;
	}
	
	public function get_shipping_price( ){
		if( $this->freeshipping ){
			return "0.00";
		}
		
		$rate = "ERROR";
		if( $this->shipping_method == "price" ){
			for( $i=0; $i<count( $this->price_based ); $i++ ){
				if( $this->subtotal >= $this->price_based[$i][0] ){
					$rate = $this->price_based[$i][1];
					break;
				}
				
			}
			if( $this->ship_express )
				$rate = $rate + $this->express_price;
			
		}else if( $this->shipping_method == "weight" ){
			for( $i=0; $i<count( $this->weight_based ); $i++ ){
				if( $this->weight >= $this->weight_based[$i][0] ){
					$rate = $this->weight_based[$i][1];
					break;
				}
			}
			if( $this->ship_express )
				$rate = $rate + $this->express_price;
			
		}else if( $this->shipping_method == "method" ){
			if( $this->subtotal <= 0 )
				$rate = "0.00";
			
			else if( !isset( $_SESSION['ec_shipping_method'] ) ){
				if( $this->method_based[0][3] > 0 && $this->subtotal >= $this->method_based[0][3] ){
					$rate = 0;
				}else{
					$rate = $this->method_based[0][0];
				}
			
			}else{
				$rate_found = false;
				for( $i=0; $i<count( $this->method_based ); $i++ ){
					if( $_SESSION['ec_shipping_method'] == $this->method_based[$i][2] ){
						if( $this->method_based[$i][3] > 0 && $this->subtotal >= $this->method_based[$i][3] ){
							$rate = 0;
						}else{
							$rate = $this->method_based[$i][0];
						}
						$rate_found = true;
					}
				}
				
				if( !$rate_found ){
					if( $this->method_based[0][3] > 0 && $this->subtotal >= $this->method_based[0][3] ){
						$rate = 0;
					}else{
						$rate = $this->method_based[0][0];
					}
				}
			}
			
		}else if( $this->shipping_method == "quantity" ){
			for( $i=0; $i<count( $this->quantity_based ); $i++ ){
				if( $this->quantity >= $this->quantity_based[$i][0] ){
					$rate = $this->quantity_based[$i][1];
					break;
				}
				
			}
			if( $this->ship_express )
				$rate = $rate + $this->express_price;
			
		}else if( $this->shipping_method == "percentage" ){
			for( $i=0; $i<count( $this->percentage_based ); $i++ ){
				if( $this->subtotal >= $this->percentage_based[$i][0] ){
					$rate = ( $this->subtotal * ( $this->percentage_based[$i][1] / 100 ) );
					break;
				}
				
			}
			if( $this->ship_express )
				$rate = $rate + $this->express_price;
			
		}else if( $this->shipping_method == "live" ){
			if( !isset( $_SESSION['ec_temp_zipcode'] ) && !isset( $_SESSION['ec_shipping_method'] ) && !isset( $_SESSION['ec_email'] ) )
				return doubleval( "0.00" );
				
			$lowest = 100000.00;
			$lowest_ship_method = "ERROR";
			
			for( $i=0; $i<count( $this->live_based ); $i++ ){
				
				if( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] == $this->live_based[$i][2] ){
					if( $this->live_based[$i][4] != NULL ){
						if( $this->live_based[$i][4] == 0 )
							$rate = "FREE";
						else
							$rate = $this->live_based[$i][4];
					}else if( $this->live_based[$i][5] > 0 && $this->subtotal >= $this->live_based[$i][5] ) // Shipping free at rate
						$rate = "FREE";
					else
						$rate = $this->shipper->get_rate( $this->live_based[$i][3], $this->live_based[$i][0], $this->destination_zip, $this->destination_country, $this->weight, $this->length, $this->width, $this->height, $this->subtotal, $this->cart );
					
				}else{
				
					// Find lowest
					if( $this->live_based[$i][4] != NULL && $this->live_based[$i][4] > 0 )
						$subrate = $this->live_based[$i][4];
					else if( $this->live_based[$i][5] > 0 && $this->subtotal >= $this->live_based[$i][5] ) // Shipping free at rate
						$subrate = 0; // If user is over free shipping limit, return 0 all the time!
					else
						$subrate = $this->shipper->get_rate( $this->live_based[$i][3], $this->live_based[$i][0], $this->destination_zip, $this->destination_country, $this->weight, $this->length, $this->width, $this->height, $this->subtotal, $this->cart );
					
					if( $subrate != "ERROR" && floatval( $subrate ) < $lowest ){
						$lowest = floatval( $subrate );
						$lowest_ship_method = $this->live_based[$i][2];
					}
					
				}
				
			}
			
			if( $rate == "ERROR" && $lowest_ship_method != "ERROR" ){
				$rate = $lowest;
				//if( isset( $this->destination_zip ) )
					//$_SESSION['ec_shipping_method'] = $lowest_ship_method;
			}
			
		}else if( $this->shipping_method == "fraktjakt" ){
			$i = 0;
			$selected_method = 0;
			if( isset( $_SESSION['ec_shipping_method'] ) )
				$selected_method = $_SESSION['ec_shipping_method'];
			
			if( $this->fraktjakt_shipping_options ){
				$backup = 0.00;
				$frak_is_found = false;
				foreach( $this->fraktjakt_shipping_options as $shipping_option ){
					if( ( !$selected_method && $i == 0 ) || ( $selected_method == $shipping_option['id'] ) ){
						$rate = $shipping_option['price'];
						$frak_is_found = true;
					}else if( $i == 0 )
						$backup = $shipping_option['price'];
						
					$i++;
				}
				
				if( !$frak_is_found )
					$rate = $backup;
			}
		}
		
		$promotion = new ec_promotion( );
		$discount = $promotion->get_shipping_discounts( $this->subtotal, $rate, $this->shipping_promotion_text );
		
		if( $rate == "ERROR" ){
			return doubleval( "0.00" );
		}else if( $rate == "FREE" ){
			return 0;
		}else{
			// Add the Handling Rate
			$rate = doubleval( $rate ) + doubleval( $this->handling );
			return doubleval( $rate ) - doubleval( $discount );
		}
	}
	
	public function get_shipping_promotion_text( ){
		$promotion = new ec_promotion( );
		$rate = 0;
		$promotion->get_shipping_discounts( $this->subtotal, $rate, $this->shipping_promotion_text );
		return $this->shipping_promotion_text;
	}
	
	public function submit_fraktjakt_shipping_order( ){
		$shipment_id = 0;
		$i = 0;
		$selected_method = 0;
		if( isset( $_SESSION['ec_shipping_method'] ) )
			$selected_method = $_SESSION['ec_shipping_method'];
		
		foreach( $this->fraktjakt_shipping_options as $shipping_option ){
			if( $selected_method == $shipping_option['id'] )
				$shipment_id = $shipping_option['shipment_id']; 
		}
		
		return $this->fraktjakt->insert_shipping_order( $shipment_id, $_SESSION['ec_shipping_method'] );
	}
	
	public function validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country ){
		
		if( $this->shipping_method == "live" ){
			
			return $this->shipper->validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country );
		
		}else if( $this->shipping_method == "fraktjakt" ){
			return $this->fraktjakt->validate_address( $destination_address, $destination_city, $destination_state, $destination_zip, $destination_country );
		
		}else
			return true;
			
	}
}

?>