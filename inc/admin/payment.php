<?php 

$validate = new ec_validation; 
$license = new ec_license;
 
if(isset($_POST['isupdate'])){
	//manual payment message
	update_option( 'ec_option_use_direct_deposit', $_POST['ec_option_use_direct_deposit'] );
	update_option( 'ec_option_direct_deposit_message', $_POST['ec_option_direct_deposit_message'] );
	//payment choices
	update_option( 'ec_option_use_visa', $_POST['ec_option_use_visa'] );
	update_option( 'ec_option_use_discover', $_POST['ec_option_use_discover'] );
	update_option( 'ec_option_use_mastercard', $_POST['ec_option_use_mastercard'] );
	update_option( 'ec_option_use_amex', $_POST['ec_option_use_amex'] );
	update_option( 'ec_option_use_jcb', $_POST['ec_option_use_jcb'] );
	update_option( 'ec_option_use_diners', $_POST['ec_option_use_diners'] );
	update_option( 'ec_option_use_paypal', $_POST['ec_option_use_paypal'] );
	//payment method
	update_option( 'ec_option_payment_process_method', $_POST['ec_option_payment_process_method'] );
	update_option( 'ec_option_payment_third_party', $_POST['ec_option_payment_third_party'] );
	//authorize.net
	update_option( 'ec_option_authorize_login_id', $_POST['ec_option_authorize_login_id'] );
	update_option( 'ec_option_authorize_trans_key', $_POST['ec_option_authorize_trans_key'] );
	update_option( 'ec_option_authorize_test_mode', $_POST['ec_option_authorize_test_mode'] );
	update_option( 'ec_option_authorize_developer_account', $_POST['ec_option_authorize_developer_account'] );
	update_option( 'ec_option_authorize_currency_code', $_POST['ec_option_authorize_currency_code'] );
	//paypoint
	update_option( 'ec_option_paypoint_merchant_id', $_POST['ec_option_paypoint_merchant_id'] );
	update_option( 'ec_option_paypoint_vpn_password', $_POST['ec_option_paypoint_vpn_password'] );
	update_option( 'ec_option_paypoint_test_mode', $_POST['ec_option_paypoint_test_mode'] );
    //versapay
	update_option( 'ec_option_versapay_id', $_POST['ec_option_versapay_id'] );
	update_option( 'ec_option_versapay_password', $_POST['ec_option_versapay_password'] );
	update_option( 'ec_option_versapay_language', $_POST['ec_option_versapay_language'] );
	//chronopay
	update_option( 'ec_option_chronopay_currency', $_POST['ec_option_chronopay_currency'] );
	update_option( 'ec_option_chronopay_product_id', $_POST['ec_option_chronopay_product_id'] );
	update_option( 'ec_option_chronopay_shared_secret', $_POST['ec_option_chronopay_shared_secret'] );            
    //eway
	update_option( 'ec_option_eway_customer_id', $_POST['ec_option_eway_customer_id'] );
	update_option( 'ec_option_eway_test_mode', $_POST['ec_option_eway_test_mode'] );  
	update_option( 'ec_option_eway_test_mode_success', $_POST['ec_option_eway_test_mode_success'] );          
    //firstdata
	update_option( 'ec_option_firstdata_login_id', $_POST['ec_option_firstdata_login_id'] );
	update_option( 'ec_option_firstdata_pem_file', $_POST['ec_option_firstdata_pem_file'] );
	update_option( 'ec_option_firstdata_host', $_POST['ec_option_firstdata_host'] );
	update_option( 'ec_option_firstdata_port', $_POST['ec_option_firstdata_port'] );
	update_option( 'ec_option_firstdata_test_mode', $_POST['ec_option_firstdata_test_mode'] );
	update_option( 'ec_option_firstdata_use_ssl_cert', $_POST['ec_option_firstdata_use_ssl_cert'] );     
    //firstdatae4
	update_option( 'ec_option_firstdatae4_exact_id', $_POST['ec_option_firstdatae4_exact_id'] );
	update_option( 'ec_option_firstdatae4_password', $_POST['ec_option_firstdatae4_password'] );
	update_option( 'ec_option_firstdatae4_language', $_POST['ec_option_firstdatae4_language'] );
	update_option( 'ec_option_firstdatae4_currency', $_POST['ec_option_firstdatae4_currency'] ); 
	update_option( 'ec_option_firstdatae4_test_mode', $_POST['ec_option_firstdatae4_test_mode'] );           
	//paymentexpress
	update_option( 'ec_option_payment_express_username', $_POST['ec_option_payment_express_username'] );
	update_option( 'ec_option_payment_express_password', $_POST['ec_option_payment_express_password'] );
	update_option( 'ec_option_payment_express_currency', $_POST['ec_option_payment_express_currency'] );
	//paypal
	update_option( 'ec_option_paypal_email', $_POST['ec_option_paypal_email'] );
	update_option( 'ec_option_paypal_currency_code', $_POST['ec_option_paypal_currency_code'] );
	update_option( 'ec_option_paypal_lc', $_POST['ec_option_paypal_lc'] );
	update_option( 'ec_option_paypal_use_sandbox', $_POST['ec_option_paypal_use_sandbox'] );
	update_option( 'ec_option_paypal_weight_unit', $_POST['ec_option_paypal_weight_unit'] );	
	//paypal pro
	update_option( 'ec_option_paypal_pro_test_mode', $_POST['ec_option_paypal_pro_test_mode'] );
	update_option( 'ec_option_paypal_pro_vendor', $_POST['ec_option_paypal_pro_vendor'] );
	update_option( 'ec_option_paypal_pro_partner', $_POST['ec_option_paypal_pro_partner'] );
	update_option( 'ec_option_paypal_pro_user', $_POST['ec_option_paypal_pro_user'] );
	update_option( 'ec_option_paypal_pro_password', $_POST['ec_option_paypal_pro_password'] );
	update_option( 'ec_option_paypal_pro_currency', $_POST['ec_option_paypal_pro_currency'] );
	
	//Skrill
	update_option( 'ec_option_skrill_merchant_id', $_POST['ec_option_skrill_merchant_id'] );
	update_option( 'ec_option_skrill_company_name', $_POST['ec_option_skrill_company_name'] );
	update_option( 'ec_option_skrill_email', $_POST['ec_option_skrill_email'] );
	update_option( 'ec_option_skrill_language', $_POST['ec_option_skrill_language'] );
	update_option( 'ec_option_skrill_currency_code', $_POST['ec_option_skrill_currency_code'] );
	//Realex
	update_option( 'ec_option_realex_merchant_id', $_POST['ec_option_realex_merchant_id'] );
	update_option( 'ec_option_realex_secret', $_POST['ec_option_realex_secret'] );
	update_option( 'ec_option_realex_account', $_POST['ec_option_realex_account'] );
	update_option( 'ec_option_realex_currency', $_POST['ec_option_realex_currency'] );
	//Sagepay
	update_option( 'ec_option_sagepay_vendor', $_POST['ec_option_sagepay_vendor'] );
	update_option( 'ec_option_sagepay_currency', $_POST['ec_option_sagepay_currency'] );
	update_option( 'ec_option_sagepay_testmode', $_POST['ec_option_sagepay_testmode'] );
	//Securepay
	update_option( 'ec_option_securepay_merchant_id', $_POST['ec_option_securepay_merchant_id'] );
	update_option( 'ec_option_securepay_password', $_POST['ec_option_securepay_password'] );
	update_option( 'ec_option_securepay_currency', $_POST['ec_option_securepay_currency'] );
	update_option( 'ec_option_securepay_test_mode', $_POST['ec_option_securepay_test_mode'] );
	//Securepay
	update_option( 'ec_option_psigate_store_id', $_POST['ec_option_psigate_store_id'] );
	update_option( 'ec_option_psigate_passphrase', $_POST['ec_option_psigate_passphrase'] );
	update_option( 'ec_option_psigate_test_mode', $_POST['ec_option_psigate_test_mode'] );
	//proxy settings
	update_option( 'ec_option_use_proxy', $_POST['ec_option_use_proxy'] );
	update_option( 'ec_option_proxy_address', $_POST['ec_option_proxy_address'] );
	
	
}

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

?>

