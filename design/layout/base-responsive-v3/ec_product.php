<?php 

// DISPLAY OPTIONS //   
if( isset( $product->page_options->product_type ) )
	$product_type = $product->page_options->product_type;
else
	$product_type = get_option( 'ec_option_default_product_type' );

if( isset( $product->page_options->use_quickview ) )
	$use_quickview = $product->page_options->use_quickview;
else
	$use_quickview = get_option( 'ec_option_default_quick_view' );
	
if( isset( $product->page_options->image_height_desktop ) )
	$image_height_desktop = $product->page_options->image_height_desktop;
else
	$image_height_desktop = get_option( 'ec_option_default_desktop_image_height' );
	
$show_rating = $product->use_customer_reviews;

// Check for Safari
$ua = $_SERVER["HTTP_USER_AGENT"];
$safariorchrome = strpos($ua, 'Safari') ? true : false;
$chrome = strpos($ua, 'Chrome') ? true : false;
if( $safariorchrome && !$chrome )
	$safari = true;
else
	$safari = false;

$ipad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
$iphone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');

if( $ipad || $iphone )
	$use_quickview = false;
	
if( isset( $_GET['preview'] ) ){
	$is_preview = true;
}else{
	$is_preview = false;
}

// Show admin if logged in and not using Safari
if( current_user_can( 'manage_options' ) && !$safari && !$is_preview )
	$admin_access = true;
else
	$admin_access = false;
// DISPLAY OPTIONS //
if( !$product->tag_bg_color ){
	$product->tag_bg_color = "#000000";
}

if( !$product->tag_text_color ){
	$product->tag_text_color = "#FFFFFF";
}
 
?>

<li class="ec_product_li" id="ec_product_li_<?php echo $product->model_number; ?>">

<?php 
/////////// QUICK VIEW ////////////////

