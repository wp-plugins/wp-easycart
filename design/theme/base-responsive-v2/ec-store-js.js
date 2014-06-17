function ec_product_show_quick_view_link( modelnum ){
	jQuery('#ec_product_quick_view_' + modelnum).fadeIn(100);	
}

function ec_product_hide_quick_view_link( modelnum ){
	jQuery('#ec_product_quick_view_' + modelnum).fadeOut(100);	
}

function ec_product_show_quick_view( modelnum ){
	jQuery('#ec_product_quick_view_box_' + modelnum).fadeIn(100);
}

function ec_product_hide_quick_view( modelnum ){
	jQuery('#ec_product_quick_view_box_' + modelnum).fadeOut(100);
}

function ec_thumb_quick_view_click( modelnum, level, imgnum ){
	
	if( document.getElementById( 'ec_image_quick_view_' + modelnum + "_" + 1 + "_" + level ) ){
		jQuery('#ec_image_quick_view_' + modelnum + "_" + 1 + "_" + level ).hide();
	}
		
		
	if( document.getElementById( 'ec_image_quick_view_' + modelnum + "_" + 2 + "_" + level ) )
		jQuery('#ec_image_quick_view_' + modelnum + "_" + 2 + "_" + level ).hide();
		
		
	if( document.getElementById( 'ec_image_quick_view_' + modelnum + "_" + 3 + "_" + level ) )
		jQuery('#ec_image_quick_view_' + modelnum + "_" + 3 + "_" + level ).hide();
		
		
	if( document.getElementById( 'ec_image_quick_view_' + modelnum + "_" + 4 + "_" + level ) )
		jQuery('#ec_image_quick_view_' + modelnum + "_" + 4 + "_" + level ).hide();
		
		
	if( document.getElementById( 'ec_image_quick_view_' + modelnum + "_" + 5 + "_" + level ) )
		jQuery('#ec_image_quick_view_' + modelnum + "_" + 5 + "_" + level ).hide();
	
	jQuery('#ec_image_quick_view_' + modelnum + "_" + imgnum + "_" + level ).show();
	
}

function ec_image_quick_view_click( modelnum, level, imgnum ){
	return false;
}

function product_quantity_change( ){
	// Possibly do something on quantity change
}

function ec_swatch_quick_view_click( modelnum, level, imgnum ){
	
	if( level == 1 && document.getElementById( 'use_optionitem_images_' + modelnum ).value == 1 ){
		ec_image_quick_view_update( modelnum, level, imgnum );
	}
	
	if(document.getElementById( 'ec_swatch_quick_view_' + modelnum + "_" + level + "_" + imgnum ).className != "ec_product_swatch_out_of_stock"){
		
		var i=0;
		while( document.getElementById( 'ec_swatch_quick_view_' + modelnum + "_" + level + "_" + i ) ){
					
			if( document.getElementById( 'ec_swatch_quick_view_' + modelnum + "_" + level + "_" + i ).className != "ec_product_swatch_out_of_stock"){
				document.getElementById( 'ec_swatch_quick_view_' + modelnum + "_" + level + "_" + i ).className = "ec_product_swatch";
			}
			
			i++;
		}
				
		document.getElementById( 'ec_swatch_quick_view_' + modelnum + "_" + level + "_" + imgnum ).className = "ec_product_swatch_selected";	
	}
	
}

function ec_image_quick_view_update( modelnum, level, imgnum ){
	if(this.document.getElementById( 'ec_swatch_' + modelnum + "_" + level + "_" + imgnum ).className != "ec_product_swatch_out_of_stock"){
		
		var i=0;
		while( this.document.getElementById( 'ec_swatch_' + modelnum + "_" + level + "_" + i ) ){
			
			if(this.document.getElementById( 'ec_image_quick_view_'  + modelnum + "_" + 1 + "_" + i ))
				jQuery('#ec_image_quick_view_'  + modelnum + "_" + 1 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_image_quick_view_'  + modelnum + "_" + 2 + "_" + i ))
				jQuery('#ec_image_quick_view_'  + modelnum + "_" + 2 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_image_quick_view_'  + modelnum + "_" + 3 + "_" + i ))
				jQuery('#ec_image_quick_view_'  + modelnum + "_" + 3 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_image_quick_view_'  + modelnum + "_" + 4 + "_" + i ))
				jQuery('#ec_image_quick_view_'  + modelnum + "_" + 4 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_image_quick_view_'  + modelnum + "_" + 5 + "_" + i ))
				jQuery('#ec_image_quick_view_'  + modelnum + "_" + 5 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 1 + "_" + i ))
				jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 1 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 2 + "_" + i ))
				jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 2 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 3 + "_" + i ))
				jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 3 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 4 + "_" + i ))
				jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 4 + "_" + i ).hide();
			
			if(this.document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 5 + "_" + i ))
				jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 5 + "_" + i ).hide();
			
			i++;
				
		}
		
		jQuery('#ec_image_quick_view_'  + modelnum + "_" + 1 + "_" + imgnum ).show();
			
		if( document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 1 + "_" + imgnum ) )
			jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 1 + "_" + imgnum ).show();
		
		if( document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 2 + "_" + imgnum ) )
			jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 2 + "_" + imgnum ).show();
		
		if( document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 3 + "_" + imgnum ) )
			jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 3 + "_" + imgnum ).show();
		
		if( document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 4 + "_" + imgnum ) )
			jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 4 + "_" + imgnum ).show();
		
		if( document.getElementById( 'ec_thumb_quick_view_'  + modelnum + "_" + 5 + "_" + imgnum ) )
			jQuery('#ec_thumb_quick_view_'  + modelnum + "_" + 5 + "_" + imgnum ).show();
		
	}
	
}

function ec_product_image_click( model, level, num ){
	return true;
}

function ec_image_click( model, level, num ){
	return true; // just go to the link
}

function ec_product_details_swap_image( modelnum, level, imgnum ){
	
	var i=1;
	while(	document.getElementById( 'ec_image_quick_view_' + modelnum + '_' + i + '_' + level ) ){
		document.getElementById( 'ec_image_quick_view_' + modelnum + '_' + i + '_' + level ).className = 'ec_product_image_inactive';
		i++;
	}
	
	document.getElementById( 'ec_image_quick_view_' + modelnum + '_' + imgnum + '_' + level ).className = 'ec_product_image';
}

var content_width = 1000;

jQuery( document ).ready( function( ){
	content_width = jQuery( "#ec_product_page" ).width( );
	resize_product_layout( );
	if( jQuery( '.ec_product_details_page' ).width( ) < 550 ){
		jQuery( '.ec_product_details_right_side' ).css( 'width', '100%' );
		jQuery( '.ec_product_details_right_side' ).css( 'float', 'left' );
		jQuery( '.ec_product_details_right_side' ).css( 'margin-left', '0px' );
		jQuery( '.ec_product_details_left_side' ).css( 'width', '100%' );
	}
});

jQuery( window ).resize( function( ){
	if( content_width != jQuery( "#ec_product_page" ).width( ) ){
		content_width = jQuery( "#ec_product_page" ).width( );
		resize_product_layout( );
	}
});

function resize_product_layout( ){
	if( document.getElementById( 'ec_product_details_mag_viewer' ) ){
		var position_top = jQuery( '.ec_product_details_left_side' ).offset().top;
		var margin_bottom = parseInt( jQuery( '.ec_product_details_top_bar' ).css( "margin-bottom" ) );
		jQuery( '#ec_product_details_mag_viewer' ).css( "top", position_top + margin_bottom + 2 );	
	}
	
	var product_width = jQuery( "#ec_product_item1" ).width( );
	var num_products_per_row = Math.floor( content_width / product_width );
	var remaining_space = content_width - ( num_products_per_row * product_width );
	var margin_between_product = remaining_space / ( ( ( num_products_per_row - 1 ) * 2 ) );
	
	if( Number(margin_between_product) < 1 )
		margin_between_product = 0;
	
	
	var i = 0;
	while( document.getElementById( "ec_product_item" + (i+1) ) ){
		if( i%num_products_per_row == 0 ){ //This is left product
			document.getElementById( "ec_product_item" + (i+1) ).setAttribute("class", "ec_product left"); 
		}else if( i%num_products_per_row == num_products_per_row-1 ){ // This is the right product
			document.getElementById( "ec_product_item" + (i+1) ).setAttribute("class", "ec_product right");
		}else{ // This is a middle product
			document.getElementById( "ec_product_item" + (i+1) ).setAttribute("class", "ec_product middle");
		}
		i++;
	}
	
	// Change class for left products so margins are correct
	jQuery( ".ec_product.left" ).css( "margin-left", "0px" );
	jQuery( ".ec_product.left" ).css( "margin-right", margin_between_product + "px" );
	
	// Change class for middle products so margins are correct
	jQuery( ".ec_product.middle" ).css( "margin-left", margin_between_product + "px" );
	jQuery( ".ec_product.middle" ).css( "margin-right", margin_between_product + "px" );
	
	// Change class for right products so margins are correct
	jQuery( ".ec_product.right" ).css( "margin-left", "0px" );
	jQuery( ".ec_product.right" ).css( "margin-right", "0px" );
	
}// Base Theme - Product Filter Bar Javascript Document// JavaScript Document// EC Product Page JavaScript Document
function change_product_sort(menu_id, menu_name, submenu_id, submenu_name, subsubmenu_id, subsubmenu_name, manufacturer_id, pricepoint_id, currentpage_selected, perpage, URL, divider){
	
	var url_string = URL + divider + "filternum=" + document.getElementById('sortfield').value;
	
	if( subsubmenu_id != 0 ){
		url_string = url_string + "&subsubmenuid=" + subsubmenu_id;
		
		if( subsubmenu_name != 0 )
			url_string = url_string + "&subsubmenu=" + subsubmenu_name;
	
	}else if( submenu_id != 0 ){
		url_string = url_string + "&submenuid=" + submenu_id;
		
		if( submenu_name != 0 )
			url_string = url_string + "&submenu=" + submenu_name;
			
	}else if( menu_id != 0 ){
		url_string = url_string + "&menuid=" + menu_id;
		
		if( menu_name != 0 )
			url_string = url_string + "&menu=" + menu_name;
		
	}
	
	if( manufacturer_id > 0 )
		url_string = url_string + "&manufacturer=" + manufacturer_id;
		
	if( pricepoint_id > 0 )
		url_string = url_string + "&pricepoint=" + pricepoint_id;
	
	if( currentpage_selected )
		url_string = url_string + "&pagenum=" + currentpage_selected;
	
	if( perpage )
		url_string = url_string + "&perpage=" + perpage; 
	
	window.location = url_string;
}jQuery(document).ready(
	function() {
		// In case a theme over-rides images, we need to make sure all inactive images get hidden on load
		jQuery( ".ec_product_image_inactive" ).hide( );
		
		// Initialize the available quick view boxes
		jQuery(".ec_product_quick_view_box_holder").each( function( ){
			var temp_split = jQuery( this ).attr( "id" ).split( "ec_product_quick_view_box_" );
			ec_initialize_options_product( temp_split[1] );
		});
		
		if( document.getElementById( 'ec_product_details_magbox' ) ){
			
			if( document.getElementById( 'ec_product_details_description_tab' ) ){
				if( document.getElementById( 'ec_product_details_specifications' ) )
					jQuery( '#ec_product_details_specifications' ).hide( );
					
				if( document.getElementById( 'ec_product_details_customer_reviews' ) )
					jQuery( '#ec_product_details_customer_reviews' ).hide( );
			}
				
			
			jQuery('.ec_product_details_images img').hover( 
				function (){
					if( jQuery(window).width() > 960 ){
						if( !jQuery.browser.msie ){
							//jQuery('#ec_product_details_magbox').fadeIn(100); 
						}
						var hasTouch = ("ontouchstart" in window);
						if( !hasTouch ){
							jQuery('#ec_product_details_mag_viewer').fadeIn(100); 
							jQuery("#ec_product_details_mag_viewer").html('<img src="' + this.src + '" class="ec_product_details_mag_viewer_image" style="width:800px; height:800px;" width="800" height="800">');
						}
					}
				}, 
				
				function (){ 
					if( !jQuery.browser.msie ){
						//jQuery('#ec_product_details_magbox').fadeOut(100); 
					}
					jQuery('#ec_product_details_mag_viewer').fadeOut(100); 
				} 
			);
			
			var position_top = jQuery( '.ec_product_details_left_side' ).offset().top;
			var margin_bottom = parseInt( jQuery( '.ec_product_details_top_bar' ).css( "margin-bottom" ) );
			jQuery( '#ec_product_details_mag_viewer' ).css( "top", position_top + margin_bottom + 2 );
			
			jQuery(document).bind('mousemove', function( e ){
					
				jQuery('#ec_product_details_magbox').css({ 'left': e.pageX - jQuery(e.target).offset().left - 20, 'top': e.pageY - jQuery(e.target).offset().top + 225});
				
				// top left position, image should be 0,0
				// top right position, image should be at -550, 0
				// bottom left position, image should be at 0, -550
				// bottom right position, image should be at -550, -550
				var mag_box_size = 350;
				
				var small_img_width = 350;
				var small_img_height = 350;
				
				var large_img_width = 800;
				var large_img_height = 800;
				
				var move_width = large_img_width - mag_box_size;
				var move_height = large_img_height - mag_box_size;
				
				var left_pos = e.pageX - jQuery( e.target ).offset( ).left;
				var top_pos = e.pageY - jQuery( e.target).offset( ).top;
				
				// %accross * amount to move * negative move distance
				var left = ( left_pos / small_img_width ) * move_width * -1; 
				var top = ( top_pos / small_img_height ) * move_height * -1; 
				
				jQuery('#ec_product_details_mag_viewer img').css({ 'left': left, 'top': top});
			});
		}
	}
);

