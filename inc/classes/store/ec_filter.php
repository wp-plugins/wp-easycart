<?php 

class ec_filter{
	protected $mysqli;											// ec_db structure
	
	public $perpage;											// ec_perpage structure
	
	public $menulevel1;											// ec_menuitem structure
	public $menulevel2;											// ec_menuitem structure
	public $menulevel3;											// ec_menuitem structure
	public $forced_menu_level = 0;								// menu level can be forced for shortcodes, INT
	
	public $show_on_startup;									// BOOL
	public $product_only;										// BOOL
	
	public $search;												// VARCHAR
	
	public $menufacturer;										// ec_manufacturer structure
	public $group_id;											// INT
	public $model_number;										// VARCHAR
	public $pricepoint_id;										// INT
	public $current_filter;										// INT
	public $default_first_filter;								// INT
	
	private $store_page;										// VARCHAR
	private $permalink_divider;									// CHAR
	
	function __construct( ){
		$this->mysqli = new ec_db();
		
		$this->default_first_filter = get_option( 'ec_option_default_store_filter' );
		$this->current_filter = $this->get_current_filter();
		$this->perpage = new ec_perpage();
		
		$this->menulevel1 = new ec_menuitem( $this->get_menu1_id( ), 1 );
		$this->menulevel2 = new ec_menuitem( $this->get_menu2_id( ), 2 );
		$this->menulevel3 = new ec_menuitem( $this->get_menu3_id( ), 3 );
		$this->show_on_startup = $this->get_show_on_startup( );
		$this->product_only = $this->get_product_only( );
		
		$this->search = $this->get_search( );
		
		$this->manufacturer = new ec_manufacturer( $this->get_manufacturer_id(), "" );
		$this->group_id = $this->get_group_id();
		$this->pricepoint_id = $this->get_pricepoint_id();
		$this->model_number = $this->get_model_number();
		
		$store_page_id = get_option('ec_option_storepage');
		$this->store_page = get_permalink( $store_page_id );
		
		if( substr_count( $this->store_page, '?' ) )			$this->permalink_divider = "&";
		else													$this->permalink_divider = "?";
	}
	
	private function get_current_filter(){
		if( isset($_GET['filternum']) )							return $_GET['filternum'];
		else													return $this->default_first_filter;
	}
	
	private function get_menu1_id(){
		if( $this->get_menu_level() == 1 )						return $_GET['menuid'];
		
		else if( $this->get_menu_level() == 2 )					return $this->mysqli->get_menulevel1_id_from_menulevel2( $this->get_displayed_menu_id( ) );
			
		else if( $this->get_menu_level() == 3 ){				$id2 = $this->mysqli->get_menulevel2_id_from_menulevel3( $this->get_displayed_menu_id( ) );
																return $this->mysqli->get_menulevel1_id_from_menulevel2( $id2 );
																
		}else													return 0;
		
	}
	
	private function get_menu2_id(){
		if( $this->get_menu_level() == 2)						return $_GET['submenuid'];
			
		else if( $this->get_menu_level() == 3)					return $this->mysqli->get_menulevel2_id_from_menulevel3( $this->get_displayed_menu_id() );
		
		else													return 0;
	}
	
	private function get_menu3_id(){
		if( $this->get_menu_level() == 3)						return $_GET['subsubmenuid'];
																return 0;
	}
	
	private function get_displayed_menu_id(){
		if(isset($_GET['menuid']))								return $_GET['menuid'];
		else if(isset($_GET['submenuid']))						return $_GET['submenuid'];
		else if(isset($_GET['subsubmenuid']))					return $_GET['subsubmenuid'];
		else													return 0;
	}
	
	public function get_menu_level(){
		if($this->forced_menu_level != 0)						return $this->forced_menu_level;
		else if(isset($_GET['menuid']))							return 1;
		else if(isset($_GET['submenuid']))						return 2;
		else if(isset($_GET['subsubmenuid']))					return 3;
		else													return 0;
	}
	
