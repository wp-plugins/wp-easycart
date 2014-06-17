<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "colorize-easycart" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_colors" ){
	ec_update_colors( );
	$isupdate = true;
}
?>

<link rel="stylesheet" id="wpeasycart_css-css" href="<?php echo plugins_url( 'wp-easycart/inc/scripts/ec_css_loader.php' ); ?>" type="text/css" media="all">
<script type="text/javascript" src="<?php echo plugins_url( 'wp-easycart/inc/scripts/ec_js_loader.php' ); ?>"></script>
<script>
jQuery( 
	function(){
		var bCanPreview = false; // can preview
	 
		// create canvas and context objects
		var canvas = document.getElementById('picker');
		var ctx = canvas.getContext('2d');
 	
		// drawing active image
		var image = new Image();
		image.onload = function () {
			ctx.drawImage(image, 0, 0, image.width, image.height); // draw the image on the canvas
		}
 
		// select desired colorwheel
		var imagesrc = "<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/colorwheel1.png' ); ?>";
		switch( jQuery( canvas ).attr( 'var' ) ) {
			case '2':
				imagesrc="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/colorwheel2.png' ); ?>";
				break;
			case '3':
				imagesrc="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/colorwheel3.png' ); ?>";
				break;
			case '4':
				imagesrc="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/colorwheel4.png' ); ?>";
				break;
			case '5':
				imagesrc="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/colorwheel5.png' ); ?>";
				break;
			case '6':
				imagesrc="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/colorwheel6.png' ); ?>";
				break;
		}
		image.src = imagesrc;
 	
		jQuery('#picker').mousemove(
			function(e) { // mouse move handler
				if (bCanPreview) {
					// get coordinates of current position
					var canvasOffset = jQuery(canvas).offset();
					var canvasX = Math.floor(e.pageX - canvasOffset.left);
					var canvasY = Math.floor(e.pageY - canvasOffset.top);
	 	
					// get current pixel
					var imageData = ctx.getImageData(canvasX, canvasY, 1, 1);
					var pixel = imageData.data;
		 
					// update preview color
					var pixelColor = "rgb("+pixel[0]+", "+pixel[1]+", "+pixel[2]+")";
					jQuery('.preview').css('backgroundColor', pixelColor);
 		
					// update controls
					jQuery('#rVal').val(pixel[0]);
					jQuery('#gVal').val(pixel[1]);
					jQuery('#bVal').val(pixel[2]);
					jQuery('#rgbVal').val(pixel[0]+','+pixel[1]+','+pixel[2]);
 	
					var dColor = pixel[2] + 256 * pixel[1] + 65536 * pixel[0];
					jQuery('#hexVal').val('#' + ('0000' + dColor.toString(16)).substr(-6));
					
					// Continuously update the preview
					ec_update_color_preview( document.getElementById( 'hexVal' ).value );
				}
			}
		);
	
		jQuery('#picker').click(
			function(e) { // click event handler
				ec_update_color_preview( document.getElementById( 'hexVal' ).value );
				bCanPreview = !bCanPreview;
			}
		);
	
		jQuery('.preview').click(
			function(e) { // preview click
				jQuery('.colorpicker').fadeToggle("slow", "linear");
				bCanPreview = true;
			}
		);
	}
);	

function ec_update_color_preview( color ){
	document.getElementById( 'main_color' ).value = color;
	document.getElementById( 'link_hover_color' ).value = color;
	jQuery( '.ec_product_details_add_to_cart_button' ).css( 'cssText', 'background-color:' + color + " !important;" );
	jQuery( '.ec_product_details_price .ec_product_sale_price' ).css( 'cssText', 'color:' + color + " !important;" );
	jQuery( '.ec_product_details_tab_selected' ).css( 'cssText', 'background-color:' + color + " !important;" );
	jQuery( '.ec_product_details_customer_reviews_button a' ).css( 'cssText', 'background-color:' + color + " !important;" );
	jQuery( '#main_color_block' ).css( 'cssText', 'background-color:' + color + " !important;" );
	jQuery( '#link_hover_color_block' ).css( 'cssText', 'background-color:' + color + " !important;" );
}

jQuery( document ).ready( function( $ ){
	
	var custom_uploader;
	
	jQuery( '#upload_logo_button' ).click( function( e ){
 
		e.preventDefault( );
		
		if( custom_uploader ){
			custom_uploader.open( );
			return;
		}

		custom_uploader = wp.media.frames.file_frame = wp.media( {
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		} );
 
		custom_uploader.on( 'select', function( ){
			attachment = custom_uploader.state( ).get( 'selection' ).first( ).toJSON( );
			jQuery( '#email_logo_image' ).attr( "src", attachment.url );
			jQuery( '#ec_option_email_logo' ).val( attachment.url );
		} );
 
		custom_uploader.open( );
 
	});
} );
</script>

<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Colorization saved.</strong></p></div>
<?php }?> 

