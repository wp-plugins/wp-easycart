<?php $this->display_page_three_form_start( ); ?>
<div class="ec_cart_left">
    
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_payment_method' ); ?>
    </div>
    
    <?php if( $this->use_manual_payment( ) ){?>
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_manual" value="manual_bill"<?php if( get_option( 'ec_option_default_payment_type' ) == "manual_bill" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_manual_payment' )?>
    </div>
    
    <div id="ec_manual_payment_form"<?php if( get_option( 'ec_option_default_payment_type' ) == "manual_bill" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<?php $this->display_manual_payment_text( ); ?>
        </div>
    </div>
    <?php } ?>
    
    <?php if( get_option( 'ec_option_use_affirm' ) ){ ?>
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_affirm" value="affirm"<?php if( get_option( 'ec_option_default_payment_type' ) == "affirm" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_affirm' ); ?>
    </div>
    
    <div id="ec_affirm_form"<?php if( get_option( 'ec_option_default_payment_type' ) == "affirm" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section ec_affirm_box">
        	<script>
				function ec_checkout_with_affirm( ){
				// setup and configure checkout
				affirm.checkout({
				
					config: {
						financial_product_key:		"<?php echo get_option( 'ec_option_affirm_financial_product' ); ?>"
					},
					
					merchant: {
						user_confirmation_url:		"<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=process_affirm",
						user_cancel_url:			"<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_payment"
					},
					
					billing: {
						name: {
							first:					"<?php echo $this->user->billing->first_name; ?>",
							last:					"<?php echo $this->user->billing->last_name; ?>"
						},
						address: {
							line1:					"<?php echo $this->user->billing->address_line_1; ?>",
							line2:					"<?php echo $this->user->billing->address_line_2; ?>",
							city:					"<?php echo $this->user->billing->city; ?>",
							state:					"<?php echo $this->user->billing->state; ?>",
							zipcode:				"<?php echo $this->user->billing->zip; ?>",
							country:				"<?php echo $this->user->billing->country; ?>"
						},
						phone_number:				"<?php echo $this->user->billing->phone; ?>",
						email:						"<?php echo $this->user->email; ?>"
					},
					
					shipping: {
						name: {
							first:					"<?php echo $this->user->shipping->first_name; ?>",
							last:					"<?php echo $this->user->shipping->last_name; ?>"
						},
						address: {
							line1:					"<?php echo $this->user->shipping->address_line_1; ?>",
							line2:					"<?php echo $this->user->shipping->address_line_2; ?>",
							city:					"<?php echo $this->user->shipping->city; ?>",
							state:					"<?php echo $this->user->shipping->state; ?>",
							zipcode:				"<?php echo $this->user->shipping->zip; ?>",
							country:				"<?php echo $this->user->shipping->country; ?>"
						},
						phone_number:				"<?php echo $this->user->shipping->phone; ?>"
					},
					
					items: [<?php for( $i=0; $i<count( $this->cart->cart ); $i++ ){ ?>{
						display_name:         		"<?php echo $this->cart->cart[$i]->title; ?>",
						sku:                  		"<?php echo $this->cart->cart[$i]->model_number; ?>",
						unit_price:           		<?php echo number_format( ( 100 * $this->cart->cart[$i]->unit_price ), 0, '', '' ); ?>,
						qty:                  		<?php echo $this->cart->cart[$i]->quantity; ?>,
						item_image_url:       		"<?php echo $this->cart->cart[$i]->get_image_url( ); ?>",
						item_url:             		"<?php echo $this->cart->cart[$i]->get_product_url( ); ?>"
					},<?php }?>],
					
					tax_amount:						<?php echo number_format( ( 100 * $this->order_totals->tax_total ), 0, '', '' ); ?>,
					shipping_amount:				<?php echo number_format( ( 100 * $this->order_totals->shipping_total ), 0, '', '' ); ?>
				
				});
				
				affirm.checkout.open( ); 
				
				}
			</script>
            
            <a href="https://www.affirm.com" target="_blank"><img src="<?php echo plugins_url('/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ). '/images/affirm-banner-540x200.png' ); ?>" alt="Affirm Split Pay" /></a>
        </div>
    </div>
    <?php }?>
    
	<?php if( $this->use_third_party( ) ){?>
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_third_party" value="third_party"<?php if( get_option( 'ec_option_default_payment_type' ) == "third_party" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?>
    </div>
    
    
    <div id="ec_third_party_form"<?php if( get_option( 'ec_option_default_payment_type' ) == "third_party" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_first' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_second' )?>
            
            <br />
			
			<?php if( get_option( 'ec_option_payment_third_party' ) == "paypal" ){ ?>
            	<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/paypal.jpg" ); ?>" alt="PayPal" />
            
            <?php }else if( get_option( 'ec_option_payment_third_party' ) == "skrill" ){ ?>
            	<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/skrill-logo.gif" ); ?>" alt="Skrill" />
            
			<?php } ?>
        
        </div>
    </div>
    <?php }?>
    
    <?php if( $this->use_payment_gateway( ) ){?>
    <div class="ec_cart_option_row">
		<input type="radio" name="ec_cart_payment_selection" id="ec_payment_credit_card" value="credit_card"<?php if( get_option( 'ec_option_default_payment_type' ) == "credit_card" ){ ?> checked="checked"<?php }?> onChange="ec_update_payment_display( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_credit_card' )?>
    </div>
    
    <div id="ec_credit_card_form"<?php if( get_option( 'ec_option_default_payment_type' ) == "credit_card" ){ ?> style="display:block;"<?php }?>>
    	<div class="ec_cart_box_section">
        	<div class="ec_cart_input_row">
				<?php if( get_option('ec_option_use_visa') || get_option('ec_option_use_delta') || get_option('ec_option_use_uke') ){ ?>
					<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/visa.png" ); ?>" alt="Visa" class="ec_card_active" id="ec_card_visa" />
                	<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/visa_inactive.png" ); ?>" alt="Visa" class="ec_card_inactive" id="ec_card_visa_inactive" />
            	<?php }?>
            
                <?php if( get_option('ec_option_use_discover') ){ ?>
                    <img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/discover.png" ); ?>" alt="Discover" class="ec_card_active" id="ec_card_discover" />
                    <img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/discover_inactive.png" ); ?>" alt="Discover" class="ec_card_inactive" id="ec_card_discover_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_mastercard') || get_option('ec_option_use_mcdebit') ){ ?>
                    <img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/mastercard.png"); ?>" alt="Mastercard" class="ec_card_active" id="ec_card_mastercard" />
					<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/mastercard_inactive.png"); ?>" alt="Mastercard" class="ec_card_inactive" id="ec_card_mastercard_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_amex') ){ ?>
                    <img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/american_express.png"); ?>" alt="AMEX" class="ec_card_active" id="ec_card_amex" />
					<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/american_express_inactive.png"); ?>" alt="AMEX" class="ec_card_inactive" id="ec_card_amex_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_jcb') ){ ?>
                    <img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/jcb.png"); ?>" alt="JCB" class="ec_card_active" id="ec_card_jcb" />
					<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/jcb_inactive.png"); ?>" alt="JCB" class="ec_card_inactive" id="ec_card_jcb_inactive" />
                <?php }?>
                
                <?php if( get_option('ec_option_use_diners') ){ ?>
                    <img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/diners.png"); ?>" alt="Diners" class="ec_card_active" id="ec_card_diners" />
					<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/diners_inactive.png"); ?>" alt="Diners" class="ec_card_inactive" id="ec_card_diners_inactive" />
            	<?php }?>
                
            	<?php if( get_option('ec_option_use_maestro') || get_option('ec_option_use_laser')){ ?>
                	<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/maestro.png"); ?>" alt="Maestro" class="ec_card_active" id="ec_card_maestro" />
					<img src="<?php echo plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/maestro_inactive.png"); ?>" alt="Maestro" class="ec_card_inactive" id="ec_card_maestro_inactive" />
            	<?php }?>
            </div>
            
			<?php $this->ec_cart_display_card_holder_name_hidden_input(); ?>
			<div class="ec_cart_input_row">
				<div class="ec_cart_input_left_half">
                	<label for="ec_card_number"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></label>
                	<?php $this->ec_cart_display_card_number_input( ); ?>
                	<div class="ec_cart_error_row" id="ec_card_number_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>
                    </div>
            	</div>
                <div class="ec_cart_input_right_half ec_small_field">
                	<label for="ec_security_code"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></label>
                	<?php $this->ec_cart_display_card_security_code_input( ); ?>
                	<div class="ec_cart_error_row" id="ec_security_code_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?>
                    </div>
            	</div>
            </div>
			<div class="ec_cart_input_row">
				<div class="ec_cart_input_left_half ec_small_field">
                	<label for="ec_expiration_month"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></label>
            		<?php $this->ec_cart_display_card_expiration_month_input( "MM" ); ?> <?php $this->ec_cart_display_card_expiration_year_input( "YYYY" ); ?>
                	<div class="ec_cart_error_row" id="ec_expiration_date_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?>
                    </div>
            	</div>
            </div>
        </div>
    </div>
    <?php }?>
    
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_review_title' )?>
    </div>
    
    <?php for( $cartitem_index = 0; $cartitem_index<count( $this->cart->cart ); $cartitem_index++ ){ ?>
    
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php $this->cart->cart[$cartitem_index]->display_title( ); ?><?php if( $this->cart->cart[$cartitem_index]->grid_quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->grid_quantity; ?><?php }else if( $this->cart->cart[$cartitem_index]->quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->quantity; ?><?php }?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_subtotal"><?php echo $this->cart->cart[$cartitem_index]->get_total( ); ?></div>
    </div>
    
    <?php }?>
    
    <div class="ec_cart_price_row ec_order_total">
        <div class="ec_cart_price_row_label"></div>
        <div class="ec_cart_price_row_total"><a href="<?php echo $this->cart_page; ?>"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_cart_link' ); ?></a></div>
    </div>
    
    <?php if( get_option( 'ec_option_user_order_notes' ) && isset( $_SESSION['ec_order_notes'] ) && strlen( $_SESSION['ec_order_notes'] ) > 0 ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
    	<?php echo $_SESSION['ec_order_notes']; ?>
    </div>
    <?php }?>
    
    <div id="ec_cart_payment_one_column">
    	<div class="ec_cart_header ec_top">
            <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->billing->first_name; ?> <?php echo $this->user->billing->last_name; ?>
        </div>
        
        <?php if( strlen( $this->user->billing->company_name ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo $this->user->billing->company_name; ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->billing->address_line_1; ?>
        </div>
        
        <?php if( strlen( $this->user->billing->address_line_2 ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo $this->user->billing->address_line_2; ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->billing->city; ?>, <?php echo $this->user->billing->state; ?> <?php echo $this->user->billing->zip; ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->billing->country_name; ?>
        </div>
        
        <?php if( strlen( $this->user->billing->phone ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo $this->user->billing->phone; ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_billing_link' ); ?></a>
        </div>
        
        <div class="ec_cart_header ec_top">
            <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_title' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->shipping->first_name; ?> <?php echo $this->user->shipping->last_name; ?>
        </div>
        
        <?php if( strlen( $this->user->shipping->company_name ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo $this->user->shipping->company_name; ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->shipping->address_line_1; ?>
        </div>
        
        <?php if( strlen( $this->user->shipping->address_line_2 ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo $this->user->shipping->address_line_2; ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->shipping->city; ?>, <?php echo $this->user->shipping->state; ?> <?php echo $this->user->shipping->zip; ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo $this->user->shipping->country_name; ?>
        </div>
        
        <?php if( strlen( $this->user->shipping->phone ) > 0 ){ ?>
        <div class="ec_cart_input_row">
            <?php echo $this->user->shipping->phone; ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_shipping_link' ); ?></a>
        </div>
        
        <div class="ec_cart_header">
            <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?> 
        </div>
        <div class="ec_cart_input_row">
            <strong><?php echo $this->shipping->get_selected_shipping_method( ); ?></strong>
        </div>
        <div class="ec_cart_input_row">
            <a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_shipping"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_shipping_method_link' ); ?></a>
        </div>
    </div>
    
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_totals_title' ); ?>
    </div>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_subtotal' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_subtotal"><?php echo $this->get_subtotal( ); ?></div>
    </div>
    <?php if( $this->tax->is_tax_enabled( ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_tax' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_tax"><?php echo $this->get_tax_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_use_shipping' ) && $this->cart->shipping_subtotal > 0 ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_shipping"><?php echo $this->get_shipping_total( ); ?></div>
    </div>
    <?php }?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_discounts' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_discount"><?php echo $this->get_discount_total( ); ?></div>
    </div>
    <?php if( $this->tax->is_duty_enabled( ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_duty' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_duty"><?php echo $this->get_duty_total( ); ?></div>
    </div>
    <?php }?>
    <?php if( $this->tax->is_vat_enabled( ) ){ ?>
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_vat' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_vat"><?php echo $this->get_vat_total_formatted( ); ?></div>
    </div>
    <?php }?>
    <div class="ec_cart_price_row ec_order_total">
        <div class="ec_cart_price_row_label"><?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_grand_total' )?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_total"><?php echo $this->get_grand_total( ); ?></div>
    </div>
		
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>
    </div>
    
    <div class="ec_cart_error_row" id="ec_terms_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_accept_terms' )?> 
    </div>
    <div class="ec_cart_input_row">
		<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?>
    </div>
	<?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?>
    <div class="ec_cart_input_row ec_agreement_section">
        <input type="checkbox" name="ec_terms_agree" id="ec_terms_agree" value="1"  /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_agree' )?>
    </div>
    <?php }else{ ?>
    	<input type="hidden" name="ec_terms_agree" id="ec_terms_agree" value="2"  />
    <?php }?>
    
    
    <div class="ec_cart_error_row" id="ec_submit_order_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_correct_errors' )?> 
    </div>
                    
    <div class="ec_cart_button_row">
        <input type="submit" value="SUBMIT ORDER" class="ec_cart_button" id="ec_cart_submit_order" onclick="return ec_validate_submit_order( );" />
        <input type="submit" value="PLEASE WAIT" class="ec_cart_button_working" id="ec_cart_submit_order_working" />
    </div>
</div>

<?php $this->display_page_three_form_end( ); ?>

<div class="ec_cart_right" id="ec_cart_payment_hide_column">
    
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->billing->first_name; ?> <?php echo $this->user->billing->last_name; ?>
    </div>
    
    <?php if( strlen( $this->user->billing->company_name ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo $this->user->billing->company_name; ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->billing->address_line_1; ?>
    </div>
    
    <?php if( strlen( $this->user->billing->address_line_2 ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo $this->user->billing->address_line_2; ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->billing->city; ?>, <?php echo $this->user->billing->state; ?> <?php echo $this->user->billing->zip; ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->billing->country_name; ?>
    </div>
    
    <?php if( strlen( $this->user->billing->phone ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo $this->user->billing->phone; ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_billing_link' ); ?></a>
    </div>
    
    <?php if( get_option( 'ec_option_use_shipping' ) && $this->cart->shipping_subtotal > 0 ){ ?>
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->shipping->first_name; ?> <?php echo $this->user->shipping->last_name; ?>
    </div>
    
    <?php if( strlen( $this->user->shipping->company_name ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo $this->user->shipping->company_name; ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->shipping->address_line_1; ?>
    </div>
    
    <?php if( strlen( $this->user->shipping->address_line_2 ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo $this->user->shipping->address_line_2; ?>
    </div>
    <?php }?>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->shipping->city; ?>, <?php echo $this->user->shipping->state; ?> <?php echo $this->user->shipping->zip; ?>
    </div>
    
    <div class="ec_cart_input_row">
    	<?php echo $this->user->shipping->country_name; ?>
    </div>
    
    <?php if( strlen( $this->user->shipping->phone ) > 0 ){ ?>
    <div class="ec_cart_input_row">
    	<?php echo $this->user->shipping->phone; ?>
    </div>
    <?php }?>
    
    <?php $this->display_page_two_form_start( ); ?>
    <div class="ec_cart_input_row">
    	<a href="<?php echo $this->cart_page . $this->permalink_divider; ?>ec_page=checkout_info"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_edit_shipping_link' ); ?></a>
    </div>
    <?php }?>
    
    <?php if( get_option( 'ec_option_use_shipping' ) && $this->cart->shipping_subtotal > 0 ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
        <strong><?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?></strong>
    </div>
    
    <div class="ec_cart_button_row">
        <input type="submit" value="Update Shipping" class="ec_cart_button" />
    </div>
    <?php $this->display_page_two_form_end( ); ?>
    <?php } // Close if for shipping ?>
    
</div>