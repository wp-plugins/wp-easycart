// JavaScript Document
jQuery( document ).ready( function( ){
	jQuery( '.ec_flipbook_left' ).click( 
		function( event ){
			var current_image = jQuery( event.target ).parent( ).children( 'img' ).attr( 'src' );
			var image_list_string = jQuery( event.target ).parent( ).data( 'image-list' );
			var image_list = image_list_string.split( ',' );
			var prev = image_list[image_list.length - 1]; 
			for( var i=0; i<image_list.length; i++ ){ 
				if( image_list[i] == current_image ){ 
					break; 
				}else{ 
					prev = image_list[i]; 
				} 
			}
			jQuery( event.target ).parent( ).children( 'img' ).attr( 'src', prev );
		}
	);
	jQuery( '.ec_flipbook_right' ).click( 
		function( event ){
			var current_image = jQuery( event.target ).parent( ).children( 'img' ).attr( 'src' );
			var image_list_string = jQuery( event.target ).parent( ).data( 'image-list' );
			var image_list = image_list_string.split( ',' );
			var prev = image_list[0]; 
			for( var i=image_list.length-1; i>-1; i-- ){ 
				if( image_list[i] == current_image ){ 
					break; 
				}else{ 
					prev = image_list[i]; 
				} 
			}
			jQuery( event.target ).parent( ).children( 'img' ).attr( 'src', prev );
		}
	);
	jQuery( '#ec_cart_billing_country' ).change( function( ){
		if( ec_is_state_required( jQuery( '#ec_cart_billing_country' ).val( ) ) )
			jQuery( '#ec_billing_state_required' ).show( );
		else
			jQuery( '#ec_billing_state_required' ).hide( );
		
		if( document.getElementById( 'ec_cart_billing_state_' + jQuery( '#ec_cart_billing_country' ).val( ) ) ){
			jQuery( '.ec_billing_state_dropdown, #ec_cart_billing_state' ).hide( );
			jQuery( '#ec_cart_billing_state_' + jQuery( '#ec_cart_billing_country' ).val( ) ).show( );
		}else{
			jQuery( '.ec_billing_state_dropdown' ).hide( );
			jQuery( '#ec_cart_billing_state' ).show( );
		}
	} );
	jQuery( '#ec_cart_shipping_country' ).change( function( ){
		if( ec_is_state_required( jQuery( '#ec_cart_shipping_country' ).val( ) ) )
			jQuery( '#ec_shipping_state_required' ).show( );
		else
			jQuery( '#ec_shipping_state_required' ).hide( );
		
		if( document.getElementById( 'ec_cart_shipping_state_' + jQuery( '#ec_cart_shipping_country' ).val( ) ) ){
			jQuery( '.ec_shipping_state_dropdown, #ec_cart_shipping_state' ).hide( );
			jQuery( '#ec_cart_shipping_state_' + jQuery( '#ec_cart_shipping_country' ).val( ) ).show( );
		}else{
			jQuery( '.ec_shipping_state_dropdown' ).hide( );
			jQuery( '#ec_cart_shipping_state' ).show( );
		}
	} );
	jQuery( '#ec_card_number' ).keydown( function( ){
		ec_show_cc_type( ec_get_card_type( jQuery( '#ec_card_number' ).val( ) ) )
	} );
});

function ec_product_show_quick_view_link( modelnum ){
	jQuery('#ec_product_quickview_container_' + modelnum).fadeIn(100);	
}

function ec_product_hide_quick_view_link( modelnum ){
	jQuery('#ec_product_quickview_container_' + modelnum).fadeOut(100);	
}

function change_product_sort( menu_id, menu_name, submenu_id, submenu_name, subsubmenu_id, subsubmenu_name, manufacturer_id, pricepoint_id, currentpage_selected, perpage, URL, divider ){
	
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
}

