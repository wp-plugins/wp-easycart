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




//Flash Variables

$date = $_POST['datemd5'];

$requestID = $_POST['reqID'];

$imagenumber = $_POST['imagenumber'];

$insertupdate = $_POST['insertupdate'];

$productid = $_POST['product_id'];

$optionitemid = $_POST['optionitemid'];

$useoptionitemimages = $_POST['useoptionitemimages'];



$imagequality = $_POST['imagequality'];//set this between 0 and $imagequality  for .jpg quality resizing

//If using option item quantity tracking, we need to insert a row for images with productid/optionitemid combo if no in already.

if($useoptionitemimages){

	$sql = sprintf("SELECT COUNT(ec_optionitemimage.optionitemimage_id) as numrows FROM ec_optionitemimage WHERE ec_optionitemimage.optionitem_id = '%s' AND ec_optionitemimage.product_id = '%s'", mysql_real_escape_string($optionitemid), mysql_real_escape_string($productid));
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_assoc($result);
	
	$numresults = $row['numrows'];
	
	if($numresults == 0){
		
		$sql = sprintf("INSERT INTO ec_optionitemimage(ec_optionitemimage.optionitem_id, ec_optionitemimage.product_id) VALUES('%s', '%s')", mysql_real_escape_string($optionitemid), mysql_real_escape_string($productid));
		
		mysql_query($sql);
			
	}

}

//Get User Information

$usersqlquery = sprintf("select * from ec_user WHERE ec_user.password = '%s' AND ec_user.user_level = 'admin' ORDER BY ec_user.email ASC", mysql_real_escape_string($requestID));

$userresult = mysql_query($usersqlquery);

$users = mysql_fetch_assoc($userresult);


if ($users) {

	//Flash File Data

	$filename = $_FILES['Filedata']['name'];	

	$filetmpname = $_FILES['Filedata']['tmp_name'];	

	$fileType = $_FILES["Filedata"]["type"];

	$fileSizeMB = ($_FILES["Filedata"]["size"] / 1024 / 1000);

	$explodedfilename = explode(".", $filename);

	$nameoffile = $explodedfilename[0];

	$fileextension = $explodedfilename[1];

	include("resizer.php");

	if ($imagenumber == '1') {

		// Place file on server, into the images folder
		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../../products/pics1/".$nameoffile."_".$date.".".$fileextension);

		//if using option item images
		if($useoptionitemimages){
			//update option item image for product and option item ID
			$sql = "UPDATE ec_optionitemimage SET ec_optionitemimage.image1 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_optionitemimage.product_id = '".$productid."' AND ec_optionitemimage.optionitem_id = '".$optionitemid."'";
			mysql_query($sql);

		}else{
			//if not using option item images, update the image1 for this product
			if ($insertupdate == 'update') {
				
				$sql = "Update ec_product SET ec_product.image1 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_product.product_id = ".$productid;
				mysql_query($sql);

			}

		}

	}

	

	if ($imagenumber == '2') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../../products/pics2/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		//$resizeObj = new resizer("../../../products/pics2/".$nameoffile."_".$date.".".$fileextension);

		//$resizeObj -> resize($maxwidth, $maxheight, "../../../products/pics2/".$nameoffile."_".$date.".".$fileextension, $imagequality );


		if($useoptionitemimages){
	
			$sql = "UPDATE ec_optionitemimage SET ec_optionitemimage.image2 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_optionitemimage.product_id = '".$productid."' AND ec_optionitemimage.optionitem_id = '".$optionitemid."'";
			
			mysql_query($sql);

		}else{
			
			if ($insertupdate == 'update') {
				
				$sql = "Update ec_product SET ec_product.image2 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_product.product_id = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

	if ($imagenumber == '3') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../../products/pics3/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		//$resizeObj = new resizer("../../../products/pics3/".$nameoffile."_".$date.".".$fileextension);

		//$resizeObj -> resize($maxwidth, $maxheight, "../../../products/pics3/".$nameoffile."_".$date.".".$fileextension, $imagequality );
		

		if($useoptionitemimages){
	
			$sql = "UPDATE ec_optionitemimage SET ec_optionitemimage.image3 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_optionitemimage.product_id = '".$productid."' AND ec_optionitemimage.optionitem_id = '".$optionitemid."'";
			
			mysql_query($sql);

		}else{
			
			if ($insertupdate == 'update') {
				
				$sql = "Update ec_product SET ec_product.image3 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_product.product_id = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

	if ($imagenumber == '4') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../../products/pics4/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		//$resizeObj = new resizer("../../../products/pics4/".$nameoffile."_".$date.".".$fileextension);

		//$resizeObj -> resize($maxwidth, $maxheight, "../../../products/pics4/".$nameoffile."_".$date.".".$fileextension, $imagequality );


		if($useoptionitemimages){
	
			$sql = "UPDATE ec_optionitemimage SET ec_optionitemimage.image4 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_optionitemimage.product_id = '".$productid."' AND ec_optionitemimage.optionitem_id = '".$optionitemid."'";
			
			mysql_query($sql);

		}else{
			
			if ($insertupdate == 'update') {
				
				$sql = "Update ec_product SET ec_product.image4 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_product.product_id = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

	if ($imagenumber == '5') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../../products/pics5/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		//$resizeObj = new resizer("../../../products/pics5/".$nameoffile."_".$date.".".$fileextension);

		//$resizeObj -> resize($maxwidth, $maxheight, "../../../products/pics5/".$nameoffile."_".$date.".".$fileextension, $imagequality );
		

		if($useoptionitemimages){
	
			$sql = "UPDATE ec_optionitemimage SET ec_optionitemimage.image5 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_optionitemimage.product_id = '".$productid."' AND ec_optionitemimage.optionitem_id = '".$optionitemid."'";
			
			mysql_query($sql);

		}else{
			
			if ($insertupdate == 'update') {
				
				$sql = "Update ec_product SET ec_product.image5 = '".$nameoffile."_".$date.".".$fileextension."' WHERE ec_product.product_id = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

}

?>