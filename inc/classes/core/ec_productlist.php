<?php

class ec_productlist{
	private $mysqli;								// ec_db structure

	public $products = array();						// array of ec_product structures
	public $is_product_details;						// BOOL
	public $filter;									// ec_filter structure
	public $paging;									// ec_paging structure
	public $num_products;							// INT
	
	function __construct( $is_product_details = false, $menuid = "NOMENU", $submenuid = "NOSUBMENU", $subsubmenuid = "NOSUBSUBMENU", $manufacturerid = "NOMANUFACTURER", $groupid = "NOGROUP", $modelnumber = "NOMODELNUMBER" ){
		$this->mysqli = new ec_db();
		
		$this->filter = new ec_filter( );
		$this->set_shortcode_vals( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
		$this->paging = new ec_paging( $this->filter->perpage->selected );
		$this->is_product_details = $is_product_details;
		$this->get_products( );	
		if( count( $this->products ) > 0 )
			$this->paging->update_product_count( $this->products[0]->total_products );
		else
			$this->paging->update_product_count( 0 );
	
	}
	
	private function get_is_details( ){
		if( isset( $_GET['model_number'] ) )					return true;
		else													return false;
	}
	
	private function get_products( ){
		//First get number of products without the limit query
		if( !$this->is_product_details )
			$result = $this->mysqli->get_product_list( $this->filter->get_where_query(), $this->filter->get_order_by_query(), $this->paging->get_limit_query(), session_id() );
		else
			$result = $this->mysqli->get_product_list( $this->filter->get_where_query(), $this->filter->get_order_by_query(), "", session_id() );
			
		if( count( $result ) > 0 )
			$this->num_products = $result[0]["product_count"];
		else
			$this->num_products = 0;
		
		for($i=0; $i<count($result); $i++){
			
			$product = new ec_product( $result[$i], 0, $this->get_is_details( ) );
			array_push($this->products, $product);
				
		}
	}
	
	public function display_product_list( ){
		
		for($i=0; $i<count($this->products); $i++){
			
			$product = $this->products[$i];
			$list_view = false;
			if( get_option( "ec_option_product_layout_type" ) == "list_only" )
				$list_view = true;
			else if( isset( $_SESSION['ec_option_product_layout_type'] ) && $_SESSION['ec_option_product_layout_type'] == "list" )
				$list_view = true;
				
			if( $list_view ){
				if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_list.php' ) )
					include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option('ec_option_base_layout') . '/ec_product_list.php' );
				else if( file_exists( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_list.php' ) )
					include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_product_list.php' );
				else
					echo "List View Layout Missing";
			}else{
				if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product.php' ) )	
					include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option('ec_option_base_layout') . '/ec_product.php' );
				else if( file_exists( WP_PLUGIN_DIR . '/' . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product.php' ) )	
					include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_product.php' );
				else
					echo "Grid View Layout Missing";
			}
		}
		
	}
	
	public function display_filter_menu( $divider ){
		
		if($this->filter->get_menu_level() == 1)			echo $this->filter->get_menu_link();
		else if($this->filter->get_menu_level() == 2)		echo $this->filter->get_menu_link() . $divider . $this->filter->get_submenu_link();
		else if($this->filter->get_menu_level() == 3)		echo $this->filter->get_menu_link() . $divider . $this->filter->get_submenu_link() . $divider . $this->filter->get_subsubmenu_link();
		
	}
	
	public function display_filter_combo( ){
		
		global $language_data;
		
		$storepageid = get_option('ec_option_storepage');
		$cartpageid = get_option('ec_option_cartpage');
		$accountpageid = get_option('ec_option_accountpage');
		
		$storepage = get_permalink( $storepageid );
		$cartpage = get_permalink( $cartpageid );
		$accountpage = get_permalink( $accountpageid );
		
		if(substr_count($storepage, '?'))							$permalinkdivider = "&";
		else														$permalinkdivider = "?";
		
		echo "<select name=\"sortfield\" id=\"sortfield\" onchange=\"change_product_sort('" . $this->filter->get_menu_id( ) . "', '" . str_replace( "'", "&rsquo;", $this->filter->get_menu_name( ) ) . "', '" . $this->filter->get_submenu_id( ) . "', '" . str_replace( "'", "&rsquo;", $this->filter->get_submenu_name( ) ) . "', '" . $this->filter->get_subsubmenu_id( ) . "', '" . str_replace( "'", "&rsquo;", $this->filter->get_subsubmenu_name( ) ) . "', '" . $this->filter->manufacturer->manufacturer_id . "', '" . $this->filter->pricepoint_id . "', '" . $this->paging->current_page . "', '" . $this->filter->perpage->selected . "', '" . $storepage . "', '" . $permalinkdivider . "');\" class=\"ec_sort_menu\">\n\n";

		if( get_option( 'ec_option_product_filter_1' ) ){
			echo "<option value=\"1\""; if( $this->filter->is_sort_selected(1) ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'sort_bar', 'sort_by_price_low' ) . "</option>\n\n";
		}
		
		if( get_option( 'ec_option_product_filter_2' ) ){
			echo "<option value=\"2\""; if( $this->filter->is_sort_selected(2) ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'sort_bar', 'sort_by_price_high' ) . "</option>\n\n";
		}
		
		if( get_option( 'ec_option_product_filter_3' ) ){
			echo "<option value=\"3\""; if( $this->filter->is_sort_selected(3) ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'sort_bar', 'sort_by_title_a' ) . "</option>\n\n";
		}
		
		if( get_option( 'ec_option_product_filter_4' ) ){
			echo "<option value=\"4\""; if( $this->filter->is_sort_selected(4) ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'sort_bar', 'sort_by_title_z' ) . "</option>\n\n";
		}
		
		if( get_option( 'ec_option_product_filter_5' ) ){
			echo "<option value=\"5\""; if( $this->filter->is_sort_selected(5) ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'sort_bar', 'sort_by_newest' ) . "</option>\n\n";
		}
		
		if( get_option( 'ec_option_product_filter_6' ) ){
			echo "<option value=\"6\""; if( $this->filter->is_sort_selected(6) ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'sort_bar', 'sort_by_rating' ) . "</option>\n\n";
		}
		
		if( get_option( 'ec_option_product_filter_7' ) ){
			echo "<option value=\"7\""; if( $this->filter->is_sort_selected(7) ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'sort_bar', 'sort_by_most_viewed' ) . "</option>\n\n";
		}

        echo "</select>\n\n";
        
	}
	
	public function display_items_per_page( $divider ){
		
		echo $this->filter->get_items_per_page( $divider );
	
	}
	
	public function display_current_page( ){
		
		echo $this->paging->current_page;
		
	}
	
	public function display_total_pages( ){
		
		echo $this->paging->total_pages;
		
	}
	
	public function display_product_paging( $divider ){
		
		echo $this->paging->display_paging_links( $divider, $this->filter->get_link_string( 0 ) );
	}
	
	public function set_shortcode_vals( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber ){
		
		if( $menuid != "NOMENU" ){
			$this->filter->menulevel1 = new ec_menuitem( $menuid, 1 );
			$this->filter->forced_menu_level = 1;
		}else if( $submenuid != "NOSUBMENU" ){
			$this->filter->menulevel2 = new ec_menuitem( $submenuid, 2 );
			$this->filter->forced_menu_level = 2;
		}else if( $subsubmenuid != "NOSUBSUBMENU" ){
			$this->filter->menulevel3 = new ec_menuitem( $subsubmenuid, 3 );
			$this->filter->forced_menu_level = 3;
		}
		
		if( $manufacturerid != "NOMANUFACTURER" )
			$this->filter->manufacturer = new ec_manufacturer( $manufacturerid, "" );
			
		if( $groupid != "NOGROUP" )
			$this->filter->group_id = $groupid;
			
		if( $modelnumber != "NOMODELNUMBER" )
			$this->filter->model_number = $modelnumber;
			
	}
	
}

?>