function ec_add_to_cart( product_id, model_number, quantity ){
	
	jQuery( "#ec_product_loader_" + model_number ).show( );
	var data = {
		action: 'ec_ajax_add_to_cart',
		product_id: product_id,
		model_number: model_number,
		quantity: quantity
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
		var json_data = JSON.parse( data );
		jQuery( "#ec_product_loader_" + model_number ).hide( );
		jQuery( "#ec_product_added_" + model_number ).show( ).delay( 2500 ).fadeOut( 'slow' );
		jQuery( '.ec_product_added_to_cart' ).fadeIn( 'slow' );
		jQuery( ".ec_cart_items_total" ).html( json_data[0].total_items );
		jQuery( ".ec_cart_price_total" ).html( json_data[0].total_price );
		
		if( json_data[0].total_items == 1 ){
			jQuery( ".ec_menu_cart_singular_text" ).show( );
			jQuery( ".ec_menu_cart_plural_text" ).hide( );
		}else{
			jQuery( ".ec_menu_cart_singular_text" ).hide( );
			jQuery( ".ec_menu_cart_plural_text" ).show( );
		}
		
		if( json_data[0].total_items == 0 ){
			jQuery( ".ec_cart_price_total" ).hide( );
		}else{
			jQuery( ".ec_cart_price_total" ).show( );
		}
		
	} } );
}

function ec_minus_quantity( model_number ){
	var currval = jQuery( '#ec_quantity_' + model_number ).val( );
	currval = Number( currval ) - 1;
	if( currval <= 0 ){
		currval = 1;
	}
	jQuery( '#ec_quantity_' + model_number ).val( currval );
}

function ec_plus_quantity( model_number ){
	var currval = jQuery( '#ec_quantity_' + model_number ).val( );
	currval = Number( currval ) + 1;
	jQuery( '#ec_quantity_' + model_number ).val( currval );
}

function ec_cartitem_delete( cartitem_id, model_number ){
	var data = {
		action: 'ec_ajax_cartitem_delete',
		cartitem_id: cartitem_id,
		quantity: jQuery( '#ec_quantity_' + model_number ).val( )
	}
	
	jQuery( '#ec_cartitem_delete_' + cartitem_id ).hide( );
	jQuery( '#ec_cartitem_deleting_' + cartitem_id ).show( );
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( '#ec_cartitem_row_' + cartitem_id ).remove( );
		ec_update_cart( data, 0, "" );
	} } );
}

function ec_cartitem_update( cartitem_id, model_number ){
	var data = {
		action: 'ec_ajax_cartitem_update',
		cartitem_id: cartitem_id,
		quantity: jQuery( '#ec_quantity_' + model_number ).val( )
	};
	
	jQuery( '#ec_cartitem_updating_' + cartitem_id ).show( );
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ 
		jQuery( '#ec_cartitem_updating_' + cartitem_id ).hide( );
		data_arr = data.split( '***' );
		var updated_quantity = Number( jQuery( '#ec_quantity_' + model_number ).val( ) );
		var returned_quantity = Number( data_arr[2] );
		if( updated_quantity > returned_quantity ){
			//show max quantity error
			jQuery( '#ec_cartitem_max_error_' + cartitem_id ).show( );
			jQuery( '#ec_cartitem_min_error_' + cartitem_id ).hide( );
		}else if( updated_quantity < returned_quantity ){
			// show min quantity error
			jQuery( '#ec_cartitem_max_error_' + cartitem_id ).hide( );
			jQuery( '#ec_cartitem_min_error_' + cartitem_id ).show( );
		}else{
			jQuery( '#ec_cartitem_max_error_' + cartitem_id ).hide( );
			jQuery( '#ec_cartitem_min_error_' + cartitem_id ).hide( );
		}
		ec_update_cart( data, cartitem_id, model_number );
	} } );
}

function ec_apply_coupon( ){
	
	jQuery( '#ec_apply_coupon' ).hide( );
	jQuery( '#ec_applying_coupon' ).show( );
	
	var data = {
		action: 'ec_ajax_redeem_coupon_code',
		couponcode: jQuery( '#ec_coupon_code').val( )
	};
	
	jQuery.ajax( {
		url: ajax_object.ajax_url, 
		type: 'post', 
		data: data, 
		success: function( data ){ 
			jQuery( '#ec_apply_coupon' ).show( );
			jQuery( '#ec_applying_coupon' ).hide( );
			data_arr = data.split( '***' );
			if( data_arr[9] == "valid" ){
				jQuery( '#ec_coupon_error' ).hide( );
				jQuery( '#ec_coupon_success' ).html( data_arr[8] ).show( );
			}else{
				jQuery( '#ec_coupon_success' ).hide( );
				jQuery( '#ec_coupon_error' ).html( data_arr[8] ).show( );
			}
			
			ec_update_cart( data, 0, "" ); 
		} 
	} );
}

