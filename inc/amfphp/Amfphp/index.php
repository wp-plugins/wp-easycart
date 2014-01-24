<?php
/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp
 */

/**
*  includes
*  */
if( !defined( 'WP_USE_THEMES' ) )
	define( 'WP_USE_THEMES', false );
define( 'WP_DEBUG', false );
define( 'WP_INSTALLING', true );
define( 'EC_PUGIN_NAME', 'WP EasyCart' );
define( 'EC_PLUGIN_DIRECTORY', 'wp-easycart' );

require_once( '../../../../../../wp-load.php' );
require_once( '../../ec_config.php' );

require_once dirname(__FILE__) . '/ClassLoader.php';

/* 
 * main entry point (gateway) for service calls. instanciates the gateway class and uses it to handle the call.
 * 
 * @package Amfphp
 * @author Ariel Sommeria-klein
 */
$gateway = Amfphp_Core_HttpRequestGatewayFactory::createGateway();

//use this to change the current folder to the services folder. Be careful of the case.
//This was done in 1.9 and can be used to support relative includes, and should be used when upgrading from 1.9 to 2.0 if you use relative includes
//chdir(dirname(__FILE__) . '/Services');

$gateway->service();
$gateway->output();


?>
