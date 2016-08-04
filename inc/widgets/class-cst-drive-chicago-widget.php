<?php

class CST_Drive_Chicago_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_drive_chicago',
            esc_html__( 'CST Drive Chicago', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display the Drive Chicago Ad.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <li class="drive_chicago">
        <div class="row">
            <div class="large-12 medium-6 small-6 columns">
            <?php
                get_template_part( 'parts/vendors/drive-chicago' );
            ?>
            </div>
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