// tab listener
function update_content_areas( item_num ){
	
	if( item_num == 1 ){
		jQuery( '#ec_product_details_description' ).show( );
		document.getElementById( 'ec_product_details_description_tab' ).className = "ec_product_details_tab_selected";
	}else{
		jQuery( '#ec_product_details_description' ).hide( );
		document.getElementById( 'ec_product_details_description_tab' ).className = "ec_product_details_tab";
	}
	
	if( document.getElementById( 'ec_product_details_specifications' ) ){
		if( item_num == 2 ){
			jQuery( '#ec_product_details_specifications' ).show( );
			document.getElementById( 'ec_product_details_specifications_tab' ).className = "ec_product_details_tab_selected";
		}else{
			jQuery( '#ec_product_details_specifications' ).hide( );
			document.getElementById( 'ec_product_details_specifications_tab' ).className = "ec_product_details_tab";
		}
	}
		
	if( document.getElementById( 'ec_product_details_customer_reviews' ) ){
		if( item_num == 3 ){
			jQuery( '#ec_product_details_customer_reviews' ).show( );
			document.getElementById( 'ec_product_details_customer_reviews_tab' ).className = "ec_product_details_tab_selected";
		}else{
			jQuery( '#ec_product_details_customer_reviews' ).hide( );
			document.getElementById( 'ec_product_details_customer_reviews_tab' ).className = "ec_product_details_tab";
		}
	}
	
}


// Set initial variables
var model_number = "";
var product_id = "";
var current_rating = -1;
var selected_option_quantity = 0;

/////////////// OPTION FUNCTIONS ///////////////////////////////

// Once the page has loaded we can initialize the commonly used variables.
function ec_update_product_details_variables( ){
	
	model_number = document.getElementById( 'model_number' ).value;
	product_id = document.getElementById('product_id').value;

}

// Initialize the product details page for option sets
function ec_initialize_options( ){
	ec_update_product_details_variables( );
	
	if( ec_uses_stock_quantities( model_number ) ){
		
		if( ec_is_swatch_set( 1 ) )									ec_set_swatches_by_stock_quantities( 1 );
		else if( ec_is_combo_box( 1 ) )								ec_set_combo_by_stock_quantities( 1 );
		
		if( ec_is_swatch_set( 1 ) && ec_is_swatch_set( 2 ))			ec_set_swatches_by_stock_quantities( 2 );
		else if( ec_is_swatch_set( 1 ) && ec_is_combo_box( 2 ))		ec_set_combo_by_stock_quantities( 2 );
		else if( ec_is_swatch_set( 2 ) )							ec_clear_swatch_set( 2 );
		else if( ec_is_combo_box( 2 ) )								ec_clear_combo_box( 2 );
		
		if( ec_is_swatch_set( 3 ) )									ec_clear_swatch_set( 3 );
		else if( ec_is_combo_box( 3 ) )								ec_clear_combo_box( 3 );
		
		if( ec_is_swatch_set( 4 ) )									ec_clear_swatch_set( 4 );
		else if( ec_is_combo_box( 4 ) )								ec_clear_combo_box( 4 );
		
		if( ec_is_swatch_set( 5 ) )									ec_clear_swatch_set( 5 );
		else if( ec_is_combo_box( 5 ) )								ec_clear_combo_box( 5 );
		
	}
}

function ec_initialize_options_product( modnum ){
	
	model_number = modnum;
	if( ec_uses_stock_quantities( modnum ) ){
		
		if( ec_is_swatch_set( 1 ) )									ec_set_swatches_by_stock_quantities( 1 );
		else if( ec_is_combo_box( 1 ) )								ec_set_combo_by_stock_quantities( 1 );
		
		if( ec_is_swatch_set( 1 ) && ec_is_swatch_set( 2 ))			ec_set_swatches_by_stock_quantities( 2 );
		else if( ec_is_swatch_set( 1 ) && ec_is_combo_box( 2 ))		ec_set_combo_by_stock_quantities( 2 );
		else if( ec_is_swatch_set( 2 ) )							ec_clear_swatch_set( 2 );
		else if( ec_is_combo_box( 2 ) )								ec_clear_combo_box( 2 );
		
		if( ec_is_swatch_set( 3 ) )									ec_clear_swatch_set( 3 );
		else if( ec_is_combo_box( 3 ) )								ec_clear_combo_box( 3 );
		
		if( ec_is_swatch_set( 4 ) )									ec_clear_swatch_set( 4 );
		else if( ec_is_combo_box( 4 ) )								ec_clear_combo_box( 4 );
		
		if( ec_is_swatch_set( 5 ) )									ec_clear_swatch_set( 5 );
		else if( ec_is_combo_box( 5 ) )								ec_clear_combo_box( 5 );
		
	}

}

// When a swatch changes, update the state of the page
function ec_swatch_click( modelnum, level, num ){
	
	model_number = modelnum;
	
	if( document.getElementById( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + num ) )
		element_name = 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + num;
	
	else
		element_name = 'ec_swatch_' + model_number + "_" + level + "_" + num;
	
	if( document.getElementById( element_name ).className != "ec_product_swatch_out_of_stock" ){
		
		// Update the selected optionitem_id
		document.getElementById( 'ec_option' + level + "_" + model_number ).value = document.getElementById( element_name ).getAttribute( "data-optionitemid" );
		// If first level, AND uses option item images, swap out the product image
		if( ec_uses_optionitem_images( ) && level == 1 ){
			ec_update_product_details_images( num, level );
		}
		// Update the swatches to reflect the new selection
		ec_update_swatch_images( level, num );
		
		// If we use stock quantities, update the next box to reflect the correct stock count
		if( ec_uses_stock_quantities( ) ){
			ec_update_next_option_level( level, num );
		}//close if uses stock quantities
	}//close check for out of stock
}//close ec_product_details_swatch_change

// Run when the combo box changes
function ec_product_details_combo_change( level, modelnum ){
	model_number = modelnum;
	
	// Only update stock stuff if this product uses that option.
	if( ec_uses_stock_quantities( model_number ) ){
		
		// If the user selected a value (not index 0!)
		if( document.getElementById( 'ec_option' + level + "_" + model_number ).selectedIndex > 0 ){
			
			ec_update_next_option_level( level, document.getElementById( 'ec_option' + level + "_" + model_number ).selectedIndex );	
		
		// Otherwise reset to the previous level or reset all if level 1
		}else{
			if( level == 1 ){
				if( ec_uses_optionitem_images( ) ){
					ec_update_product_details_images( level, 0 );
				}
				ec_update_next_option_level( level, document.getElementById( 'ec_option' + level + "_" + model_number ).selectedIndex - 1 );	
			}else{
				ec_update_next_option_level( level-1, get_selected_option_index( level - 1) );
			}//close if/else for level 1
		}//close if/else for 0 index check
	}//close check if uses stock quantities

	if( ec_uses_optionitem_images( ) && level == 1 && document.getElementById( 'ec_option' + level + "_" + model_number ).selectedIndex > 0 ){
		ec_update_product_details_images( document.getElementById( 'ec_option' + level + "_" + model_number ).selectedIndex - 1, level );
	}
}// close ec_option_combo_change

// Swap the product image
function ec_thumb_click( modelnum, image_index, image_number ){
	
	var model_number = modelnum;
	var i=1;
	
	while( document.getElementById( 'ec_image_' + model_number + "_" + i + "_" + image_index ) ){
		jQuery('#ec_image_' + model_number + "_" + i + "_" + image_index ).hide();
		jQuery('#ec_image_quick_view_' + model_number + "_" + i + "_" + image_index ).hide();
		i++;
	}
	
	jQuery('#ec_image_' + model_number + "_" + image_number + "_" + image_index ).show();
	jQuery('#ec_image_quick_view_' + model_number + "_" + image_number + "_" + image_index ).show();
	
}

// Update the swatch image classes
function ec_update_swatch_images( level, num ){
	
	// Only change the swatch if someone clicked a swatch that is in stock
	if( document.getElementById( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + num ) )
		element_name = 'ec_swatch_quick_view_' + model_number + "_" + level + "_";
	else
		element_name = 'ec_swatch_' + model_number + "_" + level + "_";
	
	// Only update a swatch image if it isn't out of stock!
	if(this.document.getElementById( element_name + num ).className != "ec_product_swatch_out_of_stock" ){
		
		var i=0;
		element_name_temp = element_name + i;
		while( document.getElementById( element_name_temp ) ){
			
			//Don't touch out of stock swatches
			if( document.getElementById( 'ec_swatch_' + model_number + "_" + level + "_" + i ) && 
				document.getElementById( 'ec_swatch_' + model_number + "_" + level + "_" + i ).className != "ec_product_swatch_out_of_stock" ){
				
				ec_set_element_class_name( 'ec_swatch_' + model_number + "_" + level + "_" + i, "ec_product_swatch" );
			}
			
			if( document.getElementById( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + i ) && 
				document.getElementById( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + i ).className != "ec_product_swatch_out_of_stock" ){ 
				
				ec_set_element_class_name( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + i, "ec_product_swatch" );
				
			}
			i++;
			element_name_temp = element_name + i;	
		}
		
		ec_set_element_class_name( 'ec_swatch_' + model_number + "_" + level + "_" + num, "ec_product_swatch_selected" );
		ec_set_element_class_name( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + num, "ec_product_swatch_selected" );
		
	}
}

// Update the next option level
function ec_update_next_option_level( level, num ){
	
	if( ec_uses_stock_quantities( model_number ) ){
		
		// Check for a resetting combo box, manage the quantity values different for this.
		if( ec_is_combo_box( level ) && num == 0 ){
			// Reset this combo box, lets revert the quantities
			selected_option_quantity = get_stock_amount( level-1, get_selected_option_index( level-1 ) );
			
			if( document.getElementById( 'in_stock_amount_text_' + model_number ) )
				document.getElementById( 'in_stock_amount_text_' + model_number ).innerHTML = selected_option_quantity;
			else if( document.getElementById( 'in_stock_amount_text' ) )
				document.getElementById( 'in_stock_amount_text' ).innerHTML = selected_option_quantity;
			
			if( document.getElementById( 'quantity_' + model_number ) )
				document.getElementById( 'quantity_' + model_number ).value = selected_option_quantity;
		}else{
			// We are moving forward, update quantities and options
			selected_option_quantity = get_stock_amount( level, num );
			
			if( document.getElementById( 'in_stock_amount_text_' + model_number ) )
				document.getElementById( 'in_stock_amount_text_' + model_number ).innerHTML = selected_option_quantity;
			else if( document.getElementById( 'in_stock_amount_text' ) )
				document.getElementById( 'in_stock_amount_text' ).innerHTML = selected_option_quantity;

			if( document.getElementById( 'quantity_' + model_number ) )
				document.getElementById( 'quantity_' + model_number ).value = selected_option_quantity;
		}
	
		if( Number(level) < 5 ){
			level = Number(level)+1;
			if( ec_is_swatch_set( level ) )										ec_set_swatches_by_stock_quantities( level );
			else if( ec_is_combo_box( level ) )									ec_set_combo_by_stock_quantities( level );
		}
		
		while( level < 5 ){
			
			level++;
			
			if( ec_is_swatch_set( level ) )										ec_clear_swatch_set( level );
			else if( ec_is_combo_box( level ) )									ec_clear_combo_box( level );
		}
	}
}

