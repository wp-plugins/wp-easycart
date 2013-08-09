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


class categories
	{		
	
		function categories() {
			
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
		
		
		//category functions
		function getcategories($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_category.* FROM ec_category  WHERE category_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		//category functions
		function getcategorylist() {

			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_category.* FROM ec_category");
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
		
		function deletecategory($categoryid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_category WHERE ec_category.category_id = '%s'", $categoryid);
			  //Run query on database;
			  mysql_query($deletesql);
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_categoryitem WHERE ec_categoryitem.category_id = '%s'", $categoryid);
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
		function updatecategory($categoryid, $categoryname) {
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_category(category_id, category_name)
				values('".$categoryid."', '%s')",
				mysql_real_escape_string($categoryname));
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
		function addcategory($categoryname) {
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_category(category_id, category_name)
				values(Null, '%s')",
				mysql_real_escape_string($categoryname));
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

		//category items function
		function getcategoryitems($startrecord, $limit, $orderby, $ordertype, $filter, $parentid) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_categoryitem.*, ec_product.title, ec_product.product_id FROM ec_categoryitem LEFT JOIN ec_product ON ec_product.product_id = ec_categoryitem.product_id  WHERE ec_categoryitem.categoryitem_id != '' AND ec_categoryitem.category_id = ".$parentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		
		function deletecategoryitem($categoryitemid) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_categoryitem WHERE ec_categoryitem.categoryitem_id = '%s'", $categoryitemid);
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

		function addcategoryitem($productid, $categoryid) {
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_categoryitem(categoryitem_id, product_id, category_id)
				values(Null, '%s', '%s')",
				mysql_real_escape_string($productid),
				mysql_real_escape_string($categoryid));
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

		function getcategoryproducts() {
			//Create SQL Query
			$sql = "SELECT ec_product.title, ec_product.product_id FROM ec_product ORDER BY ec_product.title ASC";
			$query = mysql_query($sql);

			//if results, convert to an array for use in flash
			if(mysql_num_rows($query) > 0) {
			  while ($row=mysql_fetch_object($query)) {
				  $returnArray[] = $row;
			  }
			  return($returnArray); //return array results if there are some
			
			} else {
			  $returnArray[] = "noresults";
			}
		}
		



	}//close class
?>