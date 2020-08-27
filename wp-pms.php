<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.google.com
 * @since             1.0.0
 * @package           Wp_Pms
 *
 * @wordpress-plugin
 * Plugin Name:       PMS
 * Plugin URI:        http://www.github.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Bojken Sina
 * Author URI:        http://www.google.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-pms
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
define( 'WP_PMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-pms-activator.php
 */
function activate_wp_pms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-pms-activator.php';
	$wp_pms_activator = new Wp_Pms_Activator();
	$wp_pms_activator -> activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-pms-deactivator.php
 */
function deactivate_wp_pms() {
	require_once plugin_dir_path( __FILE__ ) .'includes/class-wp-pms-deactivator.php';
	$wp_pms_deactivator = new Wp_Pms_Deactivator();
}

register_activation_hook( __FILE__, 'activate_wp_pms' );
register_deactivation_hook( __FILE__, 'deactivate_wp_pms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-pms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_pms() {

	$plugin = new Wp_Pms();
	$plugin->run();

}
run_wp_pms();
