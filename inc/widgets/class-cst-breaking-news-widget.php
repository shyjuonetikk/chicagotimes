<?php

class CST_Breaking_News_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_breaking_news_widget',
            esc_html__( 'CST Homepage Breaking News', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Set Breaking News displayed in the header.', 'chicagosuntimes' ),
            )
        );

        add_action( 'wp_ajax_cst_breaking_news_get_posts', array( $this, 'cst_breaking_news_get_posts' ) );
        
    }

    /**
    * Get all published posts to display in Select2 dropdown
    */
    public function cst_breaking_news_get_posts() {

        if ( ! wp_verify_nonce( $_GET['nonce'], 'cst-breaking-news-widget' )
            || ! current_user_can( 'edit_others_posts' ) ) {
            wp_send_json_error();
        }

        $term = sanitize_text_field( $_GET['searchTerm'] );

        $search_args = array(
                                'post_type'            => CST()->get_post_types(),
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

        wp_enqueue_script( 'cst-breaking-news-widget', get_template_directory_uri() . '/assets/js/cst-breaking-news-widget.js', array( 'jquery' ) );
        wp_localize_script( 'cst-breaking-news-widget', 'CSTBreakingNewsWidgetData', array(
            'placeholder_text'       => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
            'nonce'                  => wp_create_nonce( 'cst-breaking-news-widget' ),
        ) );
        wp_enqueue_style ( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' );
        wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' );

    }

    public function widget( $args, $instance ) {

        if ( empty( $instance['cst_breaking_news_story_id'] ) ) {
            return;
        }

        $breaking_news_story_id    = $instance['cst_breaking_news_story_id'];
        $obj = \CST\Objects\Post::get_by_post_id( $breaking_news_story_id );

        if( !$obj) {
            return;
        }
        ?>
        

        <div class="breaking-news-story">
            <h3 class="title">
                <span><i class="fa fa-times-circle-o close-breaking-news"></i> <?php echo esc_html_e( 'Breaking News...', 'chicagosuntimes' ); ?></span> <a href="<?php echo $obj->the_permalink(); ?>"><?php echo esc_html( $obj->the_title() ); ?></a>
            </h3>
        </div>

        <?php

    }

    public function form( $instance ) {

        $this->enqueue_scripts();

        $breaking_news_story_id = ! empty( $instance['cst_breaking_news_story_id'] ) ? $instance['cst_breaking_news_story_id'] : '';
        $obj = \CST\Objects\Post::get_by_post_id( $breaking_news_story_id );
        if ( $obj ) {
            $content_type = str_replace( 'cst_', '', $obj->get_post_type() );
            $story_title = $obj->get_title() . ' [' . $content_type . ']';
        } else {
            $story_title = '';
        }

        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_news_story_id' ) ); ?>">
                    <?php esc_html_e( 'Breaking News Content', 'chicagosuntimes' ); ?>:
                </label>
                <input class="cst-breaking-news-story-id" id="<?php echo esc_attr( $this->get_field_id( 'cst_breaking_news_story_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_breaking_news_story_id' ) ); ?>" value="<?php echo esc_attr( $breaking_news_story_id ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" />
            </p>
        <?php
    
    }

    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['cst_breaking_news_story_id'] = intval( $new_instance['cst_breaking_news_story_id'] );

        return $instance;

    }

}
