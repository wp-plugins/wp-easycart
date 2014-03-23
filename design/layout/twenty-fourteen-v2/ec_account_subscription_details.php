
<h3><?php $this->subscription->display_title( ); ?></h3>
<?php if( $this->subscription->has_membership_page( ) ){ ?><div><?php $this->subscription->display_membership_page_link( $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_5" ) ); ?></div><?php } ?>
<?php if( !$this->subscription->is_canceled( ) ){ ?><div><b>Next Billing Date:</b> <?php $this->subscription->display_next_bill_date( "n/d/Y" ); ?></div><?php }?>
<div><b>Last Payment Date:</b> <?php $this->subscription->display_last_bill_date( "n/d/Y" ); ?></div>
<div><?php $this->subscription->display_price( ); ?></div>

<hr />
<?php if( !$this->subscription->is_canceled( ) ){ ?>
<h3>Current Billing Method</h3>
<?php $this->display_subscription_update_form_start( ); ?>

<div><?php $this->user->display_card_type( ); ?>: ############<?php $this->user->display_last4( ); ?> | <a href="#" onclick="return show_billing_info( );">change billing method</a></div>
<?php if( $this->subscription->has_upgrades( ) ){ ?>
<div class="ec_account_subscription_upgrade_row"><?php $this->subscription->display_upgrade_dropdown( ); ?></div>
<?php }?>

<hr />

<div id="ec_account_subscription_billing_information" class="ec_account_subscription_billing">
  <div class="ec_account_billing_information_title"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_title' )?></div>
  <div class="ec_account_billing_information_holder">
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_first_name_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_first_name' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_first_name_input(); ?>
      </div>
    </div>
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_last_name_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_last_name' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_last_name_input(); ?>
      </div>
    </div>
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_address_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_address' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_address_input(); ?>
      </div>
    </div>
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_city_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_city' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_city_input(); ?>
      </div>
    </div>
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_state_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_state' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_state_input(); ?>
      </div>
    </div>
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_zip_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_zip' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_zip_input(); ?>
      </div>
    </div>
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_country_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_country' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_country_input(); ?>
      </div>
    </div>
    <div class="ec_account_billing_information_row" id="ec_account_billing_information_phone_row">
      <div class="ec_account_billing_information_label"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_phone' )?></div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_phone_input(); ?>
      </div>
    </div>
  </div>
</div>

<div id="ec_account_subscription_payment" class="ec_account_subscription_payment">
  	<div class="ec_account_billing_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_title' )?></div>
  	<div>
        <div class="ec_cart_payment_information_row" id="ec_cart_payment_type_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_credit_card' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_display_payment_method_input( "Select One" ); ?></div>
            
        </div>
        <div class="ec_cart_payment_information_row" id="ec_card_holder_name_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_holder_name' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_display_card_holder_name_input(); ?></div>
        </div>
        <div class="ec_cart_payment_information_row" id="ec_card_number_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_display_card_number_input(); ?></div>
        </div>
        <div class="ec_cart_payment_information_row" id="ec_expiration_date_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_display_card_expiration_month_input( "MM" ); ?><?php $this->ec_display_card_expiration_year_input( "YYYY" ); ?></div>
        </div>
        <div class="ec_cart_payment_information_row" id="ec_security_code_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_display_card_security_code_input(); ?></div>
        </div>
    </div>
</div>


<div>*NOTICE: any changes to the billing method or subscription plan will take effect in the next billing cycle. Pricing changes will be prorated beginning immediately and will be reflected on your next bill.</div>

<div class="ec_account_subscription_button"><input type="submit" value="Save Changes" /></div>

<?php $this->display_subscription_update_form_end( ); ?>

<hr />
<?php }?>
<h3>Past Payments</h3>
<?php $this->subscription->display_past_payments( 'M d, Y g:i A' ); ?>

<?php if( !$this->subscription->is_canceled( ) ){ ?>
<hr />
<div  class="ec_account_subscription_button"><?php $this->subscription->display_cancel_form( $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_button' ), $GLOBALS['language']->get_text( 'account_subscriptions', 'cancel_subscription_confirm_text' ) ); ?></div>
<?php } ?>