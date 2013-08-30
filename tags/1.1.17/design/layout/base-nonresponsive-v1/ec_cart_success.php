<script>

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
	ga('create', '<?php echo $google_urchin_code; ?>', '<?php echo $google_wp_url; ?>');
	ga('send', 'pageview');
	
	ga('require', 'ecommerce', 'ecommerce.js');
	
	<?php
		//transaction information
		echo $google_transaction;
		//transaction items
		echo $google_items;
	?>
	
	ga('ecommerce:send');
	
</script>

<div class="top_link_bar"><a href="<?php echo $this->account_page . $this->permalink_divider; ?>ec_page=order_details&amp;order_id=<?php echo $order_id; ?>">
  <?php if( $_SESSION['ec_password'] != "guest" ){?>
  <input value="<?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_payment_receipt_order_details_link' ); ?>" type="button" class="top_link_button" id="cart_success_details_button"/>
  <?php }?>
  </a></div>
<div id="printable">
  <table width='90%' border='0' align='center'>
    <tr>
      <td colspan='4' align='left' class='ec_cart_success_style22'>&nbsp;</td>
    </tr>
    <tr>
      <td colspan='4' align='left' class='ec_cart_success_style22'><p><br>
          <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_1" ) . " " . $this->user->billing->first_name . " " . $this->user->billing->last_name; ?>:</p>
        <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_2" ); ?> <strong><?php echo $order_id; ?></strong></p>
        <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_3" ); ?></p>
        <p><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_4" ); ?><br>
          <br>
          <br>
        </p></td>
    </tr>
    <tr>
      <td colspan='4' align='center' class='ec_cart_success_style20'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
          <tr>
            <td width='47%' bgcolor='#F3F1ED' class='ec_cart_success_style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_billing_label" ); ?></td>
            <td width='3%'>&nbsp;</td>
            <td width='50%' bgcolor='#F3F1ED' class='ec_cart_success_style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_shipping_label" ); ?></td>
          </tr>
          <tr>
            <td class='ec_cart_success_style22'><?php echo $this->user->billing->first_name; ?> <?php echo $this->user->billing->last_name; ?></td>
            <td>&nbsp;</td>
            <td class='ec_cart_success_style22'><?php echo $this->user->shipping->first_name; ?> <?php echo $this->user->shipping->last_name; ?></td>
          </tr>
          <tr>
            <td class='ec_cart_success_style22'><?php echo $this->user->billing->address_line_1; ?></td>
            <td>&nbsp;</td>
            <td class='ec_cart_success_style22'><?php echo $this->user->shipping->address_line_1; ?></td>
          </tr>
          <tr>
            <td class='ec_cart_success_style22'><?php echo $this->user->billing->city; ?>, <?php echo $this->user->billing->state; ?> <?php echo $this->user->billing->zip; ?></td>
            <td>&nbsp;</td>
            <td class='ec_cart_success_style22'><?php echo $this->user->shipping->city; ?>, <?php echo $this->user->shipping->state; ?> <?php echo $this->user->shipping->zip; ?></td>
          </tr>
          <tr>
            <td class='ec_cart_success_style22'><?php echo $this->user->billing->country; ?></td>
            <td>&nbsp;</td>
            <td class='ec_cart_success_style22'><?php echo $this->user->shipping->country; ?></td>
          </tr>
          <tr>
            <td class='ec_cart_success_style22'><?php echo $this->user->billing->phone; ?></td>
            <td>&nbsp;</td>
            <td class='ec_cart_success_style22'><?php echo $this->user->shipping->phone; ?></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width='55%' align='left'>&nbsp;</td>
      <td width='15%' align='center'>&nbsp;</td>
      <td width='15%' align='center'>&nbsp;</td>
      <td width="15%" align='center'>&nbsp;</td>
    </tr>
    <tr>
      <td align='left' bgcolor='#F3F1ED' class='ec_cart_success_style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_1" ); ?></td>
      <td align='center' bgcolor='#F3F1ED' class='ec_cart_success_style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_2" ); ?></td>
      <td align='center' bgcolor='#F3F1ED' class='ec_cart_success_style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_3" ); ?></td>
      <td align='center' bgcolor='#F3F1ED' class='ec_cart_success_style20'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_details_header_4" ); ?></td>
    </tr>
    <?php for( $i=0; $i < count( $order_details ); $i++){ 
	
			$unit_price = $GLOBALS['currency']->get_currency_display( $order_details[$i]->unit_price );
			$total_price = $GLOBALS['currency']->get_currency_display( $order_details[$i]->total_price );
		
		?>
    <tr>
      <td class='ec_cart_success_style22'>
	  <table>
        <tr><td>
	  	<?php echo $order_details[$i]->title; ?>
        </td></tr>
	  	<?php 
		if( $order_details[$i]->optionitem_name_1 ){
			echo "<tr><td><span class=\"ec_option_label\">" . $order_details[$i]->optionitem_label_1 . "</span>: <span class=\"ec_option_name\">" . $order_details[$i]->optionitem_name_1 . "</span></td></tr>";
		}
		
		if( $order_details[$i]->optionitem_name_2 ){
			echo "<tr><td><span class=\"ec_option_label\">" . $order_details[$i]->optionitem_label_2 . "</span>: <span class=\"ec_option_name\">" . $order_details[$i]->optionitem_name_2 . "</span></td></tr>";
		}
		
		if( $order_details[$i]->optionitem_name_3 ){
			echo "<tr><td><span class=\"ec_option_label\">" . $order_details[$i]->optionitem_label_3 . "</span>: <span class=\"ec_option_name\">" . $order_details[$i]->optionitem_name_3 . "</span></td></tr>";
		}
		
		if( $order_details[$i]->optionitem_name_4 ){
			echo "<tr><td><span class=\"ec_option_label\">" . $order_details[$i]->optionitem_label_4 . "</span>: <span class=\"ec_option_name\">" . $order_details[$i]->optionitem_name_4 . "</span></td></tr>";
		}
		
		if( $order_details[$i]->optionitem_name_5 ){
			echo "<tr><td><span class=\"ec_option_label\">" . $order_details[$i]->optionitem_label_5 . "</span>: <span class=\"ec_option_name\">" . $order_details[$i]->optionitem_name_5 . "</span></td></tr>";
		}
		?>
      </table>
      </td>
      <td align='center' class='ec_cart_success_style22'><?php echo $order_details[$i]->quantity; ?></td>
      <td align='center' class='ec_cart_success_style22'><?php echo $unit_price; ?></td>
      <td align='center' class='ec_cart_success_style22'><?php echo $total_price; ?></td>
    </tr>
    <?php }//end for loop ?>
    <tr>
      <td>&nbsp;</td>
      <td align='center'>&nbsp;</td>
      <td align='center'>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_subtotal" ); ?></td>
      <td align='center'  class='ec_cart_success_style22'><?php echo $subtotal; ?></td>
    </tr>
    <?php if( !$this->tax->vat_enabled ){ ?>
    <tr>
      <td>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_tax" ); ?></td>
      <td align='center' class='ec_cart_success_style22'><?php echo $tax; ?></td>
    </tr>
    <?php }?>
    <tr>
      <td>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_shipping" ); ?></td>
      <td align='center'  class='ec_cart_success_style22'><?php echo $shipping; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_discount" ); ?></td>
      <td align='center'  class='ec_cart_success_style22'>-<?php echo $discount; ?></td>
    </tr>
    <?php if( $this->tax->vat_enabled ){ ?>
    <tr>
      <td>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_vat" ); ?><?php echo $vat_rate; ?>%</td>
      <td align='center' class='ec_cart_success_style22'><?php echo $vat; ?></td>
    </tr>
    <?php }?>
    <tr>
      <td>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'>&nbsp;</td>
      <td align='center' class='ec_cart_success_style22'><strong><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_order_totals_grand_total" ); ?></strong></td>
      <td align='center' class='ec_cart_success_style22'><strong><?php echo $total; ?></strong></td>
    </tr>
    <tr>
      <td colspan='4' class='ec_cart_success_style22'><p><br>
          <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_1" ); ?><br>
          <br>
          <?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_bottom_line_2" ); ?></p>
        <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan='4'><p class='ec_cart_success_style22'>&nbsp;</p></td>
    </tr>
  </table>
</div>
