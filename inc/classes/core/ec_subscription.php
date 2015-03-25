<?php

class ec_subscription{
	
	private $mysqli;									// ec_db object
	
	private $subscription_id;							// DB ID for Subscription
	private $user_id;									// USER ID connecting subscription to user
	private $title;										// title of the subscription
	private $created;									// date created in UNIX timestamp format
	private $amount;									// 12.00 format
	private $product_id;								// id of the product
	private $bill_length;								// length of bill cycle, e.g. 4
	private $bill_period;								// period type (D, W, M, Y)
	private $status;									// Active, Suspended, or Canceled
	private $last_billed;								// date in UNIX timestamp format
	private $next_payment;								// date in UNIX timestamp format
	private $card_type;									// credit card type used
	private $last4;										// last 4 digits of credit card
	
	private $is_details;								// Get more details if this is details
	private $stripe_subscription_id;					// ID of a Stripe Subscription
	
	public $upgrades;									// Array of possible upgrades
	public $past_payments;								// Array of past payments
	
	public $membership_page;							// VARCHAR link
	
	private $account_page;								// VARCHAR
	private $permalink_divider;							// CHAR
	
	function __construct( $subscription_row, $is_details = false ){
		
		$this->mysqli = new ec_db();
		$this->is_details = $is_details;
		
		$accountpageid = get_option('ec_option_accountpage');
		
		if( function_exists( 'icl_object_id' ) ){
			$accountpageid = icl_object_id( $accountpageid, 'page', true, ICL_LANGUAGE_CODE );
		}
		
		$this->account_page = get_permalink( $accountpageid );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->account_page = $https_class->makeUrlHttps( $this->account_page );
		}
		
		if( substr_count( $this->account_page, '?' ) )				$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		
		// Initialize data
		$this->set_db_vars( $subscription_row );
		$this->upgrades = $this->mysqli->get_subscription_upgrades( $this->subscription_id );
		$this->past_payments = $this->mysqli->get_subscription_payments( $this->subscription_id, $subscription_row->user_id );
		
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
	
	public function has_membership_page( ){
		if( $this->membership_page != "" ){
			return true;
		}else{
			return false;
		}
	}
	
