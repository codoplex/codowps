<?php
/**
 * Plugin Name: CODO WP Plugins
 * Plugin URI: https://github.com/codoplex/codowps
 * Description: Lists and filters all WordPress plugins you have developed, hosted on Codecanyon, WordPress.org, or GitHub.
 * Version: 1.0.1
 * Author: Junaid Hassan
 * Author URI: https://codoplex.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: codowps
 * GitHub Plugin URI: https://github.com/codoplex/codowps
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('CODOWPS_VERSION', '1.0.1');
define('CODOWPS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CODOWPS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CODOWPS_GITHUB_REPO', 'https://api.github.com/repos/codoplex/codowps/releases/latest');


// Enqueue Styles and Scripts
function codowps_enqueue_assets() {
    wp_enqueue_style('codowps-style', CODOWPS_PLUGIN_URL . 'assets/style.css');
    wp_enqueue_script('codowps-script', CODOWPS_PLUGIN_URL . 'assets/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'codowps_enqueue_assets');

// Include necessary files
require_once(CODOWPS_PLUGIN_DIR . 'includes/post-type.php');
require_once(CODOWPS_PLUGIN_DIR . 'includes/meta-boxes.php');
require_once(CODOWPS_PLUGIN_DIR . 'includes/plugin-showcase.php');
require_once(CODOWPS_PLUGIN_DIR . 'includes/admin-menu.php');
require_once(CODOWPS_PLUGIN_DIR . 'includes/update-check.php');