<?php

class CST_Social_Follow_Us_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_social_follow_us',
            esc_html__( 'CST Social Links', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display CST Social Network links.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <div class="large-12 medium-6 small-6 social-follow-us">
    <?php
        get_template_part( 'parts/homepage/social-follow-us' );
    ?>
    </div>
    <?php
    }

    public function form( $instance ) {

    }

    public function update( $new_instance, $old_instance ) {

    }

}