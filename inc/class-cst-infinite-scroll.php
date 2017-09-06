<?php

class CST_Infinite_Scroll {

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Infinite_Scroll;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
		}
		return self::$instance;

	}

	/**
	 * Set up Infinite Scroll actions
	 */
	private function setup_actions() {

		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );

		add_action( 'template_redirect', array( $this, 'bypass_is_last_batch_in_footer' ), 9, 0 );

		add_action( 'template_redirect', array( $this, 'remove_bypass_is_last_batch_in_footer' ), 11, 0 );
	}

	/**
	 * Set up Infinite Scroll filters
	 */
	private function setup_filters() {


		add_filter( 'infinite_scroll_archive_supported', function( $val ){
			if ( is_singular() ) {
				return true;
			} else {
				return $val;
			}
		});

		add_filter( 'infinite_scroll_settings', function( $settings ) {
			if ( is_singular() ) {
				$settings['posts_per_page'] = 1;
			}
			return $settings;
		});

		add_filter( 'infinite_scroll_js_settings', function( $settings ) {
			$settings['google_analytics'] = false;
			$settings['offset'] = 251;
			return $settings;
		});

		add_filter( 'infinite_scroll_query_args', function( $query_args ) {
			global $wpdb;

			// Figure out the next post in relation to this post
			$section_based_post_types = CST()->get_post_types();
			$unset_feature = array_keys( $section_based_post_types, 'cst_feature' );
			unset( $section_based_post_types[ $unset_feature[0] ] );
			$post_types = $section_based_post_types;
			if ( ! empty( $query_args['post_type'] ) && ! empty( $query_args['name'] ) && ( in_array( $query_args['post_type'], $post_types ) || ( is_array( $query_args['post_type'] ) && $query_args['post_type'] == $post_types ) ) ) {

				$key = array_search( 'cst_link', $post_types );
				unset( $post_types[ $key ] );

				if ( is_string( $query_args['post_type'] ) && isset( $query_args[ $query_args['post_type'] ] ) ) {
					unset( $query_args[ $query_args['post_type'] ] );
				}

				unset( $query_args['year'] );
				unset( $query_args['monthnum'] );
				unset( $query_args['day'] );

				$temp_query_args = array(
					'offset'                 => (int) $_POST['page'] - 1,
					'post_type'              => $post_types,
					'posts_per_page'         => 1,
					'post_status'            => 'publish',
					'orderby'                => 'date',
					'order'                  => 'DESC',
					'date_query'             => array(
						'before'             => sanitize_text_field( $_POST['last_post_date'] ),
						),
					'no_found_rows'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
					'ignore_sticky_posts'    => true,
					'tax_query'              => array(
						array(
							'taxonomy'  => 'cst_section',
							'field'     => 'slug',
							'terms'     => $query_args['cst_section'],
							'include_children' => false,
							),
						),
					);
				$temp_query = new WP_Query( $temp_query_args );

				// No post means the end of the query
				if ( ! $temp_query->posts ) {
					return $query_args;
				}

				$post = array_pop( $temp_query->posts );

				$query_args['post_type'] = $post->post_type;
				$query_args['name'] = $post->post_name;
				$query_args[ $post->post_type ] = $post->post_name;
				$query_args['posts_per_page'] = 1;

				// Make sure Liveblog has access to the global post when setting the entries query
				add_action( 'wp_head', function(){
					global $post, $wp_query;
					$post = $wp_query->post;
				}, -1 );

				add_filter( 'infinite_scroll_results', function( $results, $query_args, $wp_query ) {
					$results['lastbatch'] = false;
					return $results;
				}, 10, 3 );

				return $query_args;

			} else {

				return $query_args;
			}
		}, 11 );

	}

	/**
	 * Infinite scroll JavaScript hacks.
	 */
	public function action_wp_enqueue_scripts() {
		if ( is_page_template( 'page-monster.php' ) || is_front_page() || is_post_type_archive( 'cst_feature' ) || is_singular( 'cst_feature' ) ) {
			return;
		}
		wp_enqueue_script( 'cst-infinite-scroll', get_template_directory_uri() . '/assets/js/infinite-scroll.js', array( 'chicagosuntimes', 'the-neverending-homepage', 'cst-ga-custom-actions' ), false, true );
		wp_localize_script( 'cst-infinite-scroll', 'CSTInfiniteScrollData', array(
			'readMoreLabel'           => esc_html__( 'Read More', 'chicagosuntimes' ),
		) );
		$post_sections = array_map( 'strtolower', CST_Frontend::$post_sections );
		$post_sections = array_map( 'esc_attr', $post_sections );
		wp_localize_script( 'cst-infinite-scroll', 'CSTYieldMoData', array(
			'SECTIONS_FOR_YIELD_MO' => $post_sections,
		) );
	}

	/**
	 * VIP: add filter which helps us bypassing JP's is_last_batch check
	 */
	public function bypass_is_last_batch_in_footer() {
		add_filter( 'infinite_scroll_query_object', array( $this, 'set_high_found_posts' ), 99, 1 );
	}

	/**
	 * VIP: remove filter which helps us bypassing JP's is_last_batch check
	 */
	public function remove_bypass_is_last_batch_in_footer() {
		remove_filter( 'infinite_scroll_query_object', array( $this, 'set_high_found_posts' ), 99 );
	}

	/**
	 * VIP: set the found_posts to unreasonably high number in order to pass the is_last_batch check
	 */
	public function set_high_found_posts( $wp_query ) {
		$wp_query->found_posts = 999;
		return $wp_query;
	}

}
