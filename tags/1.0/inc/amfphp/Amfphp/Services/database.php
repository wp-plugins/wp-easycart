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


class database
	{		
	
		function database() {
			//load our connection settings
			require_once('../../../connection/ec_conn.php');
		
			//set our connection variables
			$dbhost = HOSTNAME;
			$dbname = DATABASE;
			$dbuser = USERNAME;
			$dbpass = PASSWORD;	

			//make a connection to our database
			$this->conn = mysql_pconnect($dbhost, $dbuser, $dbpass);
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
		
		
			
		
		//database  functions
		function restoredb($dbfilename) {
			// Get file data
			$data = file("../../../products/".$dbfilename);
			//echo $data;
			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			$lines = $data;
			// Loop through each line
			foreach ($lines as $line_num => $line) {
			  // Only continue if it's not a comment
			  if (substr($line, 0, 2) != '/*' && $line != '') {
				// Add this line to the current segment
				$templine .= $line;
				
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
				   // Perform the query
				    mysql_query($templine); 
					 // Reset temp variable to empty
				  $templine = '';
				}
			  }
			}
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
					  
		}
		
		function deletedbfile($dbfilename) {
			if (unlink("../../../products/".$dbfilename)) {
				return "success";
			} else {
				return "error";
			}
		}
		
		function logdbrestore() {
			//insert into db backup log an entry
			//Create SQL Query
			$sql = sprintf("INSERT INTO ec_dblog(ec_dblog.entry_date, ec_dblog.entry_type) values(NOW(), 'restore')");
			//Run query on database;
			mysql_query($sql);
		}
		function logdbbackup() {
			//insert into db backup log an entry
			//Create SQL Query
			$sql = sprintf("INSERT INTO ec_dblog(ec_dblog.entry_date, ec_dblog.entry_type) values(NOW(), 'backup')");
			//Run query on database;
			mysql_query($sql);
		}


	}//close class
?>