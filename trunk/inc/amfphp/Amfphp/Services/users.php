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


class users
	{		
	
		function users() {
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
			  //Create SQL Query	
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
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		function updateclient($clientid, $client) {
			  //convert object to array
			  $client = (array)$client;
			  
			  
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
			  $sql = sprintf("Replace into ec_user(ec_user.user_id, ec_user.email, ec_user.password, ec_user.first_name, ec_user.last_name, ec_user.default_billing_address_id, ec_user.default_shipping_address_id, ec_user.user_level, ec_user.is_subscriber)
				values('".$clientid."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($client['email']),
				mysql_real_escape_string($client['password']),
				mysql_real_escape_string($client['firstname']),
				mysql_real_escape_string($client['lastname']),
				mysql_real_escape_string($default_billing_address_id),
				mysql_real_escape_string($default_shipping_address_id),
				mysql_real_escape_string($client['userlevel']),
				mysql_real_escape_string($client['subscriber']));
				//Run query on database;
			    mysql_query($sql);
				//return $sql;
				
				
				

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
				values(Null, '".$clientid."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s')",
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
				values(Null, '".$clientid."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s')",	
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