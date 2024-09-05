<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class CWM_Post_Types {

    /**
     * Initialize the class and register hooks.
     */
    public function __construct() {
        add_action('init', array($this, 'register_custom_post_types'));
    }

    /**
     * Register all custom post types for the Car Workshop Management system.
     */
    public function register_custom_post_types() {
        $post_types = array(
            'invoice' => array(
                'singular_name' => 'Invoice',
                'plural_name' => 'Invoices',
                'menu_icon' => 'dashicons-media-spreadsheet',
                'supports' => array('title', 'editor', 'custom-fields'),
            ),
            'vendor' => array(
                'singular_name' => 'Vendor',
                'plural_name' => 'Vendors',
                'menu_icon' => 'dashicons-store',
                'supports' => array('title', 'editor', 'custom-fields'),
            ),
            'customer' => array(
                'singular_name' => 'Customer',
                'plural_name' => 'Customers',
                'menu_icon' => 'dashicons-businessman',
                'supports' => array('title', 'editor', 'custom-fields'),
            ),
            'ledger' => array(
                'singular_name' => 'Ledger',
                'plural_name' => 'Ledgers',
                'menu_icon' => 'dashicons-book',
                'supports' => array('title', 'editor', 'custom-fields'),
            ),
        );

        foreach ($post_types as $post_type => $args) {
            $this->register_post_type($post_type, $args['singular_name'], $args['plural_name'], $args['menu_icon'], $args['supports']);
        }
    }

    /**
     * Register a custom post type.
     *
     * @param string $post_type Custom post type key.
     * @param string $singular_name Singular name for the custom post type.
     * @param string $plural_name Plural name for the custom post type.
     * @param string $menu_icon Menu icon for the custom post type.
     * @param array $supports Features supported by the custom post type.
     */
    private function register_post_type($post_type, $singular_name, $plural_name, $menu_icon, $supports) {
        $labels = array(
            'name'                  => $plural_name,
            'singular_name'         => $singular_name,
            'add_new'               => 'Add New',
            'add_new_item'          => 'Add New ' . $singular_name,
            'edit_item'             => 'Edit ' . $singular_name,
            'new_item'              => 'New ' . $singular_name,
            'view_item'             => 'View ' . $singular_name,
            'view_items'            => 'View ' . $plural_name,
            'search_items'          => 'Search ' . $plural_name,
            'not_found'             => 'No ' . strtolower($plural_name) . ' found',
            'not_found_in_trash'    => 'No ' . strtolower($plural_name) . ' found in Trash',
            'all_items'             => 'All ' . $plural_name,
            'archives'              => $singular_name . ' Archives',
            'attributes'            => $singular_name . ' Attributes',
            'insert_into_item'      => 'Insert into ' . strtolower($singular_name),
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'has_archive'           => true,
            'menu_icon'             => $menu_icon,
            'supports'              => $supports,
            'show_in_rest'          => true,
        );

        register_post_type($post_type, $args);
    }
}

// Initialize the class
new CWM_Post_Types();
?>