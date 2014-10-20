<?php 

class ec_currency{
	
	public $symbol;
	
	public $symbol_location;
	public $negative_location;
	public $decimal_symbol;
	public $decimal_length;
	public $grouping_symbol;
	
	private $conversion_rate;
	
	function __construct( ){
		$this->symbol = get_option( 'ec_option_currency' );
		$this->symbol_location = get_option( 'ec_option_currency_symbol_location' );
		$this->negative_location = get_option( 'ec_option_currency_negative_location' );
		$this->decimal_symbol = get_option( 'ec_option_currency_decimal_symbol' );
		$this->decimal_length = get_option( 'ec_option_currency_decimal_places' );
		$this->grouping_symbol = get_option( 'ec_option_currency_thousands_seperator' );
		$this->conversion_rate = 1.000;
		
		if( isset( $_SESSION['ec_convert_to'] ) ){
			$from = strtoupper( get_option( 'ec_option_base_currency' ) );
			$to = strtoupper( $_SESSION['ec_convert_to'] );
			if( $to != $from ){
				//Set Symbol
				$this->symbol = $this->get_currency_symbol( $to );
				//Get rate from string
				$rates = explode( ",", get_option( 'ec_option_exchange_rates' ) );
				for( $i=0; $i<count( $rates ); $i++ ){
					$rate = explode( "=", $rates[$i] );
					if( $rate[0] == $to ){
						$this->conversion_rate = $rate[1];
						break;
					}
				}
			}
		}
	}
	
	public function get_currency_display( $amount ){
		$display_amount = '';
		
		if( $amount < 0 && $this->negative_location )
			$display_amount .= '-';
		
		if( $this->symbol_location )
			$display_amount .= $this->symbol;
			
		if( $amount < 0 && !$this->negative_location )
			$display_amount .= '-';
		
		if( $amount < 0 )
		$amount = $amount * -1;
		
		$amount = doubleval( $amount );
		$amount = $amount * $this->conversion_rate;
		$display_amount .= number_format( $amount, $this->decimal_length, $this->decimal_symbol, $this->grouping_symbol );
		
		if( !$this->symbol_location )
			$display_amount .= $this->symbol;
			
		return $display_amount;
	}
	
	public function get_number_only( $amount ){
		$amount = doubleval( $amount );
		//convert if needed
		$amount = $amount * $this->conversion_rate;
		return number_format( $amount, $this->decimal_length, $this->decimal_symbol, '' );
	}
	
	public function format_cents( $cents ){
		return substr( $cents, 0, $this->decimal_length );
	}
	
	public function convert_price( $amount ){
		$amount = number_format( $amount * $this->conversion_rate, $this->decimal_length, $this->decimal_symbol, '' );
		return $amount;
	}
	
	public function get_currency_symbol( $currency_code ){
		$currencies = array( 'ALL' => 'Lek',
							 'AFN' => '؋', 
							 'ARS' => '$',
							 'AWG' => 'ƒ',
							 'AUD' => '$', 
							 'AZN' => 'ман', 
							 'BSD' => '$', 
							 'BBD' => '$',
							 'BYR' => 'p.', 
							 'BZD' => 'BZ$', 
							 'BMD' => '$',
							 'BOB' => '$b',	 
							 'BAM' => 'KM', 
							 'BWP' => 'P', 
							 'BGN' => 'лв', 
							 'BRL' => 'R$',
							 'BND' => '$',
							 'KHR' => '៛	៛',
							 'CAD' => '$',
							 'KYD' => '$',
							 'CLP' => '$',
							 'CNY' => '¥',
							 'COP' => '$',
							 'CRC' => '₡', 
							 'HRK' => 'kn',
							 'CUP' => '₱',	 
							 'CZK' => 'Kč', 
							 'DKK' => 'kr',
							 'DOP' => 'RD$',
							 'XCD' => '$', 
							 'EGP' => '£', 
							 'SVC' => '$', 
							 'EEK' => 'kr',
							 'EUR' => '€', 
							 'FKP' => '£',
							 'FJD' => '$',
							 'GHC' => '¢', 
							 'GIP' => '£',	 
							 'GTQ' => 'Q', 
							 'GGP' => '£',	 
							 'GYD' => '$', 
							 'HNL' => 'L',
							 'HKD' => '$',
							 'HUF' => 'Ft',
							 'ISK' => 'kr',
							 'INR' => 'INR',
							 'IDR' => 'Rp',
							 'IRR' => '﷼',
							 'IMP' => '£',
							 'ILS' => '₪', 
							 'JMD' => 'J$',
							 'JPY' => '¥',
							 'JEP' => '£',
							 'KZT' => 'лв',
							 'KPW' => '₩', 
							 'KRW' => '₩',
							 'KGS' => 'лв', 
							 'LAK' => '₭',
							 'LVL' => 'Ls',
							 'LBP' => '£',
							 'LRD' => '$',
							 'LTL' => 'Lt',
							 'MKD' => 'ден',
							 'MYR' => 'RM',
							 'MUR' => '₨',
							 'MXN' => '$',
							 'MNT' => '₮',
							 'MZN' => 'MT',
							 'NAD' => '$',
							 'NPR' => '₨',
							 'ANG' => 'ƒ',
							 'NZD' => '$',
							 'NIO' => 'C$',
							 'NGN' => '₦',
							 'KPW' => '₩',
							 'NOK' => 'kr',
							 'OMR' => '﷼',
							 'PKR' => '₨',
							 'PAB' => 'B/.',
							 'PYG' => 'Gs',
							 'PEN' => 'S/.',
							 'PHP' => '₱',
							 'PLN' => 'zł',
							 'QAR' => '﷼',
							 'RON' => 'lei',
							 'RUB' => 'руб',
							 'SHP' => '£',
							 'SAR' => '﷼',
							 'RSD' => 'Дин.',
							 'SCR' => '₨',
							 'SGD' => '$',
							 'SBD' => '$',
							 'SOS' => 'S',
							 'ZAR' => 'R',
							 'KRW' => '₩',
							 'LKR' => '₨',
							 'SEK' => 'kr',
							 'CHF' => 'CHF',
							 'SRD' => '$',
							 'SYP' => '£',
							 'TWD' => 'NT$',
							 'THB' => '฿',
							 'TTD' => 'TT$',
							 'TRY' => 'TRY',
							 'TRL' => '₤',
							 'TVD' => '$',
							 'UAH' => '₴',
							 'GBP' => '£',
							 'USD' => '$',
							 'UYU' => '$U',
							 'UZS' => 'лв',
							 'VEF' => 'Bs',
							 'VND' => '₫',
							 'YER' => '﷼',
							 'ZWD' => 'Z$'
							);
							
		return $currencies[$currency_code];
	}
	
	public function get_symbol( ){
		return $this->symbol;
	}
}

?>