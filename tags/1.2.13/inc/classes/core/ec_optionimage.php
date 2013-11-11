<?php

class ec_optionimage{
	
	public $OptionItemID;			//INT
	public $OptionName;				//VARCHAR 255
	public $Image;					//VARCHAR 255
	
	function __construct( $optid, $image ){
		$this->OptionItemID = $optid;
		$this->Image = $image;
		$this->set_option_name();
	}
	
	private function set_option_name(){
		$sql = sprintf("SELECT optionitemname FROM optionitems WHERE optionitemID = '%s'", mysql_real_escape_string($this->OptinItemID));
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			$this->OptionName = $row['optionitemname'];
		}
	}
	
}

?>