<?php
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, LLC
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, LLC's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

class ec_admin_categories{		
	
	private $db;
	
	function ec_admin_categories( ){
		
		global $wpdb;
		$this->db = $wpdb;

	}
		
	public function _getMethodRoles( $methodName ){
	   		if( $methodName == 'getcategories' ) 		return array( 'admin' );
	   else if( $methodName == 'getcategorylist' ) 		return array( 'admin' );
	   else if( $methodName == 'deletecategory' ) 		return array( 'admin' );
	   else if( $methodName == 'updatecategory' ) 		return array( 'admin' );
	   else if( $methodName == 'addcategory' ) 			return array( 'admin' );
	   else if( $methodName == 'getcategoryitems' ) 	return array( 'admin' );
	   else if( $methodName == 'deleteindividualcategoryitem' ) 	return array( 'admin' );
	   else if( $methodName == 'deletecategoryitem' ) 	return array( 'admin' );
	   else if( $methodName == 'addcategoryitem' ) 		return array( 'admin' );
	   else if( $methodName == 'getcategoryproducts' ) 	return array( 'admin' );
	   else  											return null;
	}//_getMethodRoles
	
	function getcategories( $startrecord, $limit, $orderby, $ordertype, $filter ){

		$sql = "SELECT SQL_CALC_FOUND_ROWS ec_category.* FROM ec_category WHERE category_id != '' " . $filter . " ORDER BY " . $orderby . " " . $ordertype . " LIMIT " . $startrecord . ", " . $limit;
		$results = $this->db->get_results( $sql );
		
		$totalquery = $this->db->get_var( "SELECT FOUND_ROWS( )" );
		
		//trying to return total products inside this category_id
		if(count( $results ) > 0 ) {
			$rowcount = 0;
			foreach( $results as $row ){ 
				
				$current_category_id = $row->category_id;
				$product_sql = "SELECT SQL_CALC_FOUND_ROWS ec_categoryitem.* FROM ec_categoryitem WHERE ec_categoryitem.category_id = '".$current_category_id."'";
				$product_results = $this->db->get_results( $product_sql );
				$total_products = 0;
				if(count( $product_results ) > 0 ) {
					$total_products = $this->db->get_var( "SELECT FOUND_ROWS( )" );
				}
				$results[$rowcount]->totalproducts = $total_products;
				$rowcount++; 
			}
		}
		//end new section
		
		if( count( $results ) > 0 ){
			$results[0]->totalrows = $totalquery;
			return $results;
		}else{
			return array( "noresults" );
		}
		
	}//getcategories
	
	function getcategorylist( ){

		$sql = "SELECT SQL_CALC_FOUND_ROWS ec_category.* FROM ec_category";
		$results = $this->db->get_results( $sql );
		$totalquery = $this->db->get_var( "SELECT FOUND_ROWS()" );
		
		if( count( $results ) > 0 ){
			$results[0]->totalrow = $totalquery;
			return $results;
		}else{
			return array( "noresults" );
		}
	}//getcategorylist
	
