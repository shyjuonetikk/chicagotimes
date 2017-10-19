<?php

/**
 * Theme functionality for the frontend
 */
class CST_Frontend {

	private static $instance;

	private $nav_title_filter;

	public static $post_sections = array( 'news', 'sports', 'politics', 'entertainment', 'lifestyles', 'opinion', 'columnists', 'obituaries', 'sponsored', 'autos' );

	private $send_to_news_embeds = array(
		'cubs'              => 'xXrmaE8c',
		'cubs-baseball'     => 'xXrmaE8c',
		'white-sox'         => 'TR8jtM5y',
		'bulls'             => 'oags2xgZ',
		'bears'             => 'L9X2Tt4y',
		'bears-football'    => 'L9X2Tt4y',
		'pga-golf'          => 'a7k31LHx',
		'nascar'            => 'L0muW63f',
		'ahl-wolves'        => 'udXbWp8Y',
		'colleges'          => 'SRHLAr2T',
		'olympics-2016'     => 'fLPoOgHI',
		'blackhawks' 		=> 'uy7k8sat',
		'blackhawks-hockey' => 'uy7k8sat',
		'sports'            => 'uDnVEu1d',
	);

	private $headlines_network_slugs = array(
		'sports' => 'f64bb30a45d9141fd5a905788a725121',
		'news' => '8b29b9f9866acb90e8b00e42c1353f4c',
		'entertainment' => 'a5c0c8e47c50c3acd6a8d95d5d1a3939',
		'opinion' => '82e7629cdb9eb1b0aa1d2d86a52c394e',
	);

	public static $pgs_section_slugs = array();
	private $default_image_partial_url = '/assets/images/favicons/mstile-144x144.png';

