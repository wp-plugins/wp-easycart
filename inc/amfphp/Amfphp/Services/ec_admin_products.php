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


class ec_admin_products
	{		
	
		function ec_admin_products() {
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
			
			if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
				require_once( "../../../../wp-easycart-quickbooks/ec_quickbooks.php" );
				require_once( "../../../../wp-easycart-quickbooks/QuickBooks.php" );
			}


			//make a connection to our database
			$this->conn = mysql_connect($dbhost, $dbuser, $dbpass);
			mysql_select_db ($dbname);
			mysql_query("SET CHARACTER SET utf8", $this->conn); 
			mysql_query("SET NAMES 'utf8'", $this->conn); 	

		}	
			
		
		//secure all of the services for logged in authenticated users only	
		public function _getMethodRoles($methodName){
			if ($methodName == 'deleteadvancedoption') return array('admin');
			else if($methodName == 'deletealladvancedoption') return array('admin');
			else if($methodName == 'addadvancedoption') return array('admin');
			else if($methodName == 'getadvancedproductoptions') return array('admin');
		    else if($methodName == 'getfeaturedproducts') return array('admin');
		    else if($methodName == 'getproductlist') return array('admin');
		    else if($methodName == 'getproducts') return array('admin');
		    else if($methodName == 'duplicateproduct') return array('admin');
		    else if($methodName == 'deleteproduct') return array('admin');
		    else if($methodName == 'updateproduct') return array('admin');
		    else if($methodName == 'addproduct') return array('admin');
		    else if($methodName == 'deleteimage') return array('admin');
		    else if($methodName == 'deleteoptionitemimage') return array('admin');
		    else if($methodName == 'deletefiledownload') return array('admin');
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
		
		function deletealladvancedoption($product_id) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_option_to_product WHERE ec_option_to_product.product_id = '%s'", $product_id);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			   			  
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] = "success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		function deleteadvancedoption($optionlinkid, $product_id) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_option_to_product WHERE ec_option_to_product.option_to_product_id = '%s'", $optionlinkid);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			   //Create SQL Query
			  $sql = $this->escape("SELECT 
									  ec_option.option_name,
									  ec_option.option_label,
									  ec_option.option_type,
									  ec_option.option_required,
									  ec_option.option_error_text,
									  ec_option.option_id,
									  ec_product.model_number,
									  ec_product.product_id,
									  ec_option_to_product.product_id,
									  ec_option_to_product.option_to_product_id,
									  ec_option_to_product.option_id
									FROM
									  ec_option_to_product
									  INNER JOIN ec_product ON (ec_option_to_product.product_id = ec_product.product_id)
									  INNER JOIN ec_option ON (ec_option_to_product.option_id = ec_option.option_id)
									WHERE
									  ec_option_to_product.product_id = '".$product_id."'
									ORDER BY
									  ec_option_to_product.option_to_product_id");
			  // Run query on database
			  $result = mysql_query($sql);
			  
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  while ($row=mysql_fetch_object($result)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}

		function addadvancedoption($product_id, $optionid) {
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_option_to_product(ec_option_to_product.option_to_product_id, ec_option_to_product.option_id, ec_option_to_product.product_id, ec_option_to_product.role_label)
				values(Null, '%s', '%s', 'shopper')",
				mysql_real_escape_string($optionid),
				mysql_real_escape_string($product_id));
			  mysql_query($sql);
			  
			  
			   //Create SQL Query
			  $sql = $this->escape("SELECT 
									  ec_option.option_name,
									  ec_option.option_label,
									  ec_option.option_type,
									  ec_option.option_required,
									  ec_option.option_error_text,
									  ec_option.option_id,
									  ec_product.model_number,
									  ec_product.product_id,
									  ec_option_to_product.product_id,
									  ec_option_to_product.option_to_product_id,
									  ec_option_to_product.option_id
									FROM
									  ec_option_to_product
									  INNER JOIN ec_product ON (ec_option_to_product.product_id = ec_product.product_id)
									  INNER JOIN ec_option ON (ec_option_to_product.option_id = ec_option.option_id)
									WHERE
									  ec_option_to_product.product_id = '".$product_id."'
									ORDER BY
									  ec_option_to_product.option_to_product_id");
			  // Run query on database
			  $result = mysql_query($sql);
			  
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  while ($row=mysql_fetch_object($result)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function getadvancedproductoptions($product_id) {
			  //Create SQL Query
			  $sql = $this->escape("SELECT 
									  ec_option.option_name,
									  ec_option.option_label,
									  ec_option.option_type,
									  ec_option.option_required,
									  ec_option.option_error_text,
									  ec_option.option_id,
									  ec_product.model_number,
									  ec_product.product_id,
									  ec_option_to_product.product_id,
									  ec_option_to_product.option_to_product_id,
									  ec_option_to_product.option_id
									FROM
									  ec_option_to_product
									  INNER JOIN ec_product ON (ec_option_to_product.product_id = ec_product.product_id)
									  INNER JOIN ec_option ON (ec_option_to_product.option_id = ec_option.option_id)
									WHERE
									  ec_option_to_product.product_id = '".$product_id."'
									ORDER BY
									  ec_option_to_product.option_to_product_id");
			  // Run query on database
			  $result = mysql_query($sql);
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($result) > 0) {
				  while ($row=mysql_fetch_object($result)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function getfeaturedproducts() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_product.product_id, ec_product.title, ec_product.model_number FROM ec_product ORDER BY ec_product.title ASC");
			  // Run query on database
			  $result = mysql_query($sql);
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($result) > 0) {
				  while ($row=mysql_fetch_object($result)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function getproductlist() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_product.title, ec_product.product_id FROM ec_product ORDER BY ec_product.title ASC");
			  // Run query on database
			  $result = mysql_query($sql);
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($result) > 0) {
				  while ($row=mysql_fetch_object($result)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		

		
		//product functions
		function getproducts($startrecord, $limit, $orderby, $ordertype, $filter) {
			//Create SQL Query
			$sql = "SELECT SQL_CALC_FOUND_ROWS ec_product.* FROM ec_product  WHERE ec_product.product_id != '' " . $filter . " ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord . ", ". $limit;
			$query = mysql_query($sql);
			$totalquery=mysql_query("SELECT FOUND_ROWS()");
			$totalrows = mysql_fetch_object($totalquery);

			//if results, convert to an array for use in flash
			if(mysql_num_rows($query) > 0) {
			  while ($row = mysql_fetch_object($query)) {
				  if($row->use_optionitem_images == 1) {
					$findimagesql = "SELECT ec_optionitemimage.image1 FROM ec_optionitemimage WHERE ec_optionitemimage.product_id = '".$row->product_id."'";
					$findimagequery = mysql_query($findimagesql);
					while ($images = mysql_fetch_array($findimagequery)) {
						$row->image1 = $images[0];	
					}
				  }
				  $row->totalrows=$totalrows;
				  $returnArray[] = $row;
			  }
			  return($returnArray); //return array results if there are some
			} else {
			  $returnArray[] = "noresults";
			  return $returnArray; //return noresults if there are no results
			}
		}
		
		
		function duplicateproduct($productid) {
			
			// load the original record into an array
			$result = mysql_query(sprintf("SELECT * FROM ec_product WHERE ec_product.product_id = '%s'", mysql_real_escape_string($productid)));
			$original_record = mysql_fetch_assoc($result);
			
			$randmodel = rand(1000000, 10000000);
			
			// insert the new record and get the new auto_increment id
			mysql_query(sprintf("INSERT INTO ec_product(ec_product.product_id, ec_product.model_number) VALUES (NULL, '%s')", mysql_real_escape_string($randmodel)));
			$newid = mysql_insert_id();
			
			// generate the query to update the new record with the previous values
			$query = "UPDATE ec_product SET ";
			foreach ($original_record as $key => $value) {
				if ($key != "product_id" && $key != "model_number") {
					//$query .= '`'.$key.'` = "'.str_replace('"','\"',mysql_real_escape_string($value)).'", '; //removed, was adding double \\" to escape them 
					if ($key == 'added_to_db_date') {
						$query .= '`'.$key.'` = NOW(), ';
					} else if ($key == 'views') {
						$query .= '`'.$key.'` = "0", ';
					} else {
						$query .= '`'.$key.'` = "'.mysql_real_escape_string($value).'", ';
					}
				}
			}
			$query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
			$query .= " WHERE product_id=" . $newid;
			mysql_query($query);
		
			
			//duplicate option image rows
			$optionimagessql = sprintf("SELECT * FROM ec_optionitemimage WHERE ec_optionitemimage.product_id = '%s'", mysql_real_escape_string($productid));
			$result = mysql_query($optionimagessql);
			
			while($row = mysql_fetch_assoc($result)){
				$sql = sprintf("INSERT INTO ec_optionitemimage(ec_optionitemimage.optionitem_id, ec_optionitemimage.image1, ec_optionitemimage.image2, ec_optionitemimage.image3, ec_optionitemimage.image4, ec_optionitemimage.image5, ec_optionitemimage.product_id) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
				mysql_real_escape_string($row['optionitem_id']), 
				mysql_real_escape_string($row['image1']), 
				mysql_real_escape_string($row['image2']), 
				mysql_real_escape_string($row['image3']), 
				mysql_real_escape_string($row['image4']), 
				mysql_real_escape_string($row['image5']), 
				mysql_real_escape_string($newid));
				mysql_query($sql);
			}
			
			//duplicate tiered pricing
			$tierpricingsql = sprintf("SELECT * FROM ec_pricetier WHERE ec_pricetier.product_id = '%s'", mysql_real_escape_string($productid));
			$result = mysql_query($tierpricingsql);
			
			while($row = mysql_fetch_assoc($result)){
				$sql = sprintf("INSERT INTO ec_pricetier(ec_pricetier.product_id, ec_pricetier.price, ec_pricetier.quantity) VALUES('%s', '%s', '%s')", 
				mysql_real_escape_string($newid), 
				mysql_real_escape_string($row['price']), 
				mysql_real_escape_string($row['quantity']));
				mysql_query($sql);
			}
			
			//duplicate B2B role pricing
			$rolepricingsql = sprintf("SELECT * FROM ec_roleprice WHERE ec_roleprice.product_id = '%s'", mysql_real_escape_string($productid));
			$result = mysql_query($rolepricingsql);
			
			while($row = mysql_fetch_assoc($result)){
				$sql = sprintf("INSERT INTO ec_roleprice(ec_roleprice.product_id, ec_roleprice.role_label, ec_roleprice.role_price) VALUES('%s', '%s', '%s')", 
				mysql_real_escape_string($newid), 
				mysql_real_escape_string($row['role_label']), 
				mysql_real_escape_string($row['role_price']));
				mysql_query($sql);
			}
			
			//duplicate option quantity rows
			$optionquantitysql = sprintf("SELECT * FROM ec_optionitemquantity WHERE ec_optionitemquantity.product_id = '%s'", mysql_real_escape_string($productid));
			$result = mysql_query($optionquantitysql);
			
			while($row = mysql_fetch_assoc($result)){
				$sql = sprintf("INSERT INTO ec_optionitemquantity(ec_optionitemquantity.optionitem_id_1, ec_optionitemquantity.optionitem_id_2, ec_optionitemquantity.optionitem_id_3, ec_optionitemquantity.optionitem_id_4, ec_optionitemquantity.optionitem_id_5, ec_optionitemquantity.quantity, ec_optionitemquantity.product_id) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
				mysql_real_escape_string($row['OptionItemID1']), 
				mysql_real_escape_string($row['OptionItemID2']), 
				mysql_real_escape_string($row['OptionItemID3']), 
				mysql_real_escape_string($row['OptionItemID4']), 
				mysql_real_escape_string($row['OptionItemID5']), 
				mysql_real_escape_string($row['Quantity']), 
				mysql_real_escape_string($newid));
				mysql_query($sql);
 
			}
			
			//Enqueue Quickbooks Update Customer
			if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->add_product( $randmodel );	
			}
			
			// Insert a WordPress Custom post type post.
			$sql_product = sprintf("SELECT title FROM ec_product WHERE ec_product.model_number = '%s'", $randmodel );
			$result_get_product = mysql_query( $sql_product );
			$product = mysql_fetch_assoc( $result_get_product );
			$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $randmodel . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $product['title'],
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post, $wp_error );
			$db = new ec_db( );
			$db->update_product_post_id( $newid, $post_id );

			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		function deleteproduct($productid) {
			  //Remove Product
			  $deletesql = $this->escape("DELETE FROM ec_product WHERE ec_product.product_id = '%s'", $productid);
			  mysql_query($deletesql);
			  
			  //remove Option Item Images
			  $deletesql = $this->escape("DELETE FROM ec_optionitemimage WHERE ec_optionitemimage.product_id = '%s'", $productid);
			  mysql_query($deletesql);
			  
			  //Remove price tiers
			  $deletesql = $this->escape("DELETE FROM ec_pricetier WHERE ec_pricetier.product_id = '%s'", $productid);
			  mysql_query($deletesql);
			  
			  //Remove role pricing
			  $deletesql = $this->escape("DELETE FROM ec_roleprice WHERE ec_roleprice.product_id = '%s'", $productid);
			  mysql_query($deletesql);
			  
			  //Remove Option Item Quantity
			  $deletesql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.product_id = '%s'", $productid);
			  mysql_query($deletesql);
			  
			  //Remove Reviews
			  $deletesql = $this->escape("DELETE FROM ec_review WHERE ec_review.product_id = '%s'", $productid);
			  mysql_query($deletesql);
			  
			  //Remove Item from Product Groupings
			  $deletesql = $this->escape("DELETE FROM ec_categoryitem WHERE ec_categoryitem.product_id = '%s'", $productid);
			  mysql_query($deletesql);
			  
			  
			  
			  //Delete the post for this item from WordPress
			  wp_delete_post( $product['post_id'], true );
			  
			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function updateproduct($productid, $product) {
			
			  //convert object to array
			  $product = (array)$product;
			  
			  // Update the WordPress entry
			$sql = $this->escape( "SELECT post_id FROM ec_product WHERE product_id = %d", $productid );
			$result = mysql_query( $sql );
			$result_product = mysql_fetch_array( $result );
			
					
			//configure default images  
			if ($product['useoptionitemimages'] == 1) {
				 $product['Image1'] = '';
				 $product['Image2'] = '';
				 $product['Image3'] = '';
				 $product['Image4'] = '';
				 $product['Image5'] = ''; 
			  }
			  
			  //set default handling price
			  $handling_price = '0';
			  if ($product['handling_price']) $handling_price = $product['handling_price'];
			  
			  //set default vat rate
			  $vat_rate = '0';
			  if ($product['vatrate']) $vat_rate = $product['vatrate'];
			  
			  
			  //Create SQL Query
			  $sql = sprintf("UPDATE ec_product SET price = '%s', title = '%s', description = '%s', model_number = '%s', activate_in_store = '%s', manufacturer_id = '%s', image1 = '%s', image2 = '%s', image3 = '%s', image4 = '%s', image5 = '%s', is_giftcard = '%s', download_file_name = '%s', is_taxable = '%s', is_download = '%s', weight = '%s', stock_quantity = '%s', show_on_startup = '%s', menulevel1_id_1 = '%s', menulevel1_id_2 = '%s', menulevel1_id_3 = '%s', menulevel2_id_1 = '%s', menulevel2_id_2 = '%s', menulevel2_id_3 = '%s', menulevel3_id_1 = '%s', menulevel3_id_2 = '%s', menulevel3_id_3 = '%s', option_id_1 = '%s', option_id_2 = '%s', option_id_3 = '%s', option_id_4 = '%s', option_id_5 = '%s', featured_product_id_1 = '%s', featured_product_id_2 = '%s', featured_product_id_3 = '%s', featured_product_id_4 = '%s', seo_description = '%s', use_specifications = '%s', use_customer_reviews = '%s', specifications = '%s', list_price = '%s', seo_keywords = '%s', is_special = '%s', use_optionitem_images = '%s', use_optionitem_quantity_tracking = '%s', is_donation = '%s', show_stock_quantity = '%s', maximum_downloads_allowed = '%s', download_timelimit_seconds = '%s', handling_price = '%s', vat_rate= '%s', use_advanced_optionset = '%s' WHERE product_id = '%s'",
				mysql_real_escape_string($product['listprice']),
				mysql_real_escape_string($product['producttitle']),
				mysql_real_escape_string($product['productdescription']),
				mysql_real_escape_string($product['modelnumber']),
				mysql_real_escape_string($product['listproduct']),
				mysql_real_escape_string($product['productmanufacturer']),
				mysql_real_escape_string($product['Image1']),
				mysql_real_escape_string($product['Image2']),
				mysql_real_escape_string($product['Image3']),
				mysql_real_escape_string($product['Image4']),
				mysql_real_escape_string($product['Image5']),
				mysql_real_escape_string($product['isgiftcard']),
				mysql_real_escape_string($product['downloadid']),
				mysql_real_escape_string($product['taxableproduct']),
				mysql_real_escape_string($product['isdownload']),
				mysql_real_escape_string($product['productweight']),
				mysql_real_escape_string($product['quantity']),
				mysql_real_escape_string($product['featuredproduct']),
				mysql_real_escape_string($product['Cat1Name']),
				mysql_real_escape_string($product['Cat2Name']),
				mysql_real_escape_string($product['Cat3Name']),
				mysql_real_escape_string($product['Cat1bName']),
				mysql_real_escape_string($product['Cat2bName']),
				mysql_real_escape_string($product['Cat3bName']),
				mysql_real_escape_string($product['Cat1cName']),
				mysql_real_escape_string($product['Cat2cName']),
				mysql_real_escape_string($product['Cat3cName']),
				mysql_real_escape_string($product['option1']),
				mysql_real_escape_string($product['option2']),
				mysql_real_escape_string($product['option3']),
				mysql_real_escape_string($product['option4']),
				mysql_real_escape_string($product['option5']),
				mysql_real_escape_string($product['featureproduct1']),
				mysql_real_escape_string($product['featureproduct2']),
				mysql_real_escape_string($product['featureproduct3']),
				mysql_real_escape_string($product['featureproduct4']),
				mysql_real_escape_string($product['seoshortdescription']),
				mysql_real_escape_string($product['usespecs']),
				mysql_real_escape_string($product['allowreviews']),
				mysql_real_escape_string($product['specifications']),
				mysql_real_escape_string($product['previousprice']),
				mysql_real_escape_string($product['seokeywords']),
				mysql_real_escape_string($product['isspecial']),
				mysql_real_escape_string($product['useoptionitemimages']),
				mysql_real_escape_string($product['usequantitytracking']),
				mysql_real_escape_string($product['isdonation']),
				mysql_real_escape_string($product['show_stock_quantity']),
				mysql_real_escape_string($product['maximum_downloads_allowed']),
				mysql_real_escape_string($product['download_timelimit_seconds']),
				mysql_real_escape_string($product['handling_price']),
				mysql_real_escape_string($product['vatrate']),
				mysql_real_escape_string($product['use_advanced_optionset']),
				mysql_real_escape_string($productid));

			//Run query on database;
			mysql_query($sql);
			//return mysql_error();
			
			//Enqueue Quickbooks Update Customer
			if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->update_product( $product['modelnumber'] );	
			}
			
			// Insert a WordPress Custom post type post.
			$post = array(	'ID'			=> $result_product['post_id'],
							'post_content'	=> "[ec_store modelnumber=\"" . $product['modelnumber'] . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $product['producttitle'],
							'post_type'		=> "ec_store",
							'post_name'		=> str_replace(' ', '-', $product['producttitle'] ),
						  );
			$post_id = wp_update_post( $post );
			
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$sqlerror = mysql_error();
				$error = explode(" ", $sqlerror);
				if ($error[0] == "Duplicate") {
					$returnArray[] = "duplicate";
					return $returnArray; //return noresults if there are no results
			    } else {  
					$returnArray[] = "error";
					return $returnArray; //return noresults if there are no results
				}
			}
		}


		function addproduct($product) {
			
			  //convert object to array
			  $product = (array)$product;
			  
			  if ($product['useoptionitemimages'] == 1) {
				 $product['Image1'] = '';
				 $product['Image2'] = '';
				 $product['Image3'] = '';
				 $product['Image4'] = '';
				 $product['Image5'] = ''; 
			  }
			  
			  //set default handling price
			  $handling_price = '0';
			  if ($product['handling_price']) $handling_price = $product['handling_price'];
			  
			  //set default vat rate
			  $vat_rate = '0';
			  if ($product['vatrate']) $vat_rate = $product['vatrate'];
			  
			  //Create SQL Query
			  $sql = sprintf("INSERT into ec_product(ec_product.price, ec_product.title, ec_product.description, ec_product.model_number, ec_product.activate_in_store, ec_product.manufacturer_id, ec_product.image1, ec_product.image2, ec_product.image3, ec_product.image4, ec_product.image5, ec_product.is_giftcard, ec_product.download_file_name, ec_product.is_taxable, ec_product.is_download, ec_product.weight, ec_product.stock_quantity, ec_product.show_on_startup, ec_product.menulevel1_id_1, ec_product.menulevel1_id_2, ec_product.menulevel1_id_3, ec_product.menulevel2_id_1, ec_product.menulevel2_id_2, ec_product.menulevel2_id_3, ec_product.menulevel3_id_1, ec_product.menulevel3_id_2, ec_product.menulevel3_id_3, ec_product.option_id_1, ec_product.option_id_2, ec_product.option_id_3, ec_product.option_id_4, ec_product.option_id_5, ec_product.featured_product_id_1, ec_product.featured_product_id_2, ec_product.featured_product_id_3, ec_product.featured_product_id_4, ec_product.seo_description, ec_product.use_specifications, ec_product.use_customer_reviews, ec_product.specifications, ec_product.list_price, ec_product.seo_keywords, ec_product.is_special, ec_product.use_optionitem_images, ec_product.use_optionitem_quantity_tracking, ec_product.is_donation, ec_product.show_stock_quantity, ec_product.maximum_downloads_allowed, ec_product.download_timelimit_seconds, ec_product.handling_price, ec_product.vat_rate, ec_product.use_advanced_optionset)
				values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($product['listprice']),
				mysql_real_escape_string($product['producttitle']),
				mysql_real_escape_string($product['productdescription']),
				mysql_real_escape_string($product['modelnumber']),
				mysql_real_escape_string($product['listproduct']),
				mysql_real_escape_string($product['productmanufacturer']),
				mysql_real_escape_string($product['Image1']),
				mysql_real_escape_string($product['Image2']),
				mysql_real_escape_string($product['Image3']),
				mysql_real_escape_string($product['Image4']),
				mysql_real_escape_string($product['Image5']),
				mysql_real_escape_string($product['isgiftcard']),
				mysql_real_escape_string($product['downloadid']),
				mysql_real_escape_string($product['taxableproduct']),
				mysql_real_escape_string($product['isdownload']),
				mysql_real_escape_string($product['productweight']),
				mysql_real_escape_string($product['quantity']),
				mysql_real_escape_string($product['featuredproduct']),
				mysql_real_escape_string($product['Cat1Name']),
				mysql_real_escape_string($product['Cat2Name']),
				mysql_real_escape_string($product['Cat3Name']),
				mysql_real_escape_string($product['Cat1bName']),
				mysql_real_escape_string($product['Cat2bName']),
				mysql_real_escape_string($product['Cat3bName']),
				mysql_real_escape_string($product['Cat1cName']),
				mysql_real_escape_string($product['Cat2cName']),
				mysql_real_escape_string($product['Cat3cName']),
				mysql_real_escape_string($product['option1']),
				mysql_real_escape_string($product['option2']),
				mysql_real_escape_string($product['option3']),
				mysql_real_escape_string($product['option4']),
				mysql_real_escape_string($product['option5']),
				mysql_real_escape_string($product['featureproduct1']),
				mysql_real_escape_string($product['featureproduct2']),
				mysql_real_escape_string($product['featureproduct3']),
				mysql_real_escape_string($product['featureproduct4']),
				mysql_real_escape_string($product['seoshortdescription']),
				mysql_real_escape_string($product['usespecs']),
				mysql_real_escape_string($product['allowreviews']),
				mysql_real_escape_string($product['specifications']),
				mysql_real_escape_string($product['previousprice']),
				mysql_real_escape_string($product['seokeywords']),
				mysql_real_escape_string($product['isspecial']),
				mysql_real_escape_string($product['useoptionitemimages']),
				mysql_real_escape_string($product['usequantitytracking']),
				mysql_real_escape_string($product['isdonation']),
				mysql_real_escape_string($product['show_stock_quantity']),
				mysql_real_escape_string($product['maximum_downloads_allowed']),
				mysql_real_escape_string($product['download_timelimit_seconds']),
				mysql_real_escape_string($handling_price),
				mysql_real_escape_string($vat_rate),
				mysql_real_escape_string($product['use_advanced_optionset']));
			 	mysql_query($sql);
				if(mysql_error()) {
				  $sqlerror = mysql_error();
				  $error = explode(" ", $sqlerror);
				  if ($error[0] == "Duplicate") {
					  $returnArray[] = "duplicate";
					  return $returnArray; //return noresults if there are no results
				  }
			 	}
		
								
				$sql_getprodid = sprintf("SELECT product_id from ec_product WHERE ec_product.model_number = '%s'", $product['modelnumber']);
				$result_getprodid = mysql_query($sql_getprodid);
				$row_getprodid = mysql_fetch_assoc($result_getprodid);
				$newproductid = $row_getprodid['product_id'];
				
				$updatequantities = sprintf("UPDATE ec_optionitemquantity SET ec_optionitemquantity.product_id = '%s' WHERE ec_optionitemquantity.product_id = '%s'", $newproductid, $product['product_id']);
				mysql_query($updatequantities);
	
				$updateimages = sprintf("UPDATE ec_optionitemimage SET ec_optionitemimage.product_id = '%s' WHERE ec_optionitemimage.product_id = '%s'", $newproductid, $product['product_id']);
				mysql_query($updateimages);

			//Enqueue Quickbooks Update Customer
			if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->add_product( $product['modelnumber'] );	
			}
			
			// Insert a WordPress Custom post type post.
			$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product['modelnumber'] . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $product['producttitle'],
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post, $wp_error );
			$db = new ec_db( );
			$db->update_product_post_id( $newproductid, $post_id );

			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $sqlerror = mysql_error();
				  $error = explode(" ", $sqlerror);
				  if ($error[0] == "Duplicate") {
					  $returnArray[] = "duplicate";
					  return $returnArray; //return noresults if there are no results
				  } else {  
					  $returnArray[] = "error";
					  return $returnArray; //return noresults if there are no results
				  }
			  }
		}
		function deleteimage($productid, $imagelocation, $imagename) {
			  //determine image location and then update databse and remove images and thumbnails			
			  if ($imagelocation == 1) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_product SET image1='' WHERE ec_product.product_id = '%s'", $productid);
					//look for duplicate
					$duplicatesql = sprintf("SELECT product_id from ec_product WHERE ec_product.image1 = '%s'", $imagename);
					$duplicateresult = mysql_query($duplicatesql);
					if (!$duplicateresult) {
						if (file_exists("../../../products/pics1/".$imagename)) unlink("../../../products/pics1/".$imagename);
					}
			  }
			  if ($imagelocation == 2) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_product SET image2='' WHERE ec_product.product_id = '%s'", $productid);
					//look for duplicate
					$duplicatesql = sprintf("SELECT product_id from ec_product WHERE ec_product.image2 = '%s'", $imagename);
					$duplicateresult = mysql_query($duplicatesql);
					if (!$duplicateresult) {
						if (file_exists("../../../products/pics2/".$imagename)) unlink("../../../products/pics2/".$imagename);
					}
		
			  }
			  if ($imagelocation == 3) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_product SET image3='' WHERE ec_product.product_id = '%s'", $productid);
					//look for duplicate
					$duplicatesql = sprintf("SELECT product_id from ec_product WHERE ec_product.image3 = '%s'", $imagename);
					$duplicateresult = mysql_query($duplicatesql);
					if (!$duplicateresult) {
						if (file_exists("../../../products/pics3/".$imagename)) unlink("../../../products/pics3/".$imagename);
					}
			  }
			  if ($imagelocation == 4) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_product SET image4='' WHERE ec_product.product_id = '%s'",  $productid);
					//look for duplicate
					$duplicatesql = sprintf("SELECT product_id from ec_product WHERE ec_product.image4 = '%s'", $imagename);
					$duplicateresult = mysql_query($duplicatesql);
					if (!$duplicateresult) {
						if (file_exists("../../../products/pics4/".$imagename)) unlink("../../../products/pics4/".$imagename);
					}
			  }
			  if ($imagelocation == 5) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_product SET image5='' WHERE ec_product.product_id = '%s'", $productid);
					//look for duplicate
					$duplicatesql = sprintf("SELECT product_id from ec_product WHERE ec_product.image5 = '%s'", $imagename);
					$duplicateresult = mysql_query($duplicatesql);
					if (!$duplicateresult) {
						if (file_exists("../../../products/pics5/".$imagename)) unlink("../../../products/pics5/".$imagename);
					}
			  }

			  //Run query on database;
			  mysql_query($sql);
			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $sqlerror = mysql_error();
				  $error = explode(" ", $sqlerror);
				  if ($error[0] == "Duplicate") {
					  $returnArray[] = "duplicate";
					  return $returnArray; //return noresults if there are no results
				  } else {  
					  $returnArray[] = "error";
					  return $returnArray; //return noresults if there are no results
				  }
			  }
		}
		
		
		function deleteoptionitemimage($productid, $optionitemid, $imagelocation, $imagename) {
			  //determine image location and then update databse and remove images and thumbnails			
			  if ($imagelocation == 1) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_optionitemimage SET image1='' WHERE ec_optionitemimage.product_id = '%s' AND ec_optionitemimage.optionitemimage_id = '%s'", $productid, $optionitemid);
					if (file_exists("../../../products/pics1/".$imagename)) unlink("../../../products/pics1/".$imagename);
			  }
			  if ($imagelocation == 2) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_optionitemimage SET image2='' WHERE ec_optionitemimage.product_id = '%s' AND ec_optionitemimage.optionitemimage_id = '%s'", $productid, $optionitemid);
					if (file_exists("../../../products/pics2/".$imagename)) unlink("../../../products/pics2/".$imagename);
			  }
			  if ($imagelocation == 3) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_optionitemimage SET image3='' WHERE ec_optionitemimage.product_id = '%s' AND ec_optionitemimage.optionitemimage_id = '%s'", $productid, $optionitemid);
					if (file_exists("../../../products/pics3/".$imagename)) unlink("../../../products/pics3/".$imagename);
			  }
			  if ($imagelocation == 4) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_optionitemimage SET image4='' WHERE ec_optionitemimage.product_id = '%s' AND ec_optionitemimage.optionitemimage_id = '%s'", $productid, $optionitemid);
					if (file_exists("../../../products/pics4/".$imagename)) unlink("../../../products/pics4/".$imagename);
			  }
			  if ($imagelocation == 5) {
					//Create SQL Query
					$sql = $this->escape("UPDATE ec_optionitemimage SET image5='' WHERE ec_optionitemimage.product_id = '%s' AND ec_optionitemimage.optionitemimage_id = '%s'", $productid, $optionitemid);
					if (file_exists("../../../products/pics5/".$imagename)) unlink("../../../products/pics5/".$imagename);
			  }

			  //Run query on database;
			  mysql_query($sql);
			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $sqlerror = mysql_error();
				  $error = explode(" ", $sqlerror);
				  if ($error[0] == "Duplicate") {
					  $returnArray[] = "duplicate";
					  return $returnArray; //return noresults if there are no results
				  } else {  
					  $returnArray[] = "error";
					  return $returnArray; //return noresults if there are no results
				  }
			  }
		}
		function deletefiledownload($productid, $filename) {
			  //Create SQL Query
			  $sql = $this->escape("UPDATE ec_product SET ec_product.download_file_name = '' WHERE ec_product.product_id = '%s'", $productid);
			  if (file_exists("../../../products/downloads/".$filename)) unlink("../../../products/downloads/".$filename);
			  //Run query on database;
			  mysql_query($sql);
			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $sqlerror = mysql_error();
				  $error = explode(" ", $sqlerror);
				  if ($error[0] == "Duplicate") {
					  $returnArray[] = "duplicate";
					  return $returnArray; //return noresults if there are no results
				  } else {  
					  $returnArray[] = "error";
					  return $returnArray; //return noresults if there are no results
				  }
			  }
		}



	}//close class
?>