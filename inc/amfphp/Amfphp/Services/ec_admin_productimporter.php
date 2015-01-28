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


class ec_admin_productimporter{
	
	private $db;
	
	function ec_admin_productimporter( ){
		
		global $wpdb;
		$this->db = $wpdb;

	}	
		
	public function _getMethodRoles($methodName){
	   if ($methodName == 'productimport') return array('admin');
	   else  return null;
	}
	
	public function productimport( ){
		
		if( !file_exists( "../administration/productimportfile.csv" ) ){
			return "Import file not found on server or did not upload successfully.";
		}
		$file = fopen( "../administration/productimportfile.csv", "r" );
	
		$rows = array( );
		
		while( !feof( $file ) ){
		
			$rows[] = fgetcsv( $file );
		
		}
		
		fclose( $file );
		
		$insert_sql = "INSERT INTO ec_product(";
		$update_sql = "UPDATE ec_product SET ";
		
		$first = true;
		$product_id_index = -1;
		$product_post_id_index = -1;
		
		for( $i=0; $i<count( $rows[0] ); $i++ ){
			if( $rows[0][$i] == "product_id" ){
				$product_id_index = $i; // do not add product id to list
				
			}else if( $rows[0][$i] == "post_id" ){
				$product_post_id_index = $i; // do not add post id to list
			
			}else{
			
				if( !$first ){
					$insert_sql .= ",";
					$update_sql .= ",";
				}
				
				$insert_sql .= "`" . $rows[0][$i] . "`";
				$update_sql .= "`" . $rows[0][$i] . "`=%s";
				$first = false;
				
			}
		}
		
		$insert_sql .= ") VALUES(";
		
		$first = true;
		
		for( $i=0; $i<count( $rows[0] ); $i++ ){
			if( $i != $product_id_index && $i != $product_post_id_index ){ // Skip rows with product id and post id
				if( !$first )
					$insert_sql .= ",";
					
				$insert_sql .= "%s";
				$first = false;
			}
		}
		
		$insert_sql .= ")";
		$update_sql .= " WHERE ec_product.product_id = %s";
		
		if( $product_id_index == -1 ){
			return "Missing `product_id` Key field! Values for additions should be 0, updates should be the exported product_id value.";
		}
		
		$error_list = "";
		
		for( $i=1; $i<count( $rows )-1; $i++ ){
			
			if( $rows[$i][$product_id_index] != 0 && $rows[$i][$product_id_index] != "" ){
				$product_id = $rows[$i][$product_id_index];
				$post_id = $rows[$i][$product_post_id_index];
				
				// Try and get the product
				$sql = "SELECT ec_product.model_number, ec_product.title, ec_product.activate_in_store FROM ec_product WHERE ec_product.product_id = %d";
				$product = $this->db->get_row( $this->db->prepare( $sql, $product_id ) );
				
				if( $product ){
						
					$update_vals = array( );
					for( $j=0; $j<count( $rows[$i] ); $j++ ){
						if( $j != $product_id_index && $j != $product_post_id_index ){
							$update_vals[] = $rows[$i][$j];
						}
					}
					$update_vals[] = $product_id; // Add product id last for the update
					$this->db->query( $this->db->prepare( $update_sql, $update_vals ) );
				
					// Update the WordPress Post
					if( $product->activate_in_store )
						$status = "publish";
					else
						$status = "private";
					$post = array(	'ID'			=> $post_id,
									'post_content'	=> "[ec_store modelnumber=\"" . $product->model_number . "\"]",
									'post_status'	=> $status,
									'post_title'	=> $GLOBALS['language']->convert_text( $product->title ),
									'post_type'		=> "ec_store",
									'post_name'		=> str_replace(' ', '-', $GLOBALS['language']->convert_text( $product->title ) ),
								  );
					wp_update_post( $post );
					
				}else{
					// Save error
					if( $error_list != "" )
						$error_list .= ", ";
					$error_list .= "Product " . $product_id . " on line " . ($i+1) . " failed to update, invalid product_id (if you are trying to add a new product use 0 for the product_id)";
				}
				
				
			}else{
				
				// Insert the product to ec_product table
				$insert_vals = array( );
				for( $j=0; $j<count( $rows[$i] ); $j++ ){
					if( $j != $product_id_index && $j != $product_post_id_index ){
						$insert_vals[] = $rows[$i][$j];
					}
				}
				$this->db->query( $this->db->prepare( $insert_sql, $insert_vals ) );
				$product_id = $this->db->insert_id;
				
				// Try and get the product
				$sql = "SELECT ec_product.model_number, ec_product.title, ec_product.activate_in_store FROM ec_product WHERE ec_product.product_id = %d";
				$product = $this->db->get_row( $this->db->prepare( $sql, $product_id ) );
					
				if( $product ){
						
					// Insert WordPress Post
					if( $product->activate_in_store )
						$status = "publish";
					else
						$status = "private";
					
					$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product->model_number . "\"]",
									'post_status'	=> $status,
									'post_title'	=> $GLOBALS['language']->convert_text( $product->title ),
									'post_type'		=> "ec_store"
								  );
					$post_id = wp_insert_post( $post, $wp_error );
					
					// Update the product in ec_product table
					$sql = "UPDATE ec_product SET ec_product.post_id = %s WHERE ec_product.product_id = %d";
					$this->db->query( $this->db->prepare( $sql, $post_id, $product_id ) );
					
				}else{
					// Save error
					if( $error_list != "" )
						$error_list .= ", ";
					$error_list .= "Product on line " . ($i+1) . " failed to insert(common errors are invalid data, invalid column header, missing required field)";
				}
			}
			
		}
		
		if( $error_list == "" ){
			return array( "success" );
		}else{
			return $error_list;
		}
		
	} // Close Import Function
	
}
?>