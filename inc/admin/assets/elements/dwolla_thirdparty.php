<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "dwolla_thirdparty" ){ echo '_inactive'; } ?>" id="dwolla_thirdparty">
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Account ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_dwolla_thirdparty_account_id"  id="ec_option_dwolla_thirdparty_account_id" type="text" value="<?php echo get_option('ec_option_dwolla_thirdparty_account_id'); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_dwolla_thirdparty_key"  id="ec_option_dwolla_thirdparty_key" type="text" value="<?php echo get_option('ec_option_dwolla_thirdparty_key'); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Secret:</span><span class="ec_payment_type_row_input"><input name="ec_option_dwolla_thirdparty_secret"  id="ec_option_dwolla_thirdparty_secret" type="text" value="<?php echo get_option('ec_option_dwolla_thirdparty_secret'); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_dwolla_thirdparty_test_mode" id="ec_option_dwolla_thirdparty_test_mode">
                        <option value="1" <?php if (get_option('ec_option_dwolla_thirdparty_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_dwolla_thirdparty_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
    
</div>