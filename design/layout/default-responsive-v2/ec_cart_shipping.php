<div class="ec_cart_shipping_holder">
  <div class="ec_cart_shipping_title"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_title' )?></div>
  <div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_first_name_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_first_name' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "first_name" ); ?>
      </div>
    </div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_last_name_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_last_name' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "last_name" ); ?>
      </div>
    </div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_address_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_address' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "address" ); ?>
      </div>
    </div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_city_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_city' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "city" ); ?>
      </div>
    </div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_state_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_state' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "state" ); ?>
      </div>
    </div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_zip_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_zip' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "zip" ); ?>
      </div>
    </div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_country_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "country" ); ?>
      </div>
    </div>
    <div class="ec_cart_shipping_row" id="ec_cart_shipping_phone_row">
      <div class="ec_cart_shipping_label"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_phone' )?></div>
      <div class="ec_cart_shipping_input">
        <?php $this->display_shipping_input( "phone" ); ?>
      </div>
    </div>
  </div>
</div>
<?php 
if( $this->should_hide_shipping_panel( ) ){ ?>
<script>
jQuery('.ec_cart_shipping_holder').hide();
</script>
<?php }?>
