<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// This class define all the functionality of public side of the plugin.
if ( ! class_exists( 'Wp_Post_Contributors_Public' ) ) {    

	class Wp_Post_Contributors_Public {

		public function __construct() {
			
		}
		
		/**
		 * Define all the Actions for Front side of plugin
		 * 
		 * @return void
         *
         * @since 1.0.0
		 *  
		 */
		public function hooks() {

			// Display Contributors on single post
			add_filter('the_content', array($this,'wpc_display_contributors'));

			// Front CSS and javascript
			add_action( 'wp_enqueue_scripts', array( $this, 'wpc_enqueue_styles_scripts_front' ) );

        }

		/**
		 * Display Contributors on single post
		 * 
		 * @param string $content
		 * @return string
		 * 
		 * @since 1.0.0
		 *
		 */
		public function wpc_display_contributors($content) {
			// TODO: Implement wpc_display_contributors() method.
			if (is_single()) {
				global $post;
				$contributors = get_post_meta($post->ID, '_wpc_contributors', true);
				
				if ($contributors) {
					$content .= '<div class="wp-contributors-box"><h3>' . __('Contributors', 'wp_contributors') . '</h3><ul>';
					foreach ($contributors as $contributor_id) {
						$user_info = get_userdata($contributor_id);
						$avatar = get_avatar($contributor_id, 32);
						$user_link = get_author_posts_url($contributor_id);
						$content .= '<li><a href="' . esc_url($user_link) . '">' . $avatar . esc_html($user_info->display_name) . '</a></li>';
					}
					$content .= '</ul></div>';
				}
			}
			return $content;
		}

		/**
		 * Front CSS and javascript
		 * 
		 * @since 1.0.0
		 *
		 */
		public function wpc_enqueue_styles_scripts_front() {
			// TODO: Implement wpc_enqueue_styles_scripts_front() method.
			wp_enqueue_style( WPC_SLUG . '-frontend',  WPC_ASSETS_URL. '/css/frontend.css', array(), WPC_VERSION );
		}
    }
}