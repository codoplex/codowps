<?php

/**
 * Shortcode: Display Plugins
 */
function codowps_shortcode($atts) {
    ob_start();
    $args = array('post_type' => 'codowps', 'posts_per_page' => -1);
    $query = new WP_Query($args);
    ?>
    <div class="codowps-filters">
        <select id="codowps-filter-type">
            <option value="all"><?php _e('All Types', 'codowps'); ?></option>
            <option value="free"><?php _e('Free', 'codowps'); ?></option>
            <option value="paid"><?php _e('Paid', 'codowps'); ?></option>
        </select>
        <select id="codowps-filter-source">
            <option value="all"><?php _e('All Sources', 'codowps'); ?></option>
            <option value="codecanyon"><?php _e('Codecanyon', 'codowps'); ?></option>
            <option value="wordpress"><?php _e('WordPress Repository', 'codowps'); ?></option>
            <option value="github"><?php _e('GitHub', 'codowps'); ?></option>
        </select>
    </div>
    <div class="codowps-list">
        <?php while ($query->have_posts()) : $query->the_post();
            $type = get_post_meta(get_the_ID(), '_codowps_type', true);
            $source = get_post_meta(get_the_ID(), '_codowps_source', true);
            ?>
            <div class="codowps-plugin-item" data-type="<?php echo esc_attr($type); ?>" data-source="<?php echo esc_attr($source); ?>">
                <h3><?php the_title(); ?></h3>
                <p><?php the_content(); ?></p>
                <strong><?php echo ucfirst($type); ?> - <?php echo ucfirst($source); ?></strong>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <script src="<?php echo CODO_WPPLUGINS_PLUGIN_URL . 'assets/script.js'; ?>"></script>
    <?php
    return ob_get_clean();
}
add_shortcode('codowps_plugin_showcase', 'codowps_shortcode');
