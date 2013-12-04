// JavaScript Document
jQuery(document).ready(function() {
	var hasTouch = ("ontouchstart" in window);
	if( hasTouch ){
		var elements = jQuery( ".has-submenu" );
		for( var i=0; i<elements.length; i++){
			elements[i].addEventListener( "click", ec_horizontal_click, false);
		}
	}
	
	function ec_horizontal_click( e ) {
		e.preventDefault();
	}
});