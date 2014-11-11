<div id="ec_account_personal_information">
    
	<div class="ec_account_left">

    	<?php $this->display_account_personal_information_form_start( ); ?>

  		<div class="ec_cart_header ec_top"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_title' )?></div>

		<div class="ec_cart_input_row">
            
            <label for="ec_account_personal_information_first_name"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_first_name' )?></label>

			<?php $this->display_account_personal_information_first_name_input(); ?>
			
            <div class="ec_cart_error_row" id="ec_account_personal_information_first_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_first_name' ); ?>
            </div>

		</div>

		<div class="ec_cart_input_row">
        
			<label for="ec_account_personal_information_last_name"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_last_name' )?></label>

			<?php $this->display_account_personal_information_last_name_input(); ?>

			<div class="ec_cart_error_row" id="ec_account_personal_information_last_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_last_name' ); ?>
            </div>

		</div>

		<div class="ec_cart_input_row">

			<label for="ec_account_personal_information_email"><?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_email' )?></label>

			<?php $this->display_account_personal_information_email_input(); ?>

			<div class="ec_cart_error_row" id="ec_account_personal_information_email_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_email' ); ?>
            </div>

		</div>
        
        <div class="ec_cart_input_row">
        
			<?php $this->display_account_personal_information_is_subscriber_input(); ?> <?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_subscribe' )?>
		
        </div>

		<div class="ec_cart_button_row">
        	<input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_update_button' ); ?>" class="ec_cart_button" onclick="return ec_account_personal_information_update_click( );" />
		</div>

		<div class="ec_cart_button_row">
        	<?php $this->display_account_personal_information_cancel_link( $GLOBALS['language']->get_text( 'account_personal_information', 'account_personal_information_cancel_link' ) ); ?>
		</div>

		<?php $this->display_account_personal_information_form_end( ); ?>

	</div>
    
    <div class="ec_account_right">
    	
        <div class="ec_cart_header ec_top"><?php echo $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_title' )?></div>
        
        <div class="ec_cart_input_row">

			<?php $this->display_billing_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_billing_information' ) ); ?>

		</div>

        <div class="ec_cart_input_row">

			<?php $this->display_shipping_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_shipping_information' ) ); ?>

		</div>

        <div class="ec_cart_input_row">

			<?php $this->display_personal_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_basic_inforamtion' ) ); ?>

		</div>

       <div class="ec_cart_input_row">

          <?php $this->display_password_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_password' ) ); ?>

        </div>

		<?php if( $this->using_subscriptions( ) ){ ?>

        <div class="ec_cart_input_row">

          <?php $this->display_subscriptions_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_subscriptions' )); ?>

        </div>

        <?php }?>

        <div class="ec_cart_input_row">

          <?php $this->display_logout_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_sign_out' )); ?>

        </div>
        
    </div>

</div>


