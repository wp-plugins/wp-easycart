<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "basic-settings" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_options" ){
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

<div class="ec_status_header"><div class="ec_status_header_text">Currency Display: <?php echo $GLOBALS['currency']->get_currency_display( 1999.990 ); ?></div></div>

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

<div class="ec_status_header"><div class="ec_status_header_text">Store Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Layout Format</em>This will display the products in either a grid or list view. Some product types are best displayed in a grid view, others in a list view, choose what makes the most sense for you.</span></a></span>
    <span class="ec_setting_row_label">Product Layout Format:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_layout_type" id="ec_option_product_layout_type">
                <option value="grid_only" <?php if (get_option('ec_option_product_layout_type') == 'grid_only') echo ' selected'; ?>>Grid Layout</option>
                <option value="list_only" <?php if (get_option('ec_option_product_layout_type') == 'list_only') echo ' selected'; ?>>List Layout</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Default Product Sort</em>This will set the default sort technique for the products page. For example, changing to Title A-Z will have the products sorted this way by default.</span></a></span>
    <span class="ec_setting_row_label">Default Product Sort:</span>
    <span class="ec_setting_row_input"><select name="ec_option_default_store_filter" id="ec_option_default_store_filter">
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

<div class="ec_status_header"><div class="ec_status_header_text">Cart Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Default Selected Payment Type</em>This will select the default payment type that will be displayed to the customer as the main payment type.</span></a></span>
    <span class="ec_setting_row_label">Default Selected Payment Type:</span>
    <span class="ec_setting_row_input"><select name="ec_option_default_payment_type" id="ec_option_default_payment_type">
                <option value="manual_bill" <?php if (get_option('ec_option_default_payment_type') == 'manual_bill') echo ' selected'; ?>>Manual Billing</option>
                <option value="third_party" <?php if (get_option('ec_option_default_payment_type') == 'third_party') echo ' selected'; ?>>Third Party</option>
                <option value="credit_card" <?php if (get_option('ec_option_default_payment_type') == 'credit_card') echo ' selected'; ?>>Credit Card</option>
              </select></span>
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

<div class="ec_status_header"><div class="ec_status_header_text">Account Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Add Billing Address Input on Account Registration Page</em>Enabling this option adds and requires the user to enter a billing address when creating a new account through the account page.</span></a></span>
    <span class="ec_setting_row_label">Require Billing Input on Account Registration Page:</span>
    <span class="ec_setting_row_input"><select name="ec_option_require_account_address" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_account_address') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_account_address') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_status_header"><div class="ec_status_header_text">Google Analytics Setup</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Analytics</em>This is your google analytics code that will collect eCommerce transaction data.  EasyCart analytics will not track your page data, please use a third party plugin such as Yoast or your theme for that data. This only represents the eCommerce transaction collection process so as not to overlap with another plugin.</span></a></span>
    <span class="ec_setting_row_label">Google Analytics ID for Order Tracking:</span>
    <span class="ec_setting_row_input"><input name="ec_option_googleanalyticsid" type="text" value="<?php echo get_option('ec_option_googleanalyticsid'); ?>" /></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>