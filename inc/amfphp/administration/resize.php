<?php
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licensed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

//load our connection settings
ob_start( NULL, 4096 );
require_once( '../../../../../../wp-load.php' );
global $wpdb;

$image_name = $_GET['src'];

if( isset( $_GET['w'] ) )
	$image_width = $_GET['w'];
else
	$image_width = 100;

if( isset( $_GET['h'] ) )
	$image_height = $_GET['h'];
else
	$image_height = 100;

if( isset( $_GET['zc'] ) )
	$image_zoomcrop = $_GET['zc'];
else
	$image_zoomcrop = 1;

$image = wp_get_image_editor( '../../../../wp-easycart-data/'.$image_name ); // Return an implementation that extends <tt>WP_Image_Editor</tt>

//echo '../../../../wp-easycart-data/'.$image_name;
if ( ! is_wp_error( $image ) ) {
    $image->resize( $image_width, $image_height, $image_zoomcrop );
	$image->stream();
}

?>