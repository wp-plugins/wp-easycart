<?php 

$validate = new ec_validation; 
$license = new ec_license;

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

?>
<div class="wrap">
<?php if( !$license->is_registered() && !$license->is_lite_version() ) { ?>
<div class="ribbon">You are running the WP EasyCart FREE version. To purchase the LITE or FULL version and unlock the full selling potential visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a> and purchase a license.</div>
<?php }else if( $license->is_lite_version() && $license->show_lite_message() ) { ?>
<div class="ribbon">You are running the WP EasyCart Lite version. To learn more about what you are missing with the Full version visit <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a>. To dismiss this banner <a href="?page=ec_demos&dismiss_lite_banner=true">click here.</a></div>
<?php }?>

 
<div class="ec_contentwrap">
     <br />
    <div class="ec_admin_page_title">WP EasyCart Themes and Demos</div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="55"><p>The WordPress EasyCart software was designed to give you an easy to use eCommerce plugin that can accommodate a lot of looks, designs, and styles with ease. Below are some of our themes designed with a matching EasyCart shopping system for a seamless look. All of these themes are available for purchase from EasyCart and are a great compliment to your EasyCart system. </p>
          <p><a href="http://www.wpeasycart.com/wordpress_shopping_cart_demos/" target="_blank">Click to View All Themes</a> <strong>Most Themes start at only $40 dollars!</strong></p>
        <p>You may also be interested in how WP EasyCart compares to other popular shopping systems. <a href="http://www.wpeasycart.com/wordpress-shopping-cart-comparison/" target="_blank">Click to View Full Comparison Guide.</a></p>
        <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="10"></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><span class="ec_demo_shadow"><a href="http://base.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/demo-portfolio-shots-1.png', __FILE__); ?>" width="325" height="211" /></a></span></td>
            <td align="center"><span class="ec_demo_shadow"><a href="http://basedark.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/basedark.jpg', __FILE__); ?>" width="325" height="211" /></a></span></td>
            <td align="center"><span class="ec_demo_shadow"><a href="http://choices-fresh.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/choices-fresh.jpg', __FILE__); ?>" width="325" height="211" /></a></span></td>
          </tr>
          <tr>
            <td height="40" align="center"><strong>Standard EasyCart Plugin</strong></td>
            <td height="40" align="center"><strong>BaseDark</strong></td>
            <td height="40" align="center"><strong>Choices Fresh</strong></td>
          </tr>
          <tr>
            <td align="center"><span class="ec_demo_shadow"><a href="http://highrise.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/highrise.jpg', __FILE__); ?>" width="325" height="211" /></a></span></td>
            <td align="center"><span class="ec_demo_shadow"><a href="http://estate.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/estate.jpg', __FILE__); ?>" width="325" height="211" /></a></span></td>
            <td align="center"><span class="ec_demo_shadow"><a href="http://artsee.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/artsee.jpg', __FILE__); ?>" width="325" height="211" /></a></span></td>
          </tr>
          <tr>
            <td height="40" align="center"><strong>HighRise</strong></td>
            <td height="40" align="center"><strong>Estate</strong></td>
            <td height="40" align="center"><strong>ArtSee</strong></td>
          </tr>
          <tr>
            <td align="center"><div class="ec_demo_shadow"><a href="http://whiterock.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/whiterock.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://chameleon.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/demo-portfolio-shots-2.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://phoenix.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/demo-portfolio-shots-3.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
          </tr>
          <tr>
            <td height="40" align="center"><strong>WhiteRock</strong></td>
            <td height="40" align="center"><strong>Chameleon</strong></td>
            <td height="40" align="center"><strong>Phoenix</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><div class="ec_demo_shadow"><a href="http://crux.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/demo-portfolio-shots-4.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://feather.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/demo-portfolio-shots-5.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://udesign.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('../images/demos/udesign.jpg', __FILE__); ?>" width="325" height="211" /></a></div></td>
          </tr>
          <tr>
            <td height="40" align="center"><strong>Crux</strong></td>
            <td height="40" align="center"><strong>Feather</strong></td>
            <td height="40" align="center"><strong>U-Design</strong></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3" align="center"><div  class='info_note'><p><strong>For a full list of our themed designs and to visit our online gallery of demo shopping systems, please visit <a href="http://www.wpeasycart.com/wordpress_shopping_cart_demos/" target="_blank">www.wpeasycart.com</a></strong></p></div></td>
            </tr>
        </table></td>
      </tr>
    </table>
    <p>&nbsp;</p>
</div>
</div>