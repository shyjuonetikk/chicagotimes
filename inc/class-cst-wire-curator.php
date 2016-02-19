<?php

/**
 * Ingests items from a wire so they can be imported into WordPress in one-click
 */
class CST_Wire_Curator {

	private static $instance;

	private $post_type = 'cst_wire_item';

	private $cap = 'edit_others_posts';

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new CST_Wire_Curator;
			self::$instance->setup_actions();
			self::$instance->setup_filters();
		}
		return self::$instance;
	}

	/**
	 * Set up Curator actions
	 */
	private function setup_actions() {

		add_action( 'init', array( $this, 'action_init_register_post_type' ) );
		add_action( 'init', array( $this, 'action_init_register_fields' ) );

		add_action( 'init', function() {

			if ( ! wp_next_scheduled( 'cst_wire_items_import' ) ) {
				wp_schedule_event( time(), 'cst-wire-items-15', 'cst_wire_items_import' );
			}

			if ( ! wp_next_scheduled( 'cst_wire_items_purge' ) ) {
				wp_schedule_event( time(), 'cst-wire-items-hourly', 'cst_wire_items_purge' );
			}

		});

		add_action( 'cst_wire_items_import', array( $this, 'refresh_wire_items' ) );
		add_action( 'cst_wire_items_purge', array( $this, 'purge_wire_items' ) );

		add_action( 'load-edit.php', array( $this, 'action_load_edit' ) );

		add_action( 'wp_ajax_cst_refresh_wire_items', array( $this, 'handle_ajax_refresh_wire_items' ) );
		add_action( 'wp_ajax_cst_create_from_wire_item', array( $this, 'handle_ajax_create_from_wire_item' ) );

		add_action( "manage_{$this->post_type}_posts_custom_column", array( $this, 'action_manage_posts_custom_column' ), 10, 2 );

	}

	/**
	 * Set up Curator filters
	 */
	private function setup_filters() {

		add_filter( "manage_{$this->post_type}_posts_columns", array( $this, 'filter_post_columns' ) );

		add_filter( 'cron_schedules', array( $this, 'filter_cron_schedules' ) );

		add_filter( 'fm_element_markup_start', array( $this, 'filter_fm_link_markup' ), 10, 2 );

	}

	/**
	 * Register the Wire Item post type
	 */
	public function action_init_register_post_type() {

		register_post_type( $this->post_type, array(
			'hierarchical'      => false,
			'public'            => false,
			'show_in_nav_menus' => true,
			'show_in_admin_bar' => false,
			'show_ui'           => true,
			'menu_icon'         => 'dashicons-welcome-view-site',
			'supports'          => array( 'title', 'editor' ),
			'has_archive'       => false,
			'query_var'         => true,
			'rewrite'           => false,
			'capabilities'      => array(
				'create_posts'  => 'do_not_allow',
				'edit_posts'    => $this->cap,
				),
			'labels'            => array(
				'name'                => esc_html__( 'Wire Items', 'chicagosuntimes' ),
				'singular_name'       => esc_html__( 'Wire Items', 'chicagosuntimes' ),
				'all_items'           => esc_html__( 'Wire Items', 'chicagosuntimes' ),
				'new_item'            => esc_html__( 'New Wire Items', 'chicagosuntimes' ),
				'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
				'add_new_item'        => esc_html__( 'Add New Wire Items', 'chicagosuntimes' ),
				'edit_item'           => esc_html__( 'Edit Wire Items', 'chicagosuntimes' ),
				'view_item'           => esc_html__( 'View Wire Items', 'chicagosuntimes' ),
				'search_items'        => esc_html__( 'Search Wire Items', 'chicagosuntimes' ),
				'not_found'           => esc_html__( 'No Wire Items found', 'chicagosuntimes' ),
				'not_found_in_trash'  => esc_html__( 'No Wire Items found in trash', 'chicagosuntimes' ),
				'parent_item_colon'   => esc_html__( 'Parent Wire Items', 'chicagosuntimes' ),
				'menu_name'           => esc_html__( 'AP Wire', 'chicagosuntimes' ),
			),
		) );

	}

	/**
	 * Register Fieldmanager fields
	 */
	public function action_init_register_fields() {

		$fm = new Fieldmanager_Link( array(
			'name'            => 'wire_curator_feed_url',
			'label'           => false,
			'limit'           => 0,
			'add_more_label'  => esc_attr__( 'Import Another Feed', 'chicagosuntimes' ),
			'attributes' => array(
				'placeholder'     => esc_attr__( 'Enter WebFeed URL for AP Content Explorer saved search', 'chicagosuntimes' ),
				'size'            => 100
				)
			) );

		$fm->add_submenu_page( 'edit.php?post_type=' . $this->post_type, esc_html__( 'Wire Curator Settings', 'chicagosuntimes' ), esc_html__( 'Settings', 'chicagosuntimes' ), $this->cap );

	}

	/**
	 * Only do these things on the Wire Items edit screen
	 */
	public function action_load_edit() {

		$screen = get_current_screen();
		if ( ! empty( $screen->post_type ) && 'cst_wire_item' === $screen->post_type ) {

			$feeds = $this->get_feeds();
			if ( empty( $feeds ) ) {
				add_action( 'admin_notices', array( $this, 'action_admin_notices_feed_warning' ) );
			}

			add_action( 'restrict_manage_posts', array( $this, 'action_restrict_manage_posts_refresh_button' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts' ) );
			add_filter( 'bulk_actions-' . $screen->id, '__return_empty_array' );
			add_filter( 'views_' . $screen->id, '__return_empty_array' );
			add_filter( 'months_dropdown_results', '__return_empty_array' );

			add_action( 'admin_footer', array( $this, 'action_admin_footer' ) );

		}

	}

	/**
	 * Show a warning if there isn't a feed set yet
	 */
	public function action_admin_notices_feed_warning() {
		echo '<div class="message error"><p>' . sprintf( __( 'No import feed specified. Please <a href="%s">add a feed to import</a>.', 'chicagosuntimes' ), admin_url( 'edit.php?post_type=' . $this->post_type . '&page=wire_curator_feed_url' ) ) . '</p></div>';
	}

	/**
	 * Add some descriptive text to the settings page
	 */
	public function filter_fm_link_markup( $out, $fm ) {

		if ( 'wire_curator_feed_url' !== $fm->name ) {
			return $out;
		}

		$out .= '<p>' . sprintf( __( 'Wire Curator accepts WebFeeds from AP Exchange Save Searches. You can <a target="_blank" href="%s">log in</a> with these credentials: %s / %s', 'chicagosuntimes' ), 'http://www.apexchange.com/pages/ManageFeatures.aspx?s=0', CST_AP_SYNDICATION_USERNAME, CST_AP_SYNDICATION_PASSWORD ) . '</p>';

		return $out;
	}

	/**
	 * Button to refresh wire items
	 */
	public function action_restrict_manage_posts_refresh_button() {

		$feeds = $this->get_feeds();
		if ( empty( $feeds ) ) {
			return;
		}

		submit_button( esc_attr__( 'Refresh Items', 'chicagosuntimes' ), 'button', false, false, array( 'id' => 'cst-refresh-wire-items', 'data-nonce' => wp_create_nonce( 'cst_refresh_wire_items' ), 'data-in-progress-text' => esc_attr__( 'Refreshing...', 'chicagosuntimes' ) ) );
		$last_refresh = $this->get_last_refresh();
		if ( $last_refresh ) {
			$last_refresh = human_time_diff( $last_refresh );
		} else {
			$last_refresh = 'Never';
		}

		$events = _get_cron_array();
		$next_refresh = false;
		foreach( $events as $time => $event ) {

			if ( isset( $event['cst_wire_items_import'] ) ) {
				$next_refresh = ( $time - time() ) / 60;
				break;
			}

		}
		echo '<span id="cst-last-refresh">' . sprintf( esc_html__( 'Last refresh %s ago, next in %d mins', 'chicagosuntimes' ), $last_refresh, $next_refresh ) . '</span>';
	}

	/**
	 * Scripts and styles for the Wire Curator
	 */
	public function action_admin_enqueue_scripts() {

		wp_enqueue_style( 'cst-wire-curator', get_template_directory_uri() . '/assets/css/wire-curator.css' );
		wp_enqueue_script( 'cst-wire-curator', get_template_directory_uri() . '/assets/js/wire-curator.js' );

	}

	/**
	 * Filter the columns on the Wire Items table
	 */
	public function filter_post_columns( $columns ) {

		$new_columns = array(
			'cst_wire_item_title'    => esc_html__( 'Title', 'chicagosuntimes' ),
			'cst_wire_item_content'  => esc_html__( 'Summary', 'chicagosuntimes' ),
			'cst_wire_item_date'     => esc_html__( 'Published', 'chicagosuntimes' ),
			);

		return $new_columns;
	}

	/**
	 * Add the correct value for our custom columns
	 */
	public function action_manage_posts_custom_column( $column_name, $post_id ) {

		$item = new \CST\Objects\AP_Wire_Item( $post_id );

		switch ( $column_name ) {

			case 'cst_wire_item_title':
				echo '<strong>' . esc_html( $item->get_title() ) . '</strong>';
				echo $this->post_row_actions( $item );
				break;

			case 'cst_wire_item_content':
				echo $item->get_content();
				echo '<div class="cst-preview-data">';
				echo '<div class="preview-headline">' . esc_html( $item->get_wire_headline() ) . '</div>';
				echo '<div class="preview-content">' . wp_kses_post( $item->get_wire_content() ) . '</div>';
				echo '</div>';
				break;

			case 'cst_wire_item_date':
				$published = human_time_diff( $item->get_post_date_gmt() );
				echo sprintf( esc_html__( '%s ago', 'chicagosuntimes' ), $published );
				$updated = human_time_diff( $item->get_post_modified_gmt() );
				if ( $updated != $published ) {
					echo '<br /><em>' . sprintf( esc_html__( 'Updated %s ago', 'chicagosuntimes' ), $updated ) . '</em>';
				}
				break;

			default:
				break;

		}

	}

	/**
	 * Filter the actions available to each wire item
	 */
	private function post_row_actions( $item, $always_visible = false ) {

		$actions = array(
			'wire-item-preview'    => '<a title="' . esc_attr__( 'Preview wire item full text', 'chicagosuntimes' ) . '" class="wire-item-preview" href="#">' . esc_html__( 'Preview', 'chicagosuntimes' ) . '</a>',
			);

		$create_args = array(
			'action'        => 'cst_create_from_wire_item',
			'nonce'         => wp_create_nonce( 'cst_create_from_wire_item' ),
			'wire_item_id'  => $item->get_id(),
			);
		$create_url = add_query_arg( $create_args, admin_url( 'admin-ajax.php' ) );

		if ( $item->get_wire_content() ) {

			if ( $article = $item->get_article_post() ) {
				$actions['wire-item-article'] = '<a title="' . esc_attr__( 'Edit article', 'chicagosuntimes' ) . '" href="' . get_edit_post_link( $article->get_id() ) . '">' . esc_html__( 'Edit Article', 'chicagosuntimes' ). '</a>';
			} else {
				$actions['wire-item-article'] = '<a title="' . esc_attr__( 'Create an article for the wire item', 'chicagosuntimes' ) . '" href="' . esc_url( add_query_arg( 'create', 'article', $create_url ) ) . '">' . esc_html__( 'Create Article', 'chicagosuntimes' ) . '</a>';
			}

		}

		if ( $item->get_external_url() ) {

			if ( $link = $item->get_link_post() ) {
				$actions['wire-item-link'] = '<a title="' . esc_attr__( 'Edit link post', 'chicagosuntimes' ) . '" href="' . get_edit_post_link( $link->get_id() ) . '">' . esc_html__( 'Edit Link', 'chicagosuntimes' ). '</a>';
			} else {
				$actions['wire-item-link'] = '<a title="' . esc_attr__( 'Create a link post to the external URL for the wire item', 'chicagosuntimes' ) . '" href="' . esc_url( add_query_arg( 'create', 'link', $create_url ) ) . '">' . esc_html__( 'Create Link', 'chicagosuntimes' ) . '</a>';
			}

		}

		$action_count = count( $actions );
		$i = 0;

		if ( !$action_count ) {
			return '';
		}

		$out = '<div class="' . ( $always_visible ? 'row-actions visible' : 'row-actions' ) . '">';
		foreach ( $actions as $action => $link ) {
			++$i;
			( $i == $action_count ) ? $sep = '' : $sep = ' | ';
			$out .= "<span class='$action'>$link$sep</span>";
		}
		$out .= '</div>';

		return $out;
	}

	/**
	 * Filter cron schedules to include our own
	 */
	public function filter_cron_schedules( $schedules ) {

		$schedules['cst-wire-items-15'] = array(
			'interval' => MINUTE_IN_SECONDS * 15,
			'display'  => 'Every 15 minutes'
		);

		$schedules['cst-wire-items-hourly'] = array(
			'interval' => HOUR_IN_SECONDS,
			'display'  => 'Every hour'
		);

		return $schedules;
	}

	/**
	 * Get the feeds we're pulling data from
	 *
	 * @return array
	 */
	public function get_feeds() {
		return get_option( 'wire_curator_feed_url', array() );
	}

	/**
	 * Get the last time the feeds were refreshed
	 *
	 * @return int
	 */
	public function get_last_refresh() {
		return (int)get_option( 'wire_curator_last_refresh', 0 );
	}

	/**
	 * Set the last time the feeds were refreshed
	 *
	 * @param int $time
	 */
	public function set_last_refresh( $time ) {
		update_option( 'wire_curator_last_refresh', (int) $time );
	}

	/**
	 * Handle ajax request to refresh wire items
	 */
	public function handle_ajax_refresh_wire_items() {

		wp_verify_nonce( $_GET['nonce'], 'cst_refresh_wire_items' );

		if ( ! current_user_can( $this->cap ) ) {
			wp_die( esc_html__( "You shouldn't be doing this...", 'chicagosuntimes' ) );
		}

		$this->refresh_wire_items();

		echo 'Done';
		exit;
	}

	/**
	 * Create a new Article or Link from a wire item
	 */
	public function handle_ajax_create_from_wire_item() {

		wp_verify_nonce( $_GET['nonce'], 'cst_create_from_wire_item' );

		if ( ! current_user_can( $this->cap ) ) {
			wp_die( esc_html__( "You shouldn't be doing this...", 'chicagosuntimes' ) );
		}

		$item_id = (int)$_GET['wire_item_id'];

		$post = get_post( $item_id );
		if ( ! $post || $this->post_type !== $post->post_type ) {
			wp_die( esc_html__( 'Invalid wire item ID', 'chicagosuntimes' ) );
		}

		$item = new \CST\Objects\AP_Wire_Item( $post );

		switch ( $_GET['create'] ) {

			case 'link':

				$link = $item->create_link_post();
				if ( $link ) {
					wp_safe_redirect( $link->get_edit_link() );
					exit;
				} else {
					wp_die( esc_html__( 'Error creating link?', 'chicagosuntimes' ) );
				}

				break;

			case 'article':

				$article = $item->create_article_post();
				if ( $article ) {
					wp_safe_redirect( $article->get_edit_link() );
					exit;
				} else {
					wp_die( esc_html__( 'Error creating article?', 'chicagosuntimes' ) );
				}

				break;

			default:
				wp_die( esc_html__( 'Invalid type to create', 'chicagosuntimes' ) );
				break;
		}

	}

	/**
	 * Anything needing to be done in the footer
	 */
	public function action_admin_footer() {

		get_template_part( 'parts/admin/wire-curator-preview' );

	}

	/**
	 * Refresh Wire Items from the feeds
	 */
	public function refresh_wire_items() {

		foreach( $this->get_feeds() as $feed ) {

			// Failsafe
			if ( empty( $feed ) ) {
				continue;
			}

			$args = array();

			// Associated Press requires HTTP Basic Auth
			if ( 'syndication.ap.org' === parse_url( $feed, PHP_URL_HOST ) ) {
				$args['headers'] = array(
						'Authorization' => 'Basic ' . base64_encode( CST_AP_SYNDICATION_USERNAME . ':' . CST_AP_SYNDICATION_PASSWORD )
					);
			}

			$response = vip_safe_wp_remote_get( $feed, '', 3, 3, 20, $args );

			if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
				continue;
			}

			$feed_data = wp_remote_retrieve_body( $response );
			$xml = simplexml_load_string( $feed_data );
			foreach( $xml->entry as $entry ) {

				// Only handle articles right now
				$is_article = false;
				foreach( $entry->link as $link ) {
					if ( 'enclosure' === (string)$link['rel'] && 'AP Article' === (string)$link['title'] ) {
						$is_article = true;
						break;
					}
				}

				if ( ! $is_article ) {
					continue;
				}

				// See if this was already imported, otherwise create
				if ( \CST\Objects\AP_Wire_Item::get_by_original_id( sanitize_text_field( $entry->id ) ) ) {
					continue;
				}

				\CST\Objects\AP_Wire_Item::create_from_simplexml( $entry );

			}

			$this->set_last_refresh( time() );

		}

	}

	/**
	 * Purge old wire items
	 */
	public function purge_wire_items() {

		$query_args = array(
			'post_type'      => $this->post_type,
			'post_status'    => 'any',
			'posts_per_page' => 200,
			'fields'         => 'ids',
			'date_query'     => array(
				'before'     => date( 'Y-m-d H:i:s', time() - ( DAY_IN_SECONDS * 3 ) ),
				'column'     => 'post_date_gmt',
				),
			);
		$old_items = new WP_Query( $query_args );

		foreach( $old_items->posts as $post_id ) {
			wp_delete_post( $post_id, true );
		}

	}

}