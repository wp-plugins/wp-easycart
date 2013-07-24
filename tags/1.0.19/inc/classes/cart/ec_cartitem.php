<?php

class ec_cartitem{
	
	public $cartitem_id;											// INT
	public $product_id;												// INT
	public $model_number;											// VARCHAR 255
	public $manufacturer_id;										// INT
	
	public $quantity;												// INT
	public $weight;													// INT
	
	public $title;													// VARCHAR 255
	
	public $unit_price;												// FLOAT 11,2
	public $total_price;											// FLOAT 11,2
	public $prev_price;												// FLOAT 11,2
	public $handling_price;											// FLOAT 11,2
	public $pricetiers = array();									// Array of rows of ec_pricetier
	
	public $vat_rate;												// FLAOT 11,2
	
	public $non_vat_unit_price;										// FLOAT 11,2
	public $non_vat_total_price;									// FLOAT 11,2
	
	public $is_giftcard;											// BOOL
	public $is_download;											// BOOL
	public $is_donation;											// BOOL
	public $is_taxable;												// BOOL
	
	public $image1;													// VARCHAR 255
	public $image1_optionitem;										// VARCHAR 255
	
	public $optionitem1_name;										// VARCHAR 255
	public $optionitem2_name;										// VARCHAR 255
	public $optionitem3_name;										// VARCHAR 255
	public $optionitem4_name;										// VARCHAR 255
	public $optionitem5_name;										// VARCHAR 255
	
	public $optionitem1_label;										// VARCHAR 255
	public $optionitem2_label;										// VARCHAR 255
	public $optionitem3_label;										// VARCHAR 255
	public $optionitem4_label;										// VARCHAR 255
	public $optionitem5_label;										// VARCHAR 255
	
	public $optionitem1_price;										// FLOAT 7,2
	public $optionitem2_price;										// FLOAT 7,2
	public $optionitem3_price;										// FLOAT 7,2
	public $optionitem4_price;										// FLOAT 7,2
	public $optionitem5_price;										// FLOAT 7,2
	
	public $optionitem1_id;											// INT
	public $optionitem2_id;											// INT
	public $optionitem3_id;											// INT
	public $optionitem4_id;											// INT
	public $optionitem5_id;											// INT
	
	public $gift_card_message;										// TEXT
	public $gift_card_from_name;									// VARCHAR 255
	public $gift_card_to_name;										// VARCHAR 255
	
	public $donation_price;											// FLOAT 9,2
	
	public $download_file_name;										// VARCHAR 255
	public $use_optionitem_quantity_tracking;						// BOOL
	
	public $promotions;												// array of promtions
	
	private $store_page;											// VARCHAR
	private $cart_page;												// VARCHAR
	private $permalink_divider;										// CHAR
	
	private $currency;												// ec_currency structure
	
