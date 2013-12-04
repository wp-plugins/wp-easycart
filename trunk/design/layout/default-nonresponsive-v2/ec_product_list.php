<div id="ec_product_item_list_<?php echo $i+1; ?>" class="ec_product_list_view">
    <?php $product->display_product_details_form_start( ); ?>
		<div class="ec_product_list_view_left">
        	<div class="ec_product_list_view_image">
                <?php $product->display_product_image_set( "large", "ec_image_", "return true; ec_image_quick_view_click" ); ?>
            </div>
        </div>
		
        <div class="ec_product_list_view_middle">
        	<div class="ec_product_list_view_row"><span class="title"><?php $product->display_product_title(); ?></span></div>
        	<?php if( $product->is_donation ){?>
                <div class="ec_product_list_view_row" id="ec_product_details_donation_row"> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_donation_label' )?> <?php $product->display_price_input(); ?></div>
                
                <div class="ec_product_details_donation" id="ec_product_details_donation_min_row">( <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_minimum_donation' )?> <?php $product->display_price( ); ?> )</div>
        
            <?php }else{ ?>
                <div class="ec_product_list_view_row2"><?php $product->display_price(); ?>&nbsp;<?php $product->display_product_list_price(); ?></div>
                <?php if( $product->list_price != "0.00" ){ ?>
                <div class="ec_product_list_view_row3"><span class="ec_product_details_discount"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_reduced_price' )?> <?php $product->display_product_discount_percentage( ); ?>%</span></div>
                <?php } ?> 
                <div class="ec_product_list_view_row"><?php $product->display_product_price_tiers(); ?></div>
            <?php }?>
            
            <?php if( !$product->use_advanced_optionset ){ ?>
            
            <?php if( $product->product_has_swatches( $product->options->optionset1 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset1, "large", 1, "ec_swatch_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset1 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset1, "large", 1, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset2 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset2, "large", 2, "ec_swatch_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset2 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset2, "large", 2, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset3 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset3, "large", 3, "ec_swatch_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset3 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset3, "large", 3, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset4 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset4, "large", 4, "ec_swatch_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset4 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset4, "large", 4, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset5 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset5, "large", 5, "ec_swatch_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset5 ) ){ ?>
            <div class="ec_product_list_view_option_row">
              <?php $product->display_product_option( $product->options->optionset5, "large", 5, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            
            <?php } // End Advanced Option Set( Basic Option Set Here) Else ?>
			<?php if( $product->show_stock_quantity || $product->use_optionitem_quantity_tracking ){ ?>
            <div class="ec_product_list_view_row"><span id="in_stock_amount_text_<?php echo $product->model_number; ?>"><?php $product->display_product_stock_quantity(); ?></span> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_remaining' )?></div>
            <?php }?>
            <div class="ec_product_list_view_row"><?php $product->display_product_link( $GLOBALS['language']->get_text( 'quick_view', 'quick_view_view_full_details' ) ); ?></div>
        </div>
        <div class="ec_product_list_view_right">
            
            <?php if( !$product->is_giftcard && !$product->use_advanced_optionset ){ ?>
            <div class="ec_product_details_quantity" id="ec_product_details_quantity_<?php echo $product->model_number; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_quantity' )?> <?php $product->display_product_quantity_input("1"); ?></div>
            
            <div class="ec_product_list_view_row"><?php $product->display_product_add_to_cart_button( $GLOBALS['language']->get_text( 'quick_view', 'quick_view_add_to_cart' ), "ec_list_view_error" ); ?></div>
            <?php }?>
            
        </div>
        <?php $product->display_product_details_form_end( ); ?>
</div>
<?php if( $product->product_has_swatches( $product->options->optionset1 ) ){ ?>
<script>
	ec_swatch_click('<?php echo $product->model_number; ?>', 1, 0);
</script>
<?php }?>