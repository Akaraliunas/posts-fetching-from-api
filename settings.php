<?php
// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Callback function to display the settings page
function posts_fetching_settings_page() {
    // Check if the form is submitted
    if (isset($_POST['posts_fetching_settings_submit'])) {
        // Save the settings values
        update_option('api_url', $_POST['api_url']);
        update_option('posts_count', $_POST['posts_count']);
        update_option('default_order', $_POST['default_order']);

        // Display a success message
        echo '<div class="notice notice-success"><p>Settings saved successfully.</p></div>';
    }

    // Get the current settings values
    $api_url = get_option('api_url', '');
    $posts_count = get_option('posts_count', '');
    $default_order = get_option('default_order', '');

    // Add your settings HTML markup here
    echo '<div class="wrap">';
    echo '<h1>Posts fetching settings</h1><br>';

    echo '<form method="post" action="">';
    echo '<label for="api_url">API url:</label>';
    echo '<input type="text" id="api_url" name="api_url" value="' . esc_attr($api_url) . '" /><br>';

    echo '<form method="post" action="">';
    echo '<label for="posts_count">Posts count:</label>';
    echo '<input type="text" id="posts_count" name="posts_count" value="' . esc_attr($posts_count) . '" /><br>';

    echo '<label for="default_order">Default order:</label>';
    echo '<input type="text" id="default_order" name="default_order" value="' . esc_attr($default_order) . '" /><br>';

    echo '<br><input type="submit" name="posts_fetching_settings_submit" class="button button-primary" value="Save Settings" />';
    echo '</form>';

    echo '</div>';
}

// Callback function to add the settings page to the WordPress admin menu
function my_module_add_settings_page() {
    add_menu_page(
        'Posts fetching',
        'Posts fetching',
        'manage_options',
        'posts-fetching-settings',
        'posts_fetching_settings_page',
        'dashicons-admin-generic',
        99
    );
}
add_action( 'admin_menu', 'my_module_add_settings_page' );
