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

<?php do_action( 'wpeasycart_success_page_content_top', $order_id, $order ); ?>

<h2 class="ec_cart_success_title"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_thank_you_title' ); ?></h2>

<hr />

<p class="ec_cart_success_info"><strong><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_order_number_is' ); ?> <?php $this->display_order_number_link( $order_id ); ?></strong></p>

<p class="ec_cart_success_info"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_will_receive_email' ); ?> <?php echo htmlspecialchars( $order->user_email, ENT_QUOTES); ?></p>

<p class="ec_cart_success_info"><?php $this->display_print_receipt_link( $GLOBALS['language']->get_text( 'cart_success', 'cart_success_print_receipt_text' ), $order_id ); ?></p>

<hr />