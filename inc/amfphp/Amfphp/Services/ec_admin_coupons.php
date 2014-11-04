<?php
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, LLC
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, LLC's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

class ec_admin_coupons{		
	
	private $db;
	
	function ec_admin_coupons( ){
		
		global $wpdb;
		$this->db = $wpdb;

	}//ec_admin_coupons
	
	public function _getMethodRoles( $methodName ){
	
	   		if( $methodName == 'getcoupons' ) 		return array( 'admin' );
	   else if( $methodName == 'deletecoupon' ) 	return array( 'admin' );
	   else if( $methodName == 'updatecoupon' ) 	return array( 'admin' );
	   else if( $methodName == 'addcoupon' ) 		return array( 'admin' );
	   else 										return null;
	
	}//_getMethodRoles
	
	function getcoupons( $startrecord, $limit, $orderby, $ordertype, $filter ){
		
		$sql = "SELECT SQL_CALC_FOUND_ROWS ec_promocode.* FROM ec_promocode  WHERE ec_promocode.promocode_id != '' " . $filter . " ORDER BY " . $orderby . " " . $ordertype . " LIMIT " . $startrecord . ", " . $limit;
		$results = $this->db->get_results( $sql );
		
		$totalquery = $this->db->get_var( "SELECT FOUND_ROWS()" );
		
		if( count( $results ) > 0 ){
			$results[0]->totalrows = $totalquery;
			return $results;
		}else{
			return array( "noresults" );
		}
		
	}//getcoupons
	
	function deletecoupon( $promocodesid ){

		$sql = "DELETE FROM ec_promocode WHERE ec_promocode.promocode_id  = %s";
		$rows_affected = $this->db->query( $this->db->prepare( $sql, $promocodesid ) );

		if( $rows_affected ){
			if( get_option( 'ec_option_payment_process_method' ) == 'stripe' ){
				$stripe = new ec_stripe( );
				$stripe->delete_coupon( $promocodesid );
			}
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//deletecoupon
	
	function updatecoupon( $promocode_id, $promocode ){
		
		$promocode = (array)$promocode;
		
		$sql = "UPDATE ec_promocode SET 
					ec_promocode.promo_dollar = %s, 
					ec_promocode.is_dollar_based = %s, 
					ec_promocode.promo_percentage = %s, 
					ec_promocode.is_percentage_based = %s, 
					ec_promocode.promo_shipping = %s, 
					ec_promocode.is_shipping_based = %s, 
					ec_promocode.promo_free_item = %s, 
					ec_promocode.is_free_item_based = %s, 
					ec_promocode.message = %s, 
					ec_promocode.manufacturer_id = %d, 
					ec_promocode.product_id = %d, 
					ec_promocode.by_manufacturer_id = %s, 
					ec_promocode.by_product_id = %s, 
					ec_promocode.by_all_products = %s 
					
				WHERE ec_promocode.promocode_id = %s";
				
		$rows_affected = $this->db->query( $this->db->prepare( 	$sql, 
												$promocode['dollaramount'], 
												$promocode['usedollar'], 
												$promocode['percentageamount'], 
												$promocode['usepercentage'], 
												$promocode['shippingamount'], 
												$promocode['useshipping'], 
												'0.00', 
												$promocode['usefreeitem'], 
												$promocode['promodescription'], 
												$promocode['manufacturers'], 
												$promocode['products'], 
												$promocode['attachmanufacturer'], 
												$promocode['attachproduct'], 
												$promocode['attachall'],
												$promocode_id ) );
		
		if( $rows_affected ){
			if( get_option( 'ec_option_payment_process_method' ) == 'stripe' ){
				$stripe = new ec_stripe( );
				$stripe->delete_coupon( $promocode_id );
				
				$stripe = new ec_stripe( );
				$coupon = array( "is_amount_off" => $promocode['usedollar'],
								 "promocode_id" => $promocode_id,
								 "duration" => "forever",
								 "amount_off" => $promocode['dollaramount'] * 100,
								 "percent_off" => $promocode['percentageamount'] );
									
				$stripe->insert_coupon( $coupon );
			}
			
			return array( "success" );
		}else{
			$sql = "SELECT * FROM ec_promocode WHERE promocode_id = %s";
			$results = $this->db->get_results( $this->db->prepare( $sql, $promocode_id ) );
			
			if( empty( $results ) ){
				return array( "Unknown error has occurred" );
			}else{
				return array( "duplicate" );
			}
		}
	
	}//updatecoupon
	
	function addcoupon( $promocode ){
		
		$promocode = (array)$promocode;
		
		$sql = "INSERT INTO ec_promocode( ec_promocode.promocode_id, ec_promocode.promo_dollar, ec_promocode.is_dollar_based, ec_promocode.promo_percentage, ec_promocode.is_percentage_based, ec_promocode.promo_shipping, ec_promocode.is_shipping_based, ec_promocode.promo_free_item, ec_promocode.is_free_item_based, ec_promocode.message, ec_promocode.manufacturer_id, ec_promocode.product_id, ec_promocode.by_manufacturer_id, ec_promocode.by_product_id, ec_promocode.by_all_products ) VALUES( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )";
		$rows_affected = $this->db->query( $this->db->prepare( $sql, $promocode['promoid'], $promocode['dollaramount'], $promocode['usedollar'], $promocode['percentageamount'], $promocode['usepercentage'], $promocode['shippingamount'], $promocode['useshipping'], '0.00', $promocode['usefreeitem'], $promocode['promodescription'], $promocode['manufacturers'], $promocode['products'], $promocode['attachmanufacturer'], $promocode['attachproduct'], $promocode['attachall'] ) );
		
		if( $rows_affected ){
			if( get_option( 'ec_option_payment_process_method' ) == 'stripe' ){
				$stripe = new ec_stripe( );
				$coupon = array( "is_amount_off" => $promocode['usedollar'],
								 "promocode_id" => $promocode['promoid'],
								 "duration" => "forever",
								 "amount_off" => $promocode['dollaramount'] * 100,
								 "percent_off" => $promocode['percentageamount'] );
									
				$stripe->insert_coupon( $coupon );
			}
			return array( "success" );
		}else{
			$sql = "SELECT * FROM ec_promocode WHERE promocode_id = %s";
			$results = $this->db->get_results( $this->db->prepare( $sql, $promocode['promoid'] ) );
			
			if( empty( $results ) ){
				return array( "Unknown error has occurred" );
			}else{
				return array( "duplicate" );
			}
		}
	}//addcoupon

}//ec_admin_coupon
?>