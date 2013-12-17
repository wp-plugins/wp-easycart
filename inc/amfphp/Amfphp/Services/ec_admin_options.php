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


class ec_admin_options
	{		
	
		function ec_admin_options() {
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
		   if ($methodName == 'getoptions') return array('admin');
		   else if($methodName == 'getoptionsets') return array('admin');
		   else if($methodName == 'deleteoption') return array('admin');
		   else if($methodName == 'updateoption') return array('admin');
		   else if($methodName == 'addoption') return array('admin');
		   else if($methodName == 'getproductoptionitems') return array('admin');
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

		
		function getoptions() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_option.* FROM ec_option ORDER BY ec_option.option_name ASC");
			  // Run query on database
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
		

	
		//option functions
		function getoptionsets($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_option.* FROM ec_option  WHERE ec_option.option_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deleteoption($optionid) {
			  //delete the main option group	
			  $deletesql = $this->escape("DELETE FROM ec_option WHERE ec_option.option_id = '%s'", $optionid);
			  //Run query on database;
			  mysql_query($deletesql);
			 
			 	//get all option items and delete them from db
			 	$sql_getoptionitemid = sprintf("SELECT optionitem_id from ec_optionitem WHERE ec_optionitem.option_id = '%s'", $optionid);
				$result_getoptionitemid = mysql_query($sql_getoptionitemid);
				while ($row_getoptionitem_id = mysql_fetch_assoc($result_getoptionitemid)) {
					
					$optionitem_id = $row_getoptionitem_id['optionitem_id'];
					//delete option items for this option 	
					$deleteoptionitemsql = $this->escape("DELETE FROM ec_optionitem WHERE ec_optionitem.optionitem_id = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteoptionitemsql);
					
					//delete option items quantitys
					$deleteoptionitemquantitysql = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteoptionitemquantitysql);
					
					//now delete option item images
					$deleteoptionimagessql = $this->escape("DELETE FROM ec_optionitemimage WHERE ec_optionitemimage.optionitem_id = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteoptionimagessql);
					
					//option item quantity 1
					$deleteproductoption1 = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_1 = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteproductoption1);
					
					//option item quantity 2
					$deleteproductoption2 = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_2 = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteproductoption2);
					
					//option item quantity 3
					$deleteproductoption3 = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_3 = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteproductoption3);
					
					//option item quantity 4
					$deleteproductoption4 = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_4 = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteproductoption4);
					
					//option item quantity 5
					$deleteproductoption5 = $this->escape("DELETE FROM ec_optionitemquantity WHERE ec_optionitemquantity.optionitem_id_5 = '%s'", $optionitem_id);
					//Run query on database;
					mysql_query($deleteproductoption5);
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
		function updateoption($optionid, $option) {
			
			  //convert object to array
			  $option = (array)$option;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_option(ec_option.option_id, ec_option.option_name, ec_option.option_label, ec_option.option_type, ec_option.option_required)
				values('".$optionid."', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($option['optionname']),
				mysql_real_escape_string($option['optionlabel']),
				mysql_real_escape_string($option['optiontype']),
				mysql_real_escape_string($option['optionrequired']));
				
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
		function addoption($option) {
			  //convert object to array
			  $option = (array)$option;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_option(ec_option.option_id, ec_option.option_name, ec_option.option_label, ec_option.option_type, ec_option.option_required)
				values(Null, '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($option['optionname']),
				mysql_real_escape_string($option['optionlabel']),
				mysql_real_escape_string($option['optiontype']),
				mysql_real_escape_string($option['optionrequired']));
				
			  mysql_query($sql);
			  $option_id_parent = mysql_insert_id();
			  
			  //add option item if file, text, or text area
			  if ($option['optiontype'] == 'file' || $option['optiontype'] == 'text' || $option['optiontype'] == 'textarea' ) {
				  //Create SQL Query
				  if ($option['optiontype'] == 'file') $op_name = 'File Field';
				  if ($option['optiontype'] == 'text') $op_name = 'Text Box Input';
				  if ($option['optiontype'] == 'textarea') $op_name = 'Text Area Input';
				  $sql = sprintf("Insert into ec_optionitem(
								  ec_optionitem.optionitem_id, 
								  ec_optionitem.option_id, 
								  ec_optionitem.optionitem_name, 
								  ec_optionitem.optionitem_price, 
								  ec_optionitem.optionitem_price_onetime,
								  ec_optionitem.optionitem_price_override,
								  ec_optionitem.optionitem_weight,
								  ec_optionitem.optionitem_weight_onetime,
								  ec_optionitem.optionitem_weight_override,
								  ec_optionitem.optionitem_order, 
								  ec_optionitem.optionitem_icon,
								  ec_optionitem.optionitem_initial_value)
								  values(Null, '".$option_id_parent."', '".$op_name."', '0', '0', '-1', '0', '0', '-1', '1', '', '')");
				  mysql_query($sql);
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
		
		function getproductoptionitems($optionnum){
			$sql = sprintf("SELECT ec_optionitem.*, ec_option.option_name FROM ec_optionitem, ec_option WHERE ec_optionitem.option_id = '%s' AND ec_option.option_id = ec_optionitem.option_id", mysql_real_escape_string($optionnum));
			// Run query on database
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



	}//close class
?>