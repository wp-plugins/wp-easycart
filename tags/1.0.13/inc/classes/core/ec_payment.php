<?php

class ec_payment{
	protected $mysqli;												// ec_db structure
	
	private $process_method;										// VARCHAR
	private $third_party_type;										// VARCHAR
	
	public $credit_card;											// ec_credit_card structure
	private $cart_page;
	private $account_page;
	private $permalink_divider;
	
	public $payment_type;
	
	function __construct( $credit_card, $payment_type ){
		$this->mysqli = new ec_db();
		
		if( $payment_type == "credit_card" )
			$this->payment_type = $credit_card->payment_method;
		else
			$this->payment_type = $payment_type;
		
		$this->proccess_method = get_option( 'ec_option_payment_process_method' );
		$this->third_party_type = get_option( 'ec_option_payment_third_party' );
		
		$this->credit_card = $credit_card;
		
		$this->third_party = $this->get_third_party( );
		
		$cart_page_id = get_option('ec_option_cartpage');
		$this->cart_page = get_permalink( $cart_page_id );
		
		$account_page_id = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $account_page_id );
		
		if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		$use_proxy = get_option( 'ec_option_use_proxy' );
		$proxy_address = get_option( 'ec_option_proxy_address' );
		
		if( $use_proxy )
		define('WP_PROXY_HOST', $proxy_address);
	}
	
	
	
	public function process_payment( $cart, $user, $shipping, $tax, $discount, $order_totals, $order_id ){
		
			 if($this->proccess_method == "authorize"		)			$gateway = new ec_authorize();
		else if($this->proccess_method == "paypal_pro"		)			$gateway = new ec_paypal_pro();
		else if($this->proccess_method == "chronopay"		)			$gateway = new ec_chronopay();
		else if($this->proccess_method == "eway"			)			$gateway = new ec_eway();
		else if($this->proccess_method == "paypoint"		)			$gateway = new ec_paypoint();
		else if($this->proccess_method == "paymentexpress"	)			$gateway = new ec_paymentexpress();
		else if($this->proccess_method == "firstdata"		)			$gateway = new ec_firstdata();
		else if($this->proccess_method == "realex"			)			$gateway = new ec_realex();
		else if($this->proccess_method == "sagepay"			)			$gateway = new ec_sagepay();
		else if($this->proccess_method == "psigate"			)			$gateway = new ec_psigate();
		else if($this->proccess_method == "securepay"		)			$gateway = new ec_securepay();
		else{
			error_log( "Setup error, no payment gateway selected." );
			return "Setup error, no payment gateway selected."; 
		}
		
		$gateway->initialize( $cart, $user, $shipping, $tax, $discount, $this->credit_card, $order_totals, $order_id );
		
		if( $gateway->process_credit_card( ) ){
			return "1";
		}else
			return $gateway->get_response_message( );
			
	}
	
	private function get_third_party( ){
			 if( $this->third_party_type == "paypal" )					return new ec_paypal( );
		else if( $this->third_party_type == "skrill" )					return new ec_skrill( );
	}
	
}

?>