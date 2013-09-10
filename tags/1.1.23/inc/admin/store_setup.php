<?php 

$validate = new ec_validation; 
$license = new ec_license;

if(isset($_POST['isupdate'])){
	
	//update options
	update_option( 'ec_option_currency', $_POST['ec_option_currency'] );
	update_option( 'ec_option_currency_decimal_symbol', $_POST['ec_option_currency_decimal_symbol'] );
	update_option( 'ec_option_currency_decimal_places', $_POST['ec_option_currency_decimal_places'] );
	update_option( 'ec_option_currency_thousands_seperator', $_POST['ec_option_currency_thousands_seperator'] );
	update_option( 'ec_option_order_from_email', $_POST['ec_option_order_from_email'] );
	update_option( 'ec_option_password_from_email', $_POST['ec_option_password_from_email'] );
	update_option( 'ec_option_bcc_email_addresses', $_POST['ec_option_bcc_email_addresses'] );
	update_option( 'ec_option_use_state_dropdown', $_POST['ec_option_use_state_dropdown'] );
	update_option( 'ec_option_use_country_dropdown', $_POST['ec_option_use_country_dropdown'] );
	update_option( 'ec_option_default_store_filter', $_POST['ec_option_default_store_filter'] );
	update_option( 'ec_option_default_payment_type', $_POST['ec_option_default_payment_type'] );
	update_option( 'ec_option_allow_guest', $_POST['ec_option_allow_guest'] );
	update_option( 'ec_option_use_shipping', $_POST['ec_option_use_shipping'] );
	update_option( 'ec_option_user_order_notes', $_POST['ec_option_user_order_notes'] );
	update_option( 'ec_option_terms_link', $_POST['ec_option_terms_link'] );
	update_option( 'ec_option_privacy_link', $_POST['ec_option_privacy_link'] );

	update_option( 'ec_option_googleanalyticsid', $_POST['ec_option_googleanalyticsid'] );

}

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

