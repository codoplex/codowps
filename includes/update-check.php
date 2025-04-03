<?php
// Add AJAX action for logged-in users
function codowps_check_for_update() {
    $response = wp_remote_get(CODOWPS_GITHUB_REPO); // Fetch the latest release from GitHub

    if (is_wp_error($response)) {
        wp_send_json_error(); // Send error response if there's a problem with the request
    }

    $data = json_decode(wp_remote_retrieve_body($response), true); // Decode the JSON response
    if (isset($data['tag_name'])) {
        wp_send_json_success($data); // Send success response with version data
    } else {
        wp_send_json_error(); // Send error if the data is not available
    }
}
add_action('wp_ajax_codowps_check_for_update', 'codowps_check_for_update');

