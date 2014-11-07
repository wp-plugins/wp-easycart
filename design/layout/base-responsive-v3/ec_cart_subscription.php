<?php
// Check for Safari/Admin //
$ua = $_SERVER["HTTP_USER_AGENT"];
$safariorchrome = strpos($ua, 'Safari') ? true : false;
$chrome = strpos($ua, 'Chrome') ? true : false;
if( $safariorchrome && !$chrome )
	$safari = true;
else
	$safari = false;

$ipad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
$iphone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');

$is_admin = current_user_can( 'manage_options' );

if( isset( $_GET['preview'] ) ){
	$is_preview = true;
}else{
	$is_preview = false;
}

if( isset( $_GET['previewholder'] ) )
	$is_preview_holder = true;
else
	$is_preview_holder = false;
	
// END CHECK // 

/* PREVIEW CONTENT */
if( $is_preview_holder && $is_admin ){ ?>

<div class="ec_admin_preview_container" id="ec_admin_preview_container">
	<div class="ec_admin_preview_content">
    	<div class="ec_admin_preview_button_container">
            <div class="ec_admin_preview_ipad_landscape"><input type="button" onclick="ec_admin_ipad_landscape_preview( );" value="iPad Landscape"></div>
            <div class="ec_admin_preview_ipad_portrait"><input type="button" onclick="ec_admin_ipad_portrait_preview( );" value="iPad Portrait"></div>
            <div class="ec_admin_preview_iphone_landscape"><input type="button" onclick="ec_admin_iphone_landscape_preview( );" value="iPhone Landscape"></div>
            <div class="ec_admin_preview_iphone_portrait"><input type="button" onclick="ec_admin_iphone_portrait_preview( );" value="iPhone Portrait"></div>
        </div>
		<div id="ec_admin_preview_content" class="ec_admin_preview_wrapper ipad landscape">
			<iframe src="<?php echo $this->cart_page . $this->permalink_divider; ?>preview=true" width="100%" height="100%" id="ec_admin_preview_iframe"></iframe>
		</div>
	</div>
</div>

<?php }else if( $is_admin && !$safari && !$is_preview ){ ?>

<div class="ec_admin_video_container" id="ec_admin_video_container"<?php if( !$show_video ){ ?> style="display:none;"<?php }?>>
	<div class="ec_admin_video_content">
		<div class="ec_admin_video_padding">
    		<div class="ec_admin_video_holder">
    	    	<div class="ec_admin_video">
                	<h3>WP EasyCart Design Help</h3>
                    <h5>Do you need help in designing your perfect store? Watch our short video and start on your way to success.</h5>
                    <div class="ec_admin_video_hide_div"><a href="" onclick="ec_admin_hide_video_from_page( '<?php global $post; echo $post->ID; ?>' ); return false;">Hide the help video for this page?</a> OR if you no longer need design help, <a href="" onclick="ec_admin_hide_video_forever( );">hide it forever</a></div>
    	        	
                    <embed id="ec_admin_youtube_video" height="480" width="853" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen allowfullscreen="true" allowscriptaccess="always" quality="high" bgcolor="#000000" name="ec_admin_youtube_video" style="margin-bottom:-6px;" src="http://www.youtube.com/v/8Vc-69M-UWk?enablejsapi=1&version=3&playerapiid=ytplayer" type="application/x-shockwave-flash">
                    
    	        	<div class="ec_admin_video_close"><input type="button" onclick="ec_admin_close_video_screen( );" value="x"></div>
                </div>
    	    </div>
    	</div>
	</div>
</div>

<div class="ec_admin_successfully_update_container" id="ec_admin_page_updated">
	<div class="ec_admin_successfully_updated">
    	<div>Your Page Settings Have Been Updated Successfully. The Page Will Now Reload.</div>
    </div>
</div>
        
<div class="ec_admin_loader_container" id="ec_admin_page_updated_loader">
	<div class="ec_admin_loader">
    	<div>Updating Your Page Options...</div>
    </div>
</div>

<div class="ec_admin_loader_bg" id="ec_admin_loader_bg"></div>

<div id="ec_page_editor" class="ec_slideout_editor ec_display_editor_false ec_cart_editor">
	<div id="ec_page_editor_openclose_button" class="ec_slideout_openclose" data-post-id="<?php global $post; echo $post->ID; ?>">
    	<div class="dashicons dashicons-admin-generic"></div>
    </div>
    
    <div class="ec_admin_preview_button"><a href="<?php echo $this->cart_page . $this->permalink_divider; ?>previewholder=true" target="_blank">Show Device Preview</a></div>
    
    <div class="ec_admin_page_size">Cart Options</div>
    <div><strong>Desktop Columns</strong></div>
    <div><select id="ec_option_cart_columns_desktop">
    		<option value="0"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == "" ){?> selected="selected"<?php }?>>Select One</option>
            <option value="1"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == "1" ){?> selected="selected"<?php }?>>1 Column</option>
            <option value="2"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == "2" ){?> selected="selected"<?php }?>>2 Columns</option>
    </select></div>
    <div><strong>Tablet Landscape Columns</strong></div>
    <div><select id="ec_option_cart_columns_laptop">
    		<option value="0"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == "" ){?> selected="selected"<?php }?>>Select One</option>
            <option value="1"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == "1" ){?> selected="selected"<?php }?>>1 Column</option>
            <option value="2"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == "2" ){?> selected="selected"<?php }?>>2 Columns</option>
    </select></div>
    <div><strong>Tablet Portfolio Columns</strong></div>
    <div><select id="ec_option_cart_columns_tablet_wide">
    		<option value="0"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == "" ){?> selected="selected"<?php }?>>Select One</option>
            <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == "1" ){?> selected="selected"<?php }?>>1 Column</option>
            <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == "2" ){?> selected="selected"<?php }?>>2 Columns</option>
    </select></div>
    <div><strong>Smartphone Landscape Columns</strong></div>
    <div><select id="ec_option_cart_columns_tablet">
    		<option value="0"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == "" ){?> selected="selected"<?php }?>>Select One</option>
            <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == "1" ){?> selected="selected"<?php }?>>1 Column</option>
            <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == "2" ){?> selected="selected"<?php }?>>2 Columns</option>
    </select></div>
    <div><strong>Smartphone Portfolio Columns</strong></div>
    <div><select id="ec_option_cart_columns_smartphone">
    		<option value="0"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == "" ){?> selected="selected"<?php }?>>Select One</option>
            <option value="1"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == "1" ){?> selected="selected"<?php }?>>1 Column</option>
            <option value="2"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == "2" ){?> selected="selected"<?php }?>>2 Columns</option>
    </select></div>
    <div><strong>Dark/Light Theme Background</strong></div>
    <div><select id="ec_option_use_dark_bg">
    		<option value="0"<?php if( get_option( 'ec_option_use_dark_bg' ) == "" ){?> selected="selected"<?php }?>>Select One</option>
            <option value="1"<?php if( get_option( 'ec_option_use_dark_bg' ) == "1" ){?> selected="selected"<?php }?>>Dark Background</option>
            <option value="0"<?php if( get_option( 'ec_option_use_dark_bg' ) == "0" ){?> selected="selected"<?php }?>>Light Background</option>
    </select></div>
    
    <div><input type="button" value="APPLY AND SAVE" onclick="ec_admin_save_cart_options( ); return false;" /></div>
    
    <div class="ec_editor_link_row"><a href="<?php echo get_admin_url( ); ?>admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-settings#cart-settings" target="_blank">Edit Basic Cart Settings</a></div>
    
