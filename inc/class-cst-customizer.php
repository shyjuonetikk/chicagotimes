<?php

/**
 * Customizations to the Customizer
 */
class CST_Customizer {

	private static $instance;
	private $column_one_stories = [
		'cst_homepage_headlines_one'   => true,
		'cst_homepage_headlines_two'   => true,
		'cst_homepage_headlines_three' => true,
	];
	private $related_column_one_stories = [
		'cst_homepage_related_headlines_one'   => true,
		'cst_homepage_related_headlines_two'   => true,
		'cst_homepage_related_headlines_three' => true,
	];
	private $other_stories = [
		'cst_homepage_other_headlines_1' => true,
		'cst_homepage_other_headlines_2' => true,
		'cst_homepage_other_headlines_3' => true,
		'cst_homepage_other_headlines_4' => true,
		'cst_homepage_other_headlines_5' => true,
	];
	private $upper_section_stories = [
		'cst_homepage_section_headlines_1' => true,
		'cst_homepage_section_headlines_2' => true,
		'cst_homepage_section_headlines_3' => true,
		'cst_homepage_section_headlines_4' => true,
		'cst_homepage_section_headlines_5' => true,
	];
	private $politics_list_section_stories = [
		'cst_homepage_top_story_headline_1'  => true,
		'cst_homepage_top_story_headline_2'  => true,
		'cst_homepage_top_story_headline_3'  => true,
		'cst_homepage_top_story_headline_4'  => true,
		'cst_homepage_top_story_headline_5'  => true,
		'cst_homepage_top_story_headline_6'  => true,
		'cst_homepage_top_story_headline_7'  => true,
		'cst_homepage_top_story_headline_8'  => true,
		'cst_homepage_top_story_headline_9'  => true,
		'cst_homepage_top_story_headline_10' => true,
	];
	private $widget_top_story_list_stub = 'cst_homepage_widget_more_headlines_';
	private $lower_section_stories = [
		'cst_homepage_lower_section_headlines_1' => true,
		'cst_homepage_lower_section_headlines_2' => true,
		'cst_homepage_lower_section_headlines_3' => true,
		'cst_homepage_lower_section_headlines_4' => true,
		'cst_homepage_lower_section_headlines_5' => true,
	];
	private $entertainment_section_stories = [
		'cst_homepage_entertainment_section_headlines_1' => true,
		'cst_homepage_entertainment_section_headlines_2' => true,
		'cst_homepage_entertainment_section_headlines_3' => true,
		'cst_homepage_entertainment_section_headlines_4' => true,
		'cst_homepage_entertainment_section_headlines_5' => true,
	];
	private $featured_obits_section_stories = [
		'cst_featured_obits_section_headlines_1' => true,
		'cst_featured_obits_section_headlines_2' => true,
		'cst_featured_obits_section_headlines_3' => true,
		'cst_featured_obits_section_headlines_4' => true,
		'cst_featured_obits_section_headlines_5' => true,
	];
	private $podcast_section_stories = [
		'cst_podcast_section_headlines_1' => true,
		'cst_podcast_section_headlines_2' => true,
		'cst_podcast_section_headlines_3' => true,
		'cst_podcast_section_headlines_4' => true,
		'cst_podcast_section_headlines_5' => true,
	];
	private $featured_story_block_headlines = [
		'featured_story_block_headlines_1' => true,
		'featured_story_block_headlines_2' => true,
		'featured_story_block_headlines_3' => true,
		'featured_story_block_headlines_4' => true,
		'featured_story_block_headlines_5' => true,
	];
	private $capability = 'edit_others_posts';
	private $sports_section_choices, $section_choices;

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
		add_action( 'customize_preview_init', [ $this, 'action_customizer_live_preview' ] );
	}

	public function action_customizer_live_preview() {
		wp_enqueue_script(
			'chicagosuntimes-themecustomizer',
			get_theme_file_uri( '/assets/js/cst-customize-preview.js' ),
			[ 'customize-preview' ],
			'1.0',
			true
		);
		wp_enqueue_style(
			'chicagosuntimes-customizer-preview',
			get_theme_file_uri( '/assets/css/cst-customizer-preview.css' )
		);
	}

	/**
	 * Register Customizer Panels, sections and controls
	 *
	 * Homepage Column 1 Stories
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
		$wp_customize->add_section( 'hp_lead_stories', [
			'title'           => __( 'Column 1 stories', 'chicagosuntimes' ),
			'description'     => __( 'Choose column 1 stories', 'chicagosuntimes' ),
			'priority'        => 160,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'hp_lead_related_stories', [
			'title'           => __( 'Related stories', 'chicagosuntimes' ),
			'description'     => __( 'Choose related stories (only displayed if related checkbox selected)', 'chicagosuntimes' ),
			'priority'        => 170,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'hp_other_stories', [
			'title'           => __( 'Photo stories', 'chicagosuntimes' ),
			'description'     => __( 'Choose photo stories', 'chicagosuntimes' ),
			'priority'        => 180,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'hp_chartbeat_stories', [
			'title'           => __( 'Chartbeat settings', 'chicagosuntimes' ),
			'description'     => __( 'Configure Chartbeat', 'chicagosuntimes' ),
			'priority'        => 190,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'upper_section_stories', [
			'title'           => __( 'Sports', 'chicagosuntimes' ),
			'description'     => __( 'Choose sports stories', 'chicagosuntimes' ),
			'priority'        => 200,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'politics_section_stories', [
			'title'           => __( 'Politics', 'chicagosuntimes' ),
			'description'     => __( 'Choose politics stories', 'chicagosuntimes' ),
			'priority'        => 210,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'featured_stories_section', [
			'title'           => __( 'Features', 'chicagosuntimes' ),
			'description'     => __( 'Choose Features stories', 'chicagosuntimes' ),
			'priority'        => 220,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'lower_section_stories', [
			'title'           => __( 'Crime', 'chicagosuntimes' ),
			'description'     => __( 'Choose crime stories', 'chicagosuntimes' ),
			'priority'        => 230,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'entertainment_section_stories', [
			'title'           => __( 'Entertainment', 'chicagosuntimes' ),
			'description'     => __( 'Choose entertainment stories', 'chicagosuntimes' ),
			'priority'        => 240,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'featured_obits_section_stories', [
			'title'           => __( 'Featured Obits', 'chicagosuntimes' ),
			'description'     => __( 'Choose Featured obit', 'chicagosuntimes' ),
			'priority'        => 250,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'podcast_section_stories', [
			'title'           => __( 'Podcasts', 'chicagosuntimes' ),
			'description'     => __( 'Choose podcast stories', 'chicagosuntimes' ),
			'priority'        => 260,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		] );
		$wp_customize->add_section( 'hp_footer_section_ads', array(
			'title'           => __( 'Homepage Footer', 'chicagosuntimes' ),
			'description'     => __( 'Choose HP footer ads', 'chicagosuntimes' ),
			'priority'        => 270,
			'capability'      => $this->capability,
			'active_callback' => 'is_front_page',
		) );
		/**
		 * Add settings within each section
		 */
		$lead_counter       = 1;
		$column_one_counter = 1;
		foreach ( array_keys( $this->column_one_stories ) as $lead_story ) {
			$this->set_setting( $wp_customize, $lead_story, 'absint' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $lead_story, [
				'type'        => 'cst_select_control',
				'priority'    => 10 + $lead_counter,
				'section'     => 'hp_lead_stories',
				'settings'    => $lead_story,
				'label'       => __( 'Column 1 Story ' . $column_one_counter, 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( '-Choose article-', 'chicagosuntimes' ),
				],
			] ) );
			if ( 1 === $lead_counter ) {
				/**
				 * Related stories, checkbox and select2 custom control
				 */
				$this->set_setting( $wp_customize, 'hero_related_posts', [ $this, 'sanitize_checkbox' ] );
				$wp_customize->add_control(
					new \WP_Customize_Control(
						$wp_customize, 'hero_related_posts', [
							'label'    => __( 'Display the following Column 1 related stories?', 'chicagosuntimes' ),
							'section'  => 'hp_lead_stories',
							'settings' => 'hero_related_posts',
							'type'     => 'checkbox',
							'priority' => 11,
						]
					)
				);
			}
			$lead_counter += 4;
			$column_one_counter ++;
		}
		$article_count = 1;
		foreach ( array_keys( $this->related_column_one_stories ) as $lead_story ) {
			$this->set_setting( $wp_customize, $lead_story, 'absint' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $lead_story, [
				'type'        => 'cst_select_control',
				'priority'    => 11 + $article_count,
				'section'     => 'hp_lead_stories',
				'settings'    => $lead_story,
				'label'       => esc_attr__( 'Related story ' . $article_count ++, 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( '=Choose related story=', 'chicagosuntimes' ),
				],
			] ) );
		}
		/**
		 * Photo stories
		 */
		$photo_story_counter = 1;
		foreach ( array_keys( $this->other_stories ) as $other_story ) {
			$this->set_setting( $wp_customize, $other_story, 'absint' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 10,
				'settings'    => $other_story,
				'section'     => 'hp_other_stories',
				'label'       => __( 'Photo story ' . $photo_story_counter, 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => __( 'Choose photo story', 'chicagosuntimes' ),
				],
			] ) );
			$photo_story_counter ++;
		}
		/**
		 * Chartbeat
		 */
		$this->set_setting( $wp_customize, 'chartbeat_config', 'absint' );
		$this->set_setting( $wp_customize, 'chartbeat_section_title', 'esc_html' );
		$wp_customize->add_control( 'chartbeat_config', [
			'type'     => 'radio',
			'priority' => 25,
			'section'  => 'hp_chartbeat_stories',
			'label'    => __( 'What should Chartbeat return?', 'chicagosuntimes' ),
			'choices'  => [
				1 => 'Concurrents (default)',
				2 => 'Returning',
				3 => 'Engaged time',
			]
		] );
		$wp_customize->add_control( 'chartbeat_section_title', [
			'type'     => 'text',
			'priority' => 20,
			'section'  => 'hp_chartbeat_stories',
			'label'    => __( 'Choose title', 'chicagosuntimes' ),
		] );
		/**
		 * Upper - Sports - section based stories, custom heading
		 */
		$this->_generate_choices();
		$sports_customizer = [
			'sport_section_lead'    => [
				'section'  => 'upper_section_stories',
				'label'    => 'Choose sport lead section',
				'priority' => 19,
				'choices'  => $this->section_choices,
			],
			'sport_other_section_1' => [
				'section'  => 'upper_section_stories',
				'label'    => 'Choose sport other section 1',
				'priority' => 20,
				'choices'  => $this->sports_section_choices,
			],
			'sport_other_section_2' => [
				'section'  => 'upper_section_stories',
				'label'    => 'Choose sport other section 2',
				'priority' => 21,
				'choices'  => $this->sports_section_choices,
			],
			'sport_other_section_3' => [
				'section'  => 'upper_section_stories',
				'label'    => 'Choose sport other section 3',
				'priority' => 22,
				'choices'  => $this->sports_section_choices,
			],
			'sport_other_section_4' => [
				'section'  => 'upper_section_stories',
				'label'    => 'Choose sport other section 4',
				'priority' => 23,
				'choices'  => $this->sports_section_choices,
			],
		];
		$lead_counter      = 0;
		$sports_keys       = array_keys( $sports_customizer );
		foreach ( array_keys( $this->upper_section_stories ) as $other_story ) {
			$this->set_setting( $wp_customize, $other_story, 'esc_html' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 20 + $lead_counter,
				'section'     => 'upper_section_stories',
				'label'       => 0 === $lead_counter ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder'          => esc_attr__( 'Choose other article' ),
					'data-related-section' => $sports_keys[ $lead_counter ],
				],
			] ) );
			$lead_counter ++;
		}

		foreach ( $sports_customizer as $sports_customizer_id => $settings ) {
			$this->set_setting( $wp_customize, $sports_customizer_id, 'absint' );
			$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, $sports_customizer_id, [
				'type'     => 'select',
				'priority' => $settings['priority'],
				'section'  => $settings['section'],
				'settings' => $sports_customizer_id,
				'choices'  => $settings['choices'],
				'label'    => __( $settings['label'], 'chicagosuntimes' ),
			] ) );
		}

		/**
		 * Top stories list of 10
		 */
		foreach ( array_keys( $this->politics_list_section_stories ) as $other_story ) {
			$this->set_setting( $wp_customize, $other_story, 'esc_html' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 20,
				'section'     => 'politics_section_stories',
				'label'       => __( 'Article', 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( 'Choose Politics story article' ),
				],
			] ) );
		}
		$wp_customize->add_setting( 'top_stories_block_title', [
			'type'              => 'theme_mod',
			'capability'        => $this->capability,
			'default'           => 'Politics',
			'sanitize_callback' => 'esc_html',
			'transport'         => $transport,
		] );
		$wp_customize->add_control( 'top_stories_block_title', [
			'type'     => 'text',
			'priority' => 2,
			'section'  => 'politics_section_stories',
			'label'    => __( 'Choose Top Stories title', 'chicagosuntimes' ),
		] );
		$lead_counter = 0;
		/**
		 * Featured stories block
		 */
		foreach ( array_keys( $this->featured_story_block_headlines ) as $other_story ) {
			$wp_customize->add_setting( $other_story, [
				'type'              => 'theme_mod',
				'capability'        => $this->capability,
				'default'           => $other_story,
				'sanitize_callback' => 'esc_html',
				'transport'         => $transport,
			] );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 20,
				'section'     => 'featured_stories_section',
				'label'       => 0 === $lead_counter ++ ? __( 'Lead Feature', 'chicagosuntimes' ) : __( 'Other Features', 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( 'Choose top story article' ),
				],
			] ) );
		}
		$lead_counter = 0;
		/**
		 * Lower section based stories, custom heading
		 */
		foreach ( array_keys( $this->lower_section_stories ) as $other_story ) {
			$this->set_setting( $wp_customize, $other_story, 'esc_html' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 10,
				'section'     => 'lower_section_stories',
				'label'       => 0 === $lead_counter ++ ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( 'Choose other article' ),
				],
			] ) );
		}
		/**
		 * Entertainment section based stories, custom heading
		 */
		$lead_counter = 0;
		foreach ( array_keys( $this->entertainment_section_stories ) as $other_story ) {
			$this->set_setting( $wp_customize, $other_story, 'esc_html' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 20,
				'section'     => 'entertainment_section_stories',
				'label'       => 0 === $lead_counter ++ ? __( 'Lead Article', 'chicagosuntimes' ) : __( 'Other Article', 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( 'Choose other article' ),
				],
			] ) );
		}
		/**
		 * Podcast section based stories, custom heading
		 */
		$lead_counter = 0;
		foreach ( array_keys( $this->featured_obits_section_stories ) as $other_story ) {
			$this->set_setting( $wp_customize, $other_story, 'esc_html' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 20,
				'section'     => 'featured_obits_section_stories',
				'label'       => 0 === $lead_counter ++ ? __( 'Lead Obit', 'chicagosuntimes' ) : __( 'Other Obit', 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( 'Choose other obit' ),
				],
			] ) );
		}
		/**
		 * Podcast section based stories, custom heading
		 */
		$lead_counter = 0;
		foreach ( array_keys( $this->podcast_section_stories ) as $other_story ) {
			$this->set_setting( $wp_customize, $other_story, 'esc_html' );
			$wp_customize->add_control( new WP_Customize_CST_Select_Control( $wp_customize, $other_story, [
				'type'        => 'cst_select_control',
				'priority'    => 30,
				'section'     => 'podcast_section_stories',
				'label'       => 0 === $lead_counter ++ ? __( 'Lead Podcast', 'chicagosuntimes' ) : __( 'Other Podcast', 'chicagosuntimes' ),
				'input_attrs' => [
					'placeholder' => esc_attr__( 'Choose other podcast' ),
				],
			] ) );
		}

		/**
		 * Add a section choice for the five block of stories
		 * Perhaps create a CST version of this control for reuse
		 */
		$this->set_setting( $wp_customize, 'lower_section_section_title', 'absint' );
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'lower_section_section_title', [
			'type'     => 'select',
			'priority' => 10,
			'section'  => 'lower_section_stories',
			'settings' => 'lower_section_section_title',
			'choices'  => $this->section_choices,
			'label'    => __( 'Choose section title', 'chicagosuntimes' ),
		] ) );
		/**
		 * Add a section choice for the five block of stories
		 * Perhaps create a CST version of this control for reuse
		 */
		$this->set_setting( $wp_customize, 'entertainment_section_section_title', 'absint' );
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'entertainment_section_section_title', [
			'type'     => 'select',
			'priority' => 10,
			'section'  => 'entertainment_section_stories',
			'settings' => 'entertainment_section_section_title',
			'choices'  => $this->section_choices,
			'label'    => __( 'Choose section title', 'chicagosuntimes' ),
		] ) );
		/**
		 * Add a section choice for the five block of stories
		 * Perhaps create a CST version of this control for reuse
		 */
		$this->set_setting( $wp_customize, 'featured_obit_section_section_title', 'absint' );
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'featured_obit_section_section_title', [
			'type'     => 'select',
			'priority' => 10,
			'section'  => 'featured_obits_section_stories',
			'settings' => 'featured_obit_section_section_title',
			'choices'  => $this->section_choices,
			'label'    => __( 'Choose section title', 'chicagosuntimes' ),
		] ) );

		/**
		 * HP Footer Ads
		 */
		$this->set_setting( $wp_customize, 'footer_config', 'absint' );
		$wp_customize->add_control( 'footer_config', array(
			'type'     => 'radio',
			'priority' => 25,
			'section'  => 'hp_footer_section_ads',
			'label'    => __( 'Choose mobile adhesion ad type.', 'chicagosuntimes' ),
			'choices'  => array(
				1 => 'AOL',
				2 => 'Verve',
				3 => 'AdX',
			)
		) );
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

		$combined_arrays = array_merge(
			array_keys( $this->column_one_stories ),
			array_keys( $this->other_stories ),
			array_keys( $this->upper_section_stories ),
			array_keys( $this->lower_section_stories ),
			array_keys( $this->podcast_section_stories ),
			array_keys( $this->related_column_one_stories ),
			array_keys( $this->politics_list_section_stories ),
			array_keys( $this->entertainment_section_stories ),
			array_keys( $this->featured_obits_section_stories ),
			array_keys( $this->featured_story_block_headlines )
		);
		foreach ( $combined_arrays as $customizer_element_id ) {
			$this->set_selective_refresh( $wp_customize, $customizer_element_id );
		}
		$this->set_selective_refresh( $wp_customize, 'lower_section_section_title' );
		$this->set_selective_refresh( $wp_customize, 'entertainment_section_section_title' );
		$this->set_selective_refresh( $wp_customize, 'featured_obit_section_section_title' );
		$this->set_selective_refresh( $wp_customize, 'chartbeat_section_title' );
		$this->set_selective_refresh( $wp_customize, 'top_stories_block_title' );
		$this->set_selective_refresh( $wp_customize, 'hero_related_posts' );
	}

	/**
	 * @param $wp_customize
	 * @param $partial
	 *
	 * Helper function to set selective refresh partial
	 */
	private function set_selective_refresh( $wp_customize, $partial ) {
		$wp_customize->selective_refresh->add_partial( $partial, [
			'selector'            => '.js-' . str_replace( '_', '-', $partial ),
			'settings'            => $partial,
			'container_inclusive' => false,
			'sanitize_callback'   => 'absint',
			'render_callback'     => [ $this, 'render_callback' ],
		] );

	}

	/**
	 * @param $wp_customize ,
	 * @param $setting_id
	 * @param $callback
	 *
	 * Helper function to set Customizer setting
	 */
	private function set_setting( \WP_Customize_Manager $wp_customize, $setting_id, $callback ) {
		$transport = ( $wp_customize->selective_refresh ? 'postMessage' : 'refresh' );
		$wp_customize->add_setting( $setting_id, [
			'type'              => 'theme_mod',
			'capability'        => $this->capability,
			'default'           => $setting_id,
			'sanitize_callback' => $callback,
			'transport'         => $transport,
		] );
	}

	/**
	 * Internal function to generate select drop down choices
	 */
	private function _generate_choices() {
		$this->section_choices        = get_terms( [
			'taxonomy'   => 'cst_section',
			'hide_empty' => false,
			'fields'     => 'id=>name',
		] );
		$sports_term                  = wpcom_vip_get_term_by( 'name', 'Sports', 'cst_section' );
		$sports_child_terms           = new WP_Term_Query( [
			'taxonomy'   => 'cst_section',
			'parent'     => $sports_term->term_id,
			'hide_empty' => false,
			'fields'     => 'id=>name',
		] );
		$this->sports_section_choices = (array) $sports_child_terms->get_terms();
		foreach ( array_keys( $this->sports_section_choices ) as $sports_sub_sections_id ) {
			$sports_sub_section = new WP_Term_Query( [
				'taxonomy'   => 'cst_section',
				'parent'     => $sports_sub_sections_id,
				'hide_empty' => false,
				'fields'     => 'id=>name',
			] );
			if ( $sports_sub_section->get_terms() ) {
				foreach ( $sports_sub_section->get_terms() as $item => $name ) {
					$this->sports_section_choices[ $item ] = $name;
				}
			}
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
			case 'cst_homepage_section_headlines_2':
			case 'cst_homepage_section_headlines_3':
			case 'cst_homepage_section_headlines_4':
			case 'cst_homepage_section_headlines_5':
			case 'cst_homepage_lower_section_headlines_2':
			case 'cst_homepage_lower_section_headlines_3':
			case 'cst_homepage_lower_section_headlines_4':
			case 'cst_homepage_lower_section_headlines_5':
			case 'cst_podcast_section_headlines_2':
			case 'cst_podcast_section_headlines_3':
			case 'cst_podcast_section_headlines_4':
			case 'cst_podcast_section_headlines_5':
			case 'cst_homepage_entertainment_section_headlines_2':
			case 'cst_homepage_entertainment_section_headlines_3':
			case 'cst_homepage_entertainment_section_headlines_4':
			case 'cst_homepage_entertainment_section_headlines_5':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );

				return CST()->frontend->single_mini_story( $obj, 'regular', $element->id, 'yes', '', true );
				break;
			case 'cst_homepage_section_headlines_1':
			case 'cst_podcast_section_headlines_1':
			case 'cst_homepage_lower_section_headlines_1':
			case 'cst_homepage_entertainment_section_headlines_1':
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $element->id ) );

				return CST()->frontend->single_mini_story( $obj, 'prime', $element->id, 'yes' );
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

				return CST()->frontend->single_mini_story( $obj, 'vertical', $element->id, 'feature-landscape', true );
				break;
			case 'lower_section_section_title':
			case 'entertainment_section_section_title':
			case 'featured_obit_section_section_title':
			case 'top_stories_block_title':
				return CST()->frontend->render_section_title( $element->id );
				break;
			case 'chartbeat_section_title':
				return CST()->frontend->render_section_text_title( $element->id );
				break;
			case 'footer_config':
				return CST()->frontend->render_hp_footer_ad_unit( $element->id );
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
		if ( isset( $_GET['nonce'] )
			 && empty( $_GET['nonce'] )
			 && ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'cst_customizer_control_homepage_headlines' )
			 || ! current_user_can( 'edit_others_posts' )
		) {
			wp_send_json_error( [ 'code' => 'bad_nonce' ], 400 );
		}

		$term    = sanitize_text_field( $_GET['searchTerm'] );
		$section = sanitize_text_field( $_GET['cst_section'] );

		$search_args = [
			'post_type'     => CST()->get_post_types(),
			's'             => $term,
			'post_status'   => 'publish',
			'no_found_rows' => true,
		];

		if ( $section ) {
			$search_args['tax_query'] = [
				[
					'taxonomy'         => 'cst_section',
					'field'            => 'id',
					'terms'            => absint( $section ),
					'include_children' => false,
				],
			];
		}
		$search_query = new \WP_Query( $search_args );

		$returning = [];
		$posts     = [];

		if ( $search_query->have_posts() ) {

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
			wp_send_json_error( [
				'code'    => $returning->get_error_code(),
				'message' => $returning->get_error_message(),
				'data'    => $returning->get_error_data(),
			], 400 );
		} else {
			//wp_send_json_success( $returning ); sends array vs object (that json_encode sends)
			echo wp_json_encode( $returning );
			exit();
		}
	}

	public function sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}

	/**
	 * Getter for top stories array
	 * @return array
	 */
	public function get_entertainment_stories() {
		return $this->entertainment_section_stories;
	}

	/**
	 * Getter for top stories array
	 * @return array
	 */
	public function get_politics_stories() {
		return $this->politics_list_section_stories;
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
	public function get_column_one_related_stories() {
		return $this->related_column_one_stories;
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

	/**
	 * Getter for top stories - widget version - array
	 * @return string
	 */
	public function get_widget_top_stories_stub() {
		return $this->widget_top_story_list_stub;
	}

	/**
	 * Getter for podcast stories - array
	 * @return array
	 */
	public function get_podcast_section_stories() {
		return $this->podcast_section_stories;
	}
	/**
	 * Getter for podcast stories - array
	 * @return array
	 */
	public function get_featured_obits_section_stories() {
		return $this->featured_obits_section_stories;
	}
}
