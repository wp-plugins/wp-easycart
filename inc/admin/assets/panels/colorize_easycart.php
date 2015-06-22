<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "colorize-easycart" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_colors" && isset( $_POST['ec_option_details_main_color'] ) ){
	ec_update_colors( );
	$isupdate = true;
}
?>



<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Colorization saved.</strong></p></div>
<?php }?> 

<div class="ec_admin_page_title">Colorize EasyCart</div>
<div class="ec_adin_page_intro">This page allows you to set a default color, default sizing, and default design options. If you have upgraded to a V3 design package, you will be able to set defaults, which will be applied to all pages that you have not specifically set values to. If you wish to edit on a page by page basis, simply visit the page and use the live editing tools.</div>

<?php if( get_option( 'ec_option_base_theme' ) && !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){ 
/* V2 COLORIZER ONLY */
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

</script>
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
<?php }else{ ?>
<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=colorize-easycart&ec_action=save_colors" method="POST">
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Receipt Logo: </span>
            <?php // Logo Uploader ?>
            <span class="ec_colorizer_row_input">
                <input id="upload_logo_button" type="button" class="button" value="Upload Receipt Logo" />
                <input id="ec_option_email_logo" type="hidden" size="36" name="ec_option_email_logo" value="<?php echo get_option( 'ec_option_email_logo' ); ?>" />
            </span>
            <img src="<?php echo get_option( 'ec_option_email_logo' ); ?>" id="email_logo_image" style="margin-left:75px;" />
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Main Color: </span>
        <span class="ec_colorizer_row_input"><input type="color" name="ec_option_details_main_color" id="ec_option_details_main_color" value="<?php echo get_option( 'ec_option_details_main_color' ); ?>" class="ec_color_block_input" style="width:45px;" /></span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Second Color: </span>
        <span class="ec_colorizer_row_input"><input type="color" name="ec_option_details_second_color" id="ec_option_details_second_color" value="<?php echo get_option( 'ec_option_details_second_color' ); ?>" class="ec_color_block_input" style="width:45px;" /></span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Theme Background: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_use_dark_bg" id="ec_option_use_dark_bg">
    			<option value="1"<?php if( get_option( 'ec_option_use_dark_bg' ) == "1" ){?> selected="selected"<?php }?>>Dark Background</option>
        	    <option value="0"<?php if( get_option( 'ec_option_use_dark_bg' ) == "0" ){?> selected="selected"<?php }?>>Light Background</option>
    		</select>
    	</span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Page Options</div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Product Type: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_product_type" id="ec_option_default_product_type">
                <option value="1"<?php if( get_option( 'ec_option_default_product_type' ) == '1' ){ echo " selected='selected'"; }?>>Grid Type 1</option>
                <option value="2"<?php if( get_option( 'ec_option_default_product_type' ) == '2' ){ echo " selected='selected'"; }?>>Grid Type 2</option>
                <option value="3"<?php if( get_option( 'ec_option_default_product_type' ) == '3' ){ echo " selected='selected'"; }?>>Grid Type 3</option>
                <option value="4"<?php if( get_option( 'ec_option_default_product_type' ) == '4' ){ echo " selected='selected'"; }?>>Grid Type 4</option>
                <option value="5"<?php if( get_option( 'ec_option_default_product_type' ) == '5' ){ echo " selected='selected'"; }?>>Grid Type 5</option>
                <option value="6"<?php if( get_option( 'ec_option_default_product_type' ) == '6' ){ echo " selected='selected'"; }?>>List Type 6</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Hover Effect: </span>
        <span class="ec_colorizer_row_input">
            <select name="ec_option_default_product_image_hover_type" id="ec_option_default_product_image_hover_type">
                <option value="1"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '1' ){ echo " selected='selected'"; }?>>Image Flip</option>
                <option value="2"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '2' ){ echo " selected='selected'"; }?>>Image Crossfade</option>
                <option value="3"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '3' ){ echo " selected='selected'"; }?>>Lighten</option>
                <option value="5"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '5' ){ echo " selected='selected'"; }?>>Image Grow</option>
                <option value="6"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '6' ){ echo " selected='selected'"; }?>>Image Shrink</option>
                <option value="7"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '7' ){ echo " selected='selected'"; }?>>Grey-Color</option>
                <option value="8"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '8' ){ echo " selected='selected'"; }?>>Brighten</option>
                <option value="9"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '9' ){ echo " selected='selected'"; }?>>Image Slide</option>
                <option value="10"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '10' ){ echo " selected='selected'"; }?>>FlipBook</option>
                <option value="4"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '4' ){ echo " selected='selected'"; }?>>No Effect</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Effect: </span>
        <span class="ec_colorizer_row_input">
            <select name="ec_option_default_product_image_effect_type" id="ec_option_default_product_image_effect_type">
                <option value="none"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'none' ){ echo " selected='selected'"; }?>>None</option>
                <option value="border"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'border' ){ echo " selected='selected'"; }?>>Border</option>
                <option value="shadow"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'shadow' ){ echo " selected='selected'"; }?>>Shadow</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Quick View: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_quick_view" id="ec_option_default_quick_view">
            	<option value="1"<?php if( get_option( 'ec_option_default_quick_view' ) == '1' ){ echo " selected='selected'"; }?>>On</option>
            	<option value="0"<?php if( get_option( 'ec_option_default_quick_view' ) == '0' ){ echo " selected='selected'"; }?>>Off</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Use Dynamic Images: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_dynamic_sizing" id="ec_option_default_dynamic_sizing">
            	<option value="1"<?php if( get_option( 'ec_option_default_dynamic_sizing' ) == '1' ){ echo " selected='selected'"; }?>>On</option>
            	<option value="0"<?php if( get_option( 'ec_option_default_dynamic_sizing' ) == '0' ){ echo " selected='selected'"; }?>>Off</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Desktop Options</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
            <select name="ec_option_default_desktop_columns" id="ec_option_default_desktop_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_desktop_image_height" id="ec_option_default_desktop_image_height" type="number" value="<?php if( get_option( 'ec_option_default_desktop_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_desktop_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Tablet Landscape</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_laptop_columns" id="ec_option_default_laptop_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_laptop_image_height" id="ec_option_default_laptop_image_height" type="number" value="<?php if( get_option( 'ec_option_default_laptop_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_laptop_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Tablet Portrait</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_tablet_wide_columns" id="ec_option_default_tablet_wide_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_tablet_wide_image_height" id="ec_option_default_tablet_wide_image_height" type="number" value="<?php if( get_option( 'ec_option_default_tablet_wide_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_tablet_wide_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Smartphone Landscape</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_tablet_columns" id="ec_option_default_tablet_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_tablet_image_height" id="ec_option_default_tablet_image_height" type="number" value="<?php if( get_option( 'ec_option_default_tablet_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_tablet_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Smartphone Portrait</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_smartphone_columns" id="ec_option_default_smartphone_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_smartphone_image_height" id="ec_option_default_smartphone_image_height" type="number" value="<?php if( get_option( 'ec_option_default_smartphone_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_smartphone_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Product Details Columns</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Desktop: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_desktop" id="ec_option_details_columns_desktop">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_desktop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_desktop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_laptop" id="ec_option_details_columns_laptop">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_laptop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_laptop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_tablet_wide" id="ec_option_details_columns_tablet_wide">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_tablet_wide' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_tablet_wide' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_tablet" id="ec_option_details_columns_tablet">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_tablet' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_tablet' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_smartphone" id="ec_option_details_columns_smartphone">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_smartphone' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_smartphone' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Cart Page Columns</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Desktop: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_desktop" id="ec_option_cart_columns_desktop">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_laptop" id="ec_option_cart_columns_laptop">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_tablet_wide" id="ec_option_cart_columns_tablet_wide">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_tablet" id="ec_option_cart_columns_tablet">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_smartphone" id="ec_option_cart_columns_smartphone">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_button_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>
	
<?php }?>
<script>
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