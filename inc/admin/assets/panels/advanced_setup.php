<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-setup" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_options" ){
	ec_update_advanced_setup( );
	$isupdate = true;
}
?>

<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Settings saved.</strong></p></div>
<?php }?> 

<script src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/colorpicker.js'); ?>"></script>
<script src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/eye.js'); ?>"></script>

<div class="ec_admin_page_title">ADVANCED OPTIONS</div>
<div class="ec_adin_page_intro">The options here are for advanced users only. Switching some of these options may have unintended consequences with your store's functionality. Some users do require these options to be changed however, and may do so below.</div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-setup&ec_action=save_options" method="POST">

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>State Drop Downs</em>Depending on your country, you may choose to allow state drop downs or if disabled, customers will have an open text box to enter their state or province.  This varies from country to country.  You may edit the list in the drop down within the admin console software.</span></a></span>
    <span class="ec_setting_row_label">Use State Drop Down List for Addresses:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_state_dropdown" id="ec_option_use_state_dropdown">
            <option value="1" <?php if (get_option('ec_option_use_state_dropdown') == 1) echo ' selected'; ?>>Yes</option>
            <option value="0" <?php if (get_option('ec_option_use_state_dropdown') == 0) echo ' selected'; ?>>No</option>
          </select></span>
</div>
          
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Country Drop Downs</em>Country drop downs allow you to choose to have a pull down for the country, or to have an open text box for the country.  For consistent data, it is best to leave this option on.  you can edit the list of countries in the pulldown by using the admin console software.</span></a></span>
    <span class="ec_setting_row_label">Use Country Drop Down List for Addresses:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_country_dropdown" id="ec_option_use_country_dropdown">
            <option value="1" <?php if (get_option('ec_option_use_country_dropdown') == 1) echo ' selected'; ?>>Yes</option>
            <option value="0" <?php if (get_option('ec_option_use_country_dropdown') == 0) echo ' selected'; ?>>No</option>
          </select></span>
</div>
          
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Country for Estimate Shipping</em>We highly recommend you use this option for live shpping estimates. If you initially downloaded the EasyCart prior to 1.2.5, then you will need to update the ec_cart.css and ec_cart.js files in the wp-easycart/design/theme/{your_selected_theme}/ec_cart/ folder to a more current version. This is because the estimate shipping heavily relies on design files and we do not overwrite design files ever on update.</span></a></span>
    <span class="ec_setting_row_label">Use Country on Estimate Shipping</span>
    <span class="ec_setting_row_input"><select name="ec_option_estimate_shipping_country" id="ec_option_estimate_shipping_country">
            <option value="1" <?php if (get_option('ec_option_estimate_shipping_country') == 1) echo ' selected'; ?>>Yes</option>
            <option value="0" <?php if (get_option('ec_option_estimate_shipping_country') == 0) echo ' selected'; ?>>No</option>
          </select></span>
</div>
          
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use WP_MAIL function</em>Enabling this will allow you to leverage the built in wp_mail funciton. Disabled uses the php mail function instead. We have found this useful with SMTP plugins on Godaddy hosting.</span></a></span>
    <span class="ec_setting_row_label">Use WP Mail Function</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_wp_mail" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_wp_mail') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_wp_mail') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>RTL Support</em>RTL support is the method of setting all items in the store to be viewed with RTL direction text. We have also done some custom css to specific parts of the store to look more correct for RTL languages. In no way is this perfect though, or available in all themes. Please contact WP EasyCart with questions if you have any issues with our RTL support option.</span></a></span>
    <span class="ec_setting_row_label">Use RTL Support(e.g. Arabic, Hewbrew, etc...):</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_rtl" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_rtl') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_rtl') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_admin_page_title_secondary">Custom CSS</div>
<div class="ec_adin_page_intro">Any CSS you add here will over-ride the css in your EasyCart theme files. If you have an error in CSS here, it may effect your entire site, so please be cautious and pay attention to syntax errors.</div>
<div class="ec_adin_page_intro"><textarea style="width:100%; height:250px;" name="ec_option_custom_css"><?php echo get_option( 'ec_option_custom_css' ); ?></textarea></div>

