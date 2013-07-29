<?php 
class ec_specialswidget extends WP_Widget{
	
	function ec_specialswidget(){
		$widget_product_limit = array('classname' => 'ec_specialswidget', 'description' => 'Displays the Specials For Your WP EasyCart' );
		$this->WP_Widget('ec_specialswidget', 'WP EasyCart Specials', $widget_product_limit);
	}
 
	function form($instance){
		$defaults = array( 'title' => 'Store Specials', 'product_limit' => '3' );
		$instance = wp_parse_args( (array) $instance, $defaults);
		$product_limit = $instance['product_limit'];
		$title = $instance['title'];
		
		echo "<p>";
		echo "<label for=\"" . $this->get_field_id('title') . "\">";
		echo "Title: ";
		echo "<input class=\"widefat\" id=\"" . $this->get_field_id('title') . "\" name=\"" . $this->get_field_name('title') . "\" type=\"text\" value=\"" . attribute_escape($title) . "\" />";
		echo "</label>";
		echo "</p>";
		
		echo "<p>";
		echo "<label for=\"" . $this->get_field_id('product_limit') . "\">";
		echo "Product Limit: ";
		echo "<input class=\"widefat\" id=\"" . $this->get_field_id('product_limit') . "\" name=\"" . $this->get_field_name('product_limit') . "\" type=\"text\" value=\"" . attribute_escape($product_limit) . "\" />";
		echo "</label>";
		echo "</p>";
	}
 
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['product_limit'] = $new_instance['product_limit'];
		$instance['title'] = $new_instance['title'];
		return $instance;
	}
 
 
	function widget($args, $instance){
	
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$product_limit = empty($instance['product_limit']) ? ' ' : apply_filters('widget_product_limit', $instance['product_limit']);
		
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		// WIDGET CODE GOES HERE
		$mysqli = new ec_db();
		
		//First get number of products without the limit query
		$result = $mysqli->get_product_list( " WHERE product.is_special = '1' ", "", " LIMIT " . $product_limit, "" );
		
		for($i=0; $i<count($result); $i++){
			$product = new ec_product( $result[$i], 0, 0, 1 );
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option('ec_option_base_layout') . '/ec_special.php' );
		}
		echo "<div style=\"clear:both;\"></div>";
		echo $after_widget;
	}
 
}
?>