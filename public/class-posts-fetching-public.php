<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://karaliunas.dev
 * @since      1.0.0
 *
 * @package    Posts_Fetching
 * @subpackage Posts_Fetching/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Posts_Fetching
 * @subpackage Posts_Fetching/public
 * @author     Aivaras Karaliūnas <aivaras@karaliunas.dev>
 */
class Posts_Fetching_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/posts-fetching-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css', array(), $this->version, 'all' );
		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/posts-fetching-public.js', array( 'jquery' ), $this->version, false );

	}

	public static function init_posts_shortcode($atts)
	{
		add_shortcode('random_posts', [__NAMESPACE__ . '\\Posts_Fetching_Public', 'random_posts_shortcode'],);
	}

	public static function random_posts_shortcode($atts)
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
			$posts = Posts_Fetching_Public::fetch_posts($order, $count);
			set_transient($cache_key, $posts, 3600);
		}

		$output = '';
		ob_start();
		include plugin_dir_path( __FILE__ ) . 'partials/posts-fetching-public-display.php';
		$output = ob_get_clean();

		return $output;
	}

	public static function fetch_posts($order, $count) {
		$api_url = get_option('api_url', '');
		$response = wp_remote_get($api_url);
	
		if (is_wp_error($response)) {
			return __('Failed to fetch posts from the API.');
		}
	
		$posts = json_decode(wp_remote_retrieve_body($response), true);
	
		if (!$posts) {
			return __('No posts found.');
		}
	
		Posts_Fetching_Public::sort_posts($posts, $order);

		return array_slice($posts, 0, $count);
	}

	public static function sort_posts($posts, $order) {
		switch ($order) {
			case 'desc':
				usort($posts, fn($a, $b) => $a['id'] <=> $b['id']);
				break;
			
			case 'asc':
				usort($posts, fn($a, $b) => $b['id'] <=> $a['id']);
				break;
		}

		return $posts;
	}
}
