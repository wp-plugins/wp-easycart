<?php 
class ec_currencywidget extends WP_Widget{
	
	function ec_currencywidget(){
		$widget_ops = array('classname' => 'ec_currencywidget', 'description' => 'Displays a Currency Convertor for WP EasyCart' );
		$this->WP_Widget('ec_currencywidget', 'WP EasyCart Currency Conversion', $widget_ops);
	}
	
	function form( $instance ){ 
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'Select a Currency', 'text_domain' );
		}
		
		if( isset( $instance[ 'allowed_currencies' ] ) ) {
			$allowed_currencies = $instance[ 'allowed_currencies' ];
		}else {
			$allowed_currencies = __( 'USD,EUR,GBP,JPY', 'text_domain' );
		}
		
		echo "<p><label for=\"" . $this->get_field_name( 'title' ) . "\">" . _e( 'Title:' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'title' ) . "\" name=\"" . $this->get_field_name( 'title' ) . "\" type=\"text\" value=\"" . esc_attr( $title ) . "\" /></p>";
		
		echo "<p><label for=\"" . $this->get_field_name( 'allowed_currencies' ) . "\">" . _e( 'Allowed Currencies (currency codes separated by a comma):' ) . "</label><input class=\"widefat\" id=\"" . $this->get_field_id( 'allowed_currencies' ) . "\" name=\"" . $this->get_field_name( 'allowed_currencies' ) . "\" type=\"text\" value=\"" . esc_attr( $allowed_currencies ) . "\" /></p>";
		
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults);
	}
	
	function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['allowed_currencies'] = ( !empty( $new_instance['allowed_currencies'] ) ) ? strip_tags( $new_instance['allowed_currencies'] ) : '';

		return $instance;
	}
	
	
	function widget($args, $instance){
	
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$allowed_currencies = apply_filters( 'widget_allowed_currencies', $instance['allowed_currencies'] );
		$currencies = explode( ",", $allowed_currencies );
		
		$title = $GLOBALS['language']->convert_text( $title );
		
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		$selected_currency = get_option( 'ec_option_base_currency' );
		if( isset( $_SESSION['ec_convert_to'] ) ){
			$selected_currency = $_SESSION['ec_convert_to'];
		}
		
		// WIDGET CODE GOES HERE
		echo "<form action=\"\" method=\"POST\" id=\"currency\">";
		echo "<select name=\"ec_currency_conversion\" onchange=\"document.getElementById('currency').submit();\">";
		foreach( $currencies as $currency ){
			echo "<option value=\"" . $currency . "\"";
			if( $selected_currency == $currency )
				echo " selected=\"selected\"";
			echo ">" . $currency . "</option>";
		}
		echo "</select>";
		echo "</form>";
		
		echo $after_widget;
	}
 
}
?>