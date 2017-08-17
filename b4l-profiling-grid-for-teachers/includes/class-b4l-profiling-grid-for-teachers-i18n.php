<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mylanguageskills.wordpress.com/
 * @since      1.0.0
 *
 * @package    B4l_Profiling_Grid_For_Teachers
 * @subpackage B4l_Profiling_Grid_For_Teachers/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    B4l_Profiling_Grid_For_Teachers
 * @subpackage B4l_Profiling_Grid_For_Teachers/includes
 * @author     My Language Skills <colomett@gmail.com>
 */
class B4l_Profiling_Grid_For_Teachers_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'b4l-profiling-grid-for-teachers',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
