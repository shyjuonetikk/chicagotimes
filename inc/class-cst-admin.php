<?php

/**
 * Theme functionality for the admin
 */
class CST_Admin {

	private static $instance;

	private $edit_print_feed_cap = 'edit_others_posts';

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Admin;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
		}
		return self::$instance;
	}

	/**
	 * Set up admin customization actions
	 */
	private function setup_actions() {

		add_action( 'init', array( $this, 'action_init_register_fields' ) );

		add_action( 'admin_init', array( $this, 'handle_bulk_print_feed_action' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts' ) );
		add_action( 'load-edit.php', array( $this, 'action_load_edit' ) );
		add_action( 'load-post.php', array( $this, 'action_load_post' ) );
		add_action( 'admin_head', array( $this, 'action_admin_head' ) );

		add_action( 'admin_menu', array( $this, 'action_admin_menu_late' ), 100 );

		add_action( 'save_post', array( $this, 'action_save_post_late' ), 100 );

		add_action( 'transition_post_status', array( $this, 'action_save_post_app_update' ), 100, 3 );

		add_action( 'add_meta_boxes', array( $this, 'action_add_meta_boxes' ), 20, 2 );

		add_action( 'restrict_manage_posts', function() {

			if ( is_object_in_taxonomy( get_current_screen()->post_type, 'cst_section' ) ) {

				$selected = 0;
				if ( isset( $_GET['cst_section'] ) ) {
					if ( is_numeric( $_GET['cst_section'] ) ) {
						$term = wpcom_vip_get_term_by( 'id', (int) $_GET['cst_section'], 'cst_section' );
					} else {
						$term = wpcom_vip_get_term_by( 'slug', sanitize_text_field( $_GET['cst_section'] ), 'cst_section' );
					}
					if ( $term ) {
						$selected = $term->term_id;
					}
				}

				$dropdown_options = array(
					'show_option_all'    => esc_html__( 'View all sections', 'chicagosuntimes' ),
					'hide_empty'         => 0,
					'hierarchical'       => 1,
					'show_count'         => 0,
					'orderby'            => 'name',
					'selected'           => $selected,
					'name'               => 'cst_section',
					'taxonomy'           => 'cst_section',
				);
				wp_dropdown_categories( $dropdown_options );
			}

		});
		add_action( 'restrict_manage_posts', array( $this, 'action_author_filter' ) );
		add_action( 'pre_get_posts', function( $query ) {
			global $pagenow;

			if ( 'edit.php' == $pagenow && $query->is_main_query() && is_numeric( $query->get( 'cst_section' ) ) ) {
				$term = wpcom_vip_get_term_by( 'id', (int) $_GET['cst_section'], 'cst_section' );
				if ( $term ) {
					$query->set( 'cst_section', $term->slug );
				}
			}
		});
		add_action( 'fm_term_cst_section', array( $this, 'section_sponsorship_fields' ) );
	}

	/**
	 * Set up our admin customization filters
	 */
	private function setup_filters() {

		add_filter( 'fm_element_markup_start', array( $this, 'filter_fm_element_markup_start' ), 10, 2 );

		add_filter( 'attachment_fields_to_edit', function( $fields, $post ) {

			$metadata = wp_get_attachment_metadata( $post->ID );
			if ( ! empty( $metadata['image_meta'] ) ) {
				$fields['chicagosuntimes_credit'] = array(
					'label'              => esc_html__( 'Credit', 'chicagosuntimes' ),
					'input'              => 'text',
					'value'              => $metadata['image_meta']['credit'],
					);
			}

			return $fields;
		}, 10, 2 );

		add_filter( 'attachment_fields_to_save', function( $data, $attachment ) {

			$metadata = wp_get_attachment_metadata( $data['ID'] );
			if ( ! empty( $metadata['image_meta'] ) && isset( $attachment['chicagosuntimes_credit'] ) ) {
				$metadata['image_meta']['credit'] = sanitize_text_field( $attachment['chicagosuntimes_credit'] );
				wp_update_attachment_metadata( $data['ID'], $metadata );
			}

			return $data;

		}, 10, 2 );

		add_filter( 'coauthors_guest_author_fields', array( $this, 'filter_coauthors_guest_author_fields' ), 10, 2 );

		/*
		 * Fix active menu when managing terms and guest authors
		 */
		add_filter( 'parent_file', function( $parent_file ){
			global $pagenow;
			if ( 'edit-tags.php' == $pagenow ) {
				return 'edit-tags.php?taxonomy=cst_section';
			}
			if ( 'post' == get_current_screen()->base && 'guest-author' == get_current_screen()->post_type ) {
				return 'tools.php';
			}
			return $parent_file;
		});

		add_filter( 'enter_title_here', array( $this, 'filter_custom_enter_title' ) );
		add_filter( 'admin_post_thumbnail_html', array( $this, 'filter_featured_image_instruction' ) );

	}

	/**
	 * Customizations to the admin menu
	 */
	public function action_admin_menu_late() {
		global $menu;

		// Hide posts menu because we don't use posts
		unset( $menu[ 5 ] );

		// Orient video, media, liveblog and zones
		/* $liveblog = array(
			esc_html__( 'Liveblogs', 'chicagosuntimes' ),
			'edit_posts',
			'edit.php?post_type=cst_liveblog',
			'',
			'menu-top menu-icon-cst_liveblog',
			'menu-posts-cst_liveblog',
			'dashicons-format-status',
		); */
		$media = $menu[ 10 ];
		$zones = $menu[ 11 ];
		$video = $menu[ 12 ];

		if ( isset( $menu[ 25 ] ) ) {
			$menu[ 25 ][ 2 ] = 'https://cstbreakingnews.disqus.com/admin/moderate/';
		}

		//$menu[ 10 ] = $liveblog;
 		$menu[ 10 ] = $media;
 		$menu[ 11 ] = $zones;
 		$menu[ 12 ] = $video;

		// Modify standard taxonomy links
		$taxonomies = array( 'cst_section', 'cst_person', 'cst_location', 'cst_topic' );
		$post_types_to_change = CST()->get_post_types();
		if ( current_user_can( 'adops' ) ) {
			$post_types_to_change[] = 'cst_wire_item';
			$post_types_to_change[] = 'cst_usa_today_item';
			$post_types_to_change[] = 'cst_shia_kapos_item';
			$post_types_to_change[] = 'cst_chicago_item';
		}
		foreach ( $post_types_to_change as $post_type ) {
			foreach ( $taxonomies as $taxonomy ) {
				remove_submenu_page( 'edit.php?post_type=' . $post_type, 'edit-tags.php?taxonomy=' . $taxonomy . '&amp;post_type=' . $post_type );
				if ( current_user_can( 'adops' ) && ! current_user_can( 'manage_options' ) ) {
					remove_menu_page( 'edit-tags.php?taxonomy=' . $taxonomy . '&amp;post_type=' . $post_type );
					remove_menu_page( 'edit.php?post_type=' . $post_type );
				}
			}
		}

		if ( current_user_can( 'edit_others_posts' ) ) {
			add_menu_page( esc_html__( 'Terms', 'chicagosuntimes' ), esc_html__( 'Terms', 'chicagosuntimes' ), 'edit_others_posts', 'edit-tags.php?taxonomy=cst_section', false, 'dashicons-tag', 14 );
			foreach ( $taxonomies as $taxonomy ) {
				if ( ! current_user_can( 'adops' ) || current_user_can( 'manage_options' ) ) {
					add_submenu_page( 'edit-tags.php?taxonomy=cst_section', get_taxonomy( $taxonomy )->labels->name, get_taxonomy( $taxonomy )->labels->name, 'adops', 'edit-tags.php?taxonomy=' . $taxonomy );
				}
			}
		}

	}

	/**
	 * Register Fieldmanager fields
	 */
	public function action_init_register_fields() {
		global $pagenow;

		$article = isset( $_GET['post'] ) ? get_post( absint( $_GET['post'] ) ) : false;

		/**
		 * Article
		 */
		$featured_media = new \Fieldmanager_Group( '', array(
			'name'        => 'cst_production',
			'tabbed'      => true,
			) );
		$featured_media->children['featured_media'] = new \Fieldmanager_Group( esc_html__( 'Featured Media', 'chicagosuntimes' ), array(
			'name'             => 'featured_media',
			'children'         => array(
				'featured_media_type'         => new \Fieldmanager_Select( esc_html__( 'Type of media to feature', 'chicagosuntimes' ), array(
					'name'     => 'featured_media_type',
					'options'  => array(
						'image'        => esc_html__( "Article's Featured Image", 'chicagosuntimes' ),
						'gallery'      => esc_html__( 'Gallery', 'chicagosuntimes' ),
						'video'      => esc_html__( 'Video', 'chicagosuntimes' ),
						),
					) ),
				'featured_gallery'     => new \Fieldmanager_Autocomplete( esc_html__( 'Featured Gallery', 'chicagosuntimes' ), array(
					'name'             => 'featured_gallery',
					'attributes'       => array(
						'placeholder'  => esc_html__( 'Search by title', 'chicagosuntimes' ),
						'size'         => 45,
						),
					'datasource'       => new \Fieldmanager_Datasource_Post( array(
						'query_args'        => array(
							'post_type'     => array( 'cst_gallery' ),
							),
						) )
					) ),
				'featured_video'          => new \Fieldmanager_Select( esc_html__( 'Choose video category', 'chicagosuntimes' ), array(
					'name'     => 'featured_video',
					'description' => 'Choosing this option replaces the featured image with a video embed element and automatically places the featured image further down the content.',
					'options'  => array(
						'cubs'       => esc_html__( "Chicago Cubs", 'chicagosuntimes' ),
						'white-sox'  => esc_html__( 'Chicago White Sox', 'chicagosuntimes' ),
						'bulls'      => esc_html__( "Chicago Bulls", 'chicagosuntimes' ),
						'bears'      => esc_html__( 'Chicago Bears', 'chicagosuntimes' ),
						'pga-golf'   => esc_html__( 'PGA Golf', 'chicagosuntimes' ),
						'nascar'     => esc_html__( 'NASCAR', 'chicagosuntimes' ),
						'ahl-wolves' => esc_html__( 'AHL Wolves', 'chicagosuntimes' ),
						'college'    => esc_html__( 'College', 'chicagosuntimes' ),
						'rio-2016'   => esc_html__( 'Rio 2016', 'chicagosuntimes' ),
						'blackhawks-hockey' => esc_html__( 'Blackhawks', 'chicagosuntimes' ),
					),
				) )
				),
			) );
		$featured_media->add_meta_box( esc_html__( 'Production', 'chicagosuntimes' ), array( 'cst_article' ), 'normal', 'high' );
		$terms_group = new \Fieldmanager_Group( '', array(
			'name'        => 'cst_preferred_terms',
			'tabbed'      => true,
			'persist_active_tab' => false,
		) );
		if ( 'post.php' == $pagenow && ( ( $article && 'cst_article' == $article->post_type ) || ! isset( $_GET['post'] ) ) ) {
			$selected_sections = array();
			if ( $article ) {
				$terms_assigned = get_the_terms( $article->ID, 'cst_section' );
				$selected_sections = wp_list_pluck( $terms_assigned, 'term_id' );
			}
			$terms_group->children['choose_section'] = new \Fieldmanager_Group( esc_html__( 'Choose Preferred section', 'chicagosuntimes' ), array(
				'name'        => 'choose_section',
				'description' => 'After saving a draft or publishing you can then select the preferred section. Choose the first/blank to disable this preference.',
				'children'    => array(
					'featured_option_section' => new \Fieldmanager_Select( esc_html__( 'Select existing Section', 'chicagosuntimes' ), array(
						'name'       => 'featured_option_section',
						'first_empty' => true,
						'attributes' => array(
							'placeholder' => esc_html__( 'Search by existing Section title', 'chicagosuntimes' ),
						),
						'datasource' => new \Fieldmanager_Datasource_Term( array(
							'taxonomy'                    => 'cst_section',
							'taxonomy_save_to_terms'      => false,
							'taxonomy_hierarchical_depth' => 3,
							'taxonomy_args'               => array(
								'hide_empty' => true,
								'include'    => $selected_sections,
							)
						) )
					) )
				)
			) );
		}
		$terms_group->children['choose_chatter'] = new \Fieldmanager_Group( esc_html__( 'Choose Chatter Widget', 'chicagosuntimes' ), array(
			'name'             => 'choose_chatter',
			'description' => 'Please select the Chatter Widget to be injected into the article body',
			'children'         => array(
				'chatter_widget_selection'         => new \Fieldmanager_Select( esc_html__( 'Select the Chatter Widget injected into the article', 'chicagosuntimes' ), array(
					'name'     => 'chatter_widget_selection',
					'options'  => array(
						'default_chatter' 	 => esc_html__( 'Article Section Chatter', 'chicagosuntimes' ),
						'politics_chatter'   => esc_html__( 'Politics Chatter', 'chicagosuntimes' ),
						'celeb_chatter'      => esc_html__( 'Celeb Chatter', 'chicagosuntimes' ),
						'sports_chatter'     => esc_html__( 'Sports Chatter', 'chicagosuntimes' ),
						'no_widget' 		 => esc_html__( 'No Chatter Widget', 'chicagosuntimes' ),
						),
					) )
			)));
		$terms_group->children['choose_topic'] = new \Fieldmanager_Group( esc_html__( 'Choose Topic', 'chicagosuntimes' ), array(
			'name'             => 'choose_topic',
			'description' => 'Please select the single Topic to display below the article',
			'children'         => array(
				'featured_option_topic'     => new \Fieldmanager_Autocomplete( esc_html__( 'Select existing Topic', 'chicagosuntimes' ), array(
					'name'             => 'featured_option_topic',
					'attributes'       => array(
						'placeholder'  => esc_html__( 'Search by existing Topic title', 'chicagosuntimes' ),
						'size'         => 45,
					),
					'datasource'       => new \Fieldmanager_Datasource_Term( array(
						'taxonomy' => 'cst_topic',
						'taxonomy_save_to_terms' => false,
					) )
				) )
			)));
		$terms_group->children['choose_location'] = new \Fieldmanager_Group( esc_html__( 'Choose Location', 'chicagosuntimes' ), array(
			'name'             => 'choose_location',
			'description' => 'Please select the single Location to display below the article',
			'children'         => array(
				'featured_option_location'     => new \Fieldmanager_Autocomplete( esc_html__( 'Select existing Location', 'chicagosuntimes' ), array(
					'name'             => 'featured_option_location',
					'attributes'       => array(
						'placeholder'  => esc_html__( 'Search by existing Location title', 'chicagosuntimes' ),
						'size'         => 45,
					),
					'datasource'       => new \Fieldmanager_Datasource_Term( array(
						'taxonomy' => 'cst_location',
						'taxonomy_save_to_terms' => false,
					) )
				) )
			)));
		$terms_group->children['choose_person'] = new \Fieldmanager_Group( esc_html__( 'Choose Person', 'chicagosuntimes' ), array(
			'name'             => 'choose_person',
			'description' => 'Please select the single Person to display below the article',
			'children'         => array(
				'featured_option_person'     => new \Fieldmanager_Autocomplete( esc_html__( 'Select existing Person', 'chicagosuntimes' ), array(
					'name'             => 'featured_option_person',
					'attributes'       => array(
						'placeholder'  => esc_html__( 'Search by existing Person', 'chicagosuntimes' ),
						'size'         => 45,
					),
					'datasource'       => new \Fieldmanager_Datasource_Term( array(
						'taxonomy' => 'cst_person',
						'taxonomy_save_to_terms' => false,
					) )
				) )
			),
		) );
		$terms_group->add_meta_box( esc_html__( 'Article Preferences', 'chicagosuntimes' ), array( 'cst_article' ), 'normal', 'high' );


		$fm = new Fieldmanager_Textfield( array(
			'name'    => 'freelancer_byline',
			'label'   => false,
			'description'           => esc_html__( 'Only the Byline Author will be displayed.', 'chicagosuntimes' ),
			) );
		$fm->add_meta_box( esc_html__( 'Freelancer Byline', 'chicagosuntimes' ), array( 'cst_article', 'cst_gallery' ), 'normal', 'high' );

		$fm = new Fieldmanager_Select( array( 
			'name' 	  => 'newsletter_tags',
			'description' => esc_html__( 'Used to identify stories that should appear in the Newsletters.', 'chicagosuntimes' ),
			'options' => array(
				'Normal_Story' 	=> 'Normal Story',
				'No_Newsletter'				=> 'No Newsletter',
				'Top_Story'		=> 'Top Story',
				'Hero' 	=> 'Hero Story'
				)
			) );
		$fm->add_meta_box( esc_html__( 'Newsletter Tag', 'chicagosuntimes' ), array( 'cst_article' ), 'normal', 'high' );

	if( is_admin() ) {
		$fm = new Fieldmanager_Select( array( 
			'name' 	  => 'yieldmo_tags',
			'description' => esc_html__( 'Used to test YieldMo Tags on Live Articles. Do not select an option if you do not know what this is.', 'chicagosuntimes' ),
			'options' => array(
				'YM_No_Demo'				=> 'No Tag Demo',
				'YM_Carousel_Demo' 			=> 'Carousel Tag Demo',
				'YM_Video_Demo'				=> 'Video Tag Demo',
				'YM_Window_Demo'				=> 'Window Tag Demo',
				'YM_Wrapper_Article_Demo' 	=> 'Article Wrapper Tag Demo',
				'YM_Wrapper_Homepage_Demo' 	=> 'Homepage Wrapper Tag Demo',
				'YM_Mainstage_Demo' 		=> 'Mainstage Tag Demo',
				)
			) );
		$fm->add_meta_box( esc_html__( 'YieldMo Test Tag', 'chicagosuntimes' ), array( 'cst_article', 'page' ), 'normal', 'high' );
	}	

		/**
		 * Link
		 */
		$fm = new Fieldmanager_Textfield( array(
			'name'    => 'external_url',
			'label'   => false
			) );
		$fm->add_meta_box( esc_html__( 'External URL', 'chicagosuntimes' ), array( 'cst_link' ), 'normal', 'high' );

		/**
		 * Embed
		 */
		$fm = new Fieldmanager_Textfield( array(
			'name'    => 'embed_url',
			'label'   => false
			) );
		$fm->add_meta_box( esc_html__( 'Embed URL', 'chicagosuntimes' ), array( 'cst_embed' ), 'normal', 'high' );

		/**
		 * Gallery
		 */
		$fm = new Fieldmanager_Media( array(
			'name'                 => 'gallery_images',
			'label'                => __( 'Image', 'chicagosuntimes' ),
			'limit'                => 0,
			'sortable'             => true,
			'add_more_label'       => esc_html__( 'Add Another Image', 'chicagosuntimes' )
			) );
		$fm->add_meta_box( esc_html__( 'Images', 'chicagosuntimes' ), array( 'cst_gallery' ) );

		/**
		 * Videos
		 */
		$fm = new Fieldmanager_Textfield( array(
			'name'                  => 'video_url',
			'label'                 => false,
			'description'           => esc_html__( 'YouTube videos are supported at this time.', 'chicagosuntimes' ),
			));
		$fm->add_meta_box( esc_html__( 'Video URL', 'chicagosuntimes' ), array( 'cst_video'), 'normal', 'high' );

		$fm = new Fieldmanager_Textfield( array(
			'name'                  => 'video_description',
			'label'                 => false,
			'description'           => esc_html__( '(Optional) Appears below the video embed.', 'chicagosuntimes' ),
			));
		$fm->add_meta_box( esc_html__( 'Video Description', 'chicagosuntimes' ), array( 'cst_video'), 'normal', 'high' );

		/**
		 * Subscribe Pages
		 */
		$subscribe_group = new \Fieldmanager_Group( '', array(
			'name'        => 'cst_subscribe',
			'tabbed'      => true,
			) );
		$subscribe_group->children['content'] = new \Fieldmanager_Group( esc_html__( 'Content', 'chicagosuntimes' ), array(
			'name'                    => 'content',
			'children'                => array(
				'top_left'          => new \Fieldmanager_TextField( esc_html__( 'Top Left Text', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Title text the displays at the top left of the page', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						)
					) ),
				'top_right'               => new \Fieldmanager_RichTextarea( esc_html__( 'Intro Text', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Text that displays at the top right of the page', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						)
					) ),
				'benefits'               => new \Fieldmanager_RichTextarea( esc_html__( 'Benefits Text', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Small text that displays below the Print packages explaining the benefits agreement with The Washington Post', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						)
					) ),
				'image'               => new \Fieldmanager_Media( esc_html__( 'Image', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Display an image at the top left of the page. Suggested image size is 300x40', 'chicagosuntimes' ),
					'button_label'    => esc_html__( 'Select an image', 'chicagosuntimes' ),
					'modal_button_label' => esc_html__( 'Select image', 'chicagosuntimes' ),
					'modal_title'     => esc_html__( 'Choose image', 'chicagosuntimes' ),
					) )
				),
			) );
		$subscribe_group->add_meta_box( esc_html__( 'Subscribe Page Print Content', 'chicagosuntimes' ), 'page' );
		$subscribe_print_group = new \Fieldmanager_Group( '', array(
			'name'        => 'cst_subscribe_print',
			'tabbed'      => true,
			) );
		$subscribe_print_group->children['print_package_1'] = new \Fieldmanager_Group( esc_html__( 'Package 1', 'chicagosuntimes' ), array(
			'name'                    => 'print_package_1',
			'children'                => array(
				'package_title'    	  	=> new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The Title & Days of the package (ie: Daily Delivery (Monday - Sunday))', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'         => 'width:100%',
						)
					) ),
				'package_description' 	=> new \Fieldmanager_RichTextarea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The description of this package', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_price'       	=> new \Fieldmanager_TextArea( esc_html__( 'Price', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The price of the package (ie: $18.99/month)', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_url'       	=> new \Fieldmanager_TextArea( esc_html__( 'Package URL', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The URL to the package purchase page', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) )
				),
			) );
		$subscribe_print_group->children['print_package_2'] = new \Fieldmanager_Group( esc_html__( 'Package 2', 'chicagosuntimes' ), array(
			'name'                    => 'print_package_2',
			'children'                => array(
				'package_title'    	  	=> new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The Title & Days of the package (ie: Daily Delivery (Monday - Sunday))', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'         => 'width:100%',
						)
					) ),
				'package_description' 	=> new \Fieldmanager_RichTextarea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The description of this package', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_price'       	=> new \Fieldmanager_TextArea( esc_html__( 'Price', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The price of the package (ie: $18.99/month)', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_url'       	=> new \Fieldmanager_TextArea( esc_html__( 'Package URL', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The URL to the package purchase page', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) )
				),
			) );
		$subscribe_print_group->children['print_package_3'] = new \Fieldmanager_Group( esc_html__( 'Package 3', 'chicagosuntimes' ), array(
			'name'                    => 'print_package_3',
			'children'                => array(
				'package_title'    	  	=> new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The Title & Days of the package (ie: Daily Delivery (Monday - Sunday))', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'         => 'width:100%',
						)
					) ),
				'package_description' 	=> new \Fieldmanager_RichTextarea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The description of this package', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_price'       	=> new \Fieldmanager_TextArea( esc_html__( 'Price', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The price of the package (ie: $18.99/month)', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_url'       	=> new \Fieldmanager_TextArea( esc_html__( 'Package URL', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The URL to the package purchase page', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) )
				),
			) );
		$subscribe_print_group->add_meta_box( esc_html__( 'Subscribe Page Print Package Content', 'chicagosuntimes' ), 'page' );
		$subscribe_digital_group = new \Fieldmanager_Group( '', array(
			'name'        => 'cst_subscribe_digital',
			'tabbed'      => true,
			) );
		$subscribe_digital_group->children['digital_package_1'] = new \Fieldmanager_Group( esc_html__( 'Package 1', 'chicagosuntimes' ), array(
			'name'                    => 'digital_package_1',
			'children'                => array(
				'package_title'    	  	=> new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The Title & Days of the package (ie: Daily Delivery (Monday - Sunday))', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'         => 'width:100%',
						)
					) ),
				'package_description' 	=> new \Fieldmanager_RichTextarea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The description of this package', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_price'       	=> new \Fieldmanager_TextArea( esc_html__( 'Price', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The price of the package (ie: $18.99/month)', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_url'       	=> new \Fieldmanager_TextArea( esc_html__( 'Package URL', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The URL to the package purchase page', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'image'               => new \Fieldmanager_Media( esc_html__( 'Image', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Display an image at the top left of the page. Suggested image size is 300x40', 'chicagosuntimes' ),
					'button_label'    => esc_html__( 'Select an image', 'chicagosuntimes' ),
					'modal_button_label' => esc_html__( 'Select image', 'chicagosuntimes' ),
					'modal_title'     => esc_html__( 'Choose image', 'chicagosuntimes' ),
					) )
				),
			) );
		$subscribe_digital_group->children['digital_package_2'] = new \Fieldmanager_Group( esc_html__( 'Package 2', 'chicagosuntimes' ), array(
			'name'                    => 'digital_package_2',
			'children'                => array(
				'package_title'    	  	=> new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The Title & Days of the package (ie: Daily Delivery (Monday - Sunday))', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'         => 'width:100%',
						)
					) ),
				'package_description' 	=> new \Fieldmanager_RichTextarea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The description of this package', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_price'       	=> new \Fieldmanager_TextArea( esc_html__( 'Price', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The price of the package (ie: $18.99/month)', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_url'       	=> new \Fieldmanager_TextArea( esc_html__( 'Package URL', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The URL to the package purchase page', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) )
				),
			) );
		$subscribe_digital_group->children['digital_package_3'] = new \Fieldmanager_Group( esc_html__( 'Package 3', 'chicagosuntimes' ), array(
			'name'                    => 'digital_package_3',
			'children'                => array(
				'package_title'    	  	=> new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The Title & Days of the package (ie: Daily Delivery (Monday - Sunday))', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'         => 'width:100%',
						)
					) ),
				'package_description' 	=> new \Fieldmanager_RichTextarea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The description of this package', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_price'       	=> new \Fieldmanager_TextArea( esc_html__( 'Price', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The price of the package (ie: $18.99/month)', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) ),
				'package_url'       	=> new \Fieldmanager_TextArea( esc_html__( 'Package URL', 'chicagosuntimes' ), array(
					'description'     	=> esc_html__( 'The URL to the package purchase page', 'chicagosuntimes' ),
					'attributes'      	=> array(
						'style'       	=> 'width:100%',
						)
					) )
				),
			) );
		$subscribe_digital_group->add_meta_box( esc_html__( 'Subscribe Page Digital Package Content', 'chicagosuntimes' ), 'page' );

		/**
		 * Distribution settings
		 */
		$meta_group = new \Fieldmanager_Group( '', array(
			'name'        => 'cst_distribution',
			'tabbed'      => true,
			) );

		// Can't use $fm_group->add_child(): https://github.com/alleyinteractive/wordpress-fieldmanager/pull/172
		$meta_group->children['twitter'] = new \Fieldmanager_Group( esc_html__( 'Twitter', 'chicagosuntimes' ), array(
			'name'                    => 'twitter',
			'children'                => array(
				'share_text'          => new \Fieldmanager_TextArea( esc_html__( 'Share Text', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'What text would you like the user to include in their tweet? (Defaults to title and shortlink)', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						)
					) ),
				'title'               => new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Title should be concise and will be truncated at 70 characters.', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						'maxlength'       => 70,
						)
					) ),
				'description'         => new \Fieldmanager_TextArea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Description text will be truncated at the word to 200 characters.', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						'maxlength'       => 200,
						'rows'            => 3,
						)
					) ),
				'image'               => new \Fieldmanager_Media( esc_html__( 'Image', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Override the featured image with an image specific to Twitter. The image must be a minimum size of 400x400px. Images larger than 400x400px will be resized and cropped square based on its longest dimension.', 'chicagosuntimes' ),
					'button_label'    => esc_html__( 'Select an image', 'chicagosuntimes' ),
					'modal_button_label' => esc_html__( 'Select image', 'chicagosuntimes' ),
					'modal_title'     => esc_html__( 'Choose image', 'chicagosuntimes' ),
					) )
				),
			) );
		$meta_group->children['facebook'] = new \Fieldmanager_Group( esc_html__( 'Facebook Open Graph', 'chicagosuntimes' ), array(
			'name'                    => 'facebook',
			'children'                => array(
				'title'               => new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'The title of your article, excluding any branding.', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						)
					) ),
				'description'         => new \Fieldmanager_TextArea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'A detailed description of the piece of content, usually between 2 and 4 sentences.', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						'rows'            => 4,
						)
					) ),
				'image'               => new \Fieldmanager_Media( esc_html__( 'Image', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Override the featured image with an image specific to Facebook. We suggest that you use an image of at least 1200x630 pixels.', 'chicagosuntimes' ),
					'button_label'    => esc_html__( 'Select an image', 'chicagosuntimes' ),
					'modal_button_label' => esc_html__( 'Select image', 'chicagosuntimes' ),
					'modal_title'     => esc_html__( 'Choose image', 'chicagosuntimes' ),
					) )
				),
			) );

		$seo_group = new \Fieldmanager_Group( esc_html__( 'SEO', 'chicagosuntimes' ), array(
			'name'        			  => 'seo',
			'children'                => array(
				'title'               => new \Fieldmanager_TextField( esc_html__( 'Title', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Suggested length of up to 60 characters.', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						)
					) ),
				'description'         => new \Fieldmanager_TextArea( esc_html__( 'Description', 'chicagosuntimes' ), array(
					'description'     => esc_html__( 'Suggested length of up to 150 characters. Defaults to excerpt.', 'chicagosuntimes' ),
					'attributes'      => array(
						'style'           => 'width:100%',
						'rows'            => 2,
						)
					) ),
				),
			) );
		$meta_group->children['seo'] = $seo_group;

		$post = isset( $_GET['post'] ) ? get_post( absint( $_GET['post'] ) ) : false;
		if ( 'post.php' == $pagenow && ( ( $post && 'cst_article' == $post->post_type ) || ! isset( $_GET['post'] ) ) )  {

			$print_group = new \Fieldmanager_Group( '<i class="dashicons dashicons-info"></i> ' . esc_html__( 'Print', 'chicagosuntimes' ), array(
				'name'        => 'print',
				'children'                => array(
					'print_slug'          => new \Fieldmanager_TextField( '<strong>' . esc_html__( 'Slug', 'chicagosuntimes' ) . '</strong>', array(
						'description'     => esc_html__( 'Enter the print slug.', 'chicagosuntimes' ),
						'attributes'      => array(
							'style'           => 'width:100%',
							)
						) ),
					),
				) );
			$meta_group->children['print'] = $print_group;

		}

		$meta_group->add_meta_box( esc_html__( 'Distribution', 'chicagosuntimes' ), CST()->get_post_types() );

	}

	/**
	 * Handle a bulk action to add or remove posts from the print feed
	 */
	public function handle_bulk_print_feed_action() {

		if ( empty( $_GET['action'] ) || ! in_array( $_GET['action'], array( 'cst-add-print-feed', 'cst-remove-print-feed' ) ) ) {
			return;
		}

		check_admin_referer( 'bulk-posts' );
		if ( ! current_user_can( $this->edit_print_feed_cap ) ) {
			wp_die( esc_html__( "You shouldn't be doing this.", 'chicagosuntimes' ) );
		}

		$post_ids = ! empty( $_GET['post'] ) ? array_map( 'intval', $_GET['post'] ) : array();

		if ( 'cst-add-print-feed' === $_GET['action'] ) {
			CST()->add_to_print_feed( $post_ids );
		} else if ( 'cst-remove-print-feed' === $_GET['action'] ) {
			CST()->remove_from_print_feed( $post_ids );
		}

		wp_safe_redirect( wp_get_referer() );
		exit;
	}

	/**
	 * What to do when loading the Manage Posts view
	 */
	public function action_load_edit() {

		$screen = get_current_screen();
		if ( 'cst_article' === $screen->post_type ) {

			add_filter( 'post_class', function( $classes, $class, $post_id ) {

				if ( CST()->is_post_in_print_feed( $post_id ) ) {
					$classes[] = 'cst-is-in-print-feed';
				}

				return $classes;
			}, 10, 3 );

		}


	}


	/**
	 * What to do when loading the Edit Posts view
	 */
	public function action_load_post() {

		$screen = get_current_screen();
		if ( 'cst_embed' === $screen->post_type && ! empty( $_GET['post'] ) && $obj = \CST\Objects\Embed::get_by_post_id( (int) $_GET['post'] ) ) {

			if ( 'twitter' == $obj->get_embed_type() && $obj->is_embed_data_errored() ) {
				$embed_data = $obj->get_embed_data();
				$error = array_shift( $embed_data->errors );
				add_action( 'admin_notices', function() use ( $error ) {
					echo '<div class="message error"><p>' . esc_html( sprintf( esc_html__( 'Twitter API error: %s (Code %d)', 'chicagosuntimes' ), $error->message, $error->code ) ) . '</p></div>';
				});
			}

		}


	}
	/**
	 * Custom scripts and styles for the admin
	 */
	public function action_admin_enqueue_scripts() {

		wp_enqueue_style( 'cst-admin', get_template_directory_uri() . '/assets/css/admin.css' );
		wp_enqueue_script( 'cst-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ) );
		wp_localize_script( 'cst-admin', 'CSTAdminData', array(
			'add_to_print_feed_label'            => esc_html__( 'Add to Print Feed', 'chicagosuntimes' ),
			'included_in_print_feed_label'       => esc_html__( 'Included in Print Feed', 'chicagosuntimes' ),
			'remove_from_print_feed_label'       => esc_html__( 'Remove from Print Feed', 'chicagosuntimes' ),
			'current_user_can_edit_print_feed'   => current_user_can( $this->edit_print_feed_cap ),
			'post_sticky_hidden_html'            => '<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky"' . checked( is_sticky( get_the_ID() ), true, false ) . '/>',
			'post_sticky_visible_html'           => '<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky" ' . checked( is_sticky( get_the_ID() ), true, false )  . ' /> <label for="sticky" class="selectit">' . esc_html__( "Stick this post to the front page", 'chicagosuntimes' ) . '</label><br /></span>',
			'post_is_sticky'                     => is_sticky( get_the_ID() ),
			) );

	}

	/**
	 * What to do in the admin head
	 */
	public function action_admin_head() {
		global $wp_meta_boxes;

		$screen = get_current_screen();
		if ( 'nav-menus' == $screen->id ) {
			$valid_meta_boxes = array(
				'add-page',
				'add-cst_liveblog',
				'add-custom-links',
				'add-cst_section',
				'add-cst_topic',
				'add-cst_location',
				'add-cst_person',
				);

			foreach( $wp_meta_boxes['nav-menus']['side']['core'] as $key => $data ) {
				if ( ! in_array( $key, $valid_meta_boxes ) ) {
					unset( $wp_meta_boxes['nav-menus']['side']['core'][ $key ] );
				}
			}

			foreach( $wp_meta_boxes['nav-menus']['side']['default'] as $key => $data ) {
				if ( ! in_array( $key, $valid_meta_boxes ) ) {
					unset( $wp_meta_boxes['nav-menus']['side']['default'][ $key ] );
				}
			}

			add_filter( 'hidden_meta_boxes', '__return_empty_array' );

		}

	}

	/**
	 * What we need to do when saving a post
	 */
	public function action_save_post_late( $post_id ) {

		$post_type = get_post_type( $post_id );
		switch( $post_type ) {

			case 'cst_embed':
				$embed = new \CST\Objects\Embed( $post_id );
				$embed->fetch_embed_data();
				break;

			case 'cst_video':

				$video = new \CST\Objects\Video( $post_id );
				if ( ! $video->get_featured_image_id() ) {
					$video->fetch_featured_image();
				}
				break;

		}

		if ( in_array( $post_type, CST()->get_post_types() ) ) {
			$obj = \CST\Objects\Post::get_by_post_id( $post_id );

			if ( ! $obj->get_sections() ) {
				wp_set_object_terms( $obj->get_id(), array( CST_DEFAULT_SECTION ), 'cst_section', true );
			}

		}

	}

	/**
	 * @param $new_status
	 * @param $old_status
	 * @param $post
	 *
	 * @return bool
	 *
	 * Upon content state transition trigger a post to the App API
	 */
	public function action_save_post_app_update( $new_status, $old_status, $post ) {

		if ( 'publish' === $new_status || 'new' === $new_status ) {
			$obj     = \CST\Objects\Post::get_by_post_id( $post->ID );
			if ( ! $obj ) {
				return false;
			}

			$story_url   = $obj->get_permalink();
			$slug        = basename( $obj->get_permalink() );
			$section     = $obj->get_primary_section()->slug;
			$app_api_url = 'http://cst.atapi.net/apicst_v2/_newstory.php';
			$payload_array = array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array(
					'token'   => 'suntimes',
					'message'   => $obj->get_title(),
					'slug'     => esc_attr( $slug ),
					'section' => esc_attr( $section ),
				),
				'cookies'     => array()
			);
			$response = wp_remote_post( $app_api_url, $payload_array );
			CST()->slack->notify_app( $response, $payload_array, $obj );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();

				return false;
			} else {
				return true;
			}

		} else {
			return false;
		}

	}

	/**
	 * Filter markup to include placeholders specific to this post
	 */
	public function filter_fm_element_markup_start( $out, $fm ) {

		$screen = get_current_screen();
		if ( 'post' !== $screen->base ) {
			return $out;
		}

		$post = \CST\Objects\Post::get_by_post_id( get_the_ID() );

		$fm_tree = $fm->get_form_tree();
		array_pop( $fm_tree );
		$parent = array_pop( $fm_tree );

		if ( $parent ) {

			if ( 'facebook' === $parent->name ) {
				$placeholders = array(
					'title'        => $post->get_default_facebook_open_graph_tag( 'title' ),
					'description'  => $post->get_default_facebook_open_graph_tag( 'description' ),
				);
			} else if ( 'twitter' === $parent->name ) {
				$placeholders = array(
					'title'        => $post->get_default_twitter_card_tag( 'title' ),
					'description'  => $post->get_default_twitter_card_tag( 'description' ),
				);
			} else if ( 'seo' === $parent->name ) {
				$placeholders = array(
					'title'        => $post->get_default_seo_title(),
					'description'  => $post->get_default_seo_description(),
					);
			}

			if ( isset( $placeholders[ $fm->name ] ) ) {
				$fm->attributes['placeholder'] = $placeholders[ $fm->name ];
			}

		}

		return $out;
	}

	/**
	 * Register the metaboxes used for Guest Authors Social settings
	 */
	function action_add_meta_boxes() {
		global $coauthors_plus;

		if ( get_post_type() == $coauthors_plus->guest_authors->post_type )
			add_meta_box( 'coauthors-manage-guest-author-social', __( 'Social', 'chicagosuntimes' ), array( $this, 'metabox_manage_guest_author_social' ), $coauthors_plus->guest_authors->post_type, 'normal', 'default' );
	}

	/**
	 * Metabox for saving or updating a Guest Author Social settings
	 */
	public function metabox_manage_guest_author_social() {
		global $post, $coauthors_plus;

		$fields = $coauthors_plus->guest_authors->get_guest_author_fields( 'social' );

		echo '<table class="form-table"><tbody>';

		foreach( $fields as $field ) {
			$pm_key 	= $coauthors_plus->guest_authors->get_post_meta_key( $field['key'] );
			$value 		= get_post_meta( $post->ID, $pm_key, true );
			$type 		= isset( $field['type'] ) ? $field['type'] : 'text';
			$disabled 	= isset( $field['disabled'] ) ? ( (bool) $field['disabled'] ) : false;

			echo '<tr><th>';
			echo '<label for="' . esc_attr( $pm_key ) . '">' . esc_html( $field['label'] ) . '</label>';
			echo '</th><td>';

			if ( 'checkbox' == $type ) {
				echo '<input type="checkbox" name="' . esc_attr( $pm_key ) . '" value="1" ' . checked( (bool) $value, true, false ) . ' ' . disabled( $disabled, true, false ) . ' />';
			} else {
				echo '<input type="text" name="' . esc_attr( $pm_key ) . '" value="' . esc_attr( $value ) . '" class="regular-text" ' . disabled( $disabled, true, false ) . ' />';
			}
			echo '</td></tr>';
		}

		echo '</tbody></table>';
	}

	/**
	 * Hook into Co Authors Plus's filter_coauthors_guest_author_fields to add new fields
	 * to the Guest Author (profile) edit page
	 *
	 * @param  array $fields_to_return The current Guest Author fields
	 * @param  array $groups           The field groups
	 * @return array                   The filtered array of fields
	 */
	public function filter_coauthors_guest_author_fields( $fields_to_return, $groups ) {

		if ( 'social' === $groups[0] || 'all' === $groups[0] ){

			$fields_to_return['twitter'] = array(
				'key'      			=> 'twitter',
				'label'    			=> esc_html__( 'Twitter Username', 'chicagosuntimes' ),
				'group'    			=> 'social',
			);

			$fields_to_return['instagram'] = array(
				'key'      			=> 'instagram',
				'label'    			=> esc_html__( 'Instagram Username', 'chicagosuntimes' ),
				'group'    			=> 'social'
			);

			$fields_to_return['tumblr_url'] = array(
				'key'      			=> 'tumblr_url',
				'label'    			=> esc_html__( 'Tumblr URL', 'chicagosuntimes' ),
				'group'    			=> 'social',
				'sanitize_function' => 'esc_url_raw'
			);
		}

		return apply_filters( 'coauthors_social_fields', $fields_to_return );
	}

	public function filter_custom_enter_title( $input ) {
		return 'Enter headline here';
	}

	public function filter_featured_image_instruction( $content ) {
		return $content .= '<p>' . esc_html__( 'This is the image that displays on the homepage, at the top of an article, and on social media. Required minimum image width 640px.', 'chicagosuntimes' ) . '</p>';
	}

	/**
	 * Add filter dropdown to Admin edit screens for Articles, Links, Embeds etc.
	 */
	function action_author_filter() {
		$args = array( 'name' => 'author', 'show_option_all' => 'View all authors' );
		if ( isset( $_GET['user'] ) ) {
			$args['selected'] = intval ( $_GET['user'] );
		}
		wp_dropdown_users( $args );
	}

	/**
	 * Add Fieldmanager fields to term screens - cst_section - to facilitate
	 * sponsorship images and urls over a date range.
	 */
	function section_sponsorship_fields() {

		$cst_section = new \Fieldmanager_Group( esc_html__( 'Section Sponsor', 'chicagosuntimes' ), array(
			'name'     => 'sponsor',
			'children' => array(
				'start_date'      => new \Fieldmanager_Datepicker( esc_html__( 'Start Date', 'chicagosuntimes' ), array(
					'description'      => esc_html__( 'Select start date of sponsorship', 'chicagosuntimes' ),
					'date_format'      => 'Y-m-d',
					'store_local_time' => true,
					'use_time'         => true,
					'js_opts'          => array(
						'dateFormat' => 'yy-mm-dd',
						'showButtonPanel' => true,
						'minDate' => 0
					),
				) ),
				'end_date'        => new \Fieldmanager_Datepicker( esc_html__( 'End Date', 'chicagosuntimes' ), array(
					'description'      => esc_html__( 'Select end date of sponsorship', 'chicagosuntimes' ),
					'date_format'      => 'Y-m-d',
					'store_local_time' => true,
					'use_time'         => true,
					'js_opts'          => array(
						'dateFormat' => 'yy-mm-dd',
						'showButtonPanel' => true,
						'minDate' => -1
					),
				) ),
				'sponsor_options' => new \Fieldmanager_Checkboxes( esc_html__( 'Coverage', 'chicagosuntimes' ), array(
					'options' => array(
						'everything' => 'Everything',
						'section' => 'Section',
						'article' => 'Article',
					),
					'default_value' => 'section'
				) ),
				'destination_url' => new \Fieldmanager_Link( esc_html__( 'Click thru / destination url', 'chicagosuntimes' ), array(
					'description' => esc_html__( 'Enter the click thru / destination url link', 'chicagosuntimes' ),
				) ),
				'image'           => new \Fieldmanager_Media( esc_html__( 'Section front sponsor Image', 'chicagosuntimes' ), array(
					'description'        => esc_html__( 'Display a sponsors image with link on the section front. Preferred image size is 320x50', 'chicagosuntimes' ),
					'button_label'       => esc_html__( 'Choose or upload and select a sponsors image', 'chicagosuntimes' ),
					'modal_button_label' => esc_html__( 'Select sponsor image', 'chicagosuntimes' ),
					'modal_title'        => esc_html__( 'Choose or upload and select a sponsors image', 'chicagosuntimes' ),
				) )
			),
		) );
		$cst_section->add_term_form( esc_html__( 'Sponsorship', 'chicagosuntimes' ), 'cst_section' );
	}

}