// Base Theme - EC Cart Item Javascript Document

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
	
	document.getElementById('ec_cartitem_total_' + cartitem_id).innerHTML = Number( Number( document.getElementById( 'ec_cartitem_unit_price_' + cartitem_id ).innerHTML.substring(1) ) * Number( document.getElementById( 'ec_cartitem_quantity_' + cartitem_id ).value ) ).toFixed(2);
	
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
	
		jQuery('#ec_cart_item_' + cartitem_id ).remove(); 
	
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
}