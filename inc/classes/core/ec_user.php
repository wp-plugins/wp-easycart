<?php

class ec_user{
	protected $mysqli;									// ec_db structure
	
	public $user_id;									// INT
	public $email;										// VARCHAR 255
	public $user_level;									// VARCHAR 255
	public $is_subscriber;								// BOOLEAN
	
	public $first_name;									// VARCHAR 255
	public $last_name;									// VARCHAR 255
	
	public $billing_id;									// INT
	public $shipping_id;								// INT
	
	public $billing;									// ec_address structure
	public $shipping;									// ec_address structure
	
	public $realauth_registered;						// BOOL
	
	private $password;									// VARCHAR 255
	
	public $customfields = array();						// array of customfield objects
	
	function __construct( $email ){ 
		
		$this->mysqli = new ec_db();
		
		if( isset( $_SESSION['ec_user_id'] ) )
			$this->user_id = $_SESSION['ec_user_id'];
		else
			$this->user_id = 0;
		
		if( isset( $_SESSION['ec_email'] ) )
			$this->email = $_SESSION['ec_email'];
		else
			$this->email = "";
			
		if( isset( $_SESSION['ec_password'] ) )
			$this->password = $_SESSION['ec_password'];
		else
			$this->password = "";
		
		$user = $this->mysqli->get_user( $this->email, $this->password );
		
		
		
		if( isset( $_SESSION['ec_first_name'] ) )
			$this->first_name = $_SESSION['ec_first_name'];
		else
			$this->first_name = "";
			
		if( isset( $_SESSION['ec_last_name'] ) )
			$this->last_name = $_SESSION['ec_last_name'];
		else
			$this->last_name = "";
		
		if( $user && $user->user_level ){
			$this->user_level = $user->user_level;
			$this->is_subscriber = $user->is_subscriber;
			$this->billing_id = $user->default_billing_address_id;
			$this->shipping_id = $user->default_shipping_address_id;
		}else{
			$this->user_level = "";
			$this->is_subscriber = "";
			$this->billing_id = "";
			$this->shipping_id = "";
		}
		
		if( isset( $_SESSION['ec_billing_first_name'] ) && $_SESSION['ec_billing_first_name'] != "" ){
			$this->billing = new ec_address( $_SESSION['ec_billing_first_name'], $_SESSION['ec_billing_last_name'], $_SESSION['ec_billing_address'], "", $_SESSION['ec_billing_city'], $_SESSION['ec_billing_state'], $_SESSION['ec_billing_zip'], $_SESSION['ec_billing_country'], $_SESSION['ec_billing_phone'] );
		}else if( $user && $user->billing_first_name ){
			$this->billing = new ec_address( $user->billing_first_name, $user->billing_last_name, $user->billing_address_line_1, $user->billing_address_line_2, $user->billing_city, $user->billing_state, $user->billing_zip, $user->billing_country, $user->billing_phone );
		}else{
			$this->billing = new ec_address( "", "", "", "", "", "", "", "", "" );
		}
		
		if( isset( $_SESSION['ec_shipping_first_name'] ) && $_SESSION['ec_shipping_first_name'] != "" ){
			$this->shipping = new ec_address( $_SESSION['ec_shipping_first_name'], $_SESSION['ec_shipping_last_name'], $_SESSION['ec_shipping_address'], "", $_SESSION['ec_shipping_city'], $_SESSION['ec_shipping_state'], $_SESSION['ec_shipping_zip'], $_SESSION['ec_shipping_country'], $_SESSION['ec_shipping_phone'] );
		}else if( $user && $user->shipping_first_name ){
			$this->shipping = new ec_address( $user->shipping_first_name, $user->shipping_last_name, $user->shipping_address_line_1, $user->shipping_address_line_2, $user->shipping_city, $user->shipping_state, $user->shipping_zip, $user->shipping_country, $user->shipping_phone );
		}else{
			$this->shipping = new ec_address( "", "", "", "", "", "", "", "", "" );
		}
		
		if( isset( $user ) )
			$this->realauth_registered = $user->realauth_registered;
		
		if( $user && $user->customfield_data ){
			$customfield_data_array = explode( "---", $user->customfield_data );
			for( $i=0; $i<count( $customfield_data_array ); $i++ ){
				$temp_arr = explode("***", $customfield_data_array[$i]);
				array_push($this->customfields, $temp_arr);
			}
		}
		
	}
	
