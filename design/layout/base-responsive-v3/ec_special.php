<div class="ec_product item<?php echo $i+1; ?>">

	<div class="ec_product_images">
		
		<?php $product->display_product_image_set( "medium", "ec_image_", "true; ec_image_click" ); ?>

	</div>

    <div class="ec_product_title">

      <?php $product->display_product_title_link(); ?>

    </div>

	<div class="ec_product_pricing"><?php $product->display_product_list_price(); ?><?php $product->display_price(); ?></div>

</div>