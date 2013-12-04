<?php

class ec_orderdetail{
	protected $mysqli;									// ec_db structure
	
	public $orderdetail_id; 							// INT
	public $order_id;  									// INT
	public $product_id;  								// INT
	public $title;  									// VARCHAR 255
	public $model_number;   							// VARCHAR 255
	public $order_date;       							// DATETIME
	public $unit_price;       							// FLOAT 7,2 
	public $total_price;        						// FLOAT 7,2
	public $quantity;        							// INT
	public $image1;   									// VARCHAR 255
	public $optionitem_name_1;   						// VARCHAR 128
	public $optionitem_name_2;    						// VARCHAR 128
	public $optionitem_name_3;    						// VARCHAR 128
	public $optionitem_name_4;    						// VARCHAR 128
	public $optionitem_name_5;    						// VARCHAR 128
	public $optionitem_label_1;   						// VARCHAR 128
	public $optionitem_label_2;    						// VARCHAR 128
	public $optionitem_label_3;    						// VARCHAR 128
	public $optionitem_label_4;    						// VARCHAR 128
	public $optionitem_label_5;    						// VARCHAR 128
	public $optionitem_price_1;   						// FLOAT 13,3
	public $optionitem_price_2;    						// FLOAT 13,3
	public $optionitem_price_3;    						// FLOAT 13,3
	public $optionitem_price_4;    						// FLOAT 13,3
	public $optionitem_price_5;    						// FLOAT 13,3
	public $use_advanced_optionset;						// BOOL
	public $giftcard_id;    							// VARCHAR 20
	public $gift_card_message;     						// TEXT
	public $gift_card_from_name;     					// VARCHAR 255
	public $gift_card_to_name;      					// VARCHAR 255
	public $is_download;      							// BOOL
	public $is_giftcard;       							// BOOL
	public $is_taxable;       							// BOOL
	public $download_file_name;       					// VARCHAR 255
	public $download_id;      							// VARCHAR 255
	public $maximum_downloads_allowed;       			// INT
	public $download_timelimit_seconds;      			// INT
	
	public $custom_vars = array();						// Array
	
	private $download;									// ec_download object
	public $timecheck;
	public $download_count;
	
	public $customfields = array();						// array of ec_customfield objects
	