	public function get_show_on_startup( ){
		if( isset( $_GET['featured'] ) )						return true;
		else													return false;	
	}
	
	public function get_product_only( ){
		if( isset( $_GET['model_number'] ) && !$this->has_filters() )					return true;
		else													return false;	
	}
	
	public function get_search( ){
		if( isset( $_GET['ec_search'] ) )						return $_GET['ec_search'];
		else													return "";	
	}
	
	public function get_manufacturer_id(){
		if( isset( $_GET['manufacturer'] ) )					return $_GET['manufacturer'];
		else													return 0;	
	}
	
	private function get_pricepoint_id(){
		if(isset($_GET['pricepoint']))							return $_GET['pricepoint'];
		else													return 0;	
	}
	
	public function get_group_id(){
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		if( isset( $post_obj ) ){
			$post_id = $post_obj->ID;
			$group = $this->mysqli->get_category_id_from_post_id( $post_id );
		
			if( isset( $_GET['group_id'] ) )						return $_GET['group_id'];
			else if( isset( $group ) )								return $group->category_id;
			else													return 0;
		}else{
			if( isset( $_GET['group_id'] ) )						return $_GET['group_id'];
			else													return 0;
		}
	}
	
	private function get_model_number(){
		if(isset($_GET['model_number']))						return $_GET['model_number'];
		else if(isset($this->model_number))						return $this->model_number;
		else													return "";
	}
	
	public function get_menu_id(){
		if( isset( $this->menulevel1->menu_id ) )
			return $this->menulevel1->menu_id;
		else
			return 0;
	}
	
	public function get_submenu_id(){
		if( isset( $this->menulevel2->menu_id ) )
			return $this->menulevel2->menu_id;
		else
			return 0;
	}
	
	public function get_subsubmenu_id(){
		if( isset( $this->menulevel3->menu_id ) )
			return $this->menulevel3->menu_id;
		else
			return 0;
	}
	
	public function get_menu_name(){
		if( isset( $this->menulevel1->menu_name ) )
			return $this->menulevel1->menu_name;
		else
			return 0;
	}
	
	public function get_submenu_name(){
		if( isset( $this->menulevel2->menu_name ) )
			return $this->menulevel2->menu_name;
		else
			return 0;
	}
	
	public function get_subsubmenu_name(){
		if( isset( $this->menulevel3->menu_name ) )
			return $this->menulevel3->menu_name;
		else
			return 0;
	}
	
	public function get_menu_permalink( ){
		return get_permalink( $this->menulevel1->post_id );
	}
	
	public function get_submenu_permalink( ){
		return get_permalink( $this->menulevel2->post_id );
	}
	
	public function get_subsubmenu_permalink( ){
		return get_permalink( $this->menulevel3->post_id );
	}
	
	public function get_menu_link(){
		return "<a href=\"". $this->get_menu_permalink( ) . "\" class=\"ec_store_link\">" . $this->menu->level1->name( ) . "</a>";
	}
	
	public function get_submenu_link(){
		return "<a href=\"". $this->get_submenu_permalink( ) . "\" class=\"ec_store_link\">" . $this->menu->level2->name . "</a>";
	}
	
	public function get_subsubmenu_link(){
		return "<a href=\"". $this->get_subsubmenu_permalink( ) . "\" class=\"ec_store_link\">" . $this->menu->level3->name . "</a>";
	}
	
	public function if_level_1_get_name(){
		if($this->get_menu_level() == 1)				return $this->menu->level1->name;
		else											return "";	
	}
	
	public function if_level_2_get_name(){
		if($this->get_menu_level() == 2)				return $this->menu->level2->name;
		else											return "";	
	}
	
	public function if_level_3_get_name(){
		if($this->get_menu_level() == 3)				return $this->menu->level3->name;
		else											return "";	
	}
	
	public function is_sort_selected($num){
		if($this->current_filter == $num)				return true;
		else											return false;	
	}
	
