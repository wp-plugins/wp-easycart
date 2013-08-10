<div class="ec_category_widget">
  
	<?php 
	for($i=0; $i<count( $categories ); $i++){
		if( $categories[$i][2] > 0 ){ ?>
			<div>
            	<a href="<?php echo $store_page . $permalink_divider; if( $level > 1 ){ echo "sub"; } if( $level > 0 ){ echo "sub"; } echo "menuid=" . $categories[$i][0] . "&amp;"; if( $level > 1 ){ echo "sub"; } if( $level > 0 ){ echo "sub"; } echo "menu=" . $categories[$i][1]; ?>" class="menu_link"><?php if( ( $level == 0 && isset( $_GET['menuid'] ) && $_GET['menuid'] == $categories[$i][0] ) || ( $level == 1 && isset( $_GET['submenuid'] ) && $_GET['submenuid'] == $categories[$i][0] ) || ( $level == 2 && isset( $_GET['subsubmenuid'] ) && $_GET['subsubmenuid'] == $categories[$i][0] ) ){ echo "<b>"; } ?><?php echo $categories[$i][1]; ?> (<?php echo $categories[$i][2]; ?>)<?php if( ( $level == 0 && isset( $_GET['menuid'] ) && $_GET['menuid'] == $categories[$i][0] ) || ( $level == 1 && isset( $_GET['submenuid'] ) && $_GET['submenuid'] == $categories[$i][0] ) || ( $level == 2 && isset( $_GET['subsubmenuid'] ) && $_GET['subsubmenuid'] == $categories[$i][0] ) ){ echo "</b>"; } ?></a>
            </div>
  
  <?php 
  		}
  }
  ?>
  
</div>
