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


class ec_admin_subscriptions
	{		
	
		function ec_admin_subscriptions() {
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
		   if ($methodName == 'getsubscriptions') return array('admin');
		   else if($methodName == 'deletesubscription') return array('admin');
		   else if($methodName == 'updatesubscription') return array('admin');
		   else if($methodName == 'insertsubscription') return array('admin');
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
		

		
		//subscription functions
		function getsubscriptions($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_subscription.*, UNIX_TIMESTAMP(ec_subscription.start_date) AS start_date, UNIX_TIMESTAMP(ec_subscription.last_payment_date) AS last_payment_date, UNIX_TIMESTAMP(ec_subscription.next_payment_date) AS next_payment_date FROM ec_subscription WHERE ec_subscription.subscription_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);
			  
			 // return mysql_num_rows($query);
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
		
		function deletesubscription($subscriptionid) {
			  //Create SQL Query	
			$ec_subscription = $this->escape("DELETE FROM ec_subscription WHERE ec_subscription.subscription_id = '%s'", $subscriptionid);
			//Run query on database;
			mysql_query($ec_subscription);
			
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
		function updatesubscription($subscriptionid, $subscription) {
			 //convert object to array
			  $subscription = (array)$subscription;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_subscription(ec_subscription.subscription_id, ec_subscription.subscription_type, ec_subscription.title, ec_subscription.model_number, ec_subscription.price, ec_subscription.payment_length, ec_subscription.payment_period, ec_subscription.start_date, ec_subscription.last_payment_date, ec_subscription.next_payment_date, ec_subscription.email, ec_subscription.first_name, ec_subscription.last_name, ec_subscription.user_country, ec_subscription.number_payments_completed, ec_subscription.paypal_txn_id, ec_subscription.paypal_txn_type, ec_subscription.paypal_subscr_id, ec_subscription.paypal_username, ec_subscription.paypal_password)
				values('".$subscriptionid."', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($subscription['subscription_type']),
				mysql_real_escape_string($subscription['title']),
				mysql_real_escape_string($subscription['model_number']),
				mysql_real_escape_string($subscription['price']),
				mysql_real_escape_string($subscription['payment_length']),
				mysql_real_escape_string($subscription['payment_period']),
				mysql_real_escape_string($subscription['start_date']),
				mysql_real_escape_string($subscription['last_payment_date']),
				mysql_real_escape_string($subscription['next_payment_date']),
				mysql_real_escape_string($subscription['email']),
				mysql_real_escape_string($subscription['first_name']),
				mysql_real_escape_string($subscription['last_name']),
				mysql_real_escape_string($subscription['user_country']),
				mysql_real_escape_string($subscription['number_payments_completed']),
				mysql_real_escape_string($subscription['paypal_txn_id']),
				mysql_real_escape_string($subscription['paypal_txn_type']),
				mysql_real_escape_string($subscription['paypal_subscr_id']),
				mysql_real_escape_string($subscription['paypal_username']),
				mysql_real_escape_string($subscription['paypal_password']));
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
		function insertsubscription($subscription) {
			  //convert object to array
			  $subscription = (array)$subscription;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_subscription(ec_subscription.subscription_id, ec_subscription.subscription_type, ec_subscription.title, ec_subscription.model_number, ec_subscription.price, ec_subscription.payment_length, ec_subscription.payment_period, ec_subscription.start_date, ec_subscription.last_payment_date, ec_subscription.next_payment_date, ec_subscription.email, ec_subscription.first_name, ec_subscription.last_name, ec_subscription.user_country, ec_subscription.number_payments_completed, ec_subscription.paypal_txn_id, ec_subscription.paypal_txn_type, ec_subscription.paypal_subscr_id, ec_subscription.paypal_username, ec_subscription.paypal_password)
				values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($subscription['subscription_id']),
				mysql_real_escape_string($subscription['subscription_type']),
				mysql_real_escape_string($subscription['title']),
				mysql_real_escape_string($subscription['model_number']),
				mysql_real_escape_string($subscription['price']),
				mysql_real_escape_string($subscription['payment_length']),
				mysql_real_escape_string($subscription['payment_period']),
				mysql_real_escape_string($subscription['start_date']),
				mysql_real_escape_string($subscription['last_payment_date']),
				mysql_real_escape_string($subscription['next_payment_date']),
				mysql_real_escape_string($subscription['email']),
				mysql_real_escape_string($subscription['first_name']),
				mysql_real_escape_string($subscription['last_name']),
				mysql_real_escape_string($subscription['user_country']),
				mysql_real_escape_string($subscription['number_payments_completed']),
				mysql_real_escape_string($subscription['paypal_txn_id']),
				mysql_real_escape_string($subscription['paypal_txn_type']),
				mysql_real_escape_string($subscription['paypal_subscr_id']),
				mysql_real_escape_string($subscription['paypal_username']),
				mysql_real_escape_string($subscription['paypal_password']));
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

	}//close class
?>