</div>

<script>
function ec_admin_save_cart_options( ){
	
	jQuery( "#ec_admin_page_updated_loader" ).show( );
	jQuery( "#ec_admin_loader_bg" ).show( );
	
	var data = {
		action: 'ec_ajax_save_cart_options',
		ec_option_cart_columns_desktop: jQuery( '#ec_option_cart_columns_desktop' ).val( ),
		ec_option_cart_columns_laptop: jQuery( '#ec_option_cart_columns_laptop' ).val( ),
		ec_option_cart_columns_tablet_wide: jQuery( '#ec_option_cart_columns_tablet_wide' ).val( ),
		ec_option_cart_columns_tablet: jQuery( '#ec_option_cart_columns_tablet' ).val( ),
		ec_option_cart_columns_smartphone: jQuery( '#ec_option_cart_columns_smartphone' ).val( ),
		ec_option_use_dark_bg: jQuery( '#ec_option_use_dark_bg' ).val( ),
	}
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		jQuery( "#ec_admin_page_updated_loader" ).hide( );
		jQuery( "#ec_admin_page_updated" ).show( );
		jQuery( "#ec_admin_loader_bg" ).fadeOut( 'slow' );
		location.reload( );
	} } );
	
	jQuery( '#ec_page_editor' ).animate( { left:'-290px' }, {queue:false, duration:220} ).removeClass( 'ec_display_editor_true' ).addClass( 'ec_display_editor_false' );
	
}
</script>

