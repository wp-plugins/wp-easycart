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


class ec_admin_taxes
	{		
	
		function ec_admin_taxes() {
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
		   if ($methodName == 'gettaxes') return array('admin');
		   else if($methodName == 'savetax') return array('admin');
		   else if($methodName == 'deletetax') return array('admin');
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
		


		//tax functions
		function gettaxes() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_taxrate.* FROM ec_taxrate");
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
		function savetax($taxrates) {
			//convert object to array 
			  $taxrates = (array)$taxrates;
			  
			  //country tax
			  if($taxrates['taxcountryenable'] == 1) {
				  $sql = $this->escape("DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_country = 1");
				  mysql_query($sql);
				  $sql = sprintf("INSERT into ec_taxrate(ec_taxrate.taxrate_id, ec_taxrate.country_code, ec_taxrate.country_rate, ec_taxrate.tax_by_country)
					values(null, '%s', '%s', 1)",
					mysql_real_escape_string($taxrates['taxcountryid']),
					mysql_real_escape_string($taxrates['taxcountryrate']));
			  }
			  
			  //all tax
			  if($taxrates['taxallenable'] == 1) {
				  $sql = $this->escape("DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_all = 1");
				  mysql_query($sql);
				  $sql = sprintf("INSERT into ec_taxrate(ec_taxrate.taxrate_id, ec_taxrate.all_rate, ec_taxrate.tax_by_all)
					values(null, '%s',  1 )",
					mysql_real_escape_string($taxrates['taxallrate']));
			  }
			  
			  //duty tax
			  if($taxrates['taxdutyenable'] == 1) {
				  $sql = $this->escape("DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_duty = 1");
				  mysql_query($sql);
				  $sql = sprintf("INSERT into ec_taxrate(ec_taxrate.taxrate_id, ec_taxrate.duty_exempt_country_code, ec_taxrate.duty_rate, ec_taxrate.tax_by_duty)
					values(null, '%s', '%s', 1)",
					mysql_real_escape_string($taxrates['taxdutycountryid']),
					mysql_real_escape_string($taxrates['taxdutyrate']));
			  }
			  
			  //vat tax
			  if($taxrates['taxvatenable'] == 1) {
				  $sql = $this->escape("DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_vat = 1");
				  mysql_query($sql);
				  $sql = sprintf("INSERT into ec_taxrate(ec_taxrate.taxrate_id, ec_taxrate.vat_country_code, ec_taxrate.vat_rate, ec_taxrate.tax_by_vat)
					values(null, '%s', '%s', 1)",
					mysql_real_escape_string($taxrates['taxvatcountryid']),
					mysql_real_escape_string($taxrates['taxvatrate']));
			  }
			  
			  //state tax
			  if($taxrates['taxstateenable'] == 1 && $taxrates['taxstaterate'] != '') {
				  $sql = $this->escape("DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_state = 1 AND ec_taxrate.state_code = '".$taxrates['taxstateid']."'");
				  mysql_query($sql);
				  $sql = sprintf("INSERT into ec_taxrate(ec_taxrate.taxrate_id, ec_taxrate.state_code, ec_taxrate.state_rate, ec_taxrate.tax_by_state)
					values(null, '%s', '%s', 1)",
					mysql_real_escape_string($taxrates['taxstateid']),
					mysql_real_escape_string($taxrates['taxstaterate']));
			  }
			  
			  //Create SQL Query
			  
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
					return $returnArray; //return noresults  if there are no results
				}
			}
		}	
		
		function deletetax($taxrates) {
			//convert object to array
			  $taxrates = (array)$taxrates;
			  
			  //country tax
			  if($taxrates['removetaxcountry'] == 1) {
				  $sql = "DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_country = 1";
			  }
			  
			  //all tax
			  if($taxrates['removetaxall'] == 1) {
				  $sql = "DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_all = 1";
			  }
			  
			  //duty tax
			  if($taxrates['removetaxduty'] == 1) {
				  $sql = "DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_duty = 1";
			  }
			  
			  //vat tax
			  if($taxrates['removetaxvat'] == 1) {
				  $sql = "DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_vat = 1";
			  }
			  
			  //remove individual state tax
			  if($taxrates['removetaxstate'] == 1) {
				  $sql = "DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_state = 1 AND ec_taxrate.taxrate_id = ".$taxrates['keyfield']."";
			  }
			  
			  //Delete all states, it has been disabled
			  if($taxrates['removetaxstate'] == 2) {
				  $sql = "DELETE FROM ec_taxrate WHERE ec_taxrate.tax_by_state = 1";
			  }

			  

			  
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