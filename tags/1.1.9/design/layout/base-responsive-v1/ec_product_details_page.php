<?php if( $this->product->has_promotion_text( ) ){ ?><div class="ec_store_promotion"><div><?php $this->product->display_promotion_text( ); ?></div></div><?php }?>
<span class="ec_product_details_magbox" id="ec_product_details_magbox"></span>
<div class="ec_product_details_page">
    
    <div class="ec_product_details_left_side">
    	<div class="ec_product_details_images">
    		<?php $this->product->display_product_details_image_set( "large", "ec_image_", "ec_image_click" ); ?>
    	</div>
    	<div class="ec_product_details_thumbnails">
      		<?php $this->product->display_product_image_thumbnails("xsmall", "ec_thumb_", "ec_thumb_click" ); ?>
    	</div>
    </div>
    
	<?php $this->product->display_product_details_form_start(); ?>
    <div class="ec_product_details_right_side">
    	<div class="ec_product_details_mag_viewer" id="ec_product_details_mag_viewer"></div>
    	<div class="ec_product_details_title">
            <div class="ec_product_details_title_sub">
                <?php $this->product->display_product_title(); ?>
            </div>
    	
			<?php if( $this->product->use_customer_reviews ){ ?>
            <div class="ec_product_details_stars"><?php $this->product->display_product_stars(); ?></div>
            <div class="ec_product_details_review_count">(<?php $this->product->display_product_number_reviews(); ?>)</div>
            
			<?php } ?>
    
    	</div>
    
    	<div class="ec_product_details_below_title_row">
    		<div class="ec_product_details_model_number"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_model_number' )?> <?php $this->product->display_model_number( ); ?></div>
      	
			<?php if( $this->product->show_stock_quantity ){ ?>
                <div class="ec_product_details_in_stock"><span id="in_stock_amount_text"><?php $this->product->display_product_stock_quantity(); ?></span> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_remaining' )?></div>
            <?php } ?>
        
		</div>
    
		<?php if( $this->product->is_donation ){?>
    	<div class="ec_product_details_donation" id="ec_product_details_donation_row"> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_donation_label' )?> <?php $this->product->display_price_input(); ?> ( <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_minimum_donation' )?> <?php $this->product->display_price( ); ?> )</div>
    
		<?php }else{ ?>
    	<div class="ec_product_details_price">
    		<?php $this->product->display_price(); ?>
      		<?php $this->product->display_list_price(); ?>
   		</div>
    	
			<?php if( $this->product->product_has_discount( ) ){ ?>
    	<div class="ec_product_details_discount"> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_reduced_price' )?> <?php $this->product->display_product_discount_percentage( ); ?>%</div>
  			<?php }?>
    
    	<div class="ec_product_price_tiers"><?php $this->product->display_product_price_tiers(); ?></div>
    
		<?php }?>
    
    	<?php if( $this->product->product_has_swatches( $this->product->options->optionset1 ) ){ ?>
    	<div class="ec_product_details_option1_swatches"><?php $this->product->display_product_option( $this->product->options->optionset1, "large", 1, "ec_swatch_", "ec_swatch_click" ); ?></div>
    
		<?php }else if( $this->product->product_has_combo( $this->product->options->optionset1 ) ){ ?>
    	<div class="ec_product_details_option1_combo"><?php $this->product->display_product_option( $this->product->options->optionset1, "large", 1, "ec_combo_", "" ); ?></div>
    
		<?php }?>
    
		<?php if( $this->product->product_has_swatches( $this->product->options->optionset2 ) ){ ?>
        <div class="ec_product_details_option2_swatches"><?php $this->product->display_product_option( $this->product->options->optionset2, "large", 2, "ec_swatch_", "ec_swatch_click" ); ?></div>
    
		<?php }else if( $this->product->product_has_combo( $this->product->options->optionset2 ) ){ ?>
        <div class="ec_product_details_option2_combo"><?php $this->product->display_product_option( $this->product->options->optionset2, "large", 2, "ec_combo_", "" ); ?></div>
    
		<?php }?>
    
    	<?php if( $this->product->product_has_swatches( $this->product->options->optionset3 ) ){ ?>
        <div class="ec_product_details_option3_swatches"><?php $this->product->display_product_option( $this->product->options->optionset3, "large", 3, "ec_swatch_", "ec_swatch_click" ); ?></div>
    
		<?php }else if( $this->product->product_has_combo( $this->product->options->optionset3 ) ){ ?>
        <div class="ec_product_details_option3_combo"><?php $this->product->display_product_option( $this->product->options->optionset3, "large", 3, "ec_combo_", "" ); ?></div>
    
		<?php }?>
    
		<?php if( $this->product->product_has_swatches( $this->product->options->optionset4 ) ){ ?>
        <div class="ec_product_details_option4_swatches"><?php $this->product->display_product_option( $this->product->options->optionset4, "large", 4, "ec_swatch_", "ec_swatch_click" ); ?></div>
    
		<?php }else if( $this->product->product_has_combo( $this->product->options->optionset4 ) ){ ?>
        <div class="ec_product_details_option4_combo"><?php $this->product->display_product_option( $this->product->options->optionset4, "large", 4, "ec_combo_", "" ); ?></div>
    
		<?php }?>
    
		<?php if( $this->product->product_has_swatches( $this->product->options->optionset5 ) ){ ?>
    	<div class="ec_product_details_option5_swatches"><?php $this->product->display_product_option( $this->product->options->optionset5, "large", 5, "ec_swatch_", "ec_swatch_click" ); ?></div>
    
		<?php }else if( $this->product->product_has_combo( $this->product->options->optionset5 ) ){ ?>
    	<div class="ec_product_details_option5_combo"><?php $this->product->display_product_option( $this->product->options->optionset5, "large", 5, "ec_combo_", "" ); ?></div>
    
		<?php }?>
    
		<?php if( $this->product->is_giftcard ){ ?>
    	<div class="ec_product_details_gift_card"><?php $this->product->display_gift_card_input(); ?></div>
    
		<?php }?>
    
    	<div class="<?php if( $this->product->is_donation ){ echo "ec_product_details_quantity_donation"; }else{ echo "ec_product_details_quantity"; } ?>" id="ec_product_details_quantity_<?php echo $this->product->model_number; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_quantity' )?> <?php $this->product->display_product_quantity_input("1"); ?>
    	</div>
    
    	<div class="ec_product_details_add_to_cart"><?php $this->product->display_product_add_to_cart_button($GLOBALS['language']->get_text( 'product_details', 'product_details_add_to_cart' ), "ec_quick_view_error" ); ?></div>
    
    	<div class="ec_product_details_social_media_icons">
			<?php $this->product->social_icons->display_facebook_icon( ); ?>
            <?php $this->product->social_icons->display_twitter_icon( ); ?>
            <?php $this->product->social_icons->display_delicious_icon( ); ?>
            <?php $this->product->social_icons->display_myspace_icon( ); ?>
            <?php $this->product->social_icons->display_linkedin_icon( ); ?>
            <?php $this->product->social_icons->display_email_icon( ); ?>
            <?php $this->product->social_icons->display_digg_icon( ); ?>
            <?php $this->product->social_icons->display_googleplus_icon( ); ?>
            <?php $this->product->social_icons->display_pinterest_icon( ); ?>
    	</div>
    </div>
    <?php $this->product->display_product_details_form_end(); ?>
  
	<div class="ec_product_details_bottom" id="ec_product_details_tabs">
    
		<?php if($this->product->product_has_description()){?>
    		<div class="ec_product_details_tab_selected" id="ec_product_details_description_tab"><a href="#ec_product_details_description" onclick="update_content_areas( 1 ); return false;"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_description' )?><span class="ec_product_details_tab_span"></span></a></div>
		<?php }?>
     
		<?php if($this->product->product_has_specifications()){?>
    		<div class="ec_product_details_tab" id="ec_product_details_specifications_tab"><a href="#ec_product_details_specifications" onclick="update_content_areas( 2 ); return false;"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_specifications' )?><span class="ec_product_details_tab_span"></span></a></div>
		<?php }?>
    
		<?php if($this->product->product_has_customer_reviews()){?>
    		<div class="ec_product_details_tab" id="ec_product_details_customer_reviews_tab"><a href="#ec_product_details_customer_reviews" onclick="update_content_areas( 3 ); return false;"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_customer_reviews' )?><span class="ec_product_details_tab_span"></span></a></div>
    	<?php }?>
  	
    </div>
  
  
	<?php if($this->product->product_has_description()){?>
	<div class="ec_product_details_description" id="ec_product_details_description"><div><?php $this->product->display_product_description(); ?></div></div>
    <?php }?>
    
	<?php if($this->product->product_has_specifications()){?>
    <div class="ec_product_details_specifications" id="ec_product_details_specifications"><div><?php $this->product->display_product_specifications(); ?></div></div>
    <?php }?>
    
	<?php if($this->product->product_has_customer_reviews()){?>
    <div class="ec_product_details_customer_reviews" id="ec_product_details_customer_reviews">
   		<div class="ec_product_details_customer_reviews_overall_row">
            <div class="ec_product_details_customer_reviews_button"><?php $this->product->display_product_customer_review_open_button("Write a Review", "Review Submitted"); ?></div>
            <div class="ec_product_details_customer_reviews_overall_title"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_customer_rating' )?></div>
            <?php if( $this->product->has_reviews( ) ){ ?>
            <div class="ec_product_details_customer_reviews_stars"><?php $this->product->display_product_stars(); ?></div>
            <div class="ec_product_details_customer_reviews_num_reviews"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_review_based_on' )?> <?php $this->product->display_product_number_reviews(); ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_review' )?><?php if($this->product->get_product_number_reviews() != 1) echo "s"; ?></div>
            <?php }else{ ?>
            <div class="ec_product_details_customer_reviews_num_reviews"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_review_no_reviews' )?></div>
            <?php }?>
        </div>
        
        <div class="ec_product_details_customer_reviews_list"><?php $this->product->display_product_reviews(); ?></div>
    </div>
    
    <div class="ec_product_details_customer_reviews_popup_background" id="customer_review_popup_background"></div>
    <div class="ec_product_details_customer_reviews_popup_box" id="customer_review_popup_box">
		<div class="ec_product_details_customer_reviews_popup_title"><span><?php echo $GLOBALS['language']->get_text( 'customer_review', 'customer_review_title' )?></span></div>
      	<div class="ec_product_details_customer_reviews_popup_close_button"><span><?php $this->product->display_product_customer_review_close_button($GLOBALS['language']->get_text( 'customer_review', 'customer_review_close_button' )); ?></span></div>
      	
        <div class="ec_product_details_customer_reviews_popup_content">
        	<span>
				<?php $this->product->display_product_customer_review_form_start(); ?>
        		<div class="ec_product_details_customer_reviews_popup_rating_row">
          			<div class="ec_product_details_customer_reviews_popup_rating_label"><?php echo $GLOBALS['language']->get_text( 'customer_review', 'customer_review_choose_rating' )?></div>
          			<div class="ec_product_details_customer_reviews_popup_rating_stars"><?php $this->product->display_product_customer_review_rating_stars(); ?></div>
        		</div>
        	
            	<div class="ec_product_details_customer_reviews_popup_label_row" id="ec_product_details_customer_reviews_popup_label_title"><span><?php echo $GLOBALS['language']->get_text( 'customer_review', 'customer_review_enter_title' )?></span></div>
        		<div class="ec_product_details_customer_reviews_popup_input_row"><span><?php $this->product->display_product_customer_review_title_input(); ?></span></div>
        		<div class="ec_product_details_customer_reviews_popup_label_row" id="ec_product_details_customer_reviews_popup_label_description"><span><?php echo $GLOBALS['language']->get_text( 'customer_review', 'customer_review_enter_description' )?></span></div>
        		<div class="ec_product_details_customer_reviews_popup_input_row"><span><?php $this->product->display_product_customer_review_description_input(); ?></span></div>
        		<div class="ec_product_details_customer_reviews_popup_submit_button"><span><?php $this->product->display_product_customer_review_submit_button($GLOBALS['language']->get_text( 'customer_review', 'customer_review_submit_button' )); ?></span></div>
        		<?php $this->product->display_product_customer_review_form_end(); ?>
        	</span>
        </div>
    </div>
    <?php }?>
    
	<?php if( $this->product->product_has_featured_products( ) ){?>
    <div class="ec_product_details_featured_products" id="ec_product_details_featured_products"><?php $this->product->display_featured_products(); ?></div>
    <?php }?>
  	<div class="ec_product_details_clear"></div>
</div>
<script>
jQuery("#customer_review_popup_background").appendTo("#top");
jQuery("#customer_review_popup_box").appendTo("#top");
</script>