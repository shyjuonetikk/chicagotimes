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
	private $related_hero_stories = array(
		'cst_homepage_related_headlines_one' => true,
		'cst_homepage_related_headlines_two' => true,
		'cst_homepage_related_headlines_three' => true,
	);
	private $other_stories = array(
		'cst_homepage_other_headlines_1' => true,
		'cst_homepage_other_headlines_2' => true,
		'cst_homepage_other_headlines_3' => true,
		'cst_homepage_other_headlines_4' => true,
		'cst_homepage_other_headlines_5' => true,
	);
	private $upper_section_stories = array(
		'cst_homepage_section_headlines_1' => true,
		'cst_homepage_section_headlines_2' => true,
		'cst_homepage_section_headlines_3' => true,
		'cst_homepage_section_headlines_4' => true,
		'cst_homepage_section_headlines_5' => true,
	);
	private $capability = 'edit_others_posts';

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
		add_action( 'wp_ajax_cst_customizer_control_homepage_headlines', [ $this, 'action_get_posts' ], 11 );
		add_action( 'customize_register', [ $this, 'action_customize_register' ], 11 );
		add_action( 'customize_register', [ $this, 'action_customize_refresh' ], 11 );
		if ( method_exists( 'Jetpack_Custom_CSS', 'disable' ) ) {
			add_action( 'init', array( 'Jetpack_Custom_CSS', 'disable' ), 11 );
		}
	}

	/**
	 * Register Customizer Panels, sections and controls
	 *
	 * Homepage Lead Stories
	 * Homepage Other Stories
	 * Homepage Section stories
	 *
	 * @param $wp_customize
	 */
	public function action_customize_register( \WP_Customize_Manager $wp_customize ) {
		$transport = ( $wp_customize->selective_refresh ? 'postMessage' : 'refresh' );
		// Don't need to be able to edit blog title or description
		// and we don't want the homepage to change
		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'custom_css' );
		/**
		 * Add sections we want
		 */
		$wp_customize->add_section( 'hp_lead_stories', array(
			'title' => __( 'Hero and lead stories', 'chicagosuntimes' ),
			'description' => __( 'Choose lead articles', 'chicagosuntimes' ),
			'priority' => 160,
			'capability' => $this->capability,
		) );
		$wp_customize->add_section( 'hp_lead_related_stories', array(
			'title' => __( 'Hero related stories', 'chicagosuntimes' ),
			'description' => __( 'Choose related articles (only displayed if related checkbox selected)', 'chicagosuntimes' ),
			'priority' => 160,
			'capability' => $this->capability,
		) );
		$wp_customize->add_section( 'hp_other_stories', array(
			'title' => __( 'Other lead stories' ),
			'description' => __( 'Choose other lead stories' ),
			'priority' => 170,
			'capability' => $this->capability,
		) );
		$wp_customize->add_section( 'upper_section_stories', array(
			'title' => __( 'Upper section stories' ),
			'description' => __( 'Choose upper section stories' ),
			'priority' => 180,
			'capability' => $this->capability,
		) );
		/**
		 * Add settings within each section
		 */
		$lead_counter = 0;
		foreach ( $this->lead_stories as $lead_story => $value ) {
			$wp_customize->add_setting( $lead_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $lead_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $lead_story, array(
				'type' => 'cst_select_control',
				'priority' => 10,
				'section' => 'hp_lead_stories',
				'settings' => $lead_story,
				'label' => 0 === $lead_counter++ ? __( 'Hero Article', 'chicagosuntimes' ) : __( 'Lead Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => __( '-Choose article-' ),
				),
			) ) );
		}
		/**
		 * Related stories, checkbox and select2 custom control
		 */
		$wp_customize->add_setting( 'hero_related_posts', array(
			'type' => 'theme_mod',
			'capability' => $this->capability,
			'default' => 'hero_related_posts',
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport' => $transport,
		) );
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'hero_related_posts', array(
					'label'          => __( 'Choose and display related posts?', 'chicagosuntimes' ),
					'section'        => 'hp_lead_stories',
					'settings'       => 'hero_related_posts',
					'type'           => 'checkbox',
					'priority' => 9,
				)
			)
		);
		foreach ( $this->related_hero_stories as $lead_story => $value ) {
			$wp_customize->add_setting( $lead_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $lead_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $lead_story, array(
				'type' => 'cst_select_control',
				'priority' => 11,
				'section' => 'hp_lead_related_stories',
				'settings' => $lead_story,
				'label' => __( 'Related to Hero Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => __( '=Choose article=' ),
				),
			) ) );
		}
		/**
		 * Other stories
		 */
		$lead_counter = 0;
		foreach ( $this->other_stories as $other_story => $value ) {
			$wp_customize->add_setting( $other_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $other_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, array(
				'type'        => 'cst_select_control',
				'priority'    => 10,
				'section'     => 'hp_other_stories',
				'label'       => 0 === $lead_counter++ ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => __( 'Choose other article' ),
				),
			) ) );
		}
		/**
		 * Upper section based stories
		 */
		$lead_counter = 0;
		foreach ( $this->upper_section_stories as $other_story => $value ) {
			$wp_customize->add_setting( $other_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $other_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, array(
				'type'        => 'cst_select_control',
				'priority'    => 10,
				'section'     => 'upper_section_stories',
				'label'       => 0 === $lead_counter++ ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => __( 'Choose other article' ),
				),
			) ) );
		}
	}

	/**
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * Setup the partials
	 */
	public function action_customize_refresh( WP_Customize_Manager $wp_customize ) {
		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		foreach ( $this->lead_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '#js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'render_callback' => [ $this, 'render_callback' ],
				'sanitize_callback' => 'absint',
			) );
		}
		foreach ( $this->other_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '#js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => [ $this, 'render_callback' ],
			) );
		}
		foreach ( $this->upper_section_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '#js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => [ $this, 'render_callback' ],
			) );
		}
		foreach ( $this->related_hero_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '#js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => [ $this, 'render_callback' ],
			) );
		}
	}

	/**
	 * @param $element
	 *
	 * @return string
	 *
	 * Decide and trigger content rendering function
	 */
	public function render_callback( $element ) {
		switch ( $element->id ) {
			case 'cst_homepage_headlines_one':
				return CST()->frontend->homepage_hero_story( $element->id );
				break;
			case 'cst_homepage_headlines_two':
			case 'cst_homepage_headlines_three':
				return CST()->frontend->homepage_lead_story( $element->id );
				break;
			case 'cst_homepage_other_headlines_1':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'cst_homepage_other_headlines_1' ) );
				if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
					$author = CST()->frontend->hp_get_article_authors( $obj );
				}
				return CST()->frontend->homepage_mini_story_lead( $obj, $author );
				break;
			case 'cst_homepage_other_headlines_2':
			case 'cst_homepage_other_headlines_3':
			case 'cst_homepage_other_headlines_4':
			case 'cst_homepage_other_headlines_5':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );
				return CST()->frontend->single_mini_story( $obj, 'regular', $element->id );
				break;
			case 'cst_homepage_related_headlines_one':
			case 'cst_homepage_related_headlines_two':
			case 'cst_homepage_related_headlines_three':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );
				return CST()->frontend->single_hero_related_story( $obj );
				break;
		}
		return '';
	}

	/**
	 * Get all published posts to display in Select2 dropdown
	 */
	public function action_get_posts() {
		global $wp_customize;
		while ( 0 !== ob_get_level() ) {
			ob_end_clean();
		}
		if ( ! wp_verify_nonce( $_GET['nonce'], 'cst_customizer_control_homepage_headlines' )
			 || ! current_user_can( 'edit_others_posts' )
		) {
			wp_send_json_error( array( 'code' => 'bad_nonce' ), 400 );
		}

		$term = sanitize_text_field( $_GET['searchTerm'] );

		if ( '' !== $term && strlen( $term ) >= 3 ) {
			$search_args = array(
				'post_type'     => CST()->get_post_types(),
				's'             => $term,
				'post_status'   => 'publish',
				'no_found_rows' => true,
			);

			$search_query = new WP_Query( $search_args );

			$returning = array();
			$posts     = array();

			if ( '' !== $term && strlen( $term ) >= 3 && $search_query->have_posts() ) {

				while ( $search_query->have_posts() ) : $search_query->the_post();
					$obj = get_post( get_the_ID() );
					if ( $obj ) {
						$content_type  = get_post_type( $obj->ID );
						$posts['id']   = get_the_ID();
						$posts['text'] = $obj->post_title . ' [' . $content_type . ']';
						array_push( $returning, $posts );
					}

				endwhile;
				if ( ! empty( $wp_customize ) ) {
					foreach ( $wp_customize->settings() as $setting ) {
						/**
						 * Setting.
						 *
						 * @var \WP_Customize_Setting $setting
						 */
						$setting->preview();
					}
				}
			}
			if ( is_wp_error( $returning ) ) {
				wp_send_json_error( array(
					'code' => $returning->get_error_code(),
					'message' => $returning->get_error_message(),
					'data' => $returning->get_error_data(),
				), 400 );
			} else {
				//wp_send_json_success( $returning ); sends array vs object (that json_encode sends)
				echo json_encode( $returning );
				exit();
			}
		}
	}

	public function sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}