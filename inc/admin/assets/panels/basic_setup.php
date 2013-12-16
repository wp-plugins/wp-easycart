<?php 
$isupdate = false;

if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_selected_pages" ){
	ec_update_pages( $_POST['ec_option_storepage'], $_POST['ec_option_accountpage'], $_POST['ec_option_cartpage'] );
	$isupdate = true;
	$message = "Settings saved.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add_store_shortcode" && isset( $_GET['ec_storeid'] ) ){
	ec_add_store_shortcode( $_GET['ec_storeid'] );
	$isupdate = true;
	$message = "Shortcode [ec_store] has been added to the selected page.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add_account_shortcode" && isset( $_GET['ec_accountid'] ) ){
	ec_add_account_shortcode( $_GET['ec_accountid'] );
	$isupdate = true;
	$message = "Shortcode [ec_account] has been added to the selected page.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add_cart_shortcode" && isset( $_GET['ec_cartid'] ) ){
	ec_add_cart_shortcode( $_GET['ec_cartid'] );
	$isupdate = true;
	$message = "Shortcode [ec_cart] has been added to the selected page.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add_store_page" ){
	ec_add_store_page( );
	$isupdate = true;
	$message = "A 'Store' page has been created and the shortcode [ec_store] has been added to the selected page.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add_account_page" ){
	ec_add_account_page( );
	$isupdate = true;
	$message = "An 'Account' page has been created and the shortcode [ec_account] has been added to the selected page.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "add_cart_page" ){
	ec_add_cart_page( );
	$isupdate = true;
	$message = "A 'Cart' page has been created and the shortcode [ec_cart] has been added to the selected page.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "install_demo_data" ){
	ec_install_demo_data( );
	$isupdate = true;
	$message = "The demo data has been installed.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "uninstall_demo_data" ){
	ec_uninstall_demo_data( );
	$isupdate = true;
	$message = "The demo data has been uninstalled.";
}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_selected_design" ){
	ec_update_selected_design( );
	$isupdate = true;
	$message = "The selected design options have been saved.";
}
?>

<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong><?php echo $message; ?></strong></p></div>
<?php }?> 

<div class="ec_admin_page_title">BASIC SETUP</div>
<div class="ec_adin_page_intro">Welcome to the WP EasyCart. To begin the setup of your plugin, please start by selecting the page you are uing for your store, account, and cart. If you need to create a page, click the "create page" button. You need to also add the [ec_store], [ec_account], and [ec_cart] shortcodes to each page. Do this automatically by clicking the "Add Shortcode" link once you have selected the correct page.</div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=save_selected_pages" method="POST">
<div class="ec_setup_row">
	<span class="ec_setup_row_label">Store Page:</span>
    <span class="ec_setup_row_input"><?php wp_dropdown_pages(array('name'=>'ec_option_storepage', 'selected'=>get_option('ec_option_storepage'))); ?></span>
    <span class="ec_setup_row_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=add_store_shortcode&ec_storeid=<?php echo get_option( 'ec_option_storepage' ); ?>" class="ec_setup_button" onclick="return check_add_shortcode( 'store', '<?php echo get_option( 'ec_option_storepage' ); ?>' );">ADD SHORTCODE</a></span>
    <span class="ec_setup_row_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=add_store_page" class="ec_setup_button" onclick="return check_add_page( 'store' );">CREATE PAGE</a></span>
</div>

<div class="ec_setup_row">
	<span class="ec_setup_row_label">Account Page:</span>
    <span class="ec_setup_row_input"><?php wp_dropdown_pages(array('name'=>'ec_option_accountpage', 'selected'=>get_option('ec_option_accountpage'))); ?></span>
    <span class="ec_setup_row_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=add_account_shortcode&ec_accountid=<?php echo get_option( 'ec_option_accountpage' ); ?>" class="ec_setup_button" onclick="return check_add_shortcode( 'account', '<?php echo get_option( 'ec_option_accountpage' ); ?>' );">ADD SHORTCODE</a></span>
    <span class="ec_setup_row_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=add_account_page" class="ec_setup_button" onclick="return check_add_page( 'account' );">CREATE PAGE</a></span>
</div>

<div class="ec_setup_row">
	<span class="ec_setup_row_label">Cart Page:</span>
    <span class="ec_setup_row_input"><?php wp_dropdown_pages(array('name'=>'ec_option_cartpage', 'selected'=>get_option('ec_option_cartpage'))); ?></span>
    <span class="ec_setup_row_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=add_cart_shortcode&ec_cartid=<?php echo get_option( 'ec_option_cartpage' ); ?>" class="ec_setup_button" onclick="return check_add_shortcode( 'cart', '<?php echo get_option( 'ec_option_cartpage' ); ?>' );">ADD SHORTCODE</a></span>
    <span class="ec_setup_row_button"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=add_cart_page" class="ec_setup_button" onclick="return check_add_page( 'cart' );">CREATE PAGE</a></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>

