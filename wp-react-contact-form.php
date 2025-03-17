<?php

if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts
function wprcf_enqueue_assets() {
    wp_enqueue_script(
        'wp-react-contact-form-script',
        plugin_dir_url(__FILE__) . 'build/index.js',
        ['wp-element'],
        filemtime(plugin_dir_path(__FILE__) . 'build/index.js'),
        true
    );

    wp_localize_script('wp-react-contact-form-script', 'wpReactForm', [
        'ajaxUrl' => rest_url('wp-react-form/submit')
    ]);
}
add_action('wp_enqueue_scripts', 'wprcf_enqueue_assets');

// Register shortcode
function wprcf_shortcode() {
    return '<div id="wp-react-contact-form"></div>';
}
add_shortcode('wp_react_contact_form', 'wprcf_shortcode');

// Include API for form submission
require_once plugin_dir_path(__FILE__) . 'includes/api.php';
