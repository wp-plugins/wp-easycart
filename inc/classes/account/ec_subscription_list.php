<?php

class ec_subscription_list{
	
	private $user;
	
	public $subscription_list;
	
	private $account_page;						// VARCHAR
	private $permalink_divider;					// CHAR
	
	function __construct( $user ){
		$this->user = $user;
		
		$this->set_subscription_list( );
		
		$accountpageid = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $accountpageid );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->account_page = $https_class->getHttpsUrl( ) . substr( $this->account_page, strlen( get_option( 'home' ) ) );
		}
		
		if( substr_count( $this->account_page, '?' ) )				$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
	}
	
	private function set_subscription_list( ){
		// Initial VARS
		$payment_procesor = get_option( 'ec_option_payment_process_method' );
		$this->subscription_list = array( );
		$data = "";
		
		// Setup for stripe
		if( $payment_procesor == "stripe" ){
			$stripe = new ec_stripe( );
			$data = $stripe->get_active_subscription_list( $this->user );
			
			if( !$data->error ){
			
				foreach( $data->data as $subscription_row ){
					$this->subscription_list[] = new ec_subscription( $subscription_row );
				}
				
			}
		}
	}
	
	///////////////////////////////////////////////////
	// Display Functions
	///////////////////////////////////////////////////
	
	public function display_subscription_list( ){
		
		$i=0;
		if( count( $this->subscription_list ) > 0 ){
			
			foreach( $this->subscription_list as $subscription ){
				if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_account_subscription_line.php' ) )	
					include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option('ec_option_base_layout') . '/ec_account_subscription_line.php' );
				else if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_account_subscription_line.php' ) )
					include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_account_subscription_line.php' );
			
				$i++;
			}
			
		}else{
			
			echo "<div class=\"ec_subscription_none_found\">" . $GLOBALS['language']->get_text( 'account_subscriptions', 'account_subscriptions_none_found' ) . "</div>";
			
		}
		
	}
	
}

?>