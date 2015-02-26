<div class="ec_group_widget">
	
	<?php for($i=0; $i<count( $groups ); $i++){ ?>

		<div><a href="<?php if( !get_option( 'ec_option_use_old_linking_style' ) ){ echo get_permalink( $groups[$i]->post_id ); }else{ echo $store_page . $permalink_divider . "group_id=" . $groups[$i]->category_id; } ?>" class="menu_link"><?php if( $group_id == $groups[$i]->category_id ){ echo "<b>"; } ?><?php echo $groups[$i]->category_name; ?><?php if( $group_id == $groups[$i]->category_id ){ echo "</b>"; } ?></a></div>

	<?php }?>

</div>