	public function get_items_per_page( $divider ){
		
		return $this->perpage->get_items_per_page( $divider, $this->get_link_string( 2 ) );
		
	}
	
	public function get_link_string( $leave_out ){
		
		// First we should check if the store shortcode is even on the page. This will tell us what to use as the initial link
		$has_store_shortcode = false;
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		$post_content = $post_obj->post_content;
		if( strstr( $post_content, "[ec_store" ) )
			$has_store_shortcode = true;
		
		if( $leave_out != 1 && ( isset( $_GET['menuid'] ) || isset( $_GET['submenuid'] ) || isset( $_GET['subsubmenuid'] ) ) ){
			// First try and get a permalink from the id
			if( isset( $_GET['subsubmenuid'] ) )
				$menu_row = $this->mysqli->get_menu_row( $_GET['subsubmenuid'], 3 );
			else if( isset( $_GET['submenuid'] ) )
				$menu_row = $this->mysqli->get_menu_row( $_GET['submenuid'], 2 );
			else if( isset( $_GET['menuid'] ) )
				$menu_row = $this->mysqli->get_menu_row( $_GET['menuid'], 1 );
				
			if( count( $menu_row ) > 0 ){
				if( $has_store_shortcode )
					$ret_string = get_permalink( $menu_row->post_id ) . $this->permalink_divider;
				else
					$ret_string = $this->store_page . $this->permalink_divider;
			}else{
				
				$ret_string = $this->store_page . $this->permalink_divider;
				if( $this->get_menu_level() == 1 )						$ret_string .= "menuid=" . $this->menulevel1->menu_id . "&amp;menu=" . $this->get_menu_name();
				else if( $this->get_menu_level() == 2 ) 				$ret_string .= "submenuid=" . $this->menulevel2->menu_id . "&amp;submenu=" . $this->get_submenu_name();
				else if( $this->get_menu_level() == 3 )					$ret_string .= "subsubmenuid=" . $this->menulevel3->menu_id . "&amp;subsubmenu=" . $this->get_subsubmenu_name();
			}
		}else if( $leave_out != 1 ){
			global $wp_query;
			$post_obj = $wp_query->get_queried_object();
			$post_id = $post_obj->ID;
			$manufacturer = $this->mysqli->get_manufacturer_id_from_post_id( $post_id );
			$product = $this->mysqli->get_product_from_post_id( $post_id );
			if( ( isset( $manufacturer ) && $leave_out == 3 ) || ( isset( $product ) && $leave_out == 3 ) || ( isset( $product ) && $leave_out == 4 ) )
				$ret_string = $this->store_page . $this->permalink_divider;
			else{
				if( $has_store_shortcode )
					$ret_string = get_permalink( $post_id ) . $this->permalink_divider;
				else
					$ret_string = $this->store_page . $this->permalink_divider;
			}
		}else{
			$ret_string = $this->store_page . $this->permalink_divider;
		}
		
		if( $leave_out != 2 )										$ret_string .= "&amp;perpage=" . $this->perpage->selected;
		
		if( $leave_out != 3 ){
		
			if($this->manufacturer->manufacturer_id != 0)			$ret_string .= "&amp;manufacturer=".$this->manufacturer->manufacturer_id;
			
		}
		
		
		if( $leave_out != 3 && $leave_out != 4 ){
		
			if($this->pricepoint_id != 0)							$ret_string .= "&amp;pricepoint=" . $this->pricepoint_id;
			
		}
		
		if( $leave_out != 5 ){
	
			if($this->current_filter != 0)							$ret_string .= "&amp;filternum=" . $this->current_filter;
			
		}
		
		return $ret_string;
		
	}
	
