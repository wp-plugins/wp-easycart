<div id="ec_account_personal_information">
  <div class="ec_account_personal_information_main_title"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_title' )?></div>
  <div class="ec_account_personal_information_main_sub_title"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_title' )?></div>
  <div class="ec_account_personal_information_holder">
    <?php $this->display_account_personal_information_form_start( ); ?>
    <div class="ec_account_personal_information_row" id="ec_account_personal_information_first_name_row">
      <div class="ec_account_personal_information_label"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_first_name' )?></div>
      <div class="ec_account_personal_information_input">
        <?php $this->display_account_personal_information_first_name_input(); ?>
      </div>
    </div>
    <div class="ec_account_personal_information_row" id="ec_account_personal_information_last_name_row">
      <div class="ec_account_personal_information_label"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_last_name' )?></div>
      <div class="ec_account_personal_information_input">
        <?php $this->display_account_personal_information_last_name_input(); ?>
      </div>
    </div>
    <div class="ec_account_personal_information_row" id="ec_account_personal_information_email_row">
      <div class="ec_account_personal_information_label"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_email' )?></div>
      <div class="ec_account_personal_information_input">
        <?php $this->display_account_personal_information_email_input(); ?>
      </div>
    </div>
    <div class="ec_account_personal_information_row" id="ec_account_personal_information_is_subscriber_row">
      <div class="ec_account_personal_information_label">&nbsp;&nbsp;&nbsp;</div>
      <div class="ec_account_personal_information_input">
        <?php $this->display_account_personal_information_is_subscriber_input(); ?>
        <?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_subscribe' )?></div>
    </div>
    <div class="ec_account_personal_information_row">
      <div class="ec_account_personal_information_label">&nbsp;&nbsp;&nbsp;</div>
      <div class="ec_account_personal_information_input">
        <?php $this->display_account_personal_information_update_button( $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_update_button' ) ); ?>
        <?php $this->display_account_personal_information_cancel_link( $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_cancel_link' ) ); ?>
      </div>
    </div>
    <?php $this->display_account_personal_information_form_end( ); ?>
  </div>
</div>
