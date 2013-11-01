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


class pricepoints
	{		
	
		function pricepoints() {
			//load our connection settings
			if( file_exists( '../../../../wp-easycart-data/connection/ec_conn.php' ) )
				require_once('../../../../wp-easycart-data/connection/ec_conn.php');
			else
				require_once('../../../connection/ec_conn.php');
		
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
		   if ($methodName == 'getpricepoints') return array('admin');
		   else if($methodName == 'updatepricepoint') return array('admin');
		   else if($methodName == 'deletepricepoint') return array('admin');
		   else if($methodName == 'addpricepoint') return array('admin');
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
		
		
		//price point functions
		function getpricepoints() {
			//Create SQL Query
			$sql = "SELECT ec_pricepoint.* FROM ec_pricepoint ORDER BY ec_pricepoint.order ASC";
			
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
		
		function updatepricepoint($id, $pricepoint) {
			//convert object to array
			  $pricepoint = (array)$pricepoint;
			  
			//Create SQL Query
			  $sql = $this->escape("UPDATE ec_pricepoint SET ec_pricepoint.is_less_than = '%s', ec_pricepoint.is_greater_than = '%s', ec_pricepoint.low_point = '%s', ec_pricepoint.high_point = '%s', ec_pricepoint.order = '%s' WHERE ec_pricepoint.pricepoint_id = '%s'", $pricepoint['lessthan'], $pricepoint['greaterthan'], $pricepoint['lowpoint'], $pricepoint['highpoint'], $pricepoint['pricepointorder'], $id);
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
		function deletepricepoint($id) {
			//Create SQL Query
			$sql = $this->escape("DELETE FROM ec_pricepoint WHERE ec_pricepoint.pricepoint_id = %s", $id);
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
		function addpricepoint($pricepoint) {
			//convert object to array
			  $pricepoint = (array)$pricepoint;
			  
			//Create SQL Query
			$sql = sprintf("Insert into ec_pricepoint(ec_pricepoint.pricepoint_id, ec_pricepoint.is_less_than, ec_pricepoint.is_greater_than, ec_pricepoint.low_point, ec_pricepoint.high_point, ec_pricepoint.order)
				values(null, '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($pricepoint['lessthan']),
				mysql_real_escape_string($pricepoint['greaterthan']),
				mysql_real_escape_string($pricepoint['lowpoint']),
				mysql_real_escape_string($pricepoint['highpoint']),
				mysql_real_escape_string($pricepoint['pricepointorder']));
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