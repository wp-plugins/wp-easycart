<div id="ec_account_login">
  <div class="ec_account_login_holder">
    <?php $this->display_account_login_form_start(); ?>
    <div class="ec_account_login_left">
      <div class="ec_account_header_left">
        <div class="ec_account_login_title"><?php echo $GLOBALS['language']->get_text( 'account_login', 'account_login_title' )?></div>
        <div class="ec_account_login_subtitle"><?php echo $GLOBALS['language']->get_text( 'account_login', 'account_login_sub_title' )?></div>
      </div>
      <div class="ec_account_login_row" id="ec_account_login_email_row">
        <div class="ec_account_login_row_label"><?php echo $GLOBALS['language']->get_text( 'account_login', 'account_login_email_label' )?></div>
        <div class="ec_account_login_row_input">
          <?php $this->display_account_login_email_input(); ?>
        </div>
      </div>
      <div class="ec_account_login_row" id="ec_account_login_password_row">
        <div class="ec_account_login_row_label"><?php echo $GLOBALS['language']->get_text( 'account_login', 'account_login_password_label' )?></div>
        <div class="ec_account_login_row_input">
          <?php $this->display_account_login_password_input(); ?>
        </div>
      </div>
      <div class="ec_account_login_row">
        <div class="ec_account_login_row_label">&nbsp;&nbsp;&nbsp;</div>
        <div class="ec_account_login_row_input">
          <?php $this->display_account_login_button($GLOBALS['language']->get_text( 'account_login', 'account_login_button' )); ?>
        </div>
      </div>
      <div class="ec_account_login_row">
        <div class="ec_account_login_row_label">&nbsp;&nbsp;&nbsp;</div>
        <div class="ec_account_login_row_input">
          <?php $this->display_account_login_forgot_password_link( $GLOBALS['language']->get_text( 'account_login', 'account_login_forgot_password_link' ) ); ?>
        </div>
      </div>
    </div>
    <?php $this->display_account_login_form_end(); ?>
    <div class="ec_account_login_right">
      <div class="ec_account_header_right">
        <div class="ec_account_login_title"><?php echo $GLOBALS['language']->get_text( 'account_login', 'account_new_user_title' )?></div>
        <div class="ec_account_login_subtitle"><?php echo $GLOBALS['language']->get_text( 'account_login', 'account_new_user_sub_title' )?></div>
      </div>
      <div class="ec_account_login_row"><?php echo $GLOBALS['language']->get_text( 'account_login', 'account_new_user_message' )?></div>
      <div class="ec_account_login_row_extra_margin">
        <?php $this->display_account_login_create_account_button( $GLOBALS['language']->get_text( 'account_login', 'account_new_user_button' ) ); ?>
      </div>
    </div>
  </div>
</div>
