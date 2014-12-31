<?php
class ec_paypal extends ec_third_party{
	
	public function display_form_start( ){
		$paypal_use_sandbox = get_option( 'ec_option_paypal_use_sandbox' );
		$paypal_email = get_option( 'ec_option_paypal_email' );
		$paypal_currency_code = get_option( 'ec_option_paypal_currency_code' );
		$paypal_lc = get_option( 'ec_option_paypal_lc' );
		$paypal_weight_unit = get_option( 'ec_option_paypal_weight_unit' );
		
		//this is actionscript version in flash
		if( $paypal_use_sandbox )			$paypal_request = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		else								$paypal_request = "https://www.paypal.com/cgi-bin/webscr";
		
		echo "<form action=\"" . $paypal_request . "\" method=\"post\">";
		echo "<input name=\"cmd\" id=\"cmd\" type=\"hidden\" value=\"_cart\" />";
		echo "<input name=\"upload\" id=\"upload\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"custom\" id=\"custom\" type=\"hidden\" value=\"" . $this->order_id . "\" />";
		echo "<input name=\"bn\" id=\"bn\" type=\"hidden\" value=\"LevelFourDevelopmentLLC_Cart\" />";
		echo "<input name=\"business\" id=\"business\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $paypal_email ) . "\" />";
		echo "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"" . $paypal_currency_code . "\" />";
		echo "<input name=\"handling_cart\" id=\"handling_cart\" type=\"hidden\" value=\"" . number_format($this->order->shipping_total, 2) . "\" />";
		echo "<input name=\"discount_amount_cart\" id=\"discount_amount_cart\" type=\"hidden\" value=\"" . number_format($this->order->discount_total, 2) . "\" />";
		$tax = new ec_tax( 0.00, 0.00, 0.00, $this->order->billing_state, $this->order->billing_country );
		if( $tax->vat_included ){
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . number_format($this->order->tax_total + $this->order->duty_total, 2) . "\" />";
		}else{
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . number_format($this->order->tax_total + $this->order->vat_total + $this->order->duty_total, 2) . "\" />";
		}
		echo "<input name=\"weight_cart\" id=\"weight_cart\" type=\"hidden\" value=\"" . $this->order->order_weight . "\" />";
		echo "<input name=\"weight_unit\" id=\"weight_unit\" type=\"hidden\" value=\"" . $paypal_weight_unit . "\" />";
		echo "<input name=\"amount\" id=\"amount\" type=\"hidden\" value=\"" . number_format($this->order->sub_total, 2) . "\" />";
		if( get_option( 'ec_option_paypal_collect_shipping' ) ){
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"2\" />";
		}else{
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"1\" />";
		}
		echo "<input name=\"lc\" id=\"lc\" type=\"hidden\" value=\"" . $paypal_lc . "\" />";
		echo "<input name=\"rm\" id=\"rm\" type=\"hidden\" value=\"2\" />";
		echo "<input name=\"notify_url\" id=\"notify_url\" type=\"hidden\" value=\"".  plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/paypal_payment_complete.php" ) ."\" />";
		echo "<input type=\"hidden\" name=\"return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order_id . "\" />";
		echo "<input type=\"hidden\" name=\"cancel_return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" />";
		
		//customer billing information and address info
		echo "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_first_name ) . "\" />";
		echo "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_last_name ) . "\" />";
		echo "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_address_line_1 ) . "\" />";
		echo "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_city ) . "\" />";
		echo "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', strtoupper($this->order->billing_state ) ) . "\" />";
		echo "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_zip ) . "\" />";
		echo "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_country ) . "\" />";
		echo "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->user_email ) . "\" />";
		
		//add the cart contents to paypal
		for( $i = 0; $i<count( $this->order_details ); $i++ ){
			$paypal_counter = $i+1;
			echo "<input name=\"item_name_" . $paypal_counter . "\" id=\"item_name_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order_details[$i]->title ) . "\" />";
			echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . number_format($this->order_details[$i]->unit_price, 2) . "\" />";
			echo "<input name=\"quantity_".$paypal_counter . "\" id=\"quantity_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $this->order_details[$i]->quantity . "\" />";
			echo "<input name=\"shipping_" . $paypal_counter . "\" id=\"shipping_" . $paypal_counter."\" type=\"hidden\" value=\"0.00\" />";
			echo "<input name=\"shipping2_" . $paypal_counter . "\" id=\"shipping2_" . $paypal_counter . "\" type=\"hidden\" value=\"0.00\" />";
		}
	}
	
