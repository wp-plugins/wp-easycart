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


class giftcards
	{		
	
		function giftcards() {
			//load our connection settings
			if( file_exists( '../../../../wp-easycart-data/connection/ec_conn.php' ) ) {
				require_once('../../../../wp-easycart-data/connection/ec_conn.php');
			} else {
				require_once('../../../connection/ec_conn.php');
			}
		
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
		   if ($methodName == 'getgiftcards') return array('admin');
		   else if($methodName == 'deletegiftcard') return array('admin');
		   else if($methodName == 'updategiftcard') return array('admin');
		   else if($methodName == 'addgiftcard') return array('admin');
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

		
		//giftcard functions
		function getgiftcards($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_giftcard.* FROM ec_giftcard WHERE ec_giftcard.giftcard_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletegiftcard($cardid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_giftcard WHERE ec_giftcard.giftcard_id = '%s'", $cardid);
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
		function updategiftcard($cardid, $card) {
			  //convert object to array
			  $card = (array)$card;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_giftcard(ec_giftcard.giftcard_id, ec_giftcard.amount, ec_giftcard.message)
				values('".$cardid."', '%s', '%s')",
				mysql_real_escape_string($card['giftcardamount']),
				mysql_real_escape_string($card['giftcardmessage']));
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
		function addgiftcard($card) {
			  //convert object to array
			  $card = (array)$card;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_giftcard(ec_giftcard.giftcard_id, ec_giftcard.amount, ec_giftcard.message)
				values('%s', '%s', '%s')",
				mysql_real_escape_string($card['giftcardid']),
				mysql_real_escape_string($card['giftcardamount']),
				mysql_real_escape_string($card['giftcardmessage']));
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