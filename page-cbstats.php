<?php
/*
 * Template Name: Chartbeat Stats API Page
 */
@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
$feed_url  = 'http://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=news,%20sports,%20entertainment,%20lifestyles,%20columnists,%20politics&all_platforms=1&types=0&limit=5
';
$cache_key = md5( $feed_url );
$result    = wp_cache_get( $cache_key, 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
if ( false === $result ) {
	$response = wpcom_vip_file_get_contents( $feed_url );
	if ( ! is_wp_error( $response ) ) {
		$result = json_decode( $response );
		wp_cache_set( $cache_key, $result, 'default', 5 * MINUTE_IN_SECONDS );
	}
}
echo( $return );
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	wp_die();
} else {
	die;
}
