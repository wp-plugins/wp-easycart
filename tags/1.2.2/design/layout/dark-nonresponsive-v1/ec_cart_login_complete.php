<div id="ec_cart_login_complete" <?php if( $_SESSION['ec_username'] ){ echo "class=\"ec_cart_login_complete\""; }else{ echo "class=\"ec_cart_login_complete_hidden\""; } ?> >
    <div class="ec_cart_login_complete_title"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_title' )?></div>
    <div class="ec_cart_login_complete_subtitle"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text' )?><?php $this->display_cart_login_complete_user_name( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_a_guest_text' ) ); //If user is not logged in we will display input text provided ?><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text2' )?> <?php $this->display_cart_login_complete_signout_link( $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_logout_link' ) ); ?>.</div>
</div>