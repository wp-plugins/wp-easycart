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
<?php $this->display_subscription_form_start( $product->model_number ); ?>
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
          <?php $this->display_billing_input( "country" ); ?>
        </div>
    </div>
    <?php }?>
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
    <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
    <div class="ec_cart_billing_row" id="ec_cart_billing_country_row">
        <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' )?></div>
        <div class="ec_cart_billing_input">
          <?php $this->display_billing_input( "country" ); ?>
        </div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
    <div class="ec_cart_billing_row" id="ec_cart_billing_phone_row">
        <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' )?></div>
        <div class="ec_cart_billing_input">
          <?php $this->display_billing_input( "phone" ); ?>
        </div>
    </div>
    <?php }?>
    <?php if( !isset( $_SESSION['ec_email'] ) || $_SESSION['ec_email'] == "guest" || $_SESSION['ec_email'] == "" ){ ?>
    </div>
    <div class="ec_cart_subscription_holder_middle">
    
    <div class="ec_cart_payment_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_title' )?></div>
    <div class="ec_cart_billing_row" id="ec_contact_email_row">
        <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' )?></div>
        <div class="ec_cart_billing_input">
			<?php $this->ec_cart_display_contact_email_input(); ?>
        </div>
    </div>
    <div class="ec_cart_billing_row" id="ec_contact_email_retype_row">
        <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_email' )?></div>
        <div class="ec_cart_billing_input">
			<?php $this->ec_cart_display_contact_email_retype_input(); ?>
        </div>
    </div>
    <div class="ec_cart_billing_row" id="ec_contact_password_row">
        <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_password' )?></div>
        <div class="ec_cart_billing_input">
        	<?php $this->ec_cart_display_contact_password_input(); ?>
        </div>
    </div>
    <div class="ec_cart_billing_row" id="ec_contact_password_retype_row">
        <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_password' )?></div>
        <div class="ec_cart_billing_input">
        	<?php $this->ec_cart_display_contact_password_retype_input(); ?>
      	</div>
    </div>
    <?php }?>
</div>

<div class="ec_cart_subscription_holder_right" style="display:block;">
  
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
            
            <?php $this->ec_cart_display_credit_card_images( ); ?>
            <?php $this->ec_cart_display_card_holder_name_hidden_input(); ?>
        </div>
        <div class="ec_cart_payment_information_row">
            
            <div class="ec_cart_payment_information_row">
                <div class="ec_cart_payment_information_credit_card_label" id="ec_card_number_row"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></div>
                <div class="ec_cart_payment_information_security_code_label" id="ec_security_code_row"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></div>
            </div>
            
            <div class="ec_cart_payment_information_row">
                <div class="ec_cart_payment_information_card_number_input"><?php $this->ec_cart_display_card_number_input(); ?></div>
                <div class="ec_cart_payment_information_security_code_input"><?php $this->ec_cart_display_card_security_code_input(); ?></div>
            </div>
            
        </div>
        <div class="ec_cart_payment_information_row" id="ec_expiration_date_row">
            <div class="ec_cart_payment_information_exp_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></div>
            <div class="ec_cart_payment_information_exp_month_input"><?php $this->ec_cart_display_card_expiration_month_input( "MM" ); ?></div><div class="ec_cart_payment_information_exp_year_input"><?php $this->ec_cart_display_card_expiration_year_input( "YYYY" ); ?></div>
        </div>
    </div>
</div>

<div class="ec_cart_submit_order_message"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?></div>
<div class="ec_cart_page_submit_order_button"><?php $this->display_submit_order_button( $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' ) ); ?></div>
<?php $this->display_subscription_form_end(); ?>