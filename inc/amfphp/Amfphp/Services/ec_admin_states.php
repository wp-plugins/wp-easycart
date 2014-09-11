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


class ec_admin_states
	{		
	
		private $db;
	
		function ec_admin_states() {
			
			global $wpdb;
			$this->db = $wpdb;
		}	
		
		
		//secure all of the services for logged in authenticated users only	
		public function _getMethodRoles($methodName){
		   if ($methodName == 'getstates') return array('admin');
		   else if($methodName == 'updatestate') return array('admin');
		   else if($methodName == 'deletestate') return array('admin');
		   else if($methodName == 'addstate') return array('admin');
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
		
		

		function getstates() {
			  //Create SQL Query
			  $sql = $this->escape("SELECT ec_state.* FROM ec_state ORDER BY ec_state.sort_order ASC");
			  // Run query on database
			  $results = $this->db->get_results( $sql);
			  //if results, convert to an array for use in flash
			  if( count( $results ) > 0 ){
				   foreach( $results as $row ){
					  $returnArray[] = $row;
				  }
				  return $returnArray;
			  }else{
				  return array( "noresults" );
			  }
		}
	
		
		
		//state list functions
		//get state list is handled above
		function updatestate($id, $countryid, $iso2, $name, $sortorder) {
			//Create SQL Query
			  $sql = "UPDATE ec_state SET  ec_state.name_sta='%s', ec_state.code_sta='%s', ec_state.idcnt_sta='%s', ec_state.sort_order='%s' WHERE ec_state.id_sta = '%s'";
			//Run query on database;
			$results = $this->db->get_results( $this->db->prepare( $sql, $name, $iso2, $countryid, $sortorder,  $id) );
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if( count( $results ) > 0 ){
				   foreach( $results as $row ){
					  $returnArray[] = $row;
				  }
				  return $returnArray;
			  }else{
				  return array( "noresults" );
			  }
		}	
		function deletestate($id) {
			//Create SQL Query
			$sql = "DELETE FROM ec_state WHERE ec_state.id_sta = %s";
			//Run query on database;
			$success = $this->db->query( $this->db->prepare( $sql, $id ) );
		
			if( $success === FALSE ){
				return array( "error" );
			}else{
				return array( "success" );
			}
		}	
		
		function addstate($countryid, $iso2, $name, $sortorder) {
			//Create SQL Query
			  $sql = "Insert into ec_state(ec_state.id_sta, ec_state.name_sta, ec_state.code_sta, ec_state.idcnt_sta, ec_state.sort_order)
				values(null, '%s', '%s', '%s', '%s')";
			
			
			$success = $this->db->query( $this->db->prepare( $sql, $name, $iso2, $countryid, $sortorder ) );
		
			if( $success === FALSE ){
				return array( "error" );
			}else{
				return array( "success" );
			}
		}
		


	}//close class
?>