<?php
/*
 * Template Name: ChartBeat API page
 */
/**
 * Poll Chartbeat every two minutes, cache result
 * This page is intended to be called by our JS typically on the homepage
 * Can we perhaps use a nonce to prevent abuse?
 */
$chartbeat_result_type = get_theme_mod( 'chartbeat_config' );
switch ( $chartbeat_result_type ) {
	case 1 :
		// Concurrents (default Chartbeat)
		$chartbeat_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=fe619e0e0b2a7b2742c6a97e14fb2eb8&host=chicago.suntimes.com&section=chicago%20news,sports,politics,business,sun-times%20wire,opinion,crime,the%20watchdogs,baseball,football,basketball,hockey&metrics=post_id&limit=6';
		break;
	case 2 :
		// Returning time
		$chartbeat_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=fe619e0e0b2a7b2742c6a97e14fb2eb8&host=chicago.suntimes.com&section=chicago%20news,sports,politics,business,sun-times%20wire,opinion,crime,the%20watchdogs,baseball,football,basketball,hockey&metrics=post_id&sort_by=returning&limit=6';
		break;
	case 3 :
		// Engaged time
		$chartbeat_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=fe619e0e0b2a7b2742c6a97e14fb2eb8&host=chicago.suntimes.com&section=chicago%20news,sports,politics,business,sun-times%20wire,opinion,crime,the%20watchdogs,baseball,football,basketball,hockey&metrics=post_id&sort_by=engaged_time&limit=6';
		break;
	default:
		// Concurrents - default if theme mod not available.
		$chartbeat_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=fe619e0e0b2a7b2742c6a97e14fb2eb8&host=chicago.suntimes.com&section=chicago%20news,sports,politics,business,sun-times%20wire,opinion,crime,the%20watchdogs,baseball,football,basketball,hockey&metrics=post_id&limit=6';
}
$cache_key = md5( $chartbeat_url );
$chartbeat_data = wpcom_vip_cache_get( $cache_key, 'cst' );
$result    = wpcom_vip_cache_get( $cache_key, 'default' );
if ( false === $result ) {
	$response = wpcom_vip_file_get_contents( $chartbeat_url );
	if ( ! is_wp_error( $response ) ) {
		$result = json_decode( $response );
		wpcom_vip_cache_set( $cache_key, $result, 'cst', 1 * MINUTE_IN_SECONDS );
	}
}
if ( ! empty( $result->pages ) ) {
header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
echo json_encode( $result );
}
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	wp_die();
} else {
	die;
}