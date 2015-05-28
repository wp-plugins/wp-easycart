<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "basic-settings" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_options" && isset( $_POST['ec_option_order_from_email'] ) ){
	ec_save_basic_settings( );
	$isupdate = true;
}
?>

<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Settings saved.</strong></p></div>
<?php }?> 

<div class="ec_admin_page_title">BASIC SETTINGS</div>
<div class="ec_adin_page_intro">The options displayed on this page are those that can be changed without unintended consequences. For advanced options, visit the advanced setup page.</div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-settings&ec_action=save_options" method="POST">

<div class="ec_status_header"><div class="ec_status_header_text">Basic Settings</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Order From Email</em>Emails go out to customers once an order is placed and successfully processed.  This email address represents who that email comes from and if a customer hits reply, this email is where they will respond to. If you would like a name to be displayed in the 'FROM' line, enter an email address as follows: My Name&lt;myemail@mysite.com&gt;</span></a></span>
    <span class="ec_setting_row_label">Order Receipt From Email Address:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_order_from_email" type="text"  value="<?php echo get_option('ec_option_order_from_email'); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Password Recovery From Email</em>Emails are sent to customers when they request a password reset. This email represents where that email comes from and if a customer hits reply, this email is where they will respond to. If you would like a name to be displayed in the 'FROM' line, enter an email address as follows: My Name&lt;myemail@mysite.com&gt;</span></a></span>
	<span class="ec_setting_row_label">Password Recovery From Email Address:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_password_from_email" type="text"  value="<?php echo get_option('ec_option_password_from_email'); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Admin Order Email Addresses</em>Copies of every order will be sent to these email addresses as a second email, meaning the customer will not see these email addresses. You can add multiple addresses seperated by commas. If you would like a name to be displayed in the 'FROM' line, enter an email address as follows: My Name&lt;myemail@mysite.com&gt;</span></a></span>
    <span class="ec_setting_row_label">Admin Email Address(es):</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_bcc_email_addresses" type="text"  value="<?php echo get_option('ec_option_bcc_email_addresses'); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Site Terms and Conditions Link</em>This will only work on the final checkout page. The Cart, Payment Information, Checkout Text item in the advanced language editor allows for [terms]Terms and Conditions[/terms] which will be replaced with an a link around the word between [terms] and [/terms]. It will also open into a new window.</span></a></span>
    <span class="ec_setting_row_label">Site Terms and Conditions Link:</span>
    <span class="ec_setting_row_input"><input name="ec_option_terms_link" type="text"  value="<?php echo get_option('ec_option_terms_link'); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Site Privacy Policy Link</em>This will only work on the final checkout page. The Cart, Payment Information, Checkout Text item in the advanced language editor allows for [privacy]Privacy Policy[/privacy] which will be replaced with an a link around the word between [privacy] and [/privacy]. It will also open into a new window.</span></a></span>
    <span class="ec_setting_row_label">Site Privacy Policy Link:</span>
    <span class="ec_setting_row_input"><input name="ec_option_privacy_link" type="text"  value="<?php echo get_option('ec_option_privacy_link'); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Weight Unit</em>Weight unit is displayed for weight adjustment of an order and to display.  Please note that all live shipping options use their own weight choice and should be selected when live shipping is setup.</span></a></span>
    <span class="ec_setting_row_label">Weight Unit:</span>
    <span class="ec_setting_row_input"><select name="ec_option_weight">
              <option value="0"<?php if(get_option('ec_option_weight') == '0') echo ' selected'; ?>>Select a Weight Unit</option>
              <option value="lbs"<?php if(get_option('ec_option_weight') == 'lbs') echo ' selected'; ?>>LBS</option>
              <option value="kgs"<?php if(get_option('ec_option_weight') == 'kgs') echo ' selected'; ?>>KGS</option>
          </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Cart Icon Link in Menu</em>If you turn this on and select a menu to display this item in, a cart icon with total and number of items in cart is displayed in your menu.</span></a></span>
    <span class="ec_setting_row_label">Show Cart Icon Link in Menu:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_menu_cart_icon" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_menu_cart_icon') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_menu_cart_icon') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row" style="height:auto">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Cart Icon Menu</em>If you turn on the option to show cart icon link in the menu, then you can select the menu in which you want the icon to appear for this option.</span></a></span>
    <span class="ec_setting_row_label">Cart Icon Menu:</span>
    <span class="ec_setting_row_input">
    <select multiple name="ec_option_cart_menu_id[]" style="width:auto; max-width:350px;">
    	<option value="0"<?php if( get_option('ec_option_cart_menu_id') == "0" ){ echo " selected=\"selected\""; }?>>No Menu</option>
        <?php 
		$ids = explode( '***', get_option('ec_option_cart_menu_id') );
		
		$menus = get_registered_nav_menus( );
		$keys = array_keys( $menus );
		foreach ( $keys as $key ) {
			echo '<option value="' . $key . '"';
			if( in_array( $key, $ids ) ){ 
				echo " selected=\"selected\""; 
			}
			echo '>' . $menus[$key] . '</option>';
		}
		?>
    </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Newsletter Popup on Site</em>If you turn this on, a user will be prompted to sign up for your newsletter subscription list when they visit your site. Their sign up is tracked by session and cookie through their browser, so once they sign up or hide the box, they will not be shown it again.</span></a></span>
    <span class="ec_setting_row_label">Show Newsletter Popup on Site:</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_newsletter_popup" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_newsletter_popup') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_enable_newsletter_popup') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Hide Live Design Editor from Admin</em>If you turn this on, you will not be able to edit the design of your site from page to page. This is great to turn on if you want to lock in your store design or if you are having difficulties with the browser displaying the high number of elements required for the live editor.</span></a></span>
    <span class="ec_setting_row_label">Hide Live Design Editor from Admin:</span>
    <span class="ec_setting_row_input"><select name="ec_option_hide_live_editor" style="width:100px;"><option value="0"<?php if( get_option('ec_option_hide_live_editor') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_hide_live_editor') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Currency Display: <?php echo $GLOBALS['currency']->get_currency_display( 1999.990 ); ?></div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Base Currency Code</em>This is the currency your store is based in. If you choose to use the currency conversion option to allow customers to see the store in alternate currencies, the store will convert from this to another currency for display, but final checkout must be in the currency setup for your payment gateway.</span></a></span>
    <span class="ec_setting_row_label">Base Currency Code:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_base_currency" value="<?php echo get_option('ec_option_base_currency'); ?>"></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Currency Symbol</em>All currency symbols can easily be changed here.  Please note that all payment processors determine the actual payment currency, not this symbol.  Check with your payment processor to ensure you are processing in the proper currency that you need, then apply the currency symbol here to align your store.</span></a></span>
    <span class="ec_setting_row_label">Currency Symbol:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_currency" value="<?php echo get_option('ec_option_currency'); ?>"></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Currency Location</em>You can choose to have currency symbols in front of the numbers, or trailing the numbers.  This is usually country specific.</span></a></span>
    <span class="ec_setting_row_label">Currency Symbol Location:</span>
    <span class="ec_setting_row_input"><select name="ec_option_currency_symbol_location" id="ec_option_currency_symbol_location">
            <option value="1" <?php if (get_option('ec_option_currency_symbol_location') == 1) echo ' selected'; ?>>Left</option>
            <option value="0" <?php if (get_option('ec_option_currency_symbol_location') == 0) echo ' selected'; ?>>Right</option>
          </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Negative Symbol Location</em>You can choose to have the negative symbol in front of the currency symbol or behind.  This is usually country specific</span></a></span>
    <span class="ec_setting_row_label">Negative Location:</span>
    <span class="ec_setting_row_input"><select name="ec_option_currency_negative_location" id="ec_option_currency_negative_location">
                <option value="1" <?php if (get_option('ec_option_currency_negative_location') == 1) echo ' selected'; ?>>Before</option>
                <option value="0" <?php if (get_option('ec_option_currency_negative_location') == 0) echo ' selected'; ?>>After</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Decimal Symbol</em>You can choose to have a decimal symbol represented by something besides the standard period. Some countries represent the decimal with a comma.</span></a></span>
    <span class="ec_setting_row_label">Currency Decimal Symbol:</span>
    <span class="ec_setting_row_input"><input name="ec_option_currency_decimal_symbol" type="text" value="<?php echo get_option('ec_option_currency_decimal_symbol'); ?>" size="1" style="width:40px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Decimal Length</em>Choose how many decimals are to be represented after the decimal symbol.  Most countries are 2 decimal places, some countries are 3 decimal places.</span></a></span>
    <span class="ec_setting_row_label">Currency Decimal Length:</span>
    <span class="ec_setting_row_input"><input name="ec_option_currency_decimal_places" type="text" value="<?php echo get_option('ec_option_currency_decimal_places'); ?>" size="1" style="width:40px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Grouping Symbol</em>You may choose what symbol reprsents your thousands seperator.  Most countries represent this with a comma, but you can enter another value depending on your countries typical format.</span></a></span>
    <span class="ec_setting_row_label">Currency Grouping Symbol:</span>
    <span class="ec_setting_row_input"><input name="ec_option_currency_thousands_seperator" type="text" value="<?php echo get_option('ec_option_currency_thousands_seperator'); ?>" size="1" style="width:40px;" /></span>
</div>
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Store Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Layout Format (V2 ONLY)</em>This will display the products in either a grid or list view. Some product types are best displayed in a grid view, others in a list view, choose what makes the most sense for you. For V3 users, you can choose the list type 6 from the product display types in the live editor on the store page and set your columns to 1.</span></a></span>
    <span class="ec_setting_row_label">Product Layout Format (V2 ONLY):</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_layout_type" id="ec_option_product_layout_type">
                <option value="grid_only" <?php if (get_option('ec_option_product_layout_type') == 'grid_only') echo ' selected'; ?>>Grid Layout</option>
                <option value="list_only" <?php if (get_option('ec_option_product_layout_type') == 'list_only') echo ' selected'; ?>>List Layout</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Default Product Sort</em>This will set the default sort technique for the products page. For example, changing to Title A-Z will have the products sorted this way by default.</span></a></span>
    <span class="ec_setting_row_label">Default Product Sort:</span>
    <span class="ec_setting_row_input"><select name="ec_option_default_store_filter" id="ec_option_default_store_filter">
                <option value="0" <?php if (get_option('ec_option_default_store_filter') == '0') echo ' selected'; ?>>Default Sorting</option>
                <option value="1" <?php if (get_option('ec_option_default_store_filter') == '1') echo ' selected'; ?>>Price Low-High</option>
                <option value="2" <?php if (get_option('ec_option_default_store_filter') == '2') echo ' selected'; ?>>Price High-Low</option>
                <option value="3" <?php if (get_option('ec_option_default_store_filter') == '3') echo ' selected'; ?>>Title A-Z</option>
                <option value="4" <?php if (get_option('ec_option_default_store_filter') == '4') echo ' selected'; ?>>Title Z-A</option>
                <option value="5" <?php if (get_option('ec_option_default_store_filter') == '5') echo ' selected'; ?>>Newest</option>
                <option value="6" <?php if (get_option('ec_option_default_store_filter') == '6') echo ' selected'; ?>>Best Rating</option>
                <option value="7" <?php if (get_option('ec_option_default_store_filter') == '7') echo ' selected'; ?>>Most Viewed</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Price Low-High" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_1" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_1') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_1') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Price High-Low" Sort Option:</span><span class="ec_setting_row_input"><select name="ec_option_product_filter_2" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_2') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_2') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Title A-Z" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_3" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_3') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_3') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Title Z-A" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_4" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_4') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_4') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Newest" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_5" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_5') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_5') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Best Rating" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_6" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_6') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_6') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Most Viewed" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_7" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_7') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_7') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Paged Product List</em>By turning this on/off you can enable/disable the ability to limit the products per page and show the paging information on the store.</span></a></span>
    <span class="ec_setting_row_label">Paged Product List:</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_product_paging" id="select">
                  <option value="1" <?php if (get_option('ec_option_enable_product_paging') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_enable_product_paging') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Sorting Box</em>By turning this on/off you can show/hide the sorting box on the products page.</span></a></span>
    <span class="ec_setting_row_label">Show Sorting Box:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_sort_box" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_sort_box') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_sort_box') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Product Details Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Facebook Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_facebook_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_facebook_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_facebook_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show Twitter Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_twitter_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_twitter_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_twitter_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show Delicious Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_delicious_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_delicious_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_delicious_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show MySpace Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_myspace_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_myspace_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_myspace_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show LinkedIn Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_linkedin_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_linkedin_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_linkedin_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show Email Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_email_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_email_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_email_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Digg Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_digg_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_digg_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_digg_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Google+ Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_googleplus_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_googleplus_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_googleplus_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Pinterest Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_pinterest_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_pinterest_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_pinterest_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Breadcrumbs</em>By turning this option on/off you are showing and hiding the breadcrumbs display within the product details page (only applies to the store not your theme).</span></a></span>
    <span class="ec_setting_row_label">Show Breadcrumbs:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_breadcrumbs" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_breadcrumbs') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_breadcrumbs') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Model Number</em>By turning this option on/off you are showing and hiding the model number display within the product details page.</span></a></span>
    <span class="ec_setting_row_label">Show Model Number:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_model_number" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_model_number') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_model_number') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Categories</em>By turning this option on/off you are showing and hiding the categories display within the product details page if the product is attached to categories.</span></a></span>
    <span class="ec_setting_row_label">Show Categories:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_categories" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_categories') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_categories') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Manufacturer</em>By turning this option on/off you are showing and hiding the manufacturer link display within the product details page if the product.</span></a></span>
    <span class="ec_setting_row_label">Show Manufacturer:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_manufacturer" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_manufacturer') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_manufacturer') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Image Magnification Box</em>By turning this option on/off you are showing or hiding the hover magnification box on the product details page.</span></a></span>
    <span class="ec_setting_row_label">Use Image Magnification Box:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_magnification" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_magnification') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_magnification') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Popup Large Image View</em>By turning this option on/off you are allowing or disallowing the popup box with a large image view.</span></a></span>
    <span class="ec_setting_row_label">Show Popup Large Image View:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_large_popup" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_large_popup') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_large_popup') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require User Logged in to Review</em>By turning this option on/off are allowing anonymous custom reviews or requiring the user to sign in first to review.</span></a></span>
    <span class="ec_setting_row_label">Require User Logged in to Review:</span>
    <span class="ec_setting_row_input"><select name="ec_option_customer_review_require_login" id="select">
                  <option value="1" <?php if (get_option('ec_option_customer_review_require_login') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_customer_review_require_login') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show User's Name on Customer Review (if available)</em>By turning this option on/off are showing the review user's name. This applies only to users that are logged into their EasyCart account during submission.</span></a></span>
    <span class="ec_setting_row_label">Show User's Name on Customer Review:</span>
    <span class="ec_setting_row_input"><select name="ec_option_customer_review_show_user_name" id="select">
                  <option value="1" <?php if (get_option('ec_option_customer_review_show_user_name') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_customer_review_show_user_name') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Hide Price for Seasonal Mode Products</em>By turning this on, you can hide the price for any seasonal mode products.</span></a></span>
    <span class="ec_setting_row_label">Hide Price for Seasonal Mode Products:</span>
    <span class="ec_setting_row_input"><select name="ec_option_hide_price_seasonal" id="select">
                  <option value="0" <?php if (get_option('ec_option_hide_price_seasonal') == 0) echo ' selected'; ?>>No</option>
                  <option value="1" <?php if (get_option('ec_option_hide_price_seasonal') == 1) echo ' selected'; ?>>Yes</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Hide Price for Inquiry Mode Products</em>By turning this on, you can hide the price for any inquiry mode products.</span></a></span>
    <span class="ec_setting_row_label">Hide Price for Inquiry Mode Products:</span>
    <span class="ec_setting_row_input"><select name="ec_option_hide_price_inquiry" id="select">
                  <option value="0" <?php if (get_option('ec_option_hide_price_inquiry') == 0) echo ' selected'; ?>>No</option>
                  <option value="1" <?php if (get_option('ec_option_hide_price_inquiry') == 1) echo ' selected'; ?>>Yes</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Vat Included and Excluded Prices</em>By turning this on, if you are using VAT, the user will see the price of the product with and without VAT.</span></a></span>
    <span class="ec_setting_row_label">Show Vat Included and Excluded Prices:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_multiple_vat_pricing" id="select">
                  <option value="0" <?php if (get_option('ec_option_show_multiple_vat_pricing') == 0) echo ' selected'; ?>>No</option>
                  <option value="1" <?php if (get_option('ec_option_show_multiple_vat_pricing') == 1) echo ' selected'; ?>>Yes</option>
              	</select></span>
</div>

<a id="cart-settings"></a>
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Cart Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Default Selected Payment Type</em>This will select the default payment type that will be displayed to the customer as the main payment type.</span></a></span>
    <span class="ec_setting_row_label">Default Selected Payment Type:</span>
    <span class="ec_setting_row_input"><select name="ec_option_default_payment_type" id="ec_option_default_payment_type">
                <option value="manual_bill" <?php if (get_option('ec_option_default_payment_type') == 'manual_bill') echo ' selected'; ?>>Manual Billing</option>
                <option value="affirm" <?php if (get_option('ec_option_default_payment_type') == 'affirm') echo ' selected'; ?>>Affirm</option>
                <option value="third_party" <?php if (get_option('ec_option_default_payment_type') == 'third_party') echo ' selected'; ?>>Third Party</option>
                <option value="credit_card" <?php if (get_option('ec_option_default_payment_type') == 'credit_card') echo ' selected'; ?>>Credit Card</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>International Country Box Position</em>If you expect international orders, it is best to display the country drop down box before the rest of the form. This allows the form to change based on the country selected and helps with compatibility for user inputs. This requires you have the latest design files.</span></a></span>
    <span class="ec_setting_row_label">International Country Box Position:</span>
    <span class="ec_setting_row_input"><select name="ec_option_display_country_top" style="width:100px;"><option value="0"<?php if( get_option('ec_option_display_country_top') == "0" ){ echo " selected=\"selected\""; }?>>Below Zip</option><option value="1"<?php if( get_option('ec_option_display_country_top') == "1" ){ echo " selected=\"selected\""; }?>>Top of Form</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Second Address Line</em>Display two address lines for input on checkout form and account.</span></a></span>
    <span class="ec_setting_row_label">Use Second Address Line:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_address2" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_address2') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_address2') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect User Phone Number</em>If enabled, the system will collect the phone number from the user.</span></a></span>
    <span class="ec_setting_row_label">Collect User Phone Number:</span>
    <span class="ec_setting_row_input"><select name="ec_option_collect_user_phone" style="width:100px;"><option value="0"<?php if( get_option('ec_option_collect_user_phone') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_collect_user_phone') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Company Name in Address</em>If enabled, the system will offer a place for an optional company name for a user's address.</span></a></span>
    <span class="ec_setting_row_label">Enable Company Name in Address:</span>
    <span class="ec_setting_row_input">
    <select name="ec_option_enable_company_name" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_company_name') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_enable_company_name') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Guest Checkout</em>When guest checkout is enabled a user has the option complete the checkout process without entering a password for an account. All the same information is recorded when a user checks out as a guest, but no user is created for that order. In addition, the customer cannot return to the site to see their past orders.</span></a></span>
    <span class="ec_setting_row_label">Enable Guest Checkout:</span>
    <span class="ec_setting_row_input"><select name="ec_option_allow_guest" style="width:100px;"><option value="0"<?php if( get_option('ec_option_allow_guest') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_allow_guest') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Shipping in Store</em>Disabling this option will hide shipping on checkout, addres review, receipts, and in the account from the user. It will also override any shipping options you may have setup previously. The customer will only be able to enter billing information on checkout if this is disabled. NOTE: users who had first install prior to 1.1.18 will need to upgrade their layout files in order to leverage this option.</span></a></span>
    <span class="ec_setting_row_label">Enable Shipping in Store:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Customer Notes on Checkout</em>Enabling this option will allow customers to enter custom notes on the last step of checkout. NOTE: users for had a first install prior to 1.1.18 will need to update their layout and theme fiiles manually in order to use this option.</span></a></span>
    <span class="ec_setting_row_label">Enable Customer Notes on Checkout:</span>
    <span class="ec_setting_row_input"><select name="ec_option_user_order_notes" style="width:100px;"><option value="0"<?php if( get_option('ec_option_user_order_notes') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_user_order_notes') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Gift Cards</em>Enabling/Disabling will essentially show or hide the gift card box during checkout.</span></a></span>
    <span class="ec_setting_row_label">Enable Gift Cards:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_giftcards" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_giftcards') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_giftcards') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Coupon Codes</em>Enabling/Disabling will essentially show or hide the coupon code box during checkout.</span></a></span>
    <span class="ec_setting_row_label">Enable Coupon Codes:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_coupons" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_coupons') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_coupons') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Return To Previous Page after Add to Cart Success</em>If enabled, the user will be returned to the store page or previous product page with a notice about add to cart success. This option actually returns to the previous page on the server, so if you use a widget or shortcode you may see a different result. If you leave this off the customer is still forwarded to the cart.</span></a></span>
    <span class="ec_setting_row_label">Return To Previous Page after Add to Cart:</span>
    <span class="ec_setting_row_input"><select name="ec_option_addtocart_return_to_product" style="width:100px;"><option value="0"<?php if( get_option('ec_option_addtocart_return_to_product') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_addtocart_return_to_product') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<?php if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){ 
/* V2 ONLY */
?>
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Skip Login Screen in Cart</em>If enabled, the system will skip the screen to log into your account first. This option will speed up checkout for new users and, if you have the latest design files, will still display the log in screen at the top.</span></a></span>
    <span class="ec_setting_row_label">Skip Login Screen in Cart:</span>
    <span class="ec_setting_row_input"><select name="ec_option_skip_cart_login" style="width:100px;"><option value="0"<?php if( get_option('ec_option_skip_cart_login') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_skip_cart_login') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>
<?php }?>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Skip Shipping Cart Panel</em>If enabled, the system will skip the panel in the cart where the user is asked to select their shipping method. This data is instead collected on the final checkout page if needed.</span></a></span>
    <span class="ec_setting_row_label">Skip Shipping Cart Panel:</span>
    <span class="ec_setting_row_input"><select name="ec_option_skip_shipping_page" style="width:100px;"><option value="0"<?php if( get_option('ec_option_skip_shipping_page') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_skip_shipping_page') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<?php if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){ 
/* V2 ONLY */
?>
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Skip Review Order Screen</em>If enabled, the system will submit the order directly after they enter their payment information. The review screen is useful for orders that require shipping and often have multiple items.</span></a></span>
    <span class="ec_setting_row_label">Skip Review Order Screen:</span>
    <span class="ec_setting_row_input"><select name="ec_option_skip_reivew_screen" style="width:100px;"><option value="0"<?php if( get_option('ec_option_skip_reivew_screen') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_skip_reivew_screen') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>
<?php }?>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Terms Agreement</em>If enabled, the system requires the users to agree to the terms and conditions of the website.</span></a></span>
    <span class="ec_setting_row_label">Require Terms Agreement:</span>
    <span class="ec_setting_row_input"><select name="ec_option_require_terms_agreement" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_terms_agreement') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_terms_agreement') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Name for Contact Information</em>If enabled, the checkout will require a user to input their first and last name during the creation of an account (this is separate from the billing and shipping information).</span></a></span>
    <span class="ec_setting_row_label">Require Name for Contact Information:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_contact_name" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_contact_name') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_contact_name') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Estimate Shipping</em>If enabled, your customer will see an estimate shipping area during the checkout process.</span></a></span>
    <span class="ec_setting_row_label">Enable Estimate Shipping:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_estimate_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_estimate_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_estimate_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Email on Receipt</em>If enabled, your email receipts will include the email address of the customer on the receipt.</span></a></span>
    <span class="ec_setting_row_label">Show Email on Receipt:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_email_on_receipt" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_email_on_receipt') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_email_on_receipt') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Tax Shipping</em>If enabled, tax will be collected for shipping (does not apply to tax cloud, which automatically determines if shipping should be taxed on a stated to state basis).</span></a></span>
    <span class="ec_setting_row_label">Tax Shipping:</span>
    <span class="ec_setting_row_input"><select name="ec_option_collect_tax_on_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_collect_tax_on_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_collect_tax_on_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Account Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Add Billing Address Input on Account Registration Page</em>Enabling this option adds and requires the user to enter a billing address when creating a new account through the account page.</span></a></span>
    <span class="ec_setting_row_label">Require Billing Input on Account Registration Page:</span>
    <span class="ec_setting_row_input"><select name="ec_option_require_account_address" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_account_address') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_account_address') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Email Validation on Registration</em>Enabling this option will require a user to click a link in an email sent to their registered email account before they can use their account.</span></a></span>
    <span class="ec_setting_row_label">Require Email Validation on Registration:</span>
    <span class="ec_setting_row_input"><select name="ec_option_require_email_validation" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_email_validation') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_email_validation') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Manage Subscriptions Link</em>You should only leave this enabled if you are using subscriptions or memberships with the store, otherwise it will not apply to you. Additionally, since subscriptions and memberships are only available with the Stripe payment processor, you must have this selected for your credit card processor to display.</span></a></span>
    <span class="ec_setting_row_label">Show Manage Subscriptions Link:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_account_subscriptions_link" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_account_subscriptions_link') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_account_subscriptions_link') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Custom User Notes on Registration</em>You can require a user registering for your site through the account area to enter some kind of user notes. This is commonly used when a user is required to validate themselves in some way. You can customize the instructions for this field through the advanced language area of the site.</span></a></span>
    <span class="ec_setting_row_label">Require Custom User Notes on Registration:</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_user_notes" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_user_notes') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_enable_user_notes') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Google Analytics Setup</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Analytics</em>This is your google analytics code that will collect eCommerce transaction data.  EasyCart analytics will not track your page data, please use a third party plugin such as Yoast or your theme for that data. This only represents the eCommerce transaction collection process so as not to overlap with another plugin.</span></a></span>
    <span class="ec_setting_row_label">Google Analytics ID for Order Tracking:</span>
    <span class="ec_setting_row_input"><input name="ec_option_googleanalyticsid" type="text" value="<?php echo get_option('ec_option_googleanalyticsid'); ?>" /></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>