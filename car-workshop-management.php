<?php
/*
Plugin Name: Car Workshop Management
Description: A simple car workshop management system for WordPress operated from the frontend.
Version: 1.0
Author: Hassan Ejaz
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Include required files
include_once plugin_dir_path(__FILE__) . 'includes/class-car-workshop.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-customer.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-vendor.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-ledger.php';

// Initialize the plugin
function cwm_initialize() {
    // Add your initialization code here
}
add_action( 'init', 'cwm_initialize' );
?>
