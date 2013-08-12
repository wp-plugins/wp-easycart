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


class optionitems
	{		
	
		function optionitems() {
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
		

		
		//option items function
		function getoptionitems($startrecord, $limit, $orderby, $ordertype, $filter, $parentid) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_optionitem.* FROM ec_optionitem  WHERE ec_optionitem.optionitem_id != '' AND ec_optionitem.option_id = ".$parentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deleteoptionitem($optionitemid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_optionitem WHERE ec_optionitem.optionitem_id = '%s'", $optionitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  //delete option items quantitys
			  $deletesql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id = '%s'", $optionitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_optionitemimage WHERE ec_optionitemimage.optionitem_id = '%s'", $optionitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			  //option item quantity 1
			  $deletesql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_1 = '%s'", $optionitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			  //option item quantity 2
			  $deletesql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_2 = '%s'", $optionitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			  //option item quantity 3
			  $deletesql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_3 = '%s'", $optionitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			  //option item quantity 4
			  $deletesql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_4 = '%s'", $optionitemid);
			  //Run query on database;
			  mysql_query($deletesql);
			  
			  //option item quantity 5
			  $deletesql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_5 = '%s'", $optionitemid);
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
		function updateoptionitem($optionitemid, $optionitem) {
			  //convert object to array
			  $optionitem = (array)$optionitem;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_optionitem(ec_optionitem.optionitem_id, ec_optionitem.option_id, ec_optionitem.optionitem_name, ec_optionitem.optionitem_price, ec_optionitem.optionitem_order, ec_optionitem.optionitem_icon)
				values('".$optionitemid."', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($optionitem['optionparentID']),
				mysql_real_escape_string($optionitem['optionitemname']),
				mysql_real_escape_string($optionitem['optionitemprice']),
				mysql_real_escape_string($optionitem['optionorder']),
				mysql_real_escape_string($optionitem['optionitemicon']));
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
		function addoptionitem($optionitem) {
			  //convert object to array
			  $optionitem = (array)$optionitem;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_optionitem(ec_optionitem.optionitem_id, ec_optionitem.option_id, ec_optionitem.optionitem_name, ec_optionitem.optionitem_price, ec_optionitem.optionitem_order, ec_optionitem.optionitem_icon)
				values(Null,  '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($optionitem['optionparentID']),
				mysql_real_escape_string($optionitem['optionitemname']),
				mysql_real_escape_string($optionitem['optionitemprice']),
				mysql_real_escape_string($optionitem['optionorder']),
				mysql_real_escape_string($optionitem['optionitemicon']));
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
		
		
		function getproductimages($ProductID, $OptionItemID){
			$sql = sprintf("SELECT * FROM ec_optionitemimage WHERE ec_optionitemimage.product_id = '%s' AND ec_optionitemimage.optionitem_id = '%s'", mysql_real_escape_string($ProductID), mysql_real_escape_string($OptionItemID));
			// Run query on database
			$result = mysql_query($sql);
			
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
		
		function getoptionitemquantities($productid, $option1, $option2, $option3, $option4, $option5){
			$sql = "";
			if($option1 != 0){
				$sql .= sprintf("
					SELECT * FROM (
						SELECT 
							optionitem_name AS optname1,
    						optionitem_id as optid1
						FROM ec_optionitem
						WHERE option_id = %s
					) as optionitems1 ", mysql_real_escape_string($option1));
			}
			
			if($option2 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitem_name AS optname2,
    						optionitem_id as optid2
						FROM ec_optionitem
						WHERE option_id = %s
					) as optionitems2 ON (1=1) ", mysql_real_escape_string($option2));
			}
			
			if($option3 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitem_name AS optname3,
    						optionitem_id as optid3
						FROM ec_optionitem
						WHERE option_id = %s
					) as optionitems3 ON (1=1) ", mysql_real_escape_string($option3));
			}
			
			if($option4 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitem_name AS optname4,
    						optionitem_id as optid4
						FROM ec_optionitem
						WHERE option_id = %s 
					) as optionitems4 ON (1=1) ", mysql_real_escape_string($option4));
			}
			
			if($option5 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitem_name AS optname5,
    						optionitem_id as optid5
						FROM ec_optionitem
						WHERE option_id = %s 
					) as optionitems5 ON (1=1) ", mysql_real_escape_string($option5));
			}
			
			$sql .= "LEFT JOIN ec_optionitemquantity ON (1=1";
			
			if($option1 != 0){
				$sql .= " AND optionitem_id_1 = optid1";
				
			}
			if($option2 != 0){
				$sql .= " AND optionitem_id_2 = optid2";
			}
			
			if($option3 != 0){
				$sql .= " AND optionitem_id_3 = optid3";
			}
			
			if($option4 != 0){
				$sql .= " AND optionitem_id_4 = optid4";
			}
			
			if($option5 != 0){
				$sql .= " AND optionitem_id_5 = optid5";
			}
			
			$sql .= sprintf(" AND product_id = %s)", mysql_real_escape_string($productid));
			$sql .= " ORDER BY optname1";


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
		
		function objectToArray( $object )
		{
			if( !is_object( $object ) && !is_array( $object ) )
			{
				return $object;
			}
			if( is_object( $object ) )
			{
				$object = get_object_vars( $object );
			}
			return array_map( 'objectToArray', $object );
		}
		
		
		function saveoptionitemquantities($optionitems){

			$numitems = count($optionitems);
			for($i=0;$i<$numitems;$i++){
				$optionitems[$i] = get_object_vars($optionitems[$i]);

				//if they are 1 which is odd for amfphp to return for undefined or null variables, then set them to 0
				if (isset($optionitems[$i]['optid1']) && $optionitems[$i]['optid1'] != 1) {
					$opt1var = $optionitems[$i]['optid1'];
				} else { 
					$opt1var = 0;
				}
				if (isset($optionitems[$i]['optid2']) && $optionitems[$i]['optid2'] != 1) {
					$opt2var = $optionitems[$i]['optid2'];
				} else { 
					$opt2var = 0;
				}
				if (isset($optionitems[$i]['optid3']) && $optionitems[$i]['optid3'] != 1) {
					$opt3var = $optionitems[$i]['optid3'];
				} else { 
					$opt3var = 0;
				}
				if (isset($optionitems[$i]['optid4']) && $optionitems[$i]['optid4'] != 1) {
					$opt4var = $optionitems[$i]['optid4'];
				} else { 
					$opt4var = 0;
				}
				if (isset($optionitems[$i]['optid5']) && $optionitems[$i]['optid5'] != 1) {
					$opt5var = $optionitems[$i]['optid5'];
				} else { 
					$opt5var = 0;
				}
					
				//now we can update or insert
				if($optionitems[$i]['optionitemquantityid']){
					$sql = sprintf("UPDATE ec_optionitemquantity SET ec_optionitemquantity.optionitem_id_1 = %d, ec_optionitemquantity.optionitem_id_2 = %d, ec_optionitemquantity.optionitem_id_3 = %d, ec_optionitemquantity.optionitem_id_4 = %d, ec_optionitemquantity.optionitem_id_5 = %d, ec_optionitemquantity.product_id = %d, ec_optionitemquantity.quantity = %d WHERE ec_optionitemquantity.optionitemquantity_id = %d", $opt1var, $opt2var, $opt3var, $opt4var, $opt5var, $optionitems[$i]['product_id'], $optionitems[$i]['quantity'], $optionitems[$i]['optionitemquantityid']);
					
				}else{
					$sql = sprintf("INSERT INTO ec_optionitemquantity(ec_optionitemquantity.optionitem_id_1, ec_optionitemquantity.optionitem_id_2, ec_optionitemquantity.optionitem_id_3, ec_optionitemquantity.optionitem_id_4, ec_optionitemquantity.optionitem_id_5, ec_optionitemquantity.product_id, ec_optionitemquantity.quantity) VALUES(%d, %d, %d, %d, %d, %d, %d)", $opt1var, $opt2var, $opt3var, $opt4var, $opt5var, $optionitems[$i]['product_id'], $optionitems[$i]['quantity']); 
				}
				
				//return $sql;
						
				//Run query on database;
				mysql_query($sql);
			}
			
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
		
		function removealloptionitemquantities($productid){
			
			$sql = 	sprintf("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.product_id = %s", mysql_real_escape_string($productid));
			
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
		
		function updateoptionvalues($productid, $option1, $option2, $option3, $option4, $option5){
			
			$sql = sprintf("UPDATE ec_product SET ec_product.option_id_1 = '%s', ec_product.option_id_2 = '%s' , ec_product.option_id_3 = '%s', ec_product.option_id_4 = '%s', ec_product.option_id_5 = '%s' WHERE ec_product.product_id = '%s'", mysql_real_escape_string($option1), mysql_real_escape_string($option2), mysql_real_escape_string($option3), mysql_real_escape_string($option4), mysql_real_escape_string($option5), mysql_real_escape_string($productid));
			
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