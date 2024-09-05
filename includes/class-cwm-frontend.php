<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary classes
include_once plugin_dir_path(__FILE__) . 'dashboard/class-dashboard-rendering.php';
include_once plugin_dir_path(__FILE__) . 'dashboard/class-modal-boxes.php';
include_once plugin_dir_path(__FILE__) . 'dashboard/class-forms-saving.php';
include_once plugin_dir_path(__FILE__) . 'dashboard/class-render-pages.php';

class CWM_Frontend {

    /**
     * Initialize the class and register the shortcode.
     */
    public function __construct() {
        add_shortcode('cwm_dashboard', array($this, 'render_dashboard'));
        add_action('wp_ajax_cwm_save_data', array('CWM_Forms_Saving', 'save_data'));
        add_action('wp_ajax_nopriv_cwm_save_data', array('CWM_Forms_Saving', 'save_data'));
        add_action('wp_ajax_cwm_form_handler', array($this, 'handle_ajax_form_submission'));
        add_action('wp_ajax_nopriv_cwm_form_handler', array($this, 'handle_ajax_form_submission'));
    }

    /**
     * Render the Dashboard with forms and routes.
     */
    public function render_dashboard() {
        $dashboard_rendering = new CWM_Dashboard_Rendering();
        $modals = new CWM_Modal_Boxes();
        
        // Use output buffering to capture the content
        ob_start();
        echo $dashboard_rendering->render_dashboard();
        echo $modals->render_modals();
        return ob_get_clean(); // Return the content to be displayed where the shortcode is used
    }

    /**
     * Handle AJAX form submissions and page loads.
     */
    public function handle_ajax_form_submission() {
        $page = isset($_POST['page']) ? sanitize_text_field($_POST['page']) : '';

        // Output buffering to ensure proper AJAX response
        ob_start();

        switch ($page) {
            case 'customers':
                CWM_Render_Pages::render_customers_page();
                break;
            case 'vendors':
                CWM_Render_Pages::render_vendors_page();
                break;
            case 'invoices':
                CWM_Render_Pages::render_invoices_page();
                break;
            default:
                CWM_Render_Pages::render_dashboard_page();
                break;
        }

        // Send the buffered content and end the AJAX request
        echo ob_get_clean();
        wp_die(); // Terminate immediately and return a proper response
    }
}

// Initialize the CWM_Frontend class
new CWM_Frontend();
?>
