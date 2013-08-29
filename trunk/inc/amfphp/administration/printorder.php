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

//load our connection settings
require_once('../../../../../../wp-config.php');
//set our connection variables
$dbhost = DB_HOST;
$dbname = DB_NAME;
$dbuser = DB_USER;
$dbpass = DB_PASSWORD;	
//make a connection to our database
mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db ($dbname);


if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;



  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}

}



$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);

}







$requestID = "-1";

if (isset($_GET['reqID'])) {

  $requestID = $_GET['reqID'];

}



$usersqlquery = sprintf("select * from ec_user WHERE ec_user.password = '%s' AND ec_user.user_level = 'admin' ORDER BY ec_user.email ASC", mysql_real_escape_string($requestID));



$userresult = mysql_query($usersqlquery) or die(mysql_error());

$users = mysql_fetch_assoc($userresult);



if ($users) {

$KTColParam1_orderdetails = "-1";

if (isset($_GET["OrderID"])) {

  $KTColParam1_orderdetails = (get_magic_quotes_gpc()) ? $_GET["OrderID"] : addslashes($_GET["OrderID"]);

}


$query_orderdetails = sprintf("SELECT ec_order.*, ec_orderdetail.*, ec_orderstatus.order_status FROM ((ec_order LEFT JOIN ec_orderdetail ON ec_orderdetail.order_id = ec_order.order_id) LEFT JOIN ec_orderstatus ON ec_order.orderstatus_id = ec_orderstatus.status_id) WHERE ec_order.order_id = %s ORDER BY ec_orderdetail.product_id", GetSQLValueString($KTColParam1_orderdetails, "int"));

$orderdetails = mysql_query($query_orderdetails) or die(mysql_error());

$row_orderdetails = mysql_fetch_assoc($orderdetails);

$totalRows_orderdetails = mysql_num_rows($orderdetails);




$query_rsorderstatus = "SELECT * FROM ec_orderstatus";

$rsorderstatus = mysql_query($query_rsorderstatus) or die(mysql_error());

$row_rsorderstatus = mysql_fetch_assoc($rsorderstatus);

$totalRows_rsorderstatus = mysql_num_rows($rsorderstatus);




$query_settingsRS = "SELECT * FROM ec_setting";

$settingsRS = mysql_query($query_settingsRS) or die(mysql_error());

$row_settingsRS = mysql_fetch_assoc($settingsRS);

$totalRows_settingsRS = mysql_num_rows($settingsRS);


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Print Order</title>
<style type="text/css">
<!--
.style1 {
	font-weight: bold
}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
.style3 {
	color: #FF0000
}
.fontstyle {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: normal;
}
.sizesmallfont {
	font-size: 11px;
}
.sizemediumfont {
	font-size: 14px;
}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="fontstyle">
    <td width="442" height="25" bgcolor="#CCCCCC" class="tableheadingbg"><div align="left">
        <input name="Print Order" type="submit" class="buttontext" id="Print Order" value="Print Order" onClick="window.print()">
      </div></td>
    <td width="140" bgcolor="#CCCCCC" class="tableheadingbg" style="font-weight: bold"><div align="right" class="sizemediumfont">Order Status:</div></td>
    <td width="218" align="right" bgcolor="#CCCCCC" class="sizemediumfont" style="font-weight: bold"><?php echo utf8_decode($row_orderdetails['order_status']); ?>&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td height="119" colspan="3"><span class="fontstyle"><!-- address billing/shipping information --> 
      
      </span>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
        <tr>
          <td width="400" class="style1"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;Shipping Information </strong></span></span></div></td>
          <td width="400" class="style1"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>Billing Information </strong></span></span></div></td>
        </tr>
        <?php 

// Show IF Conditional region8 

if (@$row_orderdetails['billing_address_line_1'] == "" && @$row_orderdetails['billing_city'] == ""&& @$row_orderdetails['billing_zip'] == "") {

?>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <?php 

// else Conditional region8

} else { ?>
        <tr>
          <td width="400"><span class="sizesmallfont"><span class="fontstyle">&nbsp;<?php echo utf8_decode($row_orderdetails['shipping_first_name']); ?> <?php echo utf8_decode($row_orderdetails['shipping_last_name']); ?></span></span></td>
          <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['billing_first_name']); ?> <?php echo utf8_decode($row_orderdetails['billing_last_name']); ?></span></span></div></td>
        </tr>
        <tr>
          <td width="400"><span class="sizesmallfont"><span class="fontstyle">&nbsp;<?php echo utf8_decode($row_orderdetails['shipping_address_line_1']); ?></span></span></td>
          <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['billing_address_line_1']); ?></span></span></div></td>
        </tr>
        <tr>
          <td width="400"><span class="sizesmallfont"><span class="fontstyle">&nbsp;<?php echo utf8_decode($row_orderdetails['shipping_city']); ?>, <?php echo utf8_decode($row_orderdetails['shipping_state']); ?> <?php echo utf8_decode($row_orderdetails['shipping_zip']); ?></span></span></td>
          <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['billing_city']); ?>, <?php echo utf8_decode($row_orderdetails['billing_state']); ?> <?php echo utf8_decode($row_orderdetails['billing_zip']); ?></span></span></div></td>
        </tr>
        <tr>
          <td><span class="sizesmallfont"><span class="fontstyle">&nbsp;Country: <?php echo utf8_decode($row_orderdetails['shipping_country']); ?></span></span></td>
          <td><span class="sizesmallfont"><span class="fontstyle">Country: <?php echo utf8_decode($row_orderdetails['billing_country']); ?></span></span></td>
        </tr>
        <?php } 

