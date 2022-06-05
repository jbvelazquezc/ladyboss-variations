<?php

/**
 *
 * @link       https://ladyboss.com/store
 * @since      1.0.0
 *
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/admin
 */

/**
 *
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/admin
 * @author     Jose Velazquez <jose@ladyboss.com>
 */
class Ladyboss_Variations_Admin {

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

		// Load CSS only on plugin admin page
		$screen = get_current_screen();

		if ( $screen->base === 'settings_page_ladyboss-variations-settings' && $_GET['page'] === 'ladyboss-variations/settings' ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ladyboss-variations-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		// Load JS only on plugin admin page
		$screen = get_current_screen();

		if ( $screen->base === 'settings_page_ladyboss-variations-settings' && $_GET['page'] === 'ladyboss-variations-settings' ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ladyboss-variations-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
		}

	}

	/**
	 * Add custom menu
	 *
	 * @since    1.0.0
	 */
	public function my_admin_menu() {

		// Add admin menu under "Settings"
		add_options_page( 'LadyBoss Variations', 'Variations', 'manage_options', 'ladyboss-variations-settings', array($this, 'myplugin_admin_page') );
		
	}

	/**
	 * Return admin view
	 *
	 * @since    1.0.0
	 */
	public function myplugin_admin_page() {

		//Return views
		require_once 'partials/ladyboss-variations-admin-display.php';

	}

	/**
	 * Register custom fields for plugin settings
	 *
	 * @since    1.0.0
	 */
	public function register_lb_variations_general_settings() {

		// Registers all settings for general settings page
		register_setting( 'lb-variation-settings', 'checkbox-setting');

		register_setting( 'lb-variation-settings', 'bgc-btn' );
		register_setting( 'lb-variation-settings', 'hov-btn' );
		register_setting( 'lb-variation-settings', 'selected-btn' );

		register_setting( 'lb-variation-settings', 'text-color-btn' );
		register_setting( 'lb-variation-settings', 'hov-text' );
		register_setting( 'lb-variation-settings', 'selected-text' );

	 }

	/**
	 * Add color picker
	 *
	 * @since    1.0.0
	 */
	public function add_color_picker() {
		 
		// Add the color picker css file       
		wp_enqueue_style( 'wp-color-picker' ); 

	}

	/**
	 * Plugin settings link
	 *
	 * @since    1.0.0
	 */
	public function settings_link( $links ) {

		// Build and escape the URL.
		$url = esc_url( add_query_arg( 'page', 'ladyboss-variations-settings', 'options-general.php' ) );

		$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';

		array_unshift( $links, $settings_link );

		return $links;

	}

}
