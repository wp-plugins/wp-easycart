<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type='text/css'>
    <!--
		.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
        .style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
		.ec_option_label{font-family: Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; }
		.ec_option_name{font-family: Arial, Helvetica, sans-serif; font-size:11px; }
	-->
    </style>
</head>
<body>
    <table width='539' border='0' align='center'>
        <tr>
            <td colspan='4' align='left' class='style22'>
                <img src='<?php echo $email_logo_url; ?>'>
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
				<h3><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_inquiry_title' ); ?></h3>
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
				&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
                <span class='style22'><?php echo $product->title; ?> (<?php echo $product->model_number; ?>)</span>
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
                <span class='style22'><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_inquiry_name' ); ?> <?php echo stripslashes( $inquiry_name ); ?></span>
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
                <span class='style22'><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_inquiry_email' ); ?> <?php echo stripslashes( $inquiry_email ); ?></span>
            </td>
        </tr>
        <?php if( $has_product_options ){ ?>
        <tr>
			<td colspan='4' align='left' class='style22'>
                <span class='style22'>Product Options: <?php if( $option1 != "" ){ echo $option1; } ?><?php if( $option2 != "" ){ echo ', ' . $option2; } ?><?php if( $option3 != "" ){ echo ', ' . $option3; } ?><?php if( $option4 != "" ){ echo ', ' . $option4; } ?><?php if( $option5 != "" ){ echo ', ' . $option5; } ?></span>
            </td>
        </tr>
        <?php }?>
        <?php if( $product->use_advanced_optionset ){ ?>
        <tr>
			<td colspan='4' align='left' class='style22'>
                <span class='style22'>Product Options: <ul><?php foreach( $option_vals as $optionitem ){ echo "<li>" . $optionitem['optionitem_value'] . "</li>"; } ?></ul></span>
            </td>
        </tr>
        <?php }?>
        <tr>
			<td colspan='4' align='left' class='style22'>
                <span class='style22'><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_inquiry_message' ); ?> <?php echo nl2br( stripslashes( $inquiry_message ) ); ?></span>
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
				&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
			<td colspan='4' align='left' class='style22'>
				<span class='style22'><?php echo $GLOBALS['language']->get_text( 'product_details', 'product_details_inquiry_thank_you' ); ?></span>
            </td>
        </tr>
    </table>
</body>
</html>