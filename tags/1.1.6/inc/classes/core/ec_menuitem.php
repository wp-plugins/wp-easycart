<?php

class ec_menuitem{
	private $mysqli;					// ec_db structure
	public $menu_id;					// INT
	public $menu_level;					// INT
	public $menu_name;					// VARCHAR
	
	function __construct( $menu_id, $menu_level ){
		$this->mysqli = new ec_db( );
		$this->menu_id = $menu_id;
		$this->menu_level = $menu_level;
		$this->menu_name = $this->mysqli->get_menuname( $menu_id, $menu_level );
	}
}

?>