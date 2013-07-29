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


class authentication
	{		
	
		public function authentication() {
			
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
		public function escape($sql) 
		{ 
			  $args = func_get_args(); 
				foreach($args as $key => $val) 
				{ 
					$args[$key] = mysql_real_escape_string($val); 
				} 
				 
				$args[0] = $sql; 
				return call_user_func_array('sprintf', $args); 
		} 
		


		//login functions
		public function login($Email, $Password) {

			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_user.* FROM ec_user where ec_user.email = '%s' AND ec_user.password = '%s' AND ec_user.user_level = 'admin'", $Email, $Password);
			  // Run query on database
			  $result = mysql_query($sql);
			  //now get version
			  $versionsql = $this->escape("select ec_setting.storeversion, ec_setting.storetype FROM ec_setting WHERE ec_setting.settingID = 1");
			  $versionresult = mysql_query($versionsql); 
			  //return $versionresult;
			  if ($versionresult) {
				 $versionrow = mysql_fetch_array($versionresult); 
				 $storeversion = $versionrow[storeversion];
				 $storetype = $versionrow[storetype];
			  } else {
				 //return 'not exists';
			     $storeversion = '7.0.0';
				 $storetype = 'flash';
			  }
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($result) > 0) {
				  while ($row=mysql_fetch_object($result)) {
					  //now attach the version if it's there
					  $row->storeversion = $storeversion;
					  $row->storetype = $storetype;
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