<?php

class CST_Letters_To_Editor_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_letters_to_editor',
            esc_html__( 'CST Letters to the Editor', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display Letters to the Editor image link.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
    ?>
    <li class="letters-to-the-editor-widget">
        <div class="large-12 medium-12 small-12 columns">
            <a href="https://docs.google.com/forms/d/1Z_TpgRWFtrPXFDRoxydLCm39p5MnpMjjC4ZF2x4fB84/viewform" target="_blank">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/letters_to_the_editor.png" alt="Chicago Sun-Times Letters to the Editor" />
            </a>
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