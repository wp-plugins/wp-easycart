<?php 

$validate = new ec_validation; 
$license = new ec_license;

if(isset($_POST['isupdate'])){
	
	//update options
	update_option( 'ec_option_base_theme', $_POST['ec_option_base_theme'] );
	update_option( 'ec_option_base_layout', $_POST['ec_option_base_layout'] );
	
}


//helper function for uploader
function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
       if ('.' === $file || '..' === $file) continue;
       if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
       else unlink("$dir/$file");
   }
 
   rmdir($dir);
}
 
//////////////////////////////////////////////////////
//theme uploader
//////////////////////////////////////////////////////
if( $_FILES && $_FILES["theme_file"]["name"] ) {
	
	$filename = $_FILES["theme_file"]["name"];
	$source = $_FILES["theme_file"]["tmp_name"];
	$type = $_FILES["theme_file"]["type"];
	
	$theme_message = "";
	
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
	
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$theme_message .= " The theme file you are trying to upload is not a .zip file. Please try again.<br>";
	}
	/* PHP current path */
	$path = dirname(__FILE__).'/';
	$filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
	$filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
	$targetdir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/". $filenoext; // target directory
	$targetzip = $path . $filename; // target zip file
	
	if( is_writable( $install_dir ) ){ // If we can create the dir, do it, otherwise ftp it.
		if (is_dir($targetdir))  rmdir_recursive ( $targetdir);
		mkdir($targetdir, 0777);
		if( is_dir( $targetdir ) )
			$theme_message .= " The theme directory was created successfully.<br>";
		else
			$theme_message .= " The theme directory was NOT created, please try again.<br>";
	  
	}else{
		// Could not open the file, lets write it via ftp!
		$ftp_server = $_SERVER['HTTP_HOST'];
		$ftp_user_name = $_POST['ec_ftp_user1'];
		$ftp_user_pass = $_POST['ec_ftp_pass1'];
		
		// set up basic connection
		$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
		
		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		if( !$login_result ){
			$theme_message .= "The plugin could not connect to your server via FTP. Please enter your FTP info and try again.<br>";
		}else{
			ftp_mkdir( $conn_id, $targetdir );
			ftp_site( $conn_id, "CHMOD 0777 " . $targetdir );
			if( is_dir( $targetdir ) )
				$theme_message .= " The theme directory was created successfully via FTP.<br>";
			else
				$theme_message .= " The theme directory was NOT created, failed via FTP, please try again.<br>";
		}
	}
  	
	if( !is_dir( $targetdir ) ){
		// Already added message about the dir.
	}else{
		$zip = new ZipArchive();
		$x = $zip->open( $_FILES["theme_file"]["tmp_name"] );  // open the zip file to extract 
		if( $x === true ) {
			$zip->extractTo( $targetdir ); // place in the directory with same name  
			$zip->close();
			
			unlink($targetzip);
			$theme_message .= "Your EasyCart theme file was uploaded and unpacked. You may select from the Base Design above.";
		}else{
			$theme_message .= "Could not open the uploaded zip file. Please try again.";
		}
	}
}
	
