jQuery(document).ready(
	function() {
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
			if( ec_uses_optionitem_images( ) && level == 1 ){
				ec_update_product_details_images( level, document.getElementById( 'ec_option' + level + "_" + model_number ).selectedIndex - 1 );
			}
			
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
	
	var error_text = "$GLOBALVAR_SWATCH_ERROR";
	
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
}