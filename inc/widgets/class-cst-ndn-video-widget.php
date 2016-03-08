<?php

class CST_NDN_Video_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_ndn_video',
            esc_html__( 'CST NDN Video', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display the NDN Video.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <li class="ndn_embed">
        <div class="large-12 medium-6 small-6 columns">
        <?php
            get_template_part( 'parts/vendors/ndn-video-embed' );
        ?>
        </div>
    </li>
    <?php
    }

    public function form( $instance ) {

    }

    public function update( $new_instance, $old_instance ) {
        $new_instance = $old_instance;
    }

}