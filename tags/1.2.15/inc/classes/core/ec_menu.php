<?php

class ec_menu{
	public $menu_array;											// array( subcat_array(), id, name )
	private $storepage;											// VARCHAR
	private $permalinkdivider;									// CHAR
	
	function __construct( $menu_array ){
		
		$this->menu_array = $menu_array;
		
		$storepageid = get_option( 'ec_option_storepage' );
		$this->storepage = get_permalink( $storepageid );
		
		if( substr_count( $this->storepage, '?' ) )					$this->permalinkdivider = "&";
		else														$this->permalinkdivider = "?";
	
	}
	
	public function level1_count( ){
		return count( $this->menu_array );
	}
	
	public function display_menulevel1_link( $level1 ){
		
		$permalink = get_permalink( $this->menu_array[$level1][3] );
		echo $permalink;
		
	}
	
	public function display_menulevel1_name( $level1 ){
		
		echo $this->menu_array[$level1][2];	
	
	}
	
	public function display_menulevel1_id( $level1 ){
		
		echo $this->menu_array[$level1][1];	
	
	}
	
	public function level2_count( $level1 ){
		return count( $this->menu_array[$level1][0] );
	}
	
	public function display_menulevel2_link( $level1, $level2 ){
		
		$permalink = get_permalink( $this->menu_array[$level1][0][$level2][3] );
		echo $permalink;
		
	}
	
	public function display_menulevel2_name( $level1, $level2 ){
		
		echo $this->menu_array[$level1][0][$level2][2];	
	
	}
	
	public function display_menulevel2_id( $level1, $level2 ){
		
		echo $this->menu_array[$level1][0][$level2][1];	
	
	}
	
	public function level3_count( $level1, $level2 ){
		return count( $this->menu_array[$level1][0][$level2][0] );
	}
	
	public function display_menulevel3_link( $level1, $level2, $level3 ){
		
		$permalink = get_permalink( $this->menu_array[$level1][0][$level2][0][$level3][2] );
		echo $permalink;
	
	}
	
	public function display_menulevel3_name( $level1, $level2, $level3 ){
		
		echo $this->menu_array[$level1][0][$level2][0][$level3][1];	
	
	}
	
	public function display_menulevel3_id( $level1, $level2, $level3 ){
		
		echo $this->menu_array[$level1][0][$level2][0][$level3][0];	
	
	}
}

?>