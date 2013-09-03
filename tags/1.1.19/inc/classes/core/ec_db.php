<?php

class ec_db{
	
	private $mysqli;  // holds your mysqli connection
	private $orderdetail_sql;
	function __construct(){
		global $wpdb;
		$this->mysqli =& $wpdb;
		
		$this->orderdetail_sql = "SELECT 
				ec_orderdetail.orderdetail_id, 
				ec_orderdetail.order_id, 
				ec_orderdetail.product_id, 
				ec_orderdetail.title, 
				ec_orderdetail.model_number, 
				ec_orderdetail.order_date, 
				ec_orderdetail.unit_price, 
				ec_orderdetail.total_price, 
				ec_orderdetail.quantity, 
				ec_orderdetail.image1, 
				ec_orderdetail.optionitem_name_1, 
				ec_orderdetail.optionitem_name_2, 
				ec_orderdetail.optionitem_name_3, 
				ec_orderdetail.optionitem_name_4, 
				ec_orderdetail.optionitem_name_5,
				ec_orderdetail.optionitem_label_1, 
				ec_orderdetail.optionitem_label_2, 
				ec_orderdetail.optionitem_label_3, 
				ec_orderdetail.optionitem_label_4, 
				ec_orderdetail.optionitem_label_5,
				ec_orderdetail.optionitem_price_1, 
				ec_orderdetail.optionitem_price_2, 
				ec_orderdetail.optionitem_price_3, 
				ec_orderdetail.optionitem_price_4, 
				ec_orderdetail.optionitem_price_5,
				ec_orderdetail.giftcard_id, 
				ec_orderdetail.gift_card_message, 
				ec_orderdetail.gift_card_from_name, 
				ec_orderdetail.gift_card_to_name,
				ec_orderdetail.is_download, 
				ec_orderdetail.is_giftcard, 
				ec_orderdetail.is_taxable, 
				ec_orderdetail.download_file_name, 
				ec_orderdetail.download_key,
				ec_orderdetail.maximum_downloads_allowed,
				ec_orderdetail.download_timelimit_seconds,
				
				GROUP_CONCAT(DISTINCT CONCAT_WS('***', ec_customfield.field_name, ec_customfield.field_label, ec_customfielddata.data) ORDER BY ec_customfield.field_name ASC SEPARATOR '---') as customfield_data
				
				FROM ec_orderdetail
				
				LEFT JOIN ec_customfield
				ON ec_customfield.table_name = 'ec_orderdetail'
				
				LEFT JOIN ec_customfielddata
				ON ec_customfielddata.customfield_id = ec_customfield.customfield_id AND ec_customfielddata.table_id = ec_orderdetail.orderdetail_id, 
				
				ec_order, ec_user
				
				WHERE 
				ec_user.email = '%s' AND ec_user.password = '%s' AND 
				ec_order.order_id = ec_orderdetail.order_id AND 
				ec_user.user_id = ec_order.user_id AND 
				ec_orderdetail.order_id = %d
				
				GROUP BY
				ec_orderdetail.orderdetail_id";
				
		$this->orderdetail_guest_sql = "SELECT 
				ec_orderdetail.orderdetail_id, 
				ec_orderdetail.order_id, 
				ec_orderdetail.product_id, 
				ec_orderdetail.title, 
				ec_orderdetail.model_number, 
				ec_orderdetail.order_date, 
				ec_orderdetail.unit_price, 
				ec_orderdetail.total_price, 
				ec_orderdetail.quantity, 
				ec_orderdetail.image1, 
				ec_orderdetail.optionitem_name_1, 
				ec_orderdetail.optionitem_name_2, 
				ec_orderdetail.optionitem_name_3, 
				ec_orderdetail.optionitem_name_4, 
				ec_orderdetail.optionitem_name_5,
				ec_orderdetail.optionitem_label_1, 
				ec_orderdetail.optionitem_label_2, 
				ec_orderdetail.optionitem_label_3, 
				ec_orderdetail.optionitem_label_4, 
				ec_orderdetail.optionitem_label_5,
				ec_orderdetail.optionitem_price_1, 
				ec_orderdetail.optionitem_price_2, 
				ec_orderdetail.optionitem_price_3, 
				ec_orderdetail.optionitem_price_4, 
				ec_orderdetail.optionitem_price_5,
				ec_orderdetail.giftcard_id, 
				ec_orderdetail.gift_card_message, 
				ec_orderdetail.gift_card_from_name, 
				ec_orderdetail.gift_card_to_name,
				ec_orderdetail.is_download, 
				ec_orderdetail.is_giftcard, 
				ec_orderdetail.is_taxable, 
				ec_orderdetail.download_file_name, 
				ec_orderdetail.download_key,
				ec_orderdetail.maximum_downloads_allowed,
				ec_orderdetail.download_timelimit_seconds,
				
				GROUP_CONCAT(DISTINCT CONCAT_WS('***', ec_customfield.field_name, ec_customfield.field_label, ec_customfielddata.data) ORDER BY ec_customfield.field_name ASC SEPARATOR '---') as customfield_data
				
				FROM ec_orderdetail
				
				LEFT JOIN ec_customfield
				ON ec_customfield.table_name = 'ec_orderdetail'
				
				LEFT JOIN ec_customfielddata
				ON ec_customfielddata.customfield_id = ec_customfield.customfield_id AND ec_customfielddata.table_id = ec_orderdetail.orderdetail_id, 
				
				ec_order 
				
				WHERE 
				ec_order.order_id = ec_orderdetail.order_id AND 
				ec_orderdetail.order_id = %d
				
				GROUP BY
				ec_orderdetail.orderdetail_id";
	}
	
	public function get_breadcrumb_data( $model_number, $menuid, $submenuid, $subsubmenuid ){
		$sql_menu0 = $this->mysqli->prepare( "SELECT ec_product.title, ec_product.model_number FROM ec_product WHERE ec_product.model_number = '%s'", $model_number );
		$sql_menu1 = $this->mysqli->prepare( "SELECT ec_product.title, ec_product.model_number, ec_menulevel1.menulevel1_id, ec_menulevel1.name as menulevel1_name FROM ec_product, ec_menulevel1 WHERE ec_product.model_number = '%s' AND ec_menulevel1.menulevel1_id = %d", $model_number, $menuid );
		$sql_menu2 = $this->mysqli->prepare( "SELECT ec_product.title, ec_product.model_number, ec_menulevel1.menulevel1_id, ec_menulevel2.menulevel2_id, ec_menulevel1.name as menulevel1_name, ec_menulevel2.name as menulevel2_name FROM ec_product, ec_menulevel2 LEFT JOIN ec_menulevel1 ON ec_menulevel1.menulevel1_id = ec_menulevel2.menulevel1_id WHERE ec_product.model_number = '%s' AND ec_menulevel2.menulevel2_id = %d", $model_number, $submenuid );
		$sql_menu3 = $this->mysqli->prepare( "SELECT ec_product.title, ec_product.model_number, ec_menulevel1.menulevel1_id, ec_menulevel2.menulevel2_id, ec_menulevel3.menulevel3_id, ec_menulevel1.name as menulevel1_name, ec_menulevel2.name as menulevel2_name, ec_menulevel3.name as menulevel3_name FROM ec_product, ec_menulevel3 LEFT JOIN ec_menulevel2 ON ec_menulevel2.menulevel2_id = ec_menulevel3.menulevel2_id LEFT JOIN ec_menulevel1 ON ec_menulevel1.menulevel1_id = ec_menulevel2.menulevel1_id WHERE ec_product.model_number = '%s' AND ec_menulevel3.menulevel3_id = %d", $model_number, $subsubmenuid );
		
		if( $subsubmenuid != 0 )
			$sql = $sql_menu3;
		else if( $submenuid != 0 )
			$sql = $sql_menu2;
		else if( $menuid != 0 )
			$sql = $sql_menu1;
		else
			$sql = $sql_menu0;
		
		return $this->mysqli->get_row( $sql );	
	}
	
	public function get_optionitem_list( ){
		$sql = "SELECT 
				optionitem.option_id,
				optionitem.optionitem_id, 
				optionitem.optionitem_name, 
				optionitem.optionitem_price, 
				optionitem.optionitem_icon
				
				FROM ec_optionitem as optionitem
				
				ORDER BY
				optionitem.option_id, 
				optionitem.optionitem_order";
				
		return $this->mysqli->get_results( $sql );
	}
	
	public function get_optionitem_image_list( ){
		$sql = "SELECT 
				optionitemimage.optionitemimage_id,
				optionitemimage.optionitem_id, 
				optionitemimage.product_id, 
				optionitemimage.image1, 
				optionitemimage.image2, 
				optionitemimage.image3, 
				optionitemimage.image4, 
				optionitemimage.image5,
				optionitem.optionitem_order
				
				FROM ec_optionitemimage as optionitemimage, ec_optionitem as optionitem

				WHERE optionitem.optionitem_id = optionitemimage.optionitem_id
				
                GROUP BY optionitemimage.optionitemimage_id
				
				ORDER BY
				optionitemimage.product_id,
				optionitem.optionitem_order";
				
		return $this->mysqli->get_results( $sql );
	}
	
