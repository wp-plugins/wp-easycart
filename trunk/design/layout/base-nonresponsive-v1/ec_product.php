<div class="ec_product_quick_view_box_holder" id="ec_product_quick_view_box_<?php echo $product->model_number; ?>">
	<div class="ec_product_quick_view_box_background"></div>
    <div class="ec_product_quick_view_box_content_holder">
    	<div class="ec_product_quick_view_box_content_close">
        	<a href="#" onclick="ec_product_hide_quick_view( '<?php echo $product->model_number; ?>' )">X</a>
        </div>
        <?php $product->display_product_details_form_start( ); ?>
		<?php if( $product->has_thumbnails( ) ){ ?>
    	<div class="ec_product_quick_view_box_content_thumbnails">
        	<?php $product->display_product_image_thumbnails( "xsmall", "ec_thumb_quick_view_", "ec_thumb_quick_view_click" ); ?>
        </div>
        <?php } ?>
        <div class="ec_product_quick_view_box_content_image">
        	<?php $product->display_product_details_image_set( "large", "ec_image_quick_view_", "ec_image_quick_view_click" ); ?>
        </div>
        <div class="ec_product_quick_view_box_content_right">
        	<div class="ec_product_quick_view_box_content_row"><span class="title"><?php $product->display_product_title(); ?></span></div>
        	<div class="ec_product_quick_view_box_content_row2"><?php $product->display_price(); ?>&nbsp;<?php $product->display_product_list_price(); ?></div>
             <?php if( $product->list_price != "0.00" ){ ?>
            <div class="ec_product_quick_view_box_content_row3"><span class="ec_product_details_discount"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_reduced_price' )?> <?php $product->display_product_discount_percentage( ); ?>%</span></div>
             <?php }?>
            
            
            <div class="ec_product_quick_view_box_content_row"><?php $product->display_product_price_tiers(); ?></div>
            
            
            <?php if( $product->product_has_swatches( $product->options->optionset1 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset1, "large", 1, "ec_swatch_quick_view_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset1 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset1, "large", 1, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset2 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset2, "large", 2, "ec_swatch_quick_view_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset2 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset2, "large", 2, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset3 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset3, "large", 3, "ec_swatch_quick_view_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset3 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset3, "large", 3, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset4 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset4, "large", 4, "ec_swatch_quick_view_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset4 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset4, "large", 4, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->product_has_swatches( $product->options->optionset5 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset5, "large", 5, "ec_swatch_quick_view_", "ec_swatch_click" ); ?>
            </div>
            <?php }else if( $product->product_has_combo( $product->options->optionset5 ) ){ ?>
            <div class="ec_product_quick_view_box_content_option_row">
              <?php $product->display_product_option( $product->options->optionset5, "large", 5, "ec_combo_", "" ); ?>
            </div>
            <?php }?>
            <?php if( $product->is_giftcard ){ ?>
            <div class="ec_product_details_gift_card">
              <?php $product->display_gift_card_input(); ?>
            </div>
            <?php }?>
            
            <div class="ec_product_details_quantity" id="ec_product_details_quantity_<?php echo $product->model_number; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_quantity' )?> <?php $product->display_product_quantity_input("1"); ?></div>
            
            <?php if( $product->show_stock_quantity || $product->use_optionitem_quantity_tracking ){ ?>
            <div class="ec_product_quick_view_box_content_row"><span id="in_stock_amount_text_<?php echo $product->model_number; ?>"><?php $product->display_product_stock_quantity(); ?></span> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_remaining' )?></div>
            <?php }?>
            <div class="ec_product_quick_view_box_content_row"><?php $product->display_product_add_to_cart_button( $GLOBALS['language']->get_text( 'quick_view', 'quick_view_add_to_cart' ), "ec_quick_view_error" ); ?></div>
            <div class="ec_product_quick_view_box_content_row"><?php $product->display_product_link( $GLOBALS['language']->get_text( 'quick_view', 'quick_view_view_full_details' ) ); ?></div>
        </div>
        <?php $product->display_product_details_form_end( ); ?>
    </div>
</div>
<script>
jQuery("#ec_product_quick_view_box_<?php echo $product->model_number; ?>").appendTo("body");
</script>
<div id="ec_product_item<?php echo $i+1; ?>" class="ec_product">
    <div class="ec_product_quick_view_holder"><?php $product->display_product_quick_view( $GLOBALS['language']->get_text( 'product_page', 'product_quick_view' ) ); ?></div>
    
    <div class="ec_product_images">
		<?php $product->display_product_image_set( "medium", "ec_image_", "" ); ?>
		
    </div>
	
    <div class="ec_product_left">
        <div class="ec_product_title"><?php $product->display_product_title_link(); ?></div>
        
        <?php if( $product->use_customer_reviews ){?><div class="ec_product_rating"><div class="ec_product_stars"><?php $product->display_product_stars(); ?></div><div class="ec_product_num_reviews"> (<?php $product->display_product_number_reviews(); ?>)</div></div><?php }?>
    	
    </div>
    <div style="width:35%; float:right;">
    	<div class="ec_product_pricing"><?php $product->display_product_list_price(); ?><?php $product->display_price(); ?></div>
    </div>
    <?php if($product->use_optionitem_images){ ?><div class="ec_product_swatches"><?php $product->display_product_option_swatches( $product->options->optionset1, "small", 1, "ec_swatch_", "ec_swatch_click", false ); ?></div><?php }?>
</div>