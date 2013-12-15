<?php
///////////////////////////////////////////////
// Server Status Section
///////////////////////////////////////////////
?>

<div class="ec_status_header"><div class="ec_status_header_text">Server Settings Status</div></div>

<?php 
////////////////////////////
// PHP Versoin Check
////////////////////////////
if( ec_get_php_version( ) < 5.3 ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">PHP 5.3 is the optimaal setup. We do not guarantee functionality for PHP versions below 5.3 at this time.</span></div>
<?php }else if( ec_get_php_version( ) >= 5.4 ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">PHP 5.3 is the optimaal setup. We do not guarantee functionality for PHP 5.4 and above at this time.</span></div>
<?php }else{ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Your PHP Version is <?php echo ec_get_php_version( ); ?>, meeting the PHP 5.3 optimal setup.</span></div>
<?php } ?>

<?php 
///////////////////////////
// Session Writable Check
///////////////////////////
if( ec_is_session_writable( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Your session path is writable, which will allow the cart to function correctly.</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">Your session path is NOT writable and session variables cannot be written at this time. Contact your host to have this issue resolved.</span></div>
<?php } 
///////////////////////////////////////////////
// EasyCart Status Section
///////////////////////////////////////////////
?>


<div class="ec_status_header"><div class="ec_status_header_text">EasyCart Setup Status</div></div>
<?php
////////////////////////////
// Store Page Setup Check
////////////////////////////
if( ec_is_store_page_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Store Page Setup &amp; Connected Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><?php echo ec_get_store_page_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// Cart Page Setup Check
////////////////////////////
if( ec_is_cart_page_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Cart Page Setup &amp; Connected Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><?php echo ec_get_cart_page_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// Account Page Setup Check
////////////////////////////
if( ec_is_account_page_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Account Page Setup &amp; Connected Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><?php echo ec_get_account_page_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// Demo Data Addable Check
////////////////////////////
if( ec_is_demo_data_writable( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Your server is configured correctly for automatic demo data installation.</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">The setup of your server does not allow for us to copy the demo data and write it to your store. Manually add products to test functionality.</span></div>
<?php } ?>

<?php
////////////////////////////
// Demo Data Addable Check
////////////////////////////
if( ec_basic_settings_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have added the required basic settings.</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have not added a <?php echo ec_get_basic_missing_settings( ); ?>.</span></div>
<?php } 
///////////////////////////////////////////////
// Shipping Status Section
///////////////////////////////////////////////
?>

<div class="ec_status_header"><div class="ec_status_header_text">Shipping Status</div></div>

<?php
////////////////////////////
// Price Based Shipping Check
////////////////////////////
if( ec_using_price_shipping( ) && ec_price_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup price based shipping.</span></div>
<?php }else if( ec_using_price_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">The setup of your server does not allow for us to copy the demo data and write it to your store. Manually add products to test functionality.</span></div>
<?php }

////////////////////////////
// Weight Based Shipping Check
////////////////////////////
if( ec_using_weight_shipping( ) && ec_weight_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup weight based shipping.</span></div>
<?php }else if( ec_using_weight_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">The setup of your server does not allow for us to copy the demo data and write it to your store. Manually add products to test functionality.</span></div>
<?php }

////////////////////////////
// Method Based Shipping Check
////////////////////////////
if( ec_using_method_shipping( ) && ec_method_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup method based shipping.</span></div>
<?php }else if( ec_using_method_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have not added any price triggers, yet price based shipping is selected.</span></div>
<?php }

////////////////////////////
// Live Based Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && !ec_live_shipping_setup( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have live shipping selected, but no rates are setup.</span></div>
<?php }

////////////////////////////
// UPS Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_ups_shipping( ) && ec_ups_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup UPS live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_ups_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">UPS live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// USPS Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_usps_shipping( ) && ec_usps_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup USPS live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_usps_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">USPS live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// FEDEX Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_fedex_shipping( ) && ec_fedex_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup FedEx live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_fedex_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">FedEx live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// DHL Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_dhl_shipping( ) && ec_dhl_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup DHL live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_dhl_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">DHL live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// AUSPOST Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_auspost_shipping( ) && ec_auspost_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup Australia Post live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_auspost_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">Australia Post live shipping setup incorrectly.</span></div>
<?php } 
///////////////////////////////////////////////
// Tax Status Section
///////////////////////////////////////////////
?>

<div class="ec_status_header"><div class="ec_status_header_text">Tax Status</div></div>

<?php 
////////////////////////////
// No Tax Check
////////////////////////////
if( ec_using_no_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You are setup to use no tax structure, this can be changed in the Store Admin -> Rates -> Tax Rates panel.</span></div>
<?php }

////////////////////////////
// State Tax Check
////////////////////////////
if( ec_using_state_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured state/province taxes.</span></div>
<?php }

////////////////////////////
// Country Tax Check
////////////////////////////
if( ec_using_country_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured country taxes.</span></div>
<?php }

////////////////////////////
// Gloabl Tax Check
////////////////////////////
if( ec_using_global_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured global taxes.</span></div>
<?php }

////////////////////////////
// Duty Tax Check
////////////////////////////
if( ec_using_duty_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured customs duty or export taxes.</span></div>
<?php }

////////////////////////////
// VAT Tax Check
////////////////////////////
if( ec_using_vat_tax( ) && ec_global_vat_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured VAT.</span></div>
<?php }else if( ec_using_vat_tax( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have selected to use VAT, but have not entered a rate and/or have not set any individual country rates.</span></div>
<?php } ?>

<div class="ec_status_header"><div class="ec_status_header_text">Payment Status</div></div>
<?php
///////////////////////////////////////////////
// Payment Status Section
///////////////////////////////////////////////

////////////////////////////
// No Payment Type Selected Check
////////////////////////////
if( ec_no_payment_selected( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have not selected a payment method, the checkout process cannot be completed by your customers at this time.</span></div>
<?php } 

////////////////////////////
// Manual Payment Type Selected Check
////////////////////////////
if( ec_manual_payment_selected( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have setup your store to use manual payment. This method requires your customer to send a check or direct deposit before shipping.</span></div>
<?php } 

////////////////////////////
// Third Party Payment Type Selected Check
////////////////////////////
if( ec_third_party_payment_selected( ) && ec_third_party_payment_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have selected to use <?php echo ec_get_third_party_method( ); ?> as a third party payment method and you have entered all necessary info.</span></div>
<?php }else if( ec_third_party_payment_selected( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have selected <?php echo ec_get_third_party_method( ); ?> , but have missed some necessary info. Go to Store Setup -> Payment Setup to resolve this.</span></div>
<?php } 

////////////////////////////
// Live Payment Type Selected Check
////////////////////////////
if( ec_live_payment_selected( ) && ec_live_payment_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have selected to use <?php echo ec_get_live_payment_method( ); ?> as a live payment method and you have entered all necessary info.</span></div>
<?php }else if( ec_third_party_payment_selected( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have selected <?php echo ec_get_live_payment_method( ); ?> , but have missed some necessary info. Go to Store Setup -> Payment Setup to resolve this.</span></div>
<?php } ?>
