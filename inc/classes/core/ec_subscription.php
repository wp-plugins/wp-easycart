<?php

class ec_subscription{
	
	private $mysqli;									// ec_db object
	
	private $subscription_id;							// DB ID OR Unique id relating the subscription to payment gateway
	private $title;										// title of the subscription
	private $created;									// date created in UNIX timestamp format
	private $amount;									// 12.00 format
	private $product_id;								// id of the product
	private $bill_length;								// length of bill cycle, e.g. 4
	private $bill_period;								// period type (D, W, M, Y)
	private $status;									// Active, Suspended, or Canceled
	private $last_billed;								// date in UNIX timestamp format
	private $next_payment;								// date in UNIX timestamp format
	
	private $account_page;						// VARCHAR
	private $permalink_divider;					// CHAR
	
	function __construct( $subscription_row ){
		
		$this->mysqli = new ec_db();
		
		$accountpageid = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $accountpageid );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->account_page = $https_class->getHttpsUrl( ) . substr( $this->account_page, strlen( get_option( 'home' ) ) );
		}
		
		if( substr_count( $this->account_page, '?' ) )				$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		
		// Initialize data
		$payment_procesor = get_option( 'ec_option_payment_process_method' );
		if( !is_object( $subscription_row ) ){
			$subscription_data = $this->mysqli->get_subscription_row( $subscription_row );
			$this->set_db_vars( $subscription_data );
		}else{
			if( $payment_procesor  == "stripe" )
				$this->set_stripe_vars( $subscription_row );
		}
	}
	
	//////////////////////////////////////////////////////////
	//Display Functions
	//////////////////////////////////////////////////////////
	
	public function display_title( ){
		echo $this->title;
	}
	
	public function display_next_bill_date( $format ){
		echo gmdate( $format, $this->next_payment );
	}
	
	public function display_last_bill_date( $format ){
		echo gmdate( $format, $this->last_billed );
	}
	
	public function display_price( ){
		echo $GLOBALS['currency']->get_currency_display( $this->amount ) . $this->get_bill_period_formatted( );
	}
	
	public function display_subscription_link( $text ){
		
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=subscription_details&subscription_id=" . $this->subscription_id. "\">" . $text . "</a>";
		
	}
	
	/////////////////////////////////////////////////////////
	// Funtionality Functions
	/////////////////////////////////////////////////////////
	public function send_email_receipt( $user, $order, $order_details ){
		
		$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
	 	
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; charset=utf-8";
		$headers[] = "From: " . get_option( 'ec_option_order_from_email' );
		$headers[] = "Reply-To: " . get_option( 'ec_option_order_from_email' );
		$headers[] = "X-Mailer: PHP/".phpversion();
		
		ob_start();
        if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php' ) )	
			include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php';
		else if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php' ) )
			include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php';
		else{
			
		}
			
        $message = ob_get_clean();
		
		if( get_option( 'ec_option_use_wp_mail' ) ){
			wp_mail( $user->email, $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
			wp_mail( get_option( 'ec_option_bcc_email_addresses' ), $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
		}else{
			mail( $user->email, $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
			mail( get_option( 'ec_option_bcc_email_addresses' ), $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
		}
		
	}
	
	public function print_receipt( $order, $order_details ){
		
		$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
	 	
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php' ) )	
			include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php';
		else if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php' ) )
			include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php';
		else{
			
		}
		
	}
	
	public function has_upgrades( ){
		
		return true;
		
	}
	
	public function display_upgrade_dropdown( ){
		
		echo "<select><option>Coming Soon</option></select>";
		
	}
	
	/////////////////////////////////////////////////////////
	//Help Functions
	/////////////////////////////////////////////////////////
	
	private function get_bill_period_formatted( ){
		
		$ret_string = "/";
		
		if( $this->bill_length > 1 ){
			$ret_string .= $this->bill_length . " ";
		}
		
		if( $this->bill_period == "D" ){
			$ret_string .= "day";
		}else if( $this->bill_period == "W" ){
			$ret_string .= "week";
		}else if( $this->bill_period == "M" ){
			$ret_string .= "month";
		}else if( $this->bill_period == "Y" ){
			$ret_string .= "year";
		}
		
		if( $this->bill_length > 1 ){
			$ret_string .= "s";
		}
		
		return $ret_string;
		
	}
	
	////////////////////////////////////////////////////////////
	//
	// MAIN DB FUNCTIONS
	//
	////////////////////////////////////////////////////////////
	
	private function set_db_vars( $db_row ){
		
		$this->subscription_id = $db_row->subscription_id;
		$this->title = $db_row->title;
		$this->amount = $db_row->price;
		$this->product_id = $db_row->product_id;
		$this->bill_length = $db_row->payment_length;
		$this->bill_period = $db_row->payment_period;
		$this->status = $db_row->subscription_status;
		$this->last_billed = $db_row->last_payment_date;
		$this->next_payment = $db_row->next_payment_date;
		
	}
	
	////////////////////////////////////////////////////////////
	//
	// STRIPE FUNCTIONS
	//
	////////////////////////////////////////////////////////////
	
	private function set_stripe_vars( $subscription_row ){
		
		$this->subscription_id = $subscription_row->id;
		$this->title = $subscription_row->plan->name;
		$this->created = $subscription_row->plan->created;
		$this->amount = $this->convert_from_cents( $subscription_row->plan->amount );
		$this->product_id = $subscription_row->plan->id;
		$this->bill_length = $subscription_row->plan->interval_count;
		$this->bill_period = $this->stripe_convert_bill_period( $subscription_row->plan->interval );
		$this->status = $this->stripe_convert_status( $subscription_row->status );
		$this->last_billed = $subscription_row->current_period_start;
		$this->next_payment = $subscription_row->current_period_end;
		
	}
	
	private function convert_from_cents( $price ){
		return ( $price / 100 );
	}
	
	private function stripe_convert_bill_period( $period ){
		
		if( $period == "day" )
			return "D";
		else if( $period == "week" )
			return "W";
		else if( $period == "month" )
			return "M";
		else if( $period == "year" )
			return "Y";
	
	}
	
	private function stripe_convert_status( $status ){
		
		if( $status == "active" )
			return "Active";
			
	}
	
}

?>