<?php

class CST_AP_NCAA_Scoreboard_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_ap_ncaa_scoreboard',
            esc_html__( 'CST AP NCAA Scoreboard', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display the NCAA CBB Scoreboard.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <li class="ap_ncaa_cbb_scoreboard_widget">
        <div class="large-12 medium-6 small-6 columns">
        <?php
            get_template_part( 'parts/vendors/ap-ncaa-cbb-scoreboard-widget' );
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