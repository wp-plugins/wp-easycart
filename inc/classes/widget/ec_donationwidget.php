<?php 
class ec_donationwidget extends WP_Widget{
	
	function ec_donationwidget(){
		$widget_ops = array('classname' => 'ec_donationwidget', 'description' => 'Displays a donation goal thermometer for donation products in your WP EasyCart' );
		$this->WP_Widget('ec_donationwidget', 'WP EasyCart Donation Goal Thermometer', $widget_ops);
	}
	
	function form( $instance ){ 
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'Donation Goal', 'text_domain' );
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
		global $post;
		if( isset( $post ) )
			$post_id = $post->ID;
		else
			$post_id = 0;
		
		// Now with post_id try and find a matching product
		$db = new ec_db( );
		$products = $db->get_product_list( sprintf( " WHERE product.post_id = %d", mysql_real_escape_string( $post_id ) ), "", "", "" );
		
		if( count( $products ) > 0 && $products[0]["is_donation"]  ){
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
			
			
			$donation_order_total = $db->get_donation_order_total( $products[0]['model_number'] );
		
			$raised_total = $GLOBALS['currency']->get_currency_display( $donation_order_total );
			$goal_total = $GLOBALS['currency']->get_currency_display( $products[0]['specifications'] );
			if( $donation_order_total == 0 )
				$percent_used = 0;
			else
				$percent_used = $donation_order_total / $products[0]['specifications'];
		
			if( $percent_used > 1 )
				$percent_used = 1;
			
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_donation_widget.php' ) )	
				include( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_donation_widget.php");
			else if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_donation_widget.php' ) )	
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_donation_widget.php");
			else
				echo "Could not find the donation widget layout file.";
			echo "<div style=\"clear:both\"></div>";
			echo $after_widget;
		}
	}
 
}
?>