// endif Conditional region8

?>
        <tr>
          <td width="400"><span class="sizesmallfont"><span class="fontstyle"><strong>&nbsp;Phone:</strong> <?php echo utf8_decode($row_orderdetails['shipping_phone']); ?></span></span></td>
          <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><strong>Email:</strong>&nbsp; <a href="mailto:<?php echo utf8_decode($row_orderdetails['user_email']); ?>"><?php echo utf8_decode($row_orderdetails['user_email']); ?></a></span></span></div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="34" colspan="3" valign="top"><span class="fontstyle"><!-- order comments section table --> 
      
      </span>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
        <tr>
          <td width="121" class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;Order Number:</strong> </span></td>
          <td width="134" class="sizesmallfont"><div align="left"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['order_id']); ?></span></div></td>
          <td width="148" class="sizesmallfont">&nbsp;</td>
          <td width="126" class="sizemediumfont"><div align="left"><span class="fontstyle"><strong>Order Date: </strong></span></div></td>
          <td width="271" class="sizesmallfont"><div align="left"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['last_updated']); ?></span></div>
            <div align="left"></div></td>
        </tr>
        <tr>
          <td class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;Coupon  Code:</strong></span></td>
          <td colspan="2" class="sizesmallfont"><span class="fontstyle">
            <?php 

							// Show IF Conditional region22 

							if ($row_orderdetails['promo_code'] != '0' || $row_orderdetails['promo_code'] != '') {

							?>
            <?php echo utf8_decode($row_orderdetails['promo_code']); ?>
            <?php 

							// else Conditional region22

							} else { ?>
            NO COUPON CODE USED
            <?php } 

							// endif Conditional region22

							?>
            </span></td>
          <td class="sizemediumfont"><span class="fontstyle"><strong>Total Weight:</strong></span></td>
          <td class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['order_weight']); ?></span></td>
        </tr>
        <tr>
          <td colspan="5" class="sizemediumfont"> <span class="fontstyle"><strong>&nbsp;Customer Notes:</strong>&nbsp;&nbsp;<span class="sizesmallfont"><?php echo utf8_decode($row_orderdetails['order_customer_notes']); ?></span></span></td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="3"><span class="fontstyle"><!--Shipping table --> 
      
      </span>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="tableheadingbg">
        <tr>
          <td width="180" bgcolor="#CCCCCC"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;ORDER DETAILS </strong></span></span></div></td>
          <td width="368" align="right" bgcolor="#CCCCCC"><div class="style2"></div>
            <span class="sizemediumfont"><span class="fontstyle"> Shipping Carrier:<br>
            Tracking Number:<br>
            Shipping Method:</span></span></td>
          <td width="252" align="right" bgcolor="#CCCCCC"><span class="sizemediumfont"><span class="fontstyle">
            <div class="style2">
            <?php echo utf8_decode($row_orderdetails['shipping_carrier']); ?>&nbsp;&nbsp;<br>
            <?php echo utf8_decode($row_orderdetails['shipping_carrier']); ?>&nbsp;&nbsp;<br>
            </span> </span>
            <div align="right"></div>
            <div align="right" class="style2"> <span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['shipping_method']); ?>&nbsp;&nbsp; </span></span></div></td>
        </tr>
      </table>
      <span class="fontstyle"> 
      
      <!--table headings --> 
      
      </span>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
        <tr>
          <td width="120"><div align="center"><span class="sizemediumfont"><span class="fontstyle"><strong>Quantity</strong></span></span></div></td>
          <td width="385"><span class="sizemediumfont"><span class="fontstyle"><strong>Item</strong></span></span></td>
          <td width="100"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>Model/SKU</strong></span></span></div></td>
          <td width="100"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>Ind. Price </strong></span></span></div></td>
          <td width="100"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><strong>Total Price</strong></span></span></div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="3" valign="bottom"><span class="fontstyle">
      <?php

$rows_orderdetails = 2;

$cols_orderdetails = ceil($totalRows_orderdetails/ 2);