if( $admin_access || $use_quickview ){ ?>
<div id="ec_product_quickview_container_<?php echo $product->model_number; ?>" class="ec_product_quickview_container">
	<div class="ec_product_quickview_content">
		<div class="ec_product_quickview_content_padding">
        	<div class="ec_product_quickview_content_holder">
                <div class="ec_product_quickview_content_images" data-image-list="<?php if( $product->images->use_optionitem_images ){ for( $i=0; $i<count( $product->images->imageset ); $i++ ){ if( $i > 0 ){ echo ","; } echo plugins_url( "/wp-easycart-data/products/pics1/" . $product->images->imageset[$i]->image1 ); } }else{ echo $product->get_first_image_url( ); if( trim( $product->images->image2 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics2/" . $product->images->image2 ); } if( trim( $product->images->image3 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics3/" . $product->images->image3 ); } if( trim( $product->images->image4 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics4/" . $product->images->image4 ); } if( trim( $product->images->image5 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics5/" . $product->images->image5 ); } } ?>">
                    <?php if( ( $product->images->use_optionitem_images && count( $product->images->imageset ) > 1 ) || trim( $product->images->image2 ) != "" ){ ?>
                    <div class="ec_flipbook_left">&#65513;</div>
                    <div class="ec_flipbook_right">&#65515;</div>
                    <?php }?>
                    <img src="<?php echo $product->get_first_image_url( ); ?>" />
                </div>
                <div class="ec_product_quickview_content_data">
                    <h1 class="ec_product_quickview_content_title"><a href="<?php echo $product->get_product_link( ); ?>"><?php echo $product->title; ?></a></h1>
                    <div class="ec_product_quickview_content_divider"></div>
                    <div class="ec_product_quickview_content_price"><?php if( $product->list_price > 0 ){ ?><span class="ec_list_price"><?php echo $GLOBALS['currency']->get_currency_display( $product->list_price ); ?></span><?php }?><span class="ec_price"><?php echo $GLOBALS['currency']->get_currency_display( $product->price ); ?></div>
                    <div class="ec_product_quickview_content_description"><?php echo $product->short_description; ?></div>
                    <?php if( count( $product->pricetiers[0] ) > 1 ){ ?>
                    
                    <ul class="ec_product_quickview_price_tier">
						<?php 
						foreach( $product->pricetiers as $pricetier ){
							$tier_price = $GLOBALS['currency']->get_currency_display( $pricetier[0] );
							$tier_quantity = $pricetier[1];
							?>
						
                        <li><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_tier_buy' ); ?> <?php echo $tier_quantity; ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_tier_buy_at' ); ?> <?php echo $tier_price; ?></li>
                        
						<?php } ?>
                    </ul>
					<?php }?>
					<?php if( $product->handling_price > 0 ){ ?>
                    <div class="ec_product_quickview_shipping_notice"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_handling_fee_notice1' ); ?> <?php echo $GLOBALS['currency']->get_currency_display( $product->handling_price ); ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_handling_fee_notice2' ); ?></div>
                    <?php } ?>
                    <div class="ec_product_quickview_content_add_to_cart_container">
                        <?php if( get_option( 'ec_option_display_as_catalog' ) ){
						// Show nothing
						
						}else if( $product->is_catalog_mode ){ ?>
						<div class="ec_seasonal_mode"><?php echo $product->catalog_mode_phrase; ?></div>	
        
						<?php }else if( $product->is_deconetwork ){ ?>
                        <div class="ec_product_quickview_content_add_to_cart"><a href="<?php echo $product->get_deconetwork_link( ); ?>"><?php echo $GLOBALS['language']->get_text( 'product_page', 'product_design_now' ); ?></a></div>
                        
                        <?php }else if( $product->in_stock( ) && ( $product->has_options( ) || $product->is_giftcard || $product->is_inquiry_mode || $product->is_donation ) ){ ?>
                        <div class="ec_product_quickview_content_add_to_cart"><a href="<?php echo $product->get_product_link( ); ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_select_options' ); ?></a></div>
                        
                        <?php }else if( $product->in_stock( ) && $product->is_subscription_item ){ ?>
                        <div class="ec_product_quickview_content_add_to_cart"><a href="<?php echo $product->get_subscription_link( ); ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_sign_up_now' ); ?></a></div>
                        
                        <?php }else if( $product->in_stock( ) ){ ?>
                        
                        <div class="ec_details_option_row_error" id="ec_addtocart_quantity_exceeded_error_<?php echo $product->model_number; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_maximum_quantity' ); ?></div>
            			<div class="ec_details_option_row_error" id="ec_addtocart_quantity_minimum_error_<?php echo $product->model_number; ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_minimum_quantity_text1' ); ?> <?php echo $product->min_purchase_quantity; ?> <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_minimum_quantity_text2' ); ?></div>
                        
                        <table class="ec_product_quickview_content_quantity">
                        	<tr>
                            	<td>
                        			<input type="button" value="-" class="ec_minus" onclick="ec_minus_quantity( '<?php echo $product->model_number; ?>', <?php echo $product->min_purchase_quantity; ?> );" />
                            	</td>
                                <td>
                                    <input type="number" value="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>" name="quantity" id="ec_quantity_<?php echo $product->model_number; ?>" autocomplete="off" step="1" min="<?php if( $product->min_purchase_quantity > 0 ){ echo $product->min_purchase_quantity; }else{ echo '1'; } ?>"<?php if( $product->show_stock_quantity ){ ?> max="<?php echo $product->stock_quantity; ?>"<?php }?> class="ec_quantity" />
                                </td>
                                <td>
                            		<input type="button" value="+" class="ec_plus" onclick="ec_plus_quantity( '<?php echo $product->model_number; ?>', <?php echo $product->show_stock_quantity; ?>, <?php echo $product->stock_quantity; ?> );" />
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="3">
                                	<input type="button" value="<?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_add_to_cart' ); ?>" onclick="ec_add_to_cart( '<?php echo $product->product_id; ?>', '<?php echo $product->model_number; ?>', jQuery( '#ec_quantity_<?php echo $product->model_number; ?>' ).val( ), <?php echo $product->show_stock_quantity; ?>, <?php echo $product->min_purchase_quantity; ?>, <?php echo $product->stock_quantity; ?> );" />
                                </td>
                             </tr>
                        </table>
                        
                        <?php }else{ ?>
                        <div class="ec_out_of_stock"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_out_of_stock' ); ?></div>
                        <?php }?>
                        
                        
                    </div>
                </div>
                <div class="ec_product_quickview_close"><input type="button" onclick="ec_product_hide_quick_view_link( '<?php echo $product->model_number; ?>' );" value="x"></div>
            </div>
        </div>
	</div>
