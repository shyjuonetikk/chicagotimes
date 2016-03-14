<?php

class CST_Search_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_search',
            esc_html__( 'CST Search', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display CST Search.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <div class="large-12 medium-6 small-12 columns social-follow-us">
    <?php
        if( is_front_page() ) :
            get_template_part( 'parts/homepage/social-follow-us' );
        else :
            get_template_part( 'parts/sidebar/search-widget' );
        endif;
    ?>
    </div>
    <?php
    }

    public function form( $instance ) {

    }

    public function update( $new_instance, $old_instance ) {

    }

}