function ec_apply_gift_card( ){
	
	jQuery( '#ec_apply_gift_card' ).hide( );
	jQuery( '#ec_applying_gift_card' ).show( );
	
	var data = {
		action: 'ec_ajax_redeem_gift_card',
		giftcard: jQuery( '#ec_gift_card').val( )
	};
	
	jQuery.ajax( {
		url: ajax_object.ajax_url, 
		type: 'post', 
		data: data, 
		success: function( data ){ 
			jQuery( '#ec_apply_gift_card' ).show( );
			jQuery( '#ec_applying_gift_card' ).hide( );
			data_arr = data.split( '***' );
			if( data_arr[9] == "valid" ){
				jQuery( '#ec_gift_card_error' ).hide( );
				jQuery( '#ec_gift_card_success' ).html( data_arr[8] ).show( );
			}else{
				jQuery( '#ec_gift_card_success' ).hide( );
				jQuery( '#ec_gift_card_error' ).html( data_arr[8] ).show( );
			}
			
			ec_update_cart( data, 0, "" ); 
		} 
	} );
}

function ec_estimate_shipping( ){
	
	jQuery( '#ec_estimate_shipping' ).hide( );
	jQuery( '#ec_estimating_shipping' ).show( );
	
	var data = {
		action: 'ec_ajax_estimate_shipping',
		zipcode: jQuery( '#ec_estimate_zip' ).val( ),
		country: jQuery( '#ec_estimate_country' ).val( )
	};
	
	jQuery.ajax({
		url: ajax_object.ajax_url, 
		type: 'post', 
		data: data, 
		success: function( data ){ 
			jQuery( '#ec_estimate_shipping' ).show( );
			jQuery( '#ec_estimating_shipping' ).hide( );
			data_arr = data.split( '***' );
			jQuery( '#ec_cart_shipping' ).html( data_arr[0] );
			jQuery( '#ec_cart_total' ).html( data_arr[1] );
		} 
	} );
}

function ec_update_cart( data, cartitem_id, model_number ){
	
	data_arr = data.split( '***' );
	if( cartitem_id != 0 ){
		if( data_arr[2] == 0 ){
			ec_reload_cart( );
		}else{
			jQuery( '#ec_cartitem_price_' + cartitem_id ).html( data_arr[0] );
			jQuery( '#ec_cartitem_total_' + cartitem_id ).html( data_arr[1] );
			jQuery( '#ec_quantity_' + model_number ).val( data_arr[2] );
			jQuery( '#ec_cart_subtotal' ).html( data_arr[3] );
			jQuery( '#ec_cart_tax' ).html( data_arr[4] );
			jQuery( '#ec_cart_shipping' ).html( data_arr[5] );
			jQuery( '#ec_cart_duty' ).html( data_arr[6] );
			jQuery( '#ec_cart_vat' ).html( data_arr[7] );
			jQuery( '#ec_cart_discount' ).html( data_arr[8] );
			jQuery( '#ec_cart_total' ).html( data_arr[9] );
		}
		
	}else{
		if( data_arr[0] == 0 ){
			ec_reload_cart( );
		}else{
			jQuery( '#ec_cart_subtotal' ).html( data_arr[1] );
			jQuery( '#ec_cart_tax' ).html( data_arr[2] );
			jQuery( '#ec_cart_shipping' ).html( data_arr[3] );
			jQuery( '#ec_cart_discount' ).html( data_arr[4] );
			jQuery( '#ec_cart_duty' ).html( data_arr[5] );
			jQuery( '#ec_cart_vat' ).html( data_arr[6] );
			jQuery( '#ec_cart_total' ).html( data_arr[7] );
		}
	}
}

function ec_reload_cart( ){
	location.reload( );
}

function ec_open_login_click( ){
	jQuery( '#ec_alt_login' ).slideToggle(300);
	
	return false;
}

function ec_update_shipping_view( ){
	if( jQuery( '#ec_shipping_selector' ).is( ':checked' ) ){
		jQuery( '#ec_shipping_form' ).show( );
	}else{
		jQuery( '#ec_shipping_form' ).hide( );
	}
}

function ec_cart_toggle_login( ){
	if( jQuery( '#ec_user_login_form' ).is( ':visible' ) ){
		jQuery( '#ec_user_login_form' ).hide( );
	}else{
		jQuery( '#ec_user_login_form' ).show( );
	}
}

function ec_toggle_create_account( ){
	if( jQuery( '#ec_user_create_form' ).is( ':visible' ) ){
		jQuery( '#ec_user_create_form' ).hide( );
	}else{
		jQuery( '#ec_user_create_form' ).show( );
	}
}

