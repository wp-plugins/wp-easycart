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




//Flash Variables

$requestID = $_POST['reqID'];

$imagenumber = $_POST['imagenumber'];



//Get User Information

$usersqlquery = sprintf("SELECT  ec_user.*, ec_role.admin_access FROM  ec_user  LEFT JOIN ec_role ON (ec_user.user_level = ec_role.role_label) WHERE  ec_user.password = '%s' AND  (ec_user.user_level = 'admin' OR ec_role.admin_access = 1)", mysql_real_escape_string($requestID));

$userresult = mysql_query($usersqlquery);

$users = mysql_fetch_assoc($userresult);


if ($users || is_user_logged_in()) {

	//Flash File Data

	$filename = $_FILES['Filedata']['name'];	

	$filetmpname = $_FILES['Filedata']['tmp_name'];	

	$fileType = $_FILES["Filedata"]["type"];

	$fileSizeMB = ($_FILES["Filedata"]["size"] / 1024 / 1000);

	//$explodedfilename = explode(".", $filename);

	//$nameoffile = $explodedfilename[0];

	//$fileextension = $explodedfilename[1];
	$explodedfilename = pathinfo($filename);
	$nameoffile = $explodedfilename['filename'];
	$fileextension = $explodedfilename['extension'];

	//if this is a header image, put it with the right name here
	if ($imagenumber == '1') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../images/emaillogo.jpg");

		return 'moved 1';

	}

	//if this is a footer image, put it with the right name here
	else if ($imagenumber == '2') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../images/emailfooter.jpg");
		
		return 'moved 2';

	}
	
	else {
		
		return 'upgrade needed';
	}


}

?>