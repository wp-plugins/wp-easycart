<?php 

if( $this->should_display_cart( ) ){ 

?>

<div class="ec_cart">
  <?php if( $this->is_cart_type_one( ) ){ ?>
  <div class="ec_cart_header_row">
    <div class="ec_cart_header_title"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_title' )?></div>
    <div class="ec_cart_continue_shopping_button">
      <?php $this->display_continue_shopping_button( $GLOBALS['language']->get_text( 'cart', 'cart_continue_shopping' ) ); ?>
      <?php $this->display_checkout_button( $GLOBALS['language']->get_text( 'cart', 'cart_checkout' ) ); ?>
    </div>
  </div>
  <?php }?>
  <div class="ec_cart_title_bar">
    <div class="ec_cart_title_bar_column_1"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column1' )?></div>
    <div class="ec_cart_title_bar_column_2"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column2' )?></div>
    <div class="ec_cart_title_bar_column_3"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column3' )?></div>
    <div class="ec_cart_title_bar_column_4"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column4' )?></div>
    <div class="ec_cart_title_bar_column_5"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column5' )?></div>
    <div class="ec_cart_title_bar_column_6"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column6' )?></div>
  </div>
  <div class="ec_cart_item_holder">
    <?php $this->display_cart_items(); ?>
  </div>
  <?php if( $this->is_cart_type_two( ) ){ ?>
  <?php if( $this->has_cart_total_promotion( ) ){ ?><div class="ec_cart_promotion_bar"><div><?php echo $this->display_cart_total_promotion( ); ?></div></div><?php }?>
  <?php if( $this->has_cart_shipping_promotion( ) ){ ?><div class="ec_cart_promotion_bar"><div><?php echo $this->display_cart_shipping_promotion( ); ?></div></div><?php }?>
  <div class="ec_cart_lower_left">
    <div class="ec_cart_lower_left_title"><?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_title' )?></div>
    <div class="ec_cart_lower_left_subtitle"><?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_sub_title' )?></div>
    <div class="ec_cart_gift_card_row">
      <?php $this->display_gift_card_input( $GLOBALS['language']->get_text( 'cart_coupons', 'cart_redeem_gift_card' ) ); ?>
      <?php $this->display_gift_card_loader(); ?>
    </div>
    <div class="ec_cart_gift_card_row_message" id="ec_cart_gift_card_row_message">
      <?php $this->display_gift_card_message( ); ?>
    </div>
    <div class="ec_cart_coupon_row">
      <?php $this->display_coupon_input( $GLOBALS['language']->get_text( 'cart_coupons', 'cart_apply_coupon' ) ); ?>
      <?php $this->display_coupon_loader(); ?>
    </div>
    <div class="ec_cart_coupon_row_message" id="ec_cart_coupon_row_message">
      <?php $this->display_coupon_message( ); ?>
    </div>
    <?php if( $this->is_cart_type_three( ) ){ ?>
    <?php if( get_option( 'ec_option_use_shipping' ) ){?>
    <div class="ec_cart_lower_left_title"><?php echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_title' )?></div>
    <div class="ec_cart_lower_left_subtitle"><?php echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_sub_title' )?></div>
    <div class="ec_cart_shipping_costs_row">
      <?php $this->display_shipping_costs_input( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_input_label' ), $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_button' ), $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_input_country_label' ), $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_select_one' ) ); ?>
      <?php $this->display_estimate_shipping_loader(); ?>
    </div>
    <div class="ec_cart_shipping_methods" id="ec_cart_shipping_methods">
      <?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ), $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?>
    </div>
    <?php }?>
    <?php }?>
  </div>
  <?php }?>
  <?php if( $this->is_cart_type_two( ) ){ ?>
  <div class="ec_cart_lower_right">
    <div class="ec_cart_lower_right_title"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_title' )?></div>
    <div class="ec_cart_lower_right_row">
      <div class="left"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_subtotal' )?></div>
      <div class="right">
        <?php $this->display_subtotal(); ?>
      </div>
    </div>
    <?php if( $this->tax->is_tax_enabled( ) ){ ?>
    <div class="ec_cart_lower_right_row">
      <div class="left"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_tax' )?></div>
      <div class="right">
        <?php $this->display_tax_total(); ?>
      </div>
    </div>
    <?php } ?>
    <?php if( get_option( 'ec_option_use_shipping' ) ){?>
    <div class="ec_cart_lower_right_row">
      <div class="left"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' )?></div>
      <div class="right">
        <?php $this->display_shipping_total(); ?>
      </div>
    </div>
    <?php }?>
    <div class="ec_cart_lower_right_row">
      <div class="left"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_discounts' )?></div>
      <div class="right">-<?php $this->display_discount_total(); ?></div>
    </div>
    <?php if( $this->tax->is_duty_enabled( ) ){ ?>
    <div class="ec_cart_lower_right_row">
      <div class="left"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_duty' )?></div>
      <div class="right">
        <?php $this->display_duty_total( ); ?>
      </div>
    </div>
    <?php }?>
    <?php if( $this->tax->is_vat_enabled( ) ){ ?>
    <div class="ec_cart_lower_right_row">
      <div class="left"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_vat' )?> </div>
      <div class="right"><?php echo $this->display_vat_total( ); ?></div>
    </div>
    <?php } ?>
    <div class="ec_cart_lower_right_row">
      <div class="left"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_grand_total' )?></div>
      <div class="right">
        <?php $this->display_grand_total(); ?>
      </div>
    </div>
  </div>
  <div class="ec_cart_bottom_divider_line"></div>
  <?php }?>
  <?php if( $this->is_cart_type_one( ) ){ ?>
  <div class="ec_cart_header_row">
    <div class="ec_cart_continue_shopping_button">
      <?php $this->display_continue_shopping_button( $GLOBALS['language']->get_text( 'cart', 'cart_continue_shopping' )); ?>
      <?php $this->display_checkout_button( $GLOBALS['language']->get_text( 'cart', 'cart_checkout' ) ); ?>
    </div>
  </div>
  <?php }?>
  <div class="ec_cart_clear"></div>
</div>
<?php }?>
