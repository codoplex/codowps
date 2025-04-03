<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Remove all plugin data
delete_option('codowps_settings');
