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

class ec_admin_orders{		
		
	private $db;
	
	function ec_admin_orders( ){
		
		global $wpdb;
		$this->db = $wpdb;
		
	}//ec_admin_orders
	
	public function _getMethodRoles( $methodName ){
			
			if( $methodName == 'getorders' ) 						return array( 'admin' );
	   else if( $methodName == 'getorderdetailsadvancedoptions' ) 	return array( 'admin' );
	   else if( $methodName == 'getorderdetails' ) 					return array( 'admin' );
	   else if( $methodName == 'getorderstatus' ) 					return array( 'admin' );
	   else if( $methodName == 'updateorderstatus' ) 				return array( 'admin' );
	   else if( $methodName == 'updateorderviewed' ) 				return array( 'admin' );
	   else if( $methodName == 'deleteorder' ) 						return array( 'admin' );
	   else if( $methodName == 'updateshippingstatus' ) 			return array( 'admin' );
	   else if( $methodName == 'updateshippingstatus' ) 			return array( 'admin' );
	   else  														return null;
	   
	}//_getMethodRoles

	function getorderdetailsadvancedoptions( $orderdetails_id ){
		
		  $sql = "SELECT ec_order_option.* FROM ec_order_option WHERE ec_order_option.orderdetail_id = %s";
		  $results = $this->db->get_results( $this->db->prepare( $sql, $orderdetails_id ) );
		  
		  if( count( $results ) > 0 ){
			  return( $results );
		  }else{
			  return array( "noresults" );
		  }
		  
	}//getorderdetailsadvancedoptions
	
	function getorders($startrecord, $limit, $orderby, $ordertype, $filter) {
		  
		  $sql = "SELECT SQL_CALC_FOUND_ROWS ec_order.billing_first_name, ec_order.billing_last_name, ec_order.order_viewed, ec_order.grand_total, UNIX_TIMESTAMP(ec_order.order_date) AS order_date, ec_order.user_email, ec_order.user_id,  ec_order.order_id, ec_order.orderstatus_id, ec_orderstatus.order_status FROM ec_order LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.user_id != -1 " . $filter . " ORDER BY " . $orderby . " " . $ordertype . " LIMIT " . $startrecord . ", " . $limit;
		  $results = $this->db->get_results( $sql );

		  $totalquery = $this->db->get_var( "SELECT FOUND_ROWS( )" );
		  
		  if( count( $results ) > 0 ){
			  $results[0]->totalrows = $totalquery;
			  return( $results ); 
		  }else {
			  return array( "noresults" );
		  }
		  
	}//getorders
	
	function getorderdetails( $orderid ){
		  
		  $sql = "SELECT ec_orderdetail.*, ec_order.*, ec_orderstatus.order_status, UNIX_TIMESTAMP(ec_order.order_date) AS order_date,  ec_download.date_created, ec_download.download_count FROM (((ec_order LEFT JOIN ec_orderdetail ON ec_orderdetail.order_id = ec_order.order_id) LEFT JOIN ec_download ON ec_orderdetail.download_key = ec_download.download_id) LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id) WHERE ec_order.order_id = %d ORDER BY ec_orderdetail.product_id";
		  
		  $results = $this->db->get_results( $this->db->prepare( $sql, $orderid ) );
		  
		  if( count( $results ) > 0 ){
			 return($results);
		  }else{
			  return array( "noresults" );
		  }
		  
	}//getorderdetail
	
	function getorderstatus( ){
		  
		  $sql = "SELECT ec_orderstatus.* FROM ec_orderstatus ORDER BY ec_orderstatus.status_id ASC";
		  $results = $this->db->get_results( $sql );

		  if( count( $results ) > 0 ){
			 return( $results );
		  }else{
			  return array( "noresults" );
		  }
		  
	}//getorderstatus
	
	function updateorderstatus( $orderid, $status ){
		
		$sql = "UPDATE ec_order SET ec_order.orderstatus_id = %s WHERE ec_order.order_id = %d";
		$this->db->query( $this->db->prepare( $sql, $status, $orderid ) );
		
		if( !mysql_error( ) ){
			return array( "success" );
		}else{
			return array( "error" );
		}
	
	}//updateorderstatus
	
	function updateordernotes( $orderid, $notes ){
		
		$sql = "UPDATE ec_order SET ec_order.order_notes = %s WHERE ec_order.order_id = %d";
		$this->db->query( $this->db->prepare( $sql, $notes, $orderid ) );
		
		if( !mysql_error( ) ){
			return array( "success" );	
		}else{
			return array( "error" );
		}
	
	}//updateordernotes
	
	function updateorderviewed( $orderid ){
		
		$sql = "UPDATE ec_order SET order_viewed = 1 WHERE ec_order.order_id = %d";
		$this->db->query( $this->db->prepare( $sql, $orderid ) );
		
		if( !mysql_error( ) ){
			return array( "success" );	
		}else{
			return array( "error" );
		}
		
	}	//updateorderviewed
	