//////////////////////////////////////////////////////
//layout uploader
//////////////////////////////////////////////////////
if( $_FILES && $_FILES["layout_file"]["name"] ) {
	
	$filename = $_FILES["layout_file"]["name"];
	$source = $_FILES["layout_file"]["tmp_name"];
	$type = $_FILES["layout_file"]["type"];
	
	$layout_message = "";
	
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
	
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$layout_message .= " The layout file you are trying to upload is not a .zip file. Please try again.<br>";
	}
	/* PHP current path */
	$path = dirname(__FILE__).'/';
	$filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
	$filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
	$targetdir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/". $filenoext; // target directory
	$targetzip = $path . $filename; // target zip file
	
	if( is_writable( $install_dir ) ){ // If we can create the dir, do it, otherwise ftp it.
		if (is_dir($targetdir))  rmdir_recursive ( $targetdir);
		mkdir($targetdir, 0777);
		if( is_dir( $targetdir ) )
			$layout_message .= " The layout directory was created successfully.<br>";
		else
			$layout_message .= " The layout directory was NOT created, please try again.<br>";
	  
	}else{
		// Could not open the file, lets write it via ftp!
		$ftp_server = $_SERVER['HTTP_HOST'];
		$ftp_user_name = $_POST['ec_ftp_user2'];
		$ftp_user_pass = $_POST['ec_ftp_pass2'];
		
		// set up basic connection
		$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
		
		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		if( !$login_result ){
			$layout_message .= "The plugin could not connect to your server via FTP. Please enter your FTP info and try again.<br>";
		}else{
			ftp_mkdir( $conn_id, $targetdir );
			ftp_site( $conn_id, "CHMOD 0777 " . $targetdir );
			if( is_dir( $targetdir ) )
				$layout_message .= " The layout directory was created successfully via FTP.<br>";
			else
				$layout_message .= " The layout directory was NOT created, failed via FTP, please try again.<br>";
		}
	}
  	
	if( !is_dir( $targetdir ) ){
		// Already added message about the dir.
	}else{
		$zip = new ZipArchive();
		$x = $zip->open( $_FILES["layout_file"]["tmp_name"] );  // open the zip file to extract 
		if( $x === true ) {
			$zip->extractTo( $targetdir ); // place in the directory with same name  
			$zip->close();
			
			unlink($targetzip);
			$layout_message .= "Your EasyCart layout file was uploaded and unpacked. You may select from the Base Design above.";
		}else{
			$layout_message .= "Could not open the uploaded zip file. Please try again.";
		}
	}
}

?>

