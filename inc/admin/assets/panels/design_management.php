<?php
$isupdate = false;
if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_design_options" ){
	ec_update_selected_design( );
	$isupdate = true;
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "design-management" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "upload_design" ){
	ec_design_management_update( );
	$isupdate = true;
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "design-management" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "upload_design" ){
	ec_option_copy_layout( );
	$isupdate = true;
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "design-management" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "update_cache_rules" ){
	ec_update_cache_rules( );
	ec_regenerate_css( );
	ec_regenerate_js( );
	$isupdate = true;
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "design-management" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "refresh_cache" ){
	ec_regenerate_css( );
	ec_regenerate_js( );
	update_option( 'ec_option_cached_date', time( ) );
	$isupdate = true;
}
?>

<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Files have been uploaded and/or settings have been changed.</strong></p></div>
<?php }?>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management&ec_action=save_design_options" method="POST" enctype="multipart/form-data">
<div class="ec_admin_page_title">SELECT YOUR STORE DESIGN</div>
<div class="ec_adin_page_intro"><p>The EasyCart system allows you to choose from a few basic store designs. If you are a website designer and you would like to create a custom design for a client or a template to resell, you can copy one of our starter designs, rename the folders, and begin editing. The store will automatically detect your new design folders and allow you to select it here. Edit the designs in the plugins/wp-easycart-data/design/layout and plugins/wp-easycart-data/design/theme folders of your WordPress install.</p>

<p>To make things even easier, we have designed matching WordPress themes, so the theme of your website specifically matches the theme of your EasyCart. But even if you have your own WordPress theme, there is no reason you can't use one of our EasyCart plugin themes to mix and match design.</p>

<p><strong>Theme</strong> = The overall styling such as colors, borders, background designs, and button design and colors.<br />
<strong>Layout</strong> = The overall placement or arrangement of page elements, such as title and image locations, column widths, and general page layout.</p></div>

<?php
	$ec_selected_theme = wp_get_theme();
	if( $ec_selected_theme->Name == "Twenty Fourteen" && substr( get_option( 'ec_option_base_theme' ), 0, 15 ) != "twenty-fourteen" ){
    ?>
    <div class="updated" style="float:left;">
        <p>To match the Twenty Fourteen WordPress theme up with the store, select 'twenty-fourteen-v2' for the EasyCart Theme and EasyCart Layout below.</p>
    </div>
    <?php
    }// Close check for latest WordPress theme
?>

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

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management&ec_action=upload_design" method="POST" enctype="multipart/form-data">
<div class="ec_admin_page_title">Upload Design Packages</div>
<div class="ec_adin_page_intro">This section is designed to give customers a location to upload new EasyCart design packages. If you would like to find new theme packages for download, <a href="http://www.wpeasycart.com/latest-theme-downloads" target="_blank">view our latest free store themes here</a>.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Upload New Theme Package</em>If you have a new EasyCart theme package, you can upload it here. Be sure you are uploading a zip that contains only the EasyCart theme. If you downloaded a design from our site, be sure you have extracted and selected the EasyCart theme zip package only.</span></a></span>
    <span class="ec_setting_row_label">Upload New Theme Package:</span>
    <span class="ec_setting_row_input"><input type="file" name="theme_file" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Upload New Layout Package</em>If you have a new EasyCart layout package, you can upload it here. Be sure you are uploading a zip that contains only the EasyCart layout. If you downloaded a design from our site, be sure you have extracted and selected the EasyCart layout zip package only.</span></a></span>
    <span class="ec_setting_row_label">Upload New Layout Package:</span>
    <span class="ec_setting_row_input"><input type="file" name="layout_file" /></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="UPLOAD NEW DESIGNS" class="ec_save_changes_button" /></div>

</form>

<div class="ec_admin_page_title_secondary">Update to Latest Design</div>
<div class="ec_adin_page_intro">If you have not edited the fileset, you may want to do a quick update to the latest design set. You can <a href="http://www.wpeasycart.com/latest-theme-downloads" target="_blank">click here</a> to go to the latest design file download page. Download the theme and layout zips and upload them to the "Upload Design Packages" above. There may also be additional free downloads for new themes and layouts.</div>

<div class="ec_admin_page_title_secondary">CSS/JS Cache Management</div>
<div class="ec_adin_page_intro">The goal of the EasyCart is to balance ease of use and setup with the ability for designers and developers to customize their install. As of version 2.1.14, we have implemented a system in which the css and js files are combined and saved for re-use (cached). You can also set it up to automatically regenerate these files every day, week, month, or year so that changes are recognized. For developers and designers, we also have an option to turn caching off for development. Finally, we give you the ability to manually refresh the design file set here.</div>


<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management&ec_action=update_cache_rules" method="POST" enctype="multipart/form-data">
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Caching Mode</em>This option allows you to turn caching into production mode or testing mode.</span></a></span>
    <span class="ec_setting_row_label">Caching Mode:</span>
    <span class="ec_setting_row_input">
    <select name="ec_option_caching_on">
              <option value="0"<?php if(get_option('ec_option_caching_on') == '0') echo ' selected'; ?>>Development Mode</option>
              <option value="1"<?php if(get_option('ec_option_caching_on') == '1') echo ' selected'; ?>>Production Mode</option>
          </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Cache Update Period</em>This option forces the css and js files to refresh the cached file after the expiry period set here.</span></a></span>
    <span class="ec_setting_row_label">Cache Update Period:</span>
    <span class="ec_setting_row_input">
    <select name="ec_option_cache_update_period">
              <option value="0"<?php if(get_option('ec_option_cache_update_period') == '0') echo ' selected'; ?>>Never Update Automatically</option>
              <option value="1"<?php if(get_option('ec_option_cache_update_period') == '1') echo ' selected'; ?>>Update Daily</option>
              <option value="2"<?php if(get_option('ec_option_cache_update_period') == '2') echo ' selected'; ?>>Update Weekly</option>
              <option value="3"<?php if(get_option('ec_option_cache_update_period') == '3') echo ' selected'; ?>>Update Monthly</option>
              <option value="4"<?php if(get_option('ec_option_cache_update_period') == '4') echo ' selected'; ?>>Update Yearly</option>
          </select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="UPDATE SETTINGS" class="ec_save_changes_button" /></div>

</form>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management&ec_action=refresh_cache" method="POST" enctype="multipart/form-data">

<div class="ec_adin_page_intro">Last CSS/JS Cache: <?php echo date( 'l jS \of F Y h:i:s A T', get_option( 'ec_option_cached_date' ) ); ?> | <a href="<?php echo plugins_url('wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store-css.css' ); ?>">Current CSS</a> | <a href="<?php echo plugins_url('wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store-js.js' ); ?>">Current JS</a></div>

<div class="ec_save_changes_row"><input type="submit" value="REFRESH CACHE" class="ec_save_changes_button" /></div>

</form>