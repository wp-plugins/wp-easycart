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


class mainmenu
	{		
	
		function mainmenu() {
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
		   if ($methodName == 'getmenulevel1') return array('admin');
		   else if($methodName == 'getmenulevel1set') return array('admin');
		   else if($methodName == 'deletemenulevel1') return array('admin');
		   else if($methodName == 'updatemenulevel1') return array('admin');
		   else if($methodName == 'addmenulevel1') return array('admin');
		   else if($methodName == 'getmenulevel2') return array('admin');
		   else if($methodName == 'getmenulevel2set') return array('admin');
		   else if($methodName == 'deletemenulevel2') return array('admin');
		   else if($methodName == 'updatemenulevel2') return array('admin');
		   else if($methodName == 'addmenulevel2') return array('admin');
		   else if($methodName == 'getmenulevel3') return array('admin');
		   else if($methodName == 'getmenulevel3set') return array('admin');
		   else if($methodName == 'deletemenulevel3') return array('admin');
		   else if($methodName == 'updatemenulevel3') return array('admin');
		   else if($methodName == 'addmenulevel3') return array('admin');
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

		
		//menulevel1 functions
		function getmenulevel1() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_menulevel1.* FROM ec_menulevel1 ORDER BY ec_menulevel1.order ASC");
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
		function getmenulevel1set($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_menulevel1.* FROM ec_menulevel1  WHERE ec_menulevel1.menulevel1_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		
		
		function deletemenulevel1($keyfield) {
			  //first, delete menu 3 sub-sub menus attached to this
			  //query for 2nd level menu ids if there are some 
			  $subquery = mysql_query("SELECT ec_menulevel2.menulevel2_id FROM ec_menulevel2 WHERE ec_menulevel2.menulevel1_id = ".$keyfield."");
			  while($level2 = mysql_fetch_array($subquery)){
				  $level2_id = $level2[0];
				  //Create SQL Query	
				  $deletesql = $this->escape("DELETE FROM ec_menulevel3 WHERE ec_menulevel3.menulevel2_id = '%s'", $level2_id);
				  //Run query on database;
				  mysql_query($deletesql);
			  }
			  //then remove menu and main menu items using keyfield
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_menulevel1 WHERE ec_menulevel1.menulevel1_id = '%s'", $keyfield);
			  //Run query on database;
			  mysql_query($deletesql);
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_menulevel2 WHERE ec_menulevel2.menulevel1_id = '%s'", $keyfield);
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
		function updatemenulevel1($keyfield, $menulevel1) {
			  //convert object to array
			  $menulevel1 = (array)$menulevel1;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_menulevel1 (ec_menulevel1.menulevel1_id, ec_menulevel1.name, ec_menulevel1.clicks, ec_menulevel1.order, ec_menulevel1.seo_keywords, ec_menulevel1.seo_description, ec_menulevel1.banner_image) values ('".$keyfield."', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($menulevel1['menuname']),
				mysql_real_escape_string($menulevel1['clicks']),
				mysql_real_escape_string($menulevel1['menu1order']),
				mysql_real_escape_string($menulevel1['seokeywords']),
				mysql_real_escape_string($menulevel1['seodescription']),
				mysql_real_escape_string($menulevel1['bannerimage']));
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
		function addmenulevel1($menulevel1) {
			  //convert object to array
			  $menulevel1 = (array)$menulevel1;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_menulevel1(ec_menulevel1.menulevel1_id, ec_menulevel1.name, ec_menulevel1.clicks, ec_menulevel1.order, ec_menulevel1.seo_keywords, ec_menulevel1.seo_description, ec_menulevel1.banner_image)
				values(Null, '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($menulevel1['menuname']),
				mysql_real_escape_string($menulevel1['clicks']),
				mysql_real_escape_string($menulevel1['menu1order']),
				mysql_real_escape_string($menulevel1['seokeywords']),
				mysql_real_escape_string($menulevel1['seodescription']),
				mysql_real_escape_string($menulevel1['bannerimage']));
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

		//menulevel2 functions
		function getmenulevel2() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_menulevel2.* FROM ec_menulevel2 ORDER BY ec_menulevel2.order ASC");
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
		function getmenulevel2set($startrecord, $limit, $orderby, $ordertype, $filter, $menuparentid) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_menulevel2.* FROM ec_menulevel2  WHERE ec_menulevel2.menulevel2_id != '' AND ec_menulevel2.menulevel1_id=".$menuparentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletemenulevel2($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_menulevel2 WHERE ec_menulevel2.menulevel2_id = '%s'", $keyfield);
			  //Run query on database;
			  mysql_query($deletesql);
			   //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_menulevel3 WHERE ec_menulevel3.ec_menulevel2_id = '%s'", $keyfield);
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
		function updatemenulevel2($keyfield, $menulevel2) {
			  //convert object to array
			  $menulevel2 = (array)$menulevel2;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_menulevel2(ec_menulevel2.menulevel2_id, ec_menulevel2.menulevel1_id, ec_menulevel2.name, ec_menulevel2.clicks, ec_menulevel2.order, ec_menulevel2.seo_keywords, ec_menulevel2.seo_description, ec_menulevel2.banner_image)
				values('".$keyfield."', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($menulevel2['menuparentid']),
				mysql_real_escape_string($menulevel2['menuname']),
				mysql_real_escape_string($menulevel2['clicks']),
				mysql_real_escape_string($menulevel2['menu2order']),
				mysql_real_escape_string($menulevel2['seokeywords']),
				mysql_real_escape_string($menulevel2['seodescription']),
				mysql_real_escape_string($menulevel2['bannerimage']));
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
		function addmenulevel2($menulevel2) {
			  //convert object to array
			  $menulevel2 = (array)$menulevel2;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_menulevel2(ec_menulevel2.menulevel2_id, ec_menulevel2.menulevel1_id, ec_menulevel2.name, ec_menulevel2.clicks, ec_menulevel2.order, ec_menulevel2.seo_keywords, ec_menulevel2.seo_description, ec_menulevel2.banner_image)
				values(Null, '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($menulevel2['menuparentid']),
				mysql_real_escape_string($menulevel2['menuname']),
				mysql_real_escape_string($menulevel2['clicks']),
				mysql_real_escape_string($menulevel2['menu2order']),
				mysql_real_escape_string($menulevel2['seokeywords']),
				mysql_real_escape_string($menulevel2['seodescription']),
				mysql_real_escape_string($menulevel2['bannerimage']));
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
		
		//menulevel3 functions
		function getmenulevel3() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_menulevel3.* FROM ec_menulevel3 ORDER BY ec_menulevel3.order ASC");
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
		function getmenulevel3set($startrecord, $limit, $orderby, $ordertype, $filter, $menuparentid) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_menulevel3.* FROM ec_menulevel3  WHERE ec_menulevel3.menulevel3_id != '' AND ec_menulevel3.menulevel2_id=".$menuparentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletemenulevel3($keyfield) {
			  //Create SQL Query	
			  $deletesql = $this->escape("DELETE FROM ec_menulevel3 WHERE ec_menulevel3.menulevel3_id = '%s'", $keyfield);
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
		function updatemenulevel3($keyfield, $menulevel3) {
			  //convert object to array
			  $menulevel3 = (array)$menulevel3;
			  
			  //Create SQL Query
			  $sql = sprintf("Replace into ec_menulevel3(ec_menulevel3.menulevel3_id, ec_menulevel3.menulevel2_id, ec_menulevel3.name, ec_menulevel3.clicks, ec_menulevel3.order, ec_menulevel3.seo_keywords, ec_menulevel3.seo_description, ec_menulevel3.banner_image)
				values('".$keyfield."', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($menulevel3['menuparentid']),
				mysql_real_escape_string($menulevel3['menuname']),
				mysql_real_escape_string($menulevel3['clicks']),
				mysql_real_escape_string($menulevel3['menu3order']),
				mysql_real_escape_string($menulevel3['seokeywords']),
				mysql_real_escape_string($menulevel3['seodescription']),
				mysql_real_escape_string($menulevel3['bannerimage']));
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
		function addmenulevel3($menulevel3) {
			  //convert object to array
			  $menulevel3 = (array)$menulevel3;
			  
			  //Create SQL Query
			  $sql = sprintf("Insert into ec_menulevel3(ec_menulevel3.menulevel3_id, ec_menulevel3.menulevel2_id, ec_menulevel3.name, ec_menulevel3.clicks, ec_menulevel3.order, ec_menulevel3.seo_keywords, ec_menulevel3.seo_description, ec_menulevel3.banner_image)
				values(Null,  '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($menulevel3['menuparentid']),
				mysql_real_escape_string($menulevel3['menuname']),
				mysql_real_escape_string($menulevel3['clicks']),
				mysql_real_escape_string($menulevel3['menu3order']),
				mysql_real_escape_string($menulevel3['seokeywords']),
				mysql_real_escape_string($menulevel3['seodescription']),
				mysql_real_escape_string($menulevel3['bannerimage']));
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