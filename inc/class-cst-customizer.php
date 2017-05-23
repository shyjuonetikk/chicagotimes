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

	}

	/**
	 * Register Customizer controls
	 */
	public function action_customize_register( $customize ) {

		// Don't need to be able to edit blog title or description
		// and we don't want the homepage to change
		$customize->remove_section( 'title_tagline' );
		$customize->remove_section( 'static_front_page' );

		$customize->add_section( 'cst_site_header', array(
			'title'          => esc_html__( 'Site Header', 'chicagosuntimes' ),
			'priority'       => 35,
			'capability'     => 'customize',
		) );
	 
		$customize->add_setting( 'cst_headline_template', array(
			'default'        => 'cst_images',
			'capability'     => 'customize',
		) );
	 
		$customize->add_control( 'cst_headline_template', array(
			'label'   => esc_html__( 'Featured articles template:', 'chicagosuntimes' ),
			'section' => 'cst_site_header',
			'type'    => 'select',
			'choices'    => array(
				'cst_images' => esc_html__( 'Images', 'chicagosuntimes' ),
				'cst_list' => esc_html__( 'List', 'chicagosuntimes' ),
				),
		) );

	}

}