// Update swatches in the NEXT level based on quantities
function ec_set_swatches_by_stock_quantities( level ){
	//If this level has swatches, update the swatches to match stock quantities
	if( document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_0' ) ){
		
		var i=0;
		while( document.getElementById('ec_swatch_' + model_number + '_' + level + '_' + i ) ){
			if( level != 1 )
				document.getElementById('ec_option' + level + "_" + model_number).value = 0;
			
			if( level == 1 && i == document.getElementById( 'initial_swatch_selected_' + model_number ).value ){	
				if( document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_' + i  ) )
					document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_' + i ).className = "ec_product_swatch_selected";
				
				selected_option_quantity = get_stock_amount(level, i);
				
				if( document.getElementById('in_stock_amount_text') )
					document.getElementById('in_stock_amount_text').innerHTML = selected_option_quantity;
			}else if( ec_is_in_stock( level, i ) ){
				if( document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_' + i ) )
					document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_' + i ).className = "ec_product_swatch";
				
			}else{
				if( document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_' + i ) )
					document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_' + i ).className = "ec_product_swatch_out_of_stock";
				
			}
			
			i++;
		}
		
	}else if( document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_0' ) ){
		
		var i=0;
		while( document.getElementById('ec_swatch_quick_view_' + model_number + '_' + level + '_' + i ) ){
			
			if( level == 1 && i == document.getElementById( 'initial_swatch_selected_' + model_number ).value ){	
				if( document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_' + i ) )
					document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_' + i ).className = "ec_product_swatch_selected";
				
				selected_option_quantity = get_stock_amount(level, i);
				
				if( document.getElementById('in_stock_amount_text') )
					document.getElementById('in_stock_amount_text').innerHTML = selected_option_quantity;
			}else if( ec_is_in_stock( level, i ) ){
				if( document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_' + i ) )
					document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_' + i ).className = "ec_product_swatch";
			}else{
				if( document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_' + i ) )
					document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_' + i ).className = "ec_product_swatch_out_of_stock";
			}
			
			i++;
		}
		
	}
	
}

// Update combo in the NEXT level based on quantities
function ec_set_combo_by_stock_quantities( level ){
	//If this level has swatches, update the swatches to match stock quantities
	if(level > 1 && get_selected_option_index(level-1) == -1){
		document.getElementById('ec_option' + level + "_" + model_number).disabled = "disabled";
		document.getElementById('ec_option' + level + "_" + model_number).selectedIndex = 0;
	}else{
		document.getElementById('ec_option' + level + "_" + model_number).disabled = "";
		document.getElementById('ec_option' + level + "_" + model_number).selectedIndex = 0;
		//Hide or show items
		for(var i=1; i<document.getElementById('ec_option'+level+"_"+model_number).options.length; i++){
			if(get_stock_amount(level, i) > 0){
				jQuery("#ec_option"+level+"_"+model_number+" option[value=" + document.getElementById('ec_option'+level+"_"+model_number).options[i].value + "]").show();
			}else{
				jQuery("#ec_option"+level+"_"+model_number+" option[value=" + document.getElementById('ec_option'+level+"_"+model_number).options[i].value + "]").hide();
			}
		}
	}
}

// Clear a swatch set
function ec_clear_swatch_set( set_num ){
	
	if(document.getElementById( 'ec_swatch_' + model_number + '_' + set_num + '_0' ) ){
		var i=0;
		while( document.getElementById('ec_swatch_' + model_number + '_' + set_num + '_' + i ) ){
			document.getElementById( 'ec_swatch_' + model_number + '_' + set_num + '_' + i ).className = "ec_product_swatch_out_of_stock";
			document.getElementById( 'ec_swatch_quick_view' + model_number + '_' + set_num + '_' + i ).className = "ec_product_swatch_out_of_stock";
			i++;
		}
		document.getElementById( 'ec_option' + set_num + "_" + model_number ).value = 0;
	}	
}

// Get an option's specific stock quantity
function get_stock_amount( level, num ){
	
	if( num == -1 )
	num = 0;
	// Get the quantity string off of the element
	var quantity_string = "";
	if( ec_is_swatch_set( level ) && document.getElementById( 'ec_swatch_' + model_number + "_" + level + "_" + num ) )		
										quantity_string = document.getElementById( 'ec_swatch_' + model_number + "_" + level + "_" + num ).getAttribute("data-quantitystring");
	
	else if( ec_is_swatch_set( level ) && document.getElementById( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + num ) )		
										quantity_string = document.getElementById( 'ec_swatch_quick_view_' + model_number + "_" + level + "_" + num ).getAttribute("data-quantitystring");	
	
	else if( ec_is_combo_box( level ) && document.getElementById( 'ec_option' + level + "_" + model_number ) )	
										quantity_string = document.getElementById( 'ec_option' + level + "_" + model_number ).options[num].getAttribute('data-quantitystring');
	
	else if( ec_is_combo_box( level ) && document.getElementById( 'ec_option' + level + "_quick_view_" + model_number ) )	
										quantity_string = document.getElementById( 'ec_option' + level + "_quick_view_" + model_number ).options[num].getAttribute('data-quantitystring');
	
	else								return -1;
	
	// If level 1, that is the value, otherwise we need to split and find the quantity value.
	if(level == 1){
		return Number(quantity_string);
	}else{
		// Get the selected values so far
		var quantity_split_string = quantity_string.split(",");
		var option1_index = Number(get_selected_option_index(1));
		var option2_index = Number(get_selected_option_index(2));
		var option3_index = Number(get_selected_option_index(3));
		var option4_index = Number(get_selected_option_index(4));
		var option5_index = Number(get_selected_option_index(5));
		var quantity_id = 0;
		
		// Use the selected index values to decide the correct index of our quantity string split
		if(option1_index != -1 && level == 2)
			quantity_id = option1_index;
		else if(option2_index != -1 && level == 3)
			quantity_id = ( option1_index * get_num_options(2) ) + option2_index;
		else if(option3_index != -1 && level == 4)
			quantity_id = ( option1_index * get_num_options(2) * get_num_options(3) ) + ( option2_index * get_num_options(3) ) + option3_index;
		else if(option4_index != -1 && level == 5)
			quantity_id = ( option1_index * get_num_options(2) * get_num_options(3) * get_num_options(4) ) + ( option2_index * get_num_options(3) * get_num_options(4) ) + ( option3_index * get_num_options(4) ) + option4_index;
		
		// Return the correct quantity value.
		return Number(quantity_split_string[quantity_id]);
	}
}

// Get the number of options at this level for other calculations
function get_num_options( level ){
	
	if( ec_is_swatch_set( level ) ){
	var i = 0;
		while( document.getElementById( 'ec_swatch_' + model_number + "_" + level + "_" + i  )){
			i++;
		}
		return i;
		
	}else if( ec_is_combo_box( level ) ){
		return Number( document.getElementById('ec_option' + level + "_" + model_number).options.length ) - 1;
	}else{
		return 0;
	}
}

// Get the selected optionitem index for an option level
function get_selected_option_index( level ){
	
	if(document.getElementById('ec_option' + level + "_" + model_number)){
	
		if( ec_is_swatch_set( level ) ){
			var i=0;
			while( document.getElementById( 'ec_swatch_' + model_number + "_" + level + "_" + i ) ){
				if( document.getElementById( 'ec_swatch_' + model_number + "_" + level + "_" + i ).className == "ec_product_swatch_selected" ){
					return i;
				}
				i++;
			}
			return -1;
		}else if( ec_is_combo_box( level ) ){
			return ( Number( document.getElementById( 'ec_option' + level + "_" + model_number ).selectedIndex ) - 1 );
		}else{
			return -1;
		}
	}else{
		return -1;
	}
}

/////////////     END OPTION FUNCTIONS  /////////////////////////

///////////// CUSTOMER REVIEW FUNCTIONS /////////////////////////

// Open Customer Review Panel
function product_details_customer_review_open( ){
	jQuery( '#customer_review_popup_background' ).fadeIn( 500 );
	jQuery( '#customer_review_popup_box' ).fadeIn( 500 );
}//close product_details_customer_review_open

// Close Customer Review Panel
function product_details_customer_review_close( ){
	jQuery( '#customer_review_popup_background' ).fadeOut( 500 );
	jQuery( '#customer_review_popup_box' ).fadeOut( 500 );
}//close product_details_customer_review_close

// On star hover
function ec_customer_review_star_hover( rating ){
	ec_customer_review_star_set_to_value(rating);
}

// On star rollout
function ec_customer_review_star_rollout( rating ){
	ec_customer_review_star_set_to_value(current_rating);
}

// On star click
function ec_customer_review_star_click( rating ){
	current_rating = rating;
	document.getElementById('ec_customer_review_rating').value = rating+1;
	ec_customer_review_star_set_to_value(rating);
}

// Set the value of the review based on the selected value
function ec_customer_review_star_set_to_value( rating ){
	
	rating++;
	for(var i=0; i<rating; i++){
		ec_set_element_class_name( 'ec_customer_review_star_' + i, "ec_customer_review_star_on" );
	}
	
	for(var j=rating; j<5; j++){
		ec_set_element_class_name( 'ec_customer_review_star_' + j, "ec_customer_review_star_off" );
	}
	
}

// Disable the customer review button by hiding and showing a non-button
function disable_review_button(){
	document.getElementById('ec_open_review_button').style.display = "none";
	document.getElementById('ec_open_review_button_submitted').style.display = "block";
}

// Reset the customer review form
function product_details_customer_review_reset_form(){
	//reset rating and stars
	document.getElementById('ec_customer_review_star_0').className = "ec_customer_review_star_off";
	document.getElementById('ec_customer_review_star_1').className = "ec_customer_review_star_off";
	document.getElementById('ec_customer_review_star_2').className = "ec_customer_review_star_off";
	document.getElementById('ec_customer_review_star_3').className = "ec_customer_review_star_off";
	document.getElementById('ec_customer_review_star_4').className = "ec_customer_review_star_off";
	document.getElementById('ec_customer_review_rating').value = 0;
	
	//reset title and description
	document.getElementById('ec_customer_review_title').value = "";
	document.getElementById('ec_customer_review_description').value = "";
}

///////////// END CUSTOMER REVIEW FUNCTIONS //////////////////////

///////////// HELPER FUNCTIONS //////////////////////////////////
function ec_update_product_details_images( image_index, image_number ){
	
	var i=0;
	var j=1;
	
	while( document.getElementById( 'ec_image_' + model_number + "_" + 1 + "_" + i ) ){
		
		j=1;
		
		while( document.getElementById( 'ec_image_' + model_number + "_" + j + "_" + i ) ){
			jQuery('#ec_image_' + model_number + "_" + j + "_" + i ).hide();
			jQuery('#ec_thumb_' + model_number + "_" + j + "_" + i ).hide();
			
			j++;
		}
		
		j=1;
		
		while( document.getElementById( 'ec_image_quick_view_' + model_number + "_" + j + "_" + i ) ){
			jQuery('#ec_image_quick_view_' + model_number + "_" + j + "_" + i ).hide();
			jQuery('#ec_thumb_quick_view_' + model_number + "_" + j + "_" + i ).hide();
			
			j++;
		}
		
		i++;
			
	}
	
	jQuery( '#ec_image_' + model_number + "_" + 1 + "_" + image_index ).show();
	jQuery( '#ec_image_quick_view_' + model_number + "_" + 1 + "_" + image_index ).show();
	
	if( document.getElementById( 'ec_thumb_' + model_number + '_' + 1 + '_' + image_index ) )
		jQuery('#ec_thumb_' + model_number + "_" + 1 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_' + model_number + '_' + 2 + '_' + image_index ) )
		jQuery('#ec_thumb_' + model_number + "_" + 2 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_' + model_number + '_' + 3 + '_' + image_index ) )
		jQuery('#ec_thumb_' + model_number + "_" + 3 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_' + model_number + '_' + 4 + '_' + image_index ) )
		jQuery('#ec_thumb_' + model_number + "_" + 4 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_' + model_number + '_' + 5 + '_' + image_index ) )
		jQuery('#ec_thumb_' + model_number + "_" + 5 + "_" + image_index ).show();
	
	if( document.getElementById( 'ec_thumb_quick_view_' + model_number + '_' + 1 + '_' + image_index ) )
		jQuery('#ec_thumb_quick_view_' + model_number + "_" + 1 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_quick_view_' + model_number + '_' + 2 + '_' + image_index ) )
		jQuery('#ec_thumb_quick_view_' + model_number + "_" + 2 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_quick_view_' + model_number + '_' + 3 + '_' + image_index ) )
		jQuery('#ec_thumb_quick_view_' + model_number + "_" + 3 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_quick_view_' + model_number + '_' + 4 + '_' + image_index ) )
		jQuery('#ec_thumb_quick_view_' + model_number + "_" + 4 + "_" + image_index ).show();
	if( document.getElementById( 'ec_thumb_quick_view_' + model_number + '_' + 5 + '_' + image_index ) )
		jQuery('#ec_thumb_quick_view_' + model_number + "_" + 5 + "_" + image_index ).show();
	
}

function ec_set_element_class_name( element_name, class_name ){
	if( document.getElementById( element_name ) )
		document.getElementById( element_name ).className = class_name;	
}

///////////////// QUICK IS OR USES CHECKS ///////////////////
function ec_uses_stock_quantities( ){
	if( document.getElementById( 'use_optionitem_quantity_tracking_' + model_number ) && 
		document.getElementById( 'use_optionitem_quantity_tracking_' + model_number ).value == "1" )		return true;
	else																									return false;
}

function ec_uses_optionitem_images( ){
	if( document.getElementById( 'use_optionitem_images_' + model_number ).value == 1 )						return true;
	else																									return false;
}

function ec_is_swatch_set( level ){
	
	if( document.getElementById( 'ec_swatch_' + model_number + '_' + level + '_0' ) )		
																				return true;
	else if( document.getElementById( 'ec_swatch_quick_view_' + model_number + '_' + level + '_0' ) )
																				return true;
	else																		return false;
}

function ec_is_combo_box( level ){
	
	if( !ec_is_swatch_set( level ) && 
		document.getElementById( 'ec_option' + level + "_" + model_number ) && 
		document.getElementById( 'ec_option' + level + "_" + model_number ).options && 
		document.getElementById( 'ec_option' + level + "_" + model_number ).options.length > 1 )	
																				return true;
	else if( !ec_is_swatch_set( level ) && 
		document.getElementById( 'ec_option' + level + "_quick_view_" + model_number ) && 
		document.getElementById( 'ec_option' + level + "_quick_view_" + model_number ).options && 
		document.getElementById( 'ec_option' + level + "_quick_view_" + model_number ).options.length > 1 )
																				return true;
	else																		return false;
	
}

function ec_is_in_stock( level, num ){
	if( get_stock_amount( level, num ) )										return true;
	else																		return false;
}

function ec_clear_combo_box( set_num ){
	if(document.getElementById( 'ec_option' + set_num + "_" + model_number )){
		document.getElementById( 'ec_option' + set_num + "_" + model_number ).selectedIndex = 0;
		document.getElementById( 'ec_option' + set_num + "_" + model_number ).disabled = "disabled";
	}
}

////////// FORM SUBMISSION FUNCTIONS /////////////////////

// Submit the customer review form
function submit_customer_review(){
	
	var errors=0;
	if(document.getElementById('ec_customer_review_rating').value == 0){
		errors++;
		document.getElementById('ec_customer_review_rating_error').style.display = 'block';
	}else{
		document.getElementById('ec_customer_review_rating_error').style.display = 'none';
	}
	
	if(document.getElementById('ec_customer_review_title').value.length == 0){
		errors++;
		document.getElementById('ec_product_details_customer_reviews_popup_label_title').className = 'ec_product_details_customer_reviews_popup_label_row_error';
	}else{
		document.getElementById('ec_product_details_customer_reviews_popup_label_title').className = 'ec_product_details_customer_reviews_popup_label_row';
	}
	
	if(document.getElementById('ec_customer_review_description').value.length == 0){
		errors++;
		document.getElementById('ec_product_details_customer_reviews_popup_label_description').className = 'ec_product_details_customer_reviews_popup_label_row_error';
	}else{
		document.getElementById('ec_product_details_customer_reviews_popup_label_description').className = 'ec_product_details_customer_reviews_popup_label_row';
	}
	
	if(errors == 0){
		jQuery('#ec_customer_review_loader').fadeIn(100);
		
		var data = {
			action: 'ec_ajax_insert_customer_review',
			product_id: document.getElementById('product_id').value,
			rating: document.getElementById('ec_customer_review_rating').value,
			title: document.getElementById('ec_customer_review_title').value,
			description: document.getElementById('ec_customer_review_description').value
		};
		
		jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ jQuery('#ec_customer_review_loader').fadeOut(100); product_details_customer_review_close(); product_details_customer_review_reset_form(); disable_review_button(); } } );
	}
	
	return false;	
}

// Add to cart function
function ec_product_details_add_to_cart( modelnum ){
	
	model_number = modelnum;
	
	var errors = 0;
	
	if( document.getElementById( 'ec_option1_' + model_number ) ){
		
		if( document.getElementById( 'ec_option1_' + model_number ).value == "0" ){
			
			if( ec_is_combo_box( 1 ) )	document.getElementById( 'ec_option1_' + model_number ).className = "ec_product_details_option_combo_error";
			else						ec_show_swatch_error( 1 );
			errors++;
		}else{
			if( ec_is_combo_box( 1 ) )	document.getElementById( 'ec_option1_' + model_number ).className = "ec_product_details_option_combo";
			else						ec_hide_swatch_error( 1 );
		}
	}
	
	if( document.getElementById( 'ec_option2_' + model_number ) ){
		if( document.getElementById( 'ec_option2_' + model_number ).value == "0"){
			if( ec_is_combo_box( 2 ) )	document.getElementById( 'ec_option2_' + model_number ).className = "ec_product_details_option_combo_error";
			else						ec_show_swatch_error( 2 );
			errors++;
		}else{
			if( ec_is_combo_box( 2 ) )	document.getElementById( 'ec_option2_' + model_number ).className = "ec_product_details_option_combo";
			else						ec_hide_swatch_error( 2 );
		}
	}
	
	if( document.getElementById( 'ec_option3_' + model_number ) ){
		if( document.getElementById( 'ec_option3_' + model_number ).value == "0"){
			if( ec_is_combo_box( 3 ) )	document.getElementById( 'ec_option3_' + model_number ).className = "ec_product_details_option_combo_error";
			else						ec_show_swatch_error( 3 );
			errors++;
		}else{
			if( ec_is_combo_box( 3 ) )	document.getElementById( 'ec_option3_' + model_number ).className = "ec_product_details_option_combo";
			else						ec_hide_swatch_error( 3 );
		}
	}
	
	if( document.getElementById( 'ec_option4_' + model_number ) ){
		if( document.getElementById( 'ec_option4_' + model_number ).value == "0"){
			if( ec_is_combo_box( 4 ) )	document.getElementById( 'ec_option4_' + model_number ).className = "ec_product_details_option_combo_error";
			else						ec_show_swatch_error( 4 );
			errors++;
		}else{
			if( ec_is_combo_box( 4 ) )	document.getElementById( 'ec_option4_' + model_number ).className = "ec_product_details_option_combo";
			else						ec_hide_swatch_error( 4 );
		}
	}
	
	if( document.getElementById( 'ec_option5_' + model_number ) ){
		if( document.getElementById( 'ec_option5_' + model_number ).value == "0"){
			if( ec_is_combo_box( 5 ) )	document.getElementById( 'ec_option5_' + model_number ).className = "ec_product_details_option_combo_error";
			else						ec_show_swatch_error( 5 );
			errors++;
		}else{
			if( ec_is_combo_box( 5 ) )	document.getElementById( 'ec_option5_' + model_number ).className = "ec_product_details_option_combo";
			else						ec_hide_swatch_error( 5 );
		}
	}
	
	if( document.getElementById( 'is_donation_' + model_number ) && document.getElementById( 'is_donation_' + model_number ).value == "1" ){
		
		var donation_amount = document.getElementById( 'ec_product_input_price' ).value;
		var min_amount = document.getElementById( 'ec_product_min_donation_amount' ).value;
		
		if( isNaN( donation_amount ) || Number( donation_amount ) < min_amount ){
			document.getElementById('ec_product_details_donation_row').className = "ec_product_details_donation_error";
			errors++;
		}else{
			document.getElementById('ec_product_details_donation_row').className = "ec_product_details_donation";
		}
		
	}else{
		
		if( ( ec_track_basic_quantity( model_number ) && !ec_check_basic_quantity( model_number ) ) || !ec_has_valid_quantity( model_number, selected_option_quantity ) ){
			document.getElementById( 'ec_product_details_quantity_' + model_number ).className = "ec_product_details_quantity_error";
			errors++;
		}else{
			document.getElementById( 'ec_product_details_quantity_' + model_number ).className = "ec_product_details_quantity";
		}
	}
	
	if( document.getElementById( 'ec_gift_card_message_' + model_number ) && document.getElementById( 'ec_gift_card_message_' + model_number ).value.length == 0 ){
		document.getElementById( 'ec_gift_card_message_' + model_number ).className = "ec_gift_card_message_error";
		errors++;
	}else if( document.getElementById( 'ec_gift_card_message_' + model_number ) ){
		document.getElementById( 'ec_gift_card_message_' + model_number ).className = "ec_gift_card_message";	
	}
	
	if( document.getElementById( 'ec_gift_card_to_name_' + model_number ) && document.getElementById( 'ec_gift_card_to_name_' + model_number ).value.length == 0 ){
		document.getElementById( 'ec_gift_card_to_name_' + model_number ).className = "ec_gift_card_to_name_error";
		errors++;
	}else if( document.getElementById( 'ec_gift_card_to_name_' + model_number ) ){
		document.getElementById( 'ec_gift_card_to_name_' + model_number ).className = "ec_gift_card_to_name";	
	}
	
	if( document.getElementById( 'ec_gift_card_from_name_' + model_number ) && document.getElementById( 'ec_gift_card_from_name_' + model_number ).value.length == 0 ){
		document.getElementById( 'ec_gift_card_from_name_' + model_number ).className = "ec_gift_card_from_name_error";
		errors++;
	}else if( document.getElementById( 'ec_gift_card_from_name_' + model_number ) ){
		document.getElementById( 'ec_gift_card_from_name_' + model_number ).className = "ec_gift_card_from_name";	
	}	
	
	if(errors == 0)
		return true;
	else
		return false;
}

function ec_product_details_add_to_cart_advanced( model_number ){
	var i=0;
	var errors=0;
	while( document.getElementById( 'ec_option' + i + '_' + model_number ) || document.getElementById( 'ec_option' + i + '_' + model_number + '_0' ) ){
		if( document.getElementById( 'ec_option' + i + '_' + model_number ) ){
			if( document.getElementById( 'ec_option' + i + '_' + model_number ).value <= 0 && document.getElementById( 'ec_option' + i + '_' + model_number ).getAttribute( "data-ec-required" ) == '1' ){
				document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "block";
				errors++;
			}else{
				document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "none";
			}
		}else{
			var input_type = jQuery( '#ec_option' + i + '_' + model_number + "_0" ).attr("type").toLowerCase();
			if( input_type == "checkbox" ){
				var j=0;
				var selected = 0;
				while( document.getElementById( 'ec_option' + i + '_' + model_number + '_' + j ) ){
					if( jQuery( '#ec_option' + i + '_' + model_number + "_" + j ).prop("checked") ){
						selected++;
					}
					j++;
				}
				if( selected <= 0 && document.getElementById( 'ec_option' + i + '_' + model_number + '_0' ).getAttribute( "data-ec-required" ) == '1' ){
					document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "block";
					errors++;
				}else{
					document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "none";
				}
			}else if( input_type == "radio" ){
				var j=0;
				var selected = 0;
				while( document.getElementById( 'ec_option' + i + '_' + model_number + '_' + j ) ){
					if( jQuery( '#ec_option' + i + '_' + model_number + "_" + j ).prop("checked") ){
						selected++;
					}
					j++;
				}
				if( selected <= 0 && document.getElementById( 'ec_option' + i + '_' + model_number + '_0' ).getAttribute( "data-ec-required" ) == '1' ){
					document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "block";
					errors++;
				}else{
					document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "none";
				}
			}else if( input_type == "number" ){
				var j=0;
				var total=0;
				while( document.getElementById( 'ec_option' + i + '_' + model_number + '_' + j ) ){
					total = total + Number( jQuery( '#ec_option' + i + '_' + model_number + "_" + j ).val( )  );
					j++;
				}
				if( total <= 0 && document.getElementById( 'ec_option' + i + '_' + model_number + '_0' ).getAttribute( "data-ec-required" ) == '1' ){
					document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "block";
					errors++;
				}else{
					document.getElementById( 'ec_option' + i + '_' + model_number + "_error" ).style.display = "none";
				}
			}
		}
		i++;
	}
	if( errors > 0 )
		return false;
	else
		return true;
}
function ec_track_basic_quantity( model_number ){
	if( document.getElementById( 'show_stock_quantity_' + model_number ) && document.getElementById( 'show_stock_quantity_' + model_number ).value == "1" )
		return true;
	else
		return false;
}

function ec_check_basic_quantity( model_number ){
	var quantity = Number( document.getElementById( 'product_quantity_' + model_number ).value );
	var stock_quantity = Number( document.getElementById( 'quantity_' + model_number ).value );
	
	if( quantity <= stock_quantity )
		return true;
	else
		return false;	
}

function ec_has_valid_quantity( model_number, selected_option_quantity ){
	
	var quantity = Number( document.getElementById( 'product_quantity_' + model_number ).value );
	
	if(  !is_valid_quantity_entry( model_number ) || ( ec_uses_stock_quantities( model_number ) && quantity > selected_option_quantity ) )
		return false;
	else{
		return true;
	}
}

function is_valid_quantity_entry( model_number ){
	if( isNaN( document.getElementById( 'product_quantity_' + model_number ).value ) || Number( document.getElementById('product_quantity_' + model_number).value ) < 1 )
		return false;
	else
		return true;
}

function ec_show_swatch_error( level ){
	
	var error_text = "Please select all options for this product.";
	
	if( document.getElementById( 'ec_quick_view_error_' + model_number ) ){
		document.getElementById( 'ec_quick_view_error_' + model_number ).innerHTML = error_text;
		jQuery( '#ec_quick_view_error_' + model_number ).fadeIn(200);
	}
	
}

function ec_hide_swatch_error( level ){
	
	if( document.getElementById( 'ec_quick_view_error_' + model_number ) ){
		document.getElementById( 'ec_quick_view_error_' + model_number ).innerHTML = "";
		jQuery( '#ec_quick_view_error_' + model_number ).fadeOut(100);
	}else if( document.getElementById( 'ec_quick_view_error' ) ){
		document.getElementById( 'ec_quick_view_error' ).innerHTML = "";
		jQuery( '#ec_quick_view_error').fadeOut(100);
	}
	
}

function ec_product_details_update_quantity_value( ){
	if( document.getElementById( 'use_optionitem_quantity_tracking_' + model_number ) && document.getElementById( 'use_optionitem_quantity_tracking_' + model_number ).value == 1 ){
		selected_option_quantity = selected_option_quantity - document.getElementById('product_quantity_' + model_number).value;
		document.getElementById('in_stock_amount_text_' + model_number ).innerHTML = selected_option_quantity;
	}else{
		document.getElementById( 'quantity_' + model_number ).value = document.getElementById( 'quantity_' + model_number ).value - document.getElementById( 'product_quantity_' + model_number ).value;
		document.getElementById( 'in_stock_amount_text_' + model_number ).innerHTML = document.getElementById( 'quantity_' + model_number ).value;
	}
	document.getElementById('product_quantity_' + model_number).value = 1;
}

function ec_continue_shopping_click(){
	jQuery('#ec_product_details_temp_cart_holder').fadeOut(100);
}

function ec_image_click( model, level, num ){
	return false;
}// Base Theme - Product Filter Bar Javascript Document// Base Theme - Product Filter Bar Javascript Document// Base Theme - Product Filter Bar Javascript Document// Base Theme - EC Cart Page Javascript Document
function ec_cart_validate_checkout_info( ){
	
	var billing_country_code = document.getElementById('ec_cart_billing_country').value;
	var shipping_country_code = document.getElementById('ec_cart_shipping_country').value;
	
	if( document.getElementById('ec_contact_first_name') ){
		var first_name = document.getElementById('ec_contact_first_name').value;
		var last_name = document.getElementById('ec_contact_last_name').value;
	}
	
	var create_account = false;
	if( document.getElementById('ec_contact_email') ){
		var email = document.getElementById('ec_contact_email').value;
		var retype_email = document.getElementById('ec_contact_email_retype').value;
	}
	if( document.getElementById('ec_contact_create_account') && document.getElementById('ec_contact_create_account').checked ){
		create_account = true;
		var password = document.getElementById('ec_contact_password').value;
		var retype_password = document.getElementById('ec_contact_password_retype').value;
	}
	
	var shipping_selector = false;
	if( document.getElementById('ec_cart_use_shipping_for_shipping') && document.getElementById('ec_cart_use_shipping_for_shipping').checked )
		shipping_selector = true;
		 
	var errors = 0;
	
	var input_names = ['first_name', 'last_name', 'address', 'city', 'state', 'zip', 'country'];
	
	if( document.getElementById( 'ec_cart_billing_phone' ) ){
		input_names.push( 'phone' );
	}
	
	for( var i=0; i< input_names.length; i++){
		if( input_names[i] == "state" && document.getElementById( 'ec_cart_billing_' + input_names[i] + '_' + billing_country_code ) && document.getElementById( 'ec_cart_billing_' + input_names[i] + '_' + billing_country_code ).options ){
			var value = document.getElementById( 'ec_cart_billing_' + input_names[i] + '_' + billing_country_code ).options[document.getElementById( 'ec_cart_billing_' + input_names[i] + '_' + billing_country_code ).selectedIndex].value;
		}else{
			var value = document.getElementById( 'ec_cart_billing_' + input_names[i] ).value;
		}
		// validate billing
		if( !ec_validation( "validate_" + input_names[i], value, billing_country_code ) ){
			errors++;
			document.getElementById('ec_cart_billing_' + input_names[i] + '_row').className = "ec_cart_billing_row_error";
			jQuery( '#ec_cart_error_billing_' + input_names[i] ).show( );
		}else{
			document.getElementById('ec_cart_billing_' + input_names[i] + '_row').className = "ec_cart_billing_row";
			jQuery( '#ec_cart_error_billing_' + input_names[i] ).hide( );
		}
	}
	
	if( shipping_selector ){
		for( i=0; i < input_names.length; i++ ){
			if( input_names[i] == "state" && document.getElementById( 'ec_cart_shipping_' + input_names[i] + '_' + shipping_country_code ) && document.getElementById( 'ec_cart_shipping_' + input_names[i] + '_' + shipping_country_code ).options ){
				var value = document.getElementById( 'ec_cart_shipping_' + input_names[i] + '_' + shipping_country_code ).options[document.getElementById( 'ec_cart_shipping_' + input_names[i] + '_' + shipping_country_code ).selectedIndex].value;
			}else{
				var value = document.getElementById( 'ec_cart_shipping_' + input_names[i] ).value;
			}
			
			// validate shipping
			if( !ec_validation( "validate_" + input_names[i], value, shipping_country_code ) ){
				errors++;
				document.getElementById('ec_cart_shipping_' + input_names[i] + '_row').className = "ec_cart_shipping_row_error";
				jQuery( '#ec_cart_error_shipping_' + input_names[i] ).show( );
			}else{
				document.getElementById('ec_cart_shipping_' + input_names[i] + '_row').className = "ec_cart_shipping_row";
				jQuery( '#ec_cart_error_shipping_' + input_names[i] ).hide( );
			}	
		}
	}
	
	if( document.getElementById('ec_contact_first_name') ){
		if( !ec_validation( "validate_first_name", first_name, billing_country_code ) ){
			errors++;
			document.getElementById('ec_contact_first_name_row').className = "ec_cart_contact_information_row_error";
			jQuery( '#ec_cart_error_contact_first_name' ).show( );
		}else{
			document.getElementById('ec_contact_first_name_row').className = "ec_cart_contact_information_row";
			jQuery( '#ec_cart_error_contact_first_name' ).hide( );
		}
		
		if( !ec_validation( "validate_last_name", last_name, billing_country_code ) ){
			errors++;
			document.getElementById('ec_contact_last_name_row').className = "ec_cart_contact_information_row_error";
			jQuery( '#ec_cart_error_contact_last_name' ).show( );
		}else{
			document.getElementById('ec_contact_last_name_row').className = "ec_cart_contact_information_row";
			jQuery( '#ec_cart_error_contact_last_name' ).hide( );
		}
	}
	
	if( document.getElementById('ec_contact_email') ){
		if( !ec_validation( "validate_email", email, billing_country_code ) ){
			errors++;
			document.getElementById('ec_contact_email_row').className = "ec_cart_contact_information_row_error";
			jQuery( '#ec_cart_error_email' ).show( );
		}else{
			document.getElementById('ec_contact_email_row').className = "ec_cart_contact_information_row";
			jQuery( '#ec_cart_error_email' ).hide( );
		}
		
		if( retype_email.length == 0 || email != retype_email ){
			errors++;
			document.getElementById('ec_contact_email_retype_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_email_retype_row').className = "ec_cart_contact_information_row";
		}
		
		if( retype_email.length == 0 ){
			jQuery( '#ec_cart_error_retype_email' ).show( );
		}else if( email != retype_email ){
			jQuery( '#ec_cart_error_retype_email' ).hide( );
			jQuery( '#ec_cart_error_email_match' ).show( );
		}else{
			jQuery( '#ec_cart_error_retype_email' ).hide( );
			jQuery( '#ec_cart_error_email_match' ).hide( );
		}
	}
	
	if( create_account ){
		
		
		
		if( !ec_validation( "validate_password", password, billing_country_code ) ){
			errors++;
			document.getElementById('ec_contact_password_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_password_row').className = "ec_cart_contact_information_row";
		}
		
		if( retype_password.length == 0 || password != retype_password ){
			errors++;
			document.getElementById('ec_contact_password_retype_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_password_retype_row').className = "ec_cart_contact_information_row";
		}
		
		if( retype_password.length == 0 ){
			jQuery( '#ec_cart_error_retype_password' ).show( );
		}else if( password != retype_password ){
			jQuery( '#ec_cart_error_retype_password' ).hide( );
			jQuery( '#ec_cart_error_password_match' ).show( );
		}else{
			jQuery( '#ec_cart_error_retype_password' ).hide( );
			jQuery( '#ec_cart_error_password_match' ).hide( );
		}
		
		if( password.length <= 0 ){
			jQuery( '#ec_cart_error_password' ).show( );
		}else if( password.length < 6 ){
			jQuery( '#ec_cart_error_password_length' ).show( );
			jQuery( '#ec_cart_error_password' ).hide( );
		}else{
			jQuery( '#ec_cart_error_password_length' ).hide( );
			jQuery( '#ec_cart_error_password' ).hide( );
		}
		
	}
	
	
	
	if( errors ){
		jQuery( '#ec_cart_error_text' ).show( );
		jQuery( 'html, body' ).animate( {
			scrollTop: jQuery("#ec_cart_error_scroll").offset( ).top - 150
		}, 750);
		return false;
	}else{
		jQuery( '#ec_cart_error_text' ).hide( );
		return true;
	}
	
}

function ec_cart_validate_checkout_shipping( ){
	var errors = 0;
	
	if ( !jQuery( "input[name='ec_cart_shipping_method']:checked" ).val( ) ){
		errors++;
		jQuery( ".ec_cart_shipping_method_row" ).css("color", "#900");
	}else{
		jQuery( ".ec_cart_shipping_method_row" ).css("color", "#999");
	}
	
	if( errors )
		return false;
	else
		return true;
}

function ec_cart_validate_checkout_submit_order( ){
	
	jQuery( '.ec_cart_final_loader_overlay' ).show( );
	
	var errors = 0;
	
	var payment_type = jQuery('input[name=ec_cart_payment_selection]:checked').val();
	if( !document.getElementById( 'ec_cart_pay_by_manual_payment' ) && !document.getElementById( 'ec_cart_pay_by_third_party' ) && !document.getElementById( 'ec_cart_pay_by_credit_card_holder' ) ){
		return true;
	}else if( payment_type ){
		jQuery('.ec_cart_payment_information_payment_type_row.error').removeClass('error');
		if( payment_type == "credit_card" ){
		
			var card_number = document.getElementById('ec_card_number').value;
			var exp_month = document.getElementById('ec_expiration_month').value;
			var exp_year = document.getElementById('ec_expiration_year').value;
			var sec_code = document.getElementById('ec_security_code').value;
			
			if( card_number.length <= 0 ){
				errors++;
				jQuery('#ec_cart_error_payment_card_number').show( );
			}else{
				jQuery('#ec_cart_error_payment_card_number').hide( );
			}
			
			if( card_number.length > 0 && !ec_validation( "validate_card_number", card_number, "" ) ){
				jQuery('#ec_cart_error_payment_card_number_error').show( );
				errors++;
			}else{
				jQuery('#ec_cart_error_payment_card_number_error').hide( );
			}
			
			
			if( !ec_validation( "validate_expiration_month", exp_month, "" ) || !ec_validation( "validate_expiration_year", exp_year, "" ) )
				errors++;
				
			if( !ec_validation( "validate_expiration_month", exp_month, "" ) ){
				jQuery('#ec_cart_error_payment_card_exp_month').show( );
				
			}else{
				jQuery('#ec_cart_error_payment_card_exp_month').hide( );
				
			}
			
			if( !ec_validation( "validate_expiration_year", exp_year, "" ) ){
				jQuery('#ec_cart_error_payment_card_exp_year').show( );
				
			}else{
				jQuery('#ec_cart_error_payment_card_exp_year').hide( );
				
			}
			
			if( !ec_validation( "validate_security_code", sec_code, "" ) ){
				errors++;
				jQuery('#ec_cart_error_payment_card_code').show( );
			}else{
				jQuery('#ec_cart_error_payment_card_code').hide( );
			}
		}
	}else{
		jQuery('.ec_cart_payment_information_payment_type_row').addClass('error');
		errors++;
	}
	
	if( errors ){
		jQuery('#ec_cart_payment_error_text').show( );
		jQuery( 'html, body' ).animate( {
			scrollTop: jQuery("#ec_cart_payment_error_text").offset( ).top - 150
		}, 750);
		return false;
	}else{
		jQuery('#ec_cart_payment_error_text').hide( );
		if( document.getElementById( 'ec_cart_final_review_holder' ) && jQuery( '#ec_cart_final_review_holder' ).is( ':visible' ) ){
			jQuery( '#ec_submit_order_form' ).submit( );
		}
		return true;
	}
}

function ec_cart_validate_subscription_order( ){
	var errors = 0;
	
	var billing_country_code = document.getElementById('ec_cart_billing_country').value;
	
	var payment_method = document.getElementById('ec_cart_payment_type').value;
	var card_holder_name = document.getElementById('ec_card_holder_name').value;
	var card_number = document.getElementById('ec_card_number').value;
	var exp_month = document.getElementById('ec_expiration_month').value;
	var exp_year = document.getElementById('ec_expiration_year').value;
	var sec_code = document.getElementById('ec_security_code').value;
	
	// Validate Billing Information
	var input_names = ['first_name', 'last_name', 'address', 'city', 'state', 'zip', 'country', 'phone'];
	
	for( var i=0; i< input_names.length; i++){
		if( input_names[i] == "state" && document.getElementById( 'ec_cart_billing_' + input_names[i] ).options ){
			var value = document.getElementById( 'ec_cart_billing_' + input_names[i] ).options[document.getElementById( 'ec_cart_billing_' + input_names[i] ).selectedIndex].value;
		}else{
			var value = document.getElementById( 'ec_cart_billing_' + input_names[i] ).value;
		}
		// validate billing
		if( !ec_validation( "validate_" + input_names[i], value, billing_country_code ) ){
			errors++;
			document.getElementById('ec_cart_billing_' + input_names[i] + '_row').className = "ec_cart_billing_row_error";
		}else{
			document.getElementById('ec_cart_billing_' + input_names[i] + '_row').className = "ec_cart_billing_row";
		}
	}
	
	// Validate Credit Card Information
	if( payment_method == "0" ){
		errors++;
		document.getElementById('ec_cart_payment_type_row').className = "ec_cart_payment_information_row_error";
	}else{
		document.getElementById('ec_cart_payment_type_row').className = "ec_cart_payment_information_row";
	}
	
	if( !ec_validation( "validate_card_holder_name", card_holder_name, payment_method ) ){
		errors++;
		document.getElementById('ec_card_holder_name_row').className = "ec_cart_payment_information_row_error";
	}else{
		document.getElementById('ec_card_holder_name_row').className = "ec_cart_payment_information_row";
	}
	
	if( !ec_validation( "validate_card_number", card_number, payment_method ) ){
		errors++;
		document.getElementById('ec_card_number_row').className = "ec_cart_payment_information_row_error";
	}else{
		document.getElementById('ec_card_number_row').className = "ec_cart_payment_information_row";
	}
	
	if( !ec_validation( "validate_expiration_month", exp_month, payment_method ) || !ec_validation( "validate_expiration_year", exp_year, payment_method ) ){
		errors++;
		document.getElementById('ec_expiration_date_row').className = "ec_cart_payment_information_row_error";
	}else{
		document.getElementById('ec_expiration_date_row').className = "ec_cart_payment_information_row";
	}
	
	if( !ec_validation( "validate_security_code", sec_code, payment_method ) ){
		errors++;
		document.getElementById('ec_security_code_row').className = "ec_cart_payment_information_row_error";
	}else{
		document.getElementById('ec_security_code_row').className = "ec_cart_payment_information_row";
	}
	
	// If new account, Validate Account Info
	if( document.getElementById( 'ec_contact_email' ) ){
		
		var email = jQuery( '#ec_contact_email' ).val( );
		var retype_email = jQuery( '#ec_contact_email_retype' ).val( );
		var password = jQuery( '#ec_contact_password' ).val( );
		var retype_password = jQuery( '#ec_contact_password_retype' ).val( );
		
		if( !ec_validation( "validate_email", email, billing_country_code ) ){
			errors++;
			document.getElementById('ec_contact_email_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_email_row').className = "ec_cart_contact_information_row";
		}
		
		if( retype_email.length == 0 || email != retype_email ){
			errors++;
			document.getElementById('ec_contact_email_retype_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_email_retype_row').className = "ec_cart_contact_information_row";
		}
		
			
		if( !ec_validation( "validate_password", password, billing_country_code ) ){
			errors++;
			document.getElementById('ec_contact_password_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_password_row').className = "ec_cart_contact_information_row";
		}
		
		if( retype_password.length == 0 || password != retype_password ){
			errors++;
			document.getElementById('ec_contact_password_retype_row').className = "ec_cart_contact_information_row_error";
		}else{
			document.getElementById('ec_contact_password_retype_row').className = "ec_cart_contact_information_row";
		}
		
	}
	
	if( errors )
		return false;
	else
		return true;
	
}// Base Theme - EC Cart Javascript Document

function ec_estimate_shipping_click( ){
	
	jQuery('#ec_estimate_shipping_loader').fadeIn(100);
	
	var data = {
		action: 'ec_ajax_estimate_shipping',
		zipcode: document.getElementById( 'ec_cart_zip_code' ).value,
		country: document.getElementById( 'ec_cart_country' ).value
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_estimate_shipping_complete( data ); } } );
	
	return false;
}

function ec_estimate_shipping_complete( data ){
	
	jQuery('#ec_estimate_shipping_loader').fadeOut(100);
	
	var values = data.split("***");
	
	if( values.length == 2 ){
		document.getElementById('ec_cart_shipping').innerHTML = values[0];
		document.getElementById('ec_cart_grandtotal').innerHTML = values[1];
	}else{
		document.getElementById('ec_cart_shipping').innerHTML = values[0];
		document.getElementById('ec_cart_grandtotal').innerHTML = values[1];
		document.getElementById('ec_cart_shipping_methods').innerHTML = values[2];	
	}
}// Base Theme - EC Cart Item Javascript Document

function ec_cart_item_update( cartitem_id ){
	var data = {
		action: 'ec_ajax_cartitem_update',
		cartitem_id: cartitem_id,
		quantity: document.getElementById( 'ec_cartitem_quantity_' + cartitem_id ).value,
		session_id: document.getElementById( 'ec_cart_session_id' ).value
	};
	
	ec_cart_item_show_loader( cartitem_id );
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_cart_item_update_finished( data, cartitem_id ); } } );
}

function ec_cart_item_update_finished( data, cartitem_id ){
	
	ec_cart_item_hide_loader( cartitem_id );
	
	var currency = document.getElementById( 'ec_cartitem_unit_price_' + cartitem_id ).innerHTML.substring(0,1);
	var item_unit_price = parseFloat( document.getElementById( 'ec_cartitem_unit_price_' + cartitem_id ).innerHTML.substring(1).replace( /,/g,'') );
	var item_quantity = Number( document.getElementById( 'ec_cartitem_quantity_' + cartitem_id ).value ).toFixed(2);
	var item_total_price = currency + (item_unit_price * item_quantity).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	document.getElementById('ec_cartitem_total_' + cartitem_id).innerHTML = item_total_price;
	
	if( document.getElementById( 'ec_cart_zip_code' ) ){
		ec_estimate_shipping_click( );
	}
	
	if( document.getElementById('ec_cart_subtotal') ){
		
		var data_split = data.split("***");
		
		//document.getElementById('ec_cart_total_items').innerHTML = data_split[0];
		if( document.getElementById( 'ec_cartitem_unit_price_' + cartitem_id ) )
		document.getElementById( 'ec_cartitem_unit_price_' + cartitem_id ).innerHTML = data_split[0];
		
		if( document.getElementById( 'ec_cartitem_total_' + cartitem_id ) )
		document.getElementById( 'ec_cartitem_total_' + cartitem_id ).innerHTML = data_split[1];
		
		if( document.getElementById( 'ec_cartitem_quantity_' + cartitem_id ) )
		document.getElementById( 'ec_cartitem_quantity_' + cartitem_id ).value = data_split[2];
		
		if( document.getElementById('ec_cart_subtotal') ) 
		document.getElementById('ec_cart_subtotal').innerHTML = data_split[3];
		
		if( document.getElementById('ec_cart_tax') )
		document.getElementById('ec_cart_tax').innerHTML = data_split[4];
		
		if( document.getElementById('ec_cart_shipping') )
		document.getElementById('ec_cart_shipping').innerHTML = data_split[5];
		
		if( document.getElementById('ec_cart_duty') )
		document.getElementById('ec_cart_duty').innerHTML = data_split[6];
		
		if( document.getElementById('ec_cart_vat') )
		document.getElementById('ec_cart_vat').innerHTML = data_split[7];
		
		if( document.getElementById('ec_cart_discount') )
		document.getElementById('ec_cart_discount').innerHTML = data_split[8];
		
		if( document.getElementById('ec_cart_grandtotal') )
		document.getElementById('ec_cart_grandtotal').innerHTML = data_split[9];
		
	}
}

function ec_cart_item_delete( cartitem_id ){
	var data = {
		action: 'ec_ajax_cartitem_delete',
		cartitem_id: cartitem_id,
		quantity: document.getElementById( 'ec_cartitem_quantity_' + cartitem_id ).value,
		session_id: document.getElementById( 'ec_cart_session_id' ).value
	}

	ec_cart_item_show_loader( cartitem_id );
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ ec_cart_item_delete_finished( data, cartitem_id ); } } );
}

function ec_cart_item_delete_finished( data, cartitem_id ){
	
	var data_split = data.split("***");
	
	if( data_split[0] == 0 ){
		document.location = document.getElementById('ec_cart_page').value;
	}else{
	
		ec_cart_item_hide_loader( cartitem_id );
		
		if( document.getElementById( 'ec_cart_zip_code' ) ){
			ec_estimate_shipping_click( );
		}
	
		jQuery('#ec_cart_item_' + cartitem_id ).remove(); 
		if( document.getElementById( 'ec_cart_final_item_' + cartitem_id ) ){
			jQuery('#ec_cart_final_item_' + cartitem_id ).remove();
		}
	
		if( document.getElementById('ec_cart_subtotal') ) 
		document.getElementById('ec_cart_subtotal').innerHTML = data_split[1];
		
		if( document.getElementById('ec_cart_tax') )
		document.getElementById('ec_cart_tax').innerHTML = data_split[2];
		
		if( document.getElementById('ec_cart_shipping') )
		document.getElementById('ec_cart_shipping').innerHTML = data_split[3];
		
		if( document.getElementById('ec_cart_duty') )
		document.getElementById('ec_cart_duty').innerHTML = data_split[4];
		
		if( document.getElementById('ec_cart_vat') )
		document.getElementById('ec_cart_vat').innerHTML = data_split[5];
		
		if( document.getElementById('ec_cart_discount') )
		document.getElementById('ec_cart_discount').innerHTML = data_split[6];
		
		if( document.getElementById('ec_cart_grandtotal') )
		document.getElementById('ec_cart_grandtotal').innerHTML = data_split[7];
	
	}
}

function ec_cart_item_show_loader( cartitem_id ){
	jQuery('#ec_cart_item_loader_' + cartitem_id).fadeIn( 100 );	
}

function ec_cart_item_hide_loader( cartitem_id ){
	jQuery('#ec_cart_item_loader_' + cartitem_id).fadeOut( 100 );
}// Base Theme - EC Cart Login Javascript Document// Base Theme - EC Cart Billing Javascript Document

function ec_cart_billing_validate_input_update( input_name ){
	
	alert( input_name + " changed" );
	var country_code = document.getElementById('ec_cart_billing_country').value;
	var value = document.getElementById('ec_cart_billing_' + input_name).value;
	
	// validate billing
	if( !ec_validation( "validate_" + input_name, value, country_code ) ){
		document.getElementById('ec_cart_billing_' + input_name + '_row').className = "ec_cart_billing_row_error";
	}else{ 
		document.getElementById('ec_cart_billing_' + input_name + '_row').className = "ec_cart_billing_row";
	}	
}

jQuery( document ).ready( function( ){
	jQuery( '#ec_cart_billing_country' ).change( function( ){
		var country = jQuery( '#ec_cart_billing_country' ).val( );
		if( document.getElementById( 'ec_cart_billing_state_' + country ) ){
			jQuery( '.ec_cart_billing_input_text.ec_billing_state_dropdown' ).hide( );
			jQuery( '#ec_cart_billing_state' ).hide( );
			jQuery( '#ec_cart_billing_state_' + country ).show( );
		}else{
			jQuery( '.ec_cart_billing_input_text.ec_billing_state_dropdown' ).hide( );
			jQuery( '#ec_cart_billing_state' ).show( );
		}
	} );
} );// Base Theme - EC Cart Shipping Javascript Document
function ec_cart_use_billing_for_shipping_change(){
	jQuery('.ec_cart_shipping_holder').fadeOut(400);
}

function ec_cart_use_shipping_for_shipping_change(){
	jQuery('.ec_cart_shipping_holder').fadeIn(400);
}

jQuery( document ).ready( function( ){
	jQuery( '#ec_cart_shipping_country' ).change( function( ){
		var country = jQuery( '#ec_cart_shipping_country' ).val( );
		if( document.getElementById( 'ec_cart_shipping_state_' + country ) ){
			jQuery( '.ec_cart_shipping_input_text.ec_shipping_state_dropdown' ).hide( );
			jQuery( '#ec_cart_shipping_state' ).hide( );
			jQuery( '#ec_cart_shipping_state_' + country ).show( );
		}else{
			jQuery( '.ec_cart_shipping_input_text.ec_shipping_state_dropdown' ).hide( );
			jQuery( '#ec_cart_shipping_state' ).show( );
		}
	} );
} );// Base Theme - EC Cart Shipping Method Javascript Document
function ec_cart_shipping_method_change( shipping_method, shipping_price ){
	
	var data = {
		action: 'ec_ajax_update_shipping_method',
		shipping_method: shipping_method
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ ec_cart_shipping_method_change_finished( data ); } } );
	
}


