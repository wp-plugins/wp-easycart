<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-setup" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_options" && isset( $_POST['ec_option_use_smart_states'] ) ){
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
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Advanced State Display</em>For version 2.1.8 and beyond, first time installs will automatically have this feature available. If you first installed a version prior to this, you will need to upgrade your design files to use this feature. This feature allows you to input multiple states from multiple countries and display these dropdown menus based on the selected country. If a country with no states is selected, a basic text box will be available.</span></a></span>
    <span class="ec_setting_row_label">Use Advanced State Display:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_smart_states" id="ec_option_use_smart_states">
            <option value="1" <?php if (get_option('ec_option_use_smart_states') == 1) echo ' selected'; ?>>Yes</option>
            <option value="0" <?php if (get_option('ec_option_use_smart_states') == 0) echo ' selected'; ?>>No</option>
          </select></span>
</div>

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

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Match Store Page Meta</em>This option is setup for those who use custom meta tags in their theme that apply to the store page. When this option is on, all store products, menus, product groups, and manufacturers will automatically match the meta information from the store page.</span></a></span>
    <span class="ec_setting_row_label">Match Store Page Meta:</span>
    <span class="ec_setting_row_input"><select name="ec_option_match_store_meta" style="width:100px;"><option value="0"<?php if( get_option('ec_option_match_store_meta') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_match_store_meta') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Custom Post Type Linking</em>This option switches the linking format to go to individual product, menu, manufacterer, and group pages setup as custom post types. This option is the most SEO friendly option, but does not work with all WordPress themes and servers. If you begin to see a 404 error or no content on a product details page, then turn this option off or ask for help in troubleshooting.</span></a></span>
    <span class="ec_setting_row_label">Use Custom Post Type Linking:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_old_linking_style" style="width:100px;"><option value="1"<?php if( get_option('ec_option_use_old_linking_style') == "1" ){ echo " selected=\"selected\""; }?>>Off</option><option value="0"<?php if( get_option('ec_option_use_old_linking_style') == "0" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>No VAT For Shipping</em>This option is available only for VAT tax system users. If you turn this on, VAT will be calculated without the shipping price included.</span></a></span>
    <span class="ec_setting_row_label">No VAT For Shipping:</span>
    <span class="ec_setting_row_input"><select name="ec_option_no_vat_on_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_no_vat_on_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_no_vat_on_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Display Store as Catalog</em>This option removes the add to cart button and quantity input as well as the quick view. This will allow you to display a catalog of products to your customers.</span></a></span>
    <span class="ec_setting_row_label">Display Store as Catalog:</span>
    <span class="ec_setting_row_input"><select name="ec_option_display_as_catalog" style="width:100px;"><option value="0"<?php if( get_option('ec_option_display_as_catalog') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_display_as_catalog') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Store Exchange Rates</em>This option allows you to define exchange rates from your base currency. This is a list in the form of "EUR=.80,GBP=.55,JPY=101.9". Each of these is an example of converting from USD to each of the currencies provided. You can list as many currencies as you would like, but they must match the values entered in the WP EasyCart currency widget. The values must also be valid three digit currency codes.</span></a></span>
    <span class="ec_setting_row_label">Currency Exchange Rates:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_exchange_rates" style="width:350px;" value="<?php echo get_option('ec_option_exchange_rates'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Gift Cards Apply to Grand Total</em>This option allows you to globally control if gift cards can be applied to the grand total or subtotal. If turned on, a customer can use the gift card to pay for shipping, but if it is turned off, it will only apply to the subtotal.</span></a></span>
    <span class="ec_setting_row_label">Gift Cards Apply to Grand Total:</span>
    <span class="ec_setting_row_input"><select name="ec_option_gift_card_shipping_allowed" style="width:100px;"><option value="0"<?php if( get_option('ec_option_gift_card_shipping_allowed') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_gift_card_shipping_allowed') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Shipping for Subscriptions</em>This option allows you to collect a user's shipping information if required for subscription items. If you sell digital goods, you should leave this off, but if you are shipping something with the recurring billing, turn it on.</span></a></span>
    <span class="ec_setting_row_label">Collect Shipping for Subscriptions:</span>
    <span class="ec_setting_row_input"><select name="ec_option_collect_shipping_for_subscriptions" style="width:100px;"><option value="0"<?php if( get_option('ec_option_collect_shipping_for_subscriptions') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_collect_shipping_for_subscriptions') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row" style="height:auto">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Restrict Store to User Level</em>This option allows you to restrict your store and purchases to a specific user level or levels. You must have user roles setup to use this option.</span></a></span>
    <span class="ec_setting_row_label">Restrict Store to User Level:</span>
    <span class="ec_setting_row_input">
    	<?php
		global $wpdb;
		$user_roles = $wpdb->get_results( "SELECT * FROM ec_role WHERE admin_access = 0" );
		$restricted_roles = explode( "***", get_option('ec_option_restrict_store' ) );
		?>
    	<select multiple name="ec_option_restrict_store[]" style="width:350px;">
        	<option value="0"<?php if( get_option('ec_option_restrict_store') == "0" ){ echo " selected=\"selected\""; }?>>No Restrictions</option>
            <?php foreach( $user_roles as $user_role ){ ?>
            <option value="<?php echo $user_role->role_label; ?>"<?php if( in_array( $user_role->role_label, $restricted_roles ) ){ echo " selected=\"selected\""; }?>><?php echo $user_role->role_label; ?></option>
            <?php }?>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Theme Custom Post Template for Store Items</em>This option allows you to customize your store design with your theme. The default is to use your page design for all store items, but turning this on will force the system to use your single.php file. Customize store pages by adding a single-ec_store.php file to your theme and turning this option on.</span></a></span>
    <span class="ec_setting_row_label">Use Theme Custom Post Template:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_custom_post_theme_template" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_custom_post_theme_template') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_custom_post_theme_template') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Send Email When New Account Created</em>This option allows you to receive a notification email every time someone creates a new account in your EasyCart system.</span></a></span>
    <span class="ec_setting_row_label">Send Email When New Account Created:</span>
    <span class="ec_setting_row_input"><select name="ec_option_send_signup_email" style="width:100px;"><option value="0"<?php if( get_option('ec_option_send_signup_email') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_send_signup_email') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_admin_page_title_secondary">Custom CSS</div>
<div class="ec_adin_page_intro">Any CSS you add here will over-ride the css in your EasyCart theme files. If you have an error in CSS here, it may effect your entire site, so please be cautious and pay attention to syntax errors.</div>
<div class="ec_adin_page_intro"><textarea style="width:100%; height:250px;" name="ec_option_custom_css"><?php echo stripslashes( get_option( 'ec_option_custom_css' ) ); ?></textarea></div>
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_admin_page_title">Amazon S3 Setup</div>
<div class="ec_adin_page_intro">If you plan to use Amazon S3 for downloads, you will want to enter your setup data here.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Amazon Key</em>This option is the key used to access your S3 buckets.</span></a></span>
    <span class="ec_setting_row_label">Amazon Key:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_amazon_key" style="width:350px;" value="<?php echo get_option('ec_option_amazon_key'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Amazon Secret</em>This option is the secret used to access your S3 buckets.</span></a></span>
    <span class="ec_setting_row_label">Amazon Secret:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_amazon_secret" style="width:350px;" value="<?php echo get_option('ec_option_amazon_secret'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Amazon Download Bucket</em>This option is the bucket name you will be using to store/access your downloadable products.</span></a></span>
    <span class="ec_setting_row_label">Amazon Download Bucket:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_amazon_bucket" style="width:350px;" value="<?php echo get_option('ec_option_amazon_bucket'); ?>" /></span>
</div>


<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_admin_page_title">DecoNetwork Setup</div>
<div class="ec_adin_page_intro">If you plan to offer custom designed goods on your own DecoNetwork site with the WP EasyCart as the checkout integration, you can enter your setup information below.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>DecoNetwork URL</em>This is the base URL for your DecoNetwork website, e.g. mystore.secure-store.com.</span></a></span>
    <span class="ec_setting_row_label">DecoNetwork URL:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_deconetwork_url" style="width:350px;" value="<?php echo get_option('ec_option_deconetwork_url'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>DecoNetwork Order Passwrod</em>This is a custom password used to commit orders to your DecoNetwork account. The values must match here and in your DecoNetwork API settings, which are explained below.</span></a></span>
    <span class="ec_setting_row_label">DecoNetwork Order Password:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_deconetwork_password" style="width:350px;" value="<?php echo get_option('ec_option_deconetwork_password'); ?>" /></span>
</div>

<div>Note: You must complete the following steps in your DecoNetwork settings panel to offer these product types:
<ul>
	<li>External Cart Integration must be enabled by going to your DecoNetwork Manage Store -> Website Settings -> API Settings.</li>
    <li>Add the Add to Cart Callback URL: <?php echo get_permalink( get_option( 'ec_option_cartpage' ) ); ?></li>
    <li>Add the Cancel Callback URL: <?php echo get_permalink( get_option( 'ec_option_storepage' ) ); ?></li>
    <li>Create a Custom Order Commit URL. This is a custom value DIFFERENT from your account password AND should be entered in the field provided above!</li>
    <li>Additional note, the hard part of setting this up tends to be finding the product id (not product code!) and is available if you go to the product on your DecoNetowrk site, look at the URL, and where it says n=xxxxxxx, the xxxxxxx is the id you need to enter in the EasyCart system when setting up a product.</li>
    <li>It is recommended that you turn off email coorespondence from your DecoNetwork site. This can be done by going to Manage Store -> Website Settings -> Correspondence Settings and check the box to force coorespondance from the WP EasyCart instead of your DecoNetwork site.</li>
</ul>
</div>


<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_admin_page_title">Canada Taxation Options</div>
<div class="ec_adin_page_intro">In order to make setup for taxation in Canada easier, we have added a few options here to make setup quick and easy. Please select the options below to collect appropriate taxes for Candian purchases. Please be sure to enable the advanced state display on this page for best results.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Easy Canada Tax</em>This option allows you to collect Canadian tax at the standard rates and display them properly during checkout.</span></a></span>
    <span class="ec_setting_row_label">Enable Easy Canada Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_enable_easy_canada_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_enable_easy_canada_tax') == "0" ){ echo " selected=\"selected\""; }?>>Disabled</option>
            <option value="1"<?php if( get_option('ec_option_enable_easy_canada_tax') == "1" ){ echo " selected=\"selected\""; }?>>Enabled</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Alberta Tax</em>This option allows you to collect the 5% GST when shipping to Alberta customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Alberta Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_alberta_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_alberta_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_alberta_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect British Columbia Tax</em>This option allows you to collect the 5% GST + 7% PST when shipping to British Columbia customers.</span></a></span>
    <span class="ec_setting_row_label">Collect British Columbia Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_british_columbia_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_british_columbia_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_british_columbia_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Manitoba Tax</em>This option allows you to collect the 5% GST + 8% PST when shipping to Manitoba customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Manitoba Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_manitoba_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_manitoba_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_manitoba_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect New Brunswick Tax</em>This option allows you to collect the 13% HST when shipping to New Brunswick customers.</span></a></span>
    <span class="ec_setting_row_label">Collect New Brunswick Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_new_brunswick_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_new_brunswick_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_new_brunswick_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Newfoundland and Labrador Tax</em>This option allows you to collect the 13% HST when shipping to Newfoundland and Labrador customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Newfoundland and Labrador Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_newfoundland_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_newfoundland_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_newfoundland_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Northwest Territories Tax</em>This option allows you to collect the 5% GST when shipping to Northwest Territories customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Northwest Territories Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_northwest_territories_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_northwest_territories_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_northwest_territories_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Nova Scotia Tax</em>This option allows you to collect the 15% HST when shipping to Nova Scotia customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Nova Scotia Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_nova_scotia_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_nova_scotia_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_nova_scotia_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Nunavut Tax</em>This option allows you to collect the 5% GST when shipping to Nunavut customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Nunavut Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_nunavut_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_nunavut_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_nunavut_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Ontario Tax</em>This option allows you to collect the 13% HST when shipping to Ontario customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Ontario Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_ontario_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_ontario_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_ontario_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Prince Edward Island Tax</em>This option allows you to collect the 14% HST when shipping to Prince Edward Island customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Prince Edward Island Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_prince_edward_island_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_prince_edward_island_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_prince_edward_island_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Quebec Tax</em>This option allows you to collect the 5% GST + 5% PST when shipping to Quebec customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Quebec Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_quebec_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_quebec_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_quebec_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Saskatchewan Tax</em>This option allows you to collect the 5% GST + 5% PST when shipping to Saskatchewan customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Saskatchewan Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_saskatchewan_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_saskatchewan_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_saskatchewan_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect Yukon Tax</em>This option allows you to collect the 5% GST when shipping to Yukon customers.</span></a></span>
    <span class="ec_setting_row_label">Collect Yukon Tax:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_collect_yukon_tax" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_collect_yukon_tax') == "0" ){ echo " selected=\"selected\""; }?>>DO NOT Collect</option>
            <option value="1"<?php if( get_option('ec_option_collect_yukon_tax') == "1" ){ echo " selected=\"selected\""; }?>>Collect Tax</option>
        </select>
    </span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_admin_page_title">Tax Cloud Setup</div>
<div class="ec_adin_page_intro">If you want to get the best possible tax rates, Tax Cloud is your solution! If you enter API credentials here, the tax rates entered will be ignored and the Tax Cloud provided rate will be used at all times.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>API ID</em>This is the API ID provided by your Tax Cloud account.</span></a></span>
    <span class="ec_setting_row_label">API ID:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_tax_cloud_api_id" style="width:350px;" value="<?php echo get_option('ec_option_tax_cloud_api_id'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>API Key</em>This is the API Key provided by your Tax Cloud account.</span></a></span>
    <span class="ec_setting_row_label">API Key:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_tax_cloud_api_key" style="width:350px;" value="<?php echo get_option('ec_option_tax_cloud_api_key'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>USPS ID</em>This is your USPS user ID, required by tax cloud to use their service.</span></a></span>
    <span class="ec_setting_row_label">USPS ID:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_tax_cloud_usps_id" style="width:350px;" value="<?php echo get_option('ec_option_tax_cloud_usps_id'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Origin Address</em>This is the shipping FROM address for all goods.</span></a></span>
    <span class="ec_setting_row_label">Origin Address:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_tax_cloud_address" style="width:350px;" value="<?php echo get_option('ec_option_tax_cloud_address'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Origin City</em>This is the shipping FROM city for all goods.</span></a></span>
    <span class="ec_setting_row_label">Origin City:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_tax_cloud_city" style="width:350px;" value="<?php echo get_option('ec_option_tax_cloud_city'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Origin State</em>This is the shipping FROM state for all goods.</span></a></span>
    <span class="ec_setting_row_label">Origin State (2 Characters):</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_tax_cloud_state" style="width:350px;" value="<?php echo get_option('ec_option_tax_cloud_state'); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Origin Zip</em>This is the shipping FROM zip for all goods.</span></a></span>
    <span class="ec_setting_row_label">Origin Zip:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_tax_cloud_zip" style="width:350px;" value="<?php echo get_option('ec_option_tax_cloud_zip'); ?>" /></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<?php if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){ 
/* V2 ONLY */
?>
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
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

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
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

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
<?php }?>

<?php do_action( 'wpeasycart_admin_advanced_options' ); ?>
</form>