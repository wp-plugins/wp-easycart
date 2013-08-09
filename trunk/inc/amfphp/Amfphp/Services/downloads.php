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


class downloads
	{		
	
		function downloads() {
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
		

		
		//download functions
		function getdownloads($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_download.* FROM ec_download WHERE ec_download.download_id != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");
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
		function deletedownload($downloadid) {
			  //Create SQL Query	
			$ec_downloadsql = $this->escape("DELETE FROM ec_download WHERE ec_download.download_id = '%s'", $downloadid);
			//Run query on database;
			mysql_query($ec_downloadsql);
			
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
		function updatedownload($downloadid, $downloads, $downloadname) {
			  //Create SQL Query
			$sql = $this->escape("UPDATE ec_download SET ec_download.download_count = '%s', ec_download.download_file_name = '%s' WHERE ec_download.download_id = '%s'", $downloads, $downloadname, $downloadid);
			//Run query on database;
			mysql_query($sql);
			  //Create SQL Query
			$productsql = $this->escape("UPDATE ec_orderdetail SET ec_orderdetail.download_file_name = '%s' WHERE ec_orderdetail.download_key = '%s'", $downloadname, $downloadid);
			//Run query on database;
			mysql_query($productsql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = mysql_error();
				return $returnArray; //return noresults if there are no results
			}
		}
		function readdownloaddirectory() { 
			  //get a list of files in the download directory
			$listDir = array(); 
			$dir = "../../../products/downloads";
			if($handler = opendir($dir)) { 
				while (($sub = readdir($handler)) !== FALSE) { 
					if ($sub != "." && $sub != ".." && $sub != "Thumb.db" && $sub != "_notes" && $sub != ".htaccess") { 
						if(is_file($dir."/".$sub)) { 
							$listDir[] = $sub; 
						}
					} 
				}    
				closedir($handler); 
			} 
			return $listDir;    
		} 

	}//close class
?>