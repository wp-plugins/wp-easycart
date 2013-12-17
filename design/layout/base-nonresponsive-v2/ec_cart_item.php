<div class="ec_cart_item" id="ec_cart_item_<?php $cart_item->display_cartitem_id(); ?>">
	<div class="ec_cart_item_column1">
		<?php $cart_item->display_image( "small" ); ?>
	</div>
    <div class="ec_cart_item_column2">
		<div class="ec_cart_item_title"><?php $cart_item->display_title_link(); ?></div>
        <?php if( $cart_item->use_advanced_optionset ){ ?>
        <?php $advanced_options = $cart_item->get_advanced_options( ) ?>
        <?php foreach( $advanced_options as $advanced_option ){ ?>
        <?php // Set the display text for an option item price adjustment
			  $optionitem_price = ""; 
		      if( $advanced_option->optionitem_price > 0 ){ 
			      $optionitem_price = " (+" . $GLOBALS['currency']->get_currency_display( $advanced_option->optionitem_price ) . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ")"; 
			  }else if( $advanced_option->optionitem_price < 0 ){ 
			      $optionitem_price = " (" . $GLOBALS['currency']->get_currency_display( $advanced_option->optionitem_price ) . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ")"; 
			  }else if( $advanced_option->optionitem_price_onetime > 0 ){ 
			      $optionitem_price = " (+" . $GLOBALS['currency']->get_currency_display( $advanced_option->optionitem_price_onetime ) . ")"; 
			  }else if( $advanced_option->optionitem_price_onetime < 0 ){ 
			      $optionitem_price = " (" . $GLOBALS['currency']->get_currency_display( $advanced_option->optionitem_price_onetime ) . ")"; 
			  }else if( $advanced_option->optionitem_price_override >= 0 ){ 
			      $optionitem_price = " (" . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . $GLOBALS['currency']->get_currency_display( $advanced_option->optionitem_price_override ) . ")"; 
			  }
			  
			  // Set the display text for an option item weight adjustment
			  $optionitem_weight = "";
			  if( $advanced_option->optionitem_weight > 0 ){ 
			      $optionitem_weight = " (+" . $advanced_option->optionitem_weight . get_option( 'ec_option_weight' ) . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ")"; 
			  }else if( $advanced_option->optionitem_weight < 0 ){ 
			      $optionitem_weight = " (" . $advanced_option->optionitem_weight . get_option( 'ec_option_weight' ) . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ")"; 
			  }else if( $advanced_option->optionitem_weight_onetime > 0 ){ 
			      $optionitem_weight = " (+" . $advanced_option->optionitem_weight_onetime . get_option( 'ec_option_weight' ) . ")"; 
			  }else if( $advanced_option->optionitem_weight_onetime < 0 ){ 
			      $optionitem_weight = " (" . $advanced_option->optionitem_weight_onetime . get_option( 'ec_option_weight' ) . ")"; 
			  }
		?>
        <?php if( $advanced_option->option_type == "grid" ){ ?>
        <div class="ec_cart_item_option"><?php echo $advanced_option->option_name; ?>: <?php echo $advanced_option->optionitem_name; ?> (<?php echo $advanced_option->optionitem_value; ?>)<?php echo $optionitem_price; ?></div>
        <?php }else{ ?>
        <div class="ec_cart_item_option"><?php echo $advanced_option->option_name; ?>: <?php echo $advanced_option->optionitem_value; ?><?php echo $optionitem_price; ?></div>
        <?php } ?>
		<?php } ?>
        <?php }else{ ?>
        <?php if( $cart_item->has_option1( ) ){?><div class="ec_cart_item_option"><?php $cart_item->display_option1( ); ?></div><?php } ?>
        <?php if( $cart_item->has_option2( ) ){?><div class="ec_cart_item_option"><?php $cart_item->display_option2( ); ?></div><?php } ?>
        <?php if( $cart_item->has_option3( ) ){?><div class="ec_cart_item_option"><?php $cart_item->display_option3( ); ?></div><?php } ?>
        <?php if( $cart_item->has_option4( ) ){?><div class="ec_cart_item_option"><?php $cart_item->display_option4( ); ?></div><?php } ?>
        <?php if( $cart_item->has_option5( ) ){?><div class="ec_cart_item_option"><?php $cart_item->display_option5( ); ?></div><?php } ?>
        <?php } ?>
        
        <?php if( $cart_item->has_gift_card_message( ) ){?>
        <div class="ec_cart_item_option">
			<?php $cart_item->display_gift_card_message( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_message' ) ); ?>
        </div>
        <?php }?>
        
        <?php if( $cart_item->has_gift_card_from_name( ) ){?>
        <div class="ec_cart_item_option">
			<?php $cart_item->display_gift_card_from_name( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_from' ) ); ?>
        </div>
        <?php }?>
        
        <?php if( $cart_item->has_gift_card_to_name( ) ){?>
        <div class="ec_cart_item_option">
			<?php $cart_item->display_gift_card_to_name( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_to' ) ); ?>
        </div>
        <?php }?>
        
    </div>
    <div class="ec_cart_item_column3">
    	<div class="ec_cart_item_unit_price"><?php $cart_item->display_unit_price( ); ?></div>
    </div>
	<?php $cart_item->display_update_form_start( ); ?>
    <div class="ec_cart_item_column4">
    	<div class="ec_cart_item_quantity_box"><?php if( $cart_item->is_donation ){ $cart_item->display_quantity(); }else{ $cart_item->display_quantity_box( ); } ?></div>
    </div>
    <div class="ec_cart_item_column5">
    	<div class="ec_cart_item_total_price"><?php $cart_item->display_item_total( ); ?></div>
    	<?php $cart_item->display_item_loader(); ?>
    </div>
    <div class="ec_cart_item_column6">
    	<?php if( !$cart_item->is_donation ){ ?><div class="ec_cart_item_update_button"><?php $cart_item->display_update_button( $GLOBALS['language']->get_text( 'cart', 'cart_item_update_button' ) ); ?></div><?php }?>
    	<?php $cart_item->display_update_form_end( ); ?>
        <div class="ec_cart_item_delete_button"><?php $cart_item->display_delete_button( $GLOBALS['language']->get_text( 'cart', 'cart_item_remove_button' ) ); ?></div>
    </div>
</div>