	public function get_product_list( $where_query, $order_query, $limit_query, $session_id ){
		$query = "SET SESSION group_concat_max_len = 20000";
		$update = $this->mysqli->query($query);
		
		//Setup the Product Query
		$sql = "SELECT
				product.product_id,
				product.model_number,
				product.activate_in_store,
				manufacturer.manufacturer_id,
				manufacturer.name as manufacturer_name,
				product.title,
				product.description,
				product.seo_description,
				product.seo_keywords,
				product.price,
				product.list_price,
				product.vat_rate,
				product.stock_quantity,
				product.weight,
				product.use_optionitem_quantity_tracking,
				product.use_specifications,
				product.specifications,
				product.use_customer_reviews,
				product.show_on_startup,
				product.show_stock_quantity,
				product.is_special,
				product.is_taxable,
				product.is_giftcard,
				product.is_download,
				product.is_donation,
				product.download_file_name,
				
				CONCAT_WS('***', option1.option_id, option1.option_name, option1.option_label) as option_data_1,
				CONCAT_WS('***', option2.option_id, option2.option_name, option2.option_label) as option_data_2,
				CONCAT_WS('***', option3.option_id, option3.option_name, option3.option_label) as option_data_3,
				CONCAT_WS('***', option4.option_id, option4.option_name, option4.option_label) as option_data_4,
				CONCAT_WS('***', option5.option_id, option5.option_name, option5.option_label) as option_data_5,
				
				product.use_optionitem_images,
				
				product.image1,
				product.image2,
				product.image3,
				product.image4,
				product.image5,
				
				product.featured_product_id_1,
				product.featured_product_id_2,
				product.featured_product_id_3,
				product.featured_product_id_4,
				
				GROUP_CONCAT(review.rating) as review_data,
				AVG(review.rating) as review_average,
				
				product.views,
				
				GROUP_CONCAT(DISTINCT CONCAT_WS('***', pricetier.price, pricetier.quantity) ORDER BY pricetier.quantity ASC SEPARATOR '---') as pricetier_data,
				
				GROUP_CONCAT(DISTINCT CONCAT_WS('***', ec_customfield.field_name, ec_customfield.field_label, ec_customfielddata.data) ORDER BY ec_customfield.field_name ASC SEPARATOR '---') as customfield_data
				
				FROM ec_product as product 
				
				LEFT JOIN ec_option as option1
				ON option1.option_id = product.option_id_1
				
				LEFT JOIN ec_option as option2
				ON option2.option_id = product.option_id_2
				
				LEFT JOIN ec_option as option3
				ON option3.option_id = product.option_id_3
				
				LEFT JOIN ec_option as option4
				ON option4.option_id = product.option_id_4
				
				LEFT JOIN ec_option as option5
				ON option5.option_id = product.option_id_5
				
				LEFT JOIN ec_manufacturer as manufacturer
				ON manufacturer.manufacturer_id = product.manufacturer_id
				
				LEFT JOIN ec_review as review
				ON review.product_id = product.product_id
				
				LEFT JOIN ec_pricetier as pricetier
				ON pricetier.product_id = product.product_id 
				
				LEFT JOIN ec_customfield
				ON ec_customfield.table_name = 'ec_product'
				
				LEFT JOIN ec_customfielddata
				ON ec_customfielddata.customfield_id = ec_customfield.customfield_id AND ec_customfielddata.table_id = product.product_id 
				
				LEFT JOIN ec_categoryitem
				ON ec_categoryitem.product_id = product.product_id 
				";
				
				$group_query = " GROUP BY 
				product.product_id,
				product.option_id_1, 
				product.option_id_2, 
				product.option_id_3, 
				product.option_id_4, 
				product.option_id_5 ";
				
		
		$result = $this->mysqli->get_results( $this->mysqli->prepare( $sql, $session_id ) . $where_query . $group_query . $order_query );
		$result_count = count($result);
		
		$result2 = $this->mysqli->get_results( $this->mysqli->prepare( $sql, $session_id ) . $where_query . $group_query . $order_query . $limit_query );
		
		//Process the Result
		$optionitem_list = $this->get_optionitem_list( );
		$optionitem_image_list = $this->get_optionitem_image_list( );
		$product_list = array();
		
		foreach($result2 as $row){
		
			$option1_data_array = explode("***", $row->option_data_1);
			$option2_data_array = explode("***", $row->option_data_2);
			$option3_data_array = explode("***", $row->option_data_3);
			$option4_data_array = explode("***", $row->option_data_4);
			$option5_data_array = explode("***", $row->option_data_5);
			
			$review_data_array = explode(",", $row->review_data);
			
			$pricetier_data_array = explode("---", $row->pricetier_data);
			$pricetier_data_array2 = array();
			for($i=0; $i<count($pricetier_data_array); $i++){
				$temp_arr = explode("***", $pricetier_data_array[$i]);
				array_push($pricetier_data_array2, $temp_arr);
			}
			
			// Get option items if needed
			$optionitem1_data = array();
			$optionitem2_data = array();
			$optionitem3_data = array();
			$optionitem4_data = array();
			$optionitem5_data = array();
			
			if( $row->option_data_1 || $row->option_data_2 || $row->option_data_3 || $row->option_data_4 || $row->option_data_5 ){
				for( $i=0; $i<count( $optionitem_list ); $i++ ){
					if( $row->option_data_1 && $optionitem_list[$i]->option_id == $option1_data_array[0] )
						array_push( $optionitem1_data, $optionitem_list[$i] );
						
					if( $row->option_data_2 && $optionitem_list[$i]->option_id == $option2_data_array[0] )
						array_push( $optionitem2_data, $optionitem_list[$i] );
						
					if( $row->option_data_3 && $optionitem_list[$i]->option_id == $option3_data_array[0] )
						array_push( $optionitem3_data, $optionitem_list[$i] );
						
					if( $row->option_data_4 && $optionitem_list[$i]->option_id == $option4_data_array[0] )
						array_push( $optionitem4_data, $optionitem_list[$i] );
						
					if( $row->option_data_5 && $optionitem_list[$i]->option_id == $option5_data_array[0] )
						array_push( $optionitem5_data, $optionitem_list[$i] );
				
				}
			}
			
			// Get option item images if needed
			$optionitemimage_data = array();
			if( $row->use_optionitem_images ){
				for( $i=0; $i<count( $optionitem_image_list ); $i++ ){
					if( $optionitem_image_list[$i]->product_id == $row->product_id )
						array_push( $optionitemimage_data, $optionitem_image_list[$i] );
				}
			}
			
			$option1 = ""; $option2 = ""; $option3 = ""; $option4 = ""; $option5 = "";
			
			if( $row->option_data_1 )
				$option1 = array($option1_data_array[0], $option1_data_array[1], $option1_data_array[2], $optionitem1_data);
			
			if( $row->option_data_2 )
				$option2 = array($option2_data_array[0], $option2_data_array[1], $option2_data_array[2], $optionitem2_data);
			
			if( $row->option_data_3 )
				$option3 = array($option3_data_array[0], $option3_data_array[1], $option3_data_array[2], $optionitem3_data);
			
			if( $row->option_data_4 )
				$option4 = array($option4_data_array[0], $option4_data_array[1], $option4_data_array[2], $optionitem4_data);
			
			if( $row->option_data_5 )
				$option5 = array($option5_data_array[0], $option5_data_array[1], $option5_data_array[2], $optionitem5_data);
			
			
			//Setup Return Array
			$temp_product = array(
						"product_count" => $result_count,
						"product_id" => $row->product_id,
						"model_number" => $row->model_number,
						"activate_in_store" => $row->activate_in_store,
						"manufacturer_id" => $row->manufacturer_id, 
						"manufacturer_name" => $row->manufacturer_name, 
						"title" => $row->title, 
						"description" => $row->description, 
						"seo_description" => $row->seo_description, 
						"seo_keywords" => $row->seo_keywords, 
						"price" => $row->price, 
						"list_price" => $row->list_price, 
						"vat_rate" => $row->vat_rate,
						"stock_quantity" => $row->stock_quantity, 
						"weight" => $row->weight, 
						"use_optionitem_quantity_tracking" => $row->use_optionitem_quantity_tracking, 
						"use_specifications" => $row->use_specifications, 
						"specifications" => $row->specifications, 
						"use_customer_reviews" => $row->use_customer_reviews, 
						"show_on_startup" => $row->show_on_startup,
						"show_stock_quantity" => $row->show_stock_quantity, 
						"is_special" => $row->is_special, 
						"is_taxable" => $row->is_taxable, 
						"is_giftcard" => $row->is_giftcard, 
						"is_download" => $row->is_download,
						"is_donation" => $row->is_donation,
						"download_file_name" => $row->download_file_name,
						
						"option1" => $option1, 
						"option2" => $option2, 
						"option3" => $option3, 
						"option4" => $option4, 
						"option5" => $option5, 
						
						"use_optionitem_images" => $row->use_optionitem_images, 
						
						"image1" => $row->image1, 
						"image2" => $row->image2, 
						"image3" => $row->image3, 
						"image4" => $row->image4, 
						"image5" => $row->image5, 
						
						"optionitemimage_data" => $optionitemimage_data,
						
						"featured_product_id_1" => $row->featured_product_id_1, 
						"featured_product_id_2" => $row->featured_product_id_2, 
						"featured_product_id_3" => $row->featured_product_id_3, 
						"featured_product_id_4" => $row->featured_product_id_4,
						
						"review_data" => $review_data_array,
						"review_average" => $row->review_average,
						"views" => $row->views,
						"pricetier_data" => $pricetier_data_array2
			);
			
			array_push($product_list, $temp_product);
			
		}
		
		//Return Array
		return $product_list;
		
	}
	
	public function clean_search( $string ){
		return mysql_real_escape_string( $string );		
	}
	
	public function get_tempcart_product_quantity( $session_id, $product_id ){
		
		$sql = "SELECT SUM(tempcart.quantity) as quantity FROM ec_tempcart as tempcart WHERE tempcart.session_id = '%s' AND tempcart.product_id = %d";
		$result = $this->mysqli->get_row( $this->mysqli->prepare( $sql, $session_id, $product_id ) );
		return $result->quantity;
			
	}
	
	public function get_quantity_data( $product_id, $optionset1, $optionset2, $optionset3, $optionset4, $optionset5 ){
		
		$sql = 	"SELECT oiq.optionitem_id_1, oiq.optionitem_id_2, oiq.optionitem_id_3, oiq.optionitem_id_4, oiq.optionitem_id_5, COALESCE(SUM(oiq.quantity)) as quantity ";
		$sql .= "FROM ec_optionitemquantity as oiq ";
		$sql .= "LEFT JOIN ec_optionitem as oi1 ON oiq.optionitem_id_1 = oi1.optionitem_id ";
		$sql .= "LEFT JOIN ec_optionitem as oi2 ON oiq.optionitem_id_2 = oi2.optionitem_id ";
		$sql .= "LEFT JOIN ec_optionitem as oi3 ON oiq.optionitem_id_3 = oi3.optionitem_id ";
		$sql .= "LEFT JOIN ec_optionitem as oi4 ON oiq.optionitem_id_4 = oi4.optionitem_id ";
		$sql .= "LEFT JOIN ec_optionitem as oi5 ON oiq.optionitem_id_5 = oi5.optionitem_id ";	
		$sql .=	"WHERE oiq.product_id = %d AND quantity > 0 ";
		$sql .= "GROUP BY oiq.optionitem_id_1, oiq.optionitem_id_2, oiq.optionitem_id_3, oiq.optionitem_id_4, oiq.optionitem_id_5 ";
		$sql .= "ORDER BY oi1.optionitem_order, oi2.optionitem_order, oi3.optionitem_order, oi4.optionitem_order, oi5.optionitem_order";			
		
		$result = $this->mysqli->get_results($this->mysqli->prepare($sql, $product_id));
		
		$quantity_array = array();
		
		foreach($result as $row){
			array_push($quantity_array, array($row->optionitem_id_1, $row->optionitem_id_2, $row->optionitem_id_3, $row->optionitem_id_4, $row->optionitem_id_5, $row->quantity));
		}
		
		$return_array = array();
		
		for($a=0; $a<count($optionset1->optionset); $a++){
			$quantity = $this->get_level_1_quantity($quantity_array, $optionset1->optionset[$a]->optionitem_id);
			$arr = array(array(), $quantity);
			
			//Option 2 Loop
			for($b=0; $b<count($optionset2->optionset); $b++){
				$quantity = $this->get_level_2_quantity($quantity_array, $optionset1->optionset[$a]->optionitem_id, $optionset2->optionset[$b]->optionitem_id);
				array_push($arr[0], array(array(), $quantity));
				
				//Option 3 Loop
				for($c=0; $c<count($optionset3->optionset); $c++){
					$quantity = $this->get_level_3_quantity($quantity_array, $optionset1->optionset[$a]->optionitem_id, $optionset2->optionset[$b]->optionitem_id, $optionset3->optionset[$c]->optionitem_id);
					array_push($arr[0][$b][0], array(array(), $quantity));
					
					//Option 4 Loop
					for($d=0; $d<count($optionset4->optionset); $d++){
						$quantity = $this->get_level_4_quantity($quantity_array, $optionset1->optionset[$a]->optionitem_id, $optionset2->optionset[$b]->optionitem_id, $optionset3->optionset[$c]->optionitem_id, $optionset4->optionset[$d]->optionitem_id);
						array_push($arr[0][$b][0][$c][0], array(array(), $quantity));
						
						//Option 5 Loop
						for($e=0; $e<count($optionset5->optionset); $e++){
							$quantity = $this->get_level_5_quantity($quantity_array, $optionset1->optionset[$a]->optionitem_id, $optionset2->optionset[$b]->optionitem_id, $optionset3->optionset[$c]->optionitem_id, $optionset4->optionset[$d]->optionitem_id, $optionset5->optionset[$e]->optionitem_id);
							array_push($arr[0][$b][0][$c][0][$d][0], array(array(), $quantity));
						
						}//close e loop
					}//close d loop
				}//close c loop
			}//close b loop
			
			//push array for level 1
			array_push($return_array, $arr);
		}
		
		return $return_array;
		
	}
	
