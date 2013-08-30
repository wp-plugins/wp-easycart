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
		array_push($this->wp_option_names, 'ec_option_storepage'); 							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-install-group');
		array_push($this->wp_option_names, 'ec_option_cartpage'); 							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-install-group');
		array_push($this->wp_option_names, 'ec_option_accountpage');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-store-install-group');
		
		//Use this to track the db																					
		array_push($this->wp_option_names, 'ec_option_db_version');							array_push($this->wp_option_defaults, '1_1' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		array_push($this->wp_option_names, 'ec_option_show_lite_message');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-db-group');
		
		//store basic setup settings
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
		array_push($this->wp_option_names, 'ec_option_default_store_filter');				array_push($this->wp_option_defaults, '1' );
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
		array_push($this->wp_option_names, 'ec_option_use_state_dropdown');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_country_dropdown');				array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');																																												
		array_push($this->wp_option_names, 'ec_option_stylesheettype');						array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_googleanalyticsid');					array_push($this->wp_option_defaults, 'UA-XXXXXXX-X' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		array_push($this->wp_option_names, 'ec_option_use_rtl');							array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-store-setup-group');
		
		// Payment Options
		array_push($this->wp_option_names, 'ec_option_use_direct_deposit');					array_push($this->wp_option_defaults, '1' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_direct_deposit_message');				array_push($this->wp_option_defaults, 'You have selected a manual payment method.' );
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
		array_push($this->wp_option_names, 'ec_option_payment_express_username');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_password');			array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_payment_express_currency');			array_push($this->wp_option_defaults, '' );
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
		array_push($this->wp_option_names, 'ec_option_skrill_merchant_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_company_name');				array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_email');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_language');					array_push($this->wp_option_defaults, 'EN' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_skrill_currency_code');				array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_merchant_id');					array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_secret');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_account');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_realex_currency');					array_push($this->wp_option_defaults, 'GBP' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_vendor');						array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_currency');					array_push($this->wp_option_defaults, 'USD' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_simulator');					array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-payment-group');
		array_push($this->wp_option_names, 'ec_option_sagepay_testmode');					array_push($this->wp_option_defaults, '0' );
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
		
		// Language Options																					
		array_push($this->wp_option_names, 'ec_option_language');							array_push($this->wp_option_defaults, 'en-us' );
																							array_push($this->wp_option_groups, 'ec-language-group');
		array_push($this->wp_option_names, 'ec_option_language_data');						array_push($this->wp_option_defaults, '0' );
																							array_push($this->wp_option_groups, 'ec-language-group');
				
		// Base Design Options	
		array_push($this->wp_option_names, 'ec_option_base_theme');							array_push($this->wp_option_defaults, 'base-responsive-v1' );
																							array_push($this->wp_option_groups, 'ec-base-design-group');
		array_push($this->wp_option_names, 'ec_option_base_layout');						array_push($this->wp_option_defaults, 'base-responsive-v1' );
																							array_push($this->wp_option_groups, 'ec-base-design-group');
																							
		// Theme Options
		array_push($this->wp_option_names, 'ec_option_css_replacements');					array_push($this->wp_option_defaults, "main_color=#6e9e42,second_color=#9ecc8e,third_color=#d0ebca,title_color=#0f0f0f,text_color=#141414,link_color=#363636,link_hover_color=#348539,sale_color=#900,backdrop_color=#333,content_bg=#FFF,error_text=#900,error_color=#F1D9D9,error_color2=#FF0606,success_text=#333,success_color=#E6FFE6,success_color2=#6FFF47"  );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_font_replacements');					array_push($this->wp_option_defaults, "title_font=Arial, Helvetica, sans-serif:::subtitle_font=Arial, Helvetica, sans-serif:::content_font=Arial, Helvetica, sans-serif" );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_responsive_sizes');					array_push($this->wp_option_defaults, "size_level1_high=479:::size_level2_low=480:::size_level2_high=767:::size_level3_low=768:::size_level3_high=960:::size_level4_low=961:::size_level4_high=1300:::size_level5_low=1301" );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
		array_push($this->wp_option_names, 'ec_option_email_logo');							array_push($this->wp_option_defaults, '' );
																							array_push($this->wp_option_groups, 'ec-theme-options-group');
																							
		// Store Images Options
		array_push($this->wp_option_names, 'ec_option_xsmall_width');						array_push($this->wp_option_defaults, '50' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_xsmall_height');						array_push($this->wp_option_defaults, '50' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_small_width');						array_push($this->wp_option_defaults, '100' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_small_height');						array_push($this->wp_option_defaults, '100' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_medium_width');						array_push($this->wp_option_defaults, '175' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_medium_height');						array_push($this->wp_option_defaults, '175' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_large_width');						array_push($this->wp_option_defaults, '400' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_large_height');						array_push($this->wp_option_defaults, '400' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_swatch_small_width');					array_push($this->wp_option_defaults, '15' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_swatch_small_height');				array_push($this->wp_option_defaults, '15' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_swatch_large_width');					array_push($this->wp_option_defaults, '25' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		array_push($this->wp_option_names, 'ec_option_swatch_large_height');				array_push($this->wp_option_defaults, '25' );
																							array_push($this->wp_option_groups, 'ec-store-images-group');
		
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