	private function setup_billing_info(){
		
		if(	isset($_POST['EmailNew']))		setup_billing_info_from_post();
		else								setup_billing_info_from_db();
	
	}
	
	private function setup_shipping_info(){
		
		if(	isset($_POST['EmailNew']))		setup_shipping_info_from_post();
		else								setup_shipping_info_from_db();
	
	}
	
	public function setup_billing_info_data( $bname, $blastname, $baddress, $bcity, $bstate, $bcountry, $bzip, $bphone ){
		
		$this->billing = new ec_address( $bname, $blastname, $baddress, "", $bcity, $bstate, $bzip, $bcountry, $bphone );
		
	}
	
	public function setup_shipping_info_data( $sname, $slastname, $saddress, $scity, $sstate, $scountry, $szip, $sphone ){
		
		$this->shipping = new ec_address( $sname, $slastname, $saddress, "", $scity, $sstate, $szip, $scountry, $sphone );
		
	}
	
	public function should_insert_user($userlevel, $createaccount){
		if($userlevel == "guest" && $createaccount)					return true;
		else 														return false;
	}
	
	public function is_guest( ){
		if( $_SESSION['ec_username'] == "guest" )					return true;
		else														return false;	
	}
	
	public function insert_user( ){
		$this->billing_id = $this->insert_billing_info( );
		$this->shipping_id = $this->insert_shipping_info( );
		$this->user_id = $this->mysqli->insert_user( $this->email, $this->password, $this->first_name, $this->last_name, $this->billing_id, $this->shipping_id, "shopper", $this->is_subscriber );
		$this->mysqli->update_address_user_id( $this->billing_id, $this->user_id );
		$this->mysqli->update_address_user_id( $this->shipping_id, $this->user_id );
	}
	
	public function insert_billing_info( ){
		$this->mysqli->insert_address( $this->billing->first_name, $this->billing->last_name, $this->billing->address_line_1, $this->billing->city, $this->billing->state, $this->billing->zip, $this->billing->country, $this->billing->phone );
	}
	
	public function insert_shipping_info( ){
		$this->mysqli->insert_address( $this->shipping->first_name, $this->shipping->last_name, $this->shipping->address_line_1, $this->shipping->city, $this->shipping->state, $this->shipping->zip, $this->shipping->country, $this->shipping->phone );
	}
	
	public function display_email( ){
		echo $this->email;	
	}
	
	public function display_custom_input_fields( $divider, $seperator ){
		for( $i=0; $i<count( $this->customfields ) && $this->customfields[$i][0] != ""; $i++ ){
			echo $this->customfields[$i][1] . $divider . " <input type=\"text\" name=\"ec_user_custom_field_" . $this->customfields[$i][0] . "\" id=\"ec_user_custom_field_" . $this->customfields[$i][0] . "\" value=\"" . $this->customfields[$i][2] . "\" />" . $seperator;
		}
	}
	
	public function display_custom_fields( $divider, $seperator ){
		for( $i=0; $i<count( $this->customfields ) && $this->customfields[$i][0] != ""; $i++ ){
			echo $this->customfields[$i][1] . $divider . " " . $this->customfields[$i][2] . $seperator;
		}
	}
	
	public function display_custom_input_label_single( $i ){
		echo $this->customfields[$i][1];
	}
	
	public function display_custom_input_field_single( $i ){
		echo "<input type=\"text\" name=\"ec_user_custom_field_" . $this->customfields[$i][0] . "\" id=\"ec_user_custom_field_" . $this->customfields[$i][0] . "\" value=\"" . $this->customfields[$i][2] . "\" />" . $seperator;
	}
	
}

?>