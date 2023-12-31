<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://karaliunas.dev
 * @since             1.0.0
 * @package           Posts_Fetching
 *
 * @wordpress-plugin
 * Plugin Name:       Fetching Posts from API
 * Plugin URI:        https://https://karaliunas.dev
 * Description:       Plugin for fetching and displaying posts via shortcode from an Custom API
 * Version:           1.0.0
 * Author:            Aivaras Karaliūnas
 * Author URI:        https://https://karaliunas.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       posts-fetching
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'POSTS_FETCHING_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-posts-fetching-activator.php
 */
function activate_posts_fetching() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-posts-fetching-activator.php';
	Posts_Fetching_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-posts-fetching-deactivator.php
 */
function deactivate_posts_fetching() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-posts-fetching-deactivator.php';
	Posts_Fetching_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_posts_fetching' );
register_deactivation_hook( __FILE__, 'deactivate_posts_fetching' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-posts-fetching.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_posts_fetching() {

	$plugin = new Posts_Fetching();
	$plugin->run();

}
run_posts_fetching();
