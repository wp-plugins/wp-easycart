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

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>