<?php
/*
Plugin Name: Fetching Posts from API 
Plugin URI: https://karaliunas.dev
Description: Plugin for fetching and displaying posts via shortcode from an Custom API
Version: 1.0
Author: Aivaras Karaliūnas
Author URI: https://karaliunas.dev
*/

require_once( __DIR__ . '/settings.php' );

const CACHE_LIFETIME = 3600;

/**
 * Shortcode to display random posts from the API
 */
function custom_api_module_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'count' => get_option('posts_count', ''),
        'order' => get_option('default_order', '')
    ), $atts);

    $count = intval($atts['count']);
    $order = sanitize_text_field($atts['order']);
    $cache_key = 'random_posts_' . $count . '_' . $order;
    $cached_posts = get_transient($cache_key);

    if ($cached_posts !== false) {
        $posts = $cached_posts;
    } else {
        $api_url = get_option('api_url', '');
        $response = wp_remote_get($api_url);
    
        if (is_wp_error($response)) {
            return 'Failed to fetch posts from the API.';
        }
    
        $posts = json_decode(wp_remote_retrieve_body($response), true);
    
        if (!$posts) {
            return 'No posts found.';
        }
    
        switch ($order) {
            case 'desc':
                usort($posts, fn($a, $b) => $a['id'] <=> $b['id']);
                break;
            
            case 'acs':
                usort($posts, fn($a, $b) => $b['id'] <=> $a['id']);
                break;
        }
    
        $posts = array_slice($posts, 0, $count);
        set_transient($cache_key, $posts, CACHE_LIFETIME);
    }

    $output = '<ul class="grid gap-4">';
    foreach ($posts as $post) {
        $output .= '<li class="border border-black p-4 rounded">';
            $output .= '<h3 class="text-lg font-bold normal-case ">' . esc_html($post['title']) . '</h3>';
            $output .= '<p class="mt-2 normal-case ">' . esc_html($post['body']) . '</p>';
        $output .= '</li>';
    }
    $output .= '</ul>';

    return $output;
}

add_shortcode('random_posts', 'custom_api_module_shortcode');

/**
 * Enqueue tailwind styles for posts display
 */
function enqueue_tailwind_styles() {
    wp_enqueue_style( 'tailwind-styles', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_tailwind_styles' );

// Callback function to add a settings link in the plugin list
function my_plugin_add_settings_link($links)
{
    $settings_link = '<a href="' . admin_url('admin.php?page=posts-fetching-settings') . '">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_posts-fetching/posts-fetching.php', 'my_plugin_add_settings_link');