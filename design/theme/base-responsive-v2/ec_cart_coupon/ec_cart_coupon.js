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
