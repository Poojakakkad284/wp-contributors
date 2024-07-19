<?php
/**
 * Plugin Name:       Post Contributors
 * Description: A plugin to manage post contributors.
 * Author:            Pooja Kakkad
 * Version:           1.0.0
 * Text Domain:       wp-contributors
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Domain Path:       /languages
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package           wp-contributors
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The code that runs during plugin activation.
 */
function activate_wp_post_contributors() {
	
}
register_activation_hook( __FILE__, 'activate_wp_post_contributors' );

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_wp_post_contributors() {
	
}
register_deactivation_hook( __FILE__, 'deactivate_wp_post_contributors' );

require plugin_dir_path( __FILE__ ) . 'includes/class-wp-post-contributors.php';

function run_wp_post_contributors() {

    define( 'WPC_VERSION', '1.0.0' );
    define( 'WPC_DIR', plugin_dir_path( __FILE__ ) );
    define( 'WPC_URL', plugin_dir_url( __FILE__ ) );
    define( 'WPC_FILE', __FILE__ );
    define( 'WPC_BASENAME', plugin_basename( __FILE__ ) );  
    define( 'WPC_SLUG', 'wp-contributors' );
    define( 'WPC_TEXT_DOMAIN', 'wp-contributors' );
    define( 'WPC_INCLUDES_DIR', plugin_dir_path( __FILE__ )."includes" );
    define( 'WPC_ASSETS_DIR', plugin_dir_path( __FILE__ )."assets" );
    define( 'WPC_ASSETS_URL', plugin_dir_url( __FILE__ )."assets" );

    
	$plugin = new WP_Post_Contributors();
	$plugin->run();

}
run_wp_post_contributors();
?>