	function __construct( $orderdetail_row, $download_now = 0 ){
		$this->mysqli = new ec_db( );
		
		$this->orderdetail_id = $orderdetail_row->orderdetail_id; 
		$this->order_id = $orderdetail_row->order_id; 
		$this->product_id = $orderdetail_row->product_id; 
		$this->title = $orderdetail_row->title; 
		$this->model_number = $orderdetail_row->model_number; 
		$this->order_date = $orderdetail_row->order_date; 
		$this->unit_price = $orderdetail_row->unit_price; 
		$this->total_price = $orderdetail_row->total_price; 
		$this->quantity = $orderdetail_row->quantity; 
		$this->image1 = $orderdetail_row->image1; 
		$this->optionitem_name_1 = $orderdetail_row->optionitem_name_1; 
		$this->optionitem_name_2 = $orderdetail_row->optionitem_name_2; 
		$this->optionitem_name_3 = $orderdetail_row->optionitem_name_3; 
		$this->optionitem_name_4 = $orderdetail_row->optionitem_name_4; 
		$this->optionitem_name_5 = $orderdetail_row->optionitem_name_5; 
		$this->optionitem_label_1 = $orderdetail_row->optionitem_label_1; 
		$this->optionitem_label_2 = $orderdetail_row->optionitem_label_2; 
		$this->optionitem_label_3 = $orderdetail_row->optionitem_label_3; 
		$this->optionitem_label_4 = $orderdetail_row->optionitem_label_4; 
		$this->optionitem_label_5 = $orderdetail_row->optionitem_label_5; 
		$this->optionitem_price_1 = $orderdetail_row->optionitem_price_1; 
		$this->optionitem_price_2 = $orderdetail_row->optionitem_price_2; 
		$this->optionitem_price_3 = $orderdetail_row->optionitem_price_3; 
		$this->optionitem_price_4 = $orderdetail_row->optionitem_price_4; 
		$this->optionitem_price_5 = $orderdetail_row->optionitem_price_5; 
		$this->use_advanced_optionset = $orderdetail_row->use_advanced_optionset;
		$this->giftcard_id = $orderdetail_row->giftcard_id; 
		$this->gift_card_message = $orderdetail_row->gift_card_message; 
		$this->gift_card_from_name = $orderdetail_row->gift_card_from_name; 
		$this->gift_card_to_name = $orderdetail_row->gift_card_to_name; 
		$this->is_download = $orderdetail_row->is_download; 
		$this->is_giftcard = $orderdetail_row->is_giftcard; 
		$this->is_taxable = $orderdetail_row->is_taxable; 
		$this->download_file_name = $orderdetail_row->download_file_name; 
		$this->download_id = $orderdetail_row->download_key;
		$this->maximum_downloads_allowed = $orderdetail_row->maximum_downloads_allowed;
		$this->download_timelimit_seconds = $orderdetail_row->download_timelimit_seconds;
		
		if( isset( $GLOBALS['ec_hooks']['ec_extra_cartitem_vars'] ) ){
			for( $i=0; $i<count( $GLOBALS['ec_hooks']['ec_extra_cartitem_vars'] ); $i++ ){
				$arr = $GLOBALS['ec_hooks']['ec_extra_cartitem_vars'][$i][0]( array( ), array( ) );
				for( $j=0; $j<count( $arr ); $j++ ){
					$this->custom_vars[ $arr[$j] ] =  $orderdetail_row->{$arr[$j]};
				}
			}
		}
		
		if( $this->is_download ){
			$this->download = $this->mysqli->get_download( $this->download_id );
			$this->timecheck = date('U') - $this->download->date_created_timestamp;
			$this->download_count = $this->download->download_count;
		}
		
		$accountpageid = get_option('ec_option_accountpage');
		$this->account_page = get_permalink( $accountpageid );
		
		if( substr_count( $this->account_page, '?' ) )				$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		if( isset( $_GET['orderdetail_id'] ) && $_GET['orderdetail_id'] == $this->orderdetail_id && 
			isset( $_GET['download_id'] ) && $_GET['download_id'] == $this->download_id && 
			$download_now ){
			
			$this->start_download( );
			
		}
		
		$customfield_data_array = explode( "---", $orderdetail_row->customfield_data );
		for( $i=0; $i<count( $customfield_data_array ); $i++ ){
			$temp_arr = explode("***", $customfield_data_array[$i]);
			array_push($this->customfields, $temp_arr);
		}
	}
	
	public function display_order_item_id( ){
		echo $this->orderdetail_id;	
	}
	
	public function display_image( $size ){
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/" . $this->image1 ) )	
			echo "<img src=\"" . plugins_url( "wp-easycart-data/products/pics1/" . $this->image1 ) . "\" alt=\"" . $this->model_number . "\" />";	
		else
			echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/products/pics1/" . $this->image1 ) . "\" alt=\"" . $this->model_number . "\" />";
	}
	
	public function display_title( ){
		echo $this->title;
	}
	
	public function has_option1( ){
		if( $this->optionitem_name_1 != "" )
			return true;
		else
			return false;
	}
	
	public function display_option1( ){
		if( $this->optionitem_name_1 != "" )
			echo $this->optionitem_name_1;
	}
	
	public function display_option1_label( ){
		if( $this->optionitem_label_1 != "" )
			echo $this->optionitem_label_1;	
	}
	
	public function has_option1_price( ){
		if( $this->optionitem_price_1 != "0.00" )
			return true;
		else
			return false;
	}
	
	public function display_option1_price( ){
		echo $GLOBALS['currency']->get_currency_display( $this->optionitem_price_1 );
	}
	