</div>
<script>
jQuery( '#ec_product_quickview_container_<?php echo $product->model_number; ?>' ).appendTo( document.body );
</script>
<?php }  ?>


<?php ///// Admin editor /// ?>
<?php if( $admin_access ){ ?>
<div id="ec_product_editor_<?php echo $product->model_number; ?>" class="ec_product_editor" data-changes-made="0" data-model-number="<?php echo $product->model_number; ?>">
	<div><strong>Image Hover Effect</strong></div><div><select name="ec_product_image_hover_type" id="ec_product_image_hover_type_<?php echo $product->model_number; ?>" onchange="ec_admin_update_image_hover_effect( '<?php echo $product->model_number; ?>' );" data-default="<?php echo $product->image_hover_type; ?>"><option value="1"<?php if( $product->image_hover_type == '1' ){ echo ' selected="selected"'; }?>>Image Flip</option><option value="2"<?php if( $product->image_hover_type == '2' ){ echo ' selected="selected"'; }?>>Image Crossfade</option><option value="3"<?php if( $product->image_hover_type == '3' ){ echo ' selected="selected"'; }?>>Lighten</option><option value="5"<?php if( $product->image_hover_type == '5' ){ echo ' selected="selected"'; }?>>Image Grow</option><option value="6"<?php if( $product->image_hover_type == '6' ){ echo ' selected="selected"'; }?>>Image Shrink</option><option value="7"<?php if( $product->image_hover_type == '7' ){ echo ' selected="selected"'; }?>>Grey-Color</option><option value="8"<?php if( $product->image_hover_type == '8' ){ echo ' selected="selected"'; }?>>Brighten</option><option value="9"<?php if( $product->image_hover_type == '9' ){ echo ' selected="selected"'; }?>>Image Slide</option><option value="10"<?php if( $product->image_hover_type == '10' ){ echo ' selected="selected"'; }?>>FlipBook</option><option value="4"<?php if( $product->image_hover_type == '4' ){ echo ' selected="selected"'; }?>>No Effect</option></select></div>
    
    <div><strong>Image Effect</strong></div><div><select name="ec_product_image_effect_type" id="ec_product_image_effect_type_<?php echo $product->model_number; ?>" onchange="ec_admin_update_image_effect_type( '<?php echo $product->model_number; ?>' );" data-default="<?php echo $product->image_effect_type; ?>"><option value="none"<?php if( $product->image_effect_type == "none" ){ echo ' selected="selected"'; }?>>None</option><option value="border"<?php if( $product->image_effect_type == "border" ){ echo ' selected="selected"'; }?>>Border</option><option value="shadow"<?php if( $product->image_effect_type == "shadow" ){ echo ' selected="selected"'; }?>>Shadow</option></select></div>
    
    <div><strong>Tag Type</strong></div><div><select name="ec_product_tag_type" id="ec_product_tag_type_<?php echo $product->model_number; ?>" value="<?php echo $product->tag_type; ?>" onchange="ec_admin_update_tag_type( '<?php echo $product->model_number; ?>' );" data-default="<?php echo $product->tag_type; ?>"><option value="0"<?php if( $product->tag_type == "0" ){ echo ' selected="selected"'; }?>>No Tag</option><option value="1"<?php if( $product->tag_type == "1" ){ echo ' selected="selected"'; }?>>Round Tag</option><option value="2"<?php if( $product->tag_type == "2" ){ echo ' selected="selected"'; }?>>Square Tag</option><option value="3"<?php if( $product->tag_type == "3" ){ echo ' selected="selected"'; }?>>Diagonal Tag</option><option value="4"<?php if( $product->tag_type == "4" ){ echo ' selected="selected"'; }?>>Classy Tag</option></select></div>
    
    <div><strong>Tag Text</strong></div><div><input type="text" name="ec_product_tag_text" id="ec_product_tag_text_<?php echo $product->model_number; ?>" value="<?php echo $product->tag_text; ?>" onkeypress="ec_admin_update_tag_text( '<?php echo $product->model_number; ?>' );" onchange="ec_admin_update_tag_text( '<?php echo $product->model_number; ?>' );" data-default="<?php echo $product->tag_text; ?>" /></div>
    
    <div><span style="float:left; width:50%;"><strong>Tag Color</strong></span><span style="float:right; width:50%;"><strong>Tag Text Color</strong></span></div>
    
    <div class="ec_admin_product_color_selection"><span style="float:left; width:50%;"><input type="color" name="ec_product_tag_color" id="ec_product_tag_color_<?php echo $product->model_number; ?>" value="<?php echo $product->tag_bg_color; ?>" onchange="ec_admin_update_tag_color( '<?php echo $product->model_number; ?>' );" data-default="<?php echo $product->tag_bg_color; ?>" /></span><span style="float:right; width:50%;"><input type="color" name="ec_product_tag_text_color" id="ec_product_tag_text_color_<?php echo $product->model_number; ?>" value="<?php echo $product->tag_text_color; ?>" onchange="ec_admin_update_tag_color( '<?php echo $product->model_number; ?>' );" data-default="<?php echo $product->tag_text_color; ?>" /></span></div>
    
    <div><input type="submit" value="SAVE" onclick="ec_admin_save_product_display( '<?php echo $product->model_number; ?>' ); return false;" style="float:left; width:45%;" /><input type="submit" value="CANCEL" onclick="ec_admin_cancel_product_display( '<?php echo $product->model_number; ?>' ); return false;" style="float:right; width:45%;" /></div>
    
</div>

<div id="ec_product_editor_openclose_button_<?php echo $product->model_number; ?>" class="ec_product_openclose" onclick="ec_product_editor_openclose( '<?php echo $product->model_number; ?>' );"><div class="dashicons dashicons-admin-generic"></div></div>

<?php } // Close Admin Editor /// ?>

