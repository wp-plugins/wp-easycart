<?php $this->display_page_one_form_start(); ?>
        
<div class="ec_cart_left">
    <?php if( !isset( $_SESSION['ec_user_id'] ) ){ ?>
    <div class="ec_cart_header ec_top">
        <input type="checkbox" name="ec_login_selector" id="ec_login_selector" value="login" onchange="ec_cart_toggle_login( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_title' ); ?>
    </div>
    <div id="ec_user_login_form">
        
        <div class="ec_cart_input_row">
            <label for="ec_cart_login_email"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_email_label' ); ?>*</label>
            <input type="text" id="ec_cart_login_email" name="ec_cart_login_email" novalidate />
        </div>
        <div class="ec_cart_error_row" id="ec_cart_login_email_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_email_label' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_cart_login_password"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_password_label' ); ?>*</label>
            <input type="password" id="ec_cart_login_password" name="ec_cart_login_password" />
        </div>
        <div class="ec_cart_error_row" id="ec_cart_login_password_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_password_label' ); ?>
        </div>
        
        <div class="ec_cart_button_row">
            <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_button' ); ?>" class="ec_cart_button" onclick="return ec_validate_cart_login( );" />
        </div>
    </div>
    
    <?php }else{ // close section for NON logged in user ?>
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_title' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
        <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text' ); ?> <?php echo htmlspecialchars( $this->user->first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $this->user->last_name, ENT_QUOTES ); ?>, <a href="<?php echo $this->cart_page . $this->permalink_divider . "ec_cart_action=logout"; ?>"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_logout_link' ); ?></a> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text2' ); ?>
    </div>
    <?php }?>

    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
    </div>
    <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
    <div class="ec_cart_input_row">
        <label for="ec_cart_billing_country"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>*</label>
        <?php $this->display_billing_input( "country" ); ?>
        <div class="ec_cart_error_row" id="ec_cart_billing_country_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>
        </div>
    </div>
    <?php }?>
    <div class="ec_cart_input_row">
        <div class="ec_cart_input_left_half">
            <label for="ec_cart_billing_first_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_first_name' ); ?>*</label>
            <?php $this->display_billing_input( "first_name" ); ?>
        	<div class="ec_cart_error_row" id="ec_cart_billing_first_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_first_name' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_right_half">
            <label for="ec_cart_billing_last_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_last_name' ); ?>*</label>
            <?php $this->display_billing_input( "last_name" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_billing_last_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_last_name' ); ?>
            </div>
        </div>
    </div>
    <?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
    <div class="ec_cart_input_row">
        <label for="ec_cart_billing_company_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_company_name' ); ?></label>
        <?php $this->display_billing_input( "company_name" ); ?>
    </div>
    <?php }?>
    <div class="ec_cart_input_row">
        <label for="ec_cart_billing_address"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address' ); ?>*</label>
        <?php $this->display_billing_input( "address" ); ?>
    </div>
    <div class="ec_cart_error_row" id="ec_cart_billing_address_error">
		<?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address' ); ?>
    </div>
    <?php if( get_option( 'ec_option_use_address2' ) ){ ?>
    <div class="ec_cart_input_row">
        <?php $this->display_billing_input( "address2" ); ?>
    </div>
    <?php }?>
    <div class="ec_cart_input_row">
        <label for="ec_cart_billing_city"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_city' ); ?>*</label>
        <?php $this->display_billing_input( "city" ); ?>
        <div class="ec_cart_error_row" id="ec_cart_billing_city_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_city' ); ?>
        </div>
    </div>
    <div class="ec_cart_input_row">
        <div class="ec_cart_input_left_half">
            <label for="ec_cart_billing_state"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_state' ); ?><span id="ec_billing_state_required">*</span></label>
            <?php $this->display_billing_input( "state" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_billing_state_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_state' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_right_half">
            <label for="ec_cart_billing_zip"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_zip' ); ?>*</label>
            <?php $this->display_billing_input( "zip" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_billing_zip_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_zip' ); ?>
            </div>
        </div>
    </div>
    <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
    <div class="ec_cart_input_row">
        <label for="ec_cart_billing_country"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>*</label>
        <?php $this->display_billing_input( "country" ); ?>
        <div class="ec_cart_error_row" id="ec_cart_billing_country_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>
        </div>
    </div>
    <?php }?>
    <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
    <div class="ec_cart_input_row">
        <label for="ec_cart_billing_phone"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' ); ?>*</label>
        <?php $this->display_billing_input( "phone" ); ?>
        <div class="ec_cart_error_row" id="ec_cart_billing_phone_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' ); ?>
        </div>
    </div>
    <?php }?>
    
    <?php if( get_option( 'ec_option_use_shipping' ) && $this->cart->shipping_subtotal > 0 ){ ?>
    <div class="ec_cart_header">
        <input type="checkbox" name="ec_shipping_selector" id="ec_shipping_selector" value="true" onchange="ec_update_shipping_view( );"<?php if( isset( $_SESSION['ec_shipping_selector'] ) && $_SESSION['ec_shipping_selector'] == "true" ){?> checked="checked"<?php }?> /> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_ship_to_different' ); ?>
    </div>
    <div id="ec_shipping_form"<?php if( isset( $_SESSION['ec_shipping_selector'] ) && $_SESSION['ec_shipping_selector'] == "true" ){?> style="display:block;"<?php }?>>
        <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_shipping_country"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>*</label>
            <?php $this->display_shipping_input( "country" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_shipping_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>
            </div>
        </div>
        <?php }?>
        <div class="ec_cart_input_row">
            <div class="ec_cart_input_left_half">
                <label for="ec_cart_shipping_first_name"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_first_name' ); ?>*</label>
                <?php $this->display_shipping_input( "first_name" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_first_name_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_first_name' ); ?>
                </div>
            </div>
            <div class="ec_cart_input_right_half">
                <label for="ec_cart_shipping_last_name"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_last_name' ); ?>*</label>
                <?php $this->display_shipping_input( "last_name" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_last_name_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_last_name' ); ?>
                </div>
            </div>
        </div>
    	<?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_shipping_company_name"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_company_name' ); ?></label>
            <?php $this->display_shipping_input( "company_name" ); ?>
        </div>
        <?php }?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_shipping_address"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_address' ); ?>*</label>
            <?php $this->display_shipping_input( "address" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_shipping_address_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_address' ); ?>
            </div>
        </div>
        <?php if( get_option( 'ec_option_use_address2' ) ){ ?>
    	<div class="ec_cart_input_row">
            <?php $this->display_shipping_input( "address2" ); ?>
        </div>
        <?php }?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_shipping_city"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_city' ); ?>*</label>
            <?php $this->display_shipping_input( "city" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_shipping_city_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_city' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_row">
            <div class="ec_cart_input_left_half">
                <label for="ec_cart_shipping_state"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_state' ); ?><span id="ec_shipping_state_required">*</span></label>
                <?php $this->display_shipping_input( "state" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_state_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_state' ); ?>
                </div>
            </div>
            <div class="ec_cart_input_right_half">
                <label for="ec_cart_shipping_zip"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_zip' ); ?>*</label>
                <?php $this->display_shipping_input( "zip" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_zip_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_zip' ); ?>
                </div>
            </div>
        </div>
        <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_shipping_country"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>*</label>
            <?php $this->display_shipping_input( "country" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_shipping_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>
            </div>
        </div>
        <?php }?>
    	<?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_shipping_phone"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_phone' ); ?>*</label>
            <?php $this->display_shipping_input( "phone" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_shipping_phone_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_phone' ); ?>
            </div>
        </div>
        <?php }?>
    </div>
    
    <?php }?>
    
    <?php if( !isset( $_SESSION['ec_user_id'] ) ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' ); ?>
    </div>
    
    <div class="ec_cart_input_row">
        <label for="ec_contact_email"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' ); ?>*</label>
        <?php $this->ec_cart_display_contact_email_input(); ?>
        <div class="ec_cart_error_row" id="ec_contact_email_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' ); ?>
        </div>
    </div>
    
    <div class="ec_cart_input_row">
        <label for="ec_contact_email_retype"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_email' ); ?>*</label>
        <?php $this->ec_cart_display_contact_email_retype_input(); ?>
        <div class="ec_cart_error_row" id="ec_contact_email_retype_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_emails_do_not_match' ); ?>
        </div>
    </div>
    <?php }?>
    
	<?php if( !isset( $_SESSION['ec_email'] ) || 
			  ( isset( $_SESSION['ec_is_guest'] ) && $_SESSION['ec_is_guest'] ) || 
			  ( !$this->user->user_id )
			){ ?>
    
    <div class="ec_cart_header">
        <?php if( get_option( 'ec_option_allow_guest' ) && !$this->has_downloads ){ ?><input type="checkbox" name="ec_create_account_selector" id="ec_create_account_selector" value="create_account" onchange="ec_toggle_create_account( );" /> <?php }else{ ?><input type="hidden" name="ec_create_account_selector" id="ec_create_account_selector" value="create_account" /><?php }?><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_create_account' ); ?>
    </div>
    <?php if( get_option( 'ec_option_allow_guest' ) && !$this->has_downloads ){ ?><div id="ec_user_create_form"><?php }?>
        <?php if( get_option( 'ec_option_use_contact_name' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_contact_first_name"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_first_name' ); ?>*</label>
            <?php $this->ec_cart_display_contact_first_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_first_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_first_name' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_row">
            <label for="ec_contact_last_name"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_last_name' ); ?>*</label>
            <?php $this->ec_cart_display_contact_last_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_last_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_last_name' ); ?>
            </div>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <label for="ec_contact_password"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_password' ); ?>*</label>
            <?php $this->ec_cart_display_contact_password_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_password_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_length_error' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_row">
            <label for="ec_contact_password_retype"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_password' ); ?>*</label>
            <?php $this->ec_cart_display_contact_password_retype_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_password_retype_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_passwords_do_not_match' ); ?>
            </div>
        </div>
    <?php if( get_option( 'ec_option_allow_guest' ) && !$this->has_downloads ){ ?></div><?php }?>
    <?php } ?>
    <?php if( get_option( 'ec_option_user_order_notes' ) ){ ?>
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?>
    </div>
    <div class="ec_cart_input_row">
    	<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_message' ); ?>
        <textarea name="ec_order_notes" id="ec_order_notes"><?php if( isset( $_SESSION['ec_order_notes'] ) ){ echo htmlspecialchars( $_SESSION['ec_order_notes'], ENT_QUOTES ); } ?></textarea>
    </div>
    <?php }?>
</div>

<div class="ec_cart_right">
    
    <div class="ec_cart_header ec_top">
        <?php echo $GLOBALS['language']->get_text( 'cart', 'your_cart_title' ); ?>
    </div>
    
    <?php for( $cartitem_index = 0; $cartitem_index<count( $this->cart->cart ); $cartitem_index++ ){ ?>
    
    <div class="ec_cart_price_row">
        <div class="ec_cart_price_row_label"><?php $this->cart->cart[$cartitem_index]->display_title( ); ?><?php if( $this->cart->cart[$cartitem_index]->grid_quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->grid_quantity; ?><?php }else if( $this->cart->cart[$cartitem_index]->quantity > 1 ){ ?> x <?php echo $this->cart->cart[$cartitem_index]->quantity; ?><?php }?></div>
        <div class="ec_cart_price_row_total" id="ec_cart_subtotal"><?php echo $this->cart->cart[$cartitem_index]->get_total( ); ?></div>
    </div>
    
    <?php }?>
    
    <div class="ec_cart_header">
        <?php echo $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_title' ); ?>
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
    
    <div class="ec_cart_error_row" id="ec_checkout_error">
        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_checkout_details_errors' )?>
    </div>
    
    <div class="ec_cart_button_row">
        <input type="submit" value="<?php if( get_option( 'ec_option_skip_shipping_page' ) || $this->cart->shipping_subtotal <= 0 ){ ?><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_continue_payment' ); ?><?php }else{ ?><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_continue_shipping' ); ?><?php }?>" class="ec_cart_button" onclick="return ec_validate_cart_details( );" />
    </div>
    
</div>

<?php $this->display_page_one_form_end(); ?>