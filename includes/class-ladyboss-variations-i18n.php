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
class Ladyboss_Variations_i18n {

	/**
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ladyboss-variations',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
