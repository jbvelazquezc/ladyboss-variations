<?php

/**
 *
 * @link       https://ladyboss.com/store
 * @since      1.0.0
 *
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/includes
 */

/**
 *
 * @since      1.0.0
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/includes
 * @author     Jose Velazquez <jose@ladyboss.com>
 */
class Ladyboss_Variations {

	/**
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ladyboss_Variations_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'LADYBOSS_VARIATIONS_VERSION' ) ) {
			$this->version = LADYBOSS_VARIATIONS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ladyboss-variations';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ladyboss-variations-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ladyboss-variations-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ladyboss-variations-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ladyboss-variations-public.php';

		$this->loader = new Ladyboss_Variations_Loader();

	}

	/**
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ladyboss_Variations_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ladyboss_Variations_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add color picker files
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'add_color_picker' );

		// Add admin menu items
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'my_admin_menu' );

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'settings_link' );

		// Register our general settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_lb_variations_general_settings' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ladyboss_Variations_Public( $this->get_plugin_name(), $this->get_version() );

		// Register css only when plugin is present
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'register_styles' );

		// Register js only when plugin is present
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'register_scripts' );

		// Add the function to show the attributes
		$this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public, 'show_attributes' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ladyboss_Variations_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
