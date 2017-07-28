<?php

class CST_TCX_Widget extends WP_Widget {

    protected $tcx_widgets = array(
        'entertainment',
        'money',
        'sports',
        'weather'
        );

    public function __construct() {

        parent::__construct(
            'cst_tcx',
            esc_html__( 'CST TCX', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Display one of the TCX Widgets.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {

        $current_tcx = isset( $instance['tcx_widget'] ) ? $instance['tcx_widget'] : '';
        switch( $current_tcx ) {
            case 'entertainment':
            ?>
                <li class="tcx_entertainment_widget tcx_widget">
                    <div class="large-12 medium-6 small-6">
                    <script src="http://content.synapsys.us/embeds/placement.js?p=VSUE4YV38U&amp;type=dynamic_group_entertainment&amp;style=standard"></script>
                    </div>
                </li>
            <?php
                break;

              case 'money':
            ?>
                <li class="tcx_money_widget tcx_widget">
                    <div class="large-12 medium-6 small-6">
                    <script src="http://content.synapsys.us/embeds/placement.js?p=VSUE4YV38U&amp;type=dynamic_group_money&amp;style=standard"></script>
                    </div>
                </li>
            <?php
                break;

            case 'sports':
            ?>
                <li class="tcx_sports_widget tcx_widget">
                    <div class="large-12 medium-6 small-6">
                    <script src="http://content.synapsys.us/embeds/placement.js?p=VSUE4YV38U&amp;type=dynamic_group_sports&amp;style=standard"></script>
                    </div>
                </li>
            <?php
                break;

            case 'weather':
            ?>
                <li class="tcx_weather_widget tcx_widget">
                    <div class="large-12 medium-6 small-6">
                    <script src="http://content.synapsys.us/embeds/placement.js?p=VSUE4YV38U&amp;type=dynamic_group_weather&amp;style=standard"></script>
                    </div>
                </li>
            <?php
                break;

            default:
                break;
        }
    
    }

    public function form( $instance ) {

        $current_tcx = isset( $instance['tcx_widget'] ) ? $instance['tcx_widget'] : '';
    ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'tcx_widget' ) ); ?>"><?php esc_html_e( 'TCX Widget', 'chicagosuntimes' ); ?>:</label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tcx_widget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tcx_widget' ) ); ?>" data-current-unit="<?php echo esc_attr( $current_tcx ); ?>">
            <?php foreach( $this->tcx_widgets as $tcx_widget ) : ?>
                <option value="<?php echo esc_attr( $tcx_widget ); ?>" <?php selected( $tcx_widget, $current_tcx ); ?>><?php echo esc_html( $tcx_widget ); ?></option>
            <?php endforeach; ?>
            </select>
        </p>

    <?php

    }

    public function update( $new_instance, $old_instance ) {
        
        $instance = array();

        if ( in_array( $new_instance['tcx_widget'], $this->tcx_widgets ) ) {
            $instance['tcx_widget'] = $new_instance['tcx_widget'];
        }

        return $instance;

    }

}