function ec_update_payment_display( ){
	jQuery( '#ec_manual_payment_form, #ec_affirm_form, #ec_third_party_form, #ec_credit_card_form' ).hide( );
	if( jQuery( '#ec_payment_manual' ).is( ':checked' ) ){
		jQuery( '#ec_manual_payment_form' ).show( );
	
	}else if( jQuery( '#ec_payment_affirm' ).is( ':checked' ) ){
		jQuery( '#ec_affirm_form' ).show( );
	
	}else if( jQuery( '#ec_payment_third_party' ).is( ':checked' ) ){
		jQuery( '#ec_third_party_form' ).show( );
	
	}else if( jQuery( '#ec_payment_credit_card' ).is( ':checked' ) ){
		jQuery( '#ec_credit_card_form' ).show( );
	}
}

function ec_show_cc_type( type ){
	
	if( jQuery( '#ec_card_visa' ) ){
		if( type == "visa" || type == "all" ){
			jQuery( '#ec_card_visa' ).show( );
			jQuery( '#ec_card_visa_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_visa' ).hide( );
			jQuery( '#ec_card_visa_inactive' ).show( );
		}
	}
	
	if( jQuery( '#ec_card_discover' ) ){
		if( type == "discover" || type == "all" ){
			jQuery( '#ec_card_discover' ).show( );
			jQuery( '#ec_card_discover_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_discover' ).hide( );
			jQuery( '#ec_card_discover_inactive' ).show( );
		}
	}
	
	if( jQuery( '#ec_card_mastercard' ) ){
		if( type == "mastercard" || type == "all" ){
			jQuery( '#ec_card_mastercard' ).show( );
			jQuery( '#ec_card_mastercard_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_mastercard' ).hide( );
			jQuery( '#ec_card_mastercard_inactive' ).show( );
		}
	}
	
	if( jQuery( '#ec_card_amex' ) ){
		if( type == "amex" || type == "all" ){
			jQuery( '#ec_card_amex' ).show( );
			jQuery( '#ec_card_amex_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_amex' ).hide( );
			jQuery( '#ec_card_amex_inactive' ).show( );
		}
	}
	
	if( jQuery( '#ec_card_jcb' ) ){
		if( type == "jcb" || type == "all" ){
			jQuery( '#ec_card_jcb' ).show( );
			jQuery( '#ec_card_jcb_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_jcb' ).hide( );
			jQuery( '#ec_card_jcb_inactive' ).show( );
		}
	}
	
	if( jQuery( '#ec_card_diners' ) ){
		if( type == "diners" || type == "all" ){
			jQuery( '#ec_card_diners' ).show( );
			jQuery( '#ec_card_diners_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_diners' ).hide( );
			jQuery( '#ec_card_diners_inactive' ).show( );
		}
	}
	
	if( jQuery( '#ec_card_laser' ) ){
		if( type == "laser" || type == "all" ){
			jQuery( '#ec_card_laser' ).show( );
			jQuery( '#ec_card_laser_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_laser' ).hide( );
			jQuery( '#ec_card_laser_inactive' ).show( );
		}
	}
	
	if( jQuery( '#ec_card_maestro' ) ){
		if( type == "maestro" || type == "all" ){
			jQuery( '#ec_card_maestro' ).show( );
			jQuery( '#ec_card_maestro_inactive' ).hide( );
		}else{
			jQuery( '#ec_card_maestro' ).hide( );
			jQuery( '#ec_card_maestro_inactive' ).show( );
		}
	}
	
}

function ec_validate_cart_details( ){
	
	login_complete = true;
	billing_complete = ec_validate_address_block( 'billing' );
	shipping_complete = true;
	email_complete = true;
	create_account_complete = true;
	
	if( jQuery( '#ec_login_selector' ).is( ':checked' ) )
		login_complete = ec_validate_cart_login( );
	
	if( jQuery( '#ec_shipping_selector' ).is( ':checked' ) )
		shipping_complete = ec_validate_address_block( 'shipping' );
	
	if( jQuery( '#ec_contact_email' ).length )
		email_complete = ec_validate_email_block( );
	
	if( jQuery( '#ec_create_account_selector' ).is( ':checked' ) )
		create_account_complete = ec_validate_create_account( );
		
	if( login_complete && billing_complete && shipping_complete && email_complete && create_account_complete ){
		ec_hide_cart_error( 'ec_checkout' );
		return true;
	}else{
		ec_show_cart_error( 'ec_checkout' );
		return false;
	}
	
}

