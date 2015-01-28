<?php 

if( $this->should_display_cart( ) ){ 

?>

<section class="ec_cart_page">
	
    <div class="ec_cart_breadcrumbs">
    	<div class="ec_cart_breadcrumb<?php if( isset( $_GET['ec_page'] ) ){?> ec_inactive<?php }?>"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_title' ); ?></div>
        <div class="ec_cart_breadcrumb_divider"></div>
        <div class="ec_cart_breadcrumb<?php if( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] != "checkout_info" ) ){?> ec_inactive<?php }?>"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_checkout_details_title' ); ?></div>
        <div class="ec_cart_breadcrumb_divider"></div>
        <div class="ec_cart_breadcrumb<?php if( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] != "checkout_payment" ) ){?> ec_inactive<?php }?>"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_submit_payment_title' ); ?></div>
    </div>
    
    <?php if( !isset( $_GET['ec_page'] ) ){ ?>

	<div class="ec_cart_left ec_cart_holder">
    	<table class="ec_cart" cellspacing="0">
            <thead>
                <tr>
                    <th class="ec_cartitem_head_name" colspan="3"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column1' )?></th>
                    <th class="ec_cartitem_head_price"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column3' )?></th>
                    <th class="ec_cartitem_head_quantity"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column4' )?></th>
                    <th class="ec_cartitem_head_total"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_header_column5' )?></th>
                </tr>
            </thead>
            
            <tbody>
                <?php for( $cartitem_index = 0; $cartitem_index<count( $this->cart->cart ); $cartitem_index++ ){ ?>
                <tr class="ec_cartitem_error_row" id="ec_cartitem_max_error_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>">
                	<td colspan="6"><?php echo $GLOBALS['language']->get_text( 'cart', 'cartitem_max_error' )?></td>
                </tr>
                
                <tr class="ec_cartitem_error_row" id="ec_cartitem_min_error_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>">
                	<td colspan="6"><?php echo $GLOBALS['language']->get_text( 'cart', 'cartitem_min_error' )?></td>
                </tr>
                
                <tr class="ec_cartitem_row" id="ec_cartitem_row_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>">
                    <td class="ec_cartitem_remove_column">
                    	<div class="ec_cartitem_delete" id="ec_cartitem_delete_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>" onclick="ec_cartitem_delete( '<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>', '<?php echo $this->cart->cart[$cartitem_index]->model_number; ?>' );"></div>
                    	<div class="ec_cartitem_deleting" id="ec_cartitem_deleting_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>"></div>
                    </td>
                    <td class="ec_cartitem_image"><img src="<?php echo $this->cart->cart[$cartitem_index]->get_image_url( ); ?>" alt="<?php echo $this->cart->cart[$cartitem_index]->title; ?>" /></td>
                    <td class="ec_cartitem_details">
                        <a href="<?php echo $this->cart->cart[$cartitem_index]->get_title_link( ); ?>" class="ec_cartitem_title"><?php $this->cart->cart[$cartitem_index]->display_title( ); ?></a>
                        <?php if( $this->cart->cart[$cartitem_index]->optionitem1_name ){ ?>
                            <dl>
                                <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem1_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem1_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem1_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem1_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem1_price ); ?> )<?php } ?></dt>
                            
                            <?php if( $this->cart->cart[$cartitem_index]->optionitem2_name ){ ?>
                                <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem2_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem2_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem2_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem2_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem2_price ); ?> )<?php } ?></dt>
                            <?php }?>
                            
                            <?php if( $this->cart->cart[$cartitem_index]->optionitem3_name ){ ?>
                                <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem3_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem3_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem3_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem3_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem3_price ); ?> )<?php } ?></dt>
                            <?php }?>
                            
                            <?php if( $this->cart->cart[$cartitem_index]->optionitem4_name ){ ?>
                                <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem4_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem4_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem4_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem4_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem4_price ); ?> )<?php } ?></dt>
                            <?php }?>
                            
                            <?php if( $this->cart->cart[$cartitem_index]->optionitem5_name ){ ?>
                                <dt><?php echo $this->cart->cart[$cartitem_index]->optionitem5_name; ?><?php if( $this->cart->cart[$cartitem_index]->optionitem5_price > 0 ){ ?> ( +<?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem5_price ); ?> )<?php }else if( $this->cart->cart[$cartitem_index]->optionitem5_price < 0 ){ ?> ( <?php echo $GLOBALS['currency']->get_currency_display( $this->cart->cart[$cartitem_index]->optionitem5_price ); ?> )<?php } ?></dt>
                            <?php }?>
                            </dl>
                        <?php }?>
                        
                        <?php if( $this->cart->cart[$cartitem_index]->use_advanced_optionset ){ ?>
                        <dl>
                        	<?php foreach( $this->cart->cart[$cartitem_index]->advanced_options as $advanced_option_set ){ ?>
								<?php if( $advanced_option_set->option_type == "grid" ){ ?>
                                <dt><?php echo $advanced_option_set->optionitem_name; ?>: <?php echo $advanced_option_set->optionitem_value; ?><?php if( $advanced_option_set->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_override ) . ')'; } ?></dt>
                                <?php }else{ ?>
                                <dt><?php echo $advanced_option_set->option_label; ?>: <?php echo htmlspecialchars( $advanced_option_set->optionitem_value, ENT_QUOTES ); ?><?php if( $advanced_option_set->optionitem_price > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_item_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime > 0 ){ echo ' (+' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_onetime < 0 ){ echo ' (' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_onetime ) . ' ' . $GLOBALS['language']->get_text( 'cart', 'cart_order_adjustment' ) . ')'; }else if( $advanced_option_set->optionitem_price_override > -1 ){ echo ' (' . $GLOBALS['language']->get_text( 'cart', 'cart_item_new_price_option' ) . ' ' . $GLOBALS['currency']->get_currency_display( $advanced_option_set->optionitem_price_override ) . ')'; } ?></dt>
                            	<?php } ?>
							<?php }?>
                        </dl>
                        <?php }?>
                        
                        <?php if( $this->cart->cart[$cartitem_index]->is_giftcard ){ ?>
                        <dl>
                        	<dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_name' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_to_name, ENT_QUOTES ); ?></dt>
                        	<dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_recipient_email' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_email, ENT_QUOTES ); ?></dt>
                        	<dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_sender_name' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_from_name, ENT_QUOTES ); ?></dt>
                        	<dt><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_gift_card_message' ); ?>: <?php echo htmlspecialchars( $this->cart->cart[$cartitem_index]->gift_card_message, ENT_QUOTES ); ?></dt>
                        </dl>
                        <?php }?>
                        
                        <?php if( $this->cart->cart[$cartitem_index]->is_deconetwork ){ ?>
                        <dl>
                        	<dt><?php echo str_replace( "<br/><br/>", "<br/>", $this->cart->cart[$cartitem_index]->deconetwork_options ); ?></dt>
							<dt><?php echo "<a href=\"https://" . get_option( 'ec_option_deconetwork_url' ) . $this->cart->cart[$cartitem_index]->deconetwork_edit_link . "\">" . $GLOBALS['language']->get_text( 'cart', 'deconetwork_edit' ) . "</a>"; ?></dt>
                        </dl>
                        <?php }?>
                    </td>
                    </td>
                    <td class="ec_cartitem_price" id="ec_cartitem_price_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>"><?php echo $this->cart->cart[$cartitem_index]->get_unit_price( ); ?></td>
                    <td class="ec_cartitem_quantity">
                    	<?php if( $this->cart->cart[$cartitem_index]->grid_quantity > 0 ){ ?>
                        	<?php echo $this->cart->cart[$cartitem_index]->grid_quantity; ?>
                        <?php }else if( $this->cart->cart[$cartitem_index]->is_deconetwork ){ ?>
                        	<?php echo $this->cart->cart[$cartitem_index]->quantity; ?>
                        <?php }else{ ?>
                        <div class="ec_cartitem_updating" id="ec_cartitem_updating_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>"></div>
                        <table class="ec_cartitem_quantity_table">
                        	<tbody>
                            	<tr>
                                	<td class="ec_minus_column">
                        				<input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>' );" /></td>
                        			<td class="ec_quantity_column"><input type="number" value="<?php echo $this->cart->cart[$cartitem_index]->quantity; ?>" id="ec_quantity_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>" autocomplete="off" step="1" min="<?php if( $this->cart->cart[$cartitem_index]->min_purchase_quantity > 0 ){ echo $this->cart->cart[$cartitem_index]->min_purchase_quantity; }else{ echo '1'; } ?>" class="ec_quantity" /></td>
                        			<td class="ec_plus_column"><input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>' );" /></td>
                                </tr>
                                <tr>
                                	<td colspan="3"><div class="ec_cartitem_update_button" id="ec_cartitem_update_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>" onclick="ec_cartitem_update( '<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>', '<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>' );">UPDATE</div></td>
                                </tr>
                            </tbody>
                        </table>
						<?php }?>
                    </td>
                    <td class="ec_cartitem_total" id="ec_cartitem_total_<?php echo $this->cart->cart[$cartitem_index]->cartitem_id; ?>"><?php echo $this->cart->cart[$cartitem_index]->get_total( ); ?></td>
                </tr>
                <?php }?>
            </tbody>
    	</table>
    </div>
    <div class="ec_cart_right">
    	<div class="ec_cart_header ec_top">
        	Cart Totals
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
        <div class="ec_cart_button_row">
        	<a class="ec_cart_button" href="<?php echo $this->cart_page . $this->permalink_divider . "ec_page=checkout_info"; ?>"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_checkout' ); ?></a>
        </div>
        <div class="ec_cart_button_row">
        	<a class="ec_cart_button" href="<?php echo $this->store_page;?>"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_continue_shopping' ); ?></a>
        </div>
        <?php if( get_option( 'ec_option_show_coupons' ) ){ ?>
        <div class="ec_cart_header">
        	<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_title' )?>
        </div>
        <div class="ec_cart_error_message" id="ec_coupon_error"></div>
        <div class="ec_cart_success_message" id="ec_coupon_success"<?php if( isset( $this->coupon ) ){?> style="display:block;"<?php }?>><?php if( isset( $this->coupon ) ){ echo $this->coupon->message; } ?></div>
        <div class="ec_cart_input_row">
        	<input type="text" name="ec_coupon_code" id="ec_coupon_code" value="<?php if( isset( $this->coupon ) ){ echo $this->coupon_code; } ?>" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_enter_coupon' )?>" />
        </div>
        <div class="ec_cart_button_row">
        	<div class="ec_cart_button" id="ec_apply_coupon" onclick="ec_apply_coupon( );"><?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_apply_coupon' ); ?></div>
            <div class="ec_cart_button_working" id="ec_applying_coupon"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' )?></div>
        </div>
        <?php }?>
        <?php if( get_option( 'ec_option_show_giftcards' ) ){ ?>
        <div class="ec_cart_header">
        	<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_gift_card_title' )?>
        </div>
        <div class="ec_cart_error_message" id="ec_gift_card_error"></div>
        <div class="ec_cart_success_message" id="ec_gift_card_success"<?php if( $this->gift_card != "" ){?> style="display:block;"<?php }?>><?php if( $this->gift_card != "" ){ echo $this->giftcard->message; } ?></div>
        <div class="ec_cart_input_row">
        	<input type="text" name="ec_gift_card" id="ec_gift_card" value="<?php echo $this->gift_card; ?>" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_enter_gift_code' )?>" />
        </div>
        <div class="ec_cart_button_row">
        	<div class="ec_cart_button" id="ec_apply_gift_card" onclick="ec_apply_gift_card( );"><?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_redeem_gift_card' ); ?></div>
            <div class="ec_cart_button_working" id="ec_applying_gift_card"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' )?></div>
        </div>
        <?php }?>
        
        <?php if( get_option( 'ec_option_use_estimate_shipping' ) ){ ?>
        	<?php if( get_option( 'ec_option_use_shipping' ) && $this->cart->shipping_subtotal > 0 ){ ?>
        	<div class="ec_cart_header">
        		<?php echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_button' )?>
        	</div>
			<?php if( get_option( 'ec_option_estimate_shipping_country' ) ){ ?>
            <div class="ec_cart_input_row">
                <?php $this->display_estimate_shipping_country_select( ); ?>
            </div>
            <?php }?>
            <div class="ec_cart_input_row">
                <input type="text" name="ec_estimate_zip" id="ec_estimate_zip" value="<?php if( isset( $_SESSION['ec_temp_zipcode'] ) ){ echo htmlspecialchars( $_SESSION['ec_temp_zipcode'], ENT_QUOTES ); } ?>" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_hint' )?>" />
            </div>
            <div class="ec_cart_button_row">
                <div class="ec_cart_button" id="ec_estimate_shipping" onclick="ec_estimate_shipping( );"><?php echo $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_button' ); ?></div>
                <div class="ec_cart_button_working" id="ec_estimating_shipping"><?php echo $GLOBALS['language']->get_text( 'cart', 'cart_please_wait' )?></div>
            </div>
        	<?php }?>
        <?php }?>
        
    </div>
    <?php } ?>
    
</section>

<?php }// close should display cart ?>