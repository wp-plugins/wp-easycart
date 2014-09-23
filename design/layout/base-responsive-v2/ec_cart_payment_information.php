<div class="ec_cart_payment_information_holder">

	<div class="ec_cart_payment_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_title' )?></div>
	
    <ul class="ec_cart_error" id="ec_cart_payment_error_text">
    	<li id="ec_cart_error_payment_card_type" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_type' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        
        <li id="ec_cart_error_payment_card_holder_name" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_holder_name' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        
        <li id="ec_cart_error_payment_card_number" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_number' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
         
        <li id="ec_cart_error_payment_card_number_error" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_number_error' ); ?></strong>.</li>
        
        <li id="ec_cart_error_payment_card_exp_month" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_exp_month' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        
        <li id="ec_cart_error_payment_card_exp_year" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_exp_year' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
        
        <li id="ec_cart_error_payment_card_code" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_card_code' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_is_required' ); ?>.</li>
    </ul>
    
	<?php if( $this->use_manual_payment( ) ){?>
    <div class="ec_cart_payment_information_payment_type_row">
    	<div class="ec_inner_padding"><input type="radio" value="manual_bill" name="ec_cart_payment_selection" onchange="ec_cart_update_payment_type( 'manual_bill' );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_manual_payment' )?></div>
    </div>
    <div class="ec_cart_payment_information_payment_type_holder" id="ec_cart_pay_by_manual_payment"> 
    	<div class="ec_inner_padding">
	        <?php $this->display_manual_payment_text( ); ?>
    	</div>
    </div>
    <?php }?>
    
    <?php if( get_option( 'ec_option_use_affirm' ) ){ ?>
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
				display_name:         "<?php echo $this->cart->cart[$i]->title; ?>",
				sku:                  "<?php echo $this->cart->cart[$i]->model_number; ?>",
				unit_price:           <?php echo number_format( ( 100 * $this->cart->cart[$i]->unit_price ), 0, '', '' ); ?>,
				qty:                  <?php echo $this->cart->cart[$i]->quantity; ?>,
				item_image_url:       "<?php echo $this->cart->cart[$i]->get_image_url( ); ?>",
				item_url:             "<?php echo $this->cart->cart[$i]->get_product_url( ); ?>"
			},<?php }?>],
			
			tax_amount:						<?php echo number_format( ( 100 * $this->order_totals->tax_total ), 0, '', '' ); ?>,
			shipping_amount:				<?php echo number_format( ( 100 * $this->order_totals->shipping_total ), 0, '', '' ); ?>
		
		});
		
		affirm.checkout.open( ); 
		
		}
	</script>
    
    <div class="ec_cart_payment_information_payment_type_row">
    	<div class="ec_inner_padding"><input type="radio" value="affirm" name="ec_cart_payment_selection" onchange="ec_cart_update_payment_type( 'affirm' );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_affirm' )?></div>
    </div>
    <div class="ec_cart_payment_information_payment_type_holder" id="ec_cart_pay_by_affirm"> 
    	<div class="ec_inner_padding">
	        <a href="https://www.affirm.com" target="_blank"><img src="<?php echo plugins_url('/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ). '/affirm-banner-540x200.png' ); ?>" alt="Affirm Split Pay" /></a>
    	</div>
    </div>
    <?php }?>
    
    <?php if( $this->use_third_party( ) ){?>
    <div class="ec_cart_payment_information_payment_type_row">
    	<div class="ec_inner_padding"><input type="radio" value="third_party" name="ec_cart_payment_selection" onchange="ec_cart_update_payment_type( 'third_party' );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?></div>
    </div>
    <div class="ec_cart_payment_information_payment_type_holder" id="ec_cart_pay_by_third_party"> 
    	<div class="ec_inner_padding">
	        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_first' )?> <?php $this->ec_cart_display_current_third_party_name( ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_third_party_second' )?><br /><br />
            <?php $this->ec_cart_display_third_party_logo( ); ?>
        </div>
    </div>
    <?php }?>
    <?php if( $this->use_payment_gateway( ) ){?>
    <div class="ec_cart_payment_information_payment_type_row">
    	<div class="ec_inner_padding"><input type="radio" value="credit_card" name="ec_cart_payment_selection" onchange="ec_cart_update_payment_type( 'credit_card' );" /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_credit_card' )?></div>
    </div>
    <div class="ec_cart_payment_information_payment_type_holder" id="ec_cart_pay_by_credit_card_holder">
    	<div class="ec_inner_padding">
            <div class="ec_cart_payment_information_row" id="ec_cart_payment_type_row">
                
                <?php $this->ec_cart_display_credit_card_images( ); ?>
                <?php $this->ec_cart_display_card_holder_name_hidden_input(); ?>
            </div>
            <div class="ec_cart_payment_information_row">
            	
                <div class="ec_cart_payment_information_row">
                	<div class="ec_cart_payment_information_credit_card_label" id="ec_card_number_row"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></div>
                	<div class="ec_cart_payment_information_security_code_label" id="ec_security_code_row"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></div>
               	</div>
                
                <div class="ec_cart_payment_information_row">
               		<div class="ec_cart_payment_information_card_number_input"><?php $this->ec_cart_display_card_number_input(); ?></div>
                	<div class="ec_cart_payment_information_security_code_input"><?php $this->ec_cart_display_card_security_code_input(); ?></div>
                </div>
                
            </div>
            <div class="ec_cart_payment_information_row" id="ec_expiration_date_row">
                <div class="ec_cart_payment_information_exp_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></div>
                <div class="ec_cart_payment_information_exp_month_input"><?php $this->ec_cart_display_card_expiration_month_input( "MM" ); ?></div><div class="ec_cart_payment_information_exp_year_input"><?php $this->ec_cart_display_card_expiration_year_input( "YYYY" ); ?></div>
            </div>
        </div>
    </div>
    <?php }?>
</div>