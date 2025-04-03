<?php

/**
 * Register Custom Post Type: Plugins
 */
function codowps_register_post_type() {
    $labels = array(
        'name'          => __('CODO Plugins', 'codowps'),
        'singular_name' => __('CODO Plugin', 'codowps'),
        'add_new'       => __('Add New Plugin', 'codowps'),
        'add_new_item'  => __('Add New Plugin', 'codowps'),
        'edit_item'     => __('Edit Plugin', 'codowps'),
    );

    $args = array(
        'label'               => __('Plugins', 'codowps'),
        'labels'              => $labels,
        'public'              => true,
        'menu_icon'           => 'dashicons-admin-plugins',
        'supports'            => array('title', 'editor', 'thumbnail'),
        'show_in_rest'        => true,
        'rewrite'             => array('slug' => 'codowps'),
    );

    register_post_type('codowps', $args);
}
add_action('init', 'codowps_register_post_type');

// Add Custom Columns to the 'codowps' Post Type List
function codowps_add_custom_columns($columns) {
    $columns['price_type'] = __('Price Type', 'codowps');
    $columns['source'] = __('Source', 'codowps');
    return $columns;
}
add_filter('manage_codowps_posts_columns', 'codowps_add_custom_columns');

// Populate Custom Columns
function codowps_custom_column_data($column, $post_id) {
    switch ($column) {
        case 'price_type':
            $price_type = get_post_meta($post_id, '_codowps_price_type', true);
            echo esc_html($price_type);
            break;
        case 'source':
            $source = get_post_meta($post_id, '_codowps_source', true);
            echo esc_html($source);
            break;
    }
}
add_action('manage_codowps_posts_custom_column', 'codowps_custom_column_data', 10, 2);

// Add Custom Filters to the Post List for 'CODO Plugins'
function codowps_add_filters_to_plugin_list() {
    global $typenow;

    // Check if we're on the correct post type page (i.e., 'codowps')
    if ($typenow == 'codowps') {
        // Get the current filter values from the URL (if any)
        $filter_price_type = isset($_GET['price_type']) ? $_GET['price_type'] : '';
        $filter_source = isset($_GET['source']) ? $_GET['source'] : '';

        // Price Type Filter Dropdown
        echo '<select name="price_type" id="price_type_filter">';
        echo '<option value="">All Price Types</option>';
        echo '<option value="free"' . selected($filter_price_type, 'free', false) . '>Free</option>';
        echo '<option value="paid"' . selected($filter_price_type, 'paid', false) . '>Paid</option>';
        echo '</select>';

        // Source Filter Dropdown
        echo '<select name="source" id="source_filter">';
        echo '<option value="">All Sources</option>';
        echo '<option value="codecanyon"' . selected($filter_source, 'codecanyon', false) . '>Codecanyon</option>';
        echo '<option value="wordpress"' . selected($filter_source, 'wordpress', false) . '>WordPress Repository</option>';
        echo '<option value="github"' . selected($filter_source, 'github', false) . '>GitHub</option>';
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'codowps_add_filters_to_plugin_list');

// Modify the Query to Filter Posts Based on Custom Fields (Price Type and Source)
function codowps_filter_plugin_list_query($query) {
    global $pagenow;

    // Only modify the query for the admin list of 'codowps' post type
    if (is_admin() && $query->is_main_query() && $pagenow == 'edit.php' && 'codowps' == $query->get('post_type')) {
        // Get filter values
        $filter_price_type = isset($_GET['price_type']) ? $_GET['price_type'] : '';
        $filter_source = isset($_GET['source']) ? $_GET['source'] : '';

        // Filter by Price Type
        if ($filter_price_type) {
            $query->set('meta_query', array(
                array(
                    'key'     => '_codowps_price_type',
                    'value'   => $filter_price_type,
                    'compare' => '='
                )
            ));
        }

        // Filter by Source
        if ($filter_source) {
            $meta_query = $query->get('meta_query', array());
            $meta_query[] = array(
                'key'     => '_codowps_source',
                'value'   => $filter_source,
                'compare' => '='
            );
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'codowps_filter_plugin_list_query');
