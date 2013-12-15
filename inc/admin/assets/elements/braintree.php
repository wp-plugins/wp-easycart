<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "braintree" ){ echo '_inactive'; } ?>" id="braintree">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Braintree Merchant Account ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_braintree_merchant_id" id="ec_option_braintree_merchant_id" type="text" value="<?php echo get_option('ec_option_braintree_merchant_id'); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Braintree Public Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_braintree_public_key" id="ec_option_braintree_public_key" type="text" value="<?php echo get_option('ec_option_braintree_public_key'); ?>" style="width:400px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Braintree Private Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_braintree_private_key" id="ec_option_braintree_private_key" type="text" value="<?php echo get_option('ec_option_braintree_private_key'); ?>" style="width:400px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Braintree Currency Code:</span><span class="ec_payment_type_row_input"><select name="ec_option_braintree_currency" id="ec_option_braintree_currency">
                        <option value="USD" <?php if (get_option('ec_option_braintree_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_braintree_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="DEM" <?php if (get_option('ec_option_braintree_currency') == "DEM") echo ' selected'; ?>>German Mark</option>
                        <option value="CHF" <?php if (get_option('ec_option_braintree_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="GBP" <?php if (get_option('ec_option_braintree_currency') == "GBP") echo ' selected'; ?>>British Pound</option>
                        
                        <option value="AFA" <?php if (get_option('ec_option_braintree_currency') == "AFA") echo ' selected'; ?>>Afghanistan Afghani</option>
                        <option value="ALL" <?php if (get_option('ec_option_braintree_currency') == "ALL") echo ' selected'; ?>>Albanian Lek</option>
                        <option value="DZD" <?php if (get_option('ec_option_braintree_currency') == "DZD") echo ' selected'; ?>>Algerian Dinar</option>
                        <option value="ARS" <?php if (get_option('ec_option_braintree_currency') == "ARS") echo ' selected'; ?>>Argentine Peso</option>
                        <option value="AMD" <?php if (get_option('ec_option_braintree_currency') == "AMD") echo ' selected'; ?>>Armenian Dram</option>
                        <option value="AWG" <?php if (get_option('ec_option_braintree_currency') == "AWG") echo ' selected'; ?>>Aruban Florin</option>
                        <option value="AUD" <?php if (get_option('ec_option_braintree_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="AZN" <?php if (get_option('ec_option_braintree_currency') == "AZN") echo ' selected'; ?>>Azerbaijani an Manat</option>
                        
                        <option value="BSD" <?php if (get_option('ec_option_braintree_currency') == "BSD") echo ' selected'; ?>>Bahamanian Dollar</option>
                        <option value="BHD" <?php if (get_option('ec_option_braintree_currency') == "BHD") echo ' selected'; ?>>Bahraini Dinar</option>
                        <option value="BDT" <?php if (get_option('ec_option_braintree_currency') == "BDT") echo ' selected'; ?>>Bangladeshi Taka</option>
                        <option value="BBD" <?php if (get_option('ec_option_braintree_currency') == "BBD") echo ' selected'; ?>>Barbados Dollar</option>
                        <option value="BYR" <?php if (get_option('ec_option_braintree_currency') == "BYR") echo ' selected'; ?>>Belarussian Ruble</option>
                        <option value="BZD" <?php if (get_option('ec_option_braintree_currency') == "BZD") echo ' selected'; ?>>Belize Dollar</option>
                        <option value="BMD" <?php if (get_option('ec_option_braintree_currency') == "BMD") echo ' selected'; ?>>Bermudian Dollar</option>
                        <option value="BOB" <?php if (get_option('ec_option_braintree_currency') == "BOB") echo ' selected'; ?>>Bolivian Boliviano</option>
                        <option value="BWP" <?php if (get_option('ec_option_braintree_currency') == "BWP") echo ' selected'; ?>>Botswana Pula</option>
                        <option value="BRL" <?php if (get_option('ec_option_braintree_currency') == "BRL") echo ' selected'; ?>>Brazilian Real</option>
                        <option value="BND" <?php if (get_option('ec_option_braintree_currency') == "BND") echo ' selected'; ?>>Brunei Dollar</option>
                        <option value="BGN" <?php if (get_option('ec_option_braintree_currency') == "BGN") echo ' selected'; ?>>Bulgarian Lev</option>
                        <option value="BIF" <?php if (get_option('ec_option_braintree_currency') == "BIF") echo ' selected'; ?>>Burundi Franc</option>
                        
                        <option value="KHR" <?php if (get_option('ec_option_braintree_currency') == "KHR") echo ' selected'; ?>>Cambodian Riel</option>
                        <option value="CVE" <?php if (get_option('ec_option_braintree_currency') == "CVE") echo ' selected'; ?>>Cape Verde Escudo</option>
                        <option value="KYD" <?php if (get_option('ec_option_braintree_currency') == "KYD") echo ' selected'; ?>>Cayman Islands Dollar</option>
                        <option value="XAF" <?php if (get_option('ec_option_braintree_currency') == "XAF") echo ' selected'; ?>>Central African Republic Franc BCEAO</option>
                        <option value="XPF" <?php if (get_option('ec_option_braintree_currency') == "XPF") echo ' selected'; ?>>CFP Franc</option>
                        <option value="CLP" <?php if (get_option('ec_option_braintree_currency') == "CLP") echo ' selected'; ?>>Chilean Peso</option>
                        <option value="CNY" <?php if (get_option('ec_option_braintree_currency') == "CNY") echo ' selected'; ?>>Chinese Yuan Renminbi</option>
                        <option value="COP" <?php if (get_option('ec_option_braintree_currency') == "COP") echo ' selected'; ?>>Colombian Peso</option>
                        <option value="KMF" <?php if (get_option('ec_option_braintree_currency') == "KMF") echo ' selected'; ?>>Comoros Franc</option>
                        <option value="BAM" <?php if (get_option('ec_option_braintree_currency') == "BAM") echo ' selected'; ?>>Convertible Marks</option>
                        <option value="CRC" <?php if (get_option('ec_option_braintree_currency') == "CRC") echo ' selected'; ?>>Costa Rican Colon</option>
                        <option value="HRK" <?php if (get_option('ec_option_braintree_currency') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                        <option value="CUP" <?php if (get_option('ec_option_braintree_currency') == "CUP") echo ' selected'; ?>>Cuban Peso</option>
                        <option value="CYP" <?php if (get_option('ec_option_braintree_currency') == "CYP") echo ' selected'; ?>>Cyprus Pound</option>
                        <option value="CZK" <?php if (get_option('ec_option_braintree_currency') == "CZK") echo ' selected'; ?>>Czech Republic Koruna</option>
                        
                        <option value="DKK" <?php if (get_option('ec_option_braintree_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="DJF" <?php if (get_option('ec_option_braintree_currency') == "DJF") echo ' selected'; ?>>Djibouti Franc</option>
                        <option value="DOP" <?php if (get_option('ec_option_braintree_currency') == "DOP") echo ' selected'; ?>>Dominican Peso</option>
                        
                        
                        <option value="XCD" <?php if (get_option('ec_option_braintree_currency') == "XCD") echo ' selected'; ?>>East Caribbean Dollar</option>
                        <option value="ECS" <?php if (get_option('ec_option_braintree_currency') == "ECE") echo ' selected'; ?>>Ecuador Sucre</option>
                        <option value="EGP" <?php if (get_option('ec_option_braintree_currency') == "EGP") echo ' selected'; ?>>Egyptian Pound</option>
                        <option value="SVC" <?php if (get_option('ec_option_braintree_currency') == "SVC") echo ' selected'; ?>>El Salvador Colon</option>
                        <option value="ERN" <?php if (get_option('ec_option_braintree_currency') == "ERN") echo ' selected'; ?>>Eritrea Nakfa</option>
                        <option value="EEK" <?php if (get_option('ec_option_braintree_currency') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                        <option value="ETB" <?php if (get_option('ec_option_braintree_currency') == "ETB") echo ' selected'; ?>>Ethiopian Birr</option>
                        <option value="EUR" <?php if (get_option('ec_option_braintree_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        
                        <option value="FKP" <?php if (get_option('ec_option_braintree_currency') == "FKP") echo ' selected'; ?>>Falkland Islands Pound</option>
                        <option value="FJD" <?php if (get_option('ec_option_braintree_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                        <option value="CDF" <?php if (get_option('ec_option_braintree_currency') == "CDF") echo ' selected'; ?>>Franc Congolais</option>
                        
                        <option value="GMD" <?php if (get_option('ec_option_braintree_currency') == "GMD") echo ' selected'; ?>>Gambian Dalasi</option>
                        <option value="GEL" <?php if (get_option('ec_option_braintree_currency') == "GEL") echo ' selected'; ?>>Georgian Lari</option>
                        <option value="GHS" <?php if (get_option('ec_option_braintree_currency') == "GHS") echo ' selected'; ?>>Ghanaian Cedi</option>
                        <option value="GIP" <?php if (get_option('ec_option_braintree_currency') == "GIP") echo ' selected'; ?>>Gibraltar Pound</option>
                        <option value="GTQ" <?php if (get_option('ec_option_braintree_currency') == "GTQ") echo ' selected'; ?>>Guatemalan Quetzal</option>
                        <option value="GNF" <?php if (get_option('ec_option_braintree_currency') == "GNF") echo ' selected'; ?>>Guinea Franc</option>
                        <option value="GWP" <?php if (get_option('ec_option_braintree_currency') == "GWP") echo ' selected'; ?>>Guinea-Bissau Peso</option>
                        <option value="GYD" <?php if (get_option('ec_option_braintree_currency') == "GYD") echo ' selected'; ?>>Guyanan Dollar</option>
                        
                        <option value="HTG" <?php if (get_option('ec_option_braintree_currency') == "HTG") echo ' selected'; ?>>Haitian Gourde</option>
                        <option value="HNL" <?php if (get_option('ec_option_braintree_currency') == "HNL") echo ' selected'; ?>>Honduran Lempira</option>
                        <option value="HKD" <?php if (get_option('ec_option_braintree_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="HUF" <?php if (get_option('ec_option_braintree_currency') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                        
                        <option value="ISK" <?php if (get_option('ec_option_braintree_currency') == "ISK") echo ' selected'; ?>>Iceland Krona</option>
                        <option value="INR" <?php if (get_option('ec_option_braintree_currency') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                        <option value="IDR" <?php if (get_option('ec_option_braintree_currency') == "IDR") echo ' selected'; ?>>Indonesian Rupiah</option>
                        <option value="IRR" <?php if (get_option('ec_option_braintree_currency') == "IRR") echo ' selected'; ?>>Iranian Rial</option>
                        <option value="IQD" <?php if (get_option('ec_option_braintree_currency') == "IQD") echo ' selected'; ?>>Iraqi Dinar</option>
                        <option value="ILS" <?php if (get_option('ec_option_braintree_currency') == "ILS") echo ' selected'; ?>>Israeli New Shekel</option>
                        
                        <option value="JMD" <?php if (get_option('ec_option_braintree_currency') == "JMD") echo ' selected'; ?>>Jamaican Dollar</option>
                        <option value="JPY" <?php if (get_option('ec_option_braintree_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="JOD" <?php if (get_option('ec_option_braintree_currency') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                        
                        <option value="KZT" <?php if (get_option('ec_option_braintree_currency') == "KZT") echo ' selected'; ?>>Kazakhstan Tenge</option>
                        <option value="KES" <?php if (get_option('ec_option_braintree_currency') == "KES") echo ' selected'; ?>>Kenyan Shilling</option>
                        <option value="KWD" <?php if (get_option('ec_option_braintree_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                        <option value="AOA" <?php if (get_option('ec_option_braintree_currency') == "AOA") echo ' selected'; ?>>Kwanza</option>
                        <option value="GKS" <?php if (get_option('ec_option_braintree_currency') == "GKS") echo ' selected'; ?>>Kyrgyzstan Som</option>
                        
                        <option value="KIP" <?php if (get_option('ec_option_braintree_currency') == "KIP") echo ' selected'; ?>>Laos Kip</option>
                        <option value="LAK" <?php if (get_option('ec_option_braintree_currency') == "LAK") echo ' selected'; ?>>Laosian Kip</option>
                        <option value="LVL" <?php if (get_option('ec_option_braintree_currency') == "LVL") echo ' selected'; ?>>Latvian Lat</option>
                        <option value="LBP" <?php if (get_option('ec_option_braintree_currency') == "LBP") echo ' selected'; ?>>Lebanese Pound</option>
                        <option value="LRD" <?php if (get_option('ec_option_braintree_currency') == "LRD") echo ' selected'; ?>>Liberian Dollar</option>
                        <option value="LYD" <?php if (get_option('ec_option_braintree_currency') == "LYD") echo ' selected'; ?>>Libyan Dinar</option>
                        <option value="LTL" <?php if (get_option('ec_option_braintree_currency') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                        <option value="LSL" <?php if (get_option('ec_option_braintree_currency') == "LSL") echo ' selected'; ?>>Loti</option>
                        
                        <option value="MOP" <?php if (get_option('ec_option_braintree_currency') == "MOP") echo ' selected'; ?>>Macanese Pataca</option>
                        <option value="MOP" <?php if (get_option('ec_option_braintree_currency') == "MOP") echo ' selected'; ?>>Macao</option>
                        <option value="MKD" <?php if (get_option('ec_option_braintree_currency') == "MKD") echo ' selected'; ?>>Macedonian Denar</option>
                        <option value="MGF" <?php if (get_option('ec_option_braintree_currency') == "MGF") echo ' selected'; ?>>Malagasy Franc</option>
                        <option value="MGA" <?php if (get_option('ec_option_braintree_currency') == "MGA") echo ' selected'; ?>>Malagasy Ariary</option>
                        <option value="MWK" <?php if (get_option('ec_option_braintree_currency') == "MWK") echo ' selected'; ?>>Malawi Kwacha</option>
                        <option value="MYR" <?php if (get_option('ec_option_braintree_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="MVR" <?php if (get_option('ec_option_braintree_currency') == "MVR") echo ' selected'; ?>>Maldive Rufiyaa</option>
                        <option value="MTL" <?php if (get_option('ec_option_braintree_currency') == "MRL") echo ' selected'; ?>>Maltese Lira</option>
                        <option value="MRO" <?php if (get_option('ec_option_braintree_currency') == "MRO") echo ' selected'; ?>>Mauritanian Ouguiya</option>
                        <option value="MUR" <?php if (get_option('ec_option_braintree_currency') == "MUR") echo ' selected'; ?>>Mauritius Rupee</option>
                        <option value="MXN" <?php if (get_option('ec_option_braintree_currency') == "MXN") echo ' selected'; ?>>Mexican Peso</option>
                        <option value="MNT" <?php if (get_option('ec_option_braintree_currency') == "MNT") echo ' selected'; ?>>Mongolian Tugrik</option>
                        <option value="MAD" <?php if (get_option('ec_option_braintree_currency') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                        <option value="MZM" <?php if (get_option('ec_option_braintree_currency') == "MZM") echo ' selected'; ?>>Mozambique Metical</option>
                        <option value="MMK" <?php if (get_option('ec_option_braintree_currency') == "MMK") echo ' selected'; ?>>Myanmar Kyat</option>
                        
                        <option value="NAD" <?php if (get_option('ec_option_braintree_currency') == "NAD") echo ' selected'; ?>>Namibia Dollar</option>
                        <option value="NPR" <?php if (get_option('ec_option_braintree_currency') == "NPR") echo ' selected'; ?>>Nepalese Rupee</option>
                        <option value="ANG" <?php if (get_option('ec_option_braintree_currency') == "ANG") echo ' selected'; ?>>Netherlands Antillean Guilder</option>
                        <option value="PGK" <?php if (get_option('ec_option_braintree_currency') == "PGK") echo ' selected'; ?>>New Guinea Kina</option>
                        <option value="TWD" <?php if (get_option('ec_option_braintree_currency') == "TWD") echo ' selected'; ?>>New Taiwan Dollar</option>
                        <option value="TRY" <?php if (get_option('ec_option_braintree_currency') == "TRY") echo ' selected'; ?>>New Turkish Lira</option>
                        <option value="NZD" <?php if (get_option('ec_option_braintree_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="NIO" <?php if (get_option('ec_option_braintree_currency') == "NIO") echo ' selected'; ?>>Nicaraguan Cordoba Oro</option>
                        <option value="NGN" <?php if (get_option('ec_option_braintree_currency') == "NGN") echo ' selected'; ?>>Nigerian Naira</option>
                        <option value="KPW" <?php if (get_option('ec_option_braintree_currency') == "KPW") echo ' selected'; ?>>North Korea Won</option>
                        <option value="NOK" <?php if (get_option('ec_option_braintree_currency') == "NOK") echo ' selected'; ?>>Norwegian Kroner</option>
                        
                        <option value="PKR" <?php if (get_option('ec_option_braintree_currency') == "PKR") echo ' selected'; ?>>Pakistan Rupee</option>
                        <option value="PAB" <?php if (get_option('ec_option_braintree_currency') == "PAB") echo ' selected'; ?>>Panamanian Balboa</option>
                        <option value="PYG" <?php if (get_option('ec_option_braintree_currency') == "PYG") echo ' selected'; ?>>Paraguay Guarani</option>
                        <option value="PEN" <?php if (get_option('ec_option_braintree_currency') == "PEN") echo ' selected'; ?>>Peruvian Nuevo Sol</option>
                        <option value="PHP" <?php if (get_option('ec_option_braintree_currency') == "PHP") echo ' selected'; ?>>Philippine Peso</option>
                        <option value="PLN" <?php if (get_option('ec_option_braintree_currency') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                        
                        <option value="QAR" <?php if (get_option('ec_option_braintree_currency') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                        
                        <option value="OMR" <?php if (get_option('ec_option_braintree_currency') == "OMR") echo ' selected'; ?>>Rial Omani</option>
                        <option value="RON" <?php if (get_option('ec_option_braintree_currency') == "RON") echo ' selected'; ?>>Romanian Leu</option>
                        <option value="RUB" <?php if (get_option('ec_option_braintree_currency') == "RUB") echo ' selected'; ?>>Russian Rouble</option>
                        <option value="RWF" <?php if (get_option('ec_option_braintree_currency') == "RWF") echo ' selected'; ?>>Rwanda Franc</option>
                        
                        
                        <option value="WST" <?php if (get_option('ec_option_braintree_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                        <option value="STD" <?php if (get_option('ec_option_braintree_currency') == "STD") echo ' selected'; ?>>Sao Tome/Principe Dobra</option>
                        <option value="SAR" <?php if (get_option('ec_option_braintree_currency') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                        <option value="RSD" <?php if (get_option('ec_option_braintree_currency') == "RSD") echo ' selected'; ?>>Serbian Dinar</option>
                        <option value="SCR" <?php if (get_option('ec_option_braintree_currency') == "SCR") echo ' selected'; ?>>Seychelles Rupee</option>
                        <option value="SLL" <?php if (get_option('ec_option_braintree_currency') == "SLL") echo ' selected'; ?>>Sierra Leone Leone</option>
                        <option value="SGD" <?php if (get_option('ec_option_braintree_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="SKK" <?php if (get_option('ec_option_braintree_currency') == "SKK") echo ' selected'; ?>>Slovak Koruna</option>
                        <option value="SIT" <?php if (get_option('ec_option_braintree_currency') == "SIT") echo ' selected'; ?>>Slovenian Tolar</option>
                        <option value="SBD" <?php if (get_option('ec_option_braintree_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                        <option value="SOS" <?php if (get_option('ec_option_braintree_currency') == "SOS") echo ' selected'; ?>>Somalia Shilling</option>
                        <option value="ZAR" <?php if (get_option('ec_option_braintree_currency') == "ZAR") echo ' selected'; ?>>South African Rand</option>
                        <option value="KRW" <?php if (get_option('ec_option_braintree_currency') == "KRW") echo ' selected'; ?>>South-Korean Won</option>
                        <option value="LKR" <?php if (get_option('ec_option_braintree_currency') == "LKR") echo ' selected'; ?>>Sri Lanka Rupee</option>
                        <option value="SHP" <?php if (get_option('ec_option_braintree_currency') == "SHP") echo ' selected'; ?>>St. Helena Pound</option>
                        <option value="SDD" <?php if (get_option('ec_option_braintree_currency') == "SDD") echo ' selected'; ?>>Sudanese Dollar</option>
                        <option value="SRD" <?php if (get_option('ec_option_braintree_currency') == "SRD") echo ' selected'; ?>>Suriname Dollar</option>
                        <option value="SZL" <?php if (get_option('ec_option_braintree_currency') == "SZL") echo ' selected'; ?>>Swaziland Lilangeni</option>
                        <option value="SEK" <?php if (get_option('ec_option_braintree_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="CHF" <?php if (get_option('ec_option_braintree_currency') == "CHF") echo ' selected'; ?>>Switzerland Franc</option>
                        <option value="SYP" <?php if (get_option('ec_option_braintree_currency') == "SYP") echo ' selected'; ?>>Syrian Arab Republic Pound</option>
                        
                        <option value="TJS" <?php if (get_option('ec_option_braintree_currency') == "TJS") echo ' selected'; ?>>Tajikistani Somoni</option>
                        <option value="TZS" <?php if (get_option('ec_option_braintree_currency') == "TZS") echo ' selected'; ?>>Tanzanian Shilling</option>
                        <option value="THB" <?php if (get_option('ec_option_braintree_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                        <option value="TOP" <?php if (get_option('ec_option_braintree_currency') == "TOP") echo ' selected'; ?>>Tonga Pa'anga</option>
                        <option value="TTD" <?php if (get_option('ec_option_braintree_currency') == "TTD") echo ' selected'; ?>>Trinidad/Tobago Dollar</option>
                        <option value="TND" <?php if (get_option('ec_option_braintree_currency') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                        <option value="TMM" <?php if (get_option('ec_option_braintree_currency') == "TMM") echo ' selected'; ?>>Turkmenistan Manat</option>
                        
                        <option value="UGX" <?php if (get_option('ec_option_braintree_currency') == "UGX") echo ' selected'; ?>>Uganda Shilling</option>
                        <option value="UAH" <?php if (get_option('ec_option_braintree_currency') == "UAH") echo ' selected'; ?>>Ukraine Hryvnia</option>
                        <option value="AED" <?php if (get_option('ec_option_braintree_currency') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                        <option value="UYU" <?php if (get_option('ec_option_braintree_currency') == "UYU") echo ' selected'; ?>>Uruguayo Peso</option>
                        <option value="UZS" <?php if (get_option('ec_option_braintree_currency') == "UZS") echo ' selected'; ?>>Uzbekistan Som</option>
                        
                        <option value="VUV" <?php if (get_option('ec_option_braintree_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                        <option value="VEF" <?php if (get_option('ec_option_braintree_currency') == "VEF") echo ' selected'; ?>>Venezuelan Bolivar Fuerte</option>
                        <option value="VND" <?php if (get_option('ec_option_braintree_currency') == "VND") echo ' selected'; ?>>Vietnamese Dong</option>
                        <option value="XOF" <?php if (get_option('ec_option_braintree_currency') == "XOF") echo ' selected'; ?>>West African CFA Franc BCEAO</option>
                        <option value="YER" <?php if (get_option('ec_option_braintree_currency') == "YER") echo ' selected'; ?>>Yemeni Rial</option>
                        
                        <option value="YUM" <?php if (get_option('ec_option_braintree_currency') == "YUm") echo ' selected'; ?>>Yugoslav New Dinar</option>
                        <option value="ZMK" <?php if (get_option('ec_option_braintree_currency') == "ZMK") echo ' selected'; ?>>Zambian Kwacha</option>
                        <option value="ZWD" <?php if (get_option('ec_option_braintree_currency') == "ZWD") echo ' selected'; ?>>Zimbabwean Dollar</option>
                      </select></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Braintree Environment:</span><span class="ec_payment_type_row_input"><select name="ec_option_braintree_environment" id="ec_option_braintree_environment">
                        <option value="sandbox" <?php if (get_option('ec_option_braintree_environment') == 'sandbox') echo ' selected'; ?>>Sandbox</option>
                        <option value="development" <?php if (get_option('ec_option_braintree_environment') == 'development') echo ' selected'; ?>>Development</option>
                        <option value="production" <?php if (get_option('ec_option_braintree_environment') == 'production') echo ' selected'; ?>>Production</option>
                        <option value="qa" <?php if (get_option('ec_option_braintree_environment') == 'qa') echo ' selected'; ?>>qa</option>
                      </select></span></div>
	    
</div>