	private function get_level_1_quantity(&$values, $opt1){
		$quant = 0;
		for($i=0; $i<count($values); $i++){
			if($values[$i][0] == $opt1){
				$quant = $quant + $values[$i][5];
			}
		}
		return $quant;
	}
	
	private function get_level_2_quantity(&$values, $opt1, $opt2){
		$quant = 0;
		for($i=0; $i<count($values); $i++){
			if($values[$i][0] == $opt1 && $values[$i][1] == $opt2){
				$quant = $quant + $values[$i][5];
			}
		}
		return $quant;
	}
	
	private function get_level_3_quantity(&$values, $opt1, $opt2, $opt3){
		$quant = 0;
		for($i=0; $i<count($values); $i++){
			if($values[$i][0] == $opt1 && $values[$i][1] == $opt2 && $values[$i][2] == $opt3){
				$quant = $quant + $values[$i][5];
			}
		}
		return $quant;
	}
	
	private function get_level_4_quantity(&$values, $opt1, $opt2, $opt3, $opt4){
		$quant = 0;
		for($i=0; $i<count($values); $i++){
			if($values[$i][0] == $opt1 && $values[$i][1] == $opt2 && $values[$i][2] == $opt3 && $values[$i][3] == $opt4){
				$quant = $quant + $values[$i][5];
			}
		}
		return $quant;
	}
	
	private function get_level_5_quantity(&$values, $opt1, $opt2, $opt3, $opt4, $opt5){
		$quant = 0;
		for($i=0; $i<count($values); $i++){
			if($values[$i][0] == $opt1 && $values[$i][1] == $opt2 && $values[$i][2] == $opt3 && $values[$i][3] == $opt4 && $values[$i][4] == $opt5){
				$quant = $quant + $values[$i][5];
			}
		}
		return $quant;
	}
	
	public function get_perpage_values(){
		$vals = $this->mysqli->get_results( "SELECT perpage.perpage FROM ec_perpage as perpage ORDER BY perpage.perpage ASC" );
		$array = array( );
		foreach( $vals as $val ){
			$array[] = $val->perpage;	
		}
		return $array;
	}
	
	public function get_manufacturers( $level, $menuid ){
		
		if( $level == 0 )
			$sql = "SELECT manufacturer_id, name, (SELECT COUNT( ec_product.product_id )FROM ec_product WHERE ec_product.activate_in_store = 1 AND ec_product.show_on_startup = 1 AND ec_product.manufacturer_id = ec_manufacturer.manufacturer_id) as product_count FROM ec_manufacturer ORDER BY name ASC";
		else
			$sql = $this->mysqli->prepare( "SELECT manufacturer_id, name, (SELECT COUNT( ec_product.product_id )FROM ec_product WHERE ec_product.activate_in_store = 1 AND ec_product.manufacturer_id = ec_manufacturer.manufacturer_id AND ( ec_product.menulevel1_id_%d = %d OR ec_product.menulevel2_id_%d = %d OR ec_product.menulevel3_id_%d = %d ) ) as product_count FROM ec_manufacturer ORDER BY name ASC", $level, $menuid, $level, $menuid, $level, $menuid );
		
		return $this->mysqli->get_results( $sql );	
	}
	
	public function get_groups( ){
		
		$sql = $this->mysqli->prepare( "SELECT ec_category.category_id, ec_category.category_name FROM ec_category ORDER BY ec_category.category_name ASC", $level, $menuid, $level, $menuid, $level, $menuid );
		
		return $this->mysqli->get_results( $sql );	
	}
	
