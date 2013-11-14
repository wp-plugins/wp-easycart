<?php 

$validate = new ec_validation; 
$license = new ec_license;

function rrmdir($dir) { 
	if (is_dir($dir)) { 
		$objects = scandir($dir); 
		foreach ($objects as $object) { 
			if ($object != "." && $object != "..") { 
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); 
				else unlink($dir."/".$object); 
			} 
		} 
		reset($objects); 
		rmdir($dir); 
	} 
}

function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755)){
	
	$result=false;

	if (is_file($source)) {
		if ($dest[strlen($dest)-1]=='/') {
			if (!file_exists($dest)) {
				cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
			}
			$__dest=$dest."/".basename($source);
		} else {
			$__dest=$dest;
		}
		$result=copy($source, $__dest);
		chmod($__dest,$options['filePermission']);
	   
	} elseif(is_dir($source)) {
		if ($dest[strlen($dest)-1]=='/') {
			if ($source[strlen($source)-1]=='/') {
				//Copy only contents
			} else {
				//Change parent itself and its contents
				$dest=$dest.basename($source);
				@mkdir($dest);
				chmod($dest,$options['filePermission']);
			}
		} else {
			if ($source[strlen($source)-1]=='/') {
				//Copy parent directory with new name and all its content
				@mkdir($dest,$options['folderPermission']);
				chmod($dest,$options['filePermission']);
			} else {
				//Copy parent directory with new name and all its content
				@mkdir($dest,$options['folderPermission']);
				chmod($dest,$options['filePermission']);
			}
		}
	
		$dirHandle=opendir($source);
		while($file=readdir($dirHandle))
		{
			if($file!="." && $file!="..")
			{
				 if(!is_dir($source."/".$file)) {
					$__dest=$dest."/".$file;
				} else {
					$__dest=$dest."/".$file;
				}
				//echo "$source/$file ||| $__dest<br />";
				$result=smartCopy($source."/".$file, $__dest, $options);
			}
		}
		closedir($dirHandle);
   
	}else{
		$result=false;
	}
	
	return $result;
} 

function chmod_R($path, $filemode, $dirmode) {
    if (is_dir($path) ) {
        if (!chmod($path, $dirmode)) {
            $dirmode_str=decoct($dirmode);
            print "Failed applying filemode '$dirmode_str' on directory '$path'\n";
            print "  `-> the directory '$path' will be skipped from recursive chmod\n";
            return;
        }
        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if($file != '.' && $file != '..') {  // skip self and parent pointing directories
                $fullpath = $path.'/'.$file;
                chmod_R($fullpath, $filemode,$dirmode);
            }
        }
        closedir($dh);
    } else {
        if (is_link($path)) {
            print "link '$path' is skipped\n";
            return;
        }
        if (!chmod($path, $filemode)) {
            $filemode_str=decoct($filemode);
            print "Failed applying filemode '$filemode_str' on file '$path'\n";
            return;
        }
    }
}

function DeleteDirRecursive( $resource, $path ) {
    $result_message = "";
    $list = ftp_nlist( $resource, $path );
	
	if ( empty($list) ) {
        $list = RawlistToNlist( ftp_rawlist($resource, $path), $path . ( substr($path, strlen($path) - 1, 1) == "/" ? "" : "/" ) );
    }
    if ($list[0] != $path) {
        $path .= ( substr($path, strlen($path)-1, 1) == "/" ? "" : "/" );
        foreach ($list as $item) {
			if ($item != $path.".." && $item != $path.".") {
				$result_message .= DeleteDirRecursive($resource, $item);
			}
        }
        if (ftp_rmdir ($resource, $path)) {
            $result_message .= "Successfully deleted $path <br />\n";
        } else {
            $result_message .= "There was a problem while deleting $path <br />\n";
        }
    }
    else {
		$res = ftp_site( $resource, 'CHMOD 0777 ' . $path );
        if (ftp_delete ($resource, $path)) {
            $result_message .= "Successfully deleted $path <br />\n";
        } else {
            $result_message .= "There was a problem while deleting $path <br />\n";
        }
    }
    return $result_message;
}
 
     /**
     *    Convert a result from ftp_rawlist() to a result of ftp_nlist()
     *
     *    @param array $rawlist        Result from ftp_rawlist();
     *    @param string $path            Path to the directory on the FTP-server relative to the current working directory
     *    @return array                An array with the paths of the files in the directory
     */
function RawlistToNlist($rawlist, $path) {
    $array = array();
    foreach ($rawlist as $item) {
        $filename = trim(substr($item, 55, strlen($item) - 55));
        if ($filename != "." || $filename != "..") {
        $array[] = $path . $filename;
        }
    }
    return $array;
}

function clean_up_demo( ){
	$install_dir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
	unlink( $install_dir . "standard_demo_install.sql" );
	unlink( $install_dir . "standard_demo_assets.zip" );
}

function ec_ftp_copy_recursive( $conn_id, $prefix, $src_dir, $dst_dir ){ 
	if( !is_dir( $prefix . "/" . $dst_dir ) ){ 
		$d = dir( $prefix . "/" . $src_dir); 
		ftp_mkdir( $conn_id, $dst_dir );
		while( $file = $d->read( ) ){
			if( $file != "." && $file != ".." ){
				if( is_dir( $prefix . "/" . $src_dir . "/" . $file ) ){
					ec_ftp_copy_recursive( $conn_id, $prefix, $src_dir . "/" . $file, $dst_dir . "/" . $file ); 
				}else{ 
					$upload = ftp_put( $conn_id, $dst_dir . "/" . $file, $src_dir . "/" . $file, FTP_BINARY );
				} 
  			}
			ob_flush() ; 
			sleep(1);  
		} 
		$d->close(); 
	}
}
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//START SIMPLE UPDATE SCRIPT
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////	

