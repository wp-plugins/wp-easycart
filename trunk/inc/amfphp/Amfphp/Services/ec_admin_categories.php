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


class ec_admin_categories
	{		
	
		function ec_admin_categories() {
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

			//make a connection to our database
			$this->conn = mysql_connect($dbhost, $dbuser, $dbpass);
			mysql_select_db ($dbname);	
			mysql_query("SET CHARACTER SET utf8", $this->conn); 
			mysql_query("SET NAMES 'utf8'", $this->conn); 

		}	 
		
			
		//secure all of the services for logged in authenticated users only	
		public function _getMethodRoles($methodName){
		   if($methodName == 'getcategories') return array('admin');
		   else if($methodName == 'getcategorylist') return array('admin');
		   else if($methodName == 'deletecategory') return array('admin');
		   else if($methodName == 'updatecategory') return array('admin');
		   else if($methodName == 'addcategory') return array('admin');
		   else if($methodName == 'getcategoryitems') return array('admin');
		   else if($methodName == 'deletecategoryitem') return array('admin');
		   else if($methodName == 'addcategoryitem') return array('admin');
		   else if($methodName == 'getcategoryproducts') return array('admin');
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
		
		
		//category functions
		function getcategories($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_category.* FROM ec_category  WHERE category_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);
			  
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($query) > 0) {
				  while ($row=mysql_fetch_object($query)) {
					  $row->totalrows=$totalrows;
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		//category functions
		function getcategorylist() {

			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_category.* FROM ec_category");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);
			  
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($query) > 0) {
				  while ($row=mysql_fetch_object($query)) {
					  $row->totalrows=$totalrows;
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function deletecategory($categoryid) {
			// Remove the post from WordPress
			$sql_get_post_id = $this->escape( "SELECT post_id FROM ec_category WHERE category_id = %d", $categoryid );
			$result = mysql_query( $sql_get_post_id );
			$category = mysql_fetch_array( $result );
			wp_delete_post( $category['post_id'], true );
			
			//Create SQL Query	
			$deletesql = $this->escape("DELETE FROM ec_category WHERE ec_category.category_id = '%s'", $categoryid);
			//Run query on database;
			mysql_query($deletesql);
			//Create SQL Query	
			$deletesql = $this->escape("DELETE FROM ec_categoryitem WHERE ec_categoryitem.category_id = '%s'", $categoryid);
			//Run query on database;
			mysql_query($deletesql);
			
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
		function updatecategory($categoryid, $categoryname) {
			//Create and run SQL Query
			$sql = sprintf("UPDATE ec_category SET category_name = '%s' WHERE category_id = %d", mysql_real_escape_string( $categoryname ), mysql_real_escape_string( $categoryid ) );
			mysql_query($sql);
			
			// Update WordPress to match
			// Remove the post from WordPress
			$sql_get_post_id = $this->escape( "SELECT post_id FROM ec_category WHERE category_id = %d", $categoryid );
			$result = mysql_query( $sql_get_post_id );
			$category = mysql_fetch_array( $result );
			
			// Insert a WordPress Custom post type post.
			$post = array(	'ID'			=> $category['post_id'],
							'post_content'	=> "[ec_store groupid=\"" . $categoryid . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $categoryname,
							'post_type'		=> "ec_store",
							'post_name'		=> str_replace(' ', '-', $categoryname ),
						  );
			$post_id = wp_update_post( $post );
			
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
		function addcategory( $categoryname ){
			//Create SQL Query
			$sql = sprintf( "INSERT INTO ec_category(category_name) VALUES('%s')", mysql_real_escape_string( $categoryname ) );
			mysql_query( $sql );
			
			if( !mysql_error( ) ){
				// Insert a WordPress Custom post type post.
				$category_id = mysql_insert_id( );
				$post = array(	'post_content'	=> "[ec_store groupid=\"" . $category_id . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $categoryname,
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post, $wp_error );
				$db = new ec_db( );
				$db->update_category_post_id( $category_id, $post_id );
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			}else{
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}

		//category items function
		function getcategoryitems($startrecord, $limit, $orderby, $ordertype, $filter, $parentid) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_categoryitem.*, ec_product.title, ec_product.product_id FROM ec_categoryitem LEFT JOIN ec_product ON ec_product.product_id = ec_categoryitem.product_id  WHERE ec_categoryitem.categoryitem_id != '' AND ec_categoryitem.category_id = ".$parentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);
			  
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($query) > 0) {
				  while ($row=mysql_fetch_object($query)) {
					  $row->totalrows=$totalrows;
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function deletecategoryitem($categoryitemid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_categoryitem WHERE ec_categoryitem.categoryitem_id = '%s'", $categoryitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  
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

		function addcategoryitem($productid, $categoryid) {
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_categoryitem(categoryitem_id, product_id, category_id)
				values(Null, '%s', '%s')",
				mysql_real_escape_string($productid),
				mysql_real_escape_string($categoryid));
			  mysql_query($sql);
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

		function getcategoryproducts() {
			//Create SQL Query
			$sql = "SELECT ec_product.title, ec_product.product_id FROM ec_product ORDER BY ec_product.title ASC";
			$query = mysql_query($sql);

			//if results, convert to an array for use in flash
			if(mysql_num_rows($query) > 0) {
			  while ($row=mysql_fetch_object($query)) {
				  $returnArray[] = $row;
			  }
			  return($returnArray); //return array results if there are some
			
			} else {
			  $returnArray[] = "noresults";
			}
		}
		



	}//close class
?>