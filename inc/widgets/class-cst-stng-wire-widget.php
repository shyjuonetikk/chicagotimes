<?php

class CST_STNG_Wire_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'CST_STNG_Wire_Widget',
            esc_html__( 'CST STNG Wire', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Displays The STNG Wire\'s recent posts.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {
        $feed_url = $instance['cst_stng_wire_feed_url'];
        if( empty( $feed_url ) ) {
            $feed_url = 'http://www.suntimeswire.com/feed';
        }
    ?>
        <div class="large-12 medium-12 small-12 columns widget_cst_stng_wire_widget">
            <h2 class="widgettitle"><?php echo esc_html_e( 'Wire Updates', 'chicagosuntimes' ); ?></h2>
            <ul class="widget-stng-wire-posts">
              <?php
                $stng_items = CST()->frontend->cst_homepage_fetch_feed( $feed_url, 10 );
                  if( count( $stng_items ) > 0 ) :
                      foreach( $stng_items as $stng_item ) {
                        ?>
                        <li>
                        <strong><?php echo human_time_diff( strtotime( $stng_item->get_date('j F Y g:i a') ) ); ?></strong>
                            <a href="<?php echo esc_url( $stng_item->get_permalink() ); ?>"
                                title="<?php printf( __( 'Posted %s', 'cst-homepage' ), $stng_item->get_date('j F Y | g:i a') ); ?>">
                                <?php echo esc_html( $stng_item->get_title() ); ?>
                            </a>
                            <em><?php echo esc_html_e( 'STNG Wire', 'chicagosuntimes' ); ?></em>
                        </li>
                      <?php 
                      }
                  endif;
              ?>
            </ul>
        </div>
    <?php
    }

    public function form( $instance ) {
        $instance = $instance;

        $feed_url = $instance['cst_stng_wire_feed_url'];
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cst_stng_wire_feed_url' ) ); ?>"><?php esc_html_e( 'Feed URL:', 'chicagosuntimes' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cst_stng_wire_feed_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cst_stng_wire_feed_url' ) ); ?>" type="text" value="<?php echo esc_attr( $feed_url ); ?>" />
    <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['cst_stng_wire_feed_url'] = sanitize_text_field( $new_instance['cst_stng_wire_feed_url'] );
        return $instance;

    }

}