?>
<div class="wrap">
<?php if( !$license->is_registered() && !$license->is_lite_version() ) { ?>
<div class="ribbon">You are running the WP EasyCart FREE version. To purchase the LITE or FULL version and unlock the full selling potential visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a> and purchase a license.</div>
<?php }else if( $license->is_lite_version() && $license->show_lite_message() ) { ?>
<div class="ribbon">You are running the WP EasyCart Lite version. To learn more about what you are missing with the Full version visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a>. To dismiss this banner <a href="?page=ec_setup&dismiss_lite_banner=true">click here.</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

<?php if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ){ ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  

<div class="ec_contentwrap">
    
    <h2>Basic Settings</h2>
    <form method="post" action="options.php">
      <p>
        <?php settings_fields( 'ec-store-setup-group' ); ?>
      </p>
      <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
        <tr valign="top">
          <td width="36%" align="left" class="platformheading" scope="row">Store Settings and Functionality:</td>
          <td width="64%" valign="top" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
        </tr>
        <tr valign="top">
          <td colspan="2" align="left" scope="row">Configure which options you wish to have on your store by enabling and disabling them below. Changes to these settings will have immediate effect on your store. It is best to set them up prior to starting your business and have established policies with regards to these settings in place from the start.</td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Email Order Receipts come from:<br />
            <span class="itemsubheading">(This email represents where Order receipt emails
          come from)</span></td>
          <td valign="top"><input name="ec_option_order_from_email" type="text"  value="<?php echo get_option('ec_option_order_from_email'); ?>" size="10" style="width:300px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Order From Email</em>Emails go out to customers once an order is placed and successfully processed.  This email address represents who that email comes from and if a customer hits reply, this email is where they will respond to.</span></a>
          
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row"><p>Email Password Recoverys come from:<br />
              <span class="itemsubheading">(This email represents where password recovery emails
          come from)</span></p></td>
          <td valign="top"><input name="ec_option_password_from_email" type="text"  value="<?php echo get_option('ec_option_password_from_email'); ?>" size="10" style="width:300px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Password Recovery From Email</em>Emails are sent to customers when they request a password reset.  This email represents where that email comes from and if a customer hits reply, this email is where they will respond to.</span></a>
          
          
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row"><p>Admin Email Addresses for Orders:<br />
              <span class="itemsubheading">(These are the email addresses that will receive a copy of customer orders.)</span></p></td>
          <td valign="top"><input name="ec_option_bcc_email_addresses" type="text"  value="<?php echo get_option('ec_option_bcc_email_addresses'); ?>" size="10" style="width:300px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Admin Order Email Addresses</em>Copies of every order will be sent to these email addresses as a second email, meaning the customer will not see these email addresses. You can add multiple addresses seperated by commas.</span></a>
          
          
          </td>
        </tr>
        
        <tr valign="top">
          <td align="left" class="itemheading" scope="row"><p>Site Terms and Conditions Link:<br />
              <span class="itemsubheading">(This will link on the final cart page message when you enter [terms]terms and conditions[/terms] in the text).</span></p></td>
          <td valign="top"><input name="ec_option_terms_link" type="text"  value="<?php echo get_option('ec_option_terms_link'); ?>" size="10" style="width:300px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Site Terms and Conditions Link</em>This will only work on the final checkout page. The Cart, Payment Information, Checkout Text item in the advanced language editor allows for [terms]Terms and Conditions[/terms] which will be replaced with an a link around the word between [terms] and [/terms]. It will also open into a new window.</span></a>
          
          
          </td>
        </tr>
        
        <tr valign="top">
          <td align="left" class="itemheading" scope="row"><p>Site Privacy Policy Link:<br />
              <span class="itemsubheading">(This will link on the final cart page message when you enter [privacy]privacy policy[/privacy] in the text).</span></p></td>
          <td valign="top"><input name="ec_option_privacy_link" type="text"  value="<?php echo get_option('ec_option_privacy_link'); ?>" size="10" style="width:300px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Site Privacy Policy Link</em>This will only work on the final checkout page. The Cart, Payment Information, Checkout Text item in the advanced language editor allows for [privacy]Privacy Policy[/privacy] which will be replaced with an a link around the word between [privacy] and [/privacy]. It will also open into a new window.</span></a>
          
          
          </td>
        </tr>
        
        
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Use State Drop Down List for Addresses:<br />
            <span class="itemsubheading">(You may edit the list using our admin console)</span></td>
          <td valign="top"><select name="ec_option_use_state_dropdown" id="ec_option_use_state_dropdown">
            <option value="1" <?php if (get_option('ec_option_use_state_dropdown') == 1) echo ' selected'; ?>>Yes</option>
            <option value="0" <?php if (get_option('ec_option_use_state_dropdown') == 0) echo ' selected'; ?>>No</option>
          </select>
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>State Drop Downs</em>Depending on your country, you may choose to allow state drop downs or if disabled, customers will have an open text box to enter their state or province.  This varies from country to country.  You may edit the list in the drop down within the admin console software.</span></a>
          
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Use Country Drop Down List for Addresses:<br />
          <span class="itemsubheading">(You may edit the list using our admin console)</span></td>
          <td valign="top"><select name="ec_option_use_country_dropdown" id="ec_option_use_country_dropdown">
            <option value="1" <?php if (get_option('ec_option_use_country_dropdown') == 1) echo ' selected'; ?>>Yes</option>
            <option value="0" <?php if (get_option('ec_option_use_country_dropdown') == 0) echo ' selected'; ?>>No</option>
          </select>
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Country Drop Downs</em>Country drop downs allow you to choose to have a pull down for the country, or to have an open text box for the country.  For consistent data, it is best to leave this option on.  you can edit the list of countries in the pulldown by using the admin console software.</span></a>
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Currency Symbol:<br />
            <span class="itemsubheading">(The currency symbol to represent throughout your store)</span></td>
          <td valign="top">
          <input type="text" name="ec_option_currency" value="<?php echo get_option('ec_option_currency'); ?>">
          
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Currency Symbol</em>All currency symbols can easily be changed here.  Please note that all payment processors determine the actual payment currency, not this symbol.  Check with your payment processor to ensure you are processing in the proper currency that you need, then apply the currency symbol here to align your store.</span></a>
          
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Currency Symbol Location:<br />
            <span class="itemsubheading">(Some countries display the currency symbol to the left, others to the right.)</span></td>
          <td valign="top"><select name="ec_option_currency_symbol_location" id="ec_option_currency_symbol_location">
            <option value="1" <?php if (get_option('ec_option_currency_symbol_location') == 1) echo ' selected'; ?>>Left</option>
            <option value="0" <?php if (get_option('ec_option_currency_symbol_location') == 0) echo ' selected'; ?>>Right</option>
          </select>
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Currency Location</em>You can choose to have currency symbols in front of the numbers, or trailing the numbers.  This is usually country specific.</span></a>
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Negative Location:<br />
          <span class="itemsubheading">(Place negative symbol before or after the currency symbol. Ex: -$9.00 or $-9.00. This does not apply to display when currency symbol appears on the right.)</span></td>
          <td valign="top">
              <select name="ec_option_currency_negative_location" id="ec_option_currency_negative_location">
                <option value="1" <?php if (get_option('ec_option_currency_negative_location') == 1) echo ' selected'; ?>>Before</option>
                <option value="0" <?php if (get_option('ec_option_currency_negative_location') == 0) echo ' selected'; ?>>After</option>
              </select>
              <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Negative Symbol Location</em>You can choose to have the negative symbol in front of the currency symbol or behind.  This is usually country specific</span></a>
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Currency Decimal Symbol:<br />
            <span class="itemsubheading">(This symbol represents the decimal, usually a period, comma, or space)</span></td>
          <td valign="top"><input name="ec_option_currency_decimal_symbol" type="text" value="<?php echo get_option('ec_option_currency_decimal_symbol'); ?>" size="1" style="width:40px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Decimal Symbol</em>You can choose to have a decimal symbol represented by something besides the standard period.  Some countries represent the decimal with a comma. </span></a>
          </td>
          
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Currency Decimal Length:<br />
            <span class="itemsubheading">(The decimal  length, usually 0, 2 or 3)</span></td>
          <td valign="top"><input name="ec_option_currency_decimal_places" type="text" value="<?php echo get_option('ec_option_currency_decimal_places'); ?>" size="1" style="width:40px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Decimal Length</em>Choose how many decimals are to be represented after the decimal symbol.  Most countries are 2 decimal places, some countries are 3 decimal places.</span></a>
          
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Currency Grouping Symbol:<br />
            <span class="itemsubheading">(The group seperator, usually a period, comma, or a space)</span></td>
          <td valign="top"><input name="ec_option_currency_thousands_seperator" type="text" value="<?php echo get_option('ec_option_currency_thousands_seperator'); ?>" size="1" style="width:40px;" />
          <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Grouping Symbol</em>You may choose what symbol reprsents your thousands seperator.  Most countries represent this with a comma, but you can enter another value depending on your countries typical format.</span></a>
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Default Product Sort:<br />
          <span class="itemsubheading">This is in the filter bar on the products list page and is the default first selection.</span></td>
          <td valign="top">
              <select name="ec_option_default_store_filter" id="ec_option_default_store_filter">
                <option value="1" <?php if (get_option('ec_option_default_store_filter') == '1') echo ' selected'; ?>>Price Low-High</option>
                <option value="2" <?php if (get_option('ec_option_default_store_filter') == '2') echo ' selected'; ?>>Price High-Low</option>
                <option value="3" <?php if (get_option('ec_option_default_store_filter') == '3') echo ' selected'; ?>>Title A-Z</option>
                <option value="4" <?php if (get_option('ec_option_default_store_filter') == '4') echo ' selected'; ?>>Title Z-A</option>
                <option value="5" <?php if (get_option('ec_option_default_store_filter') == '5') echo ' selected'; ?>>Newest</option>
                <option value="6" <?php if (get_option('ec_option_default_store_filter') == '6') echo ' selected'; ?>>Best Rating</option>
                <option value="7" <?php if (get_option('ec_option_default_store_filter') == '7') echo ' selected'; ?>>Most Viewed</option>
              </select>
              <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Default Product Sort</em>This will set the default sort technique for the products page. For example, changing to Title A-Z will have the products sorted this way by default.</span></a>
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Default Selected Payment Type:<br />
          <span class="itemsubheading">This is the payment type that is automatically selected and open on the final cart page.</span></td>
          <td valign="top">
              <select name="ec_option_default_payment_type" id="ec_option_default_payment_type">
                <option value="manual_bill" <?php if (get_option('ec_option_default_payment_type') == 'manual_bill') echo ' selected'; ?>>Manual Billing</option>
                <option value="third_party" <?php if (get_option('ec_option_default_payment_type') == 'third_party') echo ' selected'; ?>>Third Party</option>
                <option value="credit_card" <?php if (get_option('ec_option_default_payment_type') == 'credit_card') echo ' selected'; ?>>Credit Card</option>
              </select>
              <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Default Product Sort</em>This will set the default sort technique for the products page. For example, changing to Title A-Z will have the products sorted this way by default.</span></a>
          </td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Enable Guest Checkout:</td>
          <td valign="top"><select name="ec_option_allow_guest" style="width:100px;"><option value="0"<?php if( get_option('ec_option_allow_guest') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_allow_guest') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Enable Guest Checkout</em>When guest checkout is enabled a user has the option complete the checkout process without entering a password for an account. All the same information is recorded when a user checks out as a guest, but no user is created for that order. In addition, the customer cannot return to the site to see their past orders.</span></a></td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Enable Shipping in Store:</td>
          <td valign="top"><select name="ec_option_use_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Enable Shipping in Store</em>Disabling this option will hide shipping on checkout, addres review, receipts, and in the account from the user. It will also override any shipping options you may have setup previously. The customer will only be able to enter billing information on checkout if this is disabled. NOTE: users who had first install prior to 1.1.18 will need to upgrade their layout files in order to leverage this option.</span></a></td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Enable Customer Notes on Checkout:</td>
          <td valign="top"><select name="ec_option_user_order_notes" style="width:100px;"><option value="0"<?php if( get_option('ec_option_user_order_notes') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_user_order_notes') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Enable Customer Notes on Checkout</em>Enabling this option will allow customers to enter custom notes on the last step of checkout. NOTE: users for had a first install prior to 1.1.18 will need to update their layout and theme fiiles manually in order to use this option.</span></a></td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">Use RTL Support (Right to Left Text):</td>
          <td valign="top"><select name="ec_option_use_rtl" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_rtl') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_rtl') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>RTL Support</em>RTL support is the method of setting all items in the store to be viewed with RTL direction text. We have also done some custom css to specific parts of the store to look more correct for RTL languages. In no way is this perfect though, or available in all themes. Please contact WP EasyCart with questions if you have any issues with our RTL support option.</span></a></td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row"><span class="submit">
            <input type="hidden" name="isupdate2" value="1" />
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
          </span></td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td align="left" class="itemheading" scope="row">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
            
            <tr valign="top">
                <td align="left" scope="row">&nbsp;</td>
            
                <td valign="top">&nbsp;</td>
            </tr>
            <tr valign="top">
              <td align="left" class="platformheading" scope="row">Google Analytics Setup:</td>
              <td valign="top" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" align="left" scope="row">You may choose to track your visitors movements by using this free service. You may also leave this disabled if you are using a Google analytics tracking code in your theme to avoid duplicate statistic and false tracking numbers. If in doubt, enter your google tracking code in one place and test for a few days to ensure your setup is optimal for your WordPress configuration.</td>
            </tr>
            <tr valign="top">
              <td align="left" class="itemheading" scope="row"><img src="<?php echo plugins_url('images/google_icon.png', __FILE__); ?>" width="25" height="25" /> Google Analytics ID for Order Tracking:</td>
              <td valign="top"><input name="ec_option_googleanalyticsid" type="text" value="<?php echo get_option('ec_option_googleanalyticsid'); ?>" style="width:100px;" /><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Google Analytics</em>This is your google analytics code that will collect eCommerce transaction data.  EasyCart analytics will not track your page data, please use a third party plugin such as Yoast or your theme for that data.  This only represents the eCommerce transaction collection process so as not to overlap with another plugin.</span></a></td>
            </tr>
            <tr valign="top">
              <td colspan="2" align="left" class="itemheading" scope="row"><span class="submit">
                <input type="hidden" name="isupdate" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                
                
                
              </span></td>
            </tr>
            <tr valign="top">
              <td colspan="2" align="left" class="itemheading" scope="row">&nbsp;</td>
            </tr>
            <tr valign="top">
              <td align="left" class="itemheading" scope="row">&nbsp;</td>
              <td valign="top">&nbsp;</td>
            </tr>
            <tr valign="top">
              <td colspan="2" align="left" class="itemheading" scope="row">&nbsp;</td>
            </tr>
              
      </table>
  </form>
</div>
</div>