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


class subscribers
	{		
	
		function subscribers() {
			//load our connection settings
			require_once('../../../connection/ec_conn.php');
		
			//set our connection variables
			$dbhost = HOSTNAME;
			$dbname = DATABASE;
			$dbuser = USERNAME;
			$dbpass = PASSWORD;	

			//make a connection to our database
			$this->conn = mysql_connect($dbhost, $dbuser, $dbpass);
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
		

		
		//subscriber functions
		function getsubscribers($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_subscriber.* FROM ec_subscriber  WHERE ec_subscriber.subscriber_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletesubscriber($subscriberid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_subscriber WHERE ec_subscriber.subscriber_id = '%s'", $subscriberid);
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
		function updatesubscriber($subscriberid, $subscriber) {
			
			  //convert object to array
			  $subscriber = (array)$subscriber;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_subscriber(ec_subscriber.subscriber_id, ec_subscriber.email, ec_subscriber.first_name, ec_subscriber.last_name)
				values('".$subscriberid."', '%s', '%s', '%s')",
				mysql_real_escape_string($subscriber['email']),
				mysql_real_escape_string($subscriber['firstname']),
				mysql_real_escape_string($subscriber['lastname']));
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
		function addsubscriber($subscriber) {
			
			  //convert object to array
			  $subscriber = (array)$subscriber;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_subscriber(ec_subscriber.subscriber_id, ec_subscriber.email, ec_subscriber.first_name, ec_subscriber.last_name)
				values(Null, '%s', '%s', '%s')",
				mysql_real_escape_string($subscriber['email']),
				mysql_real_escape_string($subscriber['firstname']),
				mysql_real_escape_string($subscriber['lastname']));
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