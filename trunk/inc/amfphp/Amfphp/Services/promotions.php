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


class promotions
	{		
	
		function promotions() {
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
			mysql_query("SET CHARACTER SET utf8", $this->conn); 
			mysql_query("SET NAMES 'utf8'", $this->conn); 

		}	
		
		
		//secure all of the services for logged in authenticated users only	
		public function _getMethodRoles($methodName){
		   if ($methodName == 'getpromotions') return array('admin');
		   else if($methodName == 'deletepromotion') return array('admin');
		   else if($methodName == 'updatepromotion') return array('admin');
		   else if($methodName == 'addpromotion') return array('admin');
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
		

		//promotion functions
		function getpromotions($startrecord, $limit, $orderby, $ordertype, $filter) {
			
				$timezone = mysql_query("SELECT ec_setting.timezone from ec_setting");
			 	$timezoneobject = mysql_fetch_object($timezone);
				date_default_timezone_set($timezoneobject->timezone);
				
			
				$serverdtz = date_default_timezone_get();
				$dtz = new DateTimeZone($serverdtz);
				$server_time = new DateTime('now', $dtz);
				$offset = $dtz->getOffset( $server_time );
	
			
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_promotion.*, ec_promotion.start_date AS original_start_date, ec_promotion.end_date AS original_end_date, UNIX_TIMESTAMP(ec_promotion.start_date) AS start_date, UNIX_TIMESTAMP(ec_promotion.end_date) AS end_date FROM ec_promotion  WHERE ec_promotion.promotion_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);
			  
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($query) > 0) {
				  while ($row=mysql_fetch_object($query)) {
					  $row->totalrows=$totalrows;
					  $row->timezone=$serverdtz;
					  $phpstarttime = strtotime($row->original_start_date);
					  $phpendtime = strtotime($row->original_end_date);
					  $row->offset = $offset;
					  $row->offset_start_date = strval($phpstarttime);
					  $row->offset_end_date = strval($phpendtime);
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		function deletepromotion($promotionid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_promotion WHERE ec_promotion.promotion_id = '%s'", $promotionid);
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
		function updatepromotion($promotionid, $promotioninfo) {
			
			//convert object to array
			 $promotioninfo = (array)$promotioninfo;
			

			if ($promotioninfo['startdate'] != '') {
				$unixstartdate = $promotioninfo['startdate']->timeStamp / 1000;
				$startdate = date("'Y-m-d H:i:s'", strtotime("midnight", $unixstartdate));
			} else {
				$startdate = 'NULL';
			}
			if ($promotioninfo['enddate'] != '') {
				$unixenddate = $promotioninfo['enddate']->timeStamp / 1000;
				$enddate = date("'Y-m-d H:i:s'", strtotime("tomorrow", $unixenddate) -1);
			} else {
				$enddate = 'NULL';
			}
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_promotion(ec_promotion.promotion_id, ec_promotion.name, ec_promotion.type, ec_promotion.start_date, ec_promotion.end_date, ec_promotion.product_id_1, ec_promotion.manufacturer_id_1, ec_promotion.category_id_1, ec_promotion.price1, ec_promotion.price2, ec_promotion.percentage1)
				values('".$promotionid."', '%s', '%s', ".$startdate.", ".$enddate.", '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($promotioninfo['promotionname']),
				mysql_real_escape_string($promotioninfo['promotiontype']),
				mysql_real_escape_string($promotioninfo['product1']),
				mysql_real_escape_string($promotioninfo['manufacturer1']),
				mysql_real_escape_string($promotioninfo['category1']),
				mysql_real_escape_string($promotioninfo['price1']),
				mysql_real_escape_string($promotioninfo['price2']),
				mysql_real_escape_string($promotioninfo['percentage1']));
			
	
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				return mysql_error();
				return $returnArray; //return noresults if there are no results
			}
		}
		function addpromotion($promotioninfo) {
			
			 //convert object to array
			 $promotioninfo = (array)$promotioninfo; 
			  if ($promotioninfo['startdate'] != '') {
				$startdate = date('Y-m-d H:i:s', ($promotioninfo['startdate']->timeStamp / 1000));
			} else {
				$startdate = 'NULL';
			}
			if ($promotioninfo['enddate'] != '') {
				$enddate = date('Y-m-d H:i:s', ($promotioninfo['enddate']->timeStamp / 1000));
			} else {
				$enddate = 'NULL';
			}
			
			
			
			
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_promotion(ec_promotion.promotion_id, ec_promotion.name, ec_promotion.type, ec_promotion.start_date, ec_promotion.end_date, ec_promotion.product_id_1, ec_promotion.manufacturer_id_1, ec_promotion.category_id_1, ec_promotion.price1, ec_promotion.price2, ec_promotion.percentage1)
				values(NULL, '%s', '%s', '".$startdate."', '".$enddate."', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($promotioninfo['promotionname']),
				mysql_real_escape_string($promotioninfo['promotiontype']),
				mysql_real_escape_string($promotioninfo['product1']),
				mysql_real_escape_string($promotioninfo['manufacturer1']),
				mysql_real_escape_string($promotioninfo['category1']),
				mysql_real_escape_string($promotioninfo['price1']),
				mysql_real_escape_string($promotioninfo['price2']),
				mysql_real_escape_string($promotioninfo['percentage1']));
				
			// return $sql;
			 //Run query on database;
			  mysql_query($sql);
			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  return mysql_error();
				  //return $returnArray; //return noresults if there are no results
			  }
		}




	}//close class
?>