<?php $this->display_cart_success( ); ?>
<?php $this->display_cart_error( ); ?>
<?php $this->display_cart_process( ); ?>
<?php /* Cart page shows specific elements based on the checkout page being viewed */ ?>
<div class="ec_cart_page_cart"><?php $this->display_cart(  $GLOBALS['language']->get_text( 'cart', 'cart_empty_cart' ) ); ?></div>

<?php 
/* 
	Login page shows only when NOT logged in AND cart_page == checkout_login,
	Login complete page shows only when LOGGED IN and cart_page == checkout_info
*/ 
?>
<?php 
if( $this->should_display_login( ) ){ 
	$this->display_login(); 
}
?>

<?php if( $this->cart->total_items > 0 ){ ?>

	<?php /* Account Information page shows only when NOT logged in AND  cart_page  == checkout_login */ ?>
    <?php 
    if( $this->should_display_page_one( ) ){ ?>
        <?php $this->display_login_complete(); ?>
        
        <div id="ec_cart_error_scroll"></div>
        <ul class="ec_cart_error" id="ec_cart_error_text">
        	<li id="ec_cart_error_billing_first_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_first_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_billing_last_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_last_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_billing_address" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_address' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_billing_city" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_city' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_billing_state" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_state' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_billing_zip" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_zip_code' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_billing_country" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_country' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_billing_phone" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_phone' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	
            
            <li id="ec_cart_error_shipping_first_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_first_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_shipping_last_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_last_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_shipping_address" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_address' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_shipping_city" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_city' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_shipping_state" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_state' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_shipping_zip" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_zip_code' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_shipping_country" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_country' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_shipping_phone" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_shipping_phone' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            
            
        	<li id="ec_cart_error_contact_first_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_contact_first_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_contact_last_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_contact_last_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_email" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_email' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_retype_email" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_retype_email' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_email_match" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_emails_match' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_item_must_match' ); ?>.</li>
        	<li id="ec_cart_error_password" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_password' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_retype_password" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_retype_password' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        	<li id="ec_cart_error_password_match" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_passwords_match' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_item_must_match' ); ?>.</li>
            <li id="ec_cart_error_password_length" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_password' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_length_error' ); ?>.</li>
        </ul>
        
        <?php $this->display_page_one_form_start(); ?>
            <div class="ec_cart_page_left">
                <?php $this->display_billing(); ?>
            </div>
            <div class="ec_cart_page_right">
                <?php $this->display_shipping(); ?>
            </div>
            <?php $this->display_contact_information(); ?>
            <div class="ec_cart_page_continue_to_shipping_button"><?php $this->display_continue_to_shipping_button( $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_continue_button' ) ); ?></div>
        <?php $this->display_page_one_form_end(); ?>
    
    <?php } // END CHECKOUT_INFO PAGE ?>
    
    <?php if( $this->should_display_page_two( ) ){ ?>
        
        <?php $this->display_page_two_form_start(); ?>
            <?php $this->display_shipping_method(); ?>
            <div class="ec_cart_page_continue_to_payment_button"><?php $this->display_continue_to_payment_button( $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_continue_button' )); ?></div>
        <?php $this->display_page_two_form_end(); ?>
    
    <?php } // END CHECKOUT_SHIPPING PAGE ?>
    
    <?php if( $this->should_display_page_three( ) ){ ?>
        <?php $this->display_address_review(); ?>
        <?php if( get_option( 'ec_option_skip_shipping_page' ) ){ ?>
        <?php $this->display_page_two_form_start(); ?>
            <?php if( $this->shipping->shipping_method == "live" && $this->cart->weight > 0 ){ 
			$this->display_shipping_method( ); ?>
            <div class="ec_cart_page_continue_to_payment_button"><?php $this->display_continue_to_payment_button( 'Update Totals' ); ?></div>
			<hr />
            <?php }else{ ?>
            <div class="ec_cart_page_no_shipping_buffer"></div>
            <?php }?>
        <?php $this->display_page_two_form_end(); ?>
        <?php }else{ ?>
            <div class="ec_cart_page_no_shipping_buffer"></div>
        <?php }?>
		<?php $this->display_page_three_form_start(); ?>
        <?php $this->display_payment_information(); ?>
        <?php $this->display_customer_order_notes(); ?>
        <div class="ec_cart_checkout_review_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_review_checkout_text' ); ?></div>
        <?php $this->display_order_review_button( $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_review_order_button' ) ); ?>
        <?php $this->display_order_finalize_panel( ); ?>
    <?php $this->display_page_three_form_end(); ?>
    <?php } // END CHECKOUT_PAYMENT PAGE ?>
<?php }?>