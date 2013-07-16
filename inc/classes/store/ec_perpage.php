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
		if( isset( $_GET['perpage'] ) )							return $_GET['perpage'];
		else if( isset( $_SESSION['perpage'] ) )				return $_SESSION['perpage'];
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
		return "<a href=\"" . $link_string . "&amp;perpage=" . $this->values[$i] . "\" class=\"ec_per_page_link\">" . $this->values[$i] . "</a>"; 
	}
	
	private function get_per_page_link_selected($i){
		return "<span class=\"ec_per_page_selected\">" . $this->values[$i] . "</span>";
	}
}

?>