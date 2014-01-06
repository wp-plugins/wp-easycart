<div class="ec_cart_payment_information_holder">

	<div class="ec_cart_payment_information_title"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_title' )?></div>
	
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
                <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_credit_card' )?></div>
                <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_payment_method_input( "Select One" ); ?></div>
                
            </div>
            <div class="ec_cart_payment_information_row" id="ec_card_holder_name_row">
                <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_holder_name' )?></div>
                <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_card_holder_name_input(); ?></div>
            </div>
            <div class="ec_cart_payment_information_row" id="ec_card_number_row">
                <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></div>
                <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_card_number_input(); ?></div>
            </div>
            <div class="ec_cart_payment_information_row" id="ec_expiration_date_row">
                <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></div>
                <div class="ec_cart_payment_information_expiration_input"><?php $this->ec_cart_display_card_expiration_month_input( "MM" ); ?><?php $this->ec_cart_display_card_expiration_year_input( "YYYY" ); ?></div>
            </div>
            <div class="ec_cart_payment_information_row" id="ec_security_code_row">
                <div class="ec_cart_payment_information_label"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></div>
                <div class="ec_cart_payment_information_input"><?php $this->ec_cart_display_card_security_code_input(); ?></div>
            </div>
        </div>
    </div>
    <?php }?>
</div>