<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "eway" ){ echo '_inactive'; } ?>" id="eway">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Eway Customer ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_eway_customer_id"  id="ec_option_eway_customer_id" type="text" value="<?php echo get_option('ec_option_eway_customer_id'); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Eway Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_eway_test_mode" id="ec_option_eway_test_mode">
                        <option value="1" <?php if (get_option('ec_option_eway_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_eway_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Eway Test Mode Process Successful Transaction:</span><span class="ec_payment_type_row_input"><select name="ec_option_eway_test_mode_success" id="ec_option_eway_test_mode_success">
                        <option value="1" <?php if (get_option('ec_option_eway_test_mode_success') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_eway_test_mode_success') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>