<?php

/**
 * Modifications to the WordPress.com VIP Liveblog add-on
 */
class CST_Liveblog {

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Liveblog;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
		}
		return self::$instance;
	}

	/**
	 * Set up Liveblog actions
	 */
	private function setup_actions() {

		add_action( 'after_liveblog_init', array( $this, 'action_after_liveblog_init' ) );

	}

	/**
	 * Set up Liveblog filters
	 */
	private function setup_filters() {

		add_filter( 'liveblog_entry_avatar_size', function(){
			return 48;
		});

	}

	/**
	 * Register post support for liveblog
	 */
	public function action_after_liveblog_init() {
		add_post_type_support( 'cst_liveblog', 'liveblog' );

		// Need to trigger this after the main query has been modified, not before
		// Infinite Scroll responses are returned on 'template_redirect'
		if ( class_exists( 'WPCOM_Liveblog' ) && isset( $_GET['infinity'] ) && 'scrolling' == $_GET['infinity'] ) {
			remove_filter( 'template_redirect', array( 'WPCOM_Liveblog', 'handle_request' ) );
			add_action( 'wp_enqueue_scripts', array( 'WPCOM_Liveblog', 'handle_request' ), 1 );
		}

	}

}