<div class="ec_admin_page_title_secondary">Responsive Size Points</div>
<div class="ec_adin_page_intro">This section is meant for you to match up the resize points of your WordPress theme to that of your EasyCart theme.</div>

<?php
$resize_options = get_option( 'ec_option_responsive_sizes' ); 
$resize_split = explode( ":::", $resize_options );

if( count( $resize_split ) != 8 ){
	$resize_options = "size_level1_high=479:::size_level2_low=480:::size_level2_high=767:::size_level3_low=768:::size_level3_high=960:::size_level4_low=961:::size_level4_high=1300:::size_level5_low=1301";
	update_option( 'ec_option_responsive_sizes', $resize_options );
	$resize_split = explode( ":::", $resize_options );
}
?>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Max Width Phone</em>This is the resize point for smaller devices.</span></a></span>
    <span class="ec_setting_row_label">Max Width Phone:</span>
    <span class="ec_setting_row_input"><input name="size_level1_high" style="width:100px;" value="<?php $var = explode( "=", $resize_split[0] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Min Width Large Phone</em>This is the resize point for large phone devices.</span></a></span>
    <span class="ec_setting_row_label">Min Width Large Phone:</span>
    <span class="ec_setting_row_input"><input name="size_level2_low" style="width:100px;" value="<?php $var = explode( "=", $resize_split[1] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Max Width Large Phone</em>This is the resize point for large phone devices.</span></a></span>
    <span class="ec_setting_row_label">Max Width Large Phone:</span>
    <span class="ec_setting_row_input"><input name="size_level2_high" style="width:100px;" value="<?php $var = explode( "=", $resize_split[2] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Min Width Tablet</em>This is the resize point for tablet devices.</span></a></span>
    <span class="ec_setting_row_label">Min Width Tablet:</span>
    <span class="ec_setting_row_input"><input name="size_level3_low" style="width:100px;" value="<?php $var = explode( "=", $resize_split[3] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Max Width Tablet</em>This is the resize point for smaller tablet devices.</span></a></span>
    <span class="ec_setting_row_label">Max Width Tablet:</span>
    <span class="ec_setting_row_input"><input name="size_level3_high" style="width:100px;" value="<?php $var = explode( "=", $resize_split[4] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Min Width Small Desktop</em>This is the resize point for smaller desktop screens.</span></a></span>
    <span class="ec_setting_row_label">Min Width Small Desktop:</span>
    <span class="ec_setting_row_input"><input name="size_level4_low" style="width:100px;" value="<?php $var = explode( "=", $resize_split[5] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Max Width Small Desktop</em>This is the resize point for smaller desktop screens.</span></a></span>
    <span class="ec_setting_row_label">Max Width Small Desktop:</span>
    <span class="ec_setting_row_input"><input name="size_level4_high" style="width:100px;" value="<?php $var = explode( "=", $resize_split[6] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Min Width Large Desktop</em>This is the resize point for large display desktops.</span></a></span>
    <span class="ec_setting_row_label">Min Width Large Desktop:</span>
    <span class="ec_setting_row_input"><input name="size_level5_low" style="width:100px;" value="<?php $var = explode( "=", $resize_split[7] ); echo $var[1]; ?>" /></span>
</div>

<div class="ec_admin_page_title_secondary">Advanced Color Management</div>
<div class="ec_adin_page_intro">This section allows for you to edit the advanced colors of your store. These colors may not apply to all EasyCart themes or in all places you would expect.</div>

