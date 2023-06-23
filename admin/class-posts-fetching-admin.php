<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://karaliunas.dev
 * @since      1.0.0
 *
 * @package    Posts_Fetching
 * @subpackage Posts_Fetching/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Posts_Fetching
 * @subpackage Posts_Fetching/admin
 * @author     Aivaras Karaliūnas <aivaras@karaliunas.dev>
 */
class Posts_Fetching_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Posts_Fetching_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Posts_Fetching_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/posts-fetching-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Posts_Fetching_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Posts_Fetching_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/posts-fetching-admin.js', array( 'jquery' ), $this->version, false );

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

		include_once plugin_dir_path( __FILE__ ) . 'partials/posts-fetching-admin-display.php';
	}

	// Callback function to add the settings page to the WordPress admin menu
	function posts_fetching_add_settings_page() {
		add_menu_page(
			'Posts fetching',
			'Posts fetching',
			'manage_options',
			'posts-fetching-settings',
			[__NAMESPACE__ . '\\Posts_Fetching_Admin', 'posts_fetching_settings_page'],
			'dashicons-admin-generic',
			99
		);
	}

	function my_plugin_add_settings_link($links)
	{
		$settings_link = '<a href="' . admin_url('admin.php?page=posts-fetching-settings') . '">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}
	}
