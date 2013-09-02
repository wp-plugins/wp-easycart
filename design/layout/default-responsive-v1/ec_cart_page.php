<?php $this->display_cart_success( ); ?>
<?php $this->display_cart_error( ); ?>
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
        <?php $this->display_page_three_form_start(); ?>
        <?php $this->display_address_review(); ?>
        <?php $this->display_payment_information(); ?>
        <?php $this->display_customer_order_notes(); ?>
        <div class="ec_cart_submit_order_message"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?></div>
        <div class="ec_cart_page_submit_order_button"><?php $this->display_submit_order_button( $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' ) ); ?></div>
        
    <?php $this->display_page_three_form_end(); ?>
    <?php } // END CHECKOUT_PAYMENT PAGE ?>
<?php }?>