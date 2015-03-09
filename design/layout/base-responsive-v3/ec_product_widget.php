<div id="ec_product_widget_item" class="ec_product_widget">
	
    <div class="ec_product_widget_images">
		<?php $product->display_product_image_set( "medium", "ec_image_product_widget_", "" ); ?>
    </div>

    <div class="ec_product_widget_title"><?php $product->display_product_title_link(); ?></div>

	<div class="ec_product_widget_pricing"><?php $product->display_product_list_price(); ?><?php $product->display_price(); ?></div>

</div>

<div style="clear:both;"></div>