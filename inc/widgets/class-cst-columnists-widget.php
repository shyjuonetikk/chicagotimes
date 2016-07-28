<?php

class CST_Columnists_Content_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'CST_Columnists_Content_Widget',
            esc_html__( 'CST Columnists Content', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Set columnists Content displayed in the sidebar.', 'chicagosuntimes' ),
            ),
	        array( 'width' => '400' )
        );

        add_action( 'wp_ajax_cst_columnists_content_get_posts', array( $this, 'cst_columnists_content_get_posts' ) );
        
    }

    /**
    * Get all published posts to display in Select2 dropdown
    */
    public function cst_columnists_content_get_posts() {

        if ( ! wp_verify_nonce( $_GET['nonce'], 'cst-columnists-content-widget' )
            || ! current_user_can( 'edit_others_posts' ) ) {
            wp_send_json_error();
        }

        $term = sanitize_text_field( $_GET['searchTerm'] );

        $search_args = array(
                                'post_type' => 'cst_article',
                                'tax_query' => array(
                                    array(
                                    'taxonomy' => 'cst_section',
                                    'field' => 'name',
                                    'terms' => 'columnists'
                                    )
                                ),
                                's'                    => $term,
                            );
        $search_query = new WP_Query( $search_args );

        $returning = array();
        $posts = array();

        if ( $search_query->have_posts() ):

                while( $search_query->have_posts() ) : $search_query->the_post();
                    $obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
                    if($obj) {
                        $content_type = str_replace( 'cst_', '', $obj->get_post_type() );
                        $posts['id'] = $obj->get_id();
                        $posts['text'] = $obj->get_title() . ' [' . $content_type . ']';
                        array_push( $returning, $posts );
                    }
                    
                endwhile;
        endif;

        echo json_encode($returning);
        exit();
        
    }

    public function enqueue_scripts() {

        wp_enqueue_script( 'cst-columnists-content-widget', get_template_directory_uri() . '/assets/js/columnists-content-widget.js', array( 'jquery' ) );
        wp_localize_script( 'cst-columnists-content-widget', 'CSTColumnistsContentWidgetData', array(
            'placeholder_text'       => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
            'nonce'                  => wp_create_nonce( 'cst-columnists-content-widget' ),
        ) );
        wp_enqueue_style ( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' );
        wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' );

    }

    public function widget( $args, $instance ) {

        if ( empty( $instance['cst_columnists_story_id'] ) ) {
            return;
        }

        $columnists_story_id    = $instance['cst_columnists_story_id'];
        $obj = \CST\Objects\Post::get_by_post_id( $columnists_story_id );

        if( !$obj) {
            return;
        }
        $primary_section = $obj->get_primary_parent_section();
        ?>
        
        <div class="large-12 medium-6 small-12 widget_cst_columnists_content_widget">
            <h2 class="widgettitle"><?php esc_html_e( 'Today\'s Voice', 'chicagosuntimes' ); ?></h2>
            <?php
                foreach( $obj->get_authors() as $i => $author ) {
	                if ( $author->get_type() === 'guest-author' ) {
		                global $coauthors_plus;
		                $guest_author = $coauthors_plus->get_coauthor_by( 'ID', $author->get_id() );
		                $guest_author_gravatar_html = $coauthors_plus->guest_authors->get_guest_author_thumbnail( $guest_author, 80 );
		                if ( null === $guest_author_gravatar_html ) {
			                echo $author->get_avatar( 80 );
		                } else {
			                echo $guest_author_gravatar_html;
		                }
		                break; // Show only one - the first
	                } else {
		                echo $author->get_avatar( 80 );
		                break; // Show only one - the first
	                }
                }
            ?>
            <div class="columnists-story">
                <?php if( $obj->get_featured_image_html() ) : ?>
                <div class="columnists-story-image <?php echo ( $obj->get_post_type() != 'cst_article' ? 'hover-state' : 'columnists-article' ); ?>">
                    <a href="<?php echo esc_url( $obj->the_permalink() ); ?>">
                        <?php echo $obj->get_featured_image_html( 'chiwire-article' ); ?>
                        <?php if ( $obj->get_post_type() != 'cst_article' ) { ?>
                            <i class="fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
                        <?php } ?>
                    </a>
                </div>
                <?php endif; ?>
                <div class="columnists-story-body">
                <?php if ( $section = $obj->get_primary_section() ) : ?>
                    <span class="section">
                        <a href="<?php echo esc_url( wpcom_vip_get_term_link( $section ) ); ?>"><?php echo esc_html( $section->name ); ?></a> 
                    </span><br/>
                <?php endif; ?>
                    <h3 class="title">
                        <a href="<?php echo $obj->the_permalink(); ?>"><?php echo esc_html_e( $obj->the_title(), 'chicagosuntimes' ); ?></a>
                    </h3>
                </div>
            </div>
        </div>
        <?php

    }

    public function form( $instance ) {

        $this->enqueue_scripts();

        $columnists_story_id = ! empty( $instance['cst_columnists_story_id'] ) ? $instance['cst_columnists_story_id'] : '';
        $obj = \CST\Objects\Post::get_by_post_id( $columnists_story_id );
        if ( $obj ) {
            $content_type = str_replace( 'cst_', '', $obj->get_post_type() );
            $story_title = $obj->get_title() . ' [' . $content_type . ']';
        } else {
            $story_title = '';
        }

        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'cst_columnists_story_id' ) ); ?>">
                    <?php esc_html_e( 'Columnists Content', 'chicagosuntimes' ); ?>:
                </label>
                <input class="cst-columnists-story-id" id="<?php echo esc_attr( $this->get_field_id( 'cst_columnists_story_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_columnists_story_id' ) ); ?>" value="<?php echo esc_attr( $columnists_story_id ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" style="width:400px;" />
            </p>
        <?php
    
    }

    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['cst_columnists_story_id'] = intval( $new_instance['cst_columnists_story_id'] );

        return $instance;

    }

}
