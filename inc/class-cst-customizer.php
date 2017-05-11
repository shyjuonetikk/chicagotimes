<?php

/**
 * Customizations to the Customizer
 */
class CST_Customizer {

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Customizer;
			self::$instance->setup_actions();
		}
		return self::$instance;
	}

	/**
	 * Set up Customizer actions
	 */
	private function setup_actions() {

		add_action( 'customize_register', array( $this, 'action_customize_register' ), 11 );
		if ( method_exists( 'Jetpack_Custom_CSS', 'disable' ) ) {
			add_action( 'init', array( 'Jetpack_Custom_CSS', 'disable' ), 11 );
		}
	}

	/**
	 * Register Customizer controls
	 */
	public function action_customize_register( $customize ) {

		// Don't need to be able to edit blog title or description
		// and we don't want the homepage to change
		$customize->remove_section( 'title_tagline' );
		$customize->remove_section( 'static_front_page' );
		$customize->remove_section( 'colors' );
		$customize->remove_section( 'custom_css' );

	}

}