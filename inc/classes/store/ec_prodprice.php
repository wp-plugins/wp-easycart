<?php

class ec_prodprice{
	
	public $prod_price;
	public $tier_price;
	public $option_price;
	public $promo_price;
	public $unit_price;
	public $total_price;
	
	//Initialize the product pricing structure
	function __construct($product, $quantity, $quantity_in_cart, $options){
		$this->prod_price = $product->Price;
		$this->set_tier_price($product->ProductID, $quantity_in_cart);
		$this->set_option_price($options);
		
		$promotion = new ec_promotion();
		$promotion->set_promotion_product($product->ProductID);
		$promotion->set_promotion_pricing($this->prod_price, $this->tier_price, $this->option_price);
		
		$this->promo_price = $promotion->get_promotion_price();
		$this->set_unit_price();
		$this->set_total_price($quantity);
	}
	
	//Set the product standard price
	private function set_tier_price($productid, $quantity){
		if($this->has_price_tiers($productid)){
			$this->tier_price = $this->get_tier_price($productid, $quantity);
		}
	}
	
	private function get_tier_price($productid, $quantity){
		$pricetiers = $this->get_price_tiers($productid);
		$ret_price = 0;
		
		while($pricetier = mysql_fetch_assoc($pricetiers)){
			if($quantity >= $this->price_tier_quantity($pricetier))		$ret_price = $this->price_tier_price($pricetier);
		}
		
		return $ret_price;
	}
	
	//Set the product standard price
	private function set_option_price($options){
		$opt_total = 0;
		
		if($options->OptionItem1->OptionItemID != 0){
			$opt_total = $opt_total + $options->OptionItem1->OptionItemPrice;	
		}
		
		if($options->OptionItem2->OptionItemID != 0){
			$opt_total = $opt_total + $options->OptionItem2->OptionItemPrice;	
		}
		
		if($options->OptionItem3->OptionItemID != 0){
			$opt_total = $opt_total + $options->OptionItem3->OptionItemPrice;	
		}
		
		if($options->OptionItem4->OptionItemID != 0){
			$opt_total = $opt_total + $options->OptionItem4->OptionItemPrice;	
		}
		
		if($options->OptionItem5->OptionItemID != 0){
			$opt_total = $opt_total + $options->OptionItem5->OptionItemPrice;	
		}
		
		$this->option_price = $opt_total;	
	}
	
	//Set the product standard price
	private function set_unit_price(){
		
		$this->unit_price = $this->promo_price;
			
	}
	
	//Set the product standard price
	private function set_total_price($quantity){
		$this->total_price = $this->unit_price * $quantity;
	}
	
	//Check to see if this product has price tiers
	private function has_price_tiers($productid){ 
		$sql = sprintf("SELECT ProductID FROM pricetiers WHERE pricetiers.ProductID = %s", mysql_real_escape_string($productid));
		$result = mysql_query($sql);
		
		if($result && mysql_num_rows($result) > 0)			return true;
		else												return false;
	}
	
	//Get the price tier result
	function get_price_tiers($productid){
		$sql = sprintf("SELECT * FROM pricetiers WHERE pricetiers.ProductID = %s ORDER BY PriceTierQuantity ASC", mysql_real_escape_string($productid));
		$result = mysql_query($sql);
		
		return $result;
	}
	
	//Extract the price tier quantity from the result row
	function price_tier_quantity($pricetier){
		return $pricetier['PriceTierQuantity'];
	}
	
	//Extract the price tier price from the result row
	function price_tier_price($pricetier){
		return $pricetier['PriceTierPrice'];
	}
	
	//Provide the discount percentage number over original price
	public function price_tier_percentage($pricetier, $price, $list_price){
		if($list_price != "0.00"){
			return round(100 - 100*($pricetier['PriceTierPrice']/$list_price));
		}else{
			return round(100 - 100*($pricetier['PriceTierPrice']/$price));
		}
	}

}

?>