	public function display_membership_page_link( $link_text ){
		echo "<a href=\"" . $this->membership_page . "\" class=\"ec_account_membership_page_link\">" . $link_text . "</a>";
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
		else
			include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_subscription_email_receipt.php';
			
        $message = ob_get_clean();
		
		$email_send_method = get_option( 'ec_option_use_wp_mail' );
		$email_send_method = apply_filters( 'wpeasycart_email_method', $email_send_method );
		
		if( $email_send_method == "1" ){
			wp_mail( $user->email, $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
			wp_mail( get_option( 'ec_option_bcc_email_addresses' ), $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
		
		}else if( $email_send_method == "0" ){
			mail( $user->email, $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
			mail( get_option( 'ec_option_bcc_email_addresses' ), $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message, implode("\r\n", $headers) );
			
		}else{
			do_action( 'wpeasycart_custom_subscription_order_email', get_option( 'ec_option_order_from_email' ), $user->email, get_option( 'ec_option_bcc_email_addresses' ), $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order->order_id, $message );
			
		}
		
	}
	
	public function print_receipt( $order, $order_details ){
		
		$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
	 	
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php' ) )	
			include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription_email_receipt.php';
		else if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_subscription_email_receipt.php' ) )
			include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_subscription_email_receipt.php';
		else{
			
		}
		
	}
	
	public function has_upgrades( ){
		
		if( count( $this->upgrades ) > 0 ){
			foreach( $this->upgrades as $upgrade ){
				if( $this->product_id == $upgrade->product_id ){
					return true;
				}
			}
		}
		
		echo "<input type=\"hidden\" name=\"ec_selected_plan\" value=\"" . $this->product_id . "\" />";
		
		return false;
		
	}
	
	public function display_upgrade_dropdown( ){
		
		$found_this = false;
		echo "<select name=\"ec_selected_plan\">";
		foreach( $this->upgrades as $upgrade ){
			if( $this->product_id == $upgrade->product_id ){
				$found_this = true;
			}
			
			if( $upgrade->can_downgrade || $found_this ){
				echo "<option value=\"" . $upgrade->product_id . "\"";
				if( $this->product_id == $upgrade->product_id ){
					echo " selected=\"selected\"";
				}
				echo ">" . $GLOBALS['language']->convert_text( $upgrade->title ) . " " . $GLOBALS['currency']->get_currency_display( $upgrade->price ) . $this->get_new_bill_period_formatted( $upgrade->subscription_bill_length, $upgrade->subscription_bill_period ) . "</option>";
			}
		}
		echo "</select>";
		
	}
	
	public function get_stripe_id( ){
		return $this->stripe_subscription_id;
	}
	
	public function display_past_payments( $date_format ){
		if( $this->past_payments ){
			foreach( $this->past_payments as $payment ){
				echo date( $date_format, strtotime( $payment->order_date ) ) . " | " . $GLOBALS['currency']->get_currency_display( $payment->grand_total ) . " | <a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&order_id=" . $payment->order_id . "\">View Order</a>";
			}
		}
	}
	
	public function display_cancel_form( $button_text, $confirm_text ){
		echo "<form method=\"POST\" action=\"" . $this->account_page . $this->permalink_divider . "ec_page=subscriptions\">";
		echo "<input type=\"hidden\" name=\"ec_account_subscription_id\" value=\"" . $this->subscription_id . "\">";
		echo "<input type=\"hidden\" name=\"ec_account_form_action\" value=\"cancel_subscription\">";
		echo "<input type=\"submit\" value=\"" . $button_text . "\" onclick=\"return ec_cancel_subscription_check( '" . $confirm_text . "' );\">";
		echo "</form>";
	}
	
	public function is_canceled( ){
		if( $this->status == "Canceled" ){
			return true;
		}else{
			return false;
		}
	}
	
	/////////////////////////////////////////////////////////
	//Help Functions
	/////////////////////////////////////////////////////////
	
	private function get_new_bill_period_formatted( $length, $period ){
		
		$ret_string = "/";
		
		if( $length > 1 ){
			$ret_string .= $length . " ";
		}
		
		if( $period == "D" ){
			$ret_string .= "day";
		}else if( $period == "W" ){
			$ret_string .= "week";
		}else if( $period == "M" ){
			$ret_string .= "month";
		}else if( $period == "Y" ){
			$ret_string .= "year";
		}
		
		if( $length > 1 ){
			$ret_string .= "s";
		}
		
		return $ret_string;
		
	}
	
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
		$this->user_id = $db_row->user_id;
		$this->title = $db_row->title;
		$this->amount = $db_row->price;
		$this->product_id = $db_row->product_id;
		$this->bill_length = $db_row->payment_length;
		$this->bill_period = $db_row->payment_period;
		$this->status = $db_row->subscription_status;
		$this->last_billed = $db_row->last_payment_date;
		$this->next_payment = $db_row->next_payment_date;
		if( isset( $db_row->credit_card_type ) )
			$this->card_type = $db_row->credit_card_type;
		else
			$this->card_type = "";
		if( isset( $db_row->credit_card_last4 ) )
			$this->last4 = $db_row->credit_card_last4;
		else
			$this->last4 = "";
		$this->stripe_subscription_id = $db_row->stripe_subscription_id;
		$this->membership_page = $db_row->membership_page;
		
	}
	
	////////////////////////////////////////////////////////////
	//
	// STRIPE FUNCTIONS
	//
	////////////////////////////////////////////////////////////
	
	private function set_stripe_vars( $subscription_row ){
		
		$this->stripe_subscription_id = $subscription_row->id;
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