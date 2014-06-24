<div id="ec_cart_login_complete" class="ec_cart_login_complete">
    <div class="ec_cart_alt_complete">
		<div class="ec_cart_alt_complete_padding">
		<?php 
	if( !isset( $_SESSION['ec_email'] ) || $_SESSION['ec_email'] == "guest" || $_SESSION['ec_email'] == "" ){
		echo "<strong>Returning Customer?</strong> <a href=\"\" onclick=\"return ec_open_login_click( );\" class=\"ec_cart_alt_login_link\">Click here to log in</a>";
	}else{
		echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text' ) . " ";
		$this->display_cart_login_complete_user_name( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_a_guest_text' ) );
		echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text2' ) . " ";
		$this->display_cart_login_complete_signout_link( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_logout_link' ) );
		echo ".";
	}?>
    	</div>
    </div>
    
    <div id="ec_alt_login" style="display:none;">
    	<div class="ec_cart_login_holder">
			<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "subscription_info" ){ $this->display_cart_login_form_start_subscription(); }else{ $this->display_cart_login_form_start(); } ?>
             <div class="ec_cart_header_left">
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
                <div class="ec_cart_login_row_label">&nbsp;&nbsp;&nbsp;</div>
                <div class="ec_cart_login_row_input">
                  <?php $this->display_cart_login_login_button( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_button' ) ); ?>
                </div>
              </div>
              <div class="ec_cart_login_row">
                <div class="ec_cart_login_row_label">&nbsp;&nbsp;&nbsp;</div>
                <div class="ec_cart_login_row_input">
                  <?php $this->display_cart_login_forgot_password_link( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_forgot_password_link' ) ); ?>
                </div>
              </div>
            <?php $this->display_cart_login_form_end(); ?>
            <?php $this->display_cart_login_form_guest_start(); ?>
    	</div>
    </div>
</div>