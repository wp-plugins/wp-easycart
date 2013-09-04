<?php

class ec_orderdisplay{
	
	protected $mysqli;							// ec_db structure
	
	public $order_id; 							// INT
	public $order_date; 						// TIMESTAMP
	public $order_status; 						// VARCHAR 50
	public $order_weight; 						// FLOAT 9,2
	public $is_approved;						// BOOL
	
	public $sub_total;							// FLOAT 7,2
	public $shipping_total; 					// FLOAT 7,2
	public $tax_total; 							// FLOAT 7,2
	public $duty_total; 						// FLOAT 7,2
	public $vat_total; 							// FLOAT 7,2
	public $discount_total;						// FLOAT 7,2
	public $grand_total;  						// FLOAT 7,2
	
	public $promo_code;  						// VARCHAR 255
	public $giftcard_id;  						// VARCHAR 20
		
	public $use_expedited_shipping; 			// BOOL
	public $shipping_method;  					// VARCHAR 255
	public $shipping_carrier;  					// VARCHAR 64
	public $tracking_number;  					// VARCHAR 100
	
	public $user_email;  						// VARCHAR 255
	public $user_level;  						// VARCHAR 255
	
	public $billing_first_name;  				// VARCHAR 255
	public $billing_last_name;  				// VARCHAR 255
	public $billing_address_line_1; 			// VARCHAR 255 
	public $billing_address_line_2;  			// VARCHAR 255
	public $billing_city;  						// VARCHAR 255
	public $billing_state;  					// VARCHAR 255
	public $billing_zip;  						// VARCHAR 32
	public $billing_country; 					// VARCHAR 255 
	public $billing_phone;  					// VARCHAR 32
	
	public $shipping_first_name;  				// VARCHAR 255
	public $shipping_last_name;  				// VARCHAR 255
	public $shipping_address_line_1;  			// VARCHAR 255
	public $shipping_address_line_2;  			// VARCHAR 255
	public $shipping_city;  					// VARCHAR 255
	public $shipping_state;  					// VARCHAR 255
	public $shipping_zip;  						// VARCHAR 32
	public $shipping_country;  					// VARCHAR 255
	public $shipping_phone;  					// VARCHAR 32
	
	public $order_customer_notes;				// BLOB
	
	public $user;								// ec_user class
	
	public $payment_method; 					// VARCHAR 64
	
	public $paypal_email_id; 					// VARCHAR 255
	public $paypal_payer_id;					// VARCHAR 255
	
	public $orderdetails = array();				// array of ec_orderdetail items
	public $cart;
	
	private $account_page;						// VARCHAR
	private $permalink_divider;					// CHAR
	
	private $currency;							// ec_currency structure
	