	public function has_option2( ){
		if( $this->optionitem_name_2 != "" )
			return true;
		else
			return false;
	}
	
	public function display_option2( ){
		if( $this->optionitem_name_2 != "" )
			echo $this->optionitem_name_2;
	}
	
	public function display_option2_label( ){
		if( $this->optionitem_label_2 != "" )
			echo $this->optionitem_label_2;	
	}
	
	public function has_option2_price( ){
		if( $this->optionitem_price_2 != "0.00" )
			return true;
		else
			return false;
	}
	
	public function display_option2_price( ){
		echo $GLOBALS['currency']->get_currency_display( $this->optionitem_price_2 );
	}
	
	public function has_option3( ){
		if( $this->optionitem_name_3 != "" )
			return true;
		else
			return false;
	}
	
	public function display_option3( ){
		if( $this->optionitem_name_3 != "" )
			echo $this->optionitem_name_3;
	}
	
	public function display_option3_label( ){
		if( $this->optionitem_label_3 != "" )
			echo $this->optionitem_label_3;	
	}
	
	public function has_option3_price( ){
		if( $this->optionitem_price_3 != "0.00" )
			return true;
		else
			return false;
	}
	
	public function display_option3_price( ){
		echo $GLOBALS['currency']->get_currency_display( $this->optionitem_price_3 );
	}
	
	public function has_option4( ){
		if( $this->optionitem_name_4 != "" )
			return true;
		else
			return false;
	}
	
	public function display_option4( ){
		if( $this->optionitem_name_4 != "" )
			echo $this->optionitem_name_4;
	}
	
	public function display_option4_label( ){
		if( $this->optionitem_label_4 != "" )
			echo $this->optionitem_label_4;	
	}
	
	public function has_option4_price( ){
		if( $this->optionitem_price_4 != "0.00" )
			return true;
		else
			return false;
	}
	
	public function display_option4_price( ){
		echo $GLOBALS['currency']->get_currency_display( $this->optionitem_price_4 );
	}
	
	public function has_option5( ){
		if( $this->optionitem_name_5 != "" )
			return true;
		else
			return false;
	}
	
	public function display_option5( ){
		if( $this->optionitem_name_5 != "" )
			echo $this->optionitem_name_5;
	}
	
	public function display_option5_label( ){
		if( $this->optionitem_label_5 != "" )
			echo $this->optionitem_label_5;	
	}
	
	public function has_option5_price( ){
		if( $this->optionitem_price_5 != "0.00" )
			return true;
		else
			return false;
	}
	
	public function display_option5_price( ){
		echo $GLOBALS['currency']->get_currency_display( $this->optionitem_price_5 );
	}
	
	public function has_gift_card_message( ){
		if( $this->is_giftcard )
			return true;
		else
			return false;
	}
	
	public function display_gift_card_message( $label_text ){
		if( $this->is_giftcard )
			echo $label_text . $this->gift_card_message;
	}
	
	public function has_gift_card_from_name( ){
		if( $this->is_giftcard )
			return true;
		else
			return false;
	}
	
	public function display_gift_card_from_name( $label_text ){
		if( $this->is_giftcard )
			echo $label_text . $this->gift_card_from_name;
	}
	
	public function has_gift_card_to_name( ){
		if( $this->is_giftcard )
			return true;
		else
			return false;
	}
	
	public function display_gift_card_to_name( $label_text ){
		if( $this->is_giftcard )
			echo $label_text . $this->gift_card_to_name;
	}
	
	public function display_gift_card_id( $label_text ){
		if( $this->is_giftcard )
			echo $label_text . $this->giftcard_id;
	}
	
	public function has_print_gift_card_link( ){
		if( $this->is_giftcard )
			return true;
		else
			return false;
	}
	
