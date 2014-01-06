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
	if( $ec_selected_theme->Name == "Twenty Fourteen" && ( get_option( 'ec_option_base_theme' ) != "twenty-fourteen-v2" || get_option( 'ec_option_base_layout' ) != "twenty-fourteen-v2" ) ){ 
    
	if( is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/twenty-fourteen-v2/" ) ){;
	?>
    <div class="updated" style="float:left;">
        <p>To match the Twenty Fourteen WordPress theme up with the store, select 'twenty-fourteen-v2' for the EasyCart Theme and EasyCart Layout below.</p>
    </div>
    <?php }else{ ?>
    <div class="updated" style="float:left;">
        <p>To match the Twenty Fourteen WordPress theme up with the store, read the article <a href="http://www.wpeasycart.com/forums/forum/customization-and-themes/general-theme-questions/individual-theme-support/base-and-default-theme/262-twenty-fourteen-wordpress-theme" target="_blank">here</a>.</p>
    </div>
    <?php
	}// Close check for existing theme
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
<div class="ec_adin_page_intro">This section is designed to give customers a location to upload new EasyCart design packages.</div>

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

<?php if( is_dir( '../wp-content/plugins/wp-easycart-data/latest-design/' ) ) {?>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management&ec_action=upload_design" method="POST" enctype="multipart/form-data">
<div class="ec_admin_page_title_secondary">Update to Latest Design</div>
<div class="ec_adin_page_intro">If you have not edited the fileset, you may want to do a quick update to the latest design set. Starting with the EasyCart version 2.0, you can automatically copy the latest design files as a new EasyCart theme and layout set. This allows you to revert to the old version if the new version is not compatible with your WordPress theme.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Latest Theme</em>This option allows you to create a new theme package from the latest theme from the EasyCart plugin core. If you have made changes to the css or javascript specific to your store, then you will need to make this update manually.</span></a></span>
    <span class="ec_setting_row_label">Use Latest Theme:</span>
    <span class="ec_setting_row_input"><select name="ec_option_copy_theme" id="ec_option_copy_theme">
    				<option value="0" selected="selected">Do NOT Copy a Theme</option>
		          <?php
						$dir = '../wp-content/plugins/wp-easycart-data/latest-design/theme/';
						
						$scan = scandir( $dir );
						foreach( $scan as $key => $val ) {
							
							if ( is_dir( $dir . "/" . $val ) ) {
								if($val != "." && $val != ".."){
									echo "<option value=\"".$val."\">" . $val . "</option>\n";
								}
							}
							
						}
						?>
		          </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Latest Layout</em>This option allows you to create a new layout package from the latest layout from the EasyCart plugin core. If you have made changes to the php specific to your store, then you will need to make this update manually.</span></a></span>
    <span class="ec_setting_row_label">Use Latest Layout:</span>
    <span class="ec_setting_row_input"><select name="ec_option_copy_layout" id="ec_option_copy_layout">
    				<option value="0" selected="selected">Do NOT Copy a Layout</option>
		          <?php
						$dir = '../wp-content/plugins/wp-easycart-data/latest-design/layout/';
							
						$scan = scandir( $dir );
						foreach( $scan as $key => $val ) {
							
							if ( is_dir( $dir . "/" . $val ) ) {
								if($val != "." && $val != ".."){
									echo "<option value=\"".$val."\">" . $val . "</option>\n";
								}
							}
							
						}
						?>
		          </select></span>
</div>
<div class="ec_save_changes_row"><input type="submit" value="COPY LATEST DESIGN" class="ec_save_changes_button" /></div>

</form>
<?php } ?>