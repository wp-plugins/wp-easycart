<div id="ec_account_shipping_information">

  <div class="ec_account_shipping_information_title"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_title' )?></div>

  <div class="ec_account_shipping_information_holder">

    <?php $this->display_account_shipping_information_form_start(); ?>

    <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_country_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_country' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_country_input(); ?>

      </div>

    </div>

    <?php } ?>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_first_name_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_first_name' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_first_name_input(); ?>

      </div>

    </div>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_last_name_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_last_name' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_last_name_input(); ?>

      </div>

    </div>

	<?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
    
    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_company_name_row">
	
    	<div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_company_name' ); ?></div>
	
    	<div class="ec_account_shipping_information_input">
	
    	<input type="text" name="ec_account_shipping_information_company_name" id="ec_account_shipping_information_company_name" class="ec_account_shipping_information_input_field" value="<?php echo $this->user->shipping->company_name; ?>">
	
    	</div>
	
    </div>
	
	<?php } ?>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_address_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_address' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_address_input(); ?>

      </div>

    </div>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_address2_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_address2' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_address2_input(); ?>

      </div>

    </div>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_city_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_city' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_city_input(); ?>

      </div>

    </div>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_state_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_state' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_state_input(); ?>

      </div>

    </div>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_zip_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_zip' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_zip_input(); ?>

      </div>

    </div>

    <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_country_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_country' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_country_input(); ?>

      </div>

    </div>

    <?php } ?>

    <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>

    <div class="ec_account_shipping_information_row" id="ec_account_shipping_information_phone_row">

      <div class="ec_account_shipping_information_label"><?php echo $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_phone' )?></div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_phone_input(); ?>

      </div>

    </div>

    <?php }?>

    <div class="ec_account_shipping_information_row">

      <div class="ec_account_shipping_information_label">&nbsp;&nbsp;&nbsp;</div>

      <div class="ec_account_shipping_information_input">

        <?php $this->display_account_shipping_information_update_button( $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_update_button' ) ); ?>

        <?php $this->display_account_shipping_information_cancel_link( $GLOBALS['language']->get_text( 'account_shipping_information', 'account_shipping_information_cancel' ) ); ?>

      </div>

    </div>

    <?php $this->display_account_shipping_information_form_end(); ?>

  </div>

</div>

