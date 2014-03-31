<div class="ec_cart_billing_holder">
  <div class="ec_cart_billing_title"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' )?></div>
  <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
  <div class="ec_cart_billing_row" id="ec_cart_billing_country_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "country" ); ?>
    </div>
  </div>
  <?php } ?>
  <div class="ec_cart_billing_row" id="ec_cart_billing_first_name_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_first_name' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "first_name" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_last_name_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_last_name' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "last_name" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_address_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "address" ); ?>
    </div>
  </div>
  <?php if( get_option( 'ec_option_use_address2' ) ){ ?>
  <div class="ec_cart_billing_row" id="ec_cart_billing_address_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address2' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "address2" ); ?>
    </div>
  </div>
  <?php } ?>
  <div class="ec_cart_billing_row" id="ec_cart_billing_city_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_city' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "city" ); ?>
    </div>
  </div>
  
  <div class="ec_cart_billing_row" id="ec_cart_billing_state_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_state' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "state" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row" id="ec_cart_billing_zip_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_zip' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "zip" ); ?>
    </div>
  </div>
  <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
  <div class="ec_cart_billing_row" id="ec_cart_billing_country_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "country" ); ?>
    </div>
  </div>
  <?php } ?>
  <div class="ec_cart_billing_row" id="ec_cart_billing_phone_row">
    <div class="ec_cart_billing_label"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' )?></div>
    <div class="ec_cart_billing_input">
      <?php $this->display_billing_input( "phone" ); ?>
    </div>
  </div>
  <div class="ec_cart_billing_row">
    <?php $this->display_shipping_selector( $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_ship_to_this' ), $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_ship_to_different' ) ); ?>
  </div>
</div>
