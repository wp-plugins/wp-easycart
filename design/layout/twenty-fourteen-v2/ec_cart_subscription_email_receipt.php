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
            	<p><br><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_1" ) . " " . $order->billing_first_name . " " . $order->billing_last_name; ?>:</p>
                <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_2" ); ?> <strong><?php echo $order->order_id; ?></strong></p>
                <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_3" ); ?></p>
                <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_4" ); ?><?php if( $order->has_membership_page( ) ){ ?></p>
                <p><a href="<?php echo $order->get_membership_page_link( ); ?>"><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_5" ); ?></a><?php }?><br>
                <br><br></p>
            </td>
        </tr>
        <tr>
        	<td colspan='4' align='left' class='style20'>
            	<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
                	<tr>
                    	<td width='47%' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_billing_label" ); ?></td>
                        <td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $order->billing_first_name; ?> <?php echo $order->billing_last_name; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $order->billing_address_line_1; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $order->billing_city; ?>, <?php echo $order->billing_state; ?> <?php echo $order->billing_zip; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $order->billing_country_name; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'></span></td>
                    </tr>
                    <tr>
                    	<td><span class='style22'><?php echo $order->billing_phone; ?></span></td>
                        <td>&nbsp;</td>
                        <td><span class='style22'></span></td>
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
        
        
        <tr>
        	<td width='269' class='style22'>
				<table>
                	<tr><td>
                    <?php echo $order_details[0]->title; ?><br />
                    <a href="<?php echo $this->account_page . $this->permalink_divider; ?>ec_page=subscription_details&subscription_id=<?php echo $order->subscription_id; ?>"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_payment_receipt_subscription_details_link' ); ?></a>
                    </td></tr>
                </table>
            </td>
            <td width='80' align='center' class='style22'>1</td>
            <td width='91' align='center' class='style22'><?php echo $GLOBALS['currency']->get_currency_display( $order_details[0]->unit_price ); ?></td>
            <td align='center' class='style22'><?php echo $GLOBALS['currency']->get_currency_display( $order_details[0]->total_price ); ?></td>
        </tr>

		<tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center'>&nbsp;</td>
            <td width='91' align='center'>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        	<td width='269'>&nbsp;</td>
            <td width='80' align='center' class='style22'>&nbsp;</td>
            <td width='91' align='center' class='style22'><strong><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_grand_total" ); ?></strong></td>
            <td align='center' class='style22'><strong><?php echo $GLOBALS['currency']->get_currency_display( $order->grand_total ); ?></strong></td>
        </tr>
        <tr>
        	<td colspan='4' class='style22'>
            	<p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_1" ); ?><br><br><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_2" ); ?></p>
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