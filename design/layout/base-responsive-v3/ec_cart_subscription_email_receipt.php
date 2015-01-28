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

            	<p><br><?php echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_line_1" ) . " " . htmlspecialchars( $order->billing_first_name, ENT_QUOTES ) . " " . htmlspecialchars( $order->billing_last_name, ENT_QUOTES ); ?>:</p>

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

                        <td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'><?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ echo $GLOBALS['language']->get_text( "cart_success", "cart_payment_complete_shipping_label" ); } ?></td>

                    </tr>

                    <tr>

                    	<td><span class='style22'><?php echo htmlspecialchars( $order->billing_first_name, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $order->billing_last_name, ENT_QUOTES ); ?></span></td>

                        <td>&nbsp;</td>

                        <td><span class='style22'><?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ echo htmlspecialchars( $order->shipping_first_name, ENT_QUOTES ) . " " . htmlspecialchars( $order->shipping_last_name, ENT_QUOTES ); }?></span></td>

                    </tr>
                    
                    <?php if( $order->billing_company_name != "" || ( get_option( 'ec_option_use_shipping' ) && $order->shipping_company_name != "" ) ){ ?>
                    <tr>

                    	<td><span class='style22'><?php echo htmlspecialchars( $order->billing_company_name, ENT_QUOTES ); ?></span></td>

                        <td>&nbsp;</td>

                        <td><span class='style22'><?php if( get_option( 'ec_option_use_shipping' ) ){?><?php echo htmlspecialchars( $order->shipping_company_name, ENT_QUOTES ); ?><?php }?></span></td>

                    </tr>
                    <?php }?>

                    <tr>

                    	<td><span class='style22'><?php echo htmlspecialchars( $order->billing_address_line_1, ENT_QUOTES ); ?></span></td>

                        <td>&nbsp;</td>

                        <td><span class='style22'><?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ echo htmlspecialchars( $order->shipping_address_line_1, ENT_QUOTES ); }?></span></td>

                    </tr>
                    
                    <?php if( $order->billing_address_line_2 != "" || ( $order->shipping_address_line_2 != "" && get_option( 'ec_option_collect_shipping_for_subscriptions' ) ) ){ ?>

                    <tr>

                      <td><span class='style22'><?php echo htmlspecialchars( $order->billing_address_line_2, ENT_QUOTES ); ?></span></td>

                      <td>&nbsp;</td>

                      <td><span class='style22'><?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ ?><?php echo htmlspecialchars( $order->shipping_address_line_2, ENT_QUOTES ); ?><?php }?></span></td>

                    </tr>

                    <?php }?>

                    <tr>

                    	<td><span class='style22'><?php echo htmlspecialchars( $order->billing_city, ENT_QUOTES ); ?>, <?php echo htmlspecialchars( $order->billing_state, ENT_QUOTES ); ?> <?php echo htmlspecialchars( $order->billing_zip, ENT_QUOTES ); ?></span></td>

                        <td>&nbsp;</td>

                        <td><span class='style22'><?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ echo htmlspecialchars( $order->shipping_city, ENT_QUOTES ) . ', ' . htmlspecialchars( $order->shipping_state, ENT_QUOTES ) . ' ' . htmlspecialchars( $order->shipping_zip, ENT_QUOTES ); }?></span></td>

                    </tr>

                    <tr>

                    	<td><span class='style22'><?php echo htmlspecialchars( $order->billing_country_name, ENT_QUOTES ); ?></span></td>

                        <td>&nbsp;</td>

                        <td><span class='style22'><?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ echo htmlspecialchars( $order->shipping_country_name, ENT_QUOTES ); }?></span></td>

                    </tr>

                    <tr>

                    	<td><span class='style22'><?php echo htmlspecialchars( $order->billing_phone, ENT_QUOTES ); ?></span></td>

                        <td>&nbsp;</td>

                        <td><span class='style22'><?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ echo htmlspecialchars( $order->shipping_phone, ENT_QUOTES ); }?></span></td>

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
                    
                    <?php
	
					if( $order_details[0]->use_advanced_optionset ){
						$advanced_options = $this->mysqli->get_order_options( $order_details[0]->orderdetail_id );
						
						foreach( $advanced_options as $advanced_option ){
							
							if( $advanced_option->option_type == "file" ){
								
								$file_split = explode( "/", $advanced_option->option_value );
								echo "<tr><td><span class=\"ec_option_label\">" . $advanced_option->option_name . ":</span> <span class=\"ec_option_name\">" . $file_split[1] . $advanced_option->option_price_change . "</span></td></tr>";

							}else if( $advanced_option->option_type == "grid" ){

								echo "<tr><td><span class=\"ec_option_label\">" . $advanced_option->option_name . ":</span> <span class=\"ec_option_name\">" . $advanced_option->optionitem_name . " (" . $advanced_option->option_value . ")" . $advanced_option->option_price_change . "</span></td></tr>";

							}else{

								echo "<tr><td><span class=\"ec_option_label\">" . $advanced_option->option_name . ":</span> <span class=\"ec_option_name\">" . htmlspecialchars( $advanced_option->option_value, ENT_QUOTES ) . $advanced_option->option_price_change . "</span></td></tr>";

							}

						}

					}else{

						if( $order_details[0]->optionitem_name_1 ){

							echo "<tr><td><span class=\"ec_option_label\">" . $order_details[0]->optionitem_label_1 . "</span>: <span class=\"ec_option_name\">" . $order_details[0]->optionitem_name_1;

							echo "</span></td></tr>";

						}

						if( $order_details[0]->optionitem_name_2 ){

							echo "<tr><td><span class=\"ec_option_label\">" . $order_details[0]->optionitem_label_2 . "</span>: <span class=\"ec_option_name\">" . $order_details[0]->optionitem_name_2;

							echo "</span></td></tr>";

						}

						if( $order_details[0]->optionitem_name_3 ){

							echo "<tr><td><span class=\"ec_option_label\">" . $order_details[0]->optionitem_label_3 . "</span>: <span class=\"ec_option_name\">" . $order_details[0]->optionitem_name_3;

							echo "</span></td></tr>";

						}

						if( $order_details[0]->optionitem_name_4 ){

							echo "<tr><td><span class=\"ec_option_label\">" . $order_details[0]->optionitem_label_4 . "</span>: <span class=\"ec_option_name\">" . $order_details[0]->optionitem_name_4;

							echo "</span></td></tr>";

						}

						if( $order_details[0]->optionitem_name_5 ){

							echo "<tr><td><span class=\"ec_option_label\">" . $order_details[0]->optionitem_label_5 . "</span>: <span class=\"ec_option_name\">" . $order_details[0]->optionitem_name_5;

							echo "</span></td></tr>";

						}

					}// Close basic options
					?>

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

            	<?php if( get_option( 'ec_option_user_order_notes' ) && strlen( $order->order_customer_notes ) > 0 ){ ?>


                    <hr />


                    <h4><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?></h4>


                    <p><?php echo nl2br( htmlspecialchars( $order->order_customer_notes, ENT_QUOTES ) ); ?></p>


                    <br>


                    <hr />


                <?php }?>

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