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
	 * @param $wp_customize
	 */
	public function action_customize_register( $wp_customize ) {

		// Don't need to be able to edit blog title or description
		// and we don't want the homepage to change
		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'custom_css' );

		$wp_customize->add_section( 'hp_lead_stories', array(
			'title' => __( 'Lead Stories (3)' ),
			'description' => __( 'Choose stories' ),
			'panel' => '', // Not typically needed.
			'priority' => 160,
			'capability' => 'edit_theme_options',
			'theme_supports' => '', // Rarely needed.
		) );
		$wp_customize->add_setting( 'widget-lead-stories', array(
			'type' => 'theme_mod',
			'capability' => 'manage_options',
			'default' => '#ff2525',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( 'lead_story', array(
			'type' => 'input',
			'priority' => 10, // Within the section.
			'section' => 'hp_lead_stories', // Required, core or custom.
			'label' => __( 'Lead Story' ),
			'description' => __( 'This is the lead story.' ),
			'input_attrs' => array(
				'class' => 'cst-homepage-headlines-one',
				'style' => 'border: 1px solid #900',
				'placeholder' => __( 'mm/dd/yyyy' ),
			),
		) );
	}

}