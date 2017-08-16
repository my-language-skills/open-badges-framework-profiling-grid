<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mylanguageskills.wordpress.com/
 * @since             1.0.0
 * @package           B4l_Portfolio
 *
 * @wordpress-plugin
 * Plugin Name:       Badges4Languages-Portfolio
 * Plugin URI:        https://github.com/Badges4Languages/Badges4Languages-Portfolio
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            MyLanguageSkills
 * Author URI:        https://mylanguageskills.wordpress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       b4l-portfolio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-b4l-portfolio-activator.php
 */
function activate_b4l_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b4l-portfolio-activator.php';
	B4l_Portfolio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-b4l-portfolio-deactivator.php
 */
function deactivate_b4l_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b4l-portfolio-deactivator.php';
	B4l_Portfolio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_b4l_portfolio' );
register_deactivation_hook( __FILE__, 'deactivate_b4l_portfolio' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-b4l-portfolio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_b4l_portfolio() {

	$plugin = new B4l_Portfolio();
	$plugin->run();

}
run_b4l_portfolio();
