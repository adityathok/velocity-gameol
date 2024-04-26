<?php
/**
 * The plugin Gameol for Velocity Developer
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/velocitydeveloper/velocity_gameol
 * @since             1.0.0
 * @package           velocity_gameol
 *
 * @wordpress-plugin
 * Plugin Name:       Velocity Gameol
 * Plugin URI:        https://velocitydeveloper.com/
 * Description:       Plugin Topup Game Online by Velocity Developer
 * Version:           1.0.0
 * Author:            Velocity Developer
 * Author URI:        https://velocitydeveloper.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       velocity-gameol
 * Domain Path:       /languages
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Define constants
 *
 * @since 1.0.0
*/
if (!defined('VELOCITY_GAMEOL_VERSION')) define('VELOCITY_GAMEOL_VERSION', '1.0.0'); // Plugin version constant
if (!defined('VELOCITY_GAMEOL_PLUGIN')) define('VELOCITY_GAMEOL_PLUGIN', trim(dirname(plugin_basename(__FILE__)), '/')); // Name of the plugin folder eg - 'velocity-gameol'
if (!defined('VELOCITY_GAMEOL_PLUGIN_DIR'))	define('VELOCITY_GAMEOL_PLUGIN_DIR', plugin_dir_path(__FILE__)); // Plugin directory absolute path with the trailing slash. Useful for using with includes eg - /var/www/html/wp-content/plugins/velocity-gameol/
if (!defined('VELOCITY_GAMEOL_PLUGIN_URL'))	define('VELOCITY_GAMEOL_PLUGIN_URL', plugin_dir_url(__FILE__)); // URL to the plugin folder with the trailing slash. Useful for referencing src eg - http://localhost/wp/wp-content/plugins/velocity-gameol/
    
// Load everything
$includes = [
	'inc/games-post-type.php',
	'inc/promogame-post-type.php',
	'inc/ordergame-post-type.php',
	'inc/pengaturan.php',
	'inc/form-topup-game.php',
	'inc/form-cek-transaksi-game.php',
	'inc/ajax-formtopupgame.php',
	'inc/ajax-promogame.php',
];
foreach ($includes as $include) {
	require_once(VELOCITY_GAMEOL_PLUGIN_DIR . $include);
}

/**
 * function register asset css and js to frontend public.
 *
 */
 if (!function_exists('velocitygameol_enqueue_scripts')) {
	function velocitygameol_enqueue_scripts()
	{	
		// Get the version.
		$the_version = VELOCITY_GAMEOL_VERSION;
		if (defined('WP_DEBUG') && true === WP_DEBUG) {
			$the_version = $the_version.'.'.time();
		}
		$the_version = $the_version.'.'.time();

		wp_enqueue_script('jquery');
		wp_enqueue_script('velocitygameol-script', VELOCITY_GAMEOL_PLUGIN_URL . 'js/script.js', array('jquery'), $the_version, true);
		wp_localize_script(
			'velocitygameol-script',
			'velocitygameol',
			array(
				'ajaxUrl' => admin_url('admin-ajax.php'),
				'restUrl' => rest_url(),
			),
		);

	}
	add_action('wp_enqueue_scripts', 'velocitygameol_enqueue_scripts',25);
}