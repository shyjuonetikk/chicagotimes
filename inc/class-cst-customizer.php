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
	private $top_story_list_section_stories = array(
		'cst_homepage_top_story_headline_1' => true,
		'cst_homepage_top_story_headline_2' => true,
		'cst_homepage_top_story_headline_3' => true,
		'cst_homepage_top_story_headline_4' => true,
		'cst_homepage_top_story_headline_5' => true,
		'cst_homepage_top_story_headline_6' => true,
		'cst_homepage_top_story_headline_7' => true,
		'cst_homepage_top_story_headline_8' => true,
		'cst_homepage_top_story_headline_9' => true,
		'cst_homepage_top_story_headline_10' => true,
	);
	private $lower_section_stories = array(
		'cst_homepage_lower_section_headlines_1' => true,
		'cst_homepage_lower_section_headlines_2' => true,
		'cst_homepage_lower_section_headlines_3' => true,
		'cst_homepage_lower_section_headlines_4' => true,
		'cst_homepage_lower_section_headlines_5' => true,
	);
	private $featured_story_block_headlines = array(
		'featured_story_block_headlines_1' => true,
		'featured_story_block_headlines_2' => true,
		'featured_story_block_headlines_3' => true,
		'featured_story_block_headlines_4' => true,
		'featured_story_block_headlines_5' => true,
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
		add_action( 'customize_preview_init', [ $this, 'action_customizer_live_preview' ] );
	}

	public static function action_customizer_live_preview() {
		wp_enqueue_script(
			'chicagosuntimes-themecustomizer',
			get_template_directory_uri().'/assets/js/cst-customize-preview.js',
			array( 'jquery', 'customize-preview' ),
			'',
			true
		);
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
			'active_callback' => 'is_front_page',
		) );
		$wp_customize->add_section( 'hp_lead_related_stories', array(
			'title' => __( 'Hero related stories', 'chicagosuntimes' ),
			'description' => __( 'Choose related articles (only displayed if related checkbox selected)', 'chicagosuntimes' ),
			'priority' => 160,
			'capability' => $this->capability,
			'active_callback' => 'is_front_page',
		) );
		$wp_customize->add_section( 'hp_other_stories', array(
			'title' => __( 'Other lead stories', 'chicagosuntimes' ),
			'description' => __( 'Choose other lead stories', 'chicagosuntimes' ),
			'priority' => 170,
			'capability' => $this->capability,
			'active_callback' => 'is_front_page',
		) );
		$wp_customize->add_section( 'upper_section_stories', array(
			'title' => __( 'Upper section stories', 'chicagosuntimes' ),
			'description' => __( 'Choose upper section stories', 'chicagosuntimes' ),
			'priority' => 180,
			'capability' => $this->capability,
			'active_callback' => 'is_front_page',
		) );
		$wp_customize->add_section( 'featured_stories_section', array(
			'title' => __( 'Features', 'chicagosuntimes' ),
			'description' => __( 'Choose Features stories', 'chicagosuntimes' ),
			'priority' => 180,
			'capability' => $this->capability,
			'active_callback' => 'is_front_page',
		) );
		$wp_customize->add_section( 'lower_section_stories', array(
			'title' => __( 'Lower section stories', 'chicagosuntimes' ),
			'description' => __( 'Choose lower section stories', 'chicagosuntimes' ),
			'priority' => 180,
			'capability' => $this->capability,
			'active_callback' => 'is_front_page',
		) );
		$wp_customize->add_section( 'top_story_section_stories', array(
			'title' => __( 'Top stories', 'chicagosuntimes' ),
			'description' => __( 'Choose top stories', 'chicagosuntimes' ),
			'priority' => 180,
			'capability' => $this->capability,
			'active_callback' => 'is_front_page',
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
				'sanitize_callback' => 'absint',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $lead_story, array(
				'type' => 'cst_select_control',
				'priority' => 10,
				'section' => 'hp_lead_stories',
				'settings' => $lead_story,
				'label' => 0 === $lead_counter++ ? __( 'Hero Article', 'chicagosuntimes' ) : __( 'Lead Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => esc_attr__( '-Choose article-', 'chicagosuntimes' ),
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
					'label'          => __( 'Display the following hero story related articles?', 'chicagosuntimes' ),
					'section'        => 'hp_lead_stories',
					'settings'       => 'hero_related_posts',
					'type'           => 'checkbox',
					'priority' => 29,
				)
			)
		);
		$article_count = 1;
		foreach ( $this->related_hero_stories as $lead_story => $value ) {
			$wp_customize->add_setting( $lead_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $lead_story,
				'sanitize_callback' => 'absint',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $lead_story, array(
				'type' => 'cst_select_control',
				'priority' => 30,
				'section' => 'hp_lead_stories',
				'settings' => $lead_story,
				'label' => esc_attr__( 'Article ' . $article_count++ , 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => esc_attr__( '=Choose article=', 'chicagosuntimes' ),
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
				'sanitize_callback' => 'absint',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, array(
				'type'        => 'cst_select_control',
				'priority'    => 10,
				'section'     => 'hp_other_stories',
				'label'       => 0 === $lead_counter++ ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => esc_attr__( 'Choose other article', 'chicagosuntimes' ),
				),
			) ) );
		}
		/**
		 * Upper section based stories, custom heading
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
				'priority'    => 20,
				'section'     => 'upper_section_stories',
				'label'       => 0 === $lead_counter++ ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => esc_attr__( 'Choose other article' ),
				),
			) ) );
		}
		/**
		 * Top stories list of 10
		 */
		foreach ( $this->top_story_list_section_stories as $other_story => $value ) {
			$wp_customize->add_setting( $other_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $other_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, array(
				'type'        => 'cst_select_control',
				'priority'    => 20,
				'section'     => 'top_story_section_stories',
				'label'       => __( 'Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => esc_attr__( 'Choose top story article' ),
				),
			) ) );
		}
		$lead_counter = 0;
		/**
		 * Featured stories block
		 */
		foreach ( $this->featured_story_block_headlines as $other_story => $value ) {
			$wp_customize->add_setting( $other_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $other_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, array(
				'type'        => 'cst_select_control',
				'priority'    => 20,
				'section'     => 'featured_stories_section',
				'label'       => 0 === $lead_counter++ ? __( 'Lead Feature', 'chicagosuntimes' ) : __( 'Other Features', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => esc_attr__( 'Choose top story article' ),
				),
			) ) );
		}
		$lead_counter = 0;
		/**
		 * Lower section based stories, custom heading
		 */
		foreach ( $this->lower_section_stories as $other_story => $value ) {
			$wp_customize->add_setting( $other_story, array(
				'type' => 'theme_mod',
				'capability' => $this->capability,
				'default' => $other_story,
				'sanitize_callback' => 'esc_html',
				'transport' => $transport,
			) );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, array(
				'type'        => 'cst_select_control',
				'priority'    => 20,
				'section'     => 'lower_section_stories',
				'label'       => 0 === $lead_counter++ ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => array(
					'placeholder' => esc_attr__( 'Choose other article' ),
				),
			) ) );
		}

		/**
		 * Add a section choice for the five block of stories
		 * Perhaps create a CST version of this control for reuse
		 */
		$wp_customize->add_setting( 'upper_section_section_title', array(
			'type' => 'theme_mod',
			'capability' => $this->capability,
			'default' => 'upper_section_section_title',
			'sanitize_callback' => 'absint',
			'transport' => $transport,
		) );
		$choices = get_terms( array(
			'taxonomy' => 'cst_section',
			'hide_empty' => true,
			'fields' => 'id=>name',
		) );
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'upper_section_section_title', array(
			'type'        => 'select',
			'priority'    => 10,
			'section'     => 'upper_section_stories',
			'settings'    => 'upper_section_section_title',
			'choices'     => $choices,
			'label'       => __( 'Choose section title', 'chicagosuntimes' ),
		) ) );
		$wp_customize->add_setting( 'lower_section_section_title', array(
			'type' => 'theme_mod',
			'capability' => $this->capability,
			'default' => 'lower_section_section_title',
			'sanitize_callback' => 'absint',
			'transport' => $transport,
		) );
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'lower_section_section_title', array(
			'type'        => 'select',
			'priority'    => 10,
			'section'     => 'lower_section_stories',
			'settings'    => 'lower_section_section_title',
			'choices'     => $choices,
			'label'       => __( 'Choose section title', 'chicagosuntimes' ),
		) ) );
	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
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
				'selector'        => '.js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'render_callback' => array( $this, 'render_callback' ),
				'sanitize_callback' => 'absint',
			) );
		}
		foreach ( $this->other_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '.js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => array( $this, 'render_callback' ),
			) );
		}
		foreach ( $this->upper_section_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '.js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => array( $this, 'render_callback' ),
			) );
		}
		foreach ( $this->lower_section_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '.js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => array( $this, 'render_callback' ),
			) );
		}
		foreach ( $this->related_hero_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '.js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => array( $this, 'render_callback' ),
			) );
		}
		foreach ( $this->top_story_list_section_stories as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '.js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => array( $this, 'render_callback' ),
			) );
		}
		foreach ( $this->featured_story_block_headlines as $story => $value ) {
			$wp_customize->selective_refresh->add_partial( $story, array(
				'selector'        => '.js-' . str_replace( '_', '-', $story ),
				'settings'        => $story,
				'container_inclusive' => false,
				'sanitize_callback' => 'absint',
				'render_callback' => array( $this, 'render_callback' ),
			) );
		}
		$wp_customize->selective_refresh->add_partial( 'upper_section_section_title', array(
			'selector'        => '.js-upper-section-section-title',
			'settings'        => 'upper_section_section_title',
			'container_inclusive' => false,
			'sanitize_callback' => 'absint',
			'render_callback' => array( $this, 'render_callback' ),
		) );
		$wp_customize->selective_refresh->add_partial( 'lower_section_section_title', array(
			'selector'        => '.js-lower-section-section-title',
			'settings'        => 'lower_section_section_title',
			'container_inclusive' => false,
			'sanitize_callback' => 'absint',
			'render_callback' => array( $this, 'render_callback' ),
		) );
		$wp_customize->selective_refresh->add_partial( 'hero_related_posts', array(
			'selector'        => '.js-hero-related-posts',
			'settings'        => 'hero_related_posts',
			'container_inclusive' => false,
			'sanitize_callback' => 'absint',
			'render_callback' => array( $this, 'render_callback' ),
		) );
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
				return CST()->frontend->homepage_mini_story_lead( $element->id );
				break;
			case 'cst_homepage_other_headlines_2':
			case 'cst_homepage_other_headlines_3':
			case 'cst_homepage_other_headlines_4':
			case 'cst_homepage_other_headlines_5':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );
				return CST()->frontend->single_mini_story( $obj, 'regular', $element->id );
				break;
			case 'cst_homepage_top_story_headline_1':
			case 'cst_homepage_top_story_headline_2':
			case 'cst_homepage_top_story_headline_3':
			case 'cst_homepage_top_story_headline_4':
			case 'cst_homepage_top_story_headline_5':
			case 'cst_homepage_top_story_headline_6':
			case 'cst_homepage_top_story_headline_7':
			case 'cst_homepage_top_story_headline_8':
			case 'cst_homepage_top_story_headline_9':
			case 'cst_homepage_top_story_headline_10':
				return CST()->frontend->top_story( $element->id, 'columns' );
				break;
				break;
			case 'cst_homepage_section_headlines_2':
			case 'cst_homepage_section_headlines_3':
			case 'cst_homepage_section_headlines_4':
			case 'cst_homepage_section_headlines_5':
			case 'cst_homepage_lower_section_headlines_2':
			case 'cst_homepage_lower_section_headlines_3':
			case 'cst_homepage_lower_section_headlines_4':
			case 'cst_homepage_lower_section_headlines_5':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );
				return CST()->frontend->single_mini_story( $obj, 'regular', $element->id, 'yes' );
				break;
			case 'featured_story_block_headlines_1':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );
				return CST()->frontend->featured_story_lead( $obj );
				break;
			case 'hero_related_posts':
				return CST()->frontend->handle_related_content();
				break;
			case 'cst_homepage_related_headlines_one':
			case 'cst_homepage_related_headlines_two':
			case 'cst_homepage_related_headlines_three':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );
				return CST()->frontend->single_hero_related_story( $obj );
				break;
			case 'featured_story_block_headlines_2':
			case 'featured_story_block_headlines_3':
			case 'featured_story_block_headlines_4':
			case 'featured_story_block_headlines_5':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );
				return CST()->frontend->single_mini_story( $obj, 'vertical', $element->id, 'feature-landscape' );
				break;
			case 'upper_section_section_title':
			case 'lower_section_section_title':
				return CST()->frontend->render_section_title( $element->id );
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

			$search_query = new \WP_Query( $search_args );

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

	/**
	 * Getter for top stories array
	 * @return array
	 */
	public function get_top_stories() {
		return $this->top_story_list_section_stories;
	}

	/**
	 * Getter for upper section stories array
	 * @return array
	 */
	public function get_upper_section_stories() {
		return $this->upper_section_stories;
	}

	/**
	 * Getter for upper section stories array
	 * @return array
	 */
	public function get_hero_related_stories() {
		return $this->related_hero_stories;
	}

	/**
	 * Getter for lower section stories array
	 * @return array
	 */
	public function get_lower_section_stories() {
		return $this->lower_section_stories;
	}

	/**
	 * Getter for Features section array
	 * @return array
	 */
	public function get_featured_stories() {
		return $this->featured_story_block_headlines;
	}

	/**
	 * Getter for Other lead stories section array
	 * @return array
	 */
	public function get_other_headlines_stories() {
		return $this->other_stories;
	}
}