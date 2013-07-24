<?php 

$validate = new ec_validation; 
$license = new ec_license;

if(isset($_POST['isupdate'])){
	
	update_option( 'ec_option_use_facebook_icon', $_POST['ec_option_use_facebook_icon'] );
	update_option( 'ec_option_use_twitter_icon', $_POST['ec_option_use_twitter_icon'] );
	update_option( 'ec_option_use_delicious_icon', $_POST['ec_option_use_delicious_icon'] );
	update_option( 'ec_option_use_myspace_icon', $_POST['ec_option_use_myspace_icon'] );
	update_option( 'ec_option_use_linkedin_icon', $_POST['ec_option_use_linkedin_icon'] );
	update_option( 'ec_option_use_email_icon', $_POST['ec_option_use_email_icon'] );
	update_option( 'ec_option_use_digg_icon', $_POST['ec_option_use_digg_icon'] );
	update_option( 'ec_option_use_googleplus_icon', $_POST['ec_option_use_googleplus_icon'] );
	update_option( 'ec_option_use_pinterest_icon', $_POST['ec_option_use_pinterest_icon'] );
	update_option( 'ec_option_use_pretty_image_names', $_POST['ec_option_use_pretty_image_names'] );
	
}

?>
<div class="wrap">
<?php if(!$license->is_registered()) {; ?>
<div class="ribbon">This banner appears when you have a WordPress EasyCart FREE version installed. To purchase the FULL version, you must purchase a license at <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

<?php if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ){ ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  

<div class="ec_contentwrap">
   
    <h2>Social Icons</h2>

    <form method="post" action="options.php">
		<?php settings_fields( 'ec-social-icons-group' ); ?>
        <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            
            <tr valign="top">
              <td class="platformheading" scope="row">Enable Social Icons:</td>
              <td class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row">The social icons for each product may be enabled or disabled by simply turning their images on and off below. These social icons allow customers to share the product with a link directly back to your website.</td>
            </tr>
            <tr valign="top">
                <td width="25%" class="itemheading" scope="row"><img src="<?php echo plugins_url('images/facebook_20x20.png', __FILE__); ?>" width="20" height="20" /> Show Facebook Icon on Product Details:</td>
            
                <td width="75%">
                <select name="ec_option_use_facebook_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_facebook_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_facebook_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/twitter_20x20.png', __FILE__); ?>" width="20" height="20" /> Show Twitter Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_twitter_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_twitter_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_twitter_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/delicious_20x20.png', __FILE__); ?>" width="20" height="20" /> Show Delicious Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_delicious_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_delicious_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_delicious_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/myspace_20x20.png', __FILE__); ?>" width="20" height="20" /> Show MySpace Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_myspace_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_myspace_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_myspace_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/linkedin_20x20.png', __FILE__); ?>" width="20" height="20" /> Show LinkedIn Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_linkedin_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_linkedin_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_linkedin_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/email_20x20.png', __FILE__); ?>" width="20" height="20" /> Show Email Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_email_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_email_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_email_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/Digg_20x20.png', __FILE__); ?>" width="20" height="20" /> Show Digg Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_digg_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_digg_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_digg_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/google_plus_20x20.png', __FILE__); ?>" width="20" height="20" /> Show Google+ Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_googleplus_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_googleplus_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_googleplus_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row"><img src="<?php echo plugins_url('images/pinterest_20x20.png', __FILE__); ?>" width="20" height="20" /> Show Pinterest Icon on Product Details:</td>
            
                <td>
                <select name="ec_option_use_pinterest_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_pinterest_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_pinterest_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></td>
            </tr>
              
      </table>
        
        <p class="submit">
        <input type="hidden" name="isupdate" value="1" />
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    
    </form>
    </div>
</div>