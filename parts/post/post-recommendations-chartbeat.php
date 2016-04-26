<?php
if( $obj ) {
    $primary_section = $obj->get_primary_parent_section();
    if( $primary_section ) {
    $feed_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=' . $primary_section->slug . '&all_platforms=1&types=0&limit=4
    ';
    CST()->frontend->cst_post_recommendation_block( $feed_url, $primary_section );
    }
}
?>