	public function display_auto_forwarding_form( ){
		$paypal_use_sandbox = get_option( 'ec_option_paypal_use_sandbox' );
		$paypal_email = get_option( 'ec_option_paypal_email' );
		$paypal_currency_code = get_option( 'ec_option_paypal_currency_code' );
		$paypal_lc = get_option( 'ec_option_paypal_lc' );
		$paypal_weight_unit = get_option( 'ec_option_paypal_weight_unit' );
		
		//this is actionscript version in flash
		if( $paypal_use_sandbox )			$paypal_request = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		else								$paypal_request = "https://www.paypal.com/cgi-bin/webscr";
		
		echo "<form name=\"ec_paypal_standard_auto_form\" action=\"" . $paypal_request . "\" method=\"post\">";
		echo "<input name=\"cmd\" id=\"cmd\" type=\"hidden\" value=\"_cart\" />";
		echo "<input name=\"upload\" id=\"upload\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"custom\" id=\"custom\" type=\"hidden\" value=\"" . $this->order_id . "\" />";
		echo "<input name=\"bn\" id=\"bn\" type=\"hidden\" value=\"LevelFourDevelopmentLLC_Cart\" />";
		echo "<input name=\"business\" id=\"business\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $paypal_email ) . "\" />";
		echo "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"" . $paypal_currency_code . "\" />";
		echo "<input name=\"handling_cart\" id=\"handling_cart\" type=\"hidden\" value=\"" . number_format($this->order->shipping_total, 2) . "\" />";
		echo "<input name=\"discount_amount_cart\" id=\"discount_amount_cart\" type=\"hidden\" value=\"" . number_format($this->order->discount_total, 2) . "\" />";
		$tax = new ec_tax( 0.00, 0.00, 0.00, $this->order->billing_state, $this->order->billing_country );
		if( $tax->vat_included ){
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . number_format($this->order->tax_total + $this->order->duty_total, 2) . "\" />";
		}else{
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . number_format($this->order->tax_total + $this->order->vat_total + $this->order->duty_total, 2) . "\" />";
		}
		echo "<input name=\"weight_cart\" id=\"weight_cart\" type=\"hidden\" value=\"" . $this->order->order_weight . "\" />";
		echo "<input name=\"weight_unit\" id=\"weight_unit\" type=\"hidden\" value=\"" . $paypal_weight_unit . "\" />";
		echo "<input name=\"amount\" id=\"amount\" type=\"hidden\" value=\"" . number_format($this->order->sub_total, 2) . "\" />";
		if( get_option( 'ec_option_paypal_collect_shipping' ) ){
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"2\" />";
		}else{
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"1\" />";
		}
		echo "<input name=\"lc\" id=\"lc\" type=\"hidden\" value=\"" . $paypal_lc . "\" />";
		echo "<input name=\"rm\" id=\"rm\" type=\"hidden\" value=\"2\" />";
		echo "<input name=\"notify_url\" id=\"notify_url\" type=\"hidden\" value=\"".  plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/paypal_payment_complete.php" ) ."\" />";
		echo "<input type=\"hidden\" name=\"return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order_id . "\" />";
		echo "<input type=\"hidden\" name=\"cancel_return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" />";
		
		//customer billing information and address info
		echo "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_first_name ) . "\" />";
		echo "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_last_name ) . "\" />";
		echo "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_address_line_1 ) . "\" />";
		echo "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_city ) . "\" />";
		echo "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', strtoupper($this->order->billing_state ) ) . "\" />";
		echo "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_zip ) . "\" />";
		echo "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->billing_country ) . "\" />";
		echo "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order->user_email ) . "\" />";
		
		//add the cart contents to paypal
		for( $i = 0; $i<count( $this->order_details ); $i++ ){
			$paypal_counter = $i+1;
			echo "<input name=\"item_name_" . $paypal_counter . "\" id=\"item_name_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order_details[$i]->title ) . "\" />";
			echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . number_format($this->order_details[$i]->unit_price, 2) . "\" />";
			echo "<input name=\"quantity_".$paypal_counter . "\" id=\"quantity_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $this->order_details[$i]->quantity . "\" />";
			echo "<input name=\"shipping_" . $paypal_counter . "\" id=\"shipping_" . $paypal_counter."\" type=\"hidden\" value=\"0.00\" />";
			echo "<input name=\"shipping2_" . $paypal_counter . "\" id=\"shipping2_" . $paypal_counter . "\" type=\"hidden\" value=\"0.00\" />";
		}
		echo "</form>";
		echo "<SCRIPT data-cfasync=\"false\" LANGUAGE=\"Javascript\">document.ec_paypal_standard_auto_form.submit();</SCRIPT>";
	}
	
}
?>