<?php 
$labels = array( 	"main_color" 		=> "Main Color",
					"second_color"		=> "Second Color",
					"third_color"		=> "Third Color",
					"title_color"		=> "Title Text Color",
					"text_color"		=> "Content Text Color",
					"link_color"		=> "Basic Link Color",
					"link_hover_color"	=> "Basic Link Mouse Over Color",
					"sale_color"		=> "Item Sale Color",
					"backdrop_color"	=> "Popup Window Backdrop Color",
					"content_bg"		=> "Popup Window Background Color",
					"error_text"		=> "Error Text Color",
					"error_color"		=> "Error Background Color",
					"error_color2"		=> "Error Box Border Color",
					"success_text"		=> "Success Text Color",
					"success_color"		=> "Success Background Color",
					"success_color2"	=> "Success Border Color",
					"title_font"		=> "Title Font Family",
					"subtitle_font"		=> "Subtitle Font Family",
					"content_font"		=> "General Content Font Family",
					"size_level1_high"	=> "Max Width Phone",
					"size_level2_low"	=> "Min Width Large Phone",
					"size_level2_high"	=> "Max Width Large Phone",
					"size_level3_low"	=> "Min Width Tablet",
					"size_level3_high"	=> "Max Width Tablet",
					"size_level4_low"	=> "Min Width Smaller Desktop",
					"size_level4_high"	=> "Max Width Smaller Desktop",
					"size_level5_low"	=> "Min Width Desktop"
				);

$css_options = get_option( 'ec_option_css_replacements' ); 
$css_split = explode( ",", $css_options );

if( count( $css_split ) != 16 ){
	$css_options = "main_color=#242424,second_color=#6b6b6b,third_color=#adadad,title_color=#0f0f0f,text_color=#141414,link_color=#242424,link_hover_color=#121212,sale_color=#900,backdrop_color=#333,content_bg=#FFF,error_text=#900,error_color=#F1D9D9,error_color2=#FF0606,success_text=#333,success_color=#E6FFE6,success_color2=#6FFF47";
	update_option( 'ec_option_css_replacements', $css_options );
	$css_split = explode( ",", $css_options );
}

