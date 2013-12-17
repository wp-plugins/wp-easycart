<?php

class ec_optionitem{
	
	public $option_id;									// INT
	public $optionitem_id;								// INT
	public $optionitem_name;							// VARCHAR 33
	public $optionitem_price;							// FLOAT 7,2
	public $optionitem_icon;							// VARCHAR 512
	
	function __construct( $option_id, $optionitem_data ){
		$this->option_id = $option_id;
		$this->optionitem_id = $optionitem_data->optionitem_id;
		$this->optionitem_name = $optionitem_data->optionitem_name;
		$this->optionitem_price = $optionitem_data->optionitem_price;
		$this->optionitem_icon = $optionitem_data->optionitem_icon;
	}
	
	public function get_optionitem_label( ){
		if($this->optionitem_price != 0.00)				return $this->optionitem_name . " (" . $GLOBALS['currency']->get_currency_display( $this->optionitem_price ) . ")";
		else											return $this->optionitem_name;
	}

}

?>