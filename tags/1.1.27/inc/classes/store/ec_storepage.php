<?php

class ec_storepage{
	
	private $is_details;									// BOOL
	private $product_list;									// ec_productlist structure
	private $product;										// ec_product structure
	private $model_number;									// VARCHAR 255
	private $optionitem_id;									// INT
	
	public $previous_model_number;							// VARCHAR 255
	public $number_in_product_list;							// INT
	public $count_of_product_list;							// INT
	public $next_model_number;								// VARCHAR 255
	private $store_page;
	private $permalink_divider;
	
	////////////////////////////////////////////////////////
	// CONSTUCTOR FUNCTION
	////////////////////////////////////////////////////////
	function __construct( $menuid = "NOMENU", $submenuid = "NOSUBMENU", $subsubmenuid = "NOSUBSUBMENU", $manufacturerid = "NOMANUFACTURER", $groupid = "NOGROUP" ){
		
		$this->is_details = $this->get_is_details( );
		if(	!$this->is_details )											$this->setup_products(  $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid );
		else{												
																			$this->model_number = $_GET['model_number'];
			if( isset( $_GET['optionitem_id'] ) )
																			$this->optionitem_id = $_GET['optionitem_id'];
			else
																			$this->optionitem_id = 0;
																			$this->setup_details( );
		}
		
		$storepageid = get_option( 'ec_option_storepage' );
		$this->store_page = get_permalink( $storepageid );
		
		if( substr_count( $this->store_page, '?' ) )						$this->permalink_divider = "&";
		else																$this->permalink_divider = "?";
	}

	////////////////////////////////////////////////////////
	// STORE PAGE SETUP FUNCTIONS
	////////////////////////////////////////////////////////
	private function setup_products( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid ){
		
		$this->product_list = new ec_productlist( false, $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid );
	
	}
	
	private function setup_details( ){
		
		$this->product_list = new ec_productlist( true );
		if( $this->product_list->num_products > 0 ){
			
			$this->previous_model_number = "";
			$this->number_in_product_list = 0;
			$this->count_of_product_list = count( $this->product_list->products );
			$this->next_model_number = "";
			
			// Find current product
			for( $i=0; $i< count( $this->product_list->products ); $i++ ){
				if( $this->product_list->products[$i]->model_number == $this->model_number )
					$this->number_in_product_list = $i+1;
				else if( $this->number_in_product_list == 0 )
					$this->previous_model_number = $this->product_list->products[$i]->model_number;
				
				if( $this->number_in_product_list > 0 && ($i+1) != $this->number_in_product_list && $this->next_model_number == ""  )
					$this->next_model_number = $this->product_list->products[$i]->model_number;
					
			}
			
			$this->product = $this->product_list->products[$this->number_in_product_list-1];
		
		}else{
			
			global $wp_query;
			$wp_query->is_404 = true;
			$wp_query->is_single = false;
			$wp_query->is_page = false;
			
			include( get_query_template( '404' ) );
			exit();
				
		}
		
	}
	
	////////////////////////////////////////////////////////
	// STORE PAGE MAIN DISPLAY FUNCTIONS
	////////////////////////////////////////////////////////
	public function display_store_page( ){
		if(	!$this->is_details )							$this->display_products_page( );
		else												$this->display_product_details_page( );
	}
	
	private function display_products_page( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_product_page.php' );	
	}
	
	public function has_products( ){
		if( count( $this->product_list->products ) > 0 )
			return true;
		else
			return false;
	}
	
	private function display_product_details_page( ){
		$storepageid = get_option('ec_option_storepage');
		$cartpageid = get_option('ec_option_cartpage');
		$accountpageid = get_option('ec_option_accountpage');
		
		$storepage = get_permalink( $storepageid );
		$cartpage = get_permalink( $cartpageid );
		$accountpage = get_permalink( $accountpageid );
		
		if(substr_count($storepage, '?'))							$permalinkdivider = "&";
		else														$permalinkdivider = "?";
		
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_product_details_page.php' );
		echo "<script>ec_initialize_options();</script>";
	}
	
	////////////////////////////////////////////////////////
	// PRODUCT MENU FILTER BAR DISPLAY FUNCTIONS
	////////////////////////////////////////////////////////
	private function product_menu_filter( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_product_menu_filter.php' );	
	}
	
