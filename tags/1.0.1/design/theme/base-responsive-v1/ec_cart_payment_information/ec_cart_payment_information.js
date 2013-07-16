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
	

}