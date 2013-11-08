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


class countrys
	{		
	
		function countrys() {
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
		   if ($methodName == 'getcountries') return array('admin');
		   else if($methodName == 'updatecountry') return array('admin');
		   else if($methodName == 'deletecountry') return array('admin');
		   else if($methodName == 'addcountry') return array('admin');
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
		
		function getcountries() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_country.* FROM ec_country ORDER BY ec_country.sort_order ASC");
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
		

		//country list functions
		//get countries is handled above
		function updatecountry($id, $name, $iso2, $iso3, $vatrate, $sortorder) {
			//Create SQL Query
			  $sql = $this->escape("UPDATE ec_country SET  ec_country.name_cnt='%s', ec_country.iso2_cnt='%s', ec_country.iso3_cnt='%s', ec_country.vat_rate_cnt='%s', ec_country.sort_order='%s' WHERE ec_country.id_cnt = '%s'", $name, $iso2, $iso3, $vatrate, $sortorder, $id);
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
		function deletecountry($id) {
			//Create SQL Query
			$sql = sprintf("DELETE FROM ec_country WHERE ec_country.id_cnt = $id");
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
		function addcountry($name, $iso2, $iso3, $vatrate, $sortorder) {
			//Create SQL Query
			  $sql = sprintf("Insert into ec_country(ec_country.id_cnt, ec_country.name_cnt, ec_country.iso2_cnt, ec_country.iso3_cnt, ec_country.vat_rate_cnt, ec_country.sort_order)
				values(null, '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($name),
				mysql_real_escape_string($iso2),
				mysql_real_escape_string($iso3),
				mysql_real_escape_string($vatrate),
				mysql_real_escape_string($sortorder));
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