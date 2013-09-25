<?php

class ec_accountpage{
	protected $mysqli;							// ec_db structure
	
	public $user;								// ec_user structure
	public $orders;								// ec_orderlist structure
	public $order;								// ec_orderitem structure
	
	private $user_email;						// VARCHAR
	private $user_password;						// VARCHAR
	
	private $account_page;						// VARCHAR
	private $permalink_divider;					// CHAR
	
	////////////////////////////////////////////////////////
	// CONSTUCTOR FUNCTION
	////////////////////////////////////////////////////////
	function __construct( ){
		$this->mysqli = new ec_db();
		
		$this->user_email = "";
		if( isset( $_SESSION['ec_email'] ) )
			$this->user_email = $_SESSION['ec_email'];
		
		$this->user_password = "";
		if( isset( $_SESSION['ec_password'] ) )
			$this->user_password = $_SESSION['ec_password'];
		
		$this->user = new ec_user( $this->user_email );
		
		$this->orders = new ec_orderlist( $this->user->user_id, $this->user_email, $this->user_password );
		if( isset( $_GET['order_id'] ) ){
			$order_row = $this->mysqli->get_order_row( $_GET['order_id'], $this->user_email, $this->user_password );
			$this->order = new ec_orderdisplay( $order_row, true );
		}
		
		$accountpageid = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $accountpageid );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->account_page = $https_class->getHttpsUrl( ) . substr( $this->account_page, strlen( get_settings('home') ) );
		}
		
		if( substr_count( $this->account_page, '?' ) )				$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
	}
	
	public function display_account_page( ){
		echo "<div class=\"ec_account_page\">";
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_page.php' );
		echo "<input type=\"hidden\" name=\"ec_account_base_path\" id=\"ec_account_base_path\" value=\"" . plugins_url( ) . "\" />";
		echo "<input type=\"hidden\" name=\"ec_account_session_id\" id=\"ec_account_session_id\" value=\"" . session_id() . "\" />";
		echo "<input type=\"hidden\" name=\"ec_account_email\" id=\"ec_account_email\" value=\"" . $this->user_email . "\" />";
		
		$page_name = "";
		if( isset( $_GET['ec_page'] ) )
			$page_name = $_GET['ec_page'];
		
		echo "<input type=\"hidden\" name=\"ec_account_start_page\" id=\"ec_account_start_page\" value=\"" . $page_name . "\" />";
		echo "</div>";
	}
	
	public function display_account_error(){
		if( isset( $_GET['account_error'] ) ){
			$error_text = $GLOBALS['language']->get_text( "ec_errors", $_GET['account_error'] );
			if( $error_text )
				echo "<div class=\"ec_account_error\"><div>" . $error_text . "</div></div>";
		}
	}
	
	public function display_account_success(){
		if( isset( $_GET['account_success'] ) ){
			$success_text = $GLOBALS['language']->get_text( "ec_success", $_GET['account_success'] );
			if( $success_text )
				echo "<div class=\"ec_account_success\"><div>" . $success_text . "</div></div>";
		}
	}
	
	public function is_page_visible( $page_name ){
		if( isset( $_GET['ec_page'] ) ){ //Check for a ec_page variable, act differently if set.
			if( isset( $_SESSION['ec_password'] ) && $_SESSION['ec_password'] != "guest" ){ //If logged in we can show any page accept login
				if ( $page_name == 'login' )															return false;
				else if( $page_name == $_GET['ec_page'] )												return true;
				else if( $_GET['ec_page'] == 'login' && $page_name == 'dashboard')						return true;
				else																					return false;
			}else{ //If not logged in we can only show login or register
				if( $page_name == 'forgot_password' && $_GET['ec_page'] == 'forgot_password' )			return true;
				else if( $page_name == 'register' && $_GET['ec_page'] == 'register' )					return true;
				else if( $page_name == 'login' && $_GET['ec_page'] != 'register' && $_GET['ec_page'] != 'forgot_password' )	
																										return true;
				else																					return false;
			}
		}else{ //ec_page variable is not set
			if( isset( $_SESSION['ec_password'] ) && $_SESSION['ec_password'] != "guest" ){ //If logged in we should only show dashboard here
				if( $page_name == 'dashboard' )										return true;
				else																return false;
			}else{ //If not logged in we should only show login here
				if( $page_name == 'login' )											return true;
				else																return false;
			}
		}
	}
	
	/* START ACCOUNT LOGIN FUNCTIONS */
	public function display_account_login( ){
		if( $this->is_page_visible( "login" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_login.php' );
	}
	
	public function display_account_login_form_start( ){
		echo "<form action=\"" . $this->account_page . "\" method=\"POST\">";
	}
	
	public function display_account_login_form_end( ){
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" value=\"login\" />";
		echo "</form>";	
	}
	
	public function display_account_login_email_input( ){
		echo "<input type=\"email\" name=\"ec_account_login_email\" id=\"ec_account_login_email\" class=\"ec_account_login_input_field\" autocomplete=\"off\" autocapitalize=\"off\">";
	}
	
	public function display_account_login_password_input( ){
		echo "<input type=\"password\" name=\"ec_account_login_password\" id=\"ec_account_login_password\" class=\"ec_account_login_input_field\">";
	}
	
	public function display_account_login_button( $button_text ){
		echo "<input type=\"submit\" name=\"ec_account_login_button\" id=\"ec_account_login_button\" class=\"ec_account_login_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_login_button_click();\">";
	}
	
	public function display_account_login_forgot_password_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=forgot_password\" class=\"ec_account_login_link\">" . $link_text . "</a>";
	}
	
	public function display_account_login_create_account_button( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=register\" class=\"ec_account_login_create_account_button\">" . $link_text . "</a>";
	}
	
	/* END ACCOUNT LOGIN FUNCTIONS */
	
	/* START FORGOT PASSWORD FUNCTIONS */
	public function display_account_forgot_password( ){
		if( $this->is_page_visible( "forgot_password" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_forgot_password.php' );
	}
	
	public function display_account_forgot_password_form_start( ){
		echo "<form action=\"" . $this->account_page . "\" method=\"POST\" />";	
	}
	
	public function display_account_forgot_password_form_end( ){
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" value=\"retrieve_password\" />";
		echo "</form>";
	}
	
	public function display_account_forgot_password_email_input( ){
		echo "<input type=\"email\" name=\"ec_account_forgot_password_email\" id=\"ec_account_forgot_password_email\" class=\"ec_account_forgot_password_input_field\">";	
	}
	
	public function display_account_forgot_password_submit_button( $button_text ){
		echo "<input type=\"submit\" name=\"ec_account_forgot_password_button\" id=\"ec_account_forgot_password_button\" class=\"ec_account_forgot_password_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_forgot_password_button_click();\">";
	}
	/* END FORGOT PASSWORD FUNCTIONS*/
	
	/* START REGISTER FUNCTIONS */
	public function display_account_register( ){
		if( $this->is_page_visible( "register" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_register.php' );
	}
	
	public function display_account_register_form_start( ){
		echo "<form action=\"" . $this->account_page . "\" method=\"POST\">";
	}
	
	public function display_account_register_form_end( ){
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" value=\"register\"/>";
		echo "</form>";
	}
	
	public function display_account_register_first_name_input( ){
		echo "<input type=\"text\" name=\"ec_account_register_first_name\" id=\"ec_account_register_first_name\" class=\"ec_account_register_input_field\">";
	}
	
	public function display_account_register_last_name_input( ){
		echo "<input type=\"text\" name=\"ec_account_register_last_name\" id=\"ec_account_register_last_name\" class=\"ec_account_register_input_field\">";
	}
	
	public function display_account_register_zip_input( ){
		echo "<input type=\"text\" name=\"ec_account_register_zip\" id=\"ec_account_register_zip\" class=\"ec_account_register_input_field\">";
	}
	
	public function display_account_register_email_input( ){
		echo "<input type=\"email\" name=\"ec_account_register_email\" id=\"ec_account_register_email\" class=\"ec_account_register_input_field\">";
	}
	
	public function display_account_register_password_input( ){
		echo "<input type=\"password\" name=\"ec_account_register_password\" id=\"ec_account_register_password\" class=\"ec_account_register_input_field\">";
	}
	
	public function display_account_register_retype_password_input( ){
		echo "<input type=\"password\" name=\"ec_account_register_password_retype\" id=\"ec_account_register_password_retype\" class=\"ec_account_register_input_field\">";
	}
	
	public function display_account_register_is_subscriber_input( ){
		echo "<input type=\"checkbox\" name=\"ec_account_register_is_subscriber\" id=\"ec_account_register_is_subscriber\" class=\"ec_account_register_input_field\" />";	
	}
	
	public function display_account_register_button( $button_text ){
		if( get_option( 'ec_option_require_account_address' ) )
			echo "<input type=\"submit\" name=\"ec_account_register_button\" id=\"ec_account_register_button\" class=\"ec_account_register_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_register_button_click2( );\">";
		else
			echo "<input type=\"submit\" name=\"ec_account_register_button\" id=\"ec_account_register_button\" class=\"ec_account_register_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_register_button_click( );\">";
	}
	/* END REGISTER FUNCTIONS */
	
	/* START DASHBOARD FUNCTIONS */
	public function display_account_dashboard( ){
		if( $this->is_page_visible( "dashboard" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_dashboard.php' );
	}
	
	public function display_dashboard_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=dashboard\" class=\"ec_account_dashboard_link\">" . $link_text . "</a>";	
	}
	
	public function display_orders_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=orders\" class=\"ec_account_dashboard_link\">" . $link_text . "</a>";	
	}
	
	public function display_personal_information_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=personal_information\" class=\"ec_account_dashboard_link\">" . $link_text . "</a>";
	}
	
	public function display_billing_information_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=billing_information\" class=\"ec_account_dashboard_link\">" . $link_text . "</a>";
	}
	
	public function display_shipping_information_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=shipping_information\" class=\"ec_account_dashboard_link\">" . $link_text . "</a>";
	}
	
	public function display_password_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=password\" class=\"ec_account_dashboard_link\">" . $link_text . "</a>";
	}
	
	public function display_logout_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=logout\" class=\"ec_account_dashboard_link\">" . $link_text . "</a>";
	}
	/* END DASHBOARD FUNCTIONS */
	
	/* START ORDERS FUNCTIONS */
	public function display_account_orders( ){
		if( $this->is_page_visible( "orders" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_orders.php' );
	}
	/* END ORDERS FUNCTIONS*/
	
	/* START ORDER DETAILS FUNCTIONS */
	public function display_account_order_details( ){
		if( $this->is_page_visible( "order_details" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_order_details.php' );
	}
	
	public function display_order_detail_product_list( ){
		if( $this->order ){
			$this->order->display_order_detail_product_list( );
		}
	}
	
	public function display_print_order_icon( ){
		if( $this->order )
			echo "<a href=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/print_receipt.php?order_id=" . $this->order->order_id ) . "\" target=\"_blank\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_account_order_details/print_icon.png" ) . "\" alt=\"print\" /></a>";
	}
	/* END ORDER DETAILS FUNCTIONS*/
	
	/* START PERSONAL INFORMATION FUNCTIONS */
	public function display_account_personal_information( ){
		if( $this->is_page_visible( "personal_information" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_personal_information.php' );
	}
	
	public function display_account_personal_information_form_start( ){
		echo "<form action=\"" . $this->account_page . "\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" id=\"ec_account_personal_information_form_action\" value=\"update_personal_information\" />";
	}
	
	public function display_account_personal_information_form_end( ){
		echo "</form>";
	}
	
	public function display_account_personal_information_first_name_input( ){
		echo "<input type=\"text\" name=\"ec_account_personal_information_first_name\" id=\"ec_account_personal_information_first_name\" class=\"ec_account_personal_information_input_field\" value=\"" . $this->user->first_name . "\" />";
	}
	
	public function display_account_personal_information_last_name_input( ){
		echo "<input type=\"text\" name=\"ec_account_personal_information_last_name\" id=\"ec_account_personal_information_last_name\" class=\"ec_account_personal_information_input_field\" value=\"" . $this->user->last_name . "\" />";
	}
	
	public function display_account_personal_information_zip_input( ){
		echo "<input type=\"text\" name=\"ec_account_personal_information_zip\" id=\"ec_account_personal_information_zip\" class=\"ec_account_personal_information_input_field\" value=\"" . $this->user->billing->zip . "\" />";
	}
	
	public function display_account_personal_information_email_input( ){
		echo "<input type=\"email\" name=\"ec_account_personal_information_email\" id=\"ec_account_personal_information_email\" class=\"ec_account_personal_information_input_field\" value=\"" . $this->user->email . "\" />";
	}
	
	public function display_account_personal_information_is_subscriber_input( ){
		echo "<input type=\"checkbox\" name=\"ec_account_personal_information_is_subscriber\" id=\"ec_account_personal_information_is_subscriber\" class=\"ec_account_personal_information_input_field\"";
		if( $this->user->is_subscriber )
		echo " checked=\"checked\"";
		echo "/>";
	}
	
	public function display_account_personal_information_update_button( $button_text ){
		echo "<input type=\"submit\" name=\"ec_account_personal_information_button\" id=\"ec_account_personal_information_button\" class=\"ec_account_personal_information_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_personal_information_update_click();\" />";
	}
	public function display_account_personal_information_cancel_link( $button_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=dashboard\" class=\"ec_account_personal_information_link\"><input type=\"button\" name=\"ec_account_personal_information_button\" id=\"ec_account_personal_information_button\" class=\"ec_account_personal_information_button\" value=\"" . $button_text . "\" onclick=\"window.location='" . $this->account_page . $this->permalink_divider . "ec_page=dashboard'\" /></a>";
	}
	

	/* END PERSONAL INFORMATION FUNCTIONS */
	
	/* START PASSWORD FUNCTIONS */
	public function display_account_password( ){
		if( $this->is_page_visible( "password" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_password.php' );
	}
	
	public function display_account_password_form_start( ){
		echo "<form action=\"" . $this->account_page . "\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" id=\"ec_account_password_form_action\" value=\"update_password\" />";
	}
	
	public function display_account_password_form_end( ){
		echo "</form>";
	}
	
	public function display_account_password_current_password( ){
		echo "<input type=\"password\" name=\"ec_account_password_current_password\" id=\"ec_account_password_current_password\" class=\"ec_account_password_input_field\">";
	}
	
	public function display_account_password_new_password( ){
		echo "<input type=\"password\" name=\"ec_account_password_new_password\" id=\"ec_account_password_new_password\" class=\"ec_account_password_input_field\">";
	}
	
	public function display_account_password_retype_new_password( ){
		echo "<input type=\"password\" name=\"ec_account_password_retype_new_password\" id=\"ec_account_password_retype_new_password\" class=\"ec_account_password_input_field\">";
	}
	
	public function display_account_password_update_button( $button_text ){
		echo "<input type=\"submit\" name=\"ec_account_password_button\" id=\"ec_account_password_button\" class=\"ec_account_password_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_password_button_click();\" />";
	}
	public function display_account_password_cancel_link( $button_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=dashboard\" class=\"ec_account_password_link\"><input type=\"button\" name=\"ec_account_password_button\" id=\"ec_account_password_button\" class=\"ec_account_password_button\" value=\"" . $button_text . "\" onclick=\"window.location='" . $this->account_page . $this->permalink_divider . "ec_page=dashboard'\" /></a>";
	}

	/* END PASSWORD FUNCTIONS */
	
	/* START BILLING INFORMATION FUNCTIONS */
	public function display_account_billing_information( ){
		if( $this->is_page_visible( "billing_information" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_billing_information.php' );
	}
	
	public function display_account_billing_information_form_start( ){
		echo "<form action=\"" . $this->account_page . "\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" id=\"ec_account_billing_information_form_action\" value=\"update_billing_information\" />";
	}
	
	public function display_account_billing_information_form_end( ){
		echo "</form>";
	}
	
	public function display_account_billing_information_first_name_input(){
		echo "<input type=\"text\" name=\"ec_account_billing_information_first_name\" id=\"ec_account_billing_information_first_name\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->first_name . "\" />";
	}
	
	public function display_account_billing_information_last_name_input(){
		echo "<input type=\"text\" name=\"ec_account_billing_information_last_name\" id=\"ec_account_billing_information_last_name\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->last_name . "\" />";
	}
	
	public function display_account_billing_information_address_input(){
		echo "<input type=\"text\" name=\"ec_account_billing_information_address\" id=\"ec_account_billing_information_address\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->address_line_1 . "\" />";
	}
	
	public function display_account_billing_information_city_input(){
		echo "<input type=\"text\" name=\"ec_account_billing_information_city\" id=\"ec_account_billing_information_city\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->city . "\" />";
	}
	
	public function display_account_billing_information_state_input(){
		if( get_option( 'ec_option_use_state_dropdown' ) ){
			$states = $this->mysqli->get_states( );
			$selected_state = $this->user->billing->state;
			
			echo "<select name=\"ec_account_billing_information_state\" id=\"ec_account_billing_information_state\" class=\"ec_account_billing_information_input_field\">";
			echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "account_billing_information", "account_billing_information_default_no_state" ) . "</option>";
			foreach($states as $state){
				echo "<option value=\"" . $state->code_sta . "\"";
				if( $state->code_sta == $selected_state )
				echo " selected=\"selected\"";
				echo ">" . $state->name_sta . "</option>";
			}
			echo "</select>";
		}else{
			echo "<input type=\"text\" name=\"ec_account_billing_information_state\" id=\"ec_account_billing_information_state\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->state . "\" />";
		}
	}
	
	public function display_account_billing_information_zip_input(){
		echo "<input type=\"text\" name=\"ec_account_billing_information_zip\" id=\"ec_account_billing_information_zip\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->zip . "\" />";
	}
	
	public function display_account_billing_information_country_input(){
		if( get_option( 'ec_option_use_country_dropdown' ) ){
			$countries = $this->mysqli->get_countries( );
			$selected_country = $this->user->billing->country;
			
			echo "<select name=\"ec_account_billing_information_country\" id=\"ec_account_billing_information_country\" class=\"ec_account_billing_information_input_field\">";
			echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "account_billing_information", "account_billing_information_default_no_country" ) . "</option>";
			foreach($countries as $country){
				echo "<option value=\"" . $country->iso2_cnt . "\"";
				if( $country->iso2_cnt == $selected_country )
				echo " selected=\"selected\"";
				echo ">" . $country->name_cnt . "</option>";
			}
			echo "</select>";
		}else{
			echo "<input type=\"text\" name=\"ec_account_billing_information_country\" id=\"ec_account_billing_information_country\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->country . "\" />";
		}
	}
	
	public function display_account_billing_information_phone_input(){
		echo "<input type=\"text\" name=\"ec_account_billing_information_phone\" id=\"ec_account_billing_information_phone\" class=\"ec_account_billing_information_input_field\" value=\"" . $this->user->billing->phone . "\" />";
	}
	
	public function display_account_billing_information_update_button( $button_text ){
		echo "<input type=\"submit\" name=\"ec_account_billing_information_button\" id=\"ec_account_billing_information_button\" class=\"ec_account_billing_information_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_billing_information_update_click();\" />";
	}
	public function display_account_billing_information_cancel_link( $button_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=dashboard\" class=\"ec_account_billing_information_link\">" . "<input type=\"button\" name=\"ec_account_billing_information_button\" id=\"ec_account_billing_information_button\" class=\"ec_account_billing_information_button\" value=\"" . $button_text . "\" onclick=\"window.location='" . $this->account_page . $this->permalink_divider . "ec_page=dashboard'\" /></a>";
	}
	

	/* END BILLING INFORMATION FUNCTIONS */
	
	/* START SHIPPING INFORMATION FUNCTIONS */
	public function display_account_shipping_information( ){
		if( $this->is_page_visible( "shipping_information" ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_shipping_information.php' );
	}
	
	public function display_account_shipping_information_form_start( ){
		echo "<form action=\"" . $this->account_page . "\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" id=\"ec_account_shipping_information_form_action\" value=\"update_shipping_information\" />";
	}
	
	public function display_account_shipping_information_form_end( ){
		echo "</form>";
	}
	
	public function display_account_shipping_information_first_name_input(){
		echo "<input type=\"text\" name=\"ec_account_shipping_information_first_name\" id=\"ec_account_shipping_information_first_name\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->first_name . "\" />";
	}
	
	public function display_account_shipping_information_last_name_input(){
		echo "<input type=\"text\" name=\"ec_account_shipping_information_last_name\" id=\"ec_account_shipping_information_last_name\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->last_name . "\" />";
	}
	
	public function display_account_shipping_information_address_input(){
		echo "<input type=\"text\" name=\"ec_account_shipping_information_address\" id=\"ec_account_shipping_information_address\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->address_line_1 . "\" />";
	}
	
	public function display_account_shipping_information_city_input(){
		echo "<input type=\"text\" name=\"ec_account_shipping_information_city\" id=\"ec_account_shipping_information_city\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->city . "\" />";
	}
	
	public function display_account_shipping_information_state_input(){
		if( get_option( 'ec_option_use_state_dropdown' ) ){
			$states = $this->mysqli->get_states( );
			$selected_state = $this->user->shipping->state;
			
			echo "<select name=\"ec_account_shipping_information_state\" id=\"ec_account_shipping_information_state\" class=\"ec_account_shipping_information_input_field\">";
			echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "account_shipping_information", "account_shipping_information_default_no_state" ) . "</option>";
			foreach($states as $state){
				echo "<option value=\"" . $state->code_sta . "\"";
				if( $state->code_sta == $selected_state )
				echo " selected=\"selected\"";
				echo ">" . $state->name_sta . "</option>";
			}
			echo "</select>";
		}else{
			echo "<input type=\"text\" name=\"ec_account_shipping_information_state\" id=\"ec_account_shipping_information_state\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->state . "\" />";
		}
	}
	
	public function display_account_shipping_information_zip_input(){
		echo "<input type=\"text\" name=\"ec_account_shipping_information_zip\" id=\"ec_account_shipping_information_zip\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->zip . "\" />";
	}
	
	public function display_account_shipping_information_country_input(){
		if( get_option( 'ec_option_use_country_dropdown' ) ){
			$countries = $this->mysqli->get_countries( );
			$selected_country = $this->user->shipping->country;
			
			echo "<select name=\"ec_account_shipping_information_country\" id=\"ec_account_shipping_information_country\" class=\"ec_account_shipping_information_input_field\">";
			echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "account_shipping_information", "account_shipping_information_default_no_country" ) . "</option>";
			foreach($countries as $country){
				echo "<option value=\"" . $country->iso2_cnt . "\"";
				if( $country->iso2_cnt == $selected_country )
				echo " selected=\"selected\"";
				echo ">" . $country->name_cnt . "</option>";
			}
			echo "</select>";
		}else{
			echo "<input type=\"text\" name=\"ec_account_shipping_information_country\" id=\"ec_account_shipping_information_country\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->country . "\" />";
		}
	}
	
	public function display_account_shipping_information_phone_input(){
		echo "<input type=\"text\" name=\"ec_account_shipping_information_phone\" id=\"ec_account_shipping_information_phone\" class=\"ec_account_shipping_information_input_field\" value=\"" . $this->user->shipping->phone . "\" />";
	}
	
	public function display_account_shipping_information_update_button( $button_text ){
		echo "<input type=\"submit\" name=\"ec_account_shipping_information_button\" id=\"ec_account_shipping_information_button\" class=\"ec_account_shipping_information_button\" value=\"" . $button_text . "\" onclick=\"return ec_account_shipping_information_update_click();\" />";
	}
	
	public function display_account_shipping_information_cancel_link( $button_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=dashboard\" class=\"ec_account_shipping_information_link\">" ."<input type=\"button\" name=\"ec_account_shipping_information_button\" id=\"ec_account_shipping_information_button\" class=\"ec_account_shipping_information_button\" value=\"" . $button_text . "\" onclick=\"window.location='" . $this->account_page . $this->permalink_divider . "ec_page=dashboard'\" /></a>";
	}
	

	/* END SHIPPING INFORMATION FUNCTIONS */
	
	/* START FORM ACTION FUNCTIONS */
	public function process_form_action( $action ){
		if( $action == "login" )
			$this->process_login( );
		else if( $action == "register" )
			$this->process_register( );
		else if( $action == "retrieve_password" )
			$this->process_retrieve_password( );
		else if( $action == "update_personal_information" )
			$this->process_update_personal_information( );
		else if( $action == "update_password" )
			$this->process_update_password( );
		else if( $action == "update_billing_information" )
			$this->process_update_billing_information( );
		else if( $action == "update_shipping_information" )
			$this->process_update_shipping_information( );
		else if( $action == "logout" )
			$this->process_logout( );
	}
	
	private function process_login( ){
		$email = $_POST['ec_account_login_email'];
		$password = md5( $_POST['ec_account_login_password'] );
		
		$user = $this->mysqli->get_user( $email, $password );
		
		if( $user ){
			$_SESSION['ec_user_id'] = $user->user_id;
			$_SESSION['ec_email'] = $email;
			$_SESSION['ec_username'] = $user->first_name . " " . $user->last_name;
			$_SESSION['ec_first_name'] = $user->first_name;
			$_SESSION['ec_last_name'] = $user->last_name;
			$_SESSION['ec_password'] = $password;
		
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard" );
			
		}else{
			
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=login&account_error=login_failed" );
				
		}
	}
	
	private function process_register( ){
		$first_name = $_POST['ec_account_register_first_name'];
		$last_name = $_POST['ec_account_register_last_name'];
		$email = $_POST['ec_account_register_email'];
		$password = md5( $_POST['ec_account_register_password'] );
		$is_subscriber = $_POST['ec_account_register_is_subscriber'];
		$billing_id = 0;
		
		// Insert billing address if enabled
		if( get_option( 'ec_option_require_account_address' ) ){
			$billing = array( "first_name" 	=> $_POST['ec_account_billing_information_first_name'],
							  "last_name"	=> $_POST['ec_account_billing_information_last_name'],
							  "address"		=> $_POST['ec_account_billing_information_address'],
							  "city"		=> $_POST['ec_account_billing_information_city'],
							  "state"		=> $_POST['ec_account_billing_information_state'],
							  "zip_code"	=> $_POST['ec_account_billing_information_zip'],
							  "country"		=> $_POST['ec_account_billing_information_country'],
							  "phone"		=> $_POST['ec_account_billing_information_phone']
							);
			
			$billing_id = $this->mysqli->insert_address( $billing["first_name"], $billing["last_name"], $billing["address"], $billing["city"], $billing["state"], $billing["zip_code"], $billing["country"], $billing["phone"] );
		}
		
		// Insert the user
		$user_id = $this->mysqli->insert_user( $email, $password, $first_name, $last_name, $billing_id, 0, "shopper", $is_subscriber );
		
		// Update the address user_id
		if( get_option( 'ec_option_require_account_address' ) ){
			$this->mysqli->update_address_user_id( $billing_id, $user_id );
		}
		
		if( $user_id ){
			$_SESSION['ec_user_id'] = $user_id;
			$_SESSION['ec_email'] = $email;
			$_SESSION['ec_username'] = $first_name . " " . $last_name;
			$_SESSION['ec_first_name'] = $first_name;
			$_SESSION['ec_last_name'] = $last_name;
			$_SESSION['ec_password'] = $password;
		
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard" );
			
		}else{
			
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=register&account_error=register_email_error" );
				
		}
	}
	
	private function process_retrieve_password( ){
		$email = $_POST['ec_account_forgot_password_email'];
		$new_password = $this->get_random_password( );
		
		$success = $this->mysqli->reset_password( $email, md5( $new_password ) );
		
		if( $success ){
			$this->send_new_password_email( $email, $new_password );
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=login&account_success=reset_email_sent" );
		}else{
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=register&account_error=no_reset_email_found" );
		}
		
	}
	
	private function process_update_personal_information( ){
		$old_email = $_SESSION['ec_email'];
		$password = $_SESSION['ec_password'];
		$first_name = $_POST['ec_account_personal_information_first_name'];
		$last_name = $_POST['ec_account_personal_information_last_name'];
		$email = $_POST['ec_account_personal_information_email'];
		if( isset( $_POST['ec_account_personal_information_is_subscriber'] ) &&  $_POST['ec_account_personal_information_is_subscriber'] )
			$is_subscriber = 1;
		else
			$is_subscriber = 0;
		
		$success = $this->mysqli->update_personal_information( $old_email, $password, $first_name, $last_name, $email, $is_subscriber );
		
		//Update Custom Fields if They Exist
		if( count( $this->user->customfields ) > 0 ){
			for( $i=0; $i<count( $this->user->customfields ); $i++ ){
				$this->mysqli->update_customfield_data( $this->user->customfields[$i][0], $_POST['ec_user_custom_field_' . $this->user->customfields[$i][0]] );
			}
		}
		
		if( $success >= 0 ){
			$_SESSION['ec_email'] = $email;
			$_SESSION['ec_username'] = $first_name . " " . $last_name;
			$_SESSION['ec_first_name'] = $first_name;
			$_SESSION['ec_last_name'] = $last_name;
			
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard&account_success=personal_information_updated" );
		}else
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=personal_information&account_error=personal_information_update_error" );
		
	}
	
	private function process_update_password( ){
		$session_email = $_SESSION['ec_email'];
		$session_password = $_SESSION['ec_password'];
		
		$current_password = md5( $_POST['ec_account_password_current_password'] );
		$new_password = md5( $_POST['ec_account_password_new_password'] );
		$retype_new_password = md5( $_POST['ec_account_password_retype_new_password'] );
		
		if( $session_password != $current_password )
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=password&account_error=password_wrong_current" );
		else if( $new_password != $retype_new_password )
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=password&account_error=password_no_match" );
		else{
			$success = $this->mysqli->update_password( $session_email, $current_password, $new_password );
			
			if( $success >= 0 ){
				$_SESSION['ec_password'] = $new_password;
				header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard&account_success=password_updated" );
			}else
				header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=password&account_error=password_update_error" );
		}
	}
	
	private function process_update_billing_information( ){
		$first_name = $_POST['ec_account_billing_information_first_name'];
		$last_name = $_POST['ec_account_billing_information_last_name'];
		$address = $_POST['ec_account_billing_information_address'];
		$city = $_POST['ec_account_billing_information_city'];
		$state = $_POST['ec_account_billing_information_state'];
		$zip = $_POST['ec_account_billing_information_zip'];
		$country = $_POST['ec_account_billing_information_country'];
		$phone = $_POST['ec_account_billing_information_phone'];
		
		if( $first_name == $this->user->billing->first_name && 
			$last_name == $this->user->billing->last_name && 
			$address == $this->user->billing->address_line_1 && 
			$city == $this->user->billing->city && 
			$state == $this->user->billing->state && 
			$zip == $this->user->billing->zip && 
			$country == $this->user->billing->country &&
			$phone == $this->user->billing->phone ){
			
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard&account_success=billing_information_updated" );
				
		}else{
		
			$address_id = $this->user->billing_id;
			if( $address_id )
				$success = $this->mysqli->update_user_address( $address_id, $first_name, $last_name, $address, $city, $state, $zip, $country, $phone );
			else{
				$success = $this->mysqli->insert_user_address( $first_name, $last_name, $address, $city, $state, $zip, $country, $phone, $this->user_email, $this->user_password, "billing" );
			}
			
			if( $success >= 0 )
				header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard&account_success=billing_information_updated" );
			else
				header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=billing_information&account_error=billing_information_error" );
			
		}
	}
	
	private function process_update_shipping_information( ){
		$first_name = $_POST['ec_account_shipping_information_first_name'];
		$last_name = $_POST['ec_account_shipping_information_last_name'];
		$address = $_POST['ec_account_shipping_information_address'];
		$city = $_POST['ec_account_shipping_information_city'];
		$state = $_POST['ec_account_shipping_information_state'];
		$zip = $_POST['ec_account_shipping_information_zip'];
		$country = $_POST['ec_account_shipping_information_country'];
		$phone = $_POST['ec_account_shipping_information_phone'];
		
		if( $first_name == $this->user->shipping->first_name && 
			$last_name == $this->user->shipping->last_name && 
			$address == $this->user->shipping->address_line_1 && 
			$city == $this->user->shipping->city && 
			$state == $this->user->shipping->state && 
			$zip == $this->user->shipping->zip && 
			$country == $this->user->shipping->country &&
			$phone == $this->user->shipping->phone ){
			
			header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard&account_success=shipping_information_updated" );
				
		}else{
		
			$address_id = $this->user->shipping_id;
			if( $address_id )
				$success = $this->mysqli->update_user_address( $address_id, $first_name, $last_name, $address, $city, $state, $zip, $country, $phone );
			else{
				$success = $this->mysqli->insert_user_address( $first_name, $last_name, $address, $city, $state, $zip, $country, $phone, $this->user_email, $this->user_password, "shipping" );
			}
			
			$success = $this->mysqli->update_user_address( $address_id, $first_name, $last_name, $address, $city, $state, $zip, $country, $phone );
			if( $success >= 0 )
				header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=dashboard&account_success=shipping_information_updated" );
			else
				header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=shipping_information&account_error=shipping_information_error" );
			
		}
	}
	
	private function process_logout( ){
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
		
		unset( $_SESSION['ec_shipping_first_name'] );
		unset( $_SESSION['ec_shipping_last_name'] );
		unset( $_SESSION['ec_shipping_address'] );
		unset( $_SESSION['ec_shipping_city'] );
		unset( $_SESSION['ec_shipping_state'] );
		unset( $_SESSION['ec_shipping_zip'] );
		unset( $_SESSION['ec_shipping_country'] );
		unset( $_SESSION['ec_shipping_phone'] );
		
		unset( $_SESSION['ec_use_shipping'] );
		unset( $_SESSION['ec_shipping_method'] );
		unset( $_SESSION['ec_expedited_shipping'] ); 
		
		if( isset( $_SESSION['ec_create_account'] ) ){
			unset( $_SESSION['ec_first_name'] );
			unset( $_SESSION['ec_last_name'] );
			unset( $_SESSION['ec_email'] );
			unset( $_SESSION['ec_password'] );
		}
		
		unset( $_SESSION['ec_create_account'] );
		unset( $_SESSION['ec_couponcode'] );
		unset( $_SESSION['ec_giftcard'] );
	
		header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=login" );
	}
	/* END FORM ACTION FUNCTIONS */
	
	private function send_new_password_email( $email, $new_password ){
		
		$user = $this->mysqli->get_user( $email, md5( $new_password ) );
		
		$email_logo_url = get_option( 'ec_option_email_logo' );
	 	
		// Get receipt
		ob_start();
        include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_retrieve_password_email.php' );
		$message = ob_get_contents();
		ob_end_clean();
		
		$headers = "From: " . get_option( 'ec_option_order_from_email' ) . "\r\n";
		$headers .= "Reply-To: " . get_option( 'ec_option_order_from_email' ) . "\r\n";
		$headers .= "X-Mailer: PHP4\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Return-Path: " . get_option( 'ec_option_order_from_email' ) . "\r\n"; 
		$headers .= "Content-type: text/html\r\n"; 
		
		if( get_option( 'ec_option_use_wp_mail' ) )
			wp_mail( $email, $GLOBALS['language']->get_text( "account_forgot_password_email", "account_forgot_password_email_title" ), $message, $headers);
		else
			mail( $email, $GLOBALS['language']->get_text( "account_forgot_password_email", "account_forgot_password_email_title" ), $message, $headers);
	}
	
	private function get_random_password( ){
		$rand_chars = array( "A", "B", "C", "D", "E", "F", "G", "H", "I", "J" );
		$rand_password = $rand_chars[ rand( 0, 9 ) ] . $rand_chars[ rand( 0, 9 ) ] . $rand_chars[ rand( 0, 9 ) ] . $rand_chars[ rand( 0, 9 ) ] . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 );
		return $rand_password;
	}
	
}

?>