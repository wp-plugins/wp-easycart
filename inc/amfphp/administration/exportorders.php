<?php 
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, llc
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licensed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, llc's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

//load our connection settings
ob_start( NULL, 4096 );
require_once( '../../../../../../wp-load.php' );
global $wpdb;

$requestID = "-1";
if( isset( $_GET['reqID'] ) )
	$requestID = $_GET['reqID'];
	
if( isset( $_GET['startdate'] ) ){
 	$startdate = $_GET['startdate'];
	$startdate = new DateTime( $startdate );
}

if( isset( $_GET['enddate'] ) ){
 	$enddate = $_GET['enddate'];
	$enddate = new DateTime( $enddate );
}

if( isset( $_GET['format'] ) )
	$format = $_GET['format'];

if( isset( $_GET['alldata'] ) )
	$alldata = $_GET['alldata'];

$user_sql = "SELECT  ec_user.*, ec_role.admin_access FROM ec_user LEFT JOIN ec_role ON (ec_user.user_level = ec_role.role_label) WHERE ec_user.password = %s AND  (ec_user.user_level = 'admin' OR ec_role.admin_access = 1)";
$users = $wpdb->get_results( $wpdb->prepare( $user_sql, $requestID ) );

if( !empty( $users ) ){
	
	if( $format == 'excel' ){

		$header = "";
		$data = "";
		
		if( $alldata == 'true' ){
			$sql = "SELECT ec_orderdetail.*, ec_order.*, billing_country.name_cnt as billing_country_name, shipping_country.name_cnt as shipping_country_name, ec_orderstatus.order_status FROM ec_order LEFT OUTER JOIN ec_orderdetail ON (ec_order.order_id = ec_orderdetail.order_id) LEFT JOIN ec_country as billing_country ON billing_country.iso2_cnt = ec_order.billing_country LEFT JOIN ec_country as shipping_country ON shipping_country.iso2_cnt = ec_order.shipping_country LEFT JOIN ec_orderstatus ON ec_orderstatus.status_id = ec_order.orderstatus_id ORDER BY ec_order.order_id ASC";	
		
		}else{
			$sql = "SELECT ec_orderdetail.*, ec_order.*, billing_country.name_cnt as billing_country_name, shipping_country.name_cnt as shipping_country_name, ec_orderstatus.order_status FROM ec_order LEFT OUTER JOIN ec_orderdetail ON ( ec_order.order_id = ec_orderdetail.order_id ) LEFT JOIN ec_country as billing_country ON billing_country.iso2_cnt = ec_order.billing_country LEFT JOIN ec_country as shipping_country ON shipping_country.iso2_cnt = ec_order.shipping_country LEFT JOIN ec_orderstatus ON ec_orderstatus.status_id = ec_order.orderstatus_id WHERE ec_order.order_date >= '" . date_format( $startdate, 'Y-m-d' ) . "' AND ec_order.order_date <= '" . date_format( $enddate, 'Y-m-d' ) . "' ORDER BY ec_order.order_id ASC";
		
		}
		
		$results = $wpdb->get_results( $sql, ARRAY_A );
		$keys = array_keys( $results[0] );
		
		foreach( $keys as $key ){
			$header .= $key."\t";
		}

		$header .= "advanced_product_options" ."\t";  //add the product options to the end
		
		foreach( $results as $result ){

			$line = '';
			foreach( $result as $value ){
	
				if( !isset( $value ) || $value == "" ){
					$value = "\t";
	
				}else{
					$value = str_replace( '"', '""', $value);
					$value = '"' . utf8_decode($value) . '"' . "\t";
	
				}
	
				$line .= $value;
	
			}
			
			$option_sql = "SELECT ec_order_option.option_value FROM ec_order_option WHERE ec_order_option.orderdetail_id = %s";
			$option_results = $wpdb->get_results( $wpdb->prepare( $option_sql, $result['orderdetail_id'] ) );
			
			$optionlist = '';
			foreach( $option_results as $option_row ){
				$optionlist .= $option_row->option_value . ', ';
			}
			$line .= $optionlist . "\t";
	
			$data .= trim( $line )."\n";
	
		}
		
		$data = str_replace( "\r", "", $data );

		if( $data == "" ){
			$data = "\nno matching records found\n";
		}
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Disposition: attachment; filename=orders.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	
		echo $header."\n".$data; 
	
	}else if( $format == 'pdf' ){
		
		require_once('fpdf/fpdf.php');

		class PDF extends FPDF{
			
			function LoadData($file){
				
				$lines = file($file);
				$data = array();
				foreach($lines as $line)
					$data[] = explode(';',trim($line));
				return $data;
			
			}

			
			function FancyTable( $header, $startdate, $enddate, $alldata ){
				
				global $wpdb;
				
				$this->SetFillColor(23, 183, 15);
				$this->SetTextColor(255);
				$this->SetDrawColor(128,128, 128);
				$this->SetLineWidth(.3);
				
				$this->SetFont('Arial','B',10);
				$w = array(20, 30, 45, 40, 40, 20, 35, 35);
				for($i=0;$i<count($header);$i++)
					$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
				$this->Ln();
				
				$this->SetFillColor(224,235,255);
				$this->SetTextColor(0);
				$this->SetFont('Arial','',8);
				
				$fill = false;
				
				$data = "";
				
				if( $alldata == 'true' ){
					$sql = "SELECT  
								ec_order.order_id, 
								ec_order.order_date, 
								ec_order.billing_first_name, 
								ec_order.billing_last_name, 
								ec_orderdetail.model_number, 
								ec_orderdetail.quantity, 
								ec_orderdetail.unit_price, 
								ec_orderdetail.total_price, 
								ec_orderdetail.optionitem_name_1, 
								ec_orderdetail.optionitem_name_2, 
								ec_orderdetail.optionitem_name_3, 
								ec_orderdetail.optionitem_name_4,
								ec_orderdetail.optionitem_name_5, 
								ec_orderdetail.use_advanced_optionset,
								ec_orderdetail.orderdetail_id
							FROM ec_order LEFT OUTER JOIN ec_orderdetail ON ( ec_order.order_id = ec_orderdetail.order_id )  
							ORDER BY ec_order.order_id ASC";
							
				}else{
					$sql = "SELECT  
								ec_order.order_id, 
								ec_order.order_date, 
								ec_order.billing_first_name, 
								ec_order.billing_last_name, 
								ec_orderdetail.model_number, 
								ec_orderdetail.quantity, 
								ec_orderdetail.unit_price, 
								ec_orderdetail.total_price, 
								ec_orderdetail.optionitem_name_1, 
								ec_orderdetail.optionitem_name_2, 
								ec_orderdetail.optionitem_name_3, 
								ec_orderdetail.optionitem_name_4,
								ec_orderdetail.optionitem_name_5, 
								ec_orderdetail.use_advanced_optionset,
								ec_orderdetail.orderdetail_id
							FROM ec_order LEFT OUTER JOIN ec_orderdetail ON (ec_order.order_id = ec_orderdetail.order_id)
							WHERE ec_order.order_date >= '".date_format($startdate, 'Y-m-d')."' AND 
								  ec_order.order_date <= '".date_format($enddate, 'Y-m-d')."' 
							ORDER BY ec_order.order_id asc";
				}
				$results = $wpdb->get_results( $sql, ARRAY_N );
				
				foreach( $results as $row ){
					$neworder = true;
					$currentorderid = $row[0];
					
					$optionlist = '';
					foreach($row as $line)
					{
						//get basic options, or advanced options
						if ($row[13] == '0') {
							$optionlist = $row[8];
							if($row[9]) $optionlist .= ', '. $row[9];
							if($row[10]) $optionlist .= ', '. $row[10];
							if($row[11]) $optionlist .= ', '. $row[11];
							if($row[12]) $optionlist .= ', '. $row[12];
						} else {
							$option_sql = "SELECT ec_order_option.option_value FROM  ec_order_option where ec_order_option.orderdetail_id = '".$row[14]."'";
							$option_results = $wpdb->get_results( $option_sql );
							$optionlist = '';
							foreach( $option_results as $optionrow ){
								$optionlist .= $optionrow->option_value . ', ';
							}
						}

					}
					
					$orderdate = new DateTime($row[1]);
					//now fill the row cells
					$this->Cell($w[0],6,$row[0],'LR',0,'C',$fill);
					$this->Cell($w[1],6,date_format($orderdate, 'F j, Y'),'LR',0,'C',$fill);
					$this->Cell($w[2],6,$row[4],'LR',0,'C',$fill);
					$this->Cell($w[3],6,substr($optionlist, 0, 25),'LR',0,'C',$fill);
					$this->Cell($w[4],6,$row[3] . ', ' . $row[2],'LR',0,'C',$fill);
					$this->Cell($w[5],6,number_format($row[5], 2),'LR',0,'C',$fill);
					$this->Cell($w[6],6,number_format($row[6], 2),'LR',0,'C',$fill);
					$this->Cell($w[7],6,number_format($row[7], 2),'LR',0,'C',$fill);
					$this->Ln();
					$fill = !$fill;
					
				}

				// Closing line
				$this->Cell(array_sum($w),0,'','T');
			}
		}
		
		//create 2 variables for use later on
		$header = array('Order ID', 'Order Date', 'Product SKU/Model', 'Product Options', 'Customer Name', 'Quantity', 'Individual Price', 'Total Price');
		
		$pdf = new PDF('L');

		$pdf->AddPage();
		//report data
		$pdf->SetFont('Arial','',14);
		
		//get grand total for report
		if($alldata == 'true') {
			$sql = "SELECT SUM(ec_order.grand_total) as grand_total FROM ec_order ";
			$reporttitle = 'Sales Report for All Orders';
			$pdf->Cell(60,10,$reporttitle,0,1,'C');
		} else {
			$sql = "SELECT SUM(ec_order.grand_total) as grand_total FROM ec_order WHERE ec_order.order_date >= '".date_format($startdate, 'Y-m-d')."' AND ec_order.order_date <= '".date_format($enddate, 'Y-m-d')."'";
			$reporttitle = 'Sales Report for ' . date_format($startdate, 'F j, Y') . ' to ' . date_format($enddate, 'F j, Y');
			$pdf->Cell(130,10,$reporttitle,0,1,'C');
		}
		$results = $wpdb->get_results( $sql );
		foreach( $results as $row ){
			$grandtotal = number_format($row->grand_total, 2);
		}
		
		$reporttotals = 'Grand Total for the Report Period: '. $grandtotal;
		
		$pdf->FancyTable($header, $startdate, $enddate, $alldata);
		
		//report totals
		$pdf->SetFont('Arial','',14);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(0,20,$reporttotals,0,1,'L');
		
		//output report
		$pdf->Output();

	}

}else{
	echo "Not Authorized...";
}
?>