<script>

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	ga('create', '<?php echo get_option( 'ec_option_googleanalyticsid' ); ?>', 'auto');
	ga('require', 'ec');
	
	ga('set', '&cu', '<?php echo get_option( 'ec_option_base_currency' ); ?>');
	
	ga('ec:setAction', 'checkout', {
		'step': 4,
		'option': 'Checkout Success'
	});
	
	ga('send', 'pageview');
	
	<?php for( $i=0; $i<count( $this->cart->cart ); $i++ ){ ?>
	ga('ec:addProduct', {
	  'id': '<?php echo $this->cart->cart[$i]->model_number; ?>',
	  'name': '<?php echo $this->cart->cart[$i]->title; ?>',
	  'price': '<?php echo $this->cart->cart[$i]->unit_price; ?>',
	  'quantity': <?php echo $this->cart->cart[$i]->quantity; ?>
	});
	<?php }?>
	
	// Transaction level information is provided via an actionFieldObject.
	ga('ec:setAction', 'purchase', {
	  'id': '<?php  echo $order_id; ?>',
	  'affiliation': 'Online Store',
	  'revenue': '<?php echo number_format( $order->grand_total, 2, '.', '' ); ?>',
	  'tax': '<?php echo number_format( $order->tax_total, 2, '.', '' ); ?>',
	  'shipping': '<?php echo number_format( $order->shipping_total, 2, '.', '' ); ?>',
	  <?php if( $order->promo_code != "" ){ ?>'coupon': '<?php echo $order->promo_code; ?>'<?php }?>
	});
	
	ga('send', 'pageview');     // Send transaction data with initial pageview.	
	
</script>

<div class="ec_cart_third_party_holder">
  <?php $this->ec_cart_display_third_party_form_start( ); ?>
  <?php $this->ec_cart_display_third_party_logo( ); ?>
  <br \>
  You are about to leave our site. To complete your order you must be redirected to
  <?php $this->ec_cart_display_current_third_party_name( ); ?>
  . Once the order has been completed through
  <?php $this->ec_cart_display_current_third_party_name( ); ?>
  you will be brought back to our site.<br />
  <br />
  <?php $this->display_third_party_submit_button( "Continue to " . $this->ec_cart_get_current_third_party_name( ) ); ?>
  <?php $this->ec_cart_display_third_party_form_end( ); ?>
</div>
