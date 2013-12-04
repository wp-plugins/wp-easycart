<div id="ec_account_forgot_password">
  <div class="ec_account_forgot_password_title"><?php echo $GLOBALS['language']->get_text( 'account_forgot_password', 'account_forgot_password_title' )?></div>
  <div class="ec_account_forgot_password_holder">
    <?php $this->display_account_forgot_password_form_start( ); ?>
    <div class="ec_account_forgot_password_row" id="ec_account_forgot_password_email_row">
      <div class="ec_account_forgot_password_label"><?php echo $GLOBALS['language']->get_text( 'account_forgot_password', 'account_forgot_password_email_label' )?></div>
      <div class="ec_account_forgot_password_input">
        <?php $this->display_account_forgot_password_email_input( ); ?>
      </div>
    </div>
    <div class="ec_account_forgot_password_row">
      <div class="ec_account_forgot_password_label">&nbsp;&nbsp;&nbsp;</div>
      <div class="ec_account_forgot_password_input">
        <?php $this->display_account_forgot_password_submit_button( $GLOBALS['language']->get_text( 'account_forgot_password', 'account_forgot_password_button' ) ); ?>
      </div>
    </div>
    <?php $this->display_account_forgot_password_form_end( ); ?>
  </div>
</div>