	public static $triple_lift_section_slugs = array(
		'dear-abby',
	);
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Frontend;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
		}
		return self::$instance;
	}

	/**
	 * Set up frontend customization actions
	 */
	private function setup_actions() {

		add_action( 'pre_get_posts', array( $this, 'action_pre_get_posts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );

		add_action( 'wp_head', array( $this, 'action_wp_head_meta_tags' ) );

		add_action( 'rss2_item', array( $this, 'action_rss2_item' ) );

		add_action( 'cst_section_front_heading', array( $this, 'action_cst_section_front_heading' ) );
		add_action( 'closing_body', array( $this, 'inject_teads_tag' ) );
		add_action( 'closing_body', [ $this, 'enqueue_chartbeat_react_engagement_script' ] );
		add_action( 'closing_body', [ $this, 'enqueue_inspectlet_script' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'cst_tracking_pixels' ] );
		add_action( 'wp_enqueue_scripts', array( $this, 'cst_remove_extra_twitter_js' ), 15 );
		add_action( 'wp_footer', array( $this, 'cst_remove_extra_twitter_js' ), 15 );
		add_action( 'wp_footer', [ $this, 'render_hp_footer_ad_unit' ], 99 );

		add_action( 'cst_dfp_ad_settings', array( $this, 'setup_dfp_header_ad_settings' ) );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_cst_openx_header_bidding_script' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_distroscale_injection' ] );
		add_action( 'head_early_elements', [ $this, 'action_head_early_elements' ] );
		add_action( 'body_start', [ $this, 'action_body_start' ] );

	}

	/**
	 * Set up frontend customization filters
	 */
	private function setup_filters() {

		add_filter( 'post_class', array( $this, 'filter_post_class' ) );

		add_filter( 'wp_title', array( $this, 'filter_wp_title' ) );
		add_filter( 'the_content', array( $this, 'filter_article_featured_image' ) );

		add_filter( 'embed_oembed_html', array( $this, 'filter_embed_oembed_html' ), 10, 4 );

		add_filter( 'nav_menu_link_attributes', array( $this, 'filter_nav_menu_link_attributes' ), 10, 3 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'filter_walker_nav_menu_start_el' ) );
		add_filter( 'the_content', [ $this, 'inject_sponsored_content' ] );
		add_filter( 'the_content', [ $this, 'inject_a9' ] );
		add_filter( 'the_content', [ $this, 'inject_a92' ] );	
		add_filter( 'the_content', [ $this, 'inject_a9_leaderboard' ] );	
		add_filter( 'the_content', [ $this, 'inject_tcx_mobile' ] );
		add_filter( 'the_content', [ $this, 'inject_yieldmo_mobile' ] );
		add_filter( 'wp_nav_menu_objects', [ $this, 'submenu_limit' ], 10, 2 );
		add_filter( 'wp_nav_menu_objects', [ $this, 'remove_current_nav_item' ], 10, 2 );
		add_filter( 'wp_kses_allowed_html', [ $this, 'filter_wp_kses_allowed_custom_attributes' ] );
	}

	/**
	 * Modifications to the main query
	 *
	 * @param \WP_query $query
	 */
	public function action_pre_get_posts( $query ) {

		// Include all content types on the homepage
		if ( $query->is_main_query() && ( $query->is_home() || $query->is_tax() || $query->is_author() ) ) {
			$query->set( 'post_type', CST()->get_post_types() );
		} else if ( $query->is_main_query() && 'print' === get_query_var( 'feed' ) ) {

			// Build the print feed from selected posts
			$print_post_ids = CST()->get_print_feed_post_ids();
			if ( ! empty( $print_post_ids ) ) {
				$query->set( 'post__in', $print_post_ids );
				$query->set( 'post_type', 'cst_article' );
				$query->set( 'post_status', 'publish' );
				$query->set( 'orderby', 'post__in' );
				$query->set( 'posts_per_page', 100 );
				$query->set( 'ignore_sticky_posts', true );
			} else {
				// when passed an empty array, post__in returns main query
				// This is a better way of killing it
				$query->set( 'post_type', 'd5t34tfgdfg' );
			}
		} else if ( $query->is_main_query() && $query->is_feed() ) {
			$query->set( 'post_type', 'cst_article' );
			$query->set( 'ignore_sticky_posts', true );
		}

	}

	/**
	 * Enqueue scripts and styles
	 */
	public function action_wp_enqueue_scripts() {
		// Foundation
		wp_enqueue_script( 'foundation', get_template_directory_uri() . '/assets/js/vendor/foundation.min.js', array( 'jquery' ), '5.5.3' );
		wp_enqueue_style( 'foundation', get_template_directory_uri() . '/assets/css/vendor/foundation.min.css', false, '5.5.3' );
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr.js', array( 'jquery' ), '6.0.0' );
		// Fonts
		if ( is_post_type_archive( 'cst_feature' ) ) {
			wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Merriweather:400,400i,700,700i|Open+Sans:400,400i,700,700i&amp;subset=latin' );
		} else {
			wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Libre+Franklin:400,400i,600,600i,700,700i|Merriweather:300,300i,400,400i,700,700i,900,900i&amp;subset=latin' );
		}
		if ( is_page_template( 'page-flipp.php' ) ) {
			wp_enqueue_script( 'cst_ad_flipp_page', 'https://circulars-chicago.suntimes.com/distribution_services/iframe.js' );
		}

		if ( is_page_template( 'page-monster.php' ) ) {
			wp_enqueue_script( 'monster-footerhook', get_template_directory_uri() . '/assets/js/vendor/footerhookv1-min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'twitter-platform', '//platform.twitter.com/widgets.js', array(), null, true );
			wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts' ) );
			wp_enqueue_script( 'cst-custom-js', get_template_directory_uri() . '/assets/js/theme-custom-page.js' );
		} elseif ( is_page_template( 'page-paper-finder.php' ) ) {
			wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/vendor/font-awesome.min.css' );
			wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts' ) );
			wp_enqueue_script( 'google-paper-finder', esc_url( 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDkPQ9BLBwW_xCk4Wrh55UjZvyVqPc_5FU&libraries=places&callback=initAutocomplete' ), array( 'paper-finder' ), null, true );
			wp_enqueue_script( 'paper-finder', get_template_directory_uri() . '/assets/js/paper-finder.js', array(), null, true );
			wp_enqueue_script( 'cst-custom-js', get_template_directory_uri() . '/assets/js/theme-custom-page.js' );
		} else {
			wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/vendor/font-awesome.min.css' );
			if ( ! is_post_type_archive( 'cst_feature' ) && ! is_singular( 'cst_feature' ) && ! $this->display_minimal_nav() ) {
				wp_enqueue_style( 'cst-weathericons', get_template_directory_uri() . '/assets/css/vendor/weather/css/weather-icons.css' );
			}

			wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts', 'fontawesome' ) );
			// If we are on a 404 page don't try and load scripts/css that we won't be using.
			if ( ! is_404() && ! is_page() ) {
				// The theme
				if ( is_front_page() ) {
					wp_enqueue_script( 'chicagosuntimes-homepage', get_template_directory_uri() . '/assets/js/theme-homepage.js' );
				} else {
					if ( is_singular( 'cst_feature' ) || is_post_type_archive( 'cst_feature' ) ) {
						wp_enqueue_script( 'chicagosuntimes', get_template_directory_uri() . '/assets/js/feature-theme.js', array() );
					} else {
						wp_enqueue_script( 'chicagosuntimes', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery-effects-slide' ) );
					}
				}
				if ( is_singular() || is_tax() ) {
					if ( is_singular( [ 'cst_article', 'cst_feature', 'cst_gallery', 'cst_video' ] ) ) {
						wp_enqueue_script( 'add-this', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5419af2b250842c9', array(), null, true );
					}
					wp_enqueue_script( 'twitter-platform', '//platform.twitter.com/widgets.js', array(), null, true );

					if ( is_singular( [ 'cst_article', 'cst_feature', 'cst_gallery', 'cst_video' ] ) || is_tax() || is_author() ) {
						// Slick
						wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/vendor/slick/slick.min.js', array( 'jquery' ), '1.3.6' );
						wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/js/vendor/slick/slick.css', false, '1.3.6' );
						if ( is_singular( array( 'cst_article', 'cst_feature', 'cst_gallery' ) ) ) {
							wp_enqueue_script( 'cst-gallery', get_template_directory_uri() . '/assets/js/gallery.js', array( 'slick' ) );
						}
					}
					wp_enqueue_script( 'cst-events', get_template_directory_uri() . '/assets/js/event-tracking.js', array( 'jquery' ) );
					if ( ! is_singular( 'cst_feature' ) ) {
						wp_enqueue_script( 'cst-ga-custom-actions', get_template_directory_uri(). '/assets/js/analytics.js', array( 'jquery' ) );
					}
					wp_enqueue_script( 'cst-ga-autotrack', get_template_directory_uri(). '/assets/js/vendor/autotrack.js', array( 'jquery' ) );
					$analytics_data = array(
						'is_singular'     => is_singular(),
					);
					if ( is_singular() && $obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() ) ) {
						for ( $i = 1;  $i <= 10;  $i++ ) {
							$analytics_data[ 'dimension' . $i ] = $obj->get_ga_dimension( $i );
						}
					}

					wp_localize_script( 'cst-ga-custom-actions', 'CSTAnalyticsData', $analytics_data );
				}

				if ( is_singular( [ 'cst_article', 'cst_gallery', 'cst_video' ] ) && ! is_admin() ) {
					wp_enqueue_script( 'yieldmo', get_template_directory_uri() . '/assets/js/vendor/yieldmo.js' );
				}

				if ( is_page() ) {
					wp_enqueue_script( 'google-maps', get_template_directory_uri() . '/assets/js/vendor/google-map.js', array( 'jquery' ), '5.2.3' );
				}
				if ( ( is_author() || is_tax() || is_singular( [ 'cst_article', 'cst_gallery', 'cst_video' ] ) )  && ! is_admin() ) {
					wp_enqueue_script( 'cst-ads', get_template_directory_uri() . '/assets/js/ads.js', array( 'jquery' ) );
				}
				if ( is_tax() ) {
					wp_enqueue_script( 'cst-sticky', get_template_directory_uri() . '/assets/js/vendor/sticky-kit.min.js', array( 'jquery' ) );
				}
			} else {
				wp_enqueue_script( 'chicagosuntimes-404page', get_template_directory_uri() . '/assets/js/404.js' );
			}
			wp_localize_script( 'chicagosuntimes', 'CSTIE', array( 'cst_theme_url' => get_template_directory_uri() ) );

		}
		if ( is_page() ) {
			wp_enqueue_script( 'page-iframe-reponsify', get_template_directory_uri() . '/assets/js/theme-page.js', array(), null, true );
		}
		wp_localize_script( 'chicagosuntimes', 'CSTData', array(
			'home_url'         => esc_url_raw( home_url( '/' ) ),
			'disqus_shortname' => CST_DISQUS_SHORTNAME,
			'taboola_container_id' => 'taboola-below-article-thumbnails-',
		) );

	}

	/**
	 * Load the correct style sheet based on the section or ref
	 */
	public function action_load_section_styling() {

		if ( is_author() ) {
			wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts', 'fontawesome' ) );
		} elseif ( is_tax() ) {
			$section_obj = get_queried_object();
			$section_slug = $this->determine_section_slug( $section_obj );
			switch ( $section_slug ) {
				case 'sports':
					wp_enqueue_style( 'chicagosuntimes-sports', get_template_directory_uri() . '/assets/css/sports-theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
				case 'politics':
					wp_enqueue_style( 'chicagosuntimes-politics', get_template_directory_uri() . '/assets/css/politics-theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
				case 'entertainment':
					wp_enqueue_style( 'chicagosuntimes-entertainment', get_template_directory_uri() . '/assets/css/entertainment-theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
				case 'lifestyles':
					wp_enqueue_style( 'chicagosuntimes-lifestyles', get_template_directory_uri() . '/assets/css/lifestyles-theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
				case 'columnists':
					wp_enqueue_style( 'chicagosuntimes-columnists', get_template_directory_uri() . '/assets/css/columnists-theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
				case 'opinion':
					wp_enqueue_style( 'chicagosuntimes-opinion', get_template_directory_uri() . '/assets/css/opinion-theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
				case 'news':
				case 'sponsored':
					wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
				default:
					wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts', 'fontawesome' ) );
					break;
			}
		} elseif ( $obj = get_queried_object() ) {

					wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts', 'fontawesome' ) );

		} else {
			wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts', 'fontawesome' ) );
		}

	}

	/**
	* Remove the devicepx code from our section fronts to test and prevent unnecessary img src modifications
	* Zendesk #68999
	*/
	public function section_front_dequeue_devicepx() {
		// An alternative for sitewide disablement is wpcom_vip_disable_devicepx_js()
		if ( is_tax() ) {
			wp_dequeue_script( 'devicepx' );
		}
	}
	/**
	 * Add meta tags to the head of our site
	 */
	public function action_wp_head_meta_tags() {

		if ( is_singular() ) {
			$post = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
			$meta_description = $post->get_seo_description();
			$people     = $post->get_people() ? $post->get_people() : array();
			$locations  = $post->get_locations() ? $post->get_locations() : array();
			$topics     = $post->get_topics() ? $post->get_topics() : array();
			$combined_taxonomies = array_merge( $topics, $locations, $people );
			if ( $combined_taxonomies ) {
				echo '<meta name="news_keywords" content="' . esc_attr( join( ', ', wp_list_pluck( $combined_taxonomies, 'name' ) ) ) . '" />' . esc_attr( PHP_EOL );
			}
		} elseif ( is_tax() && $description = get_queried_object()->description ) {
			$meta_description = $description;
			$term = get_queried_object();
			$seo = fm_get_term_meta( $term->term_id, 'cst_section', 'seo', true );
			if ( $seo ) {
				echo '<meta name="keywords" content="' . esc_attr( $seo['section_keywords'] ) . '" />' . esc_attr( PHP_EOL );
			}
			if ( ! empty( $term ) ) {
				$term_link          = wpcom_vip_get_term_link( $term, $term->taxonomy );
				if ( ! is_wp_error( $term_link ) ) {
					echo '<link rel="canonical" href="' . esc_url( $term_link, null, 'other' ) . '" />' . "\n";
				}
			}
		} else {
			$meta_description = get_bloginfo( 'description' );
		}

		$facebook_tags = $this->get_facebook_open_graph_meta_tags();
		$twitter_tags = $this->get_twitter_card_meta_tags();

		$tags = array_merge( array( 'description' => $meta_description ), $facebook_tags, $twitter_tags );
		foreach ( $tags as $name => $value ) {
			echo '<meta property="' . esc_attr( $name ) . '" content="' . esc_attr( $value ) . '" />' . esc_attr( PHP_EOL );
		}

		echo '<meta name="description" content="' . esc_attr( $meta_description ) . '" />' . esc_attr( PHP_EOL );

	}

	function add_data_type_suffix( $source, $handle, $tag ) {

		$accepted_scripts = array( 'send-to-news' );
		foreach ( $accepted_scripts as $accepted_script ) {
			if ( strstr( $handle, $accepted_script ) ) {
				$source = str_replace( 'src=', 'data-type="s2nScript" src=', $source );
			}
		}

		return $source;
	}
	/**
	 * If a post has multiple bylines, include all of them in the feed item
	 */
	public function action_rss2_item() {

		$authors = get_coauthors();
		if ( count( $authors ) <= 1 ) {
			return;
		}
		// Discard the first as it's already been added
		array_shift( $authors );
		foreach ( $authors as $author ) {
			echo '<dc:creator><![CDATA[' . esc_html( $author->display_name ) . ']]></dc:creator>';
		}

	}

	/**
	 * Filter the title on single posts
	 * @param $wp_title
	 *
	 * @return string
	 */
	public function filter_wp_title( $wp_title ) {

		if ( empty( $wp_title ) && ( is_home() || is_front_page() ) ) {
			return 'Chicago Sun-Times: Chicago news, sports, politics, entertainment';
		}

		if ( is_404() ) {
			return 'Page not found - Chicago Sun-Times';
		}

		if ( is_tax() ) {
			$seo = fm_get_term_meta( get_queried_object()->term_id, 'cst_section', 'seo', true );
			if ( isset( $seo['section_seo_title'] ) && ! empty( $seo['section_seo_title'] ) ) {
				return esc_html( $seo['section_seo_title'] . ' - Chicago Sun-Times' );
			}
			switch ( get_queried_object()->slug ) {
				case 'business':
					return 'Chicago Business - Chicago Sun-Times';
				case 'chicago':
					return 'Chicago Breaking News - Chicago Sun-Times';
				case 'crime':
					return 'Chicago Crime - Chicago Sun-Times';
				case 'education':
					return 'Chicago Education - Chicago Sun-Times';
				case 'entertainment':
					return 'Chicago Entertainment - Chicago Sun-Times';
				case 'nationworld':
				case 'world':
					return 'U.S. News &amp; World News - Chicago Sun-Times';
				case 'politics':
					return 'Chicago Politics - Chicago Sun-Times';
				case 'sports':
					return 'Chicago Sports, News, Schedules &amp; Scores - Chicago Sun-Times';
				case 'transportation':
					return 'Chicago Transit &amp; Transportation - Chicago Sun-Times';
				default:
					return get_queried_object()->name . ' - Chicago Sun-Times';
			}
		}

		if ( is_author() ) {
			return $wp_title . get_bloginfo( 'name' );
		}
		if ( is_post_type_archive() ) {
			return $wp_title . ' - Chicago Sun-Times';
		}

		if ( ! is_singular() ) {
			return $wp_title;
		}

		$post = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
		return $post->get_seo_title();

	}

	/**
	 * If using an embedded video (from SendToNews) insert the assigned featured image
	 * ahead of the the 5th paragraph
	 *
	 * This functions runs as part of the_content filter
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function filter_article_featured_image( $content ) {

		$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
		if ( false !== $obj && $obj->get_post_type() === 'cst_article' ) {
			if ( 'video' === $obj->get_featured_media_type() ) {
				$exploded = explode( '</p>',$content );
				array_splice( $exploded, 4, 0, CST()->featured_image_markup( $obj ) );
				$content = join( '</p>',$exploded );
			}
		}
		return $content;
	}

	/**
	* Filter nav menu item links
	* @param $atts
	* @param $item
	* @param $args
	 *
	* @return mixed
	 */
	public function filter_nav_menu_link_attributes( $atts, $item, $args ) {

		if ( empty( $args->theme_location ) ) {
			return $atts;
		}

		switch ( $args->theme_location ) {

			case 'trending-menu':

				$fontawesome_icon = false;

				if ( 'taxonomy' === $item->type && 'cst_person' === $item->object ) {
					$fontawesome_icon = 'fa fa-male';
				}

				if ( 'taxonomy' === $item->type && 'cst_location' === $item->object ) {
					$fontawesome_icon = 'fa fa-location-arrow';
				}

				if ( 'taxonomy' === $item->type && 'cst_topic' === $item->object ) {
					$fontawesome_icon = 'fa fa-cst-topic';
				}

				if ( 'taxonomy' === $item->type && 'cst_section' === $item->object ) {
					$fontawesome_icon = 'fa fa-folder';
				}

				if ( 'post_type' === $item->type && 'cst_liveblog' === $item->object ) {
					$fontawesome_icon = 'fa fa-comment';
				}

				if ( 'custom' === $item->type ) {
					$fontawesome_icon = 'fa fa-link';
				}

				if ( $fontawesome_icon ) {
					// WordPress is a series of massive hacks: https://core.trac.wordpress.org/ticket/29417
					$this->nav_title_filter = function( $item_title ) use ( $fontawesome_icon ) {
						$item_title = '<i class="' . esc_attr( $fontawesome_icon ) . '"></i>' . $item_title;
						return $item_title;
					};
					add_filter( 'the_title', $this->nav_title_filter, 10, 2 );
				}

				break;

		}

		return $atts;
	}

	/**
	 * Remove the title filter if there is one
	 * @param $output
	 *
	 * @return mixed
	 */
	public function filter_walker_nav_menu_start_el( $output ) {

		if ( $this->nav_title_filter ) {
			remove_filter( 'the_title', $this->nav_title_filter );
			$this->nav_title_filter = false;
		}

		return $output;
	}

	/**
	 * Filter oEmbed response HTML to make some embeds responsive
	 * @param $cache
	 * @param $url
	 * @param $attr
	 * @param $post_ID
	 *
	 * @return mixed
	 */
	public function filter_embed_oembed_html( $cache, $url, $attr, $post_ID ) {

		$host = parse_url( $url, PHP_URL_HOST );
		switch ( $host ) {

			case 'www.youtube.com':
				$cache = str_replace( '<iframe ', '<iframe class="cst-responsive" data-true-height="640" data-true-width="360" ', $cache );
				break;

			case 'instagr.am';
			case 'instagram.com':
				$cache = str_replace( '_a.jpg', '_o.jpg', $cache );
				$cache = str_replace( '<img ', '<img style="width: 100% !important; height: auto !important;" ', $cache );
				break;

		}
		return $cache;
	}

	/**
	 * Filter post classes
	 */
	public function filter_post_class( $classes ) {

		$classes[] = 'post'; // Easier styling across all post types

		if ( get_the_ID() === get_queried_object_id() ) {
			$classes[] = 'active';
		}

		if ( 'cst_embed' == get_post_type() ) {
			$obj = new \CST\Objects\Embed( get_the_ID() );
			$classes[] = 'cst-embed-' . $obj->get_embed_type();
		}

		return $classes;
	}

	/**
	 * Get the Facebook Open Graph meta tags for this page
	 */
	public function get_facebook_open_graph_meta_tags() {

		if ( isset( $_SERVER['REQUEST_URI'] ) && $_SERVER['REQUEST_URI'] ) {
			$default_url = is_ssl() ? 'https://' : 'http://';
			$default_url .= wp_unslash( $_SERVER['HTTP_HOST'] ); // WPCS: sanitization okay
			$default_url .= wp_unslash( $_SERVER['REQUEST_URI'] ); // WPCS: sanitization okay
		}
		// Defaults
		$tags = array(
			'og:site_name'        => get_bloginfo( 'name' ),
			'og:type'             => 'website',
			'og:title'            => get_bloginfo( 'name' ),
			'og:description'      => get_bloginfo( 'description' ),
			'og:url'              => esc_url( $default_url ),
			);

		// Single posts
		if ( is_singular() ) {
			$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
			$tags['og:title'] = $obj->get_facebook_open_graph_tag( 'title' );
			$tags['og:type'] = 'article';
			$tags['og:description'] = $obj->get_facebook_open_graph_tag( 'description' );
			$tags['og:url'] = $obj->get_facebook_open_graph_tag( 'url' );
			if ( $image = $obj->get_facebook_open_graph_tag( 'image' ) ) {
				$tags['og:image'] = $image;
			}
		} elseif ( is_tax() && $description = get_queried_object()->description ) {
			$tags['og:description'] = $description;
		}

		return $tags;

	}

	/**
	 * Get the Twitter card meta tags for this page
	 */
	public function get_twitter_card_meta_tags() {

		if ( isset( $_SERVER['REQUEST_URI'] ) && $_SERVER['REQUEST_URI'] ) {
			$default_url = is_ssl() ? 'https://' : 'http://';
			$default_url .= wp_unslash( $_SERVER['HTTP_HOST'] ); // WPCS: sanitization okay
			$default_url .= wp_unslash( $_SERVER['REQUEST_URI'] ); // WPCS: sanitization okay
		}
		// Defaults
		$tags = array(
			'twitter:card'        => 'summary_large_image',
			'twitter:site'        => '@' . CST_TWITTER_USERNAME,
			'twitter:title'       => get_bloginfo( 'name' ),
			'twitter:description' => get_bloginfo( 'description' ),
			'twitter:url'         => esc_url( $default_url ),
			);

		// Single posts
		if ( is_singular() ) {
			$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
			$tags['twitter:title'] = $obj->get_twitter_card_tag( 'title' );
			$tags['twitter:description'] = $obj->get_twitter_card_tag( 'description' );
			$tags['twitter:url'] = $obj->get_twitter_card_tag( 'url' );

			if ( $image = $obj->get_twitter_card_tag( 'image' ) ) {
				$tags['twitter:image'] = $image;
			}
		} elseif ( is_tax() && $description = get_queried_object()->description ) {
			$tags['twitter:description'] = $description;
		}

		return $tags;

	}

	/**
	 * Ensure there's enough posts for a collection of posts
	 *
	 * @param array $collection
	 * @param int $minimum_count
	 * @param string|array $section
	 * @return array
	 */
	public function ensure_minimum_post_count( $collection, $minimum_count, $section ) {
		static $fetched_posts;

		if ( count( $collection ) >= $minimum_count ) {
			return $collection;
		}

		if ( ! is_array( $fetched_posts ) ) {
			$fetched_posts = array();
		}

		$query_args = array(
			'post_type'        => array( 'cst_article' ),
			'posts_per_page'   => $minimum_count - count( $collection ),
			'post_status'      => 'publish',
			'post__not_in'     => array_merge( $fetched_posts, wp_list_pluck( $collection, 'ID' ) ),
			'no_found_rows'    => true,
			'cst_section'	   => $section,
			);

		if ( is_array( $section ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy'  => 'cst_section',
					'field'     => 'slug',
					'terms'     => $section,
				),
			);
			unset( $query_args['cst_section'] );
		}

		$post_query = new \WP_Query( $query_args );
		$fetched_posts = array_merge( $fetched_posts, wp_list_pluck( $post_query->posts, 'ID' ) );
		return array_merge( $collection, $post_query->posts );
	}

	public function get_weather() {
		if ( $this->display_minimal_nav() ) {
			return;
		}
		$response = wpcom_vip_file_get_contents( 'https://apidev.accuweather.com/currentconditions/v1/348308.json?language=en&apikey=' . CST_ACCUWEATHER_API_KEY );
		$data = json_decode( $response );
		if ( ! $data ) {
			return false;
		}
		return $data;

	}

	/**
	 * @param $number
	 *
	 * @return string
	 */
	public function get_weather_icon( $number ) {
		$icon = '';
		switch ( $number ) {

			case 1:
				$icon = 'wi-sunny-day';
				break;
			case 2:
			case 3:
				$icon = 'wi-day-sunny-overcast';
				break;
			case 4:
			case 6:
			case 7:
				$icon = 'wi-day-cloudy';
				break;
			case 5:
			case 8:
			case 11:
				$icon = 'wi-day-fog';
				break;
			case 12:
				$icon = 'wi-showers';
				break;
			case 13:
			case 14:
				$icon = 'wi-day-showers';
				break;
			case 15:
				$icon = 'wi-thunderstorm';
				break;
			case 16:
				$icon = 'wi-day-thunderstorm';
				break;
			case 17:
				$icon = 'wi-day-storm-showers';
				break;
			case 18:
				$icon = 'wi-showers';
				break;
			case 19:
				$icon = 'wi-snow-wind';
				break;
			case 20:
			case 21:
				$icon = 'wi-day-snow';
				break;
			case 22:
				$icon = 'wi-snow';
				break;
			case 23:
				$icon = 'wi-day-snow';
				break;
			case 24:
				$icon = 'wi-snowflake-cold';
				break;
			case 25:
				$icon = 'wi-hail';
				break;
			case 26:
				$icon = 'wi-rain';
				break;
			case 29:
				$icon = 'wi-rain-mix';
				break;
			case 30:
				$icon = 'wi-hot';
				break;
			case 31:
				$icon = 'wi-snowflake-cold';
				break;
			case 32:
				$icon = 'wi-strong-wind';
				break;
			case 33:
				$icon = 'wi-night-clear';
				break;
			case 34:
			case 35:
			case 36:
				$icon = 'wi-night-cloudy';
				break;
			case 37:
				$icon = 'wi-night-fog';
				break;
			case 38:
				$icon = 'wi-cloudy';
				break;
			case 39:
				$icon = 'wi-night-alt-sprinkle';
				break;
			case 40:
				$icon = 'wi-night-showers';
				break;
			case 41:
				$icon = 'wi-night-lightning';
				break;
			case 42:
				$icon = 'wi-night-storm-showers';
				break;
			case 43:
				$icon = 'wi-night-snow';
				break;
			case 44:
				$icon = 'wi-night-alt-snow';
				break;
			default:
				break;

		}
		return $icon;

	}

	/**
	* @param $taxonomy string The filename of taxonomy icon
	*
	* @return bool|string
	*/
	public function get_taxonomy_image( $taxonomy ) {

		$taxonomy = sanitize_key( $taxonomy );
		if ( file_exists( get_template_directory() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.jpg' ) ) {
			return get_template_directory_uri() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.jpg';
		} elseif ( file_exists( get_template_directory() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.svg' ) ) {
			return get_template_directory_uri() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.svg';
		} elseif ( file_exists( get_template_directory() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.png' ) ) {
			return get_template_directory_uri() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.png';
		} else {
			return false;
		}

	}

	public function cst_homepage_get_traffic() {
		$response = wpcom_vip_file_get_contents( 'http://www.mapquestapi.com/traffic/v2/incidents?key=' . CST_MAPQUEST_API_KEY . '&boundingBox=41.8,-87.7,42.3,-88.2&filters=construction,incidents&outFormat=json' );
		$result = json_decode( $response );

		if ( ! $result ) {
			$_traffic['icon'] = '';
			$_traffic['word'] = '';
			return $_traffic;
		}

		$data = (object) array( json_decode( $response ) );

		$total_severity = 0;
		$total = 0;
		foreach ( $data as $traffic ) {

			$total = count( $traffic->incidents );
			for ( $i = 0; $i <= ( $total - 1); $i++ ) {
				$total_severity += $traffic->incidents[ $i ]->severity;
			}
		}
		$_traffic['accidents'] = $total;
		if ( $total_severity <= $total ) {
			$_traffic['icon'] = 'green';
			$_traffic['word'] = 'Light';
		} elseif ( $total_severity >= ($total * 2) ) {
			$_traffic['icon'] = 'orange';
			$_traffic['word'] = 'Mild';
		} elseif ( $total_severity >= ($total * 3) ) {
			$_traffic['icon'] = 'red';
			$_traffic['word'] = 'High';
		}
		return $_traffic;

	}

	public function cst_homepage_get_traffic_report() {
		$response = wpcom_vip_file_get_contents( 'http://www.mapquestapi.com/traffic/v2/incidents?key=' . CST_MAPQUEST_API_KEY . '&boundingBox=41.8,-87.7,42.3,-88.2&filters=construction,incidents&outFormat=json' );
		$result = json_decode( $response );

		if ( ! $result ) {
			$_traffic['icon'] = '';
			$_traffic['word'] = '';
			return $_traffic;
		}

		$data = (object) array( json_decode( $response ) );
		$all_incidents = array();
		foreach ( $data as $traffic ) {
			foreach ( $traffic->incidents as $incident ) {
				array_push( $all_incidents, $incident );
			}
		}

		return $all_incidents;

	}

	/**
	* @param $feed_url
	* @param $max_display
	*
	* @return array|bool|mixed|null
	*/
	public function cst_homepage_fetch_feed( $feed_url, $max_display ) {

		$cache_key = md5( $feed_url . (int) $max_display );
		$cached_feed = wpcom_vip_cache_get( $cache_key, 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
		if ( ( false === $cached_feed ) || WP_DEBUG ) {
			$headlines = fetch_feed( $feed_url );
			if ( ! is_wp_error( $headlines ) ) :
				$maxitems = $headlines->get_item_quantity( $max_display );
				$items    = $headlines->get_items( 0, $maxitems );
				wpcom_vip_cache_set( $cache_key, $items, 'default', 15 * MINUTE_IN_SECONDS );
				return $items;
			else :
				return; //todo: VIP note: cache when the feed is not found.
			endif;
		} else {
			return $cached_feed;
		}
	}

	/**
	 * Fetch and output content from the specified section
	 * @param $content_query
	 * @param $nativo_slug
	 */
	public function cst_homepage_content_block( $content_query, $nativo_slug = null ) {

		$cache_key = md5( json_encode( $content_query ) );
		$cached_content = wpcom_vip_cache_get( $cache_key );
		if ( false === $cached_content || WP_DEBUG ) {
			$items = new \WP_Query( $content_query );
			ob_start();
			if ( $items->have_posts() ) {
				$count = $content_query['posts_per_page'];
				while ( $items->have_posts() ) {
					$items->the_post();
					$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
					if ( $count == $content_query['posts_per_page'] ) {
						$featured_image_id = $obj->get_featured_image_id();
						if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) { ?>
							<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="image" data-event-action="navigate-hp-column-wells">
							<?php echo wp_kses_post( $attachment->get_html( 'homepage-columns' ) ); ?>
							</a>
							<?php
						}
						if ( '' !== $nativo_slug ) { ?>
							<ul id="<?php echo esc_html( $nativo_slug ); ?>">
						<?php } else { ?>
							<ul>
						<?php }
					}
					$count--;
					?>
					<li>
						<h3>
						<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="content" data-event-action="navigate-hp-column-wells">
							<?php echo esc_html( $obj->get_title() ); ?>
						</a>
						</h3>
					</li>
			<?php }
			} ?>
			</ul>
			<?php
			$cached_content = ob_get_clean();
			wpcom_vip_cache_set( $cache_key, $cached_content, 'default', 5 * MINUTE_IN_SECONDS );
		}
		echo wp_kses_post( $cached_content );
	}

	/**
	 * Fetch and output content from the specified section
	 * Multi functional content layer outer
	 * @param $orientation string Basic name describing orientation of articles in this block
	 */
	public function cst_politics_stories_content_block( $orientation = 'columns' ) {
?>
			<div class="row">
			<div class="columns small-12">
			<?php
		foreach ( CST()->customizer->get_politics_stories() as $partial_id => $value ) {
				$this->top_story( $partial_id, $orientation );
		} ?>
			</div>
			</div>
		<?php
	}

	/**
	* @param $partial_id
	* @param $orientation
	* Display story title and image in a column for homepage
	*/
	public function top_story( $partial_id, $orientation ) {
		$classes = array(
			'columns' => array(
				'title' => 'columns small-9 medium-8 title',
				'image' => 'columns small-3 medium-4 image',
			),
			'rows' => array(
				'title' => 'columns small-9 medium-8 large-6 title',
				'image' => 'columns small-3 medium-4 large-6 image',
			),
		);
		$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $partial_id ) );
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) { ?>
			<div class="latest-story js-<?php echo esc_attr( str_replace( '_', '-', $partial_id ) ); ?>">
			<div class="<?php echo esc_attr( $classes[ $orientation ]['title'] ); ?>">
				<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="content" data-event-action="navigate-hp-latest-wells">
					<?php echo esc_html( $obj->get_title() ); ?>
				</a>
			</div>
			<div class="<?php echo esc_attr( $classes[ $orientation ]['image'] ); ?>">
				<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" class="image-right" data-on="click" data-event-category="content" data-event-action="navigate-hp-latest-wells">
					<?php
						$featured_image_id = $obj->get_featured_image_id();
			if ( $featured_image_id ) {
				$attachment = wp_get_attachment_metadata( $featured_image_id );
				if ( $attachment ) {
					$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'right', 'chiwire-slider-square' );
					echo wp_kses_post( $image_markup );
				}
			}
					?>
				</a>
			</div>
			</div>
		<?php
		}
	}

	/**
	* Display two column stories:
	* 	Widget style top stories column
	* 	Then Featured Story and up to 4 featured stories block too
	* And finally display an ad below those
	*/
	public function more_stories_content() {
		add_filter( 'get_image_tag_class', function( $class ) {
			$class .= ' featured-story-hero';
			return $class;
		} );
		?>
<div class="more-stories-content">
	<div class="row">
	<?php $this->more_top_stories_block( get_theme_mod( 'top_stories_block_title' ), 'normal-style' ); ?>
	<?php if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() && is_active_sidebar( 'homepage_sidebar_two' ) ) { ?>
	<div class="columns small-12 medium-6 large-4 sidebar homepage-sidebar widgets mobile">
	<div class="columns"><hr></div>
	<?php dynamic_sidebar( 'homepage_sidebar_two' ); ?>
	</div>
	<?php } ?>
	<div class="columns small-12 medium-6 large-8">
		<div class="small-12 columns more-stories-container" id="featured-stories">
			<div class="row">
				<h3 class="more-sub-head"><a href="<?php echo esc_url( home_url( '/' ) ); ?>features/"></a>Featured story</h3>
				<div class="featured-story js-featured-story-block-headlines-1">
					<?php
					$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( 'featured_story_block_headlines_1' ) );
					if ( $obj ) {
						$this->featured_story_lead( $obj );
					}
					?>
				</div>
			</div>
			<div class="row">
				<h2 class="more-sub-head">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>features/" data-on="click" data-event-category="navigation"
					   data-event-action="navigate-hp-features-column-title">
						More Features</a></h2>
				<div class="columns small-12 mini-featured-stories" data-equalizer>
					<div class="row">
						<?php $featured_stories = CST()->customizer->get_featured_stories();
						array_shift( $featured_stories );
						$featured_stories['display_relative_timestamp'] = false;
						$featured_stories['layout_type'] = 'vertical';
						$this->mini_stories_content_block( $featured_stories ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div><!-- /more-stories-content -->
		<?php
	}
	/**
	 * @param $title string  Title of the content block
	 * @param $style string 'sidebar-style' | 'normal-style' to determine markup
	 * List of stories - title -> image
	 *
	 */
	public function more_top_stories_block( $title, $style = 'sidebar-style' ) {
		$widget_style = array(
			'sidebar-style' => array(
				'wrapper-open' => 'row more-stories-container ss',
				'container-open' => 'columns small-12',
			),
			'normal-style' => array(
				'wrapper-open' => 'more-stories-container ns',
				'container-open' => 'columns small-12 medium-6 large-4',
			),
		);
		?>
		<div class="<?php echo esc_attr( $widget_style[ $style ]['wrapper-open'] ); ?>">
			<div class="<?php echo esc_attr( $widget_style[ $style ]['container-open'] ); ?>">
				<h2 class="more-sub-head"><?php echo esc_html( $title ); ?></h2>
				<div class="row">
					<div class="columns stories-list">
						<?php $this->cst_politics_stories_content_block( 'columns' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

		/**
	 * @param $obj
	 *
	 * Display Featured Story - lead, large image
	 */
	public function featured_story_lead( \CST\Objects\Post $obj ) {
		?>
		<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" title="<?php echo esc_html( $obj->get_title() ); ?>" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-featured-story">
	<?php
		$featured_image_id = $obj->get_featured_image_id();
		if ( $featured_image_id )  {
			$attachment = wp_get_attachment_metadata( $featured_image_id );
			if ( $attachment ) {
				$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'none', 'cst-article-featured' );
				echo wp_kses_post( $image_markup );
			}
		}
		?>
		<h3><?php echo esc_html( $obj->get_title() ); ?></h3>
		</a>
		<?php
	}
	/**
	* A 2 x 2 block of content, each have image with title and anchored
	* Optionally a 5th piece of content on left of 2 x 2 block of content
	* @param $headlines array
	*/
	public function mini_stories_content_block( $headlines ) {
		$count_headlines = count( $headlines );
		$display_relative_timestamp = true;
		if ( isset( $headlines['display_relative_timestamp'] ) && false === $headlines['display_relative_timestamp'] ){
			$display_relative_timestamp = false;
		}
		$counter = 0;
		$close_me = false; ?>
		<div class="row mini-stories small-collapse" >
		<?php $partials = array_keys( $headlines ); ?>
			<?php foreach ( $partials as $partial_id ) {
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $partial_id ) );
			if ( $obj ) {
				if ( 0 === $counter && ( 0 !== $count_headlines % 2 ) ) {
						// First item and odd total
						?>
						<div class="prime-lead-story small-12 medium-4">
							<?php
							$this->single_mini_story( [
								'story' => $obj,
								'layout_type' => 'prime',
								'partial_id' => $partial_id,
								'watch' => 'no',
								'custom_landscape_class' => 'title-container',
								'display_relative_timestamp' => $display_relative_timestamp,
							] );
							$close_me = true;
							?>
						</div><!-- First one -->
						<div class="remaining-stories small-12 medium-8 columns" data-equalizer>
					<?php } else { ?>
						<?php $this->single_mini_story( [
								'story' => $obj,
								'layout_type' => 'regular',
								'partial_id' => $partial_id,
								'watch' => 'yes',
								'display_relative_timestamp' => $display_relative_timestamp,
								] ); ?>
					<?php }
				}
				$counter++;
			if ( $close_me && ( $count_headlines ) === $counter ) { ?>
				</div><!-- right four -->
			<?php } ?>
			<?php } ?>
		</div>
	<?php
	}

	/**
	* A mini single story content block as part of 2 x 2 or 1 + 2 x 2 (5)
	*/
	public function single_mini_story( $args) {
		$obj = $args['story'];
		$defaults = [
			'layout_type' => 'prime',
			'partial_id' => '',
			'watch' => 'no',
			'custom_landscape_class' => '',
			'render_partial' => false,
			'display_relative_timestamp' => true,
		];
		$args = wp_parse_args( $args, $defaults );
		$layout['prime'] = array(
			'wrapper_class' => '',
			'image_class' => 'small-12 medium-6 large-12 prime',
			'image_size' => 'secondary-wells',
			'title_class' => 'small-12 medium-6 large-12',
		);
		$layout['regular'] = array(
			'wrapper_class' => $args['render_partial'] ? '' : 'small-12 medium-6',
			'image_class' => 'small-3 medium-4 large-4 mini-image',
			'image_size' => 'chiwire-small-square',
			'title_class' => 'small-9 medium-8 large-8 mini-title',
		);
		$layout['vertical'] = array(
			'wrapper_class' => $args['render_partial'] ? '' : 'small-12 medium-6',
			'image_class' => 'small-3 medium-12 large-4',
			'image_size' => 'chiwire-small-square',
			'title_class' => 'small-9 medium-12 large-8',
		);
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$author          = $this->hp_get_article_authors( $obj );
			remove_filter( 'the_excerpt', 'wpautop' );
			$story_excerpt = apply_filters( 'the_excerpt', $obj->get_excerpt() );
			$story_long_excerpt = apply_filters( 'the_excerpt', $obj->get_long_excerpt() );
			add_filter( 'the_excerpt', 'wpautop' );
		}
		?>
		<div class="js-<?php echo esc_attr( str_replace( '_', '-', $args['partial_id'] ) ); ?> single-mini-story  <?php echo esc_attr( $layout[ $args['layout_type'] ]['wrapper_class'] ); ?>" <?php echo 'yes' === $args['watch'] ? esc_attr( 'data-equalizer-watch' ) : esc_attr( '' ); ?>>
		<div class="columns <?php echo esc_attr( $layout[ $args['layout_type'] ]['image_class'] ); ?>">
			<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="image" data-event-action="navigate-hp-mini-story-wells">
			<?php
				$featured_image_id = $obj->get_featured_image_id();
		if ( $featured_image_id ) {
			$attachment = wp_get_attachment_metadata( $featured_image_id );
			if ( $attachment ) {
				$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'right', $layout[ $args['layout_type'] ]['image_size'] );
				echo wp_kses_post( $image_markup );
			}
		}
			?>
			</a>
		</div>
		<div class="columns <?php echo esc_attr( $layout[ $args['layout_type'] ]['title_class'] ); ?> show-for-portrait">
			<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="content" data-event-action="navigate-hp-mini-story-wells">
				<h3><?php echo esc_html( $obj->get_title() ); ?></h3>
			</a>
			<?php if ( 'prime' === $args['layout_type'] ) { ?>
			<div class="prime-excerpt">
				<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
					<div class="show-for-medium hide-for-large-up">
					<p class="excerpt">
						<?php echo wp_kses_post( $story_excerpt ); ?>
					</p>
					</div>
					<div class="show-for-large">
						<p class="excerpt">
							<?php echo wp_kses_post( $story_long_excerpt ); ?>
						</p>
					</div>
				</a>
			</div>
			<?php } ?>
		</div>
		<div class="columns <?php echo esc_attr( $layout[ $args['layout_type'] ]['title_class'] ); ?> show-for-landscape <?php echo esc_attr( $args['custom_landscape_class'] ); ?>">
			<a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="content" data-event-action="navigate-hp-mini-story-wells">
				<h3><?php echo esc_html( $obj->get_title() ); ?></h3>
			</a>
			<?php if ( 'prime' === $args['layout_type'] ) { ?>
			<div class="prime-excerpt">
				<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
					<div class="hide-for-medium hide-for-large-up">
						<p class="excerpt">
							<?php echo wp_kses_post( $story_excerpt ); ?>
						</p>
					</div>
					<div class="show-for-medium">
						<p class="excerpt">
							<?php echo wp_kses_post( $story_long_excerpt ); ?>
						</p>
					</div>
				</a>
			</div>
			<?php } ?>
		</div>
		<div class="columns small-12 show-for-large-up byline"><?php $this->homepage_byline( $obj, $author, $args['display_relative_timestamp'] ); ?></div>
		</div>
		<?php
	}
	/**
	 * Fetch and output content from the specified section
	 * @param $content_query
	 */
	public function cst_dear_abby_recommendation_block( $content_query ) {

		$cache_key = md5( json_encode( $content_query ) );
		$cached_content = wpcom_vip_cache_get( $cache_key );
		if ( false === $cached_content ) {
			$items = new \WP_Query( $content_query );
			ob_start();
			if ( $items->have_posts() ) { ?>
				<div class="large-10 medium-offset-1 post-recommendations">
					<h3>Previously from Dear Abby</h3>
				<?php
				while ( $items->have_posts() ) {
					$items->the_post();
					$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
					?>
					<div class="columns large-3 medium-6 small-12 recommended-post">
						<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="dear-abby" data-event-action="click-text">
							<?php echo esc_html( $obj->get_title() ); ?>
						</a>
					</div>
				<?php } ?>
				</div>
			<?php
			}
			$cached_content = ob_get_clean();
			wpcom_vip_cache_set( $cache_key, $cached_content, 'default', 5 * MINUTE_IN_SECONDS );
		}
		echo wp_kses_post( $cached_content );
	}

	/**
	 * Previously from / recommendations content block
	 * @param $feed_url
	 * @param $section_name
	 */
	public function cst_post_recommendation_block( $feed_url, $section_name ) {

		$cache_key = md5( $feed_url );
		$result = wpcom_vip_cache_get( $cache_key, 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
		if ( false === $result ) {
			$response = wpcom_vip_file_get_contents( $feed_url );
			if ( ! is_wp_error( $response ) ) {
				$result = json_decode( $response );
				wpcom_vip_cache_set( $cache_key, $result, 'default', 5 * MINUTE_IN_SECONDS );
			}
		}
		?>
		<div class="cst-recommendations columns">
			<hr>
			<h3>Previously from <?php esc_html_e( $section_name ); ?></h3>
			<hr>
			<div class="row">
		<?php foreach ( $result->pages as $item ) {
			$chart_beat_top_content = (array) $item->metrics->post_id->top;
			$image_url = false;
			$image_markup = '';
			if ( ! empty( $chart_beat_top_content ) && is_array( $chart_beat_top_content ) ) {
				$top_item = array_keys( $chart_beat_top_content, max( $chart_beat_top_content ) );
				if ( isset( $top_item[0] ) ) {
					$image_url = $this->get_remote_featured_image( $top_item[0] );
					$obj = \CST\Objects\Post::get_by_post_id( $top_item[0] );
					$sponsored_markup = '';
					if ( $obj ) {
						if ( $obj->get_sponsored_content() ) {
							$sponsored_markup = '<div class="sponsored-notification"></div>';
						}
					}
				}
			}
			$temporary_title       = strtok( $item->title, '|' );
			$temporary_title       = strtok( $temporary_title, '–' );
			$article_curated_title = trim( $temporary_title );
			if ( $image_url ) {
				$image_markup = sprintf( '<img class="-amp-fill-content -amp-replaced-content" src="%1$s" width="80" height="80" >', esc_url( $image_url ) );
			} else {
				$image_markup = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="80" height="80" viewbox="-4 -4 40 40">
<path d="M28 8v-4h-28v22c0 1.105 0.895 2 2 2h27c1.657 0 3-1.343 3-3v-17h-4zM26 26h-24v-20h24v20zM4 10h20v2h-20zM16 14h8v2h-8zM16 18h8v2h-8zM16 22h6v2h-6zM4 14h10v10h-10z"></path>
</svg>';
			}
			?>
				<div class="cst-recommended-content columns medium-6 small-12">
					<div class="cst-article">
					<div class="cst-recommended-image -amp-layout-size-defined">
						<a href="<?php echo esc_url( $item->path ); ?>" title="<?php echo esc_html( $article_curated_title ); ?>" class="cst-rec-anchor" data-on="click" data-event-category="previous-from" data-event-action="click-image">
								<?php echo wp_kses( $image_markup, CST()->recommendation_kses ); ?>
						</a>
					</div>
						<a href="<?php echo esc_url( $item->path ); ?>" title="<?php echo esc_html( $article_curated_title ); ?>" class="cst-rec-anchor" data-on="click" data-event-category="previous-from" data-event-action="click-text">
							<span><?php echo esc_html( $article_curated_title ); ?></span>
						</a>
						<?php echo wp_kses_post( $sponsored_markup ); ?>
				</div>
			</div>
		<?php } ?>
			</div>
		</div>
<?php

	}

		/**
	 * @param $post_id
	 *
	 * @return bool|string
	 *
	 */
	function get_remote_featured_image( $post_id ) {
		$article = \CST\Objects\Post::get_by_post_id( (int) $post_id );
		if ( $article ) {
			$attachment_id = $article->get_featured_image_id();
			$featured_image_url = wp_get_attachment_image_url( $attachment_id, 'chiwire-small-square' );
			if ( ! $featured_image_url ) {
				return false;
			}
			return $featured_image_url;
		}
		return false;
	}

	/**
	 * @param $slug
	 *
	 * @return array
	 */
	public function cst_nativo_determine_positions( $slug ) {

		$positions = array();
		switch ( $slug ) {
			case 'news':
				$positions = array( 'News1', 'News2' );
				break;
			case 'chicago':
				$positions = array( 'NewsChi1', 'NewsChi2' );
				break;
			case 'crime':
				$positions = array( 'NewsCrime1', 'NewsCrime2' );
				break;
			case 'the-watchdogs':
				$positions = array( 'NewsWatch1', 'NewsWatch2' );
				break;
			case 'nation-world':
				$positions = array( 'NewsNation1', 'NewsNation2' );
				break;
			case 'education':
				$positions = array( 'NewsEdu1', 'NewsEdu2' );
				break;
			case 'transportation':
				$positions = array( 'NewsTrans1', 'NewsTrans2' );
				break;
			case 'business':
				$positions = array( 'NewsBus1', 'NewsBus2' );
				break;
			case 'sneed':
				$positions = array( 'NewsSneed1', 'NewsSneed2' );
				break;
			case 'chicago-politics':
				$positions = array( 'PolChi1', 'PolChi2' );
				break;
			case 'springfield-politics':
				$positions = array( 'PolSpring1', 'PolSpring2' );
				break;
			case 'washington-politics':
				$positions = array( 'PolWash1', 'PolWash2' );
				break;
			case 'lynn-sweet-politics':
				$positions = array( 'PolSweet1', 'PolSweet2' );
				break;
			case 'rick-morrissey':
				$positions = array( 'SportsMorrissey1', 'SportsMorrissey2' );
				break;
			case 'rick-telander':
				$positions = array( 'SportsTelander1', 'SportsTelander2' );
				break;
			case 'cubs-baseball':
				$positions = array( 'SportsCubs1', 'SportsCubs2' );
				break;
			case 'white-sox':
				$positions = array( 'SportsSox1', 'SportsSox2' );
				break;
			case 'bears':
				$positions = array( 'SportsBears1', 'SportsBears2' );
				break;
			case 'blackhawks':
				$positions = array( 'SportsHawks1', 'SportsHawks2' );
				break;
			case 'bulls':
				$positions = array( 'SportsBulls1', 'SportsBulls2' );
				break;
			case 'outdoor':
				$positions = array( 'SportsOutdoor1', 'SportsOutdoor2' );
				break;
			case 'fire':
				$positions = array( 'SportsFire1', 'SportsFire2' );
				break;
			case 'colleges':
				$positions = array( 'SportsColleges1', 'SportsColleges2' );
				break;
			case 'entertainment':
				$positions = array( 'Entertainment1', 'Entertainment2' );
				break;
			default:
				$positions = array( 'News1', 'News2' );
				break;
		}
		return $positions;
	}

	/**
	 * Tracking_Pixels_Handler
	 *
	 * add script based on what the section front or what section the story belongs to
	*/

	public function cst_tracking_pixels() {

		if ( is_single() || is_tax() ) {
			$found = false;
			$trackers = array(
				'blackhawks' => '6655a88f1aa976a9',
				'blackhawks-hockey' => '6655a88f1aa976a9',
				'cubs' => 'f73b65fe8a643ce0',
				'cubs-baseball' => 'f73b65fe8a643ce0',
				'white-sox' => 'ea36f07c77f599cb',
			);
			if ( is_single() ) {
				$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
				$post_sections  = $obj->get_section_slugs();
				while ( $post_sections ) {
					$section_name = array_pop( $post_sections );
					if ( isset( $trackers[ $section_name ] ) ) {
						$section_id = $trackers[ $section_name ];
						$found = true;
						break;
					}
				}
			}
			if ( is_tax() ) {
				$section_name = get_queried_object()->slug;
				if ( isset( $trackers[ $section_name ] ) ) {
					$section_id = $trackers[ $section_name ];
					$found = true;
				}
			}
			if ( $found ) {
				wp_enqueue_script( 'centro', esc_url( get_stylesheet_directory_uri() . '/assets/js/vendor/centro-track.js' ), array(), null, true );
				wp_localize_script( 'centro', 'Centro', array(
					'id'         => $section_id,
				) );
			}
		}
	}
	/**
	 * @return string
	 *
	 * Determine and return the slug for use in headlines slider, sidebar and other template files.
	 */
	public function slug_detection() {
		if ( is_author() ) {
			$primary_slug = 'news';
		} elseif ( is_single() ) {
			$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
			$primary_section = $obj->get_primary_parent_section();
			$primary_slug = $primary_section->slug;
			if ( ! in_array( $primary_slug, CST_Frontend::$post_sections ) ) {
				$parent_terms = get_term( $primary_section->parent, 'cst_section' );
				if ( is_wp_error( $parent_terms ) ) {
					$primary_slug = $primary_section->slug;
				} elseif ( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
					$child_terms = get_term( $parent_terms->parent, 'cst_section' );
					$primary_slug = $child_terms->slug;
				} else {
					$primary_slug = $parent_terms->slug;
				}
			}
		} else {
			$primary_section = get_queried_object();
			if ( isset( $primary_section ) && ( 'cst_section' === $primary_section->taxonomy ) ) {
				if ( 0 !== $primary_section->parent ) {
					$primary_slug = $primary_section->slug;
					if ( ! in_array( $primary_slug, CST_Frontend::$post_sections ) ) {
						$current_section = get_term( $primary_section->parent, 'cst_section' );
						if ( ! in_array( $current_section->slug, CST_Frontend::$post_sections ) ) {
							$current_section = get_term( $current_section->parent, 'cst_section' );
							if ( ! in_array( $current_section->slug, CST_Frontend::$post_sections ) ) {
								$current_section = get_term( $current_section->parent, 'cst_section' );
							} else {
								$primary_slug = $current_section->slug;
							}
						} else {
							$primary_slug = $current_section->slug;
						}
					}
				} else {
					$primary_slug = $primary_section->slug;
				}
			} else {
				$primary_slug = 'news';
			}
		}

		return $primary_slug;
	}

	/**
	* @param \CST\Objects\Post $obj
	* @param $author
	* @param $primary_section
	* @param $image_size
	* @param  $tracking_location_name
	* Display an article container and related markup in the homepage wells
	*/
	public function well_article_container_markup( \CST\Objects\Post $obj, $author, $primary_section, $image_size = 'chiwire-header-large', $tracking_location_name ) {
		?>
		<div class="article-container">
	<?php $this->well_article_markup( $obj, $author, $primary_section, $image_size, $tracking_location_name ); ?>
		</div>
		<?php
	}

	/**
	* @param \CST\Objects\Post $obj
	* @param $author
	* @param $primary_section
	* @param $image_size
	* @param  $tracking_location_name
	* Display an article anchor markup in the homepage wells
	*/
	public function well_article_markup( \CST\Objects\Post $obj, $author, $primary_section, $image_size = 'chiwire-header-small', $tracking_location_name ) {
		?>
		<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-<?php echo esc_attr( $tracking_location_name ); ?>" >
		<?php
		$featured_image_id = $obj->get_featured_image_id();
		if ( $featured_image_id ) {
			if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) {
				echo wp_kses_post( $attachment->get_html( $image_size ) );
			}
		}
		?>
		<div class="article-title <?php echo esc_attr( strtolower( $primary_section->name ) ); ?>-cat">
			<h3><?php echo esc_html( $obj->get_title() ); ?></h3>
			<?php echo wp_kses_post( apply_filters( 'the_excerpt', $obj->get_excerpt() ) ); ?>
			<span>By <?php echo esc_html( $author ); ?></span>
		</div>
		</a>
		<?php
	}

	/**
	 * @param \CST\Objects\Post $obj
	 *
	 * @return string
	 * Return author for use in homepage wells.
	 */
	public function get_article_author( \CST\Objects\Post $obj ) {
		if ( $byline = $obj->get_byline() ) {
			$author = $byline;
		} else {
			$authors = $obj->get_authors();
			$author_data = $authors[0];
			$author = $author_data->get_display_name();
		}
		return $author;
	}

	/**
	 * End of head tag for Google Tag Manager as per GTM implementation
	 */
	public function action_head_early_elements() {

?>
<!-- Chartbeat header -->
<script type='text/javascript'>var _sf_startpt=(new Date()).getTime()</script>
<!-- End Chartbeat header -->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5VPTL3X');</script>
<!-- End Google Tag Manager -->
<?php
	}
	/**
	* Matching GTM script
	*/
	public function action_body_start() {

?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5VPTL3X"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
	}

	/**
	* @param \CST\Objects\Post $obj
	*
	* @return string
	*
	* Generate and return markup for article author(s) for use on the homepage
	*/
	public function hp_get_article_authors( \CST\Objects\Post $obj ) {
		$authors_open = '<span class="post-meta-author">';
		$authors_close = '</span>';
		$authors = array();
		if ( $byline = $obj->get_byline() ) {
			$authors = array( $byline );
		} else {
			foreach ( $obj->get_authors() as $author ) {
				$authors[]= '<a href="' . esc_url( $author->get_permalink() ) . '"
				data-on="click" data-event-category="hp-author-byline" data-event-action="view author">' .
				$author->get_display_name() . '</a>';
			}
		}
		return $authors_open . implode( ' and ', $authors ) . $authors_close;
	}
	/**
	* Adding OpenX script tag in header section of markup for all
	* site templates that might display advertising
	*/

	public function action_cst_openx_header_bidding_script() {
		if ( is_page() || is_singular( 'cst_feature' ) || is_post_type_archive( 'cst_feature' ) ) {
			return;
		}
		wp_enqueue_script( 'openx-async', '//suntimes-d.openx.net/w/1.0/jstag?nc=61924087-suntimes', array(), null, false );
	}
	/**
	 * Checks if we have a video player for embedding purposes for a section front
	 * Counter is the article number / placement position within the section front.
	 * @param $counter int
	 */
	function cst_section_front_video( $counter ) {
		if ( 3 === $counter ) {
			if ( is_tax() ) {
				if ( array_key_exists( get_queried_object()->slug, $this->send_to_news_embeds ) ) {
					return $this->inject_send_to_news_video_player( get_queried_object()->slug, get_queried_object_id() );
				}
			}
		}

	}

	/**
	* @param $slug
	* @param $id
	* Inject SendToNews responsive video player into markup.
	* @return string
	*/
	function inject_send_to_news_video_player( $slug, $id ) {
		$template   = '<div class="video-injection"><div class="s2nPlayer k-%1$s %2$s" data-type="float"></div><script type="text/javascript" src="'. esc_url( 'https://embed.sendtonews.com/player3/embedcode.js?fk=%1$s&cid=4661&offsetx=0&offsety=50&floatwidth=300&floatposition=top-left' ) . '" data-type="s2nScript"></script></div>';
		$markup     = sprintf( $template, esc_attr( $this->send_to_news_embeds[ $slug ] ), esc_attr( $id ) );
		return $markup;
	}
	/**
	 * Do not display section heading in the regular place
	 *  for the listed section names (based on slug)
	 * Immediately below the RSS area of the section front
	 *
	 * @return  boolean
	 * Pretty title for section front
	 */
	function action_cst_section_front_heading() {

		if ( $this->do_sponsor_header() ) {
			$this->sponsor_header();
			return true;
		} else {
			$this->display_section_front_title( 'row grey-background wire upper-heading', 'columns small-12', '' );
			return false;
		}
	}
	/**
	 * Display section heading in the upper location
	 * only for the sections listed
	 * Immediately above the RSS area of the section front
	 *
	 * Pretty title for section front
	 */
	function action_cst_section_front_upper_heading() {
		if ( $this->do_sponsor_header() ) {
			$this->sponsor_header();
		}
	}

	/**
	* Evaluation options to display a sponsor banner
	* Display on section header, article header, section and article header on single article page
	* or everything - section header, article header on index/section page and
	* article header on single article page
	* @param string $section_id
	*
	* @return bool
	*/
	function do_sponsor_header( $section_id = '' ) {
		if ( '' === $section_id ) {
			// Section
			$term_metadata = fm_get_term_meta( get_queried_object_id(), 'cst_section', 'sponsor', true );
		} else {
			// Article
			$term_metadata = fm_get_term_meta( (int) $section_id , 'cst_section', 'sponsor', true );
		}
		if ( ! empty( $term_metadata['sponsor_options'] ) ) {
			$sponsor_options = array_flip( $term_metadata['sponsor_options'] );
			if ( array_key_exists( 'everything', $sponsor_options ) ) {
				return true;
			}
			if ( array_key_exists( 'section', $sponsor_options ) ) {
				if ( '' === $section_id ) { // Only return true if displaying on a section
					return true;
				}
			}
			if ( array_key_exists( 'article', $sponsor_options ) ) {
				if ( (int) $section_id && ! is_tax() ) {
					return true;
				}
			}
		}
		return false;
	}
	/**
	* Handle display of Section title and determine if a section sponsor image
	* and link should also be displayed
	* Accommodate same on article display
	* @param string $section_id
	*/

	function sponsor_header( $section_id = '' ) {
		// Handle sponsor image and link
		if ( '' === $section_id ) {
			$term_metadata = fm_get_term_meta( get_queried_object_id(), 'cst_section', 'sponsor', true );
			$class = 'grey-background wire upper-heading';
		} else {
			$term_metadata = fm_get_term_meta( (int) $section_id , 'cst_section', 'sponsor', true );
			$class = 'upper-heading';
		}
		$name_width = 'small-12'; // DIV size if no sponsor image
		$sponsor_markup = '';
		if ( ! empty( $term_metadata ) ) {
			$start_date = $term_metadata['start_date'];
			$end_date = $term_metadata['end_date'];
			$today = time();
			if ( ( $today >= $start_date )  && ( $today <= $end_date ) ) {
				$sponsor_template = '
<div class="%1$s">
	<a href="%2$s" target="_blank">
		<img style="float:right;" src="%3$s" width="%4$s" height="%5$s">
	</a>
</div>
';
				$sponsor_image = wp_get_attachment_image_src( intval( $term_metadata['image'] ), array( 320, 50 ) );
				if ( $sponsor_image ) {
					$sponsor_markup = sprintf( $sponsor_template,
						( '' !== $section_id ) ? esc_attr( '' ) : esc_attr( 'columns medium-7 small-12' ),
						esc_url( $term_metadata['destination_url'] ),
						esc_url( $sponsor_image[0] ),
						esc_attr( $sponsor_image[1] ),
						esc_attr( $sponsor_image[2] )
					);
				}
				// DIV size if there is a sponsor image
				$name_width = 'medium-5 small-12';
			}
		}
		if ( '' !== $section_id ) {
			echo wp_kses_post( $sponsor_markup );
		} else {
			$this->display_section_front_title( $class, $name_width, $sponsor_markup );
		}
	}

	/**
	* Display Section Front Title with/without sponsorship
	* @param $class
	* @param $name_width
	* @param $sponsor_markup
	*/
	public function display_section_front_title( $class, $name_width, $sponsor_markup ) {
		$section_obj = get_queried_object();
		$section_link = wpcom_vip_get_term_link( $section_obj->term_id , 'cst_section' );
		if ( is_wp_error( $section_link ) ) {
			$section_link = '#';
		}
		?>
<section class="<?php echo esc_attr( $class ); ?>">
	<div class="<?php echo esc_attr( $name_width ); ?> section-meta">
		<div class="small-11 section-name columns">
			<div class="section-feed">
				<div class="icon">
					<a href="<?php echo esc_url( get_term_feed_link( $section_obj->term_id , 'cst_section' ) ); ?>"  data-on="click" data-event-category="navigation" data-event-action="navigate-sf-feed"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/rss.png" alt="rss"></a>
				</div>
			</div>
		<h1><a href="<?php echo esc_url( $section_link ); ?>" class="section-front" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-upper-heading"><?php echo esc_html( str_replace( '_', ' ', $section_obj->name ) ); ?></a></h1>
		</div>
	</div>
	<?php echo wp_kses_post( $sponsor_markup ); ?>
</section>
<?php
		$this->determine_and_display_section_subnav( $section_obj );
	}

	/**
	* @param $section_obj
	* Determine and display a sub navigation on section fronts
	* If a child sub nav display a link to the parent section before the sub nav
	*/
	public function determine_and_display_section_subnav( $section_obj ) {
		$parent = $section_obj->term_id;
		echo wp_kses_post( $this->get_sections_nav_markup( $parent, false ) );
	}
	/**
	* @return bool|object
	*
	* Get object for article / section front
	*/
	public function get_current_object() {
		$current_obj = false;
		if ( is_single() ) {
			$current_obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
		} else if ( is_tax() ) {
			$current_obj = get_queried_object();
		}
		return $current_obj;
	}
	/**
	* @return array|bool|null|object|string|WP_Error|WP_Term
	 *
	 * Get conditional nav object / setting
	*/
	public function get_conditional_nav() {
		$current_obj = $this->get_current_object();
		if ( is_single() ) {
			if ( $current_obj ) {
				$conditional_nav = $current_obj->get_primary_parent_section();
				if ( ! $conditional_nav ) {
					$conditional_nav = $current_obj->get_child_parent_section();
					if ( ! in_array( $conditional_nav, CST_Frontend::$post_sections, true ) ) {
						$conditional_nav = $current_obj->get_grandchild_parent_section();
					}
				}
			} else {
				$conditional_nav = 'menu';
			}
		} elseif ( is_tax() ) {
			if ( 'cst_section' === $current_obj->taxonomy ) {
				if ( 0 !== $current_obj->parent ) {
					$parent_terms = get_term( $current_obj->parent, 'cst_section' );
					if ( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections, true ) ) {
						$child_terms = get_term( $parent_terms->parent, 'cst_section' );
						$conditional_nav = $child_terms;
					} else {
						$conditional_nav = $parent_terms;
					}
				} else {
					$conditional_nav = $current_obj;
				}
			} else {
				$conditional_nav = 'news';
			}
		} else {
			$conditional_nav = 'menu';
		}
		return $conditional_nav;
	}
	/**
	* Create a section navigation list for use in the off canvas menu
	* Primarily for backup purposes
	* @param int $parent
	* @param bool $off_canvas
	* @return bool|mixed
	*/
	public function get_sections_nav_markup( $parent = 0, $off_canvas = true ) {
		$custom_subnavigation = array(
			'sports' => array(),
			'opinion' => array(),
			'entertainment' => array(),
			'news' => array(),
			'columnists' => array(),
		);
		if ( $current_obj = $this->get_current_object() ) {
			foreach ( $custom_subnavigation as $item => $value) {
				$custom_subnavigation[$item] = wpcom_vip_get_term_by( 'slug', $item, 'cst_section' );
			}
			$child_parent = wpcom_vip_get_term_by( 'id', $current_obj->parent, 'cst_section' );
			// Custom nav handling here
			if ( isset( $custom_subnavigation[$current_obj->slug] )
			|| $custom_subnavigation[$current_obj->slug]->term_id === $current_obj->parent
			|| ( false !== $child_parent ? $child_parent->parent : $current_obj->parent ) ) {
				$conditional_nav = $current_obj->slug . '-subnav';
				if ( array_key_exists( $conditional_nav.'-menu', get_registered_nav_menus() ) ) {
						$container = $off_canvas ? 'cst-off-canvas-navigation-container' : 'cst-navigation-container columns';
						$chosen_parameters = array(
								'theme_location' => $conditional_nav.'-menu',
								'fallback_cb' => false,
								'container_class' => $container,
								'walker' => new GC_walker_nav_menu(),
								'items_wrap' => '<div class="nav-holder"><div class="nav-descriptor"><ul id="%1$s" class="section-front">%3$s</ul></div></div>',
								'echo' => false,
						);
						if ( false === ( $section_navigation = wpcom_vip_cache_get( 'section_sub_nav_cache_key' . '_' . $current_obj->slug, 'cst' ) ) ) {
							$section_navigation = wp_nav_menu( $chosen_parameters );
							wpcom_vip_cache_set( 'section_sub_nav_cache_key' . '_' . $current_obj->slug, 'cst', 1 * WEEK_IN_SECONDS );
						}

				} else {
					$section_navigation = $this->generate_section_subnav( $parent, $current_obj, $off_canvas );
				}
			} else {
				$section_navigation = $this->generate_section_subnav( $parent, $current_obj, $off_canvas );
			}
		}

		return $section_navigation;

	}

	/**
	* @param $parent
	* @param $current_obj
	* @param $off_canvas
	* return $string
	* Subnav below section title above section content - typically child section links
	*/
	public function generate_section_subnav( $parent, $current_obj, $off_canvas ) {
		if ( false === ( $section_navigation = wpcom_vip_cache_get( 'section_nav_cache_key' . '_' . $parent, 'cst' ) )  || WP_DEBUG ) {
			// Generate dynamic section based navigation links
			$sections = get_terms( array(
				'taxonomy'         => 'cst_section',
				'hide_empty'       => false,
				'include_children' => false,
				'parent'           => 0 === $current_obj->parent ? $parent : $current_obj->parent,
				)
			);
			$container = $off_canvas ? 'cst-off-canvas-navigation-container' : 'cst-navigation-container columns';
			$section_navigation = '<div class="' . esc_attr( $container ) . ' section-backup"><div class="nav-holder"><div class="nav-descriptor sections-nav">';
			$section_navigation .= '<ul id="menu-section-subnav" class="menu">';
			foreach ( $sections as $section ) {
				if ( $section->term_id !== $current_obj->term_id ) {
					$section_link_url = wpcom_vip_get_term_link( $section->term_id );
					if ( ! is_wp_error( $section_link_url ) ) {
						$section_navigation .= sprintf( '<li class="section-nav-item"><a href="%1$s" data-on="click" data-event-category="navigation - %2$s-section-subnav" data-event-action="navigate">%2$s</a></li>', esc_url( $section_link_url ), esc_html( $section->name ) );
					}
				}
			}
			// Add parent link as appropriate
			$parent_link_id = ( 0 === $current_obj->parent ) ? $parent : $current_obj->parent;
			if ( $parent != $parent_link_id ) {
				$link_to_parent = wpcom_vip_get_term_link( $parent_link_id );
				if ( ! is_wp_error( $link_to_parent ) ) {
					$nav_parent = wpcom_vip_get_term_by( 'id', $parent_link_id, 'cst_section' );
					if ( false !== $nav_parent ) {
						$section_navigation .= sprintf( '<li class="section-nav-item"><a href="%1$s" data-on="click" data-event-category="navigation - %2$s-section-subnav" data-event-action="navigate">%2$s</a></li>', esc_url( $link_to_parent ), esc_html( $nav_parent->name ) );
					}
				}
			}
			$section_navigation .= '</ul></div></div></div>';
			wpcom_vip_cache_set( 'section_nav_cache_key' . '_' . $parent, $section_navigation, 'cst', 1 * WEEK_IN_SECONDS );
		}
		return $section_navigation;
	}
	/**
	* Generate off canvas menu items
	* Generate a conditional and a sectional
	*/
	public function generate_off_canvas_menu() {
		if ( $this->display_minimal_nav() ) {
			return;
		}
		if ( is_front_page() || is_singular() || is_tax() || is_post_type_archive() ) {
			$chosen_parameters = array(
					'theme_location' => 'homepage-menu',
					'container' => '',
					'depth' => 2,
					'fallback_cb' => false,
					'walker' => new GC_walker_nav_menu(),
					'items_wrap' => '<ul id="%1$s-oc" class="off-canvas-list cst-off-canvas-navigation-container homepage">%3$s</ul>',
					 );
		} else if ( $current_obj = $this->get_current_object() ) {
			$conditional_nav = $this->get_conditional_nav();
			if ( array_key_exists( $conditional_nav->slug.'-menu', get_registered_nav_menus() ) ) {
				// Nav menu $conditional_nav->slug.'-menu' exists but is unassigned what to do?
				if ( has_nav_menu( $conditional_nav->slug.'-menu' ) ) {
					$chosen_parameters = array( 'theme_location' => $conditional_nav->slug.'-menu', 'fallback_cb' => false, 'container_class' => 'cst-off-canvas-navigation-container conditional', 'walker' => new GC_walker_nav_menu() ) ;
			} else {
				echo wp_kses_post( $this->get_sections_nav_markup() );
					return;
				}
			} else {
				$chosen_parameters = array( 'theme_location' => 'news-menu', 'fallback_cb' => false, 'container_class' => 'cst-off-canvas-navigation-container undefined-slug', 'walker' => new GC_walker_nav_menu() ) ;
			}
		} else {
			$chosen_parameters = array( 'theme_location' => 'news-menu', 'fallback_cb' => false, 'container_class' => 'cst-off-canvas-navigation-container undetermined', 'walker' => new GC_walker_nav_menu() );
		}
		$cache_key = $chosen_parameters['theme_location'];
		$navigation_markup    = wpcom_vip_cache_get( $cache_key, 'cst' );
		if ( false === $navigation_markup || WP_DEBUG ) {
			$chosen_parameters['echo'] = false;
			$navigation_markup = wp_nav_menu( $chosen_parameters );
			wpcom_vip_cache_set( $cache_key, $navigation_markup, 'cst', 1 * WEEK_IN_SECONDS );
		}
		echo wp_kses_post( $navigation_markup );
	}
	/**
	* http://wordpressvip.zendesk.com/hc/requests/56671
	*/
	function cst_remove_extra_twitter_js() {
		wp_deregister_script( 'twitter-widgets' );
	}

	/**
	* Display masthead navigation if needed
 	*
 	* @param string $page_type
 	*
 	*/
	public function masthead_navigation( $page_type ) {
		$page_types = array(
			'homepage' => array(
					'container_class' => 'columns small-12 show-for-medium-up show-for-landscape homepage-nav-wrapper',
					'items_wrap'      => '<div class="homepage-nav-holder columns"><ul id="%1$s" class="homepage">%3$s</ul></div>',
					'location'        => 'homepage-masthead',
			),
			'section-front' => array(
					'container_class' => 'cst-navigation-container',
					'items_wrap' => '<div class="nav-holder"><div class="nav-descriptor"><ul id="%1$s" class="section-front">%3$s</ul></div></div>',
					'location'        => 'homepage-masthead',
			),
			'homepage-itn' => array(
					'container_class' => 'cst-navigation-container',
					'items_wrap' => '<div class="nav-holder"><div class="nav-descriptor"><ul><li>In the news:</li></ul><ul id="%1$s" class="homepage-itn">%3$s</ul></div></div>',
					'location'        => 'homepage-itn',
			),
		);
		if ( array_key_exists( $page_type, $page_types ) ) {
			$masthead_nav_markup = wpcom_vip_cache_get( 'cst_' . $page_type, 'default' );
			if ( false === $masthead_nav_markup || WP_DEBUG ) {
				$masthead_nav_markup = wp_nav_menu( array(
					'theme_location'  => $page_types[ $page_type ]['location'],
					'echo'            => false,
					'fallback_cb'     => false,
					'depth'           => 1,
					'container_class' => $page_types[ $page_type ]['container_class'],
					'items_wrap'      => $page_types[ $page_type ]['items_wrap'],
					)
				);
				wpcom_vip_cache_set( 'cst_' . $page_type, $masthead_nav_markup, 'default', 1 * DAY_IN_SECONDS );
			}
			echo wp_kses_post( $masthead_nav_markup );
		} else {
			// Fallback
		}
	}
	/**
	*  Inject dfp ad settings, variables into header before gpt script call
	*/
	public function setup_dfp_header_ad_settings() {
		if ( ! is_404() ) {
			CST()->dfp_handler->ad_header_settings();
		}
	}

	/**
	* Display Chartbeat engagement based article list on home page
	*/
	public function enqueue_chartbeat_react_engagement_script() {
		if ( is_front_page() && function_exists('jetpack_is_mobile') && ! jetpack_is_mobile() ) {
			$site = CST()->dfp_handler->get_parent_dfp_inventory();
			$chartbeat_file_name = 'main.3f878c34-cb-dev-test.js';
			if ( 'chicago.suntimes.com' === $site ) {
				$chartbeat_file_name = 'main.b8f7cb34-cb-prod.js';
			}
			if ( is_front_page() ) {
				wp_enqueue_script( 'chartbeat_engagement', esc_url( get_stylesheet_directory_uri() . '/assets/js/' . $chartbeat_file_name ), array(), null, true );
			}
		}
	}
	/**
	* Add inspectlet script to all pages
	*/
	public function enqueue_inspectlet_script(){
	    wp_enqueue_script( 'inspectlet', esc_url( get_stylesheet_directory_uri() . '/assets/js/vendor/inspectlet-script.js' ), [], null, true );
	}
	/**
	*
	* Inject supplied Yieldmo tag if singular and mobile and over 9 paragraphs
	* Only do this on article pages
	*
	* @param $content string
	* @return string
	*/
	public function inject_yieldmo_mobile( $content ) {
		if ( is_singular( 'cst_article' ) ) {
			if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() ) {
       			$yieldmo_unit = '<div id="ym_1555064078586984494" class="ym"></div><script type="text/javascript">(function(e,t){if(t._ym===void 0){t._ym="";var m=e.createElement("script");m.type="text/javascript",m.async=!0,m.src="//static.yieldmo.com/ym.m5.js",(e.getElementsByTagName("head")[0]||e.getElementsByTagName("body")[0]).appendChild(m)}else t._ym instanceof String||void 0===t._ym.chkPls||t._ym.chkPls()})(document,window);</script>';
				$exploded = explode( '</p>', $content );
				$num_exploded = count( $exploded );
				if ( $num_exploded > 9) {
					array_splice( $exploded, 10, 0, $yieldmo_unit );
					$content = join( '</p>', $exploded );
				}
			}
		}
		return $content;
	}
	/**
	*
	* Inject supplied TCX tag if singular and mobile and over 16 paragraphs
	* Only do this on article pages
	*
	* @param $content string
	* @return string
	*/
	public function inject_tcx_mobile( $content ) {
		if ( is_singular( 'cst_article' ) ) {
			if ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() ) {
				$tcxjs = '<script src="//content.synapsys.us/embeds/placement.js?p=VSUE4YV38U&type=default_mobile&style=inline"></script>';
				$exploded = explode( '</p>', $content );
				$num_exploded = count( $exploded );
				if ( $num_exploded > 16) {
					array_splice( $exploded, 17, 0, $tcxjs );
					$content = join( '</p>', $exploded );
				}
			}
		}
		return $content;
	}
	/**
	*
	* Inject A9 test slots. Only for testing. Assume at this point the slots will be pointed to dfp
	*
	*/
	public function inject_a9( $content ) {
		if ( is_singular( 'cst_article' ) ) {
				#$a9tag = '<div id="google_ads_iframe_/61924087/slot1_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/61924087/slot1_0" title="3rd party ad content" name="google_ads_iframe_/61924087/slot1_0" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" srcdoc="" style="border: 0px; vertical-align: bottom;"></iframe></div></div>';
				$a9tag = "<div id='div-gpt-ad-test-a9'><script>googletag.cmd.push(function() { googletag.display('div-gpt-ad-test-a9'); });</script></div>";

				$exploded = explode( '</p>', $content );
				$num_exploded = count( $exploded );
				if ( $num_exploded > 3) {
					array_splice( $exploded, 4, 0, $a9tag );
					$content = join( '</p>', $exploded );
			}
		}
		return $content;
	}
		public function inject_a92( $content ) {
		if ( is_singular( 'cst_article' ) ) {
				#$a9tag = '<div id="google_ads_iframe_/61924087/slot1_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/61924087/slot1_0" title="3rd party ad content" name="google_ads_iframe_/61924087/slot1_0" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" srcdoc="" style="border: 0px; vertical-align: bottom;"></iframe></div></div>';
				$a9tag2 = "<div id='div-gpt-ad-test2-a9'><script>googletag.cmd.push(function() { googletag.display('div-gpt-ad-test-a9'); });</script></div>";

				$exploded = explode( '</p>', $content );
				$num_exploded = count( $exploded );
				if ( $num_exploded > 5) {
					array_splice( $exploded, 6, 0, $a9tag2 );
					$content = join( '</p>', $exploded );
			}
		}
		return $content;
	}
	public function inject_a9_leaderboard( $content ) {
		if ( is_singular( 'cst_article' ) ) {
				#$a9tag = '<div id="google_ads_iframe_/61924087/slot1_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/61924087/slot1_0" title="3rd party ad content" name="google_ads_iframe_/61924087/slot1_0" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" srcdoc="" style="border: 0px; vertical-align: bottom;"></iframe></div></div>';
				$a9tag3 = "<div id='div-gpt-ad-leaderboard-a9'><script>googletag.cmd.push(function() { googletag.display('div-gpt-ad-test-a9'); });</script></div>";

				$exploded = explode( '</p>', $content );
				$num_exploded = count( $exploded );
				if ( $num_exploded > 7) {
					array_splice( $exploded, 8, 0, $a9tag3 );
					$content = join( '</p>', $exploded );
			}
		}
		return $content;
	}
	/**
	*
	* Inject supplied Teads tag just before the closing body tag of single article pages
	*
	*/
	public function inject_teads_tag() {

		if ( is_page() || is_singular( 'cst_feature' ) ) {
			return;
		}
		if ( is_singular() ) {
			wp_enqueue_script( 'teads', '//a.teads.tv/page/53230/tag', [], null, true );
		}
	}

	/**
	* Determine if we should append the Public Good Take Action button
	* @param \CST\Objects\Article $obj
	* @return mixed
	*/
	public function inject_public_good_markup( $obj ) {
		if ( ! $obj ) {
			return;
		}
		if ( 'cst_article' !== $obj->get_post_type() ) {
			return;
		}
		if ( $obj->get_sponsored_content() ) {
			return;
		}
		// Selected list of content we prefer not to display this button on
		if ( $this->is_content_partner( $obj ) ) {
			return;
		}
		if ( shortcode_exists( 'takeaction' ) ) {
			echo do_shortcode( '[takeaction]' );
		}
		return;
	}

	/**
	* @param $paged
	 *
	 * @return string
	 *
	 * Inject Flipp circular ad
	 */
	public function inject_flipp( $paged ) {
		if ( $paged < 5 ) {
			$div_id_suffix = 10635 + $paged;
			$flipp_ad_markup = '<div id="circularhub_module_' . esc_attr( $div_id_suffix ) . '" style="background-color: #ffffff; margin-bottom: 10px; padding: 5px 5px 0px 5px;"></div>';
			$flipp_ad_src_escaped = esc_url( '//api.circularhub.com/' . rawurlencode( $div_id_suffix ) . '/2e2e1d92cebdcba9/circularhub_module.js?p=' . rawurlencode( $div_id_suffix ) );
			$flipp_ad_safe = $flipp_ad_markup . '<script src="' . $flipp_ad_src_escaped . '"></script>';
			echo $flipp_ad_safe;
		}
	}
	/**
	 * Determine if content destined for the display is partnership or we have
	 * an arrangement or not
	 * @param \CST\Objects\Article $obj
	 * @return bool
	 */
	public function is_content_partner( $obj ) {

		$content_partners = array(
			'Associated Press',
			'USA Today',
			'USA TODAY',
			'USA TODAY Network',
			'Georgia Nicols',
			'Abigail Van Buren',
		);
		if ( $byline = $obj->get_byline() ) {
			if ( array_key_exists( $byline, $content_partners ) ) {
				return true;
			} else {
				foreach ( $content_partners as $content_partner ) {
					if ( stristr( $byline, $content_partner ) ) {
						return true;
					}
				}
			}
		}
		$authors = get_coauthors();
		foreach ( $authors as $author ) {
			if ( array_key_exists( $author->display_name, $content_partners ) ) {
				return true;
			} else {
				foreach ( $content_partners as $content_partner ) {
					if ( stristr( $author->display_name, $content_partner ) ) {
						return true;
					}
				}
			}
		}
		return false;
	}
	/**
	* Inject sponsored content into selected article in the third paragraph
	* Does not inject into feeds
	* @param string $article_content
	* @return string $article_content
	*/
	public function inject_sponsored_content( $article_content ) {
		if ( is_feed() || is_admin() || null === get_queried_object() || 0 === get_queried_object_id() ) {
			return $article_content;
		}
		$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
		if ( 'cst_article' !== $obj->get_post_type() ) {
			return $article_content;
		}
		$after_paragraph_number = 2;
		if ( $sponsor_array = $obj->get_sponsored_content() ) {
			$matched_content = preg_match_all( '/(?:[^(p>)].*){1}/i', $article_content, $matched_items );
			if ( false === $matched_content ) {
				return $article_content;
			}
			if ( ! empty( $matched_items ) && $matched_content >= $after_paragraph_number ) {
				$matches = $matched_items[0];
				$sponsor_image_url = wp_get_attachment_image_src( $sponsor_array['sponsor_image'], array( 300, 165 ) );
				$markup_to_inject_template = '
	<div class="sponsored-insert">
	<div class="row">
		<div class="small-5 columns sponsor-thumbnail"><a href="%2$s"><img src="%5$s" width="%6$s" height="%7$s"></a></div>
		<div class="small-7 columns sponsor-wording"><div class="holder"><h4>Sponsored by <a href="%2$s" class="sponsorname">%1$s</a></h4><p>%3$s</p><p>%4$s</p><a href="%2$s"><span class="seemore">See More</span></a></div></div>
	</div>
	</div>
	';
				$content_with_sponsorship = sprintf( $markup_to_inject_template,
					esc_attr( $sponsor_array['sponsor_content_name'] ),
					esc_url( $sponsor_array['sponsor_url'] . '?utm_source=sponsored_article&utm_medium=autos' ),
					esc_attr( $sponsor_array['sponsor_line1'] ),
					esc_attr( $sponsor_array['sponsor_line2'] ),
					esc_url( $sponsor_image_url[0] ),
					esc_attr( $sponsor_image_url[1] ),
					esc_attr( $sponsor_image_url[2] )
				);
				$paragraph_with_script = trim( "\n" . $matches[2] ) . $content_with_sponsorship;
				$pos = strpos( $article_content, $matches[2] );
				if ( false !== $pos ) {
					$new_article_content = substr_replace( $article_content, $paragraph_with_script, $pos, strlen( $matches[2] ) );
					$article_content = $new_article_content;
				}
			}
		}
		return $article_content;
	}

	/**
	* Using one nav as a master, based on location in the site, remove dropdowns before display
	* Source: http://wordpress.stackexchange.com/questions/2802/display-a-portion-branch-of-the-menu-tree-using-wp-nav-menu
	* @param $items
	* @param $args
	*
	* @return mixed
	*/
	public function submenu_limit( $items, $args ) {

		if ( empty( $args->submenu ) ) {
			return $items;
		}

		$ids       = wp_filter_object_list( $items, array( 'title' => $args->submenu ), 'and', 'ID' );
		$parent_id = array_pop( $ids );
		$children  = $this->submenu_get_children_ids( $parent_id, $items );

		foreach ( $items as $key => $item ) {

			if ( ! in_array( $item->ID, $children, true ) ) {
				unset( $items[$key] );
			}
		}

		return $items;
	}

	/**
	* On GrandChild navs try and remove the section currently being displayed
	* Source: http://wordpress.stackexchange.com/questions/2802/display-a-portion-branch-of-the-menu-tree-using-wp-nav-menu
	* @param $items
	* @param $args
	*
	* @return mixed
	*/
	public function remove_current_nav_item( $items, $args ) {

		if ( empty( $args->removeitem ) ) {
			return $items;
		}

		$ids = wp_filter_object_list( $items, array( 'title' => $args->removeitem ), 'AND', 'ID' );
		foreach ( $items as $key => $item ) {
			if ( isset( $item->ID ) &&  isset( $ids[$key] ) && $ids[$key] === $item->ID ) {
				unset( $items[$key] );
				break;
			}
		}
		return $items;
	}

	/**
	* @param $id
	* @param $items
	*
	* @return array
	*
	* Source: http://wordpress.stackexchange.com/questions/2802/display-a-portion-branch-of-the-menu-tree-using-wp-nav-menu
	*/
	public function submenu_get_children_ids( $id, $items ) {

		$ids = wp_filter_object_list( $items, array( 'menu_item_parent' => $id ), 'and', 'ID' );

		foreach ( $ids as $id ) {

			$ids = array_merge( $ids, $this->submenu_get_children_ids( $id, $items ) );
		}

		return $ids;
	}
	/**
	* See also functions.php - perhaps consolidate kses through this function
	* and make all kses function calls wp_kses_post
	* @param $allowed_html
	*
	* @return array
	*/
	public function filter_wp_kses_allowed_custom_attributes( $allowed_html ) {
		$cst_custom_element_attributes = array(
			'div' => array_merge( $allowed_html['div'], array(
				'addthis:url' => true,
				'addthis:title' => true,
				'data-pgs-partner-id' => true,
				'data-pgs-keywords' => true,
				'data-pgs-target-id' => true,
				'data-pgs-location' => true,
				'data-pgs-variant' => true,
				'data-pgs-target-type' => true,
				'data-equalizer' => true,
				'data-equalizer-watch' => true,
			)),
			'a' => array_merge( $allowed_html['a'], array(
				'data-event-category' => true,
				'data-event-action' => true,
				'data-event-on' => true,
				'addthis:url' => true,
				'addthis:title' => true,
			) ),
			'span' => array_merge( $allowed_html['span'], array(
				'class' => true,
			) )
		);
		return array_merge( $allowed_html, $cst_custom_element_attributes );
	}
	public function inject_newsletter_signup( $newsletter ) {

		$newsletter_codes = array(
			'news' => array( 'title' => 'News &amp; Politics', 'code' => '062jcp97-2819pvaa' ),
			'entertainment' => array( 'title' => 'Entertainment', 'code' => '062jcp97-bf1s1y92' ),
			'sports' => array( 'title' => 'Sports', 'code' => '062jcp97-06149p3a' ),
		);
		$template = '
<div class="large-7 medium-8 small-12 columns newsletter-box">
	<div class="newsletter-sign-up">
		<h3>Sign-Up for our %1$s Newsletter&nbsp;
			<a href="https://r1.surveysandforms.com/%2$s" data-on="click" data-event-category="newsletter" data-event-action="subscribe to %1$s" target="_blank" class="button tiny info">
				<i class="fa fa-envelope"></i> Sign-Up
			</a>
		</h3>
	</div>
</div>
';
		echo wp_kses_post( sprintf( $template,
			esc_attr( $newsletter_codes[ $newsletter ]['title'] ),
			esc_attr( $newsletter_codes[ $newsletter ]['code'] )
		) );
	}

	/**
	 * Get and return an array of sections associated with this single object - article | gallery
	 * @return array|bool
	 *
	 */
	public function get_article_section_list() {

		$section_list = false;

		if ( is_singular() ) {
			$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
			if ( $obj ) {
				$sections = $obj->get_sections();
				$section_list = array();
				if ( $sections ) {
					if ( isset( $obj ) && is_object( $obj ) ) {
						foreach ( $sections as $section ) {
							array_push( $section_list, strtolower( $section->name ) );
						}
					}
				}
			}
		}
		return $section_list;
	}

	/**
	* Determine whether to include the Triplelift ad element.
	* @param $obj \CST\Objects\Article | \CST\Objects\Post
	*
	* @return bool
	*
	*/
	public function include_triple_lift( $obj ) {
		$article_section_slugs = wp_list_pluck( $obj->get_sections(), 'slug' );

		if ( $article_section_slugs ) {
			if ( array_intersect( CST_Frontend::$triple_lift_section_slugs, $article_section_slugs ) ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}

	/**
	 * Handle ad injection logic for section fronts and article pages and related infinite scrolling
	 *
	 * @param $paged page number within infinite scroll
	 */
	public function content_ad_injection( $paged ) {
		if ( is_singular( 'cst_feature' ) || is_post_type_archive( 'cst_feature' ) ) {
			return;
		}
		global $wp_query;
		$ad_template = '<div class="cst-ad-container">%s</div>';
		$inject_ad_markup = false;
		if ( is_singular() ) {
			$placement = 'div-gpt-placement-a';
			$mapping = 'article_lead_unit_mapping';
			$targeting = ( ! $paged ) ? 'atf leaderboard 2' : 'atf leaderboard 3';
			$inject_ad_markup = true;
		} else {
			if ( $wp_query->current_post > 1 ) {
				$placement = 'div-gpt-placement-s';
				$mapping = 'sf_inline_mapping';
				$sf_first_ad = ( 2 === $wp_query->current_post && 0 === $paged );
				if ( $sf_first_ad ) {
					$targeting = 'rr cube 2';
					$inject_ad_markup = true;
				} else {
					$every_two = $wp_query->current_post % 2;
					$sf_second_ad = ! $every_two;
					if ( $sf_second_ad ) {
						$targeting = 'rr cube 3';
						$inject_ad_markup = true;
					}
				}
			}
		}
		if ( $inject_ad_markup ) {
			$ad_unit_definition = CST()->dfp_handler->dynamic_unit(
				get_the_ID(),
				esc_attr( $placement ),
				esc_attr( 'dfp-placement' ),
				esc_attr( $mapping ),
				esc_attr( $targeting )
			);
			echo sprintf(
				wp_kses( $ad_template, array( 'div' => array( 'class' => array() ) ) ),
				wp_kses( $ad_unit_definition, CST()->dfp_kses )
			);
		}
		?>
<?php
	}

	/**
	 * @param $section_obj
	 *
	 * @return string
	 */
	public function determine_section_slug( $section_obj ) {
		if ( 'cst_section' === $section_obj->taxonomy ) {
			if ( 0 !== $section_obj->parent ) {
				$parent_terms = get_term( $section_obj->parent, 'cst_section' );
				if ( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections, true ) ) {
					$child_terms = get_term( $parent_terms->parent, 'cst_section' );
					$section_slug = $child_terms->slug;
				} else {
					$section_slug = $parent_terms->slug;
				}
			} else {
				$section_slug = $section_obj->slug;
			}
		} else {
			$section_slug = 'news';
		}
		return $section_slug;
	}
	/**
	* Include Distroscale and all article pages on Pre-Production
	*/
	public function action_distroscale_injection() {
		if ( is_singular( 'cst_feature' ) ) {
			return;
		}
		if ( is_front_page() ) {
			return;
		}
		$obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
		if ( ! $obj ) {
			return;
		}
		if ( 'cst_article' !== $obj->get_post_type() ) {
			return;
		}
		if ( $obj->get_sponsored_content() ) {
			return;
		}
		$site = CST()->dfp_handler->get_parent_dfp_inventory();
		$enqueue_me = false;
		if ( 'chicago.suntimes.com.test' === $site ) {
			if ( is_front_page() || is_tax() || is_singular() ) {
				$enqueue_me = true; ?>
<!-- ddistroscale -->
<div id="ds_default_anchor"></div>
<!-- /ddistroscale -->
			<?php }
		} elseif ( 'chicago.suntimes.com' === $site ) {
			if ( is_singular( 'cst_article' ) ) {
				$enqueue_me = true; ?>
<!-- distroscale -->
<div id="ds_default_anchor"></div>
<!-- /distroscale -->
			<?php }
		}
		if ( $enqueue_me ) {
			wp_enqueue_script( 'distroscale', '//c.jsrdn.com/s/cs.js?p=22519', array(), null, false );
		}
	}

	/**
	* Determine data dimension markup attributes for use with Google Analytics
	* @param $obj
	*
	* @return string
	*/
	public function article_dimensions( $obj ) {
		$attrs = '';
		$data = array(
			'post-id'   => $obj->get_id(),
			'post-uri'  => wp_parse_url( get_permalink( $obj->get_id() ), PHP_URL_PATH ),
			'wp-title'  => wp_title( '|', false, 'right' ),
			);

		for ( $i = 1;  $i <= 9;  $i++) {
			$data[ 'ga-dimension-' . $i ] = $obj->get_ga_dimension( $i );
		}

		foreach ( $data as $key => $val ) {
			$attrs .= ' data-cst-' . sanitize_key( $key ) . '="' . $val . '"';
		}
		return $attrs;
	}
	/**
	 * For third party vendor templates just display basic navigational links
	 * @return bool
	 */
	public function display_minimal_nav() {
		if ( is_singular() ) {
			$do_not_display = array(
				'page-arkadium.php' => true,
				'page-alt-arkadium.php' => true,
			);
			$path_portions = explode( '/', get_page_template() );
			$current = array_pop( $path_portions );
			if ( isset( $do_not_display[$current] ) ) {
				return true;
			}
		}
		return false;
	}
	/**
	* Hero story markup generation and display
	* Used by the customizer render callback
	*
	* @param int $headline
	*/
	public function homepage_hero_story( $headline ) {
		$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $headline ) );
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$author          = CST()->frontend->hp_get_article_authors( $obj );
			remove_filter( 'the_excerpt', 'wpautop' );
			$story_long_excerpt = apply_filters( 'the_excerpt', $obj->get_long_excerpt() );
			add_filter( 'the_excerpt', 'wpautop' );
		?>
		<div class="hero-story js-cst-homepage-headlines-one">
		<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
	<h3 class="hero-title"><?php echo esc_html( $obj->get_title() ); ?></h3>
</a>
	<div class="columns small-12 medium-6 large-12">
		<div class="row">
			<div class="hidden-for-large-up">
				<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
				<span class="image">
				<?php
				$featured_image_id = $obj->get_featured_image_id();
				if ( $featured_image_id ) {
					$attachment = wp_get_attachment_metadata( $featured_image_id );
					if ( $attachment ) {
						$image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'chiwire-header-small' );
						echo wp_kses_post( $image_markup );
					}
				}
				?>
				</span></a>
			</div>

	</div>
