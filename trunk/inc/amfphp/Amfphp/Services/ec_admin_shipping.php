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


class ec_admin_shipping
	{		
	
		function ec_admin_shipping() {
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
		   if($methodName == 'getshippingsettings') return array('admin');
		   else if($methodName == 'updateshippingmethodsetting') return array('admin');
		   else if($methodName == 'updateshippingsettings') return array('admin');
		   else if($methodName == 'getups') return array('admin');
		   else if($methodName == 'deleteups') return array('admin');
		   else if($methodName == 'updateups') return array('admin');
		   else if($methodName == 'addups') return array('admin');
		   else if($methodName == 'getusps') return array('admin');
		   else if($methodName == 'deleteusps') return array('admin');
		   else if($methodName == 'updateusps') return array('admin');
		   else if($methodName == 'addusps') return array('admin');
		   else if($methodName == 'getfedex') return array('admin');
		   else if($methodName == 'deletefedex') return array('admin');
		   else if($methodName == 'updatefedex') return array('admin');
		   else if($methodName == 'addfedex') return array('admin');
		   else if($methodName == 'getauspost') return array('admin');
		   else if($methodName == 'deleteauspost') return array('admin');
		   else if($methodName == 'updateauspost') return array('admin');
		   else if($methodName == 'addauspost') return array('admin');
		   else if($methodName == 'updateexpeditedrates') return array('admin');
		   else if($methodName == 'getmethodshippingrates') return array('admin');
		   else if($methodName == 'deleteshippingmethodrate') return array('admin');
		   else if($methodName == 'updateshippingmethodrate') return array('admin');
		   else if($methodName == 'addshippingmethodrate') return array('admin');
		   else if($methodName == 'getweightshippingrates') return array('admin');
		   else if($methodName == 'deleteshippingweightrate') return array('admin');
		   else if($methodName == 'updateshippingweightrate') return array('admin');
		   else if($methodName == 'addshippingweightrate') return array('admin');
		   else if($methodName == 'getpriceshippingrates') return array('admin');
		   else if($methodName == 'deleteshippingpricerate') return array('admin');
		   else if($methodName == 'updateshippingpricerate') return array('admin');
		   else if($methodName == 'addshippingpricerate') return array('admin');
		   else if($methodName == 'getzonedetails') return array('admin');
		   else if($methodName == 'deletezonedetails') return array('admin');
		   else if($methodName == 'insertzonedetails') return array('admin');
		   else if($methodName == 'getshippingzones') return array('admin');
		   else if($methodName == 'deleteshippingzone') return array('admin');
		   else if($methodName == 'insertshippingzone') return array('admin');
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
		
		/////////////////////////////////////////////////////////////////////////////////
		//Shipping Zones 
		/////////////////////////////////////////////////////////////////////////////////
		
		function getzonedetails($zone_id) {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_zone_to_location.*, ec_country.*, ec_state.*
									FROM
									  ec_zone_to_location
									  LEFT JOIN ec_country ON (ec_zone_to_location.iso2_cnt = ec_country.iso2_cnt)
									  LEFT JOIN ec_state ON (ec_zone_to_location.code_sta = ec_state.code_sta)
									WHERE
									  ec_zone_to_location.zone_id = '".$zone_id."' ORDER BY ec_country.name_cnt ASC");
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
		
		function deletezonedetails($keyfield, $zone_id) {
			//convert object to array
			  //$keyfield = (array)$keyfield;
			  //$zone_id = (array)$zone_id;
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_zone_to_location WHERE ec_zone_to_location.zone_to_location_id = '".$keyfield."'");
			  //Run query on database;
			  mysql_query($deletesql);
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  //Create SQL Query
				  $sql = $this->escape("SELECT ec_zone_to_location.*, ec_country.*, ec_state.*
									FROM
									  ec_zone_to_location
									  LEFT JOIN ec_country ON (ec_zone_to_location.iso2_cnt = ec_country.iso2_cnt)
									  LEFT JOIN ec_state ON (ec_zone_to_location.code_sta = ec_state.code_sta)
									WHERE
									  ec_zone_to_location.zone_id = '".$zone_id."' ORDER BY ec_country.name_cnt ASC");
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
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}

		function insertzonedetails($zone_id, $zonecountry, $zonestate) {
			
			$sql = sprintf("Insert into ec_zone_to_location(ec_zone_to_location.zone_to_location_id, ec_zone_to_location.zone_id, ec_zone_to_location.iso2_cnt, ec_zone_to_location.code_sta)
					values(null, '%s', '%s', '%s')",
					mysql_real_escape_string($zone_id),
					mysql_real_escape_string($zonecountry),
					mysql_real_escape_string($zonestate));

			//Run query on database;
			mysql_query($sql);
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				//Create SQL Query
			  $sql = $this->escape("SELECT ec_zone_to_location.*, ec_country.*, ec_state.*
									FROM
									  ec_zone_to_location
									  LEFT JOIN ec_country ON (ec_zone_to_location.iso2_cnt = ec_country.iso2_cnt)
									  LEFT JOIN ec_state ON (ec_zone_to_location.code_sta = ec_state.code_sta)
									WHERE
									  ec_zone_to_location.zone_id = '".$zone_id."' ORDER BY ec_country.name_cnt ASC");
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
			} else {
				$returnArray[] ="error";
				return($returnArray); //return array results if there are some
			}
		}
		
		
		
		
		
		function getshippingzones() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_zone.* FROM ec_zone ORDER BY ec_zone.zone_id ASC");
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
		
		function deleteshippingzone($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_zone WHERE ec_zone.zone_id = '%s'", $keyfield);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			  $deletesql = $this->escape("DELETE FROM ec_zone_to_location WHERE ec_zone_to_location.zone_id = '".$keyfield."'");
			  //Run query on database;
			  mysql_query($deletesql);
			  
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}

		function insertshippingzone($zonename) {
			
			$sql = sprintf("Insert into ec_zone(ec_zone.zone_id, ec_zone.zone_name)
					values(null, '%s')",
					mysql_real_escape_string($zonename));

			//Run query on database;
			mysql_query($sql);
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] ="error";
				return($returnArray); //return array results if there are some
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		

		/////////////////////////////////////////////////////////////////////////////////
		//Shipping Settings
		/////////////////////////////////////////////////////////////////////////////////
		
		
		function getshippingsettings() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_setting.shipping_method, ec_setting.shipping_expedite_rate, ec_setting.shipping_handling_rate, ec_setting.ups_access_license_number, ec_setting.ups_user_id, ec_setting.ups_password, ec_setting.ups_ship_from_zip, ec_setting.ups_shipper_number, ec_setting.ups_country_code, ec_setting.ups_weight_type, ec_setting.usps_user_name, ec_setting.usps_ship_from_zip, ec_setting.fedex_key, ec_setting.fedex_account_number, ec_setting.fedex_meter_number, ec_setting.fedex_password, ec_setting.fedex_ship_from_zip, ec_setting.fedex_weight_units, ec_setting.fedex_country_code, ec_setting.auspost_api_key, ec_setting.auspost_ship_from_zip FROM ec_setting  WHERE ec_setting.setting_id = 1");
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
		
		function updateshippingmethodsetting($shippingmethod) {
			
			  //Create SQL Query
			  $sql = sprintf("UPDATE ec_setting SET ec_setting.shipping_method='%s' WHERE ec_setting.setting_id = 1", 
			 mysql_real_escape_string($shippingmethod));
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
					return $returnArray; //return noresults if th ere are no results
				}
			}
		}	 
		
		
		function updateshippingsettings($shippingsettings) {
				//convert object to array
			  $shippingsettings = (array)$shippingsettings;
			  //Create SQL Query
			  $sql = sprintf("UPDATE ec_setting SET ec_setting.shipping_method='%s',  ec_setting.ups_access_license_number='%s', ec_setting.ups_user_id='%s', ec_setting.ups_password='%s', ec_setting.ups_ship_from_zip='%s', ec_setting.ups_shipper_number='%s', ec_setting.ups_country_code='%s', ec_setting.ups_weight_type='%s', ec_setting.usps_user_name='%s', ec_setting.usps_ship_from_zip='%s', ec_setting.fedex_key='%s', ec_setting.fedex_account_number='%s', ec_setting.fedex_meter_number='%s', ec_setting.fedex_password='%s', ec_setting.fedex_ship_from_zip='%s', ec_setting.fedex_weight_units='%s', ec_setting.fedex_country_code='%s', ec_setting.auspost_api_key = '%s', ec_setting.auspost_ship_from_zip = '%s' WHERE ec_setting.setting_id = 1", 
			 mysql_real_escape_string($shippingsettings['shippingmethod']), 
			 mysql_real_escape_string($shippingsettings['ups_access_license_number']), 
			 mysql_real_escape_string($shippingsettings['ups_user_id']),  
			 mysql_real_escape_string($shippingsettings['ups_password']), 
			 mysql_real_escape_string($shippingsettings['ups_ship_from_zip']), 
			 mysql_real_escape_string($shippingsettings['ups_shipper_number']), 
			 mysql_real_escape_string($shippingsettings['ups_country_code']), 
			 mysql_real_escape_string($shippingsettings['ups_weight_type']),
			 mysql_real_escape_string($shippingsettings['usps_user_name']), 
			 mysql_real_escape_string($shippingsettings['usps_ship_from_zip']),
			 mysql_real_escape_string($shippingsettings['fedex_key']), 
			 mysql_real_escape_string($shippingsettings['fedex_account_number']), 
			 mysql_real_escape_string($shippingsettings['fedex_meter_number']), 
			 mysql_real_escape_string($shippingsettings['fedex_password']), 
			 mysql_real_escape_string($shippingsettings['fedex_ship_from_zip']),
			 mysql_real_escape_string($shippingsettings['fedex_weight_units']), 
			 mysql_real_escape_string($shippingsettings['fedex_country_code']),
			 mysql_real_escape_string($shippingsettings['auspost_api_key']), 
			 mysql_real_escape_string($shippingsettings['auspost_ship_from_zip']));
			//Run query on database;
			  mysql_query($sql);
			  return mysql_error();
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
		
		/////////////////////////////////////////////////////////////////////////////////
		//AUS POST BASED SHIPPING
		/////////////////////////////////////////////////////////////////////////////////
		
		function getauspost() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_shippingrate.* FROM ec_shippingrate WHERE ec_shippingrate.is_auspost_based = 1 ORDER BY ec_shippingrate.shipping_order ASC");
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
		
		function deleteauspost($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_shippingrate WHERE ec_shippingrate.shippingrate_id = '%s'", $keyfield);
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
		function updateauspost($keyfield, $info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_auspost_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s', '%s','%s', '%s', 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code,  ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_auspost_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s', '%s', '%s', null, 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));
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
		function addauspost($info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
				  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_auspost_based, ec_shippingrate.zone_id)
					values(null, '%s', '%s','%s','%s', 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_auspost_based, ec_shippingrate.zone_id)
					values(null, '%s', '%s', '%s', null, 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));
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
					$returnArray[] = mysql_error();
					return $returnArray; //return noresults if there are no results
				}
			}
		}
		/////////////////////////////////////////////////////////////////////////////////
		//UPS BASED SHIPPING
		/////////////////////////////////////////////////////////////////////////////////
		
		function getups() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_shippingrate.* FROM ec_shippingrate WHERE ec_shippingrate.is_ups_based = 1 ORDER BY ec_shippingrate.shipping_order ASC");
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
		
		function deleteups($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_shippingrate WHERE ec_shippingrate.shippingrate_id = '%s'", $keyfield);
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
		function updateups($keyfield, $info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_ups_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s', '%s','%s', '%s', 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code,  ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_ups_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s', '%s', '%s', null, 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));
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
		function addups($info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
				  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_ups_based, ec_shippingrate.zone_id)
					values(null, '%s', '%s','%s','%s', 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_ups_based, ec_shippingrate.zone_id)
					values(null, '%s', '%s', '%s', null, 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));
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
					$returnArray[] = mysql_error();
					return $returnArray; //return noresults if there are no results
				}
			}
		}
		
		/////////////////////////////////////////////////////////////////////////////////
		//USPS BASED SHIPPING 
		/////////////////////////////////////////////////////////////////////////////////
		
		function getusps() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_shippingrate.* FROM ec_shippingrate WHERE ec_shippingrate.is_usps_based = 1 ORDER BY ec_shippingrate.shipping_order ASC");
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
		
		function deleteusps($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_shippingrate WHERE ec_shippingrate.shippingrate_id = '%s'", $keyfield);
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
		function updateusps($keyfield, $info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code,  ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_usps_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s', '%s','%s','%s', 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_usps_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s','%s', '%s', null, 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));
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
		function addusps($info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
					$sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_usps_based, ec_shippingrate.zone_id)
					values(null, '%s', '%s','%s','%s', 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_usps_based, ec_shippingrate.zone_id)
					values(null, '%s', '%s', '%s', null, 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));
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
					$returnArray[] = mysql_error();
					return $returnArray; //return noresults if there are no results
				}
			}
		}	
		
		/////////////////////////////////////////////////////////////////////////////////
		//FedEx BASED SHIPPING
		/////////////////////////////////////////////////////////////////////////////////
		
		function getfedex() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_shippingrate.* FROM ec_shippingrate WHERE ec_shippingrate.is_fedex_based = 1 ORDER BY ec_shippingrate.shipping_order ASC");
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
		
		function deletefedex($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_shippingrate WHERE ec_shippingrate.shippingrate_id = '%s'", $keyfield);
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
		function updatefedex($keyfield, $info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order,ec_shippingrate.shipping_override_rate, ec_shippingrate.is_fedex_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s', '%s', '%s','%s', 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_fedex_based, ec_shippingrate.zone_id)
					values('".$keyfield."', '%s', '%s',  '%s', null, 1, '%s')",
					mysql_real_escape_string($info['shippinglabel']),
					mysql_real_escape_string($info['shippingcode']),
					mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));
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
		function addfedex($info) {
			//convert object to array
			  $info = (array)$info;
			  
			  //Create SQL Query
			  if($info['shippingoverride'] != '') {
			 	 $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code,  ec_shippingrate.shipping_order,ec_shippingrate.shipping_override_rate, ec_shippingrate.is_fedex_based, ec_shippingrate.zone_id)
				values(null, '%s', '%s','%s', '%s', 1, '%s')",
				mysql_real_escape_string($info['shippinglabel']),
				mysql_real_escape_string($info['shippingcode']),
				mysql_real_escape_string($info['shipping_order']),
				mysql_real_escape_string($info['shippingoverride']),
					mysql_real_escape_string($info['zoneid']));
			  } else {
				$sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.shipping_label, ec_shippingrate.shipping_code, ec_shippingrate.shipping_order, ec_shippingrate.shipping_override_rate, ec_shippingrate.is_fedex_based, ec_shippingrate.zone_id)
				values(null, '%s','%s', '%s', null, 1, '%s')",
				mysql_real_escape_string($info['shippinglabel']),
				mysql_real_escape_string($info['shippingcode']),
				mysql_real_escape_string($info['shipping_order']),
					mysql_real_escape_string($info['zoneid']));  
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
					$returnArray[] = mysql_error();
					return $returnArray; //return noresults if there are no results
				}
			}
		}							
	
		
		//shipping functions
		function updateexpeditedrates($rate) {
			  //Create SQL Query
			  $sql = sprintf("UPDATE ec_setting SET ec_setting.shipping_expedite_rate='%s' WHERE ec_setting.setting_id = 1", 
			 mysql_real_escape_string($rate));
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
		
	
	
			/////////////////////////////////////////////////////////////////////////////////
			//METHOD BASED SHIPPING
			/////////////////////////////////////////////////////////////////////////////////
	
			function getmethodshippingrates() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_shippingrate.* FROM ec_shippingrate WHERE ec_shippingrate.is_method_based = 1 ORDER BY ec_shippingrate.shipping_order ASC");
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
		function deleteshippingmethodrate($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_shippingrate WHERE ec_shippingrate.shippingrate_id = '%s'", $keyfield);
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
		function updateshippingmethodrate($keyfield, $rate) {
			//convert object to array
			  $rate = (array)$rate;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id,  ec_shippingrate.shipping_rate, ec_shippingrate.shipping_label, ec_shippingrate.shipping_order,  ec_shippingrate.is_method_based, ec_shippingrate.zone_id)
				values('".$keyfield."', '%s', '%s', '%s', 1, '%s')",
				mysql_real_escape_string($rate['shippingrate']),
				mysql_real_escape_string($rate['shippinglabel']),
				mysql_real_escape_string($rate['shippingorder']),
					mysql_real_escape_string($rate['zoneid']));
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
		function addshippingmethodrate($rate) {
			//convert object to array
			  $rate = (array)$rate;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id,  ec_shippingrate.shipping_rate, ec_shippingrate.shipping_label, ec_shippingrate.shipping_order,  ec_shippingrate.is_method_based, ec_shippingrate.zone_id)
				values(null, '%s', '%s', '%s', 1, '%s')",
				mysql_real_escape_string($rate['shippingrate']),
				mysql_real_escape_string($rate['shippinglabel']),
				mysql_real_escape_string($rate['shippingorder']),
					mysql_real_escape_string($rate['zoneid']));
			//Run query on database;
			  mysql_query($sql);
			  //if no errors, return their  current Client ID
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
					$returnArray[] = mysql_error();
					return $returnArray; //return noresults if there are no results
				}
			}
		}
	
	
	
	
	
	  	/////////////////////////////////////////////////////////////////////////////////
		//WEIGHT BASED SHIPPING
		/////////////////////////////////////////////////////////////////////////////////
	
		
		function getweightshippingrates() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_shippingrate.* FROM ec_shippingrate WHERE ec_shippingrate.is_weight_based = 1 ORDER BY ec_shippingrate.trigger_rate ASC");
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
		function deleteshippingweightrate($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_shippingrate WHERE ec_shippingrate.shippingrate_id = '%s'", $keyfield);
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
		function updateshippingweightrate($keyfield, $rate) {
			//convert object to array
			  $rate = (array)$rate;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.trigger_rate, ec_shippingrate.shipping_rate, ec_shippingrate.is_weight_based, ec_shippingrate.zone_id)
				values('".$keyfield."', '%s', '%s', 1, '%s')",
				mysql_real_escape_string($rate['triggerrate']),
				mysql_real_escape_string($rate['shippingrate']),
					mysql_real_escape_string($rate['zoneid']));
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
		function addshippingweightrate($rate) {
			//convert object to array
			  $rate = (array)$rate;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.trigger_rate, ec_shippingrate.shipping_rate, ec_shippingrate.is_weight_based, ec_shippingrate.zone_id)
				values(null, '%s', '%s', 1, '%s')",
				mysql_real_escape_string($rate['triggerrate']),
				mysql_real_escape_string($rate['shippingrate']),
					mysql_real_escape_string($rate['zoneid']));
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
					$returnArray[] = mysql_error();
					return $returnArray; //return noresults if there are no results
				}
			}
		}
		
		
		
		
		
		/////////////////////////////////////////////////////////////////////////////////
		//PRICE BASED SHIPPING
		/////////////////////////////////////////////////////////////////////////////////
		
		function getpriceshippingrates() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_shippingrate.* FROM ec_shippingrate WHERE ec_shippingrate.is_price_based = 1 ORDER BY ec_shippingrate.trigger_rate ASC");
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
		
		function deleteshippingpricerate($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_shippingrate WHERE ec_shippingrate.shippingrate_id = '%s'", $keyfield);
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
		function updateshippingpricerate($keyfield, $rate) {
			//convert object to array
			  $rate = (array)$rate;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.trigger_rate, ec_shippingrate.shipping_rate, ec_shippingrate.is_price_based, ec_shippingrate.zone_id)
				values('".$keyfield."', '%s', '%s', 1, '%s')",
				mysql_real_escape_string($rate['triggerrate']),
				mysql_real_escape_string($rate['shippingrate']),
					mysql_real_escape_string($rate['zoneid']));
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
		function addshippingpricerate($rate) {
			//convert object to array
			  $rate = (array)$rate;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_shippingrate(ec_shippingrate.shippingrate_id, ec_shippingrate.trigger_rate, ec_shippingrate.shipping_rate, ec_shippingrate.is_price_based, ec_shippingrate.zone_id)
				values(null, '%s', '%s', 1, '%s')",
				mysql_real_escape_string($rate['triggerrate']),
				mysql_real_escape_string($rate['shippingrate']),
					mysql_real_escape_string($rate['zoneid']));
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
					$returnArray[] = mysql_error();
					return $returnArray; //return noresults if there are no results
				}
			}
		}
		
		
			
		


	}//close class
?>