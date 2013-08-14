<?php 

$validate = new ec_validation; 
$license = new ec_license;

if(isset($_POST['isupdate'])){
	
	//update options
	update_option( 'ec_option_storepage', $_POST['ec_option_storepage'] );
	update_option( 'ec_option_cartpage', $_POST['ec_option_cartpage'] );
	update_option( 'ec_option_accountpage', $_POST['ec_option_accountpage'] );
	update_option( 'ec_option_currency', $_POST['ec_option_currency'] );
	update_option( 'ec_option_sideMenuOnProducts', $_POST['ec_option_sideMenuOnProducts'] );
	update_option( 'ec_option_sideMenuOnProductDetails', $_POST['ec_option_sideMenuOnProductDetails'] );
	update_option( 'ec_option_stylesheettype', $_POST['ec_option_stylesheettype'] );
	update_option( 'ec_option_googleanalyticsid', $_POST['ec_option_googleanalyticsid'] );
	update_option( 'ec_option_num_prods_per_row', $_POST['ec_option_num_prods_per_row'] );
	update_option( 'ec_option_categories_title', $_POST['ec_option_categories_title'] );
	update_option( 'ec_option_manufacturers_title', $_POST['ec_option_manufacturers_title'] );
	update_option( 'ec_option_pricepoints_title', $_POST['ec_option_pricepoints_title'] );
	update_option( 'ec_option_guest_text', $_POST['ec_option_guest_text'] );
	update_option( 'ec_option_submit_order_text', $_POST['ec_option_submit_order_text'] );
	
	
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
	
}else if(isset($_POST['isinsertdemodata'])){
	//INSERT DEMO DATA HERE
	//Put up the databse for website
	$url = plugin_dir_path(__FILE__) . 'demo.sql';
	// Load and explode the sql file
	$f = fopen($url, "r+") or die("CANNOT OPEN SQL SCRIPT");
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
	
	//COPY PRODUCTS HERE
	copy("http://www.levelfourstorefront.com/downloads/wordpress/demo.zip", plugin_dir_path(__FILE__) . "/demo.zip");
	
	$zip = new ZipArchive;
	$res = $zip->open(plugin_dir_path(__FILE__) . "/demo.zip");
	if ($res === TRUE) {
		$zip->extractTo(plugin_dir_path(__FILE__) . "/");
		$zip->close();
	} else {
		echo 'Unzip Failed';
	}
	
}

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

?>
<div class="wrap">
<?php if( !$license->is_registered() && !$license->is_lite_version() ) { ?>
<div class="ribbon">You are running the WP EasyCart FREE version. To purchase the LITE or FULL version and unlock the full selling potential visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a> and purchase a license.</div>
<?php }else if( $license->is_lite_version() && $license->show_lite_message() ) { ?>
<div class="ribbon">You are running the WP EasyCart Lite version. To learn more about what you are missing with the Full version visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a>. To dismiss this banner <a href="?page=ec_adminconsole&dismiss_lite_banner=true">click here.</a></div>
<?php }?>
<h2>
  
  <img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" /></h2>