	public function display_print_online_link( $link_text ){
		if( $this->is_giftcard )
			echo "<a href=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/print_giftcard.php?order_id=" . $this->order_id ) . "&amp;orderdetail_id=" . $this->orderdetail_id ."&amp;giftcard_id=" . $this->giftcard_id . "\" target=\"_blank\">" . $link_text . "</a>";
	}
	
	public function display_unit_price( ){
		echo $GLOBALS['currency']->get_currency_display( $this->unit_price );
	}
	
	public function display_quantity( ){
		echo $this->quantity;
	}
	
	public function display_item_total( ){
		echo $GLOBALS['currency']->get_currency_display( $this->total_price );
	}
	
	public function display_custom_fields( $divider, $seperator ){
		for( $i=0; $i<count( $this->customfields ) && count( $this->customfields[$i] ) == 3; $i++ ){
			echo $this->customfields[$i][1] . $divider . " " . $this->customfields[$i][2] . $seperator;
		}
	}
	
	public function has_download_link( ){
		if( $this->is_download )
			return true;
		else
			return false;
	}
	
	public function display_download_link( $link_text ){
		if( $this->is_download )
			echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&amp;order_id=" . $this->order_id . "&amp;orderdetail_id=" . $this->orderdetail_id . "&amp;download_id=" . $this->download_id . "\" class=\"ec_account_dashboard_link\" onclick=\"update_download_count( '" . $this->orderdetail_id . "' );\">" . $link_text . "</a>";
	}
	
	public function display_download_error( ){
		if( $this->is_download ){
			if( $this->download_timelimit_seconds > 0 && $this->timecheck >= $this->download_timelimit_seconds )
				echo "<div class=\"ec_account_error\"><div>The download has expired because you have exceeded the length of time that you have to access and download this product.</div></div>";
	
			else if ($this->maximum_downloads_allowed > 0 && $this->download_count >= $this->maximum_downloads_allowed)
				echo "<div class=\"ec_account_error\"><div>The download key has expired because you have exceeded your download limit set for this product.</div></div>";	
		}
	}
	
	public function get_download_expire_date( $date_format ){
		$date = new DateTime();
		$seconds_remaining = $this->download_timelimit_seconds - $this->timecheck;
		if( $seconds_remaining < 0 ){
			$seconds_remaining = ( $seconds_remaining * -1 );
			$date->sub( new DateInterval('PT' . $seconds_remaining . 'S' ) );
		}else
			$date->add( new DateInterval('PT' . $seconds_remaining . 'S' ) );
			
		return $date->format( $date_format );
	}
	
	private function start_download( ){
		if( $this->is_download ){
			
			$this->download_count++;
			
			if( ( $this->download_timelimit_seconds == 0 || $this->timecheck <= $this->download_timelimit_seconds ) && 
				( $this->maximum_downloads_allowed  == 0 || $this->download_count <= $this->maximum_downloads_allowed  ) ) {
	
				ob_start();
				$mm_type="application/octet-stream";
				if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/" . $this->download->download_file_name ) )	
					$file = WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/" . $this->download->download_file_name;
				else
					$file = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/products/downloads/" . $this->download->download_file_name;
				
				$ext = substr( $this->download->download_file_name, strrpos( $this->download->download_file_name, '.' ) + 1);
				
				$date = new DateTime();
				$time_stamp = $date->getTimestamp();
				
				$filename_arr = explode( "_", $this->download->download_file_name );
				$file_start_name = "";
				for( $i=0; $i<count($filename_arr)-1; $i++ ){
					if( $i>0 )
						$file_start_name .= "_";
					$file_start_name .= $filename_arr[$i];
				}
				
				$filename = $file_start_name . "_" . $time_stamp . "." . $ext;
				
				header( "Cache-Control: public, must-revalidate" );
				header( "Pragma: no-cache" );
				header( "Content-Type: " . $mm_type );
				header( "Content-Length: " . ( string )( filesize( $file ) ) );
				header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
				header( "Content-Transfer-Encoding: binary\n" );
				ob_end_clean();
				
				readfile( $file );
				
				$this->mysqli->update_download_count( $this->download_id, $this->download_count );
	
			}
		}
	}	
}