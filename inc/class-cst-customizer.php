<?php

/**
 * Customizations to the Customizer
 */
class CST_Customizer {

	private static $instance;
	private $lead_stories = array(
		'cst_homepage_headlines_one' => true,
		'cst_homepage_headlines_two' => true,
		'cst_homepage_headlines_three' => true,
	);
	private $other_stories = array(
		'cst_homepage_other_headlines_one' => true,
		'cst_homepage_other_headlines_two' => true,
		'cst_homepage_other_headlines_three' => true,
		'cst_homepage_other_headlines_four' => true,
		'cst_homepage_other_headlines_five' => true,
	);


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

		add_action( 'customize_register', [ $this, 'action_customize_register' ], 11 );
		add_action( 'customize_register', [ $this, 'action_customize_refresh' ], 11 );
		if ( method_exists( 'Jetpack_Custom_CSS', 'disable' ) ) {
			add_action( 'init', array( 'Jetpack_Custom_CSS', 'disable' ), 11 );
		}
//		add_action( 'customize_preview_init', [ $this, 'action_customize_preview_js' ] );
	}

	/**
	 * Register Customizer controls
	 * @param $wp_customize
	 */
	public function action_customize_register( $wp_customize ) {
		$transport = ( $wp_customize->selective_refresh ? 'postMessage' : 'refresh' );
		// Don't need to be able to edit blog title or description
		// and we don't want the homepage to change
		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'custom_css' );
		$wp_customize->add_section( 'hp_lead_stories', array(
			'title' => __( 'Lead Stories (3)' ),
			'description' => __( 'Choose lead articles' ),
			'panel' => '', // Not typically needed.
			'priority' => 160,
			'capability' => 'edit_theme_options',
			'theme_supports' => '', // Rarely needed.
		) );
		$wp_customize->add_section( 'hp_other_stories', array(
			'title' => __( 'Five block' ),
			'description' => __( 'Choose five block stories' ),
			'panel' => '', // Not typically needed.
			'priority' => 160,
			'capability' => 'edit_theme_options',
			'theme_supports' => '', // Rarely needed.
		) );
		foreach ( $this->lead_stories as $lead_story => $value ) {
			$wp_customize->add_setting( $lead_story, array(
				'type' => 'theme_mod',
				'capability' => 'manage_options',
				'default' => $lead_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_Hero_Select_Control( $wp_customize, $lead_story, array(
				'type' => 'cst_select_control',
				'priority' => 10, // Within the section.
				'section' => 'hp_lead_stories', // Required, core or custom.
				'settings' => $lead_story,
				'label' => __( 'Article' ),
				'input_attrs' => array(
					'style' => 'border: 1px solid #900',
					'placeholder' => __( '-Choose article-' ),
				),
			) ) );
		}
		foreach ( $this->other_stories as $other_story => $value ) {
			$wp_customize->add_setting( $other_story, array(
				'type' => 'theme_mod',
				'capability' => 'manage_options',
				'default' => $other_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( $other_story, array(
				'type'        => 'input',
				'priority'    => 10, // Within the section.
				'section'     => 'hp_other_stories', // Required, core or custom.
				'label'       => __( 'Article' ),
				'input_attrs' => array(
					'class'       => preg_replace( '/_/', '-', $other_story ),
					'style'       => 'border-bottom: 1px solid #f90',
					'placeholder' => __( 'Choose other article' ),
				),
			) );
		}
	}

	public function action_customize_refresh( WP_Customize_Manager $wp_customize ) {
		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		foreach ( $this->lead_stories as $lead_story => $value ) {
			$wp_customize->selective_refresh->add_partial( $lead_story, array(
				'selector'        => '#js-' . preg_replace( '/_/', '-', $lead_story ),
				'settings'        => $lead_story,
				'container_inclusive' => false,
				'render_callback' => [ $this, 'render_callback' ],
			) );
		}
		foreach ( $this->other_stories as $other_story => $value ) {
			$wp_customize->selective_refresh->add_partial( $other_story, array(
				'selector'        => '#js-' . preg_replace( '/_/', '-', $other_story ),
				'settings'        => $other_story,
				'container_inclusive' => false,
				'render_callback' => [ $this, 'render_callback' ],
			) );
		}
	}

	public function render_callback( $element ) {
		return get_theme_mod( $element->id );
	}
	/**
	 * Bind JS handlers to instantly live-preview changes.
	 */
	public function action_customize_preview_js() {
		//wp_enqueue_script( 'cst_customizer_homepage_headlines', esc_url( get_stylesheet_directory_uri() . '/assets/js/cst-customize-preview.js' ), array( 'customize-preview', 'jquery' ), '1.0', true );
	}

}