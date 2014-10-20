<div class="ec_group_widget">
  
  <?php for($i=0; $i<count( $groups ); $i++){ ?>
  	
	  <div><a href="<?php echo get_permalink( $groups[$i]->post_id ); ?>" class="menu_link"><?php if( isset( $_GET['group'] ) && $_GET['group'] == $groups[$i]->category_id ){ echo "<b>"; } ?><?php echo $groups[$i]->category_name; ?><?php if( isset( $_GET['group'] ) && $_GET['group'] == $groups[$i]->category_id ){ echo "</b>"; } ?></a>
      </div>

  <?php }?>
  
</div>