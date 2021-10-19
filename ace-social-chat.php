<?php

/**
 * The plugin bootstrap file
 *
 * Chat with your website visitors via whatsapp.
 * Show a chat button on the bottom of your site and communicate with your customers with Whatsapp Chat Multi Agent wordpress plugin.
 *
 * @link              http://acewebx.com
 * @since             1.0.0
 * @package           Ace-Social-Chat
 *
 * @wordpress-plugin
 * Plugin Name:       Ace Social Chat
 * Plugin URI:        http://acewebx.com
 * Description:       Chat with your website visitors via whatsapp. Show a chat button on the bottom of your site and communicate with your customers with Ace Social Chat wordpress plugin.
 * Version:           1.0.1
 * Author:            AceWebX Team
 * Author URI:        http://acewebx.com/contact-us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Ace-Social-Chat
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
define( 'Ace_Social_Chat_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-whatsapp-chat-multi-agent-activator.php
 */
function activate_ace_social_chat_multi_agent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-whatsapp-chat-multi-agent-activator.php';
	Whatsapp_Chat_Multi_Agent_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-whatsapp-chat-multi-agent-deactivator.php
 */
function deactivate_ace_social_chat_multi_agent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-whatsapp-chat-multi-agent-deactivator.php';
	Whatsapp_Chat_Multi_Agent_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_whatsapp_chat_multi_agent' );
register_deactivation_hook( __FILE__, 'deactivate_whatsapp_chat_multi_agent' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-whatsapp-chat-multi-agent.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ace_social_chat_multi_agent() {

	$plugin = new Ace_Social_Chat_Multi_Agent();
	$plugin->run();

}
run_ace_social_chat_multi_agent();
