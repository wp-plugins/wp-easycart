// Base Theme - EC Cart Javascript Document

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
}