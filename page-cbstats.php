<?php
/*
 * Template Name: Chartbeat Stats API Page
 */
@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
$cb_api_url  = 'http://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=chicago%20news,sports,politics&exclude_people=5&sort_by=engaged_time&loyalty=1&types=1&metrics=post_id';
$cache_key = md5( $cb_api_url );
$result    = wp_cache_get( $cache_key, 'default' );
if ( false === $result ) {
	$response = wpcom_vip_file_get_contents( $cb_api_url );
	if ( ! is_wp_error( $response ) ) {
		$result = json_decode( $response );
		wp_cache_set( $cache_key, $result, 'default', 1 * MINUTE_IN_SECONDS );
	}
}
echo( wp_json_encode( $result ) );
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	wp_die();
} else {
	die;
}