<?php ///////TAGS CODE//////// ?>
<?php if( $admin_access || $product->tag_type == 1 ){ ?>
	<span class="ec_tag1" style="color:<?php echo $product->tag_text_color; ?>; background: <?php echo $product->tag_bg_color; ?> !important;<?php if( $product->tag_type != 1 ){ ?> display:none;<?php }?>"><?php echo $product->tag_text; ?></span>
<?php }?>

<?php if( $admin_access || $product->tag_type == 2 ){ ?>
	<div class="ec_tag2"<?php if( $product->tag_type != 2 ){ ?> style="display:none;"<?php }?>><span style="background: none repeat scroll 0 0 <?php echo $product->tag_bg_color; ?>; color: <?php echo $product->tag_text_color; ?>;"><?php echo $product->tag_text; ?></span></div>
<?php }?>

<?php if( $admin_access || $product->tag_type == 3 ){ ?>
	<div class="ec_tag3" style="border-bottom-color:<?php echo $product->tag_bg_color; ?>; color:<?php echo $product->tag_text_color; ?>;<?php if( $product->tag_type != 3 ){ ?> display:none;<?php }?>"><span style="background-color:<?php echo $product->tag_bg_color; ?>;"><?php echo $product->tag_text; ?></span></div>
<?php }?>