foreach( $css_split as $css_item ){
	$temp_split = explode( "=", $css_item );
	
?>
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em><?php echo $labels[$temp_split[0]]; ?></em>You can edit the color for this item using the swatch next to the input box.</span></a></span>
    <span class="ec_setting_row_label"><?php echo $labels[$temp_split[0]]; ?>:</span>
    <span class="ec_setting_row_input_color"><input type="text" name="<?php echo $temp_split[0]; ?>" id="<?php echo $temp_split[0]; ?>" value="<?php echo $temp_split[1]; ?>" class="ec_color_block_input" /><div class="ec_color_block" id="<?php echo $temp_split[0]; ?>_colorblock"></div></span>
</div>

<script>
	jQuery('#<?php echo $temp_split[0]; ?>_colorblock').css('backgroundColor', '<?php echo $temp_split[1]; ?>');
	
	jQuery('#<?php echo $temp_split[0]; ?>_colorblock').ColorPicker({
		color:'<?php echo $temp_split[1]; ?>',
		onShow: function (colpkr) {
			jQuery(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			jQuery(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			jQuery('#<?php echo $temp_split[0]; ?>').val("#" + hex);
			jQuery('#<?php echo $temp_split[0]; ?>_colorblock').css('backgroundColor', '#' + hex);
		}
	
	});
</script>
<?php } ?>

<div class="ec_admin_page_title_secondary">Font Management</div>
<div class="ec_adin_page_intro">This section allows for you to edit the fonts used in your store. These fonts may not apply to all EasyCart themes or in all places you would expect.</div>

<?php 
// Get the Google Font Options
$response = (array)wp_remote_request( "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAprmWHw-alcYMQ2-7cuUGQ3iWI_IexLQ8" ); 
$fonts = json_decode( $response['body'] )->items;

$font_options = get_option( 'ec_option_font_replacements' ); 
$font_split = explode( ":::", $font_options );

if( count( $font_split ) != 3 ){
	$font_options = "title_font=Arial, Helvetica, sans-serif:::subtitle_font=Arial, Helvetica, sans-serif:::content_font=Arial, Helvetica, sans-serif";
	update_option( 'ec_option_font_replacements', $font_options );
	$font_split = explode( ":::", $font_options );
}

foreach( $font_split as $font_item ){
	$temp_split = explode( "=", $font_item );
	$font_name = $temp_split[1];
?>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em><?php echo $labels[$temp_split[0]]; ?></em>You can change the font for this item here. Some EasyCart themes do not actually use this option.</span></a></span>
    <span class="ec_setting_row_label"><?php echo $labels[$temp_split[0]]; ?>:</span>
    <span class="ec_setting_row_input"><?php
				echo "<select name=\"" . $temp_split[0] . "\">";
					
					echo "<option value='Verdana, Geneva, sans-serif'"; if( $font_name == "Verdana, Geneva, sans-serif" ){ echo " selected=\"selected\""; } echo ">Verdana, Geneva, sans-serif</option>";
					
					echo "<option value='Georgia, Times New Roman, Times, serif'"; if( $font_name == "Georgia, Times New Roman, Times, serif" ){ echo " selected=\"selected\""; } echo ">Georgia, Times New Roman, Times, serif</option>";
					
					echo "<option value='Courier New, Courier, monospace'"; if( $font_name == 'Courier New, Courier, monospace' ){ echo " selected=\"selected\""; } echo ">Courier New, Courier, monospace</option>";
					
					echo "<option value='Arial, Helvetica, sans-serif'"; if( $font_name == "Arial, Helvetica, sans-serif" ){ echo " selected=\"selected\""; } echo ">Arial, Helvetica, sans-serif</option>";
					
					echo "<option value='Tahoma, Geneva, sans-serif'"; if( $font_name == "Tahoma, Geneva, sans-serif" ){ echo " selected=\"selected\""; } echo ">Tahoma, Geneva, sans-serif</option>";
					
					echo "<option value='Trebuchet MS, Arial, Helvetica, sans-serif'"; if( $font_name == 'Trebuchet MS, Arial, Helvetica, sans-serif' ){ echo " selected=\"selected\""; } echo ">Trebuchet MS, Arial, Helvetica, sans-serif</option>";
					
					echo "<option value='Arial Black, Gadget, sans-serif'"; if( $font_name == 'Arial Black, Gadget, sans-serif' ){ echo " selected=\"selected\""; } echo ">Arial Black, Gadget, sans-serif</option>";
					
					echo "<option value='Times New Roman, Times, serif'"; if( $font_name == 'Times New Roman, Times, serif' ){ echo " selected=\"selected\""; } echo ">Times New Roman, Times, serif</option>";
					
					echo "<option value='Palatino Linotype, Book Antiqua, Palatino, serif'"; if( $font_name == 'Palatino Linotype, Book Antiqua, Palatino, serif' ){ echo " selected=\"selected\""; } echo ">Palatino Linotype, Book Antiqua, Palatino, serif</option>";
					
					echo "<option value='Lucida Sans Unicode, Lucida Grande, sans-serif'"; if( $font_name == 'Lucida Sans Unicode, Lucida Grande, sans-serif' ){ echo " selected=\"selected\""; } echo ">Lucida Sans Unicode, Lucida Grande, sans-serif</option>";
					
					echo "<option value='MS Serif, New York, serif'"; if( $font_name == 'MS Serif, New York, serif' ){ echo " selected=\"selected\""; } echo ">MS Serif, New York, serif</option>";
					
					echo "<option value='Lucida Console, Monaco, monospace'"; if( $font_name == 'Lucida Console, Monaco, monospace' ){ echo " selected=\"selected\""; } echo ">Lucida Console, Monaco, monospace</option>";
					
					echo "<option value='Comic Sans MS, cursive'"; if( $font_name == 'Comic Sans MS, cursive' ){ echo " selected=\"selected\""; } echo ">Comic Sans MS, cursive</option>";
					
					foreach( $fonts as $font ){
						echo "<option value=\"" . $font->family . "\"";
						if( $font_name == $font->family ){ echo " selected=\"selected\""; }
						echo ">" . $font->family . "</option>";	
					}
				echo "</select>";
				?></span>
</div>

<?php }?>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>