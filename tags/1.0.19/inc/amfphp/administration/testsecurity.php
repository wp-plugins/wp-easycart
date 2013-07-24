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
$this->conn = mysql_pconnect($dbhost, $dbuser, $dbpass);
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



$KTColParam1_clientspecificRS = "0";

if (isset($_GET["clientid"])) {

  $KTColParam1_clientspecificRS = (get_magic_quotes_gpc()) ? $_GET["clientid"] : addslashes($_GET["clientid"]);

}

$KTColParam2_clientspecificRS = "0";

if (isset($_GET["file"])) {

  $KTColParam2_clientspecificRS = (get_magic_quotes_gpc()) ? $_GET["file"] : addslashes($_GET["file"]);

}

$KTColParam3_clientspecificRS = "0";

if (isset($_GET["clientemail"])) {

  $KTColParam3_clientspecificRS = (get_magic_quotes_gpc()) ? $_GET["clientemail"] : addslashes($_GET["clientemail"]);

}

$KTColParam4_clientspecificRS = "0";

if (isset($_GET["clientpassword"])) {

  $KTColParam4_clientspecificRS = (get_magic_quotes_gpc()) ? $_GET["clientpassword"] : addslashes($_GET["clientpassword"]);

}

mysql_select_db($database_flashdb, $flashdb);

$query_clientspecificRS = sprintf("SELECT clients.ClientID, orders.OrderStatus, orders.OrderID, details.ProductID, details.isDownload, details.downloadID FROM ((clients LEFT JOIN orders ON orders.ClientID=clients.ClientID) LEFT JOIN details ON details.OrderID=orders.OrderID) WHERE clients.ClientID=%s  AND (orders.OrderStatus='Card Approved' or orders.OrderStatus='Order Shipped' or orders.OrderStatus='Order Confirmed')  AND details.isDownload=1  AND details.downloadID=%s AND  clients.Email =%s AND clients.Password =%s", GetSQLValueString($KTColParam1_clientspecificRS, "int"), GetSQLValueString($KTColParam2_clientspecificRS, "text"),GetSQLValueString($KTColParam3_clientspecificRS, "text"), GetSQLValueString($KTColParam4_clientspecificRS, "text"));

$clientspecificRS = mysql_query($query_clientspecificRS, $flashdb) or die(mysql_error());

$row_clientspecificRS = mysql_fetch_assoc($clientspecificRS);

$totalRows_clientspecificRS = mysql_num_rows($clientspecificRS);

?>
<?php 

// Show IF Conditional region1 

if (@$row_clientspecificRS['downloadID'] == $_GET['file']) {

?>
<?php 

// else Conditional region1

} else { ?>

Logged Information:  Sorry, item not available for download... if you suspect an error, please give us a call.
<?php } 

// endif Conditional region1

?>
<?php

mysql_free_result($clientspecificRS);

?>
