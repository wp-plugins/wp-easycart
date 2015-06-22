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
	
	$data = "";
	$setnum = 1;
	if( isset( $_GET['setnum'] ) )
		$setnum = $_GET['setnum'];
	$total = $wpdb->get_var( "SELECT COUNT( ec_product.product_id ) as total FROM ec_product" );
	$sql = "SELECT * FROM ec_product ORDER BY ec_product.product_id ASC LIMIT %d, 500";
	$results = $wpdb->get_results( $wpdb->prepare( $sql, ( $setnum-1 )*500 ), ARRAY_A );
	
	if( count( $results ) > 0 ){
		
		$keys = array_keys( $results[0] );
		
		$first = true;
		
		foreach( $keys as $key ){
			
			if( !$first )
				$data .= ',';
			
			$data .= $key;
			$first = false;
		
		}
		
		$data .= "\n";
		
		foreach( $results as $result ){
		
			$first = true;
			
			foreach( $result as $value ){
			
				if( !$first )
					$data .= ',';
			
				$data .= '"' . str_replace( '"', '""', iconv( "UTF-8", "ISO-8859-2", $value ) ) . '"';
				
				$first = false;
			
			}
			
			$data .= "\n";
		}
		
	}else{
		if( $data == "" ){
			$data = "\nno matching records found\n";
		}
	}
	
	if( $total > ( $setnum * 500 ) ){ // More files to generate
		
		file_put_contents( "productexport" . $setnum . ".csv", $data );
		header( "location:productexport.php?reqID=" . $_GET['reqID'] . "&setnum=" . ($setnum+1) );
		
	}else if( $total > 500 ){ // Combine and zip generate files
		
		file_put_contents( "productexport" . $setnum . ".csv", $data );
		$files = array( );
		for( $i=1; $i<=$setnum; $i++ ){
			$files[] = "productexport" . $i . ".csv";
		}
		$zipname = 'productexport-' . date( 'Y-m-d' ) . '.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($files as $file) {
		  $zip->addFile($file);
		}
		$zip->close();
		
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='.$zipname);
		header('Content-Length: ' . filesize($zipname));
		readfile($zipname);
		
		for( $i=1; $i<=$setnum; $i++ ){
			unlink( "productexport" . $i . ".csv" );
		}
		unlink( $zipname );
		
	}else{ // Download a single file
	
		header("Content-type: text/csv; charset=UTF-8");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Disposition: attachment; filename=product-export-" . date( 'Y-m-d' ). ".csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $data;
		
	}
	
}else{

	echo "Not Authorized...";

}
?>