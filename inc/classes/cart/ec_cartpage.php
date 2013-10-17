<?php

class ec_cartpage{
	protected $mysqli;							// ec_db structure
	public $cart;								// ec_cart structure
	public $user;								// ec_user structure
	public $tax;								// ec_tax structure
	public $shipping;							// ec_shipping structure
	public $discount;							// ec_discount structure
	public $order_totals;						// ec_order_totals structure
	public $payment;							// ec_payment structure
	public $order;								// ec_order structure
	public $coupon;								// ec_coupon structure
	public $giftcard;							// ec_giftcard structure
	
	public $coupon_code;						// VARCHAR
	public $gift_card;							// VARCHAR
	
	private $store_page;						// VARCHAR
	private $cart_page;							// VARCHAR
	private $account_page;						// VARCHAR
	private $permalink_divider;					// CHAR
	
	private $analytics;							// ec_googleanalytics class
	
	////////////////////////////////////////////////////////
	// CONSTUCTOR FUNCTION
	////////////////////////////////////////////////////////
	function __construct( ){
		$this->mysqli = new ec_db();
		
		$this->cart = new ec_cart( session_id() );
		
		$user_email = "";
		if( isset( $_SESSION['ec_email'] ) )
			$user_email = $_SESSION['ec_email'];
		
		$this->user = new ec_user( $user_email );
		
		if( isset( $_SESSION['ec_couponcode'] ) && $_SESSION['ec_couponcode'] != "" ){
			$this->coupon_code = $_SESSION['ec_couponcode'];
			$this->coupon = $this->mysqli->redeem_coupon_code( $this->coupon_code );
		}else{
			$this->coupon_code = "";
		}
		
		if( isset( $_SESSION['ec_giftcard'] ) && $_SESSION['ec_giftcard'] != "" ){
			$this->gift_card = $_SESSION['ec_giftcard'];
			$this->giftcard = $this->mysqli->redeem_gift_card( $this->gift_card );
		}else{
			$this->gift_card = "";
		}
		
		// Tax (no VAT here)
		$this->tax = new ec_tax( $this->cart->subtotal, $this->cart->taxable_subtotal, 0, $this->user->shipping->state, $this->user->shipping->country );
		// Shipping
		$this->shipping = new ec_shipping( $this->cart->subtotal, $this->cart->weight );
		// Duty (Based on Product Price) - already calculated in tax
		// Get Total Without VAT, used only breifly
		$total_without_vat_or_discount = $this->cart->vat_subtotal + $this->shipping->get_shipping_price( ) + $this->tax->tax_total + $this->tax->duty_total;
		// Discount for Coupon
		$this->discount = new ec_discount( $this->cart, $this->cart->subtotal, $this->shipping->get_shipping_price( ), $this->coupon_code, $this->gift_card, $total_without_vat_or_discount );
		// Amount to Apply VAT on
		$vatable_subtotal = $total_without_vat_or_discount - $this->discount->coupon_discount;
		// Get Tax Again For VAT
		$this->tax = new ec_tax( $this->cart->subtotal, $this->cart->taxable_subtotal, $vatable_subtotal, $this->user->shipping->state, $this->user->shipping->country );
		// Discount for Gift Card
		$this->discount = new ec_discount( $this->cart, $this->cart->subtotal, $this->shipping->get_shipping_price( ), $this->coupon_code, $this->gift_card, $GLOBALS['currency']->get_number_only( $total_without_vat_or_discount ) + $GLOBALS['currency']->get_number_only( $this->tax->vat_total ) );
		// Order Totals
		$this->order_totals = new ec_order_totals( $this->cart, $this->user, $this->shipping, $this->tax, $this->discount );
		
		// Credit Card
		if( isset( $_POST['ec_cart_payment_type'] ) )
			$credit_card = new ec_credit_card( $_POST['ec_cart_payment_type'], $_POST['ec_card_holder_name'], $_POST['ec_card_number'], $_POST['ec_expiration_month'], $_POST['ec_expiration_year'], $_POST['ec_security_code'] );
		else
			$credit_card = new ec_credit_card( "", "", "", "", "", "" );
		
		// Payment
		if( isset( $_POST['ec_cart_payment_selection'] ) )
			$this->payment = new ec_payment( $credit_card, $_POST['ec_cart_payment_selection'] );
		else
			$this->payment = new ec_payment( $credit_card, "" );
		
		// Order
		$this->order = new ec_order( $this->cart, $this->user, $this->shipping, $this->tax, $this->discount, $this->order_totals, $this->payment );
		
		$store_page_id = get_option('ec_option_storepage');
		$this->store_page = get_permalink( $store_page_id );
		
		$cart_page_id = get_option('ec_option_cartpage');
		$this->cart_page = get_permalink( $cart_page_id );
		
		$account_page_id = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $account_page_id );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->cart_page = $https_class->getHttpsUrl( ) . substr( $this->cart_page, strlen( get_option( 'home' ) ) + 1 );
		}
		
		if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
	}
	
	public function display_cart_success(){
		$success_notes = array(	"account_created" => $GLOBALS['language']->get_text( "ec_success", "cart_account_created" ) );
		
		if( isset( $_GET['ec_cart_success'] ) ){
			echo "<div class=\"ec_cart_success\"><div>" . $success_notes[ $_GET['ec_cart_success'] ] . "</div></div>";
		}
	}
	
	public function display_cart_error(){
		$error_notes = array( "email_exists" => $GLOBALS['language']->get_text( "ec_errors", "email_exists_error" ),
							  "login_failed" => $GLOBALS['language']->get_text( "ec_errors", "login_failed" ),
							  "3dsecure_failed" => $GLOBALS['language']->get_text( "ec_errors", "3dsecure_failed" ),
							  "manualbill_failed" => $GLOBALS['language']->get_text( "ec_errors", "manualbill_failed"),
							  "thirdparty_failed" => $GLOBALS['language']->get_text( "ec_errors", "thirdparty_failed"),
							  "payment_failed" => $GLOBALS['language']->get_text( "ec_errors", "payment_failed")   
							);
		if( isset( $_GET['ec_cart_error'] ) ){
			echo "<div class=\"ec_cart_error\"><div>" . $error_notes[ $_GET['ec_cart_error'] ] . "</div></div>";
		}
	}
	
	public function display_cart_page(){
		
		echo "<div class=\"ec_cart_page\">";
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && isset( $_SESSION['ec_email'] ) && isset( $_SESSION['ec_password'] ) ){
			$order_id = $_GET['order_id'];
			$order = $this->mysqli->get_order_row( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			$order_details = $this->mysqli->get_order_details( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			
			$this->user->setup_billing_info_data( $order->billing_first_name, $order->billing_last_name, $order->billing_address_line_1, $order->billing_city, $order->billing_state, $order->billing_country, $order->billing_zip, $order->billing_phone );
			
			$this->user->setup_shipping_info_data( $order->shipping_first_name, $order->shipping_last_name, $order->shipping_address_line_1, $order->shipping_city, $order->shipping_state, $order->shipping_country, $order->shipping_zip, $order->shipping_phone );
		
			$tax_struct = new ec_tax( 0,0,0, "", "");
			
			$total = $GLOBALS['currency']->get_currency_display( $order->grand_total );
			$subtotal = $GLOBALS['currency']->get_currency_display( $order->sub_total );
			$tax = $GLOBALS['currency']->get_currency_display( $order->tax_total );
			$duty = $GLOBALS['currency']->get_currency_display( $order->duty_total );
			$vat = $GLOBALS['currency']->get_currency_display( $order->vat_total );
			if( ( $order->grand_total - $order->vat_total ) > 0 )
			$vat_rate = number_format( ( $order->vat_total / ( $order->grand_total - $order->vat_total ) ) * 100, 0, '', '' );
			else
			$vat_rate = number_format( 0, 0, '', '' );
			$shipping = $GLOBALS['currency']->get_currency_display( $order->shipping_total );
			$discount = $GLOBALS['currency']->get_currency_display( $order->discount_total );
			
			$email_logo_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_email_receipt/emaillogo.jpg");
			$email_footer_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_email_receipt/emailfooter.jpg");
			
			//google analytics
			$this->analytics = new ec_googleanalytics($order_details, $order->shipping_total, $order->tax_total , $order->grand_total, $order_id);
			$google_urchin_code = get_option('ec_option_googleanalyticsid');
			$google_wp_url = $_SERVER['SERVER_NAME'];
			$google_transaction = $this->analytics->get_transaction_js();
			$google_items = $this->analytics->get_item_js();
			//end google analytics
			$this->display_cart_error();
			
			//Backwards compatibility for an error... Don't want the button showing if user didn't create an account.
			if( $_SESSION['ec_password'] == "guest" )
				$_SESSION['ec_email'] = "guest";
				
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_success.php' );
			
		}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "third_party" ){
			$order_id = $_GET['order_id'];
			$order = $this->mysqli->get_order_row( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			$order_details = $this->mysqli->get_order_details( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			//google analytics
			$this->analytics = new ec_googleanalytics($order_details, $order->shipping_total, $order->tax_total , $order->grand_total, $order_id);
			$google_urchin_code = get_option('ec_option_googleanalyticsid');
			$google_wp_url = $_SERVER['SERVER_NAME'];
			$google_transaction = $this->analytics->get_transaction_js();
			$google_items = $this->analytics->get_item_js();
			//end google analytics
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_third_party.php' );
			
		}else{
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_page.php' );
			echo "<input type=\"hidden\" name=\"ec_cart_session_id\" id=\"ec_cart_session_id\" value=\"" . session_id() . "\" />";
		}
		echo "</div>";
	}
	
	public function display_cart( $empty_cart_string ){
		if(	$this->cart->total_items > 0 ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart.php' );
			echo "<input type=\"hidden\" name=\"ec_cart_page\" id=\"ec_cart_page\" value=\"" . $this->cart_page . "\" />";
			echo "<input type=\"hidden\" name=\"ec_cart_base_path\" id=\"ec_cart_base_path\" value=\"" . plugins_url( ) . "\" />";
			echo "<input type=\"hidden\" name=\"ec_cart_session_id\" id=\"ec_cart_session_id\" value=\"" . session_id() . "\" />";
		}else
			echo $empty_cart_string;
	}
	
	public function display_login(){
		if(	$this->cart->total_items > 0 ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login.php' );
		}
	}
	
	public function display_login_complete(){
		if(	$this->cart->total_items > 0 ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' );
		}
	}
	
	public function should_display_cart( ){
		if( !$this->should_display_login( ) )
			return true;
		else
			return false;
	}
	
	public function should_display_login( ){
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_login" && !isset( $_SESSION['ec_email'] ) );
	}
	
	public function payment_processor_requires_billing( ){
		if( get_option( 'ec_option_payment_process_method' ) == "skrill" ){
			return false;	
		}
	}
	
	public function should_hide_shipping_panel(){
		return ( !isset( $_SESSION['ec_shipping_selector'] ) || ( isset( $_SESSION['ec_shipping_selector'] ) && $_SESSION['ec_shipping_selector'] == "false" ) );
	}
	
	public function should_display_page_one( ){
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_info" && isset( $_SESSION['ec_email'] ) );
	}
	
	public function display_page_one_form_start(){
		$next_page = "checkout_shipping";
		if( !get_option( 'ec_option_use_shipping' ) || $this->cart->weight == 0 )
			$next_page = "checkout_payment";
		
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page . "\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"save_checkout_info\" />";
	}
	
	public function display_page_one_form_end(){
		echo "</form>";
	}
	
	public function should_display_page_two( ){
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_shipping" && isset( $_SESSION['ec_email'] ) );
	}
	
	public function display_page_two_form_start(){
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"save_checkout_shipping\" />";
	}
	
	public function display_page_two_form_end(){
		echo "</form>";
	}
	
	public function should_display_page_three( ){
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_payment" && isset( $_SESSION['ec_email'] ) );
	}
	
	public function display_page_three_form_start(){
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_submit_order\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"submit_order\" />";
	}
	
	public function display_page_three_form_end(){
		echo "</form>";
	}
	
	/* START CART FUNCTIONS */
	public function is_cart_type_one( ){
		return ( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && !isset( $_SESSION['ec_email'] ) ) );
	}
	
	public function is_cart_type_two( ){
		return ( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_payment" ) || !isset( $_SESSION['ec_email'] ) );
	}
	
	public function is_cart_type_three( ){
		return ( $this->shipping->shipping_method == "live" && $this->cart->weight > 0 && ( !isset( $_GET['ec_page'] ) || !isset( $_SESSION['ec_email'] ) ) );
	}
	
	public function display_total_items( ){
		echo "<span id=\"ec_cart_total_items\">" . $this->cart->get_total_items() . "</span>";
	}
	
	public function display_cart_items( ){
		$this->cart->display_cart_items( $this->tax->vat_enabled, $this->tax->vat_country_match );	
	}
	
	public function has_cart_total_promotion( ){
		if( $this->cart->cart_total_promotion )
			return true;
		else
			return false;
	}
	
	public function display_cart_total_promotion( ){
		echo $this->cart->cart_total_promotion;
	}
	
	public function has_cart_shipping_promotion( ){
		if( $this->shipping->get_shipping_promotion_text( ) )
			return true;
		else
			return false;
	}
	
	public function display_cart_shipping_promotion( ){
		echo $this->shipping->get_shipping_promotion_text();
	}
	
	public function display_shipping_costs_input( $label, $button_text ){
		echo "<span>" . $label . "</span><input type=\"text\" name=\"ec_cart_zip_code\" id=\"ec_cart_zip_code\" value=\"";
		if( isset( $_SESSION['ec_temp_zipcode'] ) )
			echo $_SESSION['ec_temp_zipcode'];
		echo "\" /><a href=\"#\" onclick=\"return ec_estimate_shipping_click();\">" . $button_text . "</a>";
	}
	
	public function display_shipping_costs_input_text( $label ){
		echo "<span>" . $label . "</span><input type=\"text\" name=\"ec_cart_zip_code\" id=\"ec_cart_zip_code\" value=\"";
		if( isset( $_SESSION['ec_temp_zipcode'] ) )
			echo $_SESSION['ec_temp_zipcode'];
		echo "\" />";
	}
	
	public function display_shipping_costs_input_button( $button_text ){
		echo "<a href=\"#\" onclick=\"return ec_estimate_shipping_click();\">" . $button_text . "</a>";
	}
	
	public function display_estimate_shipping_loader( ){
		echo "<div class=\"ec_estimate_shipping_loader\" id=\"ec_estimate_shipping_loader\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
	}
	
	public function display_subtotal( ){
		echo "<span id=\"ec_cart_subtotal\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->sub_total ) . "</span>";	
	}
	
	public function display_tax_total( ){
		echo "<span id=\"ec_cart_tax\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->tax_total ) . "</span>";	
	}
	
	public function has_duty( ){
		if ( $this->tax->duty_total > 0 )			return true;
		else										return false;	
	}
	
	public function display_duty_total( ){
		echo "<span id=\"ec_cart_duty\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->duty_total ) . "</span>";	
	}
	
	public function get_vat_total( ){
		return $this->tax->vat_total;
	}
	
	public function display_vat_total( ){
		echo "<span id=\"ec_cart_vat\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->vat_total ) . "</span>";	
	}
	
	public function display_shipping_total( ){
		echo "<span id=\"ec_cart_shipping\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->shipping_total ) . "</span>";
	}
	
	public function display_discount_total( ){
		echo "<span id=\"ec_cart_discount\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->discount_total ) . "</span>";
	}
	
	public function display_grand_total( ){
		echo "<span id=\"ec_cart_grandtotal\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->grand_total ) . "</span>"; 	
	}
	
	public function display_continue_shopping_button( $button_text ){
		echo "<a href=\"" . $this->store_page;
		if( isset( $_GET['model_number'] ) )
			echo $this->permalink_divider . "model_number=" . $_GET['model_number'];
		
		echo "\" class=\"ec_cart_continue_shopping_link\">" . $button_text . "</a>";
	}
	
	public function display_checkout_button( $button_text ){
		$checkout_page = "checkout_login";
		if( isset( $_SESSION['ec_email'] ) )
		$checkout_page = "checkout_info";
		echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=" . $checkout_page . "\" class=\"ec_cart_checkout_link\">" . $button_text . "</a>";
	}
	/* END CART FUNCTIONS */

	// Forward the page to the cart page minus form submission with success note
	private function forward_cart_success(){
		
	}
	
	// Forward the page to the last product page, plus a failed note
	private function forward_product_failed(){
		
	}
	
	/* Login Form Functions */
	public function display_cart_login_form_start(){
		echo "<form action=\"". $this->cart_page . "\" method=\"post\">";	
	}
	
	public function display_cart_login_form_end(){
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"login_user\" />";
		echo "</form>";
	}
	
	public function display_cart_login_form_guest_start(){
		echo "<form action=\"". $this->cart_page . "\" method=\"post\">";
	}
	
	public function display_cart_login_form_guest_end(){
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"login_user\" />";
		echo "<input type=\"hidden\" name=\"ec_cart_login_email\" value=\"guest\" />";
		echo "<input type=\"hidden\" name=\"ec_cart_login_password\" value=\"guest\" />";
		echo "</form>";
	}
	
	public function display_cart_login_email_input(){
		echo "<input type=\"email\" id=\"ec_cart_login_email\" name=\"ec_cart_login_email\" class=\"ec_cart_login_input\" autocorrect=\"off\" autocapitalize=\"off\" />";
	}
	
	public function display_cart_login_password_input(){
		echo "<input type=\"password\" id=\"ec_cart_login_password\" name=\"ec_cart_login_password\" class=\"ec_cart_login_input\" />";
	}
	
	public function display_cart_login_login_button( $input ){
		echo "<input type=\"submit\" id=\"ec_cart_login_login_button\" name=\"ec_cart_login_login_button\" class=\"ec_cart_login_button\" value=\"" . $input . "\" />";
	}
	
	public function display_cart_login_forgot_password_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=forgot_password\" class=\"ec_cart_login_complete_logout_link\">" . $link_text . "</a>";
	}
	
	public function display_cart_login_guest_button( $input ){
		echo "<input type=\"submit\" id=\"ec_cart_login_guest_button\" name=\"ec_cart_login_guest_button\" class=\"ec_cart_login_button\" value=\"" . $input . "\" />";
	}
	
	public function display_cart_login_complete_user_name( $input ){
		echo "<input type=\"hidden\" id=\"ec_cart_login_guest_text\" value=\"" . $input . "\" /><span id=\"ec_cart_login_complete_username\">";
		if( $_SESSION['ec_username'] != "guest" )			echo $_SESSION['ec_username'];
		else												echo $input;
		echo "</span>";
	}
	
	public function display_cart_login_complete_signout_link( $input ){
		echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_cart_action=logout\" class=\"ec_cart_login_complete_logout_link\">" . $input . "</a>";
	}
	
	/* END LOGIN/LOGOUT FUNCTIONS */
	
	/* START BILLING FUNCTIONS */
	public function display_billing(){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_billing.php' );
	}
	
	public function display_billing_input( $name ){
		if( $name == "country" ){
			if( get_option( 'ec_option_use_country_dropdown' ) ){
				// DISPLAY COUNTRY DROP DOWN MENU
				$countries = $this->mysqli->get_countries( );
				if( isset( $_SESSION['ec_billing_country'] ) )
					$selected_country = $_SESSION['ec_billing_country'];
				else
					$selected_country = $this->user->billing->get_value( "country2" );
				
				echo "<select name=\"ec_cart_billing_country\" id=\"ec_cart_billing_country\" class=\"ec_cart_billing_input_text\">";
				echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_country" ) . "</option>";
				foreach($countries as $country){
					echo "<option value=\"" . $country->iso2_cnt . "\"";
					if( $country->iso2_cnt == $selected_country )
						echo " selected=\"selected\"";
					echo ">" . $country->name_cnt . "</option>";
				}
				echo "</select>";
			}else{
				// DISPLAY COUNTRY TEXT INPUT
				if( isset( $_SESSION['ec_billing_country'] ) )
					$selected_country = $_SESSION['ec_billing_country'];
				else
					$selected_country = $this->user->billing->get_value( "country" );
					
				echo "<input type=\"text\" name=\"ec_cart_billing_country\" id=\"ec_cart_billing_country\" class=\"ec_cart_billing_input_text\" value=\"" . $selected_country . "\" />";
			}
		}else if( $name == "state" ){
			if( get_option( 'ec_option_use_state_dropdown' ) ){
				// DISPLAY STATE DROP DOWN MENU
				$states = $this->mysqli->get_states( );
				if( isset( $_SESSION['ec_billing_state'] ) )
					$selected_state = $_SESSION['ec_billing_state'];
				else
					$selected_state = $this->user->billing->get_value( "state" );
				
				echo "<select name=\"ec_cart_billing_state\" id=\"ec_cart_billing_state\" class=\"ec_cart_billing_input_text\">";
				echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_state" ) . "</option>";
				foreach($states as $state){
					echo "<option value=\"" . $state->code_sta . "\"";
					if( $state->code_sta == $selected_state )
						echo " selected=\"selected\"";
					echo ">" . $state->name_sta . "</option>";
				}
				echo "</select>";
			}else{
				// DISPLAY STATE TEXT INPUT
				if( isset( $_SESSION['ec_billing_state'] ) )
					$selected_state = $_SESSION['ec_billing_state'];
				else
					$selected_state = $this->user->billing->get_value( "state" );
					
				echo "<input type=\"text\" name=\"ec_cart_billing_state\" id=\"ec_cart_billing_state\" class=\"ec_cart_billing_input_text\" value=\"" . $selected_state . "\" />";
			}
		}else{
		
			$value = $this->user->billing->get_value( $name );
			
			echo "<input type=\"text\" name=\"ec_cart_billing_" . $name . "\" id=\"ec_cart_billing_" . $name . "\" class=\"ec_cart_billing_input_text\" value=\"" . $value . "\" />";
			
		}
	}
	/* END BILLING FUNCTIONS */
	
	/* START SHIPPING FUNCTIONS */
	public function display_shipping(){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping.php' );
	}
	
	public function display_shipping_selector( $first_opt, $second_opt ){
		if( $this->cart->shipping_subtotal > 0 )
			echo "<div class=\"ec_cart_shipping_selector_row\">";
		else
			echo "<div class=\"ec_cart_shipping_selector_row_hidden\">";
			
		echo "<input type=\"radio\" name=\"ec_shipping_selector\" id=\"ec_cart_use_billing_for_shipping\" value=\"false\"";
		if( !isset( $_SESSION['ec_shipping_selector'] ) || ( isset( $_SESSION['ec_shipping_selector'] ) && $_SESSION['ec_shipping_selector'] == "false" ) )
		echo " checked=\"checked\"";
		echo " onchange=\"ec_cart_use_billing_for_shipping_change(); return false;\" />" . $first_opt;
		echo "</div>";
		
		if( get_option( 'ec_option_use_shipping' ) ){
			if( $this->cart->shipping_subtotal > 0 )
				echo "<div class=\"ec_cart_shipping_selector_row\">";
			else
				echo "<div class=\"ec_cart_shipping_selector_row_hidden\">";
			
			echo "<input type=\"radio\" name=\"ec_shipping_selector\" id=\"ec_cart_use_shipping_for_shipping\" value=\"true\"";
			if( isset( $_SESSION['ec_shipping_selector'] ) && $_SESSION['ec_shipping_selector'] == "true" )
			echo " checked=\"checked\"";
			echo " onchange=\"ec_cart_use_shipping_for_shipping_change(); return false;\" />" . $second_opt;
			echo "</div>";
		}else{
			echo "<script>jQuery('.ec_cart_shipping_selector_row').hide();</script>";	
		}
	}
	
	public function display_shipping_input( $name ){
		if( $name == "country" ){
			if( get_option( 'ec_option_use_country_dropdown' ) ){
				// DISPLAY COUNTRY DROP DOWN MENU
				$countries = $this->mysqli->get_countries( );
				if( isset( $_SESSION['ec_shipping_country'] ) )
					$selected_country = $_SESSION['ec_shipping_country'];
				else
					$selected_country = $this->user->shipping->get_value( "country2" );
				
				echo "<select name=\"ec_cart_shipping_country\" id=\"ec_cart_shipping_country\" class=\"ec_cart_shipping_input_text\">";
				echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_country" ) . "</option>";
				foreach($countries as $country){
					echo "<option value=\"" . $country->iso2_cnt . "\"";
					if( $country->iso2_cnt == $selected_country )
					echo " selected=\"selected\"";
					echo ">" . $country->name_cnt . "</option>";	
				}
				echo "</select>";
			}else{
				// DISPLAY STATE TEXT INPUT
				if( isset( $_SESSION['ec_shipping_country'] ) )
					$selected_country = $_SESSION['ec_shipping_country'];
				else
					$selected_country = $this->user->shipping->get_value( "country" );
					
				echo "<input type=\"text\" name=\"ec_cart_shipping_country\" id=\"ec_cart_shipping_country\" class=\"ec_cart_shipping_input_text\" value=\"" . $selected_country . "\" />";
			}
		}else if( $name == "state" ){
			if( get_option( 'ec_option_use_state_dropdown' ) ){
				// DISPLAY STATE DROP DOWN MENU
				$states = $this->mysqli->get_states( );
				if( isset( $_SESSION['ec_shipping_state'] ) )
					$selected_state = $_SESSION['ec_shipping_state'];
				else
					$selected_state = $this->user->shipping->get_value( "state" );
				
				echo "<select name=\"ec_cart_shipping_state\" id=\"ec_cart_shipping_state\" class=\"ec_cart_shipping_input_text\">";
				echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_state" ) . "</option>";
				foreach($states as $state){
					echo "<option value=\"" . $state->code_sta . "\"";
					if( $state->code_sta == $selected_state )
					echo " selected=\"selected\"";
					echo ">" . $state->name_sta . "</option>";
				}
				echo "</select>";
			}else{
				// DISPLAY STATE TEXT INPUT
				if( isset( $_SESSION['ec_shipping_state'] ) )
					$selected_state = $_SESSION['ec_shipping_state'];
				else
					$selected_state = $this->user->shipping->get_value( "state" );
					
				echo "<input type=\"text\" name=\"ec_cart_shipping_state\" id=\"ec_cart_shipping_state\" class=\"ec_cart_shipping_input_text\" value=\"" . $selected_state . "\" />";
			}
		}else{
			$value = $this->user->shipping->get_value( $name );
			
			echo "<input type=\"text\" name=\"ec_cart_shipping_" . $name . "\" id=\"ec_cart_shipping_" . $name . "\" class=\"ec_cart_shipping_input_text\" value=\"" . $value . "\" />";
		}
	}
	/* END SHIPPING FUNCTIONS */
	
	/* START SHIPPING METHOD FUNCTIONS */
	public function display_shipping_method( ){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping_method.php' );
	}
	
	public function ec_cart_display_shipping_methods( $standard_text, $express_text, $ship_method ){
		$shipping_options = $this->shipping->get_shipping_options( $standard_text, $express_text );	
		if( $shipping_options )
			echo $shipping_options;
		else if( isset( $_SESSION['ec_temp_zipcode'] ) && $_SESSION['ec_temp_zipcode'] )
			echo "<div class=\"ec_cart_shipping_method_row\">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_error' ) . "</div>";
	}
	/* END SHIPPING METHOD FUNCTIONS */
	
	/* START COUPON FUNCTIONS */
	public function display_coupon( ){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_coupon.php' );
	}
	
	public function display_coupon_input( $redeem_text ){
		echo "<input type=\"text\" name=\"ec_cart_coupon_code\" id=\"ec_cart_coupon_code\" class=\"ec_cart_coupon_input_text\" value=\"";
		if( $this->coupon_code != "" )
			echo $this->coupon_code;
		echo "\" /><div class=\"ec_cart_coupon_code_redeem_button\"><a href=\"#\" onclick=\"ec_cart_coupon_code_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_coupon_input_text( ){
		echo "<input type=\"text\" name=\"ec_cart_coupon_code\" id=\"ec_cart_coupon_code\" class=\"ec_cart_coupon_input_text\" value=\"";
		if( $this->coupon_code != "" )
			echo $this->coupon_code;
		
		echo "\" />";
	}
	
	public function display_coupon_input_button( $redeem_text ){
		echo "<div class=\"ec_cart_coupon_code_redeem_button\"><a href=\"#\" onclick=\"ec_cart_coupon_code_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_coupon_loader( ){
		echo "<div class=\"ec_cart_coupon_loader\" id=\"ec_cart_coupon_loader\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";	
	}
	
	public function display_coupon_message( ){
		if( isset( $this->coupon ) )
			echo $this->coupon->message;
		else if( $this->coupon_code != "" )
			echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' );
	}
	/* END COUPON FUNCTIONS */
	
	/* START GIFT CARD FUNCTIONS */
	public function display_gift_card( ){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_gift_card.php' );
	}
	
	public function display_gift_card_input( $redeem_text ){
		echo "<input type=\"text\" name=\"ec_cart_gift_card\" id=\"ec_cart_gift_card\" class=\"ec_cart_gift_card_input_text\" value=\"";
		if( $this->gift_card != "" )
			echo $this->gift_card;
		echo "\" /><div class=\"ec_cart_gift_card_redeem_button\"><a href=\"#\" onclick=\"ec_cart_gift_card_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_gift_card_input_text( ){
		echo "<input type=\"text\" name=\"ec_cart_gift_card\" id=\"ec_cart_gift_card\" class=\"ec_cart_gift_card_input_text\" value=\"";
		if( $this->gift_card != "" )
			echo $this->gift_card;
			
		echo "\" />";
	}
	
	public function display_gift_card_input_button( $redeem_text ){
		echo "<div class=\"ec_cart_gift_card_redeem_button\"><a href=\"#\" onclick=\"ec_cart_gift_card_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_gift_card_loader( ){
		echo "<div class=\"ec_cart_gift_card_loader\" id=\"ec_cart_gift_card_loader\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";	
	}
	
	public function display_gift_card_message( ){
		if( isset( $this->giftcard ) )
			echo $this->giftcard->message;
		else if( $this->gift_card != "" )
			echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_giftcard' );
	}
	/* END GIFT CARD FUNCTIONS */
	
	public function display_continue_to_shipping_button( $button_text ){
		echo "<input type=\"submit\" class=\"ec_cart_continue_to_shipping_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_checkout_info( );\" />";
	}
	
	/* START CONTINUE TO PAYMENT FUNCTIONS */
	public function display_continue_to_payment_button( $button_text ){
		echo "<input type=\"submit\" class=\"ec_cart_continue_to_payment_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_checkout_shipping( );\" />";
	}
	/* END CONTINUE TO PAYMENT FUNCTIONS */
	
	public function display_submit_order_button( $button_text ){
		echo "<input type=\"submit\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_checkout_submit_order();\" />";
	}
	
	/* START ADDRESS REVIEW FUNCTIONS */
	public function display_address_review(){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_address_review.php' );
			
		if( !get_option( 'ec_option_use_shipping' ) )
			echo "<script>jQuery('.ec_cart_address_review_middle').html('');</script>";
	}
	
	public function display_edit_address_link( $link_text ){
		echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info\">" . $link_text . "</a>";	
	}
	
	public function display_review_billing( $name ){
		echo $this->user->billing->get_value( $name );
	}
	
	public function display_review_shipping( $name ){
		echo $this->user->shipping->get_value( $name );
	}
	
	public function display_selected_shipping_method( ){
		echo $this->shipping->get_selected_shipping_method();
	}
	/* END ADDRESS REVIEW FUNCTIONS */
	
	/* START PAYMENT INFORMATION FUNCTIONS */
    public function display_payment_information( ){
    	if(	$this->cart->total_items > 0 && $this->order_totals->grand_total > 0 ){
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment_information.php' );
			echo "<script>jQuery(\"input[name=ec_cart_payment_selection][value='" . get_option( 'ec_option_default_payment_type' ) . "']\").attr('checked', 'checked');";
			if( get_option( 'ec_option_default_payment_type' ) == "manual_bill" ){
				echo "jQuery('#ec_cart_pay_by_manual_payment').show();";
			}else if( get_option( 'ec_option_default_payment_type' ) == "third_party" ){
				echo "jQuery('#ec_cart_pay_by_third_party').show();";
			}else if( get_option( 'ec_option_default_payment_type' ) == "credit_card" ){
				echo "jQuery('#ec_cart_pay_by_credit_card_holder').show();";
			}
			echo "</script>";
		}
	}
	
	public function use_manual_payment( ){
		if( get_option( 'ec_option_use_direct_deposit' ) )
			return true;
		else
			return false;
	}
	
	public function display_manual_payment_text( ){
		echo nl2br( get_option( 'ec_option_direct_deposit_message' ) );	
	}
	
	public function use_third_party( ){
		if( get_option( 'ec_option_payment_third_party' ) )
			return true;
		else
			return false;
	}
	
	public function ec_cart_display_third_party_form_start( ){
		$this->payment->third_party->initialize( $_GET['order_id'] );
		$this->payment->third_party->display_form_start( );
	}
	
	public function ec_cart_display_third_party_form_end( ){
		echo "</form>";
	}
	
	public function display_third_party_submit_button( $button_text ){
		echo "<input type=\"submit\" class=\"ec_cart_submit_third_party\" value=\"" . $button_text . "\" />";
	}
	
	public function ec_cart_display_current_third_party_name( ){
		if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
			echo "PayPal";
		else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
			echo "Skrill";
		else if( get_option( 'ec_option_payment_third_party' ) == "realex_thirdparty" )
			echo "Realex Payments";
	}
	
	public function ec_cart_get_current_third_party_name( ){
		if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
			return "PayPal";
		else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
			return "Skrill";
		else if( get_option( 'ec_option_payment_third_party' ) == "realex_thirdparty" )
			return "Realex Payments";
	}
	
	public function ec_cart_display_third_party_logo( ){
		if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
			echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/paypal.jpg") . "\" alt=\"PayPal\" />";
		else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
			echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/skrill-logo.gif") . "\" alt=\"Skrill\" />";
	}
	
	public function use_payment_gateway( ){
		if( get_option( 'ec_option_payment_process_method' ) )
			return true;
		else
			return false;
	}
	
	public function ec_cart_display_credit_card_images(){
		//display credit card icons
		if( get_option('ec_option_use_visa') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/visa.png") . "\" alt=\"Visa\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_visa\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/visa_inactive.png") . "\" alt=\"Visa\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_visa_inactive\" />";
		
		if( get_option('ec_option_use_discover') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/discover.png") . "\" alt=\"Discover\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_discover\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/discover_inactive.png") . "\" alt=\"Discover\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_discover_inactive\" />";
		
		if( get_option('ec_option_use_mastercard') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/mastercard.png") . "\" alt=\"Mastercard\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_mastercard\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/mastercard_inactive.png") . "\" alt=\"Mastercard\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_mastercard_inactive\" />";
		
		if( get_option('ec_option_use_amex') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/american_express.png") . "\" alt=\"AMEX\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_amex\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/american_express_inactive.png") . "\" alt=\"AMEX\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_amex_inactive\" />";
		
		if( get_option('ec_option_use_jcb') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/jcb.png") . "\" alt=\"JCB\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_jcb\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/jcb_inactive.png") . "\" alt=\"JCB\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_jcb_inactive\" />";
		
		if( get_option('ec_option_use_diners') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/diners.png") . "\" alt=\"Diners\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_diners\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/diners_inactive.png") . "\" alt=\"Diners\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_diners_inactive\" />";
		
		if( get_option('ec_option_use_laser') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/laser.gif") . "\" alt=\"Laser\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_laser\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/laser_inactive.png") . "\" alt=\"Laser\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_laser_inactive\" />";
		
		if( get_option('ec_option_use_maestro') )
		echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/maestro.png") . "\" alt=\"Maestro\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_maestro\" />" . "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_layout' ) . "/ec_cart_payment_information/maestro_inactive.png") . "\" alt=\"Maestro\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_maestro_inactive\" />";
		
		
	}
	
	public function ec_cart_display_payment_method_input( $select_one_text ){
		echo "<select name=\"ec_cart_payment_type\" id=\"ec_cart_payment_type\" class=\"ec_cart_payment_information_input_select\" onchange=\"ec_cart_payment_type_change();\">";
		
		echo "<option value=\"0\">" . $select_one_text . "</option>";
		
		if( get_option('ec_option_use_visa') )
		echo "<option value=\"visa\">Visa</option>";
		
		if( get_option('ec_option_use_delta') )
		echo "<option value=\"delta\">Visa Debit/Delta</option>";
		
		if( get_option('ec_option_use_uke') )
		echo "<option value=\"uke\">Visa Electron</option>";
		
		if( get_option('ec_option_use_discover') )
		echo "<option value=\"discover\">Discover</option>";
		
		if( get_option('ec_option_use_mastercard') )
		echo "<option value=\"mastercard\">Mastercard</option>";
		
		if( get_option('ec_option_use_mcdebit') )
		echo "<option value=\"mcdebit\">Debit Mastercard</option>";
		
		if( get_option('ec_option_use_amex') )
		echo "<option value=\"amex\">American Express</option>";
		
		if( get_option('ec_option_use_jcb') )
		echo "<option value=\"jcb\">JCB</option>";
		
		if( get_option('ec_option_use_diners') )
		echo "<option value=\"diners\">Diners</option>";
		
		if( get_option('ec_option_use_laser') )
		echo "<option value=\"laser\">Laser</option>";
		
		if( get_option('ec_option_use_maestro') )
		echo "<option value=\"maestro\">Maestro</option>";
		
		echo "</select>";
	}
	
	public function ec_cart_display_card_holder_name_input(){
		echo "<input type=\"text\" name=\"ec_card_holder_name\" id=\"ec_card_holder_name\" class=\"ec_cart_payment_information_input_text\" value=\"\" />";
	}
	
	public function ec_cart_display_card_number_input(){
		echo "<input type=\"text\" name=\"ec_card_number\" id=\"ec_card_number\" class=\"ec_cart_payment_information_input_text\" value=\"\" />";
	}
	
	public function ec_cart_display_card_expiration_month_input( $select_text ){
		echo "<select name=\"ec_expiration_month\" id=\"ec_expiration_month\" class=\"ec_cart_payment_information_input_select\">";
		echo "<option value=\"0\">" . $select_text . "</option>";
		for( $i=1; $i<=12; $i++ ){
			echo "<option value=\"";
			if( $i<10 )										$month = "0" . $i;
			else											$month = $i;
			echo $month . "\">" . $month . "</option>";
		}
		echo "</select>";
	}
	
	public function ec_cart_display_card_expiration_year_input( $select_text ){
		echo "<select name=\"ec_expiration_year\" id=\"ec_expiration_year\" class=\"ec_cart_payment_information_input_select\">";
		echo "<option value=\"0\">" . $select_text . "</option>";
		for( $i=date( 'Y' ); $i < date( 'Y' ) + 15; $i++ ){
			echo "<option value=\"" . $i . "\">" . $i . "</option>";	
		}
		echo "</select>";
	}
	
	public function ec_cart_display_card_security_code_input(){
		echo "<input type=\"text\" name=\"ec_security_code\" id=\"ec_security_code\" class=\"ec_cart_payment_information_input_select\" value=\"\" />";
	}
	/* END PAYMENT INFORMATION FUNCTIONS */
    
	/* START CONTACT INFORMATION FUNCTIONS */
    public function display_contact_information(){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_contact_information.php' );
	}
	
	public function ec_cart_display_contact_first_name_input(){
		if( isset( $_SESSION['ec_first_name'] ) )
			$first_name = $_SESSION['ec_first_name'];
		else
			$first_name = $this->user->first_name;
			
		if( $first_name == "guest" )
			$first_name = "";
			
		echo "<input type=\"text\" name=\"ec_contact_first_name\" id=\"ec_contact_first_name\" class=\"ec_cart_contact_information_input_text\" value=\"" . $first_name . "\" />";
	}
	
	public function ec_cart_display_contact_last_name_input(){
		if( isset( $_SESSION['ec_last_name'] ) )
			$last_name = $_SESSION['ec_last_name'];
		else
			$last_name = $this->user->last_name;
			
		if( $last_name == "guest" )
			$last_name = "";
			
		echo "<input type=\"text\" name=\"ec_contact_last_name\" id=\"ec_contact_last_name\" class=\"ec_cart_contact_information_input_text\" value=\"" . $last_name . "\" />";
	}
	
	public function ec_cart_display_contact_email_input(){
		if( isset( $_SESSION['ec_email'] ) )
			$email = $_SESSION['ec_email'];
		else
			$email = $this->user->email;
			
		if( $email == "guest" )
			$email = "";
			
		echo "<input type=\"text\" name=\"ec_contact_email\" id=\"ec_contact_email\" class=\"ec_cart_contact_information_input_text\" value=\"" . $email . "\" />";
	}
	
	public function ec_cart_display_contact_email_retype_input(){
		if( isset( $_SESSION['ec_email'] ) )
			$email = $_SESSION['ec_email'];
		else
			$email = $this->user->email;
			
		if( $email == "guest" )
			$email = "";
			
		echo "<input type=\"text\" name=\"ec_contact_email_retype\" id=\"ec_contact_email_retype\" class=\"ec_cart_contact_information_input_text\" value=\"" . $email . "\" />";
	}
	
	public function ec_cart_display_contact_create_account_box( ){
		echo "<input type=\"checkbox\" name=\"ec_contact_create_account\" id=\"ec_contact_create_account\" onchange=\"ec_contact_create_account_change( );\"";
		if( isset( $_SESSION['ec_create_account'] ) )
			echo " checked=\checked\"";
		echo " />";
		
		if( !get_option( 'ec_option_allow_guest' ) ){
			echo "<script>jQuery('#ec_contact_create_account').hide(); jQuery('#ec_contact_create_account').attr('checked', true);
</script>";
		}
	}
	
	public function ec_cart_display_contact_password_input( ){
		echo "<input type=\"password\" name=\"ec_contact_password\" id=\"ec_contact_password\" class=\"ec_cart_contact_information_input_text\" />";
	}
	
	public function ec_cart_display_contact_password_retype_input( ){
		echo "<input type=\"password\" name=\"ec_contact_password_retype\" id=\"ec_contact_password_retype\" class=\"ec_cart_contact_information_input_text\" />";
	}
	
	public function ec_cart_display_contact_is_subscriber_input( ){
		echo "<input type=\"checkbox\" name=\"ec_contact_is_subscriber\" id=\"ec_contact_is_subscriber\" />";
	}
	/* END CONTACT INFORMATION FUNCTIONS */
	
	/* START SUBMIT ORDER DISPLAY FUNCTIONS */
    public function display_submit_order(){
		if(	$this->cart->total_items > 0 )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_submit_order.php' );
	}
	
	public function display_customer_order_notes( ){
		if( get_option( 'ec_option_user_order_notes' ) ){
			echo "<div class=\"ec_cart_payment_information_title\">" . $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ) . "</div>";
			echo "<div class=\"ec_cart_submit_order_message\">" . $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_message' ) . "</div>";	
			echo "<div class=\"ec_cart_payment_information_row\"><textarea name=\"ec_order_notes\">";
			if( isset( $_SESSION['ec_order_notes'] ) )
				echo $_SESSION['ec_order_notes'];
			
			echo "</textarea></div>";
		}
	}
	/* END SUBMIT ORDER DISPLAY FUNCTIONS */
	
	/* START FORM PROCESSING FUNCTIONS */
	// Process the cart page form action
	public function process_form_action( $action ){
		if( $action == "add_to_cart" )						$this->process_add_to_cart();
		else if( $action == "ec_update_action" )			$this->process_update_cartitem( $_POST['ec_update_cartitem_id'], $_POST['ec_cartitem_quantity_' . $_POST['ec_update_cartitem_id'] ] );
		else if( $action == "ec_delete_action" )			$this->process_delete_cartitem( $_POST['ec_delete_cartitem_id'] );
		else if( $action == "submit_order" )				$this->process_submit_order();
		else if( $action == "3dsecure" )					$this->process_3dsecure_response();
		else if( $action == "third_party_forward" )			$this->process_third_party_forward();
		else if( $action == "login_user" )					$this->process_login_user();
		else if( $action == "save_checkout_info" )			$this->process_save_checkout_info();
		else if( $action == "save_checkout_shipping" )		$this->process_save_checkout_shipping();
		else if( $action == "logout" )						$this->process_logout_user();
	}
	
	// Process the add to cart form submission
	private function process_add_to_cart(){
		
		//Product Info
		$session_id = session_id( );
		$product_id = $_POST['product_id'];
		$quantity = $_POST['product_quantity'];
		$model_number = $_POST['model_number'];
		
		//Optional Gift Card Info
		$gift_card_message = "";
		if( isset( $_POST['ec_gift_card_message'] ) )
			$gift_card_message = $_POST['ec_gift_card_message'];
		
		$gift_card_to_name = "";
		if( isset( $_POST['ec_gift_card_to_name'] ) )
			$gift_card_to_name = $_POST['ec_gift_card_to_name'];
		
		$gift_card_from_name = "";
		if( isset( $_POST['ec_gift_card_from_name'] ) )
			$gift_card_from_name = $_POST['ec_gift_card_from_name'];
		
		// Optional Donation Price
		$donation_price = 0.000;
		if( isset( $_POST['ec_product_input_price'] ) )
			$donation_price = $_POST['ec_product_input_price'];
		
		//Product Options
		$option1 = "";
		if( isset( $_POST['ec_option1'] ) )
			$option1 = $_POST['ec_option1'];
		
		$option2 = "";
		if( isset( $_POST['ec_option2'] ) )
			$option2 = $_POST['ec_option2'];
		
		$option3 = "";
		if( isset( $_POST['ec_option3'] ) )
			$option3 = $_POST['ec_option3'];
		
		$option4 = "";
		if( isset( $_POST['ec_option4'] ) )
			$option4 = $_POST['ec_option4'];
		
		$option5 = "";
		if( isset( $_POST['ec_option5'] ) )
			$option5 = $_POST['ec_option5'];
		
		$this->mysqli->add_to_cart( $product_id, $session_id, $quantity, $option1, $option2, $option3, $option4, $option5, $gift_card_message, $gift_card_to_name, $gift_card_from_name, $donation_price );
		
		header( "location: " . $this->cart_page . $this->permalink_divider . "model_number=" . $model_number );
		
	}
	
	private function process_update_cartitem( $cartitem_id, $new_quantity ){
		$this->mysqli->update_cartitem( $cartitem_id, session_id(), $new_quantity );
		
		if( isset( $_GET['ec_page'] ) )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $_GET['ec_page'] );	
		else
			header( "location: " . $this->cart_page );
	}
	
	private function process_delete_cartitem( $cartitem_id ){
		$this->mysqli->delete_cartitem( $cartitem_id, session_id() );
		
		if( isset( $_GET['ec_page'] ) )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $_GET['ec_page'] );	
		else
			header( "location: " . $this->cart_page );
	}
	
	private function process_submit_order(){
		if( isset( $_POST['ec_cart_payment_selection'] ) )
			$payment_type = $_POST['ec_cart_payment_selection'];
		else
			$payment_type = $GLOBALS['language']->get_text( "ec_success", "cart_account_free_order" );
			
		if( isset( $_POST['ec_order_notes'] ) )
			$_SESSION['ec_order_notes'] = $_POST['ec_order_notes'];
			
		$submit_return_val = $this->order->submit_order( $payment_type );
		
		if( $this->order_totals->grand_total <= 0 ){
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );	
			
		}else if( $payment_type == "manual_bill" ){ // Show fail message or the success landing page (including the manual bill notice).
			if( $submit_return_val == "1" )
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );
			else
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&cart_error=manualbill_failed" );
			
		}else if( $payment_type == "third_party" ){ // Show the third party landing page
			if( $submit_return_val == "1" )
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=third_party&order_id=" . $this->order->order_id );
			else
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=thirdparty_failed" );
				
		}else{ // Either show the success landing page
			
			if( $submit_return_val == "1" ){
				if( $this->order->payment->is_3d_auth )
					$this->auth_3d_form();
				else
					header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );	
					
			}else
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=payment_failed&reason=" . $submit_return_val );
			
		}
	}
	
	public function auth_3d_form( ){
		echo "<form name=\"ec_cart_3dauth_form\" method=\"POST\" action=\"" . $this->order->payment->post_url . "\">";
		echo "<input type=\"hidden\" name=\"" . $this->order->payment->post_id_input_name . "\" value=\"" . $this->order->payment->post_id . "\">";
		echo "<input type=\"hidden\" name=\"" . $this->order->payment->post_message_input_name . "\" value=\"" . $this->order->payment->post_message . "\">";
		echo "<input type=\"hidden\" name=\"" . $this->order->payment->post_return_url_input_name . "\" value=\"" . $this->cart_page . $this->permalink_divider . "ec_page=3dsecure&order_id=" . $this->order->order_id . "\">";
		echo "</form>";
		echo "<SCRIPT LANGUAGE=\"Javascript\">document.ec_cart_3dauth_form.submit();</SCRIPT>";
	}
	
	public function process_3dsecure_response( ){
		
		$success = false;
		
		if( get_option( 'ec_option_payment_process_method' ) == "sagepay" ){
			$gateway = new ec_sagepay( );
		}else if( get_option( 'ec_option_payment_process_method' ) == "realex" ){
			$gateway = new ec_realex( );
		}
		
		if( isset( $gateway ) ){
			$success = $gateway->secure_3d_auth( );
			if( $success ){
				
				// Quickbooks Hook
				if( file_exists( WP_PLUGIN_DIR . "/" . EC_QB_PLUGIN_DIRECTORY . "/ec_quickbooks.php" ) ){
					$quickbooks = new ec_quickbooks( );
					$quickbooks->add_order( $_GET['order_id'] );
				}
				
				$this->order->clear_session();
				if( $this->discount->giftcard_code )
					$this->mysqli->update_giftcard_total( $this->discount->giftcard_code, $this->discount->giftcard_discount );
						
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_GET['order_id'] );
			}
		}
		
		if( !$success ){
			$this->mysqli->remove_order( $_GET['order_id'] );
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=3dsecure_failed" );
		}	
	}
	
	private function process_third_party_forward( ){
		$this->payment->third_party->initialize( $_GET['order_id'] );
		$this->payment->third_party->display_auto_forwarding_form( );
	}
	
	private function process_login_user( ){
		$email = $_POST['ec_cart_login_email'];
		$password = md5( $_POST['ec_cart_login_password'] );
		
		if( $email == "guest"){
			$_SESSION['ec_email'] = "guest";
			$_SESSION['ec_username'] = "guest";
			$_SESSION['ec_password'] = "guest";
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
		}else{
			$user = $this->mysqli->get_user( $email, $password );
			if($user){
				$_SESSION['ec_user_id'] = $user->user_id;
				$_SESSION['ec_email'] = $email;
				$_SESSION['ec_username'] = $user->first_name . " " . $user->last_name;
				$_SESSION['ec_first_name'] = $user->first_name;
				$_SESSION['ec_last_name'] = $user->last_name;
				$_SESSION['ec_password'] = $password;
				
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_login&ec_cart_error=login_failed");
			}
		}
	}
	
	private function process_logout_user( ){
	
		unset( $_SESSION['ec_user_id'] );
		unset( $_SESSION['ec_email'] );
		unset( $_SESSION['ec_username'] );
		unset( $_SESSION['ec_first_name'] );
		unset( $_SESSION['ec_last_name'] );
		unset( $_SESSION['ec_password'] );
		
		unset( $_SESSION['ec_billing_first_name'] );
		unset( $_SESSION['ec_billing_last_name'] );
		unset( $_SESSION['ec_billing_address'] );
		unset( $_SESSION['ec_billing_city'] );
		unset( $_SESSION['ec_billing_state'] );
		unset( $_SESSION['ec_billing_zip'] );
		unset( $_SESSION['ec_billing_country'] );
		unset( $_SESSION['ec_billing_phone'] );
		
		unset( $_SESSION['ec_shipping_selector'] );
		
		unset( $_SESSION['ec_shipping_first_name'] );
		unset( $_SESSION['ec_shipping_last_name'] );
		unset( $_SESSION['ec_shipping_address'] );
		unset( $_SESSION['ec_shipping_city'] );
		unset( $_SESSION['ec_shipping_state'] );
		unset( $_SESSION['ec_shipping_zip'] );
		unset( $_SESSION['ec_shipping_country'] );
		unset( $_SESSION['ec_shipping_phone'] );
		
		unset( $_SESSION['ec_first_name'] );
		unset( $_SESSION['ec_last_name'] );
		
		unset( $_SESSION['ec_create_account'] );
		
		unset( $_SESSION['ec_order_notes'] );
		
		header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_login");
	
	}
	
	private function process_save_checkout_info( ){
		$billing_first_name = $shipping_first_name = $_POST['ec_cart_billing_first_name'];
		$billing_last_name = $shipping_last_name = $_POST['ec_cart_billing_last_name'];
		$billing_address = $shipping_address = $_POST['ec_cart_billing_address'];
		$billing_city = $shipping_city = $_POST['ec_cart_billing_city'];
		$billing_state = $shipping_state = $_POST['ec_cart_billing_state'];
		$billing_zip = $shipping_zip = $_POST['ec_cart_billing_zip'];
		$billing_country = $shipping_country = $_POST['ec_cart_billing_country'];
		$billing_phone = $shipping_phone = $_POST['ec_cart_billing_phone'];
		
		$shipping_selector = $_POST['ec_shipping_selector'];
		
		if( $shipping_selector == "true" ){
			$shipping_first_name = $_POST['ec_cart_shipping_first_name'];
			$shipping_last_name = $_POST['ec_cart_shipping_last_name'];
			$shipping_address = $_POST['ec_cart_shipping_address'];
			$shipping_city = $_POST['ec_cart_shipping_city'];
			$shipping_state = $_POST['ec_cart_shipping_state'];
			$shipping_zip = $_POST['ec_cart_shipping_zip'];
			$shipping_country = $_POST['ec_cart_shipping_country'];
			$shipping_phone = $_POST['ec_cart_shipping_phone'];
		}
		
		$first_name = $_POST['ec_contact_first_name'];
		$last_name = $_POST['ec_contact_last_name'];
		
		if( isset( $_POST['ec_contact_create_account'] ) )
			$create_account = $_POST['ec_contact_create_account'];
		else
			$create_account = false;
		
		
		$_SESSION['ec_billing_first_name'] = $billing_first_name;
		$_SESSION['ec_billing_last_name'] = $billing_last_name;
		$_SESSION['ec_billing_address'] = $billing_address;
		$_SESSION['ec_billing_city'] = $billing_city;
		$_SESSION['ec_billing_state'] = $billing_state;
		$_SESSION['ec_billing_zip'] = $billing_zip;
		$_SESSION['ec_billing_country'] = $billing_country;
		$_SESSION['ec_billing_phone'] = $billing_phone;
		
		$_SESSION['ec_shipping_selector'] = $shipping_selector;
		
		$_SESSION['ec_shipping_first_name'] = $shipping_first_name;
		$_SESSION['ec_shipping_last_name'] = $shipping_last_name;
		$_SESSION['ec_shipping_address'] = $shipping_address;
		$_SESSION['ec_shipping_city'] = $shipping_city;
		$_SESSION['ec_shipping_state'] = $shipping_state;
		$_SESSION['ec_shipping_zip'] = $shipping_zip;
		$_SESSION['ec_shipping_country'] = $shipping_country;
		$_SESSION['ec_shipping_phone'] = $shipping_phone;
		
		$_SESSION['ec_first_name'] = $first_name;
		$_SESSION['ec_last_name'] = $last_name;
		
		$next_page = "checkout_shipping";
		if( !get_option( 'ec_option_use_shipping' ) || $this->cart->weight == 0 )
			$next_page = "checkout_payment";
		
		if( $_SESSION['ec_email'] == "guest" ){
			$email = $_POST['ec_contact_email'];
			$_SESSION['ec_email'] = $email;
		}
		
		if( $create_account ){
			$email = $_POST['ec_contact_email'];
			$password = md5( $_POST['ec_contact_password'] );
			
			// INSERT USER
			$billing_id = $this->mysqli->insert_address( $billing_first_name, $billing_last_name, $billing_address, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone );
			
			$shipping_id = $this->mysqli->insert_address( $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone );
			
			$user_level = "shopper";
			if( isset( $_POST['ec_contact_is_subscriber'] ) )
				$is_subscriber = true;
			else
				$is_subscriber = false;
			
			$user_id = $this->mysqli->insert_user( $email, $password, $first_name, $last_name, $billing_id, $shipping_id, $user_level, $is_subscriber );
			$this->mysqli->update_address_user_id( $billing_id, $user_id );
			$this->mysqli->update_address_user_id( $shipping_id, $user_id );
			
			// Quickbooks Hook
			if( file_exists( WP_PLUGIN_DIR . "/" . EC_QB_PLUGIN_DIRECTORY . "/ec_quickbooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->add_user( $user_id );
			}
			
			if( $user_id != 0 ){
			
				$_SESSION['ec_user_id'] = $user_id;
				$_SESSION['ec_email'] = $email;
				$_SESSION['ec_username'] = $first_name . " " . $last_name;
				$_SESSION['ec_first_name'] = $first_name;
				$_SESSION['ec_last_name'] = $last_name;
				$_SESSION['ec_password'] = $password;
				
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page . "&ec_cart_success=account_created");
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=email_exists");
			}
		}else{
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page);
		}
	}
	
	private function process_save_checkout_shipping( ){
		if( isset( $_POST['ec_cart_shipping_method'] ) )
			$shipping_method = $_POST['ec_cart_shipping_method'];
		else
			$shipping_method = "";
		if( isset( $_POST['ec_cart_ship_express'] ) )
			$ship_express = $_POST['ec_cart_ship_express'];
		else
			$ship_express = "";
		
		$_SESSION['ec_shipping_method'] = $shipping_method;
		$_SESSION['ec_ship_express'] = $ship_express;
		
		header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment");
	}
	/* END PROCESS FORM SUBMISSION FUNCTIONS */
}

?>