<div class="ec_admin_page_title">INSTALL DEMO DATA</div>
<div class="ec_adin_page_intro">If you have just installed the EasyCart plugin, you may want to quickly see what it can do. The best way to do this is to install the demo data. Most servers can install this data without a problem, while others have the wrong permissions and will not allow the necessary files to be copied. If you cannot get the demo data to install automatically, you may have to do it manually. Additional information can be found on our docs site at <a href="http://wpeasycart.com/docs" target="_blank">http://wpeasycart.com/docs</a></div>

<div class="ec_demo_buttons_row"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=install_demo_data" class="ec_install_demo_data_button" onclick="return ec_verify_install_demo_data( );"></a><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=uninstall_demo_data" class="ec_uninstall_demo_data_button" onclick="return ec_verify_uninstall_demo_data( );"></a></div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup&ec_action=save_selected_design" method="POST">
<div class="ec_admin_page_title">SELECT YOUR STORE DESIGN</div>
<div class="ec_adin_page_intro"><p>The EasyCart system allows you to choose from a few basic store designs. If you are a website designer and you would like to create a custom design for a client or a template to resell, you can copy one of our starter designs, rename the folders, and begin editing. The store will automatically detect your new design folders and allow you to select it here. Edit the designs in the plugins/wp-easycart-data/design/layout and plugins/wp-easycart-data/design/theme folders of your WordPress install.</p>

<p>To make things even easier, we have designed matching WordPress themes, so the theme of your website specifically matches the theme of your EasyCart. But even if you have your own WordPress theme, there is no reason you can't use one of our EasyCart plugin themes to mix and match design.</p>

<p><strong>Theme</strong> = The overall styling such as colors, borders, background designs, and button design and colors.<br />
<strong>Layout</strong> = The overall placement or arrangement of page elements, such as title and image locations, column widths, and general page layout.</p></div>

<div class="ec_setup_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Choose Your EasyCart Theme</em>An EasyCart theme is the css, javascript, and imagery that is used to display your store to your customers. If a theme is labeled responsive, this means the theme will adjust the appearance at specific screen size levels. It is important that if your WordPress theme is responsive, that you also choose a responsive EasyCart theme. In addition, it is important that the screen sizes in which your WordPress theme changes matches the screen sizes that your EasyCart changes. This can be changed under the advanced options panel in this admin.</span></a></span>
	<span class="ec_setup_row_label_wide">Choose Your EasyCart <em>Theme</em>:</span>
    <span class="ec_setup_row_input"><select name="ec_option_base_theme" id="ec_option_base_theme">
		          <?php
						if( is_dir( '../wp-content/plugins/wp-easycart-data/' ) )
							$dir = '../wp-content/plugins/wp-easycart-data/design/theme/';
						else
							$dir = '../wp-content/plugins/wp-easycart/design/theme/';
						
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
		          </select></span>
</div>

<div class="ec_setup_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Choose Your EasyCart Layout</em>An EasyCart layout is the positioning of elements throughout your store. These are PHP files that allow a developer to move elements around in order to customize the display of the store. In addition, if you are a developer, you can add custom PHP in these files that can customize the store, without fear of the code being over-written during an update.</span></a></span>
	<span class="ec_setup_row_label_wide">Choose Your Easycart <em>Layout</em>:</span>
    <span class="ec_setup_row_input"><select name="ec_option_base_layout" id="ec_option_base_layout">
		          <?php
						if( is_dir( '../wp-content/plugins/wp-easycart-data/' ) )
							$dir = '../wp-content/plugins/wp-easycart-data/design/layout/';
						else
							$dir = '../wp-content/plugins/wp-easycart/design/layout/';
							
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
		          </select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>

<script>
function check_add_shortcode( page_type, pageid ){
	if( jQuery('#ec_option_' + page_type + 'page' ).val( ) != pageid ){
		ec_show_alert_box( page_type.charAt(0).toUpperCase( ) + page_type.slice( 1 ) + " Page Has Changed", "You have changed the selected store page since this page was loaded. Please save your changes first before adding the shortcode." );
		return false;
	}else{
		return confirm( "Do you really want to add the shortcode to " + jQuery('#ec_option_' + page_type + 'page option:selected').text() + "?" );
	}
}

function check_add_page( page_type ){
	return confirm( "Are you sure you would like to create a new " + page_type.charAt(0).toUpperCase( ) + page_type.slice( 1 ) + " page?" );
}

function ec_show_alert_box( title, message ){
	document.getElementById( 'ec_popup_title' ).innerHTML = title;
	document.getElementById( 'ec_popup_content' ).innerHTML = message;
	jQuery( '#ec_popup_background' ).fadeIn( "slow" );
	jQuery( '#ec_popup' ).fadeIn( "slow" );
}

function ec_hide_alert_box( ){
	jQuery( '#ec_popup_background' ).fadeOut( "slow" );
	jQuery( '#ec_popup' ).fadeOut( "slow" );
}

function ec_verify_install_demo_data( ){
	return confirm( "Do you really want to install the demo data?" );
}

function ec_verify_uninstall_demo_data( ){
	return confirm( "Do you really want to uninstall the demo data?" );
}
</script>