</div>
<div class="row">
<div class="columns small-12 medium-6 large-12 large-offset-0">
		<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-hero-story" >
			<p class="excerpt">
				<?php echo wp_kses_post( $story_long_excerpt ); ?>
			</p>
		</a>
		<?php $this->homepage_byline( $obj, $author ); ?>
</div>
</div>
</div>
		<?php
		}
	}

	/**
	* Display heading content / markup from $section_theme_mod as an anchor link to a section front url
	*
	* @param $section_theme_mod
	*/
	public function render_section_title( $section_theme_mod ) {
		$section_title_id = get_theme_mod( $section_theme_mod );
		// Check for no value and put a default - can't make get_theme_mod $default option work :-(
		if ( ! $section_title_id  ){
			$section_title = 'In other news';
			$section_term = wpcom_vip_get_term_by( 'slug', 'news', 'cst_section' );
		} else {
			$section_term = wpcom_vip_get_term_by( 'id', $section_title_id, 'cst_section' );
			$section_title = $section_term->name;
		}
		if ( $section_term ) {
		$link = wpcom_vip_get_term_link( $section_term->slug, 'cst_section' );
		if ( is_wp_error( $link ) ) {
			$link = '';
		}
?>
<div class="js-<?php echo esc_attr( str_replace( '_', '-', $section_theme_mod ) ); ?>">
	<h2 class="more-sub-head"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $section_title ); ?></a></h2>
</div>
<?php
		}

	}
	/**
	* @param $term_name
	* Display anchor link markup when provided with a Section name
	*/
	public function render_term_link( $term_name ) {
		if ( '' === trim( $term_name ) ) {
			echo '';
		} else {
			$section_term = wpcom_vip_get_term_by( 'name', $term_name, 'cst_section' );
			if ( $section_term ) {
				$link = wpcom_vip_get_term_link( $section_term->slug, 'cst_section' );
				if ( is_wp_error( $link ) ) {
					echo '';
				} else {
					echo '<a href="' . esc_url( $link ) . '">' . esc_html( $term_name ) . '</a>';
				}
			}
		}
	}
	/**
	* Display textual heading content / markup from $section_theme_mod
	*
	* @param $section_theme_mod
	*/
	public function render_section_text_title( $section_theme_mod ) {
		$section_title_text = get_theme_mod( $section_theme_mod );
?>
<div class="js-<?php echo esc_attr( str_replace( '_', '-', $section_theme_mod ) ); ?>">
	<h2 class="more-sub-head"><?php echo esc_html( $section_title_text ); ?></h2>
</div>
<?php
	}
	/**
	* Determine whether to display related stories,
	* if selected retrieve related stories and display in a list
	*/
	public function handle_related_content() {
		$do_related = get_theme_mod( 'hero_related_posts' );
		if ( $do_related ) { ?>
		<div class="related-stories">
			<h3>Related stories:</h3>
			<ul class="related-title">
				<?php $related_hero_stories = array_keys( CST()->customizer->get_column_one_related_stories() ); ?>
				<?php foreach ( $related_hero_stories as $story ) {
				$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $story ) );
				if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) { ?>
				<li class="js-<?php echo esc_attr( str_replace( '_', '-', $story ) ); ?>"><a href="<?php echo esc_url( $obj->get_permalink() ); ?>" data-on="click" data-event-category="content" data-event-action="navigate-hp-related-story"><h3><?php echo esc_html( $obj->get_title() ); ?></h3></a>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
		<?php }
	}

	/**
	* Inject a dfp div for a mobile adhesion ad unit
	*/
	public function render_hp_footer_ad_unit() {
		if ( function_exists( 'jetpack_is_mobile' )	 && jetpack_is_mobile() ) {
			if ( is_front_page() ) {
				$id_num = mt_rand( 0, 38290 );
				echo wp_kses( sprintf( CST()->dfp_handler->get_dynamic_adhesion_start(), $id_num )
				. CST()->dfp_handler->dynamic_unit( $id_num, '', 'dfp onebyone dfp-centered', '', 'cst-adhesion', '[320,50],[300,50]' )
				. CST()->dfp_handler->get_dynamic_adhesion_end(),
					CST()->dfp_kses
				);
			}
		}
	}
	/**
	* The lead stories - each generated by the following function - display below the hero story (see above)
	* Used by the customizer render callback
	*
	* @param $headline
	*/
	public function homepage_lead_story( $headline ) {
		$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $headline ) );
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$author          = CST()->frontend->hp_get_article_authors( $obj );
			remove_filter( 'the_excerpt', 'wpautop' );
			$story_excerpt = apply_filters( 'the_excerpt', $obj->get_excerpt() );
			$story_long_excerpt = apply_filters( 'the_excerpt', $obj->get_long_excerpt() );
			add_filter( 'the_excerpt', 'wpautop' );
			$featured_image_id = $obj->get_featured_image_id();
			if ( $featured_image_id ) {
				$attachment = wp_get_attachment_metadata( $featured_image_id );
				if ( $attachment ) {
					$large_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'chiwire-header-medium' );
					$small_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'chiwire-small-square' );
				}
			}
		?>
		<div class="lead-story js-<?php echo esc_attr( str_replace( '_', '-', $headline ) ); ?>">
