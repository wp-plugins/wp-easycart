<?php

class ec_wpoptionset{
	
	public $wp_options = array();					// array of ec_wpoption structures
	
	private $wp_option_names = array();				// array of strings
	private $wp_option_defaults = array();			// array of strings
	private $wp_option_groups = array();			// array of strings
	
	function __construct(){
		
		$this->generate_wp_option_names_and_defaults();
		$this->generate_wp_options();
			
	}
	
	private function generate_wp_option_names_and_defaults(){
		
		//Store install page settinngs
		array_push($this->wp_option_names, 'ec_option_is_installed'); 						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-install-group');
		array_push($this->wp_option_names, 'ec_option_storepage'); 							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-install-group');
		array_push($this->wp_option_names, 'ec_option_cartpage'); 							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-install-group');
		array_push($this->wp_option_names, 'ec_option_accountpage');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-install-group');
		
		//Use this to track the db																					
		array_push($this->wp_option_names, 'ec_option_db_version');							array_push($this->wp_option_defaults, '1_23' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		array_push($this->wp_option_names, 'ec_option_show_lite_message');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		array_push($this->wp_option_names, 'ec_option_new_linking_setup');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		array_push($this->wp_option_names, 'ec_option_show_install_message');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		array_push($this->wp_option_names, 'ec_option_added_custom_post_type');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		array_push($this->wp_option_names, 'ec_option_hide_admin_notice');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		array_push($this->wp_option_names, 'ec_option_hide_design_help_video');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		
		//store basic setup settings
		array_push($this->wp_option_names, 'ec_option_weight');								array_push($this->wp_option_defaults, 'lbs' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_base_currency');						array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_currency');							array_push($this->wp_option_defaults, '$' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_currency_symbol_location');			array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_currency_negative_location');			array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_currency_decimal_symbol');			array_push($this->wp_option_defaults, '.' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_currency_decimal_places');			array_push($this->wp_option_defaults, '2' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');																					
		array_push($this->wp_option_names, 'ec_option_currency_thousands_seperator');		array_push($this->wp_option_defaults, ',' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_default_store_filter');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_default_payment_type');				array_push($this->wp_option_defaults, 'manual_bill' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_shipping_type');						array_push($this->wp_option_defaults, 'price' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_express_shipping_price');				array_push($this->wp_option_defaults, '9.99' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_reg_code');							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_order_from_email');					array_push($this->wp_option_defaults, 'youremail@url.com' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_password_from_email');				array_push($this->wp_option_defaults, 'youremail@url.com' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_bcc_email_addresses');				array_push($this->wp_option_defaults, 'youremail@url.com' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_state_dropdown');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_country_dropdown');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_estimate_shipping_country');			array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');																																												
		array_push($this->wp_option_names, 'ec_option_stylesheettype');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_googleanalyticsid');					array_push($this->wp_option_defaults, 'UA-XXXXXXX-X' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_rtl');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_allow_guest');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_shipping');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_user_order_notes');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_terms_link');							array_push($this->wp_option_defaults, 'http://yoursite.com/termsandconditions' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_privacy_link');						array_push($this->wp_option_defaults, 'http://yoursite.com/privacypolicy' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_email_type');							array_push($this->wp_option_defaults, 'mail' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_require_account_address');			array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_wp_mail');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_layout_type');				array_push($this->wp_option_defaults, 'grid_only' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_filter_1');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_filter_2');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_filter_3');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_filter_4');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_filter_5');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_filter_6');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_product_filter_7');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_show_giftcards');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_show_coupons');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_match_store_meta');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_old_linking_style');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_no_vat_on_shipping');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_display_as_catalog');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_addtocart_return_to_product');		array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_exchange_rates');						array_push($this->wp_option_defaults, 'EUR=.73,GBP=.6,JPY=101.9' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_require_email_validation');			array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_display_country_top');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_address2');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_smart_states');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_show_account_subscriptions_link');	array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_gift_card_shipping_allowed');			array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_collect_shipping_for_subscriptions');	array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_skip_cart_login');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_contact_name');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_collect_user_phone');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_enable_company_name');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_skip_shipping_page');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_skip_reivew_screen');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_require_terms_agreement');			array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_show_menu_cart_icon');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_cart_menu_id');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_amazon_key');							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_amazon_secret');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_amazon_bucket');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_deconetwork_url');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_deconetwork_password');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		
		// Payment Options
		array_push($this->wp_option_names, 'ec_option_use_direct_deposit');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_direct_deposit_message');				array_push($this->wp_option_defaults, 'You have selected a manual payment method.' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_affirm');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_affirm_public_key');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_affirm_private_key');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_affirm_financial_product');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_affirm_sandbox_account');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_visa');							array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_delta');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_uke');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_discover');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_mastercard');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_mcdebit');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_amex');							array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_jcb');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_diners');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_laser');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_maestro');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_process_method');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_third_party');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_authorize_login_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_authorize_trans_key');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_authorize_test_mode');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_authorize_developer_account');		array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_authorize_currency_code');			array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_braintree_merchant_id');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_braintree_public_key');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_braintree_private_key');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_braintree_currency');					array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_braintree_environment');				array_push($this->wp_option_defaults, 'sandbox' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypoint_merchant_id');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypoint_vpn_password');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypoint_test_mode');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_chronopay_currency');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_chronopay_product_id');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_chronopay_shared_secret');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_dwolla_thirdparty_key');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_dwolla_thirdparty_secret');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_dwolla_thirdparty_test_mode');		array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_dwolla_thirdparty_account_id');		array_push($this->wp_option_defaults, '812-xxx-xxxx' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_versapay_id');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_versapay_password');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_versapay_language');					array_push($this->wp_option_defaults, 'en' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_eway_customer_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_eway_test_mode');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_eway_test_mode_success');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdata_login_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdata_pem_file');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdata_host');						array_push($this->wp_option_defaults, 'secure.linkpt.net' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdata_port');						array_push($this->wp_option_defaults, '1129' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdata_test_mode');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdata_use_ssl_cert');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdatae4_exact_id');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdatae4_password');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdatae4_language');				array_push($this->wp_option_defaults, 'EN' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdatae4_currency');				array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_firstdatae4_test_mode');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');																				
		array_push($this->wp_option_names, 'ec_option_goemerchant_gateway_id');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_goemerchant_processor_id');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_goemerchant_trans_center_id');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_nets_merchant_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_nets_token');							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_nets_currency');						array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_nets_test_mode');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_moneris_ca_store_id');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_moneris_ca_api_token');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_moneris_ca_test_mode');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_username');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_password');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_currency');			array_push($this->wp_option_defaults, 'NZD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_thirdparty_username');array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_thirdparty_key');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_thirdparty_currency');array_push($this->wp_option_defaults, 'NZD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_use_sandbox');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_email');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_currency_code');				array_push($this->wp_option_defaults, 'usd' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_lc');							array_push($this->wp_option_defaults, 'en' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_weight_unit');					array_push($this->wp_option_defaults, 'lbs' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_collect_shipping');			array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_pro_test_mode');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_pro_vendor');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_pro_partner');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_pro_user');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_pro_password');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_pro_currency');				array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_payments_pro_test_mode');		array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_payments_pro_user');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_payments_pro_password');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_payments_pro_signature');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_paypal_payments_pro_currency');		array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_merchant_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_company_name');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_email');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_language');					array_push($this->wp_option_defaults, 'EN' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_thirdparty_merchant_id');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_thirdparty_secret');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_thirdparty_currency');			array_push($this->wp_option_defaults, 'GBP' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_merchant_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_secret');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_currency');					array_push($this->wp_option_defaults, 'GBP' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_3dsecure');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_minimum_tss_score');			array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_vendor');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_currency');					array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_simulator');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_testmode');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepayus_mid');						array_push($this->wp_option_defaults, '999999999997' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepayus_mkey');						array_push($this->wp_option_defaults, 'A1B2C3D4E5F6' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepayus_application_id');			array_push($this->wp_option_defaults, 'SAGETEST1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_securepay_merchant_id');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_securepay_password');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_securepay_currency');					array_push($this->wp_option_defaults, 'AUD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_securepay_test_mode');				array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_psigate_store_id');					array_push($this->wp_option_defaults, 'teststore' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_psigate_passphrase');					array_push($this->wp_option_defaults, 'psigate1234' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_psigate_test_mode');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_use_proxy');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_proxy_address');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_stripe_api_key');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_stripe_currency');					array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_virtualmerchant_ssl_merchant_id');	array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_virtualmerchant_ssl_user_id');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_virtualmerchant_ssl_pin');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_virtualmerchant_currency');			array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_virtualmerchant_demo_account');		array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		
		// Language Options																					
		array_push($this->wp_option_names, 'ec_option_language');							array_push($this->wp_option_defaults, 'en-us' );
																							array_push($this->wp_option_groups, 'ec-language-group');
		array_push($this->wp_option_names, 'ec_option_language_data');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-language-group');
		array_push($this->wp_option_names, 'ec_option_use_seperate_language_forms');		array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-language-group');
				
		// Base Design Options	
		array_push($this->wp_option_names, 'ec_option_base_theme');							array_push($this->wp_option_defaults, 'base-responsive-v3' );
																							array_push($this->wp_option_groups, 'ec-base-design-group');
		array_push($this->wp_option_names, 'ec_option_base_layout');						array_push($this->wp_option_defaults, 'base-responsive-v3' );
																							array_push($this->wp_option_groups, 'ec-base-design-group');
		array_push($this->wp_option_names, 'ec_option_caching_on');							array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-base-design-group');
		array_push($this->wp_option_names, 'ec_option_cache_update_period');				array_push($this->wp_option_defaults, '2' );
																							array_push($this->wp_option_groups, 'ec-base-design-group');
		array_push($this->wp_option_names, 'ec_option_cached_date');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-base-design-group');
		array_push($this->wp_option_names, 'ec_option_custom_css');							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-custom-css-design-group');
					
		// V2 Theme Options
		array_push($this->wp_option_names, 'ec_option_css_replacements');					array_push($this->wp_option_defaults, "main_color=#242424,second_color=#6b6b6b,third_color=#adadad,title_color=#0f0f0f,text_color=#141414,link_color=#242424,link_hover_color=#121212,sale_color=#900,backdrop_color=#333,content_bg=#FFF,error_text=#900,error_color=#F1D9D9,error_color2=#FF0606,success_text=#333,success_color=#E6FFE6,success_color2=#6FFF47"  );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_font_replacements');					array_push($this->wp_option_defaults, "title_font=Arial, Helvetica, sans-serif:::subtitle_font=Arial, Helvetica, sans-serif:::content_font=Arial, Helvetica, sans-serif" );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_responsive_sizes');					array_push($this->wp_option_defaults, "size_level1_high=479:::size_level2_low=480:::size_level2_high=767:::size_level3_low=768:::size_level3_high=960:::size_level4_low=961:::size_level4_high=1300:::size_level5_low=1301" );
																							
		// Theme Options
		array_push($this->wp_option_names, 'ec_option_details_main_color');					array_push($this->wp_option_defaults, '#222222' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_details_second_color');				array_push($this->wp_option_defaults, '#666666' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_use_dark_bg');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_default_product_type');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_product_image_hover_type');	array_push($this->wp_option_defaults, '3' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_product_image_effect_type');	array_push($this->wp_option_defaults, 'none' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_quick_view');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_default_desktop_columns');			array_push($this->wp_option_defaults, '3' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_desktop_image_height');		array_push($this->wp_option_defaults, '210px' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_default_laptop_columns');				array_push($this->wp_option_defaults, '3' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_laptop_image_height');		array_push($this->wp_option_defaults, '180px' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_default_tablet_wide_columns');		array_push($this->wp_option_defaults, '2' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_tablet_wide_image_height');	array_push($this->wp_option_defaults, '210px' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_default_tablet_columns');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_tablet_image_height');		array_push($this->wp_option_defaults, '225px' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_default_smartphone_columns');			array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_default_smartphone_image_height');	array_push($this->wp_option_defaults, '160px' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_details_columns_desktop');			array_push($this->wp_option_defaults, '2' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_details_columns_laptop');				array_push($this->wp_option_defaults, '2' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_details_columns_tablet_wide');		array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_details_columns_tablet');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_details_columns_smartphone');			array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
																							
		array_push($this->wp_option_names, 'ec_option_cart_columns_desktop');				array_push($this->wp_option_defaults, '2' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_cart_columns_laptop');				array_push($this->wp_option_defaults, '2' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_cart_columns_tablet_wide');			array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_cart_columns_tablet');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_cart_columns_smartphone');			array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		array_push($this->wp_option_names, 'ec_option_email_logo');							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		
		// Social Icons Options
		array_push($this->wp_option_names, 'ec_option_use_facebook_icon');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_twitter_icon');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_delicious_icon');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_myspace_icon');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_linkedin_icon');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_email_icon');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_digg_icon');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_googleplus_icon');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
		array_push($this->wp_option_names, 'ec_option_use_pinterest_icon');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-social-icons-group');
																							
		// Checklist Group																					
		array_push($this->wp_option_names, 'ec_option_checklist_state');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_currency');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_default_payment');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_guest');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_shipping_enabled');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_checkout_notes');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_billing_registration');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_google_analytics');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_manual_billing');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_third_party_complete');		array_push($this->wp_option_defaults, '' );	
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_third_party');				array_push($this->wp_option_defaults, '' );	
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_has_paypal');				array_push($this->wp_option_defaults, '' );	
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_has_skrill');				array_push($this->wp_option_defaults, '' );	
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_has_paymentexpress_thirdparty'); array_push($this->wp_option_defaults, '' );	
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_has_realex_thirdparty');	array_push($this->wp_option_defaults, '' );	
																							array_push($this->wp_option_groups, 'ec-checklist-group');																			
		array_push($this->wp_option_names, 'ec_option_checklist_credit_cart_complete');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_credit_card');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_credit_card_location');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_tax_complete');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_tax_choice');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_shipping_complete');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_shipping_choice');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_checklist_shipping_use_ups');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_checklist_shipping_use_usps');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_checklist_shipping_use_fedex');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_checklist_shipping_use_auspost');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_checklist_shipping_use_dhl');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_language_complete');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_theme_complete');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_colorization_complete');	array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_logo_added_complete');		array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_admin_embedded_complete');	array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_admin_consoles_complete');	array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');																					
		array_push($this->wp_option_names, 'ec_option_checklist_page');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-checklist-group');
																																												
		array_push($this->wp_option_names, 'ec_option_quickbooks_user');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-quickbooks-group');																					
		array_push($this->wp_option_names, 'ec_option_quickbooks_password');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-quickbooks-group');
		
	}
	
	private function generate_wp_options(){
		
		for($i=0; $i<count($this->wp_option_names); $i++){
			$item = new ec_wpoption($this->wp_option_names[$i], $this->wp_option_defaults[$i]);
			array_push($this->wp_options, $item);	
		}
		
	}
	
	public function add_options(){
		
		for($i=0; $i<count($this->wp_option_names); $i++){
			add_option($this->wp_options[$i]->wp_option_name, $this->wp_options[$i]->wp_option_default);
		}
		
	}
	
	public function update_options(){
		
		for($i=0; $i<count($this->wp_option_names); $i++){
			add_option($this->wp_options[$i]->wp_option_name, $this->wp_options[$i]->wp_option_default);
		}
		
	}
	
	public function register_options(){
		for($i=0; $i<count($this->wp_options); $i++){
			register_setting( $this->wp_option_groups[$i], $this->wp_options[$i]->wp_option_name);
		}
	}
	
	public function delete_options(){
		
		for($i=0; $i<count($this->wp_option_names); $i++){
			delete_option($this->wp_options[$i]->wp_option_name);
		}
		
	}
	
}

?>