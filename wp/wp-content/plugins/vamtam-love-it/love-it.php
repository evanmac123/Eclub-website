<?php
/*
Plugin Name: Love It (Maintained by Vamtam)
Plugin URI: http://vamtam.com
Description: Adds a "Love It" link to posts, pages, and custom post types
Version: 1.0.0
Author: Vamtam, Pippin Williamson
Author URI: http://vamtam.com
*/

/***************************
* constants
***************************/

$file = __FILE__;
if ( isset( $mu_plugin ) ) {
	$file = $mu_plugin;
}
if ( isset( $network_plugin ) ) {
	$file = $network_plugin;
}
if ( isset( $plugin ) ) {
	$file = $plugin;
}

if(!defined('WPV_LI_BASE_DIR')) {
	define('WPV_LI_BASE_DIR', dirname($file));
}
if(!defined('WPV_LI_BASE_URL')) {
	define('WPV_LI_BASE_URL', plugin_dir_url($file));
}

if ( !class_exists( 'Vamtam_Updates' ) )
	require 'vamtam-updates/class-vamtam-updates.php';

$plugin_slug = basename(dirname(__FILE__));
$plugin_file = basename(__FILE__);

new Vamtam_Updates( array(
	'slug' => $plugin_slug,
	'main_file' => $plugin_slug . '/' . $plugin_file,
) );

/***************************
* language files
***************************/
function wpv_li_load_text_domain() {
	load_plugin_textdomain( 'love_it', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'wpv_li_load_text_domain' );

/***************************
* includes
***************************/
if(file_exists(WPV_LI_BASE_DIR . '/includes/display-functions.php')) {
	include(WPV_LI_BASE_DIR . '/includes/display-functions.php');
	include(WPV_LI_BASE_DIR . '/includes/love-functions.php');
	include(WPV_LI_BASE_DIR . '/includes/scripts.php');
}
