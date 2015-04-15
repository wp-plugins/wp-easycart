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
		if( isset( $instance['title'] ) )
			$title = apply_filters( 'widget_title', $instance['title'] );
		else
			$title = "";
		
		// Translate if Needed
		$title = $GLOBALS['language']->convert_text( $title );
	
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		// WIDGET CODE GOES HERE
		$mysqli = new ec_db();
		$filter = new ec_filter(0);
		
		$storepageid = get_option('ec_option_storepage');
		if( function_exists( 'icl_object_id' ) ){
			$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
		}
		$store_page = get_permalink( $storepageid );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$store_page = $https_class->makeUrlHttps( $store_page );
		}
		
		if( substr_count( $store_page, '?' ) )						$permalink_divider = "&";
		else														$permalink_divider = "?";
		
		if( isset( $_GET['menuid'] ) || isset( $_GET['submenuid'] ) || isset( $_GET['subsubmenuid'] ) ){
			//Old Linking Format Code
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
		}else{
			//New Linking Format Code
			global $wp_query;
			$post_obj = $wp_query->get_queried_object();
			if( isset( $post_obj ) && isset( $post_obj->ID ) ){
				$post_id = $post_obj->ID;
				$menulevel1 = $mysqli->get_menu_row_from_post_id( $post_id, 1 );
				$menulevel2 = $mysqli->get_menu_row_from_post_id( $post_id, 2 );
				$menulevel3 = $mysqli->get_menu_row_from_post_id( $post_id, 3 );
				
				if( count( $menulevel1 ) > 0 ){
					$level = 1;
					$menu_id = $menulevel1->menulevel1_id;
				}else if( count( $menulevel2 ) > 0 ){
					$level = 2;
					$menu_id = $menulevel2->menulevel2_id;
				}else if( count( $menulevel3 ) > 0 ){
					$level = 3;
					$menu_id = $menulevel3->menulevel3_id;
				}else{
					$level = 0;
					$menu_id = 0;
				}
			}else{
				$level = 0;
				$menu_id = 0;
			}
		}
		
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		if( isset( $post_obj ) && isset( $post_obj->ID ) ){
			$post_id = $post_obj->ID;
			$manufacturer = $mysqli->get_manufacturer_id_from_post_id( $post_id );
			$group = $mysqli->get_category_id_from_post_id( $post_id );
			
			if( isset( $_GET['manufacturer'] ) )
				$man_id = $_GET['manufacturer'];
			else if( isset( $manufacturer ) )
				$man_id = $manufacturer->manufacturer_id;
			else
				$man_id = 0;
				
			if( isset( $_GET['group_id'] ) )
				$group_id = $_GET['group_id'];
			else if( isset( $group ) )
				$group_id = $group->category_id;
			else
				$group_id = 0;
		}else{
			$man_id = 0;
			$group_id = 0;
		}
		
		$pricepoints = $mysqli->get_pricepoints( $level, $menu_id, $man_id, $group_id );
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_pricepoint_widget.php' ) )	
			include( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" . get_option( 'ec_option_base_layout' ) . "/ec_pricepoint_widget.php");
		else
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" . get_option( 'ec_option_latest_layout' ) . "/ec_pricepoint_widget.php");
		
		echo $after_widget;
	}
 
}
?>