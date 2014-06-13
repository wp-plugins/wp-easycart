<div class="ec_cart_process_bar">
	<div class="ec_cart_process_bar_padding">
    	<div class="ec_cart_process_bar_left">
    		<div class="dashicons dashicons-lock ec_cart_process_icon"></div>
        </div>
        <div class="ec_cart_process_bar_right">
        	<div class="dashicons dashicons-cart ec_cart_process_icon<?php if( !isset( $_GET['ec_page'] ) ){ echo " ec_cart_process_icon_active"; } ?>"></div> <strong class="ec_cart_process_text"><?php $this->display_cart_process_cart_link( $GLOBALS['language']->get_text( 'cart_process', 'cart_process_cart_link' ) ); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="dashicons dashicons-id ec_cart_process_icon<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_info" ){ echo " ec_cart_process_icon_active"; } ?> ec_cart_process_icon_left_margin"></div> <strong class="ec_cart_process_text"><?php $this->display_cart_process_shipping_link( $GLOBALS['language']->get_text( 'cart_process', 'cart_process_shipping_link' ) ); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="dashicons dashicons-tag ec_cart_process_icon<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_payment" ){ echo " ec_cart_process_icon_active"; } ?> ec_cart_process_icon_left_margin"></div> <strong class="ec_cart_process_text"><?php $this->display_cart_process_review_link( $GLOBALS['language']->get_text( 'cart_process', 'cart_process_review_link' ) ); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="dashicons dashicons-yes ec_cart_process_icon<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){ echo " ec_cart_process_icon_active"; } ?> ec_cart_process_icon_left_margin"></div> <strong class="ec_cart_process_text"><?php echo $GLOBALS['language']->get_text( 'cart_process', 'cart_process_complete_link' ); ?></strong>
    	</div>
    </div>
</div>