	public function get_pricepoint_row( $pricepoint_id ){
		$sql = "SELECT 
					ec_pricepoint.pricepoint_id, 
					ec_pricepoint.is_less_than, 
					ec_pricepoint.is_greater_than, 
					ec_pricepoint.low_point, 
					ec_pricepoint.high_point, 
					(
						SELECT COUNT( ec_product.product_id ) 
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.show_on_startup = 1 AND 
						ec_product.price < ec_pricepoint.high_point
					) as product_count_below,
					(
						SELECT COUNT( ec_product.product_id )
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.show_on_startup = 1 AND 
						ec_product.price > ec_pricepoint.low_point
					) as product_count_above,
					(
						SELECT COUNT( ec_product.product_id )
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.show_on_startup = 1 AND 
						ec_product.price <= ec_pricepoint.high_point AND 
						ec_product.price >= ec_pricepoint.low_point
					) as product_count_between
					 FROM ec_pricepoint 
					 WHERE ec_pricepoint.pricepoint_id = %d
					 ORDER BY ec_pricepoint.order ASC";
					 
		return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $pricepoint_id ) );
	}
	
	public function get_pricepoints( $level, $menuid, $manufacturerid ){
		if( $manufacturerid )
			$man_sql = $this->mysqli->prepare( " AND ec_product.manufacturer_id = %d", $manufacturerid );
		else
			$man_sql = "";
		
		if( $level == 0 )
			$sql = "SELECT 
					ec_pricepoint.pricepoint_id, 
					ec_pricepoint.is_less_than, 
					ec_pricepoint.is_greater_than, 
					ec_pricepoint.low_point, 
					ec_pricepoint.high_point, 
					(
						SELECT COUNT( ec_product.product_id ) 
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.show_on_startup = 1 AND 
						ec_product.price < ec_pricepoint.high_point
						" . $man_sql . "
					) as product_count_below,
					(
						SELECT COUNT( ec_product.product_id )
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.show_on_startup = 1 AND 
						ec_product.price > ec_pricepoint.low_point
						" . $man_sql . "
					) as product_count_above,
					(
						SELECT COUNT( ec_product.product_id )
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.show_on_startup = 1 AND 
						ec_product.price <= ec_pricepoint.high_point AND 
						ec_product.price >= ec_pricepoint.low_point
						" . $man_sql . "
					) as product_count_between
					 FROM ec_pricepoint 
					 ORDER BY ec_pricepoint.order ASC";
		else
			$sql = $this->mysqli->prepare( "SELECT 
					ec_pricepoint.pricepoint_id, 
					ec_pricepoint.is_less_than, 
					ec_pricepoint.is_greater_than, 
					ec_pricepoint.low_point, 
					ec_pricepoint.high_point, 
					(
						SELECT COUNT( ec_product.product_id ) 
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.price < ec_pricepoint.high_point AND
						( ec_product.menulevel1_id_%d = %d OR ec_product.menulevel2_id_%d = %d OR ec_product.menulevel3_id_%d = %d )
						" . $man_sql . "
					) as product_count_below,
					(
						SELECT COUNT( ec_product.product_id )
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.price > ec_pricepoint.low_point AND
						( ec_product.menulevel1_id_%d = %d OR ec_product.menulevel2_id_%d = %d OR ec_product.menulevel3_id_%d = %d )
						" . $man_sql . "
					) as product_count_above,
					(
						SELECT COUNT( ec_product.product_id )
						FROM ec_product 
						WHERE 
						ec_product.activate_in_store = 1 AND 
						ec_product.price <= ec_pricepoint.high_point AND 
						ec_product.price >= ec_pricepoint.low_point AND
						( ec_product.menulevel1_id_%d = %d OR ec_product.menulevel2_id_%d = %d OR ec_product.menulevel3_id_%d = %d )
						" . $man_sql . "
					) as product_count_between
					 FROM ec_pricepoint 
					 ORDER BY ec_pricepoint.order ASC", $level, $menuid, $level, $menuid, $level, $menuid, $level, $menuid, $level, $menuid, $level, $menuid, $level, $menuid, $level, $menuid, $level, $menuid );
					 
		
		return $this->mysqli->get_results( $sql );	
	}
	
	public function get_menuname( $menu_id, $menu_level ){
		if( $menu_level == 1 )
			return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT name FROM ec_menulevel1 WHERE menulevel1_id = '%s'", $menu_id ) );
		else if( $menu_level == 2 )
			return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT name FROM ec_menulevel2 WHERE menulevel2_id = '%s'", $menu_id ) );
		else if( $menu_level == 3 )
			return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT name FROM ec_menulevel3 WHERE menulevel3_id = '%s'", $menu_id ) );
	}
	
	public function get_menulevel1_id_from_menulevel2( $menulevel2_id ){
		return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT ec_menulevel2.menulevel1_id FROM ec_menulevel2 WHERE ec_menulevel2.menulevel2_id = '%s'", $menulevel2_id ) );
	}
	
	
	public function get_menulevel2_id_from_menulevel3( $menulevel3_id ){
		return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT ec_menulevel3.menulevel2_id FROM ec_menulevel3 WHERE ec_menulevel3.menulevel3_id = '%s'", $menulevel3_id ) );
	}
	
	public function get_customer_reviews( $product_id ){
		return $this->mysqli->get_results( "SELECT review_id, rating, title, description, approved, DATE_FORMAT(date_submitted, '%W, %M %e, %Y') as review_date " . $this->mysqli->prepare( "FROM ec_review WHERE product_id = '%s' AND approved = 1", $product_id ) );
	}
	
	public function get_temp_cart( $session_id ){
		$sql = "SELECT 
				product.product_id,
				product.model_number,
				product.manufacturer_id,
				product.price,
				product.handling_price,
				product.vat_rate,
				product.title,
				product.image1,
				product.weight,
				product.is_giftcard,
				product.is_download,
				product.is_donation,
				product.is_taxable,
				product.download_file_name,
				product.use_optionitem_quantity_tracking,
				product.show_stock_quantity,
				product.maximum_downloads_allowed,
				product.download_timelimit_seconds,
				
				tempcart.tempcart_id as cartitem_id,
				tempcart.quantity,
				optionitemimage.image1 as optionitemimage_image1,
				
				CONCAT_WS('***', optionitem1.optionitem_name, optionitem1.optionitem_price, option1.option_name, optionitem1.optionitem_id) as optionitem1_data,
				CONCAT_WS('***', optionitem2.optionitem_name, optionitem2.optionitem_price, option2.option_name, optionitem2.optionitem_id) as optionitem2_data,
				CONCAT_WS('***', optionitem3.optionitem_name, optionitem3.optionitem_price, option3.option_name, optionitem3.optionitem_id) as optionitem3_data,
				CONCAT_WS('***', optionitem4.optionitem_name, optionitem4.optionitem_price, option4.option_name, optionitem4.optionitem_id) as optionitem4_data,
				CONCAT_WS('***', optionitem5.optionitem_name, optionitem5.optionitem_price, option5.option_name, optionitem5.optionitem_id) as optionitem5_data, 
				 
				tempcart.gift_card_message, 
				tempcart.gift_card_to_name, 
				tempcart.gift_card_from_name,
				
				tempcart.donation_price,

				( 
					SELECT GROUP_CONCAT( CONCAT_WS('***', ec_pricetier.price, ec_pricetier.quantity) SEPARATOR '---' ) 
					FROM ec_pricetier 
					WHERE ec_pricetier.`product_id` = tempcart.product_id 
					ORDER BY ec_pricetier.quantity ASC 
				) as pricetier_data
				
				FROM 
				ec_tempcart as tempcart
				
				LEFT JOIN ec_product as product
				ON product.product_id = tempcart.product_id
				
				LEFT JOIN ec_optionitem as optionitem1
				ON optionitem1.optionitem_id = tempcart.optionitem_id_1
				
				LEFT JOIN ec_optionitemimage as optionitemimage
				ON (optionitemimage.product_id = product.product_id AND optionitemimage.optionitem_id = optionitem1.optionitem_id)
				
				LEFT JOIN ec_option as option1
				ON option1.option_id = optionitem1.option_id
				
				LEFT JOIN ec_optionitem as optionitem2
				ON optionitem2.optionitem_id = tempcart.optionitem_id_2
				
				LEFT JOIN ec_option as option2
				ON option2.option_id = optionitem2.option_id
				
				LEFT JOIN ec_optionitem as optionitem3
				ON optionitem3.optionitem_id = tempcart.optionitem_id_3
				
				LEFT JOIN ec_option as option3
				ON option3.option_id = optionitem3.option_id
				
				LEFT JOIN ec_optionitem as optionitem4
				ON optionitem4.optionitem_id = tempcart.optionitem_id_4
				
				LEFT JOIN ec_option as option4
				ON option4.option_id = optionitem4.option_id
				
				LEFT JOIN ec_optionitem as optionitem5
				ON optionitem5.optionitem_id = tempcart.optionitem_id_5
				
				LEFT JOIN ec_option as option5
				ON option5.option_id = optionitem5.option_id
				
				WHERE 
				tempcart.session_id = '%s'
				
				ORDER BY
				product.title ASC
				";
				
		$cart_array = $this->mysqli->get_results( $this->mysqli->prepare( $sql, $session_id ) );
		$cart = array();
		foreach($cart_array as $row){
			array_push($cart, new ec_cartitem( $row ) );
		}
		return $cart;
	}
	
	// IN: the Product ID
	// OUT: Product array (
	public function get_cart_product( $productid ){
			
	}
	
	public function get_menu_items(){
		$sql = "SELECT menulevel1.name as menu1_name, menulevel1.menulevel1_id, menulevel2.name as menu2_name, menulevel2.menulevel2_id, menulevel3.name as menu3_name, menulevel3.menulevel3_id FROM ec_menulevel1 as menulevel1 LEFT JOIN ec_menulevel2 as menulevel2 ON menulevel2.menulevel1_id = menulevel1.menulevel1_id LEFT JOIN ec_menulevel3 as menulevel3 ON menulevel3.menulevel2_id = menulevel2.menulevel2_id ORDER BY menulevel1.order, menulevel2.order, menulevel3.order";
		$result = $this->mysqli->get_results($sql);
		return $result;
	}
	
	public function submit_customer_review( $product_id, $rating, $title, $description ){
		return $this->mysqli->insert( 	'ec_review', 
										array( 	'product_id' => $product_id, 
												'rating' => $rating, 
												'title' => $title, 
												'description' => $description 
										), 
										array( '%d', '%d', '%s', '%s' )
									);
	}
	
	public function get_category_items( &$level, $menu_id, $submenu_id, $subsubmenu_id ){
		$sql_level0 = "SELECT 
						ec_menulevel1.name as menu_name, 
						ec_menulevel1.menulevel1_id as menu_id,
						( 	SELECT count( ec_product.product_id ) 
							FROM ec_product 
							WHERE 
							ec_product.activate_in_store = 1 AND 
							(
								ec_menulevel1.menulevel1_id = ec_product.menulevel1_id_1 OR
								ec_menulevel1.menulevel1_id = ec_product.menulevel2_id_1 OR
								ec_menulevel1.menulevel1_id = ec_product.menulevel3_id_1
							)
						) as product_count
						
						FROM 
						ec_menulevel1
						 
						ORDER BY 
						ec_menulevel1.order"; 
						
		$sql_level1 = "SELECT 
						ec_menulevel2.name as menu_name, 
						ec_menulevel2.menulevel2_id as menu_id, 
						( 	SELECT count( ec_product.product_id ) 
							FROM ec_product 
							WHERE 
							ec_product.activate_in_store = 1 AND 
							(
								ec_menulevel2.menulevel2_id = ec_product.menulevel1_id_2 OR
								ec_menulevel2.menulevel2_id = ec_product.menulevel2_id_2 OR
								ec_menulevel2.menulevel2_id = ec_product.menulevel3_id_2
							)
						) as product_count
						
						FROM ec_menulevel2 
						
						WHERE ec_menulevel2.menulevel1_id = %d 
						
						ORDER BY ec_menulevel2.order";
						
		$sql_level2 = "SELECT 
						ec_menulevel3.name as menu_name, 
						ec_menulevel3.menulevel3_id as menu_id, 
						( 	SELECT count( ec_product.product_id ) 
							FROM ec_product 
							WHERE 
							ec_product.activate_in_store = 1 AND 
							(
								ec_menulevel3.menulevel3_id = ec_product.menulevel1_id_3 OR
								ec_menulevel3.menulevel3_id = ec_product.menulevel2_id_3 OR
								ec_menulevel3.menulevel3_id = ec_product.menulevel3_id_3
							)
						) as product_count
						
						FROM ec_menulevel3 
						
						WHERE ec_menulevel3.menulevel2_id = %d 
						
						ORDER BY ec_menulevel3.order";
		
		$sql_get_menuid = "SELECT ec_menulevel2.menulevel1_id FROM ec_menulevel2 WHERE ec_menulevel2.menulevel2_id = %d";
		$sql_get_submenuid = "SELECT ec_menulevel3.menulevel2_id FROM ec_menulevel3 WHERE ec_menulevel3.menulevel3_id = %d";
		
		if( $level == 0 ){
			return $this->mysqli->get_results( $sql_level0 );
		
		}else if( $level == 1 ){
			$results = $this->mysqli->get_results( $this->mysqli->prepare( $sql_level1, $menu_id ) );
			if( count( $results ) > 0 )
				return $results;
			else{
				$level = 0;
				return $this->mysqli->get_results( $sql_level0 );
			}
				
		}else if( $level == 2 ){ 
			$results = $this->mysqli->get_results( $this->mysqli->prepare( $sql_level2, $submenu_id ) );
			if( count( $results ) > 0 )
				return $results;
			else{
				$level = 1;
				$menu_id = $this->mysqli->get_var( $this->mysqli->prepare( $sql_get_menuid, $submenu_id ) );
				return $this->mysqli->get_results( $this->mysqli->prepare( $sql_level1, $menu_id ) );
			}
			
		}else if( $level == 3 ){
			$level = 2;
			$submenu_id = $this->mysqli->get_var( $this->mysqli->prepare( $sql_get_submenuid, $subsubmenu_id ) );
			$results = $this->mysqli->get_results( $this->mysqli->prepare( $sql_level2, $submenu_id ) );
			
			if( count( $results ) > 0 )
				return $results;
			else{
				$level = 1;
				$menuid = $this->mysqli->get_var( $this->mysqli->prepare( $sql_get_menuid, $submenu_id ) );
				return $this->mysqli->get_results(  $this->mysqli->prepare( $sql_level1, $menu_id ) );
			}
		}
	}
	
	public function get_promotions( ){
		return $this->mysqli->get_results( "SELECT 
											ec_promotion.promotion_id, ec_promotion.type as promotion_type, ec_promotion.name as promotion_name,
											ec_promotion.start_date, ec_promotion.end_date, 
											ec_promotion.product_id_1, ec_promotion.product_id_2, ec_promotion.product_id_3, 
											ec_promotion.manufacturer_id_1, ec_promotion.manufacturer_id_2, ec_promotion.manufacturer_id_3, 
											ec_promotion.category_id_1, ec_promotion.category_id_2, ec_promotion.category_id_3, 
											ec_promotion.price1, ec_promotion.price2, ec_promotion.price3, 
											ec_promotion.percentage1, ec_promotion.percentage2, ec_promotion.percentage3, 
											ec_promotion.number1, ec_promotion.number2, ec_promotion.number3, 
											ec_promotion.limit as product_limit,
											NOW() as currdate
											
											FROM ec_promotion 
											HAVING ec_promotion.start_date <= currdate AND ec_promotion.end_date >= currdate" );
	}
	
	public function has_category_match( $category_id, $product_id ){
		$count = $this->mysqli->get_var( $this->mysqli->prepare( "SELECT COUNT( categoryitem_id ) FROM ec_categoryitem WHERE category_id = %d AND product_id = %d", $category_id, $product_id ) );
		if( $count > 0 )
			return true;
		else
			return false;
	}
	
	public function add_to_cart( $product_id, $session_id, $quantity, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4, $optionitem_id_5, $gift_card_message="", $gift_card_to_name="", $gift_card_from_name="", $donation_price=0.00 ){
		
		// Get the limit on this product
		$product_sql = "SELECT stock_quantity, use_optionitem_quantity_tracking FROM ec_product WHERE product_id = %d";
		$optionitem_sql = "SELECT quantity FROM ec_optionitemquantity WHERE product_id = %d AND optionitem_id_1 = %d AND optionitem_id_2 = %d AND optionitem_id_3 = %d AND optionitem_id_4 = %d AND optionitem_id_5 = %d";
		$tempcart_optionitem_sql = "SELECT quantity FROM ec_tempcart WHERE session_id = '%s' AND product_id = %d AND optionitem_id_1 = %d AND optionitem_id_2 = %d AND optionitem_id_3 = %d AND optionitem_id_4 = %d AND optionitem_id_5 = %d";
		
		$tempcart_sql = "SELECT SUM(quantity) as quantity FROM ec_tempcart WHERE session_id = '%s' AND product_id = %d";
		
		$stock_quantity = 99999999999; // very large limit... nearly infinite really
		
		//Get this product stock quantity and use_optionitem_quantity tracking
		$product = $this->mysqli->get_row( $this->mysqli->prepare( $product_sql, $product_id ) );
		//Get this tempcart item quantity
		$tempcart_optionitem = $this->mysqli->get_row( $this->mysqli->prepare( $tempcart_optionitem_sql, $session_id, $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4, $optionitem_id_5 ) );
		//Get this tempcart total quantity
		$tempcart = $this->mysqli->get_row( $this->mysqli->prepare( $tempcart_sql, $session_id, $product_id ) );
		//
		$optionitem_quantity = $this->mysqli->get_row( $this->mysqli->prepare( $optionitem_sql, $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4, $optionitem_id_5 ) );
		
		if( $product->use_optionitem_quantity_tracking == 1 ){
			$stock_quantity = $optionitem_quantity->quantity;
		}else if( isset( $product->show_stock_quantity ) && $product->show_stock_quantity == 1 ){
			$stock_quantity = $product->stock_quantity;
		}else{
			$stock_quantity = 1000000;
		}
		
		//Get the quantity for the new tempcart item (insert or update)
		// OPTION ITEM QUANTITY TRACKING AND ENTERED QUANITTY GOES OVER ITEM LIMIT
		// IF    1. using option item quantity tracking
		//       2. quantity + item in cart with same options quantity > amount available for this option
		// THEN     use max for that option item set
		if( $product->use_optionitem_quantity_tracking == 1 && isset( $tempcart_optionitem ) && $quantity + $tempcart_optionitem->quantity > $stock_quantity ){			
			$quantity = $stock_quantity;
		
		// OPTION ITEM QUANTITY TRACKING AND AMOUNT ENTERED IS TOO MUCH
		// IF    1. using option item quanitty tracking
		//       2. item with theme options is not in the cart yet
		// THEN     use the quantity entered by the user
		}else if( $product->use_optionitem_quantity_tracking == 1 && $quantity > $optionitem_quantity ){
			$quantity = $optionitem_quantity;
			
		// OPTION ITEM QUANTITY TRACKING AND NONE YET ADDED
		// IF    1. using option item quanitty tracking
		//       2. item with theme options is not in the cart yet
		// THEN     use the quantity entered by the user
		}else if( $product->use_optionitem_quantity_tracking == 1 && !$tempcart_optionitem ){
			// USE THE QUANITTY ENTERED
		
		// BASIC QUANTITY TRACKING and THIS OPTION CHOICE IS IN CART and ENTERED QUANTITY + ALL QUANITY OF SAME PROD IDS MORE THAN QUANTITY IN STOCK
		// IF    1. using general quantity tracking
		//       2. quantity + the quantity of all items with same product id > amount available
		// THEN     use the total in stock - the total in cart so far
		}else if( isset( $product->show_stock_quantity ) && $tempcart_optionitem && $quantity + $tempcart->quantity > $stock_quantity ){			
			$quantity = $stock_quantity - $tempcart->quantity + $tempcart_optionitem->quantity;
		
		// BASIC QUANTITY TRACKING and THIS OPTION CHOICE IS NOT IN CART and ENTERED QUANTITY + ALL QUANITY OF SAME PROD IDS MORE THAN QUANTITY IN STOCK
		// IF    1. using general quantity tracking
		//       2. quantity + the quantity of all items with same product id > amount available
		// THEN     use the total in stock - the total in cart so far
		}else if( isset( $product->show_stock_quantity ) && $quantity + $tempcart->quantity > $stock_quantity ){			
			$quantity = $stock_quantity - $tempcart->quantity;
		
		// BASIC QUANTITY TRACKING and THIS OPTION CHOICE IS IN CART
		// IF    1. using general quantity tracking
		//       2. quantity + the quantity of all items with same product id > amount available
		// THEN     use the total in stock - the total in cart so far
		}else if( isset( $product->show_stock_quantity ) && $tempcart_optionitem ){			
			$quantity = $quantity + $tempcart_optionitem + $quantity;	
		
		// BASIC QUANTITY TRACKING and THIS OPTION CHOICE IS NOT IN CART
		// IF    1. using general quantity tracking
		//       2. quantity + the quantity of all items with same product id > amount available
		// THEN     use the total in stock - the total in cart so far
		}else if( isset( $product->show_stock_quantity ) ){			
			// USE QUANTITY ENTERED
		
		// NO QUANITTY TRACKING
		// THEN     use the quantity entered + the quantity for this option item in cart
		}else{																		
			if( isset( $tempcart_optionitem ) )
				$quantity = $quantity + $tempcart_optionitem->quantity;
		}
		
		// First check for an item with the same option items IF NOT a gift card
		$sql = "SELECT COUNT(tempcart_id) AS total_rows FROM ec_tempcart WHERE session_id = '%s' AND product_id = %d AND optionitem_id_1 = %d AND optionitem_id_2 = %d AND optionitem_id_3 = %d AND optionitem_id_4 = %d AND optionitem_id_5 = %d";
		$insert = $this->mysqli->get_var( $this->mysqli->prepare( $sql, $session_id, $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4, $optionitem_id_5 ) );
		
		if( $gift_card_message != "" || $gift_card_from_name != "" || $gift_card_to_name != "" || ( $insert == 0 && $quantity > 0 ) ){
			$this->mysqli->insert( 'ec_tempcart', 
										array( 	'product_id' 					=> $product_id,
												'session_id' 					=> $session_id, 
												'quantity'						=> $quantity, 
												'optionitem_id_1' 				=> $optionitem_id_1, 
												'optionitem_id_2' 				=> $optionitem_id_2, 
												'optionitem_id_3'				=> $optionitem_id_3, 
												'optionitem_id_4' 				=> $optionitem_id_4, 
												'optionitem_id_5' 				=> $optionitem_id_5, 
												'gift_card_message' 			=> $gift_card_message, 
												'gift_card_from_name' 			=> $gift_card_from_name, 
												'gift_card_to_name' 			=> $gift_card_to_name, 
												'donation_price'				=> $donation_price
										), 
										array( '%d', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s' )
									);							
		}else if($insert != 0){
			$this->mysqli->update(	'ec_tempcart', 
										array(	'quantity'						=> $quantity ),
										array( 	'product_id' 					=> $product_id,
												'session_id' 					=> $session_id, 
												'optionitem_id_1' 				=> $optionitem_id_1, 
												'optionitem_id_2' 				=> $optionitem_id_2, 
												'optionitem_id_3'				=> $optionitem_id_3, 
												'optionitem_id_4' 				=> $optionitem_id_4, 
												'optionitem_id_5' 				=> $optionitem_id_5
										), 
										array( '%d', '%d', '%s', '%d', '%d', '%d', '%d', '%d' )
								  );	
		}
		
		return $this->get_temp_cart( $session_id );
	}
	
	public function update_cartitem( $tempcart_id, $session_id, $quantity ){
		
		$tempcart_item_sql = "SELECT product_id, optionitem_id_1, optionitem_id_2, optionitem_id_3, optionitem_id_4, optionitem_id_5 FROM ec_tempcart WHERE tempcart_id = %d";
		$tempcart_item = $this->mysqli->get_row( $this->mysqli->prepare( $tempcart_item_sql, $tempcart_id ) );
		$product_id = $tempcart_item->product_id;
		$optionitem_id_1 = $tempcart_item->optionitem_id_1;
		$optionitem_id_2 = $tempcart_item->optionitem_id_2;
		$optionitem_id_3 = $tempcart_item->optionitem_id_3;
		$optionitem_id_4 = $tempcart_item->optionitem_id_4;
		$optionitem_id_5 = $tempcart_item->optionitem_id_5;
		
		// Get the limit on this product
		$product_sql = "SELECT show_stock_quantity, stock_quantity, use_optionitem_quantity_tracking FROM ec_product WHERE product_id = %d";
		$optionitem_sql = "SELECT quantity FROM ec_optionitemquantity WHERE product_id = %d AND optionitem_id_1 = %d AND optionitem_id_2 = %d AND optionitem_id_3 = %d AND optionitem_id_4 = %d AND optionitem_id_5 = %d";
		$tempcart_optionitem_sql = "SELECT quantity FROM ec_tempcart WHERE session_id = '%s' AND product_id = '%s' AND optionitem_id_1 = '%s' AND optionitem_id_2 = '%s' AND optionitem_id_3 = '%s' AND optionitem_id_4 = '%s' AND optionitem_id_5 = '%s'";
		$tempcart_sql = "SELECT SUM(quantity) as quantity FROM ec_tempcart WHERE session_id = '%s' AND product_id = %d";
		
		$stock_quantity = 99999999999; // very large limit... nearly infinite really
		
		//Get this product stock quantity and use_optionitem_quantity tracking
		$product = $this->mysqli->get_row( $this->mysqli->prepare( $product_sql, $product_id ) );
		
		//Get this tempcart item quantity
		$tempcart_optionitem = $this->mysqli->get_row( $this->mysqli->prepare( $tempcart_optionitem_sql, $session_id, $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4, $optionitem_id_5 ) );
		
		//Get this tempcart total quantity
		$tempcart = $this->mysqli->get_row( $this->mysqli->prepare( $tempcart_sql, $session_id, $product_id ) );
		
		//Get the maximum for this option item
		$optionitem_quantity = $this->mysqli->get_row( $this->mysqli->prepare( $optionitem_sql, $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4, $optionitem_id_5 ) );
		
		if( $product->use_optionitem_quantity_tracking == 1 ){
			$stock_quantity = $optionitem_quantity->quantity;
		}else if( $product->show_stock_quantity == 1 ){
			$stock_quantity = $product->stock_quantity;
		}else{
			$stock_quantity = 1000000;
		}
		
		if( $product->use_optionitem_quantity_tracking == 1 && $quantity > $stock_quantity ){			
			$quantity = $stock_quantity;
		
		}else if( $product->show_stock_quantity == 1 && $quantity > $stock_quantity ){			
			$quantity = $stock_quantity;
		
		}else if( $product->show_stock_quantity == 1 && $tempcart->quantity - $tempcart_optionitem->quantity + $quantity > $stock_quantity ){			
			$quantity = $stock_quantity - ( $tempcart->quantity - $tempcart_optionitem->quantity );
		
		}
		
		$this->mysqli->update( 	'ec_tempcart',
								array( 	'quantity' => $quantity ),
								array( 	'tempcart_id' => $tempcart_id, 'session_id' => $session_id ),
								array(	'%d', '%s', '%s' )
							  );
							
	}
	
	public function delete_cartitem( $tempcart_id, $session_id ){
		$sql = "DELETE FROM ec_tempcart WHERE ec_tempcart.tempcart_id = '%s' AND ec_tempcart.session_id = '%s'";
		$this->mysqli->query( $this->mysqli->prepare( $sql, $tempcart_id, $session_id ) );
		
		$sql = "SELECT 

				SUM( ec_tempcart.quantity ) as quantity,
				
				SUM( 
					( ec_product.price + 
					  IFNULL(optionitem1.optionitem_price, 0) + 
					  IFNULL(optionitem2.optionitem_price, 0) + 
					  IFNULL(optionitem3.optionitem_price, 0) + 
					  IFNULL(optionitem4.optionitem_price, 0) + 
					  IFNULL(optionitem5.optionitem_price, 0) 
					) * ec_tempcart.quantity
				) as total_price 
				
				FROM 
				ec_tempcart 
				
				LEFT JOIN ec_product 
				ON ec_product.product_id = ec_tempcart.product_id 
				
				LEFT JOIN ec_optionitem as `optionitem1`
				ON optionitem1.`optionitem_id` = ec_tempcart.`optionitem_id_1`
				
				LEFT JOIN ec_optionitem as `optionitem2`
				ON optionitem2.`optionitem_id` = ec_tempcart.`optionitem_id_2`
				
				LEFT JOIN ec_optionitem as `optionitem3`
				ON optionitem3.`optionitem_id` = ec_tempcart.`optionitem_id_3`
				
				LEFT JOIN ec_optionitem as `optionitem4`
				ON optionitem4.`optionitem_id` = ec_tempcart.`optionitem_id_4`
				
				LEFT JOIN ec_optionitem as `optionitem5`
				ON optionitem5.`optionitem_id` = ec_tempcart.`optionitem_id_5`
				
				WHERE session_id = '%s'";
		return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $session_id ) );
	}
	
	public function get_shipping_data( ){
		$sql = "SELECT ec_shippingrate.shippingrate_id, ec_shippingrate.is_price_based, ec_shippingrate.is_weight_based, ec_shippingrate.is_method_based, ec_shippingrate.is_ups_based, ec_shippingrate.is_usps_based, ec_shippingrate.is_fedex_based, ec_shippingrate.trigger_rate, ec_shippingrate.shipping_rate, ec_shippingrate.shipping_label, ec_shippingrate.shipping_order, ec_shippingrate.shipping_code FROM ec_shippingrate ORDER BY ec_shippingrate.is_price_based DESC, ec_shippingrate.is_weight_based DESC, ec_shippingrate.is_method_based DESC, ec_shippingrate.trigger_rate DESC, ec_shippingrate.trigger_rate DESC, ec_shippingrate.shipping_order";
		return $this->mysqli->get_results( $sql );
		
	}
	
	public function redeem_coupon_code( $couponcode ){
		$sql = "SELECT 
				ec_promocode.is_dollar_based, 
				ec_promocode.is_percentage_based, 
				ec_promocode.is_shipping_based, 
				ec_promocode.is_free_item_based, 
				ec_promocode.is_for_me_based, 
				ec_promocode.by_manufacturer_id, 
				ec_promocode.by_product_id, 
				ec_promocode.by_all_products, 
				ec_promocode.promo_dollar, 
				ec_promocode.promo_percentage, 
				ec_promocode.promo_shipping, 
				ec_promocode.promo_free_item, 
				ec_promocode.promo_for_me, 
				ec_promocode.manufacturer_id, 
				ec_promocode.product_id, 
				ec_promocode.message 
				
				FROM 
				ec_promocode 
				
				WHERE 
				ec_promocode.promocode_id = '%s'";
				
		return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $couponcode ) );	
	}
	
	public function redeem_gift_card( $giftcardcode ){
		$sql = "SELECT 
				ec_giftcard.amount, 
				ec_giftcard.message 
				
				FROM 
				ec_giftcard
				
				WHERE 
				ec_giftcard.giftcard_id = '%s'";
				
		return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $giftcardcode ) );	
	}
	
	public function update_giftcard_total( $giftcard_code, $giftcard_discount ){
		$this->mysqli->query( $this->mysqli->prepare( "UPDATE ec_giftcard SET amount = amount - '%s' WHERE giftcard_id = '%s'", $giftcard_discount, $giftcard_code ) );
	}
	
	public function get_taxrates( ){
		$sql = "SELECT taxrate_id, tax_by_state, tax_by_country, tax_by_duty, tax_by_vat, tax_by_all, state_rate, country_rate, duty_rate, vat_rate, all_rate, state_code, country_code,vat_country_code, duty_exempt_country_code FROM ec_taxrate ORDER BY tax_by_vat, tax_by_duty, tax_by_all, tax_by_country, tax_by_state";
		return $this->mysqli->get_results( $sql );
	}
	
	public function get_registration_code( ){
		$sql = "SELECT ec_setting.reg_code FROM ec_setting WHERE ec_setting.setting_id = 1";
		return $this->mysqli->get_var( $sql );
	}
	
	public function install( $install_sql_array ){
		if( !$this->mysqli->get_var( "show tables like 'ec_product'" ) ){
		
			foreach( $install_sql_array as $stmt ){
				if( strlen( $stmt ) > 3 ){
					$this->mysqli->query( $stmt );
				}
			}
		
		}
		return true;
	} 
	
	public function upgrade( $upgrade_sql_array ){
		foreach( $upgrade_sql_array as $stmt ){
			if( strlen( $stmt ) > 3 ){
				$this->mysqli->query( $stmt );
			}
		}
		return true;
	} 
	
	public function uninstall( $install_sql_array ){
		foreach( $install_sql_array as $stmt ){
			if( strlen( $stmt ) > 3 ){
				$this->mysqli->query( $stmt );
			}
		}
		return true;
	} 
	
	public function update_url( $site_url ){
		//First check if tables exists
		$this->mysqli->query( $this->mysqli->prepare( "UPDATE ec_setting SET site_url = '%s'", $site_url ) );
	}
	
	public function get_shipping_method_name( $ship_id ){
		return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT shipping_label FROM ec_shippingrate WHERE shippingrate_id = '%s'", $ship_id ) );	
	}
	
	public function insert_order( $cart, $user, $shipping, $tax, $discount, $order_totals, $payment, $payment_type, $orderstatus_id, $order_notes ){
		
		// Get Payment Method to Save
		if( $payment_type == "manual_bill" )
			$payment_type = $GLOBALS['language']->get_text( "account_order_details", "account_order_details_payment_method_manual" );
		else if( $payment_type == "third_party" )
			$payment_type = get_option( 'ec_option_payment_third_party' );
		
		// Get Shipping Method to Save
		$shipping_method = "";
		if( isset( $_SESSION['ec_shipping_method'] ) && $_SESSION['ec_shipping_method'] != "standard" )
			$shipping_method = $this->get_shipping_method_name( $_SESSION['ec_shipping_method'] );
		else if( ( $shipping->shipping_method == "price" || $shipping->shipping_method == "weight" ) && isset( $_SESSION['ec_ship_express'] ) )
			$shipping_method = $GLOBALS['language']->get_text( "cart_estimate_shipping", "cart_estimate_shipping_express" );
		else
			$shipping_method = $GLOBALS['language']->get_text( "cart_estimate_shipping", "cart_estimate_shipping_standard" );
		
		// Gift Card and Coupon Code
		$coupon_code = "";
		if( isset( $_SESSION['ec_couponcode'] ) )
			$coupon_code = $_SESSION['ec_couponcode'];
		
		$gift_card = "";
		if( isset( $_SESSION['ec_giftcard'] ) )
			$gift_card = $_SESSION['ec_giftcard'];
			
		$expedited_shipping = 0;
		if( isset( $_SESSION['ec_ship_express'] ) )
			$expedited_shipping = $_SESSION['ec_ship_express'];
		
		$this->mysqli->insert(  'ec_order', 
								array( 	'user_id' 						=> $user->user_id, 
										'last_updated' 					=> date( 'Y-m-d H:i:s' ),
										'orderstatus_id'				=> $orderstatus_id,
										'order_weight' 					=> $cart->weight,
										'sub_total'						=> $order_totals->sub_total,
										
										'tax_total'						=> $order_totals->tax_total,
										'shipping_total'				=> $order_totals->shipping_total,
										'duty_total'					=> $order_totals->duty_total,
										'discount_total'				=> $order_totals->discount_total,
										'vat_total'						=> $order_totals->vat_total,
										
										'grand_total' 					=> $order_totals->grand_total,
										'promo_code'					=> $coupon_code,
										'giftcard_id'					=> $gift_card,
										'use_expedited_shipping'		=> $expedited_shipping,
										'shipping_method'				=> $shipping_method,
										
										'user_email'					=> $user->email,
										'user_level'					=> $user->user_level,
										'billing_first_name'			=> $user->billing->first_name,
										'billing_last_name'				=> $user->billing->last_name,
										'billing_address_line_1'		=> $user->billing->address_line_1,
										
										'billing_address_line_2'		=> $user->billing->address_line_2,
										'billing_city'					=> $user->billing->city,
										'billing_state'					=> $user->billing->state,
										'billing_country'				=> $user->billing->country,
										'billing_zip'					=> $user->billing->zip,
										
										'billing_phone'					=> $user->billing->phone,
										'shipping_first_name'			=> $user->shipping->first_name,
										'shipping_last_name'			=> $user->shipping->last_name,
										'shipping_address_line_1'		=> $user->shipping->address_line_1,
										'shipping_address_line_2'		=> $user->shipping->address_line_2,
										
										'shipping_city'					=> $user->shipping->city,
										'shipping_state'				=> $user->shipping->state,
										'shipping_country'				=> $user->shipping->country,
										'shipping_zip'					=> $user->shipping->zip,
										'shipping_phone'				=> $user->shipping->phone,
										
										'payment_method'				=> $payment_type,
										'order_customer_notes'			=> $order_notes
								), 
								array( 	'%d', '%s', '%d', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s'
								)
							);	
									
		return $this->mysqli->insert_id;
	}
	
	public function update_order_status( $order_id, $orderstatus_id ){
		return $this->mysqli->update(  'ec_order',
									array( 'orderstatus_id' 	=> $orderstatus_id ),
									array( 'order_id'			=> $order_id ),
									array( '%d', '%d' )
								  );
								
	}
	
	public function get_order_id_from_temp_id( $temp_order_id ){
		return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT order_id FROM ec_order WHERE temp_order_id = '%s'", $temp_order_id ) );	
	}
	
	public function get_response_from_order_id( $order_id ){
		return $this->mysqli->get_var( $this->mysqli->prepare( "SELECT is_error FROM ec_response WHERE order_id = '%s'" ) );
	}
	
	public function update_reponse_order_id( $order_id, $temp_order_id, $processor ){
		if( $processor == "Skrill" ){
			$this->mysqli->update( 'ec_response',
									array( 'order_id'		=> $order_id ),
									array( 'skrill_transaction_id'	=> $temp_order_id ),
									array( '%s', '%s' )
								  );
		}
	}
	
	public function remove_order( $order_id ){
		$this->mysqli->query( $this->mysqli->prepare( "DELETE FROM ec_order WHERE order_id = %d", $order_id ) );
	}
	
	public function insert_address( $first_name, $last_name, $address_line_1, $city, $state, $zip, $country, $phone ){
		$this->mysqli->insert(	'ec_address',
								array(	"first_name"		=> $first_name,
										"last_name"			=> $last_name,
										"address_line_1"	=> $address_line_1,
										"city"				=> $city,
										"state"				=> $state,
										"zip"				=> $zip,
										"country"			=> $country,
										"phone"				=> $phone
									  ),
								array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
							  );
		
		return $this->mysqli->insert_id;	
	}
	
	public function insert_user( $email, $password, $first_name, $last_name, $billing_id, $shipping_id, $user_level, $is_subscriber ){
		if( $is_subscriber )
			$this->insert_subscriber( $email, $first_name, $last_name );
		else
			$this->remove_subscriber( $email );
		
		$this->mysqli->insert(	'ec_user',
								array(	"email"							=> $email,
										"password"						=> $password,
										"first_name"					=> $first_name,
										"last_name"						=> $last_name,
										"default_billing_address_id"	=> $billing_id,
										"default_shipping_address_id"	=> $shipping_id,
										"user_level"					=> $user_level,
										"is_subscriber"					=> $is_subscriber
									  ),
								array( '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%d' )
							  );
		
		return $this->mysqli->insert_id;
	}
	
	public function insert_subscriber( $email, $first_name, $last_name ){
		$this->mysqli->insert( 'ec_subscriber',
								array(	"email"			=> $email,
										"first_name"	=> $first_name,
										"last_name"		=> $last_name ),
								array( '%s', '%s', '%s' )
							);
	}
	
	public function remove_subscriber( $email ){
		$this->mysqli->query( $this->mysqli->prepare( "DELETE FROM ec_subscriber WHERE email = '%s'", $email ) );
	}
	
	public function update_address_user_id( $address_id, $user_id ){
		$this->mysqli->update(	'ec_address',
								array(	"user_id"	=> $user_id ),
								array(	"address_id"	=> $address_id),
								array(	'%s', '%s' )
							  );	
	}
	
	public function insert_order_detail( $order_id, $giftcard_id, $download_key, $cart_item ){
		
		if( $cart_item->image1_optionitem )	$image1 = $cart_item->image1_optionitem;
		else								$image1 = $cart_item->image1;
		
		$this->mysqli->insert(	'ec_orderdetail',
								array(	'order_id'						=> $order_id,
										'product_id'					=> $cart_item->product_id,
										'title'							=> $cart_item->title,
										'model_number'					=> $cart_item->model_number,
										'unit_price'					=> $cart_item->unit_price,
										
										'total_price'					=> $cart_item->total_price,
										'quantity'						=> $cart_item->quantity,
										'image1'						=> $image1,
										
										'optionitem_name_1'				=> $cart_item->optionitem1_name,
										'optionitem_name_2'				=> $cart_item->optionitem2_name,
										'optionitem_name_3'				=> $cart_item->optionitem3_name,
										'optionitem_name_4'				=> $cart_item->optionitem4_name,
										'optionitem_name_5'				=> $cart_item->optionitem5_name,
										
										'optionitem_label_1'			=> $cart_item->optionitem1_label,
										'optionitem_label_2'			=> $cart_item->optionitem2_label,
										'optionitem_label_3'			=> $cart_item->optionitem3_label,
										'optionitem_label_4'			=> $cart_item->optionitem4_label,
										'optionitem_label_5'			=> $cart_item->optionitem5_label,
										
										'optionitem_price_1'			=> $cart_item->optionitem1_price,
										'optionitem_price_2'			=> $cart_item->optionitem2_price,
										'optionitem_price_3'			=> $cart_item->optionitem3_price,
										'optionitem_price_4'			=> $cart_item->optionitem4_price,
										'optionitem_price_5'			=> $cart_item->optionitem5_price,
										
										'giftcard_id'					=> $giftcard_id,
										'gift_card_message'				=> $cart_item->gift_card_message,
										
										'gift_card_from_name'			=> $cart_item->gift_card_from_name,
										'gift_card_to_name'				=> $cart_item->gift_card_to_name,
										'is_download'					=> $cart_item->is_download,
										'is_giftcard'					=> $cart_item->is_giftcard,
										
										'is_taxable'					=> $cart_item->is_taxable,
										'download_file_name'			=> $cart_item->download_file_name,
										'download_key'					=> $download_key,
										'maximum_downloads_allowed'		=> $cart_item->maximum_downloads_allowed,
										'download_timelimit_seconds'	=> $cart_item->download_timelimit_seconds ),
										
								array( 	'%d', '%d', '%s', '%s', '%s', 
										'%s', '%d', '%s', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s', '%s', '%s', '%s', 
										'%s', '%s', '%d', '%d', 
										'%d', '%s', '%s', '%d', '%d' ) );
	}
	
	public function insert_response( $order_id, $is_error, $processor, $response_text ){
		$this->mysqli->insert( 	'ec_response',
								array( 	'order_id' => $order_id,
										'is_error' => $is_error,
										'processor' => $processor,
										'response_text' => $response_text
									 ),
								array( '%d', '%d', '%s', '%s' ) );
	}
	
	public function insert_new_giftcard( $amount, $message ){
		$chars = array( "A", "B", "C", "D", "E", "F" );
		$giftcard_id = $chars[rand( 0, 5 )] . $chars[rand( 0, 5 )] . $chars[rand( 0, 5 )] . $chars[rand( 0, 5 )] . $chars[rand( 0, 5 )] . $chars[rand( 0, 5 )] . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 );
		
		$this->mysqli->insert( 'ec_giftcard', array( 'giftcard_id' => $giftcard_id, 'amount' => $amount, 'message' => $message ), array( '%s', '%s', '%s' ) );
		return $giftcard_id;
	}
	
	public function insert_new_download( $order_id, $download_file_name, $product_id ){
		$download_id = uniqid( md5( rand( ) ) );
		
		$this->mysqli->insert( 	'ec_download', 
								array( 	'download_id'			=> $download_id, 
										'order_id' 				=> $order_id, 
										'download_file_name' 	=> $download_file_name,
										'product_id'			=> $product_id 
									), 
								array( 	'%s', '%d', '%s', '%d' ) );
		return $download_id;
	}
	
	public function get_download( $download_id ){
		return $this->mysqli->get_row( $this->mysqli->prepare( "SELECT download_id, date_created, download_count, order_id, product_id, download_file_name FROM ec_download WHERE download_id = '%s'", $download_id ) );	
	}
	
	public function update_quantity_value( $quantity, $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4, $optionitem_id_5 ){
		$this->mysqli->update(  'ec_optionitemquantity',
								array(  'quantity' => $quantity ),
								array(  'product_id' => $product_id, 
										'optionitem_id_1' => $optionitem_id_1, 
										'optionitem_id_2' => $optionitem_id_2, 
										'optionitem_id_3' => $optionitem_id_3, 
										'optionitem_id_4' => $optionitem_id_4, 
										'optionitem_id_5' => $optionitem_id_5
									  ),
								array(  '%d', '%d', '%d', '%d', '%d', '%d', '%d' )
							);
	}
	
	public function update_download_count( $download_id, $download_count ){
		$this->mysqli->update(	'ec_download',
								array(	'download_count'	=> $download_count ),
								array(	'download_id'		=> $download_id ),
								array(	'%d', '$s' )
							);
	}
	
	public function update_product_stock( $product_id, $quantity ){
		
		$stock_quantity = $this->mysqli->get_var( $this->mysqli->prepare( "SELECT stock_quantity FROM ec_product WHERE product_id = %d", $product_id ) );
		
		$this->mysqli->update( 	'ec_product',
								array( 'stock_quantity' => $stock_quantity - $quantity ),
								array( 'product_id' => $product_id ),
								array( '%d', '%d' )
							  );
	}
	
	public function clear_tempcart( $session_id ){
		$sql = "DELETE FROM ec_tempcart WHERE session_id = '%s'";
		$this->mysqli->query( $this->mysqli->prepare( $sql, $session_id ) );
	}
	
	public function get_order_list( $user_id, $email, $password ){
		$sql = "SELECT 
				ec_order.order_id, 
				ec_order.order_date, 
				ec_orderstatus.order_status, 
				ec_order.order_weight, 
				ec_orderstatus.is_approved,
				
				ec_order.sub_total,
				ec_order.shipping_total,
				ec_order.tax_total, 
				ec_order.duty_total, 
				ec_order.vat_total, 
				ec_order.discount_total,
				ec_order.grand_total,  
				
				ec_order.promo_code, 
				ec_order.giftcard_id, 
				
				ec_order.use_expedited_shipping, 
				ec_order.shipping_method, 
				ec_order.shipping_carrier, 
				ec_order.tracking_number, 
				
				ec_order.user_email, 
				ec_order.user_level, 
				
				ec_order.billing_first_name, 
				ec_order.billing_last_name, 
				ec_order.billing_address_line_1, 
				ec_order.billing_address_line_2, 
				ec_order.billing_city, 
				ec_order.billing_state, 
				ec_order.billing_zip, 
				ec_order.billing_country, 
				ec_order.billing_phone, 
				
				ec_order.shipping_first_name, 
				ec_order.shipping_last_name, 
				ec_order.shipping_address_line_1, 
				ec_order.shipping_address_line_2, 
				ec_order.shipping_city, 
				ec_order.shipping_state, 
				ec_order.shipping_zip, 
				ec_order.shipping_country, 
				ec_order.shipping_phone, 
				
				ec_order.payment_method, 
				
				ec_order.paypal_email_id, 
				ec_order.paypal_payer_id,
				
				ec_order.order_customer_notes
				
				FROM 
				ec_order
				LEFT JOIN ec_orderstatus ON
				ec_order.orderstatus_id = ec_orderstatus.status_id, 
				ec_user
				
				WHERE 
				ec_order.user_id = %d AND 
				ec_user.user_id = ec_order.user_id AND 
				ec_user.email = '%s' AND 
				ec_user.password = '%s'
				
				ORDER BY 
				ec_order.order_date DESC";
				
		return $this->mysqli->get_results( $this->mysqli->prepare( $sql, $user_id, $email, $password ) );
	}
	
	public function get_order_row( $order_id, $email, $password ){
		if( $password == "guest" ){
			$sql = "SELECT 
				ec_order.order_id, 
				ec_order.order_date, 
				ec_orderstatus.order_status, 
				ec_order.order_weight, 
				ec_orderstatus.is_approved,
				
				ec_order.sub_total,
				ec_order.shipping_total,
				ec_order.tax_total,
				ec_order.vat_total,
				ec_order.duty_total,
				ec_order.discount_total,
				ec_order.grand_total, 
				
				ec_order.promo_code, 
				ec_order.giftcard_id, 
				
				ec_order.use_expedited_shipping, 
				ec_order.shipping_method, 
				ec_order.shipping_carrier, 
				ec_order.tracking_number, 
				
				ec_order.user_email, 
				ec_order.user_level, 
				
				ec_order.billing_first_name, 
				ec_order.billing_last_name, 
				ec_order.billing_address_line_1, 
				ec_order.billing_address_line_2, 
				ec_order.billing_city, 
				ec_order.billing_state, 
				ec_order.billing_zip, 
				ec_order.billing_country, 
				ec_order.billing_phone, 
				
				ec_order.shipping_first_name, 
				ec_order.shipping_last_name, 
				ec_order.shipping_address_line_1, 
				ec_order.shipping_address_line_2, 
				ec_order.shipping_city, 
				ec_order.shipping_state, 
				ec_order.shipping_zip, 
				ec_order.shipping_country, 
				ec_order.shipping_phone, 
				
				ec_order.payment_method, 
				
				ec_order.paypal_email_id, 
				ec_order.paypal_payer_id,
				
				ec_order.order_customer_notes,
				
				GROUP_CONCAT(DISTINCT CONCAT_WS('***', ec_customfield.field_name, ec_customfield.field_label, ec_customfielddata.data) ORDER BY ec_customfield.field_name ASC SEPARATOR '---') as customfield_data
				
				FROM 
				ec_order
				
				LEFT JOIN ec_orderstatus ON
				ec_order.orderstatus_id = ec_orderstatus.status_id
				
				LEFT JOIN ec_customfield
				ON ec_customfield.table_name = 'ec_order'
				
				LEFT JOIN ec_customfielddata
				ON ec_customfielddata.customfield_id = ec_customfield.customfield_id AND ec_customfielddata.table_id = ec_order.order_id
				
				WHERE ec_order.order_id = %d
				
				GROUP BY
				ec_order.order_id";
				
				return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $order_id ) );
				
		}else{
			
			$sql = "SELECT 
				ec_order.order_id, 
				ec_order.order_date, 
				ec_orderstatus.order_status, 
				ec_order.order_weight, 
				ec_orderstatus.is_approved,
				
				ec_order.sub_total,
				ec_order.shipping_total,
				ec_order.tax_total,
				ec_order.vat_total,
				ec_order.duty_total,
				ec_order.discount_total,
				ec_order.grand_total, 
				
				ec_order.promo_code, 
				ec_order.giftcard_id, 
				
				ec_order.use_expedited_shipping, 
				ec_order.shipping_method, 
				ec_order.shipping_carrier, 
				ec_order.tracking_number, 
				
				ec_order.user_email, 
				ec_order.user_level, 
				
				ec_order.billing_first_name, 
				ec_order.billing_last_name, 
				ec_order.billing_address_line_1, 
				ec_order.billing_address_line_2, 
				ec_order.billing_city, 
				ec_order.billing_state, 
				ec_order.billing_zip, 
				ec_order.billing_country, 
				ec_order.billing_phone, 
				
				ec_order.shipping_first_name, 
				ec_order.shipping_last_name, 
				ec_order.shipping_address_line_1, 
				ec_order.shipping_address_line_2, 
				ec_order.shipping_city, 
				ec_order.shipping_state, 
				ec_order.shipping_zip, 
				ec_order.shipping_country, 
				ec_order.shipping_phone, 
				
				ec_order.payment_method, 
				
				ec_order.paypal_email_id, 
				ec_order.paypal_payer_id,
				
				ec_order.order_customer_notes,
				
				GROUP_CONCAT(DISTINCT CONCAT_WS('***', ec_customfield.field_name, ec_customfield.field_label, ec_customfielddata.data) ORDER BY ec_customfield.field_name ASC SEPARATOR '---') as customfield_data 
				
				FROM 
				ec_order
				
				LEFT JOIN ec_orderstatus ON
				ec_order.orderstatus_id = ec_orderstatus.status_id
				
				LEFT JOIN ec_customfield
				ON ec_customfield.table_name = 'ec_order'
				
				LEFT JOIN ec_customfielddata
				ON ec_customfielddata.customfield_id = ec_customfield.customfield_id AND ec_customfielddata.table_id = ec_order.order_id, 
				
				ec_user
				
				WHERE ec_user.email = '%s' AND ec_user.password = '%s' AND ec_user.user_id = ec_order.user_id AND ec_order.order_id = %d
				
				GROUP BY ec_order.order_id";
				
				return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $email, $password, $order_id ) );
				
		}
	
	}
	
	public function get_order_details( $order_id, $email, $password ){
		if( $password == "guest" ){
			return $this->mysqli->get_results( $this->mysqli->prepare( $this->orderdetail_guest_sql, $order_id ) );	
		}else{
			return $this->mysqli->get_results( $this->mysqli->prepare( $this->orderdetail_sql, $email, $password, $order_id ) );
		}
	}
	
	public function get_orderdetail_row( $order_id, $orderdetail_id, $email, $password ){
		$row_sql = $this->orderdetail_sql . " AND ec_orderdetail.orderdetail_id = '%s'";
		return $this->mysqli->get_row( $this->mysqli->prepare( $row_sql, $_SESSION['ec_email'], $_SESSION['ec_password'], $order_id, $orderdetail_id ) );
	}
	
	public function get_user( $email, $password ){
		$sql = "SELECT 
				ec_user.user_id,
				ec_user.first_name, 
				ec_user.last_name,
				ec_user.user_level, 
				ec_user.default_billing_address_id,
				ec_user.default_shipping_address_id,
				ec_user.is_subscriber,
				
				billing.first_name as billing_first_name, 
				billing.last_name as billing_last_name, 
				billing.address_line_1 as billing_address_line_1, 
				billing.address_line_2 as billing_address_line_2, 
				billing.city as billing_city, 
				billing.state as billing_state, 
				billing.zip as billing_zip, 
				billing.country as billing_country, 
				billing.phone as billing_phone, 
				
				shipping.first_name as shipping_first_name, 
				shipping.last_name as shipping_last_name, 
				shipping.address_line_1 as shipping_address_line_1, 
				shipping.address_line_2 as shipping_address_line_2, 
				shipping.city as shipping_city, 
				shipping.state as shipping_state, 
				shipping.zip as shipping_zip, 
				shipping.country as shipping_country, 
				shipping.phone as shipping_phone,
				
				GROUP_CONCAT(DISTINCT CONCAT_WS('***', ec_customfield.field_name, ec_customfield.field_label, ec_customfielddata.data) ORDER BY ec_customfield.field_name ASC SEPARATOR '---') as customfield_data
				
				FROM 
				ec_user 
				
				LEFT JOIN ec_address as billing 
				ON ec_user.default_billing_address_id = billing.address_id 
				
				LEFT JOIN ec_address as shipping 
				ON ec_user.default_shipping_address_id = shipping.address_id 
				
				LEFT JOIN ec_customfield
				ON ec_customfield.table_name = 'ec_user'
				
				LEFT JOIN ec_customfielddata
				ON ec_customfielddata.customfield_id = ec_customfield.customfield_id AND ec_customfielddata.table_id = ec_user.user_id
				
				WHERE 
				ec_user.email = '%s' AND 
				ec_user.password = '%s'
				
				GROUP BY
				ec_user.user_id";
		
		return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $email, $password ) );
		
	}
	
	public function reset_password( $email, $new_password ){
		return $this->mysqli->update( 	'ec_user',
								array( 'password'	=> $new_password ),
								array( 'email'		=> $email ),
								array( '%s', '%s' ) );	
	}
	
	public function update_personal_information( $old_email, $password, $first_name, $last_name, $email, $is_subscriber ){
		if( $is_subscriber )
			$this->insert_subscriber( $email, $first_name, $last_name );
		else
			$this->remove_subscriber( $email );
		
		return $this->mysqli->update(	'ec_user',
										array(	'first_name'	=> $first_name,
												'last_name'		=> $last_name,
												'email'			=> $email,
												'is_subscriber'	=> $is_subscriber ),
										array(	'email'			=> $old_email,
												'password'		=> $password ),
										array(	'%s', '%s', '%s', '%d', '%s', '%s' ) );
	}
	
	public function update_password( $session_email, $current_password, $new_password ){
		return $this->mysqli->update(	'ec_user',
										array(	'password'		=> $new_password ),
										array(	'email'			=> $session_email,
												'password'		=> $current_password ),
										array(	'%s', '%s', '%s' ) );
	}
	
	public function update_user_address( $address_id, $first_name, $last_name, $address, $city, $state, $zip, $country, $phone ){
		return $this->mysqli->update(	'ec_address', 
										array(	'first_name'						=> $first_name,
												'last_name'							=> $last_name,
												'address_line_1'					=> $address,
												'city'								=> $city,
												'state'								=> $state,
												'zip'								=> $zip,
												'country'							=> $country,
												'phone'								=> $phone 
											 ),
										array( 	'address_id' 						=> $address_id ), 
										array( 	'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d' )
								  );
	}
	
	public function insert_user_address( $first_name, $last_name, $address, $city, $state, $zip, $country, $phone, $email, $password, $address_type ){
		$user_id = $this->mysqli->get_var(	$this->mysqli->prepare( "SELECT user_id FROM ec_user WHERE email = '%s' AND password = '%s'", $email, $password ) );
		
		$this->mysqli->insert(	'ec_address',
												array(	'user_id'							=> $user_id,
														'first_name'						=> $first_name,
														'last_name'							=> $last_name,
														'address_line_1'					=> $address,
														'city'								=> $city,
														'state'								=> $state,
														'zip'								=> $zip,
														'country'							=> $country,
														'phone'								=> $phone
												),
												array( 	'%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
											);
											
		$address_id = $this->mysqli->insert_id;
		
		if( $address_type == "billing" ){
			return $this->mysqli->update(	"ec_user",
											array( 	"default_billing_address_id"	=> $address_id ),
											array( 	"email"							=> $email,
													"password"						=> $password
											),
											array( "%d", "%s", "%s" )
										);
			
		}else if( $address_type == "shipping"){
			return $this->mysqli->update(	"ec_user",
											array( 	"default_shipping_address_id"	=> $address_id ),
											array( 	"email"							=> $email,
													"password"						=> $password
											),
											array( "%d", "%s", "%s" )
										);
										
		}
		
	}
	
	public function update_product_views( $model_number ){
		$this->mysqli->query( $this->mysqli->prepare( "UPDATE ec_product SET ec_product.views=ec_product.views+1 WHERE ec_product.model_number = '%s'", $model_number ) );
	}
	
	public function update_menu_views( $menuid ){
		$this->mysqli->query( $this->mysqli->prepare( "UPDATE ec_menulevel1 SET ec_menulevel1.clicks=ec_menulevel1.clicks+1 WHERE ec_menulevel1.menulevel1_id = '%s'", $menuid ) );
	}
	
	public function update_submenu_views( $submenuid ){
		$this->mysqli->query( $this->mysqli->prepare( "UPDATE ec_menulevel2 SET ec_menulevel2.clicks=ec_menulevel2.clicks+1 WHERE ec_menulevel2.menulevel2_id = '%s'", $submenuid ) );
	}
	
	public function update_subsubmenu_views( $subsubmenuid ){
		$this->mysqli->query( $this->mysqli->prepare( "UPDATE ec_menulevel3 SET ec_menulevel3.clicks=ec_menulevel3.clicks+1 WHERE ec_menulevel3.menulevel3_id = '%s'", $subsubmenuid ) );
	}
	
	public function get_countries( ){
		$sql = "SELECT name_cnt, iso2_cnt FROM ec_country ORDER BY sort_order ASC";
		return $this->mysqli->get_results( $sql );
	}
	
	public function get_states( ){
		$sql = "SELECT name_sta, code_sta FROM ec_state ORDER BY sort_order ASC";
		return $this->mysqli->get_results( $sql );
	}
	
	public function get_settings( ){
		$sql = "SELECT shipping_method, shipping_expedite_rate, shipping_handling_rate, ups_access_license_number, ups_user_id, ups_password, ups_ship_from_zip, ups_shipper_number, ups_country_code, ups_weight_type, usps_user_name, usps_ship_from_zip, fedex_key, fedex_account_number, fedex_meter_number, fedex_password, fedex_ship_from_zip, fedex_weight_units, fedex_country_code FROM ec_setting WHERE setting_id = 1";
		return $this->mysqli->get_row( $sql );	
	}
	
	public function get_ios3_country_code( $iso2 ){
		$sql = "SELECT iso3_cnt FROM ec_country WHERE iso2_cnt = '%s'";
		return $this->mysqli->get_var( $this->mysqli->prepare( $sql, $iso2 ) );
	}
	
	public function get_manufacturer_row( $manufacturer_id ){
		$sql = "SELECT ec_manufacturer.name FROM ec_manufacturer WHERE ec_manufacturer.manufacturer_id = %d";
		return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $manufacturer_id ) );	
	}
	
	public function get_menu_row( $menu_id, $level ){
		if( $level == 1 ){
			$sql = "SELECT ec_menulevel1.menulevel1_id, ec_menulevel1.name, ec_menulevel1.order, ec_menulevel1.clicks, ec_menulevel1.seo_keywords, ec_menulevel1.seo_description, ec_menulevel1.banner_image FROM ec_menulevel1 WHERE ec_menulevel1.menulevel1_id = %d";
			return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $menu_id ) );
		}else if( $level == 2 ){
			$sql = "SELECT ec_menulevel2.menulevel2_id, ec_menulevel2.menulevel1_id, ec_menulevel2.name, ec_menulevel2.order, ec_menulevel2.clicks, ec_menulevel2.seo_keywords, ec_menulevel2.seo_description, ec_menulevel2.banner_image FROM ec_menulevel2 WHERE ec_menulevel2.menulevel2_id = %d";
			return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $menu_id ) );
		}else if( $level == 3 ){
			$sql = "SELECT ec_menulevel3.menulevel3_id, ec_menulevel3.menulevel2_id, ec_menulevel3.name, ec_menulevel3.order, ec_menulevel3.clicks, ec_menulevel3.seo_keywords, ec_menulevel3.seo_description, ec_menulevel3.banner_image FROM ec_menulevel3 WHERE ec_menulevel3.menulevel3_id = %d";
			return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $menu_id ) );
		}
	}
	
}

?>