function ec_cart_shipping_method_change_finished( data ){
	var values = data.split("***");
	
	if( values.length == 2 ){
		document.getElementById('ec_cart_shipping').innerHTML = values[0];
		document.getElementById('ec_cart_grandtotal').innerHTML = values[1];
	}else{
		document.getElementById('ec_cart_shipping').innerHTML = values[0];
		document.getElementById('ec_cart_grandtotal').innerHTML = values[1];
		document.getElementById('ec_cart_shipping_methods').innerHTML = values[2];	
	}
}
// Base Theme - EC Cart Coupon Javascript Document
function ec_cart_coupon_code_redeem( ){
	
	jQuery('#ec_cart_coupon_loader').fadeIn(100);
	
	var data = {
		action: 'ec_ajax_redeem_coupon_code',
		couponcode: document.getElementById('ec_cart_coupon_code').value
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ ec_cart_coupon_code_redeem_complete( data ); } } );
}

function ec_cart_coupon_code_redeem_complete( data ){
	jQuery('#ec_cart_coupon_loader').fadeOut(100);
	
	var data_split = data.split("***");
	
	if( document.getElementById('ec_cart_subtotal') )
		document.getElementById('ec_cart_subtotal').innerHTML = data_split[1];
	
	if( document.getElementById('ec_cart_tax') )
		document.getElementById('ec_cart_tax').innerHTML = data_split[2];
	
	if( document.getElementById('ec_cart_shipping') )
		document.getElementById('ec_cart_shipping').innerHTML = data_split[3];
	
	if( document.getElementById('ec_cart_discount') )
		document.getElementById('ec_cart_discount').innerHTML = data_split[4];
	
	if( document.getElementById('ec_cart_duty') )
		document.getElementById('ec_cart_duty').innerHTML = data_split[5];
	
	if( document.getElementById('ec_cart_vat') )
		document.getElementById('ec_cart_vat').innerHTML = data_split[6];
	
	if( document.getElementById('ec_cart_grandtotal') )
		document.getElementById('ec_cart_grandtotal').innerHTML = data_split[7];
	
	if( data_split.length > 8 ){
		document.getElementById('ec_cart_coupon_row_message').innerHTML = data_split[8];
	}else{
		document.getElementById('ec_cart_coupon_row_message').innerHTML = "";
	}
}
// Base Theme - EC Cart Gift Card Javascript Document
function ec_cart_gift_card_redeem( ){
	
	jQuery('#ec_cart_gift_card_loader').fadeIn(100);
	
	var data = {
		action: 'ec_ajax_redeem_gift_card',
		giftcard: document.getElementById('ec_cart_gift_card').value
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ ec_cart_gift_card_redeem_complete( data ); } } );
}

