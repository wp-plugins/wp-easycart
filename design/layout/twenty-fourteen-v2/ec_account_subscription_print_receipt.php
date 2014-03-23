<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order_id; ?></title>
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
    <td colspan='4' align='left' class='style22'><img src='<?php echo $email_logo_url; ?>'></td>
  </tr>
  <tr>
    <td colspan='4' align='left' class='style22'><p><br>
        <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_1" ) . " " . $order->billing_first_name . " " . $order->billing_last_name; ?>:</p>
      <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_2" ); ?> <strong><?php echo $order_id; ?></strong></p>
      <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_3" ); ?></p>
      <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_4" ); ?><br>
        <br>
        <br>
      </p></td>
  </tr>
  <tr>
    <td colspan='4' align='left' class='style20'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='47%' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_billing_label" ); ?></td>
          <td width='3%'>&nbsp;</td>
          <td width='50%' bgcolor='#F3F1ED' class='style20'></td>
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
          <td><span class='style22'><?php echo $order->billing_country; ?></span></td>
          <td>&nbsp;</td>
          <td><span class='style22'></span></td>
        </tr>
        <tr>
          <td><span class='style22'><?php echo $order->billing_phone; ?></span></td>
          <td>&nbsp;</td>
          <td><span class='style22'></span></td>
        </tr>
      </table></td>
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
  <?php for( $i=0; $i < count( $order_details); $i++){ 
	
			$unit_price = $GLOBALS['currency']->get_currency_display( $order_details[$i]->unit_price );
			$total_price = $GLOBALS['currency']->get_currency_display( $order_details[$i]->total_price );
		
		?>
  <tr>
    <td width='269' class='style22'>
		<table>
            <tr><td>
            <?php echo $order_details[$i]->title; ?>
            </td></tr>
        </table>
	</td>
    <td width='80' align='center' class='style22'><?php echo $order_details[$i]->quantity; ?></td>
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
    <td width='91' align='center' class='style22'><strong><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_grand_total" ); ?></strong></td>
    <td align='center' class='style22'><strong><?php echo $total; ?></strong></td>
  </tr>
  <tr>
    <td colspan='4' class='style22'><p><br>
		<?php if( get_option( 'ec_option_user_order_notes' ) ){ ?>
            <hr />
            <h4><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?></h4>
            <p><?php echo nl2br( $order->order_customer_notes ); ?></p>
            <br>
            <hr />
        <?php }?>
        <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_1" ); ?><br>
        <br>
        <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_2" ); ?></p>
      <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>