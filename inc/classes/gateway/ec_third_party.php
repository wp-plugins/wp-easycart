<?php
class ec_third_party{
	
	protected $mysqli;													// ec_db structure
	
	protected $order_id;												// INT
	protected $order;													// ec_orderdisplay structure
	protected $order_details = array();											// array of ec_orderdetail structure
	
	protected $store_page;												// VARCHAR
	protected $cart_page;												// VARCHAR
	protected $account_page;											// VARCHAR
	protected $permalink_divider;										// CHAR
	
	function __construct( ){
		$this->mysqli = new ec_db( );
	}
	
	/****************************************
	* INITIALIZATION FUNCTIONS
	*****************************************/
	
	public function initialize( $order_id  ){
		
		$this->order_id = $order_id;
		$order_row = $this->mysqli->get_order_row( $this->order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
		
		if( $order_row ){
			$this->order = new ec_orderdisplay( $order_row );
		
			$order_details = $this->mysqli->get_order_details( $this->order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			
			if( $order_details ){
				foreach( $order_details as $order_detail )
					$this->order_details[] = new ec_orderdetail( $order_detail );
				
				$store_page_id = get_option('ec_option_storepage');
				$this->store_page = get_permalink( $store_page_id );
				
				$cart_page_id = get_option('ec_option_cartpage');
				$this->cart_page = get_permalink( $cart_page_id );
				
				$account_page_id = get_option('ec_option_accountpage');
				$this->account_page = get_permalink( $account_page_id );
				
				if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
				else														$this->permalink_divider = "?";
			}else{
				error_log( "no order details found on third-party checkout page." );
				return false;
			}
		}else{
			error_log( "no order found on third-party checkout page." );
			return false;
		}
	}
	
	/****************************************
	* CHANGING FUNCTIONS
	*****************************************/
	
	public function display_form_start( ){
		error_log( "display_form_start( ) must be overriden by a third_party-specific child." );
		return false;
	}
	
}
?>