<?php 
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licensed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

//load our connection settings
ob_start( NULL, 4096 );
require_once( '../../../../../../wp-load.php' );
global $wpdb;

$requestID = "-1";
if( isset( $_GET['reqID'] ) )
	$requestID = $_GET['reqID'];

$user_sql = "SELECT  ec_user.*, ec_role.admin_access FROM ec_user LEFT JOIN ec_role ON (ec_user.user_level = ec_role.role_label) WHERE ec_user.password = %s AND  (ec_user.user_level = 'admin' OR ec_role.admin_access = 1)";
$users = $wpdb->get_results( $wpdb->prepare( $user_sql, $requestID ) );

if( !empty( $users ) ){
	
		// Prepare our csv download
		$data = "";
		$sql = "SELECT * FROM ec_product ORDER BY ec_product.product_id ASC";
		$results = $wpdb->get_results( $wpdb->prepare($sql) );
		// Set header row values

		$output_filename = 'products.csv';
		$output_handle = @fopen( 'php://output', 'w' );
		 
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-type: text/csv' );
		header( 'Content-Disposition: attachment; filename=' . $output_filename );
		header( 'Expires: 0' );
		header( 'Pragma: public' );	
		
		$first = true;
		   // Parse results to csv format
		   foreach ($results as $row) {
     
			  // Add table headers
			  if($first){
				 $titles = array();
				 foreach($row as $key=>$val){
					$titles[] = $key;
				 }
				 fputcsv($output_handle, $titles);
				 $first = false;
			  }
			  
			   $leadArray = (array) $row; // Cast the Object to an array
			   // Add row to file
			   fputcsv( $output_handle, $leadArray );
		   }
		
		die();
	
}else{

	echo "Not Authorized...";

}
?>