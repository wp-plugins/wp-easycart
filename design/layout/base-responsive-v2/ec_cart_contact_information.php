<?php if( isset( $_SESSION['ec_email'] ) && $_SESSION['ec_email'] == "guest" ){ ?>
<div class="ec_cart_contact_information_holder">
  <div class="ec_cart_contact_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_title' )?></div>
  
  <?php if( get_option( 'ec_option_use_contact_name' ) ){ ?>
  <div class="ec_cart_contact_information_row" id="ec_contact_first_name_row">
    <div class="ec_cart_contact_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_first_name' )?></div>
    <div class="ec_cart_contact_information_input">
      <?php $this->ec_cart_display_contact_first_name_input(); ?>
    </div>
  </div>
  <div class="ec_cart_contact_information_row" id="ec_contact_last_name_row">
    <div class="ec_cart_contact_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_last_name' )?></div>
    <div class="ec_cart_contact_information_input">
      <?php $this->ec_cart_display_contact_last_name_input(); ?>
    </div>
  </div>
  
  <?php } ?>
  
  <?php if( $this->user->is_guest( ) ){ ?>
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
  <div class="ec_cart_contact_information_row" id="ec_contact_email_row">
    <div class="ec_cart_contact_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_create_account' )?></div>
    <div class="ec_cart_contact_information_input">
      <?php $this->ec_cart_display_contact_create_account_box(); ?>
    </div>
  </div>
  <div id="ec_cart_password_input">
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
    <div class="ec_cart_contact_information_row" id="ec_contact_is_subscriber">
      <div class="ec_cart_contact_information_label">&nbsp;&nbsp;&nbsp;</div>
      <div class="ec_cart_contact_information_input">
        <?php $this->ec_cart_display_contact_is_subscriber_input(); ?>
        <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_subscribe' )?></div>
    </div>
  </div>
  <script>
		if( !document.getElementById('ec_contact_create_account').checked ){
			jQuery("#ec_cart_password_input").hide();
		}
	</script>
  <?php }?>
</div>
<?php } ?>