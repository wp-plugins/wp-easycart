<?php 

$validate = new ec_validation; 
$license = new ec_license;


?>
<div class="wrap">
<?php if(!$license->is_registered()) {; ?>
<div class="ribbon">This banner appears when you have a WordPress EasyCart FREE version installed. To purchase the FULL version, you must purchase a license at <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a></div>
<h2>
  <?php }?>
  <img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" /></h2>
<div class="ec_contentwrap">
   
    <h2>Online Demos</h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="55">The WordPress EasyCart software was designed to give you an easy to use eCommerce plugin that can accommodate a lot of looks, designs, and styles with ease. Below are some of our demo shops, click the demo image to view. Try out the demos to get an idea of what the plugin can do. A complete feature list is documented at <a href="http://wpeasycart.com/docs/1.0.0/index/index.php" target="_blank">WP EasyCart Docs</a>.</td>
      </tr>
      <tr>
        <td height="10"></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><div class="ec_demo_shadow"><a href="http://base.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('images/demos/demo-portfolio-shots-1.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://chameleon.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('images/demos/demo-portfolio-shots-2.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://phoenix.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('images/demos/demo-portfolio-shots-3.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
          </tr>
          <tr>
            <td height="40" align="center"><strong>Standard EasyCart Plugin</strong></td>
            <td height="40" align="center"><strong>Chameleon</strong></td>
            <td height="40" align="center"><strong>Phoenix</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><div class="ec_demo_shadow"><a href="http://crux.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('images/demos/demo-portfolio-shots-4.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://feather.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('images/demos/demo-portfolio-shots-5.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
            <td align="center"><div class="ec_demo_shadow"><a href="http://gemini.wpeasycart.com" target="_blank"><img src="<?php echo plugins_url('images/demos/demo-portfolio-shots-6.png', __FILE__); ?>" width="325" height="211" /></a></div></td>
          </tr>
          <tr>
            <td height="40" align="center"><strong>Crux</strong></td>
            <td height="40" align="center"><strong>Feather</strong></td>
            <td height="40" align="center"><strong>Gemini</strong></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3" align="center"><div  class='info_note'><p><strong>For a full list of our themed designs and to visit our online gallery of demo shopping systems, please visit <a href="http://www.wpeasycart.com/portfolio_entries/featuredthemes/">www.wpeasycart.com</a></strong></p></div></td>
            </tr>
        </table></td>
      </tr>
    </table>
    <p>&nbsp;</p>
</div>
</div>