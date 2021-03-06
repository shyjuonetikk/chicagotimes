<?php

class CST_Bears_Cube_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_bears_cube_widget',
            esc_html__( 'CST Homepage Bears Cube News', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Set Bears article displayed in the header.', 'chicagosuntimes' ),
            )
        );

        add_action( 'wp_ajax_cst_bears_cube_get_posts', array( $this, 'cst_bears_cube_get_posts' ) );
        
    }

    /**
    * Get all published posts to display in Select2 dropdown
    */
    public function cst_bears_cube_get_posts() {

        if ( ! wp_verify_nonce( $_GET['nonce'], 'cst-bears-cube-widget' )
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

        wp_enqueue_script( 'cst-bears-cube-widget', get_template_directory_uri() . '/assets/js/cst-bears-cube-widget.js', array( 'jquery' ) );
        wp_localize_script( 'cst-bears-cube-widget', 'CSTBearsCubeWidgetData', array(
            'placeholder_text'       => esc_html__( 'Search for content to feature', 'chicagosuntimes' ),
            'nonce'                  => wp_create_nonce( 'cst-bears-cube-widget' ),
        ) );
        wp_enqueue_style ( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.css' );
        wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/vendor/select2/select2.min.js' );

    }

    public function widget( $args, $instance ) {

        if ( empty( $instance['cst_bears_cube_story_id'] ) ) {
            return;
        }

        $bears_cube_story_id    = $instance['cst_bears_cube_story_id'];
        $title = ! empty( $instance['cst_bears_cube_title'] ) ? $instance['cst_bears_cube_title'] : '';
        $obj = \CST\Objects\Post::get_by_post_id( $bears_cube_story_id );

        $section_bg_class = 'sports_bg';
        if( ! $obj) {
            return;
        } else {
            if ( $section = $obj->get_primary_section() ) :
                $primary_section = $section->slug;
            else :
                $primary_section = 'news';
            endif;

            $post_section = $obj->get_primary_parent_section();
            if( ! $post_section ) {
                $post_section = $obj->get_child_parent_section();
                if( ! in_array( $post_section, CST_Frontend::$post_sections ) ) {
                    $post_section = $obj->get_grandchild_parent_section();
                }
            }

            switch( $post_section->slug ) {
                case 'news':
                    $section_bg_class = 'news_bg';
                    break;
                case 'entertainment':
                    $section_bg_class = 'entertainment_bg';
                    break;
                case 'sports':
                    $section_bg_class = 'sports_bg';
                    break;
                case 'politics':
                    $section_bg_class = 'politics_bg';
                    break;
                case 'lifestyles':
                    $section_bg_class = 'lifestyles_bg';
                    break;
                case 'opinion':
                    $section_bg_class = 'opinion_bg';
                    break;
                default:
                    break;
            }
        }
        ?>
        

        <div class="bears-cube-story <?php echo esc_html( $section_bg_class ); ?>">
            <h3 class="title">
                <span><i class="fa fa-times-circle-o close-bears-cube"></i> <?php echo esc_html_e( $title, 'chicagosuntimes' ); ?></span> <a href="<?php echo $obj->the_permalink(); ?>"><?php echo esc_html( $obj->the_title() ); ?></a>
                    <?php echo ! empty( $post_section ) ? '<span>&mdash; (' . $post_section->name . ')</span>' : ''; ?>
            </h3>
        </div>

        <?php

    }

    public function form( $instance ) {

        $this->enqueue_scripts();

        $title = ! empty( $instance['cst_bears_cube_title'] ) ? $instance['cst_bears_cube_title'] : '';
        $bears_cube_story_id = ! empty( $instance['cst_bears_cube_story_id'] ) ? $instance['cst_bears_cube_story_id'] : '';
        $obj = \CST\Objects\Post::get_by_post_id( $bears_cube_story_id );
        if ( $obj ) {
            $content_type = str_replace( 'cst_', '', $obj->get_post_type() );
            $story_title = $obj->get_title() . ' [' . $content_type . ']';
        } else {
            $story_title = '';
        }

        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'cst_bears_cube_title' ) ); ?>"><?php esc_html_e( 'Title:', 'chicagosuntimes' ); ?></label> 
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_bears_cube_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_bears_cube_title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
                <label for="<?php echo esc_attr( $this->get_field_id( 'cst_bears_cube_story_id' ) ); ?>">
                    <?php esc_html_e( 'Bears Cube Content', 'chicagosuntimes' ); ?>:
                </label>
                <input class="cst-bears-cube-story-id" id="<?php echo esc_attr( $this->get_field_id( 'cst_bears_cube_story_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_bears_cube_story_id' ) ); ?>" value="<?php echo esc_attr( $bears_cube_story_id ); ?>" data-story-title="<?php echo esc_attr( $story_title ); ?>" />
            </p>
        <?php
    
    }

    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['cst_bears_cube_title']    = sanitize_text_field( $new_instance['cst_bears_cube_title'] );
        $instance['cst_bears_cube_story_id'] = intval( $new_instance['cst_bears_cube_story_id'] );

        return $instance;

    }

}