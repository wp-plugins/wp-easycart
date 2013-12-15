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


class ec_admin_users
	{		
	
		function ec_admin_users() {
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
		   if ($methodName == 'getclients') return array('admin');
		   else if($methodName == 'deleteclient') return array('admin');
		   else if($methodName == 'updateclient') return array('admin');
		   else if($methodName == 'addclient') return array('admin');
		   else if($methodName == 'getuserroles') return array('admin');
		   else if($methodName == 'deleteuserrole') return array('admin');
		   else if($methodName == 'adduserrole') return array('admin');
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
		


		//client account functions
		function getclients($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_user.* FROM ec_user WHERE ec_user.user_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);

			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($query) > 0) {
				  while ($row=mysql_fetch_object($query)) {
					  //get the shipping and billing address id's
					  $billing_address_id = $row->default_billing_address_id;
				  	  $shipping_address_id = $row->default_shipping_address_id;

					  //query for the billing address
					  if($billing_address_id != 0) {
						  $billingquery = mysql_query("SELECT 
										  ec_address.first_name AS billing_first_name,
										  ec_address.last_name AS billing_last_name,
										  ec_address.address_line_1 AS billing_address_line_1,
										  ec_address.address_line_2 AS billing_address_line_2,
										  ec_address.city AS billing_city,
										  ec_address.state AS billing_state,
										  ec_address.zip AS billing_zip,
										  ec_address.country AS billing_country,
										  ec_address.phone AS billing_phone
										  FROM ec_address  WHERE ec_address.address_id = '$billing_address_id'");
						  //set the billing address to the first query
						  while ($billing_row = mysql_fetch_object($billingquery)) {
							$row->billing_first_name = $billing_row->billing_first_name;
							$row->billing_last_name = $billing_row->billing_last_name;
							$row->billing_address_line_1 = $billing_row->billing_address_line_1;
							$row->billing_address_line_2 = $billing_row->billing_address_line_2;
							$row->billing_city = $billing_row->billing_city;
							$row->billing_state = $billing_row->billing_state;
							$row->billing_zip = $billing_row->billing_zip;
							$row->billing_country = $billing_row->billing_country;
							$row->billing_phone = $billing_row->billing_phone;
						  }
					  }
					  //query for the shipping address
					  if ($shipping_address_id != 0) {
						  $shippingquery = mysql_query("SELECT 
										  ec_address.first_name AS shipping_first_name,
										  ec_address.last_name AS shipping_last_name,
										  ec_address.address_line_1 AS shipping_address_line_1,
										  ec_address.address_line_2 AS shipping_address_line_2,
										  ec_address.city AS shipping_city,
										  ec_address.state AS shipping_state,
										  ec_address.zip AS shipping_zip,
										  ec_address.country AS shipping_country,
										  ec_address.phone AS shipping_phone
										  FROM ec_address  WHERE ec_address.address_id = '$shipping_address_id'");
						  //set the shipping address to the first query
						  while ($shipping_row = mysql_fetch_object($shippingquery)) {
							$row->shipping_first_name = $shipping_row->shipping_first_name;
							$row->shipping_last_name = $shipping_row->shipping_last_name;
							$row->shipping_address_line_1 = $shipping_row->shipping_address_line_1;
							$row->shipping_address_line_2 = $shipping_row->shipping_address_line_2;
							$row->shipping_city = $shipping_row->shipping_city;
							$row->shipping_state = $shipping_row->shipping_state;
							$row->shipping_zip = $shipping_row->shipping_zip;
							$row->shipping_country = $shipping_row->shipping_country;
							$row->shipping_phone = $shipping_row->shipping_phone;
						  }
					  }
					  
					  //attach the total rows to the first query
					  $row->totalrows=$totalrows;
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		function deleteclient($clientid) {
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_user.* FROM ec_user WHERE ec_user.user_level = 'admin' AND ec_user.user_id != '".$clientid."'");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_array($totalquery);
			  
			  //return $totalrows;
			  //Create SQL Query	
			  if ($totalrows[0] >= '1') {
				  
				  $deletesql = $this->escape("DELETE FROM ec_address WHERE ec_address.user_id = '%s'", $clientid);
				  //Run query on database;
				  mysql_query($deletesql);
				  
				  //Create SQL Query	
				  $deletesql = $this->escape("DELETE FROM ec_user WHERE ec_user.user_id = '%s'", $clientid);
				  //Run query on database;
				  mysql_query($deletesql);
				  
				  //if no errors, return their current Client ID
				  //if results, convert to an array for use in flash
				  if(!mysql_error()) {
					  $returnArray[] = "success";
					  return($returnArray); //return array results if there are some
				  } else {
					  $returnArray[] = "error";
					  return $returnArray; //return noresults if there are no results
				  }
			  } else {
				  $returnArray[] = "noadminerror";
				  return $returnArray; //return noresults if there ares no result
			  }
		}
		function updateclient($clientid, $client) {
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_user.* FROM ec_user WHERE ec_user.user_level = 'admin'");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_array($totalquery);
			  
			  //convert object to array
			  $client = (array)$client;
			  
			  $matchlastadmin = false;
			  while ($row = mysql_fetch_assoc($query)) {
				  if ($totalrows[0] == 1 && $clientid == $row[user_id]) {
					  $matchlastadmin = true;
				  }
			  }
			  //need to determine if the one last user ID is this users ID
			  ////////////////////////////////////////////////////////////
			  if ($matchlastadmin == true && $client['userlevel'] != 'admin') {
				  $returnArray[] = "noadminerror";
				  return $returnArray; //return noresults if there ares no result
			  } else {
				  
				  $sql = sprintf("Replace into ec_address(ec_address.address_id, ec_address.user_id, ec_address.first_name, ec_address.last_name, ec_address.address_line_1, ec_address.address_line_2, ec_address.city, ec_address.state, ec_address.zip, ec_address.country, ec_address.phone)
					values('%s', '".$clientid."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s')",
				  mysql_real_escape_string($client['billing_id']),
				  mysql_real_escape_string($client['billname']),
				  mysql_real_escape_string($client['billlastname']),
				  mysql_real_escape_string($client['billaddress']),
				  mysql_real_escape_string($client['billaddress2']),
				  mysql_real_escape_string($client['billcity']),
				  mysql_real_escape_string($client['billstate']),
				  mysql_real_escape_string($client['billzip']),
				  mysql_real_escape_string($client['billcountry']),
				  mysql_real_escape_string($client['billphone']));
				  //Run query on database;
				  mysql_query($sql);
				  
				  $default_billing_address_id = $client['billing_id'];
					
				  $sql = sprintf("Replace into ec_address(ec_address.address_id, ec_address.user_id, ec_address.first_name, ec_address.last_name, ec_address.address_line_1, ec_address.address_line_2, ec_address.city, ec_address.state, ec_address.zip, ec_address.country, ec_address.phone)
					values('%s', '".$clientid."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s')",	
				  mysql_real_escape_string($client['shipping_id']),
				  mysql_real_escape_string($client['shipname']),
				  mysql_real_escape_string($client['shiplastname']),
				  mysql_real_escape_string($client['shipaddress']),
				  mysql_real_escape_string($client['shipaddress2']),
				  mysql_real_escape_string($client['shipcity']),
				  mysql_real_escape_string($client['shipstate']),
				  mysql_real_escape_string($client['shipzip']),
				  mysql_real_escape_string($client['shipcountry']),
				  mysql_real_escape_string($client['shipphone']));
				  //Run query on database;
				  mysql_query($sql);
				  $default_shipping_address_id = $client['shipping_id'];
					
					
				  //Create SQL Query
				  $sql = sprintf("UPDATE ec_user SET ec_user.email = '%s', ec_user.password = '%s', ec_user.first_name = '%s', ec_user.last_name = '%s', ec_user.default_billing_address_id = %d, ec_user.default_shipping_address_id = %d, ec_user.user_level = '%s', ec_user.is_subscriber = %d WHERE ec_user.user_id = %d",
					mysql_real_escape_string($client['email']),
					mysql_real_escape_string($client['password']),
					mysql_real_escape_string($client['firstname']),
					mysql_real_escape_string($client['lastname']),
					mysql_real_escape_string($default_billing_address_id),
					mysql_real_escape_string($default_shipping_address_id),
					mysql_real_escape_string($client['userlevel']),
					mysql_real_escape_string($client['subscriber']),
					mysql_real_escape_string($clientid));
					
					//Run query on database;
					mysql_query($sql);
					//return $sql;
					
					
				//Enqueue Quickbooks Update Customer
				if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
					$quickbooks = new ec_quickbooks( );
					$quickbooks->update_user_admin( $clientid );	
				}				
	
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
		}
		
		
		function addclient($client) {
			  //convert object to array 
			  $client = (array)$client;
			 
			  //Create SQL Query 
			  $sql = sprintf("INSERT into ec_user(ec_user.user_id, ec_user.email, ec_user.password, ec_user.first_name, ec_user.last_name, ec_user.default_billing_address_id, ec_user.default_shipping_address_id, ec_user.user_level, ec_user.is_subscriber)
				values(Null, '%s', '%s', '%s',  '%s', '0', '0', '%s', '%s')",
			  mysql_real_escape_string($client['email']),
			  mysql_real_escape_string($client['password']),
			  mysql_real_escape_string($client['firstname']),
			  mysql_real_escape_string($client['lastname']),
			  mysql_real_escape_string($client['userlevel']),
			  mysql_real_escape_string($client['subscriber']));
			  //Run query on database;
			  mysql_query($sql);
			  $user_id = mysql_insert_id();
				
			 //add billing address
			 $billingsql = sprintf("INSERT into ec_address(ec_address.address_id, ec_address.user_id, ec_address.first_name, ec_address.last_name, ec_address.address_line_1, ec_address.address_line_2, ec_address.city, ec_address.state, ec_address.zip, ec_address.country, ec_address.phone)
				values(Null, '".$user_id."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s')",
			  mysql_real_escape_string($client['billname']),
			  mysql_real_escape_string($client['billlastname']),
			  mysql_real_escape_string($client['billaddress']),
			  mysql_real_escape_string($client['billaddress2']),
			  mysql_real_escape_string($client['billcity']),
			  mysql_real_escape_string($client['billstate']),
			  mysql_real_escape_string($client['billzip']),
			  mysql_real_escape_string($client['billcountry']),
			  mysql_real_escape_string($client['billphone']));
			  //Run query on database;
			  mysql_query($billingsql);
			  $default_billing_address_id = mysql_insert_id();
				
			  //add shipping address
			  $shippingsql = sprintf("INSERT into ec_address(ec_address.address_id, ec_address.user_id, ec_address.first_name, ec_address.last_name, ec_address.address_line_1, ec_address.address_line_2, ec_address.city, ec_address.state, ec_address.zip, ec_address.country, ec_address.phone)
				values(Null, '".$user_id."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s')",	
			  mysql_real_escape_string($client['shipname']),
			  mysql_real_escape_string($client['shiplastname']),
			  mysql_real_escape_string($client['shipaddress']),
			  mysql_real_escape_string($client['shipaddress2']),
			  mysql_real_escape_string($client['shipcity']),
			  mysql_real_escape_string($client['shipstate']),
			  mysql_real_escape_string($client['shipzip']),
			  mysql_real_escape_string($client['shipcountry']),
			  mysql_real_escape_string($client['shipphone']));
			  //Run query on database;
			  mysql_query($shippingsql);
			 $default_shipping_address_id = mysql_insert_id();
			 
			 //now update the ec_users with the new address ID's
			 $sql = $this->escape("UPDATE ec_user SET ec_user.default_billing_address_id='%s', ec_user.default_shipping_address_id='%s'  WHERE ec_user.user_id = '%s'", $default_billing_address_id, $default_shipping_address_id, $user_id);

			 //Run query on database;
			 mysql_query($sql);
			 
			 
			 //Enqueue Quickbooks Add Customer
			if( file_exists( "../../../../wp-easycart-quickbooks/QuickBooks.php" ) ){
				$quickbooks = new ec_quickbooks( );
				$quickbooks->add_user( $user_id );
			}
			  
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
		
		
		
		
		//user roles
		function getuserroles() {
			//Create SQL Query
			$sql = sprintf("SELECT ec_role.* FROM ec_role ORDER BY ec_role.role_id ASC");
			
			$result = mysql_query($sql);
			  //if results, convert to an array for use in flash
			  if($result) {
				  while ($row=mysql_fetch_object($result)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function deleteuserrole($role_id) {
			//Create SQL Query
			$sql = $this->escape("DELETE FROM ec_role WHERE ec_role.role_id = %s", $role_id);
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] = "success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function adduserrole($role_label, $admin_access) {
			
			$adminok = 0; //default
			if($admin_access == true) $adminok = 1;
			if($admin_access == false) $adminok = 0;
			
			//Create SQL Query
			$sql = sprintf("Insert into ec_role(ec_role.role_id, ec_role.role_label, ec_role.admin_access)
				values(null, '%s', '%s')",
				mysql_real_escape_string($role_label),
				mysql_real_escape_string($adminok));
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] = "success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}
		
		
		
		
		//user role prices
		function getuserroleprices($product_id) {
			//Create SQL Query
			$sql = sprintf("SELECT ec_roleprice.* FROM ec_roleprice WHERE ec_roleprice.product_id = '%s' ORDER BY ec_roleprice.role_label ASC", mysql_real_escape_string($product_id));
			
			$result = mysql_query($sql);
			  //if results, convert to an array for use in flash
			  if($result) {
				  while ($row=mysql_fetch_object($result)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function deleteuserroleprice($roleprice_id, $product_id) {
			//Create SQL Query
			$sql = $this->escape("DELETE FROM ec_roleprice WHERE ec_roleprice.roleprice_id = %s", $roleprice_id);
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] = $product_id;
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function adduserroleprice($product_id, $role_label, $price) {
			
			//Create SQL Query
			$sql = sprintf("Insert into ec_roleprice(ec_roleprice.roleprice_id, ec_roleprice.product_id, ec_roleprice.role_label, ec_roleprice.role_price)
				values(null, '%s', '%s', '%s')",
				mysql_real_escape_string($product_id),
				mysql_real_escape_string($role_label),
				mysql_real_escape_string($price));
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] = $product_id;
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}
		


	}//close class
?>