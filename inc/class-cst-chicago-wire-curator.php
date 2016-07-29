<?php

/**
 * Ingests items from a wire so they can be imported into WordPress in one-click
 */
class CST_Chicago_Wire_Curator {

    private static $instance;

    private $post_type = 'cst_chicago_item';

    private $cap = 'edit_others_posts';

    public static function get_instance() {

        if ( ! isset( self::$instance ) ) {
            self::$instance = new CST_Chicago_Wire_Curator;
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

            if ( ! wp_next_scheduled( 'cst_chicago_wire_items_import' ) ) {
                wp_schedule_event( time(), 'cst-chicago-wire-items-15', 'cst_chicago_wire_items_import' );
            }

        });

        add_action( 'cst_chicago_wire_items_import', array( $this, 'refresh_chicago_wire_items' ) );
        add_action( 'cst_chicago_wire_items_purge', array( $this, 'purge_chicago_wire_items' ) );

        add_action( 'load-edit.php', array( $this, 'action_load_edit' ) );

        add_action( 'wp_ajax_cst_refresh_chicago_wire_items', array( $this, 'handle_ajax_refresh_chicago_wire_items' ) );
        add_action( 'wp_ajax_cst_create_from_chicago_wire_item', array( $this, 'handle_ajax_create_from_chicago_wire_item' ) );
        add_action( 'wp_ajax_cst_delete_chicago_wire_items', array( $this, 'handle_ajax_delete_chicago_wire_items' ) );
        add_action( 'wp_ajax_cst_reset_chicago_items_timer', array( $this, 'handle_ajax_reset_chicago_items_timer' ) );

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
                'name'                => esc_html__( 'ChicagoDot Wire Items', 'chicagosuntimes' ),
                'singular_name'       => esc_html__( 'ChicagoDot Wire Items', 'chicagosuntimes' ),
                'all_items'           => esc_html__( 'ChicagoDot Wire Items', 'chicagosuntimes' ),
                'new_item'            => esc_html__( 'New ChicagoDot Wire Items', 'chicagosuntimes' ),
                'add_new'             => esc_html__( 'Add New', 'chicagosuntimes' ),
                'add_new_item'        => esc_html__( 'Add New ChicagoDot Wire Items', 'chicagosuntimes' ),
                'edit_item'           => esc_html__( 'Edit ChicagoDot Wire Items', 'chicagosuntimes' ),
                'view_item'           => esc_html__( 'View ChicagoDot Wire Items', 'chicagosuntimes' ),
                'search_items'        => esc_html__( 'Search ChicagoDot Wire Items', 'chicagosuntimes' ),
                'not_found'           => esc_html__( 'No ChicagoDot Wire Items found', 'chicagosuntimes' ),
                'not_found_in_trash'  => esc_html__( 'No ChicagoDot Wire Items found in trash', 'chicagosuntimes' ),
                'parent_item_colon'   => esc_html__( 'Parent ChicagoDot Wire Items', 'chicagosuntimes' ),
                'menu_name'           => esc_html__( 'ChicagoDot Wire', 'chicagosuntimes' ),
            ),
        ) );

    }

    /**
     * Register Fieldmanager fields
     */

    public function action_init_register_fields() {

        $fm = new Fieldmanager_Link( array(
            'name'            => 'chicago_wire_curator_feed_url',
            'label'           => false,
            'limit'           => 0,
            'add_more_label'  => esc_attr__( 'Import Another Feed', 'chicagosuntimes' ),
            'attributes' => array(
                'placeholder'     => esc_attr__( 'Enter JSON Feed URL for ChicagoDot Wire Items', 'chicagosuntimes' ),
                'size'            => 100
                )
            ) );

        $fm->add_submenu_page( 'edit.php?post_type=' . $this->post_type, esc_html__( 'ChicagoDot Wire Curator Feed Settings', 'chicagosuntimes' ), esc_html__( 'Feed Settings', 'chicagosuntimes' ), $this->cap );

        $fm = new Fieldmanager_Textfield( array(
            'name'            => 'chicago_wire_curator_author',
            'label'                => __( 'Author Username', 'chicagosuntimes' ),
            'attributes' => array(
                'placeholder'     => esc_attr__( 'Enter Author Username', 'chicagosuntimes' ),
                'size'            => 50
                )
            ) );

        $fm->add_submenu_page( 'edit.php?post_type=' . $this->post_type, esc_html__( 'ChicagoDot Wire Curator Author Settings', 'chicagosuntimes' ), esc_html__( 'Author Settings', 'chicagosuntimes' ), $this->cap );

    }


    /**
     * Only do these things on the ChicagoDot Wire Items edit screen
     */
    public function action_load_edit() {

        $screen = get_current_screen();
        if ( ! empty( $screen->post_type ) && 'cst_chicago_item' === $screen->post_type ) {

            $feeds = $this->get_feeds();
            if ( empty( $feeds ) ) {
                add_action( 'admin_notices', array( $this, 'action_admin_notices_feed_warning' ) );
            }

            $author = $this->get_author();
            if ( empty( $author ) ) {
                add_action( 'admin_notices', array( $this, 'action_admin_notices_author_warning' ) );
            } else {
                $validate_author = $this->validate_author( $author );
                if ( $validate_author == false ) {
                    add_action( 'admin_notices', array( $this, 'action_admin_notices_validate_author_warning' ) );
                }
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
        $admin_url = rawurlencode( 'edit.php?post_type=' . $this->post_type . '&page=chicago_wire_curator_feed_url' );
        echo '<div class="message error"><p>' . sprintf( esc_html__( 'No import feed specified. Please <a href=' . esc_url( "%s" ) . '>add a feed to import</a>.', 'chicagosuntimes' ), admin_url( esc_url( $admin_url ) ) ) . '</p></div>';
    }

    /**
     * Show a warning if there isn't an author username set yet
     */
    public function action_admin_notices_author_warning() {
        $admin_url = rawurlencode( 'edit.php?post_type=' . $this->post_type . '&page=chicago_wire_curator_author' );
        echo '<div class="message error"><p>' . sprintf( esc_html__( 'No author username specified. Please <a href=' . esc_url( "%s" ) . '>add an author</a>.', 'chicagosuntimes' ), admin_url( esc_url( $admin_url ) ) ) . '</p></div>';
    }

    /**
     * Show a warning if there isn't a valid author username set yet
     */
    public function action_admin_notices_validate_author_warning() {
        $admin_url = rawurlencode( 'edit.php?post_type=' . $this->post_type . '&page=chicago_wire_curator_author' );
        echo '<div class="message error"><p>' . sprintf( esc_html__( 'The author username set is not valid. Please <a href=' . esc_url( "%s" ) . '>set a valid author username</a>.', 'chicagosuntimes' ), admin_url( esc_url( $admin_url ) ) ) . '</p></div>';
    }

    /**
     * Add some descriptive text to the settings page
     */
    public function filter_fm_link_markup( $out, $fm ) {

        if ( 'chicago_wire_curator_feed_url' !== $fm->name ) {
            return $out;
        }

        $out .= '<p>ChicagoDot Curator accepts feed URLs in a JSON format</p>';

        return $out;
    }

    /**
     * Button to refresh ChicagoDot wire items
     */
    public function action_restrict_manage_posts_refresh_button() {

        $feeds = $this->get_feeds();
        $author = $this->get_author();
        if ( empty( $feeds ) || empty( $author ) ) {
            return;
        } elseif( isset( $author ) ) {
            $validate_author = $this->validate_author( $author );
            if( $validate_author == false ) {
                return;
            }
        }

        submit_button( esc_attr__( 'Refresh Items', 'chicagosuntimes' ), 'button', false, false, array( 'id' => 'cst-refresh-chicago-wire-items', 'data-nonce' => wp_create_nonce( 'cst_refresh_chicago_wire_items' ), 'data-in-progress-text' => esc_attr__( 'Refreshing...', 'chicagosuntimes' ) ) );
        submit_button( esc_attr__( 'Delete Last 50 Items', 'chicagosuntimes' ), 'button', false, false, array( 'id' => 'cst-delete-chicago-wire-items', 'data-nonce' => wp_create_nonce( 'cst_delete_chicago_wire_items' ), 'data-in-progress-text' => esc_attr__( 'Deleting...', 'chicagosuntimes' ) ) );
        submit_button( esc_attr__( 'Reset Timer', 'chicagosuntimes' ), 'button', false, false, array( 'id' => 'cst-reset-chicago-items-timer', 'data-nonce' => wp_create_nonce( 'cst_reset_chicago_items_timer' ), 'data-in-progress-text' => esc_attr__( 'Resetting...', 'chicagosuntimes' ) ) );
        $last_refresh = (int)$this->get_last_refresh();
        if ( $last_refresh ) {
            $last_refresh = human_time_diff( $last_refresh );
        } else {
            $last_refresh = 'Never';
        }

        $events = _get_cron_array();
        $next_refresh = false;
        foreach( $events as $time => $event ) {

            if ( isset( $event['cst_chicago_wire_items_import'] ) ) {
                $next_refresh = (int)( $time - time() ) / 60;
                break;
            }

        }
        echo '<span id="cst-last-refresh">' . sprintf( esc_html__( 'Last refresh %s ago, next in %d mins', 'chicagosuntimes' ), $last_refresh, $next_refresh ) . '</span>';
    }

    /**
     * Scripts and styles for the Wire Curator
     */
    public function action_admin_enqueue_scripts() {

        wp_enqueue_style( 'cst-chicago-wire-curator', get_stylesheet_directory_uri() . '/assets/css/chicago-wire-curator.css' );
        wp_enqueue_script( 'cst-chicago-wire-curator', get_stylesheet_directory_uri() . '/assets/js/chicago-wire-curator.js' );

    }

    /**
     * Filter the columns on the ChicagoDot Wire Items table
     */
    public function filter_post_columns( $columns ) {

        $new_columns = array(
            'cst_chicago_wire_item_title'    => esc_html__( 'Title', 'chicagosuntimes' ),
            'cst_chicago_wire_item_content'  => esc_html__( 'Story Brief', 'chicagosuntimes' ),
            'cst_chicago_wire_item_orig_post_id'  => esc_html__( 'Orig Post ID', 'chicagosuntimes' ),
            'cst_chicago_wire_item_date'     => esc_html__( 'Published', 'chicagosuntimes' ),
            );

        return $new_columns;
    }

    /**
     * Add the correct value for our custom columns
     */
    public function action_manage_posts_custom_column( $column_name, $post_id ) {

        require_once 'objects/class-chicago-wire-item.php';
        $item = new \CST\Objects\chicago_Wire_Item( $post_id );

        switch ( $column_name ) {

            case 'cst_chicago_wire_item_title':
                echo '<strong>' . esc_html( $item->get_title() ) . '</strong>';
                echo $this->post_row_actions( $item );
                break;

            case 'cst_chicago_wire_item_content':
                echo wp_kses_post( substr( $item->get_wire_promo_brief(), 0, 450 ) );
                echo '<div class="cst-preview-data">';
                echo '<div class="preview-headline">' . esc_html( $item->get_wire_headline() ) . '</div>';
                echo '<div class="preview-content">' . wp_kses_post( $item->get_wire_content() ) . '</div>';
                echo '</div>';
                break;

            case 'cst_chicago_wire_item_orig_post_id':
                echo '<strong>' . esc_html( $item->get_original_post_id() ) . '</strong>';
                break;

            case 'cst_chicago_wire_item_date':
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
            'chicago-wire-item-preview'    => '<a title="' . esc_attr__( 'Preview wire item full text', 'chicagosuntimes' ) . '" class="chicago-wire-item-preview" href=' . esc_url( "#" ) . '>' . esc_html__( 'Preview', 'chicagosuntimes' ) . '</a>',
            );

        $create_args = array(
            'action'        => 'cst_create_from_chicago_wire_item',
            'nonce'         => wp_create_nonce( 'cst_create_from_chicago_wire_item' ),
            'chicago_wire_item_id'  => $item->get_id(),
            );
        $admin_url = rawurlencode( 'admin-ajax.php' );
        $create_url = add_query_arg( $create_args, admin_url( esc_url( $admin_url ) ) );

        if ( $item->get_wire_content() ) {

            if ( $article = $item->get_article_post() ) {
                $actions['chicago-wire-item-article'] = '<a title="' . esc_attr__( 'Edit article', 'chicagosuntimes' ) . '" href="' . esc_url( get_edit_post_link( $article->get_id() ) ) . '">' . esc_html__( 'Edit Article', 'chicagosuntimes' ). '</a>';
            } else {
                $actions['chicago-wire-item-article'] = '<a title="' . esc_attr__( 'Create an article for the ChicagoDot wire item', 'chicagosuntimes' ) . '" href="' . esc_url( add_query_arg( 'create', 'article', $create_url ) ) . '">' . esc_html__( 'Create Article', 'chicagosuntimes' ) . '</a>';
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
            $out .= "<span class='" . wp_kses_post( $action ) . "'>" . wp_kses_post( $link ) . "" . wp_kses_post( $sep ) . "</span>";
        }
        $out .= '</div>';

        return $out;
    }

    /**
     * Filter cron schedules to include our own
     */
    public function filter_cron_schedules( $schedules ) {

        $schedules['cst-chicago-wire-items-15'] = array(
            'interval' => MINUTE_IN_SECONDS * 15,
            'display'  => 'Every 15 minutes'
        );

        return $schedules;
    }

    /**
     * Get the feeds we're pulling data from
     *
     * @return array
     */
    public function get_feeds() {
        return get_option( 'chicago_wire_curator_feed_url', array() );
    }

    /**
     * Get the author username ChicagoDot wire item's are assigned to
     *
     * @return array
     */
    public function get_author() {
        return get_option( 'chicago_wire_curator_author', array() );
    }

    /**
     * Validate the author username Chicago wire item's are assigned to
     *
     * @return array
     */
    public function validate_author($author_username) {

        $blog_id = get_current_blog_id();
        $current_user_id = get_current_user_id();
        if( ! is_user_member_of_blog( $current_user_id, $blog_id ) ) {
            wp_die( esc_html__( "You do not belong here...", 'chicagosuntimes' ) );
        }

        if ( ! current_user_can( $this->cap ) ) {
            wp_die( esc_html__( "You shouldn't be doing this...", 'chicagosuntimes' ) );
        }

        $author_username = get_option( 'chicago_wire_curator_author', array() );
        $chicago_author_lookup    = get_user_by( 'login', $author_username );
        if( is_object( $chicago_author_lookup ) ) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * Get the last time the feeds were refreshed
     *
     * @return int
     */
    public function get_last_refresh() {
        return (int)get_option( 'chicago_wire_curator_last_refresh', 0 );
    }

    /**
     * Set the last time the feeds were refreshed
     *
     * @param int $time
     */
    public function set_last_refresh( $time ) {
        update_option( 'chicago_wire_curator_last_refresh', (int) $time );
    }

    /**
     * Handle ajax request to refresh ChicagoDot wire items
     */
    public function handle_ajax_refresh_chicago_wire_items() {

        wp_verify_nonce( $_GET['nonce'], 'cst_refresh_chicago_wire_items' );

        if ( ! current_user_can( $this->cap ) ) {
            wp_die( esc_html__( "You shouldn't be doing this...", 'chicagosuntimes' ) );
        }

        $this->refresh_chicago_wire_items();

        echo 'Done';
        exit;
    }

    /**
     * Handle ajax request to delete all ChicagoDot wire items
     */
    public function handle_ajax_delete_chicago_wire_items() {

        wp_verify_nonce( $_GET['nonce'], 'cst_delete_chicago_wire_items' );

        if ( ! current_user_can( $this->cap ) ) {
            wp_die( esc_html__( "You shouldn't be doing this...", 'chicagosuntimes' ) );
        }

        $this->purge_chicago_wire_items();

        echo 'Done';
        exit;
    }

    /**
     * Handle ajax request to reset ChicagoDot wire items cron job timer
     */
    public function handle_ajax_reset_chicago_items_timer() {

        wp_verify_nonce( $_GET['nonce'], 'cst_reset_chicago_items_timer' );

        if ( ! current_user_can( $this->cap ) ) {
            wp_die( esc_html__( "You shouldn't be doing this...", 'chicagosuntimes' ) );
        }

        $this->reset_chicago_items_timer();

        echo 'Done';
        exit;
    }

    /**
     * Create a new Article or Link from a wire item
     */
    public function handle_ajax_create_from_chicago_wire_item() {

        wp_verify_nonce( $_GET['nonce'], 'cst_create_from_chicago_wire_item' );

        if ( ! current_user_can( $this->cap ) ) {
            wp_die( esc_html__( "You shouldn't be doing this...", 'chicagosuntimes' ) );
        }

        $item_id = (int)$_GET['chicago_wire_item_id'];

        $post = get_post( $item_id );
        if ( ! $post || $this->post_type !== $post->post_type ) {
            wp_die( esc_html__( 'Invalid ChicagoDot wire item ID', 'chicagosuntimes' ) );
        }
        require_once 'objects/class-chicago-wire-item.php';
        $item = new \CST\Objects\chicago_Wire_Item( $post );

        switch ( $_GET['create'] ) {

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

        get_template_part( 'parts/admin/chicago-wire-curator-preview' );

    }

    /**
     * Refresh ChicagoDot Wire Items from the feeds
     */
    public function refresh_chicago_wire_items() {

        foreach( $this->get_feeds() as $feed ) {
            
            // Failsafe
            if ( empty( $feed ) ) {
                continue;
            }

            $response = vip_safe_wp_remote_get( $feed, '', 1, 3 );

            if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
                continue;
            }

            $feed_data = wp_remote_retrieve_body( $response );
            $xml = simplexml_load_string( $feed_data );
            
            if( $xml ) {
                require_once 'objects/class-chicago-wire-item.php';
                foreach( $xml->channel->item as $entry ) {

                    // Only 'text' type items will be processed
                    if( $entry->title != '' ) {

                        $orig_post_id = filter_var( $entry->guid, FILTER_SANITIZE_NUMBER_INT );

                        // See if this was already imported, otherwise create
                        if ( \CST\Objects\Chicago_Wire_Item::get_by_original_id( sanitize_text_field( $orig_post_id ) ) ) {
                            continue;
                        }

                        $blog_id = get_current_blog_id();
                        $current_user_id = get_current_user_id();
                        if( ! is_user_member_of_blog( $current_user_id, $blog_id ) ) {
                            wp_die( esc_html__( "You do not belong here...", 'chicagosuntimes' ) );
                        }
                        
                        \CST\Objects\Chicago_Wire_Item::create_from_simplexml( $entry );

                    }

                }

                $this->set_last_refresh( time() );
            } else {
                echo 'fail to load xml';
            }

        }

    }

    /**
     * Reset obit wire items cron job schedule
     */
    public function reset_chicago_items_timer() {

        wp_clear_scheduled_hook( 'cst_chicago_wire_items_import' );

        $this->set_last_refresh( time() );

    }

    /**
     * Purge old ChicagoDot wire items
     */
    public function purge_chicago_wire_items() {

        $query_args = array(
            'post_type'      => $this->post_type,
            'post_status'    => 'any',
            'fields'         => 'ids',
            'posts_per_page' => 50,
            );
        $old_items = new WP_Query( $query_args );

        foreach( $old_items->posts as $post_id ) {
            wp_delete_post( $post_id, true );
        }

    }

}