<?php }// Close editor content ?>

<section class="ec_cart_page">

	<div class="ec_cart_left">
    
    	<?php $this->display_subscription_form_start( $product->model_number ); ?>
        
		<?php if( !isset( $_SESSION['ec_user_id'] ) ){ ?>
        
        <div class="ec_cart_header ec_top">
            <input type="checkbox" name="ec_login_selector" id="ec_login_selector" value="login" onchange="ec_cart_toggle_login( );" /> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_title' ); ?>
        </div>
        
        <div id="ec_user_login_form">
            
            <div class="ec_cart_input_row">
                <label for="ec_cart_login_email"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_email_label' ); ?>*</label>
                <input type="email" id="ec_cart_login_email" name="ec_cart_login_email" />
            </div>
            <div class="ec_cart_error_row" id="ec_cart_login_email_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_email_label' ); ?>
            </div>
            
            <div class="ec_cart_input_row">
                <label for="ec_cart_login_password"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_password_label' ); ?>*</label>
                <input type="password" id="ec_cart_login_password" name="ec_cart_login_password" />
            </div>
            <div class="ec_cart_error_row" id="ec_cart_login_password_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_password_label' ); ?>
            </div>
            
            <div class="ec_cart_button_row">
                <input type="submit" value="<?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_button' ); ?>" class="ec_cart_button" onclick="return ec_validate_cart_login( );" />
            </div>
        
        </div>
        
        <?php }else{ // close section for NON logged in user ?>
        
        <div class="ec_cart_header ec_top">
            <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_title' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text' ); ?> <?php echo $this->user->first_name; ?> <?php echo $this->user->last_name; ?>, <a href="<?php echo $this->cart_page . $this->permalink_divider . "ec_cart_action=logout&subscription=" . $product->model_number; ?>"><?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_logout_link' ); ?></a> <?php echo $GLOBALS['language']->get_text( 'cart_login', 'cart_login_account_information_text2' ); ?>
        </div>
       
        <?php }?>
        
        <div id="ec_cart_payment_one_column">
        
        	<div class="ec_cart_header ec_top">
				<?php echo $product->title; ?>
            </div>
    
            <div class="ec_cart_input_row">
                <?php echo $product->short_description; ?>
            </div>
    
            <div class="ec_cart_input_row">
                <?php echo $product->get_price_formatted( ); ?>    
            </div>
            
            <?php if( $this->subscription_option1 != 0 ){ ?>
            <div class="ec_cart_input_row">
                <?php echo $this->subscription_option1_name; ?>
            </div>
            <?php }?>
            
            <?php if( $this->subscription_option2 != 0 ){ ?>
            <div class="ec_cart_input_row">
                <?php echo $this->subscription_option2_name; ?>
            </div>
            <?php }?>
            
            <?php if( $this->subscription_option3 != 0 ){ ?>
            <div class="ec_cart_input_row">
                <?php echo $this->subscription_option3_name; ?>
            </div>
            <?php }?>
            
            <?php if( $this->subscription_option4 != 0 ){ ?>
            <div class="ec_cart_input_row">
                <?php echo $this->subscription_option4_name; ?>
            </div>
            <?php }?>
            
            <?php if( $this->subscription_option5 != 0 ){ ?>
            <div class="ec_cart_input_row">
                <?php echo $this->subscription_option5_name; ?>    
            </div>
            <?php }?>
            
            <?php foreach( $this->subscription_advanced_options as $option ){ ?>
            <div class="ec_cart_input_row">
                <?php print_r( $option ); ?>    
            </div>
            <?php }?>
            
        </div>
    
        <div class="ec_cart_header">
			<?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_title' ); ?>
        </div>
        
		<?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_billing_country"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>*</label>
            <?php $this->display_billing_input( "country" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_billing_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>
            </div>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <div class="ec_cart_input_left_half">
                <label for="ec_cart_billing_first_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_first_name' ); ?>*</label>
                <?php $this->display_billing_input( "first_name" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_billing_first_name_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_first_name' ); ?>
                </div>
            </div>
            <div class="ec_cart_input_right_half">
                <label for="ec_cart_billing_last_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_last_name' ); ?>*</label>
                <?php $this->display_billing_input( "last_name" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_billing_last_name_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_last_name' ); ?>
                </div>
            </div>
        </div>
        
		<?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_billing_company_name"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_company_name' ); ?></label>
            <?php $this->display_billing_input( "company_name" ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <label for="ec_cart_billing_address"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address' ); ?>*</label>
            <?php $this->display_billing_input( "address" ); ?>
        </div>
        <div class="ec_cart_error_row" id="ec_cart_billing_address_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_address' ); ?>
        </div>
        
		<?php if( get_option( 'ec_option_use_address2' ) ){ ?>
        <div class="ec_cart_input_row">
            <?php $this->display_billing_input( "address2" ); ?>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <label for="ec_cart_billing_city"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_city' ); ?>*</label>
            <?php $this->display_billing_input( "city" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_billing_city_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_city' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_row">
            <div class="ec_cart_input_left_half">
                <label for="ec_cart_billing_state"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_state' ); ?><span id="ec_billing_state_required">*</span></label>
                <?php $this->display_billing_input( "state" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_billing_state_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_state' ); ?>
                </div>
            </div>
            <div class="ec_cart_input_right_half">
                <label for="ec_cart_billing_zip"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_zip' ); ?>*</label>
                <?php $this->display_billing_input( "zip" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_billing_zip_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_zip' ); ?>
                </div>
            </div>
        </div>
        
		<?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_billing_country"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>*</label>
            <?php $this->display_billing_input( "country" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_billing_country_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_country' ); ?>
            </div>
        </div>
        <?php }?>
        
		<?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_cart_billing_phone"><?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' ); ?>*</label>
            <?php $this->display_billing_input( "phone" ); ?>
            <div class="ec_cart_error_row" id="ec_cart_billing_phone_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_phone' ); ?>
            </div>
        </div>
        <?php }?>
        
        <?php if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) ){ ?>
        <div class="ec_cart_header">
            <input type="checkbox" name="ec_shipping_selector" id="ec_shipping_selector" value="true" onchange="ec_update_shipping_view( );"<?php if( isset( $_SESSION['ec_shipping_selector'] ) && $_SESSION['ec_shipping_selector'] == "true" ){?> checked="checked"<?php }?> /> <?php echo $GLOBALS['language']->get_text( 'cart_billing_information', 'cart_billing_information_ship_to_different' ); ?>
        </div>
        <div id="ec_shipping_form"<?php if( isset( $_SESSION['ec_shipping_selector'] ) && $_SESSION['ec_shipping_selector'] == "true" ){?> style="display:block;"<?php }?>>
            <?php if( get_option( 'ec_option_display_country_top' ) ){ ?>
            <div class="ec_cart_input_row">
                <label for="ec_cart_shipping_country"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>*</label>
                <?php $this->display_shipping_input( "country" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_country_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>
                </div>
            </div>
            <?php }?>
            <div class="ec_cart_input_row">
                <div class="ec_cart_input_left_half">
                    <label for="ec_cart_shipping_first_name"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_first_name' ); ?>*</label>
                    <?php $this->display_shipping_input( "first_name" ); ?>
                    <div class="ec_cart_error_row" id="ec_cart_shipping_first_name_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_first_name' ); ?>
                    </div>
                </div>
                <div class="ec_cart_input_right_half">
                    <label for="ec_cart_shipping_last_name"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_last_name' ); ?>*</label>
                    <?php $this->display_shipping_input( "last_name" ); ?>
                    <div class="ec_cart_error_row" id="ec_cart_shipping_last_name_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_last_name' ); ?>
                    </div>
                </div>
            </div>
            <?php if( get_option( 'ec_option_enable_company_name' ) ){ ?>
            <div class="ec_cart_input_row">
                <label for="ec_cart_shipping_company_name"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_company_name' ); ?></label>
                <?php $this->display_shipping_input( "company_name" ); ?>
            </div>
            <?php }?>
            <div class="ec_cart_input_row">
                <label for="ec_cart_shipping_address"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_address' ); ?>*</label>
                <?php $this->display_shipping_input( "address" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_address_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_address' ); ?>
                </div>
            </div>
            <?php if( get_option( 'ec_option_use_address2' ) ){ ?>
            <div class="ec_cart_input_row">
                <?php $this->display_shipping_input( "address2" ); ?>
            </div>
            <?php }?>
            <div class="ec_cart_input_row">
                <label for="ec_cart_shipping_city"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_city' ); ?>*</label>
                <?php $this->display_shipping_input( "city" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_city_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_city' ); ?>
                </div>
            </div>
            <div class="ec_cart_input_row">
                <div class="ec_cart_input_left_half">
                    <label for="ec_cart_shipping_state"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_state' ); ?><span id="ec_shipping_state_required">*</span></label>
                    <?php $this->display_shipping_input( "state" ); ?>
                    <div class="ec_cart_error_row" id="ec_cart_shipping_state_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_state' ); ?>
                    </div>
                </div>
                <div class="ec_cart_input_right_half">
                    <label for="ec_cart_shipping_zip"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_zip' ); ?>*</label>
                    <?php $this->display_shipping_input( "zip" ); ?>
                    <div class="ec_cart_error_row" id="ec_cart_shipping_zip_error">
                        <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_zip' ); ?>
                    </div>
                </div>
            </div>
            <?php if( !get_option( 'ec_option_display_country_top' ) ){ ?>
            <div class="ec_cart_input_row">
                <label for="ec_cart_shipping_country"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>*</label>
                <?php $this->display_shipping_input( "country" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_country_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_select_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_country' ); ?>
                </div>
            </div>
            <?php }?>
            <?php if( get_option( 'ec_option_collect_user_phone' ) ){ ?>
            <div class="ec_cart_input_row">
                <label for="ec_cart_shipping_phone"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_phone' ); ?>*</label>
                <?php $this->display_shipping_input( "phone" ); ?>
                <div class="ec_cart_error_row" id="ec_cart_shipping_phone_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_shipping_information', 'cart_shipping_information_phone' ); ?>
                </div>
            </div>
            <?php }?>
        </div>
        
        <?php } // Close if use shipping ?>
        
        <?php if( !isset( $_SESSION['ec_user_id'] ) ){ ?>
        <div class="ec_cart_header">
            <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' ); ?>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_contact_email"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' ); ?>*</label>
            <?php $this->ec_cart_display_contact_email_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_email_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_email' ); ?>
            </div>
        </div>
        
        <div class="ec_cart_input_row">
            <label for="ec_contact_email_retype"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_email' ); ?>*</label>
            <?php $this->ec_cart_display_contact_email_retype_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_email_retype_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_emails_do_not_match' ); ?>
            </div>
        </div>
        <?php }?>
        
        <?php if( !isset( $_SESSION['ec_email'] ) || ( isset( $_SESSION['ec_is_guest'] ) && $_SESSION['ec_is_guest'] ) ){ ?>
        
        <div class="ec_cart_header">
            <input type="hidden" name="ec_create_account_selector" id="ec_create_account_selector" value="create_account" /><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_create_account' ); ?>
        </div>
		
		<?php if( get_option( 'ec_option_use_contact_name' ) ){ ?>
        <div class="ec_cart_input_row">
            <label for="ec_contact_first_name"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_first_name' ); ?>*</label>
            <?php $this->ec_cart_display_contact_first_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_first_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_first_name' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_row">
            <label for="ec_contact_last_name"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_last_name' ); ?>*</label>
            <?php $this->ec_cart_display_contact_last_name_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_last_name_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_your' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_last_name' ); ?>
            </div>
        </div>
        <?php }?>
        
        <div class="ec_cart_input_row">
            <label for="ec_contact_password"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_password' ); ?>*</label>
            <?php $this->ec_cart_display_contact_password_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_password_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_length_error' ); ?>
            </div>
        </div>
        <div class="ec_cart_input_row">
            <label for="ec_contact_password_retype"><?php echo $GLOBALS['language']->get_text( 'cart_contact_information', 'cart_contact_information_retype_password' ); ?>*</label>
            <?php $this->ec_cart_display_contact_password_retype_input(); ?>
            <div class="ec_cart_error_row" id="ec_contact_password_retype_error">
                <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_passwords_do_not_match' ); ?>
            </div>
        </div>
        <?php }// close else/if for logged in user?>
        
        <?php if( get_option( 'ec_option_user_order_notes' ) ){ ?>
        <div class="ec_cart_header">
            <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ); ?>
        </div>
        <div class="ec_cart_input_row">
            <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_message' ); ?>
            <textarea name="ec_order_notes" id="ec_order_notes"><?php if( isset( $_SESSION['ec_order_notes'] ) ){ echo $_SESSION['ec_order_notes']; } ?></textarea>
        </div>
        <?php }?>
        
        <?php if( get_option( 'ec_option_show_coupons' ) ){ ?>
        <div class="ec_cart_header">
        	<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_title' )?>
        </div>
        <div class="ec_cart_error_message" id="ec_coupon_error"></div>
        <div class="ec_cart_success_message" id="ec_coupon_success"<?php if( isset( $this->coupon ) ){?> style="display:block;"<?php }?>><?php if( isset( $this->coupon ) ){ echo $this->coupon->message; } ?></div>
        <div class="ec_cart_input_row">
        	<input type="text" name="ec_coupon_code" id="ec_coupon_code" value="<?php if( isset( $this->coupon ) ){ echo $this->coupon_code; } ?>" placeholder="<?php echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_enter_coupon' )?>" />
        </div>
        <?php }?>
        
        <div class="ec_cart_header">
			<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_payment_method' ); ?>
        </div>
        
        <?php if( $this->use_payment_gateway( ) ){?>
        <div class="ec_cart_input_row">
			<?php if( get_option('ec_option_use_visa') || get_option('ec_option_use_delta') || get_option('ec_option_use_uke') ){ ?>
                <img src="<?php echo $this->get_payment_image_source( "visa.png" ); ?>" alt="Visa" class="ec_card_active" id="ec_card_visa" />
                <img src="<?php echo $this->get_payment_image_source( "visa_inactive.png" ); ?>" alt="Visa" class="ec_card_inactive" id="ec_card_visa_inactive" />
            <?php }?>
        
            <?php if( get_option('ec_option_use_discover') ){ ?>
                <img src="<?php echo $this->get_payment_image_source( "discover.png" ); ?>" alt="Discover" class="ec_card_active" id="ec_card_discover" />
                <img src="<?php echo $this->get_payment_image_source( "discover_inactive.png" ); ?>" alt="Discover" class="ec_card_inactive" id="ec_card_discover_inactive" />
            <?php }?>
            
            <?php if( get_option('ec_option_use_mastercard') || get_option('ec_option_use_mcdebit') ){ ?>
                <img src="<?php echo $this->get_payment_image_source( "mastercard.png"); ?>" alt="Mastercard" class="ec_card_active" id="ec_card_mastercard" />
                <img src="<?php echo $this->get_payment_image_source( "mastercard_inactive.png"); ?>" alt="Mastercard" class="ec_card_inactive" id="ec_card_mastercard_inactive" />
            <?php }?>
            
            <?php if( get_option('ec_option_use_amex') ){ ?>
                <img src="<?php echo $this->get_payment_image_source( "american_express.png"); ?>" alt="AMEX" class="ec_card_active" id="ec_card_amex" />
                <img src="<?php echo $this->get_payment_image_source( "american_express_inactive.png"); ?>" alt="AMEX" class="ec_card_inactive" id="ec_card_amex_inactive" />
            <?php }?>
            
            <?php if( get_option('ec_option_use_jcb') ){ ?>
                <img src="<?php echo $this->get_payment_image_source( "jcb.png"); ?>" alt="JCB" class="ec_card_active" id="ec_card_jcb" />
                <img src="<?php echo $this->get_payment_image_source( "jcb_inactive.png"); ?>" alt="JCB" class="ec_card_inactive" id="ec_card_jcb_inactive" />
            <?php }?>
            
            <?php if( get_option('ec_option_use_diners') ){ ?>
                <img src="<?php echo $this->get_payment_image_source( "diners.png"); ?>" alt="Diners" class="ec_card_active" id="ec_card_diners" />
                <img src="<?php echo $this->get_payment_image_source( "diners_inactive.png"); ?>" alt="Diners" class="ec_card_inactive" id="ec_card_diners_inactive" />
            <?php }?>
            
            <?php if( get_option('ec_option_use_maestro') || get_option('ec_option_use_laser')){ ?>
                <img src="<?php echo $this->get_payment_image_source( "maestro.png"); ?>" alt="Maestro" class="ec_card_active" id="ec_card_maestro" />
                <img src="<?php echo $this->get_payment_image_source( "maestro_inactive.png"); ?>" alt="Maestro" class="ec_card_inactive" id="ec_card_maestro_inactive" />
            <?php }?>
        </div>
        
        <?php $this->ec_cart_display_card_holder_name_hidden_input(); ?>
        <div class="ec_cart_input_row">
            <div class="ec_cart_input_left_half">
                <label for="ec_card_number"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?></label>
                <?php $this->ec_cart_display_card_number_input( ); ?>
                <div class="ec_cart_error_row" id="ec_card_number_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_card_number' )?>
                </div>
            </div>
            <div class="ec_cart_input_right_half ec_small_field">
                <label for="ec_security_code"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?></label>
                <?php $this->ec_cart_display_card_security_code_input( ); ?>
                <div class="ec_cart_error_row" id="ec_security_code_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_security_code' )?>
                </div>
            </div>
        </div>
        <div class="ec_cart_input_row">
            <div class="ec_cart_input_left_half ec_small_field">
                <label for="ec_expiration_month"><?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?></label>
                <?php $this->ec_cart_display_card_expiration_month_input( "MM" ); ?> <?php $this->ec_cart_display_card_expiration_year_input( "YYYY" ); ?>
                <div class="ec_cart_error_row" id="ec_expiration_date_error">
                    <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_please_enter_valid' ); ?> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_expiration_date' )?>
                </div>
            </div>
        </div>
        <?php }?>
        
        <div class="ec_cart_header">
			<?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_submit_order_button' )?>
        </div>
        
        <div class="ec_cart_error_row" id="ec_terms_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_accept_terms' )?> 
        </div>
        <div class="ec_cart_input_row">
            <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_checkout_text' )?>
        </div>
        <?php if( get_option( 'ec_option_require_terms_agreement' ) ){ ?>
        <div class="ec_cart_input_row ec_agreement_section">
            <input type="checkbox" name="ec_terms_agree" id="ec_terms_agree" value="1"  /> <?php echo $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_review_agree' )?>
        </div>
        <?php }else{ ?>
            <input type="hidden" name="ec_terms_agree" id="ec_terms_agree" value="2"  />
        <?php }?>
        
        
        <div class="ec_cart_error_row" id="ec_submit_order_error">
            <?php echo $GLOBALS['language']->get_text( 'cart_form_notices', 'cart_notice_payment_correct_errors' )?> 
        </div>
                        
        <div class="ec_cart_button_row">
            <input type="submit" value="SUBMIT ORDER" class="ec_cart_button" id="ec_cart_submit_order" onclick="return ec_validate_submit_subscription( );" />
            <input type="submit" value="PLEASE WAIT" class="ec_cart_button_working" id="ec_cart_submit_order_working" />
        </div>
        
        <?php $this->display_subscription_form_end(); ?>

	</div>
    
    <div class="ec_cart_right" id="ec_cart_payment_hide_column">
		
        <div class="ec_cart_header ec_top">
			<?php echo $product->title; ?>
        </div>

		<div class="ec_cart_input_row">
			<?php echo $product->short_description; ?>
        </div>

		<div class="ec_cart_input_row">
			<?php echo $product->get_price_formatted( ); ?>    
        </div>
        
        <?php if( $this->subscription_option1 != 0 ){ ?>
        <div class="ec_cart_input_row">
			<?php echo $this->subscription_option1_label; ?>: <?php echo $this->subscription_option1_name; ?>
        </div>
        <?php }?>
        
        <?php if( $this->subscription_option2 != 0 ){ ?>
        <div class="ec_cart_input_row">
			<?php echo $this->subscription_option2_label; ?>: <?php echo $this->subscription_option2_name; ?>
        </div>
        <?php }?>
        
        <?php if( $this->subscription_option3 != 0 ){ ?>
        <div class="ec_cart_input_row">
			<?php echo $this->subscription_option3_label; ?>: <?php echo $this->subscription_option3_name; ?>
        </div>
        <?php }?>
        
        <?php if( $this->subscription_option4 != 0 ){ ?>
        <div class="ec_cart_input_row">
			<?php echo $this->subscription_option4_label; ?>: <?php echo $this->subscription_option4_name; ?>
        </div>
        <?php }?>
        
        <?php if( $this->subscription_option5 != 0 ){ ?>
        <div class="ec_cart_input_row">
			<?php echo $this->subscription_option5_label; ?>: <?php echo $this->subscription_option5_name; ?>    
        </div>
        <?php }?>
        
        <?php foreach( $this->subscription_advanced_options as $option ){ ?>
        <div class="ec_cart_input_row">
			<?php echo $option['option_label']; ?>: <?php echo $option['optionitem_value']; ?>    
        </div>
        <?php }?>
		
	</div>
	
    <div id="ec_current_media_size"></div>
    
</section>