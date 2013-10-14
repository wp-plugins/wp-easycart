<div class="ec_filter_bar">
  <div class="ec_filter_bar_left">
    <?php $this->product_filter_combo( ); //Input is the default selection for the filter drop down box ?>
  </div>
  <div class="ec_filter_bar_right"><?php echo $GLOBALS['language']->get_text( 'product_page', 'product_items_per_page' )?>
    <?php $this->product_items_per_page( " " ); //Input is the divider between the numbers, e.g. 3 12 48 (uses spaces) ?>
    | <?php echo $GLOBALS['language']->get_text( 'product_page', 'product_paging_page' )?>
    <?php $this->product_current_page(); ?>
    <?php echo $GLOBALS['language']->get_text( 'product_page', 'product_paging_of' )?>
    <?php $this->product_total_pages(); ?>
    |
    <?php $this->product_paging( " " ); //Input is the divider between the numbers, e.g. 1 2 3 (uses spaces) ?>
  </div>
</div>
