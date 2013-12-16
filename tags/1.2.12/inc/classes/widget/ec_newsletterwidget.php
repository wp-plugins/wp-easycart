<?php 
class ec_newsletterwidget extends WP_Widget{
	
	function ec_newsletterwidget(){
		$widget_ops = array('classname' => 'ec_newsletterwidget', 'description' => 'Displays the Newsletter Sign Up For Your WP EasyCart' );
		$this->WP_Widget('ec_newsletterwidget', 'WP EasyCart Newsletter Sign Up', $widget_ops);
	}
	
	function form($instance){
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'Newsletter Sign Up', 'text_domain' );
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
		
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_newsletter_widget.php' ) )	
			include( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_newsletter_widget.php");
		else
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_newsletter_widget.php");
		
		echo $after_widget;
	}
 
}
?>