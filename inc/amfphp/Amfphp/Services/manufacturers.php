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


class manufacturers
	{		
	
		function manufacturers() {
			//load our connection settings
			if( file_exists( '../../../../wp-easycart-data/connection/ec_conn.php' ) ) {
				require_once('../../../../wp-easycart-data/connection/ec_conn.php');
			} else {
				require_once('../../../connection/ec_conn.php');
			}
		
			//set our connection variables
			$dbhost = HOSTNAME;
			$dbname = DATABASE;
			$dbuser = USERNAME;
			$dbpass = PASSWORD;	

			//make a connection to our database
			$this->conn = mysql_connect($dbhost, $dbuser, $dbpass);
			mysql_select_db ($dbname);		
			mysql_query("SET CHARACTER SET utf8", $this->conn); 
			mysql_query("SET NAMES 'utf8'", $this->conn); 

		}	
			
		
		//secure all of the services for logged in authenticated users only	
		public function _getMethodRoles($methodName){
		   if ($methodName == 'getmanufacturers') return array('admin');
		   else if($methodName == 'getmanufacturerset') return array('admin');
		   else if($methodName == 'deletemanufacturer') return array('admin');
		   else if($methodName == 'updatemanufacturer') return array('admin');
		   else if($methodName == 'addmanufacturer') return array('admin');
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
		
		
		//manufacturer functions
		function getmanufacturers() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_manufacturer.* FROM ec_manufacturer ORDER BY ec_manufacturer.name");
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
		
		function getmanufacturerset($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_manufacturer.* FROM ec_manufacturer  WHERE ec_manufacturer.manufacturer_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletemanufacturer($manufacturerid) {
			// Remove the post from WordPress
			$sql_get_post_id = $this->escape( "SELECT post_id FROM ec_manufacturer WHERE manufacturer_id = %d", $manufacturerid );
			$result = mysql_query( $sql_get_post_id );
			$manufacturer = mysql_fetch_array( $result );
			wp_delete_post( $manufacturer['post_id'], true );
			
			//Create SQL Query	
			$deletesql = $this->escape("DELETE FROM ec_manufacturer WHERE ec_manufacturer.manufacturer_id = '%s'", $manufacturerid);
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
		function updatemanufacturer($manufacturerid, $manufacturer) {
			//convert object to array
			$manufacturer = (array)$manufacturer;
			
			// Update WordPress to match
			// Remove the post from WordPress
			$sql_get_post_id = $this->escape( "SELECT post_id FROM ec_manufacturer WHERE manufacturer_id = %d", $manufacturerid );
			$result = mysql_query( $sql_get_post_id );
			$manufacturer_post = mysql_fetch_array( $result );
			wp_delete_post( $manufacturer_post['post_id'], true );
			
			//Create SQL Query
			$sql = sprintf("Replace into ec_manufacturer(ec_manufacturer.manufacturer_id, ec_manufacturer.name, ec_manufacturer.clicks) values('".$manufacturerid."', '%s', '%s')",
					mysql_real_escape_string($manufacturer['manufacturername']),
					mysql_real_escape_string($manufacturer['clicks']));
			
			mysql_query($sql);
			
			// Insert a WordPress Custom post type post.
			$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturerid . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $manufacturer['manufacturername'],
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post, $wp_error );
			$db = new ec_db( );
			$db->update_manufacturer_post_id( $manufacturerid, $post_id );
			
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
		function addmanufacturer($manufacturer) {
			//convert object to array
			$manufacturer = (array)$manufacturer;
			
			//Create SQL Query
			$sql = sprintf("Insert into ec_manufacturer(ec_manufacturer.manufacturer_id, ec_manufacturer.name, ec_manufacturer.clicks) values(Null, '%s', '%s')",
					mysql_real_escape_string($manufacturer['manufacturername']),
					mysql_real_escape_string($manufacturer['clicks']));
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$manufacturerid = mysql_insert_id( );
				// Insert a WordPress Custom post type post.
				$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturerid . "\"]",
								'post_status'	=> "publish",
								'post_title'	=> $manufacturer['manufacturername'],
								'post_type'		=> "ec_store"
							  );
				$post_id = wp_insert_post( $post, $wp_error );
				$db = new ec_db( );
				$db->update_manufacturer_post_id( $manufacturerid, $post_id );
				
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}
	}//close class
?>