<html>
    <head>
    <title>Your New Password</title>
    <style type='text/css'>
<!--
.style20 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.style22 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
    </head>
    <body>
    <table width='539' border='0' align='center'>
      <tr>
        <td colspan='4' align='left' class='style22'><img src='<?php echo $email_logo_url; ?>'></td>
      </tr>
      <tr>
        <td colspan='4' align='left' class='style22'><p><br>
            Dear <?php echo $user->billing_first_name; ?> <?php echo $user->billing_last_name; ?>:</p>
          <p>Your new password is: <strong><?php echo $new_password; ?></strong></p>
          <p>Be sure to log into your account and change your password to something you can remember.</p></td>
      </tr>
      <tr>
        <td colspan='4' class='style22'><p><br>
            Thank You Very much!</p>
          <p>&nbsp;</p></td>
      </tr>
    </table>
</body>
</html>