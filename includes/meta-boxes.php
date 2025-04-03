<?php

/**
 * Register Meta Fields for Source and Price Type
 */
function codowps_add_meta_boxes() {
    add_meta_box(
        'codowps_meta_box',
        __('Plugin Details', 'codowps'),
        'codowps_meta_box_callback',
        'codowps',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'codowps_add_meta_boxes');

function codowps_meta_box_callback($post) {
    $plugin_type = get_post_meta($post->ID, '_codowps_type', true);
    $plugin_source = get_post_meta($post->ID, '_codowps_source', true);
    ?>
    <p>
        <label for="codowps_type"><?php _e('Type:', 'codowps'); ?></label>
        <select id="codowps_type" name="codowps_type">
            <option value="free" <?php selected($plugin_type, 'free'); ?>><?php _e('Free', 'codowps'); ?></option>
            <option value="paid" <?php selected($plugin_type, 'paid'); ?>><?php _e('Paid', 'codowps'); ?></option>
        </select>
    </p>
    <p>
        <label for="codowps_source"><?php _e('Source:', 'codowps'); ?></label>
        <select id="codowps_source" name="codowps_source">
            <option value="codecanyon" <?php selected($plugin_source, 'codecanyon'); ?>><?php _e('Codecanyon', 'codowps'); ?></option>
            <option value="wordpress" <?php selected($plugin_source, 'wordpress'); ?>><?php _e('WordPress Repository', 'codowps'); ?></option>
            <option value="github" <?php selected($plugin_source, 'github'); ?>><?php _e('GitHub', 'codowps'); ?></option>
        </select>
    </p>
    <?php
}

function codowps_save_meta_fields($post_id) {
    if (isset($_POST['codowps_type'])) {
        update_post_meta($post_id, '_codowps_type', sanitize_text_field($_POST['codowps_type']));
    }
    if (isset($_POST['codowps_source'])) {
        update_post_meta($post_id, '_codowps_source', sanitize_text_field($_POST['codowps_source']));
    }
}
add_action('save_post', 'codowps_save_meta_fields');
