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
	
	public $subscription_option1;				// Option Item ID
	public $subscription_option2;				// Option Item ID
	public $subscription_option3;				// Option Item ID
	public $subscription_option4;				// Option Item ID
	public $subscription_option5;				// Option Item ID
	
	public $subscription_option1_name;			// Option Item Name
	public $subscription_option2_name;			// Option Item Name
	public $subscription_option3_name;			// Option Item Name
	public $subscription_option4_name;			// Option Item Name
	public $subscription_option5_name;			// Option Item Name
	
	public $subscription_option1_label;			// Option Item Label
	public $subscription_option2_label;			// Option Item Label
	public $subscription_option3_label;			// Option Item Label
	public $subscription_option4_label;			// Option Item Label
	public $subscription_option5_label;			// Option Item Label
	
	public $subscription_advanced_options;		// Array
	
	public $store_page;							// VARCHAR
	public $cart_page;							// VARCHAR
	public $account_page;						// VARCHAR
	public $permalink_divider;					// CHAR
	
	private $analytics;							// ec_googleanalytics class
	private $is_affirm;
	
	////////////////////////////////////////////////////////
	// CONSTUCTOR FUNCTION
	////////////////////////////////////////////////////////
	function __construct( $is_affirm = false ){
		
		$this->is_affirm = $is_affirm;
		
		$this->mysqli = new ec_db();
		
		$this->cart = new ec_cart( $_SESSION['ec_cart_id'] );
		
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
		
		// Shipping
		$this->shipping = new ec_shipping( $this->cart->shipping_subtotal, $this->cart->weight, $this->cart->shippable_total_items, 'RADIO', $this->user->freeshipping );
		// Tax (no VAT here)
		$sales_tax_discount = new ec_discount( $this->cart, $this->cart->subtotal, 0.00, $this->coupon_code, "", 0 );
		$this->tax = new ec_tax( $this->cart->subtotal, $this->cart->taxable_subtotal - $sales_tax_discount->coupon_discount, 0, $this->user->shipping->state, $this->user->shipping->country, $this->user->taxfree );
		// Duty (Based on Product Price) - already calculated in tax
		// Get Total Without VAT, used only breifly
		if( get_option( 'ec_option_no_vat_on_shipping' ) ){
			$total_without_vat_or_discount = $this->cart->subtotal + $this->tax->tax_total + $this->tax->duty_total;
		}else{
			$total_without_vat_or_discount = $this->cart->subtotal + $this->shipping->get_shipping_price( ) + $this->tax->tax_total + $this->tax->duty_total;
		}
		//If a discount used, and no vatable subtotal, we need to set to 0
		if( $total_without_vat_or_discount < 0 )
			$total_without_vat_or_discount = 0;
		// Discount for Coupon
		$this->discount = new ec_discount( $this->cart, $this->cart->subtotal, $this->shipping->get_shipping_price( ), $this->coupon_code, $this->gift_card, $total_without_vat_or_discount );
		// Amount to Apply VAT on
		$vatable_subtotal = $total_without_vat_or_discount - $this->discount->coupon_discount;
		// If for some reason this is less than zero, we should correct
		if( $vatable_subtotal < 0 )
			$vatable_subtotal = 0;
		// Get Tax Again For VAT
		$this->tax = new ec_tax( $this->cart->subtotal, $this->cart->taxable_subtotal - $sales_tax_discount->coupon_discount, $vatable_subtotal, $this->user->shipping->state, $this->user->shipping->country, $this->user->taxfree );
		// Discount for Gift Card
		$this->discount = new ec_discount( $this->cart, $this->cart->subtotal, $this->shipping->get_shipping_price( ), $this->coupon_code, $this->gift_card, $GLOBALS['currency']->get_number_only( $total_without_vat_or_discount ) + $GLOBALS['currency']->get_number_only( $this->tax->vat_total ) );
		// Order Totals
		$this->order_totals = new ec_order_totals( $this->cart, $this->user, $this->shipping, $this->tax, $this->discount );
		
		// Credit Card
		if( isset( $_POST['ec_cart_payment_type'] ) )
			$credit_card = new ec_credit_card( $_POST['ec_cart_payment_type'], $_POST['ec_card_holder_name'], $this->sanatize_card_number( $_POST['ec_card_number'] ), $_POST['ec_expiration_month'], $_POST['ec_expiration_year'], $_POST['ec_security_code'] );
		else if( isset( $_POST['ec_card_number'] ) )
			$credit_card = new ec_credit_card( $this->get_payment_type( $this->sanatize_card_number( $_POST['ec_card_number'] ) ), $_POST['ec_card_holder_name'],  $this->sanatize_card_number( $_POST['ec_card_number'] ), $_POST['ec_expiration_month'], $_POST['ec_expiration_year'], $_POST['ec_security_code'] );
		else
			$credit_card = new ec_credit_card( "", "", "", "", "", "" );
		
		// Payment
		if( isset( $_POST['ec_cart_payment_selection'] ) )
			$this->payment = new ec_payment( $credit_card, $_POST['ec_cart_payment_selection'] );
		else if( $is_affirm )
			$this->payment = new ec_payment( $credit_card, "affirm" );
		else
			$this->payment = new ec_payment( $credit_card, "" );
		
		// Order
		$this->order = new ec_order( $this->cart, $this->user, $this->shipping, $this->tax, $this->discount, $this->order_totals, $this->payment );
		
		$store_page_id = get_option('ec_option_storepage');
		$cart_page_id = get_option('ec_option_cartpage');
		$account_page_id = get_option('ec_option_accountpage');
		
		if( function_exists( 'icl_object_id' ) ){
			$store_page_id = icl_object_id( $store_page_id, 'page', true, ICL_LANGUAGE_CODE );
			$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
			$account_page_id = icl_object_id( $account_page_id, 'page', true, ICL_LANGUAGE_CODE );
		}
		
		$this->store_page = get_permalink( $store_page_id );
		$this->cart_page = get_permalink( $cart_page_id );
		$this->account_page = get_permalink( $account_page_id );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->store_page = $https_class->makeUrlHttps( $this->store_page );
			$this->cart_page = $https_class->makeUrlHttps( $this->cart_page );
			$this->account_page = $https_class->makeUrlHttps( $this->account_page );
		}
		
		if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		// Subscription Options
		$this->subscription_option1 = $this->subscription_option2 = $this->subscription_option3 = $this->subscription_option4 = $this->subscription_option5 = 0;
			
		if( isset( $_SESSION['ec_subscription_option1'] ) || isset( $_SESSION['ec_subscription_option2'] ) || isset( $_SESSION['ec_subscription_option3'] ) || isset( $_SESSION['ec_subscription_option4'] ) || isset( $_SESSION['ec_subscription_option5'] ) ){
			
			$optionitem_list = $this->mysqli->get_optionitem_list( );
			
			if( isset( $_SESSION['ec_subscription_option1'] ) ){
				$this->subscription_option1 = $_SESSION['ec_subscription_option1'];
			}
			
			if( isset( $_SESSION['ec_subscription_option2'] ) ){
				$this->subscription_option2 = $_SESSION['ec_subscription_option2'];
			}
			
			if( isset( $_SESSION['ec_subscription_option3'] ) ){
				$this->subscription_option3 = $_SESSION['ec_subscription_option3'];
			}
			
			if( isset( $_SESSION['ec_subscription_option4'] ) ){
				$this->subscription_option4 = $_SESSION['ec_subscription_option4'];
			}
			
			if( isset( $_SESSION['ec_subscription_option5'] ) ){
				$this->subscription_option5 = $_SESSION['ec_subscription_option5'];
			}
			
			foreach( $optionitem_list as $option_item ){
				if( $option_item->optionitem_id == $this->subscription_option1 ){
					$this->subscription_option1_name = $option_item->optionitem_name;
					$this->subscription_option1_label = $option_item->option_name;
				
				}else if( $option_item->optionitem_id == $this->subscription_option2 ){
					$this->subscription_option2_name = $option_item->optionitem_name;
					$this->subscription_option2_label = $option_item->option_name;
				
				}else if( $option_item->optionitem_id == $this->subscription_option3 ){
					$this->subscription_option3_name = $option_item->optionitem_name;
					$this->subscription_option3_label = $option_item->option_name;
				
				}else if( $option_item->optionitem_id == $this->subscription_option4 ){
					$this->subscription_option4_name = $option_item->optionitem_name;
					$this->subscription_option4_label = $option_item->option_name;
				
				}else if( $option_item->optionitem_id == $this->subscription_option5 ){
					$this->subscription_option5_name = $option_item->optionitem_name;
					$this->subscription_option5_label = $option_item->option_name;
				}
			}
			
		}
		
		// Subscription Advanced Options
		$this->subscription_advanced_options = array( );
		$i=0;
		while( isset( $_SESSION['ec_subscription_advanced_option' . $i] ) ){
			$this->subscription_advanced_options[] = $_SESSION['ec_subscription_advanced_option' . $i];
			$i++;
		}
		
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
							  "manualbill_failed" => $GLOBALS['language']->get_text( "ec_errors", "manualbill_failed" ),
							  "thirdparty_failed" => $GLOBALS['language']->get_text( "ec_errors", "thirdparty_failed" ),
							  "payment_failed" => $GLOBALS['language']->get_text( "ec_errors", "payment_failed" ),
							  "card_error" => $GLOBALS['language']->get_text( "ec_errors", "payment_failed" ),
							  "already_subscribed" => $GLOBALS['language']->get_text( "ec_errors", "already_subscribed" ),
							  "not_activated" => $GLOBALS['language']->get_text( "ec_errors", "not_activated" ),
							  "subscription_not_found" => $GLOBALS['language']->get_text( "ec_errors", "subscription_not_found" ),
							  "user_insert_error" => $GLOBALS['language']->get_text( "ec_errors", "user_insert_error" ),
							  "subscription_added_failed" => $GLOBALS['language']->get_text( "ec_errors", "subscription_added_failed" ),
							  "subscription_failed" => $GLOBALS['language']->get_text( "ec_errors", "subscription_failed" ),
							  "invalid_address" => $GLOBALS['language']->get_text( "ec_errors", "invalid_address" )  
							);
		if( isset( $_GET['ec_cart_error'] ) ){
			echo "<div class=\"ec_cart_error\"><div>" . $error_notes[ $_GET['ec_cart_error'] ] . "</div></div>";
		}
	}
	
	public function display_cart_page(){
		
		if( get_option( 'ec_option_googleanalyticsid' ) != "UA-XXXXXXX-X" && get_option( 'ec_option_googleanalyticsid' ) != "" ){
			echo "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			ga('create', '" . get_option( 'ec_option_googleanalyticsid' ) . "', 'auto');
			ga('send', 'pageview');
			ga('require', 'ec');
			
			function ec_google_removeFromCart( model_number, title, quantity, price ){
			  ga('ec:addProduct', {
				'id': model_number,
				'name': title,
				'price': price,
				'quantity': quantity
			  });
			  ga('ec:setAction', 'remove');
			  ga('send', 'event', 'UX', 'click', 'remove from cart');     // Send data using an event.
			}";
			
			// Setup Cart
			for( $i=0; $i < count( $this->cart->cart ); $i++ ){
				echo "
				ga( 'ec:addProduct', {
				  'id': '" . $this->cart->cart[$i]->model_number . "',
				  'name': '" . $this->cart->cart[$i]->title . "',
				  'price': '" . $this->cart->cart[$i]->unit_price . "',
				  'quantity': '" . $this->cart->cart[$i]->quantity . "'
				});";
			}
			
			// View of Cart
			if( !isset( $_GET['ec_page'] )  ){
				echo "
				ga('ec:setAction','checkout', {
					'step': 1,
					'option': 'Cart View'
				});
				ga('send', 'pageview');";
			
			// View of Checkout Info
			}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_info" ){
				echo "
				ga('ec:setAction','checkout', {
					'step': 2,
					'option': 'Checkout Info'
				});
				ga('send', 'pageview');";
			
			// View of Payment Method
			}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_payment" ){
				echo "
				ga('ec:setAction','checkout', {
					'step': 3,
					'option': 'Checkout Payment'
				});
				ga('send', 'pageview');";
			
			}
			
			echo "</script>";
		}
		
		echo "<div class=\"ec_cart_page\">";
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			$order_id = $_GET['order_id'];
			if( isset( $_SESSION['ec_is_guest'] ) && $_SESSION['ec_is_guest'] ){
				// Get Guest Order
				$order_row = $this->mysqli->get_guest_order_row( $order_id, $_SESSION['ec_guest_key'] );
			}else{
				$order_row = $this->mysqli->get_order_row( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			}
			$order = new ec_orderdisplay( $order_row );
			
			if( isset( $_SESSION['ec_email'] ) && isset( $_SESSION['ec_password'] ) ){
				$order_details = $this->mysqli->get_order_details( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
			}else{
				$order_details = $this->mysqli->get_guest_order_details( $order_id, $_SESSION['ec_guest_key'] );
			}
			
			$this->user->setup_billing_info_data( $order->billing_first_name, $order->billing_last_name, $order->billing_address_line_1, $order->billing_address_line_2, $order->billing_city, $order->billing_state, $order->billing_country, $order->billing_zip, $order->billing_phone, $order->billing_company_name );
			
			$this->user->setup_shipping_info_data( $order->shipping_first_name, $order->shipping_last_name, $order->shipping_address_line_1, $order->shipping_address_line_2, $order->shipping_city, $order->shipping_state, $order->shipping_country, $order->shipping_zip, $order->shipping_phone, $order->shipping_company_name );
			
			$tax_struct = new ec_tax( 0,0,0, "", "");
			
			$total = $GLOBALS['currency']->get_currency_display( $order->grand_total );
			$subtotal = $GLOBALS['currency']->get_currency_display( $order->sub_total );
			$tax = $GLOBALS['currency']->get_currency_display( $order->tax_total );
			$duty = $GLOBALS['currency']->get_currency_display( $order->duty_total );
			$vat = $GLOBALS['currency']->get_currency_display( $order->vat_total );
			if( ( $order->grand_total - $order->vat_total ) > 0 )
				$vat_rate = number_format( $this->tax->vat_rate, 0, '', '' );
			else
				$vat_rate = number_format( 0, 0, '', '' );
			$shipping = $GLOBALS['currency']->get_currency_display( $order->shipping_total );
			$discount = $GLOBALS['currency']->get_currency_display( $order->discount_total );
			
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emaillogo.jpg" ) ){
				$email_logo_url = plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emaillogo.jpg");
				$email_footer_url = plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emailfooter.jpg");
			}else{
				$email_logo_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emaillogo.jpg");
				$email_footer_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emailfooter.jpg");
			}
			
			//google analytics
			$this->analytics = new ec_googleanalytics($order_details, $order->shipping_total, $order->tax_total , $order->grand_total, $order_id);
			$google_urchin_code = get_option('ec_option_googleanalyticsid');
			$google_wp_url = $_SERVER['SERVER_NAME'];
			$google_transaction = $this->analytics->get_transaction_js();
			$google_items = $this->analytics->get_item_js();
			//end google analytics
			$this->display_cart_error();
			
			//Backwards compatibility for an error... Don't want the button showing if user didn't create an account.
			if( isset( $_SESSION['ec_password'] ) && $_SESSION['ec_password'] == "guest" )
				$_SESSION['ec_email'] = "guest";
			
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_success.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_success.php' );
			else
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
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_third_party.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_third_party.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_third_party.php' );
			
		}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "subscription_info" ){
			
			$this->display_cart_error( );
			
			$subscription_found = false;
			
			if( isset( $_GET['subscription'] ) ){
				
				global $wpdb;
				$model_number = $_GET['subscription'];
				$products = $this->mysqli->get_product_list( $wpdb->prepare( " WHERE product.model_number = %s", $model_number ), "", "", "" );
				if( count( $products ) > 0 ){
					$subscription_found = true;
					$product = new ec_product( $products[0], 0, 1, 0 );
					
					// Subscription
					if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription.php' ) )	
						include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription.php' );
					else
						include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription.php' );
				}
				
			}
			
			if( !$subscription_found ){
				echo "No subscription was found to match the model number provided.";
			}
				
		}else{
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_page.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_page.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_page.php' );
		}
		echo "</div>";
	}
	
	public function display_cart_process( ){
		if(	$this->cart->total_items > 0 || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ) ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_process.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_process.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_process.php' );
		}
	}
	
	public function display_cart_process_cart_link( $link_text ){
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			echo $link_text;
		}else{
			echo "<a href=\"" . $this->cart_page . "\" class=\"ec_process_bar_link\">" . $link_text . "</a>";
		}
	}
	
	public function display_cart_process_shipping_link( $link_text ){
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			echo $link_text;
		}else{
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info\" class=\"ec_process_bar_link\">" . $link_text . "</a>";
		}
	}
	
	public function display_cart_process_review_link( $link_text ){
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			echo $link_text;
		}else if( isset( $_SESSION['ec_billing_first_name'] ) ){
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" class=\"ec_process_bar_link\">" . $link_text . "</a>";
		}else{
			echo $link_text;
		}
	}
	
	public function display_cart( $empty_cart_string ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart.php' );
			
			echo "<input type=\"hidden\" name=\"ec_cart_page\" id=\"ec_cart_page\" value=\"" . $this->cart_page . "\" />";
			echo "<input type=\"hidden\" name=\"ec_cart_base_path\" id=\"ec_cart_base_path\" value=\"" . plugins_url( ) . "\" />";
		}else
			echo $empty_cart_string;
	}
	
	public function display_login(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login.php' );
		}
	}
	
	public function display_login_complete(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' );
		}
	}
	
	public function display_subscription_login_complete( ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' ) )	
			include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' );
		else if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' );
	}
	
	public function should_display_cart( ){
		if( !$this->should_display_login( ) )
			return true;
		else
			return false;
	}
	
	public function should_display_login( ){
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_login" && ( !isset( $_SESSION['ec_email'] ) || $_SESSION['ec_email'] == "" || $_SESSION['ec_email'] == "guest" ) );
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
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_info" );
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
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_submit_order\" method=\"post\" id=\"ec_submit_order_form\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"submit_order\" />";
	}
	
	public function display_page_three_form_end(){
		echo "</form>";
	}
	
	public function display_subscription_form_start( $model_number ){
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_submit_order\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"insert_subscription\" />";
		echo "<input type=\"hidden\" name=\"ec_cart_model_number\" value=\"" . $model_number . "\" />";
	}
	
	public function display_subscription_form_end(){
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
		return ( ( $this->shipping->shipping_method == "live" ) && $this->cart->weight > 0 && ( !isset( $_GET['ec_page'] ) || !isset( $_SESSION['ec_email'] ) ) );
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
	
	public function display_shipping_costs_input( $label, $button_text, $label2 = 'Country:', $select_label = 'Select One' ){
		
		if( get_option( 'ec_option_estimate_shipping_country' ) ){
			if( isset( $_SESSION['ec_temp_country'] ) )
				$selected_country = $_SESSION['ec_temp_country'];
			else
				$selected_country = "0";
			
			$countries = $this->mysqli->get_countries( );
			
			echo "<div class=\"ec_estimate_shipping_country\"><span>" . $label2 . "</span><select name=\"ec_cart_country\" id=\"ec_cart_country\">";
			echo "<option value=\"0\"";
			if( $selected_country == "0" )
				echo " selected=\"selected\"";
			echo ">" . $select_label . "</option>";
			foreach( $countries as $country ){
				echo "<option value=\"" . $country->iso2_cnt . "\"";
				if( $country->iso2_cnt == $selected_country )
					echo " selected=\"selected\"";
				echo ">" . $country->name_cnt . "</option>";
			}
			echo "</select></div>";
		}else{
			echo "<input type=\"hidden\" name=\"ec_cart_country\" id=\"ec_cart_country\" value=\"0\" />";
		}
		echo "<div class=\"ec_estimate_shipping_zip\"><span>" . $label . "</span><input type=\"text\" name=\"ec_cart_zip_code\" id=\"ec_cart_zip_code\" value=\"";
		if( isset( $_SESSION['ec_temp_zipcode'] ) )
			echo $_SESSION['ec_temp_zipcode'];
		echo "\" /><a href=\"#\" onclick=\"return ec_estimate_shipping_click();\">" . $button_text . "</a></div>";
	}
	
	public function display_estimate_shipping_country_select( ){
		if( isset( $_SESSION['ec_temp_country'] ) )		$selected_country = $_SESSION['ec_temp_country'];
		else											$selected_country = "0";
			
		$countries = $this->mysqli->get_countries( );
		
		echo "<select name=\"ec_estimate_country\" id=\"ec_estimate_country\">";
		echo "<option value=\"0\""; if( $selected_country == "0" ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_select_one' ) . "</option>";
		foreach( $countries as $country ){
			echo "<option value=\"" . $country->iso2_cnt . "\"";
			if( $country->iso2_cnt == $selected_country )
				echo " selected=\"selected\"";
			echo ">" . $country->name_cnt . "</option>";
		}
		echo "</select>";
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
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) )	
			echo "<div class=\"ec_estimate_shipping_loader\" id=\"ec_estimate_shipping_loader\"><img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";	
		else
			echo "<div class=\"ec_estimate_shipping_loader\" id=\"ec_estimate_shipping_loader\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
	}
	
	public function display_subtotal( ){
		echo "<span id=\"ec_cart_subtotal\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->sub_total ) . "</span>";	
	}
	
	public function get_subtotal( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->sub_total );
	}
	
	public function display_tax_total( ){
		echo "<span id=\"ec_cart_tax\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->tax_total ) . "</span>";	
	}
	
	public function get_tax_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->tax_total );	
	}
	
	public function has_duty( ){
		if ( $this->tax->duty_total > 0 )			return true;
		else										return false;	
	}
	
	public function display_duty_total( ){
		echo "<span id=\"ec_cart_duty\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->duty_total ) . "</span>";	
	}
	
	public function get_duty_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->duty_total );	
	}
	
	public function get_vat_total( ){
		return $this->tax->vat_total;
	}
	
	public function get_vat_total_formatted( ){
		return $GLOBALS['currency']->get_currency_display( $this->tax->vat_total );
	}
	
	public function display_vat_total( ){
		echo "<span id=\"ec_cart_vat\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->vat_total ) . "</span>";	
	}
	
	public function display_shipping_total( ){
		echo "<span id=\"ec_cart_shipping\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->shipping_total ) . "</span>";
	}
	
	public function get_shipping_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->shipping_total );
	}
	
	public function display_discount_total( ){
		echo "<span id=\"ec_cart_discount\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->discount_total ) . "</span>";
	}
	
	public function get_discount_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->discount_total );
	}
	
	public function display_grand_total( ){
		echo "<span id=\"ec_cart_grandtotal\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->grand_total ) . "</span>"; 	
	}
	
	public function get_grand_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->grand_total ); 	
	}
	
	public function display_continue_shopping_button( $button_text ){
		echo "<a href=\"" . $this->store_page;
		
		echo "\" class=\"ec_cart_continue_shopping_link\">" . $button_text . "</a>";
	}
	
	public function display_checkout_button( $button_text ){
		$checkout_page = "checkout_login";
		if( isset( $_SESSION['ec_email'] ) ){
			$checkout_page = "checkout_info";
			
		}else if( get_option( 'ec_option_skip_cart_login' ) ){
			$checkout_page = "checkout_info";
			$_SESSION['ec_email'] = "guest";
			$_SESSION['ec_username'] = "guest";
			$_SESSION['ec_password'] = "guest";
		}
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) )
			echo "<a href=\"" . $this->cart_page . "\" class=\"ec_cart_checkout_link\">" . $button_text . "</a>";
		else
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
	
	public function display_cart_login_form_start_subscription( ){
		echo "<form action=\"". $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_GET['subscription'] . "\" method=\"post\">";
	}
	
	public function display_cart_login_form_end(){
		if( isset( $_GET['subscription'] ) ){
			echo "<input type=\"hidden\" name=\"ec_cart_subscription\" value=\"" . $_GET['subscription'] . "\" />";
		}
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"login_user\" />";
		echo "</form>";
	}
	
	public function display_cart_login_form_guest_start(){
		echo "<form action=\"". $this->cart_page . "\" method=\"post\">";
	}
	
	public function display_cart_login_form_guest_end(){
		if( isset( $_GET['subscription'] ) ){
			echo "<input type=\"hidden\" name=\"ec_cart_subscription\" value=\"" . $_GET['subscription'] . "\" />";
		}
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
		if( isset( $_GET['subscription'] ) ){
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_cart_action=logout&subscription=" . $_GET['subscription'] . "\" class=\"ec_cart_login_complete_logout_link\">" . $input . "</a>";
		}else{
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_cart_action=logout\" class=\"ec_cart_login_complete_logout_link\">" . $input . "</a>";
		}
	}
	
	/* END LOGIN/LOGOUT FUNCTIONS */
	
	/* START BILLING FUNCTIONS */
	public function display_checkout_details( ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_checkout_details.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_checkout_details.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_checkout_details.php' );
		}
	}
	
	public function display_billing(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_billing.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_billing.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_billing.php' );
		}
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
			
			if( get_option( 'ec_option_use_smart_states' ) ){
			
				// DISPLAY STATE DROP DOWN MENU
				$states = $this->mysqli->get_states( );
				if( isset( $_SESSION['ec_billing_state'] ) )
					$selected_state = $_SESSION['ec_billing_state'];
				else
					$selected_state = $this->user->billing->get_value( "state" );
					
				if( isset( $_SESSION['ec_billing_country'] ) )
						$selected_country = $_SESSION['ec_billing_country'];
					else
						$selected_country = $this->user->billing->get_value( "country2" );
				
				$current_country = "";
				$close_last_state = false;
				$state_found = false;
				$current_state_group = "";
				$close_last_state_group = false;
				
				foreach($states as $state){
					if( $current_country != $state->iso2_cnt ){
						if( $close_last_state ){
							echo "</select>";
						}
						echo "<select name=\"ec_cart_billing_state_" . $state->iso2_cnt . "\" id=\"ec_cart_billing_state_" . $state->iso2_cnt . "\" class=\"ec_cart_billing_input_text ec_billing_state_dropdown\"";
						if( $state->iso2_cnt != $selected_country ){
							echo " style=\"display:none;\"";
						}else{
							$state_found = true;
						}
						echo ">";
						
						if( $state->iso2_cnt == "CA" ){ // Canada
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_province" ) . "</option>";
						}else if( $state->iso2_cnt == "GB" ){ // United Kingdom
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_county" ) . "</option>";
						}else if( $state->iso2_cnt == "US" ){ //USA 
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_state" ) . "</option>";
						}else{
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_other" ) . "</option>";
						}
						
						$current_country = $state->iso2_cnt;
						$close_last_state = true;
					}
					
					if( $current_state_group != $state->group_sta && $state->group_sta != "" ){
						if( $close_last_state_group ){
							echo "</optgroup>";
						}
						echo "<optgroup label=\"" . $state->group_sta . "\">";
						$current_state_group = $state->group_sta;
						$close_last_state_group = true;
					}
					
					echo "<option value=\"" . $state->code_sta . "\"";
					if( $state->code_sta == $selected_state )
						echo " selected=\"selected\"";
					echo ">" . $state->name_sta . "</option>";
				}
				
				if( $close_last_state_group ){
					echo "</optgroup>";
				}
				
				echo "</select>";
				
				// DISPLAY STATE TEXT INPUT	
				echo "<input type=\"text\" name=\"ec_cart_billing_state\" id=\"ec_cart_billing_state\" class=\"ec_cart_billing_input_text\" value=\"" . $selected_state . "\"";
				if( $state_found ){
					echo " style=\"display:none;\"";
				}
				echo " />";
				
			}else{
				// Use the basic method of old
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
			}// Close if/else for state display type
			
		}else{
		
			$value = $this->user->billing->get_value( $name );
			
			echo "<input type=\"text\" name=\"ec_cart_billing_" . $name . "\" id=\"ec_cart_billing_" . $name . "\" class=\"ec_cart_billing_input_text\" value=\"" . $value . "\" />";
			
		}
	}
	/* END BILLING FUNCTIONS */
	
	/* START SHIPPING FUNCTIONS */
	public function display_shipping(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping.php' );
		}
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
			
			if( get_option( 'ec_option_use_smart_states' ) ){ // Use new method
				// DISPLAY STATE DROP DOWN MENU
				$states = $this->mysqli->get_states( );
				if( isset( $_SESSION['ec_shipping_state'] ) )
					$selected_state = $_SESSION['ec_shipping_state'];
				else
					$selected_state = $this->user->shipping->get_value( "state" );
					
				if( isset( $_SESSION['ec_shipping_country'] ) )
						$selected_country = $_SESSION['ec_shipping_country'];
					else
						$selected_country = $this->user->shipping->get_value( "country2" );
				
				$current_country = "";
				$close_last_state = false;
				$state_found = false;
				$current_state_group = "";
				$close_last_state_group = false;
				
				foreach($states as $state){
					if( $current_country != $state->iso2_cnt ){
						if( $close_last_state ){
							echo "</select>";
						}
						echo "<select name=\"ec_cart_shipping_state_" . $state->iso2_cnt . "\" id=\"ec_cart_shipping_state_" . $state->iso2_cnt . "\" class=\"ec_cart_shipping_input_text ec_shipping_state_dropdown\"";
						if( $state->iso2_cnt != $selected_country ){
							echo " style=\"display:none;\"";
						}else{
							$state_found = true;
						}
						echo ">";
						
						if( $state->iso2_cnt == "CA" ){ // Canada
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_province" ) . "</option>";
						}else if( $state->iso2_cnt == "GB" ){ // United Kingdom
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_county" ) . "</option>";
						}else if( $state->iso2_cnt == "US" ){ //USA 
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_state" ) . "</option>";
						}else{
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_other" ) . "</option>";
						}
						
						$current_country = $state->iso2_cnt;
						$close_last_state = true;
					}
					
					if( $current_state_group != $state->group_sta && $state->group_sta != "" ){
						if( $close_last_state_group ){
							echo "</optgroup>";
						}
						echo "<optgroup label=\"" . $state->group_sta . "\">";
						$current_state_group = $state->group_sta;
						$close_last_state_group = true;
					}
					
					echo "<option value=\"" . $state->code_sta . "\"";
					if( $state->code_sta == $selected_state )
						echo " selected=\"selected\"";
					echo ">" . $state->name_sta . "</option>";
				}
				
				if( $close_last_state_group ){
					echo "</optgroup>";
				}
				
				echo "</select>";
				
				// DISPLAY STATE TEXT INPUT	
				echo "<input type=\"text\" name=\"ec_cart_shipping_state\" id=\"ec_cart_shipping_state\" class=\"ec_cart_shipping_input_text\" value=\"" . $selected_state . "\"";
				if( $state_found ){
					echo " style=\"display:none;\"";
				}
				echo " />";
				
			}else{// Use old method
				
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
				
			}// Close if/else for state display type
			
		}else{
			$value = $this->user->shipping->get_value( $name );
			
			echo "<input type=\"text\" name=\"ec_cart_shipping_" . $name . "\" id=\"ec_cart_shipping_" . $name . "\" class=\"ec_cart_shipping_input_text\" value=\"" . $value . "\" />";
		}
	}
	/* END SHIPPING FUNCTIONS */
	
	/* START SHIPPING METHOD FUNCTIONS */
	public function display_shipping_method( ){
		if(	$this->cart->total_items > 0 ){
			echo "<input type=\"hidden\" id=\"ec_cart_zip_code\" value=\"" . $this->user->shipping->zip . "\" />";
			echo "<input type=\"hidden\" id=\"ec_cart_country\" value=\"" . $this->user->shipping->country . "\" />";
			echo "<input type=\"hidden\" id=\"ec_cart_shipping\" value=\"\" />";
			echo "<input type=\"hidden\" id=\"ec_cart_grandtotal\" value=\"\" />";
			
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping_method.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping_method.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping_method.php' );
		}
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
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_coupon.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_coupon.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_coupon.php' );
		}
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
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) )	
			echo "<div class=\"ec_cart_coupon_loader\" id=\"ec_cart_coupon_loader\"><img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";	
		else
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
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_gift_card.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_gift_card.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_gift_card.php' );
		}
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
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) )	
			echo "<div class=\"ec_cart_gift_card_loader\" id=\"ec_cart_gift_card_loader\"><img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
		else
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
		
		if( isset( $_GET['subscription'] ) ){
			echo "<input type=\"submit\" id=\"ec_submit_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_subscription_order();\" />";
		}else{
			echo "<input type=\"submit\" id=\"ec_submit_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_checkout_submit_order();\" />";
		}
		
	}
	
	public function display_cancel_order_button( $button_text ){
		echo "<input type=\"button\" id=\"ec_cancel_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_cancel_order();\" />";
	}
	
	public function display_order_review_button( $button_text ){
		echo "<input type=\"button\" id=\"ec_review_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"if( ec_cart_validate_checkout_submit_order( ) ){ ec_cart_show_review_panel( ); } return false;\" />";
	}
	
	/* START ADDRESS REVIEW FUNCTIONS */
	public function display_address_review(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_address_review.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_address_review.php' );
			else	
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_address_review.php' );
		}
		
		if( !get_option( 'ec_option_use_shipping' ) )
			echo "<script>jQuery('.ec_cart_address_review_middle').html('');</script>";
	}
	
	public function display_edit_address_link( $link_text ){
		echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info\">" . $link_text . "</a>";	
	}
	
	public function display_review_billing( $name ){
		echo $this->user->billing->get_value( $name );
	}
	
	public function has_billing_address_line2( ){
		if( $this->user->billing->address_line_2 != "" ){
			return true;
		}else{
			return false;
		}
	}
	
	public function display_review_shipping( $name ){
		echo $this->user->shipping->get_value( $name );
	}
	
	public function has_shipping_address_line2( ){
		if( $this->user->shipping->address_line_2 != "" ){
			return true;
		}else{
			return false;
		}
	}
	
	public function display_selected_shipping_method( ){
		echo $this->shipping->get_selected_shipping_method();
	}
	/* END ADDRESS REVIEW FUNCTIONS */
	
	/* START PAYMENT INFORMATION FUNCTIONS */
    public function display_payment( ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment.php' );
		}
	}
	
    public function display_payment_information( ){
    	if(	$this->cart->total_items > 0 && $this->order_totals->grand_total > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment_information.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment_information.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment_information.php' );
			
			echo "<script>jQuery(\"input[name=ec_cart_payment_selection][value='" . get_option( 'ec_option_default_payment_type' ) . "']\").attr('checked', 'checked');";
			if( get_option( 'ec_option_default_payment_type' ) == "manual_bill" ){
				echo "jQuery('#ec_cart_pay_by_manual_payment').show();";
			}else if( get_option( 'ec_option_default_payment_type' ) == "affirm" ){
				echo "jQuery('#ec_cart_pay_by_affirm').show();";
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
		echo nl2br( $GLOBALS['language']->convert_text( get_option( 'ec_option_direct_deposit_message' ) ) );
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
		if( get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" )
			echo "Dwolla";
		else if( get_option( 'ec_option_payment_third_party' ) == "nets" )
			echo "Nets Netaxept";
		else if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
			echo "PayPal";
		else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
			echo "Skrill";
		else if( get_option( 'ec_option_payment_third_party' ) == "realex_thirdparty" )
			echo "Realex Payments";
		else if( get_option( 'ec_option_payment_third_party' ) == "paymentexpress_thirdparty" )
			echo "Payment Express";
	}
	
	public function ec_cart_get_current_third_party_name( ){
		if( get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" )
			return "Dwolla";
		else if( get_option( 'ec_option_payment_third_party' ) == "nets" )
			return "Nets Netaxept";
		else if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
			return "PayPal";
		else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
			return "Skrill";
		else if( get_option( 'ec_option_payment_third_party' ) == "realex_thirdparty" )
			return "Realex Payments";
		else if( get_option( 'ec_option_payment_third_party' ) == "paymentexpress_thirdparty" )
			return "Payment Express";
	}
	
	public function ec_cart_display_third_party_logo( ){
		if( get_option( 'ec_option_payment_third_party' ) == "paypal" ){
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/paypal.jpg" ) )	
				echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/paypal.jpg" ) . "\" alt=\"PayPal\" />";
			else
				echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/paypal.jpg") . "\" alt=\"PayPal\" />";
		}else if( get_option( 'ec_option_payment_third_party' ) == "skrill" ){
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/skrill-logo.gif" ) )	
				echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/skrill-logo.gif" ) . "\" alt=\"Skrill\" />";
			else
				echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/skrill-logo.gif") . "\" alt=\"Skrill\" />";
		}
	}
	
	public function use_payment_gateway( ){
		if( get_option( 'ec_option_payment_process_method' ) )
			return true;
		else
			return false;
	}
	
	public function ec_cart_display_credit_card_images(){
		//display credit card icons
		if( get_option('ec_option_use_visa') || get_option('ec_option_use_delta') || get_option('ec_option_use_uke') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visa.png") . "\" alt=\"Visa\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_visa\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visa_inactive.png") . "\" alt=\"Visa\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_visa_inactive\" />";
		
		/*
		if( get_option('ec_option_use_delta') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visadebit.png") . "\" alt=\"Visa Debit\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_delta\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visadebit_inactive.png") . "\" alt=\"Visa Debit\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_delta_inactive\" />";
			
		if( get_option('ec_option_use_uke') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visaelectron.png") . "\" alt=\"Visa Electron\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_uke\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visaelectron_inactive.png") . "\" alt=\"Visa Electron\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_uke_inactive\" />";
		*/
		
		if( get_option('ec_option_use_discover') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/discover.png") . "\" alt=\"Discover\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_discover\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/discover_inactive.png") . "\" alt=\"Discover\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_discover_inactive\" />";
		
		if( get_option('ec_option_use_mastercard') || get_option('ec_option_use_mcdebit') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/mastercard.png") . "\" alt=\"Mastercard\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_mastercard\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/mastercard_inactive.png") . "\" alt=\"Mastercard\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_mastercard_inactive\" />";
		
		if( get_option('ec_option_use_amex') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/american_express.png") . "\" alt=\"AMEX\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_amex\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/american_express_inactive.png") . "\" alt=\"AMEX\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_amex_inactive\" />";
		
		if( get_option('ec_option_use_jcb') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/jcb.png") . "\" alt=\"JCB\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_jcb\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/jcb_inactive.png") . "\" alt=\"JCB\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_jcb_inactive\" />";
		
		if( get_option('ec_option_use_diners') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/diners.png") . "\" alt=\"Diners\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_diners\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/diners_inactive.png") . "\" alt=\"Diners\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_diners_inactive\" />";
		
		/*
		if( get_option('ec_option_use_laser') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/laser.png") . "\" alt=\"Laser\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_laser\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/laser_inactive.png") . "\" alt=\"Laser\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_laser_inactive\" />";
		*/
		
		if( get_option('ec_option_use_maestro') || get_option('ec_option_use_laser'))
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/maestro.png") . "\" alt=\"Maestro\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_maestro\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/maestro_inactive.png") . "\" alt=\"Maestro\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_maestro_inactive\" />";
		
		
	}
	
	public function ec_cart_display_payment_method_input( $select_one_text ){
		echo "<select name=\"ec_cart_payment_type\" id=\"ec_cart_payment_type\" class=\"ec_cart_payment_information_input_select\">";
		
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
	
	public function ec_cart_display_card_holder_name_hidden_input(){
		echo "<input type=\"hidden\" name=\"ec_card_holder_name\" id=\"ec_card_holder_name\" class=\"ec_cart_payment_information_input_text\" value=\"" . $this->user->billing->first_name . " " . $this->user->billing->last_name . "\" />";
	}
	
	public function ec_cart_display_card_number_input(){
		echo "<input type=\"text\" name=\"ec_card_number\" id=\"ec_card_number\" class=\"ec_cart_payment_information_input_text\" value=\"\" autocomplete=\"off\" />";
	}
	
	public function ec_cart_display_card_expiration_month_input( $select_text ){
		echo "<select name=\"ec_expiration_month\" id=\"ec_expiration_month\" class=\"ec_cart_payment_information_input_select\" autocomplete=\"off\">";
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
		echo "<select name=\"ec_expiration_year\" id=\"ec_expiration_year\" class=\"ec_cart_payment_information_input_select\" autocomplete=\"off\">";
		echo "<option value=\"0\">" . $select_text . "</option>";
		for( $i=date( 'Y' ); $i < date( 'Y' ) + 15; $i++ ){
			echo "<option value=\"" . $i . "\">" . $i . "</option>";	
		}
		echo "</select>";
	}
	
	public function ec_cart_display_card_security_code_input(){
		echo "<input type=\"text\" name=\"ec_security_code\" id=\"ec_security_code\" class=\"ec_cart_payment_information_input_text\" value=\"\" autocomplete=\"off\" />";
	}
	/* END PAYMENT INFORMATION FUNCTIONS */
    
	/* START CONTACT INFORMATION FUNCTIONS */
    public function display_contact_information(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_contact_information.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_contact_information.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_contact_information.php' );
		}
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
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_submit_order.php' ) )	
				include( WP_PLUGIN_DIR . "/" . 'wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_submit_order.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_submit_order.php' );
		}
	}
	
	public function display_customer_order_notes( ){
		if( get_option( 'ec_option_user_order_notes' ) ){
			echo "<div class=\"ec_cart_payment_information_title\">" . $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ) . "</div>";
			echo "<div class=\"ec_cart_submit_order_message\">" . $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_message' ) . "</div>";	
			echo "<div class=\"ec_cart_payment_information_row\"><textarea name=\"ec_order_notes\" id=\"ec_order_notes\">";
			if( isset( $_SESSION['ec_order_notes'] ) )
				echo $_SESSION['ec_order_notes'];
			
			echo "</textarea></div><hr />";
		}
	}
	
	public function display_order_finalize_panel( ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_finalize_order.php' ) )	
				include( WP_PLUGIN_DIR . "/" . 'wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_finalize_order.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_finalize_order.php' );
		}
	}
	
	public function display_ajax_loader( $img ){
		echo "<img src=\"" .  plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ajax-loader.gif" ) . "\" class=\"ec_cart_final_loader\" />";
	}
	/* END SUBMIT ORDER DISPLAY FUNCTIONS */
	
	/* START SUCCESS PAGE FUNCTIONS */
	public function display_print_receipt_link( $link_text, $order_id ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=print_receipt&order_id=" . $order_id . "\" target=\"_blank\">" . $link_text . "</a>";
	}
	
	public function display_success_account_create_form_start( $order_id, $email ){
		echo "<form action=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&order_id=" . $order_id . "\" method=\"POST\">";
		echo "<input type=\"hidden\" value=\"order_create_account\" name=\"ec_account_form_action\" />";
		echo "<input type=\"hidden\" value=\"" . $order_id . "\" name=\"order_id\" />";
		echo "<input type=\"hidden\" value=\"" . $email . "\" name=\"email_address\" />";
	}
	
	public function display_success_create_password( ){
		echo "<input type=\"password\" name=\"ec_password\" id=\"ec_password\" />";
	}
	
	public function display_success_verify_password( ){
		echo "<input type=\"password\" name=\"ec_verify_password\" id=\"ec_verify_password\" />";
	}
	
	public function display_success_account_create_submit_button( $button_text ){
		echo "<input type=\"submit\" value=\"" . $button_text . "\" onclick=\"return ec_check_success_passwords( );\" />";
	}
	
	public function display_success_account_create_form_end( ){
		echo "</form>";
	}
	/* END SUCCESS PAGE FUNCTIONS */
	
	/* START FORM PROCESSING FUNCTIONS */
	// Process the cart page form action
	public function process_form_action( $action ){
		if( $action == "add_to_cart" )								$this->process_add_to_cart();
		else if( $action == "add_to_cart_v3" )						$this->process_add_to_cart_v3( );
		else if( $action == "ec_update_action" )					$this->process_update_cartitem( $_POST['ec_update_cartitem_id'], $_POST['ec_cartitem_quantity_' . $_POST['ec_update_cartitem_id'] ] );
		else if( $action == "ec_delete_action" )					$this->process_delete_cartitem( $_POST['ec_delete_cartitem_id'] );
		else if( $action == "submit_order" )						$this->process_submit_order();
		else if( $action == "3dsecure" )							$this->process_3dsecure_response();
		else if( $action == "third_party_forward" )					$this->process_third_party_forward();
		else if( $action == "login_user" )							$this->process_login_user();
		else if( $action == "save_checkout_info" )					$this->process_save_checkout_info();
		else if( $action == "save_checkout_shipping" )				$this->process_save_checkout_shipping();
		else if( $action == "logout" )								$this->process_logout_user();
		else if( $action == "realex_redirect" )						$this->process_realex_redirect( );
		else if( $action == "realex_response" )						$this->process_realex_response( );
		else if( $action == "paymentexpress_thirdparty_response" )	$this->process_paymentexpress_thirdparty_response( );
		else if( $action == "purchase_subscription" )				$this->process_purchase_subscription( );
		else if( $action == "insert_subscription" )					$this->process_insert_subscription( );
		else if( $action == "send_inquiry" )						$this->process_send_inquiry( );
		else if( $action == "deconetwork_add_to_cart" )				$this->process_deconetwork_add_to_cart( );
		else if( $action == "subscribe_v3" )						$this->process_subscribe_v3( );
	}
	
	// Process the add to cart form submission
	private function process_add_to_cart(){
		
		if( !$this->check_quantity( $_POST['product_id'], $_POST['product_quantity'] ) ){
			header( "location: " . $this->store_page . $this->permalink_divider . "model_number=" . $_POST['model_number'] . "&ec_store_error=minquantity" );
			
		}else{
			
			//add_to_cart_replace Hook
			if( isset( $GLOBALS['ec_hooks']['add_to_cart_replace'] ) ){
				$class_args = array( "cart_page" => $this->cart_page, "permalink_divider" => $this->permalink_divider );
				for( $i=0; $i<count( $GLOBALS['ec_hooks']['add_to_cart_replace'] ); $i++ ){
					ec_call_hook( $GLOBALS['ec_hooks']['add_to_cart_replace'][$i], $class_args );
				}
			}else{
				//Product Info
				$session_id = $_SESSION['ec_cart_id'];
				$product_id = $_POST['product_id'];
				if( isset( $_POST['product_quantity'] ) )
					$quantity = $_POST['product_quantity'];
				else
					$quantity = 1;
				
				$model_number = stripslashes( $_POST['model_number'] );
				
				//Optional Gift Card Info
				$gift_card_message = "";
				if( isset( $_POST['ec_gift_card_message'] ) )
					$gift_card_message = stripslashes( $_POST['ec_gift_card_message'] );
				
				$gift_card_to_name = "";
				if( isset( $_POST['ec_gift_card_to_name'] ) )
					$gift_card_to_name = stripslashes( $_POST['ec_gift_card_to_name'] );
				
				$gift_card_from_name = "";
				if( isset( $_POST['ec_gift_card_from_name'] ) )
					$gift_card_from_name = stripslashes( $_POST['ec_gift_card_from_name'] );
				
				// Optional Donation Price
				$donation_price = 0.000;
				if( isset( $_POST['ec_product_input_price'] ) )
					$donation_price = $_POST['ec_product_input_price'];
				
				$use_advanced_optionset = false;
				//Product Options
				if( isset( $_POST['ec_use_advanced_optionset'] ) && $_POST['ec_use_advanced_optionset'] ){
					$option1 = "";
					$option2 = "";
					$option3 = "";
					$option4 = "";
					$option5 = "";
					$use_advanced_optionset = true;
				}else{
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
						
				}
				
				$tempcart_id = $this->mysqli->add_to_cart( $product_id, $session_id, $quantity, $option1, $option2, $option3, $option4, $option5, $gift_card_message, $gift_card_to_name, $gift_card_from_name, $donation_price, $use_advanced_optionset, false );
				
				$option_vals = array( );
				// Now insert the advanced option set tempcart table if needed
				if( $use_advanced_optionset ){
					
					$optionsets = $this->mysqli->get_advanced_optionsets( $product_id );
					$grid_quantity = 0;
					
					foreach( $optionsets as $optionset ){
						if( $optionset->option_type == "checkbox" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) ){
									$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
								}
							}
						}else if( $optionset->option_type == "grid" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) && $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] > 0 ){
									$grid_quantity = $grid_quantity + $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id];
									$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id], "optionitem_model_number" => $optionitem->optionitem_model_number );
								}
							}
						}else if( $optionset->option_type == "combo" || $optionset->option_type == "swatch" || $optionset->option_type == "radio" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								if( $optionitem->optionitem_id == $_POST['ec_option_' . $optionset->option_id] ){
									$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => $optionitem->optionitem_name, "optionitem_model_number" => $optionitem->optionitem_model_number );
								}
							}
						}else if( $optionset->option_type == "file" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => $_FILES['ec_option_' . $optionset->option_id]['name'], "optionitem_model_number" => $optionitem->optionitem_model_number );
							}
						}else{
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
							}
						}
						
						if( $optionset->option_type == "file" ){
							//upload the file
							$this->upload_customer_file( $tempcart_id, 'ec_option_' . $optionset->option_id );
						}
					}
				}
				
				for( $i=0; $i<count( $option_vals ); $i++ ){
					$this->mysqli->add_option_to_cart( $tempcart_id, $_SESSION['ec_cart_id'], $option_vals[$i] );
				}
				
				if( $grid_quantity > 0 ){
					$this->mysqli->update_tempcart_grid_quantity( $tempcart_id, $grid_quantity );
				}
				
				if( get_option( 'ec_option_addtocart_return_to_product' ) ){
					$return_url = $_SERVER['HTTP_REFERER'];
					$return_url = str_replace( "ec_store_success=addtocart", "", $return_url );
					$divider = "?";
					if( substr_count( $return_url, '?' ) )
						$divider = "&";
					
					
					header( "location: " . $return_url . $divider . "ec_store_success=addtocart&model=" . $_POST['model_number'] );
				}else{
					header( "location: " . $this->cart_page );
				}
			}
		}
	}
	
	private function send_inquiry( $product ){
			
		$inquiry_name = "";
		$inquiry_email = "";
		$inquiry_message = "";
		$send_copy = false;
		$has_product_options = false;
		
		if( isset( $_POST['ec_inquiry_name'] ) )			$inquiry_name = $_POST['ec_inquiry_name'];
		if( isset( $_POST['ec_inquiry_email'] ) )			$inquiry_email = $_POST['ec_inquiry_email'];
		if( isset( $_POST['ec_inquiry_message'] ) )			$inquiry_message = $_POST['ec_inquiry_message'];
		if( isset( $_POST['ec_inquiry_send_copy'] ) )		$send_copy = true;
		
		//Product Options
		$option1 = $option2 = $option3 = $option4 = $option5 = "";
		$optionitem_list = $this->mysqli->get_optionitem_list( );
		
		if( !$product->use_advanced_optionset ){
			
			if( isset( $_POST['ec_option1'] ) )				$option1 = $_POST['ec_option1'];
			if( isset( $_POST['ec_option2'] ) )				$option2 = $_POST['ec_option2'];
			if( isset( $_POST['ec_option3'] ) )				$option3 = $_POST['ec_option3'];
			if( isset( $_POST['ec_option4'] ) )				$option4 = $_POST['ec_option4'];
			if( isset( $_POST['ec_option5'] ) )				$option5 = $_POST['ec_option5'];
			
			if( isset( $_POST['ec_option1'] ) || isset( $_POST['ec_option2'] ) || isset( $_POST['ec_option3'] ) || isset( $_POST['ec_option4'] ) || isset( $_POST['ec_option5'] ) ){
				$has_product_options = true;
			}
			
		}
		
		foreach( $optionitem_list as $optionitem ){
			if( $option1 == $optionitem->optionitem_id ){
				$option1 = $optionitem->optionitem_name;
			}else if( $option2 == $optionitem->optionitem_id ){
				$option2 = $optionitem->optionitem_name;
			}else if( $option3 == $optionitem->optionitem_id ){
				$option3 = $optionitem->optionitem_name;
			}else if( $option4 == $optionitem->optionitem_id ){
				$option4 = $optionitem->optionitem_name;
			}else if( $option5 == $optionitem->optionitem_id ){
				$option5 = $optionitem->optionitem_name;
			}
		}
		
		if( $product->use_advanced_optionset ){
			$tempcart_id = rand( 0, 99999999 );
			$option_vals = $this->get_advanced_option_vals( $product->product_id, $tempcart_id );
		}
		
		// send inquiry
		// Create mail script
		$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
		
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; charset=utf-8";
		$headers[] = "From: " . get_option( 'ec_option_password_from_email' );
		$headers[] = "Reply-To: " . get_option( 'ec_option_password_from_email' );
		$headers[] = "X-Mailer: PHP/".phpversion();
		
		ob_start();
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php' ) )	
			include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php';	
		else
			include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php';
		$message = ob_get_clean();
		
		if( get_option( 'ec_option_use_wp_mail' ) ){
			if( $send_copy )
				wp_mail( $inquiry_email, "New Product Inquiry", $message, implode("\r\n", $headers) );
			
			wp_mail( get_option( 'ec_option_bcc_email_addresses' ), "New Product Inquiry", $message, implode("\r\n", $headers) );
		}else{
			if( $send_copy )
				mail( $inquiry_email, "New Product Inquiry", $message, implode("\r\n", $headers) );
			
			mail( get_option( 'ec_option_bcc_email_addresses' ), "New Product Inquiry", $message, implode("\r\n", $headers) );
		}
		
		header( "location: " . $this->store_page . $this->permalink_divider . "model_number=" . $product->model_number . "&ec_store_success=inquiry_sent" );
		// return to previous url with success message.
			
	}
	
	private function get_advanced_option_vals( $product_id, $tempcart_id ){
		
		$option_vals = array( );
		$optionsets = $this->mysqli->get_advanced_optionsets( $product_id );
		$grid_quantity = 0;
		
		foreach( $optionsets as $optionset ){
			
			if( $optionset->option_type == "checkbox" ){
				$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
				foreach( $optionitems as $optionitem ){
					if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) ){
						$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
					}
				}
			
			}else if( $optionset->option_type == "grid" ){
				$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
				foreach( $optionitems as $optionitem ){
					if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) && $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] > 0 ){
						$grid_quantity = $grid_quantity + $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id];
						$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id], "optionitem_model_number" => $optionitem->optionitem_model_number );
					}
				}
			
			}else if( $optionset->option_type == "combo" || $optionset->option_type == "swatch" || $optionset->option_type == "radio" ){
				$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
				foreach( $optionitems as $optionitem ){
					if( $optionitem->optionitem_id == $_POST['ec_option_' . $optionset->option_id] ){
						$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => $optionitem->optionitem_name, "optionitem_model_number" => $optionitem->optionitem_model_number );
					}
				}
			
			}else if( $optionset->option_type == "file" ){
				$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
				foreach( $optionitems as $optionitem ){
					$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => $_FILES['ec_option_' . $optionset->option_id]['name'], "optionitem_model_number" => $optionitem->optionitem_model_number );
				}
			
			}else{
				$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
				foreach( $optionitems as $optionitem ){
					$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
				}
			}
			
			if( $optionset->option_type == "file" ){
				//upload the file
				$this->upload_customer_file( $tempcart_id, 'ec_option_' . $optionset->option_id );
			}
		}
		
		return $option_vals;
		
	}
	
	private function get_grid_quantity( $product_id, $tempcart_id ){
		
		$optionsets = $this->mysqli->get_advanced_optionsets( $product_id );
		$grid_quantity = 0;
		foreach( $optionsets as $optionset ){
			
			if( $optionset->option_type == "grid" ){
				$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
				foreach( $optionitems as $optionitem ){
					if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) && $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] > 0 ){
						$grid_quantity = $grid_quantity + $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id];
					}
				}
			}
		}
		return $grid_quantity;
		
	}
	
	private function process_add_to_cart_v3( ){
		
		$cart_id = $_SESSION['ec_cart_id'];
		$product_id = $_POST['product_id'];
		
		$product = $this->mysqli->get_product( "", $product_id );
		
		if( $product->inquiry_mode ){
			
			$this->send_inquiry( $product );
			
		}else if( $product->is_subscription_item ){
			
		}else{
		
			if( isset( $_POST['ec_quantity'] ) )				$quantity = $_POST['ec_quantity'];
			else												$quantity = 1;
			
			//Optional Gift Card Info
			$gift_card_message = "";
			if( isset( $_POST['ec_giftcard_message'] ) )		$gift_card_message = stripslashes( $_POST['ec_giftcard_message'] );
			
			$gift_card_to_name = "";
			if( isset( $_POST['ec_giftcard_to_name'] ) )		$gift_card_to_name = stripslashes( $_POST['ec_giftcard_to_name'] );
			
			$gift_card_from_name = "";
			if( isset( $_POST['ec_giftcard_from_name'] ) )		$gift_card_from_name = stripslashes( $_POST['ec_giftcard_from_name'] );
			
			$gift_card_email = "";
			if( isset( $_POST['ec_giftcard_to_email'] ) )		$gift_card_email = stripslashes( $_POST['ec_giftcard_to_email'] );
			
			// Optional Donation Price
			$donation_price = 0.000;
			if( isset( $_POST['ec_donation_amount'] ) )			$donation_price = $_POST['ec_donation_amount'];
			
			$use_advanced_optionset = 							$product->use_advanced_optionset;
			
			//Product Options
			$option1 = $option2 = $option3 = $option4 = $option5 = "";
			if( !$use_advanced_optionset ){
				
				if( isset( $_POST['ec_option1'] ) )				$option1 = $_POST['ec_option1'];
				if( isset( $_POST['ec_option2'] ) )				$option2 = $_POST['ec_option2'];
				if( isset( $_POST['ec_option3'] ) )				$option3 = $_POST['ec_option3'];
				if( isset( $_POST['ec_option4'] ) )				$option4 = $_POST['ec_option4'];
				if( isset( $_POST['ec_option5'] ) )				$option5 = $_POST['ec_option5'];
				
			}
			
			$tempcart_id = $this->mysqli->add_to_cart( $product_id, $cart_id, $quantity, $option1, $option2, $option3, $option4, $option5, $gift_card_message, $gift_card_to_name, $gift_card_from_name, $donation_price, $use_advanced_optionset, false, $gift_card_email );
			
			// Now insert the advanced option set tempcart table if needed
			if( $use_advanced_optionset ){
				
				$option_vals = $this->get_advanced_option_vals( $product_id, $tempcart_id );
				$grid_quantity = $this->get_grid_quantity( $product_id, $tempcart_id );
				
			}
			
			for( $i=0; $i<count( $option_vals ); $i++ ){
				$this->mysqli->add_option_to_cart( $tempcart_id, $cart_id, $option_vals[$i] );
			}
			
			if( $grid_quantity > 0 ){
				$this->mysqli->update_tempcart_grid_quantity( $tempcart_id, $grid_quantity );
			}
			
			if( get_option( 'ec_option_addtocart_return_to_product' ) ){
				$return_url = $_SERVER['HTTP_REFERER'];
				$return_url = str_replace( "ec_store_success=addtocart", "", $return_url );
				$divider = "?";
				if( substr_count( $return_url, '?' ) )
					$divider = "&";
				
				
				header( "location: " . $return_url . $divider . "ec_store_success=addtocart&model=" . $_POST['model_number'] );
			
			}else{
				header( "location: " . $this->cart_page );
			
			}
			
		}
		
	}
	
	private function check_quantity( $product_id, $quantity ){
		
		global $wpdb;
		$min_quantity = $wpdb->get_var( $wpdb->prepare( "SELECT ec_product.min_purchase_quantity FROM ec_product WHERE ec_product.product_id = %d", $product_id ) );
		
		if( $min_quantity > 0 ){
			$current_amount = $quantity;
			foreach( $this->cart->cart as $cartitem ){
				if( $cartitem->product_id == $product_id ){
					$current_amount = $current_amount + $cartitem->quantity;
				}
			}
			
			if( $min_quantity <= $current_amount ){
				return true;
				
			}else{
				return false;
				
			}
		
		
		}else{
			return true;
		}
		
	}
	
	private function process_update_cartitem( $cartitem_id, $new_quantity ){
		$this->mysqli->update_cartitem( $cartitem_id, $_SESSION['ec_cart_id'], $new_quantity );
		
		if( isset( $_GET['ec_page'] ) )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $_GET['ec_page'] );	
		else
			header( "location: " . $this->cart_page );
	}
	
	private function process_delete_cartitem( $cartitem_id ){
		$this->mysqli->delete_cartitem( $cartitem_id, $_SESSION['ec_cart_id'] );
		
		if( isset( $_GET['ec_page'] ) )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $_GET['ec_page'] );	
		else
			header( "location: " . $this->cart_page );
	}
	
	private function process_submit_order(){
		if( isset( $_POST['ec_cart_payment_selection'] ) )
			$payment_type = $_POST['ec_cart_payment_selection'];
		else if( $this->is_affirm )
			$payment_type = "affirm";
		else
			$payment_type = $GLOBALS['language']->get_text( "ec_success", "cart_account_free_order" );
			
		if( isset( $_POST['ec_order_notes'] ) )
			$_SESSION['ec_order_notes'] = stripslashes( $_POST['ec_order_notes'] );
			
		$submit_return_val = $this->order->submit_order( $payment_type );
		
		if( $this->order_totals->grand_total <= 0 ){
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );	
			
		}else if( $payment_type == "manual_bill" ){ // Show fail message or the success landing page (including the manual bill notice).
			if( $submit_return_val == "1" )
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );
			else
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&cart_error=manualbill_failed" );
			
		}else if( $payment_type == "affirm" ){
			if( $submit_return_val == "1" )
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );
			else
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=payment_failed" );
			
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
	
	private function process_realex_redirect( ){
		// Check response, if success, send to success page. If failed, return to last page of cart
		if( isset( $_POST['AUTHCODE'] ) && isset( $_POST['ORDER_ID'] ) && $_POST['AUTHCODE'] == "00" )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_POST['ORDER_ID'] );
		else
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=thirdparty_failed" );
	}
	
	private function process_realex_response( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/scripts/realex_payment_complete.php" );
	}
	
	private function process_paymentexpress_thirdparty_response( ){
		$gateway = new ec_paymentexpress_thirdparty( );
		$gateway->update_order_status( );
		$db = new ec_db( );
		$db->clear_tempcart( $_SESSION['ec_cart_id'] );
		header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_GET['order_id'] );
	}
	
	private function process_third_party_forward( ){
		$this->payment->third_party->initialize( $_GET['order_id'] );
		$this->payment->third_party->display_auto_forwarding_form( );
		die( );
	}
	
	private function process_login_user( ){
		$email = $_POST['ec_cart_login_email'];
		$password = md5( $_POST['ec_cart_login_password'] );
		
		$user = $this->mysqli->get_user( $email, $password );
		if( $user && $user->user_level == "pending" ){
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_login&ec_cart_error=not_activated");
		}else if( $email == "guest"){
			$_SESSION['ec_email'] = "guest";
			$_SESSION['ec_username'] = "guest";
			$_SESSION['ec_password'] = "guest";
			if( isset( $_POST['ec_cart_subscription'] ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_subscription'] );
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
			}
		}else if( $user ){
			unset( $_SESSION['ec_is_guest'] );
			unset( $_SESSION['ec_guest_key'] );
			$_SESSION['ec_user_id'] = $user->user_id;
			$_SESSION['ec_email'] = $email;
			$_SESSION['ec_username'] = $user->first_name . " " . $user->last_name;
			$_SESSION['ec_first_name'] = $user->first_name;
			$_SESSION['ec_last_name'] = $user->last_name;
			$_SESSION['ec_password'] = $password;
			
			$_SESSION['ec_shipping_zip'] = $user->shipping_zip;
			$_SESSION['ec_shipping_country'] = $user->shipping_country;
			
			if( isset( $_POST['ec_cart_subscription'] ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_subscription'] );
			}else if( isset( $_POST['ec_cart_model_number'] ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_model_number'] );
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
			}
		}else{
			if( get_option( 'ec_option_skip_cart_login' ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=login_failed");
			}else if( isset( $_POST['ec_cart_subscription'] ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_subscription'] . "&ec_cart_error=login_failed" );
			}else if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=login_failed");
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
		unset( $_SESSION['ec_billing_address2'] );
		unset( $_SESSION['ec_billing_city'] );
		unset( $_SESSION['ec_billing_state'] );
		unset( $_SESSION['ec_billing_zip'] );
		unset( $_SESSION['ec_billing_country'] );
		unset( $_SESSION['ec_billing_phone'] );
		
		unset( $_SESSION['ec_shipping_selector'] );
		
		unset( $_SESSION['ec_shipping_first_name'] );
		unset( $_SESSION['ec_shipping_last_name'] );
		unset( $_SESSION['ec_shipping_address'] );
		unset( $_SESSION['ec_shipping_address2'] );
		unset( $_SESSION['ec_shipping_city'] );
		unset( $_SESSION['ec_shipping_state'] );
		unset( $_SESSION['ec_shipping_zip'] );
		unset( $_SESSION['ec_shipping_country'] );
		unset( $_SESSION['ec_shipping_phone'] );
		
		unset( $_SESSION['ec_first_name'] );
		unset( $_SESSION['ec_last_name'] );
		
		unset( $_SESSION['ec_create_account'] );
		
		unset( $_SESSION['ec_order_notes'] );
		
		unset( $_SESSION['ec_shipping_method'] );
		unset( $_SESSION['ec_temp_zipcode'] );
		unset( $_SESSION['ec_temp_country'] );
		
		if( isset( $_GET['subscription'] ) ){
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_GET['subscription'] );
		}else if( get_option( 'ec_option_skip_cart_login' ) || file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
		}else{
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_login");
		}
	}
	
	private function process_save_checkout_info( ){
		
		if( isset( $_POST['ec_login_selector'] ) ){
			$this->process_login_user( );
			
		}else{
			$this->process_save_checkout_info_helper( );
		}
		
	}
	
	private function process_save_checkout_info_helper( ){
		
		$billing_country = $shipping_country = stripslashes( $_POST['ec_cart_billing_country'] );
		
		$billing_first_name = $shipping_first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
		$billing_last_name = $shipping_last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
			
		if( isset( $_POST['ec_cart_billing_company_name'] ) ){
			$billing_company_name = $shipping_company_name = $_POST['ec_cart_billing_company_name'];
		}else{
			$billing_company_name = $shipping_company_name = "";
		}
		
		$billing_address = $shipping_address = stripslashes( $_POST['ec_cart_billing_address'] );
		if( isset( $_POST['ec_cart_billing_address2'] ) ){
			$billing_address2 = $shipping_address2 = stripslashes( $_POST['ec_cart_billing_address2'] );
		}else{
			$billing_address2 = $shipping_address2 = "";
		}
		
		$billing_city = $shipping_city = stripslashes( $_POST['ec_cart_billing_city'] );
		if( isset( $_POST['ec_cart_billing_state_' . $billing_country] ) ){
			$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state_' . $billing_country] );
		}else{
			$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state'] );
		}
		
		$billing_zip = $shipping_zip = stripslashes( $_POST['ec_cart_billing_zip'] );
		if( isset( $_POST['ec_cart_billing_phone'] ) ){
			$billing_phone = $shipping_phone = stripslashes( $_POST['ec_cart_billing_phone'] );
		}else{
			$billing_phone = "";
		}
		
		if( isset( $_POST['ec_shipping_selector'] ) )
			$shipping_selector = $_POST['ec_shipping_selector'];
		else
			$shipping_selector = "false";
		
		if( $shipping_selector == "true" ){
			$shipping_country = stripslashes( $_POST['ec_cart_shipping_country'] );
			
			$shipping_first_name = stripslashes( $_POST['ec_cart_shipping_first_name'] );
			$shipping_last_name = stripslashes( $_POST['ec_cart_shipping_last_name'] );
			
			if( isset( $_POST['ec_cart_shipping_company_name'] ) ){
				$shipping_company_name = $_POST['ec_cart_shipping_company_name'];
			}else{
				$shipping_company_name = "";
			}
			
			$shipping_address = stripslashes( $_POST['ec_cart_shipping_address'] );
			if( isset( $_POST['ec_cart_shipping_address2'] ) ){
				$shipping_address2 = stripslashes( $_POST['ec_cart_shipping_address2'] );
			}else{
				$shipping_address2 = "";
			}
			
			$shipping_city = stripslashes( $_POST['ec_cart_shipping_city'] );
			
			if( isset( $_POST['ec_cart_shipping_state_' . $shipping_country] ) ){
				$shipping_state = stripslashes( $_POST['ec_cart_shipping_state_' . $shipping_country] );
			}else{
				$shipping_state = stripslashes( $_POST['ec_cart_shipping_state'] );
			}
			
			$shipping_zip = stripslashes( $_POST['ec_cart_shipping_zip'] );
			if( isset( $_POST['ec_cart_shipping_phone'] ) ){
				$shipping_phone = stripslashes( $_POST['ec_cart_shipping_phone'] );
			}else{
				$shipping_phone = "";
			}
		}
		
		if( isset( $_POST['ec_order_notes'] ) ){
			$order_notes = $_POST['ec_order_notes'];
		}else if( isset( $_SESSION['ec_order_notes'] ) ){
			$order_notes = $_SESSION['ec_order_notes'];
		}else{
			$order_notes = "";
		}
		
		if( isset( $_POST['ec_contact_first_name'] ) ){
			$first_name = stripslashes( $_POST['ec_contact_first_name'] );
		}else if( isset( $_POST['ec_cart_billing_first_name'] ) ){
			$first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
		}else{
			$first_name = "";
		}
		if( isset( $_POST['ec_contact_last_name'] ) ){
			$last_name = stripslashes( $_POST['ec_contact_last_name'] );
		}else if( isset( $_POST['ec_cart_billing_last_name'] ) ){
			$last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
		}else{
			$last_name = "";
		}
		
		if( isset( $_POST['ec_contact_create_account'] ) )
			$create_account = $_POST['ec_contact_create_account'];
		else if( isset( $_POST['ec_create_account_selector'] ) )
			$create_account = true;
		else
			$create_account = false;
		
		$_SESSION['ec_billing_first_name'] = $billing_first_name;
		$_SESSION['ec_billing_last_name'] = $billing_last_name;
		$_SESSION['ec_billing_company_name'] = $billing_company_name;
		$_SESSION['ec_billing_address'] = $billing_address;
		$_SESSION['ec_billing_address2'] = $billing_address2;
		$_SESSION['ec_billing_city'] = $billing_city;
		$_SESSION['ec_billing_state'] = $billing_state;
		$_SESSION['ec_billing_zip'] = $billing_zip;
		$_SESSION['ec_billing_country'] = $billing_country;
		$_SESSION['ec_billing_phone'] = $billing_phone;
		
		$_SESSION['ec_shipping_selector'] = $shipping_selector;
		
		$_SESSION['ec_shipping_first_name'] = $shipping_first_name;
		$_SESSION['ec_shipping_last_name'] = $shipping_last_name;
		$_SESSION['ec_shipping_company_name'] = $shipping_company_name;
		$_SESSION['ec_shipping_address'] = $shipping_address;
		$_SESSION['ec_shipping_address2'] = $shipping_address2;
		$_SESSION['ec_shipping_city'] = $shipping_city;
		$_SESSION['ec_shipping_state'] = $shipping_state;
		$_SESSION['ec_shipping_zip'] = $shipping_zip;
		$_SESSION['ec_shipping_country'] = $shipping_country;
		$_SESSION['ec_shipping_phone'] = $shipping_phone;
		
		$_SESSION['ec_first_name'] = $first_name;
		$_SESSION['ec_last_name'] = $last_name;
		
		$_SESSION['ec_order_notes'] = $order_notes;
		
		$next_page = "checkout_shipping";
		if( !get_option( 'ec_option_use_shipping' ) || $this->cart->weight == 0 )
			$next_page = "checkout_payment";
			
		if( get_option( 'ec_option_skip_shipping_page' ) || $this->user->freeshipping || $this->discount->shipping_discount == $this->discount->shipping_subtotal )
			$next_page = "checkout_payment";
		
		if( isset( $_POST['ec_contact_email'] ) ){
			$email = $_POST['ec_contact_email'];
			$_SESSION['ec_email'] = $email;
		}
		
		if( isset( $_POST['ec_contact_email'] ) && !$create_account ){
			$_SESSION['ec_is_guest'] = true;
			$_SESSION['ec_guest_key'] = $_SESSION['ec_cart_id'];
		}else{
			$_SESSION['ec_is_guest'] = false;
		}
		
		if( $create_account ){
			$email = $_POST['ec_contact_email'];
			$password = md5( $_POST['ec_contact_password'] );
			
			// INSERT USER
			$billing_id = $this->mysqli->insert_address( $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $billing_company_name );
			
			$shipping_id = $this->mysqli->insert_address( $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone, $shipping_company_name );
			
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
				
				if( $this->shipping->validate_address( $shipping_address, $shipping_city, $shipping_state, $shipping_zip, $shipping_country ) ){
					unset( $_SESSION['ec_is_guest'] );
					unset( $_SESSION['ec_guest_key'] );
					
					header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page . "&ec_cart_success=account_created");
				}else
					header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_success=account_created&ec_cart_error=invalid_address");
				
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=email_exists");
			}
		
		}else{
			
			if( $this->shipping->validate_address( $shipping_address, $shipping_city, $shipping_state, $shipping_zip, $shipping_country ) )
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page);
			
			else
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_address");
				
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
	
	private function process_purchase_subscription( ){
		
		$model_number = 0;
		if( isset( $_POST['model_number'] ) )
			$model_number = $_POST['model_number'];
		
		header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number );
		
	}
	
	private function process_insert_subscription( ){
		
		if( isset( $_POST['ec_login_selector'] ) ){
			$this->process_login_user( );
			
		}else{
			$this->process_insert_subscription_helper( );
		}
		
	}
	
	private function process_insert_subscription_helper( ){
		
		global $wpdb;
		$model_number = $_POST['ec_cart_model_number'];
		$products = $this->mysqli->get_product_list( $wpdb->prepare( " WHERE product.model_number = %s", $model_number ), "", "", "" );
		
		$user_error = false;
		if( isset( $_POST['ec_contact_email'] ) ){
			$user_error = $this->mysqli->does_user_exist( $_POST['ec_contact_email'] );
		}
		
		// If checkout out as new user and the email already exists, this is an error.
		if( !$user_error ){
		
			if( count( $products > 0 ) ){
				
				// Try to get a subscription for this product and email address!
				if( isset( $_POST['ec_contact_email'] ) )	$email_test = $_POST['ec_contact_email'];
				else										$email_test = $_SESSION['ec_email'];
				
				$subscription_list = $this->mysqli->find_subscription_match( $email_test, $products[0]['product_id'] );
				
				if( count( $subscription_list ) <= 0 ){
					
					// Coupon Information
					$coupon = NULL;
					$is_match = false;
					if( isset( $_POST['ec_cart_coupon_code'] ) && $_POST['ec_cart_coupon_code'] != "" ){
						$coupon_row = $this->mysqli->redeem_coupon_code( $_POST['ec_cart_coupon_code'] );
						$is_match = false;
						if( $coupon_row->by_product_id ){
							if( $products[0]['product_id'] == $coupon_row->product_id ){
								$is_match = true;
							}
						}else if( $coupon_row->by_manufacturer_id ){
							if( $products[0]['manufacturer_id'] == $coupon_row->manufacturer_id ){
								$is_match = true;
							}
						}else{
							$is_match = true;
						}
						
						if( $is_match ){
							$coupon = $coupon_row->promocode_id;
						}
					}else if( isset( $_POST['ec_coupon_code'] ) && $_POST['ec_coupon_code'] != "" ){
						$coupon_row = $this->mysqli->redeem_coupon_code( $_POST['ec_coupon_code'] );
						$is_match = false;
						if( $coupon_row->by_product_id ){
							if( $products[0]['product_id'] == $coupon_row->product_id ){
								$is_match = true;
							}
						}else if( $coupon_row->by_manufacturer_id ){
							if( $products[0]['manufacturer_id'] == $coupon_row->manufacturer_id ){
								$is_match = true;
							}
						}else{
							$is_match = true;
						}
						
						if( $is_match ){
							$coupon = $coupon_row->promocode_id;
						}
					}
					
					if( $is_match ){
						
						if( $coupon_row->is_dollar_based ){
							$products[0]['price'] = floatval( $products[0]['price'] ) - floatval( $coupon_row->promo_dollar );
							
						}else if( $coupon_row->is_percentage_based ){
							$products[0]['price'] = floatval( $products[0]['price'] ) - ( floatval( $products[0]['price'] ) * ( floatval( $coupon_row->promo_percentage ) / 100 ) );
							
						}
				
					}
				
					// Billing Information
					$billing_country = $shipping_country = stripslashes( $_POST['ec_cart_billing_country'] );
		
					$billing_first_name = $shipping_first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
					$billing_last_name = $shipping_last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
						
					if( isset( $_POST['ec_cart_billing_company_name'] ) ){
						$billing_company_name = $shipping_company_name = $_POST['ec_cart_billing_company_name'];
					}else{
						$billing_company_name = $shipping_company_name = "";
					}
					
					$billing_address = $shipping_address = stripslashes( $_POST['ec_cart_billing_address'] );
					if( isset( $_POST['ec_cart_billing_address2'] ) ){
						$billing_address2 = $shipping_address2 = stripslashes( $_POST['ec_cart_billing_address2'] );
					}else{
						$billing_address2 = $shipping_address2 = "";
					}
					
					$billing_city = $shipping_city = stripslashes( $_POST['ec_cart_billing_city'] );
					if( isset( $_POST['ec_cart_billing_state_' . $billing_country] ) ){
						$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state_' . $billing_country] );
					}else{
						$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state'] );
					}
					
					$billing_zip = $shipping_zip = stripslashes( $_POST['ec_cart_billing_zip'] );
					if( isset( $_POST['ec_cart_billing_phone'] ) ){
						$billing_phone = $shipping_phone = stripslashes( $_POST['ec_cart_billing_phone'] );
					}else{
						$billing_phone = "";
					}
					
					// Shipping Information
					if( isset( $_POST['ec_shipping_selector'] ) )
						$shipping_selector = $_POST['ec_shipping_selector'];
					else
						$shipping_selector = "false";
					
					if( $shipping_selector == "true" ){
						$shipping_country = stripslashes( $_POST['ec_cart_shipping_country'] );
						
						$shipping_first_name = stripslashes( $_POST['ec_cart_shipping_first_name'] );
						$shipping_last_name = stripslashes( $_POST['ec_cart_shipping_last_name'] );
						
						if( isset( $_POST['ec_cart_shipping_company_name'] ) ){
							$shipping_company_name = $_POST['ec_cart_shipping_company_name'];
						}else{
							$shipping_company_name = "";
						}
						
						$shipping_address = stripslashes( $_POST['ec_cart_shipping_address'] );
						if( isset( $_POST['ec_cart_shipping_address2'] ) ){
							$shipping_address2 = stripslashes( $_POST['ec_cart_shipping_address2'] );
						}else{
							$shipping_address2 = "";
						}
						
						$shipping_city = stripslashes( $_POST['ec_cart_shipping_city'] );
						
						if( isset( $_POST['ec_cart_shipping_state_' . $shipping_country] ) ){
							$shipping_state = stripslashes( $_POST['ec_cart_shipping_state_' . $shipping_country] );
						}else{
							$shipping_state = stripslashes( $_POST['ec_cart_shipping_state'] );
						}
						
						$shipping_zip = stripslashes( $_POST['ec_cart_shipping_zip'] );
						if( isset( $_POST['ec_cart_shipping_phone'] ) ){
							$shipping_phone = stripslashes( $_POST['ec_cart_shipping_phone'] );
						}else{
							$shipping_phone = "";
						}
					}
					
					// Order Notes
					if( isset( $_POST['ec_order_notes'] ) ){
						$order_notes = $_POST['ec_order_notes'];
					}else{
						$order_notes = "";
					}
					
					// Create Account Information
					if( isset( $_POST['ec_contact_first_name'] ) ){
						$first_name = stripslashes( $_POST['ec_contact_first_name'] );
					}else if( isset( $_POST['ec_cart_billing_first_name'] ) ){
						$first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
					}else{
						$first_name = "";
					}
					if( isset( $_POST['ec_contact_last_name'] ) ){
						$last_name = stripslashes( $_POST['ec_contact_last_name'] );
					}else if( isset( $_POST['ec_cart_billing_last_name'] ) ){
						$last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
					}else{
						$last_name = "";
					}
					
					if( isset( $_POST['ec_contact_create_account'] ) )
						$create_account = $_POST['ec_contact_create_account'];
					else if( isset( $_POST['ec_create_account_selector'] ) )
						$create_account = true;
					else
						$create_account = false;
						
						
					// Payment Information
					$payment_method = $this->get_payment_type( $this->sanatize_card_number( $_POST['ec_card_number'] ) );
					$card_holder_name = stripslashes( $_POST['ec_cart_billing_first_name'] . " " . $_POST['ec_cart_billing_last_name'] );
					$card_number = $_POST['ec_card_number'];
					$exp_month = $_POST['ec_expiration_month'];
					$exp_year = $_POST['ec_expiration_year'];
					$security_code = $_POST['ec_security_code'];
					
					// CREATE ACCOUNT IF NEEDED
					if( isset( $_POST['ec_contact_email'] ) ){
						$email = $_POST['ec_contact_email'];
						$_SESSION['ec_email'] = $email;
					}
					
					if( isset( $_POST['ec_contact_email'] ) && !$create_account ){
						$_SESSION['ec_is_guest'] = true;
						$_SESSION['ec_guest_key'] = $_SESSION['ec_cart_id'];
					}else{
						$_SESSION['ec_is_guest'] = false;
					}
					
					if( $create_account ){
						$email = $_POST['ec_contact_email'];
						$password = md5( $_POST['ec_contact_password'] );
						
						// INSERT USER
						$billing_id = $this->mysqli->insert_address( $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $billing_company_name );
						
						$shipping_id = $this->mysqli->insert_address( $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone, $shipping_company_name );
						
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
							
						}
					}
					// END CREATE ACCOUNT
					
					// Set Sessions
					$_SESSION['ec_billing_first_name'] = $billing_first_name;
					$_SESSION['ec_billing_last_name'] = $billing_last_name;
					$_SESSION['ec_billing_company_name'] = $billing_company_name;
					$_SESSION['ec_billing_address'] = $billing_address;
					$_SESSION['ec_billing_address2'] = $billing_address2;
					$_SESSION['ec_billing_city'] = $billing_city;
					$_SESSION['ec_billing_state'] = $billing_state;
					$_SESSION['ec_billing_zip'] = $billing_zip;
					$_SESSION['ec_billing_country'] = $billing_country;
					$_SESSION['ec_billing_phone'] = $billing_phone;
					
					$_SESSION['ec_shipping_selector'] = $shipping_selector;
					
					$_SESSION['ec_shipping_first_name'] = $shipping_first_name;
					$_SESSION['ec_shipping_last_name'] = $shipping_last_name;
					$_SESSION['ec_shipping_company_name'] = $shipping_company_name;
					$_SESSION['ec_shipping_address'] = $shipping_address;
					$_SESSION['ec_shipping_address2'] = $shipping_address2;
					$_SESSION['ec_shipping_city'] = $shipping_city;
					$_SESSION['ec_shipping_state'] = $shipping_state;
					$_SESSION['ec_shipping_zip'] = $shipping_zip;
					$_SESSION['ec_shipping_country'] = $shipping_country;
					$_SESSION['ec_shipping_phone'] = $shipping_phone;
					
					$_SESSION['ec_first_name'] = $first_name;
					$_SESSION['ec_last_name'] = $last_name;
					
					$_SESSION['ec_order_notes'] = $order_notes;
					
					// Setup for processing
					$user = new ec_user( "" );
					$user->setup_billing_info_data( $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_country, $billing_zip, $billing_phone, $billing_company_name );
					$user->setup_shipping_info_data( $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_country, $shipping_zip, $shipping_phone, $shipping_company_name );
					$card = new ec_credit_card( $payment_method, $card_holder_name, $card_number, $exp_month, $exp_year, $security_code );
					$product = new ec_product( $products[0] );
					$stripe = new ec_stripe( );
					$customer_id = $user->stripe_customer_id;
					
					// Tests vars
					$need_to_update_customer_id = false;
					$customer_insert_test = false;
					
					if( $customer_id == "" ){
						$customer_id = $stripe->insert_customer( $user );
						$need_to_update_customer_id = true;
					}
					
					if( $need_to_update_customer_id && $customer_id ){ // Customer inserted to stripe successfully
						$this->mysqli->update_user_stripe_id( $user->user_id, $customer_id );
						$user->stripe_customer_id = $customer_id;
						$customer_insert_test = true;
					}else if( $need_to_update_customer_id && !$customer_id ){
						$customer_insert_test = false;
					}else{
						$customer_insert_test = true;
					}
					
					if( $customer_insert_test ){ // Customer inserted successfully (OR didn't need to be inserted)
						
						$card_result = $stripe->insert_card( $user, $card );
							
						
						if( $card_result ){ //Card Submitted Successfully
							
							$plan_added = $product->stripe_plan_added;
							
							if( !$product->stripe_plan_added ){ // Add plan if needed
								$plan_added = $stripe->insert_plan( $product );
								$this->mysqli->update_product_stripe_added( $product->product_id );
							}
							
							if( $plan_added ){ // Plan added successfully
							
								$stripe_response = $stripe->insert_subscription( $product, $user, $card, $coupon );
								
								if( $stripe_response ){ // Subscription added successfully
									
									$subscription_id = $this->mysqli->insert_stripe_subscription( $stripe_response, $product, $user, $card );
									$subscription_row = $this->mysqli->get_subscription_row( $subscription_id );
									$order_id = $this->mysqli->insert_subscription_order( $product, $user, $card, $subscription_id, $coupon_row->promocode_id, $order_notes, $this->subscription_option1_name, $this->subscription_option2_name, $this->subscription_option3_name, $this->subscription_option4_name, $this->subscription_option5_name, $this->subscription_option1_label, $this->subscription_option2_label, $this->subscription_option3_label, $this->subscription_option4_label, $this->subscription_option5_label );
									$this->mysqli->update_user_default_card( $user, $card );
									
									$subscription = new ec_subscription( $subscription_row );
									$order_row = $this->mysqli->get_order_row( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
									$order = new ec_orderdisplay( $order_row );
									$order_details = $this->mysqli->get_order_details( $order_id, $_SESSION['ec_email'], $_SESSION['ec_password'] );
									$subscription->send_email_receipt( $user, $order, $order_details );
									$this->mysqli->update_product_stock( $product->product_id, 1 );
									
									// Unset Variables Entered
									unset( $_SESSION['ec_subscription_option1'] );
									unset( $_SESSION['ec_subscription_option2'] );
									unset( $_SESSION['ec_subscription_option3'] );
									unset( $_SESSION['ec_subscription_option4'] );
									unset( $_SESSION['ec_subscription_option5'] );
									
									$i=0;
									while( isset( $_SESSION['ec_subscription_advanced_option' . $i] ) ){
										unset( $_SESSION['ec_subscription_advanced_option' . $i] );
										$i++;
									}
									
									unset( $_SESSION['ec_billing_first_name'] );
									unset( $_SESSION['ec_billing_last_name'] );
									unset( $_SESSION['ec_billing_address'] );
									unset( $_SESSION['ec_billing_address2'] );
									unset( $_SESSION['ec_billing_city'] );
									unset( $_SESSION['ec_billing_state'] );
									unset( $_SESSION['ec_billing_zip'] );
									unset( $_SESSION['ec_billing_country'] );
									unset( $_SESSION['ec_billing_phone'] );
									
									unset( $_SESSION['ec_shipping_selector'] );
									unset( $_SESSION['ec_shipping_first_name'] );
									unset( $_SESSION['ec_shipping_last_name'] );
									unset( $_SESSION['ec_shipping_address'] );
									unset( $_SESSION['ec_shipping_address2'] );
									unset( $_SESSION['ec_shipping_city'] );
									unset( $_SESSION['ec_shipping_state'] );
									unset( $_SESSION['ec_shipping_zip'] );
									unset( $_SESSION['ec_shipping_country'] );
									unset( $_SESSION['ec_shipping_phone'] );
									
									unset( $_SESSION['ec_use_shipping'] );
									unset( $_SESSION['ec_shipping_method'] );
									unset( $_SESSION['ec_expedited_shipping'] ); 
									
									if( !isset( $_SESSION['ec_user_id'] ) ){
										unset( $_SESSION['ec_email'] );
										unset( $_SESSION['ec_first_name'] );
										unset( $_SESSION['ec_last_name'] );
									}
									
									unset( $_SESSION['ec_create_account'] );
									unset( $_SESSION['ec_couponcode'] );
									unset( $_SESSION['ec_giftcard'] );
									unset( $_SESSION['ec_order_notes'] );
									unset( $_SESSION['ec_cart_id'] );
									unset( $_COOKIE['ec_cart_id'] );
									$vals = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
									$_SESSION['ec_cart_id'] = $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)];
									setcookie( 'ec_cart_id', $_SESSION['ec_cart_id'], time( ) + ( 3600 * 24 * 30 ) );
									
									header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $order_id );	
								
								}else{
									header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=subscription_failed" );	
								
								}// Close check for subscription insertion
								
							}else{
								header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=subscription_added_failed" );
							
							}// Close check for stripe plan insertion
							
						}else{
							header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=card_error" );
						
						}// Close check for card insertion
					
					}else{
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=user_insert_error" );
					
					}// Close check for customer insertion to stripe check
			
				}else{
					header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=already_subscribed" );
				
				}// Close check for already subscribed error
			
			}else{
				
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=subscription_not_found" );
				
			}// Close check for subscription existing
			
		}else{
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=email_exists" );
			
		}// Close user exists error for guest checkout
		
	}
	
	private function process_send_inquiry( ){
		
		$inquiry_email = $_POST['inquiry_email'];
		$inquiry_name = $_POST['inquiry_name'];
		$inquiry_message = $_POST['inquiry_message'];
		$model_number = $_POST['inquiry_model_number'];
		if( isset( $_POST['inquiry_send_copy'] ) )
			$send_copy = true;
		else
			$send_copy = false;
		
		$product = $this->mysqli->get_product( $model_number );
		
		if( $product && $inquiry_email != "" && $inquiry_name != "" && $inquiry_message != "" ){
			
			// Create mail script
			$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
			
			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-Type: text/html; charset=utf-8";
			$headers[] = "From: " . get_option( 'ec_option_password_from_email' );
			$headers[] = "Reply-To: " . get_option( 'ec_option_password_from_email' );
			$headers[] = "X-Mailer: PHP/".phpversion();
			
			ob_start();
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php' ) )	
				include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php';	
			else
				include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php';
			$message = ob_get_clean();
			
			if( get_option( 'ec_option_use_wp_mail' ) ){
				if( $send_copy )
					wp_mail( $inquiry_email, "New Product Inquiry", $message, implode("\r\n", $headers) );
				
				wp_mail( get_option( 'ec_option_bcc_email_addresses' ), "New Product Inquiry", $message, implode("\r\n", $headers) );
			}else{
				if( $send_copy )
					mail( $inquiry_email, "New Product Inquiry", $message, implode("\r\n", $headers) );
				
				mail( get_option( 'ec_option_bcc_email_addresses' ), "New Product Inquiry", $message, implode("\r\n", $headers) );
			}
			
			header( "location: " . $this->store_page . $this->permalink_divider . "ec_store_success=inquiry_sent" );
			
		}
		
	}
	
	private function process_deconetwork_add_to_cart( ){
		
		$this->mysqli->deconetwork_add_to_cart( );
		header( "location: " . $this->cart_page );
	
	}
	
	public function process_subscribe_v3( ){
		
		$product_id = $_POST['product_id'];
		$cart_id = $_SESSION['ec_cart_id'];
		$product = $this->mysqli->get_product( "", $product_id );
		$use_advanced_optionset = $product->use_advanced_optionset;
			
		//Product Options
		unset( $_SESSION['ec_subscription_option1'] );
		unset( $_SESSION['ec_subscription_option2'] );
		unset( $_SESSION['ec_subscription_option3'] );
		unset( $_SESSION['ec_subscription_option4'] );
		unset( $_SESSION['ec_subscription_option5'] );
		
		if( !$use_advanced_optionset ){
			
			if( isset( $_POST['ec_option1'] ) )				$_SESSION['ec_subscription_option1'] = $_POST['ec_option1'];
			else											unset( $_SESSION['ec_subscription_option1'] );
			
			if( isset( $_POST['ec_option2'] ) )				$_SESSION['ec_subscription_option2'] = $_POST['ec_option2'];
			else											unset( $_SESSION['ec_subscription_option2'] );
			
			
			if( isset( $_POST['ec_option3'] ) )				$_SESSION['ec_subscription_option3'] = $_POST['ec_option3'];
			else											unset( $_SESSION['ec_subscription_option3'] );
			
			
			if( isset( $_POST['ec_option4'] ) )				$_SESSION['ec_subscription_option4'] = $_POST['ec_option4'];
			else											unset( $_SESSION['ec_subscription_option4'] );
			
			
			if( isset( $_POST['ec_option5'] ) )				$_SESSION['ec_subscription_option5'] = $_POST['ec_option5'];
			else											unset( $_SESSION['ec_subscription_option5'] );
			
		}
		
		if( $use_advanced_optionset ){
			
			$option_vals = $this->get_advanced_option_vals( $product_id, $cart_id );
			
		}
		
		$i=0;
		while( isset( $_SESSION['ec_subscription_advanced_option' . $i] ) ){
			unset( $_SESSION['ec_subscription_advanced_option' . $i] );
			$i++;
		}
		
		for( $i=0; $i<count( $option_vals ); $i++ ){
			$_SESSION['ec_subscription_advanced_option' . $i] = $option_vals[$i];
		}
		
		header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $product->model_number );
		
	}
	/* END PROCESS FORM SUBMISSION FUNCTIONS */
	
	/* Customer File Upload Function */
	private function upload_customer_file( $tempcart_id, $upload_field_name ){
		
		# Check to see if the file is accessible
		if( isset($_FILES[$upload_field_name]['name']) && $_FILES[$upload_field_name]['name'] != '' ) {
			$max_filesize = 999999;
			$filetypes = array( 'text/plain', 'image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip', 'application/x-bzip2', 'application/x-bzip', 'application/x-bzip2', 'application/x-gzip', 'application/x-gzip', 'multipart/x-gzip' );
			if( is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" ) )
				$upload_path =  WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/";
			else
				$upload_path =  WP_PLUGIN_DIR . "/wp-easycart/products/uploads/";
		 
			# Check to see if the filesize is too large
			if( $_FILES[$upload_field_name]['size'] <= $max_filesize && in_array( $_FILES[$upload_field_name]['type'], $filetypes ) ){
				
				# Create a custom dir for this order
				mkdir( $upload_path . $tempcart_id . "/", 0711 );
				
				# If file has gotten this far, it is successful
				$copy_to = $upload_path . $tempcart_id . "/" . $_FILES[$upload_field_name]['name'];
		
				# Upload the file
				$upload = move_uploaded_file( $_FILES[$upload_field_name]['tmp_name'], $copy_to );
		 
				# Check to see if upload was successful
				if( $upload ){
					return true;
				}
			}
		}
		return false;
	}
	
	private function sanatize_card_number( $card_number ){
		
		return preg_replace( "/[^0-9]/", "", $card_number );
	
	}
	
	private function get_payment_type( $card_number ){
		
		if (ereg("^5[1-5][0-9]{14}$", $card_number))
                return "mastercard";
 
        else if (ereg("^4[0-9]{12}([0-9]{3})?$", $card_number))
                return "visa";
 
        else if (ereg("^3[47][0-9]{13}$", $card_number))
                return "amex";
 
        else if (ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$", $card_number))
                return "diners";
 
        else if (ereg("^6011[0-9]{12}$", $card_number))
                return "discover";
 
        else if (ereg("^(3[0-9]{4}|2131|1800)[0-9]{11}$", $card_number))
                return "jcb";
				
		else
				return "Credit Card";
		
	}
	
	public function display_order_number_link( $order_id ){
		if( isset( $_SESSION['ec_password'] ) && $_SESSION['ec_password'] == "guest" ){
			echo $order_id;
		}else{
			echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&order_id=" . $order_id . "\">" . $order_id . "</a>";
		}
	}
	
	public function get_shipping_method_name( ){
		return $this->mysqli->get_shipping_method_name( $_SESSION['ec_shipping_method'] );
	}
	
}

?>