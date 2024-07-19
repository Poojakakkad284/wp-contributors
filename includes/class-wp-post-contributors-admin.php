<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// This class define all the functionality of public side of the plugin.
if ( ! class_exists( 'Wp_Post_Contributors_Admin' ) ) {    

	class Wp_Post_Contributors_Admin {

		public function __construct() {
			
		}
		
        /**
         * Define all the Actions for admin side of plugin
         * 
         * @return void
         *
         * @since 1.0.0
         *
         */
		public function hooks() {

            // Post Meta Box
            add_action('add_meta_boxes', array($this, 'wpc_add_meta_box'));

            // Save Post Meta Box
            add_action('save_post', array($this, 'wpc_save_meta_box'));

            // Admin CSS and javascript
            add_action( 'admin_enqueue_scripts', array( $this, 'wpc_admin_enqueue_styles' ) );
		}

        /**
         * Constributor meta box in Post
         * 
         * @since 1.0.0
         *
         */
        public function wpc_add_meta_box() {
            add_meta_box(
                'wp_contributors_meta_box',
                __('Contributors', 'wp-contributors'),
                array($this, 'wpc_meta_box_callback'),
                'post',
                'normal',
                'high'
            );

        }

        /**
         * Contributors meta box callback.
         *
         * @param WP_Post $post The post object.
         * @since 1.0.0
         *
         */
        public function wpc_meta_box_callback($post) {
            $users = get_users();
            $selected_contributors = get_post_meta($post->ID, '_wpc_contributors', true);
            wp_nonce_field('wpc_save_meta_box_data', 'wpc_meta_box_nonce');
            echo '<ul>';
            foreach ($users as $user) {
                $checked = is_array($selected_contributors) && in_array($user->ID, $selected_contributors) ? 'checked' : '';
                echo '<li><p><label><input type="checkbox" name="wp_contributors[]" value="' . esc_attr($user->ID) . '" ' . $checked . ' /> ' . esc_html($user->display_name) . '</label></p></li>';
            }
            echo '</ul>';
            if (empty($users)) {
                echo '<p>' . __('No users found.', 'wp-contributors') . '</p>';
            }
            echo '<p><small>' . __('Select the contributors for this post.', 'wp-contributors') . '</small></p>';
        }


        /**
         * Save contributors meta box data.
         *
         * @param int $post_id The post ID.
         * @since 1.0.0
         *
         */
        public function wpc_save_meta_box($post_id) {
            if (!isset($_POST['wpc_meta_box_nonce']) || !wp_verify_nonce($_POST['wpc_meta_box_nonce'], 'wpc_save_meta_box_data')) {
                return;
            }
        
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
        
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        
            if (!isset($_POST['wp_contributors'])) {
                delete_post_meta($post_id, '_wpc_contributors');
                return;
            }
        
            $contributors = array_map('intval', $_POST['wp_contributors']);
            update_post_meta($post_id, '_wpc_contributors', $contributors);
        }

        /**
         * Add admin CSS and Javascript.
         *
         * @param array $hooks The hooks.
         *
         */
        public function wpc_admin_enqueue_styles($hooks) {
            if($hooks == 'post.php') {
                wp_enqueue_style( WPC_SLUG. '-admin', WPC_ASSETS_URL. '/css/admin.css', array(), WPC_VERSION );
            }
        }
    }
}