	function __construct( $order_row, $is_order_details = false ){
		$this->mysqli = new ec_db( );
		
		$this->order_id = $order_row->order_id; 
		$this->order_date = $order_row->order_date; 
		$this->order_status = $order_row->order_status; 
		$this->order_weight = $order_row->order_weight; 
		$this->is_approved = $order_row->is_approved;
		
		$this->sub_total = $order_row->sub_total;
		$this->shipping_total = $order_row->shipping_total;
		$this->tax_total = $order_row->tax_total;
		$this->discount_total = $order_row->discount_total;
		$this->duty_total = $order_row->duty_total;
		$this->vat_total = $order_row->vat_total;
		$this->grand_total = $order_row->grand_total; 
		
		$this->promo_code = $order_row->promo_code; 
		$this->giftcard_id = $order_row->giftcard_id; 
		
		$this->use_expedited_shipping = $order_row->use_expedited_shipping; 
		$this->shipping_method = $order_row->shipping_method; 
		$this->shipping_carrier = $order_row->shipping_carrier; 
		$this->tracking_number = $order_row->tracking_number; 
		
		$this->user_email = $order_row->user_email; 
		$this->user_level = $order_row->user_level; 
		
		$this->billing_first_name = $order_row->billing_first_name; 
		$this->billing_last_name = $order_row->billing_last_name; 
		$this->billing_address_line_1 = $order_row->billing_address_line_1; 
		$this->billing_address_line_2 = $order_row->billing_address_line_2; 
		$this->billing_city = $order_row->billing_city; 
		$this->billing_state = $order_row->billing_state; 
		$this->billing_zip = $order_row->billing_zip; 
		$this->billing_country = $order_row->billing_country; 
		$this->billing_phone = $order_row->billing_phone; 
		
		$this->shipping_first_name = $order_row->shipping_first_name; 
		$this->shipping_last_name = $order_row->shipping_last_name; 
		$this->shipping_address_line_1 = $order_row->shipping_address_line_1; 
		$this->shipping_address_line_2 = $order_row->shipping_address_line_2; 
		$this->shipping_city = $order_row->shipping_city; 
		$this->shipping_state = $order_row->shipping_state; 
		$this->shipping_zip = $order_row->shipping_zip; 
		$this->shipping_country = $order_row->shipping_country; 
		$this->shipping_phone = $order_row->shipping_phone; 
		
		$this->order_customer_notes = $order_row->order_customer_notes;
		
		$this->user = new ec_user( $this->user_email );
		$this->user->setup_billing_info_data( $this->billing_first_name, $this->billing_last_name, $this->billing_address_line_1 , $this->billing_city, $this->billing_state, $this->billing_zip, $this->billing_country, $this->billing_phone );
		$this->user->setup_shipping_info_data( $this->shipping_first_name, $this->shipping_last_name, $this->shipping_address_line_1 , $this->shipping_city, $this->shipping_state, $this->shipping_zip, $this->shipping_country, $this->shipping_phone );
		
		$this->payment_method = $order_row->payment_method; 
		
		$this->paypal_email_id = $order_row->paypal_email_id; 
		$this->paypal_payer_id = $order_row->paypal_payer_id;
		
		if( $is_order_details ){
			$this->cart =(object) array('cart' => array( ) );
			if( isset( $_SESSION['ec_email'] ) )
				$result = $this->mysqli->get_order_details( $this->order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			else
				$result = $this->mysqli->get_order_details( $this->order_id, "guest", "guest" );
				
			foreach( $result as $item ){
				array_push( $this->cart->cart, (object) array( "unit_price"=>$item->unit_price, "total_price"=>$item->total_price, "title"=>$item->title, "quantity"=>$item->quantity, "optionitem1_name"=>$item->optionitem_name_1, "optionitem2_name"=>$item->optionitem_name_2, "optionitem3_name"=>$item->optionitem_name_3, "optionitem4_name"=>$item->optionitem_name_4, "optionitem5_name"=>$item->optionitem_name_5, "optionitem1_label"=>$item->optionitem_label_1, "optionitem2_label"=>$item->optionitem_label_2, "optionitem3_label"=>$item->optionitem_label_3, "optionitem4_label"=>$item->optionitem_label_4, "optionitem5_label"=>$item->optionitem_label_5, "optionitem1_price"=>$item->optionitem_price_1, "optionitem2_price"=>$item->optionitem_price_2, "optionitem3_price"=>$item->optionitem_price_3, "optionitem4_price"=>$item->optionitem_price_4, "optionitem5_price"=>$item->optionitem_price_5, "model_number"=>$item->model_number, "is_download"=>$item->is_download  ) );
				array_push( $this->orderdetails, new ec_orderdetail( $item ) );
				
			}
		}
		
		$accountpageid = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $accountpageid );
		
		if( substr_count( $this->account_page, '?' ) )				$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		$this->currency = new ec_currency( );
	}
	
	public function display_order_detail_product_list( ){
		
		for( $i=0; $i < count( $this->orderdetails ); $i++ ){
			$order_item = $this->orderdetails[$i];
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_order_details_item_display.php' );	
		}
	}
	
	public function display_sub_total( ){
		echo $this->currency->get_currency_display( $this->sub_total );
	}
	
	public function display_shipping_total( ){
		echo $this->currency->get_currency_display( $this->shipping_total );
	}
	
	public function display_tax_total( ){
		echo $this->currency->get_currency_display( $this->tax_total );
	}
	
	public function has_duty( ){
		if( $this->duty_total != "0" )
			return true;
		else
			return false;	
	}
	
	public function display_duty_total( ){
		echo $this->currency->get_currency_display( $this->duty_total );
	}
	
