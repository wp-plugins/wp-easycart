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


class dashboard
	{		
	
		function dashboard() {
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
		   if ($methodName == 'getdashboardorders') return array('admin');
		   else if($methodName == 'getdashboardmenus') return array('admin');
		   else if($methodName == 'getdashboardreviews') return array('admin');
		   else if($methodName == 'getdashboardproducts') return array('admin');
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
		
		
		//dashboard functions
		function getdashboardorders() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_order.billing_first_name, ec_order.billing_last_name, ec_order.grand_total, UNIX_TIMESTAMP(ec_order.order_date) AS order_date, ec_order.user_email, ec_order.orderstatus_id, ec_order.order_id, ec_order.order_viewed FROM ec_order  ORDER BY ec_order.order_date DESC LIMIT 0, 23");
			  
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);
			  
			  //if results, convert to an array for use in  flash
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
		
		function getdashboardmenus() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_menulevel1.* FROM ec_menulevel1 ORDER BY ec_menulevel1.clicks DESC LIMIT 0, 6");
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
		function getdashboardreviews() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS  ec_product.title, reviews.*, UNIX_TIMESTAMP(reviews.datesubmitted) AS datesubmitted  FROM reviews  LEFT JOIN products ON ec_product.product_id = reviews.productID ORDER BY reviews.datesubmitted DESC LIMIT 0, 6");
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
		function getdashboardproducts() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_product.*, statistics.* FROM products LEFT JOIN statistics ON ec_product.product_id = statistics.ProductID ORDER BY statistics.views DESC LIMIT 0, 6");
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

	}//close class
?>