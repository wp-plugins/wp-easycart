<?php 

$validate = new ec_validation; 
$license = new ec_license;

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

//get the site url without http:// https:// or www.
$input = site_url();
// in case scheme relative URI is passed, e.g., //www.google.com/
$input = trim($input, '/');
// If scheme not included, prepend it
if (!preg_match('#^http(s)?://#', $input)) {
    $input = 'http://' . $input;
}
$urlParts = parse_url($input);
// remove www
$domain = preg_replace('/^www\./', '', $urlParts['host']);


//get current wordpress user
global $current_user;
get_currentuserinfo();
$userlogin = $current_user->user_login;
$useremail = $current_user->user_email;

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
        <td height="25" class="platformheading">WordPress Embedded Adminstration Console</td>
        <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('images/wordpress_icon.jpg', __FILE__); ?>" width="38" height="40" /></td>
      </tr>
      <tr>
        <td height="10" colspan="2"></td>
      </tr>
      <tr id="ec_wordpress_content">
      	<?php if( function_exists( "wp_easycart_load_admin" ) ){ ?>
        <td width="100%" colspan="2" align="center">
        	 <?php wp_easycart_load_admin( $domain, $userlogin ); ?>
        </td>
        <?php }else{ ?>
        <td width="600" align="center">
        	<a href="http://wpeasycart.com/air/wp-easycart-admin.zip" target="_blank"><img src="<?php echo plugins_url('images/wordpress_easycart.jpg', __FILE__); ?>" alt="iPad Administration Console" width="600" height="360" /></a>
        </td>
        <td  style="padding: 15px;">
        	&nbsp;&nbsp;&nbsp;&nbsp;
            <p><strong>How to Install: </strong></p>
            <p><strong>1. </strong><a href="http://wpeasycart.com/air/wp-easycart-admin.zip">Click this link</a> to download the WP EasyCart Administration Plugin.</p>
            <p><strong>2. </strong>Click 'Plugins' -> 'Add New' -> 'Upload' -> 'Choose File' and select the plugin from your downloads. Once selected, click install now.</p>
            <p><strong>3. </strong>Once Installed, this section will be replaced with an embedded version of the WP EasyCart Administration Software.</p>
            <p>&nbsp;</p>
            <p><strong>Need More Help?</strong></p>
            <p><a href="http://www.wpeasycart.com/support-ticket/" target="_blank">Submit a ticket</a> with the url you are using and an agent will get back to you shortly.</p>
        </td>
        <?php }?>
      </tr>
      
      <tr>
        <td width="600">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td height="25" class="platformheading">Desktop and Laptop Users</td>
        <td height="25" class="platformheadingimage"><img src="<?php echo plugins_url('images/windows-apple-linux.png', __FILE__); ?>" width="120" height="40" /></td>
      </tr>
      <tr>
        <td height="10" colspan="2"></td>
      </tr>
      <tr id="ec_desktop_content">
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
                so.addVariable("appurl", "http://www.wpeasycart.com/air/wpadmin_v1_0_49.air"); // absolute URL (beginning with http or https) of the application ".air" file
                
                // these parameters are required to support launching apps from the badge (but optional for install):
                so.addVariable("appid", "com.wpeasycart.admin"); // the qualified application ID (ex. com.gskinner.air.MyApplication)
                so.addVariable("pubid", ""); // publisher id
                
                // this parameter is required in addition to the above to support upgrading from the badge:
                so.addVariable("appversion", "1.0.49"); // AIR application version
                
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
        <td style="padding: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;
        <p><strong>How to Install: </strong></p>
        <p><strong>1. </strong>Simply click the '<em><strong>Install Now</strong></em>' on the left image and the automatic installer will try to install Adobe AIR and the Administrative Console. Please allow a few moments for it to install.</p>
        <p>Note: If that process fails or the automatic installer does not work, you can try our second method.</p>
        <p><strong>2. </strong> Try manually installing by following these <a href="http://www.wpeasycart.com/air-install" target="_blank">2 steps to install.</a></p>
        <p>&nbsp;</p>
        <p><strong>Need More Help?</strong></p>
        <p>Try visiting our <a href="http://www.wpeasycart.com/video-tutorials/" target="_blank">Video Tutorial</a> on installing and logging into the admin console, or our <a href="http://www.wpeasycart.com/docs/1.0.0/administration/installing_console.php" target="_blank">Online Documentation</a>.</p>
        <p>Still need more help? Simply <a href="http://www.wpeasycart.com/support-ticket/" target="_blank">submit a ticket</a> with the url you are using and an agent will get back to you shortly.</p></td>
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
      <tr id="ec_ipad_content">
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
      <tr id="ec_android_content">
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
<script type="text/javascript">
function ec_admin_open( panel ){
	jQuery( '#' + panel + "_content" ).show('blind');
}
</script>