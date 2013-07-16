<?php 
class ec_categorywidget extends WP_Widget{
	
	function ec_categorywidget(){
		$widget_ops = array('classname' => 'ec_categorywidget', 'description' => 'Displays the Categories For Your WP EasyCart' );
		$this->WP_Widget('ec_categorywidget', 'WP EasyCart Category Filter', $widget_ops);
	}
	
	function form($instance){
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'Shop by Category', 'text_domain' );
		}
		
		if( isset( $instance[ 'up_level_text' ] ) ) {
			$up_level_text = $instance[ 'up_level_text' ];
		}else {
			$up_level_text = __( 'Up a Level', 'text_domain' );
		}
		
		echo "<p><label for=\"" . $this->get_field_name( 'title' ) . "\">" . _e( 'Title:' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'title' ) . "\" name=\"" . $this->get_field_name( 'title' ) . "\" type=\"text\" value=\"" . esc_attr( $title ) . "\" /></p>";
		
		echo "<p><label for=\"" . $this->get_field_name( 'up_level_text' ) . "\">" . _e( 'Up a Level Text:' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'up_level_text' ) . "\" name=\"" . $this->get_field_name( 'up_level_text' ) . "\" type=\"text\" value=\"" . esc_attr( $up_level_text ) . "\" /></p>";
		
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults);
	}
	
	function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['up_level_text'] = ( !empty( $new_instance['up_level_text'] ) ) ? strip_tags( $new_instance['up_level_text'] ) : '';

		return $instance;
	}
	
	
	function widget($args, $instance){
	
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$up_level_text = apply_filters( 'widget_up_level_text', $instance['up_level_text'] );
	
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		// WIDGET CODE GOES HERE
		$mysqli = new ec_db();
		$storepageid = get_option('ec_option_storepage');
		$store_page = get_permalink( $storepageid );
		
		if( substr_count( $store_page, '?' ) )						$permalink_divider = "&";
		else														$permalink_divider = "?";
		
		if( isset( $_GET['menuid'] ) ){
			$level = 1;
			$menu_id = $_GET['menuid'];
			$submenu_id = 0;
			$subsubmenu_id = 0;
		}else if( isset( $_GET['submenuid'] ) ){
			$level = 2;
			$menu_id = 0;
			$submenu_id = $_GET['submenuid'];
			$subsubmenu_id = 0;
		}else if( isset( $_GET['subsubmenuid'] ) ){
			$level = 3;
			$menu_id = 0;
			$submenu_id = 0;
			$subsubmenu_id = $_GET['subsubmenuid'];
		}else{
			$level = 0;
			$menu_id = 0;
			$submenu_id = 0;
			$subsubmenu_id = 0;
		}
		
		$category_items = $mysqli->get_category_items( $level, $menu_id, $submenu_id, $subsubmenu_id );
		
		$categories = array(); 
		for( $i=0; $i<count( $category_items ); $i++ ){
			$categories[] = array( $category_items[$i]->menu_id, $category_items[$i]->menu_name, $category_items[$i]->product_count );
		}
		
		include("wp-content/plugins/wpeasycart/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_category_widget.php");
		
		
		
		echo $after_widget;
	}
 
}
?>