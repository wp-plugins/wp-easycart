<h3 class="ec_account_subscription_title"><?php $this->subscription->display_title( ); ?></h3>
<?php if( $this->subscription->has_membership_page( ) ){ ?><div class="ec_account_subscription_row"><?php $this->subscription->display_membership_page_link( $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_5" ) ); ?></div><?php } ?>
<?php if( !$this->subscription->is_canceled( ) ){ ?><div class="ec_account_subscription_row"><b><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_next_billing' ); ?>:</b> <?php $this->subscription->display_next_bill_date( "n/d/Y" ); ?></div><?php }?>
<div class="ec_account_subscription_row"><b><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_last_payment' ); ?>:</b> <?php $this->subscription->display_last_bill_date( "n/d/Y" ); ?></div>
<div class="ec_account_subscription_row"><?php $this->subscription->display_price( ); ?></div>
<?php if( !$this->subscription->is_canceled( ) ){ ?>
<div class="ec_account_subscription_row last_spacer"><?php $this->user->display_card_type( ); ?>: ############<?php $this->user->display_last4( ); ?> | <a href="#" onclick="return show_billing_info( );" class="ec_account_subscription_link">change billing method</a></div>

<?php $this->display_subscription_update_form_start( ); ?>
<?php if( $this->subscription->has_upgrades( ) ){ ?>
<div class="ec_account_subscription_upgrade_row"><?php $this->subscription->display_upgrade_dropdown( ); ?></div>
<?php }?>

<div id="ec_account_subscription_billing_information" class="ec_account_subscription_billing">
  
    <div class="ec_cart_subscription_holder_left">
    
        <div class="ec_cart_payment_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' )?></div>
        
        <ul class="ec_cart_error" id="ec_cart_billing_error_text">
            <li id="ec_cart_error_billing_first_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_first_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_billing_last_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_last_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_billing_address" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_address' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_billing_city" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_city' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_billing_state" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_state' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_billing_zip" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_zip_code' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_billing_country" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_country' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_billing_phone" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_billing_phone' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            
            <li id="ec_cart_error_email" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_email' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_retype_email" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_retype_email' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_email_match" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_emails_match' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_item_must_match' ); ?>.</li>
            <li id="ec_cart_error_password" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_password' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_retype_password" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_retype_password' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            <li id="ec_cart_error_password_match" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_passwords_match' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_item_must_match' ); ?>.</li>
            <li id="ec_cart_error_password_length" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_password' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_length_error' ); ?>.</li>
        </ul>
        
        <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_billing_row" id="ec_cart_billing_country_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_country_input( ); ?>
            </div>
        </div>
        <?php }?>
        <div class="ec_cart_billing_row" id="ec_cart_billing_first_name_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_first_name' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_first_name_input( ); ?>
            </div>
        </div>
        <div class="ec_cart_billing_row" id="ec_cart_billing_last_name_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_last_name' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_last_name_input( ); ?>
            </div>
        </div>
        <div class="ec_cart_billing_row" id="ec_cart_billing_address_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_address_input( ); ?>
            </div>
        </div>
        <div class="ec_cart_billing_row" id="ec_cart_billing_city_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_city' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_city_input( ); ?>
            </div>
        </div>
        <div class="ec_cart_billing_row" id="ec_cart_billing_state_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_state' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_state_input( ); ?>
            </div>
        </div>
        <div class="ec_cart_billing_row" id="ec_cart_billing_zip_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_zip' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_zip_input( ); ?>
            </div>
        </div>
        <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_billing_row" id="ec_cart_billing_country_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_country_input( ); ?>
            </div>
        </div>
        <?php }?>
        <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
        <div class="ec_cart_billing_row" id="ec_cart_billing_phone_row">
            <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' )?></div>
            <div class="ec_cart_billing_input">
              <?php $this->display_account_billing_information_phone_input( ); ?>
            </div>
        </div>
        <?php }?>
    </div>

    <div class="ec_cart_subscription_holder_right">
      
        <div class="ec_cart_payment_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_title' )?></div>
        
        <ul class="ec_cart_error" id="ec_cart_payment_error_text">
            <li id="ec_cart_error_payment_card_number" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_number' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
             
            <li id="ec_cart_error_payment_card_number_error" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_number_error' ); ?></strong>.</li>
            
            <li id="ec_cart_error_payment_card_exp_month" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_exp_month' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            
            <li id="ec_cart_error_payment_card_exp_year" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_exp_year' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
            
            <li id="ec_cart_error_payment_card_code" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_code' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        </ul>
            
        <div class="ec_inner_padding">
            <div class="ec_cart_payment_information_row" id="ec_cart_payment_type_row">
                
                <?php $this->ec_account_display_credit_card_images( ); ?>
                <?php $this->ec_account_display_card_holder_name_hidden_input(); ?>
            </div>
            <div class="ec_cart_payment_information_row">
                
                <div class="ec_cart_payment_information_row">
                    <div class="ec_cart_payment_information_credit_card_label" id="ec_card_number_row"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></div>
                    <div class="ec_cart_payment_information_security_code_label" id="ec_security_code_row"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></div>
                </div>
                
                <div class="ec_cart_payment_information_row">
                    <div class="ec_cart_payment_information_card_number_input"><?php $this->ec_display_card_number_input(); ?></div>
                    <div class="ec_cart_payment_information_security_code_input"><?php $this->ec_display_card_security_code_input(); ?></div>
                </div>
                
            </div>
            <div class="ec_cart_payment_information_row" id="ec_expiration_date_row">
                <div class="ec_cart_payment_information_exp_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></div>
                <div class="ec_cart_payment_information_exp_month_input"><?php $this->ec_display_card_expiration_month_input( "MM" ); ?></div><div class="ec_cart_payment_information_exp_year_input"><?php $this->ec_display_card_expiration_year_input( "YYYY" ); ?></div>
            </div>
        </div>
	</div>

	<div class="ec_account_subscription_details_notice"><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_notice' ); ?></div>
    
</div>

<div class="ec_account_subscription_button"><input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'save_changes_button' ); ?>" onclick="return ec_check_update_subscription_info( );" /></div>

<?php $this->display_subscription_update_form_end( ); ?>

<?php }?>
<h3><?php echo $GLOBALS['language']->get_text( 'account_subscriptions', 'subscription_details_past_payments' ); ?></h3>
<div class="ec_account_subscriptions_past_payments"><?php $this->subscription->display_past_payments( 'M d, Y g:i A' ); ?></div>

<?php if( !$this->subscription->is_canceled( ) ){ ?>
<hr />
<div  class="ec_account_subscription_button"><?php $this->subscription->display_cancel_form( $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_button' ), $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_confirm_text' ) ); ?></div>
<?php } ?>