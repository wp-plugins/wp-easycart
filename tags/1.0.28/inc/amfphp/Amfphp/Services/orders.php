<?php
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/


class orders
	{		
	
		function orders() {
			//load our connection settings
			require_once('../../../connection/ec_conn.php');
		
			//set our connection variables
			$dbhost = HOSTNAME;
			$dbname = DATABASE;
			$dbuser = USERNAME;
			$dbpass = PASSWORD;	

			//make a connection to our database
			$this->conn = mysql_pconnect($dbhost, $dbuser, $dbpass);
			mysql_select_db ($dbname);	

		}	
			
		
		//HELPER - used to escape out SQL calls
		function escape($sql) 
		{ 
			  $args = func_get_args(); 
				foreach($args as $key => $val) 
				{ 
					$args[$key] = mysql_real_escape_string($val); 
				} 
				 
				$args[0] = $sql; 
				return call_user_func_array('sprintf', $args); 
		} 
		

		
		//orders functions
		function getorders($startrecord, $limit, $orderby, $ordertype, $filter) {
			  //Create SQL Query
			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS ec_order.billing_first_name, ec_order.billing_last_name, ec_order.order_viewed, ec_order.grand_total, UNIX_TIMESTAMP(ec_order.order_date) AS order_date, ec_order.user_email, ec_order.user_id,  ec_order.order_id, ec_order.orderstatus_id, ec_orderstatus.order_status FROM ec_order LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id WHERE ec_order.user_id != -1 ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");
			  $totalrows = mysql_fetch_object($totalquery);
			  //return $query;
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($query) > 0) {
				  while ($row=mysql_fetch_object($query)) {
					 $row->totalrows=$totalrows;
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some 
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		
		
		function getorderdetails($orderid) {
			  //Create SQL Query
			  $query = $this->escape("SELECT ec_orderdetail.*, ec_order.*, ec_orderstatus.order_status, UNIX_TIMESTAMP(ec_order.order_date) AS order_date,  ec_download.date_created, ec_download.download_count FROM (((ec_order LEFT JOIN ec_orderdetail ON ec_orderdetail.order_id = ec_order.order_id) LEFT JOIN ec_download ON ec_orderdetail.download_key = ec_download.download_id) LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id) WHERE ec_order.order_id = '$orderid' ORDER BY ec_orderdetail.product_id");
			 // return $query;
			  $ordersquery = mysql_query($query);   
			  
			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($ordersquery) > 0) {
				  while ($row = mysql_fetch_object($ordersquery)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		function getorderstatus() {
			  //Create SQL Query
			  $ordersquery = mysql_query("SELECT ec_orderstatus.* FROM ec_orderstatus ORDER BY ec_orderstatus.status_id ASC");

			  //if results, convert to an array for use in flash
			  if(mysql_num_rows($ordersquery) > 0) {
				  while ($row = mysql_fetch_object($ordersquery)) {
					  $returnArray[] = $row;
				  }
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "noresults";
				  return $returnArray; //return noresults if there are no results
			  }
		}
		function updateorderstatus($orderid, $status) {
			  //Create SQL Query
			$sql = $this->escape("UPDATE ec_order SET ec_order.orderstatus_id='%s' WHERE ec_order.order_id = '%s'", $status, $orderid);
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		
		}
		function updateordernotes($orderid, $notes) {
			  //Create SQL Query
			$sql = $this->escape("UPDATE ec_order SET ec_order.order_notes='%s' WHERE ec_order.order_id = '%s'", $notes, $orderid);
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		
		}
		function updateorderviewed($orderid) {
			 //Create SQL Query
			 $sql = sprintf("UPDATE ec_order SET order_viewed = 1 WHERE ec_order.order_id = '%s'",
				mysql_real_escape_string($orderid));
			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		
		function deleteorder($orderid) {
			  //Create SQL Query
			$ordersql = $this->escape("DELETE FROM ec_order WHERE ec_order.order_id = '%s'", $orderid);
			//Run query on database;
			mysql_query($ordersql);
			
			$orderdetailssql = $this->escape("DELETE FROM ec_detail WHERE ec_orderdetail.order_id = '%s'", $orderid);
			//Run query on database;
			mysql_query($orderdetailssql);
			
			$ec_downloadsql = $this->escape("DELETE FROM ec_download WHERE ec_download.orderid = '%s'", $orderid);
			//Run query on database;
			mysql_query($ec_downloadsql);
			
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}
		
		function updateshippingstatus($orderid, $shipcarrier, $shiptrackingcode, $sendemail, $clientemail) {
			  //Create SQL Query
			$sql = $this->escape("UPDATE ec_order SET ec_order.shipping_carrier='%s', ec_order.tracking_number='%s' WHERE ec_order.order_id = '%s'", $shipcarrier, $shiptrackingcode, $orderid);
			//Run query on database;
			mysql_query($sql);
			

			if($sendemail == 1) {
				// retrieve the clients name and email
				$sql = sprintf("SELECT ec_orderdetail.*, ec_order.* FROM (ec_order LEFT JOIN ec_orderdetail ON ec_orderdetail.order_id = ec_order.order_id) WHERE ec_order.order_id='$orderid' ORDER BY ec_orderdetail.product_id");
				$result = mysql_query($sql);
				$row_specific = mysql_query($sql);
				$order = mysql_fetch_assoc($result);


				//get order admin email
				$fromsql = sprintf("SELECT wp_options.option_value FROM  wp_options WHERE  wp_options.option_name = 'admin_email'");
				$fromresult = mysql_query($fromsql);
				$fromrow = mysql_fetch_assoc($fromresult);
				
				//Build the email message with full itemized paging
				$Text = "This email is html, please switch to this view...";


				$message = "--==MIME_BOUNDRY_alt_main_message\n";
				$message .= "Content-Type: text/plain; charset=ISO-8859-1\n";
				$message .= "Content-Transfer-Encoding: 7bit\n\n";
				$message .= $Text . "\n\n";
				$message .= "--==MIME_BOUNDRY_alt_main_message\n";
				$message .= "Content-Type: text/html; charset=ISO-8859-1\n";
				$message .= "Content-Transfer-Encoding: 7bit\n\n";
				
				$trackingnumber = $order[tracking_number];
				$shipcarrier = $order[shipping_carrier];
				$message .= "<html><head><title>..::Shipping Confirmation - Order Number $order_id ::..</title><style type='text/css'><!--.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }.style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }--></style></head><body> <table width='539' border='0' align='center'>   <tr><td colspan='4' align='left' class='style22'></td></tr><tr><td colspan='4' align='left' class='style22'><p><br> Dear $order[billing_first_name]  $order[billing_last_name]: </p><p>Your recent order  with the number <strong>$order[order_id]</strong> has been shipped! You should be receiving it within a short time period.<br>";
				
				if ($trackingnumber != '0' && $trackingnumber != 'Null'&& $trackingnumber != 'NULL'&& $trackingnumber != 'null'&& $trackingnumber != NULL && $trackingnumber != '') {
					$message .= "<br>  You may check the status of your order by visiting your carriers website and using the following tracking number.</p><p>Package Carrier: $shipcarrier<br>Package Tracking Number: $trackingnumber</p>";
				}
				
				$message .= "<p><br></p></td></tr><tr><td colspan='4' align='left' class='style20'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td width='47%' bgcolor='#F3F1ED' class='style20'>Billing Address</td><td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'>Shipping Address</td></tr><tr>   <td><span class='style22'>     $order[billing_first_name]       $order[billing_last_name]    </span></td>    <td>&nbsp;</td>   <td><span class='style22'>$order[shipping_first_name]       $order[shipping_last_name]</span></td> </tr><tr><td><span class='style22'> $order[billing_address_line_1]<br>$order[billing_address_line_2]</span></td>   <td>&nbsp;</td><td><span class='style22'>$order[shipping_address_line_1] <br>
$order[shipping_address_line_2] </span></td> </tr><tr><td><span class='style22'>$order[billing_city]        , $order[billing_state]   &nbsp;  $order[billing_zip]  </span></td>   <td>&nbsp;</td>   <td><span class='style22'>$order[shipping_city]      , $order[shipping_state]       &nbsp; $order[shipping_zip]    </span></td> </tr><tr><td><span class='style22'>Phone:    $order[billing_phone]  </span></td><td>&nbsp;</td><td><span class='style22'>Phone:      $order[shipping_phone]    </span></td> </tr></table></td></tr><tr><td width='269' align='left'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td align='center'>&nbsp;</td></tr><tr><td width='269' align='left' bgcolor='#F3F1ED' class='style20'>Product</td><td width='80' align='center' bgcolor='#F3F1ED' class='style20'>Qty</td><td width='91' align='center' bgcolor='#F3F1ED' class='style20'>Unit Price</td><td align='center' bgcolor='#F3F1ED' class='style20'>Ext Price</td></tr>";
					while($row = mysql_fetch_array($row_specific)) 
					{
						$finaltotal = number_format($row[unit_price], 2);
						$totalitemprice = number_format($row[total_price], 2);
						$message .= "<tr><td width='269' class='style22'>$row[title]</td><td width='80' align='center' class='style22'>$row[quantity]</td><td width='91' align='center' class='style22'>$finaltotal </td><td align='center' class='style22'>$totalitemprice</td></tr> ";				
					}
				
				$message .="<tr><td width='269'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan='4' class='style22'><p><br>Please double check your order when you receive it and let us know immediately if there are any concerns or issues. We always value your business and hope you enjoy your product.<br><br>Thank you very much!<br><br><br></p></td></tr><tr><td colspan='4'><p class='style22'></p></td></tr></table></body></html>";
				
				//set from email address
				$orderfromemail = $fromrow[option_value];
				//headers
				$headers = "From: $orderfromemail\r\n";
				$headers .= "Reply-To: $orderfromemail\r\n";
				$headers .= "X-Mailer: PHP4\n";
				$headers .= "X-Priority: 3\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Return-Path: $orderfromemail\r\n"; 
				$headers .= "Content-Type: multipart/alternative; boundary=\"==MIME_BOUNDRY_alt_main_message\"\n\n";
			
				//mail individual gift card message
				mail($order[user_email], 'Order Shipped - Confirmation', $message, $headers);
			  }//close if this is an emailer
							  
			  //if no errors, return their current Client ID
			  //if results, convert to an array for use in flash
			  if(!mysql_error()) {
				  $returnArray[] ="success";
				  return($returnArray); //return array results if there are some
			  } else {
				  $returnArray[] = "error";
				  return $returnArray; //return noresults if there are no results
			  }
		}


	}//close class
?>