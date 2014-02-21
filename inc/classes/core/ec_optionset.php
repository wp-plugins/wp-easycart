<?php

class ec_optionset{
	private $mysqli;									// ec_db structure
	
	public $option_id;									// INT
	public $option_name;								// VARCHAR 255
	public $option_label;								// VARCHAR 255
	public $optionset = array();						// Array of ec_optionitem
	
	function __construct( $option_data ){
		
		if( count( $option_data ) >= 3 ){
			$this->option_id = $option_data[0];
			$this->option_name = $GLOBALS['language']->convert_text( $option_data[1] );
			$this->option_label = $GLOBALS['language']->convert_text( $option_data[2] );
		
			for($i=0; $i<count($option_data[3]); $i++){
				array_push( $this->optionset, new ec_optionitem( $this->option_id, $option_data[3][$i] ) );
			}
		}
	}
	
	public function is_combo(){
		if(count($this->optionset) > 0 && $this->optionset[0]->optionitem_name && $this->optionset[0]->optionitem_name != "" && $this->optionset[0]->optionitem_icon == "")
			return true;
		else
			return false;
	}
	
	public function is_swatch(){
		if(count($this->optionset) > 0 && $this->optionset[0]->optionitem_icon != "")
			return true;
		else
			return false;
	}
	
}

?>