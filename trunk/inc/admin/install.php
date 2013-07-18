<?php 

$validate = new ec_validation; 
$license = new ec_license;

//set our datapack location
$datapack_url = '';
if ($_POST['datapack']) {
	if($_POST['datapack'] == 'standard_data') {
		$datapack_url = 'http://www.wpeasycart.com/sampledata/standard_demo';	
	}
}

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
	
} else if(isset($_POST['isinsertdemodata'])){
	//INSERT DEMO DATA HERE
	copy("$datapack_url/standard_demo_install.sql", WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/standard_demo_install.sql");
	//Put up the databse for website
	$url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/standard_demo_install.sql";
	// Load and explode the sql file
	$f = fopen($url, "r+") or die("CANNOT OPEN SQL SCRIPT");
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
	
	//COPY DEMO PRODUCTS HERE
	copy("$datapack_url/standard_demo_assets.zip", WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/standard_demo_assets.zip");
	
	$zip = new ZipArchive;
	$res = $zip->open(WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/standard_demo_assets.zip");
	if ($res === TRUE) {
		$zip->extractTo(WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/");
		$zip->close();
	} else {
		echo 'Unzip Failed';
	}
	
}else if(isset($_POST['isdeletedemodata'])){
	//REMOVE JUST TABLE DATA
	copy("http://www.wpeasycart.com/sampledata/demo_uninstall.sql", WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/demo_uninstall.sql");
	//uninstall if it's there first
	$url = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/demo_uninstall.sql";
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
	
	
	//COPY CLEAN SET OF PRODUCTS FOLDERS
	copy("http://www.wpeasycart.com/sampledata/clean_assets.zip", WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/clean_assets.zip");
	
	$zip = new ZipArchive;
	$res = $zip->open(WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/clean_assets.zip");
	if ($res === TRUE) {
		$zip->extractTo(WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY  . "/");
		$zip->close();
	} else {
		echo 'Unzip Failed';
	}
	
}

?>
<script type="text/javascript">
	function install_alert() {
		var answer = confirm ("Are you sure you want to install demo data?  We will attempt to retrieve sample data and product images from the EasyCart servers and place this information into your system.")
		if (answer)
		document.getElementById("installdataform").submit();
	}
	function uninstall_alert() {
		var answer = confirm ("Are you sure you want to uninstall demo data?  Doing so will remove ALL of the products, options, and orders in EasyCart.  This will create a clean empty eCommerce system for you.")
		if (answer)
		document.getElementById("deletedataform").submit();
	}
	function runchecklist() {
		window.open('<?php echo plugins_url('ec_checklist.php', __FILE__); ?>', '_blank', 'width=950, height=800');	
	}
</script>



<div class="wrap">

<?php if(!$license->is_registered()) {; ?>
<div class="ribbon">This banner appears when you have a WordPress EasyCart FREE version installed. To purchase the FULL version, you must purchase a license at <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

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
                    </ol>
				</td>
            </tr>
            <tr valign="top">
                <td colspan="2" align="left" scope="row">
                <div class="ec_info_note"><strong>Helpful Links</strong>: You can view a full installation manual at <a href="http://www.wpeasycart.com/docs" target="_blank">www.wpeasycart.com/docs</a>. We also offer full video tutorials and walk-throughs of various capablilities of the store, installation, and product setup; just view our <a href="http://www.wpeasycart.com/video-tutorials/" target="_blank">video library</a> for more information. If you would like to purchase a licensed version of our software, you can check our <a href="http://www.wpeasycart.com/wordpress-ecommerce-plugin/" target="_blank">pricing here.</a> We do custom design and development and are here to support the software, so don't hesitate to ask us questions.</div>
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
                
                
                    <select name="datapack" id="datapack">
                    <option value="standard_data">Standard Demo Data</option>
                    </select> 
                    
                    <input type="button" class="button-primary" value="Install Sample Data" onclick="install_alert()" />
                    </form>
                	</p>
                    </div>
                    
                    <div class="ec_install_right">
    				<form method="post" action="#" name="deletedataform" id="deletedataform">
                    <input type="hidden" name="isdeletedemodata" id="isdeletedemodata" value="1" />
                    <input type="button" class="button-primary" value="Un-Install Sample Data" onclick="uninstall_alert()" />
                    </form>
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" class="platformheading" scope="row">Server Diagnostics and Checklist</td>
                <td valign="top" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        	</tr>
            <tr valign="top">
            	<td colspan="2" align="left" scope="row">
                <p>WP EasyCart is an advanced plugin and more complex in design than many in WordPress.  If you continue to have issues with installation or need to verify that certain configurations qualify on your servers, you can run this quick checklist that will test your servers settings.  This test will verify certain PHP and server settings, and also complete a read/write test of your directories to ensure the EasyCart system can be installed and operate.  This is a minimal test and other settings may cause problems, but these are the most common.  If you come across a failed request, show this test to your web host and the will usually fix the issues.</p>
                
                <input type="button" class="button-primary" value="Run Server Check" onclick="runchecklist()" />
                </td>
            </tr>
        </table>
    
    
    </div>
</div>