<?php

class ec_orderlist{
	protected $mysqli;								// ec_db structure

	public $orders = array();						// array of ec_orderitem structures
	public $num_orders;								// INT
	
	private $user_id;								// INT
	
	function __construct( $user_id ){
		$this->mysqli = new ec_db();
		
		$this->user_id = $user_id;
		
		$this->get_orders( );
	}
	
	private function get_orders( ){
		if( isset( $_SESSION['ec_email'] ) && isset( $_SESSION['ec_password'] ) ){
			$result = $this->mysqli->get_order_list( $this->user_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			$this->num_orders = count($result);
		
			foreach( $result as $orderdata ){
				
				$order = new ec_orderdisplay( $orderdata );
				array_push( $this->orders, $order );
				
			}
		}
	}
	
	public function display_order_list( $days_limit = 0, $order_limit = 0 ){
		
		for( $i=0; $i < count( $this->orders ) && ($order_limit == 0 || $i < $order_limit); $i++ ){
			if( $days_limit == 0 || $this->date_within_range( $this->orders[$i]->order_date, $days_limit ) ){
				$order = $this->orders[$i];
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_account_order_line.php' );
			}
		}
		
	}
	
	private function date_within_range( $order_date, $limit ){
		$current_date = new DateTime();
		$order_date = strtotime( $order_date );
		$limit_date = strtotime( date_modify( $current_date, '-' . $limit . "day" )->format('Y-m-d H:i:s') );
		
		if( $order_date > $limit_date )				return true;
		else										return false;
	}
	
}

?>