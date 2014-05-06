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


class ec_admin_productimporter
	{		
	
		function ec_admin_productimporter() {
			/*load our connection settings
			if( file_exists( '../../../../wp-easycart-data/connection/ec_conn.php' ) ) {
				require_once('../../../../wp-easycart-data/connection/ec_conn.php');
			} else {
				require_once('../../../connection/ec_conn.php');
			};*/
		
			//set our connection variables
			$dbhost = DB_HOST;
			$dbname = DB_NAME;
			$dbuser = DB_USER;
			$dbpass = DB_PASSWORD;
			global $wpdb;
			define ('WP_PREFIX', $wpdb->prefix);
			
			require_once( "../../classes/core/ec_db.php" );
			require_once '../administration/excel_reader2.php';

		
			//make a connection to our database
			$this->conn = mysql_connect($dbhost, $dbuser, $dbpass);
			mysql_select_db ($dbname);	
			mysql_query("SET CHARACTER SET utf8", $this->conn); 
			mysql_query("SET NAMES 'utf8'", $this->conn); 

		}	
			
		//secure all of the services for logged in authenticated users only	
		public function _getMethodRoles($methodName){
		   if ($methodName == 'productimport') return array('admin');
		   else  return null;
		}
		
		//HELPER - used to escape out SQL calls
		function escape($sql) 
		{ 
			  $args = func_get_args(); 
				foreach($args as $key => $val) 
				{ 
					$args[$key] = mysql_real_escape_string($val); 
				} 
				 
				$args[0] = $sql; 
				return call_user_func_array('sprintf', $args); 
		} 
		
			
		public function productimport() {
			
			$excel = new Spreadsheet_Excel_Reader("../administration/productimportfile.xls", false);
			// read spreadsheet data
			$excel->read('../administration/productimportfile.xls'); 
			

			if(!mysql_error()) {
				// iterate over spreadsheet rows and columns
				// first check all the data
				$errorfound = false;
				for ($x=2; $x<=$excel->sheets[0]['numRows']; $x++) {
			
					//1 product_id
					
					//2 model_number
					if ($excel->sheets[0]['cells'][$x][2] == '') {
						$errorfound = true;
						return "Error at record ".$x.", all products require a unique model number." ;
					}
					//3 post_id
					
					//4 activate_in_store
						if (!is_numeric($excel->sheets[0]['cells'][$x][4]) || ($excel->sheets[0]['cells'][$x][4] != 0 && $excel->sheets[0]['cells'][$x][4] != 1)) {
							$errorfound = true;
							return "Error at record ".$x.", activate in store must be either 1 - active or 0 - not active" ;
						}
					//5 title
					if ($excel->sheets[0]['cells'][$x][5] == '') {
						$errorfound = true;
						return "Error at record ".$x.", all products require a title." ;
					}
					//6 description
					if ($excel->sheets[0]['cells'][$x][6] == '') {
						$errorfound = true;
						return "Error at record ".$x.", all products require a description." ;
					}
					//7 specifications
					
					//8 price
					if ($excel->sheets[0]['cells'][$x][8] == '' || !is_numeric($excel->sheets[0]['cells'][$x][8])) {
						$errorfound = true;
						return "Error at record ".$x.", all products require you enter a valid price for the item.  Do not enter currency signs or thousands seperators." ;
					}
					//9 list_price
					if (!is_numeric($excel->sheets[0]['cells'][$x][9])) {
						$errorfound = true;
						return "Error at record ".$x.", if you include a list price, it must be in numeric format.  Do not enter currency signs or thousands seperators." ;
					}
					//10 vat_rate
					
					//11 handling_price
					
					//12 stock_quantity
					if ($excel->sheets[0]['cells'][$x][12] == '' || !is_numeric($excel->sheets[0]['cells'][$x][12])) {
						$errorfound = true;
						return "Error at record ".$x.", all products require you enter a stock quantity for the product." ;
					}
					//13 weight
					
					//14 width
					
					//15 height
					
					//16 length
					
					//17 seo_description
					
					//18 seo_keywords
					
					//19 use_specifications
					if (!is_numeric($excel->sheets[0]['cells'][$x][19]) || ($excel->sheets[0]['cells'][$x][19] != 0 && $excel->sheets[0]['cells'][$x][19] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", use specifications must be either a 1 - selected or 0 - not selected." ;
					}
					//20 use_customer_reviews
					if (!is_numeric($excel->sheets[0]['cells'][$x][20]) || ($excel->sheets[0]['cells'][$x][20] != 0 && $excel->sheets[0]['cells'][$x][20] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", use customer reviews must be either a 1 - selected or 0 - not selected." ;
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
					if (!is_numeric($excel->sheets[0]['cells'][$x][33]) || ($excel->sheets[0]['cells'][$x][33] != 0 && $excel->sheets[0]['cells'][$x][33] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", use advanced optionsets must be either a 1 - selected or 0 - not selected." ;
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
					if (!is_numeric($excel->sheets[0]['cells'][$x][47]) || ($excel->sheets[0]['cells'][$x][47] != 0 && $excel->sheets[0]['cells'][$x][47] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is giftcard must be either a 1 - selected or 0 - not selected." ;
					}
					//48 is_download
					if (!is_numeric($excel->sheets[0]['cells'][$x][48]) || ($excel->sheets[0]['cells'][$x][48] != 0 && $excel->sheets[0]['cells'][$x][48] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is download must be either a 1 - selected or 0 - not selected." ;
					}
					//49 is_donation
					if (!is_numeric($excel->sheets[0]['cells'][$x][49]) || ($excel->sheets[0]['cells'][$x][49] != 0 && $excel->sheets[0]['cells'][$x][49] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is donation must be either a 1 - selected or 0 - not selected." ;
					}
					//50 is_special
					if (!is_numeric($excel->sheets[0]['cells'][$x][50]) || ($excel->sheets[0]['cells'][$x][50] != 0 && $excel->sheets[0]['cells'][$x][50] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is special must be either a 1 - selected or 0 - not selected." ;
					}
					//51 is_taxable
					if (!is_numeric($excel->sheets[0]['cells'][$x][51]) || ($excel->sheets[0]['cells'][$x][51] != 0 && $excel->sheets[0]['cells'][$x][51] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is taxable must be either a 1 - selected or 0 - not selected." ;
					}
					//52 is_subscription_item
					if (!is_numeric($excel->sheets[0]['cells'][$x][52]) || ($excel->sheets[0]['cells'][$x][52] != 0 && $excel->sheets[0]['cells'][$x][52] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is subscription item must be either a 1 - selected or 0 - not selected." ;
					}
					//53 is_preorder
					
					//54 added_to_db_date
					
					//55 show_on_startup
					if (!is_numeric($excel->sheets[0]['cells'][$x][55]) || ($excel->sheets[0]['cells'][$x][55] != 0 && $excel->sheets[0]['cells'][$x][55] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", show on store startup must be either a 1 - selected or 0 - not selected." ;
					}
					//56 use_optionitem_images
					if (!is_numeric($excel->sheets[0]['cells'][$x][56]) || ($excel->sheets[0]['cells'][$x][56] != 0 && $excel->sheets[0]['cells'][$x][56] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", use optionitem images must be either a 1 - selected or 0 - not selected." ;
					}
					//57 use_optionitem_quantity_tracking
					if (!is_numeric($excel->sheets[0]['cells'][$x][57]) || ($excel->sheets[0]['cells'][$x][57] != 0 && $excel->sheets[0]['cells'][$x][57] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", use optionitem quantity tracking must be either a 1 - selected or 0 - not selected." ;
					}
					//58 views
					
					//59 last_viewed
					
					//60 show_stock_quantity
					if (!is_numeric($excel->sheets[0]['cells'][$x][60]) || ($excel->sheets[0]['cells'][$x][60] != 0 && $excel->sheets[0]['cells'][$x][60] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", show stock quantity must be either a 1 - selected or 0 - not selected." ;
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


			
				}


				//if we made it through validation, then begin inserting or updating data
				if($errorfound == false) {
					
					
					
					
					  for ($x=2; $x<=$excel->sheets[0]['numRows']; $x++) {
						  
						  //Create SQL Query
						  $sql = $this->escape("SELECT ec_product.product_id FROM ec_product WHERE ec_product.product_id = '".$excel->sheets[0]['cells'][$x][1]."'");
						  // Run query on database
						  $result = mysql_query($sql);
						  //if results, then we found an existing product, do update
						  if(mysql_num_rows($result) > 0) {

							    //update product
							  	$sql = $this->escape("UPDATE ec_product SET 
								ec_product.product_id = '%s',
								ec_product.model_number = '%s',
								ec_product.post_id = '%s',
								ec_product.activate_in_store = '%s',
								ec_product.title = '%s',
								ec_product.description = '%s',
								ec_product.specifications = '%s',
								ec_product.price = '%s',
								ec_product.list_price = '%s',
								ec_product.vat_rate = '%s',
								ec_product.handling_price = '%s',
								ec_product.stock_quantity = '%s',
								ec_product.weight = '%s',
								ec_product.width = '%s',
								ec_product.height = '%s',
								ec_product.length = '%s',
								ec_product.seo_description = '%s',
								ec_product.seo_keywords = '%s',
								ec_product.use_specifications = '%s',
								ec_product.use_customer_reviews = '%s',
								ec_product.manufacturer_id = '%s',
								ec_product.download_file_name = '%s',
								ec_product.image1 = '%s',
								ec_product.image2 = '%s',
								ec_product.image3 = '%s',
								ec_product.image4 = '%s',
								ec_product.image5 = '%s',
								ec_product.option_id_1 = '%s',
								ec_product.option_id_2 = '%s',
								ec_product.option_id_3 = '%s',
								ec_product.option_id_4 = '%s',
								ec_product.option_id_5 = '%s',
								ec_product.use_advanced_optionset = '%s',
								ec_product.menulevel1_id_1 = '%s',
								ec_product.menulevel1_id_2 = '%s',
								ec_product.menulevel1_id_3 = '%s',
								ec_product.menulevel2_id_1 = '%s',
								ec_product.menulevel2_id_2 = '%s',
								ec_product.menulevel2_id_3 = '%s',
								ec_product.menulevel3_id_1 = '%s',
								ec_product.menulevel3_id_2 = '%s',
								ec_product.menulevel3_id_3 = '%s',
								ec_product.featured_product_id_1 = '%s',
								ec_product.featured_product_id_2 = '%s',
								ec_product.featured_product_id_3 = '%s',
								ec_product.featured_product_id_4 = '%s',
								ec_product.is_giftcard = '%s',
								ec_product.is_download = '%s',
								ec_product.is_donation = '%s',
								ec_product.is_special = '%s',
								ec_product.is_taxable = '%s',
								ec_product.is_subscription_item = '%s',
								ec_product.is_preorder = '%s',
								ec_product.added_to_db_date = '%s',
								ec_product.show_on_startup = '%s',
								ec_product.use_optionitem_images = '%s',
								ec_product.use_optionitem_quantity_tracking = '%s',
								ec_product.views = '%s',
								ec_product.last_viewed = '%s',
								ec_product.show_stock_quantity = '%s',
								ec_product.maximum_downloads_allowed = '%s',
								ec_product.download_timelimit_seconds = '%s',
								ec_product.list_id = '%s',
								ec_product.edit_sequence = '%s',
								ec_product.subscription_bill_length = '%s',
								ec_product.subscription_bill_period = '%s',
								ec_product.trial_period_days = '%s',
								ec_product.stripe_plan_added = '%s',
								ec_product.subscription_plan_id = '%s',
								ec_product.allow_multiple_subscription_purchases = '%s',
								ec_product.membership_page = '%s'
								
								WHERE product_id = '".$excel->sheets[0]['cells'][$x][1]."'",
								
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][1]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][2]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][3]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][4]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][5]),
								$excel->sheets[0]['cells'][$x][6],
								$excel->sheets[0]['cells'][$x][7],
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][8]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][9]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][10]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][11]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][12]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][13]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][14]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][15]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][16]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][17]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][18]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][19]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][20]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][21]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][22]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][23]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][24]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][25]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][26]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][27]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][28]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][29]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][30]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][31]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][32]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][33]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][34]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][35]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][36]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][37]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][38]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][39]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][40]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][41]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][42]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][43]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][44]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][45]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][46]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][47]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][48]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][49]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][50]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][51]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][52]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][53]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][54]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][55]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][56]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][57]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][58]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][59]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][60]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][61]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][62]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][63]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][64]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][65]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][66]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][67]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][68]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][69]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][70]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][71]));
								
								if (!mysql_query($sql)) {
									//error out
									break;
								} else {
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
									if (get_option( 'ec_option_payment_process_method' ) == 'stripe' && $excel->sheets[0]['cells'][$x][52] == '1') {
										//create an object for call to stripe
										$stripe_plan = (object)array(
										  "product_id" 					=> $excel->sheets[0]['cells'][$x][1],
										  "title"						=> $excel->sheets[0]['cells'][$x][5]);
										
										$stripe = new ec_stripe;
										$response = $stripe->update_plan($stripe_plan);
										if ($response == false) {
											//try to insert it then
											//create an object for call to stripe
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
							  
						  } else {
							    //insert product
								
								// Insert a WordPress Custom post type post.
								$sql_product = sprintf("SELECT ec_product.product_id, ec_product.title, ec_product.model_number FROM ec_product WHERE ec_product.model_number = '%s'", $excel->sheets[0]['cells'][$x][1] );
								$result_get_product = mysql_query( $sql_product );
								$product = mysql_fetch_assoc( $result_get_product );
								$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product['model_number'] . "\"]",
												'post_status'	=> "publish",
												'post_title'	=> $product['title'],
												'post_type'		=> "ec_store"
											  );
								$post_id = wp_insert_post( $post, $wp_error );
								$db = new ec_db( );
								$db->update_product_post_id( $product['product_id'], $post_id );
									
									
								$sql = $this->escape("INSERT into ec_product(
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
								ec_product.membership_page
								)
												values('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s', '%s')",
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][1]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][2]),
								mysql_real_escape_string($post_id),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][4]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][5]),
								$excel->sheets[0]['cells'][$x][6],
								$excel->sheets[0]['cells'][$x][7],
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][8]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][9]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][10]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][11]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][12]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][13]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][14]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][15]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][16]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][17]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][18]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][19]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][20]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][21]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][22]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][23]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][24]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][25]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][26]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][27]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][28]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][29]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][30]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][31]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][32]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][33]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][34]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][35]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][36]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][37]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][38]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][39]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][40]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][41]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][42]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][43]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][44]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][45]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][46]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][47]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][48]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][49]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][50]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][51]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][52]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][53]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][54]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][55]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][56]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][57]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][58]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][59]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][60]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][61]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][62]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][63]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][64]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][65]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][66]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][67]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][68]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][69]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][70]),
								mysql_real_escape_string($excel->sheets[0]['cells'][$x][71]));
								
								if (!mysql_query($sql)) {
									//error out
									break;
								} else {
									//Enqueue Quickbooks Add Product
									if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
										$quickbooks = new ec_quickbooks( );
										$quickbooks->add_product( $excel->sheets[0]['cells'][$x][1] ); //model_number	
									}
									
									
									
									//if using stripe and is subscription, insert plan
									if (get_option( 'ec_option_payment_process_method' ) == 'stripe' && $excel->sheets[0]['cells'][$x][52] == '1') {
										//create an object for call to stripe
										$stripe_plan = (object)array(
										  "price" 						=> $excel->sheets[0]['cells'][$x][8],
										  "product_id" 					=> $product['product_id'],
										  "title"						=> $excel->sheets[0]['cells'][$x][5],
										  "subscription_bill_period" 	=> $excel->sheets[0]['cells'][$x][66],
										  "subscription_bill_length" 	=> $excel->sheets[0]['cells'][$x][65],
										  "trial_period_days" 			=> $excel->sheets[0]['cells'][$x][67]);
										
										$stripe = new ec_stripe;
										$response = $stripe->insert_plan($stripe_plan);
									}
								}
							
						  }
							
							
		
					  }
					  if(!mysql_error()) {
						  $returnArray[] ="success";
				 		  return($returnArray); //return array results if there are some
					  } else {
						  return 'Error at record '.$x.', Please Check Excel File: ' . mysql_error();
					  }
				}
			}


		}



	}//close class
?>