for ($i=0; $i<$rows_orderdetails; $i++) {

	for ($j=0; $j<$cols_orderdetails; $j++) {

		$currentIndex_orderdetails = $i + $rows_orderdetails * $j;

		if (@mysql_data_seek($orderdetails, $currentIndex_orderdetails)) {

			$row_orderdetails = mysql_fetch_assoc($orderdetails); ?>
      
      <!-- order details if statements --> 
      
      </span>
      <table border="0" cellpadding="0" cellspacing="0" class="KT_tngtable">
        <tr>
          <td height="30" width="120" valign="top" class="style1"><div align="center"><span class="sizesmallfont"><span class="fontstyle"><b><?php echo utf8_decode($row_orderdetails['quantity']); ?></b></span></span></div></td>
          <td width="385" valign="top" class="style1"><span class="sizesmallfont"><span class="fontstyle"><b><?php echo utf8_decode($row_orderdetails['title']); ?></b><br>
            </span> </span>
            <table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
              <?php 

// Show IF Conditional option1area 

if (@$row_orderdetails['is_giftcard'] == 1 ) {

?>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card Delivery: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['gift_card_delivery_method']); ?></span></span></td>
              </tr>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card To: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['gift_card_to_name']); ?></span></span></td>
              </tr>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card From: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['gift_card_from_name']); ?></span></span></td>
              </tr>
              <tr>
                <td width="125" valign="top" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card Message: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['gift_card_message']); ?></span></span></td>
              </tr>
              <?php }

// endif Conditional option1area

?>
              <?php 

// Show IF Conditional option1area 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['optionitem_name_1'] != $emptyvalue && @$row_orderdetails['optionitem_name_1'] != $zerovalue) {

?>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 1: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['optionitem_name_1']); ?></span></span></td>
              </tr>
              <?php } 

// endif Conditional option1area

?>
              <?php 

// Show IF Conditional region2 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['optionitem_name_2'] != $emptyvalue && @$row_orderdetails['optionitem_name_2'] != $zerovalue) {

?>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 2: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['optionitem_name_2']); ?></span></span></td>
              </tr>
              <?php } 

// endif Conditional region2

?>
              <?php 

// Show IF Conditional region3 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['optionitem_name_3'] != $emptyvalue && @$row_orderdetails['optionitem_name_3'] != $zerovalue) {

?>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 3: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['optionitem_name_3']); ?></span></span></td>
              </tr>
              <?php } 

// endif Conditional region3

?>
              <?php 

// Show IF Conditional region4 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['optionitem_name_4'] != $emptyvalue && @$row_orderdetails['optionitem_name_4'] != $zerovalue) {

?>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 4: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['optionitem_name_4']); ?></span></span></td>
              </tr>
              <?php } 

// endif Conditional region4

?>
              <?php 

// Show IF Conditional region5 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['optionitem_name_5'] != $emptyvalue && @$row_orderdetails['optionitem_name_5'] != $zerovalue) {

?>
              <tr>
                <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 5: </em></span></span></div></td>
                <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['optionitem_name_5']); ?></span></span></td>
              </tr>
              <?php } 

// endif Conditional region5

?>
            </table></td>
          <td width="100" valign="top"><div align="center"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['model_number']); ?>&nbsp;</span></span></div></td>
          <td width="100" valign="top"><div align="center"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['unit_price'], 2)); ?></span></span></div></td>
          <td width="100" valign="top"><div align="right"> <span class="sizesmallfont"><span class="fontstyle"><b><?php echo utf8_decode(number_format($row_orderdetails['total_price'], 2)); ?> </b></span></span></div></td>
        </tr>
      </table>
      <span class="fontstyle">
      <?php

		} else {

			echo '<td>&nbsp;</td>';

		} // end if;

	} //end for 2

	if ($i != $rows_orderdetails-1) {

		echo "";

	}

} // end for 1

?>
      &nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><span class="fontstyle"><!--totals, shipping, taxes table --> 
      
      </span>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
        <tr>
          <td align="right" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><strong>Sales Tax:</strong>&nbsp;</span></span></div></td>
          <td width="100" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['tax_total'], 2)); ?></span></span></div></td>
        </tr>
        <tr>
          <td align="right" class="total"><span class="sizemediumfont"><span class="fontstyle"><strong>Shipping:</strong>&nbsp;</span></span></td>
          <td width="100" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['shipping_total'], 2)); ?></span></span></div></td>
        </tr>
        <tr>
          <td align="right" class="total"><div align="left">
              <div align="right"><span class="sizemediumfont"><span class="fontstyle"><strong>Discounts Total:</strong>&nbsp;</span></span></div>
            </div></td>
          <td width="100" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['discount_total'], 2)); ?></span></span></div></td>
        </tr>
        <tr>
          <td align="right" class="total"><div align="left">
              <div align="right"><span class="sizemediumfont"><span class="fontstyle"><strong>Order Total:</strong>&nbsp;</span></span></div>
            </div></td>
          <td width="100" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['grand_total'], 2)); ?></span></span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php

} else {

	echo "Not Authorized...";

}

mysql_free_result($orderdetails);



mysql_free_result($rsorderstatus);



mysql_free_result($settingsRS);

?>