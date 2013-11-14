<?php

class ec_language{
	
	private $selected_language;										// VARCHAR
	
	public $language_data;											// OBJECT
	public $languages;												// ARRAY of VARCHAR
	
	function __construct( ){
		$this->selected_language = get_option( 'ec_option_language' );
		$this->language_data = $this->get_decoded_language_data( );
		if( !$this->language_data ){ // Language data is new, lets set it up from the text files
			$this->language_data = $this->get_new_language_data( );
			$this->save_language_data( );
		}
		$this->languages = $this->get_languages( );
	}
	
	/************************************************************
	/* INITIALIZATION FUNCTIONS
	/************************************************************/
	
	// Get an array of languages from the language_data
	// Returns: array of text
	private function get_languages( ){
		$language_arrays = get_object_vars( $this->language_data );
		return array_keys( $language_arrays );
	}
	
	// Gets a complete object for the language data. Used on site initialization only.
	// Returns: Language data Object
	private function get_new_language_data( ){
		$language_data = (object) array();
		$file_names = $this->get_language_file_list( );
		
		for( $i=0; $i<count( $file_names ); $i++ ){
			$language_data->{$file_names[$i]} = $this->get_language_file_decoded( $file_names[$i] . ".txt" );
		}
		
		return $language_data;
		
	}
	
	// Gets a list of language text files
	// Returns: Array of file names
	private function get_language_file_list( ){
		$file_names = array();
		$dir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/language/";
		$handle = opendir( $dir );
		while( false !== ( $file = readdir( $handle ) ) ){
			$extension = pathinfo( $file, PATHINFO_EXTENSION );
			$name = pathinfo( $file, PATHINFO_FILENAME );
			if( $extension == "txt" )
			$file_names[] = $name;
		}
		return $file_names;
	}
	
	// Gets the json decoded file data for a language file
	// Returns: Language Object
	private function get_language_file_decoded( $file_name ){
		return json_decode( $this->get_language_file_contents( $file_name ) );
	}
	
	// Gets the contents of a language file as a string
	// Returns: Language File String
	private function get_language_file_contents( $file_name ){
		$contents = file_get_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/language/" . $file_name, true );	
		//$this->language_file_checker( $contents );
		return $contents;
	}
	
	/************************************************************
	/* FRONT END FUNCTIONS
	/************************************************************/
	
	// Gets the text for a language variable
	// Returns: Matching Text
	public function get_text( $lang_section, $lang_var ){
		if( isset( $this->language_data->{$this->selected_language} ) && 
			isset( $this->language_data->{$this->selected_language}->options->{$lang_section} ) && 
			isset( $this->language_data->{$this->selected_language}->options->{$lang_section}->options->{$lang_var} ) )
				
			return str_replace( "[terms]", "<a href=\"" . get_option( 'ec_option_terms_link' ) . "\" target=\"_blank\">", str_replace( "[/terms]", "</a>", str_replace( "[privacy]", "<a href=\"" . get_option( 'ec_option_privacy_link' ) . "\" target=\"_blank\">", str_replace( "[/privacy]", "</a>", $this->language_data->{$this->selected_language}->options->{$lang_section}->options->{$lang_var}->value ) ) ) );
	}
	
	
	/************************************************************
	/* ADMIN FUNCTIONS
	/************************************************************/
	
	public function update_language_data( ){
		if( isset( $_POST['isupdate'] ) ){
			foreach( $this->languages as $language ){
				$key1 = $language;
				foreach( $this->language_data->{$language}->options as $language_section ){
					$key2 = key( $this->language_data->{$language}->options );
					foreach( $language_section->options as $language_item ){
						$key3 = key( $language_section->options );
						if( isset( $_POST['ec_' . $key1 . "_" . $key2 . "_" . $key3] ) ){
							$language_item->value = $_POST['ec_' . $key1 . "_" . $key2 . "_" . $key3];
						}
					}	
				}
			}
		}
		$file_names = $this->get_language_file_list( );
		foreach( $file_names as $file_name ){
			if( in_array( $file_name, $this->languages ) )
				$this->update_language_entry( $file_name );
			else
				$this->add_new_language_file( $file_name );
		}
		$this->save_language_data( );
	}
	
	private function update_language_entry( $file_name ){
		$new_language_object = $this->get_language_file_decoded( $file_name . ".txt" );	
		$new_array = get_object_vars( $new_language_object->options );
		$new_keys = array_keys( $new_array );
		
		$current_language_object = $this->language_data->{$file_name};
		$current_array = get_object_vars( $current_language_object->options );
		$current_keys = array_keys( $current_array );
		
		foreach( $new_keys as $new_key ){
			if( !in_array( $new_key, $current_keys ) ){
				echo "not in there";
				$this->language_data->{$file_name}->options->{$new_key} = $new_language_object->options->{$new_key};
			}else{
				$new_sub_array = get_object_vars( $new_language_object->options->{$new_key}->options );
				$new_sub_keys = array_keys( $new_sub_array );
				
				$current_sub_array = get_object_vars( $current_language_object->options->{$new_key}->options );
				$current_sub_keys = array_keys( $current_sub_array );
				
				foreach( $new_sub_keys as $new_sub_key ){
					if( !in_array( $new_sub_key, $current_sub_keys ) ){
						$this->language_data->{$file_name}->options->{$new_key}->options->{$new_sub_key} = $new_language_object->options->{$new_key}->options->{$new_sub_key};
					}
				}
			}
				
		}
		
	}
	
	// Adds a new language file to the language data heap.
	// Returns: NULL
	private function add_new_language_file( $file_name ){
		$language_data[ $file_name ] = $this->get_language_file_decoded( $file_name . ".txt" );	
	}
	
	// Updates the language_data wordpress option
	// Returns: NULL
	public function save_language_data( ){
		update_option( 'ec_option_language_data', $this->get_encoded_language_data( ) );
	}
	
	// encodes the language data
	// Returns: json encoded language data
	private function get_encoded_language_data( ){
		return json_encode( $this->language_data );
	}
	
	// decodes the language data
	// Returns: json decoded language data in object format
	private function get_decoded_language_data( ){
		return json_decode( get_option( 'ec_option_language_data' ) );
	}
	
	//////////////////////////
	// TESTING FUNCTIONS
	//////////////////////////
	private function language_file_checker( $file_contents ){
		$this->check_bracket_count( $file_contents );
		$this->check_for_quotes( $file_contents );
	}
	
	private function check_bracket_count( $file_contents ){
		$open_count = substr_count( trim($file_contents), "{" );
		$close_count = substr_count( trim($file_contents), "}" );
		
		if( $open_count > $close_count ){
			throw new Exception( "Too many open brackets in language file." );
		}else if( $close_count > $open_count ){
			throw new Exception( "Too many closed brackets in language file." );
		}
	}
	
	private function check_for_quotes( $file_contents ){
		$open_bracket_found = false;
		$open_paren_found = false;
		$closed_paren_found = false;
		for( $i=0; $i<strlen($file_contents); $i++){
			$char = substr( $file_contents, $i, 1 );
			
			if( $open_bracket_found && $char != '"' ){
				throw new Exception( "Needed a paren after open bracket at character " . $i . "." );
			}else{
				$open_bracket_found = false;
			}
			
			if( $open_paren_found && $char == '"' ){
				$closed_paren_found = true;
				$open_paren_found = false;
			}
			
			if( $closed_paren_found && $char != ':' && $char != ',' && $char != "}" ){
				throw new Exception( "Expected a : or , or } after a closed paren at character " . $i . "." );
			}else{
				$closed_paren_found = false;	
			}
		}
	}
	
}

?>