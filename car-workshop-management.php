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
include_once plugin_dir_path(__FILE__) . 'includes/class-cwm-post-types.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-cwm-frontend.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-car-workshop.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-customer.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-vendor.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-ledger.php';

function cwm_enqueue_frontend_assets() {
    // Correct Bootstrap CSS and JS links
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    
    // Enqueue Custom CSS and JS
    wp_enqueue_style('cwm-custom-css', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('cwm-custom-js', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
	
	// Localize script to pass the AJAX URL to JavaScript
    wp_localize_script('cwm-custom-js', 'cwm_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'cwm_enqueue_frontend_assets');

function cwm_register_endpoints() {
    add_rewrite_rule('^customers/?$', 'index.php?cwm_page=customers', 'top');
    add_rewrite_rule('^invoices/?$', 'index.php?cwm_page=invoices', 'top');
    add_rewrite_rule('^vendors/?$', 'index.php?cwm_page=vendors', 'top');
    add_rewrite_rule('^ledgers/?$', 'index.php?cwm_page=ledgers', 'top');
}
add_action('init', 'cwm_register_endpoints');

function cwm_add_query_vars($vars) {
    $vars[] = 'cwm_page';
    return $vars;
}
add_filter('query_vars', 'cwm_add_query_vars');

function cwm_template_redirect() {
    $page = get_query_var('cwm_page');
    if ($page) {
        switch ($page) {
            case 'customers':
                include plugin_dir_path(__FILE__) . 'templates/customers.php';
                exit;
            case 'invoices':
                include plugin_dir_path(__FILE__) . 'templates/invoices.php';
                exit;
            case 'vendors':
                include plugin_dir_path(__FILE__) . 'templates/vendors.php';
                exit;
            case 'ledgers':
                include plugin_dir_path(__FILE__) . 'templates/ledgers.php';
                exit;
        }
    }
}
add_action('template_redirect', 'cwm_template_redirect');



// Initialize the plugin
function cwm_initialize() {
    // Add your initialization code here
}
add_action( 'init', 'cwm_initialize' );
?>
