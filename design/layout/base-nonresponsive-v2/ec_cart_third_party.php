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
