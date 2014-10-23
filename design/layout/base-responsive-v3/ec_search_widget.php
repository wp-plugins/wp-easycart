<div class="ec_search_widget">
<form action="<?php echo $store_page; ?>" method="GET">
	<input type="text" name="ec_search" class="ec_search_input" onkeyup="ec_live_search_update( );" list="ec_search_suggestions" />
    <datalist id="ec_search_suggestions">
    </datalist>
	<input type="submit" value="<?php echo $label; ?>" />
</form>
</div>