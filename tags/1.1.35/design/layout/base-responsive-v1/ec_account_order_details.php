<div id="ec_account_order_details">
  <div class="ec_account_order_details_main_holder">
    <div class="ec_account_order_details_left">
      <div class="ec_account_order_details_title"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_order_info_title' )?></div>
      <div class="ec_account_order_details_holder">
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_order_number' )?></b>
          <?php $this->order->display_order_id( ); ?>
        </div>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_order_date' )?></b>
          <?php $this->order->display_order_date( 'M d, Y g:i A' ); ?>
        </div>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_order_status' )?></b>
          <?php $this->order->display_order_status( ); ?>
        </div>
        <?php if( get_option( 'ec_option_use_shipping' ) ){?>
        <?php if( $this->order->shipping_method ){ ?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_shipping_method' )?></b>
          <?php $this->order->display_order_shipping_method( ); ?>
        </div>
        <?php }?>
        <?php }?>
        <?php if( $this->order->promo_code ){ ?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_coupon_code' )?></b>
          <?php $this->order->display_order_promocode( ); ?>
        </div>
        <?php }?>
        <?php if( $this->order->giftcard_id ){ ?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_card' )?></b>
          <?php $this->order->display_order_giftcard( ); ?>
        </div>
        <?php }?>
        <?php if( $this->order->has_tracking_number( ) ){ ?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_order_tracking' )?></b>
          <?php $this->order->display_order_tracking_number( ); ?>
        </div>
        <?php }?>
        <div class="ec_account_order_details_row">&nbsp;&nbsp;&nbsp;</div>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_billing_label' )?></b></div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_billing_first_name( ); ?>
          <?php $this->order->display_order_billing_last_name( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_billing_address_line_1( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_billing_city( ); ?>
          ,
          <?php $this->order->display_order_billing_state( ); ?>
          <?php $this->order->display_order_billing_zip( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_billing_country( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_billing_phone( ); ?>
        </div>
        <div class="ec_account_order_details_row">&nbsp;&nbsp;&nbsp;</div>
        <?php if( get_option( 'ec_option_use_shipping' ) ){?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_shipping_label' )?></b></div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_shipping_first_name( ); ?>
          <?php $this->order->display_order_shipping_last_name( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_shipping_address_line_1( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_shipping_city( ); ?>
          ,
          <?php $this->order->display_order_shipping_state( ); ?>
          <?php $this->order->display_order_shipping_zip( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_shipping_country( ); ?>
        </div>
        <div class="ec_account_order_details_row">
          <?php $this->order->display_order_shipping_phone( ); ?>
        </div>
        <div class="ec_account_order_details_row">&nbsp;&nbsp;&nbsp;</div>
        <?php }?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_payment_method' )?></b>
          <?php $this->order->display_payment_method( ); ?>
        </div>
        <div class="ec_account_order_details_row">&nbsp;&nbsp;&nbsp;</div>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_subtotal' )?></b>
          <?php $this->order->display_sub_total( ); ?>
        </div>
        <?php if( get_option( 'ec_option_use_shipping' ) ){?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_shipping_total' )?></b>
          <?php $this->order->display_shipping_total( ); ?>
        </div>
        <?php }?>
        <?php if( !$this->order->has_vat( ) ){?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_tax_total' )?></b>
          <?php $this->order->display_tax_total( ); ?>
        </div>
        <?php } ?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_discount_total' )?></b>
          -<?php $this->order->display_discount_total( ); ?>
        </div>
        <?php if( $this->order->has_duty( ) ){?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_duty_total' )?></b>
          <?php $this->order->display_duty_total( ); ?>
        </div>
        <?php } ?>
        <?php if( $this->order->has_vat( ) ){?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_vat_total' )?></b>
          <?php $this->order->display_vat_total( ); ?>
        </div>
        <?php } ?>
        <div class="ec_account_order_details_row"><b><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_grand_total' )?></b>
          <?php $this->order->display_grand_total( ); ?>
        </div>
      </div>
    </div>
    <div class="ec_account_order_details_right">
      <div class="ec_account_order_details_title">
        <div class="left"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_your_order_title' )?></div>
        <div class="right">
          <?php $this->display_print_order_icon( ); ?>
        </div>
      </div>
      <div class="ec_account_order_details_holder">
        <div class="ec_account_order_details_header_row">
          <div class="ec_account_order_details_column1_header"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_header_1' )?></div>
          <div class="ec_account_order_details_column2_header"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_header_2' )?></div>
          <div class="ec_account_order_details_column3_header"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_header_3' )?></div>
          <div class="ec_account_order_details_column4_header"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_header_4' )?></div>
          <div class="ec_account_order_details_column5_header"><?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_header_5' )?></div>
        </div>
        <?php $this->display_order_detail_product_list( ); ?>
        <?php if( get_option( 'ec_option_user_order_notes' ) ){ ?>
            <div class="ec_account_order_notes">
                <h4><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?></h4>
                <p><?php echo nl2br( $this->order->order_customer_notes ); ?></p>
                <br>
                <hr />
            </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>
