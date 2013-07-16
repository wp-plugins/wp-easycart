<div id="ec_account_password">
  <div class="ec_account_password_main_title"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_title' )?></div>
  <div class="ec_account_password_main_sub_title"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_sub_title' )?></div>
  <div class="ec_account_password_holder">
    <?php $this->display_account_password_form_start( ); ?>
    <div class="ec_account_password_row" id="ec_account_password_current_password_row">
      <div class="ec_account_password_label"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_current_password' )?></div>
      <div class="ec_account_password_input">
        <?php $this->display_account_password_current_password(); ?>
      </div>
      <div class="ec_account_password_error_text">Passwords should be 6 or more characters.</div>
    </div>
    <div class="ec_account_password_row" id="ec_account_password_new_password_row">
      <div class="ec_account_password_label"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_new_password' )?></div>
      <div class="ec_account_password_input">
        <?php $this->display_account_password_new_password(); ?>
      </div>
      <div class="ec_account_password_error_text">Passwords should be 6 or more characters.</div>
    </div>
    <div class="ec_account_password_row" id="ec_account_password_retype_new_password_row">
      <div class="ec_account_password_label"><?php echo $GLOBALS['language']->get_text( 'account_password', 'account_password_retype_new_password' )?></div>
      <div class="ec_account_password_input">
        <?php $this->display_account_password_retype_new_password(); ?>
      </div>
      <div class="ec_account_password_error_text">Passwords do not match.</div>
    </div>
    <div class="ec_account_password_row">
      <div class="ec_account_password_label">&nbsp;&nbsp;&nbsp;</div>
      <div class="ec_account_password_input">
        <?php $this->display_account_password_update_button( $GLOBALS['language']->get_text( 'account_password', 'account_password_update_button' ) ); ?>
        <?php $this->display_account_password_cancel_link( $GLOBALS['language']->get_text( 'account_password', 'account_password_cancel_button' ) ); ?>
      </div>
    </div>
    <?php $this->display_account_password_form_end( ); ?>
  </div>
</div>
