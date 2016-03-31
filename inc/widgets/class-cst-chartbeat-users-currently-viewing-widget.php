<?php

class CST_Chartbeat_Currently_Viewing_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'cst_chartbeat_currently_viewing',
            esc_html__( 'CST Chartbeat Users Currently Viewing', 'chicagosuntimes' ),
            array(
                'description' => esc_html__( 'Displays Content Currently Viewed by Users.', 'chicagosuntimes' ),
            )
        );

    }

    public function widget( $args, $instance ) {

        echo $args['before_widget'];

        echo $args['before_title'] . esc_html( 'Currently Trending' ) . $args['after_title'];

        $feed_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=news,%20sports,%20entertainment,%20lifestyles,%20columnists,%20politics&all_platforms=1&types=0&limit=5
';
        $cache_key = md5( $feed_url );
        $result = wp_cache_get( $cache_key, 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
        if ( $result === false ) {
            $response = wpcom_vip_file_get_contents( $feed_url );
            if ( ! is_wp_error( $response ) ) {
                $result = json_decode( $response );
                wp_cache_set( $cache_key, $result, 'default', 5 * MINUTE_IN_SECONDS );
            }
        }
        ?>
        <ul class="widget-chartbeat-currently-viewing">
        <?php foreach( $result->pages as $item ) { ?>
            <li>
                <a href="<?php echo esc_url( $item->path ); ?>">
                <span class='section'><?php echo esc_html( $item->sections[0] ) ?></span><br/>
                <span class='title'><?php echo esc_html( $item->title ); ?></span>
                </a>
            </li>
        <?php } ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {

    }

    public function update( $new_instance, $old_instance ) {

    }

}