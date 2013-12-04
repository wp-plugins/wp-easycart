<?php 

$validate = new ec_validation; 
$license = new ec_license;

if(isset($_POST['isupdate'])){
	
	//update options
	$css_options = get_option( 'ec_option_css_replacements' ); 
	$css_split = explode( ",", $css_options );
	
	$css_options = "";
	
	for( $i=0; $i<count($css_split); $i++ ){
		$temp_split = explode( "=", $css_split[$i] );
		$key = $temp_split[0];
		$val = $_POST[$key];
		if( $i>0 )
			$css_options .= ",";
		$css_options .= $key . "=" . $val;
	}
	
	//update options
	$font_options = get_option( 'ec_option_font_replacements' ); 
	$font_split = explode( ":::", $font_options );
	
	$font_options = "";
	
	for( $i=0; $i<count($font_split); $i++ ){
		$temp_split = explode( "=", $font_split[$i] );
		$key = $temp_split[0];
		$val = $_POST[$key];
		if( $i>0 )
			$font_options .= ":::";
		$font_options .= $key . "=" . $val;
	}
	
	//update options
	$responsive_sizes = get_option( 'ec_option_responsive_sizes' ); 
	$sizes_split = explode( ":::", $responsive_sizes );
	
	$responsive_sizes = "";
	
	for( $i=0; $i<count($sizes_split); $i++ ){
		$temp_split = explode( "=", $sizes_split[$i] );
		$key = $temp_split[0];
		$val = $_POST[$key];
		if( $i>0 )
			$responsive_sizes .= ":::";
		$responsive_sizes .= $key . "=" . $val;
	}
	
	
	update_option( 'ec_option_css_replacements', $css_options );
	update_option( 'ec_option_font_replacements', $font_options );
	update_option( 'ec_option_responsive_sizes', $responsive_sizes );
	
	$ec_option_email_logo = strip_tags( stripslashes( $_POST["ec_option_email_logo"] ) );
    if( $ec_option_email_logo != "" )
		update_option( 'ec_option_email_logo', $ec_option_email_logo );

}
?>

<div class="wrap">
<?php if(!$license->is_registered()) {; ?>
<div class="ribbon">This banner appears when you have a WordPress EasyCart trial installed. To unlock the full version and to remove this banner, you must purchase a license at <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a></div>
<?php }?>

