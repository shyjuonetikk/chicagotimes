<?php

class CST_Homepage_NDN_Video_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_homepage_ndn_video',
            esc_html__( 'CST Homepage NDN Video', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display the Homepage NDN Video.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <div class="large-12 medium-6 small-12 columns homepage-no-padding">
        <?php
            get_template_part( 'parts/dfp/homepage/ndn-video' );
        ?>
    </div>
    <?php
    }

    public function form( $instance ) {

    }

    public function update( $new_instance, $old_instance ) {
        $new_instance = $old_instance;
    }

}