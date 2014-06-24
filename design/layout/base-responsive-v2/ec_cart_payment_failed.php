<h2 class="ec_cart_success_title"><?php echo $GLOBALS['language']->get_text( 'ec_errors', 'subscription_payment_failed_title' ); ?> - <?php echo $subscription->title; ?></h2>
<hr />
<p class="ec_cart_success_info"><strong><?php echo $GLOBALS['language']->get_text( 'ec_errors', 'subscription_payment_failed_text' ); ?></strong></p>
<p class="ec_cart_success_info"><?php $this->display_order_link( $GLOBALS['language']->get_text( 'ec_errors', 'subscription_payment_failed_link' )); ?></p>