<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Whatsapp_Chat_Multi_Agent
 * @subpackage Whatsapp_Chat_Multi_Agent/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Whatsapp_Chat_Multi_Agent
 * @subpackage Whatsapp_Chat_Multi_Agent/includes
 * @author     Acewebx <webbninja01@gmail.com>
 */
class Ace_Social_Chat_Multi_Agent_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'whatsapp-chat-multi-agent',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
