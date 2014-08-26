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
	
	<?php for( $i=0; $i<count( $order_details ); $i++ ){ ?>
	ga('ec:addProduct', {
	  'id': '<?php echo $order_details[$i]->model_number; ?>',
	  'name': '<?php echo $order_details[$i]->title; ?>',
	  'price': '<?php echo $order_details[$i]->unit_price; ?>',
	  'quantity': <?php echo $order_details[$i]->quantity; ?>
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
<?php $this->display_cart_process( ); ?>

<h2 class="ec_cart_success_title"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_thank_you_title' ); ?></h2>
<hr />
<p class="ec_cart_success_info"><strong><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_order_number_is' ); ?> <?php $this->display_order_number_link( $order_id ); ?></strong></p>
<p class="ec_cart_success_info"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_will_receive_email' ); ?> <?php echo $order->user_email; ?></p>
<p class="ec_cart_success_info"><?php $this->display_print_receipt_link( $GLOBALS['language']->get_text( 'cart_success', 'cart_success_print_receipt_text' ), $order_id ); ?></p>
<hr />
<?php if( $_SESSION['ec_password'] == "guest" ){?>

<h4 class="ec_cart_success_subtitle"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_save_order_text' ); ?></h4>
<ul class="ec_cart_error" id="ec_cart_success_error_text">
    <li id="ec_cart_error_password_length" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_length_error' ); ?></strong>.</li>
    <li id="ec_cart_error_password_match" style="display: none;"><strong><?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_passwords_match' ); ?></strong> <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_item_must_match' ); ?>.</li>
</ul>
<?php $this->display_success_account_create_form_start( $order_id, $order->user_email ); ?>
<div class="ec_success_create_account_box">
	<div class="ec_success_create_password">
		<div class="ec_success_create_password_label"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_create_password' ); ?></div>
        <div class="ec_success_create_password_box"><?php $this->display_success_create_password( ); ?></div>
        <div class="ec_success_create_password_hint"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_password_hint' ); ?></div>
    </div>
	<div class="ec_success_create_password">
		<div class="ec_success_create_password_label"><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_verify_password' ); ?></div>
        <div class="ec_success_create_password_box"><?php $this->display_success_verify_password( ); ?></div>
    </div>
	<div class="ec_success_create_password_button">
    	<?php $this->display_success_account_create_submit_button( $GLOBALS['language']->get_text( 'cart_success', 'cart_success_create_account' ) ); ?>
    </div>
</div>
<?php $this->display_success_account_create_form_end( ); ?>
<hr />
<?php }?>