<img src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/images/WP-Easy-Cart-Logo.png' ); ?>" />
<script src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/colorpicker.js'); ?>"></script>
<script src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/eye.js'); ?>"></script>
<script>
jQuery( document ).ready(
	function( ){
 		jQuery( '#upload_logo_button' ).click(
			function( ){
				formfield = jQuery( '#ec_option_email_logo' ).attr( 'name' );
				tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
				return false;
			}
		);
 
		window.send_to_editor = function( html ){
			imgurl = jQuery( 'img', html ).attr( 'src' );
			jQuery( '#ec_option_email_logo' ).val( imgurl );
			jQuery( '#email_logo_image' ).attr( "src", imgurl );
			tb_remove();
		}
 	}
);
</script>
<?php if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ){ ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  


<div class="ec_contentwrap">
 
    <h2>Theme Options</h2>
    
    <form method="post" action="admin.php?page=ec_theme_options&settings-updated=true">
		<?php //settings_fields( 'ec-theme-options-group' ); ?>
        <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            
            <tr valign="top">
              <td width="27%" class="platformheading" scope="row">Custom Theme Color Options</td>
              <td width="73%" class="platformheadingimage" scope="row">
              	<img src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/images/settings_icon.png' ); ?>" alt="" width="25" height="25" />
              </td>
            </tr>
            <?php 
			$labels = array( 	"main_color" 		=> "Main Color",
								"second_color"		=> "Second Color",
								"third_color"		=> "Third Color",
								"title_color"		=> "Title Text Color",
								"text_color"		=> "Content Text Color",
								"link_color"		=> "Basic Link Color",
								"link_hover_color"	=> "Basic Link Mouse Over Color",
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
			
			foreach( $css_split as $css_item ){
				$temp_split = explode( "=", $css_item );
				
			?>
            
            <tr valign="top">
              <td class="itemheading" scope="row"><?php echo $labels[$temp_split[0]]; ?>:</td>
              <td scope="row">
              	<input type="text" name="<?php echo $temp_split[0]; ?>" id="<?php echo $temp_split[0]; ?>" value="<?php echo $temp_split[1]; ?>" class="ec_color_block_input" /><div class="ec_color_block" id="<?php echo $temp_split[0]; ?>_colorblock"></div>
                
                </td>
             </tr>
             <script>
			 	jQuery('#<?php echo $temp_split[0]; ?>_colorblock').css('backgroundColor', '<?php echo $temp_split[1]; ?>');
				
				jQuery('#<?php echo $temp_split[0]; ?>_colorblock').ColorPicker({
					color:'<?php echo $temp_split[1]; ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						jQuery('#<?php echo $temp_split[0]; ?>').val("#" + hex);
						jQuery('#<?php echo $temp_split[0]; ?>_colorblock').css('backgroundColor', '#' + hex);
					}

				});
             </script>
           <?php } 
		   
		   		// Get the Google Font Options
				$response = (array)wp_remote_request( "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAprmWHw-alcYMQ2-7cuUGQ3iWI_IexLQ8" ); 
				$fonts = json_decode( $response['body'] )->items;
				
		   ?>
           
           <tr valign="top">
              <td width="27%" class="platformheading" scope="row">Custom Theme Font Family Options</td>
              <td width="73%" class="platformheadingimage" scope="row">
              	<img src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/images/settings_icon.png' ); ?>" alt="" width="25" height="25" />
              </td>
            </tr>
           
            <?php 
			$font_options = get_option( 'ec_option_font_replacements' ); 
			$font_split = explode( ":::", $font_options );
			
			if( count( $font_split ) != 3 ){
				$font_options = "title_font=Arial, Helvetica, sans-serif:::subtitle_font=Arial, Helvetica, sans-serif:::content_font=Arial, Helvetica, sans-serif";
				update_option( 'ec_option_font_replacements', $font_options );
				$font_split = explode( ":::", $font_options );
			}
			
			foreach( $font_split as $font_item ){
				$temp_split = explode( "=", $font_item );
				$font_name = $temp_split[1];
			?>
             
             <tr valign="top">
              <td class="itemheading" scope="row"><?php echo $labels[$temp_split[0]]; ?>:</td>
              <td scope="row">
              	<?php
				echo "<select name=\"" . $temp_split[0] . "\">";
					
					echo "<option value='Verdana, Geneva, sans-serif'"; if( $font_name == "Verdana, Geneva, sans-serif" ){ echo " selected=\"selected\""; } echo ">Verdana, Geneva, sans-serif</option>";
					
					echo "<option value='Georgia, Times New Roman, Times, serif'"; if( $font_name == "Georgia, Times New Roman, Times, serif" ){ echo " selected=\"selected\""; } echo ">Georgia, Times New Roman, Times, serif</option>";
					
					echo "<option value='Courier New, Courier, monospace'"; if( $font_name == 'Courier New, Courier, monospace' ){ echo " selected=\"selected\""; } echo ">Courier New, Courier, monospace</option>";
					
					echo "<option value='Arial, Helvetica, sans-serif'"; if( $font_name == "Arial, Helvetica, sans-serif" ){ echo " selected=\"selected\""; } echo ">Arial, Helvetica, sans-serif</option>";
					
					echo "<option value='Tahoma, Geneva, sans-serif'"; if( $font_name == "Tahoma, Geneva, sans-serif" ){ echo " selected=\"selected\""; } echo ">Tahoma, Geneva, sans-serif</option>";
					
					echo "<option value='Trebuchet MS, Arial, Helvetica, sans-serif'"; if( $font_name == 'Trebuchet MS, Arial, Helvetica, sans-serif' ){ echo " selected=\"selected\""; } echo ">Trebuchet MS, Arial, Helvetica, sans-serif</option>";
					
					echo "<option value='Arial Black, Gadget, sans-serif'"; if( $font_name == 'Arial Black, Gadget, sans-serif' ){ echo " selected=\"selected\""; } echo ">Arial Black, Gadget, sans-serif</option>";
					
					echo "<option value='Times New Roman, Times, serif'"; if( $font_name == 'Times New Roman, Times, serif' ){ echo " selected=\"selected\""; } echo ">Times New Roman, Times, serif</option>";
					
					echo "<option value='Palatino Linotype, Book Antiqua, Palatino, serif'"; if( $font_name == 'Palatino Linotype, Book Antiqua, Palatino, serif' ){ echo " selected=\"selected\""; } echo ">Palatino Linotype, Book Antiqua, Palatino, serif</option>";
					
					echo "<option value='Lucida Sans Unicode, Lucida Grande, sans-serif'"; if( $font_name == 'Lucida Sans Unicode, Lucida Grande, sans-serif' ){ echo " selected=\"selected\""; } echo ">Lucida Sans Unicode, Lucida Grande, sans-serif</option>";
					
					echo "<option value='MS Serif, New York, serif'"; if( $font_name == 'MS Serif, New York, serif' ){ echo " selected=\"selected\""; } echo ">MS Serif, New York, serif</option>";
					
					echo "<option value='Lucida Console, Monaco, monospace'"; if( $font_name == 'Lucida Console, Monaco, monospace' ){ echo " selected=\"selected\""; } echo ">Lucida Console, Monaco, monospace</option>";
					
					echo "<option value='Comic Sans MS, cursive'"; if( $font_name == 'Comic Sans MS, cursive' ){ echo " selected=\"selected\""; } echo ">Comic Sans MS, cursive</option>";
					
					foreach( $fonts as $font ){
						echo "<option value=\"" . $font->family . "\"";
						if( $font_name == $font->family ){ echo " selected=\"selected\""; }
						echo ">" . $font->family . "</option>";	
					}
				echo "</select>";
				?>
              </td>
            </tr>
            <?php }?>
            
            <tr valign="top">
              <td width="27%" class="platformheading" scope="row">Custom Theme Responsive Sizing Options</td>
              <td width="73%" class="platformheadingimage" scope="row">
              	<img src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/images/settings_icon.png' ); ?>" alt="" width="25" height="25" />
              </td>
            </tr>
            
            <?php
            $resize_options = get_option( 'ec_option_responsive_sizes' ); 
			$resize_split = explode( ":::", $resize_options );
			
			if( count( $resize_split ) != 8 ){
				$resize_options = "size_level1_high=479:::size_level2_low=480:::size_level2_high=767:::size_level3_low=768:::size_level3_high=960:::size_level4_low=961:::size_level4_high=1300:::size_level5_low=1301";
				update_option( 'ec_option_responsive_sizes', $resize_options );
				$resize_split = explode( ":::", $resize_options );
			}
			
			foreach( $resize_split as $resize_item ){
				$temp_split = explode( "=", $resize_item );
				
			?>
            
            <tr valign="top">
              <td class="itemheading" scope="row"><?php echo $labels[$temp_split[0]]; ?>:</td>
              <td scope="row">
              	<input type="text" name="<?php echo $temp_split[0]; ?>" id="<?php echo $temp_split[0]; ?>" value="<?php echo $temp_split[1]; ?>" class="ec_color_block_input" />px
                </td>
             </tr>
             
             <?php }?>
             
             <tr valign="top">
              <td width="27%" class="platformheading" scope="row">Custom Theme Image Options</td>
              <td width="73%" class="platformheadingimage" scope="row">
              	<img src="<?php echo plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/images/settings_icon.png' ); ?>" alt="" width="25" height="25" />
              </td>
            </tr>
             
            <tr valign="top">
            	<td class="itemheading" scope="row">Email Receipt Logo:</td>
                <td scope="row">
                    <input id="ec_option_email_logo" type="hidden" size="36" name="ec_option_email_logo" value="<?php echo get_option( 'ec_option_email_logo' ); ?>" />
                    <img src="<?php echo get_option( 'ec_option_email_logo' ); ?>" id="email_logo_image" /><br />
                    <input id="upload_logo_button" type="button" class="button" value="Upload Logo" />
                    
                </td>
            </tr>
            
            <tr valign="top">
              <td colspan="2" scope="row">
              	<p class="submit">
                <input type="hidden" name="isupdate" value="1" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
              </td>
            </tr> 
            </table>
      
		</form>
    </div>
</div>