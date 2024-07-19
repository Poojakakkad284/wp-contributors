<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Post_Contributors' ) ) { 

	class WP_Post_Contributors {

		/**
		 * The single instance of WP_Post_Contributors.
		 *
		 * @var    object
		 * @access private
		 * @since  1.0.0
		 */
		private static $_instance = null;

		/**
		 * Constructor function.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function __construct () {      
			
		}	
		
		/**
		 * Load plugin localisation
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_plugin_textdomain () {
			$domain = 'wp-contributors';
			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		
		public function run() {

			if(is_admin()) {
				require_once( WPC_INCLUDES_DIR . '/class-wp-post-contributors-admin.php' );
				$admin = new WP_Post_Contributors_Admin();
				$this->admin = $admin;
				$this->admin->hooks();
			} else {
				require_once( WPC_INCLUDES_DIR . '/class-wp-post-contributors-public.php' );
				$public = new WP_Post_Contributors_Public();
				$this->public = $public;
				$this->public->hooks();
			}   

			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		}
		
	}

} // End if class_exists check.