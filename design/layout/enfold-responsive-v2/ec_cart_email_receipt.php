<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type='text/css'>
    <!--
		.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
        .style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
		.ec_option_label{font-family: Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; }
		.ec_option_name{font-family: Arial, Helvetica, sans-serif; font-size:11px; }
	-->
    </style>
</head>
<body>
    <table width='539' border='0' align='center'>
        <tr>
            <td colspan='4' align='left' class='style22'>
                <img src='<?php echo $email_logo_url; ?>'>
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
				<p><br><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_1" ) . " " . $this->user->billing->first_name . " " . $this->user->billing->last_name; ?>:</p>
                <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_2" ); ?> <strong><?php echo $this->order_id; ?></strong></p>
                <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_3" ); ?></p>
                <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_4" ); ?><br><br><br></p>
            </td>
        </tr>
        <tr>
        	<td colspan='4' align='left' class='style20'>
            	<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
                	<tr>
                    	<td width='47%' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_billing_label" ); ?></td>
                        <td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'><?php if( get_option( 'ec_option_use_shipping' ) ){?><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_shipping_label" ); ?><?php }?></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $this->user->billing->first_name; ?> <?php echo $this->user->billing->last_name; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'><?php if( get_option( 'ec_option_use_shipping' ) ){?><?php echo $this->user->shipping->first_name; ?> <?php echo $this->user->shipping->last_name; ?><?php }?></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $this->user->billing->address_line_1; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'><?php if( get_option( 'ec_option_use_shipping' ) ){?><?php echo $this->user->shipping->address_line_1; ?><?php }?></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $this->user->billing->city; ?>, <?php echo $this->user->billing->state; ?> <?php echo $this->user->billing->zip; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'><?php if( get_option( 'ec_option_use_shipping' ) ){?><?php echo $this->user->shipping->city; ?>, <?php echo $this->user->shipping->state; ?> <?php echo $this->user->shipping->zip; ?><?php }?></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $this->user->billing->country_name; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'><?php if( get_option( 'ec_option_use_shipping' ) ){?><?php echo $this->user->shipping->country_name; ?><?php }?></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $this->user->billing->phone; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'><?php if( get_option( 'ec_option_use_shipping' ) ){?><?php echo $this->user->shipping->phone; ?><?php }?></span></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td width='269' align='left'>&nbsp;</td>
            <td width='80' align='center'>&nbsp;</td>
            <td width='91' align='center'>&nbsp;</td>
            <td align='center'>&nbsp;</td>
        </tr>
        <tr>
        	<td width='269' align='left' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_1" ); ?></td>
            <td width='80' align='center' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_2" ); ?></td>
            <td width='91' align='center' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_3" ); ?></td>
            <td align='center' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_4" ); ?></td>
        </tr>
        
        <?php for( $i=0; $i < count( $this->cart->cart); $i++){ 
	
			$unit_price = $GLOBALS['currency']->get_currency_display( $this->cart->cart[$i]->unit_price );
			$total_price = $GLOBALS['currency']->get_currency_display( $this->cart->cart[$i]->total_price );
		
		?>
		
        <tr>
        	<td width='269' class='style22'>
				<table>
                	<tr><td>
                    <?php echo $this->cart->cart[$i]->title; ?>
                    </td></tr>
                    <?php if( $this->cart->cart[$i]->gift_card_message ){ ?>
                    <tr><td>
                      <?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_message' ) . $this->cart->cart[$i]->gift_card_message; ?>
                    </td></tr>
                    <?php }?>
                    
                    <?php if( $this->cart->cart[$i]->gift_card_from_name ){ ?>
                    <tr><td>
                      <?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_from' ) . $this->cart->cart[$i]->gift_card_from_name; ?>
                    </td></tr>
                    <?php }?>
                    <?php if( $this->cart->cart[$i]->gift_card_to_name ){ ?>
                    <tr><td>
                      <?php echo $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_to' ) . $this->cart->cart[$i]->gift_card_to_name; ?>
                    </td></tr>
                    <?php }?>
                    <?php if( $this->cart->cart[$i]->is_giftcard || $this->cart->cart[$i]->is_download ){ ?>
                    <tr><td>
                    
                    <?php 
					$account_page_id = get_option('ec_option_accountpage');
					$account_page = get_permalink( $account_page_id );
					if( substr_count( $account_page, '?' ) )
						$permalink_divider = "&";
					else
						$permalink_divider = "?";
					
					if( $this->cart->cart[$i]->is_giftcard ){
						echo "<a href=\"" . $account_page . $permalink_divider . "ec_page=order_details&order_id=" . $this->order_id . "\" target=\"_blank\">" . $GLOBALS['language']->get_text( "account_order_details", "account_orders_details_print_online" ) . "</a>";
					}else if( $this->cart->cart[$i]->is_download ){
						echo "<a href=\"" . $account_page . $permalink_divider . "ec_page=order_details&order_id=" . $this->order_id . "\" target=\"_blank\">" . $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_download' ) . "</a>";
					}
					?>
                    </td></tr>
                    <?php }
                    if( $this->cart->cart[$i]->optionitem1_name ){
                        echo "<tr><td><span class=\"ec_option_label\">" . $this->cart->cart[$i]->optionitem1_label . "</span>: <span class=\"ec_option_name\">" . $this->cart->cart[$i]->optionitem1_name;
						if( $this->cart->cart[$i]->optionitem1_price != "0.00" )
							echo " (" . $GLOBALS['currency']->get_currency_display( $this->cart->cart[$i]->optionitem1_price ) . ")";
						echo "</span></td></tr>";
                    }
                    
                    if( $this->cart->cart[$i]->optionitem2_name ){
                        echo "<tr><td><span class=\"ec_option_label\">" . $this->cart->cart[$i]->optionitem2_label . "</span>: <span class=\"ec_option_name\">" . $this->cart->cart[$i]->optionitem2_name;
						if( $this->cart->cart[$i]->optionitem2_price != "0.00" )
							echo " (" . $GLOBALS['currency']->get_currency_display( $this->cart->cart[$i]->optionitem2_price ) . ")";
						echo "</span></td></tr>";
                    }
                    
                    if( $this->cart->cart[$i]->optionitem3_name ){
                        echo "<tr><td><span class=\"ec_option_label\">" . $this->cart->cart[$i]->optionitem3_label . "</span>: <span class=\"ec_option_name\">" . $this->cart->cart[$i]->optionitem3_name;
						if( $this->cart->cart[$i]->optionitem3_price != "0.00" )
							echo " (" . $GLOBALS['currency']->get_currency_display( $this->cart->cart[$i]->optionitem3_price ) . ")";
						echo "</span></td></tr>";
                    }
                    
                    if( $this->cart->cart[$i]->optionitem4_name ){
                        echo "<tr><td><span class=\"ec_option_label\">" . $this->cart->cart[$i]->optionitem4_label . "</span>: <span class=\"ec_option_name\">" . $this->cart->cart[$i]->optionitem4_name;
						if( $this->cart->cart[$i]->optionitem4_price != "0.00" )
							echo " (" . $GLOBALS['currency']->get_currency_display( $this->cart->cart[$i]->optionitem4_price ) . ")";
						echo "</span></td></tr>";
                    }
                    
                    if( $this->cart->cart[$i]->optionitem5_name ){
                        echo "<tr><td><span class=\"ec_option_label\">" . $this->cart->cart[$i]->optionitem5_label . "</span>: <span class=\"ec_option_name\">" . $this->cart->cart[$i]->optionitem5_name;
						if( $this->cart->cart[$i]->optionitem5_price != "0.00" )
							echo " (" . $GLOBALS['currency']->get_currency_display( $this->cart->cart[$i]->optionitem5_price ) . ")";
						echo "</span></td></tr>";
                    }
                    ?>
                </table>
            </td>
            <td width='80' align='center' class='style22'><?php echo $this->cart->cart[$i]->quantity; ?></td>
            <td width='91' align='center' class='style22'><?php echo $unit_price; ?></td>
            <td align='center' class='style22'><?php echo $total_price; ?></td>
        </tr>
	
		<?php }//end for loop ?>

		<tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center'>&nbsp;</td>
            <td width='91' align='center'>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center' class='style22'>&nbsp;</td>
            <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_subtotal" ); ?></td>
            <td  align='center'  class='style22'><?php echo $subtotal; ?></td>
        </tr>
		
        <?php if( $tax_struct->is_tax_enabled( ) ){ ?>
        <tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center' class='style22'>&nbsp;</td>
            <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_tax" ); ?></td>
            <td align='center' class='style22'><?php echo $tax; ?></td>
        </tr>
        <?php }?>
        <?php if( get_option( 'ec_option_use_shipping' ) ){?>
        <tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center' class='style22'>&nbsp;</td>
            <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_shipping" ); ?></td>
            <td  align='center'  class='style22'><?php echo $shipping; ?></td>
        </tr>
        <?php }?>
        <tr>
          <td>&nbsp;</td>
          <td align='center' class='style22'>&nbsp;</td>
          <td align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_discount" ); ?></td>
          <td  align='center'  class='style22'>-<?php echo $discount; ?></td>
        </tr>
        
        <?php if( $has_duty ){ ?>
        <tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center' class='style22'>&nbsp;</td>
            <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_duty" ); ?></td>
            <td align='center' class='style22'><?php echo $duty; ?></td>
        </tr>
        <?php }?>
        
        <?php if( $tax_struct->is_vat_enabled( ) ){ ?>
        <tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center' class='style22'>&nbsp;</td>
            <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_vat" ); ?><?php echo $vat_rate; ?>%</td>
            <td align='center' class='style22'><?php echo $vat; ?></td>
        </tr>
        <?php }?>
        <tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center' class='style22'>&nbsp;</td>
            <td width='91' align='center' class='style22'><strong><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_grand_total" ); ?></strong></td>
            <td align='center' class='style22'><strong><?php echo $total; ?></strong></td>
        </tr>
        <tr>
        	<td colspan='4' class='style22'>
            	<p><br>
				<?php if( get_option( 'ec_option_user_order_notes' ) ){ ?>
                    <hr />
                    <h4><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?></h4>
                    <p><?php echo nl2br( $this->order_customer_notes ); ?></p>
                    <br>
                    <hr />
                <?php }?>
				<?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_1" ); ?><br><br><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_2" ); ?></p>
            	<p>&nbsp;</p>
            </td>
        </tr>
        <tr>
        	<td colspan='4'>
            	
            </td>
        </tr>
    </table>
</body>
</html>