	function deleteorder( $orderid ){
		
		$sql = "DELETE FROM ec_order WHERE ec_order.order_id = %d";
		$this->db->query( $this->db->prepare( $sql, $orderid ) );
		
		$sql = "DELETE FROM ec_detail WHERE ec_orderdetail.order_id = %d";
		$this->db->query( $this->db->prepare( $sql, $orderid ) );
		
		$sql = "DELETE FROM ec_download WHERE ec_download.orderid = %d";
		$this->db->query( $this->db->prepare( $sql, $orderid ) );
		
		if( !mysql_error( ) ){
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//deleteorder
	
	function updateshippingstatus( $orderid, $shipcarrier, $shiptrackingcode, $sendemail, $clientemail ){
		
		$sql = "UPDATE ec_order SET ec_order.shipping_carrier = %s, ec_order.tracking_number = %s WHERE ec_order.order_id = %d";
		$this->db->query( $this->db->prepare( $sql, $shipcarrier, $shiptrackingcode, $orderid ) );
		
		if( $sendemail == 1 ){
			
			$sql = "SELECT ec_order.* FROM ec_order WHERE ec_order.order_id = %d";
			$order = $this->db->get_results( $this->db->prepare( $sql, $orderid ) );
			
			$trackingnumber = $order[0]->tracking_number;
			$shipcarrier = $order[0]->shipping_carrier;
			
			$orderfromemail = get_option( 'ec_option_order_from_email' );
			
			$message = "<html><head><title>Shipping Confirmation - Order Number " . $order_id . "</title><style type='text/css'><!--.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }.style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }--></style></head><body> <table width='539' border='0' align='center'>   <tr><td colspan='4' align='left' class='style22'></td></tr><tr><td colspan='4' align='left' class='style22'><p><br> Dear " . $order[0]->billing_first_name . " " . $order[0]->billing_last_name . ": </p><p>Your recent order  with the number <strong>" . $order[0]->order_id . "</strong> has been shipped! You should be receiving it within a short time period.<br>";
			
			if( $trackingnumber != '0' && $trackingnumber != 'Null' && $trackingnumber != 'NULL'&& $trackingnumber != 'null' && $trackingnumber != NULL && $trackingnumber != '' ){
				$message .= "<br>  You may check the status of your order by visiting your carriers website and using the following tracking number.</p><p>Package Carrier: " . $shipcarrier . "<br>Package Tracking Number: " . $trackingnumber . "</p>";
			}
			
			$message .= "<p><br></p></td></tr><tr><td colspan='4' align='left' class='style20'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td width='47%' bgcolor='#F3F1ED' class='style20'>Billing Address</td><td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'>Shipping Address</td></tr><tr>   <td><span class='style22'>     " . $order[0]->billing_first_name . " " . $order[0]->billing_last_name . "    </span></td>    <td>&nbsp;</td>   <td><span class='style22'>" . $order[0]->shipping_first_name . " " . $order[0]->shipping_last_name . "</span></td> </tr><tr><td><span class='style22'> " . $order[0]->billing_address_line_1 . "<br>" . $order[0]->billing_address_line_2 . "</span></td>   <td>&nbsp;</td><td><span class='style22'>" . $order[0]->shipping_address_line_1 . " <br>
			" . $order[0]->shipping_address_line_2 . " </span></td> </tr><tr><td><span class='style22'>" . $order[0]->billing_city . ", " . $order[0]->billing_state . " " . $order[0]->billing_zip . "</span></td>   <td>&nbsp;</td>   <td><span class='style22'>" . $order[0]->shipping_city . ", " . $order[0]->shipping_state . " " . $order[0]->shipping_zip . "</span></td> </tr><tr><td><span class='style22'>Phone: " . $order[0]->billing_phone . "</span></td><td>&nbsp;</td><td><span class='style22'>Phone: " . $order[0]->shipping_phone . "</span></td> </tr></table></td></tr><tr><td width='269' align='left'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td align='center'>&nbsp;</td></tr><tr><td width='269' align='left' bgcolor='#F3F1ED' class='style20'>Product</td><td width='80' align='center' bgcolor='#F3F1ED' class='style20'>Qty</td><td width='91' align='center' bgcolor='#F3F1ED' class='style20'>Unit Price</td><td align='center' bgcolor='#F3F1ED' class='style20'>Ext Price</td></tr>";
				
			$sql = "SELECT ec_orderdetail.* FROM ec_orderdetail WHERE ec_orderdetail.order_id = %d ORDER BY ec_orderdetail.product_id";
			$orderdetails = $this->db->get_results( $this->db->prepare( $sql, $orderid ) );
			
			foreach( $orderdetails as $row ){
				$finaltotal = number_format( $row->unit_price, 2 );
				$totalitemprice = number_format( $row->total_price , 2 );
				$message .= "<tr><td width='269' class='style22'>" . $row->title . "</td><td width='80' align='center' class='style22'>" . $row->quantity . "</td><td width='91' align='center' class='style22'>" . $finaltotal . "</td><td align='center' class='style22'>" . $totalitemprice . "</td></tr>";				
			}
			
			$message .="<tr><td width='269'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan='4' class='style22'><p><br>Please double check your order when you receive it and let us know immediately if there are any concerns or issues. We always value your business and hope you enjoy your product.<br><br>Thank you very much!<br><br><br></p></td></tr><tr><td colspan='4'><p class='style22'></p></td></tr></table></body></html>";
			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			$headers .= "From: " . get_option( 'ec_option_order_from_email')  . "\r\n";
			$headers .= "Reply-To: " . get_option( 'ec_option_order_from_email' )  . "\r\n";
			$headers .= "X-Mailer: PHP/".phpversion()  . "\r\n";
			
			if( get_option( 'ec_option_use_wp_mail' ) ){
				wp_mail( $order[0]->user_email, 'Order Shipped - Confirmation' , $message, $headers );
			}else{
				mail( $order[0]->user_email, 'Order Shipped - Confirmation' , $message, $headers  );
			}
		}
		
		if( !mysql_error( ) ){
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//updateshippingstatus
	
}//ec_admin_orders
?>