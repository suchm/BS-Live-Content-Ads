<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://michaelsuch.co.uk/
 * @since      1.0.0
 *
 * @package    Blueshift_Live_Content
 * @subpackage Blueshift_Live_Content/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Blueshift_Live_Content
 * @subpackage Blueshift_Live_Content/includes
 * @author     Mike Such <mikesuchyo@yahoo.com>
 */
class Blueshift_Live_Content_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'blueshift-live-content',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
