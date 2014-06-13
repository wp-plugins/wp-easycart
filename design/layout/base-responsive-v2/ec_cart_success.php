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

<?php $this->display_cart_process( ); ?>

<h2><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_thank_you_title' ); ?></h2>
<hr />
<p><strong><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_order_number_is' ); ?> <?php $this->display_order_number_link( $order_id ); ?></strong></p>
<p><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_will_receive_email' ); ?> <?php echo $order->user_email; ?></p>
<p><?php $this->display_print_receipt_link( $GLOBALS['language']->get_text( 'cart_success', 'cart_success_print_receipt_text' ), $order_id ); ?></p>
<hr />
<?php if( $_SESSION['ec_password'] == "guest" ){?>

<h4><?php echo $GLOBALS['language']->get_text( 'cart_success', 'cart_success_save_order_text' ); ?></h4>
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