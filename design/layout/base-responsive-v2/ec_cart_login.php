<div id="ec_cart_login">
  <div class="ec_cart_login_holder">
    <?php $this->display_cart_login_form_start(); ?>
    <div class="ec_cart_login_left">
      <div class="ec_cart_header_left">
        <div class="ec_cart_login_title"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_title' )?></div>
        <div class="ec_cart_login_subtitle"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_sub_title' )?></div>
      </div>
      <div class="ec_cart_login_row">
        <div class="ec_cart_login_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_email_label' )?></div>
        <div class="ec_cart_login_row_input">
          <?php $this->display_cart_login_email_input(); ?>
        </div>
      </div>
      <div class="ec_cart_login_row">
        <div class="ec_cart_login_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_password_label' )?></div>
        <div class="ec_cart_login_row_input">
          <?php $this->display_cart_login_password_input(); ?>
        </div>
      </div>
      <div class="ec_cart_login_row">
        <div class="ec_cart_login_row_input">
          <?php $this->display_cart_login_login_button( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_button' ) ); ?>
        </div>
      </div>
      <div class="ec_cart_login_row">
        <div class="ec_cart_login_row_input">
          <?php $this->display_cart_login_forgot_password_link( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_forgot_password_link' ) ); ?>
        </div>
      </div>
    </div>
    <?php $this->display_cart_login_form_end(); ?>
    <?php $this->display_cart_login_form_guest_start(); ?>
    <div class="ec_cart_login_right">
      <div class="ec_cart_header_right">
        <div class="ec_cart_login_title"><?php echo $GLOBALS['language']->get_text( 'cart_guest_checkout', 'cart_guest_title' )?></div>
        <div class="ec_cart_login_subtitle"><?php echo $GLOBALS['language']->get_text( 'cart_guest_checkout', 'cart_guest_sub_title' )?></div>
      </div>
      <div class="ec_cart_login_row"><?php echo $GLOBALS['language']->get_text( 'cart_guest_checkout', 'cart_guest_message' )?></div>
      <div class="ec_cart_login_row">
        <?php $this->display_cart_login_guest_button( $GLOBALS['language']->get_text( 'cart_guest_checkout', 'cart_guest_button' ) ); ?>
      </div>
    </div>
    <?php $this->display_cart_login_form_guest_end(); ?>
  </div>
</div>