if(isset($_POST['isupdate'])){
	
	//update options
	update_option( 'ec_option_storepage', $_POST['ec_option_storepage'] );
	update_option( 'ec_option_cartpage', $_POST['ec_option_cartpage'] );
	update_option( 'ec_option_accountpage', $_POST['ec_option_accountpage'] );
	
	//Check and add a shortcode to a page (Simplifies the process!
	$storepage_data = get_page( $_POST['ec_option_storepage'] );
	if(!strstr($storepage_data, "[ec_store]")){
		$storepage_data = "[ec_store]" . $storepage_data;
		update_page( $_POST['ec_option_storepage'], $storepage_data);
	}
	
	$cartpage_data = get_page( $_POST['ec_option_cartpage'] );
	if(!strstr($cartpage_data, "[ec_cart]")){
		$cartpage_data = "[ec_cart]" . $cartpage_data;
		update_page( $_POST['ec_option_cartpage'], $cartpage_data);
	}
	
	$accountpage_data = get_page( $_POST['ec_option_accountpage'] );
	if(!strstr($accountpage_data, "[ec_account]")){
		$accountpage_data = "[ec_account]" . $accountpage_data;
		update_page( $_POST['ec_option_accountpage'], $accountpage_data);
	}
	
} else if( isset( $_POST['isinsertdemodata'] ) ){
	
	install_demo_data( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/" );
	install_demo_images( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/" );
	install_demo_images( WP_PLUGIN_DIR . "/wp-easycart-data/" );
	
}else if( isset( $_POST['isdeletedemodata'] ) ){
	
	uninstall_demo_data( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/" );
	uninstall_demo_images( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/" );
	uninstall_demo_images( WP_PLUGIN_DIR . "/wp-easycart-data/" );
	
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//START CONNECTIONS FTP WRITE SCRIPT
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////	
	
}else if( isset( $_GET['save_conn'] ) && $_GET['save_conn'] == "yes" ){
	$dir_arr = explode( "/", WP_PLUGIN_DIR );
	for( $i=0; $i<count( $dir_arr ); $i++ ){
		if( $dir_arr[$i] == "public_html" ){
			break;
		}
	}
	$plugin_dir = "";
	$prefix_dir = "";
	for( $j=0; $j<$i; $j++ ){
		$prefix_dir .= "/" . $dir_arr[$j];
	}
	for( $i; $i<count( $dir_arr ); $i++ ){
		$plugin_dir .= "/" . $dir_arr[$i];
	}
	
	$to = $plugin_dir . "/wp-easycart-data/";
	$from = $plugin_dir . "/" . EC_PLUGIN_DIRECTORY . "/";
	
	$ec_conn_filename = $plugin_dir . "/" . EC_PLUGIN_DIRECTORY . "/connection/ec_conn.php";
	
	$ec_conn_php = "<?php
	define ('HOSTNAME','" . DB_HOST . "'); 	
	define ('DATABASE','" . DB_NAME . "'); 		
	define ('USERNAME','" . DB_USER . "'); 	
	define ('PASSWORD','" . DB_PASSWORD . "'); 	
?>"; 

	// Could not open the file, lets write it via ftp!
	$ftp_server = $_SERVER['HTTP_HOST'];
	$ftp_user_name = $_POST['ec_ftp_user'];
	$ftp_user_pass = $_POST['ec_ftp_pass'];
	
	// set up basic connection
	$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
	
	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	
	if( !$login_result ){
		
		die( "Could not connect to your server via FTP to backup your wp-easycart install. Please try re-entering your informaiton and try again." );
		
	}else{
		/* LETS WRITE THE CONNECTIONS HERE FOR FTP USERS ONLY */
		
		$temp = tmpfile();
		fwrite( $temp, $ec_conn_php );
		fseek( $temp, 0 );
		
		ftp_fput( $conn_id, $ec_conn_filename, $temp, FTP_BINARY );
		
		//Close the temp file to finish process
		fclose( $temp );
		
		ftp_site( $conn_id, 'CHMOD 0644 ' . $ec_conn_filename );
		
		if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/connection/ec_conn.php" ) ){
			$admin_conn_config = "complete";
		}else{
			$admin_conn_config = "failed";
		}
		
		/* LETS WRITE THE DATA FOLDER HERE!!! FOR FTP USERS ONLY */
		// Find the destination plugins folder
		
		if( !is_dir( $to ) ){
			ftp_mkdir( $conn_id, $to );
		
			ec_ftp_copy_recursive( $conn_id, $prefix_dir, $from . "products", $to . "products" );
			ec_ftp_copy_recursive( $conn_id, $prefix_dir, $from . "design", $to . "design"  );
			ec_ftp_copy_recursive( $conn_id, $prefix_dir, $from . "connection", $to . "connection" );
		}
	}
}

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

function install_demo_data( $install_dir ){
	//////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////
	//START DEMO DATA INSTALL SCRIPT
	//////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////	
	
	//set our datapack location
	$datapack_url = 'http://www.wpeasycart.com/sampledata';
	if( isset( $_POST['datapack'] ) ){
		if($_POST['datapack'] == 'standard_data') {
			$datapack_url = 'http://www.wpeasycart.com/sampledata/standard_demo';	
		}
	}

	// See if we can even write via http
	if( is_writable( $install_dir ) && ini_get( "allow_url_fopen" ) ){
		
		//INSERT DEMO DATA HERE
		if( !copy( "$datapack_url/standard_demo_install.sql",  $install_dir . "standard_demo_install.sql" ) ){
			// clean up the directory if anything remains
			die( "The plugin could not copy the demo install sql script from our WP EasyCart servers. Likely this was a network failure. We recommend trying again. If you continue to have issues, please submit a support ticket with WP EasyCart at www.wpeasycart.com. Please be sure to include FTP access to ensure a quick resolution." );
		}
			
	}else{ // Cannot install via http, use ftp
		
		if( isset( $_POST['ec_ftp_user'] ) && $_POST['ec_ftp_user'] !=  "" && isset( $_POST['ec_ftp_pass'] ) && $_POST['ec_ftp_pass'] != "" ){
			
			$wp_server_sql = $datapack_url . "/standard_demo_install.sql";
			$local_install_sql = $install_dir . "standard_demo_install.sql";
			
			// Could not open the file, lets write it via ftp!
			$ftp_server = $_SERVER['HTTP_HOST'];
			$ftp_user_name = $_POST['ec_ftp_user'];
			$ftp_user_pass = $_POST['ec_ftp_pass'];
			
			// set up basic connection
			$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
			
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			
			if( !$login_result ){
				die( "The plugin could not connect to your server via ftp. Please return to the last page, re-enter your login info, and try again. If you continue to have problems, please submit a support ticket at www.wpeasycart.com with your FTP information." );
			}else{
			
				$f1 = fopen( $wp_server_sql, "r" );
				
				// Sometimes helps to try and change the wp-easycart permissions
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir );
				
				// Copy the sql script from wp servers
				if( !ftp_fput( $conn_id, $local_install_sql, $f1, FTP_BINARY ) ){
					// clean up the directory if anything remains
					die( "The plugin could not copy $wp_server_sql to $local_install_sql. Likely this was a network failure, please try again. If the problem persists, contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket." );
				}
				// Close the file
				fclose( $f1 );
				
				// Try to change the permissions
				ftp_site( $conn_id, 'CHMOD 0777 ' . $local_install_sql );
				
			}// Close ftp login check
			
		}// Close check for FTP info
		else{
			die( "Please return to the last page and insert your FTP information to continue. Your wp-easycart directory is not writable and requires FTP access to continue. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
		} // Close section related to could not connect and didn't insert FTP info
	}// Close FTP option
		
	//Put up the database for website
	$url = $install_dir . "standard_demo_install.sql";
	// Load and explode the sql file
	$f = fopen( $url, "r" );
	if( !$f ){
		// clean up the directory if anything remains
		die("The plugin could not open the demo install script. This is most likely related to permissions issues. The copy was successful if you made it this far, so you should be able to find the install sql script in your wp-easycart plugin folder. Change the permissions to 644 to fix this issue. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance.");
	}
	$sqlFile = fread($f, filesize($url));
	$sqlArray = explode(';', $sqlFile);
	   
	//Process the sql file by statements
	foreach ($sqlArray as $stmt) {
	if (strlen($stmt)>3){
		$result = mysql_query($stmt);
		
		  if (mysql_error()){
			 $sqlErrorCode = mysql_errno();
			 $sqlErrorText = mysql_error();
			 $sqlStmt      = $stmt;
			 break;
		  }
	   }
	}
	
	// NOW LETS UPDATE THE LINKING STRUCTURE
	$db = new ec_db();
	$menulevel1_items = $db->get_menulevel1_items( );
	$menulevel2_items = $db->get_menulevel2_items( );
	$menulevel3_items = $db->get_menulevel3_items( );
	$product_list = $db->get_product_list( "", "", "", "" );
	$manufacturer_list = $db->get_manufacturer_list( );
	
	foreach( $menulevel1_items as $menu_item ){
		if( $menu_item->menulevel1_post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store menuid=\"" . $menu_item->menulevel1_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->menu1_name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_menu_post_id( $menu_item->menulevel1_id, $post_id );
		}
	}
	
	foreach( $menulevel2_items as $menu_item ){
		if( $menu_item->menulevel2_post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store submenuid=\"" . $menu_item->menulevel2_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->menu2_name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_submenu_post_id( $menu_item->menulevel2_id, $post_id );
		}
	}
	
	foreach( $menulevel3_items as $menu_item ){
		if( $menu_item->menulevel3_post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store subsubmenuid=\"" . $menu_item->menulevel3_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->menu3_name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_subsubmenu_post_id( $menu_item->menulevel3_id, $post_id );
		}
	}
	
	foreach( $product_list as $product_single ){
		if( $product_single['post_id'] == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product_single['model_number'] . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $product_single['title'],
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_product_post_id( $product_single['product_id'], $post_id );
		}
	}
	
	foreach( $manufacturer_list as $manufacturer_single ){
		if( $manufacturer_single->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturer_single->manufacturer_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $manufacturer_single->name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_manufacturer_post_id( $manufacturer_single->manufacturer_id, $post_id );
		}
	}
}

function install_demo_images( $install_dir ){
	
	//set our datapack location
	$datapack_url = 'http://www.wpeasycart.com/sampledata';
	if( isset( $_POST['datapack'] ) ){
		if($_POST['datapack'] == 'standard_data') {
			$datapack_url = 'http://www.wpeasycart.com/sampledata/standard_demo';	
		}
	}

	// See if we can even write via http
	if( is_writable( $install_dir ) && ini_get( "allow_url_fopen" ) ){
		
		if( !copy( "$datapack_url/standard_demo_assets.zip", $install_dir . "standard_demo_assets.zip") ){
			// clean up the directory if anything remains
			die( "The plugin could not copy the demo images from the WP EasyCart servers. Likely this was a network failure. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance. Tried to copy to " . $install_dir . "standard_demo_assets.zip." );
		}
			
	}else{ // Cannot install via http, use ftp
		
		if( isset( $_POST['ec_ftp_user'] ) && $_POST['ec_ftp_user'] !=  "" && isset( $_POST['ec_ftp_pass'] ) && $_POST['ec_ftp_pass'] != "" ){
			
			$wp_server_zip = $datapack_url . "/standard_demo_assets.zip";
			$local_install_zip = $install_dir . "standard_demo_assets.zip";
		
			// Could not open the file, lets write it via ftp!
			$ftp_server = $_SERVER['HTTP_HOST'];
			$ftp_user_name = $_POST['ec_ftp_user'];
			$ftp_user_pass = $_POST['ec_ftp_pass'];
			
			// set up basic connection
			$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
			
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			
			if( !$login_result ){
				die( "The plugin could not connect to your server via ftp. Please return to the last page, re-enter your login info, and try again. If you continue to have problems, please submit a support ticket at www.wpeasycart.com with your FTP information." );
			}else{
			
				$f2 = fopen( $wp_server_zip, "r" );
				
				// Sometimes helps to try and change the wp-easycart permissions
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir );
				
				// Copy the Zip
				if( !ftp_fput( $conn_id, $local_install_zip, $f2, FTP_BINARY ) ){
					// clean up the directory if anything remains
					die( "The plugin could not copy $wp_server_zip to $local_install_zip. Likely this was a network failure. Please try again. If the problem persists contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket." );
				}
				
				// Close the file
				fclose( $f2 );
				
				// Try to change the permissions on the server
				ftp_site( $conn_id, 'CHMOD 0777 ' . $local_install_zip );
				
				if( is_dir( $install_dir . 'products' ) ){
					// Rename the products folder for now.
					$res = ftp_rename( $conn_id, $install_dir . "products", $install_dir . "old-products" );
					if( !$res ){
						die( "Could not rename the products folder. You should delete the products folder and try again. If the problem persists, contact WP EasyCart at www.wpeasycart.com with a support ticket. \r\n" );	
					}
					
					//Lets do whatever we can to remove the old-products folder.
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir );
					
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/banners" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/downloads" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics1" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics2" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics3" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics4" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics5" );
					ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/swatches" );
					
					ftp_delete( $conn_id, $install_dir . "old-products/pics1/.htaccess" );
					ftp_delete( $conn_id, $install_dir . "old-products/pics2/.htaccess" );
					ftp_delete( $conn_id, $install_dir . "old-products/pics3/.htaccess" );
					ftp_delete( $conn_id, $install_dir . "old-products/pics4/.htaccess" );
					ftp_delete( $conn_id, $install_dir . "old-products/pics5/.htaccess" );
					ftp_delete( $conn_id, $install_dir . "old-products/swatches/.htaccess" );
					DeleteDirRecursive( $conn_id, $install_dir . "old-products" );
					
					if( is_dir( $install_dir . "old-products" ) ){
						echo "During installation, could not remove the old-products folder. Please delete this manually. \r\n";
					}
				}
				
			}// Close ftp login check
			
		}// Close check for FTP info
		else{
			die( "Please return to the last page and insert your FTP information to continue. Your wp-easycart directory is not writable and requires FTP access to continue. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
		} // Close section related to could not connect and didn't insert FTP info
	}// Close FTP option
	
	// First, make sure the client's server can extract the zip.
	if( !class_exists('ZipArchive') ){
		die( "We cannot unzip the product images folder to extract the demo images because you are missing the ZipArchive class in your php install. Please contact your hosting provider to resolve this. Additionally, you can contact WP EasyCart by submitting a support ticket at www.wpeasycart.com with FTP access to have the photos installed manually." );
	}
	
	$zip = new ZipArchive;
	$res = $zip->open( $install_dir . "standard_demo_assets.zip" );
	if( $res === TRUE ){
		// Now try to extract a new products folder.
		$res2 = $zip->extractTo( $install_dir );
		if( $res2 === FALSE ){
			// clean up the directory if anything remains
			die( "Could not extract the contents of the zip file. Often times this has to do with the products folder remaining and the permissions of the wp-easycart folder. Try deleting the products folder (and old-products folder if it exists) and change the permissions of the wp-easycart folder to 0777 for this install. Change the permissions back when the install is complete. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );	
			
		}
		
	} else {
		// An error occured opening the zip folder
		// clean up the directory if anything remains
		die( "The plugin could not open the zip folder, likely because it was never copied correctly. This can be caused by a network error. If the install zip and sql exist change the permissions to 0777, remove the products folder, remove the old-products folder if it exists, and temporarily set the wp-easycart plugin folder to 0777. Any of these could be a possible error. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
	}
	
	$zip->close();
	
	// Finish up by cleaning up the directory if anything remains
	if( !unlink( $install_dir . "standard_demo_assets.zip" ) ){
		
		ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "standard_demo_install.sql" );
		$res = ftp_delete( $conn_id, $install_dir . "standard_demo_install.sql" );
		if( !$res ){
			echo "Could not delete the demo install script during clean up. Please delete manually.\r\n";	
		}
		
		ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "standard_demo_assets.zip" );
		$res = ftp_delete( $conn_id, $install_dir . "standard_demo_assets.zip" );
		if( !$res ){
			echo "Could not delete the demo install zip during clean up. Please delete manually.\r\n";
		}
		
		ftp_site( $conn_id, 'CHMOD 0755 ' . $install_dir );
		
	}
	
	if( substr( sprintf( '%o', fileperms( $install_dir ) ), -4 ) == "0777" ){
		echo "Could not reset the wp-easycart plugin folder permissions to 0755, currently set at 0777. Please manually fix the permissions.";
	}
}

function uninstall_demo_data( $install_dir ){
	//////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////
	//START DEMO DATA REMOVAL SCRIPT
	//////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////	
	// Remove all wordpress posts
	$store_posts = get_posts( array( 'post_type' => 'ec_store', 'posts_per_page' => 5000 ) );
	foreach( $store_posts as $store_post ) {
		wp_delete_post( $store_post->ID, true);
	}
	
	//set our datapack location
	$datapack_url = 'http://www.wpeasycart.com/sampledata';
	if( isset( $_POST['datapack'] ) ){
		if($_POST['datapack'] == 'standard_data') {
			$datapack_url = 'http://www.wpeasycart.com/sampledata/standard_demo';	
		}
	}

	if( is_writable( $install_dir ) && ini_get( "allow_url_fopen" ) ){ //start http version
		
		//REMOVE JUST TABLE DATA
		copy("http://www.wpeasycart.com/sampledata/demo_uninstall.sql", $install_dir . "demo_uninstall.sql");
		
	}// close http version
	else{// start ftp version
		
		if( isset( $_POST['ec_ftp_user'] ) && $_POST['ec_ftp_user'] !=  "" && isset( $_POST['ec_ftp_pass'] ) && $_POST['ec_ftp_pass'] != "" ){
			$wp_server_sql = $datapack_url . "/demo_uninstall.sql";
			$local_uninstall_sql = $install_dir . "demo_uninstall.sql";
			
			// Could not open the file, lets write it via ftp!
			$ftp_server = $_SERVER['HTTP_HOST'];
			$ftp_user_name = $_POST['ec_ftp_user'];
			$ftp_user_pass = $_POST['ec_ftp_pass'];
			
			// set up basic connection
			$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
			
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			
			if( !$login_result ){
				die( "The plugin could not connect to your server via ftp. Please return to the last page, re-enter your login info, and try again. If you continue to have problems, please submit a support ticket at www.wpeasycart.com with your FTP information." );
				
			}else{ // Done all the checks, lets do an FTP delete.
				
				$f1 = fopen( $wp_server_sql, "r" );
				
				// Try to copy the sql uninstaller
				if( !ftp_fput( $conn_id, $local_uninstall_sql, $f1, FTP_BINARY ) ){
					// clean up the directory if anything remains
					die( "The plugin could not copy $wp_server_sql to $local_uninstall_sql. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
				}
				fclose( $f1 );
				
				// Try to change the permissions
				ftp_site( $conn_id, 'CHMOD 0777 ' . $local_uninstall_sql );
				
			}
			
		}else{
			die( "Please return to the last page and insert your FTP information to continue. Your wp-easycart directory is not writable and requires FTP access to continue. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
		}
		
	}//close ftp version
	
	//uninstall if it's there first
	$url = $install_dir . "demo_uninstall.sql";
	// Load and explode the sql file
	$f = fopen($url, "r") or die(" The plugin could not open the demo uninstall sql script from our WP EasyCart servers. This could be related to a network failure or permissions issues. Try setting your wp-easycart plugin folder to 0777 for now and try again. If you continue to have issues please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket.");
	$sqlFile = fread($f, filesize($url));
	$sqlArray = explode(';', $sqlFile);
	   
	//Process the sql file by statements
	foreach ($sqlArray as $stmt) {
	if (strlen($stmt)>3){
		$result = mysql_query($stmt);
		  if (!$result){
			 $sqlErrorCode = mysql_errno();
			 $sqlErrorText = mysql_error();
			 $sqlStmt      = $stmt;
			 break;
		  }
	   }
	}
	
	// Finish up by cleaning up the directory if anything remains
	if( !unlink( $install_dir . "demo_uninstall.sql" ) ){
		// Do the FTP version of the cleanup
		$res = ftp_delete( $conn_id, $install_dir . "demo_uninstall.sql" );
		if( !$res ){
			echo "Could not delete the demo install script during clean up. Please delete manually.\r\n";	
		}
	}
}

function uninstall_demo_images( $install_dir ){
	//////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////
	//START DEMO DATA REMOVAL SCRIPT
	//////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////	
	//set our datapack location
	$datapack_url = 'http://www.wpeasycart.com/sampledata';
	if( isset( $_POST['datapack'] ) ){
		if($_POST['datapack'] == 'standard_data') {
			$datapack_url = 'http://www.wpeasycart.com/sampledata/standard_demo';	
		}
	}

	if( is_writable( $install_dir ) && ini_get( "allow_url_fopen" ) ){ //start http version
		
		//COPY CLEAN SET OF PRODUCTS FOLDERS
		copy( "http://www.wpeasycart.com/sampledata/clean_assets.zip", $install_dir . "clean_assets.zip" );
		
	}// close http version
	else{// start ftp version
		
		if( isset( $_POST['ec_ftp_user'] ) && $_POST['ec_ftp_user'] !=  "" && isset( $_POST['ec_ftp_pass'] ) && $_POST['ec_ftp_pass'] != "" ){
			$wp_server_zip = $datapack_url . "/clean_assets.zip";
			$local_uninstall_zip = $install_dir . "clean_assets.zip";
		
			// Could not open the file, lets write it via ftp!
			$ftp_server = $_SERVER['HTTP_HOST'];
			$ftp_user_name = $_POST['ec_ftp_user'];
			$ftp_user_pass = $_POST['ec_ftp_pass'];
			
			// set up basic connection
			$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
			
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			
			if( !$login_result ){
				die( "The plugin could not connect to your server via ftp. Please return to the last page, re-enter your login info, and try again. If you continue to have problems, please submit a support ticket at www.wpeasycart.com with your FTP information." );
				
			}else{ // Done all the checks, lets do an FTP delete.
				
				$f2 = fopen( $wp_server_zip, "r" );
				
				// Try to copy the zip for fresh products folder
				if( !ftp_fput( $conn_id, $local_uninstall_zip, $f2, FTP_BINARY ) ){
					// clean up the directory if anything remains
					die( "The plugin could not copy $wp_server_zip to $local_install_zip. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
				}
				fclose( $f2 );
				
				// Try to change the permissions
				ftp_site( $conn_id, 'CHMOD 0777 ' . $local_uninstall_zip );
				
				// Rename the products folder for now.
				$res = ftp_rename( $conn_id, $install_dir . "products", $install_dir . "old-products" );
				if( !$res ){
					die( "Could not rename the products folder. This means you still have all of the product data on your site. The best way to fix this issue is to delete the products folder manually from your wp-easycart plugin folder (also delete the old-products folder if it exists). Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance. \r\n" );
				}
				
				// Try to change the permissions of the entire directory.
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir );
				
				// Do what we can in an attempt of deleting the old products folder
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/banners" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/downloads" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics1" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics2" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics3" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics4" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/pics5" );
				ftp_site( $conn_id, 'CHMOD 0777 ' . $install_dir . "old-products/swatches" );
				
				ftp_delete( $conn_id, $install_dir . "old-products/pics1/.htaccess" );
				ftp_delete( $conn_id, $install_dir . "old-products/pics2/.htaccess" );
				ftp_delete( $conn_id, $install_dir . "old-products/pics3/.htaccess" );
				ftp_delete( $conn_id, $install_dir . "old-products/pics4/.htaccess" );
				ftp_delete( $conn_id, $install_dir . "old-products/pics5/.htaccess" );
				ftp_delete( $conn_id, $install_dir . "old-products/swatches/.htaccess" );
				DeleteDirRecursive( $conn_id, $install_dir . "old-products" );
				
				if( is_dir( $install_dir . "old-products" ) ){
					echo "During uninstallation of the demo data the old-products folder could not be deleted. Please do so manually. ";
				}
			}
			
		}else{
			die( "Please return to the last page and insert your FTP information to continue. Your wp-easycart directory is not writable and requires FTP access to continue. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
		}
		
	}//close ftp version
	
	$zip = new ZipArchive;
	if( $zip->open( $install_dir . "clean_assets.zip" ) ){
		if( !$zip->extractTo( $install_dir ) )
			die( "Could not extract the contents of the fresh products zip file. A lot of times this is because of either permissions or ownership issues. Please manually delete the products folder (and old-products folder if it exists) from the wp-easycart plugin folder, change the permissions of the wp-easycart folder to 0777, change the permissions of the clean_assets.zip to 0777, and try again. We will install a fresh version of the products folder for you upon successful un-installation. Remember to change the permissions of the wp-easycart folder back once complete. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );	
		$zip->close();
	} else {
		die( "Could not complete the unzip, an unknown error has occured. Please contact WP EasyCart at www.wpeasycart.com with FTP access in a support ticket if you need assistance." );
	}
	
	// Finish up by cleaning up the directory if anything remains
	if( unlink( $install_dir . "clean_assets.zip" ) ){
		
		if( is_dir( $install_dir . "old-products" ) ){
			echo "Could not delete the old-products folder during clean up. Please delete manually.\r\n";
		}
		
		// Try to change back the dir permissions.
		if( substr( sprintf( '%o', fileperms( $install_dir ) ), -4 ) == "0777" ){
			echo "Could not reset the wp-easycart plugin folder permissions to 0755, currently set at 0777. Please manually fix the permissions.";
		}
		
	}else{ // Do the FTP version of the cleanup
		
		$res = ftp_delete( $conn_id, $install_dir . "clean_assets.zip" );
		if( !$res ){
			echo "Could not delete the demo install zip during clean up. Please delete manually.\r\n";
		}
		
		if( is_dir( $install_dir . "old-products" ) ){
			echo "Could not delete the old-products folder during clean up. Please delete manually.\r\n";
		}
		
		// Try to change back the dir permissions.
		ftp_site( $conn_id, 'CHMOD 0755 ' . $install_dir );
		
	}
	
	if( substr( sprintf( '%o', fileperms( $install_dir ) ), -4 ) == "0777" ){
		echo "Could not reset the wp-easycart plugin folder permissions to 0755, currently set at 0777. Please manually fix the permissions.";
	}
}

?>
<script type="text/javascript">
	function install_alert() {
		var answer = confirm ("Are you sure you want to install demo data?  We will attempt to retrieve sample data and product images from the EasyCart servers and place this information into your system.")
		if (answer)
		return true;
		else
		return false;
	}
	function uninstall_alert() {
		var answer = confirm ("Are you sure you want to uninstall demo data?  Doing so will remove ALL of the products, options, and orders in EasyCart.  This will create a clean empty eCommerce system for you.")
		if (answer)
			return true;
		else
			return false;
	}
	function runchecklist() {
		window.open('<?php echo plugins_url('ec_checklist.php', __FILE__); ?>', '_blank', 'width=950, height=800');	
	}
</script>



<div class="wrap">
<?php if( !$license->is_registered() && !$license->is_lite_version() ) { ?>
<div class="ribbon">You are running the WP EasyCart FREE version. To purchase the LITE or FULL version and unlock the full selling potential visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a> and purchase a license.</div>
<?php }else if( $license->is_lite_version() && $license->show_lite_message() ) { ?>
<div class="ribbon">You are running the WP EasyCart Lite version. To learn more about what you are missing with the Full version visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a>. To dismiss this banner <a href="?page=ec_install&dismiss_lite_banner=true">click here.</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

<?php if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/connection/ec_conn.php" ) && !file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/connection/ec_conn.php" ) ){ ?>
<div class="ec_special_note"><strong>Administration Console Connection Problem</strong>: Please notice that during the activation of your WP EasyCart the necessary connection file could not be written. To write this file now, simply enter your FTP information and press submit.</div>
<?php if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/connection/ec_conn.php" ) ){ ?>
<div class="ec_special_note"><strong>WP EasyCart Data Folder Problem</strong>: During the activation of your plugin, the necessary data folder was not able to create. Enter your FTP information below to copy the necessary data over. This is important to prevent data loss during upgrades. Notice, this process takes a while via FTP, please be patient.</div>
<?php }?>
<form action="<?php echo admin_url( "admin.php?page=ec_install&save_conn=yes" ); ?>" method="post">
<table>
	<tr><td colspan="2">Please enter FTP info to finish installation/activation:</td></tr>
    <tr><td>FTP User:</td><td><input type="text" name="ec_ftp_user" /></td></tr>
    <tr><td>FTP Pass:</td><td><input type="password" name="ec_ftp_pass" /></td></tr>
    <tr><td></td><td><input type="submit" value="Finish Installation" />
</table>
</form>
<?php }?>
<?php if( isset( $admin_conn_config ) && $admin_conn_config == "failed" ){ ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Connections file FAILED to create.</strong></p></div>
<?php }else if( isset( $admin_conn_config ) && $admin_conn_config == "complete" ){ ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Connections file created successfully.</strong></p></div>
<?php }?>
<?php if(isset($_POST['isupdate'])) { ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  
<?php if(isset($_POST['isinsertdemodata'])){?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Sample Data Installed Successfully!</strong> If you do not see the sample data on your website, you may wish to contact an EasyCart professional via chat or email and see if we can install it for you.</p></div>
<?php }?>
<?php if(isset($_POST['isdeletedemodata'])){?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Sample Data Un-Installed Successfully!</strong> Your sample data should have been removed from your website.</p></div>
<?php }?>
<div class="ec_contentwrap">
    
    
    <h2>Installation Steps</h2>
    <form method="post" action="options.php">
      <p>
        <?php settings_fields( 'ec-store-install-group' ); ?>
      </p>
      <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            <tr valign="top">
                <td bgcolor="#F2FFF2" class="platformheading"><b>4 Easy Steps to Install the WP EasyCart:</b></td>
                <td bgcolor="#F2FFF2" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
            	<td colspan="2" align="left" scope="row"><ol>
                    <li>Create 3 new pages in WordPress: An example of the three page names would be 'Store', 'Shopping Cart', and 'My Account'. </li>
                    <li>Open each page you just created and enter the WordPress shortcode to apply the eCommerce system to those pages. A short code is a word in brackets that is replaced by a plugin or widget when displayed to the user. 
                      <ol>
                      <li>Open the 'Store' page and type <strong>[ec_store] </strong>in the page text editor.</li>
                      <li>Open 'Shopping Cart' page and type <strong>[ec_cart]</strong><strong> </strong>in the page text editor.</li>
                      <li>Open 'My Account' page and type <strong>[ec_account] </strong><strong> </strong>in the page text editor.</li>
                    </ol> 
                    </li>
                    <li>Select the pages you just created in the select boxes below. The will help the WP EasyCart link your store up correctly. That's it! Now you can configure your store or access the admin console area.</li>
                    <li>Download the Administrative Console for your PC, Mac, Laptop, iPad, or Android devices by visiting the<a href="admin.php?page=ec_adminconsole"> admin console</a> menu on the left. This small download will install  using Adobe technology and lets you view orders, manage products and images, control your customer accounts, promotions, and more!</li>
                    <li>At this point the store is connected and ready to go. If you want to see how it looks, add the demo data below. If you like the plugin and want to go through the complete setup (get your store fully functional and selling to customers) then you should try our <a href="?page=ec_checklist">setup wizard here</a>.</li>
                    </ol>
				</td>
            </tr>
            <tr valign="top">
                <td colspan="2" align="left" scope="row">
                <div class="ec_info_note"><strong>Helpful Links</strong>: You can view a full installation manual at <a href="http://www.wpeasycart.com/docs" target="_blank">www.wpeasycart.com/docs</a>. We also offer full video tutorials and walk-throughs of various capablilities of the store, installation, and product setup; just view our <a href="http://www.wpeasycart.com/video-tutorials/" target="_blank">video library</a> for more information. If you would like to purchase a licensed version of our software, you can check our <a href="http://www.wpeasycart.com/wordpress-shopping-cart/" target="_blank">pricing here.</a> We do custom design and development and are here to support the software, so don't hesitate to ask us questions.</div>
                <div class="ec_special_note"><strong>Permalink Settings</strong>: Please check your permalink settings in the admin under <strong>"Settings"->"Permalinks"</strong>. The WP EasyCart system currently works best with the <strong>post name</strong> permalink method.</div>
                </td>
            </tr>
            
            <tr valign="top">
                <td class="platformheading">Connect Store Pages: </td>
                <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            
            <tr valign="top">
              <td colspan="2" align="left" scope="row">Configure the following pages to match your WordPress setup. After you have created 3 new pages and added the shortcode using the steps above, simply match up the correct page with the correct store function below.</td>
            </tr>
            <tr valign="top">
                <td width="36%" align="left" class="itemheading" scope="row">Store Page:</td>
                <td width="64%" valign="top">
                    <?php wp_dropdown_pages(array('name'=>'ec_option_storepage', 'selected'=>get_option('ec_option_storepage'))); ?>
                <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Store Page</em>Choose the WordPress page that will represent the store system of your e-commerce system.  Typically this is a page called 'Online Store' or 'Shop' or 'Products'.</span></a>
                    
                    </td>
            </tr>
            <tr valign="top">
                <td align="left" class="itemheading" scope="row">Cart Page:</td>
            
                <td valign="top">
                    <?php wp_dropdown_pages(array('name'=>'ec_option_cartpage', 'selected'=>get_option('ec_option_cartpage'))); ?>
              <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Cart Page</em>Choose the WordPress page that will represent the cart system of your e-commerce system.  Typically this is a page called 'My Cart' or 'Shop Cart' or 'Checkout'.</span></a>
                     </td>
            </tr>
            <tr valign="top">
                <td align="left" class="itemheading" scope="row">Account Page:</td>
            
                <td valign="top">
                    <?php wp_dropdown_pages(array('name'=>'ec_option_accountpage', 'selected'=>get_option('ec_option_accountpage'))); ?>
                    <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Store Page</em>Choose the WordPress page that will represent the account system of your e-commerce system.  Typically this is a page called 'My Account' or 'Account'.</span></a>
                    
                </td>
            </tr>
            <tr valign="top">
              <td colspan="2" align="left" class="itemheading" scope="row"><span class="submit">
                <input type="hidden" name="isupdate" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
              </span></td>
            </tr>
            
            <tr valign="top">
                <td align="left" scope="row">&nbsp;</td>
            
                <td valign="top">&nbsp;</td>
            </tr>
              
      </table>
  	</form>
    
    
    
    
        <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
        	<tr valign="top">
                <td align="left" class="platformheading" scope="row">Install and Uninstall Sample  Data:</td>
                <td valign="top" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        	</tr>
            <tr valign="top">
            	<td colspan="2" align="left" scope="row">
                <p>If you would like to install or uninstall the sample data to your store, you may do so below. Sample data is an easy way to have sample products and orders in your administration area and store to visually see what it may look like. Please note that this will remove and/or replace any products, orders, custom users, shipping settings, coupons, giftcards, and other custom store data that you may have built into the EasyCart system. It will not remove any WordPress information.</p>
                </td>
            </tr>
        	<tr valign="top">
                <td colspan="2" align="left" scope="row">
                	<div class="ec_install_left">
                    <form method="post" action="#" name="installdataform" id="installdataform">
                    <input type="hidden" name="isinsertdemodata" id="isinsertdemodata" value="1" />
                	<table>
                    <tr>
                    	<td>Data Pack:</td>
                    	<td>
                        	<select name="datapack" id="datapack">
                            <option value="standard_data">Standard Demo Data</option>
                            </select> 
                        </td>
                    </tr>
                    
                    <?php 
					$install_dir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
					if( !is_writable( $install_dir ) ){
					?>
                    <tr>
                    	<td colspan="2">FTP Information is required for some servers. If you see an error try entering your ftp access information.</td>
                    </tr>
                    <tr>
                    	<td>Optional: FTP User:</td>
                        <td><input type="text" name="ec_ftp_user" /></td>
                    </tr>
                    <tr>
                    	<td>Optional: FTP Pass:</td>
                        <td><input type="password" name="ec_ftp_pass" /></td>
                    </tr>
                    <?php }?>
                    <tr>
                    	<td></td>
                        <td><input type="submit" class="button-primary" value="Install Sample Data" onclick="return install_alert()" /></td>
                    </tr>
                    </table>
                    
                    
                    </form>
                	</p>
                    </div>
                    
                    <div class="ec_install_right">
    				<form method="post" action="#" name="deletedataform" id="deletedataform">
                    <input type="hidden" name="isdeletedemodata" id="isdeletedemodata" value="1" />
                    <table>
                    <?php 
					$install_dir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
					if( !is_writable( $install_dir ) ){
					?>
                    <tr>
                    	<td colspan="2">FTP Information is required for some servers. If you see an error try entering your ftp access information.</td>
                    </tr>
                    <tr>
                    	<td>Optional: FTP User:</td>
                        <td><input type="text" name="ec_ftp_user" /></td>
                    </tr>
                    <tr>
                    	<td>Optional: FTP Pass:</td>
                        <td><input type="password" name="ec_ftp_pass" /></td>
                    </tr>
                    <?php }?>
                    <tr>
                    	<td></td>
                        <td><input type="submit" class="button-primary" value="Un-Install Sample Data" onclick="return uninstall_alert()" /></td>
                    </tr>
                    </table>
                    </form>
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" class="platformheading" scope="row">Having Trouble Installing Sample Data?</td>
                <td valign="top" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        	</tr>
            <tr valign="top">
            	<td colspan="2" align="left" scope="row">
                <p>Some servers have difficulty copying the sample data from the wpeasycart servers, others get the files copied but do not have write access to unzip and copy the files into the products folder. Please read the <a href="http://wpeasycart.com/docs/1.0.0/installation/sample_data.php">docs page here</a> to learn about manual sample data installation/uninstallation.</p>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" class="platformheading" scope="row">Server Diagnostics and Checklist</td>
                <td valign="top" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        	</tr>
            <tr valign="top">
            	<td colspan="2" align="left" scope="row">
                <p>WP EasyCart is an advanced plugin and more complex in design than many in WordPress.  If you continue to have issues with installation or need to verify that certain configurations qualify on your servers, you can run this quick checklist that will test your servers settings.  This test will verify certain PHP and server settings, and also complete a read/write test of your directories to ensure the EasyCart system can be installed and operate.  This is a minimal test and other settings may cause problems, but these are the most common.  If you come across a failed request, show this test to your web host and they will usually fix the issues.</p>
                
                <input type="button" class="button-primary" value="Run Server Check" onclick="runchecklist()" />
                </td>
            </tr>
        </table>
    
    
    </div>
</div>