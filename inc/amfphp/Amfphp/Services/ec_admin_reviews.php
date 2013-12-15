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


class ec_admin_reviews
	{		
	
		function ec_admin_reviews() {
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
		   if ($methodName == 'getreviews') return array('admin');
		   else if($methodName == 'deletereview') return array('admin');
		   else if($methodName == 'updatereview') return array('admin');
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
		


		//review functions
		function getreviews($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS  ec_review.*, UNIX_TIMESTAMP(ec_review.date_submitted) AS date_submitted, ec_product.model_number, ec_product.title as product_title, ec_product.activate_in_store, ec_product.image1, ec_product.price  FROM ec_review LEFT JOIN ec_product ON ec_product.product_id = ec_review.product_id WHERE ec_review.review_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletereview($reviewid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_review WHERE ec_review.review_id = '%s'", $reviewid);
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
		function updatereview($reviewid, $review) {
			  //convert object to array
			  $review = (array)$review;
			  
			  
			  //Create SQL Query
			   $sql = $this->escape("UPDATE ec_review SET ec_review.approved='%s', ec_review.title='%s', ec_review.description='%s', ec_review.rating='%s' WHERE ec_review.review_id = '%s'", $review['approved'], $review['reviewtitle'],$review['reviewdescription'],$review['rating'],$reviewid);

			//Run query on database;
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




	}//close class
?>