<div class="ec_cart_address_review_holder">
  <div class="ec_cart_address_review_title"><?php echo $GLOBALS['language']->get_text( 'cart_address_review', 'cart_address_review_title' )?></div>
  <div class="ec_cart_address_review_left">
    <div class="ec_cart_address_review_row_title"><?php echo $GLOBALS['language']->get_text( 'cart_address_review', 'cart_address_review_billing_title' )?></div>
    <div class="ec_cart_address_review_row" id="ec_cart_billing_name_row">
      <?php $this->display_review_billing( "first_name" ); ?>
      <?php $this->display_review_billing( "last_name" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_billing_address_line_1_row">
      <?php $this->display_review_billing( "address" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_billing_address_line_2_row">
      <?php $this->display_review_billing( "city" ); ?>,
      <?php $this->display_review_billing( "state" ); ?>
      <?php $this->display_review_billing( "zip" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_billing_country_row">
      <?php $this->display_review_billing( "country" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_billing_phone_row">
      <?php $this->display_review_billing( "phone" ); ?>
    </div>
  </div>
  <div class="ec_cart_address_review_middle">
    <div class="ec_cart_address_review_row_title"><?php echo $GLOBALS['language']->get_text( 'cart_address_review', 'cart_address_review_shipping_title' )?></div>
    <div class="ec_cart_address_review_row" id="ec_cart_shipping_name_row">
      <?php $this->display_review_shipping( "first_name" ); ?>
      <?php $this->display_review_shipping( "last_name" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_shipping_address_line_1_row">
      <?php $this->display_review_shipping( "address" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_shipping_address_line_2_row">
      <?php $this->display_review_shipping( "city" ); ?>,
      <?php $this->display_review_shipping( "state" ); ?>
      <?php $this->display_review_shipping( "zip" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_shipping_country_row">
      <?php $this->display_review_shipping( "country" ); ?>
    </div>
    <div class="ec_cart_address_review_row" id="ec_cart_shipping_phone_row">
      <?php $this->display_review_shipping( "phone" ); ?>
    </div>
  </div>
  <div class="ec_cart_address_review_right">
    <div class="ec_cart_address_review_right_row">
      <?php $this->display_selected_shipping_method( ); ?>
    </div>
    <div class="ec_cart_address_review_right_row">
      <?php $this->display_edit_address_link( $GLOBALS['language']->get_text( 'cart_address_review', 'cart_address_review_edit_link' ) ); ?>
    </div>
  </div>
</div>
