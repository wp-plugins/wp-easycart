<?php

class ec_menu{
	public $menu_array;													// array( subcat_array(), id, name )
	private $store_page;												// VARCHAR
	private $permalinkdivider;											// CHAR
	
	function __construct( $menu_array ){
		
		$this->menu_array = $menu_array;
		
		$storepageid = get_option( 'ec_option_storepage' );
		
		if( function_exists( 'icl_object_id' ) ){
			$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
		}
		
		$this->store_page = get_permalink( $storepageid );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->store_page = $https_class->makeUrlHttps( $this->store_page );
		}
		
		if( substr_count( $this->store_page, '?' ) )					$this->permalinkdivider = "&";
		else															$this->permalinkdivider = "?";
	
	}
	
	public function level1_count( ){
		return count( $this->menu_array );
	}
	
	public function display_menulevel1_link( $level1 ){
		
		$permalink = $this->ec_get_permalink( 1, $level1, 0, 0, $this->menu_array[$level1][3] );
		echo $permalink;
		
	}
	
	public function display_menulevel1_name( $level1 ){
		
		echo $GLOBALS['language']->convert_text( $this->menu_array[$level1][2] );	
	
	}
	
	public function get_menulevel1_name( $level1 ){
		
		return $GLOBALS['language']->convert_text( $this->menu_array[$level1][2] );	
	
	}
	
	public function display_menulevel1_id( $level1 ){
		
		echo $this->menu_array[$level1][1];	
	
	}
	
	public function get_menulevel1_id( $level1 ){
		
		return $this->menu_array[$level1][1];	
	
	}
	
	public function level2_count( $level1 ){
		return count( $this->menu_array[$level1][0] );
	}
	
	public function display_menulevel2_link( $level1, $level2 ){
		
		$permalink = $this->ec_get_permalink( 2, $level1, $level2, 0, $this->menu_array[$level1][0][$level2][3] );
		echo $permalink;
		
	}
	
	public function display_menulevel2_name( $level1, $level2 ){
		
		echo $GLOBALS['language']->convert_text( $this->menu_array[$level1][0][$level2][2] );	
	
	}
	
	public function get_menulevel2_name( $level1, $level2 ){
		
		return $GLOBALS['language']->convert_text( $this->menu_array[$level1][0][$level2][2] );	
	
	}
	
	public function display_menulevel2_id( $level1, $level2 ){
		
		echo $this->menu_array[$level1][0][$level2][1];	
	
	}
	
	public function get_menulevel2_id( $level1, $level2 ){
		
		return $this->menu_array[$level1][0][$level2][1];	
	
	}
	
	public function level3_count( $level1, $level2 ){
		return count( $this->menu_array[$level1][0][$level2][0] );
	}
	
	public function display_menulevel3_link( $level1, $level2, $level3 ){
		
		$permalink = $this->ec_get_permalink( 3, $level1, $level2, $level3, $this->menu_array[$level1][0][$level2][0][$level3][2] );
		echo $permalink;
	
	}
	
	public function display_menulevel3_name( $level1, $level2, $level3 ){
		
		echo $GLOBALS['language']->convert_text( $this->menu_array[$level1][0][$level2][0][$level3][1] );	
	
	}
	
	public function get_menulevel3_name( $level1, $level2, $level3 ){
		
		return $GLOBALS['language']->convert_text( $this->menu_array[$level1][0][$level2][0][$level3][1] );	
	
	}
	
	public function display_menulevel3_id( $level1, $level2, $level3 ){
		
		echo $this->menu_array[$level1][0][$level2][0][$level3][0];	
	
	}
	
	public function get_menulevel3_id( $level1, $level2, $level3 ){
		
		return $this->menu_array[$level1][0][$level2][0][$level3][0];	
	
	}
	
	private function ec_get_permalink( $menu_level, $level1, $level2, $level3, $postid ){
		
		if( !get_option( 'ec_option_use_old_linking_style' ) && $postid != "0" ){
			return get_permalink( $postid );
		}else{
			if( $menu_level == 1 )
				return $this->store_page . $this->permalinkdivider . "menuid=" . $this->get_menulevel1_id( $level1 ) . "&menuname=" . $this->get_menulevel1_name( $level1 );
			else if( $menu_level == 2 )
				return $this->store_page . $this->permalinkdivider . "submenuid=" . $this->get_menulevel2_id( $level1, $level2 ) . "&submenuname=" . $this->get_menulevel2_name( $level1, $level2 );
			else if( $menu_level == 3 )
				return $this->store_page . $this->permalinkdivider . "subsubmenuid=" . $this->get_menulevel3_id( $level1, $level2, $level3 ) . "&subsubmenuname=" . $this->get_menulevel3_name( $level1, $level2, $level3 );
		}
		
	}
}

?>