<div class="wrap">
<?php if(!$license->is_registered()) {; ?>
<div class="ribbon">This banner appears when you have a WordPress EasyCart FREE version installed. To purchase the FULL version, you must purchase a license at <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

<?php if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true) { ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  


<div class="ec_contentwrap">
 
    <h2>Base Design</h2>
    
    <form method="post" action="options.php">
		<?php settings_fields( 'ec-base-design-group' ); ?>
        <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            
            <tr valign="top">
              <td width="27%" class="platformheading" scope="row">Choose your eCommerce Design Template</td>
              <td width="73%" class="platformheadingimage" scope="row">
              	<img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" />
              </td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row"><p>EasyCart provides you with high quality designed eCommerce templates that can be mixed and matched to meet your specific needs in design and layout. The following Base Design will change the design and layout of the EasyCart plugin system. This includes the store product display and product details display, the shopping cart and checkout system, and the customer account section. These three sections are the core focus of the EasyCart plugin, and require custom themes outside the standard WordPress theme.</p>
              <p>To make things even easier, we have designed matching WordPress themes, so the theme of your website specifically matches the theme of your EasyCart. But even if you have your own WordPress theme, there is no reason you can't use one of our EasyCart plugin themes to mix and match design.</p>
              <p><strong><em>Theme</em></strong> = The overall styling such as colors, borders, background designs, and button design and colors.<br />
              <strong><em>Layout</em></strong> = The overall placement or arrangement of page elements, such as title and image locations, column widths, and general page layout.</p></td>
            </tr>
            
            <tr valign="top">
              <td class="itemheading" scope="row">Choose your Base <em>Theme</em>:<br />
                <span class="itemsubheading">(This will become default design for all sections)</span></td>
              <td scope="row"><select name="ec_option_base_theme" id="ec_option_base_theme" onchange="theme_change();">
		          <?php
						$dir = '../wp-content/plugins/' . EC_PLUGIN_DIRECTORY . '/design/theme/';
						$scan = scandir( $dir );
						foreach( $scan as $key => $val ) {
							
							if ( is_dir( $dir . "/" . $val ) ) {
								if($val != "." && $val != ".."){
									echo "<option value=\"".$val."\"";
									if( get_option('ec_option_base_theme') == $val){ 
										echo " selected=\"selected\"";
									}
									
									echo ">" . $val . "</option>\n";
								}
							}
							
						}
						?>
		          </select> <a href="#" class="ec_tooltip">
<img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" />
<span class="ec_custom ec_help">
<img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" />

<em>Base Theme</em>

When you upload a new theme to your site, you will see them appear here.  This setting will change all of your EasyCart plugin themes to the default you choose here.

</span>
</a>
                </td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row">Choose your Base<em> Layout</em>:<br />
              <span class="itemsubheading">(This will become default layout for all sections)</span></td>
              <td scope="row"><select name="ec_option_base_layout" id="ec_option_base_layout" onchange="layout_change();">
		          <?php
						$dir = '../wp-content/plugins/' . EC_PLUGIN_DIRECTORY . '/design/layout/';
						$scan = scandir( $dir );
						foreach( $scan as $key => $val ) {
							
							if ( is_dir( $dir . "/" . $val ) ) {
								if($val != "." && $val != ".."){
									echo "<option value=\"".$val."\"";
									if( get_option('ec_option_base_layout') == $val){ 
										echo " selected=\"selected\"";
									}
									
									echo ">" . $val . "</option>\n";
								}
							}
							
						}
						?>
		          </select>
                <a href="#" class="ec_tooltip"> <img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /> <span class="ec_custom ec_help"> <img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /> <em>Base Layout</em> When you upload a new layout to your site, you will see them appear here.  This setting will change all of your EasyCart plugin layouts to the default you choose here. </span> </a></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row">
              	<p class="submit">
                <input type="hidden" name="isupdate" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
              </td>
            </tr>
            </table>
            </form> 
            
            <form enctype="multipart/form-data" method="post" action="">
            <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            <tr valign="top">
              <td width="27%" class="platformheading" scope="row">Upload a Custom EasyCart Plugin Theme</td>
              <td width="73%" class="platformheadingimage" scope="row"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row"><p>If you have a custom theme for the EasyCart plugin, you can upload it here. These themes are separate from the WordPress themes, and specifically designed to theme the store, shopping cart, checkout, and account pages of the plugin. These themes do <em>NOT</em> theme the <em>WordPress </em>system, you should upload WordPress themes in the appropriate location.</p>
              <p>Don't have a custom design pack? Get one here at <a href="http://www.wpeasycart.com" target="_blank">www.wpeasycart.com</a> or simply look through our demos to see if you find one you like!</p></td>
            </tr>
           
            <tr valign="top">
              <td class="itemheading" scope="row">Choose EasyCart Plugin <em>Theme</em> File:</td>
              <td scope="row">
                <input type="file" name="theme_file" />
                    
              <a href="#" class="ec_tooltip"> <img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /> <span class="ec_custom ec_help"> <img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /> <em>EasyCart Themes</em> To get more EasyCart themes, you can visit www.wpeasycart.com and browser our catalog of WordPress and EasyCart themes.</span> </a>              </td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row" colspan="2">Some servers require FTP access</td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row">FTP User Name:</td>
              <td scope="row"><input type="text" name="ec_ftp_user1" /></td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row">FTP Password:</td>
              <td scope="row"><input type="password" name="ec_ftp_pass1" /></td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row"></td>
              <td scope="row"><input type="submit" name="submit" value="Upload" /></td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row"></td>
              <td scope="row" class="ec_upload_success"><?php if( isset( $theme_message ) && $theme_message != "") echo "<p>$theme_message</p>"; ?>
              </td>
            </tr> 
            <tr valign="top">
              <td class="itemheading" scope="row">Choose EasyCart Plugin<em> Layout</em> File:</td>
              <td scope="row">
                    <input type="file" name="layout_file" />
                    <a href="#" class="ec_tooltip"> <img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /> <span class="ec_custom ec_help"> <img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /> <em>EasyCart Layouts</em> To get more EasyCart themes, you can visit www.wpeasycart.com and browser our catalog of WordPress and EasyCart themes.</span> </a> 
              </td>
            </tr>  
            <tr valign="top">
              <td class="itemheading" scope="row" colspan="2">Some servers require FTP access</td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row">FTP User Name:</td>
              <td scope="row"><input type="text" name="ec_ftp_user2" /></td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row">FTP Password:</td>
              <td scope="row"><input type="password" name="ec_ftp_pass2" /></td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row"></td>
              <td scope="row"><input type="submit" name="submit" value="Upload" /></td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row"></td>
              <td scope="row" class="ec_upload_success"><?php if( isset( $layout_message ) && $layout_message != "" ) echo "<p>$layout_message</p>"; ?>
              </td>
            </tr>   
            </table>
      
		</form>
    </div>
</div>