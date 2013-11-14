// Base Theme - Product Filter Bar Javascript Document
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
	
}