<?php 
class ec_pricepointwidget extends WP_Widget{
	
	function ec_pricepointwidget(){
		$widget_ops = array('classname' => 'ec_pricepointwidget', 'description' => 'Displays the Price Point Filter For Your WP EasyCart' );
		$this->WP_Widget('ec_pricepointwidget', 'WP EasyCart Price Point Filter', $widget_ops);
	}
	
	function form($instance){
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'Filter by Price', 'text_domain' );
		}
		
		echo "<p><label for=\"" . $this->get_field_name( 'title' ) . "\">" . _e( 'Title:' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'title' ) . "\" name=\"" . $this->get_field_name( 'title' ) . "\" type=\"text\" value=\"" . esc_attr( $title ) . "\" /></p>";
		
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults);
	}
	
	function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
	
	
	function widget($args, $instance){
	
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
	
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		// WIDGET CODE GOES HERE
		$mysqli = new ec_db();
		$filter = new ec_filter(0);
		
		$storepageid = get_option('ec_option_storepage');
		$store_page = get_permalink( $storepageid );
		
		if( substr_count( $store_page, '?' ) )						$permalink_divider = "&";
		else														$permalink_divider = "?";
		
		if( isset( $_GET['menuid'] ) ){
			$level = 1;
			$menu_id = $_GET['menuid'];
		}else if( isset( $_GET['submenuid'] ) ){
			$level = 2;
			$menu_id = $_GET['submenuid'];
		}else if( isset( $_GET['subsubmenuid'] ) ){
			$level = 3;
			$menu_id = $_GET['subsubmenuid'];
		}else{
			$level = 0;
			$menu_id = 0;
		}
		
		if( isset( $_GET['manufacturer'] ) )
			$man_id = $_GET['manufacturer'];
		else
			$man_id = 0;
		
		$pricepoints = $mysqli->get_pricepoints( $level, $menu_id, $man_id );
		
		include("wp-content/plugins/wp-easycart/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_pricepoint_widget.php");
		
		echo $after_widget;
	}
 
}
?>