<div class="ec_contentwrap">
   
    <h2>Administrative Console </h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="55" colspan="2"><p>The WordPress EasyCart administrative console software is available for Desktops and popular tablet and phone systems.  The administrative console software allows you to manage day to day operations of your store, including Orders, Products, Users, Marketing, and more!</p>
        <p><em><strong>Note:</strong> The administrative console is not downloaded or associated with WordPress and/or it's site. This software is downloaded via 3rd party systems such as Apple iTunes, the Google Play store, and WP Easy Cart.</em></p></td>
      </tr>
      <tr>
        <td height="25" class="platformheading">Desktop and Laptop Users</td>
        <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('images/windows-apple-linux.png', __FILE__); ?>" width="120" height="40" /></td>
      </tr>
      <tr>
        <td height="10" colspan="2"></td>
      </tr>
      <tr>
        <td width="600" align="center">
        
        <script type="text/javascript" src="<?php echo plugins_url('AIR_badge/swfobject.js', __FILE__); ?>"></script>
        
        <!-- BEGIN EMBED CODE -->
            
            <!-- IMPORTANT: Make sure you also copy the swfobject script tag from the head above -->
            
            <div id="flashcontent" style="width:600px; height:360px;">
                <strong>Please upgrade your Flash Player</strong>
                This is the content that would be shown if the user does not have Flash Player 10.0.0 or higher installed.
            </div>
        
          <script type="text/javascript">
                // <![CDATA[
                
                // version 9.0.115 or greater is required for launching AIR apps.
                var so = new SWFObject("<?php echo plugins_url('AIR_badge/AIRInstallBadge.swf', __FILE__); ?>", "Badge", "600", "360", "10.0.0", "#FFFFFF");
                so.useExpressInstall('<?php echo plugins_url('AIR_badge/expressinstall.swf', __FILE__); ?>');
                
                // these parameters are required for badge install:
                so.addVariable("airversion", "3.7"); // version of AIR runtime required
                so.addVariable("appname", "WP EasyCart Admin Console"); // application name to display to the user
                so.addVariable("appurl", "http://www.wpeasycart.com/air/wpadmin_v1_0_37.air"); // absolute URL (beginning with http or https) of the application ".air" file
                
                // these parameters are required to support launching apps from the badge (but optional for install):
                so.addVariable("appid", "com.wpeasycart.admin"); // the qualified application ID (ex. com.gskinner.air.MyApplication)
                so.addVariable("pubid", ""); // publisher id
                
                // this parameter is required in addition to the above to support upgrading from the badge:
                so.addVariable("appversion", "1.0.37"); // AIR application version
                
                // these parameters are optional:
                so.addVariable("image", "<?php echo plugins_url('AIR_badge/DemoImage.jpg', __FILE__); ?>"); // URL for an image (JPG, PNG, GIF) or SWF to display in the badge (205px wide, 170px high)
                so.addVariable("appinstallarg", "installed from web"); // passed to the application when it is installed from the badge
                so.addVariable("applauncharg", "launched from web"); // passed to the application when it is launched from the badge
                so.addVariable("helpurl", "http://www.wpeasycart.com/docs"); // optional url to a page containing additional help, displayed in the badge's help screen
                so.addVariable("hidehelp", "false"); // hides the help icon if "true"
                so.addVariable("skiptransition", "true"); // skips the initial transition if "true"
                so.addVariable("titlecolor", "#4b9725"); // changes the color of titles
                so.addVariable("buttonlabelcolor", "#4b9725"); // changes the color of the button label
                so.addVariable("appnamecolor", "#4b9725"); // changes the color of the application name if the image is not specified or loaded
                
                // these parameters allow you to override the default text in the badge:
                // supported strings: str_error, str_err_params, str_err_airunavailable, str_err_airswf, str_loading, str_install, str_launch, str_upgrade, str_close, str_launching, str_launchingtext, str_installing, str_installingtext, str_tryagain, str_beta3, str_beta3text, str_help, str_helptext
                so.addVariable("str_err_airswf", "<u>Running locally?</u><br/><br/>The AIR proxy swf won't load properly when this demo is run from the local file system."); // overrides the error text when the AIR proxy swf fails to load
                
                so.write("flashcontent");
                
                // ]]>
            </script>
        
        <!-- END EMBED CODE -->
        
        
        
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td height="37" align="center"><strong>Problems Downloading?</strong> Try manually installing by following these <a href="http://www.wpeasycart.com/air_install" target="_blank">2 steps to install.</a></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="600">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="platformheading">iPad Users</td>
        <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('images/apple.png', __FILE__); ?>" width="40" height="40" /></td>
      </tr>
      <tr>
        <td height="10" colspan="2"></td>
      </tr>
      <tr>
        <td width="600" align="center"><a href="https://itunes.apple.com/us/app/wp-easycart/id616846878?mt=8" target="_blank"><img src="<?php echo plugins_url('images/ipad_mockup1.png', __FILE__); ?>" alt="iPad Administration Console" width="550" height="432" /></a></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td width="600">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="platformheading">Android Tablet and Phone Users</td>
        <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('images/android_vector.png', __FILE__); ?>" width="38" height="40" /></td>
      </tr>
      <tr>
        <td colspan="2" height="10"></td>
      </tr>
      <tr>
        <td width="600" align="center"><a href="https://play.google.com/store/search?q=wp+easycart&amp;c=apps&amp;feature=spelling" target="_blank"><img src="<?php echo plugins_url('images/android_tablet_phone.png', __FILE__); ?>" width="550" height="450" /></a></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td width="600">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>&nbsp;</p>
</div>
</div>