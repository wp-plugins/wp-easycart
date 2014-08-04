<?php

class ec_amazons3{

	public function download_file( $file_name ){
		
		$client = Aws\S3\S3Client::factory(array(
			'key' 		=> get_option( 'ec_option_amazon_key' ),
			'secret' 	=> get_option( 'ec_option_amazon_secret' )
		));
		
		$command = $client->getCommand('GetObject', array(
			'Bucket' => get_option( 'ec_option_amazon_bucket' ),
			'Key' => $file_name,
			'ResponseContentDisposition' => 'attachment; filename="' . $file_name . '"'
		));
		
		$signedUrl = $command->createPresignedUrl('+10 seconds');
		
		header( "location:" . $signedUrl );
		
		die( );
		
	}
	
	public function get_aws_files( ){
		
		$returnArray = array( );
		
		$client = Aws\S3\S3Client::factory(array(
			'key' 		=> get_option( 'ec_option_amazon_key' ),
			'secret' 	=> get_option( 'ec_option_amazon_secret' )
		));
		
		$result = $client->listObjects( array( 'Bucket' => get_option( 'ec_option_amazon_bucket' ) ) );

		foreach( $result['Contents'] as $object ){
			if( substr( $object['Key'], 0, 5 ) != "logs/" ){
				$returnArray[] = $object['Key'];
			}
		}
		
		return $returnArray;
		
	}
		
}

?>