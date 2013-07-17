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


class settings
	{		
	
		function settings() {
			//load our connection settings
			require_once('../../../connection/ec_conn.php');
		
			//set our connection variables
			$dbhost = HOSTNAME;
			$dbname = DATABASE;
			$dbuser = USERNAME;
			$dbpass = PASSWORD;	

			//make a connection to our database
			$this->conn = mysql_pconnect($dbhost, $dbuser, $dbpass);
			mysql_select_db ($dbname);	

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
		
		
		function gettimezones() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_timezone.* FROM ec_timezone ORDER BY ec_timezone.timezone_id ASC");
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
		
		//site settings functions
		function getsitesettings() {
			  //Create SQL Query
			  $query= mysql_query("SELECT 
				  ec_setting.*,
				  wp_options.option_value AS WPstorepage,
				  wp_options1.option_value AS WP_currency_seperator,
				  wp_options2.option_value AS WP_decimal_symbol,
				  wp_options3.option_value AS WP_decimal_places,
				  wp_options4.option_value AS WP_currency_symbol
				FROM
				  ec_setting,
				  wp_options,
				  wp_options wp_options1,
				  wp_options wp_options2,
				  wp_options wp_options3,
				  wp_options wp_options4
				WHERE
				  ec_setting.setting_id = 1 AND 
				  wp_options.option_name = 'ec_option_storepage' AND 
				  wp_options1.option_name = 'ec_option_currency_thousands_seperator' AND 
				  wp_options2.option_name = 'ec_option_currency_decimal_symbol' AND 
				  wp_options3.option_name = 'ec_option_currency_decimal_places' AND 
				  wp_options4.option_name = 'ec_option_currency'");
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
				  //fallback and load settings without wordpress data.
				  //Create SQL Query
				  $query= mysql_query("SELECT 
					  ec_setting.*
					FROM
					  ec_setting
					WHERE
					  ec_setting.setting_id = 1 ");
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
		}
		
		
		function updatesitesettings($settings) {
			//convert object to array
			  $settings = (array)$settings;
			  
			  //Create SQL Query
			  $sql = sprintf("UPDATE ec_setting SET ec_setting.site_url='%s', ec_setting.timezone='%s'  WHERE ec_setting.setting_id = 1",
				mysql_real_escape_string($settings['siteURL']),
				mysql_real_escape_string($settings['timezone']));
				

  

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
		function clearmenustatistics() {
			//Create SQL Query
			$sql = sprintf("UPDATE ec_menulevel1, ec_menulevel2, ec_menulevel3 SET ec_menulevel1.clicks = 0, menulevel2.clicks = 0, menulevel3.clicks = 0");

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
		function clearproductstatistics() {
			//Create SQL Query
			$sql = sprintf("UPDATE ec_product SET ec_product.views = 0");

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
		
		function insertregcode($regcode) {
			//Create SQL Query
			$sql = sprintf("UPDATE ec_setting SET ec_setting.reg_code='%s'  WHERE ec_setting.setting_id = 1",
			mysql_real_escape_string($regcode));
			
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