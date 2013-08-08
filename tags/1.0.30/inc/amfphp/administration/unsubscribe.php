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
mysql_pconnect($dbhost, $dbuser, $dbpass);
mysql_select_db ($dbname);


if ((isset($_GET['email'])) && ($_GET['email'] != "")) {

  $deleteSQL = sprintf("DELETE FROM ec_subscriber WHERE ec_subscriber.email = '%s'", mysql_real_escape_string($_GET['email']));



  $Result1 = mysql_query($deleteSQL) or die(mysql_error());

  $deleteGoTo = "successfullydeleted.php";

  if (isset($_SERVER['QUERY_STRING'])) {

    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";

    $deleteGoTo .= $_SERVER['QUERY_STRING'];

  }

  header(sprintf("Location: %s", $deleteGoTo));

}

?>