function ec_cart_gift_card_redeem_complete( data ){
	jQuery('#ec_cart_gift_card_loader').fadeOut(100);
	
	var data_split = data.split("***");
	
	if( document.getElementById('ec_cart_subtotal') )
		document.getElementById('ec_cart_subtotal').innerHTML = data_split[1];
	
	if( document.getElementById('ec_cart_tax') )
		document.getElementById('ec_cart_tax').innerHTML = data_split[2];
	
	if( document.getElementById('ec_cart_shipping') )
		document.getElementById('ec_cart_shipping').innerHTML = data_split[3];
	
	if( document.getElementById('ec_cart_discount') )
		document.getElementById('ec_cart_discount').innerHTML = data_split[4];
	
	if( document.getElementById('ec_cart_duty') )
		document.getElementById('ec_cart_duty').innerHTML = data_split[5];
	
	if( document.getElementById('ec_cart_vat') )
		document.getElementById('ec_cart_vat').innerHTML = data_split[6];
	
	if( document.getElementById('ec_cart_grandtotal') )
		document.getElementById('ec_cart_grandtotal').innerHTML = data_split[7];
	
	if( data_split.length > 8 ){
		document.getElementById('ec_cart_gift_card_row_message').innerHTML = data_split[8];
	}else{
		document.getElementById('ec_cart_gift_card_row_message').innerHTML = "";
	}
}

