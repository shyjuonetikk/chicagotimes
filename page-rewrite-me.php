<?php
	/*
	 * Template Name: Rewrite Me
	 */

$where_to = get_query_var( 'where' );
if ( $where_to && '' !== $where_to ) {
	switch ( sanitize_text_field( $where_to ) ) {
		case 'analytics.txt':
			echo 'GooGhywoiu9839t543j0s7543uw1 - pls add mwatson@suntimes.com to GA account UA-55799047-3 with ‘Manage Users and Edit’ permissions - date September 28, 2017.';
			die( 200 );
			break;
		case 'googleddb5b02478e7d794.html':
			echo 'google-site-verification: googleddb5b02478e7d794.html';
			die( 200 );
			break;
		default:
			break;
	}
}
