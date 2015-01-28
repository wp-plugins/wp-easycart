<html>
	<head>
    	<title>Shipping Confirmation - Order Number <?php echo $order_id; ?></title>
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
                	<p><br> Dear <?php echo $order[0]->billing_first_name . " " . $order[0]->billing_last_name; ?>: </p>
                    <p>Your recent order  with the number <strong><?php echo $order[0]->order_id; ?></strong> has been shipped! You should be receiving it within a short time period.<br>
					<?php if( $trackingnumber != '0' && $trackingnumber != 'Null' && $trackingnumber != 'NULL' && $trackingnumber != 'null' && $trackingnumber != NULL && $trackingnumber != '' ){ ?>
					<br>You may check the status of your order by visiting your carriers website and using the following tracking number.</p>
                    <p>Package Carrier: <?php echo $shipcarrier; ?><br>Package Tracking Number: <?php echo $trackingnumber; ?></p>
					<?php } ?>
			
					<p><br></p>
            	</td>
            </tr>
            <tr>
            	<td colspan='4' align='left' class='style20'>
                	<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
                    	<tr>
                        	<td width='47%' bgcolor='#F3F1ED' class='style20'>Billing Address</td>
                            <td width='3%'>&nbsp;</td>
                            <td width='50%' bgcolor='#F3F1ED' class='style20'>Shipping Address</td>
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
            	<td width='269' align='left' bgcolor='#F3F1ED' class='style20'>Product</td>
                <td width='80' align='center' bgcolor='#F3F1ED' class='style20'>Qty</td>
                <td width='91' align='center' bgcolor='#F3F1ED' class='style20'>Unit Price</td>
                <td align='center' bgcolor='#F3F1ED' class='style20'>Ext Price</td>
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
            	<td colspan='4' class='style22'><p><br>Please double check your order when you receive it and let us know immediately if there are any concerns or issues. We always value your business and hope you enjoy your product.<br><br>Thank you very much!<br><br><br></p></td>
            </tr>
            <tr>
            	<td colspan='4'><p class='style22'></p></td>
            </tr>
        </table>
    </body>
</html>