// Base Theme - EC Cart Payment Information Javascript Document
function ec_cart_update_payment_type( payment_type ){
	
	jQuery('#ec_cart_pay_by_manual_payment').hide();
	jQuery('#ec_cart_pay_by_third_party').hide();
	jQuery('#ec_cart_pay_by_credit_card_holder').hide();
	
	if( payment_type == "manual_bill" )
		jQuery('#ec_cart_pay_by_manual_payment').show();
	else if( payment_type == "third_party" )
		jQuery('#ec_cart_pay_by_third_party').show();
	else if( payment_type == "credit_card" )
		jQuery('#ec_cart_pay_by_credit_card_holder').show();
	

}// Base Theme - EC Cart Contact Information Javascript Document
function ec_contact_create_account_change( ){
	if( document.getElementById('ec_contact_create_account').checked == true )
		jQuery( '#ec_cart_password_input').fadeIn(150);
	else
		jQuery( '#ec_cart_password_input').fadeOut(150);	
}// Base Theme - EC Cart Submit Order Javascript Document
function ec_cart_submit_order_click(){
	var has_errors = false;
	if( !ec_cart_payment_method_check( ) )			has_errors = true;
	if( !ec_cart_card_holder_name_check( ) ) 		has_errors = true;
	if( !ec_cart_card_number_check( ) ) 			has_errors = true;
	if( !ec_cart_expiration_month_check( ) ) 		has_errors = true;
	if( !ec_cart_expiration_year_check( ) ) 		has_errors = true;
	if( !ec_cart_security_code_check( ) ) 			has_errors = true;
	if( !ec_cart_email_check( ) ) 					has_errors = true;
	if( !ec_cart_email_retype_check( ) ) 			has_errors = true;
		
	return !has_errors;
}

function ec_cart_payment_method_check( ){
	if( document.getElementById('ec_payment_type').value != 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_payment_type') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_payment_type') );
		return false;
	}
}

function ec_cart_card_holder_name_check( ){
	if( document.getElementById('ec_card_holder_name').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_card_holder_name') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_card_holder_name') );
		return false;
	}
}

function ec_cart_card_number_check( ){
	if( document.getElementById('ec_card_number').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_card_number') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_card_number') );
		return false;
	}
}

function ec_cart_expiration_month_check( ){
	if( document.getElementById('ec_expiration_month').value != 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_expiration_month') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_expiration_month') );
		return false;
	}
}

function ec_cart_expiration_year_check( ){
	if( document.getElementById('ec_expiration_year').value != 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_expiration_year') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_expiration_year') );
		return false;
	}
}

function ec_cart_security_code_check( ){
	if( document.getElementById('ec_security_code').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_security_code') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_security_code') );
		return false;
	}
}

function ec_cart_email_check( ){
	if( document.getElementById('ec_contact_email').value.length > 0 ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_contact_email') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_contact_email') );
		return false;
	}
}

function ec_cart_email_retype_check( ){
	if( document.getElementById('ec_contact_email_retype').value.length > 0 && document.getElementById('ec_contact_email').value.length == document.getElementById('ec_contact_email_retype').value.length ){
		ec_text_field_highlight_error_remove( document.getElementById('ec_contact_email_retype') );
		return true;
	}else{
		ec_text_field_highlight_error( document.getElementById('ec_contact_email_retype') );
		return false;
	}
}

function ec_text_field_highlight_error( field ){
	field.style.backgroundColor = 'Yellow';
}

function ec_text_field_highlight_error_remove( field ){
	field.style.backgroundColor = 'White';
}
// JavaScript Document// JavaScript Document// Base Theme - EC Cart Third Party Javascript Document////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Base Theme - EC Account Billing Information Javascript Document

