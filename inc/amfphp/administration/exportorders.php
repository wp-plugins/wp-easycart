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
require_once('../../../../../../wp-config.php');
//set our connection variables
$dbhost = DB_HOST;
$dbname = DB_NAME;
$dbuser = DB_USER;
$dbpass = DB_PASSWORD;//make a connection to our database
mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db ($dbname);




//get our url variables for the report
$requestID = "-1";

if (isset($_GET['reqID'])) { 
	$requestID = $_GET['reqID'];
}
if (isset($_GET['beginningdate'])) {
 	$startdate = $_GET['beginningdate'];
	$startdate = new DateTime($startdate);
}
if (isset($_GET['enddate'])) {
 	$enddate = $_GET['enddate'];
	$enddate = new DateTime($enddate);
}
if (isset($_GET['format'])) {
 	$format = $_GET['format'];
}
if (isset($_GET['alldata'])) {
 	$alldata = $_GET['alldata'];
}


//get the user and the role fo that user to see if they can access this page
$usersqlquery = sprintf("SELECT  ec_user.*, ec_role.admin_access FROM  ec_user  LEFT JOIN ec_role ON (ec_user.user_level = ec_role.role_label) WHERE  ec_user.password = '%s' AND  (ec_user.user_level = 'admin' OR ec_role.admin_access = 1)", mysql_real_escape_string($requestID));
$userresult = mysql_query($usersqlquery) or die(mysql_error());
$users = mysql_fetch_assoc($userresult);

//if the user has access
if ($users || is_user_logged_in()) {
	if($format == 'excel') {

		//create 2 variables for use later on
		$header = "";
		$data = "";
		if($alldata == 'true') {
			$sqlquery = sprintf("SELECT  ec_orderdetail.*, ec_order.* FROM  ec_order  LEFT OUTER JOIN ec_orderdetail ON (ec_order.order_id = ec_orderdetail.order_id)  order by ec_order.order_id asc");	
		} else {
			$sqlquery = sprintf("SELECT  ec_orderdetail.*, ec_order.* FROM  ec_order  LEFT OUTER JOIN ec_orderdetail ON (ec_order.order_id = ec_orderdetail.order_id) WHERE ec_order.order_date >= '".date_format($startdate, 'Y-m-d')."' AND ec_order.order_date <= '".date_format($enddate, 'Y-m-d')."' order by ec_order.order_id asc");
		}
		$result = mysql_query($sqlquery) or die(mysql_error());
		$count = mysql_num_fields($result);
		//now loop through and get database field names
		for ($i = 0; $i < $count; $i++){
			$header .= mysql_field_name($result, $i) ."\t";
		}
		$header .= "advanced_product_options" ."\t";  //add the product options to the end
		while($row = mysql_fetch_row($result)){
			$line = '';
			foreach($row as $value){
				//add order table info
				if(!isset($value) || $value == ""){
					$value = "\t";
				}else{
					# important to escape any quotes to preserve them in the data.
					$value = str_replace('"', '""', $value);
					# needed to encapsulate data in quotes because some data might be multi line.
					# the good news is that numbers remain numbers in Excel even though quoted.
					$value = '"' . utf8_decode($value) . '"' . "\t";
				}
				$line .= $value;
			}
					$optionquery = sprintf("SELECT ec_order_option.option_value FROM  ec_order_option where ec_order_option.orderdetail_id = '".$row[0]."'");
			$optionresults = mysql_query($optionquery) or die(mysql_error());
			$optionlist = '';
			while($optionrow = mysql_fetch_row($optionresults)){
				$optionlist .= $optionrow[0] . ', ';
			}
					$line .= $optionlist . "\t";
					//create the line item and next row
			$data .= trim($line)."\n";
		}
		# this line is needed because returns embedded in the data have "\r"
		# and this looks like a "box character" in Excel
		$data = str_replace("\r", "", $data);
			# Nice to let someone know that the search came up empty.
		# Otherwise only the column name headers will be output to Excel.
		if ($data == "") {
		$data = "\nno matching records found\n";
		}
		# This line will stream the file to the user rather than spray it across the screen
		header("Content-type: application/vnd.ms-excel");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Disposition: attachment; filename=orders.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $header."\n".$data;
	}
	
	if($format == 'pdf') {
		require_once('fpdf/fpdf.php');

		class PDF extends FPDF
		{
			// Load data
			function LoadData($file)
			{
				// Read file lines
				$lines = file($file);
				$data = array();
				foreach($lines as $line)
					$data[] = explode(';',trim($line));
				return $data;
			}

			// Colored table
			function FancyTable($header, $startdate, $enddate, $alldata)
			{
				// Colors, line width and bold font
				$this->SetFillColor(23, 183, 15);
				$this->SetTextColor(255);
				$this->SetDrawColor(128,128, 128);
				$this->SetLineWidth(.3);
				// Header
				$this->SetFont('Arial','B',10);
				$w = array(20, 30, 45, 40, 40, 20, 35, 35);
				for($i=0;$i<count($header);$i++)
					$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
				$this->Ln();
				// Color and font restoration
				$this->SetFillColor(224,235,255);
				$this->SetTextColor(0);
				$this->SetFont('Arial','',8);
				// Data
				$fill = false;
				
				//fetch our order data
				$data = "";
				
				if($alldata == 'true') {
					$sqlquery = sprintf("SELECT  
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
					FROM  ec_order  LEFT OUTER JOIN ec_orderdetail ON (ec_order.order_id = ec_orderdetail.order_id)  
					order by ec_order.order_id asc");
				} else {
					$sqlquery = sprintf("SELECT  
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
					FROM  ec_order  LEFT OUTER JOIN ec_orderdetail ON (ec_order.order_id = ec_orderdetail.order_id)
					WHERE ec_order.order_date >= '".date_format($startdate, 'Y-m-d')."' 
					AND ec_order.order_date <= '".date_format($enddate, 'Y-m-d')."' 
					order by ec_order.order_id asc");
				}
				$result = mysql_query($sqlquery) or die(mysql_error());
				$count = mysql_num_fields($result);

				while($row = mysql_fetch_row($result)){
					$neworder = true;
					$currentorderid = $row[0];
					//echo $currentorderid;
					
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
							$optionquery = sprintf("SELECT ec_order_option.option_value FROM  ec_order_option where ec_order_option.orderdetail_id = '".$row[14]."'");
							$optionresults = mysql_query($optionquery) or die(mysql_error());
							$optionlist = '';
							while($optionrow = mysql_fetch_row($optionresults)){
								$optionlist .= $optionrow[0] . ', ';
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
			$sqlquery = sprintf("SELECT sum(ec_order.grand_total) FROM  ec_order ");
			$reporttitle = 'Sales Report for All Orders';
			$pdf->Cell(60,10,$reporttitle,0,1,'C');
		} else {
			$sqlquery = sprintf("SELECT sum(ec_order.grand_total) FROM  ec_order WHERE ec_order.order_date >= '".date_format($startdate, 'Y-m-d')."' AND ec_order.order_date <= '".date_format($enddate, 'Y-m-d')."'");
			$reporttitle = 'Sales Report for ' . date_format($startdate, 'F j, Y') . ' to ' . date_format($enddate, 'F j, Y');
			$pdf->Cell(130,10,$reporttitle,0,1,'C');
		}
		$result = mysql_query($sqlquery) or die(mysql_error());
		while($row = mysql_fetch_row($result)){
			$grandtotal = number_format($row[0], 2);
		}
		//echo $sqlquery;
		
		//set titles
		
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

} else {
	echo "Not Authorized...";
}
?>