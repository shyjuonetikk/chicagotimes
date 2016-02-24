<?php

// Initialize VIP
require_once WP_CONTENT_DIR . '/themes/vip/plugins/vip-init.php';

/**
 * Encapsulates core theme functionality
 */
class CST {

	private static $instance;

	private $post_types = array();

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST;
			self::$instance->setup_theme();
		}
		return self::$instance;
	}

	/**
	 * Set up theme components
	 */
	private function setup_theme() {

		$this->define_constants();
		$this->require_files();

		if ( is_admin() ) {
			$this->admin = CST_Admin::get_instance();
		} else {
			$this->frontend = CST_Frontend::get_instance();
		}

		$this->customizer = CST_Customizer::get_instance();
		$this->liveblog = CST_Liveblog::get_instance();
		$this->infinite_scroll = CST_Infinite_Scroll::get_instance();
		// Disabled 8/26 by DB
		// $this->merlin = CST_Merlin::get_instance();
		$this->shortcodes = CST_Shortcode_Manager::get_instance();
		$this->wire_curator = CST_Wire_Curator::get_instance();

		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'footer'    => false,
		) );

		wpcom_vip_disable_sharing();
		wpcom_vip_disable_post_flair();
		wpcom_vip_disable_likes();

		// Disable Media Explorer
		if ( class_exists( 'Media_Explorer' ) ) {
			$instance = Media_Explorer::init();
			remove_action( 'init',                  array( $instance, 'action_init' ) );
			remove_action( 'wp_enqueue_media',      array( $instance, 'action_enqueue_media' ) );
			remove_action( 'print_media_templates', array( $instance, 'action_print_media_templates' ) );
			remove_action( 'wp_ajax_mexp_request',   array( $instance, 'ajax_request' ) );
		}

		add_image_size( 'chiwire-article', 570, 260, true );
		add_image_size( 'chiwire-small-square', 80, 80, true );
		add_image_size( 'chiwire-featured-content-widget', 295, 165, true );
		add_image_size( 'chiwire-header-large', 640, 480, true );
		add_image_size( 'chiwire-header-medium', 425, 320, true );
		add_image_size( 'chiwire-header-small', 320, 240, true );
		add_image_size( 'cst-article-featured', 670, 9999, false );
		add_image_size( 'cst-gallery-desktop-vertical', 1200, 1600, true );
		add_image_size( 'cst-gallery-desktop-horizontal', 1600, 1200, true );
		add_image_size( 'cst-gallery-mobile-vertical', 600, 800, true );
		add_image_size( 'cst-gallery-mobile-horizontal', 800, 600, true );
		add_image_size( 'twitter-card', 120, 120, true );
		add_image_size( 'facebook-open-graph', 1200, 630, true );
		add_image_size( 'secondary-wells', 290, 190, true );
		add_image_size( 'homepage-columns', 228, 134, true );
		add_image_size( 'newspaper', 297, 287, true );

		$this->setup_actions();
		$this->setup_filters();
		$this->register_sidebars();

	}

	/**
	 * Define constants used by the theme
	 */
	private function define_constants() {

		define( 'CST_TWITTER_USERNAME', 'suntimes' );
		define( 'CST_TWITTER_CONSUMER_KEY', 'i2nLp5eOTlqpwOQ6pkbge7lzR' );
		define( 'CST_TWITTER_CONSUMER_SECRET', 'kRvlRnW31SgCEZWbsPfNIdRwbqip7z8fQp2aeBbWcBIQ0y5RM7' );

		$twitter_share_text_max_length = 140 - strlen( ' via @' . CST_TWITTER_USERNAME );
		define( 'CST_TWITTER_SHARE_TEXT_MAX_LENGTH', $twitter_share_text_max_length );

		define( 'CST_AP_SYNDICATION_USERNAME', 'cnewman@suntimes.com' );
		define( 'CST_AP_SYNDICATION_PASSWORD', 'TheBright1' );

		define( 'CST_MERLIN_API_URL', 'http://cst.merlinone.net/' );
		define( 'CST_MERLIN_API_KEY', 'XX9A23C8754C37FD187E006A1EE6' );

		define( 'CST_BITLY_API_LOGIN', 'suntimes' );
		define( 'CST_BITLY_API_KEY', 'R_d0c36ce8933246bfbc91f1821a5133b2' );

		define( 'CST_DISQUS_SHORTNAME', 'cstbreakingnews' );

		define( 'CST_ACCUWEATHER_API_KEY', 'e2b0821d28e14186b744121b5a367815' );

		define( 'CST_MAPQUEST_API_KEY', 'Fmjtd%7Cluurnu6bn1%2C8g%3Do5-9wbgdy' );

		define( 'CST_DEFAULT_SECTION', 'news' );

		define( 'VIP_MAINTENANCE_MODE', false );

	}

	/**
	 * Require files we need to load
	 */
	private function require_files() {

		// Theme parts
		require_once dirname( __FILE__ ) . '/inc/class-cst-admin.php';
		require_once dirname( __FILE__ ) . '/inc/class-cst-frontend.php';
		require_once dirname( __FILE__ ) . '/inc/class-cst-customizer.php';
		require_once dirname( __FILE__ ) . '/inc/class-cst-infinite-scroll.php';
		require_once dirname( __FILE__ ) . '/inc/class-cst-liveblog.php';
		// Disabled 8/26 by DB
		// require_once dirname( __FILE__ ) . '/inc/class-cst-merlin.php';
		require_once dirname( __FILE__ ) . '/inc/class-cst-shortcode-manager.php';
		require_once dirname( __FILE__ ) . '/inc/class-cst-wire-curator.php';

		// Objects
		require_once dirname( __FILE__ ) . '/inc/objects/class-post.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-page.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-author.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-guest-author.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-user.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-article.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-link.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-liveblog.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-gallery.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-embed.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-ap-wire-item.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-video.php';
		require_once dirname( __FILE__ ) . '/inc/objects/class-attachment.php';

		// Widgets
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-ad-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-recent-posts-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-twitter-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-featured-content-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-homepage-headlines-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-homepage-secondary-headlines-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-homepage-more-headlines-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-weather-word-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-columnists-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-newspaper-cover-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-breaking-news-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-ndn-video-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-stng-wire-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-social-follow-us-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-category-headlines-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-chatter-site-widget.php';
		require_once dirname( __FILE__ ) . '/inc/widgets/class-cst-homepage-featured-story-widget.php';

		wpcom_vip_require_lib( 'codebird' );

		wpcom_vip_load_plugin( 'co-authors-plus' );
		wpcom_vip_load_plugin( 'fieldmanager' );
		wpcom_vip_load_plugin( 'pushup' );
		wpcom_vip_load_plugin( 'wpcom-thumbnail-editor' );
		wpcom_vip_load_plugin( 'zoninator' );
		wpcom_vip_load_plugin( 'maintenance-mode' );

		// Options are loaded on Bitly::__construct
		add_filter( 'pre_option_bitly_settings', function() {
			return array(
				'api_login'        => CST_BITLY_API_LOGIN,
				'api_key'          => CST_BITLY_API_KEY,
				);
		});
		wpcom_vip_load_plugin( 'bitly' );

	}

	/**
	 * Set up any actions for the theme
	 */
	private function setup_actions() {

		add_action( 'init', array( $this, 'action_init_early' ), 2 );
		add_action( 'widgets_init', array( $this, 'action_widgets_init' ), 11 );

		// Sections are included in permalinks, so we need to make sure they're in rewrite rules
		add_action( 'created_cst_section', 'wpcom_initiate_flush_rewrite_rules' );
		add_action( 'edited_cst_section', 'wpcom_initiate_flush_rewrite_rules' );
		add_action( 'delete_cst_section', 'wpcom_initiate_flush_rewrite_rules' );

		add_action( 'wp_footer', array( $this, 'action_wp_footer_gallery_backdrop' ) );

		/*
		 * Remove "New Post" from admin bar because we don't have posts,
		 * Add "Edit Tag" to frontend because it's missing on WordPress.com
		 */
		add_action( 'admin_bar_menu', function( $wp_admin_bar ) {
			$wp_admin_bar->remove_menu('ab-new-post');

			if ( ! is_admin() && is_tax() && current_user_can( 'edit_others_posts' ) && ! $wp_admin_bar->get_node( 'edit' ) ) {

				$term = get_queried_object();
				$wp_admin_bar->add_menu( array(
					'id'        => 'edit',
					'title'     => sprintf( esc_html__( 'Edit %s', 'chicagosuntimes' ), get_taxonomy( $term->taxonomy )->labels->singular_name ),
					'href'      => get_edit_term_link( $term->term_id, $term->taxonomy, 'post' ),
					) );
			}

		}, 999 );

	}

	/**
	 * Set up any filters for the theme
	 */
	private function setup_filters() {

		add_filter( 'post_type_link', array( $this, 'filter_post_type_link' ), 10, 2 );
		add_filter( 'post_rewrite_rules', array( $this, 'filter_post_rewrite_rules' ) );

		add_filter( 'default_option_taxonomy_image_plugin_settings', array( $this, 'filter_taxonomy_image_plugin_settings' ) );
		add_filter( 'option_taxonomy_image_plugin_settings', array( $this, 'filter_taxonomy_image_plugin_settings' ) );

		$right_blog_id = get_current_blog_id();
		add_filter( 'pre_option_timezone_string', function( $value ) use ( $right_blog_id ) {
			if ( $right_blog_id == get_current_blog_id() ) {
				return 'America/Chicago';
			} else {
				return $value;
			}
		});

		add_filter( 'pre_option_image_default_link_type', function( $value ) use ( $right_blog_id ) {
			if ( $right_blog_id == get_current_blog_id() ) {
				return 'none';
			} else {
				return $value;
			}
		});
		add_filter( 'pre_option_image_default_size', function( $value ) use ( $right_blog_id ) {
			if ( $right_blog_id == get_current_blog_id() ) {
				return 'medium';
			} else {
				return $value;
			}
		});
		add_filter( 'pre_option_medium_size_w', function( $value ) use ( $right_blog_id ) {
			if ( $right_blog_id == get_current_blog_id() ) {
				return 570;
			} else {
				return $value;
			}
		});
		add_filter( 'pre_option_medium_size_w', function( $value ) use ( $right_blog_id ) {
			if ( $right_blog_id == get_current_blog_id() ) {
				return 570;
			} else {
				return $value;
			}
		});

		add_filter( 'post_gallery', array( $this, 'filter_post_gallery' ), 10, 2 );

		add_filter( 'wp_unique_post_slug', array( $this, 'filter_wp_unique_post_slug' ), 10, 6 );

		// All of the filters!
		add_filter( 'pre_option_link_manager_enabled', '__return_zero', 100 );
		add_filter( 'default_option_link_manager_enabled', '__return_zero', 100 );
		add_filter( 'option_link_manager_enabled', '__return_zero', 100 );

		add_filter( 'coauthors_guest_authors_enabled', '__return_true' );
		add_filter( 'coauthors_plus_should_query_post_author', '__return_false' );
		add_filter( 'coauthors_guest_author_avatar_sizes', '__return_empty_array' );

		add_filter( 'wpcom_sitemap_post_types', array( $this, 'filter_sitemap_post_types' ) );
		add_filter( 'wpcom_sitemap_news_sitemap_post_types', array( $this, 'filter_sitemap_post_types' ) );

		/**
		 * Remove avatar references from RSS feed
		 */
		add_filter( 'mrss_avatar_user', '__return_false' );

		/**
		 * Add aditional classes to body for sections
		 */
		add_filter( 'body_class', function( $classes ) {
			if ( isset( get_queried_object()->slug ) ) {
				$classes[] = get_queried_object()->slug;
			}
			return $classes;
		});

	}

	/**
	 * Register the sidebars for the theme
	 */
	private function register_sidebars() {

		register_sidebar( array(
			'id'          => 'newswire',
			'name'        => esc_html__( 'NewsWire', 'chicagosuntimes' ),
		) );
		register_sidebar( array(
			'id'          => 'sportswire',
			'name'        => esc_html__( 'SportsWire', 'chicagosuntimes' ),
		) );
		register_sidebar( array(
			'id'          => 'entertainmentwire',
			'name'        => esc_html__( 'EntertainmentWire', 'chicagosuntimes' ),
		) );
		register_sidebar( array(
			'id'          => 'politicswire',
			'name'        => esc_html__( 'PoliticsWire', 'chicagosuntimes' ),
		) );
		register_sidebar( array(
			'id'          => 'lifestyleswire',
			'name'        => esc_html__( 'LifestylesWire', 'chicagosuntimes' ),
		) );
		register_sidebar( array(
			'id'          => 'opinionwire',
			'name'        => esc_html__( 'OpinionWire', 'chicagosuntimes' ),
		) );
		register_sidebar( array(
			'id'          => 'columnistswire',
			'name'        => esc_html__( 'ColumnistsWire', 'chicagosuntimes' ),
		) );
		register_sidebar( array(
			'id'          => 'obitswire',
			'name'        => esc_html__( 'ObitsWire', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'homepage_breaking_news',
			'name'        => esc_html__( 'Homepage Breaking News', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'homepage_headlines',
			'name'        => esc_html__( 'Homepage Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'homepage_featured_story',
			'name'        => esc_html__( 'Homepage Featured Story', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'homepage_weather_word',
			'name'        => esc_html__( 'Homepage Weather Word', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'homepage_sidebar',
			'name'        => esc_html__( 'Top Homepage Sidebar', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'homepage_sidebar_two',
			'name'        => esc_html__( 'Middle Homepage Sidebar', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'homepage_sidebar_three',
			'name'        => esc_html__( 'Bottom Homepage Sidebar', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'news_headlines',
			'name'        => esc_html__( 'News Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'sports_headlines',
			'name'        => esc_html__( 'Sports Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'entertainment_headlines',
			'name'        => esc_html__( 'Entertainment Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'politics_headlines',
			'name'        => esc_html__( 'Politics Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'lifestyles_headlines',
			'name'        => esc_html__( 'Lifestyles Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'columnists_headlines',
			'name'        => esc_html__( 'Columnists Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'opinion_headlines',
			'name'        => esc_html__( 'Opinion Headlines', 'chicagosuntimes' ),
		) );

		register_sidebar( array(
			'id'          => 'obits_headlines',
			'name'        => esc_html__( 'Obits Headlines', 'chicagosuntimes' ),
		) );

	}

	/**
	 * Manipulate available widgets
	 */
	public function action_widgets_init() {

		// Register our custom widgets
		register_widget( 'CST_Ad_Widget' );
		register_widget( 'CST_Recent_Posts' );
		register_widget( 'CST_Twitter_Feed_Widget' );
		register_widget( 'CST_Featured_Content_Widget' );
		register_widget( 'CST_Homepage_Headlines_Widget' );
		register_widget( 'CST_Homepage_Secondary_Headlines_Widget' );
		register_widget( 'CST_Homepage_More_Headlines_Widget' );
		register_widget( 'CST_Weather_Word_Widget' );
		register_widget( 'CST_Columnists_Content_Widget' );
		register_widget( 'CST_Newspaper_Cover_Widget' );
		register_widget( 'CST_Breaking_News_Widget' );
		register_widget( 'CST_NDN_Video_Widget' );
		register_widget( 'CST_STNG_Wire_Widget' );
		register_widget( 'CST_Social_Follow_Us_Widget' );
		register_widget( 'CST_Category_Headlines_Widget' );
		register_widget( 'CST_Chatter_Site_Widget' );
		register_widget( 'CST_Homepage_Featured_Story_Widget' );

		// Unregister common Widgets we [probably] won't be using
		unregister_widget( 'WP_Widget_Pages' );
		unregister_widget( 'WP_Widget_Archives' );
		unregister_widget( 'WP_Widget_Links' );
		unregister_widget( 'WP_Widget_Meta' );
		unregister_widget( 'WP_Widget_Text' );
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
		unregister_widget( 'WP_Widget_RSS' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
		unregister_widget( 'WP_Widget_Search' );

	}

	/**
	 * Actions to perform on init
	 */
	public function action_init_early() {

		$this->register_post_types();
		$this->register_taxonomies();

		register_nav_menus(
			array(
				'homepage-menu'     	=> esc_html__( 'Homepage', 'chicagosuntimes' ),
				'homepage-footer-menu'  => esc_html__( 'Homepage Footer', 'chicagosuntimes' ),
				'news-menu'         	=> esc_html__( 'News', 'chicagosuntimes' ),
				'news-trending'     	=> esc_html__( 'News Trending', 'chicagosuntimes' ),
				'sports-menu'       	=> esc_html__( 'Sports', 'chicagosuntimes' ),
				'sports-trending'   	=> esc_html__( 'Sports Trending', 'chicagosuntimes' ),
				'politics-menu'     	=> esc_html__( 'Politics', 'chicagosuntimes' ),
				'politics-trending' 	=> esc_html__( 'Politics Trending', 'chicagosuntimes' ),
				'entertainment-menu'    => esc_html__( 'Entertainment', 'chicagosuntimes' ),
				'entertainment-trending'=> esc_html__( 'Entertainment Trending', 'chicagosuntimes' ),
				'lifestyles-menu'      	=> esc_html__( 'Lifestyles', 'chicagosuntimes' ),
				'lifestyles-trending'   => esc_html__( 'Lifestyles Trending', 'chicagosuntimes' ),
				'opinion-menu'       	=> esc_html__( 'Opinion', 'chicagosuntimes' ),
				'opinion-trending'   	=> esc_html__( 'Opinion Trending', 'chicagosuntimes' ),
				'columnists-menu'       => esc_html__( 'Columnists', 'chicagosuntimes' ),
				'columnists-trending'   => esc_html__( 'Columnists Trending', 'chicagosuntimes' )
			)
		);

		add_feed( 'print', array( $this, 'render_print_feed' ) );

	}

	/**
	 * Register custom post types for the theme
	 */
	private function register_post_types() {
		global $wp_post_types;

		// We aren't using the default post type
		// Unsetting causes errors, so hiding is better.
		$wp_post_types[ 'post' ]->public = false;
		$wp_post_types[ 'post' ]->show_ui = false;
		$wp_post_types[ 'post' ]->show_in_menu = false;
		$wp_post_types[ 'post' ]->show_in_admin_bar = false;
		$wp_post_types[ 'post' ]->show_in_nav_menus = false;

		$this->post_types[] = 'cst_article';
		register_post_type( 'cst_article', array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'menu_position'     => 6,
			'show_ui'           => true,
			'supports'          => array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'bitly',
				'revisions',
			),
			'has_archive'       => 'articles',
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'cst_article',
				),
			'labels'            => array(
				'name'                => esc_html__( 'Articles', 'chicagosuntimes' ),
				'singular_name'       => esc_html__( 'Article', 'chicagosuntimes' ),
				'all_items'           => esc_html__( 'Articles', 'chicagosuntimes' ),
				'new_item'            => esc_html__( 'New Article', 'chicagosuntimes' ),
				'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
				'add_new_item'        => esc_html__( 'Add New Article', 'chicagosuntimes' ),
				'edit_item'           => esc_html__( 'Edit Article', 'chicagosuntimes' ),
				'view_item'           => esc_html__( 'View Article', 'chicagosuntimes' ),
				'search_items'        => esc_html__( 'Search Articles', 'chicagosuntimes' ),
				'not_found'           => esc_html__( 'No Articles found', 'chicagosuntimes' ),
				'not_found_in_trash'  => esc_html__( 'No Articles found in trash', 'chicagosuntimes' ),
				'parent_item_colon'   => esc_html__( 'Parent Article', 'chicagosuntimes' ),
				'menu_name'           => esc_html__( 'Articles', 'chicagosuntimes' ),
			),
		) );

		$this->post_types[] = 'cst_link';
		register_post_type( 'cst_link', array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'menu_position'     => 7,
			'menu_icon'         => 'dashicons-admin-links',
			'show_ui'           => true,
			'supports'          => array(
				'title',
				'author',
				'thumbnail',
				'excerpt',				
				'bitly',
			),
			'has_archive'       => 'links',
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'cst_link',
				),
			'labels'            => array(
				'name'                => esc_html__( 'Links', 'chicagosuntimes' ),
				'singular_name'       => esc_html__( 'Link', 'chicagosuntimes' ),
				'all_items'           => esc_html__( 'Links', 'chicagosuntimes' ),
				'new_item'            => esc_html__( 'New Link', 'chicagosuntimes' ),
				'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
				'add_new_item'        => esc_html__( 'Add New Link', 'chicagosuntimes' ),
				'edit_item'           => esc_html__( 'Edit Link', 'chicagosuntimes' ),
				'view_item'           => esc_html__( 'View Link', 'chicagosuntimes' ),
				'search_items'        => esc_html__( 'Search Links', 'chicagosuntimes' ),
				'not_found'           => esc_html__( 'No Links found', 'chicagosuntimes' ),
				'not_found_in_trash'  => esc_html__( 'No Links found in trash', 'chicagosuntimes' ),
				'parent_item_colon'   => esc_html__( 'Parent Link', 'chicagosuntimes' ),
				'menu_name'           => esc_html__( 'Links', 'chicagosuntimes' ),
			),
		) );

		$this->post_types[] = 'cst_embed';
		register_post_type( 'cst_embed', array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'menu_position'     => 8,
			'menu_icon'         => 'dashicons-twitter',
			'show_ui'           => true,
			'supports'          => array(
				'author',
				'bitly',
			),
			'has_archive'       => 'embeds',
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'cst_embed',
			),
			'labels'            => array(
				'name'                => esc_html__( 'Embeds', 'chicagosuntimes' ),
				'singular_name'       => esc_html__( 'Embed', 'chicagosuntimes' ),
				'all_items'           => esc_html__( 'Embeds', 'chicagosuntimes' ),
				'new_item'            => esc_html__( 'New Embed', 'chicagosuntimes' ),
				'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
				'add_new_item'        => esc_html__( 'Add New Embed', 'chicagosuntimes' ),
				'edit_item'           => esc_html__( 'Edit Embed', 'chicagosuntimes' ),
				'view_item'           => esc_html__( 'View Embed', 'chicagosuntimes' ),
				'search_items'        => esc_html__( 'Search Embeds', 'chicagosuntimes' ),
				'not_found'           => esc_html__( 'No Embeds found', 'chicagosuntimes' ),
				'not_found_in_trash'  => esc_html__( 'No Embeds found in trash', 'chicagosuntimes' ),
				'parent_item_colon'   => esc_html__( 'Parent Embed', 'chicagosuntimes' ),
				'menu_name'           => esc_html__( 'Embeds', 'chicagosuntimes' ),
			),
		) );

		$this->post_types[] = 'cst_gallery';
		register_post_type( 'cst_gallery', array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'menu_position'     => 9,
			'menu_icon'         => 'dashicons-format-gallery',
			'show_ui'           => true,
			'supports'          => array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'bitly',
			),
			'has_archive'       => 'galleries',
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'cst_gallery',
				),
			'labels'            => array(
				'name'                => esc_html__( 'Galleries', 'chicagosuntimes' ),
				'singular_name'       => esc_html__( 'Gallery', 'chicagosuntimes' ),
				'all_items'           => esc_html__( 'Galleries', 'chicagosuntimes' ),
				'new_item'            => esc_html__( 'New Gallery', 'chicagosuntimes' ),
				'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
				'add_new_item'        => esc_html__( 'Add New Gallery', 'chicagosuntimes' ),
				'edit_item'           => esc_html__( 'Edit Gallery', 'chicagosuntimes' ),
				'view_item'           => esc_html__( 'View Gallery', 'chicagosuntimes' ),
				'search_items'        => esc_html__( 'Search Galleries', 'chicagosuntimes' ),
				'not_found'           => esc_html__( 'No Galleries found', 'chicagosuntimes' ),
				'not_found_in_trash'  => esc_html__( 'No Galleries found in trash', 'chicagosuntimes' ),
				'parent_item_colon'   => esc_html__( 'Parent Gallery', 'chicagosuntimes' ),
				'menu_name'           => esc_html__( 'Galleries', 'chicagosuntimes' ),
			),
		) );

		$this->post_types[] = 'cst_liveblog';
		register_post_type( 'cst_liveblog', array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'menu_position'     => 11,
			'menu_icon'         => 'dashicons-format-status',
			'show_ui'           => true,
			'supports'          => array(
				'title',
				'editor',
				'author',
				'bitly',
			),
			'has_archive'       => 'liveblogs',
			'rewrite'           => array(
				'slug'          => 'cst_liveblog',
				),

			'query_var'         => true,
			'labels'            => array(
				'name'                => esc_html__( 'Liveblogs', 'chicagosuntimes' ),
				'singular_name'       => esc_html__( 'Liveblog', 'chicagosuntimes' ),
				'all_items'           => esc_html__( 'Liveblogs', 'chicagosuntimes' ),
				'new_item'            => esc_html__( 'New Liveblog', 'chicagosuntimes' ),
				'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
				'add_new_item'        => esc_html__( 'Add New Liveblog', 'chicagosuntimes' ),
				'edit_item'           => esc_html__( 'Edit Liveblog', 'chicagosuntimes' ),
				'view_item'           => esc_html__( 'View Liveblog', 'chicagosuntimes' ),
				'search_items'        => esc_html__( 'Search Liveblogs', 'chicagosuntimes' ),
				'not_found'           => esc_html__( 'No Liveblogs found', 'chicagosuntimes' ),
				'not_found_in_trash'  => esc_html__( 'No Liveblogs found in trash', 'chicagosuntimes' ),
				'parent_item_colon'   => esc_html__( 'Parent Liveblog', 'chicagosuntimes' ),
				'menu_name'           => esc_html__( 'Liveblogs', 'chicagosuntimes' ),
			),
		) );

		$this->post_types[] = 'cst_video';
		register_post_type( 'cst_video', array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'menu_position'     => 11,
			'menu_icon'         => 'dashicons-media-video',
			'show_ui'           => true,
			'supports'          => array(
				'title',
				'author',
				'thumbnail',
				'bitly',
			),
			'has_archive'       => 'video',
			'rewrite'           => array(
				'slug'          => 'cst_video',
				),

			'query_var'         => true,
			'labels'            => array(
				'name'                => esc_html__( 'Videos', 'chicagosuntimes' ),
				'singular_name'       => esc_html__( 'Video', 'chicagosuntimes' ),
				'all_items'           => esc_html__( 'Videos', 'chicagosuntimes' ),
				'new_item'            => esc_html__( 'New Video', 'chicagosuntimes' ),
				'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
				'add_new_item'        => esc_html__( 'Add New Video', 'chicagosuntimes' ),
				'edit_item'           => esc_html__( 'Edit Video', 'chicagosuntimes' ),
				'view_item'           => esc_html__( 'View Video', 'chicagosuntimes' ),
				'search_items'        => esc_html__( 'Search Videos', 'chicagosuntimes' ),
				'not_found'           => esc_html__( 'No Videos found', 'chicagosuntimes' ),
				'not_found_in_trash'  => esc_html__( 'No Videos found in trash', 'chicagosuntimes' ),
				'parent_item_colon'   => esc_html__( 'Parent Videos', 'chicagosuntimes' ),
				'menu_name'           => esc_html__( 'Videos', 'chicagosuntimes' ),
			),
		) );

		foreach( $this->get_post_types() as $post_type ) {
			// We have custom rewrite rules below
			add_filter( "{$post_type}_rewrite_rules", '__return_empty_array' );
		}

		// Register a subset of post types with Zoninator
		foreach( array( 'cst_article', 'cst_video', 'cst_liveblog', 'cst_gallery', 'cst_link' ) as $post_type ) {
			// Register video post type with Zoninator
			add_post_type_support( $post_type, $GLOBALS[ 'zoninator' ]->zone_taxonomy );
			register_taxonomy_for_object_type( $GLOBALS[ 'zoninator' ]->zone_taxonomy, $post_type);
		}

		// Clear Zoninator supported post types cache
		unset( $GLOBALS[ 'zoninator' ]->post_types );

	}

	/**
	 * Register custom taxonomies for the theme
	 */
	private function register_taxonomies() {

		// Only editors and above can manage terms
		$term_permissions = array(
			'manage_terms'  => 'edit_others_posts',
			'edit_terms'    => 'edit_others_posts',
			'delete_terms'  => 'edit_others_posts',
			'assign_terms'  => 'edit_posts'
			);

		register_taxonomy( 'cst_section', $this->post_types, array(
			'hierarchical'      => true,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'section',
				),
			'capabilities'      => $term_permissions,
			'labels'            => array(
				'name'                       => esc_html__( 'Sections', 'chicagosuntimes' ),
				'singular_name'              => esc_html( _x( 'Section', 'taxonomy general name', 'chicagosuntimes' ) ),
				'search_items'               => esc_html__( 'Search Sections', 'chicagosuntimes' ),
				'popular_items'              => esc_html__( 'Popular Sections', 'chicagosuntimes' ),
				'all_items'                  => esc_html__( 'All Sections', 'chicagosuntimes' ),
				'parent_item'                => esc_html__( 'Parent Section', 'chicagosuntimes' ),
				'parent_item_colon'          => esc_html__( 'Parent Section:', 'chicagosuntimes' ),
				'edit_item'                  => esc_html__( 'Edit Section', 'chicagosuntimes' ),
				'update_item'                => esc_html__( 'Update Section', 'chicagosuntimes' ),
				'add_new_item'               => esc_html__( 'New Section', 'chicagosuntimes' ),
				'new_item_name'              => esc_html__( 'New Section', 'chicagosuntimes' ),
				'separate_items_with_commas' => esc_html__( 'Sections separated by comma', 'chicagosuntimes' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Sections', 'chicagosuntimes' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used Sections', 'chicagosuntimes' ),
				'menu_name'                  => esc_html__( 'Sections', 'chicagosuntimes' ),
			),
		) );

		register_taxonomy( 'cst_topic', $this->post_types, array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'topic',
				),
			'capabilities'      => $term_permissions,
			'labels'            => array(
				'name'                       => esc_html__( 'Topics', 'chicagosuntimes' ),
				'singular_name'              => esc_html( _x( 'Topic', 'taxonomy general name', 'chicagosuntimes' ) ),
				'search_items'               => esc_html__( 'Search Topics', 'chicagosuntimes' ),
				'popular_items'              => esc_html__( 'Popular Topics', 'chicagosuntimes' ),
				'all_items'                  => esc_html__( 'All Topics', 'chicagosuntimes' ),
				'parent_item'                => esc_html__( 'Parent Topic', 'chicagosuntimes' ),
				'parent_item_colon'          => esc_html__( 'Parent Topic:', 'chicagosuntimes' ),
				'edit_item'                  => esc_html__( 'Edit Topic', 'chicagosuntimes' ),
				'update_item'                => esc_html__( 'Update Topic', 'chicagosuntimes' ),
				'add_new_item'               => esc_html__( 'New Topic', 'chicagosuntimes' ),
				'new_item_name'              => esc_html__( 'New Topic', 'chicagosuntimes' ),
				'separate_items_with_commas' => esc_html__( 'Topics separated by comma', 'chicagosuntimes' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Topics', 'chicagosuntimes' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used Topics', 'chicagosuntimes' ),
				'menu_name'                  => esc_html__( 'Topics', 'chicagosuntimes' ),
			),
		) );

		register_taxonomy( 'cst_location', $this->post_types, array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'location',
			),
			'capabilities'      => $term_permissions,
			'labels'            => array(
				'name'                       => esc_html__( 'Locations', 'chicagosuntimes' ),
				'singular_name'              => esc_html( _x( 'Location', 'taxonomy general name', 'chicagosuntimes' ) ),
				'search_items'               => esc_html__( 'Search Locations', 'chicagosuntimes' ),
				'popular_items'              => esc_html__( 'Popular Locations', 'chicagosuntimes' ),
				'all_items'                  => esc_html__( 'All Locations', 'chicagosuntimes' ),
				'parent_item'                => esc_html__( 'Parent Location', 'chicagosuntimes' ),
				'parent_item_colon'          => esc_html__( 'Parent Location:', 'chicagosuntimes' ),
				'edit_item'                  => esc_html__( 'Edit Location', 'chicagosuntimes' ),
				'update_item'                => esc_html__( 'Update Location', 'chicagosuntimes' ),
				'add_new_item'               => esc_html__( 'New Location', 'chicagosuntimes' ),
				'new_item_name'              => esc_html__( 'New Location', 'chicagosuntimes' ),
				'separate_items_with_commas' => esc_html__( 'Locations separated by comma', 'chicagosuntimes' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Locations', 'chicagosuntimes' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used Locations', 'chicagosuntimes' ),
				'menu_name'                  => esc_html__( 'Locations', 'chicagosuntimes' ),
			),
		) );

		register_taxonomy( 'cst_person', $this->post_types, array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => false,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'          => 'person',
				),
			'capabilities'      => $term_permissions,
			'labels'            => array(
				'name'                       => esc_html__( 'People', 'chicagosuntimes' ),
				'singular_name'              => esc_html( _x( 'Person', 'taxonomy general name', 'chicagosuntimes' ) ),
				'search_items'               => esc_html__( 'Search People', 'chicagosuntimes' ),
				'popular_items'              => esc_html__( 'Popular People', 'chicagosuntimes' ),
				'all_items'                  => esc_html__( 'All People', 'chicagosuntimes' ),
				'parent_item'                => esc_html__( 'Parent Person', 'chicagosuntimes' ),
				'parent_item_colon'          => esc_html__( 'Parent Person:', 'chicagosuntimes' ),
				'edit_item'                  => esc_html__( 'Edit Person', 'chicagosuntimes' ),
				'update_item'                => esc_html__( 'Update Person', 'chicagosuntimes' ),
				'add_new_item'               => esc_html__( 'New Person', 'chicagosuntimes' ),
				'new_item_name'              => esc_html__( 'New Person', 'chicagosuntimes' ),
				'separate_items_with_commas' => esc_html__( 'People separated by comma', 'chicagosuntimes' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove People', 'chicagosuntimes' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used People', 'chicagosuntimes' ),
				'menu_name'                  => esc_html__( 'People', 'chicagosuntimes' ),
			),
		) );

	}

	/**
	 * Register rewrite rules for our custom post types
	 */
	public function filter_post_rewrite_rules() {

		$rewrites = array();

		// Rewrite rules for our custom post types
		$post_types = '';
		foreach( $this->get_post_types() as $ptype ) {
			$post_types .= '&post_type[]=' . $ptype;
		}

		$sections = get_terms( array( 'cst_section' ), array( 'hide_empty' => false, 'fields' => 'id=>slug' ) );
		$sections_match = implode( '|', $sections );
		$rewrites[ '(' . $sections_match . ')/([^/]+)/page/?([0-9]{1,})/?$' ] = 'index.php?cst_section=$matches[1]&name=$matches[2]&paged=$matches[3]' . $post_types;
		$rewrites[ '(' . $sections_match . ')/([^/]+)(/[0-9]+)?/?$' ] = 'index.php?cst_section=$matches[1]&name=$matches[2]&page=$matches[3]' . $post_types;
		$rewrites[ '(' . $sections_match . ')/([^/]+)/liveblog/(.*)/?$' ] = 'index.php?index.php?cst_section=$matches[1]&name=$matches[2]&liveblog=$matches[3]' . $post_types;

		return $rewrites;
	}

	/**
	 * Get the post types the site is using
	 *
	 * @return array
	 */
	public function get_post_types() {
		return $this->post_types;
	}

	/**
	 * Filter the Taxonomy Images option to always use our taxonomies
	 */
	public function filter_taxonomy_image_plugin_settings( $option ) {

		$option['taxonomies'] = array(
			'cst_topic',
			'cst_section',
			'cst_location',
			'cst_person',
			);
		return $option;
	}

	/**
	 * Filter post type links
	 */
	public function filter_post_type_link( $link, $post ) {

		if ( 'cst_link' === $post->post_type ) {
			$link = get_post_meta( $post->ID, 'external_url', true );
		} else if ( in_array( $post->post_type, $this->get_post_types() ) ) {

			$query = parse_url( $link, PHP_URL_QUERY );
			parse_str( $query, $args );
			// Generating a preview link
			if ( ! empty( $args['post_type'] ) && $args['post_type'] === $post->post_type ) {
				return $link;
			}

			$unixtime = strtotime( $post->post_date );
			$date = explode( " ",date( 'Y m d H i s', $unixtime ) );
			// Sometimes the permalink is passed for preview links
			if ( 'publish' === $post->post_status && $post->post_name ) {
				$post_name = $post->post_name;
			} else {
				$post_name = '%' . $post->post_type . '%';
			}

			$post = \CST\Objects\Post::get_by_post_id( $post->ID );
			$primary_section = $post->get_primary_parent_section();
			// This shouldn't ever happen, but just in case
			if ( empty( $primary_section ) ) {

				if( $post->get_child_parent_section() ) {
					$section_slug = $post->get_child_parent_section();
				} else {
					$section_slug = CST_DEFAULT_SECTION;
				}
				
			} else {
				$section_slug = $primary_section->slug;
			}

			$search_replace = array(
				'%year%'        => $date[0],
				'%monthnum%'    => $date[1],
				'%day%'         => $date[2],
				'%postname%'    => $post_name,
				'%cst_section%' => $section_slug,
				);

			$permalink_struct = '%cst_section%/%postname%/';
			$link = home_url( str_replace( array_keys( $search_replace ), array_values( $search_replace ), $permalink_struct ) );
		}

		return $link;
	}

	/**
	 * Add post types to sitemap
	 */
	public function filter_sitemap_post_types( $post_types ) {

		if ( false !== ( $key = array_search( 'post', $post_types ) ) ) {
			unset( $post_types[ $key ] );
		}

		$post_types = array_merge( $post_types, $this->get_post_types() );

		// Prohibited because external content
		if ( false !== ( $key = array_search( 'cst_link', $post_types ) ) ) {
			unset( $post_types[ $key ] );
		}
		if ( false !== ( $key = array_search( 'cst_embed', $post_types ) ) ) {
			unset( $post_types[ $key ] );
		}

		return $post_types;
	}

	/**
	 * Produce our own HTML for galleries
	 *
	 * @param string $html
	 * @param array $attr
	 * @return string
	 */
	public function filter_post_gallery( $html, $attr ) {

		if ( is_singular( 'cst_gallery' ) ) {
			$obj = new \CST\Objects\Gallery( get_the_ID() );
		} else {
			return '';
		}

		return $this->get_template_part( 'post/gallery-slides', array( 'obj' => $obj ) );
	}

	/**
	 * Filter unique slugs to ensure slugs are unique across all post types
	 */
	public function filter_wp_unique_post_slug( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug ) {
		global $wpdb, $wp_rewrite;

		if ( ! in_array( $post_type, $this->get_post_types() ) ) {
			return $slug;
		}

		$feeds = $wp_rewrite->feeds;
		if ( ! is_array( $feeds ) ) {
			$feeds = array();
		}

		// Post slugs must be unique across all posts of all post types
		$post_types_sql = "'" . implode( "','", array_map( 'sanitize_key', $this->get_post_types() ) ) . "'";
		$check_sql = "SELECT post_name FROM $wpdb->posts WHERE post_name = %s AND post_type IN ({$post_types_sql}) AND ID != %d LIMIT 1";
		$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $slug, $post_ID ) );

		if ( $post_name_check || in_array( $slug, $feeds ) ) {
			$suffix = 2;
			do {
				$alt_post_name = _truncate_post_slug( $slug, 200 - ( strlen( $suffix ) + 1 ) ) . "-$suffix";
				$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $alt_post_name, $post_ID ) );
				$suffix++;
			} while ( $post_name_check );
			$slug = $alt_post_name;
		}

		return $slug;

	}

	/**
	 * Add the gallery backdrop to the footer
	 */
	public function action_wp_footer_gallery_backdrop() {
		echo $this->get_template_part( 'post/gallery-backdrop' );
	}

	/**
	 * Add post(s) to the print feed
	 *
	 * @param mixed
	 */
	public function add_to_print_feed( $post_ids ) {

		if ( ! is_array( $post_ids ) ) {
			$post_ids = array( $post_ids );
		}

		$print_post_ids = $this->get_print_feed_post_ids();

		// Make sure post ids are integers added in the order passed
		$post_ids = array_map( 'intval', $post_ids );
		$post_ids = array_reverse( $post_ids );

		foreach( $post_ids as $post_id ) {
			if ( ! in_array( $post_id, $print_post_ids ) ) {
				array_unshift( $print_post_ids, $post_id );
			}
		}

		// Limit to 100 and reindex
		$print_post_ids = array_slice( $print_post_ids, 0, 100 );
		$print_post_ids = array_values( $print_post_ids );

		$this->set_print_feed_post_ids( $print_post_ids );
	}

	/**
	 * Remove post(s) from the print feed
	 *
	 * @param mixed
	 */
	public function remove_from_print_feed( $post_ids ) {

		if ( ! is_array( $post_ids ) ) {
			$post_ids = array( $post_ids );
		}

		$print_post_ids = $this->get_print_feed_post_ids();

		// Make sure post ids are integers
		$post_ids = array_map( 'intval', $post_ids );

		$print_post_ids = array_diff( $print_post_ids, $post_ids );
		$print_post_ids = array_values( $print_post_ids );

		$this->set_print_feed_post_ids( $print_post_ids );
	}

	/**
	 * Get the IDs for posts in the print feed
	 *
	 * @return array
	 */
	public function get_print_feed_post_ids() {
		return get_option( 'cst_print_feed_post_ids', array() );
	}

	/**
	 * Set the IDs for the posts in the print feed
	 *
	 * @param array
	 */
	public function set_print_feed_post_ids( $post_ids ) {
		update_option( 'cst_print_feed_post_ids', $post_ids );
	}

	/**
	 * Is this post in the print feed?
	 *
	 * @param int $post_id
	 * @return bool
	 */
	public function is_post_in_print_feed( $post_id ) {
		return in_array( $post_id, $this->get_print_feed_post_ids() );
	}

	/**
	 * Render the print feed as RSS
	 */
	public function render_print_feed() {
		add_filter( 'the_title_rss',  function( $title ) {
			$obj= CST\Objects\Post::get_by_post_id( get_the_ID() );
			if ( $obj && $print_slug = $obj->get_print_slug() ) {
				return $print_slug;
			} else {
				return $title;
			}
		});
		load_template( ABSPATH . WPINC . '/feed-rss2.php' );
	}

	/**
	 * Get a rendered template part
	 *
	 * @param string $template
	 * @param array $vars
	 * @return string
	 */
	public function get_template_part( $template, $vars = array() ) {

		$full_path = get_template_directory() . '/parts/' . $template . '.php';
		if ( ! file_exists( $full_path ) ) {
			return '';
		}

		ob_start();
		extract( $vars );
		include $full_path;
		return ob_get_clean();
	}

	/**
	 * Get and return primary section slug
	 * @return mixed|string
	 */
	public function get_primary_section_slug() {

		$obj = get_queried_object();

		if( is_tax() ) :
			if ( $section = $obj->slug ) :
				if( ( $section != 'sports' || $obj != 'news' ) && $obj->parent != 0 ) :
					$section = get_term( $obj->parent, 'cst_section' )->slug;
				else :
					$section = 'news';
				endif;
			else:
				$section = \CST\Objects\Post::get_by_post_id( $obj->ID )->get_primary_section()->slug;
			endif;
		else:
			$section = \CST\Objects\Post::get_by_post_id( $obj->ID )->get_primary_parent_section()->slug;
		endif;

		return $section;
	}

}

/**
 * Load the theme
 */
function CST() {
	return CST::get_instance();
}
add_action( 'after_setup_theme', 'CST' );

class GC_walker_nav_menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	public function start_lvl(&$output, $depth = 0, $args = array() ) {
		
		// depth dependent classes
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// build html
		$output .= "\n" . $indent . '<ul class="dropdown">' . "\n";

	}

}

if ( ! function_exists( 'GC_menu_set_dropdown' ) ) :

	function GC_menu_set_dropdown($sorted_menu_items, $args) {
		$last_top = 0;
	  	foreach ( $sorted_menu_items as $key => $obj) {
	    	// it is a top lv item?
	    	if ( 0 == $obj->menu_item_parent ) {
	      	// set the key of the parent
	      		$last_top = $key;
	    	} else {
	      		$sorted_menu_items[$last_top]->classes['dropdown'] = 'has-dropdown';
	    	}
	  	}
	  return $sorted_menu_items;

	}

endif;
add_filter( 'wp_nav_menu_objects', 'GC_menu_set_dropdown', 10, 2 );