	function deletecategory( $categoryid ){
		
		// Delete WordPress Post
		$sql = "SELECT post_id FROM ec_category WHERE category_id = %d";
		$post_id = $this->db->get_var( $this->db->prepare( $sql, $categoryid ) );
		wp_delete_post( $post_id, true );
		
		// Delete Category	
		$sql = "DELETE FROM ec_category WHERE ec_category.category_id = %d";
		$rows_affected = $this->db->query( $this->db->prepare( $sql, $categoryid ) );
		
		// Delete Category Items
		$sql = "DELETE FROM ec_categoryitem WHERE ec_categoryitem.category_id = %d";
		$this->db->query( $this->db->prepare( $sql, $categoryid ) );
		
		if( $rows_affected ){
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//deletecategory
	
	function updatecategory( $categoryid, $categoryname ){
		
		$sql = "UPDATE ec_category SET category_name = %s WHERE category_id = %d";
		$this->db->query( $this->db->prepare( $sql, $categoryname, $categoryid ) );
		
		// Update WordPress Post
		$sql = "SELECT post_id FROM ec_category WHERE category_id = %d";
		$results = $this->db->get_results( $this->db->prepare( $sql, $categoryid ) );
		
		// Create Post Array
		$post = array(	'ID'			=> $results[0]->post_id,
						'post_content'	=> "[ec_store groupid=\"" . $categoryid . "\"]",
						'post_status'	=> "publish",
						'post_title'	=> $GLOBALS['language']->convert_text( $categoryname ),
						'post_type'		=> "ec_store",
						'post_name'		=> str_replace(' ', '-', $GLOBALS['language']->convert_text( $categoryname ) ),
					  );
		
		// Update WordPress Post
		wp_update_post( $post );
		
		return array( "success" );
		
	}//updatecategory
	
	function addcategory( $categoryname ){
		
		$sql = "INSERT INTO ec_category( category_name ) VALUES( %s )";
		$rows_affected = $this->db->query( $this->db->prepare( $sql, $categoryname ) );
		
		if( $rows_affected ){
			// Insert a WordPress Custom post type post.
			$category_id = $this->db->insert_id;
			$post = array(	'post_content'	=> "[ec_store groupid=\"" . $category_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $GLOBALS['language']->convert_text( $categoryname ),
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			
			// Update Category Post ID
			$db = new ec_db( );
			$db->update_category_post_id( $category_id, $post_id );
			
			return array( "success" );
		}else{
			return array( "error" );
		}
	
	}//addcategory

	function getcategoryitems( $startrecord, $limit, $orderby, $ordertype, $filter, $parentid ){
		  
		$sql = "SELECT SQL_CALC_FOUND_ROWS ec_categoryitem.*, ec_product.title, ec_product.product_id FROM ec_categoryitem LEFT JOIN ec_product ON ec_product.product_id = ec_categoryitem.product_id  WHERE ec_categoryitem.categoryitem_id != '' AND ec_categoryitem.category_id = " . $parentid . " " . $filter . " ORDER BY " . $orderby . " " . $ordertype . " LIMIT " . $startrecord . ", " . $limit;
		$results = $this->db->get_results( $sql );
		
		$totalquery = $this->db->get_var( "SELECT FOUND_ROWS( )" );
		
		if( count( $results) > 0 ){
			$results[0]->totalrows = $totalquery;
			return $results;
		} else {
			return array( "noresults" );
		}
	}//getcategoryitems
	
	function deleteindividualcategoryitem(  $categoryitemid ){
		  
		$sql = "DELETE FROM ec_categoryitem WHERE ec_categoryitem.categoryitem_id = %d";
		$rows_affected = $this->db->query( $this->db->prepare( $sql,  $categoryitemid) );
		
		if( $rows_affected ){
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//deletecategoryitem
	
	function deletecategoryitem(  $productid, $categoryid ){
		  
		$sql = "DELETE FROM ec_categoryitem WHERE ec_categoryitem.product_id = %d AND ec_categoryitem.category_id = %d";
		$rows_affected = $this->db->query( $this->db->prepare( $sql,  $productid, $categoryid  ) );
		
		if( $rows_affected ){
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//deletecategoryitem

	function addcategoryitem( $productid, $categoryid ){
		
		$sql = "Insert into ec_categoryitem( product_id, category_id ) values( %d, %d )";
		$rows_affected = $this->db->query( $this->db->prepare( $sql, $productid, $categoryid ) );
		
		if( $rows_affected ){
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//addcategoryitem

	function getcategoryproducts( $categoryid, $startrecord, $limit, $orderby, $ordertype, $filter  ){
		
		
		$sql = "SELECT SQL_CALC_FOUND_ROWS 
		ec_product.*, 
		ec_categoryitem.categoryitem_id, 
		ec_categoryitem.category_id,
		ec_manufacturer.name AS manufacturer 
		FROM ec_product 
		LEFT OUTER JOIN ec_categoryitem ON (ec_product.product_id = ec_categoryitem.product_id AND ec_categoryitem.category_id = ".$categoryid.")
		LEFT OUTER JOIN ec_manufacturer ON (ec_product.manufacturer_id = ec_manufacturer.manufacturer_id)   
		WHERE ec_product.product_id != '' " . $filter . " 
		ORDER BY ".  $orderby ." ".  $ordertype . " 
		LIMIT ".  $startrecord . ", ". $limit;
		
		$results = $this->db->get_results( $sql );
		$totalquery = $this->db->get_var( "SELECT FOUND_ROWS()" );
		
		if( count( $results ) > 0 ){
			$results[0]->totalrows = $totalquery;
			return $results;
		}else{
			return array( "noresults" );
		}
		
		
		
	}//getcategoryproducts

}//ec_admin_categories
?>