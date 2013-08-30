<?php

class ec_prodimageset{
	
	public $product_id;						// INT
	public $optionitem_id;					// INT
	public $image1;							// VARCHAR 255
	public $image2;							// VARCHAR 255
	public $image3;							// VARCHAR 255
	public $image4;							// VARCHAR 255
	public $image5;							// VARCHAR 255
	
	function __construct($product_id, $image_data){
		
		$this->product_id = $product_id;
		
		if(count($image_data) > 0){
			$this->optionitem_id = $image_data[0];
		}else{
			$this->optionitem_id = 0;
		}
		
		if(count($image_data) > 1){
			$this->image1 = $image_data[1];
		}else{
			$this->image1 = "";
		}
		
		if(count($image_data) > 2){
			$this->image2 = $image_data[2];
		}else{
			$this->image2 = "";
		}
		
		if(count($image_data) > 3){
			$this->image3 = $image_data[3];
		}else{
			$this->image3 = "";
		}
		
		if(count($image_data) > 4){
			$this->image4 = $image_data[4];
		}else{
			$this->image4 = "";
		}
		
		if(count($image_data) > 5){
			$this->image5 = $image_data[5];
		}else{
			$this->image5 = "";
		}
	}
	
}

?>