<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Facebook_Popup_Likebox_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ays-facebook-popup-likebox',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
