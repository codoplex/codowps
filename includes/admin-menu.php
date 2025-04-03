<?php
// Admin Settings Page for GitHub Updates
function codowps_add_admin_menu() {
    // Add Settings Page as a Submenu under the CODO Plugins post type
    add_submenu_page(
        'edit.php?post_type=codowps', // Parent slug (custom post type slug)
        'Plugin Settings', // Page title
        'Settings', // Menu title
        'manage_options', // Capability required to access the page
        'codowps-settings', // Menu slug
        'codowps_settings_page' // Function to display the settings page
    );
}
add_action('admin_menu', 'codowps_add_admin_menu');

function codowps_settings_page() {
    ?>
    <div class="wrap">
        <h1>CODO WP Plugins - Settings</h1>
        <p>Check for the latest version from GitHub.</p>
        <button id="codowps-check-update" class="button button-primary">Check for Updates</button>
        <div id="codowps-update-result"></div>
    </div>
    <script>
        document.getElementById('codowps-check-update').addEventListener('click', function() {
            console.log('Check for Updates button clicked');

            // AJAX request to fetch data from the server
            var data = {
                action: 'codowps_check_for_update'
            };

            jQuery.post(ajaxurl, data, function(response) {
                console.log('Server response:', response);
                if (response.success) {
                    document.getElementById('codowps-update-result').innerHTML = 'Latest Version: ' + response.data.tag_name;
                } else {
                    document.getElementById('codowps-update-result').innerHTML = 'Error checking for updates. Please try again later.';
                }
            });
        });

    </script>
    <?php
}
