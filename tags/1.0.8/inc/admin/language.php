<?php 

$validate = new ec_validation; 
$license = new ec_license;
$language = new ec_language( );
$language->update_language_data( ); //Do this to update the database if a new language is added
 
if(isset($_POST['isupdate'])){
	update_option( 'ec_option_language', $_POST['ec_option_language'] );
	
	$language->save_language_data( );
}

?>

<div class="wrap">
<?php if(!$license->is_registered()) {; ?>
<div class="ribbon">This banner appears when you have a WordPress EasyCart FREE version installed. To purchase the FULL version, you must purchase a license at <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

<?php if(isset($_POST['isupdate'])) { ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  

<div class="ec_contentwrap">
   
    <h2>Language Options</h2>
    
     <script language="javascript" type="application/javascript">
			
			
				
	</script>
    
    <form method="post" action="">
      <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            
            <tr valign="top">
              <td width="23%" class="platformheading" >Language Options: </td>
              <td width="77%" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__ ); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td valign="middle" class="itemheading" scope="row">Selected Language:</td>
			  <td valign="middle">
              	<select name="ec_option_language" id="ec_option_language" onchange="toggle_language();">
			  	<?php 
				for( $i=0; $i<count( $language->languages ); $i++ ){ 
					$file_name = $language->languages[$i];
				?>
            		<option value="<?php echo $file_name; ?>" <?php if( get_option( 'ec_option_language' ) == $file_name ) echo ' selected'; ?>><?php echo $language->language_data->{$file_name}->label; ?></option>
  		        <?php }?>
              	</select>
              </td>
            </tr>
            <tr valign="top">
              <td valign="middle" class="itemheading" scope="row">Enable Advanced Editor:<br />
                <span class="itemsubheading">(Allows you to edit each phrase)</span></td>
			  <td valign="middle"><input type="checkbox" name="enable_editor" id="enable_editor" onchange="toggle_editor()" />
					
              </td>
            </tr>
            
            
            <div id="advanced_editor">
            <?php 
			for( $i=0; $i<count( $language->languages ); $i++ ){ 
				$file_name = $language->languages[$i];
			?>
            
            <tr valign="top" class="form-table" id="<?php echo $file_name; ?>">
				<td height="116" colspan="2" scope="row">
                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                	<tr valign="top">
                      <td width="27%" class="platformheading" ><?php echo $language->language_data->{$file_name}->label; ?></td>
                      <td width="73%" class="platformheadingimage">&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    
                    <tr valign="top" class="form-table" id="<?php echo $file_name; ?>">
						<td height="116" colspan="2" scope="row">
                
							<?php
                            foreach( $language->language_data->{$file_name}->options as $language_section ){
								$key_section = key( $language->language_data->{$file_name}->options );
                                $section_label = $language_section->label;
                            ?>
                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                <tr valign="top">
                                  <td width="30%" class="platformheading" ><?php echo $section_label; ?></td>
                                  <td width="70%" class="platformheadingimage">&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <?php
                                foreach( $language_section->options as $language_item ){
                                    $title = $language_item->title;
                                    $value = $language_item->value;
									$key = key( $language_section->options );
                                ?>
                                <tr valign="top" class="form-table">
                                  <td width="30%" class="itemheading" scope="row"><?php echo $title; ?></td>
                                  <td width="70%">
                                <input name="ec_<?php echo $file_name; ?>_<?php echo $key_section; ?>_<?php echo $key; ?>"  id="ec_option_language_<?php echo $file_name; ?>_<?php echo $key_section; ?>_<?php echo $key; ?>" type="text" value="<?php echo $value; ?>" style="width:250px;" /></td>
                                </tr>
                            	<?php }?>
                          </table>
                          <p class="submit">
                            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                          </p>
                          <?php }?>
                  		</td>
                	</tr>
                </table>
              </td>
            </tr>
            
            <?php }?>
            </div>
            
      </table>
        
      <p class="submit">
      	<input type="hidden" name="isupdate" value="1" /> 
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
      </p>
    
    </form> 
    </div>
</div>

<script>

function toggle_language( ){
	var language_keys = new Array( <?php for( $i=0; $i<count( $language->languages ); $i++ ){ if( $i>0 ){ echo ","; } echo '"' . $language->languages[$i] . '"'; } ?> );
	
	for( var i=0; i<language_keys.length; i++ ){
		document.getElementById( language_keys[i] ).style.display = "none";
	}
	
	document.getElementById( document.getElementById('ec_option_language').value ).style.display = "";
}

function toggle_editor(){
	var lang_code = document.getElementById('ec_option_language').value ;
	if( document.getElementById( "enable_editor" ).checked == true)
		document.getElementById( lang_code ).style.display = "";
	else{
		document.getElementById( lang_code ).style.display = "none";
	}
}

toggle_language();
toggle_editor();

</script>