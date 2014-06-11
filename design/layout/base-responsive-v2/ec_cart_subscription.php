<?php $this->display_subscription_form_start( $product->model_number ); ?>
<h3><?php echo $product->title; ?></h3>
<p><?php echo $product->description; ?></p>
<p><?php echo $product->get_price_formatted( ); ?></p>

<hr>
<?php $this->display_subscription_login_complete(); ?>
<hr>

<?php if( get_option( 'ec_option_show_coupons' ) ){ ?>
<div class="ec_cart_billing_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_apply_coupon' ); ?></div>
    <div class="ec_cart_billing_input">
      <div class="ec_cart_coupon_row">
		  <?php $this->display_coupon_input( $GLOBALS['language']->get_text( 'cart_coupons', 'cart_apply_coupon' ) ); ?>
          <?php $this->display_coupon_loader(); ?>
        </div>
        <div class="ec_cart_coupon_row_message" id="ec_cart_coupon_row_message">
          <?php $this->display_coupon_message( ); ?>
        </div>
    </div>
</div>
<?php }?>

<div class="ec_cart_subscription_holder_left">
  <div class="ec_cart_billing_title"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' )?></div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_first_name_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_first_name' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "first_name" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_last_name_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_last_name' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "last_name" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_address_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "address" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_city_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_city' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "city" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_state_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_state' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "state" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_zip_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_zip' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "zip" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_country_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "country" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_phone_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "phone" ); ?>
    </div>
  </div>
</div>

<div class="ec_cart_subscription_holder_right" style="display:block;">
  <div class="ec_cart_billing_title">Payment Information</div>
  	<div>
        <div class="ec_cart_payment_information_row" id="ec_cart_payment_type_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_credit_card' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_payment_method_input( "Select One" ); ?></div>
            
        </div>
        <div class="ec_cart_payment_information_row" id="ec_card_holder_name_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_holder_name' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_card_holder_name_input(); ?></div>
        </div>
        <div class="ec_cart_payment_information_row" id="ec_card_number_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_card_number_input(); ?></div>
        </div>
        <div class="ec_cart_payment_information_row" id="ec_expiration_date_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_card_expiration_month_input( "MM" ); ?><?php $this->ec_cart_display_card_expiration_year_input( "YYYY" ); ?></div>
        </div>
        <div class="ec_cart_payment_information_row" id="ec_security_code_row">
            <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></div>
            <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_card_security_code_input(); ?></div>
        </div>
    </div>
</div>

<?php if( isset( $_SESSION['ec_email'] ) && $_SESSION['ec_email'] == "guest" ){ ?>
<div class="ec_cart_contact_information_holder">
    <div class="ec_cart_contact_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_title' )?></div>
    
    <div class="ec_cart_contact_information_row" id="ec_contact_email_row">
    <div class="ec_cart_contact_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' )?></div>
    <div class="ec_cart_contact_information_input">
		<?php $this->ec_cart_display_contact_email_input(); ?>
    </div>
    </div>
    <div class="ec_cart_contact_information_row" id="ec_contact_email_retype_row">
    <div class="ec_cart_contact_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_email' )?></div>
    <div class="ec_cart_contact_information_input">
		<?php $this->ec_cart_display_contact_email_retype_input(); ?>
    </div>
    </div>
    <div class="ec_cart_contact_information_row" id="ec_contact_password_row">
        <div class="ec_cart_contact_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_password' )?></div>
        <div class="ec_cart_contact_information_input">
	        <?php $this->ec_cart_display_contact_password_input(); ?>
        </div>
    </div>
    <div class="ec_cart_contact_information_row" id="ec_contact_password_retype_row">
        <div class="ec_cart_contact_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_password' )?></div>
        <div class="ec_cart_contact_information_input">
	        <?php $this->ec_cart_display_contact_password_retype_input(); ?>
        </div>
    </div>
    
</div>
<?php }?>

<div class="ec_cart_submit_order_message"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?></div>
<div class="ec_cart_page_submit_order_button"><?php $this->display_submit_order_button( $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' ) ); ?></div>
<?php $this->display_subscription_form_end(); ?>