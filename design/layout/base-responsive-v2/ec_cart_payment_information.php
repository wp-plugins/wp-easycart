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