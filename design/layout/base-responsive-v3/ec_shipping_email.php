<html>
	<head>
    	<title><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_email_title' )?> <?php echo $orderid; ?></title>
		<style>
			.style20{ font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px; }
			.style22{ font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
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
                	<p><br><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_dear' )?> <?php echo $order[0]->billing_first_name . " " . $order[0]->billing_last_name; ?>: </p>
                    <p><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_subtitle1' )?> <strong><?php echo $order[0]->order_id; ?></strong> <?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_subtitle2' )?><br>
					<?php if( $trackingnumber != '0' && $trackingnumber != 'Null' && $trackingnumber != 'NULL' && $trackingnumber != 'null' && $trackingnumber != NULL && $trackingnumber != '' ){ ?>
					<br><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_description' )?></p>
                    <p><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_carrier' )?> <?php echo $shipcarrier; ?><br><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_tracking' )?> <?php echo $trackingnumber; ?></p>
					<?php } ?>
			
					<p><br></p>
            	</td>
            </tr>
            <tr>
            	<td colspan='4' align='left' class='style20'>
                	<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
                    	<tr>
                        	<td width='47%' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_billing_label' )?></td>
                            <td width='3%'>&nbsp;</td>
                            <td width='50%' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_shipping_label' )?></td>
                        </tr>
                        <tr>
                        	<td><span class='style22'><?php echo $order[0]->billing_first_name . " " . $order[0]->billing_last_name; ?></span></td>
                            <td>&nbsp;</td>
                            <td><span class='style22'><?php echo $order[0]->shipping_first_name . " " . $order[0]->shipping_last_name; ?></span></td>
                        </tr>
                        <tr>
                        	<td><span class='style22'><?php echo $order[0]->billing_address_line_1 . "<br>" . $order[0]->billing_address_line_2; ?></span></td>
                            <td>&nbsp;</td>
                            <td><span class='style22'><?php echo $order[0]->shipping_address_line_1 . " <br>" . $order[0]->shipping_address_line_2; ?></span></td>
                        </tr>
                        <tr>
                        	<td><span class='style22'><?php echo $order[0]->billing_city . ", " . $order[0]->billing_state . " " . $order[0]->billing_zip; ?></span></td>
                            <td>&nbsp;</td>
                            <td><span class='style22'><?php echo $order[0]->shipping_city . ", " . $order[0]->shipping_state . " " . $order[0]->shipping_zip; ?></span></td>
                        </tr>
                        <tr>
                        	<td><span class='style22'>Phone: <?php echo $order[0]->billing_phone; ?></span></td>
                            <td>&nbsp;</td>
                            <td><span class='style22'>Phone: <?php echo $order[0]->shipping_phone; ?></span></td>
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
            	<td width='269' align='left' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_product' )?></td>
                <td width='80' align='center' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_quantity' )?></td>
                <td width='91' align='center' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_unit_price' )?></td>
                <td align='center' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_total_price' )?></td>
            </tr>
			
            <?php 
			foreach( $orderdetails as $row ){
				$finaltotal = $GLOBALS['currency']->get_currency_display( $row->unit_price );
				$totalitemprice = $GLOBALS['currency']->get_currency_display( $row->total_price );
				?>
            <tr>
            	<td width='269' class='style22'><?php echo $row->title; ?></td>
                <td width='80' align='center' class='style22'><?php echo $row->quantity; ?></td>
                <td width='91' align='center' class='style22'><?php echo $finaltotal; ?></td>
                <td align='center' class='style22'><?php echo $totalitemprice; ?></td>
            </tr>				
			<?php } ?>
            		
			<tr>
            	<td width='269'>&nbsp;</td>
                <td width='80' align='center'>&nbsp;</td>
                <td width='91' align='center'>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td colspan='4' class='style22'><p><br><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_final_note1' )?><br><br><?php echo $GLOBALS['language']->get_text( 'ec_shipping_email', 'shipping_final_note2' )?><br><br><br></p></td>
            </tr>
            <tr>
            	<td colspan='4'><p class='style22'></p></td>
            </tr>
        </table>
    </body>
</html>