<?php

class CST_Newsletter_Signup_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_ndn_video',
            esc_html__( 'CST Newsletter Signup', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display the Newsletter Sign-Up Link.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <li class="cst_newsletter_signup">
        <div class="large-12 medium-6 small-6 columns">
        <?php
            echo $args['before_title'] . esc_html( 'Newsletter Sign-Up' ) . $args['after_title'];
            get_template_part( 'parts/vendors/dotmailer-newsletter' );
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