	function __construct( $cartitem_data ){
		$this->cartitem_id = $cartitem_data->cartitem_id;
		$this->product_id = $cartitem_data->product_id;
		$this->model_number = $cartitem_data->model_number;
		$this->manufacturer_id = $cartitem_data->manufacturer_id;
		
		$this->quantity = $cartitem_data->quantity;
		$this->weight = $cartitem_data->weight;
		
		$this->title = $cartitem_data->title;
		
		$this->is_giftcard = $cartitem_data->is_giftcard;
		$this->is_download = $cartitem_data->is_download;
		$this->is_donation = $cartitem_data->is_donation;
		$this->is_taxable = $cartitem_data->is_taxable;
		
		$this->image1 = $cartitem_data->image1;
		$this->image1_optionitem = $cartitem_data->optionitemimage_image1;
		
		if($cartitem_data->optionitem1_data){
			$option = explode("***", $cartitem_data->optionitem1_data);
			$this->optionitem1_name = $option[0]; 
			$this->optionitem1_price = $option[1];
			$this->optionitem1_label = $option[2];
			$this->optionitem1_id = $option[3];
		}else{
			$this->optionitem1_name = ""; $this->optionitem1_price = 0.00;
		}
		
		if($cartitem_data->optionitem2_data){
			$option = explode("***", $cartitem_data->optionitem2_data);
			$this->optionitem2_name = $option[0]; 
			$this->optionitem2_price = $option[1];
			$this->optionitem2_label = $option[2];
			$this->optionitem2_id = $option[3];
		}else{
			$this->optionitem2_name = ""; $this->optionitem2_price = 0.00;
		}
		
		if($cartitem_data->optionitem3_data){
			$option = explode("***", $cartitem_data->optionitem3_data);
			$this->optionitem3_name = $option[0]; 
			$this->optionitem3_price = $option[1];
			$this->optionitem3_label = $option[2];
			$this->optionitem3_id = $option[3];
		}else{
			$this->optionitem3_name = ""; $this->optionitem3_price = 0.00;
		}
		
		if($cartitem_data->optionitem4_data){
			$option = explode("***", $cartitem_data->optionitem4_data);
			$this->optionitem4_name = $option[0]; 
			$this->optionitem4_price = $option[1];
			$this->optionitem4_label = $option[2];
			$this->optionitem4_id = $option[3];
		}else{
			$this->optionitem4_name = ""; $this->optionitem4_price = 0.00;
		}
		
		if($cartitem_data->optionitem5_data){
			$option = explode("***", $cartitem_data->optionitem5_data);
			$this->optionitem5_name = $option[0]; 
			$this->optionitem5_price = $option[1];
			$this->optionitem5_label = $option[2];
			$this->optionitem5_id = $option[3];
		}else{
			$this->optionitem5_name = ""; $this->optionitem5_price = 0.00;
		}
		
		if( $cartitem_data->pricetier_data ){
			$pricetiers = explode( "---", $cartitem_data->pricetier_data );
			for( $i=0; $i<count( $pricetiers ); $i++ ){
				$pricetier = explode( "***", $pricetiers[$i] );
				$this->pricetiers[$i] = array( $pricetier[0], $pricetier[1] );
			}
		}
		
		$this->gift_card_message = $cartitem_data->gift_card_message;
		$this->gift_card_from_name = $cartitem_data->gift_card_from_name;
		$this->gift_card_to_name = $cartitem_data->gift_card_to_name;
		
		$this->download_file_name = $cartitem_data->download_file_name;
		$this->maximum_downloads_allowed = $cartitem_data->maximum_downloads_allowed;
		$this->download_timelimit_seconds = $cartitem_data->download_timelimit_seconds;
		
		$this->use_optionitem_quantity_tracking = $cartitem_data->use_optionitem_quantity_tracking;
		
		$this->donation_price = $cartitem_data->donation_price;
		
		$options_price = $this->optionitem1_price + $this->optionitem2_price + $this->optionitem3_price + $this->optionitem4_price + $this->optionitem5_price;
		
		if( $this->is_donation ){
			$this->unit_price = $cartitem_data->donation_price;
		}else if( count( $this->pricetiers ) > 0 ){
			$this->unit_price = $cartitem_data->price + $options_price;
			for( $i=0; $i<count( $this->pricetiers ); $i++ ){
				if( $this->quantity >= $this->pricetiers[$i][1] ){
					$this->unit_price = $this->pricetiers[$i][0] + $options_price;	
				}
			}
		}else{
			$this->unit_price = $cartitem_data->price + $options_price;	
		}
		
		$this->total_price = $this->unit_price * $this->quantity;
		$this->handling_price = $cartitem_data->handling_price;
		
		$this->vat_rate = $cartitem_data->vat_rate;
		
		$vat_rate = ( $this->vat_rate / 100 );
		
		$this->non_vat_unit_price = ( $this->unit_price / ( 1 + $vat_rate ) );
		$this->vat_unit_price = ( $this->unit_price - $this->non_vat_unit_price );
		
		$this->non_vat_total_price = ( $this->total_price / ( 1 + $vat_rate ) );
		$this->vat_total_price = ( $this->total_price - $this->non_vat_total_price );
			
		$store_page_id = get_option('ec_option_storepage');
		$this->store_page = get_permalink( $store_page_id );
		
		$cart_page_id = get_option('ec_option_cartpage');
		$this->cart_page = get_permalink( $cart_page_id );
		
		if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		$this->currency = new ec_currency( );
	}
	
