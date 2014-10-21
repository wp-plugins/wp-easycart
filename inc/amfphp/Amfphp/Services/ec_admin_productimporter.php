<?php
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/


class ec_admin_productimporter{
	
	private $db;
	
	function ec_admin_productimporter( ){
		
		global $wpdb;
		$this->db = $wpdb;
		
		require_once( "../../classes/core/ec_db.php" );
		require_once( "../administration/excel_reader2.php" );

	}	
		
	public function _getMethodRoles($methodName){
	   if ($methodName == 'productimport') return array('admin');
	   else  return null;
	}
	
	public function productimport( ){
		
		$excel = new Spreadsheet_Excel_Reader( "../administration/productimportfile.xls", false );
		$excel->read('../administration/productimportfile.xls'); 
		
		// iterate over spreadsheet rows and columns and check all the data
		for( $x=2; $x <= $excel->sheets[0]['numRows']; $x++ ){
	
			//1 product_id
			if( $excel->sheets[0]['cells'][$x][1] == '' || !is_numeric( $excel->sheets[0]['cells'][$x][1] ) ){
				return "Error at record " . $x . ", product ID must be numeric and less than 11 characters in length.  It must be unique for each product.";
			}
			//2 model_number
			if( $excel->sheets[0]['cells'][$x][2] == '' ){
				return "Error at record " . $x . ", all products require a unique model number.";
			}
			
			//3 post_id
			
			//4 activate_in_store
			if( !is_numeric( $excel->sheets[0]['cells'][$x][4] ) || ( $excel->sheets[0]['cells'][$x][4] != 0 && $excel->sheets[0]['cells'][$x][4] != 1 ) ){
				return "Error at record " . $x . ", activate in store must be either 1 - active or 0 - not active";
			}
			
			//5 title
			if( $excel->sheets[0]['cells'][$x][5] == '' ){
				return "Error at record " . $x . ", all products require a title.";
			}
			
			//6 description
			if( $excel->sheets[0]['cells'][$x][6] == '' ){
				return "Error at record " . $x . ", all products require a description.";
			}
			
			//7 specifications
			
			//8 price
			if( $excel->sheets[0]['cells'][$x][8] == '' || !is_numeric( $excel->sheets[0]['cells'][$x][8] ) ){
				return "Error at record " . $x . ", all products require you enter a valid price for the item.  Do not enter currency signs or thousands seperators.";
			}
			
			//9 list_price
			if( !is_numeric( $excel->sheets[0]['cells'][$x][9] ) ){
				return "Error at record " . $x . ", if you include a list price, it must be in numeric format.  Do not enter currency signs or thousands seperators." ;
			}
			
			//10 vat_rate
			
			//11 handling_price
			
			//12 stock_quantity
			if( !is_numeric( $excel->sheets[0]['cells'][$x][12] ) ){
				return "Error at record " . $x . ", all products require you enter a stock quantity for the product.";
			}
			
			//13 weight
			
			//14 width
			
			//15 height
			
			//16 length
			
			//17 seo_description
			
			//18 seo_keywords
			
			//19 use_specifications
			if( !is_numeric( $excel->sheets[0]['cells'][$x][19] ) || ( $excel->sheets[0]['cells'][$x][19] != 0 && $excel->sheets[0]['cells'][$x][19] != 1 ) ){
				return "Error at record " . $x . ", use specifications must be either a 1 - selected or 0 - not selected.";
			}
			
			//20 use_customer_reviews
			if( !is_numeric( $excel->sheets[0]['cells'][$x][20] ) || ( $excel->sheets[0]['cells'][$x][20] != 0 && $excel->sheets[0]['cells'][$x][20] != 1 ) ){
				return "Error at record " . $x . ", use customer reviews must be either a 1 - selected or 0 - not selected." ;
			}
			
			//21 manufacturer_id
			
			//22 download_file_name
			
			//23 image1
			
			//24 image2
			
			//25 image3
			
			//26 image4
			
			//27 image5
			
			//28 option_id_1
			
			//29 option_id_2
			
			//30 option_id_3
			
			//31 option_id_4
			
			//32 option_id_5
			
			//33 use_advanced_optionset
			if( !is_numeric( $excel->sheets[0]['cells'][$x][33] ) || ( $excel->sheets[0]['cells'][$x][33] != 0 && $excel->sheets[0]['cells'][$x][33] != 1 ) ){
				return "Error at record " . $x . ", use advanced optionsets must be either a 1 - selected or 0 - not selected.";
			}
			
			//34 menulevel1_id_1
			
			//35 menulevel1_id_2
			
			//36 menulevel1_id_3
			
			//37 menulevel2_id_1
			
			//38 menulevel2_id_2
			
			//39 menulevel2_id_3
			
			//40 menulevel3_id_1
			
			//41 menulevel3_id_2
			
			//42 menulevel3_id_3
			
			//43 featured_product_id_1
			
			//44 featured_product_id_2
			
			//45 featured_product_id_3
			
			//46 featured_product_id_4
			
			//47 is_giftcard
			if( !is_numeric( $excel->sheets[0]['cells'][$x][47] ) || ( $excel->sheets[0]['cells'][$x][47] != 0 && $excel->sheets[0]['cells'][$x][47] != 1 ) ){
				return "Error at record " . $x . ", is giftcard must be either a 1 - selected or 0 - not selected.";
			}
			
			//48 is_download
			if( !is_numeric( $excel->sheets[0]['cells'][$x][48] ) || ( $excel->sheets[0]['cells'][$x][48] != 0 && $excel->sheets[0]['cells'][$x][48] != 1 ) ){
				return "Error at record " . $x . ", is download must be either a 1 - selected or 0 - not selected.";
			}
			
			//49 is_donation
			if( !is_numeric( $excel->sheets[0]['cells'][$x][49] ) || ( $excel->sheets[0]['cells'][$x][49] != 0 && $excel->sheets[0]['cells'][$x][49] != 1 ) ){
				return "Error at record " . $x . ", is donation must be either a 1 - selected or 0 - not selected.";
			}
			
			//50 is_special
			if( !is_numeric($excel->sheets[0]['cells'][$x][50] ) || ( $excel->sheets[0]['cells'][$x][50] != 0 && $excel->sheets[0]['cells'][$x][50] != 1 ) ){
				return "Error at record " . $x . ", is special must be either a 1 - selected or 0 - not selected.";
			}
			
			//51 is_taxable
			if( !is_numeric($excel->sheets[0]['cells'][$x][51] ) || ( $excel->sheets[0]['cells'][$x][51] != 0 && $excel->sheets[0]['cells'][$x][51] != 1 ) ){
				return "Error at record " . $x . ", is taxable must be either a 1 - selected or 0 - not selected.";
			}
			
			//52 is_subscription_item
			if( !is_numeric($excel->sheets[0]['cells'][$x][52] ) || ( $excel->sheets[0]['cells'][$x][52] != 0 && $excel->sheets[0]['cells'][$x][52] != 1 ) ){
				return "Error at record " . $x . ", is subscription item must be either a 1 - selected or 0 - not selected.";
			}
			
			//53 is_preorder
			
			//54 added_to_db_date
			
			//55 show_on_startup
			if( !is_numeric($excel->sheets[0]['cells'][$x][55] ) || ( $excel->sheets[0]['cells'][$x][55] != 0 && $excel->sheets[0]['cells'][$x][55] != 1 ) ){
				return "Error at record ".$x.", show on store startup must be either a 1 - selected or 0 - not selected.";
			}
			
			//56 use_optionitem_images
			if( !is_numeric( $excel->sheets[0]['cells'][$x][56] ) || ( $excel->sheets[0]['cells'][$x][56] != 0 && $excel->sheets[0]['cells'][$x][56] != 1 ) ){
				return "Error at record " . $x . ", use optionitem images must be either a 1 - selected or 0 - not selected.";
			}
			
			//57 use_optionitem_quantity_tracking
			if( !is_numeric( $excel->sheets[0]['cells'][$x][57] ) || ( $excel->sheets[0]['cells'][$x][57] != 0 && $excel->sheets[0]['cells'][$x][57] != 1 ) ){
				return "Error at record " . $x . ", use optionitem quantity tracking must be either a 1 - selected or 0 - not selected.";
			}
			
			//58 views
			
			//59 last_viewed
			
			//60 show_stock_quantity
			if( !is_numeric( $excel->sheets[0]['cells'][$x][60] ) || ( $excel->sheets[0]['cells'][$x][60] != 0 && $excel->sheets[0]['cells'][$x][60] != 1 ) ){
				return "Error at record " . $x . ", show stock quantity must be either a 1 - selected or 0 - not selected.";
			}
			
			//61 maximum_downloads_allowed
			
			//62 download_timelimit_seconds
			
			//63 QB list_id
			
			//64 QB edit_sequence
			
			//65 subscription_bill_length
			
			//66 subscription_bill_period
			
			//67 trial_period_days
			
			//68 stripe_plan_added
			
			//69 subscription_plan_id
			
			//70 allow_multiple_subscription_purchases
			
			//71 membership_page
			
			//72 min purchase quantity
			
			//73 is_amazon_download
			
			//74 amazon_key
			
			//75 catalog Mode
			
			//76 catalog Mode Phrase
			
			//77 inquiry mode
			
			//78 inquiry url
			
			//79 is deconetwork
			
			//80 deconetwork mode
			
			//81 deconetwork product id
			
			//82 deconetwork size id
			
			//83 deconetwork color id
			
			//84 deconetwork design id
			
			//85 short description
			
			//86 tag type
			
			//87 tag bg color
			
			//88 tag text
			
			//89 tag text color
			
			//90 display_type
			
			//91 image_hover_type
			
			//92 image_effect_type
	
		}

		//if we made it through validation, then begin inserting or updating data
		for( $x=2; $x <= $excel->sheets[0]['numRows']; $x++ ){
			
			$sql = "SELECT ec_product.product_id FROM ec_product WHERE ec_product.product_id = %d";
			$results = $this->db->get_results( $this->db->prepare( $sql, $excel->sheets[0]['cells'][$x][1] ) );
			
			if( count( $results ) > 0 ){ // If results, do update.
			
				$sql = "UPDATE ec_product SET 
							ec_product.product_id = %d,
							ec_product.model_number = %s,
							ec_product.post_id = %s,
							ec_product.activate_in_store = %s,
							ec_product.title = %s,
							ec_product.description = %s,
							ec_product.specifications = %s,
							ec_product.price = %s,
							ec_product.list_price = %s,
							ec_product.vat_rate = %s,
							ec_product.handling_price = %s,
							ec_product.stock_quantity = %s,
							ec_product.weight = %s,
							ec_product.width = %s,
							ec_product.height = %s,
							ec_product.length = %s,
							ec_product.seo_description = %s,
							ec_product.seo_keywords = %s,
							ec_product.use_specifications = %s,
							ec_product.use_customer_reviews = %s,
							ec_product.manufacturer_id = %d,
							ec_product.download_file_name = %s,
							ec_product.image1 = %s,
							ec_product.image2 = %s,
							ec_product.image3 = %s,
							ec_product.image4 = %s,
							ec_product.image5 = %s,
							ec_product.option_id_1 = %d,
							ec_product.option_id_2 = %d,
							ec_product.option_id_3 = %d,
							ec_product.option_id_4 = %d,
							ec_product.option_id_5 = %d,
							ec_product.use_advanced_optionset = %s,
							ec_product.menulevel1_id_1 = %d,
							ec_product.menulevel1_id_2 = %d,
							ec_product.menulevel1_id_3 = %d,
							ec_product.menulevel2_id_1 = %d,
							ec_product.menulevel2_id_2 = %d,
							ec_product.menulevel2_id_3 = %d,
							ec_product.menulevel3_id_1 = %d,
							ec_product.menulevel3_id_2 = %d,
							ec_product.menulevel3_id_3 = %d,
							ec_product.featured_product_id_1 = %d,
							ec_product.featured_product_id_2 = %d,
							ec_product.featured_product_id_3 = %d,
							ec_product.featured_product_id_4 = %d,
							ec_product.is_giftcard = %s,
							ec_product.is_download = %s,
							ec_product.is_donation = %s,
							ec_product.is_special = %s,
							ec_product.is_taxable = %s,
							ec_product.is_subscription_item = %s,
							ec_product.is_preorder = %s,
							ec_product.added_to_db_date = %s,
							ec_product.show_on_startup = %s,
							ec_product.use_optionitem_images = %s,
							ec_product.use_optionitem_quantity_tracking = %s,
							ec_product.views = %s,
							ec_product.last_viewed = %s,
							ec_product.show_stock_quantity = %s,
							ec_product.maximum_downloads_allowed = %s,
							ec_product.download_timelimit_seconds = %s,
							ec_product.list_id = %s,
							ec_product.edit_sequence = %s,
							ec_product.subscription_bill_length = %s,
							ec_product.subscription_bill_period = %s,
							ec_product.trial_period_days = %s,
							ec_product.stripe_plan_added = %s,
							ec_product.subscription_plan_id = %s,
							ec_product.allow_multiple_subscription_purchases = %s,
							ec_product.membership_page = %s,
							ec_product.min_purchase_quantity = %s,
							ec_product.is_amazon_download = %s,
							ec_product.amazon_key = %s,
							ec_product.catalog_mode = %s,
							ec_product.catalog_mode_phrase = %s,
							ec_product.inquiry_mode = %s,
							ec_product.inquiry_url = %s,
							ec_product.is_deconetwork = %s,
							ec_product.deconetwork_mode = %s,
							ec_product.deconetwork_product_id = %s,
							ec_product.deconetwork_size_id = %s,
							ec_product.deconetwork_color_id = %s,
							ec_product.deconetwork_design_id = %s,
							ec_product.short_description = %s,
							ec_product.display_type = %s,
							ec_product.image_hover_type = %s,
							ec_product.tag_type = %s,
							ec_product.tag_bg_color = %s,
							ec_product.tag_text_color = %s,
							ec_product.tag_text = %s,
							ec_product.image_effect_type = %s
							
							WHERE product_id = %d";
				
				
				$success = $this->db->query( $this->db->prepare( $sql, $excel->sheets[0]['cells'][$x][1], $excel->sheets[0]['cells'][$x][2], $excel->sheets[0]['cells'][$x][3], $excel->sheets[0]['cells'][$x][4], $excel->sheets[0]['cells'][$x][5], $excel->sheets[0]['cells'][$x][6], $excel->sheets[0]['cells'][$x][7], $excel->sheets[0]['cells'][$x][8], $excel->sheets[0]['cells'][$x][9], $excel->sheets[0]['cells'][$x][10], $excel->sheets[0]['cells'][$x][11], $excel->sheets[0]['cells'][$x][12], $excel->sheets[0]['cells'][$x][13], $excel->sheets[0]['cells'][$x][14], $excel->sheets[0]['cells'][$x][15], $excel->sheets[0]['cells'][$x][16], $excel->sheets[0]['cells'][$x][17], $excel->sheets[0]['cells'][$x][18], $excel->sheets[0]['cells'][$x][19], $excel->sheets[0]['cells'][$x][20], $excel->sheets[0]['cells'][$x][21], $excel->sheets[0]['cells'][$x][22], $excel->sheets[0]['cells'][$x][23], $excel->sheets[0]['cells'][$x][24], $excel->sheets[0]['cells'][$x][25], $excel->sheets[0]['cells'][$x][26], $excel->sheets[0]['cells'][$x][27], $excel->sheets[0]['cells'][$x][28], $excel->sheets[0]['cells'][$x][29], $excel->sheets[0]['cells'][$x][30], $excel->sheets[0]['cells'][$x][31], $excel->sheets[0]['cells'][$x][32], $excel->sheets[0]['cells'][$x][33], $excel->sheets[0]['cells'][$x][34], $excel->sheets[0]['cells'][$x][35], $excel->sheets[0]['cells'][$x][36], $excel->sheets[0]['cells'][$x][37], $excel->sheets[0]['cells'][$x][38], $excel->sheets[0]['cells'][$x][39], $excel->sheets[0]['cells'][$x][40], $excel->sheets[0]['cells'][$x][41], $excel->sheets[0]['cells'][$x][42], $excel->sheets[0]['cells'][$x][43], $excel->sheets[0]['cells'][$x][44], $excel->sheets[0]['cells'][$x][45], $excel->sheets[0]['cells'][$x][46], $excel->sheets[0]['cells'][$x][47], $excel->sheets[0]['cells'][$x][48], $excel->sheets[0]['cells'][$x][49], $excel->sheets[0]['cells'][$x][50], $excel->sheets[0]['cells'][$x][51], $excel->sheets[0]['cells'][$x][52], $excel->sheets[0]['cells'][$x][53], $excel->sheets[0]['cells'][$x][54], $excel->sheets[0]['cells'][$x][55], $excel->sheets[0]['cells'][$x][56], $excel->sheets[0]['cells'][$x][57], $excel->sheets[0]['cells'][$x][58], $excel->sheets[0]['cells'][$x][59], $excel->sheets[0]['cells'][$x][60], $excel->sheets[0]['cells'][$x][61], $excel->sheets[0]['cells'][$x][62], $excel->sheets[0]['cells'][$x][63], $excel->sheets[0]['cells'][$x][64], $excel->sheets[0]['cells'][$x][65], $excel->sheets[0]['cells'][$x][66], $excel->sheets[0]['cells'][$x][67], $excel->sheets[0]['cells'][$x][68], $excel->sheets[0]['cells'][$x][69], $excel->sheets[0]['cells'][$x][70], $excel->sheets[0]['cells'][$x][71], $excel->sheets[0]['cells'][$x][72], $excel->sheets[0]['cells'][$x][73],  $excel->sheets[0]['cells'][$x][74], $excel->sheets[0]['cells'][$x][75], $excel->sheets[0]['cells'][$x][76], $excel->sheets[0]['cells'][$x][77], $excel->sheets[0]['cells'][$x][78], $excel->sheets[0]['cells'][$x][79], $excel->sheets[0]['cells'][$x][80], $excel->sheets[0]['cells'][$x][81], $excel->sheets[0]['cells'][$x][82], $excel->sheets[0]['cells'][$x][83], $excel->sheets[0]['cells'][$x][84], $excel->sheets[0]['cells'][$x][85], $excel->sheets[0]['cells'][$x][86], $excel->sheets[0]['cells'][$x][87], $excel->sheets[0]['cells'][$x][88], $excel->sheets[0]['cells'][$x][89], $excel->sheets[0]['cells'][$x][90], $excel->sheets[0]['cells'][$x][91], $excel->sheets[0]['cells'][$x][92], $excel->sheets[0]['cells'][$x][1] ) );
				
				if( $success === FALSE ){
					break; //error out
				
				}else{
					
					//Enqueue Quickbooks Add Product
					if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
						$quickbooks = new ec_quickbooks( );
						$quickbooks->update_product( $excel->sheets[0]['cells'][$x][2] ); //model_number	
					}
					
					// Insert a WordPress Custom post type post.
					$post = array(	'ID'			=> $excel->sheets[0]['cells'][$x][3],
									'post_content'	=> "[ec_store modelnumber=\"" . $excel->sheets[0]['cells'][$x][2] . "\"]",
									'post_status'	=> "publish",
									'post_title'	=> $GLOBALS['language']->convert_text( $excel->sheets[0]['cells'][$x][5] ),
									'post_type'		=> "ec_store",
									'post_name'		=> str_replace(' ', '-', $GLOBALS['language']->convert_text( $excel->sheets[0]['cells'][$x][5] ) ),
								  );
					$post_id = wp_update_post( $post );
					
					//if using stripe and is subscription
					if( get_option( 'ec_option_payment_process_method' ) == 'stripe' && $excel->sheets[0]['cells'][$x][52] == '1' ){
						//create an object for call to stripe
						$stripe_plan = (object)array(
							"product_id" 					=> $excel->sheets[0]['cells'][$x][1],
							"title"						=> $excel->sheets[0]['cells'][$x][5]);
						
						$stripe = new ec_stripe;
						$response = $stripe->update_plan($stripe_plan);
						
						if( $response == false ){
							
							$stripe_plan = (object)array(
							  "price" 						=> $excel->sheets[0]['cells'][$x][8],
							  "product_id" 					=> $excel->sheets[0]['cells'][$x][1],
							  "title"						=> $excel->sheets[0]['cells'][$x][5],
							  "subscription_bill_period" 	=> $excel->sheets[0]['cells'][$x][66],
							  "subscription_bill_length" 	=> $excel->sheets[0]['cells'][$x][65],
							  "trial_period_days" 			=> $excel->sheets[0]['cells'][$x][67]);
							
							$stripe = new ec_stripe;
							$response = $stripe->insert_plan($stripe_plan);
						
						}
					
					}
				
				}
			  
			}else{ // If NO results, do insert.
				
				// Insert a WordPress Custom post type post.
				$sql_product = "SELECT ec_product.product_id, ec_product.title, ec_product.model_number FROM ec_product WHERE ec_product.model_number = %s";
				$product = $this->db->get_row( $this->db->prepare( $sql_product, $excel->sheets[0]['cells'][$x][1] ) );
				
				$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product->model_number . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $product->title,
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post, $wp_error );
				$db = new ec_db( );
				$db->update_product_post_id( $product->product_id, $post_id );
					
					
				$sql = "INSERT into ec_product(
					ec_product.product_id,
					ec_product.model_number,
					ec_product.post_id,
					ec_product.activate_in_store,
					ec_product.title,
					ec_product.description,
					ec_product.specifications,
					ec_product.price,
					ec_product.list_price,
					ec_product.vat_rate,
					ec_product.handling_price,
					ec_product.stock_quantity,
					ec_product.weight,
					ec_product.width,
					ec_product.height,
					ec_product.length,
					ec_product.seo_description,
					ec_product.seo_keywords,
					ec_product.use_specifications,
					ec_product.use_customer_reviews,
					ec_product.manufacturer_id,
					ec_product.download_file_name,
					ec_product.image1,
					ec_product.image2,
					ec_product.image3,
					ec_product.image4,
					ec_product.image5,
					ec_product.option_id_1,
					ec_product.option_id_2,
					ec_product.option_id_3,
					ec_product.option_id_4,
					ec_product.option_id_5,
					ec_product.use_advanced_optionset,
					ec_product.menulevel1_id_1,
					ec_product.menulevel1_id_2,
					ec_product.menulevel1_id_3,
					ec_product.menulevel2_id_1,
					ec_product.menulevel2_id_2,
					ec_product.menulevel2_id_3,
					ec_product.menulevel3_id_1,
					ec_product.menulevel3_id_2,
					ec_product.menulevel3_id_3,
					ec_product.featured_product_id_1,
					ec_product.featured_product_id_2,
					ec_product.featured_product_id_3,
					ec_product.featured_product_id_4,
					ec_product.is_giftcard,
					ec_product.is_download,
					ec_product.is_donation,
					ec_product.is_special,
					ec_product.is_taxable,
					ec_product.is_subscription_item,
					ec_product.is_preorder,
					ec_product.added_to_db_date,
					ec_product.show_on_startup,
					ec_product.use_optionitem_images,
					ec_product.use_optionitem_quantity_tracking,
					ec_product.views,
					ec_product.last_viewed,
					ec_product.show_stock_quantity,
					ec_product.maximum_downloads_allowed,
					ec_product.download_timelimit_seconds,
					ec_product.list_id,
					ec_product.edit_sequence,
					ec_product.subscription_bill_length,
					ec_product.subscription_bill_period,
					ec_product.trial_period_days,
					ec_product.stripe_plan_added,
					ec_product.subscription_plan_id,
					ec_product.allow_multiple_subscription_purchases,
					ec_product.membership_page,
					ec_product.min_purchase_quantity,
					ec_product.is_amazon_download,
					ec_product.amazon_key,
					ec_product.catalog_mode,
					ec_product.catalog_mode_phrase,
					ec_product.inquiry_mode,
					ec_product.inquiry_url,
					ec_product.is_deconetwork,
					ec_product.deconetwork_mode,
					ec_product.deconetwork_product_id,
					ec_product.deconetwork_size_id,
					ec_product.deconetwork_color_id,
					ec_product.deconetwork_design_id,
					ec_product.short_description,
					ec_product.display_type,
					ec_product.image_hover_type,
					ec_product.tag_type,
					ec_product.tag_bg_color,
					ec_product.tag_text_color,	
					ec_product.tag_text,
					ec_product.image_effect_type

				) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )";
								
				$success = $this->db->query( $this->db->prepare( $sql, $excel->sheets[0]['cells'][$x][1], $excel->sheets[0]['cells'][$x][2], $post_id, $excel->sheets[0]['cells'][$x][4], $excel->sheets[0]['cells'][$x][5], $excel->sheets[0]['cells'][$x][6], $excel->sheets[0]['cells'][$x][7], $excel->sheets[0]['cells'][$x][8], $excel->sheets[0]['cells'][$x][9], $excel->sheets[0]['cells'][$x][10], $excel->sheets[0]['cells'][$x][11], $excel->sheets[0]['cells'][$x][12], $excel->sheets[0]['cells'][$x][13], $excel->sheets[0]['cells'][$x][14], $excel->sheets[0]['cells'][$x][15], $excel->sheets[0]['cells'][$x][16], $excel->sheets[0]['cells'][$x][17], $excel->sheets[0]['cells'][$x][18], $excel->sheets[0]['cells'][$x][19], $excel->sheets[0]['cells'][$x][20], $excel->sheets[0]['cells'][$x][21], $excel->sheets[0]['cells'][$x][22], $excel->sheets[0]['cells'][$x][23], $excel->sheets[0]['cells'][$x][24], $excel->sheets[0]['cells'][$x][25], $excel->sheets[0]['cells'][$x][26], $excel->sheets[0]['cells'][$x][27], $excel->sheets[0]['cells'][$x][28], $excel->sheets[0]['cells'][$x][29], $excel->sheets[0]['cells'][$x][30], $excel->sheets[0]['cells'][$x][31], $excel->sheets[0]['cells'][$x][32], $excel->sheets[0]['cells'][$x][33], $excel->sheets[0]['cells'][$x][34], $excel->sheets[0]['cells'][$x][35], $excel->sheets[0]['cells'][$x][36], $excel->sheets[0]['cells'][$x][37], $excel->sheets[0]['cells'][$x][38], $excel->sheets[0]['cells'][$x][39], $excel->sheets[0]['cells'][$x][40], $excel->sheets[0]['cells'][$x][41], $excel->sheets[0]['cells'][$x][42], $excel->sheets[0]['cells'][$x][43], $excel->sheets[0]['cells'][$x][44], $excel->sheets[0]['cells'][$x][45], $excel->sheets[0]['cells'][$x][46], $excel->sheets[0]['cells'][$x][47], $excel->sheets[0]['cells'][$x][48], $excel->sheets[0]['cells'][$x][49], $excel->sheets[0]['cells'][$x][50], $excel->sheets[0]['cells'][$x][51], $excel->sheets[0]['cells'][$x][52], $excel->sheets[0]['cells'][$x][53], $excel->sheets[0]['cells'][$x][54], $excel->sheets[0]['cells'][$x][55], $excel->sheets[0]['cells'][$x][56], $excel->sheets[0]['cells'][$x][57], $excel->sheets[0]['cells'][$x][58], $excel->sheets[0]['cells'][$x][59], $excel->sheets[0]['cells'][$x][60], $excel->sheets[0]['cells'][$x][61], $excel->sheets[0]['cells'][$x][62], $excel->sheets[0]['cells'][$x][63], $excel->sheets[0]['cells'][$x][64], $excel->sheets[0]['cells'][$x][65], $excel->sheets[0]['cells'][$x][66], $excel->sheets[0]['cells'][$x][67], $excel->sheets[0]['cells'][$x][68], $excel->sheets[0]['cells'][$x][69], $excel->sheets[0]['cells'][$x][70], $excel->sheets[0]['cells'][$x][71], $excel->sheets[0]['cells'][$x][72], $excel->sheets[0]['cells'][$x][73],  $excel->sheets[0]['cells'][$x][74], $excel->sheets[0]['cells'][$x][75], $excel->sheets[0]['cells'][$x][76], $excel->sheets[0]['cells'][$x][77], $excel->sheets[0]['cells'][$x][78], $excel->sheets[0]['cells'][$x][79], $excel->sheets[0]['cells'][$x][80], $excel->sheets[0]['cells'][$x][81], $excel->sheets[0]['cells'][$x][82], $excel->sheets[0]['cells'][$x][83], $excel->sheets[0]['cells'][$x][84], $excel->sheets[0]['cells'][$x][85], $excel->sheets[0]['cells'][$x][86], $excel->sheets[0]['cells'][$x][87], $excel->sheets[0]['cells'][$x][88], $excel->sheets[0]['cells'][$x][89], $excel->sheets[0]['cells'][$x][90], $excel->sheets[0]['cells'][$x][91], $excel->sheets[0]['cells'][$x][92]));
				
				if( $success === FALSE ){
					break; //error out
				}else{
					//Enqueue Quickbooks Add Product
					if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
						$quickbooks = new ec_quickbooks( );
						$quickbooks->add_product( $excel->sheets[0]['cells'][$x][1] ); //model_number	
					}
					
					//if using stripe and is subscription, insert plan
					if (get_option( 'ec_option_payment_process_method' ) == 'stripe' && $excel->sheets[0]['cells'][$x][52] == '1' ){
						//create an object for call to stripe
						$stripe_plan = (object)array(
							  "price" 						=> $excel->sheets[0]['cells'][$x][8],
							  "product_id" 					=> $product['product_id'],
							  "title"						=> $excel->sheets[0]['cells'][$x][5],
							  "subscription_bill_period" 	=> $excel->sheets[0]['cells'][$x][66],
							  "subscription_bill_length" 	=> $excel->sheets[0]['cells'][$x][65],
							  "trial_period_days" 			=> $excel->sheets[0]['cells'][$x][67]);
						
						$stripe = new ec_stripe;
						$response = $stripe->insert_plan( $stripe_plan );
					}
				
				}
			
			} // Close update/insert if/else

		} // Close for loop
		
		if( $x > $excel->sheets[0]['numRows'] ){
			return array( "success" );
		}else{
			return 'Error at record '.$x.', Please Check Excel File for Missing Data or Duplicate Products';
		}
		
	} // Close Import Function
	
}
?>