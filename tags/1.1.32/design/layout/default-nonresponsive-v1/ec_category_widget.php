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
  
  
	if( $level == 1 ){
		echo "<div><a href=\"" . $store_page . "\" class=\"menu_link\">" . $up_level_text . "</a></div>";
	}else if( $level == 2 ){
		if( $subsubmenu_id > 0 )
		$submenu_id = $mysqli->get_menulevel2_id_from_menulevel3( $subsubmenu_id );
		$menu_id = $mysqli->get_menulevel1_id_from_menulevel2( $submenu_id );
		$menu_name = $mysqli->get_menuname( $menu_id, 1 );
		echo "<div><a href=\"" . $store_page . $permalink_divider . "menuid=" . $menu_id . "&amp;menu=" . htmlentities( $menu_name ) . "\" class=\"menu_link\">" . $up_level_text . "</a></div>";
	}
	
	?>
  
</div>
