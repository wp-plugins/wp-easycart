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
$dbpass = DB_PASSWORD;	
//make a connection to our database
mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db ($dbname);



$settings_sql = "SELECT max_width, max_height FROM ec_setting";

$settings_result = mysql_query($settings_sql);

$settings_row = mysql_fetch_assoc($settings_result);

//Flash Variables

$date = $_POST['datemd5'];

$requestID = $_POST['reqID'];

$optionitemid = $_POST['optionitemid'];

$maxwidth = $settings_row['max_width'];

$maxheight = $settings_row['max_height'];

$imagequality = $_POST['imagequality'];//set this between 0 and $imagequality  for .jpg quality resizing


//Get User Information


$usersqlquery = sprintf("select * from ec_user WHERE ec_user.password = '%s' AND ec_user.user_level = 'admin' ORDER BY ec_user.email ASC", mysql_real_escape_string($requestID));

$userresult = mysql_query($usersqlquery);

$users = mysql_fetch_assoc($userresult);


if ($users || is_user_logged_in()) {

	//Flash File Data

	$filename = $_FILES['Filedata']['name'];	

	$filetmpname = $_FILES['Filedata']['tmp_name'];	

	$fileType = $_FILES["Filedata"]["type"];

	$fileSizeMB = ($_FILES["Filedata"]["size"] / 1024 / 1000);

	$explodedfilename = explode(".", $filename);

	$nameoffile = $explodedfilename[0];

	$fileextension = $explodedfilename[1];

	

	include("resizer.php");


	// Place file on server, into the images folder

	move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../../products/swatches/".$nameoffile."_".$date.".".$fileextension);

	//resize original max image

	$resizeObj = new resizer("../../../products/swatches/".$nameoffile."_".$date.".".$fileextension);

	$resizeObj -> resize($maxwidth, $maxheight, "../../../products/swatches/".$nameoffile."_".$date.".".$fileextension, $imagequality );

	
	//if we are updating, then update the db field, inserting happens later

	//Create SQL Query 
	
	$sqlfilename = $nameoffile . '_' . $date . '.' .$fileextension;	
	$sql = sprintf("Update ec_optionitem SET ec_optionitem.optionitem_icon = '%s' WHERE ec_optionitem.optionitem_id = '%s'", 
		 mysql_real_escape_string($sqlfilename),
		 mysql_real_escape_string($optionitemid));

	//Run query on database;

	mysql_query($sql);

}

?>