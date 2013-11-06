<?php

class ec_db_admin extends ec_db{
	
	public function add_taxrate( $tax_by_state, $tax_by_country, $tax_by_duty, $tax_by_vat, $tax_by_all, $state_rate, $country_rate, $duty_rate, $vat_rate, $all_rate, $state_code, $country_code, $vat_country_code, $duty_exempt_country_code ){
		$sql = "INSERT INTO ec_taxrate(tax_by_state, tax_by_country, tax_by_duty, tax_by_vat, tax_by_all, state_rate, country_rate, duty_rate, vat_rate, all_rate, state_code, country_code,vat_country_code, duty_exempt_country_code) VALUES( %d, %d, %d, %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s)";
		
		$this->mysqli->query( $this->mysqli->prepare( $sql, $tax_by_state, $tax_by_country, $tax_by_duty, $tax_by_vat, $tax_by_all, $state_rate, $country_rate, $duty_rate, $vat_rate, $all_rate, $state_code, $country_code, $vat_country_code, $duty_exempt_country_code ) );
	}
	
	public function update_taxrate( $taxrate_id, $tax_by_state, $tax_by_country, $tax_by_duty, $tax_by_vat, $tax_by_all, $state_rate, $country_rate, $duty_rate, $vat_rate, $all_rate, $state_code, $country_code, $vat_country_code, $duty_exempt_country_code ){
		$sql = "UPDATE ec_taxrate SET tax_by_state=%d, tax_by_country=%d, tax_by_duty=%d, tax_by_vat=%d, tax_by_all=%d, state_rate=%s, country_rate=%s, duty_rate=%s, vat_rate=%s, all_rate=%s, state_code=%s, country_code=%s, vat_country_code=%s, duty_exempt_country_code=%s WHERE taxrate_id=%d";
		
		$this->mysqli->query( $this->mysqli->prepare( $sql, $tax_by_state, $tax_by_country, $tax_by_duty, $tax_by_vat, $tax_by_all, $state_rate, $country_rate, $duty_rate, $vat_rate, $all_rate, $state_code, $country_code, $vat_country_code, $duty_exempt_country_code, $taxrate_id ) );
	}
	
	public function delete_taxrate( $taxrate_id ){
		$sql = "DELETE FROM ec_taxrate WHERE taxrate_id = %d";
		
		$this->mysqli->query( $this->mysqli->prepare( $sql, $taxrate_id ) );
	}
	
	public function update_country( $iso2_cnt, $rate ){
		$sql = "UPDATE ec_country SET vat_rate_cnt = %s WHERE iso2_cnt = %s";
		$this->mysqli->query( $this->mysqli->prepare( $sql, $rate, $iso2_cnt ) );
	}
	
	public function add_shippingrate( $is_price_based, $is_weight_based, $is_method_based, $is_ups_based, $is_usps_based, $is_fedex_based, $trigger_rate, $shipping_rate, $shipping_label, $shipping_order, $shipping_code, $shipping_override_rate ){
		$sql = "INSERT INTO ec_shippingrate( is_price_based, is_weight_based, is_method_based, is_ups_based, is_usps_based, is_fedex_based, trigger_rate, shipping_rate, shipping_label, shipping_order, shipping_code, shipping_override_rate) VALUES( %d, %d, %d, %d, %d, %d, %s, %s, %s, %d, %s, %s)";
		$this->mysqli->query( $this->mysqli->prepare( $sql, $is_price_based, $is_weight_based, $is_method_based, $is_ups_based, $is_usps_based, $is_fedex_based, $trigger_rate, $shipping_rate, $shipping_label, $shipping_order, $shipping_code, $shipping_override_rate ) );
	}
	
	public function update_shippingrate( $shippingrate_id, $is_price_based, $is_weight_based, $is_method_based, $is_ups_based, $is_usps_based, $is_fedex_based, $trigger_rate, $shipping_rate, $shipping_label, $shipping_order, $shipping_code, $shipping_override_rate ){
		$sql = "UPDATE ec_shippingrate SET is_price_based=%d, is_weight_based=%d, is_method_based=%d, is_ups_based=%d, is_usps_based=%d, is_fedex_based=%d, trigger_rate=%s, shipping_rate=%s, shipping_label=%s, shipping_order=%d, shipping_code=%s, shipping_override_rate=%s WHERE shippingrate_id=%d";
		$this->mysqli->query( $this->mysqli->prepare( $sql, $is_price_based, $is_weight_based, $is_method_based, $is_ups_based, $is_usps_based, $is_fedex_based, $trigger_rate, $shipping_rate, $shipping_label, $shipping_order, $shipping_code, $shipping_override_rate, $shippingrate_id ) );
	}
	
	public function delete_shippingrate( $shippingrate_id ){
		$sql = "DELETE FROM ec_shippingrate WHERE shippingrate_id=%d";
		$this->mysqli->query( $this->mysqli->prepare( $sql, $shippingrate_id ) );
	}
	
	public function update_setting( $option_name, $option_value ){
		$sql = "UPDATE ec_setting SET " . mysql_real_escape_string( $option_name ) . "=%s WHERE setting_id = 1";
		$this->mysqli->query( $this->mysqli->prepare( $sql, $option_value ) );
	}
	
	public function get_user( $user_id ){
		$sql = "SELECT ec_user.user_id, ec_user.password, ec_user.email, ec_user.first_name, ec_user.last_name, ec_user.user_level, billing.first_name AS billing_first_name, billing.last_name AS billing_last_name, billing.address_line_1 AS billing_address_line_1, billing.city AS billing_city, billing.state AS billing_state, billing.zip AS billing_zip, billing.country AS billing_country, billing.phone AS billing_phone, shipping.first_name AS shipping_first_name, shipping.last_name AS shipping_last_name, shipping.address_line_1 AS shipping_address_line_1, shipping.city AS shipping_city, shipping.state AS shipping_state, shipping.zip AS shipping_zip, shipping.country AS shipping_country, shipping.phone AS shipping_phone FROM ec_user LEFT JOIN ec_address as billing ON (ec_user.default_billing_address_id = billing.address_id) LEFT JOIN ec_address as shipping ON (ec_user.default_shipping_address_id = shipping.address_id) WHERE ec_user.user_id = %d";
		return $this->mysqli->get_row( $this->mysqli->prepare( $sql, $user_id ) );
	}
	
	public function get_users( ){
		$sql = "SELECT ec_user.user_id, ec_user.password, ec_user.email, ec_user.first_name, ec_user.last_name, ec_user.user_level, billing.first_name AS billing_first_name, billing.last_name AS billing_last_name, billing.address_line_1 AS billing_address_line_1, billing.city AS billing_city, billing.state AS billing_state, billing.zip AS billing_zip, billing.country AS billing_country, billing.phone AS billing_phone, shipping.first_name AS shipping_first_name, shipping.last_name AS shipping_last_name, shipping.address_line_1 AS shipping_address_line_1, shipping.city AS shipping_city, shipping.state AS shipping_state, shipping.zip AS shipping_zip, shipping.country AS shipping_country, shipping.phone AS shipping_phone FROM ec_user LEFT JOIN ec_address as billing ON (ec_user.default_billing_address_id = billing.address_id) LEFT JOIN ec_address as shipping ON (ec_user.default_shipping_address_id = shipping.address_id)";
		return $this->mysqli->get_results( $sql );
	}
}

?>