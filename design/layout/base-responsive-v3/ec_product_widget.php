<div id="ec_product_widget_item<?php echo $i+1; ?>" class="ec_product_widget">
    
    <div class="ec_product_widget_images">
		<?php $product->display_product_image_set( "medium", "ec_image_product_widget_", "" ); ?>
    </div>
	
    <div class="ec_product_widget_left">
        <div class="ec_product_widget_title"><?php $product->display_product_title_link(); ?></div>
        
        <?php if( $product->use_customer_reviews ){?>
        <div class="ec_product_widget_rating">
        	<div class="ec_product_widget_stars"><?php $product->display_product_stars(); ?></div>
            <div class="ec_product_widget_num_reviews"> (<?php $product->display_product_number_reviews(); ?>)</div>
        </div>
		<?php }?>
    	
    </div>
    
    <div style="width:35%; float:right;">
    	<div class="ec_product_widget_pricing"><?php $product->display_product_list_price(); ?><?php $product->display_price(); ?></div>
    </div>
    
</div>
<div style="clear:both;"></div>