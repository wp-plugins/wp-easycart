<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "paypal" ){ echo '_inactive'; } ?>" id="paypal">
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Email:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_email" id="ec_option_paypal_email" type="text" value="<?php echo get_option('ec_option_paypal_email'); ?>" style="width:250px;" /></span></div>
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Currency Code:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_currency_code" id="ec_option_paypal_currency_code">
            <option value="USD" <?php if (get_option('ec_option_paypal_currency_code') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
            <option value="AUD" <?php if (get_option('ec_option_paypal_currency_code') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
            <option value="BRL" <?php if (get_option('ec_option_paypal_currency_code') == 'BRL') echo ' selected'; ?>>Brazilian Real</option>
            <option value="CAD" <?php if (get_option('ec_option_paypal_currency_code') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
            <option value="CZK" <?php if (get_option('ec_option_paypal_currency_code') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
            <option value="CZK" <?php if (get_option('ec_option_paypal_currency_code') == 'CZK') echo ' selected'; ?>>Danish Krone</option>
            <option value="EUR" <?php if (get_option('ec_option_paypal_currency_code') == 'EUR') echo ' selected'; ?>>Euro</option>
            <option value="HKD" <?php if (get_option('ec_option_paypal_currency_code') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
            <option value="HUF" <?php if (get_option('ec_option_paypal_currency_code') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
            <option value="ILS" <?php if (get_option('ec_option_paypal_currency_code') == 'ILS') echo ' selected'; ?>>Israeli New Sheqel</option>
            <option value="JPY" <?php if (get_option('ec_option_paypal_currency_code') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
            <option value="MYR" <?php if (get_option('ec_option_paypal_currency_code') == 'MYR') echo ' selected'; ?>>Malaysian Ringgit</option>
            <option value="MXN" <?php if (get_option('ec_option_paypal_currency_code') == 'MXN') echo ' selected'; ?>>Mexican Peso</option>
            <option value="NOK" <?php if (get_option('ec_option_paypal_currency_code') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
            <option value="NZD" <?php if (get_option('ec_option_paypal_currency_code') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
            <option value="PHP" <?php if (get_option('ec_option_paypal_currency_code') == 'PHP') echo ' selected'; ?>>Philippine Peso</option>
            <option value="PLN" <?php if (get_option('ec_option_paypal_currency_code') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
            <option value="GBP" <?php if (get_option('ec_option_paypal_currency_code') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
            <option value="SGD" <?php if (get_option('ec_option_paypal_currency_code') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
            <option value="SEK" <?php if (get_option('ec_option_paypal_currency_code') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
            <option value="CHF" <?php if (get_option('ec_option_paypal_currency_code') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
            <option value="TWD" <?php if (get_option('ec_option_paypal_currency_code') == 'TWD') echo ' selected'; ?>>Taiwan New Dollar</option>
            <option value="THB" <?php if (get_option('ec_option_paypal_currency_code') == 'THB') echo ' selected'; ?>>Thai Baht</option>
            <option value="TRY" <?php if (get_option('ec_option_paypal_currency_code') == 'TRY') echo ' selected'; ?>>Turkish Lira</option>
          </select></span></div>
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Language Code:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_lc" id="ec_option_paypal_lc">
            <option value="US" <?php if (get_option('ec_option_paypal_lc') == 'US') echo ' selected'; ?>>United States</option>
            <option value="AU" <?php if (get_option('ec_option_paypal_lc') == 'AU') echo ' selected'; ?>>Australia</option>
            <option value="AT" <?php if (get_option('ec_option_paypal_lc') == 'AT') echo ' selected'; ?>>Austria</option>
            <option value="BE" <?php if (get_option('ec_option_paypal_lc') == 'BE') echo ' selected'; ?>>Belgium</option>
            <option value="BR" <?php if (get_option('ec_option_paypal_lc') == 'BR') echo ' selected'; ?>>Brazil</option>
            <option value="CA" <?php if (get_option('ec_option_paypal_lc') == 'CA') echo ' selected'; ?>>Canada</option>
            <option value="CH" <?php if (get_option('ec_option_paypal_lc') == 'CH') echo ' selected'; ?>>Switzerland</option>
            <option value="CN" <?php if (get_option('ec_option_paypal_lc') == 'CN') echo ' selected'; ?>>China</option>
            <option value="DE" <?php if (get_option('ec_option_paypal_lc') == 'DE') echo ' selected'; ?>>Germany</option>
            <option value="ES" <?php if (get_option('ec_option_paypal_lc') == 'ES') echo ' selected'; ?>>Spain</option>
            <option value="GB" <?php if (get_option('ec_option_paypal_lc') == 'GB') echo ' selected'; ?>>United Kingdom</option>
            <option value="FR" <?php if (get_option('ec_option_paypal_lc') == 'FR') echo ' selected'; ?>>France</option>
            <option value="IT" <?php if (get_option('ec_option_paypal_lc') == 'IT') echo ' selected'; ?>>Italy</option>
            <option value="NL" <?php if (get_option('ec_option_paypal_lc') == 'NL') echo ' selected'; ?>>Netherlands</option>
            <option value="PL" <?php if (get_option('ec_option_paypal_lc') == 'PL') echo ' selected'; ?>>Poland</option>
            <option value="PT" <?php if (get_option('ec_option_paypal_lc') == 'PT') echo ' selected'; ?>>Portugal</option>
            <option value="RU" <?php if (get_option('ec_option_paypal_lc') == 'RU') echo ' selected'; ?>>Russia</option>
            <option value="da_DK" <?php if (get_option('ec_option_paypal_lc') == 'da_DK') echo ' selected'; ?>>Danish (for Denmark only)</option>
            <option value="he_IL" <?php if (get_option('ec_option_paypal_lc') == 'he_IL') echo ' selected'; ?>>Hebrew (all)</option>
            <option value="id_ID" <?php if (get_option('ec_option_paypal_lc') == 'id_ID') echo ' selected'; ?>>Indonesian (for Indonesia only)</option>
            <option value="jp_JP" <?php if (get_option('ec_option_paypal_lc') == 'jp_JP') echo ' selected'; ?>>Japanese (for Japan only)</option>
            <option value="no_NO" <?php if (get_option('ec_option_paypal_lc') == 'no_NO') echo ' selected'; ?>>Norwegian (for Norway only)</option>
            <option value="pt_BR" <?php if (get_option('ec_option_paypal_lc') == 'pt_BR') echo ' selected'; ?>>Brazilian Portuguese (for Portugal and Brazil only)</option>
            <option value="ru_RU" <?php if (get_option('ec_option_paypal_lc') == 'ru_RU') echo ' selected'; ?>>Russian (for Lithuania, Latvia, and Ukraine only)</option>
            <option value="sv_SE" <?php if (get_option('ec_option_paypal_lc') == 'sv_SE') echo ' selected'; ?>>Swedish (for Sweden only)</option>
            <option value="th_TH" <?php if (get_option('ec_option_paypal_lc') == 'th_TH') echo ' selected'; ?>>Thai (for Thailand only)</option>
            <option value="tr_TR" <?php if (get_option('ec_option_paypal_lc') == 'tr_TR') echo ' selected'; ?>>Turkish (for Turkey only)</option>
            <option value="zh_CN" <?php if (get_option('ec_option_paypal_lc') == 'zh_CN') echo ' selected'; ?>>Simplified Chinese (for China only)</option>
            <option value="zh_HK" <?php if (get_option('ec_option_paypal_lc') == 'zh_HK') echo ' selected'; ?>>Traditional Chinese (for Hong Kong only)</option>
            <option value="zh_TW" <?php if (get_option('ec_option_paypal_lc') == 'zh_TW') echo ' selected'; ?>>Traditional Chinese (for Taiwan only)</option>
          </select></span></div>
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Weight Unit:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_weight_unit" id="ec_option_paypal_weight_unit">
            <option value="lbs" <?php if (get_option('ec_option_paypal_weight_unit') == 'lbs') echo ' selected'; ?>>LBS</option>
            <option value="kgs" <?php if (get_option('ec_option_paypal_weight_unit') == 'kgs') echo ' selected'; ?>>KGS</option>
          </select></span></div>
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Use Sandbox For Testing:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_use_sandbox" id="ec_option_paypal_use_sandbox">
            <option value="1" <?php if (get_option('ec_option_paypal_use_sandbox') == 1) echo ' selected'; ?>>Yes</option>
            <option value="0" <?php if (get_option('ec_option_paypal_use_sandbox') == 0) echo ' selected'; ?>>No</option>
          </select></span></div>
    <div class="ec_payment_type_row"><strong>To Do:</strong> We recommend you add the plugin IPN listener to your PayPal account in order to optimize the checkout process for you and your customers. You will need to upgrade your standard account to a standard business account, if you haven't already, to use this feature.</div>
    <div class="ec_payment_type_row"><strong>PayPal IPN URL:</strong> <?php echo plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/paypal_payment_complete.php" ); ?></div>
</div>