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

$output_messages=array();

$requestID = "-1";

if (isset($_GET['reqID'])) {

  $requestID = $_GET['reqID'];

}

$usersqlquery = sprintf("SELECT  ec_user.*, ec_role.admin_access FROM  ec_user  LEFT JOIN ec_role ON (ec_user.user_level = ec_role.role_label) WHERE  ec_user.password = '%s' AND  (ec_user.user_level = 'admin' OR ec_role.admin_access = 1)", mysql_real_escape_string($requestID));


$userresult = mysql_query($usersqlquery) or die(mysql_error());

$users = mysql_fetch_assoc($userresult);

if ($users || is_user_logged_in()) {

	//create 2 variables for use later on

	$header = "";

	$data = "";

	$mysql_host = DB_HOST;

	$mysql_database = DB_NAME;

	$mysql_username = DB_USER;

	$mysql_password = DB_PASSWORD;

	$db_selected = mysql_select_db($mysql_database);

		function mysqldump($mysql_database)

		{	

			echo   "/*MySQL Dump File*/\n";

			$sql="show tables;";

			$result= mysql_query($sql);

			if( $result)

			{

				while( $row= mysql_fetch_row($result))

				{

					mysqldump_table_structure($row[0]);

					mysqldump_table_data($row[0]);

				}

			}

			else

			{

				echo   "/* no tables in $mysql_database */\n";

			}
			
			mysql_free_result($result);

		}

		function mysqldump_table_structure($table)

		{

			echo   "/* Table structure for table `$table` */\n";

			echo   "DROP TABLE IF EXISTS `$table`;\n\n";

			$sql="show create table `$table`; ";

			$result=mysql_query($sql);

			if( $result)

			{

				if($row= mysql_fetch_assoc($result))

				{

					echo   $row['Create Table'].";\n\n";

				}

			}

			mysql_free_result($result);

		}

		function mysqldump_table_data($table)

		{

			$sql="select * from `$table`;";

			$result=mysql_query($sql);

			if( $result)

			{

				$num_rows= mysql_num_rows($result);

				$num_fields= mysql_num_fields($result);

				if( $num_rows > 0)

				{

					echo   "/* dumping data for table `$table` */\n";

					$field_type=array();

					$i=0;

					while( $i < $num_fields)

					{

						$meta= mysql_fetch_field($result, $i);

						array_push($field_type, $meta->type);

						$i++;

					}

					//print_r( $field_type);

					echo   "insert into `$table` values\n";

					$index=0;

					while( $row= mysql_fetch_row($result))

					{

						echo   "(";

						for( $i=0; $i < $num_fields; $i++)

						{

							if( is_null( $row[$i]))

								echo   "null";

							else

							{

								switch( $field_type[$i])

								{

									case 'int':

										echo   $row[$i];

										break;

									case 'string':

									case 'blob' :

									default:

										echo   "'".mysql_real_escape_string($row[$i])."'";

								}

							}

							if( $i < $num_fields-1)

								echo   ",";

						}

						echo   ")";

						

						if( $index < $num_rows-1)

							echo   ",";

						else

							echo   ";";

						echo   "\n";

						

						$index++;

					}

				}

			}

			mysql_free_result($result);

			echo   "\n";

		}

		function mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password)

		{

				$db_selected = mysql_select_db($mysql_database);

				if (!$db_selected) 

				{

					//echo mysql_error();

				}

				else {

					//echo "Connected with MySQL database:$mysql_database successfully";

				}

		}

		mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password);

		header("Content-type: application/octet-stream");

		header('Content-Disposition: attachment; filename=Storefront_Backup_'.date('Y_m_d').'.sql');

		header("Pragma: no-cache");

		header("Expires: 0");

		mysqldump($mysql_database);

} else {

	echo "Not Authorized...";

}

?>