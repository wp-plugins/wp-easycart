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
					//column A - model number
					if ($excel->sheets[0]['cells'][$x][1] == '') {
						$errorfound = true;
						return "Error at record ".$x.", all products must have a valid Model Number that is unique and contains no special characters or spaces." ;
					}
					//column B - title
					if ($excel->sheets[0]['cells'][$x][2] == '') {
						$errorfound = true;
						return "Error at record ".$x.", all products require a title." ;
					}
					//column C - description
					if ($excel->sheets[0]['cells'][$x][3] == '') {
						$errorfound = true;
						return "Error at record ".$x.", all products require a product description." ;
					}
					//column D - stock quantity
					if ($excel->sheets[0]['cells'][$x][4] == '' || !is_numeric($excel->sheets[0]['cells'][$x][4])) {
						$errorfound = true;
						return "Error at record ".$x.", all products require you enter a stock quantity for the product." ;
					}
					//column E - Weight
					if ($excel->sheets[0]['cells'][$x][5] == '' || !is_numeric($excel->sheets[0]['cells'][$x][5])) {
						$errorfound = true;
						return "Error at record ".$x.", all products require you enter a weight for the item." ;
					}
					//column F - Price
					if ($excel->sheets[0]['cells'][$x][6] == '' || !is_numeric($excel->sheets[0]['cells'][$x][6])) {
						$errorfound = true;
						return "Error at record ".$x.", all products require you enter a valid price for the item.  Do not enter currency signs or thousands seperators." ;
					}
					//column G - List Price
					if (!is_numeric($excel->sheets[0]['cells'][$x][7])) {
						$errorfound = true;
						return "Error at record ".$x.", if you include a list price, it must be in numeric format.  Do not enter currency signs or thousands seperators." ;
					}
					//column H - Vat Rate
					if (!is_numeric($excel->sheets[0]['cells'][$x][8])) {
						$errorfound = true;
						return "Error at record ".$x.", if you include a VAT rate, it must be in numeric format.  Do not enter currency signs or thousands seperators." ;
					}
					//column I - Handling Price
					if (!is_numeric($excel->sheets[0]['cells'][$x][9])) {
						$errorfound = true;
						return "Error at record ".$x.", if you include a handling price, it must be in numeric format.  Do not enter currency signs or thousands seperators." ;
					}
					//column J - Image 1
					//column K - Image 2
					//column L - Image 3
					//column M - Image 4
					//column N - Image 5
					//column O - SEO Description
					//column P - SEO Keywords
					//column Q - Speciifcations
					//column R - Use Specifications
					if (!is_numeric($excel->sheets[0]['cells'][$x][18]) || ($excel->sheets[0]['cells'][$x][18] != 0 && $excel->sheets[0]['cells'][$x][18] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", specifications must be either a 1 - selected or 0 - not selected." ;
					}
					//column S - Activate In Store
					if (!is_numeric($excel->sheets[0]['cells'][$x][19]) || ($excel->sheets[0]['cells'][$x][19] != 0 && $excel->sheets[0]['cells'][$x][19] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", activate in store must be either a 1 - selected or 0 - not selected." ;
					}
					//column T - Use Customer Reviews
					if (!is_numeric($excel->sheets[0]['cells'][$x][20]) || ($excel->sheets[0]['cells'][$x][20] != 0 && $excel->sheets[0]['cells'][$x][20] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", use customer reviews must be either a 1 - selected or 0 - not selected." ;
					}
					//column U - Is GiftCard
					if (!is_numeric($excel->sheets[0]['cells'][$x][21]) || ($excel->sheets[0]['cells'][$x][21] != 0 && $excel->sheets[0]['cells'][$x][21] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", specifications must be either a 1 - selected or 0 - not selected." ;
					}
					//column V - Is Download
					if (!is_numeric($excel->sheets[0]['cells'][$x][22]) || ($excel->sheets[0]['cells'][$x][22] != 0 && $excel->sheets[0]['cells'][$x][22] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is download must be either a 1 - selected or 0 - not selected." ;
					}
					//column W - Is Donation
					if (!is_numeric($excel->sheets[0]['cells'][$x][23]) || ($excel->sheets[0]['cells'][$x][23] != 0 && $excel->sheets[0]['cells'][$x][23] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is donation must be either a 1 - selected or 0 - not selected." ;
					}
					//column X - Is Special
					if (!is_numeric($excel->sheets[0]['cells'][$x][24]) || ($excel->sheets[0]['cells'][$x][24] != 0 && $excel->sheets[0]['cells'][$x][24] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is special product must be either a 1 - selected or 0 - not selected." ;
					}
					//column Y - Is Taxable
					if (!is_numeric($excel->sheets[0]['cells'][$x][25]) || ($excel->sheets[0]['cells'][$x][25] != 0 && $excel->sheets[0]['cells'][$x][25] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", is taxable must be either a 1 - selected or 0 - not selected." ;
					}
					//column Z - Show on Store Startup
					if (!is_numeric($excel->sheets[0]['cells'][$x][26]) || ($excel->sheets[0]['cells'][$x][26] != 0 && $excel->sheets[0]['cells'][$x][26] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", show on store startup must be either a 1 - selected or 0 - not selected." ;
					}
					//column AA - Show Stock Quantity
					if (!is_numeric($excel->sheets[0]['cells'][$x][27]) || ($excel->sheets[0]['cells'][$x][27] != 0 && $excel->sheets[0]['cells'][$x][27] != 1)) {
						$errorfound = true;
						return "Error at record ".$x.", show stock quantity must be either a 1 - selected or 0 - not selected." ;
					}
					
					
					
					
					
					

				}


				//if we made it through validation, then begin inserting data
				if($errorfound == false) {
					
					  for ($x=2; $x<=$excel->sheets[0]['numRows']; $x++) {
							$sql = $this->escape("INSERT into ec_product(
							ec_product.model_number,
							ec_product.title, 
							ec_product.description, 
							ec_product.stock_quantity, 
							ec_product.weight, 
							ec_product.price, 
							ec_product.list_price, 
							ec_product.vat_rate, 
							ec_product.handling_price, 
							ec_product.image1, 
							ec_product.image2, 
							ec_product.image3, 
							ec_product.image4, 
							ec_product.image5, 
							ec_product.seo_description, 
							ec_product.seo_keywords, 
							ec_product.specifications, 
							ec_product.use_specifications, 
							ec_product.activate_in_store, 
							ec_product.use_customer_reviews, 
							ec_product.is_giftcard, 
							ec_product.is_download, 
							ec_product.is_donation,
							ec_product.is_special, 
							ec_product.is_taxable, 
							ec_product.show_on_startup, 
							ec_product.show_stock_quantity)
				values('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s', '%s', '%s', '%s', '%s')",
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][1]),
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][2]),
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][3]),
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][4]),
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][5]),
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][6]),
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][7]),
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
							mysql_real_escape_string($excel->sheets[0]['cells'][$x][27]));
							
							if (!mysql_query($sql)) {
								//error out
								break;
							} else {
								//Enqueue Quickbooks Add Product
								if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
									$quickbooks = new ec_quickbooks( );
									$quickbooks->add_product( $excel->sheets[0]['cells'][$x][1] ); //model_number	
								}
								
								// Insert a WordPress Custom post type post.
								$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $excel->sheets[0]['cells'][$x][1] . "\"]",
												'post_status'	=> "publish",
												'post_title'	=> $excel->sheets[0]['cells'][$x][2],
												'post_type'		=> "ec_store"
											  );
								$post_id = wp_insert_post( $post, $wp_error );
								$db = new ec_db( );
								$db->update_product_post_id( $newproductid, $post_id );
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