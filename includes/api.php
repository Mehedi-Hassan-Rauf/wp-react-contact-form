<?php
function wp_react_contact_form_submit() {
    $params = json_decode(file_get_contents("php://input"), true);

    // Server-side validation
    if (empty($params['name']) || empty($params['email']) || empty($params['message'])) {
        return new WP_REST_Response(['message' => 'All fields are required'], 400);
    }
    if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
        return new WP_REST_Response(['message' => 'Invalid email address'], 400);
    }

    // Store form data in WordPress database
    $post_id = wp_insert_post([
        'post_title'   => sanitize_text_field($params['name']),
        'post_content' => sanitize_textarea_field($params['message']),
        'post_status'  => 'publish',
        'post_type'    => 'contact_submission',
        'meta_input'   => ['email' => sanitize_email($params['email'])],
    ]);

    if ($post_id) {
        return new WP_REST_Response(['message' => 'Form submitted successfully'], 200);
    } else {
        return new WP_REST_Response(['message' => 'Failed to submit form'], 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('wp-react-form', '/submit', [
        'methods'  => 'POST',
        'callback' => 'wp_react_contact_form_submit',
        'permission_callback' => '__return_true',
    ]);
});
