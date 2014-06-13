<div class="ec_cart_final_review_background" id="ec_cart_final_review_background"></div>
<div class="ec_cart_final_review_holder" id="ec_cart_final_review_holder">
	<div class="ec_cart_final_loader_overlay"><?php $this->display_ajax_loader( 'ajax-loader.gif' ); ?></div>
    <div class="ec_cart_final_review_padding">
        <div class="ec_cart_final_review_title">Review Your Order</div>
        <hr class="ec_cart_final_divider" />
        <div class="ec_final_item_row_header"><span class="ec_final_item_title">Product</span><span class="ec_cart_final_item_quantity">Quantity</span><span class="ec_cart_final_item_price">Unit Price</span></div>
        <?php $i=0; foreach( $this->cart->cart as $cartitem ){ ?>
        <div id="ec_cart_final_item_<?php echo $cartitem->cartitem_id; ?>" class="ec_final_item_row<?php if( $i%2 ){ echo " ec_final_item_row_color1"; }else{ echo " ec_final_item_row_color2"; } ?>"><span class="ec_final_item_title"><?php echo $cartitem->title; ?></span><span class="ec_cart_final_item_quantity" id="ec_cart_final_item_quantity_<?php echo $cartitem->cartitem_id; ?>"><?php echo $cartitem->quantity; ?></span> <span class="ec_cart_final_item_price" id="ec_cart_final_item_price_<?php echo $cartitem->cartitem_id; ?>"><?php echo $GLOBALS['currency']->get_currency_display( $cartitem->unit_price ); ?></span></div>
        <?php $i++; }?>
        <hr class="ec_cart_final_divider" />
        <div class="ec_cart_final_price_row">
            <span id="ec_cart_final_subtotal" class="ec_cart_final_price_row_value"><?php echo $GLOBALS['currency']->get_currency_display( $this->order_totals->sub_total ); ?></span>
        	<span class="ec_cart_final_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_subtotal' )?></span>
        </div>
        
        <?php if( $this->tax->is_tax_enabled( ) ){ ?>
        <div class="ec_cart_final_price_row">
            <span id="ec_cart_final_tax" class="ec_cart_final_price_row_value"><?php echo $GLOBALS['currency']->get_currency_display( $this->order_totals->tax_total ); ?></span>
        	<span class="ec_cart_final_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_tax' )?></span>
        </div>
        <?php } ?>
        
        <?php if( get_option( 'ec_option_use_shipping' ) ){?>
        <div class="ec_cart_final_price_row">
            <span id="ec_cart_final_shipping" class="ec_cart_final_price_row_value"><?php echo $GLOBALS['currency']->get_currency_display( $this->order_totals->shipping_total ); ?></span>
        	<span class="ec_cart_final_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' )?></span>
      	</div>
        <?php }?>
        
        <div class="ec_cart_final_price_row">
            <span id="ec_cart_final_discount" class="ec_cart_final_price_row_value"><?php echo $GLOBALS['currency']->get_currency_display( $this->order_totals->discount_total ); ?></span>
        	<span class="ec_cart_final_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_discounts' )?></span>
        </div>
        
        <?php if( $this->tax->is_duty_enabled( ) ){ ?>
        <div class="ec_cart_final_price_row">
            <span id="ec_cart_final_duty" class="ec_cart_final_price_row_value"><?php echo $GLOBALS['currency']->get_currency_display( $this->order_totals->duty_total ); ?></span>
        	<span class="ec_cart_final_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_duty' )?></span>
        </div>
        <?php }?>
        
        <?php if( $this->tax->is_vat_enabled( ) ){ ?>
        <div class="ec_cart_final_price_row">
            <span id="ec_cart_final_vat" class="ec_cart_final_price_row_value"><?php echo $GLOBALS['currency']->get_currency_display( $this->order_totals->vat_total ); ?></span>
        	<span class="ec_cart_final_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_vat' )?></span>
        </div>
        <?php } ?>
        
        <div class="ec_cart_final_price_row">
        	<span id="ec_cart_final_grand_total" class="ec_cart_final_price_row_value"><?php echo $GLOBALS['currency']->get_currency_display( $this->order_totals->grand_total ); ?></span>
            <span class="ec_cart_final_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_grand_total' )?></span>
        </div>
        
        <?php if( get_option( 'ec_option_user_order_notes' ) ){ ?>
        <hr class="ec_cart_final_divider" />
        <div class="ec_cart_final_custom_notes_title"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?></div>
        <div class="ec_cart_final_custom_notes" id="ec_cart_final_custom_notes"></div>
        <?php }?>
        
        <hr class="ec_cart_final_divider" />
        
        <div class="ec_cart_submit_order_message"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?></div>
        <div class="ec_cart_page_submit_order_button"><?php $this->display_submit_order_button( $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' ) ); ?><?php $this->display_cancel_order_button( $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_cancel_order_button' ) ); ?></div>
        <span class="ec_cart_final_clear"></span>
    </div>
</div>

<script>
document.onkeypress = ec_stop_enter_press; 
</script>