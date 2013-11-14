<?php 
class ec_menuwidget extends WP_Widget{
	
	function ec_menuwidget(){
		$widget_ops = array('classname' => 'ec_menuwidget', 'description' => 'Displays a Menu For Your WP EasyCart' );
		$this->WP_Widget('ec_menuwidget', 'WP EasyCart Menu', $widget_ops);
	}
	
	function form( $instance ){
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'Store Menu', 'text_domain' );
		}
		
		if( isset( $instance[ 'menutype' ] ) ) {
			$menutype = $instance[ 'menutype' ];
		}else {
			$menutype = __( '1', 'text_domain' );
		}
		
		$defaults = array(
			'menutype' => '1',
			'title' => 'Store Menu'
		);
		$instance = wp_parse_args( (array) $instance, $defaults);
		$menutype = $instance['menutype'];
		$title = $instance['title'];
	
		echo "<p><label for=\"" . $this->get_field_name( 'title' ) . "\">" . _e( 'Title:' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'title' ) . "\" name=\"" . $this->get_field_name( 'title' ) . "\" type=\"text\" value=\"" . esc_attr( $title ) . "\" /></p>";
		
		echo "<p><label for=\"" . $this->get_field_id('menutype') . "\">Menu Type: 
		<select class=\"widefat\" id=\"" . $this->get_field_id('menutype') . "\" name=\"" . $this->get_field_name('menutype') . "\"><option value=\"1\"";
		if( $menutype == "1" )
		echo " selected=\"selected\"";
		echo ">Horizontal Menu</option><option value=\"2\"";
		if( $menutype == "2" )
		echo " selected=\"selected\"";
		echo ">Vertical Menu</option></select></label></p>";
		
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['menutype'] = $new_instance['menutype'];
		return $instance;
	}
	
	
	function widget($args, $instance){
	
		extract($args, EXTR_SKIP);
	
		echo $before_widget;
		$menutype = empty($instance['menutype']) ? ' ' : apply_filters('widget_menutype', $instance['menutype']);
		$title = apply_filters( 'widget_title', $instance['title'] );
	
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		// WIDGET CODE GOES HERE
		$mysqli = new ec_db();
		$menu_items = $mysqli->get_menu_items( );
		
		$last_menu1 = 0;
		$last_menu2 = 0;
		
		$i=-1;
		$j=-1;
		
		$menu_array = array(); 
		foreach( $menu_items as $menu_item ){
			if( $last_menu1 != $menu_item->menulevel1_id ){
				$i++;
				$last_menu1 = $menu_item->menulevel1_id;
				$last_menu2 = 0;
				$j=-1;
				$menu_array[] = array(array(), $menu_item->menulevel1_id, $menu_item->menu1_name, $menu_item->menulevel1_post_id );
			}
			
			if( $menu_item->menulevel2_id && $last_menu2 != $menu_item->menulevel2_id ){
				$j++;
				$last_menu2 = $menu_item->menulevel2_id;
				$menu_array[$i][0][] = array(array(), $menu_item->menulevel2_id, $menu_item->menu2_name, $menu_item->menulevel2_post_id );
			}
			
			if( $menu_item->menulevel3_id ){
				$menu_array[$i][0][$j][0][] = array($menu_item->menulevel3_id, $menu_item->menu3_name, $menu_item->menulevel3_post_id);
			}
		}
		
		$menu = new ec_menu( $menu_array );
		
		if($menutype == "1"){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_menu_horizontal_widget.php' ) )	
				include( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_menu_horizontal_widget.php");
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_menu_horizontal_widget.php");
		}else{
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_menu_vertical_widget.php' ) )	
				include( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_menu_vertical_widget.php");
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_menu_vertical_widget.php");
		}
		
		echo $after_widget;
	}
 
}
?>