function ec_validate_submit_order( ){
	
	var payment_method_complete = ec_validate_payment_method( );
	var terms_complete = ec_validate_terms( );
	
	if( payment_method_complete && terms_complete ){
		jQuery( '#ec_cart_submit_order' ).hide( );
		jQuery( '#ec_cart_submit_order_working' ).show( );
		ec_hide_cart_error( 'ec_submit_order' );
		return true;
	}else{
		jQuery( '#ec_cart_submit_order' ).show( );
		jQuery( '#ec_cart_submit_order_working' ).hide( );
		ec_show_cart_error( 'ec_submit_order' );
		return false;
	}
	
}

function ec_validate_submit_subscription( ){
	
	var login_complete = true;
	var billing_complete = ec_validate_address_block( 'billing' );
	var shipping_complete = true;
	var email_complete = true;
	var create_account_complete = true;
	var payment_method_complete = ec_validate_payment_method( );
	var terms_complete = ec_validate_terms( );
	
	if( jQuery( '#ec_login_selector' ).is( ':checked' ) )
		login_complete = ec_validate_cart_login( );
	
	if( jQuery( '#ec_shipping_selector' ).is( ':checked' ) )
		shipping_complete = ec_validate_address_block( 'shipping' );
		
	if( jQuery( '#ec_contact_email' ).length )
		email_complete = ec_validate_email_block( );
	
	if( jQuery( '#ec_create_account_selector' ).is( ':checked' ) )
		create_account_complete = ec_validate_create_account( );
		
	if( login_complete && billing_complete && shipping_complete && email_complete && create_account_complete && payment_method_complete && terms_complete ){
		ec_hide_cart_error( 'ec_checkout' );
		return true;
	}else{
		ec_show_cart_error( 'ec_checkout' );
		return false;
	}
	
}