	public function has_vat( ){
		if( $this->vat_total != 0 )
			return true;
		else
			return false;	
	}
	
	public function display_vat_total( ){
		echo $this->currency->get_currency_display( $this->vat_total );
	}
	
	public function display_discount_total( ){
		echo $this->currency->get_currency_display( $this->discount_total );
	}
	
	public function display_grand_total( ){
		echo $this->currency->get_currency_display( $this->grand_total );
	}
	
	public function display_order_date( $date_format ){
		echo date( $date_format, strtotime( $this->order_date ) );	
	}
	
	public function display_order_id( ){
		echo $this->order_id; 
	}
	
	public function display_order_status( ){
		echo ucwords( strtolower( $this->order_status ) );	
	}
	
	public function display_order_shipping_method( ){
		echo $this->shipping_method;
	}
	
	public function display_order_promocode( ){
		echo $this->promo_code;
	}
	
	public function display_order_giftcard( ){
		echo $this->giftcard_id;	
	}
	
	public function has_tracking_number( ){
		if( $this->tracking_number )
			return true;
		else
			return false;
	}
	
	public function display_order_tracking_number( ){
		echo $this->tracking_number;
	}
	
	public function display_order_billing_first_name( ){
		echo $this->billing_first_name;
	}
	
	public function display_order_billing_last_name( ){
		echo $this->billing_last_name;
	}
	
	public function display_order_billing_address_line_1( ){
		echo $this->billing_address_line_1;
	}
	
	public function display_order_billing_city( ){
		echo $this->billing_city;
	}
	
	public function display_order_billing_state( ){
		echo $this->billing_state;
	}
	
	public function display_order_billing_zip( ){
		echo $this->billing_zip;
	}
	
	public function display_order_billing_country( ){
		echo $this->billing_country;
	}
	
	public function display_order_billing_phone( ){
		echo $this->billing_phone;
	}
	
	public function display_order_shipping_first_name( ){
		echo $this->shipping_first_name;
	}
	
	public function display_order_shipping_last_name( ){
		echo $this->shipping_last_name;
	}
	
	public function display_order_shipping_address_line_1( ){
		echo $this->shipping_address_line_1;
	}
	
	public function display_order_shipping_city( ){
		echo $this->shipping_city;
	}
	
	public function display_order_shipping_state( ){
		echo $this->shipping_state;
	}
	
	public function display_order_shipping_zip( ){
		echo $this->shipping_zip;
	}
	
	public function display_order_shipping_country( ){
		echo $this->shipping_country;
	}
	
	public function display_order_shipping_phone( ){
		echo $this->shipping_phone;
	}
	
	public function display_payment_method( ){
		echo $this->payment_method;
	}
	
	public function display_order_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&amp;order_id=". $this->order_id ."\">" . $link_text . "</a>";
	}
	
	public function send_email_receipt(){
		
		$total = $GLOBALS['currency']->get_currency_display( $this->grand_total );
		$subtotal = $GLOBALS['currency']->get_currency_display( $this->sub_total );
		$tax = $GLOBALS['currency']->get_currency_display( $this->tax_total );
		$vat = $GLOBALS['currency']->get_currency_display( $this->vat_total );
		$shipping = $GLOBALS['currency']->get_currency_display( $this->shipping_total );
		$vat_rate = number_format( $tax->vat_rate, 0, '', '' );
		$discount = $GLOBALS['currency']->get_currency_display( $this->discount_total );
		
		$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
	 	
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; boundary=\"PHP-mixed-{$sep}\"; charset=utf-8";
		$headers[] = "From: " . get_option( 'ec_option_order_from_email' );
		$headers[] = "Reply-To: " . get_option( 'ec_option_order_from_email' );
		$headers[] = "Subject: Order Confirmation - #" . $this->order_id;
		$headers[] = "X-Mailer: PHP/".phpversion();
		
		ob_start();
        include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_email_receipt.php';
        $message = ob_get_clean();
		
		mail( $this->user->email, $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $this->order_id, $message, implode("\r\n", $headers) );
		mail( get_option( 'ec_option_bcc_email_addresses' ), $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $this->order_id, $message, implode("\r\n", $headers) );
		
	}
	
}