	private function product_filter_menu_items( $divider ){
		$this->product_list->display_filter_menu( $divider );
	}
	
	////////////////////////////////////////////////////////
	// PRODUCT FILTER AND PAGESET BAR DISPLAY FUNCTIONS
	////////////////////////////////////////////////////////
	private function product_filter_bar( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_product_filter_bar.php' );	
	}
	
	private function product_filter_combo( ){
		$this->product_list->display_filter_combo( );
	}
	
	private function product_items_per_page( $divider ){
		$this->product_list->display_items_per_page( $divider );
	}
	
	private function product_current_page( ){
		$this->product_list->display_current_page( );
	}
	
	private function product_total_pages( ){
		$this->product_list->display_total_pages( );
	}
	
	private function product_paging( $divider ){
		$this->product_list->display_product_paging( $divider );
	}
	
	////////////////////////////////////////////////////////
	// PRODUCT DISPLAY FUNCTIONS
	////////////////////////////////////////////////////////
	private function product_list( ){
		$this->product_list->display_product_list( );
	}
	
	////////////////////////////////////////////////////////
	// PRODUCT DETAILS DISPLAY FUNCTIONS
	////////////////////////////////////////////////////////
	private function product_details_title( ){
		echo $this->product->display_product_details_title_link();
	}
	
	private function product_details_price( ){
		$this->product->display_product_details_pricing();
	}
	
	private function product_details_discount_percentage( $text1, $text2 ){
		$this->product->display_product_details_discount_percentage( $text1, $text2 );	
	}
	
	private function product_details_rating( ){
		$this->product->display_product_details_rating( );	
	}
	
	private function product_details_number_reviews( ){
		$this->product->display_product_details_number_reviews( );	
	}
	
	private function product_details_option1( ){
		$this->product->product_details_option1_swatches( );	
	}
	
	private function product_details_option2( ){
		$this->product->product_details_option2_swatches( );	
	}
	
	private function product_details_option3( ){
		$this->product->product_details_option3_swatches( );	
	}
	
	private function product_details_option4( ){
		$this->product->product_details_option4_swatches( );	
	}
	
	private function product_details_option5( ){
		$this->product->product_details_option5_swatches( );	
	}
	
	public function display_product_previous_category_link( $link_text ){
		if( $this->previous_model_number != "" && $this->product->product_id )
			echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->previous_model_number . $this->product->get_additional_link_options() . "\" class=\"ec_product_title_link\">" . $link_text . "</a>";
		else
			echo $link_text;
	}
	
	public function display_product_number_in_category_list( ){
		echo $this->number_in_product_list;
	}
	
	public function display_product_count_in_category_list( ){
		echo $this->count_of_product_list;
	}
	
	public function display_product_next_category_link( $link_text ){
		if( $this->next_model_number )
		echo "<a href=\"" . $this->store_page . $this->permalink_divider . "model_number=" . $this->next_model_number . $this->product->get_additional_link_options() . "\" class=\"ec_product_title_link\">" . $link_text . "</a>";
		else
		echo $link_text;
	}
	
	public function display_optional_banner( ){
		$menu_level = $this->product_list->filter->get_menu_level( );
		if( $menu_level == 1 && isset( $this->product_list->filter->menulevel1->menu_id ) ){
			$db = new ec_db( );
			$menu_row = $db->get_menu_row( $this->product_list->filter->menulevel1->menu_id, 1 );
		}else if( $menu_level == 2 && isset( $this->product_list->filter->menulevel2->menu_id ) ){
			$db = new ec_db( );
			$menu_row = $db->get_menu_row( $this->product_list->filter->menulevel2->menu_id, 2 );
		}else if( $menu_level == 3 && isset( $this->product_list->filter->menulevel3->menu_id ) ){
			$db = new ec_db( );
			$menu_row = $db->get_menu_row( $this->product_list->filter->menulevel3->menu_id, 3 );
		}
		
		if( isset( $menu_row ) ){
			if( $menu_row->banner_image != "" ){
				echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/products/banners/" . $menu_row->banner_image ) . "\" alt=\"" . $menu_row->name . "\" />";	
			}
		}
	}
	
	////////////////////////////////////////////////////////
	// MAIN HELPER FUNCTIONS
	////////////////////////////////////////////////////////
	private function get_is_details( ){
		if( isset( $_GET['model_number'] ) )					return true;
		else													return false;
	}
}

?>