<?php

/**
 *
 * @link              https://ladyboss.com/store
 * @since             1.0.0
 * @package           Ladyboss_Variations
 *
 * @wordpress-plugin
 * Plugin Name:       Ladyboss Variations
 * Plugin URI:        https://ladyboss.com/store
 * Description:       Plugin to add customizable buttons to variation products.
 * Version:           1.0.0
 * Author:            Jose Velazquez
 * Author URI:        https://ladyboss.com/store
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ladyboss-variations
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'LADYBOSS_VARIATIONS_VERSION', '1.0.2' );

function activate_ladyboss_variations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ladyboss-variations-activator.php';
	Ladyboss_Variations_Activator::activate();
}

function deactivate_ladyboss_variations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ladyboss-variations-deactivator.php';
	Ladyboss_Variations_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ladyboss_variations' );
register_deactivation_hook( __FILE__, 'deactivate_ladyboss_variations' );

require plugin_dir_path( __FILE__ ) . 'includes/class-ladyboss-variations.php';

/**
 *
 * @since    1.0.0
 */
function run_ladyboss_variations() {

	$plugin = new Ladyboss_Variations();
	$plugin->run();

}
run_ladyboss_variations();