<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-story" >
	<h3 class="title"><?php echo esc_html( $obj->get_title() ); ?></h3>
	<span class="image show-for-landscape hidden-for-medium-up show-for-xlarge-up">
				<?php if ( $featured_image_id && $attachment ) { echo wp_kses_post( $large_image_markup ); } ?>
			</span>
	<p class="excerpt">
			<span class="image show-for-medium-up">
				<?php if ( $featured_image_id && $attachment ) { echo wp_kses_post( $small_image_markup ); } ?>
			</span>
		<?php echo wp_kses_post( $story_long_excerpt ); ?>
	</p>
</a>
<?php $this->homepage_byline( $obj, $author ); ?>
		</div>
<?php
		}
	}

	/**
	* Provide Chicago Sport heading, markup and link to section for homepage
	*/
	public function sports_heading() {
		$sports_term = wpcom_vip_get_term_link( 'sports','cst_section' );
		if ( ! is_wp_error( $sports_term ) ) { ?>
			<h2 class="more-sub-head"><a href="<?php echo esc_url( $sports_term ); ?>">Chicago Sports</a></h2>
		<?php }
	}

	/**
	* Display the central story, with image and excerpt
	* Used by the customizer render callback
	* Updated to handle video embeds from STN or CST
	*
	* @param $headline
	*/
	public function homepage_mini_story_lead( $headline ) {
		$obj = \CST\Objects\Post::get_by_post_id( get_theme_mod( $headline ) );
		// Handle video embed here if the slotted content is a video post type
		if ( ! empty( $obj ) && ! is_wp_error( $obj ) ) {
			$author = $this->hp_get_article_authors( $obj );
			remove_filter( 'the_excerpt', 'wpautop' );
			$story_long_excerpt = apply_filters( 'the_excerpt', $obj->get_long_excerpt() );
			add_filter( 'the_excerpt', 'wpautop' );
			// Determine whether to use STN video embed, supported CST video embed or Featured image
			$featured_image_id = $obj->get_featured_image_id();
			$video_embed = '';
			if ( method_exists( $obj, 'featured_video_embed' ) ) {
				$video_embed = $obj->featured_video_embed();
				if ( ! empty( $video_embed ) ) {
					$featured_image_id = true;
					$attachment = true;
					$large_image_markup = $video_embed;
				}
			}
			if ( $featured_image_id && empty( $video_embed ) ) {
				$attachment = wp_get_attachment_metadata( $featured_image_id );
				if ( $attachment ) {
					$large_image_markup = get_image_tag( $featured_image_id, $attachment['image_meta']['caption'], '', 'left', 'secondary-wells' );
				}
			}
			$type = $obj->get_type();
			if ( 'video' === $type ) {
				$large_image_markup = $obj->get_video_embed();
				if ( ! empty( $large_image_markup ) ) {
					$featured_image_id = true;
					$attachment = true;
				}
			}
?>
<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 medium-6 large-6 prime">
			<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-mini-story" >
			<span class="image"><?php if ( $featured_image_id && $attachment ) {
				if ( 'video' === $type || ! empty( $video_embed ) ) {
					echo $large_image_markup;
				} else {
					echo wp_kses_post( $large_image_markup );
				}
			} ?></span>
			<div class="hide-for-landscape">
				<h3 class="alt-title"><?php echo esc_html( $obj->get_title() ); ?></h3>
			</div>
			</a>
		</div>
		<div class="columns small-12 medium-6 large-6 show-for-landscape">
			<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-mini-story" >
			<h3 class="alt-title"><?php echo esc_html( $obj->get_title() ); ?></h3>
			</a>
		</div>
		<div class="columns small-12 medium-6 large-6">
			<a href="<?php echo esc_url( $obj->get_permalink() ); ?>"  data-on="click" data-event-category="content" data-event-action="navigate-hp-lead-mini-story" >
			<p class="excerpt"><?php echo wp_kses_post( $story_long_excerpt ); ?></p>
			</a>
			<?php $this->homepage_byline( $obj, $author ); ?>
		</div>
	</div>
</div>
<?php
		}
	}
	/**
	* @param \CST\Objects\Post $obj
	* @param $author
	* @param $display_relative_timestamp
	*/
	public function homepage_byline( CST\Objects\Post $obj, $author, $display_relative_timestamp = true) { ?>
<p class="authors">By <?php echo wp_kses_post( $author );
echo $display_relative_timestamp ? ' - ' . esc_html( human_time_diff( $obj->get_localized_pub_mod_date_gmt() ) ) . ' ago' : '';
?></p>
	<?php }

	/**
	* Provide basic pagination and styling for Features archive pages
	*/
	public function features_pagination() {
		$features_nav = get_the_posts_pagination( array(
			'show_all' => true,
			'type' => 'list',
			'mid_size' => 2,
		) );
		$features_nav = str_replace( 'page-numbers', 'page-numbers pagination', $features_nav );
		$features_nav = str_replace( '><span class=\'page-numbers pagination current', ' class="current"><span class=\'page-numbers pagination current', $features_nav );
		echo wp_kses_post( $features_nav );
	}
}
