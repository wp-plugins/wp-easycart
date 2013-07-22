<div id="ec_account_billing_information">
  <div class="ec_account_billing_information_title"><?php echo $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_title' )?></div>
  <div class="ec_account_billing_information_holder">
    <?php $this->display_account_billing_information_form_start(); ?>
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
    <div class="ec_account_billing_information_row">
      <div class="ec_account_billing_information_label">&nbsp;&nbsp;&nbsp;</div>
      <div class="ec_account_billing_information_input">
        <?php $this->display_account_billing_information_update_button(  $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_update_button' ) ); ?>
        <?php $this->display_account_billing_information_cancel_link( $GLOBALS['language']->get_text( 'account_billing_information', 'account_billing_information_cancel' ) ); ?>
      </div>
    </div>
    <?php $this->display_account_billing_information_form_end(); ?>
  </div>
</div>
