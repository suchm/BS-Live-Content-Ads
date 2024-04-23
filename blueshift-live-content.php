<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://michaelsuch.co.uk/
 * @since             1.0.0
 * @package           Blueshift_Live_Content
 *
 * @wordpress-plugin
 * Plugin Name:       Blueshift Live Content
 * Plugin URI:        https://https://github.com/suchm/blueshift-live-content
 * Description:       This plugin populates Blueshift Live content on your website pages
 * Version:           1.0.0
 * Author:            Mike Such
 * Author URI:        https://https://michaelsuch.co.uk//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       blueshift-live-content
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
define( 'BLUESHIFT_LIVE_CONTENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-blueshift-live-content-activator.php
 */
function activate_blueshift_live_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blueshift-live-content-activator.php';
	Blueshift_Live_Content_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-blueshift-live-content-deactivator.php
 */
function deactivate_blueshift_live_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blueshift-live-content-deactivator.php';
	Blueshift_Live_Content_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_blueshift_live_content' );
register_deactivation_hook( __FILE__, 'deactivate_blueshift_live_content' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-blueshift-live-content.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_blueshift_live_content() {

	$plugin = new Blueshift_Live_Content();
	$plugin->run();

}
run_blueshift_live_content();
