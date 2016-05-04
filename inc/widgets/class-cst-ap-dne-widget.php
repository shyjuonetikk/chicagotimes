<?php

class CST_AP_DNE_Widget extends WP_Widget {

    protected $dne_widgets = array(
        'ap-ncaa-news-widget',
        'ap-ncaa-scoreboard-widget',
        'ap-summer-games-news-widget',
        'ap-summer-games-medal-count-widget',
        'ap-summer-games-event-schedule-widget',
        'ap-us-election-news-widget'
        );

    public function __construct() {

        parent::__construct(
            'cst_ap_dne',
            esc_html__( 'CST AP DNE', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display one of the AP DNE Widgets.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {

        $current_dne = isset( $instance['dne_widget'] ) ? $instance['dne_widget'] : '';
        switch( $current_dne ) {
            case 'ap-ncaa-news-widget':
            ?>
                <li class="ap_ncaa_cbb_news_widget">
                    <div class="large-12 medium-6 small-6 columns">
                    <?php
                        get_template_part( 'parts/vendors/ap-ncaa-cbb-news-widget' );
                    ?>
                    </div>
                </li>
            <?php
                break;
            case 'ap-ncaa-scoreboard-widget':
            ?>
                <li class="ap_ncaa_cbb_scoreboard_widget">
                    <div class="large-12 medium-6 small-6 columns">
                    <?php
                        get_template_part( 'parts/vendors/ap-ncaa-cbb-scoreboard-widget' );
                    ?>
                    </div>
                </li>
            <?php
                break;
            case 'ap-summer-games-news-widget':
            ?>
                <li class="ap_ncaa_cbb_scoreboard_widget">
                    <div class="large-12 medium-6 small-6 columns">
                    <?php
                        get_template_part( 'parts/vendors/ap-summer-games-news-widget' );
                    ?>
                    </div>
                </li>
            <?php
                break;
            case 'ap-summer-games-medal-count-widget':
            ?>
                <li class="ap_ncaa_cbb_scoreboard_widget">
                    <div class="large-12 medium-6 small-6 columns">
                    <?php
                        get_template_part( 'parts/vendors/ap-summer-games-news-widget' );
                    ?>
                    </div>
                </li>
            <?php
                break;
            case 'ap-summer-games-event-schedule-widget':
            ?>
                <li class="ap_ncaa_cbb_scoreboard_widget">
                    <div class="large-12 medium-6 small-6 columns">
                    <?php
                        get_template_part( 'parts/vendors/ap-summer-games-news-widget' );
                    ?>
                    </div>
                </li>
            <?php
                break;
            case 'ap-us-election-news-widget':
            ?>
                <li class="ap_ncaa_cbb_scoreboard_widget">
                    <div class="large-12 medium-6 small-6 columns">
                    <?php
                        get_template_part( 'parts/vendors/ap-us-election-news-widget' );
                    ?>
                    </div>
                </li>
            <?php
                break;

            default:
                break;
        }
    
    }

    public function form( $instance ) {

        $current_dne = isset( $instance['dne_widget'] ) ? $instance['dne_widget'] : '';
    ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'dne_widget' ) ); ?>"><?php esc_html_e( 'DNE Widget', 'chicagosuntimes' ); ?>:</label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dne_widget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dne_widget' ) ); ?>" data-current-unit="<?php echo esc_attr( $current_dne ); ?>">
            <?php foreach( $this->dne_widgets as $dne_widget ) : ?>
                <option value="<?php echo esc_attr( $dne_widget ); ?>" <?php selected( $dne_widget, $current_dne ); ?>><?php echo esc_html( $dne_widget ); ?></option>
            <?php endforeach; ?>
            </select>
        </p>

    <?php

    }

    public function update( $new_instance, $old_instance ) {
        
        $instance = array();

        if ( in_array( $new_instance['dne_widget'], $this->dne_widgets ) ) {
            $instance['dne_widget'] = $new_instance['dne_widget'];
        }

        return $instance;

    }

}