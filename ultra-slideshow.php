<?php
/**
 * Main Plugin File
 *
 * @package UltraSlideShow
 */

/**
 * Plugin Name:       Ultra Slideshow
 * Plugin URI:        https://ultradevs.com/plugins/ultra-slideshow
 * Description:       Ultra Slideshow is a modern sortable slide show plugin for WordPress.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            ultraDevs
 * Author URI:        https://ultradevs.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ultra-slideshow
 * Domain Path:       /languages
 */

// If this file is called directly, abort!
defined( 'ABSPATH' ) || die( 'bYe bYe!' );

// Constant.
define( 'ULTRA_SLIDESHOW_VERSION', '1.0.0' );
define( 'ULTRA_SLIDESHOW_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'ULTRA_SLIDESHOW_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'ULTRA_SLIDESHOW_ASSETS', ULTRA_SLIDESHOW_DIR_URL . 'assets/' );

/**
 * The code that runs during plugin activation.
 */
if ( ! function_exists( 'ultra_slideshow_activate' ) ) {
	function ultra_slideshow_activate() {
		flush_rewrite_rules();
	}
}
register_activation_hook( __FILE__, 'ultra_slideshow_activate' );

/**
 * The code that runs during plugin deactivation.
 */
if ( ! function_exists( 'ultra_slideshow_deactivate' ) ) {
	function ultra_slideshow_deactivate() {

	}
}
register_deactivation_hook( __FILE__, 'ultra_slideshow_deactivate' );

/**
 * Core plugin class
 */
require ULTRA_SLIDESHOW_DIR_PATH . 'includes/Init.php';

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_ultra_slideshow() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
		require ULTRA_SLIDESHOW_DIR_PATH . 'includes/appsero/src/Client.php';
    }

    $client = new Appsero\Client( 'c4481911-35b5-4fa9-89f4-411d2fe88e88', 'Ultra Slideshow', __FILE__ );

    // Active insights.
    $client->insights()->init();

}

appsero_init_tracker_ultra_slideshow();


/**
 * Begin execution of the plugin
 */
if ( ! function_exists( 'ultra_slideshow_run' ) ) {
	function ultra_slideshow_run() {
		$plugin = new UltraSlideshow\Init();
		$plugin->run();
	}
}
ultra_slideshow_run();
