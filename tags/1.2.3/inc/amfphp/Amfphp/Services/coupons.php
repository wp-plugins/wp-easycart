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


class coupons
	{		
	
		function coupons() {
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
		   if ($methodName == 'getcoupons') return array('admin');
		   else if($methodName == 'deletecoupon') return array('admin');
		   else if($methodName == 'updatecoupon') return array('admin');
		   else if($methodName == 'addcoupon') return array('admin');
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
		

		
		//coupon functions
		function getcoupons($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_promocode.* FROM ec_promocode  WHERE ec_promocode.promocode_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletecoupon($promocodesid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_promocode WHERE ec_promocode.promocode_id  = '%s'", $promocodesid);
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
		function updatecoupon($promocodesid, $promocodes) {
			//convert object to array
			  $promocodes = (array)$promocodes;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_promocode(ec_promocode.promocode_id, ec_promocode.promo_dollar, ec_promocode.is_dollar_based, ec_promocode.promo_percentage, ec_promocode.is_percentage_based, ec_promocode.promo_shipping, ec_promocode.is_shipping_based, ec_promocode.promo_free_item, ec_promocode.is_free_item_based,  ec_promocode.message, ec_promocode.manufacturer_id, ec_promocode.product_id, ec_promocode.by_manufacturer_id, ec_promocode.by_product_id, ec_promocode.by_all_products)
				values('".$promocodesid."', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($promocodes['dollaramount']),
				mysql_real_escape_string($promocodes['usedollar']),
				mysql_real_escape_string($promocodes['percentageamount']),
				mysql_real_escape_string($promocodes['usepercentage']),
				mysql_real_escape_string($promocodes['shippingamount']),
				mysql_real_escape_string($promocodes['useshipping']),
				mysql_real_escape_string('0.00'),
				mysql_real_escape_string($promocodes['usefreeitem']),
				mysql_real_escape_string($promocodes['promodescription']),
				mysql_real_escape_string($promocodes['manufacturers']),
				mysql_real_escape_string($promocodes['products']),
				mysql_real_escape_string($promocodes['attachmanufacturer']),
				mysql_real_escape_string($promocodes['attachproduct']),
				mysql_real_escape_string($promocodes['attachall']));
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
					return mysql_error(); //return noresults if there are no results
				}
			}
		}
		function addcoupon($promocodes) {
			
			//convert object to array
			  $promocodes = (array)$promocodes;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_promocode(ec_promocode.promocode_id, ec_promocode.promo_dollar, ec_promocode.is_dollar_based, ec_promocode.promo_percentage, ec_promocode.is_percentage_based, ec_promocode.promo_shipping, ec_promocode.is_shipping_based, ec_promocode.promo_free_item, ec_promocode.is_free_item_based,  ec_promocode.message, ec_promocode.manufacturer_id, ec_promocode.product_id, ec_promocode.by_manufacturer_id, ec_promocode.by_product_id, ec_promocode.by_all_products)
				values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($promocodes['promoid']),
				mysql_real_escape_string($promocodes['dollaramount']),
				mysql_real_escape_string($promocodes['usedollar']),
				mysql_real_escape_string($promocodes['percentageamount']),
				mysql_real_escape_string($promocodes['usepercentage']),
				mysql_real_escape_string($promocodes['shippingamount']),
				mysql_real_escape_string($promocodes['useshipping']),
				mysql_real_escape_string('0.00'),
				mysql_real_escape_string($promocodes['usefreeitem']),
				mysql_real_escape_string($promocodes['promodescription']),
				mysql_real_escape_string($promocodes['manufacturers']),
				mysql_real_escape_string($promocodes['products']),
				mysql_real_escape_string($promocodes['attachmanufacturer']),
				mysql_real_escape_string($promocodes['attachproduct']),
				mysql_real_escape_string($promocodes['attachall']));
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