<?php if( $admin_access || $product->tag_type == 4 ){ ?>
	<div class="ec_tag4"<?php if( $product->tag_type != 4 ){ ?> style="display:none;"<?php }?>><span style="color: <?php echo $product->tag_text_color; ?>;"><?php echo $product->tag_text; ?></span></div>
<?php }?>
	
	<div style="padding:0px; margin:auto; vertical-align:middle;<?php if( $product_type == 0 ){ ?> display:none;<?php }?>" class="ec_product_type<?php echo $product_type; ?>" id="ec_product_image_<?php echo $product->model_number; ?>">
    	
        <?php ///////////////// IMAGE HOLDER///////////// ?>
        <div id="ec_product_image_effect_<?php echo $product->model_number; ?>" class="ec_image_container_<?php echo $product->image_effect_type; ?>">
        	
        	<a href="<?php echo $product->get_product_link( ); ?>" class="ec_image_link_cover"></a>
        
        	<?php if( ( $admin_access || $product->image_hover_type == 1 ) && !$ipad && !$iphone ){ ?>
        	<div class="ec_flip_container"<?php if( $product->image_hover_type != 1 ){ ?> style="display:none;"<?php }?>>
            	<div class="ec_flipper">
					<div class="ec_image_front"><img src="<?php echo $product->get_first_image_url( ); ?>" /></div>
					<div class="ec_image_back"><img src="<?php echo $product->get_second_image_url( ); ?>" /></div>
        		</div>
            </div>
            <?php }
			
			if( ( $admin_access || $product->image_hover_type == 2 ) && !$ipad && !$iphone ){ ?>
        	<div class="ec_fade_container" style="height:<?php echo $image_height_desktop; ?>;<?php if( $product->image_hover_type != 2 ){ ?> display:none;<?php }?>">
            	<div class="ec_fadder">
					<div class="ec_image_front_2"><img src="<?php echo $product->get_first_image_url( ); ?>" /></div>
					<div class="ec_image_back_2"><img src="<?php echo $product->get_second_image_url( ); ?>" /></div>
        		</div>
            </div>
            <?php }
			
			if( ( $admin_access || $product->image_hover_type == 3 ) && !$ipad && !$iphone ){ ?>
        	<div class="ec_single_fade_container"<?php if( $product->image_hover_type != 3 ){ ?> style="display:none;"<?php }?>>
            	<div class="ec_single_fade"><img src="<?php echo $product->get_first_image_url( ); ?>" /></div>
            </div>
            <?php }
			
			if( $iphone || $ipad || $admin_access || $product->image_hover_type == 4 ){ ?>
            	<div class="ec_single_none_container"<?php if( !$iphone && !$ipad && $product->image_hover_type != 4 ){ ?> style="display:none;"<?php }?>>
					<?php $product->display_product_image_set( "medium", "ec_image_", "" ); ?>
				</div>
            <?php } 
			
			if( ( $admin_access || $product->image_hover_type == 5 ) && !$ipad && !$iphone ){ ?>
        	<div class="ec_single_grow_container"<?php echo $image_height_desktop; ?>;<?php if( $product->image_hover_type != 5 ){ ?> style="display:none;"<?php }?>>
            	<div class="ec_single_grow"><img src="<?php echo $product->get_first_image_url( ); ?>" /></div>
            </div>
            <?php } 
			
			if( ( $admin_access || $product->image_hover_type == 6 ) && !$ipad && !$iphone ){ ?>
        	<div class="ec_single_shrink_container"<?php if( $product->image_hover_type != 6 ){ ?> style="display:none;"<?php }?>>
            	<div class="ec_single_shrink"><img src="<?php echo $product->get_first_image_url( ); ?>" /></div>
            </div>
            <?php } 
			
			if( ( $admin_access || $product->image_hover_type == 7 ) && !$ipad && !$iphone ){ ?>
        	<div class="ec_single_btw_container"<?php if( $product->image_hover_type != 7 ){ ?> style="display:none;"<?php }?>>
            	<div class="ec_single_btw"><img src="<?php echo $product->get_first_image_url( ); ?>" /></div>
            </div>
            <?php }
			
			if( ( $admin_access || $product->image_hover_type == 8 ) && !$ipad && !$iphone ){ ?>
        	<div class="ec_single_brighten_container"<?php if( $product->image_hover_type != 8 ){ ?> style="display:none;"<?php }?>>
            	<div class="ec_single_brighten"><img src="<?php echo $product->get_first_image_url( ); ?>" /></div>
            </div>
            <?php }
			
			if( ( $admin_access || $product->image_hover_type == 9 ) && !$ipad && !$iphone ){ ?>
        	<div<?php if( $product->image_hover_type != 9 ){ ?> style="display:none;"<?php }?> class="ec_slide_container">
            	<img src="<?php echo $product->get_first_image_url( ); ?>" class="ec_image_front_3" />
				<img src="<?php echo $product->get_second_image_url( ); ?>" class="ec_image_back_3" />
            </div>
            <?php }
			
			if( ( $admin_access || $product->image_hover_type == 10 ) && !$ipad && !$iphone ){ ?>
        	
            <div class="ec_flipbook"<?php if( $product->image_hover_type != 10 ){ ?> style="display:none;"<?php }?> data-image-list="<?php if( $product->images->use_optionitem_images ){ for( $i=0; $i<count( $product->images->imageset ); $i++ ){ if( $i > 0 ){ echo ","; } echo plugins_url( "/wp-easycart-data/products/pics1/" . $product->images->imageset[$i]->image1 ); } }else{ echo $product->get_first_image_url( ); if( trim( $product->images->image2 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics2/" . $product->images->image2 ); } if( trim( $product->images->image3 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics3/" . $product->images->image3 ); } if( trim( $product->images->image4 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics4/" . $product->images->image4 ); } if( trim( $product->images->image5 ) != "" ){ echo "," . plugins_url( "/wp-easycart-data/products/pics5/" . $product->images->image5 ); } } ?>">
            	<div class="ec_flipbook_left">&#65513;</div>
                <div style="" class="ec_flipbook_right">&#65515;</div>
                <img src="<?php echo $product->get_first_image_url( ); ?>"/>
            </div>
			<?php } ?>
            
		</div>
        
        <?php /////// START CONTENT AREA //// ?>
        <div class="ec_product_meta_type6">
        	<h3 class="ec_product_title"><a href="<?php echo $product->get_product_link( ); ?>" class="ec_image_link_cover"><?php echo $product->title; ?></a></h3>
        	<div class="ec_product_description"><?php echo $product->short_description; ?></div>
            <div class="ec_price_container">
				<?php if( $product->list_price > 0 ){ ?>
                    <span class="ec_list_price"><?php echo $GLOBALS['currency']->get_currency_display( $product->list_price ); ?></span>
                <?php }?>
                <span class="ec_price"><?php echo $GLOBALS['currency']->get_currency_display( $product->price ); ?></span>
            </div>
            
            <?php if( $admin_access || $use_quickview ){ ?>
        	<div class="ec_product_quickview_container"><span class="ec_product_quickview"<?php if( !$use_quickview ){ echo " style='display:none;'"; } ?>><input type="button" onclick="ec_product_show_quick_view_link( '<?php echo $product->model_number; ?>' );" value="<?php echo $GLOBALS['language']->get_text( 'product_page', 'product_quick_view' ); ?>" /> </span></div>
        	<?php }?>
			
			<?php if( get_option( 'ec_option_display_as_catalog' ) ){
			// Show nothing
			
			}else if( $product->is_catalog_mode ){ ?>
			<div class="ec_seasonal_mode"><?php echo $product->catalog_mode_phrase; ?></div>	

			<?php }else if( $product->is_deconetwork ){ ?>
			<div class="ec_product_quickview_content_add_to_cart"><a href="<?php echo $product->get_deconetwork_link( ); ?>"><?php echo $GLOBALS['language']->get_text( 'product_page', 'product_design_now' ); ?></a></div>
			
			<?php }else if( $product->in_stock( ) && ( $product->has_options( ) || $product->is_giftcard || $product->is_inquiry_mode || $product->is_donation ) ){ ?>
            <div class="ec_product_addtocart_container"><span class="ec_product_addtocart"><a href="<?php echo $product->get_product_link( ); ?>" target="_self"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_select_options' ); ?></a></span></div>
            
            <?php }else if( $product->in_stock( ) && $product->is_subscription_item ){ ?>
            <div class="ec_product_addtocart_container"><span class="ec_product_addtocart"><a href="<?php echo $product->get_subscription_link( ); ?>" target="_self"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_sign_up_now' ); ?></a></span></div>
            
            <?php }else if( $product->in_stock( ) ){ ?>
            <div class="ec_product_addtocart_container"><span class="ec_product_addtocart"><a href="<?php echo $product->get_add_to_cart_link( ); ?>" onclick="ec_add_to_cart( '<?php echo $product->product_id; ?>', '<?php echo $product->model_number; ?>', 1 ); return false;">+ <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_add_to_cart' ); ?></a></span></div>
            <?php }else{ ?>
            <div class="ec_out_of_stock ec_oos_type_6"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_out_of_stock' ); ?></div>
            <?php }?>
        </div>
        
        <h3 class="ec_product_title_type<?php echo $product_type; ?>"><a href="<?php echo $product->get_product_link( ); ?>" class="ec_image_link_cover"><?php echo $product->title; ?></a></h3>
        <?php if( $show_rating && $product->get_rating( ) > 0 ){ 
			$average = $product->get_rating( );
		?>
        <div class="ec_product_stars_type<?php echo $product_type; ?>" title="Rated <?php echo number_format( floatval( $average ), 2 ); ?> out of 5"><span><?php $product->display_product_stars(); ?></span></div>
        <?php }?>
        <div class="ec_price_container_type<?php echo $product_type; ?>">
			<?php if( $product->list_price > 0 ){ ?>
        		<span class="ec_list_price_type<?php echo $product_type; ?>"><?php echo $GLOBALS['currency']->get_currency_display( $product->list_price ); ?></span>
       		<?php }?>
        	<span class="ec_price_type<?php echo $product_type; ?>"><?php echo $GLOBALS['currency']->get_currency_display( $product->price ); ?></span>
        </div>
        
        <?php if( get_option( 'ec_option_display_as_catalog' ) ){
		// Show nothing
		
		}else if( $product->is_catalog_mode ){ ?>
		<div class="ec_seasonal_mode"<?php if( $product_type == 6 ){ echo ' style="display:none;"'; } ?>><?php echo $product->catalog_mode_phrase; ?></div>	
		
		<?php }else if( $product->is_deconetwork ){ ?>
        <div class="ec_product_addtocart_container"><span class="ec_product_addtocart"><a href="<?php echo $product->get_deconetwork_link( ); ?>"><?php echo $GLOBALS['language']->get_text( 'product_page', 'product_design_now' ); ?></a></span></div>
        
        <?php }else if( $product->in_stock( ) && ( $product->has_options( ) || $product->is_giftcard || $product->is_inquiry_mode || $product->is_donation ) ){ ?>
        <div class="ec_product_addtocart_container"><span class="ec_product_addtocart"><a href="<?php echo $product->get_product_link( ); ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_select_options' ); ?></a></span></div>
        
        <?php }else if( $product->in_stock( ) && $product->is_subscription_item ){ ?>
        <div class="ec_product_addtocart_container"><span class="ec_product_addtocart"><a href="<?php echo $product->get_subscription_link( ); ?>"><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_sign_up_now' ); ?></a></span></div>
        
		<?php }else if( $product->in_stock( ) ){ ?>
        <div class="ec_product_addtocart_container"><span class="ec_product_addtocart"><a href="<?php echo $product->get_add_to_cart_link( ); ?>" onclick="ec_add_to_cart( '<?php echo $product->product_id; ?>', '<?php echo $product->model_number; ?>', 1 ); return false;">+ <?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_add_to_cart' ); ?></a></span></div>
        <?php }else{ ?>
        <div class="ec_out_of_stock ec_oos_type_1"<?php if( $product_type == 6 ){ echo ' style="display:none;"'; } ?>><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_out_of_stock' ); ?></div>
        <?php }?>
        <?php if( $admin_access || $use_quickview ){ ?>
        <span class="ec_product_quickview" <?php if( $product_type == 3 || $product_type == 4 ){ ?>style="top:<?php $quickview_top = substr( $image_height_desktop, 0, -2 ); echo ( $quickview_top - 21 ) . "px"; ?>;<?php if( !$use_quickview ){ echo " display:none;"; } ?>"<?php }else{ ?><?php if( !$use_quickview ){ echo "style='display:none;'"; } ?><?php }?>><input type="button" onclick="ec_product_show_quick_view_link( '<?php echo $product->model_number; ?>' ); return false;" value="<?php echo $GLOBALS['language']->get_text( 'product_page', 'product_quick_view' ); ?>" /></span>
        <?php }?>
        
        <div class="ec_product_successfully_added_container" id="ec_product_added_<?php echo $product->model_number; ?>"><div class="ec_product_successfully_added"><div><?php echo $GLOBALS['language']->get_text( 'ec_success', 'add_to_cart_success' ); ?></div></div></div>
        
        <div class="ec_product_loader_container" id="ec_product_loader_<?php echo $product->model_number; ?>"><div class="ec_product_loader"><div><?php echo $GLOBALS['language']->get_text( 'ec_success', 'adding_to_cart' ); ?></div></div></div>
        
    </div>
    
</li>