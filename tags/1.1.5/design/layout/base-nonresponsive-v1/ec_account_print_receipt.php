<html>
<head>
<title><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_receipt_title" ) . " " . $order_id; ?></title>
<style type='text/css'>
<!--
.style20 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.style22 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
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
          <td width='50%' bgcolor='#F3F1ED' class='style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_shipping_label" ); ?></td>
        </tr>
        <tr>
          <td><span class='style22'><?php echo $order->billing_first_name; ?> <?php echo $order->billing_last_name; ?></span></td>
          <td>&nbsp;</td>
          <td><span class='style22'><?php echo $order->shipping_first_name; ?> <?php echo $order->shipping_last_name; ?></span></td>
        </tr>
        <tr>
          <td><span class='style22'><?php echo $order->billing_address_line_1; ?></span></td>
          <td>&nbsp;</td>
          <td><span class='style22'><?php echo $order->shipping_address_line_1; ?></span></td>
        </tr>
        <tr>
          <td><span class='style22'><?php echo $order->billing_city; ?>, <?php echo $order->billing_state; ?> <?php echo $order->billing_zip; ?></span></td>
          <td>&nbsp;</td>
          <td><span class='style22'><?php echo $order->shipping_city; ?>, <?php echo $order->shipping_state; ?> <?php echo $order->shipping_zip; ?></span></td>
        </tr>
        <tr>
          <td><span class='style22'><?php echo $order->billing_country; ?></span></td>
          <td>&nbsp;</td>
          <td><span class='style22'><?php echo $order->shipping_country; ?></span></td>
        </tr>
        <tr>
          <td><span class='style22'><?php echo $order->billing_phone; ?></span></td>
          <td>&nbsp;</td>
          <td><span class='style22'><?php echo $order->shipping_phone; ?></span></td>
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
    <td width='269' class='style22'><?php echo $order_details[$i]->title; ?></td>
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
    <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_subtotal" ); ?></td>
    <td  align='center'  class='style22'><?php echo $subtotal; ?></td>
  </tr>
  <?php if( $vat == "0.00" ){ ?>
  <tr>
    <td width='269'>&nbsp;</td>
    <td width='80' align='center' class='style22'>&nbsp;</td>
    <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_tax" ); ?></td>
    <td align='center' class='style22'><?php echo $tax; ?></td>
  </tr>
  <?php }?>
  <tr>
    <td width='269'>&nbsp;</td>
    <td width='80' align='center' class='style22'>&nbsp;</td>
    <td width='91' align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_shipping" ); ?></td>
    <td  align='center'  class='style22'><?php echo $shipping; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align='center' class='style22'>&nbsp;</td>
    <td align='center' class='style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_discount" ); ?></td>
    <td  align='center'  class='style22'>-<?php echo $discount; ?></td>
  </tr>
  <?php if( $vat != "0.00" ){ ?>
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
    <td colspan='4' class='style22'><p><br>
        <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_1" ); ?><br>
        <br>
        <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_2" ); ?></p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan='4'><p class='style22'><img src='<?php echo $email_footer_url; ?>'></p></td>
  </tr>
</table>
</body>
</html>