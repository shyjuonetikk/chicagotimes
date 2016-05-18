<?php

/**
 * Theme functionality for the frontend
 */
class CST_Frontend {

	private static $instance;

	private $nav_title_filter;

	public static $post_sections = array( 'news', 'sports', 'politics', 'entertainment', 'lifestyles', 'opinion', 'columnists', 'obituaries', 'sponsored' );

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

		/*
		 * Hack to address invalid URLs generated by wp.me
		 * Early priority to happen before canonical redirect
		 */
		add_action( 'template_redirect', function() {
			global $wpdb;

			/*
			 * Pattern like /2014/09/24/emanuel-criticizes-lewis-for-wanting-to-legalize-tax-marijuana/
			 * Turns into pagename=2014%2F09%2F24%2Femanuel-criticizes-lewis-for-wanting-to-legalize-tax-marijuana
			 * Because we ain't got no post rewrite rules
			 *
			 * See http://wordpressvip.zendesk.com/requests/33709
			 */
			if ( is_404() && get_query_var( 'pagename' ) ) {
				$pagename = get_query_var( 'pagename' );
				$parts = explode( '%2', $pagename );
				$post_name = array_pop( $parts );
				$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='cst_link' AND post_status='publish' AND post_name=%s", $post_name ) );
				if ( $post_id ) {
					// Will be an external link
					wp_redirect( get_permalink( $post_id ) );
					exit;
				}
			}

		}, 9 );

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

	}

	/**
	 * Modifications to the main query
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
		wp_enqueue_script( 'foundation', get_template_directory_uri() . '/assets/js/vendor/foundation.min.js', array( 'jquery' ), '5.2.3' );
		wp_enqueue_style( 'foundation', get_template_directory_uri() . '/assets/css/vendor/foundation.min.css', false, '5.2.3' );
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr.js', array( 'jquery' ), '5.2.3' );

		// Fonts
		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Raleway|Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800|Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' );
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/vendor/font-awesome.min.css' );
		wp_enqueue_style( 'cst-weathericons', get_template_directory_uri() . '/assets/css/vendor/weather/css/weather-icons.css' );

		$this->action_load_section_styling();

		// If we are on a 404 page don't try and load scripts/css that we won't be using.
		if( !is_404() ) {
			if ( ! is_front_page() || ! is_page() ) {
				// Scripty-scripts
				wp_enqueue_script( 'twitter-platform', '//platform.twitter.com/widgets.js' );
				wp_enqueue_script( 'add-this', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5419af2b250842c9' );

				// Slick
				wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/vendor/slick/slick.min.js', array( 'jquery' ), '1.3.6' );
				wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/js/vendor/slick/slick.css', false, '1.3.6' );
			}
			// The theme
			if( ! is_front_page() ) {
				wp_enqueue_script( 'chicagosuntimes', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery-effects-slide' ) );
			} elseif( is_front_page() ) {
				wp_enqueue_script( 'chicagosuntimes-homepage', get_template_directory_uri() . '/assets/js/theme-homepage.js' );
			} else {
				wp_enqueue_script( 'chicagosuntimes', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery-effects-slide' ) );
			}
		
			if( is_singular() && ! is_admin() ) {
				wp_enqueue_script( 'google-survey', get_template_directory_uri() . '/assets/js/vendor/google-survey.js' );
				wp_enqueue_script( 'yieldmo', get_template_directory_uri() . '/assets/js/vendor/yieldmo.js' );
			}

			wp_enqueue_script( 'chicagosuntimes-ndn', 'http://launch.newsinc.com/js/embed.js' );


			if ( ! is_front_page() || ! is_page() ) {
				wp_localize_script( 'chicagosuntimes', 'CSTData', array(
					'home_url'                           => esc_url_raw( home_url() ),
					'disqus_shortname'                   => CST_DISQUS_SHORTNAME,
				) );
				wp_enqueue_script( 'cst-gallery', get_template_directory_uri() . '/assets/js/gallery.js', array( 'slick' ) );
				wp_enqueue_script( 'cst-ads', get_template_directory_uri() . '/assets/js/ads.js', array( 'jquery' ) );
				wp_enqueue_script( 'cst-events', get_template_directory_uri() . '/assets/js/event-tracking.js', array( 'jquery' ) );
				wp_enqueue_script( 'cst-ga-custom-actions', get_template_directory_uri(). '/assets/js/analytics.js', array( 'jquery' ) );
				$analytics_data = array(
					'is_singular'     => is_singular(),
				);
				if ( is_singular() && $obj = \CST\Objects\Post::get_by_post_id( get_queried_object_id() ) ) {
					for ( $i = 1;  $i <= 9;  $i++) {
						$analytics_data['dimension' . $i] = $obj->get_ga_dimension( $i );
					}

					wp_enqueue_script( 'aggrego-chatter', get_template_directory_uri(). '/assets/js/vendor/aggrego-chatter.js', array(), false, true );
				}

				wp_localize_script( 'cst-ga-custom-actions', 'CSTAnalyticsData', $analytics_data );
			}
		} else {
			wp_enqueue_script( 'chicagosuntimes-404page', get_template_directory_uri() . '/assets/js/404.js' );
		}

		wp_localize_script( 'chicagosuntimes', 'CSTIE', array('cst_theme_url' => get_template_directory_uri() ) );

	}

	/**
	 * Load the correct style sheet based on the section or ref
	 */
	public function action_load_section_styling() {

		if ( is_author() ) {
			wp_enqueue_style( 'chicagosuntimes', get_template_directory_uri() . '/assets/css/theme.css', array( 'google-fonts', 'fontawesome' ) );
		} elseif ( is_tax() ) {
			$section_obj = get_queried_object();
			if( $section_obj->taxonomy == 'cst_section' ) {
				if( $section_obj->parent != 0 ) {
					$parent_terms = get_term( $section_obj->parent, 'cst_section' );
					if( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
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
	 * Add meta tags to the head of our site
	 */
	public function action_wp_head_meta_tags() {

		if ( is_singular() ) {
			$post = \CST\Objects\Post::get_by_post_id( get_queried_object_id() );
			$meta_description = $post->get_seo_description();
		} elseif ( is_tax() && $description = get_queried_object()->description ) {
			$meta_description = $description;
		} 
		else {
			$meta_description = get_bloginfo( 'description' );
		}

		$facebook_tags = $this->get_facebook_open_graph_meta_tags();
		$twitter_tags = $this->get_twitter_card_meta_tags();

		$tags = array_merge( array( 'description' => $meta_description ), $facebook_tags, $twitter_tags );
		foreach( $tags as $name => $value ) {
			echo '<meta property="' . esc_attr( $name ) . '" content="' . esc_attr( $value ) . '" />' . PHP_EOL;
		}

		echo '<meta name="description" content="' . esc_attr( $meta_description ) . '" />' . PHP_EOL;

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
		foreach( $authors as $author ) {
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
	 */
	public function filter_nav_menu_link_attributes( $atts, $item, $args ) {

		if ( empty( $args->theme_location ) ) {
			return $atts;
		}

		switch( $args->theme_location ) {

			case 'trending-menu':

				$fontawesome_icon = false;

				if ( 'taxonomy' == $item->type && 'cst_person' == $item->object ) {
					$fontawesome_icon = 'fa fa-male';
				}

				if ( 'taxonomy' == $item->type && 'cst_location' == $item->object ) {
					$fontawesome_icon = 'fa fa-location-arrow';
				}

				if ( 'taxonomy' == $item->type && 'cst_topic' == $item->object ) {
					$fontawesome_icon = 'fa fa-cst-topic';
				}

				if ( 'taxonomy' == $item->type && 'cst_section' == $item->object ) {
					$fontawesome_icon = 'fa fa-folder';
				}

				if ( 'post_type' == $item->type && 'cst_liveblog' == $item->object ) {
					$fontawesome_icon = 'fa fa-comment';
				}

				if ( 'custom' == $item->type ) {
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

		// Defaults
		$tags = array(
			'og:site_name'        => get_bloginfo( 'name' ),
			'og:type'             => 'website',
			'og:title'            => get_bloginfo( 'name' ),
			'og:description'      => get_bloginfo( 'description' ),
			'og:url'              => esc_url( home_url( $_SERVER['REQUEST_URI'] ) ),
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

		// Defaults
		$tags = array(
			'twitter:card'        => 'summary_large_image',
			'twitter:site'        => '@' . CST_TWITTER_USERNAME,
			'twitter:title'       => get_bloginfo( 'name' ),
			'twitter:description' => get_bloginfo( 'description' ),
			'twitter:url'         => esc_url( home_url( $_SERVER['REQUEST_URI'] ) ),
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
				)
			);
			unset( $query_args['cst_section'] );
		}


		$post_query = new \WP_Query( $query_args );
		$fetched_posts = array_merge( $fetched_posts, wp_list_pluck( $post_query->posts, 'ID' ) );
		return array_merge( $collection, $post_query->posts );
	}

	public function get_weather() {
		$response = wpcom_vip_file_get_contents( 'http://apidev.accuweather.com/currentconditions/v1/348308.json?language=en&apikey=' . CST_ACCUWEATHER_API_KEY );
		$data = json_decode( $response );
		if ( ! $data ) {
			return false;
		} 
		return $data;

	}

	public function get_weather_icon($number) {
		$icon = '';
		switch( $number ) {

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

	public function get_taxonomy_image($taxonomy) {

		$taxonomy = sanitize_key( $taxonomy );
		if( file_exists( get_template_directory() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.jpg' ) ) {
		    return get_template_directory_uri() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.jpg';
		}
		elseif ( file_exists( get_template_directory() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.svg' ) ) {
			return get_template_directory_uri() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.svg';
		}
		elseif ( file_exists( get_template_directory() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.png' ) ) {
			return get_template_directory_uri() . '/assets/images/taxonomy/taxonomy-' . $taxonomy . '.png';
		}
		 else {
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

		$count = 0;
		$total_severity = 0;
		foreach( $data as $traffic ) {

			$total = count($traffic->incidents);
			for( $i=0; $i <= ( $total - 1); $i++ ) {
				$total_severity += $traffic->incidents[$i]->severity;
			}

		}
		$_traffic['accidents'] = $total;
		if( $total_severity <= $total ) {
			$_traffic['icon'] = 'green';
			$_traffic['word'] = 'Light';
		} elseif( $total_severity >= ($total * 2) ) {
			$_traffic['icon'] = 'orange';
			$_traffic['word'] = 'Mild';
		} elseif( $total_severity >= ($total * 3) ) {
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
		foreach( $data as $traffic ) {
			foreach( $traffic->incidents as $incident ) {
				array_push( $all_incidents, $incident );
			}
		}

		return $all_incidents;

	}

	public function cst_homepage_fetch_feed($feed_url, $max_display) {

		$cache_key = md5( $feed_url . (int) $max_display );
		$cached_feed = wp_cache_get( $cache_key, 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
		if ( $cached_feed === false ) {
			$headlines = fetch_feed( $feed_url );
			if ( ! is_wp_error( $headlines ) ) :
				$maxitems = $headlines->get_item_quantity( $max_display );
				$items    = $headlines->get_items( 0, $maxitems );
				wp_cache_set( $cache_key, $items, 'default', 15 * MINUTE_IN_SECONDS );
				$test = strlen(serialize($items));
				return $items;
			else :
				return; //todo: VIP note: cache when the feed is not found.
			endif;
		}else{
			return $cached_feed;
		}
	}


	/**
	 * Fetch the JSON feed of aggregated posts being used on another CST Network site
	 * @param int $count
	 * @return json array
	 */
	public function cst_get_chatter_site($json_feed) {

		$response = wpcom_vip_file_get_contents( $json_feed . '?count=1' );
		if ( is_wp_error( $response ) ) :
			return;
		else :
			$posts = json_decode( $response );
			if ( ! $posts ) {
				return;
			}
			return $posts;
		endif;

	}

	/**
	 * Fetch and output content from the specified section
	 * @param $content_query
	 */
	public function cst_homepage_content_block( $content_query, $nativo_slug = NULL ) {

		$cache_key = md5( serialize($content_query) );
		$cached_content = wp_cache_get( $cache_key );
		if ($cached_content === false ){
			$items = new \WP_Query( $content_query );
			ob_start();
			if ( $items->have_posts() ) {
				$count = $content_query['posts_per_page'];
				while( $items->have_posts() ) {
					$items->the_post();
					$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
					if ( $count == $content_query['posts_per_page'] ) {
						if ( 'image' == $obj->get_featured_media_type() ) {
							$featured_image_id = $obj->get_featured_image_id();
							if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id ) ) { ?>
								<a href="<?php echo esc_url( $obj->the_permalink() ); ?>" title="<?php echo esc_html( $obj->the_title() ); ?>">
								<?php echo $attachment->get_html( 'homepage-columns' ); ?>
								</a>
								<?php
							}
						}
						?>
			<?php if( $nativo_slug != NULL ) { ?>
				<ul id="<?php echo esc_html( $nativo_slug ); ?>">
			<?php } else { ?>
				<ul>
			<?php } ?>
					<?php }
					$count--;
					?>
					<li>
						<a href="<?php echo esc_url( $obj->the_permalink() ); ?>" title="<?php echo esc_html( $obj->the_title() ); ?>">
							<?php echo esc_html( $obj->get_title() ); ?>
						</a>
					</li>
				<?php } ?>
				</ul>
				<?php
			}
			$cached_content = ob_get_clean();
			wp_cache_set( $cache_key, $cached_content, 'default', 5 * MINUTE_IN_SECONDS );
		}
		echo $cached_content;
	}

	/**
	 * Fetch and output content from the specified section
	 * @param $content_query
	 */
	public function cst_dear_abby_recommendation_block( $content_query ) {

		$cache_key = md5( serialize($content_query) );
		$cached_content = wp_cache_get( $cache_key );
		if ($cached_content === false ){
			$items = new \WP_Query( $content_query );
			ob_start();
			if ( $items->have_posts() ) { ?>
			<div class="large-10 medium-offset-1 post-recommendations">
				<h3>Previously from Dear Abby</h3>
			<?php
				while( $items->have_posts() ) {
					$items->the_post();
					$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
				?>
					<div class="columns large-3 medium-6 small-12 recommended-post">
						<a href="<?php echo esc_url( $obj->the_permalink() ); ?>" title="<?php echo esc_html( $obj->the_title() ); ?>">
							<?php echo esc_html( $obj->get_title() ); ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php
			}
			$cached_content = ob_get_clean();
			wp_cache_set( $cache_key, $cached_content, 'default', 5 * MINUTE_IN_SECONDS );
		}
		echo $cached_content;
	}

	/**
	 * Fetch and output content from the specified section
	 * @param $content_query
	 */
	public function cst_post_recommendation_block( $feed_url, $section_name ) {

		$cache_key = md5( $feed_url );
            $result = wp_cache_get( $cache_key, 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
            if ( $result === false ) {
                $response = wpcom_vip_file_get_contents( $feed_url );
                if ( ! is_wp_error( $response ) ) {
                    $result = json_decode( $response );
                    wp_cache_set( $cache_key, $result, 'default', 5 * MINUTE_IN_SECONDS );
                }
            }
            ?>
            <div class="large-10 medium-offset-1 post-recommendations">
				<h3>Previously from <?php esc_html_e( $section_name ); ?></h3>
            <?php foreach( $result->pages as $item ) { ?>
            	<div class="columns large-3 medium-6 small-12 recommended-post">
					<a href="<?php echo esc_url( $item->path ); ?>" title="<?php echo esc_html( $item->title ); ?>">
						<?php echo esc_html( $item->title ); ?>
					</a>
				</div>
            <?php }

	}

	public function cst_nativo_determine_positions($slug) {

        $positions = array();
        switch( $slug ) {

            case 'news':
                $positions = array( 'News1', 'News2' );
                break;
            case 'chicago':
                $positions = array('NewsChi1', 'NewsChi2' );
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
	 * @return string
	 * 
	 * Determine and return the slug for use in headlines slider, sidebar and other template files.
	 */
	public function slug_detection() {
		if ( is_author() ) {
			$primary_slug = 'news';
		} elseif( is_single() ) {
			$obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
			$primary_section = $obj->get_primary_parent_section();
			$primary_slug = $primary_section->slug;
			if( ! in_array( $primary_slug, CST_Frontend::$post_sections ) ) {
				$parent_terms = get_term( $primary_section->parent, 'cst_section' );
				if( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
					$child_terms = get_term( $parent_terms->parent, 'cst_section' );
					$primary_slug = $child_terms->slug;
				} else {
					$primary_slug = $parent_terms->slug;
				}
			}
		} else {
			$primary_section = get_queried_object();
			if( isset( $primary_section ) && $primary_section->taxonomy == 'cst_section') {
				if( $primary_section->parent != 0 ) {
					$primary_slug = $primary_section->slug;
					if( ! in_array( $primary_slug, CST_Frontend::$post_sections ) ) {
						$current_section = get_term( $primary_section->parent, 'cst_section' );
						if( ! in_array( $current_section->slug, CST_Frontend::$post_sections ) ) {
							$current_section = get_term( $current_section->parent, 'cst_section' );
							if( ! in_array( $current_section->slug, CST_Frontend::$post_sections ) ) {
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
			}  else {
				$primary_slug = 'news';
			}
		}
		
		return $primary_slug;
	}

}