	public function display_cartitem_id(){
		echo $this->cartitem_id;
	}
	
	public function get_quantity(){
		return $this->quantity;
	}
	
	public function display_quantity(){
		echo $this->quantity;
	}
	
	public function get_item_unit_price(){
		return $this->unit_price;
	}
	
	public function get_discount_unit_price(){
		if( $this->discount_price )
		return $this->discount_price;	
	}
	
	public function get_item_total(){
		return $this->total_price;
	}
	
	public function get_weight(){
		return ($this->weight * $this->quantity);
	}
	
	public function get_shippable_total(){
		if( !$this->is_giftcard && !$this->is_download && !$this->is_donation ){
			return $this->total_price;
		}else{
			return 0;
		}
	}
	
	public function display_image( $size ){
		
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->model_number;
		
		if( $this->image1_optionitem )
			echo "&optionitem_id=" . $this->optionitem1_id . "\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/products/pics1/" . $this->image1_optionitem ) . "\" alt=\"" . $this->model_number . "\" />";
		else
			echo "\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/products/pics1/" . $this->image1 ) . "\" alt=\"" . $this->model_number . "\" />";
			
		echo "</a>";
		
	}
	
	public function display_title( ){
		echo $this->title;
	}
	
	public function display_title_link( ){
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->model_number;
		
		if( $this->image1_optionitem )
			echo "&optionitem_id=" . $this->optionitem1_id;
		
		echo "\">" . $this->title . "</a>";
	}
	
	public function has_option1( ){
		if( $this->optionitem1_name )
			return true;
		else
			return false;
	}
	
	public function display_option1( ){
		if( $this->optionitem1_price == "0.00" &&  $this->optionitem1_name)
			echo $this->optionitem1_label . ": " . $this->optionitem1_name;
		else if( $this->optionitem1_name )
			echo $this->optionitem1_label . ": " . $this->optionitem1_name . " ( " . $this->currency->get_currency_display( $this->optionitem1_price ) . " )";
	}
	
	public function has_option2( ){
		if( $this->optionitem2_name )
			return true;
		else
			return false;
	}
	
	public function display_option2( ){
		if( $this->optionitem2_price == "0.00" &&  $this->optionitem2_name )
			echo $this->optionitem2_label . ": " . $this->optionitem2_name;
		else if( $this->optionitem2_name )
			echo $this->optionitem2_label . ": " . $this->optionitem2_name . " ( " . $this->currency->get_currency_display( $this->optionitem2_price ) . " )";
	}
	
	public function has_option3( ){
		if( $this->optionitem3_name )
			return true;
		else
			return false;
	}
	
	public function display_option3( ){
		if( $this->optionitem3_price == "0.00" &&  $this->optionitem3_name )
			echo $this->optionitem3_label . ": " . $this->optionitem3_name;
		else if( $this->optionitem3_name )
			echo $this->optionitem3_label . ": " . $this->optionitem3_name . " ( " . $this->currency->get_currency_display( $this->optionitem3_price ) . " )";
	}
	
	public function has_option4( ){
		if( $this->optionitem4_name )
			return true;
		else
			return false;
	}
	
	public function display_option4( ){
		if( $this->optionitem4_price == "0.00" &&  $this->optionitem4_name )
			echo $this->optionitem4_label . ": " . $this->optionitem4_name;
		else if( $this->optionitem4_name )
			echo $this->optionitem4_label . ": " . $this->optionitem4_name . " ( " . $this->currency->get_currency_display( $this->optionitem4_price ) . " )";
	}
	
	public function has_option5( ){
		if( $this->optionitem5_name )
			return true;
		else
			return false;
	}
	
	public function display_option5( ){
		if( $this->optionitem5_price == "0.00" &&  $this->optionitem5_name )
			echo $this->optionitem5_label . ": " . $this->optionitem5_name;
		else if( $this->optionitem5_name )
			echo $this->optionitem5_label . ": " . $this->optionitem5_name . " ( " . $this->currency->get_currency_display( $this->optionitem5_price ) . " )";
	}
	
	public function has_gift_card_message( ){
		if( $this->gift_card_message )
			return true;
		else
			return false;
	}
	
	public function display_gift_card_message( $message_text ){
		if( $this->gift_card_message )
			echo $message_text . $this->gift_card_message;
	}
	
	public function has_gift_card_from_name( ){
		if( $this->gift_card_from_name )
			return true;
		else
			return false;
	}
	
	public function display_gift_card_from_name( $from_text ){
		if( $this->gift_card_from_name )
			echo $from_text . $this->gift_card_from_name;
	}
	
	public function has_gift_card_to_name( ){
		if( $this->gift_card_to_name )
			return true;
		else
			return false;
	}
	
	public function display_gift_card_to_name( $to_text ){
		if( $this->gift_card_to_name )
			echo $to_text . $this->gift_card_to_name;
	}
	
	public function display_update_form_start( ){
		$cartpageid = get_option('ec_option_cartpage');
		$cartpage = get_permalink( $cartpageid );
		
		echo "<form action=\"" . $cartpage . "\">";	
	}
	
	public function display_update_form_end( ){
		echo "<input type=\"hidden\" name=\"ec_update_cartitem_id\" id=\"ec_update_cartitem_id_" . $this->cartitem_id . "\" value=\"" . $this->cartitem_id . "\" />";
		echo "<input type=\"hidden\" name=\"ec_action\" id=\"ec_update_action\" />";
		echo "</form>";	
	}
	
	public function display_quantity_box( ){
		echo "<input type=\"number\" id=\"ec_cartitem_quantity_" . $this->cartitem_id . "\" name=\"ec_cartitem_quantity_" . $this->cartitem_id . "\" value=\"" . $this->quantity . "\" min=\"1\" />";
	}
	
	public function display_update_button( $update_text ){
		echo "<input type=\"submit\" id=\"update_" . $this->cartitem_id . "\" name=\"update_" . $this->cartitem_id . "\" value=\"" . $update_text . "\" onclick=\"ec_cart_item_update( '" . $this->cartitem_id . "' ); return false;\" />";
	}
	
	public function display_delete_button( $remove_text ){
		$cartpageid = get_option('ec_option_cartpage');
		$cartpage = get_permalink( $cartpageid );
		
		echo "<form action=\"" . $cartpage . "\">";
		echo "<input type=\"submit\" id=\"remove_" . $this->cartitem_id . "\" name=\"remove_" . $this->cartitem_id . "\" value=\"" . $remove_text . "\" onclick=\"ec_cart_item_delete( '" . $this->cartitem_id . "' ); return false;\"/>";
		echo "<input type=\"hidden\" name=\"ec_action\" id=\"ec_delete_action\" />";
		echo "</form>";
	}
	
	public function display_unit_price( $vat_enabled, $vat_country_match ){
		if( !$vat_enabled || ( $vat_enabled && $vat_country_match ) )
			$unit_price = $this->unit_price;
		else
			$unit_price = $this->non_vat_unit_price;
		
		echo "<span id=\"ec_cartitem_unit_price_" . $this->cartitem_id . "\">" . $this->currency->get_currency_display( $unit_price ) . "</span>";
		
		if( $this->prev_price )
			echo "<span id=\"ec_cartitem_prev_price_" . $this->cartitem_id . "\" class=\"ec_product_old_price\">" . $this->currency->get_currency_display( $this->prev_price ) . "</span>";
		
	}
	
	public function display_item_total( $vat_enabled, $vat_country_match ){
		if( !$vat_enabled || ( $vat_enabled && $vat_country_match ) )
			echo "<span id=\"ec_cartitem_total_" . $this->cartitem_id . "\">" . $this->currency->get_currency_display( $this->total_price ) . "</span>";
		else
			echo "<span id=\"ec_cartitem_total_" . $this->cartitem_id . "\">" . $this->currency->get_currency_display( $this->non_vat_total_price ) . "</span>";
	}
	
	public function display_vat_rate( $vat_country_match ){
		if( $vat_country_match )
			echo number_format( $this->vat_rate, 0 );	
		else
			echo number_format( 0, 0 );	
	}
	
	public function display_item_loader( ){
		echo "<div class=\"ec_cart_item_loader\" id=\"ec_cart_item_loader_" . $this->cartitem_id . "\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
	}
}

?>