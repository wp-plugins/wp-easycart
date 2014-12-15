<?php

class ec_perpage{
	private $mysqli;											// ec_db structure
	
	public $values;												// array of INTs
	public $selected;											// INT
	
	function __construct(){
		$this->mysqli = new ec_db();
		
		$this->values = $this->mysqli->get_perpage_values();
		$this->selected = $this->get_selected( );
	}
	
	private function get_selected(){
		if( isset( $_GET['perpage'] ) )							return $this->mysqli->get_perpage( $_GET['perpage'] );
		else if( isset( $_SESSION['perpage'] ) )				return $this->mysqli->get_perpage( $_SESSION['perpage'] );
		else													return $this->get_default( );
		
	}
	
	private function get_default(){
		$sel_item = ( ceil( count( $this->values ) / 2 )  );
		if( $sel_item > 0 )										return $this->values[$sel_item-1];
		else													return 0;
	}
	
	public function get_items_per_page( $divider, $link_string ){
		
		$ret_string = "";
		
		for( $i=0; $i<count($this->values); $i++ ){
		
			if( $this->values[$i] == $this->selected )			$ret_string .= $this->get_per_page_link_selected($i);
			else												$ret_string .= $this->get_per_page_link($i, $link_string);
			
			if( $i+1 < count($this->values) )					$ret_string .= $divider;
			
		}
		
		return $ret_string;
		
	}
	
	private function get_per_page_link($i, $link_string){
		return "<a href=\"" . $this->get_current_url( ) . "perpage=" . $this->values[$i] . "\" class=\"ec_per_page_link\">" . $this->values[$i] . "</a>"; 
	}
	
	private function get_per_page_link_selected($i){
		return "<span class=\"ec_per_page_selected\">" . $this->values[$i] . "</span>";
	}
	
	public function get_per_page_url( $i ){
		return $this->get_current_url( ) . "perpage=" . $i; 
	}
	
	private function get_current_url( ){
		$page_url = 'http';
		if( isset( $_SERVER["HTTPS"] ) && $_SERVER["HTTPS"] == "on" ){
			$pageURL .= "s";
		}
		
		$page_url .= "://";
		
		if( $_SERVER["SERVER_PORT"] != "80") {
			$page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		
		}else{
			$page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		}
		
		$page_url = preg_replace( '/([&]*[?]*perpage\=[\d]*)/', '', preg_replace( '/([&]*[?]*pagenum\=[\d]*)/', '', $page_url ) );
		
		if( substr_count( $page_url, '?' ) )						
			$page_url .= "&";
		else																
			$page_url = "?";
		
		return $page_url;
	}
}

?>