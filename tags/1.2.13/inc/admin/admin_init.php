<?php
////////////////////////////////////////////
// ADMIN INITIALIZE/LOCALIZE AJAX Functions
////////////////////////////////////////////
add_action( 'admin_enqueue_scripts', 'ec_load_admin_scripts' );
add_action( 'admin_init', 'ec_register_settings' );
add_action( 'admin_menu', 'ec_create_menu' );

function ec_load_admin_scripts( ){
	
	include( 'style.php' );
	
	wp_enqueue_script('thickbox');  
	wp_enqueue_style('thickbox');  

	wp_enqueue_script('media-upload'); 
	
	wp_register_script( 'wpeasycart_admin_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/admin_ajax_functions.js' ), array( 'jquery' ) );
	wp_enqueue_script( 'wpeasycart_admin_js' );
	
	$https_link = "";
	if( class_exists( "WordPressHTTPS" ) ){
		$https_class = new WordPressHTTPS( );
		$https_link = $https_class->getHttpsUrl() . '/wp-admin/admin-ajax.php';
	}else{
		$https_link = str_replace( "http://", "https://", admin_url( 'admin-ajax.php' ) );
	}
	
	if( isset( $_SERVER['HTTPS'] ) )
		wp_localize_script( 'wpeasycart_admin_js', 'ajax_object', array( 'ajax_url' => $https_link ) );
	else
		wp_localize_script( 'wpeasycart_admin_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

function ec_register_settings() {
	
	//register admin css
	wp_register_style( 'wpeasycart_admin_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/wpadmin_stylesheet.css' ) );
	wp_enqueue_style( 'wpeasycart_admin_css' );
		
	//register options
	$wpoptions = new ec_wpoptionset();
	$wpoptions->register_options();
	
}

function ec_create_menu() {
	//store settings menu
	add_menu_page( 'Store Settings', 'Store Settings', 'manage_options', 'ec_settings', 'ec_settings_page_callback', plugins_url( 'images/wp_16x16_icon.png', __FILE__ ) );
	add_submenu_page( 'ec_settings', 'Installation', 'Installation', 'manage_options', 'ec_install', 'ec_install_page_callback' );
	add_submenu_page( 'ec_settings', 'Basic Setup', 'Basic Setup', 'manage_options', 'ec_setup', 'ec_setup_page_callback' );
	add_submenu_page( 'ec_settings', 'Payment Info', 'Payment Info', 'manage_options', 'ec_payment', 'ec_payment_page_callback' );
	add_submenu_page( 'ec_settings', 'Social Icons', 'Social Icons', 'manage_options', 'ec_socialicons', 'ec_social_icons_page_callback' );
	add_submenu_page( 'ec_settings', 'Language Options', 'Language Options', 'manage_options', 'ec_language', 'ec_language_page_callback' );
	
	//administration menu
	add_menu_page( 'Administration', 'Administration', 'manage_options', 'ec_admin', 'ec_administration_callback', plugins_url( 'images/wp_16x16_icon.png', __FILE__ ) );
	add_submenu_page( 'ec_admin', 'Admin Console', 'Admin Console', 'manage_options', 'ec_adminconsole', 'ec_admin_console_page_callback' );
	add_submenu_page( 'ec_admin', 'Online Demos', 'Online Demos', 'manage_options', 'ec_demos', 'ec_demos_callback' );
	add_submenu_page( 'ec_admin', 'Users Guide', 'Users Guide', 'manage_options', 'ec_users_guide', 'ec_users_guide_callback' );
	
	//store design menu
	add_menu_page( 'Store Design', 'Store Design', 'manage_options', 'ec_design', 'ec_base_design_page_callback', plugins_url( 'images/wp_16x16_icon.png', __FILE__ ) );
	add_submenu_page( 'ec_design', 'Base Design', 'Base Design', 'manage_options', 'ec_design', 'ec_base_design_page_callback' );
	add_submenu_page( 'ec_design', 'Theme Options', 'Theme Options', 'manage_options', 'ec_theme_options', 'ec_theme_options_page_callback' );
	
	remove_submenu_page('ec_settings', 'ec_settings');
	remove_submenu_page('ec_admin', 'ec_admin');
	
	//Checklist
	add_menu_page( 'Setup Wizard', 'Setup Wizard', 'manage_options', 'ec_checklist', 'ec_checklist_page_callback', plugins_url( 'images/wp_16x16_icon.png', __FILE__ ) );
	
}

//store settings menu
function ec_settings_page_callback(){
	include("ec_install.php");
}

function ec_install_page_callback(){
	include("ec_install.php");
}

function ec_setup_page_callback(){
	include("store_setup.php");
}

function ec_payment_page_callback(){
	include("payment.php");
}

function ec_social_icons_page_callback(){
	include("social_icons.php");
}

function ec_language_page_callback(){
	include("language.php");
}


//administration menu
function ec_administration_callback() {
	include("demos.php");
}
function ec_admin_console_page_callback() {
	include("admin_console.php");
}
function ec_demos_callback() {
	include("demos.php");
}
function ec_users_guide_callback() {
	include("users_guide.php");
}

//store design menu
function ec_base_design_page_callback(){
	include("base_design.php");
}

// Admin per theme function is in wpeasycart.php

//store checklist menu
function ec_checklist_page_callback(){
	include("checklist.php");
}

?>