	public function get_where_query(){
		
		if( $this->has_filters( ) || $this->product_only ){
			
			$ret_string = "WHERE product.activate_in_store = 1";
			
			if( $this->get_menu_level() == 1 && $this->get_menu_id( ) != 0 )						
				$ret_string .= sprintf(" AND ( product.menulevel1_id_1 = %s OR product.menulevel2_id_1 = %s OR product.menulevel3_id_1 = %s )", mysql_real_escape_string( $this->get_menu_id( ) ), mysql_real_escape_string( $this->get_menu_id( ) ), mysql_real_escape_string( $this->get_menu_id( ) ) );
			
			if( $this->get_menu_level() == 2 && $this->get_submenu_id( ) != 0 ) 						$ret_string .= sprintf(" AND ( product.menulevel1_id_2 = %s OR product.menulevel2_id_2 = %s OR product.menulevel3_id_2 = %s )", mysql_real_escape_string( $this->get_submenu_id( ) ), mysql_real_escape_string( $this->get_submenu_id( ) ), mysql_real_escape_string( $this->get_submenu_id( ) ) );
			
			if( $this->get_menu_level() == 3 && $this->get_subsubmenu_id( ) != 0 )						
				$ret_string .= sprintf(" AND ( product.menulevel1_id_3 = %s OR product.menulevel2_id_3 = %s OR product.menulevel3_id_3 = %s )", mysql_real_escape_string( $this->get_subsubmenu_id( ) ), mysql_real_escape_string( $this->get_subsubmenu_id( ) ), mysql_real_escape_string( $this->get_subsubmenu_id( ) ) );
			
			if( $this->search != "" )								$ret_string .= " AND ( product.title LIKE '%" . $this->mysqli->clean_search( $this->search ) . "%' OR manufacturer.name LIKE '%" . $this->mysqli->clean_search( $this->search ) . "%' OR product.description LIKE '%" . $this->mysqli->clean_search( $this->search ) . "%' ) ";
			
			if( $this->show_on_startup )							$ret_string .= " AND product.show_on_startup = 1 ";
			
			if( $this->product_only )								$ret_string .= " AND product.model_number = '" . $this->model_number . "' ";
			
			if( $this->manufacturer->manufacturer_id != 0 )			$ret_string .= " AND product.manufacturer_id = ".$this->manufacturer->manufacturer_id;
			
			if( $this->group_id != 0 )								$ret_string .= " AND ec_categoryitem.category_id = ".$this->group_id;
																	
			if( $this->pricepoint_id != 0 )							$ret_string .= $this->get_price_point_where( );
			
																	return $ret_string;
			
		}else														return " WHERE product.show_on_startup = 1 AND product.activate_in_store = 1";
	}
	
	public function get_order_by_query(){
		
		if($this->current_filter == 1)								return " ORDER BY product.price ASC";
		else if($this->current_filter == 2)							return " ORDER BY product.price DESC";
		else if($this->current_filter == 3)							return " ORDER BY product.title ASC";
		else if($this->current_filter == 4)							return " ORDER BY product.title DESC";
		else if($this->current_filter == 5)							return " ORDER BY product.added_to_db_date DESC";
		else if($this->current_filter == 6)							return " ORDER BY review_average DESC";
		else if($this->current_filter == 7)							return " ORDER BY product.views DESC";
		else														return " ORDER BY product.price ASC";
	
	}
	
	private function has_filters( ){
		
		if(	$this->get_menu_level() != 0 || 
			( isset( $this->manufacturer ) && $this->manufacturer->manufacturer_id && $this->manufacturer->manufacturer_id != 0 ) || 
			$this->group_id != 0 ||
			$this->pricepoint_id != 0 || 
			$this->model_number != "" || 
			$this->search != ""  ||
			$this->show_on_startup
		  )
																	return true;
		else														return false;
			
	}
	
	private function get_price_point_where( ){
		$pricepoint_row = $this->mysqli->get_pricepoint_row( $this->pricepoint_id );
		if( $pricepoint_row->is_less_than )
			return " AND product.price < " . $pricepoint_row->high_point;
		else if( $pricepoint_row->is_greater_than )
			return " AND product.price > " . $pricepoint_row->low_point;
		else
			return " AND product.price <= " . $pricepoint_row->high_point . " AND product.price >= " . $pricepoint_row->low_point;
	}
	
}

?>