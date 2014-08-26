<section class="ec_product_page" id="ec_product_page">
	<?php if( $this->has_products( ) ){ ?>
   	<div><?php $this->product_filter_bar(); ?></div>
    <?php $this->display_optional_banner( ); ?>
    <div><?php $this->product_list(); ?></div>
    <div class="filter_bar_bottom"><?php $this->product_filter_bar(); ?></div>
    <div style="clear:both"></div>
    <?php }else{ ?>
    <div class="ec_products_no_results"><?php echo $GLOBALS['language']->get_text( "product_page", "product_no_results" ); ?></div>
    <?php }?>
</section>