<div class="ec_admin_page_title">Colorize EasyCart</div>
<div class="ec_adin_page_intro">This page is for demonstration purposes only, if you do not save the values, it will not be applied. In addition, the styles for your theme are NOT loaded here, because of this the display may vary from here to your actual store. To begin colorizing, click inside the color wheel, to apply the color, click again. Values are automatically inserted into the correct boxes, click update to save your changes or refresh the page to cancel.</div>

<div class="ec_preview" style="display:none"></div>
<div class="ec_colorpicker">
	<canvas id="picker" var="6" width="300" height="300"></canvas>
	<div class="ec_controls">
		<div><label>R</label> <input type="text" id="rVal" /></div>
		<div><label>G</label> <input type="text" id="gVal" /></div>
		<div><label>B</label> <input type="text" id="bVal" /></div>
		<div><label>RGB</label> <input type="text" id="rgbVal" /></div>
		<div><label>HEX</label> <input type="text" id="hexVal" /></div>
	</div>
</div>

<div class="ec_color_inputs">
	<?php 
	$labels = array( 	"main_color" 		=> "Main Color",
						"second_color"		=> "Second Color",
						"third_color"		=> "Third Color",
						"title_color"		=> "Title Text Color",
						"text_color"		=> "Content Text Color",
						"link_color"		=> "Basic Link Color",
						"link_hover_color"	=> "Basic Link Hover Color",
						"sale_color"		=> "Item Sale Color",
						"backdrop_color"	=> "Popup Window Backdrop Color",
						"content_bg"		=> "Popup Window Background Color",
						"error_text"		=> "Error Text Color",
						"error_color"		=> "Error Background Color",
						"error_color2"		=> "Error Box Border Color",
						"success_text"		=> "Success Text Color",
						"success_color"		=> "Success Background Color",
						"success_color2"	=> "Success Border Color",
						"title_font"		=> "Title Font Family",
						"subtitle_font"		=> "Subtitle Font Family",
						"content_font"		=> "General Content Font Family",
						"size_level1_high"	=> "Max Width Phone",
						"size_level2_low"	=> "Min Width Large Phone",
						"size_level2_high"	=> "Max Width Large Phone",
						"size_level3_low"	=> "Min Width Tablet",
						"size_level3_high"	=> "Max Width Tablet",
						"size_level4_low"	=> "Min Width Smaller Desktop",
						"size_level4_high"	=> "Max Width Smaller Desktop",
						"size_level5_low"	=> "Min Width Desktop"
					);
	
	$css_options = get_option( 'ec_option_css_replacements' ); 
	$css_split = explode( ",", $css_options );
	
	if( count( $css_split ) != 16 ){
		$css_options = "main_color=#242424,second_color=#6b6b6b,third_color=#adadad,title_color=#0f0f0f,text_color=#141414,link_color=#242424,link_hover_color=#121212,sale_color=#900,backdrop_color=#333,content_bg=#FFF,error_text=#900,error_color=#F1D9D9,error_color2=#FF0606,success_text=#333,success_color=#E6FFE6,success_color2=#6FFF47";
		update_option( 'ec_option_css_replacements', $css_options );
		$css_split = explode( ",", $css_options );
	}
	?>
    <form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=colorize-easycart&ec_action=save_colors" method="POST">
    <?php
	foreach( $css_split as $css_item ){
		$temp_split = explode( "=", $css_item );
	?>
	
	<div class="ec_colorizer_row<?php if( $temp_split[0] != "main_color" ){ echo "_inactive"; } ?>"><span class="ec_colorizer_row_label"><?php echo $labels[$temp_split[0]]; ?>: </span><span class="ec_colorizer_row_input"><input type="text" name="<?php echo $temp_split[0]; ?>" id="<?php echo $temp_split[0]; ?>" value="<?php echo $temp_split[1]; ?>" class="ec_color_block_input" /></span><span class="ec_color_square" id="<?php echo $temp_split[0]; ?>_block" style="background-color:<?php echo $temp_split[1]; ?>;"></span></div>
	<?php } ?>
    
    <div class="ec_colorizer_row_receipt_logo"><input id="upload_logo_button" type="button" class="button" value="Upload Receipt Logo" /></div>
    <div class="ec_colorizer_row">
    <?php // Logo Uploader ?>
    <input id="ec_option_email_logo" type="hidden" size="36" name="ec_option_email_logo" value="<?php echo get_option( 'ec_option_email_logo' ); ?>" />
    <img src="<?php echo get_option( 'ec_option_email_logo' ); ?>" id="email_logo_image" /><br />
    
    </div>
    
    <div class="ec_colorizer_button_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
    </form>
</div>

<div id="ec_prod_preview">
	<?php 
	$db = new ec_db_admin( );
	$products = $db->get_product_list( "", "", " LIMIT 1 ", "" );
	if( count( $products ) > 0 ){
		$store_page = new ec_storepage( "", "", "", "", "", $products[0]["model_number"] );
		$store_page->display_store_page();
	}
	?>
</div>