// Base Theme - EC Cart Shipping Method Javascript Document
function ec_cart_shipping_method_change( shipping_method, shipping_price ){
	
	var data = {
		action: 'ec_ajax_update_shipping_method',
		shipping_method: shipping_method
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ ec_cart_shipping_method_change_finished( data ); } } );
	
}


function ec_cart_shipping_method_change_finished( data ){
	// do nothing.
}