<div class="wrap">
<?php if( !$license->is_registered() && !$license->is_lite_version() ) { ?>
<div class="ribbon">You are running the WP EasyCart FREE version. To purchase the LITE or FULL version and unlock the full selling potential visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a> and purchase a license.</div>
<?php }else if( $license->is_lite_version() && $license->show_lite_message() ) { ?>
<div class="ribbon">You are running the WP EasyCart Lite version. To learn more about what you are missing with the Full version visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a>. To dismiss this banner <a href="?page=ec_payment&dismiss_lite_banner=true">click here.</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

<?php if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ){ ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  

<div class="ec_contentwrap">
   
    <h2>Payment Information</h2>
    
    <form method="post" action="options.php">
      <p>
        <?php settings_fields( 'ec-payment-group' ); ?>
   	  </p>
		<table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            
            <tr valign="top">
              <td width="23%" class="platformheading" >Payment Options: </td>
              <td width="77%" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row"><p>This section lets you enable or disable the visual credit cards and payment methods customers will see during checkout. For example, you may use a gateway such as Authorize.net AND PayPal together, therefore giving customers a choice on how to pay. Authorize.net may accept Visa, Discover, and Mastercard, plus you wish to enable PayPal, so by setting them up here, customers will see their options during checkout. There are three main categories you can choose from for payment methods.</p>
                <ul>
                  <li><strong>Manual or Direct Deposit (Free, Lite, and Full Versions)</strong> - Customer orders are placed, but receipt of payment is manual and must be verified by you the business owner.</li>
                  <li><strong>3rd Party Processor (Lite and Full Versions)</strong> - Customers orders are placed and the customer is redirected to the payment page. Customers will leave your website and pay, business owners should verify payment before shipping.</li>
                  <li><strong>Live Payment Processor (Full Version Only)</strong> - Customer orders are verified immediately using a gateway. Customers will never leave your website and pay directly via your EasyCart payment page.</li>
                </ul></td>
            </tr>
            
            <tr valign="top">
              <td scope="row">&nbsp;</td>
              <td scope="row">&nbsp;</td>
            </tr>
            
            <script language="javascript" type="application/javascript">
			function toggle_direct_deposit() {
				var usedd = document.getElementById("ec_option_use_direct_deposit").value;
				
				document.getElementById("dd_message").style.display = 'none';

				if( usedd == '1')
				   document.getElementById( "dd_message" ).style.display = "";

			}
			</script>
            <tr valign="top">
              <td class="platformheading" scope="row">Manual Payments or Direct Deposit:</td>
              <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row">Manual payments or direct deposits allow you to accept orders on your website, however, payment is accepted by either invoicing the customer or by a direct deposit. Many countries outside the U.S. benefit from direct deposit, and you may use the following section to enter a message to your customers, such as direct deposit directions, or manual billing instructions and what to expect from your store. If operating where a payment gateway is provided, we recommend disabling this feature and using the availability of the payment processing system.</td>
            </tr>
            <tr valign="top">
              <td valign="middle" class="itemheading" scope="row">Show Manual Payments to Customers:</td>
              <td valign="middle"><select name="ec_option_use_direct_deposit" id="ec_option_use_direct_deposit" onchange="toggle_direct_deposit();">
                <option value="1" <?php if (get_option('ec_option_use_direct_deposit') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_direct_deposit') == 0) echo ' selected'; ?>>No</option>
              </select> 
              <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Manual Payments</em>Manual payments or direct deposit allows orders to be placed by customers with no payment.  You can leave address or bank information in the text below that the customer can send payment to, or any message you wish.  Orders are placed into a pending status and payment retrieval and confirmation is up to the store owner.</span></a>
              
              </td>
            </tr>
            <tr valign="top" id="dd_message">
              <td class="itemheading" scope="row">Manual or Direct Deposit Message:</td>
              <td><textarea name="ec_option_direct_deposit_message" id="ec_option_direct_deposit_message" cols="85" rows="12" style="width:350px;"><?php echo get_option('ec_option_direct_deposit_message'); ?></textarea>
              </td>
            </tr>
            <tr valign="top">
              <td height="19" colspan="2" scope="row"><span class="submit">
                <input type="hidden" name="isupdate4" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
              </span></td>
            </tr>
            <tr valign="top">
              <td scope="row">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            <script language="javascript" type="application/javascript">
			function toggle_live_cards( ) {
				var usevisa = document.getElementById("ec_option_use_visa").value;
				var usediscover = document.getElementById("ec_option_use_discover").value;
				var usemastercard = document.getElementById("ec_option_use_mastercard").value;
				var useamex = document.getElementById("ec_option_use_amex").value;
				var usejcb = document.getElementById("ec_option_use_jcb").value;
				var usediners = document.getElementById("ec_option_use_diners").value;
				var uselaser = document.getElementById("ec_option_use_laser").value;
				var usemaestro = document.getElementById("ec_option_use_maestro").value;
				
				document.getElementById("live_gateways").style.display = 'none';

				if( usevisa == '1' || usediscover == '1' || usemastercard == '1' || useamex == '1' || usejcb == '1' || usediners == '1' || uselaser == '1' || usemaestro == '1' )
				   document.getElementById( "live_gateways" ).style.display = "";

			}
			
			function toggle_live_card_display( visa, discover, mastercard, amex, jcb, diners, laser, maestro ){
				if( visa )
					document.getElementById( "visa" ).style.display = "";
				else{
					document.getElementById( "visa" ).style.display = "none";
					document.getElementById( "ec_option_use_visa" ).value = "0";
				}
				
				if( discover )
					document.getElementById( "discover" ).style.display = "";
				else{
					document.getElementById( "discover" ).style.display = "none";
					document.getElementById( "ec_option_use_discover" ).value = "0";
				}
					
				if( mastercard )
					document.getElementById( "mastercard" ).style.display = "";
				else{
					document.getElementById( "mastercard" ).style.display = "none";
					document.getElementById( "ec_option_use_mastercard" ).value = "0";
				}
					
				if( amex )
					document.getElementById( "amex" ).style.display = "";
				else{
					document.getElementById( "amex" ).style.display = "none";
					document.getElementById( "ec_option_use_amex" ).value = "0";
				}
					
				if( jcb )
					document.getElementById( "jcb" ).style.display = "";
				else{
					document.getElementById( "jcb" ).style.display = "none";
					document.getElementById( "ec_option_use_jcb" ).value = "0";
				}
					
				if( diners )
					document.getElementById( "diners" ).style.display = "";
				else{
					document.getElementById( "diners" ).style.display = "none";
					document.getElementById( "ec_option_use_diners" ).value = "0";
				}
					
				if( laser )
					document.getElementById( "laser" ).style.display = "";
				else{
					document.getElementById( "laser" ).style.display = "none";
					document.getElementById( "ec_option_use_laser" ).value = "0";
				}
					
				if( maestro )
					document.getElementById( "maestro" ).style.display = "";
				else{
					document.getElementById( "maestro" ).style.display = "none";
					document.getElementById( "ec_option_use_maestro" ).value = "0";
				}
			}
			</script>
            
            
            
         	<?php if($license->is_registered() && !$license->is_lite_version() ) { ?>
            
            <tr valign="top">
              <td class="platformheading" scope="row">Live Payment Processor:</td>
              <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row">Please select a payment processor or gateway that you will use to process payments on your site. These gateways allow for credit cards to be accepted on your website, and customers do not have to leave your site for payment. The following gateways are pre-integrated, and provide instant payment information upon an order being placed. If you need a custom gateway integrated, be sure to talk to our EasyCart team.</td>
            </tr>
            <tr valign="top" id="visa">
              <td valign="middle" class="itemheading" scope="row"><img width="25" height="25" src="<?php echo plugins_url('images/visa.png', __FILE__); ?>" alt="" /> Show Visa to Customers:</td>
              <td valign="middle"><select name="ec_option_use_visa" id="ec_option_use_visa" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_visa') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_visa') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top" id="discover">
              <td valign="middle" class="itemheading" scope="row"><img  width="25" height="25" src="<?php echo plugins_url('images/discover.png', __FILE__); ?>" alt="" /> Show Discover to Customers:</td>
              <td valign="middle"><select name="ec_option_use_discover" id="ec_option_use_discover" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_discover') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_discover') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top" id="mastercard">
              <td valign="middle" class="itemheading" scope="row"><img  width="25" height="25" src="<?php echo plugins_url('images/mastercard.png', __FILE__); ?>" alt="" /> Show Mastercard to Customers:</td>
              <td valign="middle"><select name="ec_option_use_mastercard" id="ec_option_use_mastercard" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_mastercard') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_mastercard') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top" id="amex">
              <td valign="middle" class="itemheading" scope="row"><img  width="25" height="25" src="<?php echo plugins_url('images/american_express.png', __FILE__); ?>" alt="" /> Show America to Customers:</td>
              <td valign="middle"><select name="ec_option_use_amex" id="ec_option_use_amex" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_amex') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_amex') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top" id="jcb">
              <td valign="middle" class="itemheading" scope="row"><img  width="25" height="25" src="<?php echo plugins_url('images/jcb.png', __FILE__); ?>" alt="" /> Show JCB to Customers:</td>
              <td valign="middle"><select name="ec_option_use_jcb" id="ec_option_use_jcb" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_jcb') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_jcb') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top" id="diners">
              <td valign="middle" class="itemheading" scope="row"><img  width="25" height="25" src="<?php echo plugins_url('images/diners.png', __FILE__); ?>" alt="" /> Show Diners to Customers:</td>
              <td valign="middle"><select name="ec_option_use_diners" id="ec_option_use_diners" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_diners') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_diners') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top" id="laser">
              <td valign="middle" class="itemheading" scope="row"><img  width="25" height="25" src="<?php echo plugins_url('images/laser-logo.gif', __FILE__); ?>" alt="" /> Show Laser to Customers:</td>
              <td valign="middle"><select name="ec_option_use_laser" id="ec_option_use_laser" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_laser') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_laser') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top" id="maestro">
              <td valign="middle" class="itemheading" scope="row"><img  width="25" height="25" src="<?php echo plugins_url('images/maestro_logo.gif', __FILE__); ?>" alt="" /> Show Maestro to Customers:</td>
              <td valign="middle"><select name="ec_option_use_maestro" id="ec_option_use_maestro" onchange="toggle_live_cards();">
                <option value="1" <?php if (get_option('ec_option_use_maestro') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_use_maestro') == 0) echo ' selected'; ?>>No</option>
              </select></td>
            </tr>
            <tr valign="top">
              <td class="itemheading" scope="row">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            
            <script language="javascript" type="application/javascript">
			function toggle_live_gateways() {
				var paymentmethod = document.getElementById("paymentmethod").value;
				
				document.getElementById("authorize").style.display = 'none';
				document.getElementById("paypal_pro").style.display = 'none';
				document.getElementById("realex").style.display = 'none';
				document.getElementById("sagepay").style.display = 'none';
				document.getElementById("firstdata").style.display = 'none';
				document.getElementById("paymentexpress").style.display = 'none';
				document.getElementById("chronopay").style.display = 'none';
				document.getElementById("versapay").style.display = 'none';
				document.getElementById("eway").style.display = 'none';
				document.getElementById("paypoint").style.display = 'none';
				document.getElementById("securepay").style.display = 'none';
				document.getElementById("psigate").style.display = 'none';
			   
			   	//toggle_live_card_display( visa, discover, mastercard, amex, jcb, diners, laser, maestro );
				if( paymentmethod == "authorize" ){
				   	document.getElementById( "authorize" ).style.display = "";
					toggle_live_card_display( 1, 1, 1, 1, 1, 1, 0, 0 );
				}
				
				else if(paymentmethod == "paypal_pro"){
					document.getElementById('paypal_pro').style.display = "";
					toggle_live_card_display( 1, 1, 1, 1, 1, 1, 0, 0 );
				}
				
				else if(paymentmethod == "realex"){
					document.getElementById('realex').style.display = "";
					toggle_live_card_display( 1, 0, 1, 1, 0, 1, 1, 1 );
				}
				
				else if(paymentmethod == "sagepay"){
					document.getElementById('sagepay').style.display = "";
					toggle_live_card_display( 1, 1, 1, 1, 1, 0, 1, 1 );
				}
				
				else if( paymentmethod == "firstdata" ){
				   document.getElementById( "firstdata").style.display = '';
					toggle_live_card_display( 1, 1, 1, 1, 1, 1, 0, 0 );
				}
				
				else if( paymentmethod == 'paymentexpress' ){
				   document.getElementById( "paymentexpress" ).style.display = '';
					toggle_live_card_display( 1, 0, 1, 1, 0, 1, 0, 0 );
				}
				
				else if( paymentmethod == 'chronopay' ){
				   document.getElementById( "chronopay" ).style.display = '';
					toggle_live_card_display( 1, 1, 1, 1, 1, 1, 1, 1 );
				}
				
				else if( paymentmethod == 'versapay' ){
				   document.getElementById( "versapay" ).style.display = '';
					toggle_live_card_display( 1, 1, 1, 1, 1, 1, 0, 0 );
				}
				
				else if( paymentmethod == 'eway' ){
				   document.getElementById( "eway" ).style.display = '';
					toggle_live_card_display( 1, 0, 1, 1, 1, 1, 0, 0 );
				}
				
				else if( paymentmethod == 'paypoint' ){
				   document.getElementById( "paypoint" ).style.display = '';
					toggle_live_card_display( 1, 0, 1, 1, 1, 1, 1, 1 );
				}
				
				else if( paymentmethod == 'securepay' ){
				   document.getElementById( "securepay" ).style.display = '';
					toggle_live_card_display( 1, 0, 1, 1, 1, 1, 0, 0 );
				}
				
				else if( paymentmethod == 'psigate' ){
				   document.getElementById( "psigate" ).style.display = '';
					toggle_live_card_display( 1, 1, 1, 1, 1, 1, 0, 0 );
				}
				
			}
			
			</script>
            
            
            
            <tr valign="top" id="live_gateways">
              <td height="19" colspan="2" scope="row"> 
              <table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top" class="form-table">
                  <td colspan="2" scope="row">Please select a payment processor that is capable of processing the above transactions live on your website. These gateways allow customers to use their credit cards on your website and will never leave your site to pay on another. Be sure to check with your payment gateway provider to see which credit cards above are accepted.</td>
                </tr>
                <tr valign="top" class="form-table">
                  <td width="23%" class="itemheading" scope="row">Select Payment Processor:</td>
                  <td width="77%"><select id="paymentmethod" name="ec_option_payment_process_method"  onclick="toggle_live_gateways();" value="<?php echo get_option('ec_option_payment_process_method'); ?>" style="width:250px;">
                    <option value="0" <?php if( get_option('ec_option_payment_process_method') == "0" ){ echo " selected"; } ?>>No Live Payment Processor</option>
                    <option value="authorize" <?php if( get_option('ec_option_payment_process_method') == "authorize" ){ echo " selected"; } ?>>Authorize.net</option>
                    <option value="paypal_pro" <?php if( get_option('ec_option_payment_process_method') == "paypal_pro" ){ echo " selected"; } ?>>PayPal Pro</option>
                    <option value="realex" <?php if( get_option('ec_option_payment_process_method') == "realex" ){ echo " selected"; } ?>>Realex</option>
                    <option value="sagepay" <?php if( get_option('ec_option_payment_process_method') == "sagepay" ){ echo " selected"; } ?>>Sagepay</option>
                    <option value="firstdata" <?php if( get_option('ec_option_payment_process_method') == "firstdata" ){ echo " selected"; } ?>>First Data Global Gateway e4</option>
                    <option value="paymentexpress" <?php if( get_option('ec_option_payment_process_method') == "paymentexpress" ){ echo " selected"; } ?>>Payment Express</option>
                    <option value="chronopay" <?php if( get_option('ec_option_payment_process_method') == "chronopay" ){ echo " selected"; } ?>>Chronopay</option>
                    <option value="eway" <?php if( get_option('ec_option_payment_process_method') == "eway" ){ echo " selected"; } ?>>Eway</option>
                    <option value="paypoint" <?php if( get_option('ec_option_payment_process_method') == "paypoint" ){ echo " selected"; } ?>>PayPoint</option>
                    <option value="securepay" <?php if( get_option('ec_option_payment_process_method') == "securepay" ){ echo " selected"; } ?>>SecurePay</option>
                  </select></td>
                </tr>
                <tr valign="top" class="form-table" id="authorize">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Authorize.net Login ID:</td>
                      <td width="74%"><input name="ec_option_authorize_login_id" id="ec_option_authorize_login_id" type="text" value="<?php echo get_option('ec_option_authorize_login_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Authorize.net Transaction Key:</td>
                      <td><input name="ec_option_authorize_trans_key" id="ec_option_authorize_trans_key" type="text" value="<?php echo get_option('ec_option_authorize_trans_key'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Authorize.net Currency Code:</td>
                      <td><select name="ec_option_authorize_currency_code" id="ec_option_authorize_currency_code">
                        <option value="USD" <?php if ( get_option( 'ec_option_authorize_currency_code') == "USD" ){ echo " selected=\"selected\""; } ?>>USD</option>
                        <option value="CAD" <?php if ( get_option( 'ec_option_authorize_currency_code') == "CAD" ){ echo " selected=\"selected\""; } ?>>CAD</option>
                        <option value="EUR" <?php if ( get_option( 'ec_option_authorize_currency_code') == "EUR" ){ echo " selected=\"selected\""; } ?>>EUR</option>
                        <option value="GBP" <?php if ( get_option( 'ec_option_authorize_currency_code') == "GBP" ){ echo " selected=\"selected\""; } ?>>GBP</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Authorize.net Test Mode:</td>
                      <td><select name="ec_option_authorize_test_mode" id="ec_option_authorize_test_mode">
                        <option value="1" <?php if (get_option('ec_option_authorize_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_authorize_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Authorize.net Developer Account:</td>
                      <td><select name="ec_option_authorize_developer_account" id="ec_option_authorize_developer_account">
                        <option value="1" <?php if (get_option('ec_option_authorize_developer_account') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_authorize_developer_account') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="paypal_pro">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">PayPal Pro Partner:</td>
                      <td width="74%"><input name="ec_option_paypal_pro_partner"  id="ec_option_paypal_pro_partner" type="text" value="<?php echo get_option('ec_option_paypal_pro_partner'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">PayPal Pro User:</td>
                      <td><input name="ec_option_paypal_pro_user"  id="ec_option_paypal_pro_user" type="text" value="<?php echo get_option('ec_option_paypal_pro_user'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">PayPal Pro Vendor:</td>
                      <td width="74%"><input name="ec_option_paypal_pro_vendor" id="ec_option_paypal_pro_vendor"  type="text" value="<?php echo get_option('ec_option_paypal_pro_vendor'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">PayPal Pro Password:</td>
                      <td><input name="ec_option_paypal_pro_password"  id="ec_option_paypal_pro_password" type="text" value="<?php echo get_option('ec_option_paypal_pro_password'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">PayPal Pro Currency:</td>
                      <td>
                      <select name="ec_option_paypal_pro_currency" id="ec_option_paypal_pro_currency">
                        <option value="USD" <?php if (get_option('ec_option_paypal_pro_currency') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="AUD" <?php if (get_option('ec_option_paypal_pro_currency') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
                        <option value="BRL" <?php if (get_option('ec_option_paypal_pro_currency') == 'BRL') echo ' selected'; ?>>Brazilian Real</option>
                        <option value="CAD" <?php if (get_option('ec_option_paypal_pro_currency') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="CZK" <?php if (get_option('ec_option_paypal_pro_currency') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
                        <option value="CZK" <?php if (get_option('ec_option_paypal_pro_currency') == 'CZK') echo ' selected'; ?>>Danish Krone</option>
                        <option value="EUR" <?php if (get_option('ec_option_paypal_pro_currency') == 'EUR') echo ' selected'; ?>>Euro</option>
                        <option value="HKD" <?php if (get_option('ec_option_paypal_pro_currency') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="HUF" <?php if (get_option('ec_option_paypal_pro_currency') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
                        <option value="ILS" <?php if (get_option('ec_option_paypal_pro_currency') == 'ILS') echo ' selected'; ?>>Israeli New Sheqel</option>
                        <option value="JPY" <?php if (get_option('ec_option_paypal_pro_currency') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
                        <option value="MYR" <?php if (get_option('ec_option_paypal_pro_currency') == 'MYR') echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="MXN" <?php if (get_option('ec_option_paypal_pro_currency') == 'MXN') echo ' selected'; ?>>Mexican Peso</option>
                        <option value="NOK" <?php if (get_option('ec_option_paypal_pro_currency') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
                        <option value="NZD" <?php if (get_option('ec_option_paypal_pro_currency') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="PHP" <?php if (get_option('ec_option_paypal_pro_currency') == 'PHP') echo ' selected'; ?>>Philippine Peso</option>
                        <option value="PLN" <?php if (get_option('ec_option_paypal_pro_currency') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
                        <option value="GBP" <?php if (get_option('ec_option_paypal_pro_currency') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
                        <option value="SGD" <?php if (get_option('ec_option_paypal_pro_currency') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="SEK" <?php if (get_option('ec_option_paypal_pro_currency') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
                        <option value="CHF" <?php if (get_option('ec_option_paypal_pro_currency') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
                        <option value="TWD" <?php if (get_option('ec_option_paypal_pro_currency') == 'TWD') echo ' selected'; ?>>Taiwan New Dollar</option>
                        <option value="THB" <?php if (get_option('ec_option_paypal_pro_currency') == 'THB') echo ' selected'; ?>>Thai Baht</option>
                        <option value="TRY" <?php if (get_option('ec_option_paypal_pro_currency') == 'TRY') echo ' selected'; ?>>Turkish Lira</option>
                      </select>
                       </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">PayPal Pro Test Mode:</td>
                      <td><select name="ec_option_paypal_pro_test_mode" id="ec_option_paypal_pro_test_mode">
                        <option value="1" <?php if (get_option('ec_option_paypal_pro_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_paypal_pro_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                
                <tr valign="top" class="form-table" id="realex">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Merchant ID:</td>
                      <td width="74%"><input name="ec_option_realex_merchant_id"  id="ec_option_realex_merchant_id" type="text" value="<?php echo get_option('ec_option_realex_merchant_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Secret:</td>
                      <td width="74%"><input name="ec_option_realex_secret"  id="ec_option_realex_secret" type="text" value="<?php echo get_option('ec_option_realex_secret'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Account:</td>
                      <td width="74%"><input name="ec_option_realex_account"  id="ec_option_realex_account" type="text" value="<?php echo get_option('ec_option_realex_account'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Realex Currency:</td>
                      <td width="74%"><select name="ec_option_realex_currency" id="ec_option_realex_currency">
                        <option value="GBP" <?php if (get_option('ec_option_realex_currency') == "GBP") echo ' selected'; ?>>GBP</option>
                        <option value="EUR" <?php if (get_option('ec_option_realex_currency') == "EUR") echo ' selected'; ?>>EUR</option>
                        <option value="USD" <?php if (get_option('ec_option_realex_currency') == "USD") echo ' selected'; ?>>USD</option>
                        <option value="DKK" <?php if (get_option('ec_option_realex_currency') == "DKK") echo ' selected'; ?>>DKK</option>
                        <option value="NOK" <?php if (get_option('ec_option_realex_currency') == "NOK") echo ' selected'; ?>>NOK</option>
                        <option value="CHF" <?php if (get_option('ec_option_realex_currency') == "CHF") echo ' selected'; ?>>CHF</option>
                        <option value="AUD" <?php if (get_option('ec_option_realex_currency') == "AUD") echo ' selected'; ?>>AUD</option>
                        <option value="CAD" <?php if (get_option('ec_option_realex_currency') == "CAD") echo ' selected'; ?>>CAD</option>
                        <option value="CZK" <?php if (get_option('ec_option_realex_currency') == "CZK") echo ' selected'; ?>>CZK</option>
                        <option value="JPY" <?php if (get_option('ec_option_realex_currency') == "JPY") echo ' selected'; ?>>JPY</option>
                        <option value="NZD" <?php if (get_option('ec_option_realex_currency') == "NZD") echo ' selected'; ?>>NZD</option>
                        <option value="HKD" <?php if (get_option('ec_option_realex_currency') == "HKD") echo ' selected'; ?>>HKD</option>
                        <option value="ZAR" <?php if (get_option('ec_option_realex_currency') == "ZAR") echo ' selected'; ?>>ZAR</option>
                        <option value="SEK" <?php if (get_option('ec_option_realex_currency') == "SEK") echo ' selected'; ?>>SEK</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="sagepay">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Sagepay Vendor:</td>
                      <td width="74%"><input name="ec_option_sagepay_vendor" id="ec_option_sagepay_vendor" type="text" value="<?php echo get_option('ec_option_sagepay_vendor'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Sagepay Currency:</td>
                      <td><select name="ec_option_sagepay_currency" id="ec_option_sagepay_currency">
                        <option value="AUD" <?php if (get_option('ec_option_sagepay_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_sagepay_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="CHF" <?php if (get_option('ec_option_sagepay_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="DKK" <?php if (get_option('ec_option_sagepay_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="EUR" <?php if (get_option('ec_option_sagepay_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="GBP" <?php if (get_option('ec_option_sagepay_currency') == "GBP") echo ' selected'; ?>>Pound Sterling</option>
                        <option value="HKD" <?php if (get_option('ec_option_sagepay_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="IDR" <?php if (get_option('ec_option_sagepay_currency') == "IDR") echo ' selected'; ?>>Rupiah</option>
                        <option value="JPY" <?php if (get_option('ec_option_sagepay_currency') == "JPY") echo ' selected'; ?>>Yen</option>
                        <option value="LUF" <?php if (get_option('ec_option_sagepay_currency') == "LUF") echo ' selected'; ?>>Luxembourg Franc</option>
                        <option value="NOK" <?php if (get_option('ec_option_sagepay_currency') == "NOK") echo ' selected'; ?>>Norwegian Krone</option>
                        <option value="NZD" <?php if (get_option('ec_option_sagepay_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="SEK" <?php if (get_option('ec_option_sagepay_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="SGD" <?php if (get_option('ec_option_sagepay_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="TRL" <?php if (get_option('ec_option_sagepay_currency') == "TRL") echo ' selected'; ?>>Turkish Lira</option>
                        <option value="USD" <?php if (get_option('ec_option_sagepay_currency') == "USD") echo ' selected'; ?>>US Dollar</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Sagepay Simulator Only:</td>
                      <td><select name="ec_option_sagepay_simulator" id="ec_option_sagepay_simulator">
                        <option value="1" <?php if (get_option('ec_option_sagepay_simulator') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_sagepay_simulator') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Sagepay Test Mode:</td>
                      <td><select name="ec_option_sagepay_testmode" id="ec_option_sagepay_testmode">
                        <option value="1" <?php if (get_option('ec_option_sagepay_testmode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_sagepay_testmode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="paypoint">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Paypoint Merchant ID:</td>
                      <td width="74%"><input name="ec_option_paypoint_merchant_id"  id="ec_option_paypoint_merchant_id" type="text" value="<?php echo get_option('ec_option_paypoint_merchant_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Paypoint VPN Password:</td>
                      <td><input name="ec_option_paypoint_vpn_password" id="ec_option_paypoint_vpn_password" type="text" value="<?php echo get_option('ec_option_paypoint_vpn_password'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Paypoint Test Mode:</td>
                      <td><select name="ec_option_paypoint_test_mode" id="ec_option_paypoint_test_mode">
                        <option value="1" <?php if (get_option('ec_option_paypoint_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_paypoint_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="chronopay">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Chronopay Currency:</td>
                      <td width="74%"><input name="ec_option_chronopay_currency"  id="ec_option_chronopay_currency"  type="text" value="<?php echo get_option('ec_option_chronopay_currency'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Chronopay Product ID:</td>
                      <td><input name="ec_option_chronopay_product_id"  id="ec_option_chronopay_product_id" type="text" value="<?php echo get_option('ec_option_chronopay_product_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Chronopay Shared Secret:</td>
                      <td><input name="ec_option_chronopay_shared_secret"  id="ec_option_chronopay_shared_secret" type="text" value="<?php echo get_option('ec_option_chronopay_shared_secret'); ?>" style="width:250px;" /></td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="versapay">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Versapay ID:</td>
                      <td width="74%"><input name="ec_option_versapay_id"  id="ec_option_versapay_id" type="text" value="<?php echo get_option('ec_option_versapay_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Versapay Password:</td>
                      <td><input name="ec_option_versapay_password"  id="ec_option_versapay_password" type="text" value="<?php echo get_option('ec_option_versapay_password'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Versapay Language:</td>
                      <td><input name="ec_option_versapay_language"  id="ec_option_versapay_language" type="text" value="<?php echo get_option('ec_option_versapay_language'); ?>" style="width:250px;" /></td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="eway">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Eway Customer ID:</td>
                      <td width="74%"><input name="ec_option_eway_customer_id"  id="ec_option_eway_customer_id" type="text" value="<?php echo get_option('ec_option_eway_customer_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Eway Test Mode:</td>
                      <td><select name="ec_option_eway_test_mode" id="ec_option_eway_test_mode">
                        <option value="1" <?php if (get_option('ec_option_eway_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_eway_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Eway Test Mode Process Successful Transaction:</td>
                      <td><select name="ec_option_eway_test_mode_success" id="ec_option_eway_test_mode_success">
                        <option value="1" <?php if (get_option('ec_option_eway_test_mode_success') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_eway_test_mode_success') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
               
                <tr valign="top" class="form-table" id="firstdata">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Firstdata e4 Exact ID (Gateway ID):</td>
                      <td width="74%"><input name="ec_option_firstdatae4_exact_id"  id="ec_option_firstdatae4_exact_id" type="text" value="<?php echo get_option('ec_option_firstdatae4_exact_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Firstdata e4 Password:</td>
                      <td width="74%"><input name="ec_option_firstdatae4_password"  id="ec_option_firstdatae4_password" type="text" value="<?php echo get_option('ec_option_firstdatae4_password'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Firstdata e4 Language:</td>
                      <td width="74%"><select name="ec_option_firstdatae4_language" id="ec_option_firstdatae4_language">
                        <option value="EN" <?php if (get_option('ec_option_firstdatae4_language') == "EN") echo ' selected'; ?>>EN</option>
                        <option value="FR" <?php if (get_option('ec_option_firstdatae4_language') == "FR") echo ' selected'; ?>>FR</option>
                        <option value="ES" <?php if (get_option('ec_option_firstdatae4_language') == "ES") echo ' selected'; ?>>ES</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Firstdata e4 Currency:</td>
                      <td width="74%"><select name="ec_option_firstdatae4_currency" id="ec_option_firstdatae4_currency">
                        <option value="USD" <?php if (get_option('ec_option_firstdatae4_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_firstdatae4_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="DEM" <?php if (get_option('ec_option_firstdatae4_currency') == "DEM") echo ' selected'; ?>>German Mark</option>
                        <option value="CHF" <?php if (get_option('ec_option_firstdatae4_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="GBP" <?php if (get_option('ec_option_firstdatae4_currency') == "GBP") echo ' selected'; ?>>British Pound</option>
                        <option value="JPY" <?php if (get_option('ec_option_firstdatae4_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="AFA" <?php if (get_option('ec_option_firstdatae4_currency') == "AFA") echo ' selected'; ?>>Afghanistan Afghani</option>
                        <option value="ALL" <?php if (get_option('ec_option_firstdatae4_currency') == "ALL") echo ' selected'; ?>>Albanian Lek</option>
                        <option value="DZD" <?php if (get_option('ec_option_firstdatae4_currency') == "DZD") echo ' selected'; ?>>Algerian Dinar</option>
                        <option value="ADF" <?php if (get_option('ec_option_firstdatae4_currency') == "ADF") echo ' selected'; ?>>Andorran Franc</option>
                        <option value="ADP" <?php if (get_option('ec_option_firstdatae4_currency') == "ADP") echo ' selected'; ?>>Andorran Peseta</option>
                        <option value="AON" <?php if (get_option('ec_option_firstdatae4_currency') == "AON") echo ' selected'; ?>>Angolan New Kwanza</option>
                        <option value="ARS" <?php if (get_option('ec_option_firstdatae4_currency') == "ARS") echo ' selected'; ?>>Argentine Peso</option>
                        <option value="AWG" <?php if (get_option('ec_option_firstdatae4_currency') == "AWG") echo ' selected'; ?>>Aruban Florin</option>
                        <option value="AUD" <?php if (get_option('ec_option_firstdatae4_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="ATS" <?php if (get_option('ec_option_firstdatae4_currency') == "ATS") echo ' selected'; ?>>Austrian Schilling</option>
                        <option value="BSD" <?php if (get_option('ec_option_firstdatae4_currency') == "BSD") echo ' selected'; ?>>Bahamanian Dollar</option>
                        <option value="BHD" <?php if (get_option('ec_option_firstdatae4_currency') == "BHD") echo ' selected'; ?>>Bahraini Dinar</option>
                        <option value="BDT" <?php if (get_option('ec_option_firstdatae4_currency') == "BDT") echo ' selected'; ?>>Bangladeshi Taka</option>
                        <option value="BBD" <?php if (get_option('ec_option_firstdatae4_currency') == "BBD") echo ' selected'; ?>>Barbados Dollar</option>
                        <option value="BEF" <?php if (get_option('ec_option_firstdatae4_currency') == "BEF") echo ' selected'; ?>>Belgian Franc</option>
                        <option value="BZD" <?php if (get_option('ec_option_firstdatae4_currency') == "BZD") echo ' selected'; ?>>Belize Dollar</option>
                        <option value="BMD" <?php if (get_option('ec_option_firstdatae4_currency') == "BMD") echo ' selected'; ?>>Bermudian Dollar</option>
                        <option value="BTN" <?php if (get_option('ec_option_firstdatae4_currency') == "BTN") echo ' selected'; ?>>Bhutan Ngultrum</option>
                        <option value="BOB" <?php if (get_option('ec_option_firstdatae4_currency') == "BOB") echo ' selected'; ?>>Bolivian Boliviano</option>
                        <option value="BWP" <?php if (get_option('ec_option_firstdatae4_currency') == "BWP") echo ' selected'; ?>>Botswana Pula</option>
                        <option value="BRL" <?php if (get_option('ec_option_firstdatae4_currency') == "BRL") echo ' selected'; ?>>Brazilian Real</option>
                        <option value="BND" <?php if (get_option('ec_option_firstdatae4_currency') == "BND") echo ' selected'; ?>>Brunei Dollar</option>
                        <option value="BGL" <?php if (get_option('ec_option_firstdatae4_currency') == "BGL") echo ' selected'; ?>>Bulgarian Lev</option>
                        <option value="BIF" <?php if (get_option('ec_option_firstdatae4_currency') == "BIF") echo ' selected'; ?>>Burundi Franc</option>
                        <option value="XOF" <?php if (get_option('ec_option_firstdatae4_currency') == "XOF") echo ' selected'; ?>>CFA Franc BCEAO</option>
                        <option value="XAF" <?php if (get_option('ec_option_firstdatae4_currency') == "XAF") echo ' selected'; ?>>CFA Franc BEAC</option>
                        <option value="KHR" <?php if (get_option('ec_option_firstdatae4_currency') == "KHR") echo ' selected'; ?>>Cambodian Riel</option>
                        <option value="CVE" <?php if (get_option('ec_option_firstdatae4_currency') == "CVE") echo ' selected'; ?>>Cape Verde Escudo</option>
                        <option value="KYD" <?php if (get_option('ec_option_firstdatae4_currency') == "KYD") echo ' selected'; ?>>Cayman Islands Dollar</option>
                        <option value="CLP" <?php if (get_option('ec_option_firstdatae4_currency') == "CLP") echo ' selected'; ?>>Chilean Peso</option>
                        <option value="CNY" <?php if (get_option('ec_option_firstdatae4_currency') == "CNY") echo ' selected'; ?>>Chinese Yuan Renminbi</option>
                        <option value="COP" <?php if (get_option('ec_option_firstdatae4_currency') == "COP") echo ' selected'; ?>>Colombian Peso</option>
                        <option value="KMF" <?php if (get_option('ec_option_firstdatae4_currency') == "KMF") echo ' selected'; ?>>Comoros Franc</option>
                        <option value="CRC" <?php if (get_option('ec_option_firstdatae4_currency') == "CRC") echo ' selected'; ?>>Costa Rican Colon</option>
                        <option value="HRK" <?php if (get_option('ec_option_firstdatae4_currency') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                        <option value="CYP" <?php if (get_option('ec_option_firstdatae4_currency') == "CYP") echo ' selected'; ?>>Cyprus Pound</option>
                        <option value="CSK" <?php if (get_option('ec_option_firstdatae4_currency') == "CSK") echo ' selected'; ?>>Czech Koruna</option>
                        <option value="DKK" <?php if (get_option('ec_option_firstdatae4_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="DJF" <?php if (get_option('ec_option_firstdatae4_currency') == "DJF") echo ' selected'; ?>>Djibouti Franc</option>
                        <option value="DOP" <?php if (get_option('ec_option_firstdatae4_currency') == "DOP") echo ' selected'; ?>>Dominican Peso</option>
                        <option value="NLG" <?php if (get_option('ec_option_firstdatae4_currency') == "NLG") echo ' selected'; ?>>Dutch Guilder</option>
                        <option value="XEU" <?php if (get_option('ec_option_firstdatae4_currency') == "XEU") echo ' selected'; ?>>ECU</option>
                        <option value="ECS" <?php if (get_option('ec_option_firstdatae4_currency') == "ECE") echo ' selected'; ?>>Ecuador Sucre</option>
                        <option value="EGP" <?php if (get_option('ec_option_firstdatae4_currency') == "EGP") echo ' selected'; ?>>Egyptian Pound</option>
                        <option value="SVC" <?php if (get_option('ec_option_firstdatae4_currency') == "SVC") echo ' selected'; ?>>El Salvador Colon</option>
                        <option value="EEK" <?php if (get_option('ec_option_firstdatae4_currency') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                        <option value="ETB" <?php if (get_option('ec_option_firstdatae4_currency') == "ETB") echo ' selected'; ?>>Ethiopian Birr</option>
                        <option value="EUR" <?php if (get_option('ec_option_firstdatae4_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="FKP" <?php if (get_option('ec_option_firstdatae4_currency') == "FKP") echo ' selected'; ?>>Falkland Islands Pound</option>
                        <option value="FJD" <?php if (get_option('ec_option_firstdatae4_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                        <option value="FIM" <?php if (get_option('ec_option_firstdatae4_currency') == "FTM") echo ' selected'; ?>>Finnish Markka</option>
                        <option value="FRF" <?php if (get_option('ec_option_firstdatae4_currency') == "FRF") echo ' selected'; ?>>French Franc</option>
                        <option value="GMD" <?php if (get_option('ec_option_firstdatae4_currency') == "GMD") echo ' selected'; ?>>Gambian Dalasi</option>
                        <option value="GHC" <?php if (get_option('ec_option_firstdatae4_currency') == "GHC") echo ' selected'; ?>>Ghanaian Cedi</option>
                        <option value="GIP" <?php if (get_option('ec_option_firstdatae4_currency') == "GIP") echo ' selected'; ?>>Gibraltar Pound</option>
                        <option value="XAU" <?php if (get_option('ec_option_firstdatae4_currency') == "XAU") echo ' selected'; ?>>Gold (oz.)</option>
                        <option value="GRD" <?php if (get_option('ec_option_firstdatae4_currency') == "GRD") echo ' selected'; ?>>Greek Drachma</option>
                        <option value="GTQ" <?php if (get_option('ec_option_firstdatae4_currency') == "GTQ") echo ' selected'; ?>>Guatemalan Quetzal</option>
                        <option value="GNF" <?php if (get_option('ec_option_firstdatae4_currency') == "GNF") echo ' selected'; ?>>Guinea Franc</option>
                        <option value="GYD" <?php if (get_option('ec_option_firstdatae4_currency') == "GYD") echo ' selected'; ?>>Guyanan Dollar</option>
                        <option value="HTG" <?php if (get_option('ec_option_firstdatae4_currency') == "HTG") echo ' selected'; ?>>Haitian Gourde</option>
                        <option value="HNL" <?php if (get_option('ec_option_firstdatae4_currency') == "HNL") echo ' selected'; ?>>Honduran Lempira</option>
                        <option value="HKD" <?php if (get_option('ec_option_firstdatae4_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="HUF" <?php if (get_option('ec_option_firstdatae4_currency') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                        <option value="ISK" <?php if (get_option('ec_option_firstdatae4_currency') == "ISK") echo ' selected'; ?>>Iceland Krona</option>
                        <option value="INR" <?php if (get_option('ec_option_firstdatae4_currency') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                        <option value="IDR" <?php if (get_option('ec_option_firstdatae4_currency') == "IDR") echo ' selected'; ?>>Indonesian Rupiah</option>
                        <option value="IEP" <?php if (get_option('ec_option_firstdatae4_currency') == "IEP") echo ' selected'; ?>>Irish Punt</option>
                        <option value="ILS" <?php if (get_option('ec_option_firstdatae4_currency') == "ILS") echo ' selected'; ?>>Israeli New Shekel</option>
                        <option value="ITL" <?php if (get_option('ec_option_firstdatae4_currency') == "ITL") echo ' selected'; ?>>Italian Lira</option>
                        <option value="JMD" <?php if (get_option('ec_option_firstdatae4_currency') == "JMD") echo ' selected'; ?>>Jamaican Dollar</option>
                        <option value="JOD" <?php if (get_option('ec_option_firstdatae4_currency') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                        <option value="KZT" <?php if (get_option('ec_option_firstdatae4_currency') == "KZT") echo ' selected'; ?>>Kazakhstan Tenge</option>
                        <option value="KES" <?php if (get_option('ec_option_firstdatae4_currency') == "KES") echo ' selected'; ?>>Kenyan Shilling</option>
                        <option value="KWD" <?php if (get_option('ec_option_firstdatae4_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                        <option value="LAK" <?php if (get_option('ec_option_firstdatae4_currency') == "LAK") echo ' selected'; ?>>Lao Kip</option>
                        <option value="LVL" <?php if (get_option('ec_option_firstdatae4_currency') == "LVL") echo ' selected'; ?>>Latvian Lats</option>
                        <option value="LSL" <?php if (get_option('ec_option_firstdatae4_currency') == "LSL") echo ' selected'; ?>>Lesotho Loti</option>
                        <option value="LRD" <?php if (get_option('ec_option_firstdatae4_currency') == "LRD") echo ' selected'; ?>>Liberian Dollar</option>
                        <option value="LTL" <?php if (get_option('ec_option_firstdatae4_currency') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                        <option value="LUF" <?php if (get_option('ec_option_firstdatae4_currency') == "LUF") echo ' selected'; ?>>Luxembourg Franc</option>
                        <option value="MOP" <?php if (get_option('ec_option_firstdatae4_currency') == "MOP") echo ' selected'; ?>>Macau Pataca</option>
                        <option value="MGF" <?php if (get_option('ec_option_firstdatae4_currency') == "MGF") echo ' selected'; ?>>Malagasy Franc</option>
                        <option value="MWK" <?php if (get_option('ec_option_firstdatae4_currency') == "MWK") echo ' selected'; ?>>Malawi Kwacha</option>
                        <option value="MYR" <?php if (get_option('ec_option_firstdatae4_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="MVR" <?php if (get_option('ec_option_firstdatae4_currency') == "MVR") echo ' selected'; ?>>Maldive Rufiyaa</option>
                        <option value="MTL" <?php if (get_option('ec_option_firstdatae4_currency') == "MRL") echo ' selected'; ?>>Maltese Lira</option>
                        <option value="MRO" <?php if (get_option('ec_option_firstdatae4_currency') == "MRO") echo ' selected'; ?>>Mauritanian Ouguiya</option>
                        <option value="MUR" <?php if (get_option('ec_option_firstdatae4_currency') == "MUR") echo ' selected'; ?>>Mauritius Rupee</option>
                        <option value="MXN" <?php if (get_option('ec_option_firstdatae4_currency') == "MXN") echo ' selected'; ?>>Mexican Peso</option>
                        <option value="MNT" <?php if (get_option('ec_option_firstdatae4_currency') == "MNT") echo ' selected'; ?>>Mongolian Tugrik</option>
                        <option value="MAD" <?php if (get_option('ec_option_firstdatae4_currency') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                        <option value="MZM" <?php if (get_option('ec_option_firstdatae4_currency') == "MZM") echo ' selected'; ?>>Mozambique Metical</option>
                        <option value="MMK" <?php if (get_option('ec_option_firstdatae4_currency') == "MMK") echo ' selected'; ?>>Myanmar Kyat</option>
                        <option value="ANG" <?php if (get_option('ec_option_firstdatae4_currency') == "ANG") echo ' selected'; ?>>NL Antillian Guilder</option>
                        <option value="NAD" <?php if (get_option('ec_option_firstdatae4_currency') == "NAD") echo ' selected'; ?>>Namibia Dollar</option>
                        <option value="NPR" <?php if (get_option('ec_option_firstdatae4_currency') == "NPR") echo ' selected'; ?>>Nepalese Rupee</option>
                        <option value="NZD" <?php if (get_option('ec_option_firstdatae4_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="NIO" <?php if (get_option('ec_option_firstdatae4_currency') == "NIO") echo ' selected'; ?>>Nicaraguan Cordoba Oro</option>
                        <option value="NGN" <?php if (get_option('ec_option_firstdatae4_currency') == "NGN") echo ' selected'; ?>>Nigerian Naira</option>
                        <option value="NOK" <?php if (get_option('ec_option_firstdatae4_currency') == "NOK") echo ' selected'; ?>>Norwegian Kroner</option>
                        <option value="OMR" <?php if (get_option('ec_option_firstdatae4_currency') == "OMR") echo ' selected'; ?>>Omani Rial</option>
                        <option value="PKR" <?php if (get_option('ec_option_firstdatae4_currency') == "PKR") echo ' selected'; ?>>Pakistan Rupee</option>
                        <option value="XPD" <?php if (get_option('ec_option_firstdatae4_currency') == "XPD") echo ' selected'; ?>>Palladium (oz.)</option>
                        <option value="PAB" <?php if (get_option('ec_option_firstdatae4_currency') == "PAB") echo ' selected'; ?>>Panamanian Balboa</option>
                        <option value="PGK" <?php if (get_option('ec_option_firstdatae4_currency') == "PGK") echo ' selected'; ?>>Papua New Guinea Kina</option>
                        <option value="PYG" <?php if (get_option('ec_option_firstdatae4_currency') == "PYG") echo ' selected'; ?>>Paraguay Guarani</option>
                        <option value="PEN" <?php if (get_option('ec_option_firstdatae4_currency') == "PEN") echo ' selected'; ?>>Peruvian Nuevo Sol</option>
                        <option value="PHP" <?php if (get_option('ec_option_firstdatae4_currency') == "PHP") echo ' selected'; ?>>Philippine Peso</option>
                        <option value="XPT" <?php if (get_option('ec_option_firstdatae4_currency') == "XPT") echo ' selected'; ?>>Platinum (oz.)</option>
                        <option value="PLN" <?php if (get_option('ec_option_firstdatae4_currency') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                        <option value="PTE" <?php if (get_option('ec_option_firstdatae4_currency') == "PTE") echo ' selected'; ?>>Portuguese Escudo</option>
                        <option value="QAR" <?php if (get_option('ec_option_firstdatae4_currency') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                        <option value="ROL" <?php if (get_option('ec_option_firstdatae4_currency') == "ROL") echo ' selected'; ?>>Romanian Leu</option>
                        <option value="RUB" <?php if (get_option('ec_option_firstdatae4_currency') == "RUB") echo ' selected'; ?>>Russian Rouble</option>
                        <option value="WST" <?php if (get_option('ec_option_firstdatae4_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                        <option value="STD" <?php if (get_option('ec_option_firstdatae4_currency') == "STD") echo ' selected'; ?>>Sao Tome/Principe Dobra</option>
                        <option value="SAR" <?php if (get_option('ec_option_firstdatae4_currency') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                        <option value="SCR" <?php if (get_option('ec_option_firstdatae4_currency') == "SCR") echo ' selected'; ?>>Seychelles Rupee</option>
                        <option value="SLL" <?php if (get_option('ec_option_firstdatae4_currency') == "SLL") echo ' selected'; ?>>Sierra Leone Leone</option>
                        <option value="XAG" <?php if (get_option('ec_option_firstdatae4_currency') == "XAG") echo ' selected'; ?>>Silver (oz.)</option>
                        <option value="SGD" <?php if (get_option('ec_option_firstdatae4_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="SKK" <?php if (get_option('ec_option_firstdatae4_currency') == "SKK") echo ' selected'; ?>>Slovak Koruna</option>
                        <option value="SIT" <?php if (get_option('ec_option_firstdatae4_currency') == "SIT") echo ' selected'; ?>>Slovenian Tolar</option>
                        <option value="SBD" <?php if (get_option('ec_option_firstdatae4_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                        <option value="ZAR" <?php if (get_option('ec_option_firstdatae4_currency') == "ZAR") echo ' selected'; ?>>South African Rand</option>
                        <option value="KRW" <?php if (get_option('ec_option_firstdatae4_currency') == "KRW") echo ' selected'; ?>>South-Korean Won</option>
                        <option value="ESP" <?php if (get_option('ec_option_firstdatae4_currency') == "ESP") echo ' selected'; ?>>Spanish Peseta</option>
                        <option value="LKR" <?php if (get_option('ec_option_firstdatae4_currency') == "LKR") echo ' selected'; ?>>Sri Lanka Rupee</option>
                        <option value="SHP" <?php if (get_option('ec_option_firstdatae4_currency') == "SHP") echo ' selected'; ?>>St. Helena Pound</option>
                        <option value="SRG" <?php if (get_option('ec_option_firstdatae4_currency') == "SRG") echo ' selected'; ?>>Suriname Guilder</option>
                        <option value="SZL" <?php if (get_option('ec_option_firstdatae4_currency') == "SZL") echo ' selected'; ?>>Swaziland Lilangeni</option>
                        <option value="SEK" <?php if (get_option('ec_option_firstdatae4_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="TWD" <?php if (get_option('ec_option_firstdatae4_currency') == "TWS") echo ' selected'; ?>>Taiwan Dollar</option>
                        <option value="TZS" <?php if (get_option('ec_option_firstdatae4_currency') == "TZS") echo ' selected'; ?>>Tanzanian Shilling</option>
                        <option value="THB" <?php if (get_option('ec_option_firstdatae4_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                        <option value="TOP" <?php if (get_option('ec_option_firstdatae4_currency') == "TOP") echo ' selected'; ?>>Tonga Pa'anga</option>
                        <option value="TTD" <?php if (get_option('ec_option_firstdatae4_currency') == "TTD") echo ' selected'; ?>>Trinidad/Tobago Dollar</option>
                        <option value="TND" <?php if (get_option('ec_option_firstdatae4_currency') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                        <option value="TRL" <?php if (get_option('ec_option_firstdatae4_currency') == "TRL") echo ' selected'; ?>>Turkish Lira</option>
                        <option value="UGS" <?php if (get_option('ec_option_firstdatae4_currency') == "UGS") echo ' selected'; ?>>Uganda Shilling</option>
                        <option value="UAH" <?php if (get_option('ec_option_firstdatae4_currency') == "UAH") echo ' selected'; ?>>Ukraine Hryvnia</option>
                        <option value="UYP" <?php if (get_option('ec_option_firstdatae4_currency') == "UYP") echo ' selected'; ?>>Uruguayan Peso</option>
                        <option value="AED" <?php if (get_option('ec_option_firstdatae4_currency') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                        <option value="VUV" <?php if (get_option('ec_option_firstdatae4_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                        <option value="VEB" <?php if (get_option('ec_option_firstdatae4_currency') == "VEB") echo ' selected'; ?>>Venezuelan Bolivar</option>
                        <option value="VND" <?php if (get_option('ec_option_firstdatae4_currency') == "VND") echo ' selected'; ?>>Vietnamese Dong</option>
                        <option value="YUN" <?php if (get_option('ec_option_firstdatae4_currency') == "YUN") echo ' selected'; ?>>Yugoslav Dinar</option>
                        <option value="ZMK" <?php if (get_option('ec_option_firstdatae4_currency') == "ZMK") echo ' selected'; ?>>Zambian Kwacha</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Firstdata e4 Test Mode:</td>
                      <td><select name="ec_option_firstdatae4_test_mode" id="ec_option_firstdatae4_test_mode">
                        <option value="1" <?php if (get_option('ec_option_firstdatae4_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_firstdatae4_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                
                <tr valign="top" class="form-table" id="paymentexpress">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Payment Express User Name:</td>
                      <td width="74%"><input name="ec_option_payment_express_username"  id="ec_option_payment_express_username" type="text" value="<?php echo get_option('ec_option_payment_express_username'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Payment Express Password:</td>
                      <td><input name="ec_option_payment_express_password"  id="ec_option_payment_express_password" type="text" value="<?php echo get_option('ec_option_payment_express_password'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Payment Express Currency:</td>
                      <td>
                      <select name="ec_option_payment_express_currency" id="ec_option_payment_express_currency">
                        <option value="USD" <?php if (get_option('ec_option_payment_express_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_payment_express_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="CHF" <?php if (get_option('ec_option_payment_express_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="DKK" <?php if (get_option('ec_option_payment_express_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="EUR" <?php if (get_option('ec_option_payment_express_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="FRF" <?php if (get_option('ec_option_payment_express_currency') == "FRF") echo ' selected'; ?>>French Franc</option>
                        <option value="GBP" <?php if (get_option('ec_option_payment_express_currency') == "GBP") echo ' selected'; ?>>United Kingdom Pound</option>
                        <option value="HKD" <?php if (get_option('ec_option_payment_express_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="JPY" <?php if (get_option('ec_option_payment_express_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="NZD" <?php if (get_option('ec_option_payment_express_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="SGD" <?php if (get_option('ec_option_payment_express_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="THB" <?php if (get_option('ec_option_payment_express_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                        <option value="ZAR" <?php if (get_option('ec_option_payment_express_currency') == "ZAR") echo ' selected'; ?>>Rand</option>
                        <option value="AUD" <?php if (get_option('ec_option_payment_express_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="WST" <?php if (get_option('ec_option_payment_express_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                        <option value="VUV" <?php if (get_option('ec_option_payment_express_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                        <option value="TOP" <?php if (get_option('ec_option_payment_express_currency') == "TOP") echo ' selected'; ?>>Tongan Pa'anga</option>
                        <option value="SBD" <?php if (get_option('ec_option_payment_express_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                        <option value="PGK" <?php if (get_option('ec_option_payment_express_currency') == "PGK") echo ' selected'; ?>>Papua New Guinea Kina</option>
                        <option value="MYR" <?php if (get_option('ec_option_payment_express_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="KWD" <?php if (get_option('ec_option_payment_express_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                        <option value="FJD" <?php if (get_option('ec_option_payment_express_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                        
                      </select>
                      </td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="securepay">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">SecurePay Merchant ID:</td>
                      <td width="74%"><input name="ec_option_securepay_merchant_id"  id="ec_option_securepay_merchant_id" type="text" value="<?php echo get_option('ec_option_securepay_merchant_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">SecurePay Password:</td>
                      <td><input name="ec_option_securepay_password"  id="ec_option_securepay_password" type="text" value="<?php echo get_option('ec_option_securepay_password'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">SecurePay Currency:</td>
                      <td><select name="ec_option_securepay_currency" id="ec_option_securepay_currency">
                        <option value="AUD" <?php if (get_option('ec_option_securepay_test_mode') == "AUD") echo ' selected'; ?>>AUD</option>
                        <option value="CAD" <?php if (get_option('ec_option_securepay_test_mode') == "CAD") echo ' selected'; ?>>CAD</option>
                        <option value="CHF" <?php if (get_option('ec_option_securepay_test_mode') == "CHF") echo ' selected'; ?>>CHF</option>
                        <option value="EUR" <?php if (get_option('ec_option_securepay_test_mode') == "EUR") echo ' selected'; ?>>EUR</option>
                        <option value="GBP" <?php if (get_option('ec_option_securepay_test_mode') == "GBP") echo ' selected'; ?>>GBP</option>
                        <option value="HKD" <?php if (get_option('ec_option_securepay_test_mode') == "HKD") echo ' selected'; ?>>HKD</option>
                        <option value="JPY" <?php if (get_option('ec_option_securepay_test_mode') == "CHF") echo ' selected'; ?>>JPY</option>
                        <option value="NZD" <?php if (get_option('ec_option_securepay_test_mode') == "NZD") echo ' selected'; ?>>NZD</option>
                        <option value="SGD" <?php if (get_option('ec_option_securepay_test_mode') == "SGD") echo ' selected'; ?>>SGD</option>
                        <option value="USD" <?php if (get_option('ec_option_securepay_test_mode') == "USD") echo ' selected'; ?>>USD</option>
                      </select></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">SecurePay Test Mode:</td>
                      <td><select name="ec_option_securepay_test_mode" id="ec_option_securepay_test_mode">
                        <option value="1" <?php if (get_option('ec_option_securepay_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_securepay_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                <tr valign="top" class="form-table" id="psigate">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">PSI Gate Store ID:</td>
                      <td width="74%"><input name="ec_option_psigate_store_id"  id="ec_option_psigate_store_id" type="text" value="<?php echo get_option('ec_option_psigate_store_id'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">PSI Gate Passphrase:</td>
                      <td><input name="ec_option_psigate_passphrase"  id="ec_option_psigate_passphrase" type="text" value="<?php echo get_option('ec_option_psigate_passphrase'); ?>" style="width:250px;" /></td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">PSI Gate Test Mode:</td>
                      <td><select name="ec_option_psigate_test_mode" id="ec_option_psigate_test_mode">
                        <option value="1" <?php if (get_option('ec_option_psigate_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_psigate_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr valign="top">
              <td height="19" colspan="2" scope="row"><span class="submit">
                <input type="hidden" name="isupdate2" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
              </span></td>
            </tr>
            <tr valign="top">
              <td height="19" scope="row">&nbsp;</td>
              <td height="19" scope="row">&nbsp;</td>
            </tr> 
			
			
			
			<script language="javascript" type="application/javascript">
				function toggle_third_party() {
					
					var paymentmethod = document.getElementById("ec_option_payment_third_party").value;
					
					document.getElementById("paypal").style.display = 'none';
					document.getElementById("skrill").style.display = 'none';
				   
					if( paymentmethod == 'paypal' ) {
					   document.getElementById( "paypal" ).style.display = "";
					}else if( paymentmethod == 'skrill' ){
						document.getElementById( "skrill" ).style.display = "";	
					}
					
				}
			</script>
            <tr valign="top">
              <td height="19" class="platformheading" scope="row">Use Payment Proxy</td>
              <td height="19" class="platformheadingimage" scope="row"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row">Some hosting environments require a proxy server to use payment SSL requests. If you have been instructed to enter a proxy by your host or by EasyCart staff, please enter it below.</td>
            </tr>
		
            <tr valign="top">
                <td class="itemheading" scope="row">Use Proxy:</td>
            
                <td>
                <select name="ec_option_use_proxy" id="ec_option_use_proxy"> 
                  <option value="1" <?php if (get_option('ec_option_use_proxy') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_proxy') == 0) echo ' selected'; ?>>No</option>
              	</select>
                
                <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url('images/Help.png', __FILE__); ?>" alt="Help" height="48" width="48" /><em>Use Proxy Address</em>Most webservers will allow payments to be processed without a proxy server, however, you may be instructed by an EasyCart staff to enter a proxy address here.  Otherwise, this option can be disabled and left blank.</span></a>
                
                </td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row">Proxy Address:</td>
            
                <td><input name="ec_option_proxy_address"  id="ec_option_proxy_address" type="text" value="<?php echo get_option('ec_option_proxy_address'); ?>" style="width:250px;" /></td>
            </tr>
          	<tr valign="top">
              <td height="19" colspan="2" scope="row"><span class="submit">
                <input type="hidden" name="isupdate3" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
              </span></td>
            </tr>
            
            <?php }else if( $license->is_registered() && $license->is_lite_version() ){?>
            
            <tr valign="top">
              <td height="19" class="platformheading" scope="row">Third Party Payment Processing</td>
              <td height="19" class="platformheadingimage" scope="row"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row">Third party payment processors are those in which customers leave your website and will visit the third party payment pages to finish payment.</td>
            </tr>
           
            <tr valign="top">
              <td valign="middle" class="itemheading" scope="row">Select Third Party Processor:</td>
              <td valign="middle">
              	<select name="ec_option_payment_third_party" id="ec_option_payment_third_party" onchange="toggle_third_party()">
                	<option value="0" <?php if (get_option('ec_option_payment_third_party') == 0) echo ' selected'; ?>>No Third Party Processor</option>
                	<option value="paypal" <?php if (get_option('ec_option_payment_third_party') == "paypal") echo ' selected'; ?>>PayPal</option>
                	<option value="skrill" <?php if (get_option('ec_option_payment_third_party') == "skrill") echo ' selected'; ?>>Skrill</option>
              	</select>
              </td>
            </tr>
            
            <tr valign="top" id="paypal">
              <td colspan="2" class="itemheading" scope="row">
              
              <table width="90%" border="0" cellspacing="0" cellpadding="0">
              	
                <tr valign="top">
                  <td width="24%" class="itemheading" scope="row">PayPal Email:</td>
                  <td width="76%"><input name="ec_option_paypal_email" id="ec_option_paypal_email" type="text" value="<?php echo get_option('ec_option_paypal_email'); ?>" style="width:250px;" />
                  	<a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        <span class="ec_custom ec_help">
                            <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            <em>Email Address</em>
                            The email address associated with your PayPal account.
                        </span>
                    </a>
                  </td>
                </tr>
                <tr valign="top">
                  <td class="itemheading" scope="row">PayPal Currency Code:</td>
                  <td>
                  <select name="ec_option_paypal_currency_code" id="ec_option_paypal_currency_code">
                    <option value="USD" <?php if (get_option('ec_option_paypal_currency_code') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
                    <option value="AUD" <?php if (get_option('ec_option_paypal_currency_code') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
                    <option value="BRL" <?php if (get_option('ec_option_paypal_currency_code') == 'BRL') echo ' selected'; ?>>Brazilian Real</option>
                    <option value="CAD" <?php if (get_option('ec_option_paypal_currency_code') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
                    <option value="CZK" <?php if (get_option('ec_option_paypal_currency_code') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
                    <option value="CZK" <?php if (get_option('ec_option_paypal_currency_code') == 'CZK') echo ' selected'; ?>>Danish Krone</option>
                    <option value="EUR" <?php if (get_option('ec_option_paypal_currency_code') == 'EUR') echo ' selected'; ?>>Euro</option>
                    <option value="HKD" <?php if (get_option('ec_option_paypal_currency_code') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
                    <option value="HUF" <?php if (get_option('ec_option_paypal_currency_code') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
                    <option value="ILS" <?php if (get_option('ec_option_paypal_currency_code') == 'ILS') echo ' selected'; ?>>Israeli New Sheqel</option>
                    <option value="JPY" <?php if (get_option('ec_option_paypal_currency_code') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
                    <option value="MYR" <?php if (get_option('ec_option_paypal_currency_code') == 'MYR') echo ' selected'; ?>>Malaysian Ringgit</option>
                    <option value="MXN" <?php if (get_option('ec_option_paypal_currency_code') == 'MXN') echo ' selected'; ?>>Mexican Peso</option>
                    <option value="NOK" <?php if (get_option('ec_option_paypal_currency_code') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
                    <option value="NZD" <?php if (get_option('ec_option_paypal_currency_code') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
                    <option value="PHP" <?php if (get_option('ec_option_paypal_currency_code') == 'PHP') echo ' selected'; ?>>Philippine Peso</option>
                    <option value="PLN" <?php if (get_option('ec_option_paypal_currency_code') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
                    <option value="GBP" <?php if (get_option('ec_option_paypal_currency_code') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
                    <option value="SGD" <?php if (get_option('ec_option_paypal_currency_code') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
                    <option value="SEK" <?php if (get_option('ec_option_paypal_currency_code') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
                    <option value="CHF" <?php if (get_option('ec_option_paypal_currency_code') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
                    <option value="TWD" <?php if (get_option('ec_option_paypal_currency_code') == 'TWD') echo ' selected'; ?>>Taiwan New Dollar</option>
                    <option value="THB" <?php if (get_option('ec_option_paypal_currency_code') == 'THB') echo ' selected'; ?>>Thai Baht</option>
                    <option value="TRY" <?php if (get_option('ec_option_paypal_currency_code') == 'TRY') echo ' selected'; ?>>Turkish Lira</option>
                  </select>
                  <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        <span class="ec_custom ec_help">
                            <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            <em>Currency Code</em>
                            The currency code used to process a transaction.
                        </span>
                    </a>
                  </td>
                </tr>
                <tr valign="top">
                  <td class="itemheading" scope="row">PayPal Language Code:</td>
                  <td>
                  <select name="ec_option_paypal_lc" id="ec_option_paypal_lc">
                    <option value="US" <?php if (get_option('ec_option_paypal_lc') == 'US') echo ' selected'; ?>>United States</option>
                    <option value="AU" <?php if (get_option('ec_option_paypal_lc') == 'AU') echo ' selected'; ?>>Australia</option>
                    <option value="AT" <?php if (get_option('ec_option_paypal_lc') == 'AT') echo ' selected'; ?>>Austria</option>
                    <option value="BE" <?php if (get_option('ec_option_paypal_lc') == 'BE') echo ' selected'; ?>>Belgium</option>
                    <option value="BR" <?php if (get_option('ec_option_paypal_lc') == 'BR') echo ' selected'; ?>>Brazil</option>
                    <option value="CA" <?php if (get_option('ec_option_paypal_lc') == 'CA') echo ' selected'; ?>>Canada</option>
                    <option value="CH" <?php if (get_option('ec_option_paypal_lc') == 'CH') echo ' selected'; ?>>Switzerland</option>
                    <option value="CN" <?php if (get_option('ec_option_paypal_lc') == 'CN') echo ' selected'; ?>>China</option>
                    <option value="DE" <?php if (get_option('ec_option_paypal_lc') == 'DE') echo ' selected'; ?>>Germany</option>
                    <option value="ES" <?php if (get_option('ec_option_paypal_lc') == 'ES') echo ' selected'; ?>>Spain</option>
                    <option value="GB" <?php if (get_option('ec_option_paypal_lc') == 'GB') echo ' selected'; ?>>United Kingdom</option>
                    <option value="FR" <?php if (get_option('ec_option_paypal_lc') == 'FR') echo ' selected'; ?>>France</option>
                    <option value="IT" <?php if (get_option('ec_option_paypal_lc') == 'IT') echo ' selected'; ?>>Italy</option>
                    <option value="NL" <?php if (get_option('ec_option_paypal_lc') == 'NL') echo ' selected'; ?>>Netherlands</option>
                    <option value="PL" <?php if (get_option('ec_option_paypal_lc') == 'PL') echo ' selected'; ?>>Poland</option>
                    <option value="PT" <?php if (get_option('ec_option_paypal_lc') == 'PT') echo ' selected'; ?>>Portugal</option>
                    <option value="RU" <?php if (get_option('ec_option_paypal_lc') == 'RU') echo ' selected'; ?>>Russia</option>
                    <option value="da_DK" <?php if (get_option('ec_option_paypal_lc') == 'da_DK') echo ' selected'; ?>>Danish (for Denmark only)</option>
                    <option value="he_IL" <?php if (get_option('ec_option_paypal_lc') == 'he_IL') echo ' selected'; ?>>Hebrew (all)</option>
                    <option value="id_ID" <?php if (get_option('ec_option_paypal_lc') == 'id_ID') echo ' selected'; ?>>Indonesian (for Indonesia only)</option>
                    <option value="jp_JP" <?php if (get_option('ec_option_paypal_lc') == 'jp_JP') echo ' selected'; ?>>Japanese (for Japan only)</option>
                    <option value="no_NO" <?php if (get_option('ec_option_paypal_lc') == 'no_NO') echo ' selected'; ?>>Norwegian (for Norway only)</option>
                    <option value="pt_BR" <?php if (get_option('ec_option_paypal_lc') == 'pt_BR') echo ' selected'; ?>>Brazilian Portuguese (for Portugal and Brazil only)</option>
                    <option value="ru_RU" <?php if (get_option('ec_option_paypal_lc') == 'ru_RU') echo ' selected'; ?>>Russian (for Lithuania, Latvia, and Ukraine only)</option>
                    <option value="sv_SE" <?php if (get_option('ec_option_paypal_lc') == 'sv_SE') echo ' selected'; ?>>Swedish (for Sweden only)</option>
                    <option value="th_TH" <?php if (get_option('ec_option_paypal_lc') == 'th_TH') echo ' selected'; ?>>Thai (for Thailand only)</option>
                    <option value="tr_TR" <?php if (get_option('ec_option_paypal_lc') == 'tr_TR') echo ' selected'; ?>>Turkish (for Turkey only)</option>
                    <option value="zh_CN" <?php if (get_option('ec_option_paypal_lc') == 'zh_CN') echo ' selected'; ?>>Simplified Chinese (for China only)</option>
                    <option value="zh_HK" <?php if (get_option('ec_option_paypal_lc') == 'zh_HK') echo ' selected'; ?>>Traditional Chinese (for Hong Kong only)</option>
                    <option value="zh_TW" <?php if (get_option('ec_option_paypal_lc') == 'zh_TW') echo ' selected'; ?>>Traditional Chinese (for Taiwan only)</option>
                  </select>
                  <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        <span class="ec_custom ec_help">
                            <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            <em>Language Code</em>
                            The language to be used during checkout on the PayPal page.
                        </span>
                    </a>
                  </td>
                </tr>
                <tr valign="top">
                  <td class="itemheading" scope="row">PayPal Weight Unit:</td>
                  <td><select name="ec_option_paypal_weight_unit" id="ec_option_paypal_weight_unit">
                    <option value="lbs" <?php if (get_option('ec_option_paypal_weight_unit') == 'lbs') echo ' selected'; ?>>LBS</option>
                    <option value="kgs" <?php if (get_option('ec_option_paypal_weight_unit') == 'kgs') echo ' selected'; ?>>KGS</option>
                  </select>
                  <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        <span class="ec_custom ec_help">
                            <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            <em>Weight Unit</em>
                            (Optional) Used if your PayPal account has shipping settings overriding the WP EasyCart shipping values.
                        </span>
                    </a>
                    </td>
                </tr>
                <tr valign="top">
                  <td class="itemheading" scope="row">PayPal Use Sandbox For Testing:</td>
                  <td><select name="ec_option_paypal_use_sandbox" id="ec_option_paypal_use_sandbox">
                    <option value="1" <?php if (get_option('ec_option_paypal_use_sandbox') == 1) echo ' selected'; ?>>Yes</option>
                    <option value="0" <?php if (get_option('ec_option_paypal_use_sandbox') == 0) echo ' selected'; ?>>No</option>
                  </select>
                  <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        <span class="ec_custom ec_help">
                            <img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            <em>Sandbox</em>
                            Turn this off when you are ready to sell items live on your website.
                        </span>
                    </a>
                  </td>
                </tr>
              </table>
              
              </td>
            </tr>
            
            <tr valign="top" class="form-table" id="skrill">
                  <td height="116" colspan="2" scope="row"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Skrill Information:</td>
                      <td width="74%">Skrill is not accepted in Afghanistan, Cuba, Myanmar, Nigeria, North Korea, Sudan, Syria, Somalia, and Yemen.</td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Skrill Merchant ID (Customer ID):</td>
                      <td width="74%"><input name="ec_option_skrill_merchant_id"  id="ec_option_skrill_merchant_id" type="text" value="<?php echo get_option('ec_option_skrill_merchant_id'); ?>" style="width:250px;" />
                        <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Customer ID</em>
                                The customer ID associated with your skrill account.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Skrill Company Name:</td>
                      <td><input name="ec_option_skrill_company_name"  id="ec_option_skrill_company_name" type="text" value="<?php echo get_option('ec_option_skrill_company_name'); ?>" style="width:250px;" />
                      	<a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Company Name</em>
                                (Required) This is your company name for your Skrill account.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Skrill Email:</td>
                      <td><input name="ec_option_skrill_email" id="ec_option_skrill_email"  type="text" value="<?php echo get_option('ec_option_skrill_email'); ?>" style="width:250px;" />
                      	<a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Email Address</em>
                                (Optional) email used to send order data, use only for testing and leave blank for live processing.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td width="26%" class="itemheading" scope="row">Skrill Language:</td>
                      <td width="74%"><select name="ec_option_skrill_language" id="ec_option_skrill_language">
                        <option value="EN" <?php if (get_option('ec_option_skrill_language') == "EN") echo ' selected'; ?>>EN</option>
                        <option value="DE" <?php if (get_option('ec_option_skrill_language') == "DE") echo ' selected'; ?>>DE</option>
                        <option value="ES" <?php if (get_option('ec_option_skrill_language') == "ES") echo ' selected'; ?>>ES</option>
                        <option value="FR" <?php if (get_option('ec_option_skrill_language') == "FR") echo ' selected'; ?>>FR</option>
                        <option value="IT" <?php if (get_option('ec_option_skrill_language') == "IT") echo ' selected'; ?>>IT</option>
                        <option value="PL" <?php if (get_option('ec_option_skrill_language') == "PL") echo ' selected'; ?>>PL</option>
                        <option value="GR" <?php if (get_option('ec_option_skrill_language') == "GR") echo ' selected'; ?>>GR</option>
                        <option value="RO" <?php if (get_option('ec_option_skrill_language') == "RO") echo ' selected'; ?>>RO</option>
                        <option value="RU" <?php if (get_option('ec_option_skrill_language') == "RU") echo ' selected'; ?>>RU</option>
                        <option value="TR" <?php if (get_option('ec_option_skrill_language') == "TR") echo ' selected'; ?>>TR</option>
                        <option value="CN" <?php if (get_option('ec_option_skrill_language') == "CN") echo ' selected'; ?>>CN</option>
                        <option value="CZ" <?php if (get_option('ec_option_skrill_language') == "CZ") echo ' selected'; ?>>CZ</option>
                        <option value="NL" <?php if (get_option('ec_option_skrill_language') == "NL") echo ' selected'; ?>>NL</option>
                        <option value="DA" <?php if (get_option('ec_option_skrill_language') == "DA") echo ' selected'; ?>>DA</option>
                        <option value="SV" <?php if (get_option('ec_option_skrill_language') == "SV") echo ' selected'; ?>>SV</option>
                        <option value="FI" <?php if (get_option('ec_option_skrill_language') == "FI") echo ' selected'; ?>>FI</option>
                        <option value="BG" <?php if (get_option('ec_option_skrill_language') == "BG") echo ' selected'; ?>>BG</option>
                      </select>
                        
                        <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Language Code</em>
                                (Required) select your language code for your website/checkout process.
                            </span>
                        </a>
                      </td>
                    </tr>
                    <tr valign="top" class="form-table">
                      <td class="itemheading" scope="row">Skrill Currency Code:</td>
                      <td><select name="ec_option_skrill_currency_code" id="ec_option_skrill_currency_code">
                        <option value="USD" <?php if (get_option('ec_option_skrill_currency_code') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="EUR" <?php if (get_option('ec_option_skrill_currency_code') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="GBP" <?php if (get_option('ec_option_skrill_currency_code') == "GBP") echo ' selected'; ?>>British Pound</option>
                        <option value="HKD" <?php if (get_option('ec_option_skrill_currency_code') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="SGD" <?php if (get_option('ec_option_skrill_currency_code') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="JPY" <?php if (get_option('ec_option_skrill_currency_code') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="CAD" <?php if (get_option('ec_option_skrill_currency_code') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="AUD" <?php if (get_option('ec_option_skrill_currency_code') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="CHF" <?php if (get_option('ec_option_skrill_currency_code') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="DKK" <?php if (get_option('ec_option_skrill_currency_code') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="SEK" <?php if (get_option('ec_option_skrill_currency_code') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="NOK" <?php if (get_option('ec_option_skrill_currency_code') == "NOK") echo ' selected'; ?>>Norwegian Krone</option>
                        <option value="ILS" <?php if (get_option('ec_option_skrill_currency_code') == "ILS") echo ' selected'; ?>>Israeli Shekel</option>
                        <option value="MYR" <?php if (get_option('ec_option_skrill_currency_code') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="NZD" <?php if (get_option('ec_option_skrill_currency_code') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="TRY" <?php if (get_option('ec_option_skrill_currency_code') == "TRY") echo ' selected'; ?>>New Turkish Lira</option>
                        <option value="AED" <?php if (get_option('ec_option_skrill_currency_code') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                        <option value="MAD" <?php if (get_option('ec_option_skrill_currency_code') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                        <option value="QAR" <?php if (get_option('ec_option_skrill_currency_code') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                        <option value="SAR" <?php if (get_option('ec_option_skrill_currency_code') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                        <option value="TWD" <?php if (get_option('ec_option_skrill_currency_code') == "TWD") echo ' selected'; ?>>Taiwan Dollar</option>
                        <option value="THB" <?php if (get_option('ec_option_skrill_currency_code') == "THB") echo ' selected'; ?>>Thailand Baht</option>
                        <option value="CZK" <?php if (get_option('ec_option_skrill_currency_code') == "CZK") echo ' selected'; ?>>Czech Koruna</option>
                        <option value="HUF" <?php if (get_option('ec_option_skrill_currency_code') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                        <option value="SKK" <?php if (get_option('ec_option_skrill_currency_code') == "SKK") echo ' selected'; ?>>Slovakian Koruna</option>
                        <option value="EEK" <?php if (get_option('ec_option_skrill_currency_code') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                        <option value="BGN" <?php if (get_option('ec_option_skrill_currency_code') == "BGN") echo ' selected'; ?>>Bulgarian Leva</option>
                        <option value="PLN" <?php if (get_option('ec_option_skrill_currency_code') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                        <option value="ISK" <?php if (get_option('ec_option_skrill_currency_code') == "ISK") echo ' selected'; ?>>Iceland Krona</option>
                        <option value="INR" <?php if (get_option('ec_option_skrill_currency_code') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                        <option value="LVL" <?php if (get_option('ec_option_skrill_currency_code') == "LVL") echo ' selected'; ?>>Latvian Lat</option>
                        <option value="KRW" <?php if (get_option('ec_option_skrill_currency_code') == "KRW") echo ' selected'; ?>>South-Korean Won</option>
                        <option value="ZAR" <?php if (get_option('ec_option_skrill_currency_code') == "ZAR") echo ' selected'; ?>>South-African Rand</option>
                        <option value="RON" <?php if (get_option('ec_option_skrill_currency_code') == "RON") echo ' selected'; ?>>Romanian Leu New</option>
                        <option value="HRK" <?php if (get_option('ec_option_skrill_currency_code') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                        <option value="LTL" <?php if (get_option('ec_option_skrill_currency_code') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                        <option value="JOD" <?php if (get_option('ec_option_skrill_currency_code') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                        <option value="OMR" <?php if (get_option('ec_option_skrill_currency_code') == "OMR") echo ' selected'; ?>>Omani Rial</option>
                        <option value="RSD" <?php if (get_option('ec_option_skrill_currency_code') == "RSD") echo ' selected'; ?>>Serbian dinar</option>
                        <option value="TND" <?php if (get_option('ec_option_skrill_currency_code') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                      </select>
                        
                        <a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('images/help_icon.png', __FILE__ ); ?>" alt="Help" width="25" height="25">
                        	<span class="ec_custom ec_help">
                            	<img src="<?php echo plugins_url('images/Help.png', __FILE__ ); ?>" alt="Help" height="48" width="48">
                            	<em>Currency Code</em>
                                (Required) The currency code used to process transactions.
                            </span>
                        </a>
                      </td>
                    </tr>
                  </table></td>
                </tr>
                
          
          			
            
            <tr valign="top">
              <td height="19" colspan="2" scope="row"><span class="submit">
                <input type="hidden" name="isupdate3" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
              </span></td>
            </tr>
            <tr valign="top">
              <td height="19" scope="row">&nbsp;</td>
              <td height="19" scope="row">&nbsp;</td>
            </tr>
            
           <?php } else { ?>
           <tr>
           <td colspan="2"> <div class='info_note'>
             <p><strong>To access live payment gateways such as PayPal Pro, Authorize.net, FirstData, PayPal Standard, and other payment gateways, you must purchase a license and upgrade to our FULL edition plugin. Third party gateways like PayPal Free and Skrill are available on both the LITE and FULL versions. For more information, please visit <a href="http://www.wpeasycart.com" target="_blank">www.wpeasycart.com</a>.</strong></p></div>  
           </td>
           </tr>
           <?php } ?>
           
           <?php if( $license->is_lite_version() ){ ?>
           <tr>
           <td colspan="2"> <div class='info_note'>
             <p><strong>To access live payment gateways such as PayPal Pro, Authorize.net, FirstData, PayPal Standard, and other payment gateways, you must upgrade to our FULL edition plugin. For more information, please visit <a href="http://www.wpeasycart.com" target="_blank">www.wpeasycart.com</a> .</strong></p></div>  
           </td>
           </tr>
           <?php }?>
           
           
      </table>
        
        
    
    </form>
    </div>
</div>

<script type="application/javascript" language="javascript">
	toggle_direct_deposit();
 	toggle_live_cards();
	toggle_live_gateways();
	toggle_third_party();

</script>