function ec_account_billing_information_update_click( ){
	var errors = 0;
	
	var country = document.getElementById('ec_account_billing_information_country').value;
	var first_name = document.getElementById('ec_account_billing_information_first_name').value;
	var last_name = document.getElementById('ec_account_billing_information_last_name').value;
	var address = document.getElementById('ec_account_billing_information_address').value;
	var city = document.getElementById('ec_account_billing_information_city').value;
	var state = document.getElementById('ec_account_billing_information_state').value;
	
	// Check for special drop down
	if( document.getElementById( 'ec_account_billing_information_state_' + country ) && document.getElementById( 'ec_account_billing_information_state_' + country ).options ){
		state = document.getElementById( 'ec_account_billing_information_state_' + country ).options[document.getElementById( 'ec_account_billing_information_state_' + country ).selectedIndex].value;
	}
	
	var zip = document.getElementById('ec_account_billing_information_zip').value;
	var phone = document.getElementById('ec_account_billing_information_phone').value;
	
	if( !ec_validation( "validate_first_name", first_name, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_first_name_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_first_name_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_last_name", last_name, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_last_name_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_last_name_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_address", address, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_address_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_address_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_city", city, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_city_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_city_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_state", state, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_state_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_state_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_zip", zip, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_zip_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_zip_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_country", country, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_country_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_country_row').className = "ec_account_billing_information_row";
	}
	
	if( !ec_validation( "validate_phone", phone, country ) ){
		errors++;
		document.getElementById('ec_account_billing_information_phone_row').className = "ec_account_billing_information_row_error";
	}else{ 
		document.getElementById('ec_account_billing_information_phone_row').className = "ec_account_billing_information_row";
	}
	
	
	if( errors > 0 )
		return false;
	else
		return true;
	
}

jQuery( document ).ready( function( ){
	jQuery( '#ec_account_billing_information_country' ).change( function( ){
		var country = jQuery( '#ec_account_billing_information_country' ).val( );
		if( document.getElementById( 'ec_account_billing_information_state_' + country ) ){
			jQuery( '.ec_account_billing_information_input_field.ec_billing_state_dropdown' ).hide( );
			jQuery( '#ec_account_billing_information_state' ).hide( );
			jQuery( '#ec_account_billing_information_state_' + country ).show( );
		}else{
			jQuery( '.ec_account_billing_information_input_field.ec_billing_state_dropdown' ).hide( );
			jQuery( '#ec_account_billing_information_state' ).show( );
		}
	} );
} );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Dashboard Javascript Document
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Login Javascript Document
function ec_account_login_button_click( ){
	var errors = 0;
	
	var email = document.getElementById( 'ec_account_login_email' ).value;
	var password = document.getElementById( 'ec_account_login_password' ).value;
	
	if( !ec_validation( "validate_email", email, "US" ) ){
		errors++;
		document.getElementById('ec_account_login_email_row').className = "ec_account_login_row_error";
	}else{ 
		document.getElementById('ec_account_login_email_row').className = "ec_account_login_row";
	}
	
	if( !ec_validation( "validate_password", password, "US" ) ){
		errors++;
		document.getElementById('ec_account_login_password_row').className = "ec_account_login_row_error";
	}else{ 
		document.getElementById('ec_account_login_password_row').className = "ec_account_login_row";
	}
	
	if( errors > 0 )
		return false;
	else
		return true;
}////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Order Details Javascript Document/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Orders Javascript Document
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Page Javascript Document////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Password Javascript Document
function ec_account_password_button_click( ){
	var errors = 0;
	
	var password = document.getElementById('ec_account_password_current_password').value;
	var new_password = document.getElementById('ec_account_password_new_password').value;
	var retype_new_password = document.getElementById('ec_account_password_retype_new_password').value;
	
	if( !ec_validation( "validate_password", password, "US" ) ){
		errors++;
		document.getElementById('ec_account_password_current_password_row').className = "ec_account_password_row_error";
	}else{ 
		document.getElementById('ec_account_password_current_password_row').className = "ec_account_password_row";
	}
	
	if( !ec_validation( "validate_password", new_password, "US" ) ){
		errors++;
		document.getElementById('ec_account_password_new_password_row').className = "ec_account_password_row_error";
	}else{ 
		document.getElementById('ec_account_password_new_password_row').className = "ec_account_password_row";
	}
	
	if( retype_new_password != new_password ){
		errors++;
		document.getElementById('ec_account_password_retype_new_password_row').className = "ec_account_password_row_error";
	}else{ 
		document.getElementById('ec_account_password_retype_new_password_row').className = "ec_account_password_row";
	}
	
	if( errors > 0 )
		return false;
	else
		return true;
	
}////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Personal Information Javascript Document
function ec_account_personal_information_update_click( ){
	var errors = 0;
	
	var first_name = document.getElementById('ec_account_personal_information_first_name').value;
	var last_name = document.getElementById('ec_account_personal_information_last_name').value;
	var email = document.getElementById('ec_account_personal_information_email').value;
	
	if( !ec_validation( "validate_first_name", first_name, "US" ) ){
		errors++;
		document.getElementById('ec_account_personal_information_first_name_row').className = "ec_account_personal_information_row_error";
	}else{ 
		document.getElementById('ec_account_personal_information_first_name_row').className = "ec_account_personal_information_row";
	}
	
	if( !ec_validation( "validate_last_name", last_name, "US" ) ){
		errors++;
		document.getElementById('ec_account_personal_information_last_name_row').className = "ec_account_personal_information_row_error";
	}else{ 
		document.getElementById('ec_account_personal_information_last_name_row').className = "ec_account_personal_information_row";
	}
	
	if( !ec_validation( "validate_email", email, "US" ) ){
		errors++;
		document.getElementById('ec_account_personal_information_email_row').className = "ec_account_personal_information_row_error";
	}else{ 
		document.getElementById('ec_account_personal_information_email_row').className = "ec_account_personal_information_row";
	}
	
	if( errors > 0 )
		return false;
	else
		return true;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Shipping Information Javascript Document
	
function ec_account_shipping_information_update_click( ){
	var errors = 0;
	
	var country = document.getElementById('ec_account_shipping_information_country').value;
	var first_name = document.getElementById('ec_account_shipping_information_first_name').value;
	var last_name = document.getElementById('ec_account_shipping_information_last_name').value;
	var address = document.getElementById('ec_account_shipping_information_address').value;
	var city = document.getElementById('ec_account_shipping_information_city').value;
	var state = document.getElementById('ec_account_shipping_information_state').value;
	
	// Check for special drop down
	if( document.getElementById( 'ec_account_shipping_information_state_' + country ) && document.getElementById( 'ec_account_shipping_information_state_' + country ).options ){
		state = document.getElementById( 'ec_account_shipping_information_state_' + country ).options[document.getElementById( 'ec_account_shipping_information_state_' + country ).selectedIndex].value;
	}
	
	var zip = document.getElementById('ec_account_shipping_information_zip').value;
	var phone = document.getElementById('ec_account_shipping_information_phone').value;
	
	if( !ec_validation( "validate_first_name", first_name, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_first_name_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_first_name_row').className = "ec_account_shipping_information_row";
	}
	
	if( !ec_validation( "validate_last_name", last_name, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_last_name_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_last_name_row').className = "ec_account_shipping_information_row";
	}
	
	if( !ec_validation( "validate_address", address, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_address_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_address_row').className = "ec_account_shipping_information_row";
	}
	
	if( !ec_validation( "validate_city", city, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_city_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_city_row').className = "ec_account_shipping_information_row";
	}
	
	if( !ec_validation( "validate_state", state, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_state_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_state_row').className = "ec_account_shipping_information_row";
	}
	
	if( !ec_validation( "validate_zip", zip, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_zip_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_zip_row').className = "ec_account_shipping_information_row";
	}
	
	if( !ec_validation( "validate_country", country, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_country_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_country_row').className = "ec_account_shipping_information_row";
	}
	
	if( !ec_validation( "validate_phone", phone, country ) ){
		errors++;
		document.getElementById('ec_account_shipping_information_phone_row').className = "ec_account_shipping_information_row_error";
	}else{ 
		document.getElementById('ec_account_shipping_information_phone_row').className = "ec_account_shipping_information_row";
	}
	
	
	if( errors > 0 )
		return false;
	else
		return true;
	
}

jQuery( document ).ready( function( ){
	jQuery( '#ec_account_shipping_information_country' ).change( function( ){
		var country = jQuery( '#ec_account_shipping_information_country' ).val( );
		if( document.getElementById( 'ec_account_shipping_information_state_' + country ) ){
			jQuery( '.ec_account_shipping_information_input_field.ec_shipping_state_dropdown' ).hide( );
			jQuery( '#ec_account_shipping_information_state' ).hide( );
			jQuery( '#ec_account_shipping_information_state_' + country ).show( );
		}else{
			jQuery( '.ec_account_shipping_information_input_field.ec_shipping_state_dropdown' ).hide( );
			jQuery( '#ec_account_shipping_information_state' ).show( );
		}
	} );
} );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Forgot Password Javascript Document

function ec_account_forgot_password_button_click( ){
	var errors = 0;
	
	var email = document.getElementById( 'ec_account_forgot_password_email' ).value;
	
	if( !ec_validation( "validate_email", email, "US" ) ){
		errors++;
		document.getElementById('ec_account_forgot_password_email_row').className = "ec_account_forgot_password_row_error";
	}else{ 
		document.getElementById('ec_account_forgot_password_email_row').className = "ec_account_forgot_password_row";
	}
	
	if( errors > 0 )
		return false;
	else
		return true;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Register Javascript Document

function ec_account_register_button_click( ){
	var errors = 0;
	
	var first_name = document.getElementById('ec_account_register_first_name').value;
	var last_name = document.getElementById('ec_account_register_last_name').value;
	var email = document.getElementById('ec_account_register_email').value;
	var password = document.getElementById('ec_account_register_password').value;
	var retype_password = document.getElementById('ec_account_register_password_retype').value;
	
	if( !ec_validation( "validate_first_name", first_name, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_first_name_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_first_name_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_last_name", last_name, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_last_name_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_last_name_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_email", email, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_email_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_email_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_password", password, "US" ) ){
		errors++;
		document.getElementById('ec_account_register_password_row').className = "ec_account_register_row_error";
		document.getElementById('ec_account_register_password_retype_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_password_row').className = "ec_account_register_row";
	}
	
	if( !ec_validation( "validate_password", password, "US" ) || password != retype_password ){
		errors++;
		document.getElementById('ec_account_register_password_retype_row').className = "ec_account_register_row_error";
	}else{ 
		document.getElementById('ec_account_register_password_retype_row').className = "ec_account_register_row";
	}
	
	if( errors > 0 )
		return false;
	else
		return true;
	
}

function ec_account_register_button_click2( ){
	var top_half = ec_account_register_button_click( );
	var bottom_half = ec_account_billing_information_update_click( );
	if( top_half && bottom_half ){
		return true;
	}else{
		return false;
	}
}////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - Account Order Line Javascript Document
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - EC Account Order Details Item Display Javascript Document
function update_download_count( orderdetail_id ){
	if( document.getElementById( 'ec_download_count_' + orderdetail_id ) ){
		var count = Number(document.getElementById( 'ec_download_count_' + orderdetail_id ).innerHTML);
		var max_count = Number(document.getElementById( 'ec_download_count_max_' + orderdetail_id ).innerHTML);
		if( count < max_count ){
			count++;
			document.getElementById( 'ec_download_count_' + orderdetail_id ).innerHTML = count;
		}
	}
}////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Base Theme - Account Order Line Javascript Document
function show_billing_info( ){
	jQuery( '#ec_account_subscription_billing_information' ).fadeIn( );
	jQuery( '#ec_account_subscription_payment' ).fadeIn( );
	return false;
}

function ec_cancel_subscription_check( confirm_text ){
	return confirm( confirm_text );
}// JavaScript Document
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
jQuery(document).ready(function() {
    jQuery(".ec_menu_vertical").accordion({
        accordion:true,
        speed: 500,
        closedSign: '[+]',
        openedSign: '[-]'
    });
});
(function(jQuery){
    jQuery.fn.extend({
    accordion: function(options) {
        
		var defaults = {
			accordion: 'true',
			speed: 300,
			closedSign: '[+]',
			openedSign: '[-]'
		};
		var opts = jQuery.extend(defaults, options);
 		var jQuerythis = jQuery(this);
 		jQuerythis.find("li").each(function() {
 			if(jQuery(this).find("ul").size() != 0){
 				jQuery(this).find("a:first").append("<span>"+ opts.closedSign +"</span>");
 				if(jQuery(this).find("a:first").attr('href') == "#"){
 		  			jQuery(this).find("a:first").click(function(){return false;});
 		  		}
 			}
 		});
 		jQuerythis.find("li.active").each(function() {
 			jQuery(this).parents("ul").slideDown(opts.speed);
 			jQuery(this).parents("ul").parent("li").find("span:first").html(opts.openedSign);
 		});
  		jQuerythis.find("li a").click(function() {
  			if(jQuery(this).parent().find("ul").size() != 0){
  				if(opts.accordion){
  					if(!jQuery(this).parent().find("ul").is(':visible')){
  						parents = jQuery(this).parent().parents("ul");
  						visible = jQuerythis.find("ul:visible");
  						visible.each(function(visibleIndex){
  							var close = true;
  							parents.each(function(parentIndex){
  								if(parents[parentIndex] == visible[visibleIndex]){
  									close = false;
  									return false;
  								}
  							});
  							if(close){
  								if(jQuery(this).parent().find("ul") != visible[visibleIndex]){
  									jQuery(visible[visibleIndex]).slideUp(opts.speed, function(){
  										jQuery(this).parent("li").find("span:first").html(opts.closedSign);
  									});
  									
  								}
  							}
  						});
  					}
  				}
  				if(jQuery(this).parent().find("ul:first").is(":visible")){
  					jQuery(this).parent().find("ul:first").slideUp(opts.speed, function(){
  						jQuery(this).parent("li").find("span:first").delay(opts.speed).html(opts.closedSign);
  					});
  					
  					
  				}else{
  					jQuery(this).parent().find("ul:first").slideDown(opts.speed, function(){
  						jQuery(this).parent("li").find("span:first").delay(opts.speed).html(opts.openedSign);
  					});
  				}
  			}
  		});
    }
});
})(jQuery);
function ec_cart_widget_click( ){
	if( !jQuery('.ec_cart_widget_minicart_wrap').is(':visible') ) 
		jQuery('.ec_cart_widget_minicart_wrap').fadeIn( 200 );
	else
		jQuery('.ec_cart_widget_minicart_wrap').fadeOut( 100 );
}

function ec_cart_widget_mouseover( ){
	if( !jQuery('.ec_cart_widget_minicart_wrap').is(':visible') ){
		jQuery('.ec_cart_widget_minicart_wrap').fadeIn( 200 );
		jQuery('.ec_cart_widget_minicart_bg').css( "display", "block" );
	}
}

function ec_cart_widget_mouseout( ){
	if( jQuery('.ec_cart_widget_minicart_wrap').is(':visible') ) {
		jQuery('.ec_cart_widget_minicart_wrap').fadeOut( 100 );
		jQuery('.ec_cart_widget_minicart_bg').css( "display", "none" );
	}
}
function ec_validation( function_name, input, country_code ){
	
	if( function_name == "validate_first_name" ){
		if( input.length > 0)
			return true;
		else
			return false;
		
	}else if( function_name == "validate_last_name" ){
		if( input.length > 0)
			return true;
		else
			return false;
			
	}else if( function_name == "validate_address" ){
		if( country_code == "US" ){
			if( input.length > 0 )
				return true;	
			else
				return false;
				
		}else{
			if( input.length > 0)
				return true;
			else
				return false;
				
		}
	}else if( function_name == "validate_city" ){
		if( country_code == "US" ){
			if( input.length > 0 )
				return true;	
			else
				return false;
				
		}else{
			if( input.length > 0)
				return true;
			else
				return false;
				
		}
	}else if( function_name == "validate_state" ){
		var us_states = ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY', 'AS', 'GU', 'MP', 'PR', 'VI', 'UM', 'ALABAMA', 'ALASKA', 'ARIZONA', 'ARKANSAS', 'CALIFORNIA', 'COLORADO', 'CONNECTICUT', 'DELAWARE', 'DISTRICT OF COLUMBIA', 'D.C.', 'FLORIDA', 'GEORGIA', 'HAWAII', 'IDAHO', 'ILLINOIS', 'INDIANA', 'IOWA', 'KANSAS', 'KENTUCKY', 'LOUISIANA', 'MAINE', 'MARYLAND', 'MASSACHUSETTS', 'MICHIGAN', 'MINNESOTA', 'MISSISSIPPI', 'MISSOURI', 'MONTANA', 'NEBRASKA', 'NEVADA', 'NEW HAMPSHIRE', 'NEW JERSEY', 'NEW MEXICO', 'NEW YORK', 'NORTH CAROLINA', 'NORTH DAKOTA', 'OHIO', 'OKLAHOMA', 'OREGON', 'PENNSYLVANIA', 'RHODE ISLAND', 'SOUTH CAROLINA', 'SOUTH DAKOTA', 'TENNESSEE', 'TEXAS', 'UTAH', 'VERMONT', 'VIRGINIA', 'WASHINGTON', 'WEST VIRGINIA', 'WISCONSIN', 'WYOMING', 'AMERICAN SAMOA', 'GUAM', 'NORTH MARINANA ISLANDS', 'PUERTO RICO', 'VIRGIN ISLANDS']
		
		input = input.toUpperCase();
		
		if( country_code == "US" ){
			if( jQuery.inArray( input, us_states ) != -1 )
				return true;	
			else
				return false;
				
		}else{
			return true;
				
		}
	}else if( function_name == "validate_zip" ){
		var no_zip_countries = ['AO', 'AG', 'AW', 'BS', 'BZ', 'BJ', 'BW', 'BF', 'BI', 'KM', 'CG', 'CK', 'CI', 'DJ', 'DM', 'TP', 'GQ', 'ER', 'FJ', 'GM', 'GH', 'GD', 'GN', 'GY', 'HK', 'IE', 'KI', 'MO', 'MW', 'ML', 'MR', 'MU', 'MS', 'NA', 'NR', 'NU', 'PA', 'QA', 'RW', 'KN', 'LC', 'ST', 'SC', 'SL', 'SB', 'SO', 'SR', 'SY', 'TK', 'TO', 'TT', 'TV', 'UG', 'AE', 'VU', 'YE', 'ZW'];
		
		if( country_code == "US" ){
			if( /(^\d{5}$)|(^\d{5}-\d{4}$)/.test( input ) )
				return true;
			else
				return false;
		}else if( jQuery.inArray( country_code, no_zip_countries ) ){
			return true;
		}else{
			if( input.length > 0 )
				return true;
			else
				return false;	
		}
	}else if( function_name == "validate_country" ){
		if( input != 0 && input.length > 0)
			return true;	
		else
			return false;
	}else if( function_name == "validate_phone" ){
		if( country_code == "US" ){
			if( /^(?:\(\d{3}\)|\d{3})(?:\s|[-,.])?\d{3}(?:\s|[-,.])?\d{4}$/.test( input ) )
				return true;
			else
				return false;
		}else{
			if( input.length > 0 )
				return true;	
			else
				return false;
		}
	}else if( function_name == "validate_email" ){
		if( /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/.test( input ) )
			return true;
		else
			return false;
	}else if( function_name == "validate_password" ){
		if( input.length > 5 )
			return true;
		else
			return false;
	}else if( function_name == "validate_card_holder_name" ){
		if( country_code == "paypal" )
			return true;
		else if( input.length > 0 )
			return true;
		else
			return false;
	}else if( function_name == "validate_card_number" ){
		
		input = input.replace(/[^\d]/g,'');
		
		if( /^4[0-9]{12}(?:[0-9]{3}|[0-9]{6})?$/.test( input ) )
			return true;
		else if( /^6(?:011|5[0-9]{2})[0-9]{12}$/.test( input ) )
			return true;
		else if( /^5[1-5]\d{14}$/.test( input ) )
			return true;
		else if( /^3[47][0-9]{13}$/.test( input ) )
			return true;
		else if( /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/.test( input ) )
			return true;
		else if( /^1800\d{11}$|^3\d{15}$/.test( input ) )
			return true;
		else if( /(^(5[0678]\d{11,18}$))|(^(6[^0357])\d{11,18}$)|(^(3)\d{13,20}$)/.test( input ) )
			return true;
		else
			return false;
		
	}else if( function_name == "validate_expiration_month" ){
		if( country_code == "paypal" )
			return true;
		else if( !isNaN( input ) && input.length == 2 )
			return true;
		else
			return false;
			
	}else if( function_name == "validate_expiration_year" ){
		if( country_code == "paypal" )
			return true;
		else if( !isNaN( input ) && input.length == 4 )
			return true;
		else
			return false;
	}else if( function_name == "validate_security_code" ){
		if( country_code == "paypal" )
			return true;
		else if( /^[0-9]{3,4}$/.test( input ) )
			return true;
		else
			return false;
	}
}

function ec_open_login_click( ){
	jQuery( '#ec_alt_login' ).slideToggle(300);
	
	return false;
}

function ec_cart_show_review_panel( ){
	
	jQuery( '.ec_cart_final_loader_overlay' ).show( );
	
	var data = { action: 'ec_ajax_get_cart' };
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ ec_cart_load_finalize_cart( data ); } } );
	
	var data = { action: 'ec_ajax_get_cart_totals' };
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ ec_cart_load_finalize_cart_totals( data ); } } );
	
	if( document.getElementById( 'ec_order_notes' ) && document.getElementById( 'ec_order_notes' ).value.length > 0 ){
		jQuery( '.ec_cart_final_custom_notes_title' ).show( );
		jQuery( '#ec_cart_final_custom_notes' ).show( );
		document.getElementById( 'ec_cart_final_custom_notes' ).innerHTML = document.getElementById( 'ec_order_notes' ).value;
	}else if( document.getElementById( 'ec_order_notes' ) ){
		jQuery( '.ec_cart_final_custom_notes_title' ).hide( );
		jQuery( '#ec_cart_final_custom_notes' ).hide( );
	}
	
	jQuery( 'html, body' ).animate( {
		scrollTop: 0
	}, 750);
	
	jQuery( '#ec_cart_final_review_background' ).fadeIn( 100 );
	jQuery( '#ec_cart_final_review_holder' ).fadeIn( 300 );
}

function ec_cart_load_finalize_cart( data ){
	var json = jQuery.parseJSON( data );
	
	for( var i=0; i<json.length; i++ ){
		jQuery( '#ec_cart_final_item_' + json[i].cartitem_id ).removeClass( 'ec_final_item_row_color1' ).removeClass( 'ec_final_item_row_color2' );
		if( i%2 ){
			jQuery( '#ec_cart_final_item_' + json[i].cartitem_id ).addClass( 'ec_final_item_row_color1' );
		}else{
			jQuery( '#ec_cart_final_item_' + json[i].cartitem_id ).addClass( 'ec_final_item_row_color2' );
		}
		document.getElementById( 'ec_cart_final_item_quantity_' + json[i].cartitem_id ).innerHTML = json[i].quantity;
		document.getElementById( 'ec_cart_final_item_price_' + json[i].cartitem_id ).innerHTML = json[i].unit_price;
	}
	
}

function ec_cart_load_finalize_cart_totals( data ){
	var json = jQuery.parseJSON( data );
	
	if( document.getElementById( 'ec_cart_final_subtotal' ) )
		document.getElementById( 'ec_cart_final_subtotal' ).innerHTML = json.sub_total;
	if( document.getElementById( 'ec_cart_final_tax' ) )
		document.getElementById( 'ec_cart_final_tax' ).innerHTML = json.tax_total;
	if( document.getElementById( 'ec_cart_final_shipping' ) )
		document.getElementById( 'ec_cart_final_shipping' ).innerHTML = json.shipping_total;
	if( document.getElementById( 'ec_cart_final_discount' ) )
		document.getElementById( 'ec_cart_final_discount' ).innerHTML = json.duty_total;
	if( document.getElementById( 'ec_cart_final_duty' ) )
		document.getElementById( 'ec_cart_final_duty' ).innerHTML = json.vat_total;
	if( document.getElementById( 'ec_cart_final_vat' ) )
		document.getElementById( 'ec_cart_final_vat' ).innerHTML = json.discount_total;
	if( document.getElementById( 'ec_cart_final_grand_total' ) )
		document.getElementById( 'ec_cart_final_grand_total' ).innerHTML = json.grand_total;
	
	jQuery( '.ec_cart_final_loader_overlay' ).fadeOut( 250 );
}

function ec_cart_cancel_order( ){
	jQuery( '#ec_cart_final_review_background' ).fadeOut( 100 );
	jQuery( '#ec_cart_final_review_holder' ).fadeOut( 100 );
	return false;
}

function ec_stop_enter_press( evt ){ 
	var evt = (evt) ? evt : ((event) ? event : null); 
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
	if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
}

function ec_check_success_passwords( ){
	var password = document.getElementById( 'ec_password' ).value;
	var verify_password = document.getElementById( 'ec_verify_password' ).value;
	
	var errors = 0;
	
	if( password.length < 6 || password.length > 12 ){
		jQuery( '#ec_cart_error_password_length' ).show( );
		jQuery( '#ec_cart_error_password_match' ).hide( );
		errors++;
	}else if( password != verify_password ){
		jQuery( '#ec_cart_error_password_length' ).hide( );
		jQuery( '#ec_cart_error_password_match' ).show( );
		errors++;
	}
	
	if( errors ){
		jQuery( '#ec_cart_success_error_text' ).show( );
		return false;
	}else{
		jQuery( '#ec_cart_success_error_text' ).hide( );
		return true;
	}
}

jQuery( document ).ready( function( ){
	jQuery( '#ec_card_number' ).on( 'input', ec_check_credit_card_type );
} );

function ec_check_credit_card_type( ){
	var num = document.getElementById( 'ec_card_number' ).value;
	// first, sanitize the number by removing all non-digit characters.
	num = num.replace(/[^\d]/g,'');
	// now test the number against some regexes to figure out the card type.
	if( num.match( /^5[1-5]\d{14}$/ ) ){
		ec_show_cc_type( "mastercard" );
	}else if( num.match( /^4\d{15}/ ) || num.match( /^4\d{12}/ ) ){
		ec_show_cc_type( "visa" );
	}else if( num.match( /(^3[47])((\d{11}$)|(\d{13}$))/ ) ){
		ec_show_cc_type( "amex" );
	}else if( num.match( /(^3[47])((\d{11}$)|(\d{13}$))/ ) ){
		ec_show_cc_type( "discover" );
	}else if( num.match( /^(?:5[0678]\d\d|6304|6390|67\d\d)\d{8,15}$/ ) ){
		ec_show_cc_type( "maestro" );
	}else if( num.match( /(^(352)[8-9](\d{11}$|\d{12}$))|(^(35)[3-8](\d{12}$|\d{13}$))/ ) ){
		ec_show_cc_type( "jcb" );
	}else if( num.match( /(^(30)[0-5]\d{11}$)|(^(36)\d{12}$)|(^(38[0-8])\d{11}$)/ ) ){
		ec_show_cc_type( "diners" );
	}else{
		ec_show_cc_type( "all" );
	}
}

function ec_show_cc_type( type ){
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_visa' ) ){
		if( type == "visa" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_visa' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_visa_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_visa' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_visa_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_delta' ) ){
		if( type == "delta" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_delta' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_delta_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_delta' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_delta_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_uke' ) ){
		if( type == "uke" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_uke' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_uke_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_uke' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_uke_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_discover' ) ){
		if( type == "discover" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_discover' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_discover_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_discover' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_discover_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_mastercard' ) ){
		if( type == "mastercard" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_mastercard' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_mastercard_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_mastercard' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_mastercard_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_amex' ) ){
		if( type == "amex" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_amex' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_amex_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_amex' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_amex_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_jcb' ) ){
		if( type == "jcb" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_jcb' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_jcb_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_jcb' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_jcb_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_diners' ) ){
		if( type == "diners" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_diners' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_diners_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_diners' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_diners_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_laser' ) ){
		if( type == "laser" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_laser' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_laser_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_laser' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_laser_inactive' ).show( );
		}
	}
	
	if( document.getElementById( 'ec_cart_payment_credit_card_icon_maestro' ) ){
		if( type == "maestro" || type == "all" ){
			jQuery( '#ec_cart_payment_credit_card_icon_maestro' ).show( );
			jQuery( '#ec_cart_payment_credit_card_icon_maestro_inactive' ).hide( );
		}else{
			jQuery( '#ec_cart_payment_credit_card_icon_maestro' ).hide( );
			jQuery( '#ec_cart_payment_credit_card_icon_maestro_inactive' ).show( );
		}
	}
}

jQuery( document ).ready( function( ){
	jQuery( '.ec_cart_final_review_background' ).appendTo( document.body );
	jQuery( '.ec_cart_final_review_holder' ).appendTo( document.body );
} );