function ec_validate_cart_login( ){
	
	var errors = false;
	var email = jQuery( '#ec_cart_login_email' ).val( );
	var password = jQuery( '#ec_cart_login_password' ).val( );
	
	if( !ec_validate_email( email ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_login_email' );
	}else{
		ec_hide_cart_error( 'ec_cart_login_email' );
	}
	
	if( !ec_validate_text( password ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_login_password' );
	}else{
		ec_hide_cart_error( 'ec_cart_login_password' );
	}
	
	return ( !errors );
	
}

function ec_validate_address_block( prefix ){
	
	var errors = false;
	var country = jQuery( '#ec_cart_' + prefix + '_country' ).val( );
	var first_name = jQuery( '#ec_cart_' + prefix + '_first_name' ).val( );
	var last_name = jQuery( '#ec_cart_' + prefix + '_last_name' ).val( );
	var city = jQuery( '#ec_cart_' + prefix + '_city' ).val( );
	var address = jQuery( '#ec_cart_' + prefix + '_address' ).val( );
	if( jQuery( '#ec_cart_' + prefix + '_state_' + country ) )
		var state = jQuery( '#ec_cart_' + prefix + '_state_' + country ).val( );
	else
		var state = jQuery( '#ec_cart_' + prefix + '_state' ).val( );
	var zip = jQuery( '#ec_cart_' + prefix + '_zip' ).val( );
	var phone = jQuery( '#ec_cart_' + prefix + '_phone' ).val( );
	
	if( !ec_validate_select( country ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_' + prefix + '_country' );
	}else{
		ec_hide_cart_error( 'ec_cart_' + prefix + '_country' );
	}
	
	if( !ec_validate_text( first_name ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_' + prefix + '_first_name' );
	}else{
		ec_hide_cart_error( 'ec_cart_' + prefix + '_first_name' );
	}
	
	if( !ec_validate_text( last_name ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_' + prefix + '_last_name' );
	}else{
		ec_hide_cart_error( 'ec_cart_' + prefix + '_last_name' );
	}
	
	if( !ec_validate_text( city ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_' + prefix + '_city' );
	}else{
		ec_hide_cart_error( 'ec_cart_' + prefix + '_city' );
	}
	
	if( !ec_validate_text( address ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_' + prefix + '_address' );
	}else{
		ec_hide_cart_error( 'ec_cart_' + prefix + '_address' );
	}
	
	if( jQuery( '#ec_cart_' + prefix + '_state_' + country ) ){
		if( !ec_validate_select( state ) ){
			errors = true;
			ec_show_cart_error( 'ec_cart_' + prefix + '_state' );
		}else{
			ec_hide_cart_error( 'ec_cart_' + prefix + '_state' );
		}
	}else{
		if( ec_is_state_required( country ) && !ec_validate_text( state ) ){
			errors = true;
			ec_show_cart_error( 'ec_cart_' + prefix + '_state' );
		}else{
			ec_hide_cart_error( 'ec_cart_' + prefix + '_state' );
		}
	}
	
	if( !ec_validate_text( zip ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_' + prefix + '_zip' );
	}else{
		ec_hide_cart_error( 'ec_cart_' + prefix + '_zip' );
	}
	
	if( jQuery( '#ec_cart_' + prefix + '_phone' ).length && !ec_validate_text( phone ) ){
		errors = true;
		ec_show_cart_error( 'ec_cart_' + prefix + '_phone' );
	}else{
		ec_hide_cart_error( 'ec_cart_' + prefix + '_phone' );
	}
	
	return ( !errors );
	
}

function ec_validate_email_block( ){
	
	var errors = false;
	var email = jQuery( '#ec_contact_email' ).val( );
	var retype_email = jQuery( '#ec_contact_email_retype' ).val( );
	
	if( !ec_validate_email( email ) ){
		errors = true;
		ec_show_cart_error( 'ec_contact_email' );
	}else{
		ec_hide_cart_error( 'ec_contact_email' );
	}
	
	if( !ec_validate_match( email, retype_email) ){
		errors = true;
		ec_show_cart_error( 'ec_contact_email_retype' );
	}else{
		ec_hide_cart_error( 'ec_contact_email_retype' );
	}
	
	return ( !errors );
	
}

function ec_validate_create_account( ){
	
	var errors = false;
	var first_name = jQuery( '#ec_contact_first_name' ).val( );
	var last_name = jQuery( '#ec_contact_last_name' ).val( );
	var password = jQuery( '#ec_contact_password' ).val( );
	var retype_password = jQuery( '#ec_contact_password_retype' ).val( );
	
	if( jQuery( '#ec_contact_first_name' ).length && !ec_validate_text( first_name ) ){
		errors = true;
		ec_show_cart_error( 'ec_contact_first_name' );
	}else{
		ec_hide_cart_error( 'ec_contact_first_name' );
	}
	
	if( jQuery( '#ec_contact_last_name' ).length && !ec_validate_text( last_name ) ){
		errors = true;
		ec_show_cart_error( 'ec_contact_last_name' );
	}else{
		ec_hide_cart_error( 'ec_contact_last_name' );
	}
	
	if( !ec_validate_password( password ) ){
		errors = true;
		ec_show_cart_error( 'ec_contact_password' );
	}else{
		ec_hide_cart_error( 'ec_contact_password' );
	}
	
	if( !ec_validate_match( password, retype_password ) ){
		errors = true;
		ec_show_cart_error( 'ec_contact_password_retype' );
	}else{
		ec_hide_cart_error( 'ec_contact_password_retype' );
	}
	
	return ( !errors );
	
}

function ec_validate_payment_method( ){
	
	var errors = false;
	var payment_method = "credit_card";
	if( jQuery( 'input:radio[name=ec_cart_payment_selection]:checked' ).length )
		payment_method = jQuery( 'input:radio[name=ec_cart_payment_selection]:checked' ).val( );
	
	var card_number = jQuery( '#ec_card_number' ).val( );
	var security_code = jQuery( '#ec_security_code' ).val( );
	var exp_month = jQuery( '#ec_expiration_month' ).val( );
	var exp_year = jQuery( '#ec_expiration_year' ).val( );
	
	if( payment_method == "affirm" ){
		ec_checkout_with_affirm( );
		ec_hide_cart_error( 'ec_submit_order' );
		return false;
		
	}else if( payment_method == "credit_card" ){
		
		if( !ec_validate_credit_card( card_number ) ){
			errors = true;
			ec_show_cart_error( 'ec_card_number' );
		}else{
			ec_hide_cart_error( 'ec_card_number' );
		}
		
		if( !ec_validate_security_code( security_code ) ){
			errors = true;
			ec_show_cart_error( 'ec_security_code' );
		}else{
			ec_hide_cart_error( 'ec_security_code' );
		}
		
		if( !ec_validate_select( exp_month ) || !ec_validate_select( exp_year )  ){
			errors = true;
			ec_show_cart_error( 'ec_expiration_date' );
		}else{
			ec_hide_cart_error( 'ec_expiration_date' );
		}
		
	}
	
	return ( !errors );
	
}

function ec_validate_terms( ){
	
	var errors = false;
	
	if( jQuery( '#ec_terms_agree' ).is( ':checked' ) || jQuery( '#ec_terms_agree' ).val( ) == '2' ){
		ec_hide_cart_error( 'ec_terms' );
	}else{
		errors = true;
		ec_show_cart_error( 'ec_terms' );
	}
	
	return ( !errors );
	
}

function ec_validate_email( email ){
	
	return /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/.test( email );

}

function ec_validate_password( pw ){
	
	if( pw && pw.length > 5 )
		return true;
	else
		return false;
	
}

function ec_validate_text( str ){
	
	if( str && str.length > 0 )
		return true;
	else
		return false;
	
}

function ec_validate_select( val ){
	
	if( val && val != 0 )
		return true;
	else
		return false;
	
}

function ec_validate_match( val1, val2 ){
	
	if( val1 == val2 )
		return true;
	else
		return false;
	
}

function ec_is_state_required( country ){
	if( country == "AU" || country == "BR" || country == "CA" || country == "CN" || country == "GB" || country == "IN" || country == "JP" || country == "US" )
		return true;
	else
		return false; 
}

function ec_get_card_type( card_number ){
	
	var num = card_number;
	
	num = num.replace(/[^\d]/g,'');
	
	if( num.match( /^5[1-5]\d{14}$/ ) )														return "mastercard";
	else if( num.match( /^4\d{15}/ ) || num.match( /^4\d{12}/ ) )							return "visa";
	else if( num.match( /(^3[47])((\d{11}$)|(\d{13}$))/ ) )									return "amex";
	else if( num.match( /(^3[47])((\d{11}$)|(\d{13}$))/ ) )									return "discover";
	else if( num.match( /^(?:5[0678]\d\d|6304|6390|67\d\d)\d{8,15}$/ ) )					return "maestro";
	else if( num.match( /(^(352)[8-9](\d{11}$|\d{12}$))|(^(35)[3-8](\d{12}$|\d{13}$))/ ) )	return "jcb";
	else if( num.match( /(^(30)[0-5]\d{11}$)|(^(36)\d{12}$)|(^(38[0-8])\d{11}$)/ ) )		return "diners";
	else																					return "all";
		
}

function ec_validate_credit_card( card_number ){
	
	var card_type = ec_get_card_type( card_number );
	
	if( card_type == "visa" || card_type == "delta" || card_type == "uke" ){
		if( /^4[0-9]{12}(?:[0-9]{3}|[0-9]{6})?$/.test( card_number ) )								return true;
		else 																						return false;
	
	}else if( card_type == "discover" ){
		if( /^6(?:011|5[0-9]{2})[0-9]{12}$/.test( card_number ) )									return true;
		else																						return false;
	
	}else if( card_type == "mastercard" || card_type == "mcdebit" ){
		if( /^5[1-5]\d{14}$/.test( card_number ) )													return true;
		else																						return false;
	
	}else if( card_type == "amex" ){
		if( /^3[47][0-9]{13}$/.test( card_number ) )												return true;
		else																						return false;
	
	}else if( card_type == "diners" ){
		if( /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/.test( card_number ) )								return true;
		else																						return false;
	
	}else if( card_type == "jcb" ){
		if( /^1800\d{11}$|^3\d{15}$/.test( card_number ) )											return true;
		else																						return false;
	
	}else if( card_type == "maestro" ){
		if( /(^(5[0678]\d{11,18}$))|(^(6[^0357])\d{11,18}$)|(^(3)\d{13,20}$)/.test( card_number ) )	return true;
		else																						return false;	
	}
}

function ec_validate_security_code( security_code ){
	
	if( /^[0-9]{3,4}$/.test( security_code ) )													return true;
	else																						return false;

}

function ec_show_cart_error( error_field ){
	jQuery( '#' + error_field + '_error' ).show( );
}

function ec_hide_cart_error( error_field ){
	jQuery( '#' + error_field + '_error' ).hide( );
}

function ec_cart_shipping_method_change( ){
	
}