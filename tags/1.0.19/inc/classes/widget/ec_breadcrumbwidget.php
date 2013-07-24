<?php 
class ec_breadcrumbwidget extends WP_Widget{
	
	function ec_breadcrumbwidget(){
		$widget_ops = array('classname' => 'ec_breadcrumbwidget', 'description' => 'Custom Breadcrumbs for Your WP EasyCart' );
		$this->WP_Widget('ec_breadcrumbwidget', 'WP EasyCart Breadcrumbs', $widget_ops);
	}
	
	function form($instance){
		if( isset( $instance[ 'divider' ] ) ) {
			$divider = $instance[ 'divider' ];
		}else {
			$divider = __( '&quot;', 'text_domain' );
		}
		
		echo "<p><label for=\"" . $this->get_field_name( 'divider' ) . "\">" . _e( 'divider:' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'divider' ) . "\" name=\"" . $this->get_field_name( 'divider' ) . "\" type=\"text\" value=\"" . esc_attr( $divider ) . "\" /></p>";
		
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults);
	}
	
	function update($new_instance, $old_instance){
		$instance = array();
		$instance['divider'] = ( !empty( $new_instance['divider'] ) ) ? strip_tags( $new_instance['divider'] ) : '';

		return $instance;
	}
	
	
	function widget($args, $instance){
	
		extract( $args );
		$divider = empty($instance['divider']) ? ' ' : apply_filters('widget_divider', $instance['divider']);
	
		echo $before_widget;
		
		// WIDGET CODE GOES HERE
		include("wp-content/plugins/wp-easycart/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_breadcrumb_widget.php");
		
		echo $after_widget;
	}
 
}
?>