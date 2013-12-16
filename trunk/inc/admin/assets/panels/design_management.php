<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "design-management" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_design_options" ){
	ec_design_management_update( );
	$isupdate = true;
}
?>

<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Files have been uploaded and/or settings have been changed.</strong></p></div>
<?php }?>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=design-management&ec_action=save_design_options" method="POST" enctype="multipart/form-data">
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

<?php if( is_dir( '../wp-content/plugins/wp-easycart-data/latest-design/' ) ) {?>

<div class="ec_admin_page_title_secondary">Update to Latest Design</div>
<div class="ec_adin_page_intro">If you have not edited the fileset, you may want to do a quick update to the latest design set. Starting with the EasyCart version 2.0, you can automatically copy the latest design files as a new EasyCart theme and layout set. This allows you to revert to the old version if the new version is not compatible with your WordPress theme.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Upload New Theme Package</em>If you have a new EasyCart theme package, you can upload it here. Be sure you are uploading a zip that contains only the EasyCart theme. If you downloaded a design from our site, be sure you have extracted and selected the EasyCart theme zip package only.</span></a></span>
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
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Upload New Layout Package</em>If you have a new EasyCart layout package, you can upload it here. Be sure you are uploading a zip that contains only the EasyCart layout. If you downloaded a design from our site, be sure you have extracted and selected the EasyCart layout zip package only.</span></a></span>
    <span class="ec_setting_row_label">Upload New Layout Package:</span>
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
<?php }else{ ?>
<input type="hidden" name="ec_option_copy_theme" value="0">
<input type="hidden" name="ec_option_copy_layout" value="0">
<?php }?>
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

</form>