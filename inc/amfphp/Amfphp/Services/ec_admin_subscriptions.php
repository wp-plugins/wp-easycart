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
		  if($methodName == 'cancelstripesubscription') return array('admin');
		  else if($methodName == 'updatestripesubscription') return array('admin');
		  else if($methodName == 'getsubscriptions') return array('admin');
		  else if($methodName == 'getsubscriptionplans') return array('admin');
		  else if($methodName == 'getcustomerpayments') return array('admin');
		  else if($methodName == 'getsubscriptionplanrecords') return array('admin');
		  else if($methodName == 'deletesubscriptionplanrecord') return array('admin');
		  else if($methodName == 'updatesubscriptionplanrecord') return array('admin');
		  else if($methodName == 'addsubscriptionplanrecord') return array('admin');
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
		


///////////////////////////////////////////////////////////////////////
//SUBSCRIPTIONS
//////////////////////////////////////////////////////////////////////	

		function getcustomerpayments($subscription_id, $user_id) {
			//Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_order.*, UNIX_TIMESTAMP(ec_order.order_date) AS order_date FROM ec_order WHERE ec_order.user_id = '".mysql_real_escape_string($user_id)."' AND ec_order.subscription_id = '".mysql_real_escape_string($subscription_id)."'");
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

		
		function getsubscriptions($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_subscription.*, ec_user.stripe_customer_id, ec_user.default_card_type, ec_user.default_card_last4, UNIX_TIMESTAMP(ec_subscription.start_date) AS start_date FROM ec_subscription LEFT JOIN ec_user ON ec_subscription.email = ec_user.email  WHERE ec_subscription.subscription_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		
		function cancelstripesubscription($user, $subscription_id) {
			
			//create an object for call to stripe
			$stripe_user = (object)array( "stripe_customer_id" => $user);
			
			$stripe = new ec_stripe;
			$response = $stripe->cancel_subscription( $stripe_user, $subscription_id);
			if($response != false) {
				  //Create SQL Query
				  $sql = sprintf("UPDATE ec_subscription SET ec_subscription.subscription_status = 'Canceled'  WHERE ec_subscription.stripe_subscription_id = '%s'",
				  mysql_real_escape_string($subscription_id));
				  mysql_query($sql);
				  
				  if (!mysql_error()) {
					  $returnArray[] = "success";
					  return($returnArray); //return array results if there are some
				  } else {
					$returnArray[] = "failed";
				  	return $returnArray; //return noresults if there are no results 
				  }
			  } else {
				  $returnArray[] = "failed";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		 
		
		
		function updatestripesubscription($user, $subscription_id, $product_id) {
			
			//create an object for call to stripe
			$stripe_user = (object)array( "stripe_customer_id" => $user);
			$stripe_product = (object)array( "product_id" => $product_id);
			
			
			$stripe = new ec_stripe;
			$response = $stripe->update_subscription( $stripe_product, $stripe_user, NULL ,$subscription_id);
			if($response != false) {
				  //get current subscription plan id
				  $currentplansql = mysql_query("SELECT ec_product.* FROM ec_product WHERE ec_product.product_id = '".$product_id."'");
				  $currentplanid = mysql_fetch_object($currentplansql);
				  

				  //Create SQL Query
				  $sql = sprintf("UPDATE ec_subscription SET ec_subscription.title = '%s', ec_subscription.product_id = '%s', ec_subscription.model_number = '%s', ec_subscription.price = '%s',  ec_subscription.payment_length = '%s', ec_subscription.payment_period = '%s' WHERE ec_subscription.stripe_subscription_id = '%s'",
				  mysql_real_escape_string($currentplanid->title),
				  mysql_real_escape_string($product_id),
				  mysql_real_escape_string($currentplanid->model_number),
				  mysql_real_escape_string($currentplanid->price),
				  mysql_real_escape_string($currentplanid->subscription_bill_length),
				  mysql_real_escape_string($currentplanid->subscription_bill_period),
				  mysql_real_escape_string($subscription_id));
				  mysql_query($sql);
				 
				  //now get the newest product request
				  $query= mysql_query("SELECT ec_subscription.*, ec_user.stripe_customer_id, ec_user.default_card_type, ec_user.default_card_last4, UNIX_TIMESTAMP(ec_subscription.start_date) AS start_date FROM ec_subscription LEFT JOIN ec_user ON ec_subscription.email = ec_user.email  WHERE ec_subscription.stripe_subscription_id = '".$subscription_id."'");
				 
				  
				  if (!mysql_error()) {
					  $row = mysql_fetch_object($query);
					  $returnArray[] = $row;
					  return($returnArray); //return array results if there are some
				  } else {
					$returnArray[] = "failed";
				  	return $returnArray; //return noresults if there are no results 
				  }
			  } else {
				  $returnArray[] = "failed";
				  return $returnArray; //return noresults if there are no results
			  }
	}
		
		
		


		
		
///////////////////////////////////////////////////////////////////////
//SUBSCRIPTION COMBO CALL
//////////////////////////////////////////////////////////////////////
		function getsubscriptionplans() {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_subscription_plan.* FROM ec_subscription_plan");

			  
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
		
		function getcommonplans($productid) {
			//get current subscription plan id
			$currentplansql = mysql_query("SELECT ec_product.subscription_plan_id FROM ec_product WHERE ec_product.product_id = '".$productid."'");
			
			//now get the related items with similar subscription plan ids
			$currentplanid = mysql_fetch_object($currentplansql);
			$query= mysql_query("SELECT ec_product.product_id, ec_product.title FROM ec_product WHERE ec_product.subscription_plan_id = '".$currentplanid->subscription_plan_id."'");
			
			if(mysql_num_rows($query) > 0) {
				  while ($row = mysql_fetch_object($query)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
			
		}
	
	
	
	
	
		
///////////////////////////////////////////////////////////////////////
//SUBSCRIPTION PLANS
//////////////////////////////////////////////////////////////////////
		function getsubscriptionplanrecords($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_subscription_plan.* FROM ec_subscription_plan  WHERE ec_subscription_plan.subscription_plan_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		
		
		function deletesubscriptionplanrecord($subscriptionid) {
			
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_subscription_plan WHERE ec_subscription_plan.subscription_plan_id = '%s'", $subscriptionid);
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
		function updatesubscriptionplanrecord($subscriptionid, $subscription) {
			  //convert object to array
			  $subscription = (array)$subscription;
			  			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_subscription_plan(ec_subscription_plan.subscription_plan_id, ec_subscription_plan.plan_title, ec_subscription_plan.can_downgrade)
				values('".$subscriptionid."', '%s', '%s')",
				mysql_real_escape_string($subscription['subscriptionplantitle']),
				mysql_real_escape_string($subscription['candowngrade']));
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
		function addsubscriptionplanrecord($subscription) {
			//convert object to array
			  $subscription = (array)$subscription;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_subscription_plan(ec_subscription_plan.subscription_plan_id, ec_subscription_plan.plan_title, ec_subscription_plan.can_downgrade)
				values(Null, '%s', '%s')",
				mysql_real_escape_string($subscription['subscriptionplantitle']),
				mysql_real_escape_string($subscription['candowngrade']));
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